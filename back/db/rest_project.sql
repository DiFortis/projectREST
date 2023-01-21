-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Sty 2023, 12:37
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `rest_project`
--
CREATE DATABASE IF NOT EXISTS `rest_project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rest_project`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `beverages`
--

CREATE TABLE `beverages` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `ingredients` varchar(256) NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `beverages`
--

INSERT INTO `beverages` (`id`, `name`, `ingredients`, `is_available`) VALUES
(1, 'Cola', 'Water, sugar, Sulphuric acid', 0),
(2, 'Sparkling Water', 'Water, CO2, Sulphuric acid', 1),
(3, 'Sprite', 'Water, CO2, TEST', 1),
(4, 'Fanta', 'Water, CO2', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(2, 'test1', '$2y$10$asVo0qwNSXdjhe8fZcM8Me28KyS5M7oiakjkjCteXTRMfGePKjG0a', '2020-10-03 00:52:19'),
(3, 'testOlek', '$2y$10$fcN2LkOGxk3Ythbv6OMQEuSqZKM6ijwu9GgKgLiwbg.stQ/LlncGC', '2023-01-11 13:31:00'),
(4, 'testFortis', '$2y$10$Gk.fpzoSnDXvprOQ1W3yOucSNkueSIZXcu3w8tzAp2hDeyJm56MS2', '2023-01-15 17:06:08');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `beverages`
--
ALTER TABLE `beverages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `beverages`
--
ALTER TABLE `beverages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
