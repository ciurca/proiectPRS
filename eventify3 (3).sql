-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2023 at 12:15 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventify3`
--

-- --------------------------------------------------------

--
-- Table structure for table `bilet`
--

CREATE TABLE `bilet` (
  `ID` int(11) NOT NULL,
  `tip` varchar(50) NOT NULL,
  `pret` decimal(10,2) NOT NULL,
  `IDEveniment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bilet`
--

INSERT INTO `bilet` (`ID`, `tip`, `pret`, `IDEveniment`) VALUES
(1, 'Basic', 100.00, 10),
(2, 'GOLD', 150.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `bilet_individual`
--

CREATE TABLE `bilet_individual` (
  `id` int(11) NOT NULL,
  `IDBilet` int(11) NOT NULL,
  `IDParticipant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bilet_individual`
--

INSERT INTO `bilet_individual` (`id`, `IDBilet`, `IDParticipant`) VALUES
(16, 2, 3),
(17, 1, 3),
(18, 2, 3),
(19, 2, 3),
(20, 2, 3),
(21, 2, 3),
(22, 2, 3),
(23, 2, 3),
(24, 2, 3),
(25, 2, 3),
(26, 2, 3),
(27, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `colaborator`
--

CREATE TABLE `colaborator` (
  `ID` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `tip` varchar(50) NOT NULL,
  `suma` decimal(10,2) DEFAULT NULL,
  `premii` varchar(255) DEFAULT NULL,
  `tip_parteneriat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colaborator`
--

INSERT INTO `colaborator` (`ID`, `nume`, `email`, `telefon`, `tip`, `suma`, `premii`, `tip_parteneriat`) VALUES
(2, ' ', ' fds', 'fds', ' ', 0.00, ' ', ' '),
(3, 'Mega Image', 'mega@image.ro', '03724357', 'GOLD', 10000.00, '1', 'Sponsor');

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `ID` int(11) NOT NULL,
  `NUMAR` varchar(50) NOT NULL,
  `data_semnarii` date NOT NULL,
  `tip` varchar(50) NOT NULL,
  `IDColaborator` int(11) DEFAULT NULL,
  `IDEveniment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`ID`, `NUMAR`, `data_semnarii`, `tip`, `IDColaborator`, `IDEveniment`) VALUES
(1, '23242', '2023-11-08', 'Sponsor', NULL, NULL),
(4, '23242', '2023-11-14', 'Sponsor', 3, 10);

-- --------------------------------------------------------

--
-- Table structure for table `eveniment`
--

