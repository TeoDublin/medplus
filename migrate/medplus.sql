ALTER TABLE `percorsi_terapeutici` CHANGE `id_trattamento` `id_combo` INT NULL DEFAULT NULL;
ALTER TABLE `percorsi_terapeutici_sedute` CHANGE `id_trattamento` `id_combo` INT NULL DEFAULT NULL;

CREATE TABLE `percorsi_combo` (
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `percorsi_combo`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `percorsi_combo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


CREATE TABLE `percorsi_combo_trattamenti` (
  `id` int NOT NULL,
  `id_combo` int NOT NULL,
  `id_trattamento` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `percorsi_combo_trattamenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_combo` (`id_combo`),
  ADD KEY `id_trattamento` (`id_trattamento`);

ALTER TABLE `percorsi_combo_trattamenti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


DROP VIEW view_percorsi;
CREATE VIEW view_percorsi AS 
SELECT 
    pt.id AS id,
    pt.id_cliente AS id_cliente,
    pt.id_combo AS id_combo,
    pt.sedute AS sedute,
    pt.prezzo_tabellare AS prezzo_tabellare,
    pt.prezzo AS prezzo,
    pt.note AS note,
    pt.timestamp AS timestamp,
    t.trattamenti AS trattamento,
    ta.acronimo AS acronimo,
    IF(pt.sedute <= IFNULL(p.sp_count, 0), 'Concluso', 'Attivo') COLLATE utf8mb4_general_ci AS `stato`
FROM percorsi_terapeutici pt
LEFT JOIN percorsi_combo pc ON pt.id_combo = pc.id
LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) t ON pc.id = t.id_combo
LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.acronimo SEPARATOR ' - ') AS acronimo
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) ta ON pc.id = ta.id_combo
LEFT JOIN (
    SELECT 
        pts.id_percorso AS id_percorso,
        COUNT(pts.id) AS sp_count
    FROM percorsi_terapeutici_sedute_prenotate pts
    WHERE pts.stato_prenotazione = 'Conclusa'
    GROUP BY pts.id_percorso
) p ON pt.id = p.id_percorso
ORDER BY pt.timestamp DESC;


DROP VIEW IF EXISTS `view_pagamenti`;

CREATE VIEW `view_pagamenti` AS
SELECT 
    'trattamenti' COLLATE utf8mb4_general_ci AS `origine`,
    pt.`id`,
    pt.`id_cliente`,
    pt.id_combo AS `id_origine`,
    t.`trattamenti` AS `nome`,
	ta.`acronimo` AS `acronimo`,
    DATE_FORMAT(pt.`timestamp`, '%Y-%m-%d') COLLATE utf8mb4_general_ci AS `scadenza`,
    pt.`prezzo_tabellare`,
    pt.`prezzo`,
    COALESCE(pf.`saldato_fatture`, 0) + COALESCE(psf.`totale_valore`, 0) + COALESCE(pa.`totale_valore`, 0) AS `saldato`,
    COALESCE(pf.`pendente_fatture`, 0) AS `fatturato`,
    pt.`prezzo` - (
        COALESCE(psf.`totale_valore`, 0) + 
        COALESCE(pa.`totale_valore`, 0) + 
        COALESCE(pf.`saldato_fatture`, 0) + 
        COALESCE(pf.`pendente_fatture`, 0)
    ) AS `non_fatturato`
FROM `percorsi_terapeutici` pt
LEFT JOIN percorsi_combo pc ON pt.id_combo = pc.id
LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) t ON pc.id = t.id_combo
LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.acronimo SEPARATOR ' - ') AS acronimo
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) ta ON pc.id = ta.id_combo
LEFT JOIN (
    SELECT `id_origine`, COALESCE(SUM(`valore`), 0) AS `totale_valore`
    FROM `pagamenti_senza_fattura`
    GROUP BY `id_origine`
) psf ON pt.`id` = psf.`id_origine`
LEFT JOIN (
    SELECT `id_origine`, COALESCE(SUM(`valore`), 0) AS `totale_valore`
    FROM `pagamenti_aruba`
    GROUP BY `id_origine`
) pa ON pt.`id` = pa.`id_origine`
LEFT JOIN (
    SELECT 
        pf.`id_origine`,
        pf.`origine`,
        SUM(CASE WHEN f.`stato` = 'Saldata' THEN pf.`importo` ELSE 0 END) AS `saldato_fatture`,
        SUM(CASE WHEN f.`stato` = 'Pendente' THEN pf.`importo` ELSE 0 END) AS `pendente_fatture`
    FROM `pagamenti_fatture` pf
    LEFT JOIN `fatture` f ON pf.`id_fattura` = f.`id`
    GROUP BY pf.`id_origine`, pf.`origine`
) pf ON pt.`id` = pf.`id_origine` AND pf.`origine` = 'trattamenti'

