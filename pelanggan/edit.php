<?php
$page_title = "Edit Pelanggan";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
unset($_SESSION['flash']);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id = :id");
$stmt->execute(['id' => $id]);
$pelanggan = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pelanggan) {
    header('Location: list.php');
    exit;
}
?>
        <section>
            <h2>Edit Pelanggan</h2>

            <?php if (!empty($flash)): ?>
                <p class="flash flash-<?php echo htmlspecialchars($flash['type'] ?? ''); ?>">
                    <?php echo htmlspecialchars($flash['pesan'] ?? ''); ?>
                </p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo $pelanggan['id']; ?>">
                <p>
                    <label for="nama_pelanggan">Nama Pelanggan <span class="required-mark">*</span></label><br>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" value="<?php echo htmlspecialchars($pelanggan['nama_pelanggan']); ?>" required>
                </p>
                <p>
                    <label for="kode_pelanggan">Kode Pelanggan <span class="required-mark">*</span></label><br>
                    <input type="text" id="kode_pelanggan" name="kode_pelanggan" value="<?php echo htmlspecialchars($pelanggan['kode_pelanggan']); ?>" required>
                </p>
                <p>
                    <label for="alamat">Alamat</label><br>
                    <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($pelanggan['alamat']); ?>">
                </p>
                <p>
                    <label for="no_hp">No. HP</label><br>
                    <input type="text" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($pelanggan['no_hp']); ?>">
                </p>
                <p>
                    <button type="submit">Update</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
