-- ============================================================
-- Jobsheet 3 Convert: Skema database toko_barokah (PostgreSQL)
-- ============================================================
-- Cara menjalankan ke database Aiven Cloud Anda:
--
-- Buka pgAdmin / DBeaver / terminal, lalu jalankan query ini
-- ke database: defaultdb
-- Host: pg-135cb050-karezamaulana-d1b0.e.aivencloud.com (Port: 11587)
-- ============================================================

-- Bersihkan tabel jika sudah ada sebelumnya
DROP TABLE IF EXISTS detail_transaksi CASCADE;
DROP TABLE IF EXISTS transaksi CASCADE;
DROP TABLE IF EXISTS pelanggan CASCADE;
DROP TABLE IF EXISTS produk CASCADE;

-- Tabel produk toko
CREATE TABLE produk (
    id          SERIAL PRIMARY KEY,
    nama_produk VARCHAR(255) NOT NULL,
    kategori    VARCHAR(100),
    kode_produk VARCHAR(50) UNIQUE,
    stok        INTEGER      NOT NULL DEFAULT 0,
    harga       NUMERIC(15,2) NOT NULL DEFAULT 0
);

-- Tabel pelanggan
CREATE TABLE pelanggan (
    id             SERIAL PRIMARY KEY,
    nama_pelanggan VARCHAR(255) NOT NULL,
    kode_pelanggan VARCHAR(50)  NOT NULL UNIQUE,
    alamat         TEXT,
    no_hp          VARCHAR(30)
);

-- Tabel transaksi (header)
CREATE TABLE transaksi (
    id             SERIAL PRIMARY KEY,
    id_pelanggan   INTEGER      REFERENCES pelanggan(id) ON DELETE SET NULL,
    tanggal        DATE         NOT NULL DEFAULT CURRENT_DATE,
    total_harga    NUMERIC(15,2) NOT NULL DEFAULT 0
);

-- Tabel detail transaksi (item per transaksi)
CREATE TABLE detail_transaksi (
    id             SERIAL PRIMARY KEY,
    id_transaksi   INTEGER NOT NULL REFERENCES transaksi(id) ON DELETE CASCADE,
    id_produk      INTEGER NOT NULL REFERENCES produk(id) ON DELETE CASCADE,
    jumlah         INTEGER NOT NULL DEFAULT 1,
    harga_satuan   NUMERIC(15,2) NOT NULL DEFAULT 0
);

-- ============================================================
-- Data awal (seed) — opsional, hapus jika tidak diperlukan
-- ============================================================

INSERT INTO produk (nama_produk, kategori, kode_produk, stok, harga) VALUES
    ('Buku Tulis',  'Alat Tulis', 'PRD-001', 50, 4500),
    ('Pulpen Gel',  'Alat Tulis', 'PRD-002', 100, 3000),
    ('Buku Gambar', 'Alat Tulis', 'PRD-003', 30, 6000),
    ('Penghapus',   'Alat Tulis', 'PRD-004', 80, 2000),
    ('Pensil 2B',   'Alat Tulis', 'PRD-005', 120, 2500);

INSERT INTO pelanggan (nama_pelanggan, kode_pelanggan, alamat, no_hp) VALUES
    ('Siti Aminah', 'PLG-001', 'Jl. Merdeka No 1, Malang', '081234567890'),
    ('Budi Santoso', 'PLG-002', 'Jl. Sudirman No 2, Batu',  '081345678901');

INSERT INTO transaksi (id_pelanggan, tanggal, total_harga) VALUES
    (1, CURRENT_DATE - INTERVAL '2 days', 15000),
    (2, CURRENT_DATE - INTERVAL '1 days', 22500);

INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga_satuan) VALUES
    (1, 1, 2, 4500),
    (1, 3, 1, 6000),
    (2, 2, 5, 3000),
    (2, 5, 3, 2500);
