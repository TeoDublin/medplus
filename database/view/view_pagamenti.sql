USE medplus;
DROP VIEW IF EXISTS view_pagamenti;
CREATE VIEW view_pagamenti AS
SELECT 
    pt.id,
    pt.id as id_origine,
    ('trattamenti' COLLATE utf8mb4_general_ci) AS origine,
    pt.realizzato_da AS realizzato_da,
    pt.id_cliente AS id_cliente,
    c.nominativo,
    t.trattamenti AS nome,
    t.acronimo AS acronimo,
    (DATE_FORMAT(pt.timestamp, '%Y-%m-%d') COLLATE utf8mb4_general_ci) AS scadenza,
    pt.prezzo_tabellare AS prezzo_tabellare,
    pac.tipo_pagamento,
    pac.id_fattura,
    pac.fattura_aruba,
    pac.origine as pac_origine,
    COALESCE(SUM(pts.prezzo),0) as prezzo,
    COALESCE(SUM(pac.saldato),0) AS saldato,
    COALESCE(SUM(pac.fatturato),0) AS fatturato,
    COALESCE(SUM(pts.prezzo),0) - COALESCE(SUM(pac.saldato),0) - COALESCE(SUM(pac.fatturato),0) AS non_fatturato
FROM 
    percorsi_terapeutici pt
LEFT JOIN 
    percorsi_terapeutici_sedute pts ON pts.id_percorso = pt.id
LEFT JOIN 
    percorsi_combo pc ON pt.id_combo = pc.id
LEFT JOIN 
    (
        SELECT 
            pct.id_combo AS id_combo,
            GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti,
            GROUP_CONCAT(t.acronimo SEPARATOR ' - ') AS acronimo
        FROM 
            percorsi_combo_trattamenti pct
        LEFT JOIN 
            trattamenti t ON pct.id_trattamento = t.id
        GROUP BY 
            pct.id_combo
    ) t ON pc.id = t.id_combo
LEFT JOIN 
    (
        SELECT 
            pac.id_origine AS id_origine,
            pac.id_origine_child AS id_origine_child,
            pac.tipo_pagamento,
            pac.id_fattura,
            pac.fattura_aruba,
            pac.origine,
            SUM(IF(pac.stato = 'Saldato',pac.valore,0)) AS saldato,
            SUM(IF(pac.stato <> 'Saldato', pac.valore , 0)) AS fatturato
        FROM 
            pagamenti_child pac 
        WHERE 
            pac.origine = 'Trattamenti'
        GROUP BY 
            pac.id_origine_child
    ) pac ON pts.id = pac.id_origine_child
LEFT JOIN clienti c on pt.id_cliente = c.id
GROUP BY
    pt.id


UNION ALL


SELECT 
    cp.id AS id,
    cp.id_corso as id_origine,
    ('corsi' COLLATE utf8mb4_general_ci) AS origine,
    cc.realizzato_da AS realizzato_da,
    cp.id_cliente AS id_cliente,
    c.nominativo,
    co.corso AS nome,
    co.corso AS acronimo,
    (cp.scadenza COLLATE utf8mb4_general_ci) AS scadenza,
    cp.prezzo_tabellare AS prezzo_tabellare,
    pac.tipo_pagamento,
    pac.id_fattura,
    pac.fattura_aruba,
    pac.origine as pac_origine,
    COALESCE(SUM(cp.prezzo),0) as prezzo,
    COALESCE(SUM(pac.saldato),0) AS saldato,
    COALESCE(SUM(pac.fatturato),0) AS fatturato,
    COALESCE(SUM(cp.prezzo),0) - COALESCE(SUM(pac.saldato),0) - COALESCE(SUM(pac.fatturato),0) AS non_fatturato
FROM 
    corsi_pagamenti cp
LEFT JOIN 
    corsi co ON co.id = cp.id_corso
LEFT JOIN 
    corsi_classi cc ON cp.id_corso = cc.id_corso AND cp.id_cliente = cc.id_cliente AND YEAR(cp.scadenza) = YEAR(cc.data_inizio)
LEFT JOIN 
    (
        SELECT 
            pac.id_origine AS id_origine,
            pac.id_origine_child AS id_origine_child,
            pac.tipo_pagamento,
            pac.id_fattura,
            pac.fattura_aruba,
            pac.origine,
            SUM(IF(pac.stato = 'Saldato',pac.valore,0)) AS saldato,
            SUM(IF(pac.stato <> 'Saldato', pac.valore , 0)) AS fatturato
        FROM 
            pagamenti_child pac 
        WHERE 
            pac.origine = 'Corsi'
        GROUP BY 
            pac.id_origine_child
    ) pac ON cp.id = pac.id_origine_child
LEFT JOIN clienti c on cp.id_cliente = c.id
GROUP BY
    cp.id