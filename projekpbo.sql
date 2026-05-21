-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 21 Bulan Mei 2026 pada 00.29
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekpbo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kekosongan_obat`
--

CREATE TABLE `kekosongan_obat` (
  `id_kekosongan` int NOT NULL,
  `id_obat` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kekosongan_obat`
--

INSERT INTO `kekosongan_obat` (`id_kekosongan`, `id_obat`, `tanggal`, `keterangan`) VALUES
(1, 3, '2026-04-10', 'Stok menipis karena keterlambatan pengiriman suplier'),
(2, 5, '2026-04-12', 'Barang kosong dari distributor pusat'),
(3, 2, '2026-04-15', 'Permintaan meningkat tajam'),
(4, 1, '2026-04-18', 'Menunggu proses pengadaan disetujui'),
(5, 3, '2026-04-21', 'Stok benar-benar nol di rak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id_obat` int NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `stok` int DEFAULT '0',
  `satuan` varchar(20) DEFAULT NULL,
  `tanggal_kadaluarsa` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `stok`, `satuan`, `tanggal_kadaluarsa`) VALUES
(1, 'Paracetamol 500mg', 135, 'Tablet', '2027-05-20'),
(2, 'Amoxicillin', 59, 'Strip', '2026-12-10'),
(3, 'OBH Bersin', 28, 'Botol', '2027-01-15'),
(4, 'Vitamin C 1000mg', 275, 'Tablet', '2028-03-30'),
(5, 'Betadine 30ml', 18, 'Botol', '2026-08-22'),
(6, 'Ibuprofen', 30, 'Tablet', '2027-02-22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukan_obat`
--

CREATE TABLE `pemasukan_obat` (
  `id_pemasukan` int NOT NULL,
  `id_obat` int DEFAULT NULL,
  `jumlah_masuk` int NOT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `id_pengguna` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pemasukan_obat`
--

INSERT INTO `pemasukan_obat` (`id_pemasukan`, `id_obat`, `jumlah_masuk`, `tanggal_masuk`, `id_pengguna`) VALUES
(16, 1, 50, '2026-04-01', 1),
(17, 2, 20, '2026-04-02', 6),
(18, 3, 10, '2026-04-05', 7),
(19, 4, 100, '2026-04-10', 8),
(20, 5, 5, '2026-04-12', 9),
(21, 6, 10, '2026-04-22', 1),
(22, 6, 15, '2026-05-19', 1);

--
-- Trigger `pemasukan_obat`
--
DELIMITER $$
CREATE TRIGGER `tambah_stok` AFTER INSERT ON `pemasukan_obat` FOR EACH ROW UPDATE obat SET stok = stok + NEW.jumlah_masuk WHERE id_obat = NEW.id_obat
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengadaan_obat`
--

CREATE TABLE `pengadaan_obat` (
  `id_pengadaan` int NOT NULL,
  `id_obat` int DEFAULT NULL,
  `jumlah_pengadaan` int DEFAULT NULL,
  `tanggal_pengajuan` date DEFAULT NULL,
  `status_pengadaan` enum('diajukan','disetujui','ditolak') DEFAULT 'diajukan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengadaan_obat`
--

INSERT INTO `pengadaan_obat` (`id_pengadaan`, `id_obat`, `jumlah_pengadaan`, `tanggal_pengajuan`, `status_pengadaan`) VALUES
(1, 1, 100, '2026-04-21', 'diajukan'),
(2, 3, 30, '2026-04-20', 'disetujui'),
(3, 5, 20, '2026-04-18', 'ditolak'),
(4, 2, 50, '2026-04-19', 'disetujui'),
(5, 4, 200, '2026-04-21', 'diajukan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran_obat`
--

CREATE TABLE `pengeluaran_obat` (
  `id_pengeluaran` int NOT NULL,
  `id_obat` int DEFAULT NULL,
  `jumlah_keluar` int NOT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  `id_pengguna` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengeluaran_obat`
--

INSERT INTO `pengeluaran_obat` (`id_pengeluaran`, `id_obat`, `jumlah_keluar`, `tanggal_keluar`, `id_pengguna`) VALUES
(1, 1, 10, '2026-04-15', 7),
(2, 2, 5, '2026-04-16', 7),
(3, 4, 25, '2026-04-18', 8),
(4, 3, 2, '2026-04-19', 6),
(5, 1, 5, '2026-04-20', 1),
(6, 2, 1, '2026-04-22', 1),
(7, 2, 1, '2026-04-22', 1),
(8, 6, 1, '2026-04-22', 1),
(9, 6, 1, '2026-04-22', 1),
(10, 6, 1, '2026-04-22', 1),
(11, 6, 1, '2026-04-22', 1),
(12, 6, 1, '2026-04-22', 1),
(13, 6, 1, '2026-04-22', 1),
(14, 6, 1, '2026-04-22', 1),
(15, 6, 1, '2026-04-22', 1),
(16, 6, 1, '2026-04-22', 1),
(17, 6, 1, '2026-04-22', 1),
(18, 5, 1, '2026-05-19', 8),
(20, 2, 1, '2026-05-19', 1);

--
-- Trigger `pengeluaran_obat`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `pengeluaran_obat` FOR EACH ROW UPDATE obat SET stok = stok - NEW.jumlah_keluar WHERE id_obat = NEW.id_obat
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `status_aktif` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `nama_pengguna`, `status_aktif`) VALUES
(1, 'admin', 'admin', 'pembina asrama', 'aktif'),
(6, 'admin1', 'pass123', 'Budi Santoso', 'aktif'),
(7, 'staff_apotek', 'rahasia', 'Siti Aminah', 'aktif'),
(8, 'gudang_01', 'stok123', 'Andi Wijaya', 'aktif'),
(9, 'manager', 'manage99', 'Dewi Lestari', 'aktif'),
(10, 'admin2', 'adminoke', 'Rizky Pratama', 'nonaktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kekosongan_obat`
--
ALTER TABLE `kekosongan_obat`
  ADD PRIMARY KEY (`id_kekosongan`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indeks untuk tabel `pemasukan_obat`
--
ALTER TABLE `pemasukan_obat`
  ADD PRIMARY KEY (`id_pemasukan`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `pengadaan_obat`
--
ALTER TABLE `pengadaan_obat`
  ADD PRIMARY KEY (`id_pengadaan`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indeks untuk tabel `pengeluaran_obat`
--
ALTER TABLE `pengeluaran_obat`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kekosongan_obat`
--
ALTER TABLE `kekosongan_obat`
  MODIFY `id_kekosongan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pemasukan_obat`
--
ALTER TABLE `pemasukan_obat`
  MODIFY `id_pemasukan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `pengadaan_obat`
--
ALTER TABLE `pengadaan_obat`
  MODIFY `id_pengadaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_obat`
--
ALTER TABLE `pengeluaran_obat`
  MODIFY `id_pengeluaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kekosongan_obat`
--
ALTER TABLE `kekosongan_obat`
  ADD CONSTRAINT `kekosongan_obat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`);

--
-- Ketidakleluasaan untuk tabel `pemasukan_obat`
--
ALTER TABLE `pemasukan_obat`
  ADD CONSTRAINT `pemasukan_obat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`),
  ADD CONSTRAINT `pemasukan_obat_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Ketidakleluasaan untuk tabel `pengadaan_obat`
--
ALTER TABLE `pengadaan_obat`
  ADD CONSTRAINT `pengadaan_obat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`);

--
-- Ketidakleluasaan untuk tabel `pengeluaran_obat`
--
ALTER TABLE `pengeluaran_obat`
  ADD CONSTRAINT `pengeluaran_obat_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`),
  ADD CONSTRAINT `pengeluaran_obat_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
