<?php
// ============================================================
// SCRIPT CLEANUP DATA LAMA (Untuk menghemat penyimpanan DB)
// ============================================================
require_once 'config/database.php';
require_once '../includes/functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_old_data'])) {
        try {
            $pdo = getPDO();
            // Hapus data pendaftaran dan pengaduan yang lebih dari 30 hari
            $date30DaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
            
            $stmt1 = $pdo->prepare("DELETE FROM pendaftaran WHERE created_at < ?");
            $stmt1->execute([$date30DaysAgo]);
            $deletedPendaftaran = $stmt1->rowCount();

            $stmt2 = $pdo->prepare("DELETE FROM pengaduan WHERE created_at < ?");
            $stmt2->execute([$date30DaysAgo]);
            $deletedPengaduan = $stmt2->rowCount();

            $message = "<div style='color:green; font-weight:bold;'>Berhasil menghapus {$deletedPendaftaran} data pendaftaran dan {$deletedPengaduan} data pengaduan lama (lebih dari 30 hari).</div>";
        } catch (Exception $e) {
            $message = "<div style='color:red;'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cleanup Database</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; background: #f4f4f4; }
        .container { background: #fff; padding: 2rem; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn { padding: 10px 20px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        .btn:hover { background: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <h2>🛠️ Pembersihan Database (Cleanup)</h2>
        <p>Hapus data <strong>Pendaftaran</strong> dan <strong>Pengaduan</strong> yang umurnya sudah lebih dari 30 hari untuk menghemat kapasitas penyimpanan Supabase/Railway Anda.</p>
        
        <?= $message ? "<p>$message</p>" : '' ?>

        <form method="POST" onsubmit="return confirm('Yakin ingin menghapus semua data transaksi yang lebih lama dari 30 hari? Tindakan ini tidak bisa dibatalkan!');">
            <button type="submit" name="delete_old_data" class="btn">🗑️ Hapus Data Lama (> 30 Hari)</button>
        </form>
    </div>
</body>
</html>
