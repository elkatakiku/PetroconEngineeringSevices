-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2023 at 09:39 PM
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
('PTRCN-ACCT-63d19cdcea78d', 'PTRCN-PRJCT-63d1743ab8138', '2023-01-25 21:19:25');

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
('PTRCN-TYPE-20221', 'Admin', ''),
('PTRCN-TYPE-20222', 'Employee', ''),
('PTRCN-TYPE-20224', 'Client', ''),
('PTRCN-TYPE-4b9e178f', 'Employee', ''),
('PTRCN-TYPE-c821d24e', 'Admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `pltbl_company`
--

CREATE TABLE `pltbl_company` (
  `id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pltbl_company`
--

INSERT INTO `pltbl_company` (`id`, `name`) VALUES
('123', 'Sample'),
('456', 'Isa pang company');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`id`, `type_id`, `register_id`, `login_id`, `activated`, `created_at`) VALUES
('PTRCN-ACCT-638e56ea9b617', 'PTRCN-TYPE-c821d24e', 'PTRCN-RGSTR-638e56ea9b610', 'PTRCN-USR-638e56ea86b8c', 1, '2023-01-26 10:00:20'),
('PTRCN-ACCT-63d19cdcea78d', 'PTRCN-TYPE-18c19c59', 'PTRCN-RGSTR-63d19cdcea275', 'PTRCN-USR-63d19cdccf288', 0, '2023-01-26 10:00:40');

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
-- Table structure for table `tbl_client`
--

CREATE TABLE `tbl_client` (
  `id` varchar(100) NOT NULL,
  `company_id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_client`
--

INSERT INTO `tbl_client` (`id`, `company_id`, `name`, `contact`, `email`, `active`, `last_update`) VALUES
('123', '123', 'Sample', '123', '123', 1, '2023-01-25 11:37:35'),
('456', '456', 'El Katakiku', '09123456789', 'lamzonelizer1@gmail.com', 1, '2023-01-25 16:10:04');

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
('PTRCN-INVTTN-63d19573ced7f', 'Lamzon, Eli V.', 'elkatakiku@gmail.com', '87d1133a87d6c6df71c684d51ea9af3ac8b2daab86bce662c4e9583bf8f7d978', 'PTRCN-PRJCT-63d1743ab8138', 1, '2023-01-25 20:47:50', 'PTRCN-TYPE-18c19c59', 'Lamzon_96f1', 'f132d726');

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
('PTRCN-USR-63d19cdccf288', 'Lamzon_96f1', '$2y$10$jV0JAKYOfidvV49or2.j0uKOeTDed2dN11pnpOAAlx2JURWt.IOYG');

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
('PTRCN-PYMNT-63be88b770c1f', 'asd', 123.0000, '2023-01-11 10:46:27', 'PTRCN-PRJCT-63bc1cdd12b27', 1),
('PTRCN-PYMNT-63be88f2ade15', 'asd', 123.0000, '2023-01-11 10:46:31', 'PTRCN-PRJCT-63bc1cdd12b27', 1),
('PTRCN-PYMNT-63be890299fa1', 'test', 3214.0000, '2023-01-11 10:46:36', 'PTRCN-PRJCT-63bc1cdd12b27', 1);

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
('PTRCN-PRJCT-63bc1cdd12b27', 'Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stubouts at 2F and UGF.', 'Test', 'Test', 1, 1, '20221526', '2023-01-18 00:00:00', 'Pheonix Inc.', 'Test', 'Test', '2023-01-26 19:16:15'),
('PTRCN-PRJCT-63d1743ab8138', 'Sample', 'Samin', '32 A654asd6 654asd', 0, 1, '3216545', '2023-01-20 00:00:00', 'Elkatakiku', 'Yeah Yeah Yeah', '0912345789', '2023-01-25 18:26:02');

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
('PTRCN-RGSTR-63d19cdcea275', '', '', '', '', '2023-01-26', 'elkatakiku@gmail.com', 'PTRCN-USR-63d19cdccf288', '');

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
('PTRCN-RSRC-63bc48b9bfad9', 'ads', 12, 4343.0000, 52116.0000, 'It goes every where i go', 'PTRCN-PRJCT-63bc1cdd12b27', 1),
('PTRCN-RSRC-63bea3b9e36f1', 'This is the hill i would die on', 23, 22.0000, 506.0000, '3323', 'PTRCN-PRJCT-63bc1cdd12b27', 1),
('PTRCN-RSRC-63c0e35d7efed', 'Reach out', 233, 23.0000, 5359.0000, '', 'PTRCN-PRJCT-63bc1cdd12b27', 1),
('PTRCN-RSRC-63caba5136605', 'Lowkey daw', 23, 2312.0000, 53176.0000, '', 'PTRCN-PRJCT-63bc1cdd12b27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stopage`
--

CREATE TABLE `tbl_stopage` (
  `id` varchar(100) NOT NULL,
  `task_id` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
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
('PTRCN-STPG-63d0fb13a5467', 'PTRCN-TSK-63bc489db00e9', '', '2023-01-27 00:00:00', '2023-01-27 00:00:00', '2023-01-25 09:49:07', '2023-01-26 19:14:18');

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
('PTRCN-TSK-63bc489db00e9', 'Test', '2023-01-15 16:00:00', '2023-01-30 16:00:00', 100, 0, '1.0000', 0, '2023-01-09 17:02:21', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-26 19:16:07'),
('PTRCN-TSK-63bc5ef3aa3bb', 'Test 2', '2023-01-19 16:00:00', '2023-02-23 16:00:00', 100, 0, '2.0000', 0, '2023-01-09 18:37:39', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 20:12:38'),
('PTRCN-TSK-63cfd10656b4a', 'It not a walk in the park', '2023-01-23 16:00:00', '2023-01-23 16:00:00', 50, 0, '3.0000', 0, '2023-01-24 12:37:26', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 19:12:17'),
('PTRCN-TSK-63cfd50059447', 'Take me by the hand', '2023-01-23 16:00:00', '2023-01-31 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 12:54:24', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-26 19:16:15'),
('PTRCN-TSK-63cfd95be46bc', 'Hey its on me in my head', '2023-01-23 16:00:00', '2023-01-26 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 13:12:59', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-26 19:14:24'),
('PTRCN-TSK-63cfd9bbd5c08', 'But it dies and it dies and it dies', '2023-01-23 16:00:00', '2023-01-26 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 13:14:35', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 19:17:18'),
('PTRCN-TSK-63cfd9f628937', 'A drug that only works', '2023-01-23 16:00:00', '2023-02-20 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 13:15:34', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-26 20:10:18'),
('PTRCN-TSK-63cfdb0f60d00', 'dd', '2023-01-10 16:00:00', '2023-01-03 16:00:00', 13, 0, '0.0000', 0, '2023-01-24 13:20:15', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 19:12:34'),
('PTRCN-TSK-63d03d4c994e5', 'Brown guilty eyes', '2023-01-24 16:00:00', '2023-01-26 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 20:19:24', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-24 23:09:44'),
('PTRCN-TSK-63d03dde3e8a7', 'asd', '2023-02-10 16:00:00', '2023-02-15 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 20:21:50', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:47:21'),
('PTRCN-TSK-63d03e7af17c5', 'asd', '2023-02-13 16:00:00', '2023-01-26 16:00:00', 100, 0, '0.0000', 0, '2023-01-24 20:24:26', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:37:24'),
('PTRCN-TSK-63d03eebd7015', 'asdasd', '2023-01-24 16:00:00', '2023-01-26 16:00:00', 100, 0, '9.0000', 0, '2023-01-24 20:26:19', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:37:19'),
('PTRCN-TSK-63d03f6b1cebf', 'Ese', '2023-01-24 16:00:00', '2023-01-27 16:00:00', 100, 0, '10.0000', 0, '2023-01-24 20:28:27', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:47:46'),
('PTRCN-TSK-63d0402bc3ff8', 'sdfgdg', '2023-01-24 16:00:00', '2023-01-26 16:00:00', 100, 0, '11.0000', 0, '2023-01-24 20:31:39', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:43:21'),
('PTRCN-TSK-63d040b35d0c9', 'aaaaa', '2023-01-24 16:00:00', '2023-02-02 16:00:00', 100, 0, '12.0000', 0, '2023-01-24 20:33:55', 0, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-25 10:37:33'),
('PTRCN-TSK-63d040ff7d4a5', 'but i miss screaming and fighting', '2023-01-24 16:00:00', '2023-02-02 16:00:00', 100, 0, '13.0000', 0, '2023-01-24 20:35:11', 1, 'PTRCN-PRJCT-63bc1cdd12b27', '2023-01-26 19:14:30'),
('PTRCN-TSK-63d2dccc726bb', 'Task 1', '2023-01-26 16:00:00', '2023-01-27 16:00:00', 0, 0, '1.0000', 0, '2023-01-26 20:04:28', 1, 'PTRCN-PRJCT-63d1743ab8138', '2023-01-26 20:04:28');

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
-- Indexes for table `pltbl_company`
--
ALTER TABLE `pltbl_company`
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
-- Indexes for table `tbl_client`
--
ALTER TABLE `tbl_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tblClient_company` (`company_id`);

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
-- Constraints for table `tbl_client`
--
ALTER TABLE `tbl_client`
  ADD CONSTRAINT `FK_tblClient_company` FOREIGN KEY (`company_id`) REFERENCES `pltbl_company` (`id`);

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
