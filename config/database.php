<?php
// ============================================================
// KONFIGURASI DATABASE - SIPP UPTD PUSKESMAS IPUH
// ============================================================

$isRailway = getenv('RAILWAY_ENVIRONMENT') || getenv('RAILWAY_PUBLIC_DOMAIN') || isset($_SERVER['RAILWAY_PUBLIC_DOMAIN']);

if ($isRailway) {
    // 100% JALUR BYPASS - TANPA BACA VARIABEL RAILWAY SAMA SEKALI
    // Menggunakan jalur TCP Proxy (sama seperti HeidiSQL) yang sudah pasti jalan
    $envHost = 'altaria.proxy.rlwy.net';
    $envDb   = 'railway';
    $envUser = 'root';
    $envPass = 'pOYFWyPDVSnlgLwXrwJhFvqiODauJXAP';
    $envPort = '34261';
} else {
    // LOKAL LARAGON
    $envHost = 'localhost';
    $envDb   = 'sipp_puskesmas';
    $envUser = 'root';
    $envPass = '';
    $envPort = '3306';
}

define('DB_HOST', $envHost);
define('DB_NAME', $envDb);
define('DB_USER', $envUser);
define('DB_PASS', $envPass);
define('DB_PORT', $envPort);
define('DB_CHARSET', 'utf8mb4');

// Base URL (sesuaikan jika folder berbeda)
$appUrl = getenv('RAILWAY_PUBLIC_DOMAIN') ? 'https://' . getenv('RAILWAY_PUBLIC_DOMAIN') : 'http://localhost/website%20SIPP';
define('BASE_URL', $appUrl);
define('BASE_PATH', dirname(__DIR__));

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('<div style="font-family:sans-serif;padding:2rem;background:#fee;color:#900;border:1px solid #f99;border-radius:8px;">
                <strong>Koneksi Database Gagal!</strong><br>
                Mencoba terhubung ke: <strong>' . DB_HOST . '</strong> (Database: <strong>' . DB_NAME . '</strong>)<br>
                Detail: ' . $e->getMessage() . '
                </div>');
        }
    }
    return $pdo;
}
