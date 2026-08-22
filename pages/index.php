<?php
// ============================================================
// BERANDA — SIPP UPTD PUSKESMAS IPUH
// ============================================================
require_once '../includes/functions.php';

$activePage   = 'beranda';
$profil       = getProfil();
$pengumuman   = getPengumumanAktif();
$pageTitle = 'Beranda SIPP UPTD Puskesmas Ipuh';
$extraCss = [
    '../css/hero.css', 
    '../css/fasilitas.css?v=' . time(),
    'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css'
];
$extraHead = '<link rel="preload" as="image" href="../assets/images/puskesmas1.jpg">';
include '../includes/header.php';
?>

<?php include '../includes/navbar.php'; ?>

<section class="hero" id="hero" aria-label="Hero Beranda">
  <div class="hero-slider">
    <div class="hero-slide active" style="background-image: url('../assets/images/puskesmas1.jpg');"></div>
    <div class="hero-slide" style="background-image: url('../assets/images/puskesmas2.jpg');"></div>
    <div class="hero-slide" style="background-image: url('../assets/images/puskesmas3.jpg');"></div>
    <div class="hero-slide" style="background-image: url('../assets/images/puskesmas4.jpg');"></div>
    <div class="hero-slide" style="background-image: url('../assets/images/puskesmas5.jpg');"></div>
  </div>
  <div class="hero-content">
    <div class="hero-text">
      <div class="hero-eyebrow"><i class="fas fa-shield-alt"></i> Pelayanan Kesehatan Terpercaya</div>
      <h1 class="hero-title">SELAMAT DATANG<span>DI PUSKESMAS IPUH</span></h1>
      <p class="hero-desc">Sistem Informasi Pelayanan Publik UPTD Puskesmas Ipuh hadir untuk memudahkan masyarakat mengakses layanan kesehatan, mendaftar online, dan menyampaikan aspirasi dengan mudah dan transparan.</p>
      <div class="hero-cta">
        <a href="pendaftaran.php" class="btn btn-white btn-lg" id="hero-daftar-btn"><i class="fas fa-clipboard-list"></i> Daftar Online</a>
        <a href="fasilitas.php" class="btn btn-lg" style="border:2px solid rgba(255,255,255,0.4);color:#fff;" id="hero-fasilitas-btn"><i class="fas fa-hospital"></i> Cek Fasilitas</a>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($pengumuman)): ?>
<div id="banner-container" style="background:linear-gradient(90deg,var(--clr-accent) 0%,var(--clr-secondary) 100%);color:white;padding:0.75rem 0;overflow:hidden;">
  <div class="container" style="display:flex;align-items:center;gap:1rem;">
    <span style="background:rgba(0,0,0,0.15);padding:3px 12px;border-radius:999px;font-size:0.75rem;font-weight:700;white-space:nowrap;flex-shrink:0;">
      <i class="fas fa-bullhorn" id="banner-icon"></i> <span id="banner-type"><?= strtoupper($pengumuman[0]["tipe"]) ?></span>
    </span>
    <div class="marquee-container" style="font-size:0.875rem;">
      <div class="marquee-text" id="banner-text">
        <strong><?= htmlspecialchars($pengumuman[0]["judul"]) ?></strong> - <?= htmlspecialchars($pengumuman[0]["isi"]) ?>
      </div>
    </div>
  </div>
</div>
<script>
const pengumumanData = <?= json_encode($pengumuman) ?>;
if (pengumumanData && pengumumanData.length > 1) {
  let currentIdx = 0;
  const bannerText = document.getElementById("banner-text");
  const bannerType = document.getElementById("banner-type");
  const bannerIcon = document.getElementById("banner-icon");
  bannerText.addEventListener("animationiteration", () => {
    currentIdx = (currentIdx + 1) % pengumumanData.length;
    const p = pengumumanData[currentIdx];
    bannerType.textContent = p.tipe.toUpperCase();
    if (p.tipe === "Darurat") bannerIcon.className = "fas fa-exclamation-triangle";
    else if (p.tipe === "Penting") bannerIcon.className = "fas fa-exclamation-circle";
    else bannerIcon.className = "fas fa-bullhorn";
    const safeJudul = p.judul.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    const safeIsi = p.isi.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    bannerText.innerHTML = "<strong>" + safeJudul + "</strong> - " + safeIsi;
  });
}
</script>
<?php endif; ?>

