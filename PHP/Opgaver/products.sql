-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 05. 09 2021 kl. 20:15:10
-- Serverversion: 10.4.16-MariaDB
-- PHP-version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v3cms`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products`
--

CREATE TABLE `products` (
  `PID` int(11) NOT NULL,
  `PName` varchar(50) NOT NULL,
  `PStars` tinyint(4) NOT NULL,
  `PDesc` varchar(4096) NOT NULL,
  `PStiff` tinyint(4) NOT NULL,
  `PSupp` varchar(1024) NOT NULL,
  `PPrice` mediumint(9) NOT NULL,
  `PPic` varchar(1024) DEFAULT NULL,
  `PStock` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Data dump for tabellen `products`
--

INSERT INTO `products` (`PID`, `PName`, `PStars`, `PDesc`, `PStiff`, `PSupp`, `PPrice`, `PPic`, `PStock`) VALUES
(1, 'Edea Chorus', 4, 'Edea har kombineret letvægts design og den nyeste teknologi ved produktionen af Chorus, som er et trin op fra Overture og udviklet til et højere niveau.<br>\r\nNår du begynder på dine dobbeltspring er Chorus den helt rigtige støvle for dig.<br>\r\nHvis du ofte deltager i konkurrencer, kan Chorus hjælpe dig med at tage det næste skridt op på podiet.<br>\r\nEdea Chorus er 100% håndlavet italiensk design. Sålen er lavet af glasfiber og nylon, som giver dig en lettere kraftoverførsel fra fod til is, og som sikrer god stabilitet.', 70, 'Dobbeltspring', 1825, 'chorus-edea-skates.jpg', 100),
(2, 'Edea Concerto', 5, 'Concerto er udviklet til skøjteløb på højt niveau. Edea har brugt sin erfaring og knowhow til at producere en støvle, der kombinerer moderne teknologi med det traditionelle udseende.<br>\r\nConcertos ekstra styrke betyder, at den ofte bruges af mandlige skøjteløbere eller af parløbere, hvor de høje spring kræver ekstra understøttelse og styrke i støvlen.<br>\r\nEdea Concerto er 100% håndlavet italiensk design. Den dobbelte sål giver ekstra stødabsorbering og hjælper til at passe på dine led.\r\n', 85, 'Triplespring Quadspring', 2675, 'concerto-edea-skates.jpg concerto-black-edea-skates.jpg concerto-lingua-edea-skates.jpg', 100),
(3, 'Edea Ice-Fly', 5, 'Ice Fly er den letteste kunstskøjtestøvle på markedet i et ultra moderne design. Støvlens fleksibilitet giver mulighed for ekstra ynde og elegance til enhver performance.<br>\r\nMed en øget hældning på forsiden af hælen, forkortes reaktionstiden, fordi foden allerede er i den korrekte position. Dette giver kunstskøjteløbere mere flydende bevægelser i indløbet og forberedelserne til spring.<br>\r\nEdea Ice-Fly er 100% håndlavet italiensk design. Den dobbelte sål giver ekstra stødabsorbering og hjælper til at passe på dine led.\r\n', 90, 'Triplespring Quadspring', 3400, 'ice-fly-edea-skates.jpg ice-fly-black-edea-skates.jpg ice-fly-lingua-edea-skates.jpg ice-fly-swarovski-edea-skates.jpg', 100),
(4, 'Edea Overture', 3, 'Overture er en kombination af let design og Edea teknologi. Det er den mest solgte Edea støvle. Støvlen har stor støtte og fleksibilitet for kunstskøjteløbere, der arbejder på deres grundløb, enkeltspring og axel.<br>\r\nOverture er baseret på vores teknologisk viden om kunstskøjteløb på højt niveau og er baseret på vores passion for kunstskøjteløb.<br>\r\nEdea Overture er 100% håndlavet italiensk design. Støvlen er letvægtsdesign, som sikrer god responsivitet. Den giver en god fornemmelse for isen, som gør det lettere at udvikle det grundlæggende skøjteløb.\r\n', 48, 'Enkeltspring Axel', 1175, 'overture-edea-skates.jpg overture-black-edea-skates.jpg overture-lingua-edea-skates.jpg', 100),
(5, 'Edea Piano', 6, 'Kunstskøjteløbere forsøger altid at flytte grænserne, og med den nyeste teknologi er det nu blevet endnu lettere.<br>\r\nVores dygtige teknikere har med feedback fra verdens bedste skøjteløbere og med brug af den allernyeste teknologi skabt en helt unik ny støvle, Piano.<br>\r\nEdea Piano er 100% håndlavet italiensk design. Vores første støvle, der giver ekstra stabilitet, kraft og bevægelse med det dobbelte antichok system og revolutionære design.<br>\r\n', 95, 'Triplespring Quadspring', 4500, 'piano-edea-skates.jpg piano-black-edea-skates.jpg piano-collare-edea-skates.jpg piano-lingua-edea-skates.jpg piano-swarovski-edea-skates.jpg piano-tacco-laterale-edea-skates.jpg', 100),
(6, 'Edea Flamenco Ice', 6, 'Flamenco Ice er fremstillet med henblik på den ynde og elegance, der kendetegner dansesporten.<br>\r\nVed hjælp af Edeas mangeårige erfaring har vi lavet en støvle, som givere dansere fuld kontrol over deres skær og ekstra fleksibilitet med den lave støvle.<br>\r\nDen unikke indersål giver bedre føling med isen og stabilitet.', 70, 'Alle-danseniveauer', 2500, NULL, 20);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`PID`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `products`
--
ALTER TABLE `products`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
