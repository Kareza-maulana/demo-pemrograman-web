<?php
session_start();

// Hitung prefix relatif ke root proyek agar path asset & link benar
// baik diakses lewat vhost langsung maupun subfolder.
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir    = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel          = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base           = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Barokah Jaya<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body class="dashboard-layout">
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <aside class="sidebar">
        <h1>Toko Barokah Jaya</h1>
        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>produk/list.php">Daftar Produk</a></li>
                <li><a href="<?php echo $base; ?>produk/tambah.php">Tambah Produk</a></li>
                <li><a href="<?php echo $base; ?>pelanggan/list.php">Daftar Pelanggan</a></li>
                <li><a href="<?php echo $base; ?>pelanggan/tambah.php">Tambah Pelanggan</a></li>
            </ul>
        </nav>
    </aside>

    <header class="dashboard-header">
        <div class="mobile-header-brand">
            <label for="nav-toggle" id="nav-toggle-btn" class="nav-toggle-label">&#9776;</label>
            <span>Toko Barokah Jaya</span>
        </div>
        <div class="user-profile">
            <div class="user-avatar">A</div>
            <div>
                <strong>Admin Toko</strong>
                <span>Admin</span>
            </div>
        </div>
    </header>

    <main>
