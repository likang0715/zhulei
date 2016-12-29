/*
Navicat MySQL Data Transfer

Source Server         : upupw
Source Server Version : 50505
Source Host           : localhost:3308
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-07-12 16:24:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pigcms_order_cashier`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_cashier`;
CREATE TABLE `pigcms_order_cashier` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `physical_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店ID',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uid` int(11) NOT NULL COMMENT '购买人uid',
  `openid` varchar(50) DEFAULT NULL COMMENT '支付人openid',
  `pay_no` varchar(100) DEFAULT NULL COMMENT '短信支付订单号，格式：SMSPAY_生成另外订单号',
  `trade_no` varchar(100) NOT NULL COMMENT '交易流水号 ',
  `price` int(11) DEFAULT '0' COMMENT '订单金额',
  `money` float(8,2) NOT NULL COMMENT '支付金额',
  `name` varchar(50) DEFAULT NULL COMMENT '支付人姓名',
  `content` varchar(255) DEFAULT NULL COMMENT '支付人留言',
  `pay_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `third_id` varchar(100) NOT NULL COMMENT '第三方支付ID',
  `third_data` text NOT NULL COMMENT '第三方支付返回内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态，0：未支付，1：已支付',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='短信订单表';

-- ----------------------------
-- Records of pigcms_order_cashier
-- ----------------------------
INSERT INTO `pigcms_order_cashier` VALUES ('1', '0', '0', '1466141506', '8', null, 'SMSPAY_20160617133146101842', '', '10', '100.00', null, null, '0', '', '', '0');
INSERT INTO `pigcms_order_cashier` VALUES ('2', '0', '0', '1466393385', '18', null, 'SMSPAY_20160620112945643550', '', '10', '100.00', null, null, '0', '', '', '0');
