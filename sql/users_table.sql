-- ============================================================
-- Tabel users untuk sistem autentikasi
-- ============================================================
-- Jalankan SQL ini ke database Anda untuk menambahkan tabel users

CREATE TABLE IF NOT EXISTS users (
    id       SERIAL PRIMARY KEY,
    nama     VARCHAR(255) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role     VARCHAR(50)  NOT NULL DEFAULT 'petugas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data contoh user (opsional, hapus jika tidak diperlukan)
-- Username: admin, Password: admin123
INSERT INTO users (nama, username, password, role) VALUES
    ('Admin Toko', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
