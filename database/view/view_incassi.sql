DROP VIEW IF EXISTS view_incassi;
CREATE VIEW view_incassi AS
SELECT 
	p.id,
    p.id_cliente,
    (p.origine COLLATE utf8mb4_general_ci) as origine,
    (p.metodo COLLATE utf8mb4_general_ci) as metodo,
    (p.data COLLATE utf8mb4_general_ci) as `data`,
    p.imponibile,
    p.inps,
    p.bollo,
    p.totale,
    (p.note COLLATE utf8mb4_general_ci) as note,
    (p.stato COLLATE utf8mb4_general_ci) as stato,
    (
        IF(`p`.`origine` IS NULL, 
            'da definire',
            if( `p`.`origine` = 'senza_fattura' and `p`.`metodo` = 'Contanti', 'no', 'si') 
        ) COLLATE utf8mb4_general_ci
    ) AS `bnw`,
    (c.nominativo COLLATE utf8mb4_general_ci) as nominativo,
    psf.realizzato_da,
    p.fattura_aruba
FROM `pagamenti` p
LEFT JOIN clienti c ON p.id_cliente = c.id
LEFT JOIN (
    	SELECT 
		psf.id_pagamenti, 
		COALESCE( pt.realizzato_da, cc.realizzato_da) AS realizzato_da
	FROM pagamenti_senza_fattura psf 
    LEFT JOIN percorsi_terapeutici pt on psf.id_origine = pt.id
    LEFT JOIN corsi_pagamenti cp on cp.id = psf.id_origine_child
	LEFT JOIN corsi_classi cc on cp.id_cliente = cc.id_cliente and cc.id_corso = cp.id_corso
	WHERE 
		COALESCE( pt.realizzato_da, cc.realizzato_da) IS NOT NULL
    GROUP BY 
		psf.id_pagamenti


	UNION ALL

	SELECT 
		psf.id_pagamenti, 
		COALESCE( pt.realizzato_da, cc.realizzato_da) AS realizzato_da
	FROM pagamenti_aruba psf 
    LEFT JOIN percorsi_terapeutici pt on psf.id_origine = pt.id
    LEFT JOIN corsi_pagamenti cp on cp.id = psf.id_origine_child
	LEFT JOIN corsi_classi cc on cp.id_cliente = cc.id_cliente and cc.id_corso = cp.id_corso
	WHERE 
		COALESCE( pt.realizzato_da, cc.realizzato_da) IS NOT NULL
    GROUP BY 
		psf.id_pagamenti

    UNION ALL

        SELECT 
            psf.id_pagamenti, 
            COALESCE( pt.realizzato_da, cc.realizzato_da) AS realizzato_da
        FROM pagamenti_isico psf 
        LEFT JOIN percorsi_terapeutici pt on psf.id_origine = pt.id
        LEFT JOIN corsi_pagamenti cp on cp.id = psf.id_origine_child
    	LEFT JOIN corsi_classi cc on cp.id_cliente = cc.id_cliente and cc.id_corso = cp.id_corso
        WHERE 
            COALESCE( pt.realizzato_da, cc.realizzato_da) IS NOT NULL
        GROUP BY 
            psf.id_pagamenti

    UNION ALL
        SELECT 
            psf.id_pagamenti, 
            COALESCE( pt.realizzato_da, cc.realizzato_da) AS realizzato_da
        FROM pagamenti_fatture pf
        LEFT JOIN fatture psf on pf.id_fattura = psf.id 
        LEFT JOIN percorsi_terapeutici pt on pf.id_origine = pt.id
        LEFT JOIN corsi_pagamenti cp on cp.id = pf.id_origine_child
        LEFT JOIN corsi_classi cc on cp.id_cliente = cc.id_cliente and cc.id_corso = cp.id_corso
        WHERE 
            COALESCE( pt.realizzato_da, cc.realizzato_da) IS NOT NULL
        GROUP BY 
            psf.id_pagamenti
    ) psf ON p.id = psf.id_pagamenti
GROUP BY p.id
ORDER BY p.data DESC