<?php
// ============================================================
// PROCESS PENDAFTARAN — SIPP UPTD PUSKESMAS IPUH
// ============================================================
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Collect & sanitize input
$data = [
    'jenis_pasien'  => in_array($_POST['jenis_pasien'] ?? '', ['Baru','Lama']) ? $_POST['jenis_pasien'] : 'Baru',
    'nik'           => preg_replace('/\D/', '', $_POST['nik'] ?? ''),
    'nama'          => trim($_POST['nama'] ?? ''),
    'tgl_lahir'     => $_POST['tgl_lahir'] ?? '',
    'jenis_kelamin' => in_array($_POST['jenis_kelamin'] ?? '', ['L','P']) ? $_POST['jenis_kelamin'] : 'L',
    'no_hp'         => trim($_POST['no_hp'] ?? ''),
    'alamat'        => trim($_POST['alamat'] ?? ''),
    'jenis_kartu'   => in_array($_POST['jenis_kartu'] ?? '', ['Umum','BPJS','KIS','Askes']) ? $_POST['jenis_kartu'] : 'Umum',
    'no_kartu'      => trim($_POST['no_kartu'] ?? ''),
    'poli_id'       => (int)($_POST['poli_id'] ?? 0),
    'keluhan'       => trim($_POST['keluhan'] ?? ''),
    'tgl_kunjungan' => $_POST['tgl_kunjungan'] ?? '',
    'sesi'          => in_array($_POST['sesi'] ?? '', ['Pagi','Siang']) ? $_POST['sesi'] : 'Pagi',
];

// Validation
$errors = [];
if (strlen($data['nik']) !== 16) {
    $errors[] = 'NIK harus 16 digit';
}
if (strlen($data['nama']) < 3) {
    $errors[] = 'Nama tidak valid';
}
if (empty($data['tgl_lahir']) || !strtotime($data['tgl_lahir'])) {
    $errors[] = 'Tanggal lahir tidak valid';
}
if (!preg_match('/^(0|\+62|62)8[1-9][0-9]{7,11}$/', preg_replace('/\s/', '', $data['no_hp']))) {
    $errors[] = 'Nomor HP tidak valid';
}
if (empty($data['alamat'])) {
    $errors[] = 'Alamat tidak boleh kosong';
}
if ($data['poli_id'] <= 0) {
    $errors[] = 'Pilih poli terlebih dahulu';
}
if (empty($data['tgl_kunjungan']) || !strtotime($data['tgl_kunjungan'])) {
    $errors[] = 'Tanggal kunjungan tidak valid';
}

// Check poli exists and open
$poli = getPoliById($data['poli_id']);
if (!$poli) {
    $errors[] = 'Poli tidak ditemukan';
} elseif ($poli['status'] === 'Tutup') {
    $errors[] = 'Poli sedang tutup';
}

// Check kuota
if (empty($errors)) {
    $kuotaTersisa = getKuotaTersisa($data['poli_id'], $data['sesi'], $data['tgl_kunjungan']);
    if ($data['sesi'] === 'Siang' && $poli['kuota_siang'] == 0) {
        $errors[] = 'Poli ini tidak memiliki sesi siang';
    } elseif ($kuotaTersisa <= 0) {
        $errors[] = 'Kuota sesi ' . $data['sesi'] . ' sudah penuh untuk tanggal tersebut';
    }
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
    exit;
}

try {
    $noAntrian = savePendaftaran($data);
    echo json_encode([
        'success'    => true,
        'no_antrian' => $noAntrian,
        'nama'       => $data['nama'],
        'poli'       => $poli['nama_poli'],
        'tanggal'    => $data['tgl_kunjungan'],
        'sesi'       => $data['sesi'],
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan data: ' . $e->getMessage()]);
}
