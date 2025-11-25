DROP VIEW IF EXISTS view_uscite_registrate;
CREATE VIEW view_uscite_registrate AS
SELECT 
    ur.id,
    ur.id_categoria,
    ur.id_uscita,
    ur.id_indirizzato_a,
    ur.in_capo_a,
    ur.data_pagamento,
    ur.tipo_pagamento,
    ur.importo,
    ur.voucher,
    ur.note,
    uc.categoria,
    uia.indirizzato_a,
    uu.uscita
FROM `uscite_registrate` ur
LEFT JOIN uscite_categoria uc ON ur.id_categoria = uc.id
LEFT JOIN uscite_indirizzato_a uia ON ur.id_indirizzato_a = uia.id
LEFT JOIN uscite_uscita uu ON ur.id_uscita = uu.id