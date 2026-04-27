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
        
    cc.realizzato_da,

    t.id as id_terapista,
    t.terapista,

    p.data_creazione COLLATE utf8mb4_general_ci as data_creazione,
    p.data_pagamento COLLATE utf8mb4_general_ci as data_pagamento,
	p.voucher COLLATE utf8mb4_general_ci as voucher,
    p.metodo COLLATE utf8mb4_general_ci AS `metodo`

FROM `corsi_pagamenti` cp
LEFT JOIN clienti cli ON cp.id_cliente = cli.id
LEFT JOIN corsi c ON cp.id_corso = c.id
LEFT JOIN corsi_classi cc ON cp.id_corso = cc.id_corso
LEFT JOIN terapisti t ON c.id_terapista = t.id
LEFT JOIN pagamenti p ON cp.id_pagamenti = p.id
GROUP BY
    cp.id