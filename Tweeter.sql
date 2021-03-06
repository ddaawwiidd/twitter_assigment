-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2016 at 09:53 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Tweeter`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_tweet` int(11) DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL,
  `comment_body` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_tweet` (`id_tweet`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`id`, `id_user`, `id_tweet`, `comment_date`, `comment_body`) VALUES
(1, 1, 1, '2016-02-12 00:00:00', 'test'),
(5, 1, 1, '2016-02-12 15:40:37', 'fdfgdgd'),
(6, 1, 1, '2016-02-12 15:41:03', 'fdfgdgd'),
(7, 1, 12, '2016-02-12 16:51:29', 'comment1'),
(8, 1, 11, '2016-02-12 17:31:06', 'komentarz'),
(9, 1, 11, '2016-02-12 18:02:23', 'komentarz2');

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sent` int(11) DEFAULT NULL,
  `id_received` int(11) DEFAULT NULL,
  `body_msg` varchar(255) DEFAULT NULL,
  `date_msg` datetime DEFAULT NULL,
  `read_msg` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_sent` (`id_sent`),
  KEY `id_received` (`id_received`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `Messages`
--

INSERT INTO `Messages` (`id`, `id_sent`, `id_received`, `body_msg`, `date_msg`, `read_msg`) VALUES
(1, 1, 1, 'inserted from DB', '2016-02-13 00:00:00', 1),
(2, 1, 1, 'test msg', '2016-02-13 20:30:07', 1),
(3, 1, 1, 'test msg', '2016-02-13 20:32:13', 1),
(4, 1, 1, 'test msg', '2016-02-13 20:32:13', 1),
(5, 1, 1, 'test msg', '2016-02-13 20:32:13', 1),
(6, 1, 1, 'test message', '2016-02-13 20:32:29', 1),
(10, 1, 1, 'aaaaa', '2016-02-13 21:16:33', 1),
(11, 1, 1, 'aaaaa', '2016-02-13 21:16:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Tweets`
--

CREATE TABLE IF NOT EXISTS `Tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `tweet_body` varchar(140) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `Tweets`
--

INSERT INTO `Tweets` (`id`, `id_user`, `tweet_body`, `post_date`) VALUES
(1, 1, 'test edytu', '2016-02-12'),
(2, 1, 'ssssss', '2016-02-12'),
(3, 1, 'ssssss', '2016-02-12'),
(4, 1, 'ssssss', '2016-02-12'),
(5, 1, 'ssssss', '2016-02-12'),
(6, 1, 'ssssss', '2016-02-12'),
(7, 1, 'ssssss', '2016-02-12'),
(8, 1, 'ssssss', '2016-02-12'),
(9, 1, 'ssssss', '2016-02-12'),
(10, 1, 'ssssss', '2016-02-12'),
(11, 1, 'ssssss', '2016-02-12'),
(12, 1, 'abcds', '2016-02-12'),
(15, 1, 'test', '2016-02-12');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` char(60) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `name`, `email`, `password`, `description`) VALUES
(1, 'dan', 'dd@dd.pl', '$2y$11$wEE7fRyQrHF6smvU/jwevO1d3WZ66.kr7S3ePjliZNz41qzacO6P2', 'Here is place for your new description'),
(2, 'anna', 'aa@aa.pl', '$2y$11$1hwXtt2hNPBbDexTTb2VJ.eU8lYML5e3MCsaYlFX2A6DC3g3gUT9K', 'i like six');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`id_tweet`) REFERENCES `Tweets` (`id`);

--
-- Constraints for table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`id_sent`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`id_received`) REFERENCES `Users` (`id`);

--
-- Constraints for table `Tweets`
--
ALTER TABLE `Tweets`
  ADD CONSTRAINT `Tweets_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
