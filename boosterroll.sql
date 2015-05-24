/*
Navicat MySQL Data Transfer

Source Server         : game
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : boosterroll

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-05-23 15:21:42
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(9) NOT NULL auto_increment,
  `name` text collate utf8_unicode_ci NOT NULL,
  `news` text collate utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', 'Dobro pozhalovati na nash sayt', 'blfdlgfdslgfdsfds few fewfewf wfw wtwetw wtw twtw wtw tww twtw wtwt wt', '2015-05-21');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `nickname` varchar(100) collate utf8_unicode_ci NOT NULL,
  `mail` text collate utf8_unicode_ci NOT NULL,
  `password` varchar(100) collate utf8_unicode_ci NOT NULL,
  `salt` varchar(10) collate utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `cOpenBox` int(11) NOT NULL default '0',
  `cCloseBox` int(11) NOT NULL default '0',
  `cAddCash` float NOT NULL default '0',
  `cOutCash` float NOT NULL default '0',
  `CountCsh` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '', 'lovepsone@mail.ru', 'ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'i[91tG0)mo', '2015-05-18', '0', '0', '0', '0', '0');
INSERT INTO `user` VALUES ('3', '', 'roudi1990@mail.ru', 'c1dfd96eea8cc2b62785275bca38ac261256e278', 'qq[b3P~-9H', '2015-05-18', '0', '0', '0', '0', '0');
