-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 03:26 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sialum`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pengguna` int(10) UNSIGNED DEFAULT NULL,
  `id_jabatan` int(10) UNSIGNED DEFAULT NULL,
  `id_pangkat_golongan` int(10) UNSIGNED DEFAULT NULL,
  `id_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `id_jurusan_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `nip` varchar(18) NOT NULL,
  `nama_guru` varchar(128) NOT NULL,
  `jk` enum('l','p') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tmp_lahir` varchar(64) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `tahun_ijazah` year(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`id`, `id_pengguna`, `id_jabatan`, `id_pangkat_golongan`, `id_pendidikan`, `id_jurusan_pendidikan`, `nip`, `nama_guru`, `jk`, `alamat`, `tmp_lahir`, `tgl_lahir`, `tahun_ijazah`, `created_at`, `updated_at`) VALUES
(1, 25, 1, 1, 9, 4, '196506121990022003', 'Sukarti', 'p', 'Palembang', 'Palembang', '2024-05-01', 2009, '2024-05-23 08:29:39', '2024-06-24 18:29:06'),
(4, NULL, 5, 9, 9, 4, '199204202015031006', 'Della Rizky Andini', 'l', 'Plaju', 'Palembang', '2024-05-06', 2014, '2024-05-25 17:52:18', '2024-06-24 12:14:30'),
(5, NULL, 5, 9, 9, 4, '198912252019022005', 'Sudaryani', 'p', 'Plaju', 'Prabumulih', '2020-04-30', 2011, '2024-05-25 17:53:27', '2024-06-24 12:11:48'),
(6, NULL, 5, 9, 9, 4, '1988103020201901', 'Sulastinah', 'p', 'Plaju', 'Prabumulih', '2024-05-05', 2010, '2024-05-26 09:59:45', '2024-06-24 12:11:48'),
(7, NULL, 4, 5, 10, 14, '1234567890123456', 'Abdul Kadir, M.Kom.', 'l', 'Depok', 'Depok', '2024-04-30', 2010, '2024-06-10 15:46:11', '2025-05-13 08:18:38'),
(8, NULL, 5, 5, 9, 33, '9999999999888777', 'Nur Widyasti', 'p', 'Palembang', 'Palembang', '2024-03-31', 2010, '2024-06-10 18:02:33', '2024-06-24 12:14:30'),
(9, NULL, 5, 4, 9, 34, '1979762520140320', 'Susmayasari', 'p', 'Palembang', 'Palembang', '2024-05-26', 2014, '2024-06-10 19:01:29', '2024-06-24 12:14:30'),
(10, NULL, 5, 4, 9, 4, '1989986520190220', 'Nunsianah', 'p', 'Plaju', 'Palembang', '2024-05-26', 2010, '2024-06-10 19:02:12', '2024-06-24 12:46:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_informasi`
--

