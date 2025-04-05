UPDATE `percorsi_terapeutici_sedute` pts
JOIN (
    SELECT 
        pts.id,
        COALESCE(
            MAX(CASE WHEN ptsp_c.stato_prenotazione = 'Conclusa' THEN ptsp_c.stato_prenotazione END),
            MAX(CASE WHEN ptsp_p.stato_prenotazione = 'Prenotata' THEN ptsp_p.stato_prenotazione END),
            MAX(CASE WHEN ptsp_a.stato_prenotazione = 'Assente' THEN ptsp_a.stato_prenotazione END),
            'Pendente'
        ) AS nuovo_stato_seduta,
        COALESCE(
            MAX(CASE WHEN ptsp_c.stato_prenotazione = 'Conclusa' THEN ptsp_c.data END),
            MAX(CASE WHEN ptsp_p.stato_prenotazione = 'Prenotata' THEN ptsp_p.data END),
            MAX(CASE WHEN ptsp_a.stato_prenotazione = 'Assente' THEN ptsp_a.data END)
        ) AS nuova_data_seduta,
        COALESCE(
            MAX(CASE WHEN ptsp_c.stato_prenotazione = 'Conclusa' THEN ptsp_c.id_terapista END),
            MAX(CASE WHEN ptsp_p.stato_prenotazione = 'Prenotata' THEN ptsp_p.id_terapista END),
            MAX(CASE WHEN ptsp_a.stato_prenotazione = 'Assente' THEN ptsp_a.id_terapista END)
        ) AS nuovo_id_terapista
    FROM percorsi_terapeutici_sedute pts
    LEFT JOIN percorsi_terapeutici_sedute_prenotate ptsp_c 
        ON pts.id = ptsp_c.id_seduta AND ptsp_c.stato_prenotazione = 'Conclusa'
    LEFT JOIN percorsi_terapeutici_sedute_prenotate ptsp_p 
        ON pts.id = ptsp_p.id_seduta AND ptsp_p.stato_prenotazione = 'Prenotata'
    LEFT JOIN percorsi_terapeutici_sedute_prenotate ptsp_a 
        ON pts.id = ptsp_a.id_seduta AND ptsp_a.stato_prenotazione = 'Assente'
    GROUP BY pts.id
) AS subquery ON pts.id = subquery.id
SET 
    pts.stato_seduta = subquery.nuovo_stato_seduta,
    pts.data_seduta = subquery.nuova_data_seduta,
    pts.id_terapista = subquery.nuovo_id_terapista;


UPDATE `percorsi_terapeutici_sedute` pts
LEFT JOIN terapisti t ON pts.id_terapista = t.id
SET pts.percentuale_terapista = t.percentuale_sedute;

update `percorsi_terapeutici_sedute` set saldo_terapista = ROUND((prezzo * percentuale_terapista)/100,2);