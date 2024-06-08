-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2018 at 08:53 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jantung_cbr`
--

-- --------------------------------------------------------

--
-- Table structure for table `analisa_hasil`
--

CREATE TABLE `analisa_hasil` (
  `id` int(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelamin` char(10) NOT NULL,
  `umur` varchar(3) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `kd_penyakit` char(4) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `kd_gejala` char(4) NOT NULL,
  `gejala` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`kd_gejala`, `gejala`) VALUES
('G001', 'Dada terasa penuh'),
('G002', 'Detak jantung cepat (tachycardia)'),
('G003', 'Detak jantung lambat (bradycardia)'),
('G004', 'Nyeri pada dada'),
('G005', 'Panas'),
('G006', 'Sesak napas'),
('G008', 'katup jantung tidak bekerja dengan baik'),
('G009', 'bunyi jantung abnormal'),
('G010', 'kebocoran, penyempitan'),
('G011', 'Badan lesu atau lemah'),
('G013', 'Pusing'),
('G014', 'Pingsan (syncope)'),
('G015', 'katup jantung tanpa lubang'),
('G017', 'Sulit tidur karena gangguan rasa sakit pada daerah perut sebelah atas (ulu hati) '),
('G018', 'denyut nadi yang lemah dan cepat');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit_solusi`
--

CREATE TABLE `penyakit_solusi` (
  `kd_penyakit` char(4) NOT NULL,
  `nama_penyakit` varchar(30) DEFAULT NULL,
  `definisi` text,
  `solusi` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penyakit_solusi`
--

INSERT INTO `penyakit_solusi` (`kd_penyakit`, `nama_penyakit`, `definisi`, `solusi`) VALUES
('P001', 'Gagal Jantung', 'Gagal jantung atau Heart Failure adalah keadaan dimana jantung tidak bisa memasok aliran darah untuk memenuhi kebutuhan tubuh dan berpotensi mematikan.', 'Penyakit jantung jenis ini memiliki gejala antara lain pembengkakan pada kaki dan tangan, penambahan atau pengurangan berat badan sebelum terjadinya pembengkakan.'),
('P002', 'Heart Valve Disease', 'Heart Valve Disease atau masalah pada katup jantung adalah kedaan dimana salah satu atau lebih katub jantung tidak bekerja dengan baik. Dalam beberapa kasus, orang-orang terlahir dengan masalah pada katub jantung sedangkan beberapa orang mendapatkan  kelainan pada katub dimasa hidupnya.\r\nAda tiga jenis penyakit katup jantung yaitu kebocoran, penyempitan, dan katup tanpa lubang. Tidak ada obat untuk kelainan pada katub jantung kecuali operasi. Tetapi bagi anda yang tidak memiliki penyakit ini dari lahir,  menjaga pola makan dan pola hidup adalah kunci untuk terbebas dari penyakit ini.', '1.Tidur dengan mulut terbuka menyebabkan mulut kering di pagi hari. Sebisa mungkin bernapaslah dengan hidung ketika tidur.\r\n\r\n2. Menggunakan produk pencegah mulut kering. Untuk lebih aman, konsultasikan dengan dokter mengenai produk yang paling tepat.\r\n\r\n3. Menjaga kebersihan mulut. Sikat gigi dan berkumur secara teratur. Gunakan pula benang gigi (dental floss).\r\n\r\n4. Minum air sedikitnya 8 gelas per hari.\r\n\r\n5. Hindari konsumsi kafein dan alkohol'),
('P003', 'Aritmia', 'Jenis penyakit jantung ini adalah menggangu yakni gangguan irama atau detak jantung. Detak jantung bisa lebih cepat, lebih lambat, atau tidak teratur. Faktor utama penyakit aritmia adalah kurangnya kalsium dalam tubuh dan terjadinya penyumbatan pembuluh darah jantung.\r\nPenyumbatan pembuluh darah jantung yang juga berefek pada detak jantung yang tidak normal akan berakibat pada serangan jantung. Selain dua hal tersebut penyebab aritmia lainnya adalah diabetes, tekanan darah tinggi, merokok, kafein, stress, kematian otot jantung, penyalahgunaan obat, dan terlalu aktifnya kelenjar thyroid.\r\n', 'Makan secara teratur sangat dianjurkan untuk mengurangi resiko  timbulnya tukak lambung.'),
('P004', 'Perikarditis', 'Jenis penyakit jantung ini adalah peradangan pada kantung jantung atau pericardium sehingga menimbulkan penimbunan cairan dan penebalan. Perdangan ini disebabkan oleh beberapa hal, penyebab yang umum adalah infeksi virus dan terapi penyinaran untuk kanker payudara.', 'segera lakukan pembedahan untuk mencegah terjadinya ruptur (peca)dan Pembedahan yang segera dilakukan bisa mengurangi angka kematian pada apendisitis.'),
('P005', 'Penyakit Jantung Koroner', 'Penyakit jantung coroner disebabkan oleh lapisan lemak atau kolesterol di dinding nadi yang menyumbat pembuluh darah. Akibatnya dari penyumbatan oleh lapisan lemak dan kolesterol ini adalah terganggunya proses suplai darah dari dan ke  jantung. Ketika darah tersumbat akibat lapisan lemak maka inilah yang disebut serangan jantung. Lapisan lemak dan kolesterol di dinding nadi diakibatkan oleh kecanduan rokok, hipertensi, dan kolesterol tinggi.', '1. Menerapkan perilaku hidup sehat dengan mencuci tangan memakai sabun terutama setelah kontak dengan benda-benda kotor. \r\n2. Meningkatkan kebersihan lingkungan dan pemberian gizi yang seimbang. \r\n3. Menjaga kebersihan dari makanan atau minuman yang Anda makan.\r\n4. untuk pengobatannya pun anda dapat menkonsumsi obat-obat tradisional seperti jus kulit mangis, dan daun sirsak. Atau anda langsung berobat ke dokter.'),
('P006', 'Konstipasi', 'Konstipasi atau sembelit terjadi akibat penyerapan air yang berlebihan pada sisa makanan di dalam usus besar. Akibatnya feses menjadi sangat padat dan mengeras sehingga sulit dikeluarkan.', 'Untuk  mencegah sembelit dianjurkan untuk perbanyak mengkonsumsi makanan yang berserat, kurangi makan daging, buang air besar secara teratur setiap hari dan perbanyak makan sayur dan buah-buahan serta minum air putih.');

