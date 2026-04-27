-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ahoy
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `title` varchar(50) DEFAULT 'Employee',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Gabriella Bonaretti','gabribonaretti@gmail.com','$2y$10$KIcFPSw8AZCmR3fCaiOr0.QTmN4rHfO/rsECS1JL6UnYztui/K/WC','justgabri','Employee'),(5,'Gabri van Vuuren','goobies@gmail.com','$2y$10$oPcP/zoD5iLTzUKBFGnaiOMROp2F6OBBf2XYcUIDVqVpY8iXvfRMe','goobies','Employee'),(7,'Test User','1234@outlook.com','$2y$10$Vev98CxN8EHqxwsBghr.huNFmRj7I1v4xs8V.KovyG1AfP4Ol5Eoy',NULL,'Employee'),(8,'TJ Miller','miller@yahoo.com','$2y$10$tp464b0RbGFl8yJFHXQFrO9X2bBmL1wUJg/DUFTP.nFdZJ3s/9JzC',NULL,'Employee'),(9,'ghgh','asdf@asdf','$2y$10$nSFuB/Z9kIxY3E0fyId5qetgRji6OVEFTRnMHJlTqaW57ummuKmha',NULL,'Employee'),(10,'Jane Doe','janedoe@gmail.com','$2y$10$iFGP9J3mkAtfMqQ4wtYzU.m4to4ZcKrtN9VsbKeTzJMx/E5Rs1046',NULL,'Employee'),(11,'Jim Carrey','jimjim@yahoo.com','$2y$10$fzc5N1WyIdqHzKp7VmkfJeqGLUWKiYnrxoQBU57OVntBWPBB9s/Aa',NULL,'Employee');
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

-- Dump completed on 2026-04-27 20:48:24
