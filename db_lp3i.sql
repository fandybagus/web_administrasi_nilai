-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2024 at 05:51 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lp3i`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_nilai`
--

CREATE TABLE `data_nilai` (
  `idnilai` int(11) NOT NULL,
  `nip_dosen` varchar(15) NOT NULL,
  `nim_mhs` varchar(15) NOT NULL,
  `idmatkul` int(10) NOT NULL,
  `nilai_formatif` int(3) NOT NULL,
  `nilai_perilaku` int(3) NOT NULL,
  `nilai_tugas` int(3) NOT NULL,
  `nilai_uts` int(3) NOT NULL,
  `nilai_uas` int(3) NOT NULL,
  `poin_formatif` int(3) NOT NULL,
  `poin_perilaku` int(3) NOT NULL,
  `poin_tugas` int(3) NOT NULL,
  `poin_uts` int(3) NOT NULL,
  `poin_uas` int(3) NOT NULL,
  `total_poin` int(3) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `is_approved` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_nilai`
--

INSERT INTO `data_nilai` (`idnilai`, `nip_dosen`, `nim_mhs`, `idmatkul`, `nilai_formatif`, `nilai_perilaku`, `nilai_tugas`, `nilai_uts`, `nilai_uas`, `poin_formatif`, `poin_perilaku`, `poin_tugas`, `poin_uts`, `poin_uas`, `total_poin`, `created_date`, `created_by`, `is_approved`) VALUES
(29, 'NIP2024002', 'NIM20240002', 1, 100, 100, 100, 90, 90, 10, 10, 20, 18, 36, 94, '2024-07-18', 'alie ismail', 0),
(30, 'NIP2024003', 'NIM20240005', 2, 100, 100, 100, 80, 85, 10, 10, 20, 16, 34, 90, '2024-07-18', 'alie ismail', 0),
(31, 'NIP2024004', 'NIM20240006', 5, 90, 90, 100, 80, 87, 9, 9, 20, 16, 35, 89, '2024-07-18', 'alie ismail', 0),
(32, 'NIP2024005', 'NIM20240001', 6, 100, 100, 90, 80, 90, 10, 10, 18, 16, 36, 90, '2024-07-18', 'alie ismail', 0),
(44, 'NIP2024003', 'NIM20240003', 2, 100, 100, 85, 85, 87, 10, 10, 17, 17, 35, 89, '2024-07-18', 'alie ismail', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mst_dosen`
--

CREATE TABLE `mst_dosen` (
  `nip_dosen` varchar(10) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `email_dosen` varchar(20) NOT NULL,
  `telp_dosen` varchar(15) NOT NULL,
  `alamat_dos` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mst_dosen`
--

INSERT INTO `mst_dosen` (`nip_dosen`, `nama_dosen`, `email_dosen`, `telp_dosen`, `alamat_dos`, `password`, `is_active`) VALUES
('NIP2024002', 'alie ismail', 'alie1@gmail.com', '082131930787', 'jl.kupang indah\r\n', '$2y$10$K.MnxN.EC6VQW12ApS0jIeFFNsUtmnx47EeJbh/RQrYg9AAx41mvi', 1),
('NIP2024003', 'zukruf saputra', 'zukruf@gmail.com', '082131967879', 'jl.kebayoran lama no', '$2y$10$RNAYVnUt9I2lLyRyVPeg/.k01MkU3s8TrGZHEnUkPEGl095cLIxu.', 1),
('NIP2024004', 'bunga handayani putri', 'bunga@gmail.com', '083856322541', 'griya pesawahan no.6', '$2y$10$fWOZyCxbHptpxmJmryCEl.2S994T6mEaJtlCOTRxK9QGClAOa1lru', 1),
('NIP2024005', 'dani putra arjuna', 'dani@gmail.com', '085767588876', 'pengangsaan selatan ', '$2y$10$va252x4njMdRRl0ekY7MW.AZVUGY1.7r6QwDXVxYbCxGq9i48pN02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_jurusan`
--

CREATE TABLE `mst_jurusan` (
  `idjurusan` varchar(12) NOT NULL,
  `nm_jurusan` varchar(50) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mst_jurusan`
--

INSERT INTO `mst_jurusan` (`idjurusan`, `nm_jurusan`, `is_active`) VALUES
('01', 'Organize Administration Automatization', 1),
('02', 'Accounting information system', 1),
('03', 'Digital Bussines management', 1),
('04', 'Visual Communication Design Management', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_mahasiswa`
--

CREATE TABLE `mst_mahasiswa` (
  `nim` varchar(15) NOT NULL,
  `nama_mhs` varchar(50) NOT NULL,
  `email_mhs` varchar(20) NOT NULL,
  `telp_mhs` varchar(15) NOT NULL,
  `alamat_mhs` text NOT NULL,
  `idjurusan` varchar(12) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mst_mahasiswa`
--

INSERT INTO `mst_mahasiswa` (`nim`, `nama_mhs`, `email_mhs`, `telp_mhs`, `alamat_mhs`, `idjurusan`, `password`, `foto`, `is_active`) VALUES
('NIM20240001', 'aurelia putri azzahra', 'lia@gamil.com', '082131456547', 'jl.binangun no 87', '01', '$2y$10$wkyKuNK8LlHinSI2hvJhxO2wjK.MAPMqdbZS159XLDsDbrIzayFES', '', 1),
('NIM20240002', 'putra sejati az zakaria', 'putra@gmail.com', '089876778765', 'jl.timur rayakan 98', '01', '123', '../../assets/img_mhs20221229_214045.jpg', 1),
('NIM20240003', 'nanda surya bakti', 'putra@gmail.com', '083831244332', 'jl.surabaya lama no 56', '02', '$2y$10$eB7bjeNJ0do/DHyVhYl/8.2UmjT8CTYw59uEutjy7/j6yuifHMF1K', '../../assets/img_mhs20221229_214045.jpg', 1),
('NIM20240004', 'bima putra arya', 'bima@gmail.com', '085732007566', 'jl.kupang indah wetan', '03', '$2y$10$Wyeyp5gsGN7CMyIZU.yHCemsErx0aeL5..2.UEfHyOBi4oBpZMeXe', '../../assets/img_mhs20221229_214034.jpg', 1),
('NIM20240005', 'ringga samudra ', 'ringga@gmail.com', '085674324356', 'griya indah permai utara ', '02', '$2y$10$wX0dAq1IwWsLi/p/skWT7ejseIj5Z/vLa0pj/oUxNEfwQ43MnHoUy', '../../assets/img_mhs/user.jpg', 1),
('NIM20240006', 'raden bagus cahaya sentosa', 'raden@gmail.com', '082131930787', 'griya indah jaya tegalsari blok f-5', '04', '$2y$10$hWayZn0KY6qOLbhoH7l9H.yJab9R01la1/l01tCaX..knGCA0W92G', '../../assets/img_mhs/20221229_214045.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_matakuliah`
--

CREATE TABLE `mst_matakuliah` (
  `idmatkul` int(10) NOT NULL,
  `matakuliah` varchar(50) NOT NULL,
  `idjurusan` varchar(20) NOT NULL,
  `tahunkuliah` year(4) NOT NULL,
  `kode_dosen` varchar(20) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mst_matakuliah`
--

INSERT INTO `mst_matakuliah` (`idmatkul`, `matakuliah`, `idjurusan`, `tahunkuliah`, `kode_dosen`, `is_active`) VALUES
(1, 'computer for office 1', '01', 2024, 'NIP2024002', 1),
(2, 'bussiness corespondence', '02', 2024, 'NIP2024003', 1),
(5, 'design graphic 1', '04', 2024, 'NIP2024004', 1),
(6, 'Human Resource Management', '01', 2024, 'NIP2024005', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_menus`
--

CREATE TABLE `mst_menus` (
  `menuid` int(11) NOT NULL,
  `menu_name` varchar(30) NOT NULL,
  `menu_link` varchar(30) NOT NULL,
  `isactive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `mst_menus`
--

INSERT INTO `mst_menus` (`menuid`, `menu_name`, `menu_link`, `isactive`) VALUES
(1, 'Data Dosen', '?modul=DataDosen', 1),
(2, 'Data Mahasiswa', '?modul=DataMahasiswa', 1),
(3, 'Data Matakuliah', '?modul=DataMatakuliah', 1),
(4, 'Data Nilai', '?modul=DataNilai', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mst_pegawai`
--

CREATE TABLE `mst_pegawai` (
  `idpegawai` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mst_pegawai`
--

INSERT INTO `mst_pegawai` (`idpegawai`, `nama`, `email`, `password`, `is_active`) VALUES
('001', 'alie ismail', 'alie@gmail.com', '$2y$10$1YLzBOBMGU4UnFc3aowXvOo4bNd51ElrQoHhK/ZDtfmB7on8/iSf2', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_nilai`
--
ALTER TABLE `data_nilai`
  ADD PRIMARY KEY (`idnilai`),
  ADD KEY `fk_mhs` (`nim_mhs`),
  ADD KEY `fk_matkul` (`idmatkul`),
  ADD KEY `nip_dosen` (`nip_dosen`) USING BTREE;

--
-- Indexes for table `mst_dosen`
--
ALTER TABLE `mst_dosen`
  ADD PRIMARY KEY (`nip_dosen`);

--
-- Indexes for table `mst_jurusan`
--
ALTER TABLE `mst_jurusan`
  ADD PRIMARY KEY (`idjurusan`);

--
-- Indexes for table `mst_mahasiswa`
--
ALTER TABLE `mst_mahasiswa`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `idjurusan` (`idjurusan`);

--
-- Indexes for table `mst_matakuliah`
--
ALTER TABLE `mst_matakuliah`
  ADD PRIMARY KEY (`idmatkul`),
  ADD KEY `idjurusan` (`idjurusan`),
  ADD KEY `kode_dosen` (`kode_dosen`);

--
-- Indexes for table `mst_menus`
--
ALTER TABLE `mst_menus`
  ADD PRIMARY KEY (`menuid`) USING BTREE;

--
-- Indexes for table `mst_pegawai`
--
ALTER TABLE `mst_pegawai`
  ADD PRIMARY KEY (`idpegawai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_nilai`
--
ALTER TABLE `data_nilai`
  MODIFY `idnilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `mst_matakuliah`
--
ALTER TABLE `mst_matakuliah`
  MODIFY `idmatkul` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mst_menus`
--
ALTER TABLE `mst_menus`
  MODIFY `menuid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_nilai`
--
ALTER TABLE `data_nilai`
  ADD CONSTRAINT `fk_dos` FOREIGN KEY (`nip_dosen`) REFERENCES `mst_dosen` (`nip_dosen`),
  ADD CONSTRAINT `fk_matkul` FOREIGN KEY (`idmatkul`) REFERENCES `mst_matakuliah` (`idmatkul`),
  ADD CONSTRAINT `fk_mhs` FOREIGN KEY (`nim_mhs`) REFERENCES `mst_mahasiswa` (`nim`);

--
-- Constraints for table `mst_mahasiswa`
--
ALTER TABLE `mst_mahasiswa`
  ADD CONSTRAINT `fk_idjurusan` FOREIGN KEY (`idjurusan`) REFERENCES `mst_jurusan` (`idjurusan`);

--
-- Constraints for table `mst_matakuliah`
--
ALTER TABLE `mst_matakuliah`
  ADD CONSTRAINT `fk_dosen` FOREIGN KEY (`kode_dosen`) REFERENCES `mst_dosen` (`nip_dosen`),
  ADD CONSTRAINT `fk_jurusan` FOREIGN KEY (`idjurusan`) REFERENCES `mst_jurusan` (`idjurusan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
