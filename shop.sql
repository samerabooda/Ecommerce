-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2018 at 02:08 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Descrption` varchar(255) NOT NULL,
  `Parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visablty` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Descrption`, `Parent`, `Ordering`, `Visablty`, `Allow_Comment`, `Allow_Ads`) VALUES
(27, 'Computers', 'computers items', 0, 2, 0, 0, 0),
(28, 'CellPhone', 'cellphone items', 0, 1, 0, 0, 0),
(29, 'Clothing', 'closing item', 0, 1, 1, 0, 0),
(30, 'Tools', 'homemade tools', 0, 1, 0, 0, 0),
(31, 'games', 'sadas', 0, 1, 1, 0, 0),
(39, 'nokia', 'asdad', 28, 1, 0, 0, 0),
(41, 'xsddcsdcs', 'sc', 27, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`Comment_id` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `statues` tinyint(4) NOT NULL,
  `Comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Comment_id`, `Comment`, `statues`, `Comment_date`, `item_id`, `user_id`) VALUES
(1, 'fgdargdfgdfg', 1, '2018-08-01', 21, 10),
(2, 'this is anter', 1, '2018-08-01', 21, 2),
(3, 'this is comments khaled', 1, '2018-08-01', 21, 10),
(5, 'sdasadasdasda', 1, '2018-08-01', 25, 14),
(11, 'sxas', 1, '2018-09-03', 23, 10),
(12, 'sdfsd', 1, '2018-09-04', 25, 10),
(13, 'saasxx', 1, '2018-09-04', 24, 10),
(14, 'sqwxzxasxacwe', 1, '2018-09-04', 25, 10),
(15, 'samer', 1, '2018-09-04', 25, 10),
(16, 'very nice', 1, '2018-09-04', 25, 10),
(20, 'khLED', 1, '2018-09-04', 24, 10),
(21, 'asa', 1, '2018-09-05', 43, 10);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
`ItemID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Descrption` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `addDate` date NOT NULL,
  `CountryMade` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `statues` varchar(255) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Rating` smallint(6) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  `MemberID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `Name`, `Descrption`, `Price`, `addDate`, `CountryMade`, `image`, `statues`, `Approve`, `Rating`, `Cat_ID`, `MemberID`, `tags`) VALUES
(21, 'speaker', 'very good', '10$', '2018-09-01', 'china', '', '1', 1, 0, 28, 4, ''),
(22, 'mivrophone', 'good', '08', '2018-09-01', 'usa', '', '1', 1, 0, 27, 10, ''),
(23, 'mouce', 'is the like new', '$10', '2018-09-01', 'usa', '', '2', 1, 0, 27, 10, ''),
(24, 'moutan', 'asdcaca', '$20', '2018-09-01', 'USA', '', '1', 1, 0, 27, 10, ''),
(25, 'process', 'used', '5$', '2018-09-01', 'chaina', '', '3', 1, 0, 27, 10, 'sas,rtsas'),
(39, 'dreftbbgb', 'dreftbbgb', '12', '2018-09-04', 'sdsad', '', '3', 1, 0, 27, 10, ''),
(40, 'sdad', 'sad', '2', '2018-09-05', 'sas', '', '1', 1, 0, 27, 2, ''),
(41, 'Pls4', 'good gams', '10', '2018-09-05', 'cairo', '', '1', 1, 0, 31, 8, 'GOOD,users'),
(42, 'adssadasddasdad', 'adssadasddasdad', '8', '2018-09-05', 'xzcsd', '', '1', 1, 0, 31, 10, ''),
(43, 'asxxxxxxxxx', 'asxxxxxxxxx', '5', '2018-09-05', 'fgfa', '', '3', 1, 0, 29, 10, 'sass,fds'),
(44, 'asdxas', 'asdxas', '10', '2018-09-05', 'sadasd', '', '2', 1, 0, 31, 10, 'GOOD');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`UserID` int(11) NOT NULL COMMENT 'TO IDENFAY USER',
  `Username` varchar(255) NOT NULL COMMENT 'username to login',
  `Password` varchar(255) NOT NULL COMMENT 'password to login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0',
  `TrustStatus` int(11) NOT NULL DEFAULT '0',
  `Regstatues` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL,
  `avatar` varchar(225) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `Regstatues`, `Date`, `avatar`) VALUES
(1, 'samer', '3d6bba78a8a5c6a1e2c8694ae6ea202c163dcb21', 'samerabodelmonem96@gmail.com', 'samerabooda', 1, 0, 1, '0000-00-00', ''),
(2, 'mohamed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mohameds@info', 'mohamed ahmed', 0, 0, 1, '2018-08-24', ''),
(3, 'ahmed', '6b6277afcb65d33525545904e95c2fa240632660', 'ahmed@gmail', 'ahmed samir', 0, 0, 1, '2018-08-24', ''),
(4, 'elsayed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'elsayed@yahoo.com', 'elsayed ahmed', 0, 0, 1, '2018-08-24', ''),
(8, 'sameh', '0735ec301b2987daad452d62c34b0884de674e46', 'sameh@info', 'sameh mohamed', 0, 0, 1, '2018-08-24', ''),
(9, 'elsaied', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'elsaies@info', 'elsaied mohamed', 0, 0, 1, '2018-08-26', ''),
(10, 'khaled', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'khaled@info', 'ksd', 0, 0, 1, '2018-08-30', ''),
(12, 'mariem', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'mariem@info.com', '', 0, 0, 0, '2018-09-02', ''),
(13, 'khloood', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'asas@sd.com', '', 0, 0, 1, '2018-09-02', ''),
(14, 'marwa', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ass@sad.com', '', 0, 0, 1, '2018-09-02', ''),
(15, 'asxas', '8346953607195122cdea75488f96ab7f2d1d64b7', 'asxaas@sadcasd', 'sacs', 0, 0, 0, '2018-09-05', ''),
(17, 'asxasx', 'e2cf4087f274d792de3fd871364a9562e3857b5b', 'asxasacadsca@dsca', 'sacsdcds', 0, 0, 0, '2018-09-05', ''),
(19, 'ascas', '7bfbe40d7117d4b560fe19edfb6f93cb34d27f09', 'saas@dads', 'saxas@sacas', 0, 0, 0, '2018-09-05', '3074_IMG-20180611-WA0002.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`Comment_id`), ADD KEY `item1` (`item_id`), ADD KEY `user1` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
 ADD PRIMARY KEY (`ItemID`), ADD UNIQUE KEY `Name` (`Name`), ADD KEY `member_1` (`MemberID`), ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `Comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'TO IDENFAY USER',AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `item1` FOREIGN KEY (`item_id`) REFERENCES `items` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `member_1` FOREIGN KEY (`MemberID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
