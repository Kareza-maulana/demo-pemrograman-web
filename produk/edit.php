<?php
$page_title = "Edit Produk";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = :id");
$stmt->execute(['id' => $id]);
$produk = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produk) {
    header('Location: list.php');
    exit;
}
?>
        <section class="tambah-buku">
            <h2>Edit Produk</h2>
            <p class="form-intro">Ubah informasi produk yang diperlukan.</p>

            <?php if (!empty($flash)): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? ''); ?>">
                    <?php echo htmlspecialchars($flash['pesan'] ?? ''); ?>
                </p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo $produk['id']; ?>">
                <p>
                    <label for="nama_produk">Nama Produk <span class="required-mark">*</span></label>
                    <input type="text" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($produk['nama_produk']); ?>" required>
                </p>
                <p>
                    <label for="harga">Harga <span class="required-mark">*</span></label>
                    <input type="number" id="harga" name="harga" min="0" value="<?php echo htmlspecialchars($produk['harga']); ?>" required>
                </p>
                <p>
                    <label for="kode_produk">Kode Produk</label>
                    <input type="text" id="kode_produk" name="kode_produk" value="<?php echo htmlspecialchars($produk['kode_produk']); ?>">
                </p>
                <p>
                    <label for="stok">Stok <span class="required-mark">*</span></label>
                    <input type="number" id="stok" name="stok" min="0" value="<?php echo htmlspecialchars($produk['stok']); ?>" required>
                </p>
                <p>
                    <label for="kategori">Kategori <span class="required-mark">*</span></label>
                    <select id="kategori" name="kategori">
                        <?php foreach (['Alat Tulis' => 'Alat Tulis', 'Peralatan Rumah' => 'Peralatan Rumah', 'Sembako' => 'Sembako'] as $value => $label): ?>
                        <option value="<?php echo $value; ?>" <?php echo $produk['kategori'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <button type="submit">Update</button>
                </p>
            </form>
            <small class="form-note"><span class="required-mark">*</span> Wajib diisi</small>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
