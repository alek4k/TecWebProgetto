-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Feb 13, 2019 alle 23:47
-- Versione del server: 10.1.38-MariaDB-0ubuntu0.18.04.1
-- Versione PHP: 7.2.15-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alovo`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admin`
--

CREATE TABLE `admin` (
  `Id` int(11) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(60) NOT NULL,
  `token` varchar(400) DEFAULT NULL,
  `token_generation` datetime DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `admin`
--

INSERT INTO `admin` (`Id`, `username`, `password`, `token`, `token_generation`, `token_expiration`) VALUES
(52, 'admin', '$2y$10$GHCl.mrDIKA7QO6jEXPK8eRMgCvw5EODQ6W5Has3xw7yU7tYWKxAy', 'Y2Y2MGU4MjljY2JhZjgxYmQzMTBiNzE3NWM2NDgxNzU1NTdiMzRh37fWhgal1vJYmlYJGQhR9zeiJh4S-CZ-8l1pTCy7', '2019-02-13 20:45:54', '2019-02-13 21:00:54'),
(68, 'alovo', '$2y$10$ESTpXAcVYdwWnMBylJ1s7.cCcumi.Kjv6KjrRazuoyfCIGtkCtqJS', NULL, NULL, NULL),
(69, 'acorrocher', '$2y$10$hzKhy..EBwGdniUzzA29Ge0sYMZK2i1e/fYe5kEvMFsiuh7pMaJXq', NULL, NULL, NULL),
(70, 'cr7', '$2y$10$p/zOoBb04qf6Q3l8BVhhfukrxRsfIenoudTMELh9jbyFOazCPau8G', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE `evento` (
  `Id` int(11) NOT NULL,
  `titolo` varchar(100) NOT NULL,
  `descrizione` varchar(500) NOT NULL,
  `data` date NOT NULL,
  `image` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`Id`, `titolo`, `descrizione`, `data`, `image`) VALUES
(31, 'Capodanno in rifugio', 'Non perdete l\'occasione di trascorrere un capodanno indimenticabile fra le nevi delle Dolomiti... Intrattenimento musicale, brindisi di mezzanotte attorno ad un fal&ograve; e fuochi d&rsquo;artificio renderanno il vostro veglione memorabile!', '2018-12-31', 'uploads/fuochi_artificio.jpg'),
(33, 'Cena di San Valentino', 'Gioved&igrave; 14 febbraio 2019 anche al Rifugio Paolotti si celebra l\'amore con una cena di San Valentino davvero speciale!', '2019-02-14', 'uploads/san_valentino.jpg'),
(34, 'Ciaspolata notturna con guide alpine', 'Un\'inedita serata tra ciaspole e cena: il Rifugio Paolotti vi regaler&agrave; un\'esperienza indimenticabile... Una ciaspolata alla scoperta di magici scenari innevati, rischiarati dalla tenue luce della Luna.', '2019-02-20', 'uploads/ciaspolata.jpg'),
(36, 'Aperitivo in alta quota', 'Radunate la migliore compagnia che conoscete e raggiungeteci al Rifugio Paolotti per un esclusivo aperitivo attorno al caminetto centrale ammirando il panorama mozzafiato.', '2019-02-28', 'uploads/aperitivo.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `Id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `email` varchar(40) DEFAULT NULL,
  `telefono` varchar(13) NOT NULL,
  `persone` int(1) NOT NULL DEFAULT '1',
  `data` date NOT NULL,
  `note` varchar(999) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO `prenotazione` (`Id`, `nome`, `email`, `telefono`, `persone`, `data`, `note`) VALUES
(1, 'Mario Rossi', '', '0498736485', 2, '2019-02-14', ''),
(2, 'Paola Moro', 'paola1990@gmail.com', '3647568572', 1, '2019-02-19', ''),
(3, 'Vittorio Scantamburlo', 'vittorio.scantamburlo@hotmail.it', '3294681523', 7, '2019-02-19', 'Buonasera, siamo una compagnia di amici, come sono organizzate le stanze? Ci sono camerate o solo singole e doppie? Grazie, a presto.'),
(4, 'Cristiano Lombardi', '', '1234567899', 3, '2019-02-23', 'Accettate pagamenti con carte di credito? Grazie!'),
(5, 'Simone Verdi', 'simone.verdi@verdi.com', '+393324523423', 4, '2019-03-02', 'Buongiorno, c\'&egrave; la possibilit&agrave; di portare con noi anche un cane? Grazie!');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indici per le tabelle `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`Id`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `admin`
--
ALTER TABLE `admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT per la tabella `evento`
--
ALTER TABLE `evento`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
DELIMITER $$
--
-- Eventi
--
CREATE DEFINER=`alovo`@`localhost` EVENT `inactiveUser` ON SCHEDULE EVERY 15 MINUTE STARTS '2018-12-15 15:01:37' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Delete accounts inactive in the last 15 minutes' DO BEGIN
		DELETE FROM onlineUser WHERE data < (NOW() - INTERVAL 15 MINUTE);
      END$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
