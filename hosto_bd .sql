-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 21 août 2024 à 18:35
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hosto_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `idadmin` int(15) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `tel` int(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tof` varchar(255) NOT NULL,
  `mdp` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`idadmin`, `nom`, `prenom`, `tel`, `email`, `tof`, `mdp`) VALUES
(1, 'singui', 'brice', 653861183, 'brice@gmail.com', '../img/Capture 2024-08-11 215650.png', '$2y$10$KCJ/0');

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

CREATE TABLE `consultation` (
  `id` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `docteur`
--

CREATE TABLE `docteur` (
  `iddocteur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `tel` int(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cni` varchar(255) NOT NULL,
  `tof` varchar(255) NOT NULL,
  `idspecialiste` int(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `diplome` varchar(255) NOT NULL,
  `certificat` varchar(255) NOT NULL,
  `mdp` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `docteur`
--

INSERT INTO `docteur` (`iddocteur`, `nom`, `prenom`, `tel`, `email`, `cni`, `tof`, `idspecialiste`, `grade`, `diplome`, `certificat`, `mdp`) VALUES
(16, 'EBAMI', 'manou', 2147483647, 'man@gmail.com', 'img/16.jpg', 'img/15.jpg', 4, 'dtfygh', 'img/12.jpg', 'img/17.jpg', '$2y$10$SrCgI'),
(17, 'EBAMI', 'manou', 2147483647, 'mane@gmail.com', 'img/16.jpg', 'img/15.jpg', 1, 'dtfygh', 'img/18.jpg', 'img/17.jpg', '$2y$10$lg4ZW'),
(18, 'PAPOUKA', 'lory', 653861183, 'papouka@gmail.com', 'img/17.jpg', 'img/16.jpg', 4, 'dtfygh', 'img/12.jpg', 'img/14.jpg', '$2y$10$eqz2r'),
(19, 'PAPOUKA', 'lory', 653861183, 'papouk@gmail.com', 'img/17.jpg', 'img/16.jpg', 4, 'dtfygh', 'img/12.jpg', 'img/14.jpg', '$2y$10$Q0Ujr');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `idpatient` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `tel` int(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(12) NOT NULL,
  `tof` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`idpatient`, `nom`, `prenom`, `tel`, `email`, `mdp`, `tof`) VALUES
(3, 'ebakisse', 'victoire', 1234567890, 'victoire@gmail.com', '$2y$10$kAJZf', ''),
(4, 'sindjui', 'brice', 1234567890, 'victoir@gmail.com', '$2y$10$bepPx', ''),
(5, 'ebakisse', 'victoire', 1234567890, 'aimee@gmail.com', '$2y$10$ZEFKF', 'image/Capture d\'écran 2024-08-05 110219.png'),
(6, 'ebami', 'marionne', 657956633, 'ebami@gmail.com', '$2y$10$IazZq', 'image/Capture d\'écran 2024-08-02 100052.png'),
(7, 'bisseki', 'lory', 1234567890, 'papoukalory@gmail.com', '$2y$10$jWOId', 'image/mcd.png'),
(9, 'bitom', 'richelot ', 1234567, 'bitom@gmail.com', '$2y$10$o6cwd', 'img/Capture d\'écran 2024-08-05 110219.png'),
(10, 'bisseki', 'lory', 12346780, 'maman@gmail.com', '$2y$10$Gvf1m', 'img/WhatsApp Image 2024-08-04 à 14.53.16_a1128bb7.jpg'),
(11, 'bitom', 'richelot ', 1234567, 'bito@gmail.com', '$2y$10$U.rhV', 'img/Capture d\'écran 2024-08-02 100052.png'),
(12, 'bitom', 'richelot', 1234567890, 'vit@gmail.com', '$2y$10$pur9S', 'img/mcd.png'),
(15, 'bisseki', 'adoudou', 653861183, 'adoudou@gmail.com', '$2y$10$M/5L/', 'img/mcd.png'),
(16, 'Emagou', 'marciale', 674542148, 'papa@gmail.com', '$2y$10$ix1sL', 'img/Capture d\'écran 2024-08-05 110219.png'),
(18, 'lory', 'manou', 2147483647, 'manou@gmail.com', '$2y$10$/rkiz', 'img/Capture d\'écran 2024-08-11 215650.png'),
(19, 'NKOUEBO', 'PEGUY', 678563771, 'peguynkouebo100@gmail.com', '$2y$10$fIYLM', 'img/WhatsApp Image 2024-07-21 à 21.34.54_f081b798.jpg'),
(20, 'EBAMI', 'manou', 2147483647, 'man@gmail.com', '$2y$10$yv5yE', 'img/15.jpg'),
(22, 'bitom', 'brice', 653861183, 'joel@gmail.com', '$2y$10$98zDo', 'img/15.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `specialiste`
--

CREATE TABLE `specialiste` (
  `idspecialiste` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `specialiste`
--

INSERT INTO `specialiste` (`idspecialiste`, `nom`, `description`) VALUES
(1, 'ophtalmologie ', 'celui qui soigne la maladie '),
(4, 'Pédiatrie ', 'tout ceux qui concerne\r\nla peau de l\'humain'),
(6, 'Cardiologie ', 'tout ce qui concerne le cœur '),
(7, 'Genicologie ', 'toujours autre maladies'),
(9, 'Naturopath ', 'nature');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`idadmin`);

--
-- Index pour la table `docteur`
--
ALTER TABLE `docteur`
  ADD PRIMARY KEY (`iddocteur`),
  ADD KEY `idspecialiste` (`idspecialiste`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`idpatient`);

--
-- Index pour la table `specialiste`
--
ALTER TABLE `specialiste`
  ADD PRIMARY KEY (`idspecialiste`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `idadmin` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `docteur`
--
ALTER TABLE `docteur`
  MODIFY `iddocteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `idpatient` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `specialiste`
--
ALTER TABLE `specialiste`
  MODIFY `idspecialiste` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `docteur`
--
ALTER TABLE `docteur`
  ADD CONSTRAINT `docteur_ibfk_1` FOREIGN KEY (`idspecialiste`) REFERENCES `specialiste` (`idspecialiste`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
