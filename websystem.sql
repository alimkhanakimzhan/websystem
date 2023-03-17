-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2023 at 04:47 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city`) VALUES
(1, 'Астана'),
(2, 'Алматы'),
(3, 'Актау'),
(4, 'Атырау'),
(5, 'Шымкент'),
(6, 'Жезказган'),
(7, 'Караганды'),
(8, 'Тараз'),
(9, 'Темиртау');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `Name`) VALUES
(1, 'Управления'),
(2, 'Внешней политики'),
(3, 'Внутренней политики'),
(4, 'Кадровый');

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE `family` (
  `employee_ID` int(11) NOT NULL,
  `relative_ID` int(11) NOT NULL,
  `relationship_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`employee_ID`, `relative_ID`, `relationship_ID`) VALUES
(1, 101, 2),
(2, 102, 6),
(3, 103, 2),
(4, 104, 4),
(5, 105, 5),
(6, 106, 7),
(7, 107, 4),
(8, 108, 3),
(9, 109, 4),
(10, 110, 4),
(11, 111, 2),
(12, 112, 3),
(13, 113, 2),
(14, 114, 6),
(15, 115, 5),
(16, 116, 4),
(17, 117, 1),
(18, 118, 6),
(19, 119, 7),
(20, 120, 4),
(21, 121, 1),
(22, 122, 5),
(23, 123, 4),
(24, 124, 3),
(25, 125, 2),
(26, 126, 5),
(27, 127, 1),
(28, 128, 4),
(29, 129, 1),
(30, 130, 3),
(31, 131, 7),
(32, 132, 5),
(33, 133, 7),
(34, 134, 1),
(35, 135, 3),
(36, 136, 3),
(37, 137, 7),
(38, 138, 1),
(39, 139, 3),
(40, 140, 3),
(41, 141, 7),
(42, 142, 2),
(43, 143, 1),
(44, 144, 4),
(45, 145, 6),
(46, 146, 2),
(47, 147, 5),
(48, 148, 4),
(49, 149, 4),
(50, 150, 2),
(51, 151, 2),
(52, 152, 4),
(53, 153, 2),
(54, 154, 5),
(55, 155, 6),
(56, 156, 3),
(57, 157, 1),
(58, 158, 5),
(59, 159, 7),
(60, 160, 5),
(61, 161, 4),
(62, 162, 4),
(63, 163, 4),
(64, 164, 6),
(65, 165, 5),
(66, 166, 1),
(67, 167, 7),
(68, 168, 2),
(69, 169, 2),
(70, 170, 6),
(71, 171, 3),
(72, 172, 3),
(73, 173, 4),
(74, 174, 6),
(75, 175, 5),
(76, 176, 3),
(77, 177, 2),
(78, 178, 7),
(79, 179, 1),
(80, 180, 7),
(81, 181, 1),
(82, 182, 6),
(83, 183, 6),
(84, 184, 2),
(85, 185, 3),
(86, 186, 5),
(87, 187, 2),
(88, 188, 7),
(89, 189, 2),
(90, 190, 1),
(91, 191, 3),
(92, 192, 2),
(93, 193, 6),
(94, 194, 3),
(95, 195, 1),
(96, 196, 5),
(97, 197, 3),
(98, 198, 5),
(99, 199, 3),
(100, 200, 4),
(1, 106, 2);

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `gender` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `gender`) VALUES
(1, 'Мужской'),
(2, 'Женский');

-- --------------------------------------------------------

--
-- Table structure for table `history_of_position`
--

