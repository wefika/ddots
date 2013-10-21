/*
 Navicat Premium Data Transfer

 Source Server         : Local MySQL
 Source Server Type    : MySQL
 Source Server Version : 50613
 Source Host           : localhost
 Source Database       : fikadb

 Target Server Type    : MySQL
 Target Server Version : 50613
 File Encoding         : utf-8

 Date: 10/21/2013 09:52:51 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `bunch`
-- ----------------------------
DROP TABLE IF EXISTS `bunch`;
CREATE TABLE `bunch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(45) NOT NULL,
  `time` varchar(45) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `uniquehash` varchar(45) NOT NULL,
  `location` varchar(45) NOT NULL,
  `img` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `recipients`
-- ----------------------------
DROP TABLE IF EXISTS `recipients`;
CREATE TABLE `recipients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bunch_id` int(11) NOT NULL,
  `recipient` varchar(45) NOT NULL,
  `hash` varchar(45) NOT NULL,
  `accepted` int(11) NOT NULL DEFAULT '0',
  `dateresponded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
