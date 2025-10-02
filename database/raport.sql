-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 09:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `raport`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_guru`
--

CREATE TABLE `tb_guru` (
  `nip` varchar(20) NOT NULL,
  `nama_guru` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `no_tlp` varchar(13) NOT NULL,
  `alamat` text NOT NULL,
  `jk` text NOT NULL,
  `status_guru` text NOT NULL,
  `tempat_lahir` text NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` text NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_guru`
--

INSERT INTO `tb_guru` (`nip`, `nama_guru`, `username`, `password`, `no_tlp`, `alamat`, `jk`, `status_guru`, `tempat_lahir`, `tanggal_lahir`, `agama`, `foto`) VALUES
('19203564', 'Busra. N', 'busra', 'busra', '081363385162', 'Padang Utara', 'Laki-laki', 'Honor', 'Sonsang', '1983-03-28', 'ISLAM', '686e105793970.jpg'),
('23203664', 'Ronal Agusta', 'ronal', 'ronal', '082254637890', 'Padang Utara', 'Laki-laki', 'Honor', 'Cupak', '1988-08-04', 'ISLAM', '686e196504bd5.jpg'),
('27534112', 'Wiwit Mania', 'wiwit', 'wiwit', '081256787699', 'Jl. Pinus II', 'Perempuan', 'Honor', 'Padang', '1995-06-13', 'ISLAM', '6870c14ca4ac0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_japel`
--

