
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `clienti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clienti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nominativo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `indirizzo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cap` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `citta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cf` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cellulare` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `portato_da` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_inserimento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notizie_cliniche` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `clienti` WRITE;
/*!40000 ALTER TABLE `clienti` DISABLE KEYS */;
INSERT INTO `clienti` VALUES (68,'testb','trovatore','80126','test','teataeta','3758298897','adfafda','teodublin@gmail.com','adfadf','2024-12-27 23:00:00','aaffdadfafdadfadfadfadfadf'),(69,'xxxxxx','trovatore','80126','teatafda','adfafd','3758298897','adfadf','teodublin@gmail.com','adfafd','2024-12-27 23:00:00','adfafdafd'),(71,'Joseph test','trovatore','80126','Napoli','98916519835','3758298897','946598463168','teodublin@gmail.com','test','2024-12-27 23:00:00','adfadfadf asdfadfadf'),(72,'ciro massimo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2025-01-01 23:00:00',NULL);
/*!40000 ALTER TABLE `clienti` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `corsi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `corsi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('Mensile') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_categoria` int NOT NULL,
  `corso` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `prezzo` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `corsi` WRITE;
/*!40000 ALTER TABLE `corsi` DISABLE KEYS */;
INSERT INTO `corsi` VALUES (6,'Mensile',1,'test',300.00);
/*!40000 ALTER TABLE `corsi` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `corsi_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `corsi_categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `corsi_categorie` WRITE;
/*!40000 ALTER TABLE `corsi_categorie` DISABLE KEYS */;
INSERT INTO `corsi_categorie` VALUES (1,'Palestra');
/*!40000 ALTER TABLE `corsi_categorie` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `corsi_classi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `corsi_classi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_corso` int NOT NULL,
  `classe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `note` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_corso` (`id_corso`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `corsi_classi` WRITE;
/*!40000 ALTER TABLE `corsi_classi` DISABLE KEYS */;
INSERT INTO `corsi_classi` VALUES (5,1,'Ginnastica','test','2024-12-31 11:33:05');
/*!40000 ALTER TABLE `corsi_classi` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `fatture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fatture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `link` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `importo` int NOT NULL,
  `index` int NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stato` enum('Pendente','Saldata') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pendente',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `fatture` WRITE;
/*!40000 ALTER TABLE `fatture` DISABLE KEYS */;
INSERT INTO `fatture` VALUES (91,72,'ciro_massimo_2025-01-12_16:36:42.pdf',60,415,'2025-01-12','Saldata','2025-01-12 16:36:42'),(93,72,'ciro_massimo_2025-01-12_17:28:12.pdf',60,416,'2025-01-12','Saldata','2025-01-12 17:28:12');
/*!40000 ALTER TABLE `fatture` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `motivi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `motivi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `motivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `motivi` WRITE;
/*!40000 ALTER TABLE `motivi` DISABLE KEYS */;
INSERT INTO `motivi` VALUES (2,'Pranzo'),(3,'Corso'),(4,'Malatia'),(8,'ferie');
/*!40000 ALTER TABLE `motivi` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `percorsi_pagamenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `percorsi_pagamenti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_percorso` int NOT NULL,
  `id_cliente` int NOT NULL,
  `prezzo_tabellare` int NOT NULL,
  `prezzo` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_percorso` (`id_percorso`),
  CONSTRAINT `id_percorso` FOREIGN KEY (`id_percorso`) REFERENCES `percorsi_terapeutici` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `percorsi_pagamenti` WRITE;
/*!40000 ALTER TABLE `percorsi_pagamenti` DISABLE KEYS */;
INSERT INTO `percorsi_pagamenti` VALUES (40,118,72,420,420);
/*!40000 ALTER TABLE `percorsi_pagamenti` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `percorsi_pagamenti_fatture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `percorsi_pagamenti_fatture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_percorso` int NOT NULL,
  `id_cliente` int NOT NULL,
  `id_fattura` int NOT NULL,
  `importo` double(10,2) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_percorso` (`id_percorso`),
  KEY `id_fattura` (`id_fattura`),
  CONSTRAINT `id_fatture` FOREIGN KEY (`id_fattura`) REFERENCES `fatture` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `percorsi_pagamenti_fatture` WRITE;
/*!40000 ALTER TABLE `percorsi_pagamenti_fatture` DISABLE KEYS */;
INSERT INTO `percorsi_pagamenti_fatture` VALUES (86,118,72,91,60.00,'2025-01-12 16:36:42'),(88,118,72,93,60.00,'2025-01-12 17:28:12');
/*!40000 ALTER TABLE `percorsi_pagamenti_fatture` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `percorsi_pagamenti_senza_fattura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `percorsi_pagamenti_senza_fattura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `id_percorso` int NOT NULL,
  `valore` double(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `percorsi_pagamenti_senza_fattura` WRITE;
/*!40000 ALTER TABLE `percorsi_pagamenti_senza_fattura` DISABLE KEYS */;
INSERT INTO `percorsi_pagamenti_senza_fattura` VALUES (7,72,118,300.00);
/*!40000 ALTER TABLE `percorsi_pagamenti_senza_fattura` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `percorsi_terapeutici`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `percorsi_terapeutici` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `id_trattamento` int DEFAULT NULL,
  `sedute` int DEFAULT NULL,
  `prezzo_tabellare` double(10,2) NOT NULL,
  `prezzo` double(10,2) NOT NULL,
  `note` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_trattamento` (`id_trattamento`),
  CONSTRAINT `id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clienti` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `percorsi_terapeutici` WRITE;
/*!40000 ALTER TABLE `percorsi_terapeutici` DISABLE KEYS */;
INSERT INTO `percorsi_terapeutici` VALUES (118,72,56,3,420.00,420.00,NULL,'2025-01-12 11:34:34');
/*!40000 ALTER TABLE `percorsi_terapeutici` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `percorsi_terapeutici_sedute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `percorsi_terapeutici_sedute` (
  `id` int NOT NULL AUTO_INCREMENT,
  `index` int DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  `id_percorso` int DEFAULT NULL,
  `id_trattamento` int DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_ciclo` (`id_percorso`),
  KEY `id_trattamento` (`id_trattamento`),
  CONSTRAINT `cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clienti` (`id`) ON DELETE CASCADE,
  CONSTRAINT `percorsi` FOREIGN KEY (`id_percorso`) REFERENCES `percorsi_terapeutici` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `percorsi_terapeutici_sedute` WRITE;
/*!40000 ALTER TABLE `percorsi_terapeutici_sedute` DISABLE KEYS */;
INSERT INTO `percorsi_terapeutici_sedute` VALUES (349,1,72,118,56,'2025-01-12 11:34:34'),(350,2,72,118,56,'2025-01-12 11:34:34'),(351,3,72,118,56,'2025-01-12 11:34:34');
/*!40000 ALTER TABLE `percorsi_terapeutici_sedute` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `percorsi_terapeutici_sedute_prenotate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `percorsi_terapeutici_sedute_prenotate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `row_inizio` int NOT NULL,
  `row_fine` int NOT NULL,
  `id_terapista` int NOT NULL,
  `id_seduta` int NOT NULL,
  `id_percorso` int NOT NULL,
  `data` date NOT NULL,
  `id_cliente` int NOT NULL,
  `stato_prenotazione` enum('Assente','Spostata','Conclusa','Prenotata') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Prenotata',
  PRIMARY KEY (`id`),
  KEY `id_sedute` (`id_seduta`),
  KEY `id_terapista` (`id_terapista`),
  KEY `row_inizio` (`row_inizio`),
  KEY `row_fine` (`row_fine`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_percorso` (`id_percorso`),
  CONSTRAINT `id_sedute` FOREIGN KEY (`id_seduta`) REFERENCES `percorsi_terapeutici_sedute` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `percorsi_terapeutici_sedute_prenotate` WRITE;
/*!40000 ALTER TABLE `percorsi_terapeutici_sedute_prenotate` DISABLE KEYS */;
/*!40000 ALTER TABLE `percorsi_terapeutici_sedute_prenotate` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `planning`;
/*!50001 DROP VIEW IF EXISTS `planning`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `planning` AS SELECT 
 1 AS `origin`,
 1 AS `id`,
 1 AS `row_inizio`,
 1 AS `row_fine`,
 1 AS `id_terapista`,
 1 AS `data`,
 1 AS `motivo`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `planning_motivi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `planning_motivi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `row_inizio` int NOT NULL,
  `row_fine` int NOT NULL,
  `id_terapista` int NOT NULL,
  `data` date NOT NULL,
  `id_motivo` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_motivo` (`id_motivo`),
  KEY `row_inizio` (`row_inizio`),
  KEY `row_fine` (`row_fine`),
  KEY `id_terapista` (`id_terapista`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `planning_motivi` WRITE;
/*!40000 ALTER TABLE `planning_motivi` DISABLE KEYS */;
INSERT INTO `planning_motivi` VALUES (41,1,3,11,'2024-12-28',1),(43,25,29,11,'2024-12-30',4),(44,12,15,11,'2024-12-30',3),(46,19,19,11,'2024-12-29',2),(47,13,17,11,'2025-01-02',3),(48,21,29,12,'2025-01-03',2);
/*!40000 ALTER TABLE `planning_motivi` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `planning_row`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `planning_row` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ora` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `planning_row` WRITE;
/*!40000 ALTER TABLE `planning_row` DISABLE KEYS */;
INSERT INTO `planning_row` VALUES (1,'07:00:00'),(2,'07:15:00'),(3,'07:30:00'),(4,'07:45:00'),(5,'08:00:00'),(6,'08:15:00'),(7,'08:30:00'),(8,'08:45:00'),(9,'09:00:00'),(10,'09:15:00'),(11,'09:30:00'),(12,'09:45:00'),(13,'10:00:00'),(14,'10:15:00'),(15,'10:30:00'),(16,'10:45:00'),(17,'11:00:00'),(18,'11:15:00'),(19,'11:30:00'),(20,'11:45:00'),(21,'12:00:00'),(22,'12:15:00'),(23,'12:30:00'),(24,'12:45:00'),(25,'13:00:00'),(26,'13:15:00'),(27,'13:30:00'),(28,'13:45:00'),(29,'14:00:00'),(30,'14:15:00'),(31,'14:30:00'),(32,'14:45:00'),(33,'15:00:00'),(34,'15:15:00'),(35,'15:30:00'),(36,'15:45:00'),(37,'16:00:00'),(38,'16:15:00'),(39,'16:30:00'),(40,'16:45:00'),(41,'17:00:00'),(42,'17:15:00'),(43,'17:30:00'),(44,'17:45:00'),(45,'18:00:00'),(46,'18:15:00'),(47,'18:30:00'),(48,'18:45:00'),(49,'19:00:00'),(50,'19:15:00'),(51,'19:30:00');
/*!40000 ALTER TABLE `planning_row` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `setup` longtext COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `setup` WRITE;
/*!40000 ALTER TABLE `setup` DISABLE KEYS */;
INSERT INTO `setup` VALUES (1,'fatture','{\"first_index\":415}');
/*!40000 ALTER TABLE `setup` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `terapisti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terapisti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `terapista` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `terapisti` WRITE;
/*!40000 ALTER TABLE `terapisti` DISABLE KEYS */;
INSERT INTO `terapisti` VALUES (11,'Daniela Zanotti'),(12,'Giancarlo Di Bonito'),(13,'Claudia Mancusi'),(14,'Enrica Marinucci');
/*!40000 ALTER TABLE `terapisti` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `trattamenti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trattamenti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('Per Seduta') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_categoria` int NOT NULL,
  `trattamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prezzo` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `trattamenti` WRITE;
/*!40000 ALTER TABLE `trattamenti` DISABLE KEYS */;
INSERT INTO `trattamenti` VALUES (37,'Per Seduta',0,'Magneto domiciliare',120.00),(38,'Per Seduta',0,'Magneto ambulatoriale',10.00),(39,'Per Seduta',0,'Ultrasuoni',10.00),(40,'Per Seduta',0,'Tens',10.00),(41,'Per Seduta',0,'Ionoforesi',10.00),(42,'Per Seduta',0,'Elettrostimolazione',10.00),(43,'Per Seduta',0,'Laser',30.00),(44,'Per Seduta',0,'Tecar',30.00),(45,'Per Seduta',0,'Onde durto',50.00),(46,'Per Seduta',0,'Radiofrequenza',40.00),(47,'Per Seduta',0,'Fisio-TT',35.00),(48,'Per Seduta',0,'Rieducazione motoria',40.00),(49,'Per Seduta',0,'Esercizi propriocettivi',40.00),(50,'Per Seduta',0,'Rieducazione al passo',40.00),(51,'Per Seduta',0,'Mezieres',50.00),(53,'Per Seduta',0,'Trattamento S.E.A.S.',40.00),(56,'Per Seduta',0,'Isico',140.00);
/*!40000 ALTER TABLE `trattamenti` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `trattamenti_categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trattamenti_categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `trattamenti_categorie` WRITE;
/*!40000 ALTER TABLE `trattamenti_categorie` DISABLE KEYS */;
INSERT INTO `trattamenti_categorie` VALUES (2,'test 2');
/*!40000 ALTER TABLE `trattamenti_categorie` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `view_corsi`;
/*!50001 DROP VIEW IF EXISTS `view_corsi`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_corsi` AS SELECT 
 1 AS `id`,
 1 AS `tipo`,
 1 AS `id_categoria`,
 1 AS `corso`,
 1 AS `prezzo`,
 1 AS `categoria`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `view_fatture`;
/*!50001 DROP VIEW IF EXISTS `view_fatture`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_fatture` AS SELECT 
 1 AS `id`,
 1 AS `id_cliente`,
 1 AS `link`,
 1 AS `importo`,
 1 AS `index`,
 1 AS `data`,
 1 AS `stato`,
 1 AS `timestamp`,
 1 AS `nominativo`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `view_percorsi`;
/*!50001 DROP VIEW IF EXISTS `view_percorsi`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_percorsi` AS SELECT 
 1 AS `id`,
 1 AS `id_cliente`,
 1 AS `id_trattamento`,
 1 AS `sedute`,
 1 AS `prezzo_tabellare`,
 1 AS `prezzo`,
 1 AS `note`,
 1 AS `timestamp`,
 1 AS `trattamento`,
 1 AS `tipo`,
 1 AS `stato`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `view_percorsi_pagamenti`;
/*!50001 DROP VIEW IF EXISTS `view_percorsi_pagamenti`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_percorsi_pagamenti` AS SELECT 
 1 AS `id_percorso`,
 1 AS `id_cliente`,
 1 AS `trattamento`,
 1 AS `prezzo_tabellare`,
 1 AS `prezzo`,
 1 AS `saldato`,
 1 AS `fatturato`,
 1 AS `non_fatturato`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `view_sedute`;
/*!50001 DROP VIEW IF EXISTS `view_sedute`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_sedute` AS SELECT 
 1 AS `id`,
 1 AS `index`,
 1 AS `id_cliente`,
 1 AS `id_percorso`,
 1 AS `id_trattamento`,
 1 AS `stato`*/;
