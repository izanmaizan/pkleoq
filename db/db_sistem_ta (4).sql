-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 05:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sistem_ta`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(10) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `keterangan`) VALUES
(1, 'Obat Tabur', 'Obat ini seperti bedak yang bisa ditabur'),
(8, 'Krim Oles', 'Untuk luka luar'),
(9, 'Obat Dalam', 'Untuk obat luka dalam');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `kode_obat` varchar(100) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `kategori_id` varchar(100) NOT NULL,
  `satuan_id` varchar(100) NOT NULL,
  `stock` bigint(100) NOT NULL,
  `harga` bigint(100) NOT NULL,
  `biaya_penyimpanan` bigint(20) DEFAULT NULL,
  `sup_id` varchar(100) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kode_obat`, `nama_obat`, `kategori_id`, `satuan_id`, `stock`, `harga`, `biaya_penyimpanan`, `sup_id`, `keterangan`) VALUES
(8, 'KD-OB142614', 'Primolut-N 5', '9', '4', 90, 8000, 5549, '18', ''),
(9, 'KD-OB082584', 'Vometa', '9', '4', 10, 5600, 3773, '18', ''),
(10, 'KD-OB350975', 'Dextaf', '9', '4', 40, 3000, 1441, '18', ''),
(11, 'KD-OB804171', 'Tera F', '9', '4', 20, 800, 407, '18', ''),
(12, 'KD-OB043964', 'Fremenza', '9', '4', 92, 2200, 1550, '18', ''),
(13, 'KD-OB183272', 'Semizolon', '9', '4', 73, 3000, 686, '18', ''),
(14, 'KD-OB760686', 'Curvit', '9', '4', 3, 2400, 1808, '18', ''),
(15, 'KD-OB373515', 'Omenacort', '9', '4', 105, 2000, 572, '18', ''),
(16, 'KD-OB434414', 'Paramex Flu dan Batuk', '9', '3', 65, 3000, 2128, '18', ''),
(17, 'KD-OB526655', 'Grantusif', '9', '5', 175, 7000, 3431, '18', '');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(10) NOT NULL,
  `nama_role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `nama_role`) VALUES
(1, 'Apoteker'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL,
  `nama_satuan` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `nama_satuan`, `keterangan`) VALUES
(2, 'Botol', ''),
(3, 'Pcs', ''),
(4, 'Tablet', ''),
(5, 'Strip', '');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(10) NOT NULL,
  `kode_sup` varchar(100) NOT NULL,
  `nama_sup` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `kode_sup`, `nama_sup`, `alamat`, `no_hp`) VALUES
(18, 'KD-SUP728659', 'PT. Riau Jaya Cemerlang', 'Jl. Sidodadi', '081277605797'),
(25, 'KD-SUP488517', 'CV. Khaleed Healty', 'Jl. Pesantren Kulim Pekanbaru', '081277605797');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pembelian`
--

CREATE TABLE `transaksi_pembelian` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `stock_in` int(11) NOT NULL,
  `sup_id` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `kode_transaksi` varchar(100) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_pembelian`
--

INSERT INTO `transaksi_pembelian` (`id`, `produk_id`, `user_id`, `satuan_id`, `harga`, `stock_in`, `sup_id`, `keterangan`, `kode_transaksi`, `total_harga`, `tanggal`) VALUES
(24, 11, 26, 4, 800, 5, 18, 'Bulan maret', 'KD-TRS-B48698726937', 4000, '2024-03-23'),
(25, 8, 26, 4, 8000, 10, 18, 'Bulan maret', 'KD-TRS-B48698726937', 80000, '2024-03-23'),
(26, 13, 26, 4, 3000, 5, 18, 'Bulan maret', 'KD-TRS-B48698726937', 15000, '2024-03-23'),
(27, 12, 25, 4, 2200, 34, 18, 'Tengah malam', 'KD-TRS-B89474343290', 74800, '2024-03-26'),
(35, 12, 24, 4, 2200, 2, 25, 'Rebuild', 'KD-TRS-B02979559566', 4400, '2024-06-04');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_penjualan`
--

CREATE TABLE `transaksi_penjualan` (
  `id` int(11) NOT NULL,
  `kd_transaksi` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `stock_out` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `sup_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_penjualan`
--

INSERT INTO `transaksi_penjualan` (`id`, `kd_transaksi`, `user_id`, `produk_id`, `stock_out`, `satuan_id`, `harga`, `total_harga`, `sup_id`, `tanggal`, `keterangan`) VALUES
(2, 'KD-TRS-J37667072968', 25, 14, 90, 4, 2400, 216000, 18, '2024-03-27', 'penjualan'),
(3, 'KD-TRS-J37667072968', 25, 16, 100, 3, 3000, 300000, 18, '2024-03-27', 'penjualan'),
(4, 'KD-TRS-J35238002628', 25, 15, 9, 4, 2000, 18000, 18, '2024-03-27', 'test'),
(5, 'KD-TRS-J37042837391', 25, 12, 1, 4, 2200, 2200, 18, '2024-03-25', 'sebelum'),
(6, 'KD-TRS-J46235330830', 24, 9, 2, 4, 5600, 11200, 18, '2024-04-22', 'bulan april'),
(7, 'KD-TRS-J46235330830', 24, 17, 4, 5, 7000, 28000, 18, '2024-04-22', 'bulan april'),
(8, 'KD-TRS-J89594932113', 24, 14, 5, 4, 2400, 12000, 18, '2024-04-22', 'April 2'),
(9, 'KD-TRS-J53441167674', 24, 12, 10, 4, 2200, 22000, 18, '2023-01-01', 'testing'),
(10, 'KD-TRS-J53441167674', 24, 9, 8, 4, 5600, 44800, 18, '2023-01-01', 'testing'),
(11, 'KD-TRS-J53441167674', 24, 8, 10, 4, 8000, 80000, 18, '2023-01-01', 'testing'),
(12, 'KD-TRS-J47068046479', 24, 10, 10, 4, 3000, 30000, 18, '2023-01-02', 'tahun 2023'),
(13, 'KD-TRS-J36301741741', 24, 13, 5, 4, 3000, 15000, 18, '2023-01-03', 'asd'),
(14, 'KD-TRS-J79195555399', 24, 14, 2, 4, 2400, 4800, 18, '2023-01-01', 'Bulan maret 2'),
(15, 'KD-TRS-J59683354801', 24, 11, 7, 4, 800, 5600, 18, '2023-01-01', 'sad'),
(16, 'KD-TRS-JL93807370946', 24, 8, 10, 4, 8000, 80000, 25, '2024-06-04', 'Khaleed');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `role_id`) VALUES
(24, 'Admin', 'admin', 'admin123', 2),
(25, 'Nina', 'apoteker', 'apoteker', 1),
(26, 'Aldeny', 'aldeny', 'aldeny', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_pembelian`
--
ALTER TABLE `transaksi_pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_penjualan`
--
ALTER TABLE `transaksi_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `transaksi_pembelian`
--
ALTER TABLE `transaksi_pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `transaksi_penjualan`
--
ALTER TABLE `transaksi_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
