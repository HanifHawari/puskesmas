<?php
// process_pengaduan.php
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$data = [
    'nama_pelapor' => trim($_POST['nama_pelapor'] ?? '') ?: 'Anonim',
    'no_hp'        => trim($_POST['no_hp'] ?? ''),
    'kategori'     => $_POST['kategori'] ?? '',
    'judul'        => trim($_POST['judul'] ?? ''),
    'isi_pengaduan'=> trim($_POST['isi_pengaduan'] ?? ''),
    'tgl_kejadian' => $_POST['tgl_kejadian'] ?? '',
];

$validKategori = [
    'Pelayanan Petugas','Fasilitas & Kebersihan','Waktu Tunggu',
    'Prosedur & Administrasi','Obat-obatan','Lain-lain / Saran'
];

$errors = [];
if (!in_array($data['kategori'], $validKategori)) $errors[] = 'Kategori tidak valid';
if (strlen($data['judul']) < 3)                   $errors[] = 'Judul terlalu pendek';
if (strlen($data['isi_pengaduan']) < 20)          $errors[] = 'Isi pengaduan terlalu singkat';
if (!$data['tgl_kejadian'])                       $errors[] = 'Tanggal kejadian wajib diisi';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
    exit;
}

// Handle file upload
$fileBukti = null;
if (!empty($_FILES['file_bukti']['name'])) {
    $fileBukti = uploadFile($_FILES['file_bukti'], 'pengaduan');
}

try {
    $kode = savePengaduan($data, $fileBukti);
    echo json_encode(['success' => true, 'kode' => $kode, 'message' => 'Pengaduan berhasil dikirim']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan: ' . $e->getMessage()]);
}
