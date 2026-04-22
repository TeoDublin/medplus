USE medplus;
DROP VIEW IF EXISTS view_fatture;
CREATE VIEW view_fatture AS
SELECT
    f.id AS id,
    f.id_cliente AS id_cliente,
    f.link COLLATE utf8mb4_general_ci AS link,
    p.totale AS totale,
    p.bollo AS bollo,
    p.inps AS inps,
    p.imponibile AS importo,
    f.index AS `index`,
    p.data_creazione AS data_creazione,
    p.data_pagamento AS data_pagamento,
    p.stato COLLATE utf8mb4_general_ci AS stato,
    p.metodo COLLATE utf8mb4_general_ci AS metodo,
    f.timestamp AS timestamp,
    c.nominativo COLLATE utf8mb4_general_ci AS nominativo
FROM fatture f
LEFT JOIN 
    pagamenti p ON f.id = p.id_fattura
LEFT JOIN clienti c
    ON f.id_cliente = c.id
ORDER BY f.`index`;
