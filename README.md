# SIPP UPTD Puskesmas Ipuh 🏥

<div align="center">
  <img src="assets/logo.png" alt="Logo SIPP Puskesmas Ipuh" width="150" />
</div>

<br>

**Sistem Informasi Pelayanan Publik (SIPP)** UPTD Puskesmas Ipuh adalah platform digital yang dirancang untuk memudahkan masyarakat dalam mengakses layanan kesehatan, mendaftar antrean secara online, melihat fasilitas, dan menyampaikan aspirasi atau pengaduan secara transparan.

![Hero Banner](assets/images/puskesmas1.jpg)

## 🚀 Fitur Utama

- **Pendaftaran Online**: Pasien dapat mendaftar antrean secara online tanpa harus datang lebih awal ke Puskesmas.
- **Informasi Fasilitas & Layanan**: Menampilkan daftar fasilitas kesehatan, jadwal poli, dan tenaga medis yang tersedia.
- **Profil & Maklumat**: Informasi lengkap mengenai visi, misi, struktur organisasi, dan maklumat pelayanan resmi Puskesmas.
- **Layanan Pengaduan**: Form interaktif bagi masyarakat untuk memberikan saran, kritik, atau pengaduan terkait layanan.
- **Pengumuman Real-time**: Menampilkan informasi penting atau darurat langsung di halaman beranda.

## 🛠️ Teknologi yang Digunakan

- **Backend**: PHP (>= 8.0)
- **Database**: Mendukung MySQL (lokal via Laragon/XAMPP) & PostgreSQL (production via Railway/Supabase).
- **Frontend**: HTML5, Vanilla CSS3, JavaScript.
- **Lainnya**: PDO untuk koneksi database yang aman.

## 📦 Panduan Instalasi (Lokal)

1. Clone repositori ini ke dalam folder server lokal Anda (misal: `c:\laragon\www\`).
   ```bash
   git clone https://github.com/HanifHawari/puskesmas.git
   ```
2. Pastikan Anda menggunakan PHP versi 8.0 atau yang lebih baru.
3. Buat database baru di MySQL dengan nama `sipp_puskesmas`.
4. Import struktur database dari folder `db` (jika ada) ke database `sipp_puskesmas`.
5. Buka `config/database.php` dan sesuaikan konfigurasi koneksi database jika diperlukan. Secara default sudah dikonfigurasi untuk lokal Laragon:
   ```php
   $envHost = '127.0.0.1';
   $envDb   = 'sipp_puskesmas';
   $envUser = 'root';
   $envPass = '';
   ```
6. Akses website melalui browser Anda, contoh: `http://localhost/website SIPP/` (sesuaikan dengan nama folder).

## 🚀 Deployment

Project ini sudah dikonfigurasi agar mudah di-deploy ke platform seperti **Railway** menggunakan file `nixpacks.toml` dan membaca variabel environment `DATABASE_URL` untuk koneksi PostgreSQL secara otomatis.

---
*Dibuat untuk mempermudah akses layanan kesehatan bagi masyarakat Ipuh.*
