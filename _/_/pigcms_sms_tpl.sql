/*
Navicat MySQL Data Transfer

Source Server         : upupw
Source Server Version : 50505
Source Host           : localhost:3308
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-07-18 17:37:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pigcms_sms_tpl`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_sms_tpl`;
CREATE TABLE `pigcms_sms_tpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` smallint(2) NOT NULL DEFAULT '0' COMMENT '短信单价',
  `text` text NOT NULL COMMENT '短信内容',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '状态',
  `type` int(5) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_sms_tpl
-- ----------------------------
INSERT INTO `pigcms_sms_tpl` VALUES ('1', '0', '【e点茶】恭喜，您的e点茶商家入驻申请审核通过！店铺名称：{storename}，手机号码：{mobile}，请及时登录并完善店铺信息，咨询电话：13621138883。', '1', '1');
INSERT INTO `pigcms_sms_tpl` VALUES ('2', '0', '【e点茶】抱歉，您的e点茶商家入驻申请审核未通过！未通过原因：{content}，咨询电话：13621138883。', '1', '1');
INSERT INTO `pigcms_sms_tpl` VALUES ('3', '0', '【e点茶】您正在找回e点茶帐号密码，短信验证码是{msg}，如非本人操作，请忽略此短信。', '1', '1');
INSERT INTO `pigcms_sms_tpl` VALUES ('4', '0', '【e点茶】商家入驻提醒，茶馆名称：{storename}，地址：{address}，联系电话{mobile}。', '1', '1');
INSERT INTO `pigcms_sms_tpl` VALUES ('5', '10', '【e点茶】您有一笔退款订单，请及时处理！订单编号：{ordersn}，买家：{name}，退款金额{price}，退款原因{content}', '1', '2');
INSERT INTO `pigcms_sms_tpl` VALUES ('6', '10', '【e点茶】您好，用户{name}报名了您发布的茶会{chname}，请及时登录商家后台处理。', '1', '2');
INSERT INTO `pigcms_sms_tpl` VALUES ('7', '10', '【e点茶】包厢预约提醒，分店名称：{pname}，预约包厢：{bname}，预约人：{name}，到店时间：{times}，请登录商家后台处理。', '1', '2');
INSERT INTO `pigcms_sms_tpl` VALUES ('8', '10', '【{storename}】尊敬的{name}，您的{content}已成功支付，订单号{ordersn}，订单金额{price}元，商家将尽快给您安排发货，请保持电话通畅。如有问题，请及时与我们联系，咨询电话：{tel}。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('9', '10', '【{storename}】您在{storename}购买的{content}还没有付款哦，请及时付款哦。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('10', '10', '【{storename}】您在{storename}购买的{content}已发货，快递{kuaidi}，单号{kdsn}，请注意查收！如有问题，请及时与我们联系，咨询电话：{tel}。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('11', '10', '【{storename}】尊敬的用户您好，您的订单{ordersn}已退款，退款金额{price}，钱款将会2-5个工作日内按原路返还。咨询电话：{tel}。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('12', '10', '【{storename}】恭喜，您报名的茶会：{content}已审核通过，开始时间{times}，凭报名时填写的姓名和手机号即可入场，请准时参加哦。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('13', '10', '【{storename}】抱歉，您报名的茶会：{content}已审核未通过，咨询电话：{tel}。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('14', '10', '【{storename}】尊敬的用户您好，您报名的茶会将在{time}开始，请准时参加哦！咨询电话：{tel}。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('15', '10', '【{storename}】恭喜，您预约的{pname}的包厢{bname}预约成功，到店时间{times}，进店提供姓名和手机号即可，请准时到店消费哦。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('17', '10', '【{storename}】尊敬的用户您好，您预约的{pname}的包厢{bname}，时间快到了哦，到店时间{times}，记得准时参加哦！咨询电话：{tel}。', '1', '3');
INSERT INTO `pigcms_sms_tpl` VALUES ('16', '10', '【{storename}】抱歉，您预约的{pname}的包厢{bname}预约失败，咨询电话：{tel}。', '1', '3');
