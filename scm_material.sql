-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 08:59 AM
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
-- Database: `scm_material`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_admin`
--

CREATE TABLE `data_admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `username_admin` varchar(20) NOT NULL,
  `password_admin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_admin`
--

INSERT INTO `data_admin` (`id_admin`, `nama_admin`, `username_admin`, `password_admin`) VALUES
(3, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `data_distributor`
--

CREATE TABLE `data_distributor` (
  `id_distributor` int(11) NOT NULL,
  `nama_distributor` varchar(255) NOT NULL,
  `alamat_distributor` text NOT NULL,
  `telepon_distributor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_keranjang`
--

CREATE TABLE `data_keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `jumlah_keranjang` int(10) NOT NULL,
  `harga_keranjang` varchar(255) NOT NULL,
  `total_keranjang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_material`
--

CREATE TABLE `data_material` (
  `id_material` int(11) NOT NULL,
  `nama_material` varchar(50) NOT NULL,
  `deskripsi_material` varchar(255) NOT NULL,
  `harga_material` int(20) NOT NULL,
  `stok_material` int(20) NOT NULL,
  `gambar_material` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_order`
--

CREATE TABLE `data_order` (
  `id_order` int(11) NOT NULL,
  `nama_order` varchar(255) NOT NULL,
  `email_order` varchar(50) NOT NULL,
  `alamat_order` varchar(255) NOT NULL,
  `telepon_order` varchar(255) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_distributor` int(11) DEFAULT NULL,
  `total_order` varchar(255) NOT NULL,
  `status_order` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_order_item`
--

CREATE TABLE `data_order_item` (
  `id_order_item` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `jumlah_order_item` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_pelanggan`
--

CREATE TABLE `data_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `username_pelanggan` varchar(50) NOT NULL,
  `password_pelanggan` varchar(50) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `alamat_pelanggan` varchar(255) NOT NULL,
  `email_pelanggan` varchar(50) NOT NULL,
  `telepon_pelanggan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_pemasok`
--

CREATE TABLE `data_pemasok` (
  `id_pemasok` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL DEFAULT 1,
  `nama_pemasok` varchar(50) NOT NULL,
  `alamat_pemasok` varchar(255) NOT NULL,
  `telepon_pemasok` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_pembayaran`
--

CREATE TABLE `data_pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `total_pembayaran` varchar(255) NOT NULL,
  `foto_pembayaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_pembelian`
--

CREATE TABLE `data_pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_pemasok` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL DEFAULT 1,
  `harga_pembelian` int(20) NOT NULL,
  `jumlah_pembelian` int(20) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_penjualan`
--

CREATE TABLE `data_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `jumlah_penjualan` int(20) NOT NULL,
  `harga_penjualan` int(20) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `harga_total_penjualan` int(50) NOT NULL,
  `status_penjualan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_return`
--

CREATE TABLE `detail_return` (
  `id_detail_return` int(11) NOT NULL,
  `id_return` int(11) DEFAULT NULL,
  `id_detail_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_produk`
--

CREATE TABLE `return_produk` (
  `id_return` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  `alasan_return` varchar(100) DEFAULT NULL,
  `keterangan_return` text DEFAULT NULL,
  `bukti_return` varchar(255) DEFAULT NULL,
  `status_return` enum('Menunggu Konfirmasi','Disetujui','Ditolak') DEFAULT 'Menunggu Konfirmasi',
  `tanggal_return` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_admin`
--
ALTER TABLE `data_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `data_distributor`
--
ALTER TABLE `data_distributor`
  ADD PRIMARY KEY (`id_distributor`);

--
-- Indexes for table `data_keranjang`
--
ALTER TABLE `data_keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_obat` (`id_material`,`id_pelanggan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_material` (`id_material`);

--
-- Indexes for table `data_material`
--
ALTER TABLE `data_material`
  ADD PRIMARY KEY (`id_material`);

--
-- Indexes for table `data_order`
--
ALTER TABLE `data_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_distributor` (`id_distributor`);

--
-- Indexes for table `data_order_item`
--
ALTER TABLE `data_order_item`
  ADD PRIMARY KEY (`id_order_item`),
  ADD KEY `id_pelanggan` (`id_pelanggan`,`id_material`,`id_order`),
  ADD KEY `id_obat` (`id_material`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_material` (`id_material`);

--
-- Indexes for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `data_pemasok`
--
ALTER TABLE `data_pemasok`
  ADD PRIMARY KEY (`id_pemasok`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `data_pembayaran`
--
ALTER TABLE `data_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_penjualan` (`id_order`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `data_pembelian`
--
ALTER TABLE `data_pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_pemasok` (`id_pemasok`,`id_material`),
  ADD KEY `id_obat` (`id_material`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_material` (`id_material`);

--
-- Indexes for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_obat` (`id_material`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_material` (`id_material`);

--
-- Indexes for table `detail_return`
--
ALTER TABLE `detail_return`
  ADD PRIMARY KEY (`id_detail_return`),
  ADD KEY `detail_return_ibfk_1` (`id_return`),
  ADD KEY `detail_return_ibfk_2` (`id_detail_order`);

--
-- Indexes for table `return_produk`
--
ALTER TABLE `return_produk`
  ADD PRIMARY KEY (`id_return`),
  ADD KEY `return_produk_ibfk_1` (`id_order`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_admin`
--
ALTER TABLE `data_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_distributor`
--
ALTER TABLE `data_distributor`
  MODIFY `id_distributor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_keranjang`
--
ALTER TABLE `data_keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `data_material`
--
ALTER TABLE `data_material`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `data_order`
--
ALTER TABLE `data_order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `data_order_item`
--
ALTER TABLE `data_order_item`
  MODIFY `id_order_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_pemasok`
--
ALTER TABLE `data_pemasok`
  MODIFY `id_pemasok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `data_pembayaran`
--
ALTER TABLE `data_pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `data_pembelian`
--
ALTER TABLE `data_pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `detail_return`
--
ALTER TABLE `detail_return`
  MODIFY `id_detail_return` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `return_produk`
--
ALTER TABLE `return_produk`
  MODIFY `id_return` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_keranjang`
--
ALTER TABLE `data_keranjang`
  ADD CONSTRAINT `data_keranjang_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_keranjang_ibfk_2` FOREIGN KEY (`id_material`) REFERENCES `data_material` (`id_material`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_order`
--
ALTER TABLE `data_order`
  ADD CONSTRAINT `data_order_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_order_ibfk_2` FOREIGN KEY (`id_distributor`) REFERENCES `data_distributor` (`id_distributor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_order_item`
--
ALTER TABLE `data_order_item`
  ADD CONSTRAINT `data_order_item_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_order_item_ibfk_2` FOREIGN KEY (`id_material`) REFERENCES `data_material` (`id_material`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_order_item_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `data_order` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_pemasok`
--
ALTER TABLE `data_pemasok`
  ADD CONSTRAINT `data_pemasok_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `data_admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_pembayaran`
--
ALTER TABLE `data_pembayaran`
  ADD CONSTRAINT `data_pembayaran_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `data_order` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_pembelian`
--
ALTER TABLE `data_pembelian`
  ADD CONSTRAINT `data_pembelian_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `data_material` (`id_material`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_pembelian_ibfk_2` FOREIGN KEY (`id_pemasok`) REFERENCES `data_pemasok` (`id_pemasok`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_pembelian_ibfk_3` FOREIGN KEY (`id_admin`) REFERENCES `data_admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_penjualan`
--
ALTER TABLE `data_penjualan`
  ADD CONSTRAINT `data_penjualan_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `data_material` (`id_material`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_penjualan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_return`
--
ALTER TABLE `detail_return`
  ADD CONSTRAINT `detail_return_ibfk_1` FOREIGN KEY (`id_return`) REFERENCES `return_produk` (`id_return`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_return_ibfk_2` FOREIGN KEY (`id_detail_order`) REFERENCES `data_order_item` (`id_order_item`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `return_produk`
--
ALTER TABLE `return_produk`
  ADD CONSTRAINT `return_produk_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `data_order` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
