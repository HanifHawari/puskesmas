<?php
// ============================================================
// PENGADUAN MASYARAKAT — SIPP UPTD PUSKESMAS IPUH
// ============================================================
require_once '../includes/functions.php';
$activePage = 'pengaduan';

$kategoriList = [
    'Pelayanan Petugas',
    'Fasilitas & Kebersihan',
    'Waktu Tunggu',
    'Prosedur & Administrasi',
    'Obat-obatan',
    'Lain-lain / Saran',
];
$pageTitle = 'Pengaduan Masyarakat SIPP UPTD Puskesmas Ipuh';
$metaDesc = 'Sampaikan pengaduan, keluhan, atau saran kepada UPTD Puskesmas Ipuh secara online dan anonim.';
$extraHead = <<<HTML
  <style>
    .view-toggle {
      display: flex;
      gap: 4px;
      background: var(--clr-gray-100);
      padding: 4px;
      border-radius: var(--radius-xl);
      margin-bottom: 2.5rem;
      max-width: 360px;
      margin-left: auto;
      margin-right: auto;
    }
    .view-btn {
      flex: 1;
      padding: 8px 20px;
      border: none;
      border-radius: var(--radius-lg);
      font-family: var(--font-body);
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--clr-gray-600);
      cursor: pointer;
      background: transparent;
      transition: all var(--transition-base);
      display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .view-btn.active {
      background: var(--clr-white);
      color: var(--clr-primary);
      font-weight: 600;
      box-shadow: var(--shadow-sm);
    }
    .view-panel { display: none; }
    .view-panel.active { display: block; animation: fadeIn 0.3s ease; }

    .kategori-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 0.75rem;
      margin-bottom: 1.5rem;
    }
    .kat-card input { display: none; }
    .kat-label {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      padding: 1rem;
      border: 2px solid var(--clr-gray-200);
      border-radius: var(--radius-lg);
      cursor: pointer;
      text-align: center;
      font-size: 0.85rem;
      font-weight: 500;
      color: var(--clr-gray-700);
      transition: all var(--transition-fast);
    }
    .kat-label i { font-size: 1.5rem; color: var(--clr-accent); }
    .kat-card input:checked + .kat-label {
      border-color: var(--clr-accent);
      background: rgba(76,175,130,0.08);
      color: var(--clr-primary);
    }
    .kat-label:hover { border-color: var(--clr-accent); }

    /* Tracking */
    .tracking-result { display: none; }
    .tracking-result.show { display: block; animation: fadeIn 0.3s ease; }
    .status-timeline { position: relative; padding-left: 2.5rem; }
    .status-timeline::before {
      content: '';
      position: absolute;
      left: 11px; top: 0; bottom: 0;
      width: 2px;
      background: var(--clr-gray-200);
    }
    .timeline-item {
      position: relative;
      margin-bottom: 1.5rem;
    }
    .timeline-dot {
      position: absolute;
      left: -2.5rem;
      width: 24px; height: 24px;
      border-radius: 50%;
      background: var(--clr-gray-200);
      border: 3px solid var(--clr-white);
      box-shadow: 0 0 0 2px var(--clr-gray-200);
      display: flex; align-items: center; justify-content: center;
      font-size: 0.65rem;
      color: var(--clr-gray-400);
    }
    .timeline-dot.done {
      background: var(--clr-accent);
      box-shadow: 0 0 0 2px rgba(76,175,130,0.25);
      color: white;
    }
    .timeline-dot.current {
      background: var(--clr-warning);
      box-shadow: 0 0 0 2px rgba(217,119,6,0.25);
      color: white;
      animation: pulse 2s ease infinite;
    }
    .timeline-label { font-weight: 600; font-size: 0.95rem; color: var(--clr-gray-800); }
    .timeline-sub   { font-size: 0.8rem; color: var(--clr-gray-500); margin-top: 2px; }
    .timeline-item.active .timeline-label { color: var(--clr-primary); }
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
      <span>Pengaduan</span>
    </nav>
    <div class="page-header-content">
      <h1><i class="fas fa-comments" style="margin-right:0.5rem;opacity:0.8;"></i> Pengaduan Masyarakat</h1>
      <p>Suara Anda penting bagi kami sampaikan keluhan, saran, atau apresiasi</p>
    </div>
  </div>