CREATE TABLE `eveniment` (
  `ID` int(11) NOT NULL,
  `titlu` varchar(100) NOT NULL,
  `descriere` text DEFAULT NULL,
  `data_inceput` date NOT NULL,
  `data_sfarsit` date NOT NULL,
  `agenda` text DEFAULT NULL,
  `locatie` varchar(255) NOT NULL,
  `IDOrganizator` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eveniment`
--

INSERT INTO `eveniment` (`ID`, `titlu`, `descriere`, `data_inceput`, `data_sfarsit`, `agenda`, `locatie`, `IDOrganizator`) VALUES
(9, 'Untold 2024', 'UNTOLDDDDDD', '2023-10-31', '2023-11-22', 'sdafsd', 'Cluj-Napoca', 1),
(10, 'Untold 2024', 'Untold Festival is the largest electronic music festival held in Romania, taking place in Cluj-Napoca at the Cluj Arena. It is held annually and has been designated Best Major Festival in the European Festival Awards 2015. Guests come from a vast range of European countries, as well as Asia and North', '2023-10-30', '2015-01-18', 'fsdafsd', 'Cluj-Napoca', 2),
(15, 'Zacusca de Arta', 'fsdaf', '2023-11-26', '2023-11-29', 'sadfsdf', 'fdsa', 3),
(16, 'fasdfs', 'rkuehuiui', '2023-11-10', '2023-11-22', 'oropweiropidport', 'oikertopipeoit', 2);

-- --------------------------------------------------------

--
-- Table structure for table `istoric_comenzi`
--

CREATE TABLE `istoric_comenzi` (
  `id` int(11) NOT NULL,
  `IDBilet` int(11) NOT NULL,
  `IDClient` int(11) NOT NULL,
  `cantitate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `istoric_comenzi`
--

INSERT INTO `istoric_comenzi` (`id`, `IDBilet`, `IDClient`, `cantitate`) VALUES
(18, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `organizator`
--

CREATE TABLE `organizator` (
  `ID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `telefon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizator`
--

INSERT INTO `organizator` (`ID`, `email`, `nume`, `parola`, `telefon`) VALUES
(1, 'raduciurca@gmail.com', 'facem', '$2y$10$qiZshzVFH4.y1YOSHISNiO.H3qMxBJAsJ2Uon0h2WwbvG/Pgc9wwW', ''),
(2, 'untold@untold.com', 'Untold', '$2y$10$lzy/MabFpe0/daTeevTojeMCLYl55onKFJ5kveAwPCXwOtWp8jsme', '075277613'),
(3, 'radu@facem.ro', 'Asociatia Facem', '$2y$10$rb1mG8nwRfUYVBIQWOSRBeY4xQCQbMZ5DDuGXsQWTt7kW2e0mUr2y', '0439248');

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `ID` int(11) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `prenume` varchar(50) NOT NULL,
  `poza` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `telefon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`ID`, `nume`, `prenume`, `poza`, `email`, `parola`, `telefon`) VALUES
(1, 'Ciurca', 'Radu', NULL, 'raduciurca@gmail.com', '$2y$10$qiZshzVFH4.y1YOSHISNiO.H3qMxBJAsJ2Uon0h2WwbvG/Pgc9wwW', NULL),
(2, 'Ciurfca', 'fsad', NULL, 'fads@gmail.com', '$2y$10$AKWnE94PIzk4Rk7qCVa/wOXPbpKPIlW/wSfbeuIu5EWTTdQTUSOhK', '423423'),
(3, 'Borsan', 'Alexandra', NULL, 'alexandra.borsan@gmail.com', '$2y$10$2yZX8xg7NiC3lRhzDxIfpeQole.DF6Hx7pc.1U0JNDxVLai.U0Zym', '0752776813');

-- --------------------------------------------------------

--
-- Table structure for table `speaker`
--

CREATE TABLE `speaker` (
  `ID` int(11) NOT NULL,
  `nume` varchar(255) NOT NULL,
  `prenume` varchar(255) NOT NULL,
  `poza` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `IDEveniment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `speaker`
--

INSERT INTO `speaker` (`ID`, `nume`, `prenume`, `poza`, `email`, `telefon`, `IDEveniment`) VALUES
(7, 'radu', 'radu', NULL, 'raduciurca@gmail.com', '+40752776813', 15),
(10, 'radu', 'radu', NULL, 'raduciurca@gmail.com', '+40752776813', 10),
(11, 'radu', 'radu', NULL, 'raduciurca@gmail.com', '+40752776813', 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bilet`
--
ALTER TABLE `bilet`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `bilet_ibfk_1` (`IDEveniment`);

--
-- Indexes for table `bilet_individual`
--
ALTER TABLE `bilet_individual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bilet_fk_id` (`IDBilet`),
  ADD KEY `fk_participant1_id` (`IDParticipant`);

--
-- Indexes for table `colaborator`
--
ALTER TABLE `colaborator`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `contract_ibfk_1` (`IDColaborator`),
  ADD KEY `contract_ibfk_2` (`IDEveniment`);

--
-- Indexes for table `eveniment`
--
ALTER TABLE `eveniment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `eveniment_ibfk_1` (`IDOrganizator`);

--
-- Indexes for table `istoric_comenzi`
--
ALTER TABLE `istoric_comenzi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bilet_id` (`IDBilet`),
  ADD KEY `fk_participant_id` (`IDClient`);

--
-- Indexes for table `organizator`
--
ALTER TABLE `organizator`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `speaker`
--
ALTER TABLE `speaker`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `speaker_ibfk_1` (`IDEveniment`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bilet`
--
ALTER TABLE `bilet`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bilet_individual`
--
ALTER TABLE `bilet_individual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `colaborator`
--
ALTER TABLE `colaborator`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `eveniment`
--
ALTER TABLE `eveniment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `istoric_comenzi`
--
ALTER TABLE `istoric_comenzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `organizator`
--
ALTER TABLE `organizator`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `speaker`
--
ALTER TABLE `speaker`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bilet`
--
ALTER TABLE `bilet`
  ADD CONSTRAINT `bilet_ibfk_1` FOREIGN KEY (`IDEveniment`) REFERENCES `eveniment` (`ID`);

--
-- Constraints for table `bilet_individual`
--
ALTER TABLE `bilet_individual`
  ADD CONSTRAINT `bilet_fk_id` FOREIGN KEY (`IDBilet`) REFERENCES `bilet` (`ID`),
  ADD CONSTRAINT `fk_participant1_id` FOREIGN KEY (`IDParticipant`) REFERENCES `participant` (`ID`);

--
-- Constraints for table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`IDColaborator`) REFERENCES `colaborator` (`ID`),
  ADD CONSTRAINT `contract_ibfk_2` FOREIGN KEY (`IDEveniment`) REFERENCES `eveniment` (`ID`);

--
-- Constraints for table `eveniment`
--
ALTER TABLE `eveniment`
  ADD CONSTRAINT `eveniment_ibfk_1` FOREIGN KEY (`IDOrganizator`) REFERENCES `organizator` (`ID`);

--
-- Constraints for table `istoric_comenzi`
--
ALTER TABLE `istoric_comenzi`
  ADD CONSTRAINT `fk_bilet_id` FOREIGN KEY (`IDBilet`) REFERENCES `bilet` (`ID`),
  ADD CONSTRAINT `fk_participant_id` FOREIGN KEY (`IDClient`) REFERENCES `participant` (`ID`);

--
-- Constraints for table `speaker`
--
ALTER TABLE `speaker`
  ADD CONSTRAINT `speaker_ibfk_1` FOREIGN KEY (`IDEveniment`) REFERENCES `eveniment` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
