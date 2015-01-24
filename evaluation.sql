/*
 Navicat Premium Data Transfer

 Source Server         : evaluation
 Source Server Type    : MySQL
 Source Server Version : 50161
 Source Host           : 127.0.0.1
 Source Database       : evaluation

 Target Server Type    : MySQL
 Target Server Version : 50161
 File Encoding         : utf-8

 Date: 01/25/2015 02:05:08 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `sv_courses`
-- ----------------------------
DROP TABLE IF EXISTS `sv_courses`;
CREATE TABLE `sv_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courseid` varchar(255) DEFAULT NULL,
  `coursename` varchar(255) DEFAULT NULL,
  `teacher` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71296 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sv_evaluation`
-- ----------------------------
DROP TABLE IF EXISTS `sv_evaluation`;
CREATE TABLE `sv_evaluation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `comment` text,
  `is_deleted` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `sv_stat`
-- ----------------------------
DROP TABLE IF EXISTS `sv_stat`;
CREATE TABLE `sv_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `views` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=605 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;
