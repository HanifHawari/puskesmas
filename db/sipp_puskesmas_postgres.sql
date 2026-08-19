-- ============================================================
-- DATABASE: sipp_puskesmas (PostgreSQL Version untuk Supabase)
-- ============================================================

CREATE TABLE IF NOT EXISTS profil_puskesmas (
  id SERIAL PRIMARY KEY,
  key_name VARCHAR(100) NOT NULL UNIQUE,
  value TEXT NOT NULL
);

INSERT INTO profil_puskesmas (key_name, value) VALUES
('nama',         'UPTD Puskesmas Ipuh'),
('kepala',       'dr. Hendra Saputra, M.Kes'),
('nip_kepala',   '197801012006041010'),
('alamat',       'Jl. Kesehatan No. 1, Ipuh, Kec. Ipuh, Kab. Mukomuko, Bengkulu 38763'),
('telp',         '(0737) 5210001'),
('email',        'puskesmas.ipuh@mukomukokab.go.id'),
('website',      'puskesmasipuh.mukomukokab.go.id'),
('jam_operasional', 'Senin - Jumat: 07.30 - 14.00 WIB | IGD: 24 Jam'),
('visi',         'Terwujudnya Masyarakat Ipuh yang Sehat, Mandiri, dan Berkeadilan'),
('misi',         '1. Memberikan pelayanan kesehatan yang bermutu dan merata\n2. Mendorong kemandirian hidup sehat bagi keluarga dan masyarakat\n3. Meningkatkan kemitraan bersama lintas sektor\n4. Meningkatkan profesionalisme tenaga kesehatan\n5. Mengelola sumber daya puskesmas secara efektif dan efisien'),
('sejarah',      'UPTD Puskesmas Ipuh berdiri sejak tahun 1978 dan telah melayani masyarakat Kecamatan Ipuh selama lebih dari 4 dekade.'),
('wilayah_kerja','Kecamatan Ipuh meliputi 17 Desa dengan jumlah penduduk 28.000 jiwa'),
('maps_embed',   'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6!2d101.474!3d-2.792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMsKwNDcnMzEuMiJTIDEwMcKwMjgnMjYuNCJF!5e0!3m2!1sid!2sid!4v1690000000000');


CREATE TABLE IF NOT EXISTS poli (
  id SERIAL PRIMARY KEY,
  nama_poli VARCHAR(100) NOT NULL,
  dokter_jaga VARCHAR(100),
  jam_buka VARCHAR(10) DEFAULT '07:30',
  jam_tutup VARCHAR(10) DEFAULT '14:00',
  kuota_pagi INT DEFAULT 30,
  kuota_siang INT DEFAULT 20,
  status VARCHAR(20) DEFAULT 'Buka',
  urutan INT DEFAULT 0
);

INSERT INTO poli (nama_poli, dokter_jaga, jam_buka, jam_tutup, kuota_pagi, kuota_siang, status, urutan) VALUES
('Poli Umum',         'dr. Hendra Saputra, M.Kes',   '07:30', '14:00', 50, 30, 'Buka',  1),
('Poli Gigi',         'drg. Sari Dewi Lestari',       '08:00', '13:00', 20, 0,  'Buka',  2),
('Poli KIA / KB',     'Bidan Nurhasanah, Amd.Keb',    '07:30', '14:00', 30, 15, 'Buka',  3),
('Poli Anak (MTBS)',  'dr. Rina Safitri',             '07:30', '14:00', 40, 20, 'Buka',  4),
('Poli Lansia',       'dr. Hendra Saputra, M.Kes',   '07:30', '12:00', 25, 0,  'Buka',  5),
('IGD (24 Jam)',      'Tim Jaga IGD',                 '00:00', '23:59', 0,  0,  'Buka',  6),
('Laboratorium',      'Marlena, AMAK',                '07:30', '13:00', 0,  0,  'Buka',  7),
('Apotek / Farmasi',  'Apt. Dian Pertiwi, S.Farm',    '07:30', '14:00', 0,  0,  'Buka',  8);