CREATE TABLE `history_of_position` (
  `id` int(11) NOT NULL,
  `person_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history_of_position`
--

INSERT INTO `history_of_position` (`id`, `person_ID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25),
(26, 26),
(27, 27),
(28, 28),
(29, 29),
(30, 30),
(31, 31),
(32, 32),
(33, 33),
(34, 34),
(35, 35),
(36, 36),
(37, 37),
(38, 38),
(39, 39),
(40, 40),
(41, 41),
(42, 42),
(43, 43),
(44, 44),
(45, 45),
(46, 46),
(47, 47),
(48, 48),
(49, 49),
(50, 50),
(51, 51),
(52, 52),
(53, 53),
(54, 54),
(55, 55),
(56, 56),
(57, 57),
(58, 58),
(59, 59),
(60, 60),
(61, 61),
(62, 62),
(63, 63),
(64, 64),
(65, 65),
(66, 66),
(67, 67),
(68, 68),
(69, 69),
(70, 70),
(71, 71),
(72, 72),
(73, 73),
(74, 74),
(75, 75),
(76, 76),
(77, 77),
(78, 78),
(79, 79),
(80, 80),
(81, 81),
(82, 82),
(83, 83),
(84, 84),
(85, 85),
(86, 86),
(87, 87),
(88, 88),
(89, 89),
(90, 90),
(91, 91),
(92, 92),
(93, 93),
(94, 94),
(95, 95),
(96, 96),
(97, 97),
(98, 98),
(99, 99),
(100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `list_of_property`
--

CREATE TABLE `list_of_property` (
  `id` int(11) NOT NULL,
  `person_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `list_of_property`
--

INSERT INTO `list_of_property` (`id`, `person_ID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25),
(26, 26),
(27, 27),
(28, 28),
(29, 29),
(30, 30),
(31, 31),
(32, 32),
(33, 33),
(34, 34),
(35, 35),
(36, 36),
(37, 37),
(38, 38),
(39, 39),
(40, 40),
(41, 41),
(42, 42),
(43, 43),
(44, 44),
(45, 45),
(46, 46),
(47, 47),
(48, 48),
(49, 49),
(50, 50),
(51, 51),
(52, 52),
(53, 53),
(54, 54),
(55, 55),
(56, 56),
(57, 57),
(58, 58),
(59, 59),
(60, 60),
(61, 61),
(62, 62),
(63, 63),
(64, 64),
(65, 65),
(66, 66),
(67, 67),
(68, 68),
(69, 69),
(70, 70),
(71, 71),
(72, 72),
(73, 73),
(74, 74),
(75, 75),
(76, 76),
(77, 77),
(78, 78),
(79, 79),
(80, 80),
(81, 81),
(82, 82),
(83, 83),
(84, 84),
(85, 85),
(86, 86),
(87, 87),
(88, 88),
(89, 89),
(90, 90),
(91, 91),
(92, 92),
(93, 93),
(94, 94),
(95, 95),
(96, 96),
(97, 97),
(98, 98),
(99, 99),
(100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE `nationality` (
  `id` int(11) NOT NULL,
  `nationality` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nationality`
--

INSERT INTO `nationality` (`id`, `nationality`) VALUES
(1, 'Казах');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `Name`) VALUES
(1, 'Агенство'),
(2, 'Акимат'),
(3, 'Министерство');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `IIN` varchar(32) NOT NULL,
  `FirstName` varchar(32) NOT NULL,
  `LastName` varchar(32) NOT NULL,
  `Patronymic` varchar(64) DEFAULT NULL,
  `Photo` varchar(128) DEFAULT NULL,
  `Gender` int(11) NOT NULL,
  `BirthDate` date NOT NULL,
  `PlaceOfBirth` int(11) NOT NULL,
  `Nationality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `IIN`, `FirstName`, `LastName`, `Patronymic`, `Photo`, `Gender`, `BirthDate`, `PlaceOfBirth`, `Nationality`) VALUES
(1, '995197337647', 'Marney', 'Millmoe', 'Kathleen', NULL, 2, '1966-10-11', 3, 1),
(2, '621877148446', 'Janenna', 'Warwick', 'Durand', NULL, 2, '1969-09-24', 7, 1),
(3, '573288610894', 'Berky', 'Sorrel', 'Ricki', NULL, 1, '1962-01-08', 1, 1),
(4, '883663022541', 'Farrell', 'Baguley', 'Wendi', NULL, 1, '1969-04-29', 1, 1),
(5, '932182867712', 'Christophorus', 'Thews', 'Othilia', NULL, 1, '1969-03-20', 8, 1),
(6, '952388285554', 'Hali', 'Carreyette', 'Hal', NULL, 1, '1968-01-02', 7, 1),
(7, '516022271137', 'Davie', 'Teesdale', 'Hewe', NULL, 2, '1961-01-03', 5, 1),
(8, '721066484678', 'Hank', 'Poultney', 'Maryl', NULL, 1, '1961-05-26', 4, 1),
(9, '540704663537', 'Nanice', 'Easbie', 'Cointon', NULL, 2, '1962-09-01', 5, 1),
(10, '796900260258', 'Kacey', 'Capoun', 'Bibbie', NULL, 2, '1969-12-12', 9, 1),
(11, '451054367500', 'Henrieta', 'Hutfield', 'Glynn', NULL, 2, '1968-09-16', 7, 1),
(12, '249790482766', 'Karee', 'Wardingley', 'Dawna', NULL, 1, '1962-12-19', 8, 1),
(13, '319308867332', 'Erin', 'Aldie', 'Elga', NULL, 2, '1967-07-03', 9, 1),
(14, '514464528897', 'Cleo', 'Eliez', 'Holmes', NULL, 2, '1965-11-09', 8, 1),
(15, '744392761267', 'Julianna', 'Keppie', 'Cathee', NULL, 2, '1963-09-20', 5, 1),
(16, '415434357845', 'Rowan', 'Smithson', 'Nelia', NULL, 2, '1964-05-31', 5, 1),
(17, '375488419198', 'Stillmann', 'Zannetti', 'Theresina', NULL, 2, '1963-02-08', 2, 1),
(18, '212871165578', 'Norry', 'Boon', 'Sue', NULL, 1, '1960-12-08', 2, 1),
(19, '809258353235', 'Ricardo', 'Dincey', 'Jed', NULL, 2, '1961-06-19', 9, 1),
(20, '517856746162', 'Beret', 'Djurisic', 'Dennet', NULL, 1, '1960-04-02', 1, 1),
(21, '596409789202', 'Charles', 'Dreye', 'Ruperta', NULL, 1, '1968-04-29', 8, 1),
(22, '534810372005', 'Jared', 'Ashplant', 'Cynde', NULL, 1, '1962-12-01', 9, 1),
(23, '828071442914', 'Deirdre', 'Purtell', 'Sonny', NULL, 1, '1964-05-19', 2, 1),
(24, '647080019910', 'Camel', 'Heinsen', 'Minor', NULL, 1, '1962-03-02', 6, 1),
(25, '781919153306', 'Pincas', 'Bette', 'Shayna', NULL, 2, '1963-01-20', 7, 1),
(26, '201486258160', 'Shay', 'Mayall', 'Marylynne', NULL, 2, '1968-05-27', 4, 1),
(27, '432320321099', 'Bobby', 'Inold', 'Clarisse', NULL, 1, '1967-02-24', 5, 1),
(28, '301156615575', 'Anastasie', 'Labrom', 'Emerson', NULL, 1, '1968-12-07', 3, 1),
(29, '670927949934', 'Waverly', 'Gregorace', 'Annmarie', NULL, 1, '1965-08-24', 8, 1),
(30, '377341496937', 'Grantham', 'Glaze', 'Parker', NULL, 2, '1970-01-05', 2, 1),
(31, '553462304795', 'Jessa', 'Burgess', 'Aubree', NULL, 1, '1967-07-30', 1, 1),
(32, '135403698070', 'Elwin', 'McGibbon', 'Irv', NULL, 2, '1966-03-31', 8, 1),
(33, '312963337499', 'Esmaria', 'Charity', 'Raynor', NULL, 1, '1961-03-19', 3, 1),
(34, '279628002550', 'Derril', 'Elms', 'Dulciana', NULL, 2, '1969-10-08', 6, 1),
(35, '944606924595', 'Trenna', 'Saffill', 'Sigfrid', NULL, 2, '1965-03-14', 8, 1),
(36, '890408851280', 'Kara-lynn', 'Avard', 'Errick', NULL, 1, '1969-02-15', 1, 1),
(37, '609857679634', 'Rhianon', 'Folkes', 'Kayla', NULL, 2, '1964-04-13', 7, 1),
(38, '127941471059', 'Kata', 'Blooman', 'Deb', NULL, 2, '1962-09-10', 6, 1),
(39, '122994647914', 'Zia', 'Bryer', 'Quintina', NULL, 2, '1960-04-09', 5, 1),
(40, '875697224962', 'Filippa', 'Medcraft', 'Saree', NULL, 2, '1963-07-13', 8, 1),
(41, '186391147545', 'Allina', 'Bolley', 'Malvin', NULL, 1, '1965-01-25', 3, 1),
(42, '821697416545', 'Raff', 'Bruce', 'Genvieve', NULL, 2, '1962-01-08', 4, 1),
(43, '154268559539', 'Gamaliel', 'Paulat', 'Shepperd', NULL, 2, '1962-09-24', 2, 1),
(44, '821824070329', 'Kissie', 'Leipold', 'Chester', NULL, 2, '1964-06-18', 9, 1),
(45, '624402432397', 'Helene', 'Towson', 'Caressa', NULL, 1, '1961-04-29', 7, 1),
(46, '780557047045', 'Jermaine', 'Stocks', 'Marlin', NULL, 2, '1962-08-08', 7, 1),
(47, '213804181848', 'Grazia', 'Pes', 'Jude', NULL, 1, '1960-06-02', 1, 1),
(48, '775536892954', 'Aggy', 'Westfalen', 'Zelda', NULL, 2, '1967-09-05', 5, 1),
(49, '989360752637', 'Carry', 'Ansell', 'Nye', NULL, 2, '1965-10-01', 7, 1),
(50, '936573138349', 'Jorey', 'Crosbie', 'Fredra', NULL, 1, '1960-05-05', 9, 1),
(51, '376475148803', 'Edin', 'Fishly', 'Coraline', NULL, 2, '1963-09-30', 1, 1),
(52, '540217397117', 'Ambros', 'Strutz', 'Ninette', NULL, 2, '1962-05-13', 3, 1),
(53, '276332862990', 'Buffy', 'Dahlberg', 'Freddi', NULL, 1, '1965-11-04', 3, 1),
(54, '898379546780', 'Myrvyn', 'Burle', 'Jo-anne', NULL, 1, '1967-07-15', 9, 1),
(55, '691120279857', 'Jessey', 'Cappineer', 'Daile', NULL, 1, '1961-05-19', 3, 1),
(56, '610662307185', 'Stanly', 'MacCrossan', 'Keely', NULL, 1, '1966-08-03', 9, 1),
(57, '852517807015', 'Darline', 'Roxby', 'Jillayne', NULL, 2, '1960-07-16', 8, 1),
(58, '326878746082', 'Lodovico', 'Strugnell', 'Sofie', NULL, 2, '1966-08-28', 5, 1),
(59, '236212328595', 'Lucy', 'Barkworth', 'Valentin', NULL, 2, '1965-09-14', 2, 1),
(60, '873107566482', 'Drusi', 'Dorot', 'Velvet', NULL, 2, '1962-06-30', 3, 1),
(61, '185681005130', 'Britta', 'Illingworth', 'Liane', NULL, 1, '1964-08-09', 1, 1),
(62, '691168774638', 'Abbe', 'Philot', 'Alicia', NULL, 2, '1964-01-08', 2, 1),
(63, '945150392630', 'Gretel', 'Pluvier', 'Storm', NULL, 2, '1960-05-18', 4, 1),
(64, '146143851740', 'Blancha', 'Clayfield', 'Helga', NULL, 1, '1962-05-05', 6, 1),
(65, '433115844227', 'Fee', 'Bark', 'Hetty', NULL, 2, '1968-01-30', 2, 1),
(66, '169498584964', 'Leila', 'Swinnerton', 'Magdalena', NULL, 1, '1962-03-21', 2, 1),
(67, '691638572970', 'Frederich', 'Dagger', 'Josefa', NULL, 2, '1968-12-05', 3, 1),
(68, '512903459962', 'Gradey', 'Ilyenko', 'Artair', NULL, 2, '1961-07-26', 7, 1),
(69, '193375174232', 'Clyve', 'Camidge', 'Marlo', NULL, 2, '1961-08-19', 9, 1),
(70, '602230292384', 'Lexy', 'Hearle', 'Fayth', NULL, 2, '1969-02-11', 2, 1),
(71, '901089185398', 'Renaldo', 'Bryden', 'Nert', NULL, 2, '1962-01-26', 1, 1),
(72, '655603512089', 'Silvia', 'Johanssen', 'Jerald', NULL, 1, '1963-06-10', 1, 1),
(73, '513415744624', 'Phillip', 'Goter', 'Anselm', NULL, 1, '1960-02-06', 3, 1),
(74, '882485719034', 'Nerissa', 'Cluley', 'Lamond', NULL, 1, '1964-07-31', 9, 1),
(75, '512722125927', 'Alecia', 'Denford', 'Ruben', NULL, 1, '1967-08-27', 8, 1),
(76, '998825570207', 'Klemens', 'Jasik', 'Florinda', NULL, 1, '1967-12-16', 4, 1),
(77, '403070208912', 'Claribel', 'Ghelarducci', 'Neall', NULL, 1, '1960-09-14', 6, 1),
(78, '201926559654', 'Gaile', 'Kinnett', 'Brandy', NULL, 2, '1966-10-22', 8, 1),
(79, '265383385195', 'Gibby', 'Bette', 'Iago', NULL, 2, '1960-07-17', 4, 1),
(80, '540748091524', 'Isidoro', 'Laddle', 'Giff', NULL, 2, '1968-08-22', 6, 1),
(81, '289070669208', 'Coleman', 'Shelborne', 'Sim', NULL, 1, '1969-04-16', 3, 1),
(82, '536805572269', 'Currey', 'Popelay', 'Sari', NULL, 1, '1964-06-28', 3, 1),
(83, '876592186874', 'Bobby', 'Caselli', 'Zared', NULL, 1, '1969-10-20', 5, 1),
(84, '150158907767', 'Julie', 'McVittie', 'Humfrid', NULL, 1, '1963-06-29', 3, 1),
(85, '814845318774', 'Simonne', 'Kingswoode', 'Lenee', NULL, 1, '1968-06-20', 7, 1),
(86, '661504401971', 'Marielle', 'Farrier', 'Nikoletta', NULL, 1, '1963-05-05', 3, 1),
(87, '771164199975', 'Ulla', 'Hurndall', 'Bert', NULL, 2, '1963-07-12', 2, 1),
(88, '608800868976', 'Erena', 'Form', 'Adrienne', NULL, 2, '1961-12-06', 2, 1),
(89, '978857317110', 'Alan', 'Colquite', 'Reiko', NULL, 2, '1966-03-15', 8, 1),
(90, '383622569406', 'Morey', 'Heintzsch', 'Nataline', NULL, 2, '1968-07-21', 8, 1),
(91, '442327955989', 'Cherie', 'Debenham', 'Curran', NULL, 1, '1961-09-21', 4, 1),
(92, '259152146741', 'Queenie', 'Jardine', 'Otes', NULL, 2, '1965-12-03', 8, 1),
(93, '455994504199', 'Arte', 'Beglin', 'Isa', NULL, 1, '1969-09-29', 4, 1),
(94, '127885288122', 'Tudor', 'Stiant', 'Geralda', NULL, 2, '1963-04-10', 3, 1),
(95, '600737035556', 'Der', 'Labes', 'Conant', NULL, 2, '1965-09-28', 8, 1),
(96, '211325739916', 'Windham', 'Kemell', 'Art', NULL, 2, '1961-03-03', 6, 1),
(97, '287104955105', 'Delmor', 'Balhatchet', 'Augustin', NULL, 2, '1966-09-09', 3, 1),
(98, '413386941515', 'Cristine', 'Janu', 'Luz', NULL, 1, '1967-05-03', 5, 1),
(99, '726417238645', 'Adrienne', 'Le Port', 'Donnell', NULL, 2, '1964-10-10', 9, 1),
(100, '453606627483', 'Paolina', 'Beasley', 'Ferrell', NULL, 1, '1965-10-09', 6, 1),
(101, '869925017301', 'Willem', 'Redmell', 'Belvia', NULL, 1, '1965-10-21', 6, 1),
(102, '252488030943', 'Elisabeth', 'Blazewicz', 'Christoforo', NULL, 1, '1968-05-07', 7, 1),
(103, '128375024162', 'Dinah', 'McGonnell', 'Harwell', NULL, 1, '1960-04-05', 6, 1),
(104, '496327368464', 'Reese', 'Bertot', 'Reuven', NULL, 1, '1965-05-15', 9, 1),
(105, '758663711637', 'Jeddy', 'Flavelle', 'Robinetta', NULL, 2, '1969-07-05', 5, 1),
(106, '532027344569', 'Tadd', 'Lepope', 'Gallagher', NULL, 1, '1969-09-22', 5, 1),
(107, '848303084277', 'Northrup', 'Ethelston', 'Munroe', NULL, 2, '1966-04-16', 4, 1),
(108, '920168173449', 'Heindrick', 'Miskin', 'Olwen', NULL, 1, '1966-06-10', 3, 1),
(109, '501016023427', 'Annice', 'Smout', 'Bale', NULL, 2, '1968-03-27', 3, 1),
(110, '725600525179', 'Adelina', 'Loftus', 'Laney', NULL, 2, '1961-02-28', 2, 1),
(111, '611205317597', 'Stacee', 'Webland', 'Wendeline', NULL, 2, '1962-06-02', 7, 1),
(112, '679975562761', 'Shirley', 'Ormond', 'Cynthia', NULL, 1, '1963-01-02', 6, 1),
(113, '558085821361', 'Erda', 'Elgy', 'Tobin', NULL, 1, '1963-04-28', 3, 1),
(114, '581922332602', 'Granville', 'Dudmesh', 'Anestassia', NULL, 2, '1964-01-20', 9, 1),
(115, '142993790211', 'Maurene', 'Stubbins', 'Jacquelyn', NULL, 1, '1960-12-14', 4, 1),
(116, '198311033257', 'Nerte', 'Hellikes', 'Henrie', NULL, 1, '1963-12-15', 7, 1),
(117, '604911877064', 'Sherwood', 'Courtliff', 'Vinnie', NULL, 2, '1966-02-07', 5, 1),
(118, '454540278396', 'Gil', 'Perkins', 'Ardyce', NULL, 2, '1968-08-01', 9, 1),
(119, '184563922502', 'Kristo', 'Grellis', 'Christoffer', NULL, 2, '1969-04-02', 3, 1),
(120, '117488116562', 'Timothee', 'Bain', 'Morgun', NULL, 1, '1966-11-28', 1, 1),
(121, '913684091904', 'Erroll', 'Peeke', 'Brew', NULL, 2, '1966-04-03', 7, 1),
(122, '459776528821', 'Frasco', 'Ghidoni', 'Ewan', NULL, 2, '1965-05-14', 8, 1),
(123, '175699652109', 'Errick', 'Beining', 'Innis', NULL, 2, '1965-08-22', 2, 1),
(124, '324579399893', 'Giuditta', 'Faux', 'Joyce', NULL, 2, '1961-05-25', 6, 1),
(125, '348149276818', 'Mickey', 'Osborne', 'Sonny', NULL, 1, '1966-06-18', 4, 1),
(126, '461522425376', 'Robena', 'Canlin', 'Joanna', NULL, 1, '1964-11-24', 7, 1),
(127, '896100905577', 'Kara', 'Snedker', 'Rhett', NULL, 2, '1968-05-09', 8, 1),
(128, '679710935355', 'Virginie', 'Stripp', 'Kalila', NULL, 1, '1962-12-06', 6, 1),
(129, '722232686066', 'Anstice', 'Iredell', 'Janice', NULL, 2, '1961-10-16', 3, 1),
(130, '873660558422', 'Deane', 'Stobbes', 'Scarlet', NULL, 2, '1963-02-16', 9, 1),
(131, '658701344254', 'Riki', 'McConnell', 'Romain', NULL, 2, '1965-06-26', 5, 1),
(132, '444611560886', 'Quentin', 'Preskett', 'Sena', NULL, 2, '1965-12-06', 4, 1),
(133, '630184987432', 'Valaree', 'Pembry', 'Judie', NULL, 1, '1963-02-12', 3, 1),
(134, '527300908921', 'Arley', 'Raiston', 'Miller', NULL, 1, '1962-09-30', 8, 1),
(135, '974198433944', 'Phoebe', 'Playford', 'Idaline', NULL, 2, '1961-03-01', 2, 1),
(136, '575527782931', 'Emory', 'Tivnan', 'Fernando', NULL, 2, '1964-07-22', 4, 1),
(137, '136507094179', 'Oran', 'Kighly', 'Adah', NULL, 2, '1961-02-13', 5, 1),
(138, '718094731652', 'Rick', 'Troake', 'Mari', NULL, 2, '1967-06-16', 1, 1),
(139, '376809779057', 'Tabbie', 'Hemshall', 'Stacie', NULL, 1, '1965-07-20', 9, 1),
(140, '849064792260', 'Glenda', 'Syers', 'Dorice', NULL, 2, '1969-12-20', 3, 1),
(141, '592292384935', 'Tyrus', 'Maleby', 'Hadlee', NULL, 2, '1960-04-26', 5, 1),
(142, '477022150686', 'Salmon', 'Luckwell', 'Claudio', NULL, 1, '1965-05-19', 6, 1),
(143, '140729283316', 'Lars', 'Ackery', 'Mariel', NULL, 2, '1962-05-11', 8, 1),
(144, '466402497785', 'Gretel', 'Pelcheur', 'Joannes', NULL, 1, '1962-01-24', 5, 1),
(145, '402318347448', 'Saul', 'Potkin', 'Dolph', NULL, 2, '1962-02-15', 9, 1),
(146, '399088149700', 'Derrek', 'Heindrich', 'Vitia', NULL, 1, '1968-10-14', 2, 1),
(147, '516268878954', 'Diahann', 'Pinxton', 'Brand', NULL, 1, '1960-06-06', 9, 1),
(148, '162136421093', 'Milly', 'Curtoys', 'Berty', NULL, 1, '1967-11-16', 8, 1),
(149, '200029211676', 'Alistair', 'Maidens', 'Merrili', NULL, 1, '1964-07-20', 9, 1),
(150, '227439295580', 'Erasmus', 'Gudgeon', 'Desmund', NULL, 2, '1965-09-28', 5, 1),
(151, '863966677308', 'Cleo', 'Moran', 'Skippie', NULL, 1, '1968-01-18', 9, 1),
(152, '856549853269', 'Prue', 'Pickburn', 'Clareta', NULL, 1, '1969-04-28', 1, 1),
(153, '947032817377', 'Olia', 'Finessy', 'Jamey', NULL, 1, '1967-06-14', 1, 1),
(154, '645570659534', 'Deb', 'Jozwiak', 'Averil', NULL, 1, '1965-02-12', 6, 1),
(155, '786360568103', 'Carlin', 'Resun', 'Lorelle', NULL, 1, '1960-08-05', 3, 1),
(156, '860662824789', 'Read', 'Silby', 'Cordell', NULL, 1, '1963-12-26', 1, 1),
(157, '118280896396', 'Hans', 'Everit', 'Lesli', NULL, 1, '1962-02-26', 8, 1),
(158, '295244686007', 'Othilia', 'Beakes', 'Ambrosius', NULL, 1, '1964-01-20', 1, 1),
(159, '513856537736', 'Dora', 'Blanpein', 'Kev', NULL, 2, '1962-05-23', 6, 1),
(160, '973015543387', 'Halli', 'Soanes', 'Joete', NULL, 2, '1963-11-15', 7, 1),
(161, '181799189966', 'Aloysia', 'Moult', 'Letty', NULL, 2, '1963-01-02', 5, 1),
(162, '580553810014', 'Marve', 'Sieur', 'Denyse', NULL, 1, '1969-12-07', 4, 1),
(163, '448521398125', 'Anett', 'Payton', 'Othelia', NULL, 2, '1966-09-23', 9, 1),
(164, '532509534581', 'Jaclin', 'Maffei', 'Carlen', NULL, 1, '1964-08-29', 8, 1),
(165, '331833048117', 'Cherey', 'Strangward', 'Lynnell', NULL, 1, '1964-09-13', 5, 1),
(166, '144836896784', 'Amabel', 'Coddrington', 'Avram', NULL, 1, '1966-06-18', 1, 1),
(167, '853062354666', 'Guenna', 'Kunert', 'Caprice', NULL, 1, '1966-02-27', 5, 1),
(168, '952098145394', 'Rochester', 'Hannah', 'Randolph', NULL, 2, '1962-03-25', 5, 1),
(169, '210615331377', 'Tandy', 'Baudesson', 'Maggie', NULL, 2, '1962-07-28', 3, 1),
(170, '506418241430', 'Killian', 'Hexum', 'Marget', NULL, 2, '1968-04-14', 1, 1),
(171, '783785526977', 'Lauren', 'Andreu', 'Whit', NULL, 1, '1964-01-15', 4, 1),
(172, '966563971194', 'Melisenda', 'Gerrell', 'Joey', NULL, 2, '1961-09-27', 4, 1),
(173, '313267873825', 'Berrie', 'Cohr', 'Angelika', NULL, 1, '1965-10-03', 5, 1),
(174, '486969754524', 'Rikki', 'Danser', 'Joelynn', NULL, 1, '1968-04-13', 7, 1),
(175, '969615394466', 'Nicolea', 'Borkin', 'Edd', NULL, 2, '1960-04-14', 6, 1),
(176, '371136021125', 'Madeleine', 'Davidovich', 'Gilbertine', NULL, 1, '1961-02-01', 7, 1),
(177, '554636395062', 'Eugenie', 'MacFie', 'Helenka', NULL, 1, '1960-02-01', 6, 1),
(178, '743116504494', 'Fan', 'Gierek', 'Kelcie', NULL, 1, '1964-12-09', 1, 1),
(179, '702230622364', 'Rhona', 'Abramamovh', 'Lynnea', NULL, 2, '1968-02-07', 5, 1),
(180, '320229582822', 'Wynnie', 'Swinnerton', 'Valaria', NULL, 1, '1963-05-09', 7, 1),
(181, '651377061752', 'Elladine', 'Jephcott', 'Hamish', NULL, 1, '1964-09-06', 1, 1),
(182, '993754747551', 'Cyrus', 'Ardling', 'Hobie', NULL, 2, '1968-08-09', 2, 1),
(183, '948953909936', 'Burgess', 'Denning', 'Anetta', NULL, 1, '1965-01-11', 1, 1),
(184, '166444379157', 'Ringo', 'Schuck', 'Eloisa', NULL, 1, '1966-07-26', 1, 1),
(185, '385189341384', 'Dagmar', 'Dolby', 'Moises', NULL, 2, '1963-03-21', 9, 1),
(186, '313221629327', 'Delilah', 'Baulk', 'Kory', NULL, 1, '1960-12-04', 5, 1),
(187, '378848621282', 'Xavier', 'Ghiraldi', 'Caye', NULL, 2, '1962-07-16', 2, 1),
(188, '988652498267', 'Kearney', 'Clemonts', 'Philippa', NULL, 1, '1965-07-04', 3, 1),
(189, '582857632806', 'Ranice', 'Goldine', 'Nell', NULL, 2, '1960-07-10', 8, 1),
(190, '202228438256', 'Celina', 'Ganiclef', 'Lorrie', NULL, 1, '1962-04-22', 7, 1),
(191, '235952879827', 'Karoline', 'Keningham', 'Verene', NULL, 1, '1968-07-21', 8, 1),
(192, '950270235098', 'Reina', 'Calender', 'Lincoln', NULL, 1, '1963-02-02', 3, 1),
(193, '196487362672', 'Perice', 'Bailes', 'Marchelle', NULL, 1, '1960-09-16', 7, 1),
(194, '101806134170', 'Hyman', 'Albers', 'Cornell', NULL, 1, '1967-10-31', 5, 1),
(195, '486059398961', 'Rodger', 'Behling', 'Chester', NULL, 1, '1967-07-11', 1, 1),
(196, '858371895385', 'Des', 'Seear', 'Alta', NULL, 2, '1965-09-10', 6, 1),
(197, '159657474679', 'Pauline', 'Younglove', 'Elena', NULL, 2, '1960-05-08', 6, 1),
(198, '566960511109', 'Gail', 'Fluin', 'Wade', NULL, 2, '1961-09-27', 1, 1),
(199, '274729520343', 'Florry', 'Beacham', 'Ashely', NULL, 1, '1962-06-13', 6, 1),
(200, '566752730043', 'Eugene', 'Avrahamy', 'Farica', NULL, 1, '1968-02-19', 8, 1),
(201, '201154541733', 'Etan', 'Dekeyser', 'Masha', NULL, 2, '1965-10-05', 4, 1),
(202, '445112434605', 'Quentin', 'Capewell', 'Fielding', NULL, 1, '1960-04-17', 2, 1),
(203, '200658538630', 'Mathian', 'Gisbey', 'Shadow', NULL, 2, '1964-10-04', 1, 1),
(204, '141152196464', 'Siusan', 'Yanyushkin', 'Sidonnie', NULL, 1, '1968-09-10', 7, 1),
(205, '490324794547', 'Leontine', 'Klimek', 'Alis', NULL, 1, '1966-08-21', 1, 1),
(206, '524151879986', 'Rhianna', 'Lockyear', 'Guthrey', NULL, 2, '1969-12-13', 9, 1),
(207, '878043895474', 'Mommy', 'Drewe', 'Hildegarde', NULL, 2, '1962-03-15', 4, 1),
(208, '527248947476', 'Wakefield', 'Elflain', 'Bill', NULL, 2, '1969-05-26', 9, 1),
(209, '892174389327', 'Janella', 'Compton', 'Kata', NULL, 2, '1960-10-20', 3, 1),
(210, '815190873950', 'Freeman', 'Langelaan', 'Corrine', NULL, 2, '1963-03-11', 9, 1),
(211, '575648143690', 'Bartlett', 'Argrave', 'Aube', NULL, 1, '1966-01-12', 9, 1),
(212, '571916838220', 'Paulette', 'Chamberlain', 'Nessa', NULL, 2, '1967-02-27', 4, 1),
(213, '411088883216', 'Riki', 'Whisson', 'Stacia', NULL, 2, '1960-02-24', 7, 1),
(214, '856013423229', 'Ty', 'McGlynn', 'Cam', NULL, 2, '1961-02-21', 3, 1),
(215, '989204077254', 'Bernardo', 'Leguay', 'Penni', NULL, 1, '1969-01-24', 6, 1),
(216, '302838979024', 'Libbey', 'Awcoate', 'Sherilyn', NULL, 2, '1967-02-09', 8, 1),
(217, '228816410686', 'Raffarty', 'Egiloff', 'Sharai', NULL, 1, '1963-06-28', 3, 1),
(218, '590486980087', 'Murry', 'Duran', 'Lorain', NULL, 1, '1960-08-17', 2, 1),
(219, '785859437645', 'Saidee', 'Culwen', 'Leta', NULL, 1, '1968-02-02', 4, 1),
(220, '230506605188', 'Felike', 'Dick', 'Cassey', NULL, 2, '1967-07-23', 9, 1),
(221, '317246871276', 'Ivette', 'Trickey', 'Brear', NULL, 2, '1963-08-15', 2, 1),
(222, '794558544609', 'Lauretta', 'Basler', 'Syd', NULL, 2, '1968-03-22', 6, 1),
(223, '225660921902', 'Dani', 'Gantley', 'Guntar', NULL, 1, '1964-12-10', 4, 1),
(224, '565320588953', 'Melessa', 'Gulston', 'Vikki', NULL, 1, '1966-04-20', 6, 1),
(225, '743664980377', 'Helga', 'Claypoole', 'Opalina', NULL, 2, '1964-06-10', 7, 1),
(226, '489411719652', 'Ernaline', 'Gjerde', 'Arlinda', NULL, 1, '1962-08-17', 2, 1),
(227, '150895660810', 'Bren', 'Kilroy', 'Cad', NULL, 2, '1964-07-23', 8, 1),
(228, '338893644742', 'Merlina', 'McCracken', 'Neila', NULL, 1, '1961-07-09', 5, 1),
(229, '665583549323', 'Constance', 'Phibb', 'Vicky', NULL, 2, '1962-01-17', 9, 1),
(230, '710923595762', 'Garret', 'Pedwell', 'Eldredge', NULL, 1, '1965-04-25', 2, 1),
(231, '835524228735', 'Bobbi', 'Lamborn', 'Gardner', NULL, 1, '1960-03-15', 1, 1),
(232, '131975631104', 'Cathrine', 'Donohoe', 'Kipp', NULL, 2, '1962-08-08', 9, 1),
(233, '813086918519', 'Jeannie', 'Marthen', 'Lenka', NULL, 1, '1964-07-26', 8, 1),
(234, '416675968656', 'Abramo', 'Semonin', 'Milka', NULL, 2, '1968-05-11', 3, 1),
(235, '344765135975', 'Danell', 'Bytheway', 'Tabatha', NULL, 2, '1969-04-07', 3, 1),
(236, '694900741178', 'Noni', 'Graben', 'Lexy', NULL, 2, '1965-07-10', 2, 1),
(237, '965399093955', 'Elsa', 'Wheatcroft', 'Alain', NULL, 2, '1962-09-13', 4, 1),
(238, '219288976089', 'Igor', 'Samples', 'Dolli', NULL, 2, '1968-03-06', 5, 1),
(239, '275582785745', 'Dorene', 'Levensky', 'Car', NULL, 2, '1965-11-23', 1, 1),
(240, '737776434187', 'Beverlee', 'Vasic', 'Vonnie', NULL, 1, '1961-08-12', 8, 1),
(241, '939455634343', 'Flossie', 'Amys', 'Ignacius', NULL, 1, '1965-09-24', 4, 1),
(242, '998864247160', 'Mathilda', 'Santus', 'Averil', NULL, 1, '1967-09-02', 8, 1),
(243, '531614929996', 'Glenine', 'Oldfield', 'Randolph', NULL, 1, '1963-01-28', 3, 1),
(244, '877909588379', 'Ethelyn', 'Comini', 'Abbott', NULL, 2, '1960-08-31', 6, 1),
(245, '672145732885', 'Alvira', 'Reilinger', 'Alysia', NULL, 1, '1961-04-01', 3, 1),
(246, '187962584503', 'Dasi', 'Dionisi', 'Adelheid', NULL, 1, '1965-01-25', 7, 1),
(247, '681171178892', 'Cris', 'Turmell', 'Brina', NULL, 1, '1967-03-16', 8, 1),
(248, '788679928855', 'Juanita', 'Codd', 'Ellerey', NULL, 1, '1962-01-04', 4, 1),
(249, '567440813148', 'Iago', 'Fulbrook', 'Berton', NULL, 2, '1965-01-16', 3, 1),
(250, '952148036150', 'Osmund', 'Ledwich', 'Barry', NULL, 1, '1961-03-16', 8, 1),
(251, '476170653325', 'Linc', 'Slafford', 'Hestia', NULL, 1, '1967-11-17', 3, 1),
(252, '295060748051', 'Tiffany', 'Harnwell', 'Katee', NULL, 1, '1961-02-17', 6, 1),
(253, '865010949753', 'Andromache', 'Rodwell', 'Lettie', NULL, 2, '1963-11-22', 9, 1),
(254, '235475181961', 'Cleo', 'Barr', 'Marcy', NULL, 1, '1965-09-04', 8, 1),
(255, '645276414324', 'Hildagard', 'O\'Dea', 'Helga', NULL, 1, '1966-05-13', 7, 1),
(256, '743711827450', 'Karly', 'Buncher', 'Allene', NULL, 2, '1963-10-26', 9, 1),
(257, '387258264939', 'Angy', 'Tunder', 'Nickey', NULL, 2, '1966-04-20', 2, 1),
(258, '381712360861', 'Magnum', 'Mapplebeck', 'Maureene', NULL, 2, '1964-11-05', 2, 1),
(259, '429676112867', 'Claiborne', 'Spehr', 'Melvyn', NULL, 2, '1968-12-07', 7, 1),
(260, '415512040173', 'Adams', 'Loughlin', 'Kerby', NULL, 2, '1968-12-24', 5, 1),
(261, '375577507456', 'Barnabe', 'Bowkley', 'Johna', NULL, 1, '1964-02-27', 9, 1),
(262, '621463747657', 'Joelle', 'Greves', 'Chandler', NULL, 1, '1968-12-15', 8, 1),
(263, '524647576929', 'Tori', 'Urrey', 'Kelli', NULL, 2, '1968-02-18', 9, 1),
(264, '166021844827', 'Gusta', 'Augustin', 'Galvan', NULL, 2, '1963-09-03', 2, 1),
(265, '517682032892', 'Carce', 'Dandison', 'Renelle', NULL, 1, '1961-08-18', 6, 1),
(266, '982711495111', 'Lottie', 'Woltman', 'Rikki', NULL, 1, '1961-03-07', 8, 1),
(267, '610880202333', 'Cammy', 'Petrillo', 'Mayne', NULL, 1, '1963-02-23', 9, 1),
(268, '683861837787', 'Erskine', 'Cestard', 'Sindee', NULL, 1, '1967-02-10', 1, 1),
(269, '659505742406', 'Starlin', 'Dudin', 'Paula', NULL, 2, '1968-03-18', 9, 1),
(270, '561424606910', 'Odetta', 'Harvard', 'Yvon', NULL, 2, '1966-05-13', 1, 1),
(271, '154654874800', 'Lynda', 'Gable', 'Elden', NULL, 2, '1967-05-08', 3, 1),
(272, '274262064461', 'Heddi', 'Manning', 'Becky', NULL, 2, '1969-10-25', 2, 1),
(273, '298454787468', 'Minette', 'Hold', 'Lezlie', NULL, 2, '1965-03-17', 7, 1),
(274, '895890217940', 'Clayborne', 'Benedick', 'Lemmy', NULL, 2, '1965-04-09', 6, 1),
(275, '823292892907', 'Winnie', 'Salery', 'Carey', NULL, 1, '1968-05-15', 3, 1),
(276, '976518873619', 'Abbot', 'Corness', 'Reeta', NULL, 1, '1966-12-07', 7, 1),
(277, '209770670674', 'Torey', 'Marcq', 'Conn', NULL, 2, '1965-01-10', 5, 1),
(278, '817953865650', 'Christalle', 'Marriage', 'Matthieu', NULL, 2, '1968-04-12', 5, 1),
(279, '642000180358', 'Wyndham', 'Seal', 'Vale', NULL, 1, '1963-09-09', 2, 1),
(280, '896207332115', 'Byrle', 'Pedrollo', 'Henri', NULL, 1, '1960-11-08', 1, 1),
(281, '725025369962', 'Nalani', 'Earley', 'Henryetta', NULL, 2, '1963-10-20', 2, 1),
(282, '126199485310', 'Bradney', 'Attle', 'Ly', NULL, 1, '1966-04-26', 7, 1),
(283, '153030310762', 'Allie', 'Birley', 'Saunderson', NULL, 2, '1963-10-21', 1, 1),
(284, '341755879418', 'Colette', 'Marunchak', 'Donaugh', NULL, 2, '1962-02-12', 2, 1),
(285, '516035116394', 'Corrina', 'Ridolfi', 'Gillie', NULL, 1, '1969-05-31', 8, 1),
(286, '356637189406', 'Kassey', 'Clace', 'Ange', NULL, 2, '1962-10-05', 4, 1),
(287, '525622638078', 'Belle', 'Vandrill', 'Abba', NULL, 2, '1965-06-22', 2, 1),
(288, '141808442006', 'Kiley', 'Rashleigh', 'Phillis', NULL, 2, '1963-12-12', 4, 1),
(289, '414365631338', 'Cassius', 'Hemphrey', 'Gardener', NULL, 1, '1960-03-14', 6, 1),
(290, '450598505167', 'Maryjo', 'Gladtbach', 'Rourke', NULL, 1, '1966-10-09', 6, 1),
(291, '510009128907', 'Devi', 'Murty', 'Guy', NULL, 1, '1966-11-03', 7, 1),
(292, '951696433481', 'Nikaniki', 'Rock', 'Vikki', NULL, 1, '1965-07-03', 2, 1),
(293, '223499240311', 'Alexa', 'Dalrymple', 'Orlan', NULL, 2, '1968-08-11', 9, 1),
(294, '264519577385', 'Valma', 'Mynett', 'Kristina', NULL, 1, '1961-06-22', 6, 1),
(295, '755696469014', 'Inga', 'Girardey', 'Thorpe', NULL, 2, '1960-06-13', 8, 1),
(296, '994527686676', 'Lea', 'Howison', 'Giordano', NULL, 1, '1964-12-07', 6, 1),
(297, '879021884804', 'Dal', 'Madine', 'Sarene', NULL, 1, '1969-10-30', 7, 1),
(298, '601365869392', 'Farlee', 'Kensall', 'Asher', NULL, 1, '1967-07-14', 6, 1),
(299, '904092341484', 'Afton', 'Rucklesse', 'Rozella', NULL, 2, '1965-05-01', 5, 1),
(300, '419330338928', 'Ginni', 'Esplin', 'Grace', NULL, 1, '1961-02-18', 5, 1),
(301, '919146207987', 'Jeremiah', 'Ghelerdini', 'Pansie', NULL, 1, '1967-05-19', 3, 1),
(302, '917034835170', 'Siobhan', 'Isaacson', 'Alanna', NULL, 2, '1964-08-01', 1, 1),
(303, '928785879892', 'Merl', 'McClory', 'Dillon', NULL, 1, '1969-11-29', 1, 1),
(304, '156415590023', 'Juieta', 'Kyles', 'Bord', NULL, 1, '1963-12-02', 4, 1),
(305, '298819255219', 'Hollis', 'Hasley', 'Adelle', NULL, 2, '1967-04-12', 9, 1),
(306, '389114869201', 'Bertie', 'Taggart', 'Roberta', NULL, 2, '1967-03-04', 3, 1),
(307, '597467828080', 'Ezri', 'Wyborn', 'Benjy', NULL, 1, '1965-06-28', 6, 1),
(308, '161367718039', 'Joletta', 'Brane', 'Lilas', NULL, 2, '1966-08-22', 1, 1),
(309, '630088067676', 'Armando', 'Eringey', 'Halimeda', NULL, 1, '1963-09-03', 8, 1),
(310, '445206312329', 'Melva', 'Pinhorn', 'Prentice', NULL, 2, '1961-10-11', 4, 1),
(311, '723850933623', 'Vinita', 'Boniface', 'Farly', NULL, 1, '1960-04-12', 8, 1),
(312, '549778664601', 'Dulcine', 'Tollmache', 'Lorens', NULL, 1, '1968-06-08', 8, 1),
(313, '670431851766', 'Yule', 'MacGray', 'Lilith', NULL, 1, '1965-06-08', 8, 1),
(314, '269926002316', 'Kelcie', 'Boshell', 'Gasparo', NULL, 1, '1963-10-01', 2, 1),
(315, '314843760841', 'Brook', 'Childers', 'Erica', NULL, 1, '1960-12-30', 7, 1),
(316, '756426070831', 'Orbadiah', 'Surgison', 'Benedetto', NULL, 2, '1966-05-09', 5, 1),
(317, '781291960680', 'Jere', 'Norcutt', 'Daryn', NULL, 2, '1965-10-19', 4, 1),
(318, '399765103561', 'Mabelle', 'McAllen', 'Carlota', NULL, 2, '1967-05-23', 2, 1),
(319, '933772090024', 'Norry', 'Eilhersen', 'Sinclair', NULL, 2, '1963-03-24', 6, 1),
(320, '369707897425', 'Jan', 'Foffano', 'Tallie', NULL, 1, '1963-04-19', 4, 1),
(321, '796671463729', 'Avrom', 'Minghella', 'Betta', NULL, 1, '1962-05-01', 6, 1),
(322, '475150154093', 'Eddy', 'Hauch', 'Karlotte', NULL, 1, '1968-08-22', 8, 1),
(323, '219749882686', 'Lauralee', 'Wallege', 'Melvin', NULL, 2, '1963-12-25', 7, 1),
(324, '312055771211', 'Kym', 'Ding', 'Eugen', NULL, 2, '1969-02-28', 8, 1),
(325, '351074235793', 'Felipe', 'Chadwell', 'Drusi', NULL, 1, '1961-03-27', 5, 1),
(326, '215199285660', 'Paten', 'Mosby', 'Elle', NULL, 2, '1968-11-01', 1, 1),
(327, '908511501361', 'Benedick', 'Maynell', 'Loise', NULL, 1, '1963-12-17', 2, 1),
(328, '796679334870', 'Gayler', 'Portriss', 'Roxanne', NULL, 2, '1964-05-26', 7, 1),
(329, '246255342580', 'Howey', 'Scardafield', 'Jillayne', NULL, 2, '1963-06-25', 7, 1),
(330, '689594738859', 'Adrian', 'Musterd', 'Katherina', NULL, 1, '1964-02-25', 1, 1),
(331, '135371808819', 'Traci', 'Pennetta', 'Sutherlan', NULL, 2, '1964-06-07', 7, 1),
(332, '546129949935', 'Electra', 'Wanless', 'Anastassia', NULL, 2, '1964-06-05', 6, 1),
(333, '358630697786', 'Gradeigh', 'Roubert', 'Page', NULL, 2, '1964-02-24', 4, 1),
(334, '726174329820', 'Lancelot', 'Lohrensen', 'Melina', NULL, 2, '1968-02-14', 5, 1),
(335, '950808830379', 'Horten', 'Tierny', 'Floyd', NULL, 1, '1965-01-08', 5, 1),
(336, '705809141254', 'Danit', 'Essex', 'Florie', NULL, 1, '1966-10-08', 1, 1),
(337, '327624242192', 'Candide', 'Feathers', 'Rubi', NULL, 2, '1966-04-11', 8, 1),
(338, '179678109736', 'Dieter', 'Szymanzyk', 'Philis', NULL, 1, '1961-08-22', 6, 1),
(339, '691101353115', 'Pat', 'Fannin', 'Agustin', NULL, 2, '1962-10-15', 4, 1),
(340, '542457826828', 'Noelle', 'Glencrash', 'Kennett', NULL, 2, '1966-01-10', 5, 1),
(341, '152840611504', 'Hamid', 'Epilet', 'Carla', NULL, 2, '1967-08-01', 6, 1),
(342, '207140075438', 'Enos', 'Pagan', 'Orlan', NULL, 1, '1960-06-22', 7, 1),
(343, '354539405116', 'Perry', 'Cundey', 'Gerhardt', NULL, 2, '1967-05-10', 4, 1),
(344, '595639757819', 'Ernst', 'Avramovitz', 'Juliette', NULL, 1, '1966-01-28', 1, 1),
(345, '311113389718', 'Christiane', 'Ridsdale', 'Rosalind', NULL, 1, '1965-05-31', 6, 1),
(346, '163210082336', 'Phillip', 'Fonzone', 'Arni', NULL, 2, '1963-12-07', 2, 1),
(347, '951103671464', 'Bari', 'Puckett', 'Mead', NULL, 2, '1968-08-11', 4, 1),
(348, '338508646554', 'Ingrim', 'Ference', 'Aryn', NULL, 1, '1967-09-20', 5, 1),
(349, '939025410018', 'Saree', 'Hanney', 'Carmel', NULL, 2, '1963-04-27', 9, 1),
(350, '228449432227', 'Nathanael', 'Olechnowicz', 'Darci', NULL, 1, '1968-03-14', 5, 1),
(351, '609906251879', 'Adda', 'Johnson', 'Alon', NULL, 1, '1966-09-01', 7, 1),
(352, '325628320530', 'Randie', 'Scoyles', 'Ody', NULL, 1, '1963-10-05', 2, 1),
(353, '919208653130', 'Arielle', 'Dockrell', 'Lanie', NULL, 2, '1968-03-25', 8, 1),
(354, '973934042448', 'Sile', 'Songest', 'Tore', NULL, 1, '1968-06-18', 4, 1),
(355, '252906528785', 'Gabriello', 'Cammocke', 'Pasquale', NULL, 1, '1968-11-25', 5, 1),
(356, '957613743863', 'Nonah', 'Jotcham', 'Fredi', NULL, 1, '1961-11-24', 5, 1),
(357, '774104792967', 'Issie', 'Farnworth', 'Lenka', NULL, 2, '1969-01-18', 7, 1),
(358, '724499720841', 'Jessamine', 'Shenfish', 'Anni', NULL, 2, '1961-05-20', 1, 1),
(359, '362036338603', 'Sher', 'Battelle', 'Norby', NULL, 2, '1961-12-12', 6, 1),
(360, '135127618061', 'Zuzana', 'Klaffs', 'Arabele', NULL, 1, '1960-06-03', 5, 1),
(361, '780703272681', 'Rubetta', 'Skinner', 'Colly', NULL, 2, '1969-03-08', 2, 1),
(362, '105713970978', 'Eveleen', 'Filov', 'Jody', NULL, 1, '1962-12-25', 9, 1),
(363, '208657582807', 'Iormina', 'Beeson', 'Corrina', NULL, 1, '1962-07-21', 9, 1),
(364, '556320913131', 'Elinor', 'Cradock', 'Boycie', NULL, 2, '1968-12-10', 5, 1),
(365, '115431252105', 'Antonella', 'Cantillon', 'Brita', NULL, 2, '1965-11-25', 8, 1),
(366, '136675435784', 'Kevina', 'Beauchamp', 'Prudi', NULL, 1, '1968-04-26', 2, 1),
(367, '562171945890', 'Marten', 'Bondesen', 'Norbert', NULL, 1, '1961-02-19', 9, 1),
(368, '768320668986', 'Dante', 'Fielding', 'Paula', NULL, 1, '1966-06-28', 3, 1),
(369, '708911983728', 'Weston', 'Ortsmann', 'Roz', NULL, 2, '1968-05-26', 3, 1),
(370, '100490116909', 'Oneida', 'Terris', 'Emery', NULL, 2, '1964-10-23', 2, 1),
(371, '885308747256', 'Yuri', 'Drohan', 'Mirilla', NULL, 1, '1967-12-16', 1, 1),
(372, '791823377070', 'Emery', 'Carlaw', 'Crysta', NULL, 1, '1967-07-20', 5, 1),
(373, '207771197399', 'Auberon', 'Maasze', 'Teressa', NULL, 1, '1961-06-02', 5, 1),
(374, '422593782472', 'Alexandra', 'Sizey', 'Hazlett', NULL, 2, '1969-02-05', 6, 1),
(375, '565614368133', 'George', 'Fellgett', 'Marcile', NULL, 2, '1968-10-03', 6, 1),
(376, '847477810876', 'Savina', 'Bevington', 'Danni', NULL, 1, '1963-12-07', 7, 1),
(377, '904428661996', 'Dode', 'Overland', 'Danell', NULL, 1, '1963-08-28', 8, 1),
(378, '147748289346', 'Sammy', 'de Cullip', 'Cly', NULL, 1, '1965-10-23', 5, 1),
(379, '321717993867', 'Brennen', 'Rein', 'Aida', NULL, 1, '1969-10-17', 8, 1),
(380, '259642977541', 'Bobbee', 'Bootman', 'Theressa', NULL, 2, '1966-08-10', 7, 1),
(381, '914651562733', 'Keri', 'Gallally', 'Chryste', NULL, 1, '1962-01-09', 8, 1),
(382, '659462729729', 'Kessia', 'Ivanyutin', 'Mel', NULL, 2, '1962-05-19', 9, 1),
(383, '613138320581', 'Arne', 'Hackford', 'Jacques', NULL, 2, '1969-07-02', 3, 1),
(384, '446877924092', 'Clementia', 'Meaden', 'Sibilla', NULL, 2, '1966-07-05', 2, 1),
(385, '278058815309', 'Oliy', 'Prendergast', 'Ailene', NULL, 1, '1964-05-09', 8, 1),
(386, '596788063990', 'Petrina', 'Longcake', 'Sula', NULL, 1, '1963-03-15', 8, 1),
(387, '923580418402', 'Briana', 'Giuroni', 'Tom', NULL, 2, '1968-05-31', 7, 1),
(388, '769005830111', 'Stewart', 'Shewen', 'Willy', NULL, 2, '1969-04-17', 1, 1),
(389, '361808122172', 'Sissy', 'Mickan', 'Hubert', NULL, 1, '1969-05-15', 4, 1),
(390, '588858194432', 'Juliann', 'Maryon', 'Padgett', NULL, 2, '1967-11-25', 2, 1),
(391, '770504692649', 'Clarke', 'Dorricott', 'William', NULL, 2, '1965-01-03', 4, 1),
(392, '178938147410', 'Westbrooke', 'Kermit', 'Conrad', NULL, 1, '1967-04-25', 4, 1),
(393, '948596017338', 'Melisa', 'Chatwin', 'Dalila', NULL, 1, '1960-10-27', 6, 1),
(394, '274477855749', 'Babb', 'McMillam', 'Chev', NULL, 1, '1968-04-26', 2, 1),
(395, '511861262559', 'Glynn', 'Sail', 'Janek', NULL, 1, '1964-11-17', 2, 1),
(396, '215121761080', 'Monika', 'Gilliland', 'Kara', NULL, 2, '1968-05-25', 4, 1),
(397, '617901220277', 'Revkah', 'Bruins', 'Enoch', NULL, 2, '1969-07-10', 2, 1),
(398, '976714227912', 'Marianne', 'Minthorpe', 'Lucky', NULL, 1, '1961-05-03', 1, 1),
(399, '416082250123', 'Sarena', 'Baldin', 'Trstram', NULL, 2, '1963-10-05', 4, 1),
(400, '296836722366', 'Hatty', 'Standrin', 'Tracie', NULL, 1, '1961-08-02', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `Name`) VALUES
(1, 'Министр'),
(2, 'Зам министр'),
(3, 'Аким'),
(4, 'Начальник управления'),
(5, 'Инспектор');

-- --------------------------------------------------------

--
-- Table structure for table `position_held`
--

CREATE TABLE `position_held` (
  `id` int(11) NOT NULL,
  `time_deploy_position` date NOT NULL,
  `time_end_position` date DEFAULT NULL,
  `position_ID` int(11) DEFAULT NULL,
  `department_ID` int(11) DEFAULT NULL,
  `organization_ID` int(11) DEFAULT NULL,
  `sector_ID` int(11) DEFAULT NULL,
  `history_of_position_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position_held`
--

INSERT INTO `position_held` (`id`, `time_deploy_position`, `time_end_position`, `position_ID`, `department_ID`, `organization_ID`, `sector_ID`, `history_of_position_ID`) VALUES
(1, '2010-04-10', '2006-08-23', 4, 1, 2, 2, 43),
(2, '2003-07-28', '2011-01-20', 1, 3, 1, 1, 98),
(3, '2009-07-26', '2009-05-01', 2, 1, 2, 4, 80),
(4, '2014-09-26', '2007-12-11', 3, 2, 2, 3, 72),
(5, '2008-12-28', '2008-06-25', 4, 2, 1, 1, 76),
(6, '2009-02-10', '2007-12-06', 2, 1, 1, 2, 57),
(7, '2010-03-30', '2007-01-22', 1, 2, 1, 1, 100),
(8, '2003-06-06', '2005-12-23', 3, 2, 2, 1, 99),
(9, '2005-02-25', '2012-12-07', 3, 4, 3, 1, 74),
(10, '2006-11-02', '2004-01-04', 1, 4, 2, 1, 31),
(11, '2007-08-28', '2003-09-25', 4, 3, 3, 1, 87),
(12, '2002-07-16', '2008-01-08', 2, 1, 3, 2, 100),
(13, '2014-10-22', '2003-04-07', 4, 3, 1, 2, 93),
(14, '2002-02-16', '2011-08-14', 5, 1, 2, 3, 53),
(15, '2013-02-09', '2007-09-21', 4, 1, 2, 1, 33),
(16, '2003-09-09', '2011-10-11', 4, 3, 1, 3, 100),
(17, '2010-10-26', '2010-05-10', 2, 3, 2, 3, 77),
(18, '2002-09-05', '2003-09-22', 3, 2, 2, 3, 63),
(19, '2004-03-05', '2008-05-01', 4, 2, 2, 2, 94),
(20, '2009-07-18', '2009-10-12', 2, 1, 1, 4, 74),
(21, '2002-07-25', '2010-07-18', 1, 3, 1, 3, 85),
(22, '2014-03-05', '2003-03-19', 3, 4, 3, 4, 99),
(23, '2013-03-17', '2003-01-10', 1, 2, 2, 1, 100),
(24, '2014-08-29', '2007-09-25', 2, 3, 1, 3, 10),
(25, '2003-11-27', '2005-02-24', 4, 1, 1, 4, 81),
(26, '2005-01-21', '2014-12-18', 2, 1, 3, 1, 96),
(27, '2003-03-23', '2005-05-28', 2, 2, 1, 1, 97),
(28, '2006-01-03', '2006-04-25', 5, 2, 1, 1, 65),
(29, '2003-01-16', '2012-03-28', 3, 4, 1, 3, 4),
(30, '2014-01-04', '2005-12-23', 4, 1, 1, 1, 56),
(31, '2002-10-26', '2004-01-23', 2, 1, 3, 1, 13),
(32, '2009-07-04', '2013-12-18', 5, 1, 1, 2, 100),
(33, '2002-06-30', '2010-06-03', 3, 4, 2, 4, 34),
(34, '2002-01-29', '2012-06-05', 2, 1, 2, 3, 5),
(35, '2014-10-14', '2003-12-07', 3, 2, 3, 3, 38),
(36, '2002-08-23', '2008-10-03', 3, 2, 3, 4, 46),
(37, '2004-04-28', '2005-12-26', 1, 3, 3, 3, 27),
(38, '2006-10-20', '2004-01-16', 4, 2, 3, 3, 41),
(39, '2007-04-21', '2004-05-21', 5, 3, 1, 4, 3),
(40, '2012-01-05', '2014-03-15', 1, 3, 2, 3, 5),
(41, '2014-07-23', '2007-10-21', 4, 1, 1, 3, 14),
(42, '2013-11-14', '2012-05-06', 2, 4, 3, 1, 87),
(43, '2006-07-02', '2006-12-28', 4, 3, 1, 3, 100),
(44, '2004-10-02', '2010-06-22', 5, 3, 2, 1, 44),
(45, '2012-08-25', '2004-06-17', 5, 2, 2, 4, 5),
(46, '2013-05-02', '2005-09-15', 4, 3, 3, 3, 38),
(47, '2008-06-04', '2003-01-02', 4, 2, 1, 2, 33),
(48, '2010-10-01', '2008-06-19', 5, 3, 3, 2, 80),
(49, '2006-01-07', '2006-03-14', 5, 3, 2, 1, 55),
(50, '2004-06-01', '2010-04-24', 2, 3, 2, 4, 9),
(51, '2008-02-26', '2007-08-07', 1, 2, 2, 4, 88),
(52, '2009-02-04', '2006-05-20', 3, 2, 3, 4, 65),
(53, '2013-10-08', '2012-03-07', 3, 3, 1, 3, 26),
(54, '2003-12-12', '2009-04-07', 5, 4, 3, 4, 29),
(55, '2011-02-04', '2009-04-24', 1, 4, 1, 4, 100),
(56, '2011-09-21', '2011-08-11', 1, 2, 3, 1, 11),
(57, '2014-07-14', '2011-07-27', 1, 4, 1, 2, 6),
(58, '2002-12-08', '2005-08-26', 3, 4, 1, 1, 49),
(59, '2014-06-03', '2008-11-11', 1, 1, 1, 2, 15),
(60, '2003-09-10', '2010-01-20', 4, 4, 3, 3, 10),
(61, '2012-01-22', '2010-07-09', 4, 3, 2, 1, 60),
(62, '2003-04-05', '2004-11-05', 4, 3, 3, 4, 77),
(63, '2007-10-08', '2012-03-28', 1, 2, 2, 1, 88),
(64, '2012-12-16', '2004-02-23', 5, 2, 2, 4, 56),
(65, '2003-01-18', '2012-01-07', 3, 4, 1, 4, 54),
(66, '2008-12-04', '2006-06-22', 4, 2, 3, 1, 44),
(67, '2005-01-21', '2013-03-26', 1, 3, 2, 1, 48),
(68, '2003-08-30', '2010-11-16', 2, 4, 2, 2, 97),
(69, '2007-09-21', '2014-01-11', 3, 1, 1, 2, 21),
(70, '2014-03-30', '2005-02-03', 3, 2, 1, 3, 50),
(71, '2007-07-16', '2014-05-08', 3, 4, 1, 3, 54),
(72, '2010-05-25', '2003-06-01', 4, 3, 2, 3, 16),
(73, '2002-11-12', '2010-01-06', 5, 4, 2, 4, 89),
(74, '2006-12-06', '2014-02-25', 4, 4, 2, 2, 7),
(75, '2004-01-23', '2004-12-03', 5, 4, 2, 2, 87),
(76, '2009-12-03', '2005-03-07', 3, 1, 2, 4, 56),
(77, '2011-10-14', '2014-06-14', 3, 3, 2, 3, 70),
(78, '2007-07-24', '2013-10-15', 2, 4, 2, 3, 84),
(79, '2004-02-22', '2006-03-02', 1, 2, 1, 3, 29),
(80, '2002-10-05', '2009-12-14', 1, 1, 2, 1, 9),
(81, '2007-10-20', '2002-11-14', 5, 2, 3, 1, 18),
(82, '2002-12-10', '2012-07-09', 3, 2, 3, 3, 61),
(83, '2012-06-25', '2002-01-30', 2, 3, 1, 4, 74),
(84, '2005-10-15', '2005-04-23', 1, 4, 3, 4, 40),
(85, '2007-11-05', '2002-11-29', 3, 1, 3, 3, 2),
(86, '2005-01-04', '2007-11-18', 5, 2, 3, 1, 45),
(87, '2004-08-21', '2003-07-30', 2, 3, 3, 2, 82),
(88, '2007-06-19', '2014-01-12', 3, 2, 1, 2, 89),
(89, '2004-05-15', '2011-04-29', 4, 3, 1, 4, 56),
(90, '2003-10-10', '2004-02-13', 5, 4, 2, 4, 24),
(91, '2005-05-12', '2011-08-22', 5, 3, 1, 3, 22),
(92, '2003-01-30', '2013-02-19', 2, 1, 2, 4, 30),
(93, '2002-07-14', '2012-12-30', 4, 4, 1, 2, 25),
(94, '2002-06-14', '2005-03-10', 1, 4, 1, 1, 21),
(95, '2007-04-20', '2009-12-22', 3, 2, 1, 4, 78),
(96, '2002-11-20', '2004-02-06', 3, 3, 2, 4, 42),
(97, '2006-12-27', '2009-05-12', 4, 3, 2, 4, 75),
(98, '2008-04-13', '2002-04-12', 5, 4, 2, 3, 13),
(99, '2006-05-14', '2010-09-14', 3, 4, 3, 1, 30),
(100, '2004-02-13', '2011-07-03', 2, 4, 2, 1, 89),
(101, '2006-01-25', '2008-02-11', 1, 3, 3, 2, 14),
(102, '2009-06-26', '2005-10-18', 3, 4, 2, 2, 2),
(103, '2006-02-19', '2008-10-28', 4, 1, 3, 4, 95),
(104, '2002-09-15', '2014-03-12', 4, 1, 3, 3, 74),
(105, '2002-09-08', '2005-05-28', 2, 1, 2, 3, 32),
(106, '2014-12-05', '2003-01-05', 2, 3, 3, 1, 70),
(107, '2011-12-27', '2006-05-19', 3, 3, 1, 1, 27),
(108, '2013-09-09', '2013-08-02', 2, 4, 3, 2, 62),
(109, '2003-07-05', '2010-12-28', 5, 2, 2, 2, 9),
(110, '2010-03-25', '2009-02-25', 1, 2, 2, 3, 25),
(111, '2004-02-21', '2009-07-01', 5, 3, 1, 1, 89),
(112, '2004-11-30', '2002-07-22', 1, 4, 2, 1, 66),
(113, '2007-06-18', '2014-07-30', 5, 1, 2, 4, 92),
(114, '2007-05-03', '2009-07-24', 4, 4, 3, 3, 83),
(115, '2006-12-30', '2014-09-02', 3, 1, 2, 1, 72),
(116, '2003-05-19', '2006-08-24', 4, 3, 2, 1, 19),
(117, '2006-03-23', '2012-08-07', 2, 1, 3, 4, 33),
(118, '2010-04-15', '2008-11-30', 2, 1, 3, 4, 89),
(119, '2010-04-21', '2007-11-18', 2, 1, 1, 4, 67),
(120, '2006-01-31', '2014-03-26', 1, 1, 3, 4, 23),
(121, '2010-02-14', '2009-11-20', 5, 3, 3, 1, 60),
(122, '2007-03-10', '2002-03-22', 4, 1, 1, 1, 99),
(123, '2014-03-07', '2007-07-05', 3, 1, 3, 4, 45),
(124, '2015-01-14', '2012-04-03', 3, 3, 3, 2, 80),
(125, '2003-06-16', '2002-11-28', 4, 2, 3, 1, 82),
(126, '2002-03-08', '2006-04-01', 2, 4, 1, 2, 37),
(127, '2004-03-01', '2014-01-03', 4, 1, 3, 1, 5),
(128, '2011-01-23', '2005-07-29', 5, 4, 2, 1, 19),
(129, '2014-02-27', '2010-08-29', 1, 2, 2, 1, 4),
(130, '2005-08-04', '2006-03-07', 4, 1, 2, 1, 54),
(131, '2006-06-19', '2014-04-30', 1, 3, 2, 4, 78),
(132, '2002-08-08', '2014-03-08', 1, 3, 3, 3, 2),
(133, '2002-04-09', '2014-01-14', 3, 2, 1, 2, 98),
(134, '2013-04-12', '2014-08-30', 3, 3, 1, 4, 57),
(135, '2012-02-16', '2014-05-15', 2, 1, 2, 2, 91),
(136, '2002-09-09', '2005-03-14', 3, 2, 2, 4, 85),
(137, '2010-04-02', '2003-11-15', 4, 4, 3, 4, 16),
(138, '2010-11-20', '2012-12-19', 5, 4, 3, 2, 66),
(139, '2011-01-07', '2006-03-26', 2, 3, 2, 4, 19),
(140, '2008-05-17', '2008-11-30', 1, 2, 1, 3, 57),
(141, '2004-12-18', '2011-08-22', 1, 3, 1, 1, 90),
(142, '2003-12-13', '2004-11-12', 2, 2, 2, 2, 28),
(143, '2011-08-28', '2005-06-05', 4, 2, 3, 3, 63),
(144, '2008-08-17', '2008-11-09', 4, 2, 2, 4, 84),
(145, '2005-06-08', '2012-08-08', 3, 2, 3, 1, 99),
(146, '2010-12-04', '2003-03-16', 5, 1, 1, 1, 35),
(147, '2010-09-13', '2010-01-02', 4, 4, 3, 3, 62),
(148, '2003-06-01', '2005-01-23', 4, 2, 2, 1, 25),
(149, '2005-01-10', '2005-11-07', 5, 2, 2, 4, 49),
(150, '2004-05-27', '2002-03-16', 5, 2, 3, 3, 98),
(151, '2014-05-24', '2004-03-09', 1, 2, 1, 2, 44),
(152, '2011-06-03', '2012-04-27', 1, 1, 1, 2, 94),
(153, '2011-03-02', '2010-03-22', 3, 4, 2, 4, 90),
(154, '2007-10-17', '2008-03-24', 4, 4, 1, 1, 82),
(155, '2014-07-06', '2011-05-03', 5, 3, 2, 1, 42),
(156, '2005-08-06', '2005-07-31', 2, 2, 1, 4, 51),
(157, '2007-03-11', '2007-01-18', 2, 4, 1, 3, 11),
(158, '2013-10-17', '2012-09-03', 1, 4, 1, 3, 57),
(159, '2013-08-07', '2012-07-12', 2, 3, 3, 4, 8),
(160, '2011-04-15', '2004-07-22', 2, 3, 2, 4, 65),
(161, '2009-08-11', '2014-04-24', 1, 4, 2, 3, 57),
(162, '2003-03-24', '2009-10-20', 3, 3, 1, 1, 49),
(163, '2008-12-03', '2008-03-20', 3, 4, 3, 1, 79),
(164, '2014-11-09', '2009-11-27', 5, 3, 3, 2, 8),
(165, '2006-09-25', '2007-11-02', 4, 2, 3, 3, 56),
(166, '2013-09-28', '2010-06-13', 2, 2, 1, 2, 19),
(167, '2006-07-17', '2008-08-14', 4, 3, 2, 4, 5),
(168, '2010-04-23', '2003-07-12', 3, 2, 2, 2, 52),
(169, '2005-05-05', '2004-05-04', 2, 4, 3, 3, 25),
(170, '2004-12-24', '2014-01-31', 4, 1, 3, 2, 52),
(171, '2006-07-01', '2013-07-21', 4, 4, 1, 2, 42),
(172, '2003-08-12', '2014-08-31', 3, 1, 2, 4, 41),
(173, '2010-09-27', '2006-09-10', 3, 2, 3, 3, 43),
(174, '2004-05-02', '2008-01-19', 1, 3, 2, 4, 6),
(175, '2007-08-08', '2010-02-19', 2, 3, 2, 4, 61),
(176, '2011-08-17', '2008-05-19', 4, 3, 3, 2, 94),
(177, '2014-01-01', '2012-02-28', 1, 1, 1, 2, 16),
(178, '2010-01-03', '2014-09-02', 4, 4, 1, 2, 58),
(179, '2006-04-19', '2008-02-19', 5, 3, 1, 4, 90),
(180, '2012-05-10', '2011-07-01', 4, 3, 2, 2, 61),
(181, '2007-01-20', '2010-08-08', 4, 1, 1, 1, 2),
(182, '2009-10-09', '2012-07-09', 5, 3, 3, 4, 45),
(183, '2006-05-01', '2008-04-17', 2, 3, 1, 4, 90),
(184, '2009-06-14', '2014-04-26', 1, 2, 2, 1, 91),
(185, '2008-02-26', '2013-08-07', 2, 3, 3, 3, 80),
(186, '2015-01-15', '2008-07-12', 5, 2, 2, 4, 74),
(187, '2012-07-31', '2007-09-28', 1, 3, 3, 1, 65),
(188, '2013-07-15', '2008-07-01', 1, 1, 2, 3, 45),
(189, '2007-10-26', '2002-08-30', 3, 4, 2, 4, 56),
(190, '2014-01-31', '2006-05-20', 2, 2, 1, 1, 30),
(191, '2009-08-19', '2004-05-05', 1, 3, 2, 2, 68),
(192, '2005-11-30', '2008-12-02', 4, 2, 1, 2, 54),
(193, '2005-05-21', '2011-03-23', 5, 4, 3, 4, 41),
(194, '2009-10-20', '2009-11-23', 1, 4, 1, 3, 25),
(195, '2003-10-08', '2005-11-16', 1, 1, 3, 4, 56),
(196, '2009-01-04', '2004-04-27', 5, 2, 2, 1, 98),
(197, '2006-10-05', '2005-01-17', 5, 1, 2, 1, 28),
(198, '2009-11-12', '2014-05-27', 5, 4, 2, 3, 7),
(199, '2011-01-08', '2007-10-14', 2, 3, 1, 4, 55),
(200, '2006-04-01', '2002-05-12', 2, 2, 1, 3, 94),
(201, '2002-12-20', NULL, 2, 2, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `car` varchar(50) DEFAULT NULL,
  `list_of_property_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `car`, `list_of_property_ID`) VALUES
(1, 'Lumina', 1),
(2, 'Q5', 2),
(3, 'Forester', 3),
(4, 'RX-7', 4),
(5, 'Ciera', 5),
(6, 'ES', 6),
(7, 'Neon', 7),
(8, 'Town Car', 8),
(9, 'Blazer', 9),
(10, 'H1', 10),
(11, 'Familia', 11),
(12, 'Beetle', 12),
(13, 'H3', 13),
(14, 'Taurus', 14),
(15, 'Touareg', 15),
(16, 'Concorde', 16),
(17, 'Escape', 17),
(18, 'Swift', 18),
(19, 'Escape', 19),
(20, 'Civic GX', 20),
(21, 'Escalade EXT', 21),
(22, 'Suburban 2500', 22),
(23, 'GX', 23),
(24, 'Elise', 24),
(25, 'Corvette', 25),
(26, 'Achieva', 26),
(27, 'Bonneville', 27),
(28, 'Uplander', 28),
(29, 'MX-6', 29),
(30, 'Thunderbird', 30),
(31, 'Explorer', 31),
(32, 'Cruze', 32),
(33, 'Mazda5', 33),
(34, 'V50', 34),
(35, 'Sunfire', 35),
(36, 'Miata MX-5', 36),
(37, '5 Series', 37),
(38, 'Dakota', 38),
(39, 'Canyon', 39),
(40, 'SLX', 40),
(41, 'Defender 90', 41),
(42, 'S10', 42),
(43, 'XJ Series', 43),
(44, 'RX Hybrid', 44),
(45, 'XL-7', 45),
(46, 'Excel', 46),
(47, 'Econoline E150', 47),
(48, '1 Series', 48),
(49, 'G-Class', 49),
(50, 'Voyager', 50),
(51, 'RL', 51),
(52, 'V50', 52),
(53, 'XG350', 53),
(54, 'LeMans', 54),
(55, 'Mirage', 55),
(56, 'NV3500', 56),
(57, 'H3T', 57),
(58, 'Concorde', 58),
(59, 'V70', 59),
(60, 'Sonata', 60),
(61, 'Taurus', 61),
(62, '4Runner', 62),
(63, 'Venza', 63),
(64, 'Topaz', 64),
(65, 'Veracruz', 65),
(66, 'Escort', 66),
(67, 'Sunbird', 67),
(68, 'E250', 68),
(69, 'Suburban 2500', 69),
(70, 'F150', 70),
(71, 'Corsica', 71),
(72, 'Tiburon', 72),
(73, 'Santa Fe', 73),
(74, 'Breeze', 74),
(75, 'Mark VIII', 75),
(76, 'B-Series Plus', 76),
(77, 'B-Series', 77),
(78, 'B-Series Plus', 78),
(79, 'Countach', 79),
(80, 'Ram Wagon B250', 80),
(81, 'Stylus', 81),
(82, 'Panamera', 82),
(83, 'Leganza', 83),
(84, 'Stratus', 84),
(85, 'M-Class', 85),
(86, 'Voyager', 86),
(87, 'Safari', 87),
(88, 'Q5', 88),
(89, 'MX-6', 89),
(90, 'GLI', 90),
(91, 'Mark VIII', 91),
(92, 'S90', 92),
(93, 'Odyssey', 93),
(94, 'Cabriolet', 94),
(95, 'Prius Plug-in', 95),
(96, 'Town & Country', 96),
(97, '3000GT', 97),
(98, 'Ram', 98),
(99, 'Touareg', 99),
(100, 'Tracker', 100),
(101, 'BMW Rx', 1);

-- --------------------------------------------------------

--
-- Table structure for table `relationship_type`
--

CREATE TABLE `relationship_type` (
  `id` int(11) NOT NULL,
  `Name` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relationship_type`
--

INSERT INTO `relationship_type` (`id`, `Name`) VALUES
(1, 'Супруг'),
(2, 'Брат'),
(3, 'Сестра'),
(4, 'Сын'),
(5, 'Дочь'),
(6, 'Внук'),
(7, 'Внучка');

-- --------------------------------------------------------

--
-- Table structure for table `sector`
--

CREATE TABLE `sector` (
  `id` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sector`
--

INSERT INTO `sector` (`id`, `Name`) VALUES
(1, 'Гос. орган'),
(2, 'Квази гос. орган'),
(3, 'Бизнес'),
(4, 'Управления');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nickname`, `password`, `email`) VALUES
(4, 'alimkhan', '$2y$10$fMaX7XmSoFxa9nElMZpW7.khnGcb2vxwEt01.HoH51GjA5AzfDqh6', 'alimkhan@alimkhan.alimkhan'),
(5, 'temirlan', '$2y$10$E25Qrhlkl1EPC.WxhyyP/eSXqvAqYqzYlMBhf.wAE920r1oUFJHCe', 'temirlan@temirlan.temirlan'),
(6, 'ertlek', '$2y$10$OA3TenOW6XXiIEwgJ0h27unigw8b1wezvueA7ECfJlvscg8CKX.PO', 'ertlek@ertlek.ertlek');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_of_position`
--
ALTER TABLE `history_of_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_of_property`
--
ALTER TABLE `list_of_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position_held`
--
ALTER TABLE `position_held`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `relationship_type`
--
ALTER TABLE `relationship_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nickname_unique` (`nickname`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `position_held`
--
ALTER TABLE `position_held`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
