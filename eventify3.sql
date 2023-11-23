-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2023 at 02:23 PM
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
(4, 'Full Access', 300.00, 20),
(5, 'Day Ticket', 150.00, 20),
(6, 'VIP', 300.00, 23),
(7, 'Basic', 150.00, 23);

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
(32, 4, 4),
(33, 6, 5),
(34, 6, 5),
(35, 6, 5),
(36, 4, 5),
(37, 5, 5);

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
(3, 'Mega Image', 'mega@image.ro', '03724357', 'GOLD', 10000.00, '1', 'Sponsor'),
(4, 'Csiki Sor', 'csiki@sor.com', '938248423', 'Gold', 10000.00, 'Bere', 'Sponsor');

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
(7, '2352', '2023-11-14', 'Sponsor', 3, 20),
(8, '43243', '2023-12-08', 'Sponsor', 4, 23);

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
(20, 'TED x Cornisa', '&Icirc;n spiritul ideilor care merită să se răsp&acirc;ndească, TEDx este un program de evenimente locale, auto-organizate, care aduce laolaltă oameni dornici să trăiască experiența TED. &Icirc;n cadrul unui eveniment TEDx, talk-urile speakerilor, video-urile TED, momentele de performance se combină pentru a crea o experiență ce va stimula discuții profunde și conexiuni puternice &icirc;ntre participanți.', '2024-05-25', '2024-05-26', '🔴Curajul este un test de caracter. C&acirc;nd avem curaj, arătăm că suntem &icirc;ncrezători și puternici.\r\n🔴Curajul este o super putere, dar atunci c&acirc;nd avem curaj nu suntem super-eroi. Suntem, pur și simplu, noi. Mai buni.\r\n🔴Curajul este despre a ne depăși fricile. Este despre a-ți asuma riscuri, a-ți urma visurile și a-ți trăi viața pe propriile picioare.\r\nCele mai mari recompense vin din &icirc;ncercările noastre cele mai curajoase. Iar deciziile pline de curaj ne duc pe căi pe care nu le-am fi crezut posibile.\r\n🔴La TEDxCornisa avem ocazia să ascultăm poveștile unor oameni curajoși care și-au urmat visurile, au &icirc;nfruntat obstacole și au făcut schimbări semnificative &icirc;n viața lor și pentru lumea noastră.\r\nVom &icirc;nvăța cum să devenim versiunea noastră cea mai curajoasă și autentică.', 'T&acirc;rgu Mureș', 5),
(21, 'TED x Zorilor', '&Icirc;n spiritul ideilor care merită să se răsp&acirc;ndească, TEDx este un program de evenimente locale, auto-organizate, care aduce laolaltă oameni dornici să trăiască experiența TED. &Icirc;n cadrul unui eveniment TEDx, talk-urile speakerilor, video-urile TED, momentele de performance se combină pentru a crea o experiență ce va stimula discuții profunde și conexiuni puternice &icirc;ntre participanți.', '2024-05-18', '2024-05-18', 'Pregătim o zi plină de idei care merită &icirc;mpărtășite, cu 10+ speakeri și performeri! \r\n\r\nAgenda:\r\n\r\n13.00-14.00 &Icirc;nregistrarea participanților\r\n\r\n14.00-15.45 Prima sesiune\r\n\r\n15.45-16.15 Pauză\r\n\r\n16.15-18.00 A doua sesiune\r\n\r\n* Ordinea speaker-ilor vă invităm să o descoperiți la eveniment', 'Cluj-Napoca', 5),
(23, 'Conferința Națională de Turism din Nordul Harghitei', 'Conferința Națională de Turism se adresează at&acirc;t micilor antreprenori și prestatorilor de servicii din domeniul turismului: administratori de pensiuni, restaurante, puncte gastronomice locale, lucrători din centrele de informare turistică, UAT-urilor ,primarilor și consilierilor. Evenimentul va găzdui peste 400 de participanți din toată țara.', '2024-09-07', '2024-09-08', 'Temele generale ce vor fi abordate &icirc;n cadrul conferinței sunt :\r\n\r\nManagementul și marketingul destinației turistice\r\nCe urmăresc turiștii la o destinație turistică\r\nEcoturism &ndash; comportamentul, atitudinea și tendințele de călătorie\r\nTrenduri internaționale &icirc;n turism\r\nPlatforme OTA &ndash; trenduri din industrie\r\nRealizare conținut media cu telefonul.\r\nCircuit turistic &icirc;n zona de nord a județului Harghita\r\nDemersul de &icirc;nființare a punctelor gastronomice locale și alte oportunități cu potențial &icirc;n domeniul turismului\r\nClasificarea unităților de cazare', 'Toplița', 6);

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
(31, 4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `organizator`
--

CREATE TABLE `organizator` (
  `ID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `parola` varchar(255) NOT NULL,
  `telefon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizator`
--

INSERT INTO `organizator` (`ID`, `email`, `username`, `nume`, `parola`, `telefon`) VALUES
(1, 'raduciurca@gmail.com', '', 'facem', '$2y$10$qiZshzVFH4.y1YOSHISNiO.H3qMxBJAsJ2Uon0h2WwbvG/Pgc9wwW', ''),
(2, 'untold@untold.com', 'untold', 'Untold', '$2y$10$lzy/MabFpe0/daTeevTojeMCLYl55onKFJ5kveAwPCXwOtWp8jsme', '075277613'),
(3, 'radu@facem.ro', '', 'Asociatia Facem', '$2y$10$rb1mG8nwRfUYVBIQWOSRBeY4xQCQbMZ5DDuGXsQWTt7kW2e0mUr2y', '0439248'),
(4, 'radu2@facem.ro', 'facem', 'Asociatia Facem', '$2y$10$mUcJauIfiCiQ6rUxvP.mcOvh2JlhxS9VAb4Q63uIRONFLt7o33.r.', '0752776813'),
(5, 'tedx@tedx.com', 'admin1', 'Tedx', '$2y$10$ZYA2TqzBfkArH6Oj4s1Q0uf3CmDJeUMOmdwBUQTxyf.I5yJHd43p.', '0752398755'),
(6, 'visit@toplita.ro', 'admin2', 'Visit Toplita', '$2y$10$43ZwJrropl7ddJJXMCBane8nboaKVtW0ti/JpBJj/Eoy56u56qwaG', '0743523252');

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
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

INSERT INTO `participant` (`ID`, `username`, `nume`, `prenume`, `poza`, `email`, `parola`, `telefon`) VALUES
(1, '', 'Ciurca', 'Radu', NULL, 'raduciurca@gmail.com', '$2y$10$qiZshzVFH4.y1YOSHISNiO.H3qMxBJAsJ2Uon0h2WwbvG/Pgc9wwW', NULL),
(2, '', 'Ciurfca', 'fsad', NULL, 'fads@gmail.com', '$2y$10$AKWnE94PIzk4Rk7qCVa/wOXPbpKPIlW/wSfbeuIu5EWTTdQTUSOhK', '423423'),
(3, '', 'Borsan', 'Alexandra', NULL, 'alexandra.borsan@gmail.com', '$2y$10$2yZX8xg7NiC3lRhzDxIfpeQole.DF6Hx7pc.1U0JNDxVLai.U0Zym', '0752776813'),
(4, 'raduc', 'Ciurca', 'Radu', NULL, 'raduciurca@gmail.com', '$2y$10$3XrKVBFdAF9dad111mjQyOFQoWN5eIRzx7r8kshSkDXxs1Y1hyGAW', '0752776813'),
(5, 'user1', 'Ion', 'Ghita', NULL, 'ion@ghita.com', '$2y$10$sLvCfNrcsRI/3fEuPhmxlur0KiuJJ1FqvxbqT/bBkgFhhi8vxRUuK', '074242375');

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
(12, 'Nartea', 'Adrian', '/static/raduciurca.jpg', 'adrian.nartea@gmail.com', '0744585475', 20),
(13, 'Tarța', 'Sanziana', '/static/raduciurca.jpg', 'tarta.sanziana@gmail.com', '0758554489', 20),
(14, 'Batlan', 'Cristina', '/static/raduciurca.jpg', 'cristina.batlan@gmail.com', '0747556841', 21),
(15, 'Rusu', 'Paula', '/static/raduciurca.jpg', 'paula.rusu@yahoo.com', '0756874412', 21),
(16, 'Berindean', 'Vlad', '/static/berindeanvlad.jpg', 'vlad@berindean.com', '0742377523', 23);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bilet_individual`
--
ALTER TABLE `bilet_individual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `colaborator`
--
ALTER TABLE `colaborator`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `eveniment`
--
ALTER TABLE `eveniment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `istoric_comenzi`
--
ALTER TABLE `istoric_comenzi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `organizator`
--
ALTER TABLE `organizator`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `speaker`
--
ALTER TABLE `speaker`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
