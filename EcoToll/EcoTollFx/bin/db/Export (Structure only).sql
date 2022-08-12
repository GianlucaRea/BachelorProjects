-- MySQL dump 10.13  Distrib 8.0.16, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ecotolldatabase
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `amministratore`
--

DROP TABLE IF EXISTS `amministratore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `amministratore` (
  `nome` varchar(31) DEFAULT NULL,
  `cognome` varchar(31) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autostrada`
--

DROP TABLE IF EXISTS `autostrada`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `autostrada` (
  `nome` varchar(31) NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `casello`
--

DROP TABLE IF EXISTS `casello`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `casello` (
  `nome` varchar(31) NOT NULL,
  `kilometro` int(11) NOT NULL,
  `nomeAutostrada` varchar(31) DEFAULT NULL,
  PRIMARY KEY (`nome`),
  KEY `nomeAutostrada` (`nomeAutostrada`),
  CONSTRAINT `casello_ibfk_1` FOREIGN KEY (`nomeAutostrada`) REFERENCES `autostrada` (`nome`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `percorso`
--

DROP TABLE IF EXISTS `percorso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `percorso` (
  `codicePercorso` varchar(31) NOT NULL,
  `nomeAutostrada` varchar(31) DEFAULT NULL,
  `caselloPartenza` varchar(31) DEFAULT NULL,
  `caselloArrivo` varchar(31) DEFAULT NULL,
  PRIMARY KEY (`codicePercorso`),
  KEY `nomeAutostrada` (`nomeAutostrada`),
  KEY `caselloPartenza` (`caselloPartenza`),
  KEY `caselloArrivo` (`caselloArrivo`),
  CONSTRAINT `percorso_ibfk_1` FOREIGN KEY (`nomeAutostrada`) REFERENCES `autostrada` (`nome`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `percorso_ibfk_2` FOREIGN KEY (`caselloPartenza`) REFERENCES `casello` (`nome`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `percorso_ibfk_3` FOREIGN KEY (`caselloArrivo`) REFERENCES `casello` (`nome`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tariffa`
--

DROP TABLE IF EXISTS `tariffa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `tariffa` (
  `classeVeicolo` int(11) NOT NULL,
  `valore` int(11) NOT NULL,
  `nomeAutostrada` varchar(31) DEFAULT NULL,
  KEY `nomeAutostrada` (`nomeAutostrada`),
  CONSTRAINT `tariffa_ibfk_1` FOREIGN KEY (`nomeAutostrada`) REFERENCES `autostrada` (`nome`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `veicolo`
--

DROP TABLE IF EXISTS `veicolo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `veicolo` (
  `targa` varchar(31) NOT NULL,
  `modello` varchar(31) NOT NULL,
  `marca` varchar(31) NOT NULL,
  `peso` int(11) NOT NULL,
  `n°assi` int(11) NOT NULL,
  `classeEuro` int(11) DEFAULT NULL,
  `anno` date NOT NULL,
  `altezza` double NOT NULL,
  PRIMARY KEY (`targa`),
  CONSTRAINT `assiOk` CHECK ((`n°assi` <> 1))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping events for database 'ecotolldatabase'
--

--
-- Dumping routines for database 'ecotolldatabase'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-29 14:57:43
