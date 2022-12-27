-- MySQL dump 10.13  Distrib 8.0.31, for macos12.6 (x86_64)
--
-- Host: 127.0.0.1    Database: sign_up
-- ------------------------------------------------------
-- Server version	8.0.31

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

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stocks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `stock_symbol` varchar(255) DEFAULT NULL,
  `stock_amount` int DEFAULT NULL,
  `order_price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (45,43,'AAPL',16,132.23),(55,41,'GME',-25,132.23),(84,42,'GME',20,NULL),(89,41,'AAPL',0,NULL),(90,43,'GME',8,NULL),(91,41,'AEHR',5,NULL),(92,41,'TSLA',14,NULL),(93,42,'AEHR',5,NULL);
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `stock_symbol` varchar(255) DEFAULT NULL,
  `stock_amount` int DEFAULT NULL,
  `action_type` varchar(255) DEFAULT NULL,
  `action_date` int DEFAULT NULL,
  `stock_price` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_pk` (`id`),
  KEY `transactions_users_null_fk` (`user_id`),
  CONSTRAINT `transactions_users_null_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,41,'AAPL',2,'BUY',1670988884,145),(2,41,'AAPL',2,'BUY',1670989005,145.47),(3,41,'AAPL',13,'SELL',1670989423,145.47),(4,41,'AAPL',8,'SELL',1670989502,145.47),(5,41,'AAPL',2,'BUY',1670991240,145.47),(6,41,'AAPL',4,'SELL',1670993021,145.47),(7,41,'AAPL',1,'BUY',1670993156,145.47),(8,41,'AAPL',3,'BUY',1670993205,145.47),(9,41,'AAPL',4,'BUY',1670993221,145.47),(10,41,'AAPL',2,'BUY',1670993236,145.47),(11,41,'AAPL',2,'SELL',1671000713,145.47),(12,41,'AAPL',5,'BUY',1671000850,145.47),(13,41,'GME',4,'BUY',1671001112,21),(14,41,'BBBY',9,'BUY',1671001142,2.95),(15,41,'AEHR',7,'BUY',1671001166,23.99),(16,41,'AAPL',4,'BUY',1671001256,145.47),(17,41,'AEHR',5,'BUY',1671001285,23.99),(18,41,'AEHR',6,'BUY',1671001313,23.99),(19,41,'AAPL',11,'BUY',1671034507,145.72),(20,41,'AAPL',11,'BUY',1671034517,145.72),(21,41,'AAPL',12,'BUY',1671034544,145.683),(22,41,'AAPL',29,'SELL',1671034569,145.683),(23,41,'AEHR',8,'SELL',1671034683,23.14),(24,41,'AAPL',5,'BUY',1671096488,143.21),(25,41,'AAPL',3,'BUY',1671097031,143.21),(32,41,'AAPL',3,'BUY',1671540280,132.37),(33,41,'AAPL',5,'BUY',1671540304,132.37),(34,41,'AAPL',12,'SELL',1671540936,132.37),(35,41,'AAPL',24,'SELL',1671541198,132.37),(36,41,'AAPL',38,'SELL',1671542311,132.37),(37,41,'AAPL',13,'BUY',1671542368,132.37),(38,41,'AAPL',13,'BUY',1671542532,132.37),(39,41,'AAPL',-36,'SELL',1671542556,132.37),(40,41,'AAPL',-36,'SELL',1671542596,132.37),(41,41,'AAPL',3,'BUY',1671543288,132.37),(42,41,'AAPL',-4,'SELL',1671543307,132.37),(43,41,'AAPL',12,'BUY',1671567772,131.68),(44,41,'AAPL',-16,'SELL',1671567815,131.73),(45,41,'gme',9,'BUY',1671568828,19.92),(46,41,'AAPL',-3,'SELL',1671612141,132.3),(47,41,'AAPL',-3,'SELL',1671612159,132.3),(48,41,'gme',-2,'SELL',1671612174,20.26),(49,41,'AAPL',1,'BUY',1671615118,132.3),(50,41,'AAPL',3,'BUY',1671615137,132.3),(51,41,'AAPL',1,'BUY',1671615831,132.3),(52,41,'AAPL',1,'BUY',1671615845,132.3),(53,41,'AAPL',2,'BUY',1671616473,132.3),(54,41,'AAPL',5,'BUY',1671616494,132.3),(55,41,'AAPL',-5,'SELL',1671616610,132.3),(56,41,'AAPL',2,'BUY',1671619255,132.3),(57,41,'AAPL',3,'BUY',1671619273,132.3),(58,41,'AAPL',-3,'SELL',1671619287,132.3),(59,41,'AAPL',3,'BUY',1671619519,132.3),(60,41,'AAPL',-3,'SELL',1671619535,132.3),(61,41,'gme',3,'BUY',1671619551,20.26),(62,41,'gme',-3,'SELL',1671619566,20.26),(63,41,'AAPL',3,'BUY',1671620293,132.3),(64,41,'AAPL',-3,'SELL',1671620322,132.3),(65,41,'AAPL',3,'BUY',1671631459,132.3),(66,41,'GME',-3,'SELL',1671631483,20.26),(67,42,'AAPL',3,'BUY',1671736087,130.95),(68,42,'AAPL',3,'BUY',1671736170,130.978),(69,43,'AAPL',3,'BUY',1671765142,132.23),(70,43,'AAPL',3,'BUY',1671765206,132.23),(71,41,'AAPL',3,'BUY',1671766983,132.23),(72,41,'AAPL',3,'BUY',1671767267,132.23),(73,41,'AAPL',3,'BUY',1671767372,132.23),(74,41,'GME',3,'BUY',1671774744,19.81),(75,41,'AAPL',2,'BUY',1671775548,132.23),(76,41,'AAPL',3,'BUY',1671776286,132.23),(77,41,'AAPL',3,'BUY',1671776317,132.23),(78,41,'AAPL',3,'BUY',1671776487,132.23),(79,41,'GME',-5,'SELL',1671776935,19.81),(80,41,'GME',-3,'SELL',1671776957,19.81),(81,41,'GME',10,'BUY',1671777007,19.81),(82,41,'GME',-7,'SELL',1671777043,19.81),(83,41,'GME',-10,'SELL',1671777083,19.81),(84,41,'AAPL',-3,'SELL',1671777366,132.23),(85,41,'AAPL',-4,'SELL',1671777389,132.23),(86,43,'AAPL',-26,'SELL',1671778892,132.23),(87,43,'GME',8,'BUY',1671778911,19.81),(88,41,'AEHR',10,'BUY',1671781826,20.86),(89,41,'TSLA',14,'BUY',1671781890,125.35),(90,41,'TSLA',300,'BUY',1671782609,125.35),(91,41,'TSLA',-300,'SELL',1671782648,125.35),(92,41,'TSLA',300,'BUY',1671782788,125.35),(93,41,'TSLA',-300,'SELL',1671782834,125.35),(94,41,'GME',-15,'SELL',1671783771,19.81),(95,41,'AAPL',-1,'SELL',1671785997,132.23),(96,41,'AAPL',-5,'SELL',1671786125,132.23),(97,41,'AAPL',10,'BUY',1671786251,132.23);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `wallet` float DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (41,'andor','and@gmail.com','$2y$10$2k.gkSokhtInLDO.s9DOhessk5FFdPOnL2fiABalqTm6/7DY9/GjS',18280),(42,'magnus','mgn@gmail.com','$2y$10$rwVdX.t3j9PPiwq2APg7OuYNwFuh4B11NOrg3sWCFOAayClTcw/UO',9216),(43,'Philip','phil@gmail.com','$2y$10$jvy0W77TgzRbv71OnvZcyO9La7zEeGptk.Q4YjLZ1GbXR03yM2tXC',12487);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-27 23:50:28
