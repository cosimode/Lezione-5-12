-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 05, 2024 alle 13:24
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `libri`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `autore_libro`
--

CREATE TABLE `autore_libro` (
  `id_autore` int(11) NOT NULL,
  `id_libro` varchar(13) NOT NULL,
  `contributo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `autori`
--

CREATE TABLE `autori` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `nascita` date DEFAULT NULL,
  `morte` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `cataloghi`
--

CREATE TABLE `cataloghi` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `genere_libro`
--

CREATE TABLE `genere_libro` (
  `isbn` varchar(13) NOT NULL,
  `id_genere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `generi`
--

CREATE TABLE `generi` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `libri`
--

CREATE TABLE `libri` (
  `isbn` varchar(13) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `libri_catalogo`
--

CREATE TABLE `libri_catalogo` (
  `id_catalogo` int(11) NOT NULL,
  `isbn` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `autore_libro`
--
ALTER TABLE `autore_libro`
  ADD PRIMARY KEY (`id_autore`,`id_libro`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indici per le tabelle `autori`
--
ALTER TABLE `autori`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `cataloghi`
--
ALTER TABLE `cataloghi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `genere_libro`
--
ALTER TABLE `genere_libro`
  ADD PRIMARY KEY (`isbn`,`id_genere`),
  ADD KEY `id_genere` (`id_genere`);

--
-- Indici per le tabelle `generi`
--
ALTER TABLE `generi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `libri`
--
ALTER TABLE `libri`
  ADD PRIMARY KEY (`isbn`);

--
-- Indici per le tabelle `libri_catalogo`
--
ALTER TABLE `libri_catalogo`
  ADD PRIMARY KEY (`id_catalogo`,`isbn`),
  ADD KEY `isbn` (`isbn`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `autori`
--
ALTER TABLE `autori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `cataloghi`
--
ALTER TABLE `cataloghi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `generi`
--
ALTER TABLE `generi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `autore_libro`
--
ALTER TABLE `autore_libro`
  ADD CONSTRAINT `autore_libro_ibfk_1` FOREIGN KEY (`id_autore`) REFERENCES `autori` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `autore_libro_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libri` (`isbn`) ON DELETE CASCADE;

--
-- Limiti per la tabella `genere_libro`
--
ALTER TABLE `genere_libro`
  ADD CONSTRAINT `genere_libro_ibfk_1` FOREIGN KEY (`isbn`) REFERENCES `libri` (`isbn`) ON DELETE CASCADE,
  ADD CONSTRAINT `genere_libro_ibfk_2` FOREIGN KEY (`id_genere`) REFERENCES `generi` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `libri_catalogo`
--
ALTER TABLE `libri_catalogo`
  ADD CONSTRAINT `libri_catalogo_ibfk_1` FOREIGN KEY (`id_catalogo`) REFERENCES `cataloghi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `libri_catalogo_ibfk_2` FOREIGN KEY (`isbn`) REFERENCES `libri` (`isbn`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
