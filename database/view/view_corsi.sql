DROP VIEW IF EXISTS view_corsi;
CREATE VIEW view_corsi AS 
SELECT 
    c.id AS id,
    c.id_categoria AS id_categoria,
    c.id_terapista AS id_terapista,
    (cct.categoria COLLATE utf8mb4_general_ci) AS categoria,
    (c.corso COLLATE utf8mb4_general_ci) AS corso,
    (c.prezzo COLLATE utf8mb4_general_ci) AS prezzo_tabellare,
    (c.scadenza COLLATE utf8mb4_general_ci) AS scadenza,
    (t.terapista COLLATE utf8mb4_general_ci) AS terapista,
    (cg.giorni COLLATE utf8mb4_general_ci) AS giorni,
    c.timestamp as timestamp
FROM 
    medplus.corsi c
    LEFT JOIN medplus.terapisti t ON c.id_terapista = t.id
    LEFT JOIN medplus.corsi_categorie cct ON c.id_categoria = cct.id
    LEFT JOIN (
        SELECT 
            cg.id_corso AS id_corso,
            GROUP_CONCAT(
                cg.giorno, ' ', 
                TIME_FORMAT(pr.ora, '%H:%i'), '-', 
                TIME_FORMAT(prf.ora, '%H:%i') 
                SEPARATOR ','
            ) AS giorni
        FROM 
            medplus.corsi_giorni cg
            LEFT JOIN medplus.planning_row pr ON pr.id = cg.inizio
            LEFT JOIN medplus.planning_row prf ON prf.id = cg.fine
        GROUP BY 
            cg.id_corso
    ) cg ON cg.id_corso = c.id
WHERE 
    c.deleted = 0
ORDER BY 
    c.id DESC;
