-- phpMyAdmin SQL Dump
-- version 5.2.3-1.el10_2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 02, 2026 at 09:33 AM
-- Server version: 10.11.15-MariaDB
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `NP03CS4A240130`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `course` varchar(100) DEFAULT NULL,
  `role` enum('admin','student') DEFAULT 'student',
  `present_days` int(11) DEFAULT 0,
  `last_attendance_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `course`, `role`, `present_days`, `last_attendance_date`, `created_at`) VALUES
(1, 'admin', '$2y$10$0rzv6NvhkbDgwLqOZPSFEOu38VSN4UGgmTRQMQsiK0VEavqmhINOW', 'System Admin', NULL, 'admin', 0, NULL, '2026-02-02 08:17:07'),
(2, 'ezsaksham_7', '$2y$10$fnLmslOGw8isAk0O2moDx.Tbv/LpNtoM592eafy5qV9W9s4wFmu92', 'Saksham Rajkarnikar', 'BIT', 'student', 1, '2026-02-02', '2026-02-02 08:17:41'),
(3, 'zoro', '$2y$10$nffgbH71.ZqmYxB/h7R3j.G6zWlN4W/dUHZEkw1P/VxSie04Qt2k.', 'Roronoa Zoro', 'Geography', 'student', 0, NULL, '2026-02-02 08:42:09'),
(4, 'naruto', '$2y$10$7rLSvRVyTQORbeNTthqG.O6P17ZeJBK9pZ.jLAvK15Zl7YpS.V72G', 'Naruto Uzumaki', 'Ninjutsu 101', 'student', 12, '2023-10-01', '2026-02-02 08:46:27'),
(5, 'luffy', '$2y$10$7rLSvRVyTQORbeNTthqG.O6P17ZeJBK9pZ.jLAvK15Zl7YpS.V72G', 'Monkey D. Luffy', 'Marine Navigation', 'student', 5, '2023-10-02', '2026-02-02 08:46:27'),
(6, 'ichigo', '$2y$10$7rLSvRVyTQORbeNTthqG.O6P17ZeJBK9pZ.jLAvK15Zl7YpS.V72G', 'Ichigo Kurosaki', 'Soul Society History', 'student', 20, '2023-10-01', '2026-02-02 08:46:27'),
(7, 'deku', '$2y$10$7rLSvRVyTQORbeNTthqG.O6P17ZeJBK9pZ.jLAvK15Zl7YpS.V72G', 'Izuku Midoriya', 'Hero Ethics', 'student', 45, '2023-10-02', '2026-02-02 08:46:27'),
(8, 'tanjiro', '$2y$10$7rLSvRVyTQORbeNTthqG.O6P17ZeJBK9pZ.jLAvK15Zl7YpS.V72G', 'Tanjiro Kamado', 'Sword Mastery', 'student', 15, NULL, '2026-02-02 08:46:27'),
(9, 'eren', '$2y$10$7rLSvRVyTQORbeNTthqG.O6P17ZeJBK9pZ.jLAvK15Zl7YpS.V72G', 'Eren Yeager', 'Titan Studies', 'student', 1, '2026-02-02', '2026-02-02 08:46:27'),
(10, 'light', '$2y$10$7rLSvRVyTQORbeNTthqG.O6P17ZeJBK9pZ.jLAvK15Zl7YpS.V72G', 'Light Yagami', 'Law & Justice', 'student', 50, '2023-10-02', '2026-02-02 08:46:27'),
(11, 'saitama', '$2y$10$7rLSvRVyTQORbeNTthqG.O6P17ZeJBK9pZ.jLAvK15Zl7YpS.V72G', 'Saitama', 'Physical Education', 'student', 1, '2023-09-30', '2026-02-02 08:46:27'),
(12, 'kaizer', '$2y$10$3T/HDjX1aBOozqbYgg3A6OzPI9/cFTxBCsLHXVmhuylQO5dT7LvIO', 'Micheal Kaizer', 'Blck', 'student', 0, NULL, '2026-02-02 08:53:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
