DROP VIEW IF EXISTS view_pagamenti;
CREATE VIEW view_pagamenti AS
SELECT 
    ('trattamenti' COLLATE utf8mb4_general_ci) AS origine,
    pt.realizzato_da AS realizzato_da,
    pt.id AS id,
    pt.id_cliente AS id_cliente,
    pt.id_combo AS id_origine,
    pt.bnw AS bnw,
    t.trattamenti AS nome,
    ta.acronimo AS acronimo,
    (DATE_FORMAT(pt.timestamp, '%Y-%m-%d') COLLATE utf8mb4_general_ci) AS scadenza,
    pt.prezzo_tabellare AS prezzo_tabellare,
    pt.prezzo AS prezzo,
    (
        (
            (COALESCE(pf.saldato_fatture, 0) + COALESCE(psf.totale_valore, 0)) 
            + COALESCE(pi.totale_valore, 0)
        ) + COALESCE(pa.totale_valore, 0)
    ) AS saldato,
    COALESCE(pf.pendente_fatture, 0) AS fatturato,
    (
        pt.prezzo - (
            (
                (
                    (COALESCE(pf.saldato_fatture, 0) + COALESCE(psf.totale_valore, 0))
                    + COALESCE(pi.totale_valore, 0)
                ) + COALESCE(pa.totale_valore, 0)
            ) + COALESCE(pf.pendente_fatture, 0)
        )
    ) AS non_fatturato
FROM 
    medplus.percorsi_terapeutici pt
LEFT JOIN 
    medplus.percorsi_combo pc ON pt.id_combo = pc.id
LEFT JOIN 
    (
        SELECT 
            pct.id_combo AS id_combo,
            GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
        FROM 
            medplus.percorsi_combo_trattamenti pct
        LEFT JOIN 
            medplus.trattamenti t ON pct.id_trattamento = t.id
        GROUP BY 
            pct.id_combo
    ) t ON pc.id = t.id_combo
LEFT JOIN 
    (
        SELECT 
            pct.id_combo AS id_combo,
            GROUP_CONCAT(t.acronimo SEPARATOR ' - ') AS acronimo
        FROM 
            medplus.percorsi_combo_trattamenti pct
        LEFT JOIN 
            medplus.trattamenti t ON pct.id_trattamento = t.id
        GROUP BY 
            pct.id_combo
    ) ta ON pc.id = ta.id_combo
LEFT JOIN 
    (
        SELECT 
            psf.id_origine AS id_origine,
            COALESCE(SUM(psf.valore), 0) AS totale_valore
        FROM 
            medplus.pagamenti_senza_fattura psf
        WHERE 
            psf.origine = 'trattamenti'
        GROUP BY 
            psf.id_origine
    ) psf ON pt.id = psf.id_origine
LEFT JOIN 
    (
        SELECT 
            pi.id_origine AS id_origine,
            COALESCE(SUM(pi.valore), 0) AS totale_valore
        FROM 
            medplus.pagamenti_isico pi
        WHERE 
            pi.origine = 'trattamenti'
        GROUP BY 
            pi.id_origine
    ) pi ON pt.id = pi.id_origine
LEFT JOIN 
    (
        SELECT 
            pa.id_origine AS id_origine,
            COALESCE(SUM(pa.valore), 0) AS totale_valore
        FROM 
            medplus.pagamenti_aruba pa
        WHERE 
            pa.origine = 'trattamenti'
        GROUP BY 
            pa.id_origine
    ) pa ON pt.id = pa.id_origine
LEFT JOIN 
    (
        SELECT 
            pf.id_origine AS id_origine,
            pf.origine AS origine,
            SUM(CASE WHEN f.stato = 'Saldata' THEN pf.importo ELSE 0 END) AS saldato_fatture,
            SUM(CASE WHEN f.stato = 'Pendente' THEN pf.importo ELSE 0 END) AS pendente_fatture
        FROM 
            medplus.pagamenti_fatture pf
        LEFT JOIN 
            medplus.fatture f ON pf.id_fattura = f.id
        WHERE 
            pf.origine = 'trattamenti'
        GROUP BY 
            pf.id_origine, pf.origine
    ) pf ON pt.id = pf.id_origine

