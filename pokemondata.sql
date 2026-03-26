-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: pokemon
-- ------------------------------------------------------
-- Server version	8.0.43

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
-- Table structure for table `pokemon`
--

DROP TABLE IF EXISTS `pokemon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pokemon` (
  `pokemon_id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `species` varchar(50) DEFAULT NULL,
  `type1` varchar(20) DEFAULT NULL,
  `type2` varchar(20) DEFAULT NULL,
  `ability1` varchar(50) DEFAULT NULL,
  `ability2` varchar(50) DEFAULT NULL,
  `hidden_ability` varchar(50) DEFAULT NULL,
  `hp` int DEFAULT NULL,
  `attack` int DEFAULT NULL,
  `defense` int DEFAULT NULL,
  `special_attack` int DEFAULT NULL,
  `special_defense` int DEFAULT NULL,
  `speed` int DEFAULT NULL,
  `height` decimal(4,1) DEFAULT NULL,
  `weight` decimal(5,1) DEFAULT NULL,
  `base_experience` int DEFAULT NULL,
  `generation` varchar(255) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `evolution_stage` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pokemon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pokemon`
--

LOCK TABLES `pokemon` WRITE;
/*!40000 ALTER TABLE `pokemon` DISABLE KEYS */;
INSERT INTO `pokemon` VALUES (1,'Bulbasaur','Seed Pokémon','Grass','Poison','Overgrow',NULL,'Chlorophyll',45,49,49,65,65,45,0.7,6.9,64,'I','Kanto','First'),(2,'Ivysaur','Seed Pokémon','Grass','Poison','Overgrow',NULL,'Chlorophyll',60,62,63,80,80,60,1.0,13.0,142,'I','Kanto','Second'),(3,'Venusaur','Seed Pokémon','Grass','Poison','Overgrow',NULL,'Chlorophyll',80,82,83,100,100,80,2.0,100.0,208,'I','Kanto','Third'),(4,'Charmander','Lizard Pokémon','Fire',NULL,'Blaze',NULL,'Solar Power',32,52,43,60,50,65,0.6,8.5,62,'I','Kanto','First'),(5,'Charmeleon','Lizard Pokémon','Fire',NULL,'Blaze',NULL,'Solar Power',58,64,58,80,65,80,1.1,19.0,142,'I','Kanto','Second'),(6,'Charizard','Flame Pokémon','Fire','Flying','Blaze',NULL,'Solar Power',78,84,78,109,85,100,1.7,90.5,209,'I','Kanto','Third'),(7,'Squirtle','Tiny Turtle Pokémon','Water',NULL,'Torrent',NULL,'Rain Dish',44,48,65,50,64,43,0.5,9.0,63,'I','Kanto','First'),(8,'Wartortle','Turtle Pokémon','Water',NULL,'Torrent',NULL,'Rain Dish',59,63,80,65,80,58,1.0,22.5,142,'I','Kanto','Second'),(9,'Blastoise','Shellfish Pokémon','Water',NULL,'Torrent',NULL,'Rain Dish',79,83,100,85,105,78,1.6,85.5,239,'I','Kanto','Third'),(10,'Caterpie','Worm Pokémon','Bug',NULL,'Shield Dust',NULL,'Run Away',45,30,35,20,20,45,0.3,2.9,39,'I','Kanto','First'),(11,'Metapod','Cocoon Pokémon','Bug',NULL,'Shed Skin',NULL,NULL,50,20,55,25,25,30,0.7,9.9,72,'I','Kanto','Second'),(12,'Butterfree','Butterfly Pokémon','Bug','Flying','Compound Eyes',NULL,'Tinted Lens',60,45,50,90,80,70,1.1,32.0,178,'I','Kanto','Third'),(13,'Weedle',' Hairy Bug Pokémon','Bug','Poison','Shield Dust',NULL,'Run Away',40,35,30,20,20,50,0.3,3.2,39,'I','Kanto','First'),(14,'Kakuna','Cocoon Pokémon','Bug','Poison','Shed Skin',NULL,NULL,45,25,50,25,25,35,0.6,10.0,72,'I','Kanto','Second'),(15,'Beedrill','Poison Bee Pokémon','Bug','Poison','Swarm',NULL,'Poison',65,90,40,45,80,75,1.0,29.5,178,'I','Kanto','Third'),(16,'Pidgey','Tiny Bird Pokémon','Normal','Flying','Keen Eye','Tangled Feet','Big Pecks',40,45,40,35,35,56,0.3,1.8,50,'I','Kanto','First'),(17,'Pidgeotto','Bird Pokémon','Normal','Flying','Keen Eye','Tangled Feet','Big Pecks',63,60,55,50,50,71,1.1,30.0,122,'I','Kanto','Second'),(18,'Pidgeot','Bird Pokémon','Normal','Flying','Keen Eye','Tangled Feet','Big Pecks',83,80,75,70,70,101,1.5,39.5,216,'I','Kanto','Third');
/*!40000 ALTER TABLE `pokemon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pokemon_evolutions`
--

DROP TABLE IF EXISTS `pokemon_evolutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pokemon_evolutions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `from_id` int NOT NULL,
  `to_id` int NOT NULL,
  `method` varchar(100) DEFAULT NULL,
  `requirement` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from_id` (`from_id`),
  KEY `to_id` (`to_id`),
  CONSTRAINT `pokemon_evolutions_ibfk_1` FOREIGN KEY (`from_id`) REFERENCES `pokemon` (`pokemon_id`),
  CONSTRAINT `pokemon_evolutions_ibfk_2` FOREIGN KEY (`to_id`) REFERENCES `pokemon` (`pokemon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pokemon_evolutions`
--

LOCK TABLES `pokemon_evolutions` WRITE;
/*!40000 ALTER TABLE `pokemon_evolutions` DISABLE KEYS */;
INSERT INTO `pokemon_evolutions` VALUES (1,1,2,'Level Up','Level 16'),(2,2,3,'Level Up','Level 32'),(3,4,5,'Level Up','Level 16'),(4,5,6,'Level Up','Level 36'),(5,7,8,'Level Up','Level 16'),(6,8,9,'Level Up','Level 36'),(7,10,11,'Level Up','Level 7'),(8,11,12,'Level Up','Level 10'),(9,13,14,'Level Up','Level 7'),(10,14,15,'Level Up','Level 10'),(11,16,17,'Level Up','Level 18'),(12,17,18,'Level Up','Level 36');
/*!40000 ALTER TABLE `pokemon_evolutions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-26 21:57:54
