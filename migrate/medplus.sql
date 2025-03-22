ALTER TABLE `percorsi_terapeutici_sedute` ADD `prezzo` DOUBLE(10,2) NOT NULL AFTER `id_combo`, ADD `saldato` DOUBLE(10,2) NOT NULL AFTER `prezzo`  DEFAULT '0', ADD `stato_pagamento` ENUM('Pendente','Parziale','Saldato','Fatturato') NOT NULL AFTER `saldato` DEFAULT 'Pendente';

DROP VIEW view_sedute;
CREATE VIEW view_sedute AS
SELECT 
    pts.id AS id,
    pts.index AS `index`,
    pts.id_cliente AS id_cliente,
    pts.id_percorso AS id_percorso,
    pts.id_combo AS id_combo,
    COALESCE(
        MAX(ptsp_Conclusa.data),
        COALESCE(MAX(ptsp_Prenotata.data), MAX(ptsp_Assente.data))
    ) COLLATE utf8mb4_general_ci AS data,
    CASE
        WHEN MAX(ptsp_Conclusa.id) IS NOT NULL THEN 'Conclusa'
        WHEN MAX(ptsp_Prenotata.id) IS NOT NULL THEN 'Prenotata'
        WHEN MAX(ptsp_Assente.id) IS NOT NULL THEN 'Assente'
        ELSE 'Da Prenotare'
    END COLLATE utf8mb4_general_ci AS stato_prenotazione,
    pts.stato_pagamento COLLATE utf8mb4_general_ci as stato_pagamento,
    IF(MAX(ptsp_Conclusa.id) IS NOT NULL,
       	if(pts.stato_pagamento='Saldato', 
       		'Completato',
           if(pts.stato_pagamento='Pendente','Debitore','Parziale')
        ),
       'In corso'
    ) COLLATE utf8mb4_general_ci as stato_seduta
FROM 
    percorsi_terapeutici_sedute pts
LEFT JOIN 
    percorsi_terapeutici_sedute_prenotate ptsp_Assente 
    ON pts.id = ptsp_Assente.id_seduta AND ptsp_Assente.stato_prenotazione = 'Assente'
LEFT JOIN 
    percorsi_terapeutici_sedute_prenotate ptsp_Conclusa 
    ON pts.id = ptsp_Conclusa.id_seduta AND ptsp_Conclusa.stato_prenotazione = 'Conclusa'
LEFT JOIN 
    percorsi_terapeutici_sedute_prenotate ptsp_Prenotata 
    ON pts.id = ptsp_Prenotata.id_seduta AND ptsp_Prenotata.stato_prenotazione = 'Prenotata'
GROUP BY 
    pts.id,
    pts.index,
    pts.id_cliente,
    pts.id_percorso,
    pts.id_combo;



DROP VIEW `view_percorsi`;
CREATE VIEW view_percorsi as
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
    (IF(pt.sedute <= IFNULL(p.sp_count, 0), 'Concluso', 'Attivo') COLLATE utf8mb4_general_ci) AS stato
FROM percorsi_terapeutici pt
LEFT JOIN percorsi_combo pc 
    ON pt.id_combo = pc.id
LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t 
        ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) t 
    ON pc.id = t.id_combo
LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.acronimo SEPARATOR ' - ') AS acronimo
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t 
        ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) ta 
    ON pc.id = ta.id_combo
LEFT JOIN (
    SELECT 
        pts.id_percorso,
        COUNT(pts.id) AS sp_count
    FROM percorsi_terapeutici_sedute_prenotate pts
    INNER JOIN percorsi_terapeutici_sedute p ON pts.id_seduta = p.id
    WHERE pts.stato_prenotazione = 'Conclusa' AND p.stato_pagamento = 'Saldato'
    GROUP BY pts.id_percorso
) p 
    ON pt.id = p.id_percorso
ORDER BY pt.timestamp DESC