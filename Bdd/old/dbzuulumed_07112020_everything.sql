-- MySQL dump 10.13  Distrib 8.0.17, for Linux (x86_64)
--
-- Host: localhost    Database: dbzuulumed
-- ------------------------------------------------------
-- Server version	8.0.17

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
-- Table structure for table `accountant`
--

DROP TABLE IF EXISTS `accountant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accountant` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(200) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accountant`
--

LOCK TABLES `accountant` WRITE;
/*!40000 ALTER TABLE `accountant` DISABLE KEYS */;
INSERT INTO `accountant` VALUES (1,'uploads/imgUsers/3_6_421199c192be2f5602673d420d84a5ec.jpg','Aissatou Sy','comptable@zuulumed.net','Mermoz','',NULL,'750');
/*!40000 ALTER TABLE `accountant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alloted_bed`
--

DROP TABLE IF EXISTS `alloted_bed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alloted_bed` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `number` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `a_time` varchar(100) DEFAULT NULL,
  `d_time` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `bed_id` varchar(100) DEFAULT NULL,
  `patientname` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alloted_bed`
--

LOCK TABLES `alloted_bed` WRITE;
/*!40000 ALTER TABLE `alloted_bed` DISABLE KEYS */;
INSERT INTO `alloted_bed` VALUES (1,NULL,NULL,'1','15 October 2020 - 04:50 PM','',NULL,NULL,'scanner-20','Shaibal Saha'),(2,NULL,NULL,'8','20 October 2020 - 09:55 AM','20 October 2020 - 01:35 PM',NULL,NULL,'scanner-20','Bouba');
/*!40000 ALTER TABLE `alloted_bed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `code` varchar(25) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `time_slot` varchar(100) DEFAULT NULL,
  `s_time` varchar(100) DEFAULT NULL,
  `e_time` varchar(100) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `add_date` varchar(100) DEFAULT NULL,
  `registration_time` varchar(100) DEFAULT NULL,
  `s_time_key` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `request` varchar(100) DEFAULT NULL,
  `patientname` varchar(1000) DEFAULT NULL,
  `doctorname` varchar(1000) DEFAULT NULL,
  `service` int(11) DEFAULT NULL,
  `servicename` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment`
--

LOCK TABLES `appointment` WRITE;
/*!40000 ALTER TABLE `appointment` DISABLE KEYS */;
INSERT INTO `appointment` VALUES (1,NULL,'2',NULL,'2','1602892800','09:30 PM To 09:45 PM','09:30 PM','09:45 PM','Rendez vous','10/14/20','1602711881','258','Pending Confirmation','1','','cheikh ahmed diagne','Ibnou Abass Diagne',NULL,NULL),(2,NULL,'3',NULL,'2','1602806400','01:00 PM To 01:45 PM','01:00 PM','01:45 PM','','10/14/20','1602713021','156','Pending Confirmation','1','','Mina Diagne','Ibnou Abass Diagne',NULL,NULL),(3,NULL,'1',NULL,'2','1604016000','01:00 PM To 01:45 PM','01:00 PM','01:45 PM','','10/14/20','1602713150','156','Confirmed','1','','Shaibal Saha','Ibnou Abass Diagne',NULL,NULL),(4,NULL,'3',NULL,'2','1602720000','Not Selected','Not Selected','','','10/14/20','1602713230','0','Pending Confirmation','1','','Mina Diagne','Ibnou Abass Diagne',NULL,NULL),(5,NULL,'1',NULL,'2','1603929600',NULL,'','','','10/14/20','1602713279','0','Treated','1','','Shaibal Saha','Ibnou Abass Diagne',NULL,NULL),(6,NULL,'1',NULL,'2','1602633600',NULL,'','','','10/14/20','1602713404','0','Confirmed','1','','Shaibal Saha','Ibnou Abass Diagne',NULL,NULL),(7,NULL,'4',NULL,'2','1603152000','Not Selected','Not Selected','','Urgence','10/14/20','1602719920','0','Pending Confirmation','1','','John DOE','Ibnou Abass Diagne',NULL,NULL),(8,NULL,'4',NULL,'2','1602720000',NULL,'','','','10/15/20','1602797468','0','Confirmed','1','','Mary DOE','Ibnou Abass Diagne',NULL,NULL),(9,NULL,'13',NULL,'2','1603929600','Not Selected','Not Selected','','','10/25/20','1603640608','0','Confirmed','1','','Getrude','Ibnou Abass Diagne',NULL,NULL),(10,NULL,'12',NULL,'','1603756800','09h-16h','09h','16h','','10/27/20','1603802800','0','Confirmed','1','','FAYE ROKHAYA','',2,'Labo Analyse'),(11,NULL,'5',NULL,'','1603756800','09h-16h','09h','16h','','10/27/20','1603802822','0','Pending Confirmation','1','','laboo FAYE ROKHAYA','',1,'Generaliste'),(12,NULL,'14',NULL,'','1603670400','09h-16h','09h','16h','tres urgent','10/28/20','1603891102','0','Confirmed','1','','Joseph Raymond','',6,'Laboratoire'),(13,NULL,'14',NULL,'','1603843200','09h-16h','09h','16h','tres urgent','10/28/20','1603900259','0','Pending Confirmation','1','','Joseph Raymond','',7,'GENERALISTE'),(14,NULL,'15',NULL,'','1604361600','09h-16h','09h','16h','','11/03/20','1604407227','0','Pending Confirmation','1','','FAYE hopital zfs ROKHAYA','',NULL,NULL),(15,NULL,'17',3,'','1604534400','09h-16h','09h','16h','','11/03/20','1604446666','0','Confirmed','1','','FA RO','',NULL,NULL),(16,NULL,'17',3,'','1605916800','09h-16h','09h','16h','','11/04/20','1604486386','0','Pending Confirmation','1','','FA RO','',9,'servive medecine generale zfs'),(17,NULL,'19',3,'','1604966400',NULL,'','','consultation test','11/04/20','1604490483','0','Confirmed','1','','aida fall','',NULL,NULL),(18,NULL,'16',4,'','1604966400','09h-16h','09h','16h','','11/04/20','1604521043','0','','769','','FAYE hopital RF DABA','',12,'laboo'),(19,NULL,'21',4,'','1606262400','09h-16h','09h','16h','','11/04/20','1604521109','0','Confirmed','769','','FAYE ROKHAYA','',12,'laboo'),(20,NULL,'15',3,'','1604620800','09h-16h','09h','16h','','11/05/20','1604535682','0','Pending Confirmation','1','','FAYE hopital zfs ROKHAYA','',8,'Scanner'),(21,NULL,'25',1,'','1605830400','09h-16h','09h','16h','','11/05/20','1604575506','0','Confirmed','761','','NoName Sy','',14,'X-Ray Gamma');
/*!40000 ALTER TABLE `appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arrondissement_senegal`
--

DROP TABLE IF EXISTS `arrondissement_senegal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arrondissement_senegal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_departement` bigint(20) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=811 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arrondissement_senegal`
--

LOCK TABLES `arrondissement_senegal` WRITE;
/*!40000 ALTER TABLE `arrondissement_senegal` DISABLE KEYS */;
INSERT INTO `arrondissement_senegal` VALUES (352,262,'Almadies'),(354,262,'Plateau'),(356,262,'Grand Dakar'),(358,262,'Parcelles Assainies'),(360,264,'Guediawaye'),(362,266,'Niayes'),(364,266,'Dagoudane'),(366,266,'Thiaroye'),(368,268,'Rufisque'),(370,268,'Sangalkam'),(372,268,'Bargny (Commune)'),(374,268,'Diamniadio (Commune)'),(376,268,'Sebikotane (Commune)'),(378,270,'Baba Garage'),(380,270,'Lambaye'),(382,270,'Ngoye'),(384,270,'Bambey (Commune)'),(386,272,'Ndindy'),(388,272,'Ndoulo'),(390,272,'Diourbel (Commune)'),(392,274,'Kael'),(394,274,'Ndame'),(396,274,'Taif'),(398,274,'Mbacke (Commune)'),(400,276,'Diakhao'),(402,276,'Fimela'),(404,276,'Niakhar'),(406,276,'Tattaguine'),(408,276,'Diofior (Commune)'),(410,276,'Fatick (Commune)'),(412,278,'Djilor'),(414,278,'Niodior'),(416,278,'Toubacouta'),(418,278,'Foundiougne (Commune)'),(420,278,'Karang Poste (Commune)'),(422,278,'Passi (Commune)'),(424,278,'Sokone (Commune)'),(426,278,'Soum (Commune)'),(428,280,'Colobane'),(430,280,'Ouadiour'),(432,280,'Gossas (Commune)'),(434,282,'Keur Mbouki'),(436,282,'Mabo'),(438,282,'Birkilane (Commune)'),(440,284,'Gniby'),(442,284,'Katakel'),(444,284,'Kaffrine (Commune)'),(446,284,'Nganda (Commune)'),(448,286,'Ida Mouride'),(450,286,'Lour Escale'),(452,286,'Missirah Wadene'),(454,286,'Koungheul (Commune)'),(456,288,'Darouminam 2'),(458,288,'Sagna'),(460,288,'Malem Hodar (Commune)'),(462,290,'Mbadakhoune'),(464,290,'Nguellou'),(466,290,'Guinguineo (Commune)'),(468,292,'Koumbal'),(470,292,'Ndiedieng'),(472,292,'Sibassor'),(474,292,'Gandiaye (Commune)'),(476,292,'Kahone (Commune)'),(478,292,'Kaoloack (Commune)'),(480,292,'Ndoffane (Commune)'),(482,294,'Medina Sabakh'),(484,294,'Paoskoto'),(486,294,'Wack Ngouna'),(488,294,'Keur Madiabel (Commune)'),(490,294,'Nioro du Rip (Commune)'),(492,296,'Bandafassi'),(494,296,'Fongolimbi'),(496,296,'Kedougou (Commune)'),(498,298,'Dakately'),(500,298,'Dar Salam'),(502,298,'Salemata (Commune)'),(504,300,'Bembou'),(506,300,'Sabodala'),(508,300,'Saraya (Commune)'),(510,302,'Dioulacolon'),(512,302,'Mampatim'),(514,302,'Sare Bidji'),(516,302,'Dabo (Commune)'),(518,302,'Kolda (Commune)'),(520,302,'Salikegne (Commune)'),(522,302,'Sare Yoba Diega (Commune)'),(524,304,'Fafacourou'),(526,304,'Ndorna'),(528,304,'Niaming'),(530,304,'Medina Yoro Foulah (Commune)'),(532,304,'Pata (Commune)'),(534,306,'Bonconto'),(536,306,'Pakour'),(538,306,'Sarre Coly Salle'),(540,306,'Diaobe Kabendou (Commune)'),(542,306,'Kounkane (Commune)'),(544,306,'Velingara (Commune)'),(546,308,'Darou Mousti'),(548,308,'Ndande'),(550,308,'Sagata Gueth'),(552,308,'Gueoul (Commune)'),(554,308,'Kebemer (Commune)'),(556,310,'Barkedji'),(558,310,'Dodji'),(560,310,'Sagatta Djoloff'),(562,310,'Yang Yang'),(564,310,'Dahra (Commune)'),(566,310,'Linguere (Commune)'),(568,312,'Keur Momar Sarr'),(570,312,'Koki'),(572,312,'Mbediene'),(574,312,'Sakal'),(576,312,'Louga (Commune)'),(578,314,'Orkadiere'),(580,314,'Sinthiou Bamambe'),(582,314,'Dembancane (Commune)'),(584,314,'Hamadi Hounare (Commune)'),(586,314,'Kanel (Commune)'),(588,314,'Ouaounde (Commune)'),(590,314,'Semme (Commune)'),(592,314,'Sinthiou Bamambe Banadji (Commune)'),(594,316,'Agnam Civol'),(596,316,'Ogo'),(598,316,'Matam (Commune)'),(600,316,'Ourossogui (Commune)'),(602,316,'Thilogne (Commune)'),(604,318,'Velingara'),(606,318,'Ranerou (Commune)'),(608,320,'Mbane'),(610,320,'Ross Bethio'),(612,320,'Dagana (Commune)'),(614,320,'Gae (Commune)'),(616,320,'Richard Toll (Commune)'),(618,320,'Rosso Senegal (Commune)'),(620,322,'Cas Cas'),(622,322,'Gamadji Sare'),(624,322,'Salde'),(626,322,'Thille Boubacar'),(628,322,'Aere Lao (Commune)'),(630,322,'Bode Lao (Commune)'),(632,322,'Demette (Commune)'),(634,322,'Galoya Toucouleur (Commune)'),(636,322,'Gollere (Commune)'),(638,322,'Guede Chantier (Commune)'),(640,322,'Mboumba (Commune)'),(642,322,'Ndioum (Commune)'),(644,322,'Niandane (Commune)'),(646,322,'Pete (Commune)'),(648,322,'Podor (Commune)'),(650,322,'Walalde (Commune)'),(652,324,'Rao'),(654,324,'Mpal (Commune)'),(656,324,'Saint Louis (Commune)'),(658,326,'Boghal'),(660,326,'Bona'),(662,326,'Diaroume'),(664,326,'Bounkiling (Commune)'),(666,326,'Madina Wandifa (Commune)'),(668,328,'Djibanar'),(670,328,'Karantaba'),(672,328,'Simbandi Brassou'),(674,328,'Diattacounda (Commune)'),(676,328,'Goundomp (Commune)'),(678,328,'Samine (Commune)'),(680,328,'Tanaff (Commune)'),(682,330,'Diende'),(684,330,'Djibabouya'),(686,330,'Djiredji'),(688,330,'Dianah Malary (Commune)'),(690,330,'Marsassoum (Commune)'),(692,330,'Sedhiou (Commune)'),(694,332,'Bele'),(696,332,'Keniaba'),(698,332,'Moudiry'),(700,332,'Bakel (Commune)'),(702,332,'Diawara (Commune)'),(704,332,'Kidira (Commune)'),(706,334,'Bala'),(708,334,'Boynguel Bamba'),(710,334,'Dianke Makha'),(712,334,'Koulor'),(714,334,'Goudiry (Commune)'),(716,334,'Kothiary (Commune)'),(718,336,'Bamba Thialene'),(720,336,'Kouthiaba Wolof'),(722,336,'Koumpentoum (Commune)'),(724,336,'Maleme Niani (Commune)'),(726,338,'Koussanar'),(728,338,'Makacolibantang'),(730,338,'Missirah'),(732,338,'Tambacounda (Commune)'),(734,340,'Fissel'),(736,340,'Sessene'),(738,340,'Sindia'),(740,340,'Joal Fadiouth (Commune)'),(742,340,'Mbour (Commune)'),(744,340,'Ngaparou (Commune)'),(746,340,'Nguekhokh (Commune)'),(748,340,'Popenguine (Commune)'),(750,340,'Saly Portudal (Commune)'),(752,340,'Somone (Commune)'),(754,340,'Thiadiaye (Commune)'),(756,342,'Keur Moussa'),(758,342,'Notto'),(760,342,'Thienaba'),(762,342,'Thies Nord'),(764,342,'Thies Sud'),(766,342,'Kayar (Commune)'),(768,342,'Khombole (Commune)'),(770,342,'Pout (Commune)'),(772,344,'Meaouane'),(774,344,'Merina Dakhar'),(776,344,'Niakhene'),(778,344,'Pambal'),(780,344,'Mboro (Commune)'),(782,344,'Meckhe (Commune)'),(784,344,'Tivaouane (Commune)'),(786,346,'Kataba 1'),(788,346,'Sindian'),(790,346,'Tendouck'),(792,346,'Tenghori'),(794,346,'Bignona (Commune)'),(796,346,'Diouloulou (Commune)'),(798,346,'Thionck Essyl (Commune)'),(800,348,'Cabrousse'),(802,348,'Loudia Ouolof'),(804,348,'Oussouye (Commune)'),(806,350,'Niaguis'),(808,350,'Niassia'),(810,350,'Ziguinchor (Commune)');
/*!40000 ALTER TABLE `arrondissement_senegal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoemailshortcode`
--

DROP TABLE IF EXISTS `autoemailshortcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autoemailshortcode` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoemailshortcode`
--

LOCK TABLES `autoemailshortcode` WRITE;
/*!40000 ALTER TABLE `autoemailshortcode` DISABLE KEYS */;
INSERT INTO `autoemailshortcode` VALUES (1,'{firstname}','payment'),(2,'{lastname}','payment'),(3,'{name}','payment'),(4,'{amount}','payment'),(52,'{doctorname}','appoinment_confirmation'),(42,'{firstname}','appoinment_creation'),(51,'{name}','appoinment_confirmation'),(50,'{lastname}','appoinment_confirmation'),(49,'{firstname}','appoinment_confirmation'),(48,'{hospital_name}','appoinment_creation'),(47,'{time_slot}','appoinment_creation'),(46,'{appoinmentdate}','appoinment_creation'),(45,'{doctorname}','appoinment_creation'),(44,'{name}','appoinment_creation'),(43,'{lastname}','appoinment_creation'),(26,'{name}','doctor'),(27,'{firstname}','doctor'),(28,'{lastname}','doctor'),(29,'{company}','doctor'),(41,'{doctor}','patient'),(40,'{company}','patient'),(39,'{lastname}','patient'),(38,'{firstname}','patient'),(37,'{name}','patient'),(36,'{department}','doctor'),(53,'{appoinmentdate}','appoinment_confirmation'),(54,'{time_slot}','appoinment_confirmation'),(55,'{hospital_name}','appoinment_confirmation'),(56,'{start_time}','meeting_creation'),(57,'{patient_name}','meeting_creation'),(58,'{doctor_name}','meeting_creation'),(59,'{hospital_name}','meeting_creation');
/*!40000 ALTER TABLE `autoemailshortcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autoemailtemplate`
--

DROP TABLE IF EXISTS `autoemailtemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autoemailtemplate` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autoemailtemplate`
--

LOCK TABLES `autoemailtemplate` WRITE;
/*!40000 ALTER TABLE `autoemailtemplate` DISABLE KEYS */;
INSERT INTO `autoemailtemplate` VALUES (1,'Payment successful email to patient','<p>Dear {name}, Your paying amount - Tk {amount} was successful.</p>\r\n\r\n<p>Thank You</p>\r\n','payment','Active'),(9,'Appointment creation email to patient','Dear {name},<br />\r\nYou have an &nbsp;appointment with {doctorname} on {appoinmentdate} at {time_slot} .Please confirm your appointment.<br />\r\nFor more information contact with {hospital_name}<br />\r\nRegards','appoinment_creation','Inactive'),(10,'Appointment Confirmation email  to patient','Dear {name},<br />\r\nYour appointment with {doctorname} on {appoinmentdate} at {time_slot} is confirmed.<br />\r\nFor more information contact with {hospital_name}<br />\r\nRegards','appoinment_confirmation','Active'),(11,'Meeting Schedule Notification To Patient','Dear {patient_name}, You have a Live Video Meeting with {doctor_name} on {start_time}. For more information contact with {hospital_name} .\r\nRegards','meeting_creation','Active'),(6,'send joining confirmation to Doctor','<p>Dear {name},<br />\r\nYou are appointed as a doctor&nbsp; in {department}.<br />\r\nThank You</p>\r\n\r\n<p>{company}</p>\r\n','doctor','Active'),(8,'Patient Registration Confirmation ','<p>Dear {name},</p>\n\n<p>You are registred to {company} as a patient to {doctor}.</p>\n\n<p>Regards</p>\n','patient','Active');
/*!40000 ALTER TABLE `autoemailtemplate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autosmsshortcode`
--

DROP TABLE IF EXISTS `autosmsshortcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autosmsshortcode` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autosmsshortcode`
--

LOCK TABLES `autosmsshortcode` WRITE;
/*!40000 ALTER TABLE `autosmsshortcode` DISABLE KEYS */;
INSERT INTO `autosmsshortcode` VALUES (1,'{name}','payment'),(2,'{firstname}','payment'),(3,'{lastname}','payment'),(4,'{amount}','payment'),(55,'{appoinmentdate}','appoinment_confirmation'),(54,'{doctorname}','appoinment_confirmation'),(53,'{name}','appoinment_confirmation'),(52,'{lastname}','appoinment_confirmation'),(51,'{firstname}','appoinment_confirmation'),(50,'{time_slot}','appoinment_creation'),(49,'{appoinmentdate}','appoinment_creation'),(48,'{hospital_name}','appoinment_creation'),(47,'{doctorname}','appoinment_creation'),(46,'{name}','appoinment_creation'),(45,'{lastname}','appoinment_creation'),(44,'{firstname}','appoinment_creation'),(28,'{firstname}','doctor'),(29,'{lastname}','doctor'),(30,'{name}','doctor'),(31,'{company}','doctor'),(43,'{doctor}','patient'),(42,'{company}','patient'),(41,'{lastname}','patient'),(40,'{firstname}','patient'),(39,'{name}','patient'),(38,'{department}','doctor'),(56,'{time_slot}','appoinment_confirmation'),(57,'{hospital_name}','appoinment_confirmation'),(58,'{start_time}','meeting_creation'),(59,'{patient_name}','meeting_creation'),(60,'{doctor_name}','meeting_creation'),(61,'{hospital_name}','meeting_creation');
/*!40000 ALTER TABLE `autosmsshortcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autosmstemplate`
--

DROP TABLE IF EXISTS `autosmstemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autosmstemplate` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autosmstemplate`
--

LOCK TABLES `autosmstemplate` WRITE;
/*!40000 ALTER TABLE `autosmstemplate` DISABLE KEYS */;
INSERT INTO `autosmstemplate` VALUES (1,'Payment successful sms to patient','Dear {name},\r\n Your paying amount - Tk {amount} was successful.\r\nThank You\r\nPlease contact our support for further queries.{name}','payment','Active'),(12,'Appointment Confirmation sms to patient','Dear {name},\r\nYour appointment with {doctorname} on {appoinmentdate} at {time_slot} is confirmed.\r\nFor more information contact with {hospital_name}\r\nRegards','appoinment_confirmation','Active'),(13,'Appointment creation sms to patient','Dear {name},\r\nYou have an  appointment with {doctorname} on {appoinmentdate} at {time_slot} .Please confirm your appointment.\r\nFor more information contact with {hospital_name}\r\nRegards','appoinment_creation','Active'),(14,'Meeting Schedule Notification To Patient','Dear {patient_name}, You have a Live Video Meeting with {doctor_name} on {start_time}. For more information contact with {hospital_name} .\r\nRegards','meeting_creation','Active'),(9,'send appoint confirmation to Doctor','Dear {name},\nYou are appointed as a doctor in {department} .\nThank You\n{company}','doctor','Active'),(11,'Patient Registration Confirmation ','Dear {name},\n You are registred to {company} as a patient to {doctor}. \nRegards','patient','Active');
/*!40000 ALTER TABLE `autosmstemplate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bankb`
--

DROP TABLE IF EXISTS `bankb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bankb` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `group` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bankb`
--

LOCK TABLES `bankb` WRITE;
/*!40000 ALTER TABLE `bankb` DISABLE KEYS */;
INSERT INTO `bankb` VALUES (1,'A+','0 Bags'),(2,'A-','0 Bags'),(3,'B+','0 Bags'),(4,'B-','0 Bags'),(5,'AB+','0 Bags'),(6,'AB-','0 Bags'),(7,'O+','0 Bags'),(8,'O-','0 Bags');
/*!40000 ALTER TABLE `bankb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bed`
--

DROP TABLE IF EXISTS `bed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bed` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `last_a_time` varchar(100) DEFAULT NULL,
  `last_d_time` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `bed_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bed`
--

LOCK TABLES `bed` WRITE;
/*!40000 ALTER TABLE `bed` DISABLE KEYS */;
INSERT INTO `bed` VALUES (1,'scanner','20','Salaire Juin test rf','20 October 2020 - 09:55 AM','20 October 2020 - 01:35 PM',NULL,'scanner-20');
/*!40000 ALTER TABLE `bed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bed_category`
--

DROP TABLE IF EXISTS `bed_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bed_category` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bed_category`
--

LOCK TABLES `bed_category` WRITE;
/*!40000 ALTER TABLE `bed_category` DISABLE KEYS */;
INSERT INTO `bed_category` VALUES (1,'scanner','Salaire Juin test rf');
/*!40000 ALTER TABLE `bed_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beneficiaire`
--

DROP TABLE IF EXISTS `beneficiaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `beneficiaire` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_organisation` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `adresse` text,
  `email` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beneficiaire`
--

LOCK TABLES `beneficiaire` WRITE;
/*!40000 ALTER TABLE `beneficiaire` DISABLE KEYS */;
INSERT INTO `beneficiaire` VALUES (1,NULL,'Aicha ',NULL,'00221781156335',NULL,NULL),(2,NULL,'Absa Ngom',NULL,'89434855900',NULL,NULL),(3,NULL,'daba dafaye',NULL,'7888888888',NULL,NULL),(4,NULL,'rf rf',NULL,'0786006831',NULL,NULL),(5,NULL,'Moussa Diop',NULL,'221786543214',NULL,NULL),(6,'3','Ino Diagne',NULL,'(+221) 78 115 63 35',NULL,NULL),(7,'4','Boune Dione',NULL,'(+221) 78 115 63 35',NULL,NULL),(8,'8','FAYE ROKHAYA',NULL,'(+221) 78 600 68 31',NULL,NULL);
/*!40000 ALTER TABLE `beneficiaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collectivite_senegal`
--

DROP TABLE IF EXISTS `collectivite_senegal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collectivite_senegal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_arrondissement` bigint(20) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1867 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collectivite_senegal`
--

LOCK TABLES `collectivite_senegal` WRITE;
/*!40000 ALTER TABLE `collectivite_senegal` DISABLE KEYS */;
INSERT INTO `collectivite_senegal` VALUES (812,352,'Mermoz Sacre Coeur'),(814,352,'Ngor'),(816,352,'Ouakam'),(818,352,'Yoff'),(820,354,'Plateau'),(822,354,'Fann Point E Amitie'),(824,354,'Goree'),(826,354,'Gueule Tapee Fass Colobane'),(828,354,'Medina'),(830,356,'Biscuiterie '),(832,356,'Dieuppeul Derkle'),(834,356,'Grand Dakar '),(836,356,'Hann Bel Air'),(838,356,'Hlm '),(840,356,'Sicap Liberte'),(842,358,'Camberene'),(844,358,'Grand Yoff'),(846,358,'Parcelles Assainies'),(848,358,'Patte D Oie '),(850,360,'Golf Sud'),(852,360,'Medina Gounass'),(854,360,'Ndiareme Limamoulaye'),(856,360,'Sam Notaire '),(858,360,'Wakhinane Nimzat'),(860,362,'Keur Massar '),(862,362,'Malika'),(864,362,'Yeumbeul Nord'),(866,362,'Yeumbeul Sud'),(868,364,'Dalifort'),(870,364,'Djida Thiaroye Kao'),(872,364,'Guinaw Rail Nord'),(874,364,'Guinaw Rail Sud'),(876,364,'Pikine Est'),(878,364,'Pikine Nord '),(880,364,'Pikine Ouest'),(882,366,'Diamaguene Sicap Mbao'),(884,366,'Mbao'),(886,366,'Thiaroye Gare'),(888,366,'Thiaroye Sur Mer'),(890,366,'Tivavouane Diaksao'),(892,368,'Rufisque Est'),(894,368,'Rufisque Nord'),(896,368,'Rufisque Ouest'),(898,370,'Sangalkam'),(900,370,'Yene'),(902,372,'Bargny'),(904,374,'Diamniadio'),(906,376,'Sebikotane'),(908,384,'Bambey'),(910,378,'Baba Garage '),(912,378,'Dinguiraye'),(914,378,'Keur Samba Kane'),(916,380,'Gawane'),(918,380,'Lambaye'),(920,380,'Ngogom'),(922,380,'Refane'),(924,382,'Dangalma'),(926,382,'Ndondol'),(928,382,'Ngoye'),(930,382,'Thiakar'),(932,390,'Diourbel'),(934,386,'Dankh Sene'),(936,386,'Gade Escale '),(938,386,'Keur Ngalgou'),(940,386,'Ndindy'),(942,386,'Taiba Moutoupha'),(944,388,'Ndoulo'),(946,388,'Ngohe'),(948,388,'Pattar'),(950,388,'Tocky Gare'),(952,388,'Toure Mbonde'),(954,398,'Mbacke'),(956,392,'Dandeye Gouygui'),(958,392,'Darou Nahim '),(960,392,'Darou Salam Typ'),(962,392,'Kael'),(964,392,'Madina'),(966,392,'Ndioumane Taiba Thiekene'),(968,392,'Taiba Thiekene'),(970,392,'Touba Mboul '),(972,394,'Dalla Ngabou'),(974,394,'Missirah'),(976,394,'Nghaye'),(978,394,'Touba Fall'),(980,394,'Touba Mosquee'),(982,396,'Sadio'),(984,396,'Taif'),(986,400,'Diakhao'),(988,400,'Diaoule'),(990,400,'Mbellacadiao'),(992,400,'Ndiob'),(994,402,'Djilass'),(996,402,'Fimela'),(998,402,'Loul Sessene'),(1000,402,'Palmarin Facao'),(1002,404,'Ngayokheme'),(1004,404,'Niakhar'),(1006,404,'Patar'),(1008,406,'Diarrere'),(1010,406,'Diouroup'),(1012,406,'Tattaguine'),(1014,408,'Diofior'),(1016,410,'Fatick'),(1018,412,'Diossong'),(1020,412,'Djilor'),(1022,414,'Bassoul'),(1024,414,'Dionewar'),(1026,414,'Djirnda'),(1028,414,'Niodior'),(1030,416,'Keur Saloum Diane'),(1032,416,'Keur Samba Gueye'),(1034,416,'Nioro Alassane Tall'),(1036,416,'Toubacouta'),(1038,418,'Foundiougne '),(1040,420,'Karang Poste'),(1042,422,'Passi'),(1044,424,'Sokone'),(1046,426,'Soum'),(1048,428,'Colobane'),(1050,428,'Mbar'),(1052,430,'Ndiene Lagane'),(1054,430,'Ouadiour'),(1056,430,'Patar Lia'),(1058,432,'Gossas'),(1060,434,'Keur Mboucki'),(1062,434,'Touba Mbella'),(1064,436,'Mabo'),(1066,436,'Ndiognick'),(1068,438,'Birkilane'),(1070,440,'Boulel'),(1072,440,'Gniby'),(1074,440,'Kahi'),(1076,442,'Diamagadio'),(1078,442,'Diokoul Mbelbouck'),(1080,442,'Kathiote'),(1082,442,'Medinatoul Salam 2'),(1084,444,'Kaffrine'),(1086,446,'Nganda'),(1088,448,'Fass Thiekene'),(1090,448,'Ida Mouride '),(1092,448,'Saly Escale '),(1094,450,'Lour Escale '),(1096,450,'Ribot Escale'),(1098,452,'Maka Yop'),(1100,452,'Missirah Wadene'),(1102,452,'Ngainthe Pate'),(1104,454,'Koungheul'),(1106,456,'Darou Minam '),(1108,456,'Khelcom'),(1110,456,'Ndioum Ngainthe'),(1112,458,'Djanke Souf '),(1114,458,'Sagna'),(1116,460,'Malem Hodar '),(1118,462,'Khelcom Birame'),(1120,462,'Mbadakhoune '),(1122,462,'Ndiago'),(1124,462,'Ngathie Naoude'),(1126,464,'Mboss'),(1128,464,'Ngagnick'),(1130,464,'Ngellou'),(1132,464,'Ourour'),(1134,466,'Guinguineo'),(1136,468,'Keur Baka'),(1138,468,'Latmingue'),(1140,468,'Thiare'),(1142,470,'Keur Soce'),(1144,470,'Ndiaffate'),(1146,470,'Ndiedieng'),(1148,472,'Dya '),(1150,472,'Ndiebel'),(1152,472,'Thiomby'),(1154,474,'Gandiaye'),(1156,476,'Kahone'),(1158,478,'Kaoloack'),(1160,480,'Ndoffane'),(1162,482,'Kayemor'),(1164,482,'Medina Sabakh'),(1166,482,'Ngayene'),(1168,484,'Gainte Kaye '),(1170,484,'Paoskoto'),(1172,484,'Porokhane'),(1174,484,'Taiba Niassene'),(1176,486,'Keur Maba Diakhou'),(1178,486,'Keur Madongo'),(1180,486,'Ndrame Escale'),(1182,486,'Wack Ngouna '),(1184,488,'Keur Madiabel'),(1186,490,'Nioro Du Rip'),(1188,492,'Bandafassi'),(1190,492,'Dindefelo'),(1192,492,'Ninefecha'),(1194,492,'Tomboronkoto'),(1196,494,'Dimboli'),(1198,494,'Fongolimbi'),(1200,496,'Kedougou'),(1202,498,'Dakately'),(1204,498,'Kevoye'),(1206,500,'Dar Salam'),(1208,500,'Ethiolo'),(1210,500,'Oubadji'),(1212,502,'Salemata'),(1214,504,'Bembou'),(1216,504,'Medina Baffe'),(1218,506,'Khossanto'),(1220,506,'Missirah Sirimana'),(1222,506,'Sabodola'),(1224,508,'Saraya'),(1226,510,'Dioulacolon '),(1228,510,'Guiro Yero Bocar'),(1230,510,'Medina El Hadji'),(1232,510,'Tankanto Escale'),(1234,512,'Bagadaji'),(1236,512,'Coumbacara'),(1238,512,'Dialambere'),(1240,512,'Mampatim'),(1242,512,'Medina Cherif'),(1244,514,'Sare Bidji'),(1246,514,'Thietty'),(1248,516,'Dabo'),(1250,518,'Kolda'),(1252,520,'Salikegne'),(1254,522,'Sare Yoba Diega'),(1256,524,'Badion'),(1258,524,'Fafacourou'),(1260,526,'Bignarabe'),(1262,526,'Bourouco'),(1264,526,'Koulinto'),(1266,526,'Ndorna'),(1268,528,'Dinguiray'),(1270,528,'Kerewane'),(1272,528,'Niaming'),(1274,530,'Medina Yoro Foulah'),(1276,532,'Pata'),(1278,534,'Bonconto'),(1280,534,'Linkering'),(1282,534,'Medina Gounasse'),(1284,534,'Sinthiang Koundara'),(1286,536,'Ouassadou'),(1288,536,'Pakour'),(1290,536,'Paroumba'),(1292,538,'Kandia'),(1294,538,'Kandiaye'),(1296,538,'Nemataba'),(1298,538,'Sare Coli Salle'),(1300,674,'Diaobe Kabendou'),(1302,542,'Kounkane'),(1304,544,'Velingara'),(1306,546,'Darou Marnane'),(1308,546,'Darou Mousti'),(1310,546,'Mbacke Cajor'),(1312,546,'Mbadiane'),(1314,546,'Ndoyene'),(1316,546,'Sam '),(1318,546,'Yabal'),(1320,546,'Touba'),(1322,546,'Merina'),(1324,548,'Bandegne Ouolof'),(1326,548,'Diokoul Ndiawrigne'),(1328,548,'Kab Gaye'),(1330,548,'Ndande'),(1332,548,'Thiep'),(1334,550,'Kanene Ndiob'),(1336,550,'Loro'),(1338,550,'Ngourane Ouolof'),(1340,550,'Sagata Gueth'),(1342,550,'Thiolom Fall'),(1344,552,'Gueoul'),(1346,554,'Kebemer'),(1348,556,'Barkedji'),(1350,556,'Gassane'),(1352,556,'Thiargny'),(1354,556,'Thiel'),(1356,558,'Dodji'),(1358,558,'Labgar'),(1360,558,'Ouarkhokh'),(1362,560,'Boulal'),(1364,560,'Dealy'),(1366,560,'Sagatta Djolof'),(1368,560,'Thiamene Passe'),(1370,562,'Kambe'),(1372,562,'Mbeuleukhe'),(1374,562,'Mboula'),(1376,562,'Tessekere Forage'),(1378,564,'Dahra'),(1380,566,'Linguere'),(1382,568,'Gande'),(1384,568,'Keur Momar Sarr'),(1386,568,'Nguer Malal '),(1388,568,'Syer'),(1390,570,'Koki'),(1392,570,'Ndiagne'),(1394,570,'Pete Ouarack'),(1396,570,'Thiamene Cayor'),(1398,572,'Kelle Gueye '),(1400,572,'Mbediene'),(1402,572,'Nguidile'),(1404,572,'Niomre'),(1406,574,'Leona'),(1408,574,'Ngueune Sarr'),(1410,574,'Sakal'),(1412,576,'Louga'),(1414,578,'Aoure'),(1416,578,'Bokiladji'),(1418,578,'Orkadiere'),(1420,580,'Ndendory'),(1422,580,'Wouro Sidy'),(1424,582,'Dembancane'),(1426,584,'Hamadi Hounare'),(1428,586,'Kanel'),(1430,588,'Ouaounde'),(1432,590,'Semme'),(1434,592,'Sinthiou Bamambe Banadji'),(1436,594,'Dabia'),(1438,594,'Des Agnam'),(1440,594,'Orefonde'),(1442,596,'Bokidiave'),(1444,596,'Nabadji Civol'),(1446,596,'Ogo '),(1448,598,'Matam'),(1450,600,'Ourossogui'),(1452,602,'Thilogne'),(1454,604,'Lougre Thioly'),(1456,604,'Oudalaye'),(1458,604,'Velingara Ranerou'),(1460,606,'Ranerou'),(1462,608,'Bokhol'),(1464,608,'Mbane'),(1466,610,'Diama'),(1468,610,'Gnith'),(1470,610,'Ronkh'),(1472,612,'Dagana'),(1474,614,'Gae '),(1476,616,'Richard Toll'),(1478,618,'Rosso Senegal'),(1480,620,'Doumga Lao'),(1482,620,'Madina Ndiathbe'),(1484,620,'Meri'),(1486,622,'Dodel'),(1488,622,'Gamadji Sare'),(1490,622,'Guede Village'),(1492,624,'Boke Dialloube'),(1494,624,'Mbolo Birane'),(1496,626,'Fanaye'),(1498,626,'Ndiayene Peindao'),(1500,628,'Aere Lao'),(1502,630,'Bode Lao'),(1504,632,'Demette'),(1506,634,'Galoya Toucouleur'),(1508,636,'Gollere'),(1510,638,'Guede Chantier'),(1512,640,'Mboumba'),(1514,642,'Ndioum'),(1516,644,'Niandane'),(1520,646,'Pete'),(1522,648,'Podor'),(1524,650,'Walalde'),(1526,652,'Fass Ngom'),(1528,652,'Gandon'),(1530,652,'Ndiebene Gandiole'),(1532,654,'Mpal'),(1534,656,'Saint Louis '),(1536,658,'Boghal'),(1538,658,'Ndiamacouta '),(1540,658,'Tankon'),(1542,660,'Bona'),(1544,660,'Diacounda'),(1546,660,'Inor'),(1548,660,'Kandion Mangana'),(1550,662,'Diambaty'),(1552,662,'Diaroume'),(1554,662,'Faoune'),(1556,664,'Bounkiling'),(1558,666,'Madina Wandifa'),(1560,668,'Djibanar'),(1562,668,'Kaour'),(1564,668,'Mangaroungou Santo'),(1566,668,'Simbandi Balante'),(1568,668,'Yarang Balante'),(1570,670,'Karantaba'),(1572,670,'Kolibantang '),(1574,672,'Baghere'),(1576,672,'Dioudoubou'),(1578,672,'Niagha'),(1580,672,'Simbandi Brassou'),(1582,674,'Diattacounda'),(1584,676,'Goundomp'),(1586,678,'Samine'),(1588,680,'Tanaff'),(1590,682,'Diannah Ba'),(1592,682,'Diende'),(1594,682,'Koussy'),(1596,682,'Oudoucar'),(1598,682,'Sakar'),(1600,682,'Same Kanta Peulh'),(1602,684,'Bemet Bidjini'),(1604,684,'Djibabouya'),(1606,684,'Sansamba'),(1608,686,'Bambali'),(1610,686,'Djiredji'),(1612,688,'Dianah Malary'),(1614,690,'Marsassoum'),(1616,692,'Sedhiou'),(1618,694,'Bele'),(1620,694,'Sinthiou Fissa'),(1622,696,'Gathiari'),(1624,696,'Madina Foulbe'),(1626,696,'Sadatou'),(1628,696,'Toumboura'),(1630,698,'Ballou'),(1632,698,'Gabou'),(1634,698,'Mouderi'),(1636,700,'Bakel'),(1638,702,'Diawara'),(1640,704,'Kidira'),(1642,706,'Bala'),(1644,706,'Goumbayel'),(1646,706,'Koar'),(1648,708,'Boynguel Bamba'),(1650,708,'Dougue'),(1652,708,'Koussan'),(1654,708,'Sinthiou Mamadou Boubou'),(1656,710,'Bani Israel '),(1658,710,'Boutoucoufara'),(1660,710,'Dianke Makha'),(1662,710,'Komoti'),(1664,712,'Koulor'),(1666,712,'Sinthiou Bocar Aly'),(1668,714,'Goudiry'),(1670,716,'Kothiary'),(1672,718,'Bamba Thialene'),(1674,718,'Kahene'),(1676,718,'Mereto'),(1678,718,'Ndam'),(1680,720,'Kouthia Gaydi'),(1682,720,'Kouthiaba Wolof'),(1684,720,'Pass Koto'),(1686,720,'Payar'),(1688,722,'Koumpentoum '),(1690,724,'Maleme Niani'),(1692,726,'Koussanar'),(1694,726,'Sinthiou Maleme'),(1696,728,'Makacolibantang'),(1698,728,'Ndoga Babacar'),(1700,728,'Niani Toucouleur'),(1702,730,'Dialokoto'),(1704,730,'Missirah'),(1706,730,'Netteboulou '),(1708,732,'Tambacounda '),(1710,734,'Fissel'),(1712,734,'Ndiaganiao'),(1714,736,'Ngueniene'),(1716,736,'Sandiara'),(1718,736,'Sessene'),(1720,738,'Diass'),(1722,738,'Malicounda'),(1724,738,'Sindia'),(1726,740,'Joal Fadiouth'),(1728,742,'Mbour'),(1730,744,'Ngaparou'),(1732,746,'Nguekhokh'),(1734,748,'Popenguine'),(1736,750,'Saly Portudal'),(1738,752,'Somone'),(1740,754,'Thiadiaye'),(1742,756,'Diender Guedji'),(1744,756,'Fandene'),(1746,756,'Keur Moussa '),(1748,758,'Notto'),(1750,758,'Tassette'),(1752,760,'Ndieyene Sirakh'),(1754,760,'Ngoundiane'),(1756,760,'Thienaba'),(1758,760,'Touba Toul'),(1760,762,'Thies Nord'),(1762,764,'Thies Est'),(1764,764,'Thies Ouest '),(1766,766,'Kayar'),(1768,768,'Khombole'),(1770,770,'Pout'),(1772,772,'Darou Khoudoss'),(1774,772,'Meouane'),(1776,772,'Taiba Ndiaye'),(1778,774,'Koul'),(1780,774,'Merina Dakhar'),(1782,774,'Pekesse'),(1784,776,'Mbayene'),(1786,776,'Ngandiouf'),(1788,776,'Niakhene'),(1790,776,'Thilmakha'),(1792,778,'Cherif Lo'),(1794,778,'Mont Rolland'),(1796,778,'Notto Gouye Diama'),(1798,778,'Pire Goureye'),(1800,780,'Mboro'),(1802,782,'Meckhe'),(1804,784,'Tivaouane'),(1806,786,'Djinaki'),(1808,786,'Kafountine'),(1810,786,'Kataba 1'),(1812,788,'Djibidione'),(1814,788,'Oulampane'),(1816,788,'Sindian'),(1818,788,'Suel'),(1820,790,'Balingore'),(1822,790,'Diegoune'),(1824,790,'Kartiack'),(1826,790,'Mangagoulack'),(1828,790,'Mlomp'),(1830,790,'Tendouck'),(1832,792,'Coubalan'),(1834,792,'Niamone'),(1836,792,'Ouonck'),(1838,792,'Tenghori'),(1840,794,'Bignona'),(1842,796,'Diouloulou'),(1844,798,'Thionck Essyl'),(1846,800,'Diembering'),(1848,800,'Santhiaba Manjaque'),(1850,802,'Mlomp'),(1852,802,'Oukout'),(1854,804,'Oussouye'),(1856,806,'Adeane'),(1858,806,'Boutoupa Camaracound'),(1860,806,'Niaguis'),(1862,808,'Enampor'),(1864,808,'Niassia'),(1866,810,'Ziguinchor');
/*!40000 ALTER TABLE `collectivite_senegal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departement_senegal`
--

DROP TABLE IF EXISTS `departement_senegal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departement_senegal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_region` bigint(20) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=351 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departement_senegal`
--

LOCK TABLES `departement_senegal` WRITE;
/*!40000 ALTER TABLE `departement_senegal` DISABLE KEYS */;
INSERT INTO `departement_senegal` VALUES (262,234,'Dakar'),(264,234,'Guediawaye'),(266,234,'Pikine'),(268,234,'Rufisque'),(270,236,'Bambey'),(272,236,'Diourbel'),(274,236,'Mbacke'),(276,238,'Fatick'),(278,238,'Foundiougne'),(280,238,'Gossas'),(282,240,'Birkilane'),(284,240,'Kaffrine'),(286,240,'Koungheul'),(288,240,'Malem Hodar'),(290,242,'Guinguineo'),(292,242,'Kaolack'),(294,242,'Nioro du Rip'),(296,244,'Kedougou'),(298,244,'Salemata'),(300,244,'Saraya'),(302,246,'Kolda'),(304,246,'Medina Yoro Foulah'),(306,246,'Velingara'),(308,248,'Kebemer'),(310,248,'Linguere'),(312,248,'Louga'),(314,250,'Kanel'),(316,250,'Matam'),(318,250,'Ranerou Ferlo'),(320,252,'Dagana'),(322,252,'Podor'),(324,252,'Saint Louis'),(326,254,'Bounkiling'),(328,254,'Goundomp'),(330,254,'Sedhiou'),(332,256,'Bakel'),(334,256,'Goudiry'),(336,256,'Koumpentoum'),(338,256,'Tambacounda'),(340,258,'Mbour'),(342,258,'Thies'),(344,258,'Tivaouane'),(346,260,'Bignona'),(348,260,'Oussouye'),(350,260,'Ziguinchor');
/*!40000 ALTER TABLE `departement_senegal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_organisation` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `x` varchar(10) DEFAULT NULL,
  `y` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,1,'IMAGERIE_MEDICALE','<p>RADIOLOGIE, SCANNER, ECHOGRAPHIE.</p>\r\n',NULL,NULL),(2,1,'GYNECOLOGIE','<p>CPN, CPON, SALLE D&#39;ACCOUCHEMENT, CONSULTATION GYNECHOLOGIQUE, PF.</p>\r\n',NULL,NULL),(3,1,'BIOLOGIE','<p>BACTERIOLOGIE, IMMUNOLOGIE...</p>\r\n',NULL,NULL),(4,3,'IMAGERIE_MEDICALE','<p>RADIOLOGIE, SCANNERE, CHOGRAPHIE.</p>\r\n',NULL,NULL),(5,3,'medecine generale zfs','',NULL,NULL),(6,3,'LABORATOIRE','<p>Regroupe les service Bact&eacute;riologie, Immunologie, H&eacute;matologie</p>\r\n',NULL,NULL),(7,4,'dep hopital RF','<p>f</p>\r\n',NULL,NULL),(8,8,'lll','<p>ll</p>\r\n',NULL,NULL);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostic_report`
--

DROP TABLE IF EXISTS `diagnostic_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnostic_report` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) DEFAULT NULL,
  `invoice` varchar(100) DEFAULT NULL,
  `report` varchar(10000) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostic_report`
--

LOCK TABLES `diagnostic_report` WRITE;
/*!40000 ALTER TABLE `diagnostic_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `diagnostic_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(10) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor`
--

LOCK TABLES `doctor` WRITE;
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` VALUES (3,NULL,'FAYE','drfaye@zuulunet.net','SENEGAL','0786006831','Radiologie','dr',NULL,NULL,'755'),(2,NULL,'Ibnou Abass Diagne','ino@zuulumed.net','Dakar','+221781156335','Radiologie','Administrateur',NULL,NULL,'743'),(4,NULL,'ino','Médecine Générale',NULL,'781156335',NULL,NULL,NULL,NULL,'760'),(5,'uploads/imgUsers/1_4_e733cc4d8caa90c8d3892a621bc94ebcae56e7fa128.jpg','Ousseynou Sy','ousseynou@zuulumed.net','Yoff','766459226',NULL,NULL,NULL,NULL,'766'),(6,'uploads/imgUsers/3_4_afro-samurai1.jpg','ibnou abass diagne','ibou@zuulu.net','Dakar','',NULL,NULL,NULL,NULL,'767'),(7,NULL,'dr fff dddddd','doc@zuulumed.net','SENEGAL','0786006831',NULL,NULL,NULL,NULL,'779');
/*!40000 ALTER TABLE `doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donor`
--

DROP TABLE IF EXISTS `donor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donor` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `group` varchar(10) DEFAULT NULL,
  `age` varchar(10) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `ldd` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `add_date` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donor`
--

LOCK TABLES `donor` WRITE;
/*!40000 ALTER TABLE `donor` DISABLE KEYS */;
INSERT INTO `donor` VALUES (1,'FAYE','A+','32','Male','14-10-2020','0786006831','rokhaya.faye@zuulu.net','10/14/20');
/*!40000 ALTER TABLE `donor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `message` varchar(10000) DEFAULT NULL,
  `reciepient` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
INSERT INTO `email` VALUES (1,'','1602711406','<p>{phone} hjhjhjhj</p>\r\n','rokhaya.faye@zuulu.net','1'),(2,'Un autre test','1603321038','<p>Ceci est un autre test!</p>\r\n','samba_diallo@yahoo.de','1');
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_settings`
--

DROP TABLE IF EXISTS `email_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_settings` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_settings`
--

LOCK TABLES `email_settings` WRITE;
/*!40000 ALTER TABLE `email_settings` DISABLE KEYS */;
INSERT INTO `email_settings` VALUES (1,'admin@zuulu.med',NULL,NULL,NULL);
/*!40000 ALTER TABLE `email_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_organisation` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `beneficiaire` varchar(255) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `heure` varchar(255) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `datestring` varchar(1000) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `numeroTransaction` varchar(255) DEFAULT NULL,
  `numeroFacture` varchar(255) DEFAULT NULL,
  `referenceClient` varchar(255) DEFAULT NULL,
  `codeType` varchar(255) NOT NULL,
  `codeFacture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=335 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense`
--

LOCK TABLES `expense` WRITE;
/*!40000 ALTER TABLE `expense` DISABLE KEYS */;
INSERT INTO `expense` VALUES (1,NULL,'securite',NULL,'1602712949',NULL,'10','10000','1','14/10/20',1,NULL,NULL,NULL,'codeCourante',NULL),(2,NULL,'sdfsdfs',NULL,'1602713945',NULL,'10','780','1','14/10/20',1,NULL,NULL,NULL,'codeCourante',NULL),(309,NULL,'Honoraires Medecin',NULL,'1603716649',NULL,'test ','500','1','26/10/20 12:50',1,NULL,NULL,NULL,'codeCourante',NULL),(261,NULL,'Honoraires Medecin',NULL,'1603379072',NULL,'TEST argent','.','1','22/10/20',1,NULL,NULL,NULL,'codeCourante',NULL),(263,NULL,'Honoraires Medecin','Ngone Sall 775740533','1603406535',NULL,'Test dépense avec Bénéficiaire','50000','1','22/10/20',1,NULL,NULL,NULL,'codeCourante',NULL),(264,NULL,'Paiement livreur','Absa Ngom 89434855900','1603406659',NULL,'Test dépense avec Bénéficiaire','50000','1','22/10/20',1,NULL,NULL,NULL,'codeCourante',NULL),(300,NULL,'Avance Salaire','Ibnou Abass Diagne +221781156335','1603472247',NULL,'','50000','1','23/10/20 16:57',1,NULL,NULL,NULL,'codeCourante',NULL),(303,NULL,'Achat Woyofal','781156335','1603495783',NULL,'6998-5621-3471-5927-7131','1000','1','23/10/20 23:29',2,'221-0018208-01',NULL,NULL,'Achat Woyofal',NULL),(281,NULL,'Paiement livreur','Mamadou Wathie +221781156335','1603458838',NULL,'Transport','500','1','23/10/20 13:13',1,NULL,NULL,NULL,'codeCourante',NULL),(297,NULL,'Paiement Senelec','021027346061','1603466109',NULL,'7500212552','900','1','23/10/20 15:15',2,'221-0018205-01','7500212552','021027346061','Paiement Senelec',NULL),(285,NULL,'Paiement SenEau','ALBINO MENDY PLLE N8 LOT 49 DJIDDAH QUT A.N','1603461528',NULL,'221-0018199-01','808','1','23/10/20 13:58:48',2,NULL,NULL,NULL,'Paiement SenEau',NULL),(296,NULL,'Paiement SenEau','KANE FATOU DIEYE','1603465613',NULL,'10000105001347801081801','4040','1','23/10/20 15:06',2,'221-0018204-01','10000105001347801081801','105001347821','Paiement SenEau',NULL),(288,NULL,'Paiement SenEau','MPANGA ADA FLORA OTILIA  1/ A DROITE','1603463445',NULL,'221-0018200-01','3232','1','23/10/20 14:30',2,NULL,NULL,NULL,'Paiement SenEau',NULL),(314,NULL,'Achat Woyofal','221781156335','1603731040',NULL,'0794-1556-7201-1743-1613','1000','1','26/10/20 16:50',2,'221-0018226-01',NULL,NULL,'Achat Woyofal',NULL),(315,NULL,'Frais Transport','Aucun','1603733308',NULL,'','500','1','26/10/20 17:28',1,NULL,NULL,NULL,'codeCourante',NULL),(316,NULL,'Carburant','henry Gomis (+221) 77 565 65 65','1603733495',NULL,'','500','1','26/10/20 17:31',1,NULL,NULL,NULL,'codeCourante',NULL),(317,NULL,'Honoraires medecin','Ngone Sall 775740533','1603751957',NULL,'Heure supplémentaire','500','1','26/10/20 22:39',1,NULL,NULL,NULL,'codeCourante',NULL),(318,NULL,'Achat Carton','','1603752019',NULL,'','500','1','26/10/20 22:40',1,NULL,NULL,NULL,'codeCourante',NULL),(322,NULL,'Achat Crédit','221781156335','1603753889','23:11:29','221-0018230-01','100','1','26/10/20 23:11',2,'221-0018230-01',NULL,NULL,'Achat Crédit',NULL),(320,NULL,'Paiement Senelec','021027346061','1603752428',NULL,'9530368757','1000','1','26/10/20 22:47',2,'221-0018228-01','9530368757','021027346061','Paiement Senelec',NULL),(321,NULL,'Paiement SenEau','HLM NIMZATT','1603752482',NULL,'10500105000183201071802','2806','1','26/10/20 22:48',2,'221-0018229-01','10500105000183201071802','105000183213','Paiement SenEau',NULL),(323,NULL,'Achat Crédit','221781156335','1603754740','23:25:40','221-0018235-01','100','1','26/10/20 23:25',2,'221-0018235-01',NULL,NULL,'Achat Crédit',NULL),(324,NULL,'Avance Salaire','Ibnou Abass Diagne +221781156335','1603754802',NULL,'prime','50000','1','26/10/20 23:26',1,NULL,NULL,NULL,'codeCourante',NULL),(325,NULL,'entretien rf zfs','Ibnou Abass Diagne +221781156335','1604492752',NULL,'','50000','1','04/11/20 12:25',1,NULL,NULL,NULL,'codeCourante',NULL),(326,NULL,'catego hopt RF','Aicha  00221781156335','1604493134',NULL,'10','11111','769','04/11/20 12:32',1,NULL,NULL,NULL,'codeCourante',NULL),(327,'3','Carburant','Ino Diagne (+221) 78 115 63 35','1604497257',NULL,'','50000','1','04/11/20 13:40',1,NULL,NULL,NULL,'codeCourante',NULL),(328,'4','Frais Transport','Boune Dione (+221) 78 115 63 35','1604497923',NULL,'','50000','769','04/11/20 13:52',1,NULL,NULL,NULL,'codeCourante',NULL),(329,NULL,'Achat Crédit','221781156335','1604533117','23:38:37','221-0018244-01','100','1','04/11/20 23:38',2,'221-0018244-01',NULL,NULL,'Achat Crédit',NULL),(330,'3','Achat Crédit','221781156335','1604534954','00:09:13','221-0018247-01','100','1','05/11/20 00:09',2,'221-0018247-01',NULL,NULL,'Achat Crédit',NULL),(331,'4','Achat Crédit','221760250303','1604535022','00:10:21','221-0018248-01','100','769','05/11/20 00:10',2,'221-0018248-01',NULL,NULL,'Achat Crédit',NULL),(332,'4','Achat Crédit','221760250303','1604537012','00:43:32','221-0018249-01','100','769','05/11/20 00:43',2,'221-0018249-01',NULL,NULL,'Achat Crédit',NULL),(333,'4','catego hopt RF','Boune Dione (+221) 78 115 63 35','1604537047',NULL,'','500','769','05/11/20 00:44',1,NULL,NULL,NULL,'codeCourante',NULL),(334,'8','cat test','FAYE ROKHAYA (+221) 78 600 68 31','1604743443',NULL,'','500','778','07/11/20 10:04',1,NULL,NULL,NULL,'codeCourante','R-008-0001');
/*!40000 ALTER TABLE `expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_category`
--

DROP TABLE IF EXISTS `expense_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_category`
--

LOCK TABLES `expense_category` WRITE;
/*!40000 ALTER TABLE `expense_category` DISABLE KEYS */;
INSERT INTO `expense_category` VALUES (69,'Honoraires medecin','honoraires du medecin',NULL,NULL,NULL,1,NULL),(68,'Avance Salaire','Avance Salaire mois Octobre',NULL,NULL,NULL,1,NULL),(65,'Détergent','Détergent',NULL,NULL,NULL,1,NULL),(66,'Frais Transport','Frais Transport',NULL,NULL,NULL,1,NULL),(67,'Carburant','Carburant',NULL,NULL,NULL,1,NULL),(70,'Balais Serpillère','Balais Serpillère',NULL,NULL,NULL,1,NULL),(71,'Transport','Transport Bagage',NULL,NULL,NULL,1,NULL),(72,'Repas','repas de midi',NULL,NULL,NULL,1,NULL),(73,'Entretien Vehicule','toutes les dépenses liées a l\'entretien des véhicules',NULL,NULL,NULL,1,NULL),(74,'entretien rf zfs','test rf fs',NULL,NULL,NULL,1,3),(75,'catego hopt RF','secur',NULL,NULL,NULL,1,4),(76,'Carburant','Carburant',NULL,NULL,NULL,1,3),(77,'Frais Transport','Frais Transport',NULL,NULL,NULL,1,4),(78,'cat test','ft',NULL,NULL,NULL,1,8);
/*!40000 ALTER TABLE `expense_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `featured`
--

DROP TABLE IF EXISTS `featured`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `featured` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(1000) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `profile` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `featured`
--

LOCK TABLES `featured` WRITE;
/*!40000 ALTER TABLE `featured` DISABLE KEYS */;
INSERT INTO `featured` VALUES (1,'uploads/mobama14.jpeg','Docteur OBAMA','Biologiste, Diplomé','<p>A votre Service</p>\r\n');
/*!40000 ALTER TABLE `featured` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `label_fr` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admin','Administrator','Administrateur'),(2,'members','General User','Membre'),(3,'Accountant','For Financial Activities','Comptable'),(4,'Doctor','','Médecin'),(5,'Patient','','Patient'),(6,'Nurse','','Infirmière'),(7,'Pharmacist','','Pharmacien'),(8,'Laboratorist','','Biologiste Médical'),(10,'Receptionist','Receptionist','Réceptionniste');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `holidays` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `doctor` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
INSERT INTO `holidays` VALUES (1,'2','1602720000',NULL,NULL);
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurance`
--

DROP TABLE IF EXISTS `insurance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `insurance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insurance_name` varchar(255) DEFAULT NULL,
  `discount` int(50) DEFAULT NULL,
  `remark` text,
  `insurance_no` varchar(50) DEFAULT NULL,
  `insurance_code` varchar(50) DEFAULT NULL,
  `disease_charge` text COMMENT 'array(name, charge)',
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurance`
--

LOCK TABLES `insurance` WRITE;
/*!40000 ALTER TABLE `insurance` DISABLE KEYS */;
INSERT INTO `insurance` VALUES (1,'axa',10,'','hjgj10','hkhk','{\"1\":\"4555\"}',1),(2,'ipres',10,'','hjgj10','hkhk','{\"1\":\"4555\"}',1);
/*!40000 ALTER TABLE `insurance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab`
--

DROP TABLE IF EXISTS `lab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_organisation` int(11) DEFAULT NULL,
  `numero_demande` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `id_organisation_source_demande` int(11) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `category_name` varchar(1000) DEFAULT NULL,
  `report` varchar(10000) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `patient_phone` varchar(100) DEFAULT NULL,
  `patient_address` varchar(100) DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `date_string` varchar(100) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab`
--

LOCK TABLES `lab` WRITE;
/*!40000 ALTER TABLE `lab` DISABLE KEYS */;
INSERT INTO `lab` VALUES (1,NULL,'',NULL,'2',NULL,'2','1602633600',NULL,'<table align=\"center\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\">\r\n<thead>\r\n<tr>\r\n<th scope=\"col\">Head 1</th>\r\n<th scope=\"col\">Head 2</th>\r\n<th scope=\"col\">Head 3</th>\r\n<th scope=\"col\">Head 4</th>\r\n<th scope=\"col\">Head 5</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>102</td>\r\n<td>20</td>\r\n<td>30</td>\r\n<td>1</td>\r\n<td>2</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'1','cheikh ahmed diagne','+221781156335','Cite enseignant','Ibnou Abass Diagne','14-10-20',NULL),(2,NULL,'',NULL,'2',NULL,'2','1602633600',NULL,'<table align=\"center\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\" summary=\"Result Of Lipid Profile \">\r\n<caption>Lipid Profile Result</caption>\r\n<tbody>\r\n<tr>\r\n<td>SL</td>\r\n<td>&nbsp;Test Name</td>\r\n<td>Test Result</td>\r\n<td>&nbsp;Reference Valur</td>\r\n<td>Comment</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;1</td>\r\n<td>&nbsp;Lipid Profile</td>\r\n<td>&nbsp; &nbsp; 100</td>\r\n<td>&nbsp;&gt;10 &lt; 150</td>\r\n<td>&nbsp;Normal</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;2</td>\r\n<td>Lipid Profile</td>\r\n<td>&nbsp; &nbsp; 100</td>\r\n<td>&gt;10 &lt; 150</td>\r\n<td>&nbsp;Normal</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;3</td>\r\n<td>&nbsp;Lipid Profile</td>\r\n<td>&nbsp; &nbsp; 100</td>\r\n<td>&gt;10 &lt; 150</td>\r\n<td>&nbsp;Normal</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;4</td>\r\n<td>Lipid Profile</td>\r\n<td>&nbsp; &nbsp; 100</td>\r\n<td>&gt;10 &lt; 150</td>\r\n<td>&nbsp;Normal</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'1','cheikh ahmed diagne','+221781156335','Cite enseignant','Ibnou Abass Diagne','14-10-20',NULL),(3,NULL,'',NULL,'2',NULL,'3','1602892800',NULL,'<p>popo</p>\r\n\r\n<table align=\"center\" border=\"1\" cellpadding=\"1\" cellspacing=\"1\" summary=\"Result Of Lipid Profile \">\r\n<caption>Lipid Profile Result</caption>\r\n<tbody>\r\n<tr>\r\n<td>SL</td>\r\n<td>&nbsp;Test Name</td>\r\n<td>Test Result</td>\r\n<td>&nbsp;Reference Valur</td>\r\n<td>Comment</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;1</td>\r\n<td>&nbsp;Lipid Profile</td>\r\n<td>&nbsp; &nbsp; 100</td>\r\n<td>&nbsp;&gt;10 &lt; 155</td>\r\n<td>&nbsp;Normal</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;2</td>\r\n<td>Lipid Profile</td>\r\n<td>&nbsp; &nbsp; 100</td>\r\n<td>&gt;10 &lt; 150</td>\r\n<td>&nbsp;Normal</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;3</td>\r\n<td>&nbsp;Lipid Profile</td>\r\n<td>&nbsp; &nbsp; 100</td>\r\n<td>&gt;10 &lt; 150</td>\r\n<td>&nbsp;Normal</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;4</td>\r\n<td>Lipid Profile</td>\r\n<td>&nbsp; &nbsp; 100</td>\r\n<td>&gt;10 &lt; 150</td>\r\n<td>&nbsp;Normal</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'1','cheikh ahmed diagne','+221781156335','Cite enseignant','FAYE','17-10-20',NULL),(11,NULL,NULL,NULL,'1',NULL,'3','1603843200',NULL,'',NULL,'1','Shaibal Saha','1711111111','Debidwar,comilla','FAYE','28-10-20',NULL),(12,NULL,NULL,NULL,'2',NULL,'3','1603843200',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n<caption>Tests de diagnostic rapide du paludisme (TDR)</caption>\r\n<thead>\r\n<tr>\r\n<th scope=\"col\">Antig&egrave;ne</th>\r\n<th scope=\"col\">HRP2</th>\r\n<th scope=\"col\">pLDH</th>\r\n<th scope=\"col\">Aldolase</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>&nbsp;</p>\r\n</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n',NULL,'1','cheikh ahmed diagne','+221781156335','Cite enseignant','FAYE','28-10-20',NULL),(13,NULL,NULL,NULL,'2',NULL,'3','1603929600',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n	<caption>Tests de diagnostic rapide du paludisme (TDR)</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Antig&egrave;ne</th>\r\n			<th scope=\"col\">HRP2</th>\r\n			<th scope=\"col\">pLDH</th>\r\n			<th scope=\"col\">Aldolase</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>&nbsp;</p>\r\n			</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n',NULL,'1','cheikh ahmed diagne','+221781156335','Cite enseignant','FAYE','29-10-20',NULL),(14,NULL,NULL,NULL,'6',NULL,'2','1604275200',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<caption>R&Eacute;SULTATS DES ANALYSES</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Analyse(s) Demand&eacute;es</th>\r\n			<th scope=\"col\">R&eacute;sultats</th>\r\n			<th scope=\"col\">Unit&eacute;</th>\r\n			<th scope=\"col\">Valeurs Usuelles</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>H&eacute;moglobine Glyqu&eacute;e</td>\r\n			<td>5,7</td>\r\n			<td>%</td>\r\n			<td>4,2 &agrave; 6,4</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'768','Jane','708971243','Keur Massar','Ibnou Abass Diagne','02-11-20',NULL),(15,NULL,NULL,NULL,'3',NULL,NULL,'1604275200',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<caption>R&Eacute;SULTATS DES ANALYSES</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Analyse(s) Demand&eacute;es</th>\r\n			<th scope=\"col\">R&eacute;sultats</th>\r\n			<th scope=\"col\">Unit&eacute;</th>\r\n			<th scope=\"col\">Valeurs Usuelles</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>Test 1</td>\r\n			<td>3</td>\r\n			<td>%</td>\r\n			<td>2,4-5</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Test 2</td>\r\n			<td>2</td>\r\n			<td>mg/l</td>\r\n			<td>xx</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'1','Mina Diagne','+221781156335','Dakar','0','02-11-20',NULL),(16,NULL,NULL,NULL,'15',NULL,NULL,'1604534400',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<caption>R&Eacute;SULTATS DES ANALYSES</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Analyse(s) Demand&eacute;es</th>\r\n			<th scope=\"col\">R&eacute;sultats</th>\r\n			<th scope=\"col\">Unit&eacute;</th>\r\n			<th scope=\"col\">Valeurs Usuelles</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>TEST</td>\r\n			<td>OK</td>\r\n			<td>%</td>\r\n			<td>OK</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'1','FAYE hopital zfs','0786006831','SENEGAL','0','05-11-20',NULL),(17,1,NULL,NULL,'25',NULL,'5','1591833600',NULL,'<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<caption>R&Eacute;SULTATS DES ANALYSES</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Analyse(s) Demand&eacute;es</th>\r\n			<th scope=\"col\">R&eacute;sultats</th>\r\n			<th scope=\"col\">Unit&eacute;</th>\r\n			<th scope=\"col\">Valeurs Usuelles</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>abc</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>def</p>\r\n			</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'761','NoName','766459226','Villa Khadija, Rte de Ngor','Ousseynou Sy','11/06/2020','F-001-0001'),(18,3,NULL,NULL,'15',NULL,'2','1594425600',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<caption>R&Eacute;SULTATS DES ANALYSES</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Analyse(s) Demand&eacute;es</th>\r\n			<th scope=\"col\">R&eacute;sultats</th>\r\n			<th scope=\"col\">Unit&eacute;</th>\r\n			<th scope=\"col\">Valeurs Usuelles</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'1','FAYE hopital zfs','0786006831','SENEGAL','Ibnou Abass Diagne','11/07/2020','F-003-0001'),(19,8,NULL,NULL,'26',NULL,NULL,'1594425600',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n	<caption>Tests de diagnostic rapide du paludisme (TDR)</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Antig&egrave;ne</th>\r\n			<th scope=\"col\">HRP2</th>\r\n			<th scope=\"col\">pLDH</th>\r\n			<th scope=\"col\">Aldolase</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p>df</p>\r\n			</td>\r\n			<td>10</td>\r\n			<td>df</td>\r\n			<td>df</td>\r\n		</tr>\r\n		<tr>\r\n			<td>fg</td>\r\n			<td>2</td>\r\n			<td>2</td>\r\n			<td>2</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n',NULL,'778','laboo','0786006831','SENEGAL','0','11/07/2020','F-008-0001'),(20,3,NULL,NULL,'19',NULL,NULL,'1594425600',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Cause de l&#39;an&eacute;mie</th>\r\n			<th scope=\"col\">Type d&#39;an&eacute;mie</th>\r\n			<th scope=\"col\">Diagnostic &eacute;tiologique</th>\r\n			<th scope=\"col\">Traitement Sp&eacute;cifique</th>\r\n			<th scope=\"col\">Risque chez le demandeur</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>,m,m</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'1','aida','0786006831','SENEGAL','0','11/07/2020','F-003-0002'),(21,4,NULL,NULL,'16',NULL,NULL,'1594425600',NULL,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Cause de l&#39;an&eacute;mie</th>\r\n			<th scope=\"col\">Type d&#39;an&eacute;mie</th>\r\n			<th scope=\"col\">Diagnostic &eacute;tiologique</th>\r\n			<th scope=\"col\">Traitement Sp&eacute;cifique</th>\r\n			<th scope=\"col\">Risque chez le demandeur</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n',NULL,'769','FAYE hopital RF','0786006831','SENEGAL','0','11/07/2020','F-004-0001');
/*!40000 ALTER TABLE `lab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lab_category`
--

DROP TABLE IF EXISTS `lab_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lab_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `reference_value` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lab_category`
--

LOCK TABLES `lab_category` WRITE;
/*!40000 ALTER TABLE `lab_category` DISABLE KEYS */;
INSERT INTO `lab_category` VALUES (35,'Troponin-I','Pathological Test',''),(36,'CBC (DIGITAL)','Pathological Test',''),(37,'Eosinophil','Pathological Test',''),(38,'Platelets','Pathological Test',''),(39,'Malarial Parasites (MP)','Pathological Test',''),(40,'BT/ CT','Pathological Test',''),(41,'ASO Titre','Pathological Test',''),(42,'CRP','Pathological Test',''),(43,'R/A test','Pathological Test',''),(44,'VDRL','Pathological Test',''),(45,'TPHA','Pathological Test',''),(46,'HBsAg (Screening)','Pathological Test',''),(47,'HBsAg (Confirmatory)','Pathological Test',''),(48,'CFT for Kala Zar','Pathological Test',''),(49,'CFT for Filaria','Pathological Test',''),(50,'Pregnancy Test','Pathological Test',''),(51,'Blood Grouping','Pathological Test',''),(52,'Widal Test','Pathological Test','(70-110)mg/dl'),(53,'RBS','Pathological Test',''),(54,'Blood Urea','Pathological Test',''),(55,'S. Creatinine','Pathological Test',''),(56,'S. cholesterol','Pathological Test',''),(57,'Fasting Lipid Profile','Pathological Test',''),(58,'S. Bilirubin','Pathological Test',''),(59,'S. Alkaline Phosohare','Pathological Test',''),(61,'S. Calcium','Pathological Test',''),(62,'RBS with CUS','Pathological Test',''),(63,'SGPT','Pathological Test',''),(64,'SGOT','Pathological Test',''),(65,'Urine for R/E','Pathological Test',''),(66,'Urine C/S','Pathological Test',''),(67,'Stool for R/E','Pathological Test',''),(68,'Semen Analysis','Pathological Test',''),(69,'S. Electrolyte','Pathological Test',''),(70,'S. T3/ T4/ THS','Pathological Test',''),(71,'MT','Pathological Test',''),(106,'ESR','Patho Test',''),(107,'FBS CUS','Pathological test',''),(108,'Hb%','Pathological test',''),(114,'2HABF','Pathological test',''),(113,'FBS','Pathological test',''),(115,'S. TSH','Pathological test',''),(116,'S. T3','Pathological test',''),(117,'DC','Pathological test',''),(118,'TC','Pathological test',''),(120,'S. Uric acid','Pathological test',''),(126,'eosinphil','Pathology Test','');
/*!40000 ALTER TABLE `lab_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laboratorist`
--

DROP TABLE IF EXISTS `laboratorist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `laboratorist` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laboratorist`
--

LOCK TABLES `laboratorist` WRITE;
/*!40000 ALTER TABLE `laboratorist` DISABLE KEYS */;
INSERT INTO `laboratorist` VALUES (1,NULL,'Rawane Diagne','laboratoire@zuulumed.net','Cité des enseignants','+221781156335',NULL,NULL,'748');
/*!40000 ALTER TABLE `laboratorist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
INSERT INTO `login_attempts` VALUES (65,'102.164.151.57','alassane.sarr@zuulumed.net',1604747371);
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manual_email_template`
--

DROP TABLE IF EXISTS `manual_email_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manual_email_template` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manual_email_template`
--

LOCK TABLES `manual_email_template` WRITE;
/*!40000 ALTER TABLE `manual_email_template` DISABLE KEYS */;
INSERT INTO `manual_email_template` VALUES (7,'vddfvdf','<p>dvdfvdfvdfvd</p>\r\n','email');
/*!40000 ALTER TABLE `manual_email_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manual_sms_template`
--

DROP TABLE IF EXISTS `manual_sms_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manual_sms_template` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `message` varchar(1000) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manual_sms_template`
--

LOCK TABLES `manual_sms_template` WRITE;
/*!40000 ALTER TABLE `manual_sms_template` DISABLE KEYS */;
INSERT INTO `manual_sms_template` VALUES (1,'test','{firstname} come to my offce {lastname}','sms'),(8,'dsdsdss3wew454','{firstname}{address}{phone}{address}{email}{name}{lastname}{firstname}','sms'),(3,'sdgfgfdgfdgdf','<p>{email}{instructor}{address} gfdgdfg</p>\r\n','email'),(7,'test223','<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width: 500px;\">\r\no<tbody>\r\no<tr>\r\no<td>dsfsf</td>\r\no<td>sdfsdf</td>\r\no</tr>\r\no<tr>\r\no<td>sdfdsf</td>\r\no<td>dfdsf</td>\r\no</tr>\r\no<tr>\r\no<td>dfdf</td>\r\no<td>dfdfd</td>\r\no</tr>\r\no</tbody>\r\n</table>\r\n{email}{instructor}','email');
/*!40000 ALTER TABLE `manual_sms_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manualemailshortcode`
--

DROP TABLE IF EXISTS `manualemailshortcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manualemailshortcode` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manualemailshortcode`
--

LOCK TABLES `manualemailshortcode` WRITE;
/*!40000 ALTER TABLE `manualemailshortcode` DISABLE KEYS */;
INSERT INTO `manualemailshortcode` VALUES (1,'{firstname}','email'),(2,'{lastname}','email'),(3,'{name}','email'),(6,'{address}','email'),(7,'{company}','email'),(8,'{email}','email'),(9,'{phone}','email');
/*!40000 ALTER TABLE `manualemailshortcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manualsmsshortcode`
--

DROP TABLE IF EXISTS `manualsmsshortcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manualsmsshortcode` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) DEFAULT NULL,
  `type` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manualsmsshortcode`
--

LOCK TABLES `manualsmsshortcode` WRITE;
/*!40000 ALTER TABLE `manualsmsshortcode` DISABLE KEYS */;
INSERT INTO `manualsmsshortcode` VALUES (1,'{firstname}','sms'),(2,'{lastname}','sms'),(3,'{name}','sms'),(4,'{email}','sms'),(5,'{phone}','sms'),(6,'{address}','sms'),(10,'{company}','sms');
/*!40000 ALTER TABLE `manualsmsshortcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_history`
--

DROP TABLE IF EXISTS `medical_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medical_history` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(100) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(10000) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `patient_address` varchar(500) DEFAULT NULL,
  `patient_phone` varchar(100) DEFAULT NULL,
  `img_url` varchar(500) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `registration_time` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_history`
--

LOCK TABLES `medical_history` WRITE;
/*!40000 ALTER TABLE `medical_history` DISABLE KEYS */;
INSERT INTO `medical_history` VALUES (1,'2',NULL,'Radio','<p>Radio</p>\r\n','cheikh ahmed diagne','Cite enseignant','+221781156335',NULL,'1602720000',NULL),(2,'3',NULL,'Consultation','<p>Consultation&nbsp;</p>\r\n','Mina Diagne','Dakar','+221781156335',NULL,'1602712603',NULL),(3,'8',NULL,'Test Case','<p>This is a test case</p>\r\n','Bouba','Medina','707653425',NULL,'1603152000',NULL),(4,'14',NULL,'Cas No 1','<p>Je decris ce cas</p>\r\n','Joseph','Kaolack','765438754',NULL,'1603843200',NULL),(5,'13',NULL,'Prise en charge 1','<p>20/10/2020 Expliquer pq le patient est la</p>\r\n\r\n<p>29/10/2020 Aspirine</p>\r\n\r\n<p>&nbsp;</p>\r\n','Getrude','Kaolack','784321234',NULL,'1603843200',NULL);
/*!40000 ALTER TABLE `medical_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine`
--

DROP TABLE IF EXISTS `medicine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medicine` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `price` varchar(100) DEFAULT NULL,
  `box` varchar(100) DEFAULT NULL,
  `s_price` varchar(100) DEFAULT NULL,
  `quantity` int(100) DEFAULT NULL,
  `generic` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `effects` varchar(100) DEFAULT NULL,
  `e_date` varchar(70) DEFAULT NULL,
  `add_date` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine`
--

LOCK TABLES `medicine` WRITE;
/*!40000 ALTER TABLE `medicine` DISABLE KEYS */;
INSERT INTO `medicine` VALUES (1,'napa extra',NULL,'30','44','35',1999,'Pracetimol','Square','dsdsds','16-08-2020','14/10/20'),(2,'paracetamol','scanner','1000','','2000',100,'paracetamol','','','18-12-2020','10/14/20');
/*!40000 ALTER TABLE `medicine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine_category`
--

DROP TABLE IF EXISTS `medicine_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medicine_category` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine_category`
--

LOCK TABLES `medicine_category` WRITE;
/*!40000 ALTER TABLE `medicine_category` DISABLE KEYS */;
INSERT INTO `medicine_category` VALUES (1,'scanner','secur'),(2,'scanner','secur');
/*!40000 ALTER TABLE `medicine_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting`
--

DROP TABLE IF EXISTS `meeting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `patient` varchar(100) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `topic` varchar(1000) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `start_time` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `meeting_id` varchar(100) DEFAULT NULL,
  `meeting_password` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `time_slot` varchar(100) DEFAULT NULL,
  `s_time` varchar(100) DEFAULT NULL,
  `e_time` varchar(100) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `add_date` varchar(100) DEFAULT NULL,
  `registration_time` varchar(100) DEFAULT NULL,
  `s_time_key` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `request` varchar(100) DEFAULT NULL,
  `patientname` varchar(1000) DEFAULT NULL,
  `doctorname` varchar(1000) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  `doctor_ion_id` varchar(100) DEFAULT NULL,
  `patient_ion_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting`
--

LOCK TABLES `meeting` WRITE;
/*!40000 ALTER TABLE `meeting` DISABLE KEYS */;
/*!40000 ALTER TABLE `meeting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meeting_settings`
--

DROP TABLE IF EXISTS `meeting_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meeting_settings` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(100) DEFAULT NULL,
  `secret_key` varchar(100) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meeting_settings`
--

LOCK TABLES `meeting_settings` WRITE;
/*!40000 ALTER TABLE `meeting_settings` DISABLE KEYS */;
INSERT INTO `meeting_settings` VALUES (1,'USib-YODRTuR2irNcfzJVw','I9HQAYDkAeZRRp5Hw9aVQPsgQSGdSwNzxbob','1',NULL);
/*!40000 ALTER TABLE `meeting_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notice`
--

DROP TABLE IF EXISTS `notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notice` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notice`
--

LOCK TABLES `notice` WRITE;
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` VALUES (1,'Premiere Note','<p>Faudra informer tous les patients</p>\r\n','1602892800','staff');
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nurse`
--

DROP TABLE IF EXISTS `nurse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nurse` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  `z` varchar(100) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nurse`
--

LOCK TABLES `nurse` WRITE;
/*!40000 ALTER TABLE `nurse` DISABLE KEYS */;
INSERT INTO `nurse` VALUES (1,NULL,'Fatou Binetou Diagne','fifi@gmail.com','Cite enseignant','+221781156335',NULL,NULL,NULL,'746'),(2,NULL,'FAYE ROKHAYA','infirmiere@zuulumed.net','SENEGAL','0786006831',NULL,NULL,NULL,'749');
/*!40000 ALTER TABLE `nurse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organisation`
--

DROP TABLE IF EXISTS `organisation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organisation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `nom_commercial` varchar(255) DEFAULT NULL,
  `path_logo` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `arrondissement` varchar(255) NOT NULL,
  `collectivite` varchar(255) NOT NULL,
  `pays` varchar(255) DEFAULT 'Sénégal',
  `email` varchar(255) NOT NULL,
  `numero_fixe` varchar(45) DEFAULT NULL,
  `prenom_responsable_legal` varchar(255) DEFAULT NULL,
  `nom_responsable_legal` varchar(255) DEFAULT NULL,
  `portable_responsable_legal` varchar(45) DEFAULT NULL,
  `fonction_responsable_legal` varchar(45) DEFAULT NULL,
  `description_courte_responsable_legal` varchar(255) DEFAULT NULL,
  `prenom_responsable_legal2` varchar(255) DEFAULT NULL,
  `nom_responsable_legal2` varchar(255) DEFAULT NULL,
  `portable_responsable_legal2` varchar(255) DEFAULT NULL,
  `fonction_responsable_legal2` varchar(45) DEFAULT NULL,
  `description_courte_responsable_legal2` varchar(45) DEFAULT NULL,
  `id_partenaire_zuuluPay` varchar(20) NOT NULL,
  `pin_partenaire_zuuluPay_encrypted` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `est_active` int(1) DEFAULT '0',
  `date_creation` int(11) NOT NULL,
  `date_mise_a_jour` int(11) DEFAULT NULL,
  `description_courte_activite` varchar(255) DEFAULT NULL,
  `description_courte_services` varchar(255) DEFAULT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `horaires_ouverture` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisation`
--

LOCK TABLES `organisation` WRITE;
/*!40000 ALTER TABLE `organisation` DISABLE KEYS */;
INSERT INTO `organisation` VALUES (1,'001','Centre Médical Ademis','Centre Médical Ademis','uploads/logosPartenaires/2214020000_2214020000221402000022.png','Camberene','Dakar','Dakar','Parcelles Assainies','Camberene','Senegal','kheush@hotmail.com','337967967696','Pape Amadou','Niang Diallo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2214020000','a49147d7df0b36a5419906fcf2b83f22c16d6715f45c2f237ad3dfd79397f71f79061167910e9d91fa38bf948770329e5a19d30401927002efd9b05a7facb2ebQkigjIGnSdFFjaKlunLhW8aV3bzIuYBcb8QmPGHFqp4=','Clinique',1,1603608869,1603886010,NULL,NULL,NULL,NULL),(2,'002','Orozen','Orozen Dental Spa','uploads/logosPartenaires/1234567890_orozen.jpg','Sherbrooke','Ziguinchor','Ziguinchor','Ziguinchor (Commune)','Ziguinchor','Senegal','admin@orozen.net','33765442663884','Alexandra','Tanguy',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1234567890','954853f036443de5b294e7d25a9d2804b0c136de7974f81728fc35870d7e50a6cf91cf6e01ee256ad5d48f5ce1a2596aab41ff8942df04eae58db55c15822405YypnjO0zutEfDdcfTDXUz18/uyvwTIZNgJaSfAAljaU=','Clinique',1,1603645786,NULL,NULL,NULL,NULL,NULL),(3,'003','Hopital ZFS','Hopital  ZFS','uploads/logosPartenaires/2214770000_2214050000.png','Rond Point Central','Dakar','Dakar','Grand Dakar','Biscuiterie ','Senegal','ramata@zuulumed.net','','Ramata','Fall','','Responsable Finances','Consultant Santé Digitale','Samba','Diallo','','CEO','Consultant Santé Digitale','2214770000','1ff8373ac62028ff7f1b36f45ddd56771060832ff3a8daa39369221f30637bd5140cdfcf1aaff6cbb595a883c2d01ec42318eb356f4cdd5d2e4f797851d54a1eHrxPL74Xk0HKd1eam+sidb11b5DatroiaFJrBE24Tag=','Clinique',1,1603884596,1604753352,'Laboratoire de Finance Digitale','Fiable-Rapide-Sécurisé-RF','Votre santé digitalisée-RF','<p>Lundi - Dimanche: 07:00 - 18:00</p>\r\n'),(4,'004','Hopital RF--','RF','uploads/logosPartenaires/2214020000_logo.png','THIES','Diourbel','Bambey','Baba Garage','Baba Garage ','Senegal','admin@rf.fr','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2214020000','063c8ad49f6073d29474176e5030fb5e0bbee9b6704463c5e4de68b72d57c8e2e60efffeab72aaeeee8fd3245dc8f01458b3e6d1e5253c1b5dac8c9b8bb49f69daTI6O0ySaNId9wFPsYTktL3XNmW3tAe4hDi5ts4NV0=','Clinique',1,1604320948,1604528152,NULL,NULL,NULL,NULL),(5,'005','Axa Assurances','Axa Assurances','','Boulevard du President Habib Bourguiba','Dakar','Dakar','Plateau','','Senegal','axa@zuulumed.net','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2214770000','80ad6641a51481757f0fbd5fa02eec2b26a5c68bbcf884bab3ad32dd7e70d2a746da0dba4d38d756ce3cc49ce87ae24bf77a3ce88ef57b77ccf69cebe0b6d3647Q3wnTxA2vDzneSd8g+EjNDT33MxTpAtZYMIv8vXFnw=','Assurance',1,1604481671,NULL,NULL,NULL,NULL,NULL),(6,'006','April','April','','N°2118, Liberté 3, Rez-de-chaussée à gauche','Dakar','Dakar','','','Senegal','april@zuulumed.net','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2214780000','0d1d82a33ae4d3f989ed2049fddfe7a5e3042b9a5786f262b56b996024a0bc160cdbf6ea0790671e2cdd82887e5fd9deb38bd789d323f01a1f384d6d144a3f86LN53rXbBOSfCCkVy/t+nZXCOsWA4qpQnpznnAECaUHo=','Assurance',1,1604481944,NULL,NULL,NULL,NULL,NULL),(7,'007','hopital st louis','hopital st louis','','SENEGAL','Diourbel','Bambey','Lambaye','','Senegal','rf@zuulumed.net','','FAYE','ROKHAYA',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1212121244','ef908d10f5c5abc8bfa0204eaa7a1888b68e2057948d88f41a52bcd187868c4aa3101dee2e1c98d2fd6134549be99d564597179d33a918a71339e451162efae1CK6laHLw+2D4ksL8xRYMvqky9NSjzwMcIZGwJcUGp70=','Pharmacie',1,1604528267,NULL,NULL,NULL,NULL,NULL),(8,'008','sai jean','sai jean','','SENEGAL','Diourbel','Bambey','Baba Garage','','Senegal','admin44@zuulumed.net','7878787878','FAYE','ROKHAYA','','','','','','','','','1212121188','2da9918bf2f0906eb9c5545c0355f4c0903d096f1be61b351bc0668c8eb12848825f1978ed71d5b40eeb098aa6d5b357f5cc5f7c90292ac6086f4026d0a74434nlCuZY8XRFibuvleh2amRB054Jdg14811uj5ImQNPmY=','Assurance',1,1604741240,1604741376,'assurane','','','');
/*!40000 ALTER TABLE `organisation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ot_payment`
--

DROP TABLE IF EXISTS `ot_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ot_payment` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `patient` varchar(100) DEFAULT NULL,
  `doctor_c_s` varchar(100) DEFAULT NULL,
  `doctor_a_s_1` varchar(100) DEFAULT NULL,
  `doctor_a_s_2` varchar(100) DEFAULT NULL,
  `doctor_anaes` varchar(100) DEFAULT NULL,
  `n_o_o` varchar(100) DEFAULT NULL,
  `c_s_f` varchar(100) DEFAULT NULL,
  `a_s_f_1` varchar(100) DEFAULT NULL,
  `a_s_f_2` varchar(11) DEFAULT NULL,
  `anaes_f` varchar(100) DEFAULT NULL,
  `ot_charge` varchar(100) DEFAULT NULL,
  `cab_rent` varchar(100) DEFAULT NULL,
  `seat_rent` varchar(100) DEFAULT NULL,
  `others` varchar(100) DEFAULT NULL,
  `discount` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `doctor_fees` varchar(100) DEFAULT NULL,
  `hospital_fees` varchar(100) DEFAULT NULL,
  `gross_total` varchar(100) DEFAULT NULL,
  `flat_discount` varchar(100) DEFAULT NULL,
  `amount_received` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ot_payment`
--

LOCK TABLES `ot_payment` WRITE;
/*!40000 ALTER TABLE `ot_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `ot_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partenariat_sante_assurance`
--

DROP TABLE IF EXISTS `partenariat_sante_assurance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partenariat_sante_assurance` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `id_organisation_sante` int(11) NOT NULL,
  `id_organisation_assurance` int(11) NOT NULL,
  `partenariat_actif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partenariat_sante_assurance`
--

LOCK TABLES `partenariat_sante_assurance` WRITE;
/*!40000 ALTER TABLE `partenariat_sante_assurance` DISABLE KEYS */;
INSERT INTO `partenariat_sante_assurance` VALUES (1,1,6,1),(2,3,5,1),(3,3,6,1),(6,3,8,1),(5,4,5,1),(7,8,8,1);
/*!40000 ALTER TABLE `partenariat_sante_assurance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_organisation` int(11) DEFAULT NULL,
  `img_url` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(1000) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `sex` varchar(100) DEFAULT NULL,
  `birthdate` varchar(100) DEFAULT NULL,
  `age` varchar(100) DEFAULT NULL,
  `bloodgroup` varchar(100) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  `patient_id` varchar(100) DEFAULT NULL,
  `add_date` varchar(100) DEFAULT NULL,
  `registration_time` varchar(100) DEFAULT NULL,
  `how_added` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `matricule` varchar(100) DEFAULT NULL,
  `grade` varchar(100) DEFAULT NULL,
  `birth_position` varchar(100) DEFAULT NULL,
  `nom_contact` varchar(100) DEFAULT NULL,
  `phone_contact` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `nom_mutuelle` varchar(100) DEFAULT NULL,
  `num_police` varchar(100) DEFAULT NULL,
  `date_valid` varchar(100) DEFAULT NULL,
  `charge_mutuelle` int(11) DEFAULT NULL,
  `lien_parente` varchar(100) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,NULL,NULL,'Shaibal Saha',NULL,'voter@example.com',',2','Debidwar,comilla','1711111111','Male','31-12-2020',NULL,'O+','741','416729','14/10/20','1602710912',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,NULL,'uploads/Ademis.jpeg','cheikh ahmed diagne',NULL,'cheikh@gmail.com','2','Cite enseignant','+221781156335','Male','25-01-1991',NULL,NULL,'744','523681','10/14/20','1602711726',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Pere',12,NULL),(3,NULL,NULL,'Mina Diagne',NULL,'mina@gmail.com','2','Dakar','+221781156335','Female','04-11-1988',NULL,'A+','745','570907','10/14/20','1602712410',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,NULL,'uploads/mobama11.jpeg','Mary DOE',NULL,'mary.doe@yahoo.com',',2','Keur Massar','987665534','Female','01-05-2018',NULL,NULL,'753','473761','10/14/20','1602718584',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Pere',11,NULL),(5,NULL,NULL,'laboo','FAYE ROKHAYA','admin@zuulumed.net','','SENEGAL','0786006831','Male','26-02-2020',NULL,'','1','369649','10/15/20','1602787313',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Enfant',11,NULL),(6,NULL,'uploads/mobama12.jpeg','Jane','Doe','jane.doe@hotmail.com','','Keur Massar','708971243','Female','02-05-1991',NULL,'','754','292362','10/15/20','1602788285',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,NULL,'uploads/logo3.png','roky','faye','rokhaya.faye@zuulu.net','','SENEGAL','0786006831','Monsieur','09-02-2011',NULL,'O-','756','P-4-7','10/17/20','1602895782',NULL,1,'1265555','major','thies','FAYE ROKHAYA h','0786006831','Chetienne','Saint-Louis',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,NULL,NULL,'Bouba','Diouf','bouba_diouf@gmail.com','','Medina','707653425','Monsieur','09-05-1973',NULL,'A+','757','13179','10/17/20','1602956280',NULL,1,'841','Colonel','Diourbel','','','Musulmane','Dakar','IPM SANTE YALLA','SY09876542332','20-10-2020',30,NULL,NULL,NULL),(9,NULL,NULL,'deproky','fafa','deproky@788888888.com','','','788888888','Monsieur','',NULL,'','758','141488','10/19/20','1603121064',NULL,1,'','','','','','','','axa','45455','20-10-2020',20,'Enfant',10,NULL),(10,NULL,NULL,'rokkhaya-','faye','rokhaya.faye@zuulu.net','','SENEGAL','0786006831','Monsieur','09-02-2011',NULL,'O-',NULL,'677864','10/22/20','1603381104',NULL,1,'1265555','major','thies','FAYE ROKHAYA h','0786006831','Chetienne','Saint-Louis',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,NULL,NULL,'iroki','diop','iroki@788888888.com','','thies3','788888888','Autres','27-10-2020',NULL,'AB+','759','906331','10/22/20','1603382640',NULL,1,'1265555','major','thies','test patient','121221222121','Autres','Thiès',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,NULL,NULL,'FAYE','ROKHAYA','admin@zuulumed.net','','SENEGAL','0786006831','Autres','07-10-2020',NULL,'AB+',NULL,'695643','10/23/20','1603479754',NULL,1,'122334','Cadre','','','','Musulmane','Thiès',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,NULL,'uploads/mobama13.jpeg','Getrude','Raymond','gertrud@raymond.com',',2','Kaolack','784321234','','06-05-1997',NULL,'','762','65656','10/25/20','1603640377',NULL,1,'','','','','','','Kaolack',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,NULL,NULL,'Joseph','Raymond','samba_diallo@yahoo.de','','Kaolack','784785897','Masculin','01-05-2018',NULL,'','763','385433','10/25/20','1603642795',NULL,1,'','','Diourbel','','','','Kaolack',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,3,NULL,'FAYE hopital zfs','ROKHAYA','admin44@zuulumed.net','','SENEGAL','0786006831','Masculin','14-11-2020',NULL,'','770','P-3-15','11/03/20','1604404372',NULL,1,'','','','','','','Saint-Louis',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,4,NULL,'FAYE hopital RF','DABA','rokhaya.faye@zuulu.net','','SENEGAL','0786006831','Feminin','02-02-1990',NULL,'','756','P-4-7','11/03/20','1604406962',NULL,1,'','','','','','','Kolda',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,3,NULL,'FA','RO','admssssin@hms.com','','SENEGAL','0786006831','Masculin','02-02-1990',NULL,'','771','P-003-17','11/03/20','1604425123',NULL,1,'','','','','','','Diourbel',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,3,NULL,'gaya','diop','rok@rok.fr','','SENEGAL','788888888','Masculin','01-08-2019',NULL,'','772','P-003-18','11/03/20','1604446074',NULL,1,'','','','','','','Ziguinchor',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,3,NULL,'aida','fall','admssssin@hms.com','','SENEGAL','0786006831','Feminin','08-01-2019',NULL,'','771','P-003-19','11/04/20','1604490447',NULL,1,'','','','','','','Ziguinchor',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,3,NULL,'Abdoulaye','FALL','abdoulaye.fall@zuulu.net','','Thies','775351493','Masculin','28-01-2000',NULL,'','773','P-003-20','11/04/20','1604513305',NULL,1,'','','','','','','Thiès',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,4,NULL,'FAYE','ROKHAYA','admin@zuulumed.net','','SENEGAL','0786006831','Feminin','24-11-2020',NULL,'','1','P-004-21','11/04/20','1604521089',NULL,1,'','','','','','','Ziguinchor',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,4,NULL,'FAYE','ROKHAYA','admssssin@hms.com','','SENEGAL','0786006831','Feminin','12-11-2020',NULL,'','771','P-004-22','11/04/20','1604521129',NULL,1,'','','','','','','Ziguinchor',NULL,NULL,NULL,NULL,'Pere',21,NULL),(23,1,NULL,'Alassane','Sarr','kheush@hotmail.com','','Villa Khadija, Rte de Ngor','766459226','Masculin','01-04-1986',NULL,'','775','P-001-23','11/05/20','1604570429',NULL,1,'007','','','','','','Dakar',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,1,NULL,'Ndeye','Sarr','Ndeye@766459226.com','','Villa Khadija, Rte de Ngor','766459226','Feminin','05-11-2020',NULL,'','776','P-001-24','11/05/20','1604571147',NULL,1,'','','','','','','Dakar',NULL,NULL,NULL,NULL,'Enfant',23,NULL),(25,1,NULL,'NoName','Sy','NoName@766459226.com','','Villa Khadija, Rte de Ngor','766459226','Feminin','16-12-2020',NULL,'','777','P-001-25','11/05/20','1604571242',NULL,1,'','','','','','','Dakar',NULL,NULL,NULL,NULL,'Autres',23,NULL),(26,8,NULL,'laboo','ROKHAYA','admin44@zuulumed.net','','SENEGAL','0786006831','Feminin','26-11-2020',NULL,'','770','P-008-0002','11/07/20','1604743755',NULL,1,'','','','','','','Ziguinchor',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_deposit`
--

DROP TABLE IF EXISTS `patient_deposit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient_deposit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `patient` varchar(100) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `deposited_amount` varchar(100) DEFAULT NULL,
  `amount_received_id` varchar(100) DEFAULT NULL,
  `deposit_type` varchar(100) DEFAULT NULL,
  `gateway` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_deposit`
--

LOCK TABLES `patient_deposit` WRITE;
/*!40000 ALTER TABLE `patient_deposit` DISABLE KEYS */;
INSERT INTO `patient_deposit` VALUES (1,'3',NULL,'1','1602713913','','1.gp','Cash',NULL,'1'),(2,'1',NULL,'2','1602797961','','2.gp','Cash',NULL,'1'),(3,'1',NULL,'3','1602802079','','3.gp','Cash',NULL,'1'),(4,'4',NULL,'4','1602803048','','4.gp','Cash',NULL,'1'),(5,'6',NULL,'5','1602803629','15000','5.gp','Cash',NULL,'1'),(6,'3',NULL,'6','1602863690','','6.gp','Cash',NULL,'1'),(7,'3',NULL,'7','1602867689','','7.gp','Cash',NULL,'1'),(8,'8',NULL,'8','1602956390','','8.gp','Cash',NULL,'1'),(9,'1',NULL,'9','1603105690','','9.gp','Cash',NULL,'1'),(10,NULL,NULL,'10','1603562946','15000','10.gp','Cash',NULL,'1'),(11,'10',NULL,'11','1603573540','','11.gp','Cash',NULL,'1'),(12,'5',NULL,'12','1603582966','','12.gp','Cash',NULL,'1'),(13,'1',NULL,'13','1603585967','','13.gp','Cash',NULL,'1'),(14,'2',NULL,'14','1603586907','','14.gp','Cash',NULL,'1'),(15,'13',NULL,'15','1604157041','5000','15.gp','Cash',NULL,'1'),(16,'13',NULL,'16','1604157055','5000','16.gp','Cash',NULL,'1'),(17,'14',NULL,'17','1604156951','40','17.gp','Cash',NULL,'1'),(18,'4',NULL,'18','1603759830','10000','18.gp','Cash',NULL,'764'),(19,'12',NULL,NULL,'1603804825','500','19.gp','Cash',NULL,'1'),(20,'8',NULL,'20','1603888348','5000','20.gp','Cash',NULL,'1'),(21,'14',NULL,'21','1604156914','2000','21.gp','Cash',NULL,'1'),(22,'14',NULL,'22','1603911274','','22.gp','Cash',NULL,'1'),(23,'5',NULL,'23','1604160707','17999','23.gp','Cash',NULL,'1'),(24,'12',NULL,'24','1603935740','','24.gp','Cash',NULL,'1'),(25,'7',NULL,'25','1603971355','','25.gp','Cash',NULL,'1'),(26,'5',NULL,'26','1604159925','22000','26.gp','Cash',NULL,'1'),(27,'4',NULL,'27','1603973156','15000','27.gp','Cash',NULL,'1'),(28,'2',NULL,'28','1603991790','','28.gp','Cash',NULL,'1'),(29,'4',NULL,'29','1603992072','5000','29.gp','Cash',NULL,'1'),(30,'4',NULL,'30','1603992289','','30.gp','Cash',NULL,'1'),(31,'5',NULL,'31','1604160352','','31.gp','Cash',NULL,'1'),(32,'19',NULL,'32','1604490509','','32.gp','Cash',NULL,'1'),(33,'20',NULL,'33','1604513897','3000','33.gp','Cash',NULL,'1'),(34,'20',NULL,'34','1604536820','','34.gp','Cash',NULL,'1'),(35,'15',NULL,'35','1604593686','12000','35.gp','Cash',NULL,'1'),(36,'25',NULL,'36','1604575091','50','36.gp','Cash',NULL,'761'),(37,'25',NULL,'37','1604575954','','37.gp','Cash',NULL,'761'),(38,'20',NULL,'38','1604593570','','38.gp','Cash',NULL,'1'),(39,'17',NULL,'39','1604617214','','39.gp','Cash',NULL,'1'),(40,'15',NULL,'40','1604670415','','40.gp','Cash',NULL,'1'),(41,'20',NULL,'41','1604738811','','41.gp','Cash',NULL,'1'),(42,'26',NULL,'42','1604744647','','42.gp','Cash',NULL,'778'),(43,'15',NULL,'43','1604753391','','43.gp','Cash',NULL,'1'),(44,'25',NULL,'44','1604754571','','44.gp','Cash',NULL,'761');
/*!40000 ALTER TABLE `patient_deposit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_material`
--

DROP TABLE IF EXISTS `patient_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient_material` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `id_organisation` int(11) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `patient_address` varchar(100) DEFAULT NULL,
  `patient_phone` varchar(100) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `date_string` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_material`
--

LOCK TABLES `patient_material` WRITE;
/*!40000 ALTER TABLE `patient_material` DISABLE KEYS */;
INSERT INTO `patient_material` VALUES (1,NULL,'1602712095','ordenance',NULL,'2','cheikh ahmed diagne','Cite enseignant','+221781156335','uploads/Ademis41.jpeg','14-10-20'),(2,NULL,'1602712735','ordenance',NULL,'3','Mina Diagne','Dakar','+221781156335','uploads/INTERFACE_POSTE_CASH.png','14-10-20'),(3,NULL,'1603901963','Immunologie',NULL,'14','Joseph','Kaolack','765438754','uploads/bio1.jpg','28-10-20'),(4,NULL,'1603911962','bioahwa',NULL,'13','Getrude','Kaolack','784321234','uploads/labo_bioahwa1.png','28-10-20');
/*!40000 ALTER TABLE `patient_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_mutuelle`
--

DROP TABLE IF EXISTS `patient_mutuelle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient_mutuelle` (
  `idpm` int(11) NOT NULL AUTO_INCREMENT,
  `pm_idpatent` int(11) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `pm_idmutuelle` int(11) DEFAULT NULL,
  `pm_numpolice` varchar(100) DEFAULT NULL,
  `pm_datevalid` varchar(100) DEFAULT NULL,
  `pm_charge` varchar(100) NOT NULL,
  `pm_status` int(11) NOT NULL,
  PRIMARY KEY (`idpm`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_mutuelle`
--

LOCK TABLES `patient_mutuelle` WRITE;
/*!40000 ALTER TABLE `patient_mutuelle` DISABLE KEYS */;
INSERT INTO `patient_mutuelle` VALUES (1,10,NULL,2,'45455','16-10-2020','20',1),(2,11,NULL,2,'45454555','31-10-2020','20',1),(3,12,NULL,1,'123456','31-12-2021','12',0),(4,13,NULL,2,'SY09876542332','07/31/2021','30',1),(5,12,NULL,2,'45454555','10/29/2020','10',1),(6,14,NULL,1,'SY09876542332','12/31/2020','70',1),(7,21,4,5,'45454555','11/24/2020','12',1),(8,23,1,6,'33388888','28-11-2020','90',1),(9,15,3,8,'45454555','27-11-2020','54',1),(10,26,8,8,'45454555','25-11-2020','58',1);
/*!40000 ALTER TABLE `patient_mutuelle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient_relation`
--

DROP TABLE IF EXISTS `patient_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patient_relation` (
  `idpr` int(11) NOT NULL AUTO_INCREMENT,
  `pr_parent` int(11) NOT NULL,
  `pr_patient` int(11) NOT NULL,
  PRIMARY KEY (`idpr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient_relation`
--

LOCK TABLES `patient_relation` WRITE;
/*!40000 ALTER TABLE `patient_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `patient_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(25) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `id_organisation` int(11) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `service` int(11) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `vat` varchar(100) NOT NULL DEFAULT '0',
  `x_ray` varchar(100) DEFAULT NULL,
  `flat_vat` varchar(100) DEFAULT NULL,
  `discount` varchar(100) NOT NULL DEFAULT '0',
  `flat_discount` varchar(100) DEFAULT NULL,
  `gross_total` varchar(100) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `hospital_amount` varchar(100) DEFAULT NULL,
  `doctor_amount` varchar(100) DEFAULT NULL,
  `category_amount` varchar(1000) DEFAULT NULL,
  `category_name` varchar(1000) DEFAULT NULL,
  `amount_received` varchar(100) DEFAULT NULL,
  `deposit_type` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `patient_phone` varchar(100) DEFAULT NULL,
  `patient_address` varchar(100) DEFAULT NULL,
  `doctor_name` varchar(100) DEFAULT NULL,
  `date_string` varchar(100) DEFAULT NULL,
  `charge_mutuelle` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,NULL,NULL,'3',NULL,'2',NULL,'1602713913','2222','0',NULL,NULL,'0','0','2222','','1999.8','222.2',NULL,'1*2222*diagnostic*1','','Cash','unpaid','1','Mina Diagne','+221781156335','Dakar','Ibnou Abass Diagne','14-10-20',NULL),(2,NULL,NULL,'1',NULL,'3',NULL,'1602797961','5000','0',NULL,NULL,'0','0','5000','','5000','0',NULL,'3*5000**1','','Cash','unpaid','1','Shaibal Saha','1711111111','Debidwar,comilla','FAYE','15-10-20',NULL),(3,NULL,NULL,'1',NULL,'3',NULL,'1602802079','10000','0',NULL,NULL,'0','0','10000','','10000','0',NULL,'5*10000**1','','Cash','unpaid','1','Shaibal Saha','1711111111','Debidwar,comilla','FAYE','15-10-20',NULL),(4,NULL,NULL,'4',NULL,'2',NULL,'1602802912','15000','0',NULL,NULL,'0','0','15000','','15000','0',NULL,'4*10000**1,6*5000**1','','Cash','unpaid','1','Mary DOE','987665534','Keur Massar','Ibnou Abass Diagne','15-10-20',NULL),(5,NULL,NULL,'6',NULL,'\r\n<div style=',NULL,'1602803536','15000','0',NULL,NULL,'0','0','15000','','15000','0',NULL,'5*10000**1,14*5000**1','15000','Cash','unpaid','1','Jane','708971243','Keur Massar',NULL,'15-10-20',NULL),(6,NULL,NULL,'3',NULL,'3',NULL,'1602863690','15000','0',NULL,NULL,'0','0','15000','','15000','0',NULL,'3*5000**1,4*10000**1','','Cash','unpaid','1','Mina Diagne','+221781156335','Dakar','FAYE','16-10-20',NULL),(7,NULL,NULL,'3',NULL,NULL,NULL,'1602867689','5000','0',NULL,NULL,'0','0','5000','','5000','0',NULL,'30*5000**1','','Cash','unpaid','1','Mina Diagne','+221781156335','Dakar','0','16-10-20',NULL),(8,NULL,NULL,'8',NULL,'2',NULL,'1602956390','14000','0',NULL,NULL,'0','0','14000','','14000','0',NULL,'28*12000**1,13*2000**1','','Cash','unpaid','1','Bouba','707653425','Medina','Ibnou Abass Diagne','17-10-20',NULL),(9,NULL,NULL,'1',NULL,'3',NULL,'1603105690','20000','0',NULL,NULL,'0','0','20000','','20000','0',NULL,'3*5000.000000**1,30*5000.000000**1,34*10000.000000**1','','Cash','unpaid','1','Shaibal Saha','1711111111','Debidwar,comilla','FAYE','19-10-20',NULL),(10,NULL,NULL,NULL,NULL,NULL,NULL,'1603562946','41000','0',NULL,NULL,'2500','2500','38500','','38500','0',NULL,'4*10000.000000**1,30*5000.000000**1,31*5000.000000**1,5*10000.000000**1,13*2000.000000**1,33*9000.000000**1','15000','Cash','unpaid','1','0','0','0','0','24-10-20',NULL),(11,NULL,NULL,'10',NULL,NULL,NULL,'1603573540','22500','0',NULL,NULL,'2700','2700','19800','axa','19800','0',NULL,'13*22500**1','','Cash','unpaid','1','rokkhaya-','0786006831','SENEGAL','0','24-10-20',NULL),(12,NULL,NULL,'5',NULL,NULL,NULL,'1603582966','22500','0',NULL,NULL,'4500','4500','18000','ipres','18000','0',NULL,'13*22500**1','','Cash','unpaid','1','laboo','0786006831','SENEGAL','0','24-10-20',NULL),(13,NULL,NULL,'1',NULL,NULL,NULL,'1603585967','17000','0',NULL,NULL,'0','0','17000','','17000','0',NULL,'27*12000**1,31*5000**1','','Cash','unpaid','1','Shaibal Saha','1711111111','Debidwar,comilla','0','25-10-20',NULL),(14,NULL,NULL,'2',NULL,'4',NULL,'1603586907','22500','0',NULL,NULL,'2700','2700','19800','axa','22500','-2700',NULL,'13*22500**1','','Cash','unpaid','1','cheikh ahmed diagne','+221781156335','Cite enseignant','ino','25-10-20',NULL),(15,NULL,NULL,'13',NULL,NULL,NULL,'1603643158','12000','0',NULL,NULL,'0','0','12000','','12000','0',NULL,'28*12000**1','5000','Cash','unpaid','1','Getrude','784321234','Kaolack','0','25-10-20',NULL),(16,NULL,NULL,'13',NULL,NULL,NULL,'1603645114','22000','0',NULL,NULL,'0','0','22000','','22000','0',NULL,'27*12000**1,5*10000**1','5000','Cash','unpaid','1','Getrude','784321234','Kaolack','0','25-10-20',NULL),(17,NULL,NULL,'14',NULL,NULL,NULL,'1603753230','22500','0',NULL,NULL,'0','0','22500','ipres','22500','0',NULL,'13*22500**1','40','Cash','unpaid','1','Joseph','765438754','Kaolack','0','26-10-20',NULL),(18,NULL,NULL,'4',NULL,'2',NULL,'1603759830','35500','0',NULL,NULL,'7100','7100','28400','ipres','35500','-7100',NULL,'5*15000**1,4*15000**1,3*5500**1','10000','Cash','unpaid','764','Mary DOE','987665534','Keur Massar','Ibnou Abass Diagne','27-10-20',NULL),(19,NULL,NULL,'12',NULL,NULL,NULL,'1603804778','22500','0',NULL,NULL,'0','0','22500','ipres','22500','0',NULL,'13*22500**1','500','Cash','unpaid','1','FAYE','0786006831','SENEGAL','0','27-10-20',NULL),(20,NULL,NULL,'8',NULL,NULL,NULL,'1603888348','17000','0',NULL,NULL,'0','0','17000','','17000','0',NULL,'38*5000**1,42*7000**1,45*5000**1','5000','Cash','unpaid','1','Bouba','707653425','Medina','0','28-10-20',NULL),(21,NULL,NULL,'14',NULL,NULL,NULL,'1603909991','17000','0',NULL,NULL,'0','0','17000','','17000','0',NULL,'13*2000**1,40*5000**1,44*5000**1,41*5000**1','2000','Cash','unpaid','1','Joseph','765438754','Kaolack','0','28-10-20',NULL),(22,NULL,NULL,'14',NULL,NULL,NULL,'1603911274','45000','0',NULL,NULL,'0','0','45000','axa','45000','0',NULL,'13*22500**1,39*7500**1,43*7500**1,40*7500**1','','Cash','unpaid','1','Joseph','765438754','Kaolack','0','28-10-20',NULL),(23,NULL,NULL,'5',NULL,NULL,NULL,'1603935499','22500','0',NULL,NULL,'1','1','17999','ipres','17999','0',NULL,'13*22500**1','17999','Cash','unpaid','1','laboo','0786006831','SENEGAL','0','29-10-20',4500),(24,NULL,NULL,'12',NULL,NULL,NULL,'1603935740','5500','0',NULL,NULL,'11','11','4939','ipres','4939','0',NULL,'3*5500**1','','Cash','unpaid','1','FAYE','0786006831','SENEGAL','0','29-10-20',550),(25,NULL,NULL,'7',NULL,NULL,NULL,'1603971355','7000','0',NULL,NULL,'0','0','7000','','7000','0',NULL,'13*2000**1,3*5000**1','','Cash','unpaid','1','roky','0786006831','SENEGAL','0','29-10-20',0),(26,NULL,NULL,'5',NULL,NULL,NULL,'1603971394','28000','0',NULL,NULL,'400','400','22000','ipres','22000','0',NULL,'3*5500**1,13*22500**1','22000','Cash','unpaid','1','laboo','0786006831','SENEGAL','0','29-10-20',5600),(27,NULL,NULL,'4',NULL,NULL,NULL,'1603973156','22500','0',NULL,NULL,'500','500','17500','ipres','17500','0',NULL,'39*7500**1,43*7500**1,46*7500**1','15000','Cash','unpaid','1','Mary DOE','987665534','Keur Massar','0','29-10-20',4500),(28,NULL,NULL,'2',NULL,NULL,NULL,'1603991790','37500','0',NULL,NULL,'0','0','33750','ipres','33750','0',NULL,'13*22500**1,27*7500**1,31*7500**1','','Cash','unpaid','1','cheikh ahmed diagne','+221781156335','Cite enseignant','0','29-10-20',3750),(29,NULL,NULL,'4',NULL,NULL,NULL,'1603992072','30600','0',NULL,NULL,'0','0','24480','ipres','24480','0',NULL,'30*7500**1,34*10500**1,36*12600**1','5000','Cash','unpaid','1','Mary DOE','987665534','Keur Massar','0','29-10-20',6120),(30,NULL,NULL,'4',NULL,NULL,NULL,'1603992289','15000','0',NULL,NULL,'0','0','12000','ipres','12000','0',NULL,'40*7500**1,38*7500**1','','Cash','unpaid','1','Mary DOE','987665534','Keur Massar','0','29-10-20',3000),(31,NULL,NULL,'5',NULL,NULL,NULL,'1604160352','22500','0',NULL,NULL,'0','0','18000','ipres','18000','0',NULL,'13*22500**1','','Cash','unpaid','1','laboo','0786006831','SENEGAL','0','31-10-20',4500),(32,NULL,NULL,'19',NULL,NULL,NULL,'1604490509','12000','0',NULL,NULL,'0','0','12000','','12000','0',NULL,'55*12000**1','','Cash','unpaid','1','aida','0786006831','SENEGAL','0','04-11-20',0),(33,NULL,NULL,'20',NULL,NULL,NULL,'1604513897','12000','0',NULL,NULL,'8000','8000','4000','','4000','0',NULL,'55*12000**1','3000','Cash','unpaid','1','Abdoulaye','775351493','Thies','0','04-11-20',0),(34,NULL,NULL,'20',3,NULL,NULL,'1604536820','12000','0',NULL,NULL,'0','0','12000','','12000','0',NULL,'55*12000**1','','Cash','unpaid','1','Abdoulaye','775351493','Thies','0','05-11-20',0),(35,NULL,NULL,'15',3,NULL,NULL,'1604539251','12000','0',NULL,NULL,'0','0','12000','','12000','0',NULL,'55*12000**1','12000','Cash','unpaid','1','FAYE hopital zfs','0786006831','SENEGAL','0','05-11-20',0),(36,NULL,NULL,'25',1,NULL,NULL,'1604574696','1000','0',NULL,NULL,'0','0','100','April','100','0',NULL,'61*1000**1','50','Cash','unpaid','761','NoName','766459226','Villa Khadija, Rte de Ngor','0','05-11-20',900),(37,NULL,NULL,'25',1,NULL,NULL,'1604575954','1000','0',NULL,NULL,'0','0','1000','','1000','0',NULL,'61*1000**1','','Cash','unpaid','761','NoName','766459226','Villa Khadija, Rte de Ngor','0','05-11-20',0),(38,NULL,NULL,'20',3,NULL,NULL,'1604593570','2000','0',NULL,NULL,'0','0','2000','','2000','0',NULL,'58*2000**1','','Cash','unpaid','1','Abdoulaye','775351493','Thies','0','05-11-20',0),(39,'F-003-0039',NULL,'17',3,NULL,NULL,'1604617214','59000','0',NULL,NULL,'0','0','59000','','59000','0',NULL,'57*3000**1,59*56000**1','','Cash','new','1','FA','0786006831','SENEGAL','0','05-11-20',0),(40,'F-003-0006',NULL,'15',3,NULL,NULL,'1604670415','12000','0',NULL,NULL,'0','0','12000','','12000','0',NULL,'55*12000**1','','Cash','new','1','FAYE hopital zfs','0786006831','SENEGAL','0','06-11-20',0),(41,'F-003-0007',NULL,'20',3,NULL,8,'1604738811','1000','0',NULL,NULL,'0','0','1000','','1000','0',NULL,'56*1000**1','','Cash','new','1','Abdoulaye','775351493','Thies','0','07-11-20',0),(42,'F-008-0002',NULL,'26',8,NULL,15,'1604744647','1000','0',NULL,NULL,'300','300','120','sai jean','120','0',NULL,'62*1000**1','','Cash','new','778','laboo','0786006831','SENEGAL','0','07-11-20',580),(43,'F-003-0008',NULL,'15',3,NULL,8,'1604753391','1000','0',NULL,NULL,'0','0','460','sai jean','460','0',NULL,'56*1000**1','','Cash','new','1','FAYE hopital zfs','0786006831','SENEGAL','0','07-11-20',540),(44,'F-001-0004',NULL,'25',1,NULL,2,'1604754571','22500','0',NULL,NULL,'0','0','2250','April','2250','0',NULL,'13*22500**1','','Cash','new','761','NoName','766459226','Villa Khadija, Rte de Ngor','0','07-11-20',20250);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paymentGateway`
--

DROP TABLE IF EXISTS `paymentGateway`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paymentGateway` (
  `id` int(100) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `merchant_key` varchar(100) DEFAULT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  `APIUsername` varchar(100) DEFAULT NULL,
  `APIPassword` varchar(100) DEFAULT NULL,
  `APISignature` varchar(100) DEFAULT NULL,
  `status` varchar(1000) DEFAULT NULL,
  `publish` varchar(1000) DEFAULT NULL,
  `secret` varchar(1000) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paymentGateway`
--

LOCK TABLES `paymentGateway` WRITE;
/*!40000 ALTER TABLE `paymentGateway` DISABLE KEYS */;
INSERT INTO `paymentGateway` VALUES (1,'PayPal','','','','','API Username','API Password','API Signature','test',NULL,NULL),(2,'Pay U Money','Merchant Key','Salt','','','','','Aaw-Fd69z.JLuiq13ejMN-CsSMuuAPEXWUFPF5QW9sD22fp1hosGIFKo','test',NULL,NULL),(3,'Stripe',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Publish key','Secret Key');
/*!40000 ALTER TABLE `paymentGateway` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_category`
--

DROP TABLE IF EXISTS `payment_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `prestation` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `tarif_public` decimal(15,6) DEFAULT NULL,
  `tarif_professionnel` decimal(15,6) DEFAULT NULL,
  `tarif_assurance` decimal(15,6) DEFAULT NULL,
  `id_service` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_category`
--

LOCK TABLES `payment_category` WRITE;
/*!40000 ALTER TABLE `payment_category` DISABLE KEYS */;
INSERT INTO `payment_category` VALUES (3,'Sage Femme','',5000.000000,4500.000000,5500.000000,1),(4,'Consultation Pre-natale','',10000.000000,8500.000000,15000.000000,1),(5,'Consultation Gynecologique','',10000.000000,8500.000000,15000.000000,1),(27,'AC ANTI VHC3','',12000.000000,4250.000000,7500.000000,5),(28,'Medecine Generale',NULL,12000.000000,11500.000000,15000.000000,1),(30,'AC ANTI VHC4',NULL,5000.000000,4250.000000,7500.000000,5),(13,'ACIDE URIQUE URINAIRE','',2000.000000,12750.000000,22500.000000,2),(31,'AC ANTI VHC1',NULL,5000.000000,4250.000000,7500.000000,5),(32,'AC ANTI VHC2',NULL,6000.000000,4800.000000,6300.000000,5),(33,'AC ANTI VHC5',NULL,9000.000000,7200.000000,9450.000000,5),(34,'AC ANTI VHC6',NULL,10000.000000,8000.000000,10500.000000,5),(35,'AC ANTI VHC7',NULL,11000.000000,8800.000000,11550.000000,5),(36,'AC ANTI VHC8',NULL,12000.000000,9600.000000,12600.000000,5),(37,'Test1',NULL,5000.000000,4250.000000,7500.000000,6),(38,'Test2',NULL,5000.000000,4250.000000,7500.000000,6),(39,'Test3',NULL,5000.000000,4250.000000,7500.000000,6),(40,'Test4',NULL,5000.000000,4250.000000,7500.000000,6),(41,'Test5',NULL,5000.000000,4250.000000,7500.000000,6),(42,'Test6',NULL,7000.000000,5000.000000,8000.000000,6),(43,'Test7',NULL,5000.000000,4250.000000,7500.000000,6),(44,'Test8',NULL,5000.000000,4250.000000,7500.000000,6),(45,'Test9',NULL,5000.000000,4250.000000,7500.000000,6),(46,'Test10',NULL,5000.000000,4250.000000,7500.000000,6),(47,'Test11',NULL,5000.000000,4250.000000,7500.000000,6),(48,'Test12',NULL,5000.000000,4250.000000,7500.000000,6),(49,'Test13',NULL,5000.000000,4250.000000,7500.000000,6),(50,'Test14',NULL,5000.000000,4250.000000,7500.000000,6),(51,'Test15','',5000.000000,4300.000000,7500.000000,6),(52,'Test16',NULL,5000.000000,4250.000000,7500.000000,6),(53,'Test17',NULL,5000.000000,4250.000000,7500.000000,6),(54,'NewPrestation',NULL,5000.000000,4250.000000,7500.000000,5),(55,'ECG ZFS','',12000.000000,11000.000000,9000.000000,9),(56,'ABC','',1000.000000,1000.000000,1000.000000,8),(57,'test analyse','test',3000.000000,5000.000000,10000.000000,11),(58,'test immuno','test immuno',2000.000000,7000.000000,15000.000000,10),(59,'nfs2','',56000.000000,100000.000000,1000.000000,11),(60,'nfs','Salaire Juin test rf',1000.000000,1000.000000,1000.000000,12),(61,'Gamma','',1000.000000,1000.000000,1000.000000,14),(62,'nfs','Salaire Juin test rf',1000.000000,1000.000000,1000.000000,15);
/*!40000 ALTER TABLE `payment_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paymentgateway`
--

DROP TABLE IF EXISTS `paymentgateway`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paymentgateway` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `merchant_key` varchar(100) DEFAULT NULL,
  `salt` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  `APIUsername` varchar(100) DEFAULT NULL,
  `APIPassword` varchar(100) DEFAULT NULL,
  `APISignature` varchar(100) DEFAULT NULL,
  `status` varchar(1000) DEFAULT NULL,
  `publish` varchar(1000) DEFAULT NULL,
  `secret` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paymentgateway`
--

LOCK TABLES `paymentgateway` WRITE;
/*!40000 ALTER TABLE `paymentgateway` DISABLE KEYS */;
INSERT INTO `paymentgateway` VALUES (1,'PayPal','','','','','API Username','API Password','API Signature','test',NULL,NULL),(2,'Pay U Money','Merchant Key','Salt','','','','','Aaw-Fd69z.JLuiq13ejMN-CsSMuuAPEXWUFPF5QW9sD22fp1hosGIFKo','test',NULL,NULL),(3,'Stripe',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Publish key','Secret Key');
/*!40000 ALTER TABLE `paymentgateway` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacist`
--

DROP TABLE IF EXISTS `pharmacist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pharmacist` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacist`
--

LOCK TABLES `pharmacist` WRITE;
/*!40000 ALTER TABLE `pharmacist` DISABLE KEYS */;
INSERT INTO `pharmacist` VALUES (1,'uploads/imgUsers/3_6_images.jpg','Aicha Dia','pharmacien@zuulumed.net','Almadies','',NULL,NULL,'747');
/*!40000 ALTER TABLE `pharmacist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacy_expense`
--

DROP TABLE IF EXISTS `pharmacy_expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pharmacy_expense` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacy_expense`
--

LOCK TABLES `pharmacy_expense` WRITE;
/*!40000 ALTER TABLE `pharmacy_expense` DISABLE KEYS */;
INSERT INTO `pharmacy_expense` VALUES (1,'securite','1602712963','78',NULL);
/*!40000 ALTER TABLE `pharmacy_expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacy_expense_category`
--

DROP TABLE IF EXISTS `pharmacy_expense_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pharmacy_expense_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `y` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacy_expense_category`
--

LOCK TABLES `pharmacy_expense_category` WRITE;
/*!40000 ALTER TABLE `pharmacy_expense_category` DISABLE KEYS */;
INSERT INTO `pharmacy_expense_category` VALUES (1,'securite','secur',NULL,NULL);
/*!40000 ALTER TABLE `pharmacy_expense_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacy_payment`
--

DROP TABLE IF EXISTS `pharmacy_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pharmacy_payment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `vat` varchar(100) NOT NULL DEFAULT '0',
  `x_ray` varchar(100) DEFAULT NULL,
  `flat_vat` varchar(100) DEFAULT NULL,
  `discount` varchar(100) NOT NULL DEFAULT '0',
  `flat_discount` varchar(100) DEFAULT NULL,
  `gross_total` varchar(100) DEFAULT NULL,
  `hospital_amount` varchar(100) DEFAULT NULL,
  `doctor_amount` varchar(100) DEFAULT NULL,
  `category_amount` varchar(1000) DEFAULT NULL,
  `category_name` varchar(1000) DEFAULT NULL,
  `amount_received` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacy_payment`
--

LOCK TABLES `pharmacy_payment` WRITE;
/*!40000 ALTER TABLE `pharmacy_payment` DISABLE KEYS */;
INSERT INTO `pharmacy_payment` VALUES (1,NULL,NULL,NULL,'1602712856','35','0',NULL,NULL,'','','35',NULL,NULL,NULL,'1*35*1*30',NULL,'unpaid');
/*!40000 ALTER TABLE `pharmacy_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pharmacy_payment_category`
--

DROP TABLE IF EXISTS `pharmacy_payment_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pharmacy_payment_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `c_price` varchar(100) DEFAULT NULL,
  `d_commission` int(100) DEFAULT NULL,
  `h_commission` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pharmacy_payment_category`
--

LOCK TABLES `pharmacy_payment_category` WRITE;
/*!40000 ALTER TABLE `pharmacy_payment_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `pharmacy_payment_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescription`
--

DROP TABLE IF EXISTS `prescription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prescription` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `symptom` varchar(100) DEFAULT NULL,
  `advice` varchar(1000) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `dd` varchar(100) DEFAULT NULL,
  `medicine` varchar(1000) DEFAULT NULL,
  `validity` varchar(100) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `patientname` varchar(1000) DEFAULT NULL,
  `doctorname` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescription`
--

LOCK TABLES `prescription` WRITE;
/*!40000 ALTER TABLE `prescription` DISABLE KEYS */;
INSERT INTO `prescription` VALUES (1,'1603238400','3','2','<p>test</p>\r\n','',NULL,NULL,'2***1000***1+1+1***8***no',NULL,'<p>pole</p>\r\n','Mina Diagne','Ibnou Abass Diagne');
/*!40000 ALTER TABLE `prescription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receptionist`
--

DROP TABLE IF EXISTS `receptionist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receptionist` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `ion_user_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receptionist`
--

LOCK TABLES `receptionist` WRITE;
/*!40000 ALTER TABLE `receptionist` DISABLE KEYS */;
INSERT INTO `receptionist` VALUES (2,NULL,'Alassane Sarr','receptionniste@zuulumed.net','Dakar','+221781156335',NULL,'752');
/*!40000 ALTER TABLE `receptionist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region_senegal`
--

DROP TABLE IF EXISTS `region_senegal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `region_senegal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region_senegal`
--

LOCK TABLES `region_senegal` WRITE;
/*!40000 ALTER TABLE `region_senegal` DISABLE KEYS */;
INSERT INTO `region_senegal` VALUES (234,'Dakar'),(236,'Diourbel'),(238,'Fatick'),(240,'Kaffrine'),(242,'Kaolack'),(244,'Kedougou'),(246,'Kolda'),(248,'Louga'),(250,'Matam'),(252,'SaintLouis'),(254,'Sedhiou'),(256,'Tambacounda'),(258,'Thies'),(260,'Ziguinchor');
/*!40000 ALTER TABLE `region_senegal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `report_type` varchar(100) DEFAULT NULL,
  `patient` varchar(100) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `add_date` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
INSERT INTO `report` VALUES (36,'operation','Shaibal Saha*741','Salaire Juin test rf','Ibnou Abass Diagne','15-10-2020','10/14/20'),(37,'birth','Shaibal Saha*741','Salaire Juin test rf','Ibnou Abass Diagne','01-10-2020','10/14/20');
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sante_assurance_prestation`
--

DROP TABLE IF EXISTS `sante_assurance_prestation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sante_assurance_prestation` (
  `id_partenariat_sante_assurance` int(11) NOT NULL,
  `id_payment_category` int(11) NOT NULL,
  `est_couverte` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sante_assurance_prestation`
--

LOCK TABLES `sante_assurance_prestation` WRITE;
/*!40000 ALTER TABLE `sante_assurance_prestation` DISABLE KEYS */;
INSERT INTO `sante_assurance_prestation` VALUES (1,53,0),(1,51,0),(1,52,0),(3,56,0),(3,55,0),(3,58,0),(3,57,0),(6,56,0);
/*!40000 ALTER TABLE `sante_assurance_prestation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `img_url` varchar(1000) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (6,'uploads/immuno.jpg','Immunologie','immuno'),(7,'uploads/bacte.jpg','Bacteriologie','bacterio'),(8,'uploads/hemato.jpg','Hematologie','hemato'),(9,'uploads/bio.jpg','Biochimie','bioch');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting_service`
--

DROP TABLE IF EXISTS `setting_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `setting_service` (
  `idservice` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_organisation` int(11) DEFAULT NULL,
  `name_service` varchar(100) NOT NULL,
  `description_service` varchar(1000) NOT NULL,
  `id_department` int(11) DEFAULT NULL,
  `x` varchar(10) DEFAULT NULL,
  `y` varchar(10) DEFAULT NULL,
  `status_service` int(11) DEFAULT NULL,
  PRIMARY KEY (`idservice`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting_service`
--

LOCK TABLES `setting_service` WRITE;
/*!40000 ALTER TABLE `setting_service` DISABLE KEYS */;
INSERT INTO `setting_service` VALUES (1,1,'Generaliste','<p>gene</p>\r\n',2,NULL,NULL,1),(2,1,'Labo Analyse','',2,NULL,NULL,1),(3,1,'faye','',2,NULL,NULL,NULL),(4,1,'gygy','',2,NULL,NULL,1),(5,1,'Labo','<p>Labo</p>\r\n',3,NULL,NULL,1),(6,1,'Laboratoire','<p>tous les actes labo</p>\r\n',3,NULL,NULL,1),(7,3,'Echographie','',4,NULL,NULL,1),(8,3,'Scanner','',4,NULL,NULL,1),(9,3,'Radiologie','',4,NULL,NULL,1),(10,3,'Immunologie','',6,NULL,NULL,1),(11,3,'Bacteriologie','<p>test bacteriologie</p>\r\n',4,NULL,NULL,1),(12,4,'laboo','',7,NULL,NULL,1),(13,1,'ECG rf','',1,NULL,NULL,1),(14,1,'X-Ray Gamma','',1,NULL,NULL,1),(15,8,'laboo','',8,NULL,NULL,1);
/*!40000 ALTER TABLE `setting_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `system_vendor` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `facebook_id` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `discount` varchar(100) DEFAULT NULL,
  `vat` varchar(100) DEFAULT NULL,
  `login_title` varchar(100) DEFAULT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `invoice_logo` varchar(500) DEFAULT NULL,
  `payment_gateway` varchar(100) DEFAULT NULL,
  `sms_gateway` varchar(100) DEFAULT NULL,
  `codec_username` varchar(100) DEFAULT NULL,
  `codec_purchase_code` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'ecoMed 24','ecoMed 24','Dakar','786006831','admin@zuulu.com','#','FCFA','french','flat','percentage','Login Title','uploads/logo6.png','','PayPal','Twilio','','');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slide`
--

DROP TABLE IF EXISTS `slide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `img_url` varchar(1000) DEFAULT NULL,
  `text1` varchar(500) DEFAULT NULL,
  `text2` varchar(500) DEFAULT NULL,
  `text3` varchar(500) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slide`
--

LOCK TABLES `slide` WRITE;
/*!40000 ALTER TABLE `slide` DISABLE KEYS */;
INSERT INTO `slide` VALUES (1,'Slider 1','uploads/labo_bioahwa.png','Hematologie','BioAhwa1','Hospital','2','Active'),(2,'Terrebonne','uploads/hematoLab.jpg','Orozen Terrebonne','Best Hospital management System','Best Hospital management System','1','Active'),(5,'Hopital Ahmadou Sakhir Ndieguene','uploads/bioLab.jpg','Welcome To Hospital','Hospital Management System','Hospital','3','Active');
/*!40000 ALTER TABLE `slide` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms`
--

DROP TABLE IF EXISTS `sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  `recipient` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms`
--

LOCK TABLES `sms` WRITE;
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
INSERT INTO `sms` VALUES (66,'1602711320','{address} ','All Patient','1');
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_settings`
--

DROP TABLE IF EXISTS `sms_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_settings` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `api_id` varchar(100) DEFAULT NULL,
  `sender` varchar(100) DEFAULT NULL,
  `authkey` varchar(100) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `sid` varchar(1000) DEFAULT NULL,
  `token` varchar(1000) DEFAULT NULL,
  `sendernumber` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_settings`
--

LOCK TABLES `sms_settings` WRITE;
/*!40000 ALTER TABLE `sms_settings` DISABLE KEYS */;
INSERT INTO `sms_settings` VALUES (1,'Clickatell','Clickatell','','API Id',NULL,NULL,'1',NULL,NULL,NULL),(2,'MSG91',NULL,NULL,NULL,'Sender','Auth Key','1',NULL,NULL,NULL),(5,'Twilio',NULL,NULL,NULL,NULL,NULL,'1','Twilio SID','Twilio Token Password','Sender Number');
/*!40000 ALTER TABLE `sms_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `superusers`
--

DROP TABLE IF EXISTS `superusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `superusers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `superusers`
--

LOCK TABLES `superusers` WRITE;
/*!40000 ALTER TABLE `superusers` DISABLE KEYS */;
INSERT INTO `superusers` VALUES (1,'127.0.0.1','SuperAdmin','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.','','superadmin@zuulumed.net','','eX0.Bq6nP57EuXX4hJkPHO973e7a4c25f1849d3a',1511432365,'zCeJpcj78CKqJ4sVxVbxcO',1268889823,1603199773,1,'Super','Admin','zuuluPay','766459226');
/*!40000 ALTER TABLE `superusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `template`
--

DROP TABLE IF EXISTS `template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `template` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `template` varchar(10000) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `template`
--

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;
INSERT INTO `template` VALUES (18,'Anémies parasitaires','<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n<thead>\r\n<tr>\r\n<th scope=\"col\">Cause de l&#39;an&eacute;mie</th>\r\n<th scope=\"col\">Type d&#39;an&eacute;mie</th>\r\n<th scope=\"col\">Diagnostic &eacute;tiologique</th>\r\n<th scope=\"col\">Traitement Sp&eacute;cifique</th>\r\n<th scope=\"col\">Risque chez le demandeur</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n','1',NULL),(5,'Pancytopénie','<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n<thead>\r\n<tr>\r\n<th scope=\"col\">Origine</th>\r\n<th scope=\"col\"><strong>&Eacute;tiologie</strong></th>\r\n<th scope=\"col\">Diagnostic positif</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n','1',''),(19,'Tests de diagnostic rapide du paludisme  (TDR)','<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\">\r\n<caption>Tests de diagnostic rapide du paludisme (TDR)</caption>\r\n<thead>\r\n<tr>\r\n<th scope=\"col\">Antig&egrave;ne</th>\r\n<th scope=\"col\">HRP2</th>\r\n<th scope=\"col\">pLDH</th>\r\n<th scope=\"col\">Aldolase</th>\r\n</tr>\r\n</thead>\r\n<tbody>\r\n<tr>\r\n<td>\r\n<p>&nbsp;</p>\r\n</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n','1',NULL),(22,'Modèle Général','<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<caption>R&Eacute;SULTATS DES ANALYSES</caption>\r\n	<thead>\r\n		<tr>\r\n			<th scope=\"col\">Analyse(s) Demand&eacute;es</th>\r\n			<th scope=\"col\">R&eacute;sultats</th>\r\n			<th scope=\"col\">Unit&eacute;</th>\r\n			<th scope=\"col\">Valeurs Usuelles</th>\r\n		</tr>\r\n	</thead>\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n','768',NULL);
/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_schedule`
--

DROP TABLE IF EXISTS `time_schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `time_schedule` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `doctor` varchar(500) DEFAULT NULL,
  `weekday` varchar(100) DEFAULT NULL,
  `s_time` varchar(100) DEFAULT NULL,
  `e_time` varchar(100) DEFAULT NULL,
  `s_time_key` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_schedule`
--

LOCK TABLES `time_schedule` WRITE;
/*!40000 ALTER TABLE `time_schedule` DISABLE KEYS */;
INSERT INTO `time_schedule` VALUES (106,'2','Saturday','09:30 PM','09:45 PM','258','3'),(107,'2','Friday','01:00 PM','01:45 PM','156','9');
/*!40000 ALTER TABLE `time_schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_slot`
--

DROP TABLE IF EXISTS `time_slot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `time_slot` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `doctor` varchar(100) DEFAULT NULL,
  `s_time` varchar(100) DEFAULT NULL,
  `e_time` varchar(100) DEFAULT NULL,
  `weekday` varchar(100) DEFAULT NULL,
  `s_time_key` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2194 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_slot`
--

LOCK TABLES `time_slot` WRITE;
/*!40000 ALTER TABLE `time_slot` DISABLE KEYS */;
INSERT INTO `time_slot` VALUES (2192,'2','09:30 PM','09:45 PM','Saturday','258'),(2193,'2','01:00 PM','01:45 PM','Friday','156');
/*!40000 ALTER TABLE `time_slot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_organisation` int(11) DEFAULT '0',
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `departement` varchar(255) DEFAULT NULL,
  `arrondissement` varchar(255) DEFAULT NULL,
  `collectivite` varchar(255) DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=780 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,3,'127.0.0.1','Admin','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.','','admin@zuulumed.net','','eX0.Bq6nP57EuXX4hJkPHO973e7a4c25f1849d3a',1511432365,'zCeJpcj78CKqJ4sVxVbxcO',1268889823,1604753972,1,'Admin','istrator','ADMIN','','Dakar','Dakar','Dakar','Almadies','Mermoz Sacre Coeur','Senegal'),(109,3,'113.11.74.192','Mrs Nurse','$2y$08$.k6VviLOxsnqscJljKNhleh/RM/DlPRnr8HSDuM6E8f4LHFpvgo4C',NULL,'nurse@hms.com',NULL,NULL,NULL,NULL,1435082243,1589204427,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(110,3,'113.11.74.192','Mr. Pharmacist','$2y$08$fVsWTRz1E.ThDRlkg4JI2uU2VPzVMcxVMJZzimnMtAz/9/KMbz/De',NULL,'pharmacist@hms.com',NULL,NULL,NULL,'mbeMop6vTuscFYmD2M4Iqu',1435082359,1589725150,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(111,3,'113.11.74.192','Mr Laboratorist','$2y$08$jdb3uf9SM.0SHiJfeeGnNuLEbx4VIbFKK.zLcnT5NliJrYjH6hlJe',NULL,'laboratorist@hms.com',NULL,NULL,NULL,NULL,1435082438,1585114573,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(112,3,'113.11.74.192','Mr. Accountant','$2y$08$F4Ejo00JtSnfCLdq6JH5..MRZtkF8LyxBM9h1W1DJiPKxgpje1wFu',NULL,'accountant@hms.com',NULL,NULL,NULL,NULL,1435082637,1585114360,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(610,3,'103.231.162.58','sdhsjgj','$2y$08$JBdbYvWr0BaswifulhauLOBizxRMnx1XZeuaUNJ6utt4AqH.7c/je',NULL,'jgjjhjgjh',NULL,NULL,NULL,NULL,1505800387,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(611,3,'103.231.162.58','vsgdvfds','$2y$08$N3qoioTmznb7./7dhrfXp.ZAp7H1Vu2rU.EWdFUx5z7ECcm.la7Ee',NULL,'hfhgfhfhgf',NULL,NULL,NULL,NULL,1505800659,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(612,3,'103.231.162.58','vsgdvfds1','$2y$08$rjDLi21IP2Dncaz/FgXkJ.DYoxoYigHOjgkv4MgQby.2UQ5G61qVm',NULL,'hfhgfhfhgfefeer',NULL,NULL,NULL,NULL,1505800739,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(614,3,'103.231.162.58','Mr Receptionist','$2y$08$3STMfH6pbBQcFHYyuvgxhuJAu3oG185C52NG5jsJqg1HeRxuMo4iC',NULL,'receptionist@hms.com',NULL,NULL,NULL,NULL,1505800835,1585114400,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(681,3,'103.231.161.30','Mr Patient','$2y$08$B2w5CPy8O.98Fj3pk84sKOrcVGt9uoaU/mOP957iWbjyyBkK74FBu',NULL,'patient@hms.com',NULL,NULL,NULL,NULL,1548872582,1592461797,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(709,3,'103.231.160.47','Mr Doctor','$2y$08$fXiMENyU5S5Tbnk9cn0k1.RMy9Sgjx7sa2RLWsj2RjMkgsTVPsAmq',NULL,'doctor@hms.com',NULL,NULL,NULL,NULL,1558379920,1592490822,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(723,3,'103.239.254.123','fdfd','$2y$08$DqKKnH7jo8ZtILrOxRvgMOG0ywi/Y4TgbQFdLJQMyCqwsywiUXrkq',NULL,'gfghfhg@ghjghj.com',NULL,NULL,NULL,NULL,1583211485,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(741,3,'41.82.100.196','Shaibal Saha','$2y$08$dNaGZyXuGv.0joesDJAvrOMpTu69HNc.LUZNwpNaWxBM2pqXLGDXG',NULL,'voter@example.com',NULL,NULL,NULL,NULL,1602710912,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(743,3,'41.83.216.122','Ibnou Abass Diagne','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.',NULL,'ino@zuulumed.net',NULL,NULL,NULL,NULL,1602710981,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(744,3,'41.83.216.122','cheikh ahmed diagne','$2y$08$K3Ixuv9.FqnzpUh1amtS7OyIm4YumChxRzNtbsHn3NaCYiJCfQqSy',NULL,'cheikh@gmail.com',NULL,NULL,NULL,NULL,1602711726,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(745,3,'41.83.216.122','Mina Diagne','$2y$08$Gy0SCEU0ySbrvNcxqo4Nt.D8CKdMiLpZW7WJ5CEgcH8a00X9n0IpO',NULL,'mina@gmail.com',NULL,NULL,NULL,NULL,1602712410,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(746,3,'41.83.216.122','Fatou Binetou Diagne','$2y$08$JXYwsJmPZ.CgJIu1NwYJwea1/QvqKyvjBv4UP0RaEJFf7nPWLiJka',NULL,'fifi@gmail.com',NULL,NULL,NULL,NULL,1602713875,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(747,3,'41.83.216.122','Aicha','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.',NULL,'pharmacien@zuulumed.net',NULL,NULL,NULL,NULL,1602713936,1603444478,1,'Aicha','Dia',NULL,'','Almadies','Dakar','Dakar','Almadies','Ngor','Senegal'),(748,3,'41.83.216.122','Rawane Diagne','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.',NULL,'laboratoire@zuulumed.net',NULL,NULL,NULL,NULL,1602714074,1603444352,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(749,3,'41.82.100.196','FAYE ROKHAYA','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.',NULL,'infirmiere@zuulumed.net',NULL,NULL,NULL,NULL,1602714106,1604593218,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(750,3,'41.83.216.122','Aissatou','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.',NULL,'comptable@zuulumed.net',NULL,NULL,NULL,NULL,1602714134,1602714788,1,'Aissatou','Sy',NULL,'','Mermoz','Dakar','Dakar','Almadies','Mermoz Sacre Coeur','Senegal'),(752,3,'41.83.216.122','Alassane Sarr','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.',NULL,'receptionniste@zuulumed.net',NULL,NULL,NULL,NULL,1602714220,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(753,3,'96.22.98.166','Mary DOE','$2y$08$jAbphAL/n1g.RKsqCtt2z.Y/X8ycO9FnhHPc3OI9P4yu8HahAlL22',NULL,'mary.doe@yahoo.com',NULL,NULL,NULL,NULL,1602718584,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(754,3,'96.22.98.166','Jane','0',NULL,'jane.doe@hotmail.com',NULL,NULL,NULL,NULL,1602788285,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(755,3,'41.82.122.152','FAYE','$2y$08$53oU.N5SOTUmsKCo3cxbCeqnbhIO6n9BfenhuSpKRUmrA0im4aYwy',NULL,'drfaye@zuulunet.net',NULL,NULL,NULL,NULL,1602791919,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(756,3,'154.125.180.80','roky','0',NULL,'rokhaya.faye@zuulu.net',NULL,NULL,NULL,NULL,1602895782,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(757,3,'96.22.98.166','Bouba','0',NULL,'bouba_diouf@gmail.com',NULL,NULL,NULL,NULL,1602956280,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(758,3,'154.125.19.151','deproky','0',NULL,'deproky@788888888.com',NULL,NULL,NULL,NULL,1603121064,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(759,3,'41.82.25.2','iroki','0',NULL,'iroki@788888888.com',NULL,NULL,NULL,NULL,1603382640,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(760,3,'154.124.83.108','ino','$2y$08$U6S7DP6wkmjy2nS54C5XFOvmPIO38m7GU9ZOv1jdtkRtdx1JNYNqq',NULL,'Médecine Générale',NULL,NULL,NULL,NULL,1603586907,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(761,1,'41.83.201.127','Alassane','$2y$08$Vzizam6TGdyDze3JGFNnpe4eouTg57fBE4FM9eYqxWUt9ZxOafUnm',NULL,'alassane.sarr@zuulu.net',NULL,NULL,NULL,NULL,1603611958,1604749324,1,'Alassane','Sarr',NULL,'766459226','Villa Khadija, Rte du Ngor Diarama','Dakar','Dakar','Almadies','Ngor','Senegal'),(762,3,'96.22.98.166','Getrude','0',NULL,'gertrud@raymond.com',NULL,NULL,NULL,NULL,1603640377,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(763,3,'96.22.98.166','Joseph','0',NULL,'samba_diallo@yahoo.de',NULL,NULL,NULL,NULL,1603642795,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(764,2,'41.83.199.1','Samba','$2y$08$91QSU2Ozx2e4r/PJzVYqn.5rofkJwUT1oO8mkLIoywo5KqhKB62a6',NULL,'admin@orozen.net',NULL,NULL,NULL,NULL,1603723353,1603799180,1,'Samba','Diallo',NULL,'','Somewhere','Dakar','Dakar','Almadies','Mermoz Sacre Coeur','Senegal'),(765,3,'154.124.84.205','Ramata','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.',NULL,'ramata@zuulumed.net',NULL,NULL,NULL,NULL,1603884706,1603907224,1,'Ramata','Fall',NULL,'','Niary Tally','Dakar','Dakar','Grand Dakar','Biscuiterie ','Senegal'),(766,1,'41.83.201.26','Ousseynou','$2y$08$sTs1ukNpuF/nxIIYwC2WYe9XV2IO4pZ.jESeLELDqXquomPG.m.S.',NULL,'ousseynou@zuulumed.net',NULL,NULL,NULL,NULL,1603900753,NULL,1,'Ousseynou','Sy',NULL,'766459226','Yoff','Dakar','Dakar','Parcelles Assainies','Parcelles Assainies','Senegal'),(767,3,'154.124.84.99','ibnou abass','$2y$08$SIoUkxM6m0xRPg.CoqGX9ObOoCJN.ljAykFkzSDdBd/AeKZ1TtAzW',NULL,'ibou@zuulu.net',NULL,NULL,NULL,NULL,1603923952,1603923966,1,'ibnou abass','diagne',NULL,'','Dakar','Dakar','Dakar','Parcelles Assainies','Camberene','Senegal'),(768,1,'41.83.242.56','Samba1','$2y$08$mFhDb7dojWQ5nrGSwKfomOYVrP2fWWBuWzKd6Rv0vP4gcrxoobVxS',NULL,'samba.diallo@zuulu.net',NULL,NULL,NULL,NULL,1604085481,1604338433,1,'Samba','Diall',NULL,'','Almadies','Dakar','Dakar','Almadies','','Senegal'),(769,4,'154.125.190.247','ROKHAYA','$2y$08$fbYTO5xRjHXNhn.Sdcr.BeW.oz0kV91pwZ70SXNyYQPvjhGeFixMq',NULL,'rf@zuulumed.net',NULL,NULL,NULL,NULL,1604321138,1604753772,1,'ROKHAYA','FAYE',NULL,'','THIES','Thies','Mbour','Sindia','Diass','Senegal'),(770,0,'41.82.29.154','FAYE hopital zfs','0',NULL,'admin44@zuulumed.net',NULL,NULL,NULL,NULL,1604404372,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(771,0,'41.82.102.218','FA','0',NULL,'admssssin@hms.com',NULL,NULL,NULL,NULL,1604425123,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(772,0,'154.125.192.249','gaya','0',NULL,'rok@rok.fr',NULL,NULL,NULL,NULL,1604446074,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(773,0,'154.125.211.133','Abdoulaye','0',NULL,'abdoulaye.fall@zuulu.net',NULL,NULL,NULL,NULL,1604513305,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(774,7,'154.125.172.135','FAYE','$2y$08$ClHUb3nnr1yjKnpQk/0TJ.pVix599hSzXzi0Ke3wcg7KqTitFASyC',NULL,'rfff@zuulumefd.net',NULL,NULL,NULL,NULL,1604528398,1604528477,1,'FAYE','ROKHAYA',NULL,'0786006831','SENEGAL+','Diourbel','Diourbel','Ndindy','Keur Ngalgou','Senegal'),(775,0,'41.83.200.162','Alassane1','0',NULL,'kheush@hotmail.com',NULL,NULL,NULL,NULL,1604570429,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(776,0,'41.83.200.162','Ndeye','0',NULL,'Ndeye@766459226.com',NULL,NULL,NULL,NULL,1604571147,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(777,0,'41.83.200.162','NoName','0',NULL,'NoName@766459226.com',NULL,NULL,NULL,NULL,1604571242,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(778,8,'41.82.160.176','FAYE1','$2y$08$WLHteNtthJm2TRALkLpGZO.CqDtpTkPqn2CKFtj0BgnMiM5knqgMG',NULL,'rf2@zuulumed.net',NULL,NULL,NULL,NULL,1604741447,1604743406,1,'FAYE','ROKHAYA',NULL,'0786006831','SENEGAL','Kaffrine','Kaffrine','','','Senegal'),(779,8,'41.82.160.176','dr fff','$2y$08$D4tXrHRujLLpGOZ.SbfQZe.CDghmLFxlPbz.2KN14D7HgsCc4e6sW',NULL,'doc@zuulumed.net',NULL,NULL,NULL,NULL,1604745321,1604745384,1,'dr fff','dddddd',NULL,'0786006831','SENEGAL','Louga','Kebemer','','','Senegal');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=782 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,1,1),(111,109,6),(112,110,7),(113,111,8),(114,112,3),(613,611,10),(614,612,10),(616,614,10),(683,681,5),(711,709,4),(725,723,5),(743,741,5),(745,743,4),(746,744,5),(747,745,5),(748,746,6),(749,747,7),(750,748,8),(751,749,6),(752,750,3),(754,752,10),(755,753,5),(756,754,5),(757,755,4),(758,756,5),(759,757,5),(760,758,5),(761,759,5),(762,760,4),(763,761,1),(764,762,5),(765,763,5),(766,764,1),(767,765,1),(768,766,4),(769,767,4),(770,768,1),(771,769,1),(772,770,5),(773,771,5),(774,772,5),(775,773,5),(776,774,1),(777,775,5),(778,776,5),(779,777,5),(780,778,1),(781,779,4);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `website_settings`
--

DROP TABLE IF EXISTS `website_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `website_settings` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `logo` varchar(1000) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `emergency` varchar(100) DEFAULT NULL,
  `support` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `currency` varchar(100) DEFAULT NULL,
  `block_1_text_under_title` varchar(500) DEFAULT NULL,
  `service_block__text_under_title` varchar(500) DEFAULT NULL,
  `doctor_block__text_under_title` varchar(500) DEFAULT NULL,
  `facebook_id` varchar(100) DEFAULT NULL,
  `twitter_id` varchar(100) DEFAULT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `youtube_id` varchar(100) DEFAULT NULL,
  `skype_id` varchar(100) DEFAULT NULL,
  `x` varchar(100) DEFAULT NULL,
  `twitter_username` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website_settings`
--

LOCK TABLES `website_settings` WRITE;
/*!40000 ALTER TABLE `website_settings` DISABLE KEYS */;
INSERT INTO `website_settings` VALUES (1,'Orozen Dental Spa','uploads/orozen.jpg','thies','780000000','+0123456789','+0123456789','admin@demo.com','cfa','Meilleure Clinique Dentaire de Montreal','Aenean nibh ante, lacinia non tincidunt nec, lobortis ut tellus. Sed in porta diam.','on prend soin de vos dents et de vous','https://www.facebook.com/rizvi.plabon','https://www.twitter.com/casoft','https://www.google.com/casoft','https://www.youtube.com/casoft','https://www.skype.com/casoft',NULL,'orozen');
/*!40000 ALTER TABLE `website_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'dbzuulumed'
--

--
-- Dumping routines for database 'dbzuulumed'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-11-07 15:53:51
