USE medplus;

DROP VIEW IF EXISTS view_corsi_pagamenti_export;

CREATE VIEW view_corsi_pagamenti_export AS
SELECT
    c.id,
    c.id_categoria,
    c.id_terapista,
    c.corso,

    SUM(cp.prezzo_tabellare) AS prezzo_tabellare,
    SUM(cp.prezzo) AS prezzo,
    DATE_FORMAT(cp.scadenza, '%d/%m/%Y') AS scadenza,
    DATE_FORMAT(cp.scadenza, '%Y-%m') AS `month`,

    cli.nominativo AS nominativo,

    ccc.categoria,

    t.terapista,

    cc.realizzato_da,

    GROUP_CONCAT(
        DISTINCT
        CASE
            WHEN cc.realizzato_da = 'Medplus' THEN tptm.percentuale
            WHEN cc.realizzato_da = 'Isico Salerno' THEN tptis.percentuale
            WHEN cc.realizzato_da = 'Isico Napoli' THEN tptin.percentuale
            WHEN cc.realizzato_da = 'Daniela Zanotti' THEN tptdz.percentuale
            ELSE 0
        END
        SEPARATOR ', '
    ) AS percentuale_corsi,

    FORMAT(
        SUM(
            CASE
                WHEN t.profilo = 'Titolare' THEN
                    CASE
                        WHEN cc.realizzato_da = 'Medplus' THEN cp.prezzo * (COALESCE(tptm.percentuale, 0) / 100)
                        WHEN cc.realizzato_da = 'Daniela Zanotti' THEN cp.prezzo * (COALESCE(tptdz.percentuale, 0) / 100)
                        WHEN cc.realizzato_da = 'Isico Salerno' THEN cp.prezzo * (COALESCE(tptis.percentuale, 0) / 100)
                        WHEN cc.realizzato_da = 'Isico Napoli' THEN cp.prezzo * (COALESCE(tptin.percentuale, 0) / 100)
                        ELSE 0
                    END
                ELSE
                    CASE
                        WHEN cc.realizzato_da = 'Medplus' THEN cp.prezzo * (COALESCE(tptm.percentuale, 0) / 100)
                        WHEN cc.realizzato_da = 'Daniela Zanotti' THEN cp.prezzo * (COALESCE(tptdz.percentuale, 0) / 100)
                        WHEN cc.realizzato_da = 'Isico Salerno' THEN (cp.prezzo - (cp.prezzo * 0.4)) * (COALESCE(tptis.percentuale, 0) / 100)
                        WHEN cc.realizzato_da = 'Isico Napoli' THEN (cp.prezzo - (cp.prezzo * 0.4)) * (COALESCE(tptin.percentuale, 0) / 100)
                        ELSE 0
                    END
            END
        ),
        2,
        'it_IT'
    ) AS saldo_terapista,

    FORMAT(
        SUM(
            CASE
                WHEN cc.realizzato_da = 'Isico Salerno' THEN cp.prezzo * 0.3
                WHEN cc.realizzato_da = 'Isico Napoli' THEN cp.prezzo * 0.4
                ELSE 0
            END
        ),
        2,
        'it_IT'
    ) AS saldo_isico

FROM corsi_pagamenti cp

LEFT JOIN corsi c
    ON c.id = cp.id_corso

LEFT JOIN corsi_classi cc 
    ON cp.id_corso = cc.id_corso
    AND cp.id_cliente = cc.id_cliente
    AND YEAR(cp.scadenza) = YEAR(cc.data_inizio)

LEFT JOIN clienti cli
    ON cp.id_cliente = cli.id

LEFT JOIN corsi_categorie ccc
    ON c.id_categoria = ccc.id

LEFT JOIN terapisti t
    ON c.id_terapista = t.id

LEFT JOIN terapisti_percentuali tptm 
    ON t.id = tptm.id_terapista 
    AND tptm.tipo_percorso = 'Corsi'
    AND tptm.tipo_percentuale = 'Medplus'

LEFT JOIN terapisti_percentuali tptis 
    ON t.id = tptis.id_terapista 
    AND tptis.tipo_percorso = 'Corsi'
    AND tptis.tipo_percentuale = 'Isico Salerno'

LEFT JOIN terapisti_percentuali tptin 
    ON t.id = tptin.id_terapista 
    AND tptin.tipo_percorso = 'Corsi'
    AND tptin.tipo_percentuale = 'Isico Napoli'

LEFT JOIN terapisti_percentuali tptdz 
    ON t.id = tptdz.id_terapista 
    AND tptdz.tipo_percorso = 'Corsi'
    AND tptdz.tipo_percentuale = 'Daniela Zanotti'

WHERE c.deleted = 0

GROUP BY
    c.id,
    c.id_categoria,
    c.id_terapista,
    c.corso,
    ccc.categoria,
    cli.id,
    cc.realizzato_da,
    DATE_FORMAT(cp.scadenza, '%d/%m/%Y'),
    t.terapista;