<!-- QUICK NAV -->
<section class="section" id="layanan" aria-labelledby="layanan-title">
  <div class="container">
    <div class="section-header">
      <span class="section-label"><i class="fas fa-th-large"></i> Layanan Kami</span>
      <h2 class="section-title" id="layanan-title">Akses Layanan dengan Mudah</h2>
      <p class="section-subtitle">Temukan semua layanan kesehatan yang Anda butuhkan dalam satu platform digital yang mudah digunakan.</p>
    </div>
    <div class="quick-nav-grid">
      <a href="profil.php" class="quick-nav-card card-bg-1 reveal" id="nav-profil">
        <div class="poli-card-header">
          <div class="poli-card-icon"><i class="fas fa-building-columns"></i></div>
          <div class="poli-card-meta"><h3 class="poli-card-name">Profil &amp;<br>Maklumat</h3></div>
        </div>
        <div class="poli-card-info"><p style="font-size:0.85rem;color:var(--clr-gray-600);line-height:1.5;margin:0;">Visi, misi, struktur organisasi, dan maklumat pelayanan resmi Puskesmas Ipuh.</p></div>
      </a>
      <a href="pendaftaran.php" class="quick-nav-card card-bg-2 reveal" id="nav-pendaftaran">
        <div class="poli-card-header">
          <div class="poli-card-icon"><i class="fas fa-clipboard-list"></i></div>
          <div class="poli-card-meta"><h3 class="poli-card-name">Pendaftaran<br>Online</h3></div>
        </div>
        <div class="poli-card-info"><p style="font-size:0.85rem;color:var(--clr-gray-600);line-height:1.5;margin:0;">Daftar antrian poli tanpa perlu datang langsung. Hemat waktu Anda.</p></div>
      </a>
      <a href="pengaduan.php" class="quick-nav-card card-bg-3 reveal" id="nav-pengaduan">
        <div class="poli-card-header">
          <div class="poli-card-icon"><i class="fas fa-comments"></i></div>
          <div class="poli-card-meta"><h3 class="poli-card-name">Pengaduan<br>Masyarakat</h3></div>
        </div>
        <div class="poli-card-info"><p style="font-size:0.85rem;color:var(--clr-gray-600);line-height:1.5;margin:0;">Sampaikan keluhan, saran, atau laporan dengan mudah. Kami siap mendengar.</p></div>
      </a>
      <a href="fasilitas.php" class="quick-nav-card card-bg-4 reveal" id="nav-fasilitas">
        <div class="poli-card-header">
          <div class="poli-card-icon"><i class="fas fa-hospital-user"></i></div>
          <div class="poli-card-meta"><h3 class="poli-card-name">Info<br>Fasilitas</h3></div>
        </div>
        <div class="poli-card-info"><p style="font-size:0.85rem;color:var(--clr-gray-600);line-height:1.5;margin:0;">Cek status poli, ketersediaan tempat tidur, dan fasilitas secara real-time.</p></div>
      </a>
    </div>
  </div>
</section>