CREATE TABLE IF NOT EXISTS pendaftaran (
  id SERIAL PRIMARY KEY,
  no_antrian VARCHAR(20) NOT NULL,
  nik VARCHAR(16) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  tgl_lahir DATE NOT NULL,
  jenis_kelamin VARCHAR(1) NOT NULL,
  no_hp VARCHAR(15) NOT NULL,
  alamat TEXT NOT NULL,
  jenis_kartu VARCHAR(20) NOT NULL,
  no_kartu VARCHAR(30),
  jenis_pasien VARCHAR(10) NOT NULL DEFAULT 'Baru',
  poli_id INT NOT NULL REFERENCES poli(id),
  keluhan TEXT,
  tgl_kunjungan DATE NOT NULL,
  sesi VARCHAR(10) NOT NULL DEFAULT 'Pagi',
  status VARCHAR(20) DEFAULT 'Menunggu',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS pengaduan (
  id SERIAL PRIMARY KEY,
  kode_pengaduan VARCHAR(10) NOT NULL UNIQUE,
  nama_pelapor VARCHAR(100) DEFAULT 'Anonim',
  no_hp VARCHAR(15),
  kategori VARCHAR(50) NOT NULL,
  judul VARCHAR(200) NOT NULL,
  isi_pengaduan TEXT NOT NULL,
  tgl_kejadian DATE NOT NULL,
  file_bukti VARCHAR(255),
  status VARCHAR(20) DEFAULT 'Diterima',
  catatan_admin TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS fasilitas (
  id SERIAL PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  status VARCHAR(20) DEFAULT 'Tersedia',
  kapasitas INT DEFAULT 0,
  terisi INT DEFAULT 0,
  keterangan TEXT,
  ikon VARCHAR(50) DEFAULT 'fa-building',
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO fasilitas (nama, kategori, status, kapasitas, terisi, keterangan, ikon) VALUES
('Ruang Rawat Inap Umum',  'Ruang Rawat Inap', 'Tersedia',      10, 4,  'Kapasitas 10 tempat tidur', 'fa-bed'),
('Ruang Bersalin (VK)',    'Ruang Rawat Inap', 'Tersedia',       4, 1,  'Kapasitas 4 tempat tidur',  'fa-bed'),
('Ruang Observasi IGD',    'Ruangan',          'Tersedia',       6, 2,  'Kapasitas 6 tempat tidur',  'fa-stethoscope'),
('Ruang Tindakan',         'Ruangan',          'Tersedia',       0, 0,  'Tersedia dan berfungsi',    'fa-syringe'),
('Ambulance',              'Peralatan',        'Tersedia',       0, 0,  '1 unit siap pakai',         'fa-ambulance'),
('EKG / Rekam Jantung',    'Peralatan',        'Tersedia',       0, 0,  'Berfungsi normal',          'fa-heartbeat'),
('USG',                    'Peralatan',        'Tersedia',       0, 0,  'Tersedia di Poli KIA',      'fa-wave-square'),
('Laboratorium Klinik',    'Ruangan',          'Tersedia',       0, 0,  'Buka Senin-Sabtu 07:30-13:00', 'fa-flask'),
('Toilet Umum',            'Fasilitas Umum',   'Tersedia',       0, 0,  'Bersih dan terawat',        'fa-restroom'),
('Kursi Roda',             'Fasilitas Umum',   'Tersedia',       0, 0,  '3 unit tersedia',           'fa-wheelchair'),
('Area Parkir',            'Fasilitas Umum',   'Tersedia',       0, 0,  'Parkir gratis',             'fa-parking'),
('Mushola',                'Fasilitas Umum',   'Tersedia',       0, 0,  'Bersih dan representatif',  'fa-mosque');


CREATE TABLE IF NOT EXISTS pengumuman (
  id SERIAL PRIMARY KEY,
  judul VARCHAR(200) NOT NULL,
  isi TEXT NOT NULL,
  tipe VARCHAR(20) DEFAULT 'Info',
  aktif SMALLINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pengumuman (judul, isi, tipe, aktif) VALUES
('Jam Pelayanan Normal', 'Puskesmas Ipuh melayani pasien Senin - Jumat pukul 07.30 - 14.00 WIB. IGD tetap beroperasi 24 jam.', 'Info', 1),
('Vaksinasi Rutin Tersedia', 'Vaksinasi bayi dan anak tersedia setiap Selasa dan Kamis di Poli KIA. Bawa buku KIA/KMS.', 'Penting', 1);


CREATE TABLE IF NOT EXISTS tenaga_medis (
  id SERIAL PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jabatan VARCHAR(100) NOT NULL,
  spesialis VARCHAR(100),
  nip VARCHAR(30),
  poli_id INT REFERENCES poli(id),
  urutan INT DEFAULT 0
);

INSERT INTO tenaga_medis (nama, jabatan, spesialis, nip, poli_id, urutan) VALUES
('dr. Hendra Saputra, M.Kes',  'Kepala Puskesmas / Dokter Umum', 'Kedokteran Keluarga', '197801012006041010', 1, 1),
('drg. Sari Dewi Lestari',     'Dokter Gigi',                    'Kedokteran Gigi',     '198503122010012015', 2, 2),
('dr. Rina Safitri',           'Dokter Umum',                    NULL,                  '199001052019022003', 4, 3),
('Bidan Nurhasanah, Amd.Keb',  'Bidan Koordinator',             'Kebidanan',           '198706142010012020', 3, 4),
('Marlena, AMAK',              'Analis Laboratorium',            NULL,                  '199205102015032010', 7, 5),
('Apt. Dian Pertiwi, S.Farm',  'Apoteker',                      'Farmasi Klinik',      '199307082019032005', 8, 6);
