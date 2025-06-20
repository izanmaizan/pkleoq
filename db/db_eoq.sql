-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2025 at 10:07 AM
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
-- Database: `db_eoq`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `keterangan`) VALUES
(14, 'Perawatan Rumah Tangga', 'Produk untuk kebersihan pakaian, lantai, dan peralatan rumah tangga seperti detergen, pewangi, dan pembersih serbaguna'),
(15, 'Makanan Instan', 'Produk makanan siap saji seperti mie instan dan bumbu pelengkap.'),
(16, 'Minuman Siap Minum', 'Produk minuman dalam kemasan seperti teh botol, jus, kopi instan, dan minuman elektrolit.\r\n\r\n'),
(17, 'Perawatan Tubuh', 'Produk untuk mandi dan perawatan pribadi seperti sabun, sampo, pasta gigi, dan hand sanitizer.'),
(18, 'Camilan & Es Krim', 'Produk makanan ringan dan es krim dari kolaborasi Wings Group dengan Glico dan Calbee.');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `kode_produk` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_produk` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kategori_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `satuan_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `stock` bigint NOT NULL,
  `harga` bigint NOT NULL,
  `biaya_penyimpanan` bigint DEFAULT NULL,
  `sup_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kode_produk`, `nama_produk`, `kategori_id`, `satuan_id`, `stock`, `harga`, `biaya_penyimpanan`, `sup_id`, `keterangan`) VALUES
(22, 'KD-PRD099006', 'Mie Sedaap Goreng Original', '15', '3', 1500, 2500, 150, '27', 'Mie instan goreng dengan rasa khas gurih dan nikmat.'),
(23, 'KD-PRD312855', 'So Klin Liquid Violet 1L', '14', '10', 300, 18000, 500, '28', 'Detergen cair dengan formula lembut untuk pakaian.'),
(24, 'KD-PRD875915', 'GIV Sabun Batang White Beauty', '17', '12', 500, 7000, 200, '29', 'Sabun mandi batang untuk mencerahkan kulit, isi 4 pcs.'),
(25, 'KD-PRD729032', 'Floridina Jeruk Pet 350ml', '16', '9', 200, 35000, 1000, '30', 'Minuman jeruk segar dalam kemasan botol PET, isi 24.'),
(26, 'KD-PRD408018', 'Potabee Balado 68gr', '18', '3', 1000, 4500, 250, '31', 'Keripik kentang rasa balado produksi Calbee Wings.'),
(27, 'KD-PRD875854', 'Ale-Ale Rasa Anggur 200ml', '16', '9', 250, 30000, 800, '27', 'Minuman rasa anggur dalam kemasan cup isi 24 pcs.'),
(28, 'KD-PRD593122', 'So Klin Pewangi Violet 900ml', '14', '10', 353, 14500, 400, '28', 'Pewangi pakaian cair dengan aroma violet segar.'),
(29, 'KD-PRD378151', 'Nuvo Antibacterial Body Wash 450ml', '17', '10', 200, 19000, 600, '29', 'Sabun mandi cair antibakteri untuk perlindungan maksimal.'),
(30, 'KD-PRD869969', 'Jasjus Rasa Jeruk', '16', 'null', 1000, 500, 50, '30', 'Minuman serbuk rasa jeruk yang praktis dan ekonomis.'),
(31, 'KD-PRD029304', 'Mie Sedaap Korean Spicy Chicken', 'null', '12', 605, 12000, 300, '31', 'Mie instan rasa pedas ala Korea, isi 5 bungkus.'),
(32, 'KD-PRD339019', 'Top Coffee Toraja', '16', '12', 400, 8000, 250, '27', 'Kopi instan bubuk rasa khas Toraja isi 10 sachet.'),
(33, 'KD-PRD200544', 'Daia Putih 1.8 Kg', '14', '11', 255, 25000, 700, '28', 'Detergen bubuk khusus untuk pakaian putih.'),
(34, 'KD-PRD921460', 'Zinc Shampoo Anti Dandruff 340ml', '17', '10', 300, 17500, 500, '29', 'Sampo anti ketombe untuk pria dan wanita.'),
(35, 'KD-PRD723443', 'Krisbee Cheese 65gr', '18', '3', 800, 4000, 200, '30', 'Snack jagung rasa keju produksi Calbee Wings.'),
(36, 'KD-PRD422058', 'Mie Sukses Isi 2 Rasa Soto', '15', '3', 705, 6000, 250, '31', 'Mie instan isi 2 bungkus rasa soto khas Indonesia.'),
(37, 'KD-PRD554904', 'Mie Sedaap Soto 75gr', '15', '3', 2, 2400, 100, '27', 'Mie instan kuah rasa soto dengan bumbu khas gurih.'),
(38, 'KD-PRD727298', 'So Klin Softener Floral 800ml', '14', '10', 20, 16000, 300, '28', 'Pelembut pakaian dengan aroma floral tahan lama.'),
(39, 'KD-PRD873352', 'Top Coffee Gula Aren', '16', '12', 10, 9000, 150, '29', 'Kopi instan manis dengan perpaduan rasa gula aren.'),
(40, 'KD-PRD820166', 'Zinc Cool Menthol 170ml', '17', '10', 8, 12500, 200, '30', 'Sampo anti ketombe dengan sensasi dingin menyegarkan.'),
(41, 'KD-PRD225330', 'Potabee Seaweed 68gr', '18', '3', 1, 4500, 250, '31', 'Keripik kentang rasa rumput laut dari Calbee Wings.'),
(42, 'KD-PRD671977', 'Daia Detergent Premium 2.5 Kg', '14', '11', 0, 45000, 1500, '28', 'Detergen premium untuk mencuci pakaian dalam jumlah besar, formulasi kuat.'),
(43, 'KD-PRD029738', 'Zinc Hairfall Treatment 500ml', '17', '10', 1, 38000, 1200, '29', 'Shampoo khusus perawatan rambut rontok dengan bahan aktif pilihan.'),
(44, 'KD-PRD738729', 'Top Coffee 3in1 White Coffee Isi 30 Sachet', '16', '12', 1, 52000, 1000, '27', 'Kopi instan dengan rasa white coffee, kemasan besar isi banyak.'),
(45, 'KD-PRD505005', 'Calbee Jagabee Seaweed Family Pack', '18', '9', 1, 60000, 1800, '30', 'Kentang stik rasa rumput laut, isi banyak dalam satu box ekonomis.'),
(46, 'KD-PRD903107', 'Floridina Orange Pulpy 500ml', '16', '10', 225, 6000, 200, '27', 'Minuman jeruk dengan bulir buah, menyegarkan dan kaya vitamin C.'),
(47, 'KD-PRD719329', 'Ciptadent Pasta Gigi Junior Strawberry 120gr', '17', '3', 50, 8500, 300, '30', 'Pasta gigi anak-anak dengan rasa stroberi, melindungi gigi susu.');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_eoq`
--

CREATE TABLE `riwayat_eoq` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tanggal_dari` date NOT NULL,
  `tanggal_sampai` date NOT NULL,
  `tanggal_perhitungan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_produk` int NOT NULL,
  `total_demand` int NOT NULL,
  `total_eoq` int NOT NULL,
  `avg_eoq` decimal(10,2) NOT NULL,
  `max_eoq` int NOT NULL,
  `min_eoq` int NOT NULL,
  `total_setup_cost` decimal(15,2) NOT NULL,
  `avg_setup_cost` decimal(10,2) NOT NULL,
  `total_cost_eoq` decimal(15,2) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` enum('completed','error') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_eoq`
