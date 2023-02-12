-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2023 at 09:27 PM
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
-- Table structure for table `lnk_employee_position`
--

CREATE TABLE `lnk_employee_position` (
  `acc_id` varchar(100) NOT NULL,
  `pos_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lnk_project_team`
--

CREATE TABLE `lnk_project_team` (
  `acct_id` varchar(100) NOT NULL,
  `proj_id` varchar(100) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lnk_project_team`
--

INSERT INTO `lnk_project_team` (`acct_id`, `proj_id`, `joined_at`) VALUES
('PTRCN-ACCT-63e9281e417db', 'PTRCN-PRJCT-63bc1cdd12b27', '2023-02-12 17:55:42');

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
('PTRCN-TYPE-18c19c59', 'Client', ''),
('PTRCN-TYPE-4b9e178f', 'Employee', ''),
('PTRCN-TYPE-c821d24e', 'Admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `pltbl_employee_position`
--

CREATE TABLE `pltbl_employee_position` (
  `id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pltbl_employee_position`
--

INSERT INTO `pltbl_employee_position` (`id`, `name`) VALUES
('PTRCN-POSITION-20221', 'Manager'),
('PTRCN-POSITION-20222', 'Finance Officer'),
('PTRCN-POSITION-20223', 'Project Engineer'),
('PTRCN-POSITION-20224', 'Technical, Fire & Protection Equipment'),
('PTRCN-POSITION-20225', 'Piping Foreman'),
('PTRCN-POSITION-20226', 'Admin Officer'),
('PTRCN-POSITION-20227', 'Electrical & Aircon Technician'),
('PTRCN-POSITION-20228', 'Skilled'),
('PTRCN-POSITION-20229', 'Laborer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `id` varchar(100) NOT NULL,
  `type_id` varchar(100) NOT NULL,
  `register_id` varchar(100) NOT NULL,
  `login_id` varchar(100) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`id`, `type_id`, `register_id`, `login_id`, `activated`, `active`, `created_at`) VALUES
('PTRCN-ACCT-638e56ea9b617', 'PTRCN-TYPE-c821d24e', 'PTRCN-RGSTR-638e56ea9b610', 'PTRCN-USR-638e56ea86b8c', 1, 1, '2023-01-26 10:00:20'),
('PTRCN-ACCT-63d19cdcea78d', 'PTRCN-TYPE-18c19c59', 'PTRCN-RGSTR-63d19cdcea275', 'PTRCN-USR-63d19cdccf288', 0, 1, '2023-01-26 10:00:40'),
('PTRCN-ACCT-63e9281e417db', 'PTRCN-TYPE-18c19c59', 'PTRCN-RGSTR-63e9281e41351', 'PTRCN-USR-63e9281e22f2b', 0, 1, '2023-02-12 17:55:42');

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invitation`
--

CREATE TABLE `tbl_invitation` (
  `id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `proj_id` varchar(100) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type_id` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_invitation`
--

INSERT INTO `tbl_invitation` (`id`, `name`, `email`, `code`, `proj_id`, `used`, `created_at`, `type_id`, `username`, `password`) VALUES
('PTRCN-INVTTN-63e3811f87134', 'Yvana Magno', 'magnoyvana@gmail.com', '4a2536f399f59e506a5b037f7eb5c1009610df8c2fe34f6cd2662d0ddd48a21c', 'PTRCN-PRJCT-63e0de30e8055', 0, '2023-02-08 11:02:02', 'PTRCN-TYPE-18c19c59', 'Yvana Magno_5b50', '624df664'),
('PTRCN-INVTTN-63e9280810944', 'Lamzon, Eli', 'lamzonelizer1@gmail.com', '4482994b9195de80807db410cd5f7554bdf6f1e3f2651695bd3372e03e0aa67b', 'PTRCN-PRJCT-63bc1cdd12b27', 1, '2023-02-12 17:55:30', 'PTRCN-TYPE-18c19c59', 'Lamzon_eb5a', 'fd307bda');

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
('PTRCN-USR-63c9389825f73', 'Eli_2166', '$2y$10$QxxHOJvNW/WQtLntfVxMUeyCWYWqRLSpl2dHgVTR6yhi4XrcXZdK6'),
('PTRCN-USR-63cabaefa2cf5', 'el_bb56', '$2y$10$5ub6wVb.OYgQk./7OIU3g.HIyt.tA8FVoU/DC2dLY8tkCWUrJnCEK'),
('PTRCN-USR-63d19cdccf288', 'Lamzon_96f1', '$2y$10$2qqyfzu8m5wfxF0UWfUO8ulBwgcMCs09sm9R4vKIytpVfkxh05cZq'),
('PTRCN-USR-63e9281e22f2b', 'Lamzon_eb5a', '$2y$10$28npLwFRsAHbB7XarEkTiOd5PgZjWd1CLycvWhsTdvNJEoddvrhQe');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `id` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` double(10,4) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `proj_id` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`id`, `description`, `amount`, `sent_at`, `proj_id`, `active`) VALUES
('PTRCN-PYMNT-63be88b770c1f', 'But i wish you were sober', 123.0000, '2023-02-12 16:59:24', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-PYMNT-63be88f2ade15', 'I love you but i just need the night oh', 123.0000, '2023-02-12 16:57:52', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-PYMNT-63be890299fa1', 'its 12:45 in a tuesday', 3214.0000, '2023-01-10 16:00:00', 'PTRCN-PRJCT-63bc1cdd12b27', 1),
('PTRCN-PYMNT-63e911682013d', 'ang we stayed there for hours', 123.0000, '2023-02-12 17:01:58', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-PYMNT-63e91170ccded', 'sample', 322.2600, '2023-02-12 16:50:31', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-PYMNT-63e915b232656', 'I just need the night oh', 1234.0000, '2023-02-12 17:02:37', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-PYMNT-63e9165c7576c', 'waht a time waht a time what a tiem', 123450.2300, '2023-02-12 17:02:42', 'PTRCN-PRJCT-63bc1cdd12b27', 0);

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
  `start` timestamp NOT NULL DEFAULT current_timestamp(),
  `end` timestamp NOT NULL DEFAULT current_timestamp(),
  `company` varchar(255) NOT NULL,
  `comp_representative` varchar(255) DEFAULT NULL,
  `comp_contact` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_project`
--

INSERT INTO `tbl_project` (`id`, `description`, `location`, `building_number`, `done`, `active`, `purchase_ord`, `award_date`, `start`, `end`, `company`, `comp_representative`, `comp_contact`, `created_at`) VALUES
('PTRCN-PRJCT-63bc1cdd12b27', 'Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stubouts at 2F and UGF.', 'Test', 'Test', 1, 1, '20221526', '2023-02-01 00:00:00', '2023-01-01 01:08:57', '2023-01-28 20:46:18', 'Pheonix Inc.', 'Test', '0', '2023-02-09 15:20:34'),
('PTRCN-PRJCT-63e0de30e8055', 'Sample', '312313', '12312', 0, 1, '123123', '2023-02-25 00:00:00', '2023-02-15 16:00:00', '2023-03-01 16:00:00', '1231', '123123', '12312', '2023-02-06 11:02:08'),
('PTRCN-PRJCT-63e39f6665ff1', 'Asdasd', 'Asdsadasd', 'Asdasdas', 0, 1, '3216545', '2023-02-23 00:00:00', '2023-02-28 16:00:00', '2023-06-07 16:00:00', 'Elkatakiku', 'Asdasd', '912345789', '2023-02-08 13:11:02'),
('PTRCN-PRJCT-63e4d688d4c4f', 'Asdasdas', 'Dasdasdasad', 'Dsadasdsad', 0, 1, 'Asadasdadasdasd', '2023-02-13 00:00:00', '2023-02-08 16:00:00', '2025-11-19 16:00:00', 'Asd', 'Asdasd', '912345789', '2023-02-09 11:18:32'),
('PTRCN-PRJCT-63e4ed09e3b7f', 'Asdasdaszxczxczx', 'Dasdasd', 'Asdasdas', 1, 1, 'Adas', '2023-02-09 00:00:00', '2023-02-08 16:00:00', '2023-03-10 16:00:00', 'Asd', 'Asdasd', '912345789', '2023-02-09 13:31:03'),
('PTRCN-PRJCT-63e5001c947fa', 'Adsasd', 'Sadsa', 'Dsadsad', 0, 1, 'Adasda', '2023-02-17 00:00:00', '2023-03-02 16:00:00', '2023-04-07 16:00:00', 'Dasdsad', 'Adsada', '2147483647', '2023-02-09 14:15:56'),
('PTRCN-PRJCT-63e50ca179f20', 'Asdasqqeqwe1', 'Dfsfd', 'Sdfsdf', 0, 1, '123123', '2023-02-24 00:00:00', '2023-02-08 16:00:00', '2023-03-09 16:00:00', 'Elkatakiku', 'Qqweqe', '2147483647', '2023-02-09 15:09:21'),
('PTRCN-PRJCT-63e50eefe64dc', 'Adsa123131', 'Sdasdas', 'Sadsa', 0, 1, '123123', '2023-02-09 00:00:00', '2023-02-08 16:00:00', '2023-03-08 16:00:00', 'Elkatakiku', 'Qweqwe', '9123456789', '2023-02-09 15:19:11');

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
  `log_id` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_register`
--

INSERT INTO `tbl_register` (`id`, `lastname`, `firstname`, `middlename`, `contact_number`, `dob`, `email`, `log_id`, `address`) VALUES
('PTRCN-RGSTR-638e56ea9b610', 'admin', 'admin', 'admin', '09123456789', '2022-12-06', 'admin@email.com', 'PTRCN-USR-638e56ea86b8c', ''),
('PTRCN-RGSTR-63d19cdcea275', 'Lamzon', 'Eli', 'Villabroza', '09123456789', '2023-01-26', 'elkatakiku@gmail.com', 'PTRCN-USR-63d19cdccf288', 'Samin'),
('PTRCN-RGSTR-63e9281e41351', 'Lamzon', ' Eli', '', '', '2023-02-13', 'lamzonelizer1@gmail.com', 'PTRCN-USR-63e9281e22f2b', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reset`
--

CREATE TABLE `tbl_reset` (
  `id` varchar(100) NOT NULL,
  `log_id` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `used` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_reset`
--

INSERT INTO `tbl_reset` (`id`, `log_id`, `created_at`, `used`) VALUES
('PTRCN-RST-63e7e8df1fcd3', 'PTRCN-USR-63d19cdccf288', '2023-02-11 19:13:39', 1),
('PTRCN-RST-63e7eac573605', 'PTRCN-USR-63d19cdccf288', '2023-02-11 19:21:44', 1),
('PTRCN-RST-63e7ec7999326', 'PTRCN-USR-63d19cdccf288', '2023-02-11 19:29:00', 1),
('PTRCN-RST-63e7f0a129024', 'PTRCN-USR-63d19cdccf288', '2023-02-11 19:46:43', 1),
('PTRCN-RST-63e7f55a01b08', 'PTRCN-USR-63d19cdccf288', '2023-02-11 20:06:53', 1);

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
('PTRCN-RSRC-63bc48b9bfad9', 'ads', 12, 4343.0000, 52116.0000, 'It goes every where i go', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-RSRC-63bea3b9e36f1', 'This is the hill i would die on', 23, 22.0000, 506.0000, 'Some use a shield and a knife', 'PTRCN-PRJCT-63bc1cdd12b27', 1),
('PTRCN-RSRC-63c0e35d7efed', 'Reach out', 233, 23.0000, 5359.0000, 'Etorin', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-RSRC-63caba5136605', 'Lowkey daw', 23, 2312.0000, 53176.0000, '', 'PTRCN-PRJCT-63bc1cdd12b27', 1),
('PTRCN-RSRC-63e7947b2f213', 'Next item', 3, 12.0000, 36.0000, 'Wala lang', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-RSRC-63e794d98ca4f', 'ASD', 2, 5.0000, 10.0000, '', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-RSRC-63e794efee90c', 'ass', 25, 5.0000, 125.0000, '', 'PTRCN-PRJCT-63bc1cdd12b27', 0),
('PTRCN-RSRC-63e918b7a3a41', 'asdasd', 2, 5.0000, 10.0000, 'wq2342', 'PTRCN-PRJCT-63bc1cdd12b27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stopage`
--

CREATE TABLE `tbl_stopage` (
  `id` varchar(100) NOT NULL,
  `task_id` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start` datetime NOT NULL DEFAULT current_timestamp(),
  `end` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_stopage`
--

INSERT INTO `tbl_stopage` (`id`, `task_id`, `description`, `start`, `end`, `created_at`, `last_update`) VALUES
('PTRCN-STPG-63cfd1067f56a', 'PTRCN-TSK-63cfd10656b4a', 'La lang', '2023-01-24 00:00:00', '2023-01-27 00:00:00', '2023-01-24 12:37:26', '2023-01-24 12:37:26'),
('PTRCN-STPG-63cfd9f634c36', 'PTRCN-TSK-63cfd9f628937', 'Dont call me kid, dont call me baby', '2023-01-24 00:00:00', '2023-02-04 00:00:00', '2023-01-24 13:15:34', '2023-01-24 13:15:34'),
('PTRCN-STPG-63d0254c3aa96', 'PTRCN-TSK-63cfdb0f60d00', 'Na stop isa', '2023-01-24 00:00:00', '2023-01-26 00:00:00', '2023-01-24 18:37:00', '2023-01-24 18:58:23'),
('PTRCN-STPG-63d025bf4b9be', 'PTRCN-TSK-63cfd9bbd5c08', 'Bago to', '2023-01-24 00:00:00', '2023-02-11 00:00:00', '2023-01-24 18:38:55', '2023-01-24 19:01:51'),
('PTRCN-STPG-63d03d4cb01ee', 'PTRCN-TSK-63d03d4c994e5', 'La lang', '2023-01-24 00:00:00', '2023-01-24 00:00:00', '2023-01-24 20:19:24', '2023-01-24 22:09:42'),
('PTRCN-STPG-63d05a3d808a7', 'PTRCN-TSK-63d03d4c994e5', 'asd', '2023-01-25 00:00:00', '0000-00-00 00:00:00', '2023-01-24 22:22:53', '2023-01-24 22:22:53'),
('PTRCN-STPG-63d05a70d8441', 'PTRCN-TSK-63d03dde3e8a7', '', '2023-01-25 00:00:00', '2023-01-25 00:00:00', '2023-01-24 22:23:44', '2023-01-24 23:11:32'),
('PTRCN-STPG-63d0fb13a5467', 'PTRCN-TSK-63bc489db00e9', 'Isa pa', '2023-01-27 00:00:00', '2023-02-08 20:00:23', '2023-01-25 09:49:07', '2023-02-08 12:00:23'),
('PTRCN-STPG-63d2f1f0578c2', 'PTRCN-TSK-63bc489db00e9', 'Pasahan na', '2023-01-27 00:00:00', '0000-00-00 00:00:00', '2023-01-26 21:34:40', '2023-01-26 21:34:40'),
('PTRCN-STPG-63d2f678db3e4', 'PTRCN-TSK-63cfd95be46bc', 'One step at a time mahabang error', '2023-01-27 00:00:00', '2023-02-08 20:00:26', '2023-01-26 21:54:00', '2023-02-08 12:00:26'),
('PTRCN-STPG-63d2f68189904', 'PTRCN-TSK-63cfd50059447', 'ADS', '2023-01-27 00:00:00', '2023-02-08 20:00:25', '2023-01-26 21:54:09', '2023-02-08 12:00:25'),
('PTRCN-STPG-63e1e258c5ac8', 'PTRCN-TSK-63e112f7c80cf', 'wala lang', '2023-02-07 00:00:00', '2023-02-08 15:16:55', '2023-02-07 05:32:08', '2023-02-08 07:16:55'),
('PTRCN-STPG-63e1e3192780f', 'PTRCN-TSK-63e112f7c80cf', 'asdasdsad', '2023-02-07 00:00:00', '0000-00-00 00:00:00', '2023-02-07 05:35:21', '2023-02-07 05:35:21'),
('PTRCN-STPG-63e1e45892878', 'PTRCN-TSK-63e11306a6552', 'Halt po', '2023-02-07 00:00:00', '0000-00-00 00:00:00', '2023-02-07 05:40:40', '2023-02-07 05:40:40'),
('PTRCN-STPG-63e1ec250f485', 'PTRCN-TSK-63e1d3e762312', 'Tigil po', '2023-02-07 00:00:00', '0000-00-00 00:00:00', '2023-02-07 06:13:57', '2023-02-07 06:13:57'),
('PTRCN-STPG-63e1f0226b2a5', 'PTRCN-TSK-63e112f7c80cf', 'Stop', '2023-02-07 00:00:00', '0000-00-00 00:00:00', '2023-02-07 06:30:58', '2023-02-07 06:30:58'),
('PTRCN-STPG-63e1f1c2b1739', 'PTRCN-TSK-63e11306a6552', 'asd', '2023-02-07 14:37:54', '0000-00-00 00:00:00', '2023-02-07 06:37:54', '2023-02-07 06:37:54'),
('PTRCN-STPG-63e1f238e8b60', 'PTRCN-TSK-63e11306a6552', 'asdasd', '2023-02-07 14:39:52', '0000-00-00 00:00:00', '2023-02-07 06:39:52', '2023-02-07 06:39:52'),
('PTRCN-STPG-63e1f5b139b59', 'PTRCN-TSK-63e11306a6552', 'asdasdsd', '2023-02-07 14:54:41', '0000-00-00 00:00:00', '2023-02-07 06:54:41', '2023-02-07 06:54:41'),
('PTRCN-STPG-63e1f5dd50952', 'PTRCN-TSK-63e11306a6552', 'asdasds', '2023-02-07 14:55:25', '0000-00-00 00:00:00', '2023-02-07 06:55:25', '2023-02-07 06:55:25'),
('PTRCN-STPG-63e1f5fe9b7ee', 'PTRCN-TSK-63e11306a6552', 'asdasdazxcxz', '2023-02-07 14:55:58', '2023-02-07 14:56:02', '2023-02-07 06:55:58', '2023-02-07 06:56:02'),
('PTRCN-STPG-63e34c9b879fa', 'PTRCN-TSK-63e112f7c80cf', 'Stop po', '2023-02-08 15:17:47', '2023-02-08 15:18:09', '2023-02-08 07:17:47', '2023-02-08 07:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task`
--

CREATE TABLE `tbl_task` (
  `id` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp(),
  `end` timestamp NOT NULL DEFAULT current_timestamp(),
  `progress` smallint(6) NOT NULL DEFAULT 0,
  `stopped` tinyint(1) NOT NULL DEFAULT 0,
  `order_no` decimal(10,4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `proj_id` varchar(100) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_task`
--

INSERT INTO `tbl_task` (`id`, `description`, `start`, `end`, `progress`, `stopped`, `order_no`, `status`, `created_at`, `active`, `proj_id`, `last_update`) VALUES
('PTRCN-TSK-63bc489db00e9', 'Test', '2023-01-15 16:00:00', '2023-01-30 16:00:00', 100, 0, '1.0000', 0, '2023-01-09 17:02:21', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-02-12 16:46:22'),
('PTRCN-TSK-63bc5ef3aa3bb', 'Test 2', '2023-01-19 16:00:00', '2023-02-23 16:00:00', 100, 0, '2.0000', 0, '2023-01-09 18:37:39', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 20:12:38'),
('PTRCN-TSK-63cfd10656b4a', 'It not a walk in the park', '2023-01-23 16:00:00', '2023-01-23 16:00:00', 50, 0, '3.0000', 0, '2023-01-24 12:37:26', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 19:12:17'),
('PTRCN-TSK-63cfd50059447', 'Take me by the hand', '2023-01-23 16:00:00', '2023-01-31 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 12:54:24', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-02-08 12:00:37'),
('PTRCN-TSK-63cfd95be46bc', 'Hey its on me in my head', '2023-01-23 16:00:00', '2023-01-26 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 13:12:59', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-02-08 12:00:40'),
('PTRCN-TSK-63cfd9bbd5c08', 'But it dies and it dies and it dies', '2023-01-23 16:00:00', '2023-01-26 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 13:14:35', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 19:17:18'),
('PTRCN-TSK-63cfd9f628937', 'A drug that only works', '2023-01-23 16:00:00', '2023-02-20 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 13:15:34', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-02-12 16:57:05'),
('PTRCN-TSK-63cfdb0f60d00', 'dd', '2023-01-10 16:00:00', '2023-01-03 16:00:00', 13, 0, '0.0000', 0, '2023-01-24 13:20:15', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 19:12:34'),
('PTRCN-TSK-63d03d4c994e5', 'Brown guilty eyes', '2023-01-24 16:00:00', '2023-01-26 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 20:19:24', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-02-12 16:52:13'),
('PTRCN-TSK-63d03dde3e8a7', 'asd', '2023-02-10 16:00:00', '2023-02-15 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 20:21:50', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:47:21'),
('PTRCN-TSK-63d03e7af17c5', 'asd', '2023-02-13 16:00:00', '2023-01-26 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 20:24:26', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:37:24'),
('PTRCN-TSK-63d03eebd7015', 'asdasd', '2023-01-24 16:00:00', '2023-01-26 16:00:00', 100, 0, '9.0000', 0, '2023-01-24 20:26:19', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:37:19'),
('PTRCN-TSK-63d03f6b1cebf', 'Ese', '2023-01-24 16:00:00', '2023-01-27 16:00:00', 100, 0, '10.0000', 0, '2023-01-24 20:28:27', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:47:46'),
('PTRCN-TSK-63d0402bc3ff8', 'sdfgdg', '2023-01-24 16:00:00', '2023-01-26 16:00:00', 100, 0, '11.0000', 0, '2023-01-24 20:31:39', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:43:21'),
('PTRCN-TSK-63d040b35d0c9', 'aaaaa', '2023-01-24 16:00:00', '2023-02-02 16:00:00', 100, 0, '12.0000', 0, '2023-01-24 20:33:55', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:37:33'),
('PTRCN-TSK-63d040ff7d4a5', 'but i miss screaming and fighting', '2023-01-24 16:00:00', '2023-02-02 16:00:00', 100, 0, '13.0000', 0, '2023-01-24 20:35:11', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-26 19:14:30'),
('PTRCN-TSK-63e112f7c80cf', 'Sample Task', '2023-02-15 16:00:00', '2023-02-15 16:00:00', 23, 0, '1.0000', 0, '2023-02-06 14:47:19', 1, 'PTRCN-PRJCT-63e0de30e8055', '2023-02-08 12:01:22'),
('PTRCN-TSK-63e11306a6552', 'Inedit na task', '2023-02-15 16:00:00', '2023-02-16 16:00:00', 30, 0, '2.0000', 0, '2023-02-06 14:47:34', 0, 'PTRCN-PRJCT-63e0de30e8055', '2023-02-08 12:11:43'),
('PTRCN-TSK-63e113182148b', 'Another Task', '2023-02-16 16:00:00', '2023-02-18 16:00:00', 52, 0, '3.0000', 0, '2023-02-06 14:47:52', 1, 'PTRCN-PRJCT-63e0de30e8055', '2023-02-08 11:51:27'),
('PTRCN-TSK-63e1d3e762312', 'A mahabang mahabang textA mahabang mahabang textA mahabang mahabang textA mahabang mahabang textA mahabang mahabang textA mahabang mahabang textA mahabang mahabang textA mahabang mahabang textA mahabang mahabang text Dinagdagang text', '2023-02-19 16:00:00', '2023-02-23 16:00:00', 65, 0, '4.0000', 0, '2023-02-07 04:30:31', 0, 'PTRCN-PRJCT-63e0de30e8055', '2023-02-08 12:10:19'),
('PTRCN-TSK-63e394d482cdb', 'New Task', '2023-02-18 16:00:00', '2023-02-22 16:00:00', 20, 0, '3.0000', 0, '2023-02-08 12:25:56', 1, 'PTRCN-PRJCT-63e0de30e8055', '2023-02-08 12:27:42'),
('PTRCN-TSK-63e4e8275bc95', 'All eyes on us', '2023-02-08 16:00:00', '2023-02-09 16:00:00', 10, 0, '1.0000', 0, '2023-02-09 12:33:43', 0, 'PTRCN-PRJCT-63e4d688d4c4f', '2023-02-09 12:55:00'),
('PTRCN-TSK-63e4ed31de690', 'asd', '2023-02-08 16:00:00', '2023-02-08 16:00:00', 100, 0, '1.0000', 0, '2023-02-09 12:55:13', 1, 'PTRCN-PRJCT-63e4ed09e3b7f', '2023-02-09 13:31:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lnk_project_team`
--
ALTER TABLE `lnk_project_team`
  ADD KEY `FK_lnkProjTeam_Project` (`proj_id`),
  ADD KEY `FK_lnkProjTeam_account` (`acct_id`);

--
-- Indexes for table `pltbl_account_type`
--
ALTER TABLE `pltbl_account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pltbl_employee_position`
--
ALTER TABLE `pltbl_employee_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tblAcct_type` (`type_id`),
  ADD KEY `FK_tblAcct_register` (`register_id`),
  ADD KEY `FK_tblAcct_login` (`login_id`);

--
-- Indexes for table `tbl_activation`
--
ALTER TABLE `tbl_activation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tblActivation_account` (`acc_id`);

--
-- Indexes for table `tbl_invitation`
--
ALTER TABLE `tbl_invitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tblInvitation_project` (`proj_id`),
  ADD KEY `FK_tblInvitation_type` (`type_id`);

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
  ADD KEY `FK_tblPayment_project` (`proj_id`);

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
  ADD KEY `FK_tblReg_logId` (`log_id`);

--
-- Indexes for table `tbl_reset`
--
ALTER TABLE `tbl_reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tblReset_login` (`log_id`);

--
-- Indexes for table `tbl_resource`
--
ALTER TABLE `tbl_resource`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tblResource_project` (`proj_id`);

--
-- Indexes for table `tbl_stopage`
--
ALTER TABLE `tbl_stopage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tblStopage_task` (`task_id`);

--
-- Indexes for table `tbl_task`
--
ALTER TABLE `tbl_task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tblTask_project` (`proj_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lnk_project_team`
--
ALTER TABLE `lnk_project_team`
  ADD CONSTRAINT `FK_lnkProjTeam_Project` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_lnkProjTeam_account` FOREIGN KEY (`acct_id`) REFERENCES `tbl_account` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD CONSTRAINT `FK_tblAcct_login` FOREIGN KEY (`login_id`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tblAcct_register` FOREIGN KEY (`register_id`) REFERENCES `tbl_register` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tblAcct_type` FOREIGN KEY (`type_id`) REFERENCES `pltbl_account_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_activation`
--
ALTER TABLE `tbl_activation`
  ADD CONSTRAINT `FK_tblActivation_account` FOREIGN KEY (`acc_id`) REFERENCES `tbl_account` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_invitation`
--
ALTER TABLE `tbl_invitation`
  ADD CONSTRAINT `FK_tblInvitation_project` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tblInvitation_type` FOREIGN KEY (`type_id`) REFERENCES `pltbl_account_type` (`id`);

--
-- Constraints for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD CONSTRAINT `FK_tblPayment_project` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_register`
--
ALTER TABLE `tbl_register`
  ADD CONSTRAINT `FK_tblReg_logId` FOREIGN KEY (`log_id`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_reset`
--
ALTER TABLE `tbl_reset`
  ADD CONSTRAINT `FK_tblReset_login` FOREIGN KEY (`log_id`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_resource`
--
ALTER TABLE `tbl_resource`
  ADD CONSTRAINT `FK_tblResource_project` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_stopage`
--
ALTER TABLE `tbl_stopage`
  ADD CONSTRAINT `FK_tblStopage_task` FOREIGN KEY (`task_id`) REFERENCES `tbl_task` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_task`
--
ALTER TABLE `tbl_task`
  ADD CONSTRAINT `FK_tblTask_project` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
