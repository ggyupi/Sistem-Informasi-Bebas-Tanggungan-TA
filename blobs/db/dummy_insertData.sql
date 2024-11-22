-- Data untuk tabel User
INSERT INTO Pengguna.[User]
    (Username, Password, Level)
VALUES
    ('ahmads', 'password123', 'Mahasiswa'),
    ('budis', 'password123', 'Mahasiswa'),
    ('citraa', 'password123', 'Mahasiswa'),
    ('dianp', 'password123', 'Mahasiswa'),
    ('ediw', 'password123', 'Mahasiswa'),
    ('firae', 'password123', 'Mahasiswa'),
    ('gilangp', 'password123', 'Mahasiswa'),
    ('hendryu', 'password123', 'Mahasiswa'),
    ('indahs', 'password123', 'Mahasiswa'),
    ('jojoa', 'password123', 'Mahasiswa'),
    ('kamila', 'password123', 'Mahasiswa'),
    ('lukmanh', 'password123', 'Mahasiswa'),
    ('marias', 'password123', 'Mahasiswa'),
    ('ninas', 'password123', 'Mahasiswa'),
    ('opiqa', 'password123', 'Mahasiswa'),
    ('rizals', 'password123', 'Mahasiswa'),
    ('susand', 'password123', 'Mahasiswa'),
    ('tommyd', 'password123', 'Mahasiswa'),
    ('utamib', 'password123', 'Mahasiswa'),
    ('vianah', 'password123', 'Mahasiswa'),
    ('admin1', 'adminpass', 'Admin'),
    ('admin2', 'adminpass', 'Admin');

-- Data untuk tabel Mahasiswa
INSERT INTO Pengguna.Mahasiswa
    (NIM, Nama, NIK, TempatLahir, TanggalLahir, Alamat, NomorTelepon, JenisKelamin, ProgramStudi, Jurusan, Status, Foto, Username)
