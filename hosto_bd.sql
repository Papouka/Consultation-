-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 30 sep. 2024 à 16:49
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
  `dateconsultation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `diagnostic` varchar(255) NOT NULL,
  `traitement` varchar(255) NOT NULL,
  `idspecialiste` int(11) NOT NULL,
  `datedernieremiseajour` datetime NOT NULL,
  `typeexamen` varchar(255) NOT NULL,
  `statut` enum('nouvelle') NOT NULL,
  `read` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`idconsultation`, `iddocteur`, `idpatient`, `description`, `duree`, `dateconsultation`, `diagnostic`, `traitement`, `idspecialiste`, `datedernieremiseajour`, `typeexamen`, `statut`, `read`) VALUES
(39, NULL, NULL, 'mal de dos', '1jour', '2024-09-04 12:28:03', '', '', 10, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(40, NULL, NULL, 'mal de dos', '1jour', '2024-09-04 12:30:05', '', '', 4, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(42, NULL, NULL, 'mal de dos', '1jour', '2024-09-04 12:42:05', '', '', 4, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(70, NULL, 59, 'Consultation initiale', '30', '2024-09-16 19:02:27', '', '', 1, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(73, 24, 59, 'Mal de dos', '1 jour', '2024-09-19 10:11:24', '', '', 4, '0000-00-00 00:00:00', '', '', 0),
(74, 25, 59, '', '', '2024-09-19 15:22:02', 'er', 'erh', 11, '2024-09-17 09:11:05', 'rtgj', '', 0),
(75, 25, 59, 'mal de dents', '3 jours', '2024-09-19 15:25:46', '', '', 11, '0000-00-00 00:00:00', '', '', 0),
(76, NULL, 60, 'Consultation initiale', '30', '2024-09-17 08:35:53', '', '', 1, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(77, 25, 60, 'Mal de dents', '2 jours', '2024-09-19 15:25:10', '', '', 11, '0000-00-00 00:00:00', '', '', 0),
(78, 25, 60, 'mal de dents', '2 jours', '2024-09-19 15:23:52', '', '', 11, '0000-00-00 00:00:00', '', '', 0),
(79, 25, 60, '', '', '2024-09-17 08:57:35', 'le mal de dents', 'operartion', 11, '2024-09-17 09:57:35', 'dents', 'nouvelle', 0),
(80, NULL, 61, 'Consultation initiale', '30', '2024-09-17 12:55:37', '', '', 1, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(81, NULL, 62, 'Consultation initiale', '30', '2024-09-24 10:33:48', '', '', 1, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(82, NULL, 63, 'Consultation initiale', '30', '2024-09-25 14:34:25', '', '', 1, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(83, 24, 60, 'jghjk', '2', '2024-09-26 13:39:12', '', '', 4, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(84, 24, 60, 'jghjk', '2', '2024-09-26 13:41:51', '', '', 4, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(85, 25, 59, '', '', '2024-09-27 07:48:39', 'Palu', 'paracetamol ', 11, '2024-09-27 08:48:39', 'le sang', 'nouvelle', 0),
(86, NULL, 59, 'J\'ai mal aux dents', '3 jours', '2024-09-27 10:21:59', '', '', 11, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(87, NULL, 60, 'toux', '2', '2024-09-30 09:45:03', '', '', 10, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(88, 25, 60, 'mal à la dent', '2', '2024-09-30 09:45:50', '', '', 11, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(89, NULL, 60, 'fjhgjgj', '2', '2024-09-30 09:48:53', '', '', 6, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(90, NULL, 60, 'fjhgjgj', '2', '2024-09-30 09:49:01', '', '', 10, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(91, NULL, 60, 'fjhgjgj', '2', '2024-09-30 09:49:11', '', '', 7, '0000-00-00 00:00:00', '', 'nouvelle', 0),
(92, 24, 60, 'fjhgjgj', '2', '2024-09-30 09:49:20', '', '', 4, '0000-00-00 00:00:00', '', 'nouvelle', 0);

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
(26, 24, '2024-09-19', '12:20:00', '15:20:00', 0, 0),
(27, 25, '2024-09-19', '13:35:00', '15:40:00', 0, 0),
(28, 25, '2024-10-01', '15:00:00', '19:00:00', 0, 0);

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
  `ville` varchar(255) NOT NULL,
  `diplome` varchar(255) NOT NULL,
  `certificat` varchar(255) NOT NULL,
  `experience` int(4) NOT NULL,
  `prix` int(11) NOT NULL,
  `mdp` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `docteur`
--

INSERT INTO `docteur` (`iddocteur`, `nom`, `prenom`, `tel`, `email`, `cni`, `tof`, `idspecialiste`, `ville`, `diplome`, `certificat`, `experience`, `prix`, `mdp`) VALUES
(24, 'ADAMA', 'ALOYS', 690782031, 'ange@gmail.com ', 'img/télécharger (1).jpeg', 'img/th.jpeg', 4, 'Douala ', 'img/papouka.pdf', 'img/cahiers de charge.pdf', 4, 0, '$2y$10$IRqRCwpUfZ/phhTlsZfvIuV1yzexZP55ICla19z.hGGIr6coXdGUu'),
(25, 'FOTSO', 'PATRICIA', 690782031, 'papoukalory@gmail.com', 'img/télécharger (1).jpeg', 'img/télécharger.jpeg', 11, 'Douala ', 'img/ordonnance.pdf', 'img/papouka.pdf', 4, 6000, '$2y$10$0GHdSnDw/G3c9f2wf8LxculedvoeDPZ3x4dIXhHh.FqvsYbrpzAD.'),
(26, 'EBAKISSE', 'aimée', 690782031, 'aimeeebakisse@gmail.com', 'img/6.png', 'img/1.png', 1, 'Douala', 'img/ordonnance.pdf', 'img/cahiers de charge.pdf', 3, 5000, '$2y$10$vz0dQPtxu/18Ro70SJLsVeN7imbeJLSXLoFdlK.t3nZSrlH2a9n7C');

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

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `idmessage` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `iddocteur` int(11) NOT NULL,
  `message` text NOT NULL,
  `dateenvoie` datetime NOT NULL,
  `auteur` enum('patient','docteur') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `docteur` varchar(255) NOT NULL,
  `statut` enum('nouvelle') NOT NULL,
  `read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ordonnance`
--

INSERT INTO `ordonnance` (`idordonnance`, `patient`, `dob`, `medicament`, `dosage`, `posologie`, `docteur`, `statut`, `read`) VALUES
(1, 'BITOM', '2000-04-02', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ', 'nouvelle', 0),
(2, 'ADOUDOU', '2011-10-18', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ', 'nouvelle', 0),
(3, 'BRICE', '2000-07-13', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ', 'nouvelle', 0),
(4, 'BRICE', '2000-07-13', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ', 'nouvelle', 0),
(5, 'LORY', '2003-03-23', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ', 'nouvelle', 0),
(6, 'LORY', '2003-03-23', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ', 'nouvelle', 0),
(7, 'LORY', '2003-03-23', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ', 'nouvelle', 0),
(8, 'LORY', '2003-03-23', 'Paracetamol ', '500mg', 'un matin un soir', 'PAPOUKA ', 'nouvelle', 0),
(9, 'EBAKISSE', '2003-09-12', 'paracetamol', '500', '2 matin, 2 soi', 'PAPOUKA', 'nouvelle', 0),
(10, 'EBAKISSE', '2003-09-12', 'paracetamol', '500', '2 matin, 2 soi', 'PAPOUKA', 'nouvelle', 0),
(11, 'EBAKISSE', '2003-09-12', 'paracetamol', '500', '2 matin, 2 soi', 'PAPOUKA', 'nouvelle', 0),
(12, 'EBAKISSE', '2003-09-12', 'paracetamol', '500', '2 matin, 2 soi', 'PAPOUKA', 'nouvelle', 0),
(13, 'EBAKISSE', '2003-09-12', 'paracetamol', '500', '2 matin, 2 soi', 'PAPOUKA', 'nouvelle', 0),
(14, 'EBAKISSE', '2003-09-12', 'paracetamol', '500', '2 matin, 2 soi', 'PAPOUKA', 'nouvelle', 0),
(15, 'EBAKISSE', '2003-09-12', 'paracetamol', '500', '2 matin, 2 soi', 'PAPOUKA', 'nouvelle', 0),
(16, 'EBAKISSE', '2003-09-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(17, 'EBAKISSE', '2003-09-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(18, 'EBAKISSE', '2003-09-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(19, 'EBAKISSE', '2003-08-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(20, 'EBAKISSE', '2003-08-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(21, 'EBAKISSE', '2003-08-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(22, 'EBAKISSE', '2003-08-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(23, 'EBAKISSE', '2003-08-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(24, 'EBAKISSE', '2004-05-12', 'paracetamol', '500mg', '2 matin, 2 soir', 'PAPOUKA', 'nouvelle', 0),
(25, 'lory papouka', '2003-09-04', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ADAMA', 'nouvelle', 0),
(26, 'lory papouka', '2003-03-23', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ADAMA', 'nouvelle', 0),
(27, 'lory papouka', '2009-02-02', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ADAMA', 'nouvelle', 0),
(28, 'lory papouka', '2008-08-08', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ADAMA', 'nouvelle', 0),
(29, 'lory papouka', '2008-02-01', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ADAMA', 'nouvelle', 0),
(30, 'lory ', '2012-03-03', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ', 'nouvelle', 0),
(31, 'lory ', '2012-03-02', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ', 'nouvelle', 0),
(32, 'lory ', '2012-03-02', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ', 'nouvelle', 0),
(33, 'lory ', '2018-02-01', 'Paracetamol', '500mg', '2 matin 2 soir', 'ALOYS ', 'nouvelle', 0),
(34, '62', '2003-03-23', 'Paracetamol', '500mg', '2 matin 2 soir', 'FOTSO', 'nouvelle', 0);

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `idpatient` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `tel` int(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(256) NOT NULL,
  `tof` varchar(255) DEFAULT NULL,
  `idspecialiste` int(11) DEFAULT NULL,
  `iddocteur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`idpatient`, `nom`, `prenom`, `dob`, `tel`, `email`, `mdp`, `tof`, `idspecialiste`, `iddocteur`) VALUES
