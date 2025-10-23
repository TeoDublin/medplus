DROP VIEW IF EXISTS view_sedute;
CREATE VIEW view_sedute AS
SELECT 
    `pts`.`id` AS `id`,
    `pts`.`index` AS `index`,
    `pts`.`id_cliente` AS `id_cliente`,
    `pts`.`id_percorso` AS `id_percorso`,
    `pts`.`id_combo` AS `id_combo`,
    `pts`.`prezzo` AS `prezzo`,
    `pts`.`saldato` AS `saldato`,
    `pts`.`id_terapista` AS `id_terapista`,
    `pts`.`percentuale_terapista` AS `percentuale_terapista`,
    `pts`.`saldo_terapista` AS `saldo_terapista`,
    `pts`.`saldato_terapista` AS `saldato_terapista`,
    (`pts`.`stato_seduta` COLLATE utf8mb4_general_ci) AS `stato_seduta`,
    (`pts`.`stato_pagamento` COLLATE utf8mb4_general_ci) AS `stato_pagamento`,
    (`pts`.`stato_saldato_terapista` COLLATE utf8mb4_general_ci) AS `stato_saldato_terapista`,
    (`pts`.`data_seduta` COLLATE utf8mb4_general_ci) AS `data_seduta`,
    (`pts`.`data_pagamento` COLLATE utf8mb4_general_ci) AS `data_pagamento`,
    (`pts`.`data_saldato_terapista` COLLATE utf8mb4_general_ci) AS `data_saldato_terapista`,
    (`pts`.`timestamp` COLLATE utf8mb4_general_ci) AS `timestamp`,
    (`c`.`nominativo` COLLATE utf8mb4_general_ci) AS `nominativo`,
    (`tpd`.`terapista` COLLATE utf8mb4_general_ci) AS `portato_da`,
    (`t`.`terapista` COLLATE utf8mb4_general_ci) AS `terapista`,
    (`tc`.`trattamenti` COLLATE utf8mb4_general_ci) AS `trattamenti`,
    (`ta`.`acronimo` COLLATE utf8mb4_general_ci) AS `acronimo`,
    `pts`.`tipo_pagamento` AS `tipo_pagamento`,
    `pt`.`realizzato_da` AS `realizzato_da`,
    `pt`.`bnw` AS `bnw`
FROM 
    `medplus`.`percorsi_terapeutici_sedute` AS `pts`
LEFT JOIN 
    `medplus`.`percorsi_terapeutici` AS `pt` 
    ON `pts`.`id_percorso` = `pt`.`id`
LEFT JOIN 
    `medplus`.`terapisti` AS `t` 
    ON `pts`.`id_terapista` = `t`.`id`
LEFT JOIN 
    `medplus`.`clienti` AS `c` 
    ON `pts`.`id_cliente` = `c`.`id`
LEFT JOIN 
    `medplus`.`terapisti` AS `tpd` 
    ON `c`.`portato_da` = `tpd`.`id`
LEFT JOIN 
    (
        SELECT 
            `pct`.`id_combo` AS `id_combo`,
            GROUP_CONCAT(`t`.`trattamento` SEPARATOR ';') AS `trattamenti`
        FROM 
            `medplus`.`percorsi_combo_trattamenti` AS `pct`
        LEFT JOIN 
            `medplus`.`trattamenti` AS `t` 
            ON `pct`.`id_trattamento` = `t`.`id`
        GROUP BY 
            `pct`.`id_combo`
    ) AS `tc` 
    ON `pts`.`id_combo` = `tc`.`id_combo`
LEFT JOIN 
    (
        SELECT 
            `pct`.`id_combo` AS `id_combo`,
            GROUP_CONCAT(`t`.`acronimo` SEPARATOR ' - ') AS `acronimo`
        FROM 
            `medplus`.`percorsi_combo_trattamenti` AS `pct`
        LEFT JOIN 
            `medplus`.`trattamenti` AS `t` 
            ON `pct`.`id_trattamento` = `t`.`id`
        GROUP BY 
            `pct`.`id_combo`
    ) AS `ta` 
    ON `pts`.`id_combo` = `ta`.`id_combo`;
