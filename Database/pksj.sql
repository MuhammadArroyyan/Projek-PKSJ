-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2025 at 08:48 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uk_2301020117`
--

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` int UNSIGNED NOT NULL,
  `nama_fakultas` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `nama_fakultas`) VALUES
(1, 'FTTK');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int UNSIGNED NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_pertanyaan` int UNSIGNED NOT NULL,
  `id_pilihan_jawaban_pertanyaan` int UNSIGNED NOT NULL,
  `id_periode` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jawaban`
--

INSERT INTO `jawaban` (`id_jawaban`, `nim`, `id_pertanyaan`, `id_pilihan_jawaban_pertanyaan`, `id_periode`) VALUES
(1, '2301020117', 1, 3, 1),
(2, '2301020117', 2, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int UNSIGNED NOT NULL,
  `nama_jurusan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_fakultas` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `id_fakultas`) VALUES
(1, 'Jurusan Teknik Elektro dan Informatika', 1),
(2, 'Jurusan Teknik Industri Maritim', 1),
(3, 'Jurusan Teknik Sipil dan Arsitektur', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_mahasiswa` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_user` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama_mahasiswa`, `id_user`) VALUES
('2301020117', 'Muhammad Arroyyan Hamel', 6);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(9, '2025-12-14-071028', 'App\\Database\\Migrations\\InitialDbSetup', 'default', 'App', 1765701972, 1),
(10, '2025-12-14-072655', 'App\\Database\\Migrations\\AddPasswordToUsers', 'default', 'App', 1765701972, 1);

-- --------------------------------------------------------

--
-- Table structure for table `periode_kuisioner`
--

CREATE TABLE `periode_kuisioner` (
  `id_periode` int UNSIGNED NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL,
  `status_periode` enum('aktif','non-aktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periode_kuisioner`
--

INSERT INTO `periode_kuisioner` (`id_periode`, `keterangan`, `status_periode`) VALUES
(1, 'Ujian Kompetensi Semester Ganjil 2025/2026', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` int UNSIGNED NOT NULL,
  `pertanyaan` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_prodi` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pertanyaan`
--

INSERT INTO `pertanyaan` (`id_pertanyaan`, `pertanyaan`, `id_prodi`) VALUES
(1, 'Apakah materi perkuliahan disampaikan sesuai RPS?', 8),
(2, 'Bagaimana kedisiplinan dosen dalam mengajar?', 8);

-- --------------------------------------------------------

--
-- Table structure for table `pertanyaan_periode_kuisioner`
--

CREATE TABLE `pertanyaan_periode_kuisioner` (
  `id_pertanyaan_periode_kuisioner` int UNSIGNED NOT NULL,
  `id_periode_kuisioner` int UNSIGNED NOT NULL,
  `id_pertanyaan` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pertanyaan_periode_kuisioner`
--

INSERT INTO `pertanyaan_periode_kuisioner` (`id_pertanyaan_periode_kuisioner`, `id_periode_kuisioner`, `id_pertanyaan`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pilihan_jawaban_pertanyaan`
--

CREATE TABLE `pilihan_jawaban_pertanyaan` (
  `id_pilihan_jawaban` int UNSIGNED NOT NULL,
  `deskripsi_pilihan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `id_pertanyaan` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pilihan_jawaban_pertanyaan`
--

INSERT INTO `pilihan_jawaban_pertanyaan` (`id_pilihan_jawaban`, `deskripsi_pilihan`, `id_pertanyaan`) VALUES
(1, 'Sangat Baik', 1),
(2, 'Baik', 1),
(3, 'Cukup', 1),
(4, 'Kurang', 1),
(5, 'Sangat Baik', 2),
(6, 'Baik', 2),
(7, 'Cukup', 2),
(8, 'Kurang', 2);

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int UNSIGNED NOT NULL,
  `nama_prodi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `id_user_kaprodi` int UNSIGNED DEFAULT NULL,
  `id_jurusan` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `nama_prodi`, `id_user_kaprodi`, `id_jurusan`) VALUES
(2, 'Teknik Elektro', NULL, 1),
(3, 'Teknik Perkapalan', NULL, 2),
(4, 'Teknik Industri', NULL, 2),
(5, 'Kimia', NULL, 2),
(6, 'Teknik Sipil', NULL, 3),
(7, 'Perancangan Wilayah Kota', NULL, 3),
(8, 'Teknik Informatika', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int UNSIGNED NOT NULL,
  `nama_user` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '$2y$10$TEazZy5CwRUC4HejAAWOi.GafwSjTxAuL1JSYPL5iM2OHaAce/MHi',
  `role` enum('admin','kaprodi','mahasiswa','pimpinan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `password`, `role`) VALUES
(1, 'Admin', '$2y$10$TEazZy5CwRUC4HejAAWOi.GafwSjTxAuL1JSYPL5iM2OHaAce/MHi', 'admin'),
(5, 'Kaprodi Informatika', '$2y$10$TEazZy5CwRUC4HejAAWOi.GafwSjTxAuL1JSYPL5iM2OHaAce/MHi', 'kaprodi'),
(6, 'Muhammad Arroyyan Hamel', '$2y$10$TEazZy5CwRUC4HejAAWOi.GafwSjTxAuL1JSYPL5iM2OHaAce/MHi', 'mahasiswa'),
(7, 'Dekan', '$2y$10$TEazZy5CwRUC4HejAAWOi.GafwSjTxAuL1JSYPL5iM2OHaAce/MHi', 'pimpinan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indexes for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `jawaban_nim_foreign` (`nim`),
  ADD KEY `jawaban_id_pertanyaan_foreign` (`id_pertanyaan`),
  ADD KEY `jawaban_id_pilihan_jawaban_pertanyaan_foreign` (`id_pilihan_jawaban_pertanyaan`),
  ADD KEY `jawaban_id_periode_foreign` (`id_periode`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`),
  ADD KEY `jurusan_id_fakultas_foreign` (`id_fakultas`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `mahasiswa_id_user_foreign` (`id_user`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periode_kuisioner`
--
ALTER TABLE `periode_kuisioner`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indexes for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`),
  ADD KEY `pertanyaan_id_prodi_foreign` (`id_prodi`);

--
-- Indexes for table `pertanyaan_periode_kuisioner`
--
ALTER TABLE `pertanyaan_periode_kuisioner`
  ADD PRIMARY KEY (`id_pertanyaan_periode_kuisioner`),
  ADD KEY `pertanyaan_periode_kuisioner_id_periode_kuisioner_foreign` (`id_periode_kuisioner`),
  ADD KEY `pertanyaan_periode_kuisioner_id_pertanyaan_foreign` (`id_pertanyaan`);

--
-- Indexes for table `pilihan_jawaban_pertanyaan`
--
ALTER TABLE `pilihan_jawaban_pertanyaan`
  ADD PRIMARY KEY (`id_pilihan_jawaban`),
  ADD KEY `pilihan_jawaban_pertanyaan_id_pertanyaan_foreign` (`id_pertanyaan`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `prodi_id_user_kaprodi_foreign` (`id_user_kaprodi`),
  ADD KEY `prodi_id_jurusan_foreign` (`id_jurusan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id_fakultas` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id_jawaban` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `periode_kuisioner`
--
ALTER TABLE `periode_kuisioner`
  MODIFY `id_periode` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pertanyaan_periode_kuisioner`
--
ALTER TABLE `pertanyaan_periode_kuisioner`
  MODIFY `id_pertanyaan_periode_kuisioner` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pilihan_jawaban_pertanyaan`
--
ALTER TABLE `pilihan_jawaban_pertanyaan`
  MODIFY `id_pilihan_jawaban` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawaban_id_periode_foreign` FOREIGN KEY (`id_periode`) REFERENCES `periode_kuisioner` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_id_pertanyaan_foreign` FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_id_pilihan_jawaban_pertanyaan_foreign` FOREIGN KEY (`id_pilihan_jawaban_pertanyaan`) REFERENCES `pilihan_jawaban_pertanyaan` (`id_pilihan_jawaban`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jawaban_nim_foreign` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_id_fakultas_foreign` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Constraints for table `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD CONSTRAINT `pertanyaan_id_prodi_foreign` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pertanyaan_periode_kuisioner`
--
ALTER TABLE `pertanyaan_periode_kuisioner`
  ADD CONSTRAINT `pertanyaan_periode_kuisioner_id_periode_kuisioner_foreign` FOREIGN KEY (`id_periode_kuisioner`) REFERENCES `periode_kuisioner` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pertanyaan_periode_kuisioner_id_pertanyaan_foreign` FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pilihan_jawaban_pertanyaan`
--
ALTER TABLE `pilihan_jawaban_pertanyaan`
  ADD CONSTRAINT `pilihan_jawaban_pertanyaan_id_pertanyaan_foreign` FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan` (`id_pertanyaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_id_jurusan_foreign` FOREIGN KEY (`id_jurusan`) REFERENCES `jurusan` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prodi_id_user_kaprodi_foreign` FOREIGN KEY (`id_user_kaprodi`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
