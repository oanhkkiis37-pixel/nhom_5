-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2026 at 10:57 AM
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
-- Database: `nhom_5`
--

-- --------------------------------------------------------

--
-- Table structure for table `chamcong`
--

CREATE TABLE `chamcong` (
  `machamcong` int(11) NOT NULL,
  `manhanvien` int(11) DEFAULT NULL,
  `thang` int(11) NOT NULL,
  `nam` int(11) NOT NULL,
  `sogiolam` int(11) DEFAULT 0,
  `phucap` decimal(10,2) DEFAULT 0.00,
  `thuong` decimal(10,2) DEFAULT 0.00,
  `ngaycapnhat` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chamcong`
--

INSERT INTO `chamcong` (`machamcong`, `manhanvien`, `thang`, `nam`, `sogiolam`, `phucap`, `thuong`, `ngaycapnhat`) VALUES
(1, 1, 8, 2026, 160, 2000000.00, 5000000.00, '2026-09-30 02:24:43'),
(2, 2, 8, 2026, 160, 1000000.00, 2000000.00, '2026-09-30 02:24:43'),
(3, 3, 8, 2026, 168, 1500000.00, 3000000.00, '2026-09-30 02:24:43'),
(4, 4, 8, 2026, 160, 800000.00, 1500000.00, '2026-09-30 02:24:43'),
(5, 5, 8, 2026, 152, 1200000.00, 1800000.00, '2026-09-30 02:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `duan`
--

CREATE TABLE `duan` (
  `maduan` int(11) NOT NULL,
  `tenduan` varchar(150) NOT NULL,
  `mota` text DEFAULT NULL,
  `ngaybatdau` date DEFAULT NULL,
  `ngayketthuc` date DEFAULT NULL,
  `status` enum('Planning','In Progress','Completed','Cancelled') DEFAULT 'Planning',
  `tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `duan`
--

INSERT INTO `duan` (`maduan`, `tenduan`, `mota`, `ngaybatdau`, `ngayketthuc`, `status`, `tao`) VALUES
(1, 'Hệ thống quản lý nhân sự', 'Xây dựng web nội bộ quản lý nhân sự và chấm công', '2026-01-10', '2026-06-30', 'Completed', '2026-09-30 02:24:43'),
(2, 'Ứng dụng di động Sales', 'App đặt hàng và quản lý khách hàng trên mobile', '2026-03-01', '2026-09-30', 'In Progress', '2026-09-30 02:24:43'),
(3, 'Nâng cấp hạ tầng Cloud', 'Chuyển đổi server công ty sang AWS', '2026-05-01', '2026-07-15', 'Planning', '2026-09-30 02:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `manhanvien` int(11) NOT NULL,
  `hovaten` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sdt` varchar(20) DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `maphong` int(11) DEFAULT NULL,
  `chucvu` varchar(50) DEFAULT NULL,
  `luongcoban` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`manhanvien`, `hovaten`, `username`, `password`, `sdt`, `ngaysinh`, `maphong`, `chucvu`, `luongcoban`) VALUES
(1, 'Nguyễn Văn An', 'an.nguyen', '123456', '0901122334', '1985-05-12', 1, 'Giám đốc', 35000000.00),
(2, 'Trần Thị Bích', 'bich.tran', '123456', '0902233445', '1990-08-22', 3, 'Trưởng phòng HR', 18000000.00),
(3, 'Lê Hoàng Nam', 'nam.le', '123456', '0903344556', '1995-02-15', 2, 'Tech Lead', 25000000.00),
(4, 'Phạm Thị Thu', 'thu.pham', '123456', '0904455667', '1998-11-04', 2, 'Frontend Developer', 15000000.00),
(5, 'Hoàng Minh Tuấn', 'tuan.hoang', '123456', '0905566778', '1997-07-19', 4, 'Sales Executive', 12000000.00);

-- --------------------------------------------------------

--
-- Table structure for table `phancong`
--

CREATE TABLE `phancong` (
  `maphancong` int(11) NOT NULL,
  `manhanvien` int(11) DEFAULT NULL,
  `maduan` int(11) DEFAULT NULL,
  `vaitro` varchar(100) DEFAULT NULL,
  `ngaythamgia` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phancong`
--

INSERT INTO `phancong` (`maphancong`, `manhanvien`, `maduan`, `vaitro`, `ngaythamgia`) VALUES
(1, 3, 1, 'Project Manager', '2026-01-10'),
(2, 4, 1, 'Frontend Developer', '2026-01-15'),
(3, 3, 2, 'Technical Advisor', '2026-03-01'),
(4, 5, 2, 'Sales Lead', '2026-03-05');

-- --------------------------------------------------------

--
-- Table structure for table `phongban`
--

CREATE TABLE `phongban` (
  `maphong` int(11) NOT NULL,
  `tenphong` varchar(100) NOT NULL,
  `sonhanvien` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phongban`
--

INSERT INTO `phongban` (`maphong`, `tenphong`, `sonhanvien`) VALUES
(1, 'Phòng Giám Đốc', 2),
(2, 'Phòng Kỹ Thuật (IT)', 4),
(3, 'Phòng Nhân Sự (HR)', 2),
(4, 'Phòng Kinh Doanh (Sales)', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chamcong`
--
ALTER TABLE `chamcong`
  ADD PRIMARY KEY (`machamcong`),
  ADD KEY `manhanvien` (`manhanvien`);

--
-- Indexes for table `duan`
--
ALTER TABLE `duan`
  ADD PRIMARY KEY (`maduan`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`manhanvien`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `maphong` (`maphong`);

--
-- Indexes for table `phancong`
--
ALTER TABLE `phancong`
  ADD PRIMARY KEY (`maphancong`),
  ADD KEY `manhanvien` (`manhanvien`),
  ADD KEY `maduan` (`maduan`);

--
-- Indexes for table `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`maphong`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chamcong`
--
ALTER TABLE `chamcong`
  MODIFY `machamcong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `duan`
--
ALTER TABLE `duan`
  MODIFY `maduan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `manhanvien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phancong`
--
ALTER TABLE `phancong`
  MODIFY `maphancong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `phongban`
--
ALTER TABLE `phongban`
  MODIFY `maphong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chamcong`
--
ALTER TABLE `chamcong`
  ADD CONSTRAINT `chamcong_ibfk_1` FOREIGN KEY (`manhanvien`) REFERENCES `nhanvien` (`manhanvien`) ON DELETE CASCADE;

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`maphong`) REFERENCES `phongban` (`maphong`) ON DELETE SET NULL;

--
-- Constraints for table `phancong`
--
ALTER TABLE `phancong`
  ADD CONSTRAINT `phancong_ibfk_1` FOREIGN KEY (`manhanvien`) REFERENCES `nhanvien` (`manhanvien`) ON DELETE CASCADE,
  ADD CONSTRAINT `phancong_ibfk_2` FOREIGN KEY (`maduan`) REFERENCES `duan` (`maduan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
