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

    pt.realizzato_da AS realizzato_da,

    COALESCE(
        pts.percentuale_terapista,
        CASE
            WHEN pt.realizzato_da = 'Medplus' THEN tptm.percentuale
            WHEN pt.realizzato_da = 'Isico Salerno' THEN tptis.percentuale
            WHEN pt.realizzato_da = 'Isico Napoli' THEN tptin.percentuale
            WHEN pt.realizzato_da = 'Daniela Zanotti' THEN tptdz.percentuale
        END
    ) AS percentuale_terapista,

    FORMAT(
        COALESCE(
            pts.saldo_terapista,
            CASE
                WHEN pt.realizzato_da = 'Medplus' THEN
                    CASE
                        WHEN t.profilo = 'Terapista' THEN
                            ((pts.prezzo - (pts.prezzo * 0.6)) * (COALESCE(tptm.percentuale,0) / 100))
                        ELSE
                            (pts.prezzo * (COALESCE(tptm.percentuale,0) / 100))
                    END

                WHEN pt.realizzato_da = 'Isico Salerno' THEN
                    CASE
                        WHEN t.profilo = 'Terapista' THEN
                            ((pts.prezzo - (pts.prezzo * 0.6)) * (COALESCE(tptis.percentuale,0) / 100))
                        ELSE
                            (pts.prezzo * (COALESCE(tptis.percentuale,0) / 100))
                    END

                WHEN pt.realizzato_da = 'Isico Napoli' THEN
                    CASE
                        WHEN t.profilo = 'Terapista' THEN
                            ((pts.prezzo - (pts.prezzo * 0.6)) * (COALESCE(tptin.percentuale,0) / 100))
                        ELSE
                            (pts.prezzo * (COALESCE(tptin.percentuale,0) / 100))
                    END

                WHEN pt.realizzato_da = 'Daniela Zanotti' THEN
                    CASE
                        WHEN t.profilo = 'Terapista' THEN
                            ((pts.prezzo - (pts.prezzo * 0.6)) * (COALESCE(tptdz.percentuale,0) / 100))
                        ELSE
                            (pts.prezzo * (COALESCE(tptdz.percentuale,0) / 100))
                    END

                ELSE 0
            END
        ),
        2,
        'it_IT'
    ) AS saldo_terapista,

    IF( pts.percentuale_terapista IS NOT NULL, 
        'Impostato', 
        'Calcolato'
    ) COLLATE utf8mb4_general_ci AS `origine_percentuale_terapista`,

    IF( pts.saldato_terapista IS NOT NULL, 
        'Impostato', 
        'Calcolato'
    ) COLLATE utf8mb4_general_ci AS `origine_saldo_terapista`

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

LEFT JOIN terapisti_percentuali tptm 
    ON t.id = tptm.id_terapista 
    AND tptm.tipo_percorso = 'Trattamenti'
    AND tptm.tipo_percentuale = 'Medplus' 

LEFT JOIN terapisti_percentuali tptis 
    ON t.id = tptis.id_terapista 
    AND tptis.tipo_percorso = 'Trattamenti'
    AND tptis.tipo_percentuale = 'Isico Salerno' 

LEFT JOIN terapisti_percentuali tptin 
    ON t.id = tptin.id_terapista 
    AND tptin.tipo_percorso = 'Trattamenti'
    AND tptin.tipo_percentuale = 'Isico Napoli'

LEFT JOIN terapisti_percentuali tptdz 
    ON t.id = tptdz.id_terapista 
    AND tptdz.tipo_percorso = 'Trattamenti'
    AND tptdz.tipo_percentuale = 'Daniela Zanotti' 

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