
-- Create new database BebasTanggungan
CREATE DATABASE BebasTA;
GO
USE BebasTA;
GO
-- Create Schemas
CREATE SCHEMA pengguna AUTHORIZATION dbo;
GO
CREATE SCHEMA prodi AUTHORIZATION dbo;
GO
CREATE SCHEMA dokumen AUTHORIZATION dbo;
GO

---------------------------------------------------------------------
-- Create Tables
---------------------------------------------------------------------

-- Create table prodi.Prodi
CREATE TABLE prodi.Prodi
(
  ID INT NOT NULL IDENTITY,
  Nama_prodi NVARCHAR(100) NOT NULL,
  Jurusan NVARCHAR(100) NOT NULL,
  CONSTRAINT PK_Prodi PRIMARY KEY(ID)
);
GO


-- Create table pengguna.[User]
CREATE TABLE pengguna.[User]
(
  username CHAR(20) NOT NULL,
  password NVARCHAR(100) NOT NULL,
  level NVARCHAR(20) NOT NULL,
  -- "admin_jurusan", "admin_pusat", "mahasiswa"
  CONSTRAINT PK_User PRIMARY KEY(username)
);
GO

-- Create table pengguna.Mahasiswa
CREATE TABLE pengguna.Mahasiswa
(
  NIM CHAR(10) NOT NULL,
  Nama NVARCHAR(100) NOT NULL,
  NIK CHAR(16) NOT NULL UNIQUE,
  Tempat_lahir NVARCHAR(50) NOT NULL,
  tanggal_lahir DATE NOT NULL,
  Alamat NVARCHAR(255) NOT NULL,
  Nomor_telepon NVARCHAR(15) NOT NULL,
  Jenis_kelamin NVARCHAR(10) NOT NULL,
  -- "Laki-laki" atau "Perempuan"
  ID_prodi INT NOT NULL,
  username CHAR(20) NOT NULL UNIQUE,
  CONSTRAINT PK_Mahasiswa PRIMARY KEY(NIM),
  CONSTRAINT FK_Mahasiswa_Prodi FOREIGN KEY(ID_prodi) REFERENCES prodi.Prodi(ID),
  CONSTRAINT FK_Mahasiswa_User FOREIGN KEY(username) REFERENCES pengguna.[User](username)
);
GO

-- Create table pengguna.Admin
CREATE TABLE pengguna.Admin
(
  NIDN CHAR(10) NOT NULL,
  Nama NVARCHAR(100) NOT NULL,
  NIK CHAR(16) NOT NULL UNIQUE,
  Tempat_lahir NVARCHAR(50) NOT NULL,
  tanggal_lahir DATE NOT NULL,
  Alamat NVARCHAR(255) NOT NULL,
  Nomor_telepon NVARCHAR(15) NOT NULL,
  Jenis_kelamin NVARCHAR(10) NOT NULL,
  -- "Laki-laki" atau "Perempuan"
  username CHAR(20) NOT NULL UNIQUE,
  CONSTRAINT PK_Admin PRIMARY KEY(NIDN),
  CONSTRAINT FK_Admin_User FOREIGN KEY(username) REFERENCES pengguna.[User](username)
);
GO

-- Create table dokumen.Dokumen
CREATE TABLE dokumen.Dokumen
(
  ID INT NOT NULL IDENTITY,
  Nama_dokumen NVARCHAR(100) NOT NULL,
  Tingkat NVARCHAR(20) NOT NULL,
  -- "jurusan", "pusat", etc.
  CONSTRAINT PK_Dokumen PRIMARY KEY(ID)
);
GO

-- Create table dokumen.Upload_dokumen
CREATE TABLE dokumen.Upload_dokumen
(
  ID INT NOT NULL IDENTITY,
  Path_dokumen NVARCHAR(255) NOT NULL,
  Status NVARCHAR(20) NOT NULL,
  -- "Disetujui", "Ditolak", "Menunggu".
  Komentar NVARCHAR(MAX) NULL,
  ID_dokumen INT NOT NULL,
  NIM CHAR(10) NULL,
  NIDN CHAR(10) NULL,
  CONSTRAINT PK_Upload_dokumen PRIMARY KEY(ID),
  CONSTRAINT FK_Upload_Dokumen FOREIGN KEY(ID_dokumen) REFERENCES dokumen.Dokumen(ID),
  CONSTRAINT FK_Upload_Mahasiswa FOREIGN KEY(NIM) REFERENCES pengguna.Mahasiswa(NIM),
  CONSTRAINT FK_Upload_Admin FOREIGN KEY(NIDN) REFERENCES pengguna.Admin(NIDN)
);
GO

INSERT INTO prodi.Prodi
  (Nama_prodi, Jurusan)
