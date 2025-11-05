-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2025 at 03:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `staff_student_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$QQaOiifpMlS3Afju/uD1W.zjHe9TddUjup.XeXXEF6qcUuOzfspza');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `staff_number` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `staff_number`, `address`, `phone`, `password`, `created_at`, `approval_status`) VALUES
(1, 'EZEKIEL EZRA', 'jp1234', 'SAMARU', '1234', '$2y$10$Zwo5SZaPidjni1YkQ0fuEOeeGxMVxD1e/3u0m3R0kBKYm//basdLC', '2025-11-03 12:11:29', 'Rejected'),
(2, 'UMAR KABIR', 'jp1232', 'SAMARU', '07014402671', '$2y$10$ud8/fAlyqh2KjCJ/2lETN.BPvkuiWm89oOlKjb38ZD7DaNszRtzDe', '2025-11-03 12:20:13', 'Pending'),
(3, 'EZEKIEL EZRA', 'jp12345', 'SAMARU', '07056741950', '$2y$10$xWI/wjuEo0nidvA/2nfpGu57ir6V.T43CJW6CRJxbCUZrCNjGUcy.', '2025-11-03 13:28:38', 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `staff_credentials`
--

CREATE TABLE `staff_credentials` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `appointment_letter` varchar(255) DEFAULT NULL,
  `promotion_letter1` varchar(255) DEFAULT NULL,
  `promotion_letter2` varchar(255) DEFAULT NULL,
  `promotion_letter3` varchar(255) DEFAULT NULL,
  `promotion_letter4` varchar(255) DEFAULT NULL,
  `promotion_letter5` varchar(255) DEFAULT NULL,
  `first_degree` varchar(255) DEFAULT NULL,
  `second_degree` varchar(255) DEFAULT NULL,
  `third_degree` varchar(255) DEFAULT NULL,
  `olevel_certificate` varchar(255) DEFAULT NULL,
  `indigent_certificate` varchar(255) DEFAULT NULL,
  `birth_certificate` varchar(255) DEFAULT NULL,
  `confirmation_letter` varchar(255) DEFAULT NULL,
  `regularization_letter` varchar(255) DEFAULT NULL,
  `other_relevant_documents` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_credentials`
--

INSERT INTO `staff_credentials` (`id`, `staff_id`, `appointment_letter`, `promotion_letter1`, `promotion_letter2`, `promotion_letter3`, `promotion_letter4`, `promotion_letter5`, `first_degree`, `second_degree`, `third_degree`, `olevel_certificate`, `indigent_certificate`, `birth_certificate`, `confirmation_letter`, `regularization_letter`, `other_relevant_documents`, `uploaded_at`) VALUES
(1, 1, '1762310090_all chapters.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-05 02:34:50');

-- --------------------------------------------------------

--
-- Table structure for table `staff_rejection_reasons`
--

CREATE TABLE `staff_rejection_reasons` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `rejected_by` varchar(100) DEFAULT NULL,
  `rejected_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_rejection_reasons`
--

INSERT INTO `staff_rejection_reasons` (`id`, `staff_id`, `reason`, `rejected_by`, `rejected_at`) VALUES
(1, 1, 'not a staff', 'admin', '2025-11-05 02:24:08');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `reg_number` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `level` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `reg_number`, `address`, `phone`, `level`, `password`, `created_at`, `approval_status`) VALUES
(1, 'muhammad ibrahim musa', 'HNDSWD/2023/015', 'SAMARU', '1234', 'HND2', '$2y$10$BVW6eRX6QCzhmQIGtGRVAexRRFmUXr6UXicWvRRVEcLMJOW6ezxYO', '2025-11-03 12:09:59', 'Rejected'),
(2, 'AKO GOODLUCK', 'NDCS/2023/001', 'SAMARU', '07014402671', 'ND2', '$2y$10$VYEuLtNqJZwGDMIZUTj/qeTedh2UKoBX1wwisrzDTra6YpP1tLqx2', '2025-11-03 12:19:09', 'Approved'),
(3, 'EZEKIEL EZRA', 'HNDSWD/2023025', 'SAMARU', '07056741950', 'HND1', '$2y$10$WMQL2yZg2F.oCTh4UudDz.16UUXhgqW1U5nzxr.EEUxjwIPj0I1uq', '2025-11-03 13:16:47', 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `student_credentials`
--

CREATE TABLE `student_credentials` (
  `cred_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `indigene_certificate` varchar(255) DEFAULT NULL,
  `primary_certificate` varchar(255) DEFAULT NULL,
  `batch_certificate` varchar(255) DEFAULT NULL,
  `olevel_certificate` varchar(255) DEFAULT NULL,
  `admission_letter` varchar(255) DEFAULT NULL,
  `recommendation_letter` varchar(255) DEFAULT NULL,
  `school_fees_receipt` varchar(255) DEFAULT NULL,
  `consultancy_fees_receipt` varchar(255) DEFAULT NULL,
  `tship_payment_receipt` varchar(255) DEFAULT NULL,
  `departmental_payment_receipt` varchar(255) DEFAULT NULL,
  `upload_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_credentials`
--

INSERT INTO `student_credentials` (`cred_id`, `student_id`, `indigene_certificate`, `primary_certificate`, `batch_certificate`, `olevel_certificate`, `admission_letter`, `recommendation_letter`, `school_fees_receipt`, `consultancy_fees_receipt`, `tship_payment_receipt`, `departmental_payment_receipt`, `upload_date`) VALUES
(1, 1, '1762175791_Chapter 4.docx', NULL, '1762175791_Chapter 4.docx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-03 14:16:31'),
(2, 2, '1762176420_111.pdf', NULL, '1762176420_Chapter 4.docx', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-03 14:27:00'),
(3, 3, '1762179826_20250513_082039.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-03 15:23:46');

-- --------------------------------------------------------

--
-- Table structure for table `student_rejection_reasons`
--

CREATE TABLE `student_rejection_reasons` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `rejected_by` varchar(100) DEFAULT NULL,
  `rejected_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_rejection_reasons`
--

INSERT INTO `student_rejection_reasons` (`id`, `student_id`, `reason`, `rejected_by`, `rejected_at`) VALUES
(1, 3, 'not serious at all', 'admin', '2025-11-05 02:20:04'),
(2, 1, 'unserious element', 'admin', '2025-11-05 02:21:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `staff_number` (`staff_number`);

--
-- Indexes for table `staff_credentials`
--
ALTER TABLE `staff_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `staff_rejection_reasons`
--
ALTER TABLE `staff_rejection_reasons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_credentials`
--
ALTER TABLE `student_credentials`
  ADD PRIMARY KEY (`cred_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_rejection_reasons`
--
ALTER TABLE `student_rejection_reasons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff_credentials`
--
ALTER TABLE `staff_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_rejection_reasons`
--
ALTER TABLE `staff_rejection_reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_credentials`
--
ALTER TABLE `student_credentials`
  MODIFY `cred_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_rejection_reasons`
--
ALTER TABLE `student_rejection_reasons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `staff_credentials`
--
ALTER TABLE `staff_credentials`
  ADD CONSTRAINT `staff_credentials_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `staff_rejection_reasons`
--
ALTER TABLE `staff_rejection_reasons`
  ADD CONSTRAINT `staff_rejection_reasons_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_credentials`
--
ALTER TABLE `student_credentials`
  ADD CONSTRAINT `student_credentials_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student_rejection_reasons`
--
ALTER TABLE `student_rejection_reasons`
  ADD CONSTRAINT `student_rejection_reasons_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
