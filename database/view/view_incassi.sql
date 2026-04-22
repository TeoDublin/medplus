USE medplus;
DROP VIEW IF EXISTS view_incassi;
CREATE VIEW view_incassi AS
SELECT 
	p.id,
    p.id_cliente,
    (p.metodo COLLATE utf8mb4_general_ci) as metodo,
    (p.data_creazione COLLATE utf8mb4_general_ci) as data_creazione,
    (p.data_pagamento COLLATE utf8mb4_general_ci) as data_pagamento,
    p.imponibile,
    p.inps,
    p.bollo,
    p.totale,
    (p.note COLLATE utf8mb4_general_ci) as note,
    (p.stato COLLATE utf8mb4_general_ci) as stato,
    p.voucher COLLATE utf8mb4_general_ci as voucher,
    (c.nominativo COLLATE utf8mb4_general_ci) as nominativo,
    (p.tipo_pagamento COLLATE utf8mb4_general_ci) as tipo_pagamento,
    COALESCE(cp.realizzato_da, pt.realizzato_da) as realizzato_da,
    p.fattura_aruba
FROM `pagamenti` p
LEFT JOIN pagamenti_child pc ON p.id = pc.id_pagamenti
LEFT JOIN corsi_pagamenti cp ON cp.id_pagamenti = p.id
LEFT JOIN percorsi_terapeutici pt on pt.id = pc.id_origine
LEFT JOIN clienti c ON p.id_cliente = c.id
GROUP BY p.id
ORDER BY p.data_creazione DESC