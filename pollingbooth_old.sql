-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2021 at 02:25 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pollingbooth`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `pollsId` int(11) NOT NULL,
  `choicesId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `usersId`, `pollsId`, `choicesId`) VALUES
(8, 1, 7, 8),
(11, 3, 7, 7),
(16, 2, 7, 9),
(20, 1, 10, 17),
(21, 4, 10, 20),
(23, 7, 21, 60),
(24, 8, 10, 17),
(25, 8, 23, 64),
(26, 1, 20, 58),
(27, 3, 10, 20),
(28, 3, 12, 25),
(29, 3, 14, 36),
(30, 3, 15, 42),
(31, 4, 15, 40),
(32, 4, 14, 36),
(33, 4, 12, 33),
(34, 7, 10, 16),
(36, 4, 27, 76);

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE `choices` (
  `id` int(11) NOT NULL,
  `pollsId` int(11) NOT NULL,
  `choicesName` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `pollsId`, `choicesName`) VALUES
(7, 7, 'Oatmeal Raisin'),
(8, 7, 'Chocolate Chip'),
(9, 7, 'Ginger Snaps'),
(16, 10, 'Diluc'),
(17, 10, 'Qiqi'),
(18, 10, 'Keqing'),
(19, 10, 'Venti'),
(20, 10, 'Mona'),
(23, 12, 'Twitter'),
(25, 12, 'Tumblr'),
(26, 12, 'Instagram'),
(27, 12, 'Facebook'),
(33, 12, 'Reddit'),
(35, 14, 'Salsa'),
(36, 14, 'Cha Cha'),
(37, 14, 'Disco'),
(38, 14, 'Tango'),
(39, 14, 'Jazz'),
(40, 15, 'For the amazing filters'),
(41, 15, 'idk'),
(42, 15, 'To keep in touch with friends and family'),
(43, 15, 'I send snaps everyday, I also maintain streaks ????'),
(44, 16, '????'),
(45, 16, '????'),
(46, 16, '???'),
(47, 16, '?????????'),
(49, 16, '????'),
(52, 18, 'NO WHAT THE HE-'),
(53, 18, 'Yes! But a lot of people say otherwise. '),
(56, 20, 'Wack, NO!!!'),
(57, 20, 'Yes absolutely.'),
(58, 20, 'I don\'t really mind. I am not a fan either.'),
(59, 20, 'As long as it is food, I have no problem..'),
(60, 21, 'Book'),
(61, 21, 'Movie'),
(62, 22, 'Strawberry milkshake'),
(63, 22, 'Hazelnut coffee'),
(64, 23, 'Very fun'),
(65, 23, 'Naah, hate them'),
(74, 27, 'Happy'),
(75, 27, 'Confused'),
(76, 27, 'Sleepy'),
(77, 27, 'Motivated');

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `pollsQues` varchar(128) DEFAULT NULL,
  `pollsDesc` text DEFAULT NULL,
  `pollsStart` date NOT NULL,
  `pollsEnd` date NOT NULL,
  `usersId` int(11) DEFAULT NULL,
  `pollsPrivate` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `pollsQues`, `pollsDesc`, `pollsStart`, `pollsEnd`, `usersId`, `pollsPrivate`) VALUES
