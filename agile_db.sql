-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
-- Creato il: Mag 11, 2023 alle 11:02
=======
-- Creato il: Mag 11, 2023 alle 10:44
>>>>>>> 58f3e927cbd32218eeea61cd8a9b78be608e1429
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

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
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `numero_telefono` varchar(20) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `saldo_wallet` decimal(10,2) DEFAULT NULL,
  `socio` tinyint(1) DEFAULT NULL,
  `abbonato` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `cognome`, `numero_telefono`, `username`, `password`, `email`, `saldo_wallet`, `socio`, `abbonato`) VALUES
(1, 'emanuele', '', '', 'satanass', '$2y$10$go8B6SM3vLNbrV7/MnxkQ.HFryAvCjTJ4lv0hOc3Pp1vb31CDhFQK', 'emanueletraversa78@gmail.com', NULL, NULL, NULL),
(2, 'sisotto', 'sisotta', '3202681154', 'santo', '$2y$10$dn4/CzJQ38.cOp.HThZD2OZcssUb/QEJdgaW4t9hiWVHBhdF3BR4e', 'emanueletraversa65@gmail.com', NULL, NULL, NULL);

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
<<<<<<< HEAD
  ADD KEY `maestro` (`maestro`),
  ADD KEY `prenotazioni_ibfk_3` (`utente`);
=======
  ADD KEY `maestro` (`maestro`);
>>>>>>> 58f3e927cbd32218eeea61cd8a9b78be608e1429

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`ID`),
<<<<<<< HEAD
  ADD KEY `prenotazione` (`prenotazione`),
  ADD KEY `wallet_ibfk_1` (`utente`);
=======
  ADD KEY `prenotazione` (`prenotazione`);
>>>>>>> 58f3e927cbd32218eeea61cd8a9b78be608e1429

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
<<<<<<< HEAD
  ADD CONSTRAINT `prenotazioni_ibfk_3` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`);
=======
  ADD CONSTRAINT `prenotazioni_ibfk_3` FOREIGN KEY (`utente`) REFERENCES `utenti` (`ID`);
>>>>>>> 58f3e927cbd32218eeea61cd8a9b78be608e1429

--
-- Limiti per la tabella `wallet`
--
ALTER TABLE `wallet`
<<<<<<< HEAD
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`id`),
=======
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utenti` (`ID`),
>>>>>>> 58f3e927cbd32218eeea61cd8a9b78be608e1429
  ADD CONSTRAINT `wallet_ibfk_2` FOREIGN KEY (`prenotazione`) REFERENCES `prenotazioni` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
