DROP TABLE IF EXISTS `guestbook`;
CREATE TABLE `guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `addtime` int(11) NOT NULL,
  `click_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
LOCK TABLES `guestbook` WRITE;
INSERT INTO `guestbook` VALUES (1,'PHP',13242323,23),(2,'go',1322323232,23);
