DROP VIEW IF EXISTS view_corsi_pagamenti;
CREATE VIEW view_corsi_pagamenti AS 
SELECT 
    cp.id AS id,
    ccl.id AS id_classe,
    ccl.id_cliente AS id_cliente,
    ccl.id_corso AS id_corso,
    ccl.data_inizio AS data_inizio,
    c.prezzo AS prezzo_tabellare,
    COALESCE(ccl.prezzo, cp.prezzo ) AS prezzo,
    c.scadenza AS corso_scadenza,
    c.id_terapista AS id_terapista,
    c.corso AS corso,
    ccl.realizzato_da AS realizzato_da,
    c.deleted AS deleted,
    (t.terapista COLLATE utf8mb4_unicode_ci) AS terapista,
    (cc.nominativo COLLATE utf8mb4_unicode_ci) AS nominativo,
    (ccc.categoria COLLATE utf8mb4_unicode_ci) AS categoria,
    COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)) AS anno,
    MIN(IF((MONTH(cp.scadenza) = 1), 1, IF((cs.mese = 1), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-01-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `1`,
    MIN(IF((MONTH(cp.scadenza) = 2), 1, IF((cs.mese = 2), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-02-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `2`,
    MIN(IF((MONTH(cp.scadenza) = 3), 1, IF((cs.mese = 3), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-03-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `3`,
    MIN(IF((MONTH(cp.scadenza) = 4), 1, IF((cs.mese = 4), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-04-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `4`,
    MIN(IF((MONTH(cp.scadenza) = 5), 1, IF((cs.mese = 5), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-05-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `5`,
    MIN(IF((MONTH(cp.scadenza) = 6), 1, IF((cs.mese = 6), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-06-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `6`,
    MIN(IF((MONTH(cp.scadenza) = 7), 1, IF((cs.mese = 7), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-07-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `7`,
    MIN(IF((MONTH(cp.scadenza) = 8), 1, IF((cs.mese = 8), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-08-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `8`,
    MIN(IF((MONTH(cp.scadenza) = 9), 1, IF((cs.mese = 9), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-09-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `9`,
    MIN(IF((MONTH(cp.scadenza) = 10), 1, IF((cs.mese = 10), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-10-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `10`,
    MIN(IF((MONTH(cp.scadenza) = 11), 1, IF((cs.mese = 11), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-11-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `11`,
    MIN(IF((MONTH(cp.scadenza) = 12), 1, IF((cs.mese = 12), 2, IF((STR_TO_DATE(CONCAT(COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio)), '-12-', LPAD(c.scadenza, 2, '0')), '%Y-%m-%d') BETWEEN ccl.data_inizio AND LAST_DAY(NOW())), 4, 3)))) AS `12`
FROM 
    medplus.corsi_classi ccl
    LEFT JOIN medplus.corsi_pagamenti cp ON ccl.id_corso = cp.id_corso AND ccl.id_cliente = cp.id_cliente
    LEFT JOIN medplus.corsi c ON ccl.id_corso = c.id
    LEFT JOIN medplus.clienti cc ON ccl.id_cliente = cc.id
    LEFT JOIN medplus.terapisti t ON c.id_terapista = t.id
    LEFT JOIN medplus.corsi_categorie ccc ON c.id_categoria = ccc.id
    LEFT JOIN medplus.corsi_sospensioni cs ON ccl.id_cliente = cs.id_cliente AND ccl.id_corso = cs.id_corso
GROUP BY 
    ccl.id_cliente,
    ccl.id_corso,
    COALESCE(YEAR(cp.scadenza), YEAR(ccl.data_inizio))
ORDER BY 
    ccl.id_corso DESC;
