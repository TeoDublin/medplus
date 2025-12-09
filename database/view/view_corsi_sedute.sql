DROP VIEW IF EXISTS view_corsi_sedute;
CREATE VIEW view_corsi_sedute AS
SELECT
	cp.id,
    cli.id as id_cliente,
    cp.id_pagamenti,
    cli.nominativo,
    c.corso,
    cp.scadenza,
    p.data as data_pagamento,
    cp.prezzo,
    if(cp.stato_pagamento = 'Saldato', cp.prezzo, 0) as saldato,
    cp.stato_pagamento,
    cp.tipo_pagamento,
    cc.realizzato_da,
    t.id as id_terapista,
	t.terapista,
    (
        IF(`p`.`origine` IS NULL, 
            'da definire',
            if( `p`.`origine` = 'senza_fattura' and `p`.`metodo` = 'Contanti', 'no', 'si') 
        ) COLLATE utf8mb4_general_ci
    ) AS `bnw`,
    (`p`.`metodo` COLLATE utf8mb4_general_ci) AS `metodo`
FROM `corsi_pagamenti` cp
LEFT JOIN clienti cli ON cp.id_cliente = cli.id
LEFT JOIN corsi c ON cp.id_corso = c.id
LEFT JOIN corsi_classi cc ON cp.id_corso = cc.id_corso
LEFT JOIN terapisti t ON c.id_terapista = t.id
LEFT JOIN pagamenti p ON cp.id_pagamenti = p.id
GROUP BY
    cp.id