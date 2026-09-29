<?php
$page_title = "Tambah Produk";
include __DIR__ . '/../includes/header.php';

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
unset($_SESSION['flash']);
?>
        <section class="tambah-buku">
            <h2>Tambah Produk</h2>
            <p class="form-intro">Lengkapi informasi produk yang akan ditambahkan.</p>

            <?php if (!empty($flash)): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? ''); ?>">
                    <?php echo htmlspecialchars($flash['pesan'] ?? ''); ?>
                </p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <p>
                    <label for="nama_produk">Nama Produk <span class="required-mark">*</span></label>
                    <input type="text" id="nama_produk" name="nama_produk" required>
                </p>
                <p>
                    <label for="harga">Harga <span class="required-mark">*</span></label>
                    <input type="number" id="harga" name="harga" min="0" required>
                </p>
                <p>
                    <label for="kode_produk">Kode Produk</label>
                    <input type="text" id="kode_produk" name="kode_produk">
                </p>
                <p>
                    <label for="stok">Stok <span class="required-mark">*</span></label>
                    <input type="number" id="stok" name="stok" min="0" required>
                </p>
                <p>
                    <label for="kategori">Kategori <span class="required-mark">*</span></label>
                    <select id="kategori" name="kategori">
                        <option value="Alat Tulis">Alat Tulis</option>
                        <option value="Peralatan Rumah">Peralatan Rumah</option>
                        <option value="Sembako">Sembako</option>
                    </select>
                </p>
                <p>
                    <button type="submit">Simpan</button>
                </p>
            </form>
            <small class="form-note"><span class="required-mark">*</span> Wajib diisi</small>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
