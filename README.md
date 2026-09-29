# Toko Barokah Jaya - Sistem Manajemen Toko

Aplikasi web untuk mengelola data produk dan pelanggan toko dengan fitur CRUD lengkap.

## Fitur

- ✅ Manajemen Produk (Tambah, Edit, Hapus, Cari)
- ✅ Manajemen Pelanggan (Tambah, Edit, Hapus, Cari)
- ✅ Dashboard dengan statistik penjualan
- ✅ Grafik penjualan bulanan
- ✅ Produk paling laris
- ✅ Pagination dan pencarian real-time
- ✅ Responsive design

## Tech Stack

- **Backend**: PHP 8.2-FPM
- **Database**: PostgreSQL (Aiven Cloud)
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Server**: Nginx
- **Deployment**: Docker + Railway

## Setup Development

### 1. Clone Repository
```bash
git clone https://github.com/USERNAME-ANDA/toko-barokah-jaya.git
cd toko-barokah-jaya
```

### 2. Setup Environment Variables
Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Lalu edit file `.env` dengan kredensial database Anda.

### 3. Setup Database
Jalankan file `sql/schema.sql` ke database PostgreSQL Anda:
```bash
psql -h YOUR_HOST -p YOUR_PORT -U YOUR_USER -d YOUR_DATABASE -f sql/schema.sql
```

### 4. Jalankan dengan Docker
```bash
docker-compose up -d
```

Akses aplikasi di: `http://localhost:8282`

**Note**: Setup ini menggunakan Nginx + PHP-FPM untuk menghindari error Apache MPM (AH00534)

### 5. Atau Jalankan dengan Laragon/XAMPP
- Copy folder proyek ke `C:\laragon\www\`
- Akses di: `http://localhost/toko-barokah-jaya`

## Deploy ke Railway

1. Push repository ke GitHub
2. Login ke [Railway.app](https://railway.app)
3. Klik "New Project" → "Deploy from GitHub"
4. Pilih repository ini
5. Tambahkan Environment Variables di Railway dashboard:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASS`
6. Railway akan otomatis deploy menggunakan Dockerfile

## Struktur Proyek

```
jobsheet-3-convert/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── koneksi.php
├── produk/
│   ├── list.php
│   ├── tambah.php
│   ├── edit.php
│   ├── hapus.php
│   ├── proses_tambah.php
│   └── proses_edit.php
├── pelanggan/
│   ├── list.php
│   ├── tambah.php
│   ├── edit.php
│   ├── hapus.php
│   ├── proses_tambah.php
│   └── proses_edit.php
├── sql/
│   └── schema.sql
├── index.php
├── Dockerfile
├── docker-compose.yml
└── .env.example
```

## License

MIT License
