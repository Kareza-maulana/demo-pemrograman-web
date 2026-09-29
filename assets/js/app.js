// ===== Hamburger / Sidebar toggle (dashboard layout jobsheet-3) =====
// Di layout jobsheet-3 sidebar selalu ada di desktop (CSS grid).
// Di mobile, toggle dilakukan via checkbox #nav-toggle (CSS hack).
// JS ini menambah interaktivitas tambahan agar label nav-toggle-btn
// juga bekerja melalui JavaScript (bukan hanya CSS :checked).
function initNavToggle() {
    const toggleLabel = document.getElementById("nav-toggle-btn");
    const navToggle   = document.getElementById("nav-toggle");
    if (!toggleLabel || !navToggle) return;

    toggleLabel.addEventListener("click", function () {
        navToggle.checked = !navToggle.checked;
    });
}

// ===== Konfirmasi hapus =====
// Tombol Hapus berada di dalam <form class="form-hapus" method="post">.
// Konfirmasi dilakukan pada event "submit" agar bisa dibatalkan
// (preventDefault) sebelum request terkirim ke server.
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row  = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent.trim() : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (!yakin) {
            e.preventDefault();
        }
    });
}

// ===== Filter/pencarian tabel real-time =====
// Bekerja paralel dengan pencarian server-side:
// - Mengetik di input #search-input langsung menyembunyikan baris
//   yang tidak cocok tanpa reload halaman.
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows    = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Validasi form client-side =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span       = document.createElement("span");
    span.className   = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Validasi field nama produk atau nama pelanggan
        const namaField = form.querySelector("[name='nama_produk'], [name='nama_pelanggan']");
        if (namaField && namaField.value.trim() === "") {
            tampilkanError(namaField, "Field ini wajib diisi.");
            valid = false;
        } else if (namaField) {
            hapusError(namaField);
        }

        // Validasi harga (khusus form produk)
        const harga = form.querySelector("[name='harga']");
        if (harga) {
            const nilai = parseInt(harga.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(harga, "Harga harus berupa angka positif.");
                valid = false;
            } else {
                hapusError(harga);
            }
        }

        // Validasi kode pelanggan (khusus form pelanggan)
        const kodePelanggan = form.querySelector("[name='kode_pelanggan']");
        if (kodePelanggan && kodePelanggan.value.trim() === "") {
            tampilkanError(kodePelanggan, "Kode pelanggan wajib diisi.");
            valid = false;
        } else if (kodePelanggan) {
            hapusError(kodePelanggan);
        }

        // Validasi stok (khusus form barang)
        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

// ===== Flash message auto-hide =====
// Pesan sukses/error akan otomatis hilang setelah 4 detik.
function initFlashAutoHide() {
    const flash = document.querySelector(".flash");
    if (!flash) return;
    setTimeout(function () {
        flash.style.transition = "opacity 0.5s";
        flash.style.opacity    = "0";
        setTimeout(function () { flash.remove(); }, 500);
    }, 4000);
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    initFlashAutoHide();
});
