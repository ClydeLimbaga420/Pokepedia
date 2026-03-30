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
INSERT INTO `pokemon` VALUES (1,'Bulbasaur','Seed Pokémon','Grass','Poison','Overgrow',NULL,'Chlorophyll',45,49,49,65,65,45,0.7,6.9,64,'I','Kanto','First'),(2,'Ivysaur','Seed Pokémon','Grass','Poison','Overgrow',NULL,'Chlorophyll',60,62,63,80,80,60,1.0,13.0,142,'I','Kanto','Second'),(3,'Venusaur','Seed Pokémon','Grass','Poison','Overgrow',NULL,'Chlorophyll',80,82,83,100,100,80,2.0,100.0,208,'I','Kanto','Third'),(4,'Charmander','Lizard Pokémon','Fire',NULL,'Blaze',NULL,'Solar Power',32,52,43,60,50,65,0.6,8.5,62,'I','Kanto','First'),(5,'Charmeleon','Lizard Pokémon','Fire',NULL,'Blaze',NULL,'Solar Power',58,64,58,80,65,80,1.1,19.0,142,'I','Kanto','Second'),(6,'Charizard','Flame Pokémon','Fire','Flying','Blaze',NULL,'Solar Power',78,84,78,109,85,100,1.7,90.5,209,'I','Kanto','Third'),(7,'Squirtle','Tiny Turtle Pokémon','Water',NULL,'Torrent',NULL,'Rain Dish',44,48,65,50,64,43,0.5,9.0,63,'I','Kanto','First'),(8,'Wartortle','Turtle Pokémon','Water',NULL,'Torrent',NULL,'Rain Dish',59,63,80,65,80,58,1.0,22.5,142,'I','Kanto','Second'),(9,'Blastoise','Shellfish Pokémon','Water',NULL,'Torrent',NULL,'Rain Dish',79,83,100,85,105,78,1.6,85.5,239,'I','Kanto','Third'),(10,'Caterpie','Worm Pokémon','Bug',NULL,'Shield Dust',NULL,'Run Away',45,30,35,20,20,45,0.3,2.9,39,'I','Kanto','First'),(11,'Metapod','Cocoon Pokémon','Bug',NULL,'Shed Skin',NULL,NULL,50,20,55,25,25,30,0.7,9.9,72,'I','Kanto','Second'),(12,'Butterfree','Butterfly Pokémon','Bug','Flying','Compound Eyes',NULL,'Tinted Lens',60,45,50,90,80,70,1.1,32.0,178,'I','Kanto','Third'),(13,'Weedle',' Hairy Bug Pokémon','Bug','Poison','Shield Dust',NULL,'Run Away',40,35,30,20,20,50,0.3,3.2,39,'I','Kanto','First'),(14,'Kakuna','Cocoon Pokémon','Bug','Poison','Shed Skin',NULL,NULL,45,25,50,25,25,35,0.6,10.0,72,'I','Kanto','Second'),(15,'Beedrill','Poison Bee Pokémon','Bug','Poison','Swarm',NULL,'Poison',65,90,40,45,80,75,1.0,29.5,178,'I','Kanto','Third'),(16,'Pidgey','Tiny Bird Pokémon','Normal','Flying','Keen Eye','Tangled Feet','Big Pecks',40,45,40,35,35,56,0.3,1.8,50,'I','Kanto','First'),(17,'Pidgeotto','Bird Pokémon','Normal','Flying','Keen Eye','Tangled Feet','Big Pecks',63,60,55,50,50,71,1.1,30.0,122,'I','Kanto','Second'),(18,'Pidgeot','Bird Pokémon','Normal','Flying','Keen Eye','Tangled Feet','Big Pecks',83,80,75,70,70,101,1.5,39.5,216,'I','Kanto','Third'),(19,'Rattata','Mouse Pokémon','Normal',NULL,'Run Away','Guts','Hustle',30,56,35,25,35,72,0.3,3.5,51,'I','Kanto','First'),(20,'Raticate','Mouse Pokémon','Normal',NULL,'Run Away','Guts','Hustle',55,81,60,50,70,97,0.7,18.5,145,'I','Kanto','Second'),(21,'Spearow','Tiny Bird Pokémon','Normal','Flying','Keen Eye',NULL,'Sniper',40,60,30,31,31,70,0.3,2.0,52,'I','Kanto','First'),(22,'Fearow','Beak Pokémon','Normal','Flying','Keen Eye',NULL,'Sniper',65,90,65,61,61,100,1.2,38.0,155,'I','Kanto','Second'),(23,'Ekans','Snake Pokémon','Poison','','Intimidate','Shed Skin','Unnerve',35,60,44,40,54,55,2.0,6.9,58,'I','Kanto','First'),(24,'Arbok','Cobra Pokémon','Poison','','Intimidate','Shed Skin','Unnerve',60,95,69,65,79,80,3.5,65.0,157,'I','Kanto','Second'),(25,'Pikachu','Mouse Pokémon','Electric','','Static','','Lightning Rod',35,55,40,50,50,90,0.4,6.0,112,'I','Kanto','Second'),(26,'Raichu','Mouse Pokémon','Electric','','Static','','Lightning Rod',60,90,55,90,80,110,0.8,30.0,243,'I','Kanto','Third'),(27,'Sandshrew','Mouse Pokémon','Ground','','Sand Veil','','Sand Rush',50,75,85,20,30,40,0.6,12.0,60,'I','Kanto','First'),(28,'Sandslash','Mouse Pokémon','Ground','','Sand Veil','','Sand Rush',75,100,110,45,55,65,1.0,29.5,158,'I','Kanto','Second'),(29,'Nidoran♀','Poison Pin Pokémon','Poison','','Poison Point','Rivalry','Hustle',55,47,52,40,40,41,0.4,7.0,55,'I','Kanto','First'),(30,'Nidorina','Poison Pin Pokémon','Poison','','Poison Point','Rivalry','Hustle',70,62,67,55,55,56,0.8,20.0,128,'I','Kanto','Second'),(31,'Nidoqueen','Drill Pokémon','Poison','Ground','Poison Point','Rivalry','Sheer Force',90,92,87,75,85,76,1.3,60.0,227,'I','Kanto','Third'),(32,'Nidoran♂','Poison Pin Pokémon','Poison','','Poison Point','Rivalry','Hustle',46,57,40,40,40,50,0.5,9.0,55,'I','Kanto','First'),(33,'Nidorino','Poison Pin Pokémon','Poison','','Poison Point','Rivalry','Hustle',61,72,57,55,55,65,0.9,19.5,128,'I','Kanto','Second'),(34,'Nidoking','Drill Pokémon','Poison','Ground','Poison Point','Rivalry','Sheer Force',81,102,77,85,75,85,1.4,62.0,227,'I','Kanto','Third'),(35,'Clefairy','Fairy Pokémon','Fairy','','Cute Charm','Magic Guard','Friend Guard',70,45,48,60,65,35,0.6,7.5,113,'I','Kanto','Second'),(36,'Clefable','Fairy Pokémon','Fairy','','Cute Charm','Magic Guard','Unaware',95,70,73,95,90,60,1.3,40.0,217,'I','Kanto','Third'),(37,'Vulpix','Fox Pokémon','Fire','','Flash Fire','','Drought',38,41,40,50,65,65,0.6,9.9,60,'I','Kanto','First'),(38,'Ninetales','Fox Pokémon','Fire','','Flash Fire','','Drought',73,76,75,81,100,100,1.1,19.9,177,'I','Kanto','Second'),(39,'Jigglypuff','Balloon Pokémon','Normal','Fairy','Cute Charm','Competitive','Friend Guard',115,45,20,45,25,20,0.5,5.5,95,'I','Kanto','Second'),(40,'Wigglytuff','Balloon Pokémon','Normal','Fairy','Cute Charm','Competitive','Frisk',140,70,45,85,50,45,1.0,12.0,218,'I','Kanto','Third'),(41,'Zubat','Bat Pokémon','Poison','Flying','Inner Focus','','Infiltrator',40,45,35,30,40,55,0.8,7.5,49,'I','Kanto','First'),(42,'Golbat','Bat Pokémon','Poison','Flying','Inner Focus','','Infiltrator',75,80,70,65,75,90,1.6,55.0,159,'I','Kanto','Second'),(43,'Oddish','Weed Pokémon','Grass','Poison','Chlorophyll','','Run Away',45,50,55,75,65,30,0.5,5.4,64,'I','Kanto','First'),(44,'Gloom','Weed Pokémon','Grass','Poison','Chlorophyll','','Run Away',60,65,70,85,75,40,0.8,8.6,138,'I','Kanto','Second'),(45,'Vileplume','FLower Pokémon','Grass','Poison','Chlorophyll','','Effect Spore',75,80,85,110,90,50,1.2,18.6,221,'I','Kanto','Third'),(46,'Paras','Mushroom Pokémon','Bug','Grass','Effect Spore','Dry Skin','Damp',35,70,55,45,55,25,0.3,5.4,57,'I','Kanto','First'),(47,'Parasect','Mushroom Pokémon','Bug','Grass','Effect Spore','Dry Skin','Damp',60,95,80,60,80,30,1.0,29.5,142,'I','Kanto','Second'),(48,'Venonat','Insect Pokémon','Bug','Poison','Compound Eyes','Tinted Lens','Run Away',60,55,50,40,55,45,1.0,30.0,61,'I','Kanto','First'),(49,'Venomoth','Poison Moth Pokémon','Bug','Poison','Shield Dust','Tinted Lens','Wonder Skin',70,65,60,90,75,90,1.5,12.5,158,'I','Kanto','Second'),(50,'Diglett','Mole Pokémon','Ground','','Sand Veil','Arena Trap','Sand Force',10,55,25,35,45,95,0.2,0.8,53,'I','Kanto','First'),(51,'Dugtrio','Mole Pokémon','Ground','','Sand Veil','Arena Trap','Sand Force',35,100,50,50,70,120,0.7,33.3,149,'I','Kanto','Second'),(52,'Meowth','Scratch Cat Pokémon','Normal','','Pickup','Technician','Unnerve',40,45,35,40,40,90,0.4,4.2,58,'I','Kanto','First'),(53,'Persian','Classy Cat Pokémon','Normal','','Limber','Technician','Unnerve',65,70,60,65,65,115,1.0,32.0,154,'I','Kanto','Second'),(54,'Psyduck','Duck Pokémon','Water','','Damp','Cloud Nine','Swift Swim',50,52,48,65,50,55,0.8,19.6,64,'I','Kanto','First'),(55,'Golduck','Duck Pokémon','Water','','Damp','Cloud Nine','Swift Swim',80,82,78,95,80,85,1.7,76.6,175,'I','Kanto','Second'),(56,'Mankey','Pig Monkey Pokémon','Fighting','','Vital Spirit','Anger Point','Defiant',40,80,35,35,45,70,0.5,28.0,61,'I','Kanto','First'),(57,'Primeape','Pig Monkey Pokémon','Fighting','','Vital Spirit','Anger Point','Defiant',65,105,60,60,70,95,1.0,32.0,159,'I','Kanto','Second'),(58,'Growlithe','Puppy Pokémon','Fire','','Intimidate','Flash Fire','Justified',55,70,45,70,50,60,0.7,19.0,70,'I','Kanto','First'),(59,'Arcanine','Legendary Pokémon','Fire','','Intimidate','Flash Fire','Justified',90,110,80,100,80,95,1.9,155.0,194,'I','Kanto','Second'),(60,'Poliwag','Tadpole Pokémon','Water','','Water Absorb','Damp','Swift Swim',40,50,40,40,40,90,0.6,12.4,60,'I','Kanto','First'),(61,'Poliwhirl','Tadpole Pokémon','Water','','Water Absorb','Damp','Swift Swim',65,65,65,50,50,90,1.0,20.0,135,'I','Kanto','Second'),(62,'Poliwrath','Tadpole Pokémon','Water','Fighting','Water Absorb','Damp','Swift Swim',90,95,95,70,90,70,1.3,54.0,230,'I','Kanto','Third'),(63,'Abra','Psi Pokémon','Psychic','','Synchronize','Inner Focus','Magic Guard',25,20,15,105,55,90,0.9,19.5,62,'I','Kanto','First'),(64,'Kadabra','Psi Pokémon','Psychic','','Synchronize','Inner Focus','Magic Guard',40,35,30,120,70,105,1.3,56.5,140,'I','Kanto','Second'),(65,'Alakazam','Psi Pokémon','Psychic','','Synchronize','Inner Focus','Magic Guard',55,50,45,135,95,120,1.5,48.0,225,'I','Kanto','Third'),(66,'Machop','Superpower Pokémon','Fighting','','Guts','No Guard','Steadfast',70,80,50,35,35,35,0.8,19.5,61,'I','Kanto','First'),(67,'Machoke','Superpower Pokémon','Fighting','','Guts','No Guard','Steadfast',80,100,70,50,60,45,1.5,70.5,142,'I','Kanto','Second'),(68,'Machamp','Superpower Pokémon','Fighting','','Guts','No Guard','Steadfast',90,130,80,65,85,55,1.6,130.0,227,'I','Kanto','Third'),(69,'Bellsprout','Flower Pokémon','Grass','Poison','Chlorophyll','','Gluttony',50,75,35,70,30,40,0.7,4.0,60,'I','Kanto','First'),(70,'Weepinbell','Flycatcher Pokémon','Grass','Poison','Chlorophyll','','Gluttony',65,90,50,85,45,55,1.0,6.4,137,'I','Kanto','Second'),(71,'Victreebel','Flycatcher Pokémon','Grass','Poison','Chlorophyll','','Gluttony',80,105,65,100,70,70,1.7,15.5,221,'I','Kanto','Third'),(72,'Tentacool','Jellyfish Pokémon','Water','Poison','Clear Body','Liquid Ooze','Rain Dish',40,40,35,50,100,70,0.9,45.5,67,'I','Kanto','First'),(73,'Tentacruel','Jellyfish Pokémon','Water','Poison','Clear Body','Liquid Ooze','Rain Dish',80,70,65,80,120,100,1.6,55.0,180,'I','Kanto','Second'),(74,'Geodude','Rock Pokémon','Rock','Ground','Rock Head','Sturdy','Sand Veil',40,80,100,30,30,20,0.4,20.0,60,'I','Kanto','First'),(75,'Graveler','Rock Pokémon','Rock','Ground','Rock Head','Sturdy','Sand Veil',55,95,115,45,45,35,1.0,105.0,137,'I','Kanto','Second'),(76,'Golem','Megaton Pokémon','Rock','Ground','Rock Head','Sturdy','Sand Veil',80,120,130,55,65,45,1.4,300.0,223,'I','Kanto','Third'),(77,'Ponyta','Fire Horse Pokémon','Fire','','Run Away','Flash Fire','Flame Body',50,85,55,65,65,90,1.0,30.0,82,'I','Kanto','First'),(78,'Rapidash','Fire Horse Pokémon','Fire','','Run Away','Flash Fire','Flame Body',65,100,70,80,80,105,1.7,95.0,175,'I','Kanto','Second'),(79,'Slowpoke','Dopey Pokémon','Water','Psychic','Oblivious','Own Tempo','Regenerator',90,65,65,40,40,15,1.2,36.0,63,'I','Kanto','First'),(80,'Slowbro','Hermit Crab Pokémon','Water','Psychic','Oblivious','Own Tempo','Regenerator',95,75,110,100,80,30,1.6,78.5,172,'I','Kanto','Second');
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
  CONSTRAINT `pokemon_evolutions_ibfk_2` FOREIGN KEY (`to_id`) REFERENCES `pokemon` (`pokemon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pokemon_evolutions`
--

LOCK TABLES `pokemon_evolutions` WRITE;
/*!40000 ALTER TABLE `pokemon_evolutions` DISABLE KEYS */;
INSERT INTO `pokemon_evolutions` VALUES (1,1,2,'Level Up','Level 16'),(2,2,3,'Level Up','Level 32'),(3,4,5,'Level Up','Level 16'),(4,5,6,'Level Up','Level 36'),(5,7,8,'Level Up','Level 16'),(6,8,9,'Level Up','Level 36'),(7,10,11,'Level Up','Level 7'),(8,11,12,'Level Up','Level 10'),(9,13,14,'Level Up','Level 7'),(10,14,15,'Level Up','Level 10'),(11,16,17,'Level Up','Level 18'),(12,17,18,'Level Up','Level 36'),(13,19,20,'Level Up','Level 20'),(14,21,22,'Level Up','Level 20'),(15,23,24,'Level Up','Level 22'),(16,25,26,'Evolution Stone','Use Thunder Stone (Outside Alola)'),(17,27,28,'Level Up','Level 22'),(18,29,30,'Level Up','Level 16'),(19,30,31,'Evolution Stone','Use Moon Stone'),(20,32,33,'Level Up','Level 16'),(21,33,34,'Evolution Stone','Use Moon Stone'),(22,35,36,'Evolution Stone','Use Moon Stone'),(23,37,38,'Evolution Stone','Fire Stone'),(24,39,40,'Evolution Stone','Use Moon Stone'),(25,41,42,'Level Up','Level 22'),(26,43,44,'Level Up','Level 21'),(27,44,45,'Evolution Stone','Use Leaf Stone'),(28,46,47,'Level Up','Level 24'),(29,48,49,'Level Up','Level 31'),(30,50,51,'Level Up','Level 26'),(31,52,53,'Level Up','Level 28'),(32,54,55,'Level Up','Level 32'),(33,56,57,'Level Up','Level 28'),(34,58,59,'Evolution Stone','Use Fire Stone'),(35,60,61,'Level Up','Level 25'),(36,61,62,'Evolution Stone','Use Water Stone'),(37,63,64,'Level Up','Level 16'),(38,64,65,'Trade','Trade'),(39,66,67,'Level Up','Level 28'),(40,67,68,'Trade','Trade'),(41,69,70,'Level Up','Level 21'),(42,70,71,'Evolution Stone','Use Leaf Stone'),(43,72,73,'Level Up','Level 30'),(44,74,75,'Level Up','Level 25'),(45,75,76,'Trade','Trade'),(46,77,78,'Level Up','Level 30'),(47,79,80,'Level Up','Level 37');
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

-- Dump completed on 2026-03-30 18:32:24
