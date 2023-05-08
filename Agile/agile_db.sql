-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 07, 2023 alle 11:31
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

create database if not exists agile_db;
use agile_db;


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agile_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `impianti`
--

CREATE TABLE `impianti` (
  `ID` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `citta` varchar(30) NOT NULL,
  `via` varchar(20) NOT NULL,
  `numero_civico` int(11) NOT NULL,
  `numero_telefono` bigint(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `lista_sport` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `impianti`
--

INSERT INTO `impianti` (`ID`, `nome`, `citta`, `via`, `numero_civico`, `numero_telefono`, `email`, `lista_sport`) VALUES
(1, 'gruppo sportivo moravia', 'roma', 'via trento', 18, 851214068, 'gpmoravia@gmail.com', 'calcio,basket,pallavolo'),
(2, 'tennis team vianello', 'milano', 'via verdi', 5, 851569484, 'vianello@gmail.com', 'tennis,padel,ping-pong,badminton,squash');

-- --------------------------------------------------------

--
-- Struttura della tabella `maestri`
--

CREATE TABLE `maestri` (
  `ID` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `tariffa_oraria(€)` int(11) NOT NULL,
  `impianto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `maestri`
--

INSERT INTO `maestri` (`ID`, `nome`, `cognome`, `tariffa_oraria(€)`, `impianto`) VALUES
(1, 'mario', 'rossi', 6, 1),
(2, 'federica', 'gialli', 5, 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `ID` int(11) NOT NULL,
  `utente` int(11) NOT NULL,
  `data` date NOT NULL,
  `orario` time NOT NULL,
  `sport` varchar(30) NOT NULL,
  `numero_partecipanti` int(11) NOT NULL,
  `durata(ore)` int(11) NOT NULL,
  `maestro` int(11) DEFAULT NULL,
  `posti_disponibili` int(11) DEFAULT NULL,
  `impianto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prenotazioni`
--

INSERT INTO `prenotazioni` (`ID`, `utente`, `data`, `orario`, `sport`, `numero_partecipanti`, `durata(ore)`, `maestro`, `posti_disponibili`, `impianto`) VALUES
(1, 1, '2023-06-14', '16:30:00', 'tennis', 4, 2, 1, NULL, 2),
(2, 2, '2023-06-29', '11:00:00', 'basket', 6, 2, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `ID` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `numero_telefono` bigint(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `saldo_wallet` int(11) NOT NULL,
  `socio` tinyint(1) DEFAULT NULL,
  `plus` tinyint(1) DEFAULT NULL,
  `abbonamento` enum('mensile','annuale','bimestrale','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`ID`, `nome`, `cognome`, `numero_telefono`, `username`, `password`, `email`, `saldo_wallet`, `socio`, `plus`, `abbonamento`) VALUES
(1, 'giovanni', 'boccaccio', 3461214068, 'giovi', 'bocc', 'g.boccaccio@gmail.com', 100, 1, 1, 'mensile'),
(2, 'francesco', 'petrarca', 3471500584, 'franz', 'pett', 'f.petrarca@gmail.com', 85, 1, NULL, NULL),
(3, 'dante', 'alighieri', 3280818756, 'adante', 'aligh', 'd.alighieri@gmail.com', 25, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `wallet`
--

CREATE TABLE `wallet` (
  `ID` int(11) NOT NULL,
  `data_transazione` date NOT NULL,
  `orario_transazione` time NOT NULL,
  `importo` int(11) NOT NULL,
  `utente` int(11) NOT NULL,
  `prenotazione` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `wallet`
--

INSERT INTO `wallet` (`ID`, `data_transazione`, `orario_transazione`, `importo`, `utente`, `prenotazione`) VALUES
(1, '2023-06-01', '14:00:00', 15, 1, 1),
(2, '2023-06-04', '18:00:00', 20, 2, 2);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `impianti`
--
ALTER TABLE `impianti`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `maestri`
--
ALTER TABLE `maestri`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `impianto` (`impianto`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `impianto` (`impianto`),
  ADD KEY `maestro` (`maestro`),
  ADD KEY `utente` (`utente`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `utente` (`utente`),
  ADD KEY `prenotazione` (`prenotazione`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `impianti`
--
ALTER TABLE `impianti`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `maestri`
--
ALTER TABLE `maestri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `wallet`
--
ALTER TABLE `wallet`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `maestri`
--
ALTER TABLE `maestri`
  ADD CONSTRAINT `maestri_ibfk_1` FOREIGN KEY (`impianto`) REFERENCES `impianti` (`ID`);

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`impianto`) REFERENCES `impianti` (`ID`),
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`maestro`) REFERENCES `maestri` (`ID`),
  ADD CONSTRAINT `prenotazioni_ibfk_3` FOREIGN KEY (`utente`) REFERENCES `utenti` (`ID`);

--
-- Limiti per la tabella `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`ID`),
  ADD CONSTRAINT `wallet_ibfk_2` FOREIGN KEY (`prenotazione`) REFERENCES `prenotazioni` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
