-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 02, 2021 alle 19:33
-- Versione del server: 10.4.14-MariaDB
-- Versione PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ristorante`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `admin`
--

INSERT INTO `admin` (`id_admin`, `nome`, `cognome`, `email`, `password`, `data_creazione`, `ultima_modifica`) VALUES
(1, 'Sergio', 'Siclari', 's.siclari@hotmail.it', '$2a$04$1RLH81RQKYSZiQcYKLIVs.LgxLMMm1eGPD4a.ktuSg8JcFTWYBcJW', '2021-07-19 12:36:57', '2021-08-04 14:32:23');

-- --------------------------------------------------------

--
-- Struttura della tabella `ambiente`
--

CREATE TABLE `ambiente` (
  `id_ambiente` int(11) NOT NULL,
  `id_ristorante` int(11) DEFAULT NULL,
  `id_tipologia` int(11) DEFAULT NULL,
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ambiente`
--

INSERT INTO `ambiente` (`id_ambiente`, `id_ristorante`, `id_tipologia`, `nome`) VALUES
(1, 3, 2, 'Magazzino'),
(2, 3, 4, 'Sala Rossa'),
(3, 3, 4, 'Sala Gialla'),
(4, 9, 1, 'Sala Romana');

-- --------------------------------------------------------

--
-- Struttura della tabella `cameriere`
--

CREATE TABLE `cameriere` (
  `id_cameriere` int(11) NOT NULL,
  `id_ristorante` int(11) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data_nascita` date NOT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `cameriere`
--

INSERT INTO `cameriere` (`id_cameriere`, `id_ristorante`, `nome`, `cognome`, `email`, `password`, `data_nascita`, `data_creazione`, `ultima_modifica`) VALUES
(4, 3, 'Chris', 'Ferro', 'chris.ferro@gmail.com', '$2y$10$G8XG7RCDQct1X31kdUgMbO/sPPwDb9CmQjoP43YJyAqeOWnyHQo4e', '1994-06-13', '2021-07-08 19:33:30', '2021-08-18 16:24:48'),
(30, 3, 'Guido', 'Guidi', 'guidoguidi@gmail.com', '$2y$10$2Y3Cij0UlM6G.o3HJ1Gw7uBoP8eIpiKGzzQV5BJ/EP5gONW68VGiq', '1990-05-15', '2021-08-16 16:55:32', '2021-08-18 16:24:51');

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nome`) VALUES
(1, 'Carne'),
(2, 'Pesce'),
(3, 'Frutta'),
(4, 'Verdura'),
(5, 'Formaggio'),
(6, 'Bevanda'),
(7, 'Liquore');

-- --------------------------------------------------------

--
-- Struttura della tabella `chef`
--