<!-- GALERI CAROUSEL -->
<section class="section section-alt" id="galeri" aria-labelledby="galeri-title">
  <div class="container">
    <div class="section-header">
      <span class="section-label"><i class="fas fa-images"></i> Galeri</span>
      <h2 class="section-title" id="galeri-title">Mengenal Puskesmas Ipuh</h2>
      <p class="section-subtitle">Fasilitas dan kegiatan pelayanan kesehatan UPTD Puskesmas Ipuh untuk masyarakat Kecamatan Ipuh.</p>
    </div>
    <div class="splide" id="galeriSplide" aria-label="Galeri Puskesmas Ipuh">
      <div class="splide__track">
        <ul class="splide__list">
          <li class="splide__slide">
            <div class="galeri-img-wrap">
              <img src="../assets/images/puskesmas1.jpg" alt="Tim Tenaga Medis & Pegawai Puskesmas Ipuh" loading="lazy">
              <div class="galeri-overlay"><div class="galeri-caption"><i class="fas fa-users"></i><span>Tim Tenaga Medis & Pegawai Puskesmas Ipuh</span></div></div>
            </div>
          </li>
          <li class="splide__slide">
            <div class="galeri-img-wrap">
              <img src="../assets/images/puskesmas2.jpg" alt="Ruang Pendaftaran & Informasi Rawat Inap" loading="lazy">
              <div class="galeri-overlay"><div class="galeri-caption"><i class="fas fa-info-circle"></i><span>Ruang Pendaftaran & Informasi Rawat Inap</span></div></div>
            </div>
          </li>
          <li class="splide__slide">
            <div class="galeri-img-wrap">
              <img src="../assets/images/puskesmas3.jpg" alt="Ruang Tindakan & Pelayanan Gawat Darurat (UGD)" loading="lazy">
              <div class="galeri-overlay"><div class="galeri-caption"><i class="fas fa-heartbeat"></i><span>Ruang Tindakan & Pelayanan Gawat Darurat (UGD)</span></div></div>
            </div>
          </li>
          <li class="splide__slide">
            <div class="galeri-img-wrap">
              <img src="../assets/images/puskesmas4.jpg" alt="Loket Pendaftaran & Pelayanan Pasien" loading="lazy">
              <div class="galeri-overlay"><div class="galeri-caption"><i class="fas fa-clipboard-user"></i><span>Loket Pendaftaran & Pelayanan Pasien</span></div></div>
            </div>
          </li>
          <li class="splide__slide">
            <div class="galeri-img-wrap">
              <img src="../assets/images/puskesmas5.jpg" alt="Pelayanan Konsultasi & Pengambilan Obat" loading="lazy">
              <div class="galeri-overlay"><div class="galeri-caption"><i class="fas fa-pills"></i><span>Pelayanan Konsultasi & Pengambilan Obat</span></div></div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<style>
