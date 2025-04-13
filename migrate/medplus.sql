DROP VIEW IF EXISTS view_planning;
CREATE VIEW view_planning AS
-- Sbarra
SELECT 
    'sbarra' AS origin,
    pm.id AS id,
    pm.row_inizio,
    pm.row_fine,
    DATE_FORMAT(pri.ora, '%H:%i') COLLATE utf8mb4_general_ci AS ora_inizio,
    DATE_FORMAT(pr.ora, '%H:%i') COLLATE utf8mb4_general_ci AS ora_fine,
    (pm.row_fine - pm.row_inizio + 1) AS row_span,
    pm.id_terapista,
    SUBSTRING_INDEX(t.terapista, ' ', 1) COLLATE utf8mb4_general_ci AS terapista,
    pm.data,
    CONCAT(pm.data, ' ', pr.ora) AS data_fine,
    m.motivo AS motivo,
    m.motivo AS acronimo,
    '-' AS stato,
    NULL as tipo_pagamento

FROM 
    medplus.planning_motivi pm
LEFT JOIN 
    medplus.motivi m ON pm.id_motivo = m.id
LEFT JOIN 
    medplus.planning_row pri ON pm.row_inizio = pri.id
LEFT JOIN 
    medplus.planning_row pr ON pm.row_fine = pr.id
LEFT JOIN 
    medplus.terapisti t ON pm.id_terapista = t.id


UNION ALL

-- Seduta
SELECT 
    'seduta' AS origin,
    sp.id,
    sp.row_inizio,
    sp.row_fine,
    DATE_FORMAT(pri.ora, '%H:%i') COLLATE utf8mb4_general_ci AS ora_inizio,
    DATE_FORMAT(pr.ora, '%H:%i') COLLATE utf8mb4_general_ci AS ora_fine,
    (sp.row_fine - sp.row_inizio + 1) AS row_span,
    sp.id_terapista,
    SUBSTRING_INDEX(t.terapista, ' ', 1) COLLATE utf8mb4_general_ci AS terapista,
    sp.data,
    CONCAT(sp.data, ' ', pr.ora) AS data_fine,
    CONCAT(c.nominativo, ' (', t.trattamenti, ')') AS motivo,
    CONCAT(SUBSTRING_INDEX(c.nominativo, ' ', 1), ' ', LEFT(SUBSTRING_INDEX(c.nominativo, ' ', -1), 1), '. (', t.acronimo, ')') AS acronimo,
    sp.stato_prenotazione AS stato,
	s.tipo_pagamento as tipo_pagamento
FROM 
    medplus.percorsi_terapeutici_sedute_prenotate sp
LEFT JOIN 
    medplus.planning_row pr ON sp.row_fine = pr.id
LEFT JOIN 
    medplus.planning_row pri ON sp.row_inizio = pri.id
LEFT JOIN 
    medplus.clienti c ON sp.id_cliente = c.id
LEFT JOIN 
    medplus.percorsi_terapeutici_sedute s ON sp.id_seduta = s.id
LEFT JOIN 
    medplus.percorsi_combo pc ON s.id_combo = pc.id
LEFT JOIN (
    SELECT 
        pct.id_combo,
        GROUP_CONCAT(t.trattamento SEPARATOR ', ') AS trattamenti,
        GROUP_CONCAT(t.acronimo SEPARATOR ', ') AS acronimo
    FROM 
        medplus.percorsi_combo_trattamenti pct
    LEFT JOIN 
        medplus.trattamenti t ON pct.id_trattamento = t.id
    GROUP BY 
        pct.id_combo
) t ON pc.id = t.id_combo
LEFT JOIN 
    medplus.terapisti t ON sp.id_terapista = t.id
WHERE 
    sp.stato_prenotazione <> 'Assente'

UNION ALL

-- Corso
SELECT 
    'corso' AS origin,
    cp.id,
    cp.row_inizio,
    cp.row_fine,
    DATE_FORMAT(pri.ora, '%H:%i') COLLATE utf8mb4_general_ci AS ora_inizio,
    DATE_FORMAT(pr.ora, '%H:%i') COLLATE utf8mb4_general_ci AS ora_fine,
    (cp.row_fine - cp.row_inizio + 1) AS row_span,
    cp.id_terapista,
    SUBSTRING_INDEX(t.terapista, ' ', 1) COLLATE utf8mb4_general_ci AS terapista,
    cp.data,
    CONCAT(cp.data, ' ', pr.ora) AS data_fine,
    CONCAT(cp.motivo, ' ( Corso )') AS motivo,
    CONCAT(cp.motivo, ' ( Corso )') AS acronimo,
    '-' AS stato,
	NULL as tipo_pagamento
FROM 
    medplus.corsi_planning cp
LEFT JOIN 
    medplus.planning_row pri ON cp.row_inizio = pri.id
LEFT JOIN 
    medplus.planning_row pr ON cp.row_fine = pr.id
LEFT JOIN 
    medplus.terapisti t ON cp.id_terapista = t.id

UNION ALL

