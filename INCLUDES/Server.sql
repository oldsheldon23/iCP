-- phpMyAdmin SQL Dump
-- version 3.3.7deb3build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 31, 2011 at 11:13 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iCP`
--
CREATE DATABASE `iCP` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `iCP`;

-- --------------------------------------------------------

--
-- Table structure for table `accs`
--

CREATE TABLE IF NOT EXISTS `accs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL COMMENT 'Nickname',
  `crumbs` text NOT NULL COMMENT 'User Crumbs',
  `password` text NOT NULL COMMENT 'Password',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Accounts' AUTO_INCREMENT=12613 ;

--
-- Dumping data for table `accs`
--

INSERT INTO `accs` (`ID`, `name`, `crumbs`, `password`) VALUES
(1, 'Riley', 'a:29:{s:5:"email";s:0:"";s:10:"registerIP";s:0:"";s:12:"registertime";i:1294956131;s:5:"color";s:2:"12";s:4:"head";s:1:"0";s:4:"face";s:1:"0";s:4:"neck";s:3:"171";s:4:"body";s:1:"0";s:5:"hands";i:0;s:4:"feet";s:1:"0";s:3:"pin";s:1:"7";s:5:"photo";s:4:"9052";s:5:"items";a:26:{i:0;i:1;i:1;i:444;i:2;s:4:"7043";i:3;s:3:"413";i:4;s:2:"14";i:5;s:3:"712";i:6;s:3:"143";i:7;s:3:"172";i:8;s:4:"4241";i:9;s:2:"13";i:10;s:2:"12";i:11;s:1:"4";i:12;s:4:"4131";i:13;s:3:"171";i:14;s:4:"9052";i:15;s:3:"855";i:16;s:4:"5081";i:17;s:3:"102";i:18;s:4:"1087";i:19;s:4:"2025";i:20;s:4:"4121";i:21;s:4:"6026";i:22;s:1:"7";i:23;s:4:"1208";i:24;s:4:"4292";i:25;s:1:"2";}s:5:"coins";i:105000;s:11:"isModerator";b:1;s:9:"isBanned_";b:0;s:7:"buddies";a:74:{i:0;s:2:"24";i:1;s:2:"28";i:2;s:3:"122";i:3;s:1:"7";i:4;s:2:"92";i:5;s:3:"210";i:6;s:3:"225";i:7;s:3:"191";i:8;s:3:"232";i:9;s:3:"235";i:10;s:1:"2";i:11;s:3:"234";i:12;s:1:"4";i:13;s:3:"247";i:14;s:3:"185";i:15;s:3:"252";i:16;s:1:"3";i:17;s:3:"246";i:18;s:3:"233";i:19;s:3:"194";i:20;s:2:"84";i:21;s:3:"709";i:22;s:3:"181";i:23;s:3:"101";i:24;s:3:"285";i:25;s:3:"311";i:26;s:3:"551";i:27;s:3:"435";i:28;s:3:"495";i:29;s:3:"353";i:30;s:3:"797";i:31;s:3:"527";i:32;s:3:"704";i:33;s:4:"1602";i:34;s:4:"1731";i:35;s:4:"1710";i:36;s:4:"1619";i:37;s:4:"1369";i:38;s:3:"131";i:39;s:4:"3400";i:40;s:4:"2656";i:41;s:4:"3410";i:42;s:4:"3557";i:43;s:2:"89";i:44;s:3:"960";i:45;s:4:"3197";i:46;s:4:"1167";i:47;s:4:"3405";i:48;s:3:"829";i:49;s:3:"552";i:50;s:3:"679";i:51;s:4:"3864";i:52;s:4:"3626";i:53;s:3:"253";i:54;s:4:"2848";i:55;s:4:"4307";i:56;s:4:"2392";i:57;s:4:"5386";i:58;s:3:"710";i:59;s:4:"4894";i:60;s:3:"453";i:61;s:4:"7309";i:62;s:2:"13";i:63;s:2:"20";i:64;s:4:"7371";i:65;s:4:"1294";i:66;s:4:"9405";i:67;s:4:"5257";i:68;s:4:"1485";i:69;s:4:"3081";i:70;s:3:"821";i:71;s:4:"2964";i:72;s:4:"2654";i:73;s:4:"1720";}s:6:"ignore";a:0:{}s:6:"stamps";a:109:{i:0;s:3:"197";i:1;s:2:"14";i:2;s:2:"20";i:3;s:2:"26";i:4;s:2:"13";i:5;s:2:"18";i:6;s:2:"16";i:7;s:3:"200";i:8;s:2:"22";i:9;s:2:"27";i:10;s:2:"23";i:11;s:2:"12";i:12;s:2:"15";i:13;s:2:"29";i:14;s:2:"17";i:15;s:3:"201";i:16;s:2:"30";i:17;s:2:"28";i:18;s:2:"19";i:19;s:2:"24";i:20;s:2:"21";i:21;s:2:"11";i:22;s:2:"25";i:23;s:3:"198";i:24;s:3:"199";i:25;s:1:"9";i:26;s:2:"10";i:27;s:2:"33";i:28;s:2:"31";i:29;s:1:"8";i:30;s:2:"32";i:31;s:2:"34";i:32;s:2:"35";i:33;s:2:"36";i:34;s:1:"7";i:35;s:3:"182";i:36;s:3:"183";i:37;s:3:"184";i:38;s:3:"185";i:39;s:2:"73";i:40;s:2:"80";i:41;s:2:"84";i:42;s:2:"77";i:43;s:2:"86";i:44;s:2:"75";i:45;s:2:"88";i:46;s:2:"82";i:47;s:2:"91";i:48;s:2:"78";i:49;s:2:"79";i:50;s:2:"92";i:51;s:2:"81";i:52;s:2:"85";i:53;s:2:"76";i:54;s:2:"87";i:55;s:2:"74";i:56;s:2:"89";i:57;s:2:"83";i:58;s:2:"72";i:59;s:2:"55";i:60;s:2:"61";i:61;s:2:"59";i:62;s:2:"62";i:63;s:2:"56";i:64;s:2:"57";i:65;s:2:"58";i:66;s:2:"60";i:67;s:2:"53";i:68;s:2:"51";i:69;s:2:"52";i:70;s:2:"54";i:71;s:2:"95";i:72;s:2:"97";i:73;s:3:"102";i:74;s:3:"104";i:75;s:2:"96";i:76;s:3:"108";i:77;s:2:"93";i:78;s:3:"101";i:79;s:2:"98";i:80;s:3:"110";i:81;s:3:"109";i:82;s:3:"107";i:83;s:3:"112";i:84;s:3:"111";i:85;s:3:"100";i:86;s:2:"94";i:87;s:3:"113";i:88;s:3:"106";i:89;s:3:"105";i:90;s:3:"103";i:91;s:3:"114";i:92;s:2:"99";i:93;s:2:"49";i:94;s:2:"45";i:95;s:2:"50";i:96;s:2:"40";i:97;s:2:"47";i:98;s:2:"38";i:99;s:2:"41";i:100;s:2:"42";i:101;s:2:"43";i:102;s:2:"44";i:103;s:2:"48";i:104;s:2:"39";i:105;s:2:"46";i:106;s:2:"37";i:107;s:3:"203";i:108;s:3:"205";}s:10:"stampColor";i:1;s:14:"stampHighlight";i:1;s:12:"stampPattern";i:-1;s:9:"stampIcon";i:1;s:5:"igloo";s:2:"27";s:5:"music";i:0;s:5:"floor";s:1:"0";s:9:"furniture";a:3:{i:648;i:2;i:661;i:1;i:660;i:4;}s:13:"roomFurniture";s:16:"648|245|291|1|1,";s:4:"mood";s:6:"Hello!";}', 'notmyrealpassword');


-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `ID` int(11) NOT NULL COMMENT 'Server ID',
  `population` int(11) NOT NULL COMMENT 'Population',
  `ts` text NOT NULL COMMENT 'Timestamp',
  UNIQUE KEY `ID` (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Servers';

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`ID`, `population`, `ts`) VALUES
(1, 5, '1296515486'),
(101, 182, '1296515601'),
(103, 0, '1296409658');
