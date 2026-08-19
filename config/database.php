<?php
// ============================================================
// KONFIGURASI DATABASE - SIPP UPTD PUSKESMAS IPUH
// ============================================================

$mysqlUrl = getenv('MYSQL_URL') ?: $_ENV['MYSQL_URL'] ?? null;

if ($mysqlUrl && is_string($mysqlUrl) && strpos($mysqlUrl, '${{') === false) {
    $parsed = parse_url($mysqlUrl);
    $envHost = $parsed['host'] ?? 'mysql.railway.internal';
    $envUser = $parsed['user'] ?? 'root';
    $envPass = $parsed['pass'] ?? '';
    $envDb   = isset($parsed['path']) ? ltrim($parsed['path'], '/') : 'railway';
    $envPort = $parsed['port'] ?? '3306';
} else {
    // Fallback jika MYSQL_URL gagal dibaca
    $envHost = getenv('MYSQLHOST') ?: 'mysql.railway.internal';
    if (!is_string($envHost) || strpos($envHost, '${{') !== false) $envHost = 'mysql.railway.internal';

    $envDb = getenv('MYSQLDATABASE') ?: 'railway';
    if (!is_string($envDb) || strpos($envDb, '${{') !== false) $envDb = 'railway';

    $envPass = getenv('MYSQLPASSWORD') ?: 'pOYFWyPDVSnlgLwXrwJhFvqiODauJXAP';
    if (!is_string($envPass) || strpos($envPass, '${{') !== false) $envPass = 'pOYFWyPDVSnlgLwXrwJhFvqiODauJXAP';
    
    $envUser = 'root';
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