UNION ALL

SELECT 
    ('corsi' COLLATE utf8mb4_general_ci) AS origine,
    cc.realizzato_da AS realizzato_da,
    cp.id AS id,
    cp.id_cliente AS id_cliente,
    c.id AS id_origine,
    cc.bnw AS bnw,
    c.corso AS nome,
    c.corso AS acronimo,
    (cp.scadenza COLLATE utf8mb4_general_ci) AS scadenza,
    cp.prezzo_tabellare AS prezzo_tabellare,
    cp.prezzo AS prezzo,
    (
        (
            (COALESCE(pf.saldato_fatture, 0) + COALESCE(psf.totale_valore, 0))
            + COALESCE(pi.totale_valore, 0)
        ) + COALESCE(pa.totale_valore, 0)
    ) AS saldato,
    COALESCE(pf.pendente_fatture, 0) AS fatturato,
    (
        cp.prezzo - (
            (
                (
                    (COALESCE(pf.saldato_fatture, 0) + COALESCE(psf.totale_valore, 0))
                    + COALESCE(pi.totale_valore, 0)
                ) + COALESCE(pa.totale_valore, 0)
            ) + COALESCE(pf.pendente_fatture, 0)
        )
    ) AS non_fatturato
FROM 
    medplus.corsi_pagamenti cp
LEFT JOIN corsi_classi cc ON cp.id_corso = cc.id_corso AND cp.id_cliente = cc.id_cliente AND YEAR(cp.scadenza) = YEAR(cc.data_inizio)
LEFT JOIN 
    (
        SELECT 
            psf.id_origine AS id_origine,
            psf.id_origine_child AS id_origine_child,
            COALESCE(SUM(psf.valore), 0) AS totale_valore
        FROM 
            medplus.pagamenti_senza_fattura psf
        WHERE 
            psf.origine = 'corsi'
        GROUP BY 
            psf.id_origine_child
    ) psf ON cp.id = psf.id_origine_child
LEFT JOIN 
    (
        SELECT 
            pi.id_origine AS id_origine,
            pi.id_origine_child AS id_origine_child,
            COALESCE(SUM(pi.valore), 0) AS totale_valore
        FROM 
            medplus.pagamenti_isico pi
        WHERE 
            pi.origine = 'corsi'
        GROUP BY 
            pi.id_origine_child
    ) pi ON cp.id = pi.id_origine_child
LEFT JOIN 
    (
        SELECT 
            pa.id_origine AS id_origine,
            pa.id_origine_child AS id_origine_child,
            COALESCE(SUM(pa.valore), 0) AS totale_valore
        FROM 
            medplus.pagamenti_aruba pa
        WHERE 
            pa.origine = 'corsi'
        GROUP BY 
            pa.id_origine_child
    ) pa ON cp.id = pa.id_origine_child
LEFT JOIN 
    (
        SELECT 
            pf.id_origine AS id_origine,
            pf.id_origine_child AS id_origine_child,
            pf.origine AS origine,
            SUM(CASE WHEN f.stato = 'Saldata' THEN pf.importo ELSE 0 END) AS saldato_fatture,
            SUM(CASE WHEN f.stato = 'Pendente' THEN pf.importo ELSE 0 END) AS pendente_fatture
        FROM 
            medplus.pagamenti_fatture pf
        LEFT JOIN 
            medplus.fatture f ON pf.id_fattura = f.id
        WHERE 
            pf.origine = 'corsi'
        GROUP BY 
            pf.id_origine_child, pf.origine
    ) pf ON cp.id = pf.id_origine_child
LEFT JOIN 
    medplus.corsi c ON cp.id_corso = c.id
ORDER BY 
    id_cliente DESC;