</div>

<main class="section">
  <div class="container" style="max-width:860px;">

    <!-- View Toggle -->
    <div class="view-toggle" role="tablist" aria-label="Pilih tampilan">
      <button class="view-btn active" data-view="form" id="btn-form" role="tab">
        <i class="fas fa-edit"></i> Buat Pengaduan
      </button>
      <button class="view-btn" data-view="tracking" id="btn-tracking" role="tab">
        <i class="fas fa-search"></i> Lacak Pengaduan
      </button>
    </div>

    <!-- ======== VIEW: FORM PENGADUAN ======== -->
    <div class="view-panel active" id="view-form" role="tabpanel" aria-labelledby="btn-form">

      <div class="alert alert-info" style="margin-bottom:1.5rem;">
        <i class="fas fa-user-secret"></i>
        <div>
          <strong>Anonim Diperbolehkan:</strong> Identitas pelapor bersifat opsional.
          Anda dapat menyampaikan pengaduan tanpa mencantumkan nama.
        </div>
      </div>

      <form id="pengaduanForm" action="../process/process_pengaduan.php" method="POST" enctype="multipart/form-data" novalidate>

        <!-- Identitas (Opsional) -->
        <div class="card" style="margin-bottom:1.5rem;">
          <div class="card-body">
            <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--clr-primary);margin-bottom:1.25rem;">
              <i class="fas fa-user-circle" style="color:var(--clr-accent);margin-right:8px;"></i>
              Identitas Pelapor <span style="font-weight:400;color:var(--clr-gray-400);font-size:0.85rem;">(Opsional)</span>
            </h3>
            <div class="form-row">
              <div class="form-group">
                <label for="nama_pelapor" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama_pelapor" name="nama_pelapor" class="form-control"
                       placeholder="Kosongkan jika ingin anonim">
              </div>
              <div class="form-group">
                <label for="no_hp_pelapor" class="form-label">Nomor HP</label>
                <input type="tel" id="no_hp_pelapor" name="no_hp" class="form-control"
                       placeholder="Untuk pemberitahuan tindak lanjut">
              </div>
            </div>
          </div>
        </div>

        <!-- Detail Pengaduan -->
        <div class="card" style="margin-bottom:1.5rem;">
          <div class="card-body">
            <h3 style="font-family:var(--font-heading);font-size:1.05rem;font-weight:700;color:var(--clr-primary);margin-bottom:1.25rem;">
              <i class="fas fa-file-alt" style="color:var(--clr-accent);margin-right:8px;"></i>
              Detail Pengaduan
            </h3>

            <!-- Kategori -->
            <div class="form-group">
              <label for="kategori" class="form-label">Kategori Pengaduan <span class="required">*</span></label>
              <select name="kategori" id="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori Pengaduan --</option>
                <?php foreach ($kategoriList as $kat): ?>
                <option value="<?= htmlspecialchars($kat) ?>"><?= htmlspecialchars($kat) ?></option>
                <?php endforeach; ?>
              </select>
              <span class="form-error" id="kategori-error">Pilih kategori pengaduan</span>
            </div>

            <div class="form-group">
              <label for="judul" class="form-label">Judul Pengaduan <span class="required">*</span></label>
              <input type="text" id="judul" name="judul" class="form-control"
                     placeholder="Ringkasan singkat pengaduan Anda" maxlength="200" required>
              <span class="form-error" id="judul-error">Judul tidak boleh kosong</span>
            </div>

            <div class="form-group">
              <label for="isi_pengaduan" class="form-label">Isi Pengaduan <span class="required">*</span></label>
              <textarea id="isi_pengaduan" name="isi_pengaduan" class="form-control" rows="5"
                        placeholder="Ceritakan pengaduan Anda secara detail: kapan terjadi, siapa yang terlibat, apa yang terjadi, dan harapan Anda..." required></textarea>
              <div class="form-hint" id="charCount">0 / 2000 karakter</div>
              <span class="form-error" id="isi-error">Isi pengaduan tidak boleh kosong</span>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="tgl_kejadian" class="form-label">Tanggal Kejadian <span class="required">*</span></label>
                <input type="date" id="tgl_kejadian" name="tgl_kejadian" class="form-control"
                       max="<?= date('Y-m-d') ?>" required>
              </div>
              <div class="form-group">
                <label for="file_bukti" class="form-label">Upload Bukti <span style="color:var(--clr-gray-400);font-weight:400;">(Opsional)</span></label>
                <input type="file" id="file_bukti" name="file_bukti" class="form-control"
                       accept=".jpg,.jpeg,.png,.pdf">
                <span class="form-hint">Format: JPG, PNG, PDF. Maks. 5MB</span>
              </div>
            </div>
          </div>
        </div>

        <div class="alert alert-warning" style="margin-bottom:1.5rem;">
          <i class="fas fa-shield-alt"></i>
          <div style="font-size:0.875rem;">
            Pengaduan yang masuk akan diproses dalam <strong>3–5 hari kerja</strong>.
            Anda akan mendapatkan kode tracking untuk memantau status pengaduan.
          </div>
        </div>

        <div style="text-align:right;">
          <button type="submit" class="btn btn-primary btn-lg" id="submitPengaduanBtn">
            <i class="fas fa-paper-plane"></i> Kirim Pengaduan
          </button>
        </div>
      </form>
    </div>

    <!-- ======== VIEW: TRACKING ======== -->
    <div class="view-panel" id="view-tracking" role="tabpanel" aria-labelledby="btn-tracking">
      <div class="card" style="margin-bottom:1.5rem;">
        <div class="card-body">
          <h3 style="font-family:var(--font-heading);font-size:1.1rem;font-weight:700;color:var(--clr-primary);margin-bottom:1.25rem;">
            <i class="fas fa-search" style="color:var(--clr-accent);margin-right:8px;"></i>
            Lacak Status Pengaduan
          </h3>
          <div style="display:flex;gap:0.75rem;align-items:flex-end;">
            <div class="form-group" style="flex:1;margin-bottom:0;">
              <label for="kode_tracking" class="form-label">Kode Pengaduan <span class="required">*</span></label>
              <input type="text" id="kode_tracking" class="form-control"
                     placeholder="Contoh: ADU-AB12CD"
                     style="text-transform:uppercase;letter-spacing:0.05em;">
            </div>
            <button type="button" class="btn btn-primary" id="cariBtn" style="flex-shrink:0;">
              <i class="fas fa-search"></i> Cari
            </button>
          </div>
        </div>
      </div>

      <!-- Tracking Result -->
      <div class="tracking-result" id="trackingResult">
        <div class="card">
          <div class="card-body">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
              <div>
                <div style="font-size:0.8rem;color:var(--clr-gray-400);text-transform:uppercase;letter-spacing:0.05em;">Kode Pengaduan</div>
                <div style="font-family:var(--font-heading);font-size:1.4rem;font-weight:800;color:var(--clr-primary);" id="res-kode">-</div>
              </div>
              <span class="badge badge-dot" id="res-status-badge">-</span>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1.5rem;">
              <div style="background:var(--clr-gray-50);padding:0.75rem;border-radius:var(--radius-md);">
                <div style="font-size:0.75rem;color:var(--clr-gray-400);">Kategori</div>
                <div style="font-weight:600;color:var(--clr-gray-800);font-size:0.9rem;" id="res-kategori">-</div>
              </div>
              <div style="background:var(--clr-gray-50);padding:0.75rem;border-radius:var(--radius-md);">
                <div style="font-size:0.75rem;color:var(--clr-gray-400);">Tanggal Masuk</div>
                <div style="font-weight:600;color:var(--clr-gray-800);font-size:0.9rem;" id="res-tanggal">-</div>
              </div>
            </div>

            <div style="margin-bottom:1.5rem;">
              <div style="font-size:0.85rem;font-weight:600;color:var(--clr-gray-600);margin-bottom:0.5rem;">Judul:</div>
              <div style="font-weight:700;color:var(--clr-gray-800);" id="res-judul">-</div>
            </div>

            <!-- Timeline -->
            <div style="font-size:0.85rem;font-weight:600;color:var(--clr-gray-600);margin-bottom:1rem;">Progress Penanganan:</div>
            <div class="status-timeline" id="res-timeline"></div>
          </div>
        </div>
      </div>

      <!-- Not Found -->
      <div id="trackingNotFound" style="display:none;text-align:center;padding:3rem;">
        <i class="fas fa-search" style="font-size:3rem;color:var(--clr-gray-200);display:block;margin-bottom:1rem;"></i>
        <h3 style="color:var(--clr-gray-500);font-size:1.1rem;margin-bottom:0.5rem;">Pengaduan Tidak Ditemukan</h3>
        <p style="color:var(--clr-gray-400);font-size:0.9rem;">Periksa kembali kode pengaduan Anda</p>
      </div>
    </div>

  </div><!-- /.container -->
