-- -- Buat database BebasTanggungan
IF EXISTS (SELECT name FROM sys.databases WHERE name = N'BebasTanggungan')
    DROP DATABASE BebasTanggungan;
GO

CREATE DATABASE BebasTanggungan;
GO

-- -- Gunakan database BebasTanggungan
USE BebasTanggungan;
GO

-- Buat skema untuk setiap kelompok tabel
IF NOT EXISTS (SELECT *
FROM sys.schemas
WHERE name = 'Pengguna')
    EXEC ('CREATE SCHEMA Pengguna');
GO

IF NOT EXISTS (SELECT *
FROM sys.schemas
WHERE name = 'Tanggungan')
    EXEC ('CREATE SCHEMA Tanggungan');
GO

IF NOT EXISTS (SELECT *
FROM sys.schemas
WHERE name = 'Dokumen')
    EXEC ('CREATE SCHEMA Dokumen');
GO

-- Tabel Mahasiswa pada skema Pengguna
CREATE TABLE Pengguna.Mahasiswa
(
    NIM CHAR(10) PRIMARY KEY,
    Nama NVARCHAR(100) NOT NULL,
    NIK CHAR(16),
    TempatLahir NVARCHAR(50),
    TanggalLahir DATE,
    Alamat NVARCHAR(255),
    NomorTelepon VARCHAR(15),
    JenisKelamin CHAR(1),
    -- 'L' untuk Laki-laki, 'P' untuk Perempuan
    ProgramStudi NVARCHAR(50),
    Jurusan NVARCHAR(50),
    Status NVARCHAR(20),
    Foto VARBINARY(MAX),
    -- Kolom untuk menyimpan foto mahasiswa
    Username NVARCHAR(50)
);

-- Tabel User pada skema Pengguna (gunakan kurung siku untuk nama tabel User)
CREATE TABLE Pengguna.[User]
(
    Username NVARCHAR(50) PRIMARY KEY,
    Password NVARCHAR(255) NOT NULL,
    Level NVARCHAR(20)
    -- contoh: 'Admin', 'Mahasiswa'
);

-- Tabel Admin pada skema Pengguna
CREATE TABLE Pengguna.Admin
(
    NIDN CHAR(10) PRIMARY KEY,
    Nama NVARCHAR(100) NOT NULL,
    NIK CHAR(16),
    TempatLahir NVARCHAR(50),
    TanggalLahir DATE,
    Alamat NVARCHAR(255),
    NomorTelepon VARCHAR(15),
    JenisKelamin CHAR(1),
    -- 'L' untuk Laki-laki, 'P' untuk Perempuan
    Jurusan NVARCHAR(50),
    Username NVARCHAR(50) NOT NULL,
    FOREIGN KEY (Username) REFERENCES Pengguna.[User](Username)
);

-- Tabel Dokumen pada skema Dokumen
CREATE TABLE Dokumen.Dokumen
(
    ID INT PRIMARY KEY IDENTITY,
    NIM CHAR(10) NOT NULL,

    -- Kolom untuk menyimpan file PDF tiap jenis dokumen
    SuratBebasTanggunganJurusan VARBINARY(MAX),
    SuratBebasTanggunganAkademikPusat VARBINARY(MAX),
    SuratBebasKompen VARBINARY(MAX),
    SertifikatTOEIC VARBINARY(MAX),
    LaporanMagang VARBINARY(MAX),
    SuratBebasPustaka VARBINARY(MAX),
    SuratPernyataanPublikasi VARBINARY(MAX),
    AplikasiTugasAkhir VARBINARY(MAX),
    LaporanTugasAkhir VARBINARY(MAX),
    BuktiPengisianSKPI VARBINARY(MAX),
    BuktiPengisianKuesioner VARBINARY(MAX),
    SuratKebenaranDataDiri VARBINARY(MAX),

    -- Kolom status untuk masing-masing dokumen
    StatusSuratBebasTanggunganJurusan NVARCHAR(20),
    -- contoh: 'Menunggu Verifikasi', 'Disetujui', 'Ditolak'
    StatusSuratBebasTanggunganAkademikPusat NVARCHAR(20),
    StatusSuratBebasKompen NVARCHAR(20),
    StatusSertifikatTOEIC NVARCHAR(20),
    StatusLaporanMagang NVARCHAR(20),
    StatusSuratBebasPustaka NVARCHAR(20),
    StatusSuratPernyataanPublikasi NVARCHAR(20),
    StatusAplikasiTugasAkhir NVARCHAR(20),
    StatusLaporanTugasAkhir NVARCHAR(20),
    StatusBuktiPengisianSKPI NVARCHAR(20),
    StatusBuktiPengisianKuesioner NVARCHAR(20),
    StatusSuratKebenaranDataDiri NVARCHAR(20),

    FOREIGN KEY (NIM) REFERENCES Pengguna.Mahasiswa(NIM)
);

-- Tabel TanggunganPerpustakaan pada skema Tanggungan
CREATE TABLE Tanggungan.TanggunganPerpustakaan
(
    ID INT PRIMARY KEY IDENTITY,
    NIM CHAR(10) NOT NULL,
    Judul NVARCHAR(255),
    TanggalPeminjaman DATE,
    TanggalPengembalian DATE,
    Status NVARCHAR(20),
    -- contoh: 'Dipinjam', 'Dikembalikan'
    Lokasi NVARCHAR(50),
    FOREIGN KEY (NIM) REFERENCES Pengguna.Mahasiswa(NIM)
);

-- Tabel TanggunganUKT pada skema Tanggungan
CREATE TABLE Tanggungan.TanggunganUKT
(
    ID INT PRIMARY KEY IDENTITY,
    NIM CHAR(10) NOT NULL,
    TahunAkademik NVARCHAR(10),
    Status NVARCHAR(20),
    -- contoh: 'Terbayar', 'Belum Terbayar'
    Tagihan DECIMAL(10, 2),
    Keterangan NVARCHAR(255),
    FOREIGN KEY (NIM) REFERENCES Pengguna.Mahasiswa(NIM)
);

-- Tabel TanggunganSKKM pada skema Tanggungan
CREATE TABLE Tanggungan.TanggunganSKKM
(
    ID INT PRIMARY KEY IDENTITY,
    NIM CHAR(10) NOT NULL,
    Kegiatan NVARCHAR(255),
    Tingkat NVARCHAR(50),
    -- contoh: 'Lokal', 'Nasional', 'Internasional'
    Poin INT,
    FOREIGN KEY (NIM) REFERENCES Pengguna.Mahasiswa(NIM)
);

-- Tabel TanggunganKompensasi pada skema Tanggungan
CREATE TABLE Tanggungan.TanggunganKompensasi
(
    ID INT PRIMARY KEY IDENTITY,
    NIM CHAR(10) NOT NULL,
    Tugas NVARCHAR(255),
    Jam INT,
    Status NVARCHAR(20),
    -- contoh: 'Selesai', 'Belum Selesai'
    FOREIGN KEY (NIM) REFERENCES Pengguna.Mahasiswa(NIM)
);

-- Tambahkan foreign key untuk Username di tabel Mahasiswa
ALTER TABLE Pengguna.Mahasiswa
ADD FOREIGN KEY (Username) REFERENCES Pengguna.[User](Username);
