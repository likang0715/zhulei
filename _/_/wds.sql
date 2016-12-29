/*
Navicat MySQL Data Transfer

Source Server         : xampp
Source Server Version : 50090
Source Host           : localhost:3306
Source Database       : wds

Target Server Type    : MYSQL
Target Server Version : 50090
File Encoding         : 65001

Date: 2016-06-02 15:47:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pigcms_access_token_expires`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_access_token_expires`;
CREATE TABLE `pigcms_access_token_expires` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `access_token` varchar(700) NOT NULL,
  `expires_in` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_access_token_expires
-- ----------------------------
INSERT INTO `pigcms_access_token_expires` VALUES ('1', '4YpN6XV0O1nZfDuEsEqumdl_6cj0AP_z3e1DJDqqY_5P2fa-q5Aar_baevS_dxwbGSjhCaiwZ64Q0zqaWHZw9Q9o7eEjwiC0j1m6NRAX4ig', '1440042387');

-- ----------------------------
-- Table structure for `pigcms_admin`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_admin`;
CREATE TABLE `pigcms_admin` (
  `id` int(11) NOT NULL auto_increment,
  `account` char(20) NOT NULL,
  `pwd` char(32) NOT NULL,
  `realname` char(20) NOT NULL,
  `phone` char(20) NOT NULL,
  `email` char(20) NOT NULL,
  `qq` char(20) NOT NULL,
  `last_ip` bigint(20) NOT NULL,
  `last_time` int(11) NOT NULL,
  `login_count` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_admin
-- ----------------------------
INSERT INTO `pigcms_admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '微聚网络', '13309160049', '6421896@qq.com', '6421896', '2130706433', '1450850511', '86', '1');

-- ----------------------------
-- Table structure for `pigcms_adver`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_adver`;
CREATE TABLE `pigcms_adver` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `bg_color` varchar(30) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_id` (`cat_id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_adver
-- ----------------------------
INSERT INTO `pigcms_adver` VALUES ('38', '首页幻灯片三', 'http://shop.hweiju.com/category/1', 'adver/2015/08/55d563da922ab.png', '', '1', '1', '1440048261');
INSERT INTO `pigcms_adver` VALUES ('2', '广告1', 'http://shop.hweiju.com/category/1', 'adver/2015/06/5570fd45bcffc.png', '', '3', '1', '1433468229');
INSERT INTO `pigcms_adver` VALUES ('3', '广告2', 'http://shop.hweiju.com/category/1', 'adver/2015/06/5570fcddac14a.jpg', '', '3', '1', '1433468238');
INSERT INTO `pigcms_adver` VALUES ('6', '首页幻灯片六', 'http://shop.hweiju.com/category/1', 'adver/2015/08/55d56372e0d55.png', '#FE3875', '1', '1', '1440048281');
INSERT INTO `pigcms_adver` VALUES ('7', '首页幻灯片五', 'http://shop.hweiju.com/category/1', 'adver/2015/08/55d563687de72.png', '#6F41E1', '1', '1', '1440048275');
INSERT INTO `pigcms_adver` VALUES ('8', '广告1', 'http://shop.hweiju.com/category/1', 'adver/2015/05/555d51953df1a.jpg', '', '4', '1', '1432179093');
INSERT INTO `pigcms_adver` VALUES ('9', '广告1', 'http://shop.hweiju.com/account.php', 'adver/2015/08/55d562dbc058b.gif', '', '5', '1', '1440047835');
INSERT INTO `pigcms_adver` VALUES ('10', '首页楼层广告内容-1', 'http://shop.hweiju.com/category/1', 'adver/2015/05/555ef241c80be.png', '', '6', '1', '1432285761');
INSERT INTO `pigcms_adver` VALUES ('11', 'pc-首页楼层广告位-2', 'http://shop.hweiju.com/category/1', 'adver/2015/05/555ef2973d975.png', '', '6', '1', '1432285847');
INSERT INTO `pigcms_adver` VALUES ('12', '今日推荐-广告1', 'http://shop.hweiju.com/category/1', 'adver/2015/05/555efe7caa45b.jpg', '', '7', '1', '1432288892');
INSERT INTO `pigcms_adver` VALUES ('13', '首页幻灯片右侧广告-1', 'http://shop.hweiju.com/category/1', 'adver/2015/05/555f043ce121f.png', '', '8', '1', '1432290364');
INSERT INTO `pigcms_adver` VALUES ('14', '首页幻灯片右侧广告-2', 'http://shop.hweiju.com/category/1', 'adver/2015/05/555f04512b6c3.png', '', '8', '1', '1432290385');
INSERT INTO `pigcms_adver` VALUES ('15', '首页幻灯片四', 'http://shop.hweiju.com/category/1', 'adver/2015/08/55d5635c6f8ad.png', '#110E1F', '1', '1', '1440048268');
INSERT INTO `pigcms_adver` VALUES ('16', '今日推荐-广告2', 'http://shop.hweiju.com/category/1', 'adver/2015/05/5563de912e533.jpg', '', '7', '1', '1432608401');
INSERT INTO `pigcms_adver` VALUES ('17', '今日推荐-广告3', 'http://shop.hweiju.com/category/1', 'adver/2015/05/5563dee021d8f.jpg', '', '7', '1', '1432608480');
INSERT INTO `pigcms_adver` VALUES ('18', '今日推荐-广告4', 'http://shop.hweiju.com/category/1', 'adver/2015/05/5563df3586e25.jpg', '', '7', '1', '1432608565');
INSERT INTO `pigcms_adver` VALUES ('19', 'pc-首页楼层广告位-3', 'http://shop.hweiju.com/category/1', 'adver/2015/05/5563e04087e2d.png', '', '6', '1', '1432608832');
INSERT INTO `pigcms_adver` VALUES ('20', 'pc-首页楼层广告位-4', 'http://shop.hweiju.com/category/1', 'adver/2015/05/5563e0abbfb71.png', '', '6', '1', '1432608939');
INSERT INTO `pigcms_adver` VALUES ('22', 'pc-首页楼层广告位-6', 'http://shop.hweiju.com/category/1', 'adver/2015/05/5563e22f1cd5d.jpg', '', '6', '1', '1432609327');
INSERT INTO `pigcms_adver` VALUES ('5', '你猜', 'http://shop.hweiju.com/wap/category.php?keyword=女装&id=2', 'adver/2015/07/55ae00bfd9329.jpg', '', '2', '1', '1437466815');
INSERT INTO `pigcms_adver` VALUES ('25', '时尚女装', 'http://shop.hweiju.com/wap/category.php?keyword=女装&id=2', 'adver/2015/06/5571010f38388.jpg', '', '2', '1', '1433469237');
INSERT INTO `pigcms_adver` VALUES ('4', '制服大牌', 'http://shop.hweiju.com/wap/category.php?keyword=女装&id=2', 'adver/2015/06/55710117a44e9.jpg', '', '2', '1', '1433469270');
INSERT INTO `pigcms_adver` VALUES ('32', '我要送礼', 'http://shop.hweiju.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7ae7ce478.png', '', '13', '1', '1438415591');
INSERT INTO `pigcms_adver` VALUES ('33', '降价拍', 'http://shop.hweiju.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7b05f170a.png', '', '13', '1', '1438415621');
INSERT INTO `pigcms_adver` VALUES ('34', '一元夺宝', 'http://shop.hweiju.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7b205d36a.png', '', '13', '1', '1438415648');
INSERT INTO `pigcms_adver` VALUES ('35', '众筹', 'http://shop.hweiju.com/index.php?c=activity&a=index', 'adver/2015/08/55d564dec50f4.png', '', '13', '1', '1440048350');
INSERT INTO `pigcms_adver` VALUES ('36', '限时秒杀', 'http://shop.hweiju.com/index.php?c=activity&a=index', 'adver/2015/08/55d564d52c6b3.png', '', '13', '1', '1440048341');
INSERT INTO `pigcms_adver` VALUES ('37', '超级砍价', 'http://shop.hweiju.com/index.php?c=activity&a=index', 'adver/2015/08/55d564cb19781.png', '', '13', '1', '1440048331');
INSERT INTO `pigcms_adver` VALUES ('39', '首页幻灯片二', 'http://shop.hweiju.com', 'adver/2015/08/55d5644fe9d09.png', '', '1', '1', '1440048253');
INSERT INTO `pigcms_adver` VALUES ('40', '首页幻灯片一', 'http://shop.hweiju.com', 'adver/2015/08/55d5646268869.png', '', '1', '1', '1440048245');

-- ----------------------------
-- Table structure for `pigcms_adver_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_adver_category`;
CREATE TABLE `pigcms_adver_category` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_name` char(20) NOT NULL,
  `cat_key` char(20) NOT NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_adver_category
-- ----------------------------
INSERT INTO `pigcms_adver_category` VALUES ('1', 'pc-首页幻灯片', 'pc_index_slide');
INSERT INTO `pigcms_adver_category` VALUES ('2', 'wap-首页头部幻灯片(6)', 'wap_index_slide_top');
INSERT INTO `pigcms_adver_category` VALUES ('3', 'wap-首页热门品牌下方广告（2）', 'wap_index_brand');
INSERT INTO `pigcms_adver_category` VALUES ('4', 'pc-登陆页广告位', 'pc_login_pic');
INSERT INTO `pigcms_adver_category` VALUES ('5', 'pc-公用头部右侧广告位（1）', 'pc_index_top_right');
INSERT INTO `pigcms_adver_category` VALUES ('6', 'pc-首页楼层广告位（6）', 'pc_floor_inslide');
INSERT INTO `pigcms_adver_category` VALUES ('7', 'pc-首页今日推荐', 'pc_today');
INSERT INTO `pigcms_adver_category` VALUES ('8', '幻灯片-右侧广告', 'pc_index_slide_right');
INSERT INTO `pigcms_adver_category` VALUES ('9', 'pc-活动页头部幻灯片（6）', 'pc_activity_slider');
INSERT INTO `pigcms_adver_category` VALUES ('10', 'pc-活动页今日推荐（1）', 'pc_activity_rec');
INSERT INTO `pigcms_adver_category` VALUES ('11', 'pc-活动页热门活动（4）', 'pc_activity_hot');
INSERT INTO `pigcms_adver_category` VALUES ('12', 'pc-活动页附近活动（4）', 'pc_activity_nearby');
INSERT INTO `pigcms_adver_category` VALUES ('13', 'pc-首页活动广告', 'pc_index_activity');

-- ----------------------------
-- Table structure for `pigcms_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_attachment`;
CREATE TABLE `pigcms_attachment` (
  `pigcms_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `from` tinyint(1) NOT NULL default '0' COMMENT '0为上传，1为导入，2为收藏',
  `type` tinyint(1) NOT NULL default '0' COMMENT '0为图片，1为语音，2为视频',
  `file` varchar(100) NOT NULL COMMENT '文件地址',
  `size` bigint(20) NOT NULL COMMENT '尺寸，byte字节',
  `width` int(11) NOT NULL COMMENT '图片宽度',
  `height` int(11) NOT NULL COMMENT '图片高度',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL default '1' COMMENT '状态',
  `ip` bigint(20) NOT NULL default '0' COMMENT '用户IP地址',
  `agent` varchar(1024) NOT NULL COMMENT '用户浏览器信息',
  PRIMARY KEY  (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=337 DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of pigcms_attachment
-- ----------------------------
INSERT INTO `pigcms_attachment` VALUES ('298', '27', '002.png', '0', '0', 'images/000/000/027/201508/55d4819fb0587.png', '155921', '399', '709', '1439990174', '1', '720577822', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('299', '29', 'sssd.JPG', '0', '0', 'images/000/000/029/201508/55d483b4030ad.JPG', '105357', '747', '422', '1439990706', '1', '454626635', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.130 UBrowser/5.3.3996.0 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('300', '36', 'Chrysanthemum.jpg', '0', '0', 'images/000/000/036/201509/55f66bf125f2a.jpg', '219985', '1024', '768', '1442212849', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('301', '36', 'Koala.jpg', '0', '0', 'images/000/000/036/201509/55f6942581e9d.jpg', '253359', '1024', '768', '1442223141', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('302', '36', 'Koala.jpg', '0', '0', 'images/000/000/036/201509/55f6946016553.jpg', '253359', '1024', '768', '1442223200', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('303', '37', 'Desert.jpg', '0', '0', 'images/000/000/037/201509/55f698a442a30.jpg', '233114', '1024', '768', '1442224292', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('304', '37', 'Jellyfish.jpg', '0', '0', 'images/000/000/037/201509/55f69b09084c7.jpg', '135494', '1024', '768', '1442224905', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('305', '37', 'Hydrangeas.jpg', '0', '0', 'images/000/000/037/201509/55f69c6e5ca27.jpg', '162953', '1024', '768', '1442225262', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('306', '37', 'Desert.jpg', '0', '0', 'images/000/000/037/201509/55f7cde8151b1.jpg', '233114', '1024', '768', '1442303464', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('307', '37', 'Chrysanthemum.jpg', '0', '0', 'images/000/000/037/201509/55f7cdfa879f0.jpg', '219985', '1024', '768', '1442303482', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('308', '37', 'Desert.jpg', '0', '0', 'images/000/000/037/201509/55f7db07ecf7e.jpg', '233114', '1024', '768', '1442306823', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('309', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201509/55f7db0991703.jpg', '253359', '1024', '768', '1442306825', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('310', '37', 'Hydrangeas.jpg', '0', '0', 'images/000/000/037/201509/55f7db0b1a519.jpg', '162953', '1024', '768', '1442306827', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('311', '37', 'Jellyfish.jpg', '0', '0', 'images/000/000/037/201509/55f7db56288cf.jpg', '135494', '1024', '768', '1442306902', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('312', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201509/55f7dd5edd67f.jpg', '253359', '1024', '768', '1442307422', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('313', '37', 'Jellyfish.jpg', '0', '0', 'images/000/000/037/201509/55f7dd9ac900a.jpg', '135494', '1024', '768', '1442307482', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('314', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201509/55f7de0659b61.jpg', '253359', '1024', '768', '1442307590', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('315', '37', 'Desert.jpg', '0', '0', 'images/000/000/037/201509/55f7dec825bad.jpg', '233114', '1024', '768', '1442307784', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('316', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201509/55f7e0a61e7d1.jpg', '253359', '1024', '768', '1442308262', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('317', '37', 'Jellyfish.jpg', '0', '0', 'images/000/000/037/201509/55f7e0ae3f512.jpg', '135494', '1024', '768', '1442308270', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('318', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201509/55f7e153bda6d.jpg', '253359', '1024', '768', '1442308435', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('319', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201509/55f7e180c3e54.jpg', '253359', '1024', '768', '1442308480', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('320', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201509/55f7e194d7b51.jpg', '253359', '1024', '768', '1442308500', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('321', '37', 'Chrysanthemum.jpg', '0', '0', 'images/000/000/037/201509/55f7e31496824.jpg', '219985', '1024', '768', '1442308884', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('322', '37', 'Chrysanthemum.jpg', '0', '0', 'images/000/000/037/201509/55f7e45c40c0a.jpg', '219985', '1024', '768', '1442309212', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('323', '37', 'Desert.jpg', '0', '0', 'images/000/000/037/201509/55f7e4e7db88c.jpg', '233114', '1024', '768', '1442309351', '0', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('324', '37', 'Desert.jpg', '0', '0', 'images/000/000/037/201509/55f92c900830f.jpg', '233114', '1024', '768', '1442393232', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('325', '37', 'Chrysanthemum.jpg', '0', '0', 'images/000/000/037/201509/55fa196c81d52.jpg', '219985', '1024', '768', '1442453868', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('326', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201510/561b6d6ed2f07.jpg', '253359', '1024', '768', '1444638062', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('327', '37', 'Chrysanthemum.jpg', '0', '0', 'images/000/000/037/201510/561b6e69d43f4.jpg', '219985', '1024', '768', '1444638313', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('328', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201510/561b6eb41c781.jpg', '253359', '1024', '768', '1444638388', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('329', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201510/561b6ef347d50.jpg', '253359', '1024', '768', '1444638451', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('330', '37', 'Koala.jpg', '0', '0', 'images/000/000/037/201510/561b6f40af73c.jpg', '253359', '1024', '768', '1444638528', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('331', '37', 'Jellyfish.jpg', '0', '0', 'images/000/000/037/201510/561b6fa673980.jpg', '135494', '1024', '768', '1444638630', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('332', '37', 'Hydrangeas.jpg', '0', '0', 'images/000/000/037/201510/561b6fe0ee3cb.jpg', '162953', '1024', '768', '1444638688', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('333', '38', '988524.jpeg', '0', '0', 'images/000/000/038/201512/5680e4e12f26d.jpeg', '94682', '362', '1127', '1451287777', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('334', '38', 'Chrysanthemum.jpg', '0', '0', 'images/000/000/038/201512/5680e50245d4b.jpg', '219955', '1024', '768', '1451287810', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('335', '38', 'Desert.jpg', '0', '0', 'images/000/000/038/201512/5680e51681708.jpg', '233021', '1024', '768', '1451287830', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('336', '38', 'Chrysanthemum.jpg', '0', '0', 'images/000/000/038/201512/5680ffc6ac992.jpg', '219955', '1024', '768', '1451294662', '1', '2130706433', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.152 Safari/537.36');

-- ----------------------------
-- Table structure for `pigcms_attachment_user`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_attachment_user`;
CREATE TABLE `pigcms_attachment_user` (
  `pigcms_id` int(11) NOT NULL auto_increment COMMENT '自增ID',
  `uid` int(11) NOT NULL COMMENT 'UID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `from` tinyint(1) NOT NULL default '0' COMMENT '0为上传，1为导入，2为收藏',
  `type` tinyint(1) NOT NULL default '0' COMMENT '0为图片，1为语音，2为视频',
  `file` varchar(100) NOT NULL COMMENT '文件地址',
  `size` bigint(20) NOT NULL COMMENT '尺寸，byte字节',
  `width` int(11) NOT NULL COMMENT '图片宽度',
  `height` int(11) NOT NULL COMMENT '图片高度',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL default '1' COMMENT '状态',
  `ip` bigint(20) NOT NULL default '0' COMMENT '用户IP地址',
  `agent` varchar(1024) NOT NULL COMMENT '用户浏览器信息',
  PRIMARY KEY  (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员附件表';

-- ----------------------------
-- Records of pigcms_attachment_user
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_bank`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_bank`;
CREATE TABLE `pigcms_bank` (
  `bank_id` int(5) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '' COMMENT '名称',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态 0启用 1禁用',
  PRIMARY KEY  (`bank_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='银行';

-- ----------------------------
-- Records of pigcms_bank
-- ----------------------------
INSERT INTO `pigcms_bank` VALUES ('1', '中国工商银行', '1');
INSERT INTO `pigcms_bank` VALUES ('2', '中国农业银行', '1');
INSERT INTO `pigcms_bank` VALUES ('3', '中国银行', '1');
INSERT INTO `pigcms_bank` VALUES ('4', '中国建设银行', '1');
INSERT INTO `pigcms_bank` VALUES ('5', '交通银行', '1');

-- ----------------------------
-- Table structure for `pigcms_business_hour`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_business_hour`;
CREATE TABLE `pigcms_business_hour` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL default '0' COMMENT '店铺ID',
  `business_time` varchar(100) default '' COMMENT '营业时间',
  `is_open` tinyint(4) unsigned NOT NULL default '1' COMMENT '是否开启',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_business_hour
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_chahui`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_chahui`;
CREATE TABLE `pigcms_chahui` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `sttime` text,
  `endtime` text,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `county` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `long` decimal(10,6) NOT NULL,
  `lat` decimal(10,6) NOT NULL,
  `last_time` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `images` varchar(500) NOT NULL,
  `renshu` varchar(200) NOT NULL,
  `description` text,
  `price` text,
  `tickets` int(10) default NULL,
  `zt` text,
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_chahui
-- ----------------------------
INSERT INTO `pigcms_chahui` VALUES ('4', '37', '010', '88888839', '110000', '110100', '110101', '啊撒的发反反复复反复烦烦烦', '116.437190', '39.935091', '1444637351', '北京朝阳大忠臣店', 'images/000/000/037/201509/55fa196c81d52.jpg,images/000/000/037/201509/55f92c900830f.jpg', '8:00-17:00', '大厦法定', 'https://www.baidu.com/', '1', null);
INSERT INTO `pigcms_chahui` VALUES ('5', '37', '010', '666666', '110000', '110100', '110101', '啊的撒发生大幅', '116.404150', '39.923389', '1444637359', '北京天安门店', 'images/000/000/037/201509/55f92c900830f.jpg', '', '', '', '2', null);
INSERT INTO `pigcms_chahui` VALUES ('6', '37', '', '1323123123', '110000', '110100', '110106', 'adfasdfasdfasdf ', '116.409925', '39.913393', '1444637365', '精品蔬菜', 'images/000/000/037/201509/55fa196c81d52.jpg', '', '', 'https://www.baidu.com/', '3', null);
INSERT INTO `pigcms_chahui` VALUES ('7', '38', '', '', '', '', '', '', '0.000000', '0.000000', '1451295721', '', 'images/000/000/038/201512/5680e51681708.jpg', '', '', '', '0', null);
INSERT INTO `pigcms_chahui` VALUES ('8', '38', '', '', '', '', '', '', '0.000000', '0.000000', '1451295788', '', 'images/000/000/038/201512/5680e50245d4b.jpg', '', '', '', '0', null);
INSERT INTO `pigcms_chahui` VALUES ('9', '38', '', '', '', '', '', '', '0.000000', '0.000000', '1451295901', '22222222222', 'images/000/000/038/201512/5680e50245d4b.jpg', '', '', '', '0', null);
INSERT INTO `pigcms_chahui` VALUES ('10', '38', '', '', '130000', '130300', '130304', '北京', '119.491109', '39.840968', '1451296595', '爱的方式是是是是', 'images/000/000/038/201512/5680e51681708.jpg', '12', '阿士大夫', '', '1', null);
INSERT INTO `pigcms_chahui` VALUES ('11', '38', '2015-12-08 00:00:00', '2016-01-19 00:00:00', '150000', '150200', '150205', '北京大师傅反反复复反复反复反反复复反复', '116.413554', '39.911013', '1451296662', '大法师的法师打发阿萨德法师大发', 'images/000/000/038/201512/5680e50245d4b.jpg', '12', '发的顶顶顶顶顶顶顶顶顶顶', '', '2', null);
INSERT INTO `pigcms_chahui` VALUES ('12', '36', '2015-12-01 00:00:00', '2016-01-25 00:00:00', '110000', '110100', '110105', '鸟巢', '116.402131', '39.999448', '1451355732', '不错的茶会啊阿士大夫阿萨德', 'images/000/000/036/201509/55f6942581e9d.jpg', '12', '阿斯顿发送到发送到', '21312', '2', '');
INSERT INTO `pigcms_chahui` VALUES ('13', '36', '', '', '110000', '110100', '110101', '水立方', '112.463626', '34.634831', '1451355924', '爱奥德赛烦烦烦烦烦烦烦发', 'images/000/000/036/201509/55f6942581e9d.jpg', '', '', '', '1', '');
INSERT INTO `pigcms_chahui` VALUES ('14', '36', '', '', '110000', '110100', '110102', '王府井', '116.351997', '39.913514', '1451356693', '奥德赛烦烦烦烦烦烦烦烦烦烦发', 'images/000/000/036/201509/55f66bf125f2a.jpg', '14', '阿凡达是是是是是是是是是', '2321', '2', '');
INSERT INTO `pigcms_chahui` VALUES ('15', '36', '', '', '110000', '110100', '110101', '方式大发', '117.092378', '36.207827', '1451356715', '挨打反反复复反复反复', 'images/000/000/036/201509/55f6942581e9d.jpg', '', '', '', '1', '');

-- ----------------------------
-- Table structure for `pigcms_chahui_bm`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_chahui_bm`;
CREATE TABLE `pigcms_chahui_bm` (
  `cid` int(30) NOT NULL auto_increment,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pigcms_chahui_bm
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_comment`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_comment`;
CREATE TABLE `pigcms_comment` (
  `id` int(11) NOT NULL auto_increment,
  `dateline` int(11) unsigned NOT NULL default '0' COMMENT '评论时间',
  `order_id` int(11) NOT NULL default '0' COMMENT '订单表ID,对产品评论时，要加订单ID，其它为0',
  `relation_id` int(11) NOT NULL default '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',
  `uid` int(11) NOT NULL default '0' COMMENT '会员ID',
  `score` tinyint(1) NOT NULL default '5' COMMENT '满意度，1-5，数值越大，满意度越高',
  `logistics_score` tinyint(1) NOT NULL default '5' COMMENT '物流满意度，1-5，数值越大，满意度越高',
  `description_score` tinyint(1) NOT NULL default '5' COMMENT '描述相符，1-5，数值越大，满意度越高',
  `speed_score` tinyint(1) NOT NULL default '5' COMMENT '发货速度，1-5，数值越大，满意度越高',
  `service_score` tinyint(1) NOT NULL default '5' COMMENT '服务态度，1-5，数值越大，满意度越高',
  `type` enum('PRODUCT','STORE') NOT NULL default 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',
  `has_image` tinyint(1) NOT NULL default '0' COMMENT '是否有图片，1为有，0为没有',
  `content` text NOT NULL COMMENT '评论内容',
  `reply_number` int(11) NOT NULL default '0' COMMENT '回复数',
  `delete_flg` tinyint(1) NOT NULL default '0' COMMENT '删除标记，1：删除，0：未删除',
  UNIQUE KEY `id` (`id`),
  KEY `relation_id` USING BTREE (`relation_id`),
  KEY `order_id` USING BTREE (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论表';

-- ----------------------------
-- Records of pigcms_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_comment_tag`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_comment_tag`;
CREATE TABLE `pigcms_comment_tag` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0' COMMENT '评论表ID',
  `tag_id` int(11) NOT NULL default '0' COMMENT '系统标签表ID',
  `relation_id` int(11) NOT NULL default '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',
  `type` enum('PRODUCT','STORE') NOT NULL default 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',
  `delete_flg` tinyint(1) NOT NULL default '0' COMMENT '删除标记，1：删除，0：未删除',
  UNIQUE KEY `id` (`id`),
  KEY `cid` USING BTREE (`cid`),
  KEY `tag_id` USING BTREE (`tag_id`,`relation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_comment_tag
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_company`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_company`;
CREATE TABLE `pigcms_company` (
  `company_id` int(10) NOT NULL auto_increment COMMENT '公司id',
  `uid` int(10) NOT NULL default '0' COMMENT '用户id',
  `name` varchar(50) NOT NULL default '' COMMENT '公司名',
  `province` varchar(30) NOT NULL default '' COMMENT '省',
  `city` varchar(30) NOT NULL default '' COMMENT '市',
  `area` varchar(30) NOT NULL default '' COMMENT '区',
  `address` varchar(500) NOT NULL default '' COMMENT '地址',
  PRIMARY KEY  (`company_id`),
  KEY `uid` USING BTREE (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_company
-- ----------------------------
INSERT INTO `pigcms_company` VALUES ('26', '73', '汉中微聚网络科技有限公司', '610000', '610700', '610702', '荔枝路951号');
INSERT INTO `pigcms_company` VALUES ('27', '74', '汉中微聚网络科技有限公司', '610000', '610700', '610702', '陕西省汉中市汉台区陕南电子城一层1120-1121号');
INSERT INTO `pigcms_company` VALUES ('28', '75', '汉中微聚网络科技有限公司', '130000', '130500', '130522', '陕西省汉中市汉台区陕南电子城一层1120-1121号');
INSERT INTO `pigcms_company` VALUES ('29', '76', '大胸公司', '110000', '110100', '110101', '啊撒的发反反复复反复烦烦烦');
INSERT INTO `pigcms_company` VALUES ('30', '77', '12312312', '110000', '110100', '110101', '12312312');

-- ----------------------------
-- Table structure for `pigcms_config`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_config`;
CREATE TABLE `pigcms_config` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `type` varchar(150) NOT NULL COMMENT '多个默认值用|分隔',
  `value` text NOT NULL,
  `info` varchar(20) NOT NULL,
  `desc` varchar(250) NOT NULL,
  `tab_id` varchar(20) NOT NULL default '0' COMMENT '小分组ID',
  `tab_name` varchar(20) NOT NULL COMMENT '小分组名称',
  `gid` int(11) NOT NULL,
  `sort` int(11) NOT NULL default '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `gid` USING BTREE (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='配置表';

-- ----------------------------
-- Records of pigcms_config
-- ----------------------------
INSERT INTO `pigcms_config` VALUES ('1', 'site_name', 'type=text&validate=required:true', '汉中微聚网络-微店系统', '网站名称', '网站的名称', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('2', 'site_url', 'type=text&validate=required:true,url:true', 'http://www.ooxx.com', '网站网址', '请填写网站的网址，包含（http://域名）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('3', 'site_logo', 'type=image&validate=required:true,url:true', 'http://www.ooxx.com/upload/images/000/000/001/55d55fca4eb9c.png', '网站LOGO', '请填写LOGO的网址，包含（http://域名）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('4', 'site_qq', 'type=text&validate=qq:true', '6421896', '联系QQ', '前台涉及到需要显示QQ的地方，将显示此值！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('5', 'site_email', 'type=text&validate=email:true', '6421896@qq.com', '联系邮箱', '前台涉及到需要显示邮箱的地方，将显示此值！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('6', 'site_icp', 'type=text', '陕ICP备14000655号-4', 'ICP备案号', '可不填写。放置于大陆的服务器，需要网站备案。', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('7', 'seo_title', 'type=text&size=80&validate=required:true', '汉中微聚网络-微店系统', 'SEO标题', '一般不超过80个字符！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('8', 'seo_keywords', 'type=text&size=80', '汉中微聚网络-微店系统', 'SEO关键词', '一般不超过100个字符！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('9', 'seo_description', 'type=textarea&rows=4&cols=93', '汉中微聚网络-微店系统是帮助商家在微信上搭建微信商城的平台，提供店铺、商品、订单、物流、消息和客户的管理模块，同时还提供丰富的营销应用和活动插件。', 'SEO描述', '一般不超过200个字符！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('10', 'site_footer', 'type=textarea&rows=6&cols=93', 'Copyright 2015 © 汉中微聚网络科技有限公司 版权所有', '网站底部信息', '可填写统计、客服等HTML代码，代码前台隐藏不可见！！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('11', 'register_check_phone', 'type=radio&value=1:验证|0:不验证', '0', '验证手机', '注册时是否发送短信验证手机号码！请确保短信配置成功。', '0', '', '1', '0', '0');
INSERT INTO `pigcms_config` VALUES ('12', 'register_phone_again_time', 'type=text&size=10&validate=required:true', '60', '注册短信间隔时间', '注册再次发送短信的间隔时间', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('13', 'theme_user_group', '', 'default', '', '', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('14', 'trade_pay_cancel_time', 'type=text&size=10&validate=required:true', '30', '默认自动取消订单时间', '默认自动取消订单时间，填0表示关闭该功能', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('15', 'trade_pay_alert_time', 'type=text&size=10&validate=required:true', '20', '默认自动催付订单时间', '默认自动催付订单时间，填0表示关闭该功能', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('16', 'trade_sucess_notice', 'type=radio&value=1:通知|0:不通知', '1', '支付成功是否通知用户', '支付成功是否通知用户', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('17', 'trade_send_notice', 'type=radio&value=1:通知|0:不通知', '1', '发货是否通知用户', '发货是否通知用户', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('18', 'trade_complain_notice', 'type=radio&value=1:通知|0:不通知', '1', '维权通知是否通知用户', '维权通知是否通知用户', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('19', 'ucenter_page_title', 'type=text&size=80&validate=required:true,maxlength:50', '会员主页', '默认页面名称', '如果店铺没有填写页面名称，默认值', '0', '会员主页', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('20', 'ucenter_bg_pic', 'type=text&size=80&validate=required:true', 'default_ucenter.jpg', '默认背景图', '如果店铺没有上传背景图，默认值', '0', '会员主页', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('21', 'ucenter_show_level', 'type=radio&value=1:显示|0:不显示', '1', '默认是否显示等级', '店铺在没有修改之前，默认是否显示等级', '0', '会员主页', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('22', 'ucenter_show_point', 'type=radio&value=1:显示|0:不显示', '1', '默认是否显示积分', '店铺在没有修改之前，默认是否显示积分', '0', '会员主页', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('23', 'wap_site_url', 'type=text&size=80&validate=required:true', 'http://www.ooxx.com/wap', '手机版网站网址', '手机版网站网址，可使用二级域名', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('24', 'theme_wap_group', 'type=select&value=default:默认|theme1:其他', 'default', '平台商城模板', '选择非“默认模板”选项后“平台商城首页内容”设置将无法生效', '0', '', '11', '0', '0');
INSERT INTO `pigcms_config` VALUES ('25', 'wx_token', 'type=text', '', '公众号消息校验Token', '公众号消息校验Token', '0', '', '13', '0', '1');
INSERT INTO `pigcms_config` VALUES ('26', 'wx_appsecret', 'type=text', '', '网页授权AppSecret', '网页授权AppSecret', '0', '', '13', '0', '1');
INSERT INTO `pigcms_config` VALUES ('27', 'wx_appid', 'type=text', '', '网页授权AppID', '网页授权AppID', '0', '', '13', '0', '1');
INSERT INTO `pigcms_config` VALUES ('28', 'wx_componentverifyticket', 'type=text', 'ticket@@@1pcH5efAO-gjfuZc9ShPFxSIevu3X1bP2dXIz4-7X3BscyRtTVwFg291Oex65T3cHmXFNGejd8-xuhFuR3ltwA', '', '', '0', '', '0', '0', '1');
INSERT INTO `pigcms_config` VALUES ('29', 'orderid_prefix', 'type=text&size=20', 'PIG', '订单号前缀', '用户看到的订单号 = 订单号前缀+订单号', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('30', 'pay_alipay_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'alipay', '支付宝', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('31', 'pay_alipay_name', 'type=text&size=80', '', '帐号', '', 'alipay', '支付宝', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('32', 'pay_alipay_pid', 'type=text&size=80', '', 'PID', '', 'alipay', '支付宝', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('33', 'pay_alipay_key', 'type=text&size=80', '', 'KEY', '', 'alipay', '支付宝', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('34', 'pay_tenpay_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'tenpay', '财付通', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('35', 'pay_tenpay_partnerid', 'type=text&size=80', '', '商户号', '', 'tenpay', '财付通', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('36', 'pay_tenpay_partnerkey', 'type=text&size=80', '', '密钥', '', 'tenpay', '财付通', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('37', 'pay_yeepay_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('38', 'pay_yeepay_merchantaccount', 'type=text&size=80', 'YB01000000144', '商户编号', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('39', 'pay_yeepay_merchantprivatekey', 'type=text&size=80', 'MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAPGE6DHyrUUAgqep/oGqMIsrJddJNFI1J/BL01zoTZ9+YiluJ7I3uYHtepApj+Jyc4Hfi+08CMSZBTHi5zWHlHQCl0WbdEkSxaiRX9t4aMS13WLYShKBjAZJdoLfYTGlyaw+tm7WG/MR+VWakkPX0pxfG+duZAQeIDoBLVfL++ihAgMBAAECgYAw2urBV862+5BybA/AmPWy4SqJbxR3YKtQj3YVACTbk4w1x0OeaGlNIAW/7bheXTqCVf8PISrA4hdL7RNKH7/mhxoX3sDuCO5nsI4Dj5xF24CymFaSRmvbiKU0Ylso2xAWDZqEs4Le/eDZKSy4LfXA17mxHpMBkzQffDMtiAGBpQJBAPn3mcAwZwzS4wjXldJ+Zoa5pwu1ZRH9fGNYkvhMTp9I9cf3wqJUN+fVPC6TIgLWyDf88XgFfjilNKNz0c/aGGcCQQD3WRxwots1lDcUhS4dpOYYnN3moKNgB07Hkpxkm+bw7xvjjHqI8q/4Jiou16eQURG+hlBZlZz37Y7P+PHF2XG3AkAyng/1WhfUAfRVewpsuIncaEXKWi4gSXthxrLkMteM68JRfvtb0cAMYyKvr72oY4Phyoe/LSWVJOcW3kIzW8+rAkBWekhQNRARBnXPbdS2to1f85A9btJP454udlrJbhxrBh4pC1dYBAlz59v9rpY+Ban/g7QZ7g4IPH0exzm4Y5K3AkBjEVxIKzb2sPDe34Aa6Qd/p6YpG9G6ND0afY+m5phBhH+rNkfYFkr98cBqjDm6NFhT7+CmRrF903gDQZmxCspY', '商户私钥', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('40', 'pay_yeepay_merchantpublickey', 'type=text&size=80', 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDxhOgx8q1FAIKnqf6BqjCLKyXXSTRSNSfwS9Nc6E2ffmIpbieyN7mB7XqQKY/icnOB34vtPAjEmQUx4uc1h5R0ApdFm3RJEsWokV/beGjEtd1i2EoSgYwGSXaC32ExpcmsPrZu1hvzEflVmpJD19KcXxvnbmQEHiA6AS1Xy/vooQIDAQAB', '商户公钥', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('41', 'pay_yeepay_yeepaypublickey', 'type=text&size=80', 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCxnYJL7fH7DVsS920LOqCu8ZzebCc78MMGImzW8MaP/cmBGd57Cw7aRTmdJxFD6jj6lrSfprXIcT7ZXoGL5EYxWUTQGRsl4HZsr1AlaOKxT5UnsuEhA/K1dN1eA4lBpNCRHf9+XDlmqVBUguhNzy6nfNjb2aGE+hkxPP99I1iMlQIDAQAB', '易宝公钥', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('42', 'pay_yeepay_productcatalog', 'type=text&size=80', '1', '商品类别码', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('43', 'pay_allinpay_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'allinpay', '银行卡支付（通联）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('44', 'pay_allinpay_merchantid', 'type=text&size=80', '100020091218001', '商户号', '', 'allinpay', '银行卡支付（通联）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('45', 'pay_allinpay_merchantkey', 'type=text&size=80', '1234567890', 'MD5 KEY', '', 'allinpay', '银行卡支付（通联）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('46', 'pay_weixin_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'weixin', '微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('47', 'pay_weixin_appid', 'type=text&size=80', '', 'Appid', '微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看。', 'weixin', '微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('48', 'pay_weixin_mchid', 'type=text&size=80', '', 'Mchid', '受理商ID，身份标识', 'weixin', '微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('49', 'pay_weixin_key', 'type=text&size=80', '', 'Key', '商户支付密钥Key。审核通过后，在微信发送的邮件中查看。', 'weixin', '微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('50', 'wx_encodingaeskey', 'type=text', '', '公众号消息加解密Key', '公众号消息加解密Key', '0', '', '13', '0', '1');
INSERT INTO `pigcms_config` VALUES ('51', 'wechat_appid', 'type=text&validate=required:true', 'aaaaa', 'AppID', 'AppID', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('52', 'wechat_appsecret', 'type=text&validate=required:true', 'aaaaa', 'AppSecret', 'AppSecret', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('53', 'bbs_url', 'type=text&validate=required:true', 'http://www.ooxx.com', '交流论坛网址', '商家用于交流的论坛网址，需自行搭建', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('54', 'user_store_num_limit', 'type=text&size=20', '0', '开店数限制', '用户最大开店数限制', '0', '每个用户最多可开店数限制，0为不限', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('55', 'sync_login_key', '', 'KKgybUkzUqrBGwCTgnAhKmqJmrzfZajJUnZenBZEVQN', '', '', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('56', 'is_check_mobile', '', '0', '手机号验证', '手机号验证', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('57', 'readme_title', 'type=text', '微聚微店代理销售服务和结算协议', '开店协议标题', '开店协议标题', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('58', 'readme_content', 'type=textarea&rows=20&cols=93', '在向消费者销售及向供应商采购的过程中，分销商需遵守：\r\n\r\n1 分销商必须严格履行对消费者的承诺，分销商不得以其与供应商之间的约定对抗其对消费者的承诺,如果分销商与供应商之间的约定不清或不能覆盖分销商对消费者的销售承诺，风险由分销商自行承担；分销商与买家出现任何纠纷，均应当依据淘宝相关规则进行处理；\r\n\r\n2 分销商承诺其最终销售给消费者的分销商品零售价格符合与供应商的约定；\r\n\r\n3 在消费者（买家）付款后，分销商应当及时向供应商支付采购单货款，否则7天后系统将关闭采购单交易，分销商应当自行承担因此而发生的交易风险；\r\n\r\n4 分销商应当在系统中及时同步供应商的实际产品库存，无论任何原因导致买家拍下后无货而产生的纠纷，均应由分销商自行承担风险与责任；\r\n\r\n5 分销商承诺分销商品所产生的销售订单均由分销平台相应的的供应商供货，以保证分销商品品质；\r\n\r\n6 分销商有义务确认消费者（买家）收货地址的有效性；\r\n\r\n7 分销商有义务在买家收到货物后，及时确认货款给供应商。如果在供应商发出货物30天后，分销商仍未确认收货，则系统会自动确认收货并将采购单对应的货款支付给供应商。', '开店协议内容', '用户开店前必须先阅读并同意该协议', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('59', 'max_store_drp_level', 'type=text&size=10', '8', '排他分销最大级别', '允许排他分销最多级别', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('60', 'open_store_drp', 'type=radio&value=1:开启|0:关闭', '1', '排他分销', '', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('61', 'open_platform_drp', 'type=radio&value=1:开启|0:关闭', '1', '全网分销', '', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('62', 'platform_mall_index_page', 'type=page&validate=required:true,number:true', '3', '平台商城首页内容', '选择一篇微页面作为平台商城首页的内容', '0', '', '11', '1', '1');
INSERT INTO `pigcms_config` VALUES ('63', 'platform_mall_open', 'type=radio&value=1:开启|0:关闭', '1', '是否开启平台商城', '如果不开启平台商城，则首页将显示为宣传介绍页面！否则显示平台商城', '0', '', '11', '2', '1');
INSERT INTO `pigcms_config` VALUES ('64', 'theme_index_group', '', 'default', '', '', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('65', 'wechat_qrcode', 'type=image&validate=required:true,url:true', 'http://www.weidian.com/upload/images/system/55aa280d658c1.jpg', '公众号二维码', '您的公众号二维码', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('66', 'wechat_name', 'type=text&validate=required:true', 'aaa', '公众号名称', '公众号的名称', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('67', 'wechat_sourceid', 'type=text&validate=required:true', 'aaaa', '公众号原始id', '公众号原始id', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('68', 'wechat_id', 'type=text&validate=required:true', '398145059@qq.com', '微信号', '微信号', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('69', 'wechat_token', 'type=text&validate=required:true', '015238d04c59ebae287145170449f0ec', '微信验证TOKEN', '微信验证TOKEN', '0', '', '8', '0', '0');
INSERT INTO `pigcms_config` VALUES ('70', 'wechat_encodingaeskey', 'type=text', 'aaaaaaa', 'EncodingAESKey', '公众号消息加解密Key,在使用安全模式情况下要填写该值，请先在管理中心修改，然后填写该值，仅限服务号和认证订阅号', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('71', 'wechat_encode', 'type=select&value=0:明文模式|1:兼容模式|2:安全模式', '0', '消息加解密方式', '如需使用安全模式请在管理中心修改，仅限服务号和认证订阅号', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('72', 'web_login_show', 'type=select&value=0:两种方式|1:仅允许帐号密码登录|2:仅允许微信扫码登录', '0', '用户登录电脑网站的方式', '用户登录电脑网站的方式', '0', '', '2', '0', '1');
INSERT INTO `pigcms_config` VALUES ('73', 'store_pay_weixin_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'store_weixin', '商家微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('74', 'im_appid', '', '1530', '', '', '0', '', '0', '0', '1');
INSERT INTO `pigcms_config` VALUES ('75', 'im_appkey', '', '4611eeb8728fa0f82c95def32da99bf0', '', '', '0', '', '0', '0', '1');
INSERT INTO `pigcms_config` VALUES ('76', 'attachment_upload_type', 'type=select&value=0:保存到本服务器|1:保存到又拍云', '0', '附件保存方式', '附件保存方式', 'base', '基础配置', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('77', 'attachment_up_bucket', 'type=text&size=50', '', 'BUCKET', 'BUCKET', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('78', 'attachment_up_form_api_secret', 'type=text&size=50', '', 'FORM_API_SECRET', 'FORM_API_SECRET', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('79', 'attachment_up_username', 'type=text&size=50', '', '操作员用户名', '操作员用户名', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('80', 'attachment_up_password', 'type=text&size=50', '', '操作员密码', '操作员密码', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('81', 'attachment_up_domainname', 'type=text&size=50', '', '云存储域名', '云存储域名 不包含http://', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('82', 'web_index_cache', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '10', 'PC端首页缓存时间', 'PC端首页缓存时间，0为不缓存（小时为单位）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('83', 'notify_appid', '', 'aabbccddeeffgghhiijjkkllmmnn', '', '通知的appid', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('84', 'notify_appkey', '', 'aabbccddeeffgghhiijjkkll', '', '通知的KEY', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('85', 'is_diy_template', 'type=radio&value=1:开启|0:关闭', '1', '是否使用自定模板', '开启后平台商城首页将不使用微杂志。自定义模板目录/template/wap/default/theme', '0', '', '11', '3', '1');
INSERT INTO `pigcms_config` VALUES ('86', 'service_key', 'type=text&validate=required:false', '', '服务key', '请填写购买产品时的服务key', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('87', 'attachment_upload_unlink', 'type=select&value=0:不删除本地附件|1:删除本地附件', '0', '是否删除本地附件', '当附件存放在远程时，如果本地服务器空间充足，不建议删除本地附件', 'base', '基础配置', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('88', 'weidian_key', 'type=salt', 'bjWCxl1oOWjWqOpJ', '微店KEY', '对接微店使用的KEY，请妥善保管', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('89', 'syn_domain', 'type=text', '', '营销活动地址', '部分功能需要调用平台内容，需要用到该网址', '0', '', '8', '-2', '1');
INSERT INTO `pigcms_config` VALUES ('90', 'encryption', 'type=text', '', '营销活动key', '与平台对接时需要用到', '0', '', '8', '-1', '1');
INSERT INTO `pigcms_config` VALUES ('91', 'is_have_activity', 'type=radio&value=1:有|0:没有', '1', '活动', '首页是否需要展示营销活动', '0', '0', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('92', 'pc_usercenter_logo', 'type=image&validate=required:true,url:true', 'http://www.ooxx.com/upload/images/000/000/001/55d5788bb293f.png', 'PC-个人用户中心LOGO图', '请填写带LOGO的网址，包含（http://域名）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('93', 'pc_shopercenter_logo', 'type=image&validate=required:true,url:true', 'http://www.ooxx.com/upload/images/000/000/001/55d578920f179.png', '商家中心LOGO图', '请填写带LOGO的网址，包含（http://域名）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('94', 'is_allow_comment_control', 'type=select&value=1:允许商户管理评论|2:不允许商户管理评论', '1', '是否允许商户管理评论', '开启后，商户可对评论进行增、删、查操作', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('95', 'ischeck_to_show_by_comment', 'type=select&value=1:不需要审核评论才显示|0:需审核即可显示评论', '1', '评论是否需要审核显示', '开启后，需商家或管理员审核方可显示，反之：不需审核即可显示', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('96', 'sales_ratio', 'type=text&size=3&validate=required:true,number:true,maxlength:2', '2', '商家销售分成比例', '例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('99', 'ischeck_store', 'type=select&value=1:开店需要审核|0:开店无需审核', '0', '开店是否要审核', '开启后，会员开店需要后台审核通过后，店铺才能正常使用', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('100', 'synthesize_store', '', '1', '', '综合商城预览', '0', '', '1', '0', '0');

-- ----------------------------
-- Table structure for `pigcms_config_group`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_config_group`;
CREATE TABLE `pigcms_config_group` (
  `gid` int(11) NOT NULL auto_increment,
  `gname` char(20) NOT NULL,
  `gsort` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='配置分组';

-- ----------------------------
-- Records of pigcms_config_group
-- ----------------------------
INSERT INTO `pigcms_config_group` VALUES ('1', '基础配置', '10', '1');
INSERT INTO `pigcms_config_group` VALUES ('7', '支付配置', '4', '1');
INSERT INTO `pigcms_config_group` VALUES ('11', '微信版商城配置', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('12', '分销配置', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('8', '平台公众号配置', '3', '1');
INSERT INTO `pigcms_config_group` VALUES ('13', '店铺绑定公众号配置', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('2', '会员配置', '9', '1');
INSERT INTO `pigcms_config_group` VALUES ('14', '附件配置', '0', '1');

-- ----------------------------
-- Table structure for `pigcms_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_coupon`;
CREATE TABLE `pigcms_coupon` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `name` varchar(255) NOT NULL COMMENT '优惠券名称',
  `face_money` decimal(10,2) NOT NULL default '0.00' COMMENT '优惠券面值(起始)',
  `limit_money` decimal(10,2) NOT NULL default '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',
  `most_have` int(11) NOT NULL COMMENT '单人最多拥有优惠券数量（0：不限制）',
  `total_amount` int(11) NOT NULL COMMENT '发放总量',
  `start_time` int(11) NOT NULL COMMENT '生效时间',
  `end_time` int(11) NOT NULL COMMENT '过期时间',
  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',
  `is_share` tinyint(1) NOT NULL default '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',
  `is_all_product` tinyint(1) NOT NULL default '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',
  `is_original_price` tinyint(1) NOT NULL default '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',
  `timestamp` int(11) NOT NULL COMMENT '添加优惠券的时间',
  `description` text NOT NULL COMMENT '使用说明',
  `used_number` int(11) NOT NULL default '0' COMMENT '已使用数量',
  `number` int(11) NOT NULL default '0' COMMENT '已领取数量',
  `status` tinyint(1) NOT NULL default '1' COMMENT '是否失效（0：失效；1：未失效）',
  `type` tinyint(1) NOT NULL default '1' COMMENT '券类型（1：优惠券； 2:赠送券）',
  UNIQUE KEY `id` (`id`),
  KEY `uid` (`uid`,`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='优惠券';

-- ----------------------------
-- Records of pigcms_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_coupon_to_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_coupon_to_product`;
CREATE TABLE `pigcms_coupon_to_product` (
  `id` int(11) NOT NULL auto_increment,
  `coupon_id` int(11) NOT NULL COMMENT '优惠券id',
  `product_id` int(11) NOT NULL COMMENT '产品id',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `coupon_id` (`coupon_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='优惠券产品对应表';

-- ----------------------------
-- Records of pigcms_coupon_to_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_custom_field`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_custom_field`;
CREATE TABLE `pigcms_custom_field` (
  `field_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `module_name` varchar(20) NOT NULL,
  `module_id` int(11) NOT NULL,
  `field_type` varchar(20) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`field_id`),
  KEY `store_id_2` USING BTREE (`store_id`,`module_name`,`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=739 DEFAULT CHARSET=utf8 COMMENT='自定义字段';

-- ----------------------------
-- Records of pigcms_custom_field
-- ----------------------------
INSERT INTO `pigcms_custom_field` VALUES ('315', '3', 'page', '3', 'rich_text', 'a:1:{s:7:\"content\";s:2948:\"&lt;table data-sort=&quot;sortDisabled&quot;&gt;&lt;tbody&gt;&lt;tr class=&quot;firstRow&quot;&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; rowspan=&quot;4&quot; colspan=&quot;1&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb289f66dff.jpg&quot; width=&quot;126&quot; height=&quot;548&quot; style=&quot;width: 126px; height: 548px;&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28b2ec63a.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28be26066.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28c6a3e8f.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28d3a7b98.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28db39193.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28e4f0343.png&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28eb90d62.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=17&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb28f453cd2.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('3', '4', 'page', '4', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-20 17:05\";}');
INSERT INTO `pigcms_custom_field` VALUES ('4', '4', 'page', '4', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('5', '5', 'page', '5', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-20 17:05\";}');
INSERT INTO `pigcms_custom_field` VALUES ('6', '5', 'page', '5', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('7', '6', 'page', '6', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-20 17:58\";}');
INSERT INTO `pigcms_custom_field` VALUES ('8', '6', 'page', '6', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('9', '6', 'good_cat', '1', 'image_ad', 'a:1:{s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('10', '7', 'page', '7', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-23 09:53\";}');
INSERT INTO `pigcms_custom_field` VALUES ('11', '7', 'page', '7', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('12', '8', 'page', '8', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-23 09:56\";}');
INSERT INTO `pigcms_custom_field` VALUES ('13', '8', 'page', '8', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('14', '9', 'page', '9', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-25 09:09\";}');
INSERT INTO `pigcms_custom_field` VALUES ('15', '9', 'page', '9', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('16', '10', 'page', '10', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-25 11:00\";}');
INSERT INTO `pigcms_custom_field` VALUES ('17', '10', 'page', '10', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('18', '11', 'page', '11', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-28 11:23\";}');
INSERT INTO `pigcms_custom_field` VALUES ('19', '11', 'page', '11', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('20', '12', 'page', '12', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-29 11:49\";}');
INSERT INTO `pigcms_custom_field` VALUES ('21', '12', 'page', '12', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('22', '6', 'good_cat', '4', 'goods', 'a:4:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";}');
INSERT INTO `pigcms_custom_field` VALUES ('35', '0', 'page', '13', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('36', '0', 'page', '13', 'image_ad', 'a:3:{s:10:\"max_height\";s:3:\"320\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:4:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b99554e8de8.jpg\";}i:11;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b9955f2dce2.jpg\";}i:12;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b995cf20c96.jpg\";}i:13;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b995eec45f9.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('25', '13', 'page', '14', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-30 12:26\";}');
INSERT INTO `pigcms_custom_field` VALUES ('26', '13', 'page', '14', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('37', '0', 'page', '13', 'image_nav', 'a:4:{i:10;a:5:{s:5:\"title\";s:6:\"酒店\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b9d80a0bc84.jpg\";}i:11;a:5:{s:5:\"title\";s:6:\"美食\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b9dbb6bd499.jpg\";}i:12;a:5:{s:5:\"title\";s:6:\"打车\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/000/201507/55b9dbc6cc520.jpg\";}i:13;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('38', '0', 'page', '13', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:10:\"show_title\";s:1:\"1\";s:5:\"price\";s:1:\"1\";}');
INSERT INTO `pigcms_custom_field` VALUES ('307', '14', 'page', '28', 'component', 'a:3:{s:4:\"name\";s:7:\"模板1\";s:2:\"id\";s:1:\"3\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/component.php?id=3\";}');
INSERT INTO `pigcms_custom_field` VALUES ('303', '21', 'page', '29', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-13 15:25\";}');
INSERT INTO `pigcms_custom_field` VALUES ('304', '21', 'page', '29', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('41', '15', 'page', '16', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-30 17:13\";}');
INSERT INTO `pigcms_custom_field` VALUES ('42', '15', 'page', '16', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('318', '23', 'page', '31', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-17 22:52\";}');
INSERT INTO `pigcms_custom_field` VALUES ('109', '3', 'page', '17', 'goods', 'a:5:{s:4:\"size\";s:1:\"3\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"14\";s:5:\"title\";s:87:\"BAKONG 2015夏季新款凉鞋女平底沙滩鞋女鞋波西米亚凉鞋820 836黑色 38\";s:5:\"price\";s:5:\"79.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=14\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad1878d059.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"13\";s:5:\"title\";s:75:\"彰婷 2015夏季新款胖MM短袖大码修身连衣裙T0958 图片色. 3XL\";s:5:\"price\";s:6:\"189.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=13\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad08c7dc35.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"12\";s:5:\"title\";s:137:\"紫缇宣 欧美大码女装夏装新款印花显瘦两件套装加肥胖mm短袖T恤雪纺衫上衣+短裤子 1540# 3XL 150-160斤左右\";s:5:\"price\";s:6:\"178.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=12\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bacf9b630f6.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('106', '3', 'page', '17', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('107', '3', 'page', '17', 'image_ad', 'a:3:{s:10:\"max_height\";s:3:\"320\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:4:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad24731781.jpg\";}i:11;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad253f0343.jpg\";}i:12;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad25b94a6b.jpg\";}i:13;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad263ab8a1.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('108', '3', 'page', '17', 'text_nav', 'a:3:{i:10;a:4:{s:5:\"title\";s:6:\"女装\";s:4:\"name\";s:6:\"女装\";s:6:\"prefix\";s:9:\"微页面\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/page.php?id=18\";}i:11;a:4:{s:5:\"title\";s:6:\"女鞋\";s:4:\"name\";s:6:\"女鞋\";s:6:\"prefix\";s:9:\"微页面\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/page.php?id=19\";}i:12;a:4:{s:5:\"title\";s:6:\"女包\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('85', '3', 'page', '18', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('86', '3', 'page', '18', 'image_ad', 'a:3:{s:10:\"max_height\";s:3:\"320\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:3:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badd944ffc9.jpg\";}i:11;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badda29c47d.jpg\";}i:12;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badda94c2c0.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('87', '3', 'page', '18', 'goods', 'a:5:{s:4:\"size\";s:1:\"3\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:4:{i:0;a:5:{s:2:\"id\";s:2:\"16\";s:5:\"title\";s:112:\"猫小仙儿2015连衣裙夏装韩版女装小清新两件套印花雪纺半裙加雪纺上衣 米粉底绿花 L\";s:5:\"price\";s:6:\"158.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=16\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bada4e7dc35.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"15\";s:5:\"title\";s:96:\"虞倩YQ 2015新品秋装女装连衣裙 蕾丝边外套修身显瘦两件套装Y066 梅红色 M\";s:5:\"price\";s:6:\"168.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=15\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad9796e811.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"13\";s:5:\"title\";s:75:\"彰婷 2015夏季新款胖MM短袖大码修身连衣裙T0958 图片色. 3XL\";s:5:\"price\";s:6:\"189.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=13\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad08c7dc35.jpg\";}i:3;a:5:{s:2:\"id\";s:2:\"12\";s:5:\"title\";s:137:\"紫缇宣 欧美大码女装夏装新款印花显瘦两件套装加肥胖mm短袖T恤雪纺衫上衣+短裤子 1540# 3XL 150-160斤左右\";s:5:\"price\";s:6:\"178.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=12\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bacf9b630f6.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('88', '3', 'page', '19', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('89', '3', 'page', '19', 'image_ad', 'a:3:{s:10:\"max_height\";s:3:\"320\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:3:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badddf2235d.jpg\";}i:11;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55baddeb98774.jpg\";}i:12;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55baddfba3e8f.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('90', '3', 'page', '19', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('91', '3', 'page', '19', 'goods', 'a:5:{s:4:\"size\";s:1:\"3\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:4:{i:0;a:5:{s:2:\"id\";s:2:\"19\";s:5:\"title\";s:106:\"莱尔斯丹 2015春季新款优雅圆头纯色漆皮单鞋高跟金属扣女鞋OUSE 6M82901 黑色 BKP 38\";s:5:\"price\";s:6:\"479.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=19\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badcced1afb.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"18\";s:5:\"title\";s:126:\"邦木 2015春夏新款单鞋女鞋网面透气女帆布鞋韩版透气厚底运动摇摇鞋松糕时尚女休闲鞋 月色 38\";s:5:\"price\";s:6:\"198.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=18\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badc13e8931.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"17\";s:5:\"title\";s:96:\"红蜻蜓 2015春季新款时尚舒适可爱蝴蝶结女鞋女单鞋 WCB57311/12/13/15 黑色 36\";s:5:\"price\";s:6:\"249.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=17\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55badb5531781.jpg\";}i:3;a:5:{s:2:\"id\";s:2:\"14\";s:5:\"title\";s:87:\"BAKONG 2015夏季新款凉鞋女平底沙滩鞋女鞋波西米亚凉鞋820 836黑色 38\";s:5:\"price\";s:5:\"79.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=14\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad1878d059.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('97', '3', 'page', '20', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('98', '3', 'page', '20', 'image_ad', 'a:3:{s:10:\"max_height\";s:3:\"320\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:3:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae41cbe9ce.jpg\";}i:11;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae42a4c2c0.jpg\";}i:12;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae4344c2c0.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('99', '3', 'page', '20', 'goods', 'a:5:{s:4:\"size\";s:1:\"3\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:2:{i:0;a:5:{s:2:\"id\";s:2:\"22\";s:5:\"title\";s:94:\"海澜之家 2015夏季新品 男装条纹拼接短袖T恤HNTBJ2A009A 浅灰镶拼(11) 175/92Y\";s:5:\"price\";s:5:\"99.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=22\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae33329d6f.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"21\";s:5:\"title\";s:93:\"依泽麦布2015夏款短袖T恤男 潮男修身印花运动套装 男装短袖T恤 白色 XL\";s:5:\"price\";s:6:\"158.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=21\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bae24de4c28.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('100', '16', 'page', '21', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-07-31 12:28\";}');
INSERT INTO `pigcms_custom_field` VALUES ('101', '16', 'page', '21', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('316', '3', 'page', '3', 'rich_text', 'a:1:{s:7:\"content\";s:122:\"&lt;p&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2af00b527.jpg&quot;&gt;&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('317', '3', 'page', '3', 'rich_text', 'a:1:{s:7:\"content\";s:2535:\"&lt;table data-sort=&quot;sortDisabled&quot;&gt;&lt;tbody&gt;&lt;tr class=&quot;firstRow&quot;&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; rowspan=&quot;3&quot; colspan=&quot;1&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b0c5b6e4.jpg&quot; width=&quot;126&quot; height=&quot;408&quot; style=&quot;width: 126px; height: 408px;&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b27e8931.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b2f1e654.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b3585647.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b3c2da78.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b43b6fbc.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;td width=&quot;126&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;&lt;a href=&quot;http://www.weidian.com/wap/page.php?id=20&quot; target=&quot;_self&quot;&gt;&lt;img src=&quot;http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bb2b4a40ba5.jpg&quot;&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('314', '3', 'page', '3', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"12\";s:5:\"title\";s:137:\"紫缇宣 欧美大码女装夏装新款印花显瘦两件套装加肥胖mm短袖T恤雪纺衫上衣+短裤子 1540# 3XL 150-160斤左右\";s:5:\"price\";s:6:\"178.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=12\";s:5:\"image\";s:43:\"images/000/000/003/201507/55bacf9b630f6.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"14\";s:5:\"title\";s:87:\"BAKONG 2015夏季新款凉鞋女平底沙滩鞋女鞋波西米亚凉鞋820 836黑色 38\";s:5:\"price\";s:5:\"79.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=14\";s:5:\"image\";s:43:\"images/000/000/003/201507/55bad1878d059.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"13\";s:5:\"title\";s:75:\"彰婷 2015夏季新款胖MM短袖大码修身连衣裙T0958 图片色. 3XL\";s:5:\"price\";s:6:\"189.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=13\";s:5:\"image\";s:43:\"images/000/000/003/201507/55bad08c7dc35.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('310', '3', 'page', '3', 'image_ad', 'a:3:{s:10:\"max_height\";s:3:\"320\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:4:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad2ae5f3ed.jpg\";}i:11;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad2b453cd2.jpg\";}i:12;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad2bba3e8f.jpg\";}i:13;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad2c240ba5.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('311', '3', 'page', '3', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('312', '3', 'page', '3', 'image_nav', 'a:4:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}i:11;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}i:12;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}i:13;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('313', '3', 'page', '3', 'image_nav', 'a:4:{i:10;a:5:{s:5:\"title\";s:6:\"女人\";s:4:\"name\";s:6:\"女人\";s:6:\"prefix\";s:9:\"微页面\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/page.php?id=17\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad50fca0e9.png\";}i:11;a:5:{s:5:\"title\";s:6:\"男人\";s:4:\"name\";s:6:\"男人\";s:6:\"prefix\";s:9:\"微页面\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/page.php?id=20\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/003/201507/55bad515c26d7.png\";}i:12;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}i:13;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('202', '17', 'page', '22', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-05 21:21\";}');
INSERT INTO `pigcms_custom_field` VALUES ('203', '17', 'page', '22', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('204', '18', 'page', '23', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-05 21:23\";}');
INSERT INTO `pigcms_custom_field` VALUES ('205', '18', 'page', '23', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('241', '19', 'page_cat', '2', 'rich_text', 'a:1:{s:7:\"content\";s:1860:\"&lt;h2&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(146, 208, 80);&quot;&gt;会费缴纳标准：&lt;/span&gt;&lt;/h2&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(0, 176, 240);&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 宋体; font-size: 20px; text-decoration: none;&quot;&gt;商会会费按年缴纳&lt;/span&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;会长（法人代表）：100000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;副会长：50000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;秘书长、监事长：50000元/年&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;副秘书长：30000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;理事：10000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;font-family: 宋体; font-size: 19px; background-color: rgb(219, 238, 243);&quot;&gt;会员：3000元/年；&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;新加入商会的会员均应在办理入会手续时按要求交纳会费。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;会员向商会缴纳会费后，财务人员应开具加盖公章的会费收取收据，会费列入财务监管，会费缴纳不在退费。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('244', '19', 'ucenter', '19', 'white', 'a:1:{s:6:\"height\";s:2:\"30\";}');
INSERT INTO `pigcms_custom_field` VALUES ('245', '19', 'ucenter', '19', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('208', '19', 'good_cat', '8', 'line', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('209', '19', 'good_cat', '8', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('210', '19', 'good_cat', '8', 'text_nav', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('211', '19', 'page', '25', 'title', 'a:2:{s:5:\"title\";s:24:\"许昌商会会费缴纳\";s:9:\"sub_title\";s:15:\"以年为单位\";}');
INSERT INTO `pigcms_custom_field` VALUES ('212', '19', 'page', '25', 'notice', 'a:1:{s:7:\"content\";s:75:\"新加入商会的会员均应在办理入会手续时按要求交纳会费\";}');
INSERT INTO `pigcms_custom_field` VALUES ('213', '19', 'page', '25', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('214', '19', 'page', '25', 'goods', 'a:7:{s:4:\"size\";s:1:\"1\";s:9:\"size_type\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:10:\"show_title\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:2:{i:0;a:5:{s:2:\"id\";s:2:\"26\";s:5:\"title\";s:9:\"副会长\";s:5:\"price\";s:7:\"5000.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=26\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c311f119a65.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"25\";s:5:\"title\";s:24:\"会长（法人代表）\";s:5:\"price\";s:8:\"10000.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=25\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c30c4c622cb.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('215', '19', 'page', '25', 'line', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('216', '19', 'page', '25', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('253', '19', 'page', '26', 'notice', 'a:1:{s:7:\"content\";s:222:\"新加入商会的会员均应在办理入会手续时按要求交纳会费；会员向商会缴纳会费后，财务人员应开具加盖公章的会费收取收据，会费列入财务监管，会费缴纳不在退费。\";}');
INSERT INTO `pigcms_custom_field` VALUES ('256', '19', 'page', '26', 'line', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('254', '19', 'page', '26', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('255', '19', 'page', '26', 'goods', 'a:7:{s:4:\"size\";s:1:\"1\";s:9:\"size_type\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:10:\"show_title\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:6:{i:0;a:5:{s:2:\"id\";s:2:\"25\";s:5:\"title\";s:24:\"会长（法人代表）\";s:5:\"price\";s:8:\"10000.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=25\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c30c4c622cb.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"26\";s:5:\"title\";s:9:\"副会长\";s:5:\"price\";s:7:\"5000.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=26\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c311f119a65.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"27\";s:5:\"title\";s:21:\"秘书长、监事长\";s:5:\"price\";s:8:\"50000.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=27\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c316882b3e5.jpg\";}i:3;a:5:{s:2:\"id\";s:2:\"28\";s:5:\"title\";s:12:\"副秘书长\";s:5:\"price\";s:8:\"30000.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=28\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c3173428e03.jpg\";}i:4;a:5:{s:2:\"id\";s:2:\"29\";s:5:\"title\";s:6:\"理事\";s:5:\"price\";s:8:\"10000.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=29\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c31871c3361.jpg\";}i:5;a:5:{s:2:\"id\";s:2:\"30\";s:5:\"title\";s:6:\"会员\";s:5:\"price\";s:7:\"3000.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=30\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/019/201508/55c3194aec38e.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('252', '19', 'page', '26', 'title', 'a:2:{s:5:\"title\";s:24:\"许昌商会会费缴纳\";s:9:\"sub_title\";s:24:\"商会会费按年缴纳\";}');
INSERT INTO `pigcms_custom_field` VALUES ('257', '19', 'page', '26', 'store', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('258', '20', 'page', '27', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-10 14:35\";}');
INSERT INTO `pigcms_custom_field` VALUES ('259', '20', 'page', '27', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('306', '14', 'page', '28', 'image_nav', 'a:4:{i:10;a:5:{s:5:\"title\";s:6:\"纯棉\";s:4:\"name\";s:6:\"纯棉\";s:6:\"prefix\";s:12:\"商品分组\";s:3:\"url\";s:43:\"http://www.weidian.com/wap/goodcat.php?id=9\";s:5:\"image\";s:0:\"\";}i:11;a:5:{s:5:\"title\";s:9:\"生态棉\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}i:12;a:5:{s:5:\"title\";s:9:\"钻石绒\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:0:\"\";}i:13;a:5:{s:5:\"title\";s:6:\"天丝\";s:4:\"name\";s:15:\"天丝四件套\";s:6:\"prefix\";s:6:\"商品\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=32\";s:5:\"image\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('305', '14', 'page', '28', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('266', '14', 'common_ad', '14', 'image_ad', 'a:3:{s:10:\"max_height\";s:4:\"1308\";s:9:\"max_width\";s:4:\"1600\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/014/201508/55cc3765c469a.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('267', '14', 'common_ad', '14', 'component', 'a:3:{s:4:\"name\";s:7:\"模板1\";s:2:\"id\";s:1:\"3\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/component.php?id=3\";}');
INSERT INTO `pigcms_custom_field` VALUES ('298', '14', 'custom_page', '3', 'image_ad', 'a:3:{s:10:\"max_height\";s:4:\"1308\";s:9:\"max_width\";s:4:\"1600\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:75:\"http://weidian01.b0.upaiyun.com/images/000/000/014/201508/55cc3c7fa2e40.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('308', '22', 'page', '30', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-16 12:36\";}');
INSERT INTO `pigcms_custom_field` VALUES ('309', '22', 'page', '30', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('319', '23', 'page', '31', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('320', '24', 'page', '32', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-17 23:45\";}');
INSERT INTO `pigcms_custom_field` VALUES ('321', '24', 'page', '32', 'rich_text', 'a:1:{s:7:\"content\";s:2107:\"<p>感谢您使用联动生活社区，在联动生活社区里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择联动生活社区！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('322', '0', 'page', '33', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('323', '0', 'page', '33', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('324', '0', 'page', '33', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"41\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=43\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"42\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=42\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"43\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=41\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('325', '0', 'page', '34', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('326', '0', 'page', '34', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('327', '0', 'page', '34', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"13\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('328', '0', 'page', '35', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('329', '0', 'page', '35', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('330', '0', 'page', '35', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('331', '0', 'page', '35', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"41\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=41\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"42\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=43\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"43\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=43\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('332', '0', 'page', '36', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('333', '0', 'page', '36', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('334', '0', 'page', '36', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"41\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=41\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"42\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=41\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"43\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=41\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('335', '0', 'page', '37', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('336', '0', 'page', '37', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('337', '0', 'page', '37', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('338', '0', 'page', '37', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"41\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=42\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"42\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=41\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"43\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=41\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('339', '0', 'page', '38', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('340', '0', 'page', '38', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('341', '0', 'page', '38', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('342', '0', 'page', '38', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"41\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=42\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"42\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=43\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"43\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=42\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('343', '0', 'page', '39', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('344', '0', 'page', '39', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('345', '0', 'page', '39', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"44\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=44\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"45\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=44\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"46\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=46\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('346', '0', 'page', '40', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('347', '0', 'page', '40', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('348', '0', 'page', '40', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"14\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('349', '0', 'page', '41', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('350', '0', 'page', '41', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('351', '0', 'page', '41', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('352', '0', 'page', '41', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"44\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=44\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"45\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=44\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"46\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=46\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('353', '0', 'page', '42', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('354', '0', 'page', '42', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('355', '0', 'page', '42', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"44\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=44\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"45\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=44\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"46\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=45\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('356', '0', 'page', '43', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('357', '0', 'page', '43', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('358', '0', 'page', '43', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('359', '0', 'page', '43', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"44\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=46\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"45\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=46\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"46\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=45\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('360', '0', 'page', '44', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('361', '0', 'page', '44', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('362', '0', 'page', '44', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('363', '0', 'page', '44', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"44\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=44\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"45\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=45\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"46\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=45\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('364', '0', 'page', '45', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('365', '0', 'page', '45', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('366', '0', 'page', '45', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"47\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=47\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"48\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=49\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"49\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=47\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('367', '0', 'page', '46', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('368', '0', 'page', '46', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('369', '0', 'page', '46', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"15\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('370', '0', 'page', '47', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('371', '0', 'page', '47', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('372', '0', 'page', '47', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('373', '0', 'page', '47', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"47\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=49\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"48\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=47\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"49\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=49\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('374', '0', 'page', '48', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('375', '0', 'page', '48', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('376', '0', 'page', '48', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"47\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=48\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"48\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=49\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"49\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=48\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('377', '0', 'page', '49', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('378', '0', 'page', '49', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('379', '0', 'page', '49', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('380', '0', 'page', '49', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"47\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=49\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"48\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=47\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"49\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=47\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('381', '0', 'page', '50', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('382', '0', 'page', '50', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('383', '0', 'page', '50', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('384', '0', 'page', '50', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"47\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=48\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"48\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=49\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"49\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=49\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('385', '0', 'page', '51', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('386', '0', 'page', '51', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('387', '0', 'page', '51', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"50\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=51\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"51\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=50\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"52\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=52\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('388', '0', 'page', '52', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('389', '0', 'page', '52', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('390', '0', 'page', '52', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"16\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('391', '0', 'page', '53', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('392', '0', 'page', '53', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('393', '0', 'page', '53', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('394', '0', 'page', '53', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"50\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=51\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"51\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=50\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"52\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=50\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('395', '0', 'page', '54', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('396', '0', 'page', '54', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('397', '0', 'page', '54', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"50\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=52\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"51\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=52\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"52\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=50\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('398', '0', 'page', '55', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('399', '0', 'page', '55', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('400', '0', 'page', '55', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('401', '0', 'page', '55', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"50\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=50\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"51\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=50\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"52\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=51\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('402', '0', 'page', '56', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('403', '0', 'page', '56', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('404', '0', 'page', '56', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('405', '0', 'page', '56', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"50\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=51\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"51\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=51\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"52\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=52\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('406', '0', 'page', '57', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('407', '0', 'page', '57', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('408', '0', 'page', '57', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"53\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=53\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"54\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=54\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"55\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=55\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('409', '0', 'page', '58', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('410', '0', 'page', '58', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('411', '0', 'page', '58', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"17\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('412', '0', 'page', '59', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('413', '0', 'page', '59', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('414', '0', 'page', '59', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('415', '0', 'page', '59', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"53\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=53\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"54\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=54\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"55\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=54\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('416', '0', 'page', '60', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('417', '0', 'page', '60', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('418', '0', 'page', '60', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"53\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=55\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"54\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=55\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"55\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=54\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('419', '0', 'page', '61', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('420', '0', 'page', '61', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('421', '0', 'page', '61', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('422', '0', 'page', '61', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"53\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=53\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"54\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=54\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"55\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=53\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('423', '0', 'page', '62', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('424', '0', 'page', '62', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('425', '0', 'page', '62', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('426', '0', 'page', '62', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"53\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=53\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"54\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=55\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"55\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.weidian.com/wap/good.php?id=54\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('427', '26', 'page', '63', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-18 22:50\";}');
INSERT INTO `pigcms_custom_field` VALUES ('428', '26', 'page', '63', 'rich_text', 'a:1:{s:7:\"content\";s:2095:\"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('441', '29', 'page', '66', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-19 21:23\";}');
INSERT INTO `pigcms_custom_field` VALUES ('435', '27', 'page', '64', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:1:{i:0;a:5:{s:2:\"id\";s:2:\"58\";s:5:\"title\";s:12:\"远亮神器\";s:5:\"price\";s:4:\"1.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=58\";s:5:\"image\";s:43:\"images/000/000/027/201508/55d4819fb0587.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('444', '30', 'page', '67', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-19 21:26\";}');
INSERT INTO `pigcms_custom_field` VALUES ('431', '28', 'page', '65', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-19 21:10\";}');
INSERT INTO `pigcms_custom_field` VALUES ('432', '28', 'page', '65', 'rich_text', 'a:1:{s:7:\"content\";s:2095:\"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('433', '27', 'good', '58', 'goods', 'a:4:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";}');
INSERT INTO `pigcms_custom_field` VALUES ('442', '29', 'page', '66', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:1:{i:0;a:5:{s:2:\"id\";s:2:\"59\";s:5:\"title\";s:6:\"测试\";s:5:\"price\";d:1;s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=59\";s:5:\"image\";s:43:\"images/000/000/029/201508/55d483b4030ad.JPG\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('443', '29', 'page', '66', 'rich_text', 'a:1:{s:7:\"content\";s:2811:\"&lt;p&gt;感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。&lt;/p&gt;&lt;p&gt;在微杂志里，您可以多个功能模块，例如“&lt;strong&gt;富文本&lt;/strong&gt;”模块。在“富文本”里，对文字进行&lt;strong&gt;加粗&lt;/strong&gt;、&lt;em&gt;斜体&lt;/em&gt;、&lt;span style=&quot;text-decoration:underline;&quot;&gt;下划线&lt;/span&gt;、&lt;span style=&quot;text-decoration:line-through;&quot;&gt;删除线&lt;/span&gt;、&lt;span style=&quot;color:rgb(0,176,240);&quot;&gt;文字颜色&lt;/span&gt;、&lt;span style=&quot;color:rgb(255,255,255);background-color:rgb(247,150,70);&quot;&gt;背景色&lt;/span&gt;、以及&lt;span style=&quot;font-size:22px;&quot;&gt;字号大小&lt;/span&gt;等简单排版操作。&lt;/p&gt;&lt;p&gt;也可以在这里，通过编辑器使用表格功能&lt;/p&gt;&lt;table&gt;&lt;tbody&gt;&lt;tr class=&quot;firstRow&quot;&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;中奖客户&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;发放奖品&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;备注&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;猪猪&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;内测码&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;&lt;span style=&quot;color:rgb(255,0,0);&quot;&gt;已经发放&lt;/span&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;大麦&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;积分&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;&lt;span style=&quot;color:rgb(0,176,240);&quot;&gt;领取地址&lt;/span&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;p&gt;还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。&lt;br&gt;&lt;/p&gt;&lt;p&gt;另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。&lt;/p&gt;&lt;p&gt;再次感谢您选择JY微店系统！&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('445', '30', 'page', '67', 'rich_text', 'a:1:{s:7:\"content\";s:2095:\"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('446', '0', 'page', '68', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('447', '0', 'page', '68', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('448', '0', 'page', '68', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"60\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=62\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"61\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=60\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"62\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=60\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('449', '0', 'page', '69', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('450', '0', 'page', '69', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('451', '0', 'page', '69', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"22\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('452', '0', 'page', '70', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('453', '0', 'page', '70', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('454', '0', 'page', '70', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('455', '0', 'page', '70', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"60\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=61\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"61\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=60\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"62\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=61\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('456', '0', 'page', '71', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('457', '0', 'page', '71', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('458', '0', 'page', '71', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"60\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=62\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"61\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=62\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"62\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=62\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('459', '0', 'page', '72', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('460', '0', 'page', '72', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('461', '0', 'page', '72', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('462', '0', 'page', '72', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"60\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=60\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"61\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=60\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"62\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=61\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('463', '0', 'page', '73', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('464', '0', 'page', '73', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('465', '0', 'page', '73', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('466', '0', 'page', '73', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"60\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=62\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"61\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=62\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"62\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:45:\"http://www.weidian.com/wap/good.php?id=62\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('467', '31', 'page', '74', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-19 22:12\";}');
INSERT INTO `pigcms_custom_field` VALUES ('468', '31', 'page', '74', 'rich_text', 'a:1:{s:7:\"content\";s:2095:\"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('469', '32', 'page', '75', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-19 22:18\";}');
INSERT INTO `pigcms_custom_field` VALUES ('470', '32', 'page', '75', 'rich_text', 'a:1:{s:7:\"content\";s:2095:\"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('471', '0', 'page', '76', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('472', '0', 'page', '76', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('473', '0', 'page', '76', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"63\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=63\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"64\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=64\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"65\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=63\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('474', '0', 'page', '77', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('475', '0', 'page', '77', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('476', '0', 'page', '77', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"23\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('477', '0', 'page', '78', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('478', '0', 'page', '78', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('479', '0', 'page', '78', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('480', '0', 'page', '78', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"63\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=63\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"64\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=64\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"65\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=63\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('481', '0', 'page', '79', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('482', '0', 'page', '79', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('483', '0', 'page', '79', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"63\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=64\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"64\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=63\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"65\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=64\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('484', '0', 'page', '80', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('485', '0', 'page', '80', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('486', '0', 'page', '80', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('487', '0', 'page', '80', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"63\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=63\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"64\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=63\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"65\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=64\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('488', '0', 'page', '81', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('489', '0', 'page', '81', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('490', '0', 'page', '81', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('491', '0', 'page', '81', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:2:\"63\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=65\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:2:\"64\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=63\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:2:\"65\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.weidian.com/wap/good.php?id=65\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('492', '33', 'page', '82', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-20 09:48\";}');
INSERT INTO `pigcms_custom_field` VALUES ('493', '33', 'page', '82', 'rich_text', 'a:1:{s:7:\"content\";s:2095:\"<p>感谢您使用JY微店系统，在JY微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择JY微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('494', '34', 'page', '167', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-21 10:38\";}');
INSERT INTO `pigcms_custom_field` VALUES ('495', '34', 'page', '167', 'rich_text', 'a:1:{s:7:\"content\";s:2146:\"<p>感谢您使用汉中微聚网络-微店系统，在汉中微聚网络-微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择汉中微聚网络-微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('496', '35', 'page', '168', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-21 10:58\";}');
INSERT INTO `pigcms_custom_field` VALUES ('497', '35', 'page', '168', 'rich_text', 'a:1:{s:7:\"content\";s:2146:\"<p>感谢您使用汉中微聚网络-微店系统，在汉中微聚网络-微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择汉中微聚网络-微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('498', '0', 'page', '169', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('499', '0', 'page', '169', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('500', '0', 'page', '169', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"105\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=106\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"106\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=106\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"107\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=105\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('501', '0', 'page', '170', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('502', '0', 'page', '170', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('503', '0', 'page', '170', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"38\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('504', '0', 'page', '171', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('505', '0', 'page', '171', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('506', '0', 'page', '171', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('507', '0', 'page', '171', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"105\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=107\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"106\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=107\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"107\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=107\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('508', '0', 'page', '172', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('509', '0', 'page', '172', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('510', '0', 'page', '172', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"105\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=107\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"106\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=105\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"107\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=107\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('511', '0', 'page', '173', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('512', '0', 'page', '173', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('513', '0', 'page', '173', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('514', '0', 'page', '173', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"105\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=105\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"106\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=105\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"107\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=105\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('515', '0', 'page', '174', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('516', '0', 'page', '174', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('517', '0', 'page', '174', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('518', '0', 'page', '174', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"105\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=106\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"106\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=105\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"107\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=105\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('519', '0', 'page', '175', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('520', '0', 'page', '175', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('521', '0', 'page', '175', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"108\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=109\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"109\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=109\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"110\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=110\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('522', '0', 'page', '176', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('523', '0', 'page', '176', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('524', '0', 'page', '176', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"39\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('525', '0', 'page', '177', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('526', '0', 'page', '177', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('527', '0', 'page', '177', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('528', '0', 'page', '177', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"108\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=109\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"109\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=108\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"110\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=108\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('529', '0', 'page', '178', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('530', '0', 'page', '178', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('531', '0', 'page', '178', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"108\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=108\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"109\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=110\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"110\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=108\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('532', '0', 'page', '179', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('533', '0', 'page', '179', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('534', '0', 'page', '179', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('535', '0', 'page', '179', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"108\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=109\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"109\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=109\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"110\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=110\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('536', '0', 'page', '180', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('537', '0', 'page', '180', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('538', '0', 'page', '180', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('539', '0', 'page', '180', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"108\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=108\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"109\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=109\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"110\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:42:\"http://shop.hweiju.com/wap/good.php?id=110\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('540', '36', 'page', '181', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-08-21 13:32\";}');
INSERT INTO `pigcms_custom_field` VALUES ('541', '36', 'page', '181', 'rich_text', 'a:1:{s:7:\"content\";s:2146:\"<p>感谢您使用汉中微聚网络-微店系统，在汉中微聚网络-微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择汉中微聚网络-微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('546', '37', 'page', '182', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-09-14 17:50\";}');
INSERT INTO `pigcms_custom_field` VALUES ('547', '37', 'page', '182', 'rich_text', 'a:1:{s:7:\"content\";s:2862:\"&lt;p&gt;感谢您使用汉中微聚网络-微店系统，在汉中微聚网络-微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。&lt;/p&gt;&lt;p&gt;在微杂志里，您可以多个功能模块，例如“&lt;strong&gt;富文本&lt;/strong&gt;”模块。在“富文本”里，对文字进行&lt;strong&gt;加粗&lt;/strong&gt;、&lt;em&gt;斜体&lt;/em&gt;、&lt;span style=&quot;text-decoration:underline;&quot;&gt;下划线&lt;/span&gt;、&lt;span style=&quot;text-decoration:line-through;&quot;&gt;删除线&lt;/span&gt;、&lt;span style=&quot;color:rgb(0,176,240);&quot;&gt;文字颜色&lt;/span&gt;、&lt;span style=&quot;color:rgb(255,255,255);background-color:rgb(247,150,70);&quot;&gt;背景色&lt;/span&gt;、以及&lt;span style=&quot;font-size:22px;&quot;&gt;字号大小&lt;/span&gt;等简单排版操作。&lt;/p&gt;&lt;p&gt;也可以在这里，通过编辑器使用表格功能&lt;/p&gt;&lt;table&gt;&lt;tbody&gt;&lt;tr class=&quot;firstRow&quot;&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break: break-all;&quot;&gt;中奖客户&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;发放奖品&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;备注&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;猪猪&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;内测码&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;&lt;span style=&quot;color:rgb(255,0,0);&quot;&gt;已经发放&lt;/span&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;大麦&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;积分&lt;/td&gt;&lt;td width=&quot;133&quot; valign=&quot;top&quot; style=&quot;word-break:break-all;&quot;&gt;&lt;span style=&quot;color:rgb(0,176,240);&quot;&gt;领取地址&lt;/span&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;p&gt;还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。&lt;br&gt;&lt;/p&gt;&lt;p&gt;另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。&lt;/p&gt;&lt;p&gt;再次感谢您选择汉中微聚网络-微店系统！&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('548', '38', 'page', '183', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2015-10-10 09:27\";}');
INSERT INTO `pigcms_custom_field` VALUES ('549', '38', 'page', '183', 'rich_text', 'a:1:{s:7:\"content\";s:2146:\"<p>感谢您使用汉中微聚网络-微店系统，在汉中微聚网络-微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择汉中微聚网络-微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('550', '0', 'page', '184', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('551', '0', 'page', '184', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('552', '0', 'page', '184', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"113\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=115\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"114\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=115\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"115\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=115\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('553', '0', 'page', '185', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('554', '0', 'page', '185', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('555', '0', 'page', '185', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"42\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('556', '0', 'page', '186', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('557', '0', 'page', '186', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('558', '0', 'page', '186', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('559', '0', 'page', '186', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"113\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=114\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"114\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=114\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"115\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=115\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('560', '0', 'page', '187', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('561', '0', 'page', '187', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('562', '0', 'page', '187', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"113\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=114\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"114\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=115\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"115\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=114\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('563', '0', 'page', '188', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('564', '0', 'page', '188', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('565', '0', 'page', '188', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('566', '0', 'page', '188', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"113\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=115\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"114\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=115\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"115\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=115\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('567', '0', 'page', '189', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('568', '0', 'page', '189', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('569', '0', 'page', '189', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('570', '0', 'page', '189', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"113\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=113\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"114\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=113\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"115\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=114\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('571', '0', 'page', '190', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('572', '0', 'page', '190', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('573', '0', 'page', '190', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"116\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=117\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"117\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=118\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"118\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=116\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('574', '0', 'page', '191', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('575', '0', 'page', '191', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('576', '0', 'page', '191', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"43\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('577', '0', 'page', '192', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('578', '0', 'page', '192', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('579', '0', 'page', '192', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('580', '0', 'page', '192', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"116\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=118\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"117\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=117\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"118\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=116\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('581', '0', 'page', '193', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('582', '0', 'page', '193', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('583', '0', 'page', '193', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"116\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=116\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"117\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=117\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"118\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=116\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('584', '0', 'page', '194', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('585', '0', 'page', '194', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('586', '0', 'page', '194', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('587', '0', 'page', '194', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"116\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=117\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"117\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=118\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"118\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=117\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('588', '0', 'page', '195', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('589', '0', 'page', '195', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('590', '0', 'page', '195', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('591', '0', 'page', '195', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"116\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=118\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"117\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=117\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"118\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=116\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('592', '0', 'page', '196', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('593', '0', 'page', '196', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('594', '0', 'page', '196', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"119\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=119\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"120\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=120\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"121\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=121\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('595', '0', 'page', '197', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('596', '0', 'page', '197', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('597', '0', 'page', '197', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"44\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('598', '0', 'page', '198', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('599', '0', 'page', '198', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('600', '0', 'page', '198', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('601', '0', 'page', '198', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"119\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=121\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"120\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=120\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"121\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=119\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('602', '0', 'page', '199', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('603', '0', 'page', '199', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('604', '0', 'page', '199', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"119\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=120\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"120\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=121\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"121\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=119\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('605', '0', 'page', '200', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('606', '0', 'page', '200', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('607', '0', 'page', '200', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('608', '0', 'page', '200', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"119\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=119\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"120\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=119\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"121\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=121\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('609', '0', 'page', '201', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('610', '0', 'page', '201', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('611', '0', 'page', '201', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('612', '0', 'page', '201', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"119\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=120\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"120\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=119\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"121\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=121\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('613', '0', 'page', '202', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('614', '0', 'page', '202', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('615', '0', 'page', '202', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"122\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=124\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"123\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=123\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"124\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=124\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('616', '0', 'page', '203', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('617', '0', 'page', '203', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('618', '0', 'page', '203', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"45\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('619', '0', 'page', '204', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('620', '0', 'page', '204', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('621', '0', 'page', '204', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('622', '0', 'page', '204', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"122\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=124\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"123\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=122\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"124\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=122\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('623', '0', 'page', '205', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('624', '0', 'page', '205', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('625', '0', 'page', '205', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"122\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=124\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"123\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=123\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"124\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=123\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('626', '0', 'page', '206', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('627', '0', 'page', '206', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('628', '0', 'page', '206', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('629', '0', 'page', '206', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"122\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=124\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"123\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=124\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"124\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=122\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('630', '0', 'page', '207', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('631', '0', 'page', '207', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('632', '0', 'page', '207', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('633', '0', 'page', '207', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"122\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=122\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"123\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=124\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"124\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=123\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('634', '0', 'page', '208', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('635', '0', 'page', '208', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('636', '0', 'page', '208', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"125\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=126\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"126\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=125\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"127\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=126\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('637', '0', 'page', '209', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('638', '0', 'page', '209', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('639', '0', 'page', '209', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"46\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('640', '0', 'page', '210', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('641', '0', 'page', '210', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('642', '0', 'page', '210', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('643', '0', 'page', '210', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"125\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=127\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"126\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=127\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"127\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=126\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('644', '0', 'page', '211', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('645', '0', 'page', '211', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('646', '0', 'page', '211', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"125\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=125\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"126\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=126\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"127\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=127\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('647', '0', 'page', '212', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('648', '0', 'page', '212', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('649', '0', 'page', '212', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('650', '0', 'page', '212', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"125\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=125\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"126\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=127\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"127\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=126\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('651', '0', 'page', '213', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('652', '0', 'page', '213', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('653', '0', 'page', '213', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('654', '0', 'page', '213', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"125\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=126\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"126\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=127\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"127\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=127\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('655', '0', 'page', '214', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('656', '0', 'page', '214', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('657', '0', 'page', '214', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"128\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=129\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"129\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=129\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"130\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=128\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('658', '0', 'page', '215', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('659', '0', 'page', '215', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('660', '0', 'page', '215', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"47\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('661', '0', 'page', '216', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('662', '0', 'page', '216', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('663', '0', 'page', '216', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('664', '0', 'page', '216', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"128\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=129\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"129\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=128\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"130\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=128\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('665', '0', 'page', '217', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('666', '0', 'page', '217', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('667', '0', 'page', '217', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"128\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=130\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"129\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=130\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"130\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=128\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('668', '0', 'page', '218', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('669', '0', 'page', '218', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('670', '0', 'page', '218', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('671', '0', 'page', '218', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"128\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=129\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"129\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=128\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"130\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=130\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('672', '0', 'page', '219', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('673', '0', 'page', '219', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('674', '0', 'page', '219', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('675', '0', 'page', '219', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"128\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=130\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"129\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=128\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"130\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=128\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('676', '0', 'page', '220', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('677', '0', 'page', '220', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('678', '0', 'page', '220', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"131\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=133\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"132\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=133\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"133\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=132\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('679', '0', 'page', '221', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('680', '0', 'page', '221', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('681', '0', 'page', '221', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"48\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('682', '0', 'page', '222', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('683', '0', 'page', '222', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('684', '0', 'page', '222', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('685', '0', 'page', '222', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"131\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=131\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"132\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=132\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"133\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=133\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('686', '0', 'page', '223', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('687', '0', 'page', '223', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('688', '0', 'page', '223', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"131\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=132\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"132\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=131\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"133\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=133\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('689', '0', 'page', '224', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('690', '0', 'page', '224', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('691', '0', 'page', '224', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('692', '0', 'page', '224', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"131\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=133\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"132\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=132\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"133\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=132\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('693', '0', 'page', '225', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('694', '0', 'page', '225', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('695', '0', 'page', '225', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('696', '0', 'page', '225', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"131\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=131\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"132\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=131\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"133\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=132\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('697', '0', 'page', '226', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('698', '0', 'page', '226', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('699', '0', 'page', '226', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"134\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=136\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"135\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=135\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"136\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=134\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('700', '0', 'page', '227', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('701', '0', 'page', '227', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('702', '0', 'page', '227', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"49\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('703', '0', 'page', '228', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('704', '0', 'page', '228', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('705', '0', 'page', '228', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('706', '0', 'page', '228', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"134\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=136\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"135\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=136\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"136\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=135\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('707', '0', 'page', '229', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('708', '0', 'page', '229', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('709', '0', 'page', '229', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"134\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=135\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"135\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=134\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"136\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=136\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('710', '0', 'page', '230', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('711', '0', 'page', '230', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('712', '0', 'page', '230', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('713', '0', 'page', '230', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"134\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=134\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"135\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=136\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"136\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=134\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('714', '0', 'page', '231', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('715', '0', 'page', '231', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('716', '0', 'page', '231', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('717', '0', 'page', '231', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"134\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=136\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"135\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=135\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"136\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=134\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('718', '0', 'page', '232', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('719', '0', 'page', '232', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('720', '0', 'page', '232', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"137\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=139\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"138\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=137\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"139\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=137\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('721', '0', 'page', '233', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('722', '0', 'page', '233', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('723', '0', 'page', '233', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:2:\"50\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('724', '0', 'page', '234', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('725', '0', 'page', '234', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('726', '0', 'page', '234', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('727', '0', 'page', '234', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"137\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=139\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"138\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=139\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"139\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=139\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('728', '0', 'page', '235', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('729', '0', 'page', '235', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('730', '0', 'page', '235', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"137\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=139\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"138\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=138\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"139\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=138\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('731', '0', 'page', '236', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('732', '0', 'page', '236', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('733', '0', 'page', '236', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('734', '0', 'page', '236', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"137\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=138\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"138\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=137\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"139\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=137\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('735', '0', 'page', '237', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('736', '0', 'page', '237', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('737', '0', 'page', '237', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('738', '0', 'page', '237', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:3:\"137\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=137\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:3:\"138\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=137\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:3:\"139\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:39:\"http://www.ooxx.com/wap/good.php?id=139\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');

-- ----------------------------
-- Table structure for `pigcms_custom_page`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_custom_page`;
CREATE TABLE `pigcms_custom_page` (
  `page_id` int(10) NOT NULL auto_increment COMMENT '自定义页面id',
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `name` varchar(100) NOT NULL default '' COMMENT '自定页面模块名',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY  (`page_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='自定义页面模块';

-- ----------------------------
-- Records of pigcms_custom_page
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_diymenu_class`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_diymenu_class`;
CREATE TABLE `pigcms_diymenu_class` (
  `id` int(11) NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL,
  `pid` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `is_show` tinyint(1) NOT NULL,
  `sort` tinyint(3) NOT NULL,
  `url` varchar(300) NOT NULL default '',
  `wxsys` char(40) NOT NULL,
  `content` varchar(500) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT 'type [0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]',
  `fromid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_diymenu_class
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_express`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_express`;
CREATE TABLE `pigcms_express` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(200) NOT NULL,
  `sort` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='快递公司表';

-- ----------------------------
-- Records of pigcms_express
-- ----------------------------
INSERT INTO `pigcms_express` VALUES ('1', 'ems', 'ems快递', 'http://www.ems.com.cn/', '0', '1419225737', '1');
INSERT INTO `pigcms_express` VALUES ('2', 'shentong', '申通快递', 'http://www.sto.cn/', '0', '1419220300', '1');
INSERT INTO `pigcms_express` VALUES ('3', 'yuantong', '圆通速递', 'http://www.yto.net.cn/', '0', '1419220397', '1');
INSERT INTO `pigcms_express` VALUES ('4', 'shunfeng', '顺丰速运', 'http://www.sf-express.com/', '0', '1419220418', '1');
INSERT INTO `pigcms_express` VALUES ('5', 'tiantian', '天天快递', 'http://www.ttkd.cn/', '0', '1419220435', '1');
INSERT INTO `pigcms_express` VALUES ('6', 'yunda', '韵达快递', 'http://www.yundaex.com/', '0', '1419220474', '1');
INSERT INTO `pigcms_express` VALUES ('7', 'zhongtong', '中通速递', 'http://www.zto.cn/', '0', '1419220493', '1');
INSERT INTO `pigcms_express` VALUES ('8', 'longbanwuliu', '龙邦物流', 'http://www.lbex.com.cn/', '0', '1419220511', '1');
INSERT INTO `pigcms_express` VALUES ('9', 'zhaijisong', '宅急送', 'http://www.zjs.com.cn/', '0', '1419220528', '1');
INSERT INTO `pigcms_express` VALUES ('10', 'quanyikuaidi', '全一快递', 'http://www.apex100.com/', '0', '1419220551', '1');
INSERT INTO `pigcms_express` VALUES ('11', 'huitongkuaidi', '汇通速递', 'http://www.htky365.com/', '0', '1419220569', '1');
INSERT INTO `pigcms_express` VALUES ('12', 'minghangkuaidi', '民航快递', 'http://www.cae.com.cn/', '0', '1419220586', '1');
INSERT INTO `pigcms_express` VALUES ('13', 'yafengsudi', '亚风速递', 'http://www.airfex.cn/', '0', '1419220605', '1');
INSERT INTO `pigcms_express` VALUES ('14', 'kuaijiesudi', '快捷速递', 'http://www.fastexpress.com.cn/', '0', '1419220623', '1');
INSERT INTO `pigcms_express` VALUES ('15', 'tiandihuayu', '天地华宇', 'http://www.hoau.net/', '0', '1419220676', '1');
INSERT INTO `pigcms_express` VALUES ('16', 'zhongtiekuaiyun', '中铁快运', 'http://www.cre.cn/', '0', '1427265253', '1');
INSERT INTO `pigcms_express` VALUES ('17', 'deppon', '德邦物流', 'http://www.deppon.com/', '0', '1427265464', '1');

-- ----------------------------
-- Table structure for `pigcms_financial_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_financial_record`;
CREATE TABLE `pigcms_financial_record` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL default '0' COMMENT '店铺id',
  `order_id` int(11) NOT NULL default '0' COMMENT '订单id',
  `order_no` varchar(100) NOT NULL default '' COMMENT '订单号',
  `income` decimal(10,2) NOT NULL default '0.00' COMMENT '收入 负值为支出',
  `type` tinyint(1) NOT NULL COMMENT '类型 1订单入账 2提现 3退款 4系统退款 5分销',
  `balance` decimal(10,2) NOT NULL default '0.00' COMMENT '余额',
  `payment_method` varchar(30) NOT NULL default '' COMMENT '支付方式',
  `trade_no` varchar(100) NOT NULL default '' COMMENT '交易号',
  `add_time` int(11) NOT NULL default '0' COMMENT '时间',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态 1进行中 2退款 3成功 4失败',
  `user_order_id` int(11) unsigned NOT NULL default '0' COMMENT '用户订单id,统一分销订单',
  `profit` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '分销利润',
  `storeOwnPay` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`pigcms_id`),
  KEY `order_id` USING BTREE (`order_id`),
  KEY `order_no` USING BTREE (`order_no`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='财务记录';

-- ----------------------------
-- Records of pigcms_financial_record
-- ----------------------------
INSERT INTO `pigcms_financial_record` VALUES ('1', '29', '18', '20150819214708563365', '2.00', '1', '0.00', 'weixin', '20150819214714168436', '1439992050', '3', '18', '0.00', '0');
INSERT INTO `pigcms_financial_record` VALUES ('2', '29', '17', '20150819214612378206', '2.00', '1', '2.00', 'CardPay', '20150819215626652154', '1439992607', '3', '17', '0.00', '0');
INSERT INTO `pigcms_financial_record` VALUES ('3', '29', '20', '20150819221053307724', '2.00', '1', '4.00', 'weixin', '20150819221315519011', '1439993625', '1', '20', '0.00', '0');

-- ----------------------------
-- Table structure for `pigcms_first`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_first`;
CREATE TABLE `pigcms_first` (
  `id` int(11) NOT NULL auto_increment,
  `type` tinyint(1) NOT NULL,
  `content` varchar(500) NOT NULL COMMENT '回复内容',
  `fromid` tinyint(1) unsigned NOT NULL COMMENT '网站功能回复（1：网站首页，2:团购，3：订餐）',
  `title` varchar(50) NOT NULL COMMENT '图文回复标题',
  `info` varchar(200) NOT NULL COMMENT '图文回复内容',
  `pic` varchar(200) NOT NULL COMMENT '图文回复图片',
  `url` varchar(200) NOT NULL COMMENT '图文回复外站链接',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_first
-- ----------------------------
INSERT INTO `pigcms_first` VALUES ('1', '1', '', '0', '11111', '1111111', 'platform/000/000/001/56739659e9bfd.jpg', '');

-- ----------------------------
-- Table structure for `pigcms_flink`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_flink`;
CREATE TABLE `pigcms_flink` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `info` varchar(100) NOT NULL,
  `url` varchar(150) NOT NULL,
  `add_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  `sort` smallint(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_flink
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_fx_order`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_fx_order`;
CREATE TABLE `pigcms_fx_order` (
  `fx_order_id` int(10) unsigned NOT NULL auto_increment,
  `fx_order_no` varchar(100) NOT NULL default '' COMMENT '订单号',
  `fx_trade_no` varchar(100) NOT NULL default '' COMMENT '交易单号',
  `uid` int(11) NOT NULL default '0' COMMENT '买家id',
  `session_id` varchar(32) NOT NULL,
  `order_id` int(11) unsigned NOT NULL default '0' COMMENT '主订单id',
  `order_no` varchar(100) NOT NULL default '' COMMENT '主订单号',
  `supplier_id` int(11) NOT NULL default '0' COMMENT '供货商id',
  `store_id` int(11) NOT NULL default '0' COMMENT '分销商id',
  `postage` decimal(10,2) NOT NULL default '0.00' COMMENT '运费',
  `sub_total` decimal(10,2) NOT NULL default '0.00' COMMENT '商品总价',
  `cost_sub_total` decimal(10,2) NOT NULL default '0.00' COMMENT '商品成本总价',
  `quantity` int(5) NOT NULL default '0' COMMENT '商品数量',
  `total` decimal(10,2) NOT NULL default '0.00' COMMENT '订单金额',
  `cost_total` decimal(10,2) NOT NULL default '0.00' COMMENT '成本总额',
  `status` tinyint(1) NOT NULL default '1' COMMENT '订单状态',
  `add_time` int(11) unsigned NOT NULL default '0' COMMENT '下单时间',
  `paid_time` int(11) unsigned NOT NULL default '0' COMMENT '付款时间',
  `supplier_sent_time` int(11) NOT NULL default '0' COMMENT '供货商发货时间',
  `complate_time` int(11) NOT NULL default '0' COMMENT '交易完成时间',
  `delivery_user` varchar(100) NOT NULL default '' COMMENT '收货人',
  `delivery_tel` varchar(30) NOT NULL default '' COMMENT '收货人电话',
  `delivery_address` varchar(200) NOT NULL default '' COMMENT '收货地址',
  `user_order_id` int(11) unsigned NOT NULL default '0' COMMENT '用户订单id,统一分销订单',
  `suppliers` varchar(500) NOT NULL default '' COMMENT '供货商',
  `fx_postage` varchar(500) NOT NULL default '' COMMENT '分销运费',
  PRIMARY KEY  (`fx_order_id`),
  KEY `uid` USING BTREE (`uid`),
  KEY `order_no` USING BTREE (`order_no`),
  KEY `supplier_id` USING BTREE (`supplier_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销订单';

-- ----------------------------
-- Records of pigcms_fx_order
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_fx_order_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_fx_order_product`;
CREATE TABLE `pigcms_fx_order_product` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `fx_order_id` int(10) unsigned NOT NULL default '0' COMMENT '分销订单id',
  `product_id` int(10) unsigned NOT NULL default '0' COMMENT '商品id',
  `price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '单价',
  `cost_price` decimal(10,2) NOT NULL default '0.00' COMMENT '成本价',
  `quantity` int(5) NOT NULL default '0' COMMENT '数量',
  `sku_id` int(10) unsigned NOT NULL default '0' COMMENT '库存id',
  `sku_data` text NOT NULL COMMENT '库存信息',
  `comment` text NOT NULL COMMENT '买家留言',
  `source_product_id` int(11) unsigned NOT NULL default '0' COMMENT '源商品id',
  PRIMARY KEY  (`pigcms_id`),
  KEY `fx_order_id` USING BTREE (`fx_order_id`),
  KEY `product_id` USING BTREE (`product_id`),
  KEY `sku_id` USING BTREE (`sku_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销订单商品';

-- ----------------------------
-- Records of pigcms_fx_order_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_image_text`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_image_text`;
CREATE TABLE `pigcms_image_text` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL COMMENT '标题',
  `author` varchar(10) NOT NULL COMMENT '作者',
  `cover_pic` varchar(200) NOT NULL COMMENT '封面图',
  `digest` varchar(300) NOT NULL COMMENT '介绍',
  `content` text NOT NULL COMMENT '内容',
  `url` varchar(200) NOT NULL COMMENT '外链',
  `dateline` int(10) unsigned NOT NULL COMMENT '创建时间',
  `is_show` tinyint(1) unsigned NOT NULL COMMENT '封面图是否显示正文（0:不显示，1：显示）',
  `url_title` varchar(300) NOT NULL COMMENT '外链名称',
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图文表';

-- ----------------------------
-- Records of pigcms_image_text
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_keyword`;
CREATE TABLE `pigcms_keyword` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL,
  `content` varchar(200) NOT NULL,
  `from_id` int(11) NOT NULL,
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_keyword
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_location_qrcode`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_location_qrcode`;
CREATE TABLE `pigcms_location_qrcode` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `ticket` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL,
  `openid` char(40) NOT NULL,
  `lat` char(10) NOT NULL,
  `lng` char(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=400000942 DEFAULT CHARSET=utf8 COMMENT='使用微信登录生成的临时二维码';

-- ----------------------------
-- Records of pigcms_location_qrcode
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_login_qrcode`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_login_qrcode`;
CREATE TABLE `pigcms_login_qrcode` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `ticket` varchar(500) NOT NULL,
  `uid` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100000028 DEFAULT CHARSET=utf8 COMMENT='使用微信登录生成的临时二维码';

-- ----------------------------
-- Records of pigcms_login_qrcode
-- ----------------------------
INSERT INTO `pigcms_login_qrcode` VALUES ('100000027', 'gQFS8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BVeWV0czNsS0FGUmItWXRlbUs4AAIE8n/UVQMEgDoJAA==', '0', '1439989737');

-- ----------------------------
-- Table structure for `pigcms_meal`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal`;
CREATE TABLE `pigcms_meal` (
  `meal_id` int(11) NOT NULL auto_increment,
  `sort_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL COMMENT '名称',
  `unit` varchar(10) NOT NULL COMMENT '单位',
  `label` varchar(10) NOT NULL COMMENT '商品标签',
  `old_price` decimal(8,2) NOT NULL COMMENT '原价',
  `price` decimal(8,2) NOT NULL COMMENT '价格',
  `vip_price` decimal(8,2) NOT NULL COMMENT '会员特定价，不走会员打折价的价格',
  `image` varchar(50) NOT NULL COMMENT '图片',
  `des` text NOT NULL COMMENT '描述',
  `last_time` int(11) NOT NULL COMMENT '最后修改时间',
  `sort` int(11) NOT NULL,
  `sell_count` int(11) NOT NULL COMMENT '销售量',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态，1为开启',
  `sell_mouth` int(10) unsigned NOT NULL COMMENT '月份',
  PRIMARY KEY  (`meal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=utf8 COMMENT='订餐商品表';

-- ----------------------------
-- Records of pigcms_meal
-- ----------------------------
INSERT INTO `pigcms_meal` VALUES ('239', '11', '64', '串串香', '份', '特价', '28.00', '10.00', '10.00', '53/000/000/068,55a61e2c78535.jpg', '好吃不贵', '1436950060', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('240', '12', '62', '羊肉', '份', '促销', '45.00', '36.00', '0.00', '51/000/000/068,55a621930782b.jpg', '羊肉一份', '1436950930', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('241', '13', '61', '鸡肉', '份', '特价', '20.00', '15.00', '0.00', '90/000/000/068,55a621f6509c4.jpg', '一份', '1436951030', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('242', '14', '60', '演示', '份', '特价', '5.00', '10.00', '0.00', '38/000/000/068,55a622ec3f12f.jpg', '测试', '1436951276', '0', '6', '1', '201509');
INSERT INTO `pigcms_meal` VALUES ('243', '15', '65', '麻辣新语', '份', '招牌', '108.00', '68.00', '0.00', '56/000/000/068,55a625cbd871d.jpg', '麻辣新语成立', '1436952011', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('244', '16', '66', '门票', '个', '特价', '130.00', '18.00', '0.00', '80/000/000/068,55a6288ec9ca1.jpg', '中原影视城', '1436952718', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('245', '17', '67', '门票', '个', '特价', '230.00', '200.00', '0.00', '62/000/000/068,55a629024ca05.jpg', '方特一日游', '1436952834', '0', '0', '1', '0');

-- ----------------------------
-- Table structure for `pigcms_meal_cz`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_cz`;
CREATE TABLE `pigcms_meal_cz` (
  `cz_id` int(10) unsigned NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL default '0',
  `name` text NOT NULL,
  `wz_id` int(10) unsigned default NULL,
  `image` varchar(255) default NULL,
  `zno` varchar(255) default NULL,
  `seller_id` varchar(20) default NULL,
  `price` varchar(255) default NULL,
  `status` varchar(60) default NULL,
  `description` text,
  `image2` text,
  `image3` text,
  `add_time` text,
  `images` text,
  PRIMARY KEY  (`cz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_meal_cz
-- ----------------------------
INSERT INTO `pigcms_meal_cz` VALUES ('7', '4', '茶马古道', '4', 'data/files/store_2/chaguan/chaguan_image_1_1441504397.jpg', '12', '37', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441504397.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504397.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('8', '4', '开封古都', '4', 'data/files/store_2/chaguan/chaguan_image_1_1441504373.jpg', '12', '37', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441504373.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504373.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('9', '4', '南京古韵', '4', 'data/files/store_2/chaguan/chaguan_image_1_1441504338.jpg', '12', '37', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441504338.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504338.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('10', '4', '夜上海', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441504300.jpg', '12', '37', '300', '1', '夜上海', 'data/files/store_2/chaguan/chaguan_image_2_1441504300.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504300.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('5', '2', '甘趣', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501963.jpg', '12', '37', '300', '1', '甘趣甘趣', 'data/files/store_2/chaguan/chaguan_image_2_1441501963.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501963.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('6', '4', '北京时间', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441504420.jpg', '10', '37', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441504420.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504420.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('33', '4', '小憩二刻', '2', './upload/images/000/000/037/201509/55f90a639015a.jpg', '8', '37', '500', '1', '打发士大夫撒地方阿道夫 ', './upload/images/000/000/037/201509/55f909fc33ad1.jpg', './upload/images/000/000/037/201509/55f909fc34cb0.jpg', '1442384483', null);
INSERT INTO `pigcms_meal_cz` VALUES ('34', '4', '精品蔬菜', '2', null, '6', '37', '500', '1', '阿萨德发', null, null, '1442453739', null);
INSERT INTO `pigcms_meal_cz` VALUES ('17', '4', '幽香啊阿萨德', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441504089.jpg', '32', '37', '300', '1', '幽香', 'data/files/store_2/chaguan/chaguan_image_2_1441504089.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504089.jpg', '1442306528', null);
INSERT INTO `pigcms_meal_cz` VALUES ('18', '2', '南秀', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501221.jpg', '12', '2', '300', '1', '南秀', 'data/files/store_2/chaguan/chaguan_image_2_1441501221.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501221.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('29', '1', '西安唐貌', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441504135.jpg', '12', '2', '300', '1', '西安唐貌', 'data/files/store_2/chaguan/chaguan_image_2_1441504135.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504135.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('20', '2', '兰芷', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501536.jpg', '12', '2', '300', '1', '兰芷', 'data/files/store_2/chaguan/chaguan_image_2_1441501536.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501536.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('21', '2', '甘霖', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501836.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501836.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501836.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('22', '2', '清香', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501593.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501593.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501593.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('23', '2', '秋鸿', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501628.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501628.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501628.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('24', '2', '瑞草', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501661.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501661.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501661.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('25', '2', '山岚', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501697.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501697.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501697.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('26', '2', '天乐', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501728.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501728.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501728.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('27', '2', '怡悦', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501754.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501754.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501754.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('28', '2', '酽香', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441503445.jpg', '12', '2', '300', '1', '酽香', 'data/files/store_2/chaguan/chaguan_image_2_1441503445.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441503445.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('30', '1', '大厅', '1', 'data/files/store_2/chaguan/chaguan_image_1_1441595086.jpg', '50', '2', '300', '1', '大厅', 'data/files/store_2/chaguan/chaguan_image_2_1441595086.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441595086.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('31', '3', '大厅', '1', 'data/files/store_2/chaguan/chaguan_image_1_1441595739.jpg', '50', '2', '300', '1', '大厅', 'data/files/store_2/chaguan/chaguan_image_2_1441595739.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441595739.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('32', '2', '大厅', '1', 'data/files/store_2/chaguan/chaguan_image_1_1441505892.jpg', '50', '2', '300', '1', '大厅', 'data/files/store_2/chaguan/chaguan_image_2_1441505892.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441505892.jpg', null, null);

-- ----------------------------
-- Table structure for `pigcms_meal_like`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_like`;
CREATE TABLE `pigcms_meal_like` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned NOT NULL,
  `mer_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `meal_ids` text NOT NULL,
  PRIMARY KEY  (`pigcms_id`),
  KEY `uid` (`uid`,`mer_id`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_meal_like
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_meal_order`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_order`;
CREATE TABLE `pigcms_meal_order` (
  `order_id` int(10) unsigned NOT NULL auto_increment,
  `uid` int(10) unsigned default NULL COMMENT '用户id',
  `store_id` int(10) unsigned default NULL COMMENT '店铺ID',
  `store_uid` int(10) unsigned default NULL COMMENT '操作店员ID',
  `orderid` varchar(22) default NULL COMMENT '订单号',
  `status` tinyint(1) unsigned default NULL COMMENT '订单状态（0:未使用，1:已使用，2:已评价，3：已删除）',
  `name` varchar(20) default NULL COMMENT '点单人姓名',
  `phone` varchar(15) default NULL COMMENT '电话',
  `tableid` text COMMENT '桌台号',
  `dateline` int(10) unsigned default NULL COMMENT '下单时间',
  `use_time` int(10) unsigned default NULL COMMENT '消费时间',
  `dd_time` text,
  `sc` text,
  `bz` text,
  PRIMARY KEY  (`order_id`),
  KEY `store_id` (`store_id`,`orderid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=utf8 COMMENT='餐饮订单表';

-- ----------------------------
-- Records of pigcms_meal_order
-- ----------------------------
INSERT INTO `pigcms_meal_order` VALUES ('116', '619', '60', '0', '6860201507152347124438', '0', '112121', '212121', '0', '1436975232', '0', '0', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('119', '633', '60', '0', '2015090520101300000633', '0', '王李海霞', '13625656565', '0', '1441455013', '0', '1441462626', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('135', '76', '4', '37', '20150917100444000076', '4', '小憩二刻', '13628883553', '9', '1442455484', '1442461980', '2015-09-17 10:04:37', '3', '阿法士大夫');
INSERT INTO `pigcms_meal_order` VALUES ('121', '639', '4', '0', '2015090609134100000639', '2', '哦哦', '13812345678', '5', '1441502021', '0', '1441502026', '2', null);
INSERT INTO `pigcms_meal_order` VALUES ('122', '633', '4', '0', '2015090612310800000633', '4', '王', '13656565656', '6', '1441513868', '1442391141', '1441513873', '2', '打发士大夫大发');
INSERT INTO `pigcms_meal_order` VALUES ('123', '76', '4', '37', '2015090612342900000626', '3', '饭否', '13252254521', '7', '1441514069', '1442391115', '1441514091', '1', '噶发发都是');
INSERT INTO `pigcms_meal_order` VALUES ('125', null, '76', null, '20150916174109000076', null, null, null, null, '1442396469', null, null, null, null);
INSERT INTO `pigcms_meal_order` VALUES ('134', null, '4', '76', '20150916175933000076', '1', '精品蔬菜', '13628883553', '17', '1442397573', null, '2015-09-16 17:59:28', '3', '撒大师大师');
INSERT INTO `pigcms_meal_order` VALUES ('140', '76', '4', '37', '20150918153351000076', '1', '乐呵乐呵', '13628883553', '34', '1442561631', null, '2015-09-18 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('136', '76', '4', '37', '20150918152952000076', '1', '乐呵乐呵', '13628883553', '34', '1442561392', null, '2015-09-18 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('137', '76', '4', '37', '20150918153217000076', '1', '乐呵乐呵', '13628883553', '34', '1442561537', null, '2015-10-16 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('138', '76', '4', '37', '20150918153312000076', '1', '乐呵乐呵', '13628883553', '34', '1442561592', null, '2015-10-13 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('139', '76', '4', '37', '20150918153330000076', '1', '乐呵乐呵', '13628883553', '34', '1442561610', null, '2015-10-10 03:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('141', '76', '4', '37', '20150918153428000076', '1', '乐呵乐呵', '13628883553', '34', '1442561668', null, '2015-10-11 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('142', '76', '4', '37', '20150918153642000076', '1', '乐呵乐呵', '13628883553', '34', '1442561802', null, '2015-09-18 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('143', '76', '4', '37', '20150918153722000076', '1', '乐呵乐呵', '13628883553', '34', '1442561842', null, '2015-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('144', '76', '4', '37', '20150918154523000076', '1', '乐呵乐呵', '13628883553', '98', '1442562323', null, '2014-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('145', '76', '4', '37', '20150918154618000076', '1', '乐呵乐呵', '13628883553', '98', '1442562378', null, '2014-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('146', '76', '4', '37', '20150918154801000076', '1', '乐呵乐呵', '13628883553', '98', '1442562481', null, '2014-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('147', '76', '4', '37', '20150918154815000076', '1', '乐呵乐呵', '13628883553', '98', '1442562495', null, '2014-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('148', '76', '4', '37', '20150918154917000076', '1', '乐呵乐呵', '13628883553', '98', '1442562557', null, '2014-09-18 19:00', '1', null);

-- ----------------------------
-- Table structure for `pigcms_meal_sell_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_sell_log`;
CREATE TABLE `pigcms_meal_sell_log` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `meal_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `mouth` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`pigcms_id`),
  KEY `meal_id` (`meal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_meal_sell_log
-- ----------------------------
INSERT INTO `pigcms_meal_sell_log` VALUES ('1', '242', '1', '201507');

-- ----------------------------
-- Table structure for `pigcms_meal_sort`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_sort`;
CREATE TABLE `pigcms_meal_sort` (
  `sort_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `sort_name` varchar(50) NOT NULL COMMENT '分类名称',
  `sort` int(11) NOT NULL COMMENT '排序',
  `is_weekshow` tinyint(1) NOT NULL default '0' COMMENT '是否星期几显示',
  `week` varchar(50) NOT NULL COMMENT '星期几显示，用逗号分割存储',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`sort_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='订餐分类表';

-- ----------------------------
-- Records of pigcms_meal_sort
-- ----------------------------
INSERT INTO `pigcms_meal_sort` VALUES ('11', '64', '小吃', '0', '0', '1,2,3,4,5,6', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('12', '62', '小吃', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('13', '61', '小吃', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('14', '60', '小吃', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('15', '65', '小吃', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('16', '66', '门票', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('17', '67', '门票', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('18', '74', '2123', '1', '1', '', '0');

-- ----------------------------
-- Table structure for `pigcms_meal_store_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_store_category`;
CREATE TABLE `pigcms_meal_store_category` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_fid` int(11) NOT NULL,
  `cat_name` varchar(20) NOT NULL,
  `cat_url` varchar(20) NOT NULL,
  `cat_sort` int(11) NOT NULL,
  `cat_status` int(11) NOT NULL,
  PRIMARY KEY  (`cat_id`,`cat_fid`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='订餐分类';

-- ----------------------------
-- Records of pigcms_meal_store_category
-- ----------------------------
INSERT INTO `pigcms_meal_store_category` VALUES ('1', '0', '餐饮美食', 'wcyms', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('2', '0', '自助烧烤', 'wzzsk', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('12', '1', '中式快餐', 'azskc', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('13', '1', '中式正餐', 'azszc', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('14', '1', '西式快餐', 'axskc', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('16', '1', '特色小吃', 'atsxc', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('17', '1', '日韩料理', 'arhll', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('18', '1', '糕点饮品', 'agdyp', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('19', '2', '自助餐', 'zzzc', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('20', '0', '饰品', 'wsp', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('21', '20', '毛绒玩具', 'pmrwj', '0', '1');
INSERT INTO `pigcms_meal_store_category` VALUES ('22', '20', '发饰', 'pfs', '0', '1');

-- ----------------------------
-- Table structure for `pigcms_meal_store_category_relation`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_store_category_relation`;
CREATE TABLE `pigcms_meal_store_category_relation` (
  `store_id` int(11) NOT NULL,
  `cat_fid` int(10) unsigned NOT NULL,
  `cat_id` int(11) NOT NULL,
  KEY `store_id` (`store_id`),
  KEY `cat_id` (`cat_id`),
  KEY `cat_fid` (`cat_fid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_meal_store_category_relation
-- ----------------------------
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('13', '0', '1');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('30', '0', '2');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('63', '2', '19');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('63', '1', '18');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('63', '1', '17');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('63', '1', '16');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('63', '1', '14');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('63', '1', '13');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('63', '1', '12');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('64', '2', '19');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('61', '1', '12');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('60', '1', '16');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('65', '1', '16');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('66', '1', '16');
INSERT INTO `pigcms_meal_store_category_relation` VALUES ('71', '20', '21');

-- ----------------------------
-- Table structure for `pigcms_my_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_my_supplier`;
CREATE TABLE `pigcms_my_supplier` (
  `seller_store_id` int(11) NOT NULL default '0' COMMENT '分销商店铺id',
  `seller_id` int(11) NOT NULL default '0' COMMENT '分销商id',
  `supplier_store_id` int(11) NOT NULL default '0' COMMENT '供货商店铺id',
  `supplier_id` int(11) NOT NULL default '0' COMMENT '供货商id',
  KEY `seller_store_id` USING BTREE (`seller_store_id`),
  KEY `supplier_store_id` USING BTREE (`supplier_store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='我的供货商';

-- ----------------------------
-- Records of pigcms_my_supplier
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_ng_word`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_ng_word`;
CREATE TABLE `pigcms_ng_word` (
  `id` int(11) NOT NULL auto_increment,
  `ng_word` varchar(100) NOT NULL,
  `replace_word` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `ng_word` USING BTREE (`ng_word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='敏感词表';

-- ----------------------------
-- Records of pigcms_ng_word
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order`;
CREATE TABLE `pigcms_order` (
  `order_id` int(10) unsigned NOT NULL auto_increment COMMENT '订单id',
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `order_no` varchar(100) NOT NULL COMMENT '订单号',
  `trade_no` varchar(100) NOT NULL COMMENT '交易号',
  `pay_type` varchar(10) NOT NULL COMMENT '支付方式',
  `third_id` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL default '0' COMMENT '买家id',
  `session_id` varchar(32) NOT NULL,
  `postage` decimal(10,2) NOT NULL default '0.00' COMMENT '邮费',
  `sub_total` decimal(10,2) NOT NULL default '0.00' COMMENT '商品金额（不含邮费）',
  `total` decimal(10,2) NOT NULL default '0.00' COMMENT '订单金额（含邮费）',
  `pro_count` int(11) NOT NULL COMMENT '商品的个数',
  `pro_num` int(10) NOT NULL default '0' COMMENT '商品数量',
  `address` text NOT NULL COMMENT '收货地址',
  `address_user` varchar(30) NOT NULL default '' COMMENT '收货人',
  `address_tel` varchar(20) NOT NULL default '' COMMENT '收货人电话',
  `payment_method` varchar(50) NOT NULL default '' COMMENT '支付方式',
  `shipping_method` varchar(50) NOT NULL default '' COMMENT '物流方式 express快递发货 selffetch上门自提',
  `type` tinyint(1) NOT NULL default '0' COMMENT '订单类型 0普通 1代付 2送礼 3分销',
  `status` tinyint(1) NOT NULL default '0' COMMENT '订单状态 0临时订单 1未支付 2未发货 3已发货 4已完成 5已取消 6退款中 ',
  `add_time` int(11) NOT NULL default '0' COMMENT '订单时间',
  `paid_time` int(11) NOT NULL default '0' COMMENT '付款时间',
  `sent_time` int(11) NOT NULL default '0' COMMENT '发货时间',
  `cancel_time` int(11) NOT NULL default '0' COMMENT '取消时间',
  `complate_time` int(11) NOT NULL,
  `refund_time` int(11) NOT NULL COMMENT '退款时间',
  `comment` varchar(500) NOT NULL default '' COMMENT '买家留言',
  `bak` varchar(500) NOT NULL default '' COMMENT '备注',
  `star` tinyint(1) NOT NULL default '0' COMMENT '加星订单 1|2|3|4|5 默认0',
  `pay_money` decimal(10,2) NOT NULL COMMENT '实际付款金额',
  `cancel_method` tinyint(1) NOT NULL default '0' COMMENT '订单取消方式 0过期自动取消 1卖家手动取消 2买家手动取消',
  `float_amount` decimal(10,2) NOT NULL default '0.00' COMMENT '订单浮动金额',
  `is_fx` tinyint(1) NOT NULL default '0' COMMENT '是否包含分销商品 0 否 1是',
  `fx_order_id` int(11) unsigned NOT NULL default '0' COMMENT '分销订单id',
  `user_order_id` int(11) unsigned NOT NULL default '0' COMMENT '用户订单id,统一分销订单',
  `suppliers` varchar(500) NOT NULL default '' COMMENT '商品供货商',
  `packaging` tinyint(1) unsigned NOT NULL default '0' COMMENT '打包中',
  `fx_postage` varchar(500) NOT NULL default '' COMMENT '分销运费详细 supplier_id=>postage',
  `useStorePay` tinyint(1) NOT NULL default '0',
  `storeOpenid` varchar(100) NOT NULL,
  `sales_ratio` decimal(10,2) NOT NULL COMMENT '商家销售分成比例,按照所填百分比进行扣除',
  `is_check` tinyint(1) NOT NULL default '1' COMMENT '是否对账，1：未对账，2：已对账',
  PRIMARY KEY  (`order_id`),
  UNIQUE KEY `order_no` (`order_no`),
  UNIQUE KEY `trade_no` (`trade_no`),
  KEY `store_id` USING BTREE (`store_id`),
  KEY `uid` USING BTREE (`uid`),
  KEY `store_id_2` USING BTREE (`store_id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='订单';

-- ----------------------------
-- Records of pigcms_order
-- ----------------------------
INSERT INTO `pigcms_order` VALUES ('23', '36', '20151216111812818930', '20151216111812818930', '', '', '76', '', '0.00', '1.00', '1.00', '1', '1', '', '', '', '', '', '0', '0', '1450235892', '0', '0', '0', '0', '0', '', '', '0', '0.00', '0', '0.00', '0', '0', '0', '36', '0', 'a:1:{i:36;d:0;}', '0', '', '0.00', '1');

-- ----------------------------
-- Table structure for `pigcms_order_check_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_check_log`;
CREATE TABLE `pigcms_order_check_log` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(10) default NULL COMMENT '订单id',
  `order_no` varchar(100) default NULL COMMENT '订单号',
  `store_id` int(11) default NULL COMMENT '被操作的商铺id',
  `description` varchar(255) default NULL COMMENT '描述',
  `admin_uid` int(11) default NULL COMMENT '操作人uid',
  `ip` bigint(20) default NULL COMMENT '操作人ip',
  `timestamp` int(11) default NULL COMMENT '记录的时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_order_check_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_coupon`;
CREATE TABLE `pigcms_order_coupon` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `coupon_id` int(11) NOT NULL default '0' COMMENT '优惠券ID',
  `name` varchar(255) NOT NULL COMMENT '优惠券名称',
  `user_coupon_id` int(11) NOT NULL default '0' COMMENT 'user_coupon表id',
  `money` float(8,2) NOT NULL COMMENT '优惠券金额',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_order_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_package`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_package`;
CREATE TABLE `pigcms_order_package` (
  `package_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL default '0' COMMENT '店铺id',
  `order_id` int(11) NOT NULL default '0' COMMENT '订单id',
  `express_code` varchar(50) NOT NULL,
  `express_company` varchar(50) NOT NULL default '' COMMENT '快递公司',
  `express_no` varchar(50) NOT NULL default '' COMMENT '快递单号',
  `status` tinyint(1) NOT NULL default '0' COMMENT '状态 0未发货 1已发货 2已到店 3已签收',
  `add_time` int(11) NOT NULL default '0' COMMENT '创建时间',
  `sign_name` varchar(30) NOT NULL default '' COMMENT '签收人',
  `sign_time` int(11) NOT NULL default '0' COMMENT '签收时间',
  `products` varchar(500) NOT NULL default '' COMMENT '商品集合',
  `user_order_id` int(11) unsigned NOT NULL default '0' COMMENT '用户订单id',
  PRIMARY KEY  (`package_id`),
  KEY `store_id` USING BTREE (`store_id`),
  KEY `order_id` USING BTREE (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='订单包裹';

-- ----------------------------
-- Records of pigcms_order_package
-- ----------------------------
INSERT INTO `pigcms_order_package` VALUES ('1', '29', '18', '', '', '', '1', '0', '', '0', '59', '18');
INSERT INTO `pigcms_order_package` VALUES ('2', '29', '17', '', '', '', '1', '0', '', '0', '59', '17');

-- ----------------------------
-- Table structure for `pigcms_order_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_product`;
CREATE TABLE `pigcms_order_product` (
  `pigcms_id` int(11) NOT NULL auto_increment COMMENT '订单商品id',
  `order_id` int(10) NOT NULL default '0' COMMENT '订单id',
  `product_id` int(10) NOT NULL default '0' COMMENT '商品id',
  `sku_id` int(10) NOT NULL default '0' COMMENT '库存id',
  `sku_data` text NOT NULL COMMENT '库存信息',
  `pro_num` int(10) NOT NULL default '0' COMMENT '数量',
  `pro_price` decimal(10,2) NOT NULL,
  `pro_weight` float(10,2) NOT NULL COMMENT '每一个产品的重量，单位：克',
  `comment` text NOT NULL COMMENT '买家留言',
  `is_packaged` tinyint(1) NOT NULL default '0' COMMENT '是否已打包 0未打包 1已打包',
  `in_package_status` tinyint(1) NOT NULL COMMENT '在包裹里的状态 0未发货 1已发货 2已到店 3已签收',
  `is_fx` tinyint(1) NOT NULL default '0' COMMENT '分销商品 0否 1是',
  `supplier_id` int(11) unsigned NOT NULL default '0' COMMENT '供货商id',
  `original_product_id` int(11) unsigned NOT NULL default '0' COMMENT '源商品id',
  `user_order_id` int(11) unsigned NOT NULL default '0' COMMENT '用户订单id',
  `is_present` tinyint(1) NOT NULL default '0' COMMENT '是否为赠品，1：是，0：否',
  `is_comment` tinyint(1) NOT NULL default '0' COMMENT '是否已评论，1：是，0：否',
  PRIMARY KEY  (`pigcms_id`),
  KEY `order_id` USING BTREE (`order_id`),
  KEY `product_id` USING BTREE (`product_id`),
  KEY `sku_id` USING BTREE (`sku_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='订单商品';

-- ----------------------------
-- Records of pigcms_order_product
-- ----------------------------
INSERT INTO `pigcms_order_product` VALUES ('14', '14', '59', '0', '', '1', '1.00', '0.00', '', '0', '0', '0', '29', '59', '14', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('15', '15', '59', '0', '', '1', '1.00', '0.00', '', '0', '0', '0', '29', '59', '15', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('16', '16', '59', '0', '', '1', '1.00', '0.00', '', '0', '0', '0', '29', '59', '16', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('17', '17', '59', '0', '', '1', '1.00', '0.00', '', '1', '1', '0', '29', '59', '17', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('18', '18', '59', '0', '', '1', '1.00', '0.00', '', '1', '1', '0', '29', '59', '18', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('19', '19', '59', '0', '', '1', '1.00', '0.00', '', '0', '0', '0', '29', '59', '19', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('20', '20', '59', '0', '', '1', '1.00', '0.00', '', '0', '0', '0', '29', '59', '20', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('21', '21', '59', '0', '', '1', '1.00', '0.00', '', '0', '0', '0', '29', '59', '21', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('22', '22', '59', '0', '', '1', '1.00', '0.00', '', '0', '0', '0', '29', '59', '22', '0', '0');
INSERT INTO `pigcms_order_product` VALUES ('23', '23', '111', '140', 'a:2:{i:0;a:4:{s:3:\"pid\";s:1:\"1\";s:4:\"name\";s:6:\"尺寸\";s:3:\"vid\";s:4:\"1403\";s:5:\"value\";s:4:\"21mm\";}i:1;a:4:{s:3:\"pid\";s:1:\"2\";s:4:\"name\";s:6:\"金重\";s:3:\"vid\";s:4:\"1402\";s:5:\"value\";s:2:\"aa\";}}', '1', '1.00', '0.00', '', '0', '0', '0', '36', '111', '23', '0', '0');

-- ----------------------------
-- Table structure for `pigcms_order_reward`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_reward`;
CREATE TABLE `pigcms_order_reward` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL COMMENT '订单表ID',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `rid` int(11) NOT NULL COMMENT '满减/送ID',
  `name` varchar(255) NOT NULL COMMENT '活动名称',
  `content` text NOT NULL COMMENT '描述序列化数组',
  PRIMARY KEY  (`id`),
  KEY `order_id` (`order_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单优惠表';

-- ----------------------------
-- Records of pigcms_order_reward
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_trade`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_trade`;
CREATE TABLE `pigcms_order_trade` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL,
  `third_data` text NOT NULL,
  PRIMARY KEY  (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='交易支付返回消息详细数据';

-- ----------------------------
-- Records of pigcms_order_trade
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_platform`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_platform`;
CREATE TABLE `pigcms_platform` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(50) NOT NULL,
  `info` varchar(500) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `key` varchar(50) NOT NULL COMMENT '关键词',
  `url` varchar(200) NOT NULL COMMENT '外链url',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='首页回复配置';

-- ----------------------------
-- Records of pigcms_platform
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_postage_template`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_postage_template`;
CREATE TABLE `pigcms_postage_template` (
  `tpl_id` int(10) NOT NULL auto_increment COMMENT '邮费模板id',
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `tpl_name` varchar(100) NOT NULL default '' COMMENT '模板名称',
  `tpl_area` varchar(10000) NOT NULL COMMENT '模板配送区域',
  `last_time` int(11) NOT NULL,
  `copy_id` int(11) NOT NULL,
  PRIMARY KEY  (`tpl_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='邮费模板';

-- ----------------------------
-- Records of pigcms_postage_template
-- ----------------------------
INSERT INTO `pigcms_postage_template` VALUES ('1', '29', '包邮', '110000&120000&130000&230000&340000&350000&360000&370000&410000&420000&510000&620000&630000&640000&650000,0,0.00,0,0.00', '1439991069', '0');
INSERT INTO `pigcms_postage_template` VALUES ('2', '36', '111', '110000,0,10.00,0,0.00', '1442216650', '0');
INSERT INTO `pigcms_postage_template` VALUES ('3', '37', '11', '110000,0,0.00,0,0.00', '1442297771', '0');

-- ----------------------------
-- Table structure for `pigcms_present`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_present`;
CREATE TABLE `pigcms_present` (
  `id` int(11) NOT NULL auto_increment,
  `dateline` int(11) NOT NULL COMMENT '添加时间',
  `uid` int(11) NOT NULL default '0' COMMENT '用户ID',
  `store_id` int(11) NOT NULL default '0' COMMENT '店铺ID',
  `name` varchar(255) NOT NULL COMMENT '赠品名称',
  `start_time` int(11) NOT NULL default '0' COMMENT '赠品开始时间',
  `end_time` int(11) NOT NULL default '0' COMMENT '赠品结束时间',
  `expire_date` int(11) NOT NULL default '0' COMMENT '领取有效期，此只对虚拟产品,保留字段',
  `expire_number` int(11) NOT NULL default '0' COMMENT '领取限制，此只对虚拟产品，保留字段',
  `number` int(11) NOT NULL default '0' COMMENT '领取次数',
  `status` tinyint(1) NOT NULL default '1' COMMENT '是否有效，1：有效，0：无效，',
  PRIMARY KEY  (`id`),
  KEY `store_id` (`store_id`,`start_time`,`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赠品表';

-- ----------------------------
-- Records of pigcms_present
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_present_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_present_product`;
CREATE TABLE `pigcms_present_product` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL COMMENT '赠品表ID',
  `product_id` int(11) NOT NULL COMMENT '产品表ID',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赠品产品列表';

-- ----------------------------
-- Records of pigcms_present_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product`;
CREATE TABLE `pigcms_product` (
  `product_id` int(10) NOT NULL auto_increment COMMENT '商品id',
  `uid` int(11) unsigned NOT NULL default '0' COMMENT '用户id',
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `category_fid` int(11) NOT NULL,
  `category_id` int(10) NOT NULL default '0' COMMENT '分类id',
  `group_id` int(10) NOT NULL default '0' COMMENT '分组id',
  `name` varchar(300) NOT NULL default '' COMMENT '商品名称',
  `sale_way` char(1) NOT NULL default '0' COMMENT '出售方式 0一口价 1拍卖',
  `buy_way` char(1) NOT NULL default '1' COMMENT '购买方式 1店内购买 0店外购买',
  `type` char(1) NOT NULL default '0' COMMENT '商品类型 0实物 1虚拟',
  `quantity` int(10) NOT NULL default '0' COMMENT '商品数量',
  `price` decimal(10,2) NOT NULL default '0.00' COMMENT '价格',
  `original_price` decimal(10,2) NOT NULL default '0.00' COMMENT '原价',
  `weight` float(10,2) NOT NULL COMMENT '产品重量，单位：克',
  `code` varchar(50) NOT NULL default '' COMMENT '商品编码',
  `image` varchar(200) NOT NULL default '' COMMENT '商品主图',
  `image_size` varchar(200) NOT NULL,
  `postage_type` char(1) NOT NULL default '0' COMMENT '邮费类型 0统计邮费 1邮费模板 ',
  `postage` decimal(10,2) NOT NULL default '0.00' COMMENT '邮费',
  `postage_template_id` int(10) NOT NULL default '0' COMMENT '邮费模板',
  `buyer_quota` int(5) NOT NULL default '0' COMMENT '买家限购',
  `allow_discount` char(1) NOT NULL default '1' COMMENT '参加会员折扣',
  `invoice` char(1) NOT NULL default '0' COMMENT '发票 0无 1有',
  `warranty` char(1) NOT NULL default '0' COMMENT '保修 0无 1有',
  `sold_time` int(11) NOT NULL default '0' COMMENT '开售时间 0立即开售',
  `sales` int(10) NOT NULL default '0' COMMENT '商品销量',
  `show_sku` char(1) NOT NULL default '1' COMMENT '显示库存 0 不显示 1显示',
  `status` char(1) NOT NULL default '1' COMMENT '状态 0仓库中 1上架 2 删除',
  `date_added` varchar(20) NOT NULL default '0' COMMENT '添加日期',
  `soldout` char(1) NOT NULL default '0' COMMENT '售完 0未售完 1已售完',
  `pv` int(10) NOT NULL default '0' COMMENT '商品浏览量',
  `uv` int(10) NOT NULL default '0' COMMENT '商品浏览人数',
  `buy_url` varchar(200) NOT NULL default '' COMMENT '外部购买地址',
  `intro` varchar(300) NOT NULL default '' COMMENT '商品简介',
  `info` text NOT NULL COMMENT '商品描述',
  `has_custom` tinyint(4) NOT NULL COMMENT '有没有自定义文本',
  `has_category` tinyint(4) NOT NULL COMMENT '有没有商品分组',
  `properties` text NOT NULL COMMENT '商品属性',
  `has_property` tinyint(1) NOT NULL default '0' COMMENT '是否有商品属性 0否 1是',
  `is_fx` tinyint(1) NOT NULL default '0' COMMENT '分销商品',
  `fx_type` tinyint(1) unsigned NOT NULL default '0' COMMENT '分销类型 0全网分销 1排他分销',
  `cost_price` decimal(10,2) NOT NULL default '0.00' COMMENT '成本价格',
  `min_fx_price` decimal(10,2) NOT NULL default '0.00' COMMENT '分销最低价格',
  `max_fx_price` decimal(10,2) NOT NULL default '0.00' COMMENT '分销最高价格',
  `is_recommend` tinyint(1) NOT NULL default '0' COMMENT '商家推荐',
  `source_product_id` int(11) unsigned NOT NULL default '0' COMMENT '分销来源商品id',
  `supplier_id` int(11) unsigned NOT NULL default '0' COMMENT '供货商店铺id',
  `delivery_address_id` int(11) unsigned NOT NULL default '0' COMMENT '收货地址 0为买家地址，大于0为分销商地址',
  `last_edit_time` int(11) unsigned NOT NULL default '0' COMMENT '最后修改时间',
  `original_product_id` int(11) NOT NULL default '0' COMMENT '分销原始id,同一商品各分销商相同',
  `sort` int(11) unsigned NOT NULL default '0' COMMENT '排序',
  `is_fx_setting` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否已设置分销信息',
  `collect` int(11) unsigned NOT NULL COMMENT '收藏数',
  `attention_num` int(10) unsigned NOT NULL default '0' COMMENT '关注数',
  `drp_profit` decimal(11,0) unsigned NOT NULL default '0' COMMENT '商品分销利润总额',
  `drp_seller_qty` int(11) unsigned NOT NULL default '0' COMMENT '分销商数量(被分销次数)',
  `drp_sale_qty` int(11) unsigned NOT NULL default '0' COMMENT '分销商品销量',
  `unified_price_setting` tinyint(1) unsigned NOT NULL default '0' COMMENT '供货商统一定价',
  `drp_level_1_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '一级分销商商品价格',
  `drp_level_2_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '二级分销商商品价格',
  `drp_level_3_price` decimal(10,2) NOT NULL default '0.00' COMMENT '三级分销商商品价格',
  `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '一级分销商商品成本价格',
  `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '二级分销商商品成本价格',
  `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '三级分销商商品成本价格',
  `is_hot` tinyint(1) NOT NULL default '0' COMMENT '是否热门 0否 1是',
  PRIMARY KEY  (`product_id`),
  KEY `store_id` USING BTREE (`store_id`),
  KEY `category_id` USING BTREE (`category_id`),
  KEY `group_id` USING BTREE (`group_id`),
  KEY `postage_template_id` USING BTREE (`postage_template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8 COMMENT='商品';

-- ----------------------------
-- Records of pigcms_product
-- ----------------------------
INSERT INTO `pigcms_product` VALUES ('72', '72', '0', '3', '27', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('73', '72', '0', '3', '27', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('74', '72', '0', '3', '27', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('75', '72', '0', '3', '28', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('76', '72', '0', '3', '28', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('77', '72', '0', '3', '28', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('78', '72', '0', '3', '29', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('79', '72', '0', '3', '29', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('80', '72', '0', '3', '29', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('81', '72', '0', '3', '30', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('82', '72', '0', '3', '30', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('83', '72', '0', '3', '30', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('84', '72', '0', '3', '31', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('85', '72', '0', '3', '31', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('86', '72', '0', '3', '31', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('87', '72', '0', '3', '32', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('88', '72', '0', '3', '32', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('89', '72', '0', '3', '32', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('90', '72', '0', '3', '33', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('91', '72', '0', '3', '33', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('92', '72', '0', '3', '33', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('93', '72', '0', '3', '34', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('94', '72', '0', '3', '34', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('95', '72', '0', '3', '34', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('96', '72', '0', '3', '35', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('97', '72', '0', '3', '35', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('98', '72', '0', '3', '35', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('99', '72', '0', '3', '36', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('100', '72', '0', '3', '36', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('101', '72', '0', '3', '36', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('102', '72', '0', '3', '37', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('103', '72', '0', '3', '37', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('104', '72', '0', '3', '37', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('105', '72', '0', '3', '38', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('106', '72', '0', '3', '38', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('107', '72', '0', '3', '38', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('108', '75', '0', '3', '39', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('109', '75', '0', '3', '39', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('110', '75', '0', '3', '39', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('111', '75', '36', '1', '9', '0', '案发当时', '0', '1', '0', '444', '1.00', '0.00', '0.00', '', 'images/000/000/036/201509/55f6946016553.jpg', 'a:2:{s:5:\"width\";s:4:\"1024\";s:6:\"height\";s:3:\"768\";}', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1442223217', '0', '6', '0', '', '阿道夫', '<p>啊的撒发生大幅</p>', '0', '1', '', '1', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('112', '76', '37', '1', '9', '0', '阿萨德发的', '0', '1', '0', '110', '10.00', '22.00', '0.00', '', 'images/000/000/037/201509/55f92c900830f.jpg', 'a:2:{s:5:\"width\";s:4:\"1024\";s:6:\"height\";s:3:\"768\";}', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1442224297', '0', '11', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('113', '78', '0', '3', '42', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('114', '78', '0', '3', '42', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('115', '78', '0', '3', '42', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('116', '78', '0', '3', '43', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('117', '78', '0', '3', '43', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('118', '78', '0', '3', '43', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('119', '78', '0', '3', '44', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('120', '78', '0', '3', '44', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('121', '78', '0', '3', '44', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('122', '78', '0', '3', '45', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('123', '78', '0', '3', '45', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('124', '78', '0', '3', '45', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('125', '78', '0', '3', '46', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('126', '78', '0', '3', '46', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('127', '78', '0', '3', '46', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('128', '78', '0', '3', '47', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('129', '78', '0', '3', '47', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('130', '78', '0', '3', '47', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('131', '78', '0', '3', '48', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('132', '78', '0', '3', '48', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('133', '78', '0', '3', '48', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('134', '72', '0', '3', '49', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('135', '72', '0', '3', '49', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('136', '72', '0', '3', '49', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('137', '72', '0', '3', '50', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('138', '72', '0', '3', '50', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');
INSERT INTO `pigcms_product` VALUES ('139', '72', '0', '3', '50', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '0', '0', '', '', '', '0', '1', '', '0', '0', '0', '0.00', '0.00', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0');

-- ----------------------------
-- Table structure for `pigcms_product_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_category`;
CREATE TABLE `pigcms_product_category` (
  `cat_id` int(10) NOT NULL auto_increment COMMENT '分类id',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `cat_desc` varchar(1000) NOT NULL COMMENT '描述',
  `cat_fid` int(10) NOT NULL default '0' COMMENT '父类id',
  `cat_pic` varchar(50) NOT NULL COMMENT 'wap端栏目图片',
  `cat_pc_pic` varchar(50) NOT NULL COMMENT 'pc端栏目图片',
  `cat_status` tinyint(1) NOT NULL default '1' COMMENT '状态',
  `cat_sort` int(10) NOT NULL default '0' COMMENT '排序，值越大优前',
  `cat_path` varchar(1000) NOT NULL,
  `cat_level` tinyint(1) NOT NULL default '1' COMMENT '级别',
  `filter_attr` varchar(255) NOT NULL COMMENT '拥有的属性id 用,号分割',
  `tag_str` varchar(1024) NOT NULL COMMENT '标签列表，每个tag_id之间用逗号分割',
  `cat_parent_status` tinyint(1) NOT NULL default '1' COMMENT '父类状态',
  PRIMARY KEY  (`cat_id`),
  KEY `parent_category_id` USING BTREE (`cat_fid`),
  KEY `cat_sort` USING BTREE (`cat_sort`),
  KEY `cat_name` USING BTREE (`cat_name`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8 COMMENT='商品分类';

-- ----------------------------
-- Records of pigcms_product_category
-- ----------------------------
INSERT INTO `pigcms_product_category` VALUES ('1', '女人', '', '0', 'category/2015/08/55d571273c5ab.png', 'category/2015/08/1.png', '1', '0', '0,01', '1', '1', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('2', '女装', '', '1', 'category/2015/12/567a53358abab.jpeg', 'category/2015/12/', '1', '0', '0,01,02', '2', '2', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('3', '女鞋', '', '1', 'category/2015/04/5527380cdee55.jpg', '', '1', '0', '0,01,03', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('4', '女包', '', '1', 'category/2015/04/5527383f1d1f5.jpg', '', '1', '0', '0,01,04', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('5', '男人', '', '0', '', 'category/2015/08/2.png', '1', '0', '0,05', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('6', '男装', '', '5', 'category/2015/04/552738de81f42.jpg', '', '1', '0', '0,05,06', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('7', '男鞋', '', '5', 'category/2015/04/5527389296c4c.jpg', '', '1', '0', '0,05,07', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('8', '男包', '', '5', 'category/2015/04/552738b59a84a.jpg', '', '1', '0', '0,05,08', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('9', '女士内衣', '', '1', 'category/2015/04/552739159e37e.jpg', '', '1', '0', '0,01,09', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('10', '男士内衣', '', '5', 'category/2015/04/5527393c02fa7.jpg', '', '1', '0', '0,05,10', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('11', '食品酒水', '', '0', '', 'category/2015/08/3.png', '1', '0', '0,11', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('12', '茶叶', '', '11', 'category/2015/04/552739cd6bbce.jpg', '', '1', '0', '0,11,12', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('13', '坚果炒货', '', '11', 'category/2015/04/552739ecaa0ad.jpg', '', '1', '0', '0,11,13', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('14', '零食', '', '11', 'category/2015/04/55273a09cb340.jpg', '', '1', '0', '0,11,14', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('15', '特产', '', '11', 'category/2015/04/55273b8f95804.png', '', '1', '0', '0,11,15', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('16', '家居服', '', '1', 'category/2015/04/55273be0a0771.jpg', '', '1', '0', '0,01,16', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('17', '服饰配件', '', '1', 'category/2015/04/55273c530d6a6.jpg', '', '1', '0', '0,01,17', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('18', '围巾手套', '', '1', 'category/2015/04/55273ce948db8.jpg', '', '1', '0', '0,01,18', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('19', '棉袜丝袜', '', '1', 'category/2015/04/55273d24949ae.jpg', '', '1', '0', '0,01,19', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('20', '个护美妆', '', '0', '', 'category/2015/08/4.png', '1', '0', '0,20', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('21', '清洁', '', '20', 'category/2015/04/55273e9e9e563.png', '', '1', '0', '0,20,21', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('22', '护肤', '', '20', 'category/2015/04/55273eb645e0b.png', '', '1', '0', '0,20,22', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('23', '面膜', '', '20', 'category/2015/04/55273ee20197e.jpg', '', '1', '0', '0,20,23', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('24', '眼霜', '', '20', 'category/2015/04/55273f0606ebe.jpg', '', '1', '0', '0,20,24', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('25', '精华', '', '20', 'category/2015/04/55273f2f28827.jpg', '', '1', '0', '0,20,25', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('26', '防晒', '', '20', 'category/2015/04/55273f52c60f0.jpg', '', '1', '0', '0,20,26', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('27', '香水彩妆', '', '20', 'category/2015/04/55273f8ddc835.jpg', '', '1', '0', '0,20,27', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('28', '个人护理', '', '20', 'category/2015/04/55273fac76513.jpg', '', '1', '0', '0,20,28', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('29', '沐浴洗护', '', '20', 'category/2015/04/55273fe4c6469.jpg', '', '1', '0', '0,20,29', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('30', '母婴玩具', '', '0', '', 'category/2015/08/5.png', '1', '0', '0,30', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('31', '孕妈食品', '', '30', 'category/2015/04/552740b099e46.jpg', '', '1', '0', '0,30,31', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('32', '妈妈护肤', '', '30', 'category/2015/04/552740dfca8dc.jpg', '', '1', '0', '0,30,32', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('33', '孕妇装', '', '30', 'category/2015/04/5527410749daa.jpg', '', '1', '0', '0,30,33', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('34', '宝宝用品', '', '30', 'category/2015/04/5527419a167ba.jpg', '', '1', '0', '0,30,34', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('35', '童装童鞋', '', '30', 'category/2015/04/552741cb6979e.jpg', '', '1', '0', '0,30,35', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('36', '童车童床', '', '30', 'category/2015/04/5527420d5643d.png', '', '1', '0', '0,30,36', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('37', '玩具乐器', '', '30', 'category/2015/04/5527423eb17bd.jpg', '', '1', '0', '0,30,37', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('38', '寝具服饰', '', '30', 'category/2015/04/55274283af0a4.jpg', '', '1', '0', '0,30,38', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('39', '家居百货', '', '0', '', 'category/2015/08/6.png', '1', '0', '0,39', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('40', '家纺', '', '39', 'category/2015/04/552745a79931e.png', '', '1', '0', '0,39,40', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('41', '厨具', '', '39', 'category/2015/04/552745e700431.png', '', '1', '0', '0,39,41', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('42', '家用', '', '39', 'category/2015/04/55274acb138c9.jpg', '', '1', '0', '0,39,42', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('43', '收纳', '', '39', 'category/2015/04/5527462826195.jpg', '', '1', '0', '0,39,43', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('44', '家具', '', '39', 'category/2015/04/5527464a87c77.jpg', '', '1', '0', '0,39,44', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('45', '建材', '', '39', 'category/2015/04/5527466f6a0d6.jpg', '', '1', '0', '0,39,45', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('46', '纸品', '', '39', 'category/2015/04/552746ac0f269.jpg', '', '1', '0', '0,39,46', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('47', '女性护理', '', '1', 'category/2015/04/55274720db396.jpg', '', '1', '0', '0,01,47', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('49', '运动户外', '', '0', '', 'category/2015/08/7.png', '1', '0', '0,49', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('50', '运动鞋包', '', '49', 'category/2015/04/552747be89089.jpg', '', '1', '0', '0,49,50', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('51', '运动服饰', '', '49', 'category/2015/04/552747d81ea2b.jpg', '', '1', '0', '0,49,51', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('52', '户外鞋服', '', '49', 'category/2015/04/552747ff766bf.jpg', '', '1', '0', '0,49,52', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('53', '户外装备', '', '49', 'category/2015/04/552748237f5d5.jpg', '', '1', '0', '0,49,53', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('54', '垂钓游泳', '', '49', 'category/2015/04/55274847891a5.jpg', '', '1', '0', '0,49,54', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('55', '体育健身', '', '49', 'category/2015/04/5527486189e62.jpg', '', '1', '0', '0,49,55', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('56', '骑行运动', '', '49', 'category/2015/04/5527487e2dac0.jpg', '', '1', '0', '0,49,56', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('57', '酒水', '', '11', 'category/2015/04/55274936e745d.png', '', '1', '0', '0,11,57', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('58', '水果', '', '11', 'category/2015/04/5527495bde3c1.png', '', '1', '0', '0,11,58', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('59', '生鲜', '', '11', 'category/2015/04/5527497f0b9d4.jpg', '', '1', '0', '0,11,59', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('60', '粮油', '', '11', 'category/2015/04/552749acec1d1.jpg', '', '1', '0', '0,11,60', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('61', '干货', '', '11', 'category/2015/04/552749dd835c5.jpg', '', '1', '0', '0,11,61', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('62', '饮料', '', '11', 'category/2015/04/55274a1d54e02.jpg', '', '1', '0', '0,11,62', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('63', '计生', '', '39', 'category/2015/04/55274b2f541fd.jpg', '', '1', '0', '0,39,63', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('64', '电脑数码', '', '0', '', 'category/2015/08/8.png', '1', '0', '0,64', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('65', '手机', '', '64', 'category/2015/04/55275d3ebc545.jpg', '', '1', '0', '0,64,65', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('66', '手机配件', '', '64', 'category/2015/04/55275d663f0ae.png', '', '1', '0', '0,64,66', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('67', '电脑', '', '64', 'category/2015/04/55275da6169b7.jpg', '', '1', '0', '0,64,67', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('68', '平板', '', '64', 'category/2015/04/55275dbc4824a.jpg', '', '1', '0', '0,64,68', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('69', '电脑配件', '', '64', 'category/2015/04/55275df02c582.jpg', '', '1', '0', '0,64,69', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('70', '摄影', '', '64', 'category/2015/04/55275e0fbba9f.jpg', '', '1', '0', '0,64,70', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('71', '影音', '', '64', 'category/2015/04/55275e2f89c97.jpg', '', '1', '0', '0,64,71', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('72', '网络', '', '64', 'category/2015/04/55275e4eedc8a.jpg', '', '1', '0', '0,64,72', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('73', '办公', '', '64', 'category/2015/04/55275ea744bfc.jpg', '', '1', '0', '0,64,73', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('74', '电器', '', '39', 'category/2015/04/55275eed3b47c.png', '', '1', '0', '0,39,74', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('75', '手表饰品', '', '0', '', 'category/2015/08/9.png', '1', '0', '0,75', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('76', '钟表', '', '75', 'category/2015/04/55275f39eb17e.jpg', '', '1', '0', '0,75,76', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('77', '饰品', '', '75', 'category/2015/04/55275f618cdd6.jpg', '', '1', '0', '0,75,77', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('78', '天然珠宝', '', '75', 'category/2015/04/55275fa4e1713.jpg', '', '1', '0', '0,75,78', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('79', '汽车用品', '', '0', '', 'category/2015/08/10.png', '1', '0', '0,79', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('80', '汽车装饰', '', '79', 'category/2015/04/552760961dfa9.jpg', '', '1', '0', '0,79,80', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('81', '车载电器', '', '79', 'category/2015/04/552760140ba45.png', '', '1', '0', '0,79,81', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('82', '美容清洗', '', '79', 'category/2015/04/5527603514e1b.jpg', '', '1', '0', '0,79,82', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('83', '维修保养', '', '79', 'category/2015/04/55276054c30f7.png', '', '1', '0', '0,79,83', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('84', '安全自驾', '', '79', 'category/2015/04/5527607a693b0.png', '', '1', '0', '0,79,84', '2', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('85', '音响配件', '', '0', '', 'category/2015/08/11.png', '1', '0', '0,85', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('86', '金融理财', '', '0', '', 'category/2015/08/12.png', '1', '0', '0,86', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('87', '旅行票务', '', '0', '', 'category/2015/08/13.png', '1', '0', '0,87', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('88', '图书音像', '', '0', '', 'category/2015/08/14.png', '1', '0', '0,88', '1', '', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('89', '厨卫用具', '', '0', '', 'category/2015/08/15.png', '1', '0', '0,89', '1', '', '', '1');

-- ----------------------------
-- Table structure for `pigcms_product_custom_field`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_custom_field`;
CREATE TABLE `pigcms_product_custom_field` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `product_id` int(10) NOT NULL default '0' COMMENT '商品id',
  `field_name` varchar(30) NOT NULL default '' COMMENT '自定义字段名称',
  `field_type` varchar(30) NOT NULL default '' COMMENT '自定义字段类型',
  `multi_rows` tinyint(1) NOT NULL default '0' COMMENT '多行 0 否 1 是',
  `required` tinyint(1) NOT NULL default '0' COMMENT '必填 0 否 1是',
  PRIMARY KEY  (`pigcms_id`),
  KEY `product_id` USING BTREE (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商品自定义字段';

-- ----------------------------
-- Records of pigcms_product_custom_field
-- ----------------------------
INSERT INTO `pigcms_product_custom_field` VALUES ('1', '12', '留言', 'text', '0', '0');

-- ----------------------------
-- Table structure for `pigcms_product_group`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_group`;
CREATE TABLE `pigcms_product_group` (
  `group_id` int(10) NOT NULL auto_increment COMMENT '商品分组id',
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `group_name` varchar(50) NOT NULL COMMENT '分组名称',
  `is_show_name` char(1) NOT NULL default '0' COMMENT '显示商品分组名称',
  `first_sort` varchar(30) NOT NULL default '' COMMENT '商品排序',
  `second_sort` varchar(30) NOT NULL default '' COMMENT '商品排序',
  `list_style_size` char(1) NOT NULL default '0' COMMENT '列表大小 0大图 1小图 2一大两小 3详细列表',
  `list_style_type` char(1) NOT NULL default '0' COMMENT '列表样式 0卡片样式 1瀑布流 2极简样式',
  `is_show_price` char(1) NOT NULL default '1' COMMENT '显示价格',
  `is_show_product_name` char(1) NOT NULL default '0' COMMENT '显示商品名 0不显示 1显示',
  `is_show_buy_button` char(1) NOT NULL default '1' COMMENT '显示购买按钮',
  `buy_button_style` char(1) NOT NULL default '1' COMMENT '购买按钮样式 1样式1 2样式2 3样式3 4 样式4',
  `group_label` varchar(300) NOT NULL default '' COMMENT '商品标签简介',
  `product_count` int(10) NOT NULL default '0' COMMENT '商品数量',
  `has_custom` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY  (`group_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='商品分组';

-- ----------------------------
-- Records of pigcms_product_group
-- ----------------------------
INSERT INTO `pigcms_product_group` VALUES ('27', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('28', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('29', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('30', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('31', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('32', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('33', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('34', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('35', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('36', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('37', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('38', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('39', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('40', '36', '爱的色放', '1', '0', '0', '2', '0', '1', '0', '1', '1', '<p>阿萨德发撒的</p>', '1', '0', '1442223079');
INSERT INTO `pigcms_product_group` VALUES ('41', '37', '打到', '1', '0', '0', '2', '0', '1', '0', '1', '1', '<p>阿打发士大夫</p>', '1', '0', '1442224271');
INSERT INTO `pigcms_product_group` VALUES ('42', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('43', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('44', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('45', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('46', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('47', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('48', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('49', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('50', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');

-- ----------------------------
-- Table structure for `pigcms_product_image`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_image`;
CREATE TABLE `pigcms_product_image` (
  `product_id` int(10) NOT NULL default '0' COMMENT '商品id',
  `image` varchar(200) NOT NULL default '' COMMENT '商品图片',
  `sort` tinyint(3) unsigned NOT NULL default '0' COMMENT '排序',
  KEY `product_id` USING BTREE (`product_id`),
  KEY `sort` USING BTREE (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品图片';

-- ----------------------------
-- Records of pigcms_product_image
-- ----------------------------
INSERT INTO `pigcms_product_image` VALUES ('58', 'images/000/000/027/201508/55d4819fb0587.png', '1');
INSERT INTO `pigcms_product_image` VALUES ('59', 'images/000/000/029/201508/55d483b4030ad.JPG', '1');
INSERT INTO `pigcms_product_image` VALUES ('111', 'images/000/000/036/201509/55f6946016553.jpg', '1');
INSERT INTO `pigcms_product_image` VALUES ('112', 'images/000/000/037/201509/55f92c900830f.jpg', '1');

-- ----------------------------
-- Table structure for `pigcms_product_property`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_property`;
CREATE TABLE `pigcms_product_property` (
  `pid` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '' COMMENT '属性名',
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COMMENT='商品属性名';

-- ----------------------------
-- Records of pigcms_product_property
-- ----------------------------
INSERT INTO `pigcms_product_property` VALUES ('1', '尺寸');
INSERT INTO `pigcms_product_property` VALUES ('2', '金重');
INSERT INTO `pigcms_product_property` VALUES ('3', '机芯');
INSERT INTO `pigcms_product_property` VALUES ('4', '适用');
INSERT INTO `pigcms_product_property` VALUES ('5', '净含量');
INSERT INTO `pigcms_product_property` VALUES ('6', '包装');
INSERT INTO `pigcms_product_property` VALUES ('7', '款式');
INSERT INTO `pigcms_product_property` VALUES ('8', '口味');
INSERT INTO `pigcms_product_property` VALUES ('9', '产地');
INSERT INTO `pigcms_product_property` VALUES ('10', '种类');
INSERT INTO `pigcms_product_property` VALUES ('11', '内存');
INSERT INTO `pigcms_product_property` VALUES ('12', '套餐');
INSERT INTO `pigcms_product_property` VALUES ('13', '出行日期');
INSERT INTO `pigcms_product_property` VALUES ('14', '出行人群');
INSERT INTO `pigcms_product_property` VALUES ('15', '入住时段');
INSERT INTO `pigcms_product_property` VALUES ('16', '房型');
INSERT INTO `pigcms_product_property` VALUES ('17', '介质');
INSERT INTO `pigcms_product_property` VALUES ('18', '开本');
INSERT INTO `pigcms_product_property` VALUES ('19', '版本');
INSERT INTO `pigcms_product_property` VALUES ('20', '类型（例如实体票,电子票）');
INSERT INTO `pigcms_product_property` VALUES ('22', '有效期');
INSERT INTO `pigcms_product_property` VALUES ('23', '乘客类型');
INSERT INTO `pigcms_product_property` VALUES ('24', '伞面尺寸');
INSERT INTO `pigcms_product_property` VALUES ('25', '儿童/青少年床尺寸');
INSERT INTO `pigcms_product_property` VALUES ('26', '内裤尺码');
INSERT INTO `pigcms_product_property` VALUES ('27', '出发日期');
INSERT INTO `pigcms_product_property` VALUES ('28', '剩余保质期');
INSERT INTO `pigcms_product_property` VALUES ('29', '佛珠尺寸');
INSERT INTO `pigcms_product_property` VALUES ('30', '克重');
INSERT INTO `pigcms_product_property` VALUES ('31', '型号');
INSERT INTO `pigcms_product_property` VALUES ('32', '大小');
INSERT INTO `pigcms_product_property` VALUES ('33', '大小描述');
INSERT INTO `pigcms_product_property` VALUES ('34', '功率');
INSERT INTO `pigcms_product_property` VALUES ('35', '吉祥图案');
INSERT INTO `pigcms_product_property` VALUES ('36', '圆床尺寸');
INSERT INTO `pigcms_product_property` VALUES ('37', '奶嘴规格');
INSERT INTO `pigcms_product_property` VALUES ('38', '娃娃尺寸');
INSERT INTO `pigcms_product_property` VALUES ('39', '安全套规格');
INSERT INTO `pigcms_product_property` VALUES ('40', '宠物适用尺码');
INSERT INTO `pigcms_product_property` VALUES ('41', '布尿裤尺码');
INSERT INTO `pigcms_product_property` VALUES ('42', '帽围');
INSERT INTO `pigcms_product_property` VALUES ('43', '床品尺寸');
INSERT INTO `pigcms_product_property` VALUES ('44', '戒圈');
INSERT INTO `pigcms_product_property` VALUES ('45', '户外帽尺码');
INSERT INTO `pigcms_product_property` VALUES ('46', '户外手套尺码');
INSERT INTO `pigcms_product_property` VALUES ('47', '手镯内径');
INSERT INTO `pigcms_product_property` VALUES ('48', '方形地毯规格');
INSERT INTO `pigcms_product_property` VALUES ('49', '毛色');
INSERT INTO `pigcms_product_property` VALUES ('50', '洗车机容量');
INSERT INTO `pigcms_product_property` VALUES ('51', '珍珠直径');
INSERT INTO `pigcms_product_property` VALUES ('52', '珍珠颜色');
INSERT INTO `pigcms_product_property` VALUES ('53', '瓷砖尺寸（平方毫米）');
INSERT INTO `pigcms_product_property` VALUES ('54', '线号');
INSERT INTO `pigcms_product_property` VALUES ('55', '床垫厚度');
INSERT INTO `pigcms_product_property` VALUES ('56', '床垫规格');
INSERT INTO `pigcms_product_property` VALUES ('57', '床尺寸');
INSERT INTO `pigcms_product_property` VALUES ('58', '座垫套件数量');
INSERT INTO `pigcms_product_property` VALUES ('59', '建议身高（尺码）');
INSERT INTO `pigcms_product_property` VALUES ('60', '画布尺寸');
INSERT INTO `pigcms_product_property` VALUES ('61', '画框尺寸');
INSERT INTO `pigcms_product_property` VALUES ('62', '皮带长度');
INSERT INTO `pigcms_product_property` VALUES ('63', '窗帘尺寸（宽X高)');
INSERT INTO `pigcms_product_property` VALUES ('64', '笔芯颜色');
INSERT INTO `pigcms_product_property` VALUES ('65', '粉粉份量');
INSERT INTO `pigcms_product_property` VALUES ('66', '纸张规格');
INSERT INTO `pigcms_product_property` VALUES ('67', '线材长度');
INSERT INTO `pigcms_product_property` VALUES ('68', '线长');
INSERT INTO `pigcms_product_property` VALUES ('69', '组合');
INSERT INTO `pigcms_product_property` VALUES ('70', '绣布CT数');
INSERT INTO `pigcms_product_property` VALUES ('71', '胸围尺码');
INSERT INTO `pigcms_product_property` VALUES ('72', '胸垫尺码');
INSERT INTO `pigcms_product_property` VALUES ('73', '自定义项');
INSERT INTO `pigcms_product_property` VALUES ('74', '色温');
INSERT INTO `pigcms_product_property` VALUES ('75', '花束直径');
INSERT INTO `pigcms_product_property` VALUES ('76', '花盆规格');
INSERT INTO `pigcms_product_property` VALUES ('77', '蛋糕尺寸');
INSERT INTO `pigcms_product_property` VALUES ('78', '袜子尺码');
INSERT INTO `pigcms_product_property` VALUES ('79', '规格尺寸');
INSERT INTO `pigcms_product_property` VALUES ('80', '规格（粒/袋/ml/g）');
INSERT INTO `pigcms_product_property` VALUES ('81', '贵金属成色');
INSERT INTO `pigcms_product_property` VALUES ('82', '车用香水香味');
INSERT INTO `pigcms_product_property` VALUES ('83', '适用年龄');
INSERT INTO `pigcms_product_property` VALUES ('84', '适用床尺寸');
INSERT INTO `pigcms_product_property` VALUES ('85', '适用户外项目');
INSERT INTO `pigcms_product_property` VALUES ('86', '适用范围');
INSERT INTO `pigcms_product_property` VALUES ('87', '适用规格');
INSERT INTO `pigcms_product_property` VALUES ('88', '遮阳挡件数');
INSERT INTO `pigcms_product_property` VALUES ('89', '邮轮房型');
INSERT INTO `pigcms_product_property` VALUES ('90', '钓钩尺寸');
INSERT INTO `pigcms_product_property` VALUES ('91', '钻石净度');
INSERT INTO `pigcms_product_property` VALUES ('92', '钻石重量');
INSERT INTO `pigcms_product_property` VALUES ('93', '钻石颜色');
INSERT INTO `pigcms_product_property` VALUES ('94', '链子长度');
INSERT INTO `pigcms_product_property` VALUES ('95', '锅具尺寸');
INSERT INTO `pigcms_product_property` VALUES ('96', '锅身直径尺寸');
INSERT INTO `pigcms_product_property` VALUES ('97', '镜子尺寸');
INSERT INTO `pigcms_product_property` VALUES ('98', '镜片适合度数');
INSERT INTO `pigcms_product_property` VALUES ('99', '镶嵌材质');
INSERT INTO `pigcms_product_property` VALUES ('100', '长度');
INSERT INTO `pigcms_product_property` VALUES ('101', '防潮垫大小');
INSERT INTO `pigcms_product_property` VALUES ('102', '雨刷尺寸');
INSERT INTO `pigcms_product_property` VALUES ('103', '鞋码');
INSERT INTO `pigcms_product_property` VALUES ('104', '鞋码（内长）');
INSERT INTO `pigcms_product_property` VALUES ('105', '香味');
INSERT INTO `pigcms_product_property` VALUES ('106', '颜色');
INSERT INTO `pigcms_product_property` VALUES ('107', '尺码');
INSERT INTO `pigcms_product_property` VALUES ('108', '上市时间');
INSERT INTO `pigcms_product_property` VALUES ('109', '容量');
INSERT INTO `pigcms_product_property` VALUES ('110', '系列');
INSERT INTO `pigcms_product_property` VALUES ('111', '规格');

-- ----------------------------
-- Table structure for `pigcms_product_property_value`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_property_value`;
CREATE TABLE `pigcms_product_property_value` (
  `vid` int(10) NOT NULL auto_increment COMMENT '商品属性值id',
  `pid` int(10) NOT NULL default '0' COMMENT '商品属性名id',
  `value` varchar(50) NOT NULL default '' COMMENT '商品属性值',
  `image` varchar(255) NOT NULL COMMENT '属性对应图片',
  PRIMARY KEY  (`vid`),
  KEY `pid` USING BTREE (`pid`),
  KEY `pid_2` USING BTREE (`pid`,`value`)
) ENGINE=MyISAM AUTO_INCREMENT=1404 DEFAULT CHARSET=utf8 COMMENT='商品属性值';

-- ----------------------------
-- Records of pigcms_product_property_value
-- ----------------------------
INSERT INTO `pigcms_product_property_value` VALUES ('1', '106', '紫色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('2', '106', '绿色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('3', '106', '红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('4', '106', '黑色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('5', '107', 'S', '');
INSERT INTO `pigcms_product_property_value` VALUES ('6', '107', 'M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('7', '107', 'L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('8', '107', 'XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('9', '107', 'XXL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('10', '106', '黑红花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('11', '106', '蓝色花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('12', '106', '红色花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('13', '106', '红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('14', '106', '黑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('15', '106', '蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('16', '107', 'X', '');
INSERT INTO `pigcms_product_property_value` VALUES ('17', '106', '灰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('18', '106', '白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('19', '1', 'X', '');
INSERT INTO `pigcms_product_property_value` VALUES ('20', '1', 'L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('21', '1', 'XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('22', '106', '绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('23', '1', '1尺', '');
INSERT INTO `pigcms_product_property_value` VALUES ('24', '1', '大', '');
INSERT INTO `pigcms_product_property_value` VALUES ('25', '1', '4.7寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('26', '3', '64 位架构的 A8 芯片 M8 运动协处理器', '');
INSERT INTO `pigcms_product_property_value` VALUES ('27', '109', '16G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('28', '19', '8.1.1', '');
INSERT INTO `pigcms_product_property_value` VALUES ('29', '11', '8G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('30', '11', '16G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('31', '11', '32G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('32', '106', '银色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('33', '106', '土豪金', '');
INSERT INTO `pigcms_product_property_value` VALUES ('34', '106', '1', '');
INSERT INTO `pigcms_product_property_value` VALUES ('35', '106', '更换', '');
INSERT INTO `pigcms_product_property_value` VALUES ('36', '106', '好看', '');
INSERT INTO `pigcms_product_property_value` VALUES ('37', '106', 'vg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('38', '1', 'm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('39', '1', 'xxl', '');
INSERT INTO `pigcms_product_property_value` VALUES ('40', '1', 'xxxl', '');
INSERT INTO `pigcms_product_property_value` VALUES ('41', '1', 'xxxxxl', '');
INSERT INTO `pigcms_product_property_value` VALUES ('42', '1', '158', '');
INSERT INTO `pigcms_product_property_value` VALUES ('43', '1', '160', '');
INSERT INTO `pigcms_product_property_value` VALUES ('44', '1', '162', '');
INSERT INTO `pigcms_product_property_value` VALUES ('45', '1', '164', '');
INSERT INTO `pigcms_product_property_value` VALUES ('46', '1', '166', '');
INSERT INTO `pigcms_product_property_value` VALUES ('47', '11', '16', '');
INSERT INTO `pigcms_product_property_value` VALUES ('48', '11', '68', '');
INSERT INTO `pigcms_product_property_value` VALUES ('49', '11', '120G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('50', '3', '123456', '');
INSERT INTO `pigcms_product_property_value` VALUES ('51', '106', '雪晶白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('52', '106', '星砖黑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('53', '106', '铂光金', '');
INSERT INTO `pigcms_product_property_value` VALUES ('54', '19', 'GALAXY S6 Edge SM-G9250', '');
INSERT INTO `pigcms_product_property_value` VALUES ('55', '12', '官方标配', '');
INSERT INTO `pigcms_product_property_value` VALUES ('56', '19', '中国大陆', '');
INSERT INTO `pigcms_product_property_value` VALUES ('57', '106', '深度灰色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('58', '106', '金色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('59', '11', '64G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('60', '11', '128G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('61', '106', '深灰色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('62', '106', '深空灰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('63', '19', '公开版16G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('64', '19', '公开版（16G）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('65', '19', '公开版（64G）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('66', '19', '公开版（128G）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('67', '19', '移动4G版（16G）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('68', '19', '移动4G版（64G）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('69', '106', '香槟金', '');
INSERT INTO `pigcms_product_property_value` VALUES ('70', '106', '极光白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('71', '19', 'X5MAx+ 双卡双模', '');
INSERT INTO `pigcms_product_property_value` VALUES ('72', '19', 'X5MAx+6 双卡多模', '');
INSERT INTO `pigcms_product_property_value` VALUES ('73', '19', 'X5MAx+ 双卡多模', '');
INSERT INTO `pigcms_product_property_value` VALUES ('74', '11', '16GB', '');
INSERT INTO `pigcms_product_property_value` VALUES ('75', '19', 'X5S L 双卡多模', '');
INSERT INTO `pigcms_product_property_value` VALUES ('76', '19', 'X5V 双卡多模', '');
INSERT INTO `pigcms_product_property_value` VALUES ('77', '5', '50g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('78', '2', '15', '');
INSERT INTO `pigcms_product_property_value` VALUES ('79', '2', '16', '');
INSERT INTO `pigcms_product_property_value` VALUES ('80', '2', '18', '');
INSERT INTO `pigcms_product_property_value` VALUES ('81', '3', '19', '');
INSERT INTO `pigcms_product_property_value` VALUES ('82', '3', '1', '');
INSERT INTO `pigcms_product_property_value` VALUES ('83', '3', '74555', '');
INSERT INTO `pigcms_product_property_value` VALUES ('84', '3', '3232', '');
INSERT INTO `pigcms_product_property_value` VALUES ('85', '3', '3', '');
INSERT INTO `pigcms_product_property_value` VALUES ('86', '1', '155cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('87', '62', '98', '');
INSERT INTO `pigcms_product_property_value` VALUES ('88', '4', '26', '');
INSERT INTO `pigcms_product_property_value` VALUES ('89', '5', '150', '');
INSERT INTO `pigcms_product_property_value` VALUES ('90', '27', '2015年5月9日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('91', '1', 'f', '');
INSERT INTO `pigcms_product_property_value` VALUES ('92', '1', 'd', '');
INSERT INTO `pigcms_product_property_value` VALUES ('93', '1', 'e', '');
INSERT INTO `pigcms_product_property_value` VALUES ('94', '1', 'g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('95', '1', 'h', '');
INSERT INTO `pigcms_product_property_value` VALUES ('96', '20', 'd', '');
INSERT INTO `pigcms_product_property_value` VALUES ('97', '20', '1', '');
INSERT INTO `pigcms_product_property_value` VALUES ('98', '1', '1', '');
INSERT INTO `pigcms_product_property_value` VALUES ('99', '1', '12', '');
INSERT INTO `pigcms_product_property_value` VALUES ('100', '1', 'fd', '');
INSERT INTO `pigcms_product_property_value` VALUES ('101', '1', '2', '');
INSERT INTO `pigcms_product_property_value` VALUES ('102', '1', '3', '');
INSERT INTO `pigcms_product_property_value` VALUES ('103', '1', '4', '');
INSERT INTO `pigcms_product_property_value` VALUES ('104', '107', 'MM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('105', '5', '100', '');
INSERT INTO `pigcms_product_property_value` VALUES ('106', '9', '内蒙', '');
INSERT INTO `pigcms_product_property_value` VALUES ('107', '22', '9个月', '');
INSERT INTO `pigcms_product_property_value` VALUES ('108', '11', '3', '');
INSERT INTO `pigcms_product_property_value` VALUES ('109', '11', '3G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('110', '9', '深圳', '');
INSERT INTO `pigcms_product_property_value` VALUES ('111', '73', '品牌', '');
INSERT INTO `pigcms_product_property_value` VALUES ('112', '73', '保质期', '');
INSERT INTO `pigcms_product_property_value` VALUES ('113', '20', '四件套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('114', '1', '1.5m（5英尺）床', '');
INSERT INTO `pigcms_product_property_value` VALUES ('115', '7', '折叠席', '');
INSERT INTO `pigcms_product_property_value` VALUES ('116', '10', '凉席套件', '');
INSERT INTO `pigcms_product_property_value` VALUES ('117', '86', '组合沙发', '');
INSERT INTO `pigcms_product_property_value` VALUES ('118', '111', '直径：30CM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('119', '31', 'PC30S3', '');
INSERT INTO `pigcms_product_property_value` VALUES ('120', '17', '合金', '');
INSERT INTO `pigcms_product_property_value` VALUES ('121', '99', '304不锈钢', '');
INSERT INTO `pigcms_product_property_value` VALUES ('122', '7', '现代简约', '');
INSERT INTO `pigcms_product_property_value` VALUES ('123', '10', '台式电脑桌', '');
INSERT INTO `pigcms_product_property_value` VALUES ('124', '4', '客厅', '');
INSERT INTO `pigcms_product_property_value` VALUES ('125', '7', '时尚简约', '');
INSERT INTO `pigcms_product_property_value` VALUES ('126', '10', '装饰台灯', '');
INSERT INTO `pigcms_product_property_value` VALUES ('127', '10', '抽纸，手帕纸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('128', '80', '200抽，组合装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('129', '1', '58-60英寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('130', '10', 'LED电视（主流）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('131', '4', '客厅电视', '');
INSERT INTO `pigcms_product_property_value` VALUES ('132', '7', '简约纯色，条纹格子，几何图形', '');
INSERT INTO `pigcms_product_property_value` VALUES ('133', '10', '枕套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('134', '73', '面料：全棉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('135', '79', '48*74cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('136', '1', '48*74cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('137', '10', '长方形枕头', '');
INSERT INTO `pigcms_product_property_value` VALUES ('138', '55', '10cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('139', '57', '1.5mx2.0m', '');
INSERT INTO `pigcms_product_property_value` VALUES ('140', '4', '门厅', '');
INSERT INTO `pigcms_product_property_value` VALUES ('141', '1', '大小', '');
INSERT INTO `pigcms_product_property_value` VALUES ('142', '0', '', '');
INSERT INTO `pigcms_product_property_value` VALUES ('143', '6', '单件装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('144', '83', '0-8岁', '');
INSERT INTO `pigcms_product_property_value` VALUES ('145', '80', '120g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('146', '80', '50g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('147', '79', '50X50cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('148', '7', '宽松型', '');
INSERT INTO `pigcms_product_property_value` VALUES ('149', '80', '30ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('150', '106', '玫红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('151', '106', '黄色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('152', '106', '深蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('153', '106', '白色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('154', '80', '60g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('155', '106', '卡其色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('156', '106', '粉色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('157', '106', '浅灰色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('158', '80', '44ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('159', '80', '10片', '');
INSERT INTO `pigcms_product_property_value` VALUES ('160', '80', '80g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('161', '106', '藏青', '');
INSERT INTO `pigcms_product_property_value` VALUES ('162', '106', '裸色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('163', '80', '100g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('164', '106', '粉红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('165', '1', '18cm*15.8cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('166', '107', 'XXXL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('167', '106', '紫金红/土豪金', '');
INSERT INTO `pigcms_product_property_value` VALUES ('168', '106', '咖色格子', '');
INSERT INTO `pigcms_product_property_value` VALUES ('169', '106', '藏蓝格子', '');
INSERT INTO `pigcms_product_property_value` VALUES ('170', '80', '5袋', '');
INSERT INTO `pigcms_product_property_value` VALUES ('171', '80', '700ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('172', '106', '宝蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('173', '109', '501-600ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('174', '80', '500ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('175', '9', '中国大陆', '');
INSERT INTO `pigcms_product_property_value` VALUES ('176', '80', '1800-2000ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('177', '80', '250ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('178', '106', '桔色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('179', '80', '180g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('180', '17', 'SD/SDHC卡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('181', '9', '台湾', '');
INSERT INTO `pigcms_product_property_value` VALUES ('182', '106', '蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('183', '86', '家用', '');
INSERT INTO `pigcms_product_property_value` VALUES ('184', '107', '35', '');
INSERT INTO `pigcms_product_property_value` VALUES ('185', '107', '36', '');
INSERT INTO `pigcms_product_property_value` VALUES ('186', '107', '37', '');
INSERT INTO `pigcms_product_property_value` VALUES ('187', '107', '38', '');
INSERT INTO `pigcms_product_property_value` VALUES ('188', '107', '39', '');
INSERT INTO `pigcms_product_property_value` VALUES ('189', '109', '600ml以上', '');
INSERT INTO `pigcms_product_property_value` VALUES ('190', '107', '34', '');
INSERT INTO `pigcms_product_property_value` VALUES ('191', '107', '40', '');
INSERT INTO `pigcms_product_property_value` VALUES ('192', '107', '41', '');
INSERT INTO `pigcms_product_property_value` VALUES ('193', '106', '驼色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('194', '80', '30粒', '');
INSERT INTO `pigcms_product_property_value` VALUES ('195', '109', '30L—39L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('196', '106', '粉红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('197', '106', '粉红白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('198', '106', '灰蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('199', '106', '灰兰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('200', '73', '功率：1000W~1399W', '');
INSERT INTO `pigcms_product_property_value` VALUES ('201', '80', '5件套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('202', '107', '33', '');
INSERT INTO `pigcms_product_property_value` VALUES ('203', '111', '120*100*190cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('204', '109', '2人', '');
INSERT INTO `pigcms_product_property_value` VALUES ('205', '34', '1500W', '');
INSERT INTO `pigcms_product_property_value` VALUES ('206', '106', '绿色花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('207', '106', '条纹白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('208', '106', '米白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('209', '1', '是', '');
INSERT INTO `pigcms_product_property_value` VALUES ('210', '106', '深红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('211', '106', '深蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('212', '106', '深棕', '');
INSERT INTO `pigcms_product_property_value` VALUES ('213', '106', '橙色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('214', '106', '粉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('215', '106', '虎斑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('216', '106', '嫩黄', '');
INSERT INTO `pigcms_product_property_value` VALUES ('217', '106', '酒红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('218', '106', '灰色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('219', '80', '800g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('220', '106', '华丽晚礼', '');
INSERT INTO `pigcms_product_property_value` VALUES ('221', '106', '清凉海滩', '');
INSERT INTO `pigcms_product_property_value` VALUES ('222', '110', '四件套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('223', '110', '六件套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('224', '110', '七件套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('225', '110', '八件套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('226', '20', '迷你型', '');
INSERT INTO `pigcms_product_property_value` VALUES ('227', '20', '常规型', '');
INSERT INTO `pigcms_product_property_value` VALUES ('228', '1', '12寸绿色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('229', '1', '12寸蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('230', '1', '14寸绿色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('231', '1', '14寸蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('232', '1', '12寸红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('233', '7', '手套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('234', '106', '蜂蜜色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('235', '106', '桃木色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('236', '11', '运行内存:2GB RAM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('237', '11', '机身内存:16GB ROM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('238', '108', '2014年11月', '');
INSERT INTO `pigcms_product_property_value` VALUES ('239', '106', '橘色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('240', '107', '70A/32A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('241', '107', '70B/32B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('242', '11', '机身内存:16GB ROM 运行内存:2GB RAM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('243', '107', '75B/34B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('244', '107', '75C/34C', '');
INSERT INTO `pigcms_product_property_value` VALUES ('245', '106', '香槟色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('246', '1', '110', '');
INSERT INTO `pigcms_product_property_value` VALUES ('247', '1', '120', '');
INSERT INTO `pigcms_product_property_value` VALUES ('248', '1', '130', '');
INSERT INTO `pigcms_product_property_value` VALUES ('249', '1', '140', '');
INSERT INTO `pigcms_product_property_value` VALUES ('250', '106', '天蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('251', '106', '藏青色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('252', '107', 'A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('253', '107', 'B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('254', '107', 'C', '');
INSERT INTO `pigcms_product_property_value` VALUES ('255', '107', 'D', '');
INSERT INTO `pigcms_product_property_value` VALUES ('256', '7', '厚款', '');
INSERT INTO `pigcms_product_property_value` VALUES ('257', '7', '薄款', '');
INSERT INTO `pigcms_product_property_value` VALUES ('258', '107', '110', '');
INSERT INTO `pigcms_product_property_value` VALUES ('259', '107', '120', '');
INSERT INTO `pigcms_product_property_value` VALUES ('260', '107', '130', '');
INSERT INTO `pigcms_product_property_value` VALUES ('261', '107', '140', '');
INSERT INTO `pigcms_product_property_value` VALUES ('262', '107', '150', '');
INSERT INTO `pigcms_product_property_value` VALUES ('263', '107', '32B/70B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('264', '107', '34B/75B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('265', '106', '枣红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('266', '107', '36B/80B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('267', '107', '38B/85B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('268', '106', '冰湖蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('269', '106', '黑曜石', '');
INSERT INTO `pigcms_product_property_value` VALUES ('270', '1', '40*24*32MM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('271', '106', '黑色,白色,活力黑黄,黑绿色,魅力黑蓝,浪漫玫红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('272', '31', 'QY7', '');
INSERT INTO `pigcms_product_property_value` VALUES ('273', '106', '湖蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('274', '107', '120CM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('275', '107', '130CM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('276', '107', '140CM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('277', '107', '150CM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('278', '106', '灰色条纹', '');
INSERT INTO `pigcms_product_property_value` VALUES ('279', '106', '四叶草软底', '');
INSERT INTO `pigcms_product_property_value` VALUES ('280', '1', '21.5英寸采用 IPS 技术的LED 背光显示屏', '');
INSERT INTO `pigcms_product_property_value` VALUES ('281', '106', '玫红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('282', '107', '160/85（S)', '');
INSERT INTO `pigcms_product_property_value` VALUES ('283', '107', '170/95(L)', '');
INSERT INTO `pigcms_product_property_value` VALUES ('284', '106', '肤色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('285', '1', '21英寸,速度1.4GHz', '');
INSERT INTO `pigcms_product_property_value` VALUES ('286', '1', '21英寸,速度2.9GHz', '');
INSERT INTO `pigcms_product_property_value` VALUES ('287', '1', '27英寸,速度3.2GHz', '');
INSERT INTO `pigcms_product_property_value` VALUES ('288', '1', '27英寸,速度3.4GHz', '');
INSERT INTO `pigcms_product_property_value` VALUES ('289', '1', '27英寸,速度1600MHz DDR3', '');
INSERT INTO `pigcms_product_property_value` VALUES ('290', '106', '紫罗兰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('291', '106', '米色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('292', '80', '40g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('293', '31', 'MF432CH/A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('294', '31', 'MD531CH/A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('295', '106', '深空灰色/白色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('296', '106', '深空灰色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('297', '80', '192ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('298', '106', '棕色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('299', '106', '浅棕色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('300', '80', '200ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('301', '106', '米白色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('302', '106', '酒红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('303', '106', '肉粉色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('304', '106', '玫瑰红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('305', '31', '中号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('306', '7', '害羞女孩', '');
INSERT INTO `pigcms_product_property_value` VALUES ('307', '7', '与狼共舞', '');
INSERT INTO `pigcms_product_property_value` VALUES ('308', '31', '超大号标配', '');
INSERT INTO `pigcms_product_property_value` VALUES ('309', '31', '中号基本套餐', '');
INSERT INTO `pigcms_product_property_value` VALUES ('310', '31', '超大号基本套餐', '');
INSERT INTO `pigcms_product_property_value` VALUES ('311', '106', '果粉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('312', '106', '经典蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('313', '106', '蓝白色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('314', '107', '28', '');
INSERT INTO `pigcms_product_property_value` VALUES ('315', '107', '29', '');
INSERT INTO `pigcms_product_property_value` VALUES ('316', '107', '30', '');
INSERT INTO `pigcms_product_property_value` VALUES ('317', '107', '31', '');
INSERT INTO `pigcms_product_property_value` VALUES ('318', '107', '32', '');
INSERT INTO `pigcms_product_property_value` VALUES ('319', '80', '400ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('320', '106', '军绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('321', '106', '桔红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('322', '106', '卡其', '');
INSERT INTO `pigcms_product_property_value` VALUES ('323', '107', '42', '');
INSERT INTO `pigcms_product_property_value` VALUES ('324', '107', '43', '');
INSERT INTO `pigcms_product_property_value` VALUES ('325', '107', '45', '');
INSERT INTO `pigcms_product_property_value` VALUES ('326', '10', '多平台散热器', '');
INSERT INTO `pigcms_product_property_value` VALUES ('327', '10', '水冷', '');
INSERT INTO `pigcms_product_property_value` VALUES ('328', '6', '4瓶装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('329', '9', '马来西亚', '');
INSERT INTO `pigcms_product_property_value` VALUES ('330', '11', '无内存版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('331', '11', '内置16G内存版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('332', '106', '黑色/白色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('333', '106', '杏色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('334', '80', '1.5g*26袋', '');
INSERT INTO `pigcms_product_property_value` VALUES ('335', '106', '浅绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('336', '106', '咖啡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('337', '107', '44', '');
INSERT INTO `pigcms_product_property_value` VALUES ('338', '34', '<=5W', '');
INSERT INTO `pigcms_product_property_value` VALUES ('339', '80', '260.0g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('340', '111', '170*56*32mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('341', '106', '魅力黑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('342', '80', '64g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('343', '106', '黑红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('344', '86', '通用', '');
INSERT INTO `pigcms_product_property_value` VALUES ('345', '106', '月光银', '');
INSERT INTO `pigcms_product_property_value` VALUES ('346', '106', '酷炭黑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('347', '80', '45g*2袋', '');
INSERT INTO `pigcms_product_property_value` VALUES ('348', '106', '灰黄', '');
INSERT INTO `pigcms_product_property_value` VALUES ('349', '9', '印尼', '');
INSERT INTO `pigcms_product_property_value` VALUES ('350', '106', '军绿色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('351', '80', '336g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('352', '31', 'S-35', '');
INSERT INTO `pigcms_product_property_value` VALUES ('353', '31', 'S-36', '');
INSERT INTO `pigcms_product_property_value` VALUES ('354', '31', 'S-52', '');
INSERT INTO `pigcms_product_property_value` VALUES ('355', '106', '黑湖水蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('356', '106', '黑荧光绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('357', '106', '全黑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('358', '106', '宝蓝白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('359', '80', '160g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('360', '106', '宝石蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('361', '106', '绚丽蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('362', '106', '绚丽紫', '');
INSERT INTO `pigcms_product_property_value` VALUES ('363', '106', '天空蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('364', '106', '宝石蓝,天空蓝,绚丽紫', '');
INSERT INTO `pigcms_product_property_value` VALUES ('365', '19', '经典版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('366', '19', '无限版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('367', '106', '麦黄色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('368', '106', '红棕色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('369', '106', '棕疯马色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('370', '106', '紫', '');
INSERT INTO `pigcms_product_property_value` VALUES ('371', '1', '7英寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('372', '19', '至尊版灰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('373', '19', '至尊版黄', '');
INSERT INTO `pigcms_product_property_value` VALUES ('374', '11', '公开版16G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('375', '11', '公开版64G ROM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('376', '11', '公开版12G ROM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('377', '11', '公开版128G ROM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('378', '106', '中国红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('379', '106', '精灵蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('380', '106', '黄', '');
INSERT INTO `pigcms_product_property_value` VALUES ('381', '106', '咖色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('382', '106', '粉色,白色,黄色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('383', '106', '深海蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('384', '106', '智能红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('385', '106', '经典银', '');
INSERT INTO `pigcms_product_property_value` VALUES ('386', '7', '超级光驱,黑色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('387', '7', '刀锋超薄刻录机', '');
INSERT INTO `pigcms_product_property_value` VALUES ('388', '106', '黑配灰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('389', '106', '黑配蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('390', '86', '家庭路由', '');
INSERT INTO `pigcms_product_property_value` VALUES ('391', '19', '优酷盒子', '');
INSERT INTO `pigcms_product_property_value` VALUES ('392', '19', '手柄套装版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('393', '20', '黑白激光', '');
INSERT INTO `pigcms_product_property_value` VALUES ('394', '86', '打印 扫描 复印 传真', '');
INSERT INTO `pigcms_product_property_value` VALUES ('395', '106', '咖啡色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('396', '7', '轻便型手动装订机', '');
INSERT INTO `pigcms_product_property_value` VALUES ('397', '7', '大台板畅销型装订机', '');
INSERT INTO `pigcms_product_property_value` VALUES ('398', '106', '古铜金砂', '');
INSERT INTO `pigcms_product_property_value` VALUES ('399', '7', '爆款激光定位装订机', '');
INSERT INTO `pigcms_product_property_value` VALUES ('400', '106', '西瓜红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('401', '106', '牛仔蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('402', '106', '天然绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('403', '106', '浅咖色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('404', '1', '32cun', '');
INSERT INTO `pigcms_product_property_value` VALUES ('405', '1', '42寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('406', '7', '蓝光', '');
INSERT INTO `pigcms_product_property_value` VALUES ('407', '7', '网络', '');
INSERT INTO `pigcms_product_property_value` VALUES ('408', '7', '智能', '');
INSERT INTO `pigcms_product_property_value` VALUES ('409', '80', '240ML', '');
INSERT INTO `pigcms_product_property_value` VALUES ('410', '12', '年', '');
INSERT INTO `pigcms_product_property_value` VALUES ('411', '10', '冰冻', '');
INSERT INTO `pigcms_product_property_value` VALUES ('412', '80', '20g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('413', '80', '113g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('414', '106', '灰蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('415', '106', '橘红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('416', '106', '深灰色-女', '');
INSERT INTO `pigcms_product_property_value` VALUES ('417', '106', '伊甸粉色-女', '');
INSERT INTO `pigcms_product_property_value` VALUES ('418', '106', '黑色-男', '');
INSERT INTO `pigcms_product_property_value` VALUES ('419', '106', '铁蓝灰色-男', '');
INSERT INTO `pigcms_product_property_value` VALUES ('420', '106', '黑绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('421', '106', '母绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('422', '106', '蓝黑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('423', '106', '50SD9', '');
INSERT INTO `pigcms_product_property_value` VALUES ('424', '106', '50FD9', '');
INSERT INTO `pigcms_product_property_value` VALUES ('425', '106', '50FC99', '');
INSERT INTO `pigcms_product_property_value` VALUES ('426', '106', '50FC821', '');
INSERT INTO `pigcms_product_property_value` VALUES ('427', '106', '深棕色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('428', '106', '荧光绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('429', '1', '31.5*17.5*13.5cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('430', '106', '象牙白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('431', '86', '浴室', '');
INSERT INTO `pigcms_product_property_value` VALUES ('432', '86', '办公室', '');
INSERT INTO `pigcms_product_property_value` VALUES ('433', '86', '客厅', '');
INSERT INTO `pigcms_product_property_value` VALUES ('434', '86', '浴室，办公室，客厅', '');
INSERT INTO `pigcms_product_property_value` VALUES ('435', '107', '165', '');
INSERT INTO `pigcms_product_property_value` VALUES ('436', '107', '170', '');
INSERT INTO `pigcms_product_property_value` VALUES ('437', '107', '175', '');
INSERT INTO `pigcms_product_property_value` VALUES ('438', '107', '180', '');
INSERT INTO `pigcms_product_property_value` VALUES ('439', '107', '185', '');
INSERT INTO `pigcms_product_property_value` VALUES ('440', '1', '49.5*24*80cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('441', '1', '49.5', '');
INSERT INTO `pigcms_product_property_value` VALUES ('442', '1', '49.5*24*80', '');
INSERT INTO `pigcms_product_property_value` VALUES ('443', '106', '青绿色+', '');
INSERT INTO `pigcms_product_property_value` VALUES ('444', '106', '青绿色+白色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('445', '106', '浆果红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('446', '106', '基础黑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('447', '111', '2个大号+2个中号（赠双管抽气泵）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('448', '106', '透明色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('449', '107', '女款L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('450', '107', '女款M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('451', '107', '女款XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('452', '107', '女款XXL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('453', '107', '男款M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('454', '107', '男款L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('455', '107', '男款XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('456', '107', '男款XXL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('457', '106', '花灰色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('458', '107', '2XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('459', '107', '3XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('460', '1', '45*15*42', '');
INSERT INTO `pigcms_product_property_value` VALUES ('461', '1', '45*15*42cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('462', '106', '大红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('463', '1', '26*13*12cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('464', '1', '40*34*46cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('465', '106', '宝蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('466', '106', '花灰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('467', '73', '层数：3层', '');
INSERT INTO `pigcms_product_property_value` VALUES ('468', '73', '层数：4层', '');
INSERT INTO `pigcms_product_property_value` VALUES ('469', '106', '草绿色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('470', '106', '米蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('471', '107', '男OSFM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('472', '107', '女OSFM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('473', '107', '31L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('474', '107', '45L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('475', '107', '58L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('476', '106', '浅蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('477', '1', '单人吊床', '');
INSERT INTO `pigcms_product_property_value` VALUES ('478', '1', '双人吊床', '');
INSERT INTO `pigcms_product_property_value` VALUES ('479', '106', '黑蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('480', '107', '1.6米衣柜+转角架', '');
INSERT INTO `pigcms_product_property_value` VALUES ('481', '107', '1.8米衣柜+转角架', '');
INSERT INTO `pigcms_product_property_value` VALUES ('482', '31', '高倍型', '');
INSERT INTO `pigcms_product_property_value` VALUES ('483', '31', '稳定型', '');
INSERT INTO `pigcms_product_property_value` VALUES ('484', '107', '1.5*1.9米床+床垫+1柜', '');
INSERT INTO `pigcms_product_property_value` VALUES ('485', '107', '1.5*2.0米床+床垫+1柜', '');
INSERT INTO `pigcms_product_property_value` VALUES ('486', '107', '1.8*2.0米床+床垫+1柜', '');
INSERT INTO `pigcms_product_property_value` VALUES ('487', '7', '学习桌', '');
INSERT INTO `pigcms_product_property_value` VALUES ('488', '7', '学习桌+椅子', '');
INSERT INTO `pigcms_product_property_value` VALUES ('489', '106', '蓝色，红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('490', '100', '3.6米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('491', '100', '4.5米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('492', '100', '5.4米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('493', '55', '280mm左右', '');
INSERT INTO `pigcms_product_property_value` VALUES ('494', '12', '套餐一', '');
INSERT INTO `pigcms_product_property_value` VALUES ('495', '12', '套餐二', '');
INSERT INTO `pigcms_product_property_value` VALUES ('496', '7', '舒适版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('497', '7', '豪华版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('498', '107', '1500*2000mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('499', '107', '2000*2200mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('500', '12', '基础套餐', '');
INSERT INTO `pigcms_product_property_value` VALUES ('501', '12', '饵灯套餐', '');
INSERT INTO `pigcms_product_property_value` VALUES ('502', '12', '大支架套餐', '');
INSERT INTO `pigcms_product_property_value` VALUES ('503', '106', '浅绿色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('504', '106', '枚红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('505', '1', 'S', '');
INSERT INTO `pigcms_product_property_value` VALUES ('506', '106', '白色，古铜色，黑色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('507', '106', '湖水蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('508', '1', '90*90cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('509', '1', '110*110cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('510', '1', '120*60cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('511', '1', '136*80*73cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('512', '7', '直拍2只', '');
INSERT INTO `pigcms_product_property_value` VALUES ('513', '7', '横拍2只', '');
INSERT INTO `pigcms_product_property_value` VALUES ('514', '7', 'T字型4人位', '');
INSERT INTO `pigcms_product_property_value` VALUES ('515', '7', '人字型4人位', '');
INSERT INTO `pigcms_product_property_value` VALUES ('516', '7', '十字型4人位', '');
INSERT INTO `pigcms_product_property_value` VALUES ('517', '106', '粉色，枫叶，蝴蝶花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('518', '106', '蝴蝶花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('519', '106', '粉色，枫叶', '');
INSERT INTO `pigcms_product_property_value` VALUES ('520', '7', 'slingshot', '');
INSERT INTO `pigcms_product_property_value` VALUES ('521', '7', 'covert', '');
INSERT INTO `pigcms_product_property_value` VALUES ('522', '106', '青花瓷，旗袍红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('523', '10', '带减震', '');
INSERT INTO `pigcms_product_property_value` VALUES ('524', '9', '德国', '');
INSERT INTO `pigcms_product_property_value` VALUES ('525', '10', '彩屏带减震', '');
INSERT INTO `pigcms_product_property_value` VALUES ('526', '106', '浅蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('527', '111', '实心100cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('528', '7', '8头彩光遥控', '');
INSERT INTO `pigcms_product_property_value` VALUES ('529', '111', '实心120cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('530', '7', '3头彩光遥控', '');
INSERT INTO `pigcms_product_property_value` VALUES ('531', '107', '118*121mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('532', '106', '白蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('533', '109', '5L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('534', '109', '15L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('535', '79', '长910mm*宽127mm*厚度15mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('536', '107', 'XS', '');
INSERT INTO `pigcms_product_property_value` VALUES ('537', '106', '白蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('538', '106', '黑红色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('539', '106', '黑黄色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('540', '106', '土豪色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('541', '86', '日常生活用品', '');
INSERT INTO `pigcms_product_property_value` VALUES ('542', '9', '中国广东', '');
INSERT INTO `pigcms_product_property_value` VALUES ('543', '10', '冰爽醒肤10片独立装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('544', '10', '去油去汗10片独立装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('545', '106', '粉蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('546', '106', '富贵紫', '');
INSERT INTO `pigcms_product_property_value` VALUES ('547', '106', '轿车蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('548', '111', '200抽', '');
INSERT INTO `pigcms_product_property_value` VALUES ('549', '106', '亮黄', '');
INSERT INTO `pigcms_product_property_value` VALUES ('550', '106', '亮蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('551', '86', '产妇专用卫生纸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('552', '111', '30cm*60cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('553', '106', '空灵-女', '');
INSERT INTO `pigcms_product_property_value` VALUES ('554', '106', '空灵-男', '');
INSERT INTO `pigcms_product_property_value` VALUES ('555', '106', '无迹-女', '');
INSERT INTO `pigcms_product_property_value` VALUES ('556', '106', '无迹-男', '');
INSERT INTO `pigcms_product_property_value` VALUES ('557', '106', '极光-女', '');
INSERT INTO `pigcms_product_property_value` VALUES ('558', '106', '极光-男', '');
INSERT INTO `pigcms_product_property_value` VALUES ('559', '111', '160克以上', '');
INSERT INTO `pigcms_product_property_value` VALUES ('560', '105', '无味', '');
INSERT INTO `pigcms_product_property_value` VALUES ('561', '1', '20cm*11cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('562', '111', '6包纸巾', '');
INSERT INTO `pigcms_product_property_value` VALUES ('563', '107', '白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('564', '107', '红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('565', '111', '72只', '');
INSERT INTO `pigcms_product_property_value` VALUES ('566', '39', '72只', '');
INSERT INTO `pigcms_product_property_value` VALUES ('567', '32', '175', '');
INSERT INTO `pigcms_product_property_value` VALUES ('568', '9', '上海', '');
INSERT INTO `pigcms_product_property_value` VALUES ('569', '5', '3公斤', '');
INSERT INTO `pigcms_product_property_value` VALUES ('570', '73', '三围：90*60*88', '');
INSERT INTO `pigcms_product_property_value` VALUES ('571', '86', '时尚前卫，追求生活情趣的女性', '');
INSERT INTO `pigcms_product_property_value` VALUES ('572', '80', '10ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('573', '2', '36', '');
INSERT INTO `pigcms_product_property_value` VALUES ('574', '2', '345', '');
INSERT INTO `pigcms_product_property_value` VALUES ('575', '5', '365', '');
INSERT INTO `pigcms_product_property_value` VALUES ('576', '5', '32', '');
INSERT INTO `pigcms_product_property_value` VALUES ('577', '8', '草莓', '');
INSERT INTO `pigcms_product_property_value` VALUES ('578', '8', '蓝莓', '');
INSERT INTO `pigcms_product_property_value` VALUES ('579', '8', '香蕉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('580', '6', '塑封', '');
INSERT INTO `pigcms_product_property_value` VALUES ('581', '6', '袋装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('582', '107', 'SML', '');
INSERT INTO `pigcms_product_property_value` VALUES ('583', '25', '2迷', '');
INSERT INTO `pigcms_product_property_value` VALUES ('584', '25', '1.2迷', '');
INSERT INTO `pigcms_product_property_value` VALUES ('585', '109', '500', '');
INSERT INTO `pigcms_product_property_value` VALUES ('586', '103', '42', '');
INSERT INTO `pigcms_product_property_value` VALUES ('587', '108', '2015', '');
INSERT INTO `pigcms_product_property_value` VALUES ('588', '8', 'tian', '');
INSERT INTO `pigcms_product_property_value` VALUES ('589', '80', '150g*3袋', '');
INSERT INTO `pigcms_product_property_value` VALUES ('590', '8', '经典原味', '');
INSERT INTO `pigcms_product_property_value` VALUES ('591', '8', '伯爵', '');
INSERT INTO `pigcms_product_property_value` VALUES ('592', '8', '经典炭烧', '');
INSERT INTO `pigcms_product_property_value` VALUES ('593', '8', '经典港式', '');
INSERT INTO `pigcms_product_property_value` VALUES ('594', '8', '经典玫瑰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('595', '1', '均码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('596', '1', '35', '');
INSERT INTO `pigcms_product_property_value` VALUES ('597', '1', '36', '');
INSERT INTO `pigcms_product_property_value` VALUES ('598', '1', '37', '');
INSERT INTO `pigcms_product_property_value` VALUES ('599', '1', '38', '');
INSERT INTO `pigcms_product_property_value` VALUES ('600', '1', '39', '');
INSERT INTO `pigcms_product_property_value` VALUES ('601', '5', '25', '');
INSERT INTO `pigcms_product_property_value` VALUES ('602', '5', '50', '');
INSERT INTO `pigcms_product_property_value` VALUES ('603', '5', '10', '');
INSERT INTO `pigcms_product_property_value` VALUES ('604', '9', '涪陵龙潭镇', '');
INSERT INTO `pigcms_product_property_value` VALUES ('605', '2', '111', '');
INSERT INTO `pigcms_product_property_value` VALUES ('606', '2', '1111', '');
INSERT INTO `pigcms_product_property_value` VALUES ('607', '5', '300', '');
INSERT INTO `pigcms_product_property_value` VALUES ('608', '5', '500', '');
INSERT INTO `pigcms_product_property_value` VALUES ('609', '5', '600', '');
INSERT INTO `pigcms_product_property_value` VALUES ('610', '5', '1000', '');
INSERT INTO `pigcms_product_property_value` VALUES ('611', '6', '瓶装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('612', '6', '塑料瓶', '');
INSERT INTO `pigcms_product_property_value` VALUES ('613', '6', '玻璃瓶', '');
INSERT INTO `pigcms_product_property_value` VALUES ('614', '1', '大号：100*70cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('615', '1', '中号：80*60cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('616', '1', '小号：70*50cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('617', '8', '高钙', '');
INSERT INTO `pigcms_product_property_value` VALUES ('618', '8', '原味', '');
INSERT INTO `pigcms_product_property_value` VALUES ('619', '31', '200', '');
INSERT INTO `pigcms_product_property_value` VALUES ('620', '31', '300', '');
INSERT INTO `pigcms_product_property_value` VALUES ('621', '30', '300', '');
INSERT INTO `pigcms_product_property_value` VALUES ('622', '30', '400', '');
INSERT INTO `pigcms_product_property_value` VALUES ('623', '4', '台', '');
INSERT INTO `pigcms_product_property_value` VALUES ('624', '27', '1988', '');
INSERT INTO `pigcms_product_property_value` VALUES ('625', '27', '1989', '');
INSERT INTO `pigcms_product_property_value` VALUES ('626', '8', '核桃', '');
INSERT INTO `pigcms_product_property_value` VALUES ('627', '8', '花生', '');
INSERT INTO `pigcms_product_property_value` VALUES ('628', '2', 'aa', '');
INSERT INTO `pigcms_product_property_value` VALUES ('629', '2', 'bb', '');
INSERT INTO `pigcms_product_property_value` VALUES ('630', '3', 'cc', '');
INSERT INTO `pigcms_product_property_value` VALUES ('631', '3', 'dd', '');
INSERT INTO `pigcms_product_property_value` VALUES ('632', '3', 'ee', '');
INSERT INTO `pigcms_product_property_value` VALUES ('633', '3', 'gg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('634', '3', 'hh', '');
INSERT INTO `pigcms_product_property_value` VALUES ('635', '3', 'hjj', '');
INSERT INTO `pigcms_product_property_value` VALUES ('636', '4', '111', '');
INSERT INTO `pigcms_product_property_value` VALUES ('637', '4', '112', '');
INSERT INTO `pigcms_product_property_value` VALUES ('638', '4', '23', '');
INSERT INTO `pigcms_product_property_value` VALUES ('639', '2', '11', '');
INSERT INTO `pigcms_product_property_value` VALUES ('640', '2', '44', '');
INSERT INTO `pigcms_product_property_value` VALUES ('641', '4', '55', '');
INSERT INTO `pigcms_product_property_value` VALUES ('642', '4', '33', '');
INSERT INTO `pigcms_product_property_value` VALUES ('643', '1', '66', '');
INSERT INTO `pigcms_product_property_value` VALUES ('644', '4', '66', '');
INSERT INTO `pigcms_product_property_value` VALUES ('645', '4', '77', '');
INSERT INTO `pigcms_product_property_value` VALUES ('646', '1', '44', '');
INSERT INTO `pigcms_product_property_value` VALUES ('647', '1', 'cc', '');
INSERT INTO `pigcms_product_property_value` VALUES ('648', '1', 'dd', '');
INSERT INTO `pigcms_product_property_value` VALUES ('649', '1', '123', '');
INSERT INTO `pigcms_product_property_value` VALUES ('650', '1', '2寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('651', '19', '1', '');
INSERT INTO `pigcms_product_property_value` VALUES ('652', '19', '2', '');
INSERT INTO `pigcms_product_property_value` VALUES ('653', '19', '4', '');
INSERT INTO `pigcms_product_property_value` VALUES ('654', '31', 'x', '');
INSERT INTO `pigcms_product_property_value` VALUES ('655', '31', 'm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('656', '31', 'xl', '');
INSERT INTO `pigcms_product_property_value` VALUES ('657', '31', 'xll', '');
INSERT INTO `pigcms_product_property_value` VALUES ('658', '31', 'xlll', '');
INSERT INTO `pigcms_product_property_value` VALUES ('659', '4', '456', '');
INSERT INTO `pigcms_product_property_value` VALUES ('660', '106', '女童（荧光绿）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('661', '106', '女童（玫红）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('662', '106', '男童（宝蓝）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('663', '106', '男童（森林绿）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('664', '1', '344', '');
INSERT INTO `pigcms_product_property_value` VALUES ('665', '1', '222', '');
INSERT INTO `pigcms_product_property_value` VALUES ('666', '1', '56', '');
INSERT INTO `pigcms_product_property_value` VALUES ('667', '1', '77', '');
INSERT INTO `pigcms_product_property_value` VALUES ('668', '1', '88', '');
INSERT INTO `pigcms_product_property_value` VALUES ('669', '1', '22', '');
INSERT INTO `pigcms_product_property_value` VALUES ('670', '2', '4', '');
INSERT INTO `pigcms_product_property_value` VALUES ('671', '2', '5', '');
INSERT INTO `pigcms_product_property_value` VALUES ('672', '2', '6', '');
INSERT INTO `pigcms_product_property_value` VALUES ('673', '2', '7', '');
INSERT INTO `pigcms_product_property_value` VALUES ('674', '2', '8', '');
INSERT INTO `pigcms_product_property_value` VALUES ('675', '2', '9', '');
INSERT INTO `pigcms_product_property_value` VALUES ('676', '2', '0', '');
INSERT INTO `pigcms_product_property_value` VALUES ('677', '2', '-', '');
INSERT INTO `pigcms_product_property_value` VALUES ('678', '2', '=', '');
INSERT INTO `pigcms_product_property_value` VALUES ('679', '111', '111', '');
INSERT INTO `pigcms_product_property_value` VALUES ('680', '3', '467', '');
INSERT INTO `pigcms_product_property_value` VALUES ('681', '1', '4563', '');
INSERT INTO `pigcms_product_property_value` VALUES ('682', '1', '4.7', '');
INSERT INTO `pigcms_product_property_value` VALUES ('683', '1', '11', '');
INSERT INTO `pigcms_product_property_value` VALUES ('684', '1', 'XLL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('685', '1', 'XLLL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('686', '1', 'XLLLL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('687', '4', '222', '');
INSERT INTO `pigcms_product_property_value` VALUES ('688', '3', '1111', '');
INSERT INTO `pigcms_product_property_value` VALUES ('689', '3', '2222', '');
INSERT INTO `pigcms_product_property_value` VALUES ('690', '2', '80.0kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('691', '2', '橙色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('692', '2', '浅紫色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('693', '1', '57-17-8mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('694', '9', '缅甸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('695', '1', '56-15-7mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('696', '1', '内径：56-66mm 宽：16-22mm 厚：6mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('697', '106', '乌鸡黑色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('698', '1', '高：25~41mm 宽：13~23mm 厚：1~3mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('699', '1', '高 　　45mm 　　宽 　　31mm 　　厚 　　8mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('700', '1', '8989', '');
INSERT INTO `pigcms_product_property_value` VALUES ('701', '1', '132', '');
INSERT INTO `pigcms_product_property_value` VALUES ('702', '1', 'M号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('703', '1', 'L号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('704', '1', 'XM号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('705', '7', '最新款', '');
INSERT INTO `pigcms_product_property_value` VALUES ('706', '1', '34', '');
INSERT INTO `pigcms_product_property_value` VALUES ('707', '1', '40', '');
INSERT INTO `pigcms_product_property_value` VALUES ('708', '13', '12月1日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('709', '13', '12月19日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('710', '13', '12月30日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('711', '10', '男款', '');
INSERT INTO `pigcms_product_property_value` VALUES ('712', '10', '女款', '');
INSERT INTO `pigcms_product_property_value` VALUES ('713', '10', '儿童款', '');
INSERT INTO `pigcms_product_property_value` VALUES ('714', '1', '45', '');
INSERT INTO `pigcms_product_property_value` VALUES ('715', '1', '666', '');
INSERT INTO `pigcms_product_property_value` VALUES ('716', '2', '4144', '');
INSERT INTO `pigcms_product_property_value` VALUES ('717', '2', '4545', '');
INSERT INTO `pigcms_product_property_value` VALUES ('718', '1', '32', '');
INSERT INTO `pigcms_product_property_value` VALUES ('719', '2', '34', '');
INSERT INTO `pigcms_product_property_value` VALUES ('720', '3', '22', '');
INSERT INTO `pigcms_product_property_value` VALUES ('721', '3', '21', '');
INSERT INTO `pigcms_product_property_value` VALUES ('722', '4', '12', '');
INSERT INTO `pigcms_product_property_value` VALUES ('723', '4', '22', '');
INSERT INTO `pigcms_product_property_value` VALUES ('724', '5', '2400', '');
INSERT INTO `pigcms_product_property_value` VALUES ('725', '5', '3960', '');
INSERT INTO `pigcms_product_property_value` VALUES ('726', '5', '330', '');
INSERT INTO `pigcms_product_property_value` VALUES ('727', '5', '165', '');
INSERT INTO `pigcms_product_property_value` VALUES ('728', '106', '亚光灰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('729', '106', '银白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('730', '83', '18-23', '');
INSERT INTO `pigcms_product_property_value` VALUES ('731', '1', '59-12-6mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('732', '5', '500g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('733', '1', '41', '');
INSERT INTO `pigcms_product_property_value` VALUES ('734', '1', '42', '');
INSERT INTO `pigcms_product_property_value` VALUES ('735', '1', '4.8', '');
INSERT INTO `pigcms_product_property_value` VALUES ('736', '80', 'ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('737', '80', 'l', '');
INSERT INTO `pigcms_product_property_value` VALUES ('738', '106', '220', '');
INSERT INTO `pigcms_product_property_value` VALUES ('739', '106', '140', '');
INSERT INTO `pigcms_product_property_value` VALUES ('740', '106', '230', '');
INSERT INTO `pigcms_product_property_value` VALUES ('741', '106', '720', '');
INSERT INTO `pigcms_product_property_value` VALUES ('742', '106', '150', '');
INSERT INTO `pigcms_product_property_value` VALUES ('743', '106', '420', '');
INSERT INTO `pigcms_product_property_value` VALUES ('744', '106', '210', '');
INSERT INTO `pigcms_product_property_value` VALUES ('745', '106', '610', '');
INSERT INTO `pigcms_product_property_value` VALUES ('746', '111', '5A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('747', '111', '7A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('748', '111', '9A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('749', '19', 'PHP格式', '');
INSERT INTO `pigcms_product_property_value` VALUES ('750', '1', '1400', '');
INSERT INTO `pigcms_product_property_value` VALUES ('751', '1', '长 1400', '');
INSERT INTO `pigcms_product_property_value` VALUES ('752', '1', '高 2100', '');
INSERT INTO `pigcms_product_property_value` VALUES ('753', '106', '枫木色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('754', '5', '1100', '');
INSERT INTO `pigcms_product_property_value` VALUES ('755', '1', 'XX', '');
INSERT INTO `pigcms_product_property_value` VALUES ('756', '1', 'XM', '');
INSERT INTO `pigcms_product_property_value` VALUES ('757', '19', '基础版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('758', '19', '增值版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('759', '19', '至尊版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('760', '19', '次年续费', '');
INSERT INTO `pigcms_product_property_value` VALUES ('761', '1', '1.2米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('762', '1', '1.5米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('763', '1', '1.8米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('764', '111', '套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('765', '111', '1套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('766', '111', '标准版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('767', '111', '升级版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('768', '111', '行业版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('769', '103', '35', '');
INSERT INTO `pigcms_product_property_value` VALUES ('770', '103', '36', '');
INSERT INTO `pigcms_product_property_value` VALUES ('771', '103', '37', '');
INSERT INTO `pigcms_product_property_value` VALUES ('772', '103', '38', '');
INSERT INTO `pigcms_product_property_value` VALUES ('773', '103', '39', '');
INSERT INTO `pigcms_product_property_value` VALUES ('774', '103', '40', '');
INSERT INTO `pigcms_product_property_value` VALUES ('775', '106', 'heise', '');
INSERT INTO `pigcms_product_property_value` VALUES ('776', '80', '60粒', '');
INSERT INTO `pigcms_product_property_value` VALUES ('777', '80', '100粒', '');
INSERT INTO `pigcms_product_property_value` VALUES ('778', '80', '120粒', '');
INSERT INTO `pigcms_product_property_value` VALUES ('779', '80', '200粒', '');
INSERT INTO `pigcms_product_property_value` VALUES ('780', '111', '908g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('781', '80', '20粒', '');
INSERT INTO `pigcms_product_property_value` VALUES ('782', '1', '1.8实', '');
INSERT INTO `pigcms_product_property_value` VALUES ('783', '1', '1.8米]', '');
INSERT INTO `pigcms_product_property_value` VALUES ('784', '1', '2米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('785', '1', '2.0米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('786', '19', '标准版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('787', '19', '升级版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('788', '19', '行业版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('789', '106', '褐色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('790', '1', '16G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('791', '111', '900克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('792', '2', '斯蒂芬 防撒旦', '');
INSERT INTO `pigcms_product_property_value` VALUES ('793', '32', '大', '');
INSERT INTO `pigcms_product_property_value` VALUES ('794', '32', '中', '');
INSERT INTO `pigcms_product_property_value` VALUES ('795', '32', '小', '');
INSERT INTO `pigcms_product_property_value` VALUES ('796', '1', '5', '');
INSERT INTO `pigcms_product_property_value` VALUES ('797', '4', '北京地区', '');
INSERT INTO `pigcms_product_property_value` VALUES ('798', '4', '保定地区', '');
INSERT INTO `pigcms_product_property_value` VALUES ('799', '4', '北京地区服务', '');
INSERT INTO `pigcms_product_property_value` VALUES ('800', '4', '秦皇岛地区服务', '');
INSERT INTO `pigcms_product_property_value` VALUES ('801', '4', '保定地区服务', '');
INSERT INTO `pigcms_product_property_value` VALUES ('802', '4', '唐山地区服务', '');
INSERT INTO `pigcms_product_property_value` VALUES ('803', '13', '一月1号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('804', '13', '一月2号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('805', '13', '一月3号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('806', '13', '一月4号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('807', '13', '一月5号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('808', '13', '一月6号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('809', '13', '一月7号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('810', '13', '一月八号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('811', '31', 'XXL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('812', '27', '二月一号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('813', '27', '二月二号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('814', '27', '二月三号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('815', '27', '二月四号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('816', '27', '一月一日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('817', '27', '一月二日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('818', '27', '一月三日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('819', '27', '一月四日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('820', '27', '一月五日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('821', '27', '一月六日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('822', '27', '一月七日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('823', '13', '2015', '');
INSERT INTO `pigcms_product_property_value` VALUES ('824', '10', '卡片', '');
INSERT INTO `pigcms_product_property_value` VALUES ('825', '111', '心相随', '');
INSERT INTO `pigcms_product_property_value` VALUES ('826', '111', '阳光心情-青驼', '');
INSERT INTO `pigcms_product_property_value` VALUES ('827', '7', '电脑式', '');
INSERT INTO `pigcms_product_property_value` VALUES ('828', '31', '禾诗 HS-08F', '');
INSERT INTO `pigcms_product_property_value` VALUES ('829', '1', '1.2炚', '');
INSERT INTO `pigcms_product_property_value` VALUES ('830', '106', '时尚花都-大红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('831', '106', '素雅流年--紫', '');
INSERT INTO `pigcms_product_property_value` VALUES ('832', '106', '千娇百媚', '');
INSERT INTO `pigcms_product_property_value` VALUES ('833', '106', '塞利维亚', '');
INSERT INTO `pigcms_product_property_value` VALUES ('834', '106', '心相随', '');
INSERT INTO `pigcms_product_property_value` VALUES ('835', '106', '幸福爱意-豆沙', '');
INSERT INTO `pigcms_product_property_value` VALUES ('836', '106', '伊莎贝尔--紫色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('837', '106', '伊人香气-紫罗兰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('838', '106', '凡尔赛', '');
INSERT INTO `pigcms_product_property_value` VALUES ('839', '106', '皇家风范-驼色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('840', '106', '凯瑟大厅--红玉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('841', '106', '花语柔情--紫罗兰', '');
INSERT INTO `pigcms_product_property_value` VALUES ('842', '106', '其它花色请备注', '');
INSERT INTO `pigcms_product_property_value` VALUES ('843', '106', '酷儿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('844', '106', '飞舞时光', '');
INSERT INTO `pigcms_product_property_value` VALUES ('845', '106', '东方剑桥', '');
INSERT INTO `pigcms_product_property_value` VALUES ('846', '106', '浪漫花丛', '');
INSERT INTO `pigcms_product_property_value` VALUES ('847', '106', '安妮宝贝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('848', '106', '碧海柔情', '');
INSERT INTO `pigcms_product_property_value` VALUES ('849', '106', '淡雅格调', '');
INSERT INTO `pigcms_product_property_value` VALUES ('850', '106', '花开四季', '');
INSERT INTO `pigcms_product_property_value` VALUES ('851', '106', '可爱女孩', '');
INSERT INTO `pigcms_product_property_value` VALUES ('852', '1', '1.85米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('853', '106', '百丽佳人', '');
INSERT INTO `pigcms_product_property_value` VALUES ('854', '106', '花蝶凤兰-桔', '');
INSERT INTO `pigcms_product_property_value` VALUES ('855', '106', '流光百媚', '');
INSERT INTO `pigcms_product_property_value` VALUES ('856', '106', '思香', '');
INSERT INTO `pigcms_product_property_value` VALUES ('857', '106', '甜美意境', '');
INSERT INTO `pigcms_product_property_value` VALUES ('858', '1', '1.5哦也', '');
INSERT INTO `pigcms_product_property_value` VALUES ('859', '1', '1.', '');
INSERT INTO `pigcms_product_property_value` VALUES ('860', '106', '暖暖浅春-粉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('861', '106', '月舞飞扬', '');
INSERT INTO `pigcms_product_property_value` VALUES ('862', '106', '花团锦绣', '');
INSERT INTO `pigcms_product_property_value` VALUES ('863', '106', '花源-蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('864', '106', '唯美若诗', '');
INSERT INTO `pigcms_product_property_value` VALUES ('865', '106', '沁馨花语', '');
INSERT INTO `pigcms_product_property_value` VALUES ('866', '106', '东方情致', '');
INSERT INTO `pigcms_product_property_value` VALUES ('867', '106', '缤纷花溢', '');
INSERT INTO `pigcms_product_property_value` VALUES ('868', '106', '水色蝶舞', '');
INSERT INTO `pigcms_product_property_value` VALUES ('869', '106', '筱梦提香', '');
INSERT INTO `pigcms_product_property_value` VALUES ('870', '106', '雅熙花园', '');
INSERT INTO `pigcms_product_property_value` VALUES ('871', '110', '编号', '');
INSERT INTO `pigcms_product_property_value` VALUES ('872', '110', 'waixing', '');
INSERT INTO `pigcms_product_property_value` VALUES ('873', '110', '外形', '');
INSERT INTO `pigcms_product_property_value` VALUES ('874', '5', '190', '');
INSERT INTO `pigcms_product_property_value` VALUES ('875', '5', '490', '');
INSERT INTO `pigcms_product_property_value` VALUES ('876', '1', '厘米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('877', '30', '克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('878', '1', '5.9*4.2*1.2cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('879', '30', '5克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('880', '2', 'd', '');
INSERT INTO `pigcms_product_property_value` VALUES ('881', '2', 'dd', '');
INSERT INTO `pigcms_product_property_value` VALUES ('882', '5', '220g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('883', '3', '自动机械', '');
INSERT INTO `pigcms_product_property_value` VALUES ('884', '32', '30', '');
INSERT INTO `pigcms_product_property_value` VALUES ('885', '32', '40', '');
INSERT INTO `pigcms_product_property_value` VALUES ('886', '32', '50', '');
INSERT INTO `pigcms_product_property_value` VALUES ('887', '5', '900g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('888', '22', '1年', '');
INSERT INTO `pigcms_product_property_value` VALUES ('889', '27', '6月1日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('890', '9', '卡斯蒂利亚', '');
INSERT INTO `pigcms_product_property_value` VALUES ('891', '8', '带樱桃香味', '');
INSERT INTO `pigcms_product_property_value` VALUES ('892', '5', '750ml*1*12', '');
INSERT INTO `pigcms_product_property_value` VALUES ('893', '111', '750ml*1*12', '');
INSERT INTO `pigcms_product_property_value` VALUES ('894', '1', '64', '');
INSERT INTO `pigcms_product_property_value` VALUES ('895', '1', '70', '');
INSERT INTO `pigcms_product_property_value` VALUES ('896', '1', '76', '');
INSERT INTO `pigcms_product_property_value` VALUES ('897', '1', '82', '');
INSERT INTO `pigcms_product_property_value` VALUES ('898', '1', '90', '');
INSERT INTO `pigcms_product_property_value` VALUES ('899', '13', '6月1日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('900', '13', '6月日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('901', '13', '6月3日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('902', '30', '斤', '');
INSERT INTO `pigcms_product_property_value` VALUES ('903', '14', '成人', '');
INSERT INTO `pigcms_product_property_value` VALUES ('904', '14', '儿童', '');
INSERT INTO `pigcms_product_property_value` VALUES ('905', '1', '风格', '');
INSERT INTO `pigcms_product_property_value` VALUES ('906', '111', '浓郁的红色水果的芳香气息', '');
INSERT INTO `pigcms_product_property_value` VALUES ('907', '2', '10', '');
INSERT INTO `pigcms_product_property_value` VALUES ('908', '2', '20', '');
INSERT INTO `pigcms_product_property_value` VALUES ('909', '2', '30', '');
INSERT INTO `pigcms_product_property_value` VALUES ('910', '8', '浓郁的红色水果的芳香气息', '');
INSERT INTO `pigcms_product_property_value` VALUES ('911', '9', '里奥哈', '');
INSERT INTO `pigcms_product_property_value` VALUES ('912', '106', '淡蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('913', '31', '双人', '');
INSERT INTO `pigcms_product_property_value` VALUES ('914', '31', '单人', '');
INSERT INTO `pigcms_product_property_value` VALUES ('915', '1', '7寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('916', '106', '淡黄色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('917', '107', '尺码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('918', '107', 'F', '');
INSERT INTO `pigcms_product_property_value` VALUES ('919', '106', '米', '');
INSERT INTO `pigcms_product_property_value` VALUES ('920', '106', '玉色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('921', '5', '包', '');
INSERT INTO `pigcms_product_property_value` VALUES ('922', '6', '罐装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('923', '1', '43', '');
INSERT INTO `pigcms_product_property_value` VALUES ('924', '1', '1.5米*200', '');
INSERT INTO `pigcms_product_property_value` VALUES ('925', '106', '米黄', '');
INSERT INTO `pigcms_product_property_value` VALUES ('926', '26', '36', '');
INSERT INTO `pigcms_product_property_value` VALUES ('927', '26', '37', '');
INSERT INTO `pigcms_product_property_value` VALUES ('928', '26', '38', '');
INSERT INTO `pigcms_product_property_value` VALUES ('929', '26', '39', '');
INSERT INTO `pigcms_product_property_value` VALUES ('930', '31', 'GT630', '');
INSERT INTO `pigcms_product_property_value` VALUES ('931', '1', '10寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('932', '31', 'GT610', '');
INSERT INTO `pigcms_product_property_value` VALUES ('933', '1', '12寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('934', '31', 'GT600', '');
INSERT INTO `pigcms_product_property_value` VALUES ('935', '31', 'GT590', '');
INSERT INTO `pigcms_product_property_value` VALUES ('936', '31', 'GT580', '');
INSERT INTO `pigcms_product_property_value` VALUES ('937', '1', '1.2哦也', '');
INSERT INTO `pigcms_product_property_value` VALUES ('938', '1', '1.5主', '');
INSERT INTO `pigcms_product_property_value` VALUES ('939', '106', '锦上添花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('940', '106', '纯真时代', '');
INSERT INTO `pigcms_product_property_value` VALUES ('941', '106', '粉色兔', '');
INSERT INTO `pigcms_product_property_value` VALUES ('942', '106', '其它颜色请备注', '');
INSERT INTO `pigcms_product_property_value` VALUES ('943', '1', '10.14寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('944', '1', '上14寸，下16寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('945', '1', '上10寸.下14寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('946', '1', '上12寸.下16寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('947', '1', '上8寸.中12寸.下16寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('948', '31', 'GC-21XSQ', '');
INSERT INTO `pigcms_product_property_value` VALUES ('949', '1', '2000*200', '');
INSERT INTO `pigcms_product_property_value` VALUES ('950', '1', '14寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('951', '1', '8寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('952', '12', '国行100D单机标配特价', '');
INSERT INTO `pigcms_product_property_value` VALUES ('953', '12', '港版100D单机标配', '');
INSERT INTO `pigcms_product_property_value` VALUES ('954', '1', '6寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('955', '26', '均码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('956', '7', '三角裤', '');
INSERT INTO `pigcms_product_property_value` VALUES ('957', '106', '大红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('958', '106', '碧绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('959', '107', '均码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('960', '5', '500ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('961', '5', '1000ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('962', '9', '厦门', '');
INSERT INTO `pigcms_product_property_value` VALUES ('963', '111', '30#', '');
INSERT INTO `pigcms_product_property_value` VALUES ('964', '111', '32#', '');
INSERT INTO `pigcms_product_property_value` VALUES ('965', '111', '28#', '');
INSERT INTO `pigcms_product_property_value` VALUES ('966', '26', 'S', '');
INSERT INTO `pigcms_product_property_value` VALUES ('967', '26', 'M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('968', '26', 'L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('969', '5', '60g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('970', '6', '金装奶粉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('971', '7', '条纹', '');
INSERT INTO `pigcms_product_property_value` VALUES ('972', '7', '花色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('973', '7', '网状', '');
INSERT INTO `pigcms_product_property_value` VALUES ('974', '7', 'V领', '');
INSERT INTO `pigcms_product_property_value` VALUES ('975', '1', '175', '');
INSERT INTO `pigcms_product_property_value` VALUES ('976', '1', '180', '');
INSERT INTO `pigcms_product_property_value` VALUES ('977', '1', '185', '');
INSERT INTO `pigcms_product_property_value` VALUES ('978', '7', '格子', '');
INSERT INTO `pigcms_product_property_value` VALUES ('979', '106', '黄褐色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('980', '10', 'HEV版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('981', '10', '藏版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('982', '107', '38码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('983', '107', '39码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('984', '107', '40码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('985', '107', '41码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('986', '107', '42码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('987', '107', '43码', '');
INSERT INTO `pigcms_product_property_value` VALUES ('988', '111', '34#', '');
INSERT INTO `pigcms_product_property_value` VALUES ('989', '111', '363', '');
INSERT INTO `pigcms_product_property_value` VALUES ('990', '111', '36#', '');
INSERT INTO `pigcms_product_property_value` VALUES ('991', '1', 'xs', '');
INSERT INTO `pigcms_product_property_value` VALUES ('992', '7', '商务', '');
INSERT INTO `pigcms_product_property_value` VALUES ('993', '7', '休闲', '');
INSERT INTO `pigcms_product_property_value` VALUES ('994', '109', '750ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('995', '110', '曼男爵', '');
INSERT INTO `pigcms_product_property_value` VALUES ('996', '110', '勒胜庄', '');
INSERT INTO `pigcms_product_property_value` VALUES ('997', '110', '维而蒂  月亮河  圣峰岩  圣人里鹏  乐奔  大主教  玫思  泽思  若思  百酿吉诺  维若', '');
INSERT INTO `pigcms_product_property_value` VALUES ('998', '110', '维而蒂', '');
INSERT INTO `pigcms_product_property_value` VALUES ('999', '110', '月亮河', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1000', '110', '奔富', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1001', '20', '干红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1002', '20', '甜白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1003', '110', '套装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1004', '111', 'qweq', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1005', '111', 'weqcs', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1006', '22', '1月', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1007', '10', '微官网', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1008', '10', '微商城', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1009', '10', '三级分销商', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1010', '22', '1次', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1011', '5', '一斤', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1012', '5', '两斤', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1013', '5', '半斤', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1014', '30', '半斤', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1015', '30', '250g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1016', '111', 'M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1017', '111', 'L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1018', '111', 'XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1019', '111', 'XXL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1020', '3', 'acer', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1021', '7', 'hese', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1022', '22', '最低十五年', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1023', '4', '使用幼儿园到高中的全部学生', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1024', '79', '28', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1025', '79', '29', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1026', '79', '30', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1027', '79', '31', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1028', '79', '32', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1029', '79', '33', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1030', '31', '39', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1031', '31', '40', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1032', '31', '41', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1033', '31', '42', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1034', '31', '43', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1035', '79', 'M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1036', '79', 'L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1037', '79', 'XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1038', '8', '不辣', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1039', '8', '微辣', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1040', '8', '超辣', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1041', '5', '400克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1042', '111', '750', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1043', '111', '500', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1044', '30', '100', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1045', '30', '50', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1046', '30', '200', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1047', '1', '下16寸，中12寸，上8寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1048', '1', '下14寸，上10寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1049', '1', '170', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1050', '30', '125g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1051', '1', '六层（6寸+8寸+10寸+12寸+14寸+16寸）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1052', '107', '36 37 38 39', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1053', '1', '八层（6寸+8寸+10寸+12寸+14寸+16寸+18寸+20寸）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1054', '1', '小三层（8寸+10寸+12寸）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1055', '1', '大三层（10寸+12寸+14寸）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1056', '1', '7cun', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1057', '1', '三层（8寸+10寸+14寸）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1058', '1', '21寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1059', '1', '22寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1060', '1', '23寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1061', '1', '24寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1062', '2', '2kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1063', '2', '2.2kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1064', '106', '银', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1065', '2', '2.4kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1066', '2', '2.6kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1067', '106', '金', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1068', '1', '5.5寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1069', '7', 'iphone6', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1070', '7', 'iphone plus', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1071', '1', '三层（8寸+12寸+14寸）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1072', '1', '16寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1073', '1', '15cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1074', '1', '20cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1075', '5', '2kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1076', '5', '1.5kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1077', '5', '242g*2', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1078', '5', '202g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1079', '5', '202g*2', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1080', '5', '1.68kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1081', '5', '650g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1082', '5', '600g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1083', '1', '165', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1084', '1', '25寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1085', '11', '4G', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1086', '1', '5寸', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1087', '57', '提供早餐', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1088', '57', '提供免费宽带服务', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1089', '57', '热水洗浴', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1090', '57', '所有房型均有窗', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1091', '57', '单间A：1张床（1.5mx2m）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1092', '57', '标间B：2张床（1.2mx2m）', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1093', '1', '10*10', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1094', '4', '微信支付 支付宝 拉卡拉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1095', '103', '3536373839', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1096', '1', '10*20', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1097', '5', '1kg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1098', '106', '橄榄绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1099', '1', '180mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1100', '1', '240mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1101', '1', '480mm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1102', '1', '迷你', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1103', '1', '中长款', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1104', '1', '长款', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1105', '106', '典雅红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1106', '106', '经典黑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1107', '4', '小票', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1108', '1', '15*30', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1109', '4', '刷粉神器', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1110', '3', '真八核', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1111', '4', '吸粉神器', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1112', '4', '覆盖100㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1113', '4', '覆盖200㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1114', '4', '覆盖300㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1115', '1', '24', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1116', '1', '25', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1117', '1', '26', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1118', '10', '牛皮', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1119', '10', '呢子', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1120', '8', '斯蒂芬', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1121', '8', '多的', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1122', '34', '100㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1123', '34', '200㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1124', '34', '300㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1125', '31', '100㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1126', '31', '200㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1127', '31', '300㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1128', '34', '500㎡', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1129', '1', '小型', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1130', '1', '中型', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1131', '6', '盒装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1132', '5', '120克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1133', '5', '200克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1134', '1', 'kk', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1135', '1', 'daxia', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1136', '1', 'dadfa', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1137', '1', 'dasfads', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1138', '1', 'adsfads', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1139', '1', 'asdfads', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1140', '1', 'adsfdasfa', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1141', '1', 'asdfadsf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1142', '1', 'fasdfadsf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1143', '1', 'asdfasd', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1144', '1', 'safasdfadsf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1145', '6', '压缩', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1146', '8', '醇香', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1147', '6', '压缩盒装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1148', '73', '全脂乳粉、白砂糖、发酵乳、低聚麦芽糖、葡萄糖粉、植脂末、柠檬酸、食用香精', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1149', '8', '香辣', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1150', '1', 'sadf;kjsadfl', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1151', '1', 'asdfdasf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1152', '1', 'adsfadsf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1153', '1', 'sadfadsf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1154', '1', 'asdfadsfasdfa', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1155', '1', 'adsfadsfadsfas', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1156', '1', 'dasfadsfads', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1157', '1', 'asdfasdfasdf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1158', '1', 'adsfasdfasf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1159', '1', 'adsfasfadsf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1160', '1', 'adsfasfasfasfasfas', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1161', '1', '撒打发似的', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1162', '1', '阿斯蒂芬', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1163', '1', '多对多', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1164', '5', '225ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1165', '5', '100ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1166', '5', '300ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1167', '1', 'aa', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1168', '4', '1111', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1169', '4', '1111111111111111111', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1170', '2', '5555', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1171', '2', '5555555', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1172', '100', '1.5', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1173', '100', '0.8', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1174', '111', '本', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1175', '1', 'sfsdf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1176', '5', '25g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1177', '32', '一盒', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1178', '6', '盒', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1179', '6', '片', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1180', '7', '75A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1181', '7', '70A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1182', '7', '80A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1183', '6', '大红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1184', '6', '橙色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1185', '6', '润绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1186', '6', '黑色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1187', '106', '粉丝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1188', '1', '20', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1189', '1', '21', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1190', '1', '23', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1191', '1', '27', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1192', '1', '28', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1193', '1', '29', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1194', '1', '30', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1195', '1', '31', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1196', '1', '33', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1197', '106', '黑色、黄色、黑黄、藏青、玫红、深红、浅红、蓝色、粉肉、浅粉紫、红蓝、桔色、紫玫红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1198', '106', '黑黄', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1199', '106', '深红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1200', '106', '浅红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1201', '106', '粉肉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1202', '106', '浅粉紫', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1203', '106', '红蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1204', '106', '紫玫红', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1205', '4', '电子称', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1206', '111', '900', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1207', '111', '1500', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1208', '2', '1', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1209', '104', '35', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1210', '104', '36', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1211', '104', '37', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1212', '104', '38', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1213', '104', '39', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1214', '104', '40', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1215', '107', '155/80A/S', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1216', '107', '160/84A/M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1217', '1', '28 29 32 31 32 33 34 35 36 37', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1218', '1', '24L 48L 58L 68L 88L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1219', '1', '】', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1220', '106', '梦幻蓝 薄荷绿 烟花粉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1221', '86', '内衣 大衣/西服 毛衣 包包', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1222', '106', '白绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1223', '106', '本白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1224', '109', '15ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1225', '109', '12mg', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1226', '109', '60ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1227', '109', '30ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1228', '109', '700', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1229', '109', '900', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1230', '1', '46', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1231', '5', '100、', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1232', '6', '11', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1233', '1', '我的', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1234', '1', '好', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1235', '3', '不', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1236', '1', 'eee', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1237', '1', '二二二', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1238', '3', '让人', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1239', '3', '日日日', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1240', '3', 'eer', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1241', '2', '121', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1242', '2', '235', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1243', '3', 'aass', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1244', '3', 'c', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1245', '4', '水电费', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1246', '73', '运费', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1247', '5', '500克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1248', '107', '39，40，41', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1249', '106', '灰色，黑色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1250', '108', '2015年夏季', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1251', '73', '印花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1252', '73', '韩版', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1253', '73', '纯棉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1254', '73', '修身', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1255', '107', '均码、修身', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1256', '17', '纯棉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1257', '108', '20105年夏季', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1258', '79', '110cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1259', '79', '120cm 130cm 140cm 150cm 160cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1260', '79', '120cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1261', '79', '130cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1262', '79', '140cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1263', '79', '150cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1264', '79', '160cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1265', '1', 'xk', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1266', '1', '75A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1267', '1', '75B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1268', '1', '80A', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1269', '1', '80B', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1270', '1', '37、38', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1271', '106', '浅绿色、淡黄色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1272', '1', '110cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1273', '1', '120cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1274', '1', '130cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1275', '1', '140cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1276', '1', '150cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1277', '1', '160cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1278', '1', ';', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1279', '1', '2XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1280', '106', '浅黄色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1281', '106', '藏蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1282', '106', '甜心粉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1283', '17', '平纹棉', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1284', '31', '10W40', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1285', '31', '10W30', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1286', '106', '天蓝', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1287', '5', '10克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1288', '5', '20克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1289', '5', '30克', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1290', '1', 'C', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1291', '106', 'bai', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1292', '7', '吊带', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1293', '83', '25-29周岁', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1294', '7', '连衣裙', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1295', '109', '750', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1296', '109', '75', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1297', '109', '50', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1298', '1', 'dsada', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1299', '1', '2M*2.3M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1300', '1', '1.8M*2M', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1301', '6', '无包装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1302', '6', '有包装', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1303', '4', '男士', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1304', '4', '女士', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1305', '1', '长', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1306', '1', '宽', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1307', '1', '边距', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1308', '31', 'mx3', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1309', '31', 'mx4', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1310', '31', 'note', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1311', '31', 'm2', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1312', '31', 'm3', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1313', '31', 'm4', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1314', '1', '水电费', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1315', '1', '165M 170L 175XL 180XXL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1316', '109', '1.8L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1317', '109', '2.5', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1318', '106', '其它', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1319', '4', '移动', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1320', '4', '点心', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1321', '4', '电信', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1322', '4', '联通', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1323', '4', '三网合一', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1324', '1', '165L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1325', '1', '170L', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1326', '1', '175XL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1327', '1', '180XXL', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1328', '1', 'sdfdsf', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1329', '86', '美白', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1330', '86', '祛斑', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1331', '1', '啥地方大厦法第三方', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1332', '86', '保湿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1333', '3', '萨达、', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1334', '109', '100ml', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1335', '4', '手机音频接口', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1336', '4', '手机APP', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1337', '4', '手机音频接口、手机APP', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1338', '1', '6', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1339', '1', '8', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1340', '1', '10', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1341', '1', '14', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1342', '111', '箱', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1343', '93', '箱', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1344', '87', '箱', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1345', '106', '灰色809', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1346', '106', '军绿808', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1347', '106', '浅绿606', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1348', '6', '袋', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1349', '106', '军绿807', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1350', '6', '箱', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1351', '2', '2222', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1352', '2', 'qqqqq', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1353', '2', 'aaa', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1354', '2', 'dda', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1355', '2', 'ass', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1356', '2', 'EEE', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1357', '2', 'RR', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1358', '2', 'RRR', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1359', '2', 'EE', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1360', '2', 'TTT', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1361', '2', 'GFGG', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1362', '2', 'EESSS', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1363', '3', 'KJJJ', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1364', '3', 'JJJ', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1365', '30', '300g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1366', '30', '500g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1367', '2', '是的范德萨', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1368', '2', 'sdfds', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1369', '4', '点点滴滴', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1370', '4', '大多数是谁', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1371', '2', '100g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1372', '2', '200g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1373', '2', '12g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1374', '2', '15g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1375', '2', '18g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1376', '2', '25g', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1377', '2', '问我', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1378', '2', '呜呜呜呜', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1379', '4', '啥地方', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1380', '4', '啥地方第三方', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1381', '6', 'iii', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1382', '6', '水电费', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1383', '7', '白色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1384', '7', '蓝色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1385', '7', '灰色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1386', '1', '７.１', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1387', '111', '米粉底绿花', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1388', '111', '冰淇淋图案', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1389', '106', '灰绿', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1390', '106', '月色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1391', '106', '玫瑰色', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1392', '1', '190', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1393', '1', '180cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1394', '1', '200cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1395', '1', '230cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1396', '1', '被套(200cm*230cm)  床罩（250cm*270cm） 小枕套（50cm*70cm）  大', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1397', '1', '被套(200cm*230cm) 床罩（250cm*270cm） 小枕套（50cm*70cm） 大枕套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1398', '1', '被套(200cm*230cm)    床罩（250cm*270cm）   小枕套（45cm*75cm', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1399', '1', '被套(200cm*230cm) 床罩（250cm*270cm） 小枕套（45cm*75cm） 大枕套', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1400', '1', '被套（200cm*230cm）  床罩（250cm*270cm）  小枕套（45cm*75cm）  ', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1401', '1', '12mm', 'images/000/000/036/201509/55f6942581e9d.jpg');
INSERT INTO `pigcms_product_property_value` VALUES ('1402', '2', 'aa', '');
INSERT INTO `pigcms_product_property_value` VALUES ('1403', '1', '21mm', '');

-- ----------------------------
-- Table structure for `pigcms_product_qrcode_activity`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_qrcode_activity`;
CREATE TABLE `pigcms_product_qrcode_activity` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL default '0' COMMENT '店铺id',
  `product_id` int(11) NOT NULL default '0' COMMENT '商品id',
  `buy_type` tinyint(1) NOT NULL default '0' COMMENT '购买方式 0扫码直接购买',
  `type` tinyint(1) NOT NULL default '0' COMMENT '优惠方式 0扫码折扣 1扫码可减优惠',
  `discount` float NOT NULL default '0' COMMENT '折扣',
  `price` decimal(10,2) NOT NULL default '0.00' COMMENT '优惠金额',
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`),
  KEY `product_id` USING BTREE (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='商品扫码活动';

-- ----------------------------
-- Records of pigcms_product_qrcode_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_sku`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_sku`;
CREATE TABLE `pigcms_product_sku` (
  `sku_id` int(10) NOT NULL auto_increment COMMENT '库存id',
  `product_id` int(10) NOT NULL,
  `properties` varchar(500) NOT NULL default '' COMMENT '商品属性组合 pid1:vid1;pid2:vid2;pid3:vid3',
  `quantity` int(10) NOT NULL default '0' COMMENT '库存',
  `price` decimal(10,2) NOT NULL default '0.00' COMMENT '价格',
  `code` varchar(50) NOT NULL default '' COMMENT '库存编码',
  `sales` int(10) NOT NULL default '0' COMMENT '销量',
  `cost_price` decimal(10,2) NOT NULL default '0.00' COMMENT '成本价格',
  `min_fx_price` decimal(10,2) NOT NULL default '0.00' COMMENT '分销最低价格',
  `max_fx_price` decimal(10,2) NOT NULL default '0.00' COMMENT '分销最高价格',
  `drp_level_1_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '一级分销商商品价格',
  `drp_level_2_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '二级分销商商品价格',
  `drp_level_3_price` decimal(10,2) NOT NULL default '0.00' COMMENT '三级分销商商品价格',
  `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '一级分销商商品成本价格',
  `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '二级分销商商品成本价格',
  `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '三级分销商商品成本价格',
  PRIMARY KEY  (`sku_id`),
  KEY `code` USING BTREE (`code`),
  KEY `product_id` USING BTREE (`product_id`,`quantity`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COMMENT='商品库存';

-- ----------------------------
-- Records of pigcms_product_sku
-- ----------------------------
INSERT INTO `pigcms_product_sku` VALUES ('139', '111', '1:1401;2:1402', '222', '1.00', '333', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `pigcms_product_sku` VALUES ('140', '111', '1:1403;2:1402', '222', '1.00', '444', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- ----------------------------
-- Table structure for `pigcms_product_to_group`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_to_group`;
CREATE TABLE `pigcms_product_to_group` (
  `product_id` int(11) NOT NULL default '0' COMMENT '商品id',
  `group_id` int(11) NOT NULL default '0' COMMENT '分组id',
  KEY `product_id` USING BTREE (`product_id`),
  KEY `group_id` USING BTREE (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分组关联';

-- ----------------------------
-- Records of pigcms_product_to_group
-- ----------------------------
INSERT INTO `pigcms_product_to_group` VALUES ('55', '17');
INSERT INTO `pigcms_product_to_group` VALUES ('54', '17');
INSERT INTO `pigcms_product_to_group` VALUES ('53', '17');
INSERT INTO `pigcms_product_to_group` VALUES ('52', '16');
INSERT INTO `pigcms_product_to_group` VALUES ('51', '16');
INSERT INTO `pigcms_product_to_group` VALUES ('50', '16');
INSERT INTO `pigcms_product_to_group` VALUES ('49', '15');
INSERT INTO `pigcms_product_to_group` VALUES ('48', '15');
INSERT INTO `pigcms_product_to_group` VALUES ('47', '15');
INSERT INTO `pigcms_product_to_group` VALUES ('46', '14');
INSERT INTO `pigcms_product_to_group` VALUES ('45', '14');
INSERT INTO `pigcms_product_to_group` VALUES ('44', '14');
INSERT INTO `pigcms_product_to_group` VALUES ('43', '13');
INSERT INTO `pigcms_product_to_group` VALUES ('42', '13');
INSERT INTO `pigcms_product_to_group` VALUES ('41', '13');
INSERT INTO `pigcms_product_to_group` VALUES ('58', '20');
INSERT INTO `pigcms_product_to_group` VALUES ('59', '21');
INSERT INTO `pigcms_product_to_group` VALUES ('60', '22');
INSERT INTO `pigcms_product_to_group` VALUES ('61', '22');
INSERT INTO `pigcms_product_to_group` VALUES ('62', '22');
INSERT INTO `pigcms_product_to_group` VALUES ('63', '23');
INSERT INTO `pigcms_product_to_group` VALUES ('64', '23');
INSERT INTO `pigcms_product_to_group` VALUES ('65', '23');
INSERT INTO `pigcms_product_to_group` VALUES ('0', '24');
INSERT INTO `pigcms_product_to_group` VALUES ('0', '24');
INSERT INTO `pigcms_product_to_group` VALUES ('0', '24');
INSERT INTO `pigcms_product_to_group` VALUES ('66', '25');
INSERT INTO `pigcms_product_to_group` VALUES ('67', '25');
INSERT INTO `pigcms_product_to_group` VALUES ('68', '25');
INSERT INTO `pigcms_product_to_group` VALUES ('69', '26');
INSERT INTO `pigcms_product_to_group` VALUES ('70', '26');
INSERT INTO `pigcms_product_to_group` VALUES ('71', '26');
INSERT INTO `pigcms_product_to_group` VALUES ('72', '27');
INSERT INTO `pigcms_product_to_group` VALUES ('73', '27');
INSERT INTO `pigcms_product_to_group` VALUES ('74', '27');
INSERT INTO `pigcms_product_to_group` VALUES ('75', '28');
INSERT INTO `pigcms_product_to_group` VALUES ('76', '28');
INSERT INTO `pigcms_product_to_group` VALUES ('77', '28');
INSERT INTO `pigcms_product_to_group` VALUES ('78', '29');
INSERT INTO `pigcms_product_to_group` VALUES ('79', '29');
INSERT INTO `pigcms_product_to_group` VALUES ('80', '29');
INSERT INTO `pigcms_product_to_group` VALUES ('81', '30');
INSERT INTO `pigcms_product_to_group` VALUES ('82', '30');
INSERT INTO `pigcms_product_to_group` VALUES ('83', '30');
INSERT INTO `pigcms_product_to_group` VALUES ('84', '31');
INSERT INTO `pigcms_product_to_group` VALUES ('85', '31');
INSERT INTO `pigcms_product_to_group` VALUES ('86', '31');
INSERT INTO `pigcms_product_to_group` VALUES ('87', '32');
INSERT INTO `pigcms_product_to_group` VALUES ('88', '32');
INSERT INTO `pigcms_product_to_group` VALUES ('89', '32');
INSERT INTO `pigcms_product_to_group` VALUES ('90', '33');
INSERT INTO `pigcms_product_to_group` VALUES ('91', '33');
INSERT INTO `pigcms_product_to_group` VALUES ('92', '33');
INSERT INTO `pigcms_product_to_group` VALUES ('93', '34');
INSERT INTO `pigcms_product_to_group` VALUES ('94', '34');
INSERT INTO `pigcms_product_to_group` VALUES ('95', '34');
INSERT INTO `pigcms_product_to_group` VALUES ('96', '35');
INSERT INTO `pigcms_product_to_group` VALUES ('97', '35');
INSERT INTO `pigcms_product_to_group` VALUES ('98', '35');
INSERT INTO `pigcms_product_to_group` VALUES ('99', '36');
INSERT INTO `pigcms_product_to_group` VALUES ('100', '36');
INSERT INTO `pigcms_product_to_group` VALUES ('101', '36');
INSERT INTO `pigcms_product_to_group` VALUES ('102', '37');
INSERT INTO `pigcms_product_to_group` VALUES ('103', '37');
INSERT INTO `pigcms_product_to_group` VALUES ('104', '37');
INSERT INTO `pigcms_product_to_group` VALUES ('105', '38');
INSERT INTO `pigcms_product_to_group` VALUES ('106', '38');
INSERT INTO `pigcms_product_to_group` VALUES ('107', '38');
INSERT INTO `pigcms_product_to_group` VALUES ('108', '39');
INSERT INTO `pigcms_product_to_group` VALUES ('109', '39');
INSERT INTO `pigcms_product_to_group` VALUES ('110', '39');
INSERT INTO `pigcms_product_to_group` VALUES ('111', '40');
INSERT INTO `pigcms_product_to_group` VALUES ('112', '41');
INSERT INTO `pigcms_product_to_group` VALUES ('113', '42');
INSERT INTO `pigcms_product_to_group` VALUES ('114', '42');
INSERT INTO `pigcms_product_to_group` VALUES ('115', '42');
INSERT INTO `pigcms_product_to_group` VALUES ('116', '43');
INSERT INTO `pigcms_product_to_group` VALUES ('117', '43');
INSERT INTO `pigcms_product_to_group` VALUES ('118', '43');
INSERT INTO `pigcms_product_to_group` VALUES ('119', '44');
INSERT INTO `pigcms_product_to_group` VALUES ('120', '44');
INSERT INTO `pigcms_product_to_group` VALUES ('121', '44');
INSERT INTO `pigcms_product_to_group` VALUES ('122', '45');
INSERT INTO `pigcms_product_to_group` VALUES ('123', '45');
INSERT INTO `pigcms_product_to_group` VALUES ('124', '45');
INSERT INTO `pigcms_product_to_group` VALUES ('125', '46');
INSERT INTO `pigcms_product_to_group` VALUES ('126', '46');
INSERT INTO `pigcms_product_to_group` VALUES ('127', '46');
INSERT INTO `pigcms_product_to_group` VALUES ('128', '47');
INSERT INTO `pigcms_product_to_group` VALUES ('129', '47');
INSERT INTO `pigcms_product_to_group` VALUES ('130', '47');
INSERT INTO `pigcms_product_to_group` VALUES ('131', '48');
INSERT INTO `pigcms_product_to_group` VALUES ('132', '48');
INSERT INTO `pigcms_product_to_group` VALUES ('133', '48');
INSERT INTO `pigcms_product_to_group` VALUES ('134', '49');
INSERT INTO `pigcms_product_to_group` VALUES ('135', '49');
INSERT INTO `pigcms_product_to_group` VALUES ('136', '49');
INSERT INTO `pigcms_product_to_group` VALUES ('137', '50');
INSERT INTO `pigcms_product_to_group` VALUES ('138', '50');
INSERT INTO `pigcms_product_to_group` VALUES ('139', '50');

-- ----------------------------
-- Table structure for `pigcms_product_to_property`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_to_property`;
CREATE TABLE `pigcms_product_to_property` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `product_id` int(10) NOT NULL default '0' COMMENT '商品id',
  `pid` int(10) NOT NULL default '0' COMMENT '商品属性id',
  `order_by` int(5) NOT NULL default '0' COMMENT '排序',
  PRIMARY KEY  (`pigcms_id`),
  KEY `product_id` USING BTREE (`product_id`),
  KEY `pid` USING BTREE (`pid`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='商品关联属性id';

-- ----------------------------
-- Records of pigcms_product_to_property
-- ----------------------------
INSERT INTO `pigcms_product_to_property` VALUES ('30', '36', '111', '1', '1');
INSERT INTO `pigcms_product_to_property` VALUES ('31', '36', '111', '2', '2');

-- ----------------------------
-- Table structure for `pigcms_product_to_property_value`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_to_property_value`;
CREATE TABLE `pigcms_product_to_property_value` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `product_id` int(10) NOT NULL default '0' COMMENT '商品id',
  `pid` int(10) NOT NULL default '0' COMMENT '商品属性id',
  `vid` int(10) NOT NULL default '0' COMMENT '商品属性值id',
  `order_by` int(10) NOT NULL default '0' COMMENT '排序',
  PRIMARY KEY  (`pigcms_id`),
  KEY `product_id` USING BTREE (`product_id`),
  KEY `pid` USING BTREE (`pid`),
  KEY `vid` USING BTREE (`vid`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COMMENT='商品关联属性值';

-- ----------------------------
-- Records of pigcms_product_to_property_value
-- ----------------------------
INSERT INTO `pigcms_product_to_property_value` VALUES ('89', '36', '111', '1', '1401', '1');
INSERT INTO `pigcms_product_to_property_value` VALUES ('90', '36', '111', '2', '1402', '2');
INSERT INTO `pigcms_product_to_property_value` VALUES ('91', '36', '111', '1', '1403', '3');

-- ----------------------------
-- Table structure for `pigcms_recognition`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_recognition`;
CREATE TABLE `pigcms_recognition` (
  `id` int(11) NOT NULL auto_increment,
  `third_type` varchar(30) NOT NULL,
  `third_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  `ticket` varchar(200) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_recognition
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_reply_relation`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reply_relation`;
CREATE TABLE `pigcms_reply_relation` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '[0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]',
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_reply_relation
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_reply_tail`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reply_tail`;
CREATE TABLE `pigcms_reply_tail` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `is_open` tinyint(1) NOT NULL COMMENT '是否开启（0：关，1：开）',
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_reply_tail
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_reward`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reward`;
CREATE TABLE `pigcms_reward` (
  `id` int(11) NOT NULL auto_increment,
  `dateline` int(11) NOT NULL COMMENT '添加时间',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `name` varchar(255) NOT NULL COMMENT '活动名称',
  `start_time` int(11) NOT NULL default '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL default '0' COMMENT '结束时间',
  `type` tinyint(1) NOT NULL default '1' COMMENT '优惠方式，1：普通优惠，2：多级优惠，每级优惠不累积',
  `is_all` tinyint(1) NOT NULL default '1' COMMENT '是否所有商品都参与活动，1：全部商品，2：部分商品',
  `status` tinyint(1) NOT NULL default '1' COMMENT '是否有效，1：有效，0：无效，',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`,`store_id`,`start_time`,`end_time`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='满减/送表';

-- ----------------------------
-- Records of pigcms_reward
-- ----------------------------
INSERT INTO `pigcms_reward` VALUES ('1', '1442297839', '76', '37', '会员中心', '1441555200', '1443542400', '1', '1', '1');

-- ----------------------------
-- Table structure for `pigcms_reward_condition`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reward_condition`;
CREATE TABLE `pigcms_reward_condition` (
  `id` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL COMMENT '满减/送表ID',
  `money` int(11) NOT NULL COMMENT '钱数限制',
  `cash` int(11) NOT NULL default '0' COMMENT '减现金，0：表示没有此选项',
  `postage` int(11) NOT NULL default '0' COMMENT '免邮费，0：表示没有此选项',
  `score` int(11) NOT NULL default '0' COMMENT '送积分，0：表示没有此选项',
  `coupon` int(11) NOT NULL default '0' COMMENT '送优惠，0：表示没有此选项',
  `present` int(11) NOT NULL default '0' COMMENT '送赠品，0：表示没有此选项',
  PRIMARY KEY  (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='优惠条件表';

-- ----------------------------
-- Records of pigcms_reward_condition
-- ----------------------------
INSERT INTO `pigcms_reward_condition` VALUES ('1', '1', '100', '10', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `pigcms_reward_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reward_product`;
CREATE TABLE `pigcms_reward_product` (
  `id` int(11) NOT NULL auto_increment,
  `rid` int(11) NOT NULL COMMENT '满减/送表ID',
  `product_id` int(11) NOT NULL COMMENT '产品表ID',
  PRIMARY KEY  (`id`),
  KEY `rid` (`rid`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='满减/送产品列表';

-- ----------------------------
-- Records of pigcms_reward_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_rule`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_rule`;
CREATE TABLE `pigcms_rule` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '规则类型（0：手动添加的，1：系统默认的）',
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of pigcms_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_sale_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_sale_category`;
CREATE TABLE `pigcms_sale_category` (
  `cat_id` int(10) NOT NULL auto_increment COMMENT '类目id',
  `name` varchar(50) NOT NULL default '' COMMENT '类目名称',
  `desc` varchar(1000) NOT NULL default '' COMMENT '描述',
  `parent_id` int(10) NOT NULL default '0' COMMENT '父类id',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态',
  `order_by` int(10) NOT NULL default '0' COMMENT '排序，值小优越',
  `path` varchar(1000) NOT NULL,
  `level` tinyint(1) NOT NULL default '1' COMMENT '级别',
  `parent_status` tinyint(1) NOT NULL default '1' COMMENT '父类状态',
  `stores` int(11) unsigned NOT NULL default '0' COMMENT '店铺数量',
  `cat_pic` varchar(120) NOT NULL COMMENT '图片',
  PRIMARY KEY  (`cat_id`),
  KEY `parent_category_id` USING BTREE (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='店铺主营类目';

-- ----------------------------
-- Records of pigcms_sale_category
-- ----------------------------
INSERT INTO `pigcms_sale_category` VALUES ('1', '女装', '精美女装 新款上市', '0', '1', '0', '0,01', '1', '1', '702', '');
INSERT INTO `pigcms_sale_category` VALUES ('2', '男装', '帅气男装 新款上市', '0', '1', '0', '0,02', '1', '1', '179', '');
INSERT INTO `pigcms_sale_category` VALUES ('3', '食品酒水', '绿水食品 放心酒水', '0', '1', '0', '0,03', '1', '1', '467', '');
INSERT INTO `pigcms_sale_category` VALUES ('4', '个护美妆', '美丽从现在开始', '0', '1', '0', '0,04', '1', '1', '175', '');
INSERT INTO `pigcms_sale_category` VALUES ('5', '母婴玩具', '安全母婴 健康成长', '0', '1', '0', '0,05', '1', '1', '105', '');
INSERT INTO `pigcms_sale_category` VALUES ('6', '家居百货', '家居超市 齐全百货', '0', '1', '0', '0,06', '1', '1', '220', '');
INSERT INTO `pigcms_sale_category` VALUES ('7', '运动户外', '运动锻炼 户外旅行', '0', '1', '0', '0,07', '1', '1', '93', '');
INSERT INTO `pigcms_sale_category` VALUES ('8', '电脑数码', '全类3C 保证正品', '0', '1', '0', '0,08', '1', '1', '340', '');
INSERT INTO `pigcms_sale_category` VALUES ('9', '手表饰品', '打扮不一样的自己', '0', '1', '0', '0,09', '1', '1', '49', '');
INSERT INTO `pigcms_sale_category` VALUES ('10', '汽车用品', '汽车用品超市', '0', '1', '0', '0,10', '1', '1', '92', '');
INSERT INTO `pigcms_sale_category` VALUES ('13', '汽车装饰', '', '10', '1', '0', '0,10,13', '2', '1', '54', '');
INSERT INTO `pigcms_sale_category` VALUES ('14', '车载电器', '', '10', '1', '0', '0,10,14', '2', '1', '5', '');
INSERT INTO `pigcms_sale_category` VALUES ('15', '美容清洗', '', '10', '1', '0', '0,10,15', '2', '1', '3', '');
INSERT INTO `pigcms_sale_category` VALUES ('16', '维修保养', '', '10', '1', '0', '0,10,16', '2', '1', '8', '');
INSERT INTO `pigcms_sale_category` VALUES ('17', '安全自驾', '', '10', '1', '0', '0,10,17', '2', '1', '2', '');
INSERT INTO `pigcms_sale_category` VALUES ('18', '全品类', '', '10', '1', '0', '0,10,18', '2', '1', '20', '');
INSERT INTO `pigcms_sale_category` VALUES ('19', '其他', '其他分类', '0', '1', '0', '0,19', '1', '1', '377', '');
INSERT INTO `pigcms_sale_category` VALUES ('20', '虚拟卡券', '', '19', '1', '0', '0,19,20', '2', '1', '377', '');

-- ----------------------------
-- Table structure for `pigcms_search_hot`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_search_hot`;
CREATE TABLE `pigcms_search_hot` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `url` varchar(500) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `sort` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='热门搜索';

-- ----------------------------
-- Records of pigcms_search_hot
-- ----------------------------
INSERT INTO `pigcms_search_hot` VALUES ('1', '休闲零食', 'http://shop.hweiju.com/category/35', '1', '0', '1432971333');
INSERT INTO `pigcms_search_hot` VALUES ('2', '婚庆摄影', 'http://shop.hweiju.com/category/14', '1', '0', '1432971431');
INSERT INTO `pigcms_search_hot` VALUES ('3', '茶饮冲调', 'http://shop.hweiju.com/category/36', '0', '0', '1432971589');
INSERT INTO `pigcms_search_hot` VALUES ('4', '数码家电', 'http://shop.hweiju.com/category/7', '1', '0', '1432975713');
INSERT INTO `pigcms_search_hot` VALUES ('5', '美妆', 'http://shop.hweiju.com/category/4', '0', '0', '1432971701');
INSERT INTO `pigcms_search_hot` VALUES ('6', '男装', 'http://shop.hweiju.com/category/37', '0', '0', '1432971775');
INSERT INTO `pigcms_search_hot` VALUES ('7', '男鞋', 'http://shop.hweiju.com/category/33', '0', '0', '1432971892');

-- ----------------------------
-- Table structure for `pigcms_search_tmp`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_search_tmp`;
CREATE TABLE `pigcms_search_tmp` (
  `md5` varchar(32) NOT NULL COMMENT 'md5系统分类表id字条串，例md5(''1,2,3'')',
  `product_id_str` text COMMENT '满足条件的产品id字符串，每个产品id以逗号分割',
  `expire_time` int(11) NOT NULL default '0' COMMENT '过期时间',
  UNIQUE KEY `md5` (`md5`),
  KEY `expire_time` (`expire_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统分类筛选产品临时表';

-- ----------------------------
-- Records of pigcms_search_tmp
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_seller_fx_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_seller_fx_product`;
CREATE TABLE `pigcms_seller_fx_product` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `supplier_id` int(11) NOT NULL default '0' COMMENT '供货商店铺id',
  `seller_id` int(11) NOT NULL default '0' COMMENT '分销商店铺id',
  `source_product_id` int(11) NOT NULL default '0' COMMENT '源商品id',
  `product_id` int(11) NOT NULL default '0' COMMENT '商品id',
  PRIMARY KEY  (`pigcms_id`),
  KEY `supplier_id` USING BTREE (`supplier_id`),
  KEY `seller_id` USING BTREE (`seller_id`),
  KEY `product_id` USING BTREE (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销商分销商品';

-- ----------------------------
-- Records of pigcms_seller_fx_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_service`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_service`;
CREATE TABLE `pigcms_service` (
  `service_id` int(10) unsigned NOT NULL auto_increment COMMENT 'id',
  `nickname` char(50) NOT NULL COMMENT '客服昵称',
  `truename` char(50) NOT NULL COMMENT '真实姓名',
  `avatar` char(150) NOT NULL COMMENT '客服头像',
  `intro` text NOT NULL COMMENT '客服简介',
  `tel` char(20) NOT NULL COMMENT '电话',
  `qq` char(11) NOT NULL COMMENT 'qq',
  `email` char(45) NOT NULL COMMENT '联系邮箱',
  `openid` char(60) NOT NULL COMMENT '绑定openid',
  `add_time` char(15) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL COMMENT '客服状态',
  `store_id` int(11) NOT NULL COMMENT '所属店铺',
  PRIMARY KEY  (`service_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺客服列表';

-- ----------------------------
-- Records of pigcms_service
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_slider`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_slider`;
CREATE TABLE `pigcms_slider` (
  `id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  `last_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='导航表';

-- ----------------------------
-- Records of pigcms_slider
-- ----------------------------
INSERT INTO `pigcms_slider` VALUES ('1', '2', '餐具', 'http://shop.hweiju.com/wap/category.php?keyword=%E9%9B%B6%E9%A3%9F&id=14', 'slider/2015/06/5570f82e5d4ea.png', '0', '1433727140', '1');
INSERT INTO `pigcms_slider` VALUES ('2', '2', '居家', 'http://shop.hweiju.comm/wap/category.php?keyword=%E5%AE%B6%E7%BA%BA&id=40', 'slider/2015/06/5570f85fc0844.png', '0', '1433727124', '1');
INSERT INTO `pigcms_slider` VALUES ('3', '2', '娱乐', 'http://shop.hweiju.com/wap/category.php?keyword=%E9%AA%91%E8%A1%8C%E8%BF%90%E5%8A%A8&id=56', 'slider/2015/06/5570f87bb0b60.png', '0', '1433727106', '1');
INSERT INTO `pigcms_slider` VALUES ('4', '2', '户外', 'http://shop.hweiju.com/wap/category.php?keyword=%E8%BF%90%E5%8A%A8%E9%9E%8B%E5%8C%85&id=50', 'slider/2015/06/5570f8b047c7f.png', '0', '1433727067', '1');
INSERT INTO `pigcms_slider` VALUES ('5', '1', '运动鞋包', 'http://shop.hweiju.com/category/50', '', '1', '1433395845', '1');
INSERT INTO `pigcms_slider` VALUES ('6', '1', '食品酒水', 'http://shop.hweiju.com/category/11', '', '2', '1433572631', '1');
INSERT INTO `pigcms_slider` VALUES ('7', '1', '热卖男鞋', 'http://shop.hweiju.com/category/6', '', '3', '1433395792', '1');
INSERT INTO `pigcms_slider` VALUES ('8', '1', '宝宝用品', 'http://shop.hweiju.com/category/34', '', '0', '1433495147', '1');
INSERT INTO `pigcms_slider` VALUES ('9', '1', '沐浴洗护', 'http://shop.hweiju.com/category/29', '', '0', '1433495177', '1');
INSERT INTO `pigcms_slider` VALUES ('10', '1', '居家百货', 'http://shop.hweiju.com/category/39', '', '0', '1433495207', '1');
INSERT INTO `pigcms_slider` VALUES ('11', '1', '电脑数码', 'http://shop.hweiju.com/category/64', '', '0', '1433495234', '1');
INSERT INTO `pigcms_slider` VALUES ('12', '1', '手表饰品', 'http://shop.hweiju.com/category/75', '', '0', '1433495279', '1');
INSERT INTO `pigcms_slider` VALUES ('13', '1', '汽车用品', 'http://shop.hweiju.com/category/79', '', '0', '1433495663', '1');
INSERT INTO `pigcms_slider` VALUES ('14', '1', '服装配件', 'http://shop.hweiju.com/category/17', '', '0', '1433495697', '1');

-- ----------------------------
-- Table structure for `pigcms_slider_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_slider_category`;
CREATE TABLE `pigcms_slider_category` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_name` char(20) NOT NULL,
  `cat_key` char(20) NOT NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='导航归类表';

-- ----------------------------
-- Records of pigcms_slider_category
-- ----------------------------
INSERT INTO `pigcms_slider_category` VALUES ('1', 'PC端导航', 'pc_nav');
INSERT INTO `pigcms_slider_category` VALUES ('2', '手机端-首页导航（4个）', 'wap_index_nav');

-- ----------------------------
-- Table structure for `pigcms_source_material`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_source_material`;
CREATE TABLE `pigcms_source_material` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `it_ids` varchar(50) NOT NULL COMMENT '图文表id集合',
  `store_id` int(10) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '图文类型（0：单图文，1：多图文）',
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_source_material
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store`;
CREATE TABLE `pigcms_store` (
  `store_id` int(10) NOT NULL auto_increment COMMENT '店铺id',
  `uid` int(10) NOT NULL default '0' COMMENT '会员id',
  `name` varchar(50) default '' COMMENT '店铺名称',
  `edit_name_count` tinyint(1) unsigned default '0' COMMENT '店铺名修改次数',
  `logo` text COMMENT '店铺logo',
  `sale_category_fid` int(11) default NULL,
  `sale_category_id` int(10) default '0' COMMENT '主营类目',
  `linkman` varchar(30) default '' COMMENT '联系人',
  `tel` varchar(20) default '' COMMENT '电话',
  `intro` varchar(1000) default '' COMMENT '店铺简介',
  `approve` char(1) default '0' COMMENT '认证 0未认证 1已证',
  `status` char(1) default '1' COMMENT '状态 0禁用 1启用',
  `date_added` varchar(20) default '' COMMENT '店铺入驻时间',
  `service_tel` varchar(20) default '' COMMENT '客服电话',
  `service_qq` varchar(15) default '' COMMENT '客服qq',
  `service_weixin` varchar(60) default '' COMMENT '客服微信',
  `bind_weixin` tinyint(1) default '0' COMMENT '绑定微信 0未绑定 1已绑定',
  `weixin_name` varchar(60) default '' COMMENT '公众号名称',
  `weixin_original_id` varchar(20) default '' COMMENT '微信原始ID',
  `weixin_id` varchar(20) default '' COMMENT '微信ID',
  `qq` varchar(15) default '' COMMENT 'qq',
  `open_weixin` char(1) default '0' COMMENT '绑定微信',
  `buyer_selffetch` char(1) default '0' COMMENT '买家上门自提',
  `pay_agent` char(1) default '0' COMMENT '代付',
  `open_nav` tinyint(1) default '0' COMMENT '开启店铺导航',
  `nav_style_id` tinyint(1) default '1' COMMENT '店铺导航样式',
  `use_nav_pages` varchar(20) default '1' COMMENT '使用导航菜单的页面 1店铺主页 2会员主页 3微页面及分类 4商品分组 5商品搜索',
  `open_ad` tinyint(1) default '0' COMMENT '开启广告',
  `has_ad` tinyint(1) default '0' COMMENT '是否有店铺广告',
  `ad_position` tinyint(1) default '0' COMMENT '广告位置 0页面头部 1页面底部',
  `use_ad_pages` varchar(20) default '' COMMENT '使用广告的页面 1微页面 2微页面分类 3商品 4商品分组 5店铺主页 6会员主页',
  `date_edited` varchar(20) default '' COMMENT '更新时间',
  `income` decimal(10,2) default '0.00' COMMENT '店铺收入',
  `balance` decimal(10,2) default '0.00' COMMENT '未提现余额',
  `unbalance` decimal(10,2) default '0.00' COMMENT '不可用余额',
  `withdrawal_amount` decimal(10,2) default '0.00' COMMENT '已提现金额',
  `withdrawal_type` tinyint(1) default '0' COMMENT '提现方式 0对私 1对公',
  `bank_id` int(5) default '0' COMMENT '开户银行',
  `bank_card` varchar(30) default '' COMMENT '银行卡号',
  `bank_card_user` varchar(30) default '' COMMENT '开卡人姓名',
  `opening_bank` varchar(30) default '' COMMENT '开户行',
  `last_edit_time` varchar(20) default '' COMMENT '最后修改时间',
  `physical_count` smallint(6) default NULL,
  `drp_supplier_id` int(11) unsigned default '0' COMMENT '分销店铺供货商id',
  `drp_level` tinyint(3) default '0' COMMENT '分销级别',
  `collect` int(11) unsigned default NULL COMMENT '店铺收藏数',
  `wxpay` tinyint(1) default '0',
  `open_drp_approve` tinyint(1) unsigned default '0' COMMENT '是否开启分销商审核',
  `drp_approve` tinyint(1) unsigned default '1' COMMENT '分销商审核状态',
  `drp_profit` decimal(10,2) unsigned default '0.00' COMMENT '分销利润',
  `drp_profit_withdrawal` decimal(10,2) unsigned default '0.00' COMMENT '分销利润提现',
  `attention_num` int(10) unsigned default '0' COMMENT '关注数',
  `pigcmsToken` char(100) default NULL,
  `template_cat_id` int(11) default '0' COMMENT '店铺模板ID',
  `template_id` int(10) unsigned default '0' COMMENT '模板ID',
  `source_site_url` varchar(255) default NULL COMMENT '来源URL',
  `payment_url` varchar(255) default NULL COMMENT '支付地址',
  `notify_url` varchar(255) default NULL COMMENT '支付结果通知地址',
  `oauth_url` varchar(255) default NULL COMMENT '验证地址',
  `token` varchar(255) default NULL COMMENT 'token',
  `open_logistics` tinyint(1) default '0',
  `offline_payment` tinyint(1) default '0',
  `open_friend` tinyint(1) default '0',
  `zz` text,
  `open_service` text,
  PRIMARY KEY  (`store_id`),
  KEY `uid` USING BTREE (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='店铺';

-- ----------------------------
-- Records of pigcms_store
-- ----------------------------
INSERT INTO `pigcms_store` VALUES ('36', '75', '微聚商城', '0', '', '2', '0', '曾勇', '13309160049', '', '0', '1', '1440135175', '123123', '231123', '123123', '1', '', '', '', '6421896', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '1', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0', null, '0', '0', 'http://wx.hweiju.com', 'http://wx.hweiju.com/index.php?g=Wap&m=Micrstore&a=pay', 'http://wx.hweiju.com/index.php?g=Wap&m=Micrstore&a=notify', 'http://wx.hweiju.com/index.php?g=Wap&m=Micrstore&a=login', 'ixyvte1440042048', '1', '0', '0', null, null);
INSERT INTO `pigcms_store` VALUES ('37', '76', '舞台上', '0', 'images/000/000/037/201510/561b6f40af73c.jpg', '1', '0', '隔壁老王', '13800138000', '', '0', '1', '1442224245', '', '', '', '0', '', '', '', '', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '3', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0', null, '0', '0', null, null, null, null, null, '0', '0', '0', '4444', '0');
INSERT INTO `pigcms_store` VALUES ('38', '77', '爱读书法撒旦99', '0', '', '1', '0', '阿士大夫撒地方', '13800138000', '', '0', '1', '1444440434', '', '', '', '0', '', '', '', '12231231', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0', null, '0', '0', null, null, null, null, null, '0', '0', '0', null, null);

-- ----------------------------
-- Table structure for `pigcms_store_analytics`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_analytics`;
CREATE TABLE `pigcms_store_analytics` (
  `pigcms_id` bigint(20) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL default '0' COMMENT '店铺id',
  `module` varchar(30) NOT NULL default '' COMMENT '模块名',
  `title` varchar(300) NOT NULL default '' COMMENT '页面标题',
  `page_id` int(10) NOT NULL default '0' COMMENT '页面id',
  `visited_time` int(11) NOT NULL default '0' COMMENT '访问时间',
  `visited_ip` bigint(20) NOT NULL default '0' COMMENT '访问ip',
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`,`visited_time`,`visited_ip`)
) ENGINE=MyISAM AUTO_INCREMENT=775 DEFAULT CHARSET=utf8 COMMENT='店铺访问统计';

-- ----------------------------
-- Records of pigcms_store_analytics
-- ----------------------------
INSERT INTO `pigcms_store_analytics` VALUES ('527', '27', 'home', '这是您的第一篇微杂志', '27', '1439989967', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('528', '27', 'home', '远亮商城', '27', '1439990411', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('529', '29', 'home', '这是您的第一篇微杂志', '29', '1439990926', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('530', '29', 'pay', '订单支付', '14', '1439990935', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('531', '29', 'home', '这是您的第一篇微杂志', '29', '1439990955', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('532', '29', 'goods', '测试', '59', '1439990990', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('533', '27', 'home', '远亮商城', '27', '1439991040', '3029977423');
INSERT INTO `pigcms_store_analytics` VALUES ('534', '29', 'home', '这是您的第一篇微杂志', '29', '1439991138', '2006160067');
INSERT INTO `pigcms_store_analytics` VALUES ('535', '29', 'home', '这是您的第一篇微杂志', '29', '1439991223', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('536', '29', 'goods', '测试', '59', '1439991226', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('537', '29', 'home', '这是您的第一篇微杂志', '29', '1439991526', '1709318623');
INSERT INTO `pigcms_store_analytics` VALUES ('538', '29', 'home', '这是您的第一篇微杂志', '29', '1439991575', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('539', '29', 'home', '这是您的第一篇微杂志', '29', '1439991582', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('540', '29', 'ucenter', '会员主页', '29', '1439991586', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('541', '29', 'ucenter', '会员主页', '29', '1439991591', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('542', '29', 'home', '这是您的第一篇微杂志', '29', '1439991595', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('543', '29', 'pay', '订单支付', '15', '1439991604', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('544', '29', 'home', '这是您的第一篇微杂志', '29', '1439991604', '454626635');
INSERT INTO `pigcms_store_analytics` VALUES ('545', '29', 'home', '这是您的第一篇微杂志', '29', '1439991724', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('546', '29', 'goods', '测试', '59', '1439991728', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('547', '29', 'home', '这是您的第一篇微杂志', '29', '1439991761', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('548', '29', 'pay', '订单支付', '16', '1439991769', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('549', '29', 'home', '这是您的第一篇微杂志', '29', '1439991963', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('550', '29', 'goods', '测试', '59', '1439991968', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('551', '29', 'pay', '订单支付', '17', '1439991974', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('552', '29', 'home', '这是您的第一篇微杂志', '29', '1439992015', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('553', '29', 'goods', '测试', '59', '1439992019', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('554', '29', 'pay', '订单支付', '18', '1439992030', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('555', '29', 'home', '这是您的第一篇微杂志', '29', '1439992282', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('556', '29', 'goods', '测试', '59', '1439992285', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('557', '29', 'home', '这是您的第一篇微杂志', '29', '1439992306', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('558', '29', 'home', '这是您的第一篇微杂志', '29', '1439992369', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('559', '29', 'ucenter', '会员主页', '29', '1439992375', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('560', '29', 'home', '这是您的第一篇微杂志', '29', '1439992383', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('561', '29', 'ucenter', '会员主页', '29', '1439992394', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('562', '29', 'ucenter', '会员主页', '29', '1439992399', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('563', '29', 'ucenter', '会员主页', '29', '1439992407', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('564', '29', 'ucenter', '会员主页', '29', '1439992412', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('565', '29', 'ucenter', '会员主页', '29', '1439992422', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('566', '29', 'home', '这是您的第一篇微杂志', '29', '1439992444', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('567', '29', 'goods', '测试', '59', '1439992564', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('568', '29', 'ucenter', '会员主页', '29', '1439992574', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('569', '29', 'ucenter', '会员主页', '29', '1439992576', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('570', '29', 'pay', '订单支付', '17', '1439992583', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('571', '27', 'home', '远亮商城', '27', '1439992614', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('572', '27', 'home', '远亮商城', '27', '1439992688', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('573', '28', 'home', '这是您的第一篇微杂志', '28', '1439992693', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('574', '28', 'home', '这是您的第一篇微杂志', '28', '1439992707', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('575', '29', 'home', '这是您的第一篇微杂志', '29', '1439992725', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('576', '29', 'goods', '测试', '59', '1439992729', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('577', '29', 'ucenter', '会员主页', '29', '1439992737', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('578', '29', 'ucenter', '会员主页', '29', '1439992770', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('579', '29', 'home', '这是您的第一篇微杂志', '29', '1439992860', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('580', '29', 'goods', '测试', '59', '1439992866', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('581', '29', 'home', '这是您的第一篇微杂志', '29', '1439992927', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('582', '29', 'goods', '测试', '59', '1439992931', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('583', '29', 'home', '这是您的第一篇微杂志', '29', '1439992939', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('584', '29', 'goods', '测试', '59', '1439992943', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('585', '29', 'goods', '测试', '59', '1439993274', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('586', '29', 'ucenter', '会员主页', '29', '1439993286', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('587', '29', 'home', '这是您的第一篇微杂志', '29', '1439993361', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('588', '29', 'home', '这是您的第一篇微杂志', '29', '1439993362', '3029977556');
INSERT INTO `pigcms_store_analytics` VALUES ('589', '29', 'goods', '测试', '59', '1439993364', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('590', '29', 'pay', '订单支付', '19', '1439993370', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('591', '29', 'goods', '测试', '59', '1439993379', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('592', '29', 'goods', '测试', '59', '1439993389', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('593', '29', 'home', '这是您的第一篇微杂志', '29', '1439993445', '3062675541');
INSERT INTO `pigcms_store_analytics` VALUES ('594', '29', 'goods', '测试', '59', '1439993455', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('595', '29', 'pay', '订单支付', '20', '1439993455', '3062675541');
INSERT INTO `pigcms_store_analytics` VALUES ('596', '29', 'home', '这是您的第一篇微杂志', '29', '1439993457', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('597', '29', 'home', '这是您的第一篇微杂志', '29', '1439993463', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('598', '29', 'goods', '测试', '59', '1439993467', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('599', '29', 'goods', '测试', '59', '1439993468', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('600', '29', 'home', '这是您的第一篇微杂志', '29', '1439993482', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('601', '29', 'home', '这是您的第一篇微杂志', '29', '1439993518', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('602', '29', 'goods', '测试', '59', '1439993523', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('603', '29', 'home', '这是您的第一篇微杂志', '29', '1439993531', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('604', '29', 'goods', '测试', '59', '1439993534', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('605', '29', 'goods', '测试', '59', '1439993542', '1920253163');
INSERT INTO `pigcms_store_analytics` VALUES ('606', '29', 'home', '这是您的第一篇微杂志', '29', '1439993552', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('607', '29', 'goods', '测试', '59', '1439993554', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('608', '29', 'home', '这是您的第一篇微杂志', '29', '1439993565', '720577822');
INSERT INTO `pigcms_store_analytics` VALUES ('609', '29', 'pay', '订单支付', '21', '1439993566', '236004754');
INSERT INTO `pigcms_store_analytics` VALUES ('610', '29', 'pay', '订单支付', '22', '1439993580', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('611', '29', 'home', '这是您的第一篇微杂志', '29', '1439993619', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('612', '29', 'goods', '测试', '59', '1439993623', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('613', '29', 'home', '这是您的第一篇微杂志', '29', '1439993634', '3062675541');
INSERT INTO `pigcms_store_analytics` VALUES ('614', '29', 'home', '这是您的第一篇微杂志', '29', '1439993679', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('615', '29', 'home', '这是您的第一篇微杂志', '29', '1439993680', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('616', '29', 'goods', '测试', '59', '1439993682', '236004753');
INSERT INTO `pigcms_store_analytics` VALUES ('617', '29', 'home', '这是您的第一篇微杂志', '29', '1439993689', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('618', '29', 'ucenter', '会员主页', '29', '1439993693', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('619', '29', 'home', '这是您的第一篇微杂志', '29', '1439993702', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('620', '31', 'home', '这是您的第一篇微杂志', '31', '1439993841', '3029978659');
INSERT INTO `pigcms_store_analytics` VALUES ('621', '29', 'home', '这是您的第一篇微杂志', '29', '1439993913', '1709318625');
INSERT INTO `pigcms_store_analytics` VALUES ('622', '29', 'goods', '测试', '59', '1439994911', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('623', '29', 'goods', '测试', '59', '1439994916', '3074176005');
INSERT INTO `pigcms_store_analytics` VALUES ('624', '34', 'home', '这是您的第一篇微杂志', '34', '1440125747', '3395704081');
INSERT INTO `pigcms_store_analytics` VALUES ('625', '34', 'home', '这是您的第一篇微杂志', '34', '1440125753', '3395704081');
INSERT INTO `pigcms_store_analytics` VALUES ('626', '37', 'goods', '阿萨德发的', '112', '1442224301', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('627', '37', 'goods', '阿萨德发的', '112', '1442224364', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('628', '37', 'goods', '阿萨德发的', '112', '1442224381', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('629', '37', 'home', '这是您的第一篇微杂志', '37', '1442392623', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('630', '37', 'goods', '阿萨德发的', '112', '1442454592', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('631', '37', 'ucenter', '会员主页', '37', '1442454640', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('632', '37', 'ucenter', '会员主页', '37', '1442454892', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('633', '37', 'ucenter', '会员主页', '37', '1442454899', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('634', '37', 'ucenter', '会员主页', '37', '1442455234', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('635', '37', 'ucenter', '会员主页', '37', '1442457230', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('636', '37', 'ucenter', '会员主页', '37', '1442457319', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('637', '37', 'ucenter', '会员主页', '37', '1442457647', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('638', '37', 'home', '这是您的第一篇微杂志', '37', '1442457651', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('639', '37', 'ucenter', '会员主页', '37', '1442457655', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('640', '37', 'ucenter', '会员主页', '37', '1442458022', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('641', '37', 'ucenter', '会员主页', '37', '1442458119', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('642', '37', 'ucenter', '会员主页', '37', '1442458291', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('643', '37', 'ucenter', '会员主页', '37', '1442458300', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('644', '37', 'ucenter', '会员主页', '37', '1442458987', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('645', '37', 'ucenter', '会员主页', '37', '1442459166', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('646', '37', 'ucenter', '会员主页', '37', '1442459621', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('647', '37', 'ucenter', '会员主页', '37', '1442459747', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('648', '37', 'ucenter', '会员主页', '37', '1442459971', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('649', '37', 'ucenter', '会员主页', '37', '1442460021', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('650', '37', 'ucenter', '会员主页', '37', '1442460121', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('651', '37', 'ucenter', '会员主页', '37', '1442460129', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('652', '37', 'ucenter', '会员主页', '37', '1442460156', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('653', '37', 'ucenter', '会员主页', '37', '1442460189', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('654', '37', 'ucenter', '会员主页', '37', '1442460198', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('655', '37', 'ucenter', '会员主页', '37', '1442460204', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('656', '37', 'ucenter', '会员主页', '37', '1442460216', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('657', '37', 'ucenter', '会员主页', '37', '1442460245', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('658', '37', 'ucenter', '会员主页', '37', '1442460249', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('659', '37', 'ucenter', '会员主页', '37', '1442460256', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('660', '37', 'ucenter', '会员主页', '37', '1442460282', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('661', '37', 'ucenter', '会员主页', '37', '1442460283', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('662', '37', 'ucenter', '会员主页', '37', '1442460289', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('663', '37', 'ucenter', '会员主页', '37', '1442460290', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('664', '37', 'ucenter', '会员主页', '37', '1442460292', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('665', '37', 'ucenter', '会员主页', '37', '1442460295', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('666', '37', 'ucenter', '会员主页', '37', '1442460606', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('667', '37', 'ucenter', '会员主页', '37', '1442460759', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('668', '37', 'ucenter', '会员主页', '37', '1442460807', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('669', '37', 'ucenter', '会员主页', '37', '1442460826', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('670', '37', 'ucenter', '会员主页', '37', '1442460846', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('671', '37', 'ucenter', '会员主页', '37', '1442460998', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('672', '37', 'ucenter', '会员主页', '37', '1442461026', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('673', '37', 'ucenter', '会员主页', '37', '1442461090', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('674', '37', 'ucenter', '会员主页', '37', '1442461137', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('675', '37', 'ucenter', '会员主页', '37', '1442461149', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('676', '37', 'ucenter', '会员主页', '37', '1442461475', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('677', '37', 'ucenter', '会员主页', '37', '1442461489', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('678', '37', 'ucenter', '会员主页', '37', '1442461499', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('679', '37', 'ucenter', '会员主页', '37', '1442461660', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('680', '37', 'ucenter', '会员主页', '37', '1442461679', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('681', '37', 'ucenter', '会员主页', '37', '1442461873', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('682', '37', 'ucenter', '会员主页', '37', '1442461932', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('683', '37', 'ucenter', '会员主页', '37', '1442461978', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('684', '37', 'ucenter', '会员主页', '37', '1442461980', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('685', '37', 'ucenter', '会员主页', '37', '1442462003', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('686', '37', 'ucenter', '会员主页', '37', '1442462006', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('687', '37', 'ucenter', '会员主页', '37', '1442462010', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('688', '37', 'ucenter', '会员主页', '37', '1442462756', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('689', '37', 'ucenter', '会员主页', '37', '1442463012', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('690', '37', 'ucenter', '会员主页', '37', '1442463015', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('691', '37', 'ucenter', '会员主页', '37', '1442463021', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('692', '37', 'goods', '阿萨德发的', '112', '1442463343', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('693', '37', 'goods', '阿萨德发的', '112', '1442463372', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('694', '37', 'ucenter', '会员主页', '37', '1442463379', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('695', '37', 'ucenter', '会员主页', '37', '1442463473', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('696', '37', 'ucenter', '会员主页', '37', '1442463520', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('697', '37', 'ucenter', '会员主页', '37', '1442467081', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('698', '37', 'ucenter', '会员主页', '37', '1442467083', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('699', '37', 'ucenter', '会员主页', '37', '1442470868', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('700', '37', 'goods', '阿萨德发的', '112', '1442545152', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('701', '37', 'ucenter', '会员主页', '37', '1442545503', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('702', '37', 'ucenter', '会员主页', '37', '1442545725', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('703', '37', 'ucenter', '会员主页', '37', '1442545737', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('704', '37', 'goods', '阿萨德发的', '112', '1442546310', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('705', '37', 'ucenter', '会员主页', '37', '1442546313', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('706', '37', 'ucenter', '会员主页', '37', '1442546317', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('707', '37', 'ucenter', '会员主页', '37', '1442546321', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('708', '37', 'ucenter', '会员主页', '37', '1442546411', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('709', '37', 'ucenter', '会员主页', '37', '1442546421', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('710', '37', 'ucenter', '会员主页', '37', '1442546753', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('711', '37', 'ucenter', '会员主页', '37', '1442546818', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('712', '37', 'ucenter', '会员主页', '37', '1442546820', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('713', '37', 'ucenter', '会员主页', '37', '1442546824', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('714', '37', 'ucenter', '会员主页', '37', '1442546832', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('715', '37', 'ucenter', '会员主页', '37', '1442546836', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('716', '37', 'ucenter', '会员主页', '37', '1442548976', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('717', '37', 'ucenter', '会员主页', '37', '1442549032', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('718', '37', 'ucenter', '会员主页', '37', '1442549045', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('719', '37', 'ucenter', '会员主页', '37', '1442549048', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('720', '37', 'ucenter', '会员主页', '37', '1442549062', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('721', '37', 'ucenter', '会员主页', '37', '1442549077', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('722', '37', 'ucenter', '会员主页', '37', '1442549449', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('723', '37', 'ucenter', '会员主页', '37', '1442549547', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('724', '37', 'ucenter', '会员主页', '37', '1442549583', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('725', '37', 'ucenter', '会员主页', '37', '1442549597', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('726', '37', 'ucenter', '会员主页', '37', '1442549642', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('727', '37', 'ucenter', '会员主页', '37', '1442549661', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('728', '37', 'ucenter', '会员主页', '37', '1442549672', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('729', '37', 'ucenter', '会员主页', '37', '1442549861', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('730', '37', 'ucenter', '会员主页', '37', '1442549862', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('731', '37', 'ucenter', '会员主页', '37', '1442549864', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('732', '37', 'ucenter', '会员主页', '37', '1442549871', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('733', '37', 'ucenter', '会员主页', '37', '1442549874', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('734', '37', 'ucenter', '会员主页', '37', '1442556703', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('735', '37', 'ucenter', '会员主页', '37', '1442556970', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('736', '37', 'ucenter', '会员主页', '37', '1442557055', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('737', '37', 'ucenter', '会员主页', '37', '1442557057', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('738', '37', 'ucenter', '会员主页', '37', '1442557061', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('739', '37', 'ucenter', '会员主页', '37', '1442557409', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('740', '37', 'ucenter', '会员主页', '37', '1442557432', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('741', '37', 'ucenter', '会员主页', '37', '1442557500', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('742', '37', 'ucenter', '会员主页', '37', '1442557519', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('743', '37', 'ucenter', '会员主页', '37', '1442557542', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('744', '37', 'ucenter', '会员主页', '37', '1442557607', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('745', '37', 'ucenter', '会员主页', '37', '1442557615', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('746', '37', 'ucenter', '会员主页', '37', '1442557630', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('747', '37', 'ucenter', '会员主页', '37', '1442557636', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('748', '37', 'ucenter', '会员主页', '37', '1442557725', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('749', '37', 'ucenter', '会员主页', '37', '1442558972', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('750', '37', 'ucenter', '会员主页', '37', '1442558980', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('751', '37', 'ucenter', '会员主页', '37', '1442560707', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('752', '37', 'ucenter', '会员主页', '37', '1442561031', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('753', '0', 'ucenter', '会员主页', '0', '1442561392', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('754', '0', 'ucenter', '会员主页', '0', '1442561537', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('755', '0', 'ucenter', '会员主页', '0', '1442561592', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('756', '0', 'ucenter', '会员主页', '0', '1442561610', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('757', '0', 'ucenter', '会员主页', '0', '1442561631', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('758', '0', 'ucenter', '会员主页', '0', '1442561668', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('759', '0', 'ucenter', '会员主页', '0', '1442561802', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('760', '0', 'ucenter', '会员主页', '0', '1442561842', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('761', '37', 'ucenter', '会员主页', '37', '1442562096', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('762', '0', 'ucenter', '会员主页', '0', '1442562323', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('763', '0', 'ucenter', '会员主页', '0', '1442562378', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('764', '0', 'ucenter', '会员主页', '0', '1442562481', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('765', '0', 'ucenter', '会员主页', '0', '1442562495', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('766', '37', 'ucenter', '会员主页', '37', '1442562507', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('767', '37', 'ucenter', '会员主页', '37', '1442562508', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('768', '37', 'ucenter', '会员主页', '37', '1442562512', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('769', '37', 'ucenter', '会员主页', '37', '1442562514', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('770', '37', 'goods', '阿萨德发的', '112', '1442562519', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('771', '37', 'ucenter', '会员主页', '37', '1442562526', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('772', '0', 'ucenter', '会员主页', '0', '1442562557', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('773', '37', 'ucenter', '会员主页', '37', '1442562557', '2130706433');
INSERT INTO `pigcms_store_analytics` VALUES ('774', '37', 'goods', '阿萨德发的', '112', '1442569155', '2130706433');

-- ----------------------------
-- Table structure for `pigcms_store_brand`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_brand`;
CREATE TABLE `pigcms_store_brand` (
  `brand_id` int(11) NOT NULL auto_increment,
  `name` varchar(250) NOT NULL COMMENT '商铺品牌名',
  `pic` varchar(200) NOT NULL COMMENT '品牌图片',
  `order_by` int(100) NOT NULL default '0' COMMENT '排序，越小越前面',
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `type_id` int(11) NOT NULL COMMENT '所属品牌类别id',
  `status` tinyint(1) NOT NULL default '1' COMMENT '是否启用（1：启用；  0：禁用）',
  PRIMARY KEY  (`brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='商铺品牌表';

-- ----------------------------
-- Records of pigcms_store_brand
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_brand_type`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_brand_type`;
CREATE TABLE `pigcms_store_brand_type` (
  `type_id` int(11) NOT NULL auto_increment,
  `type_name` varchar(100) NOT NULL COMMENT '商铺品牌类别名',
  `order_by` int(10) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL default '1' COMMENT '品牌状态（1：开启，0：禁用）',
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='商铺品牌类别表';

-- ----------------------------
-- Records of pigcms_store_brand_type
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_contact`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_contact`;
CREATE TABLE `pigcms_store_contact` (
  `store_id` int(11) NOT NULL,
  `phone1` varchar(6) NOT NULL,
  `phone2` varchar(15) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `county` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `long` decimal(10,6) NOT NULL,
  `lat` decimal(10,6) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY  (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_store_contact
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_nav`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_nav`;
CREATE TABLE `pigcms_store_nav` (
  `store_nav_id` int(10) NOT NULL auto_increment COMMENT '店铺导航id',
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `style` tinyint(1) NOT NULL default '1' COMMENT '导航样式',
  `bgcolor` char(7) NOT NULL default '' COMMENT '背景颜色',
  `data` text NOT NULL COMMENT '店铺导航数据',
  `date_added` varchar(20) NOT NULL,
  PRIMARY KEY  (`store_nav_id`),
  KEY `store_id` USING BTREE (`store_id`),
  KEY `store_nav_template_id` USING BTREE (`style`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='店铺导航';

-- ----------------------------
-- Records of pigcms_store_nav
-- ----------------------------
INSERT INTO `pigcms_store_nav` VALUES ('6', '37', '3', '#2b2d30', 'a:4:{i:0;a:0:{}i:1;a:2:{s:6:\"image1\";s:45:\"./template/user/default/images/shopnav_01.png\";s:6:\"image2\";s:48:\"./template/user/default/images/shopnav_01_on.png\";}i:2;a:2:{s:6:\"image1\";s:45:\"./template/user/default/images/shopnav_02.png\";s:6:\"image2\";s:48:\"./template/user/default/images/shopnav_02_on.png\";}i:3;a:2:{s:6:\"image1\";s:45:\"./template/user/default/images/shopnav_03.png\";s:6:\"image2\";s:48:\"./template/user/default/images/shopnav_03_on.png\";}}', '1442474392');

-- ----------------------------
-- Table structure for `pigcms_store_pay_agent`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_pay_agent`;
CREATE TABLE `pigcms_store_pay_agent` (
  `agent_id` int(10) NOT NULL auto_increment,
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `nickname` varchar(30) NOT NULL default '' COMMENT '昵称',
  `type` char(1) NOT NULL default '0' COMMENT '类型 0 发起人 1 代付人',
  `content` varchar(200) NOT NULL default '' COMMENT '内容',
  PRIMARY KEY  (`agent_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='找人代付';

-- ----------------------------
-- Records of pigcms_store_pay_agent
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_physical`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_physical`;
CREATE TABLE `pigcms_store_physical` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `phone1` varchar(6) NOT NULL,
  `phone2` varchar(15) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `county` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `long` decimal(10,6) NOT NULL,
  `lat` decimal(10,6) NOT NULL,
  `last_time` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `images` varchar(500) NOT NULL,
  `business_hours` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `linkurl` text,
  `sort` int(10) default NULL,
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_store_physical
-- ----------------------------
INSERT INTO `pigcms_store_physical` VALUES ('3', '36', '010', '13213123', '110000', '110100', '110101', '阿萨德发士大夫阿萨德发', '116.352772', '39.896788', '1442220308', '精品蔬菜', 'images/000/000/036/201509/55f66bf125f2a.jpg', '9:00-17:00', '阿法士大夫', null, null);
INSERT INTO `pigcms_store_physical` VALUES ('4', '37', '010', '88888839', '110000', '110100', '110101', '啊撒的发反反复复反复烦烦烦', '116.437190', '39.935091', '1444637351', '北京朝阳大忠臣店', 'images/000/000/037/201509/55fa196c81d52.jpg,images/000/000/037/201509/55f92c900830f.jpg', '8:00-17:00', '大厦法定', 'https://www.baidu.com/', '1');
INSERT INTO `pigcms_store_physical` VALUES ('5', '37', '010', '666666', '110000', '110100', '110101', '啊的撒发生大幅', '116.404150', '39.923389', '1444637359', '北京天安门店', 'images/000/000/037/201509/55f92c900830f.jpg', '', '', '', '2');
INSERT INTO `pigcms_store_physical` VALUES ('6', '37', '', '1323123123', '110000', '110100', '110106', 'adfasdfasdfasdf ', '116.409925', '39.913393', '1444637365', '精品蔬菜', 'images/000/000/037/201509/55fa196c81d52.jpg', '', '', 'https://www.baidu.com/', '3');

-- ----------------------------
-- Table structure for `pigcms_store_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_supplier`;
CREATE TABLE `pigcms_store_supplier` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `supplier_id` int(11) NOT NULL default '0' COMMENT '供货商店铺id',
  `seller_id` int(11) NOT NULL default '0' COMMENT '分销商店铺id',
  `supply_chain` varchar(500) NOT NULL default '' COMMENT '供货链',
  `level` tinyint(1) unsigned NOT NULL default '1' COMMENT '级别',
  `type` tinyint(1) unsigned NOT NULL default '0' COMMENT '分销类型，0 全网分销 1排他分销',
  PRIMARY KEY  (`pigcms_id`),
  KEY `supplier_id` USING BTREE (`supplier_id`),
  KEY `seller_id` USING BTREE (`seller_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='供货商';

-- ----------------------------
-- Records of pigcms_store_supplier
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_user_data`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_user_data`;
CREATE TABLE `pigcms_store_user_data` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `point_count` int(11) NOT NULL,
  `order_unpay` mediumint(9) NOT NULL,
  `order_unsend` mediumint(9) NOT NULL,
  `order_send` mediumint(9) NOT NULL,
  `order_complete` mediumint(9) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='店铺用户数据表';

-- ----------------------------
-- Records of pigcms_store_user_data
-- ----------------------------
INSERT INTO `pigcms_store_user_data` VALUES ('13', '29', '66', '0', '0', '0', '0', '0', '1', '1439993691');
INSERT INTO `pigcms_store_user_data` VALUES ('14', '29', '67', '0', '0', '3', '0', '0', '1', '1439993578');
INSERT INTO `pigcms_store_user_data` VALUES ('15', '29', '68', '0', '0', '0', '1', '0', '0', '1439993625');
INSERT INTO `pigcms_store_user_data` VALUES ('16', '37', '76', '0', '0', '0', '0', '0', '0', '1442562525');
INSERT INTO `pigcms_store_user_data` VALUES ('17', '36', '76', '0', '0', '1', '0', '0', '0', '1450235892');

-- ----------------------------
-- Table structure for `pigcms_store_withdrawal`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_withdrawal`;
CREATE TABLE `pigcms_store_withdrawal` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `trade_no` varchar(100) NOT NULL default '' COMMENT '交易号',
  `uid` int(11) NOT NULL default '0' COMMENT '用户id',
  `store_id` int(11) NOT NULL default '0' COMMENT '店铺id',
  `bank_id` int(11) NOT NULL default '0' COMMENT '银行id',
  `opening_bank` varchar(30) NOT NULL default '' COMMENT '开户行',
  `bank_card` varchar(30) NOT NULL default '' COMMENT '银行卡号',
  `bank_card_user` varchar(30) NOT NULL default '' COMMENT '开卡人姓名',
  `withdrawal_type` tinyint(1) NOT NULL default '0' COMMENT '提现方式 0对私 1对公',
  `add_time` varchar(20) NOT NULL default '' COMMENT '申请时间',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态 1申请中 2银行处理中 3提现成功 4提现失败',
  `amount` decimal(10,2) unsigned NOT NULL default '0.00' COMMENT '提现金额',
  `complate_time` varchar(20) NOT NULL default '' COMMENT '完成时间',
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`),
  KEY `bank_id` USING BTREE (`bank_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='提现';

-- ----------------------------
-- Records of pigcms_store_withdrawal
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_system_info`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_info`;
CREATE TABLE `pigcms_system_info` (
  `lastsqlupdate` int(10) NOT NULL,
  `version` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_system_info
-- ----------------------------
INSERT INTO `pigcms_system_info` VALUES ('7620', '');

-- ----------------------------
-- Table structure for `pigcms_system_menu`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_menu`;
CREATE TABLE `pigcms_system_menu` (
  `id` int(11) NOT NULL auto_increment,
  `fid` int(11) NOT NULL,
  `name` char(20) NOT NULL,
  `module` char(20) NOT NULL,
  `action` char(20) NOT NULL,
  `sort` int(11) NOT NULL default '0',
  `show` tinyint(1) NOT NULL default '1' COMMENT '是否显示',
  `status` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `fid` USING BTREE (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='系统后台菜单表';

-- ----------------------------
-- Records of pigcms_system_menu
-- ----------------------------
INSERT INTO `pigcms_system_menu` VALUES ('1', '0', '后台首页', '', '', '10', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('2', '0', '系统设置', '', '', '9', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('3', '0', '商品管理', '', '', '7', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('4', '0', '订单管理', '', '', '6', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('5', '0', '用户管理', '', '', '5', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('6', '1', '后台首页', 'index', 'main', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('7', '1', '修改密码', 'index', 'pass', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('8', '1', '个人资料', 'index', 'profile', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('9', '1', '更新缓存', 'index', 'cache', '0', '0', '1');
INSERT INTO `pigcms_system_menu` VALUES ('10', '2', '站点配置', 'config', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('11', '2', '友情链接', 'flink', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('12', '0', '店铺管理', '', '', '4', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('13', '12', '店铺列表', 'Store', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('14', '2', '城市区域', 'area', 'index', '0', '0', '0');
INSERT INTO `pigcms_system_menu` VALUES ('15', '3', '商品列表', 'Product', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('16', '3', '商品分类', 'Product', 'category', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('17', '2', '广告管理', 'Adver', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('19', '2', '导航管理', 'Slider', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('20', '2', '热门搜索词', 'Search_hot', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('21', '24', '自定义菜单', 'diymenu', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('22', '2', '快递公司', 'Express', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('23', '12', '收支明细', 'Store', 'inoutdetail', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('24', '0', '微信设置', '', '', '8', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('25', '24', '首页回复配置', 'home', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('28', '4', '所有订单', 'Order', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('29', '5', '用户列表', 'user', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('30', '24', '首次关注回复', 'home', 'first', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('31', '24', '关键词回复', 'home', 'other', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('32', '2', '平台会员卡', 'Card', 'index', '0', '0', '0');
INSERT INTO `pigcms_system_menu` VALUES ('33', '24', '模板消息', 'templateMsg', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('34', '4', '到店自提订单', 'Order', 'selffetch', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('35', '4', '货到付款订单', 'Order', 'codpay', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('36', '4', '代付的订单', 'Order', 'payagent', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('37', '12', '主营类目', 'Store', 'category', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('38', '12', '提现记录', 'Store', 'withdraw', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('40', '3', '商品分组', 'Product', 'group', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('44', '2', '商品栏目属性列表', 'Sys_product_property', 'propertyType', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('45', '2', '商品栏目属性值列表', 'Sys_product_property', 'property', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('46', '2', '商城评论标签', 'Tag', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('49', '2', '敏感词', 'Ng_word', 'index', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('50', '12', '品牌类别管理', 'Store', 'brandType', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('51', '12', '品牌管理', 'Store', 'brand', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('53', '12', '营销活动管理', 'Store', 'activityManage', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('54', '12', '营销活动展示', 'Store', 'activityRecommend', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('55', '12', '店铺对账日志', 'Order', 'checklog', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('58', '3', '被分销的源商品列表', 'Product', 'fxlist', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('59', '3', '商品评价管理', 'Product', 'comment', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('60', '12', '店铺评价管理', 'Store', 'comment', '0', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('0', '0', '', '', '', '0', '1', '1');

-- ----------------------------
-- Table structure for `pigcms_system_product_property`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_product_property`;
CREATE TABLE `pigcms_system_product_property` (
  `pid` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '' COMMENT '属性名',
  `sort` int(11) NOT NULL default '0' COMMENT '排序字段',
  `status` tinyint(1) NOT NULL default '1' COMMENT '1：启用，0：关闭',
  `property_type_id` smallint(5) NOT NULL COMMENT '产品属性所属类别id',
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='商品栏目属性名表';

-- ----------------------------
-- Records of pigcms_system_product_property
-- ----------------------------
INSERT INTO `pigcms_system_product_property` VALUES ('1', '看看', '0', '1', '1');
INSERT INTO `pigcms_system_product_property` VALUES ('2', '走走', '0', '1', '1');
INSERT INTO `pigcms_system_product_property` VALUES ('3', '女装', '0', '1', '1');
INSERT INTO `pigcms_system_product_property` VALUES ('4', '哈哈', '0', '1', '2');

-- ----------------------------
-- Table structure for `pigcms_system_product_to_property_value`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_product_to_property_value`;
CREATE TABLE `pigcms_system_product_to_property_value` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(10) NOT NULL default '0' COMMENT '商品id',
  `pid` int(10) NOT NULL default '0' COMMENT '系统筛选表id',
  `vid` int(10) NOT NULL default '0' COMMENT '系统筛选属性值id',
  PRIMARY KEY  (`id`),
  KEY `product_id` USING BTREE (`product_id`),
  KEY `vid` USING BTREE (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品关联筛选属性值表';

-- ----------------------------
-- Records of pigcms_system_product_to_property_value
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_system_property_type`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_property_type`;
CREATE TABLE `pigcms_system_property_type` (
  `type_id` smallint(5) NOT NULL auto_increment,
  `type_name` varchar(80) NOT NULL COMMENT '属性类别名',
  `type_status` tinyint(1) NOT NULL default '1' COMMENT '状态：1为开启，0为关闭',
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='产品属性的类别表';

-- ----------------------------
-- Records of pigcms_system_property_type
-- ----------------------------
INSERT INTO `pigcms_system_property_type` VALUES ('1', '金重', '1');
INSERT INTO `pigcms_system_property_type` VALUES ('2', '大师', '1');
INSERT INTO `pigcms_system_property_type` VALUES ('3', '撒', '1');

-- ----------------------------
-- Table structure for `pigcms_system_property_value`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_property_value`;
CREATE TABLE `pigcms_system_property_value` (
  `vid` int(10) NOT NULL auto_increment COMMENT '商品栏目属性值id',
  `pid` int(10) NOT NULL default '0' COMMENT '商品栏目属性名id',
  `value` varchar(50) NOT NULL default '' COMMENT '商品栏目属性值',
  PRIMARY KEY  (`vid`),
  KEY `pid` USING BTREE (`pid`),
  KEY `pid_2` USING BTREE (`pid`,`value`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='商品栏目属性值';

-- ----------------------------
-- Records of pigcms_system_property_value
-- ----------------------------
INSERT INTO `pigcms_system_property_value` VALUES ('1', '1', '111');
INSERT INTO `pigcms_system_property_value` VALUES ('2', '1', '222');
INSERT INTO `pigcms_system_property_value` VALUES ('3', '2', '22');
INSERT INTO `pigcms_system_property_value` VALUES ('4', '2', '33');
INSERT INTO `pigcms_system_property_value` VALUES ('5', '2', '444');

-- ----------------------------
-- Table structure for `pigcms_system_tag`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_tag`;
CREATE TABLE `pigcms_system_tag` (
  `id` int(11) NOT NULL auto_increment,
  `tid` int(11) NOT NULL default '0' COMMENT 'system_property_type表type_id，主要是为了方便查找',
  `name` varchar(100) NOT NULL COMMENT '标签名',
  `status` tinyint(1) NOT NULL default '1' COMMENT '状态，1为开启，0：关闭',
  UNIQUE KEY `id` (`id`),
  KEY `tid` USING BTREE (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='系统标签表';

-- ----------------------------
-- Records of pigcms_system_tag
-- ----------------------------
INSERT INTO `pigcms_system_tag` VALUES ('1', '0', '111', '1');
INSERT INTO `pigcms_system_tag` VALUES ('2', '0', '222', '1');

-- ----------------------------
-- Table structure for `pigcms_tempmsg`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_tempmsg`;
CREATE TABLE `pigcms_tempmsg` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tempkey` char(50) NOT NULL,
  `name` char(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `industry` char(50) NOT NULL,
  `topcolor` char(10) NOT NULL default '#029700',
  `textcolor` char(10) NOT NULL default '#000000',
  `token` char(40) NOT NULL,
  `tempid` char(100) default NULL,
  `status` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `tempkey` (`tempkey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_tempmsg
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_text`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_text`;
CREATE TABLE `pigcms_text` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL,
  `content` varchar(200) NOT NULL,
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_text
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_trade_selffetch`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_trade_selffetch`;
CREATE TABLE `pigcms_trade_selffetch` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `store_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `province` mediumint(9) NOT NULL,
  `city` mediumint(9) NOT NULL,
  `county` mediumint(9) NOT NULL,
  `address` varchar(150) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY  (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='买家上门自提';

-- ----------------------------
-- Records of pigcms_trade_selffetch
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_trade_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_trade_setting`;
CREATE TABLE `pigcms_trade_setting` (
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `pay_cancel_time` smallint(6) NOT NULL COMMENT '自动取消订单时间',
  `pay_alert_time` smallint(6) NOT NULL COMMENT '自动催付订单时间',
  `sucess_notice` tinyint(1) NOT NULL COMMENT '支付成功是否通知',
  `send_notice` tinyint(1) NOT NULL COMMENT '发货是否通知',
  `complain_notice` tinyint(1) NOT NULL COMMENT '维权是否通知',
  `last_time` int(11) NOT NULL,
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='交易物流通知';

-- ----------------------------
-- Records of pigcms_trade_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_ucenter`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_ucenter`;
CREATE TABLE `pigcms_ucenter` (
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `page_title` varchar(100) NOT NULL COMMENT '页面名称',
  `bg_pic` varchar(200) NOT NULL COMMENT '背景图片',
  `show_level` char(1) NOT NULL default '1' COMMENT '显示会员等级 0不显示 1显示',
  `show_point` char(1) NOT NULL default '1' COMMENT '显示用户积分 0不显示 1显示',
  `has_custom` tinyint(1) NOT NULL default '0' COMMENT '是否有自定义字段',
  `last_time` int(11) NOT NULL COMMENT '最后编辑时间',
  UNIQUE KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户中心';

-- ----------------------------
-- Records of pigcms_ucenter
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user`;
CREATE TABLE `pigcms_user` (
  `uid` int(10) unsigned NOT NULL auto_increment,
  `nickname` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `openid` varchar(50) NOT NULL COMMENT '微信唯一标识',
  `reg_time` int(10) unsigned NOT NULL,
  `reg_ip` bigint(20) unsigned NOT NULL,
  `last_time` int(10) unsigned NOT NULL,
  `last_ip` bigint(20) unsigned NOT NULL,
  `check_phone` tinyint(1) NOT NULL default '0',
  `login_count` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  `intro` varchar(500) NOT NULL default '' COMMENT '个人签名',
  `avatar` varchar(200) NOT NULL default '' COMMENT '头像',
  `is_weixin` tinyint(1) NOT NULL default '0' COMMENT '是否是微信用户 0否 1是',
  `stores` smallint(6) NOT NULL default '0' COMMENT '店铺数量',
  `token` varchar(100) NOT NULL default '' COMMENT '微信token',
  `session_id` varchar(50) NOT NULL default '' COMMENT 'session id',
  `server_key` varchar(50) NOT NULL default '',
  `source_site_url` varchar(200) NOT NULL default '' COMMENT '来源网站',
  `payment_url` varchar(200) NOT NULL default '' COMMENT '站外支付地址',
  `notify_url` varchar(200) NOT NULL default '' COMMENT '通知地址',
  `oauth_url` varchar(200) NOT NULL default '' COMMENT '对接网站用户认证地址',
  `is_seller` tinyint(1) NOT NULL default '0' COMMENT '是否是卖家',
  `third_id` varchar(50) NOT NULL default '' COMMENT '第三方id',
  `drp_store_id` int(11) unsigned NOT NULL default '0' COMMENT '用户所属店铺',
  `app_id` int(11) unsigned NOT NULL default '0' COMMENT '对接应用id',
  `admin_id` int(10) unsigned NOT NULL default '0' COMMENT '后台ID',
  `storeid` int(10) default NULL,
  `mdid` int(10) default NULL,
  `zqx` text,
  PRIMARY KEY  (`uid`),
  KEY `phone` USING BTREE (`phone`),
  KEY `nickname` USING BTREE (`nickname`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_user
-- ----------------------------
INSERT INTO `pigcms_user` VALUES ('72', 'admin', '17c3ec934c8931851430f2838bff95bc', '', '', '1440049991', '1033264285', '1440049991', '1033264285', '0', '0', '1', '', '', '0', '0', '', '', '', '', '', '', '', '0', '', '0', '0', '1', null, null, null);
INSERT INTO `pigcms_user` VALUES ('75', '汉中微聚', '96e79218965eb72c92a549dd5a330112', '13309160049', '', '1440135154', '1032201527', '1442212759', '2130706433', '0', '4', '1', '', '', '0', '1', 'ixyvte1440042048', 'etaddjc676n5tha1jjdajdpst0', '', 'http://wx.hweiju.com', 'http://wx.hweiju.com/index.php?g=Wap&m=Micrstore&a=pay', 'http://wx.hweiju.com/index.php?g=Wap&m=Micrstore&a=notify', 'http://wx.hweiju.com/index.php?g=Wap&m=Micrstore&a=login', '1', '', '0', '1', '1', null, null, null);
INSERT INTO `pigcms_user` VALUES ('86', '阿我我', '96e79218965eb72c92a549dd5a330112', '13500135800', '', '0', '0', '1450430862', '2130706433', '0', '3', '1', '', '', '0', '1', '', '', '', '', '', '', '', '0', '', '0', '0', '0', '36', '3', '1,6,');
INSERT INTO `pigcms_user` VALUES ('77', '阿萨德发的', '96e79218965eb72c92a549dd5a330112', '13621126665', '', '1444440408', '2130706433', '1444440408', '2130706433', '0', '0', '1', '', '', '0', '1', '', '', '', '', '', '', '', '1', '', '0', '0', '0', null, null, null);
INSERT INTO `pigcms_user` VALUES ('78', '敢死队', '96e79218965eb72c92a549dd5a330112', '13800138000', '', '1450404568', '2130706433', '1450404747', '2130706433', '0', '1', '1', '', '', '0', '0', '', '', '', '', '', '', '', '0', '', '0', '0', '0', null, null, null);

-- ----------------------------
-- Table structure for `pigcms_user_address`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_address`;
CREATE TABLE `pigcms_user_address` (
  `address_id` int(10) NOT NULL auto_increment,
  `uid` int(10) NOT NULL default '0' COMMENT '用户id',
  `session_id` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL default '' COMMENT '收货人',
  `tel` varchar(20) NOT NULL COMMENT '联系电话',
  `province` mediumint(9) NOT NULL COMMENT '省code',
  `city` mediumint(9) NOT NULL COMMENT '市code',
  `area` mediumint(9) NOT NULL COMMENT '区code',
  `address` varchar(300) NOT NULL default '' COMMENT '详细地址',
  `zipcode` varchar(10) NOT NULL COMMENT '邮编',
  `default` tinyint(1) NOT NULL default '0' COMMENT '默认收货地址',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY  (`address_id`),
  KEY `uid` USING BTREE (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='收货地址';

-- ----------------------------
-- Records of pigcms_user_address
-- ----------------------------
INSERT INTO `pigcms_user_address` VALUES ('9', '76', '', '阿打发士大夫', '13621135553', '220000', '220800', '220881', '是打发士大夫爱的色放', '', '0', '1442463428');
INSERT INTO `pigcms_user_address` VALUES ('11', '76', '', '阿打发士大夫', '13621135553', '220000', '220800', '220881', '是打发士大夫', '', '0', '1442463431');
INSERT INTO `pigcms_user_address` VALUES ('12', '76', '', '阿打发士大夫', '13621135553', '220000', '220800', '220881', '是打发士大夫', '', '0', '1442463431');
INSERT INTO `pigcms_user_address` VALUES ('13', '76', '', '阿打发士大夫', '13621135553', '220000', '220800', '220881', '是打发士大夫', '', '0', '1442463432');

-- ----------------------------
-- Table structure for `pigcms_user_attention`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_attention`;
CREATE TABLE `pigcms_user_attention` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` mediumint(8) unsigned NOT NULL default '0' COMMENT '用户ID',
  `data_id` int(10) unsigned NOT NULL default '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',
  `data_type` tinyint(4) unsigned NOT NULL default '0' COMMENT '数据类型  1，商品 2，店铺',
  `add_time` int(10) unsigned NOT NULL default '0' COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_user_attention
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_cart`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_cart`;
CREATE TABLE `pigcms_user_cart` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku_id` int(11) NOT NULL,
  `sku_data` text NOT NULL COMMENT '库存信息',
  `pro_num` int(11) NOT NULL,
  `pro_price` decimal(10,2) NOT NULL,
  `add_time` int(11) NOT NULL,
  `comment` text NOT NULL,
  `is_fx` tinyint(1) NOT NULL default '0' COMMENT '是否为分销商品',
  PRIMARY KEY  (`pigcms_id`),
  KEY `uid` USING BTREE (`uid`),
  KEY `session_id` USING BTREE (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户的购物车';

-- ----------------------------
-- Records of pigcms_user_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_collect`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_collect`;
CREATE TABLE `pigcms_user_collect` (
  `collect_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` mediumint(8) unsigned NOT NULL default '0',
  `dataid` int(11) unsigned NOT NULL default '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',
  `add_time` int(11) unsigned NOT NULL default '0',
  `type` tinyint(1) NOT NULL COMMENT '1:为商品；2:为店铺',
  `is_attention` tinyint(1) NOT NULL default '0' COMMENT '是否被关注(0:不关注，1：关注)',
  PRIMARY KEY  (`collect_id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`dataid`),
  KEY `is_attention` (`is_attention`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户收藏店铺or商品';

-- ----------------------------
-- Records of pigcms_user_collect
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_coupon`;
CREATE TABLE `pigcms_user_coupon` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `coupon_id` int(11) NOT NULL COMMENT '优惠券ID',
  `card_no` char(32) NOT NULL COMMENT '卡号',
  `cname` varchar(255) NOT NULL COMMENT '优惠券名称',
  `face_money` decimal(10,2) NOT NULL default '0.00' COMMENT '优惠券面值(起始)',
  `limit_money` decimal(10,2) NOT NULL default '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',
  `start_time` int(11) NOT NULL COMMENT '生效时间',
  `end_time` int(11) NOT NULL COMMENT '过期时间',
  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',
  `is_share` tinyint(1) NOT NULL default '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',
  `is_all_product` tinyint(1) NOT NULL default '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',
  `is_original_price` tinyint(1) NOT NULL default '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',
  `description` text NOT NULL COMMENT '使用说明',
  `is_use` tinyint(1) NOT NULL default '0' COMMENT '是否使用',
  `is_valid` tinyint(4) NOT NULL default '0' COMMENT '0:不可以使用，1：可以使用',
  `use_time` int(11) NOT NULL default '0' COMMENT '优惠券使用时间',
  `timestamp` int(11) NOT NULL COMMENT '领取优惠券的时间',
  `type` tinyint(1) NOT NULL default '1' COMMENT '券类型（1：优惠券，2：赠送券）',
  `give_order_id` int(11) NOT NULL default '0' COMMENT '赠送的订单id',
  `use_order_id` int(11) NOT NULL default '0' COMMENT '使用的订单id',
  `delete_flg` tinyint(1) NOT NULL default '0' COMMENT '是否删除(0:未删除，1：已删除)',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `card_no` (`card_no`),
  KEY `coupon_id` (`coupon_id`),
  KEY `uid` (`uid`),
  KEY `type` (`type`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户领取的优惠券信息';

-- ----------------------------
-- Records of pigcms_user_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_weixin_bind`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_weixin_bind`;
CREATE TABLE `pigcms_weixin_bind` (
  `pigcms_id` int(10) unsigned NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL,
  `authorizer_appid` varchar(100) NOT NULL COMMENT '授权方appid',
  `authorizer_refresh_token` varchar(500) NOT NULL COMMENT '刷新令牌',
  `func_info` varchar(50) NOT NULL COMMENT '公众号授权给开发者的权限集列表',
  `head_img` varchar(300) NOT NULL COMMENT '授权方头像',
  `service_type_info` tinyint(1) NOT NULL COMMENT '授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号',
  `verify_type_info` tinyint(1) NOT NULL COMMENT '授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证',
  `user_name` varchar(70) NOT NULL COMMENT '授权方公众号的原始ID',
  `nick_name` varchar(30) NOT NULL COMMENT '授权方昵称',
  `alias` varchar(30) NOT NULL COMMENT '授权方公众号所设置的微信号，可能为空',
  `qrcode_url` varchar(300) NOT NULL COMMENT '二维码图片的URL',
  `wxpay_mchid` varchar(50) NOT NULL,
  `wxpay_key` varchar(50) NOT NULL,
  `wxpay_test` tinyint(1) NOT NULL,
  PRIMARY KEY  (`pigcms_id`),
  KEY `store_id` USING BTREE (`store_id`),
  KEY `user_name` USING BTREE (`user_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='绑定微信信息';

-- ----------------------------
-- Records of pigcms_weixin_bind
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_wei_page`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_wei_page`;
CREATE TABLE `pigcms_wei_page` (
  `page_id` int(10) NOT NULL auto_increment COMMENT '页面id',
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `page_name` varchar(50) NOT NULL COMMENT '页面标题',
  `page_desc` varchar(1000) NOT NULL COMMENT '页面描述',
  `bgcolor` varchar(10) NOT NULL COMMENT '背景颜色',
  `is_home` tinyint(1) NOT NULL default '0' COMMENT '主页 0否 1是',
  `add_time` int(11) NOT NULL default '0' COMMENT '创建日期',
  `product_count` int(10) NOT NULL default '0' COMMENT '商品数量',
  `hits` int(10) NOT NULL default '0' COMMENT '页面浏览量',
  `page_sort` int(10) NOT NULL default '0' COMMENT '排序',
  `has_category` tinyint(1) NOT NULL,
  `has_custom` tinyint(1) NOT NULL,
  PRIMARY KEY  (`page_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=238 DEFAULT CHARSET=utf8 COMMENT='微页面';

-- ----------------------------
-- Records of pigcms_wei_page
-- ----------------------------
INSERT INTO `pigcms_wei_page` VALUES ('48', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('47', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('46', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('45', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('44', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('43', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('42', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('41', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('40', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('39', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('38', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('37', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('36', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('35', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('34', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('33', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('49', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('50', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('51', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('52', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('53', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('54', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('55', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('56', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('57', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('58', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('59', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('60', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('61', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('62', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('63', '26', '这是您的第一篇微杂志', '', '', '1', '1439909414', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('64', '27', '远亮商城', '', '', '1', '1439990314', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('65', '28', '这是您的第一篇微杂志', '', '', '1', '1439989853', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('66', '29', '这是您的第一篇微杂志', '', '', '1', '1439990751', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('67', '30', '这是您的第一篇微杂志', '', '', '1', '1439990798', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('68', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('69', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('70', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('71', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('72', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('73', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('74', '31', '这是您的第一篇微杂志', '', '', '1', '1439993571', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('75', '32', '这是您的第一篇微杂志', '', '', '1', '1439993893', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('76', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('77', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('78', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('79', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('80', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('81', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('82', '33', '这是您的第一篇微杂志', '', '', '1', '1440035329', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('83', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('84', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('85', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('86', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('87', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('88', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('89', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('90', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('91', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('92', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('93', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('94', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('95', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('96', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('97', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('98', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('99', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('100', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('101', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('102', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('103', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('104', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('105', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('106', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('107', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('108', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('109', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('110', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('111', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('112', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('113', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('114', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('115', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('116', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('117', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('118', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('119', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('120', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('121', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('122', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('123', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('124', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('125', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('126', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('127', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('128', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('129', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('130', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('131', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('132', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('133', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('134', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('135', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('136', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('137', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('138', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('139', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('140', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('141', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('142', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('143', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('144', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('145', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('146', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('147', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('148', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('149', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('150', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('151', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('152', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('153', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('154', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('155', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('156', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('157', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('158', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('159', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('160', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('161', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('162', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('163', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('164', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('165', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('166', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('167', '34', '这是您的第一篇微杂志', '', '', '1', '1440124711', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('168', '35', '这是您的第一篇微杂志', '', '', '1', '1440125898', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('169', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('170', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('171', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('172', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('173', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('174', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('175', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('176', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('177', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('178', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('179', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('180', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('181', '36', '这是您的第一篇微杂志', '', '', '1', '1440135175', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('182', '37', '这是您的第一篇微杂志', '', '', '1', '1442305977', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('183', '38', '这是您的第一篇微杂志', '', '', '1', '1444440434', '0', '0', '0', '0', '1');
INSERT INTO `pigcms_wei_page` VALUES ('184', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('185', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('186', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('187', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('188', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('189', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('190', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('191', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('192', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('193', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('194', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('195', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('196', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('197', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('198', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('199', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('200', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('201', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('202', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('203', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('204', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('205', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('206', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('207', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('208', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('209', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('210', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('211', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('212', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('213', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('214', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('215', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('216', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('217', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('218', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('219', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('220', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('221', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('222', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('223', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('224', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('225', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('226', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('227', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('228', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('229', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('230', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('231', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('232', '0', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('233', '0', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('234', '0', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('235', '0', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('236', '0', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1');
INSERT INTO `pigcms_wei_page` VALUES ('237', '0', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1');

-- ----------------------------
-- Table structure for `pigcms_wei_page_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_wei_page_category`;
CREATE TABLE `pigcms_wei_page_category` (
  `cat_id` int(10) NOT NULL auto_increment COMMENT '微页面分类id',
  `store_id` int(10) NOT NULL default '0' COMMENT '店铺id',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名',
  `first_sort` varchar(20) NOT NULL default '' COMMENT '排序 pv DESC order_by DESC',
  `second_sort` varchar(20) NOT NULL default '' COMMENT '排序 date_added DESC date_added DESC pv DESC',
  `show_style` char(1) NOT NULL default '0' COMMENT '显示样式 0仅显示杂志列表 1用期刊方式展示',
  `cat_desc` text NOT NULL COMMENT '简介',
  `page_count` int(10) unsigned NOT NULL default '0' COMMENT '微页面数',
  `has_custom` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '创建日期',
  `page_id` int(10) unsigned NOT NULL default '0',
  `uid` int(10) default NULL,
  `cover_img` text,
  PRIMARY KEY  (`cat_id`),
  KEY `store_id` USING BTREE (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='微页面分类';

-- ----------------------------
-- Records of pigcms_wei_page_category
-- ----------------------------
INSERT INTO `pigcms_wei_page_category` VALUES ('1', '0', '', '', '', '0', '', '0', '0', '0', '0', null, null);
INSERT INTO `pigcms_wei_page_category` VALUES ('7', '36', '啊大师傅反反复复反复反复发放', '0', '0', '0', '', '0', '0', '0', '0', null, null);
INSERT INTO `pigcms_wei_page_category` VALUES ('6', '36', '爱的是反反复复反复反复发反反复复阿士大夫', '', '', '0', '', '0', '0', '0', '0', null, null);
INSERT INTO `pigcms_wei_page_category` VALUES ('8', '36', '奥德赛烦烦烦烦烦烦烦烦烦烦', '0', '0', '0', '<p>爱的方式是是是是</p>', '0', '0', '1450851581', '0', null, null);
INSERT INTO `pigcms_wei_page_category` VALUES ('9', '36', '阿萨德反反复复反复反复发', '0', '0', '0', '<p>阿萨德反反复复反复反复</p>', '0', '0', '1450851716', '0', '75', '/upload/images/default_ucenter.jpg');
INSERT INTO `pigcms_wei_page_category` VALUES ('10', '0', '通用模板', '0', '0', '0', '<p>通用模板描述。</p>', '1', '0', '1438998819', '226', '72', '/upload/images/icon_03.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('11', '0', '餐饮外卖', '0', '0', '0', '<p>餐饮外卖描述。</p>', '1', '0', '1438998801', '227', '72', '/upload/images/icon_05.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('12', '0', '食品电商', '0', '0', '0', '<p>食品电商描述</p>', '1', '0', '1438998781', '228', '72', '/upload/images/icon_07.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('13', '0', '美妆电商', '1', '0', '0', '<p>美妆电商描述。</p>', '1', '0', '1438998760', '229', '72', '/upload/images/icon_12.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('14', '0', '线下门店', '0', '0', '0', '<p>线下门店描述</p>', '1', '0', '1438998738', '230', '72', '/upload/images/icon_13.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('15', '0', '鲜花速递', '0', '0', '0', '<p>鲜花速递描述。</p>', '1', '0', '1438998718', '231', '72', '/upload/images/icon_14.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('16', '0', '通用模板', '0', '0', '0', '<p>通用模板描述。</p>', '1', '0', '1438998819', '232', '72', '/upload/images/icon_03.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('17', '0', '餐饮外卖', '0', '0', '0', '<p>餐饮外卖描述。</p>', '1', '0', '1438998801', '233', '72', '/upload/images/icon_05.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('18', '0', '食品电商', '0', '0', '0', '<p>食品电商描述</p>', '1', '0', '1438998781', '234', '72', '/upload/images/icon_07.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('19', '0', '美妆电商', '1', '0', '0', '<p>美妆电商描述。</p>', '1', '0', '1438998760', '235', '72', '/upload/images/icon_12.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('20', '0', '线下门店', '0', '0', '0', '<p>线下门店描述</p>', '1', '0', '1438998738', '236', '72', '/upload/images/icon_13.png');
INSERT INTO `pigcms_wei_page_category` VALUES ('21', '0', '鲜花速递', '0', '0', '0', '<p>鲜花速递描述。</p>', '1', '0', '1438998718', '237', '72', '/upload/images/icon_14.png');

-- ----------------------------
-- Table structure for `pigcms_wei_page_to_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_wei_page_to_category`;
CREATE TABLE `pigcms_wei_page_to_category` (
  `pigcms_id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL default '0' COMMENT '微页面id',
  `cat_id` int(11) NOT NULL default '0' COMMENT '微页面分类id',
  PRIMARY KEY  (`pigcms_id`),
  KEY `wei_page_id` USING BTREE (`page_id`),
  KEY `wei_page_category_id` USING BTREE (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='微页面关联分类';

-- ----------------------------
-- Records of pigcms_wei_page_to_category
-- ----------------------------
