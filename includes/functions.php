<?php
// ============================================================
// HELPER FUNCTIONS - SIPP UPTD PUSKESMAS IPUH
// ============================================================

require_once __DIR__ . '/../config/database.php';

// ---- PROFIL --------------------------------------------------
function getProfil(): array {
    $pdo  = getPDO();
    $rows = $pdo->query("SELECT key_name, value FROM profil_puskesmas")->fetchAll();
    $data = [];
    foreach ($rows as $row) {
        $data[$row['key_name']] = $row['value'];
    }
    return $data;
}

// ---- POLI ----------------------------------------------------
function getAllPoli(): array {
    return getPDO()->query("SELECT * FROM poli ORDER BY urutan ASC")->fetchAll();
}

function getPoliById(int $id): ?array {
    $stmt = getPDO()->prepare("SELECT * FROM poli WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

// ---- PENDAFTARAN ---------------------------------------------
function generateNoAntrian(int $poliId, string $sesi, string $tglKunjungan): string {
    $pdo  = getPDO();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pendaftaran WHERE poli_id = ? AND sesi = ? AND tgl_kunjungan = ?");
    $stmt->execute([$poliId, $sesi, $tglKunjungan]);
    $count     = (int)$stmt->fetchColumn() + 1;
    $prefix    = ($sesi === 'Pagi') ? 'P' : 'S';
    $poliCode  = str_pad($poliId, 2, '0', STR_PAD_LEFT);
    return $prefix . $poliCode . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
}

function savePendaftaran(array $data): string {
    $pdo          = getPDO();
    $noAntrian    = generateNoAntrian((int)$data['poli_id'], $data['sesi'], $data['tgl_kunjungan']);
    $stmt = $pdo->prepare("
        INSERT INTO pendaftaran
          (no_antrian, nik, nama, tgl_lahir, jenis_kelamin, no_hp, alamat,
           jenis_kartu, no_kartu, jenis_pasien, poli_id, keluhan, tgl_kunjungan, sesi)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $noAntrian,
        $data['nik'],
        $data['nama'],
        $data['tgl_lahir'],
        $data['jenis_kelamin'],
        $data['no_hp'],
        $data['alamat'],
        $data['jenis_kartu'],
        $data['no_kartu'] ?? '',
        $data['jenis_pasien'],
        $data['poli_id'],
        $data['keluhan'] ?? '',
        $data['tgl_kunjungan'],
        $data['sesi'],
    ]);
    return $noAntrian;
}

function getKuotaTersisa(int $poliId, string $sesi, string $tglKunjungan): int {
    $poli = getPoliById($poliId);
    if (!$poli) return 0;
    $kuota = ($sesi === 'Pagi') ? $poli['kuota_pagi'] : $poli['kuota_siang'];
    $pdo   = getPDO();
    $stmt  = $pdo->prepare("SELECT COUNT(*) FROM pendaftaran WHERE poli_id=? AND sesi=? AND tgl_kunjungan=?");
    $stmt->execute([$poliId, $sesi, $tglKunjungan]);
    $terisi = (int)$stmt->fetchColumn();
    return max(0, $kuota - $terisi);
}

// ---- PENGADUAN -----------------------------------------------
function generateKodePengaduan(): string {
    do {
        $kode = 'ADU-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $stmt = getPDO()->prepare("SELECT COUNT(*) FROM pengaduan WHERE kode_pengaduan = ?");
        $stmt->execute([$kode]);
    } while ($stmt->fetchColumn() > 0);
    return $kode;
}

function savePengaduan(array $data, ?string $fileBukti = null): string {
    $kode = generateKodePengaduan();
    $stmt = getPDO()->prepare("
        INSERT INTO pengaduan
          (kode_pengaduan, nama_pelapor, no_hp, kategori, judul, isi_pengaduan, tgl_kejadian, file_bukti)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $kode,
        $data['nama_pelapor'] ?: 'Anonim',
        $data['no_hp'] ?? '',
        $data['kategori'],
        $data['judul'],
        $data['isi_pengaduan'],
        $data['tgl_kejadian'],
        $fileBukti,
    ]);
    return $kode;
}

function getPengaduanByKode(string $kode): ?array {
    $stmt = getPDO()->prepare("SELECT * FROM pengaduan WHERE kode_pengaduan = ?");
    $stmt->execute([$kode]);
    return $stmt->fetch() ?: null;
}

// ---- FASILITAS -----------------------------------------------
function getAllFasilitas(): array {
    return getPDO()->query("SELECT * FROM fasilitas ORDER BY kategori, id")->fetchAll();
}

// ---- PENGUMUMAN ----------------------------------------------
function getPengumumanAktif(): array {
    return getPDO()->query("SELECT * FROM pengumuman WHERE aktif = 1 ORDER BY tipe DESC, created_at DESC")->fetchAll();
}

// ---- TENAGA MEDIS --------------------------------------------
function getAllTenagaMedis(): array {
    return getPDO()->query("
        SELECT tm.*, p.nama_poli
        FROM tenaga_medis tm
        LEFT JOIN poli p ON tm.poli_id = p.id
        ORDER BY tm.urutan ASC
    ")->fetchAll();
}

// ---- UTILITIES -----------------------------------------------
function sanitize(string $str): string {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void {
    header("Location: $url");
    exit;
}

function formatTanggal(string $date): string {
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
              'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $d = explode('-', $date);
    return (int)$d[2] . ' ' . ($bulan[(int)$d[1]] ?? '') . ' ' . $d[0];
}

function uploadFile(array $file, string $folder): ?string {
    if ($file['error'] !== UPLOAD_ERR_OK) return null;
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
    if (!in_array($file['type'], $allowedTypes)) return null;
    if ($file['size'] > 5 * 1024 * 1024) return null; // max 5MB

    $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('bukti_', true) . '.' . $ext;
    $destDir  = BASE_PATH . '/assets/uploads/' . $folder . '/';
    if (!is_dir($destDir)) mkdir($destDir, 0755, true);
    if (move_uploaded_file($file['tmp_name'], $destDir . $filename)) {
        return $filename;
    }
    return null;
}

function getStatusBadgeClass(string $status): string {
    return match($status) {
        'Buka', 'Tersedia', 'Selesai'   => 'badge-success',
        'Penuh', 'Hampir Penuh', 'Diproses' => 'badge-warning',
        'Tutup', 'Tidak Tersedia', 'Diterima' => 'badge-danger',
        default                          => 'badge-info',
    };
}
