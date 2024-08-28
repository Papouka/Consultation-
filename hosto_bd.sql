-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 28 août 2024 à 05:29
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
  `idconsultation` int(255) NOT NULL,
  `iddocteur` int(11) DEFAULT NULL,
  `idpatient` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `duree` varchar(255) NOT NULL,
  `heure` time NOT NULL,
  `dateconsultation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `diagnostic` varchar(255) NOT NULL,
  `traitement` varchar(255) NOT NULL,
  `idspecialiste` int(11) NOT NULL,
  `datedernieremiseajour` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`idconsultation`, `iddocteur`, `idpatient`, `description`, `duree`, `heure`, `dateconsultation`, `diagnostic`, `traitement`, `idspecialiste`, `datedernieremiseajour`) VALUES
(7, 0, NULL, 'mal de dos', '00:00:02', '00:00:00', '2024-08-27 20:00:42', '', '', 10, '0000-00-00 00:00:00'),
(8, 0, NULL, 'mal de dos', '00:00:02', '00:00:00', '2024-08-27 20:02:14', '', '', 10, '0000-00-00 00:00:00'),
(9, 0, NULL, 'mal de dos', '00:00:02', '00:00:00', '2024-08-27 20:02:25', '', '', 4, '0000-00-00 00:00:00'),
(10, 0, NULL, 'mal de dos', '00:00:02', '00:00:00', '2024-08-27 20:02:37', '', '', 4, '0000-00-00 00:00:00'),
(11, 0, NULL, 'mal de dos', '00:00:02', '00:00:00', '2024-08-27 20:07:21', '', '', 4, '0000-00-00 00:00:00'),
(12, 0, NULL, 'MAL de dos', '00:00:02', '00:00:00', '2024-08-27 20:07:52', '', '', 4, '0000-00-00 00:00:00'),
(13, 0, NULL, 'MAL de dos', '00:00:02', '00:00:00', '2024-08-27 20:09:51', '', '', 4, '0000-00-00 00:00:00'),
(14, 0, NULL, 'kl', '00:00:02', '00:00:00', '2024-08-27 20:17:08', '', '', 4, '0000-00-00 00:00:00'),
(15, 0, NULL, '3R', '00:00:02', '00:00:00', '2024-08-27 20:19:42', '', '', 1, '0000-00-00 00:00:00'),
(16, 0, NULL, '3R', '00:00:02', '00:00:00', '2024-08-27 20:19:54', '', '', 1, '0000-00-00 00:00:00'),
(17, 0, NULL, '3ZAD', '00:00:02', '00:00:00', '2024-08-27 20:20:46', '', '', 4, '0000-00-00 00:00:00'),
(18, 0, NULL, 'kù', '00:00:02', '00:00:00', '2024-08-27 20:28:34', '', '', 4, '0000-00-00 00:00:00'),
(19, 0, NULL, 'kù', '00:00:02', '00:00:00', '2024-08-27 20:29:11', '', '', 4, '0000-00-00 00:00:00'),
(20, 0, NULL, 'kù', '00:00:02', '00:00:00', '2024-08-27 20:29:21', '', '', 1, '0000-00-00 00:00:00'),
(21, 0, NULL, 'kù', '00:00:02', '00:00:00', '2024-08-27 20:29:26', '', '', 1, '0000-00-00 00:00:00'),
(22, 0, NULL, 'mal  des yeux', '1jour', '00:00:00', '2024-08-27 23:40:54', '', '', 1, '0000-00-00 00:00:00'),
(23, NULL, 26, 'mal des yeux ', '2jours', '00:00:00', '2024-08-28 00:11:26', '', '', 1, '0000-00-00 00:00:00'),
(24, NULL, 26, 'lm', '1jour', '00:00:00', '2024-08-28 00:31:36', '', '', 1, '0000-00-00 00:00:00'),
(25, NULL, 26, 'yeux ', '2jours', '00:00:00', '2024-08-28 01:10:38', '', '', 1, '0000-00-00 00:00:00'),
(26, NULL, 26, 'yeux ', '2jours', '00:00:00', '2024-08-28 01:12:03', '', '', 1, '0000-00-00 00:00:00'),
(27, NULL, 26, 'mal de ventre', '1jour', '00:00:00', '2024-08-28 01:42:44', '', '', 4, '0000-00-00 00:00:00'),
(28, NULL, 26, 'mal de ventre', '1jour', '00:00:00', '2024-08-28 01:45:28', '', '', 4, '0000-00-00 00:00:00'),
(29, 18, 26, 'mal de ventre', '1jour', '00:00:00', '2024-08-28 03:19:57', '', '', 4, '0000-00-00 00:00:00'),
(33, 16, 26, '', '', '00:00:00', '2024-08-28 02:51:53', 'vhkln :k', 'nkl', 4, '2024-08-28 03:51:53'),
(34, 16, 27, '', '', '00:00:00', '2024-08-28 03:16:14', 'zadrfa', 'rfaz', 4, '2024-08-28 04:16:14');

-- --------------------------------------------------------

--
-- Structure de la table `creneaux`
--

CREATE TABLE `creneaux` (
  `idcreneau` int(11) NOT NULL,
  `iddocteur` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `bloque` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `creneaux`
--

INSERT INTO `creneaux` (`idcreneau`, `iddocteur`, `date`, `heure_debut`, `heure_fin`, `disponible`, `bloque`) VALUES
(1, NULL, '2024-07-12', '08:30:00', '16:00:00', 0, 0),
(2, 18, '2024-11-25', '09:00:00', '13:30:00', 0, 0),
(3, 18, '2024-09-17', '12:30:00', '18:00:00', 0, 0),
(5, 16, '2024-05-12', '12:00:00', '18:40:00', 0, 0),
(6, 20, '2024-05-30', '12:00:00', '20:00:00', 0, 0);

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
  `experience` int(4) NOT NULL,
  `mdp` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `docteur`
--

INSERT INTO `docteur` (`iddocteur`, `nom`, `prenom`, `tel`, `email`, `cni`, `tof`, `idspecialiste`, `grade`, `diplome`, `certificat`, `experience`, `mdp`) VALUES
(16, 'EBAMI', 'manou', 2147483647, 'man@gmail.com', 'img/16.jpg', 'img/15.jpg', 4, 'Docteur', 'img/12.jpg', 'img/17.jpg', 0, '$2y$10$SrCgI'),
(17, 'EBAMI', 'manou', 2147483647, 'mane@gmail.com', 'img/16.jpg', 'img/15.jpg', 1, 'Infirmier', 'img/18.jpg', 'img/17.jpg', 0, '$2y$10$lg4ZW'),
(18, 'PAPOUKA', 'lory', 653861183, 'papouka@gmail.com', 'img/17.jpg', 'img/16.jpg', 4, 'Docteur', 'img/12.jpg', 'img/14.jpg', 0, '$2y$10$eqz2r'),
(19, 'PAPOUKA', 'lory', 653861183, 'papouk@gmail.com', 'img/17.jpg', 'img/16.jpg', 4, 'Aide soignante ', 'img/12.jpg', 'img/14.jpg', 6, '$2y$10$Q0Ujr'),
(20, 'PAPOUKA', 'lory', 653861183, 'pouka@gmail.com', 'img/12.jpg', 'img/13.jpg', 6, 'infirmier ', 'img/17.jpg', 'img/12.jpg', 19, '$2y$10$0DRIG'),
(21, 'ANDON', 'Rachella', 653861183, 'rachella@gmail.com', 'img/Capture d\'écran 2024-08-05 110219.png', 'img/Capture d\'écran 2024-08-02 100052.png', 1, 'docteur', 'img/papouka.pdf', 'img/cahiers de charge.pdf', 5, '$2y$10$vpzPu');

-- --------------------------------------------------------

--
-- Structure de la table `dossiermedical`
--

CREATE TABLE `dossiermedical` (
  `iddossier` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `iddocteur` int(11) NOT NULL,
  `datecreation` datetime NOT NULL,
  `historique` text NOT NULL,
  `diagnostic` text NOT NULL,
  `traitement` text NOT NULL,
  `datedernieremiseajour` datetime NOT NULL,
  `idresultat` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dossiermedical`
