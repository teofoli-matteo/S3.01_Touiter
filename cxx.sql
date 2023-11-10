-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 10 nov. 2023 à 19:02
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cxx`
--

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `IdTouite` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`IdTouite`, `url`, `description`) VALUES
(1, 'img/profile-picture.jpg', NULL),
(2, 'img/image.jpeg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `listetouites_tag`
--

CREATE TABLE `listetouites_tag` (
  `idTouite` int(11) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `listetouites_tag`
--

INSERT INTO `listetouites_tag` (`idTouite`, `idTag`) VALUES
(1, 1),
(2, 2),
(3, 2),
(1067271, 9),
(1067272, 10),
(1067273, 11),
(1067274, 12);

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `idUser` varchar(32) NOT NULL,
  `idTouite` int(11) NOT NULL,
  `Likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `IdTouite` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `nbMention` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tagtest`
--

CREATE TABLE `tagtest` (
  `idTag` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tagtest`
--

INSERT INTO `tagtest` (`idTag`, `libelle`, `description`) VALUES
(2, 'cat', 'Posts mentionnant les chats.'),
(3, 'bg', 'Beau gosse'),
(9, 'cat', ''),
(10, 'Gratitude', ''),
(11, 'Gandhi', ''),
(12, 'gratitude', '');

-- --------------------------------------------------------

--
-- Structure de la table `touite`
--

CREATE TABLE `touite` (
  `idTouite` int(11) NOT NULL,
  `idUser` varchar(32) DEFAULT NULL,
  `dateTouite` datetime DEFAULT NULL,
  `message` varchar(235) DEFAULT NULL,
  `nbLike` int(11) DEFAULT NULL,
  `nbDislike` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `touite`
--

INSERT INTO `touite` (`idTouite`, `idUser`, `dateTouite`, `message`, `nbLike`, `nbDislike`) VALUES
(1067271, 'linouts', '2023-11-10 18:49:07', 'Le Chat domestique est une espèce de mammifères carnivores, de la famille des Félidés. #cat', 0, 0),
(1067272, 'linouts', '2023-11-10 18:50:55', 'Se sentir reconnaissant(e) pour les petits moments qui apportent de la joie dans nos vies <3\r\n#Gratitude ', 0, 0),
(1067273, 'matt', '2023-11-10 18:55:32', 'Soyez le changement que vous voulez voir dans le monde. #Gandhi', 0, 0),
(1067274, 'matt', '2023-11-10 18:56:12', 'Chaque journée est une nouvelle occasion de changer votre vie. #gratitude', 0, 0),
(1067275, 'ale', '2023-11-10 18:58:08', 'Le succès n\'est pas la clé du bonheur. Le bonheur est la clé du succès. Si vous aimez ce que vous faites, vous réussirez.', 0, 0),
(1067276, 'ale', '2023-11-10 19:00:02', 'Le succès consiste à passer d\'échec en échec sans perdre son enthousiasme.', 0, 0),
(1067277, 'lh', '2023-11-10 19:01:19', 'La plus grande gloire n\'est pas de ne jamais tomber, mais de se relever à chaque chute.', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `passwd` varchar(512) NOT NULL,
  `nbFollower` int(11) DEFAULT 0,
  `nom` varchar(64) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `role` varchar(10) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `email`, `passwd`, `nbFollower`, `nom`, `prenom`, `role`) VALUES
('ale', 'ac@gmail.com', '$2y$10$bHjdtHFKuAvtlWqKv.g8Ze6qPQIp7.YxH18R/UYOwGYK35mJHRaim', 0, 'collin', 'alex', '0'),
('lh', 'lh@gmail.com', '$2y$10$dP3BM02UVzfSNS7RR.DE7epnCzgrcv4JXyYaFWf70e4SVTiFRxCq2', 0, 'harouna', 'laeticia', '0'),
('linouts', 'lt@gmail.com', '$2y$10$05qieaL45LHUB9Zj8z/qK.c0LmVTR9QsFHEzi1cAzZuI2RHK9o90y', 0, 'terras', 'lina', '1'),
('matt', 'mt@gmail.com', '$2y$10$424cA87820cF.M8xuFUnduJEZsBaJ3rjTxUBTg7P0vYDEuB.FvbdC', 0, 'teofoli', 'matteo', '0');

-- --------------------------------------------------------

--
-- Structure de la table `user_followers`
--

CREATE TABLE `user_followers` (
  `idUser` varchar(32) NOT NULL,
  `followerId` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_followers`
--

INSERT INTO `user_followers` (`idUser`, `followerId`) VALUES
('ale', 'lh'),
('lh', 'linouts'),
('linouts', 'ale'),
('linouts', 'matt'),
('matt', 'ale');

-- --------------------------------------------------------

--
-- Structure de la table `user_tag`
--

CREATE TABLE `user_tag` (
  `idUser` varchar(32) NOT NULL,
  `idTag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_tag`
--

INSERT INTO `user_tag` (`idUser`, `idTag`) VALUES
('ale', 3),
('ale', 9),
('ale', 10),
('lh', 11),
('lh', 12),
('linouts', 9);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`IdTouite`,`url`),
  ADD KEY `idTouite` (`IdTouite`);

--
-- Index pour la table `listetouites_tag`
--
ALTER TABLE `listetouites_tag`
  ADD PRIMARY KEY (`idTouite`,`idTag`),
  ADD KEY `idTag` (`idTag`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`idUser`,`idTouite`),
  ADD KEY `idTouite` (`idTouite`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`IdTouite`,`libelle`);

--
-- Index pour la table `tagtest`
--
ALTER TABLE `tagtest`
  ADD PRIMARY KEY (`idTag`);

--
-- Index pour la table `touite`
--
ALTER TABLE `touite`
  ADD PRIMARY KEY (`idTouite`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- Index pour la table `user_followers`
--
ALTER TABLE `user_followers`
  ADD PRIMARY KEY (`idUser`,`followerId`),
  ADD KEY `followerId` (`followerId`);

--
-- Index pour la table `user_tag`
--
ALTER TABLE `user_tag`
  ADD PRIMARY KEY (`idUser`,`idTag`),
  ADD KEY `idTag` (`idTag`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tagtest`
--
ALTER TABLE `tagtest`
  MODIFY `idTag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `touite`
--
ALTER TABLE `touite`
  MODIFY `idTouite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1067278;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