CREATE TABLE `tb_japel` (
  `id_japel` varchar(5) NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  `id_thn_ajar` varchar(5) NOT NULL,
  `file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_japel`
--

INSERT INTO `tb_japel` (`id_japel`, `id_kelas`, `id_thn_ajar`, `file`) VALUES
('JD001', 'KL002', 'TH001', '5cbf1fcde3993.pdf'),
('JD002', 'KL003', 'TH003', '5cee98b580b7e.doc'),
('JD003', 'KL004', 'TH004', '5e7f22b36bd6e.pdf'),
('JD004', 'KL001', 'TH004', '686e1b988cf6d.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` varchar(5) NOT NULL,
  `nama_kelas` text NOT NULL,
  `kapasitas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `nama_kelas`, `kapasitas`) VALUES
('KL001', 'Kelas I', '30'),
('KL002', 'Kelas II', '30'),
('KL003', 'Kelas III', '30'),
('KL004', 'Kelas IV', '30');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelsis`
--

CREATE TABLE `tb_kelsis` (
  `id_kelsis` varchar(5) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_siswa` text NOT NULL,
  `id_kelas` varchar(5) NOT NULL,
  `id_thn_ajar` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_kelsis`
--

INSERT INTO `tb_kelsis` (`id_kelsis`, `nis`, `nama_siswa`, `id_kelas`, `id_thn_ajar`) VALUES
('KS034', '1232452998', 'Rabbal Farza A.', 'KL003', 'TH005'),
('KS035', '1232452999', 'Salma Fauzia A.', 'KL003', 'TH005'),
('KS036', '1232453011', 'Alifa Kumaira P.', 'KL003', 'TH005'),
('KS037', '1232453012', 'Anindita Khairunniswa', 'KL003', 'TH005'),
('KS038', '1232453013', 'Ajhay Rohsan', 'KL003', 'TH005'),
('KS039', '1232453014', 'Rani', 'KL003', 'TH005'),
('KS040', '1232453015', 'Raffa', 'KL003', 'TH005'),
('KS041', '1232453016', 'Rifqi Rahman', 'KL003', 'TH005'),
('KS042', '1232453017', 'Ghazi', 'KL003', 'TH005'),
('KS043', '1232453018', 'M. Aidil', 'KL003', 'TH005'),
('KS044', '1232453019', 'Khairunnisa Hayfa N.', 'KL003', 'TH005');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mapel`
--

CREATE TABLE `tb_mapel` (
  `id_mapel` varchar(5) NOT NULL,
  `nama_mapel` text NOT NULL,
  `nip` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_mapel`
--

INSERT INTO `tb_mapel` (`id_mapel`, `nama_mapel`, `nip`) VALUES
('MP015', 'Tilawah', '19203564 '),
('MP016', 'Khat/Menulis', '19203564 '),
('MP017', 'Ilmu Tajwid', '19203564 '),
('MP018', 'Tahfidz/Hafalan', '19203564 '),
('MP019', 'Nagham/Irama', '19203564 '),
('MP020', 'Aqidah/Akhlak', '19203564 '),
('MP021', 'Fiqih', '19203564 '),
('MP022', 'Tarikh', '19203564 '),
('MP023', 'Hafalan Doa', '19203564 '),
('MP024', 'Praktek Ibadah', '19203564 '),
('MP025', 'Didikan Subuh', '19203564 ');

-- --------------------------------------------------------

--
-- Table structure for table `tb_materi`
--

CREATE TABLE `tb_materi` (
  `id_materi` varchar(5) NOT NULL,
  `id_mapel` varchar(5) NOT NULL,
  `file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_materi`
--

INSERT INTO `tb_materi` (`id_materi`, `id_mapel`, `file`) VALUES
('MT002', 'MP014', '5e7f24353189a.pdf'),
('MT003', 'MP015', '686e1ed09f73c.pdf'),
('MT004', 'MP016', '686e1f2f00fd8.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `id_nilai` varchar(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `id_kelas` varchar(6) NOT NULL,
  `tahun_ajaran` text NOT NULL,
  `mapel` text NOT NULL,
  `nilai` int(3) NOT NULL,
  `tulisan_nilai` varchar(35) NOT NULL,
  `rata` int(20) NOT NULL,
  `semester` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_nilai`
--

INSERT INTO `tb_nilai` (`id_nilai`, `nis`, `id_kelas`, `tahun_ajaran`, `mapel`, `nilai`, `tulisan_nilai`, `rata`, `semester`) VALUES
('Nl001', '1232453019', 'KL003', '2024/2025', 'Ilmu Tajwid', 70, 'Tujuh Puluh', 0, 'Ganjil'),
('Nl002', '1232453019', 'KL003', '2024/2025', 'Aqidah/Akhlak', 75, 'Tujuh Lima', 0, 'Ganjil'),
('Nl003', '1232453019', 'KL003', '2024/2025', 'Fiqih', 70, 'Tujuh Puluh', 0, 'Ganjil'),
('Nl004', '1232453019', 'KL003', '2024/2025', 'Tarikh', 70, 'Tujuh Puluh', 0, 'Ganjil'),
('Nl005', '1232453019', 'KL003', '2024/2025', 'Hafalan Doa', 60, 'Enam Puluh', 0, 'Ganjil'),
('Nl006', '1232453019', 'KL003', '2024/2025', 'Nagham/Irama', 70, 'Tujuh Puluh', 0, 'Ganjil');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nis` varchar(20) NOT NULL,
  `nama_siswa` text NOT NULL,
  `level` text NOT NULL,
  `no_hp_ortu` varchar(12) NOT NULL,
  `alamat` text NOT NULL,
  `jk` text NOT NULL,
  `tempat_lahir` text NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` text NOT NULL,
  `periode_masuk` varchar(20) DEFAULT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`nis`, `nama_siswa`, `level`, `no_hp_ortu`, `alamat`, `jk`, `tempat_lahir`, `tanggal_lahir`, `agama`, `periode_masuk`, `foto`) VALUES
('1232452998', 'Rabbal Farza A.', '', '081346758392', 'Belanti Indah ', 'Laki-laki', 'Padang Utara', '2015-02-10', 'ISLAM', '2022/2023', '686e13eee111b.jpg'),
('1232452999', 'Salma Fauzia A.', '', '081254637899', 'Jl. Pinus', 'Perempuan', 'Padang', '2015-01-10', 'ISLAM', '2022/2023', '686e172da962d.jpg'),
('1232453011', 'Alifa Kumaira P.', '', '082345654432', 'Belanti Indah ', 'Perempuan', 'Padang', '2016-03-08', 'ISLAM', '2022/2023', '686e17c1aa401.jpg'),
('1232453012', 'Anindita Khairunniswa', '', '085234127687', 'Belanti Raya', 'Perempuan', 'Padang ', '2016-01-21', 'ISLAM', '2022/2023', '686e182cc34fd.jpg'),
('1232453013', 'Ajhay Rohsan', '', '081254456378', 'Belanti Raya', 'Laki-laki', 'Padang', '2015-07-15', 'ISLAM', '2022/2023', '686e18a685185.jpg'),
('1232453014', 'Rani', '', '081324435222', 'Jl. Pinus II', 'Perempuan', 'Padang ', '2016-07-13', 'ISLAM', '2022/2023', '686e23ff34331.jpg'),
('1232453015', 'Raffa', '', '085366754344', 'Belanti Indah', 'Laki-laki', 'Padang Utara', '2016-10-11', 'ISLAM', '2022/2023', '686e245c37751.jpg'),
('1232453016', 'Rifqi Rahman', '', '085243678905', 'Belanti Indah', 'Laki-laki', 'Padang', '2017-05-10', 'ISLAM', '2022/2023', '6870cf87b99ae.jpg'),
('1232453017', 'Ghazi', '', '082354316754', 'Padang Uara', 'Laki-laki', 'Padang', '2016-02-16', 'ISLAM', '2022/2023', '6878fcf3d3b00.jpg'),
('1232453018', 'M. Aidil', '', '081254673223', 'Belanti Indah', 'Laki-laki', 'Padang', '2016-03-16', 'ISLAM', '2022/2023', '6879038b17ec5.jpg'),
('1232453019', 'Khairunnisa Hayfa N.', '', '085211037021', 'Padang Utara', 'Perempuan', 'Padang', '2016-06-07', 'ISLAM', '2022/2023', '68790412329c4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_staf`
--

CREATE TABLE `tb_staf` (
  `nik` varchar(20) NOT NULL,
  `nama_staf` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `level` text NOT NULL,
  `tempat_lahir` text NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jk` text NOT NULL,
  `alamat` text NOT NULL,
  `agama` text NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_staf`
--

INSERT INTO `tb_staf` (`nik`, `nama_staf`, `username`, `password`, `level`, `tempat_lahir`, `tanggal_lahir`, `jk`, `alamat`, `agama`, `no_hp`, `foto`) VALUES
('4321', 'admin', 'admin', 'admin', 'Admin', 'Biak', '1995-10-18', 'Laki-laki', 'Padang', 'ISLAM', '085244642030', '686e19c788710.jpg'),
('4543', 'ketua', 'ketua', 'ketua', 'ketua', 'padang', '1990-03-07', 'Laki-laki', 'padang', 'ISLAM', '085657', '68452e548e7c3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_thn_ajar`
--

CREATE TABLE `tb_thn_ajar` (
  `id_thn_ajar` varchar(5) NOT NULL,
  `semester` text NOT NULL,
  `nama_thn_ajar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_thn_ajar`
--

INSERT INTO `tb_thn_ajar` (`id_thn_ajar`, `semester`, `nama_thn_ajar`) VALUES
('TH001', 'Ganjil', '2022/2023'),
('TH002', 'Genap', '2022/2023'),
('TH003', 'Ganjil', '2023/2024'),
('TH004', 'Genap', '2023/2024'),
('TH005', 'Ganjil', '2024/2025'),
('TH006', 'Genap', '2024/2025'),
('TH007', 'Ganjil', '2025/2026'),
('TH008', 'Genap', '2025/2026');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `tb_japel`
--
ALTER TABLE `tb_japel`
  ADD PRIMARY KEY (`id_japel`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tb_kelsis`
--
ALTER TABLE `tb_kelsis`
  ADD PRIMARY KEY (`id_kelsis`);

--
-- Indexes for table `tb_mapel`
--
ALTER TABLE `tb_mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `tb_materi`
--
ALTER TABLE `tb_materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nis`);

--
-- Indexes for table `tb_staf`
--
ALTER TABLE `tb_staf`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `tb_thn_ajar`
--
ALTER TABLE `tb_thn_ajar`
  ADD PRIMARY KEY (`id_thn_ajar`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
