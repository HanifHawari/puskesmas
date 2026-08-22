<?php
// ============================================================
// NAVBAR COMPONENT - SIPP UPTD PUSKESMAS IPUH
// Usage: include 'includes/navbar.php';
// Set $activePage before including (e.g. $activePage = 'beranda')
// ============================================================
$activePage = $activePage ?? '';
?>
<nav class="navbar" id="mainNavbar">
  <div class="navbar-inner">

    <!-- Logo -->
    <a href="index.php" class="navbar-logo">
      <img src="../assets/logo.png" alt="Logo UPTD Puskesmas Ipuh">
      <div class="navbar-logo-text">
        <span class="logo-title">PUSKESMAS IPUH</span>
        <span class="logo-sub">KAB. MUKOMUKO</span>
      </div>
    </a>

    <!-- Mobile Hamburger -->
    <button class="hamburger" id="hamburgerBtn" aria-label="Buka Menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

    <!-- Nav Menu -->
    <ul class="navbar-menu" id="navMenu" role="menubar">
      <li role="none">
        <a href="index.php"
           class="nav-link <?= $activePage === 'beranda' ? 'active' : '' ?>"
           role="menuitem">
          Beranda
        </a>
      </li>
      <li role="none">
        <a href="profil.php"
           class="nav-link <?= $activePage === 'profil' ? 'active' : '' ?>"
           role="menuitem">
          Profil
        </a>
      </li>
      <li role="none">
        <a href="pendaftaran.php"
           class="nav-link <?= $activePage === 'pendaftaran' ? 'active' : '' ?>"
           role="menuitem">
          Pendaftaran
        </a>
      </li>
      <li role="none">
        <a href="pengaduan.php"
           class="nav-link <?= $activePage === 'pengaduan' ? 'active' : '' ?>"
           role="menuitem">
          Pengaduan
        </a>
      </li>
      <li role="none">
        <a href="fasilitas.php"
           class="nav-link <?= $activePage === 'fasilitas' ? 'active' : '' ?>"
           role="menuitem">
          Fasilitas
        </a>
      </li>

    </ul>

  </div>

  <!-- Mobile Overlay -->
  <div class="navbar-overlay" id="navOverlay"></div>
</nav>
