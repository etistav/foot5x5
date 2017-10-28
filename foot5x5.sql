-- phpMyAdmin SQL Dump
-- version 4.4.1.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Dim 24 Mai 2015 à 21:05
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `foot5x5`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_finances_old`
--

CREATE TABLE `t_finances_old` (
  `fin_id` int(11) NOT NULL,
  `fin_giverId` int(11) NOT NULL,
  `fin_receiverId` int(11) NOT NULL,
  `fin_amount` double NOT NULL,
  `fin_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_finances_old`
--

INSERT INTO `t_finances_old` (`fin_id`, `fin_giverId`, `fin_receiverId`, `fin_amount`, `fin_date`) VALUES
(1, 30, 6, 6, '2015-02-04'),
(2, 29, 17, 18, '2015-02-06'),
(3, 19, 6, 42, '2015-02-11'),
(4, 1, 18, 6, '2015-02-19'),
(5, 17, 6, 18, '2015-02-28'),
(6, 17, 10, 24, '2015-02-28'),
(7, 25, 19, 9, '2015-03-06'),
(8, 20, 10, 6, '2015-03-13'),
(9, 20, 27, 21, '2015-03-13'),
(10, 4, 18, 6, '2015-03-19'),
(11, 21, 14, 10, '2015-03-20'),
(12, 19, 12, 3, '2015-03-26'),
(13, 0, 0, 60, '2015-03-26'),
(14, 0, 0, 24, '2015-04-01'),
(15, 24, 6, 21, '2015-04-02'),
(16, 5, 10, 12, '2015-04-02');

-- --------------------------------------------------------

--
-- Structure de la table `t_matches`
--

CREATE TABLE `t_matches` (
  `mat_id` int(11) NOT NULL,
  `mat_num` int(11) NOT NULL,
  `mat_scoreA` int(11) NOT NULL,
  `mat_scoreB` int(11) NOT NULL,
  `mat_date` date NOT NULL,
  `mat_year` int(11) NOT NULL,
  `mat_trimester` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_matches`
--

INSERT INTO `t_matches` (`mat_id`, `mat_num`, `mat_scoreA`, `mat_scoreB`, `mat_date`, `mat_year`, `mat_trimester`) VALUES
(1, 1, 9, 6, '2015-01-08', 2015, 1),
(2, 2, 6, 6, '2015-01-22', 2015, 1),
(3, 3, 8, 14, '2015-01-29', 2015, 1),
(4, 4, 5, 9, '2015-02-05', 2015, 1),
(5, 5, 8, 4, '2015-02-12', 2015, 1),
(6, 6, 7, 5, '2015-02-19', 2015, 1),
(7, 7, 8, 12, '2015-02-24', 2015, 1),
(8, 8, 5, 10, '2015-02-26', 2015, 1),
(9, 9, 7, 7, '2015-03-12', 2015, 1),
(10, 10, 10, 4, '2015-03-19', 2015, 1),
(11, 11, 11, 3, '2015-03-26', 2015, 1),
(12, 12, 5, 12, '2015-03-31', 2015, 1),
(15, 3, 5, 6, '2015-04-30', 2015, 2),
(16, 1, 5, 5, '2015-04-16', 2015, 2),
(18, 2, 10, 7, '2015-04-23', 2015, 2),
(22, 5, 13, 7, '2015-05-13', 2015, 2),
(23, 4, 5, 4, '2015-05-07', 2015, 2),
(24, 6, 7, 7, '2015-05-21', 2015, 2);

-- --------------------------------------------------------

--
-- Structure de la table `t_matchPlayers`
--

