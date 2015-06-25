/*
Navicat MySQL Data Transfer

Source Server         : game
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : boosterroll

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-06-25 11:56:40
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `chat`
-- ----------------------------
DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id_msg` int(11) NOT NULL auto_increment,
  `id_user` int(11) NOT NULL default '0',
  `msg` text NOT NULL,
  `msg_date` datetime default NULL,
  PRIMARY KEY  (`id_msg`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of chat
-- ----------------------------
INSERT INTO `chat` VALUES ('1', '1', 'Проверка чата!', '2015-05-31 16:21:17');
INSERT INTO `chat` VALUES ('2', '1', 'Проверка цензуры: <span style=\'color:red\'>[Цензура]</span>', '2015-05-31 16:21:35');

-- ----------------------------
-- Table structure for `income`
-- ----------------------------
DROP TABLE IF EXISTS `income`;
CREATE TABLE `income` (
  `id_user` int(11) NOT NULL,
  `Normal` int(11) NOT NULL default '0',
  `Gold` int(11) NOT NULL default '0',
  `Platinum` int(11) NOT NULL default '0',
  `Premium` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of income
-- ----------------------------
INSERT INTO `income` VALUES ('1', '15', '0', '0', '0');
INSERT INTO `income` VALUES ('2', '0', '0', '0', '0');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('1', 'О системе античита', '<p>Одна из тем, волнующих игроков &mdash; это борьба с пользователями, которые не стесняются прибегать к нечестным методам игры, для получения преимущества. Ведущий программист Vostok Games Дмитрий Ясенев пояснил, как работает текущая система защиты в Survarium и что будет представлять собой новая версия античита.</p>', '2015-05-28');
INSERT INTO `news` VALUES ('4', 'Провожаем весну с премиумом! (ОБНОВЛЕНО)', '<p>Солнечные деньки становятся все жарче и возвещают нам о завершении весны и скором наступлении лета. Мы предлагаем провести это время в Survarium, а бесплатный премиум-аккаунт поможет вам добиться впечатляющих результатов!<br />Акция началась 27 мая в 12:00 и продлится сутки.</p>', '2015-05-28');
INSERT INTO `news` VALUES ('5', 'Превью обновления Survarium 0.29', '<p>Разработка обновления 0.29 вышла на финишную прямую, и скоро мы будем рады представить его на суд игроков в рамках тестирования на публичном тестовом сервере. А пока предлагаем ознакомиться с самыми заметными нововведениями грядущего обновления.</p>', '2015-05-28');
INSERT INTO `news` VALUES ('6', 'Календарь Survarium на июнь', '<p>Уже не за горами тот момент, когда география мира <span style=\"color: #ff0000;\">Survarium</span> пополнится еще одной локацией, расположенной далеко за пределами постсоветского пространства! На развалинах бывшей английской столицы развернутся отчаянные бои за выживание и превосходство. Календарь на июнь 2015 года представляет одну из областей карты \"Лондон\".</p>', '2015-05-30');
INSERT INTO `news` VALUES ('7', 'День новичка в Survarium!', '<p>Только один день, 30 мая, в <span style=\\\"color: #ff6600;\\\">магазине Survarium</span>&nbsp;будет действовать уникальное предложение для новичков! Игроки, которые недавно познакомились с Survarium, смогут приобрести наборы экипировки с невероятной скидкой &mdash; 90%! Эти комплекты позволят быстрее освоиться и получить дополнительный комфорт в игре.</p>', '2015-05-30');

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting` varchar(255) default NULL,
  `value` varchar(255) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('StartPage', 'index.php');
INSERT INTO `settings` VALUES ('theme', 'default');
INSERT INTO `settings` VALUES ('StartLocale', 'ru');
INSERT INTO `settings` VALUES ('CountNewsPage', '5');
INSERT INTO `settings` VALUES ('TypeKeyCash', '1:100,2:300,3:500,4:1000');
INSERT INTO `settings` VALUES ('CostLabelPirate1', '250');
INSERT INTO `settings` VALUES ('CountKeyLabelPirate', '30');
INSERT INTO `settings` VALUES ('CountDayLabelPirate', '30');
INSERT INTO `settings` VALUES ('CostLabelPirate2', '1500');
INSERT INTO `settings` VALUES ('IncomeUser', '90');

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
  `gmlevel` int(3) NOT NULL default '0',
  `SellKey` int(11) NOT NULL,
  `SellKeyNormal` int(11) NOT NULL default '0',
  `SellKeyGold` int(11) NOT NULL default '0',
  `SellKeyPlatinum` int(11) NOT NULL default '0',
  `SellKeyPremium` int(11) NOT NULL default '0',
  `Kopeck` int(11) NOT NULL default '0',
  `KopeckNormal` int(11) NOT NULL default '0',
  `KopeckGold` int(11) NOT NULL default '0',
  `KopeckPlatinum` int(11) NOT NULL default '0',
  `KopeckPremium` int(11) NOT NULL default '0',
  `OpenChest` int(11) NOT NULL default '0',
  `cCloseBoxNormal` int(11) NOT NULL default '0',
  `cCloseBoxGold` int(11) NOT NULL default '0',
  `cCloseBoxPlatinum` int(11) NOT NULL default '0',
  `cCloseBoxPremium` int(11) NOT NULL default '0',
  `cAddCash` float(11,0) NOT NULL default '0',
  `cOutCash` float(11,0) NOT NULL default '0',
  `CountCsh` float(11,0) NOT NULL default '0',
  `IncomeCash` float(11,0) NOT NULL default '0',
  `TimerVipLabelPirate` datetime NOT NULL,
  `ContLabelPirate` int(11) NOT NULL default '0',
  `DateLabelPirate` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'lovepsone', 'lovepsone@mail.ru', 'ac3478d69a3c81fa62e60f5c3696165a4e5e6ac4', 'i[91tG0)mo', '2015-05-18', '5', '44', '33', '3', '4', '4', '41', '28', '2', '10', '1', '23', '0', '0', '0', '0', '0', '0', '84050', '0', '2015-06-24 11:14:49', '0', '2015-06-24');
INSERT INTO `user` VALUES ('2', 'roudi1990', 'roudi1990@mail.ru', 'c1dfd96eea8cc2b62785275bca38ac261256e278', 'qq[b3P~-9H', '2015-05-18', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '100000', '0', '0000-00-00 00:00:00', '30', '2015-06-24');
