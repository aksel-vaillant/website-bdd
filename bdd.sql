-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : Dim 23 jan. 2022 à 21:13
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `idAddress` int(11) NOT NULL,
  `countryCode` varchar(2) DEFAULT NULL,
  `cityAddress` varchar(20) DEFAULT NULL,
  `cityCode` varchar(20) DEFAULT NULL,
  `streetAddress` varchar(50) DEFAULT NULL,
  `numAddress` varchar(20) DEFAULT NULL,
  `phoneAddress` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`idAddress`, `countryCode`, `cityAddress`, `cityCode`, `streetAddress`, `numAddress`, `phoneAddress`) VALUES
(1, 'FR', 'Le Mans', '72000', 'boulevard Charles Nicolle', '16', '0636958475'),
(2, 'FR', 'La Daguenière', '49800', 'rue de Villeneuve', '5', '0231429876'),
(3, 'FR', 'Plérin', '22190', 'avenue Henri Barbusse', '12', '0636958475'),
(4, 'FR', 'Perdu', '65987', 'rue du paradis', '7', '0626314212'),
(5, 'FR', 'Perdu', '65987', 'rue du paradis', '8', '0626314212');

-- --------------------------------------------------------

--
-- Structure de la table `card`
--

CREATE TABLE `card` (
  `idCard` int(11) NOT NULL,
  `codeClient` varchar(50) DEFAULT NULL,
  `idMembership` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `card`
--

INSERT INTO `card` (`idCard`, `codeClient`, `idMembership`) VALUES
(1, '17-SPR-0001', 1),
(2, '17-SPR-0002', 1),
(3, '17-SPR-0003', 1),
(4, '22-SPR-0004', 4);

-- --------------------------------------------------------

--
-- Structure de la table `cartepoint`
--

CREATE TABLE `cartepoint` (
  `idCard` int(11) NOT NULL,
  `idPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cartepoint`
--

INSERT INTO `cartepoint` (`idCard`, `idPoints`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `codeclient` varchar(50) NOT NULL,
  `nameClient` varchar(20) DEFAULT NULL,
  `mailClient` varchar(50) DEFAULT NULL,
  `facebook` varchar(20) DEFAULT NULL,
  `instagram` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`codeclient`, `nameClient`, `mailClient`, `facebook`, `instagram`) VALUES
('17-SPR-0001', 'Jean Michelle Moulin', 'jeanmi_300@yahoo.fr', 'JM Moulin', 'jmm20'),
('17-SPR-0002', 'Didier Raoul', 'didiR@gmail.com', 'Didier R', 'didi20'),
('17-SPR-0003', 'Le Batard Clément', 'rasp@hotmail.fr', 'raaa', 'rasp49'),
('22-SPR-0004', 'Aksel Vaillant ', 'aksouvaillanthappy@gmail.com', 'Aksel Vaillant ', 'aksel-vaillant');

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

CREATE TABLE `command` (
  `idCommand` varchar(20) NOT NULL,
  `dateOrder` date DEFAULT NULL,
  `noteOrder` varchar(50) DEFAULT NULL,
  `delivry` date DEFAULT NULL,
  `codeClient` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `command`
--

INSERT INTO `command` (`idCommand`, `dateOrder`, `noteOrder`, `delivry`, `codeClient`) VALUES
('21012022-CMD-C0001', '2022-01-21', 'Ceci est un description', NULL, '17-SPR-0001'),
('23012022-CMD-C0002', NULL, '', NULL, '22-SPR-0004');

-- --------------------------------------------------------

--
-- Structure de la table `compose`
--

CREATE TABLE `compose` (
  `idCommand` varchar(20) NOT NULL,
  `idItem` int(11) NOT NULL,
  `qtyItem` int(11) DEFAULT NULL,
  `puItem` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `compose`
--

INSERT INTO `compose` (`idCommand`, `idItem`, `qtyItem`, `puItem`) VALUES
('21012022-CMD-C0001', 1, 3, '12.00'),
('21012022-CMD-C0001', 4, 1, '45.00'),
('23012022-CMD-C0002', 1, 2, '10.00');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `numFacture` int(11) NOT NULL,
  `dateFacture` date DEFAULT NULL,
  `idCommand` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `habite`
--

CREATE TABLE `habite` (
  `codeClient` varchar(50) NOT NULL,
  `idAddress` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `habite`
--

INSERT INTO `habite` (`codeClient`, `idAddress`) VALUES
('17-SPR-0001', 1),
('17-SPR-0002', 2),
('17-SPR-0003', 1),
('22-SPR-0004', 5);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `idItem` int(11) NOT NULL,
  `nameItem` varchar(40) DEFAULT NULL,
  `descItem` varchar(255) DEFAULT NULL,
  `puItemRef` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`idItem`, `nameItem`, `descItem`, `puItemRef`) VALUES
(1, 'Codalie Duo Levre Main', '', '13.00'),
(2, 'Nuxe Lait Corps', '', '18.00'),
(3, 'Nuxe set Voyage', '', '29.00'),
(4, 'Crème anti-rides BIO LA PROVENCALE', '', '49.00'),
(5, 'Crème de nuit anti-âge bio N.A.E', '', '45.00'),
(24, 'bhibi', '', '5.69');

-- --------------------------------------------------------

--
-- Structure de la table `itemstatus`
--

CREATE TABLE `itemstatus` (
  `idStatutItem` int(11) NOT NULL,
  `typeStatusItem` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `itemstatus`
--

INSERT INTO `itemstatus` (`idStatutItem`, `typeStatusItem`) VALUES
(1, 'in stock'),
(2, 'available'),
(3, 'not available'),
(4, 'out of stock'),
(5, 'free gift'),
(6, 'packed'),
(7, 'dispatched'),
(8, 'arrived'),
(9, 'delivred'),
(10, 'other');

-- --------------------------------------------------------

--
-- Structure de la table `linkitem`
--

CREATE TABLE `linkitem` (
  `dateStatut` date NOT NULL,
  `idItem` int(11) NOT NULL,
  `idStatutItem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `linkitem`
--

INSERT INTO `linkitem` (`dateStatut`, `idItem`, `idStatutItem`) VALUES
('2022-01-21', 1, 1),
('2022-01-21', 4, 2),
('2022-01-21', 23, 1),
('2022-01-21', 24, 1);

-- --------------------------------------------------------

--
-- Structure de la table `linkorder`
--

CREATE TABLE `linkorder` (
  `dateStatut` date NOT NULL,
  `idStatut` int(11) NOT NULL,
  `idCommand` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `linkorder`
--

INSERT INTO `linkorder` (`dateStatut`, `idStatut`, `idCommand`) VALUES
('2022-01-21', 1, '21012022-CMD-C0001'),
('2022-01-23', 1, '23012022-CMD-C0002');

-- --------------------------------------------------------

--
-- Structure de la table `membership`
--

CREATE TABLE `membership` (
  `idMembership` int(11) NOT NULL,
  `nameMembership` varchar(20) DEFAULT NULL,
  `maxPoint` decimal(5,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membership`
--

INSERT INTO `membership` (`idMembership`, `nameMembership`, `maxPoint`) VALUES
(1, 'Silver', '400'),
(2, 'Gold', '1000'),
(3, 'Platinium', '2000'),
(4, 'Ultimate', '10000');

-- --------------------------------------------------------

--
-- Structure de la table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `idStatut` int(11) NOT NULL,
  `typeStatut` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `orderstatus`
--

INSERT INTO `orderstatus` (`idStatut`, `typeStatut`) VALUES
(1, 'To buy'),
(2, 'Bought'),
(3, 'Packed'),
(4, 'Shipped'),
(5, 'Arrived'),
(6, 'Delivered'),
(7, 'Done');

-- --------------------------------------------------------

--
-- Structure de la table `payement`
--

CREATE TABLE `payement` (
  `idPayement` int(11) NOT NULL,
  `typePayement` varchar(20) DEFAULT NULL,
  `datePayement` date DEFAULT NULL,
  `amountPayement` decimal(7,2) DEFAULT NULL,
  `idAdvancementPayement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `payer`
--

CREATE TABLE `payer` (
  `numFacture` int(11) NOT NULL,
  `idPayement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `points`
--

CREATE TABLE `points` (
  `idPoints` int(11) NOT NULL,
  `numPoint` int(11) DEFAULT NULL,
  `experyPoint` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `points`
--

INSERT INTO `points` (`idPoints`, `numPoint`, `experyPoint`) VALUES
(1, 300, '2022-01-25'),
(2, 500, '2022-01-31'),
(3, 5000, '2022-07-13'),
(4, 500, '2022-01-30'),
(5, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `idStock` int(11) NOT NULL,
  `qtyDispo` int(11) DEFAULT NULL,
  `idItem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`idStock`, `qtyDispo`, `idItem`) VALUES
(1, 45, 1),
(2, 74, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`idAddress`);

--
-- Index pour la table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`idCard`),
  ADD KEY `codeClient` (`codeClient`),
  ADD KEY `idMembership` (`idMembership`);

--
-- Index pour la table `cartepoint`
--
ALTER TABLE `cartepoint`
  ADD PRIMARY KEY (`idCard`,`idPoints`),
  ADD KEY `idCard` (`idCard`),
  ADD KEY `idPoints` (`idPoints`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`codeclient`);

--
-- Index pour la table `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`idCommand`),
  ADD KEY `codeClient` (`codeClient`);

--
-- Index pour la table `compose`
--
ALTER TABLE `compose`
  ADD PRIMARY KEY (`idCommand`,`idItem`),
  ADD KEY `idItem` (`idItem`),
  ADD KEY `idCommand` (`idCommand`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`numFacture`),
  ADD KEY `idCommand` (`idCommand`);

--
-- Index pour la table `habite`
--
ALTER TABLE `habite`
  ADD PRIMARY KEY (`codeClient`,`idAddress`),
  ADD KEY `idAddress` (`idAddress`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`idItem`);

--
-- Index pour la table `itemstatus`
--
ALTER TABLE `itemstatus`
  ADD PRIMARY KEY (`idStatutItem`);

--
-- Index pour la table `linkitem`
--
ALTER TABLE `linkitem`
  ADD PRIMARY KEY (`idItem`,`idStatutItem`),
  ADD KEY `FK_idItem` (`idItem`),
  ADD KEY `FK_idStatutItem` (`idStatutItem`);

--
-- Index pour la table `linkorder`
--
ALTER TABLE `linkorder`
  ADD PRIMARY KEY (`idStatut`,`idCommand`),
  ADD KEY `FK_idCommand` (`idStatut`),
  ADD KEY `idCommand` (`idCommand`);

--
-- Index pour la table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`idMembership`);

--
-- Index pour la table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`idStatut`);

--
-- Index pour la table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`idPayement`),
  ADD KEY `idAdvancementPayement` (`idAdvancementPayement`);

--
-- Index pour la table `payer`
--
ALTER TABLE `payer`
  ADD PRIMARY KEY (`numFacture`,`idPayement`),
  ADD KEY `idPayement` (`idPayement`);

--
-- Index pour la table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`idPoints`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idStock`),
  ADD KEY `idItem` (`idItem`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `idAddress` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `card`
--
ALTER TABLE `card`
  MODIFY `idCard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `numFacture` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `idItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `itemstatus`
--
ALTER TABLE `itemstatus`
  MODIFY `idStatutItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `membership`
--
ALTER TABLE `membership`
  MODIFY `idMembership` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `orderstatus`
--
ALTER TABLE `orderstatus`
  MODIFY `idStatut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `payement`
--
ALTER TABLE `payement`
  MODIFY `idPayement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `points`
--
ALTER TABLE `points`
  MODIFY `idPoints` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `idStock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `card_ibfk_1` FOREIGN KEY (`codeClient`) REFERENCES `clients` (`codeclient`),
  ADD CONSTRAINT `card_ibfk_2` FOREIGN KEY (`idMembership`) REFERENCES `membership` (`idMembership`);

--
-- Contraintes pour la table `cartepoint`
--
ALTER TABLE `cartepoint`
  ADD CONSTRAINT `cartepoint_ibfk_1` FOREIGN KEY (`idCard`) REFERENCES `card` (`idCard`),
  ADD CONSTRAINT `cartepoint_ibfk_2` FOREIGN KEY (`idPoints`) REFERENCES `points` (`idPoints`);

--
-- Contraintes pour la table `command`
--
ALTER TABLE `command`
  ADD CONSTRAINT `command_ibfk_1` FOREIGN KEY (`codeClient`) REFERENCES `clients` (`codeclient`);

--
-- Contraintes pour la table `compose`
--
ALTER TABLE `compose`
  ADD CONSTRAINT `compose_ibfk_2` FOREIGN KEY (`idItem`) REFERENCES `item` (`idItem`),
  ADD CONSTRAINT `compose_ibfk_3` FOREIGN KEY (`idCommand`) REFERENCES `command` (`idCommand`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`idCommand`) REFERENCES `command` (`idCommand`);

--
-- Contraintes pour la table `habite`
--
ALTER TABLE `habite`
  ADD CONSTRAINT `habite_ibfk_1` FOREIGN KEY (`codeClient`) REFERENCES `clients` (`codeclient`),
  ADD CONSTRAINT `habite_ibfk_2` FOREIGN KEY (`idAddress`) REFERENCES `address` (`idAddress`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