VALUES
  ('D-IV Teknik Informatika', 'Teknologi Informasi'),
  ('D-IV Sistem Informasi Bisnis', 'Teknologi Informasi'),
  ('D-III Manajemen Informatika', 'Teknologi Informasi'),
  ('D-II Pengembangan Piranti Lunak Sistem', 'Teknologi Informasi'),
  ('D-IV Manajemen Rekayasa Konstruksi', 'Teknik Sipil'),
  ('D-IV TRKJJ', 'Teknik Sipil'),
  ('D-IV Jaringan Telekomunikasi Digital', 'Teknik Elektro'),
  ('D-IV Teknik Elektronika', 'Teknik Elektro')
GO

SELECT *
FROM pengguna.[User]

INSERT INTO pengguna.[User]
  (username, password, level)
VALUES
  ('0009107104', '123', 'admin-jurusan'),
  ('0009107105', '123', 'admin-pusat'),
  ('0009107123', '123', 'admin-pusat'),
  ('2341720235', '123', 'mahasiswa'),
  ('2341720234', '123', 'mahasiswa'),
  ('2341720236', '123', 'mahasiswa'),
  ('2341720237', '123', 'mahasiswa'),
  ('2341720212', '123', 'mahasiswa')
GO

INSERT INTO pengguna.Admin
  (NIDN, Nama, NIK, Tempat_lahir, tanggal_lahir, Alamat, Nomor_telepon, Jenis_kelamin, username)
VALUES
  ('0009107104', 'Supardi', '3212234567890133', 'Surabaya', '1980-01-15', 'Jl. Rajawali 1', '081245678900', 'Laki-laki', '0009107104'),
  ('0009107105', 'Sulistiyowati', '3212234567890134', 'Jakarta', '1975-09-23', 'Jl. Elang 2', '081245678901', 'Perempuan', '0009107105'),
  ('0009107123', 'Sudirman Dyayadiningrat', '3212234567890135', 'Bandung', '1983-03-12', 'Jl. Garuda 3', '081245678902', 'Laki-laki', '0009107123');
GO

INSERT INTO pengguna.Mahasiswa
  (NIM, Nama, NIK, Tempat_lahir, tanggal_lahir, Alamat, Nomor_telepon, Jenis_kelamin, ID_prodi, username)
VALUES
  ('2341720235', 'Innama Maesa Putri', '3213234567890121', 'Surabaya', '2003-07-19', 'Jl. Bunga 1', '081234567910', 'Perempuan', 1, '2341720235'),
  ('2341720234', 'Muhammad Nur Aziz', '3213234567890122', 'Malang', '2002-02-25', 'Jl. Bunga 2', '081234567911', 'Laki-laki', 2, '2341720234'),
  ('2341720236', 'Hidayat Widi Saputra', '3213234567890123', 'Yogyakarta', '2003-11-11', 'Jl. Bunga 3', '081234567912', 'Laki-laki', 3, '2341720236'),
  ('2341720237', 'Beryl Funky Mubarok', '3213234567890124', 'Jakarta', '2004-05-30', 'Jl. Bunga 4', '081234567913', 'Laki-laki', 4, '2341720237'),
  ('2341720212', 'Candra Ahmad Dani', '3213234567890125', 'Bandung', '2003-08-15', 'Jl. Bunga 5', '081234567914', 'Laki-laki', 5, '2341720212');
GO

INSERT INTO pengguna.[User]
  (username, password, level)
VALUES
  ('20230001', 'password3', 'mahasiswa'),
  ('20230002', 'password4', 'mahasiswa'),
  ('20230003', 'password5', 'mahasiswa'),
  ('20230004', 'password6', 'mahasiswa'),
  ('20230005', 'password7', 'mahasiswa'),
  ('20230006', 'password8', 'mahasiswa'),
  ('20230007', 'password9', 'mahasiswa'),
  ('20230008', 'password10', 'mahasiswa');
GO

INSERT INTO pengguna.Mahasiswa
  (NIM, Nama, NIK, Tempat_lahir, tanggal_lahir, Alamat, Nomor_telepon, Jenis_kelamin, ID_prodi, username)
VALUES
  ('20230001', 'Ahmad Fauzi', '3211234567890123', 'Bandung', '2003-05-12', 'Jl. Mawar 1', '081234567890', 'Laki-laki', 1, '20230001'),
  ('20230002', 'Rina Sari', '3211234567890124', 'Jakarta', '2004-03-23', 'Jl. Melati 2', '081234567891', 'Perempuan', 2, '20230002'),
  ('20230003', 'Siti Aminah', '3211234567890125', 'Surabaya', '2003-11-18', 'Jl. Anggrek 3', '081234567892', 'Perempuan', 3, '20230003'),
  ('20230004', 'Budi Prasetyo', '3211234567890126', 'Semarang', '2002-01-20', 'Jl. Kamboja 4', '081234567893', 'Laki-laki', 4, '20230004'),
  ('20230005', 'Dewi Kusuma', '3211234567890127', 'Malang', '2003-07-14', 'Jl. Cempaka 5', '081234567894', 'Perempuan', 5, '20230005'),
  ('20230006', 'Andi Wijaya', '3211234567890128', 'Medan', '2004-10-25', 'Jl. Dahlia 6', '081234567895', 'Laki-laki', 6, '20230006'),
  ('20230007', 'Rizky Putra', '3211234567890129', 'Palembang', '2002-09-09', 'Jl. Melur 7', '081234567896', 'Laki-laki', 7, '20230007'),
  ('20230008', 'Nina Astuti', '3211234567890130', 'Makassar', '2003-12-01', 'Jl. Teratai 8', '081234567897', 'Perempuan', 8, '20230008')
