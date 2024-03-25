-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_laure
CREATE DATABASE IF NOT EXISTS `forum_laure` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_laure`;

-- Listage de la structure de table forum_laure. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id_category`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_laure.category : ~2 rows (environ)
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'Art'),
	(2, 'Fiction'),
	(3, 'Cooking'),
	(4, 'Science'),
	(5, 'Technologie');

-- Listage de la structure de table forum_laure. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `texte` text NOT NULL,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  PRIMARY KEY (`id_post`) USING BTREE,
  KEY `FK_message_sujet` (`topic_id`) USING BTREE,
  KEY `FK_message_membre` (`user_id`) USING BTREE,
  CONSTRAINT `FK_message_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_message_sujet` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_laure.post : ~11 rows (environ)
INSERT INTO `post` (`id_post`, `texte`, `dateCreation`, `user_id`, `topic_id`) VALUES
	(1, 'Painting during centuries', '2024-03-19 11:12:47', 1, 1),
	(2, 'My fav movies from all times', '2024-03-19 11:14:28', 2, 2),
	(3, 'I think one of my favorite are the one with mozzarella, tomatoes and basil. That\'s obviously from Italy.', '2024-03-20 10:47:03', 1, 3),
	(4, 'In the vast tapestry of human expression, few art forms resonate as deeply and universally as music. It transcends cultural boundaries, languages, and generations, weaving its enchanting melodies into the very fabric of our lives. From the rhythmic beats of ancient drums to the soaring crescendos of contemporary symphonies, music has been an integral part of human existence, serving as a conduit for emotions, stories, and connections.\r\n\r\nAt its core, music is a language of the soul, speaking directly to our hearts and minds in ways that words often cannot. It has the power to evoke memories long forgotten, stir passions buried deep within, and transport us to distant realms of imagination. Whether its the haunting strains of a melancholic ballad or the infectious rhythms of a lively dance tune, music has the remarkable ability to elicit a myriad of emotions, painting the canvas of our lives with vibrant hues of joy, sorrow, love, and longing.\r\n\r\nBut beyond its emotional resonance, music also serves as a unifying force, bringing people together in shared moments of harmony and understanding. In a world often divided by differences, music has the extraordinary capacity to bridge the gaps between cultures, fostering empathy, compassion, and mutual respect. Whether its through collaborative performances that blend diverse musical traditions or spontaneous jam sessions among strangers, music has the remarkable ability to dissolve barriers and forge connections that transcend borders and ideologies.\r\n\r\nMoreover, music is not merely a passive form of entertainment but a dynamic force for change and inspiration. Throughout history, it has played a pivotal role in social movements, serving as a rallying cry for justice, freedom, and equality. From the protest songs of the civil rights era to the anthems of resistance in times of oppression, music has empowered individuals to raise their voices in solidarity and defiance, igniting movements that have reshaped the course of history.\r\n\r\nIn todays digital age, music continues to evolve and adapt, embracing new technologies and genres that push the boundaries of creativity and innovation. From the emergence of electronic dance music to the fusion of traditional folk tunes with modern sounds, the landscape of music is constantly evolving, reflecting the ever-changing tapestry of human experience.\r\n\r\nIn essence, music is more than just a sequence of notes or lyrics—it is a timeless expression of the human spirit, a testament to our capacity for beauty, empathy, and connection. So whether you find solace in the soothing melodies of a classical symphony, the raw energy of a rock concert, or the infectious rhythms of a jazz ensemble, remember that in the language of music, we find a common ground that unites us all in the harmonies of our shared humanity.', '2024-03-20 13:47:26', 2, 4),
	(5, 'There are much more than in winter, for sure', '2024-03-22 09:21:35', 3, 13),
	(6, 'This is a post about quantum physics.', '2024-03-23 10:15:00', 1, 18),
	(7, 'I\'m so fascinated and admirating about artificial intelligence progress!', '2024-03-22 15:00:00', 2, 19),
	(8, 'What are your favorite work of art from the XXIe century?', '2024-03-21 10:00:00', 3, 20),
	(9, 'Classical music are beyond the era and centuries.', '2024-03-20 18:45:00', 3, 21),
	(10, 'My fav serie from all time is probably ....', '2024-03-25 10:32:14', 4, 22),
	(11, 'blablabla', '2024-03-25 14:03:29', 4, 23);

-- Listage de la structure de table forum_laure. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verouillage` tinyint DEFAULT '0',
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_topic`) USING BTREE,
  KEY `FK_sujet_membre` (`user_id`) USING BTREE,
  KEY `FK_sujet_categorie` (`category_id`) USING BTREE,
  CONSTRAINT `FK_sujet_categorie` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_sujet_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_laure.topic : ~11 rows (environ)
INSERT INTO `topic` (`id_topic`, `titre`, `dateCreation`, `verouillage`, `category_id`, `user_id`) VALUES
	(1, 'Painting', '2024-03-19 11:11:58', 0, 1, 1),
	(2, 'Movies', '2024-03-19 11:14:08', 0, 2, 2),
	(3, 'Pasta', '2024-03-20 09:13:46', 0, 3, 2),
	(4, 'Music', '2024-03-20 09:14:20', 0, 1, 2),
	(13, 'Summer fruits', '2024-03-22 09:21:35', 0, 3, 3),
	(18, 'La physique quantique', '2024-03-23 10:00:00', 0, 5, 1),
	(19, 'Les dernières avancées en intelligence artificielle', '2024-03-22 14:30:00', 0, 4, 2),
	(20, 'L\'art du XXIe siècle', '2024-03-21 09:45:00', 0, 1, 3),
	(21, 'Influences de la musique classique sur la musique moderne', '2024-03-20 18:20:00', 0, 1, 3),
	(22, 'Series', '2024-03-25 10:32:14', 0, 2, 4),
	(23, 'test', '2024-03-25 14:03:29', 0, 2, 4);

-- Listage de la structure de table forum_laure. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `dateInscription` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'ROLE_USER',
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_laure.user : ~4 rows (environ)
INSERT INTO `user` (`id_user`, `email`, `pseudo`, `motDePasse`, `dateInscription`, `role`) VALUES
	(1, 'laure@exemple.com', '@laure', '123456', '2024-03-19 11:04:45', 'ROLE_USER'),
	(2, 'laure.exemple@exemple.com', '@laure1', '123456', '2024-03-19 11:13:38', 'ROLE_USER'),
	(3, 'laureS@exemple.fr', '@laureS', '$2y$10$8SLqlb6add7VuOCMQrYIVelYbrp0gJ28LoesakpgPbhwyLhjJaSDS', '2024-03-20 16:24:12', 'ROLE_ADMIN'),
	(4, 'prenom@hotmail.com', '@prenom', '$2y$10$LWZ3n507M65QRv84PTYDpehe1Js/D5OVmxs94gonWambXMyMq268.', '2024-03-25 09:44:08', 'ROLE_USER');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
