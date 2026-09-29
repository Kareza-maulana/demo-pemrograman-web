    </main>

    <footer>
        <p>&copy; 2026 Toko Barokah Jaya &mdash; Jobsheet 3 Convert</p>
    </footer>
    <?php
    // $base dihitung di header.php; jika footer diinclude sendiri, fallback ke ''
    $base = $base ?? '';
    $extra_scripts = $extra_scripts ?? [];
    ?>
    <script src="<?php echo $base; ?>assets/js/app.js"></script>
    <?php foreach ($extra_scripts as $src): ?>
    <script src="<?php echo htmlspecialchars($src); ?>"></script>
    <?php endforeach; ?>
</body>
</html>
