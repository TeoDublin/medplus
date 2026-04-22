USE medplus;
DROP VIEW IF EXISTS view_sedute;
CREATE VIEW view_sedute AS
SELECT 
    pts.id AS id,
    pts.`index` AS `index`,
    pts.id_cliente AS id_cliente,
    pts.id_percorso AS id_percorso,
    pts.id_combo AS id_combo,
    pts.id_pagamenti AS id_pagamenti,
    pts.prezzo AS prezzo,
    pts.saldato AS saldato,
    pts.id_terapista AS id_terapista,
    pts.percentuale_terapista AS percentuale_terapista,
    pts.saldo_terapista AS saldo_terapista,
    pts.saldato_terapista AS saldato_terapista,
    pts.stato_seduta COLLATE utf8mb4_general_ci AS stato_seduta,
    pts.stato_pagamento COLLATE utf8mb4_general_ci AS stato_pagamento,
    pts.data_seduta COLLATE utf8mb4_general_ci AS data_seduta,
    pts.`timestamp` COLLATE utf8mb4_general_ci AS `timestamp`,
    pts.tipo_pagamento AS tipo_pagamento,
    
    p.data_creazione COLLATE utf8mb4_general_ci AS data_creazione,
    p.data_pagamento COLLATE utf8mb4_general_ci AS data_pagamento,
    p.voucher COLLATE utf8mb4_general_ci AS voucher,
    p.metodo COLLATE utf8mb4_general_ci AS metodo,

    c.nominativo COLLATE utf8mb4_general_ci AS nominativo,

    tpd.terapista COLLATE utf8mb4_general_ci AS portato_da,

    t.terapista COLLATE utf8mb4_general_ci AS terapista,

    tc.trattamenti COLLATE utf8mb4_general_ci AS trattamenti,
    tc.acronimo COLLATE utf8mb4_general_ci AS acronimo,

    pt.realizzato_da AS realizzato_da

FROM percorsi_terapeutici_sedute pts

LEFT JOIN percorsi_terapeutici pt 
    ON pts.id_percorso = pt.id

LEFT JOIN terapisti t 
    ON pts.id_terapista = t.id

LEFT JOIN clienti c 
    ON pts.id_cliente = c.id

LEFT JOIN terapisti tpd 
    ON c.portato_da = tpd.id

LEFT JOIN pagamenti p 
    ON pts.id_pagamenti = p.id

LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.trattamento SEPARATOR ';') COLLATE utf8mb4_general_ci AS trattamenti,
        GROUP_CONCAT(t.acronimo SEPARATOR ' - ') COLLATE utf8mb4_general_ci AS acronimo
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t 
        ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) tc 
    ON pts.id_combo = tc.id_combo