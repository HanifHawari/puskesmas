<?php
// ============================================================
// KONFIGURASI DATABASE - SIPP UPTD PUSKESMAS IPUH
// ============================================================

define('DB_HOST', getenv('MYSQL_HOST') ?: getenv('MYSQLHOST') ?: $_ENV['MYSQLHOST'] ?? $_SERVER['MYSQLHOST'] ?? 'mysql.railway.internal');
define('DB_NAME', getenv('MYSQLDATABASE') ?: getenv('MYSQL_DATABASE') ?: $_ENV['MYSQLDATABASE'] ?? $_ENV['MYSQL_DATABASE'] ?? $_SERVER['MYSQLDATABASE'] ?? 'railway');
define('DB_USER', getenv('MYSQL_USER') ?: getenv('MYSQLUSER') ?: $_ENV['MYSQLUSER'] ?? $_SERVER['MYSQLUSER'] ?? 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: getenv('MYSQL_PASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD') ?: $_ENV['MYSQLPASSWORD'] ?? $_SERVER['MYSQLPASSWORD'] ?? 'pOYFWyPDVSnlgLwXrwJhFvqiODauJXAP');
define('DB_PORT', getenv('MYSQL_PORT') ?: getenv('MYSQLPORT') ?: $_ENV['MYSQLPORT'] ?? $_SERVER['MYSQLPORT'] ?? '3306');
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
