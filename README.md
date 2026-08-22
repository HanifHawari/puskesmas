# SIPP UPTD Puskesmas Ipuh 🏥

<div align="center">
  <img src="assets/images/logo.png" alt="Logo SIPP Puskesmas Ipuh" width="150" />
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

## 🚀 Deployment

Project ini sudah dikonfigurasi agar mudah di-deploy ke platform seperti **Railway** menggunakan file `nixpacks.toml` dan membaca variabel environment `DATABASE_URL` untuk koneksi PostgreSQL secara otomatis.

---
*Dibuat untuk mempermudah akses layanan kesehatan bagi masyarakat Ipuh.*
