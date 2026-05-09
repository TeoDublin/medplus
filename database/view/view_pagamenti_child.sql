USE medplus;
DROP VIEW IF EXISTS view_pagamenti_child;
CREATE VIEW view_pagamenti_child AS
SELECT 
  pts.id,
  pts.index,
  pts.stato_seduta,
  pts.data_seduta,
  pts.prezzo,
  COALESCE(pac.saldato,0) AS saldato,
  COALESCE(pac.fatturato,0) AS fatturato,
  pts.prezzo - COALESCE(pac.saldato,0) AS non_fatturato,

  pt.id as id_origine,
  pt.realizzato_da AS realizzato_da,
  pt.id_cliente AS id_cliente,
  (DATE_FORMAT(pt.timestamp, '%Y-%m-%d') COLLATE utf8mb4_general_ci) AS scadenza,
  pt.prezzo_tabellare AS prezzo_tabellare,

  pac.id_pagamenti,
  pac.tipo_pagamento,
  pac.id_fattura,
  pac.fattura_aruba,
  pac.origine as origine_pagamento,
  
  ('trattamenti' COLLATE utf8mb4_general_ci) AS origine,

  c.nominativo,
  t.trattamenti,
  t.acronimo AS acronimo,
  te.terapista

FROM 
    percorsi_terapeutici pt
LEFT JOIN 
    percorsi_terapeutici_sedute pts ON pts.id_percorso = pt.id
LEFT JOIN 
    percorsi_combo pc ON pt.id_combo = pc.id
LEFT JOIN 
    terapisti te ON pts.id_terapista = te.id
LEFT JOIN 
    (
        SELECT 
            pct.id_combo AS id_combo,
            GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti,
            GROUP_CONCAT(t.acronimo SEPARATOR ' - ') AS acronimo
        FROM 
            percorsi_combo_trattamenti pct
        LEFT JOIN 
            trattamenti t ON pct.id_trattamento = t.id
        GROUP BY 
            pct.id_combo
    ) t ON pc.id = t.id_combo
LEFT JOIN 
    (
        SELECT 
            pac.id_origine AS id_origine,
            pac.id_origine_child AS id_origine_child,
            pac.id_pagamenti,
            pac.tipo_pagamento,
            pac.id_fattura,
            pac.fattura_aruba,
            pac.origine,
            SUM(IF(pac.stato = 'Saldato',pac.valore,0)) AS saldato,
            SUM(IF(pac.stato <> 'Saldato', pac.valore , 0)) AS fatturato
        FROM 
            pagamenti_child pac 
        WHERE 
            pac.origine = 'Trattamenti'
        GROUP BY 
            pac.id_origine_child
    ) pac ON pts.id = pac.id_origine_child
LEFT JOIN clienti c on pt.id_cliente = c.id
GROUP BY
    pts.id


UNION ALL


SELECT 
  cp.id,
  0 as 'index',
  (IF(cp.scadenza <= CURRENT_DATE(), 'Prenotata', 'Conclusa')) as stato_seduta,
  cp.scadenza as data_seduta,
  cp.prezzo,
  COALESCE(pac.saldato,0) AS saldato,
  COALESCE(pac.fatturato,0) AS fatturato,
  cp.prezzo - COALESCE(pac.saldato,0) AS non_fatturato,

  co.id as id_origine,
  cc.realizzato_da AS realizzato_da,
  cc.id_cliente AS id_cliente,
  (cp.scadenza COLLATE utf8mb4_general_ci) AS scadenza,
  cp.prezzo_tabellare AS prezzo_tabellare,

  pac.id_pagamenti,
  pac.tipo_pagamento,
  pac.id_fattura,
  pac.fattura_aruba,
  pac.origine as origine_pagamento,
  
  ('corsi' COLLATE utf8mb4_general_ci) AS origine,

  c.nominativo,
  co.corso as trattamenti,
  co.corso AS acronimo,
  te.terapista

FROM 
    corsi_pagamenti cp
LEFT JOIN 
    corsi co ON co.id = cp.id_corso
LEFT JOIN 
    corsi_classi cc ON cp.id_corso = cc.id_corso AND cp.id_cliente = cc.id_cliente AND YEAR(cp.scadenza) = YEAR(cc.data_inizio)
LEFT JOIN 
    terapisti te ON co.id_terapista = te.id
LEFT JOIN 
    (
        SELECT 
            pac.id_origine AS id_origine,
            pac.id_origine_child AS id_origine_child,
            pac.id_pagamenti,
            pac.tipo_pagamento,
            pac.id_fattura,
            pac.fattura_aruba,
            pac.origine,
            SUM(IF(pac.stato = 'Saldato',pac.valore,0)) AS saldato,
            SUM(IF(pac.stato <> 'Saldato', pac.valore , 0)) AS fatturato
        FROM 
            pagamenti_child pac 
        WHERE 
            pac.origine = 'Corsi'
        GROUP BY 
            pac.id_origine_child
    ) pac ON cp.id = pac.id_origine_child
LEFT JOIN clienti c on cp.id_cliente = c.id
GROUP BY
    cp.id