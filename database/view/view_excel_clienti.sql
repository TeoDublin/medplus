DROP VIEW IF EXISTS view_excel_clienti;
CREATE VIEW view_excel_clienti AS 
SELECT
    c.id AS `id`,
    'Privato' AS `Tipo cliente`,
    '' AS `Indirizzo telematico (Codice SDI o PEC)`,
    c.email AS `Email`,
    '' AS `PEC`,
    c.telefono AS `Telefono`,
    'IT' AS `ID Paese`,
    '' AS `Partita Iva`,
    c.cf AS `Codice fiscale`,
    c.nominativo AS `Denominazione`,
    SUBSTRING_INDEX(c.nominativo, ' ', -(1)) AS `Nome`,
    TRIM(
        SUBSTR(
            c.nominativo,
            1,
            (
                LENGTH(c.nominativo)
                - LENGTH(SUBSTRING_INDEX(c.nominativo, ' ', -(1)))
            )
        )
    ) AS `Cognome`,
    '' AS `Codice EORI (solo Privati)`,
    'IT' AS `Nazione`,
    c.cap AS `CAP`,
    'NA' AS `Provincia`,
    c.citta AS `Comune`,
    c.indirizzo AS `Indirizzo`,
    '' AS `Numero civico`,
    '' AS `Beneficiario`,
    '' AS `Condizioni di pagamento`,
    '' AS `Metodo di pagamento`,
    '' AS `Banca`
FROM clienti c
ORDER BY c.nominativo;