</main>

<?php include '../includes/footer.php'; ?>
<div class="toast-container" id="toastContainer" aria-live="polite"></div>

<script src="../js/main.js"></script>
<script>
// ---- View Toggle ----------------------------------------
document.querySelectorAll('.view-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const view = btn.dataset.view;
    document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.view-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(`view-${view}`)?.classList.add('active');
  });
});

// ---- Char Counter ----------------------------------------
const isiTextarea = document.getElementById('isi_pengaduan');
const charCount   = document.getElementById('charCount');
if (isiTextarea && charCount) {
  isiTextarea.addEventListener('input', () => {
    const len = isiTextarea.value.length;
    charCount.textContent = `${len} / 2000 karakter`;
    if (len > 2000) {
      isiTextarea.value = isiTextarea.value.substring(0, 2000);
    }
  });
}

// ---- Form Submit -----------------------------------------
const pengaduanForm = document.getElementById('pengaduanForm');
const submitBtn     = document.getElementById('submitPengaduanBtn');

if (pengaduanForm && submitBtn) {
  pengaduanForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    let valid = true;

    // Validate kategori
    if (!document.getElementById('kategori').value) {
      document.getElementById('kategori-error').style.display = 'block';
      valid = false;
    } else {
      document.getElementById('kategori-error').style.display = 'none';
    }

    const judul = document.getElementById('judul');
    if (!judul.value.trim()) {
      judul.classList.add('is-invalid');
      document.getElementById('judul-error').style.display = 'block';
      valid = false;
    } else {
      judul.classList.remove('is-invalid');
      document.getElementById('judul-error').style.display = 'none';
    }

    const isi = document.getElementById('isi_pengaduan');
    if (!isi.value.trim() || isi.value.trim().length < 20) {
      isi.classList.add('is-invalid');
      document.getElementById('isi-error').style.display = 'block';
      valid = false;
    } else {
      isi.classList.remove('is-invalid');
      document.getElementById('isi-error').style.display = 'none';
    }

    if (!document.getElementById('tgl_kejadian').value) {
      document.getElementById('tgl_kejadian').classList.add('is-invalid');
      valid = false;
    } else {
      document.getElementById('tgl_kejadian').classList.remove('is-invalid');
    }

    if (!valid) { showToast('Harap lengkapi form pengaduan.', 'error'); return; }

    setLoading(submitBtn, true);

    try {
      const formData = new FormData(pengaduanForm);
      const res  = await fetch(pengaduanForm.action, { method: 'POST', body: formData });
      const data = await res.json();

      setLoading(submitBtn, false);

      if (data.success) {
        showToast(`Pengaduan berhasil! Kode: ${data.kode}`, 'success', 6000);
        pengaduanForm.reset();

        // Show kode in modal-like alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success';
        alertDiv.innerHTML = `
          <i class="fas fa-check-circle" style="font-size:1.25rem;"></i>
          <div>
            <strong>Pengaduan Diterima!</strong><br>
            Kode tracking Anda: <strong style="font-size:1.1rem;letter-spacing:0.05em;">${data.kode}</strong><br>
            <small>Simpan kode ini untuk melacak status pengaduan Anda.</small>
          </div>
        `;
        pengaduanForm.prepend(alertDiv);
        alertDiv.scrollIntoView({ behavior: 'smooth' });
      } else {
        showToast(data.message || 'Terjadi kesalahan.', 'error');
      }
    } catch {
      setLoading(submitBtn, false);
      showToast('Gagal terhubung ke server.', 'error');
    }
  });
}

