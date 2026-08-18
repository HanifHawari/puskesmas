<?php
// ============================================================
// FOOTER COMPONENT - SIPP UPTD PUSKESMAS IPUH
// ============================================================
if (!function_exists('getProfil')) {
    require_once __DIR__ . '/functions.php';
}
$profil = getProfil();
$tahun  = date('Y');
?>
<footer class="footer">
  <div class="container">
    <div class="footer-grid">

      <!-- Brand Column -->
      <div class="footer-brand">
        <a href="index.php" class="footer-logo">
          <img src="assets/logo.png" alt="Logo Puskesmas Ipuh">
          <div class="footer-logo-text">
            <span class="logo-title">PUSKESMAS IPUH</span>
            <span class="logo-sub">KAB. MUKOMUKO</span>
          </div>
        </a>
        <p class="footer-desc">
          Melayani masyarakat Kecamatan Ipuh dengan sepenuh hati.
          Kesehatan Anda adalah prioritas kami.
        </p>
        <div class="footer-social">
          <a href="#" class="footer-social-link" title="Facebook" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="footer-social-link" title="Instagram" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://wa.me/6282xxxxxxxx" class="footer-social-link" title="WhatsApp" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="mailto:<?= htmlspecialchars($profil['email'] ?? '') ?>" class="footer-social-link" title="Email" aria-label="Email">
            <i class="fas fa-envelope"></i>
          </a>
        </div>
      </div>

      <!-- Nav Links -->
      <div>
        <h3 class="footer-section-title">Menu</h3>
        <ul class="footer-links">
          <li><a href="index.php"       class="footer-link"><i class="fas fa-chevron-right"></i> Beranda</a></li>
          <li><a href="profil.php"      class="footer-link"><i class="fas fa-chevron-right"></i> Profil Puskesmas</a></li>
          <li><a href="profil.php#maklumat" class="footer-link"><i class="fas fa-chevron-right"></i> Maklumat Pelayanan</a></li>
          <li><a href="pendaftaran.php" class="footer-link"><i class="fas fa-chevron-right"></i> Pendaftaran Online</a></li>
          <li><a href="pengaduan.php"   class="footer-link"><i class="fas fa-chevron-right"></i> Pengaduan</a></li>
          <li><a href="fasilitas.php"   class="footer-link"><i class="fas fa-chevron-right"></i> Fasilitas</a></li>
        </ul>
      </div>

      <!-- Layanan -->
      <div>
        <h3 class="footer-section-title">Layanan</h3>
        <ul class="footer-links">
          <li><a href="pendaftaran.php" class="footer-link"><i class="fas fa-chevron-right"></i> Poli Umum</a></li>
          <li><a href="pendaftaran.php" class="footer-link"><i class="fas fa-chevron-right"></i> Poli Gigi</a></li>
          <li><a href="pendaftaran.php" class="footer-link"><i class="fas fa-chevron-right"></i> Poli KIA / KB</a></li>
          <li><a href="pendaftaran.php" class="footer-link"><i class="fas fa-chevron-right"></i> Poli Anak (MTBS)</a></li>
          <li><a href="fasilitas.php"   class="footer-link"><i class="fas fa-chevron-right"></i> IGD 24 Jam</a></li>
          <li><a href="fasilitas.php"   class="footer-link"><i class="fas fa-chevron-right"></i> Laboratorium</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h3 class="footer-section-title">Kontak</h3>
        <div class="footer-contacts">
          <div class="footer-contact-item">
            <div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
            <span><?= htmlspecialchars($profil['alamat'] ?? 'Jl. Kesehatan No.1, Ipuh, Mukomuko') ?></span>
          </div>
          <div class="footer-contact-item">
            <div class="footer-contact-icon"><i class="fas fa-phone-alt"></i></div>
            <span><?= htmlspecialchars($profil['telp'] ?? '-') ?></span>
          </div>
          <div class="footer-contact-item">
            <div class="footer-contact-icon"><i class="fas fa-envelope"></i></div>
            <span><?= htmlspecialchars($profil['email'] ?? '-') ?></span>
          </div>
        </div>


      </div>

    </div><!-- /.footer-grid -->

    <!-- Footer Bottom -->
    <div class="footer-bottom">
      <span>
        &copy; <?= $tahun ?> UPTD Puskesmas Ipuh &mdash; Kabupaten Mukomuko, Bengkulu.
        Hak cipta dilindungi.
      </span>
    </div>

  </div><!-- /.container -->
</footer>
