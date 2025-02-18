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
    IF(pt.sedute <= IFNULL(p.sp_count, 0), 'Concluso', 'Attivo') AS stato
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