(59, 'lory', 'Papouka', '0000-00-00', 653861183, 'peguynkouebo100@gmail.com', '$2y$10$6YY3me5pBIsToihTHRFEGedaZDUlV/Ts8s3RdtG6FxJHbtAP9.EPa', 'img/9.png', NULL, NULL),
(60, 'BISSEKI', 'moïse ', '0000-00-00', 653861183, 'papoukalory@gmail.com ', '$2y$10$T3bfSdiLjiGPO3E1pbIubeb580XVlGhyxvNZQuqpCDI1.aCXjHyWm', 'img/6.png', NULL, NULL),
(61, 'EBAMI', 'marionne', '2004-01-20', 653861183, 'aloysdjoumo224@gmail.com', '$2y$10$4YoygdhxHHtShl/yg.v9ue1HxGfg4FWBf9ewPgu4DJsDO7XseNUf6', 'img/6.png', NULL, NULL),
(62, 'EMAGOU', 'Marciale', '2003-03-23', 653861183, 'sitchomagedeon@gmail.com', '$2y$10$msotNqzXD6.BAc5dRLkF0ubzKkZ5YVjg7uPW31aaYEQDRPdqs65xe', 'img/9.png', NULL, NULL),
(63, 'MAMA', 'papa', '2005-04-02', 690782031, 'peguynkouebo@gmail.com', '$2y$10$XCxf3t0X6MgOoJ34jQG8ZekKnIHXkqgFXzm3S3YxWYJCwIg56xs5.', 'uploads/5.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
  `idrendezvous` int(25) NOT NULL,
  `iddocteur` int(11) NOT NULL,
  `idcreneau` int(11) DEFAULT NULL,
  `idpatient` int(11) DEFAULT NULL,
  `motif` text NOT NULL,
  `statut` enum('accepter','refuser') NOT NULL,
  `is_read` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`idrendezvous`, `iddocteur`, `idcreneau`, `idpatient`, `motif`, `statut`, `is_read`) VALUES
