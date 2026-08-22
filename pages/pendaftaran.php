<?php
// ============================================================
// PENDAFTARAN ONLINE — SIPP UPTD PUSKESMAS IPUH
// ============================================================
require_once '../includes/functions.php';

$activePage = 'pendaftaran';
$poli       = getAllPoli();
$poliAktif  = array_filter($poli, fn($p) => $p['status'] === 'Buka');

// Pre-select poli dari URL
$prePoliId  = isset($_GET['poli']) ? (int)$_GET['poli'] : 0;

// Hitung kuota hari ini untuk notifikasi
$today = date('Y-m-d');
$pageTitle = 'Pendaftaran Online SIPP UPTD Puskesmas Ipuh';
$metaDesc = 'Pendaftaran online poli UPTD Puskesmas Ipuh Daftar antrian tanpa perlu antri di tempat.';
$extraHead = <<<HTML
  <style>
    .form-section {
      background: var(--clr-white);
      border-radius: var(--radius-xl);
      box-shadow: var(--shadow-lg);
      border: 1px solid var(--clr-gray-100);
      overflow: hidden;
    }
    .form-section-header {
      background: linear-gradient(135deg, var(--clr-primary) 0%, var(--clr-secondary) 100%);
      padding: 1.5rem 2rem;
      color: white;
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .form-section-icon {
      width: 48px; height: 48px;
      border-radius: var(--radius-md);
      background: rgba(255,255,255,0.2);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.25rem;
    }
    .form-section-title { font-family: var(--font-heading); font-size: 1.2rem; font-weight: 700; }
    .form-section-sub   { font-size: 0.85rem; color: rgba(255,255,255,0.75); }
    .form-body { padding: 2rem; }

    /* Poli Selector Cards */
    .poli-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 0.85rem;
    }
    .poli-select-card { cursor: pointer; }
    .poli-select-card input { display: none; }
    .poli-select-label {
      display: flex;
      flex-direction: column;
      gap: 6px;
      padding: 1rem;
      border: 2px solid var(--clr-gray-200);
      border-radius: var(--radius-lg);
      cursor: pointer;
      transition: all var(--transition-fast);
    }
    .poli-select-card input:checked + .poli-select-label {
      border-color: var(--clr-accent);
      background: rgba(76,175,130,0.08);
    }
    .poli-select-label:hover { border-color: var(--clr-accent); }
    .poli-select-name { font-weight: 600; font-size: 0.875rem; color: var(--clr-primary); }
    .poli-select-dokter { font-size: 0.775rem; color: var(--clr-gray-500); }
    .poli-select-status { font-size: 0.75rem; font-weight: 600; }

    /* Sesi cards */
    .sesi-group { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .sesi-card input { display: none; }
    .sesi-label {
      display: flex; align-items: center; gap: 12px;
      padding: 1rem 1.25rem;
      border: 2px solid var(--clr-gray-200);
      border-radius: var(--radius-lg);
      cursor: pointer;
      transition: all var(--transition-fast);
    }
    .sesi-card input:checked + .sesi-label {
      border-color: var(--clr-accent);
      background: rgba(76,175,130,0.08);
    }
    .sesi-label:hover { border-color: var(--clr-accent); }
    .sesi-icon { width: 40px; height: 40px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .sesi-info { flex: 1; }
    .sesi-name { font-weight: 600; font-size: 0.9rem; color: var(--clr-primary); }
    .sesi-time { font-size: 0.775rem; color: var(--clr-gray-500); }
    .sesi-quota { font-size: 0.75rem; font-weight: 600; color: var(--clr-accent); margin-top: 2px; }

    /* Step Panels */
    .form-step { display: none; }
    .form-step.active { display: block; animation: fadeIn 0.3s ease; }

    /* Form navigation */
    .form-nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1.5rem;
      border-top: 1px solid var(--clr-gray-100);
      margin-top: 2rem;
    }
  </style>
HTML;
include '../includes/header.php';
?>

<?php include '../includes/navbar.php'; ?>

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
      <span>/</span>
      <span>Pendaftaran Online</span>
    </nav>
    <div class="page-header-content">
      <h1><i class="fas fa-clipboard-list" style="margin-right:0.5rem;opacity:0.8;"></i> Pendaftaran Online</h1>
      <p>Daftar antrian poli tanpa perlu datang cepat, mudah, dan hemat waktu</p>
    </div>
  </div>
</div>

<main class="section">
  <div class="container" style="max-width:860px;">

    <!-- Steps Indicator -->
    <div class="steps" id="stepIndicator" aria-label="Langkah pendaftaran">
      <div class="step active" id="step-ind-1">
        <div class="step-num">1</div>
        <div class="step-label">Data Diri</div>
      </div>
      <div class="step" id="step-ind-2">
        <div class="step-num">2</div>
        <div class="step-label">Pilih Poli</div>
      </div>
      <div class="step" id="step-ind-3">
        <div class="step-num">3</div>
        <div class="step-label">Jadwal</div>
      </div>
      <div class="step" id="step-ind-4">
        <div class="step-num">4</div>
        <div class="step-label">Konfirmasi</div>
      </div>
    </div>

    <!-- Alert info -->
    <div class="alert alert-info" style="margin-bottom:1.5rem;">
      <i class="fas fa-info-circle"></i>
      <div>
        <strong>Informasi Pendaftaran:</strong> Pendaftaran online dibuka setiap hari kerja (Senin–Jumat) mulai pukul 07.00 WIB.
        Nomor antrian berlaku untuk tanggal kunjungan yang dipilih. Harap hadir 15 menit sebelum jadwal.
      </div>
    </div>

    <!-- Form -->
    <form id="pendaftaranForm" action="../process/process_pendaftaran.php" method="POST" novalidate>
      <input type="hidden" name="csrf_token" value="<?= bin2hex(random_bytes(16)) ?>">

      <!-- ======== STEP 1: DATA DIRI ======== -->
      <div class="form-step active" id="form-step-1">
        <div class="form-section">
          <div class="form-section-header">
            <div class="form-section-icon"><i class="fas fa-user"></i></div>
            <div>
              <div class="form-section-title">Data Diri Pasien</div>
              <div class="form-section-sub">Isi data diri Anda dengan lengkap dan benar</div>
            </div>
          </div>
          <div class="form-body">
            <!-- Jenis Pasien -->
            <div class="form-group">
              <label class="form-label">Jenis Pasien <span class="required">*</span></label>
              <div class="radio-group">
                <div class="radio-card">
                  <input type="radio" name="jenis_pasien" id="pasien_baru" value="Baru" checked>
                  <label for="pasien_baru"><i class="fas fa-user-plus" style="color:var(--clr-accent);"></i> Pasien Baru</label>
                </div>
                <div class="radio-card">
                  <input type="radio" name="jenis_pasien" id="pasien_lama" value="Lama">
                  <label for="pasien_lama"><i class="fas fa-user-check" style="color:var(--clr-accent);"></i> Pasien Lama</label>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="nik" class="form-label">NIK (16 Digit) <span class="required">*</span></label>
                <input type="text" id="nik" name="nik" class="form-control"
                       placeholder="Contoh: 1707xxxxxxxxx" maxlength="16"
                       inputmode="numeric" pattern="\d{16}" required>
                <span class="form-hint">Nomor Induk Kependudukan sesuai KTP</span>
                <span class="form-error" id="nik-error">NIK harus 16 digit angka</span>
              </div>
              <div class="form-group">
                <label for="nama" class="form-label">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="nama" name="nama" class="form-control"
                       placeholder="Sesuai KTP" required>
                <span class="form-error" id="nama-error">Nama tidak boleh kosong</span>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir <span class="required">*</span></label>
                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control"
                       max="<?= date('Y-m-d') ?>" required>
              </div>
              <div class="form-group">
                <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                <div class="radio-group">
                  <div class="radio-card" style="min-width:0;">
                    <input type="radio" name="jenis_kelamin" id="jk_l" value="L" checked>
                    <label for="jk_l"><i class="fas fa-mars" style="color:#0284C7;"></i> Laki-laki</label>
                  </div>
                  <div class="radio-card" style="min-width:0;">
                    <input type="radio" name="jenis_kelamin" id="jk_p" value="P">
                    <label for="jk_p"><i class="fas fa-venus" style="color:#E879A0;"></i> Perempuan</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="no_hp" class="form-label">Nomor HP / WhatsApp <span class="required">*</span></label>
                <input type="tel" id="no_hp" name="no_hp" class="form-control"
                       placeholder="Contoh: 081234567890" required>
                <span class="form-error" id="hp-error">Nomor HP tidak valid</span>
              </div>
              <div class="form-group">
                <label for="jenis_kartu" class="form-label">Jenis Kartu <span class="required">*</span></label>
                <select id="jenis_kartu" name="jenis_kartu" class="form-control" required>
                  <option value="">-- Pilih Jenis Kartu --</option>
                  <option value="Umum">Umum / Bayar Mandiri</option>
                  <option value="BPJS">BPJS Kesehatan</option>
                  <option value="KIS">KIS (Kartu Indonesia Sehat)</option>
                  <option value="Askes">Askes / ASABRI</option>
                </select>
              </div>
            </div>

            <div class="form-row" id="noKartuGroup" style="display:none;">
              <div class="form-group" style="grid-column: 1 / -1;">
                <label for="no_kartu" class="form-label">Nomor BPJS / Kartu</label>
                <input type="text" id="no_kartu" name="no_kartu" class="form-control"
                       placeholder="Masukkan nomor kartu jaminan">
              </div>
            </div>

            <div class="form-group">
              <label for="alamat" class="form-label">Alamat Lengkap <span class="required">*</span></label>
              <textarea id="alamat" name="alamat" class="form-control" rows="3"
                        placeholder="Nama jalan, RT/RW, Desa, Kecamatan" required></textarea>
            </div>
          </div>
        </div>
        <div class="form-nav">
          <span></span>
          <button type="button" class="btn btn-primary" id="next1Btn">
            Lanjut <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      </div>

      <!-- ======== STEP 2: PILIH POLI ======== -->
      <div class="form-step" id="form-step-2">
        <div class="form-section">
          <div class="form-section-header">
            <div class="form-section-icon"><i class="fas fa-hospital-user"></i></div>
            <div>
              <div class="form-section-title">Pilih Poli / Layanan</div>
              <div class="form-section-sub">Pilih poli yang sesuai dengan kebutuhan Anda</div>
            </div>
          </div>
          <div class="form-body">
            <div class="poli-grid" id="poliGrid">
              <?php foreach ($poliAktif as $p): ?>
              <div class="poli-select-card">
                <input type="radio" name="poli_id" id="poli_<?= $p['id'] ?>"
                       value="<?= $p['id'] ?>"
                       <?= $prePoliId === $p['id'] ? 'checked' : '' ?>>
                <label for="poli_<?= $p['id'] ?>" class="poli-select-label">
                  <span class="poli-select-name">
                    <i class="fas fa-stethoscope" style="color:var(--clr-accent);margin-right:6px;"></i>
                    <?= htmlspecialchars($p['nama_poli']) ?>
                  </span>
                  <?php if ($p['dokter_jaga']): ?>
                  <span class="poli-select-dokter">
                    <i class="fas fa-user-md" style="font-size:0.7rem;margin-right:4px;"></i>
                    <?= htmlspecialchars($p['dokter_jaga']) ?>
                  </span>
                  <?php endif; ?>
                  <span class="poli-select-status badge badge-dot badge-success">Buka</span>
                </label>
              </div>
              <?php endforeach; ?>
            </div>
            <span class="form-error" id="poli-error" style="display:none;">Pilih poli terlebih dahulu</span>

            <div class="form-group" style="margin-top:1.5rem;">
              <label for="keluhan" class="form-label">Keluhan Utama <span style="color:var(--clr-gray-400);font-weight:400;">(opsional)</span></label>
              <textarea id="keluhan" name="keluhan" class="form-control" rows="3"
                        placeholder="Ceritakan keluhan yang Anda rasakan..."></textarea>
            </div>
          </div>
        </div>
        <div class="form-nav">
          <button type="button" class="btn btn-outline" id="prev2Btn">
            <i class="fas fa-arrow-left"></i> Kembali
          </button>
          <button type="button" class="btn btn-primary" id="next2Btn">
            Lanjut <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      </div>

      <!-- ======== STEP 3: JADWAL ======== -->
      <div class="form-step" id="form-step-3">
        <div class="form-section">
          <div class="form-section-header">
            <div class="form-section-icon"><i class="fas fa-calendar-alt"></i></div>
            <div>
              <div class="form-section-title">Pilih Jadwal Kunjungan</div>
              <div class="form-section-sub">Tentukan tanggal dan sesi kunjungan Anda</div>
            </div>
          </div>
          <div class="form-body">
            <div class="form-row">
              <div class="form-group">
                <label for="tgl_kunjungan" class="form-label">Tanggal Kunjungan <span class="required">*</span></label>
                <input type="date" id="tgl_kunjungan" name="tgl_kunjungan" class="form-control"
                       min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                       max="<?= date('Y-m-d', strtotime('+14 days')) ?>"
                       required>
                <span class="form-hint">Pendaftaran untuk 1–14 hari ke depan (hari kerja)</span>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Pilih Sesi <span class="required">*</span></label>
              <div class="sesi-group">
                <div class="sesi-card">
                  <input type="radio" name="sesi" id="sesi_pagi" value="Pagi" checked>
                  <label for="sesi_pagi" class="sesi-label">
                    <div class="sesi-icon" style="background:rgba(251,191,36,0.15);color:#D97706;">
                      <i class="fas fa-sun"></i>
                    </div>
                    <div class="sesi-info">
                      <div class="sesi-name">Sesi Pagi</div>
                      <div class="sesi-time">07:30 – 11:00 WIB</div>
                      <div class="sesi-quota" id="kuota-pagi">Sisa kuota: –</div>
                    </div>
                  </label>
                </div>
                <div class="sesi-card">
                  <input type="radio" name="sesi" id="sesi_siang" value="Siang">
                  <label for="sesi_siang" class="sesi-label">
                    <div class="sesi-icon" style="background:rgba(2,132,199,0.15);color:#0284C7;">
                      <i class="fas fa-cloud-sun"></i>
                    </div>
                    <div class="sesi-info">
                      <div class="sesi-name">Sesi Siang</div>
                      <div class="sesi-time">11:00 – 14:00 WIB</div>
                      <div class="sesi-quota" id="kuota-siang">Sisa kuota: –</div>
                    </div>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-nav">
          <button type="button" class="btn btn-outline" id="prev3Btn">
            <i class="fas fa-arrow-left"></i> Kembali
          </button>
          <button type="button" class="btn btn-primary" id="next3Btn">
            Review <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      </div>

      <!-- ======== STEP 4: REVIEW ======== -->
      <div class="form-step" id="form-step-4">
        <div class="form-section">
          <div class="form-section-header">
            <div class="form-section-icon"><i class="fas fa-clipboard-check"></i></div>
            <div>
              <div class="form-section-title">Konfirmasi Pendaftaran</div>
              <div class="form-section-sub">Periksa kembali data Anda sebelum submit</div>
            </div>
          </div>
          <div class="form-body">
            <div id="reviewContent" style="display:grid;gap:0.75rem;"></div>

            <div class="alert alert-warning" style="margin-top:1.5rem;">
              <i class="fas fa-exclamation-triangle"></i>
              <div>Pastikan data yang Anda masukkan sudah benar. Nomor antrian yang dihasilkan berlaku untuk kunjungan di tanggal yang dipilih.</div>
            </div>
          </div>
        </div>
        <div class="form-nav">
          <button type="button" class="btn btn-outline" id="prev4Btn">
            <i class="fas fa-arrow-left"></i> Ubah Data
          </button>
          <button type="submit" class="btn btn-primary" id="submitBtn">
            <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
          </button>
        </div>
      </div>
    </form>

  </div><!-- /.container -->
</main>

<?php include '../includes/footer.php'; ?>
<div class="toast-container" id="toastContainer" aria-live="polite"></div>

<script src="../js/main.js"></script>
<script src="../js/pendaftaran.js"></script>
</body>
</html>