GO

INSERT INTO dokumen.Dokumen
  (Nama_dokumen, Tingkat)
VALUES
  ('Laporan Skripsi / Tugas Akhir', 'Jurusan'),
  ('Aplikasi / program TA', 'Jurusan'),
  ('Surat Pernyataan Publikasi Jurnal', 'Jurusan'),
  ('Tanda Terima Penyerahan Laporan Tugas Akhir/Skripsi', 'Jurusan'),
  ('Tanda Terima Penyerahan Laporan PKL/Magang', 'Jurusan'),
  ('Surat Bebas Kompen', 'Jurusan'),
  ('Upload Scan TOEIC', 'Jurusan'),
  ('Surat Bebas Tanggungan Jurusan', 'Pusat'),
  ('Surat Bebas Tanggungan Akademik Pusat', 'Pusat'),
  ('Surat Bebas Pustaka dari Perpustakaan Polinema', 'Pusat'),
  ('Surat Kebenaran Data Diri', 'Pusat'),
  ('Bukti Pengisian Kuisioner Kantor Jaminan Mutu', 'Pusat'),
  ('Bukti Pengisian SKPI', 'Pusat');
GO

INSERT INTO dokumen.Upload_dokumen
  (Path_dokumen, Status, Komentar, ID_dokumen, NIM, NIDN)
VALUES
  -- Data dengan status diverifikasi
  ('/uploads/skripsi_2341720235.pdf', 'Diverifikasi', NULL, 1, '2341720235', '0009107104'),
  ('/uploads/program_ta_2341720234.zip', 'Diverifikasi', NULL, 2, '2341720234', '0009107105'),
  ('/uploads/publikasi_2341720236.pdf', 'Diverifikasi', NULL, 3, '2341720236', '0009107105'),
  ('/uploads/tugas_akhir_2341720237.pdf', 'Diverifikasi', NULL, 4, '2341720237', '0009107104'),
  ('/uploads/pkl_2341720212.pdf', 'Diverifikasi', NULL, 5, '2341720212', '0009107123'),

  -- Data dengan status ditolak
  ('/uploads/bebas_kompen_2341720235.pdf', 'Ditolak', 'Dokumen tidak lengkap', 6, '2341720235', '0009107104'),
  ('/uploads/scan_toeic_2341720234.pdf', 'Ditolak', 'Dokumen tidak valid', 7, '2341720234', '0009107105'),

  -- Data dengan status menunggu
  ('/uploads/bebas_tanggung_jurusan_2341720236.pdf', 'Menunggu', NULL, 8, '2341720236', NULL),
  ('/uploads/bebas_tanggung_akademik_2341720237.pdf', 'Menunggu', NULL, 9, '2341720237', NULL),
  ('/uploads/pustaka_polinema_2341720212.pdf', 'Menunggu', NULL, 10, '2341720212', NULL);
GO

ALTER TABLE dokumen.Upload_dokumen
ADD tanggal DATETIME NOT NULL DEFAULT GETDATE();
GO

ALTER TABLE dokumen.Upload_dokumen
DROP COLUMN Komentar;
GO

CREATE TABLE dokumen.Komentar
(
  ID INT NOT NULL IDENTITY PRIMARY KEY,
  isi_komentar NVARCHAR(MAX) NOT NULL,
  tanggal DATETIME NOT NULL DEFAULT GETDATE(),
  ID_upload INT NOT NULL,
  CONSTRAINT FK_Komentar_Upload FOREIGN KEY(ID_upload) REFERENCES dokumen.Upload_dokumen(ID)
);
GO

UPDATE dokumen.Upload_dokumen
SET tanggal = CASE 
  WHEN Status = 'Diverifikasi' THEN '2024-11-01'
  WHEN Status = 'Ditolak' THEN '2024-11-10'
  WHEN Status = 'Menunggu' THEN '2024-11-20'
  ELSE GETDATE()
END;
GO

-- Tambahkan data komentar baru untuk testing
INSERT INTO dokumen.Komentar
  (isi_komentar, tanggal, ID_upload)
VALUES
  ('Revisi dokumen diperlukan.', '2024-11-12', 6),
  -- ID upload dokumen yang ditolak
  ('Perlu tambahan lampiran.', '2024-11-15', 7);  -- ID upload dokumen yang ditolak
GO


SELECT * FROM dokumen.Upload_dokumen

SELECT * FROM dokumen.Komentar