.galeri-img-wrap{position:relative;overflow:hidden;height:clamp(260px,50vw,540px);border-radius:var(--radius-xl);box-shadow:var(--shadow-xl);background:var(--clr-gray-900);}
.galeri-img-wrap img{width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.8s ease;}
.splide__slide.is-active .galeri-img-wrap img{transform:scale(1.04);}
.galeri-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,28,20,.78) 0%,transparent 55%);display:flex;align-items:flex-end;padding:2rem;pointer-events:none;}
.galeri-caption{display:flex;align-items:center;gap:10px;color:#fff;font-family:var(--font-heading);font-size:clamp(.9rem,2vw,1.15rem);font-weight:600;text-shadow:0 2px 8px rgba(0,0,0,.5);transform:translateY(12px);opacity:0;transition:all .5s ease .2s;}
.splide__slide.is-active .galeri-caption{transform:translateY(0);opacity:1;}
.galeri-caption i{color:var(--clr-accent-light);font-size:1.1rem;flex-shrink:0;}
.splide__pagination {bottom: 1.5rem;}
.splide__pagination__page {background: rgba(255,255,255,.45); transition: all 0.3s ease;}
.splide__pagination__page.is-active {background: #fff; transform: scale(1.2);}
@media(max-width:768px){.galeri-overlay{padding:1.25rem;}}
@media(max-width:480px){.galeri-img-wrap{height:220px;}.galeri-overlay{padding:1rem;}}
</style>

<!-- ============================================================
     TAUTAN TERKAIT — LOGO CAROUSEL
     ============================================================ -->
<section class="section" id="tautan-beranda" aria-labelledby="tautan-title">
  <div class="container">
    <div class="section-header">
      <span class="section-label"><i class="fas fa-link"></i> Tautan Terkait</span>
      <h2 class="section-title" id="tautan-title">Instansi & Layanan Terkait</h2>
      <p class="section-subtitle">Kunjungi portal instansi pemerintah dan layanan kesehatan yang berhubungan dengan Puskesmas Ipuh.</p>
    </div>

    <!-- Logo Carousel -->
    <div class="splide" id="tautanSplide" aria-label="Tautan Terkait">
      <div class="splide__track" style="padding-bottom:1rem; padding-top:1rem;">
        <ul class="splide__list">

          <li class="splide__slide">
            <a href="https://www.kemkes.go.id" target="_blank" rel="noopener" class="tautan-logo-card" id="link-kemenkes">
              <div class="tautan-logo-img"><img src="https://www.google.com/s2/favicons?domain=kemkes.go.id&sz=128" alt="Kemenkes RI" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="tautan-logo-fallback" style="display:none"><i class="fas fa-hospital"></i></div></div>
              <div class="tautan-logo-name">Kementerian Kesehatan RI</div>
              <div class="tautan-logo-url">kemkes.go.id</div>
            </a>
          </li>

          <li class="splide__slide">
            <a href="https://mukomukokab.go.id" target="_blank" rel="noopener" class="tautan-logo-card" id="link-mukomuko">
              <div class="tautan-logo-img"><img src="https://www.google.com/s2/favicons?domain=mukomukokab.go.id&sz=128" alt="Pemkab Mukomuko" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="tautan-logo-fallback" style="display:none"><i class="fas fa-building-columns"></i></div></div>
              <div class="tautan-logo-name">Pemkab Mukomuko</div>
              <div class="tautan-logo-url">mukomukokab.go.id</div>
            </a>
          </li>

          <li class="splide__slide">
            <a href="https://www.bpjs-kesehatan.go.id" target="_blank" rel="noopener" class="tautan-logo-card" id="link-bpjs">
              <div class="tautan-logo-img"><img src="https://www.google.com/s2/favicons?domain=bpjs-kesehatan.go.id&sz=128" alt="BPJS Kesehatan" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="tautan-logo-fallback" style="display:none"><i class="fas fa-id-card"></i></div></div>
              <div class="tautan-logo-name">BPJS Kesehatan</div>
              <div class="tautan-logo-url">bpjs-kesehatan.go.id</div>
            </a>
          </li>

          <li class="splide__slide">
            <a href="https://satusehat.kemkes.go.id" target="_blank" rel="noopener" class="tautan-logo-card" id="link-satusehat">
              <div class="tautan-logo-img"><img src="https://www.google.com/s2/favicons?domain=satusehat.kemkes.go.id&sz=128" alt="SatuSehat Kemenkes" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="tautan-logo-fallback" style="display:none;background:linear-gradient(135deg,#00a86b,#007a4f)"><i class="fas fa-shield-heart"></i></div></div>
              <div class="tautan-logo-name">SatuSehat Kemenkes</div>
              <div class="tautan-logo-url">satusehat.kemkes.go.id</div>
            </a>
          </li>

          <li class="splide__slide">
            <a href="https://bengkuluprov.go.id" target="_blank" rel="noopener" class="tautan-logo-card" id="link-bengkulu">
              <div class="tautan-logo-img"><img src="https://www.google.com/s2/favicons?domain=bengkuluprov.go.id&sz=128" alt="Pemprov Bengkulu" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="tautan-logo-fallback" style="display:none;background:linear-gradient(135deg,#c0392b,#922b21)"><i class="fas fa-map-location-dot"></i></div></div>
              <div class="tautan-logo-name">Pemprov Bengkulu</div>
              <div class="tautan-logo-url">bengkuluprov.go.id</div>
            </a>
          </li>

          <li class="splide__slide">
            <a href="https://www.lapor.go.id" target="_blank" rel="noopener" class="tautan-logo-card" id="link-lapor">
              <div class="tautan-logo-img"><img src="https://www.google.com/s2/favicons?domain=lapor.go.id&sz=128" alt="Layanan LAPOR!" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="tautan-logo-fallback" style="display:none;background:linear-gradient(135deg,#e67e22,#ca6f1e)"><i class="fas fa-comments"></i></div></div>
              <div class="tautan-logo-name">Layanan LAPOR!</div>
              <div class="tautan-logo-url">lapor.go.id</div>
            </a>
          </li>

          <li class="splide__slide">
            <a href="https://data.go.id" target="_blank" rel="noopener" class="tautan-logo-card" id="link-datago">
              <div class="tautan-logo-img"><img src="https://www.google.com/s2/favicons?domain=data.go.id&sz=128" alt="Satu Data Indonesia" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="tautan-logo-fallback" style="display:none;background:linear-gradient(135deg,#2980b9,#1a5276)"><i class="fas fa-database"></i></div></div>
              <div class="tautan-logo-name">Portal Satu Data Indonesia</div>
              <div class="tautan-logo-url">data.go.id</div>
            </a>
          </li>

          <li class="splide__slide">
            <a href="https://dukcapil.kemendagri.go.id" target="_blank" rel="noopener" class="tautan-logo-card" id="link-dukcapil">
              <div class="tautan-logo-img"><img src="https://www.google.com/s2/favicons?domain=kemendagri.go.id&sz=128" alt="Dukcapil Kemendagri" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"><div class="tautan-logo-fallback" style="display:none;background:linear-gradient(135deg,#7d3c98,#6c3483)"><i class="fas fa-id-badge"></i></div></div>
              <div class="tautan-logo-name">Dukcapil Kemendagri</div>
              <div class="tautan-logo-url">kemendagri.go.id</div>
            </a>
          </li>

        </ul>
      </div>
    </div>

  </div>
</section>

<style>
/* ============================================================
   TAUTAN LOGO CAROUSEL
   ============================================================ */
.tautan-logo-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 1.5rem 1rem;
  background: var(--clr-white);
  border: 2px solid var(--clr-gray-100);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-sm);
  text-decoration: none;
  color: inherit;
  transition: all var(--transition-base);
  gap: 0.75rem;
  height: 100%;
  text-align: center;
}
.tautan-logo-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
  border-color: var(--clr-accent);
}
.tautan-logo-img {
  width: 72px; height: 72px;
  display: flex; align-items: center; justify-content: center;
  border-radius: var(--radius-lg);
  overflow: hidden;
}
.tautan-logo-img img {
  width: 100%; height: 100%;
  object-fit: contain;
}
.tautan-logo-fallback {
  width: 72px; height: 72px;
  border-radius: var(--radius-lg);
  background: linear-gradient(135deg, var(--clr-accent) 0%, var(--clr-secondary) 100%);
  display: flex; align-items: center; justify-content: center;
  color: white; font-size: 1.75rem;
}
.tautan-logo-name {
  font-family: var(--font-heading);
  font-size: 0.875rem;
  font-weight: 700;
  color: var(--clr-primary);
  line-height: 1.3;
}
.tautan-logo-url {
  font-size: 0.75rem;
  color: var(--clr-accent);
  font-weight: 500;
}
</style>