--

INSERT INTO `riwayat_eoq` (`id`, `user_id`, `tanggal_dari`, `tanggal_sampai`, `tanggal_perhitungan`, `total_produk`, `total_demand`, `total_eoq`, `avg_eoq`, `max_eoq`, `min_eoq`, `total_setup_cost`, `avg_setup_cost`, `total_cost_eoq`, `keterangan`, `status`) VALUES
(16, 24, '2025-06-18', '2025-06-20', '2025-06-20 15:39:13', 10, 226, 105, 10.00, 27, 4, 33948.00, 3394.80, 58576.59, 'Perhitungan EOQ periode 18/06/2025 - 20/06/2025', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_eoq_detail`
--

CREATE TABLE `riwayat_eoq_detail` (
  `id` int NOT NULL,
  `riwayat_eoq_id` int NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `demand_tahunan` int NOT NULL,
  `harga_produk` decimal(15,2) NOT NULL,
  `biaya_pemesanan` decimal(15,2) NOT NULL,
  `biaya_penyimpanan` decimal(15,2) NOT NULL,
  `eoq_optimal` int NOT NULL,
  `frekuensi_pesan` int NOT NULL,
  `interval_hari` int NOT NULL,
  `total_cost_eoq` decimal(15,2) NOT NULL,
  `supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nilai_penjualan` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_eoq_detail`
--

INSERT INTO `riwayat_eoq_detail` (`id`, `riwayat_eoq_id`, `nama_produk`, `demand_tahunan`, `harga_produk`, `biaya_pemesanan`, `biaya_penyimpanan`, `eoq_optimal`, `frekuensi_pesan`, `interval_hari`, `total_cost_eoq`, `supplier`, `nilai_penjualan`) VALUES
(151, 16, 'Ciptadent Pasta Gigi Junior Strawberry 120gr', 110, 8500.00, 1020.00, 300.00, 27, 4, 91, 8204.00, '0', 935000.00),
(152, 16, 'Daia Detergent Premium 2.5 Kg', 8, 45000.00, 5400.00, 1500.00, 8, 1, 365, 11384.00, '0', 360000.00),
(153, 16, 'Calbee Jagabee Seaweed Family Pack', 5, 60000.00, 7200.00, 1800.00, 6, 1, 365, 11384.00, '0', 300000.00),
(154, 16, 'Top Coffee 3in1 White Coffee Isi 30 Sachet', 4, 52000.00, 6240.00, 1000.00, 7, 1, 365, 7065.00, '0', 208000.00),
(155, 16, 'Floridina Orange Pulpy 500ml', 30, 6000.00, 720.00, 200.00, 15, 2, 183, 2939.00, '0', 180000.00),
(156, 16, 'Top Coffee 3in1 White Coffee Isi 30 Sachet', 3, 52000.00, 6240.00, 1000.00, 6, 1, 365, 6118.00, '0', 156000.00),
(157, 16, 'Potabee Seaweed 68gr', 31, 4500.00, 540.00, 250.00, 12, 3, 122, 2893.00, '0', 139500.00),
(158, 16, 'Zinc Hairfall Treatment 500ml', 2, 38000.00, 4560.00, 1200.00, 4, 1, 365, 4678.00, '0', 76000.00),
(159, 16, 'So Klin Pewangi Violet 900ml', 5, 14500.00, 1740.00, 400.00, 7, 1, 365, 2638.00, '0', 72500.00),
(160, 16, 'Mie Sedaap Soto 75gr', 28, 2400.00, 288.00, 100.00, 13, 2, 183, 1269.00, '0', 67200.00);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `nama_role` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `nama_role`) VALUES
(1, 'Karyawan'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` int NOT NULL,
  `nama_satuan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `nama_satuan`, `keterangan`) VALUES
