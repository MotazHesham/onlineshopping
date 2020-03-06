-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 06, 2020 at 10:06 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineshopping`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `img`, `Ordering`, `Visibility`, `Allow_comment`, `Allow_Ads`) VALUES
(1, 'Watches', 'Smart Watches', '4.jpg', 6, 1, 0, 0),
(23, 'Mobiles', 'Smart Phones', '29.jpg', 7, 1, 0, 0),
(24, 'laptops', 'Smart Mac ', '27.jpg', 1, 1, 1, 1),
(25, 'Tvs', 'Smart Samsung', '31.jpg', 5, 0, 1, 1),
(26, 'HeadPhones', 'Best headphones', '30.jpg', 4, 1, 0, 1),
(27, 'shootsff', '22', '476349_emma_watson_brunette_eyes_face_black_and_white_64219_1920x1080.jpg', 2, 1, 1, 1),
(28, 'test', '444', '291168_desktop-wallpapers-hd-wallpapers-1080p-1920x1080-wallpapers-4.jpg', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment`, `comment_date`, `item_id`, `user_id`) VALUES
(3, 'nice product', '2020-02-21 04:16:00', 11, 2),
(4, 'Very Beauty.this my choice to visit this site.this my choice to visit this site.this my choice to visit this site.this my choice to visit this site.this my choice to visit this site', '2020-02-27 14:25:54', 14, 3),
(5, 'nice cool woow', '2020-02-28 20:54:50', 9, 4),
(6, 'very cool alexandra ', '2020-02-28 20:55:15', 9, 4),
(7, 'keep going alexandra you are wondefull wommen ', '2020-02-28 20:55:45', 9, 2),
(8, 'nice look', '2020-02-29 09:33:37', 9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Country_Made` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `Rating` smallint(6) DEFAULT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `img`, `Rating`, `Approve`, `Category_id`, `user_id`) VALUES
(8, 'Sea', 'Wounderfull', '4k$', '2020-02-22 06:22:19', 'World', 'beach_man_sea_147015_1920x1080.jpg', NULL, 1, 1, 1),
(9, 'alexandra', 'wonderful', 'not for sell', '2020-02-22 04:16:00', 'beauty', 'alexandra-daddario-2-1920x1080.jpg', NULL, 0, 1, 1),
(10, 'assisan', 'best quality', 'OMG', '2020-02-22 03:16:10', 'game', 'Assassin\'s Creed.jpg', NULL, 1, 23, 1),
(11, 'assisan2', 'nice game', '5000', '2020-02-22 02:13:21', 'usa', 'assassins-creed-origins-5k-zu-1920x1080.jpg', NULL, 0, 24, 1),
(13, 'moon', 'night', '22211', '2020-02-22 06:23:18', 'world', '39602608-mysterious-wallpapers.jpg', NULL, 0, 26, 1),
(14, 'car', 'hello', '1M', '2020-02-25 02:27:07', 'world', 'glare_bokeh_shine_134167_1920x1080.jpg', NULL, 0, 26, 1),
(15, 'z222', 'e2e2', 'e2e2e', '2020-02-26 13:10:00', '2222', '335510_Beautiful-Alexandra-Daddario-Wallpaper-Wind-Red-Dress.jpg', NULL, 0, 1, 1),
(16, 'noimage', 'a', 'a', '2020-02-26 02:11:21', 'a', '416107_Assassins-Creed-Wallpapers-Full-HD-Free-Download-Wallpaperxyz-dot-Com-81.jpg', NULL, 0, 1, 1),
(17, 'withimage', '2', '211', '2020-02-26 02:22:18', '22', '664490_dark_souls_ii_dark_souls_warrior_knight_from_software_namco_bandai_games_98197_1920x1080.jpg', NULL, 0, 23, 1),
(18, 'newitem', 'fafaf', 'faf', '2020-02-27 01:11:00', 'test', 'empty.jpg', NULL, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `Role` int(11) NOT NULL DEFAULT '0',
  `Gender` varchar(255) NOT NULL,
  `Age` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `img` varchar(255) NOT NULL DEFAULT 'empty.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `UserName`, `Password`, `Email`, `FullName`, `Role`, `Gender`, `Age`, `Date`, `img`) VALUES
(1, 'virus', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'virus@gmail.com', 'Motaz Hesham', 1, 'Male', 20, '2020-02-01 06:20:12', 'empty.jpg'),
(2, 'user1', '601f1889667efaebb33b8c12572835da3f027f78', 'user1@gmail.com', 'ALi Ahmed', 0, 'Male', 20, '2020-02-02 03:10:25', 'empty.jpg'),
(3, 'user2', '601f1889667efaebb33b8c12572835da3f027f78', 'user2@gmail.com', 'Mai Ahmed', 0, 'Female', 21, '2020-02-02 06:28:16', 'empty.jpg'),
(4, 'user3', '601f1889667efaebb33b8c12572835da3f027f78', 'user3@gmail.com', 'Mariem oOo', 0, 'Female', 20, '2020-02-28 19:21:57', '826325_emma_watson_brunette_eyes_face_black_and_white_64219_1920x1080.jpg'),
(5, 'user4', '601f1889667efaebb33b8c12572835da3f027f78', 'user4@gmail.com', 'Youseef', 0, 'Male', 25, '2020-02-28 19:23:20', '824646_Assassins-Creed-Wallpapers-Full-HD-Free-Download-Wallpaperxyz-dot-Com-81.jpg'),
(6, 'user5', '601f1889667efaebb33b8c12572835da3f027f78', 'user5@gmail.com', 'mai', 0, 'Male', 20, '2020-02-28 14:55:00', 'empty.jpg'),
(7, 'user6', '601f1889667efaebb33b8c12572835da3f027f78', 'user6@gmail.com', 'mohamed', 0, 'Male', 22, '2020-02-28 19:41:51', 'empty.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `itemfk_id` (`item_id`),
  ADD KEY `userfk_id_` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD KEY `userfk_id` (`user_id`),
  ADD KEY `categoryfk_id` (`Category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `itemfk_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userfk_id_` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `categoryfk_id` FOREIGN KEY (`Category_id`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userfk_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
