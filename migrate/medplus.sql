
DROP TABLE IF EXISTS `clienti`;
CREATE TABLE `clienti` (
  `id` int NOT NULL,
  `nominativo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indirizzo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `citta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cellulare` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('MedPlus') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `portato_da` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_inserimento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prestazioni_precedenti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notizie_cliniche` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_trattamento` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `clienti` (`id`, `nominativo`, `indirizzo`, `cap`, `citta`, `cf`, `telefono`, `cellulare`, `email`, `tipo`, `portato_da`, `data_inserimento`, `prestazioni_precedenti`, `notizie_cliniche`, `note_trattamento`) VALUES
(1, 'test', 'via Bobbio Scipione, 11', '80126', 'Napoli', 'GGLDNL81A31F839B', '3404006396', 'MedPlus', 'Altro', 'MedPlus', 'Altro', '2024-10-19 23:51:57', 'Altro studio Fisioterapico o Medico o Altro', 'Diagnosi ', 'Portatore PaceMaker / Paziente Oncologico'),
(4, 'Gagliotta Danilo', 'trovatore', '80126', 'Naples', 'GGLDNL81A31F839B', '3758298897', '984555666654', 'thierrynapule@gmail.com', 'MedPlus', 'Altro', '2024-10-20 21:47:17', 'Altro studio Fisioterapico o Medico o Altro', 'fapodijfapfdoija paodijf paodijfa poija dopijafdpoaji dpoaijf paoidjf apoidj paoijdf poaijf a podijapdoi jadf aoi japodi jfapo a oijadpoifj aopedfa daoi aj', 'apodijfapd jia adpoifja podijfa  oaidjfpoaijd fa poiajdfpoaijd aop fiajdfpoaij dpaoifa podijfap oidjfapodij apoij faopdfji aopdijf apoijdfoaij dpofaijd poaijdfp oaijdf poaidjfapo dijafpo ijapdofija pdoijafdp oiajddklnaòdlknfòqeofodijjfapo   '),
(5, 'Angela test', 'trovatore', '80126', 'Naples', 'GGLDNL81A31F839B', '3758298897', '984555666654', 'thierrynapule@gmail.com', 'MedPlus', 'Altro', '2024-10-20 21:47:17', 'Altro studio Fisioterapico o Medico o Altro', 'Notizie_cliniche', 'Note trattamento'),
(7, 'Danilo test', 'trovatore', '80126', 'Naples', 'GGLDNL81A31F839B', '3758298897', '984555666654', 'thierrynapule@gmail.com', 'MedPlus', 'Altro', '2024-10-20 21:47:17', 'Altro studio Fisioterapico o Medico o Altro', 'Notizie_cliniche', 'Note trattamento'),
(12, 'test 2222', '', '', '', '', '', '', '', 'MedPlus', '', '2024-10-28 23:00:00', '', '', ''),
(13, 'test aaaa', '', '', '', '', '', '', '', 'MedPlus', '', '2024-10-28 23:00:00', '', '', ''),
(14, 'test nnn', '', '', '', '', '', '', '', 'MedPlus', '', '2024-10-28 23:00:00', '', '', '');

DROP TABLE IF EXISTS `planning`;
CREATE TABLE `planning` (
  `id` int NOT NULL,
  `row` int NOT NULL,
  `data` date NOT NULL,
  `ora` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_terapista` int NOT NULL,
  `id_cliente` int DEFAULT NULL,
  `id_trattamento` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `planning` (`id`, `row`, `data`, `ora`, `note`, `id_terapista`, `id_cliente`, `id_trattamento`) VALUES
(21, 1, '2024-10-28', '08:00', NULL, 11, 7, 37),
(22, 2, '2024-10-29', '08:00', NULL, 11, 1, 37),
(23, 3, '2024-10-29', '10:00', NULL, 11, 7, 37),
(24, 5, '2024-10-29', '08:00', NULL, 11, 7, 40);

DROP TABLE IF EXISTS `prenotazioni`;
CREATE TABLE `prenotazioni` (
  `id` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_trattamento` int NOT NULL,
  `tipo_sezioni` enum('Mensile','Per Seduta','Singola') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `profili`;
CREATE TABLE `profili` (
  `id` int NOT NULL,
  `profilo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `profili` (`id`, `profilo`) VALUES
(1, 'direzione'),
(2, 'terapista'),
(3, 'base');

DROP TABLE IF EXISTS `terapisti`;
CREATE TABLE `terapisti` (
  `id` int NOT NULL,
  `terapista` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `terapisti` (`id`, `terapista`) VALUES
(11, 'Daniela Zanotti'),
(12, 'Giancarlo Di Bonito'),
(13, 'Claudia Mancusi'),
(14, 'Enrica Marinucci');


DROP TABLE IF EXISTS `trattamenti`;
CREATE TABLE `trattamenti` (
  `id` int NOT NULL,
  `categoria` enum('Elettromedicali','Terapia Manuale','Rieducazione posturale') COLLATE utf8mb4_unicode_ci NOT NULL,
  `trattamento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('Mensile','Per Seduta') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prezzo` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `trattamenti` (`id`, `categoria`, `trattamento`, `tipo`, `prezzo`) VALUES
(37, 'Elettromedicali', 'Magneto domiciliare', 'Mensile', 120.00),
(38, 'Elettromedicali', 'Magneto ambulatoriale', 'Per Seduta', 10.00),
(39, 'Elettromedicali', 'Ultrasuoni', 'Per Seduta', 10.00),
(40, 'Elettromedicali', 'Tens', 'Per Seduta', 10.00),
(41, 'Elettromedicali', 'Ionoforesi', 'Per Seduta', 10.00),
(42, 'Elettromedicali', 'Elettrostimolazione', 'Per Seduta', 10.00),
(43, 'Elettromedicali', 'Laser', 'Per Seduta', 30.00),
(44, 'Elettromedicali', 'Tecar', 'Per Seduta', 30.00),
(45, 'Elettromedicali', 'Onde durto', 'Per Seduta', 50.00),
(46, 'Elettromedicali', 'Radiofrequenza', 'Per Seduta', 40.00),
(47, 'Elettromedicali', 'Fisio-TT', 'Per Seduta', 35.00),
(48, 'Terapia Manuale', 'Rieducazione motoria', 'Per Seduta', 40.00),
(49, 'Terapia Manuale', 'Esercizi propriocettivi', 'Per Seduta', 40.00),
(50, 'Terapia Manuale', 'Rieducazione al passo', 'Per Seduta', 40.00),
(51, 'Terapia Manuale', 'Mezieres', 'Per Seduta', 50.00),
(52, 'Rieducazione posturale', 'Corsi di ginnastica', 'Mensile', 90.00),
(53, 'Rieducazione posturale', 'Trattamento S.E.A.S.', 'Mensile', 40.00);

DROP TABLE IF EXISTS `utenti`;
CREATE TABLE `utenti` (
  `id` int NOT NULL,
  `utente` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` enum('pink','blue') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `utenti` (`id`, `utente`, `email`, `password`, `template`) VALUES
(1, 'medplus', 'test@test.it', 'medplus', 'blue'),
(63, 'TESadsafd', 'teodublin@gmail.com', 'TEST', 'pink'),
(64, 'fadfadadsfasd', 'teodublin@gmail.com', 'TEST', 'pink'),
(65, 'TES', 'thierrynapule@gmail.com', 'TEST', 'pink');

ALTER TABLE `clienti`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_terapista` (`id_terapista`,`id_cliente`,`id_trattamento`);

ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_trattamento` (`id_trattamento`);

ALTER TABLE `profili`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `terapisti`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `trattamenti`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clienti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `planning`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

ALTER TABLE `prenotazioni`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `profili`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `terapisti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `trattamenti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

ALTER TABLE `utenti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;