CREATE TABLE `chef` (
  `id_chef` int(11) NOT NULL,
  `id_ristorante` int(11) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data_nascita` date NOT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `chef`
--

INSERT INTO `chef` (`id_chef`, `id_ristorante`, `nome`, `cognome`, `email`, `password`, `data_nascita`, `data_creazione`, `ultima_modifica`) VALUES
(1, 3, 'Antonio', 'Neri', 'antonio.neri@gmail.com', '$2y$10$WPi.lZiYFrQ.5pVETqAduurbwZT3XYy1qyOJEPT2DdCr/Fg7E/bee', '1994-06-13', '2021-07-08 19:09:13', '2021-08-18 16:30:36'),
(18, 3, 'Armando', 'Ollo', 'armandollo@gmail.com', '$2y$10$JbBHKxSijborlJa4esDil.aBNtFJpfraqubc1kWvvx8HvCv0wd1R2', '2021-08-21', '2021-08-18 11:41:48', '2021-08-18 16:30:39');

-- --------------------------------------------------------

--
-- Struttura della tabella `comanda`
--

CREATE TABLE `comanda` (
  `id_comanda` int(11) NOT NULL,
  `id_tavolo` int(11) DEFAULT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `comanda`
--

INSERT INTO `comanda` (`id_comanda`, `id_tavolo`, `data_creazione`, `ultima_modifica`) VALUES
(1, 2, '2021-08-25 12:37:46', '2021-08-26 18:01:16'),
(4, 3, '2021-08-25 12:41:07', '2021-08-26 18:01:06');

-- --------------------------------------------------------

--
-- Struttura della tabella `dettagli_ordine`
--

CREATE TABLE `dettagli_ordine` (
  `id_dettagli` int(11) NOT NULL,
  `id_ordine` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dettagli_ordine`
--

INSERT INTO `dettagli_ordine` (`id_dettagli`, `id_ordine`, `id_ingrediente`, `quantita`) VALUES
(3, 9, 7, 15);

-- --------------------------------------------------------

--
-- Struttura della tabella `fornitore`
--

CREATE TABLE `fornitore` (
  `id_fornitore` int(11) NOT NULL,
  `id_genere` int(11) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `fornitore`
--

INSERT INTO `fornitore` (`id_fornitore`, `id_genere`, `nome`, `email`, `password`, `data_creazione`, `ultima_modifica`) VALUES
(6, 1, 'Alla brace', 'allabrace@gmail.com', '$2y$10$8eeIgmPxAv.ALloArYNejOZ3e23OtEB8Q45OTsX4g9.jHuEK5LpPS', '2021-07-23 17:17:05', '2021-07-23 15:17:05'),
(8, 2, 'Mare Aperto', 'mareaperto@gmail.com', '$2y$10$5.UfFyQegnUIGKg8vzpGX.KFJ8nsvAB2ilCc0MCf93d6y1CWJKWTS', '2021-08-16 17:07:16', '2021-08-16 15:07:16');

-- --------------------------------------------------------

--
-- Struttura della tabella `genere`
--

CREATE TABLE `genere` (
  `id_genere` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `genere`
--

INSERT INTO `genere` (`id_genere`, `nome`) VALUES
(1, 'Carne'),
(2, 'Pesce'),
(3, 'Frutta'),
(4, 'Verdura'),
(5, 'Formaggio'),
(6, 'Bevanda'),
(7, 'Liquore');

-- --------------------------------------------------------

--
-- Struttura della tabella `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ingrediente` int(11) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_ambiente` int(11) DEFAULT NULL,
  `id_ordine` int(11) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `quantita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ingrediente`
--

INSERT INTO `ingrediente` (`id_ingrediente`, `id_categoria`, `id_ambiente`, `id_ordine`, `nome`, `quantita`) VALUES
(7, 4, 1, NULL, 'Lattuga', 15),
(9, 4, 1, NULL, 'Carota', 20);

-- --------------------------------------------------------

--
-- Struttura della tabella `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `prezzo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `menu`
--

INSERT INTO `menu` (`id_menu`, `nome`, `prezzo`) VALUES
(1, 'Spaghetti alla carbonara', '7.50');

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `id_ordine` int(11) NOT NULL,
  `id_fornitore` int(11) DEFAULT NULL,
  `stato` enum('0','1','2') NOT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`id_ordine`, `id_fornitore`, `stato`, `data_creazione`, `ultima_modifica`) VALUES
(9, 8, '1', '2021-08-25 20:03:25', '2021-08-25 18:04:16');

-- --------------------------------------------------------

--
-- Struttura della tabella `piatto`
--

CREATE TABLE `piatto` (
  `id_piatto` int(11) NOT NULL,
  `id_comanda` int(11) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `stato` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `piatto`
--

INSERT INTO `piatto` (`id_piatto`, `id_comanda`, `id_menu`, `stato`) VALUES
(1, 4, 1, '0');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE `prenotazione` (
  `id_prenotazione` int(11) NOT NULL,
  `id_tavolo` int(11) DEFAULT NULL,
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `data_prenotazione` datetime NOT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO `prenotazione` (`id_prenotazione`, `id_tavolo`, `nome`, `cognome`, `data_prenotazione`, `data_creazione`, `ultima_modifica`) VALUES
(1, 2, 'Aldo', 'Baglio', '2021-08-31 01:25:00', '2021-08-25 12:24:12', '2021-08-26 18:21:51');

-- --------------------------------------------------------

--
-- Struttura della tabella `ristorante`
--

CREATE TABLE `ristorante` (
  `id_ristorante` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `telefono` int(11) NOT NULL,
  `indirizzo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `ristorante`
--

INSERT INTO `ristorante` (`id_ristorante`, `nome`, `telefono`, `indirizzo`) VALUES
(3, 'Bad Bull', 2147483647, 'Via Nazionale, 343, Reggio Calabria - Pellaro'),
(9, 'Romaniac', 123456789, 'Viale dei colli, 74, Reggio Calabria');

-- --------------------------------------------------------

--
-- Struttura della tabella `segnalazione`
--

CREATE TABLE `segnalazione` (
  `id_segnalazione` int(11) NOT NULL,
  `id_chef` int(11) DEFAULT NULL,
  `ingrediente` varchar(30) NOT NULL,
  `data_creazione` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_modifica` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `segnalazione`
--

INSERT INTO `segnalazione` (`id_segnalazione`, `id_chef`, `ingrediente`, `data_creazione`, `ultima_modifica`) VALUES
(2, 18, 'Carota', '2021-08-25 20:35:47', '2021-08-25 18:35:47');

-- --------------------------------------------------------

--
-- Struttura della tabella `tavolo`
--

CREATE TABLE `tavolo` (
  `id_tavolo` int(11) NOT NULL,
  `id_ambiente` int(11) DEFAULT NULL,
  `posti` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tavolo`
--

INSERT INTO `tavolo` (`id_tavolo`, `id_ambiente`, `posti`) VALUES
(1, 2, 9),
(2, 2, 6),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologia`
--

CREATE TABLE `tipologia` (
  `id_tipologia` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tipologia`
--

INSERT INTO `tipologia` (`id_tipologia`, `nome`) VALUES
(1, 'Sala'),
(2, 'Magazzino'),
(4, 'Dispensa');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indici per le tabelle `ambiente`
--
ALTER TABLE `ambiente`
  ADD PRIMARY KEY (`id_ambiente`),
  ADD KEY `id_ristorante` (`id_ristorante`),
  ADD KEY `id_tipologia` (`id_tipologia`);

--
-- Indici per le tabelle `cameriere`
--
ALTER TABLE `cameriere`
  ADD PRIMARY KEY (`id_cameriere`),
  ADD KEY `id_ristorante` (`id_ristorante`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indici per le tabelle `chef`
--
ALTER TABLE `chef`
  ADD PRIMARY KEY (`id_chef`),
  ADD KEY `id_ristorante` (`id_ristorante`);

--
-- Indici per le tabelle `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id_comanda`),
  ADD KEY `id_tavolo` (`id_tavolo`);

--
-- Indici per le tabelle `dettagli_ordine`
--
ALTER TABLE `dettagli_ordine`
  ADD PRIMARY KEY (`id_dettagli`),
  ADD KEY `id_ingrediente` (`id_ingrediente`),
  ADD KEY `id_ordine` (`id_ordine`);

--
-- Indici per le tabelle `fornitore`
--
ALTER TABLE `fornitore`
  ADD PRIMARY KEY (`id_fornitore`),
  ADD KEY `id_genere` (`id_genere`);

--
-- Indici per le tabelle `genere`
--
ALTER TABLE `genere`
  ADD PRIMARY KEY (`id_genere`);

--
-- Indici per le tabelle `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id_ingrediente`),
  ADD KEY `id_ambiente` (`id_ambiente`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indici per le tabelle `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`id_ordine`),
  ADD KEY `id_fornitore` (`id_fornitore`);

--
-- Indici per le tabelle `piatto`
--
ALTER TABLE `piatto`
  ADD PRIMARY KEY (`id_piatto`),
  ADD KEY `id_comanda` (`id_comanda`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indici per le tabelle `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD PRIMARY KEY (`id_prenotazione`),
  ADD KEY `id_tavolo` (`id_tavolo`);

--
-- Indici per le tabelle `ristorante`
--
ALTER TABLE `ristorante`
  ADD PRIMARY KEY (`id_ristorante`);

--
-- Indici per le tabelle `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD PRIMARY KEY (`id_segnalazione`),
  ADD KEY `id_chef` (`id_chef`);

--
-- Indici per le tabelle `tavolo`
--
ALTER TABLE `tavolo`
  ADD PRIMARY KEY (`id_tavolo`),
  ADD KEY `id_ambiente` (`id_ambiente`);

--
-- Indici per le tabelle `tipologia`
--
ALTER TABLE `tipologia`
  ADD PRIMARY KEY (`id_tipologia`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `ambiente`
--
ALTER TABLE `ambiente`
  MODIFY `id_ambiente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT per la tabella `cameriere`
--
ALTER TABLE `cameriere`
  MODIFY `id_cameriere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `chef`
--
ALTER TABLE `chef`
  MODIFY `id_chef` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `dettagli_ordine`
--
ALTER TABLE `dettagli_ordine`
  MODIFY `id_dettagli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `fornitore`
--
ALTER TABLE `fornitore`
  MODIFY `id_fornitore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `genere`
--
ALTER TABLE `genere`
  MODIFY `id_genere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `id_ordine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `piatto`
--
ALTER TABLE `piatto`
  MODIFY `id_piatto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  MODIFY `id_prenotazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `ristorante`
--
ALTER TABLE `ristorante`
  MODIFY `id_ristorante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  MODIFY `id_segnalazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `tavolo`
--
ALTER TABLE `tavolo`
  MODIFY `id_tavolo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `tipologia`
--
ALTER TABLE `tipologia`
  MODIFY `id_tipologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ambiente`
--
ALTER TABLE `ambiente`
  ADD CONSTRAINT `ambiente_ibfk_1` FOREIGN KEY (`id_ristorante`) REFERENCES `ristorante` (`id_ristorante`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ambiente_ibfk_2` FOREIGN KEY (`id_tipologia`) REFERENCES `tipologia` (`id_tipologia`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `cameriere`
--
ALTER TABLE `cameriere`
  ADD CONSTRAINT `cameriere_ibfk_1` FOREIGN KEY (`id_ristorante`) REFERENCES `ristorante` (`id_ristorante`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `chef`
--
ALTER TABLE `chef`
  ADD CONSTRAINT `chef_ibfk_1` FOREIGN KEY (`id_ristorante`) REFERENCES `ristorante` (`id_ristorante`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `comanda`
--
ALTER TABLE `comanda`
  ADD CONSTRAINT `comanda_ibfk_1` FOREIGN KEY (`id_tavolo`) REFERENCES `tavolo` (`id_tavolo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `dettagli_ordine`
--
ALTER TABLE `dettagli_ordine`
  ADD CONSTRAINT `dettagli_ordine_ibfk_1` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingrediente` (`id_ingrediente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dettagli_ordine_ibfk_2` FOREIGN KEY (`id_ordine`) REFERENCES `ordine` (`id_ordine`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `fornitore`
--
ALTER TABLE `fornitore`
  ADD CONSTRAINT `fornitore_ibfk_1` FOREIGN KEY (`id_genere`) REFERENCES `genere` (`id_genere`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD CONSTRAINT `ingrediente_ibfk_1` FOREIGN KEY (`id_ambiente`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ingrediente_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`id_fornitore`) REFERENCES `fornitore` (`id_fornitore`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `piatto`
--
ALTER TABLE `piatto`
  ADD CONSTRAINT `piatto_ibfk_1` FOREIGN KEY (`id_comanda`) REFERENCES `comanda` (`id_comanda`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `piatto_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `prenotazione`
--
ALTER TABLE `prenotazione`
  ADD CONSTRAINT `prenotazione_ibfk_1` FOREIGN KEY (`id_tavolo`) REFERENCES `tavolo` (`id_tavolo`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `segnalazione`
--
ALTER TABLE `segnalazione`
  ADD CONSTRAINT `segnalazione_ibfk_1` FOREIGN KEY (`id_chef`) REFERENCES `chef` (`id_chef`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `tavolo`
--
ALTER TABLE `tavolo`
  ADD CONSTRAINT `tavolo_ibfk_1` FOREIGN KEY (`id_ambiente`) REFERENCES `ambiente` (`id_ambiente`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
