<?php
// get_kuota.php — AJAX endpoint untuk mengecek kuota sisa
header('Content-Type: application/json');
require_once '../includes/functions.php';

$poliId = (int)($_GET['poli_id'] ?? 0);
$tgl    = $_GET['tgl'] ?? '';

if (!$poliId || !$tgl) {
    echo json_encode(['pagi' => '-', 'siang' => '-']);
    exit;
}

$poli = getPoliById($poliId);
if (!$poli) {
    echo json_encode(['pagi' => '-', 'siang' => '-']);
    exit;
}

$pagi  = getKuotaTersisa($poliId, 'Pagi', $tgl);
$siang = $poli['kuota_siang'] > 0 ? getKuotaTersisa($poliId, 'Siang', $tgl) : 'Tidak ada';

echo json_encode(['pagi' => $pagi, 'siang' => $siang]);