(3, 'Pcs', 'Digunakan untuk satuan unit eceran seperti sabun batang, sachet mie, atau minuman botol.\r\n\r\n'),
(9, 'Box', 'Satuan dalam bentuk dus besar berisi banyak pcs, biasanya untuk keperluan distribusi.'),
(10, 'Liter', 'Untuk produk berbentuk cair seperti sabun cuci piring, softener, atau minuman botol besar.'),
(11, 'Kg', 'Digunakan untuk detergen atau produk dalam kemasan berat seperti tepung dan bahan baku lainnya.\r\n\r\n'),
(12, 'Pack', 'Untuk produk kemasan isi banyak, seperti pasta gigi isi 3, sabun isi 4, dll.\r\n\r\n'),
(13, 'Renteng', 'Untuk satuan yang 12 pcs.');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `kode_sup` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_sup` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `no_hp` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `kode_sup`, `nama_sup`, `alamat`, `no_hp`) VALUES
(27, 'KD-SUP113839', 'PT Alamjaya Wirasentosa Muara Bungo', 'Jl. Lintas Sumatera KM 10, Muara Bungo, Jambi', '081568932546'),
(28, 'KD-SUP326025', 'CV Mitra Alamjaya Muara Bungo', 'Komp. Ruko Bungo Permai Blok A3, Muara Bungo, Jambi', '085265432198'),
(29, 'KD-SUP044783', 'UD Sukses Alamjaya Bungo', 'Jl. Jend. Sudirman No. 45, Pasar Muara Bungo, Jambi', '082176543210'),
(30, 'KD-SUP051259', 'Toko Alamjaya Sejati', 'Jl. Pahlawan, Depan Terminal Bungo, Muara Bungo, Jambi', '087812345678'),
(31, 'KD-SUP495087', 'CV Bungo Alamjaya Mandiri', 'Jl. H. Agus Salim No. 77, Rimbo Tengah, Muara Bungo, Jambi', '089912345677');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_pembelian`
--

