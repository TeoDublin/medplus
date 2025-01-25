DROP TABLE `percorsi_pagamenti`;

DROP VIEW IF EXISTS `view_percorsi_pagamenti`;
CREATE VIEW `view_percorsi_pagamenti` AS
SELECT 
    `pt`.`id` AS `id_percorso`,
    `pt`.`id_cliente` AS `id_cliente`,
    `t`.`trattamento` AS `trattamento`,
    `pt`.`prezzo_tabellare` AS `prezzo_tabellare`,
    `pt`.`prezzo` AS `prezzo`,
    (COALESCE(`sf`.`saldato_fatture`, 0) + COALESCE(`ssf`.`totale_valore`, 0)) AS `saldato`,
    COALESCE(`sf`.`pendente_fatture`, 0) AS `fatturato`,
    (`pt`.`prezzo` - (
        (COALESCE(`ssf`.`totale_valore`, 0) + COALESCE(`sf`.`saldato_fatture`, 0)) 
        + COALESCE(`sf`.`pendente_fatture`, 0)
    )) AS `non_fatturato`
FROM 
    `medplus`.`percorsi_terapeutici` `pt`
LEFT JOIN (
    SELECT 
        `medplus`.`percorsi_pagamenti_senza_fattura`.`id_percorso` AS `id_percorso`,
        COALESCE(SUM(`medplus`.`percorsi_pagamenti_senza_fattura`.`valore`), 0) AS `totale_valore`
    FROM 
        `medplus`.`percorsi_pagamenti_senza_fattura`
    GROUP BY 
        `medplus`.`percorsi_pagamenti_senza_fattura`.`id_percorso`
) `ssf` 
ON `pt`.`id` = `ssf`.`id_percorso`
LEFT JOIN (
    SELECT 
        `ppf`.`id_percorso` AS `id_percorso`,
        SUM(CASE WHEN `f`.`stato` = 'Saldata' THEN `ppf`.`importo` ELSE 0 END) AS `saldato_fatture`,
        SUM(CASE WHEN `f`.`stato` = 'Pendente' THEN `ppf`.`importo` ELSE 0 END) AS `pendente_fatture`
    FROM 
        `medplus`.`percorsi_pagamenti_fatture` `ppf`
    LEFT JOIN 
        `medplus`.`fatture` `f` 
    ON 
        `ppf`.`id_fattura` = `f`.`id`
    GROUP BY 
        `ppf`.`id_percorso`
) `sf` 
ON `pt`.`id` = `sf`.`id_percorso`
LEFT JOIN 
    `medplus`.`trattamenti` `t`
ON 
    `pt`.`id_trattamento` = `t`.`id`;

DROP TABLE IF EXISTS `percorsi_pagamenti_senza_fattura`;

CREATE TABLE `percorsi_pagamenti_senza_fattura` (
    `id` int NOT NULL,
    `id_cliente` int NOT NULL,
    `id_percorso` int NOT NULL,
    `valore` double(10,2) NOT NULL,
    `note` longtext COLLATE utf8mb4_general_ci,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `percorsi_pagamenti_senza_fattura` ADD PRIMARY KEY (`id`);

ALTER TABLE `percorsi_pagamenti_senza_fattura` MODIFY `id` int NOT NULL AUTO_INCREMENT;

DROP TABLE IF EXISTS `corsi`;

CREATE TABLE `corsi` (
    `id` int NOT NULL,
    `id_categoria` int NOT NULL,
    `corso` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
    `prezzo` double(10,2) NOT NULL,
    `scadenza` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `corsi` ADD PRIMARY KEY (`id`), ADD KEY `id_categoria` (`id_categoria`);

ALTER TABLE `corsi` MODIFY `id` int NOT NULL AUTO_INCREMENT;

CREATE TABLE `corsi_giorni` (
    `id` int NOT NULL,
    `id_corso` int NOT NULL,
    `giorno` enum('LUNEDI','MARTEDI','MERCOLEDI','GIOVEDI','VENERDI','SABATO','DOMENICA') COLLATE utf8mb4_general_ci NOT NULL,
    `ora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `corsi_giorni` ADD PRIMARY KEY (`id`), ADD KEY `id_corso` (`id_corso`);

ALTER TABLE `corsi_giorni` MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `corsi_giorni` ADD CONSTRAINT `corsi_giorni` FOREIGN KEY (`id_corso`) REFERENCES `corsi` (`id`) ON DELETE CASCADE;

DROP VIEW IF EXISTS `view_corsi`; 
CREATE VIEW `view_corsi`
 AS select `c`.`id` AS `id`,`c`.`id_categoria` AS `id_categoria`,`c`.`corso` AS `corso`,`c`.`prezzo` AS `prezzo`,`c`.`scadenza` AS `scadenza`,`cc`.`categoria` AS `categoria` from (`medplus`.`corsi` `c` left join `medplus`.`corsi_categorie` `cc` on((`c`.`id_categoria` = `cc`.`id`)));