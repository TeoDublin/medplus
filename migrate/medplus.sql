ALTER TABLE `ruoli_utenti` ADD CONSTRAINT `ruoli_utenti_ruoli` FOREIGN KEY (`id_ruolo`) REFERENCES `ruoli`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `terapisti` 
    ADD `percentuale_sedute` INT(11) NOT NULL DEFAULT '0'  AFTER `terapista`,  
    ADD `percentuale_corsi` INT(11) NOT NULL DEFAULT '0'  AFTER `percentuale_sedute`;

ALTER TABLE `percorsi_terapeutici_sedute`  
    ADD `id_terapista` INT NULL  AFTER `id_combo`, 
    ADD `percentuale_terapista` INT NULL AFTER `id_terapista`,  
    ADD `saldo_terapista` DOUBLE(10,2) NULL AFTER `percentuale_terapista`,  
    ADD `saldato_terapista` DOUBLE(10,2) NULL AFTER `saldo_terapista`,
    ADD `stato_saldato_terapista` ENUM('Pendente','Saldato','Parziale') NOT NULL DEFAULT 'Pendente' AFTER `saldo_terapista`,
    ADD `stato_seduta` ENUM('Pendente','Assente','Conclusa','Prenotata') NOT NULL DEFAULT 'Pendente' AFTER `saldo_terapista`,  
    ADD `data_seduta` DATE NULL AFTER `stato_saldato_terapista`,
    ADD `data_pagamento` DATE NULL AFTER `data_seduta`, 
    ADD `data_saldato_terapista` DATE NULL AFTER `data_pagamento`,
    ADD `tipo_pagamento` ENUM('Senza Fattura','Aruba','Fattura') NULL AFTER `data_pagamento`,
    ADD  INDEX  `id_terapista` (`id_terapista`);

-- query to refresh new columns percorsi_terapeutici_sedute


DROP VIEW IF EXISTS view_sedute;
CREATE VIEW view_sedute AS 

SELECT 
    pts.*,
    c.nominativo AS nominativo,
    t.terapista AS terapista
FROM percorsi_terapeutici_sedute pts
LEFT JOIN terapisti t ON pts.id_terapista = t.id
LEFT JOIN clienti c ON pts.id_cliente = c.id;


INSERT INTO `ruoli` (`id`, `ruolo`, `home`) VALUES (NULL, 'commercialista', 'commercialista'), (NULL, 'direzione', 'direzione');

INSERT INTO `utenti` (`id`, `user`, `password`, `nome`) VALUES ('6', 'commercialista', '$2y$10$HcnYhJXcs9byefQqIDmV/OOOUL1iTHJvVj3OfQT4y/Ce0pyQopnjG', 'Commercialista');

INSERT INTO `utenti` (`id`, `user`, `password`, `nome`) VALUES ('7', 'direzione', '$2y$10$Lcc31McAqeec49qOVDW/8uiwhm.wyd2t9/hXDwyWyYpznCnsulob2', 'Direzione');

INSERT INTO `ruoli_utenti` (`id`, `id_utente`, `id_ruolo`) VALUES (NULL, '7', '4');

INSERT INTO ruoli_elementi SELECT NULL,4,id FROM elementi