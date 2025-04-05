
DELIMITER $$

DROP TRIGGER IF EXISTS `utenti_after_insert`;
CREATE TRIGGER `utenti_after_insert` AFTER INSERT ON `utenti` FOR EACH ROW INSERT INTO `utenti_preferenze` (`id`, `id_utente`, `chiave`, `valore`) VALUES (NULL, NEW.id, 'planning_colors', ':root{--base-bg-colloquio:#aad5d8;--base-bg-seduta:#56ebf7;--base-bg-corso:#32ffbb;--base-bg-sbarra:#5d7fff;}');

DROP TRIGGER IF EXISTS percorsi_terapeutici_sedute_before_update$$
CREATE TRIGGER percorsi_terapeutici_sedute_before_update 
BEFORE UPDATE ON percorsi_terapeutici_sedute 
FOR EACH ROW
BEGIN
	IF(NEW.id_terapista <> OLD.id_terapista OR NEW.prezzo <> OLD.prezzo) THEN
		SELECT percentuale_sedute 
		INTO @percentuale_sedute 
		FROM terapisti 
		WHERE id = NEW.id_terapista 
		LIMIT 1;

		SET NEW.percentuale_terapista = @percentuale_sedute;
		SET NEW.saldo_terapista = ROUND(((NEW.prezzo * @percentuale_sedute)/100),2);
		IF( OLD.saldato_terapista IS NULL ) THEN
			SET NEW.saldato_terapista = 0;
		END IF;
	END IF;
	
	IF(NEW.saldato <> OLD.saldato) THEN
		IF(NEW.saldato >= NEW.prezzo) THEN
			SET NEW.stato_pagamento = 'Saldato';
		ELSEIF(NEW.saldato > 0) THEN
			SET NEW.stato_pagamento = 'Parziale';
		ELSE 
			SET NEW.stato_pagamento = 'Pendente';
		END IF;
	END IF;

	IF(NEW.saldato_terapista <> OLD.saldato_terapista OR NEW.id_terapista <> OLD.id_terapista) THEN
		IF(NEW.saldato_terapista >= NEW.saldo_terapista) THEN
			SET NEW.stato_saldato_terapista = 'Saldato';
		ELSEIF(NEW.saldato_terapista > 0) THEN
			SET NEW.stato_saldato_terapista = 'Parziale';
		ELSE 
			SET NEW.stato_saldato_terapista = 'Pendente';
		END IF;
	END IF;
END$$

DROP TRIGGER IF EXISTS percorsi_terapeutici_sedute_prenotate_after_insert$$
CREATE TRIGGER percorsi_terapeutici_sedute_prenotate_after_insert 
AFTER INSERT ON percorsi_terapeutici_sedute_prenotate 
FOR EACH ROW
BEGIN
	UPDATE percorsi_terapeutici_sedute 
	SET id_terapista = NEW.id_terapista, stato_seduta = NEW.stato_prenotazione, data_seduta = NEW.data
	WHERE id = NEW.id_seduta;
END$$

DROP TRIGGER IF EXISTS percorsi_terapeutici_sedute_prenotate_before_update$$
CREATE TRIGGER percorsi_terapeutici_sedute_prenotate_before_update 
BEFORE UPDATE ON percorsi_terapeutici_sedute_prenotate 
FOR EACH ROW
BEGIN
	IF(NEW.stato_prenotazione <> OLD.stato_prenotazione) THEN
		UPDATE percorsi_terapeutici_sedute 
		SET id_terapista = NEW.id_terapista, stato_seduta = NEW.stato_prenotazione, data_seduta = NEW.data
		WHERE id = NEW.id_seduta;
	END IF;
END$$

DROP TRIGGER IF EXISTS percorsi_terapeutici_sedute_prenotate_after_delete$$
CREATE TRIGGER percorsi_terapeutici_sedute_prenotate_after_delete 
AFTER DELETE ON percorsi_terapeutici_sedute_prenotate 
FOR EACH ROW
BEGIN
    SELECT stato_prenotazione, id_terapista, data
    INTO @stato, @id_terapista, @data_seduta
    FROM percorsi_terapeutici_sedute_prenotate
    WHERE id_seduta = OLD.id_seduta 
    ORDER BY FIELD(stato_prenotazione, 'Conclusa', 'Prenotata', 'Assente') 
    LIMIT 1;

    UPDATE percorsi_terapeutici_sedute 
        SET id_terapista = IFNULL(@id_terapista, NULL), stato_seduta = IFNULL(@stato, 'Pendente'), data_seduta = IFNULL(@data_seduta, NULL)
    WHERE id = OLD.id_seduta;
END$$

DELIMITER ;