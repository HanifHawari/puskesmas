<?php
// ============================================================
// HALAMAN SUKSES PENDAFTARAN — SIPP UPTD PUSKESMAS IPUH
// ============================================================
require_once 'includes/functions.php';

$activePage  = 'pendaftaran';
$noAntrian   = htmlspecialchars($_GET['no']   ?? '');
$namaPasien  = htmlspecialchars($_GET['nama'] ?? 'Pasien');

if (!$noAntrian) {
    header('Location: pendaftaran.php');
    exit;
}

$pageTitle = 'Pendaftaran Berhasil SIPP UPTD Puskesmas Ipuh';
$extraHead = <<<HTML
  <style>
    .success-wrapper {
      min-height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 4rem var(--space-xl);
    }
    .success-card {
      background: var(--clr-white);
      border-radius: var(--radius-xl);
      box-shadow: var(--shadow-xl);
      border: 1px solid var(--clr-gray-100);
      max-width: 560px;
      width: 100%;
      text-align: center;
      padding: 3rem 2.5rem;
      animation: fadeInUp 0.5s ease;
    }
    .success-icon {
      width: 90px; height: 90px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--clr-accent) 0%, var(--clr-secondary) 100%);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2.5rem;
      color: white;
      box-shadow: 0 8px 32px rgba(76,175,130,0.35);
      animation: pulse 2s ease infinite;
    }
    .antrian-box {
      background: linear-gradient(135deg, var(--clr-primary) 0%, var(--clr-secondary) 100%);
      border-radius: var(--radius-xl);
      padding: 2rem;
      margin: 1.5rem 0;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .antrian-box::before {
      content: '';
      position: absolute; inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='20' cy='20' r='2'/%3E%3C/g%3E%3C/svg%3E");
    }
    .antrian-label {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: rgba(255,255,255,0.7);
      margin-bottom: 0.5rem;
      position: relative;
    }
    .antrian-number {
      font-family: var(--font-heading);
      font-size: 3.5rem;
      font-weight: 900;
      color: white;
      letter-spacing: 0.05em;
      position: relative;
    }
    .print-btn {
      position: absolute;
      top: 1rem; right: 1rem;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.25);
      border-radius: var(--radius-md);
      padding: 6px 12px;
      color: white;
      cursor: pointer;
      font-size: 0.8rem;
      font-family: var(--font-body);
      display: flex; align-items: center; gap: 6px;
      transition: all 0.2s;
    }
    .print-btn:hover { background: rgba(255,255,255,0.25); }
    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.65rem 0;
      border-bottom: 1px solid var(--clr-gray-100);
      font-size: 0.9rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row-label { color: var(--clr-gray-500); }
    .info-row-value { font-weight: 600; color: var(--clr-gray-800); }

    @media print {
      .navbar, footer, .no-print { display: none !important; }
      .success-wrapper { min-height: auto; padding: 0; }
      .success-card { box-shadow: none; border: 1px solid #ccc; max-width: 100%; }
    }
  </style>
HTML;
include 'includes/header.php';
?>

<?php include 'includes/navbar.php'; ?>

<main style="padding-top: var(--navbar-height);">
  <div class="success-wrapper">
    <div class="success-card">
      <div class="success-icon">
        <i class="fas fa-check"></i>
      </div>

      <h1 style="font-size:1.5rem;color:var(--clr-primary);margin-bottom:0.5rem;">
        Pendaftaran Berhasil!
      </h1>
      <p style="color:var(--clr-gray-600);margin-bottom:0;">
        Halo <strong><?= $namaPasien ?></strong>, pendaftaran Anda telah diterima.
      </p>

      <!-- Nomor Antrian Box -->
      <div class="antrian-box">
        <button class="print-btn no-print" onclick="window.print()">
          <i class="fas fa-print"></i> Cetak
        </button>
        <div class="antrian-label">Nomor Antrian Anda</div>
        <div class="antrian-number"><?= $noAntrian ?></div>
        <div style="font-size:0.8rem;color:rgba(255,255,255,0.65);margin-top:0.5rem;position:relative;">
          Simpan nomor ini sebagai bukti pendaftaran
        </div>
      </div>

      <!-- Info Box -->
      <div style="background:var(--clr-gray-50);border-radius:var(--radius-lg);padding:1.25rem;margin-bottom:1.5rem;text-align:left;">
        <div class="info-row">
          <span class="info-row-label"><i class="fas fa-user" style="color:var(--clr-accent);width:16px;"></i> Nama</span>
          <span class="info-row-value"><?= $namaPasien ?></span>
        </div>
        <div class="info-row">
          <span class="info-row-label"><i class="fas fa-hashtag" style="color:var(--clr-accent);width:16px;"></i> No. Antrian</span>
          <span class="info-row-value"><?= $noAntrian ?></span>
        </div>
      </div>

      <!-- Info Penting -->
      <div class="alert alert-info" style="text-align:left;margin-bottom:1.5rem;">
        <i class="fas fa-info-circle"></i>
        <div style="font-size:0.875rem;line-height:1.6;">
          <strong>Harap diperhatikan:</strong><br>
          • Hadir 15 menit sebelum jadwal<br>
          • Bawa kartu identitas (KTP/KK) dan kartu jaminan<br>
          • Nomor antrian dipanggil sesuai urutan
        </div>
      </div>

      <!-- Action Buttons -->
      <div style="display:flex;gap:0.75rem;flex-wrap:wrap;" class="no-print">
        <a href="index.php" class="btn btn-outline" style="flex:1;" id="sukses-beranda-btn">
          <i class="fas fa-home"></i> Beranda
        </a>
        <a href="pendaftaran.php" class="btn btn-primary" style="flex:1;" id="sukses-daftar-lagi-btn">
          <i class="fas fa-plus"></i> Daftar Lagi
        </a>
      </div>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
<script src="js/main.js"></script>
</body>
</html>
