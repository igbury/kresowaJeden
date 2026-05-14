-- phpMyAdmin SQL Dump – przygotowany do importu na Railway MySQL
-- Zmiany: DROP TABLE IF EXISTS, wyłączenie FK checks, bezpieczna kolejność tabel

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Usuwanie tabel w bezpiecznej kolejności (najpierw zależne)
-- --------------------------------------------------------

DROP TABLE IF EXISTS `menu_alergeny`;
DROP TABLE IF EXISTS `oceny`;
DROP TABLE IF EXISTS `pozycje_zamowienia`;
DROP TABLE IF EXISTS `rezerwacje`;
DROP TABLE IF EXISTS `zamowienia`;
DROP TABLE IF EXISTS `menu`;
DROP TABLE IF EXISTS `alergeny`;
DROP TABLE IF EXISTS `klienci`;
DROP TABLE IF EXISTS `pracownicy`;
DROP TABLE IF EXISTS `stoliki`;

-- --------------------------------------------------------
-- Tabela: alergeny
-- --------------------------------------------------------

CREATE TABLE `alergeny` (
  `id` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `alergeny` (`id`, `nazwa`) VALUES
(1, 'Gluten'),
(2, 'Laktoza'),
(3, 'Jaja'),
(4, 'Orzechy'),
(5, 'Soja'),
(6, 'Seler'),
(7, 'Gorczyca'),
(8, 'Ryby'),
(9, 'Sezam'),
(10, 'Dwutlenek siarki');

ALTER TABLE `alergeny`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `alergeny`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- --------------------------------------------------------
-- Tabela: klienci
-- --------------------------------------------------------

CREATE TABLE `klienci` (
  `idKlienta` int(11) NOT NULL,
  `imie` text NOT NULL,
  `haslo` text NOT NULL,
  `email` text NOT NULL,
  `nr_telefonu` varchar(20) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `klienci`
  ADD PRIMARY KEY (`idKlienta`);

ALTER TABLE `klienci`
  MODIFY `idKlienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

-- --------------------------------------------------------
-- Tabela: menu
-- --------------------------------------------------------

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nazwaPotrawy` text NOT NULL,
  `opis` text NOT NULL,
  `cena` float NOT NULL,
  `dostepne` tinyint(1) NOT NULL,
  `typ` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menu` (`id`, `nazwaPotrawy`, `opis`, `cena`, `dostepne`, `typ`) VALUES
(1, 'TRADYCYJNA ZALEWAJKA ZAGŁĘBIOWSKA', 'Regionalna zupa na bazie zakwasu / żuru z ziemniakami i wędzonką', 18, 1, 'zupa'),
(2, 'ROSÓŁ NA 3 MIĘSACH', 'Aromatyczny rosół z makaronem, długo gotowany (drób, wołowina)', 18, 1, 'zupa'),
(3, 'ZUPA POMIDOROWA', 'Z makaronem typu świderki', 18, 1, 'zupa'),
(4, 'FRYTKI', '', 12, 1, 'dodatek'),
(5, 'KLUSKI ŚLĄSKIE', '', 9, 1, 'dodatek'),
(6, 'SURÓWKA', '', 8, 1, 'dodatek'),
(7, 'SCHABOWY „ZŁOTY KLASYK"', 'Soczysty schabowy, smażony na swojskim smalcu, podany z chrupiącymi frytkami i zasmażaną kapustą', 0, 1, 'danie_glowne'),
(8, 'TAGLIATELLE VERDE „ZIELONE WSTĘGI"', 'Grube wstęgi makaronu w aromatycznym pesto z pietruszki, nutą czosnku, białego wina, ziołami i soczystym kurczakiem', 0, 1, 'danie_glowne'),
(9, 'CHRUPIĄCE PLACKI Z KRESOWEJ', 'Złociste placki ziemniaczane podane z kwaśną śmietaną', 0, 1, 'danie_glowne'),
(10, 'ZŁOTY CAMEMBERT I FRYTKI', 'Panierowany ser camembert, smażony na złoto, podany z konfiturą żurawinową', 0, 1, 'danie_glowne'),
(11, 'GRECKA „ATENY W KRESOWEJ"', 'Śródziemnomorski klasyk — chrupiące warzywa, czarne oliwki, oliwa, ser feta', 0, 1, 'salatka'),
(12, 'HALLOUMI „SŁONECZNA WYSPA"', 'Ser halloumi, sałata (mix), granat, oliwki, ogórek, słonecznik, winegret', 0, 1, 'salatka'),
(13, 'GRECKA „ATENY W KRESOWEJ" (dzieci)', 'Śródziemnomorski klasyk — chrupiące warzywa, czarne oliwki, oliwa, ser feta', 0, 1, 'dzieciece'),
(14, 'HALLOUMI „SŁONECZNA WYSPA" (dzieci)', 'Ser halloumi, sałata (mix), granat, oliwki, ogórek, słonecznik, winegret', 0, 1, 'dzieciece');

ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

-- --------------------------------------------------------
-- Tabela: pracownicy
-- --------------------------------------------------------

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `imie` text NOT NULL,
  `pensja` float NOT NULL,
  `stanowisko` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `pracownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- --------------------------------------------------------
-- Tabela: stoliki
-- --------------------------------------------------------

CREATE TABLE `stoliki` (
  `id` int(11) NOT NULL,
  `numerStolika` int(11) NOT NULL,
  `zarezerwowany` tinyint(1) NOT NULL,
  `liczbaMiejsc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `stoliki` (`id`, `numerStolika`, `zarezerwowany`, `liczbaMiejsc`) VALUES
(1, 1, 1, 4),
(2, 2, 0, 2),
(3, 3, 1, 4),
(4, 4, 0, 6),
(5, 5, 1, 4),
(6, 6, 0, 2),
(7, 7, 0, 8);

ALTER TABLE `stoliki`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `stoliki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

-- --------------------------------------------------------
-- Tabela: zamowienia
-- --------------------------------------------------------

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `idKlienta` int(11) NOT NULL,
  `dataZamowienia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_zamowienia_klienci` (`idKlienta`);

ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

-- --------------------------------------------------------
-- Tabela: menu_alergeny
-- --------------------------------------------------------

CREATE TABLE `menu_alergeny` (
  `idPotrawy` int(11) NOT NULL,
  `idAlergenu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menu_alergeny` (`idPotrawy`, `idAlergenu`) VALUES
(1, 1),(1, 2),(2, 1),(2, 3),(3, 1),(4, 1),(5, 1),(5, 3),
(7, 1),(7, 3),(8, 1),(8, 5),(9, 2),(9, 3),(10, 2),(10, 1),(11, 2),(12, 2);

ALTER TABLE `menu_alergeny`
  ADD KEY `fk_menualer_menu` (`idPotrawy`),
  ADD KEY `fk_menualer_alergeny` (`idAlergenu`);

-- --------------------------------------------------------
-- Tabela: oceny
-- --------------------------------------------------------

CREATE TABLE `oceny` (
  `id` int(11) NOT NULL,
  `idKlienta` int(11) NOT NULL,
  `idPotrawy` int(11) NOT NULL,
  `ocena` int(11) NOT NULL,
  `komentarz` text NOT NULL,
  `dataOceny` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `oceny`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_oceny_klienci` (`idKlienta`),
  ADD KEY `fk_oceny_menu` (`idPotrawy`);

ALTER TABLE `oceny`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

-- --------------------------------------------------------
-- Tabela: pozycje_zamowienia
-- --------------------------------------------------------

CREATE TABLE `pozycje_zamowienia` (
  `id` int(11) NOT NULL,
  `idZamowienia` int(11) NOT NULL,
  `idPotrawy` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `pozycje_zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_poz_zamowienia` (`idZamowienia`),
  ADD KEY `fk_poz_menu` (`idPotrawy`);

ALTER TABLE `pozycje_zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

-- --------------------------------------------------------
-- Tabela: rezerwacje
-- --------------------------------------------------------

CREATE TABLE `rezerwacje` (
  `id` int(11) NOT NULL,
  `idKlienta` int(11) NOT NULL,
  `liczbaGosci` int(11) NOT NULL,
  `dataRezerwacji` datetime NOT NULL,
  `numerStolika` int(11) DEFAULT NULL,
  `zlozenieRezerwacji` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rezerwacje_klienci` (`idKlienta`);

ALTER TABLE `rezerwacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- --------------------------------------------------------
-- Klucze obce (na końcu, gdy wszystkie tabele już istnieją)
-- --------------------------------------------------------

ALTER TABLE `menu_alergeny`
  ADD CONSTRAINT `fk_menualer_alergeny` FOREIGN KEY (`idAlergenu`) REFERENCES `alergeny` (`id`),
  ADD CONSTRAINT `fk_menualer_menu` FOREIGN KEY (`idPotrawy`) REFERENCES `menu` (`id`);

ALTER TABLE `oceny`
  ADD CONSTRAINT `fk_oceny_klienci` FOREIGN KEY (`idKlienta`) REFERENCES `klienci` (`idKlienta`),
  ADD CONSTRAINT `fk_oceny_menu` FOREIGN KEY (`idPotrawy`) REFERENCES `menu` (`id`);

ALTER TABLE `pozycje_zamowienia`
  ADD CONSTRAINT `fk_poz_menu` FOREIGN KEY (`idPotrawy`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `fk_poz_zamowienia` FOREIGN KEY (`idZamowienia`) REFERENCES `zamowienia` (`id`);

ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `fk_rezerwacje_klienci` FOREIGN KEY (`idKlienta`) REFERENCES `klienci` (`idKlienta`);

ALTER TABLE `zamowienia`
  ADD CONSTRAINT `fk_zamowienia_klienci` FOREIGN KEY (`idKlienta`) REFERENCES `klienci` (`idKlienta`);

-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;