-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 01, 2024 at 12:55 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokozulaikha`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `name`, `created_at`, `updated_at`) VALUES
(4, 'MURATEKU', '2024-04-23 06:14:28', '2024-05-20 04:33:05'),
(6, 'ORIGINAL PRODUK', '2024-04-23 07:31:00', '2024-05-20 04:33:18'),
(9, 'KIMBO', '2024-04-23 10:12:33', '2024-05-20 04:32:35'),
(10, 'ILM', '2024-05-03 01:49:07', '2024-05-20 04:31:34'),
(11, 'BELFOODS', '2024-05-03 01:50:55', '2024-05-20 04:32:14'),
(14, 'FAYZ', '2024-08-09 00:00:02', '2024-08-21 23:39:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_04_23_105138_create_kategori_table', 2),
(6, '2024_04_23_105521_add_name_field_to_kategori_table', 2),
(7, '2024_04_23_105545_add_description_field_to_kategori_table', 2),
(8, '2024_04_23_105915_add_name_field_to_kategori_table', 3),
(9, '2024_04_23_105940_add_description_field_to_kategori_table', 3),
(10, '2024_04_23_110053_add_name_field_to_kategori_table', 4),
(11, '2024_04_23_110112_add_description_field_to_kategori_table', 4),
(12, '2024_04_30_080115_create_produk_tabel', 5),
(13, '2024_05_16_175443_create_riwayat-transaksi_table', 6),
(14, '2024_05_20_131337_create_transksi-kasir_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` bigint UNSIGNED NOT NULL,
  `id_kategori` bigint UNSIGNED NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat` int NOT NULL,
  `stok` int NOT NULL,
  `stok_offline` int NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_jual` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `id_kategori`, `gambar`, `nama_produk`, `berat`, `stok`, `stok_offline`, `deskripsi`, `harga_jual`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 10, 'produk_1716140832.png', 'ILM TEMPURA 500gr', 500, 10, 0, '<div>ILM Reguler Tempura 500gr adalah pilihan sempurna untuk menciptakan hidangan tempura lezat di rumah Anda. Dibuat dengan bahan-bahan berkualitas tinggi dan proses pembuatan yang teliti, produk ini menawarkan pengalaman memasak yang mudah dan hasil akhir yang memuaskan.<br><br>Tambahkan sentuhan kreatif ke dalam masakan Anda dan buat momen bersantap yang tak terlupakan dengan ILM Reguler Tempura 500gr. Segera dapatkan produk ini dan buat pengalaman kuliner Anda menjadi lebih istimewa!</div>', 13000, '2024-05-19 10:47:12', '2024-08-09 18:08:06', NULL),