CREATE TABLE `tbl_informasi` (
  `id_informasi` int(10) UNSIGNED NOT NULL,
  `judul_informasi` varchar(128) NOT NULL,
  `isi_informasi` varchar(5000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_informasi`
--

INSERT INTO `tbl_informasi` (`id_informasi`, `judul_informasi`, `isi_informasi`, `created_at`, `updated_at`) VALUES
(2, 'Promo Diskon untuk Barang VXYZ', 'Kabar gembira bagi sobat Auto 2000 karena di tanggal 5 Mei ini akan ada banyak diskon untuk beberapa barang tertentu. Untuk list barang yang diskon bisa dicek di bawah, ya, sobat!\r\n1. Barang V\r\n2. Barang X\r\n3. Barang Y\r\n4. Barang Z', '2025-05-04 11:16:36', '2025-05-04 11:20:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jabatan`
--

CREATE TABLE `tbl_jabatan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jabatan`
--

INSERT INTO `tbl_jabatan` (`id`, `nama_jabatan`, `created_at`, `updated_at`) VALUES
(1, 'Kepala Sekolah', '2024-05-20 12:45:34', NULL),
(2, 'Wakil Kepala Sekolah', '2024-05-20 12:45:34', NULL),
(3, 'Bendahara', '2024-05-20 12:45:34', NULL),
(4, 'Tata Usaha/Administrasi', '2024-05-20 12:45:34', NULL),
(5, 'Wali Kelas', '2024-05-20 12:45:34', NULL),
(6, 'Piket', '2024-05-20 12:45:34', NULL),
(7, 'Bimbingan Konseling', '2024-05-20 12:45:34', NULL),
(8, 'Penjaga Sekolah', '2024-05-20 12:45:34', NULL),
(9, 'Kebersihan', '2024-05-20 12:45:34', '2024-05-20 12:53:45'),
(10, 'Tenaga Administrasi Sekolah', '2024-05-20 12:45:34', NULL),
(11, 'Perpustakaan', '2024-05-20 12:45:34', NULL),
(12, 'Operator', '2024-05-20 12:45:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan_pendidikan`
--

CREATE TABLE `tbl_jurusan_pendidikan` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_pendidikan` int(10) UNSIGNED DEFAULT NULL,
  `nama_jurusan` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_jurusan_pendidikan`
--

INSERT INTO `tbl_jurusan_pendidikan` (`id`, `id_pendidikan`, `nama_jurusan`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Tidak Ada', '2024-05-11 19:22:50', NULL),
(2, 4, 'IPA', '2024-05-11 19:22:50', '2024-05-13 14:09:23'),
(3, 4, 'IPS', '2024-05-11 19:22:50', '2024-05-13 14:09:34'),
(4, 9, 'Sistem Informasi', '2024-05-11 19:22:50', '2024-05-13 14:09:58'),
(5, 9, 'Psikologi', '2024-05-11 19:22:50', '2024-05-13 14:10:04'),
(8, 4, 'Lainnya', '2024-05-13 14:13:00', NULL),
(9, 5, 'Lainnya', '2024-05-13 14:13:01', NULL),
(10, 6, 'Lainnya', '2024-05-13 14:13:01', NULL),
(11, 7, 'Lainnya', '2024-05-13 14:13:01', NULL),
(12, 8, 'Lainnya', '2024-05-13 14:13:01', NULL),
(13, 9, 'Lainnya', '2024-05-13 14:13:01', NULL),
(14, 10, 'Lainnya', '2024-05-13 14:13:01', NULL),
(15, 11, 'Lainnya', '2024-05-13 14:13:01', NULL),
(16, 9, 'Teknik Elektro', '2024-05-13 16:37:09', NULL),
(28, 8, 'Some \\&quot;\'  string &amp;amp; to Sanitize &amp;lt; !$@%', '2024-05-13 18:05:45', '2024-05-13 18:12:16'),
(29, 9, 'Pendidikan Agama Islam', '2024-05-17 05:11:41', NULL),
(30, 9, 'Hukum', '2024-05-19 18:35:55', NULL),
(32, 9, 'Psikologi', '2024-05-23 04:32:24', NULL),
(33, 9, 'Bahasa Indonesia', '2024-05-23 10:55:19', NULL),
(34, 9, 'Fisika', '2024-05-23 16:27:45', NULL),
(35, 9, 'Matematika', '2024-05-25 17:35:34', NULL),
(36, 9, 'Geografi', '2024-05-26 09:59:36', NULL),
(37, 10, 'Sistem Informasi', '2024-06-10 15:56:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_wali_kelas` int(10) UNSIGNED DEFAULT NULL,
  `nama_kelas` varchar(128) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`id`, `id_wali_kelas`, `nama_kelas`, `created_at`, `updated_at`) VALUES
(1, 4, 'X - Perhotelan', '2025-05-13 13:14:02', NULL),
(2, 4, 'XI - Perhotelan', '2025-05-13 13:14:02', NULL),
(3, 4, 'XII - Perhotelan', '2025-05-13 13:14:02', NULL),
(4, 4, 'X - Akuntansi', '2025-05-13 13:14:02', NULL),
(5, 4, 'XI - Akuntansi', '2025-05-13 13:14:02', NULL),
(6, 4, 'XII - Akuntansi', '2025-05-13 13:14:02', NULL),
(7, 4, 'X - Teknik Komputer dan Jaringan', '2025-05-13 13:14:02', NULL),
(8, 4, 'XI - Teknik Komputer dan Jaringan', '2025-05-13 13:14:02', NULL),
(9, 4, 'XII - Teknik Komputer dan Jaringan', '2025-05-13 13:14:02', NULL),
(10, 4, 'X - Administrasi Perkantoran', '2025-05-13 13:14:02', NULL),
(11, 4, 'XI - Administrasi Perkantoran', '2025-05-13 13:14:02', NULL),
(12, 4, 'XII - Administrasi Perkantoran', '2025-05-13 13:14:02', NULL),
(13, 4, 'X - Teknik Mesin', '2025-05-13 13:14:02', NULL),
(14, 4, 'XI - Teknik Mesin', '2025-05-13 13:14:02', NULL),
(15, 4, 'XII - Teknik Mesin', '2025-05-13 13:14:02', NULL),
(16, 4, 'X - Teknik Kendaraan Ringan', '2025-05-13 13:14:02', NULL),
(17, 4, 'XI - Teknik Kendaraan Ringan', '2025-05-13 13:14:02', NULL),
(18, 4, 'XII - Teknik Kendaraan Ringan', '2025-05-13 13:14:02', NULL),
(19, 4, 'X - Teknik Elektro', '2025-05-13 13:14:02', NULL),
(20, 4, 'XI - Teknik Elektro', '2025-05-13 13:14:02', NULL),
(21, 4, 'XII - Teknik Elektro', '2025-05-13 13:14:02', NULL),
(22, 4, 'X - Tataboga', '2025-05-13 13:14:02', NULL),
(23, 4, 'XI - Tataboga', '2025-05-13 13:14:02', NULL),
(24, 4, 'XII - Tataboga', '2025-05-13 13:14:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kompetensi_siswa`
--

CREATE TABLE `tbl_kompetensi_siswa` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_siswa` int(10) UNSIGNED NOT NULL,
  `nama_kompetensi` varchar(128) NOT NULL,
  `file_kompetensi` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kompetensi_siswa`
--

INSERT INTO `tbl_kompetensi_siswa` (`id`, `id_siswa`, `nama_kompetensi`, `file_kompetensi`, `created_at`, `updated_at`) VALUES
(5, 1, 'Problem Solving', '961a51ca2ba7a323ae29ea897441e86d7d2e4488494d5590572f1e05df8f52bc.pdf', '2024-06-24 19:39:28', NULL),
(6, 3, 'CCNA', 'fc31ae21393b48613f0e01f9769188a310b4e27bd1bb8d2e132347e7892aa9dc.pdf', '2024-06-24 19:57:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pangkat_golongan`
--

CREATE TABLE `tbl_pangkat_golongan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_pangkat_golongan` varchar(128) NOT NULL,
  `tipe` enum('pns','pppk','gtt','honor') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pangkat_golongan`
--

INSERT INTO `tbl_pangkat_golongan` (`id`, `nama_pangkat_golongan`, `tipe`, `created_at`, `updated_at`) VALUES
(1, 'Golongan Ia (Juru Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(2, 'Golongan Ib (Juru Muda Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(3, 'Golongan Ic (Juru)', 'pns', '2024-05-15 17:21:54', NULL),
(4, 'Golongan Id (Juru Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(5, 'Golongan IIa (Pengatur muda)', 'pns', '2024-05-15 17:21:54', NULL),
(6, 'Golongan IIb (Pengatur Muda Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(7, 'Golongan IIc (Pengatur)', 'pns', '2024-05-15 17:21:54', NULL),
(8, 'Golongan IId (Pengatur tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(9, 'Golongan IIIa (Penata Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(10, 'Golongan IIIb (Penata Muda Tingkat 1)', 'pns', '2024-05-15 17:21:54', NULL),
(11, 'Golongan IIIc (Penata)', 'pns', '2024-05-15 17:21:54', NULL),
(12, 'Golongan IIId (Penata Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(13, 'Golongan IVa (Pembina)', 'pns', '2024-05-15 17:21:54', NULL),
(14, 'Golongan IVb (Pembina Tingkat I)', 'pns', '2024-05-15 17:21:54', NULL),
(15, 'Golongan IVc (Pembina Muda)', 'pns', '2024-05-15 17:21:54', NULL),
(16, 'Golongan IVd (Pembina Madya)', 'pns', '2024-05-15 17:21:54', NULL),
(17, 'Golongan IVe (Pembina Utama)', 'pns', '2024-05-15 17:21:54', NULL),
(18, 'Tidak ada', NULL, '2024-05-15 18:23:14', '2024-05-20 11:50:30'),
(19, 'PPPK', 'pppk', '2024-05-20 11:36:07', NULL),
(20, 'GTT', 'gtt', '2024-05-20 11:36:07', NULL),
(21, 'Honor', 'honor', '2024-05-20 11:49:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pekerjaan_alumni`
--

CREATE TABLE `tbl_pekerjaan_alumni` (
  `id_pekerjaan_alumni` int(10) UNSIGNED NOT NULL,
  `id_alumni` int(10) UNSIGNED DEFAULT NULL,
  `nama_perusahaan` varchar(128) NOT NULL,
  `jabatan` varchar(128) NOT NULL,
  `status_pekerjaan` enum('masih_bekerja','resign','magang','') NOT NULL,
  `deskripsi_pekerjaan` varchar(1000) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date DEFAULT NULL,
  `alamat_simpel` varchar(255) NOT NULL,
  `alamat_perusahaan_provinsi` varchar(255) NOT NULL,
  `alamat_perusahaan_kab_kota` varchar(255) NOT NULL,
  `alamat_perusahaan_kecamatan` varchar(255) NOT NULL,
  `alamat_perusahaan_kelurahan` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pekerjaan_alumni`
--

INSERT INTO `tbl_pekerjaan_alumni` (`id_pekerjaan_alumni`, `id_alumni`, `nama_perusahaan`, `jabatan`, `status_pekerjaan`, `deskripsi_pekerjaan`, `tanggal_masuk`, `tanggal_keluar`, `alamat_simpel`, `alamat_perusahaan_provinsi`, `alamat_perusahaan_kab_kota`, `alamat_perusahaan_kecamatan`, `alamat_perusahaan_kelurahan`, `created_at`, `updated_at`) VALUES
(1, 1, 'PT Bukit Asam Tbk.', 'Teknologi Informasi', 'masih_bekerja', 'analisis, merancang, develop, dan maintenance software perusahaan', '2025-08-01', '0000-00-00', 'Muara Enim', '16', '1603', '1603050', '1603050001', '2025-05-12 11:08:41', '2025-05-12 12:59:20'),
(3, 3, 'Shopee Indonesia', 'Gudang', 'masih_bekerja', 'Pergudangan', '2020-01-01', '0000-00-00', 'Tanjung Api-Api', '16', '1671', '1671041', '1671041002', '2025-05-12 12:33:53', '2025-05-12 13:02:50'),
(4, 4, 'PT Bank ', 'IT Support', 'masih_bekerja', 'IT Support', '2020-01-01', '0000-00-00', 'Ilir', '16', '1671', '1671041', '1671041002', '2025-05-12 14:00:00', NULL),
(5, 6, 'Samsung', 'Sales', 'masih_bekerja', 'Sales HP', '2019-01-01', '0000-00-00', 'Jakarta Selatan', '31', '3171', '3171090', '3171090007', '2025-05-12 14:05:07', NULL),
(6, 1, 'Universitas Siguntang Mahaputra', 'Web Developer', 'masih_bekerja', 'analisis, merancang, develop, dan maintenance web software', '2018-01-01', '0000-00-00', 'Jln. Perintis Kemerdekaan', '16', '1671', '1671060', '1671060005', '2025-05-13 02:49:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendidikan`
--

CREATE TABLE `tbl_pendidikan` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama_pendidikan` varchar(16) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pendidikan`
--

INSERT INTO `tbl_pendidikan` (`id`, `nama_pendidikan`, `created_at`, `updated_at`) VALUES
(1, 'tidak_sekolah', '2024-05-11 19:21:02', '2024-05-13 16:25:34'),
(2, 'SD', '2024-05-11 19:21:03', NULL),
(3, 'SMP', '2024-05-11 19:21:03', NULL),
(4, 'SLTA', '2024-05-11 19:21:03', NULL),
(5, 'DI', '2024-05-11 19:21:03', NULL),
(6, 'DII', '2024-05-11 19:21:03', NULL),
(7, 'DIII', '2024-05-11 19:21:03', NULL),
(8, 'DIV', '2024-05-11 19:21:03', NULL),
(9, 'S1', '2024-05-11 19:21:03', NULL),
(10, 'S2', '2024-05-11 19:21:03', NULL),
(11, 'S3', '2024-05-11 19:21:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `hak_akses` enum('admin','guru','kepala_sekolah','siswa') NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `username`, `password`, `hak_akses`, `created_at`, `last_login`) VALUES
(9, 'admin', '$2y$10$VSwsaud3aHkzE3VzMfuGCO9YizH7A7wVnx7Xfi9kUDiJdhDY53Msy', 'admin', '2024-06-10 14:42:24', '2025-05-13 03:14:22'),
(23, '', '$2y$10$0lhFQXTfT8wjZ9YmmNVWruV36NLEeFoLKEbrwWaMfjHv3gtOb2H4C', 'siswa', '2024-06-24 18:13:00', '2025-05-12 21:43:38'),
(24, 'bimasatria', '$2y$10$PJ0tlPZHqurX0xzM2NA.XO3AXBpKr6oPbWI6m2u2V8haaDMfpk2J.', 'siswa', '2024-06-24 18:17:17', NULL),
(25, '196506121990022003', '$2y$10$r6i9ouw57cTTevcboVpfxuaaeGE.LqvH0ivtFunGnpjhus3jtxu1q', 'kepala_sekolah', '2024-06-24 18:29:06', NULL),
(26, 'arief9', '$2y$10$1qEKVqVhwdpIFnx8f6BHCO5eYf1ourNTIEDqyGbU/Vxswa5ge5t2e', 'siswa', '2025-05-13 08:13:20', NULL),
(27, 'test', '$2y$10$UB9Eld6.H9TJzQOVPT1o3O6P1e2/CSz5DiG3.E6tTl91Y9xP3RyL.', 'siswa', '2025-05-13 08:13:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengumuman_seleksi`
--

CREATE TABLE `tbl_pengumuman_seleksi` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_penilaian_seleksi` int(10) UNSIGNED DEFAULT NULL,
  `keterangan_seleksi` enum('lolos','tidak_lolos') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_pengumuman_seleksi`
--

INSERT INTO `tbl_pengumuman_seleksi` (`id`, `id_penilaian_seleksi`, `keterangan_seleksi`, `created_at`, `updated_at`) VALUES
(2, 3, 'tidak_lolos', '2024-06-24 18:01:06', NULL),
(3, 1, 'lolos', '2024-06-24 18:01:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penilaian_seleksi`
--

CREATE TABLE `tbl_penilaian_seleksi` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_tahun_penilaian` int(10) UNSIGNED DEFAULT NULL,
  `id_siswa` int(10) UNSIGNED NOT NULL,
  `id_prestasi_siswa` int(10) UNSIGNED DEFAULT NULL,
  `id_kompetensi_siswa` int(10) UNSIGNED DEFAULT NULL,
  `nilai_kompetensi` decimal(4,2) NOT NULL,
  `nilai_prestasi` decimal(4,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_penilaian_seleksi`
--

INSERT INTO `tbl_penilaian_seleksi` (`id`, `id_tahun_penilaian`, `id_siswa`, `id_prestasi_siswa`, `id_kompetensi_siswa`, `nilai_kompetensi`, `nilai_prestasi`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, NULL, '89.00', '89.00', '2024-06-24 15:36:46', '2024-06-24 17:15:52'),
(4, 4, 3, NULL, NULL, '78.00', '78.00', '2024-06-24 18:02:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prestasi_siswa`
--

CREATE TABLE `tbl_prestasi_siswa` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_siswa` int(10) UNSIGNED NOT NULL,
  `nama_prestasi` varchar(128) NOT NULL,
  `file_prestasi` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_prestasi_siswa`
--

INSERT INTO `tbl_prestasi_siswa` (`id`, `id_siswa`, `nama_prestasi`, `file_prestasi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Juara II GEMASTIK Competitive Programming 2019', 'b9fb7507212ec7b29585f9c1bb021e48ec4e98ea532edb9dabccac3fe1190436.pdf', '2024-06-24 14:44:19', '2024-06-24 17:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pengguna` int(10) UNSIGNED DEFAULT NULL,
  `id_kelas` int(10) UNSIGNED DEFAULT NULL,
  `nisn` varchar(10) NOT NULL,
  `nama_siswa` varchar(128) NOT NULL,
  `jk` enum('l','p') NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tmp_lahir` varchar(64) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `no_telp` varchar(16) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `tahun_lulus` smallint(5) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id`, `id_pengguna`, `id_kelas`, `nisn`, `nama_siswa`, `jk`, `alamat`, `tmp_lahir`, `tgl_lahir`, `no_telp`, `email`, `tahun_lulus`, `created_at`, `updated_at`) VALUES
(1, 23, 9, '9991814928', 'Okta Alfiansyah', 'l', 'Kertapati', 'Palembang', '1999-10-10', '6262620877990550', 'oktaalfiansyah@gmail.com', NULL, '2025-05-13 13:24:56', '2025-05-13 13:24:56'),
(3, 24, 9, '9991814872', 'Bima Satria', 'l', 'Gang Duren', 'Palembang', '2024-05-08', '087765432345', 'bimasatria@gmail.com', NULL, '2025-05-13 13:24:56', '2025-05-13 13:24:56'),
(4, 26, 9, '9997672534', 'Arief Rahman', 'l', 'Jakabaring', 'Palembang', '2024-05-27', '087700111100', 'ariefrahman@gmail.com', NULL, '2025-05-13 13:24:56', '2025-05-13 13:24:56'),
(5, NULL, 9, '9987652345', 'Benny Setiawan', 'l', 'Palembang', 'Palembang', '1998-05-01', '6262620819920019', 'bennysetiawan@gmail.com', NULL, '2025-05-13 13:24:56', '2025-05-13 13:24:56'),
(6, NULL, 3, '1278567890', 'Nelam Salmah', 'p', 'Palembang', 'Palembang', '1999-06-12', '6262620878652345', 'nelamsalmah@gmail.com', NULL, '2025-05-13 13:25:56', '2025-05-13 13:25:56'),
(7, 27, 3, '0000000007', 'hsisasdasdasdahe', 'l', 'kertapati', 'Palembang', '2025-05-13', '6262620811764523', 'testsiswa@gmail.com', NULL, '2025-05-13 13:16:50', '2025-05-13 13:16:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tahun_penilaian`
--

CREATE TABLE `tbl_tahun_penilaian` (
  `id` int(10) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tahun_penilaian`
--

INSERT INTO `tbl_tahun_penilaian` (`id`, `tahun`, `created_at`, `updated_at`) VALUES
(1, 2021, '2024-05-28 05:11:49', '2024-06-13 15:21:31'),
(2, 2022, '2024-05-28 04:52:33', '2024-06-13 15:21:28'),
(3, 2023, '2024-05-28 04:54:00', '2024-06-13 15:21:23'),
(4, 2024, '2024-06-24 17:13:17', '2024-06-24 17:15:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_jurusan_pendidikan` (`id_jurusan_pendidikan`),
  ADD KEY `id_pangkat_golongan` (`id_pangkat_golongan`),
  ADD KEY `id_pendidikan` (`id_pendidikan`),
  ADD KEY `id_jabatan` (`id_jabatan`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tbl_informasi`
--
ALTER TABLE `tbl_informasi`
  ADD PRIMARY KEY (`id_informasi`);

--
-- Indexes for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pendidikan` (`id_pendidikan`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_wali_kelas` (`id_wali_kelas`);

--
-- Indexes for table `tbl_kompetensi_siswa`
--
ALTER TABLE `tbl_kompetensi_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tbl_pangkat_golongan`
--
ALTER TABLE `tbl_pangkat_golongan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pekerjaan_alumni`
--
ALTER TABLE `tbl_pekerjaan_alumni`
  ADD PRIMARY KEY (`id_pekerjaan_alumni`),
  ADD KEY `id_alumni` (`id_alumni`);

--
-- Indexes for table `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_pengumuman_seleksi`
--
ALTER TABLE `tbl_pengumuman_seleksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tahun_akademik` (`id_penilaian_seleksi`);

--
-- Indexes for table `tbl_penilaian_seleksi`
--
ALTER TABLE `tbl_penilaian_seleksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_prestasi_siswa` (`id_prestasi_siswa`),
  ADD KEY `id_kompetensi_siswa` (`id_kompetensi_siswa`),
  ADD KEY `id_tahun_akademik` (`id_tahun_penilaian`);

--
-- Indexes for table `tbl_prestasi_siswa`
--
ALTER TABLE `tbl_prestasi_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tbl_tahun_penilaian`
--
ALTER TABLE `tbl_tahun_penilaian`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_informasi`
--
ALTER TABLE `tbl_informasi`
  MODIFY `id_informasi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_jabatan`
--
ALTER TABLE `tbl_jabatan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_kompetensi_siswa`
--
ALTER TABLE `tbl_kompetensi_siswa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_pangkat_golongan`
--
ALTER TABLE `tbl_pangkat_golongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_pekerjaan_alumni`
--
ALTER TABLE `tbl_pekerjaan_alumni`
  MODIFY `id_pekerjaan_alumni` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_pendidikan`
--
ALTER TABLE `tbl_pendidikan`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_pengumuman_seleksi`
--
ALTER TABLE `tbl_pengumuman_seleksi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_penilaian_seleksi`
--
ALTER TABLE `tbl_penilaian_seleksi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_prestasi_siswa`
--
ALTER TABLE `tbl_prestasi_siswa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_tahun_penilaian`
--
ALTER TABLE `tbl_tahun_penilaian`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD CONSTRAINT `tbl_guru_ibfk_1` FOREIGN KEY (`id_jabatan`) REFERENCES `tbl_jabatan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_2` FOREIGN KEY (`id_pangkat_golongan`) REFERENCES `tbl_pangkat_golongan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_3` FOREIGN KEY (`id_pendidikan`) REFERENCES `tbl_pendidikan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_4` FOREIGN KEY (`id_jurusan_pendidikan`) REFERENCES `tbl_jurusan_pendidikan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_guru_ibfk_5` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_jurusan_pendidikan`
--
ALTER TABLE `tbl_jurusan_pendidikan`
  ADD CONSTRAINT `tbl_jurusan_pendidikan_ibfk_1` FOREIGN KEY (`id_pendidikan`) REFERENCES `tbl_pendidikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_kompetensi_siswa`
--
ALTER TABLE `tbl_kompetensi_siswa`
  ADD CONSTRAINT `tbl_kompetensi_siswa_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pekerjaan_alumni`
--
ALTER TABLE `tbl_pekerjaan_alumni`
  ADD CONSTRAINT `tbl_pekerjaan_alumni_ibfk_1` FOREIGN KEY (`id_alumni`) REFERENCES `tbl_siswa` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_penilaian_seleksi`
--
ALTER TABLE `tbl_penilaian_seleksi`
  ADD CONSTRAINT `tbl_penilaian_seleksi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penilaian_seleksi_ibfk_2` FOREIGN KEY (`id_prestasi_siswa`) REFERENCES `tbl_prestasi_siswa` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `tbl_penilaian_seleksi_ibfk_3` FOREIGN KEY (`id_kompetensi_siswa`) REFERENCES `tbl_kompetensi_siswa` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penilaian_seleksi_ibfk_4` FOREIGN KEY (`id_tahun_penilaian`) REFERENCES `tbl_tahun_penilaian` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_prestasi_siswa`
--
ALTER TABLE `tbl_prestasi_siswa`
  ADD CONSTRAINT `tbl_prestasi_siswa_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD CONSTRAINT `tbl_siswa_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_siswa_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
