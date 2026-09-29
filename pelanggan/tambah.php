<?php
$page_title = "Tambah Pelanggan";
include __DIR__ . '/../includes/header.php';

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Pelanggan</h2>

            <?php if (!empty($flash)): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? ''); ?>">
                    <?php echo htmlspecialchars($flash['pesan'] ?? ''); ?>
                </p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <p>
                    <label for="nama_pelanggan">Nama Pelanggan <span class="required-mark">*</span></label><br>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" required>
                </p>
                <p>
                    <label for="kode_pelanggan">Kode Pelanggan <span class="required-mark">*</span></label><br>
                    <input type="text" id="kode_pelanggan" name="kode_pelanggan" required>
                </p>
                <p>
                    <label for="alamat">Alamat</label><br>
                    <input type="text" id="alamat" name="alamat">
                </p>
                <p>
                    <label for="no_hp">No. HP</label><br>
                    <input type="text" id="no_hp" name="no_hp">
                </p>
                <p>
                    <button type="submit">Simpan</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
