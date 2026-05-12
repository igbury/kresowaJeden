-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 09, 2026 at 08:03 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kresowajeden`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `alergeny`
--

CREATE TABLE `alergeny` (
  `id` int(11) NOT NULL,
  `nazwa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `idKlienta` int(11) NOT NULL,
  `imie` VARCHAR(255) NOT NULL,
  `haslo` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `nr_telefonu` varchar(20) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `klienci`
--

INSERT INTO `klienci` (`idKlienta`, `imie`, `haslo`, `email`, `nr_telefonu`, `isAdmin`) VALUES
(6, '1', '$2y$10$bOwCAo5TC/.6D8uO1wfgw.R0NeoYEQsr1CzzenIUgB15CbY3gHHIu', 'B@op.pl', '123456789', 0),
(7, 'a', '$2y$10$54RrkJ45lyL3JNWh3ak3hed15qJUUOxlbsYYLqeTw9sbBFZl5vaoe', 'a@op.pl', '123456789', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nazwaPotrawy` text NOT NULL,
  `opis` text NOT NULL,
  `cena` DECIMAL(10,2) NOT NULL,
  `dostepne` tinyint(1) NOT NULL,
  `typ` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nazwaPotrawy`, `opis`, `cena`, `dostepne`, `typ`) VALUES
(1, 'TRADYCYJNA ZALEWAJKA ZAGŁĘBIOWSKA', 'Regionalna zupa na bazie zakwasu / żuru z ziemniakami i wędzonką', 18, 1, 'zupa'),
(2, 'ROSÓŁ NA 3 MIĘSACH', 'Aromatyczny rosół z makaronem, długo gotowany (drób, wołowina)', 18, 1, 'zupa'),
(3, 'ZUPA POMIDOROWA', 'Z makaronem typu świderki', 18, 1, 'zupa'),
(4, 'FRYTKI', '', 12, 1, 'dodatek'),
(5, 'KLUSKI ŚLĄSKIE', '', 9, 1, 'dodatek'),
(6, 'SURÓWKA', '', 8, 1, 'dodatek'),
(7, 'SCHABOWY „ZŁOTY KLASYK”', 'Soczysty schabowy, smażony na swojskim smalcu, podany z chrupiącymi frytkami i zasmażaną kapustą', 0, 1, 'danie_glowne'),
(8, 'TAGLIATELLE VERDE „ZIELONE WSTĘGI”', 'Grube wstęgi makaronu w aromatycznym pesto z pietruszki, nutą czosnku, białego wina, ziołami i soczystym kurczakiem', 0, 1, 'danie_glowne'),
(9, 'CHRUPIĄCE PLACKI Z KRESOWEJ', 'Złociste placki ziemniaczane podane z kwaśną śmietaną', 0, 1, 'danie_glowne'),
(10, 'ZŁOTY CAMEMBERT I FRYTKI', 'Panierowany ser camembert, smażony na złoto, podany z konfiturą żurawinową', 0, 1, 'danie_glowne'),
(11, 'GRECKA „ATENY W KRESOWEJ”', 'Śródziemnomorski klasyk — chrupiące warzywa, czarne oliwki, oliwa, ser feta', 0, 1, 'salatka'),
(12, 'HALLOUMI „SŁONECZNA WYSPA”', 'Ser halloumi, sałata (mix), granat, oliwki, ogórek, słonecznik, winegret', 0, 1, 'salatka'),
(13, 'GRECKA „ATENY W KRESOWEJ” (dzieci)', 'Śródziemnomorski klasyk — chrupiące warzywa, czarne oliwki, oliwa, ser feta', 0, 1, 'dzieciece'),
(14, 'HALLOUMI „SŁONECZNA WYSPA” (dzieci)', 'Ser halloumi, sałata (mix), granat, oliwki, ogórek, słonecznik, winegret', 0, 1, 'dzieciece');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `menu_alergeny`
--

CREATE TABLE `menu_alergeny` (
  `idPotrawy` int(11) NOT NULL,
  `idAlergenu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `id` int(11) NOT NULL,
  `idKlienta` int(11) NOT NULL,
  `idPotrawy` int(11) NOT NULL,
  `ocena` int(11) NOT NULL,
  `komentarz` text NOT NULL,
  `dataOceny` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pozycje_zamowienia`
--

CREATE TABLE `pozycje_zamowienia` (
  `id` int(11) NOT NULL,
  `idZamowienia` int(11) NOT NULL,
  `idPotrawy` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id` int(11) NOT NULL,
  `imie` VARCHAR(255) NOT NULL,
  `pensja` float NOT NULL,
  `stanowisko` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje`
--

CREATE TABLE `rezerwacje` (
  `id` int(11) NOT NULL,
  `idKlienta` int(11) NOT NULL,
  `liczbaGosci` int(11) NOT NULL,
  `dataRezerwacji` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stoliki`
--

CREATE TABLE `stoliki` (
  `id` int(11) NOT NULL,
  `numerStolika` text NOT NULL,
  `zarezerwowany` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `idKlienta` int(11) NOT NULL,
  `dataZamowienia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `alergeny`
--
ALTER TABLE `alergeny`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`idKlienta`);

--
-- Indeksy dla tabeli `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `menu_alergeny`
--
ALTER TABLE `menu_alergeny`
  ADD KEY `fk_menualer_menu` (`idPotrawy`),
  ADD KEY `fk_menualer_alergeny` (`idAlergenu`);

--
-- Indeksy dla tabeli `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_oceny_klienci` (`idKlienta`),
  ADD KEY `fk_oceny_menu` (`idPotrawy`);

--
-- Indeksy dla tabeli `pozycje_zamowienia`
--
ALTER TABLE `pozycje_zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_poz_zamowienia` (`idZamowienia`),
  ADD KEY `fk_poz_menu` (`idPotrawy`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rezerwacje_klienci` (`idKlienta`);

--
-- Indeksy dla tabeli `stoliki`
--
ALTER TABLE `stoliki`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_zamowienia_klienci` (`idKlienta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alergeny`
--
ALTER TABLE `alergeny`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `idKlienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pozycje_zamowienia`
--
ALTER TABLE `pozycje_zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stoliki`
--
ALTER TABLE `stoliki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_alergeny`
--
ALTER TABLE `menu_alergeny`
  ADD CONSTRAINT `fk_menualer_alergeny` FOREIGN KEY (`idAlergenu`) REFERENCES `alergeny` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_menualer_menu` FOREIGN KEY (`idPotrawy`) REFERENCES `menu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `oceny`
--
ALTER TABLE `oceny`
  ADD CONSTRAINT `fk_oceny_klienci` FOREIGN KEY (`idKlienta`) REFERENCES `klienci` (`idKlienta`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_oceny_menu` FOREIGN KEY (`idPotrawy`) REFERENCES `menu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pozycje_zamowienia`
--
ALTER TABLE `pozycje_zamowienia`
  ADD CONSTRAINT `fk_poz_menu` FOREIGN KEY (`idPotrawy`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_poz_zamowienia` FOREIGN KEY (`idZamowienia`) REFERENCES `zamowienia` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `fk_rezerwacje_klienci` FOREIGN KEY (`idKlienta`) REFERENCES `klienci` (`idKlienta`) ON DELETE CASCADE;

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `fk_zamowienia_klienci` FOREIGN KEY (`idKlienta`) REFERENCES `klienci` (`idKlienta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