<!-- TENTANG KAMI -->
<section class="section" id="tentang" aria-labelledby="tentang-title">
  <div class="container">
    <div class="tentang-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;">
      <div class="reveal">
        <span class="section-label"><i class="fas fa-heart-pulse"></i> Tentang Kami</span>
        <h2 class="section-title" id="tentang-title" style="text-align:left;margin-bottom:1rem;">Lebih dari 4 Dekade<br>Melayani Masyarakat Ipuh</h2>

        <p style="color:var(--clr-gray-600);line-height:1.8;margin-bottom:1.5rem;"><?= htmlspecialchars($profil['sejarah'] ?? '') ?></p>
        <p style="color:var(--clr-gray-600);line-height:1.8;margin-bottom:2rem;"><strong style="color:var(--clr-primary);">Visi:</strong> <?= htmlspecialchars($profil['visi'] ?? '') ?></p>
        <a href="profil.php" class="btn btn-primary" id="tentang-profil-btn"><i class="fas fa-building"></i> Selengkapnya</a>
      </div>
      <div class="reveal">
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
          <?php
          $features = [
            ['fas fa-certificate',         '#4CAF82', 'Terakreditasi Resmi',    'Memiliki akreditasi dari Kemenkes RI sebagai fasilitas kesehatan tingkat pertama.'],
            ['fas fa-user-md',              '#2D7A4F', 'Tenaga Medis Kompeten',  'Dokter umum, dokter gigi, bidan, dan tenaga medis terlatih dan berpengalaman.'],
            ['fas fa-mobile-screen',        '#0284C7', 'Layanan Digital',        'Pendaftaran online, informasi fasilitas, dan pengaduan berbasis digital.'],
            ['fas fa-hand-holding-medical', '#D97706', 'Pelayanan Terjangkau',   'Menerima pasien BPJS, KIS, dan umum. Gratis untuk warga kurang mampu.'],
          ];
          foreach ($features as $f): ?>
          <div style="display:flex;gap:1rem;align-items:flex-start;padding:1.25rem;border-radius:var(--radius-lg);border:1px solid var(--clr-gray-100);background:var(--clr-white);">
            <div style="width:48px;height:48px;border-radius:var(--radius-md);background:<?= $f[1] ?>1a;display:flex;align-items:center;justify-content:center;color:<?= $f[1] ?>;font-size:1.2rem;flex-shrink:0;">
              <i class="<?= $f[0] ?>"></i>
            </div>
            <div>
              <h4 style="font-size:0.975rem;font-weight:700;color:var(--clr-gray-900);margin-bottom:4px;"><?= $f[2] ?></h4>
              <p style="font-size:0.85rem;color:var(--clr-gray-600);line-height:1.6;margin:0;"><?= $f[3] ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ULASAN PASIEN CAROUSEL -->