VALUES
    ('200101001', 'Ahmad Santoso', '3174010101010001', 'Jakarta', '2001-01-01', 'Jl. Merdeka No.1', '081234567890', 'L', 'Teknik Informatika', 'Teknik', 'Aktif', NULL, 'ahmads'),
    ('200101002', 'Budi Sutrisno', '3174010202020002', 'Bandung', '2001-02-02', 'Jl. Sudirman No.2', '081234567891', 'L', 'Teknik Mesin', 'Teknik', 'Aktif', NULL, 'budis'),
    ('200101003', 'Citra Anggraini', '3174010303030003', 'Surabaya', '2001-03-03', 'Jl. Diponegoro No.3', '081234567892', 'P', 'Sistem Informasi', 'Ekonomi', 'Aktif', NULL, 'citraa'),
    ('200101004', 'Dian Purnama', '3174010404040004', 'Yogyakarta', '2001-04-04', 'Jl. Malioboro No.4', '081234567893', 'P', 'Teknik Elektro', 'Teknik', 'Aktif', NULL, 'dianp'),
    ('200101005', 'Edi Wibowo', '3174010505050005', 'Semarang', '2001-05-05', 'Jl. Pahlawan No.5', '081234567894', 'L', 'Teknik Industri', 'Teknik', 'Aktif', NULL, 'ediw'),
    ('200101006', 'Fira Effendi', '3174010606060006', 'Medan', '2001-06-06', 'Jl. Merdeka No.6', '081234567895', 'P', 'Manajemen', 'Ekonomi', 'Aktif', NULL, 'firae'),
    ('200101007', 'Gilang Pratama', '3174010707070007', 'Palembang', '2001-07-07', 'Jl. Angkatan 45 No.7', '081234567896', 'L', 'Akuntansi', 'Ekonomi', 'Aktif', NULL, 'gilangp'),
    ('200101008', 'Hendry Utama', '3174010808080008', 'Makassar', '2001-08-08', 'Jl. Veteran No.8', '081234567897', 'L', 'Teknik Kimia', 'Teknik', 'Aktif', NULL, 'hendryu'),
    ('200101009', 'Indah Sari', '3174010909090009', 'Padang', '2001-09-09', 'Jl. Samudera No.9', '081234567898', 'P', 'Teknik Sipil', 'Teknik', 'Aktif', NULL, 'indahs'),
    ('200101010', 'Jojo Ardi', '3174011010100010', 'Bali', '2001-10-10', 'Jl. Raya No.10', '081234567899', 'L', 'Desain Produk', 'Desain', 'Aktif', NULL, 'jojoa'),
    ('200101011', 'Kamila Arsy', '3174011111110011', 'Malang', '2001-11-11', 'Jl. Gajayana No.11', '081234567800', 'P', 'Kedokteran', 'Kesehatan', 'Aktif', NULL, 'kamila'),
    ('200101012', 'Lukman Hakim', '3174011212120012', 'Pontianak', '2001-12-12', 'Jl. Tanjungpura No.12', '081234567801', 'L', 'Teknik Informatika', 'Teknik', 'Aktif', NULL, 'lukmanh'),
    ('200101013', 'Maria Simanjuntak', '3174011313130013', 'Pematangsiantar', '2001-01-13', 'Jl. Medan No.13', '081234567802', 'P', 'Psikologi', 'Sosial', 'Aktif', NULL, 'marias'),
    ('200101014', 'Nina Sari', '3174011414140014', 'Denpasar', '2001-02-14', 'Jl. Sudirman No.14', '081234567803', 'P', 'Bioteknologi', 'Sains', 'Aktif', NULL, 'ninas'),
    ('200101015', 'Opiq Abdul', '3174011515150015', 'Aceh', '2001-03-15', 'Jl. Banda Aceh No.15', '081234567804', 'L', 'Keperawatan', 'Kesehatan', 'Aktif', NULL, 'opiqa'),
    ('200101016', 'Rizal Sutanto', '3174011616160016', 'Kupang', '2001-04-16', 'Jl. Soekarno No.16', '081234567805', 'L', 'Pendidikan Bahasa', 'Humaniora', 'Aktif', NULL, 'rizals'),
    ('200101017', 'Susan Dewi', '3174011717170017', 'Solo', '2001-05-17', 'Jl. Adi Sucipto No.17', '081234567806', 'P', 'Farmasi', 'Kesehatan', 'Aktif', NULL, 'susand'),
    ('200101018', 'Tommy Darto', '3174011818180018', 'Palopo', '2001-06-18', 'Jl. Pattimura No.18', '081234567807', 'L', 'Ilmu Hukum', 'Sosial', 'Aktif', NULL, 'tommyd'),
    ('200101019', 'Utami Br', '3174011919190019', 'Manado', '2001-07-19', 'Jl. Sam Ratulangi No.19', '081234567808', 'P', 'Sastra Indonesia', 'Humaniora', 'Aktif', NULL, 'utamib'),
    ('200101020', 'Viana Hutapea', '3174012020200020', 'Ambon', '2001-08-20', 'Jl. Ambon No.20', '081234567809', 'P', 'Geografi', 'Sains', 'Aktif', NULL, 'vianah');

-- Data untuk tabel Admin
INSERT INTO Pengguna.Admin
    (NIDN, Nama, NIK, TempatLahir, TanggalLahir, Alamat, NomorTelepon, JenisKelamin, Jurusan, Username)
VALUES
    ('100101001', 'Admin Satu', '3174012121210001', 'Jakarta', '1980-01-01', 'Jl. Administrasi No.1', '081111111111', 'L', 'Teknik', 'admin1'),
    ('100101002', 'Admin Dua', '3174012222220002', 'Bandung', '1981-02-02', 'Jl. Admin Dua No.2', '081222222222', 'L', 'Ekonomi', 'admin2');

