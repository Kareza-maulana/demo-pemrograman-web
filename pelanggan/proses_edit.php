<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$id            = $_POST['id'] ?? null;
$namaPelanggan = trim($_POST['nama_pelanggan'] ?? '');
$kodePelanggan = trim($_POST['kode_pelanggan'] ?? '');
$alamat        = trim($_POST['alamat'] ?? '');
$noHp          = trim($_POST['no_hp'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($namaPelanggan === '') {
    $errors[] = "Nama pelanggan wajib diisi.";
}
if ($kodePelanggan === '') {
    $errors[] = "Kode pelanggan wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE pelanggan SET nama_pelanggan = :nama_pelanggan, kode_pelanggan = :kode_pelanggan,
     alamat = :alamat, no_hp = :no_hp WHERE id = :id"
);
$stmt->execute([
    'nama_pelanggan' => $namaPelanggan,
    'kode_pelanggan' => $kodePelanggan,
    'alamat'         => $alamat,
    'no_hp'          => $noHp,
    'id'             => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Pelanggan berhasil diperbarui.'];
header('Location: list.php');
exit;
