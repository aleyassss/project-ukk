-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_peminjaman
CREATE DATABASE IF NOT EXISTS `db_peminjaman` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_peminjaman`;

-- Dumping structure for table db_peminjaman.alat
DROP TABLE IF EXISTS `alat`;
CREATE TABLE IF NOT EXISTS `alat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint unsigned NOT NULL,
  `nama_alat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alat_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `alat_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.alat: ~6 rows (approximately)
INSERT INTO `alat` (`id`, `kategori_id`, `nama_alat`, `stok`, `created_at`, `updated_at`) VALUES
	(4, 3, 'keyboard', 15, '2026-11-01 21:51:58', '2026-11-03 00:45:14'),
	(6, 3, 'mouse', 10, '2026-11-03 00:45:06', '2026-11-03 00:45:06'),
	(7, 3, 'laptop', 20, '2026-11-03 00:45:26', '2026-11-03 00:45:26'),
	(9, 3, 'pc', 23, '2026-11-03 00:45:47', '2026-11-03 00:45:47'),
	(10, 2, 'bola', 13, '2026-11-03 00:46:00', '2026-11-03 03:44:52'),
	(11, 2, 'bola volly', 20, '2026-11-03 01:52:33', '2026-11-03 01:52:33');

-- Dumping structure for table db_peminjaman.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.failed_jobs: ~0 rows (approximately)

-- Dumping structure for function db_peminjaman.hitung_denda
DROP FUNCTION IF EXISTS `hitung_denda`;
DELIMITER //
CREATE FUNCTION `hitung_denda`(p_rencana DATE, p_real DATE) RETURNS int
    DETERMINISTIC
BEGIN
            IF p_real > p_rencana THEN
                RETURN DATEDIFF(p_real, p_rencana) * 5000;
            END IF;
            RETURN 0;
        END//
DELIMITER ;

-- Dumping structure for table db_peminjaman.kategori
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.kategori: ~2 rows (approximately)
INSERT INTO `kategori` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
	(2, 'Olahraga', '2026-11-01 19:31:50', '2026-11-01 19:31:50'),
	(3, 'Elektronik', '2026-11-01 21:30:31', '2026-11-01 21:30:31');