(87, 24, 26, 59, 'OEIL', '', 0),
(88, 24, 26, 59, 'le dos qui fais mal', '', 0),
(89, 24, 26, 59, 'aie', '', 0),
(90, 24, 26, 59, 'le dos qui fais mal', '', 0),
(92, 25, 27, 60, 'MAL de dents', '', 0),
(93, 25, 27, 60, 'er', '', 0),
(94, 25, 27, 60, 'lol', '', 0),
(95, 24, 26, 59, 'La tête ', '', 0),
(96, 24, 26, 59, 'la tête ', '', 0),
(97, 24, 26, 59, 'la tête ', '', 0),
(98, 24, 26, 59, 'la tête ', '', 0),
(99, 24, 26, 59, 'la tête ', '', 0),
(100, 24, 26, 59, 'la tête ', '', 0),
(101, 24, 26, 59, 'la tête ', '', 0),
(102, 24, 26, 59, 'la tête ', '', 0),
(103, 24, 26, 59, 'LE VENTRE', '', 0),
(104, 24, 26, 59, 'l\'œil 😉 ', '', 0),
(105, 24, 26, 59, 'aie', '', 0),
(106, 24, 26, 59, 'aie', '', 0),
(107, 24, 26, 59, 'les yeux', 'accepter', 0),
(108, 24, 26, 59, 'humm', 'accepter', 0),
(109, 24, 26, 59, 'jp', 'accepter', 0),
(110, 24, 26, 59, 'oui', 'accepter', 0),
(111, 24, 26, 59, 'humm', 'accepter', 0),
(112, 24, 26, 59, 'tuuuuuuu', 'accepter', 0),
(113, 24, 26, 59, 'ety', 'accepter', 0),
(114, 24, 26, 59, 'j\'espère', 'accepter', 0),
(115, 24, 26, 59, 'ahh', 'accepter', 0),
(116, 24, 26, 59, 'lory', 'accepter', 0),
(117, 24, 26, 59, 'ahhh', 'accepter', 0),
(118, 24, 26, 59, 'lory', 'accepter', 0),
(119, 24, 26, 59, 'lory', 'accepter', 0),
(120, 24, 26, 59, 'lory', 'accepter', 0),
(121, 24, 26, 59, 'lol', 'accepter', 0),
(122, 25, 27, 59, 'lol', 'accepter', 0),
(123, 25, 27, 59, 'LOL', 'accepter', 0),
(124, 24, 26, 59, 'LOL', 'accepter', 0),
(125, 25, 27, 59, 'HEO', 'accepter', 0),
(126, 25, 27, 59, 'HUM', 'accepter', 0),
(127, 25, 27, 60, 'LA TÊTE ', 'accepter', 0),
(128, 25, 27, 60, 'LA TÊTE ', 'accepter', 0),
(129, 25, 27, 60, '\'fgre', 'accepter', 0),
(130, 24, 26, 60, 'sdefse', 'accepter', 0),
(131, 25, 27, 60, 'Eza', 'accepter', 0),
(132, 25, 28, 59, 'lzka,dkj', 'accepter', 0),
(133, 25, 28, 59, 'l,deml', 'accepter', 0),
(134, 25, 27, 59, 'nlj: nk', 'accepter', 0),
(135, 25, 27, 60, 'ZREA', 'accepter', 0),
(136, 25, 27, 60, 'ZREA', 'accepter', 0),
(137, 25, 27, 60, 'dgss', 'accepter', 0),
(138, 25, 27, 60, 'ddshf', 'accepter', 0),
(139, 25, 28, 60, 'ok test de motif', 'accepter', 0),
(140, 25, 27, 60, 'exemple de motif', 'accepter', 0),
(141, 25, 27, 60, 'exemple de motif', 'accepter', 0),
(142, 25, 28, 60, 'test', 'accepter', 0),
(143, 25, 28, 60, 'test', 'accepter', 0),
(144, 25, 28, 60, 'test', 'accepter', 0),
(145, 25, 28, 60, 'test', 'accepter', 0),
(146, 25, 28, 60, 'test', 'accepter', 0);