-- Colloquio
SELECT 
    'colloquio' AS origin,
    cp.id,
    cp.row_inizio,
    cp.row_fine,
    DATE_FORMAT(pri.ora, '%H:%i') COLLATE utf8mb4_general_ci AS ora_inizio,
    DATE_FORMAT(pr.ora, '%H:%i') COLLATE utf8mb4_general_ci AS ora_fine,
    (cp.row_fine - cp.row_inizio + 1) AS row_span,
    cp.id_terapista,
    SUBSTRING_INDEX(t.terapista, ' ', 1) COLLATE utf8mb4_general_ci AS terapista,
    cp.data,
    CONCAT(cp.data, ' ', pr.ora) AS data_fine,
    CONCAT(c.nominativo, ' ( Colloquio )') AS motivo,
    CONCAT(SUBSTRING_INDEX(c.nominativo, ' ', 1), ' ', LEFT(SUBSTRING_INDEX(c.nominativo, ' ', -1), 1), '. ( Colloquio )') AS acronimo,
    cp.stato_prenotazione AS stato,
	NULL as tipo_pagamento
FROM 
    medplus.colloquio_planning cp
LEFT JOIN 
    medplus.clienti c ON cp.id_cliente = c.id
LEFT JOIN 
    medplus.planning_row pri ON cp.row_inizio = pri.id
LEFT JOIN 
    medplus.terapisti t ON cp.id_terapista = t.id
LEFT JOIN 
    medplus.planning_row pr ON cp.row_fine = pr.id;



DROP VIEW IF EXISTS view_sedute;
CREATE VIEW view_sedute as 

SELECT 
  pts.id AS id,
  pts.`index` AS `index`,
  pts.id_cliente AS id_cliente,
  pts.id_percorso AS id_percorso,
  pts.id_combo AS id_combo,
  pts.prezzo AS prezzo,
  pts.saldato AS saldato,
  pts.id_terapista AS id_terapista,
  pts.percentuale_terapista AS percentuale_terapista,
  pts.saldo_terapista AS saldo_terapista,
  pts.saldato_terapista AS saldato_terapista,
  pts.stato_seduta COLLATE utf8mb4_general_ci AS stato_seduta,
  pts.stato_pagamento COLLATE utf8mb4_general_ci AS stato_pagamento,
  pts.stato_saldato_terapista COLLATE utf8mb4_general_ci AS stato_saldato_terapista,
  pts.data_seduta COLLATE utf8mb4_general_ci AS data_seduta,
  pts.data_pagamento COLLATE utf8mb4_general_ci AS data_pagamento,
  pts.data_saldato_terapista COLLATE utf8mb4_general_ci AS data_saldato_terapista,
  pts.timestamp COLLATE utf8mb4_general_ci AS `timestamp`,
  c.nominativo COLLATE utf8mb4_general_ci AS nominativo,
  tpd.terapista COLLATE utf8mb4_general_ci AS portato_da,
  t.terapista COLLATE utf8mb4_general_ci AS terapista,
  tc.trattamenti COLLATE utf8mb4_general_ci AS trattamenti,
  ta.acronimo COLLATE utf8mb4_general_ci AS acronimo,
  pts.tipo_pagamento

FROM medplus.percorsi_terapeutici_sedute pts

LEFT JOIN medplus.terapisti t 
  ON pts.id_terapista = t.id

LEFT JOIN medplus.clienti c 
  ON pts.id_cliente = c.id

LEFT JOIN medplus.terapisti tpd 
  ON c.portato_da = tpd.id

LEFT JOIN (
  SELECT 
    pct.id_combo AS id_combo,
    GROUP_CONCAT(t.trattamento SEPARATOR ';') AS trattamenti
  FROM medplus.percorsi_combo_trattamenti pct
  LEFT JOIN medplus.trattamenti t 
    ON pct.id_trattamento = t.id
  GROUP BY pct.id_combo
) tc 
  ON pts.id_combo = tc.id_combo

LEFT JOIN (
  SELECT 
    pct.id_combo AS id_combo,
    GROUP_CONCAT(t.acronimo SEPARATOR ' - ') AS acronimo
  FROM medplus.percorsi_combo_trattamenti pct
  LEFT JOIN medplus.trattamenti t 
    ON pct.id_trattamento = t.id
  GROUP BY pct.id_combo
) ta 
  ON pts.id_combo = ta.id_combo;

ALTER TABLE `fatture` ADD `request` LONGTEXT NOT NULL AFTER `metodo`;
ALTER TABLE `fatture` ADD `fatturato_da` ENUM('Medplus','Isico') NOT NULL DEFAULT 'Medplus' AFTER `request`;
ALTER TABLE `fatture` ADD `confermato_dal_commercialista` BOOLEAN NOT NULL DEFAULT FALSE AFTER `fatturato_da`;

DROP view IF EXISTS view_fatture;
CREATE VIEW view_fatture AS 
SELECT 
  f.id AS id,
  f.id_cliente AS id_cliente,
  f.link COLLATE utf8mb4_general_ci AS link,
  f.importo AS importo,
  f.index AS `index`,
  f.data AS data,
  f.stato COLLATE utf8mb4_general_ci AS stato,
  f.metodo COLLATE utf8mb4_general_ci AS metodo,
  f.request AS request,
  f.fatturato_da COLLATE utf8mb4_general_ci AS fatturato_da,
  f.timestamp AS timestamp,
  f.confermato_dal_commercialista AS confermato_dal_commercialista,
  c.nominativo COLLATE utf8mb4_general_ci AS nominativo
FROM 
  medplus.fatture f
LEFT JOIN 
  medplus.clienti c ON f.id_cliente = c.id
ORDER BY f.index ASC;