-- Dumping structure for table db_peminjaman.log_aktivitas
DROP TABLE IF EXISTS `log_aktivitas`;
CREATE TABLE IF NOT EXISTS `log_aktivitas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `aktivitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.log_aktivitas: ~62 rows (approximately)
INSERT INTO `log_aktivitas` (`id`, `user_id`, `aktivitas`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Mengubah kategori: Elektroni', '2026-11-01 21:30:14', '2026-11-01 21:30:14'),
	(2, 1, 'Mengubah kategori: Olahraga', '2026-11-01 21:30:18', '2026-11-01 21:30:18'),
	(3, 1, 'Menghapus kategori: Elektroni', '2026-11-01 21:30:24', '2026-11-01 21:30:24'),
	(4, 1, 'Menambah kategori: Elektronik', '2026-11-01 21:30:31', '2026-11-01 21:30:31'),
	(5, 1, 'Menambah user: aleya', '2026-11-01 23:18:39', '2026-11-01 23:18:39'),
	(6, 1, 'Menghapus user: aleya', '2026-11-01 23:21:10', '2026-11-01 23:21:10'),
	(7, 3, 'Mengajukan peminjaman: keyboard x3', '2026-11-02 07:13:51', '2026-11-02 07:13:51'),
	(8, 2, 'Menyetujui peminjaman #1 (keyboard)', '2026-11-02 07:14:31', '2026-11-02 07:14:31'),
	(9, 3, 'Mengembalikan alat: keyboard', '2026-11-02 07:15:33', '2026-11-02 07:15:33'),
	(10, 1, 'Menambah user: ay', '2026-11-02 07:45:19', '2026-11-02 07:45:19'),
	(11, 1, 'Mengubah user: ay', '2026-11-03 00:43:30', '2026-11-03 00:43:30'),
	(12, 1, 'Menambah user: aleya', '2026-11-03 00:44:13', '2026-11-03 00:44:13'),
	(13, 1, 'Menghapus user: aleya', '2026-11-03 00:44:43', '2026-11-03 00:44:43'),
	(14, 3, 'Mengajukan peminjaman: bola x2', '2026-11-03 00:53:42', '2026-11-03 00:53:42'),
	(15, 3, 'Mengajukan peminjaman: bola x2', '2026-11-03 00:53:42', '2026-11-03 00:53:42'),
	(16, 2, 'Menyetujui peminjaman #7 (bola)', '2026-11-03 00:55:29', '2026-11-03 00:55:29'),
	(17, 2, 'Menyetujui peminjaman #8 (bola)', '2026-11-03 00:57:33', '2026-11-03 00:57:33'),
	(18, 3, 'Mengembalikan alat: bola', '2026-11-03 00:58:55', '2026-11-03 00:58:55'),
	(19, 3, 'Mengembalikan alat: bola', '2026-11-03 00:58:58', '2026-11-03 00:58:58'),
	(20, 3, 'Mengajukan peminjaman: bola x1', '2026-11-03 01:03:22', '2026-11-03 01:03:22'),
	(21, 3, 'Mengajukan peminjaman: bola x1', '2026-11-03 01:03:22', '2026-11-03 01:03:22'),
	(22, 2, 'Menyetujui peminjaman #9 (bola)', '2026-11-03 01:03:50', '2026-11-03 01:03:50'),
	(23, 2, 'Menyetujui peminjaman #10 (bola)', '2026-11-03 01:03:53', '2026-11-03 01:03:53'),
	(24, 3, 'Mengembalikan alat: bola', '2026-11-03 01:07:13', '2026-11-03 01:07:13'),
	(25, 3, 'Mengembalikan alat: bola', '2026-11-03 01:07:18', '2026-11-03 01:07:18'),
	(26, 3, 'Mengajukan peminjaman: bola x3', '2026-11-03 01:07:51', '2026-11-03 01:07:51'),
	(27, 3, 'Mengembalikan alat: bola', '2026-11-03 01:53:05', '2026-11-03 01:53:05'),
	(28, 3, 'Mengajukan peminjaman: bola x2', '2026-11-03 01:54:27', '2026-11-03 01:54:27'),
	(29, 3, 'Mengajukan peminjaman: bola x2', '2026-11-03 01:54:27', '2026-11-03 01:54:27'),
	(30, 2, 'Menyetujui peminjaman #12 (bola)', '2026-11-03 01:55:13', '2026-11-03 01:55:13'),
	(31, 2, 'Menyetujui peminjaman #13 (bola)', '2026-11-03 01:56:25', '2026-11-03 01:56:25'),
	(32, 2, 'Memproses pengembalian #12 (bola)', '2026-11-03 02:00:38', '2026-11-03 02:00:38'),
	(33, 2, 'Memproses pengembalian #13 (bola)', '2026-11-03 02:00:40', '2026-11-03 02:00:40'),
	(34, 3, 'Mengajukan peminjaman: pc x1', '2026-11-03 02:02:03', '2026-11-03 02:02:03'),
	(35, 3, 'Mengajukan peminjaman: pc x1', '2026-11-03 02:02:03', '2026-11-03 02:02:03'),
	(36, 2, 'Menyetujui peminjaman #14 (pc)', '2026-11-03 02:02:24', '2026-11-03 02:02:24'),
	(37, 2, 'Menyetujui peminjaman #15 (pc)', '2026-11-03 02:02:26', '2026-11-03 02:02:26'),
	(38, 2, 'Memproses pengembalian #15 (pc)', '2026-11-03 02:03:11', '2026-11-03 02:03:11'),
	(39, 2, 'Memproses pengembalian #14 (pc)', '2026-11-03 02:03:56', '2026-11-03 02:03:56'),
	(40, 3, 'Mengajukan peminjaman: bola x2', '2026-11-03 02:04:54', '2026-11-03 02:04:54'),
	(41, 2, 'Menyetujui peminjaman #16 (bola)', '2026-11-03 02:05:20', '2026-11-03 02:05:20'),
	(42, 2, 'Memproses pengembalian #16 (bola)', '2026-11-03 02:06:12', '2026-11-03 02:06:12'),
	(43, 3, 'Mengajukan peminjaman: laptop x1', '2026-11-03 02:08:50', '2026-11-03 02:08:50'),
	(44, 2, 'Menyetujui peminjaman #17 (laptop)', '2026-11-03 02:11:27', '2026-11-03 02:11:27'),
	(45, 2, 'Memproses pengembalian #17 (laptop)', '2026-11-03 02:15:27', '2026-11-03 02:15:27'),
	(46, 3, 'Mengajukan peminjaman: pc x1', '2026-11-03 03:21:33', '2026-11-03 03:21:33'),
	(47, 3, 'Mengajukan peminjaman: bola volly x1', '2026-11-03 03:24:05', '2026-11-03 03:24:05'),
	(48, 2, 'Menyetujui peminjaman #18 (pc)', '2026-11-03 03:24:25', '2026-11-03 03:24:25'),
	(49, 2, 'Menyetujui peminjaman #19 (bola volly)', '2026-11-03 03:24:28', '2026-11-03 03:24:28'),
	(50, 2, 'Memproses pengembalian #19 (bola volly)', '2026-11-03 03:25:53', '2026-11-03 03:25:53'),
	(51, 2, 'Memproses pengembalian #18 (pc)', '2026-11-03 03:26:45', '2026-11-03 03:26:45'),
	(52, 1, 'Menambah user: miryam', '2026-11-03 03:46:31', '2026-11-03 03:46:31'),
	(53, 7, 'Mengajukan peminjaman: pc x1', '2026-11-03 03:50:04', '2026-11-03 03:50:04'),
	(54, 7, 'Mengajukan peminjaman: pc x1', '2026-11-03 03:50:04', '2026-11-03 03:50:04'),
	(55, 7, 'Mengajukan peminjaman: pc x1', '2026-11-03 03:50:04', '2026-11-03 03:50:04'),
	(56, 2, 'Menyetujui peminjaman #20 (pc)', '2026-11-03 03:50:54', '2026-11-03 03:50:54'),
	(57, 2, 'Menyetujui peminjaman #22 (pc)', '2026-11-03 03:51:01', '2026-11-03 03:51:01'),
	(58, 2, 'Menyetujui peminjaman #21 (pc)', '2026-11-03 03:51:03', '2026-11-03 03:51:03'),
	(59, 2, 'Memproses pengembalian #20 (pc)', '2026-11-03 03:51:28', '2026-11-03 03:51:28'),
	(60, 3, 'Mengajukan peminjaman: bola x1', '2026-11-03 05:28:20', '2026-11-03 05:28:20'),
	(61, 2, 'Menyetujui peminjaman #23 (bola)', '2026-11-03 05:28:48', '2026-11-03 05:28:48'),
	(62, 3, 'Mengembalikan alat: bola', '2026-11-03 05:32:33', '2026-11-03 05:32:33');

-- Dumping structure for table db_peminjaman.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.migrations: ~10 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2026_11_02_010541_add_username_role_to_users_table', 1),
	(6, '2026_11_02_010626_create_kategori_table', 1),
	(7, '2026_11_02_010658_create_alat_table', 1),
	(8, '2026_11_02_010731_create_peminjaman_table', 1),
	(9, '2026_11_02_010820_create_log_aktivitas_table', 1),
	(10, '2026_11_02_015901_create_procedure_function_trigger', 1);

-- Dumping structure for table db_peminjaman.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table db_peminjaman.peminjaman
DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `alat_id` bigint unsigned NOT NULL,
  `jumlah` int unsigned NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali_rencana` date NOT NULL,
  `tgl_kembali_real` date DEFAULT NULL,
  `status` enum('menunggu','disetujui','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `denda` int unsigned NOT NULL DEFAULT '0',
  `petugas_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjaman_user_id_foreign` (`user_id`),
  KEY `peminjaman_alat_id_foreign` (`alat_id`),
  KEY `peminjaman_petugas_id_foreign` (`petugas_id`),
  CONSTRAINT `peminjaman_alat_id_foreign` FOREIGN KEY (`alat_id`) REFERENCES `alat` (`id`),
  CONSTRAINT `peminjaman_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`),
  CONSTRAINT `peminjaman_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.peminjaman: ~19 rows (approximately)
INSERT INTO `peminjaman` (`id`, `user_id`, `alat_id`, `jumlah`, `tgl_pinjam`, `tgl_kembali_rencana`, `tgl_kembali_real`, `status`, `denda`, `petugas_id`, `created_at`, `updated_at`) VALUES
	(1, 3, 4, 3, '2026-11-02', '2026-11-03', '2026-11-02', 'selesai', 0, 2, '2026-11-02 07:13:51', '2026-11-02 07:15:33'),
	(6, 5, 4, 2, '2026-11-02', '2026-10-29', '2026-11-02', 'selesai', 20000, 1, '2026-11-02 08:05:44', '2026-11-02 08:06:17'),
	(7, 3, 10, 2, '2026-11-03', '2026-10-30', '2026-11-03', 'selesai', 0, 2, '2026-11-03 00:53:42', '2026-11-03 00:58:55'),
	(8, 3, 10, 2, '2026-11-03', '2026-11-04', '2026-11-03', 'selesai', 0, 2, '2026-11-03 00:53:42', '2026-11-03 00:58:58'),
	(9, 3, 10, 1, '2026-11-03', '2026-10-25', '2026-11-03', 'selesai', 35000, 2, '2026-11-03 01:03:22', '2026-11-03 01:07:13'),
	(10, 3, 10, 1, '2026-11-03', '2026-10-27', '2026-11-03', 'selesai', 0, 2, '2026-11-03 01:03:22', '2026-11-03 01:07:18'),
	(11, 3, 10, 3, '2026-11-03', '2026-11-04', '2026-11-03', 'selesai', 0, 1, '2026-11-03 01:07:51', '2026-11-03 01:53:05'),
	(12, 3, 10, 2, '2026-11-03', '2026-11-04', '2026-11-03', 'selesai', 0, 2, '2026-11-03 01:54:27', '2026-11-03 02:00:38'),
	(13, 3, 10, 2, '2026-11-03', '2026-11-04', '2026-11-03', 'selesai', 0, 2, '2026-11-03 01:54:27', '2026-11-03 02:00:40'),
	(14, 3, 9, 1, '2026-11-03', '2026-11-03', '2026-11-03', 'selesai', 0, 2, '2026-11-03 02:02:03', '2026-11-03 02:03:56'),
	(15, 3, 9, 1, '2026-11-03', '2026-11-03', '2026-11-03', 'selesai', 0, 2, '2026-11-03 02:02:03', '2026-11-03 02:03:11'),
	(16, 3, 10, 2, '2026-11-03', '2026-11-03', '2026-11-03', 'selesai', 0, 2, '2026-11-03 02:04:54', '2026-11-03 02:06:12'),
	(17, 3, 7, 1, '2026-11-03', '2026-11-04', '2026-11-03', 'selesai', 0, 2, '2026-11-03 02:08:50', '2026-11-03 02:15:27'),
	(18, 3, 9, 1, '2026-11-03', '2026-11-04', '2026-11-03', 'selesai', 0, 2, '2026-11-03 03:21:33', '2026-11-03 03:26:45'),
	(19, 3, 11, 1, '2026-11-03', '2026-10-30', '2026-11-03', 'selesai', 4000, 2, '2026-11-03 03:24:05', '2026-11-03 03:25:53'),
	(20, 7, 9, 1, '2026-11-03', '2026-11-03', '2026-11-03', 'selesai', 0, 2, '2026-11-03 03:50:04', '2026-11-03 03:51:28'),
	(21, 7, 9, 1, '2026-11-03', '2026-11-03', NULL, 'disetujui', 0, 2, '2026-11-03 03:50:04', '2026-11-03 03:51:03'),
	(22, 7, 9, 1, '2026-11-03', '2026-11-03', NULL, 'disetujui', 0, 2, '2026-11-03 03:50:04', '2026-11-03 03:51:01'),
	(23, 3, 10, 1, '2026-11-03', '2026-11-03', '2026-11-03', 'selesai', 0, 2, '2026-11-03 05:28:20', '2026-11-03 05:32:33');

-- Dumping structure for table db_peminjaman.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for procedure db_peminjaman.sp_pinjam_alat
DROP PROCEDURE IF EXISTS `sp_pinjam_alat`;
DELIMITER //
CREATE PROCEDURE `sp_pinjam_alat`(
            IN p_user_id BIGINT UNSIGNED,
            IN p_alat_id BIGINT UNSIGNED,
            IN p_jumlah INT,
            IN p_tgl_kembali DATE)
BEGIN
            DECLARE v_stok INT DEFAULT 0;
            START TRANSACTION;
            SELECT stok INTO v_stok FROM alat WHERE id = p_alat_id FOR UPDATE;
            IF v_stok < p_jumlah THEN
                ROLLBACK;
                SELECT 'gagal' AS status, 'Stok Tidak Cukup' AS pesan;
            ELSE
                INSERT INTO peminjaman
                    (user_id, alat_id, jumlah, tgl_pinjam, tgl_kembali_rencana, status, denda, created_at, updated_at)
                VALUES
                    (p_user_id, p_alat_id, p_jumlah, CURDATE(), p_tgl_kembali, 'menunggu', 0, NOW(), NOW());
                COMMIT;
                SELECT 'sukses' AS status, 'Pengajuan berhasil' AS pesan;
            END IF;
        END//
DELIMITER ;

-- Dumping structure for table db_peminjaman.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas','peminjam') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'peminjam',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_peminjaman.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin', 'admin@mail.test', NULL, '$2y$12$Mk6VZ5B8ttVtKb1rf7hYluysrZHP96hs7JSKukIXjaYaaq3TPiJXa', 'admin', NULL, '2026-11-01 19:31:49', '2026-11-01 19:31:49'),
	(2, 'Petugas', 'petugas', 'petugas@mail.test', NULL, '$2y$12$b9a5M9IEjToIWGCxt5QZB.G1v9dngh3kpjP4xMSMzC.d5sJb..sj2', 'petugas', NULL, '2026-11-01 19:31:49', '2026-11-01 19:31:49'),
	(3, 'Peminjam', 'peminjam', 'peminjam@mail.test', NULL, '$2y$12$YRIgoX7k41MVtmsRp/Bc0exDKFz2tOiGQ2X9EeUKfLR4e5FCkDuka', 'peminjam', NULL, '2026-11-01 19:31:50', '2026-11-01 19:31:50'),
	(5, 'ay', 'ay', 'ay@mail.test', NULL, '$2y$12$G6MYmIWKSY7dcLnK/RYEAO5NAmxfEHdEwMQqjpI8ldT1iXVaxpIFa', 'petugas', NULL, '2026-11-02 07:45:19', '2026-11-03 00:43:30'),
	(7, 'miryam', 'miryam', 'miryam@mail.test', NULL, '$2y$12$a/h8gDKGtWsQYAaDVDIiCOhgStO6LJJT6bBde2izdd6d3JoXwMi0y', 'peminjam', NULL, '2026-11-03 03:46:31', '2026-11-03 03:46:31');

-- Dumping structure for trigger db_peminjaman.trg_kembalikan_stok
DROP TRIGGER IF EXISTS `trg_kembalikan_stok`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_kembalikan_stok` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
            IF OLD.status = 'disetujui' AND NEW.status = 'selesai' THEN
                UPDATE alat SET stok = stok + NEW.jumlah WHERE id = NEW.alat_id;
            END IF;
        END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger db_peminjaman.trg_kurangi_stok
DROP TRIGGER IF EXISTS `trg_kurangi_stok`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_kurangi_stok` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
            IF OLD.status = 'menunggu' AND NEW.status = 'disetujui' THEN
                UPDATE alat SET stok = stok - NEW.jumlah WHERE id = NEW.alat_id;
            END IF;
        END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
