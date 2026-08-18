<?php
// ============================================================
// INFORMASI FASILITAS — SIPP UPTD PUSKESMAS IPUH
// ============================================================
require_once 'includes/functions.php';

$activePage  = 'fasilitas';
$poli        = getAllPoli();
$fasilitas   = getAllFasilitas();
$pengumuman  = getPengumumanAktif();

// Group fasilitas by kategori
$fasilitasGrouped = [];
foreach ($fasilitas as $f) {
    $fasilitasGrouped[$f['kategori']][] = $f;
}

$lastUpdate = date('H:i \W\I\B, d M Y');
$pageTitle = 'Info Fasilitas SIPP UPTD Puskesmas Ipuh';
$metaDesc = 'Informasi ketersediaan fasilitas, poli, dan layanan UPTD Puskesmas Ipuh secara real-time.';
$extraCss = ['css/fasilitas.css?v=' . time()];
include 'includes/header.php';
?>

<?php include 'includes/navbar.php'; ?>

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
      <span>/</span>
      <span>Fasilitas</span>
    </nav>
    <div class="page-header-content">
      <h1><i class="fas fa-hospital" style="margin-right:0.5rem;opacity:0.8;"></i> Informasi Ketersediaan Fasilitas</h1>
      <p>Status terkini poli, ruangan, dan fasilitas  Diperbarui: <strong id="lastUpdateText"><?= $lastUpdate ?></strong></p>
    </div>
  </div>
</div>



