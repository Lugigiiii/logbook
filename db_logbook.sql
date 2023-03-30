-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Mrz 2023 um 19:18
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `db_logbook`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `car`
--

CREATE TABLE `car` (
  `pk_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `numberplate` varchar(20) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `locstart`
--

CREATE TABLE `locstart` (
  `pk_id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `location` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ride`
--

CREATE TABLE `ride` (
  `pk_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `car` int(11) NOT NULL,
  `kmStart` int(11) NOT NULL,
  `kmEnd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tsstart`
--

CREATE TABLE `tsstart` (
  `pk_id` int(11) NOT NULL,
  `fk_ride_id` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tsstop`
--

CREATE TABLE `tsstop` (
  `pk_id` int(11) NOT NULL,
  `fk_ride_id` int(11) NOT NULL,
  `timestamp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `pk_id` int(11) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`pk_id`);

--
-- Indizes für die Tabelle `locstart`
--
ALTER TABLE `locstart`
  ADD PRIMARY KEY (`pk_id`),
  ADD KEY `ride_id_locStart` (`ride_id`);

--
-- Indizes für die Tabelle `ride`
--
ALTER TABLE `ride`
  ADD PRIMARY KEY (`pk_id`),
  ADD KEY `user` (`user`),
  ADD KEY `car` (`car`);

--
-- Indizes für die Tabelle `tsstart`
--
ALTER TABLE `tsstart`
  ADD PRIMARY KEY (`pk_id`),
  ADD KEY `ride_id_tsStart` (`fk_ride_id`);

--
-- Indizes für die Tabelle `tsstop`
--
ALTER TABLE `tsstop`
  ADD PRIMARY KEY (`pk_id`),
  ADD KEY `ride_id_tsStop` (`fk_ride_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`pk_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `car`
--
ALTER TABLE `car`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `locstart`
--
ALTER TABLE `locstart`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ride`
--
ALTER TABLE `ride`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tsstart`
--
ALTER TABLE `tsstart`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tsstop`
--
ALTER TABLE `tsstop`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `pk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `locstart`
--
ALTER TABLE `locstart`
  ADD CONSTRAINT `ride_id_locStart` FOREIGN KEY (`ride_id`) REFERENCES `ride` (`pk_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `ride`
--
ALTER TABLE `ride`
  ADD CONSTRAINT `car` FOREIGN KEY (`car`) REFERENCES `car` (`pk_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `user` (`pk_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `tsstart`
--
ALTER TABLE `tsstart`
  ADD CONSTRAINT `ride_id_tsStart` FOREIGN KEY (`fk_ride_id`) REFERENCES `ride` (`pk_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tsstop`
--
ALTER TABLE `tsstop`
  ADD CONSTRAINT `ride_id_tsStop` FOREIGN KEY (`fk_ride_id`) REFERENCES `ride` (`pk_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