--

INSERT INTO `dossiermedical` (`iddossier`, `idpatient`, `iddocteur`, `datecreation`, `historique`, `diagnostic`, `traitement`, `datedernieremiseajour`, `idresultat`) VALUES
(12, 26, 16, '0000-00-00 00:00:00', '', 'palu', 'paracetamol', '2024-08-27 17:16:29', NULL),
(13, 27, 16, '0000-00-00 00:00:00', '', 'Cholera', 'remède', '2024-08-27 17:20:51', NULL),
(14, 33, 16, '0000-00-00 00:00:00', '', 'Palu', 'paracétamol ', '2024-08-27 17:25:10', NULL),
(15, 26, 16, '0000-00-00 00:00:00', '', 'palu', 'paracétamol ', '2024-08-28 03:13:34', NULL),
(16, 26, 16, '0000-00-00 00:00:00', '', 'cholera', 'remède', '2024-08-28 03:29:13', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ordonnance`
--

CREATE TABLE `ordonnance` (
  `idordonnance` int(255) NOT NULL,
  `patient` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `medicament` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `posologie` varchar(255) NOT NULL,
  `docteur` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ordonnance`
--

INSERT INTO `ordonnance` (`idordonnance`, `patient`, `dob`, `medicament`, `dosage`, `posologie`, `docteur`) VALUES
(1, 'BITOM', '2000-04-02', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA '),
(2, 'ADOUDOU', '2011-10-18', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA '),
(3, 'BRICE', '2000-07-13', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA '),
(4, 'BRICE', '2000-07-13', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA '),
(5, 'LORY', '2003-03-23', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA '),
(6, 'LORY', '2003-03-23', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA '),
(7, 'LORY', '2003-03-23', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA '),
(8, 'LORY', '2003-03-23', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ');

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
  `tof` varchar(255) NOT NULL,
  `idspecialiste` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`idpatient`, `nom`, `prenom`, `tel`, `email`, `mdp`, `tof`, `idspecialiste`) VALUES
(26, 'ANDON', 'Rachella', 653861183, 'rachella@gmail.com', '$2y$10$rhdVx', 'img/Capture d\'écran 2024-08-11 215444.png', NULL),
(27, 'EBAKISSE', 'aimee', 653861183, 'aimee@gmail.com', '$2y$10$oOyxZ', 'img/Capture d\'écran 2024-08-05 110219.png', NULL),
(28, 'YAHOO', 'sylvia', 653861183, 'sylvia@gmail.com', '$2y$10$ZJAb3', 'img/Capture d\'écran 2024-08-11 215444.png', NULL),
(29, 'YAHOO', 'sylvia', 653861183, 'sylvi@gmail.com', '$2y$10$BTGOB', 'img/Capture d\'écran 2024-08-05 110219.png', NULL),
(32, 'YAHOO', 'sylvia', 653861183, 'lory@gmail.com', '$2y$10$9kESm', 'img/Capture d\'écran 2024-08-05 110219.png', NULL),
(33, 'PAPOUKA', 'lory', 653861183, 'papoukalory@gmail.com', '$2y$10$14o/s', 'img/Capture d\'écran 2024-08-02 100052.png', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `idrendezvous` int(25) NOT NULL,
  `iddocteur` int(11) DEFAULT NULL,
  `idcreneau` int(11) DEFAULT NULL,
  `idpatient` int(11) DEFAULT NULL,
  `motif` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`idrendezvous`, `iddocteur`, `idcreneau`, `idpatient`, `motif`) VALUES
(13, 18, 2, 26, 'ujkqzdnhmoqs'),
(14, 18, 2, 26, 'TDFCYKHFVOL'),
(31, 20, 6, 26, ';;;;;;;:chb'),
(32, 18, 3, 28, 'NJK?'),
(33, 20, 6, 26, 'yhki');

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

CREATE TABLE `resultat` (
  `idresultat` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `typeexamen` varchar(255) NOT NULL,
  `resultat` varchar(255) NOT NULL,
  `dateexamen` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `resultat`
--

INSERT INTO `resultat` (`idresultat`, `idpatient`, `typeexamen`, `resultat`, `dateexamen`) VALUES
(1, 26, 'sang', 'tout vas bien', '2024-08-26'),
(2, 33, 'sang', 'tout va bien', '2024-08-26'),
(3, 26, 'sang', 'TOUT VA BIEN', '2024-08-26'),
(4, 26, 'sang', 'TOUT VA BIEN', '2024-08-26'),
(5, 33, 'sang', 'ça va\r\n', '2024-08-26'),
(6, 33, 'sang', 'TOUT VA BIEN', '2024-08-27'),
(7, 33, 'sang', 'TOUT VA BIEN', '2024-08-27'),
(8, 33, 'sang', 'TOUT VA BIEN', '2024-08-27');

-- --------------------------------------------------------

--
-- Structure de la table `specialiste`
--

CREATE TABLE `specialiste` (
  `idspecialiste` int(255) NOT NULL,
  `nomspecialiste` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `iddocteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `specialiste`
--

INSERT INTO `specialiste` (`idspecialiste`, `nomspecialiste`, `description`, `iddocteur`) VALUES
(1, 'ophtalmologie ', 'celui qui soigne la maladie ', 0),
(4, 'Pédiatrie ', 'tout ceux qui concerne\r\nla peau de l\'humain', 0),
(6, 'Cardiologie ', 'tout ce qui concerne le cœur ', 0),
(7, 'Genicologie ', 'toujours autre maladies', 0),
(9, 'Naturopath ', 'nature', 0),
(10, 'Généraliste', 'palu', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`idadmin`);

--
-- Index pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`idconsultation`),
  ADD KEY `iddocteur` (`iddocteur`),
  ADD KEY `idpatient` (`idpatient`),
  ADD KEY `idspecialiste` (`idspecialiste`);

--
-- Index pour la table `creneaux`
--
ALTER TABLE `creneaux`
  ADD PRIMARY KEY (`idcreneau`),
  ADD KEY `iddocteur` (`iddocteur`);

--
-- Index pour la table `docteur`
--
ALTER TABLE `docteur`
  ADD PRIMARY KEY (`iddocteur`),
  ADD KEY `idspecialiste` (`idspecialiste`);

--
-- Index pour la table `dossiermedical`
--
ALTER TABLE `dossiermedical`
  ADD PRIMARY KEY (`iddossier`),
  ADD KEY `idpatient` (`idpatient`),
  ADD KEY `iddocteur` (`iddocteur`),
  ADD KEY `idresultat` (`idresultat`);

--
-- Index pour la table `ordonnance`
--
ALTER TABLE `ordonnance`
  ADD PRIMARY KEY (`idordonnance`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`idpatient`),
  ADD KEY `idspecialiste` (`idspecialiste`);

--
-- Index pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD PRIMARY KEY (`idrendezvous`),
  ADD KEY `iddocteur` (`iddocteur`),
  ADD KEY `idpatient` (`idpatient`),
  ADD KEY `idcreneau` (`idcreneau`);

--
-- Index pour la table `resultat`
--
ALTER TABLE `resultat`
  ADD PRIMARY KEY (`idresultat`),
  ADD KEY `idpatient` (`idpatient`);

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
-- AUTO_INCREMENT pour la table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `idconsultation` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `creneaux`
--
ALTER TABLE `creneaux`
  MODIFY `idcreneau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `docteur`
--
ALTER TABLE `docteur`
  MODIFY `iddocteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `dossiermedical`
--
ALTER TABLE `dossiermedical`
  MODIFY `iddossier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `ordonnance`
--
ALTER TABLE `ordonnance`
  MODIFY `idordonnance` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `idpatient` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `idrendezvous` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `resultat`
--
ALTER TABLE `resultat`
  MODIFY `idresultat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `specialiste`
--
ALTER TABLE `specialiste`
  MODIFY `idspecialiste` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consultation_ibfk_3` FOREIGN KEY (`idspecialiste`) REFERENCES `specialiste` (`idspecialiste`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `creneaux`
--
ALTER TABLE `creneaux`
  ADD CONSTRAINT `creneaux_ibfk_1` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `docteur`
--
ALTER TABLE `docteur`
  ADD CONSTRAINT `docteur_ibfk_1` FOREIGN KEY (`idspecialiste`) REFERENCES `specialiste` (`idspecialiste`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dossiermedical`
--
ALTER TABLE `dossiermedical`
  ADD CONSTRAINT `dossiermedical_ibfk_1` FOREIGN KEY (`idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossiermedical_ibfk_2` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dossiermedical_ibfk_3` FOREIGN KEY (`idresultat`) REFERENCES `resultat` (`idresultat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`idspecialiste`) REFERENCES `specialiste` (`idspecialiste`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rendezvous_ibfk_2` FOREIGN KEY (`idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rendezvous_ibfk_3` FOREIGN KEY (`idcreneau`) REFERENCES `creneaux` (`idcreneau`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `resultat`
--
ALTER TABLE `resultat`
  ADD CONSTRAINT `resultat_ibfk_1` FOREIGN KEY (`idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