UNION ALL

SELECT 
    'corsi' COLLATE utf8mb4_general_ci AS `origine`,
    cp.`id`,
    cp.`id_cliente`,
    c.`id` AS `id_origine`,
    c.`corso` AS `nome`,
	c.`corso` AS `acronimo`,
    cp.`scadenza` COLLATE utf8mb4_general_ci AS `scadenza`,
    cp.`prezzo_tabellare`,
    cp.`prezzo`,
    COALESCE(pf.`saldato_fatture`, 0) + COALESCE(psf.`totale_valore`, 0) + COALESCE(pa.`totale_valore`, 0) AS `saldato`,
    COALESCE(pf.`pendente_fatture`, 0) AS `fatturato`,
    cp.`prezzo` - (
        COALESCE(psf.`totale_valore`, 0) + 
        COALESCE(pa.`totale_valore`, 0) + 
        COALESCE(pf.`saldato_fatture`, 0) + 
        COALESCE(pf.`pendente_fatture`, 0)
    ) AS `non_fatturato`
FROM `corsi_pagamenti` cp
LEFT JOIN (
    SELECT `id_origine`, COALESCE(SUM(`valore`), 0) AS `totale_valore`
    FROM `pagamenti_senza_fattura`
    GROUP BY `id_origine`
) psf ON cp.`id` = psf.`id_origine`
LEFT JOIN (
    SELECT `id_origine`, COALESCE(SUM(`valore`), 0) AS `totale_valore`
    FROM `pagamenti_aruba`
    GROUP BY `id_origine`
) pa ON cp.`id` = pa.`id_origine`
LEFT JOIN (
    SELECT 
        pf.`id_origine`,
        pf.`origine`,
        SUM(CASE WHEN f.`stato` = 'Saldata' THEN pf.`importo` ELSE 0 END) AS `saldato_fatture`,
        SUM(CASE WHEN f.`stato` = 'Pendente' THEN pf.`importo` ELSE 0 END) AS `pendente_fatture`
    FROM `pagamenti_fatture` pf
    LEFT JOIN `fatture` f ON pf.`id_fattura` = f.`id`
    GROUP BY pf.`id_origine`, pf.`origine`
) pf ON cp.`id` = pf.`id_origine` AND pf.`origine` = 'corsi'
LEFT JOIN `corsi` c ON cp.`id_corso` = c.`id`;

DROP VIEW view_sedute;

CREATE VIEW view_sedute AS
SELECT 
    pts.id AS id,
    pts.`index` AS `index`,
    pts.id_cliente AS id_cliente,
    pts.id_percorso AS id_percorso,
    pts.id_combo AS id_combo,
    IF(ptsp_Conclusa.id IS NOT NULL, 'Conclusa',
        IF(ptsp_Spostata.id IS NOT NULL, 'Spostata',
            IF(ptsp_Assente.id IS NOT NULL, 'Assente',
                IF(ptsp_Prenotata.id IS NOT NULL, 'Prenotata', 'Da Prenotare')
            )
        )
    ) AS stato
FROM percorsi_terapeutici_sedute pts
LEFT JOIN percorsi_terapeutici_sedute_prenotate ptsp_Assente ON ptsp_Assente.id_seduta = pts.id AND ptsp_Assente.stato_prenotazione = 'Assente'
LEFT JOIN percorsi_terapeutici_sedute_prenotate ptsp_Spostata ON ptsp_Spostata.id_seduta = pts.id AND ptsp_Spostata.stato_prenotazione = 'Spostata'
LEFT JOIN percorsi_terapeutici_sedute_prenotate ptsp_Conclusa ON ptsp_Conclusa.id_seduta = pts.id AND ptsp_Conclusa.stato_prenotazione = 'Conclusa'
LEFT JOIN percorsi_terapeutici_sedute_prenotate ptsp_Prenotata ON ptsp_Prenotata.id_seduta = pts.id AND ptsp_Prenotata.stato_prenotazione = 'Prenotata'
GROUP BY 
    pts.id, 
    pts.`index`, 
    pts.id_cliente, 
    pts.id_percorso, 
    pts.id_combo, 
    stato;

