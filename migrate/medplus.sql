
DROP TABLE IF EXISTS `clienti`;
CREATE TABLE `clienti` (
  `id` int(11) NOT NULL,
  `nominativo` varchar(255) DEFAULT NULL,
  `indirizzo` varchar(255) DEFAULT NULL,
  `cap` varchar(10) DEFAULT NULL,
  `citta` varchar(255) DEFAULT NULL,
  `cf` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `cellulare` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `portato_da` varchar(255) DEFAULT NULL,
  `data_inserimento` timestamp NOT NULL DEFAULT current_timestamp(),
  `notizie_cliniche` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `clienti` (`id`, `nominativo`, `indirizzo`, `cap`, `citta`, `cf`, `telefono`, `cellulare`, `email`, `portato_da`, `data_inserimento`, `notizie_cliniche`) VALUES
(73, 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-14 00:00:00', NULL);

DROP TABLE IF EXISTS `corsi`;
CREATE TABLE `corsi` (
  `id` int(11) NOT NULL,
  `tipo` enum('Mensile') NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `corso` varchar(255) NOT NULL,
  `prezzo` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corsi`
--

INSERT INTO `corsi` (`id`, `tipo`, `id_categoria`, `corso`, `prezzo`) VALUES
(6, 'Mensile', 1, 'test', 300.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `corsi_categorie`
--

DROP TABLE IF EXISTS `corsi_categorie`;
CREATE TABLE `corsi_categorie` (
  `id` int(11) NOT NULL,
  `categoria` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corsi_categorie`
--

INSERT INTO `corsi_categorie` (`id`, `categoria`) VALUES
(1, 'Palestra');

-- --------------------------------------------------------

--
-- Struttura della tabella `corsi_classi`
--
DROP TABLE IF EXISTS `corsi_classi`;
CREATE TABLE `corsi_classi` (
  `id` int(11) NOT NULL,
  `id_corso` int(11) NOT NULL,
  `classe` varchar(255) NOT NULL,
  `note` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `corsi_classi`
--

INSERT INTO `corsi_classi` (`id`, `id_corso`, `classe`, `note`, `timestamp`) VALUES
(5, 1, 'Ginnastica', 'test', '2024-12-31 11:33:05');

-- --------------------------------------------------------

--
-- Struttura della tabella `fatture`
--
DROP TABLE IF EXISTS `fatture`;
CREATE TABLE `fatture` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `link` longtext NOT NULL,
  `importo` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  `data` longtext NOT NULL,
  `stato` enum('Pendente','Saldata') NOT NULL DEFAULT 'Pendente',
  `timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `fatture`
--

INSERT INTO `fatture` (`id`, `id_cliente`, `link`, `importo`, `index`, `data`, `stato`, `timestamp`) VALUES
(104, 73, 'test_2025-01-14_16_39_39.pdf', 35, 415, '2025-01-14', 'Saldata', '2025-01-14 16:39:39');

-- --------------------------------------------------------

--
-- Struttura della tabella `motivi`
--
DROP TABLE IF EXISTS `motivi`;
CREATE TABLE `motivi` (
  `id` int(11) NOT NULL,
  `motivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `motivi`
--

INSERT INTO `motivi` (`id`, `motivo`) VALUES
(2, 'Pranzo'),
(3, 'Corso'),
(4, 'Malatia'),
(8, 'ferie');

-- --------------------------------------------------------

--
-- Struttura della tabella `percorsi_pagamenti`
--
DROP TABLE IF EXISTS `percorsi_pagamenti`;
CREATE TABLE `percorsi_pagamenti` (
  `id` int(11) NOT NULL,
  `id_percorso` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `prezzo_tabellare` int(11) NOT NULL,
  `prezzo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `percorsi_pagamenti`
--

INSERT INTO `percorsi_pagamenti` (`id`, `id_percorso`, `id_cliente`, `prezzo_tabellare`, `prezzo`) VALUES
(42, 120, 73, 35, 35);

-- --------------------------------------------------------

--
-- Struttura della tabella `percorsi_pagamenti_fatture`
--
DROP TABLE IF EXISTS `percorsi_pagamenti_fatture`;
CREATE TABLE `percorsi_pagamenti_fatture` (
  `id` int(11) NOT NULL,
  `id_percorso` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_fattura` int(11) NOT NULL,
  `importo` double(10,2) NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `percorsi_pagamenti_fatture`
--

INSERT INTO `percorsi_pagamenti_fatture` (`id`, `id_percorso`, `id_cliente`, `id_fattura`, `importo`, `timestamp`) VALUES
(106, 120, 73, 104, 35.00, '2025-01-14 16:39:39');

-- --------------------------------------------------------

--
-- Struttura della tabella `percorsi_pagamenti_senza_fattura`
--
DROP TABLE IF EXISTS `percorsi_pagamenti_senza_fattura`;
CREATE TABLE `percorsi_pagamenti_senza_fattura` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_percorso` int(11) NOT NULL,
  `valore` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `percorsi_pagamenti_senza_fattura`
--

INSERT INTO `percorsi_pagamenti_senza_fattura` (`id`, `id_cliente`, `id_percorso`, `valore`) VALUES
(7, 72, 118, 300.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `percorsi_terapeutici`
--
DROP TABLE IF EXISTS `percorsi_terapeutici`;
CREATE TABLE `percorsi_terapeutici` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_trattamento` int(11) DEFAULT NULL,
  `sedute` int(11) DEFAULT NULL,
  `prezzo_tabellare` double(10,2) NOT NULL,
  `prezzo` double(10,2) NOT NULL,
  `note` longtext DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `percorsi_terapeutici`
--

INSERT INTO `percorsi_terapeutici` (`id`, `id_cliente`, `id_trattamento`, `sedute`, `prezzo_tabellare`, `prezzo`, `note`, `timestamp`) VALUES
(120, 73, 47, 1, 35.00, 35.00, NULL, '2025-01-14 15:19:25');

-- --------------------------------------------------------

--
-- Struttura della tabella `percorsi_terapeutici_sedute`
--
DROP TABLE IF EXISTS `percorsi_terapeutici_sedute`;
CREATE TABLE `percorsi_terapeutici_sedute` (
  `id` int(11) NOT NULL,
  `index` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_percorso` int(11) DEFAULT NULL,
  `id_trattamento` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `percorsi_terapeutici_sedute`
--

INSERT INTO `percorsi_terapeutici_sedute` (`id`, `index`, `id_cliente`, `id_percorso`, `id_trattamento`, `timestamp`) VALUES
(355, 1, 73, 120, 47, '2025-01-14 15:19:25');

-- --------------------------------------------------------

--
-- Struttura della tabella `percorsi_terapeutici_sedute_prenotate`
--
DROP TABLE IF EXISTS `percorsi_terapeutici_sedute_prenotate`;
CREATE TABLE `percorsi_terapeutici_sedute_prenotate` (
  `id` int(11) NOT NULL,
  `row_inizio` int(11) NOT NULL,
  `row_fine` int(11) NOT NULL,
  `id_terapista` int(11) NOT NULL,
  `id_seduta` int(11) NOT NULL,
  `id_percorso` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `stato_prenotazione` enum('Assente','Spostata','Conclusa','Prenotata') NOT NULL DEFAULT 'Prenotata'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Struttura della tabella `planning_motivi`
--
DROP TABLE IF EXISTS `planning_motivi`;
CREATE TABLE `planning_motivi` (
  `id` int(11) NOT NULL,
  `row_inizio` int(11) NOT NULL,
  `row_fine` int(11) NOT NULL,
  `id_terapista` int(11) NOT NULL,
  `data` date NOT NULL,
  `id_motivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `planning_motivi`
--

INSERT INTO `planning_motivi` (`id`, `row_inizio`, `row_fine`, `id_terapista`, `data`, `id_motivo`) VALUES
(41, 1, 3, 11, '2024-12-28', 1),
(43, 25, 29, 11, '2024-12-30', 4),
(44, 12, 15, 11, '2024-12-30', 3),
(46, 19, 19, 11, '2024-12-29', 2),
(47, 13, 17, 11, '2025-01-02', 3),
(48, 21, 29, 12, '2025-01-03', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `planning_row`
--
DROP TABLE IF EXISTS `planning_row`;
CREATE TABLE `planning_row` (
  `id` int(11) NOT NULL,
  `ora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `planning_row`
--

INSERT INTO `planning_row` (`id`, `ora`) VALUES
(1, '07:00:00'),
(2, '07:15:00'),
(3, '07:30:00'),
(4, '07:45:00'),
(5, '08:00:00'),
(6, '08:15:00'),
(7, '08:30:00'),
(8, '08:45:00'),
(9, '09:00:00'),
(10, '09:15:00'),
(11, '09:30:00'),
(12, '09:45:00'),
(13, '10:00:00'),
(14, '10:15:00'),
(15, '10:30:00'),
(16, '10:45:00'),
(17, '11:00:00'),
(18, '11:15:00'),
(19, '11:30:00'),
(20, '11:45:00'),
(21, '12:00:00'),
(22, '12:15:00'),
(23, '12:30:00'),
(24, '12:45:00'),
(25, '13:00:00'),
(26, '13:15:00'),
(27, '13:30:00'),
(28, '13:45:00'),
(29, '14:00:00'),
(30, '14:15:00'),
(31, '14:30:00'),
(32, '14:45:00'),
(33, '15:00:00'),
(34, '15:15:00'),
(35, '15:30:00'),
(36, '15:45:00'),
(37, '16:00:00'),
(38, '16:15:00'),
(39, '16:30:00'),
(40, '16:45:00'),
(41, '17:00:00'),
(42, '17:15:00'),
(43, '17:30:00'),
(44, '17:45:00'),
(45, '18:00:00'),
(46, '18:15:00'),
(47, '18:30:00'),
(48, '18:45:00'),
(49, '19:00:00'),
(50, '19:15:00'),
(51, '19:30:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `setup`
--
DROP TABLE IF EXISTS `setup`;
CREATE TABLE `setup` (
  `id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL,
  `setup` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `setup`
--

INSERT INTO `setup` (`id`, `key`, `setup`) VALUES
(1, 'fatture', '{\"first_index\":415}');

-- --------------------------------------------------------

--
-- Struttura della tabella `terapisti`
--
DROP TABLE IF EXISTS `terapisti`;
CREATE TABLE `terapisti` (
  `id` int(11) NOT NULL,
  `terapista` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `terapisti`
--

INSERT INTO `terapisti` (`id`, `terapista`) VALUES
(11, 'Daniela Zanotti'),
(12, 'Giancarlo Di Bonito'),
(13, 'Claudia Mancusi'),
(14, 'Enrica Marinucci');

-- --------------------------------------------------------

--
-- Struttura della tabella `trattamenti`
--
DROP TABLE IF EXISTS `trattamenti`;
CREATE TABLE `trattamenti` (
  `id` int(11) NOT NULL,
  `tipo` enum('Per Seduta') NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `trattamento` varchar(255) DEFAULT NULL,
  `prezzo` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `trattamenti`
--

INSERT INTO `trattamenti` (`id`, `tipo`, `id_categoria`, `trattamento`, `prezzo`) VALUES
(37, 'Per Seduta', 0, 'Magneto domiciliare', 120.00),
(38, 'Per Seduta', 0, 'Magneto ambulatoriale', 10.00),
(39, 'Per Seduta', 0, 'Ultrasuoni', 10.00),
(40, 'Per Seduta', 0, 'Tens', 10.00),
(41, 'Per Seduta', 0, 'Ionoforesi', 10.00),
(42, 'Per Seduta', 0, 'Elettrostimolazione', 10.00),
(43, 'Per Seduta', 0, 'Laser', 30.00),
(44, 'Per Seduta', 0, 'Tecar', 30.00),
(45, 'Per Seduta', 0, 'Onde durto', 50.00),
(46, 'Per Seduta', 0, 'Radiofrequenza', 40.00),
(47, 'Per Seduta', 0, 'Fisio-TT', 35.00),
(48, 'Per Seduta', 0, 'Rieducazione motoria', 40.00),
(49, 'Per Seduta', 0, 'Esercizi propriocettivi', 40.00),
(50, 'Per Seduta', 0, 'Rieducazione al passo', 40.00),
(51, 'Per Seduta', 0, 'Mezieres', 50.00),
(53, 'Per Seduta', 0, 'Trattamento S.E.A.S.', 40.00),
(56, 'Per Seduta', 0, 'Isico', 140.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `trattamenti_categorie`
--
DROP TABLE IF EXISTS `trattamenti_categorie`;
CREATE TABLE `trattamenti_categorie` (
  `id` int(11) NOT NULL,
  `categoria` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `trattamenti_categorie`
--

INSERT INTO `trattamenti_categorie` (`id`, `categoria`) VALUES
(2, 'test 2');

-- --------------------------------------------------------

DROP VIEW IF EXISTS `planning`;
CREATE VIEW `planning`  AS SELECT 'sbarra' AS `origin`, `pm`.`id` AS `id`, `pm`.`row_inizio` AS `row_inizio`, `pm`.`row_fine` AS `row_fine`, `pm`.`id_terapista` AS `id_terapista`, `pm`.`data` AS `data`, left(`m`.`motivo`,40) AS `motivo` FROM (`planning_motivi` `pm` left join `motivi` `m` on(`pm`.`id_motivo` = `m`.`id`))union select 'seduta' AS `origin`,`sp`.`id` AS `id`,`sp`.`row_inizio` AS `row_inizio`,`sp`.`row_fine` AS `row_fine`,`sp`.`id_terapista` AS `id_terapista`,`sp`.`data` AS `data`,concat(left(`c`.`nominativo`,20),'>',left(`t`.`trattamento`,20)) AS `motivo` from (((`percorsi_terapeutici_sedute_prenotate` `sp` left join `clienti` `c` on(`sp`.`id_cliente` = `c`.`id`)) left join `percorsi_terapeutici_sedute` `s` on(`sp`.`id_seduta` = `s`.`id`)) left join `trattamenti` `t` on(`s`.`id_trattamento` = `t`.`id`))  ;

DROP VIEW IF EXISTS `view_corsi`;

CREATE VIEW `view_corsi`  AS SELECT `c`.`id` AS `id`, `c`.`tipo` AS `tipo`, `c`.`id_categoria` AS `id_categoria`, `c`.`corso` AS `corso`, `c`.`prezzo` AS `prezzo`, `cc`.`categoria` AS `categoria` FROM (`corsi` `c` left join `corsi_categorie` `cc` on(`c`.`id_categoria` = `cc`.`id`)) ;


DROP VIEW IF EXISTS `view_fatture`;

CREATE VIEW `view_fatture`  AS SELECT `f`.`id` AS `id`, `f`.`id_cliente` AS `id_cliente`, `f`.`link` AS `link`, `f`.`importo` AS `importo`, `f`.`index` AS `index`, `f`.`data` AS `data`, `f`.`stato` AS `stato`, `f`.`timestamp` AS `timestamp`, `c`.`nominativo` AS `nominativo` FROM (`fatture` `f` left join `clienti` `c` on(`f`.`id_cliente` = `c`.`id`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_percorsi`
--
DROP VIEW IF EXISTS `view_percorsi`;

CREATE VIEW `view_percorsi`  AS SELECT `pt`.`id` AS `id`, `pt`.`id_cliente` AS `id_cliente`, `pt`.`id_trattamento` AS `id_trattamento`, `pt`.`sedute` AS `sedute`, `pt`.`prezzo_tabellare` AS `prezzo_tabellare`, `pt`.`prezzo` AS `prezzo`, `pt`.`note` AS `note`, `pt`.`timestamp` AS `timestamp`, `t`.`trattamento` AS `trattamento`, `t`.`tipo` AS `tipo`, if(`pt`.`sedute` <= ifnull(`p`.`sp_count`,0),'Concluso','Attivo') AS `stato` FROM ((`percorsi_terapeutici` `pt` left join `trattamenti` `t` on(`pt`.`id_trattamento` = `t`.`id`)) left join (select `percorsi_terapeutici_sedute_prenotate`.`id_percorso` AS `id_percorso`,count(`percorsi_terapeutici_sedute_prenotate`.`id`) AS `sp_count` from `percorsi_terapeutici_sedute_prenotate` where `percorsi_terapeutici_sedute_prenotate`.`stato_prenotazione` = 'Conclusa' group by `percorsi_terapeutici_sedute_prenotate`.`id_percorso`) `p` on(`pt`.`id` = `p`.`id_percorso`)) ORDER BY `pt`.`timestamp` DESC ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_percorsi_pagamenti`
--
DROP VIEW IF EXISTS `view_percorsi_pagamenti`;

CREATE VIEW `view_percorsi_pagamenti`  AS SELECT `pp`.`id_percorso` AS `id_percorso`, `pp`.`id_cliente` AS `id_cliente`, `t`.`trattamento` AS `trattamento`, `pp`.`prezzo_tabellare` AS `prezzo_tabellare`, `pp`.`prezzo` AS `prezzo`, coalesce(`sf`.`saldato_fatture`,0) + coalesce(`ssf`.`totale_valore`,0) AS `saldato`, coalesce(`sf`.`pendente_fatture`,0) AS `fatturato`, `pp`.`prezzo`- (coalesce(`ssf`.`totale_valore`,0) + coalesce(`sf`.`saldato_fatture`,0) + coalesce(`sf`.`pendente_fatture`,0)) AS `non_fatturato` FROM ((((`percorsi_pagamenti` `pp` left join (select `percorsi_pagamenti_senza_fattura`.`id_percorso` AS `id_percorso`,coalesce(sum(`percorsi_pagamenti_senza_fattura`.`valore`),0) AS `totale_valore` from `percorsi_pagamenti_senza_fattura` group by `percorsi_pagamenti_senza_fattura`.`id_percorso`) `ssf` on(`pp`.`id_percorso` = `ssf`.`id_percorso`)) left join (select `ppf`.`id_percorso` AS `id_percorso`,sum(case when `f`.`stato` = 'Saldata' then `f`.`importo` else 0 end) AS `saldato_fatture`,sum(case when `f`.`stato` = 'Pendente' then `f`.`importo` else 0 end) AS `pendente_fatture` from (`percorsi_pagamenti_fatture` `ppf` left join `fatture` `f` on(`ppf`.`id_fattura` = `f`.`id`)) group by `ppf`.`id_percorso`) `sf` on(`pp`.`id_percorso` = `sf`.`id_percorso`)) left join `percorsi_terapeutici` `pt` on(`pp`.`id_percorso` = `pt`.`id`)) left join `trattamenti` `t` on(`pt`.`id_trattamento` = `t`.`id`)) ;

-- --------------------------------------------------------

--
-- Struttura per vista `view_sedute`
--
DROP TABLE IF EXISTS `view_sedute`;

DROP VIEW IF EXISTS `view_sedute`;

CREATE VIEW `view_sedute`  AS SELECT `pts`.`id` AS `id`, `pts`.`index` AS `index`, `pts`.`id_cliente` AS `id_cliente`, `pts`.`id_percorso` AS `id_percorso`, `pts`.`id_trattamento` AS `id_trattamento`, if(`ptsp_Conclusa`.`id` is not null,'Conclusa',if(`ptsp_Spostata`.`id` is not null,'Spostata',if(`ptsp_Assente`.`id` is not null,'Assente',if(`ptsp_Prenotata`.`id` is not null,'Prenotata','Da Prenotare')))) AS `stato` FROM ((((`percorsi_terapeutici_sedute` `pts` left join `percorsi_terapeutici_sedute_prenotate` `ptsp_Assente` on(`ptsp_Assente`.`id_seduta` = `pts`.`id` and `ptsp_Assente`.`stato_prenotazione` = 'Assente')) left join `percorsi_terapeutici_sedute_prenotate` `ptsp_Spostata` on(`ptsp_Spostata`.`id_seduta` = `pts`.`id` and `ptsp_Spostata`.`stato_prenotazione` = 'Spostata')) left join `percorsi_terapeutici_sedute_prenotate` `ptsp_Conclusa` on(`ptsp_Conclusa`.`id_seduta` = `pts`.`id` and `ptsp_Conclusa`.`stato_prenotazione` = 'Conclusa')) left join `percorsi_terapeutici_sedute_prenotate` `ptsp_Prenotata` on(`ptsp_Prenotata`.`id_seduta` = `pts`.`id` and `ptsp_Prenotata`.`stato_prenotazione` = 'Prenotata')) GROUP BY `pts`.`id`, `pts`.`index`, `pts`.`id_cliente`, `pts`.`id_percorso`, `pts`.`id_trattamento`, if(`ptsp_Conclusa`.`id` is not null,'Conclusa',if(`ptsp_Spostata`.`id` is not null,'Spostata',if(`ptsp_Assente`.`id` is not null,'Assente',if(`ptsp_Prenotata`.`id` is not null,'Prenotata','Da Prenotare')))) ;

-- --------------------------------------------------------

--
DROP TABLE IF EXISTS `view_trattamenti`;
DROP VIEW IF EXISTS `view_trattamenti`;

CREATE VIEW `view_trattamenti`  AS SELECT `t`.`id` AS `id`, `t`.`tipo` AS `tipo`, `t`.`id_categoria` AS `id_categoria`, `t`.`trattamento` AS `trattamento`, `t`.`prezzo` AS `prezzo`, `tc`.`categoria` AS `categoria` FROM (`trattamenti` `t` left join `trattamenti_categorie` `tc` on(`t`.`id_categoria` = `tc`.`id`)) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `clienti`
--
ALTER TABLE `clienti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `corsi`
--
ALTER TABLE `corsi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indici per le tabelle `corsi_categorie`
--
ALTER TABLE `corsi_categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `corsi_classi`
--
ALTER TABLE `corsi_classi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_corso` (`id_corso`);

--
-- Indici per le tabelle `fatture`
--
ALTER TABLE `fatture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indici per le tabelle `motivi`
--
ALTER TABLE `motivi`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `percorsi_pagamenti`
--
ALTER TABLE `percorsi_pagamenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_percorso` (`id_percorso`);

--
-- Indici per le tabelle `percorsi_pagamenti_fatture`
--
ALTER TABLE `percorsi_pagamenti_fatture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_percorso` (`id_percorso`),
  ADD KEY `id_fattura` (`id_fattura`);

--
-- Indici per le tabelle `percorsi_pagamenti_senza_fattura`
--
ALTER TABLE `percorsi_pagamenti_senza_fattura`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `percorsi_terapeutici`
--
ALTER TABLE `percorsi_terapeutici`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_trattamento` (`id_trattamento`);

--
-- Indici per le tabelle `percorsi_terapeutici_sedute`
--
ALTER TABLE `percorsi_terapeutici_sedute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_ciclo` (`id_percorso`),
  ADD KEY `id_trattamento` (`id_trattamento`);

--
-- Indici per le tabelle `percorsi_terapeutici_sedute_prenotate`
--
ALTER TABLE `percorsi_terapeutici_sedute_prenotate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sedute` (`id_seduta`),
  ADD KEY `id_terapista` (`id_terapista`),
  ADD KEY `row_inizio` (`row_inizio`),
  ADD KEY `row_fine` (`row_fine`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_percorso` (`id_percorso`);

--
-- Indici per le tabelle `planning_motivi`
--
ALTER TABLE `planning_motivi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_motivo` (`id_motivo`),
  ADD KEY `row_inizio` (`row_inizio`),
  ADD KEY `row_fine` (`row_fine`),
  ADD KEY `id_terapista` (`id_terapista`);

--
-- Indici per le tabelle `planning_row`
--
ALTER TABLE `planning_row`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `terapisti`
--
ALTER TABLE `terapisti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `trattamenti`
--
ALTER TABLE `trattamenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indici per le tabelle `trattamenti_categorie`
--
ALTER TABLE `trattamenti_categorie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `clienti`
--
ALTER TABLE `clienti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT per la tabella `corsi`
--
ALTER TABLE `corsi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `corsi_categorie`
--
ALTER TABLE `corsi_categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `corsi_classi`
--
ALTER TABLE `corsi_classi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `fatture`
--
ALTER TABLE `fatture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT per la tabella `motivi`
--
ALTER TABLE `motivi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `percorsi_pagamenti`
--
ALTER TABLE `percorsi_pagamenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT per la tabella `percorsi_pagamenti_fatture`
--
ALTER TABLE `percorsi_pagamenti_fatture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT per la tabella `percorsi_pagamenti_senza_fattura`
--
ALTER TABLE `percorsi_pagamenti_senza_fattura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `percorsi_terapeutici`
--
ALTER TABLE `percorsi_terapeutici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT per la tabella `percorsi_terapeutici_sedute`
--
ALTER TABLE `percorsi_terapeutici_sedute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;

--
-- AUTO_INCREMENT per la tabella `percorsi_terapeutici_sedute_prenotate`
--
ALTER TABLE `percorsi_terapeutici_sedute_prenotate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT per la tabella `planning_motivi`
--
ALTER TABLE `planning_motivi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT per la tabella `planning_row`
--
ALTER TABLE `planning_row`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT per la tabella `setup`
--
ALTER TABLE `setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `terapisti`
--
ALTER TABLE `terapisti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `trattamenti`
--
ALTER TABLE `trattamenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT per la tabella `trattamenti_categorie`
--
ALTER TABLE `trattamenti_categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `percorsi_pagamenti`
--
ALTER TABLE `percorsi_pagamenti`
  ADD CONSTRAINT `id_percorso` FOREIGN KEY (`id_percorso`) REFERENCES `percorsi_terapeutici` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `percorsi_pagamenti_fatture`
--
ALTER TABLE `percorsi_pagamenti_fatture`
  ADD CONSTRAINT `id_fatture` FOREIGN KEY (`id_fattura`) REFERENCES `fatture` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `percorsi_terapeutici`
--
ALTER TABLE `percorsi_terapeutici`
  ADD CONSTRAINT `id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clienti` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `percorsi_terapeutici_sedute`
--
ALTER TABLE `percorsi_terapeutici_sedute`
  ADD CONSTRAINT `cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clienti` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `percorsi` FOREIGN KEY (`id_percorso`) REFERENCES `percorsi_terapeutici` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `percorsi_terapeutici_sedute_prenotate`
--
ALTER TABLE `percorsi_terapeutici_sedute_prenotate`
  ADD CONSTRAINT `id_sedute` FOREIGN KEY (`id_seduta`) REFERENCES `percorsi_terapeutici_sedute` (`id`) ON DELETE CASCADE;
