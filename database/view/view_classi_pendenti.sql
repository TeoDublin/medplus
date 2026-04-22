USE medplus;
DROP VIEW IF EXISTS view_classi_pendenti;
CREATE VIEW view_classi_pendenti AS 
SELECT 
    cc.id AS id,
    cc.id_corso AS id_corso,
    cc.id_cliente AS id_cliente,
    cc.prezzo AS prezzo,
    cc.data_inizio AS data_inizio,
    cc.realizzato_da as realizzato_da,

    c.scadenza AS scadenza,
    c.id_categoria AS id_categoria,
    c.id_terapista AS id_terapista,
    c.deleted AS deleted,
    c.corso AS corso,
    c.prezzo AS prezzo_tabellare,
    
    t.terapista AS terapista,

    ct.nominativo AS nominativo,

    cg.giorni AS giorni,
    
    cct.categoria AS categoria,

    cp.scadenza as scadenza_mensile
FROM corsi_classi cc
LEFT JOIN corsi c ON cc.id_corso = c.id
LEFT JOIN clienti ct ON cc.id_cliente = ct.id
LEFT JOIN terapisti t ON c.id_terapista = t.id
LEFT JOIN corsi_categorie cct ON c.id_categoria = cct.id
LEFT JOIN (
    SELECT 
        cp.id_corso,
        cp.id_cliente,
        cp.scadenza,
        YEAR(cp.scadenza) anno
    FROM `corsi_pagamenti` cp 
    where 
        cp.stato_pagamento NOT IN( 'Saldato', 'Esente')
    group by 
        cp.id_corso,
        id_cliente
) cp 
    ON cc.id_corso = cp.id_corso AND cc.id_cliente = cp.id_cliente AND YEAR(cc.data_inizio) = anno
LEFT JOIN (
    SELECT 
        cg.id_corso AS id_corso,
        GROUP_CONCAT(
            cg.giorno, ' ', 
            TIME_FORMAT(pr.ora, '%H:%i'), '-', 
            TIME_FORMAT(prf.ora, '%H:%i') 
            SEPARATOR ','
        ) AS giorni
    FROM corsi_giorni cg
    LEFT JOIN planning_row pr ON pr.id = cg.inizio
    LEFT JOIN planning_row prf ON prf.id = cg.fine
    GROUP BY cg.id_corso
) cg ON cg.id_corso = c.id
WHERE 
    c.deleted = 0
    AND cp.id_corso IS NOT NULL