<section class="section section-alt" id="ulasan" aria-label="Ulasan Pasien">
  <div class="container">
    <div class="section-header">
      <span class="section-label"><i class="fas fa-star" style="color:#F59E0B;"></i> Ulasan Pasien</span>
      <h2 class="section-title">Apa Kata Mereka?</h2>
      <p class="section-subtitle">Ulasan dan pengalaman nyata masyarakat saat berobat di UPTD Puskesmas Ipuh.</p>
    </div>
    
    <div class="splide" id="ulasanSplide" aria-label="Kumpulan Ulasan">
      <div class="splide__track" style="padding-bottom:1rem; padding-top:1rem;">
        <ul class="splide__list">
          
          <li class="splide__slide">
            <div class="ulasan-card">
              <div class="ulasan-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
              <p class="ulasan-text">"Pelayanan sangat ramah dan dokter menjelaskan dengan detail. Ruang tunggu bersih dan antrean teratur. Sangat membantu warga Ipuh."</p>
              <div class="ulasan-author">
                <div class="ulasan-avatar"><i class="fas fa-user"></i></div>
                <div class="ulasan-name">Bu****n</div>
              </div>
            </div>
          </li>

          <li class="splide__slide">
            <div class="ulasan-card">
              <div class="ulasan-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
              <p class="ulasan-text">"Puskesmas sudah sangat modern, pendaftaran bisa online jadi tidak perlu antre dari subuh. Semoga pelayanannya dipertahankan terus."</p>
              <div class="ulasan-author">
                <div class="ulasan-avatar"><i class="fas fa-user"></i></div>
                <div class="ulasan-name">Si****i</div>
              </div>
            </div>
          </li>
          
          <li class="splide__slide">
            <div class="ulasan-card">
              <div class="ulasan-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
              <p class="ulasan-text">"Cepat tanggap saat ada kondisi darurat malam hari. Petugas IGD berjaga 24 jam dan sangat kooperatif. Terima kasih banyak."</p>
              <div class="ulasan-author">
                <div class="ulasan-avatar"><i class="fas fa-user"></i></div>
                <div class="ulasan-name">Ah****d</div>
              </div>
            </div>
          </li>

          <li class="splide__slide">
            <div class="ulasan-card">
              <div class="ulasan-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
              <p class="ulasan-text">"Dokter giginya sabar banget sama anak-anak, jadi anak gak takut kalau diajak periksa gigi. Mantap pelayanannya!"</p>
              <div class="ulasan-author">
                <div class="ulasan-avatar"><i class="fas fa-user"></i></div>
                <div class="ulasan-name">Ma****a</div>
              </div>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </div>
