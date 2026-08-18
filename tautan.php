<?php
// ============================================================
// TAUTAN TERKAIT — SIPP UPTD PUSKESMAS IPUH
// ============================================================
require_once 'includes/functions.php';
$activePage = '';
$pageTitle = 'Tautan Terkait - SIPP UPTD Puskesmas Ipuh';
$metaDesc = 'Tautan terkait instansi pemerintah, kesehatan, dan layanan publik yang berhubungan dengan UPTD Puskesmas Ipuh.';
include 'includes/header.php';
?>

<?php include 'includes/navbar.php'; ?>

<!-- Page Header -->
<div class="page-header">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="index.php"><i class="fas fa-home"></i> Beranda</a>
      <span>/</span>
      <span>Tautan Terkait</span>
    </nav>
    <div class="page-header-content">
      <h1><i class="fas fa-link" style="margin-right:0.5rem;opacity:0.8;"></i> Tautan Terkait</h1>
      <p>Kumpulan tautan instansi pemerintah dan layanan kesehatan yang berhubungan dengan Puskesmas Ipuh</p>
    </div>
  </div>
</div>

<main class="section">
  <div class="container">

    <?php
    $groups = [
      [
        'icon'  => 'fas fa-landmark',
        'label' => 'Pemerintah Pusat & Daerah',
        'color' => '#1A4731',
        'links' => [
          ['Kementerian Kesehatan RI',       'https://www.kemkes.go.id',                'fas fa-hospital',       'Informasi kebijakan kesehatan nasional, regulasi, dan program Kemenkes RI.'],
          ['Pemerintah Kab. Mukomuko',       'https://mukomukokab.go.id',               'fas fa-building-columns','Portal resmi Pemerintah Kabupaten Mukomuko, Bengkulu.'],
          ['Dinas Kesehatan Kab. Mukomuko',  'https://dinkes.mukomukokab.go.id',        'fas fa-heart-pulse',    'Informasi program dan kebijakan kesehatan Kabupaten Mukomuko.'],
          ['Provinsi Bengkulu',              'https://bengkuluprov.go.id',              'fas fa-map-location-dot','Portal resmi Pemerintah Provinsi Bengkulu.'],
        ],
      ],
      [
        'icon'  => 'fas fa-hospital',
        'label' => 'Fasilitas Kesehatan Terkait',
        'color' => '#2D7A4F',
        'links' => [
          ['RSUD Mukomuko',                  'https://rsud.mukomukokab.go.id',          'fas fa-hospital-user',  'Rumah Sakit Umum Daerah Mukomuko sebagai rujukan tingkat lanjut.'],
          ['Puskesmas Umbulharjo I Jogja',   'https://umbulharjo1pusk.jogjakota.go.id', 'fas fa-stethoscope',   'Referensi website Puskesmas modern berbasis SIPP.'],
          ['BPJS Kesehatan',                 'https://www.bpjs-kesehatan.go.id',        'fas fa-id-card',       'Cek kepesertaan BPJS Kesehatan dan layanan JKN.'],
          ['SatuSehat Kemenkes',             'https://satusehat.kemkes.go.id',          'fas fa-shield-heart',  'Platform data kesehatan nasional terintegrasi dari Kemenkes.'],
        ],
      ],
      [
        'icon'  => 'fas fa-globe',
        'label' => 'Layanan Publik & Informasi',
        'color' => '#0284C7',
        'links' => [
          ['Portal Satu Data Indonesia',     'https://data.go.id',                      'fas fa-database',      'Satu Data Indonesia - portal data pemerintah terbuka.'],
          ['Sistem Pemerintahan Berbasis Elektronik (SPBE)', 'https://spbe.go.id',      'fas fa-server',        'Portal SPBE Nasional untuk tata kelola pemerintahan digital.'],
          ['Dukcapil Kemendagri',            'https://dukcapil.kemendagri.go.id',       'fas fa-id-badge',      'Administrasi kependudukan dan catatan sipil nasional.'],
          ['Lapor! - Layanan Aspirasi',      'https://www.lapor.go.id',                 'fas fa-comments',      'Platform pengaduan dan aspirasi masyarakat untuk pemerintah.'],
        ],
      ],
    ];
    ?>

    <?php foreach ($groups as $g): ?>
    <div class="tautan-group reveal">
      <div class="tautan-group-header">
        <div class="tautan-group-icon" style="background:<?= $g['color'] ?>;">
          <i class="<?= $g['icon'] ?>"></i>
        </div>
        <h2 class="tautan-group-title"><?= $g['label'] ?></h2>
      </div>

      <div class="tautan-grid">
        <?php foreach ($g['links'] as $i => $link): ?>
        <a href="<?= $link[1] ?>" target="_blank" rel="noopener noreferrer"
           class="tautan-card" id="tautan-<?= preg_replace('/[^a-z0-9]/', '-', strtolower($link[0])) ?>">
          <div class="tautan-card-icon" style="background:<?= $g['color'] ?>1a;color:<?= $g['color'] ?>;">
            <i class="<?= $link[2] ?>"></i>
          </div>
          <div class="tautan-card-body">
            <h3 class="tautan-card-title"><?= htmlspecialchars($link[0]) ?></h3>
            <p class="tautan-card-desc"><?= htmlspecialchars($link[3]) ?></p>
            <span class="tautan-card-url"><?= parse_url($link[1], PHP_URL_HOST) ?> <i class="fas fa-external-link-alt"></i></span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endforeach; ?>

  </div>
</main>

<style>
/* ---- Tautan Terkait Styles ---- */
.tautan-group {
  margin-bottom: 3.5rem;
}
.tautan-group-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid var(--clr-gray-100);
}
.tautan-group-icon {
  width: 48px; height: 48px;
  border-radius: var(--radius-lg);
  display: flex; align-items: center; justify-content: center;
  color: white; font-size: 1.2rem;
  flex-shrink: 0;
}
.tautan-group-title {
  font-family: var(--font-heading);
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--clr-primary);
  margin: 0;
}
.tautan-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 1rem;
}
.tautan-card {
  display: flex;
  gap: 1rem;
  align-items: flex-start;
  padding: 1.25rem;
  background: var(--clr-white);
  border-radius: var(--radius-lg);
  border: 2px solid var(--clr-gray-100);
  box-shadow: var(--shadow-sm);
  text-decoration: none;
  color: inherit;
  transition: all var(--transition-base);
}
.tautan-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
  border-color: var(--clr-accent);
}
.tautan-card-icon {
  width: 48px; height: 48px;
  border-radius: var(--radius-md);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.2rem;
  flex-shrink: 0;
}
.tautan-card-body { flex: 1; min-width: 0; }
.tautan-card-title {
  font-family: var(--font-heading);
  font-size: 0.95rem;
  font-weight: 700;
  color: var(--clr-primary);
  margin: 0 0 4px;
  line-height: 1.3;
}
.tautan-card-desc {
  font-size: 0.8rem;
  color: var(--clr-gray-600);
  margin: 0 0 8px;
  line-height: 1.5;
}
.tautan-card-url {
  font-size: 0.75rem;
  color: var(--clr-accent);
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 4px;
}
.tautan-card-url i { font-size: 0.65rem; }
@media (max-width: 768px) {
  .tautan-grid { grid-template-columns: 1fr; }
  .tautan-group-header { flex-wrap: wrap; }
}
</style>

<?php include 'includes/footer.php'; ?>
<div class="toast-container" id="toastContainer" aria-live="polite"></div>
<script src="js/main.js"></script>
</body>
</html>
