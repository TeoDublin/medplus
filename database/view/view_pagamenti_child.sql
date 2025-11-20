DROP VIEW IF EXISTS view_pagamenti_child;
CREATE VIEW view_pagamenti_child AS 
SELECT 
	psf.id,
  psf.id_origine,
  psf.id_pagamenti,
  psf.origine,
  'senza_fattura' as origine_pagamento,
  psf.id_cliente,
	pts.index,
	pts.stato_seduta,
  pts.data_seduta,
  pts.prezzo,
  te.terapista,
  t.trattamenti,
  pt.realizzato_da,
  cp.prezzo as corso_prezzo,
  cp.scadenza as corso_scadenza,
  tc.terapista as corso_terapista,
	c.corso
FROM `pagamenti_senza_fattura` psf
LEFT JOIN percorsi_terapeutici_sedute pts ON psf.id_origine_child = pts.id AND psf.origine = 'trattamenti'
LEFT JOIN percorsi_terapeutici pt ON pts.id_percorso = pt.id
LEFT JOIN terapisti te ON pts.id_terapista = te.id
LEFT JOIN (
  SELECT 
    pct.id_combo,
    GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
  FROM medplus.percorsi_combo_trattamenti pct
  LEFT JOIN medplus.trattamenti t ON pct.id_trattamento = t.id
  GROUP BY pct.id_combo
) t ON pts.id_combo = t.id_combo
LEFT JOIN corsi_pagamenti cp ON psf.id_origine_child = cp.id AND psf.origine = 'corsi'
LEFT JOIN corsi c ON cp.id_corso = c.id
LEFT JOIN terapisti tc ON c.id_terapista = tc.id
GROUP BY psf.id_origine_child, psf.id_pagamenti

UNION ALL

SELECT 
	psf.id,
  psf.id_origine,
  psf.id_pagamenti,
  psf.origine,
  'isico' as origine_pagamento,
  psf.id_cliente,
	pts.index,
	pts.stato_seduta,
    pts.data_seduta,
    pts.prezzo,
    te.terapista,
    t.trattamenti,
    pt.realizzato_da,
    cp.prezzo as corso_prezzo,
    cp.scadenza as corso_scadenza,
    tc.terapista as corso_terapista,
	  c.corso
FROM `pagamenti_isico` psf
LEFT JOIN percorsi_terapeutici_sedute pts ON psf.id_origine_child = pts.id AND psf.origine = 'trattamenti'
LEFT JOIN percorsi_terapeutici pt ON pts.id_percorso = pt.id
LEFT JOIN terapisti te ON pts.id_terapista = te.id
LEFT JOIN (
  SELECT 
    pct.id_combo,
    GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
  FROM medplus.percorsi_combo_trattamenti pct
  LEFT JOIN medplus.trattamenti t ON pct.id_trattamento = t.id
  GROUP BY pct.id_combo
) t ON pts.id_combo = t.id_combo
LEFT JOIN corsi_pagamenti cp ON psf.id_origine_child = cp.id AND psf.origine = 'corsi'
LEFT JOIN corsi c ON cp.id_corso = c.id
LEFT JOIN terapisti tc ON c.id_terapista = tc.id
GROUP BY psf.id_origine_child, psf.id_pagamenti

UNION ALL

SELECT 
	psf.id,
  psf.id_origine,
  psf.id_pagamenti,
  psf.origine,
  'aruba' as origine_pagamento,
  psf.id_cliente,
	pts.index,
	pts.stato_seduta,
    pts.data_seduta,
    pts.prezzo,
    te.terapista,
    t.trattamenti,
    pt.realizzato_da,
    cp.prezzo as corso_prezzo,
    cp.scadenza as corso_scadenza,
    tc.terapista as corso_terapista,
	c.corso
FROM `pagamenti_aruba` psf
LEFT JOIN percorsi_terapeutici_sedute pts ON psf.id_origine_child = pts.id AND psf.origine = 'trattamenti'
LEFT JOIN percorsi_terapeutici pt ON pts.id_percorso = pt.id
LEFT JOIN terapisti te ON pts.id_terapista = te.id
LEFT JOIN (
  SELECT 
    pct.id_combo,
    GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
  FROM medplus.percorsi_combo_trattamenti pct
  LEFT JOIN medplus.trattamenti t ON pct.id_trattamento = t.id
  GROUP BY pct.id_combo
) t ON pts.id_combo = t.id_combo
LEFT JOIN corsi_pagamenti cp ON psf.id_origine_child = cp.id AND psf.origine = 'corsi'
LEFT JOIN corsi c ON cp.id_corso = c.id
LEFT JOIN terapisti tc ON c.id_terapista = tc.id
GROUP BY psf.id_origine_child, psf.id_pagamenti

UNION ALL

SELECT 
	psf.id,
  psf.id_origine,
  f.id_pagamenti,
  psf.origine,
  'fatture' as origine_pagamento,
  psf.id_cliente,
	pts.index,
	pts.stato_seduta,
    pts.data_seduta,
    pts.prezzo,
    te.terapista,
    t.trattamenti,
    pt.realizzato_da,
    cp.prezzo as corso_prezzo,
    cp.scadenza as corso_scadenza,
    tc.terapista as corso_terapista,
	c.corso
FROM `pagamenti_fatture` psf
LEFT JOIN fatture f ON psf.id_fattura = f.id
LEFT JOIN percorsi_terapeutici_sedute pts ON psf.id_origine_child = pts.id AND psf.origine = 'trattamenti'
LEFT JOIN percorsi_terapeutici pt ON pts.id_percorso = pt.id
LEFT JOIN terapisti te ON pts.id_terapista = te.id
LEFT JOIN (
  SELECT 
    pct.id_combo,
    GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
  FROM medplus.percorsi_combo_trattamenti pct
  LEFT JOIN medplus.trattamenti t ON pct.id_trattamento = t.id
  GROUP BY pct.id_combo
) t ON pts.id_combo = t.id_combo
LEFT JOIN corsi_pagamenti cp ON psf.id_origine_child = cp.id AND psf.origine = 'corsi'
LEFT JOIN corsi c ON cp.id_corso = c.id
LEFT JOIN terapisti tc ON c.id_terapista = tc.id
GROUP BY psf.id_origine_child, f.id_pagamenti;