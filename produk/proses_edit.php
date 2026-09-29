<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$id         = $_POST['id'] ?? null;
$namaProduk = trim($_POST['nama_produk'] ?? '');
$harga      = trim($_POST['harga'] ?? '');
$kodeProduk = trim($_POST['kode_produk'] ?? '');
$stok       = $_POST['stok'] ?? '';
$kategori   = trim($_POST['kategori'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

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
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE produk SET nama_produk = :nama_produk, harga = :harga,
     kode_produk = :kode_produk, stok = :stok, kategori = :kategori
     WHERE id = :id"
);
$stmt->execute([
    'nama_produk' => $namaProduk,
    'harga'       => (float) $harga,
    'kode_produk' => $kodeProduk,
    'stok'        => (int) $stok,
    'kategori'    => $kategori,
    'id'          => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Produk berhasil diperbarui.'];
header('Location: list.php');
exit;
