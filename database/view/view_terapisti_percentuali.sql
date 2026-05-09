
USE medplus;
DROP VIEW IF EXISTS view_terapisti_percentuali;
CREATE VIEW view_terapisti_percentuali AS 
SELECT 
	t.id,
    t.terapista,
    t.profilo,
    COALESCE(
        GROUP_CONCAT(
            CASE 
                WHEN tipo_percorso = 'Corsi' 
                THEN CONCAT(tipo_percentuale, ': ', ROUND(percentuale,0),'%') 
            END
            ORDER BY tipo_percentuale
            SEPARATOR ', '
        ),
		'-'
	) AS percentuali_corsi,
	COALESCE(
        GROUP_CONCAT(
            CASE 
                WHEN tipo_percorso = 'Trattamenti' 
                THEN CONCAT(tipo_percentuale, ': ', ROUND(percentuale,0),'%') 
            END
            ORDER BY tipo_percentuale
            SEPARATOR ', '
        ),
		'-'
	) AS percentuali_trattamenti

FROM terapisti t
LEFT JOIN terapisti_percentuali tp ON t.id = tp.id_terapista
GROUP BY 
	t.id