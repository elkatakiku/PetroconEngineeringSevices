-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2023 at 10:13 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petrocon`
--

-- --------------------------------------------------------

--
-- Table structure for table `lnk_project_plan`
--

CREATE TABLE `lnk_project_plan` (
  `proj_id` varchar(100) NOT NULL,
  `leg_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lnk_project_plan`
--

INSERT INTO `lnk_project_plan` (`proj_id`, `leg_id`) VALUES
('PTRCN-PRJCT-63a8b1a628b00', 'PTRCN-LGND-63a8b1a628f6b'),
('PTRCN-PRJCT-63a8b1ca25a54', 'PTRCN-LGND-63a8b1ca25eca'),
('PTRCN-PRJCT-63a8b223e533c', 'PTRCN-LGND-63a8b223e5724'),
('PTRCN-PRJCT-63ae4ea9b3ba6', 'PTRCN-LGND-63ae4ea9b3dd7'),
('PTRCN-PRJCT-63ae530ac8287', 'PTRCN-LGND-63ae530ac84a5'),
('PTRCN-PRJCT-63ae530d0a5db', 'PTRCN-LGND-63ae530d0a6e0'),
('PTRCN-PRJCT-63ae530fd4447', 'PTRCN-LGND-63ae530fd464d'),
('PTRCN-PRJCT-63ae5326cd68d', 'PTRCN-LGND-63ae5326cd79b'),
('PTRCN-PRJCT-63ae5346a15b0', 'PTRCN-LGND-63ae5346a193e'),
('PTRCN-PRJCT-63ae542160c51', 'PTRCN-LGND-63ae542160e70'),
('PTRCN-PRJCT-63ae5428d0cb3', 'PTRCN-LGND-63ae5428d0ec1'),
('PTRCN-PRJCT-63ae546cdc190', 'PTRCN-LGND-63ae546cdc29e'),
('PTRCN-PRJCT-63ae54c8285e5', 'PTRCN-LGND-63ae54c828972'),
('PTRCN-PRJCT-63ae55283c6d9', 'PTRCN-LGND-63ae55283cb11'),
('PTRCN-PRJCT-63b3fe007bde1', 'PTRCN-LGND-63b3fe007bff8'),
('PTRCN-PRJCT-63bb7b72d1508', 'PTRCN-LGND-63bb7b72d1620'),
('PTRCN-PRJCT-63bc1cdd12b27', 'PTRCN-LGND-63bc1cdd12d66'),
('PTRCN-PRJCT-63bc48ea7efe2', 'PTRCN-LGND-63bc48ea7f6bb');

-- --------------------------------------------------------

--
-- Table structure for table `lnk_project_team`
--

CREATE TABLE `lnk_project_team` (
  `reg_id` varchar(100) NOT NULL,
  `proj_id` varchar(100) NOT NULL,
  `priviledge` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pltbl_account_type`
--