(8, 9, 'produk_1716202377.png', 'KIMBO HEPPII BAKSO SAPI 325gr', 325, -1, 0, '<div>&nbsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>', 22000, '2024-05-20 03:52:57', '2024-08-09 00:11:06', NULL),
(9, 4, 'produk_1716540199.png', 'MURATEKU DUMPLING AYAM 500gr', 500, 18, 0, '<div>abc</div>', 25000, '2024-05-24 01:43:19', '2024-07-29 22:19:48', NULL),
(10, 4, 'produk_1722954678.png', 'MURATEKU FISH ROLL 500gr', 500, 20, 19, '<div>MURATEKU FISH ROLL 500gr</div>', 22000, '2024-08-06 07:31:18', '2024-08-09 03:01:41', NULL),
(11, 11, 'produk_1723110119.png', 'BELFOODS CHICKEN NUGGET CRUNCHY 500gr', 500, 17, 16, '<div>Belfoods chicken nugget crunchy dibuat dengan daging ayam&nbsp;</div>', 38000, '2024-08-08 02:41:59', '2024-08-21 23:59:06', NULL),
(12, 14, 'produk_1723252938.png', 'FAYZ DIMSUM AYAM 300gr', 300, 18, 20, '<div>FAYZ DIMSUM AYAM 300gr</div>', 17000, '2024-08-09 18:22:18', '2024-08-21 23:59:06', NULL),
(13, 9, 'produk_1723253067.png', 'KIMBO HEPPII SOSIS BAKAR 500gr', 500, 20, 20, '<div>KIMBO HEPPII SOSIS BAKAR</div>', 25000, '2024-08-09 18:24:27', '2024-08-09 18:24:27', NULL),
(14, 9, 'produk_1723253133.png', 'KIMBO HEPPII DAGING ASAP 200gr', 200, 0, 18, '<div>KIMBO HEPPII DAGING ASAP&nbsp;</div>', 22000, '2024-08-09 18:25:33', '2024-08-12 01:20:54', NULL),
(15, 10, 'produk_1723253186.png', 'ILM BINTANG 500gr', 500, 19, 20, '<div>ILM BINTANG 500gr</div>', 13000, '2024-08-09 18:26:26', '2024-08-12 21:05:00', NULL),
(16, 10, 'produk_1723253244.png', 'ILM BURGER IKAN 500gr', 500, 20, 19, '<div>ILM BURGER IKAN 500gr&nbsp;</div>', 14000, '2024-08-09 18:27:24', '2024-08-12 21:02:41', NULL),
(17, 6, 'produk_1723253349.png', 'GALANTIN AYAM ZULAIKHA 400gr', 400, 9, 15, '<div>GALANTIN AYAM ZULAIKHA 350gr&nbsp;</div>', 30000, '2024-08-09 18:29:09', '2024-08-26 05:36:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat-transaksi`
--

CREATE TABLE `riwayat-transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `no_invoice` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_berat` int DEFAULT NULL,
  `subtotal` int DEFAULT NULL,
  `status_owner` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` json NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination` int DEFAULT NULL,
  `courier` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ongkir` bigint DEFAULT NULL,
  `alamat_kirim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jasa_kurir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `est_kirim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` bigint DEFAULT NULL,
  `snap_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_transaksi` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riwayat-transaksi`
--

INSERT INTO `riwayat-transaksi` (`id`, `id_user`, `no_invoice`, `order_id`, `total_berat`, `subtotal`, `status_owner`, `status`, `details`, `alamat`, `destination`, `courier`, `ongkir`, `alamat_kirim`, `jasa_kurir`, `service`, `est_kirim`, `total`, `snap_token`, `status_transaksi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(46, 2, 'INV/20240523/ZLKH/462/1406263532', 'ORD/20240523/ZLKH/462', 1975, 92000, 'success', 'success', '{\"items\": [{\"qty\": \"2\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1716140832.png\", \"subtotal\": \"26000\", \"id_produk\": \"7\", \"nama_produk\": \"ILM TEMPURA 500gr\", \"harga_produk\": \"13000\"}, {\"qty\": \"3\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1716202377.png\", \"subtotal\": \"66000\", \"id_produk\": \"8\", \"nama_produk\": \"KIMBO HEPPII BAKSO SAPI 325gr\", \"harga_produk\": \"22000\"}]}', 'Jl. Apel 3, Banjarsari, Manahan', 107, 'pos', 30000, 'Jl. Apel 3, Banjarsari, Manahan, Cimahi, Jawa Barat', 'POS Indonesia (POS)', 'Pos Kargo', '7-14 HARI', 122000, '1f07d64b-61d3-45f8-bae0-14130c51c2f2', 'LUNAS', '2024-05-22', '2024-05-23', NULL),
(47, 2, 'INV/20240523/ZLKH/472/782149753', 'ORD/20240523/ZLKH/472', 1500, 39000, 'success', 'success', '{\"items\": [{\"qty\": \"3\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1716140832.png\", \"subtotal\": \"39000\", \"id_produk\": \"7\", \"nama_produk\": \"ILM TEMPURA 500gr\", \"harga_produk\": \"13000\"}]}', 'Jl. Apel 3, Banjarsari, Manahan', 37, 'jne', 26000, 'Jl. Apel 3, Banjarsari, Manahan, Banjarnegara, Jawa Tengah', 'Jalur Nugraha Ekakurir (JNE)', 'REG', '3-6', 65000, 'a5f67fac-0d6f-4d27-9afd-409517e79a4d', 'LUNAS', '2024-05-23', '2024-05-23', NULL),
(48, 2, 'INV/20240716/ZLKH/482/1816309739', 'ORD/20240716/ZLKH/482', 500, 25000, 'pending', 'success', '{\"items\": [{\"qty\": \"1\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1716540199.png\", \"subtotal\": \"25000\", \"id_produk\": \"9\", \"nama_produk\": \"MURATEKU DUMPLING AYAM 500gr\", \"harga_produk\": \"25000\"}]}', 'Jl. Apel 3, Banjarsari, Manahan', 4, 'jne', 40000, 'Jl. Apel 3, Banjarsari, Manahan, Aceh Jaya, Nanggroe Aceh Darussalam (NAD)', 'Jalur Nugraha Ekakurir (JNE)', 'REG', '2-3', 65000, '60378bc0-acfb-432e-9ada-efbc426744d3', 'LUNAS', '2024-07-16', '2024-07-23', NULL),
(50, 2, 'INV/20240730/ZLKH/502/1289017731', 'ORD/20240730/ZLKH/502', 500, 25000, 'pending', 'success', '{\"items\": [{\"qty\": \"1\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1716540199.png\", \"subtotal\": \"25000\", \"id_produk\": \"9\", \"nama_produk\": \"MURATEKU DUMPLING AYAM 500gr\", \"harga_produk\": \"25000\"}]}', 'Jl. Apel 3, Banjarsari, Manahan', 10, 'pos', 61000, 'Jl. Apel 3, Banjarsari, Manahan, Aceh Timur, Nanggroe Aceh Darussalam (NAD)', 'POS Indonesia (POS)', 'Pos Reguler', '7 HARI', 86000, 'e8c3bebc-645d-4e2a-8d72-87c17906bd6f', 'LUNAS', '2024-07-30', '2024-07-30', NULL),
(51, 9, 'INV/20240808/ZLKH/519/23670116', 'ORD/20240808/ZLKH/519', 500, 38000, 'pending', 'success', '{\"items\": [{\"qty\": \"1\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723110119.png\", \"subtotal\": \"38000\", \"id_produk\": \"11\", \"nama_produk\": \"BELFOODS CHICKEN NUGGET CRUNCHY 500gr\", \"harga_produk\": \"38000\"}]}', 'Jl. Apel 3, Banjarsari, Manahan', 35, 'jne', 49000, 'Jl. Apel 3, Banjarsari, Manahan, Banjarbaru, Kalimantan Selatan', 'Jalur Nugraha Ekakurir (JNE)', 'REG', '1-2', 87000, 'f6b88e8e-515e-4f68-9204-b86d1139f6e5', 'LUNAS', '2024-08-08', '2024-08-08', NULL),
(55, 2, 'INV/20240809/ZLKH/552/1624525875', 'ORD/20240809/ZLKH/552', 4875, 330000, 'success', 'success', '{\"items\": [{\"qty\": \"15\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1716202377.png\", \"subtotal\": \"330000\", \"id_produk\": \"8\", \"nama_produk\": \"KIMBO HEPPII BAKSO SAPI 325gr\", \"harga_produk\": \"22000\"}]}', 'Jl. Apel 3, Banjarsari, Manahan', 2, 'jne', 230000, 'Jl. Apel 3, Banjarsari, Manahan, Aceh Barat Daya, Nanggroe Aceh Darussalam (NAD)', 'Jalur Nugraha Ekakurir (JNE)', 'REG', '2-3', 560000, '97368fd2-3bb0-425d-b5d0-e410a2012417', 'LUNAS', '2024-08-09', '2024-08-09', NULL),
(56, 2, 'INV/20240809/ZLKH/562/32834081', 'ORD/20240809/ZLKH/562', 500, 38000, 'pending', 'success', '{\"items\": [{\"qty\": \"1\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723110119.png\", \"subtotal\": \"38000\", \"id_produk\": 11, \"nama_produk\": \"BELFOODS CHICKEN NUGGET CRUNCHY 500gr\", \"harga_produk\": 38000}]}', 'Jl. Apel 3, Banjarsari, Manahan', 1, 'jne', 40000, 'Jl. Apel 3, Banjarsari, Manahan, Aceh Barat, Nanggroe Aceh Darussalam (NAD)', 'Jalur Nugraha Ekakurir (JNE)', 'REG', '2-3', 78000, 'a4cf4cb1-698c-43fc-a975-82b9b3ab1f77', 'LUNAS', '2024-08-09', '2024-08-09', NULL),
(59, 2, 'INV/20240812/ZLKH/592/323707404', 'ORD/20240812/ZLKH/592', 8000, 740000, 'success', 'success', '{\"items\": [{\"qty\": \"20\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723253133.png\", \"subtotal\": \"440000\", \"id_produk\": 14, \"nama_produk\": \"KIMBO HEPPII DAGING ASAP 200gr\", \"harga_produk\": 22000}, {\"qty\": \"10\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723253349.png\", \"subtotal\": \"300000\", \"id_produk\": 17, \"nama_produk\": \"GALANTIN AYAM ZULAIKHA 400gr\", \"harga_produk\": 30000}]}', 'Jl. Apel 3, Banjarsari, Manahan', 1, 'jne', 368000, 'Jl. Apel 3, Banjarsari, Manahan, Aceh Barat, Nanggroe Aceh Darussalam (NAD)', 'Jalur Nugraha Ekakurir (JNE)', 'REG', '2-3', 1108000, '6fece42a-3061-4f11-a2df-f3a24f8ac0ee', 'LUNAS', '2024-08-12', '2024-08-12', NULL),
(61, 8, 'INV/20240813/ZLKH/618/436566474', 'ORD/20240813/ZLKH/618', 500, 13000, 'pending', 'success', '{\"items\": [{\"qty\": \"1\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723253186.png\", \"subtotal\": \"13000\", \"id_produk\": 15, \"nama_produk\": \"ILM BINTANG 500gr\", \"harga_produk\": 13000}]}', 'Jl. Apel 3, Banjarsari, Manahan', 1, 'jne', 40000, 'Jl. Apel 3, Banjarsari, Manahan, Aceh Barat, Nanggroe Aceh Darussalam (NAD)', 'Jalur Nugraha Ekakurir (JNE)', 'REG', '2-3', 53000, 'fb6574b9-af39-4199-b2f3-bce4fb91b594', 'LUNAS', '2024-08-13', '2024-08-13', NULL),
(63, 10, 'INV/20240822/ZLKH/6310/794877762', 'ORD/20240822/ZLKH/6310', 1100, 72000, 'pending', 'success', '{\"items\": [{\"qty\": \"1\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723110119.png\", \"subtotal\": \"38000\", \"id_produk\": 11, \"nama_produk\": \"BELFOODS CHICKEN NUGGET CRUNCHY 500gr\", \"harga_produk\": 38000}, {\"qty\": \"2\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723252938.png\", \"subtotal\": \"34000\", \"id_produk\": 12, \"nama_produk\": \"FAYZ DIMSUM AYAM 300gr\", \"harga_produk\": 17000}]}', 'Jl. Apel 3, Banjarsari, Manahan', 2, 'pos', 61000, 'Jl. Apel 3, Banjarsari, Manahan, Aceh Barat Daya, Nanggroe Aceh Darussalam (NAD)', 'POS Indonesia (POS)', 'Pos Reguler', '7 HARI', 133000, 'c5a2a656-6491-4985-bc95-c442ba5579e8', 'LUNAS', '2024-08-22', '2024-08-22', NULL),
(64, 11, NULL, 'ORD/20240824/ZLKH/6411', 1800, 86000, 'pending', 'pending', '{\"items\": [{\"qty\": \"2\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723253186.png\", \"subtotal\": \"26000\", \"id_produk\": 15, \"nama_produk\": \"ILM BINTANG 500gr\", \"harga_produk\": 13000}, {\"qty\": \"2\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723253349.png\", \"subtotal\": \"60000\", \"id_produk\": 17, \"nama_produk\": \"GALANTIN AYAM ZULAIKHA 400gr\", \"harga_produk\": 30000}]}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BELUM LUNAS', '2024-08-24', '2024-08-24', NULL),
(65, 2, 'INV/20240826/ZLKH/652/1360635486', 'ORD/20240826/ZLKH/652', 400, 30000, 'pending', 'success', '{\"items\": [{\"qty\": \"1\", \"gambar\": \"http://projectskripsi.test/storage/gambar/produk_1723253349.png\", \"subtotal\": \"30000\", \"id_produk\": 17, \"nama_produk\": \"GALANTIN AYAM ZULAIKHA 400gr\", \"harga_produk\": 30000}]}', 'Jl. Apel 3, Banjarsari, Manahan', 2, 'pos', 61000, 'Jl. Apel 3, Banjarsari, Manahan, Aceh Barat Daya, Nanggroe Aceh Darussalam (NAD)', 'POS Indonesia (POS)', 'Pos Reguler', '7 HARI', 91000, '4e8e278d-b58c-4362-aff3-cfb3ab2e6768', 'LUNAS', '2024-08-26', '2024-08-26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi-kasir`
--

CREATE TABLE `transaksi-kasir` (
  `id` bigint UNSIGNED NOT NULL,
  `no_nota` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` json NOT NULL,
  `total` int NOT NULL,
  `cash` int NOT NULL,
  `kembalian` int NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi-kasir`
--

INSERT INTO `transaksi-kasir` (`id`, `no_nota`, `details`, `total`, `cash`, `kembalian`, `created_at`, `updated_at`) VALUES
(94, 'KSR/ZLKH/2024-05-23-664ede119a274', '[{\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"8\", \"product_name\": \"KIMBO HEPPII BAKSO SAPI 325gr\"}, {\"price\": \"13000\", \"quantity\": \"1\", \"product_id\": \"7\", \"product_name\": \"ILM TEMPURA 500gr\"}]', 35000, 40000, 5000, '2024-05-23', '2024-05-23'),
(95, 'KSR/ZLKH/2024-05-23-664f2540ac18d', '[{\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"8\", \"product_name\": \"KIMBO HEPPII BAKSO SAPI 325gr\"}, {\"price\": \"13000\", \"quantity\": \"2\", \"product_id\": \"7\", \"product_name\": \"ILM TEMPURA 500gr\"}]', 48000, 50000, 2000, '2024-05-23', '2024-05-23'),
(96, 'KSR/ZLKH/2024-08-08-66b47952a3886', '[{\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"10\", \"product_name\": \"MURATEKU FISH ROLL 500gr\"}, {\"price\": \"25000\", \"quantity\": \"1\", \"product_id\": \"9\", \"product_name\": \"MURATEKU DUMPLING AYAM 500gr\"}]', 47000, 50000, 3000, '2024-08-08', '2024-08-08'),
(97, 'KSR/ZLKH/2024-08-08-66b47991df337', '[{\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"10\", \"product_name\": \"MURATEKU FISH ROLL 500gr\"}]', 22000, 30000, 8000, '2024-08-08', '2024-08-08'),
(98, 'KSR/ZLKH/2024-08-08-66b47b070fa98', '[{\"price\": \"25000\", \"quantity\": \"1\", \"product_id\": \"9\", \"product_name\": \"MURATEKU DUMPLING AYAM 500gr\"}]', 25000, 50000, 25000, '2024-08-08', '2024-08-08'),
(99, 'KSR/ZLKH/2024-08-08-66b47ce3d9300', '[{\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"10\", \"product_name\": \"MURATEKU FISH ROLL 500gr\"}]', 22000, 30000, 8000, '2024-08-08', '2024-08-08'),
(100, 'KSR/ZLKH/2024-08-08-66b47cfe1013a', '[{\"price\": \"25000\", \"quantity\": \"1\", \"product_id\": \"9\", \"product_name\": \"MURATEKU DUMPLING AYAM 500gr\"}, {\"price\": \"25000\", \"quantity\": \"1\", \"product_id\": \"9\", \"product_name\": \"MURATEKU DUMPLING AYAM 500gr\"}]', 50000, 60000, 10000, '2024-08-08', '2024-08-08'),
(101, 'KSR/ZLKH/2024-08-08-66b47d5d6826a', '[{\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"10\", \"product_name\": \"MURATEKU FISH ROLL 500gr\"}]', 22000, 30000, 8000, '2024-08-08', '2024-08-08'),
(102, 'KSR/ZLKH/2024-08-08-66b47fb73c833', '[{\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"10\", \"product_name\": \"MURATEKU FISH ROLL 500gr\"}, {\"price\": \"13000\", \"quantity\": \"1\", \"product_id\": \"7\", \"product_name\": \"ILM TEMPURA 500gr\"}]', 35000, 36000, 1000, '2024-08-08', '2024-08-08'),
(103, 'KSR/ZLKH/2024-08-08-66b480e0994de', '[{\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"8\", \"product_name\": \"KIMBO HEPPII BAKSO SAPI 325gr\"}, {\"price\": \"13000\", \"quantity\": \"1\", \"product_id\": \"7\", \"product_name\": \"ILM TEMPURA 500gr\"}]', 35000, 40000, 5000, '2024-08-08', '2024-08-08'),
(104, 'KSR/ZLKH/2024-08-08-66b4b617e2123', '[{\"price\": \"38000\", \"quantity\": \"1\", \"product_id\": \"11\", \"product_name\": \"BELFOODS CHICKEN NUGGET CRUNCHY 500gr\"}]', 38000, 40000, 2000, '2024-08-08', '2024-08-08'),
(105, 'KSR/ZLKH/2024-08-09-66b5bf528a89e', '[{\"price\": \"38000\", \"quantity\": \"2\", \"product_id\": \"11\", \"product_name\": \"BELFOODS CHICKEN NUGGET CRUNCHY 500gr\"}, {\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"10\", \"product_name\": \"MURATEKU FISH ROLL 500gr\"}]', 98000, 100000, 2000, '2024-08-09', '2024-08-09'),
(107, 'KSR/ZLKH/2024-08-09-66b5e7f5c264d', '[{\"price\": \"38000\", \"quantity\": \"1\", \"product_id\": \"11\", \"product_name\": \"BELFOODS CHICKEN NUGGET CRUNCHY 500gr\"}]', 38000, 40000, 2000, '2024-08-09', '2024-08-09'),
(108, 'KSR/ZLKH/2024-08-09-66b5e8ea7360c', '[{\"price\": \"38000\", \"quantity\": \"1\", \"product_id\": \"11\", \"product_name\": \"BELFOODS CHICKEN NUGGET CRUNCHY 500gr\"}]', 38000, 40000, 2000, '2024-08-09', '2024-08-09'),
(109, 'KSR/ZLKH/2024-08-09-66b5e905e842b', '[{\"price\": \"38000\", \"quantity\": \"1\", \"product_id\": \"11\", \"product_name\": \"BELFOODS CHICKEN NUGGET CRUNCHY 500gr\"}, {\"price\": \"22000\", \"quantity\": \"1\", \"product_id\": \"10\", \"product_name\": \"MURATEKU FISH ROLL 500gr\"}]', 60000, 65000, 5000, '2024-08-09', '2024-08-09'),
(112, 'KSR/ZLKH/2024-08-12-66b99ef1c6840', '[{\"price\": \"22000\", \"quantity\": \"2\", \"product_id\": \"14\", \"product_name\": \"KIMBO HEPPII DAGING ASAP 200gr\"}, {\"price\": \"30000\", \"quantity\": \"2\", \"product_id\": \"17\", \"product_name\": \"GALANTIN AYAM ZULAIKHA 400gr\"}]', 104000, 105000, 1000, '2024-08-12', '2024-08-12'),
(113, 'KSR/ZLKH/2024-08-13-66badae0eedc6', '[{\"price\": \"30000\", \"quantity\": \"1\", \"product_id\": \"17\", \"product_name\": \"GALANTIN AYAM ZULAIKHA 400gr\"}, {\"price\": \"14000\", \"quantity\": \"1\", \"product_id\": \"16\", \"product_name\": \"ILM BURGER IKAN 500gr\"}]', 44000, 50000, 6000, '2024-08-13', '2024-08-13'),
(115, 'KSR/ZLKH/2024-08-22-66c6dd9047557', '[{\"price\": \"30000\", \"quantity\": \"2\", \"product_id\": \"17\", \"product_name\": \"GALANTIN AYAM ZULAIKHA 400gr\"}]', 60000, 100000, 40000, '2024-08-22', '2024-08-22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `alamat`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Upik', 'owner', 'owner@gmail.com', 85566789980, 'Sanggrahan, RT05 / RW 11, Sukoharjo', '2024-04-16 01:40:23', '$2y$12$CrKoyMn5/kwpSn75Xcbj5OVBtPcmCigAJCd/pxR54hXsAQODoStyK', 'ZdOw0mrhPmxRCx5jijzgoyD5GUW4RDxy0Xl9clxCi5fEyoLRbpe5cJDWYRP7', '2024-03-16 13:02:30', '2024-08-26 05:23:42'),
(2, 'Andre Saputro', 'andre', 'andre@gmail.com', 88227765542, 'Jl. Apel 3, Banjarsari, Manahan', '2024-05-03 07:01:03', '$2y$12$SpKgLPANtaS9XNWfcIrAau9MvMLiy5x2SB9n9M2bfMNUbb5krGWHi', 'DNZ4sClBpAxM937ycjTnKY2OF4xc9keJ5gj8LqnV85Uo32Om0hVtgA7E6m5X', '2024-03-19 13:32:03', '2024-08-26 05:36:34'),
(3, 'abc', 'abc', 'abc@gmail.com', 888877651234, '', '2024-04-16 01:36:37', '$2y$12$2EXsGUaBsai6mPGYKR/33.XMeeyv3giSiaitrbYZHC6IPg48RPR6.', NULL, '2024-04-16 01:35:43', '2024-04-16 01:36:37'),
(5, 'adaada', 'adada', 'adadas@gmail.com', 876556754345, '', '2024-05-03 07:22:39', '$2y$12$U/7suyWxduCJ3C1SMYa.M.GzHxehtKAEnRtF0oBY5RIVm6sg1zTV.', NULL, '2024-05-03 07:19:24', '2024-05-03 07:22:39'),
(6, 'jhondoe', 'jhon', 'jhon@gmail.com', 897887676567, '', NULL, '$2y$12$FeGEBQwLGFF8YpizX1mVvOkrXcWtFUdorp6SWhHg7hFu1Vv38/4C.', NULL, '2024-05-03 07:25:02', '2024-05-03 07:25:02'),
(7, 'Anjas', 'anjas', 'anjas@gmail.com', 88226675542, '', '2024-05-17 02:07:30', '$2y$12$ZyrWs9a4muOpa4uRXzZNE.sPBbkCCSbpC/y0pCL2v3jFzrkgnCjKq', NULL, '2024-05-17 02:06:54', '2024-05-17 02:07:30'),
(8, 'Yanti', 'yanti', 'yanti@gmail.com', 88226674451, '', '2024-07-29 23:01:41', '$2y$12$jYwqQeLxFGAGTMJwT7T8j.n5xTqRN5l6IUfkrgrdTf0SP0ldoyS.y', 'D5dhodL7Fe4IMuE1mq2yemhhxUOhl6QLDBETNLztAmW4q7kquC3Q6R4Fii5G', '2024-07-29 22:58:14', '2024-08-06 06:03:29'),
(9, 'Yanto', 'yanto', 'yanto@gmail.com', 8822998773, '', '2024-08-08 06:02:13', '$2y$12$wXxca0TlqsNUMss1zCcTd.MHtxv1yvy/CkKU7yW3ScrQLei/ci.qm', 'tj3D5GBLcfvYk3zjOEiy1snsUkMgnMzWuJm0P5KlVMMBm7cpuEgrbFlbjBt3', '2024-08-08 05:57:23', '2024-08-09 06:18:23'),
(10, 'Fafa', 'fafa', 'fafa@gmail.com', 88228843375, '', '2024-08-21 23:51:16', '$2y$12$AT63tqNMSTLtLR6aW7vIHOVesiHL5HgKIcT.DqBCT5g5M9NSrzbpO', NULL, '2024-08-21 23:50:38', '2024-08-21 23:51:16'),
(11, 'Awam', 'awam', 'awam@gmail.com', 88228828822, '', '2024-08-23 21:29:03', '$2y$12$nFAbd8cDe6eOkUgl9906tu3FImJ64gDRGdQtKn32Fl0M1teJo0yJ2', NULL, '2024-08-23 21:12:23', '2024-08-23 21:29:03'),
(12, 'Udin', 'udin', 'udin@gmail.com', 99876654432, '', '2024-08-23 21:20:53', '$2y$12$0qchm5aUrmHM8/aHSas.WOCkJXTJnqIKa44x3CzfAoWNkYFdwNdNq', NULL, '2024-08-23 21:20:35', '2024-08-23 21:20:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `riwayat-transaksi`
--
ALTER TABLE `riwayat-transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `transaksi-kasir`
--
ALTER TABLE `transaksi-kasir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `riwayat-transaksi`
--
ALTER TABLE `riwayat-transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `transaksi-kasir`
--
ALTER TABLE `transaksi-kasir`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat-transaksi`
--
ALTER TABLE `riwayat-transaksi`
  ADD CONSTRAINT `riwayat-transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