-- Tambah data ke tabel TanggunganUKT
INSERT INTO Tanggungan.TanggunganUKT
    (NIM, TahunAkademik, Status, Tagihan, Keterangan)
VALUES
    ('200101001', '2023/2024', 'Terbayar', 5000000.00, 'UKT Beasiswa'),
    ('200101002', '2023/2024', 'Belum Terbayar', 5000000.00, 'UKT Mandiri'),
    ('200101003', '2023/2024', 'Terbayar', 7500000.00, 'UKT SNBT'),
    ('200101004', '2023/2024', 'Belum Terbayar', 5000000.00, 'UKT Beasiswa'),
    ('200101005', '2023/2024', 'Terbayar', 7500000.00, 'UKT Mandiri'),
    ('200101006', '2023/2024', 'Terbayar', 6500000.00, 'UKT SNBP'),
    ('200101007', '2023/2024', 'Belum Terbayar', 5500000.00, 'UKT Mandiri'),
    ('200101008', '2023/2024', 'Terbayar', 6000000.00, 'UKT SNBT'),
    ('200101009', '2023/2024', 'Belum Terbayar', 5000000.00, 'UKT Beasiswa'),
    ('200101010', '2023/2024', 'Terbayar', 7000000.00, 'UKT Mandiri'),
    ('200101011', '2023/2024', 'Terbayar', 5000000.00, 'UKT Beasiswa'),
    ('200101012', '2023/2024', 'Belum Terbayar', 7500000.00, 'UKT SNBP'),
    ('200101013', '2023/2024', 'Terbayar', 8000000.00, 'UKT Mandiri'),
    ('200101014', '2023/2024', 'Belum Terbayar', 5500000.00, 'UKT SNBT'),
    ('200101015', '2023/2024', 'Terbayar', 7000000.00, 'UKT Beasiswa'),
    ('200101016', '2023/2024', 'Belum Terbayar', 6000000.00, 'UKT SNBT'),
    ('200101017', '2023/2024', 'Terbayar', 6500000.00, 'UKT Mandiri'),
    ('200101018', '2023/2024', 'Belum Terbayar', 5000000.00, 'UKT Beasiswa'),
    ('200101019', '2023/2024', 'Terbayar', 7000000.00, 'UKT SNBP'),
    ('200101020', '2023/2024', 'Belum Terbayar', 5000000.00, 'UKT Mandiri');

-- Tambah data ke tabel TanggunganSKKM dengan poin berkisar antara 0.5 - 2
INSERT INTO Tanggungan.TanggunganSKKM
    (NIM, Kegiatan, Tingkat, Poin)
VALUES
    ('200101001', 'Lomba Cerdas Cermat', 'Nasional', 1.5),
    ('200101002', 'Seminar Nasional', 'Nasional', 2.0),
    ('200101003', 'Pelatihan Pemrograman', 'Lokal', 1.0),
    ('200101004', 'Lomba Debat Bahasa Inggris', 'Internasional', 1.5),
    ('200101005', 'Lomba Fotografi', 'Nasional', 0.5),
    ('200101006', 'Seminar Teknologi', 'Lokal', 1.5),
    ('200101007', 'Workshop Kewirausahaan', 'Lokal', 1.0),
    ('200101008', 'Kegiatan Bakti Sosial', 'Nasional', 1.0),
    ('200101009', 'Lomba Esai', 'Nasional', 2.0),
    ('200101010', 'Pelatihan Kepemimpinan', 'Lokal', 0.5),
    ('200101011', 'Kegiatan Relawan Lingkungan', 'Internasional', 1.5),
    ('200101012', 'Lomba Sains', 'Nasional', 2.0),
    ('200101013', 'Diskusi Ilmiah', 'Lokal', 1.0),
    ('200101014', 'Pameran Seni', 'Nasional', 1.0),
    ('200101015', 'Lomba Pidato', 'Nasional', 1.5),
    ('200101016', 'Workshop Fotografi', 'Lokal', 0.5),
    ('200101017', 'Kegiatan Donor Darah', 'Nasional', 1.0),
    ('200101018', 'Lomba Desain Grafis', 'Internasional', 1.5),
    ('200101019', 'Pelatihan Bahasa Asing', 'Nasional', 1.0),
    ('200101020', 'Kegiatan Olahraga', 'Lokal', 0.5);

