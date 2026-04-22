USE medplus;
DROP VIEW IF EXISTS view_corsi_sedute;
CREATE VIEW view_corsi_sedute AS
SELECT
	cp.id,
    cli.id as id_cliente,
    cp.id_pagamenti,
    cli.nominativo,
    c.corso,
    cp.scadenza,
    p.data_creazione COLLATE utf8mb4_general_ci as data_creazione,
    p.data_pagamento COLLATE utf8mb4_general_ci as data_pagamento,
    cp.prezzo,
    if(cp.stato_pagamento = 'Saldato', cp.prezzo, 0) as saldato,
    cp.stato_pagamento,
    cp.tipo_pagamento,
    cc.realizzato_da,
    t.id as id_terapista,
	p.voucher COLLATE utf8mb4_general_ci as voucher,
    p.metodo COLLATE utf8mb4_general_ci AS `metodo`,
	t.percentuale_corsi as `percentuale_terapista`,
	CAST(
        ROUND(
            IF(
                cc.realizzato_da = 'Medplus', 
                (IF(cp.stato_pagamento = 'Saldato', cp.prezzo, 0)) * (t.percentuale_corsi / 100), 
                ((IF(cp.stato_pagamento = 'Saldato', cp.prezzo, 0)) * 0.6) * (t.percentuale_corsi / 100)
            ),
            2
        ) AS DECIMAL(10,2)
    ) AS saldo_terapista

FROM `corsi_pagamenti` cp
LEFT JOIN clienti cli ON cp.id_cliente = cli.id
LEFT JOIN corsi c ON cp.id_corso = c.id
LEFT JOIN corsi_classi cc ON cp.id_corso = cc.id_corso
LEFT JOIN terapisti t ON c.id_terapista = t.id
LEFT JOIN pagamenti p ON cp.id_pagamenti = p.id
GROUP BY
    cp.id