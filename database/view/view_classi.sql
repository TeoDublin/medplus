DROP VIEW IF EXISTS view_classi;
CREATE VIEW view_classi AS 
SELECT 
    cc.id AS id,
    cc.id_corso AS id_corso,
    cc.id_cliente AS id_cliente,
    c.id_categoria AS id_categoria,
    c.id_terapista AS id_terapista,
    c.deleted AS deleted,
    cct.categoria AS categoria,
    c.corso AS corso,
    c.prezzo AS prezzo_tabellare,
    cc.prezzo AS prezzo,
    c.scadenza AS scadenza,
    cc.data_inizio AS data_inizio,
    t.terapista AS terapista,
    ct.nominativo AS nominativo,
    cg.giorni AS giorni,
    cc.bnw AS bnw,
    cc.realizzato_da as realizzato_da
FROM medplus.corsi_classi cc
LEFT JOIN medplus.corsi c ON cc.id_corso = c.id
LEFT JOIN medplus.clienti ct ON cc.id_cliente = ct.id
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
    FROM medplus.corsi_giorni cg
    LEFT JOIN medplus.planning_row pr ON pr.id = cg.inizio
    LEFT JOIN medplus.planning_row prf ON prf.id = cg.fine
    GROUP BY cg.id_corso
) cg ON cg.id_corso = c.id
WHERE c.deleted = 0;