CREATE TABLE `pltbl_account_type` (
  `id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pltbl_account_type`
--

INSERT INTO `pltbl_account_type` (`id`, `name`, `description`) VALUES
('PTRCN-TYPE-20221', 'Admin', ''),
('PTRCN-TYPE-20222', 'Employee', ''),
('PTRCN-TYPE-20223', 'Worker', ''),
('PTRCN-TYPE-20224', 'Client', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `id` varchar(100) NOT NULL,
  `type_id` varchar(100) NOT NULL,
  `register_id` varchar(100) NOT NULL,
  `login_id` varchar(100) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`id`, `type_id`, `register_id`, `login_id`, `activated`) VALUES
('PTRCN-ACCT-638e56ea9b617', 'PTRCN-TYPE-20221', 'PTRCN-RGSTR-638e56ea9b610', 'PTRCN-USR-638e56ea86b8c', 1),
('PTRCN-ACCT-638f7d443068f', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-638f7d4430689', 'PTRCN-USR-638f7d441d81e', 0),
('PTRCN-ACCT-6390b2b8ee631', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-6390b2b8ee625', 'PTRCN-USR-6390b2b8d9892', 0),
('PTRCN-ACCT-63aca07cd1916', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-63aca07cd18fe', 'PTRCN-USR-63aca07cbe658', 1),
('PTRCN-ACCT-63b9dca9abff6', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-63b9dca9abfef', 'PTRCN-USR-63b9dca998f25', 0),
('PTRCN-ACCT-63b9e1b65024a', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-63b9e1b650244', 'PTRCN-USR-63b9e1b63da47', 0),
('PTRCN-ACCT-63b9e1fa850e6', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-63b9e1fa850da', 'PTRCN-USR-63b9e1fa70711', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activation`
--

CREATE TABLE `tbl_activation` (
  `id` varchar(100) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT current_timestamp(),
  `acc_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_activation`
--

INSERT INTO `tbl_activation` (`id`, `code`, `sent_at`, `acc_id`) VALUES
('PTRCN-ACTVTN-63bacc1acb941', 'c9d4420ac8cd028342002de08ca465cd9cb17fd69ea1127e60799665098b326e', '2023-01-08 13:58:50', 'PTRCN-ACCT-63aca07cd1916'),
('PTRCN-ACTVTN-63bc1b1b3f240', 'dfa4b5a23533a3e0d9022bd27c76ce63c573542d44262705ba4b9bf0f9fc5c47', '2023-01-09 13:48:11', 'PTRCN-ACCT-63b9e1b65024a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_client`
--

CREATE TABLE `tbl_client` (
  `clnt_ID` varchar(100) NOT NULL,
  `clnt_name` varchar(255) NOT NULL,
  `clnt_company` varchar(255) NOT NULL,
  `clnt_contact_num` varchar(255) NOT NULL,
  `clnt_email` varchar(255) NOT NULL,
  `clnt_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_client`
--

INSERT INTO `tbl_client` (`clnt_ID`, `clnt_name`, `clnt_company`, `clnt_contact_num`, `clnt_email`, `clnt_active`) VALUES
('PTRCN-CLNT-2022654', 'El Katakiku', 'Lancaster', '09123456789', 'el@email.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_legend`
--

CREATE TABLE `tbl_legend` (
  `id` varchar(100) NOT NULL,
  `color` char(7) NOT NULL,
  `title` varchar(255) NOT NULL,
  `proj_id` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_legend`
--

INSERT INTO `tbl_legend` (`id`, `color`, `title`, `proj_id`, `created_at`, `active`) VALUES
('PTRCN-LGND-63a882520e05b', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a613bd48f75', '2022-12-26 01:03:14', 1),
('PTRCN-LGND-63a891ef5decd', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a891ef5dca0', '2022-12-26 02:09:51', 1),
('PTRCN-LGND-63a891ef5ded7', '#5aac44', 'Actual', 'PTRCN-PRJCT-63a891ef5dca0', '2022-12-26 02:09:51', 1),
('PTRCN-LGND-63a8b1a628f6b', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a8b1a628b00', '2022-12-26 04:25:10', 1),
('PTRCN-LGND-63a8b1a628f8b', '#5aac44', 'Actual', 'PTRCN-PRJCT-63a8b1a628b00', '2022-12-26 04:25:10', 1),
('PTRCN-LGND-63a8b1ca25eca', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a8b1ca25a54', '2022-12-26 04:25:46', 1),
('PTRCN-LGND-63a8b1ca25edc', '#5aac44', 'Actual', 'PTRCN-PRJCT-63a8b1ca25a54', '2022-12-26 04:25:46', 1),
('PTRCN-LGND-63a8b223e5724', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-26 04:27:15', 1),
('PTRCN-LGND-63a8b223e573b', '#5aac44', 'Actual', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-26 04:27:16', 1),
('PTRCN-LGND-63ab145fdcd55', '#00aecc', 'Legend 3', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-27 23:50:55', 1),
('PTRCN-LGND-63ab24780d9b0', '#ef7564', 'Legend 4', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-28 00:59:36', 1),
('PTRCN-LGND-63ab252cd5a18', '#f5dd29', 'Legend 5', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-28 01:02:36', 1),
('PTRCN-LGND-63ab25aebfe11', '#ffaf3f', 'Legend 6', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-28 01:04:46', 1),
('PTRCN-LGND-63ab2635c7067', '#6deca9', 'Legend 7', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-28 01:07:01', 1),
('PTRCN-LGND-63ae4ea9b3dd7', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae4ea9b3ba6', '2022-12-30 10:36:25', 1),
('PTRCN-LGND-63ae4ea9b3ddb', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae4ea9b3ba6', '2022-12-30 10:36:25', 1),
('PTRCN-LGND-63ae530ac84a5', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae530ac8287', '2022-12-30 10:55:06', 1),
('PTRCN-LGND-63ae530ac84a9', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae530ac8287', '2022-12-30 10:55:06', 1),
('PTRCN-LGND-63ae530d0a6e0', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae530d0a5db', '2022-12-30 10:55:09', 1),
('PTRCN-LGND-63ae530d0a6e3', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae530d0a5db', '2022-12-30 10:55:09', 1),
('PTRCN-LGND-63ae530fd464d', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae530fd4447', '2022-12-30 10:55:11', 1),
('PTRCN-LGND-63ae530fd4653', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae530fd4447', '2022-12-30 10:55:12', 1),
('PTRCN-LGND-63ae5326cd79b', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae5326cd68d', '2022-12-30 10:55:34', 1),
('PTRCN-LGND-63ae5326cd79e', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae5326cd68d', '2022-12-30 10:55:34', 1),
('PTRCN-LGND-63ae5346a193e', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae5346a15b0', '2022-12-30 10:56:06', 1),
('PTRCN-LGND-63ae5346a1959', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae5346a15b0', '2022-12-30 10:56:06', 1),
('PTRCN-LGND-63ae542160e70', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae542160c51', '2022-12-30 10:59:45', 1),
('PTRCN-LGND-63ae542160e73', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae542160c51', '2022-12-30 10:59:45', 1),
('PTRCN-LGND-63ae5428d0ec1', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae5428d0cb3', '2022-12-30 10:59:53', 1),
('PTRCN-LGND-63ae5428d0ec4', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae5428d0cb3', '2022-12-30 10:59:53', 1),
('PTRCN-LGND-63ae546cdc29e', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae546cdc190', '2022-12-30 11:01:00', 1),
('PTRCN-LGND-63ae546cdc2a1', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae546cdc190', '2022-12-30 11:01:01', 1),
('PTRCN-LGND-63ae54c828972', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae54c8285e5', '2022-12-30 11:02:32', 1),
('PTRCN-LGND-63ae54c82897a', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae54c8285e5', '2022-12-30 11:02:32', 1),
('PTRCN-LGND-63ae55283cb11', '#026aa7', 'Plan', 'PTRCN-PRJCT-63ae55283c6d9', '2022-12-30 11:04:08', 1),
('PTRCN-LGND-63ae55283cb18', '#5aac44', 'Actual', 'PTRCN-PRJCT-63ae55283c6d9', '2022-12-30 11:04:08', 1),
('PTRCN-LGND-63af558581127', '#ff8ed4', 'Test', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-31 05:17:57', 1),
('PTRCN-LGND-63af559bf355e', '#cd8de5', '\'Sa Pa', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-31 05:18:19', 1),
('PTRCN-LGND-63af57b790b16', '#091e42', 'Asd', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-31 05:27:19', 1),
('PTRCN-LGND-63af57fe4a776', '#4ed583', 'Ass', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-31 05:28:30', 1),
('PTRCN-LGND-63af584cf176c', '#f5dd29', 'Pwet', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-31 05:29:48', 1),
('PTRCN-LGND-63af585f80dd0', '#e568af', 'Asd', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-31 05:30:07', 1),
('PTRCN-LGND-63af58b03c1c9', '#29cce5', 'Asdasd', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-31 05:31:28', 1),
('PTRCN-LGND-63b1dcc47f6e7', '#f5dd29', 'Ganto ah', 'PTRCN-PRJCT-63ae55283c6d9', '2023-01-02 03:19:32', 1),
('PTRCN-LGND-63b1eab1dca27', '#cd8de5', 'Isa Pa Legends', 'PTRCN-PRJCT-63ae55283c6d9', '2023-01-02 04:18:57', 0),
('PTRCN-LGND-63b3a18eb930d', '#00aecc', 'Test', 'PTRCN-PRJCT-63ae55283c6d9', '2023-01-03 11:31:26', 0),
('PTRCN-LGND-63b3fe007bff8', '#026aa7', 'Plan', 'PTRCN-PRJCT-63b3fe007bde1', '2023-01-03 18:05:52', 1),
('PTRCN-LGND-63b3fe007bffc', '#f5dd29', 'Actual', 'PTRCN-PRJCT-63b3fe007bde1', '2023-01-03 18:05:52', 1),
('PTRCN-LGND-63b7a3a59a0f9', '#ff8ed4', 'Penk', 'PTRCN-PRJCT-63b3fe007bde1', '2023-01-06 12:29:25', 0),
('PTRCN-LGND-63bb7b72d1620', '#026aa7', 'Plan', 'PTRCN-PRJCT-63bb7b72d1508', '2023-01-09 10:26:58', 1),
('PTRCN-LGND-63bb7b72d1623', '#5aac44', 'Actual', 'PTRCN-PRJCT-63bb7b72d1508', '2023-01-09 10:26:59', 1),
('PTRCN-LGND-63bb7d5df393a', '#ffaf3f', 'Test', 'PTRCN-PRJCT-63bb7b72d1508', '2023-01-09 10:35:09', 1),
('PTRCN-LGND-63bc1cdd12d66', '#026aa7', 'Plan', 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-09 21:55:41', 1),
('PTRCN-LGND-63bc1cdd12d6a', '#5aac44', 'Actual', 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-09 21:55:41', 1),
('PTRCN-LGND-63bc48ea7f6bb', '#026aa7', 'Plan', 'PTRCN-PRJCT-63bc48ea7efe2', '2023-01-10 01:03:38', 1),
('PTRCN-LGND-63bc48ea7f6c0', '#5aac44', 'Actual', 'PTRCN-PRJCT-63bc48ea7efe2', '2023-01-10 01:03:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `id` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`id`, `username`, `password`) VALUES
('PTRCN-USR-638e56ea86b8c', 'admin', '$2y$10$j0RTpWXgj/EkfuV1BBFvfuFv66Qw8HlvzWI1Ku4yYZxLujvNuhHaO'),
('PTRCN-USR-638f7d441d81e', 'elkatakiku', '$2y$10$EovMtaNz4MD9y6Ogj4V/WenneruwBZbjGsA2EAc/aDxb7HbRpHgs.'),
('PTRCN-USR-6390b2b8d9892', 'sample', '$2y$10$1TTUs1tCgIJVe/Pjt8PTZuTTmY3elKPYHucXwRGWn2QBlzK9Xpsp.'),
('PTRCN-USR-63aca07cbe658', 'asd', '$2y$10$8lFv3tSlJGmZQssh4BkHuOlqfeXZMyOPn9rvQB25IeaatC2sAOrf.'),
('PTRCN-USR-63b9d79eee626', '', '$2y$10$kXJc2Az6hwMS3wX44sW2qeFrmpWWqthJLcdUx7Uug0diR3BIPK34W'),
('PTRCN-USR-63b9dca998f25', 'asd', '$2y$10$i.XELP1lVWiWmOAywqJIJee3JVlZCAHsPgPtxq630GK5hFV3thnkq'),
('PTRCN-USR-63b9e1b63da47', 'sss', '$2y$10$LL7MZ6fHDpJGFqQ.IS1pVe9/hvcBBD81Rporet0cpAPmI4TPViAga'),
('PTRCN-USR-63b9e1fa70711', 'arbor', '$2y$10$PFWUCPtAYAlTqhG8FYGLIemPZIr34x8TUhUn7WinxY7byjn9C70Ui');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `id` varchar(100) NOT NULL,
  `bill` varchar(255) NOT NULL,
  `amount` double(10,4) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `proj_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_project`
--

CREATE TABLE `tbl_project` (
  `id` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `location` varchar(255) NOT NULL,
  `building_number` varchar(255) NOT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `purchase_ord` varchar(100) NOT NULL,
  `award_date` datetime NOT NULL,
  `company` varchar(255) NOT NULL,
  `comp_representative` varchar(255) DEFAULT NULL,
  `comp_contact` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_project`
--

INSERT INTO `tbl_project` (`id`, `description`, `location`, `building_number`, `done`, `active`, `purchase_ord`, `award_date`, `company`, `comp_representative`, `comp_contact`, `created_at`) VALUES
('PTRCN-PRJCT-63a04ff70fffc', 'Asd', 'Asd', 'Asd', 0, 1, 'Asd', '2022-12-10 00:00:00', 'Sad', 'Asd', 'sad', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63a19b8a06adf', 'Conduct preventive maintenance for gasline from manifold to distribution line up to burnes equipment.', 'Rosario, Batangas', 'Building 1, 2, 3', 0, 1, '20221526', '2022-12-10 00:00:00', 'Pheonix Inc.', 'Yvana Eunice Magno', '09123456789', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63a36bc924707', 'Projects chuchuness', 'Samin', 'Blk 5 Lt 54', 0, 1, '20221526', '2022-12-14 00:00:00', 'Elkatakiku', 'Eli', '09123456789', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63a6132d67c8d', 'Hekhek', 'Sa Kanila', 'Building 1, 2, 3', 0, 1, 'Another Project', '2022-12-01 00:00:00', 'Desteen', 'Effer', '09123456789', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63a61364670b1', 'Di ko na alam', 'Jan Lang', 'Building 1, 2, 3', 0, 0, 'Isa Pa', '2022-12-17 00:00:00', 'Takahiro', 'Gale', '09123456789', '2023-01-04 13:05:09'),
('PTRCN-PRJCT-63a613bd48f75', 'Di din alam', 'Sa Moon', 'Building 1, 2, 3', 0, 1, 'Isa Pa Nga', '2022-12-17 00:00:00', 'Vanana', 'Yva', '09123456789', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63a8870270288', 'Try legend', 'Asdasd', 'Asd', 0, 0, '20221526', '2022-12-07 00:00:00', 'Comp', 'Wfwef', '09123456789', '2023-01-04 13:05:31'),
('PTRCN-PRJCT-63a8879e47f6c', 'Try legend', 'Asdasd', 'Asd', 0, 0, '20221526', '2022-12-07 00:00:00', 'Comp', 'Wfwef', '09123456789', '2023-01-04 12:59:48'),
('PTRCN-PRJCT-63a891ef5dca0', 'Try legend', 'Asdasd', 'Asd', 0, 1, '20221526', '2022-12-07 00:00:00', 'Comp', 'Wfwef', '09123456789', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63a8b1a628b00', 'Try project plan', 'Sa Tabi', 'Asdasd Dasd54 498', 0, 0, '20221555', '2022-12-23 00:00:00', 'Assdfe', 'Fsda Dcv  Wefew', '09123456789', '2023-01-04 13:05:14'),
('PTRCN-PRJCT-63a8b1ca25a54', 'Try project plan', 'Sa Tabi', 'Asdasd Dasd54 498', 0, 1, '20221555', '2022-12-23 00:00:00', 'Assdfe', 'Fsda Dcv  Wefew', '09123456789', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63a8b223e533c', 'Isa pa po', 'Otw', '32156 564', 0, 1, '20221526', '2022-12-22 00:00:00', 'Elkatakiku', 'Eli', '09123456789', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae4ea9b3ba6', 'La lang po', 'Sa Singapore', 'Asdasd Dasd54 498', 0, 1, 'Another One', '2022-12-27 00:00:00', 'Ako', 'Ako Din', '09123456789', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae530ac8287', 'Asdas', 'Asd', 'Asdasd', 0, 1, 'Asdasd', '2022-12-03 00:00:00', 'Asdasd', 'Dasdas', 'dasd', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae530d0a5db', 'Asdas', 'Asd', 'Asdasd', 0, 1, 'Asdasd', '2022-12-03 00:00:00', 'Asdasd', 'Dasdas', 'dasd', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae530fd4447', 'Asdas', 'Asd', 'Asdasd', 0, 1, 'Asdasd', '2022-12-03 00:00:00', 'Asdasd', 'Dasdas', 'dasd', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae5326cd68d', 'Asdas', 'Asd', 'Asdasd', 0, 1, 'Asdasd', '2022-12-03 00:00:00', 'Asdasd', 'Dasdas', 'dasd', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae5346a15b0', 'Adasd', 'Asdasd', 'Asdasdas', 0, 1, 'Adasd', '2022-12-08 00:00:00', 'Ddsad', 'Ddd', 'das', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae542160c51', 'Adasd', 'Asdasd', 'Asdasdas', 0, 1, 'Adasd', '2022-12-08 00:00:00', 'Ddsad', 'Ddd', 'das', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae5428d0cb3', 'Asd', 'Asd', 'Asd', 0, 1, 'Asd', '2022-11-30 00:00:00', 'Asd', 'Asd', 'asd', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae546cdc190', 'Ad', 'Asd', 'Asd', 0, 1, 'Asd', '2022-12-20 00:00:00', 'Asd', 'Asd', 'asd', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae54c8285e5', 'Sdf', 'Sdfsdf', 'Sdfds', 0, 1, 'Asddfsf', '2022-11-30 00:00:00', 'Fsd', 'Sfsd', 'fdsf', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63ae55283c6d9', 'Sdfsd', 'Fsdf', 'Sdsf', 0, 1, 'Sfgsf', '2022-12-21 00:00:00', 'Sfsd', 'Sdf', 'sfs', '2023-01-03 10:03:34'),
('PTRCN-PRJCT-63b3fe007bde1', 'Installation of extension of main lpg pipeline and additional food tenant at lgf and relocation of main pipeline at ugf and extension of stubouts at 2f and ugf.', 'Robinsons Palace, Antipolo City', 'Blk 5 Lt 54', 1, 1, '3216545', '2023-01-03 00:00:00', 'Pheonix Inc.', 'Ako', '09123456789', '2023-01-09 03:47:07'),
('PTRCN-PRJCT-63bb7b72d1508', 'Test', 'Test', 'Test', 0, 1, '123', '2023-01-12 00:00:00', 'Test', 'Test', 'Test', '2023-01-09 02:26:58'),
('PTRCN-PRJCT-63bc1cdd12b27', 'Test', 'Test', 'Test', 0, 1, '20221526', '2023-01-18 00:00:00', 'Test', 'Test', 'Test', '2023-01-09 13:55:41'),
('PTRCN-PRJCT-63bc48ea7efe2', 'Asd', 'Asd', 'Asd', 0, 0, '20221526', '2023-01-26 00:00:00', 'Asd', 'Asd', 'asd', '2023-01-09 17:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_register`
--

CREATE TABLE `tbl_register` (
  `id` varchar(100) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `log_ID` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_register`
--

INSERT INTO `tbl_register` (`id`, `lastname`, `firstname`, `middlename`, `contact_number`, `dob`, `email`, `log_ID`, `address`) VALUES
('PTRCN-RGSTR-638e56ea9b610', 'admin', 'admin', 'admin', '09123456789', '2022-12-06', 'admin@email.com', 'PTRCN-USR-638e56ea86b8c', ''),
('PTRCN-RGSTR-638f7d4430689', 'Elkatakiku', 'El', 'M', '09123456789', '2000-06-30', 'lamzonelizer1@gmail.com', 'PTRCN-USR-638f7d441d81e', ''),
('PTRCN-RGSTR-6390b2b8ee625', 'Lastname', 'Firstname', 'M', '09123456789', '2000-12-07', 'sample@email.com', 'PTRCN-USR-6390b2b8d9892', ''),
('PTRCN-RGSTR-63aca07cd18fe', 'Cooper', 'Bradley', 'D', '09234567891', '2002-07-04', 'elkatakiku@email.com', 'PTRCN-USR-63aca07cbe658', 'Bat Wala'),
('PTRCN-RGSTR-63b9dca9abfef', 'Elkatakiku', 'El', 'ASD', '09123456789', '2000-06-23', 'sadsa@asd.com', 'PTRCN-USR-63b9dca998f25', ''),
('PTRCN-RGSTR-63b9e1b650244', 'Sssdd', 'Qweee', 'FGGJUY', '09123456789', '2000-01-07', 'ffgg@email.com', 'PTRCN-USR-63b9e1b63da47', ''),
('PTRCN-RGSTR-63b9e1fa850da', 'User', 'New', 'EH', '09123456789', '2000-01-07', 'shawty@email.com', 'PTRCN-USR-63b9e1fa70711', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resource`
--

CREATE TABLE `tbl_resource` (
  `id` varchar(100) NOT NULL,
  `item` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(10,4) NOT NULL,
  `total` double(10,4) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `proj_id` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_resource`
--

INSERT INTO `tbl_resource` (`id`, `item`, `quantity`, `price`, `total`, `notes`, `proj_id`, `active`) VALUES
('PTRCN-RSRC-63b8d3f76b0f0', 'Item 1', 5, 12.0000, 60.0000, '', 'PTRCN-PRJCT-63b3fe007bde1', 1),
('PTRCN-RSRC-63b8d4102777d', 'Item 2', 5, 12.0000, 60.0000, '', 'PTRCN-PRJCT-63b3fe007bde1', 1),
('PTRCN-RSRC-63b8d5106fb47', 'Item 3', 20, 2.0000, 40.0000, '', 'PTRCN-PRJCT-63b3fe007bde1', 1),
('PTRCN-RSRC-63b8e79e75958', 'Item 4', 3, 5.0000, 15.0000, 'asd', 'PTRCN-PRJCT-63b3fe007bde1', 0),
('PTRCN-RSRC-63b8e81889deb', 'Item 5', 2, 620.0000, 1240.0000, '', 'PTRCN-PRJCT-63b3fe007bde1', 1),
('PTRCN-RSRC-63b90c1c7dcf2', 'Item 6', 5, 22.0000, 110.0000, '', 'PTRCN-PRJCT-63b3fe007bde1', 1),
('PTRCN-RSRC-63b90c34a6b80', 'Sample', 11, 4.3600, 47.9600, '', 'PTRCN-PRJCT-63b3fe007bde1', 0),
('PTRCN-RSRC-63b90c9415f68', 'Yes po', 5, 36.6200, 183.1000, 'Opo', 'PTRCN-PRJCT-63b3fe007bde1', 0),
('PTRCN-RSRC-63bc48b9bfad9', 'ads', 12, 4343.0000, 52116.0000, '', 'PTRCN-PRJCT-63bc1cdd12b27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task`
--

CREATE TABLE `tbl_task` (
  `id` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `order_no` decimal(10,4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `proj_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_task`
--

INSERT INTO `tbl_task` (`id`, `description`, `order_no`, `status`, `created_at`, `active`, `proj_id`) VALUES
('PTRCN-TSK-63a8c6f27d06b', 'Task 1.9', '1.0000', 0, '2022-12-25 21:56:02', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63a8c6fb83dc3', 'Task 2.1', '2.0000', 0, '2022-12-25 21:56:11', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63a8fe7cb39ca', 'Task nito na naman. Inupdate ko rin toh', '3.0000', 0, '2022-12-26 01:53:00', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63a91767127ee', 'Another task nito. inupdate ko. isa pa', '4.0000', 0, '2022-12-26 03:39:19', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa0f0bbfd9b', 'Task na naman. Eto rinasd', '5.0000', 0, '2022-12-26 21:15:55', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa0f50ddad5', 'Try reload', '6.0000', 0, '2022-12-26 21:17:04', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa0f5f16759', 'Isa pa reload', '7.0000', 0, '2022-12-26 21:17:19', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa103f8dc53', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dictum at sapien eu mattis. Sed blandit vel diam at dapibus. Proin euismod massa vel tempus tempus.', '8.0000', 0, '2022-12-26 21:21:03', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa12b874058', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec efficitur nisl ut mauris rutrum dignissim. Suspendisse eleifend sit amet est id fermentum. Proin vitae arcu consequat nisl laoreet ultricies nec et lacus. Pellentesque ultrices lectus quam, se', '9.0000', 0, '2022-12-26 21:31:36', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa1309398af', 'Procurement', '10.0000', 0, '2022-12-26 21:32:57', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa130e0797c', 'Tool Box Meeting', '11.0000', 0, '2022-12-26 21:33:02', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa1313e1903', 'Actual visit at site for measurement', '12.0000', 0, '2022-12-26 21:33:07', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa131c08148', 'Mobilization', '13.0000', 0, '2022-12-26 21:33:16', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa1321ccc41', 'Repainting of pipe', '14.0000', 0, '2022-12-26 21:33:21', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa1330ea4d6', 'Relocation of 2&quot; Distribution line from Handyman&#039;s area (removal and Reinstall with 55 meter located at Upper ground)', '15.0000', 0, '2022-12-26 21:33:36', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa1343e6d47', 'Modification of 2&quot; B.I. pipe (step-up for x 600mm 10meter long) due to modification of wall from concrete to glass wall at Second floor,', '16.0000', 0, '2022-12-26 21:33:55', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa135072d5f', 'Modification of 2&quot; Distribution pipe line second floor due to aircon  ducting conflict with 15 meter long', '17.0000', 0, '2022-12-26 21:34:08', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa135acabaa', 'Additional stub-out for 6 tenants and additional pipe line for 12- tenats  from existing stub-outs to meter location inside the tenant area', '18.0000', 0, '2022-12-26 21:34:18', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa135f97bfa', 'Leak Test and commissioning  at 2F, UGF, LGF', '19.0000', 0, '2022-12-26 21:34:23', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa13656951c', 'Additional 2-1/2&quot;  LPG mainline and stubouts for Vikings, Tongyang', '20.0000', 0, '2022-12-26 21:34:29', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa136c9ba8a', 'Leak test on 2-1/2 addition mainline and stubouts', '21.0000', 0, '2022-12-26 21:34:36', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63ac433d1ce13', 'nagana ka ba', '22.0000', 0, '2022-12-28 13:23:09', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63ac53319b61f', 'Isa pa', '23.0000', 0, '2022-12-28 14:31:13', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b1177173021', 'asd', '24.0000', 0, '2023-01-01 05:17:37', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b1179eae6ef', 'asd', '25.0000', 0, '2023-01-01 05:18:22', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b117d883e07', 'asd', '26.0000', 0, '2023-01-01 05:19:20', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b118257f3f0', 'asd', '27.0000', 0, '2023-01-01 05:20:37', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b1187c9fee2', 'asd', '28.0000', 0, '2023-01-01 05:22:04', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b118d1e972b', 'cvx', '29.0000', 0, '2023-01-01 05:23:29', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b119ba84866', 'asd', '30.0000', 0, '2023-01-01 05:27:22', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b11b8910e7d', 'asd', '31.0000', 0, '2023-01-01 05:35:05', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b11bc18c9ca', 'asd', '32.0000', 0, '2023-01-01 05:36:01', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b11be07b5ed', 'asd', '33.0000', 0, '2023-01-01 05:36:32', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b11c2f4cd31', 'asd', '34.0000', 0, '2023-01-01 05:37:51', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b11c4e1d740', 'asd', '35.0000', 0, '2023-01-01 05:38:22', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b11c7d57916', 'asd', '36.0000', 0, '2023-01-01 05:39:09', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b11dc454931', 'Sample task', '37.0000', 0, '2023-01-01 05:44:36', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b11f48689a4', 'ad', '38.0000', 0, '2023-01-01 05:51:04', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b14b0336830', 'New Activity', '39.0000', 0, '2023-01-01 08:57:39', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b14b5069833', 'New Activity', '40.0000', 0, '2023-01-01 08:58:56', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b14ba39a6dd', 'New Activity', '41.0000', 0, '2023-01-01 09:00:19', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15413606b6', 'Bago to', '42.0000', 0, '2023-01-01 09:36:19', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b154139ad45', 'Bago to', '43.0000', 0, '2023-01-01 09:36:19', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15413ad0c2', 'Bago to', '44.0000', 0, '2023-01-01 09:36:19', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b1542e583fa', 'Try nga ulit', '45.0000', 0, '2023-01-01 09:36:46', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15c75c8277', 'Sa pa talaga', '46.0000', 0, '2023-01-01 10:12:05', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15cf3cac55', 'Try ulit', '47.0000', 0, '2023-01-01 10:14:11', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15d65b825a', 'bat may response ', '48.0000', 0, '2023-01-01 10:16:05', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15d65e7481', 'bat may response ', '49.0000', 0, '2023-01-01 10:16:05', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15d9403a02', 'ahh sa taskbar', '50.0000', 0, '2023-01-01 10:16:52', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15d9437720', 'ahh sa taskbar', '51.0000', 0, '2023-01-01 10:16:52', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15d944db78', 'ahh sa taskbar', '52.0000', 0, '2023-01-01 10:16:52', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15f2a08da2', 'asd', '53.0000', 0, '2023-01-01 10:23:38', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15f2a26940', 'asd', '54.0000', 0, '2023-01-01 10:23:38', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b15fc40fa45', 'assdddd', '55.0000', 0, '2023-01-01 10:26:12', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b16a65a6381', 'aaa', '56.0000', 0, '2023-01-01 11:11:33', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b16ebb86bd2', 'asd', '57.0000', 0, '2023-01-01 11:30:03', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b1707a17f00', 'asd', '58.0000', 0, '2023-01-01 11:37:30', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b17229a06ea', 'aaassdd', '59.0000', 0, '2023-01-01 11:44:41', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63b17265e750d', 'Task 1.0', '1.0000', 0, '2023-01-01 11:45:41', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b1727e5a8d5', 'Task 2', '2.0000', 0, '2023-01-01 11:46:06', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b172addffbb', 'Task 3', '3.0000', 0, '2023-01-01 11:46:53', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b172cfa1f68', 'Task 4', '4.0000', 0, '2023-01-01 11:47:27', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b172de56682', 'Task 5', '5.0000', 0, '2023-01-01 11:47:42', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b1d3d6e3163', 'Task 6', '6.0000', 0, '2023-01-01 18:41:26', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b1d4032b547', 'Task 7', '7.0000', 0, '2023-01-01 18:42:11', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b1dbe513559', 'Task 8', '8.0000', 0, '2023-01-01 19:15:49', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b3cbf219290', 'New task', '9.0000', 0, '2023-01-03 06:32:18', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b3cd00a5469', 'Another task', '10.0000', 0, '2023-01-03 06:36:48', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b3cd9877c88', 'Try reload', '11.0000', 0, '2023-01-03 06:39:20', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b3d0cd5ecec', 'Isa pang reload', '12.0000', 0, '2023-01-03 06:53:01', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b3f26b89047', 'Bago', '13.0000', 0, '2023-01-03 09:16:27', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b3f29d2b0c9', 'Isa pa bago', '14.0000', 0, '2023-01-03 09:17:17', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b3f2d2bed58', 'Bago ulit', '15.0000', 0, '2023-01-03 09:18:10', 1, 'PTRCN-PRJCT-63ae55283c6d9'),
('PTRCN-TSK-63b3fe4123497', 'Procurement ', '1.0000', 0, '2023-01-03 10:06:57', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63b3fe50eb350', 'Tool Box Meeting', '2.0000', 0, '2023-01-03 10:07:12', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63b3fe5d789e7', 'Actual visit at site for measurement', '3.0000', 0, '2023-01-03 10:07:25', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63b3fe678dbed', 'Mobilization', '4.0000', 0, '2023-01-03 10:07:35', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63b407be1a77e', 'Repainting of pipe', '5.0000', 0, '2023-01-03 10:47:26', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63b407c9012a8', 'Relocation of 2\" Distribution line from Handyman\'s area (removal and Reinstall with 55 meter located at Upper ground)', '6.0000', 0, '2023-01-03 10:47:37', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63b7a3aebc421', 'Task 7', '7.0000', 0, '2023-01-06 04:29:34', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63b8f2a63a9d9', 'Another task', '8.0000', 0, '2023-01-07 04:18:46', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63bb7ca53a374', 'Test', '1.0000', 0, '2023-01-09 02:32:05', 1, 'PTRCN-PRJCT-63bb7b72d1508'),
('PTRCN-TSK-63bb7ee35a136', 'Test ', '9.0000', 0, '2023-01-09 02:41:39', 1, 'PTRCN-PRJCT-63b3fe007bde1'),
('PTRCN-TSK-63bc489db00e9', 'Test', '1.0000', 0, '2023-01-09 17:02:21', 1, 'PTRCN-PRJCT-63bc1cdd12b27'),
('PTRCN-TSK-63bc5ef3aa3bb', 'Test 2', '2.0000', 0, '2023-01-09 18:37:39', 1, 'PTRCN-PRJCT-63bc1cdd12b27'),
('sampID', 'Task 1', '1.0000', 0, '2022-12-25 14:00:03', 1, 'PTRCN-PRJCT-63a613bd48f75');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_taskbar`
--

CREATE TABLE `tbl_taskbar` (
  `id` varchar(100) NOT NULL,
  `task_id` varchar(100) NOT NULL,
  `leg_id` varchar(100) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_taskbar`
--

INSERT INTO `tbl_taskbar` (`id`, `task_id`, `leg_id`, `start`, `end`, `created_at`, `active`) VALUES
('PTRCN-TSKBR-63a8c6f27d863', 'PTRCN-TSK-63a8c6f27d06b', 'PTRCN-LGND-63a8b223e5724', '2022-12-07 00:00:00', '2022-12-08 00:00:00', '2022-12-25 21:56:02', 1),
('PTRCN-TSKBR-63a8c6fb845ad', 'PTRCN-TSK-63a8c6fb83dc3', 'PTRCN-LGND-63a8b223e5724', '2022-12-08 00:00:00', '2022-12-09 00:00:00', '2022-12-25 21:56:11', 1),
('PTRCN-TSKBR-63a8fe7cb9852', 'PTRCN-TSK-63a8fe7cb39ca', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-27 00:00:00', '2022-12-26 01:53:00', 1),
('PTRCN-TSKBR-63a91767130eb', 'PTRCN-TSK-63a91767127ee', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-29 00:00:00', '2022-12-26 03:39:19', 1),
('PTRCN-TSKBR-63aa0f0bc47ac', 'PTRCN-TSK-63aa0f0bbfd9b', 'PTRCN-LGND-63a8b223e5724', '2022-12-28 00:00:00', '2022-12-28 00:00:00', '2022-12-26 21:15:56', 1),
('PTRCN-TSKBR-63aa0f50de442', 'PTRCN-TSK-63aa0f50ddad5', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:17:05', 1),
('PTRCN-TSKBR-63aa0f5f16e1d', 'PTRCN-TSK-63aa0f5f16759', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:17:19', 1),
('PTRCN-TSKBR-63aa103f8e86d', 'PTRCN-TSK-63aa103f8dc53', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:21:03', 1),
('PTRCN-TSKBR-63aa12b874b3d', 'PTRCN-TSK-63aa12b874058', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:31:36', 1),
('PTRCN-TSKBR-63aa13093a13e', 'PTRCN-TSK-63aa1309398af', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:32:57', 1),
('PTRCN-TSKBR-63aa130e08214', 'PTRCN-TSK-63aa130e0797c', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:33:02', 1),
('PTRCN-TSKBR-63aa1313e24b4', 'PTRCN-TSK-63aa1313e1903', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:33:08', 1),
('PTRCN-TSKBR-63aa131c08b6b', 'PTRCN-TSK-63aa131c08148', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:33:16', 1),
('PTRCN-TSKBR-63aa1321cd645', 'PTRCN-TSK-63aa1321ccc41', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:33:22', 1),
('PTRCN-TSKBR-63aa1330eafe4', 'PTRCN-TSK-63aa1330ea4d6', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:33:37', 1),
('PTRCN-TSKBR-63aa1343e7976', 'PTRCN-TSK-63aa1343e6d47', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:33:56', 1),
('PTRCN-TSKBR-63aa13507340f', 'PTRCN-TSK-63aa135072d5f', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:34:08', 1),
('PTRCN-TSKBR-63aa135acb5a6', 'PTRCN-TSK-63aa135acabaa', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:34:18', 1),
('PTRCN-TSKBR-63aa135f982ed', 'PTRCN-TSK-63aa135f97bfa', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:34:23', 1),
('PTRCN-TSKBR-63aa136569f6a', 'PTRCN-TSK-63aa13656951c', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:34:29', 1),
('PTRCN-TSKBR-63aa136c9feff', 'PTRCN-TSK-63aa136c9ba8a', 'PTRCN-LGND-63a8b223e5724', '2022-12-26 00:00:00', '2022-12-26 00:00:00', '2022-12-26 21:34:36', 1),
('PTRCN-TSKBR-63ac433d20c09', 'PTRCN-TSK-63ac433d1ce13', 'PTRCN-LGND-63a8b223e5724', '2022-12-28 00:00:00', '2022-12-28 00:00:00', '2022-12-28 13:23:09', 1),
('PTRCN-TSKBR-63ac53319be2a', 'PTRCN-TSK-63ac53319b61f', 'PTRCN-LGND-63a8b223e5724', '2022-12-28 00:00:00', '2022-12-28 00:00:00', '2022-12-28 14:31:13', 1),
('PTRCN-TSKBR-63b11f488a047', 'PTRCN-TSK-63b11f48689a4', 'PTRCN-LGND-63a8b223e5724', '2023-01-21 00:00:00', '2023-01-18 00:00:00', '2023-01-01 05:51:04', 1),
('PTRCN-TSKBR-63b11f488a04a', 'PTRCN-TSK-63b11f48689a4', 'PTRCN-LGND-63a8b223e573b', '2023-01-06 00:00:00', '2023-01-11 00:00:00', '2023-01-01 05:51:04', 1),
('PTRCN-TSKBR-63b14ba3bfcc6', 'PTRCN-TSK-63b14ba39a6dd', 'PTRCN-LGND-63a8b223e5724', '2023-01-01 00:00:00', '2023-01-02 00:00:00', '2023-01-01 09:00:19', 1),
('PTRCN-TSKBR-63b1541378369', 'PTRCN-TSK-63b15413606b6', 'PTRCN-LGND-63a8b223e5724', '2023-01-19 00:00:00', '2023-01-11 00:00:00', '2023-01-01 09:36:19', 1),
('PTRCN-TSKBR-63b15413a38ae', 'PTRCN-TSK-63b154139ad45', 'PTRCN-LGND-63a8b223e5724', '2023-01-19 00:00:00', '2023-01-11 00:00:00', '2023-01-01 09:36:19', 1),
('PTRCN-TSKBR-63b15413b6891', 'PTRCN-TSK-63b15413ad0c2', 'PTRCN-LGND-63a8b223e5724', '2023-01-19 00:00:00', '2023-01-11 00:00:00', '2023-01-01 09:36:19', 1),
('PTRCN-TSKBR-63b1542e7f120', 'PTRCN-TSK-63b1542e583fa', 'PTRCN-LGND-63a8b223e5724', '2023-01-21 00:00:00', '2023-01-11 00:00:00', '2023-01-01 09:36:46', 1),
('PTRCN-TSKBR-63b15c75e2236', 'PTRCN-TSK-63b15c75c8277', 'PTRCN-LGND-63a8b223e5724', '2023-01-10 00:00:00', '2023-01-06 00:00:00', '2023-01-01 10:12:05', 1),
('PTRCN-TSKBR-63b15cf3ef62b', 'PTRCN-TSK-63b15cf3cac55', 'PTRCN-LGND-63af584cf176c', '2023-01-19 00:00:00', '2023-01-21 00:00:00', '2023-01-01 10:14:11', 1),
('PTRCN-TSKBR-63b15d65dd7ce', 'PTRCN-TSK-63b15d65b825a', 'PTRCN-LGND-63af559bf355e', '2023-01-05 00:00:00', '2023-01-20 00:00:00', '2023-01-01 10:16:05', 1),
('PTRCN-TSKBR-63b15d65f045e', 'PTRCN-TSK-63b15d65e7481', 'PTRCN-LGND-63af559bf355e', '2023-01-05 00:00:00', '2023-01-20 00:00:00', '2023-01-01 10:16:05', 1),
('PTRCN-TSKBR-63b15d942d3ad', 'PTRCN-TSK-63b15d9403a02', 'PTRCN-LGND-63af558581127', '2023-01-16 00:00:00', '2023-01-20 00:00:00', '2023-01-01 10:16:52', 1),
('PTRCN-TSKBR-63b15d94431a3', 'PTRCN-TSK-63b15d9437720', 'PTRCN-LGND-63af558581127', '2023-01-16 00:00:00', '2023-01-20 00:00:00', '2023-01-01 10:16:52', 1),
('PTRCN-TSKBR-63b15d9456679', 'PTRCN-TSK-63b15d944db78', 'PTRCN-LGND-63af558581127', '2023-01-16 00:00:00', '2023-01-20 00:00:00', '2023-01-01 10:16:52', 1),
('PTRCN-TSKBR-63b15f2a1d3e9', 'PTRCN-TSK-63b15f2a08da2', 'PTRCN-LGND-63ab25aebfe11', '2023-01-14 00:00:00', '2023-01-15 00:00:00', '2023-01-01 10:23:38', 1),
('PTRCN-TSKBR-63b15f2a305a1', 'PTRCN-TSK-63b15f2a26940', 'PTRCN-LGND-63ab25aebfe11', '2023-01-14 00:00:00', '2023-01-15 00:00:00', '2023-01-01 10:23:38', 1),
('PTRCN-TSKBR-63b15fc41b28f', 'PTRCN-TSK-63b15fc40fa45', 'PTRCN-LGND-63a8b223e5724', '2023-01-13 00:00:00', '2023-01-26 00:00:00', '2023-01-01 10:26:12', 1),
('PTRCN-TSKBR-63b16a65b5e5a', 'PTRCN-TSK-63b16a65a6381', 'PTRCN-LGND-63a8b223e5724', '2023-01-05 00:00:00', '2023-01-19 00:00:00', '2023-01-01 11:11:33', 1),
('PTRCN-TSKBR-63b16ebbb7236', 'PTRCN-TSK-63b16ebb86bd2', 'PTRCN-LGND-63a8b223e573b', '2023-01-11 00:00:00', '2023-01-22 00:00:00', '2023-01-01 11:30:03', 1),
('PTRCN-TSKBR-63b1707a319e2', 'PTRCN-TSK-63b1707a17f00', 'PTRCN-LGND-63a8b223e573b', '2023-01-06 00:00:00', '2023-01-24 00:00:00', '2023-01-01 11:37:30', 1),
('PTRCN-TSKBR-63b17229b9034', 'PTRCN-TSK-63b17229a06ea', 'PTRCN-LGND-63ab24780d9b0', '2023-01-06 00:00:00', '2023-01-05 00:00:00', '2023-01-01 11:44:41', 1),
('PTRCN-TSKBR-63b1726601658', 'PTRCN-TSK-63b17265e750d', 'PTRCN-LGND-63ae55283cb11', '2023-01-14 00:00:00', '2023-01-15 00:00:00', '2023-01-01 11:45:42', 1),
('PTRCN-TSKBR-63b1727e75364', 'PTRCN-TSK-63b1727e5a8d5', 'PTRCN-LGND-63ae55283cb18', '2023-01-04 00:00:00', '2023-01-10 00:00:00', '2023-01-01 11:46:06', 1),
('PTRCN-TSKBR-63b172ae115e6', 'PTRCN-TSK-63b172addffbb', 'PTRCN-LGND-63ae55283cb11', '2023-01-11 00:00:00', '2023-01-19 00:00:00', '2023-01-01 11:46:54', 1),
('PTRCN-TSKBR-63b172cfc090c', 'PTRCN-TSK-63b172cfa1f68', 'PTRCN-LGND-63ae55283cb11', '2023-01-13 00:00:00', '2023-02-03 00:00:00', '2023-01-01 11:47:27', 1),
('PTRCN-TSKBR-63b172de7fa0f', 'PTRCN-TSK-63b172de56682', 'PTRCN-LGND-63ae55283cb11', '2023-01-06 00:00:00', '2023-01-18 00:00:00', '2023-01-01 11:47:42', 0),
('PTRCN-TSKBR-63b1d3d712fd8', 'PTRCN-TSK-63b1d3d6e3163', 'PTRCN-LGND-63ae55283cb11', '2023-01-25 00:00:00', '2023-02-02 00:00:00', '2023-01-01 18:41:27', 1),
('PTRCN-TSKBR-63b1d403398be', 'PTRCN-TSK-63b1d4032b547', 'PTRCN-LGND-63ae55283cb11', '2023-01-19 00:00:00', '2023-01-19 00:00:00', '2023-01-01 18:42:11', 1),
('PTRCN-TSKBR-63b1d423270a5', 'PTRCN-TSK-63b17265e750d', 'PTRCN-LGND-63ae55283cb18', '2023-01-17 00:00:00', '2023-01-13 00:00:00', '2023-01-01 18:42:43', 1),
('PTRCN-TSKBR-63b1d483d2f3f', 'PTRCN-TSK-63b17265e750d', 'PTRCN-LGND-63ae55283cb11', '2023-01-29 00:00:00', '2023-02-08 00:00:00', '2023-01-01 18:44:19', 0),
('PTRCN-TSKBR-63b1dbe5224a2', 'PTRCN-TSK-63b1dbe513559', 'PTRCN-LGND-63ae55283cb11', '2023-01-03 00:00:00', '2023-01-04 00:00:00', '2023-01-01 19:15:49', 1),
('PTRCN-TSKBR-63b1e9ad8a88b', 'PTRCN-TSK-63b172cfa1f68', 'PTRCN-LGND-63ae55283cb18', '2023-01-18 00:00:00', '2023-01-18 00:00:00', '2023-01-01 20:14:37', 1),
('PTRCN-TSKBR-63b1e9f531ce9', 'PTRCN-TSK-63b17265e750d', 'PTRCN-LGND-63b1dcc47f6e7', '2023-01-05 00:00:00', '2023-01-19 00:00:00', '2023-01-01 20:15:49', 1),
('PTRCN-TSKBR-63b1eab789ad6', 'PTRCN-TSK-63b17265e750d', 'PTRCN-LGND-63b1eab1dca27', '2023-01-17 00:00:00', '2023-01-05 00:00:00', '2023-01-01 20:19:03', 1),
('PTRCN-TSKBR-63b3cbf235359', 'PTRCN-TSK-63b3cbf219290', 'PTRCN-LGND-63ae55283cb11', '2023-01-04 00:00:00', '2023-01-05 00:00:00', '2023-01-03 06:32:18', 1),
('PTRCN-TSKBR-63b3cd00c908d', 'PTRCN-TSK-63b3cd00a5469', 'PTRCN-LGND-63b1dcc47f6e7', '2023-01-05 00:00:00', '2023-01-13 00:00:00', '2023-01-03 06:36:48', 1),
('PTRCN-TSKBR-63b3cd9893ac4', 'PTRCN-TSK-63b3cd9877c88', 'PTRCN-LGND-63ae55283cb11', '2023-01-02 00:00:00', '2023-01-02 00:00:00', '2023-01-03 06:39:20', 1),
('PTRCN-TSKBR-63b3cd9893aca', 'PTRCN-TSK-63b3cd9877c88', 'PTRCN-LGND-63ae55283cb18', '2023-01-12 00:00:00', '2023-01-25 00:00:00', '2023-01-03 06:39:20', 1),
('PTRCN-TSKBR-63b3cd9893acb', 'PTRCN-TSK-63b3cd9877c88', 'PTRCN-LGND-63ae55283cb11', '2023-01-02 00:00:00', '2023-01-02 00:00:00', '2023-01-03 06:39:20', 1),
('PTRCN-TSKBR-63b3cd9893acd', 'PTRCN-TSK-63b3cd9877c88', 'PTRCN-LGND-63ae55283cb11', '2023-01-02 00:00:00', '2023-01-02 00:00:00', '2023-01-03 06:39:20', 1),
('PTRCN-TSKBR-63b3d0cd78e2f', 'PTRCN-TSK-63b3d0cd5ecec', 'PTRCN-LGND-63ae55283cb11', '2023-01-17 00:00:00', '2023-01-28 00:00:00', '2023-01-03 06:53:01', 1),
('PTRCN-TSKBR-63b3f26b9fd3b', 'PTRCN-TSK-63b3f26b89047', 'PTRCN-LGND-63ae55283cb11', '2023-01-03 00:00:00', '2023-01-05 00:00:00', '2023-01-03 09:16:27', 1),
('PTRCN-TSKBR-63b3f26b9fd40', 'PTRCN-TSK-63b3f26b89047', 'PTRCN-LGND-63ae55283cb18', '2023-01-03 00:00:00', '2023-01-05 00:00:00', '2023-01-03 09:16:27', 1),
('PTRCN-TSKBR-63b3f26b9fd42', 'PTRCN-TSK-63b3f26b89047', 'PTRCN-LGND-63b1dcc47f6e7', '2023-01-05 00:00:00', '2023-01-06 00:00:00', '2023-01-03 09:16:27', 1),
('PTRCN-TSKBR-63b3f29d34b91', 'PTRCN-TSK-63b3f29d2b0c9', 'PTRCN-LGND-63ae55283cb11', '2023-01-05 00:00:00', '2023-01-08 00:00:00', '2023-01-03 09:17:17', 1),
('PTRCN-TSKBR-63b3f29d34b94', 'PTRCN-TSK-63b3f29d2b0c9', 'PTRCN-LGND-63ae55283cb18', '2023-01-05 00:00:00', '2023-01-11 00:00:00', '2023-01-03 09:17:17', 1),
('PTRCN-TSKBR-63b3f29d34b95', 'PTRCN-TSK-63b3f29d2b0c9', 'PTRCN-LGND-63b1dcc47f6e7', '2023-01-12 00:00:00', '2023-01-17 00:00:00', '2023-01-03 09:17:17', 1),
('PTRCN-TSKBR-63b3f2d2e3825', 'PTRCN-TSK-63b3f2d2bed58', 'PTRCN-LGND-63ae55283cb11', '2023-01-18 00:00:00', '2023-01-21 00:00:00', '2023-01-03 09:18:10', 1),
('PTRCN-TSKBR-63b3f2d2e3829', 'PTRCN-TSK-63b3f2d2bed58', 'PTRCN-LGND-63ae55283cb18', '2023-01-21 00:00:00', '2023-01-26 00:00:00', '2023-01-03 09:18:10', 1),
('PTRCN-TSKBR-63b3f2d2e382a', 'PTRCN-TSK-63b3f2d2bed58', 'PTRCN-LGND-63b1dcc47f6e7', '2023-01-27 00:00:00', '2023-01-31 00:00:00', '2023-01-03 09:18:10', 1),
('PTRCN-TSKBR-63b3fe413440f', 'PTRCN-TSK-63b3fe4123497', 'PTRCN-LGND-63b3fe007bff8', '2023-01-03 00:00:00', '2023-01-06 00:00:00', '2023-01-03 10:06:57', 1),
('PTRCN-TSKBR-63b3fe510d554', 'PTRCN-TSK-63b3fe50eb350', 'PTRCN-LGND-63b3fe007bff8', '2023-01-03 00:00:00', '2023-01-06 00:00:00', '2023-01-03 10:07:13', 1),
('PTRCN-TSKBR-63b3fe5da18b9', 'PTRCN-TSK-63b3fe5d789e7', 'PTRCN-LGND-63b3fe007bff8', '2023-01-08 00:00:00', '2023-01-13 00:00:00', '2023-01-03 10:07:25', 1),
('PTRCN-TSKBR-63b3fe67b956a', 'PTRCN-TSK-63b3fe678dbed', 'PTRCN-LGND-63b3fe007bff8', '2023-01-11 00:00:00', '2023-01-13 00:00:00', '2023-01-03 10:07:35', 1),
('PTRCN-TSKBR-63b4076784203', 'PTRCN-TSK-63b3fe50eb350', 'PTRCN-LGND-63b3fe007bffc', '2023-01-03 00:00:00', '2023-01-07 00:00:00', '2023-01-03 10:45:59', 1),
('PTRCN-TSKBR-63b407be3210e', 'PTRCN-TSK-63b407be1a77e', 'PTRCN-LGND-63b3fe007bff8', '2023-01-15 00:00:00', '2023-01-20 00:00:00', '2023-01-03 10:47:26', 1),
('PTRCN-TSKBR-63b407c929188', 'PTRCN-TSK-63b407c9012a8', 'PTRCN-LGND-63b3fe007bff8', '2023-01-22 00:00:00', '2023-01-31 00:00:00', '2023-01-03 10:47:37', 1),
('PTRCN-TSKBR-63b40b5b3728a', 'PTRCN-TSK-63b3fe5d789e7', 'PTRCN-LGND-63b3fe007bffc', '2023-01-08 00:00:00', '2023-01-16 00:00:00', '2023-01-03 11:02:51', 1),
('PTRCN-TSKBR-63b4d07d864f0', 'PTRCN-TSK-63b407c9012a8', 'PTRCN-LGND-63b3fe007bffc', '2023-02-01 00:00:00', '2023-02-07 00:00:00', '2023-01-04 01:03:57', 1),
('PTRCN-TSKBR-63b4d6b462992', 'PTRCN-TSK-63b407c9012a8', 'PTRCN-LGND-63b3fe007bffc', '2023-02-08 00:00:00', '2023-03-07 00:00:00', '2023-01-04 01:30:28', 1),
('PTRCN-TSKBR-63b54045619b7', 'PTRCN-TSK-63b3fe678dbed', 'PTRCN-LGND-63b3fe007bffc', '2023-01-02 00:00:00', '2023-01-13 00:00:00', '2023-01-04 09:00:53', 1),
('PTRCN-TSKBR-63b7a3aed12b7', 'PTRCN-TSK-63b7a3aebc421', 'PTRCN-LGND-63b7a3a59a0f9', '2023-01-01 00:00:00', '2023-01-26 00:00:00', '2023-01-06 04:29:34', 1),
('PTRCN-TSKBR-63b8f2a649b8b', 'PTRCN-TSK-63b8f2a63a9d9', 'PTRCN-LGND-63b3fe007bff8', '2023-01-19 00:00:00', '2023-01-26 00:00:00', '2023-01-07 04:18:46', 1),
('PTRCN-TSKBR-63bb7ca5505a3', 'PTRCN-TSK-63bb7ca53a374', 'PTRCN-LGND-63bb7b72d1620', '2023-01-18 00:00:00', '2023-01-26 00:00:00', '2023-01-09 02:32:05', 1),
('PTRCN-TSKBR-63bb7cf3119ae', 'PTRCN-TSK-63bb7ca53a374', 'PTRCN-LGND-63bb7b72d1623', '2023-01-24 00:00:00', '2023-01-14 00:00:00', '2023-01-09 02:33:23', 1),
('PTRCN-TSKBR-63bb7d63c5ff1', 'PTRCN-TSK-63bb7ca53a374', 'PTRCN-LGND-63bb7d5df393a', '2023-01-11 00:00:00', '2023-01-18 00:00:00', '2023-01-09 02:35:15', 1),
('PTRCN-TSKBR-63bb7ee3753aa', 'PTRCN-TSK-63bb7ee35a136', 'PTRCN-LGND-63b3fe007bff8', '2023-01-11 00:00:00', '2023-01-24 00:00:00', '2023-01-09 02:41:39', 1),
('PTRCN-TSKBR-63bb7f193971f', 'PTRCN-TSK-63bb7ee35a136', 'PTRCN-LGND-63b3fe007bffc', '2023-01-11 00:00:00', '2023-01-20 00:00:00', '2023-01-09 02:42:33', 1),
('PTRCN-TSKBR-63bc489dc8bdc', 'PTRCN-TSK-63bc489db00e9', 'PTRCN-LGND-63bc1cdd12d66', '2023-01-04 00:00:00', '2023-01-05 00:00:00', '2023-01-09 17:02:21', 1),
('PTRCN-TSKBR-63bc5ef3c1164', 'PTRCN-TSK-63bc5ef3aa3bb', 'PTRCN-LGND-63bc1cdd12d66', '2023-01-13 00:00:00', '2023-01-18 00:00:00', '2023-01-09 18:37:39', 1),
('PTRCN-TSKBR-63bc5f02ad341', 'PTRCN-TSK-63bc489db00e9', 'PTRCN-LGND-63bc1cdd12d6a', '2023-01-02 00:00:00', '2023-02-01 00:00:00', '2023-01-09 18:37:54', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lnk_project_plan`
--
ALTER TABLE `lnk_project_plan`
  ADD KEY `proj_id` (`proj_id`),
  ADD KEY `leg_id` (`leg_id`);

--
-- Indexes for table `pltbl_account_type`
--
ALTER TABLE `pltbl_account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accLoginID` (`login_id`),
  ADD KEY `accTypeID` (`type_id`),
  ADD KEY `accRegisterID` (`register_id`);

--
-- Indexes for table `tbl_activation`
--
ALTER TABLE `tbl_activation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_accId` (`acc_id`);

--
-- Indexes for table `tbl_client`
--
ALTER TABLE `tbl_client`
  ADD PRIMARY KEY (`clnt_ID`);

--
-- Indexes for table `tbl_legend`
--
ALTER TABLE `tbl_legend`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proj_id` (`proj_id`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_projId` (`proj_id`);

--
-- Indexes for table `tbl_project`
--
ALTER TABLE `tbl_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_register`
--
ALTER TABLE `tbl_register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regLoginID` (`log_ID`);

--
-- Indexes for table `tbl_resource`
--
ALTER TABLE `tbl_resource`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_proj_id` (`proj_id`);

--
-- Indexes for table `tbl_task`
--
ALTER TABLE `tbl_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proj_id` (`proj_id`);

--
-- Indexes for table `tbl_taskbar`
--
ALTER TABLE `tbl_taskbar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_fk` (`task_id`),
  ADD KEY `legend_fk` (`leg_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lnk_project_plan`
--
ALTER TABLE `lnk_project_plan`
  ADD CONSTRAINT `lnk_project_plan_ibfk_1` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lnk_project_plan_ibfk_2` FOREIGN KEY (`leg_id`) REFERENCES `tbl_legend` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD CONSTRAINT `tbl_account_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_account_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `pltbl_account_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_account_ibfk_3` FOREIGN KEY (`register_id`) REFERENCES `tbl_register` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_activation`
--
ALTER TABLE `tbl_activation`
  ADD CONSTRAINT `FK_accId` FOREIGN KEY (`acc_id`) REFERENCES `tbl_account` (`id`);

--
-- Constraints for table `tbl_legend`
--
ALTER TABLE `tbl_legend`
  ADD CONSTRAINT `tbl_legend_ibfk_1` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD CONSTRAINT `FK_projId` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`);

--
-- Constraints for table `tbl_register`
--
ALTER TABLE `tbl_register`
  ADD CONSTRAINT `tbl_register_ibfk_1` FOREIGN KEY (`log_ID`) REFERENCES `tbl_login` (`id`),
  ADD CONSTRAINT `tbl_register_ibfk_2` FOREIGN KEY (`log_ID`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_resource`
--
ALTER TABLE `tbl_resource`
  ADD CONSTRAINT `FK_proj_id` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`);

--
-- Constraints for table `tbl_task`
--
ALTER TABLE `tbl_task`
  ADD CONSTRAINT `tbl_task_ibfk_1` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_taskbar`
--
ALTER TABLE `tbl_taskbar`
  ADD CONSTRAINT `legend_fk` FOREIGN KEY (`leg_id`) REFERENCES `tbl_legend` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_fk` FOREIGN KEY (`task_id`) REFERENCES `tbl_task` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