CREATE TABLE `colloquio_planning` (
  `id` int NOT NULL,
  `row_inizio` int NOT NULL,
  `row_fine` int NOT NULL,
  `id_terapista` int NOT NULL,
  `id_cliente` int NOT NULL,
  `data` date NOT NULL,
  `stato_prenotazione` enum('Assente','Conclusa','Prenotata') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Prenotata'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `colloquio_planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_terapista` (`id_terapista`),
  ADD KEY `id_cliente` (`id_cliente`);

ALTER TABLE `colloquio_planning`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


DROP VIEW IF EXISTS view_planning;
CREATE VIEW view_planning AS
SELECT 
    'sbarra' AS origin,
    pm.id AS id,
    pm.row_inizio AS row_inizio,
    pm.row_fine AS row_fine,
    pm.id_terapista AS id_terapista,
    pm.data AS data,
    LEFT(m.motivo, 40) AS motivo,
    '-' AS stato
FROM planning_motivi pm
LEFT JOIN motivi m ON pm.id_motivo = m.id

UNION ALL

SELECT 
    'seduta' AS origin,
    sp.id AS id,
    sp.row_inizio AS row_inizio,
    sp.row_fine AS row_fine,
    sp.id_terapista AS id_terapista,
    sp.data AS data,
    CONCAT(LEFT(c.nominativo, 20), '>', LEFT(t.trattamenti, 20)) AS motivo,
    sp.stato_prenotazione AS stato
FROM percorsi_terapeutici_sedute_prenotate sp
LEFT JOIN clienti c ON sp.id_cliente = c.id
LEFT JOIN percorsi_terapeutici_sedute s ON sp.id_seduta = s.id
LEFT JOIN percorsi_combo pc ON s.id_combo = pc.id
LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) t ON pc.id = t.id_combo

UNION ALL

SELECT 
    'corso' AS origin,
    cp.id AS id,
    cp.row_inizio AS row_inizio,
    cp.row_fine AS row_fine,
    cp.id_terapista AS id_terapista,
    cp.data AS data,
    LEFT(cp.motivo, 40) AS motivo,
    '-' AS stato
FROM corsi_planning cp

UNION ALL

SELECT 
    'colloquio' AS origin,
    cp.id AS id,
    cp.row_inizio AS row_inizio,
    cp.row_fine AS row_fine,
    cp.id_terapista AS id_terapista,
    cp.data AS data,
    CONCAT(LEFT(c.nominativo, 28), ' > Colloquio') AS motivo,
    cp.stato_prenotazione AS stato
FROM colloquio_planning cp
LEFT JOIN clienti c ON cp.id_cliente = c.id;

CREATE VIEW view_colloqui AS 
SELECT cp.*,c.nominativo,t.terapista,pr_start.ora as ora_inizio, pr_end.ora as ora_fine
FROM `colloquio_planning` cp
LEFT JOIN clienti c ON cp.id_cliente = c.id
LEFT JOIN terapisti t ON cp.id_terapista = t.id
LEFT JOIN planning_row pr_start ON cp.row_inizio = pr_start.id
LEFT JOIN planning_row pr_end ON cp.row_fine = pr_end.id;


CREATE TABLE `utenti_preferenze` (
  `id` int NOT NULL,
  `id_utente` int NOT NULL,
  `chiave` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `valore` longtext COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `utenti_preferenze` (`id`, `id_utente`, `chiave`, `valore`) VALUES
(1, 1, 'planning_colors', ':root{\r\n    --base-bg-colloquio:#aad5d8;\r\n    --base-bg-seduta:#56ebf7;\r\n    --base-bg-corso:#32ffbb;\r\n    --base-bg-sbarra:#5d7fff;\r\n}'),
(2, 2, 'planning_colors', ':root{\r\n    --base-bg-colloquio:#aad5d8;\r\n    --base-bg-seduta:#56ebf7;\r\n    --base-bg-corso:#32ffbb;\r\n    --base-bg-sbarra:#5d7fff;\r\n}');

ALTER TABLE `utenti_preferenze`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);


ALTER TABLE `utenti_preferenze`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


DROP VIEW view_planning;
CREATE VIEW view_planning AS
SELECT 
  'sbarra' AS `origin`,
  `pm`.`id` AS `id`,
  `pm`.`row_inizio` AS `row_inizio`,
  `pm`.`row_fine` AS `row_fine`,
  `pm`.`row_fine` - `pm`.`row_inizio` + 1 AS `row_span`,
  `pm`.`id_terapista` AS `id_terapista`,
  `pm`.`data` AS `data`,
  CONCAT(`pm`.`data`, ' ', `pr`.`ora`) AS `data_fine`,
  `m`.`motivo` AS `motivo`,
  '-' AS `stato`
FROM 
  `planning_motivi` `pm`
  LEFT JOIN `motivi` `m` ON `pm`.`id_motivo` = `m`.`id`
  LEFT JOIN `planning_row` `pr` ON `pm`.`row_fine` = `pr`.`id`

UNION ALL

SELECT 
  'seduta' AS `origin`,
  `sp`.`id` AS `id`,
  `sp`.`row_inizio` AS `row_inizio`,
  `sp`.`row_fine` AS `row_fine`,
  `sp`.`row_fine` - `sp`.`row_inizio` + 1 AS `row_span`,
  `sp`.`id_terapista` AS `id_terapista`,
  `sp`.`data` AS `data`,
  CONCAT(`sp`.`data`, ' ', `pr`.`ora`) AS `data_fine`,
  CONCAT(`c`.`nominativo`, ' (', `t`.`trattamenti`, ')') AS `motivo`,
  `sp`.`stato_prenotazione` AS `stato`
