# Inventory & Cashier System for Workshop

Sistem manajemen **inventory** dan **kasir** untuk bengkel/workshop, dibangun dengan PHP Native dan Bootstrap.  
Program ini memudahkan pencatatan stok barang, transaksi penjualan, hingga pencetakan struk dan laporan. :contentReference[oaicite:0]{index=0}

## Daftar Isi

- [Tentang](#tentang)  
- [Fitur](#fitur)  
- [Persyaratan](#persyaratan)  
- [Instalasi](#instalasi)  
- [Konfigurasi](#konfigurasi)  
- [Cara Penggunaan](#cara-penggunaan)  
- [Struktur Direktori](#struktur-direktori)  
- [Kontribusi](#kontribusi)  
- [Lisensi](#lisensi)  

## Tentang

Sistem ini dirancang untuk membantu pemilik bengkel atau workshop dalam:
- Mengelola **stok barang** (tambahkan, edit, hapus)  
- Mencatat **transaksi kasir** (input item, hitung total, cetak struk)  
- Menghasilkan laporan sederhana (print, export Excel)  

## Fitur

- 📦 CRUD Inventory  
- 🛒 Transaksi Kasir dengan pilihan item otomatis (auto‐reload)  
- 🖨️ Cetak struk/PO dan laporan penjualan  
- 📊 Export data ke Excel  
- 🔒 Halaman login sederhana (single user)  
- 📱 Responsive UI dengan Bootstrap (SB Admin)  

## Persyaratan

- PHP **7.0+**  
- MySQL / MariaDB  
- Web server (Apache/Nginx) dengan mod_rewrite (`.htaccess`)  
- Ekstensi PHP: `mysqli`, `gd` (jika diperlukan untuk thumbnail)  

## Instalasi

1. **Clone** repository  
   ```bash
   git clone https://github.com/ghilmanfz/inventory-and-cashier-from-the-workshop.git
Import database

Buka file db_toko.sql di folder project.

Import ke MySQL:

bash
Copy
Edit
mysql -u root -p nama_database < db_toko.sql
Copy project ke folder web server (misal htdocs atau www).

Konfigurasi
Buka file config.php

Sesuaikan kredensial database:

php
Copy
Edit
<?php
$host     = 'localhost';
$username = 'root';
$password = '';
$database = 'nama_database';
Simpan perubahan. 
GitHub

Cara Penggunaan
Akses melalui browser:

arduino
Copy
Edit
http://localhost/inventory-and-cashier-from-the-workshop/
Login dengan:

Username: admin

Password: 123

Setelah login, pilih menu Inventory atau Kasir di sidebar.

Untuk mencetak struk, klik tombol Print di halaman transaksi.

Struktur Direktori
bash
Copy
Edit
/assets/            # Gambar, CSS, plugin SB Admin
/fungsi/            # Kumpulan fungsi PHP (helper, query)
// sb-admin/         # Template Bootstrap SB Admin
config.php         # Koneksi database
db_toko.sql        # Skrip SQL import database
index.php          # Halaman utama (dashboard)
/login.php         # Form login
/logout.php        # Logout
/proses.php        # Proses CRUD & transaksi
/reload_barang.php # Auto‐reload stok barang via AJAX
/cetak_po.php      # Cetak purchase order
/print.php         # Cetak struk transaksi
/excel.php         # Export data ke Excel
/LICENSE           # Lisensi MIT
Kontribusi
Fork repository ini.

Buat branch baru: git checkout -b fitur-baru.

Commit perubahan: git commit -m "Tambah fitur ...".

Push ke branch: git push origin fitur-baru.

Buka Pull Request di GitHub.

Lisensi
Proyek ini menggunakan lisensi MIT.
Lihat detail di file LICENSE. 
GitHub

makefile
Copy
Edit
::contentReference[oaicite:3]{index=3}
