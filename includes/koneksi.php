<?php
// Baca environment variables dari sistem (Railway/Docker) atau fallback ke default local
$host = getenv('DB_HOST') ?: "localhost";
$port = getenv('DB_PORT') ?: "5432";
$db   = getenv('DB_NAME') ?: "defaultdb";
$user = getenv('DB_USER') ?: "postgres";
$pass = getenv('DB_PASS') ?: "postgres";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
