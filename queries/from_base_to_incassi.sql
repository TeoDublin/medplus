SELECT base.* FROM
(
    SELECT 
    	cp.id, 
    	cp.id_pagamenti as 'id_pagamenti', 
    	psf.id_pagamenti as 'psf_id_pagamenti',
    	pi.id_pagamenti as 'pi_id_pagamenti',
		f.id_pagamenti as 'f_id_pagamenti',
    	pa.id_pagamenti as 'pa_id_pagamenti',
    	sum(cp.prezzo) as prezzo, 
    	'corsi' as tipo
    FROM `corsi_pagamenti` cp 
    LEFT JOIN pagamenti_senza_fattura psf on cp.id = psf.id_origine_child
	LEFT JOIN pagamenti_isico pi on cp.id = pi.id_origine_child
	LEFT JOIN pagamenti_fatture pf on cp.id = pf.id_origine_child
    LEFT JOIN fatture f on pf.id_fattura = f.id
	left join pagamenti_aruba pa on cp.id = pa.id_origine_child
    WHERE cp.id_pagamenti > 0
    group by cp.id, cp.id_pagamenti

    union all

    select 
    	pts.id, 
    	pts.id_pagamenti as 'id_pagamenti', 
    	psf.id_pagamenti as 'psf_id_pagamenti',
    	pi.id_pagamenti as 'pi_id_pagamenti',
		f.id_pagamenti as 'f_id_pagamenti',
    	pa.id_pagamenti as 'pa_id_pagamenti',
    	sum(pts.saldato) as prezzo,
    	'sedute' as tipo
    from percorsi_terapeutici_sedute pts
    LEFT JOIN pagamenti_senza_fattura psf on pts.id = psf.id_origine_child
	LEFT JOIN pagamenti_isico pi on pts.id = pi.id_origine_child
	LEFT JOIN pagamenti_fatture pf on pts.id = pf.id_origine_child
    LEFT JOIN fatture f on pf.id_fattura = f.id
	left join pagamenti_aruba pa on pts.id = pa.id_origine_child
    WHERE pts.id_pagamenti > 0
    group by pts.id, pts.id_pagamenti
) base 
LEFT JOIN pagamenti p on base.id_pagamenti = p.id
where p.id is null
