DROP TABLE IF EXISTS corsi;

CREATE TABLE `corsi` (
  `id` int NOT NULL,
  `id_categoria` int NOT NULL,
  `id_terapista` int NOT NULL,
  `corso` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prezzo` double(10,2) NOT NULL,
  `scadenza` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `corsi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_terapista` (`id_terapista`);

ALTER TABLE `corsi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


DROP TABLE IF EXISTS corsi_classi;

CREATE TABLE `corsi_classi` (
  `id` int NOT NULL,
  `id_corso` int NOT NULL,
  `id_cliente` int NOT NULL,
  `prezzo` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `corsi_classi` ADD PRIMARY KEY (`id`), ADD KEY `id_corso` (`id_corso`), ADD KEY `id_cliente` (`id_cliente`);

ALTER TABLE `corsi_classi` MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `corsi_classi` ADD CONSTRAINT `cc_id_corso` FOREIGN KEY (`id_corso`) REFERENCES `corsi`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION; ALTER TABLE `corsi_classi` ADD CONSTRAINT `cc_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clienti`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;


DROP VIEW IF EXISTS view_corsi;
CREATE VIEW view_corsi AS
select `c`.`id` AS `id`,`c`.`id_categoria` AS `id_categoria`,`c`.`id_terapista` AS `id_terapista`,`t`.`terapista` AS `terapista`,`c`.`corso` AS `corso`,`c`.`prezzo` AS `prezzo`,`c`.`scadenza` AS `scadenza`,`cc`.`categoria` AS `categoria` from (`medplus`.`corsi` `c` left join `medplus`.`corsi_categorie` `cc` on((`c`.`id_categoria` = `cc`.`id`))
left join `medplus`.`terapisti` `t` on((`c`.`id_terapista` = `t`.`id`)));

DROP VIEW IF EXISTS view_classi;
CREATE VIEW view_classi AS
select `cc`.`id` AS `id`,`cc`.`id_corso` AS `id_corso`,`cc`.`id_cliente` AS `id_cliente`,`c`.`id_categoria` AS `id_categoria`,`c`.`id_terapista` AS `id_terapista`,`c`.`corso` AS `corso`,`c`.`prezzo` AS `prezzo_tabellare`,cc.prezzo as prezzo,`c`.`scadenza` AS `scadenza`,`t`.`terapista` AS `terapista`,`ct`.`nominativo` AS `nominativo` from (((`medplus`.`corsi_classi` `cc` left join `medplus`.`corsi` `c` on((`cc`.`id_corso` = `c`.`id`))) left join `medplus`.`clienti` `ct` on((`cc`.`id_cliente` = `ct`.`id`))) left join `medplus`.`terapisti` `t` on((`c`.`id_terapista` = `t`.`id`)))