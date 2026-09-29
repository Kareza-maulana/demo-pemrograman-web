<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

// Query tabel utama — dijamin ada setelah schema.sql dijalankan
$totalProduk    = (int) $pdo->query("SELECT COUNT(*) FROM produk")->fetchColumn();
$totalPelanggan = (int) $pdo->query("SELECT COUNT(*) FROM pelanggan")->fetchColumn();

// Tabel transaksi & detail_transaksi opsional — pakai try-catch
$totalTransaksi = 0;
$totalPenjualan = 0;
$dataBulan      = [];
$dataLaris      = [];

try {
    $totalTransaksi = (int) $pdo->query("SELECT COUNT(*) FROM transaksi")->fetchColumn();
    $totalPenjualan = (float) $pdo->query("SELECT COALESCE(SUM(total_harga), 0) FROM transaksi")->fetchColumn();

    // Data penjualan per bulan (6 bulan terakhir) untuk grafik
    $stmtBulan = $pdo->query("
        SELECT TO_CHAR(tanggal, 'Mon') AS bulan,
               EXTRACT(MONTH FROM tanggal)::int AS bln_num,
               SUM(total_harga) AS total
        FROM transaksi
        WHERE tanggal >= NOW() - INTERVAL '6 months'
        GROUP BY TO_CHAR(tanggal, 'Mon'), EXTRACT(MONTH FROM tanggal)
        ORDER BY bln_num ASC
    ");
    $dataBulan = $stmtBulan->fetchAll(PDO::FETCH_ASSOC);

    // Data produk paling laris
    $stmtLaris = $pdo->query("
        SELECT b.nama_produk, SUM(dt.jumlah) AS total_terjual
        FROM detail_transaksi dt
        JOIN produk b ON b.id = dt.id_produk
        GROUP BY b.nama_produk
        ORDER BY total_terjual DESC
        LIMIT 4
    ");
    $dataLaris = $stmtLaris->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tabel transaksi belum dibuat — tampilkan data statis saja
}

// Fallback: data statis jika tabel transaksi belum ada / kosong
$chartDefault = [
    ['bulan' => 'Jan', 'total' => 1200000],
    ['bulan' => 'Feb', 'total' => 1500000],
    ['bulan' => 'Mar', 'total' => 1100000],
    ['bulan' => 'Apr', 'total' => 1800000],
    ['bulan' => 'Mei', 'total' => 1600000],
    ['bulan' => 'Jun', 'total' => 2000000],
];
$chartData = !empty($dataBulan) ? $dataBulan : $chartDefault;
$maxChart  = (float) max(array_column($chartData, 'total'));
if ($maxChart == 0) $maxChart = 1;

$larisDefault = [
    ['nama_produk' => 'Buku Tulis',  'total_terjual' => 86],
    ['nama_produk' => 'Pulpen Gel',  'total_terjual' => 72],
    ['nama_produk' => 'Buku Gambar', 'total_terjual' => 58],
    ['nama_produk' => 'Penghapus',   'total_terjual' => 41],
];
$maxLaris = !empty($dataLaris) ? (int) max(array_column($dataLaris, 'total_terjual')) : 86;
if (empty($dataLaris)) {
    $dataLaris = $larisDefault;
    $maxLaris  = 86;
}
?>
        <section class="welcome">
            <h2>Selamat Datang di Toko Barokah Jaya</h2>
            <p>Aplikasi sederhana untuk mengelola data produk dan pembeli.</p>
        </section>

        <section class="section-title">
            <h2>Laporan Penjualan</h2>
            <section>
                <article>
                    <h3>Total Produk</h3>
                    <p><?php echo $totalProduk; ?></p>
                </article>
                <article>
                    <h3>Total Pelanggan</h3>
                    <p><?php echo $totalPelanggan; ?></p>
                </article>
                <article>
                    <h3>Total Transaksi</h3>
                    <p><?php echo $totalTransaksi; ?></p>
                </article>
                <article>
                    <h3>Total Penjualan</h3>
                    <p>Rp <?php echo number_format($totalPenjualan, 0, ',', '.'); ?></p>
                </article>
            </section>
        </section>

        <section class="sales-dashboard" aria-label="Statistik penjualan">
            <article class="sales-chart">
                <div class="panel-heading">
                    <div>
                        <p class="panel-subheading">Performa penjualan</p>
                        <h2>Grafik Penjualan</h2>
                    </div>
                    <span class="panel-period">6 Bulan</span>
                </div>
                <div class="bar-chart" aria-label="Grafik penjualan 6 bulan terakhir">
                    <?php foreach ($chartData as $item): ?>
                    <?php $pct = round(($item['total'] / $maxChart) * 100); ?>
                    <div class="chart-column">
                        <span class="chart-value">Rp <?php echo number_format($item['total'] / 1000000, 1, ',', '.'); ?> jt</span>
                        <div class="chart-bar" style="height: <?php echo $pct; ?>%;"></div>
                        <span class="chart-label"><?php echo htmlspecialchars($item['bulan']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </article>

            <article class="best-selling">
                <div class="panel-heading">
                    <div>
                        <p class="panel-eyebrow">Berdasarkan transaksi</p>
                        <h2>Produk Paling Laris</h2>
                    </div>
                </div>
                <div class="product-list">
                    <?php foreach ($dataLaris as $idx => $produk): ?>
                    <?php $pct = round(($produk['total_terjual'] / $maxLaris) * 100); ?>
                    <div class="product-row">
                        <div class="product-meta">
                            <span><?php echo str_pad($idx + 1, 2, '0', STR_PAD_LEFT); ?></span>
                            <strong><?php echo htmlspecialchars($produk['nama_produk']); ?></strong>
                            <b><?php echo $pct; ?>%</b>
                        </div>
                        <div class="product-track"><span style="width: <?php echo $pct; ?>%;"></span></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </article>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>
