# Materially PHP Dashboard

Proyek ini adalah konversi dari template React Materially menjadi versi PHP yang dapat dijalankan di localhost XAMPP.

## Cara Menjalankan

1. **Pastikan XAMPP sudah terinstal** di komputer Anda.

2. **Letakkan folder project** di direktori:
   ```
   C:/xampp/htdocs/pemrograman web lanjut/project1
   ```

3. **Jalankan XAMPP**:
   - Buka XAMPP Control Panel
   - Start Apache Web Server

4. **Akses aplikasi** melalui browser:
   ```
   http://localhost/pemrograman web lanjut/project1/
   ```

## Struktur Folder

```
project1/
├── index.php              # File utama aplikasi
├── includes/
│   ├── header.php        # Header aplikasi
│   └── sidebar.php       # Sidebar navigation
├── pages/
│   ├── dashboard.php     # Halaman dashboard
│   ├── login.php         # Halaman login
│   ├── register.php      # Halaman registrasi
│   ├── users.php         # Halaman manajemen pengguna
│   └── typography.php    # Halaman typography
├── assets/
│   ├── css/
│   │   └── style.css     # Custom styles
│   ├── js/
│   │   └── main.js       # Custom JavaScript
│   └── images/          # Folder untuk gambar
```

## Fitur yang Tersedia

- **Dashboard**: Halaman utama dengan statistik dan grafik
- **Login/Register**: Sistem autentikasi sederhana
- **Users Management**: Manajemen pengguna dengan tabel
- **Typography**: Contoh styling typography
- **Responsive Design**: Mendukung mobile dan desktop

## Teknologi yang Digunakan

- **PHP 7.4+**
- **Bootstrap 5.3**
- **Chart.js** untuk grafik
- **Material Icons** untuk ikon
- **Poppins Font** dari Google Fonts

## Halaman yang Tersedia

1. **Dashboard** - `index.php?page=dashboard`
2. **Login** - `index.php?page=login`
3. **Register** - `index.php?page=register`
4. **Users** - `index.php?page=users`
5. **Typography** - `index.php?page=typography`

## Customization

Untuk menambahkan halaman baru:
1. Buat file baru di folder `pages/`
2. Tambahkan link di `includes/sidebar.php`
3. Tambahkan routing di `index.php`

## Troubleshooting

Jika terjadi masalah:
1. Pastikan Apache berjalan di XAMPP
2. Periksa folder berada di direktori yang benar
3. Pastikan file `index.php` dapat diakses
4. Cek error log di XAMPP jika ada masalah teknis
