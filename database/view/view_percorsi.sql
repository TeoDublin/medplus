DROP VIEW IF EXISTS view_percorsi;
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
    pt.realizzato_da AS realizzato_da,
    pt.bnw AS bnw,
    t.trattamenti AS trattamento,
    ta.acronimo AS acronimo,
    (IF((pt.sedute <= IFNULL(p.sp_count, 0)), 'Concluso', 'Attivo') COLLATE utf8mb4_general_ci) AS stato
FROM 
    medplus.percorsi_terapeutici pt
LEFT JOIN 
    medplus.percorsi_combo pc ON pt.id_combo = pc.id
LEFT JOIN 
    (
        SELECT 
            pct.id_combo AS id_combo,
            GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
        FROM 
            medplus.percorsi_combo_trattamenti pct
        LEFT JOIN 
            medplus.trattamenti t ON pct.id_trattamento = t.id
        GROUP BY 
            pct.id_combo
    ) t ON pc.id = t.id_combo
LEFT JOIN 
    (
        SELECT 
            pct.id_combo AS id_combo,
            GROUP_CONCAT(t.acronimo SEPARATOR ' - ') AS acronimo
        FROM 
            medplus.percorsi_combo_trattamenti pct
        LEFT JOIN 
            medplus.trattamenti t ON pct.id_trattamento = t.id
        GROUP BY 
            pct.id_combo
    ) ta ON pc.id = ta.id_combo
LEFT JOIN 
    (
        SELECT 
            pts.id_percorso AS id_percorso,
            COUNT(pts.id) AS sp_count
        FROM 
            medplus.percorsi_terapeutici_sedute_prenotate pts
        JOIN 
            medplus.percorsi_terapeutici_sedute p ON pts.id_seduta = p.id
        WHERE 
            pts.stato_prenotazione = 'Conclusa'
            AND p.stato_pagamento = 'Saldato'
        GROUP BY 
            pts.id_percorso
    ) p ON pt.id = p.id_percorso
ORDER BY 
    pt.timestamp DESC;