-- Tambah data ke tabel TanggunganKompensasi dengan tugas yang lebih spesifik
INSERT INTO Tanggungan.TanggunganKompensasi
    (NIM, Tugas, Jam, Status)
VALUES
    ('200101001', 'Kompensasi Kebersihan Ruang Kelas', 10, 'Selesai'),
    ('200101002', 'Kompensasi Kebersihan Perpustakaan', 5, 'Belum Selesai'),
    ('200101003', 'Kompensasi Kebersihan Laboratorium', 8, 'Selesai'),
    ('200101004', 'Kompensasi Kebersihan Kantin', 6, 'Belum Selesai'),
    ('200101005', 'Kompensasi Penyusunan Buku Perpustakaan', 7, 'Selesai'),
    ('200101006', 'Kompensasi Penataan Ruang Seminar', 4, 'Belum Selesai'),
    ('200101007', 'Kompensasi Kebersihan Asrama Mahasiswa', 9, 'Selesai'),
    ('200101008', 'Kompensasi Penataan Ruang Olahraga', 5, 'Belum Selesai'),
    ('200101009', 'Kompensasi Pengelolaan Sampah Kampus', 7, 'Selesai'),
    ('200101010', 'Kompensasi Perawatan Tanaman Kampus', 3, 'Belum Selesai'),
    ('200101011', 'Kompensasi Kebersihan Gedung Utama', 6, 'Selesai'),
    ('200101012', 'Kompensasi Pengawasan Parkir Kampus', 4, 'Belum Selesai'),
    ('200101013', 'Kompensasi Perawatan Lapangan', 8, 'Selesai'),
    ('200101014', 'Kompensasi Penyusunan Dokumen Kampus', 5, 'Belum Selesai'),
    ('200101015', 'Kompensasi Kebersihan Area Resepsionis', 3, 'Selesai'),
    ('200101016', 'Kompensasi Penyusunan Laboratorium Komputer', 7, 'Belum Selesai'),
    ('200101017', 'Kompensasi Penataan Ruang Baca', 5, 'Selesai'),
    ('200101018', 'Kompensasi Kebersihan Aula Kampus', 4, 'Belum Selesai'),
    ('200101019', 'Kompensasi Kebersihan Gedung Fakultas', 9, 'Selesai'),
    ('200101020', 'Kompensasi Penyusunan Arsip Administrasi', 6, 'Belum Selesai');

INSERT INTO Dokumen.Dokumen
    (NIM, SuratBebasTanggunganJurusan, StatusSuratBebasTanggunganJurusan, SuratBebasTanggunganAkademikPusat, StatusSuratBebasTanggunganAkademikPusat, SuratBebasKompen, StatusSuratBebasKompen)
VALUES
    ('200101001', NULL, 'Menunggu Verifikasi', NULL, 'Disetujui', NULL, 'Ditolak'),
    ('200101002', NULL, 'Disetujui', NULL, 'Menunggu Verifikasi', NULL, 'Disetujui')

INSERT INTO Tanggungan.TanggunganPerpustakaan
    (NIM, Judul, TanggalPeminjaman, TanggalPengembalian, Status, Lokasi)
VALUES
    ('200101001', 'Algoritma dan Struktur Data', '2023-01-10', '2023-02-10', 'Dikembalikan', 'Perpustakaan A'),
    ('200101002', 'Basis Data', '2023-01-15', NULL, 'Dipinjam', 'Perpustakaan B')
