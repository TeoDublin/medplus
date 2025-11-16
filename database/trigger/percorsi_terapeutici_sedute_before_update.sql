DELIMITER $$

DROP TRIGGER IF EXISTS percorsi_terapeutici_sedute_before_update$$

CREATE TRIGGER percorsi_terapeutici_sedute_before_update BEFORE UPDATE ON percorsi_terapeutici_sedute
FOR EACH ROW
BEGIN
	IF(NEW.stato_seduta <> OLD.stato_seduta AND OLD.stato_seduta = "Conclusa" ) THEN
	
		SET NEW.percentuale_terapista = 0;
		SET NEW.saldo_terapista = 0;
	
	ELSEIF NEW.id_terapista <> OLD.id_terapista OR NEW.prezzo <> OLD.prezzo OR ( NEW.stato_seduta <> OLD.stato_seduta AND NEW.stato_seduta = "Conclusa" ) THEN

		SELECT id_trattamento
		INTO @id_trattamento
		FROM percorsi_combo_trattamenti
		WHERE id_combo= NEW.id_combo
		LIMIT 1;
                
        IF(@id_trattamento=83) THEN
		    SELECT percentuale_isico_v 
		    INTO @percentuale_sedute 
		    FROM terapisti 
		    WHERE id = NEW.id_terapista 
		    LIMIT 1;
			
			SET @prezzo=ROUND(((NEW.prezzo * 60)/100),2);
			
		ELSEIF @id_trattamento=84 THEN
		    SELECT percentuale_isico_t 
		    INTO @percentuale_sedute 
		    FROM terapisti 
		    WHERE id = NEW.id_terapista 
		    LIMIT 1;
			
			SET @prezzo=ROUND(((NEW.prezzo * 60)/100),2);

		ELSEIF @id_trattamento=1 THEN
            SET @percentuale_sedute = 0;
            SET NEW.saldato_terapista = 0;
            SET NEW.saldo_terapista = 0;
            SET NEW.stato_saldato_terapista = 'Esente';
            SET NEW.data_saldato_terapista = NEW.data_seduta;

		ELSEIF @id_trattamento=2 THEN
            SET @percentuale_sedute = 0;
            SET NEW.saldato_terapista = 0;
            SET NEW.saldo_terapista = 0;
            SET NEW.stato_saldato_terapista = 'Esente';
            SET NEW.data_saldato_terapista = NEW.data_seduta;
	
		ELSE
		    SELECT percentuale_sedute 
		    INTO @percentuale_sedute 
		    FROM terapisti 
		    WHERE id = NEW.id_terapista 
		    LIMIT 1;
			
			SET @prezzo=NEW.prezzo;
			
        END IF;

		SET NEW.percentuale_terapista = @percentuale_sedute;
		SET NEW.saldo_terapista = ROUND(COALESCE(((@prezzo * @percentuale_sedute)/100),0),2);
		IF( OLD.saldato_terapista IS NULL ) THEN
			SET NEW.saldato_terapista = 0;
		END IF;
	END IF;
	
	IF(NEW.saldato <> OLD.saldato AND NEW.stato_pagamento <> 'Fatturato') THEN
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

	IF(NEW.prezzo = 0) THEN

		SET NEW.stato_pagamento = 'Esente';
		SET NEW.tipo_pagamento = 'Esente';

		IF (NEW.data_seduta IS NOT NULL) THEN
			SET NEW.data_pagamento = NEW.data_seduta;
		ELSEIF (OLD.data_seduta IS NOT NULL) THEN
			SET NEW.data_pagamento = OLD.data_seduta;
		END IF;
		
	END IF;
    
    IF(NEW.prezzo > 0 AND NEW.stato_pagamento = 'Esente') THEN
		SET NEW.stato_pagamento = 'Pendente';
		SET NEW.stato_saldato_terapista = 'Pendente';
		SET NEW.data_saldato_terapista = NULL;
	END IF;
END$$

DELIMITER ;