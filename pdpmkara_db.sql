-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               12.0.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- Source:                       Prepared for deploy (phpMyAdmin/HeidiSQL compatible)
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- --------------------------------------------------------
-- Schema: pdpmkara_db
-- Order: roles, cabang, ranting, users, agenda, agenda_peserta,
--        absensi_kegiatan, berita, galeri, struktur_cabang,
--        migrations, user_points, voting, voting_options, voting_votes
-- --------------------------------------------------------

-- Dumping structure for table pdpmkara_db.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `nama_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.roles
INSERT INTO `roles` (`id`, `nama_role`) VALUES
	(1, 'Super Admin'),
	(2, 'Admin'),
	(3, 'Anggota')
ON DUPLICATE KEY UPDATE `nama_role`=VALUES(`nama_role`);

-- Dumping structure for table pdpmkara_db.cabang
CREATE TABLE IF NOT EXISTS `cabang` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `nama_cabang` varchar(100) NOT NULL,
  `nama_ketua` varchar(255) DEFAULT NULL,
  `nama_sekretaris` varchar(255) DEFAULT NULL,
  `nama_bendahara` varchar(255) DEFAULT NULL,
  `cp_cabang` varchar(20) DEFAULT NULL,
  `email_cabang` varchar(255) DEFAULT NULL,
  `alamat_sekretariat` text DEFAULT NULL,
  `foto_sekretariat` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `deskripsi_cabang` text DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `admin_id` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.cabang
INSERT INTO `cabang` (`id`, `nama_cabang`, `nama_ketua`, `nama_sekretaris`, `nama_bendahara`, `cp_cabang`, `email_cabang`, `alamat_sekretariat`, `foto_sekretariat`, `instagram`, `facebook`, `twitter`, `youtube`, `website`, `deskripsi_cabang`, `is_completed`, `admin_id`, `created_at`, `updated_at`) VALUES
	(1, 'Colomadu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(2, 'Gondangrejo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(3, 'Jaten', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(4, 'Jatipuro', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(5, 'Jatiyoso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(6, 'Jenawi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(7, 'Jumapolo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(8, 'Jumantono', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(9, 'Karanganyar', 'Akaza', 'Giyu', 'Sanemi', '08572526535', 'karanganyar@gmail.com', 'JL. Derpoyudo, Munggur Kidul RT 03 RW 13 Bejen Karanganyar', '1756154877_df9b40448fc744ec2002.png', 'https://www.instagram.com/zaki_tepe/reels/', 'https://www.instagram.com/zaki_tepe/reels/', '', 'https://www.instagram.com/zaki_tepe/reels/', '', 'ini adalah tongkrongan kami, bukan tongkrongan pecundang', 1, NULL, NULL, '2025-08-25 20:47:57'),
	(10, 'Karangpandan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(11, 'Kebakkramat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(12, 'Kerjo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(13, 'Matesih', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(14, 'Ngargoyoso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(15, 'Mojogedang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(16, 'Tasikmadu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
	(17, 'Tawangmangu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL)
ON DUPLICATE KEY UPDATE `nama_cabang`=VALUES(`nama_cabang`);

-- Dumping structure for table pdpmkara_db.ranting
CREATE TABLE IF NOT EXISTS `ranting` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `nama_ranting` varchar(100) NOT NULL,
  `id_cabang` int(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ranting_id_cabang_foreign` (`id_cabang`),
  CONSTRAINT `ranting_id_cabang_foreign` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.ranting
