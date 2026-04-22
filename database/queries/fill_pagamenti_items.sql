

USE medplus;
DELETE FROM pagamenti_child;
INSERT INTO pagamenti_child
SELECT 
    NULL as id,
    f.id_pagamenti,
    pf.id_cliente,
    pf.id_origine,
    pf.id_origine_child,
    pf.id_fattura as id_fattura,
    'Fattura D.Z.' as tipo_pagamento,
    CONCAT(
        UPPER(LEFT(pf.origine, 1)),
        LOWER(SUBSTRING(pf.origine, 2))
    ) as origine,
    pf.importo as valore,
    f.`data`,
    f.metodo,
    f.stato,
    NULL as note,
    NULL as fattura_aruba,
    f.`timestamp`
FROM 
    medplus_20260418.pagamenti_fatture pf
LEFT JOIN fatture f on pf.id_fattura = f.id;


INSERT INTO pagamenti_child
SELECT 
    NULL as id,
    id_pagamenti,
    id_cliente,
    id_origine,
    id_origine_child,
    NULL as id_fattura,
    'Aruba' as tipo_pagamento,
    CONCAT(
        UPPER(LEFT(origine, 1)),
        LOWER(SUBSTRING(origine, 2))
    ) as origine,
    valore,
    `data`,
    metodo,
    'Saldato' AS stato,
    note,
    NULL as fattura_aruba,
    `timestamp`
FROM 
    medplus_20260418.pagamenti_aruba;


INSERT INTO pagamenti_child
SELECT 
    NULL as id,
    id_pagamenti,
    id_cliente,
    id_origine,
    id_origine_child,
    NULL as id_fattura,
    'Isico' as tipo_pagamento,
    CONCAT(
        UPPER(LEFT(origine, 1)),
        LOWER(SUBSTRING(origine, 2))
    ) as origine,
    valore,
    `data`,
    metodo,
    'Saldato' AS stato,
    note,
    NULL as fattura_aruba,
    `timestamp`
FROM 
    medplus_20260418.pagamenti_isico;

INSERT INTO pagamenti_child
SELECT 
    NULL as id,
    id_pagamenti,
    id_cliente,
    id_origine,
    id_origine_child,
    NULL as id_fattura,
    'Contanti' as tipo_pagamento,
    CONCAT(
        UPPER(LEFT(origine, 1)),
        LOWER(SUBSTRING(origine, 2))
    ) as origine,
    valore,
    `data`,
    metodo,
    'Saldato' AS stato,
    note,
    NULL as fattura_aruba,
    `timestamp`
FROM 
    medplus_20260418.pagamenti_senza_fattura;