CREATE TABLE `t_matchPlayers` (
  `mpl_id` int(11) NOT NULL,
  `mpl_playerId` int(11) NOT NULL,
  `mpl_matchId` int(11) NOT NULL,
  `mpl_team` varchar(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_matchPlayers`
--

INSERT INTO `t_matchPlayers` (`mpl_id`, `mpl_playerId`, `mpl_matchId`, `mpl_team`) VALUES
(1, 10, 1, 'A'),
(2, 14, 1, 'A'),
(3, 18, 1, 'A'),
(4, 27, 1, 'A'),
(5, 23, 1, 'A'),
(6, 6, 2, 'A'),
(7, 10, 2, 'A'),
(8, 12, 2, 'A'),
(9, 22, 2, 'A'),
(10, 23, 2, 'A'),
(11, 18, 3, 'A'),
(12, 17, 3, 'A'),
(13, 22, 3, 'A'),
(14, 6, 3, 'A'),
(15, 7, 3, 'A'),
(16, 1, 4, 'A'),
(17, 10, 4, 'A'),
(18, 16, 4, 'A'),
(19, 18, 4, 'A'),
(20, 27, 4, 'A'),
(21, 6, 5, 'A'),
(22, 10, 5, 'A'),
(23, 12, 5, 'A'),
(24, 19, 5, 'A'),
(25, 27, 5, 'A'),
(26, 27, 6, 'A'),
(27, 11, 6, 'A'),
(28, 12, 6, 'A'),
(29, 14, 6, 'A'),
(30, 19, 6, 'A'),
(31, 17, 7, 'A'),
(32, 20, 7, 'A'),
(33, 19, 7, 'A'),
(34, 23, 7, 'A'),
(35, 24, 7, 'A'),
(36, 6, 8, 'A'),
(37, 12, 8, 'A'),
(38, 17, 8, 'A'),
(39, 20, 8, 'A'),
(40, 27, 8, 'A'),
(41, 22, 1, 'B'),
(42, 17, 1, 'B'),
(43, 11, 1, 'B'),
(44, 12, 1, 'B'),
(45, 6, 1, 'B'),
(46, 11, 2, 'B'),
(47, 17, 2, 'B'),
(48, 18, 2, 'B'),
(49, 19, 2, 'B'),
(50, 27, 2, 'B'),
(51, 12, 3, 'B'),
(52, 14, 3, 'B'),
(53, 10, 3, 'B'),
(54, 11, 3, 'B'),
(55, 19, 3, 'B'),
(56, 6, 4, 'B'),
(57, 11, 4, 'B'),
(58, 12, 4, 'B'),
(59, 14, 4, 'B'),
(60, 23, 4, 'B'),
(61, 14, 5, 'B'),
(62, 17, 5, 'B'),
(63, 18, 5, 'B'),
(64, 22, 5, 'B'),
(65, 23, 5, 'B'),
(66, 6, 6, 'B'),
(67, 22, 6, 'B'),
(68, 17, 6, 'B'),
(69, 18, 6, 'B'),
(70, 10, 6, 'B'),
(71, 10, 7, 'B'),
(72, 11, 7, 'B'),
(73, 18, 7, 'B'),
(74, 22, 7, 'B'),
(75, 25, 7, 'B'),
(76, 10, 8, 'B'),
(77, 11, 8, 'B'),
(78, 14, 8, 'B'),
(79, 22, 8, 'B'),
(80, 24, 8, 'B'),
(81, 6, 9, 'A'),
(82, 20, 9, 'A'),
(83, 14, 9, 'A'),
(84, 19, 9, 'A'),
(85, 12, 9, 'A'),
(86, 5, 10, 'A'),
(87, 17, 10, 'A'),
(88, 20, 10, 'A'),
(89, 19, 10, 'A'),
(90, 29, 10, 'A'),
(91, 6, 11, 'A'),
(92, 10, 11, 'A'),
(93, 11, 11, 'A'),
(94, 19, 11, 'A'),
(95, 29, 11, 'A'),
(96, 11, 12, 'A'),
(97, 17, 12, 'A'),
(98, 24, 12, 'A'),
(99, 27, 12, 'A'),
(100, 29, 12, 'A'),
(101, 10, 9, 'B'),
(102, 11, 9, 'B'),
(103, 21, 9, 'B'),
(104, 17, 9, 'B'),
(105, 29, 9, 'B'),
(106, 12, 10, 'B'),
(107, 10, 10, 'B'),
(108, 14, 10, 'B'),
(109, 22, 10, 'B'),
(110, 28, 10, 'B'),
(111, 1, 11, 'B'),
(112, 12, 11, 'B'),
(113, 14, 11, 'B'),
(114, 22, 11, 'B'),
(115, 27, 11, 'B'),
(116, 5, 12, 'B'),
(117, 10, 12, 'B'),
(118, 14, 12, 'B'),
(119, 22, 12, 'B'),
(120, 28, 12, 'B'),
(141, 6, 15, 'A'),
(142, 10, 15, 'B'),
(143, 11, 15, 'A'),
(144, 14, 15, 'B'),
(145, 12, 15, 'A'),
(146, 17, 15, 'B'),
(147, 19, 15, 'A'),
(148, 18, 15, 'B'),
(149, 27, 15, 'A'),
(150, 22, 15, 'B'),
(151, 5, 16, 'A'),
(152, 6, 16, 'B'),
(153, 11, 16, 'A'),
(154, 10, 16, 'B'),
(155, 14, 16, 'A'),
(156, 22, 16, 'B'),
(157, 17, 16, 'A'),
(158, 28, 16, 'B'),
(159, 19, 16, 'A'),
(160, 29, 16, 'B'),
(171, 6, 18, 'A'),
(172, 5, 18, 'B'),
(173, 10, 18, 'A'),
(174, 32, 18, 'B'),
(175, 11, 18, 'A'),
(176, 19, 18, 'B'),
(177, 16, 18, 'A'),
(178, 26, 18, 'B'),
(179, 17, 18, 'A'),
(180, 29, 18, 'B'),
(211, 5, 22, 'A'),
(212, 6, 22, 'B'),
(213, 14, 22, 'A'),
(214, 10, 22, 'B'),
(215, 22, 22, 'A'),
(216, 11, 22, 'B'),
(217, 23, 22, 'A'),
(218, 12, 22, 'B'),
(219, 29, 22, 'A'),
(220, 17, 22, 'B'),
(221, 6, 23, 'A'),
(222, 5, 23, 'B'),
(223, 12, 23, 'A'),
(224, 16, 23, 'B'),
(225, 14, 23, 'A'),
(226, 17, 23, 'B'),
(227, 22, 23, 'A'),
(228, 18, 23, 'B'),
(229, 29, 23, 'A'),
(230, 19, 23, 'B'),
(231, 11, 24, 'A'),
(232, 5, 24, 'B'),
(233, 12, 24, 'A'),
(234, 6, 24, 'B'),
(235, 14, 24, 'A'),
(236, 10, 24, 'B'),
(237, 18, 24, 'A'),
(238, 17, 24, 'B'),
(239, 22, 24, 'A'),
(240, 19, 24, 'B');

-- --------------------------------------------------------

--
-- Structure de la table `t_notes`
--

CREATE TABLE `t_notes` (
  `not_id` int(11) NOT NULL,
  `not_evaluatorId` int(11) NOT NULL,
  `not_playerId` int(11) NOT NULL,
  `not_valAtt` double NOT NULL,
  `not_valDef` double NOT NULL,
  `not_valPhy` double NOT NULL,
  `not_valAvg` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_notes`
--

INSERT INTO `t_notes` (`not_id`, `not_evaluatorId`, `not_playerId`, `not_valAtt`, `not_valDef`, `not_valPhy`, `not_valAvg`) VALUES
(1, 1, 1, 7, 4, 5, 5.4),
(2, 1, 2, 6, 5, 9, 6.2),
(3, 1, 3, 7.5, 5.5, 7, 6.6),
(4, 1, 4, 3, 4, 4, 3.6),
(5, 1, 5, 9, 6, 7, 7.4),
(6, 1, 6, 7, 5, 6, 6),
(7, 1, 7, 6, 7, 9, 6.8),
(8, 1, 8, 9, 7, 7, 7.8),
(9, 1, 9, 5.5, 9, 8, 7.4),
(10, 1, 11, 6, 10, 8, 8),
(11, 1, 12, 7, 5, 6, 6),
(12, 1, 13, 8, 8, 8, 8),
(13, 1, 14, 6, 7, 8, 6.8),
(14, 1, 15, 7, 4, 5, 5.4),
(15, 1, 16, 4, 6, 8, 5.6),
(16, 1, 17, 7, 5, 8, 6.4),
(17, 1, 18, 5.5, 5, 5, 5.2),
(18, 1, 20, 9.5, 9.5, 9.5, 9.5),
(19, 1, 19, 6.5, 7, 8, 7),
(20, 1, 21, 7, 8, 9, 7.8),
(21, 1, 22, 9, 7, 6, 7.6),
(22, 1, 23, 5, 9, 8, 7.2),
(23, 1, 24, 5, 6, 7, 5.8),
(24, 1, 25, 8, 7, 7, 7.4),
(25, 1, 26, 4, 6, 7, 5.4),
(26, 1, 27, 8, 9, 8, 8.4),
(27, 1, 28, 6, 8, 8.5, 7.3),
(28, 1, 29, 5, 6.5, 7, 6),
(29, 1, 30, 7, 5.5, 7, 6.4),
(30, 3, 1, 6, 5, 5, 5.4),
(31, 3, 2, 6, 7, 7, 6.6),
(32, 3, 3, 7, 6, 5, 6.2),
(33, 3, 5, 7, 6, 4, 6),
(34, 3, 6, 6, 4, 3, 4.6),
(35, 3, 7, 4, 6, 7, 5.4),
(36, 3, 10, 6, 8, 5, 6.6),
(37, 3, 11, 5, 9, 8, 7.2),
(38, 3, 12, 6, 4, 5, 5),
(39, 3, 13, 7, 7, 7, 7),
(40, 3, 14, 4, 5, 6, 4.8),
(41, 3, 16, 2, 5, 6, 4),
(42, 3, 17, 4, 7, 7, 5.8),
(43, 3, 18, 5, 4, 4, 4.4),
(44, 3, 20, 9, 9, 8, 8.8),
(45, 3, 19, 4, 6, 7, 5.4),
(46, 3, 21, 6, 7, 6, 6.4),
(47, 3, 22, 8, 7, 4, 6.8),
(48, 3, 23, 4, 7, 6, 5.6),
(49, 3, 24, 4, 5, 5, 4.6),
(50, 3, 25, 7, 6, 7, 6.6),
(51, 3, 26, 4, 6, 5, 5),
(52, 3, 27, 6, 7, 7, 6.6),
(53, 3, 28, 5, 6, 6, 5.6),
(54, 3, 29, 4, 5, 4, 4.4),
(55, 3, 30, 6, 6, 4, 5.6),
(56, 5, 5, 9, 6, 5, 7),
(57, 5, 6, 7, 5, 7, 6.2),
(58, 5, 7, 5, 6, 7, 5.8),
(59, 5, 9, 5, 8, 8, 6.8),
(60, 5, 10, 6, 8, 8, 7.2),
(61, 5, 11, 6, 9, 6, 7.2),
(62, 5, 12, 6, 6, 7, 6.2),
(63, 5, 14, 4, 6, 6, 5.2),
(64, 5, 16, 4, 4, 4, 4),
(65, 5, 17, 7, 7, 9, 7.4),
(66, 5, 20, 10, 10, 9, 9.8),
(67, 5, 19, 5, 6, 8, 6),
(68, 5, 22, 6, 7, 5, 6.2),
(69, 5, 23, 6, 8, 9, 7.4),
(70, 5, 24, 4, 6, 6, 5.2),
(71, 5, 27, 7, 8, 8, 7.6),
(72, 5, 30, 7, 6, 7, 6.6),
(73, 4, 1, 7.5, 5.5, 6, 6.4),
(74, 4, 2, 8, 7.5, 7, 7.6),
(75, 4, 3, 7.5, 7, 7, 7.2),
(76, 4, 4, 4, 5, 4, 4.4),
(77, 4, 5, 8.5, 6.5, 7, 7.4),
(78, 4, 7, 6.5, 6, 7, 6.4),
(79, 4, 10, 7, 8.5, 8, 7.8),
(80, 4, 11, 8, 9, 8, 8.4),
(81, 4, 12, 7, 6, 5.5, 6.3),
(82, 4, 14, 6, 6, 6.5, 6.1),
(83, 4, 17, 7, 7, 7, 7),
(84, 4, 18, 5.5, 6, 5.5, 5.7),
(85, 4, 20, 9.5, 9, 9.5, 9.3),
(86, 4, 19, 6.5, 6.5, 7.5, 6.7),
(87, 4, 22, 8, 8, 7, 7.8),
(88, 4, 23, 6, 8.5, 8.5, 7.5),
(89, 4, 24, 5, 6, 6, 5.6),
(90, 4, 27, 7.5, 7.5, 7.5, 7.5),
(91, 4, 29, 6, 5.5, 6, 5.8),
(92, 4, 30, 7.5, 6.5, 7, 7),
(93, 6, 5, 8.5, 7.5, 7, 7.8),
(94, 6, 6, 7, 6, 6.5, 6.5),
(95, 6, 8, 9, 8, 8.5, 8.5),
(96, 6, 10, 8.5, 8.5, 8.5, 8.5),
(97, 6, 11, 7.5, 9.5, 8.5, 8.5),
(98, 6, 12, 7, 6, 6.5, 6.5),
(99, 6, 13, 8.5, 8, 9, 8.4),
(100, 6, 14, 7.5, 6.5, 9.5, 7.5),
(101, 6, 17, 7, 6.5, 9, 7.2),
(102, 6, 18, 6.5, 6, 7, 6.4),
(103, 6, 19, 7.5, 7, 9, 7.6),
(104, 6, 21, 8.5, 8, 9, 8.4),
(105, 6, 22, 9, 9, 8, 8.8),
(106, 6, 23, 6.5, 8.5, 9.5, 7.9),
(107, 6, 24, 7, 6.5, 7, 6.8),
(108, 6, 25, 8.5, 8.5, 8.5, 8.5),
(109, 6, 27, 8, 8, 8.5, 8.1),
(110, 6, 28, 8, 8, 8.5, 8.1),
(111, 6, 29, 6.5, 7, 7, 6.8),
(112, 6, 30, 7.5, 7, 7, 7.2),
(113, 7, 5, 9, 5, 4, 6.4),
(114, 7, 6, 7, 4, 4, 5.2),
(115, 7, 7, 4, 7, 8, 6),
(116, 7, 9, 4, 6, 4, 4.8),
(117, 7, 10, 6, 7, 7, 6.6),
(118, 7, 11, 5, 7, 3, 5.4),
(119, 7, 14, 5, 6, 8, 6),
(120, 7, 16, 4, 4, 8, 4.8),
(121, 7, 20, 10, 6, 7, 7.8),
(122, 7, 19, 4, 7, 8, 6),
(123, 7, 23, 4, 9, 9, 7),
(124, 7, 24, 4, 6, 4, 4.8),
(125, 7, 27, 7, 8, 8, 7.6),
(126, 7, 30, 7, 6, 5, 6.2);

-- --------------------------------------------------------

--
-- Structure de la table `t_players`
--

CREATE TABLE `t_players` (
  `plr_id` int(11) NOT NULL,
  `plr_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `plr_valAtt` double(4,2) NOT NULL,
  `plr_valDef` double(4,2) NOT NULL,
  `plr_valPhy` double(4,2) NOT NULL,
  `plr_valAvg` double(4,2) NOT NULL,
  `plr_cashBalance` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_players`
--

INSERT INTO `t_players` (`plr_id`, `plr_name`, `plr_valAtt`, `plr_valDef`, `plr_valPhy`, `plr_valAvg`, `plr_cashBalance`) VALUES
(1, 'Adil', 6.83, 4.83, 5.33, 5.73, -6),
(2, 'Almamy', 6.67, 6.50, 7.67, 6.80, -12),
(3, 'Amaury', 7.33, 6.17, 6.33, 6.67, -6),
(4, 'Amine', 3.50, 4.50, 4.00, 4.00, 0),
(5, 'Arnaud', 8.50, 6.17, 5.67, 7.00, -12),
(6, 'Benoît', 6.80, 4.80, 5.30, 5.70, 0),
(7, 'Bérenger', 5.10, 6.40, 7.60, 6.08, -24),
(8, 'David F.', 9.00, 7.50, 7.75, 8.15, 0),
(9, 'David V.', 4.83, 7.67, 6.67, 6.33, 0),
(10, 'Eti', 6.70, 8.00, 7.30, 7.34, -12),
(11, 'H.Im', 6.25, 8.92, 6.92, 7.45, 18),
(12, 'JB', 6.60, 5.40, 6.00, 6.00, 18),
(13, 'Jérôme', 7.83, 7.67, 8.00, 7.80, 0),
(14, 'Jon', 5.42, 6.08, 7.33, 6.07, -1),
(15, 'Julien B.', 7.00, 4.00, 5.00, 5.40, 0),
(16, 'Julien Bes', 3.50, 4.75, 6.50, 4.60, -6),
(17, 'Karel', 6.40, 6.50, 8.00, 6.76, 6),
(18, 'Kevin', 5.62, 5.25, 5.38, 5.42, 36),
(19, 'Maiki', 5.58, 6.58, 7.92, 6.45, 6),
(20, 'Max', 9.60, 8.70, 8.60, 9.04, 0),
(21, 'Nico C.', 7.17, 7.67, 8.00, 7.53, 4),
(22, 'Olivier', 8.00, 7.60, 6.00, 7.44, 18),
(23, 'Pti Ben', 5.25, 8.33, 8.33, 7.10, 9),
(24, 'Pti Nico', 4.83, 5.92, 5.83, 5.47, 0),
(25, 'Quentin', 7.83, 7.17, 7.50, 7.50, 0),
(26, 'Thomas', 4.00, 6.00, 6.00, 5.20, -6),
(27, 'Tober', 7.25, 7.92, 7.83, 7.63, 6),
(28, 'Tommy', 6.33, 7.33, 7.67, 7.00, -24),
(29, 'Vincent', 5.38, 6.00, 6.00, 5.75, -12),
(30, 'Xav', 7.00, 6.17, 6.17, 6.50, 0),
(32, 'Etienne G.', 5.00, 5.00, 5.00, 5.00, 0);

-- --------------------------------------------------------

--
-- Structure de la table `t_players_old`
--

CREATE TABLE `t_players_old` (
  `plr_id` int(11) NOT NULL,
  `plr_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `plr_valAtt` double DEFAULT NULL,
  `plr_valDef` double DEFAULT NULL,
  `plr_valPhy` double DEFAULT NULL,
  `plr_valAvg` double DEFAULT NULL,
  `plr_cashBalance` double DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_players_old`
--

INSERT INTO `t_players_old` (`plr_id`, `plr_name`, `plr_valAtt`, `plr_valDef`, `plr_valPhy`, `plr_valAvg`, `plr_cashBalance`) VALUES
(1, 'Adil', 5, 5, 5, 5, -6),
(2, 'Almamy', 5, 5, 5, 5, -12),
(3, 'Amaury', 5, 5, 5, 5, -6),
(4, 'Amine', 5, 5, 5, 5, 0),
(5, 'Arnaud', 5, 5, 5, 5, -12),
(6, 'Benoît', 5, 5, 5, 5, 0),
(7, 'Bérenger', 5, 5, 5, 5, -24),
(8, 'David F.', 5, 5, 5, 5, 0),
(9, 'David V.', 5, 5, 5, 5, 0),
(10, 'Eti', 5, 5, 5, 5, -12),
(11, 'H.Im', 5, 5, 5, 5, 18),
(12, 'JB', 5, 5, 5, 5, 18),
(13, 'Jérôme', 5, 5, 5, 5, 0),
(14, 'Jon', 5, 5, 5, 5, -1),
(15, 'Julien B.', 5, 5, 5, 5, 0),
(16, 'Julien Bes', 5, 5, 5, 5, -6),
(17, 'Karel', 5, 5, 5, 5, 6),
(18, 'Kevin', 5, 5, 5, 5, 36),
(19, 'Maiki', 5, 5, 5, 5, 6),
(20, 'Max', 5, 5, 5, 5, 0),
(21, 'Nico C.', 5, 5, 5, 5, 4),
(22, 'Olivier', 5, 5, 5, 5, 18),
(23, 'Pti Ben', 5, 5, 5, 5, 9),
(24, 'Pti Nico', 5, 5, 5, 5, 0),
(25, 'Quentin', 5, 5, 5, 5, 0),
(26, 'Thomas', 5, 5, 5, 5, -6),
(27, 'Tober', 5, 5, 5, 5, 6),
(28, 'Tommy', 5, 5, 5, 5, -24),
(29, 'Vincent', 5, 5, 5, 5, -12),
(30, 'Xav', 5, 5, 5, 5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `t_rankings`
--

CREATE TABLE `t_rankings` (
  `rnk_id` int(11) NOT NULL,
  `rnk_standingId` int(11) NOT NULL,
  `rnk_playerId` int(11) NOT NULL,
  `rnk_rank` int(11) NOT NULL,
  `rnk_points` int(11) NOT NULL,
  `rnk_played` int(11) NOT NULL,
  `rnk_won` int(11) NOT NULL,
  `rnk_drawn` int(11) NOT NULL,
  `rnk_lost` int(11) NOT NULL,
  `rnk_goalsFor` int(11) NOT NULL,
  `rnk_goalsAgainst` int(11) NOT NULL,
  `rnk_goalsDiff` int(11) NOT NULL,
  `rnk_eval` double(4,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_rankings`
--

INSERT INTO `t_rankings` (`rnk_id`, `rnk_standingId`, `rnk_playerId`, `rnk_rank`, `rnk_points`, `rnk_played`, `rnk_won`, `rnk_drawn`, `rnk_lost`, `rnk_goalsFor`, `rnk_goalsAgainst`, `rnk_goalsDiff`, `rnk_eval`) VALUES
(198, 5, 6, 7, 11, 9, 3, 2, 4, 65, 65, 0, 7.20),
(199, 5, 10, 1, 23, 12, 7, 2, 3, 103, 78, 25, 12.67),
(200, 5, 11, 2, 20, 10, 6, 2, 2, 87, 68, 19, 12.32),
(201, 5, 12, 5, 14, 10, 4, 2, 4, 69, 75, -6, 8.59),
(202, 5, 14, 4, 19, 10, 6, 1, 3, 79, 70, 9, 11.76),
(203, 5, 17, 14, 5, 10, 1, 2, 7, 64, 89, -25, 2.99),
(204, 5, 18, 11, 7, 7, 2, 1, 4, 49, 58, -9, 5.48),
(205, 5, 19, 3, 17, 8, 5, 2, 1, 71, 49, 22, 12.13),
(206, 5, 20, 12, 4, 4, 1, 1, 2, 30, 33, -3, 4.77),
(207, 5, 22, 10, 10, 10, 3, 1, 6, 70, 83, -13, 6.16),
(208, 5, 23, 9, 7, 5, 2, 1, 2, 36, 37, -1, 7.05),
(209, 5, 24, 13, 3, 3, 1, 0, 2, 23, 29, -6, 4.67),
(210, 5, 27, 8, 10, 8, 3, 1, 4, 48, 63, -15, 7.15),
(211, 5, 29, 6, 7, 4, 2, 1, 1, 33, 26, 7, 8.43),
(241, 7, 5, 9, 5, 5, 1, 2, 2, 36, 34, 2, 5.97),
(242, 7, 6, 5, 8, 6, 2, 2, 2, 39, 42, -3, 8.67),
(243, 7, 10, 4, 8, 5, 2, 2, 1, 35, 37, -2, 9.71),
(244, 7, 11, 10, 5, 5, 1, 2, 2, 34, 38, -4, 5.97),
(245, 7, 12, 11, 4, 4, 1, 1, 2, 24, 30, -6, 5.63),
(246, 7, 14, 2, 11, 5, 3, 2, 0, 36, 28, 8, 13.44),
(247, 7, 16, 7, 3, 2, 1, 0, 1, 14, 12, 2, 7.33),
(248, 7, 17, 6, 8, 6, 2, 2, 2, 39, 42, -3, 8.67),
(249, 7, 18, 8, 4, 3, 1, 1, 1, 17, 17, 0, 6.93),
(250, 7, 19, 12, 2, 5, 0, 2, 3, 28, 33, -5, 2.24),
(251, 7, 22, 1, 11, 5, 3, 2, 0, 36, 28, 8, 13.44),
(252, 7, 29, 3, 7, 4, 2, 1, 1, 30, 26, 4, 9.97);

-- --------------------------------------------------------

--
-- Structure de la table `t_standings`
--

CREATE TABLE `t_standings` (
  `std_id` int(11) NOT NULL,
  `std_year` int(11) NOT NULL,
  `std_trimester` int(11) NOT NULL,
  `std_nbMatch` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_standings`
--

INSERT INTO `t_standings` (`std_id`, `std_year`, `std_trimester`, `std_nbMatch`) VALUES
(1, 2014, 1, 12),
(2, 2014, 2, 12),
(3, 2014, 3, 12),
(4, 2014, 4, 12),
(5, 2015, 1, 12),
(7, 2015, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `t_users`
--

CREATE TABLE `t_users` (
  `usr_id` int(11) NOT NULL,
  `usr_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usr_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usr_salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usr_roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `usr_playerId` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_users`
--

INSERT INTO `t_users` (`usr_id`, `usr_username`, `usr_password`, `usr_salt`, `usr_roles`, `usr_playerId`) VALUES
(1, 'eti', 'U2ghzGUAKAD809f3CX/W4+6Q7OM8axO17NMCixuj/yoSaQsuNcW0d8TKZlJmpTg3N+KjJd/du8eA8Fm3Z+lgvA==', '8cb5c6feb06f5f682bdb0d9', 'a:1:{i:0;s:10:"ROLE_ADMIN";}', 10),
(2, 'maiki', 'UszvxPbwD4Wc/aOqqIjDI4ZzZRMtgiLZfugUrwP5TB1i8m+mjFcTLRxvVE3VgrjenQTyYanryvZceWJoAOI98Q==', 'ba30e3de00395bdb0e2a433', 'a:1:{i:0;s:14:"ROLE_EVALUATOR";}', 19),
(3, 'benoit', '+tqO7y0DiGD8wPeL6zbG4xHhYXLaZN/QHrjU3P3JcbWswEzPGWJofHE1lxrmOxLpkpYz87sNFe+5K7gmt/BADw==', '3e3c8ae1fe80ed981bf38d8', 'a:1:{i:0;s:14:"ROLE_EVALUATOR";}', 6),
(4, 'tober', 'LFJtMjlEauA2TveuvUeRYT6uNV+PESc2pH65E4LVfor3TuHXCNssr/spRsiZFQG2TS6UtH2fkEpsZ85x/T8/KQ==', '2e9650c993a5713e2f7faa9', 'a:1:{i:0;s:14:"ROLE_EVALUATOR";}', 27),
(5, 'max', 'N9AhHcZBZKXTdCPd5/Re1jUqch5tMvw6nMzu7l9goMPGSoggyWEwppSHuviLlQvmIObF26SpuvV8bUG0oswq+w==', '45a82fd625900549cf4fc48', 'a:1:{i:0;s:14:"ROLE_EVALUATOR";}', 20),
(6, 'xav', 'c+emhhOz7THZ4IYziA1EQ3bHUddYPHk/F8sO/ClCZUoulnxt7/JPF7FZkbaR4rYyJWXcWmXCpEb/ZhPOqgAArw==', '1833390e85f796a67b3511d', 'a:1:{i:0;s:14:"ROLE_EVALUATOR";}', 30),
(7, 'jon', 'P33AjLXnfVR5wVrKkyXCHvfxMYv/hKt0kRUx5T9YzXaaiAwgPrtV2pbWD5FZjiuxYC/iWD7RRI2VKA/62orb8g==', '1c58c5b362801fcab68e03e', 'a:1:{i:0;s:14:"ROLE_EVALUATOR";}', 14);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_finances_old`
--
ALTER TABLE `t_finances_old`
  ADD PRIMARY KEY (`fin_id`);

--
-- Index pour la table `t_matches`
--
ALTER TABLE `t_matches`
  ADD PRIMARY KEY (`mat_id`);

--
-- Index pour la table `t_matchPlayers`
--
ALTER TABLE `t_matchPlayers`
  ADD PRIMARY KEY (`mpl_id`),
  ADD KEY `IDX_C6F8050AB2FF9061` (`mpl_playerId`),
  ADD KEY `IDX_C6F8050A1177583C` (`mpl_matchId`);

--
-- Index pour la table `t_notes`
--
ALTER TABLE `t_notes`
  ADD PRIMARY KEY (`not_id`),
  ADD KEY `IDX_BFAAC0F5AE03366D` (`not_evaluatorId`),
  ADD KEY `IDX_BFAAC0F5CC16B380` (`not_playerId`);

--
-- Index pour la table `t_players`
--
ALTER TABLE `t_players`
  ADD PRIMARY KEY (`plr_id`);

--
-- Index pour la table `t_players_old`
--
ALTER TABLE `t_players_old`
  ADD PRIMARY KEY (`plr_id`);

--
-- Index pour la table `t_rankings`
--
ALTER TABLE `t_rankings`
  ADD PRIMARY KEY (`rnk_id`),
  ADD KEY `IDX_49BCB9BC11925612` (`rnk_standingId`),
  ADD KEY `IDX_49BCB9BCD22F1658` (`rnk_playerId`);

--
-- Index pour la table `t_standings`
--
ALTER TABLE `t_standings`
  ADD PRIMARY KEY (`std_id`);

--
-- Index pour la table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `UNIQ_AA32C39062D70665` (`usr_username`),
  ADD UNIQUE KEY `UNIQ_AA32C390186EDC39` (`usr_playerId`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_finances_old`
--
ALTER TABLE `t_finances_old`
  MODIFY `fin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `t_matches`
--
ALTER TABLE `t_matches`
  MODIFY `mat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `t_matchPlayers`
--
ALTER TABLE `t_matchPlayers`
  MODIFY `mpl_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=241;
--
-- AUTO_INCREMENT pour la table `t_notes`
--
ALTER TABLE `t_notes`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT pour la table `t_players`
--
ALTER TABLE `t_players`
  MODIFY `plr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT pour la table `t_players_old`
--
ALTER TABLE `t_players_old`
  MODIFY `plr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT pour la table `t_rankings`
--
ALTER TABLE `t_rankings`
  MODIFY `rnk_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=253;
--
-- AUTO_INCREMENT pour la table `t_standings`
--
ALTER TABLE `t_standings`
  MODIFY `std_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_matchPlayers`
--
ALTER TABLE `t_matchPlayers`
  ADD CONSTRAINT `FK_C6F8050A1177583C` FOREIGN KEY (`mpl_matchId`) REFERENCES `t_matches` (`mat_id`),
  ADD CONSTRAINT `FK_C6F8050AB2FF9061` FOREIGN KEY (`mpl_playerId`) REFERENCES `t_players` (`plr_id`);

--
-- Contraintes pour la table `t_notes`
--
ALTER TABLE `t_notes`
  ADD CONSTRAINT `FK_BFAAC0F5AE03366D` FOREIGN KEY (`not_evaluatorId`) REFERENCES `t_users` (`usr_id`),
  ADD CONSTRAINT `FK_BFAAC0F5CC16B380` FOREIGN KEY (`not_playerId`) REFERENCES `t_players` (`plr_id`);

--
-- Contraintes pour la table `t_rankings`
--
ALTER TABLE `t_rankings`
  ADD CONSTRAINT `FK_49BCB9BC11925612` FOREIGN KEY (`rnk_standingId`) REFERENCES `t_standings` (`std_id`),
  ADD CONSTRAINT `FK_49BCB9BCD22F1658` FOREIGN KEY (`rnk_playerId`) REFERENCES `t_players` (`plr_id`);

--
-- Contraintes pour la table `t_users`
--
ALTER TABLE `t_users`
  ADD CONSTRAINT `FK_AA32C390186EDC39` FOREIGN KEY (`usr_playerId`) REFERENCES `t_players` (`plr_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
