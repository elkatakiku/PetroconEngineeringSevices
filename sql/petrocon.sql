-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2022 at 09:54 PM
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
('PTRCN-PRJCT-63a8b223e533c', 'PTRCN-LGND-63a8b223e5724');

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
  `login_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`id`, `type_id`, `register_id`, `login_id`) VALUES
('PTRCN-ACCT-638e56ea9b617', 'PTRCN-TYPE-20221', 'PTRCN-RGSTR-638e56ea9b610', 'PTRCN-USR-638e56ea86b8c'),
('PTRCN-ACCT-638f7d443068f', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-638f7d4430689', 'PTRCN-USR-638f7d441d81e'),
('PTRCN-ACCT-6390b2b8ee631', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-6390b2b8ee625', 'PTRCN-USR-6390b2b8d9892'),
('PTRCN-ACCT-63aca07cd1916', 'PTRCN-TYPE-20224', 'PTRCN-RGSTR-63aca07cd18fe', 'PTRCN-USR-63aca07cbe658');

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_legend`
--

INSERT INTO `tbl_legend` (`id`, `color`, `title`, `proj_id`, `created_at`) VALUES
('PTRCN-LGND-63a882520e05b', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a613bd48f75', '2022-12-26 01:03:14'),
('PTRCN-LGND-63a891ef5decd', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a891ef5dca0', '2022-12-26 02:09:51'),
('PTRCN-LGND-63a891ef5ded7', '#5aac44', 'Actual', 'PTRCN-PRJCT-63a891ef5dca0', '2022-12-26 02:09:51'),
('PTRCN-LGND-63a8b1a628f6b', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a8b1a628b00', '2022-12-26 04:25:10'),
('PTRCN-LGND-63a8b1a628f8b', '#5aac44', 'Actual', 'PTRCN-PRJCT-63a8b1a628b00', '2022-12-26 04:25:10'),
('PTRCN-LGND-63a8b1ca25eca', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a8b1ca25a54', '2022-12-26 04:25:46'),
('PTRCN-LGND-63a8b1ca25edc', '#5aac44', 'Actual', 'PTRCN-PRJCT-63a8b1ca25a54', '2022-12-26 04:25:46'),
('PTRCN-LGND-63a8b223e5724', '#026aa7', 'Plan', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-26 04:27:15'),
('PTRCN-LGND-63a8b223e573b', '#5aac44', 'Actual', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-26 04:27:16'),
('PTRCN-LGND-63ab145fdcd55', '#00aecc', 'Legend 3', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-27 23:50:55'),
('PTRCN-LGND-63ab24780d9b0', '#ef7564', 'Legend 4', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-28 00:59:36'),
('PTRCN-LGND-63ab252cd5a18', '#f5dd29', 'Legend 5', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-28 01:02:36'),
('PTRCN-LGND-63ab25aebfe11', '#ffaf3f', 'Legend 6', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-28 01:04:46'),
('PTRCN-LGND-63ab2635c7067', '#6deca9', 'Legend 7', 'PTRCN-PRJCT-63a8b223e533c', '2022-12-28 01:07:01');

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
('PTRCN-USR-63aca07cbe658', 'asd', '$2y$10$SjtuhylIieY27PSJyFQ74uMBxLplJCGWe2Cb3kPgwiiRIAecY8aKi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_project`
--

CREATE TABLE `tbl_project` (
  `id` varchar(100) NOT NULL,
  `name` longtext NOT NULL,
  `location` varchar(255) NOT NULL,
  `building_number` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `purchase_ord` varchar(100) NOT NULL,
  `award_date` datetime NOT NULL,
  `company` varchar(255) NOT NULL,
  `comp_representative` varchar(255) DEFAULT NULL,
  `comp_contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_project`
--

INSERT INTO `tbl_project` (`id`, `name`, `location`, `building_number`, `status`, `active`, `purchase_ord`, `award_date`, `company`, `comp_representative`, `comp_contact`) VALUES
('PTRCN-PRJCT-63a04ff70fffc', 'Asd', 'Asd', 'Asd', 'done', 1, 'Asd', '2022-12-10 00:00:00', 'Sad', 'Asd', 'sad'),
('PTRCN-PRJCT-63a19b8a06adf', 'Conduct preventive maintenance for gasline from manifold to distribution line up to burnes equipment.', 'Rosario, Batangas', 'Building 1, 2, 3', 'ongoing', 1, '20221526', '2022-12-10 00:00:00', 'Pheonix Inc.', 'Yvana Eunice Magno', '09123456789'),
('PTRCN-PRJCT-63a36bc924707', 'Projects chuchuness', 'Samin', 'Blk 5 Lt 54', '', 1, '20221526', '2022-12-14 00:00:00', 'Elkatakiku', 'Eli', '09123456789'),
('PTRCN-PRJCT-63a6132d67c8d', 'Hekhek', 'Sa Kanila', 'Building 1, 2, 3', '', 1, 'Another Project', '2022-12-01 00:00:00', 'Desteen', 'Effer', '09123456789'),
('PTRCN-PRJCT-63a61364670b1', 'Di ko na alam', 'Jan Lang', 'Building 1, 2, 3', '', 1, 'Isa Pa', '2022-12-17 00:00:00', 'Takahiro', 'Gale', '09123456789'),
('PTRCN-PRJCT-63a613bd48f75', 'Di din alam', 'Sa Moon', 'Building 1, 2, 3', '', 1, 'Isa Pa Nga', '2022-12-17 00:00:00', 'Vanana', 'Yva', '09123456789'),
('PTRCN-PRJCT-63a8870270288', 'Try legend', 'Asdasd', 'Asd', '', 1, '20221526', '2022-12-07 00:00:00', 'Comp', 'Wfwef', '09123456789'),
('PTRCN-PRJCT-63a8879e47f6c', 'Try legend', 'Asdasd', 'Asd', '', 1, '20221526', '2022-12-07 00:00:00', 'Comp', 'Wfwef', '09123456789'),
('PTRCN-PRJCT-63a891ef5dca0', 'Try legend', 'Asdasd', 'Asd', '', 1, '20221526', '2022-12-07 00:00:00', 'Comp', 'Wfwef', '09123456789'),
('PTRCN-PRJCT-63a8b1a628b00', 'Try project plan', 'Sa Tabi', 'Asdasd Dasd54 498', '', 1, '20221555', '2022-12-23 00:00:00', 'Assdfe', 'Fsda Dcv  Wefew', '09123456789'),
('PTRCN-PRJCT-63a8b1ca25a54', 'Try project plan', 'Sa Tabi', 'Asdasd Dasd54 498', '', 1, '20221555', '2022-12-23 00:00:00', 'Assdfe', 'Fsda Dcv  Wefew', '09123456789'),
('PTRCN-PRJCT-63a8b223e533c', 'Isa pa po', 'Otw', '32156 564', '', 1, '20221526', '2022-12-22 00:00:00', 'Elkatakiku', 'Eli', '09123456789');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_register`
--

CREATE TABLE `tbl_register` (
  `id` varchar(100) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
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
('PTRCN-RGSTR-63aca07cd18fe', 'Cooper', 'Bradley', 'D', '09234567891', '2002-07-04', 'email@email.com', 'PTRCN-USR-63aca07cbe658', '');

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
('PTRCN-TSK-63a8c6f27d06b', 'Task 1', '1.0000', 0, '2022-12-25 21:56:02', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63a8c6fb83dc3', 'Task 2', '2.0000', 0, '2022-12-25 21:56:11', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63a8fe7cb39ca', 'Task nito', '3.0000', 0, '2022-12-26 01:53:00', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63a91767127ee', 'Another task nito', '4.0000', 0, '2022-12-26 03:39:19', 1, 'PTRCN-PRJCT-63a8b223e533c'),
('PTRCN-TSK-63aa0f0bbfd9b', 'Task na naman', '5.0000', 0, '2022-12-26 21:15:55', 1, 'PTRCN-PRJCT-63a8b223e533c'),
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
('PTRCN-TSKBR-63ac53319be2a', 'PTRCN-TSK-63ac53319b61f', 'PTRCN-LGND-63a8b223e5724', '2022-12-28 00:00:00', '2022-12-28 00:00:00', '2022-12-28 14:31:13', 1);

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
-- Constraints for table `tbl_legend`
--
ALTER TABLE `tbl_legend`
  ADD CONSTRAINT `tbl_legend_ibfk_1` FOREIGN KEY (`proj_id`) REFERENCES `tbl_project` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_register`
--
ALTER TABLE `tbl_register`
  ADD CONSTRAINT `tbl_register_ibfk_1` FOREIGN KEY (`log_ID`) REFERENCES `tbl_login` (`id`),
  ADD CONSTRAINT `tbl_register_ibfk_2` FOREIGN KEY (`log_ID`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE;

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
