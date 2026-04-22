USE medplus;
DROP VIEW IF EXISTS view_utenti;
CREATE  VIEW `view_utenti`  AS 
	SELECT
        u.id        AS id,
        u.user      AS user,
        u.password  AS password,
        u.email     AS email,
        u.nome      AS nome,
        u.expiry    AS expiry,
        ru.id_ruolo AS id_ruolo,
        r.ruolo     AS ruolo,
        r.home      AS home
    FROM utenti u
    LEFT JOIN ruoli_utenti ru ON u.id = ru.id_utente
    LEFT JOIN ruoli r ON ru.id_ruolo = r.id;