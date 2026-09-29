<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$namaProduk = trim($_POST['nama_produk'] ?? '');
$harga      = trim($_POST['harga'] ?? '');
$kodeProduk = trim($_POST['kode_produk'] ?? '');
$stok       = $_POST['stok'] ?? '';
$kategori   = trim($_POST['kategori'] ?? '');

$errors = [];
if ($namaProduk === '') {
    $errors[] = "Nama produk wajib diisi.";
}
if (!is_numeric($harga) || (int) $harga < 0) {
    $errors[] = "Harga harus berupa angka positif.";
}
if (!is_numeric($stok) || (int) $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO produk (nama_produk, harga, kode_produk, stok, kategori)
     VALUES (:nama_produk, :harga, :kode_produk, :stok, :kategori)
     RETURNING id"
);
$stmt->execute([
    'nama_produk' => $namaProduk,
    'harga'       => (float) $harga,
    'kode_produk' => $kodeProduk,
    'stok'        => (int) $stok,
    'kategori'    => $kategori,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Produk berhasil ditambahkan.'];
header('Location: list.php');
exit;
