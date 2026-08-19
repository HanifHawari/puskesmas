<?php
// ============================================================
// KONFIGURASI DATABASE - SIPP UPTD PUSKESMAS IPUH
// ============================================================

$dbUrl = getenv('DATABASE_URL');

if ($dbUrl) {
    // Railway / Supabase Postgres
    $parsedUrl = parse_url($dbUrl);
    
    $scheme = ($parsedUrl['scheme'] === 'postgres' || $parsedUrl['scheme'] === 'postgresql') ? 'pgsql' : $parsedUrl['scheme'];
    $envHost = $parsedUrl['host'] ?? '';
    $envPort = $parsedUrl['port'] ?? '5432';
    $envDb   = ltrim($parsedUrl['path'], '/');
    $envUser = $parsedUrl['user'] ?? '';
    $envPass = $parsedUrl['pass'] ?? '';

    define('DB_DSN', "$scheme:host=$envHost;port=$envPort;dbname=$envDb");
} else {
    // Lokal Laragon
    $envHost = 'localhost';
    $envDb   = 'sipp_puskesmas';
    $envUser = 'root';
    $envPass = '';
    $envPort = '3306';
    define('DB_DSN', "mysql:host=$envHost;port=$envPort;dbname=$envDb;charset=utf8mb4");
}

define('DB_USER', $envUser ?? 'root');
define('DB_PASS', $envPass ?? '');

// Base URL
$appUrl = getenv('RAILWAY_PUBLIC_DOMAIN') ? 'https://' . getenv('RAILWAY_PUBLIC_DOMAIN') : 'http://localhost/website%20SIPP';
define('BASE_URL', $appUrl);
define('BASE_PATH', dirname(__DIR__));

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('<div style="font-family:sans-serif;padding:2rem;background:#fee;color:#900;border:1px solid #f99;border-radius:8px;">
                <strong>Koneksi Database Gagal!</strong><br>
                Detail: ' . $e->getMessage() . '
                </div>');
        }
    }
    return $pdo;
}
