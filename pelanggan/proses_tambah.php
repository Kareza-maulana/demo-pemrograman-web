<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$namaPelanggan = trim($_POST['nama_pelanggan'] ?? '');
$kodePelanggan = trim($_POST['kode_pelanggan'] ?? '');
$alamat        = trim($_POST['alamat'] ?? '');
$noHp          = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($namaPelanggan === '') {
    $errors[] = "Nama pelanggan wajib diisi.";
}
if ($kodePelanggan === '') {
    $errors[] = "Kode pelanggan wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO pelanggan (nama_pelanggan, kode_pelanggan, alamat, no_hp)
     VALUES (:nama_pelanggan, :kode_pelanggan, :alamat, :no_hp)
     RETURNING id"
);
$stmt->execute([
    'nama_pelanggan' => $namaPelanggan,
    'kode_pelanggan' => $kodePelanggan,
    'alamat'         => $alamat,
    'no_hp'          => $noHp,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pelanggan berhasil ditambahkan.'];
header('Location: list.php');
exit;
