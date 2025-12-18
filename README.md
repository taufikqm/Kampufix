# KampuFix

Aplikasi Pengaduan Fasilitas Kampus berbasis Web.

## 📋 Persyaratan (Requirements)

Sebelum menjalankan aplikasi ini, pastikan laptop Anda sudah terinstall:

1.  **PHP** (Minimal versi 8.1)
2.  **Composer** (Untuk install dependency PHP)
3.  **MySQL / MariaDB** (Bisa pakai XAMPP / Laragon)
4.  **Node.js & NPM** (Untuk compile CSS/JS)
5.  **Git** (Untuk download project)

---

## Cara Install & Menjalankan

Ikuti langkah-langkah ini secara **berurutan**:

### 1. Clone Repository (Download Project)

Buka terminal (CMD / PowerShell / Git Bash), lalu jalankan:

```bash
git clone https://github.com/taufikqm/Kampufix.git
cd Kampufix
```

### 2. Install Dependencies

Install library PHP dan JavaScript yang dibutuhkan:

```bash
composer install
npm install
```

### 3. Setup Environment

Copy file konfigurasi `.env`, lalu generate key aplikasi:

```bash
cp .env.example .env
php artisan key:generate
```

*(Catatan: Jika command `cp` error di Windows CMD, gunakan `copy .env.example .env`)*

### 4. Konfigurasi Database

1.  Buka **XAMPP / Laragon** dan start **Apache** & **MySQL**.
2.  Buka aplikasi database manager (phpMyAdmin / HeidiSQL).
3.  Buat database baru dengan nama: `kampufix`.
4.  Buka file `.env` di text editor (VSCode), cari bagian ini dan pastikan sesuai:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kampufix
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Setup Database & Akun Default

Jalankan perintah ini untuk membuat tabel dan akun default baru:

```bash
php artisan migrate:fresh --seed
```

**Alternatif: Gunakan Database phpmyadmin (Import SQL)**

Jika teman Anda menyertakan file `database.sql`:
1.  Buka phpMyAdmin.
2.  Pilih database `kampufix`.
3.  Klik tab **Import**.
4.  Pilih file `database.sql` yang ada di folder project ini.
5.  Klik **Go/Kirim**.
*(Gunakan cara ini agar password & data akun sama persis dengan teman Anda)*
### 6. Jalankan Aplikasi

Buka **Dua (2) Terminal** sekaligus:

**Terminal 1 (Server PHP):**
```bash
php artisan serve
```

**Terminal 2 (Compile frontend):**
```bash
npm run dev
```

Akses aplikasi di browser melalui: **http://127.0.0.1:8000**

---

## 🔑 Akun Login Default

Gunakan akun berikut untuk mencoba fitur:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gmail.com` | `passadmin` |
| **Teknisi** | `asep@gmail.com` | `passteknisi` |
| **Mahasiswa** | `taufik@gmail.com` | `password` |

---

## 🧪 Cara Testing

1.  **Login Admin**: Cek dashboard notifikasi, manajemen kategori, dan monitoring feedback.
2.  **Login Mahasiswa**: Buat pengaduan baru, pilih kategori, dan cek status.
3.  **Login Teknisi**: Cek tugas masuk, update status ke 'Selesai', dan upload bukti perbaikan.
4.  **Login Mahasiswa (lagi)**: Berikan rating & feedback untuk pengaduan yang sudah selesai.