<main class="section">
  <div class="container">

    <!-- Header Actions -->
    <div class="fasilitas-header">
      <div class="legend">
        <div class="legend-item">
          <span class="legend-dot legend-dot-success"></span>
          <span>Tersedia / Buka</span>
        </div>
        <div class="legend-item">
          <span class="legend-dot legend-dot-warning"></span>
          <span>Hampir Penuh / Penuh</span>
        </div>
        <div class="legend-item">
          <span class="legend-dot legend-dot-danger"></span>
          <span>Tidak Tersedia / Tutup</span>
        </div>
      </div>
      <button class="btn btn-outline" id="refreshBtn" aria-label="Refresh status fasilitas">
        <i class="fas fa-rotate-right" id="refreshIcon"></i> Refresh
      </button>
    </div>

    <!-- ======== SECTION: STATUS POLI ======== -->
    <div class="fasilitas-section">
      <div class="fasilitas-section-header">
        <div class="fasilitas-section-icon"><i class="fas fa-stethoscope"></i></div>
        <div>
          <h2 class="fasilitas-section-title">Status Poli &amp; Layanan</h2>
          <p class="fasilitas-section-sub">Per <?= date('d F Y') ?></p>
        </div>
      </div>

      <div class="poli-dashboard-grid">
        <?php foreach ($poli as $p):
          $statusClass = match($p['status']) {
            'Buka'  => 'poli-status-buka',
            'Penuh' => 'poli-status-penuh',
            'Tutup' => 'poli-status-tutup',
            default => 'poli-status-buka',
          };
          $badgeClass = match($p['status']) {
            'Buka'  => 'badge-success',
            'Penuh' => 'badge-warning',
            'Tutup' => 'badge-danger',
            default => 'badge-info',
          };
          $persen = 0;
          $kuotaTotal = $p['kuota_pagi'] + $p['kuota_siang'];
          if ($kuotaTotal > 0) {
            $pdo  = getPDO();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM pendaftaran WHERE poli_id=? AND tgl_kunjungan=?");
            $stmt->execute([$p['id'], date('Y-m-d')]);
            $terisi = (int)$stmt->fetchColumn();
            $persen = min(100, round($terisi / $kuotaTotal * 100));
          }
        ?>
        <div class="poli-card <?= $statusClass ?> reveal">
          <div class="poli-card-header">
            <div class="poli-card-icon">
              <i class="fas fa-<?= $p['id'] == 6 ? 'ambulance' : ($p['id'] == 7 ? 'flask' : ($p['id'] == 8 ? 'pills' : 'stethoscope')) ?>"></i>
            </div>
            <div class="poli-card-meta">
              <h3 class="poli-card-name"><?= htmlspecialchars($p['nama_poli']) ?></h3>
              <?php if ($p['dokter_jaga']): ?>
              <p class="poli-card-dokter"><i class="fas fa-user-md"></i> <?= htmlspecialchars($p['dokter_jaga']) ?></p>
              <?php endif; ?>
            </div>
            <span class="badge badge-dot <?= $badgeClass ?>"><?= $p['status'] ?></span>
          </div>

          <div class="poli-card-info">
            <div class="poli-info-row">
              <i class="fas fa-clock"></i>
              <span><?= $p['jam_buka'] ?> – <?= $p['jam_tutup'] ?> WIB</span>
            </div>
            <?php if ($kuotaTotal > 0): ?>
            <div class="poli-info-row">
              <i class="fas fa-users"></i>
              <span>Kuota: Pagi <?= $p['kuota_pagi'] ?> | Siang <?= $p['kuota_siang'] ?></span>
            </div>
            <?php if ($persen > 0): ?>
            <div>
              <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:var(--clr-gray-500);margin-bottom:4px;">
                <span>Terisi hari ini</span><span><?= $persen ?>%</span>
              </div>
              <div class="progress-bar-wrap">
                <div class="progress-bar-fill" style="width:<?= $persen ?>%;background:<?= $persen >= 90 ? 'linear-gradient(90deg,#DC2626,#EF4444)' : ($persen >= 70 ? 'linear-gradient(90deg,#D97706,#F59E0B)' : 'linear-gradient(90deg,var(--clr-accent),var(--clr-secondary))') ?>"></div>
              </div>
            </div>
            <?php endif; ?>
            <?php endif; ?>
          </div>

          <?php if ($p['status'] === 'Buka'): ?>
          <a href="pendaftaran.php?poli=<?= $p['id'] ?>" class="poli-daftar-btn" id="fas-daftar-<?= $p['id'] ?>">
            <i class="fas fa-plus-circle"></i> Daftar Sekarang
          </a>
          <?php else: ?>
          <button class="poli-daftar-btn poli-daftar-disabled" disabled>
            <i class="fas fa-times-circle"></i> Tidak Tersedia
          </button>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- ======== SECTION: FASILITAS ======== -->
    <?php
    $iconKategori = [
      'Ruang Rawat Inap' => 'fa-bed',
      'Ruangan'          => 'fa-door-open',
      'Peralatan'        => 'fa-syringe',
      'Fasilitas Umum'   => 'fa-building',
    ];
    foreach ($fasilitasGrouped as $kategori => $items): ?>
    <div class="fasilitas-section">
      <div class="fasilitas-section-header">
        <div class="fasilitas-section-icon">
          <i class="fas <?= $iconKategori[$kategori] ?? 'fa-th' ?>"></i>
        </div>
        <div>
          <h2 class="fasilitas-section-title"><?= htmlspecialchars($kategori) ?></h2>
        </div>
      </div>

      <div class="fasilitas-grid">
        <?php foreach ($items as $f):
          $statusClass = match($f['status']) {
            'Tersedia'          => 'fas-card-success',
            'Hampir Penuh'      => 'fas-card-warning',
            'Tidak Tersedia'    => 'fas-card-danger',
            default             => 'fas-card-success',
          };
          $badgeClass = match($f['status']) {
            'Tersedia'       => 'badge-success',
            'Hampir Penuh'   => 'badge-warning',
            'Tidak Tersedia' => 'badge-danger',
            default          => 'badge-info',
          };
          $persen = ($f['kapasitas'] > 0) ? min(100, round($f['terisi'] / $f['kapasitas'] * 100)) : 0;
        ?>
        <div class="fas-card <?= $statusClass ?> reveal">
          <div class="fas-card-header">
            <div class="fas-icon-wrap">
              <i class="fas <?= htmlspecialchars($f['ikon'] ?? 'fa-building') ?>"></i>
            </div>
            <span class="badge badge-dot <?= $badgeClass ?>"><?= htmlspecialchars($f['status']) ?></span>
          </div>

          <h3 class="fas-card-name"><?= htmlspecialchars($f['nama']) ?></h3>

          <?php if ($f['keterangan']): ?>
          <p class="fas-card-ket"><?= htmlspecialchars($f['keterangan']) ?></p>
          <?php endif; ?>

          <?php if ($f['kapasitas'] > 0): ?>
          <div class="fas-capacity">
            <div style="display:flex;justify-content:space-between;font-size:0.775rem;margin-bottom:4px;">
              <span><?= $f['terisi'] ?>/<?= $f['kapasitas'] ?> terisi</span>
              <span><?= $persen ?>%</span>
            </div>
            <div class="progress-bar-wrap">
              <div class="progress-bar-fill" style="width:<?= $persen ?>%;background:<?= $persen >= 90 ? 'linear-gradient(90deg,#DC2626,#EF4444)' : ($persen >= 70 ? 'linear-gradient(90deg,#D97706,#F59E0B)' : 'linear-gradient(90deg,var(--clr-accent),var(--clr-secondary))') ?>"></div>
            </div>
          </div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>

    <!-- CTA -->
    <div style="text-align:center;padding:2rem;background:var(--clr-gray-50);border-radius:var(--radius-xl);margin-top:1rem;">
      <h3 style="font-family:var(--font-heading);color:var(--clr-primary);margin-bottom:0.75rem;">Ingin Mendaftar?</h3>
      <p style="color:var(--clr-gray-600);margin-bottom:1.5rem;">Daftarkan diri Anda secara online ke poli yang tersedia</p>
      <a href="pendaftaran.php" class="btn btn-primary btn-lg" id="fas-daftar-online-btn">
        <i class="fas fa-clipboard-list"></i> Pendaftaran Online
      </a>
    </div>

  </div><!-- /.container -->
</main>

<?php include 'includes/footer.php'; ?>
<div class="toast-container" id="toastContainer" aria-live="polite"></div>

<script src="js/main.js?v=<?= time() ?>"></script>
<script src="js/fasilitas.js"></script>
</body>
</html>