SET character_set_client = @saved_cs_client;
DROP TABLE IF EXISTS `view_trattamenti`;
/*!50001 DROP VIEW IF EXISTS `view_trattamenti`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_trattamenti` AS SELECT 
 1 AS `id`,
 1 AS `tipo`,
 1 AS `id_categoria`,
 1 AS `trattamento`,
 1 AS `prezzo`,
 1 AS `categoria`*/;
SET character_set_client = @saved_cs_client;
/*!50001 DROP VIEW IF EXISTS `planning`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`medplus`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `planning` AS select 'sbarra' AS `origin`,`pm`.`id` AS `id`,`pm`.`row_inizio` AS `row_inizio`,`pm`.`row_fine` AS `row_fine`,`pm`.`id_terapista` AS `id_terapista`,`pm`.`data` AS `data`,left(`m`.`motivo`,40) AS `motivo` from (`planning_motivi` `pm` left join `motivi` `m` on((`pm`.`id_motivo` = `m`.`id`))) union select 'seduta' AS `origin`,`sp`.`id` AS `id`,`sp`.`row_inizio` AS `row_inizio`,`sp`.`row_fine` AS `row_fine`,`sp`.`id_terapista` AS `id_terapista`,`sp`.`data` AS `data`,concat(left(`c`.`nominativo`,20),'>',left(`t`.`trattamento`,20)) AS `motivo` from (((`percorsi_terapeutici_sedute_prenotate` `sp` left join `clienti` `c` on((`sp`.`id_cliente` = `c`.`id`))) left join `percorsi_terapeutici_sedute` `s` on((`sp`.`id_seduta` = `s`.`id`))) left join `trattamenti` `t` on((`s`.`id_trattamento` = `t`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_corsi`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`medplus`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_corsi` AS select `c`.`id` AS `id`,`c`.`tipo` AS `tipo`,`c`.`id_categoria` AS `id_categoria`,`c`.`corso` AS `corso`,`c`.`prezzo` AS `prezzo`,`cc`.`categoria` AS `categoria` from (`corsi` `c` left join `corsi_categorie` `cc` on((`c`.`id_categoria` = `cc`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_fatture`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`medplus`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_fatture` AS select `f`.`id` AS `id`,`f`.`id_cliente` AS `id_cliente`,`f`.`link` AS `link`,`f`.`importo` AS `importo`,`f`.`index` AS `index`,`f`.`data` AS `data`,`f`.`stato` AS `stato`,`f`.`timestamp` AS `timestamp`,`c`.`nominativo` AS `nominativo` from (`fatture` `f` left join `clienti` `c` on((`f`.`id_cliente` = `c`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_percorsi`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`medplus`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_percorsi` AS select `pt`.`id` AS `id`,`pt`.`id_cliente` AS `id_cliente`,`pt`.`id_trattamento` AS `id_trattamento`,`pt`.`sedute` AS `sedute`,`pt`.`prezzo_tabellare` AS `prezzo_tabellare`,`pt`.`prezzo` AS `prezzo`,`pt`.`note` AS `note`,`pt`.`timestamp` AS `timestamp`,`t`.`trattamento` AS `trattamento`,`t`.`tipo` AS `tipo`,if((`pt`.`sedute` <= ifnull(`p`.`sp_count`,0)),'Concluso','Attivo') AS `stato` from ((`percorsi_terapeutici` `pt` left join `trattamenti` `t` on((`pt`.`id_trattamento` = `t`.`id`))) left join (select `percorsi_terapeutici_sedute_prenotate`.`id_percorso` AS `id_percorso`,count(`percorsi_terapeutici_sedute_prenotate`.`id`) AS `sp_count` from `percorsi_terapeutici_sedute_prenotate` where (`percorsi_terapeutici_sedute_prenotate`.`stato_prenotazione` = 'Conclusa') group by `percorsi_terapeutici_sedute_prenotate`.`id_percorso`) `p` on((`pt`.`id` = `p`.`id_percorso`))) order by `pt`.`timestamp` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_percorsi_pagamenti`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`medplus`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_percorsi_pagamenti` AS select `pp`.`id_percorso` AS `id_percorso`,`pp`.`id_cliente` AS `id_cliente`,`t`.`trattamento` AS `trattamento`,`pp`.`prezzo_tabellare` AS `prezzo_tabellare`,`pp`.`prezzo` AS `prezzo`,(coalesce(`sf`.`saldato_fatture`,0) + coalesce(`ssf`.`totale_valore`,0)) AS `saldato`,coalesce(`sf`.`pendente_fatture`,0) AS `fatturato`,(`pp`.`prezzo` - ((coalesce(`ssf`.`totale_valore`,0) + coalesce(`sf`.`saldato_fatture`,0)) + coalesce(`sf`.`pendente_fatture`,0))) AS `non_fatturato` from ((((`percorsi_pagamenti` `pp` left join (select `percorsi_pagamenti_senza_fattura`.`id_percorso` AS `id_percorso`,coalesce(sum(`percorsi_pagamenti_senza_fattura`.`valore`),0) AS `totale_valore` from `percorsi_pagamenti_senza_fattura` group by `percorsi_pagamenti_senza_fattura`.`id_percorso`) `ssf` on((`pp`.`id_percorso` = `ssf`.`id_percorso`))) left join (select `ppf`.`id_percorso` AS `id_percorso`,sum((case when (`f`.`stato` = 'Saldata') then `f`.`importo` else 0 end)) AS `saldato_fatture`,sum((case when (`f`.`stato` = 'Pendente') then `f`.`importo` else 0 end)) AS `pendente_fatture` from (`percorsi_pagamenti_fatture` `ppf` left join `fatture` `f` on((`ppf`.`id_fattura` = `f`.`id`))) group by `ppf`.`id_percorso`) `sf` on((`pp`.`id_percorso` = `sf`.`id_percorso`))) left join `percorsi_terapeutici` `pt` on((`pp`.`id_percorso` = `pt`.`id`))) left join `trattamenti` `t` on((`pt`.`id_trattamento` = `t`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_sedute`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`medplus`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_sedute` AS select `pts`.`id` AS `id`,`pts`.`index` AS `index`,`pts`.`id_cliente` AS `id_cliente`,`pts`.`id_percorso` AS `id_percorso`,`pts`.`id_trattamento` AS `id_trattamento`,if((`ptsp_Conclusa`.`id` is not null),'Conclusa',if((`ptsp_Spostata`.`id` is not null),'Spostata',if((`ptsp_Assente`.`id` is not null),'Assente',if((`ptsp_Prenotata`.`id` is not null),'Prenotata','Da Prenotare')))) AS `stato` from ((((`percorsi_terapeutici_sedute` `pts` left join `percorsi_terapeutici_sedute_prenotate` `ptsp_Assente` on(((`ptsp_Assente`.`id_seduta` = `pts`.`id`) and (`ptsp_Assente`.`stato_prenotazione` = 'Assente')))) left join `percorsi_terapeutici_sedute_prenotate` `ptsp_Spostata` on(((`ptsp_Spostata`.`id_seduta` = `pts`.`id`) and (`ptsp_Spostata`.`stato_prenotazione` = 'Spostata')))) left join `percorsi_terapeutici_sedute_prenotate` `ptsp_Conclusa` on(((`ptsp_Conclusa`.`id_seduta` = `pts`.`id`) and (`ptsp_Conclusa`.`stato_prenotazione` = 'Conclusa')))) left join `percorsi_terapeutici_sedute_prenotate` `ptsp_Prenotata` on(((`ptsp_Prenotata`.`id_seduta` = `pts`.`id`) and (`ptsp_Prenotata`.`stato_prenotazione` = 'Prenotata')))) group by `pts`.`id`,`pts`.`index`,`pts`.`id_cliente`,`pts`.`id_percorso`,`pts`.`id_trattamento`,if((`ptsp_Conclusa`.`id` is not null),'Conclusa',if((`ptsp_Spostata`.`id` is not null),'Spostata',if((`ptsp_Assente`.`id` is not null),'Assente',if((`ptsp_Prenotata`.`id` is not null),'Prenotata','Da Prenotare')))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!50001 DROP VIEW IF EXISTS `view_trattamenti`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`medplus`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_trattamenti` AS select `t`.`id` AS `id`,`t`.`tipo` AS `tipo`,`t`.`id_categoria` AS `id_categoria`,`t`.`trattamento` AS `trattamento`,`t`.`prezzo` AS `prezzo`,`tc`.`categoria` AS `categoria` from (`trattamenti` `t` left join `trattamenti_categorie` `tc` on((`t`.`id_categoria` = `tc`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

