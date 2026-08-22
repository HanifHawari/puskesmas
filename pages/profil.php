<?php
// ============================================================
// PROFIL & MAKLUMAT — SIPP UPTD PUSKESMAS IPUH
// ============================================================
require_once '../includes/functions.php';

$activePage  = 'profil';
$profil      = getProfil();
$tenaga      = getAllTenagaMedis();
$poli        = getAllPoli();
$pageTitle = 'Profil & Maklumat SIPP UPTD Puskesmas Ipuh';
$metaDesc = 'Profil dan Maklumat Pelayanan UPTD Puskesmas Ipuh Visi, misi, struktur organisasi, dan komitmen layanan publik.';
$extraCss = ['../css/fasilitas.css'];
$extraHead = <<<HTML
  <style>
    /* ---- Tab Navigation ------------------------------------ */
    .tab-nav {
      display: flex;
      gap: 4px;
      background: var(--clr-gray-100);
      padding: 4px;
      border-radius: var(--radius-xl);
      margin-bottom: var(--space-3xl);
      flex-wrap: wrap;
    }
    .tab-btn {
      flex: 1;
      min-width: 130px;
      padding: 10px 20px;
      border: none;
      border-radius: var(--radius-lg);
      background: transparent;
      font-family: var(--font-body);
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--clr-gray-600);
      cursor: pointer;
      transition: all var(--transition-base);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      white-space: nowrap;
    }
    .tab-btn.active,
    .tab-btn:hover {
      background: var(--clr-white);
      color: var(--clr-primary);
      font-weight: 600;
      box-shadow: var(--shadow-sm);
    }
    .tab-btn.active { color: var(--clr-primary); }

    .tab-pane { display: none; }
    .tab-pane.active { display: block; animation: fadeIn 0.3s ease; }

    /* ---- Info Cards ---------------------------------------- */
    .info-card {
      display: flex;
      gap: 1rem;
      padding: 1.25rem;
      border-radius: var(--radius-lg);
      background: var(--clr-white);
      border: 1px solid var(--clr-gray-100);
      box-shadow: var(--shadow-sm);
      margin-bottom: 1rem;
    }
    .info-icon {
      width: 44px; height: 44px;
      border-radius: var(--radius-md);
      background: rgba(76,175,130,0.12);
      display: flex; align-items: center; justify-content: center;
      color: var(--clr-accent);
      font-size: 1.1rem;
      flex-shrink: 0;
    }
    .info-label { font-size: 0.75rem; font-weight: 600; color: var(--clr-gray-400); text-transform: uppercase; letter-spacing: 0.05em; }
    .info-value { font-size: 0.95rem; font-weight: 600; color: var(--clr-gray-800); margin-top: 2px; }

    /* ---- Org Chart ----------------------------------------- */
    .org-chart { text-align: center; }
    .org-level  { display: flex; justify-content: center; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .org-card   {
      background: var(--clr-white);
      border: 2px solid var(--clr-gray-100);
      border-radius: var(--radius-lg);
      padding: 1rem 1.5rem;
      min-width: 180px;
      box-shadow: var(--shadow-sm);
      transition: all var(--transition-base);
    }
    .org-card:hover { border-color: var(--clr-accent); transform: translateY(-2px); box-shadow: var(--shadow-md); }
    .org-card.head  { border-color: var(--clr-primary); background: linear-gradient(135deg, var(--clr-primary) 0%, var(--clr-secondary) 100%); color: white; }
    .org-card.head .org-name, .org-card.head .org-role { color: white; }
    .org-name { font-weight: 700; font-size: 0.95rem; color: var(--clr-primary); }
    .org-role { font-size: 0.8rem; color: var(--clr-gray-400); margin-top: 3px; }
    .org-connector {
      width: 2px; height: 2rem; background: var(--clr-gray-200);
      margin: 0 auto; position: relative;
    }
    .org-connector-h {
      display: flex; align-items: center; gap: 0;
      position: relative; margin-bottom: 1.5rem;
    }
    .org-connector-h::before {
      content: '';
      position: absolute;
      top: 0; left: 50%; right: 0;
      transform: translateX(-50%);
      height: 2px;
      background: var(--clr-gray-200);
      width: 80%;
    }

    /* ---- Maklumat ------------------------------------------ */
    .maklumat-box {
      background: linear-gradient(135deg, var(--clr-primary) 0%, var(--clr-secondary) 100%);
      border-radius: var(--radius-xl);
      padding: 3rem;
      color: white;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .maklumat-box::before {
      content: '';
      position: absolute; inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/svg%3E");
    }
    .maklumat-box > * { position: relative; }
    .maklumat-title { font-family: var(--font-heading); font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; }
    .maklumat-subtitle { color: rgba(255,255,255,0.8); margin-bottom: 2rem; }
    .maklumat-list { text-align: left; max-width: 600px; margin: 0 auto 2rem; }
    .maklumat-item {
      display: flex; align-items: flex-start; gap: 12px;
      padding: 0.75rem;
      background: rgba(255,255,255,0.1);
      border-radius: var(--radius-md);
      margin-bottom: 0.75rem;
      border: 1px solid rgba(255,255,255,0.15);
    }
    .maklumat-item i { color: var(--clr-accent-light); font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }
    .maklumat-item p { font-size: 0.9rem; color: rgba(255,255,255,0.9); margin: 0; line-height: 1.5; }

    /* ---- Staff Card ---------------------------------------- */
    .staff-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.25rem; }
    .staff-card {
      background: var(--clr-white);
      border-radius: var(--radius-lg);
      overflow: hidden;
      border: 1px solid var(--clr-gray-100);
      box-shadow: var(--shadow-sm);
      transition: all var(--transition-base);
      text-align: center;
      display: flex;
      flex-direction: column;
    }
    .staff-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--clr-accent); }
    .staff-avatar {
      width: 80px; height: 80px; border-radius: 50%;
      background: linear-gradient(135deg, var(--clr-accent) 0%, var(--clr-secondary) 100%);
      display: flex; align-items: center; justify-content: center;
      margin: 1.5rem auto 1rem;
      font-size: 1.75rem; color: white;
      flex-shrink: 0;
    }
    .staff-info { padding: 0 1rem 1.5rem; flex: 1; }
    .staff-name { font-weight: 700; font-size: 0.9rem; color: var(--clr-primary); margin-bottom: 4px; }
    .staff-job  { font-size: 0.775rem; color: var(--clr-gray-600); }
    .staff-card .badge { margin-top: 8px; }

    /* ---- Layanan Grid Mobile ---- */
    .layanan-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.25rem;
      margin-bottom: 3rem;
    }

    /* ---- Responsive Mobile ---- */
    @media (max-width: 768px) {
      /* Sekilas & Visi-Misi: 2 col -> 1 col */
      .profil-2col { grid-template-columns: 1fr !important; gap: 2rem !important; }
      /* Lokasi: 2fr 1fr -> 1 col */
      .profil-lokasi { grid-template-columns: 1fr !important; gap: 1.5rem !important; }
      /* Maklumat padding */
      .maklumat-box { padding: 2rem 1.25rem; }
      .maklumat-title { font-size: 1.35rem; }
      /* Org chart */
      .org-level { gap: 0.75rem; }
      .org-card  { min-width: 130px; padding: 0.75rem 1rem; }
      /* Staff grid */
      .staff-grid { grid-template-columns: repeat(2, 1fr); }
      /* Layanan grid */
      .layanan-grid {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        scroll-snap-type: x mandatory !important;
        gap: 1rem !important;
        padding-top: 0.5rem !important;
        padding-bottom: 1.5rem !important;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
      }
      .layanan-grid::-webkit-scrollbar { display: none; }
      .layanan-grid .poli-card {
        flex: 0 0 85% !important;
        min-width: 85% !important;
        max-width: 85% !important;
        scroll-snap-align: center !important;
      }
    }

    @media (max-width: 480px) {
      .profil-2col { gap: 1.5rem !important; }
      .staff-grid { grid-template-columns: 1fr 1fr; }
      .org-card   { min-width: 100px; font-size: 0.85rem; }
      .maklumat-box { padding: 1.5rem 1rem; }
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
      <span>Profil &amp; Maklumat</span>
    </nav>
    <div class="page-header-content">
      <h1><i class="fas fa-building" style="margin-right:0.5rem;opacity:0.8;"></i> Profil &amp; Maklumat Pelayanan</h1>
      <p>Informasi resmi, komitmen, dan identitas UPTD Puskesmas Ipuh</p>
    </div>
  </div>
</div>

<!-- ============================================================
     MAIN CONTENT
     ============================================================ -->
<main class="section">
  <div class="container">

    <!-- TAB NAVIGATION -->
    <div class="tab-nav" role="tablist" aria-label="Navigasi Profil">
      <button class="tab-btn active" data-tab-btn="sekilas"    role="tab" aria-selected="true"  aria-controls="tab-sekilas"    id="btn-sekilas">
        <i class="fas fa-info-circle"></i> Sekilas
      </button>
      <button class="tab-btn"        data-tab-btn="visi-misi"  role="tab" aria-selected="false" aria-controls="tab-visi-misi"  id="btn-visi-misi">
        <i class="fas fa-bullseye"></i> Visi &amp; Misi
      </button>
      <button class="tab-btn"        data-tab-btn="struktur"   role="tab" aria-selected="false" aria-controls="tab-struktur"   id="btn-struktur">
        <i class="fas fa-sitemap"></i> Struktur
      </button>
      <button class="tab-btn"        data-tab-btn="layanan"    role="tab" aria-selected="false" aria-controls="tab-layanan"    id="btn-layanan">
        <i class="fas fa-list-check"></i> Layanan
      </button>
      <button class="tab-btn"        data-tab-btn="maklumat"   role="tab" aria-selected="false" aria-controls="tab-maklumat"   id="btn-maklumat">
        <i class="fas fa-file-certificate"></i> Maklumat
      </button>
      <button class="tab-btn"        data-tab-btn="lokasi"     role="tab" aria-selected="false" aria-controls="tab-lokasi"     id="btn-lokasi">
        <i class="fas fa-map-pin"></i> Lokasi
      </button>
    </div>

    <!-- TAB: SEKILAS -->
    <div class="tab-pane active" data-tab-pane="sekilas" id="tab-sekilas" role="tabpanel" aria-labelledby="btn-sekilas">
      <div class="profil-2col" style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start;">
        <div>
          <span class="section-label"><i class="fas fa-hospital"></i> Identitas Puskesmas</span>
          <h2 class="section-title" style="text-align:left;margin:0.5rem 0 1.5rem;">
            <?= htmlspecialchars($profil['nama'] ?? 'UPTD Puskesmas Ipuh') ?>
          </h2>
          <p style="color:var(--clr-gray-600);line-height:1.8;margin-bottom:1.5rem;">
            <?= nl2br(htmlspecialchars($profil['sejarah'] ?? '')) ?>
          </p>
          <p style="color:var(--clr-gray-600);line-height:1.8;margin-bottom:2rem;">
            <i class="fas fa-map-marked-alt" style="color:var(--clr-accent);margin-right:6px;"></i>
            <strong>Wilayah Kerja:</strong> <?= htmlspecialchars($profil['wilayah_kerja'] ?? '') ?>
          </p>

          <a href="profil.php?tab=maklumat" class="btn btn-primary" id="profil-lihat-maklumat-btn">
            <i class="fas fa-file-certificate"></i> Lihat Maklumat Pelayanan
          </a>
        </div>

        <div style="display:flex;flex-direction:column;gap:0.85rem;">
          <?php
          $infoItems = [
            ['fas fa-building', 'Nama Instansi',   $profil['nama']   ?? '-'],
            ['fas fa-user-tie', 'Kepala Puskesmas',$profil['kepala'] ?? '-'],
            ['fas fa-id-badge', 'NIP',             $profil['nip_kepala'] ?? '-'],
            ['fas fa-map-marker-alt','Alamat',      $profil['alamat'] ?? '-'],
            ['fas fa-phone-alt','Telepon',          $profil['telp']   ?? '-'],
            ['fas fa-envelope', 'Email',            $profil['email']  ?? '-'],
            ['fas fa-clock',    'Jam Operasional',  $profil['jam_operasional'] ?? '-'],
          ];
          foreach ($infoItems as $item): ?>
          <div class="info-card">
            <div class="info-icon"><i class="<?= $item[0] ?>"></i></div>
            <div>
              <div class="info-label"><?= $item[1] ?></div>
              <div class="info-value"><?= htmlspecialchars($item[2]) ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- TAB: VISI & MISI -->
    <div class="tab-pane" data-tab-pane="visi-misi" id="tab-visi-misi" role="tabpanel" aria-labelledby="btn-visi-misi">
      <div class="profil-2col" style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start;">
        <!-- Visi -->
        <div>
          <div style="background:linear-gradient(135deg,var(--clr-primary) 0%,var(--clr-secondary) 100%);border-radius:var(--radius-xl);padding:2.5rem;color:white;margin-bottom:1.5rem;">
            <div style="width:60px;height:60px;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem;font-size:1.5rem;">
              <i class="fas fa-eye"></i>
            </div>
            <h3 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:white;margin-bottom:1rem;">Visi</h3>
            <p style="color:rgba(255,255,255,0.9);font-size:1.05rem;line-height:1.7;">
              "<?= htmlspecialchars($profil['visi'] ?? '') ?>"
            </p>
          </div>
        </div>

        <!-- Misi -->
        <div>
          <h3 style="font-family:var(--font-heading);font-size:1.5rem;font-weight:800;color:var(--clr-primary);margin-bottom:1.25rem;">
            <i class="fas fa-bullseye" style="color:var(--clr-accent);margin-right:8px;"></i>Misi
          </h3>
          <?php
          $misi_raw = $profil['misi'] ?? '';
          $misi_lines = array_filter(explode("\n", $misi_raw));
          foreach ($misi_lines as $i => $m): ?>
          <div style="display:flex;align-items:flex-start;gap:1rem;padding:1rem 1.25rem;border-radius:var(--radius-lg);background:var(--clr-white);border:1px solid var(--clr-gray-100);box-shadow:var(--shadow-sm);margin-bottom:0.75rem;">
            <span style="width:32px;height:32px;border-radius:50%;background:var(--clr-primary);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.85rem;flex-shrink:0;"><?= $i + 1 ?></span>
            <p style="margin:0;color:var(--clr-gray-700);line-height:1.6;font-size:0.95rem;padding-top:4px;">
              <?= htmlspecialchars(ltrim($m, '0123456789. ')) ?>
            </p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Tata Nilai -->
      <div style="margin-top:3rem;">
        <h3 style="font-family:var(--font-heading);font-size:1.4rem;font-weight:700;color:var(--clr-primary);text-align:center;margin-bottom:2rem;">
          Tata Nilai
        </h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1rem;">
          <?php
          $nilais = [
            ['S', 'Sigap',   'Tanggap dan cepat dalam memberikan pelayanan'],
            ['E', 'Empati',  'Memahami dan merasakan kebutuhan pasien'],
            ['H', 'Handal',  'Profesional dan kompeten dalam bekerja'],
            ['A', 'Aman',    'Keselamatan pasien adalah prioritas utama'],
            ['T', 'Terpadu', 'Bekerja sama lintas profesi dan sektor'],
          ];
          foreach ($nilais as $n): ?>
          <div style="text-align:center;padding:1.5rem 1rem;border-radius:var(--radius-lg);background:var(--clr-white);border:2px solid var(--clr-gray-100);box-shadow:var(--shadow-sm);transition:all 0.3s;" class="card">
            <div style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,var(--clr-accent) 0%,var(--clr-secondary) 100%);color:white;display:flex;align-items:center;justify-content:center;font-family:var(--font-heading);font-size:1.5rem;font-weight:800;margin:0 auto 0.75rem;"><?= $n[0] ?></div>
            <h4 style="font-family:var(--font-heading);font-weight:700;color:var(--clr-primary);margin-bottom:0.5rem;"><?= $n[1] ?></h4>
            <p style="font-size:0.8rem;color:var(--clr-gray-600);margin:0;line-height:1.5;"><?= $n[2] ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- TAB: STRUKTUR ORGANISASI -->
    <div class="tab-pane" data-tab-pane="struktur" id="tab-struktur" role="tabpanel" aria-labelledby="btn-struktur">
      <h2 class="section-title" style="text-align:center;margin-bottom:0.5rem;">Struktur Organisasi</h2>
      <p style="text-align:center;color:var(--clr-gray-600);margin-bottom:3rem;">UPTD Puskesmas Ipuh Kab. Mukomuko</p>

      <!-- Org Chart -->
      <div class="org-chart">
        <div class="org-level">
          <div class="org-card head">
            <div class="org-name"><?= htmlspecialchars($profil['kepala'] ?? 'Dr.Jelius Hadinata') ?></div>
            <div class="org-role" style="color:rgba(255,255,255,0.7);">Kepala UPTD Puskesmas</div>
            <div style="margin-top:6px;font-size:0.7rem;color:rgba(255,255,255,0.6);">NIP: <?= htmlspecialchars($profil['nip_kepala'] ?? '-') ?></div>
          </div>
        </div>
        <div class="org-connector"></div>
        <div class="org-level">
          <div class="org-card">
            <div class="org-name">Kasubag Tata Usaha</div>
            <div class="org-role">Administrasi & Kepegawaian</div>
          </div>
        </div>
        <div class="org-connector"></div>
        <div class="org-level">
          <div class="org-card">
            <div class="org-name">Koordinator UKP</div>
            <div class="org-role">Upaya Kesehatan Perorangan</div>
          </div>
          <div class="org-card">
            <div class="org-name">Koordinator UKM</div>
            <div class="org-role">Upaya Kesehatan Masyarakat</div>
          </div>
          <div class="org-card">
            <div class="org-name">Koordinator Admin</div>
            <div class="org-role">Administrasi & Manajemen</div>
          </div>
        </div>
      </div>

      <!-- Tenaga Medis -->
      <div style="margin-top:4rem;">
        <h3 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:700;color:var(--clr-primary);text-align:center;margin-bottom:2rem;">
          Tenaga Kesehatan
        </h3>
        <div class="staff-grid">
          <?php
          $icons = [
            'Dokter' => 'fa-user-md',
            'Bidan'  => 'fa-user-nurse',
            'Analis' => 'fa-flask',
            'Apot'   => 'fa-pills',
            'Kepala' => 'fa-user-tie',
          ];
          foreach ($tenaga as $t):
            $icon = 'fa-user-md';
            foreach ($icons as $k => $v) {
              if (stripos($t['jabatan'], $k) !== false) { $icon = $v; break; }
            }
          ?>
          <div class="staff-card">
            <div class="staff-avatar">
              <i class="fas <?= $icon ?>"></i>
            </div>
            <div class="staff-info" style="display:flex;flex-direction:column;align-items:center;flex:1;">
              <div class="staff-name"><?= htmlspecialchars($t['nama']) ?></div>
              <div class="staff-job"><?= htmlspecialchars($t['jabatan']) ?></div>
              <?php if ($t['spesialis']): ?>
              <div style="font-size:0.75rem;color:var(--clr-accent);margin-top:4px;"><?= htmlspecialchars($t['spesialis']) ?></div>
              <?php endif; ?>
              <div style="margin-top:auto;padding-top:10px;">
                <?php if ($t['nama_poli']): ?>
                <span class="badge badge-success"><?= htmlspecialchars($t['nama_poli']) ?></span>
                <?php else: ?>
                <span style="display:inline-block;height:22px;"></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- TAB: LAYANAN -->
    <div class="tab-pane" data-tab-pane="layanan" id="tab-layanan" role="tabpanel" aria-labelledby="btn-layanan">
      <div class="section-header" style="margin-bottom:2rem;">
        <h2 class="section-title">Jenis Layanan</h2>
        <p class="section-subtitle" style="margin:0 auto;">Puskesmas Ipuh menyediakan berbagai layanan kesehatan komprehensif</p>
      </div>

      <div class="layanan-grid">
        <?php
        foreach ($poli as $p):
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
          $iconPoli = match(true) {
            $p['id'] == 6 => 'ambulance',
            $p['id'] == 7 => 'flask',
            $p['id'] == 8 => 'pills',
            default       => 'stethoscope',
          };
        ?>
        <div class="poli-card <?= $statusClass ?> reveal">
          <div class="poli-card-header">
            <div class="poli-card-icon">
              <i class="fas fa-<?= $iconPoli ?>"></i>
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
              <span><?= htmlspecialchars($p['jam_buka']) ?> – <?= htmlspecialchars($p['jam_tutup']) ?> WIB</span>
            </div>
            <?php if ($p['kuota_pagi'] > 0): ?>
            <div class="poli-info-row">
              <i class="fas fa-users"></i>
              <span>Kuota: Pagi <?= $p['kuota_pagi'] ?> | Siang <?= $p['kuota_siang'] ?></span>
            </div>
            <?php endif; ?>
          </div>

          <?php if ($p['status'] === 'Buka'): ?>
          <a href="pendaftaran.php?poli=<?= $p['id'] ?>" class="poli-daftar-btn" id="layanan-daftar-<?= $p['id'] ?>">
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

    <!-- TAB: MAKLUMAT -->
    <div class="tab-pane" id="maklumat" data-tab-pane="maklumat" id="tab-maklumat" role="tabpanel" aria-labelledby="btn-maklumat">
      <div class="maklumat-box">
        <div style="width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,0.9);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;overflow:hidden;padding:6px;">
          <img src="../assets/images/logo.png" alt="Logo Puskesmas Ipuh" style="width:100%;height:100%;object-fit:contain;">
        </div>
        <div class="maklumat-title">Maklumat Pelayanan</div>
        <div class="maklumat-subtitle">UPTD Puskesmas Ipuh  Kab. Mukomuko, Bengkulu</div>

        <p style="color:rgba(255,255,255,0.85);font-size:1rem;margin-bottom:2rem;line-height:1.7;max-width:700px;margin-left:auto;margin-right:auto;">
          Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan sesuai standar yang telah ditetapkan dan apabila kami tidak menepati janji, kami siap menerima sanksi sesuai peraturan perundang-undangan yang berlaku.
        </p>

        <div class="maklumat-list">
          <?php
          $komitmen = [
            'Memberikan pelayanan yang ramah, sopan, dan tidak diskriminatif kepada seluruh masyarakat.',
            'Memberikan pelayanan sesuai standar prosedur operasional yang berlaku.',
            'Menyelesaikan pelayanan tepat waktu sesuai standar yang ditetapkan.',
            'Tidak meminta imbalan di luar ketentuan yang berlaku.',
            'Menjaga kerahasiaan data dan informasi pasien.',
            'Menerima dan menindaklanjuti pengaduan masyarakat dengan serius.',
          ];
          foreach ($komitmen as $k): ?>
          <div class="maklumat-item">
            <i class="fas fa-check-circle"></i>
            <p><?= $k ?></p>
          </div>
          <?php endforeach; ?>
        </div>

        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
          <a href="../assets/uploads/pengaduan/SK%20Maklumat%20Pelayanan.pdf" target="_blank" class="btn btn-white" id="download-maklumat-btn">
            <i class="fas fa-download"></i> Unduh SK Maklumat (PDF)
          </a>
          <a href="pengaduan.php" class="btn" style="border:2px solid rgba(255,255,255,0.4);color:white;" id="maklumat-pengaduan-btn">
            <i class="fas fa-comments"></i> Sampaikan Pengaduan
          </a>
        </div>
      </div>
    </div>

    <!-- TAB: LOKASI -->
    <div class="tab-pane" data-tab-pane="lokasi" id="tab-lokasi" role="tabpanel" aria-labelledby="btn-lokasi">
      <div class="profil-lokasi" style="display:grid;grid-template-columns:2fr 1fr;gap:2.5rem;align-items:start;">
        <!-- Map -->
        <div>
          <div style="border-radius:var(--radius-xl);overflow:hidden;box-shadow:var(--shadow-lg);height:450px;background:var(--clr-gray-100);">
            <iframe 
              src="https://maps.google.com/maps?q=-3.0048965,101.491348&t=&z=17&ie=UTF8&iwloc=&output=embed" 
              width="100%" 
              height="100%" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>

        <!-- Address Info -->
        <div style="display:flex;flex-direction:column;gap:1rem;">
          <h3 style="font-family:var(--font-heading);font-size:1.3rem;font-weight:700;color:var(--clr-primary);">Informasi Kontak</h3>
          <?php
          $contacts = [
            ['fas fa-map-marker-alt','Alamat',       $profil['alamat']           ?? '-'],
            ['fas fa-phone-alt',     'Telepon',       $profil['telp']             ?? '-'],
            ['fas fa-envelope',      'Email',         $profil['email']            ?? '-'],
            ['fas fa-globe',         'Website',       $profil['website']          ?? '-'],
            ['fas fa-clock',         'Jam Layanan',   $profil['jam_operasional']  ?? '-'],
          ];
          foreach ($contacts as $c): ?>
          <div class="info-card">
            <div class="info-icon"><i class="<?= $c[0] ?>"></i></div>
            <div>
              <div class="info-label"><?= $c[1] ?></div>
              <div class="info-value" style="font-size:0.9rem;"><?= htmlspecialchars($c[2]) ?></div>
            </div>
          </div>
          <?php endforeach; ?>

          <a href="https://maps.google.com/?q=Puskesmas+Ipuh+Mukomuko" target="_blank" class="btn btn-primary" id="lokasi-maps-btn">
            <i class="fas fa-directions"></i> Petunjuk Arah
          </a>
        </div>
      </div>
    </div>

  </div><!-- /.container -->
</main>

<?php include '../includes/footer.php'; ?>

<div class="toast-container" id="toastContainer" aria-live="polite"></div>

<script src="../js/main.js"></script>
<script>
// Activate tab from URL hash
document.addEventListener('DOMContentLoaded', () => {
  const hash = window.location.hash.replace('#', '');
  if (hash) {
    const btn = document.querySelector(`[data-tab-btn="${hash}"]`);
    if (btn) btn.click();
  }

  // Tab click: update URL hash
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.dataset.tabBtn;
      history.replaceState(null, '', '#' + target);
      document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active');
        b.setAttribute('aria-selected', 'false');
      });
      document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      btn.setAttribute('aria-selected', 'true');
      document.querySelector(`[data-tab-pane="${target}"]`)?.classList.add('active');
    });
  });
});
</script>
</body>
</html>