FROM 
  `percorsi_terapeutici_sedute_prenotate` `sp`
  LEFT JOIN `planning_row` `pr` ON `sp`.`row_fine` = `pr`.`id`
  LEFT JOIN `clienti` `c` ON `sp`.`id_cliente` = `c`.`id`
  LEFT JOIN `percorsi_terapeutici_sedute` `s` ON `sp`.`id_seduta` = `s`.`id`
  LEFT JOIN `percorsi_combo` `pc` ON `s`.`id_combo` = `pc`.`id`
  LEFT JOIN 
    (SELECT 
       `pct`.`id_combo` AS `id_combo`,
       GROUP_CONCAT(`t`.`trattamento` SEPARATOR ', ') AS `trattamenti`
     FROM 
       `percorsi_combo_trattamenti` `pct`
       LEFT JOIN `trattamenti` `t` ON `pct`.`id_trattamento` = `t`.`id`
     GROUP BY `pct`.`id_combo`) `t` 
  ON `pc`.`id` = `t`.`id_combo`
WHERE 
  `sp`.`stato_prenotazione` <> 'Assente'

UNION ALL

SELECT 
  'corso' AS `origin`,
  `cp`.`id` AS `id`,
  `cp`.`row_inizio` AS `row_inizio`,
  `cp`.`row_fine` AS `row_fine`,
  `cp`.`row_fine` - `cp`.`row_inizio` + 1 AS `row_span`,
  `cp`.`id_terapista` AS `id_terapista`,
  `cp`.`data` AS `data`,
  CONCAT(`cp`.`data`, ' ', `pr`.`ora`) AS `data_fine`,
  CONCAT(`cp`.`motivo`,' ( Corso )') AS `motivo`,
  '-' AS `stato`
FROM 
  `corsi_planning` `cp`
  LEFT JOIN `planning_row` `pr` ON `cp`.`row_fine` = `pr`.`id`

UNION ALL

SELECT 
  'colloquio' AS `origin`,
  `cp`.`id` AS `id`,
  `cp`.`row_inizio` AS `row_inizio`,
  `cp`.`row_fine` AS `row_fine`,
  `cp`.`row_fine` - `cp`.`row_inizio` + 1 AS `row_span`,
  `cp`.`id_terapista` AS `id_terapista`,
  `cp`.`data` AS `data`,
  CONCAT(`cp`.`data`, ' ', `pr`.`ora`) AS `data_fine`,
  CONCAT(`c`.`nominativo`, ' ( Colloquio )') AS `motivo`,
  `cp`.`stato_prenotazione` AS `stato`
FROM 
  `colloquio_planning` `cp`
  LEFT JOIN `clienti` `c` ON `cp`.`id_cliente` = `c`.`id`
  LEFT JOIN `planning_row` `pr` ON `cp`.`row_fine` = `pr`.`id`;

DROP VIEW view_sedute;
CREATE VIEW view_sedute AS
SELECT 
    pts.id AS id,
    pts.`index` AS `index`,
    pts.id_cliente AS id_cliente,
    pts.id_percorso AS id_percorso,
    pts.id_combo AS id_combo,
    ptsp.data AS data,
    CASE 
        WHEN ptsp_Conclusa.id IS NOT NULL THEN 'Conclusa'
        WHEN ptsp_Prenotata.id IS NOT NULL THEN 'Prenotata'
        WHEN ptsp_Assente.id IS NOT NULL THEN 'Assente'
        ELSE 'Da Prenotare' 
    END AS stato
FROM 
    percorsi_terapeutici_sedute AS pts
LEFT JOIN 
    percorsi_terapeutici_sedute_prenotate AS ptsp 
    ON pts.id = ptsp.id_seduta
LEFT JOIN 
    percorsi_terapeutici_sedute_prenotate AS ptsp_Assente 
    ON pts.id = ptsp_Assente.id_seduta 
    AND ptsp_Assente.stato_prenotazione = 'Assente'
LEFT JOIN 
    percorsi_terapeutici_sedute_prenotate AS ptsp_Conclusa 
    ON pts.id = ptsp_Conclusa.id_seduta 
    AND ptsp_Conclusa.stato_prenotazione = 'Conclusa'
LEFT JOIN 
    percorsi_terapeutici_sedute_prenotate AS ptsp_Prenotata 
    ON pts.id = ptsp_Prenotata.id_seduta 
    AND ptsp_Prenotata.stato_prenotazione = 'Prenotata'
GROUP BY 
    pts.id;