</section>

<style>
.ulasan-card { background: var(--clr-white); border: 1px solid var(--clr-gray-100); border-radius: var(--radius-xl); padding: 1.5rem; box-shadow: var(--shadow-sm); display: flex; flex-direction: column; gap: 0.75rem; height: 100%; transition: all var(--transition-base); }
.ulasan-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--clr-accent-light); }
.ulasan-stars { color: #F59E0B; font-size: 0.9rem; }
.ulasan-text { font-size: 0.95rem; color: var(--clr-gray-600); line-height: 1.6; font-style: italic; flex-grow: 1; margin:0;}
.ulasan-author { display: flex; align-items: center; gap: 12px; margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid var(--clr-gray-100); }
.ulasan-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--clr-gray-100); display: flex; align-items: center; justify-content: center; color: var(--clr-gray-400); font-size: 1.2rem; }
.ulasan-name { font-weight: 700; color: var(--clr-primary); font-size: 0.9rem; font-family: var(--font-heading); }
</style>

<style>
/* Hold/Press effect — desktop only */
@media (hover: hover) {
  .galeri-img-wrap img.hold-active {
    transform: scale(1.08) !important;
    filter: brightness(1.1);
    transition: transform 0.2s ease, filter 0.2s ease;
  }
  .tautan-logo-card.hold-active {
    transform: translateY(-8px) scale(1.03) !important;
    box-shadow: 0 16px 48px rgba(26,71,49,0.25) !important;
    border-color: var(--clr-accent) !important;
    transition: all 0.15s ease !important;
  }
  .tautan-logo-img img.hold-active {
    transform: scale(1.15);
    transition: transform 0.15s ease;
  }
}
</style>

<script>
// Hold/Press effect — desktop only
(function(){
  if (!window.matchMedia('(hover: hover)').matches) return;

  // Galeri images
  document.querySelectorAll('.galeri-img-wrap img').forEach(function(img){
    img.addEventListener('mousedown', function(){ img.classList.add('hold-active'); });
    img.addEventListener('mouseup',   function(){ img.classList.remove('hold-active'); });
    img.addEventListener('mouseleave',function(){ img.classList.remove('hold-active'); });
  });

  // Tautan logo cards
  document.querySelectorAll('.tautan-logo-card').forEach(function(card){
    var img = card.querySelector('.tautan-logo-img img');
    card.addEventListener('mousedown', function(){
      card.classList.add('hold-active');
      if(img) img.classList.add('hold-active');
    });
    card.addEventListener('mouseup', function(){
      card.classList.remove('hold-active');
      if(img) img.classList.remove('hold-active');
    });
    card.addEventListener('mouseleave', function(){
      card.classList.remove('hold-active');
      if(img) img.classList.remove('hold-active');
    });
  });
})();
</script>

<?php include '../includes/footer.php'; ?>
<div class="toast-container" id="toastContainer" aria-live="polite"></div>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('galeriSplide')) {
      new Splide('#galeriSplide', {
        type: 'loop',
        perPage: 1,
        autoplay: true,
        interval: 3000,
        pagination: true,
        arrows: false,
        drag: true,
      }).mount();
    }

    if (document.getElementById('tautanSplide')) {
      new Splide('#tautanSplide', {
        type: 'loop',
        perPage: 4,
        gap: '1.25rem',
        autoplay: true,
        interval: 2500,
        pagination: false,
        arrows: false,
        drag: true,
        breakpoints: {
          1024: { perPage: 3 },
          768:  { perPage: 2 },
          480:  { perPage: 1 }
        }
      }).mount();
    }

    if (document.getElementById('ulasanSplide')) {
      new Splide('#ulasanSplide', {
        type: 'loop',
        perPage: 3,
        gap: '1.5rem',
        autoplay: true,
        interval: 4000,
        pagination: true,
        arrows: false,
        breakpoints: {
          992: { perPage: 2 },
          768: { perPage: 1 }
        }
      }).mount();
    }
  });
</script>
<script src="../js/main.js?v=<?= time() ?>" defer></script>
</body>
</html>
