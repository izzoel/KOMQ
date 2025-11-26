# KOMQ --- Aplikasi Quiz Diskominfo Tapin

**Tapin Expo 2025**

KOMQ adalah aplikasi kuis interaktif yang dikembangkan oleh **Dinas
Komunikasi dan Informatika Kabupaten Tapin** sebagai media edukasi,
promosi layanan, dan hiburan untuk pengunjung **Tapin Expo 2025**.\
Aplikasi ini menampilkan pertanyaan seputar layanan publik, teknologi
informasi, serta trivia menarik seputar Kabupaten Tapin.

## 🚀 Fitur Utama

### 🎡 1. Spin Wheel & Random Reward

Pengunjung melakukan spin untuk mendapatkan kategori pertanyaan yang
berbeda-beda.

### 📝 2. Sistem Pertanyaan Dinamis

Pertanyaan dikategorikan berdasarkan tema tertentu dan muncul secara
acak.

### 🎁 3. Reward Otomatis

Setiap jawaban benar akan menambah kesempatan untuk mendapatkan reward.\
Stok reward dikelola secara real-time melalui panel admin.

### 🔐 4. Panel Admin KOMQ

Admin dapat: - Mengatur pertanyaan & kategori\
- Mengelola reward (tambah, kurangi, toggle aktif/nonaktif)\
- Melihat riwayat reset reward\
- Mengatur akses menggunakan password\
- Melihat stok reward secara langsung

### 📅 5. Reset Harian Otomatis

Aplikasi otomatis menyimpan tanggal reset reward dalam file
`last_reward_reset.txt` dan hanya mengizinkan reset sekali per hari.

## 🛠️ Teknologi

Proyek KOMQ dibangun menggunakan: - Laravel - Bootstrap 5 -
SweetAlert2 - Eloquent ORM - AJAX / Fetch API - Laravel Filesystem

## 📂 Struktur Proyek

    app/
     ├── Http/Controllers/
     │   ├── QuizController.php
     │   └── AdminController.php
    resources/
     ├── views/
     │   ├── quiz.blade.php
     │   ├── wheel.blade.php
     │   └── admin/
    storage/
     └── app/
         └── last_reward_reset.txt
    public/
     └── assets/

## 👥 Kontributor

Tim **Dinas Komunikasi dan Informatika Kabupaten Tapin**\
Bidang Aplikasi Informatika

## 📄 Lisensi

Proyek ini dirilis sebagai *Open Source / Public Showcase* untuk
dokumentasi & edukasi.

## ⭐ Dukungan

Jangan lupa beri **🌟 Star** pada repository!
