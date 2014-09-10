/*
Navicat MySQL Data Transfer

Source Server         : localhost2
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : movies

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2014-09-12 01:46:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `movies`
-- ----------------------------
DROP TABLE IF EXISTS `movies`;
CREATE TABLE `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imdb_id` varchar(12) DEFAULT NULL,
  `rank` tinyint(4) DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `title` longtext,
  `year` int(4) DEFAULT NULL,
  `number_of_votes` varchar(20) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;