(7, 'What\'s your favourite kind of cookie?', 'Its for a party ', '2021-01-23', '2021-01-31', 1, 'N'),
(10, 'Who\'s the best Genshin Impact character', 'Placing the best Genshin Impact characters in a tier list is a trick ask. There are some awesome playable characters and it\'s safe to say that there aren???t even that many terrible ones (well, except maybe poor Amber). But as you advance through the story while unlocking more characters and getting more lucky Gacha pulls, you will find that some teammates are way better than others. Who\'s your favourite character?', '2021-01-24', '2021-07-31', 1, 'N'),
(12, 'What\'s website is your major source of memes?', 'A little survey!', '2021-01-28', '2021-04-17', 1, 'N'),
(14, 'What dance style do you prefer?', 'We just want to know what the audience would love to watch :D', '2021-01-28', '2021-05-10', 1, 'N'),
(15, 'Why do you use snapchat?', NULL, '2021-01-28', '2021-06-30', 1, 'N'),
(16, 'What emoji defines your aesthetic?', 'Choose 1 among the 5 options!', '2021-01-28', '2021-01-29', 4, 'N'),
(18, 'Can you be racist to white people', NULL, '2021-01-28', '2021-06-21', 4, 'N'),
(20, 'Do pineapples belong on pizza?', 'It\'s the food choice that seems to divide the world. What do you think? Is pineapple an acceptable pizza topping?', '2021-02-01', '2021-10-02', 1, 'Y'),
(21, 'Book vs Movie', 'Which one do you think is better at translating the intentions of the author of the original work?', '2021-02-01', '2021-10-02', 7, 'Y'),
(22, 'What\'s your favourite drink?', NULL, '2021-02-01', '2021-02-02', 7, 'Y'),
(23, 'Are polls fun?', NULL, '2021-02-06', '2021-03-31', 8, 'Y'),
(27, 'Describe your mood today..', NULL, '2021-02-22', '2021-03-30', 4, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `usersUid` varchar(128) COLLATE latin1_general_cs NOT NULL,
  `usersEmail` varchar(128) COLLATE latin1_general_cs NOT NULL,
  `usersPwd` varchar(128) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usersUid`, `usersEmail`, `usersPwd`) VALUES
(1, 'Diya', 'diya@gmail.com', '$2y$10$elFfwjNm7B3MiBQKGS4rOuuSdf9al54fsoZxbs6mfTQSSJyGEmEnG'),
(2, 'Krishna', 'krishna@gmail.com', '$2y$10$lqXQrg8US70uUYkGI6fmgOkbMS/1CgPILqE1oUw3E0MsOY/fOMRa6'),
(3, 'Dani', 'dani@gmail.com', '$2y$10$bBzjlkNEn7i0LYugiUGluu.PLl1dVd7a5tP9yTsIA8y9DTBs3doci'),
(4, 'Kat', 'kat@gmail.com', '$2y$10$KAttFpeWj8Ta6aMiQJf0seSFN8GEypg6oGWfzUv2K.C2Relv/ngb2'),
(5, 'Deven', 'deven@gmail.com', '$2y$10$zd.AHhGBvy7W.qSd495jj.4ZSezwqURfA40A3YvIH1a9Q4srjaKe.'),
(6, 'Bella', 'bella@gmail.com', '$2y$10$tGbh6OEfzIDMWaswwQfKAe.FJRKWsGqTF0qUTirGM.Fd.bCgWZyHi'),
(7, 'Louis', 'louis@gmail.com', '$2y$10$SpzB1L6Cu5R0Dw.QBEbuKe7ZlY/ewbD4y0uHf7clR7iX8MvVZ/ZOG'),
(8, 'Leon', 'leon@gmail.com', '$2y$10$lk/ip/Wcxr7MqoX1euSJwunPcpxNuqFAmLHPTM2792WKQF/AKuIJe'),
(9, 'Ruby', 'ruby@gmail.com', '$2y$10$pFQSkoSK4Ox2GQ7FczrfR.m.7aQ3IILVWDQzVHmeOMsla1s6lNm66');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollsId` (`pollsId`),
  ADD KEY `usersId` (`usersId`),
  ADD KEY `choicesId` (`choicesId`);

--
-- Indexes for table `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pollsId` (`pollsId`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usersId` (`usersId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `choices`
--
ALTER TABLE `choices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`pollsId`) REFERENCES `polls` (`id`),
  ADD CONSTRAINT `answers_ibfk_3` FOREIGN KEY (`choicesId`) REFERENCES `choices` (`id`),
  ADD CONSTRAINT `answers_ibfk_4` FOREIGN KEY (`pollsId`) REFERENCES `polls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_ibfk_5` FOREIGN KEY (`usersId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_ibfk_6` FOREIGN KEY (`choicesId`) REFERENCES `choices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `choices_ibfk_1` FOREIGN KEY (`pollsId`) REFERENCES `polls` (`id`),
  ADD CONSTRAINT `choices_ibfk_2` FOREIGN KEY (`pollsId`) REFERENCES `polls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `polls`
--
ALTER TABLE `polls`
  ADD CONSTRAINT `polls_ibfk_1` FOREIGN KEY (`usersId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `polls_ibfk_2` FOREIGN KEY (`usersId`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
