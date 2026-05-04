USE medplus;
DROP VIEW IF EXISTS view_corsi_sedute;
CREATE VIEW view_corsi_sedute AS
SELECT
	cp.id,
    cp.id_pagamenti,
    cp.scadenza,
    cp.prezzo,
    cp.stato_pagamento,
    cp.tipo_pagamento,

    if(cp.stato_pagamento = 'Saldato', cp.prezzo, 0) as saldato,

    cli.id as id_cliente,
    cli.nominativo,

    c.corso,

    t.id as id_terapista,
    t.terapista,

    p.data_creazione COLLATE utf8mb4_general_ci as data_creazione,
    p.data_pagamento COLLATE utf8mb4_general_ci as data_pagamento,
    COALESCE(p.voucher, 'Da definire') COLLATE utf8mb4_general_ci AS voucher,
    p.metodo COLLATE utf8mb4_general_ci AS `metodo`,

    cc.realizzato_da COLLATE utf8mb4_general_ci AS realizzato_da,

    (
        CASE
            WHEN cc.realizzato_da = 'Medplus' THEN tptm.percentuale
            WHEN cc.realizzato_da = 'Isico Salerno' THEN tptis.percentuale
            WHEN cc.realizzato_da = 'Isico Napoli' THEN tptin.percentuale
            WHEN cc.realizzato_da = 'Daniela Zanotti' THEN tptdz.percentuale
        END
    ) COLLATE utf8mb4_general_ci AS percentuale_terapista,

    FORMAT(
		IF( t.profilo = 'Titolare', 
			CASE
				WHEN cc.realizzato_da = 'Medplus' THEN
					cp.prezzo * ( COALESCE(tptm.percentuale,0) / 100 )
				
				WHEN cc.realizzato_da = 'Daniela Zanotti' THEN
					cp.prezzo * ( COALESCE(tptdz.percentuale,0) / 100 )

				WHEN cc.realizzato_da = 'Isico Salerno' THEN
					cp.prezzo * ( COALESCE(tptis.percentuale,0) / 100 )

				WHEN cc.realizzato_da = 'Isico Napoli' THEN
					cp.prezzo * ( COALESCE(tptin.percentuale,0) / 100 )

				ELSE 0
			END,
			CASE
				WHEN cc.realizzato_da = 'Medplus' THEN
					cp.prezzo * ( COALESCE(tptm.percentuale,0) / 100 )
				
				WHEN cc.realizzato_da = 'Daniela Zanotti' THEN
					cp.prezzo * ( COALESCE(tptdz.percentuale,0) / 100 )

				WHEN cc.realizzato_da = 'Isico Salerno' THEN
					( ( cp.prezzo - (cp.prezzo * 0.4) ) * ( COALESCE(tptis.percentuale,0) / 100 ) )

				WHEN cc.realizzato_da = 'Isico Napoli' THEN
					( ( cp.prezzo - (cp.prezzo * 0.4) ) * ( COALESCE(tptis.percentuale,0) / 100 ) )

				ELSE 0
			END
		),
        2,
        'it_IT'
    ) AS saldo_terapista,

    t.profilo COLLATE utf8mb4_general_ci AS `profilo`,

    FORMAT(
        CASE
            WHEN cc.realizzato_da = 'Isico Salerno' THEN
                cp.prezzo * 0.3
            WHEN cc.realizzato_da = 'Isico Napoli' THEN
                cp.prezzo * 0.4
            ELSE
                0
        END
        ,
        2,
        'it_IT'
    ) COLLATE utf8mb4_general_ci AS percentuale_isico

FROM `corsi_pagamenti` cp

LEFT JOIN clienti cli 
    ON cp.id_cliente = cli.id

LEFT JOIN corsi c 
    ON cp.id_corso = c.id

LEFT JOIN corsi_classi cc 
    ON cp.id_corso = cc.id_corso

LEFT JOIN terapisti t 
    ON c.id_terapista = t.id

LEFT JOIN pagamenti p 
    ON cp.id_pagamenti = p.id

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

GROUP BY
    cp.id