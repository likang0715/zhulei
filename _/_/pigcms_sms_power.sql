/*
Navicat MySQL Data Transfer

Source Server         : upupw
Source Server Version : 50505
Source Host           : localhost:3308
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-07-18 17:13:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pigcms_sms_power`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_sms_power`;
CREATE TABLE `pigcms_sms_power` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '操作的店铺id',
  `type` int(11) NOT NULL COMMENT '发送的时间戳',
  `status` int(5) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_sms_power
-- ----------------------------
INSERT INTO `pigcms_sms_power` VALUES ('1', '26', '1', '1');
INSERT INTO `pigcms_sms_power` VALUES ('2', '28', '1', '1');
INSERT INTO `pigcms_sms_power` VALUES ('3', '30', '1', '1');
