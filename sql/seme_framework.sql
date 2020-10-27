-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2020 at 06:50 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `seme_framework`
--

-- --------------------------------------------------------

--
-- Table structure for table `a_apikey`
--

DROP TABLE IF EXISTS `a_apikey`;
CREATE TABLE `a_apikey` (
  `nation_code` int(3) NOT NULL DEFAULT 62,
  `id` int(4) NOT NULL,
  `code` varchar(8) CHARACTER SET latin1 NOT NULL COMMENT 'alias apikey',
  `name` varchar(24) COLLATE utf8_unicode_ci NOT NULL COMMENT 'apikey for',
  `cdate` datetime DEFAULT NULL COMMENT 'create date',
  `ldate` timestamp NULL DEFAULT NULL COMMENT 'lastupdate',
  `is_active` int(1) NOT NULL DEFAULT 1 COMMENT '1 active, 0 inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='API Key storage';

--
-- Dumping data for table `a_apikey`
--

INSERT INTO `a_apikey` (`nation_code`, `id`, `code`, `name`, `cdate`, `ldate`, `is_active`) VALUES
(62, 1, '37329ab', 'general 37329', '2020-06-09 09:47:18', '2020-09-24 15:30:41', 1),
(62, 2, '1234ABCD', 'iOS APIKEY lorem lips', '2020-06-09 09:47:18', '2020-06-09 02:47:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `b_user`
--

DROP TABLE IF EXISTS `b_user`;
CREATE TABLE `b_user` (
  `id` int(6) UNSIGNED NOT NULL,
  `nama` varchar(78) DEFAULT NULL,
  `alamat` varchar(78) DEFAULT NULL,
  `cdate` date DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `b_user`
--

INSERT INTO `b_user` (`id`, `nama`, `alamat`, `cdate`, `is_active`) VALUES
(1, 'Anisa Saraswati', 'Cijengkol', '2019-12-28', 1),
(2, 'Hafizah Jurumiyah', 'Dusun Bambu', '2018-10-08', 1),
(3, 'Kristian Hariyanto', 'Komplek Garuda', '2017-03-22', 1),
(4, 'Dzaki Marsyadi', 'Dusun Bambu', '2020-01-22', 1),
(5, 'Jane Siska Irianti', 'Perum Cemara', '2020-01-21', 1),
(6, 'Sinta Damayani', 'Perum Cemara', '2020-01-21', 1),
(7, 'Ade Kusnanda', 'Cijengkol', '2020-02-21', 1),
(8, 'Benny Ismail', 'Dusun Bambu', '2020-01-22', 1),
(9, 'Cecep Suhendar', 'Cijengkol', '2019-07-28', 1),
(10, 'Bunga Aisyiah', 'Perum Cemara', '2019-07-27', 1),
(11, 'Heny Fauziah', 'Komplek Garuda', '2017-03-22', 0),
(12, 'Sri Rara', 'Komplek Garuda', '2018-01-20', 1),
(13, 'Chantika Nuraini', 'Perum Cemara', '2018-02-13', 1),
(14, 'Eva Anindiya', 'Komplek Garuda', '2017-03-22', 0),
(15, 'Jaka van Java', 'Cijengkol', '2020-10-10', 1),
(16, 'Ibrahim Utoyo', 'Cijengkol', '2020-09-30', 1),
(17, 'Irfan Maulana Karim', 'Cirengas', '2020-06-01', 1),
(18, 'Siti Kinara', 'Cirengas', '2020-05-28', 1),
(19, 'Farhan Adam', 'Cirengas', '2020-05-29', 1),
(20, 'Gani Abdul Gofur', 'Cirengas', '2019-08-17', 0),
(21, 'Septian Cahyono', 'Komplek Garuda ', '2019-08-17', 0),
(22, 'Maulana Sukmawan', 'Cijengkol', '2019-08-16', 0),
(23, 'Zhea Nurul Endah', 'Cijengkol', '2019-08-16', 1),
(24, 'Xena Novita', 'Perum Cemara', '2020-02-02', 1),
(25, 'Zamzam Maulidan', 'Perum Cemara', '2020-02-02', 1),
(26, 'Karina Siahaan', 'Komplek Garuda', '2020-02-02', 1),
(27, 'Rizky Lukman', 'Komplek Garuda', '2020-01-03', 1),
(28, 'Lenny Handayani', 'Komplek Garuda', '2020-01-03', 1),
(29, 'Lia Kartika', 'Komplek Garuda', '2020-01-04', 1),
(30, 'Meilia Nur Azizah', 'Komplek Garuda', '2018-08-28', 1),
(31, 'Meiriska Sihombing', 'Komplek Garuda', '2019-01-03', 0),
(32, 'Tanu Astina', 'Cijengkol', '2019-02-24', 1),
(33, 'Tika Rahayu', 'Cijengkol', '2019-03-03', 1),
(34, 'Saepul Tajuddin', 'Cijengkol', '2018-06-01', 0),
(35, 'Neng Icha Salamah', 'Cijengkol', '2020-02-20', 1),
(36, 'Keenan Abraham', 'Komplek Garuda', '2018-11-10', 1),
(37, 'Lucky Ananda', 'Komplek Garuda', '2018-12-10', 1),
(38, 'Marni Sumarni', 'Perum Cemara', '2019-03-28', 1),
(39, 'Chintya Putri', 'Perum Cemara', '2019-04-01', 1),
(40, 'Kharisma Putri', 'Perum Cemara', '2019-05-01', 1),
(41, 'Sapta Senoadji', 'Perum Cemara', '2019-05-02', 1),
(42, 'Tirta Asih', 'Perum Cemara', '2019-05-03', 1),
(43, 'Nyla Putri Dewanti', 'Perum Cemara', '2020-01-03', 1),
(44, 'Riska Putry', 'Komplek Garuda', '2020-01-04', 1),
(45, 'Santi Alami', 'Komplek Garuda', '2020-02-01', 1),
(46, 'Tantry Latuconsina', 'Komplek Garuda', '2020-03-04', 1),
(47, 'Ulysess Victory', 'Perum Cemara', '2020-04-01', 1),
(48, 'Vany Ghaniya', 'Komplek Garuda', '2020-09-01', 1),
(49, 'Vita Komala', 'Perum Cemara', '2020-10-01', 1),
(50, 'Windy Ozama', 'Perum Cemara', '2020-11-11', 1),
(51, 'Yani Nurcahyani', 'Cijengkol', '2017-01-03', 0),
(52, 'Enny Rohanan', 'Cijengkol', '2017-08-01', 0),
(53, 'Endang Muhidin', 'Cijengkol', '2017-09-12', 1),
(54, 'Seto Adrian', 'Cijengkol', '2017-02-13', 1),
(55, 'Charlotte Friskiany', 'Perum Cemara', '2017-02-13', 1),
(56, 'Randi Setiawan', 'Perum cemara ', '2017-06-30', 1),
(57, 'Qory Nurjannah', 'Perum cemara', '2017-12-12', 1),
(58, 'Penny Lamborghiny', 'Perum Cemara', '2018-01-31', 1),
(59, 'Paduka Mahaliman', 'Perum Cemara', '2019-12-01', 1),
(60, 'Friska Aviany Octavia', 'Perum Cemara', '2019-03-12', 1),
(61, 'Nurul Dewi', 'Perum Cemara', '2020-04-01', 1),
(62, 'Dzikry Turmudzi', 'Cijengkol', '2020-01-03', 1),
(63, 'Oon Nursyiam', 'Cijengkol', '2019-01-26', 1),
(64, 'Dadang Khalid', 'Cijengkol', '2020-07-27', 1),
(65, 'Gina Melati Putri', 'Cijengkol', '2019-09-01', 1),
(66, 'Herlina Ismawati', 'Cijengkol', '2020-01-01', 1),
(67, 'Onny Jalaludin', 'Cijengkol', '2019-01-31', 1),
(68, 'Aan Pratama', 'Komplek Garuda', '2017-11-01', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `a_apikey`
--
ALTER TABLE `a_apikey`
  ADD PRIMARY KEY (`id`,`nation_code`);

--
-- Indexes for table `b_user`
--
ALTER TABLE `b_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `b_user`
--
ALTER TABLE `b_user`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
SET FOREIGN_KEY_CHECKS=1;
