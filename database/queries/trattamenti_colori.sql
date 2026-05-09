USE medplus;

CREATE TABLE IF NOT EXISTS trattamenti_colori (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(40) NOT NULL,
    colore CHAR(7) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY colore (colore),
    UNIQUE KEY nome (nome)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO trattamenti_colori (nome, colore) VALUES
    ('Grigio', '#e8eaed'),
    ('Ardesia', '#cfd8dc'),
    ('Sabbia', '#d7ccc8'),
    ('Mattone', '#bcaaa4'),
    ('Rosso', '#f28b82'),
    ('Corallo', '#ff8a65'),
    ('Salmone', '#ffab91'),
    ('Pesca', '#ffccbc'),
    ('Arancione', '#fbbc04'),
    ('Ambra', '#ffd54f'),
    ('Senape', '#ffcc80'),
    ('Ocra', '#d4a017'),
    ('Giallo', '#fff475'),
    ('Crema', '#fff9c4'),
    ('Lime', '#dce775'),
    ('Oliva', '#c5e1a5'),
    ('Pistacchio', '#aed581'),
    ('Verde', '#ccff90'),
    ('Bosco', '#a5d6a7'),
    ('Smeraldo', '#81c784'),
    ('Menta', '#80cbc4'),
    ('Acquamarina', '#b2dfdb'),
    ('Petrolio', '#4db6ac'),
    ('Turchese', '#a7ffeb'),
    ('Laguna', '#b2ebf2'),
    ('Ciano', '#80deea'),
    ('Celeste', '#81d4fa'),
    ('Azzurro', '#cbf0f8'),
    ('Carta da zucchero', '#bbdefb'),
    ('Blu', '#aecbfa'),
    ('Pervinca', '#90caf9'),
    ('Indaco', '#9fa8da'),
    ('Lavanda', '#b39ddb'),
    ('Lilla', '#d1c4e9'),
    ('Prugna', '#ce93d8'),
    ('Viola', '#d7aefb'),
    ('Malva', '#e1bee7'),
    ('Fucsia', '#f48fb1'),
    ('Cipria', '#f8bbd0'),
    ('Rosa', '#fdcfe8'),
    ('Bordeaux', '#d88a8a'),
    ('Giada', '#8fd8b8'),
    ('Notte', '#9bb7d4');

ALTER TABLE trattamenti
    ADD COLUMN id_colore INT NULL AFTER prezzo,
    ADD UNIQUE KEY trattamenti_id_colore_unique (id_colore),
    ADD CONSTRAINT trattamenti_id_colore_fk
        FOREIGN KEY (id_colore) REFERENCES trattamenti_colori (id)
        ON DELETE SET NULL;