INSERT INTO `ranting` (`id`, `nama_ranting`, `id_cabang`) VALUES
	(1, 'Baturan', 1),
	(2, 'Blulukan', 1),
	(3, 'Bolon', 1),
	(4, 'Gajahan', 1),
	(5, 'Gawanan', 1),
	(6, 'Gedongan', 1),
	(7, 'Klodran', 1),
	(8, 'Malangjiwan', 1),
	(9, 'Ngasem', 1),
	(10, 'Paulan', 1),
	(11, 'Tohudan', 1),
	(12, 'Bulurejo', 2),
	(13, 'Dayu', 2),
	(14, 'Jatikuwung', 2),
	(15, 'Jeruksawit', 2),
	(16, 'Karangturi', 2),
	(17, 'Kragan', 2),
	(18, 'Krendowahono', 2),
	(19, 'Plesungan', 2),
	(20, 'Rejosari', 2),
	(21, 'Selokaton', 2),
	(22, 'Tuban', 2),
	(23, 'Wonorejo', 2),
	(24, 'Wonosari', 2),
	(25, 'Brujul', 3),
	(26, 'Dagen', 3),
	(27, 'Jaten', 3),
	(28, 'Jati', 3),
	(29, 'Jetis', 3),
	(30, 'Ngringo', 3),
	(31, 'Sroyo', 3),
	(32, 'Suruhkalang', 3),
	(33, 'Jatiharjo', 4),
	(34, 'Jatikuwung', 4),
	(35, 'Jatimulyo', 4),
	(36, 'Jatipuro', 4),
	(37, 'Jatipurwo', 4),
	(38, 'Jatiroyo', 4),
	(39, 'Jatisobo', 4),
	(40, 'Jatisuko', 4),
	(41, 'Jatiwarno', 4),
	(42, 'Ngepungsari', 4),
	(43, 'Beruk', 5),
	(44, 'Jatisawit', 5),
	(45, 'Jatiyoso', 5),
	(46, 'Karangsari', 5),
	(47, 'Petung', 5),
	(48, 'Tlobo', 5),
	(49, 'Wonokeling', 5),
	(50, 'Wonorejo', 5),
	(51, 'Wukirsawit', 5),
	(52, 'Anggrasmanis', 6),
	(53, 'Balong', 6),
	(54, 'Gumeng', 6),
	(55, 'Jenawi', 6),
	(56, 'Lempong', 6),
	(57, 'Menjing', 6),
	(58, 'Seloromo', 6),
	(59, 'Sidomukti', 6),
	(60, 'Trengguli', 6),
	(61, 'Bakalan', 7),
	(62, 'Giriwondo', 7),
	(63, 'Jatirejo', 7),
	(64, 'Jumantoro', 7),
	(65, 'Jumapolo', 7),
	(66, 'Kadipiro', 7),
	(67, 'Karangbangun', 7),
	(68, 'Kedawung', 7),
	(69, 'Kwangsan', 7),
	(70, 'Lemahbang', 7),
	(71, 'Paseban', 7),
	(72, 'Ploso', 7),
	(73, 'Blorong', 8),
	(74, 'Gemantar', 8),
	(75, 'Genengan', 8),
	(76, 'Kebak', 8),
	(77, 'Ngunut', 8),
	(78, 'Sambirejo', 8),
	(79, 'Sedayu', 8),
	(80, 'Sringin', 8),
	(81, 'Sukosari', 8),
	(82, 'Tugu', 8),
	(83, 'Tunggulrejo', 8),
	(84, 'Bejen', 9),
	(85, 'Bolong', 9),
	(86, 'Cangakan', 9),
	(87, 'Delingan', 9),
	(88, 'Gayamdompo', 9),
	(89, 'Gedong', 9),
	(90, 'Jantiharjo', 9),
	(91, 'Jungke', 9),
	(92, 'Karanganyar', 9),
	(93, 'Lalung', 9),
	(94, 'Popongan', 9),
	(95, 'Tegalgede', 9),
	(96, 'Bangsri', 10),
	(97, 'Dayu', 10),
	(98, 'Doplang', 10),
	(99, 'Gerdu', 10),
	(100, 'Gondangmanis', 10),
	(101, 'Harjosari', 10),
	(102, 'Karang', 10),
	(103, 'Karangpandan', 10),
	(104, 'Ngemplak', 10),
	(105, 'Salam', 10),
	(106, 'Tohkuning', 10),
	(107, 'Alastuwo', 11),
	(108, 'Banjarharjo', 11),
	(109, 'Kaliwuluh', 11),
	(110, 'Kebak', 11),
	(111, 'Kemiri', 11),
	(112, 'Macanan', 11),
	(113, 'Malanggaten', 11),
	(114, 'Nangsri', 11),
	(115, 'Pulosari', 11),
	(116, 'Waru', 11),
	(117, 'Botok', 12),
	(118, 'Ganten', 12),
	(119, 'Gempolan', 12),
	(120, 'Karangrejo', 12),
	(121, 'Kuto', 12),
	(122, 'Kwadungan', 12),
	(123, 'Plosorejo', 12),
	(124, 'Sumberejo', 12),
	(125, 'Tamansari', 12),
	(126, 'Tawangsari', 12),
	(127, 'Dawung', 13),
	(128, 'Gantiwarno', 13),
	(129, 'Girilayu', 13),
	(130, 'Karangbangun', 13),
	(131, 'Koripan', 13),
	(132, 'Matesih', 13),
	(133, 'Ngadiluwih', 13),
	(134, 'Pablengan', 13),
	(135, 'Plosorejo', 13),
	(136, 'Berjo', 14),
	(137, 'Dukuh', 14),
	(138, 'Girimulyo', 14),
	(139, 'Jatirejo', 14),
	(140, 'Kemuning', 14),
	(141, 'Ngargoyoso', 14),
	(142, 'Nglegok', 14),
	(143, 'Puntukrejo', 14),
	(144, 'Segorogunung', 14),
	(145, 'Buntar', 15),
	(146, 'Gebyok', 15),
	(147, 'Gentungan', 15),
	(148, 'Kaliboto', 15),
	(149, 'Kedungjeruk', 15),
	(150, 'Mojogedang', 15),
	(151, 'Mojoroto', 15),
	(152, 'Munggur', 15),
	(153, 'Ngadirejo', 15),
	(154, 'Pendem', 15),
	(155, 'Pereng', 15),
	(156, 'Pojok', 15),
	(157, 'Sewurejo', 15),
	(158, 'Buran', 16),
	(159, 'Gaum', 16),
	(160, 'Kalijirak', 16),
	(161, 'Kaling', 16),
	(162, 'Karangmojo', 16),
	(163, 'Ngijo', 16),
	(164, 'Pandeyan', 16),
	(165, 'Papahan', 16),
	(166, 'Suruh', 16),
	(167, 'Wonolopo', 16),
	(168, 'Bandardawung', 17),
	(169, 'Gondosuli', 17),
	(170, 'Karanglo', 17),
	(171, 'Nglebak', 17),
	(172, 'Plumbon', 17),
	(173, 'Sepanjang', 17),
	(174, 'Tengklik', 17),
	(175, 'Blumbang', 17),
	(176, 'Kalisoro', 17),
	(177, 'Tawangmangu', 17)
ON DUPLICATE KEY UPDATE `nama_ranting`=VALUES(`nama_ranting`), `id_cabang`=VALUES(`id_cabang`);

