<?php
// get_pengaduan.php — AJAX endpoint tracking pengaduan
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/functions.php';

$kode = strtoupper(trim($_GET['kode'] ?? ''));
if (!$kode) {
    echo json_encode(['found' => false]);
    exit;
}

$pengaduan = getPengaduanByKode($kode);
if (!$pengaduan) {
    echo json_encode(['found' => false]);
    exit;
}

echo json_encode([
    'found'      => true,
    'kode'       => $pengaduan['kode_pengaduan'],
    'kategori'   => $pengaduan['kategori'],
    'judul'      => $pengaduan['judul'],
    'status'     => $pengaduan['status'],
    'created_at' => formatTanggal(substr($pengaduan['created_at'], 0, 10)),
    'updated_at' => formatTanggal(substr($pengaduan['updated_at'], 0, 10)),
    'catatan'    => $pengaduan['catatan_admin'] ?? '',
]);
