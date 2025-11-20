DROP VIEW IF EXISTS view_corsi_sedute;
CREATE VIEW view_corsi_sedute AS
SELECT
	cp.id,
    cli.id as id_cliente,
    cli.nominativo,
    c.corso,
    cp.scadenza,
    cp.data_pagamento,
    cp.prezzo,
    if(cp.stato_pagamento = 'Saldato', cp.prezzo, 0) as saldato,
    cp.stato_pagamento,
    cp.tipo_pagamento,
    cc.realizzato_da,
    t.id as id_terapista,
	t.terapista,
    cc.bnw
FROM `corsi_pagamenti` cp
LEFT JOIN clienti cli ON cp.id_cliente = cli.id
LEFT JOIN corsi c ON cp.id_corso = c.id
LEFT JOIN corsi_classi cc ON cp.id_corso = cc.id_corso
LEFT JOIN terapisti t ON c.id_terapista = t.id
GROUP BY
    cp.id