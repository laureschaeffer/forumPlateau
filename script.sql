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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_laure.category : ~2 rows (environ)
INSERT INTO `category` (`id_category`, `name`) VALUES
	(1, 'Art'),
	(2, 'Fiction'),
	(3, 'Cooking');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_laure.post : ~2 rows (environ)
INSERT INTO `post` (`id_post`, `texte`, `dateCreation`, `user_id`, `topic_id`) VALUES
	(1, 'Painting during centuries', '2024-03-19 11:12:47', 1, 1),
	(2, 'My fav movies from all times', '2024-03-19 11:14:28', 2, 2),
	(3, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias quod quisquam sit voluptatum consequuntur culpa blanditiis! Alias numquam totam enim nulla natus sapiente eligendi fugit minima, nam iure ducimus labore.\r\n    Ipsam amet blanditiis, et, voluptate sed esse veritatis ratione dolorem optio quos, consectetur laborum animi corporis accusamus error delectus magnam impedit fugit placeat labore eum vitae! Dolor harum eaque voluptate?', '2024-03-20 10:47:03', 1, 3),
	(4, 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Alias quod quisquam sit voluptatum consequuntur culpa blanditiis! Alias numquam totam enim nulla natus sapiente eligendi fugit minima, nam iure ducimus labore.', '2024-03-20 13:47:26', 2, 4);

-- Listage de la structure de table forum_laure. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verouillage` tinyint NOT NULL DEFAULT '0',
  `category_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_topic`) USING BTREE,
  KEY `FK_sujet_membre` (`user_id`) USING BTREE,
  KEY `FK_sujet_categorie` (`category_id`) USING BTREE,
  CONSTRAINT `FK_sujet_categorie` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_sujet_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_laure.topic : ~2 rows (environ)
INSERT INTO `topic` (`id_topic`, `titre`, `dateCreation`, `verouillage`, `category_id`, `user_id`) VALUES
	(1, 'Painting', '2024-03-19 11:11:58', 0, 1, 1),
	(2, 'Movies', '2024-03-19 11:14:08', 0, 2, 2),
	(3, 'Pasta', '2024-03-20 09:13:46', 0, 3, 2),
	(4, 'Music', '2024-03-20 09:14:20', 0, 1, 2);

-- Listage de la structure de table forum_laure. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `dateInscription` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_laure.user : ~3 rows (environ)
INSERT INTO `user` (`id_user`, `email`, `pseudo`, `motDePasse`, `dateInscription`, `role`) VALUES
	(1, 'laure@exemple.com', '@laure', '123456', '2024-03-19 11:04:45', NULL),
	(2, 'laure.exemple@exemple.com', '@laure1', '123456', '2024-03-19 11:13:38', NULL),
	(3, 'laureS@exemple.fr', '@laureS', '$2y$10$8SLqlb6add7VuOCMQrYIVelYbrp0gJ28LoesakpgPbhwyLhjJaSDS', '2024-03-20 16:24:12', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