-- --------------------------------------------------------

--
-- Table structure for table `relasi`
--

CREATE TABLE `relasi` (
  `id_relasi` int(4) NOT NULL,
  `kd_gejala` char(4) NOT NULL,
  `kd_penyakit` char(4) NOT NULL,
  `bobot` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relasi`
--

INSERT INTO `relasi` (`id_relasi`, `kd_gejala`, `kd_penyakit`, `bobot`) VALUES
(1, 'G008', 'P002', 5),
(2, 'G018', 'P001', 5),
(3, 'G013', 'P001', 1),
(4, 'G009', 'P001', 3),
(5, 'G010', 'P002', 3),
(6, 'G015', 'P002', 5),
(8, 'G001', 'P003', 1),
(9, 'G002', 'P003', 1),
(10, 'G003', 'P003', 5),
(11, 'G004', 'P003', 5),
(12, 'G006', 'P003', 1),
(13, 'G013', 'P003', 3),
(14, 'G014', 'P003', 5),
(18, 'G005', 'P004', 1),
(19, 'G006', 'P004', 5),
(20, 'G009', 'P004', 1),
(21, 'G007', 'P005', 5),
(22, 'G020', 'P005', 5),
(23, 'G011', 'P005', 1),
(24, 'G012', 'P005', 1),
(25, 'G013', 'P005', 1),
(26, 'G021', 'P006', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_analisa`
--

CREATE TABLE `tmp_analisa` (
  `noip` varchar(30) NOT NULL,
  `kd_penyakit` char(4) NOT NULL,
  `kd_gejala` char(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_gejala`
--

CREATE TABLE `tmp_gejala` (
  `noip` int(3) NOT NULL,
  `kd_gejala` char(4) NOT NULL,
  `bobot` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_gejala`
--

INSERT INTO `tmp_gejala` (`noip`, `kd_gejala`, `bobot`) VALUES
(130869, 'G005', 0),
(130870, 'G008', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_pasien`
--

CREATE TABLE `tmp_pasien` (
  `id` int(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelamin` char(10) NOT NULL,
  `umur` varchar(3) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `noip` varchar(30) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_pasien`
--

INSERT INTO `tmp_pasien` (`id`, `nama`, `kelamin`, `umur`, `alamat`, `noip`, `tanggal`) VALUES
(96, 'Testing', 'Laki-laki', '25', 'Jabar', '::1', '2018-09-05 13:26:33');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penyakit`
--

CREATE TABLE `tmp_penyakit` (
  `noip` varchar(30) NOT NULL,
  `kd_penyakit` char(4) NOT NULL,
  `nilai` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tmp_penyakit`
--

INSERT INTO `tmp_penyakit` (`noip`, `kd_penyakit`, `nilai`) VALUES
('', 'P001', 0),
('', 'P002', 0.38461538461538),
('', 'P003', 0),
('', 'P004', 0.14285714285714),
('', 'P005', 0),
('', 'P006', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analisa_hasil`
--
ALTER TABLE `analisa_hasil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`kd_gejala`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `penyakit_solusi`
--
ALTER TABLE `penyakit_solusi`
  ADD PRIMARY KEY (`kd_penyakit`);

--
-- Indexes for table `relasi`
--
ALTER TABLE `relasi`
  ADD PRIMARY KEY (`id_relasi`);

--
-- Indexes for table `tmp_analisa`
--
ALTER TABLE `tmp_analisa`
  ADD PRIMARY KEY (`noip`);

--
-- Indexes for table `tmp_gejala`
--
ALTER TABLE `tmp_gejala`
  ADD PRIMARY KEY (`noip`);

--
-- Indexes for table `tmp_pasien`
--
ALTER TABLE `tmp_pasien`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analisa_hasil`
--
ALTER TABLE `analisa_hasil`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=590;

--
-- AUTO_INCREMENT for table `relasi`
--
ALTER TABLE `relasi`
  MODIFY `id_relasi` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tmp_gejala`
--
ALTER TABLE `tmp_gejala`
  MODIFY `noip` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130871;

--
-- AUTO_INCREMENT for table `tmp_pasien`
--
ALTER TABLE `tmp_pasien`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
