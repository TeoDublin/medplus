DROP VIEW IF EXISTS view_fatture;
CREATE VIEW view_fatture AS
SELECT
    fatture.id AS id,
    fatture.id_cliente AS id_cliente,
    fatture.link COLLATE utf8mb4_general_ci AS link,
    (fatture.importo + fatture.bollo + fatture.inps) AS totale,
    fatture.bollo AS bollo,
    fatture.inps AS inps,
    fatture.importo AS importo,
    fatture.`index` AS `index`,
    fatture.data AS data,
    fatture.stato COLLATE utf8mb4_general_ci AS stato,
    fatture.metodo COLLATE utf8mb4_general_ci AS metodo,
    fatture.request AS request,
    fatture.fatturato_da COLLATE utf8mb4_general_ci AS fatturato_da,
    fatture.timestamp AS timestamp,
    fatture.confermato_dal_commercialista AS confermato_dal_commercialista,
    clienti.nominativo COLLATE utf8mb4_general_ci AS nominativo
FROM medplus.fatture
LEFT JOIN medplus.clienti
    ON fatture.id_cliente = clienti.id
ORDER BY fatture.`index`;
