USE medplus;

DROP VIEW IF EXISTS view_trattamenti;
CREATE VIEW view_trattamenti AS
SELECT
    t.id AS id,
    t.id_categoria AS id_categoria,
    t.id_colore AS id_colore,
    t.trattamento AS trattamento,
    t.acronimo AS acronimo,
    t.prezzo AS prezzo,
    tc.categoria AS categoria,
    c.nome AS colore_nome,
    c.colore AS colore
FROM trattamenti t
LEFT JOIN trattamenti_categorie tc ON t.id_categoria = tc.id
LEFT JOIN trattamenti_colori c ON t.id_colore = c.id;
