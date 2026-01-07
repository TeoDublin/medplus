DROP VIEW IF EXISTS view_excel_clienti;
CREATE VIEW view_excel_clienti AS
SELECT 
	id,
    'Privato' as 'Tipo cliente',
    '' as 'Indirizzo telematico (Codice SDI o PEC)',
    'email' as 'Email',
    '' as 'PEC',
    `telefono` as 'Telefono',
    'IT' as 'ID Paese',
    '' as 'Partita Iva',
    `cf` as 'Codice fiscale',
    `nominativo` as 'Denominazione',
    SUBSTRING_INDEX(`nominativo`, ' ', -1) as 'Nome',
    TRIM(SUBSTRING(`nominativo`, 1, LENGTH(`nominativo`) - LENGTH(SUBSTRING_INDEX(`nominativo`, ' ', -1)))) as 'Cognome',
    '' as 'Codice EORI (solo Privati)',
    'IT' as 'Nazione',
    `cap` as 'CAP',
    'NA' as 'Provincia',
    `citta` as 'Comune',
    `indirizzo` as 'Indirizzo',
    '' as 'Numero civico',
    '' as 'Beneficiario',
    '' as 'Condizioni di pagamento',
    '' as 'Metodo di pagamento',
    '' as 'Banca'
FROM `clienti` ORDER BY `nominativo` ASC 