// ---- Tracking -------------------------------------------
document.getElementById('cariBtn')?.addEventListener('click', () => {
  const kode = document.getElementById('kode_tracking').value.trim().toUpperCase();
  if (!kode || kode.length < 6) {
    showToast('Masukkan kode pengaduan yang valid.', 'warning');
    return;
  }

  fetch(`../process/get_pengaduan.php?kode=${encodeURIComponent(kode)}`)
    .then(r => r.json())
    .then(data => {
      document.getElementById('trackingResult').classList.remove('show');
      document.getElementById('trackingNotFound').style.display = 'none';

      if (!data.found) {
        document.getElementById('trackingNotFound').style.display = 'block';
        return;
      }

      document.getElementById('res-kode').textContent    = data.kode;
      document.getElementById('res-kategori').textContent = data.kategori;
      document.getElementById('res-tanggal').textContent  = data.created_at;
      document.getElementById('res-judul').textContent    = data.judul;

      const statusBadge = document.getElementById('res-status-badge');
      statusBadge.textContent = data.status;
      statusBadge.className   = 'badge badge-dot';
      if (data.status === 'Selesai') statusBadge.classList.add('badge-success');
      else if (data.status === 'Diproses') statusBadge.classList.add('badge-warning');
      else statusBadge.classList.add('badge-info');

      const steps = [
        { label: 'Diterima',  sub: 'Pengaduan telah masuk ke sistem',       status: 'Diterima' },
        { label: 'Diproses',  sub: 'Sedang ditangani oleh petugas',         status: 'Diproses' },
        { label: 'Selesai',   sub: 'Pengaduan telah ditindaklanjuti',       status: 'Selesai'  },
      ];
      const statusOrder = ['Diterima', 'Diproses', 'Selesai'];
      const currentIdx  = statusOrder.indexOf(data.status);

      document.getElementById('res-timeline').innerHTML = steps.map((s, i) => {
        const isDone    = i < currentIdx;
        const isCurrent = i === currentIdx;
        const dotClass  = isDone ? 'done' : (isCurrent ? 'current' : '');
        const dotIcon   = isDone ? '<i class="fas fa-check"></i>' : (i + 1).toString();
        return `
          <div class="timeline-item ${isCurrent ? 'active' : ''}">
            <div class="timeline-dot ${dotClass}">${dotIcon}</div>
            <div class="timeline-label">${s.label}</div>
            <div class="timeline-sub">${isCurrent ? s.sub : (isDone ? 'Selesai' : 'Menunggu')}</div>
          </div>
        `;
      }).join('');

      document.getElementById('trackingResult').classList.add('show');
    })
    .catch(() => showToast('Gagal menghubungi server.', 'error'));
});

// Enter key on tracking input
document.getElementById('kode_tracking')?.addEventListener('keydown', e => {
  if (e.key === 'Enter') document.getElementById('cariBtn')?.click();
});
</script>
</body>
</html>
