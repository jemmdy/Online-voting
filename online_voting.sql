-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 11:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `manifesto` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `position_id`, `name`, `manifesto`, `photo`) VALUES
(9, 6, 'Brian Mwangi', '“Leading with vision, serving all.”', NULL),
(10, 6, 'Alice Ouma', '“Together we rise for change.”', NULL),
(11, 6, 'Kelvin Otieno', '\"Stronger students, brighter future.”', NULL),
(12, 6, 'Faith Njeri', '“Your voice, my daily mission.”', NULL),
(13, 7, 'Daniel Kariuki', '“Committed to support student leadership.”', NULL),
(14, 7, 'Mary Wambui', '“Here to assist and uplift.”', NULL),
(15, 7, 'Peter Kiprotich', '“Dependable support, trusted leadership.”', NULL),
(16, 7, 'Sharon Chebet', '“Your growth, my priority here.”', NULL),
(17, 8, 'Alice Achieng', '“Clear communication, strong unity.”', NULL),
(18, 8, 'Patrick Kimani', '“Every detail, perfectly recorded.”', NULL),
(19, 8, 'Lydia Wanjiku', '“Your voice, well documented.”', NULL),
(20, 8, 'Samuel Muriithi', '“Organized records, organized future.”', NULL),
(21, 9, 'Esther Njoki', '“Supporting documentation with efficiency.”', NULL),
(22, 9, 'Kevin Wachi', '“Reliable in every task.”', NULL),
(23, 9, 'Lucy Chepkorir', '“Assisting for success always.”', NULL),
(24, 9, 'John Kibet', '“Strong support, smooth communication.”', NULL),
(25, 10, 'Mercy Wairimu', '“Trusted to secure your funds.”', NULL),
(26, 10, 'George Mutua', '“Accountability in every coin.”', NULL),
(27, 10, 'Purity Nduta	”', '“Smart budgeting, better future.”', NULL),
(28, 10, 'Eric Oduor', '“Your money, safely managed.”', NULL),
(29, 11, 'Ivy Cherono', '“Assisting in transparent finances.”', NULL),
(30, 11, 'Duncan Mworia', '“Every cent counts with me.”', NULL),
(31, 11, 'Joseph Barasa', '“Dependable in financial matters.”', NULL),
(32, 13, 'Antony Njoroge', '“Order, fairness, student voice.”', NULL),
(33, 13, 'Judith Moraa', '“Guiding assembly with integrity.”', NULL),
(34, 13, 'Brian Ochieng', '“Your voice, properly heard.”', NULL),
(35, 13, 'Grace Chepngeno', '“Balanced debates, fair rulings.”', NULL),
(36, 14, 'Hillary Kipkurui', '“Second in seat, first in duty.”', NULL),
(37, 14, '” Rose Wekesa', '“Supporting fair student debates.”', NULL),
(38, 14, 'Kelvin Karani', '“Assisting assembly with discipline.”', NULL),
(39, 14, 'Eunice Aoko', '“Calm voice, strong support.”', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eligible_students`
--

CREATE TABLE `eligible_students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eligible_students`
--

INSERT INTO `eligible_students` (`id`, `student_id`, `name`) VALUES
(19, 'S1003', 'Ali omar'),
(20, 'S1004', 'John Omoi'),
(21, 'S1005', 'Stephen Nyerere'),
(22, 'S1006', 'Derrick Prince'),
(23, 'S1007', 'omar'),
(24, 'S1008', 'Amos wanjala'),
(25, 'S1009', 'Chalo munene');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `target_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `target_id`, `description`, `created_at`) VALUES
(1, 10, 'Vote Cast', 9, 'Voted for: Brian Mwangi (President)', '2025-10-27 14:29:11'),
(2, 10, 'Vote Cast', 13, 'Voted for: Daniel Kariuki (Vice President)', '2025-10-27 14:29:11'),
(3, 10, 'Vote Cast', 17, 'Voted for: Alice Achieng (Secretary General)', '2025-10-27 14:29:11'),
(4, 10, 'Vote Cast', 21, 'Voted for: Esther Njoki (Deputy Secretary)', '2025-10-27 14:29:11'),
(5, 10, 'Vote Cast', 25, 'Voted for: Mercy Wairimu (Treasurer)', '2025-10-27 14:29:11'),
(6, 10, 'Vote Cast', 29, 'Voted for: Ivy Cherono (Deputy Treasurer)', '2025-10-27 14:29:11'),
(7, 10, 'Vote Cast', 32, 'Voted for: Antony Njoroge (Speaker)', '2025-10-27 14:29:11'),
(8, 10, 'Vote Cast', 36, 'Voted for: Hillary Kipkurui (Deputy Speaker)', '2025-10-27 14:29:11'),
(9, 2, 'Added eligible student', 20, 'student_id: S1004, name: John Omoi', '2025-10-27 14:34:47'),
(10, 1, 'Approved student', 11, 'student_id: S1004, name: John Omoi', '2025-10-27 14:35:42'),
(11, 11, 'Vote Cast', 9, 'Voted for: Brian Mwangi (President)', '2025-10-27 15:01:41'),
(12, 11, 'Vote Cast', 13, 'Voted for: Daniel Kariuki (Vice President)', '2025-10-27 15:01:41'),
(13, 11, 'Vote Cast', 17, 'Voted for: Alice Achieng (Secretary General)', '2025-10-27 15:01:41'),
(14, 11, 'Vote Cast', 21, 'Voted for: Esther Njoki (Deputy Secretary)', '2025-10-27 15:01:41'),
(15, 11, 'Vote Cast', 25, 'Voted for: Mercy Wairimu (Treasurer)', '2025-10-27 15:01:41'),
(16, 11, 'Vote Cast', 29, 'Voted for: Ivy Cherono (Deputy Treasurer)', '2025-10-27 15:01:41'),
(17, 11, 'Vote Cast', 32, 'Voted for: Antony Njoroge (Speaker)', '2025-10-27 15:01:41'),
(18, 11, 'Vote Cast', 36, 'Voted for: Hillary Kipkurui (Deputy Speaker)', '2025-10-27 15:01:41'),
(19, 2, 'Added eligible student', 21, 'student_id: S1005, name: Stephen Nyerere', '2025-11-05 11:48:34'),
(20, 1, 'Approved student', 12, 'student_id: S1005, name: Stephen nyerere', '2025-11-05 11:51:25'),
(21, 12, 'Vote Cast', 10, 'Voted for: Alice Ouma (President)', '2025-11-05 11:53:22'),
(22, 12, 'Vote Cast', 14, 'Voted for: Mary Wambui (Vice President)', '2025-11-05 11:53:22'),
(23, 12, 'Vote Cast', 19, 'Voted for: Lydia Wanjiku (Secretary General)', '2025-11-05 11:53:22'),
(24, 12, 'Vote Cast', 23, 'Voted for: Lucy Chepkorir (Deputy Secretary)', '2025-11-05 11:53:22'),
(25, 12, 'Vote Cast', 25, 'Voted for: Mercy Wairimu (Treasurer)', '2025-11-05 11:53:22'),
(26, 12, 'Vote Cast', 29, 'Voted for: Ivy Cherono (Deputy Treasurer)', '2025-11-05 11:53:22'),
(27, 12, 'Vote Cast', 35, 'Voted for: Grace Chepngeno (Speaker)', '2025-11-05 11:53:22'),
(28, 12, 'Vote Cast', 39, 'Voted for: Eunice Aoko (Deputy Speaker)', '2025-11-05 11:53:22'),
(29, 2, 'Added eligible student', 22, 'student_id: S1006, name: Derrick Prince', '2025-11-05 11:56:43'),
(30, 1, 'Approved student', 13, 'student_id: S1006, name: Derrick Prince', '2025-11-05 11:58:32'),
(31, 13, 'Vote Cast', 10, 'Voted for: Alice Ouma (President)', '2025-11-05 12:00:23'),
(32, 13, 'Vote Cast', 16, 'Voted for: Sharon Chebet (Vice President)', '2025-11-05 12:00:23'),
(33, 13, 'Vote Cast', 19, 'Voted for: Lydia Wanjiku (Secretary General)', '2025-11-05 12:00:23'),
(34, 13, 'Vote Cast', 21, 'Voted for: Esther Njoki (Deputy Secretary)', '2025-11-05 12:00:23'),
(35, 13, 'Vote Cast', 27, 'Voted for: Purity Nduta	” (Treasurer)', '2025-11-05 12:00:23'),
(36, 13, 'Vote Cast', 29, 'Voted for: Ivy Cherono (Deputy Treasurer)', '2025-11-05 12:00:23'),
(37, 13, 'Vote Cast', 33, 'Voted for: Judith Moraa (Speaker)', '2025-11-05 12:00:23'),
(38, 13, 'Vote Cast', 39, 'Voted for: Eunice Aoko (Deputy Speaker)', '2025-11-05 12:00:23'),
(39, 2, 'Added eligible student', 23, 'student_id: S1007, name: omar', '2025-11-05 13:02:24'),
(40, 1, 'Approved student', 14, 'student_id: S1007, name: omar', '2025-11-05 13:03:26'),
(41, 14, 'Vote Cast', 9, 'Voted for: Brian Mwangi (President)', '2025-11-05 13:04:07'),
(42, 14, 'Vote Cast', 13, 'Voted for: Daniel Kariuki (Vice President)', '2025-11-05 13:04:07'),
(43, 14, 'Vote Cast', 17, 'Voted for: Alice Achieng (Secretary General)', '2025-11-05 13:04:07'),
(44, 14, 'Vote Cast', 21, 'Voted for: Esther Njoki (Deputy Secretary)', '2025-11-05 13:04:07'),
(45, 14, 'Vote Cast', 25, 'Voted for: Mercy Wairimu (Treasurer)', '2025-11-05 13:04:07'),
(46, 14, 'Vote Cast', 29, 'Voted for: Ivy Cherono (Deputy Treasurer)', '2025-11-05 13:04:07'),
(47, 14, 'Vote Cast', 32, 'Voted for: Antony Njoroge (Speaker)', '2025-11-05 13:04:07'),
(48, 14, 'Vote Cast', 36, 'Voted for: Hillary Kipkurui (Deputy Speaker)', '2025-11-05 13:04:07'),
(49, 2, 'Added eligible student', 24, 'student_id: S1008, name: Amos wanjala', '2025-11-07 11:52:55'),
(50, 1, 'Approved student', 15, 'student_id: S1008, name: Amos wanjala', '2025-11-07 11:54:03'),
(51, 15, 'Vote Cast', 9, 'Voted for: Brian Mwangi (President)', '2025-11-07 11:55:18'),
(52, 15, 'Vote Cast', 13, 'Voted for: Daniel Kariuki (Vice President)', '2025-11-07 11:55:18'),
(53, 15, 'Vote Cast', 17, 'Voted for: Alice Achieng (Secretary General)', '2025-11-07 11:55:18'),
(54, 15, 'Vote Cast', 21, 'Voted for: Esther Njoki (Deputy Secretary)', '2025-11-07 11:55:18'),
(55, 15, 'Vote Cast', 25, 'Voted for: Mercy Wairimu (Treasurer)', '2025-11-07 11:55:18'),
(56, 15, 'Vote Cast', 29, 'Voted for: Ivy Cherono (Deputy Treasurer)', '2025-11-07 11:55:18'),
(57, 15, 'Vote Cast', 32, 'Voted for: Antony Njoroge (Speaker)', '2025-11-07 11:55:18'),
(58, 15, 'Vote Cast', 36, 'Voted for: Hillary Kipkurui (Deputy Speaker)', '2025-11-07 11:55:18'),
(59, 2, 'Added eligible student', 25, 'student_id: S1009, name: Chalo munene', '2025-11-10 13:18:40'),
(60, 1, 'Approved student', 16, 'student_id: S1009, name: Chalo munene', '2025-11-10 13:46:25');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `description`) VALUES
(6, 'President', 'Leads and represents all students'),
(7, 'Vice President', 'Assists the president in leadership'),
(8, 'Secretary General', 'Manages records and communication.'),
(9, 'Deputy Secretary', 'Supports the secretary’s duties'),
(10, 'Treasurer', 'Handles student funds and budgets'),
(11, 'Deputy Treasurer', 'Assists in financial management'),
(13, 'Speaker', 'Leads student assembly meetings'),
(14, 'Deputy Speaker', 'Assists in assembly leadership');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Pending','Active','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','registrar','student') NOT NULL DEFAULT 'student',
  `has_voted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `name`, `email`, `password`, `is_admin`, `status`, `created_at`, `role`, `has_voted`) VALUES
(1, 'S1001', 'Abdulmajid abdi', 'jemmdy10@gmail.com', '$2y$10$0b.s8hg0boelSqMvgEqbp.NYIdPUbVZmE4nSLHjt66MKg9EZ3yRZ.', 1, 'Active', '2025-10-06 08:51:55', 'admin', 0),
(2, 'S1002', 'Fozia Ali', 'Fozia@gmail.com', '$2y$10$VSkVkjYXB.h5Nf09LcSkd.G9wWBq70yrEW9h99QFg21tbukC.lpNO', 0, 'Active', '2025-10-06 09:11:15', 'registrar', 0),
(10, 'S1003', 'Ali omar', 'Ali@gmail.com', '$2y$10$KKzV5Hpbx2U3R8lzkQc73uPKsMKkT8KvDFDjQV9kiZHSSiDIqoEz2', 0, '', '2025-10-27 09:49:38', 'student', 0),
(11, 'S1004', 'John Omoi', 'John@gmail.com', '$2y$10$sIg52S.VqEkM0el.X3dbP.tWXcII/3anbpUcOsdCb0DlHEGH62y0a', 0, '', '2025-10-27 11:35:33', 'student', 0),
(12, 'S1005', 'Stephen nyerere', 'stev@gmail.com', '$2y$10$t/ZjzD0GLXm3VIGslnYLe.M4AntIF3If3HOtJtse5bGKx5j89b4kS', 0, '', '2025-11-05 08:51:13', 'student', 0),
(13, 'S1006', 'Derrick Prince', 'Derrick@gmail.com', '$2y$10$LvCeErMa7W.uVMgZgS09m.c/Ow7spVqXE6zbiO8XXQGPw4xodsmWq', 0, '', '2025-11-05 08:58:01', 'student', 0),
(14, 'S1007', 'omar', 'omar@gmail.com', '$2y$10$x3e5ySyY7II0W3PUZToCKOJWN/w.pcSW1EKoNhlfrGD2r5NREVLQO', 0, '', '2025-11-05 10:03:18', 'student', 0),
(15, 'S1008', 'Amos wanjala', 'Amos@gmail.com', '$2y$10$tYZTQJ2X4jqfYMItZjwtOuYrdMGYRet5leU6UNFEFIJ3fun3SJIra', 0, '', '2025-11-07 08:53:44', 'student', 0),
(16, 'S1009', 'Chalo munene', 'chalo@gmail.com', '$2y$10$4xt8iBotAUZ8VapNnSMD5OqLKEgW1cDEQGpnwOueHHPvP6vJ8L0/u', 0, '', '2025-11-10 10:19:33', 'student', 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `position_id`, `candidate_id`, `created_at`) VALUES
(15, 10, 6, 9, '2025-10-27 11:29:11'),
(16, 10, 7, 13, '2025-10-27 11:29:11'),
(17, 10, 8, 17, '2025-10-27 11:29:11'),
(18, 10, 9, 21, '2025-10-27 11:29:11'),
(19, 10, 10, 25, '2025-10-27 11:29:11'),
(20, 10, 11, 29, '2025-10-27 11:29:11'),
(21, 10, 13, 32, '2025-10-27 11:29:11'),
(22, 10, 14, 36, '2025-10-27 11:29:11'),
(23, 11, 6, 9, '2025-10-27 12:01:41'),
(24, 11, 7, 13, '2025-10-27 12:01:41'),
(25, 11, 8, 17, '2025-10-27 12:01:41'),
(26, 11, 9, 21, '2025-10-27 12:01:41'),
(27, 11, 10, 25, '2025-10-27 12:01:41'),
(28, 11, 11, 29, '2025-10-27 12:01:41'),
(29, 11, 13, 32, '2025-10-27 12:01:41'),
(30, 11, 14, 36, '2025-10-27 12:01:41'),
(31, 12, 6, 10, '2025-11-05 08:53:22'),
(32, 12, 7, 14, '2025-11-05 08:53:22'),
(33, 12, 8, 19, '2025-11-05 08:53:22'),
(34, 12, 9, 23, '2025-11-05 08:53:22'),
(35, 12, 10, 25, '2025-11-05 08:53:22'),
(36, 12, 11, 29, '2025-11-05 08:53:22'),
(37, 12, 13, 35, '2025-11-05 08:53:22'),
(38, 12, 14, 39, '2025-11-05 08:53:22'),
(39, 13, 6, 10, '2025-11-05 09:00:23'),
(40, 13, 7, 16, '2025-11-05 09:00:23'),
(41, 13, 8, 19, '2025-11-05 09:00:23'),
(42, 13, 9, 21, '2025-11-05 09:00:23'),
(43, 13, 10, 27, '2025-11-05 09:00:23'),
(44, 13, 11, 29, '2025-11-05 09:00:23'),
(45, 13, 13, 33, '2025-11-05 09:00:23'),
(46, 13, 14, 39, '2025-11-05 09:00:23'),
(47, 14, 6, 9, '2025-11-05 10:04:07'),
(48, 14, 7, 13, '2025-11-05 10:04:07'),
(49, 14, 8, 17, '2025-11-05 10:04:07'),
(50, 14, 9, 21, '2025-11-05 10:04:07'),
(51, 14, 10, 25, '2025-11-05 10:04:07'),
(52, 14, 11, 29, '2025-11-05 10:04:07'),
(53, 14, 13, 32, '2025-11-05 10:04:07'),
(54, 14, 14, 36, '2025-11-05 10:04:07'),
(55, 15, 6, 9, '2025-11-07 08:55:18'),
(56, 15, 7, 13, '2025-11-07 08:55:18'),
(57, 15, 8, 17, '2025-11-07 08:55:18'),
(58, 15, 9, 21, '2025-11-07 08:55:18'),
(59, 15, 10, 25, '2025-11-07 08:55:18'),
(60, 15, 11, 29, '2025-11-07 08:55:18'),
(61, 15, 13, 32, '2025-11-07 08:55:18'),
(62, 15, 14, 36, '2025-11-07 08:55:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `position_id` (`position_id`);

--
-- Indexes for table `eligible_students`
--
ALTER TABLE `eligible_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_id_2` (`student_id`,`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`user_id`,`position_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `eligible_students`
--
ALTER TABLE `eligible_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  ADD CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