-- --------------------------------------------------------

--
-- Structure de la table `resultat`
--

CREATE TABLE `resultat` (
  `idresultat` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `iddocteur` int(11) NOT NULL,
  `typeexamen` varchar(255) NOT NULL,
  `resultat` varchar(255) NOT NULL,
  `dateexamen` date NOT NULL,
  `statut` enum('nouvelle') DEFAULT NULL,
  `read` int(11) DEFAULT NULL,
  `idconsultation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `resultat`
--

INSERT INTO `resultat` (`idresultat`, `idpatient`, `iddocteur`, `typeexamen`, `resultat`, `dateexamen`, `statut`, `read`, `idconsultation`) VALUES
(57, 60, 25, 'sang', 'C:\\xampp\\htdocs\\easydoctor\\pages\\docteur/img/ordonnance (2).pdf', '0000-00-00', '', 0, NULL),
(58, 60, 25, 'sang', 'C:\\xampp\\htdocs\\easydoctor\\pages\\docteur/img/ordonnance (2).pdf', '0000-00-00', '', 0, NULL),
(59, 60, 25, 'sang', 'C:\\xampp\\htdocs\\easydoctor\\pages\\docteur/img/dossier_medical (3).pdf', '0000-00-00', '', 0, NULL);

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
(10, 'Généraliste', 'palu', 0),
(11, 'Dentiste', 'les dents', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `iddocteur` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `idvideo` int(11) NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `lien` varchar(255) NOT NULL,
  `iddocteur` int(11) NOT NULL,
  `idpatient` int(11) NOT NULL,
  `statut` enum('nouvelle') NOT NULL,
  `is_read` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`idvideo`, `date`, `heure`, `lien`, `iddocteur`, `idpatient`, `statut`, `is_read`) VALUES
(14, '2024-09-27', '10:46:00', 'https://meet.jit.si/meeting_66f3dbae3b75e', 25, 60, 'nouvelle', 0),
(15, '2024-09-26', '10:45:00', 'https://meet.jit.si/meeting_66f3dc01ab6a0', 25, 60, 'nouvelle', 0),
(16, '2024-09-27', '12:47:00', 'https://meet.jit.si/meeting_66f3dc32210c8', 25, 60, 'nouvelle', 0),
(17, '2024-09-27', '10:00:00', 'https://meet.jit.si/meeting_66f3de74d46da', 25, 60, 'nouvelle', 0),
(18, '2024-09-27', '10:20:00', 'https://meet.jit.si/meeting_66f3dead2ea53', 25, 59, 'nouvelle', 0),
(19, '2024-09-27', '11:22:00', 'https://meet.jit.si/meeting_66f3e427924ff', 25, 59, 'nouvelle', 0),
(20, '2024-09-27', '11:27:00', 'https://meet.jit.si/meeting_66f3e5211af74', 25, 59, 'nouvelle', 0),
(21, '2024-09-28', '11:30:00', 'https://meet.jit.si/meeting_66f3e5c27c5be', 25, 59, 'nouvelle', 0),
(22, '2024-09-20', '11:30:00', 'https://meet.jit.si/meeting_66f3e614eca1e', 25, 59, 'nouvelle', 0),
(23, '2024-09-26', '11:40:00', 'https://meet.jit.si/meeting_66f3e7e7aea77', 25, 60, 'nouvelle', 0),
(24, '2024-09-27', '11:50:00', 'https://meet.jit.si/meeting_66f3e9fbca07f', 25, 60, 'nouvelle', 0),
(25, '2024-09-26', '11:50:00', 'https://meet.jit.si/meeting_66f3ea4fa6a71', 25, 60, 'nouvelle', 0),
(26, '2024-09-27', '16:23:00', 'https://meet.jit.si/meeting_66f42a7d4b1a7', 25, 62, 'nouvelle', 0),
(27, '2024-09-27', '16:23:00', 'https://meet.jit.si/meeting_66f42c5ade7a8', 25, 62, 'nouvelle', 0),
(28, '2024-10-02', '13:30:00', 'https://meet.jit.si/meeting_66f947b39a5e2', 25, 60, 'nouvelle', 0),
(29, '2024-10-01', '13:30:00', 'https://meet.jit.si/meeting_66f948502f3c1', 25, 60, 'nouvelle', 0),
(30, '2024-09-30', '10:54:00', 'https://meet.jit.si/meeting_66fa751e0196e', 25, 60, 'nouvelle', 0);

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
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`idmessage`),
  ADD KEY `iddocteur` (`iddocteur`),
  ADD KEY `idpatient` (`idpatient`);

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
  ADD KEY `idspecialiste` (`idspecialiste`),
  ADD KEY `iddocteur` (`iddocteur`);

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
  ADD KEY `idpatient` (`idpatient`),
  ADD KEY `iddocteur` (`iddocteur`),
  ADD KEY `idconsultation` (`idconsultation`);

--
-- Index pour la table `specialiste`
--
ALTER TABLE `specialiste`
  ADD PRIMARY KEY (`idspecialiste`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iddocteur`,`idpatient`),
  ADD KEY `idpatient` (`idpatient`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`idvideo`),
  ADD KEY `iddocteur` (`iddocteur`),
  ADD KEY `idpatient` (`idpatient`);

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
  MODIFY `idconsultation` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT pour la table `creneaux`
--
ALTER TABLE `creneaux`
  MODIFY `idcreneau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `docteur`
--
ALTER TABLE `docteur`
  MODIFY `iddocteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `dossiermedical`
--
ALTER TABLE `dossiermedical`
  MODIFY `iddossier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `idmessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT pour la table `ordonnance`
--
ALTER TABLE `ordonnance`
  MODIFY `idordonnance` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `idpatient` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  MODIFY `idrendezvous` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT pour la table `resultat`
--
ALTER TABLE `resultat`
  MODIFY `idresultat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `specialiste`
--
ALTER TABLE `specialiste`
  MODIFY `idspecialiste` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `idvideo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`idspecialiste`) REFERENCES `specialiste` (`idspecialiste`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_ibfk_2` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `resultat_ibfk_1` FOREIGN KEY (`idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resultat_ibfk_2` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resultat_ibfk_3` FOREIGN KEY (`idconsultation`) REFERENCES `consultation` (`idconsultation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`iddocteur`) REFERENCES `docteur` (`iddocteur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_ibfk_2` FOREIGN KEY (`idpatient`) REFERENCES `patient` (`idpatient`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
