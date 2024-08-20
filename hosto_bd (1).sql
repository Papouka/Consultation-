-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 août 2024 à 14:03
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
  `specialite` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `diplome` varchar(255) NOT NULL,
  `certificat` varchar(255) NOT NULL,
  `mdp` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `docteur`
--

INSERT INTO `docteur` (`iddocteur`, `nom`, `prenom`, `tel`, `email`, `cni`, `tof`, `specialite`, `grade`, `diplome`, `certificat`, `mdp`) VALUES
(1, 'lory', 'Papouka', 653861183, '', '', '', '0', '', '', '', '$2y$10$18AfE'),
(2, 'lory', 'Papouka', 653861183, '', '', '', '0', '', '', '', '$2y$10$11f8b'),
(3, 'bisseki', 'bisseki', 2147483647, '', '', '', '0', '', '', '', '$2y$10$v.fKh'),
(4, 'bisseki', 'bisseki', 237, '', '', '', '0', '', '', '', '$2y$10$wpDkE'),
(7, 'bisseki', 'lory', 23456789, 'papouka@gmail.com', '', '', '0', '', '', '', '$2y$10$3zmnA'),
(8, 'bisseki', 'lory', 123456789, 'poukalory@gmail.com', '', '', '0', '', '', '', '$2y$10$yAZgo'),
(9, 'papouka', 'lory', 657956633, 'email@gmail.com', '', '', '0', '', '', '', '$2y$10$dlGHz'),
(10, 'richelot', 'brice', 123367886, 'Ema@gmail.com', 'img/1720384932935.jpg', '', '0', 'OBHMN', 'img/1720383856540.jpg', 'img/1720383859119.jpg', '$2y$10$qWAC9'),
(11, 'NKOUEBO', 'Peguy', 699999999, 'peguy@gmail.com', 'img/1720383856540.jpg', '', '0', 'OBHMN', 'img/1720383862528.jpg', 'img/1720384944770.jpg', '$2y$10$slqDu'),
(12, 'richelot', 'brice', 1234587, 'Emailighy@gmail.com', 'img/1720383862528.jpg', 'img/1720383874071.jpg', '0', 'OIIOL', 'img/1720384960205.jpg', 'img/1720384936815.jpg', '$2y$10$G27Gq'),
(13, 'brice', 'joel', 699999999, 'joel@gmail.com', 'img/1720383856540.jpg', 'img/1720383874071.jpg', '0', '\"\'rrrggnn', 'img/1720383874071.jpg', 'img/1720383859119.jpg', '$2y$10$osql2'),
(14, 'yahoo', 'syvia', 12347568, 'sylvia@gmail.com', 'img/1720383856540.jpg', 'img/1720383854311.jpg', 'cardiologie ', 'OIIOL', 'img/1720383862528.jpg', 'img/1720384960205.jpg', '$2y$10$nhNSx'),
(15, 'MOUNCHILI', 'YAZID', 699999999, 'yazid@gmail.com', 'img/Capture d\'écran 2024-08-05 110219.png', 'img/Capture 2024-08-11 215650.png', '0', 'dtfyguhijok', 'img/Capture d\'écran 2024-08-05 110219.png', 'img/Capture d\'écran 2024-08-02 100052.png', '$2y$10$2eInD');

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
(2, 'sindjui', 'brice', 123456789, 'joel@gmail.com', '$2y$10$FI.Zs', ''),
(3, 'ebakisse', 'victoire', 1234567890, 'victoire@gmail.com', '$2y$10$kAJZf', ''),
(4, 'sindjui', 'brice', 1234567890, 'victoir@gmail.com', '$2y$10$bepPx', ''),
(5, 'ebakisse', 'victoire', 1234567890, 'aimee@gmail.com', '$2y$10$ZEFKF', 'image/Capture d\'écran 2024-08-05 110219.png'),
(6, 'ebami', 'marionne', 657956633, 'ebami@gmail.com', '$2y$10$IazZq', 'image/Capture d\'écran 2024-08-02 100052.png'),
(7, 'bisseki', 'lory', 1234567890, 'papoukalory@gmail.com', '$2y$10$jWOId', 'image/mcd.png'),
(8, 'papouka', 'lory', 1234567890, 'papouka@gmail.com', '$2y$10$7UKiq', 'image/WhatsApp Image 2024-08-04 à 14.53.16_a1128bb7.jpg'),
(9, 'bitom', 'richelot ', 1234567, 'bitom@gmail.com', '$2y$10$o6cwd', 'img/Capture d\'écran 2024-08-05 110219.png'),
(10, 'bisseki', 'lory', 12346780, 'maman@gmail.com', '$2y$10$Gvf1m', 'img/WhatsApp Image 2024-08-04 à 14.53.16_a1128bb7.jpg'),
(11, 'bitom', 'richelot ', 1234567, 'bito@gmail.com', '$2y$10$U.rhV', 'img/Capture d\'écran 2024-08-02 100052.png'),
(12, 'bitom', 'richelot', 1234567890, 'vit@gmail.com', '$2y$10$pur9S', 'img/mcd.png'),
(15, 'bisseki', 'adoudou', 653861183, 'adoudou@gmail.com', '$2y$10$M/5L/', 'img/mcd.png'),
(16, 'Emagou', 'marciale', 674542148, 'papa@gmail.com', '$2y$10$ix1sL', 'img/Capture d\'écran 2024-08-05 110219.png'),
(18, 'lory', 'manou', 2147483647, 'manou@gmail.com', '$2y$10$/rkiz', 'img/Capture d\'écran 2024-08-11 215650.png'),
(19, 'NKOUEBO', 'PEGUY', 678563771, 'peguynkouebo100@gmail.com', '$2y$10$fIYLM', 'img/WhatsApp Image 2024-07-21 à 21.34.54_f081b798.jpg'),
(20, 'EBAMI', 'manou', 2147483647, 'man@gmail.com', '$2y$10$yv5yE', 'img/15.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(255) NOT NULL,
  `patient` varchar(255) NOT NULL,
  `docteur` varchar(255) NOT NULL,
  `administrateur` varchar(255) NOT NULL,
  `id_user` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `specialiste`
--

CREATE TABLE `specialiste` (
  `id` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `specialiste`
--

INSERT INTO `specialiste` (`id`, `nom`, `description`) VALUES
(1, 'ophtalmologie ', 'celui qui soigne la maladie '),
(4, 'Pédiatrie ', 'tout ceux qui concerne\r\nla peau de l\'humain'),
(5, 'generaliste', 'juste les légères maladies....\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `tel` int(17) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tof` varchar(255) NOT NULL,
  `cni` varchar(255) NOT NULL,
  `specialite` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `diplome` varchar(255) NOT NULL,
  `certificat` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `tel`, `email`, `tof`, `cni`, `specialite`, `grade`, `diplome`, `certificat`, `mdp`, `role`) VALUES
(1, 'brice', 'joel', 12346780, '0', 'img/Capture d\'écran 2024-08-05 110219.png', '', '', '', '', '', '$2y$10$zmLXBT5yo8ti7HmliNT5ReitvNjzj/r2LjHHuYrR31dK2wDOu1u5C', 'docteur'),
(2, 'papouka', 'lory', 2147483647, 'papouka@gmail.com', 'img/mcd.png', '', '', '', '', '', '$2y$10$RtgwObL8utWws3vyxnJ8o.AROPOBtqUiMxcBvLhS7XqJOSHKTZfR.', 'docteur'),
(3, 'bisseki', 'lory', 657956633, 'papa@gmail.com', 'img/mcd.png', 'img/Capture d\'écran 2024-08-05 110219.png', 'drtfyguhijo', 'dtfyguhijok', 'img/11.jpg', 'img/13.jpg', '$2y$10$VMsth6V/oxlMyLkxE3/gc.eSBhjo/PAmfkg9KfptJ/BXbmGr91vBm', 'docteur'),
(4, 'hayoo', 'sylvia', 12346780, 'sylvia@gmail.com', 'img/Capture d\'écran 2024-08-05 110219.png', '', '', '', '', '', '$2y$10$V8eErROMmfsRg7VHWimum.vFFBG2oUBoBonpQHxwHRTyzduJgenra', 'docteur'),
(5, 'hayoo', 'sylvia', 12346780, 'sylvi@gmail.com', 'img/Capture d\'écran 2024-08-05 110219.png', 'img/mcd.png', 'drtfyguhijo', 'dtfyguhijok', 'img/WhatsApp Image 2024-08-04 à 14.53.16_a1128bb7.jpg', 'img/Capture d\'écran 2024-08-05 110219.png', '$2y$10$ShxmDAUaeSV4Kc70pcMPwe/9dRmssnE8.Cq30ak/Yfk8sDPW/NKNO', 'docteur'),
(7, 'lory', 'Papouka', 653861183, 'pouka@gmail.com', 'img/mcd.png', '', '', '', '', '', '$2y$10$xTRdk8GOqgY1FVqwqKd6Ve9GTpRg7MhlCuUdh2AAqvXRpwip9xLPq', 'patient'),
(8, 'bitom', 'richelot', 653861183, 'bitom@gmail.com', 'img/mcd.png', 'img/Capture d\'écran 2024-08-05 110219.png', 'azertghyju', 'dzyguifjoekpr', 'img/WhatsApp Image 2024-08-04 à 14.53.16_a1128bb7.jpg', 'img/mcd.png', '$2y$10$hvuqXYG340IjxuNnAuMpHuo3lHvmPbWoqGOFvTMzco.CAulCwa2sG', 'docteur'),
(9, 'bisseki', 'lory', 657956633, 'papou@gmail.com', 'img/mcd.png', '', '', '', '', '', '$2y$10$8tTziBnZ/dQw6wsjhSqVku/8x6L5lF6RgOeFYR400gC8zk3OzoM6i', 'patient'),
(10, 'bisseki', 'lory', 657956633, 'pap@gmail.com', 'img/mcd.png', '', '', '', '', '', '$2y$10$iyey1.tN8VTFclq5CmPm8e.wdABEWUuEGuh2.WCNO89pmYb0MRKJ2', 'patient'),
(11, 'bisseki', 'lory', 657956633, 'papoukaloryy@gmail.com', 'img/Capture d\'écran 2024-08-05 110219.png', '', '', '', '', '', '$2y$10$0mFds/BI12IEto3ukN8N5ejf2F4lF2uJNy.MJQDianXlYlV.znG4.', 'patient'),
(12, 'bisseki', 'lory', 657956633, 'papoukalory@gmail.com', 'img/WhatsApp Image 2024-08-04 à 14.53.16_a1128bb7.jpg', '', '', '', '', '', '$2y$10$vBU/2CUvROGqc36KzsjQJOVKFx4nkNRt0.Nr4YqTi0bC7LOZmW7Xy', ''),
(13, 'YAZID', 'MOUNCHILI', 699999999, 'yazid@gmail.com', 'img/Capture 2024-08-11 215650.png', 'img/Capture d\'écran 2024-08-02 100052.png', 'drtfyguhijo', 'dtfyguhijok', 'img/Capture d\'écran 2024-08-02 100052.png', 'img/WhatsApp Image 2024-08-04 à 14.53.16_a1128bb7.jpg', '$2y$10$9HBiHwVm0TABZma0r8VZkOwj3BpYdmpBQhivY4Up9HiQHDluax16W', '');

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
  ADD PRIMARY KEY (`iddocteur`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`idpatient`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `specialiste`
--
ALTER TABLE `specialiste`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `iddocteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `idpatient` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `specialiste`
--
ALTER TABLE `specialiste`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
