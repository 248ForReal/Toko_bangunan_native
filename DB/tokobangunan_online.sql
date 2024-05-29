-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 29, 2024 at 10:53 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokobangunan_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `uuid`, `nama_admin`, `username`, `password`, `role`, `createdAt`, `updatedAt`) VALUES
(1, 'b8a5b84b-f94f-4e0c-8d18-68aa02cdf009', 'admin', 'admin', '$argon2id$v=19$m=65536,t=3,p=4$/RSEecNRjr6OaH9jrdv6VQ$hWfOhSeNuDS2+i+2oU1S8IzLIjepXJ/630y6CClE62M', 'admin', '2024-02-03 06:49:46', '2024-02-04 08:07:42'),
(3, '68f8a935-f7c5-41b3-90e2-0231445937b5', 'kasir', 'kasir', '$argon2id$v=19$m=65536,t=3,p=4$g9EDidXid0nm/FwqFfWaXw$mFUutJEQOnGq11b4MLQ6IbMB8QdUEUdB36JN2r8X0+8', 'kasir', '2024-02-13 21:21:57', '2024-02-13 21:21:57'),
(4, '20714468-0b4c-4e1b-b51d-64c3769d5de8', 'admin2', 'admin2', '$argon2id$v=19$m=65536,t=3,p=4$FQ8SxndgjD8l/ZMiedweoQ$e100tXMcPHrKwp3wgvx+Iv+Ly9QNXXwtnDF07h4+AzA', 'admin', '2024-02-26 13:34:43', '2024-02-26 13:34:43');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `barcode_barang` int DEFAULT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_id` int DEFAULT NULL,
  `harga_modal` float NOT NULL,
  `harga_jual` float DEFAULT NULL,
  `persen_keuntungan` float DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='berubah';

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `barcode_barang`, `nama_barang`, `kategori_id`, `harga_modal`, `harga_jual`, `persen_keuntungan`, `stok`, `createdAt`, `updatedAt`) VALUES
(1, 1234567891, 'kran Taman Steinless', 1, 10000, 15000, 0.5, 77, '2024-02-13 22:05:52', '2024-02-28 16:20:32'),
(2, 1234567892, 'Kran Angsa SOLEGON', 1, 42000, 52000, 0.3, 94, '2024-02-13 22:06:07', '2024-02-27 21:01:09'),
(3, 1234567894, 'Kran Angsa ONO', 1, 68000, 88000, 0.3, 96, '2024-02-13 22:06:46', '2024-02-27 20:44:46'),
(4, 1234567895, 'Saklar Seri', 1, 8000, 10400, 0.3, 91, '2024-02-13 22:06:56', '2024-02-27 21:01:09'),
(5, 1234567896, 'Plat Panasonic 3L', 1, 9000, 11700, 0.3, 96, '2024-02-13 22:07:07', '2024-02-27 20:37:28'),
(6, 1234567898, 'Plat Panasonic 1L', 1, 9000, 11700, 0.3, 112, '2024-02-13 22:07:27', '2024-02-28 16:20:32'),
(7, 1234567899, 'Stop Kontak Panasonic', 1, 10000, 13000, 0.3, 57, '2024-02-13 22:07:39', '2024-02-27 21:01:09'),
(8, 1234567910, 'Fitling Gantungan Hitam Voltama', 1, 5000, 6500, 0.3, 93, '2024-02-13 22:08:00', '2024-02-27 21:01:09'),
(9, 1234567893, 'Kran Angsa CAB', 1, 30000, 39000, 0.3, 149, '2024-02-13 22:09:26', '2024-02-27 21:01:09'),
(10, 1234567897, 'Plat Panasonic 2L', 1, 9000, 11700, 0.3, 91, '2024-02-13 22:09:39', '2024-02-27 14:31:23'),
(12, 312412, 'wefew', 1, 5000, 6500, 0.3, 4, '2024-02-25 22:24:50', '2024-02-27 20:44:09'),
(13, 11555546, 'asep', 1, 1212210, 2303200, 0.9, 12, '2024-02-26 22:45:17', '2024-02-26 22:45:17'),
(14, 1515131, 'gancu lucu', 1, 2000, 20000, NULL, 44, '2024-05-29 06:29:11', '2024-05-29 06:29:26'),
(15, 88888015, 'aseptaa', 1, 2000, 10000, NULL, 55, '2024-05-29 06:29:47', '2024-05-29 06:29:47'),
(16, 88888816, 'gancu lucu', 1, 2000, 10000, NULL, 56, '2024-05-29 06:52:22', '2024-05-29 06:52:22'),
(17, 10254467, 'parang kocak', 1, 5000, 20000, NULL, 78, '2024-05-29 06:58:50', '2024-05-29 06:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` int NOT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `kategori`, `createdAt`, `updatedAt`) VALUES
(1, 'perkakas', '2024-02-04 11:33:46', '2024-02-04 11:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sid` varchar(36) NOT NULL,
  `expires` datetime DEFAULT NULL,
  `data` text,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`sid`, `expires`, `data`, `createdAt`, `updatedAt`) VALUES
('40I2k3De2S6VsGJXg8bZK3mRbqOqfmuT', '2024-02-29 17:07:00', '{\"cookie\":{\"originalMaxAge\":86400000,\"expires\":\"2024-02-29T10:07:00.772Z\",\"secure\":true,\"httpOnly\":true,\"path\":\"/\"}}', '2024-02-28 17:07:00', '2024-02-28 17:07:00'),
('fiJvw7HYbXdk4oVDtOToLSg6rUItCXPp', '2024-02-29 17:06:48', '{\"cookie\":{\"originalMaxAge\":86400000,\"expires\":\"2024-02-29T10:06:48.574Z\",\"secure\":true,\"httpOnly\":true,\"path\":\"/\"},\"userId\":\"b8a5b84b-f94f-4e0c-8d18-68aa02cdf009\"}', '2024-02-28 17:06:48', '2024-02-28 17:06:48');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `id_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_belanja` float NOT NULL,
  `jumlah_dibayarkan` float NOT NULL,
  `kembalian` float NOT NULL,
  `items` json NOT NULL,
  `nama_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barang`
--

CREATE TABLE `transaksi_barang` (
  `id` int NOT NULL,
  `total_belanja` float NOT NULL,
  `kembalian` float NOT NULL,
  `items` json NOT NULL,
  `nama_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_barang`
--

INSERT INTO `transaksi_barang` (`id`, `total_belanja`, `kembalian`, `items`, `nama_admin`, `createdAt`, `updatedAt`) VALUES
(1, 239000, 11000, '[{\"id\": 1, \"harga\": 15000, \"quantity\": 9, \"harga_modal\": 10000, \"nama_barang\": \"kran Taman Steinless\", \"total_harga\": 135000}, {\"id\": 2, \"harga\": 52000, \"quantity\": 2, \"harga_modal\": 42000, \"nama_barang\": \"Kran Angsa SOLEGON\", \"total_harga\": 104000}]', 'admin', '2024-02-27 20:08:52', '2024-02-27 20:08:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
