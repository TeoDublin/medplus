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
    (c.nominativo COLLATE utf8mb4_general_ci) as nominativo
FROM `pagamenti` p
LEFT JOIN clienti c ON p.id_cliente = c.id
ORDER BY p.data DESC