-- Dumping structure for table pdpmkara_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `nbm` varchar(50) DEFAULT NULL,
  `alamat_rumah` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `is_kokam` tinyint(1) DEFAULT 0,
  `tipe_pimpinan` varchar(255) DEFAULT NULL,
  `jabatan_organisasi` varchar(255) DEFAULT NULL,
  `jabatan_struktural` varchar(255) DEFAULT NULL,
  `jabatan_bidang` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int(5) unsigned NOT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `id_ranting` int(5) unsigned DEFAULT NULL,
  `status` enum('Aktif','Menunggu Verifikasi','Ditolak','Tidak Aktif') NOT NULL DEFAULT 'Menunggu Verifikasi',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `users_id_role_foreign` (`id_role`),
  KEY `users_id_cabang_foreign` (`id_cabang`),
  KEY `users_id_ranting_foreign` (`id_ranting`),
  CONSTRAINT `users_id_ranting_foreign` FOREIGN KEY (`id_ranting`) REFERENCES `ranting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_id_role_foreign` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.users
INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `no_hp`, `nbm`, `alamat_rumah`, `tanggal_lahir`, `foto`, `is_kokam`, `tipe_pimpinan`, `jabatan_organisasi`, `jabatan_struktural`, `jabatan_bidang`, `jabatan`, `password`, `id_role`, `id_cabang`, `id_ranting`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin PDPM', 'superadmin@pdpmkra.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '$2y$10$LLHzggacj5jCp6sO.yZIuu2wARK9xSaaiWsJhAXtCLXcnJ0WA/A62', 1, NULL, NULL, 'Aktif', NULL, NULL),
	(9, 'ZAKI TRI PAMUNGKAS', 'zakitripamungkas03@gmail.com', '08572526535', '112003211397991', 'JL. Derpoyudo, Munggur Kidul RT 03 RW 13 Bejen Karanganyar', '2003-12-27', '1755865130_f845faee68cbc193e268.jpeg', 0, 'daerah', 'anggota', '', 'Organisasi & Keanggotaan', 'Organisasi & Keanggotaan', '$2y$10$cfGoiiaOjmece31uQ90Y0./6PUv3eWHKfHXupoHLDkPS4vR8Qvbtq', 3, 0, NULL, 'Aktif', '2025-08-22 11:13:02', '2025-09-03 12:23:45'),
	(14, 'Hafizt Ayatollah ', 'ayatollahhafizt@gmail.com', '087879104482', NULL, NULL, '2003-11-08', '1755926070_2c88268f9c7093425ce5.jpg', 0, 'daerah', 'anggota', '', 'Hikmah & Hubungan antar Lembaga', 'Hikmah & Hubungan antar Lembaga', '$2y$10$4shUeTIV32LTk6YAso3PYufwsH2Z0v7yLNZvEmHZ2H1P6Tansy8C.', 3, 0, NULL, 'Aktif', '2025-08-23 05:14:30', '2025-08-23 06:40:16'),
	(15, 'Atha Zha Zha Zaky ', 'muhabduh6@gmail.com', '081326880316', '1299386', NULL, '1996-10-28', '1755931175_248b4a377cd9fc59b828.jpg', 0, 'daerah', 'harian', 'Wakil Ketua', 'Organisasi & Keanggotaan', 'Wakil Ketua Bidang Organisasi & Keanggotaan', '$2y$10$yAOukil8fzNrWoO9YmWPwuC500LUdEXkm5/V9agSCttU4YR9XjOJm', 3, 0, NULL, 'Aktif', '2025-08-23 06:39:35', '2025-08-23 06:40:19'),
	(18, 'Rizal Romadhony ', 'romadhonirizal1@gmail.com', '085156046769', '1459388', NULL, '1998-12-23', '1755960988_4fa9dbd3600e6b0678c1.jpeg', 0, 'daerah', 'harian', 'Wakil Sekretaris', 'Komunikasi, Informasi, Riset & Teknologi', 'Wakil Sekretaris Bidang Komunikasi, Informasi, Riset & Teknologi', '$2y$10$7QyS.BmWkKEutr8ou5CPGehPnbf8d7QaqXEt3ikxnillWxWYBW4py', 3, 0, NULL, 'Aktif', '2025-08-23 14:56:28', '2025-08-23 14:57:00'),
	(19, 'Tabah Sulistyono,S.Ud.,M.P.I.,M.Pd.,Gr.', 'tabah17sulistyono@gmail.com', '085329012062', '1202263', NULL, '1988-06-17', '1755962124_25a46f28c96ebe65f92d.jpg', 1, 'daerah', 'harian', 'Wakil Sekretaris', 'Ekonomi, Kewirausahaan, Buruh & Tani', 'Wakil Sekretaris Bidang Ekonomi, Kewirausahaan, Buruh & Tani', '$2y$10$kq7VjeklcbxRZJq0A9EH.uYMXIBwBPb/.TlKgZ6WhrJ6QTM5OtQHK', 3, 0, NULL, 'Aktif', '2025-08-23 15:15:24', '2025-08-23 15:15:38'),
	(20, 'M. Syahrul Shidiq, S.Pd.I,M.Pd.', 'arul.shidiq@gmail.com', '085642370149', '112088161250042', NULL, '1988-07-15', '1755981133_a4922a1fcc25d21d48ae.jpg', 0, 'daerah', 'harian', 'Wakil Ketua', 'Dakwah & Pengkajian Agama', 'Wakil Ketua Bidang Dakwah & Pengkajian Agama', '$2y$10$WRZoD1bi74qGIlkhRqwNLup3hEwwLb/IXbzDZmBB/59/fvU.di5zS', 3, 0, NULL, 'Aktif', '2025-08-23 20:32:13', '2025-08-23 22:32:00'),
	(21, 'Mariyo', 'mariolintasmaya@gmail.com', '085647246096', '1109722', NULL, '1985-04-16', '1756003678_852070b81097d628ebeb.jpg', 1, 'daerah', 'harian', 'Wakil Sekretaris', 'KOKAM & SAR', 'Wakil Sekretaris Bidang KOKAM & SAR', '$2y$10$a5BpI0FwK76e5OiIWEGJQ.UUODXCNJnSNW3sCaU7/R9dtsCYbMDpW', 3, 0, NULL, 'Aktif', '2025-08-24 02:47:58', '2025-08-24 04:03:31'),
	(22, 'Anggoro Wahid Bayu Prishasn9', 'anggoroprishasno@gmail.com', '088238941946', NULL, NULL, '2000-08-22', '1756025426_5daa633ebc598db1e0d6.jpg', 0, 'daerah', 'harian', 'Wakil Sekretaris', 'Hikmah & Hubungan antar Lembaga', 'Wakil Sekretaris Bidang Hikmah & Hubungan antar Lembaga', '$2y$10$RBm6YRYKsn0401oqMQTvA.bYZoc5f4wx8Nalg67SlJdLVvrjjGT/y', 3, 0, NULL, 'Aktif', '2025-08-24 08:50:26', '2025-08-24 11:34:38'),
	(23, 'WARSITO', 'warsitodarsi@gmail.com', '082135993303', NULL, NULL, '1980-03-16', '1756038684_ff36742dc5da597c586f.jpg', 1, 'ranting', 'anggota', '', 'KOKAM & SAR', 'KOKAM & SAR', '$2y$10$MJFKOqR/GzoL7t/qi71V3uNvjooN8MuDZdcn63DtTUQhlUbvHHCeW', 3, 17, 170, 'Aktif', '2025-08-24 12:31:24', '2025-08-24 13:47:31'),
	(24, 'Giyono', 'mbknaila217@gmail.com', '087764726904', NULL, NULL, '1988-05-11', '1756040211_2387b371078591b3303e.jpg', 0, 'ranting', 'anggota', '', 'KOKAM & SAR', 'KOKAM & SAR', '$2y$10$hCrJA3e9U13IzVj5fA7aPuuW6XVAgqeRZ8bzLRfj6WU68MOp.Jb3W', 3, 5, 45, 'Aktif', '2025-08-24 12:56:51', '2025-08-24 13:47:39'),
	(25, 'WARSITO', 'winnikeadhita@gmail.com', '082135993303', NULL, NULL, '1980-03-16', '1756041441_af11aedf7b080a4505a9.jpg', 1, 'ranting', 'anggota', '', 'KOKAM & SAR', 'KOKAM & SAR', '$2y$10$ZhQTCAQgj5eqgdAL7IqjW.diHy1xgqYmtc6dhEDrH983.DwunUT2K', 3, 17, 170, 'Aktif', '2025-08-24 13:17:22', '2025-08-24 13:48:17'),
	(26, 'PCPM KARANGANYAR', 'karanganyar@gmail.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '$2y$10$QtgR3Gq.yPl/O4/bHmWBlOrWXKSwcaSUaPH4dF1UdkJ8ZmWErQ60e', 2, 9, NULL, 'Aktif', '2025-08-25 20:46:01', '2025-08-25 20:46:01'),
	(29, 'Super Administrator', 'superadmin@pdpm.com', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '$2y$10$7l6LGZgC.CzaVXovlRRYAub0oFxN9JSGDuuC6uADotZPVBJ5f/ZWu', 1, 1, NULL, 'Aktif', '2025-09-01 12:16:47', '2025-09-01 12:16:47'),
	(31, 'kaneki', 'kk@gmail.com', '085725265355', '2131421421312', 'JL. Derpoyudo, Munggur Kidul RT 03 RW 13 Bejen Karanganyar ', '2025-09-03', '1756877112_eef496a95c2defc4b998.png', 1, 'cabang', 'harian', 'Wakil Ketua', 'Hikmah & Hubungan antar Lembaga', 'Wakil Ketua Bidang Hikmah & Hubungan antar Lembaga', '$2y$10$PwWIRJZW36rZxeMsZiAse.NulMYBNTvwIeKPMirB0d0Fz5kWjzNiu', 3, 9, NULL, 'Aktif', '2025-09-03 12:25:12', '2025-09-03 12:26:14')
ON DUPLICATE KEY UPDATE `email`=VALUES(`email`);

-- Dumping structure for table pdpmkara_db.agenda
CREATE TABLE IF NOT EXISTS `agenda` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kegiatan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `radius_meter` int(11) NOT NULL DEFAULT 100,
  `tanggal_mulai` datetime NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `id_penulis` int(11) unsigned NOT NULL,
  `tingkat_agenda` enum('daerah','cabang') DEFAULT 'daerah',
  `id_cabang_khusus` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agenda_id_penulis_foreign` (`id_penulis`),
  CONSTRAINT `agenda_id_penulis_foreign` FOREIGN KEY (`id_penulis`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.agenda
INSERT INTO `agenda` (`id`, `nama_kegiatan`, `deskripsi`, `lokasi`, `latitude`, `longitude`, `radius_meter`, `tanggal_mulai`, `jam_mulai`, `tanggal_selesai`, `jam_selesai`, `id_penulis`, `tingkat_agenda`, `id_cabang_khusus`, `created_at`, `updated_at`) VALUES
	(4, 'Rapat Pimpinan Harian PDPM Kab.Karanganyar', 'Dalam rangka suksesi RAKOR Triwulan PDPM Solo Raya', 'sssss', -7.60023297, 110.98056078, 100, '2025-08-27 02:00:00', '02:00:00', '2025-08-27 16:00:00', '16:00:00', 1, 'daerah', NULL, '2025-08-22 16:06:36', '2025-08-26 22:11:02')
ON DUPLICATE KEY UPDATE `nama_kegiatan`=VALUES(`nama_kegiatan`);

-- Dumping structure for table pdpmkara_db.agenda_peserta
CREATE TABLE IF NOT EXISTS `agenda_peserta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_agenda` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `status_pendaftaran` enum('terdaftar','batal') NOT NULL DEFAULT 'terdaftar',
  `tanggal_daftar` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_peserta` (`id_agenda`,`id_user`),
  KEY `agenda_peserta_id_user_foreign` (`id_user`),
  CONSTRAINT `agenda_peserta_id_agenda_foreign` FOREIGN KEY (`id_agenda`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `agenda_peserta_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table pdpmkara_db.absensi_kegiatan
CREATE TABLE IF NOT EXISTS `absensi_kegiatan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_agenda` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `waktu_absen` datetime NOT NULL DEFAULT current_timestamp(),
  `latitude_absen` decimal(10,8) NOT NULL,
  `longitude_absen` decimal(11,8) NOT NULL,
  `jarak_meter` decimal(8,2) NOT NULL,
  `status_absen` enum('hadir','terlambat') NOT NULL DEFAULT 'hadir',
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_absensi` (`id_agenda`,`id_user`),
  KEY `absensi_kegiatan_id_user_foreign` (`id_user`),
  CONSTRAINT `absensi_kegiatan_id_agenda_foreign` FOREIGN KEY (`id_agenda`) REFERENCES `agenda` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `absensi_kegiatan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table pdpmkara_db.berita
CREATE TABLE IF NOT EXISTS `berita` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `id_penulis` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `berita_id_penulis_foreign` (`id_penulis`),
  CONSTRAINT `berita_id_penulis_foreign` FOREIGN KEY (`id_penulis`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.berita
INSERT INTO `berita` (`id`, `judul`, `slug`, `isi`, `gambar`, `id_penulis`, `created_at`, `updated_at`) VALUES
	(2, ' Sosok Ikhlas di Balik Layar Media PDPM Karanganyar', 'sosok-ikhlas-di-balik-layar-media-pdpm-karanganyar', '<p style="text-align: justify;" data-start="209" data-end="517">Di balik lancarnya penyebaran dakwah dan informasi melalui media sosial <strong data-start="281" data-end="301">PDPM Karanganyar</strong>, ada sosok yang mungkin jarang tampil di depan layar, tetapi kontribusinya sangat besar. Ia adalah <strong data-start="401" data-end="416">Zunia Suneo</strong>, anggota PDPM Karanganyar yang dikenal rendah hati, sabar, dan selalu bersemangat dalam berdakwah.</p>\r\n<p style="text-align: justify;" data-start="519" data-end="913">Zunia bukan hanya hadir dalam setiap program dan kegiatan, tapi juga menjadi motor penggerak media yang aktif dan konsisten. Meski sering dihadapkan pada keterbatasan waktu dan kuota internet, ia tidak pernah menjadikan itu sebagai alasan untuk berhenti berkarya. Justru, Zunia rela mengorbankan kuota serta waktu pribadinya demi memastikan media PDPM tetap hidup, informatif, dan inspiratif.</p>\r\n<p style="text-align: justify;" data-start="915" data-end="1153">Yang membuat perannya semakin berharga adalah keikhlasan. Hingga kini, Zunia menjalankan tugas-tugas media <strong data-start="1022" data-end="1058">tanpa imbalan materi sedikit pun</strong>. Semua ia lakukan semata-mata karena dorongan hati untuk berdakwah dan memajukan organisasi.</p>\r\n<p style="text-align: justify;" data-start="1155" data-end="1449">Sikap ini menjadi teladan nyata bagi generasi muda Muhammadiyah, khususnya di Karanganyar. Zunia membuktikan bahwa dakwah tidak harus selalu di mimbar atau panggung besar. Lewat media sosial, desain, caption, dan konten yang dikelola dengan niat baik, dakwah bisa menyentuh hati banyak orang.</p>\r\n<p style="text-align: justify;" data-start="1451" data-end="1669">🙏 <strong data-start="1454" data-end="1477">Terima kasih, Zunia</strong>, atas kerja sunyi yang penuh arti. Semoga Allah SWT membalas setiap jerih payahmu dengan pahala yang terus mengalir. Tetap semangat berdakwah dan teruslah menjadi inspirasi bagi kita semua.</p>\r\n<div id="ag-1755888679964" style="text-align: justify;"></div>\r\n<p style="text-align: justify;">&nbsp;</p>\r\n<div id="ag-1755890269602" style="text-align: justify;"></div>\r\n<p>&nbsp;</p>', '1755891531_fbd3ac7226bb5814c71b.jpg', 1, '2025-08-20 20:16:34', '2025-08-22 19:38:51'),
	(3, 'Karanganyar Night Carnival 2025: Lautan Cahaya & Kreativitas Warga Meriahkan HUT RI ke-80!', 'karanganyar-night-carnival-2025-lautan-cahaya-kreativitas-warga-meriahkan-hut-ri-ke-80', '<p style="text-align: justify;" data-start="263" data-end="554"><strong data-start="263" data-end="291">Karanganyar, Jawa Tengah</strong> &ndash; Ribuan warga tumpah ruah di jalan utama Kabupaten Karanganyar pada gelaran <strong data-start="369" data-end="404">Karanganyar Night Carnival 2025</strong>, Jum\'at (22/08/2025) malam. Acara spektakuler ini diselenggarakan dalam rangka memeriahkan <strong data-start="494" data-end="551">Hari Ulang Tahun Kemerdekaan Republik Indonesia ke-80</strong>.</p>\r\n<p style="text-align: justify;" data-start="556" data-end="913">Dengan tema <em data-start="568" data-end="615">&ldquo;Cahaya Nusantara, Harmoni dalam Keberagaman&rdquo;</em>, karnaval malam ini menghadirkan berbagai pertunjukan seni, arak-arakan <strong data-start="688" data-end="701">ogoh-ogoh</strong>, kostum kreasi bercahaya, hingga parade budaya yang memukau mata penonton. Lampu LED warna-warni dan musik modern dipadukan dengan seni tradisional, menciptakan suasana meriah sekaligus penuh makna kebangsaan.</p>\r\n<p style="text-align: justify;" data-start="915" data-end="1121">Bupati Karanganyar dalam sambutannya mengatakan bahwa <strong data-start="969" data-end="999">Karanganyar Night Carnival</strong> bukan hanya hiburan, melainkan juga wadah ekspresi kreatif generasi muda serta bentuk kebanggaan terhadap budaya lokal.</p>\r\n<blockquote data-start="1122" data-end="1306">\r\n<p data-start="1124" data-end="1306"><em data-start="1124" data-end="1295">&ldquo;Acara ini bukti bahwa masyarakat Karanganyar mampu menjaga tradisi sekaligus berinovasi. Semangat HUT RI ke-80 harus kita rayakan dengan gembira dan penuh kebersamaan,&rdquo;</em> ujarnya.</p>\r\n</blockquote>\r\n<p style="text-align: justify;" data-start="1308" data-end="1562">Tidak hanya warga lokal, banyak wisatawan dari luar kota yang sengaja datang untuk menyaksikan karnaval unik ini. Media sosial pun ramai dengan unggahan foto dan video parade, menjadikan #KaranganyarNightCarnival sempat trending di wilayah Jawa Tengah.</p>\r\n<p style="text-align: justify;" data-start="1564" data-end="1803">Acara ditutup dengan pesta kembang api yang menghiasi langit malam Karanganyar, menambah semarak perayaan kemerdekaan. Warga berharap kegiatan serupa bisa menjadi agenda tahunan dan ikon wisata budaya malam hari di Kabupaten Karanganyar.</p>\r\n<div id="ag-1755890471572"></div>', '1755891581_ff12922e9bba85c6a3de.jpg', 1, '2025-08-22 19:17:23', '2025-08-22 19:39:41')
ON DUPLICATE KEY UPDATE `slug`=VALUES(`slug`), `judul`=VALUES(`judul`);

-- Dumping structure for table pdpmkara_db.galeri
CREATE TABLE IF NOT EXISTS `galeri` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `tipe` enum('foto','video') NOT NULL DEFAULT 'foto',
  `id_penulis` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galeri_id_penulis_foreign` (`id_penulis`),
  CONSTRAINT `galeri_id_penulis_foreign` FOREIGN KEY (`id_penulis`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.galeri
INSERT INTO `galeri` (`id`, `judul`, `deskripsi`, `kategori`, `file_path`, `tipe`, `id_penulis`, `created_at`) VALUES
	(3, 'Pelantikan PDPM Kabupaten Karanganyar Periode 2024-2025', NULL, 'lainnya', '1755878018_5a9f9050b673aaecda10.jpg', 'foto', 1, '2025-08-22 15:53:38'),
	(4, 'Pelantikan PDPM Kabupaten Karanganyar Periode 2024-2025', NULL, 'lainnya', '1755878040_2fe3c2b0b86443fac72f.jpg', 'foto', 1, '2025-08-22 15:54:00'),
	(5, 'Pelantikan PCPM Jatiyoso Periode Muktamar 18', NULL, 'lainnya', '1755878405_04dda03de04b5f49eb5d.jpeg', 'foto', 1, '2025-08-22 16:00:05')
ON DUPLICATE KEY UPDATE `judul`=VALUES(`judul`);

-- Dumping structure for table pdpmkara_db.struktur_cabang
CREATE TABLE IF NOT EXISTS `struktur_cabang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cabang` int(11) unsigned NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan_tampil` int(11) NOT NULL DEFAULT 0,
  `status` enum('aktif','tidak_aktif') NOT NULL DEFAULT 'aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cabang` (`id_cabang`),
  CONSTRAINT `struktur_cabang_id_cabang_foreign` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table pdpmkara_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.migrations
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2025-08-14-000001', 'App\\Database\\Migrations\\CreateRolesTable', 'default', 'App', 1755532343, 1),
	(2, '2025-08-14-000002', 'App\\Database\\Migrations\\CreateCabangTable', 'default', 'App', 1755532343, 1),
	(3, '2025-08-14-000003', 'App\\Database\\Migrations\\CreateRantingTable', 'default', 'App', 1755532343, 1),
	(4, '2025-08-14-000004', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1755532343, 1),
	(5, '2025-08-14-000005', 'App\\Database\\Migrations\\AddNoHpToUsersTable', 'default', 'App', 1755532343, 1),
	(6, '2025-08-14-000006', 'App\\Database\\Migrations\\AddAllProfileFieldsToUsers', 'default', 'App', 1755532343, 1),
	(7, '2025-08-14-000007', 'App\\Database\\Migrations\\CreateBeritaTable', 'default', 'App', 1755532343, 1),
	(8, '2025-08-14-000008', 'App\\Database\\Migrations\\CreateAgendaTable', 'default', 'App', 1755532343, 1),
	(9, '2025-08-14-000009', 'App\\Database\\Migrations\\CreateGaleriTable', 'default', 'App', 1755532343, 1),
	(10, '2025-08-14-000010', 'App\\Database\\Migrations\\AddDeskripsiToGaleriTable', 'default', 'App', 1755532343, 1),
	(11, '2025-08-14-000011', 'App\\Database\\Migrations\\AddKategoriToGaleriTable', 'default', 'App', 1755532343, 1),
	(12, '2025-08-14-000011', 'App\\Database\\Migrations\\AddNbmToUsersTable', 'default', 'App', 1755532343, 1),
	(13, '2025-08-18-180733', 'App\\Database\\Migrations\\AddNewColumnsToUsersTable', 'default', 'App', 1755540467, 2),
	(15, '2025-08-18-181905', 'App\\Database\\Migrations\\AddTanggalLahirToUsersTable', 'default', 'App', 1755542193, 3),
	(16, '2025-08-24-140352', 'App\\Database\\Migrations\\AddAlamatRumahToUsers', 'default', 'App', 1756045053, 4),
	(17, '2025-08-24-142818', 'App\\Database\\Migrations\\UpdateAgendaAddGpsFields', 'default', 'App', 1756154666, 5),
	(18, '2025-08-24-142835', 'App\\Database\\Migrations\\CreateAgendaPesertaTable', 'default', 'App', 1756154666, 5),
	(19, '2025-08-24-142850', 'App\\Database\\Migrations\\CreateAbsensiKegiatanTable', 'default', 'App', 1756154666, 5),
	(20, '2025-08-24-182636', 'App\\Database\\Migrations\\CreateCabangProfileTable', 'default', 'App', 1756154666, 5),
	(21, '2025-08-24-182715', 'App\\Database\\Migrations\\CreateStrukturCabangTable', 'default', 'App', 1756154666, 5),
	(22, '2025-08-24-182735', 'App\\Database\\Migrations\\UpdateAgendaAddCabangFields', 'default', 'App', 1756154666, 5),
	(23, '2025-08-25-000001', 'App\\Database\\Migrations\\RefactorCabangSchema', 'default', 'App', 1756154666, 5),
	(24, '2025-08-25-214052', 'App\\Database\\Migrations\\CreateUserPointsTable', 'default', 'App', 1756158083, 6),
	(25, '2025-01-27-000001', 'App\\Database\\Migrations\\CreateVotingTable', 'default', 'App', 1756879110, 7),
	(26, '2025-01-27-000002', 'App\\Database\\Migrations\\CreateVotingOptionsTable', 'default', 'App', 1756879110, 7),
	(27, '2025-01-27-000003', 'App\\Database\\Migrations\\CreateVotingVotesTable', 'default', 'App', 1756879110, 7),
	(28, '2025-01-27-000004', 'App\\Database\\Migrations\\AddPhotoToVotingOptions', 'default', 'App', 1756879968, 8),
	(29, '2025-01-27-000005', 'App\\Database\\Migrations\\ModifyVotingForFormatur', 'default', 'App', 1756879968, 8)
ON DUPLICATE KEY UPDATE `version`=VALUES(`version`);

-- Dumping structure for table pdpmkara_db.user_points
CREATE TABLE IF NOT EXISTS `user_points` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `poin` int(11) NOT NULL DEFAULT 0,
  `aktivitas` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `referensi_id` int(11) DEFAULT NULL,
  `referensi_tipe` varchar(50) DEFAULT NULL,
  `tanggal_dapat` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `tanggal_dapat` (`tanggal_dapat`),
  CONSTRAINT `user_points_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping structure for table pdpmkara_db.voting
CREATE TABLE IF NOT EXISTS `voting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('draft','aktif','selesai','dibatalkan') NOT NULL DEFAULT 'draft',
  `tanggal_mulai` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `id_creator` int(11) unsigned NOT NULL,
  `allow_multiple_choice` tinyint(1) DEFAULT 1,
  `required_selections` int(11) unsigned DEFAULT 9 COMMENT 'Number of formatur that must be selected (default 9)',
  `min_candidates` int(11) unsigned DEFAULT 9 COMMENT 'Minimum number of candidates required (default 9)',
  `show_results_before_end` tinyint(1) NOT NULL DEFAULT 0,
  `min_participants` int(11) unsigned NOT NULL DEFAULT 1,
  `total_voters` int(11) unsigned NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `voting_id_creator_foreign` (`id_creator`),
  CONSTRAINT `voting_id_creator_foreign` FOREIGN KEY (`id_creator`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.voting
INSERT INTO `voting` (`id`, `judul`, `deskripsi`, `status`, `tanggal_mulai`, `tanggal_selesai`, `id_creator`, `allow_multiple_choice`, `required_selections`, `min_candidates`, `show_results_before_end`, `min_participants`, `total_voters`, `created_at`, `updated_at`) VALUES
	(6, 'Pemilihan Formatur PDPM Karanganyar 2025', 'Pemilihan formatur untuk periode 2025-2027. Setiap anggota dapat memilih 9 formatur dari daftar kandidat yang tersedia.', 'dibatalkan', '2025-09-04 13:25:10', '2025-09-10 13:25:10', 1, 1, 9, 9, 1, 1, 0, '2025-09-03 13:25:10', '2025-09-03 14:48:55'),
	(8, 'WALID', 'asdqawdadas', 'selesai', '2025-09-03 14:49:00', '2025-09-04 14:49:00', 1, 1, 9, 9, 0, 1, 0, '2025-09-03 14:50:23', '2025-09-04 18:56:34')
ON DUPLICATE KEY UPDATE `judul`=VALUES(`judul`);

-- Dumping structure for table pdpmkara_db.voting_options
CREATE TABLE IF NOT EXISTS `voting_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_voting` int(11) unsigned NOT NULL,
  `nama_pilihan` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan` int(11) unsigned NOT NULL DEFAULT 1,
  `total_votes` int(11) unsigned NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `voting_options_id_voting_foreign` (`id_voting`),
  CONSTRAINT `voting_options_id_voting_foreign` FOREIGN KEY (`id_voting`) REFERENCES `voting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pdpmkara_db.voting_options
INSERT INTO `voting_options` (`id`, `id_voting`, `nama_pilihan`, `deskripsi`, `foto`, `urutan`, `total_votes`, `created_at`, `updated_at`) VALUES
	(64, 6, 'Ahmad Rizki Pratama', 'Ketua Umum periode sebelumnya, berpengalaman dalam organisasi', NULL, 1, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(65, 6, 'Siti Nurhaliza', 'Sekretaris Umum, aktif dalam kegiatan sosial', NULL, 2, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(66, 6, 'Budi Santoso', 'Bendahara, memiliki latar belakang keuangan', NULL, 3, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(67, 6, 'Dewi Kartika', 'Koordinator Bidang Pendidikan', NULL, 4, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(68, 6, 'Eko Prasetyo', 'Koordinator Bidang Olahraga', NULL, 5, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(69, 6, 'Fina Rahayu', 'Koordinator Bidang Kesehatan', NULL, 6, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(70, 6, 'Guntur Wijaya', 'Koordinator Bidang Ekonomi', NULL, 7, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(71, 6, 'Hesti Lestari', 'Koordinator Bidang Sosial', NULL, 8, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(72, 6, 'Indra Kurniawan', 'Koordinator Bidang Teknologi', NULL, 9, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(73, 6, 'Jihan Maharani', 'Koordinator Bidang Lingkungan', NULL, 10, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(74, 6, 'Kurniawan Adi', 'Koordinator Bidang Pemuda', NULL, 11, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(75, 6, 'Lina Sari', 'Koordinator Bidang Perempuan', NULL, 12, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(76, 6, 'Muhammad Fajar', 'Koordinator Bidang Dakwah', NULL, 13, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(77, 6, 'Nina Wulandari', 'Koordinator Bidang Kreatif', NULL, 14, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(78, 6, 'Oscar Pratama', 'Koordinator Bidang Media', NULL, 15, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(79, 6, 'Putri Anggraini', 'Koordinator Bidang Seni', NULL, 16, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(80, 6, 'Qori Sandria', 'Koordinator Bidang Budaya', NULL, 17, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(81, 6, 'Rizki Ramadhan', 'Koordinator Bidang Rohani', NULL, 18, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(82, 6, 'Sari Indah', 'Koordinator Bidang Kesejahteraan', NULL, 19, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(83, 6, 'Taufik Hidayat', 'Koordinator Bidang Hubungan Masyarakat', NULL, 20, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(84, 6, 'Umi Kalsum', 'Koordinator Bidang Pengembangan SDM', NULL, 21, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(85, 6, 'Vina Sari', 'Koordinator Bidang Riset dan Pengembangan', NULL, 22, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(86, 6, 'Wahyu Nugroho', 'Koordinator Bidang Logistik', NULL, 23, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(87, 6, 'Xena Putri', 'Koordinator Bidang Dokumentasi', NULL, 24, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(88, 6, 'Yoga Pratama', 'Koordinator Bidang Evaluasi', NULL, 25, 0, '2025-09-03 13:25:10', '2025-09-03 13:25:10'),
	(98, 8, 'SUPRI IHIY', NULL, NULL, 1, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(99, 8, 'SUPRI IHIYasa', NULL, NULL, 2, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(100, 8, 'SUPRI IHIYsadad', NULL, NULL, 3, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(101, 8, 'SUPRI IHIYasdaa', NULL, NULL, 4, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(102, 8, 'SUPRI IHIYsadawad', NULL, NULL, 5, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(103, 8, 'SUPRI IHIYsadawad', NULL, NULL, 6, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(104, 8, 'sadawdawa', NULL, NULL, 7, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(105, 8, 'SUPRI IHIYsasda', NULL, NULL, 8, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(106, 8, 'SUPRI IHIYsadaw', NULL, NULL, 9, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23'),
	(107, 8, 'vaSUPRI IHIY', NULL, NULL, 10, 0, '2025-09-03 14:50:23', '2025-09-03 14:50:23')
ON DUPLICATE KEY UPDATE `nama_pilihan`=VALUES(`nama_pilihan`);

-- Dumping structure for table pdpmkara_db.voting_votes
CREATE TABLE IF NOT EXISTS `voting_votes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_voting` int(11) unsigned NOT NULL,
  `id_voting_option` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_voting_id_voting_option_id_user` (`id_voting`,`id_voting_option`,`id_user`),
  KEY `voting_votes_id_voting_option_foreign` (`id_voting_option`),
  KEY `voting_votes_id_user_foreign` (`id_user`),
  CONSTRAINT `voting_votes_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `voting_votes_id_voting_foreign` FOREIGN KEY (`id_voting`) REFERENCES `voting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `voting_votes_id_voting_option_foreign` FOREIGN KEY (`id_voting_option`) REFERENCES `voting_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

-- End of dump
