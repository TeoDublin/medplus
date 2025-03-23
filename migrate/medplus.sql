DROP VIEW view_planning;
CREATE VIEW view_planning AS
SELECT 
    'sbarra' AS origin,
    pm.id AS id,
    pm.row_inizio AS row_inizio,
    pm.row_fine AS row_fine,
	DATE_FORMAT(pri.ora,"%H:%i") COLLATE utf8mb4_general_ci as ora_inizio,
    DATE_FORMAT(pr.ora,"%H:%i") COLLATE utf8mb4_general_ci as ora_fine,
    (pm.row_fine - pm.row_inizio + 1) AS row_span,
    pm.id_terapista AS id_terapista,
    SUBSTRING_INDEX(t.terapista, ' ', 1) COLLATE utf8mb4_general_ci as terapista,
    pm.data AS data,
    CONCAT(pm.data, ' ', pr.ora) AS data_fine,
    m.motivo AS motivo,
	m.motivo AS acronimo,
    '-' AS stato
FROM planning_motivi pm
LEFT JOIN motivi m ON pm.id_motivo = m.id
LEFT JOIN planning_row pri ON pm.row_inizio = pri.id
LEFT JOIN planning_row pr ON pm.row_fine = pr.id
LEFT JOIN terapisti t ON pm.id_terapista = t.id

UNION ALL

SELECT 
    'seduta' AS origin,
    sp.id AS id,
    sp.row_inizio AS row_inizio,
    sp.row_fine AS row_fine,
	DATE_FORMAT(pri.ora,"%H:%i") COLLATE utf8mb4_general_ci as ora_inizio,
    DATE_FORMAT(pr.ora,"%H:%i") COLLATE utf8mb4_general_ci as ora_fine,
    (sp.row_fine - sp.row_inizio + 1) AS row_span,
    sp.id_terapista AS id_terapista,
	SUBSTRING_INDEX(t.terapista, ' ', 1) COLLATE utf8mb4_general_ci as terapista,
    sp.data AS data,
    CONCAT(sp.data, ' ', pr.ora) AS data_fine,
    CONCAT(c.nominativo, ' (', t.trattamenti, ')') AS motivo,
	CONCAT(
		SUBSTRING_INDEX(c.nominativo, ' ', 1), 
		' ', 
		LEFT(SUBSTRING_INDEX(c.nominativo, ' ', -1), 1), 
		'. (', 
		t.acronimo, 
		')'
	) AS acronimo,
    sp.stato_prenotazione AS stato
FROM percorsi_terapeutici_sedute_prenotate sp
LEFT JOIN planning_row pr ON sp.row_fine = pr.id
LEFT JOIN planning_row pri ON sp.row_inizio = pri.id
LEFT JOIN clienti c ON sp.id_cliente = c.id
LEFT JOIN percorsi_terapeutici_sedute s ON sp.id_seduta = s.id
LEFT JOIN percorsi_combo pc ON s.id_combo = pc.id
LEFT JOIN (
    SELECT 
        pct.id_combo AS id_combo,
        GROUP_CONCAT(t.trattamento SEPARATOR ', ') AS trattamenti,
		GROUP_CONCAT(t.acronimo SEPARATOR ', ') AS acronimo
    FROM percorsi_combo_trattamenti pct
    LEFT JOIN trattamenti t ON pct.id_trattamento = t.id
    GROUP BY pct.id_combo
) t ON pc.id = t.id_combo
LEFT JOIN terapisti t ON sp.id_terapista = t.id
WHERE sp.stato_prenotazione <> 'Assente'

UNION ALL

SELECT 
    'corso' AS origin,
    cp.id AS id,
    cp.row_inizio AS row_inizio,
    cp.row_fine AS row_fine,
	DATE_FORMAT(pri.ora,"%H:%i") COLLATE utf8mb4_general_ci as ora_inizio,
    DATE_FORMAT(pr.ora,"%H:%i") COLLATE utf8mb4_general_ci as ora_fine,
    (cp.row_fine - cp.row_inizio + 1) AS row_span,
    cp.id_terapista AS id_terapista,
	SUBSTRING_INDEX(t.terapista, ' ', 1) COLLATE utf8mb4_general_ci as terapista,
    cp.data AS data,
    CONCAT(cp.data, ' ', pr.ora) AS data_fine,
    CONCAT(cp.motivo, ' ( Corso )') AS motivo,
	CONCAT(cp.motivo, ' ( Corso )') AS acronimo,
    '-' AS stato
FROM corsi_planning cp
LEFT JOIN planning_row pri ON cp.row_inizio = pri.id
LEFT JOIN planning_row pr ON cp.row_fine = pr.id
LEFT JOIN terapisti t ON cp.id_terapista = t.id

UNION ALL

SELECT 
    'colloquio' AS origin,
    cp.id AS id,
    cp.row_inizio AS row_inizio,
    cp.row_fine AS row_fine,
	DATE_FORMAT(pri.ora,"%H:%i") COLLATE utf8mb4_general_ci as ora_inizio,
    DATE_FORMAT(pr.ora,"%H:%i") COLLATE utf8mb4_general_ci as ora_fine,
    (cp.row_fine - cp.row_inizio + 1) AS row_span,
    cp.id_terapista AS id_terapista,
	SUBSTRING_INDEX(t.terapista, ' ', 1) COLLATE utf8mb4_general_ci as terapista,
    cp.data AS data,
    CONCAT(cp.data, ' ', pr.ora) AS data_fine,
    CONCAT(c.nominativo, ' ( Colloquio )') AS motivo,
	CONCAT(
		SUBSTRING_INDEX(c.nominativo, ' ', 1), 
		' ', 
		LEFT(SUBSTRING_INDEX(c.nominativo, ' ', -1), 1), 
		'. ( Colloquio )'
	) AS acronimo,
    cp.stato_prenotazione AS stato
FROM colloquio_planning cp
LEFT JOIN clienti c ON cp.id_cliente = c.id
LEFT JOIN planning_row pri ON cp.row_inizio = pri.id
LEFT JOIN terapisti t ON cp.id_terapista = t.id
LEFT JOIN planning_row pr ON cp.row_fine = pr.id;
