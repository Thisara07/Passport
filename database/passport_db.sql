-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2026 at 07:57 AM
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
-- Database: `passport_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Contact_Number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `Email_Address`, `Password`, `Contact_Number`) VALUES
(1, 'admin@gmail.com', '$2y$10$qeXtUMPbMwGlVdBomGvtfeK7J5ZTMHbqlUqrg5/gjNsX2B1nj2YRG', '0705634257');

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `Applicant_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`Applicant_ID`, `Name`, `Email`, `Password`) VALUES
(1, 'Bhagya Sandeepani', 'bhagya@gmail.com', '$2y$10$L4Ih9TZLoPeShrSy0Kim/uhaBMGLQeJlRbJeS0krtC065YvCqOe1y'),
(2, 'Sheyma Mariyam', 'sheyma@gmail.com', '$2y$10$N/gpN.1ww.KgGnG02sJj1Osfg9NDbXioc4r.Uy.q2FsgMM.yw9Kxq'),
(3, 'Sheyma Mariyam', 'sheyma123@gmail.com', '$2y$10$nm9whbA61Gjb9ofQp4r08ecUISm4EfnF4V7Wru84plEYk0TvpFhhW'),
(4, 'Thusini', 'Thusi@gmail.com', '$2y$10$4/6u5ZLNB1CRGF7YIUmTeuQ/PWYI0etaqj4CENIyyWZ4ySPZsn1gy'),
(7, 'Th@ghu', 'Thusini@gmail.com', '$2y$10$DQ8zHRtEew0zWKtLRTkWKuGiLfaVc19ltAVi.DlB0RVQxhaix/h8q');

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `Application_ID` int(11) NOT NULL,
  `Applicant_ID` int(11) DEFAULT NULL,
  `Document_ID` int(11) DEFAULT NULL,
  `Full_Name` varchar(100) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Date_of_Birth` date DEFAULT NULL,
  `Phone_Number` varchar(20) DEFAULT NULL,
  `NIC` varchar(20) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `Street` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `Province` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`Application_ID`, `Applicant_ID`, `Document_ID`, `Full_Name`, `Gender`, `Date_of_Birth`, `Phone_Number`, `NIC`, `Address`, `Street`, `City`, `Province`) VALUES
(2, NULL, 692177, 'Bhagya Sandeepani', 'Female', '2004-02-03', '0740487285', NULL, '24/2', 'viharamawatha', 'kandy', 'central province'),
(3, NULL, 692178, 'Thusini', 'Female', '2025-11-06', '1792016289', NULL, '24/2', 'viharamawatha', 'kandy', 'central province'),
(4, NULL, 692179, 'sheyma mariyam', 'Female', '2025-12-31', '0765432245', NULL, '195 Central Market, Kandy', 'katugasthota', 'Kandy', 'central'),
(5, NULL, 23780375, 'Sheyma Rizwan', 'Female', '2026-01-07', '0764532789', NULL, '195 Central Market, Kandy', 'katugasthota', 'Kandy', 'Centrall');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `Appointment_ID` int(11) NOT NULL,
  `Applicant_ID` int(11) DEFAULT NULL,
  `Slot_ID` int(11) DEFAULT NULL,
  `Appointment_Date` date DEFAULT NULL,
  `Appointment_Time` time DEFAULT NULL,
  `NIC_Number` varchar(20) NOT NULL,
  `Office_Branch` varchar(100) DEFAULT NULL,
  `Status` enum('PENDING','APPROVED','CANCELLED') DEFAULT 'PENDING',
  `Cancel_Reason` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`Appointment_ID`, `Applicant_ID`, `Slot_ID`, `Appointment_Date`, `Appointment_Time`, `NIC_Number`, `Office_Branch`, `Status`, `Cancel_Reason`) VALUES
(1, NULL, NULL, '2025-11-26', '14:44:00', '', 'Colombo', 'PENDING', NULL),
(2, NULL, NULL, '2025-11-25', '14:00:00', '', 'Kandy', 'PENDING', NULL),
(4, 3, NULL, '2030-03-24', '00:30:00', '123456799', 'Kandy', 'PENDING', NULL),
(6, 3, NULL, '2025-03-31', '00:30:00', '1234456677v', 'Kandy', 'PENDING', NULL),
(7, 3, NULL, '2025-11-27', '15:00:00', '998877665', 'Galle', 'PENDING', NULL),
(8, 3, NULL, '2024-02-12', '16:39:00', '8899223921', 'Kandy', 'PENDING', NULL),
(9, 3, 3, '2025-04-12', '17:44:00', '6738111451112', 'Galle', 'PENDING', NULL),
(10, 3, NULL, '2025-11-11', '17:02:00', '561278451671', 'Colombo', 'PENDING', NULL),
(15, 3, NULL, '2026-01-07', '00:12:00', '7238940623874', 'Kandy', 'PENDING', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `Document_ID` int(11) NOT NULL,
  `NIC_card` varchar(50) DEFAULT NULL,
  `Birth_Certificate` varchar(50) DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `verification_status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`Document_ID`, `NIC_card`, `Birth_Certificate`, `Nationality`, `Photo`, `verification_status`) VALUES