CREATE TABLE `transaksi_pembelian` (
  `id` int NOT NULL,
  `produk_id` int NOT NULL,
  `user_id` int NOT NULL,
  `satuan_id` int NOT NULL,
  `harga` int NOT NULL,
  `stock_in` int NOT NULL,
  `sup_id` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `kode_transaksi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `total_harga` int NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_pembelian`
--

INSERT INTO `transaksi_pembelian` (`id`, `produk_id`, `user_id`, `satuan_id`, `harga`, `stock_in`, `sup_id`, `keterangan`, `kode_transaksi`, `total_harga`, `tanggal`) VALUES
(36, 31, 24, 12, 12000, 5, 28, '', 'KD-TRS-B90165927972', 60000, '2025-06-18'),
(37, 41, 24, 3, 4500, 20, 27, '', 'KD-TRS-B77140395082', 90000, '2025-06-18'),
(38, 38, 24, 10, 16000, 5, 27, '', 'KD-TRS-B77140395082', 80000, '2025-06-18'),
(39, 37, 24, 3, 2400, 10, 27, '', 'KD-TRS-B77140395082', 24000, '2025-06-18'),
(40, 28, 24, 10, 14500, 8, 27, '', 'KD-TRS-B77140395082', 116000, '2025-06-18'),
(41, 46, 24, 10, 6000, 5, 31, '', 'KD-TRS-B04867709251', 30000, '2025-06-18'),
(42, 42, 24, 11, 45000, 3, 31, '', 'KD-TRS-B04867709251', 135000, '2025-06-18'),
(43, 44, 24, 12, 52000, 4, 31, '', 'KD-TRS-B04867709251', 208000, '2025-06-18'),
(44, 33, 24, 11, 25000, 5, 29, '', 'KD-TRS-B16844728984', 125000, '2025-06-18'),
(45, 36, 24, 3, 6000, 5, 29, '', 'KD-TRS-B16844728984', 30000, '2025-06-18');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_penjualan`
--

CREATE TABLE `transaksi_penjualan` (
  `id` int NOT NULL,
  `kd_transaksi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `produk_id` int NOT NULL,
  `stock_out` int NOT NULL,
  `satuan_id` int NOT NULL,
  `harga` int NOT NULL,
  `total_harga` int NOT NULL,
  `sup_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_penjualan`
--

INSERT INTO `transaksi_penjualan` (`id`, `kd_transaksi`, `user_id`, `produk_id`, `stock_out`, `satuan_id`, `harga`, `total_harga`, `sup_id`, `tanggal`, `keterangan`) VALUES
(17, 'KD-TRS-J19899494518', 24, 28, 5, 10, 14500, 72500, 29, '2025-06-18', ''),
(18, 'KD-TRS-J50565197863', 24, 47, 110, 3, 8500, 935000, 28, '2025-06-18', ''),
(19, 'KD-TRS-J50565197863', 24, 46, 30, 10, 6000, 180000, 28, '2025-06-18', ''),
(20, 'KD-TRS-J50565197863', 24, 45, 5, 9, 60000, 300000, 28, '2025-06-18', ''),
(21, 'KD-TRS-J50565197863', 24, 44, 4, 12, 52000, 208000, 28, '2025-06-18', ''),
(22, 'KD-TRS-J50565197863', 24, 42, 8, 11, 45000, 360000, 28, '2025-06-18', ''),
(23, 'KD-TRS-J50565197863', 24, 41, 31, 3, 4500, 139500, 28, '2025-06-18', ''),
(24, 'KD-TRS-J50565197863', 24, 43, 2, 10, 38000, 76000, 28, '2025-06-18', ''),
(25, 'KD-TRS-J04145389353', 24, 44, 3, 12, 52000, 156000, 27, '2025-06-18', ''),
(26, 'KD-TRS-J04145389353', 24, 37, 28, 3, 2400, 67200, 27, '2025-06-18', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `role_id`) VALUES
(24, 'Admin', 'admin', 'admin123', 2),
(25, 'Nina', 'karyawan', 'karyawan', 1),
(26, 'Aldeny', 'rizki', 'rizki123', 1);

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
-- Indexes for table `riwayat_eoq`
--
ALTER TABLE `riwayat_eoq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tanggal_perhitungan` (`tanggal_perhitungan`),
  ADD KEY `tanggal_periode` (`tanggal_dari`,`tanggal_sampai`),
  ADD KEY `idx_riwayat_user_tanggal` (`user_id`,`tanggal_perhitungan` DESC);

--
-- Indexes for table `riwayat_eoq_detail`
--
ALTER TABLE `riwayat_eoq_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_eoq_id` (`riwayat_eoq_id`),
  ADD KEY `nama_produk` (`nama_produk`),
  ADD KEY `idx_detail_eoq_produk` (`riwayat_eoq_id`,`eoq_optimal` DESC);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_ibfk_1` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `riwayat_eoq`
--
ALTER TABLE `riwayat_eoq`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `riwayat_eoq_detail`
--
ALTER TABLE `riwayat_eoq_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `transaksi_pembelian`
--
ALTER TABLE `transaksi_pembelian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `transaksi_penjualan`
--
ALTER TABLE `transaksi_penjualan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `riwayat_eoq`
--
ALTER TABLE `riwayat_eoq`
  ADD CONSTRAINT `riwayat_eoq_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_eoq_detail`
--
ALTER TABLE `riwayat_eoq_detail`
  ADD CONSTRAINT `riwayat_eoq_detail_ibfk_1` FOREIGN KEY (`riwayat_eoq_id`) REFERENCES `riwayat_eoq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
