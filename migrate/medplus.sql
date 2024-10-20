DROP TABLE IF EXISTS `clienti`;
CREATE TABLE `clienti` (
  `id` int NOT NULL,
  `nominativo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indirizzo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `citta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cf` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `celulare` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('MedPlus') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `portato_da` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_inserimento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prestazioni_precedenti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notizie_cliniche` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_tratammento` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `clienti` (`id`, `nominativo`, `indirizzo`, `cap`, `citta`, `cf`, `telefono`, `celulare`, `email`, `tipo`, `portato_da`, `data_inserimento`, `prestazioni_precedenti`, `notizie_cliniche`, `note_tratammento`) VALUES
(1, 'test', 'via Bobbio Scipione, 11', '80126', 'Napoli', 'GGLDNL81A31F839B', '3404006396', 'MedPlus', 'Altro', 'MedPlus', 'Altro', '2024-10-19 23:51:57', 'Altro studio Fisioterapico o Medico o Altro', 'Diagnosi ', 'Portatore PaceMaker / Paziente Oncologico'),
(2, 'test', 'trovatore', '80126', 'Naples', 'GGLDNL81A31F839B', '3758298897', '984555666654', 'teodublin@gmail.com', 'MedPlus', 'Altro', '2024-10-19 23:54:09', 'Altro studio Fisioterapico o Medico o Altro', '', ''),
(4, 'Gagliotta Danilo', 'trovatore', '80126', 'Naples', 'GGLDNL81A31F839B', '3758298897', '984555666654', 'thierrynapule@gmail.com', 'MedPlus', 'Altro', '2024-10-20 21:47:17', 'Altro studio Fisioterapico o Medico o Altro', 'fapodijfapfdoija paodijf paodijfa poija dopijafdpoaji dpoaijf paoidjf apoidj paoijdf poaijf a podijapdoi jadf aoi japodi jfapo a oijadpoifj aopedfa daoi aj', 'apodijfapd jia adpoifja podijfa  oaidjfpoaijd fa poiajdfpoaijd aop fiajdfpoaij dpaoifa podijfap oidjfapodij apoij faopdfji aopdijf apoijdfoaij dpofaijd poaijdfp oaijdf poaidjfapo dijafpo ijapdofija pdoijafdp oiajddklnaòdlknfòqeofodijjfapo   ');

DROP TABLE IF EXISTS profili;
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
(1, 'Franci'),
(2, 'Fausta'),
(3, 'Daniela'),
(4, 'Alfonso'),
(5, 'Enrica'),
(6, 'Milano'),
(8, 'Giancarlo');

DROP TABLE IF EXISTS `trattamenti`;

CREATE TABLE `trattamenti` (
  `id` int NOT NULL,
  `categoria` enum('Elettromedicali','Terapia Manuale','Rieducazione posturale') COLLATE utf8mb4_unicode_ci NOT NULL,
  `trattamento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('Mensile','Per Seduta') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prezzo` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `trattamenti` (`id`, `categoria`, `trattamento`, `tipo`, `prezzo`) VALUES
(28, 'Elettromedicali', 'test', 'Mensile', 350.00),
(29, 'Elettromedicali', 'Pancafit', 'Mensile', 150.00),
(31, 'Elettromedicali', 'Pancafit', 'Mensile', 150.00),
(35, 'Elettromedicali', 'TEST2', 'Mensile', 150.00);


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

ALTER TABLE `profili`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `terapisti`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `trattamenti`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clienti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `profili`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `terapisti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `trattamenti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

ALTER TABLE `utenti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