(16789, '56219756479', 'sabndjlasb', 'sinhaleese', 'djakslb', 'rejected'),
(692176, '692176d50e381.png', '692176d50e699.png', 'Not specified', '692176d50e95f.png', 'approved'),
(692177, '69217755d3206.png', '69217755d352d.png', NULL, '69217755d3816.png', 'approved'),
(692178, '6922c60361ea4.png', '6922c6036247a.png', NULL, '6922c60362afb.png', 'rejected'),
(692179, '6957d22aadb0b.jpg', '6957d22aae1d5.pdf', NULL, '6957d22aaecc2.jpg', 'approved'),
(692180, '12784579324576', '1`28791306123', 'tamil', '6130867218tgs', 'pending'),
(692181, '23780463782', '621780467824', 'Sinhalese', '12y894312ruewdqh', 'pending'),
(692182, '87923567085323', '273849086329783', 'Sinhaleese', 'sjkdl7283946', 'rejected'),
(692183, '84305673864', '2687064', 'Muslim', 'y3289-ywhdja', 'approved'),
(23780374, 'ghaslDG721321', '3789210EYHWQNSMA', 'Sinhaleese', 'sajklfo672389', 'approved'),
(23780375, 'doc_6958ba118644b5.65995896.jpg', 'doc_6958ba1187ab80.78108586.pdf', 'Centrall', 'doc_6958ba1188d7b4.04822160.jpg', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `officer`
--

CREATE TABLE `officer` (
  `Officer_ID` int(11) NOT NULL,
  `Full_Name` varchar(100) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Contact_Number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passport`
--

CREATE TABLE `passport` (
  `Passport_ID` int(11) NOT NULL,
  `Officer_ID` int(11) DEFAULT NULL,
  `Application_ID` int(11) DEFAULT NULL,
  `Passport_Status` varchar(50) DEFAULT NULL,
  `Issue_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Application_ID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Payment_Status` varchar(50) DEFAULT NULL,
  `Payment_Method` varchar(50) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `Slot_ID` int(11) NOT NULL,
  `Slot_Date` date NOT NULL,
  `Start_Time` time NOT NULL,
  `End_Time` time NOT NULL,
  `Office_Branch` varchar(100) NOT NULL,
  `Max_Capacity` int(11) NOT NULL,
  `Current_Bookings` int(11) DEFAULT 0,
  `Status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`Slot_ID`, `Slot_Date`, `Start_Time`, `End_Time`, `Office_Branch`, `Max_Capacity`, `Current_Bookings`, `Status`) VALUES
(2, '0000-00-00', '11:49:00', '00:49:00', '', 0, 0, 'ACTIVE'),
(3, '0000-00-00', '15:26:00', '17:26:00', '', 0, 0, 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`Applicant_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`Application_ID`),
  ADD KEY `Applicant_ID` (`Applicant_ID`),
  ADD KEY `Document_ID` (`Document_ID`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`Appointment_ID`),
  ADD KEY `appointment_ibfk_1` (`Applicant_ID`),
  ADD KEY `fk_appointment_slot` (`Slot_ID`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`Document_ID`);

--
-- Indexes for table `officer`
--
ALTER TABLE `officer`
  ADD PRIMARY KEY (`Officer_ID`);

--
-- Indexes for table `passport`
--
ALTER TABLE `passport`
  ADD PRIMARY KEY (`Passport_ID`),
  ADD KEY `Officer_ID` (`Officer_ID`),
  ADD KEY `Application_ID` (`Application_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Application_ID` (`Application_ID`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`Slot_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `Applicant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `Application_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `Appointment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `Document_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23780376;

--
-- AUTO_INCREMENT for table `officer`
--
ALTER TABLE `officer`
  MODIFY `Officer_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passport`
--
ALTER TABLE `passport`
  MODIFY `Passport_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `Slot_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`Applicant_ID`) REFERENCES `applicant` (`Applicant_ID`),
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`Document_ID`) REFERENCES `documents` (`Document_ID`);

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`Applicant_ID`) REFERENCES `applicant` (`Applicant_ID`),
  ADD CONSTRAINT `fk_appointment_slot` FOREIGN KEY (`Slot_ID`) REFERENCES `time_slots` (`Slot_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `passport`
--
ALTER TABLE `passport`
  ADD CONSTRAINT `passport_ibfk_1` FOREIGN KEY (`Officer_ID`) REFERENCES `officer` (`Officer_ID`),
  ADD CONSTRAINT `passport_ibfk_2` FOREIGN KEY (`Application_ID`) REFERENCES `application` (`Application_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Application_ID`) REFERENCES `application` (`Application_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
