-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 04 avr. 2024 à 19:31
-- Version du serveur : 8.0.36
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum_laure`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(1, 'Art'),
(2, 'Fiction'),
(3, 'Cooking'),
(4, 'Science'),
(5, 'Technologie');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id_post` int NOT NULL,
  `texte` text NOT NULL,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `topic_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id_post`, `texte`, `dateCreation`, `user_id`, `topic_id`) VALUES
(1, 'Painting during centuries', '2024-03-19 11:12:47', 3, 1),
(2, 'My fav movies from all times', '2024-03-19 11:14:28', 4, 2),
(3, 'I think one of my favorite are the one with mozzarella, tomatoes and basil. That\'s obviously from Italy.', '2024-03-20 10:47:03', 4, 3),
(4, 'In the vast tapestry of human expression, few art forms resonate as deeply and universally as music. It transcends cultural boundaries, languages, and generations, weaving its enchanting melodies into the very fabric of our lives. From the rhythmic beats of ancient drums to the soaring crescendos of contemporary symphonies, music has been an integral part of human existence, serving as a conduit for emotions, stories, and connections.\r\n\r\nAt its core, music is a language of the soul, speaking directly to our hearts and minds in ways that words often cannot. It has the power to evoke memories long forgotten, stir passions buried deep within, and transport us to distant realms of imagination. Whether its the haunting strains of a melancholic ballad or the infectious rhythms of a lively dance tune, music has the remarkable ability to elicit a myriad of emotions, painting the canvas of our lives with vibrant hues of joy, sorrow, love, and longing.\r\n\r\nBut beyond its emotional resonance, music also serves as a unifying force, bringing people together in shared moments of harmony and understanding. In a world often divided by differences, music has the extraordinary capacity to bridge the gaps between cultures, fostering empathy, compassion, and mutual respect. Whether its through collaborative performances that blend diverse musical traditions or spontaneous jam sessions among strangers, music has the remarkable ability to dissolve barriers and forge connections that transcend borders and ideologies.\r\n\r\nMoreover, music is not merely a passive form of entertainment but a dynamic force for change and inspiration. Throughout history, it has played a pivotal role in social movements, serving as a rallying cry for justice, freedom, and equality. From the protest songs of the civil rights era to the anthems of resistance in times of oppression, music has empowered individuals to raise their voices in solidarity and defiance, igniting movements that have reshaped the course of history.\r\n\r\nIn todays digital age, music continues to evolve and adapt, embracing new technologies and genres that push the boundaries of creativity and innovation. From the emergence of electronic dance music to the fusion of traditional folk tunes with modern sounds, the landscape of music is constantly evolving, reflecting the ever-changing tapestry of human experience.\r\n\r\nIn essence, music is more than just a sequence of notes or lyrics—it is a timeless expression of the human spirit, a testament to our capacity for beauty, empathy, and connection. So whether you find solace in the soothing melodies of a classical symphony, the raw energy of a rock concert, or the infectious rhythms of a jazz ensemble, remember that in the language of music, we find a common ground that unites us all in the harmonies of our shared humanity.', '2024-03-20 13:47:26', 3, 4),
(5, 'There are much more than in winter, for sure', '2024-03-22 09:21:35', 3, 13),
(6, 'This is a post about quantum physics.', '2024-03-23 10:15:00', 4, 18),
(7, 'I\'m so fascinated and admirating about artificial intelligence progress!', '2024-03-22 15:00:00', 3, 19),
(8, 'What are your favorite work of art from the XXIe century?', '2024-03-21 10:00:00', 3, 20),
(9, 'Classical music are beyond the era and centuries.', '2024-03-20 18:45:00', 3, 21),
(10, 'My fav serie from all time is probably ....', '2024-03-25 10:32:14', 4, 22),
(11, 'blablabla', '2024-03-25 14:03:29', 4, 23),
(13, 'blaaaaaa', '2024-03-27 10:12:13', 3, 23),
(14, 'reblabla', '2024-03-27 10:12:40', NULL, 23),
(15, 'Test', '2024-03-27 15:06:56', NULL, 25);

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE `topic` (
  `id_topic` int NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verouillage` tinyint DEFAULT '0',
  `category_id` int NOT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `topic`
--

INSERT INTO `topic` (`id_topic`, `titre`, `dateCreation`, `verouillage`, `category_id`, `user_id`) VALUES
(1, 'Painting', '2024-03-19 11:11:58', 0, 1, 4),
(2, 'Movies', '2024-03-19 11:14:08', 0, 2, 3),
(3, 'Pasta', '2024-03-20 09:13:46', 0, 3, 4),
(4, 'Music', '2024-03-20 09:14:20', 0, 1, 3),
(13, 'Summer fruits', '2024-03-22 09:21:35', 0, 3, 3),
(18, 'Quantum physics', '2024-03-23 10:00:00', 0, 4, 4),
(19, 'The latest advances in artificial intelligence', '2024-03-22 14:30:00', 0, 5, 4),
(20, 'XXIe century art', '2024-03-21 09:45:00', 1, 1, 3),
(21, 'Influences of classical music on modern music', '2024-03-20 18:20:00', 0, 1, 3),
(22, 'Series', '2024-03-25 10:32:14', 1, 2, 4),
(23, 'test', '2024-03-25 14:03:29', 0, 5, NULL),
(25, 'Mon topic', '2024-03-27 15:06:56', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `motDePasse` varchar(255) NOT NULL,
  `dateInscription` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'ROLE_USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `email`, `pseudo`, `motDePasse`, `dateInscription`, `role`) VALUES
(3, 'laureS@exemple.fr', '@laureS', '$2y$10$8SLqlb6add7VuOCMQrYIVelYbrp0gJ28LoesakpgPbhwyLhjJaSDS', '2024-03-20 16:24:12', 'ROLE_USER'),
(4, 'prenom@hotmail.com', '@prenom', '$2y$10$LWZ3n507M65QRv84PTYDpehe1Js/D5OVmxs94gonWambXMyMq268.', '2024-03-25 09:44:08', 'ROLE_ADMIN'),
(7, 'micka@exemple.com', 'micka', '$2y$10$tySfRAdfdJurFHYKwWYFZePWRH9FA3fZ3mQNyjaYff5Y0lyKt3PHW', '2024-03-27 15:10:52', 'ROLE_USER');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`) USING BTREE;

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`) USING BTREE,
  ADD KEY `FK_message_sujet` (`topic_id`) USING BTREE,
  ADD KEY `FK_message_membre` (`user_id`) USING BTREE;

--
-- Index pour la table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id_topic`) USING BTREE,
  ADD KEY `FK_sujet_membre` (`user_id`) USING BTREE,
  ADD KEY `FK_sujet_categorie` (`category_id`) USING BTREE;

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `topic`
--
ALTER TABLE `topic`
  MODIFY `id_topic` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_message_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_message_sujet` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `FK_sujet_categorie` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sujet_membre` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
