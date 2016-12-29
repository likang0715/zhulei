/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-03 16:33:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pigcms_access_token_expires`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_access_token_expires`;
CREATE TABLE `pigcms_access_token_expires` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` varchar(700) NOT NULL,
  `expires_in` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_access_token_expires
-- ----------------------------
INSERT INTO `pigcms_access_token_expires` VALUES ('1', 'BJWyPgWf7DaTz1iJfhh1N6NCfZL0axVADhHAG0UFLXwR2ZDXPKGvSWRkmO0EjEJPxEXQbjJuiNF3-W2toxMPyDF54f48wmgbrEIMmdf_z9raXQ1ZsKQ4Ua3O37PN-5cFXCJbAAADIP', '1464949210');

-- ----------------------------
-- Table structure for `pigcms_activity_icon`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_activity_icon`;
CREATE TABLE `pigcms_activity_icon` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` tinyint(3) DEFAULT '0' COMMENT '1=>一元夺宝',
  `name` varchar(30) DEFAULT NULL,
  `key` varchar(10) DEFAULT '0' COMMENT '查找图片键值',
  `imgurl` varchar(50) DEFAULT '' COMMENT '图片地址',
  `status` tinyint(1) DEFAULT '0' COMMENT '0=>关闭1=>开启',
  PRIMARY KEY (`id`),
  KEY `key` (`key`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_activity_icon
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_activity_recommend`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_activity_recommend`;
CREATE TABLE `pigcms_activity_recommend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modelId` int(11) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `info` varchar(2000) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `qcode` varchar(200) DEFAULT NULL COMMENT '活动二维码本地路径',
  `qcode_starttime` int(11) NOT NULL COMMENT '二维码开始生效时间',
  `token` char(50) DEFAULT NULL,
  `model` char(20) DEFAULT NULL,
  `is_rec` tinyint(1) NOT NULL,
  `is_hot` tinyint(1) DEFAULT '0' COMMENT '是否热门，1：是，0：否',
  `ucount` int(11) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `price` varchar(50) NOT NULL COMMENT '价格',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '抽奖类型',
  `original_price` varchar(50) NOT NULL COMMENT '原价',
  `store_id` int(11) DEFAULT '0' COMMENT '活动所属店铺ID',
  `status` tinyint(1) DEFAULT '0' COMMENT '活动状态，0：正常，1：过期',
  PRIMARY KEY (`id`),
  KEY `modelId` (`modelId`,`token`,`model`) USING BTREE,
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='推荐活动';

-- ----------------------------
-- Records of pigcms_activity_recommend
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_admin`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_admin`;
CREATE TABLE `pigcms_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` char(20) NOT NULL,
  `pwd` char(32) NOT NULL,
  `realname` char(20) NOT NULL,
  `phone` char(20) NOT NULL,
  `email` char(20) NOT NULL,
  `qq` char(20) NOT NULL,
  `avatar` varchar(50) DEFAULT NULL COMMENT '区域管理员头像',
  `last_ip` bigint(20) NOT NULL,
  `last_time` int(11) NOT NULL,
  `login_count` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `reward_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '奖励总额',
  `reward_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '可用奖励金额',
  `reward_unbalance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '不可用奖励金额',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属权限组id',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '后台管理类别: 0超级管理员 1普通管理员 2区域管理 3代理商',
  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '创建者uid',
  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '市区',
  `county` varchar(30) NOT NULL DEFAULT '' COMMENT '区县',
  `area_level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '区域等级：0非区域管理 1省级 2市级 3区县级',
  `agent_code` varchar(100) NOT NULL DEFAULT '' COMMENT '代理商邀请码',
  `open_id` varchar(50) NOT NULL COMMENT '区域管理员微信id （用于消息通知）',
  `area_admin` int(11) NOT NULL DEFAULT '0' COMMENT '关联区域管理员admin_id 只允许代理商关联',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_admin
-- ----------------------------
INSERT INTO `pigcms_admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', '', '', null, '-572758377', '1464940659', '57', '1', '0.00', '0.00', '0.00', '0', '0', '0', '', '', '', '0', '', '', '0');

-- ----------------------------
-- Table structure for `pigcms_admin_bonus_config`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_admin_bonus_config`;
CREATE TABLE `pigcms_admin_bonus_config` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '管理员类型,默认0: 0,1保留 2区域管理员 3代理商 ',
  `area_level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '区域等级,默认0: 0非区域管理员 1省级 2市级 3区县级',
  `self_online` decimal(6,3) unsigned NOT NULL COMMENT '自营店铺-线上(%)',
  `self_offline` decimal(6,3) unsigned NOT NULL COMMENT '自营店铺-线下(%)',
  `platform_online` decimal(6,3) unsigned NOT NULL COMMENT '平台经营-线上(%)',
  `platform_offline` decimal(6,3) unsigned NOT NULL COMMENT '平台经营-线下(%)',
  `foreign_online` decimal(6,3) unsigned NOT NULL COMMENT '海外店铺-线上(%)',
  `foreign_offline` decimal(6,3) unsigned NOT NULL COMMENT '海外店铺-线下(%)',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态: 0关闭 1使用 默认0',
  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '配置创建者',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员奖金比例配置';

-- ----------------------------
-- Records of pigcms_admin_bonus_config
-- ----------------------------
INSERT INTO `pigcms_admin_bonus_config` VALUES ('1', '2', '3', '0.100', '0.100', '0.100', '0.100', '0.100', '0.100', '1', '1', '1464348372');

-- ----------------------------
-- Table structure for `pigcms_admin_group`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_admin_group`;
CREATE TABLE `pigcms_admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL COMMENT '组名',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否可用: 0否 1是',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  `remark` varchar(100) NOT NULL COMMENT '备注',
  `menu_ids` varchar(300) NOT NULL DEFAULT '' COMMENT '保存system_menu id记录',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组管理';

-- ----------------------------
-- Records of pigcms_admin_group
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_admin_rbac`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_admin_rbac`;
CREATE TABLE `pigcms_admin_rbac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员组id',
  `module` varchar(30) NOT NULL DEFAULT '' COMMENT 'module控制器',
  `action` varchar(30) NOT NULL DEFAULT '' COMMENT 'action方法',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT 'system_rbac_menu记录的id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_module` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否为父级控制器：0否 1是 默认为0',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='总后台管理员权限表';

-- ----------------------------
-- Records of pigcms_admin_rbac
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_adver`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_adver`;
CREATE TABLE `pigcms_adver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `bg_color` varchar(30) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_adver
-- ----------------------------
INSERT INTO `pigcms_adver` VALUES ('1', '0', '首页幻灯片1', 'http://www.ediancha.com/category/26', 'adver/2015/07/55af8341ace1c.png', '#ebebeb', '1', '1', '1437565761');
INSERT INTO `pigcms_adver` VALUES ('2', '0', '广告1', 'http://www.ediancha.com/wap/home.php?id=2646', 'adver/2015/07/55b73b7de3676.jpg', '', '3', '1', '1438071677');
INSERT INTO `pigcms_adver` VALUES ('3', '0', '广告2', 'http://www.ediancha.com/wap/home.php?id=2647', 'adver/2015/07/55b73859c6b38.jpg', '', '3', '1', '1438070873');
INSERT INTO `pigcms_adver` VALUES ('5', '0', '你猜', 'http://www.ediancha.com/wap/good.php?id=4018&platform=1', 'adver/2015/07/55b736f3ade80.png', '', '2', '1', '1438070515');
INSERT INTO `pigcms_adver` VALUES ('6', '0', '首页幻灯片2', 'http://www.ediancha.com/category/4', 'adver/2015/06/5579206440bd3.png', '#fbe339', '1', '1', '1434001508');
INSERT INTO `pigcms_adver` VALUES ('7', '0', '首页幻灯片3', 'http://www.ediancha.com/category/7', 'adver/2015/06/55791da932c2c.png', '#4385f5', '1', '1', '1434000847');
INSERT INTO `pigcms_adver` VALUES ('8', '0', '广告1', 'http://www.ediancha.com/index.php?c=activity&a=index', 'adver/2015/07/55af11057bfcd.jpg', '#F2E6DA', '4', '1', '1437536593');
INSERT INTO `pigcms_adver` VALUES ('9', '0', '广告1', 'http://www.ediancha.com/account.php', 'adver/2015/07/55af5caf9b074.gif', '', '5', '1', '1437555887');
INSERT INTO `pigcms_adver` VALUES ('12', '0', '今日推荐-广告1', 'http://www.ediancha.com/goods/9.html', 'adver/2015/05/555efe7caa45b.jpg', '', '7', '1', '1432288892');
INSERT INTO `pigcms_adver` VALUES ('13', '0', '首页幻灯片右侧广告-1', 'http://www.ediancha.com/goods/10.html', 'adver/2015/05/555f043ce121f.png', '', '8', '1', '1432290364');
INSERT INTO `pigcms_adver` VALUES ('14', '0', '首页幻灯片右侧广告-2', 'http://www.ediancha.com/goods/11.html', 'adver/2015/05/555f04512b6c3.png', '', '8', '1', '1432290385');
INSERT INTO `pigcms_adver` VALUES ('15', '0', '首页幻灯片4', 'http://www.ediancha.com/category/19', 'adver/2015/06/55791d64028a2.png', '#c3fbfb', '1', '1', '1434000739');
INSERT INTO `pigcms_adver` VALUES ('16', '0', '今日推荐-广告2', 'http://www.ediancha.com/goods/12.html', 'adver/2015/05/5563de912e533.jpg', '', '7', '1', '1432608401');
INSERT INTO `pigcms_adver` VALUES ('17', '0', '今日推荐-广告3', 'http://www.ediancha.com/goods/13.html', 'adver/2015/05/5563dee021d8f.jpg', '', '7', '1', '1432608480');
INSERT INTO `pigcms_adver` VALUES ('18', '0', '今日推荐-广告4', 'http://www.ediancha.com/goods/14.html', 'adver/2015/05/5563df3586e25.jpg', '', '7', '1', '1432608565');
INSERT INTO `pigcms_adver` VALUES ('25', '0', '时尚女装', 'http://www.ediancha.com/wap/good.php?id=2', 'adver/2015/07/55b7345505d6f.png', '', '2', '1', '1438069844');
INSERT INTO `pigcms_adver` VALUES ('27', '0', '广告1', 'http://www.ediancha.com/', 'adver/2015/07/55af2e946656a.jpg', '', '9', '1', '1437544084');
INSERT INTO `pigcms_adver` VALUES ('28', '0', '活动中间广告1', 'http://www.ediancha.com/', 'adver/2015/07/55af7ab35f142.jpg', '', '11', '1', '1437563571');
INSERT INTO `pigcms_adver` VALUES ('29', '0', '最好广告', 'http://www.ediancha.com/category/19', 'adver/2015/07/55af82c4ebf42.png', '', '1', '1', '1437816277');
INSERT INTO `pigcms_adver` VALUES ('30', '0', '互动娱乐电商', 'http://www.ediancha.com/category/4', 'adver/2015/07/55af82f924fb3.png', '', '1', '1', '1437565689');
INSERT INTO `pigcms_adver` VALUES ('31', '0', 'lbs', 'http://www.ediancha.com/wap', 'adver/2015/07/55b73700c357e.png', '', '2', '1', '1438070528');
INSERT INTO `pigcms_adver` VALUES ('32', '0', '我要送礼', 'http://www.ediancha.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7ae7ce478.png', '', '13', '1', '1438415591');
INSERT INTO `pigcms_adver` VALUES ('33', '0', '降价拍', 'http://www.ediancha.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7b05f170a.png', '', '13', '1', '1438415621');
INSERT INTO `pigcms_adver` VALUES ('34', '0', '一元夺宝', 'http://www.ediancha.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7b205d36a.png', '', '13', '1', '1438415648');
INSERT INTO `pigcms_adver` VALUES ('35', '0', '众筹', 'http://www.ediancha.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7b6b5e9f1.png', '', '13', '1', '1438415723');
INSERT INTO `pigcms_adver` VALUES ('36', '0', '限时秒杀', 'http://www.ediancha.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7c09a6bf9.png', '', '13', '1', '1438415881');
INSERT INTO `pigcms_adver` VALUES ('37', '0', '超级砍价', 'http://www.ediancha.com/index.php?c=activity&a=index', 'adver/2015/08/55bc7c211c0b2.png', '', '13', '1', '1438415904');
INSERT INTO `pigcms_adver` VALUES ('38', '0', '活动中间广告1', 'http://www.ediancha.com/', 'adver/2015/07/55af7ab35f142.jpg', '', '10', '1', '1437563571');

-- ----------------------------
-- Table structure for `pigcms_adver_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_adver_category`;
CREATE TABLE `pigcms_adver_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` char(20) NOT NULL,
  `cat_key` char(20) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_adver_category
-- ----------------------------
INSERT INTO `pigcms_adver_category` VALUES ('1', 'pc-首页幻灯片', 'pc_index_slide');
INSERT INTO `pigcms_adver_category` VALUES ('2', 'wap-首页头部幻灯片(6)', 'wap_index_slide_top');
INSERT INTO `pigcms_adver_category` VALUES ('3', 'wap-首页热门品牌下方广告（2）', 'wap_index_brand');
INSERT INTO `pigcms_adver_category` VALUES ('4', 'pc-登陆页广告位', 'pc_login_pic');
INSERT INTO `pigcms_adver_category` VALUES ('5', 'pc-公用头部右侧广告位（1）', 'pc_index_top_right');
INSERT INTO `pigcms_adver_category` VALUES ('8', 'pc-首页幻灯片-右侧广告', 'pc_index_slide_right');
INSERT INTO `pigcms_adver_category` VALUES ('9', 'pc-活动页头部幻灯片（6）', 'pc_activity_slider');
INSERT INTO `pigcms_adver_category` VALUES ('10', 'pc-活动页今日推荐（1）', 'pc_activity_rec');
INSERT INTO `pigcms_adver_category` VALUES ('11', 'pc-活动页热门活动（4）', 'pc_activity_hot');
INSERT INTO `pigcms_adver_category` VALUES ('12', 'pc-活动页附近活动（4）', 'pc_activity_nearby');
INSERT INTO `pigcms_adver_category` VALUES ('13', 'pc-首页活动广告', 'pc_index_activity');

-- ----------------------------
-- Table structure for `pigcms_agent_invite`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_agent_invite`;
CREATE TABLE `pigcms_agent_invite` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联代理商的admin表id',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '关系建立来源：0管理员手动 1邀请码注册',
  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '手动添加的管理员id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `admin_id` (`admin_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代理商邀请用户注册关系记录表';

-- ----------------------------
-- Records of pigcms_agent_invite
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_aptitude_obtain`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_aptitude_obtain`;
CREATE TABLE `pigcms_aptitude_obtain` (
  `obtain_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `img_url` varchar(200) NOT NULL COMMENT '证书图片地址',
  `drp_supplier_id` int(11) NOT NULL COMMENT '供货商id',
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `object` tinyint(2) NOT NULL COMMENT '存储对象',
  PRIMARY KEY (`obtain_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='以生成证书图片表';

-- ----------------------------
-- Records of pigcms_aptitude_obtain
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_aptitude_tpl`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_aptitude_tpl`;
CREATE TABLE `pigcms_aptitude_tpl` (
  `tpl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '模板id',
  `tpl_name` varchar(100) NOT NULL COMMENT '模板名称',
  `object` varchar(100) NOT NULL COMMENT '适用对象',
  `validity_time` int(11) NOT NULL COMMENT '有效时间',
  `font` varchar(100) NOT NULL COMMENT '字体',
  `status` tinyint(2) NOT NULL COMMENT '状态',
  `tpl_img_url` varchar(200) NOT NULL COMMENT '模板图片地址',
  `uid` int(11) NOT NULL COMMENT '供货商id',
  `store_name_seat` varchar(50) DEFAULT NULL COMMENT '门店名称坐标位置',
  `proposer_seat` varchar(50) DEFAULT NULL COMMENT '个人签名坐标位置',
  `validity_time_seat` varchar(50) DEFAULT NULL COMMENT '有效期坐标地址',
  `degree_id` int(11) NOT NULL,
  `store_name` varchar(150) NOT NULL,
  `store_id` int(11) NOT NULL,
  PRIMARY KEY (`tpl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='批发商资质模板表';

-- ----------------------------
-- Records of pigcms_aptitude_tpl
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_article`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_article`;
CREATE TABLE `pigcms_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `title` varchar(50) NOT NULL COMMENT '文章标题',
  `desc` varchar(500) NOT NULL COMMENT '文章描述',
  `product_id` int(11) NOT NULL COMMENT '关联商品',
  `sku_id` int(11) NOT NULL,
  `pictures` text NOT NULL COMMENT '图片',
  `dateline` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL COMMENT '状态 0未发布1已发布',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺文章表';

-- ----------------------------
-- Records of pigcms_article
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_attachment`;
CREATE TABLE `pigcms_attachment` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `from` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为上传，1为导入，2为收藏',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为图片，1为语音，2为视频',
  `file` varchar(100) NOT NULL COMMENT '文件地址',
  `size` bigint(20) NOT NULL COMMENT '尺寸，byte字节',
  `width` int(11) NOT NULL COMMENT '图片宽度',
  `height` int(11) NOT NULL COMMENT '图片高度',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户IP地址',
  `agent` varchar(1024) NOT NULL COMMENT '用户浏览器信息',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件表';

-- ----------------------------
-- Records of pigcms_attachment
-- ----------------------------
INSERT INTO `pigcms_attachment` VALUES ('1', '2', '360截图20160526152959381.png', '0', '0', 'images/000/000/002/201605/5746a80a22d77.png', '396397', '532', '542', '1464248330', '1', '2071355825', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('2', '12', 'QQ截图20151113165451.jpg', '0', '0', 'images/000/000/012/201605/5747aeb89fece.jpg', '6381', '92', '112', '1464315576', '1', '604467071', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('3', '12', '2.jpg', '0', '0', 'images/000/000/012/201605/5747aeee81786.jpg', '24125', '506', '396', '1464315630', '1', '604467071', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('4', '12', '11.jpg', '0', '0', 'images/000/000/012/201605/5748274ef1cc4.jpg', '26741', '475', '397', '1464346446', '1', '604467071', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('5', '12', '1.jpg', '0', '0', 'images/000/000/012/201605/5748299e024d8.jpg', '33058', '521', '423', '1464347037', '1', '604467071', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('6', '12', '2.jpg', '0', '0', 'images/000/000/012/201605/574829d9d731f.jpg', '24125', '506', '396', '1464347097', '1', '604467071', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('7', '5', '39b3dd5dcc1e324722b533855ff8af90.jpeg', '0', '0', 'images/000/000/005/201605/574927e3468bf.jpeg', '85322', '1600', '900', '1464412131', '1', '3722210107', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('8', '5', '店铺.png', '0', '0', 'images/000/000/005/201605/574927feddc5d.png', '5114', '200', '200', '1464412158', '1', '3722210107', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('9', '5', '店铺.png', '0', '0', 'images/000/000/005/201605/574928035e47d.png', '5114', '200', '200', '1464412163', '1', '3722210107', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('10', '5', '店铺.png', '0', '0', 'images/000/000/005/201605/5749280880ce1.png', '5114', '200', '200', '1464412168', '1', '3722210107', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('11', '5', '店铺.png', '0', '0', 'images/000/000/005/201605/5749280cc604d.png', '5114', '200', '200', '1464412172', '1', '3722210107', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('12', '18', 'book_list_pic_01.jpg', '0', '0', 'images/000/000/018/201606/574e9beeacb56.jpg', '20431', '262', '191', '1464769518', '1', '3722209711', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.124 Safari/537.36');
INSERT INTO `pigcms_attachment` VALUES ('13', '18', '火.jpg', '0', '0', 'images/000/000/018/201606/575122f341066.jpg', '27745', '500', '270', '1464935155', '1', '3722208919', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36');

-- ----------------------------
-- Table structure for `pigcms_attachment_user`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_attachment_user`;
CREATE TABLE `pigcms_attachment_user` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` int(11) NOT NULL COMMENT 'UID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `from` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为上传，1为导入，2为收藏',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为图片，1为语音，2为视频',
  `file` varchar(100) NOT NULL COMMENT '文件地址',
  `size` bigint(20) NOT NULL COMMENT '尺寸，byte字节',
  `width` int(11) NOT NULL COMMENT '图片宽度',
  `height` int(11) NOT NULL COMMENT '图片高度',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户IP地址',
  `agent` varchar(1024) NOT NULL COMMENT '用户浏览器信息',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员附件表';

-- ----------------------------
-- Records of pigcms_attachment_user
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_bank`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_bank`;
CREATE TABLE `pigcms_bank` (
  `bank_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0启用 1禁用',
  PRIMARY KEY (`bank_id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='银行';

-- ----------------------------
-- Records of pigcms_bank
-- ----------------------------
INSERT INTO `pigcms_bank` VALUES ('1', '中国工商银行', '1');
INSERT INTO `pigcms_bank` VALUES ('2', '中国农业银行', '1');
INSERT INTO `pigcms_bank` VALUES ('3', '中国银行', '1');
INSERT INTO `pigcms_bank` VALUES ('4', '中国建设银行', '1');
INSERT INTO `pigcms_bank` VALUES ('5', '交通银行', '1');

-- ----------------------------
-- Table structure for `pigcms_bargain`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_bargain`;
CREATE TABLE `pigcms_bargain` (
  `pigcms_id` int(100) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL,
  `token` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '商品名称',
  `keyword` varchar(100) NOT NULL COMMENT '关键词',
  `wxtitle` varchar(100) NOT NULL COMMENT '图文回复标题',
  `wxpic` varchar(100) NOT NULL COMMENT '图文回复图片',
  `wxinfo` varchar(200) DEFAULT NULL COMMENT '图文回复简单描述',
  `logoimg1` varchar(100) NOT NULL COMMENT '商品图片1',
  `logourl1` varchar(200) DEFAULT NULL COMMENT '商品图片链接1',
  `logoimg2` varchar(100) DEFAULT NULL COMMENT '商品图片2',
  `logourl2` varchar(200) DEFAULT NULL COMMENT '商品图片链接2',
  `logoimg3` varchar(100) DEFAULT NULL COMMENT '商品图片3',
  `logourl3` varchar(200) DEFAULT NULL COMMENT '商品图片链接3',
  `info` mediumtext COMMENT '商品描述',
  `guize` mediumtext,
  `original` float(10,2) NOT NULL COMMENT '原价',
  `minimum` float(10,2) NOT NULL COMMENT '底价',
  `starttime` int(20) NOT NULL COMMENT '开始时间',
  `inventory` int(20) NOT NULL COMMENT '库存',
  `qdao` int(11) DEFAULT NULL COMMENT '前n刀',
  `qprice` int(20) DEFAULT NULL COMMENT '前n刀砍去多少钱',
  `dao` int(11) DEFAULT NULL COMMENT '总共需要n刀',
  `pv` int(11) NOT NULL DEFAULT '0',
  `state` int(11) NOT NULL DEFAULT '1' COMMENT '开始-关闭',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `is_new` int(11) NOT NULL DEFAULT '1',
  `kan_min` int(20) NOT NULL DEFAULT '0',
  `kan_max` int(20) NOT NULL DEFAULT '0',
  `rank_num` int(11) NOT NULL DEFAULT '10',
  `logotitle1` varchar(50) DEFAULT NULL,
  `logotitle2` varchar(50) DEFAULT NULL,
  `logotitle3` varchar(50) DEFAULT NULL,
  `is_attention` int(10) unsigned NOT NULL DEFAULT '1',
  `is_reg` int(10) unsigned NOT NULL DEFAULT '1',
  `is_subhelp` int(10) unsigned NOT NULL DEFAULT '1',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sku_id` int(10) unsigned NOT NULL DEFAULT '0',
  `delete_flag` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`pigcms_id`),
  KEY `token` (`token`),
  KEY `name` (`name`),
  KEY `state` (`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_bargain
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_bargain_kanuser`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_bargain_kanuser`;
CREATE TABLE `pigcms_bargain_kanuser` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) NOT NULL,
  `wecha_id` varchar(200) NOT NULL,
  `bargain_id` int(11) NOT NULL,
  `orderid` varchar(30) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `friend` varchar(100) NOT NULL,
  `dao` int(20) NOT NULL,
  `addtime` int(11) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `token` (`token`),
  KEY `wecha_id` (`wecha_id`),
  KEY `bargain_id` (`bargain_id`),
  KEY `orderid` (`orderid`),
  KEY `friend` (`friend`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_bargain_kanuser
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_bond_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_bond_record`;
CREATE TABLE `pigcms_bond_record` (
  `bond_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_no` varchar(50) NOT NULL DEFAULT '0' COMMENT '主订单号',
  `transaction_no` varchar(50) NOT NULL DEFAULT '0' COMMENT '交易单号',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品最终供货商id',
  `wholesale_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品经销商',
  `add_time` varchar(50) NOT NULL DEFAULT '0' COMMENT '记录生成时间',
  `status` tinyint(6) NOT NULL DEFAULT '0' COMMENT '状态  0 进行中 1 交易完成 2 退款',
  `deduct_bond` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '扣除的保证金',
  `residue_bond` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余的保证金',
  PRIMARY KEY (`bond_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_bond_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_business_hour`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_business_hour`;
CREATE TABLE `pigcms_business_hour` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `is_open` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_business_hour
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_cash_provision_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_cash_provision_log`;
CREATE TABLE `pigcms_cash_provision_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作金额',
  `point` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返还/发放的积分',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 交易完成平台添加备付金 1 积分发放扣除备付金 2 积分兑现提现扣备付金',
  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `add_date` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期',
  `cash_provision_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台备付金余额',
  PRIMARY KEY (`pigcms_id`),
  KEY `order_no` (`order_no`,`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='平台提现备付金流水';

-- ----------------------------
-- Records of pigcms_cash_provision_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_certification`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_certification`;
CREATE TABLE `pigcms_certification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `certification_info` text NOT NULL COMMENT '认证信息',
  `supplier_id` int(11) NOT NULL COMMENT '供货商',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_certification
-- ----------------------------
INSERT INTO `pigcms_certification` VALUES ('75', '1', 'a:0:{}', '0');
INSERT INTO `pigcms_certification` VALUES ('76', '1', 'a:0:{}', '0');
INSERT INTO `pigcms_certification` VALUES ('77', '9', 'a:0:{}', '0');
INSERT INTO `pigcms_certification` VALUES ('78', '12', 'a:0:{}', '0');
INSERT INTO `pigcms_certification` VALUES ('79', '17', 'a:0:{}', '0');

-- ----------------------------
-- Table structure for `pigcms_chahui`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_chahui`;
CREATE TABLE `pigcms_chahui` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `physical_id` int(11) NOT NULL,
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
  `tickets` int(10) DEFAULT NULL,
  `zt` text,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`physical_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_chahui
-- ----------------------------
INSERT INTO `pigcms_chahui` VALUES ('4', '18', '1', '010', '88888839', '110000', '110100', '110101', '啊撒的发反反复复反复烦烦烦', '116.437190', '39.935091', '1444637351', '北京朝阳大忠臣店', 'images/000/000/037/201509/55fa196c81d52.jpg,images/000/000/037/201509/55f92c900830f.jpg', '8:00-17:00', '大厦法定', 'https://www.baidu.com/', '1', null);
INSERT INTO `pigcms_chahui` VALUES ('5', '18', '1', '010', '666666', '110000', '110100', '110101', '啊的撒发生大幅', '116.404150', '39.923389', '1444637359', '北京天安门店', 'images/000/000/037/201509/55f92c900830f.jpg', '', '', '', '2', null);
INSERT INTO `pigcms_chahui` VALUES ('6', '18', '1', '', '1323123123', '110000', '110100', '110106', 'adfasdfasdfasdf ', '116.409925', '39.913393', '1444637365', '精品蔬菜', 'images/000/000/037/201509/55fa196c81d52.jpg', '', '', 'https://www.baidu.com/', '3', null);
INSERT INTO `pigcms_chahui` VALUES ('7', '18', '1', '', '', '', '', '', '', '0.000000', '0.000000', '1451295721', '', 'images/000/000/038/201512/5680e51681708.jpg', '', '', '', '0', null);
INSERT INTO `pigcms_chahui` VALUES ('8', '18', '1', '', '', '', '', '', '', '0.000000', '0.000000', '1451295788', '', 'images/000/000/038/201512/5680e50245d4b.jpg', '', '', '', '0', null);
INSERT INTO `pigcms_chahui` VALUES ('9', '18', '1', '', '', '', '', '', '', '0.000000', '0.000000', '1451295901', '22222222222', 'images/000/000/038/201512/5680e50245d4b.jpg', '', '', '', '0', null);
INSERT INTO `pigcms_chahui` VALUES ('10', '18', '1', '', '', '130000', '130300', '130304', '北京', '119.491109', '39.840968', '1451296595', '爱的方式是是是是', 'images/000/000/038/201512/5680e51681708.jpg', '12', '阿士大夫', '', '1', null);
INSERT INTO `pigcms_chahui` VALUES ('12', '18', '1', '2015-12-01 00:00:00', '2016-01-25 00:00:00', '110000', '110100', '110105', '鸟巢', '116.402131', '39.999448', '1451355732', '不错的茶会啊阿士大夫阿萨德', 'images/000/000/036/201509/55f6942581e9d.jpg', '12', '阿斯顿发送到发送到', '21312', '2', '');
INSERT INTO `pigcms_chahui` VALUES ('14', '18', '1', '', '', '110000', '110100', '110102', '王府井', '116.351997', '39.913514', '1451356693', '奥德赛烦烦烦烦烦烦烦烦烦烦发', 'images/000/000/036/201509/55f66bf125f2a.jpg', '14', '阿凡达是是是是是是是是是', '2321', '2', '');
INSERT INTO `pigcms_chahui` VALUES ('15', '18', '1', '', '', '110000', '110100', '110101', '方式大发', '117.092378', '36.207827', '1464933118', '挨打反反复复反复反复55', 'images/000/000/036/201509/55f6942581e9d.jpg', '', '', '', '1', '');
INSERT INTO `pigcms_chahui` VALUES ('16', '18', '0', '2016-07-22 20:49:00', '2016-08-31 15:45:00', '330000', '330300', '330304', '好', '120.627453', '27.989653', '1464935172', '新的茶会~哇卡卡卡', 'images/000/000/018/201606/575122f341066.jpg', '12', '', '55', '1', '');

-- ----------------------------
-- Table structure for `pigcms_chahui_bm`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_chahui_bm`;
CREATE TABLE `pigcms_chahui_bm` (
  `cid` int(30) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pigcms_chahui_bm
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_clear_return_owe_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_clear_return_owe_log`;
CREATE TABLE `pigcms_clear_return_owe_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '经销商id',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '销账金额',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '销账记录类型 0 退货欠款 ',
  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`,`supplier_id`) USING BTREE,
  KEY `add_time` (`add_time`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='退货欠款记录';

-- ----------------------------
-- Records of pigcms_clear_return_owe_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_comment`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_comment`;
CREATE TABLE `pigcms_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单表ID,对产品评论时，要加订单ID，其它为0',
  `relation_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '满意度，1-5，数值越大，满意度越高',
  `logistics_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '物流满意度，1-5，数值越大，满意度越高',
  `description_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '描述相符，1-5，数值越大，满意度越高',
  `speed_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '发货速度，1-5，数值越大，满意度越高',
  `service_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '服务态度，1-5，数值越大，满意度越高',
  `type` enum('PRODUCT','STORE') NOT NULL DEFAULT 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',
  `has_image` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有图片，1为有，0为没有',
  `content` text NOT NULL COMMENT '评论内容',
  `reply_number` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `relation_id` (`relation_id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='评论表';

-- ----------------------------
-- Records of pigcms_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_comment_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_comment_attachment`;
CREATE TABLE `pigcms_comment_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '评论表ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为图片，1为语音，2为视频',
  `file` varchar(100) DEFAULT NULL COMMENT '文件地址',
  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小，byte字节数',
  `width` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片宽度',
  `height` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片高度',
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `cid` (`cid`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='评论附件表';

-- ----------------------------
-- Records of pigcms_comment_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_comment_reply`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_comment_reply`;
CREATE TABLE `pigcms_comment_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',
  `cid` int(11) unsigned NOT NULL COMMENT '评论表ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `content` text COMMENT '回复内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `cid` (`cid`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='评论回复表';

-- ----------------------------
-- Records of pigcms_comment_reply
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_comment_tag`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_comment_tag`;
CREATE TABLE `pigcms_comment_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '评论表ID',
  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统标签表ID',
  `relation_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',
  `type` enum('PRODUCT','STORE') NOT NULL DEFAULT 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `cid` (`cid`) USING BTREE,
  KEY `tag_id` (`tag_id`,`relation_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_comment_tag
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_commonweal_address`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_commonweal_address`;
CREATE TABLE `pigcms_commonweal_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `title` varchar(256) DEFAULT NULL COMMENT '送公益标题',
  `name` varchar(50) NOT NULL COMMENT '收货人',
  `tel` varchar(20) NOT NULL COMMENT '联系电话',
  `province` mediumint(9) NOT NULL DEFAULT '0' COMMENT '省code',
  `city` mediumint(9) NOT NULL DEFAULT '0' COMMENT '市code',
  `area` mediumint(9) NOT NULL DEFAULT '0' COMMENT '区code',
  `address` varchar(256) NOT NULL COMMENT '详细地址',
  `zipcode` varchar(10) DEFAULT NULL COMMENT '邮编',
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认收货地址,1:是，0:否',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='送公益收货地址';

-- ----------------------------
-- Records of pigcms_commonweal_address
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_common_data`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_common_data`;
CREATE TABLE `pigcms_common_data` (
  `pigcms_id` int(5) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL DEFAULT '' COMMENT '字段名',
  `value` varchar(500) NOT NULL DEFAULT '' COMMENT '字段值',
  `bak` varchar(100) DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`pigcms_id`),
  UNIQUE KEY `key` (`key`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='公用数据';

-- ----------------------------
-- Records of pigcms_common_data
-- ----------------------------
INSERT INTO `pigcms_common_data` VALUES ('1', 'store_qty', '22', '店铺数');
INSERT INTO `pigcms_common_data` VALUES ('2', 'drp_seller_qty', '0', '分销商数');
INSERT INTO `pigcms_common_data` VALUES ('3', 'product_qty', '1', '商品数');
INSERT INTO `pigcms_common_data` VALUES ('4', 'income', '0', '平台收入');
INSERT INTO `pigcms_common_data` VALUES ('5', 'withdrawal', '0', '已提现');
INSERT INTO `pigcms_common_data` VALUES ('6', 'total', '0', '总收款');
INSERT INTO `pigcms_common_data` VALUES ('7', 'margin', '0', '平台保证金总额');
INSERT INTO `pigcms_common_data` VALUES ('8', 'promotion_reward', '0', '平台推广奖励总额');
INSERT INTO `pigcms_common_data` VALUES ('9', 'cash_provision_balance', '0', '平台提现备付金余额');
INSERT INTO `pigcms_common_data` VALUES ('16', 'trade_net_income', '0.00', '交易纯收入（不含备付金和推广奖励）');
INSERT INTO `pigcms_common_data` VALUES ('17', 'withdrawal_service_fee', '0.00', '提现服务费');
INSERT INTO `pigcms_common_data` VALUES ('18', 'margin_withdrawal', '0.00', '保证金已提现金额');

-- ----------------------------
-- Table structure for `pigcms_company`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_company`;
CREATE TABLE `pigcms_company` (
  `company_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '公司id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '公司名',
  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '市',
  `area` varchar(30) NOT NULL DEFAULT '' COMMENT '区',
  `address` varchar(500) NOT NULL DEFAULT '' COMMENT '地址',
  PRIMARY KEY (`company_id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_company
-- ----------------------------
INSERT INTO `pigcms_company` VALUES ('1', '6', '111111', '120000', '120100', '120101', '111111333');
INSERT INTO `pigcms_company` VALUES ('2', '7', '111111', '110000', '110100', '110101', '1111');
INSERT INTO `pigcms_company` VALUES ('3', '5', '111111', '110000', '110100', '110101', '111111333');
INSERT INTO `pigcms_company` VALUES ('4', '8', '111', '110000', '110100', '110101', '1111');
INSERT INTO `pigcms_company` VALUES ('5', '9', '高大上呀', '340000', '340100', '340186', '天鹅湖路');

-- ----------------------------
-- Table structure for `pigcms_concern_relationship`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_concern_relationship`;
CREATE TABLE `pigcms_concern_relationship` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL COMMENT '当前用户id （如果是活动就是参于者 id）',
  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商id',
  `store_id` int(11) unsigned NOT NULL COMMENT '当前店铺id',
  `type` tinyint(2) unsigned NOT NULL COMMENT '1 店铺推广 2 活动',
  `act_type` varchar(50) NOT NULL COMMENT '活动类型如 seckill（秒杀） bargain（砍价）。。。。',
  `act_id` int(11) unsigned NOT NULL COMMENT '活动ID',
  `help_uid` char(50) NOT NULL COMMENT '活动帮助者uid',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_concern_relationship
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_config`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_config`;
CREATE TABLE `pigcms_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` varchar(150) NOT NULL COMMENT '多个默认值用|分隔',
  `value` text NOT NULL,
  `info` varchar(20) NOT NULL,
  `desc` varchar(250) NOT NULL,
  `tab_id` varchar(20) NOT NULL DEFAULT '0' COMMENT '小分组ID',
  `tab_name` varchar(20) NOT NULL COMMENT '小分组名称',
  `gid` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  UNIQUE KEY `name_3` (`name`),
  KEY `gid` (`gid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='配置表';

-- ----------------------------
-- Records of pigcms_config
-- ----------------------------
INSERT INTO `pigcms_config` VALUES ('1', 'site_name', 'type=text&validate=required:true', 'e点茶微商城', '网站名称', '网站的名称', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('2', 'site_url', 'type=text&validate=required:true,url:true', 'http://www.ediancha.com', '网站网址', '请填写网站的网址，包含（http://域名）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('3', 'site_logo', 'type=image&validate=required:true,url:true', 'http://www.ediancha.com/upload/images/default_logo.png', '网站LOGO', '请填写LOGO的网址，包含（http://域名）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('4', 'site_qq', 'type=text&validate=qq:true', '35655288', '联系QQ', '前台涉及到需要显示QQ的地方，将显示此值！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('5', 'site_email', 'type=text&validate=email:true', '35655288@qq.com', '联系邮箱', '前台涉及到需要显示邮箱的地方，将显示此值！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('6', 'site_icp', 'type=text', '京ICP备15000598号-3', 'ICP备案号', '可不填写。放置于大陆的服务器，需要网站备案。', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('7', 'seo_title', 'type=text&size=80&validate=required:true', 'e点茶微商城', 'SEO标题', '一般不超过80个字符！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('8', 'seo_keywords', 'type=text&size=80', 'e点茶微商城', 'SEO关键词', '一般不超过100个字符！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('9', 'seo_description', 'type=textarea&rows=4&cols=93', 'e点茶是北京东方盈科技有限公司自主研发的一款专门针对茶馆行业的移动营销系统。该系统由针对茶馆的全方位展示、一键预约订座、在线卖茶、用户管理（CRM）、BOSS实时查看……等众多实用功能组成,协助把您的茶馆迅速切换到O2O模式,为您的“互联网+”战略实施保驾护航！', 'SEO描述', '一般不超过200个字符！', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('10', 'site_footer', 'type=textarea&rows=6&cols=93', '<div style=\"display:none;\"><script type=\"text/javascript\">var _bdhmProtocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");document.write(unescape(\"%3Cscript src=\'\" + _bdhmProtocol +\"hm.baidu.com/h.js%3F7be5e2c9d2a9f0232bb0b5a2085b65ad\' type=\'text/javascript\'%3E%3C/script%3E\"));</script></div>\r\n<p>Copyright ©2011-2015 北京东方盈科技有限公司</p>\r\n<p>联系电话：0551-65371998 / 0551-63474223 </p>', '网站底部信息', '可填写统计、客服等HTML代码，代码前台隐藏不可见！！', '0', '', '1', '0', '1');
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
INSERT INTO `pigcms_config` VALUES ('23', 'wap_site_url', 'type=text&size=80&validate=required:true', 'http://www.ediancha.com/wap', '手机版网站网址', '手机版网站网址，可使用二级域名', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('24', 'theme_wap_group', 'type=select&value=default:默认|theme1:其他', 'default', '平台商城模板', '选择非“默认模板”选项后“平台商城首页内容”设置将无法生效', '0', '', '11', '0', '0');
INSERT INTO `pigcms_config` VALUES ('25', 'wx_token', 'type=text', 'ediancha20150822', '公众号消息校验Token', '公众号消息校验Token', '0', '', '13', '0', '1');
INSERT INTO `pigcms_config` VALUES ('26', 'wx_appsecret', 'type=text', '0c79e1fa963cd80cc0be99b20a18faeb', '网页授权AppSecret', '网页授权AppSecret', '0', '', '13', '0', '1');
INSERT INTO `pigcms_config` VALUES ('27', 'wx_appid', 'type=text', 'wxfcde45ae669421c9', '网页授权AppID', '网页授权AppID', '0', '', '13', '0', '1');
INSERT INTO `pigcms_config` VALUES ('28', 'wx_componentverifyticket', 'type=text', 'ticket@@@y06xMq4-2TTJotDIp2hHsSAVRS_naDSQydBl8fhFQp9AN3CkcLCEFo27G3eB2vj_vi7oIQF2JcnfeLNceFPxEQ', '', '', '0', '', '0', '0', '1');
INSERT INTO `pigcms_config` VALUES ('29', 'orderid_prefix', 'type=text&size=20', 'YDC', '订单号前缀', '用户看到的订单号 = 订单号前缀+订单号', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('30', 'pay_alipay_open', 'type=radio&value=1:开启|0:关闭', '0', '开启', '', 'alipay', '支付宝', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('31', 'pay_alipay_name', 'type=text&size=80', '', '帐号', '', 'alipay', '支付宝', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('32', 'pay_alipay_pid', 'type=text&size=80', 'pigcms', 'PID', '', 'alipay', '支付宝', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('33', 'pay_alipay_key', 'type=text&size=80', 'pigcms', 'KEY', '', 'alipay', '支付宝', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('34', 'pay_tenpay_open', 'type=radio&value=1:开启|0:关闭', '0', '开启', '', 'tenpay', '财付通', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('35', 'pay_tenpay_partnerid', 'type=text&size=80', 'pigcms', '商户号', '', 'tenpay', '财付通', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('36', 'pay_tenpay_partnerkey', 'type=text&size=80', 'pigcms', '密钥', '', 'tenpay', '财付通', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('37', 'pay_yeepay_open', 'type=radio&value=1:开启|0:关闭', '0', '开启', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('38', 'pay_yeepay_merchantaccount', 'type=text&size=80', 'pigcms', '商户编号', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('39', 'pay_yeepay_merchantprivatekey', 'type=text&size=80', 'pigcms', '商户私钥', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('40', 'pay_yeepay_merchantpublickey', 'type=text&size=80', 'pigcms', '商户公钥', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('41', 'pay_yeepay_yeepaypublickey', 'type=text&size=80', 'pigcms', '易宝公钥', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('42', 'pay_yeepay_productcatalog', 'type=text&size=80', '1', '商品类别码', '', 'yeepay', '银行卡支付（易宝）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('43', 'pay_allinpay_open', 'type=radio&value=1:开启|0:关闭', '0', '开启', '', 'allinpay', '银行卡支付（通联）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('44', 'pay_allinpay_merchantid', 'type=text&size=80', 'pigcms', '商户号', '多个帐号用逗号‘,’隔开，顺序为：普通交易货款,积分保证金', 'allinpay', '银行卡支付（通联）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('45', 'pay_allinpay_merchantkey', 'type=text&size=80', 'pigcms', 'MD5 KEY', '多个帐号用逗号‘,’隔开，顺序为：普通交易货款,积分保证金', 'allinpay', '银行卡支付（通联）', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('46', 'pay_weixin_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'weixin', '微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('47', 'pay_weixin_appid', 'type=text&size=80', 'wx66b321d2b6ceb5a3', 'Appid', '微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看。', 'weixin', '微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('48', 'pay_weixin_mchid', 'type=text&size=80', '1266249101', 'Mchid', '受理商ID，身份标识', 'weixin', '微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('49', 'pay_weixin_key', 'type=text&size=80', 'eastprofit20141202py0916edianhca', 'Key', '商户支付密钥Key。审核通过后，在微信发送的邮件中查看。', 'weixin', '微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('50', 'wx_encodingaeskey', 'type=text', 'yidiancha20150822dongfangying20141202pangyi', '公众号消息加解密Key', '公众号消息加解密Key', '0', '', '13', '0', '1');
INSERT INTO `pigcms_config` VALUES ('51', 'wechat_appid', 'type=text&validate=required:true', 'wx66b321d2b6ceb5a3', 'AppID', 'AppID', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('52', 'wechat_appsecret', 'type=text&validate=required:true', '8ce5f0edd046ea8bb1ea4e77b8983e46', 'AppSecret', 'AppSecret', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('53', 'bbs_url', 'type=text&validate=required:false', 'http://www.ediancha.com', '交流论坛网址', '商家用于交流的论坛网址，需自行搭建', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('54', 'user_store_num_limit', 'type=text&size=20', '-1', '开店数限制', '限制开店数量，-1为不限制', '0', '每个用户最多可开店数限制，0为不限', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('55', 'sync_login_key', '', 'KKgybUkzUqrBGwCTgnAhKmqJmrzfZajJUnZenBZEVQN', '', '', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('56', 'is_check_mobile', '', '0', '手机号验证', '手机号验证', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('57', 'readme_title', 'type=text', '微商城代理销售服务和结算协议', '开店协议标题', '开店协议标题', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('58', 'readme_content', 'type=textarea&rows=20&cols=93', '在向消费者销售及向供应商采购的过程中,分销商需遵守：\r\n\r\n1 分销商必须严格履行对消费者的承诺,分销商不得以其与供应商之间的约定对抗其对消费者的承诺,如果分销商与供应商之间的约定不清或不能覆盖分销商对消费者的销售承诺,风险由分销商自行承担；分销商与买家出现任何纠纷,均应当依据淘宝相关规则进行处理；\r\n\r\n2 分销商承诺其最终销售给消费者的分销商品零售价格符合与供应商的约定；\r\n\r\n3 在消费者（买家）付款后,分销商应当及时向供应商支付采购单货款,否则7天后系统将关闭采购单交易,分销商应当自行承担因此而发生的交易风险；\r\n\r\n4 分销商应当在系统中及时同步供应商的实际产品库存,无论任何原因导致买家拍下后无货而产生的纠纷,均应由分销商自行承担风险与责任；\r\n\r\n5 分销商承诺分销商品所产生的销售订单均由分销平台相应的的供应商供货,以保证分销商品品质；\r\n\r\n6 分销商有义务确认消费者（买家）收货地址的有效性；\r\n\r\n7 分销商有义务在买家收到货物后,及时确认货款给供应商。如果在供应商发出货物30天后,分销商仍未确认收货,则系统会自动确认收货并将采购单对应的货款支付给供应商。', '开店协议内容', '用户开店前必须先阅读并同意该协议', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('59', 'max_store_drp_level', 'type=text&size=10', '3', '分销级别', '允许分销的最大级别，0或空为无限级分销', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('60', 'open_store_drp', 'type=radio&value=1:开启|0:关闭', '1', '分销开关', '', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('61', 'open_platform_drp', 'type=radio&value=1:开启|0:关闭', '1', '全网分销', '', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('62', 'platform_mall_index_page', 'type=page&validate=required:true,number:true', '5', '平台商城首页内容', '选择一篇微页面作为平台商城首页的内容', '0', '', '11', '1', '1');
INSERT INTO `pigcms_config` VALUES ('63', 'platform_mall_open', 'type=radio&value=1:开启|0:关闭', '1', '是否开启平台商城', '如果不开启平台商城，则首页将显示为宣传介绍页面！否则显示平台商城', '0', '', '11', '2', '1');
INSERT INTO `pigcms_config` VALUES ('64', 'theme_index_group', '', 'default', '', '', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('65', 'wechat_qrcode', 'type=image&validate=required:true,url:true', 'http://www.ediancha.com/static/wechat_qrcode.jpg', '公众号二维码', '您的公众号二维码', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('66', 'wechat_name', 'type=text&validate=required:true', 'e点茶', '公众号名称', '公众号的名称', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('67', 'wechat_sourceid', 'type=text&validate=required:true', 'gh_72ff8ec3dcb0', '公众号原始id', '公众号原始id', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('68', 'wechat_id', 'type=text&validate=required:true', 'ediancha', '微信号', '微信号', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('69', 'wechat_token', 'type=text&validate=required:true', 'ac2a8c528481fac73c958baa6f0326c6', '微信验证TOKEN', '微信验证TOKEN', '0', '', '8', '0', '0');
INSERT INTO `pigcms_config` VALUES ('70', 'wechat_encodingaeskey', 'type=text', 'st0eMTgrxxmo9vtrUoTAIgsGkCEV1geqDNCKdrPnoKc', 'EncodingAESKey', '公众号消息加解密Key,在使用安全模式情况下要填写该值，请先在管理中心修改，然后填写该值，仅限服务号和认证订阅号', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('71', 'wechat_encode', 'type=select&value=0:明文模式|1:兼容模式|2:安全模式', '0', '消息加解密方式', '如需使用安全模式请在管理中心修改，仅限服务号和认证订阅号', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('72', 'web_login_show', 'type=select&value=0:两种方式|1:仅允许帐号密码登录|2:仅允许微信扫码登录', '0', '用户登录电脑网站的方式', '用户登录电脑网站的方式', '0', '', '2', '0', '1');
INSERT INTO `pigcms_config` VALUES ('73', 'store_pay_weixin_open', 'type=radio&value=1:开启|0:关闭', '1', '开启', '', 'store_weixin', '商家微信支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('74', 'im_appid', '', '9307', '', '', '0', '', '0', '0', '1');
INSERT INTO `pigcms_config` VALUES ('75', 'im_appkey', '', 'a8d69db14640bee5b1ae371db8407217', '', '', '0', '', '0', '0', '1');
INSERT INTO `pigcms_config` VALUES ('76', 'attachment_upload_type', 'type=select&value=0:保存到本服务器|1:保存到又拍云', '0', '附件保存方式', '附件保存方式', 'base', '基础配置', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('77', 'attachment_up_bucket', 'type=text&size=50', 'pigcms22', 'BUCKET', 'BUCKET', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('78', 'attachment_up_form_api_secret', 'type=text&size=50', 'qFD6DLf02lRwAjvveQVgyjh90Y0=', 'FORM_API_SECRET', 'FORM_API_SECRET', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('79', 'attachment_up_username', 'type=text&size=50', 'pigcms', '操作员用户名', '操作员用户名', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('80', 'attachment_up_password', 'type=text&size=50', 'pigcms123456', '操作员密码', '操作员密码', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('81', 'attachment_up_domainname', 'type=text&size=50', 'pigcms22.b0.upaiyun.com', '云存储域名', '云存储域名 不包含http://', 'upyun', '又拍云', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('83', 'notify_appid', '', 'aabbccddeeffgghhiijjkkllmmnn', '', '通知的appid', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('84', 'notify_appkey', '', 'aabbccddeeffgghhiijjkkll', '', '通知的KEY', '0', '', '0', '0', '0');
INSERT INTO `pigcms_config` VALUES ('85', 'is_diy_template', 'type=radio&value=1:开启|0:关闭', '1', '是否使用自定模板', '开启后平台商城首页将不使用微杂志。自定义模板目录/template/wap/default/theme', '0', '', '11', '3', '1');
INSERT INTO `pigcms_config` VALUES ('86', 'service_key', 'type=text&validate=required:false', '49f2ea69faf5bc459ec32f08f0db0182', '服务key', '请填写购买产品时的服务key', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('87', 'attachment_upload_unlink', 'type=select&value=0:不删除本地附件|1:删除本地附件', '0', '是否删除本地附件', '当附件存放在远程时，如果本地服务器空间充足，不建议删除本地附件', 'base', '基础配置', '14', '0', '1');
INSERT INTO `pigcms_config` VALUES ('88', 'syn_domain', 'type=text', 'http://y.ediancha.com', '营销活动地址', '部分功能需要调用平台内容，需要用到该网址', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('89', 'withdrawal_min_amount', 'type=text&validate=required:true,number:true', '0', '单次提现最低金额', '单次提现最低金额，0为不限', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('90', 'encryption', 'type=text', '5g0J1NG9CwDzlJIH7QKX5yxGeQ0dIu5npuE1LbLS', '营销活动key', '与平台对接时需要用到', '0', '', '8', '0', '1');
INSERT INTO `pigcms_config` VALUES ('91', 'is_allow_comment_control', 'type=select&value=1:允许商户管理评论|2:不允许商户管理评论', '2', '是否允许商户管理评论', '开启后，商户可对评论进行删、改操作', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('92', 'ischeck_to_show_by_comment', 'type=select&value=1:不需要审核评论才显示|0:需审核即可显示评论', '1', '评论是否需要审核显示', '开启后，需商家或管理员审核方可显示，反之：不需审核即可显示', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('95', 'pc_shopercenter_logo', 'type=image&validate=required:false,url:false', 'http://www.ediancha.com/upload/images/default_logo.png', '商家中心LOGO图', '请填写带LOGO的网址，包含（http://域名）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('96', 'sales_ratio', 'type=text&size=5&validate=required:true,number:true,maxlength:5,max:100', '2', '商家销售分成比例', '例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('98', 'weidian_key', 'type=salt', '5g0J1NG9CwDzlJIH7QKX5yxGeQ0dIu5npuE1LbLS', '微店KEY', '对接微店使用的KEY，请妥善保管', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('99', 'ischeck_store', 'type=select&value=1:开店需要审核|0:开店无需审核', '0', '开店是否要审核', '开启后，会员开店需要后台审核通过后，店铺才能正常使用', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('100', 'synthesize_store', '', '1', '是否有综合商城', '是否有综合商城', '0', '', '1', '0', '0');
INSERT INTO `pigcms_config` VALUES ('82', 'web_index_cache', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '0', 'PC端首页缓存时间', 'PC端首页缓存时间，0为不缓存', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('93', 'is_have_activity', 'type=radio&value=1:有|0:没有', '1', '活动', '首页是否需要展示营销活动', '0', '0', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('94', 'pc_usercenter_logo', 'type=image&validate=required:true,url:true', 'http://www.ediancha.com/upload/images/default_logo.png', 'PC-个人用户中心LOGO图', '请填写带LOGO的网址，包含（http://域名）', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('101', 'sms_topdomain', 'type=text&validate=required:true,url:true', '', '发送短信授权域名', '发送短信授权域名', '0', '平台短信平台', '15', '0', '1');
INSERT INTO `pigcms_config` VALUES ('102', 'sms_key', 'type=text&validate=required:true', '', '短信key', '短信的key（必填）', '0', '平台短信平台', '15', '0', '1');
INSERT INTO `pigcms_config` VALUES ('103', 'sms_price', 'type=text&validate=required:true,number:true,maxlength:2', '', '短信价格(单位:分)', '每条多少分钱(卖给客户的)', '0', '平台短信平台', '15', '0', '1');
INSERT INTO `pigcms_config` VALUES ('104', 'sms_sign', 'type=text&validate=required:true,maxlength:5', '', '短信签名', '短信的前缀（一起发送给客户的）', '0', '平台短信平台', '15', '0', '1');
INSERT INTO `pigcms_config` VALUES ('105', 'sms_test_mobile', 'type=otext&validate=required:false,mobile:true', '', '测试', '输入手机号以后，然后<a href=\'javascript:test_send_sms()\'>点击这里</a>进行测试', '0', '平台短信平台', '15', '0', '1');
INSERT INTO `pigcms_config` VALUES ('106', 'sms_open', 'type=radio&value=1:开启|0:关闭', '1', '短信是否开启', '在以上内容全部完整的情况下，开启有效', '0', '平台短信平台', '15', '0', '1');
INSERT INTO `pigcms_config` VALUES ('109', 'emergent_mode', 'type=radio&value=1:开启|0:关闭', '0', '紧急模式', '请不要随意开启，开启后会导致无法升级，使用短信等服务（接到小猪紧急通知时可开启此项）。', '0', '平台短信平台', '1', '0', '0');
INSERT INTO `pigcms_config` VALUES ('107', 'order_return_date', 'type=text&size=2&validate=required:true,number:true,maxlength:2', '7', '退货周期', '确认收货后多长时间内可以退货', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('108', 'order_complete_date', 'type=text&size=2&validate=required:true,number:true,maxlength:2', '15', '默认交易完成时间', '发货后，用户一直没有确认收货，此值为发货后的交易完成时间周期', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('110', 'weidian_version', '', '0', '微店版本', '微店版本 0 普通 1 对接', '0', '', '1', '0', '0');
INSERT INTO `pigcms_config` VALUES ('111', 'is_open_wap_login_sms_check', 'type=select&value=0:不开启微信短信注册验证|1:开启短信注册验证', '1', 'wap站注册短信验证', 'wap站注册是否开启短信验证', '0', '', '2', '0', '1');
INSERT INTO `pigcms_config` VALUES ('118', 'allow_agent_invite', 'type=radio&value=1:是|0:否', '1', '推广邀请码注册', '', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('119', 'lbs_distance_limit', 'type=text&validate=required:true,number:true,maxlength:5', '0', '前台LBS距离设定', '在扫码或能得到精确坐标后，将限定显示在此距离范围内的商家或商品数据(单位:km)', '0', '', '1', '0', '0');
INSERT INTO `pigcms_config` VALUES ('120', 'withdraw_limit', 'type=text&size=10&validate=required:true,number:true,min:0', '0', '提现审批金额限制', '大于该金额的提现记录不允许非超级管理员操作，0为不做限制', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('121', 'offline_money', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '0', '订单额度', '需要总管里员审核的订单额度，0表示不需要', '', '订单额度', '17', '0', '1');
INSERT INTO `pigcms_config` VALUES ('123', 'open_drp_team', 'type=radio&value=1:开启|0:关闭', '1', '分销团队', '是否允许店铺开启分销团队', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('122', 'open_drp_degree', 'type=radio&value=1:开启|0:关闭', '1', '分销等级', '', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('125', 'is_show_float_menu', 'type=radio&value=1:开启|0:关闭', '0', '是否显示浮动菜单', '开启后，wap店铺首页和商品详情页右下角将会显示浮动菜单', '0', '', '11', '0', '0');
INSERT INTO `pigcms_config` VALUES ('127', 'is_allow_diy_drp_degree', 'type=radio&value=1:开启|0:关闭', '1', '店铺自定义分销等级', '是否允许供货商自定义分销等级，修改平台设置的默认等级名称，图标', '0', '', '12', '0', '1');
INSERT INTO `pigcms_config` VALUES ('128', 'open_test_payment', 'type=radio&value=1:开启|0:禁用', '0', '测试支付', '慎用，不建议在运营或正式环境开启，仅用于内部测试。', 'test_pay', '平台测试支付', '7', '0', '1');
INSERT INTO `pigcms_config` VALUES ('129', 'is_need_sub_register', 'type=radio&value=1:开启|0:关闭', '0', '强制pc用户关注后再注册', '开启后，pc注册需要先扫码关注公众号', '0', '', '2', '0', '1');
INSERT INTO `pigcms_config` VALUES ('130', 'allow_store_public_display', 'type=radio&value=1:是|0:否', '1', '开启店铺综合展示', '', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('131', 'allow_account_pwd_confirm', 'type=radio&value=1:是|0:否', '0', '开启我的账号密码确认', '', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('132', 'reg_readme_content', 'type=textarea&rows=20&cols=93', '', '用户注册协议', '用户注册前必须先阅读并同意该协议', '0', '', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('133', 'is_change_bankcard_open', 'type=radio&value=1:是|0:否', '0', '店铺修改提现银行卡', '开启后，店铺可以自由修改提现银行卡账号。关闭后用户不能随意修改银行卡账号。', '0', '', '2', '0', '1');
INSERT INTO `pigcms_config` VALUES ('140', 'user_point_total', 'type=text&size=20&validate=required:true,number:true,maxlength:10', '0', '用户积分购买', '当用户所有积分总额（待释放+可用）超过此值，用户不能用现金购物，不能受赠，0表示不限', '', '用户积分购买', '17', '0', '1');
INSERT INTO `pigcms_config` VALUES ('141', 'store_point_total', 'type=text&size=20&validate=required:true,number:true,maxlength:10', '0', '店铺每日做单限额', '商家每日做单，返送的积分，达到此值，当日就不能再次做单了，0表示不限', '', '店铺每日做单限额', '17', '0', '1');
INSERT INTO `pigcms_config` VALUES ('142', 'platform_weixin_open', 'type=radio&value=1:开启|0:关闭', '0', '开启', '平台保证金充值帐户', 'platform_weixin', '微信支付', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('143', 'platform_wechat_appid', 'type=text&size=80', '', 'AppID', 'AppID', 'platform_weixin', '微信支付', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('144', 'platform_wechat_appsecret', 'type=text&size=80', '', 'AppSecret', 'AppSecret', 'platform_weixin', '微信支付', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('145', 'platform_weixin_appid', 'type=text&size=80', '', 'Appid', '微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看。', 'platform_weixin', '微信支付', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('146', 'platform_weixin_mchid', 'type=text&size=80', '', 'Mchid', '受理商ID，身份标识', 'platform_weixin', '微信支付', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('147', 'platform_weixin_key', 'type=text&size=80', '', 'Key', '商户支付密钥Key。审核通过后，在微信发送的邮件中查看。', 'platform_weixin', '微信支付', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('148', 'platform_alipay_open', 'type=radio&value=1:开启|0:关闭', '0', '开启', '平台保证金充值帐户', 'platform_alipay', '支付宝', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('149', 'platform_alipay_name', 'type=text&size=80', '', '帐号', '', 'platform_alipay', '支付宝', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('150', 'platform_alipay_pid', 'type=text&size=80', '', 'PID', '', 'platform_alipay', '支付宝', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('151', 'platform_alipay_key', 'type=text&size=80', '', 'KEY', '', 'platform_alipay', '支付宝', '16', '0', '1');
INSERT INTO `pigcms_config` VALUES ('160', 'is_show_credit', 'type=radio&value=1:是|0:否', '1', '是否展示诚信', '产品详情页是否展示诚信内容', '0', '0', '1', '0', '1');
INSERT INTO `pigcms_config` VALUES ('134', 'wap_login_bind', 'type=select&value=1:绑定手机号登录|0:静默登录|2:手机号密码登录', '0', 'wap端登录模式', '0:静默登录,1:绑定手机号登录,2:手机号密码登录', '0', '', '2', '0', '1');

-- ----------------------------
-- Table structure for `pigcms_config_group`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_config_group`;
CREATE TABLE `pigcms_config_group` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `gname` char(20) NOT NULL,
  `gsort` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='配置分组';

-- ----------------------------
-- Records of pigcms_config_group
-- ----------------------------
INSERT INTO `pigcms_config_group` VALUES ('1', '基础配置', '10', '1');
INSERT INTO `pigcms_config_group` VALUES ('2', '会员配置', '9', '1');
INSERT INTO `pigcms_config_group` VALUES ('7', '支付配置', '4', '1');
INSERT INTO `pigcms_config_group` VALUES ('8', '平台公众号配置', '3', '1');
INSERT INTO `pigcms_config_group` VALUES ('11', '微信版商城配置', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('12', '分销配置', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('13', '店铺绑定公众号配置', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('14', '附件配置', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('15', '平台短信接口配置', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('17', '店铺自主做单', '0', '1');
INSERT INTO `pigcms_config_group` VALUES ('16', '保证金支付配置', '0', '1');

-- ----------------------------
-- Table structure for `pigcms_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_coupon`;
CREATE TABLE `pigcms_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `name` varchar(255) NOT NULL COMMENT '优惠券名称',
  `face_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券面值(起始)',
  `limit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',
  `most_have` int(11) NOT NULL COMMENT '单人最多拥有优惠券数量（0：不限制）',
  `total_amount` int(11) NOT NULL COMMENT '发放总量',
  `start_time` int(11) NOT NULL COMMENT '生效时间',
  `end_time` int(11) NOT NULL COMMENT '过期时间',
  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',
  `is_share` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',
  `is_all_product` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',
  `is_original_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',
  `timestamp` int(11) NOT NULL COMMENT '添加优惠券的时间',
  `description` text NOT NULL COMMENT '使用说明',
  `used_number` int(11) NOT NULL DEFAULT '0' COMMENT '已使用数量',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '已领取数量',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否失效（0：失效；1：未失效）',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '券类型（1：优惠券； 2:赠送券）',
  UNIQUE KEY `id` (`id`),
  KEY `uid` (`uid`,`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='优惠券';

-- ----------------------------
-- Records of pigcms_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_coupon_to_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_coupon_to_product`;
CREATE TABLE `pigcms_coupon_to_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) NOT NULL COMMENT '优惠券id',
  `product_id` int(11) NOT NULL COMMENT '产品id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`),
  KEY `coupon_id` (`coupon_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='优惠券产品对应表';

-- ----------------------------
-- Records of pigcms_coupon_to_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_credit_deposit_flow`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_credit_deposit_flow`;
CREATE TABLE `pigcms_credit_deposit_flow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL COMMENT '保证金流水订单id',
  `order_no` varchar(100) NOT NULL COMMENT '订单号',
  `store_id` int(11) unsigned NOT NULL COMMENT '来源商铺id',
  `money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '方式类型:1.充值2.扣除',
  `msg` varchar(255) NOT NULL COMMENT '内容',
  `timestamp` int(11) unsigned NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保证金流水';

-- ----------------------------
-- Records of pigcms_credit_deposit_flow
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_credit_flow`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_credit_flow`;
CREATE TABLE `pigcms_credit_flow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL COMMENT '保证金流水订单id',
  `order_no` varchar(100) NOT NULL COMMENT '订单号',
  `store_id` int(11) unsigned NOT NULL COMMENT '商户id',
  `uid` int(11) unsigned NOT NULL COMMENT '用户uid',
  `u_credit` int(11) unsigned NOT NULL COMMENT '用户积分值',
  `u_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户积分值类型：0为扣除,1为增加',
  `s_credit` int(11) unsigned NOT NULL COMMENT '店铺积分值',
  `s_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '店铺积分值类型：0为扣除,1为增加',
  `p_credit` int(11) unsigned NOT NULL COMMENT '平台积分值',
  `p_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '平台积分值类型：0为扣除,1为增加',
  `msg` varchar(255) NOT NULL COMMENT '内容',
  `timestamp` int(11) unsigned NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`),
  UNIQUE KEY `order_no` (`order_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='积分流水表';

-- ----------------------------
-- Records of pigcms_credit_flow
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_credit_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_credit_setting`;
CREATE TABLE `pigcms_credit_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `platform_credit_open` tinyint(1) NOT NULL COMMENT '开启平台积分(0不开启,1开启)',
  `force_use_platform_credit` tinyint(1) unsigned NOT NULL COMMENT '强制开启平台积分(1.开启|0.关闭)',
  `store_credit_open` tinyint(1) NOT NULL COMMENT '开启店铺积分(0不开启,1开启)',
  `platform_credit_name` varchar(50) NOT NULL COMMENT '平台积分前端展示名称',
  `platform_credit_points` varchar(80) NOT NULL COMMENT '用户可以获得的发放点数',
  `credit_deposit_ratio` decimal(5,2) unsigned NOT NULL COMMENT '积分保证金扣除比例',
  `cash_min_amount` int(10) unsigned NOT NULL COMMENT '保证金充值最小额度',
  `cash_provisions` decimal(5,2) unsigned NOT NULL COMMENT '提现备付金',
  `credit_flow_charges` decimal(5,2) unsigned NOT NULL COMMENT '积分流转手续费',
  `storecredit_to_money_charges` decimal(5,2) unsigned NOT NULL COMMENT '店铺积分变现手续费',
  `online_trade_money` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '线上订单现金积分比（现金）',
  `online_trade_credit_type` tinyint(1) unsigned NOT NULL COMMENT '线上订单赠送积分基数(0为订单全额,1为现金部分)',
  `offline_trade_money` decimal(5,2) unsigned NOT NULL COMMENT '线下做单现金积分比（现金）',
  `offline_trade_credit_type` tinyint(1) unsigned NOT NULL COMMENT '线下做单赠送积分基数(0为订单全额,1为现金部分)',
  `offline_trade_store_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '线下店铺做单赠送积分基数',
  `platform_credit_rule` int(11) unsigned NOT NULL COMMENT '平台生成规则设置:1元消费额等于xx积分',
  `platform_credit_use_value` int(11) unsigned NOT NULL COMMENT '使用价值设置:1元人民币等于xx积分',
  `credit_weight` int(11) unsigned NOT NULL COMMENT '积分权数值',
  `today_credit_weight` float(8,2) unsigned NOT NULL COMMENT '今日积分权数值',
  `day_send_credit_time` varchar(10) NOT NULL DEFAULT '00' COMMENT '每日默认发送积分时间',
  `share_qrcode_effective_click` int(11) NOT NULL COMMENT '分享二维码点击（有效点击数设置）',
  `share_qrcode_credit` int(11) NOT NULL COMMENT '分享二维码点击（送积分设置）',
  `follow_platform_credit` int(11) NOT NULL COMMENT '关注平台二维码可得积分(首次)',
  `recommend_follow_self_credit` int(11) NOT NULL COMMENT '推荐别人关注自身可得积分(每次)',
  `recharge_notice_open` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '保证金余额不足通知',
  `recharge_notice_maxcount` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '单日最大通知次数',
  `open_user_give_point` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启用户互赠积分',
  `give_point_service_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户互赠积分服务费',
  `min_margin_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '保证金最低余额',
  `open_promotion_reward` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启推广奖励',
  `promotion_reward_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '默认推广奖励',
  `open_margin_withdrawal` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '充值金额的余额是否可提现 0 可以 1 不可以',
  `margin_withdrawal_amount_min` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '最低提现额度',
  `auto_send` tinyint(1) unsigned NOT NULL COMMENT '自动释放积分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='积分配置表';

-- ----------------------------
-- Records of pigcms_credit_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_custom_field`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_custom_field`;
CREATE TABLE `pigcms_custom_field` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `module_name` varchar(20) NOT NULL,
  `module_id` int(11) NOT NULL,
  `field_type` varchar(20) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`field_id`),
  KEY `store_id_2` (`store_id`,`module_name`,`module_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=129 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='自定义字段';

-- ----------------------------
-- Records of pigcms_custom_field
-- ----------------------------
INSERT INTO `pigcms_custom_field` VALUES ('1', '1', 'page', '1', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-26 15:29\";}');
INSERT INTO `pigcms_custom_field` VALUES ('2', '1', 'page', '1', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('15', '3', 'page', '5', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=2\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"2\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=2\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"3\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=2\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('5', '2', 'page', '2', 'image_ad', 'a:3:{s:10:\"max_height\";s:3:\"542\";s:9:\"max_width\";s:3:\"532\";s:8:\"nav_list\";a:1:{i:0;a:5:{s:5:\"title\";s:0:\"\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:74:\"http://www.ediancha.com/upload/images/000/000/002/201605/5746a80a22d77.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('6', '3', 'page', '3', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('7', '3', 'page', '3', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('8', '3', 'page', '3', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=3\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"2\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=1\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"3\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=3\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('9', '3', 'page', '4', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('10', '3', 'page', '4', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('11', '3', 'page', '4', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('12', '3', 'page', '5', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('13', '3', 'page', '5', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('14', '3', 'page', '5', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('39', '8', 'page', '13', 'image_ad', 'a:4:{s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:10:\"image_type\";s:1:\"1\";s:8:\"nav_list\";a:1:{i:0;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('40', '8', 'page', '13', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('41', '8', 'page', '13', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('42', '9', 'page', '14', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-26 19:03\";}');
INSERT INTO `pigcms_custom_field` VALUES ('43', '9', 'page', '14', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('23', '3', 'page', '8', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('24', '3', 'page', '8', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('25', '3', 'page', '8', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('26', '3', 'page', '8', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=1\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"2\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=3\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"3\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=1\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('29', '5', 'page', '9', 'image_ad', 'a:4:{s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:10:\"image_type\";s:1:\"1\";s:8:\"nav_list\";a:1:{i:0;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('30', '5', 'page', '9', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('31', '5', 'page', '9', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('32', '3', 'page', '10', 'rich_text', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('33', '6', 'page', '11', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-26 18:31\";}');
INSERT INTO `pigcms_custom_field` VALUES ('34', '6', 'page', '11', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('35', '7', 'page', '12', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-26 18:31\";}');
INSERT INTO `pigcms_custom_field` VALUES ('36', '7', 'page', '12', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('44', '9', 'page', '15', 'goods_group1', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('45', '10', 'page', '16', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-27 09:28\";}');
INSERT INTO `pigcms_custom_field` VALUES ('46', '10', 'page', '16', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('47', '11', 'page', '17', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-27 09:30\";}');
INSERT INTO `pigcms_custom_field` VALUES ('48', '11', 'page', '17', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('55', '12', 'page', '18', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:0;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('56', '12', 'page', '18', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('57', '12', 'page', '18', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('58', '12', 'page', '18', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:0:{}}');
INSERT INTO `pigcms_custom_field` VALUES ('78', '18', 'page', '30', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"通用模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg6.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('61', '13', 'page', '19', 'image_ad', 'a:4:{s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:10:\"image_type\";s:1:\"1\";s:8:\"nav_list\";a:1:{i:0;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('62', '13', 'page', '19', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('63', '13', 'page', '19', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:1:\"1\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('64', '14', 'page', '20', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-27 17:19\";}');
INSERT INTO `pigcms_custom_field` VALUES ('65', '14', 'page', '20', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('66', '15', 'page', '21', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-27 17:21\";}');
INSERT INTO `pigcms_custom_field` VALUES ('67', '15', 'page', '21', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('68', '16', 'page', '22', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-27 18:11\";}');
INSERT INTO `pigcms_custom_field` VALUES ('69', '16', 'page', '22', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('70', '13', 'page', '23', 'rich_text', 'a:1:{s:7:\"content\";s:22:\"&lt;p&gt;111&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('71', '13', 'page', '24', 'rich_text', 'a:1:{s:7:\"content\";s:22:\"&lt;p&gt;111&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('72', '13', 'page', '25', 'rich_text', 'a:1:{s:7:\"content\";s:22:\"&lt;p&gt;111&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('73', '13', 'page', '26', 'rich_text', 'a:1:{s:7:\"content\";s:22:\"&lt;p&gt;111&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('74', '13', 'page', '27', 'rich_text', 'a:1:{s:7:\"content\";s:22:\"&lt;p&gt;111&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('75', '13', 'page', '28', 'rich_text', 'a:1:{s:7:\"content\";s:22:\"&lt;p&gt;111&lt;/p&gt;\";}');
INSERT INTO `pigcms_custom_field` VALUES ('76', '17', 'page', '29', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-27 18:57\";}');
INSERT INTO `pigcms_custom_field` VALUES ('77', '17', 'page', '29', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('79', '18', 'page', '30', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('80', '18', 'page', '30', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=5\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=5\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=6\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('81', '18', 'page', '31', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"200\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:12:\"餐饮外卖\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg5.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('82', '18', 'page', '31', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('83', '18', 'page', '31', 'goods_group1', 'a:1:{s:12:\"goods_group1\";a:1:{i:0;a:2:{s:2:\"id\";s:1:\"2\";s:5:\"title\";s:12:\"餐饮外卖\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('84', '18', 'page', '32', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('85', '18', 'page', '32', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('86', '18', 'page', '32', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('87', '18', 'page', '32', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=5\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=6\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('88', '18', 'page', '33', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"美妆电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('89', '18', 'page', '33', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('90', '18', 'page', '33', 'goods', 'a:5:{s:4:\"size\";s:1:\"1\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:10:\"化妆品3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:10:\"化妆品2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:10:\"化妆品1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=6\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('91', '18', 'page', '34', 'tpl_shop1', 'a:3:{s:16:\"shop_head_bg_img\";s:29:\"/upload/images/tpl_wxd_bg.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"线下门店\";}');
INSERT INTO `pigcms_custom_field` VALUES ('92', '18', 'page', '34', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('93', '18', 'page', '34', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('94', '18', 'page', '34', 'goods', 'a:4:{s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=5\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:13:\"餐饮外卖2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:13:\"餐饮外卖1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('95', '18', 'page', '35', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:10;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:14:\"images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('96', '18', 'page', '35', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('97', '18', 'page', '35', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('98', '18', 'page', '35', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=5\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('99', '19', 'page', '36', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-30 14:03\";}');
INSERT INTO `pigcms_custom_field` VALUES ('100', '19', 'page', '36', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('101', '20', 'page', '37', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-30 14:05\";}');
INSERT INTO `pigcms_custom_field` VALUES ('102', '20', 'page', '37', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('103', '21', 'page', '38', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-30 16:16\";}');
INSERT INTO `pigcms_custom_field` VALUES ('104', '21', 'page', '38', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('105', '22', 'page', '39', 'title', 'a:2:{s:5:\"title\";s:21:\"初次认识微杂志\";s:9:\"sub_title\";s:16:\"2016-05-30 16:21\";}');
INSERT INTO `pigcms_custom_field` VALUES ('106', '22', 'page', '39', 'rich_text', 'a:1:{s:7:\"content\";s:2116:\"<p>感谢您使用小猪cms微店系统，在小猪cms微店系统里，微杂志是您日常使用最频繁的模块之一。它相当于是您的一个自定义页面，您可在这里添加多种信息，向您的粉丝展示内容。</p><p>在微杂志里，您可以多个功能模块，例如“<strong>富文本</strong>”模块。在“富文本”里，对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style=\"text-decoration:underline;\">下划线</span>、<span style=\"text-decoration:line-through;\">删除线</span>、<span style=\"color:rgb(0,176,240);\">文字颜色</span>、<span style=\"color:rgb(255,255,255);background-color:rgb(247,150,70);\">背景色</span>、以及<span style=\"font-size:22px;\">字号大小</span>等简单排版操作。</p><p>也可以在这里，通过编辑器使用表格功能</p><table><tbody><tr class=\"firstRow\"><td width=\"133\" valign=\"top\" style=\"word-break: break-all;\">中奖客户</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">发放奖品</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">备注</td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">猪猪</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">内测码</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(255,0,0);\">已经发放</span></td></tr><tr><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">大麦</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\">积分</td><td width=\"133\" valign=\"top\" style=\"word-break:break-all;\"><span style=\"color:rgb(0,176,240);\">领取地址</span></td></tr></tbody></table><p>还可以通过插入图片、并对图片加上超级链接，方便用户点击，当然也可以选中文字，对文字添加超级链接。<br></p><p>另外，你除了可以在左侧预览模块底部，添加你需要的功能模块外，还可以点击预览区域已添加模块后，进行编辑、删除和在模块后面增加另外需要的功能模块，或者拖动模块，调整顺序。</p><p>再次感谢您选择小猪cms微店系统！</p>\";}');
INSERT INTO `pigcms_custom_field` VALUES ('109', '23', 'page', '40', 'image_ad', 'a:4:{s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:10:\"image_type\";s:1:\"1\";s:8:\"nav_list\";a:1:{i:0;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('110', '23', 'page', '40', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('111', '23', 'page', '40', 'text_nav', 'a:1:{i:0;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('112', '23', 'page', '40', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=5\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('115', '24', 'page', '41', 'tpl_shop', 'a:3:{s:16:\"shop_head_bg_img\";s:27:\"/upload/images/head_bg1.png\";s:18:\"shop_head_logo_img\";s:31:\"/upload/images/default_shop.png\";s:5:\"title\";s:12:\"食品电商\";}');
INSERT INTO `pigcms_custom_field` VALUES ('116', '24', 'page', '41', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('117', '24', 'page', '41', 'notice', 'a:1:{s:7:\"content\";s:108:\"食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板食品电商模板\";}');
INSERT INTO `pigcms_custom_field` VALUES ('118', '24', 'page', '41', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:7:\"零食3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:7:\"零食2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=5\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:7:\"零食1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=6\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg3.jpg\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('125', '25', 'page', '42', 'search', 'a:0:{}');
INSERT INTO `pigcms_custom_field` VALUES ('126', '25', 'page', '42', 'image_ad', 'a:4:{s:10:\"image_type\";s:1:\"1\";s:10:\"max_height\";s:3:\"300\";s:9:\"max_width\";s:3:\"640\";s:8:\"nav_list\";a:1:{i:0;a:5:{s:5:\"title\";s:18:\"鲜花速递模板\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";s:5:\"image\";s:45:\"http://www.ediancha.com/upload/images/eg4.png\";}}}');
INSERT INTO `pigcms_custom_field` VALUES ('127', '25', 'page', '42', 'text_nav', 'a:1:{i:10;a:4:{s:5:\"title\";s:12:\"最新商品\";s:4:\"name\";s:0:\"\";s:6:\"prefix\";s:0:\"\";s:3:\"url\";s:0:\"\";}}');
INSERT INTO `pigcms_custom_field` VALUES ('128', '25', 'page', '42', 'goods', 'a:5:{s:4:\"size\";s:1:\"2\";s:7:\"buy_btn\";s:1:\"1\";s:12:\"buy_btn_type\";s:1:\"1\";s:5:\"price\";s:1:\"1\";s:5:\"goods\";a:3:{i:0;a:5:{s:2:\"id\";s:1:\"5\";s:5:\"title\";s:13:\"鲜花速递3\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=5\";s:5:\"image\";s:14:\"images/eg1.jpg\";}i:1;a:5:{s:2:\"id\";s:1:\"6\";s:5:\"title\";s:13:\"鲜花速递2\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg2.jpg\";}i:2;a:5:{s:2:\"id\";s:1:\"7\";s:5:\"title\";s:13:\"鲜花速递1\";s:5:\"price\";s:5:\"10.00\";s:3:\"url\";s:41:\"http://www.ediancha.com/wap/good.php?id=7\";s:5:\"image\";s:14:\"images/eg3.jpg\";}}}');

-- ----------------------------
-- Table structure for `pigcms_custom_page`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_custom_page`;
CREATE TABLE `pigcms_custom_page` (
  `page_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自定义页面id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '自定页面模块名',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='自定义页面模块';

-- ----------------------------
-- Records of pigcms_custom_page
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_cutprice`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_cutprice`;
CREATE TABLE `pigcms_cutprice` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `product_id` int(11) NOT NULL COMMENT '商品id',
  `sku_id` int(11) NOT NULL COMMENT '商品sku_id',
  `token` varchar(100) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `active_name` varchar(50) NOT NULL COMMENT '活动名称',
  `name` varchar(100) NOT NULL,
  `wxtitle` varchar(100) NOT NULL,
  `wxpic` varchar(100) NOT NULL,
  `wxinfo` varchar(500) DEFAULT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL COMMENT '结束时间',
  `original` varchar(100) NOT NULL,
  `startprice` varchar(100) NOT NULL,
  `stopprice` varchar(100) NOT NULL,
  `cuttime` int(11) NOT NULL,
  `cutprice` varchar(100) NOT NULL,
  `inventory` int(11) NOT NULL,
  `info` text,
  `guize` text,
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '0正常，1失败，2已结束',
  `state_subscribe` int(11) NOT NULL DEFAULT '0',
  `state_userinfo` int(11) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL,
  `onebuynum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_cutprice
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_cutprice_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_cutprice_record`;
CREATE TABLE `pigcms_cutprice_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cutprice_id` int(11) NOT NULL COMMENT '降价拍活动id',
  `order_id` int(11) NOT NULL COMMENT '订单id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='降价拍活动记录表';

-- ----------------------------
-- Records of pigcms_cutprice_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_day_platform_point`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_day_platform_point`;
CREATE TABLE `pigcms_day_platform_point` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分',
  `add_date` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期 格式：19700101',
  PRIMARY KEY (`pigcms_id`),
  UNIQUE KEY `add_date` (`add_date`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='每日返积分日志';

-- ----------------------------
-- Records of pigcms_day_platform_point
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_day_platform_service_fee`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_day_platform_service_fee`;
CREATE TABLE `pigcms_day_platform_service_fee` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',
  `add_date` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期 格式：19700101',
  PRIMARY KEY (`pigcms_id`),
  UNIQUE KEY `add_date` (`add_date`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='每日平台服务费流水';

-- ----------------------------
-- Records of pigcms_day_platform_service_fee
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_dividends_rules`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_dividends_rules`;
CREATE TABLE `pigcms_dividends_rules` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商id',
  `dividends_type` tinyint(1) unsigned NOT NULL COMMENT '奖励对象（1.经销商|2.团队|3.分销商）',
  `rule_type` tinyint(1) unsigned NOT NULL COMMENT '规则',
  `is_bind` tinyint(1) unsigned NOT NULL COMMENT '是否绑定规则3',
  `month` tinyint(2) unsigned NOT NULL COMMENT '规则定义的月份',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '规则定义的金额',
  `rule3_month` tinyint(2) unsigned NOT NULL COMMENT '规则3:月份',
  `rule3_seller_1` int(10) unsigned NOT NULL COMMENT '规则3：发展下一级分销商的个数',
  `rule3_seller_2` int(10) unsigned NOT NULL COMMENT '规则3：发展下二级分销商的个数',
  `percentage` tinyint(3) unsigned NOT NULL COMMENT '周期内累计交易额的比例',
  `fixed_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额(固定值)',
  `percentage_or_fix` tinyint(1) unsigned NOT NULL COMMENT '是否按照固定值发放(1比例2固定值)',
  `upper_limit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分红上限',
  `is_limit` tinyint(1) unsigned NOT NULL COMMENT '是否按照设置的上限发放',
  `team_owner_percentage` tinyint(3) unsigned NOT NULL COMMENT '团队所属者获得的奖金比',
  `is_team_dividend` tinyint(1) unsigned NOT NULL COMMENT '是否按照指定比例进行团队分红',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='奖金分红规则表';

-- ----------------------------
-- Records of pigcms_dividends_rules
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_dividends_send`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_dividends_send`;
CREATE TABLE `pigcms_dividends_send` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商ID',
  `dividends_type` tinyint(1) unsigned NOT NULL COMMENT '奖励对象（1.经销商|2.团队|3.分销商）',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  `add_date` int(8) unsigned NOT NULL COMMENT '添加日期',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`pigcms_id`),
  KEY `supplier_id` (`supplier_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分红发放主表';

-- ----------------------------
-- Records of pigcms_dividends_send
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_dividends_send_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_dividends_send_log`;
CREATE TABLE `pigcms_dividends_send_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `record_id` int(11) unsigned NOT NULL COMMENT '发放总记录id',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺id',
  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商id',
  `dividends_type` tinyint(1) unsigned NOT NULL,
  `sales` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计进货交易额（销售额）',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '获得的奖金金额',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  `add_date` int(8) unsigned NOT NULL COMMENT '添加日期',
  PRIMARY KEY (`pigcms_id`),
  KEY `record_id` (`record_id`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `supplier_id` (`supplier_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分红发放记录表';

-- ----------------------------
-- Records of pigcms_dividends_send_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_dividends_send_rules`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_dividends_send_rules`;
CREATE TABLE `pigcms_dividends_send_rules` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商id',
  `type` tinyint(1) unsigned NOT NULL COMMENT '发放类型',
  PRIMARY KEY (`pigcms_id`),
  UNIQUE KEY `supplier_id` (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_dividends_send_rules
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_diymenu_class`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_diymenu_class`;
CREATE TABLE `pigcms_diymenu_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `pid` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `keyword` varchar(30) NOT NULL,
  `is_show` tinyint(1) NOT NULL,
  `sort` tinyint(3) NOT NULL,
  `url` varchar(300) NOT NULL DEFAULT '',
  `wxsys` char(40) NOT NULL,
  `content` varchar(500) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT 'type [0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]',
  `fromid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_diymenu_class
-- ----------------------------
INSERT INTO `pigcms_diymenu_class` VALUES ('1', '0', '0', '关于我们', '', '1', '0', '', '', '', '0', '0');
INSERT INTO `pigcms_diymenu_class` VALUES ('2', '0', '0', '赏案例', '', '1', '0', '', '', '', '0', '0');
INSERT INTO `pigcms_diymenu_class` VALUES ('3', '0', '0', '联系我', '', '1', '0', '', '', '', '0', '0');
INSERT INTO `pigcms_diymenu_class` VALUES ('4', '0', '1', '关于e点茶', '', '1', '0', 'http://www.ediancha.com/changjing.html', '', '', '0', '0');
INSERT INTO `pigcms_diymenu_class` VALUES ('5', '0', '1', '网站首页', '', '1', '0', 'http://www.ediancha.com/mobile.html', '', '', '0', '0');
INSERT INTO `pigcms_diymenu_class` VALUES ('6', '0', '2', '清香林茶楼', '', '1', '0', 'http://www.ediancha.com.cn/wap/home.php?id=42', '', '', '0', '0');
INSERT INTO `pigcms_diymenu_class` VALUES ('7', '0', '3', '联系方式', '', '1', '0', 'http://www.ediancha.com/contact_us.html', '', '', '0', '0');
INSERT INTO `pigcms_diymenu_class` VALUES ('8', '0', '3', '地理位置', '', '1', '0', 'http://www.ediancha.com.cn/wap/physical_detail.php?id=6', '', '', '0', '0');

-- ----------------------------
-- Table structure for `pigcms_diy_attestation`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_diy_attestation`;
CREATE TABLE `pigcms_diy_attestation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `type` varchar(150) NOT NULL DEFAULT '' COMMENT '类型',
  `info` varchar(20) NOT NULL DEFAULT '' COMMENT '信息',
  `desc` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_diy_attestation
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_drp_degree`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_drp_degree`;
CREATE TABLE `pigcms_drp_degree` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `degree_alias` varchar(50) DEFAULT '' COMMENT '等级别名',
  `value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '等级值',
  `is_platform_degree_name1` tinyint(1) DEFAULT '0' COMMENT '0：本地等级名；大于0：平台等级名id',
  `is_platform_degree_icon1` tinyint(1) DEFAULT '0',
  `is_platform_degree_name` tinyint(1) unsigned DEFAULT '0' COMMENT '0：本地等级名；大于0：平台等级名id',
  `is_platform_degree_icon` tinyint(1) DEFAULT '0' COMMENT '0：本地等级图标；大于0：系统等级图标id',
  `degree_icon_custom` varchar(200) DEFAULT '' COMMENT '等级自定义图标',
  `condition_point` int(11) unsigned DEFAULT '0' COMMENT '条件积分',
  `seller_reward_1` decimal(3,1) unsigned DEFAULT '0.0' COMMENT '一级分销商奖励比率',
  `seller_reward_2` decimal(3,1) unsigned DEFAULT '0.0' COMMENT '二级分销商奖励比率',
  `seller_reward_3` decimal(3,1) unsigned DEFAULT '0.0' COMMENT '三级分销商奖励比率',
  `description` varchar(500) DEFAULT '' COMMENT '使用须知',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0 禁用 1启用',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `degree_icon_id` (`is_platform_degree_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_drp_degree
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_drp_team`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_drp_team`;
CREATE TABLE `pigcms_drp_team` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '团队名称',
  `logo` varchar(200) NOT NULL DEFAULT '' COMMENT '团队logo',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队所有者',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队供货商',
  `sales` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '团队销售额',
  `members` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队成员数',
  `desc` varchar(500) NOT NULL DEFAULT '' COMMENT '团队描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '团队状态',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队创建时间',
  PRIMARY KEY (`pigcms_id`),
  UNIQUE KEY `store_id` (`store_id`) USING BTREE,
  KEY `sales` (`sales`) USING BTREE,
  KEY `members` (`members`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='分销团队';

-- ----------------------------
-- Records of pigcms_drp_team
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_drp_team_member_label`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_drp_team_member_label`;
CREATE TABLE `pigcms_drp_team_member_label` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队id',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队成员id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '成员标签别名',
  `drp_level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分销等级',
  PRIMARY KEY (`pigcms_id`),
  KEY `team_id` (`team_id`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='分销团队成员标签';

-- ----------------------------
-- Records of pigcms_drp_team_member_label
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_express`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_express`;
CREATE TABLE `pigcms_express` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(200) NOT NULL,
  `sort` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='快递公司表';

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
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_no` varchar(100) NOT NULL DEFAULT '' COMMENT '订单号',
  `income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入 负值为支出',
  `type` tinyint(1) NOT NULL COMMENT '类型 1订单入账 2提现 3退款 4系统退款 5分销',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `payment_method` varchar(30) NOT NULL DEFAULT '' COMMENT '支付方式',
  `trade_no` varchar(100) NOT NULL DEFAULT '' COMMENT '交易号',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1进行中 2退款 3成功 4失败',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id,统一分销订单',
  `profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润',
  `storeOwnPay` tinyint(1) NOT NULL DEFAULT '0',
  `bak` varchar(500) DEFAULT '' COMMENT '备注',
  `return_id` int(11) unsigned DEFAULT '0' COMMENT '退货id',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商/经销商id',
  PRIMARY KEY (`pigcms_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  KEY `order_no` (`order_no`) USING BTREE,
  KEY `return_id` (`return_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='财务记录';

-- ----------------------------
-- Records of pigcms_financial_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_first`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_first`;
CREATE TABLE `pigcms_first` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `content` varchar(500) NOT NULL COMMENT '回复内容',
  `fromid` tinyint(1) unsigned NOT NULL COMMENT '网站功能回复（1：网站首页，2:团购，3：订餐）',
  `title` varchar(50) NOT NULL COMMENT '图文回复标题',
  `info` varchar(200) NOT NULL COMMENT '图文回复内容',
  `pic` varchar(200) NOT NULL COMMENT '图文回复图片',
  `url` varchar(200) NOT NULL COMMENT '图文回复外站链接',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_first
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_flink`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_flink`;
CREATE TABLE `pigcms_flink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` varchar(100) NOT NULL,
  `url` varchar(150) NOT NULL,
  `add_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` smallint(6) NOT NULL,
  `parent_key` varchar(100) NOT NULL COMMENT '父键(关联配置表)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_flink
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_flink_config`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_flink_config`;
CREATE TABLE `pigcms_flink_config` (
  `key` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示为友情链接顶级分类',
  UNIQUE KEY `key` (`key`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='首页底部配置表';

-- ----------------------------
-- Records of pigcms_flink_config
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_fx_order`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_fx_order`;
CREATE TABLE `pigcms_fx_order` (
  `fx_order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fx_order_no` varchar(100) NOT NULL DEFAULT '' COMMENT '订单号',
  `fx_trade_no` varchar(100) NOT NULL DEFAULT '' COMMENT '交易单号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `session_id` varchar(32) NOT NULL,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '主订单id',
  `order_no` varchar(100) NOT NULL DEFAULT '' COMMENT '主订单号',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商id',
  `postage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品总价',
  `cost_sub_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品成本总价',
  `quantity` int(5) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额',
  `cost_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本总额',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单状态',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `paid_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '付款时间',
  `supplier_sent_time` int(11) NOT NULL DEFAULT '0' COMMENT '供货商发货时间',
  `complate_time` int(11) NOT NULL DEFAULT '0' COMMENT '交易完成时间',
  `delivery_user` varchar(100) NOT NULL DEFAULT '' COMMENT '收货人',
  `delivery_tel` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `delivery_address` varchar(200) NOT NULL DEFAULT '' COMMENT '收货地址',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id,统一分销订单',
  `suppliers` varchar(500) NOT NULL DEFAULT '' COMMENT '供货商',
  `fx_postage` varchar(500) NOT NULL DEFAULT '' COMMENT '分销运费',
  PRIMARY KEY (`fx_order_id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `order_no` (`order_no`) USING BTREE,
  KEY `supplier_id` (`supplier_id`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='分销订单';

-- ----------------------------
-- Records of pigcms_fx_order
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_fx_order_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_fx_order_product`;
CREATE TABLE `pigcms_fx_order_product` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fx_order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分销订单id',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '单价',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价',
  `quantity` int(5) NOT NULL DEFAULT '0' COMMENT '数量',
  `sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存id',
  `sku_data` text NOT NULL COMMENT '库存信息',
  `comment` text NOT NULL COMMENT '买家留言',
  `source_product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '源商品id',
  PRIMARY KEY (`pigcms_id`),
  KEY `fx_order_id` (`fx_order_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `sku_id` (`sku_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='分销订单商品';

-- ----------------------------
-- Records of pigcms_fx_order_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_fx_store_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_fx_store_product`;
CREATE TABLE `pigcms_fx_store_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `store_id` int(10) unsigned NOT NULL COMMENT '店铺id',
  `product_id` int(10) unsigned NOT NULL COMMENT '商品id',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_fx_store_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_gift_point_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_gift_point_record`;
CREATE TABLE `pigcms_gift_point_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '被操作的用户uid',
  `store_id` int(11) DEFAULT NULL,
  `point` int(11) DEFAULT NULL COMMENT '变更的积分',
  `type` tinyint(1) DEFAULT NULL COMMENT '1:订单消耗',
  `timestamp` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL COMMENT '订单消耗的order_id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_gift_point_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_helping`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_helping`;
CREATE TABLE `pigcms_helping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL COMMENT '店铺id',
  `title` varchar(40) NOT NULL COMMENT '活动名称',
  `guize` varchar(150) NOT NULL COMMENT '活动规则',
  `wxpic` varchar(100) NOT NULL COMMENT '微信分享图片',
  `start_time` datetime NOT NULL COMMENT '活动开始时间',
  `end_time` datetime NOT NULL COMMENT '活动结束时间',
  `add_time` varchar(15) NOT NULL COMMENT '活动添加时间',
  `is_open` tinyint(4) NOT NULL COMMENT '是否开启',
  `is_attention` tinyint(4) NOT NULL COMMENT '能否参与',
  `is_help` int(11) NOT NULL DEFAULT '0' COMMENT '能否助力',
  `wxtitle` varchar(50) NOT NULL COMMENT '微信分享标题',
  `wxinfo` varchar(150) NOT NULL COMMENT '微信分享内容',
  `rank_num` int(11) NOT NULL DEFAULT '10' COMMENT '排行榜显示数量',
  `pv` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `prizecode` varchar(50) NOT NULL COMMENT '奖品领取码',
  `delete_flag` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_helping
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_helping_news`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_helping_news`;
CREATE TABLE `pigcms_helping_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '活动id',
  `title` varchar(100) DEFAULT NULL COMMENT '推广图片标题',
  `imgurl` varchar(200) NOT NULL COMMENT '推广图片标题',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_helping_news
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_helping_prize`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_helping_prize`;
CREATE TABLE `pigcms_helping_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '活动id',
  `type` tinyint(3) NOT NULL COMMENT '奖品分类',
  `title` varchar(100) NOT NULL COMMENT '奖品内容(保存奖品id)',
  `imgurl` varchar(200) NOT NULL COMMENT '奖品图片',
  `num` tinyint(3) NOT NULL DEFAULT '1' COMMENT '奖品等级',
  `is_cash` varchar(100) NOT NULL DEFAULT '0' COMMENT '是否兑换',
  `prize_time` varchar(15) NOT NULL,
  `code` varchar(50) DEFAULT NULL COMMENT '兑换密码',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_helping_prize
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_helping_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_helping_record`;
CREATE TABLE `pigcms_helping_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `token` varchar(35) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `avatar` varchar(150) NOT NULL,
  `share_key` char(40) NOT NULL,
  `addtime` varchar(35) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_helping_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_helping_user`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_helping_user`;
CREATE TABLE `pigcms_helping_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `token` varchar(40) NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `avatar` varchar(150) NOT NULL,
  `help_count` int(11) NOT NULL,
  `share_num` int(11) NOT NULL DEFAULT '0',
  `add_time` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_helping_user
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_image_text`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_image_text`;
CREATE TABLE `pigcms_image_text` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='图文表';

-- ----------------------------
-- Records of pigcms_image_text
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_invest_config`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_invest_config`;
CREATE TABLE `pigcms_invest_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_invest_config
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_invest_order`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_invest_order`;
CREATE TABLE `pigcms_invest_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `project_id` int(11) NOT NULL COMMENT '项目id',
  `zcpay_no` varchar(100) DEFAULT NULL COMMENT '众筹微信支付订单号，格式：ZCPAY_生成另外订单号',
  `intention_amount` decimal(10,2) NOT NULL COMMENT '意向金',
  `margin_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金',
  `time` int(10) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '订单类型1小东家订单，2大东家订单',
  `status` tinyint(1) NOT NULL COMMENT '订单状态，1为未支付，2为已支付',
  `pay_openid` varchar(50) DEFAULT NULL COMMENT '支付人openid',
  `third_id` varchar(100) NOT NULL COMMENT '第三方支付ID',
  `third_data` text NOT NULL COMMENT '第三方支付返回内容',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `trade_no` varchar(100) NOT NULL COMMENT '交易流水号',
  `invest_state` tinyint(2) DEFAULT '0' COMMENT '投资人状态 0为正常投资人 1为候选投资人',
  `address` text NOT NULL COMMENT '收货人地址',
  `address_user` varchar(30) NOT NULL COMMENT '收货人姓名',
  `address_tel` varchar(20) NOT NULL COMMENT '收货人电话',
  `pay_money` int(11) DEFAULT NULL,
  `order_type` int(11) DEFAULT NULL,
  `freight` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT NULL,
  `remark` varchar(500) DEFAULT NULL,
  `repay_id` int(11) DEFAULT NULL,
  `order_status` tinyint(1) DEFAULT NULL COMMENT '1:未支付，2已支付',
  `extract_number` varchar(50) DEFAULT NULL,
  `store_id` int(10) NOT NULL COMMENT '店铺id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_invest_order
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_invest_question`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_invest_question`;
CREATE TABLE `pigcms_invest_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` tinyint(1) NOT NULL COMMENT '分类',
  `question_name` varchar(255) NOT NULL,
  `question_answer` text NOT NULL COMMENT '常见问题答案',
  `sort` int(11) NOT NULL COMMENT '排序',
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_invest_question
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_invest_slide`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_invest_slide`;
CREATE TABLE `pigcms_invest_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` tinyint(1) NOT NULL COMMENT '幻灯片分类',
  `time` int(10) NOT NULL,
  `name` varchar(200) NOT NULL COMMENT '幻灯片名称',
  `url` varchar(200) NOT NULL,
  `link` varchar(200) NOT NULL COMMENT '图片链接地址',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `waplink` varchar(200) NOT NULL COMMENT '手机端图片链接地址',
  `wapurl` varchar(200) NOT NULL COMMENT '手机端幻灯片图片地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_invest_slide
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_keyword`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_keyword`;
CREATE TABLE `pigcms_keyword` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `content` varchar(200) NOT NULL,
  `from_id` int(11) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_keyword
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_lbs_area`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_lbs_area`;
CREATE TABLE `pigcms_lbs_area` (
  `code` int(11) NOT NULL COMMENT '城市代码',
  `name` varchar(200) DEFAULT NULL COMMENT '城市名称',
  `first_spell` varchar(200) DEFAULT NULL COMMENT '城市中文首字母',
  `chinese_spell` varchar(200) DEFAULT NULL COMMENT '城市中文全拼',
  `is_hot` tinyint(1) DEFAULT '0' COMMENT '是否热门城市(0:否 1:是)',
  `is_open` tinyint(1) DEFAULT '0' COMMENT '是否开启',
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_lbs_area
-- ----------------------------
INSERT INTO `pigcms_lbs_area` VALUES ('110100', '北京市', 'b', 'beijingshi', '1', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110101', '东城区', '', 'dongchengqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110102', '西城区', '', 'xichengqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110105', '朝阳区', '', 'chaoyangqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110106', '丰台区', '', 'fengtaiqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110107', '石景山区', '', 'shijingshanqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110108', '海淀区', '', 'haidianqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110109', '门头沟区', '', 'mentougouqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110111', '房山区', '', 'fangshanqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110112', '通州区', '', 'tongzhouqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110113', '顺义区', '', 'shunyiqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110114', '昌平区', '', 'changpingqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110115', '大兴区', '', 'daxingqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110116', '怀柔区', '', 'huairouqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110117', '平谷区', '', 'pingguqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('110199', '其它区', '', 'qitaqu', '0', '1');
INSERT INTO `pigcms_lbs_area` VALUES ('120100', '天津市', 't', 'tianjinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120101', '和平区', '', 'hepingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120102', '河东区', '', 'hedongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120103', '河西区', '', 'hexiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120104', '南开区', '', 'nankaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120105', '河北区', '', 'hebeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120106', '红桥区', '', 'hongqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120107', '塘沽区', '', 'tangguqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120108', '汉沽区', '', 'hanguqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120109', '大港区', '', 'dagangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120110', '东丽区', '', 'dongliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120111', '西青区', '', 'xiqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120112', '津南区', '', 'jinnanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120113', '北辰区', '', 'beichenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120114', '武清区', '', 'wuqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120115', '宝坻区', '', 'baoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120116', '滨海新区', '', 'binhaixinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('120199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130100', '石家庄市', 's', 'shijiazhuangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130102', '长安区', '', 'changanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130103', '桥东区', '', 'qiaodongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130104', '桥西区', '', 'qiaoxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130105', '新华区', '', 'xinhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130107', '井陉矿区', '', 'jingkuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130108', '裕华区', '', 'yuhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130121', '井陉县', '', 'jingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130123', '正定县', '', 'zhengdingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130124', '栾城县', '', 'chengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130125', '行唐县', '', 'xingtangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130126', '灵寿县', '', 'lingshouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130127', '高邑县', '', 'gaoyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130128', '深泽县', '', 'shenzexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130129', '赞皇县', '', 'zanhuangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130130', '无极县', '', 'wujixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130131', '平山县', '', 'pingshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130132', '元氏县', '', 'yuanshixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130133', '赵县', '', 'zhaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130181', '辛集市', '', 'xinjishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130182', '藁城市', '', 'chengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130183', '晋州市', '', 'jinzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130184', '新乐市', '', 'xinleshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130185', '鹿泉市', '', 'luquanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130200', '唐山市', 't', 'tangshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130202', '路南区', '', 'lunanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130203', '路北区', '', 'lubeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130204', '古冶区', '', 'guyequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130205', '开平区', '', 'kaipingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130207', '丰南区', '', 'fengnanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130208', '丰润区', '', 'fengrunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130209', '曹妃甸区', '', 'caodianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130223', '滦县', '', 'luanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130224', '滦南县', '', 'luannanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130225', '乐亭县', '', 'letingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130227', '迁西县', '', 'qianxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130229', '玉田县', '', 'yutianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130230', '唐海县', '', 'tanghaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130281', '遵化市', '', 'zunhuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130283', '迁安市', '', 'qiananshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130300', '秦皇岛市', 'q', 'qinhuangdaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130302', '海港区', '', 'haigangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130303', '山海关区', '', 'shanhaiguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130304', '北戴河区', '', 'beidaihequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130321', '青龙满族自治县', '', 'qinglongmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130322', '昌黎县', '', 'changlixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130323', '抚宁县', '', 'funingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130324', '卢龙县', '', 'lulongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130398', '经济技术开发区', '', 'jingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130400', '邯郸市', 'h', 'handanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130402', '邯山区', '', 'hanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130403', '丛台区', '', 'congtaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130404', '复兴区', '', 'fuxingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130406', '峰峰矿区', '', 'fengfengkuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130421', '邯郸县', '', 'handanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130423', '临漳县', '', 'linzhangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130424', '成安县', '', 'chenganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130425', '大名县', '', 'damingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130426', '涉县', '', 'shexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130427', '磁县', '', 'cixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130428', '肥乡县', '', 'feixiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130429', '永年县', '', 'yongnianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130430', '邱县', '', 'qiuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130431', '鸡泽县', '', 'jizexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130432', '广平县', '', 'guangpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130433', '馆陶县', '', 'guantaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130434', '魏县', '', 'weixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130435', '曲周县', '', 'quzhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130481', '武安市', '', 'wuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130500', '邢台市', 'x', 'xingtaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130502', '桥东区', '', 'qiaodongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130503', '桥西区', '', 'qiaoxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130521', '邢台县', '', 'xingtaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130522', '临城县', '', 'linchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130523', '内丘县', '', 'neiqiuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130524', '柏乡县', '', 'baixiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130525', '隆尧县', '', 'longyaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130526', '任县', '', 'renxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130527', '南和县', '', 'nanhexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130528', '宁晋县', '', 'ningjinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130529', '巨鹿县', '', 'juluxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130530', '新河县', '', 'xinhexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130531', '广宗县', '', 'guangzongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130532', '平乡县', '', 'pingxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130533', '威县', '', 'weixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130534', '清河县', '', 'qinghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130535', '临西县', '', 'linxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130581', '南宫市', '', 'nangongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130582', '沙河市', '', 'shaheshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130600', '保定市', 'b', 'baodingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130602', '新市区', '', 'xinshiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130603', '北市区', '', 'beishiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130604', '南市区', '', 'nanshiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130621', '满城县', '', 'manchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130622', '清苑县', '', 'qingyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130623', '涞水县', '', 'shuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130624', '阜平县', '', 'fupingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130625', '徐水县', '', 'xushuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130626', '定兴县', '', 'dingxingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130627', '唐县', '', 'tangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130628', '高阳县', '', 'gaoyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130629', '容城县', '', 'rongchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130630', '涞源县', '', 'yuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130631', '望都县', '', 'wangduxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130632', '安新县', '', 'anxinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130633', '易县', '', 'yixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130634', '曲阳县', '', 'quyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130635', '蠡县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130636', '顺平县', '', 'shunpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130637', '博野县', '', 'boyexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130638', '雄县', '', 'xiongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130681', '涿州市', '', 'zhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130682', '定州市', '', 'dingzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130683', '安国市', '', 'anguoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130684', '高碑店市', '', 'gaobeidianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130698', '高开区', '', 'gaokaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130700', '张家口市', 'z', 'zhangjiakoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130702', '桥东区', '', 'qiaodongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130703', '桥西区', '', 'qiaoxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130705', '宣化区', '', 'xuanhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130706', '下花园区', '', 'xiahuayuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130721', '宣化县', '', 'xuanhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130722', '张北县', '', 'zhangbeixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130723', '康保县', '', 'kangbaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130724', '沽源县', '', 'guyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130725', '尚义县', '', 'shangyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130726', '蔚县', '', 'weixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130727', '阳原县', '', 'yangyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130728', '怀安县', '', 'huaianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130729', '万全县', '', 'wanquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130730', '怀来县', '', 'huailaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130731', '涿鹿县', '', 'luxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130732', '赤城县', '', 'chichengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130733', '崇礼县', '', 'chonglixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130800', '承德市', 'c', 'chengdeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130802', '双桥区', '', 'shuangqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130803', '双滦区', '', 'shuangluanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130804', '鹰手营子矿区', '', 'yingshouyingzikuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130821', '承德县', '', 'chengdexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130822', '兴隆县', '', 'xinglongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130823', '平泉县', '', 'pingquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130824', '滦平县', '', 'luanpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130825', '隆化县', '', 'longhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130826', '丰宁满族自治县', '', 'fengningmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130827', '宽城满族自治县', '', 'kuanchengmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130828', '围场满族蒙古族自治县', '', 'weichangmanzumengguzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130900', '沧州市', 'c', 'cangzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130902', '新华区', '', 'xinhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130903', '运河区', '', 'yunhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130921', '沧县', '', 'cangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130922', '青县', '', 'qingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130923', '东光县', '', 'dongguangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130924', '海兴县', '', 'haixingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130925', '盐山县', '', 'yanshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130926', '肃宁县', '', 'suningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130927', '南皮县', '', 'nanpixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130928', '吴桥县', '', 'wuqiaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130929', '献县', '', 'xianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130930', '孟村回族自治县', '', 'mengcunhuizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130981', '泊头市', '', 'botoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130982', '任丘市', '', 'renqiushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130983', '黄骅市', '', 'huangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130984', '河间市', '', 'hejianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('130999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131000', '廊坊市', 'l', 'langfangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131002', '安次区', '', 'anciqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131003', '广阳区', '', 'guangyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131022', '固安县', '', 'guanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131023', '永清县', '', 'yongqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131024', '香河县', '', 'xianghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131025', '大城县', '', 'dachengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131026', '文安县', '', 'wenanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131028', '大厂回族自治县', '', 'dachanghuizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131051', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131052', '燕郊经济技术开发区', '', 'yanjiaojingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131081', '霸州市', '', 'bazhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131082', '三河市', '', 'sanheshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131100', '衡水市', 'h', 'hengshuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131102', '桃城区', '', 'taochengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131121', '枣强县', '', 'zaoqiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131122', '武邑县', '', 'wuyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131123', '武强县', '', 'wuqiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131124', '饶阳县', '', 'raoyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131125', '安平县', '', 'anpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131126', '故城县', '', 'guchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131127', '景县', '', 'jingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131128', '阜城县', '', 'fuchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131181', '冀州市', '', 'jizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131182', '深州市', '', 'shenzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('131199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140100', '太原市', 't', 'taiyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140105', '小店区', '', 'xiaodianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140106', '迎泽区', '', 'yingzequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140107', '杏花岭区', '', 'xinghualingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140108', '尖草坪区', '', 'jiancaopingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140109', '万柏林区', '', 'wanbailinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140110', '晋源区', '', 'jinyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140121', '清徐县', '', 'qingxuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140122', '阳曲县', '', 'yangquxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140123', '娄烦县', '', 'loufanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140181', '古交市', '', 'gujiaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140200', '大同市', 'd', 'datongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140202', '城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140203', '矿区', '', 'kuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140211', '南郊区', '', 'nanjiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140212', '新荣区', '', 'xinrongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140221', '阳高县', '', 'yanggaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140222', '天镇县', '', 'tianzhenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140223', '广灵县', '', 'guanglingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140224', '灵丘县', '', 'lingqiuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140225', '浑源县', '', 'hunyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140226', '左云县', '', 'zuoyunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140227', '大同县', '', 'datongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140300', '阳泉市', 'y', 'yangquanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140302', '城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140303', '矿区', '', 'kuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140311', '郊区', '', 'jiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140321', '平定县', '', 'pingdingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140322', '盂县', '', 'yuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140400', '长治市', 'c', 'changzhishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140402', '城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140411', '郊区', '', 'jiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140421', '长治县', '', 'changzhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140423', '襄垣县', '', 'xiangyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140424', '屯留县', '', 'tunliuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140425', '平顺县', '', 'pingshunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140426', '黎城县', '', 'lichengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140427', '壶关县', '', 'huguanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140428', '长子县', '', 'changzixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140429', '武乡县', '', 'wuxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140430', '沁县', '', 'qinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140431', '沁源县', '', 'qinyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140481', '潞城市', '', 'luchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140484', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140500', '晋城市', 'j', 'jinchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140502', '城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140521', '沁水县', '', 'qinshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140522', '阳城县', '', 'yangchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140524', '陵川县', '', 'lingchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140525', '泽州县', '', 'zezhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140581', '高平市', '', 'gaopingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140600', '朔州市', 's', 'shuozhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140602', '朔城区', '', 'shuochengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140603', '平鲁区', '', 'pingluqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140621', '山阴县', '', 'shanyinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140622', '应县', '', 'yingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140623', '右玉县', '', 'youyuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140624', '怀仁县', '', 'huairenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140700', '晋中市', 'j', 'jinzhongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140702', '榆次区', '', 'yuciqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140721', '榆社县', '', 'yushexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140722', '左权县', '', 'zuoquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140723', '和顺县', '', 'heshunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140724', '昔阳县', '', 'xiyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140725', '寿阳县', '', 'shouyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140726', '太谷县', '', 'taiguxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140727', '祁县', '', 'qixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140728', '平遥县', '', 'pingyaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140729', '灵石县', '', 'lingshixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140781', '介休市', '', 'jiexiushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140800', '运城市', 'y', 'yunchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140802', '盐湖区', '', 'yanhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140821', '临猗县', '', 'linxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140822', '万荣县', '', 'wanrongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140823', '闻喜县', '', 'wenxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140824', '稷山县', '', 'shanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140825', '新绛县', '', 'xinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140826', '绛县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140827', '垣曲县', '', 'yuanquxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140828', '夏县', '', 'xiaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140829', '平陆县', '', 'pingluxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140830', '芮城县', '', 'chengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140881', '永济市', '', 'yongjishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140882', '河津市', '', 'hejinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140900', '忻州市', 'x', 'xinzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140902', '忻府区', '', 'xinfuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140921', '定襄县', '', 'dingxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140922', '五台县', '', 'wutaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140923', '代县', '', 'daixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140924', '繁峙县', '', 'fanzhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140925', '宁武县', '', 'ningwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140926', '静乐县', '', 'jinglexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140927', '神池县', '', 'shenchixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140928', '五寨县', '', 'wuzhaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140929', '岢岚县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140930', '河曲县', '', 'hequxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140931', '保德县', '', 'baodexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140932', '偏关县', '', 'pianguanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140981', '原平市', '', 'yuanpingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('140999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141000', '临汾市', 'l', 'linfenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141002', '尧都区', '', 'yaoduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141021', '曲沃县', '', 'quwoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141022', '翼城县', '', 'yichengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141023', '襄汾县', '', 'xiangfenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141024', '洪洞县', '', 'hongdongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141025', '古县', '', 'guxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141026', '安泽县', '', 'anzexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141027', '浮山县', '', 'fushanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141028', '吉县', '', 'jixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141029', '乡宁县', '', 'xiangningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141030', '大宁县', '', 'daningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141031', '隰县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141032', '永和县', '', 'yonghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141033', '蒲县', '', 'puxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141034', '汾西县', '', 'fenxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141081', '侯马市', '', 'houmashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141082', '霍州市', '', 'huozhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141100', '吕梁市', 'l', 'lvliangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141102', '离石区', '', 'lishiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141121', '文水县', '', 'wenshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141122', '交城县', '', 'jiaochengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141123', '兴县', '', 'xingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141124', '临县', '', 'linxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141125', '柳林县', '', 'liulinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141126', '石楼县', '', 'shilouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141127', '岚县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141128', '方山县', '', 'fangshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141129', '中阳县', '', 'zhongyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141130', '交口县', '', 'jiaokouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141181', '孝义市', '', 'xiaoyishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141182', '汾阳市', '', 'fenyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('141199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150100', '呼和浩特市', 'h', 'huhehaoteshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150102', '新城区', '', 'xinchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150103', '回民区', '', 'huiminqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150104', '玉泉区', '', 'yuquanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150105', '赛罕区', '', 'saihanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150121', '土默特左旗', '', 'tumotezuoqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150122', '托克托县', '', 'tuoketuoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150123', '和林格尔县', '', 'helingeerxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150124', '清水河县', '', 'qingshuihexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150125', '武川县', '', 'wuchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150200', '包头市', 'b', 'baotoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150202', '东河区', '', 'donghequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150203', '昆都仑区', '', 'kundulunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150204', '青山区', '', 'qingshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150205', '石拐区', '', 'shiguaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150206', '白云鄂博矿区', '', 'baiyunebokuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150207', '九原区', '', 'jiuyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150221', '土默特右旗', '', 'tumoteyouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150222', '固阳县', '', 'guyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150223', '达尔罕茂明安联合旗', '', 'daerhanmaominganlianheqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150300', '乌海市', 'w', 'wuhaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150302', '海勃湾区', '', 'haibowanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150303', '海南区', '', 'hainanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150304', '乌达区', '', 'wudaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150400', '赤峰市', 'c', 'chifengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150402', '红山区', '', 'hongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150403', '元宝山区', '', 'yuanbaoshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150404', '松山区', '', 'songshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150421', '阿鲁科尔沁旗', '', 'alukeerqinqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150422', '巴林左旗', '', 'balinzuoqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150423', '巴林右旗', '', 'balinyouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150424', '林西县', '', 'linxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150425', '克什克腾旗', '', 'keshiketengqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150426', '翁牛特旗', '', 'wengniuteqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150428', '喀喇沁旗', '', 'kalaqinqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150429', '宁城县', '', 'ningchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150430', '敖汉旗', '', 'aohanqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150500', '通辽市', 't', 'tongliaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150502', '科尔沁区', '', 'keerqinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150521', '科尔沁左翼中旗', '', 'keerqinzuoyizhongqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150522', '科尔沁左翼后旗', '', 'keerqinzuoyihouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150523', '开鲁县', '', 'kailuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150524', '库伦旗', '', 'kulunqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150525', '奈曼旗', '', 'naimanqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150526', '扎鲁特旗', '', 'zhaluteqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150581', '霍林郭勒市', '', 'huolinguoleshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150600', '鄂尔多斯市', 'e', 'eerduosishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150602', '东胜区', '', 'dongshengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150621', '达拉特旗', '', 'dalateqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150622', '准格尔旗', '', 'zhungeerqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150623', '鄂托克前旗', '', 'etuokeqianqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150624', '鄂托克旗', '', 'etuokeqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150625', '杭锦旗', '', 'hangjinqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150626', '乌审旗', '', 'wushenqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150627', '伊金霍洛旗', '', 'yijinhuoluoqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150628', '康巴什新区', '', 'kangbashixinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150700', '呼伦贝尔市', 'h', 'hulunbeiershi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150702', '海拉尔区', '', 'hailaerqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150703', '扎赉诺尔区', '', 'zhanuoerqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150721', '阿荣旗', '', 'arongqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150722', '莫力达瓦达斡尔族自治旗', '', 'molidawadawoerzuzizhiqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150723', '鄂伦春自治旗', '', 'elunchunzizhiqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150724', '鄂温克族自治旗', '', 'ewenkezuzizhiqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150725', '陈巴尔虎旗', '', 'chenbaerhuqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150726', '新巴尔虎左旗', '', 'xinbaerhuzuoqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150727', '新巴尔虎右旗', '', 'xinbaerhuyouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150781', '满洲里市', '', 'manzhoulishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150782', '牙克石市', '', 'yakeshishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150783', '扎兰屯市', '', 'zhalantunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150784', '额尔古纳市', '', 'eergunashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150785', '根河市', '', 'genheshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150800', '巴彦淖尔市', 'b', 'bayannaoershi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150802', '临河区', '', 'linhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150821', '五原县', '', 'wuyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150822', '磴口县', '', 'kouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150823', '乌拉特前旗', '', 'wulateqianqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150824', '乌拉特中旗', '', 'wulatezhongqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150825', '乌拉特后旗', '', 'wulatehouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150826', '杭锦后旗', '', 'hangjinhouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150900', '乌兰察布市', 'w', 'wulanchabushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150902', '集宁区', '', 'jiningqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150921', '卓资县', '', 'zhuozixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150922', '化德县', '', 'huadexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150923', '商都县', '', 'shangduxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150924', '兴和县', '', 'xinghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150925', '凉城县', '', 'liangchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150926', '察哈尔右翼前旗', '', 'chahaeryouyiqianqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150927', '察哈尔右翼中旗', '', 'chahaeryouyizhongqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150928', '察哈尔右翼后旗', '', 'chahaeryouyihouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150929', '四子王旗', '', 'siziwangqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150981', '丰镇市', '', 'fengzhenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('150999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152200', '兴安盟', 'x', 'xinganmeng', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152201', '乌兰浩特市', '', 'wulanhaoteshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152202', '阿尔山市', '', 'aershanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152221', '科尔沁右翼前旗', '', 'keerqinyouyiqianqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152222', '科尔沁右翼中旗', '', 'keerqinyouyizhongqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152223', '扎赉特旗', '', 'zhateqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152224', '突泉县', '', 'tuquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152500', '锡林郭勒盟', 'x', 'xilinguolemeng', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152501', '二连浩特市', '', 'erlianhaoteshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152502', '锡林浩特市', '', 'xilinhaoteshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152522', '阿巴嘎旗', '', 'abagaqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152523', '苏尼特左旗', '', 'sunitezuoqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152524', '苏尼特右旗', '', 'suniteyouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152525', '东乌珠穆沁旗', '', 'dongwuzhumuqinqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152526', '西乌珠穆沁旗', '', 'xiwuzhumuqinqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152527', '太仆寺旗', '', 'taipusiqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152528', '镶黄旗', '', 'xianghuangqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152529', '正镶白旗', '', 'zhengxiangbaiqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152530', '正蓝旗', '', 'zhenglanqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152531', '多伦县', '', 'duolunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152900', '阿拉善盟', 'a', 'alashanmeng', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152921', '阿拉善左旗', '', 'alashanzuoqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152922', '阿拉善右旗', '', 'alashanyouqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152923', '额济纳旗', '', 'ejinaqi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('152999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210100', '沈阳市', 's', 'shenyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210102', '和平区', '', 'hepingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210103', '沈河区', '', 'shenhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210104', '大东区', '', 'dadongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210105', '皇姑区', '', 'huangguqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210106', '铁西区', '', 'tiexiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210111', '苏家屯区', '', 'sujiatunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210112', '东陵区', '', 'donglingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210113', '沈北新区', '', 'shenbeixinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210114', '于洪区', '', 'yuhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210122', '辽中县', '', 'liaozhongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210123', '康平县', '', 'kangpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210124', '法库县', '', 'fakuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210181', '新民市', '', 'xinminshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210182', '浑南新区', '', 'hunnanxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210183', '张士开发区', '', 'zhangshikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210200', '大连市', 'd', 'dalianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210202', '中山区', '', 'zhongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210203', '西岗区', '', 'xigangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210204', '沙河口区', '', 'shahekouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210211', '甘井子区', '', 'ganjingziqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210212', '旅顺口区', '', 'lvshunkouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210213', '金州区', '', 'jinzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210224', '长海县', '', 'changhaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210251', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210281', '瓦房店市', '', 'wafangdianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210282', '普兰店市', '', 'pulandianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210283', '庄河市', '', 'zhuangheshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210284', '高新园区', '', 'gaoxinyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210285', '大连开发区', '', 'daliankaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210297', '岭前区', '', 'lingqianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210300', '鞍山市', 'a', 'anshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210302', '铁东区', '', 'tiedongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210303', '铁西区', '', 'tiexiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210304', '立山区', '', 'lishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210311', '千山区', '', 'qianshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210321', '台安县', '', 'taianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210323', '岫岩满族自治县', '', 'yanmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210351', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210381', '海城市', '', 'haichengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210400', '抚顺市', 'f', 'fushunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210402', '新抚区', '', 'xinfuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210403', '东洲区', '', 'dongzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210404', '望花区', '', 'wanghuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210411', '顺城区', '', 'shunchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210421', '抚顺县', '', 'fushunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210422', '新宾满族自治县', '', 'xinbinmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210423', '清原满族自治县', '', 'qingyuanmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210500', '本溪市', 'b', 'benxishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210502', '平山区', '', 'pingshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210503', '溪湖区', '', 'xihuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210504', '明山区', '', 'mingshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210505', '南芬区', '', 'nanfenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210521', '本溪满族自治县', '', 'benximanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210522', '桓仁满族自治县', '', 'huanrenmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210600', '丹东市', 'd', 'dandongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210602', '元宝区', '', 'yuanbaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210603', '振兴区', '', 'zhenxingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210604', '振安区', '', 'zhenanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210624', '宽甸满族自治县', '', 'kuandianmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210681', '东港市', '', 'donggangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210682', '凤城市', '', 'fengchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210700', '锦州市', 'j', 'jinzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210702', '古塔区', '', 'gutaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210703', '凌河区', '', 'linghequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210711', '太和区', '', 'taihequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210726', '黑山县', '', 'heishanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210727', '义县', '', 'yixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210781', '凌海市', '', 'linghaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210782', '北镇市', '', 'beizhenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210783', '经济技术开发区', '', 'jingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210800', '营口市', 'y', 'yingkoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210802', '站前区', '', 'zhanqianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210803', '西市区', '', 'xishiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210804', '鲅鱼圈区', '', 'yuquanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210811', '老边区', '', 'laobianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210881', '盖州市', '', 'gaizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210882', '大石桥市', '', 'dashiqiaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210900', '阜新市', 'f', 'fuxinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210902', '海州区', '', 'haizhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210903', '新邱区', '', 'xinqiuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210904', '太平区', '', 'taipingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210905', '清河门区', '', 'qinghemenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210911', '细河区', '', 'xihequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210921', '阜新蒙古族自治县', '', 'fuxinmengguzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210922', '彰武县', '', 'zhangwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('210999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211000', '辽阳市', 'l', 'liaoyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211002', '白塔区', '', 'baitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211003', '文圣区', '', 'wenshengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211004', '宏伟区', '', 'hongweiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211005', '弓长岭区', '', 'gongchanglingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211011', '太子河区', '', 'taizihequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211021', '辽阳县', '', 'liaoyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211081', '灯塔市', '', 'dengtashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211100', '盘锦市', 'p', 'panjinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211102', '双台子区', '', 'shuangtaiziqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211103', '兴隆台区', '', 'xinglongtaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211121', '大洼县', '', 'dawaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211122', '盘山县', '', 'panshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211200', '铁岭市', 't', 'tielingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211202', '银州区', '', 'yinzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211204', '清河区', '', 'qinghequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211221', '铁岭县', '', 'tielingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211223', '西丰县', '', 'xifengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211224', '昌图县', '', 'changtuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211281', '调兵山市', '', 'diaobingshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211282', '开原市', '', 'kaiyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211300', '朝阳市', 'c', 'chaoyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211302', '双塔区', '', 'shuangtaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211303', '龙城区', '', 'longchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211321', '朝阳县', '', 'chaoyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211322', '建平县', '', 'jianpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211324', '喀喇沁左翼蒙古族自治县', '', 'kalaqinzuoyimengguzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211381', '北票市', '', 'beipiaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211382', '凌源市', '', 'lingyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211400', '葫芦岛市', 'h', 'huludaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211402', '连山区', '', 'lianshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211403', '龙港区', '', 'longgangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211404', '南票区', '', 'nanpiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211421', '绥中县', '', 'suizhongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211422', '建昌县', '', 'jianchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211481', '兴城市', '', 'xingchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('211499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220100', '长春市', 'c', 'changchunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220102', '南关区', '', 'nanguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220103', '宽城区', '', 'kuanchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220104', '朝阳区', '', 'chaoyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220105', '二道区', '', 'erdaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220106', '绿园区', '', 'lvyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220112', '双阳区', '', 'shuangyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220122', '农安县', '', 'nonganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220181', '九台市', '', 'jiutaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220182', '榆树市', '', 'yushushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220183', '德惠市', '', 'dehuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220184', '高新技术产业开发区', '', 'gaoxinjishuchanyekaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220185', '汽车产业开发区', '', 'qichechanyekaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220186', '经济技术开发区', '', 'jingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220187', '净月区', '', 'jingyuequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220200', '吉林市', 'j', 'jilinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220202', '昌邑区', '', 'changyiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220203', '龙潭区', '', 'longtanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220204', '船营区', '', 'chuanyingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220211', '丰满区', '', 'fengmanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220221', '永吉县', '', 'yongjixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220281', '蛟河市', '', 'heshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220282', '桦甸市', '', 'dianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220283', '舒兰市', '', 'shulanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220284', '磐石市', '', 'panshishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220300', '四平市', 's', 'sipingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220302', '铁西区', '', 'tiexiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220303', '铁东区', '', 'tiedongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220322', '梨树县', '', 'lishuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220323', '伊通满族自治县', '', 'yitongmanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220381', '公主岭市', '', 'gongzhulingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220382', '双辽市', '', 'shuangliaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220400', '辽源市', 'l', 'liaoyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220402', '龙山区', '', 'longshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220403', '西安区', '', 'xianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220421', '东丰县', '', 'dongfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220422', '东辽县', '', 'dongliaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220500', '通化市', 't', 'tonghuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220502', '东昌区', '', 'dongchangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220503', '二道江区', '', 'erdaojiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220521', '通化县', '', 'tonghuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220523', '辉南县', '', 'huinanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220524', '柳河县', '', 'liuhexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220581', '梅河口市', '', 'meihekoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220582', '集安市', '', 'jianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220600', '白山市', 'b', 'baishanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220602', '浑江区', '', 'hunjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220605', '江源区', '', 'jiangyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220621', '抚松县', '', 'fusongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220622', '靖宇县', '', 'jingyuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220623', '长白朝鲜族自治县', '', 'changbaichaoxianzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220681', '临江市', '', 'linjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220700', '松原市', 's', 'songyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220702', '宁江区', '', 'ningjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220721', '前郭尔罗斯蒙古族自治县', '', 'qianguoerluosimengguzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220722', '长岭县', '', 'changlingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220723', '乾安县', '', 'qiananxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220781', '扶余市', '', 'fuyushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220800', '白城市', 'b', 'baichengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220802', '洮北区', '', 'beiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220821', '镇赉县', '', 'zhenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220822', '通榆县', '', 'tongyuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220881', '洮南市', '', 'nanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220882', '大安市', '', 'daanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('220899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222400', '延边朝鲜族自治州', 'y', 'yanbianchaoxianzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222401', '延吉市', '', 'yanjishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222402', '图们市', '', 'tumenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222403', '敦化市', '', 'dunhuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222404', '珲春市', '', 'chunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222405', '龙井市', '', 'longjingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222406', '和龙市', '', 'helongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222424', '汪清县', '', 'wangqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222426', '安图县', '', 'antuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('222499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230100', '哈尔滨市', 'h', 'haerbinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230102', '道里区', '', 'daoliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230103', '南岗区', '', 'nangangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230104', '道外区', '', 'daowaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230107', '动力区', '', 'dongliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230108', '平房区', '', 'pingfangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230109', '松北区', '', 'songbeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230110', '香坊区', '', 'xiangfangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230111', '呼兰区', '', 'hulanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230112', '阿城区', '', 'achengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230123', '依兰县', '', 'yilanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230124', '方正县', '', 'fangzhengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230125', '宾县', '', 'binxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230126', '巴彦县', '', 'bayanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230127', '木兰县', '', 'mulanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230128', '通河县', '', 'tonghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230129', '延寿县', '', 'yanshouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230182', '双城市', '', 'shuangchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230183', '尚志市', '', 'shangzhishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230184', '五常市', '', 'wuchangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230200', '齐齐哈尔市', 'q', 'qiqihaershi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230202', '龙沙区', '', 'longshaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230203', '建华区', '', 'jianhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230204', '铁锋区', '', 'tiefengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230205', '昂昂溪区', '', 'angangxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230206', '富拉尔基区', '', 'fulaerjiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230207', '碾子山区', '', 'nianzishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230208', '梅里斯达斡尔族区', '', 'meilisidawoerzuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230221', '龙江县', '', 'longjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230223', '依安县', '', 'yianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230224', '泰来县', '', 'tailaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230225', '甘南县', '', 'gannanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230227', '富裕县', '', 'fuyuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230229', '克山县', '', 'keshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230230', '克东县', '', 'kedongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230231', '拜泉县', '', 'baiquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230281', '讷河市', '', 'heshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230300', '鸡西市', 'j', 'jixishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230302', '鸡冠区', '', 'jiguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230303', '恒山区', '', 'hengshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230304', '滴道区', '', 'didaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230305', '梨树区', '', 'lishuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230306', '城子河区', '', 'chengzihequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230307', '麻山区', '', 'mashanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230321', '鸡东县', '', 'jidongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230381', '虎林市', '', 'hulinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230382', '密山市', '', 'mishanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230400', '鹤岗市', 'h', 'hegangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230402', '向阳区', '', 'xiangyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230403', '工农区', '', 'gongnongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230404', '南山区', '', 'nanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230405', '兴安区', '', 'xinganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230406', '东山区', '', 'dongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230407', '兴山区', '', 'xingshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230421', '萝北县', '', 'luobeixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230422', '绥滨县', '', 'suibinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230500', '双鸭山市', 's', 'shuangyashanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230502', '尖山区', '', 'jianshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230503', '岭东区', '', 'lingdongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230505', '四方台区', '', 'sifangtaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230506', '宝山区', '', 'baoshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230521', '集贤县', '', 'jixianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230522', '友谊县', '', 'youyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230523', '宝清县', '', 'baoqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230524', '饶河县', '', 'raohexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230600', '大庆市', 'd', 'daqingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230602', '萨尔图区', '', 'saertuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230603', '龙凤区', '', 'longfengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230604', '让胡路区', '', 'ranghuluqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230605', '红岗区', '', 'honggangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230606', '大同区', '', 'datongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230621', '肇州县', '', 'zhaozhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230622', '肇源县', '', 'zhaoyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230623', '林甸县', '', 'lindianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230624', '杜尔伯特蒙古族自治县', '', 'duerbotemengguzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230700', '伊春市', 'y', 'yichunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230702', '伊春区', '', 'yichunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230703', '南岔区', '', 'nanchaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230704', '友好区', '', 'youhaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230705', '西林区', '', 'xilinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230706', '翠峦区', '', 'cuiluanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230707', '新青区', '', 'xinqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230708', '美溪区', '', 'meixiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230709', '金山屯区', '', 'jinshantunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230710', '五营区', '', 'wuyingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230711', '乌马河区', '', 'wumahequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230712', '汤旺河区', '', 'tangwanghequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230713', '带岭区', '', 'dailingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230714', '乌伊岭区', '', 'wuyilingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230715', '红星区', '', 'hongxingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230716', '上甘岭区', '', 'shangganlingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230722', '嘉荫县', '', 'jiayinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230781', '铁力市', '', 'tielishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230800', '佳木斯市', 'j', 'jiamusishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230802', '永红区', '', 'yonghongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230803', '向阳区', '', 'xiangyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230804', '前进区', '', 'qianjinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230805', '东风区', '', 'dongfengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230811', '郊区', '', 'jiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230822', '桦南县', '', 'nanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230826', '桦川县', '', 'chuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230828', '汤原县', '', 'tangyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230833', '抚远县', '', 'fuyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230881', '同江市', '', 'tongjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230882', '富锦市', '', 'fujinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230900', '七台河市', 'q', 'qitaiheshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230902', '新兴区', '', 'xinxingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230903', '桃山区', '', 'taoshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230904', '茄子河区', '', 'qiezihequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230921', '勃利县', '', 'bolixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('230999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231000', '牡丹江市', 'm', 'mudanjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231002', '东安区', '', 'donganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231003', '阳明区', '', 'yangmingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231004', '爱民区', '', 'aiminqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231005', '西安区', '', 'xianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231024', '东宁县', '', 'dongningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231025', '林口县', '', 'linkouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231081', '绥芬河市', '', 'suifenheshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231083', '海林市', '', 'hailinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231084', '宁安市', '', 'ninganshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231085', '穆棱市', '', 'mulengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231100', '黑河市', 'h', 'heiheshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231102', '爱辉区', '', 'aihuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231121', '嫩江县', '', 'nenjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231123', '逊克县', '', 'xunkexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231124', '孙吴县', '', 'sunwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231181', '北安市', '', 'beianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231182', '五大连池市', '', 'wudalianchishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231200', '绥化市', 's', 'suihuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231202', '北林区', '', 'beilinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231221', '望奎县', '', 'wangkuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231222', '兰西县', '', 'lanxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231223', '青冈县', '', 'qinggangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231224', '庆安县', '', 'qinganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231225', '明水县', '', 'mingshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231226', '绥棱县', '', 'suilengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231281', '安达市', '', 'andashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231282', '肇东市', '', 'zhaodongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231283', '海伦市', '', 'hailunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('231299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232700', '大兴安岭地区', 'd', 'daxinganlingdiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232702', '松岭区', '', 'songlingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232703', '新林区', '', 'xinlinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232704', '呼中区', '', 'huzhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232721', '呼玛县', '', 'humaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232722', '塔河县', '', 'tahexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232723', '漠河县', '', 'mohexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232724', '加格达奇区', '', 'jiagedaqiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('232799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310100', '上海市', 's', 'shanghaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310101', '黄浦区', '', 'huangpuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310103', '卢湾区', '', 'luwanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310104', '徐汇区', '', 'xuhuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310105', '长宁区', '', 'changningqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310106', '静安区', '', 'jinganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310107', '普陀区', '', 'putuoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310108', '闸北区', '', 'zhabeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310109', '虹口区', '', 'hongkouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310110', '杨浦区', '', 'yangpuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310112', '闵行区', '', 'xingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310113', '宝山区', '', 'baoshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310114', '嘉定区', '', 'jiadingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310115', '浦东新区', '', 'pudongxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310116', '金山区', '', 'jinshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310117', '松江区', '', 'songjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310118', '青浦区', '', 'qingpuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310119', '南汇区', '', 'nanhuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310120', '奉贤区', '', 'fengxianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310152', '川沙区', '', 'chuanshaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('310199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320100', '南京市', 'n', 'nanjingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320102', '玄武区', '', 'xuanwuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320104', '秦淮区', '', 'qinhuaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320105', '建邺区', '', 'jianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320106', '鼓楼区', '', 'gulouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320111', '浦口区', '', 'pukouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320113', '栖霞区', '', 'qixiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320114', '雨花台区', '', 'yuhuataiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320115', '江宁区', '', 'jiangningqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320116', '六合区', '', 'liuhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320117', '溧水区', '', 'shuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320118', '高淳区', '', 'gaochunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320200', '无锡市', 'w', 'wuxishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320202', '崇安区', '', 'chonganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320203', '南长区', '', 'nanchangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320204', '北塘区', '', 'beitangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320205', '锡山区', '', 'xishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320206', '惠山区', '', 'huishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320211', '滨湖区', '', 'binhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320281', '江阴市', '', 'jiangyinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320282', '宜兴市', '', 'yixingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320296', '新区', '', 'xinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320300', '徐州市', 'x', 'xuzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320302', '鼓楼区', '', 'gulouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320303', '云龙区', '', 'yunlongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320305', '贾汪区', '', 'jiawangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320311', '泉山区', '', 'quanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320312', '铜山区', '', 'tongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320321', '丰县', '', 'fengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320322', '沛县', '', 'peixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320324', '睢宁县', '', 'ningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320381', '新沂市', '', 'xinyishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320382', '邳州市', '', 'zhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320383', '八段工业园区', '', 'baduangongyeyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320384', '金山桥开发区', '', 'jinshanqiaokaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320400', '常州市', 'c', 'changzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320402', '天宁区', '', 'tianningqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320404', '钟楼区', '', 'zhonglouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320405', '戚墅堰区', '', 'qishuyanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320411', '新北区', '', 'xinbeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320412', '武进区', '', 'wujinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320481', '溧阳市', '', 'yangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320482', '金坛市', '', 'jintanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320500', '苏州市', 's', 'suzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320505', '虎丘区', '', 'huqiuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320506', '吴中区', '', 'wuzhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320507', '相城区', '', 'xiangchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320508', '姑苏区', '', 'gusuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320509', '吴江区', '', 'wujiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320510', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320511', '工业园区', '', 'gongyeyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320581', '常熟市', '', 'changshushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320582', '张家港市', '', 'zhangjiagangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320583', '昆山市', '', 'kunshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320585', '太仓市', '', 'taicangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320600', '南通市', 'n', 'nantongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320602', '崇川区', '', 'chongchuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320611', '港闸区', '', 'gangzhaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320612', '通州区', '', 'tongzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320621', '海安县', '', 'haianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320623', '如东县', '', 'rudongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320681', '启东市', '', 'qidongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320682', '如皋市', '', 'rugaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320684', '海门市', '', 'haimenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320685', '南通经济技术开发区', '', 'nantongjingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320693', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320700', '连云港市', 'l', 'lianyungangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320703', '连云区', '', 'lianyunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320705', '新浦区', '', 'xinpuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320706', '海州区', '', 'haizhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320721', '赣榆县', '', 'ganyuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320722', '东海县', '', 'donghaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320723', '灌云县', '', 'guanyunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320724', '灌南县', '', 'guannanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320800', '淮安市', 'h', 'huaianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320802', '清河区', '', 'qinghequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320803', '淮安区', '', 'huaianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320804', '淮阴区', '', 'huaiyinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320811', '清浦区', '', 'qingpuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320826', '涟水县', '', 'lianshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320829', '洪泽县', '', 'hongzexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320830', '盱眙县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320831', '金湖县', '', 'jinhuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320832', '经济开发区', '', 'jingjikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320900', '盐城市', 'y', 'yanchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320902', '亭湖区', '', 'tinghuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320903', '盐都区', '', 'yanduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320921', '响水县', '', 'xiangshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320922', '滨海县', '', 'binhaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320923', '阜宁县', '', 'funingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320924', '射阳县', '', 'sheyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320925', '建湖县', '', 'jianhuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320981', '东台市', '', 'dongtaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320982', '大丰市', '', 'dafengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('320999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321000', '扬州市', 'y', 'yangzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321002', '广陵区', '', 'guanglingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321003', '邗江区', '', 'jiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321011', '维扬区', '', 'weiyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321012', '江都区', '', 'jiangduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321023', '宝应县', '', 'baoyingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321081', '仪征市', '', 'yizhengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321084', '高邮市', '', 'gaoyoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321092', '经济开发区', '', 'jingjikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321100', '镇江市', 'z', 'zhenjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321102', '京口区', '', 'jingkouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321111', '润州区', '', 'runzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321112', '丹徒区', '', 'dantuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321181', '丹阳市', '', 'danyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321182', '扬中市', '', 'yangzhongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321183', '句容市', '', 'jurongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321184', '丹徒新区', '', 'dantuxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321185', '镇江新区', '', 'zhenjiangxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321200', '泰州市', 't', 'taizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321202', '海陵区', '', 'hailingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321203', '高港区', '', 'gaogangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321204', '姜堰区', '', 'jiangyanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321281', '兴化市', '', 'xinghuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321282', '靖江市', '', 'jingjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321283', '泰兴市', '', 'taixingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321300', '宿迁市', 's', 'suqianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321302', '宿城区', '', 'suchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321311', '宿豫区', '', 'suyuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321322', '沭阳县', '', 'yangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321323', '泗阳县', '', 'yangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321324', '泗洪县', '', 'hongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321325', '宿迁经济开发区', '', 'suqianjingjikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('321399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330100', '杭州市', 'h', 'hangzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330102', '上城区', '', 'shangchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330103', '下城区', '', 'xiachengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330104', '江干区', '', 'jiangganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330105', '拱墅区', '', 'gongshuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330106', '西湖区', '', 'xihuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330108', '滨江区', '', 'binjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330109', '萧山区', '', 'xiaoshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330110', '余杭区', '', 'yuhangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330122', '桐庐县', '', 'tongluxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330127', '淳安县', '', 'chunanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330182', '建德市', '', 'jiandeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330183', '富阳市', '', 'fuyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330185', '临安市', '', 'linanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330186', '下沙区', '', 'xiashaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330200', '宁波市', 'n', 'ningboshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330203', '海曙区', '', 'haishuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330204', '江东区', '', 'jiangdongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330205', '江北区', '', 'jiangbeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330206', '北仑区', '', 'beilunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330211', '镇海区', '', 'zhenhaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330212', '鄞州区', '', 'zhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330225', '象山县', '', 'xiangshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330226', '宁海县', '', 'ninghaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330281', '余姚市', '', 'yuyaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330282', '慈溪市', '', 'cixishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330283', '奉化市', '', 'fenghuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330284', '高新科技开发区', '', 'gaoxinkejikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330300', '温州市', 'w', 'wenzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330302', '鹿城区', '', 'luchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330303', '龙湾区', '', 'longwanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330304', '瓯海区', '', 'haiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330322', '洞头县', '', 'dongtouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330324', '永嘉县', '', 'yongjiaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330326', '平阳县', '', 'pingyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330327', '苍南县', '', 'cangnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330328', '文成县', '', 'wenchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330329', '泰顺县', '', 'taishunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330381', '瑞安市', '', 'ruianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330382', '乐清市', '', 'leqingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330383', '茶山高教园区', '', 'chashangaojiaoyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330400', '嘉兴市', 'j', 'jiaxingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330402', '南湖区', '', 'nanhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330411', '秀洲区', '', 'xiuzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330421', '嘉善县', '', 'jiashanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330424', '海盐县', '', 'haiyanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330481', '海宁市', '', 'hainingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330482', '平湖市', '', 'pinghushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330483', '桐乡市', '', 'tongxiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330500', '湖州市', 'h', 'huzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330502', '吴兴区', '', 'wuxingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330503', '南浔区', '', 'nanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330521', '德清县', '', 'deqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330522', '长兴县', '', 'changxingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330523', '安吉县', '', 'anjixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330600', '绍兴市', 's', 'shaoxingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330602', '越城区', '', 'yuechengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330621', '绍兴县', '', 'shaoxingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330624', '新昌县', '', 'xinchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330681', '诸暨市', '', 'zhushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330682', '上虞市', '', 'shangyushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330683', '嵊州市', '', 'zhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330684', '柯桥区', '', 'keqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330700', '金华市', 'j', 'jinhuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330702', '婺城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330703', '金东区', '', 'jindongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330723', '武义县', '', 'wuyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330726', '浦江县', '', 'pujiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330727', '磐安县', '', 'pananxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330781', '兰溪市', '', 'lanxishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330782', '义乌市', '', 'yiwushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330783', '东阳市', '', 'dongyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330784', '永康市', '', 'yongkangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330800', '衢州市', 'q', 'quzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330802', '柯城区', '', 'kechengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330803', '衢江区', '', 'qujiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330822', '常山县', '', 'changshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330824', '开化县', '', 'kaihuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330825', '龙游县', '', 'longyouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330881', '江山市', '', 'jiangshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330900', '舟山市', 'z', 'zhoushanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330902', '定海区', '', 'dinghaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330903', '普陀区', '', 'putuoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330921', '岱山县', '', 'shanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330922', '嵊泗县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('330999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331000', '台州市', 't', 'taizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331002', '椒江区', '', 'jiaojiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331003', '黄岩区', '', 'huangyanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331004', '路桥区', '', 'luqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331021', '玉环县', '', 'yuhuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331022', '三门县', '', 'sanmenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331023', '天台县', '', 'tiantaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331024', '仙居县', '', 'xianjuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331081', '温岭市', '', 'wenlingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331082', '临海市', '', 'linhaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331100', '丽水市', 'l', 'lishuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331102', '莲都区', '', 'lianduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331121', '青田县', '', 'qingtianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331122', '缙云县', '', 'yunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331123', '遂昌县', '', 'suichangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331124', '松阳县', '', 'songyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331125', '云和县', '', 'yunhexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331126', '庆元县', '', 'qingyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331127', '景宁畲族自治县', '', 'jingningzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331181', '龙泉市', '', 'longquanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('331199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340100', '合肥市', 'h', 'hefeishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340102', '瑶海区', '', 'yaohaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340103', '庐阳区', '', 'luyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340104', '蜀山区', '', 'shushanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340111', '包河区', '', 'baohequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340121', '长丰县', '', 'changfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340122', '肥东县', '', 'feidongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340123', '肥西县', '', 'feixixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340124', '庐江县', '', 'lujiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340151', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340181', '巢湖市', '', 'chaohushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340182', '北城新区', '', 'beichengxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340183', '高新技术开发区', '', 'gaoxinjishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340184', '滨湖新区', '', 'binhuxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340185', '新站综合开发试验区', '', 'xinzhanzonghekaifashiyanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340186', '政务文化新区', '', 'zhengwuwenhuaxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340187', '经济技术开发区', '', 'jingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340191', '中区', '', 'zhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340200', '芜湖市', 'w', 'wuhushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340202', '镜湖区', '', 'jinghuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340203', '弋江区', '', 'jiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340207', '鸠江区', '', 'jiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340208', '三山区', '', 'sanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340221', '芜湖县', '', 'wuhuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340222', '繁昌县', '', 'fanchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340223', '南陵县', '', 'nanlingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340225', '无为县', '', 'wuweixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340300', '蚌埠市', 'b', 'bangbushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340302', '龙子湖区', '', 'longzihuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340303', '蚌山区', '', 'bangshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340304', '禹会区', '', 'yuhuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340311', '淮上区', '', 'huaishangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340321', '怀远县', '', 'huaiyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340322', '五河县', '', 'wuhexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340323', '固镇县', '', 'guzhenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340400', '淮南市', 'h', 'huainanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340402', '大通区', '', 'datongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340403', '田家庵区', '', 'tianjiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340404', '谢家集区', '', 'xiejiajiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340405', '八公山区', '', 'bagongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340406', '潘集区', '', 'panjiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340421', '凤台县', '', 'fengtaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340422', '淮南高新技术开发区', '', 'huainangaoxinjishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340500', '马鞍山市', 'm', 'maanshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340502', '金家庄区', '', 'jinjiazhuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340503', '花山区', '', 'huashanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340504', '雨山区', '', 'yushanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340506', '博望区', '', 'bowangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340521', '当涂县', '', 'dangtuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340522', '含山县', '', 'hanshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340523', '和县', '', 'hexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340600', '淮北市', 'h', 'huaibeishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340602', '杜集区', '', 'dujiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340603', '相山区', '', 'xiangshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340604', '烈山区', '', 'lieshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340621', '濉溪县', '', 'xixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340700', '铜陵市', 't', 'tonglingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340702', '铜官山区', '', 'tongguanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340703', '狮子山区', '', 'shizishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340711', '郊区', '', 'jiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340721', '铜陵县', '', 'tonglingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340800', '安庆市', 'a', 'anqingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340802', '迎江区', '', 'yingjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340803', '大观区', '', 'daguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340811', '宜秀区', '', 'yixiuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340822', '怀宁县', '', 'huainingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340823', '枞阳县', '', 'yangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340824', '潜山县', '', 'qianshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340825', '太湖县', '', 'taihuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340826', '宿松县', '', 'susongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340827', '望江县', '', 'wangjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340828', '岳西县', '', 'yuexixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340881', '桐城市', '', 'tongchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340882', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('340899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341000', '黄山市', 'h', 'huangshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341002', '屯溪区', '', 'tunxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341003', '黄山区', '', 'huangshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341004', '徽州区', '', 'huizhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341021', '歙县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341022', '休宁县', '', 'xiuningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341023', '黟县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341024', '祁门县', '', 'qimenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341100', '滁州市', 'c', 'chuzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341102', '琅琊区', '', 'langqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341103', '南谯区', '', 'nanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341122', '来安县', '', 'laianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341124', '全椒县', '', 'quanjiaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341125', '定远县', '', 'dingyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341126', '凤阳县', '', 'fengyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341181', '天长市', '', 'tianchangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341182', '明光市', '', 'mingguangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341200', '阜阳市', 'f', 'fuyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341202', '颍州区', '', 'zhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341203', '颍东区', '', 'dongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341204', '颍泉区', '', 'quanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341221', '临泉县', '', 'linquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341222', '太和县', '', 'taihexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341225', '阜南县', '', 'funanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341226', '颍上县', '', 'shangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341282', '界首市', '', 'jieshoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341283', '经济开发区', '', 'jingjikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341300', '宿州市', 's', 'suzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341302', '埇桥区', '', 'pai', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341321', '砀山县', '', 'shanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341322', '萧县', '', 'xiaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341323', '灵璧县', '', 'lingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341324', '泗县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341325', '经济开发区', '', 'jingjikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341500', '六安市', 'l', 'liuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341502', '金安区', '', 'jinanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341503', '裕安区', '', 'yuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341521', '寿县', '', 'shouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341522', '霍邱县', '', 'huoqiuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341523', '舒城县', '', 'shuchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341524', '金寨县', '', 'jinzhaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341525', '霍山县', '', 'huoshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341600', '亳州市', 'b', 'bozhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341602', '谯城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341621', '涡阳县', '', 'woyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341622', '蒙城县', '', 'mengchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341623', '利辛县', '', 'lixinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341700', '池州市', 'c', 'chizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341702', '贵池区', '', 'guichiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341721', '东至县', '', 'dongzhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341722', '石台县', '', 'shitaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341723', '青阳县', '', 'qingyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341800', '宣城市', 'x', 'xuanchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341802', '宣州区', '', 'xuanzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341821', '郎溪县', '', 'langxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341822', '广德县', '', 'guangdexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341823', '泾县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341824', '绩溪县', '', 'jixixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341825', '旌德县', '', 'dexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341881', '宁国市', '', 'ningguoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('341899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350100', '福州市', 'f', 'fuzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350102', '鼓楼区', '', 'gulouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350103', '台江区', '', 'taijiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350104', '仓山区', '', 'cangshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350105', '马尾区', '', 'maweiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350111', '晋安区', '', 'jinanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350121', '闽侯县', '', 'minhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350122', '连江县', '', 'lianjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350123', '罗源县', '', 'luoyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350124', '闽清县', '', 'minqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350125', '永泰县', '', 'yongtaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350128', '平潭县', '', 'pingtanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350181', '福清市', '', 'fuqingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350182', '长乐市', '', 'changleshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350200', '厦门市', 'x', 'xiamenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350203', '思明区', '', 'simingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350205', '海沧区', '', 'haicangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350206', '湖里区', '', 'huliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350211', '集美区', '', 'jimeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350212', '同安区', '', 'tonganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350213', '翔安区', '', 'xianganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350300', '莆田市', 'p', 'putianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350302', '城厢区', '', 'chengxiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350303', '涵江区', '', 'hanjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350304', '荔城区', '', 'lichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350305', '秀屿区', '', 'xiuyuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350322', '仙游县', '', 'xianyouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350400', '三明市', 's', 'sanmingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350402', '梅列区', '', 'meiliequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350403', '三元区', '', 'sanyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350421', '明溪县', '', 'mingxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350423', '清流县', '', 'qingliuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350424', '宁化县', '', 'ninghuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350425', '大田县', '', 'datianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350426', '尤溪县', '', 'youxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350427', '沙县', '', 'shaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350428', '将乐县', '', 'jianglexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350429', '泰宁县', '', 'tainingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350430', '建宁县', '', 'jianningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350481', '永安市', '', 'yonganshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350500', '泉州市', 'q', 'quanzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350502', '鲤城区', '', 'lichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350503', '丰泽区', '', 'fengzequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350504', '洛江区', '', 'luojiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350505', '泉港区', '', 'quangangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350521', '惠安县', '', 'huianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350524', '安溪县', '', 'anxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350525', '永春县', '', 'yongchunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350526', '德化县', '', 'dehuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350527', '金门县', '', 'jinmenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350581', '石狮市', '', 'shishishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350582', '晋江市', '', 'jinjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350583', '南安市', '', 'nananshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350600', '漳州市', 'z', 'zhangzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350602', '芗城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350603', '龙文区', '', 'longwenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350622', '云霄县', '', 'yunxiaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350623', '漳浦县', '', 'zhangpuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350624', '诏安县', '', 'anxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350625', '长泰县', '', 'changtaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350626', '东山县', '', 'dongshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350627', '南靖县', '', 'nanjingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350628', '平和县', '', 'pinghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350629', '华安县', '', 'huaanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350681', '龙海市', '', 'longhaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350700', '南平市', 'n', 'nanpingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350702', '延平区', '', 'yanpingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350721', '顺昌县', '', 'shunchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350722', '浦城县', '', 'puchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350723', '光泽县', '', 'guangzexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350724', '松溪县', '', 'songxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350725', '政和县', '', 'zhenghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350781', '邵武市', '', 'shaowushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350782', '武夷山市', '', 'wuyishanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350783', '建瓯市', '', 'jianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350784', '建阳市', '', 'jianyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350800', '龙岩市', 'l', 'longyanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350802', '新罗区', '', 'xinluoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350821', '长汀县', '', 'changtingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350822', '永定县', '', 'yongdingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350823', '上杭县', '', 'shanghangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350824', '武平县', '', 'wupingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350825', '连城县', '', 'lianchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350881', '漳平市', '', 'zhangpingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350900', '宁德市', 'n', 'ningdeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350902', '蕉城区', '', 'jiaochengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350921', '霞浦县', '', 'xiapuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350922', '古田县', '', 'gutianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350923', '屏南县', '', 'pingnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350924', '寿宁县', '', 'shouningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350925', '周宁县', '', 'zhouningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350926', '柘荣县', '', 'rongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350981', '福安市', '', 'fuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350982', '福鼎市', '', 'fudingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350983', '东侨开发区', '', 'dongqiaokaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('350999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360100', '南昌市', 'n', 'nanchangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360102', '东湖区', '', 'donghuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360103', '西湖区', '', 'xihuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360104', '青云谱区', '', 'qingyunpuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360105', '湾里区', '', 'wanliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360111', '青山湖区', '', 'qingshanhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360121', '南昌县', '', 'nanchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360122', '新建县', '', 'xinjianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360123', '安义县', '', 'anyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360124', '进贤县', '', 'jinxianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360125', '红谷滩新区', '', 'honggutanxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360126', '经济技术开发区', '', 'jingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360127', '昌北区', '', 'changbeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360128', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360200', '景德镇市', 'j', 'jingdezhenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360202', '昌江区', '', 'changjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360203', '珠山区', '', 'zhushanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360222', '浮梁县', '', 'fuliangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360281', '乐平市', '', 'lepingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360300', '萍乡市', 'p', 'pingxiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360302', '安源区', '', 'anyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360313', '湘东区', '', 'xiangdongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360321', '莲花县', '', 'lianhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360322', '上栗县', '', 'shanglixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360323', '芦溪县', '', 'luxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360400', '九江市', 'j', 'jiujiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360402', '庐山区', '', 'lushanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360403', '浔阳区', '', 'yangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360421', '九江县', '', 'jiujiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360423', '武宁县', '', 'wuningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360424', '修水县', '', 'xiushuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360425', '永修县', '', 'yongxiuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360426', '德安县', '', 'deanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360427', '星子县', '', 'xingzixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360428', '都昌县', '', 'duchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360429', '湖口县', '', 'hukouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360430', '彭泽县', '', 'pengzexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360481', '瑞昌市', '', 'ruichangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360482', '共青城市', '', 'gongqingchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360483', '八里湖新区', '', 'balihuxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360484', '经济技术开发区', '', 'jingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360500', '新余市', 'x', 'xinyushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360502', '渝水区', '', 'yushuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360521', '分宜县', '', 'fenyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360600', '鹰潭市', 'y', 'yingtanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360602', '月湖区', '', 'yuehuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360622', '余江县', '', 'yujiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360681', '贵溪市', '', 'guixishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360682', '龙虎山风景旅游区', '', 'longhushanfengjinglvyouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360700', '赣州市', 'g', 'ganzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360702', '章贡区', '', 'zhanggongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360721', '赣县', '', 'ganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360722', '信丰县', '', 'xinfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360723', '大余县', '', 'dayuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360724', '上犹县', '', 'shangyouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360725', '崇义县', '', 'chongyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360726', '安远县', '', 'anyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360727', '龙南县', '', 'longnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360728', '定南县', '', 'dingnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360729', '全南县', '', 'quannanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360730', '宁都县', '', 'ningduxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360731', '于都县', '', 'yuduxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360732', '兴国县', '', 'xingguoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360733', '会昌县', '', 'huichangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360734', '寻乌县', '', 'xunwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360735', '石城县', '', 'shichengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360751', '黄金区', '', 'huangjinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360781', '瑞金市', '', 'ruijinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360782', '南康市', '', 'nankangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360800', '吉安市', 'j', 'jianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360802', '吉州区', '', 'jizhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360803', '青原区', '', 'qingyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360821', '吉安县', '', 'jianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360822', '吉水县', '', 'jishuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360823', '峡江县', '', 'xiajiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360824', '新干县', '', 'xinganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360825', '永丰县', '', 'yongfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360826', '泰和县', '', 'taihexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360827', '遂川县', '', 'suichuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360828', '万安县', '', 'wananxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360829', '安福县', '', 'anfuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360830', '永新县', '', 'yongxinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360881', '井冈山市', '', 'jinggangshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360900', '宜春市', 'y', 'yichunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360902', '袁州区', '', 'yuanzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360921', '奉新县', '', 'fengxinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360922', '万载县', '', 'wanzaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360923', '上高县', '', 'shanggaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360924', '宜丰县', '', 'yifengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360925', '靖安县', '', 'jinganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360926', '铜鼓县', '', 'tongguxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360981', '丰城市', '', 'fengchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360982', '樟树市', '', 'zhangshushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360983', '高安市', '', 'gaoanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('360999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361000', '抚州市', 'f', 'fuzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361002', '临川区', '', 'linchuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361021', '南城县', '', 'nanchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361022', '黎川县', '', 'lichuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361023', '南丰县', '', 'nanfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361024', '崇仁县', '', 'chongrenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361025', '乐安县', '', 'leanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361026', '宜黄县', '', 'yihuangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361027', '金溪县', '', 'jinxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361028', '资溪县', '', 'zixixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361029', '东乡县', '', 'dongxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361030', '广昌县', '', 'guangchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361100', '上饶市', 's', 'shangraoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361102', '信州区', '', 'xinzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361121', '上饶县', '', 'shangraoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361122', '广丰县', '', 'guangfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361123', '玉山县', '', 'yushanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361124', '铅山县', '', 'qianshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361125', '横峰县', '', 'hengfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361126', '弋阳县', '', 'yangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361127', '余干县', '', 'yuganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361128', '鄱阳县', '', 'yangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361129', '万年县', '', 'wannianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361130', '婺源县', '', 'yuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361181', '德兴市', '', 'dexingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('361199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370100', '济南市', 'j', 'jinanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370102', '历下区', '', 'lixiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370103', '市中区', '', 'shizhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370104', '槐荫区', '', 'huaiyinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370105', '天桥区', '', 'tianqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370112', '历城区', '', 'lichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370113', '长清区', '', 'changqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370124', '平阴县', '', 'pingyinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370125', '济阳县', '', 'jiyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370126', '商河县', '', 'shanghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370181', '章丘市', '', 'zhangqiushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370182', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370200', '青岛市', 'q', 'qingdaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370202', '市南区', '', 'shinanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370203', '市北区', '', 'shibeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370205', '四方区', '', 'sifangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370211', '黄岛区', '', 'huangdaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370212', '崂山区', '', 'shanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370213', '李沧区', '', 'licangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370214', '城阳区', '', 'chengyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370251', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370281', '胶州市', '', 'jiaozhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370282', '即墨市', '', 'jimoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370283', '平度市', '', 'pingdushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370284', '胶南市', '', 'jiaonanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370285', '莱西市', '', 'laixishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370300', '淄博市', 'z', 'ziboshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370302', '淄川区', '', 'zichuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370303', '张店区', '', 'zhangdianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370304', '博山区', '', 'boshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370305', '临淄区', '', 'linziqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370306', '周村区', '', 'zhoucunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370321', '桓台县', '', 'huantaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370322', '高青县', '', 'gaoqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370323', '沂源县', '', 'yiyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370400', '枣庄市', 'z', 'zaozhuangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370402', '市中区', '', 'shizhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370403', '薛城区', '', 'xuechengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370404', '峄城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370405', '台儿庄区', '', 'taierzhuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370406', '山亭区', '', 'shantingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370481', '滕州市', '', 'zhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370500', '东营市', 'd', 'dongyingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370502', '东营区', '', 'dongyingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370503', '河口区', '', 'hekouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370521', '垦利县', '', 'kenlixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370522', '利津县', '', 'lijinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370523', '广饶县', '', 'guangraoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370589', '西城区', '', 'xichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370590', '东城区', '', 'dongchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370600', '烟台市', 'y', 'yantaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370602', '芝罘区', '', 'zhiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370611', '福山区', '', 'fushanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370612', '牟平区', '', 'moupingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370613', '莱山区', '', 'laishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370634', '长岛县', '', 'changdaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370681', '龙口市', '', 'longkoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370682', '莱阳市', '', 'laiyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370683', '莱州市', '', 'laizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370684', '蓬莱市', '', 'penglaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370685', '招远市', '', 'zhaoyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370686', '栖霞市', '', 'qixiashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370687', '海阳市', '', 'haiyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370688', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370700', '潍坊市', 'w', 'weifangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370702', '潍城区', '', 'weichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370703', '寒亭区', '', 'hantingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370704', '坊子区', '', 'fangziqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370705', '奎文区', '', 'kuiwenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370724', '临朐县', '', 'linxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370725', '昌乐县', '', 'changlexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370751', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370781', '青州市', '', 'qingzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370782', '诸城市', '', 'zhuchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370783', '寿光市', '', 'shouguangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370784', '安丘市', '', 'anqiushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370785', '高密市', '', 'gaomishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370786', '昌邑市', '', 'changyishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370787', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370800', '济宁市', 'j', 'jiningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370802', '市中区', '', 'shizhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370811', '任城区', '', 'renchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370826', '微山县', '', 'weishanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370827', '鱼台县', '', 'yutaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370828', '金乡县', '', 'jinxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370829', '嘉祥县', '', 'jiaxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370830', '汶上县', '', 'shangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370831', '泗水县', '', 'shuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370832', '梁山县', '', 'liangshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370881', '曲阜市', '', 'qufushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370882', '兖州市', '', 'zhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370883', '邹城市', '', 'zouchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370884', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370900', '泰安市', 't', 'taianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370902', '泰山区', '', 'taishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370911', '岱岳区', '', 'yuequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370921', '宁阳县', '', 'ningyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370923', '东平县', '', 'dongpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370982', '新泰市', '', 'xintaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370983', '肥城市', '', 'feichengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('370999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371000', '威海市', 'w', 'weihaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371002', '环翠区', '', 'huancuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371081', '文登市', '', 'wendengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371082', '荣成市', '', 'rongchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371083', '乳山市', '', 'rushanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371084', '工业新区', '', 'gongyexinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371100', '日照市', 'r', 'rizhaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371102', '东港区', '', 'donggangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371103', '岚山区', '', 'shanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371121', '五莲县', '', 'wulianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371122', '莒县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371123', '新市区', '', 'xinshiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371200', '莱芜市', 'l', 'laiwushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371202', '莱城区', '', 'laichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371203', '钢城区', '', 'gangchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371300', '临沂市', 'l', 'linyishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371302', '兰山区', '', 'lanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371311', '罗庄区', '', 'luozhuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371312', '河东区', '', 'hedongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371321', '沂南县', '', 'yinanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371322', '郯城县', '', 'chengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371323', '沂水县', '', 'yishuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371324', '苍山县', '', 'cangshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371325', '费县', '', 'feixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371326', '平邑县', '', 'pingyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371327', '莒南县', '', 'nanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371328', '蒙阴县', '', 'mengyinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371329', '临沭县', '', 'linxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371400', '德州市', 'd', 'dezhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371402', '德城区', '', 'dechengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371421', '陵县', '', 'lingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371422', '宁津县', '', 'ningjinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371423', '庆云县', '', 'qingyunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371424', '临邑县', '', 'linyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371425', '齐河县', '', 'qihexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371426', '平原县', '', 'pingyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371427', '夏津县', '', 'xiajinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371428', '武城县', '', 'wuchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371451', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371481', '乐陵市', '', 'lelingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371482', '禹城市', '', 'yuchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371500', '聊城市', 'l', 'liaochengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371502', '东昌府区', '', 'dongchangfuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371521', '阳谷县', '', 'yangguxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371522', '莘县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371523', '茌平县', '', 'pingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371524', '东阿县', '', 'dongaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371525', '冠县', '', 'guanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371526', '高唐县', '', 'gaotangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371581', '临清市', '', 'linqingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371600', '滨州市', 'b', 'binzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371602', '滨城区', '', 'binchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371621', '惠民县', '', 'huiminxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371622', '阳信县', '', 'yangxinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371623', '无棣县', '', 'wuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371624', '沾化县', '', 'zhanhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371625', '博兴县', '', 'boxingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371626', '邹平县', '', 'zoupingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371627', '北海新区', '', 'beihaixinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371700', '菏泽市', 'h', 'hezeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371702', '牡丹区', '', 'mudanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371721', '曹县', '', 'caoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371722', '单县', '', 'danxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371723', '成武县', '', 'chengwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371724', '巨野县', '', 'juyexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371725', '郓城县', '', 'chengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371726', '鄄城县', '', 'chengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371727', '定陶县', '', 'dingtaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371728', '东明县', '', 'dongmingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('371799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410100', '郑州市', 'z', 'zhengzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410102', '中原区', '', 'zhongyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410103', '二七区', '', 'erqiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410104', '管城回族区', '', 'guanchenghuizuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410105', '金水区', '', 'jinshuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410106', '上街区', '', 'shangjiequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410108', '惠济区', '', 'huijiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410122', '中牟县', '', 'zhongmouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410181', '巩义市', '', 'gongyishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410182', '荥阳市', '', 'yangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410183', '新密市', '', 'xinmishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410184', '新郑市', '', 'xinzhengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410185', '登封市', '', 'dengfengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410186', '郑东新区', '', 'zhengdongxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410187', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410188', '高新技术开发区', '', 'gaoxinjishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410189', '经济开发区', '', 'jingjikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410200', '开封市', 'k', 'kaifengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410202', '龙亭区', '', 'longtingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410203', '顺河回族区', '', 'shunhehuizuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410204', '鼓楼区', '', 'gulouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410205', '禹王台区', '', 'yuwangtaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410211', '金明区', '', 'jinmingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410221', '杞县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410222', '通许县', '', 'tongxuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410223', '尉氏县', '', 'weishixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410224', '开封县', '', 'kaifengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410225', '兰考县', '', 'lankaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410300', '洛阳市', 'l', 'luoyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410302', '老城区', '', 'laochengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410303', '西工区', '', 'xigongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410304', '瀍河回族区', '', 'ehehuizuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410305', '涧西区', '', 'jianxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410306', '吉利区', '', 'jiliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410311', '洛龙区', '', 'luolongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410322', '孟津县', '', 'mengjinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410323', '新安县', '', 'xinanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410324', '栾川县', '', 'chuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410325', '嵩县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410326', '汝阳县', '', 'ruyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410327', '宜阳县', '', 'yiyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410328', '洛宁县', '', 'luoningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410329', '伊川县', '', 'yichuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410381', '偃师市', '', 'shishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410382', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410383', '伊滨区', '', 'yibinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410400', '平顶山市', 'p', 'pingdingshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410402', '新华区', '', 'xinhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410403', '卫东区', '', 'weidongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410404', '石龙区', '', 'shilongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410411', '湛河区', '', 'zhanhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410421', '宝丰县', '', 'baofengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410422', '叶县', '', 'yexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410423', '鲁山县', '', 'lushanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410425', '郏县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410481', '舞钢市', '', 'wugangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410482', '汝州市', '', 'ruzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410500', '安阳市', 'a', 'anyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410502', '文峰区', '', 'wenfengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410503', '北关区', '', 'beiguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410505', '殷都区', '', 'yinduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410506', '龙安区', '', 'longanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410522', '安阳县', '', 'anyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410523', '汤阴县', '', 'tangyinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410526', '滑县', '', 'huaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410527', '内黄县', '', 'neihuangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410581', '林州市', '', 'linzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410582', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410600', '鹤壁市', 'h', 'hebishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410602', '鹤山区', '', 'heshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410603', '山城区', '', 'shanchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410611', '淇滨区', '', 'binqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410621', '浚县', '', 'junxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410622', '淇县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410700', '新乡市', 'x', 'xinxiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410702', '红旗区', '', 'hongqiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410703', '卫滨区', '', 'weibinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410704', '凤泉区', '', 'fengquanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410711', '牧野区', '', 'muyequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410721', '新乡县', '', 'xinxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410724', '获嘉县', '', 'huojiaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410725', '原阳县', '', 'yuanyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410726', '延津县', '', 'yanjinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410727', '封丘县', '', 'fengqiuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410728', '长垣县', '', 'changyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410781', '卫辉市', '', 'weihuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410782', '辉县市', '', 'huixianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410800', '焦作市', 'j', 'jiaozuoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410802', '解放区', '', 'jiefangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410803', '中站区', '', 'zhongzhanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410804', '马村区', '', 'macunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410811', '山阳区', '', 'shanyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410821', '修武县', '', 'xiuwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410822', '博爱县', '', 'boaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410823', '武陟县', '', 'wuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410825', '温县', '', 'wenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410882', '沁阳市', '', 'qinyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410883', '孟州市', '', 'mengzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410900', '濮阳市', 'p', 'puyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410902', '华龙区', '', 'hualongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410922', '清丰县', '', 'qingfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410923', '南乐县', '', 'nanlexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410926', '范县', '', 'fanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410927', '台前县', '', 'taiqianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410928', '濮阳县', '', 'puyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('410999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411000', '许昌市', 'x', 'xuchangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411002', '魏都区', '', 'weiduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411023', '许昌县', '', 'xuchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411024', '鄢陵县', '', 'lingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411025', '襄城县', '', 'xiangchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411081', '禹州市', '', 'yuzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411082', '长葛市', '', 'changgeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411100', '漯河市', 'l', 'luoheshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411102', '源汇区', '', 'yuanhuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411103', '郾城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411104', '召陵区', '', 'zhaolingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411121', '舞阳县', '', 'wuyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411122', '临颍县', '', 'linxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411200', '三门峡市', 's', 'sanmenxiashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411202', '湖滨区', '', 'hubinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411221', '渑池县', '', 'chixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411222', '陕县', '', 'shanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411224', '卢氏县', '', 'lushixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411281', '义马市', '', 'yimashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411282', '灵宝市', '', 'lingbaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411300', '南阳市', 'n', 'nanyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411302', '宛城区', '', 'wanchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411303', '卧龙区', '', 'wolongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411321', '南召县', '', 'nanzhaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411322', '方城县', '', 'fangchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411323', '西峡县', '', 'xixiaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411324', '镇平县', '', 'zhenpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411325', '内乡县', '', 'neixiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411326', '淅川县', '', 'chuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411327', '社旗县', '', 'sheqixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411328', '唐河县', '', 'tanghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411329', '新野县', '', 'xinyexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411330', '桐柏县', '', 'tongbaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411381', '邓州市', '', 'dengzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411400', '商丘市', 's', 'shangqiushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411402', '梁园区', '', 'liangyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411403', '睢阳区', '', 'yangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411421', '民权县', '', 'minquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411422', '睢县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411423', '宁陵县', '', 'ninglingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411424', '柘城县', '', 'chengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411425', '虞城县', '', 'yuchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411426', '夏邑县', '', 'xiayixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411481', '永城市', '', 'yongchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411500', '信阳市', 'x', 'xinyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411502', '浉河区', '', 'fuyou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411503', '平桥区', '', 'pingqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411521', '罗山县', '', 'luoshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411522', '光山县', '', 'guangshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411523', '新县', '', 'xinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411524', '商城县', '', 'shangchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411525', '固始县', '', 'gushixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411526', '潢川县', '', 'chuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411527', '淮滨县', '', 'huaibinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411528', '息县', '', 'xixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411600', '周口市', 'z', 'zhoukoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411602', '川汇区', '', 'chuanhuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411621', '扶沟县', '', 'fugouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411622', '西华县', '', 'xihuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411623', '商水县', '', 'shangshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411624', '沈丘县', '', 'shenqiuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411625', '郸城县', '', 'danchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411626', '淮阳县', '', 'huaiyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411627', '太康县', '', 'taikangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411628', '鹿邑县', '', 'luyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411681', '项城市', '', 'xiangchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411682', '经济开发区', '', 'jingjikaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411683', '东新区', '', 'dongxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411700', '驻马店市', 'z', 'zhumadianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411702', '驿城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411721', '西平县', '', 'xipingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411722', '上蔡县', '', 'shangcaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411723', '平舆县', '', 'pingyuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411724', '正阳县', '', 'zhengyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411725', '确山县', '', 'queshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411726', '泌阳县', '', 'miyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411727', '汝南县', '', 'runanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411728', '遂平县', '', 'suipingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411729', '新蔡县', '', 'xincaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('411799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('419000', '省直辖县级行政区划', 's', 'shengzhixiaxianjixingzhengquhua', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('419001', '济源市', '', 'jiyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420100', '武汉市', 'w', 'wuhanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420102', '江岸区', '', 'jianganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420103', '江汉区', '', 'jianghanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420104', '硚口区', '', 'changkouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420105', '汉阳区', '', 'hanyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420106', '武昌区', '', 'wuchangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420107', '青山区', '', 'qingshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420111', '洪山区', '', 'hongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420112', '东西湖区', '', 'dongxihuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420113', '汉南区', '', 'hannanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420114', '蔡甸区', '', 'caidianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420115', '江夏区', '', 'jiangxiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420116', '黄陂区', '', 'huangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420117', '新洲区', '', 'xinzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420118', '武汉经济技术开发区', '', 'wuhanjingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420200', '黄石市', 'h', 'huangshishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420202', '黄石港区', '', 'huangshigangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420203', '西塞山区', '', 'xisaishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420204', '下陆区', '', 'xialuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420205', '铁山区', '', 'tieshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420222', '阳新县', '', 'yangxinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420281', '大冶市', '', 'dayeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420282', '经济技术开发区', '', 'jingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420300', '十堰市', 's', 'shiyanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420302', '茅箭区', '', 'maojianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420303', '张湾区', '', 'zhangwanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420321', '郧县', '', 'yunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420322', '郧西县', '', 'yunxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420323', '竹山县', '', 'zhushanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420324', '竹溪县', '', 'zhuxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420325', '房县', '', 'fangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420381', '丹江口市', '', 'danjiangkoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420382', '城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420500', '宜昌市', 'y', 'yichangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420502', '西陵区', '', 'xilingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420503', '伍家岗区', '', 'wujiagangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420504', '点军区', '', 'dianjunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420505', '猇亭区', '', 'tingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420506', '夷陵区', '', 'yilingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420525', '远安县', '', 'yuananxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420526', '兴山县', '', 'xingshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420527', '秭归县', '', 'guixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420528', '长阳土家族自治县', '', 'changyangtujiazuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420529', '五峰土家族自治县', '', 'wufengtujiazuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420551', '葛洲坝区', '', 'gezhoubaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420552', '开发区', '', 'kaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420581', '宜都市', '', 'yidushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420582', '当阳市', '', 'dangyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420583', '枝江市', '', 'zhijiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420600', '襄阳市', 'x', 'xiangyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420602', '襄城区', '', 'xiangchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420606', '樊城区', '', 'fanchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420607', '襄州区', '', 'xiangzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420624', '南漳县', '', 'nanzhangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420625', '谷城县', '', 'guchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420626', '保康县', '', 'baokangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420682', '老河口市', '', 'laohekoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420683', '枣阳市', '', 'zaoyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420684', '宜城市', '', 'yichengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420700', '鄂州市', 'e', 'ezhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420702', '梁子湖区', '', 'liangzihuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420703', '华容区', '', 'huarongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420704', '鄂城区', '', 'echengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420800', '荆门市', 'j', 'jingmenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420802', '东宝区', '', 'dongbaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420804', '掇刀区', '', 'duodaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420821', '京山县', '', 'jingshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420822', '沙洋县', '', 'shayangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420881', '钟祥市', '', 'zhongxiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420900', '孝感市', 'x', 'xiaoganshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420902', '孝南区', '', 'xiaonanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420921', '孝昌县', '', 'xiaochangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420922', '大悟县', '', 'dawuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420923', '云梦县', '', 'yunmengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420981', '应城市', '', 'yingchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420982', '安陆市', '', 'anlushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420984', '汉川市', '', 'hanchuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('420999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421000', '荆州市', 'j', 'jingzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421002', '沙市区', '', 'shashiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421003', '荆州区', '', 'jingzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421022', '公安县', '', 'gonganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421023', '监利县', '', 'jianlixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421024', '江陵县', '', 'jianglingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421081', '石首市', '', 'shishoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421083', '洪湖市', '', 'honghushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421087', '松滋市', '', 'songzishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421100', '黄冈市', 'h', 'huanggangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421102', '黄州区', '', 'huangzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421121', '团风县', '', 'tuanfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421122', '红安县', '', 'honganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421123', '罗田县', '', 'luotianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421124', '英山县', '', 'yingshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421125', '浠水县', '', 'shuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421126', '蕲春县', '', 'chunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421127', '黄梅县', '', 'huangmeixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421181', '麻城市', '', 'machengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421182', '武穴市', '', 'wuxueshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421200', '咸宁市', 'x', 'xianningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421202', '咸安区', '', 'xiananqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421221', '嘉鱼县', '', 'jiayuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421222', '通城县', '', 'tongchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421223', '崇阳县', '', 'chongyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421224', '通山县', '', 'tongshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421281', '赤壁市', '', 'chibishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421282', '温泉城区', '', 'wenquanchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421300', '随州市', 's', 'suizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421303', '曾都区', '', 'zengduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421321', '随县', '', 'suixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421381', '广水市', '', 'guangshuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('421399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422800', '恩施土家族苗族自治州', 'e', 'enshitujiazumiaozuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422801', '恩施市', '', 'enshishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422802', '利川市', '', 'lichuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422822', '建始县', '', 'jianshixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422823', '巴东县', '', 'badongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422825', '宣恩县', '', 'xuanenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422826', '咸丰县', '', 'xianfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422827', '来凤县', '', 'laifengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422828', '鹤峰县', '', 'hefengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('422899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('429000', '省直辖县级行政区划', 's', 'shengzhixiaxianjixingzhengquhua', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('429004', '仙桃市', '', 'xiantaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('429005', '潜江市', '', 'qianjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('429006', '天门市', '', 'tianmenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('429021', '神农架林区', '', 'shennongjialinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430100', '长沙市', 'c', 'changshashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430102', '芙蓉区', '', 'rongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430103', '天心区', '', 'tianxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430104', '岳麓区', '', 'yueluqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430105', '开福区', '', 'kaifuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430111', '雨花区', '', 'yuhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430112', '望城区', '', 'wangchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430121', '长沙县', '', 'changshaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430124', '宁乡县', '', 'ningxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430181', '浏阳市', '', 'yangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430200', '株洲市', 'z', 'zhuzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430202', '荷塘区', '', 'hetangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430203', '芦淞区', '', 'luqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430204', '石峰区', '', 'shifengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430211', '天元区', '', 'tianyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430221', '株洲县', '', 'zhuzhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430223', '攸县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430224', '茶陵县', '', 'chalingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430225', '炎陵县', '', 'yanlingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430281', '醴陵市', '', 'lingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430300', '湘潭市', 'x', 'xiangtanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430302', '雨湖区', '', 'yuhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430304', '岳塘区', '', 'yuetangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430321', '湘潭县', '', 'xiangtanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430381', '湘乡市', '', 'xiangxiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430382', '韶山市', '', 'shaoshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430400', '衡阳市', 'h', 'hengyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430405', '珠晖区', '', 'zhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430406', '雁峰区', '', 'yanfengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430407', '石鼓区', '', 'shiguqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430408', '蒸湘区', '', 'zhengxiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430412', '南岳区', '', 'nanyuequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430421', '衡阳县', '', 'hengyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430422', '衡南县', '', 'hengnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430423', '衡山县', '', 'hengshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430424', '衡东县', '', 'hengdongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430426', '祁东县', '', 'qidongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430481', '耒阳市', '', 'yangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430482', '常宁市', '', 'changningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430500', '邵阳市', 's', 'shaoyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430502', '双清区', '', 'shuangqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430503', '大祥区', '', 'daxiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430511', '北塔区', '', 'beitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430521', '邵东县', '', 'shaodongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430522', '新邵县', '', 'xinshaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430523', '邵阳县', '', 'shaoyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430524', '隆回县', '', 'longhuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430525', '洞口县', '', 'dongkouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430527', '绥宁县', '', 'suiningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430528', '新宁县', '', 'xinningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430529', '城步苗族自治县', '', 'chengbumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430581', '武冈市', '', 'wugangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430600', '岳阳市', 'y', 'yueyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430602', '岳阳楼区', '', 'yueyanglouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430603', '云溪区', '', 'yunxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430611', '君山区', '', 'junshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430621', '岳阳县', '', 'yueyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430623', '华容县', '', 'huarongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430624', '湘阴县', '', 'xiangyinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430626', '平江县', '', 'pingjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430681', '汨罗市', '', 'luoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430682', '临湘市', '', 'linxiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430700', '常德市', 'c', 'changdeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430702', '武陵区', '', 'wulingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430703', '鼎城区', '', 'dingchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430721', '安乡县', '', 'anxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430722', '汉寿县', '', 'hanshouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430723', '澧县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430724', '临澧县', '', 'linxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430725', '桃源县', '', 'taoyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430726', '石门县', '', 'shimenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430781', '津市市', '', 'jinshishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430800', '张家界市', 'z', 'zhangjiajieshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430802', '永定区', '', 'yongdingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430811', '武陵源区', '', 'wulingyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430821', '慈利县', '', 'cilixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430822', '桑植县', '', 'sangzhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430900', '益阳市', 'y', 'yiyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430902', '资阳区', '', 'ziyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430903', '赫山区', '', 'heshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430921', '南县', '', 'nanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430922', '桃江县', '', 'taojiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430923', '安化县', '', 'anhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430981', '沅江市', '', 'jiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('430999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431000', '郴州市', 'c', 'chenzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431002', '北湖区', '', 'beihuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431003', '苏仙区', '', 'suxianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431021', '桂阳县', '', 'guiyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431022', '宜章县', '', 'yizhangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431023', '永兴县', '', 'yongxingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431024', '嘉禾县', '', 'jiahexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431025', '临武县', '', 'linwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431026', '汝城县', '', 'ruchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431027', '桂东县', '', 'guidongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431028', '安仁县', '', 'anrenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431081', '资兴市', '', 'zixingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431100', '永州市', 'y', 'yongzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431102', '零陵区', '', 'linglingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431103', '冷水滩区', '', 'lengshuitanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431121', '祁阳县', '', 'qiyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431122', '东安县', '', 'donganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431123', '双牌县', '', 'shuangpaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431124', '道县', '', 'daoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431125', '江永县', '', 'jiangyongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431126', '宁远县', '', 'ningyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431127', '蓝山县', '', 'lanshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431128', '新田县', '', 'xintianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431129', '江华瑶族自治县', '', 'jianghuayaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431200', '怀化市', 'h', 'huaihuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431202', '鹤城区', '', 'hechengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431221', '中方县', '', 'zhongfangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431222', '沅陵县', '', 'lingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431223', '辰溪县', '', 'chenxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431224', '溆浦县', '', 'puxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431225', '会同县', '', 'huitongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431226', '麻阳苗族自治县', '', 'mayangmiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431227', '新晃侗族自治县', '', 'xinhuangdongzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431228', '芷江侗族自治县', '', 'jiangdongzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431229', '靖州苗族侗族自治县', '', 'jingzhoumiaozudongzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431230', '通道侗族自治县', '', 'tongdaodongzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431281', '洪江市', '', 'hongjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431300', '娄底市', 'l', 'loudishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431302', '娄星区', '', 'louxingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431321', '双峰县', '', 'shuangfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431322', '新化县', '', 'xinhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431381', '冷水江市', '', 'lengshuijiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431382', '涟源市', '', 'lianyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('431399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433100', '湘西土家族苗族自治州', 'x', 'xiangxitujiazumiaozuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433101', '吉首市', '', 'jishoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433122', '泸溪县', '', 'luxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433123', '凤凰县', '', 'fenghuangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433124', '花垣县', '', 'huayuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433125', '保靖县', '', 'baojingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433126', '古丈县', '', 'guzhangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433127', '永顺县', '', 'yongshunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433130', '龙山县', '', 'longshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433131', '韶山市', '', 'shaoshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433132', '韶山市区内', '', 'shaoshanshiqunei', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('433199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440100', '广州市', 'g', 'guangzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440103', '荔湾区', '', 'liwanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440104', '越秀区', '', 'yuexiuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440105', '海珠区', '', 'haizhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440106', '天河区', '', 'tianhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440111', '白云区', '', 'baiyunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440112', '黄埔区', '', 'huangpuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440113', '番禺区', '', 'fanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440114', '花都区', '', 'huaduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440115', '南沙区', '', 'nanshaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440116', '萝岗区', '', 'luogangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440183', '增城市', '', 'zengchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440184', '从化市', '', 'conghuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440188', '东山区', '', 'dongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440200', '韶关市', 's', 'shaoguanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440203', '武江区', '', 'wujiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440204', '浈江区', '', 'jiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440205', '曲江区', '', 'qujiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440222', '始兴县', '', 'shixingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440224', '仁化县', '', 'renhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440229', '翁源县', '', 'wengyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440232', '乳源瑶族自治县', '', 'ruyuanyaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440233', '新丰县', '', 'xinfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440281', '乐昌市', '', 'lechangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440282', '南雄市', '', 'nanxiongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440300', '深圳市', 's', 'shenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440303', '罗湖区', '', 'luohuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440304', '福田区', '', 'futianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440305', '南山区', '', 'nanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440306', '宝安区', '', 'baoanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440307', '龙岗区', '', 'longgangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440308', '盐田区', '', 'yantianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440320', '光明新区', '', 'guangmingxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440321', '坪山新区', '', 'pingshanxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440322', '大鹏新区', '', 'dapengxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440323', '龙华新区', '', 'longhuaxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440400', '珠海市', 'z', 'zhuhaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440402', '香洲区', '', 'xiangzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440403', '斗门区', '', 'doumenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440404', '金湾区', '', 'jinwanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440486', '金唐区', '', 'jintangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440487', '南湾区', '', 'nanwanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440500', '汕头市', 's', 'shantoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440507', '龙湖区', '', 'longhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440511', '金平区', '', 'jinpingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440512', '濠江区', '', 'jiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440513', '潮阳区', '', 'chaoyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440514', '潮南区', '', 'chaonanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440515', '澄海区', '', 'chenghaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440523', '南澳县', '', 'nanaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440600', '佛山市', 'f', 'foshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440604', '禅城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440605', '南海区', '', 'nanhaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440606', '顺德区', '', 'shundequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440607', '三水区', '', 'sanshuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440608', '高明区', '', 'gaomingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440700', '江门市', 'j', 'jiangmenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440703', '蓬江区', '', 'pengjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440704', '江海区', '', 'jianghaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440705', '新会区', '', 'xinhuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440781', '台山市', '', 'taishanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440783', '开平市', '', 'kaipingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440784', '鹤山市', '', 'heshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440785', '恩平市', '', 'enpingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440800', '湛江市', 'z', 'zhanjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440802', '赤坎区', '', 'chikanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440803', '霞山区', '', 'xiashanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440804', '坡头区', '', 'potouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440811', '麻章区', '', 'mazhangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440823', '遂溪县', '', 'suixixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440825', '徐闻县', '', 'xuwenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440881', '廉江市', '', 'lianjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440882', '雷州市', '', 'leizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440883', '吴川市', '', 'wuchuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440884', '经济技术开发区', '', 'jingjijishukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440900', '茂名市', 'm', 'maomingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440902', '茂南区', '', 'maonanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440903', '茂港区', '', 'maogangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440923', '电白县', '', 'dianbaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440981', '高州市', '', 'gaozhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440982', '化州市', '', 'huazhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440983', '信宜市', '', 'xinyishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('440999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441200', '肇庆市', 'z', 'zhaoqingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441202', '端州区', '', 'duanzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441203', '鼎湖区', '', 'dinghuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441223', '广宁县', '', 'guangningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441224', '怀集县', '', 'huaijixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441225', '封开县', '', 'fengkaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441226', '德庆县', '', 'deqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441283', '高要市', '', 'gaoyaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441284', '四会市', '', 'sihuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441300', '惠州市', 'h', 'huizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441302', '惠城区', '', 'huichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441303', '惠阳区', '', 'huiyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441322', '博罗县', '', 'boluoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441323', '惠东县', '', 'huidongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441324', '龙门县', '', 'longmenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441325', '大亚湾区', '', 'dayawanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441400', '梅州市', 'm', 'meizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441402', '梅江区', '', 'meijiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441421', '梅县', '', 'meixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441422', '大埔县', '', 'dapuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441423', '丰顺县', '', 'fengshunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441424', '五华县', '', 'wuhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441426', '平远县', '', 'pingyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441427', '蕉岭县', '', 'jiaolingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441481', '兴宁市', '', 'xingningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441500', '汕尾市', 's', 'shanweishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441502', '城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441521', '海丰县', '', 'haifengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441523', '陆河县', '', 'luhexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441581', '陆丰市', '', 'lufengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441600', '河源市', 'h', 'heyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441602', '源城区', '', 'yuanchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441621', '紫金县', '', 'zijinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441622', '龙川县', '', 'longchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441623', '连平县', '', 'lianpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441624', '和平县', '', 'hepingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441625', '东源县', '', 'dongyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441700', '阳江市', 'y', 'yangjiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441702', '江城区', '', 'jiangchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441721', '阳西县', '', 'yangxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441723', '阳东县', '', 'yangdongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441781', '阳春市', '', 'yangchunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441800', '清远市', 'q', 'qingyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441802', '清城区', '', 'qingchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441803', '清新区', '', 'qingxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441821', '佛冈县', '', 'fogangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441823', '阳山县', '', 'yangshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441825', '连山壮族瑶族自治县', '', 'lianshanzhuangzuyaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441826', '连南瑶族自治县', '', 'liannanyaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441881', '英德市', '', 'yingdeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441882', '连州市', '', 'lianzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441900', '东莞市', 'd', 'dongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441901', '东莞市', '', 'dongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441902', '南城区', '', 'nanchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441903', '沙田镇', '', 'shatianzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441904', '长安镇', '', 'changanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441905', '东坑镇', '', 'dongkengzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441906', '樟木头镇', '', 'zhangmutouzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441907', '莞城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441908', '石龙镇', '', 'shilongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441909', '桥头镇', '', 'qiaotouzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441910', '万江区', '', 'wanjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441911', '麻涌镇', '', 'mayongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441912', '虎门镇', '', 'humenzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441913', '谢岗镇', '', 'xiegangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441914', '石碣镇', '', 'shizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441915', '茶山镇', '', 'chashanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441916', '东城区', '', 'dongchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441917', '洪梅镇', '', 'hongmeizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441918', '道滘镇', '', 'dao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441919', '高埗镇', '', 'gaodun', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441920', '企石镇', '', 'qishizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441921', '凤岗镇', '', 'fenggangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441922', '大岭山镇', '', 'dalingshanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441923', '松山湖', '', 'songshanhu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441924', '清溪镇', '', 'qingxizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441925', '望牛墩镇', '', 'wangniudunzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441926', '厚街镇', '', 'houjiezhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441927', '常平镇', '', 'changpingzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441928', '寮步镇', '', 'buzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441929', '石排镇', '', 'shipaizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441930', '横沥镇', '', 'henglizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441931', '塘厦镇', '', 'tangxiazhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441932', '黄江镇', '', 'huangjiangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441933', '大朗镇', '', 'dalangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('441998', '中堂镇', '', 'zhongtangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442000', '中山市', 'z', 'zhongshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442001', '中山市', '', 'zhongshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442002', '神湾镇', '', 'shenwanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442003', '东凤镇', '', 'dongfengzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442004', '五桂山镇', '', 'wuguishanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442005', '黄圃镇', '', 'huangpuzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442006', '小榄镇', '', 'xiaozhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442007', '石岐区街道', '', 'shiqujiedao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442008', '横栏镇', '', 'henglanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442009', '三角镇', '', 'sanjiaozhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442010', '三乡镇', '', 'sanxiangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442011', '港口镇', '', 'gangkouzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442012', '沙溪镇', '', 'shaxizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442013', '板芙镇', '', 'banzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442014', '沙朗镇', '', 'shalangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442015', '东升镇', '', 'dongshengzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442016', '阜沙镇', '', 'fushazhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442017', '民众镇', '', 'minzhongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442018', '东区街道', '', 'dongqujiedao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442019', '火炬开发区', '', 'huojukaifaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442020', '西区街道', '', 'xiqujiedao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442021', '南区街道', '', 'nanqujiedao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442022', '古镇', '', 'guzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442023', '坦洲镇', '', 'tanzhouzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442024', '大涌镇', '', 'dayongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442025', '南朗镇', '', 'nanlangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('442098', '南头镇', '', 'nantouzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445100', '潮州市', 'c', 'chaozhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445102', '湘桥区', '', 'xiangqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445103', '潮安区', '', 'chaoanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445122', '饶平县', '', 'raopingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445185', '枫溪区', '', 'fengxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445200', '揭阳市', 'j', 'jieyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445202', '榕城区', '', 'chengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445203', '揭东区', '', 'jiedongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445222', '揭西县', '', 'jiexixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445224', '惠来县', '', 'huilaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445281', '普宁市', '', 'puningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445284', '东山区', '', 'dongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445300', '云浮市', 'y', 'yunfushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445302', '云城区', '', 'yunchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445321', '新兴县', '', 'xinxingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445322', '郁南县', '', 'yunanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445323', '云安县', '', 'yunanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445381', '罗定市', '', 'luodingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('445399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('449900', '东沙群岛', 'd', 'dongshaqundao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('449901', '东沙群岛', '', 'dongshaqundao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450100', '南宁市', 'n', 'nanningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450102', '兴宁区', '', 'xingningqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450103', '青秀区', '', 'qingxiuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450105', '江南区', '', 'jiangnanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450107', '西乡塘区', '', 'xixiangtangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450108', '良庆区', '', 'liangqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450109', '邕宁区', '', 'ningqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450122', '武鸣县', '', 'wumingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450123', '隆安县', '', 'longanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450124', '马山县', '', 'mashanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450125', '上林县', '', 'shanglinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450126', '宾阳县', '', 'binyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450127', '横县', '', 'hengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450200', '柳州市', 'l', 'liuzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450202', '城中区', '', 'chengzhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450203', '鱼峰区', '', 'yufengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450204', '柳南区', '', 'liunanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450205', '柳北区', '', 'liubeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450221', '柳江县', '', 'liujiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450222', '柳城县', '', 'liuchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450223', '鹿寨县', '', 'luzhaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450224', '融安县', '', 'ronganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450225', '融水苗族自治县', '', 'rongshuimiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450226', '三江侗族自治县', '', 'sanjiangdongzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450300', '桂林市', 'g', 'guilinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450302', '秀峰区', '', 'xiufengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450303', '叠彩区', '', 'diecaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450304', '象山区', '', 'xiangshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450305', '七星区', '', 'qixingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450311', '雁山区', '', 'yanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450312', '临桂区', '', 'linguiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450321', '阳朔县', '', 'yangshuoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450323', '灵川县', '', 'lingchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450324', '全州县', '', 'quanzhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450325', '兴安县', '', 'xinganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450326', '永福县', '', 'yongfuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450327', '灌阳县', '', 'guanyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450328', '龙胜各族自治县', '', 'longshenggezuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450329', '资源县', '', 'ziyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450330', '平乐县', '', 'pinglexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450331', '荔浦县', '', 'lipuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450332', '恭城瑶族自治县', '', 'gongchengyaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450400', '梧州市', 'w', 'wuzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450403', '万秀区', '', 'wanxiuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450404', '蝶山区', '', 'dieshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450405', '长洲区', '', 'changzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450406', '龙圩区', '', 'longqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450421', '苍梧县', '', 'cangwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450422', '藤县', '', 'tengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450423', '蒙山县', '', 'mengshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450481', '岑溪市', '', 'xishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450500', '北海市', 'b', 'beihaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450502', '海城区', '', 'haichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450503', '银海区', '', 'yinhaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450512', '铁山港区', '', 'tieshangangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450521', '合浦县', '', 'hepuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450600', '防城港市', 'f', 'fangchenggangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450602', '港口区', '', 'gangkouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450603', '防城区', '', 'fangchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450621', '上思县', '', 'shangsixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450681', '东兴市', '', 'dongxingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450700', '钦州市', 'q', 'qinzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450702', '钦南区', '', 'qinnanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450703', '钦北区', '', 'qinbeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450721', '灵山县', '', 'lingshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450722', '浦北县', '', 'pubeixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450800', '贵港市', 'g', 'guigangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450802', '港北区', '', 'gangbeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450803', '港南区', '', 'gangnanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450804', '覃塘区', '', 'tangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450821', '平南县', '', 'pingnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450881', '桂平市', '', 'guipingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450900', '玉林市', 'y', 'yulinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450902', '玉州区', '', 'yuzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450903', '福绵区', '', 'fumianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450921', '容县', '', 'rongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450922', '陆川县', '', 'luchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450923', '博白县', '', 'bobaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450924', '兴业县', '', 'xingyexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450981', '北流市', '', 'beiliushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('450999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451000', '百色市', 'b', 'baiseshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451002', '右江区', '', 'youjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451021', '田阳县', '', 'tianyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451022', '田东县', '', 'tiandongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451023', '平果县', '', 'pingguoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451024', '德保县', '', 'debaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451025', '靖西县', '', 'jingxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451026', '那坡县', '', 'napoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451027', '凌云县', '', 'lingyunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451028', '乐业县', '', 'leyexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451029', '田林县', '', 'tianlinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451030', '西林县', '', 'xilinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451031', '隆林各族自治县', '', 'longlingezuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451100', '贺州市', 'h', 'hezhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451102', '八步区', '', 'babuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451119', '平桂管理区', '', 'pingguiguanliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451121', '昭平县', '', 'zhaopingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451122', '钟山县', '', 'zhongshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451123', '富川瑶族自治县', '', 'fuchuanyaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451200', '河池市', 'h', 'hechishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451202', '金城江区', '', 'jinchengjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451221', '南丹县', '', 'nandanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451222', '天峨县', '', 'tianexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451223', '凤山县', '', 'fengshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451224', '东兰县', '', 'donglanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451225', '罗城仫佬族自治县', '', 'luochenglaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451226', '环江毛南族自治县', '', 'huanjiangmaonanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451227', '巴马瑶族自治县', '', 'bamayaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451228', '都安瑶族自治县', '', 'duanyaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451229', '大化瑶族自治县', '', 'dahuayaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451281', '宜州市', '', 'yizhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451300', '来宾市', 'l', 'laibinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451302', '兴宾区', '', 'xingbinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451321', '忻城县', '', 'xinchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451322', '象州县', '', 'xiangzhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451323', '武宣县', '', 'wuxuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451324', '金秀瑶族自治县', '', 'jinxiuyaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451381', '合山市', '', 'heshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451400', '崇左市', 'c', 'chongzuoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451402', '江州区', '', 'jiangzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451421', '扶绥县', '', 'fusuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451422', '宁明县', '', 'ningmingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451423', '龙州县', '', 'longzhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451424', '大新县', '', 'daxinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451425', '天等县', '', 'tiandengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451481', '凭祥市', '', 'pingxiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('451499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460100', '海口市', 'h', 'haikoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460105', '秀英区', '', 'xiuyingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460106', '龙华区', '', 'longhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460107', '琼山区', '', 'qiongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460108', '美兰区', '', 'meilanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460200', '三亚市', 's', 'sanyashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460201', '三亚市', '', 'sanyashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460202', '吉阳镇', '', 'jiyangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460203', '南滨农场', '', 'nanbinnongchang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460204', '南岛农场', '', 'nandaonongchang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460205', '河西区', '', 'hexiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460206', '崖城镇', '', 'yachengzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460207', '育才镇', '', 'yucaizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460208', '海棠湾镇', '', 'haitangwanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460209', '南新农场', '', 'nanxinnongchang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460210', '凤凰镇', '', 'fenghuangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460211', '河东区', '', 'hedongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460212', '南田农场', '', 'nantiannongchang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460213', '立才农场', '', 'licainongchang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460298', '天涯镇', '', 'tianyazhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460300', '三沙市', 's', 'sanshashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460321', '西沙群岛', '', 'xishaqundao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460322', '南沙群岛', '', 'nanshaqundao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('460323', '中沙群岛的岛礁及其海域', '', 'zhongshaqundaodedaojiaojiqihaiyu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469000', '省直辖县级行政区划', 's', 'shengzhixiaxianjixingzhengquhua', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469001', '五指山市', '', 'wuzhishanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469002', '琼海市', '', 'qionghaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469003', '儋州市', '', 'zhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469005', '文昌市', '', 'wenchangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469006', '万宁市', '', 'wanningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469007', '东方市', '', 'dongfangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469021', '定安县', '', 'dinganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469022', '屯昌县', '', 'tunchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469023', '澄迈县', '', 'chengmaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469024', '临高县', '', 'lingaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469025', '白沙黎族自治县', '', 'baishalizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469026', '昌江黎族自治县', '', 'changjianglizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469027', '乐东黎族自治县', '', 'ledonglizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469028', '陵水黎族自治县', '', 'lingshuilizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469029', '保亭黎族苗族自治县', '', 'baotinglizumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('469030', '琼中黎族苗族自治县', '', 'qiongzhonglizumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500100', '重庆市', 'z', 'zhongqingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500101', '万州区', '', 'wanzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500102', '涪陵区', '', 'fulingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500103', '渝中区', '', 'yuzhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500104', '大渡口区', '', 'dadukouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500105', '江北区', '', 'jiangbeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500106', '沙坪坝区', '', 'shapingbaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500107', '九龙坡区', '', 'jiulongpoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500108', '南岸区', '', 'nananqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500109', '北碚区', '', 'beiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500110', '綦江区', '', 'jiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500111', '大足区', '', 'dazuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500112', '渝北区', '', 'yubeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500113', '巴南区', '', 'bananqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500114', '黔江区', '', 'qianjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500115', '长寿区', '', 'changshouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500116', '江津区', '', 'jiangjinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500117', '合川区', '', 'hechuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500118', '永川区', '', 'yongchuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500119', '南川区', '', 'nanchuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('500199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510100', '成都市', 'c', 'chengdushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510104', '锦江区', '', 'jinjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510105', '青羊区', '', 'qingyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510106', '金牛区', '', 'jinniuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510107', '武侯区', '', 'wuhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510108', '成华区', '', 'chenghuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510112', '龙泉驿区', '', 'longquanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510113', '青白江区', '', 'qingbaijiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510114', '新都区', '', 'xinduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510115', '温江区', '', 'wenjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510121', '金堂县', '', 'jintangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510122', '双流县', '', 'shuangliuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510124', '郫县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510129', '大邑县', '', 'dayixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510131', '蒲江县', '', 'pujiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510132', '新津县', '', 'xinjinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510181', '都江堰市', '', 'dujiangyanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510182', '彭州市', '', 'pengzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510183', '邛崃市', '', 'shi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510184', '崇州市', '', 'chongzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510185', '高新西区', '', 'gaoxinxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510186', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510300', '自贡市', 'z', 'zigongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510302', '自流井区', '', 'ziliujingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510303', '贡井区', '', 'gongjingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510304', '大安区', '', 'daanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510311', '沿滩区', '', 'yantanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510321', '荣县', '', 'rongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510322', '富顺县', '', 'fushunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510400', '攀枝花市', 'p', 'panzhihuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510402', '东区', '', 'dongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510403', '西区', '', 'xiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510411', '仁和区', '', 'renhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510421', '米易县', '', 'miyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510422', '盐边县', '', 'yanbianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510500', '泸州市', 'l', 'luzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510502', '江阳区', '', 'jiangyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510503', '纳溪区', '', 'naxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510504', '龙马潭区', '', 'longmatanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510521', '泸县', '', 'luxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510522', '合江县', '', 'hejiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510524', '叙永县', '', 'xuyongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510525', '古蔺县', '', 'guxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510600', '德阳市', 'd', 'deyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510603', '旌阳区', '', 'yangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510623', '中江县', '', 'zhongjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510626', '罗江县', '', 'luojiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510681', '广汉市', '', 'guanghanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510682', '什邡市', '', 'shishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510683', '绵竹市', '', 'mianzhushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510700', '绵阳市', 'm', 'mianyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510703', '涪城区', '', 'fuchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510704', '游仙区', '', 'youxianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510722', '三台县', '', 'santaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510723', '盐亭县', '', 'yantingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510724', '安县', '', 'anxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510725', '梓潼县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510726', '北川羌族自治县', '', 'beichuanqiangzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510727', '平武县', '', 'pingwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510751', '高新区', '', 'gaoxinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510781', '江油市', '', 'jiangyoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510782', '经开区', '', 'jingkaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510800', '广元市', 'g', 'guangyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510802', '利州区', '', 'lizhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510811', '元坝区', '', 'yuanbaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510812', '朝天区', '', 'chaotianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510821', '旺苍县', '', 'wangcangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510822', '青川县', '', 'qingchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510823', '剑阁县', '', 'jiangexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510824', '苍溪县', '', 'cangxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510900', '遂宁市', 's', 'suiningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510903', '船山区', '', 'chuanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510904', '安居区', '', 'anjuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510921', '蓬溪县', '', 'pengxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510922', '射洪县', '', 'shehongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510923', '大英县', '', 'dayingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('510999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511000', '内江市', 'n', 'neijiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511002', '市中区', '', 'shizhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511011', '东兴区', '', 'dongxingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511024', '威远县', '', 'weiyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511025', '资中县', '', 'zizhongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511028', '隆昌县', '', 'longchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511100', '乐山市', 'l', 'leshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511102', '市中区', '', 'shizhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511111', '沙湾区', '', 'shawanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511112', '五通桥区', '', 'wutongqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511113', '金口河区', '', 'jinkouhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511123', '犍为县', '', 'weixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511124', '井研县', '', 'jingyanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511126', '夹江县', '', 'jiajiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511129', '沐川县', '', 'chuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511132', '峨边彝族自治县', '', 'ebianyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511133', '马边彝族自治县', '', 'mabianyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511181', '峨眉山市', '', 'emeishanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511300', '南充市', 'n', 'nanchongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511302', '顺庆区', '', 'shunqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511303', '高坪区', '', 'gaopingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511304', '嘉陵区', '', 'jialingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511321', '南部县', '', 'nanbuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511322', '营山县', '', 'yingshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511323', '蓬安县', '', 'penganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511324', '仪陇县', '', 'yilongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511325', '西充县', '', 'xichongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511381', '阆中市', '', 'zhongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511400', '眉山市', 'm', 'meishanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511402', '东坡区', '', 'dongpoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511421', '仁寿县', '', 'renshouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511422', '彭山县', '', 'pengshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511423', '洪雅县', '', 'hongyaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511424', '丹棱县', '', 'danlengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511425', '青神县', '', 'qingshenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511500', '宜宾市', 'y', 'yibinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511502', '翠屏区', '', 'cuipingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511503', '南溪区', '', 'nanxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511521', '宜宾县', '', 'yibinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511523', '江安县', '', 'jianganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511524', '长宁县', '', 'changningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511525', '高县', '', 'gaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511526', '珙县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511527', '筠连县', '', 'lianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511528', '兴文县', '', 'xingwenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511529', '屏山县', '', 'pingshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511600', '广安市', 'g', 'guanganshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511602', '广安区', '', 'guanganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511603', '前锋区', '', 'qianfengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511621', '岳池县', '', 'yuechixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511622', '武胜县', '', 'wushengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511623', '邻水县', '', 'linshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511681', '华蓥市', '', 'huashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511700', '达州市', 'd', 'dazhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511702', '通川区', '', 'tongchuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511703', '达川区', '', 'dachuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511722', '宣汉县', '', 'xuanhanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511723', '开江县', '', 'kaijiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511724', '大竹县', '', 'dazhuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511725', '渠县', '', 'quxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511781', '万源市', '', 'wanyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511800', '雅安市', 'y', 'yaanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511802', '雨城区', '', 'yuchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511803', '名山区', '', 'mingshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511822', '荥经县', '', 'jingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511823', '汉源县', '', 'hanyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511824', '石棉县', '', 'shimianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511825', '天全县', '', 'tianquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511826', '芦山县', '', 'lushanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511827', '宝兴县', '', 'baoxingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511900', '巴中市', 'b', 'bazhongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511902', '巴州区', '', 'bazhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511903', '恩阳区', '', 'enyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511921', '通江县', '', 'tongjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511922', '南江县', '', 'nanjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511923', '平昌县', '', 'pingchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('511999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('512000', '资阳市', 'z', 'ziyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('512002', '雁江区', '', 'yanjiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('512021', '安岳县', '', 'anyuexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('512022', '乐至县', '', 'lezhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('512081', '简阳市', '', 'jianyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('512099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513200', '阿坝藏族羌族自治州', 'a', 'abacangzuqiangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513221', '汶川县', '', 'chuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513222', '理县', '', 'lixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513223', '茂县', '', 'maoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513224', '松潘县', '', 'songpanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513225', '九寨沟县', '', 'jiuzhaigouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513226', '金川县', '', 'jinchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513227', '小金县', '', 'xiaojinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513228', '黑水县', '', 'heishuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513229', '马尔康县', '', 'maerkangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513230', '壤塘县', '', 'rangtangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513231', '阿坝县', '', 'abaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513232', '若尔盖县', '', 'ruoergaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513233', '红原县', '', 'hongyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513300', '甘孜藏族自治州', 'g', 'ganzicangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513321', '康定县', '', 'kangdingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513322', '泸定县', '', 'ludingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513323', '丹巴县', '', 'danbaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513324', '九龙县', '', 'jiulongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513325', '雅江县', '', 'yajiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513326', '道孚县', '', 'daoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513327', '炉霍县', '', 'luhuoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513328', '甘孜县', '', 'ganzixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513329', '新龙县', '', 'xinlongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513330', '德格县', '', 'degexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513331', '白玉县', '', 'baiyuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513332', '石渠县', '', 'shiquxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513333', '色达县', '', 'sedaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513334', '理塘县', '', 'litangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513335', '巴塘县', '', 'batangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513336', '乡城县', '', 'xiangchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513337', '稻城县', '', 'daochengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513338', '得荣县', '', 'derongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513400', '凉山彝族自治州', 'l', 'liangshanyizuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513401', '西昌市', '', 'xichangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513422', '木里藏族自治县', '', 'mulicangzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513423', '盐源县', '', 'yanyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513424', '德昌县', '', 'dechangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513425', '会理县', '', 'huilixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513426', '会东县', '', 'huidongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513427', '宁南县', '', 'ningnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513428', '普格县', '', 'pugexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513429', '布拖县', '', 'butuoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513430', '金阳县', '', 'jinyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513431', '昭觉县', '', 'zhaojuexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513432', '喜德县', '', 'xidexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513433', '冕宁县', '', 'mianningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513434', '越西县', '', 'yuexixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513435', '甘洛县', '', 'ganluoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513436', '美姑县', '', 'meiguxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513437', '雷波县', '', 'leiboxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('513499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520100', '贵阳市', 'g', 'guiyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520102', '南明区', '', 'nanmingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520103', '云岩区', '', 'yunyanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520111', '花溪区', '', 'huaxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520112', '乌当区', '', 'wudangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520113', '白云区', '', 'baiyunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520114', '小河区', '', 'xiaohequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520115', '观山湖区', '', 'guanshanhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520121', '开阳县', '', 'kaiyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520122', '息烽县', '', 'xifengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520123', '修文县', '', 'xiuwenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520181', '清镇市', '', 'qingzhenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520200', '六盘水市', 'l', 'liupanshuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520201', '钟山区', '', 'zhongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520203', '六枝特区', '', 'liuzhitequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520221', '水城县', '', 'shuichengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520222', '盘县', '', 'panxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520300', '遵义市', 'z', 'zunyishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520302', '红花岗区', '', 'honghuagangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520303', '汇川区', '', 'huichuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520321', '遵义县', '', 'zunyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520322', '桐梓县', '', 'tongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520323', '绥阳县', '', 'suiyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520324', '正安县', '', 'zhenganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520325', '道真仡佬族苗族自治县', '', 'daozhenlaozumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520326', '务川仡佬族苗族自治县', '', 'wuchuanlaozumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520327', '凤冈县', '', 'fenggangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520328', '湄潭县', '', 'tanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520329', '余庆县', '', 'yuqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520330', '习水县', '', 'xishuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520381', '赤水市', '', 'chishuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520382', '仁怀市', '', 'renhuaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520400', '安顺市', 'a', 'anshunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520402', '西秀区', '', 'xixiuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520421', '平坝县', '', 'pingbaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520422', '普定县', '', 'pudingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520423', '镇宁布依族苗族自治县', '', 'zhenningbuyizumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520424', '关岭布依族苗族自治县', '', 'guanlingbuyizumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520425', '紫云苗族布依族自治县', '', 'ziyunmiaozubuyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520500', '毕节市', 'b', 'bijieshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520502', '七星关区', '', 'qixingguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520521', '大方县', '', 'dafangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520522', '黔西县', '', 'qianxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520523', '金沙县', '', 'jinshaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520524', '织金县', '', 'zhijinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520525', '纳雍县', '', 'nayongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520526', '威宁彝族回族苗族自治县', '', 'weiningyizuhuizumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520527', '赫章县', '', 'hezhangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520600', '铜仁市', 't', 'tongrenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520602', '碧江区', '', 'bijiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520603', '万山区', '', 'wanshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520621', '江口县', '', 'jiangkouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520622', '玉屏侗族自治县', '', 'yupingdongzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520623', '石阡县', '', 'shixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520624', '思南县', '', 'sinanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520625', '印江土家族苗族自治县', '', 'yinjiangtujiazumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520626', '德江县', '', 'dejiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520627', '沿河土家族自治县', '', 'yanhetujiazuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520628', '松桃苗族自治县', '', 'songtaomiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('520699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522300', '黔西南布依族苗族自治州', 'q', 'qianxinanbuyizumiaozuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522301', '兴义市', '', 'xingyishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522322', '兴仁县', '', 'xingrenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522323', '普安县', '', 'puanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522324', '晴隆县', '', 'qinglongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522325', '贞丰县', '', 'zhenfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522326', '望谟县', '', 'wangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522327', '册亨县', '', 'cehengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522328', '安龙县', '', 'anlongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522600', '黔东南苗族侗族自治州', 'q', 'qiandongnanmiaozudongzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522601', '凯里市', '', 'kailishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522622', '黄平县', '', 'huangpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522623', '施秉县', '', 'shibingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522624', '三穗县', '', 'sansuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522625', '镇远县', '', 'zhenyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522626', '岑巩县', '', 'gongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522627', '天柱县', '', 'tianzhuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522628', '锦屏县', '', 'jinpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522629', '剑河县', '', 'jianhexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522630', '台江县', '', 'taijiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522631', '黎平县', '', 'lipingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522632', '榕江县', '', 'jiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522633', '从江县', '', 'congjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522634', '雷山县', '', 'leishanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522635', '麻江县', '', 'majiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522636', '丹寨县', '', 'danzhaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522700', '黔南布依族苗族自治州', 'q', 'qiannanbuyizumiaozuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522701', '都匀市', '', 'duyunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522702', '福泉市', '', 'fuquanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522722', '荔波县', '', 'liboxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522723', '贵定县', '', 'guidingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522725', '瓮安县', '', 'wenganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522726', '独山县', '', 'dushanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522727', '平塘县', '', 'pingtangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522728', '罗甸县', '', 'luodianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522729', '长顺县', '', 'changshunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522730', '龙里县', '', 'longlixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522731', '惠水县', '', 'huishuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522732', '三都水族自治县', '', 'sandushuizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('522799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530100', '昆明市', 'k', 'kunmingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530102', '五华区', '', 'wuhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530103', '盘龙区', '', 'panlongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530111', '官渡区', '', 'guanduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530112', '西山区', '', 'xishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530113', '东川区', '', 'dongchuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530114', '呈贡区', '', 'chenggongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530122', '晋宁县', '', 'jinningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530124', '富民县', '', 'fuminxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530125', '宜良县', '', 'yiliangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530126', '石林彝族自治县', '', 'shilinyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530127', '嵩明县', '', 'mingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530128', '禄劝彝族苗族自治县', '', 'luquanyizumiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530129', '寻甸回族彝族自治县', '', 'xundianhuizuyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530181', '安宁市', '', 'anningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530300', '曲靖市', 'q', 'qujingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530302', '麒麟区', '', 'qu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530321', '马龙县', '', 'malongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530322', '陆良县', '', 'luliangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530323', '师宗县', '', 'shizongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530324', '罗平县', '', 'luopingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530325', '富源县', '', 'fuyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530326', '会泽县', '', 'huizexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530328', '沾益县', '', 'zhanyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530381', '宣威市', '', 'xuanweishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530400', '玉溪市', 'y', 'yuxishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530402', '红塔区', '', 'hongtaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530421', '江川县', '', 'jiangchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530422', '澄江县', '', 'chengjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530423', '通海县', '', 'tonghaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530424', '华宁县', '', 'huaningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530425', '易门县', '', 'yimenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530426', '峨山彝族自治县', '', 'eshanyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530427', '新平彝族傣族自治县', '', 'xinpingyizudaizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530428', '元江哈尼族彝族傣族自治县', '', 'yuanjianghanizuyizudaizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530500', '保山市', 'b', 'baoshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530502', '隆阳区', '', 'longyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530521', '施甸县', '', 'shidianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530522', '腾冲县', '', 'tengchongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530523', '龙陵县', '', 'longlingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530524', '昌宁县', '', 'changningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530600', '昭通市', 'z', 'zhaotongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530602', '昭阳区', '', 'zhaoyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530621', '鲁甸县', '', 'ludianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530622', '巧家县', '', 'qiaojiaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530623', '盐津县', '', 'yanjinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530624', '大关县', '', 'daguanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530625', '永善县', '', 'yongshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530626', '绥江县', '', 'suijiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530627', '镇雄县', '', 'zhenxiongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530628', '彝良县', '', 'yiliangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530629', '威信县', '', 'weixinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530630', '水富县', '', 'shuifuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530700', '丽江市', 'l', 'lijiangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530702', '古城区', '', 'guchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530721', '玉龙纳西族自治县', '', 'yulongnaxizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530722', '永胜县', '', 'yongshengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530723', '华坪县', '', 'huapingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530724', '宁蒗彝族自治县', '', 'ningyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530800', '普洱市', 'p', 'puershi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530802', '思茅区', '', 'simaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530821', '宁洱哈尼族彝族自治县', '', 'ningerhanizuyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530822', '墨江哈尼族自治县', '', 'mojianghanizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530823', '景东彝族自治县', '', 'jingdongyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530824', '景谷傣族彝族自治县', '', 'jinggudaizuyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530825', '镇沅彝族哈尼族拉祜族自治县', '', 'zhenyizuhanizulazuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530826', '江城哈尼族彝族自治县', '', 'jiangchenghanizuyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530827', '孟连傣族拉祜族佤族自治县', '', 'mengliandaizulazuzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530828', '澜沧拉祜族自治县', '', 'lancanglazuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530829', '西盟佤族自治县', '', 'ximengzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530900', '临沧市', 'l', 'lincangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530902', '临翔区', '', 'linxiangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530921', '凤庆县', '', 'fengqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530922', '云县', '', 'yunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530923', '永德县', '', 'yongdexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530924', '镇康县', '', 'zhenkangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530925', '双江拉祜族佤族布朗族傣族自治县', '', 'shuangjianglazuzubulangzudaizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530926', '耿马傣族佤族自治县', '', 'gengmadaizuzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530927', '沧源佤族自治县', '', 'cangyuanzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('530999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532300', '楚雄彝族自治州', 'c', 'chuxiongyizuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532301', '楚雄市', '', 'chuxiongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532322', '双柏县', '', 'shuangbaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532323', '牟定县', '', 'moudingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532324', '南华县', '', 'nanhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532325', '姚安县', '', 'yaoanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532326', '大姚县', '', 'dayaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532327', '永仁县', '', 'yongrenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532328', '元谋县', '', 'yuanmouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532329', '武定县', '', 'wudingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532331', '禄丰县', '', 'lufengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532500', '红河哈尼族彝族自治州', 'h', 'honghehanizuyizuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532501', '个旧市', '', 'gejiushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532502', '开远市', '', 'kaiyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532503', '蒙自市', '', 'mengzishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532504', '弥勒市', '', 'mileshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532523', '屏边苗族自治县', '', 'pingbianmiaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532524', '建水县', '', 'jianshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532525', '石屏县', '', 'shipingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532527', '泸西县', '', 'luxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532528', '元阳县', '', 'yuanyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532529', '红河县', '', 'honghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532530', '金平苗族瑶族傣族自治县', '', 'jinpingmiaozuyaozudaizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532531', '绿春县', '', 'lvchunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532532', '河口瑶族自治县', '', 'hekouyaozuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532600', '文山壮族苗族自治州', 'w', 'wenshanzhuangzumiaozuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532601', '文山市', '', 'wenshanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532622', '砚山县', '', 'yanshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532623', '西畴县', '', 'xichouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532624', '麻栗坡县', '', 'malipoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532625', '马关县', '', 'maguanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532626', '丘北县', '', 'qiubeixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532627', '广南县', '', 'guangnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532628', '富宁县', '', 'funingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532800', '西双版纳傣族自治州', 'x', 'xishuangbannadaizuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532801', '景洪市', '', 'jinghongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532822', '勐海县', '', 'haixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532823', '勐腊县', '', 'laxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532900', '大理白族自治州', 'd', 'dalibaizuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532901', '大理市', '', 'dalishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532922', '漾濞彝族自治县', '', 'yangyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532923', '祥云县', '', 'xiangyunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532924', '宾川县', '', 'binchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532925', '弥渡县', '', 'miduxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532926', '南涧彝族自治县', '', 'nanjianyizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532927', '巍山彝族回族自治县', '', 'weishanyizuhuizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532928', '永平县', '', 'yongpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532929', '云龙县', '', 'yunlongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532930', '洱源县', '', 'eryuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532931', '剑川县', '', 'jianchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532932', '鹤庆县', '', 'heqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('532999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533100', '德宏傣族景颇族自治州', 'd', 'dehongdaizujingpozuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533102', '瑞丽市', '', 'ruilishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533103', '芒市', '', 'mangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533122', '梁河县', '', 'lianghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533123', '盈江县', '', 'yingjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533124', '陇川县', '', 'longchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533300', '怒江傈僳族自治州', 'n', 'nujianglisuzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533321', '泸水县', '', 'lushuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533323', '福贡县', '', 'fugongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533324', '贡山独龙族怒族自治县', '', 'gongshandulongzunuzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533325', '兰坪白族普米族自治县', '', 'lanpingbaizupumizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533400', '迪庆藏族自治州', 'd', 'diqingcangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533421', '香格里拉县', '', 'xianggelilaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533422', '德钦县', '', 'deqinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533423', '维西傈僳族自治县', '', 'weixilisuzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('533499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540100', '拉萨市', 'l', 'lasashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540102', '城关区', '', 'chengguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540121', '林周县', '', 'linzhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540122', '当雄县', '', 'dangxiongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540123', '尼木县', '', 'nimuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540124', '曲水县', '', 'qushuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540125', '堆龙德庆县', '', 'duilongdeqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540126', '达孜县', '', 'dazixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540127', '墨竹工卡县', '', 'mozhugongkaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('540199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542100', '昌都地区', 'c', 'changdudiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542121', '昌都县', '', 'changduxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542122', '江达县', '', 'jiangdaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542123', '贡觉县', '', 'gongjuexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542124', '类乌齐县', '', 'leiwuqixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542125', '丁青县', '', 'dingqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542126', '察雅县', '', 'chayaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542127', '八宿县', '', 'basuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542128', '左贡县', '', 'zuogongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542129', '芒康县', '', 'mangkangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542132', '洛隆县', '', 'luolongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542133', '边坝县', '', 'bianbaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542200', '山南地区', 's', 'shannandiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542221', '乃东县', '', 'naidongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542222', '扎囊县', '', 'zhanangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542223', '贡嘎县', '', 'gonggaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542224', '桑日县', '', 'sangrixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542225', '琼结县', '', 'qiongjiexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542226', '曲松县', '', 'qusongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542227', '措美县', '', 'cuomeixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542228', '洛扎县', '', 'luozhaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542229', '加查县', '', 'jiachaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542231', '隆子县', '', 'longzixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542232', '错那县', '', 'cuonaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542233', '浪卡子县', '', 'langkazixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542300', '日喀则地区', 'r', 'rikazediqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542301', '日喀则市', '', 'rikazeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542322', '南木林县', '', 'nanmulinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542323', '江孜县', '', 'jiangzixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542324', '定日县', '', 'dingrixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542325', '萨迦县', '', 'saxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542326', '拉孜县', '', 'lazixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542327', '昂仁县', '', 'angrenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542328', '谢通门县', '', 'xietongmenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542329', '白朗县', '', 'bailangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542330', '仁布县', '', 'renbuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542331', '康马县', '', 'kangmaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542332', '定结县', '', 'dingjiexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542333', '仲巴县', '', 'zhongbaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542334', '亚东县', '', 'yadongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542335', '吉隆县', '', 'jilongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542336', '聂拉木县', '', 'nielamuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542337', '萨嘎县', '', 'sagaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542338', '岗巴县', '', 'gangbaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542400', '那曲地区', 'n', 'naqudiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542421', '那曲县', '', 'naquxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542422', '嘉黎县', '', 'jialixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542423', '比如县', '', 'biruxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542424', '聂荣县', '', 'nierongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542425', '安多县', '', 'anduoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542426', '申扎县', '', 'shenzhaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542427', '索县', '', 'suoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542428', '班戈县', '', 'bangexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542429', '巴青县', '', 'baqingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542430', '尼玛县', '', 'nimaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542431', '双湖县', '', 'shuanghuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542500', '阿里地区', 'a', 'alidiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542521', '普兰县', '', 'pulanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542522', '札达县', '', 'zhadaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542523', '噶尔县', '', 'gaerxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542524', '日土县', '', 'rituxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542525', '革吉县', '', 'gejixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542526', '改则县', '', 'gaizexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542527', '措勤县', '', 'cuoqinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542600', '林芝地区', 'l', 'linzhidiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542621', '林芝县', '', 'linzhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542622', '工布江达县', '', 'gongbujiangdaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542623', '米林县', '', 'milinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542624', '墨脱县', '', 'motuoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542625', '波密县', '', 'bomixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542626', '察隅县', '', 'chayuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542627', '朗县', '', 'langxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('542699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610100', '西安市', 'x', 'xianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610102', '新城区', '', 'xinchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610103', '碑林区', '', 'beilinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610104', '莲湖区', '', 'lianhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610111', '灞桥区', '', 'qiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610112', '未央区', '', 'weiyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610113', '雁塔区', '', 'yantaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610114', '阎良区', '', 'yanliangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610115', '临潼区', '', 'linqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610116', '长安区', '', 'changanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610122', '蓝田县', '', 'lantianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610124', '周至县', '', 'zhouzhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610125', '户县', '', 'huxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610126', '高陵县', '', 'gaolingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610127', '杨凌农业示范区', '', 'yanglingnongyeshifanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610200', '铜川市', 't', 'tongchuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610202', '王益区', '', 'wangyiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610203', '印台区', '', 'yintaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610204', '耀州区', '', 'yaozhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610222', '宜君县', '', 'yijunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610300', '宝鸡市', 'b', 'baojishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610302', '渭滨区', '', 'weibinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610303', '金台区', '', 'jintaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610304', '陈仓区', '', 'chencangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610322', '凤翔县', '', 'fengxiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610323', '岐山县', '', 'shanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610324', '扶风县', '', 'fufengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610326', '眉县', '', 'meixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610327', '陇县', '', 'longxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610328', '千阳县', '', 'qianyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610329', '麟游县', '', 'youxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610330', '凤县', '', 'fengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610331', '太白县', '', 'taibaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610400', '咸阳市', 'x', 'xianyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610402', '秦都区', '', 'qinduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610403', '杨陵区', '', 'yanglingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610404', '渭城区', '', 'weichengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610422', '三原县', '', 'sanyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610423', '泾阳县', '', 'yangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610424', '乾县', '', 'qianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610425', '礼泉县', '', 'liquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610426', '永寿县', '', 'yongshouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610427', '彬县', '', 'binxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610428', '长武县', '', 'changwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610429', '旬邑县', '', 'xunyixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610430', '淳化县', '', 'chunhuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610431', '武功县', '', 'wugongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610481', '兴平市', '', 'xingpingshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610500', '渭南市', 'w', 'weinanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610502', '临渭区', '', 'linweiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610521', '华县', '', 'huaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610522', '潼关县', '', 'guanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610523', '大荔县', '', 'dalixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610524', '合阳县', '', 'heyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610525', '澄城县', '', 'chengchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610526', '蒲城县', '', 'puchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610527', '白水县', '', 'baishuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610528', '富平县', '', 'fupingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610581', '韩城市', '', 'hanchengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610582', '华阴市', '', 'huayinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610600', '延安市', 'y', 'yananshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610602', '宝塔区', '', 'baotaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610621', '延长县', '', 'yanchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610622', '延川县', '', 'yanchuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610623', '子长县', '', 'zichangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610624', '安塞县', '', 'ansaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610625', '志丹县', '', 'zhidanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610626', '吴起县', '', 'wuqixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610627', '甘泉县', '', 'ganquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610628', '富县', '', 'fuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610629', '洛川县', '', 'luochuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610630', '宜川县', '', 'yichuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610631', '黄龙县', '', 'huanglongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610632', '黄陵县', '', 'huanglingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610700', '汉中市', 'h', 'hanzhongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610702', '汉台区', '', 'hantaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610721', '南郑县', '', 'nanzhengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610722', '城固县', '', 'chengguxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610723', '洋县', '', 'yangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610724', '西乡县', '', 'xixiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610725', '勉县', '', 'mianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610726', '宁强县', '', 'ningqiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610727', '略阳县', '', 'lueyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610728', '镇巴县', '', 'zhenbaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610729', '留坝县', '', 'liubaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610730', '佛坪县', '', 'fopingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610800', '榆林市', 'y', 'yulinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610802', '榆阳区', '', 'yuyangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610821', '神木县', '', 'shenmuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610822', '府谷县', '', 'fuguxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610823', '横山县', '', 'hengshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610824', '靖边县', '', 'jingbianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610825', '定边县', '', 'dingbianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610826', '绥德县', '', 'suidexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610827', '米脂县', '', 'mizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610828', '佳县', '', 'jiaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610829', '吴堡县', '', 'wubaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610830', '清涧县', '', 'qingjianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610831', '子洲县', '', 'zizhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610900', '安康市', 'a', 'ankangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610902', '汉滨区', '', 'hanbinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610921', '汉阴县', '', 'hanyinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610922', '石泉县', '', 'shiquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610923', '宁陕县', '', 'ningshanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610924', '紫阳县', '', 'ziyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610925', '岚皋县', '', 'gaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610926', '平利县', '', 'pinglixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610927', '镇坪县', '', 'zhenpingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610928', '旬阳县', '', 'xunyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610929', '白河县', '', 'baihexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('610999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611000', '商洛市', 's', 'shangluoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611002', '商州区', '', 'shangzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611021', '洛南县', '', 'luonanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611022', '丹凤县', '', 'danfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611023', '商南县', '', 'shangnanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611024', '山阳县', '', 'shanyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611025', '镇安县', '', 'zhenanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611026', '柞水县', '', 'zuoshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('611099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620100', '兰州市', 'l', 'lanzhoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620102', '城关区', '', 'chengguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620103', '七里河区', '', 'qilihequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620104', '西固区', '', 'xiguqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620105', '安宁区', '', 'anningqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620111', '红古区', '', 'hongguqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620121', '永登县', '', 'yongdengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620122', '皋兰县', '', 'gaolanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620123', '榆中县', '', 'yuzhongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620200', '嘉峪关市', 'j', 'jiayuguanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620201', '嘉峪关市', '', 'jiayuguanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620202', '长城区', '', 'changchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620203', '镜铁区', '', 'jingtiequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620298', '雄关区', '', 'xiongguanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620300', '金昌市', 'j', 'jinchangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620302', '金川区', '', 'jinchuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620321', '永昌县', '', 'yongchangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620400', '白银市', 'b', 'baiyinshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620402', '白银区', '', 'baiyinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620403', '平川区', '', 'pingchuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620421', '靖远县', '', 'jingyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620422', '会宁县', '', 'huiningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620423', '景泰县', '', 'jingtaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620500', '天水市', 't', 'tianshuishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620502', '秦州区', '', 'qinzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620503', '麦积区', '', 'maijiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620521', '清水县', '', 'qingshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620522', '秦安县', '', 'qinanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620523', '甘谷县', '', 'ganguxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620524', '武山县', '', 'wushanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620525', '张家川回族自治县', '', 'zhangjiachuanhuizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620600', '武威市', 'w', 'wuweishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620602', '凉州区', '', 'liangzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620621', '民勤县', '', 'minqinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620622', '古浪县', '', 'gulangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620623', '天祝藏族自治县', '', 'tianzhucangzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620700', '张掖市', 'z', 'zhangyeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620702', '甘州区', '', 'ganzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620721', '肃南裕固族自治县', '', 'sunanyuguzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620722', '民乐县', '', 'minlexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620723', '临泽县', '', 'linzexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620724', '高台县', '', 'gaotaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620725', '山丹县', '', 'shandanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620800', '平凉市', 'p', 'pingliangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620802', '崆峒区', '', 'qu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620821', '泾川县', '', 'chuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620822', '灵台县', '', 'lingtaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620823', '崇信县', '', 'chongxinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620824', '华亭县', '', 'huatingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620825', '庄浪县', '', 'zhuanglangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620826', '静宁县', '', 'jingningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620827', '镇原县', '', 'zhenyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620900', '酒泉市', 'j', 'jiuquanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620902', '肃州区', '', 'suzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620921', '金塔县', '', 'jintaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620922', '瓜州县', '', 'guazhouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620923', '肃北蒙古族自治县', '', 'subeimengguzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620924', '阿克塞哈萨克族自治县', '', 'akesaihasakezuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620981', '玉门市', '', 'yumenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620982', '敦煌市', '', 'dunhuangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('620999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621000', '庆阳市', 'q', 'qingyangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621002', '西峰区', '', 'xifengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621021', '庆城县', '', 'qingchengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621022', '环县', '', 'huanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621023', '华池县', '', 'huachixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621024', '合水县', '', 'heshuixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621025', '正宁县', '', 'zhengningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621026', '宁县', '', 'ningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621027', '镇原县', '', 'zhenyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621100', '定西市', 'd', 'dingxishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621102', '安定区', '', 'andingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621121', '通渭县', '', 'tongweixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621122', '陇西县', '', 'longxixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621123', '渭源县', '', 'weiyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621124', '临洮县', '', 'linxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621125', '漳县', '', 'zhangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621126', '岷县', '', 'xian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621200', '陇南市', 'l', 'longnanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621202', '武都区', '', 'wuduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621221', '成县', '', 'chengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621222', '文县', '', 'wenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621223', '宕昌县', '', 'changxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621224', '康县', '', 'kangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621225', '西和县', '', 'xihexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621226', '礼县', '', 'lixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621227', '徽县', '', 'huixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621228', '两当县', '', 'liangdangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('621299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622900', '临夏回族自治州', 'l', 'linxiahuizuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622901', '临夏市', '', 'linxiashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622921', '临夏县', '', 'linxiaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622922', '康乐县', '', 'kanglexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622923', '永靖县', '', 'yongjingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622924', '广河县', '', 'guanghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622925', '和政县', '', 'hezhengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622926', '东乡族自治县', '', 'dongxiangzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622927', '积石山保安族东乡族撒拉族自治县', '', 'jishishanbaoanzudongxiangzusalazuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('622999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623000', '甘南藏族自治州', 'g', 'gannancangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623001', '合作市', '', 'hezuoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623021', '临潭县', '', 'lintanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623022', '卓尼县', '', 'zhuonixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623023', '舟曲县', '', 'zhouquxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623024', '迭部县', '', 'diebuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623025', '玛曲县', '', 'maquxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623026', '碌曲县', '', 'luquxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623027', '夏河县', '', 'xiahexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('623099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630100', '西宁市', 'x', 'xiningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630102', '城东区', '', 'chengdongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630103', '城中区', '', 'chengzhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630104', '城西区', '', 'chengxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630105', '城北区', '', 'chengbeiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630121', '大通回族土族自治县', '', 'datonghuizutuzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630122', '湟中县', '', 'zhongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630123', '湟源县', '', 'yuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630200', '海东市', 'h', 'haidongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630202', '乐都区', '', 'leduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630221', '平安县', '', 'pinganxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630222', '民和回族土族自治县', '', 'minhehuizutuzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630223', '互助土族自治县', '', 'huzhutuzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630224', '化隆回族自治县', '', 'hualonghuizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630225', '循化撒拉族自治县', '', 'xunhuasalazuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('630299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632200', '海北藏族自治州', 'h', 'haibeicangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632221', '门源回族自治县', '', 'menyuanhuizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632222', '祁连县', '', 'qilianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632223', '海晏县', '', 'haixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632224', '刚察县', '', 'gangchaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632300', '黄南藏族自治州', 'h', 'huangnancangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632321', '同仁县', '', 'tongrenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632322', '尖扎县', '', 'jianzhaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632323', '泽库县', '', 'zekuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632324', '河南蒙古族自治县', '', 'henanmengguzuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632500', '海南藏族自治州', 'h', 'hainancangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632521', '共和县', '', 'gonghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632522', '同德县', '', 'tongdexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632523', '贵德县', '', 'guidexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632524', '兴海县', '', 'xinghaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632525', '贵南县', '', 'guinanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632600', '果洛藏族自治州', 'g', 'guoluocangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632621', '玛沁县', '', 'maqinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632622', '班玛县', '', 'banmaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632623', '甘德县', '', 'gandexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632624', '达日县', '', 'darixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632625', '久治县', '', 'jiuzhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632626', '玛多县', '', 'maduoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632699', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632700', '玉树藏族自治州', 'y', 'yushucangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632701', '玉树市', '', 'yushushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632722', '杂多县', '', 'zaduoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632723', '称多县', '', 'chengduoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632724', '治多县', '', 'zhiduoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632725', '囊谦县', '', 'nangqianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632726', '曲麻莱县', '', 'qumalaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632800', '海西蒙古族藏族自治州', 'h', 'haiximengguzucangzuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632801', '格尔木市', '', 'geermushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632802', '德令哈市', '', 'delinghashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632821', '乌兰县', '', 'wulanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632822', '都兰县', '', 'dulanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632823', '天峻县', '', 'tianjunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('632899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640100', '银川市', 'y', 'yinchuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640104', '兴庆区', '', 'xingqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640105', '西夏区', '', 'xixiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640106', '金凤区', '', 'jinfengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640121', '永宁县', '', 'yongningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640122', '贺兰县', '', 'helanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640181', '灵武市', '', 'lingwushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640200', '石嘴山市', 's', 'shizuishanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640202', '大武口区', '', 'dawukouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640205', '惠农区', '', 'huinongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640221', '平罗县', '', 'pingluoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640300', '吴忠市', 'w', 'wuzhongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640302', '利通区', '', 'litongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640303', '红寺堡区', '', 'hongsibaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640323', '盐池县', '', 'yanchixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640324', '同心县', '', 'tongxinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640381', '青铜峡市', '', 'qingtongxiashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640400', '固原市', 'g', 'guyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640402', '原州区', '', 'yuanzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640422', '西吉县', '', 'xijixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640423', '隆德县', '', 'longdexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640424', '泾源县', '', 'yuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640425', '彭阳县', '', 'pengyangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640500', '中卫市', 'z', 'zhongweishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640502', '沙坡头区', '', 'shapotouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640521', '中宁县', '', 'zhongningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640522', '海原县', '', 'haiyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('640599', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650100', '乌鲁木齐市', 'w', 'wulumuqishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650102', '天山区', '', 'tianshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650103', '沙依巴克区', '', 'shayibakequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650104', '新市区', '', 'xinshiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650105', '水磨沟区', '', 'shuimogouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650106', '头屯河区', '', 'toutunhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650107', '达坂城区', '', 'dachengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650108', '东山区', '', 'dongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650109', '米东区', '', 'midongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650121', '乌鲁木齐县', '', 'wulumuqixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650200', '克拉玛依市', 'k', 'kelamayishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650202', '独山子区', '', 'dushanziqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650203', '克拉玛依区', '', 'kelamayiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650204', '白碱滩区', '', 'baijiantanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650205', '乌尔禾区', '', 'wuerhequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('650299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652100', '吐鲁番地区', 't', 'tulufandiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652101', '吐鲁番市', '', 'tulufanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652122', '鄯善县', '', 'shanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652123', '托克逊县', '', 'tuokexunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652200', '哈密地区', 'h', 'hamidiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652201', '哈密市', '', 'hamishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652222', '巴里坤哈萨克自治县', '', 'balikunhasakezizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652223', '伊吾县', '', 'yiwuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652300', '昌吉回族自治州', 'c', 'changjihuizuzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652301', '昌吉市', '', 'changjishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652302', '阜康市', '', 'fukangshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652323', '呼图壁县', '', 'hutubixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652324', '玛纳斯县', '', 'manasixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652325', '奇台县', '', 'qitaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652327', '吉木萨尔县', '', 'jimusaerxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652328', '木垒哈萨克自治县', '', 'muleihasakezizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652700', '博尔塔拉蒙古自治州', 'b', 'boertalamengguzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652701', '博乐市', '', 'boleshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652702', '阿拉山口市', '', 'alashankoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652722', '精河县', '', 'jinghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652723', '温泉县', '', 'wenquanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652800', '巴音郭楞蒙古自治州', 'b', 'bayinguolengmengguzizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652801', '库尔勒市', '', 'kuerleshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652822', '轮台县', '', 'luntaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652823', '尉犁县', '', 'weilixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652824', '若羌县', '', 'ruoqiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652825', '且末县', '', 'qiemoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652826', '焉耆回族自治县', '', 'yanhuizuzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652827', '和静县', '', 'hejingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652828', '和硕县', '', 'heshuoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652829', '博湖县', '', 'bohuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652900', '阿克苏地区', 'a', 'akesudiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652901', '阿克苏市', '', 'akesushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652922', '温宿县', '', 'wensuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652923', '库车县', '', 'kuchexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652924', '沙雅县', '', 'shayaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652925', '新和县', '', 'xinhexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652926', '拜城县', '', 'baichengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652927', '乌什县', '', 'wushixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652928', '阿瓦提县', '', 'awatixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652929', '柯坪县', '', 'kepingxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652930', '阿拉尔市', '', 'alaershi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('652999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653000', '克孜勒苏柯尔克孜自治州', 'k', 'kezilesukeerkezizizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653001', '阿图什市', '', 'atushishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653022', '阿克陶县', '', 'aketaoxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653023', '阿合奇县', '', 'aheqixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653024', '乌恰县', '', 'wuqiaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653100', '喀什地区', 'k', 'kashidiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653101', '喀什市', '', 'kashishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653121', '疏附县', '', 'shufuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653122', '疏勒县', '', 'shulexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653123', '英吉沙县', '', 'yingjishaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653124', '泽普县', '', 'zepuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653125', '莎车县', '', 'shachexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653126', '叶城县', '', 'yechengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653127', '麦盖提县', '', 'maigaitixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653128', '岳普湖县', '', 'yuepuhuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653129', '伽师县', '', 'shixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653130', '巴楚县', '', 'bachuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653131', '塔什库尔干塔吉克自治县', '', 'tashikuergantajikezizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653200', '和田地区', 'h', 'hetiandiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653201', '和田市', '', 'hetianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653221', '和田县', '', 'hetianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653222', '墨玉县', '', 'moyuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653223', '皮山县', '', 'pishanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653224', '洛浦县', '', 'luopuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653225', '策勒县', '', 'celexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653226', '于田县', '', 'yutianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653227', '民丰县', '', 'minfengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('653299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654000', '伊犁哈萨克自治州', 'y', 'yilihasakezizhizhou', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654002', '伊宁市', '', 'yiningshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654003', '奎屯市', '', 'kuitunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654021', '伊宁县', '', 'yiningxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654022', '察布查尔锡伯自治县', '', 'chabuchaerxibozizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654023', '霍城县', '', 'huochengxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654024', '巩留县', '', 'gongliuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654025', '新源县', '', 'xinyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654026', '昭苏县', '', 'zhaosuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654027', '特克斯县', '', 'tekesixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654028', '尼勒克县', '', 'nilekexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654099', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654200', '塔城地区', 't', 'tachengdiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654201', '塔城市', '', 'tachengshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654202', '乌苏市', '', 'wusushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654221', '额敏县', '', 'eminxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654223', '沙湾县', '', 'shawanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654224', '托里县', '', 'tuolixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654225', '裕民县', '', 'yuminxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654226', '和布克赛尔蒙古自治县', '', 'hebukesaiermengguzizhixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654300', '阿勒泰地区', 'a', 'aletaidiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654301', '阿勒泰市', '', 'aletaishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654321', '布尔津县', '', 'buerjinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654322', '富蕴县', '', 'fuyunxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654323', '福海县', '', 'fuhaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654324', '哈巴河县', '', 'habahexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654325', '青河县', '', 'qinghexian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654326', '吉木乃县', '', 'jimunaixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654327', '北屯市', '', 'beitunshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('654399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('659000', '自治区直辖县级行政区划', 'z', 'zizhiquzhixiaxianjixingzhengquhua', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('659001', '石河子市', '', 'shihezishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('659002', '阿拉尔市', '', 'alaershi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('659003', '图木舒克市', '', 'tumushukeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('659004', '五家渠市', '', 'wujiaqushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710100', '台北市', 't', 'taibeishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710101', '中正区', '', 'zhongzhengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710102', '大同区', '', 'datongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710103', '中山区', '', 'zhongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710104', '松山区', '', 'songshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710105', '大安区', '', 'daanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710106', '万华区', '', 'wanhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710107', '信义区', '', 'xinyiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710108', '士林区', '', 'shilinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710109', '北投区', '', 'beitouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710110', '内湖区', '', 'neihuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710111', '南港区', '', 'nangangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710112', '文山区', '', 'wenshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710199', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710200', '高雄市', 'g', 'gaoxiongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710201', '新兴区', '', 'xinxingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710202', '前金区', '', 'qianjinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710203', '芩雅区', '', 'yaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710204', '盐埕区', '', 'yanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710205', '鼓山区', '', 'gushanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710206', '旗津区', '', 'qijinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710207', '前镇区', '', 'qianzhenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710208', '三民区', '', 'sanminqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710209', '左营区', '', 'zuoyingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710210', '楠梓区', '', 'qu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710211', '小港区', '', 'xiaogangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710241', '苓雅区', '', 'yaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710242', '仁武区', '', 'renwuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710243', '大社区', '', 'dashequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710244', '冈山区', '', 'gangshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710245', '路竹区', '', 'luzhuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710246', '阿莲区', '', 'alianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710247', '田寮区', '', 'tianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710248', '燕巢区', '', 'yanchaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710249', '桥头区', '', 'qiaotouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710250', '梓官区', '', 'guanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710251', '弥陀区', '', 'mituoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710252', '永安区', '', 'yonganqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710253', '湖内区', '', 'huneiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710254', '凤山区', '', 'fengshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710255', '大寮区', '', 'daqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710256', '林园区', '', 'linyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710257', '鸟松区', '', 'niaosongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710258', '大树区', '', 'dashuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710259', '旗山区', '', 'qishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710260', '美浓区', '', 'meinongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710261', '六龟区', '', 'liuguiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710262', '内门区', '', 'neimenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710263', '杉林区', '', 'shanlinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710264', '甲仙区', '', 'jiaxianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710265', '桃源区', '', 'taoyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710266', '那玛夏区', '', 'namaxiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710267', '茂林区', '', 'maolinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710268', '茄萣区', '', 'qieququ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710299', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710300', '台南市', 't', 'tainanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710301', '中西区', '', 'zhongxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710302', '东区', '', 'dongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710303', '南区', '', 'nanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710304', '北区', '', 'beiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710305', '安平区', '', 'anpingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710306', '安南区', '', 'annanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710339', '永康区', '', 'yongkangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710340', '归仁区', '', 'guirenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710341', '新化区', '', 'xinhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710342', '左镇区', '', 'zuozhenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710343', '玉井区', '', 'yujingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710344', '楠西区', '', 'xiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710345', '南化区', '', 'nanhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710346', '仁德区', '', 'rendequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710347', '关庙区', '', 'guanmiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710348', '龙崎区', '', 'longqiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710349', '官田区', '', 'guantianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710350', '麻豆区', '', 'madouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710351', '佳里区', '', 'jialiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710352', '西港区', '', 'xigangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710353', '七股区', '', 'qiguqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710354', '将军区', '', 'jiangjunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710355', '学甲区', '', 'xuejiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710356', '北门区', '', 'beimenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710357', '新营区', '', 'xinyingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710358', '后壁区', '', 'houbiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710359', '白河区', '', 'baihequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710360', '东山区', '', 'dongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710361', '六甲区', '', 'liujiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710362', '下营区', '', 'xiayingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710363', '柳营区', '', 'liuyingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710364', '盐水区', '', 'yanshuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710365', '善化区', '', 'shanhuaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710366', '大内区', '', 'daneiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710367', '山上区', '', 'shanshangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710368', '新市区', '', 'xinshiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710369', '安定区', '', 'andingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710399', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710400', '台中市', 't', 'taizhongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710401', '中区', '', 'zhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710402', '东区', '', 'dongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710403', '南区', '', 'nanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710404', '西区', '', 'xiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710405', '北区', '', 'beiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710406', '北屯区', '', 'beitunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710407', '西屯区', '', 'xitunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710408', '南屯区', '', 'nantunqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710431', '太平区', '', 'taipingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710432', '大里区', '', 'daliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710433', '雾峰区', '', 'wufengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710434', '乌日区', '', 'wuriqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710435', '丰原区', '', 'fengyuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710436', '后里区', '', 'houliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710437', '石冈区', '', 'shigangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710438', '东势区', '', 'dongshiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710439', '和平区', '', 'hepingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710440', '新社区', '', 'xinshequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710441', '潭子区', '', 'tanziqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710442', '大雅区', '', 'dayaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710443', '神冈区', '', 'shengangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710444', '大肚区', '', 'daduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710445', '沙鹿区', '', 'shaluqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710446', '龙井区', '', 'longjingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710447', '梧栖区', '', 'wuqiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710448', '清水区', '', 'qingshuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710449', '大甲区', '', 'dajiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710450', '外埔区', '', 'waipuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710451', '大安区', '', 'daanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710499', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710500', '金门县', 'j', 'jinmenxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710507', '金沙镇', '', 'jinshazhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710508', '金湖镇', '', 'jinhuzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710509', '金宁乡', '', 'jinningxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710510', '金城镇', '', 'jinchengzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710511', '烈屿乡', '', 'lieyuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710512', '乌坵乡', '', 'wuwxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710600', '南投县', 'n', 'nantouxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710614', '南投市', '', 'nantoushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710615', '中寮乡', '', 'zhongxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710616', '草屯镇', '', 'caotunzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710617', '国姓乡', '', 'guoxingxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710618', '埔里镇', '', 'pulizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710619', '仁爱乡', '', 'renaixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710620', '名间乡', '', 'mingjianxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710621', '集集镇', '', 'jijizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710622', '水里乡', '', 'shuilixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710623', '鱼池乡', '', 'yuchixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710624', '信义乡', '', 'xinyixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710625', '竹山镇', '', 'zhushanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710626', '鹿谷乡', '', 'luguxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710700', '基隆市', 'j', 'jilongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710701', '仁爱区', '', 'renaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710702', '信义区', '', 'xinyiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710703', '中正区', '', 'zhongzhengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710704', '中山区', '', 'zhongshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710705', '安乐区', '', 'anlequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710706', '暖暖区', '', 'nuannuanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710707', '七堵区', '', 'qiduqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710799', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710800', '新竹市', 'x', 'xinzhushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710801', '东区', '', 'dongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710802', '北区', '', 'beiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710803', '香山区', '', 'xiangshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710899', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710900', '嘉义市', 'j', 'jiayishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710901', '东区', '', 'dongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710902', '西区', '', 'xiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('710999', '其它区', '', 'qitaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711100', '新北市', 'x', 'xinbeishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711130', '万里区', '', 'wanliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711131', '金山区', '', 'jinshanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711132', '板桥区', '', 'banqiaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711133', '汐止区', '', 'xizhiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711134', '深坑区', '', 'shenkengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711135', '石碇区', '', 'shiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711136', '瑞芳区', '', 'ruifangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711137', '平溪区', '', 'pingxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711138', '双溪区', '', 'shuangxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711139', '贡寮区', '', 'gongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711140', '新店区', '', 'xindianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711141', '坪林区', '', 'pinglinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711142', '乌来区', '', 'wulaiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711143', '永和区', '', 'yonghequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711144', '中和区', '', 'zhonghequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711145', '土城区', '', 'tuchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711146', '三峡区', '', 'sanxiaqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711147', '树林区', '', 'shulinqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711148', '莺歌区', '', 'gequ', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711149', '三重区', '', 'sanzhongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711150', '新庄区', '', 'xinzhuangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711151', '泰山区', '', 'taishanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711152', '林口区', '', 'linkouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711153', '芦洲区', '', 'luzhouqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711154', '五股区', '', 'wuguqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711155', '八里区', '', 'baliqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711156', '淡水区', '', 'danshuiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711157', '三芝区', '', 'sanzhiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711158', '石门区', '', 'shimenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711200', '宜兰县', 'y', 'yilanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711214', '宜兰市', '', 'yilanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711215', '头城镇', '', 'touchengzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711216', '礁溪乡', '', 'jiaoxixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711217', '壮围乡', '', 'zhuangweixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711218', '员山乡', '', 'yuanshanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711219', '罗东镇', '', 'luodongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711220', '三星乡', '', 'sanxingxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711221', '大同乡', '', 'datongxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711222', '五结乡', '', 'wujiexiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711223', '冬山乡', '', 'dongshanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711224', '苏澳镇', '', 'suaozhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711225', '南澳乡', '', 'nanaoxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711226', '钓鱼台', '', 'diaoyutai', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711300', '新竹县', 'x', 'xinzhuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711314', '竹北市', '', 'zhubeishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711315', '湖口乡', '', 'hukouxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711316', '新丰乡', '', 'xinfengxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711317', '新埔镇', '', 'xinpuzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711318', '关西镇', '', 'guanxizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711319', '芎林乡', '', 'linxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711320', '宝山乡', '', 'baoshanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711321', '竹东镇', '', 'zhudongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711322', '五峰乡', '', 'wufengxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711323', '横山乡', '', 'hengshanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711324', '尖石乡', '', 'jianshixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711325', '北埔乡', '', 'beipuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711326', '峨眉乡', '', 'emeixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711400', '桃园县', 't', 'taoyuanxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711414', '中坜市', '', 'zhongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711415', '平镇市', '', 'pingzhenshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711416', '龙潭乡', '', 'longtanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711417', '杨梅市', '', 'yangmeishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711418', '新屋乡', '', 'xinwuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711419', '观音乡', '', 'guanyinxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711420', '桃园市', '', 'taoyuanshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711421', '龟山乡', '', 'guishanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711422', '八德市', '', 'badeshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711423', '大溪镇', '', 'daxizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711424', '复兴乡', '', 'fuxingxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711425', '大园乡', '', 'dayuanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711426', '芦竹乡', '', 'luzhuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711500', '苗栗县', 'm', 'miaolixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711519', '竹南镇', '', 'zhunanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711520', '头份镇', '', 'toufenzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711521', '三湾乡', '', 'sanwanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711522', '南庄乡', '', 'nanzhuangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711523', '狮潭乡', '', 'shitanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711524', '后龙镇', '', 'houlongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711525', '通霄镇', '', 'tongxiaozhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711526', '苑里镇', '', 'yuanlizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711527', '苗栗市', '', 'miaolishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711528', '造桥乡', '', 'zaoqiaoxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711529', '头屋乡', '', 'touwuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711530', '公馆乡', '', 'gongguanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711531', '大湖乡', '', 'dahuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711532', '泰安乡', '', 'taianxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711533', '铜锣乡', '', 'tongluoxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711534', '三义乡', '', 'sanyixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711535', '西湖乡', '', 'xihuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711536', '卓兰镇', '', 'zhuolanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711700', '彰化县', 'z', 'zhanghuaxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711727', '彰化市', '', 'zhanghuashi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711728', '芬园乡', '', 'fenyuanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711729', '花坛乡', '', 'huatanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711730', '秀水乡', '', 'xiushuixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711731', '鹿港镇', '', 'lugangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711732', '福兴乡', '', 'fuxingxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711733', '线西乡', '', 'xianxixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711734', '和美镇', '', 'hemeizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711735', '伸港乡', '', 'shengangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711736', '员林镇', '', 'yuanlinzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711737', '社头乡', '', 'shetouxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711738', '永靖乡', '', 'yongjingxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711739', '埔心乡', '', 'puxinxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711740', '溪湖镇', '', 'xihuzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711741', '大村乡', '', 'dacunxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711742', '埔盐乡', '', 'puyanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711743', '田中镇', '', 'tianzhongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711744', '北斗镇', '', 'beidouzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711745', '田尾乡', '', 'tianweixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711746', '埤头乡', '', 'touxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711747', '溪州乡', '', 'xizhouxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711748', '竹塘乡', '', 'zhutangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711749', '二林镇', '', 'erlinzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711750', '大城乡', '', 'dachengxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711751', '芳苑乡', '', 'fangyuanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711752', '二水乡', '', 'ershuixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711900', '嘉义县', 'j', 'jiayixian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711919', '番路乡', '', 'fanluxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711920', '梅山乡', '', 'meishanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711921', '竹崎乡', '', 'zhuqixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711922', '阿里山乡', '', 'alishanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711923', '中埔乡', '', 'zhongpuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711924', '大埔乡', '', 'dapuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711925', '水上乡', '', 'shuishangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711926', '鹿草乡', '', 'lucaoxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711927', '太保市', '', 'taibaoshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711928', '朴子市', '', 'puzishi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711929', '东石乡', '', 'dongshixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711930', '六脚乡', '', 'liujiaoxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711931', '新港乡', '', 'xingangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711932', '民雄乡', '', 'minxiongxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711933', '大林镇', '', 'dalinzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711934', '溪口乡', '', 'xikouxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711935', '义竹乡', '', 'yizhuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('711936', '布袋镇', '', 'budaizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712100', '云林县', 'y', 'yunlinxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712121', '斗南镇', '', 'dounanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712122', '大埤乡', '', 'daxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712123', '虎尾镇', '', 'huweizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712124', '土库镇', '', 'tukuzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712125', '褒忠乡', '', 'baozhongxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712126', '东势乡', '', 'dongshixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712127', '台西乡', '', 'taixixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712128', '仑背乡', '', 'lunbeixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712129', '麦寮乡', '', 'maixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712130', '斗六市', '', 'douliushi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712131', '林内乡', '', 'linneixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712132', '古坑乡', '', 'gukengxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712133', '莿桐乡', '', 'qiatongxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712134', '西螺镇', '', 'xiluozhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712135', '二仑乡', '', 'erlunxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712136', '北港镇', '', 'beigangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712137', '水林乡', '', 'shuilinxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712138', '口湖乡', '', 'kouhuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712139', '四湖乡', '', 'sihuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712140', '元长乡', '', 'yuanchangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712400', '屏东县', 'p', 'pingdongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712434', '屏东市', '', 'pingdongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712435', '三地门乡', '', 'sandimenxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712436', '雾台乡', '', 'wutaixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712437', '玛家乡', '', 'majiaxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712438', '九如乡', '', 'jiuruxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712439', '里港乡', '', 'ligangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712440', '高树乡', '', 'gaoshuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712441', '盐埔乡', '', 'yanpuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712442', '长治乡', '', 'changzhixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712443', '麟洛乡', '', 'luoxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712444', '竹田乡', '', 'zhutianxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712445', '内埔乡', '', 'neipuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712446', '万丹乡', '', 'wandanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712447', '潮州镇', '', 'chaozhouzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712448', '泰武乡', '', 'taiwuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712449', '来义乡', '', 'laiyixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712450', '万峦乡', '', 'wanluanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712451', '崁顶乡', '', 'dingxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712452', '新埤乡', '', 'xinxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712453', '南州乡', '', 'nanzhouxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712454', '林边乡', '', 'linbianxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712455', '东港镇', '', 'donggangzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712456', '琉球乡', '', 'liuqiuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712457', '佳冬乡', '', 'jiadongxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712458', '新园乡', '', 'xinyuanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712459', '枋寮乡', '', 'xiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712460', '枋山乡', '', 'shanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712461', '春日乡', '', 'chunrixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712462', '狮子乡', '', 'shizixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712463', '车城乡', '', 'chechengxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712464', '牡丹乡', '', 'mudanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712465', '恒春镇', '', 'hengchunzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712466', '满州乡', '', 'manzhouxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712500', '台东县', 't', 'taidongxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712517', '台东市', '', 'taidongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712518', '绿岛乡', '', 'lvdaoxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712519', '兰屿乡', '', 'lanyuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712520', '延平乡', '', 'yanpingxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712521', '卑南乡', '', 'beinanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712522', '鹿野乡', '', 'luyexiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712523', '关山镇', '', 'guanshanzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712524', '海端乡', '', 'haiduanxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712525', '池上乡', '', 'chishangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712526', '东河乡', '', 'donghexiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712527', '成功镇', '', 'chenggongzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712528', '长滨乡', '', 'changbinxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712529', '金峰乡', '', 'jinfengxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712530', '大武乡', '', 'dawuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712531', '达仁乡', '', 'darenxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712532', '太麻里乡', '', 'taimalixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712600', '花莲县', 'h', 'hualianxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712615', '花莲市', '', 'hualianshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712616', '新城乡', '', 'xinchengxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712617', '太鲁阁', '', 'tailuge', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712618', '秀林乡', '', 'xiulinxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712619', '吉安乡', '', 'jianxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712620', '寿丰乡', '', 'shoufengxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712621', '凤林镇', '', 'fenglinzhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712622', '光复乡', '', 'guangfuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712623', '丰滨乡', '', 'fengbinxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712624', '瑞穗乡', '', 'ruisuixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712625', '万荣乡', '', 'wanrongxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712626', '玉里镇', '', 'yulizhen', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712627', '卓溪乡', '', 'zhuoxixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712628', '富里乡', '', 'fulixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712700', '澎湖县', 'p', 'penghuxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712707', '马公市', '', 'magongshi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712708', '西屿乡', '', 'xiyuxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712709', '望安乡', '', 'wanganxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712710', '七美乡', '', 'qimeixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712711', '白沙乡', '', 'baishaxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712712', '湖西乡', '', 'huxixiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712800', '连江县', 'l', 'lianjiangxian', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712805', '南竿乡', '', 'nanganxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712806', '北竿乡', '', 'beiganxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712807', '莒光乡', '', 'guangxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('712808', '东引乡', '', 'dongyinxiang', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810100', '香港岛', 'x', 'xianggangdao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810101', '中西区', '', 'zhongxiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810102', '湾仔', '', 'wanzi', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810103', '东区', '', 'dongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810104', '南区', '', 'nanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810200', '九龙', 'j', 'jiulong', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810201', '九龙城区', '', 'jiulongchengqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810202', '油尖旺区', '', 'youjianwangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810203', '深水埗区', '', 'shenshuidu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810204', '黄大仙区', '', 'huangdaxianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810205', '观塘区', '', 'guantangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810300', '新界', 'x', 'xinjie', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810301', '北区', '', 'beiqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810302', '大埔区', '', 'dapuqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810303', '沙田区', '', 'shatianqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810304', '西贡区', '', 'xigongqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810305', '元朗区', '', 'yuanlangqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810306', '屯门区', '', 'tunmenqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810307', '荃湾区', '', 'wanqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810308', '葵青区', '', 'kuiqingqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('810309', '离岛区', '', 'lidaoqu', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('820100', '澳门半岛', 'a', 'aomenbandao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('820101', '澳门半岛', '', 'aomenbandao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('820200', '离岛', 'l', 'lidao', '0', '0');
INSERT INTO `pigcms_lbs_area` VALUES ('820201', '离岛', '', 'lidao', '0', '0');

-- ----------------------------
-- Table structure for `pigcms_location_qrcode`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_location_qrcode`;
CREATE TABLE `pigcms_location_qrcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket` varchar(500) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `openid` char(40) NOT NULL,
  `lat` char(10) NOT NULL,
  `lng` char(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=400002069 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='使用微信登录生成的临时二维码';

-- ----------------------------
-- Records of pigcms_location_qrcode
-- ----------------------------
INSERT INTO `pigcms_location_qrcode` VALUES ('400001711', 'gQHZ7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0lrUEVhTHJsVG9RM2piNFJJMjF1AAIEYlxOVwMEgDoJAA==', '0', '1464753248', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001712', 'gQGs7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1ZrTngxQjNsOElTSjRzcW1sbTF1AAIEYlxOVwMEgDoJAA==', '0', '1464753249', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001713', 'gQGQ7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0VFTnpZb0xsOElTSmpZd1NsRzF1AAIEY1xOVwMEgDoJAA==', '0', '1464753249', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001710', 'gQEC8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL28wTTdKTm5scVlUUUl6OUYzRzF1AAIEYVxOVwMEgDoJAA==', '0', '1464753247', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001714', 'gQGm7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2xVTl83T0xsMDRTcTVnbXltVzF1AAIEY1xOVwMEgDoJAA==', '0', '1464753249', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001715', 'gQE/7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3ZVTXFhejdsdElUTmxTRUd6VzF1AAIEYlxOVwMEgDoJAA==', '0', '1464753250', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001716', 'gQHr7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1FFTkE3UDdseUlTeEw5eVhwMjF1AAIEZFxOVwMEgDoJAA==', '0', '1464753250', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001717', 'gQH37zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0VVUHlpREhsYjRRVzFZM21GVzF1AAIEY1xOVwMEgDoJAA==', '0', '1464753251', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001718', 'gQG17zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3FVTXdISXpsczRUS1JEVnMxMjF1AAIEZVxOVwMEgDoJAA==', '0', '1464753250', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001719', 'gQG87zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2lFUE1fNzNsWFlRa3N4U1pLMjF1AAIEZVxOVwMEgDoJAA==', '0', '1464753252', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001720', 'gQGX7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2kwTVl6X3psam9UMzFSZXEtMjF1AAIEdlxOVwMEgDoJAA==', '0', '1464753270', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001721', 'gQGh7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1QwTWVvWGpsaUlUeDY5UEVfVzF1AAIEd1xOVwMEgDoJAA==', '0', '1464753271', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001722', 'gQFC8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1ZrTXJ5Ny1scjRUV1g4cTh6RzF1AAIEyl9OVwMEgDoJAA==', '0', '1464754121', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001723', 'gQEm8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3ZrUE40Sm5sVklRdHVpS0tLbTF1AAIEkGJOVwMEgDoJAA==', '0', '1464754829', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001724', 'gQGD8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1RFTXdNcVBsdW9URG9OQkwxMjF1AAIEmGNOVwMEgDoJAA==', '0', '1464755094', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001725', 'gQHp7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL19rTnc3MGpsOFlTSUlHYWRsMjF1AAIERWVOVwMEgDoJAA==', '0', '1464755522', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001726', 'gQGt7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzVVTmZwckRseVlTd2pubkR1RzF1AAIEuWdOVwMEgDoJAA==', '0', '1464756151', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001727', 'gQG87zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzFrUERSVFhsWFlRazIwb29KRzF1AAIEcnlOVwMEgDoJAA==', '0', '1464760689', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001728', 'gQHR7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0cwTkg3c0hsejRTMlNZZVZvRzF1AAIEeHtOVwMEgDoJAA==', '0', '1464761205', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001729', 'gQH37joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL20wTkJvd0RseUlTeFJRZlpwbTF1AAIEe31OVwMEgDoJAA==', '0', '1464761720', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001730', 'gQEc8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2QwTVVPQ2JsaVlUd0ZPdFc4MjF1AAIE_X1OVwMEgDoJAA==', '0', '1464761849', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001731', 'gQFM7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3JrUGVmQ2ZsVm9RdmlESUhPVzF1AAIEN39OVwMEgDoJAA==', '0', '1464762165', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001732', 'gQHG8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzgwTnhaNFRsN0lTVmJXOEpsbTF1AAIEdopOVwMEgDoJAA==', '0', '1464765045', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001733', 'gQHQ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3QwTTVfVmpsb29UYmF5dVIzbTF1AAIEnI1OVwMEgDoJAA==', '0', '1464765849', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001734', 'gQFP8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzVFTW1mSnZsb0lUWmZuZ0p3VzF1AAIEFptOVwMEgDoJAA==', '0', '1464769299', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001735', 'gQF38ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLy1FTTlJQlBscG9UZnNtQkkybTF1AAIEiJ5OVwMEgDoJAA==', '0', '1464770181', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001736', 'gQFw8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3FrTkowNXJsellTMG5qYWtybTF1AAIE4J9OVwMEgDoJAA==', '0', '1464770526', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001737', 'gQEF8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1drTUJQQzdsZ0lUNU5jWk81bTF1AAIEF6dOVwMEgDoJAA==', '0', '1464772372', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001738', 'gQFD8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL25rUE9jVkhsV1lRZ3d3SVZLVzF1AAIEGadOVwMEgDoJAA==', '0', '1464772376', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001739', 'gQEd8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3MwUEpuMURsWklRZEFTLUJMbTF1AAIEG6dOVwMEgDoJAA==', '0', '1464772378', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001740', 'gQFg8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL05FTmVWZ3JseG9TLUZhZzl1VzF1AAIEHadOVwMEgDoJAA==', '0', '1464772379', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001741', 'gQEs8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1ZrTk9uc2JsNElTWmM4ckRxVzF1AAIEXKdOVwMEgDoJAA==', '0', '1464772443', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001742', 'gQEn8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL00wUEFxTS1sUllROEthLWVKMjF1AAIEXqdOVwMEgDoJAA==', '0', '1464772445', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001743', 'gQFU8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2FVTlY1M2psMW9TdmktV1hzbTF1AAIEXqdOVwMEgDoJAA==', '0', '1464772445', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001744', 'gQFe8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL18wTlRkanZsMTRTdXkyY0J0RzF1AAIEYadOVwMEgDoJAA==', '0', '1464772448', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001745', 'gQEy8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2hVTXg2RFhsczRUS0pSbVoxbTF1AAIEnalOVwMEgDoJAA==', '0', '1464773019', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001746', 'gQHy8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1MwTXFZSGZsc1lUSUlkY0l6VzF1AAIEnalOVwMEgDoJAA==', '0', '1464773021', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001747', 'gQHV8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzcwTkNIRzNsM1lTazQzTndwVzF1AAIEnqlOVwMEgDoJAA==', '0', '1464773022', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001748', 'gQGX8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0VrTWpnX3Jsb1lUWUJvN3l4RzF1AAIEn6lOVwMEgDoJAA==', '0', '1464773022', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001749', 'gQF_8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3RrTTFDbVBscG9UZm9pcHEwbTF1AAIEoKlOVwMEgDoJAA==', '0', '1464773023', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001750', 'gQHY8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0JFTS05V3ZscTRUUzU1aVMyRzF1AAIEoKlOVwMEgDoJAA==', '0', '1464773024', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001751', 'gQGN8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3FrTW9FR0hscW9UVHBqWmh6MjF1AAIEoalOVwMEgDoJAA==', '0', '1464773024', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001752', 'gQG18DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1AwTXFkUFRsdFlUTXdxTVl6VzF1AAIEoqlOVwMEgDoJAA==', '0', '1464773025', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001753', 'gQGd8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1UwTkVMVTdsd0lTNVRjOWFvMjF1AAIEo6lOVwMEgDoJAA==', '0', '1464773027', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001754', 'gQE98ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzEwTnBvaDdsOTRTT0ZrdlBqbTF1AAIEo6lOVwMEgDoJAA==', '0', '1464773027', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001755', 'gQEy8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1VrTkhaczdsM29Tbmg4NE1vRzF1AAIEpKlOVwMEgDoJAA==', '0', '1464773027', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001756', 'gQFt8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2VrTUdiMy1sbjRUbUZfWUY0VzF1AAIEpalOVwMEgDoJAA==', '0', '1464773029', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001757', 'gQEb8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2trTTh5RWZsbG9UdllBNlIyMjF1AAIEpalOVwMEgDoJAA==', '0', '1464773029', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001758', 'gQE88ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2xrTTAxQ2JsdG9UUEdRcWwwMjF1AAIEpqlOVwMEgDoJAA==', '0', '1464773029', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001759', 'gQGf8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzVrTW91QVhsdm9USEpucmR6MjF1AAIEpqlOVwMEgDoJAA==', '0', '1464773030', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001760', 'gQFY8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzVFTml2RkhsLUlTRmRIalJoVzF1AAIEp6lOVwMEgDoJAA==', '0', '1464773030', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001761', 'gQE/8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1owTVliejNsbklUbFNQc1ktMjF1AAIEp6lOVwMEgDoJAA==', '0', '1464773031', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001762', 'gQHb8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzJVTjhCRlRsNDRTYTlFVm9tMjF1AAIEqKlOVwMEgDoJAA==', '0', '1464773032', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001763', 'gQHr8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0QwUEU0c2ZsVDRRMlY1T2FJMjF1AAIEqKlOVwMEgDoJAA==', '0', '1464773032', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001764', 'gQHL8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0RVTXBuZkxsb0lUWkg1SG56bTF1AAIEqalOVwMEgDoJAA==', '0', '1464773033', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001765', 'gQHc8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2drTmxqbjNsNW9TZkRCN19nbTF1AAIEqqlOVwMEgDoJAA==', '0', '1464773033', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001766', 'gQGi8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3ZVTWVjb1RsbllUa05pRUNfVzF1AAIEqqlOVwMEgDoJAA==', '0', '1464773033', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001767', 'gQHU8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1lVTXJnaDdsdVlUQWdQM2p6RzF1AAIEq6lOVwMEgDoJAA==', '0', '1464773034', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001768', 'gQHG8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2VFTWVSaUxsZ29UN1llUXBfVzF1AAIEq6lOVwMEgDoJAA==', '0', '1464773035', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001769', 'gQEg8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL05VTVNpcTNsbllUa2I2bjI5VzF1AAIErKlOVwMEgDoJAA==', '0', '1464773035', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001770', 'gQHv8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0VFTXRmY0hsZzRUNjBZd2d5bTF1AAIEralOVwMEgDoJAA==', '0', '1464773037', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001771', 'gQFj8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3lVTWI2SzdsaTRUeThsV0wtRzF1AAIEralOVwMEgDoJAA==', '0', '1464773037', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001772', 'gQHx8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2NVTUEtWDNsaklUMWpPMkM1MjF1AAIErqlOVwMEgDoJAA==', '0', '1464773037', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001773', 'gQE98ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xVTi1BNXZsNUlTZHlMRnJtRzF1AAIEv6lOVwMEgDoJAA==', '0', '1464773053', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001774', 'gQFJ8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0NVTTliUkRsdUlUQkNaVWIybTF1AAIExKlOVwMEgDoJAA==', '0', '1464773059', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001775', 'gQHn8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2owTVNFNWZsbklUbGRoTnU5VzF1AAIE06lOVwMEgDoJAA==', '0', '1464773074', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001776', 'gQFT8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0UwTi1nTnJsNllTUU5JLWxtRzF1AAIE6alOVwMEgDoJAA==', '0', '1464773096', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001777', 'gQFm8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1RrTTVla2pscm9UWEFkSWUzbTF1AAIECKpOVwMEgDoJAA==', '0', '1464773127', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001778', 'gQFx8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BVTlA5aFhsMFlTb282R2JxRzF1AAIEZbBOVwMEgDoJAA==', '0', '1464774754', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001779', 'gQFF8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzBrUDh4NzNsYjRRVzFVNm5HMjF1AAIEN7FOVwMEgDoJAA==', '0', '1464774964', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001780', 'gQFZ8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2ZFTWVIRjNsaElUOVFPQjFfVzF1AAIE4LVOVwMEgDoJAA==', '0', '1464776157', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001781', 'gQEu8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzNVTkNqaW5sd1lTNEIwSF9wVzF1AAIEnbdOVwMEgDoJAA==', '0', '1464776603', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001782', 'gQFX8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2MwUGJ3RWZsU1lRd2llX2hQRzF1AAIE_L1OVwMEgDoJAA==', '0', '1464778231', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001783', 'gQG88DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3BVTklFMGpsMElTcGd6bDRyMjF1AAIE9MdOVwMEgDoJAA==', '0', '1464780786', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001784', 'gQE28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL19rTkctRXpsM29Tbk4yYVhvVzF1AAIEUd9OVwMEgDoJAA==', '0', '1464786766', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001785', 'gQG_8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1ZrUDBhNHJsY1lRSXlzb2RFMjF1AAIEot9OVwMEgDoJAA==', '0', '1464786848', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001786', 'gQGV8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3AwTnRGc1hsXzRTQ0NUdHppbTF1AAIEqN9OVwMEgDoJAA==', '0', '1464786855', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001787', 'gQEO8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzQwUGZTR3psVFlRMHVuOHBPRzF1AAIEqd9OVwMEgDoJAA==', '0', '1464786856', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001788', 'gQHQ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0gwTVp1NGJsbElUdFg0UEYtbTF1AAIEAOBOVwMEgDoJAA==', '0', '1464786942', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001789', 'gQHE8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3dVTkprQjdsMjRTaU1sM3hybTF1AAIEwuBOVwMEgDoJAA==', '0', '1464787137', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001790', 'gQEo8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzdFTlFVdmZsb29UYk5IQlR0MjF1AAIEVeROVwMEgDoJAA==', '0', '1464788051', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001791', 'gQHK7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL28wTmtpWnpsX0lTQnl6LW1nMjF1AAIEZexOVwMEgDoJAA==', '0', '1464790115', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001792', 'gQFl8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2RFTllYQVRsd0lTNVVlZzN2MjF1AAIEPfBOVwMEgDoJAA==', '0', '1464791100', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001793', 'gQHK8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLy1FTmR1aGZsMElTcExHREV1bTF1AAIEpANPVwMEgDoJAA==', '0', '1464796065', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001794', 'gQE78ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2MwTlBYSVhsNllTUTFfOEpxRzF1AAIErQNPVwMEgDoJAA==', '0', '1464796077', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001795', 'gQGi8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21FTVZ6OERsbTRUaTZnU3k4bTF1AAIEtgNPVwMEgDoJAA==', '0', '1464796086', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001796', 'gQEe8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1NFTS1vR2JscW9UVDg5VEcyRzF1AAIEugNPVwMEgDoJAA==', '0', '1464796089', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001797', 'gQH28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL19FUExvLW5sU1lRdzMyVFNMRzF1AAIEvANPVwMEgDoJAA==', '0', '1464796091', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001798', 'gQEk8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2xVTkVrTkhsMjRTaXFRbjhvMjF1AAIEXBJPVwMEgDoJAA==', '0', '1464799835', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001799', 'gQH67zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3IwTmliVS1sNW9TZjhETWFoVzF1AAIEdx5PVwMEgDoJAA==', '0', '1464802932', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001800', 'gQEL8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2owTUVFX1Rsam9UM0JSTnE0MjF1AAIEnC5PVwMEgDoJAA==', '0', '1464807066', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001801', 'gQFu8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xrTm9GR2JsN29TWEliSmhqMjF1AAIExzBPVwMEgDoJAA==', '0', '1464807620', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001802', 'gQGr8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0RFUEF3dzNsTVlSSXY1REJKMjF1AAIEDTFPVwMEgDoJAA==', '0', '1464807693', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001803', 'gQGN8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BrTkVUOGpseFlTOHhLSTlvMjF1AAIEzjFPVwMEgDoJAA==', '0', '1464807884', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001804', 'gQFd8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2VrTkxuRDdsM0lTbHBlYjRyRzF1AAIE0jFPVwMEgDoJAA==', '0', '1464807889', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001805', 'gQHh7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2NFTlFFZGZseTRTeXlfeDV0MjF1AAIEBDNPVwMEgDoJAA==', '0', '1464808194', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001806', 'gQF67zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2RFTW1TTFBsdElUTjh1Z3B3VzF1AAIEYjNPVwMEgDoJAA==', '0', '1464808289', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001807', 'gQGk7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1dFTldJb1RsMW9Tdmc4UlJzVzF1AAIEeDNPVwMEgDoJAA==', '0', '1464808312', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001808', 'gQHh7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzVVTWVxQWJsajRUMk5ubktfVzF1AAIEXjRPVwMEgDoJAA==', '0', '1464808540', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001809', 'gQFz8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0RrUC1GMGpsWVlRWUxKSjZHRzF1AAIEXzRPVwMEgDoJAA==', '0', '1464808542', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001810', 'gQHS8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2NrTTRPcjNscElUZGlPNVYzMjF1AAIEsDRPVwMEgDoJAA==', '0', '1464808623', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001811', 'gQGL8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLy0wTWRPMzNsaG9ULXhHTlRfbTF1AAIECjVPVwMEgDoJAA==', '0', '1464808713', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001812', 'gQE78DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0RVTnN3V25sN0lTVjJKR3lpMjF1AAIEDDVPVwMEgDoJAA==', '0', '1464808715', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001813', 'gQG48DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzhVTnIwQnJsODRTS1JtMjdqRzF1AAIEETVPVwMEgDoJAA==', '0', '1464808720', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001814', 'gQEM8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1prTmpJWkhsX1lTQXEtcEloRzF1AAIEFzVPVwMEgDoJAA==', '0', '1464808726', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001815', 'gQE18ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1UwTUVpTlhscVlUUWM4LVc0MjF1AAIEjjVPVwMEgDoJAA==', '0', '1464808844', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001816', 'gQGO8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2swTkJRV2ZsM0lTbHlBOHZwbTF1AAIEljVPVwMEgDoJAA==', '0', '1464808853', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001817', 'gQGd8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2UwUFdZTzdsU1lRd2lPY01NVzF1AAIEpTVPVwMEgDoJAA==', '0', '1464808869', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001818', 'gQGA8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0NVTl85OFhsNG9TYlJwV1ltVzF1AAIEwTVPVwMEgDoJAA==', '0', '1464808896', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001819', 'gQHL8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzIwTmdZN0RsNm9TVGRVY2FoMjF1AAIExDVPVwMEgDoJAA==', '0', '1464808900', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001820', 'gQHN8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2MwTjRiTUxsNllTUW9POE9uMjF1AAIE6DVPVwMEgDoJAA==', '0', '1464808935', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001821', 'gQGI8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1gwUHM1MURsY29RTGxjT0tDMjF1AAIEEjZPVwMEgDoJAA==', '0', '1464808977', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001822', 'gQFr8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3FVTU80RjNsbDRUdWFUV0s2VzF1AAIEFTZPVwMEgDoJAA==', '0', '1464808981', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001823', 'gQGj7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3UwUGFhMmJsV29Ranl5Y1lQVzF1AAIEGDZPVwMEgDoJAA==', '0', '1464808983', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001824', 'gQHW7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3QwTUtMZHpsbElUdE95dEE3VzF1AAIEGDZPVwMEgDoJAA==', '0', '1464808984', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001825', 'gQHH7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0FFTWg0Y3ZsbzRUYVY1eVF4bTF1AAIEOzZPVwMEgDoJAA==', '0', '1464809019', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001826', 'gQH37zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0ZVTnZrdlhsOVlTTUQ0bjdpRzF1AAIETjZPVwMEgDoJAA==', '0', '1464809037', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001827', 'gQHb7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2trTlE3R3ZsMm9TamFBNlZ0MjF1AAIEZjZPVwMEgDoJAA==', '0', '1464809062', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001828', 'gQHw7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0EwTUN3M1BsZ0lUNXpwX3k1VzF1AAIEajZPVwMEgDoJAA==', '0', '1464809065', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001829', 'gQHY7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzAwUGh3azdsZTRRQ0lrX3JCbTF1AAIEcjZPVwMEgDoJAA==', '0', '1464809074', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001830', 'gQHg7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3kwUGtFTGJsWllRY0VGZGlBMjF1AAIEczZPVwMEgDoJAA==', '0', '1464809075', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001831', 'gQHg8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzMwTVZ5NExsbklUbDYwT3g4bTF1AAIEtDZPVwMEgDoJAA==', '0', '1464809138', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001832', 'gQHY8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BrUGRJYkhsUllRODA2SktPbTF1AAIEtzZPVwMEgDoJAA==', '0', '1464809143', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001833', 'gQGc8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLy1VUG12Q1RsRjRSdUdHR19BVzF1AAIE5zZPVwMEgDoJAA==', '0', '1464809191', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001834', 'gQHJ7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3FrTW5HWGJscjRUV3VEWml3RzF1AAIE8DZPVwMEgDoJAA==', '0', '1464809200', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001835', 'gQHH8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzRVTUw1NHJsbm9UbjhYMkI3RzF1AAIE9zZPVwMEgDoJAA==', '0', '1464809207', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001836', 'gQHu7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2VFUFdfTHZsU0lReFJ1U1ZNVzF1AAIEAjdPVwMEgDoJAA==', '0', '1464809218', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001837', 'gQFA8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3AwTlJRSWJsMllTZ0hEczd0bTF1AAIEAzdPVwMEgDoJAA==', '0', '1464809219', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001838', 'gQHD7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3ZrTU93VXJsazRUcVNDS3Y2VzF1AAIEFTdPVwMEgDoJAA==', '0', '1464809237', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001839', 'gQE/8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzRFTlByd0RsNDRTYU1uendxRzF1AAIE1TpPVwMEgDoJAA==', '0', '1464810195', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001840', 'gQH87zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3kwTURUdzNsbm9UbjlGY2g1RzF1AAIEKVBPVwMEgDoJAA==', '0', '1464815654', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001841', 'gQEq8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLy1FTWRjdURsZ0lUNUUyQWNfbTF1AAIENFVPVwMEgDoJAA==', '0', '1464816945', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001842', 'gQHu7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1pFTkpJTmJsMW9TdjctaE1ybTF1AAIEPlVPVwMEgDoJAA==', '0', '1464816957', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001843', 'gQEo8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2ZrTU14Q0xsam9UMzVlSzE2MjF1AAIERVVPVwMEgDoJAA==', '0', '1464816964', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001844', 'gQGp7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21rUHk3ZHpsYjRRVzFnYURGVzF1AAIERlVPVwMEgDoJAA==', '0', '1464816966', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001845', 'gQGy7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3BVTlA1bHJsMllTZ1pEbURxRzF1AAIESVVPVwMEgDoJAA==', '0', '1464816968', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001846', 'gQEt8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0FFTU4xMlBsbVlUZ3laeXc2bTF1AAIEymBPVwMEgDoJAA==', '0', '1464819911', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001847', 'gQFR7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3BFTldmb0hsem9TM0pqZ1ZzVzF1AAIEPmJPVwMEgDoJAA==', '0', '1464820284', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001848', 'gQGA7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzJrTWlvcWZsb0lUWm9rYlR4VzF1AAIE0mJPVwMEgDoJAA==', '0', '1464820433', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001849', 'gQF38DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2VVTWtOQVRsbzRUYU5PVkF3MjF1AAIErGVPVwMEgDoJAA==', '0', '1464821161', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001850', 'gQGG7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL09FTXNRX1RsdDRUTzRxUXJ5MjF1AAIEa2tPVwMEgDoJAA==', '0', '1464822633', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001851', 'gQEC8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3RrTWJKU2JsaDRUX3lDcEstRzF1AAIE3WxPVwMEgDoJAA==', '0', '1464823002', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001852', 'gQGF7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1IwTmtkWkhsX29TRDN0c1lnMjF1AAIEZXZPVwMEgDoJAA==', '0', '1464825441', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001853', 'gQFL7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2xFTjN2c2JsNElTWmtRamFrRzF1AAIEcXZPVwMEgDoJAA==', '0', '1464825456', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001854', 'gQHZ7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1gwTVZOaHZsazRUcUQ4TkQ4bTF1AAIETX5PVwMEgDoJAA==', '0', '1464827467', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001855', 'gQGZ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3RrTXQ5dUxsdW9URDN5cVN5bTF1AAIEiIVPVwMEgDoJAA==', '0', '1464829317', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001856', 'gQEl8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzlrTmkxN1BsNDRTYTcycWxoVzF1AAIEKZBPVwMEgDoJAA==', '0', '1464832037', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001857', 'gQGl8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2EwTVQ0c0hsbTRUaU5mZVo5RzF1AAIEXp1PVwMEgDoJAA==', '0', '1464835421', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001858', 'gQEq8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzFVTUFKUjdsZ29UN2swbFU1MjF1AAIEIrtPVwMEgDoJAA==', '0', '1464843040', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001859', 'gQGU8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21VTVlmUGZsbjRUbWJ3VUktMjF1AAIEAcBPVwMEgDoJAA==', '0', '1464844287', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001860', 'gQF08DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3pFTnREM2ZsNVlTY3lWQjBpbTF1AAIEJcBPVwMEgDoJAA==', '0', '1464844325', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001861', 'gQG78DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzhrTU80dTNsb0lUWmdHNi02VzF1AAIEeMBPVwMEgDoJAA==', '0', '1464844408', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001862', 'gQG/8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3JVTkliRy1sMDRTcTB6RUVyMjF1AAIEXcJPVwMEgDoJAA==', '0', '1464844890', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001863', 'gQEb8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2JFTkhmM2pseDRTX0Z2QU1vRzF1AAIEl8JPVwMEgDoJAA==', '0', '1464844951', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001864', 'gQFk8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzcwTWx4am5sbzRUYWJYT3p3bTF1AAIEvcJPVwMEgDoJAA==', '0', '1464844988', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001865', 'gQEm8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzhVUEx2ZURsWklRZDBXM2hMRzF1AAIE1cJPVwMEgDoJAA==', '0', '1464845013', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001866', 'gQGi8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2dFTndabmZsOG9TTDdCd1hsMjF1AAIE48JPVwMEgDoJAA==', '0', '1464845027', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001867', 'gQFw8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1JVTkg3WWZsMG9TclV0bUxvRzF1AAIEEMNPVwMEgDoJAA==', '0', '1464845071', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001868', 'gQHY8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0pVTi1rTWJsNTRTZURybjdtRzF1AAIEE8NPVwMEgDoJAA==', '0', '1464845075', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001869', 'gQHF7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3dFTWNLclhsdG9UUElseHpfMjF1AAIESsNPVwMEgDoJAA==', '0', '1464845129', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001870', 'gQH37zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1MwUFRiY2JsWG9Rbm5kY1RORzF1AAIEZsNPVwMEgDoJAA==', '0', '1464845156', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001871', 'gQFw8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzYwTVRmcDdsajRUMmRuY1I5RzF1AAIEoMNPVwMEgDoJAA==', '0', '1464845216', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001872', 'gQG/8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2tVUGR0T3ZsVDRRMnN3M1ZPbTF1AAIEqcNPVwMEgDoJAA==', '0', '1464845225', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001873', 'gQFM8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2ZrTVNwX2ZsbTRUaVFfTGQ5VzF1AAIEDsRPVwMEgDoJAA==', '0', '1464845325', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001874', 'gQHh8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0UwTl82NVRsMm9TakVZXzhtVzF1AAIENcRPVwMEgDoJAA==', '0', '1464845364', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001875', 'gQHk8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1UwTW4yQ0hsdFlUTTE4XzV3RzF1AAIERMRPVwMEgDoJAA==', '0', '1464845379', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001876', 'gQEZ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1cwTk94eGJsMW9Tdjk4ZXNxVzF1AAIERcRPVwMEgDoJAA==', '0', '1464845380', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001877', 'gQGu8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzBVUEVPdmpsVFlRMGJrMUFJMjF1AAIEb8RPVwMEgDoJAA==', '0', '1464845422', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001878', 'gQHn7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzNrTktwMWpseVlTd1hFTFhyVzF1AAIEf8RPVwMEgDoJAA==', '0', '1464845439', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001879', 'gQHN8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2MwTXRKQ1BsdVlUQUNlOUR5bTF1AAIE4sRPVwMEgDoJAA==', '0', '1464845537', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001880', 'gQHm8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2drTmtBOGZsODRTS094NW5nMjF1AAIE8cRPVwMEgDoJAA==', '0', '1464845552', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001881', 'gQEw8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0cwUEJKNi1sUm9RLTdvZFRKbTF1AAIEE8VPVwMEgDoJAA==', '0', '1464845587', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001882', 'gQHp8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2EwTU0zUnZsbW9UajBQZTQ2MjF1AAIEI8VPVwMEgDoJAA==', '0', '1464845603', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001883', 'gQGO8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2RrTUQ0dFhsaG9ULVBPcVU1RzF1AAIEJsVPVwMEgDoJAA==', '0', '1464845606', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001884', 'gQEs8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2RrUEhsYkRsVzRRaUx1cjZJRzF1AAIEasVPVwMEgDoJAA==', '0', '1464845672', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001885', 'gQFL8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2lVTTRiN0xsc0lUSktSVVUzMjF1AAIE2MVPVwMEgDoJAA==', '0', '1464845782', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001886', 'gQFm8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3QwTVN3WExsaklUMWVTdXM5VzF1AAIEH8ZPVwMEgDoJAA==', '0', '1464845855', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001887', 'gQF78DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2RVUG9KcFBsZFlRTXZlbElEMjF1AAIE7cdPVwMEgDoJAA==', '0', '1464846314', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001888', 'gQG68DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xrTUpMVExsaDRUX1RMSlE3bTF1AAIEJctPVwMEgDoJAA==', '0', '1464847140', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001889', 'gQGj8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3MwTk51UzNsMklTaFdpLWZxbTF1AAIE/89PVwMEgDoJAA==', '0', '1464848380', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001890', 'gQEG8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzcwTXV1MC1sdElUTlpuUFN5VzF1AAIEhfJPVwMEgDoJAA==', '0', '1464857218', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001891', 'gQHK7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL05rTWh6X2JsdllURVlxcWd4bTF1AAIEvfNPVwMEgDoJAA==', '0', '1464857531', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001892', 'gQGW8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2JFTVViZjdsbFlUc2d2QWY4MjF1AAIEx/NPVwMEgDoJAA==', '0', '1464857543', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001893', 'gQEm8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0MwTkJ3Y25seUlTeGZwZTdwbTF1AAIE0vNPVwMEgDoJAA==', '0', '1464857553', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001894', 'gQHM8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1VrTS1jR25scklUVk5zNFEyRzF1AAIE3fNPVwMEgDoJAA==', '0', '1464857564', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001895', 'gQFg8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzlrTkR1d0RsMVlTc01HcmVwRzF1AAIE5/NPVwMEgDoJAA==', '0', '1464857574', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001896', 'gQH27zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3VrTVZfaUxsbW9Uakh5YUc4bTF1AAIE5fhPVwMEgDoJAA==', '0', '1464858850', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001897', 'gQGl8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1ZFTThMSlBscklUVmxzaFAyMjF1AAIEDvlPVwMEgDoJAA==', '0', '1464858893', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001898', 'gQHS8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3VFTUFScDNsaW9UekhpUS01MjF1AAIExQFQVwMEgDoJAA==', '0', '1464861122', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001899', 'gQER8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3lrTTUzekxsc1lUSVdsYWszbTF1AAIEBwJQVwMEgDoJAA==', '0', '1464861189', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001900', 'gQG98DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzMwTWFILVhsa0lUcFNFTm0tVzF1AAIEHQpQVwMEgDoJAA==', '0', '1464863258', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001901', 'gQEB8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzFVTlBtMG5sMUlTdGVrbnpxRzF1AAIEIw1QVwMEgDoJAA==', '0', '1464864033', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001902', 'gQF78DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0NVTnpfekhsZ0lUNXZwWDdsRzF1AAIEkCRQVwMEgDoJAA==', '0', '1464870029', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001903', 'gQGB8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2tVTS1fRlBsazRUcVJ3Mm4yRzF1AAIE7yxQVwMEgDoJAA==', '0', '1464872171', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001904', 'gQHV7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2xVTXNzSW5sdTRUQzBRblV5MjF1AAIELjRQVwMEgDoJAA==', '0', '1464874028', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001905', 'gQHO7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3NrUGdtYTNsWVlRWV95N3JCMjF1AAIEIDxQVwMEgDoJAA==', '0', '1464876062', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001906', 'gQEg8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzYwUFBmUDdsWFlRa0ZIY2RLRzF1AAIEaz9QVwMEgDoJAA==', '0', '1464876903', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001907', 'gQEt8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzgwTldqeEhseElTOUVHLXVzVzF1AAIEJ0FQVwMEgDoJAA==', '0', '1464877348', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001908', 'gQHb7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3BrTngzQzdsLUlTRktUcWlsbTF1AAIEOk1QVwMEgDoJAA==', '0', '1464880440', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001909', 'gQFO7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3JrUDlCc3JsWW9RYkh6SnFHbTF1AAIEPU1QVwMEgDoJAA==', '0', '1464880444', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001910', 'gQHj7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0NrUF9EVm5sVVlRb0k1WlJHVzF1AAIERk1QVwMEgDoJAA==', '0', '1464880453', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001911', 'gQGI7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21FTU5sX2Zsa1lUb2xRVDQ2bTF1AAIET01QVwMEgDoJAA==', '0', '1464880463', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001912', 'gQF17zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1EwTlp5YjNsd0lTNVN0X2p2bTF1AAIEXU1QVwMEgDoJAA==', '0', '1464880477', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001913', 'gQGN7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3lFTTZLcG5scG9UZkJsUkYzVzF1AAIEZE1QVwMEgDoJAA==', '0', '1464880484', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001914', 'gQH08DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLy1VTlNxQVBsMzRTbUsySFd0VzF1AAIEmVFQVwMEgDoJAA==', '0', '1464881557', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001915', 'gQFh8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0pFUF9tTi1sZklRRkhyanBHVzF1AAIEu1dQVwMEgDoJAA==', '0', '1464883129', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001916', 'gQHg7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3RFUEJtZWJsUVlRNHRpanFKbTF1AAIEvVdQVwMEgDoJAA==', '0', '1464883130', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001917', 'gQEm8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21VUFBBRlBsVTRRcXR3VnZLRzF1AAIEx1dQVwMEgDoJAA==', '0', '1464883142', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001918', 'gQE28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2tVTTY4bm5sb1lUWVp3MmEzVzF1AAIEyldQVwMEgDoJAA==', '0', '1464883144', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001919', 'gQHv8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0MwTlk2LVhsM0lTbGFKZWN2MjF1AAIEmF9QVwMEgDoJAA==', '0', '1464885141', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001920', 'gQFr8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0RVTndvNEhsX29TRFVwSGFsMjF1AAIEiWNQVwMEgDoJAA==', '0', '1464886152', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001921', 'gQED8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2ZVTTRaX3JsdklURmplRVEzMjF1AAIEIGRQVwMEgDoJAA==', '0', '1464886302', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001922', 'gQEG8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3UwUHJIZ1RsYjRRVzNDZHBERzF1AAIEKmRQVwMEgDoJAA==', '0', '1464886314', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001923', 'gQHQ7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3NFUGJIb1BsZElRTlVDeENQRzF1AAIENmRQVwMEgDoJAA==', '0', '1464886326', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001924', 'gQEg7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3NFTWpjQVRsdm9USHVTd2V4RzF1AAIEQmRQVwMEgDoJAA==', '0', '1464886337', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001925', 'gQFn7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1RFTmZTWm5seTRTeTRkQXV1RzF1AAIEW2RQVwMEgDoJAA==', '0', '1464886362', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001926', 'gQFY7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BrTXpoZnpsdTRUQ09xTF8xRzF1AAIEaGRQVwMEgDoJAA==', '0', '1464886376', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001927', 'gQHo7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1FVTXoySjNsdDRUT2VkMnYxRzF1AAIEdWRQVwMEgDoJAA==', '0', '1464886388', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001928', 'gQGk8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzIwTlNEaGZsMzRTbXYwZHd0VzF1AAIEgWRQVwMEgDoJAA==', '0', '1464886400', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001929', 'gQFq7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0VrTjd5Z0RsNm9TVHBZNm9uRzF1AAIEeWZQVwMEgDoJAA==', '0', '1464886902', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001930', 'gQFH8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzBFTVZIOXZsa1lUb2FVeG84bTF1AAIEiGpQVwMEgDoJAA==', '0', '1464887943', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001931', 'gQGm8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1ZrUDhJYkhsYllRVXU4cERHMjF1AAIEimpQVwMEgDoJAA==', '0', '1464887945', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001932', 'gQG28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL00wTndMaUhsNTRTZVFhOUtsMjF1AAIEuW5QVwMEgDoJAA==', '0', '1464889014', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001933', 'gQHD7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzlVTnJDY2psOUlTTlNXbGxqRzF1AAIEKnBQVwMEgDoJAA==', '0', '1464889383', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001934', 'gQEr7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3NrTXQ0VXZsdFlUTVpTNkt5bTF1AAIEVnBQVwMEgDoJAA==', '0', '1464889429', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001935', 'gQEE8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xrTXZHMlBscjRUV0s3Sm95RzF1AAIEDXFQVwMEgDoJAA==', '0', '1464889613', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001936', 'gQH27zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3AwUFlRRG5sVFlRMG96c21QMjF1AAIE5HJQVwMEgDoJAA==', '0', '1464890081', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001937', 'gQGn8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0JrTVBOS0RsbklUbDc1cFU2RzF1AAIEq3NQVwMEgDoJAA==', '0', '1464890282', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001938', 'gQEk8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL01rUEMyMmZsVTRRcTg2NjVKVzF1AAIEnXZQVwMEgDoJAA==', '0', '1464891035', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001939', 'gQFd7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3IwUG96SzNsY1lRSXN6T21EMjF1AAIEbXlQVwMEgDoJAA==', '0', '1464891754', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001940', 'gQF07zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21VTU5vWXJsa0lUcHp3WFA2bTF1AAIE1nxQVwMEgDoJAA==', '0', '1464892627', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001941', 'gQEb8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1AwTi1ieG5sNm9TVE5LTUptRzF1AAIEBn1QVwMEgDoJAA==', '0', '1464892676', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001942', 'gQHy7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0dFTlFkdWJsMm9TajlZUVB0MjF1AAIEBX1QVwMEgDoJAA==', '0', '1464892676', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001943', 'gQHd7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL20wTkdrRzdsMllTZ0dBZjhvVzF1AAIEa31QVwMEgDoJAA==', '0', '1464892779', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001944', 'gQFg7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL19FTkhXZWpseFlTOE5HUW9vRzF1AAIEbX1QVwMEgDoJAA==', '0', '1464892779', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001945', 'gQHQ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3YwTUlXb0hsajRUMkdTTXU3MjF1AAIEkX1QVwMEgDoJAA==', '0', '1464892817', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001946', 'gQEY8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1MwTksyY25sMG9Tckp0ZXlyVzF1AAIElH1QVwMEgDoJAA==', '0', '1464892820', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001947', 'gQH/7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3hrUFdTZGpsVjRRdUtsbzdNVzF1AAIEmX1QVwMEgDoJAA==', '0', '1464892825', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001948', 'gQFG8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2pVTWVPdi1saFlUOE5SRlNfVzF1AAIEr31QVwMEgDoJAA==', '0', '1464892846', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001949', 'gQHu7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2IwUFhmdkhsVzRRaW5mTUJNRzF1AAIEC35QVwMEgDoJAA==', '0', '1464892938', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001950', 'gQEs8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzQwTUdKZDNsbm9UblpuOU80VzF1AAIEFH5QVwMEgDoJAA==', '0', '1464892947', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001951', 'gQFP8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0swTXllc1BsdzRTNjc3ZDQxVzF1AAIEGX5QVwMEgDoJAA==', '0', '1464892953', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001952', 'gQGu7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0FrUHdqcVBsYUlRUlVwN2xGMjF1AAIEGn5QVwMEgDoJAA==', '0', '1464892953', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001953', 'gQGw7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2pVTXE2cFhscFlUY2p4R1d6VzF1AAIEl35QVwMEgDoJAA==', '0', '1464893076', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001954', 'gQGa8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0IwTWszNi1scklUVkNwdWt3MjF1AAIEmH5QVwMEgDoJAA==', '0', '1464893080', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001955', 'gQFh8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2ZVUGo3TUxsRTRScUx1SHZCRzF1AAIEqX5QVwMEgDoJAA==', '0', '1464893097', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001956', 'gQH57zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzYwTjV4U3JsNW9TZmVYZXBubTF1AAIEqn5QVwMEgDoJAA==', '0', '1464893098', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001957', 'gQHn7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzlVTldTWVhseUlTeFJHa2tzVzF1AAIEr35QVwMEgDoJAA==', '0', '1464893103', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001958', 'gQEW8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BFTkhzZXJseFlTOEdxREFvRzF1AAIEuX5QVwMEgDoJAA==', '0', '1464893113', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001959', 'gQGJ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BFUHdENGpsZDRRT3hxQjdGMjF1AAIEun5QVwMEgDoJAA==', '0', '1464893114', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001960', 'gQH67zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3RrTU12Q3Zsam9UM1hDck42MjF1AAIEzn5QVwMEgDoJAA==', '0', '1464893134', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001961', 'gQEs8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL08wTl9taDNsMDRTcXdhZkVtVzF1AAIEw39QVwMEgDoJAA==', '0', '1464893378', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001962', 'gQGl8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzgwTjJFMC1sNElTWjBtOTJrVzF1AAIEbYFQVwMEgDoJAA==', '0', '1464893802', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001963', 'gQGX8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1FVTlJSeVBsMElTcFdOMDF0bTF1AAIEdYFQVwMEgDoJAA==', '0', '1464893813', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001964', 'gQE18DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21VTkxwQ0hseTRTeVlRWFhyRzF1AAIEeIFQVwMEgDoJAA==', '0', '1464893816', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001965', 'gQFa8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL28wTlRObmJsejRTMm5qOVp0RzF1AAIEfoFQVwMEgDoJAA==', '0', '1464893822', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001966', 'gQHA8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0MwTUpfX0xsZ0lUNWI1ZUI3bTF1AAIEoYFQVwMEgDoJAA==', '0', '1464893856', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001967', 'gQFC8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzVVTmNFMkxseUlTeDZYbDB1MjF1AAIE8oFQVwMEgDoJAA==', '0', '1464893938', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001968', 'gQE88ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1JFTXdxMkRscTRUUzh0akQxMjF1AAIECIJQVwMEgDoJAA==', '0', '1464893960', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001969', 'gQFA8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0VVTlVGNnpseUlTeDE0MTRzMjF1AAIEIIJQVwMEgDoJAA==', '0', '1464893984', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001970', 'gQEy8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzhFTjZmSHJsNUlTZGkyd1JuVzF1AAIE3oJQVwMEgDoJAA==', '0', '1464894171', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001971', 'gQGA8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BrTWJaVnZsbVlUZ2ZhSVUtRzF1AAIEJINQVwMEgDoJAA==', '0', '1464894243', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001972', 'gQF88DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzhFTUpGeG5sa1lUb2cyeDg3bTF1AAIEXoNQVwMEgDoJAA==', '0', '1464894300', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001973', 'gQFV8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2NFTXBIcmJsdUlUQnBleDh6bTF1AAIE_INQVwMEgDoJAA==', '0', '1464894454', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001974', 'gQEx8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3ZFTnZkN2JsNzRTV0FDQUVpRzF1AAIEEYRQVwMEgDoJAA==', '0', '1464894480', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001975', 'gQH28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1EwUFctSERsZVlRQXN0X2dNVzF1AAIEFYRQVwMEgDoJAA==', '0', '1464894485', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001976', 'gQFB8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3RVTjlGdUhsNVlTY1B5bDltbTF1AAIEbYRQVwMEgDoJAA==', '0', '1464894572', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001977', 'gQGy8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3NrTUJLN0RsbllUa1ZDNUU1bTF1AAIEbYRQVwMEgDoJAA==', '0', '1464894573', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001978', 'gQHc8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0VFTURVeTNsbVlUZ0U0dzY1RzF1AAIEcoRQVwMEgDoJAA==', '0', '1464894576', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001979', 'gQFE8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1NrTlFQb2Jsb0lUWmo5WTl0MjF1AAIEioRQVwMEgDoJAA==', '0', '1464894601', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001980', 'gQGW8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2QwTUc2WjdsaklUMWZldVE0VzF1AAIEtIRQVwMEgDoJAA==', '0', '1464894641', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001981', 'gQF88ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLy0wTjdOM1BsX29TRHhtTkZuRzF1AAIEy4RQVwMEgDoJAA==', '0', '1464894666', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001982', 'gQH18DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL05FTXlEaERscm9UWFY2aGgxVzF1AAIE3oRQVwMEgDoJAA==', '0', '1464894686', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001983', 'gQER8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2JFTUJ3NGpsaTRUeVd2QzY1bTF1AAIE34RQVwMEgDoJAA==', '0', '1464894687', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001984', 'gQGG8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1RrUF92LXJsYVlRUWR0TGJHVzF1AAIEA4VQVwMEgDoJAA==', '0', '1464894722', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001985', 'gQGW8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3dVTmdodnpsNFlTWXhsMzBoMjF1AAIEA4VQVwMEgDoJAA==', '0', '1464894723', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001986', 'gQFh8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2NrTnZ0cnZsLW9TSEF1N1VpRzF1AAIEFIVQVwMEgDoJAA==', '0', '1464894737', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001987', 'gQGl8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL19FTVJtVFhsbjRUbUtXVGs5bTF1AAIEIYVQVwMEgDoJAA==', '0', '1464894753', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001988', 'gQFq8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0JVTkNWbXJsd1lTNFJKa21wVzF1AAIEM4VQVwMEgDoJAA==', '0', '1464894771', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001989', 'gQGQ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0xrTWVZQ3ZsZ29UN0dMSVBfVzF1AAIEPoVQVwMEgDoJAA==', '0', '1464894782', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001990', 'gQE18DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3EwTldaMzdsMW9Tdnp6Y1VzVzF1AAIEboVQVwMEgDoJAA==', '0', '1464894830', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001991', 'gQGx8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0YwUEZyRFhsVVlRbzg0dkxJbTF1AAIEb4VQVwMEgDoJAA==', '0', '1464894831', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001992', 'gQGL8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0dVTjAxRExsOTRTT2dvV2trMjF1AAIE4oVQVwMEgDoJAA==', '0', '1464894944', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001993', 'gQGG8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3hVUE9hSkRsWTRRYVFGazJLVzF1AAIElYZQVwMEgDoJAA==', '0', '1464895124', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001994', 'gQE78ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1BFTnNGM2psNzRTV0xxQm5pMjF1AAIE_oZQVwMEgDoJAA==', '0', '1464895225', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001995', 'gQHe8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3BrTUp2VS1sallUMEtUcks3bTF1AAIE/IZQVwMEgDoJAA==', '0', '1464895227', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001996', 'gQFF8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1AwTXRseWZsc29UTDhxUDd5bTF1AAIEIYdQVwMEgDoJAA==', '0', '1464895263', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001997', 'gQHG8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzRVTmNRVFRsem9TMzZYMGd1MjF1AAIEVodQVwMEgDoJAA==', '0', '1464895318', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001998', 'gQG_8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2owUDB3enZsY0lRSkNoTzBFMjF1AAIEY4dQVwMEgDoJAA==', '0', '1464895331', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400001999', 'gQEG8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0hVTmJmUnJseklTMUI0RVp2RzF1AAIE9IdQVwMEgDoJAA==', '0', '1464895474', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002000', 'gQGz8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0FrUFZpeHpsVllRczZKNzRNbTF1AAIEBZRQVwMEgDoJAA==', '0', '1464898562', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002001', 'gQG28ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1drTUFUN1BsajRUMjI4WXo1MjF1AAIEzJxQVwMEgDoJAA==', '0', '1464900810', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002002', 'gQGn8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzZrTXF5ZEhscllUVWozYTl6VzF1AAIEzpxQVwMEgDoJAA==', '0', '1464900813', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002003', 'gQGi8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0pFTl9EenZsNFlTWWJiaGptVzF1AAIE0JxQVwMEgDoJAA==', '0', '1464900815', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002004', 'gQET8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0JFTllhQnpsMUlTdERaZ1h2MjF1AAIE0ZxQVwMEgDoJAA==', '0', '1464900817', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002005', 'gQFU8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL19FTXVOeWZsdFlUTWxXUmZ5VzF1AAIE1ZxQVwMEgDoJAA==', '0', '1464900821', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002006', 'gQFT8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2tVUEpodFhsVVlRb3Z3M3RMbTF1AAIE2ZxQVwMEgDoJAA==', '0', '1464900825', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002007', 'gQGL8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3VFTmNRZWJseFlTOFlpUXJ1MjF1AAIE35xQVwMEgDoJAA==', '0', '1464900831', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002008', 'gQEr8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1owTVRqNnJsbElUdFAtdjc5RzF1AAIE5pxQVwMEgDoJAA==', '0', '1464900838', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002009', 'gQEp8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3kwTjNTX0RsLUlTRkhWY3prRzF1AAIE8JxQVwMEgDoJAA==', '0', '1464900848', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002010', 'gQEh8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1MwTUhVUWpsaG9ULWI5Y2o0RzF1AAIE8ZxQVwMEgDoJAA==', '0', '1464900849', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002011', 'gQF08DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzVrTk9pYXJsMDRTcXVIcm5xVzF1AAIE_5xQVwMEgDoJAA==', '0', '1464900859', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002012', 'gQFE8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzRVTUkzdVBsbVlUZ29YMjg3MjF1AAIE/5xQVwMEgDoJAA==', '0', '1464900862', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002013', 'gQHK8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2hrTTFVYWpscjRUV0FobzQwbTF1AAIE_6FQVwMEgDoJAA==', '0', '1464902136', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002014', 'gQFF8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2JrTW9HeVBscjRUV0stSnZ6MjF1AAIEVqhQVwMEgDoJAA==', '0', '1464903763', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002015', 'gQHs7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0dVTXptZHZsc29UTEpvWHIxRzF1AAIEVqhQVwMEgDoJAA==', '0', '1464903765', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002016', 'gQGs8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL29FTkVETERsM0lTbFlUeG5vMjF1AAIEKbJQVwMEgDoJAA==', '0', '1464906277', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002017', 'gQHb8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzRVUEM4QnZsUTRRNmQzMkNKVzF1AAIEvrNQVwMEgDoJAA==', '0', '1464906684', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002018', 'gQEv8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3JVTU5WRVRsajRUMndERWw2bTF1AAIEqrRQVwMEgDoJAA==', '0', '1464906920', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002019', 'gQFr8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1FrTUdLVEhsbFlUc0o5NUo0VzF1AAIEnrhQVwMEgDoJAA==', '0', '1464907931', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002020', 'gQHt8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1EwTTBKYXpscklUVnQ5OU8wMjF1AAIEQcRQVwMEgDoJAA==', '0', '1464910910', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002021', 'gQH/8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzMwTVFYUURsNElTWi0wTmU5MjF1AAIEuMdQVwMEgDoJAA==', '0', '1464911797', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002022', 'gQFg8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2JFUC1BQVRsZW9RREZmQjJHRzF1AAIE18lQVwMEgDoJAA==', '0', '1464912339', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002023', 'gQHk8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1QwUDAtWC1sZG9RUHNOT01FMjF1AAIEYs1QVwMEgDoJAA==', '0', '1464913249', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002024', 'gQFd8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzJVTU9POHJsbUlUaFZVVmU2VzF1AAIEZs1QVwMEgDoJAA==', '0', '1464913254', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002025', 'gQH37zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3kwUGNieC1sU0lReHhsY0lPMjF1AAIEdM1QVwMEgDoJAA==', '0', '1464913267', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002026', 'gQF18ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzZVUEl5cFhsVFlRMHkzVzhMMjF1AAIEg81QVwMEgDoJAA==', '0', '1464913283', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002027', 'gQE/8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzcwTVJ3WEhsbElUdEluTzM5bTF1AAIEjM1QVwMEgDoJAA==', '0', '1464913292', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002028', 'gQF68ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0QwTklyNFhseElTOVdKUFFyMjF1AAIEjc5QVwMEgDoJAA==', '0', '1464913547', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002029', 'gQGN8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1cwUEpwbm5sVjRRdV9jZkxMbTF1AAIEx9NQVwMEgDoJAA==', '0', '1464914885', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002030', 'gQHI8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3YwTWMwVmZsbW9UalJDT2tfMjF1AAIEsdxQVwMEgDoJAA==', '0', '1464917166', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002031', 'gQE78DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0lFTWlWRDNsb0lUWk5Md2x4VzF1AAIENt1QVwMEgDoJAA==', '0', '1464917302', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002032', 'gQH37zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0NVUEVobHZsUVlRNHFaWHdJMjF1AAIEe_RQVwMEgDoJAA==', '0', '1464919160', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002033', 'gQFr8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1lFTjRnMHZsNVlTYzFmenRuMjF1AAIEAA9RVwMEgDoJAA==', '0', '1464930046', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002034', 'gQFW8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0IwTjgxTTdsNVlTY1lKdV9tMjF1AAIEoxBRVwMEgDoJAA==', '0', '1464930464', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002035', 'gQEt8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzEwTVdORW5sallUMDEwdGM4VzF1AAIEvxBRVwMEgDoJAA==', '0', '1464930495', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002036', 'gQH_7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0VVTUlRckRsbFlUc25vMHM3MjF1AAIEVRFRVwMEgDoJAA==', '0', '1464930643', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002037', 'gQFg7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1drTWtGYXZsb1lUWW1jWmp3MjF1AAIEVhFRVwMEgDoJAA==', '0', '1464930645', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002038', 'gQGL8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL21FTWZUYXZsajRUMkF3UXVfRzF1AAIEmhNRVwMEgDoJAA==', '0', '1464931223', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002039', 'gQF08DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1ZVUHZwVkRsZUlRQjNjbkJDRzF1AAIE_RdRVwMEgDoJAA==', '0', '1464932344', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002040', 'gQEL8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL20wUHFxUnZsZG9RUFZBZkdEVzF1AAIEARpRVwMEgDoJAA==', '0', '1464932862', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002041', 'gQHY8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2swTlUyUVRsX0lTQk13X0dzMjF1AAIEvBtRVwMEgDoJAA==', '0', '1464933305', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002042', 'gQHA8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzcwTXNUUExscFlUY0xITTJ5MjF1AAIE3h1RVwMEgDoJAA==', '0', '1464933853', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002043', 'gQG78DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0cwUDU3S3ZsWVlRWUlZZUhIbTF1AAIE5B1RVwMEgDoJAA==', '0', '1464933860', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002044', 'gQEJ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0UwUGw4Z1hsYzRRS21ZX1hBbTF1AAIEYCFRVwMEgDoJAA==', '0', '1464934751', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002045', 'gQG98DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzYwTVdzSTdsaVlUd3FIZmM4VzF1AAIElyFRVwMEgDoJAA==', '0', '1464934807', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002046', 'gQHF8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2lVTjdyaDdsN1lTVVJCWExuRzF1AAIEsSFRVwMEgDoJAA==', '0', '1464934832', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002047', 'gQGQ7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1JVTlh3a1RsMVlTc3Z0bXpzRzF1AAIE/CZRVwMEgDoJAA==', '0', '1464936185', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002048', 'gQE38DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL05FTnpRRGZsOW9TUFBxZzJsRzF1AAIEBCdRVwMEgDoJAA==', '0', '1464936195', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002049', 'gQEY8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0tFTll0eW5sMllTZ3k3VEZ2MjF1AAIECCdRVwMEgDoJAA==', '0', '1464936200', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002050', 'gQHf7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2dVTXdtZFRscG9UZnNSMzgxMjF1AAIEOSdRVwMEgDoJAA==', '0', '1464936249', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002051', 'gQFZ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0JFUFhXMlRsUzRReVJwZzBNRzF1AAIERShRVwMEgDoJAA==', '0', '1464936515', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002052', 'gQHt8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3dVUHJyYkxsUUlRNW8xMzFERzF1AAIEnihRVwMEgDoJAA==', '0', '1464936605', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002053', 'gQGr8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3UwTjdnSmpsNVlTYzNpZnRuRzF1AAIEhypRVwMEgDoJAA==', '0', '1464937094', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002054', 'gQEq8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0wwTkdkalBsdzRTNkY3TUFvVzF1AAIEiCpRVwMEgDoJAA==', '0', '1464937095', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002055', 'gQGg8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL18wTkFWaEhseDRTX3dXY2lwMjF1AAIEiCpRVwMEgDoJAA==', '0', '1464937096', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002056', 'gQFQ8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL19rTll5bkxsMUlTdFAyYTF2MjF1AAIE7zBRVwMEgDoJAA==', '0', '1464938732', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002057', 'gQEx8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3pVTVctcERsbVlUZzNsR0M4VzF1AAIEGjhRVwMEgDoJAA==', '0', '1464940567', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002058', 'gQEE8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1lrTmE4MW5sdzRTNnRmNlp2VzF1AAIEHzhRVwMEgDoJAA==', '0', '1464940574', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002059', 'gQHz7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2YwTVloRVBsbllUa3hlUHktMjF1AAIEIThRVwMEgDoJAA==', '0', '1464940576', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002060', 'gQEa8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1VVTVBBU25sbG9UdkJNMXI2RzF1AAIEIThRVwMEgDoJAA==', '0', '1464940576', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002061', 'gQGw8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzIwTUFYT0RsallUMEdrY2k1MjF1AAIEIThRVwMEgDoJAA==', '0', '1464940576', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002062', 'gQFp8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2FVUE9DRFBsUzRReUwtVl9LVzF1AAIEIjhRVwMEgDoJAA==', '0', '1464940578', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002063', 'gQGu7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0wwTWl6aW5sbzRUYXRiTzh4VzF1AAIEIzhRVwMEgDoJAA==', '0', '1464940578', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002064', 'gQGd7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3VFUGh6OG5sWVlRWXd5UzhCbTF1AAIEIzhRVwMEgDoJAA==', '0', '1464940578', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002065', 'gQER8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0wwTllkYmpsMklTaG43TUd2MjF1AAIEXThRVwMEgDoJAA==', '0', '1464940637', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002066', 'gQGT8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzVVUHZiRzNsYjRRV21Ya2ZDRzF1AAIEuzhRVwMEgDoJAA==', '0', '1464940731', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002067', 'gQFD8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3hVTk02OW5sMG9TcmlsbUdxMjF1AAIEuz1RVwMEgDoJAA==', '0', '1464942008', null, '', '', '');
INSERT INTO `pigcms_location_qrcode` VALUES ('400002068', 'gQFi8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzFVUGxDUDdsYjRRV1hrbHhBbTF1AAIE0D9RVwMEgDoJAA==', '0', '1464942543', null, '', '', '');

-- ----------------------------
-- Table structure for `pigcms_login_qrcode`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_login_qrcode`;
CREATE TABLE `pigcms_login_qrcode` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket` varchar(500) NOT NULL,
  `uid` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  `phone` int(11) DEFAULT NULL COMMENT '注册手机号',
  `other_info` varchar(250) DEFAULT NULL COMMENT '注册的其他信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100000003 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='使用微信登录生成的临时二维码';

-- ----------------------------
-- Records of pigcms_login_qrcode
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_lottery`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_lottery`;
CREATE TABLE `pigcms_lottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '门店id',
  `anwei` int(11) NOT NULL COMMENT '安慰奖(一等奖、二等奖...)',
  `title` varchar(60) NOT NULL COMMENT '活动名称',
  `win_info` varchar(60) NOT NULL COMMENT '兑奖信息',
  `win_tip` varchar(60) NOT NULL COMMENT '中奖提示',
  `starttime` int(11) NOT NULL COMMENT '活动开始时间',
  `endtime` int(11) NOT NULL COMMENT '活动结束时间',
  `active_desc` varchar(200) NOT NULL COMMENT '活动说明',
  `endtitle` varchar(50) NOT NULL COMMENT '活动结束提示语',
  `rejoin_tip` varchar(200) NOT NULL COMMENT '重复参与提示',
  `backgroundThumImage` varchar(255) NOT NULL COMMENT '活动模块背景图片',
  `fill_type` tinyint(1) NOT NULL COMMENT '背景图填充类型 1平铺0填充',
  `isshow_num` tinyint(1) NOT NULL COMMENT '是否显示奖品数量1显示0不显示',
  `win_limit` tinyint(1) NOT NULL COMMENT '抽奖限制 0不限制1每日限制3积分限制',
  `win_limit_extend` int(11) NOT NULL,
  `win_limit_share_extend` tinyint(3) NOT NULL COMMENT '分享多少次增加一次抽奖机会（当抽奖限制设置为每日限制时）',
  `need_subscribe` tinyint(1) NOT NULL COMMENT '需要用户关注参与1需要0不需要',
  `win_type` tinyint(1) NOT NULL COMMENT '每人中奖次数类型 0总次数1每日次数',
  `win_type_extend` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '游戏类型 1大转盘2九宫格3刮刮卡4水果机5砸金蛋0未知',
  `password` varchar(15) NOT NULL COMMENT '兑奖密码',
  `createtime` int(11) NOT NULL,
  `status` int(1) NOT NULL COMMENT '0正常，1已失效，2已结束，3已删除',
  `PV` int(11) NOT NULL COMMENT '活动总pv',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_lottery
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_lottery_prize`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_lottery_prize`;
CREATE TABLE `pigcms_lottery_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lottery_id` int(11) NOT NULL COMMENT '活动id',
  `prize_type` tinyint(1) NOT NULL COMMENT '奖项类型（一等奖，二等奖...）',
  `prize` tinyint(1) NOT NULL COMMENT '奖品类型（1商品2优惠券3店铺积分4其他）',
  `product_id` int(11) NOT NULL COMMENT '商品id(奖品类型为商品时)',
  `sku_id` int(11) NOT NULL COMMENT '商品sku_id(奖品类型为商品时)',
  `product_name` varchar(50) NOT NULL COMMENT '商品名称（奖品类型为商品时）',
  `coupon` int(11) NOT NULL COMMENT '优惠券id(奖品类型为优惠券时)',
  `product_recharge` int(11) NOT NULL COMMENT '店铺积分（奖品类型为店铺积分时）',
  `product_num` int(11) NOT NULL COMMENT '奖品数量',
  `rates` int(11) NOT NULL COMMENT '中奖率',
  PRIMARY KEY (`id`),
  KEY `lottery_id` (`lottery_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='抽奖活动奖项表';

-- ----------------------------
-- Records of pigcms_lottery_prize
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_lottery_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_lottery_record`;
CREATE TABLE `pigcms_lottery_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `active_id` int(11) NOT NULL COMMENT '活动id',
  `prize_id` int(11) NOT NULL COMMENT '奖项id',
  `type` tinyint(1) NOT NULL COMMENT '活动类型，1大转盘2九宫格3刮刮卡4水果机5砸金蛋',
  `dateline` int(11) NOT NULL COMMENT '抽奖时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '兑奖状态 0未兑奖 1已兑奖',
  `order_id` int(11) NOT NULL COMMENT '商品订单ID',
  `prize_time` int(11) NOT NULL COMMENT '兑奖时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `active_id` (`active_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='中奖记录';

-- ----------------------------
-- Records of pigcms_lottery_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_lottery_shared`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_lottery_shared`;
CREATE TABLE `pigcms_lottery_shared` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_uid` int(11) NOT NULL COMMENT '分享者用户ID',
  `to_uid` int(11) NOT NULL COMMENT '被分享者用户ID',
  `active_id` int(11) NOT NULL COMMENT '活动ID',
  `dateline` int(11) NOT NULL COMMENT '分享时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已生效，0未生效1已生效',
  PRIMARY KEY (`id`),
  KEY `active_id` (`active_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_lottery_shared
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_lottery_share_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_lottery_share_setting`;
CREATE TABLE `pigcms_lottery_share_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `active_id` int(11) NOT NULL COMMENT '活动id',
  `num` int(4) NOT NULL COMMENT '剩余抽奖次数',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `active_id` (`active_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户抽奖分享设置';

-- ----------------------------
-- Records of pigcms_lottery_share_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_margin_account`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_margin_account`;
CREATE TABLE `pigcms_margin_account` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) unsigned NOT NULL COMMENT '商家店铺id',
  `bank_id` int(11) unsigned NOT NULL COMMENT '开户银行',
  `bank_card` varchar(30) NOT NULL COMMENT '银行卡号',
  `bank_card_user` varchar(30) NOT NULL COMMENT '开卡人姓名',
  `opening_bank` varchar(255) NOT NULL COMMENT '开户行',
  `add_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_margin_account
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_margin_recharge_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_margin_recharge_log`;
CREATE TABLE `pigcms_margin_recharge_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '充值记录id',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '收款方店铺id',
  `distributor_id` int(11) NOT NULL DEFAULT '0' COMMENT '打款方店铺id',
  `bank_id` int(11) NOT NULL DEFAULT '0' COMMENT '开户银行',
  `bank_card` varchar(30) NOT NULL DEFAULT '0' COMMENT '银行卡号',
  `bank_card_user` varchar(20) NOT NULL DEFAULT '0' COMMENT '开卡人姓名',
  `opening_bank` varchar(30) NOT NULL DEFAULT '0' COMMENT '开户行',
  `phone` varchar(20) NOT NULL DEFAULT '0' COMMENT '打款人手机号',
  `apply_recharge` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值额度',
  `add_time` varchar(30) NOT NULL DEFAULT '0' COMMENT '充值时间',
  `status` tinyint(5) NOT NULL DEFAULT '0' COMMENT '0 未确认 1 已确认',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_margin_recharge_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_meal`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal`;
CREATE TABLE `pigcms_meal` (
  `meal_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1为开启',
  `sell_mouth` int(10) unsigned NOT NULL COMMENT '月份',
  PRIMARY KEY (`meal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=246 DEFAULT CHARSET=utf8 COMMENT='订餐商品表';

-- ----------------------------
-- Records of pigcms_meal
-- ----------------------------
INSERT INTO `pigcms_meal` VALUES ('239', '18', '64', '串串香', '份', '特价', '28.00', '10.00', '10.00', '53/000/000/068,55a61e2c78535.jpg', '好吃不贵', '1436950060', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('240', '18', '62', '羊肉', '份', '促销', '45.00', '36.00', '0.00', '51/000/000/068,55a621930782b.jpg', '羊肉一份', '1436950930', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('241', '18', '61', '鸡肉', '份', '特价', '20.00', '15.00', '0.00', '90/000/000/068,55a621f6509c4.jpg', '一份', '1436951030', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('242', '18', '60', '演示', '份', '特价', '5.00', '10.00', '0.00', '38/000/000/068,55a622ec3f12f.jpg', '测试', '1436951276', '0', '6', '1', '201509');
INSERT INTO `pigcms_meal` VALUES ('243', '18', '65', '麻辣新语', '份', '招牌', '108.00', '68.00', '0.00', '56/000/000/068,55a625cbd871d.jpg', '麻辣新语成立', '1436952011', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('244', '18', '66', '门票', '个', '特价', '130.00', '18.00', '0.00', '80/000/000/068,55a6288ec9ca1.jpg', '中原影视城', '1436952718', '0', '0', '1', '0');
INSERT INTO `pigcms_meal` VALUES ('245', '18', '67', '门票', '个', '特价', '230.00', '200.00', '0.00', '62/000/000/068,55a629024ca05.jpg', '方特一日游', '1436952834', '0', '0', '1', '0');

-- ----------------------------
-- Table structure for `pigcms_meal_cz`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_cz`;
CREATE TABLE `pigcms_meal_cz` (
  `cz_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `physical_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `wz_id` int(10) unsigned DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `zno` varchar(255) DEFAULT NULL,
  `seller_id` varchar(20) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `status` varchar(60) DEFAULT NULL,
  `description` text,
  `image2` text,
  `image3` text,
  `add_time` text,
  `images` text,
  PRIMARY KEY (`cz_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_meal_cz
-- ----------------------------
INSERT INTO `pigcms_meal_cz` VALUES ('7', '1', '茶马古道', '4', 'data/files/store_2/chaguan/chaguan_image_1_1441504397.jpg', '12', '37', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441504397.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504397.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('8', '1', '开封古都', '4', 'data/files/store_2/chaguan/chaguan_image_1_1441504373.jpg', '12', '37', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441504373.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504373.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('9', '1', '南京古韵', '4', 'data/files/store_2/chaguan/chaguan_image_1_1441504338.jpg', '12', '37', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441504338.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504338.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('10', '1', '夜上海', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441504300.jpg', '12', '37', '300', '1', '夜上海', 'data/files/store_2/chaguan/chaguan_image_2_1441504300.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504300.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('5', '1', '甘趣', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501963.jpg', '12', '37', '300', '1', '甘趣甘趣', 'data/files/store_2/chaguan/chaguan_image_2_1441501963.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501963.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('6', '1', '北京时间', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441504420.jpg', '10', '37', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441504420.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504420.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('34', '1', '哇哈', '1', null, '6', '18', '500', '1', '阿萨德发', null, null, '1464860665', null);
INSERT INTO `pigcms_meal_cz` VALUES ('17', '1', '莲花厅', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441504089.jpg', '32', '18', '300', '1', '幽香', 'data/files/store_2/chaguan/chaguan_image_2_1441504089.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504089.jpg', '1464858007', null);
INSERT INTO `pigcms_meal_cz` VALUES ('18', '1', '南秀', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501221.jpg', '12', '2', '300', '1', '南秀', 'data/files/store_2/chaguan/chaguan_image_2_1441501221.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501221.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('29', '1', '西安唐貌', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441504135.jpg', '12', '2', '300', '1', '西安唐貌', 'data/files/store_2/chaguan/chaguan_image_2_1441504135.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441504135.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('20', '1', '兰芷', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501536.jpg', '12', '2', '300', '1', '兰芷', 'data/files/store_2/chaguan/chaguan_image_2_1441501536.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501536.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('21', '1', '甘霖', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501836.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501836.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501836.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('22', '1', '清香', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501593.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501593.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501593.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('23', '1', '秋鸿', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501628.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501628.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501628.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('24', '1', '瑞草', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501661.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501661.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501661.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('25', '1', '山岚', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501697.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501697.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501697.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('26', '1', '天乐', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501728.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501728.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501728.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('27', '1', '怡悦', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441501754.jpg', '12', '2', '300', '1', '', 'data/files/store_2/chaguan/chaguan_image_2_1441501754.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441501754.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('28', '1', '酽香', '2', 'data/files/store_2/chaguan/chaguan_image_1_1441503445.jpg', '12', '2', '300', '1', '酽香', 'data/files/store_2/chaguan/chaguan_image_2_1441503445.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441503445.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('30', '1', '大厅', '1', 'data/files/store_2/chaguan/chaguan_image_1_1441595086.jpg', '50', '2', '300', '1', '大厅', 'data/files/store_2/chaguan/chaguan_image_2_1441595086.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441595086.jpg', null, null);
INSERT INTO `pigcms_meal_cz` VALUES ('32', '1', '大厅', '1', 'data/files/store_2/chaguan/chaguan_image_1_1441505892.jpg', '50', '2', '300', '1', '大厅', 'data/files/store_2/chaguan/chaguan_image_2_1441505892.jpg', 'data/files/store_2/chaguan/chaguan_image_3_1441505892.jpg', null, null);

-- ----------------------------
-- Table structure for `pigcms_meal_like`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_like`;
CREATE TABLE `pigcms_meal_like` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `mer_id` int(10) unsigned NOT NULL,
  `store_id` int(10) unsigned NOT NULL,
  `meal_ids` text NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `uid` (`uid`,`mer_id`,`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_meal_like
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_meal_order`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_order`;
CREATE TABLE `pigcms_meal_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL COMMENT '用户id',
  `physical_id` int(10) unsigned DEFAULT NULL COMMENT '店铺ID',
  `store_uid` int(10) unsigned DEFAULT NULL COMMENT '操作店员ID',
  `orderid` varchar(22) DEFAULT NULL COMMENT '订单号',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '订单状态（0:未使用，1:已使用，2:已评价，3：已删除）',
  `name` varchar(20) DEFAULT NULL COMMENT '点单人姓名',
  `phone` varchar(15) DEFAULT NULL COMMENT '电话',
  `tableid` text COMMENT '桌台号',
  `dateline` int(10) unsigned DEFAULT NULL COMMENT '下单时间',
  `use_time` int(10) unsigned DEFAULT NULL COMMENT '消费时间',
  `dd_time` text,
  `sc` text,
  `bz` text,
  PRIMARY KEY (`order_id`),
  KEY `store_id` (`physical_id`,`orderid`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COMMENT='餐饮订单表';

-- ----------------------------
-- Records of pigcms_meal_order
-- ----------------------------
INSERT INTO `pigcms_meal_order` VALUES ('116', '619', '1', '0', '6860201507152347124438', '0', '112121', '212121', '0', '1436975232', '0', '0', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('119', '633', '1', '0', '2015090520101300000633', '0', '王李海霞', '13625656565', '0', '1441455013', '0', '1441462626', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('135', '76', '1', '37', '20150917100444000076', '4', '小憩二刻', '13628883553', '9', '1442455484', '1442461980', '2015-09-17 10:04:37', '3', '阿法士大夫');
INSERT INTO `pigcms_meal_order` VALUES ('121', '639', '1', '0', '2015090609134100000639', '2', '哦哦', '13812345678', '5', '1441502021', '0', '1441502026', '2', null);
INSERT INTO `pigcms_meal_order` VALUES ('122', '633', '1', '0', '2015090612310800000633', '4', '王', '13656565656', '6', '1441513868', '1442391141', '1441513873', '2', '打发士大夫大发');
INSERT INTO `pigcms_meal_order` VALUES ('123', '76', '1', '37', '2015090612342900000626', '3', '饭否', '13252254521', '7', '1441514069', '1442391115', '1441514091', '1', '噶发发都是');
INSERT INTO `pigcms_meal_order` VALUES ('125', null, '1', null, '20150916174109000076', null, null, null, null, '1442396469', null, null, null, null);
INSERT INTO `pigcms_meal_order` VALUES ('134', null, '1', '76', '20150916175933000076', '1', '精品蔬菜', '13628883553', '17', '1442397573', null, '2015-09-16 17:59:28', '3', '撒大师大师');
INSERT INTO `pigcms_meal_order` VALUES ('140', '76', '1', '37', '20150918153351000076', '1', '乐呵乐呵', '13628883553', '34', '1442561631', null, '2015-09-18 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('136', '76', '1', '37', '20150918152952000076', '1', '乐呵乐呵', '13628883553', '34', '1442561392', null, '2015-09-18 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('137', '76', '1', '37', '20150918153217000076', '1', '乐呵乐呵', '13628883553', '34', '1442561537', null, '2015-10-16 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('138', '76', '1', '37', '20150918153312000076', '1', '乐呵乐呵', '13628883553', '34', '1442561592', null, '2015-10-13 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('139', '76', '1', '37', '20150918153330000076', '1', '乐呵乐呵', '13628883553', '34', '1442561610', null, '2015-10-10 03:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('141', '76', '1', '37', '20150918153428000076', '1', '乐呵乐呵', '13628883553', '34', '1442561668', null, '2015-10-11 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('142', '76', '1', '37', '20150918153642000076', '1', '乐呵乐呵', '13628883553', '34', '1442561802', null, '2015-09-18 15:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('143', '76', '1', '37', '20150918153722000076', '1', '乐呵乐呵', '13628883553', '34', '1442561842', null, '2015-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('144', '76', '1', '37', '20150918154523000076', '1', '乐呵乐呵', '13628883553', '98', '1442562323', null, '2014-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('145', '76', '1', '37', '20150918154618000076', '1', '乐呵乐呵', '13628883553', '98', '1442562378', null, '2014-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('146', '76', '1', '37', '20150918154801000076', '1', '乐呵乐呵', '13628883553', '98', '1442562481', null, '2014-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('147', '76', '1', '37', '20150918154815000076', '1', '乐呵乐呵', '13628883553', '98', '1442562495', null, '2014-09-18 23:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('148', '76', '1', '37', '20150918154917000076', '1', '乐呵乐呵', '13628883553', '98', '1442562557', null, '2014-09-18 19:00', '1', null);
INSERT INTO `pigcms_meal_order` VALUES ('149', null, '1', '18', '2016060217115400005', '2', '多撒', '13628883553', '29', '1464858714', null, '2016-06-22 00:00:00', '5', '');

-- ----------------------------
-- Table structure for `pigcms_meal_sell_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_sell_log`;
CREATE TABLE `pigcms_meal_sell_log` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meal_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `mouth` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `meal_id` (`meal_id`) USING BTREE
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
  `sort_id` int(11) NOT NULL AUTO_INCREMENT,
  `physical_id` int(11) NOT NULL,
  `sort_name` varchar(50) NOT NULL COMMENT '分类名称',
  `sort` int(11) NOT NULL COMMENT '排序',
  `is_weekshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否星期几显示',
  `week` varchar(50) NOT NULL COMMENT '星期几显示，用逗号分割存储',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`sort_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='订餐分类表';

-- ----------------------------
-- Records of pigcms_meal_sort
-- ----------------------------
INSERT INTO `pigcms_meal_sort` VALUES ('11', '1', '小吃', '0', '0', '1,2,3,4,5,6', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('12', '1', '小吃', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('13', '1', '小吃', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('14', '1', '小吃', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('15', '1', '小吃', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('16', '1', '门票', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('17', '1', '门票', '0', '0', '1,2,3,4,5,6,0', '0');
INSERT INTO `pigcms_meal_sort` VALUES ('18', '1', '2123', '1', '1', '', '0');

-- ----------------------------
-- Table structure for `pigcms_meal_store_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_meal_store_category`;
CREATE TABLE `pigcms_meal_store_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_fid` int(11) NOT NULL,
  `cat_name` varchar(20) NOT NULL,
  `cat_url` varchar(20) NOT NULL,
  `cat_sort` int(11) NOT NULL,
  `cat_status` int(11) NOT NULL,
  PRIMARY KEY (`cat_id`,`cat_fid`)
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
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `cat_id` (`cat_id`) USING BTREE,
  KEY `cat_fid` (`cat_fid`) USING BTREE
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
-- Table structure for `pigcms_my_collection_article`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_my_collection_article`;
CREATE TABLE `pigcms_my_collection_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `uid` int(11) NOT NULL COMMENT '用户UID',
  `article_id` int(11) NOT NULL COMMENT '文章ID',
  `dateline` int(11) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='我的文章收藏';

-- ----------------------------
-- Records of pigcms_my_collection_article
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_my_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_my_supplier`;
CREATE TABLE `pigcms_my_supplier` (
  `seller_store_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商店铺id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商id',
  `supplier_store_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商店铺id',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商id',
  KEY `seller_store_id` (`seller_store_id`) USING BTREE,
  KEY `supplier_store_id` (`supplier_store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='我的供货商';

-- ----------------------------
-- Records of pigcms_my_supplier
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_news`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_news`;
CREATE TABLE `pigcms_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新闻id',
  `news_title` varchar(500) NOT NULL COMMENT '新闻标题',
  `pic` varchar(255) DEFAULT NULL COMMENT '新闻图片',
  `news_content` text NOT NULL COMMENT '新闻内容',
  `cat_key` varchar(20) DEFAULT NULL,
  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态 1为显示 0为不显示',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `uid` int(11) NOT NULL COMMENT '添加人id',
  `hits` int(11) DEFAULT NULL COMMENT '查看次数',
  `abstract` varchar(255) DEFAULT NULL COMMENT '摘要',
  `newsType` tinyint(1) DEFAULT '0' COMMENT '文章类型',
  `imgUrl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='新闻表';

-- ----------------------------
-- Records of pigcms_news
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_news_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_news_category`;
CREATE TABLE `pigcms_news_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) NOT NULL COMMENT '新闻分类 名称',
  `cat_key` varchar(15) NOT NULL COMMENT '新闻模块key',
  `cat_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '类型 默认为0',
  `cat_state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为不正常',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `desc` varchar(50) NOT NULL COMMENT '分类描述',
  `icon` varchar(200) NOT NULL COMMENT '图标',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_news_category
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_ng_word`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_ng_word`;
CREATE TABLE `pigcms_ng_word` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ng_word` varchar(100) NOT NULL,
  `replace_word` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `ng_word` (`ng_word`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='敏感词表';

-- ----------------------------
-- Records of pigcms_ng_word
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order`;
CREATE TABLE `pigcms_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_no` varchar(100) NOT NULL COMMENT '订单号',
  `trade_no` varchar(100) NOT NULL COMMENT '交易号',
  `pay_type` varchar(10) NOT NULL COMMENT '支付方式',
  `third_id` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '买家id',
  `session_id` varchar(32) NOT NULL,
  `postage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品金额（不含邮费）',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额（含邮费）',
  `sale_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '自营商品销售总额',
  `pro_count` int(11) NOT NULL COMMENT '商品的个数',
  `pro_num` int(10) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `address` text NOT NULL COMMENT '收货地址',
  `address_user` varchar(30) NOT NULL DEFAULT '' COMMENT '收货人',
  `address_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `payment_method` varchar(50) NOT NULL DEFAULT '' COMMENT '支付方式',
  `peerpay_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单为代付订单时，1：单人付，2：多人付',
  `peerpay_content` varchar(200) NOT NULL COMMENT '代付订单时，代付人求助语',
  `shipping_method` varchar(50) NOT NULL DEFAULT '' COMMENT '物流方式 express快递发货 selffetch上门自提',
  `send_other_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '当shipping_method值为other_friend,送他人类型，0:默认值，1：送单人，2：送公益，3：送多人',
  `send_other_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '送他人送的份数',
  `send_other_per_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '送他人，每份的数量',
  `send_other_hour` smallint(2) unsigned NOT NULL DEFAULT '0' COMMENT '送他人订单时，领取有效时间，单位：小时',
  `send_other_comment` varchar(1024) DEFAULT NULL COMMENT '送他人，赠言',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型 0普通 1代付 2送礼 3分销',
  `data_id` int(11) NOT NULL DEFAULT '0' COMMENT '当type为6、7时，所对应团购ID，预售ID',
  `presale_order_id` int(11) DEFAULT '0' COMMENT '预售订单id(首次支付：默认为0，直付尾款：为预售order的id)',
  `data_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '团购订单时，团购类型，0：人缘开团，1：最优开团',
  `data_item_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购订单时，参加的团购项',
  `data_money` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '团购需要退的钱，预售需要加的钱',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单状态 0临时订单 1未支付 2未发货 3已发货 4已完成 5已取消 6退款中 ',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单时间',
  `paid_time` int(11) NOT NULL DEFAULT '0' COMMENT '付款时间',
  `sent_time` int(11) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `delivery_time` int(11) NOT NULL DEFAULT '0' COMMENT '收货时间',
  `receive_time` int(11) NOT NULL DEFAULT '0' COMMENT '货到付款时，收款时间',
  `cancel_time` int(11) NOT NULL DEFAULT '0' COMMENT '取消时间',
  `complate_time` int(11) NOT NULL,
  `refund_time` int(11) NOT NULL COMMENT '退款时间',
  `comment` varchar(500) NOT NULL DEFAULT '' COMMENT '买家留言',
  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  `star` tinyint(1) NOT NULL DEFAULT '0' COMMENT '加星订单 1|2|3|4|5 默认0',
  `pay_money` decimal(10,2) NOT NULL COMMENT '实际付款金额',
  `cancel_method` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单取消方式 0过期自动取消 1卖家手动取消 2买家手动取消',
  `float_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单浮动金额',
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含分销商品 0 否 1是',
  `fx_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销订单id',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id,统一分销订单',
  `suppliers` varchar(500) NOT NULL DEFAULT '' COMMENT '商品供货商',
  `packaging` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '打包中',
  `fx_postage` varchar(500) NOT NULL DEFAULT '' COMMENT '分销运费详细 supplier_id=>postage',
  `useStorePay` tinyint(1) NOT NULL DEFAULT '0',
  `storePay` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收款店铺id',
  `storeOpenid` varchar(100) NOT NULL,
  `sales_ratio` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商家销售分成比例,按照所填百分比进行扣除',
  `is_check` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否对账，1：未对账，2：已对账',
  `activity_data` text COMMENT '营销系统活动订单数据',
  `use_deposit_pay` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否满足保证金扣款',
  `is_assigned` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单里商品是否已经分配到门店,0:未分配,1:部分分配,2:全部分配 ',
  `has_physical_send` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有门店配送项:0无 1有',
  `activity_id` int(11) NOT NULL COMMENT '对接活动id',
  `activity_type` varchar(50) NOT NULL COMMENT '对接活动类型',
  `activity_orderid` varchar(100) NOT NULL COMMENT '活动唯一订单id(砍价)',
  `drp_degree_id` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '分销商等级id',
  `is_point_order` tinyint(1) DEFAULT '0' COMMENT '是否积分商城兑换订单 0:否 1：是',
  `order_pay_point` tinyint(1) DEFAULT '0' COMMENT '积分商城该订单需要支付多少积分',
  `drp_team_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销团队id',
  `promotion_reward` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '推广奖励总额',
  `cash_point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '抵现积分',
  `return_point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '返还积分',
  `point2money_rate` float(8,2) unsigned NOT NULL DEFAULT '1.00' COMMENT '积分抵现兑换比率',
  `is_offline` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是线下订单，1：是，0否',
  `offline_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '线下订单类型，0：使用用户的平台积分，1：使用店铺的平台积分',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_no` (`order_no`) USING BTREE,
  UNIQUE KEY `trade_no` (`trade_no`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `store_id_2` (`store_id`,`status`) USING BTREE,
  KEY `storePay` (`storePay`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单';

-- ----------------------------
-- Records of pigcms_order
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_check_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_check_log`;
CREATE TABLE `pigcms_order_check_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT NULL COMMENT '订单id',
  `order_no` varchar(100) DEFAULT NULL COMMENT '订单号',
  `store_id` int(11) DEFAULT NULL COMMENT '被操作的商铺id',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `admin_uid` int(11) DEFAULT NULL COMMENT '操作人uid',
  `ip` bigint(20) DEFAULT NULL COMMENT '操作人ip',
  `timestamp` int(11) DEFAULT NULL COMMENT '记录的时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_order_check_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_coupon`;
CREATE TABLE `pigcms_order_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `name` varchar(255) NOT NULL COMMENT '优惠券名称',
  `user_coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT 'user_coupon表id',
  `money` float(8,2) NOT NULL COMMENT '优惠券金额',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_order_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_discount`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_discount`;
CREATE TABLE `pigcms_order_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID（供货商店铺ID）',
  `discount` double(3,1) NOT NULL DEFAULT '10.0' COMMENT '折扣',
  `is_postage_free` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包邮，1：是包邮，0：不包邮',
  `postage_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',
  UNIQUE KEY `id` (`id`),
  KEY `order_id` (`order_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单折扣表';

-- ----------------------------
-- Records of pigcms_order_discount
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_friend_address`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_friend_address`;
CREATE TABLE `pigcms_order_friend_address` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `order_id` varchar(100) NOT NULL COMMENT '订单ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户UID',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `name` varchar(100) NOT NULL COMMENT '收货人姓名',
  `phone` varchar(20) NOT NULL COMMENT '收货人电话',
  `pro_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品数量',
  `address` varchar(1024) DEFAULT NULL COMMENT '省市县序列化',
  `package_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '包裹ID',
  `package_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '包裹创建时间',
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是默认收货地址，0：否，1：是',
  `openid` varchar(256) NOT NULL COMMENT '用户openid,用户唯一领取用',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_order_friend_address
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_offline`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_offline`;
CREATE TABLE `pigcms_order_offline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `order_no` varchar(50) NOT NULL COMMENT '订单号',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `total` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总额',
  `service_fee` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '服务费',
  `cash` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '使用现金数，（平台备付金使用数）',
  `point` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '使用平台积分数',
  `store_point` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '平台积分，店铺积分使用数',
  `store_user_point` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台积分，店铺用户积分使用数',
  `cat_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `product_name` varchar(255) NOT NULL COMMENT '产品名称，自定义',
  `number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品数量',
  `return_point` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '返还积分',
  `point2money_rate` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分抵现兑换比率',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态，0：临时状态，1：已发放积分',
  `check_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态，0：未审核，1：审核通过，2：审核未通过',
  `check_dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '审核时间',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '审核管理员ID',
  `bak` varchar(1024) DEFAULT NULL COMMENT '备注',
  `promotion_reward` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '推广奖励',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`),
  KEY `store_id` (`store_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='线下店铺手工做单表';

-- ----------------------------
-- Records of pigcms_order_offline
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_package`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_package`;
CREATE TABLE `pigcms_order_package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `express_code` varchar(50) NOT NULL,
  `express_company` varchar(50) NOT NULL DEFAULT '' COMMENT '快递公司',
  `express_no` varchar(50) NOT NULL DEFAULT '' COMMENT '快递单号',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0未发货 1已发货 2已到店 3已签收',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sign_name` varchar(30) NOT NULL DEFAULT '' COMMENT '签收人',
  `sign_time` int(11) NOT NULL DEFAULT '0' COMMENT '签收时间',
  `products` varchar(500) NOT NULL DEFAULT '' COMMENT '商品集合',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id',
  `physical_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店id',
  `courier_id` int(11) NOT NULL DEFAULT '0' COMMENT '配送员id',
  `order_products` varchar(500) NOT NULL DEFAULT '' COMMENT '订单商品集合',
  `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '配送员开始配送时间',
  `arrive_time` int(11) NOT NULL DEFAULT '0' COMMENT '配送员送达时间',
  PRIMARY KEY (`package_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单包裹';

-- ----------------------------
-- Records of pigcms_order_package
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_peerpay`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_peerpay`;
CREATE TABLE `pigcms_order_peerpay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `order_id` int(11) NOT NULL COMMENT '订单表ID',
  `peerpay_no` varchar(100) NOT NULL COMMENT '代支付订单号，格式：PEERPAY_生成另外订单号',
  `money` float(8,2) NOT NULL COMMENT '支付金额',
  `name` varchar(50) DEFAULT NULL COMMENT '支付人姓名',
  `content` varchar(255) DEFAULT NULL COMMENT '支付人留言',
  `pay_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `third_id` varchar(100) NOT NULL COMMENT '第三方支付ID',
  `third_data` text NOT NULL COMMENT '第三方支付返回内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态，0：未支付，1：已支付',
  `untread_money` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '退回金额',
  `untread_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '退回时间',
  `untread_content` varchar(200) DEFAULT NULL COMMENT '退回申请说明',
  `untread_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '退回状态，0：未完成，1：已完成',
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `peerpay_no` (`peerpay_no`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代付表';

-- ----------------------------
-- Records of pigcms_order_peerpay
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_point`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_point`;
CREATE TABLE `pigcms_order_point` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '主订单ID',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户UID',
  `money` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分抵用的现金数',
  `point` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所抵用的积分',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_order_point
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_printing_template`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_printing_template`;
CREATE TABLE `pigcms_order_printing_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `typename` varchar(50) NOT NULL COMMENT '系统模板类型名',
  `folder` varchar(200) DEFAULT NULL COMMENT '系统模板所在static下的文件夹',
  `filename` varchar(200) NOT NULL COMMENT '调用的系统模板名',
  `text` longtext COMMENT '系统模板具体内容',
  `timestamp` int(11) NOT NULL COMMENT '操作的时间戳',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '模板状态开启:1/关闭:0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_order_printing_template
-- ----------------------------
INSERT INTO `pigcms_order_printing_template` VALUES ('1', '购物清单 ', 'order_print', 'shopper.php', '', '1412456123', '1');
INSERT INTO `pigcms_order_printing_template` VALUES ('2', '配货单', 'order_print', 'invoice.php', '', '1412456111', '1');

-- ----------------------------
-- Table structure for `pigcms_order_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_product`;
CREATE TABLE `pigcms_order_product` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单商品id',
  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单id',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `sku_id` int(10) NOT NULL DEFAULT '0' COMMENT '库存id',
  `sku_data` text NOT NULL COMMENT '库存信息',
  `pro_num` int(10) NOT NULL DEFAULT '0' COMMENT '数量',
  `pro_price` decimal(10,2) NOT NULL,
  `presale_pro_price` decimal(10,2) DEFAULT '0.00' COMMENT '当为预售订单商品时，此为购买商品原价',
  `pro_weight` float(10,2) NOT NULL COMMENT '每一个产品的重量，单位：克',
  `point` int(10) DEFAULT '0' COMMENT '会员特权，额外赠送积分',
  `discount` float(8,2) DEFAULT '0.00' COMMENT '会员等级特权享受的折扣，优先于等级折扣，0表示没有特权折扣',
  `comment` text NOT NULL COMMENT '买家留言',
  `is_packaged` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已打包 0未打包 1已打包',
  `in_package_status` tinyint(1) NOT NULL COMMENT '在包裹里的状态 0未发货 1已发货 2已到店 3已签收',
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销商品 0否 1是',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',
  `original_product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '源商品id',
  `user_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户订单id',
  `is_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已评论，1：是，0：否',
  `return_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '产品退款状态，0：未退款，1：部分退款，2：全部退完',
  `rights_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '产品维权状态，0：未维权，1：部分维权，2：全部维权',
  `is_present` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为赠品，1：是，0：否',
  `sp_id` int(11) NOT NULL DEFAULT '0' COMMENT '门店id',
  `profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销单件商品利润',
  `drp_degree_profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销商等级利润',
  `return_point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '购买返积分',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单产品类型，0：普通，1：团购，2：预售',
  `data_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购、预售类型时的团购、预售ID',
  `subscribed_discount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '关注后的折扣',
  PRIMARY KEY (`pigcms_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `sku_id` (`sku_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单商品';

-- ----------------------------
-- Records of pigcms_order_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_product_physical`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_product_physical`;
CREATE TABLE `pigcms_order_product_physical` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单id',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格sku_id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单商品id',
  `physical_id` int(10) NOT NULL DEFAULT '0' COMMENT '仓库/门店id',
  PRIMARY KEY (`pigcms_id`),
  KEY `sku_id` (`sku_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `physical_id` (`physical_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='门店分配订单商品关系';

-- ----------------------------
-- Records of pigcms_order_product_physical
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_reward`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_reward`;
CREATE TABLE `pigcms_order_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单表ID',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `rid` int(11) NOT NULL COMMENT '满减/送ID',
  `name` varchar(255) NOT NULL COMMENT '活动名称',
  `content` text NOT NULL COMMENT '描述序列化数组',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单优惠表';

-- ----------------------------
-- Records of pigcms_order_reward
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_sms`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_sms`;
CREATE TABLE `pigcms_order_sms` (
  `sms_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uid` int(11) NOT NULL COMMENT '购买人uid',
  `pay_openid` varchar(50) DEFAULT NULL COMMENT '支付人openid',
  `smspay_no` varchar(100) DEFAULT NULL COMMENT '短信支付订单号，格式：SMSPAY_生成另外订单号',
  `trade_no` varchar(100) NOT NULL COMMENT '交易流水号 ',
  `sms_price` int(11) DEFAULT '0' COMMENT '短信单价(单位：分)',
  `sms_num` int(11) DEFAULT NULL COMMENT '购买短信数量',
  `money` float(8,2) NOT NULL COMMENT '支付金额',
  `name` varchar(50) DEFAULT NULL COMMENT '支付人姓名',
  `content` varchar(255) DEFAULT NULL COMMENT '支付人留言',
  `pay_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `third_id` varchar(100) NOT NULL COMMENT '第三方支付ID',
  `third_data` text NOT NULL COMMENT '第三方支付返回内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态，0：未支付，1：已支付',
  PRIMARY KEY (`sms_order_id`),
  UNIQUE KEY `id` (`sms_order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信订单表';

-- ----------------------------
-- Records of pigcms_order_sms
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_order_trade`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_order_trade`;
CREATE TABLE `pigcms_order_trade` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `third_data` text NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='交易支付返回消息详细数据';

-- ----------------------------
-- Records of pigcms_order_trade
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_package`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_package`;
CREATE TABLE `pigcms_package` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '套餐id',
  `name` varchar(50) NOT NULL COMMENT '套餐名称',
  `time` tinyint(3) unsigned NOT NULL COMMENT '套餐有效时间',
  `store_nums` varchar(50) NOT NULL COMMENT '开店数量',
  `store_online_trade` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '店铺线上交易',
  `store_point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '店铺每日做单限额',
  `distributor_nums` varchar(50) NOT NULL DEFAULT '0' COMMENT '店铺发展分销商数量限制',
  `store_pay_weixin_open` tinyint(1) unsigned NOT NULL COMMENT '店铺是否支持独立收款',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `is_default` tinyint(1) unsigned NOT NULL COMMENT '是否是初始权限',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_package
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_platform`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_platform`;
CREATE TABLE `pigcms_platform` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `info` varchar(500) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `key` varchar(50) NOT NULL COMMENT '关键词',
  `url` varchar(200) NOT NULL COMMENT '外链url',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='首页回复配置';

-- ----------------------------
-- Records of pigcms_platform
-- ----------------------------
INSERT INTO `pigcms_platform` VALUES ('1', '帅呆了', '没谁了啊', '', '杨工', '');

-- ----------------------------
-- Table structure for `pigcms_platform_drp_degree`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_platform_drp_degree`;
CREATE TABLE `pigcms_platform_drp_degree` (
  `pigcms_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',
  `value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '等级值',
  `icon_id` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '默认等级图标id(废弃)',
  `icon` varchar(200) NOT NULL COMMENT '图标',
  `condition_point` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '条件积分',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '使用须知',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0 禁用 1启用',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `icon_id` (`icon_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_platform_drp_degree
-- ----------------------------
INSERT INTO `pigcms_platform_drp_degree` VALUES ('1', '金牌分销商', '400', '0', 'images/drp_degree_icon/1.png', '33', '', '1', '0');
INSERT INTO `pigcms_platform_drp_degree` VALUES ('2', '银牌分销商', '300', '0', 'images/drp_degree_icon/2.png', '113', '', '1', '0');
INSERT INTO `pigcms_platform_drp_degree` VALUES ('3', '铜牌分销商', '200', '0', 'images/drp_degree_icon/3.png', '2', '', '1', '1452841572');
INSERT INTO `pigcms_platform_drp_degree` VALUES ('4', '普通分销商', '100', '0', 'images/drp_degree_icon/4.png', '0', '', '1', '1452841604');

-- ----------------------------
-- Table structure for `pigcms_platform_income`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_platform_income`;
CREATE TABLE `pigcms_platform_income` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入/支出',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类型：1交易服务费 2店铺认证费用 3 保证金服务费 4 推广奖励',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 未处理 1 已处理',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_platform_income
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_platform_margin_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_platform_margin_log`;
CREATE TABLE `pigcms_platform_margin_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_offline_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '线下订单ID',
  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '交易单号',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `payment_method` varchar(20) NOT NULL DEFAULT '' COMMENT '支付方式',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0充值 1提现 2扣除 3 退货',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未支付 1未处理 2已处理 3已取消',
  `paid_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  `margin_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '操作前保证金总额',
  `margin_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '操作前保证金余额',
  PRIMARY KEY (`pigcms_id`),
  UNIQUE KEY `order_no` (`order_no`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COMMENT='平台保证金流水记录';

-- ----------------------------
-- Records of pigcms_platform_margin_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_platform_point_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_platform_point_log`;
CREATE TABLE `pigcms_platform_point_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `point` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作积分',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 未处理 1 已处理',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型 0 用户积分抵现 + 1 积分转现 +',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `point_income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作前平台积分总额',
  `channel` tinyint(1) unsigned NOT NULL COMMENT '渠道(0表示线上交易,1表示线下交易)',
  `bak` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`pigcms_id`),
  KEY `order_no` (`order_no`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='平台积分收入日志';

-- ----------------------------
-- Records of pigcms_platform_point_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_platform_share_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_platform_share_log`;
CREATE TABLE `pigcms_platform_share_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '分享连接的用户id',
  `share_num` int(11) unsigned NOT NULL COMMENT '被分享的次数',
  `share_ip` text NOT NULL COMMENT '点击者的ip',
  `share_time` int(11) unsigned NOT NULL,
  `update_time` int(11) NOT NULL,
  `share_num_count` int(11) unsigned NOT NULL COMMENT '分享总点击数',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_platform_share_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_platform_user_points_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_platform_user_points_log`;
CREATE TABLE `pigcms_platform_user_points_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '会员id',
  `store_id` int(11) DEFAULT '0' COMMENT '被操作的店铺id',
  `order_id` int(11) DEFAULT '0',
  `point` int(11) unsigned NOT NULL COMMENT '新增积分点数',
  `point_type` tinyint(1) NOT NULL COMMENT '1 首次关注公众号（送） 2 分享链接达到点击数（送） 3 兑换礼物（消耗）',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_platform_user_points_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_plat_subscribe`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_plat_subscribe`;
CREATE TABLE `pigcms_plat_subscribe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) DEFAULT NULL COMMENT '扫码者oenid',
  `is_sub` tinyint(1) DEFAULT '1' COMMENT '是否关注:0不关注，1:关注',
  `last_time` int(11) DEFAULT NULL COMMENT '最后操作的时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_plat_subscribe
-- ----------------------------
INSERT INTO `pigcms_plat_subscribe` VALUES ('1', 'oqswDuAaz5LXF_3mUgylYWEMJs28', '1', '1464753353');
INSERT INTO `pigcms_plat_subscribe` VALUES ('2', 'oqswDuAPlbmj_ROuN3GgEiz7lwN4', '1', '1464859726');

-- ----------------------------
-- Table structure for `pigcms_plat_sub_qrcode`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_plat_sub_qrcode`;
CREATE TABLE `pigcms_plat_sub_qrcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` varchar(500) DEFAULT NULL,
  `openid` varchar(50) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_plat_sub_qrcode
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_points`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_points`;
CREATE TABLE `pigcms_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL COMMENT '积分店铺id',
  `points` int(11) DEFAULT NULL COMMENT '积分数',
  `type` tinyint(1) DEFAULT NULL COMMENT '给积分类别: 1:关注我的微信,2:每成功交易笔数, 3:每购买金额多少元',
  `trade_or_amount` int(11) DEFAULT NULL COMMENT '当type=2:为交易笔数值,type=3：为购买金额数',
  `is_call_to_fans` tinyint(1) DEFAULT NULL COMMENT '是否通知粉丝',
  `starttime` int(2) DEFAULT NULL COMMENT '开始时间 整点',
  `endtime` int(2) DEFAULT NULL COMMENT '结束时间 整点',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:关闭,1开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_points
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_postage_template`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_postage_template`;
CREATE TABLE `pigcms_postage_template` (
  `tpl_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '邮费模板id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `tpl_name` varchar(100) NOT NULL DEFAULT '' COMMENT '模板名称',
  `tpl_area` varchar(10000) NOT NULL COMMENT '模板配送区域',
  `last_time` int(11) NOT NULL,
  `copy_id` int(11) NOT NULL,
  PRIMARY KEY (`tpl_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='邮费模板';

-- ----------------------------
-- Records of pigcms_postage_template
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_presale`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_presale`;
CREATE TABLE `pigcms_presale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL COMMENT '预售名称',
  `product_id` int(11) DEFAULT NULL COMMENT '预售产品id',
  `uid` int(11) DEFAULT NULL COMMENT '操作的用户uid',
  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',
  `dingjin` double(10,2) DEFAULT '0.00' COMMENT '定金',
  `price` double(10,2) DEFAULT '0.00' COMMENT '商品原价',
  `product_quantity` int(11) DEFAULT '0' COMMENT '商品原总库存(不同规格综合)',
  `product_count` int(11) DEFAULT '0' COMMENT '商品总库存',
  `privileged_cash` double(10,2) DEFAULT '0.00' COMMENT '特权_减多少现金',
  `privileged_coupon` int(11) DEFAULT '0' COMMENT '特权_赠送券id',
  `privileged_present` int(11) DEFAULT '0' COMMENT '特权_赠品id',
  `presale_person` int(11) DEFAULT '0' COMMENT '预售人数',
  `pre_buyer_count` int(11) DEFAULT '0' COMMENT '真实支付预付款人数',
  `buyer_count` int(11) DEFAULT '0' COMMENT '真实支付尾款人数',
  `buy_count` int(11) DEFAULT '0' COMMENT '购买预售的商品的数量',
  `starttime` int(11) DEFAULT NULL COMMENT '开始时间',
  `endtime` int(11) DEFAULT NULL COMMENT '结束时间',
  `final_paytime` int(11) DEFAULT NULL COMMENT '尾款支付截止时间',
  `presale_amount` int(11) DEFAULT NULL COMMENT '预售数量限制',
  `description` text COMMENT '预售说明',
  `timestamp` int(11) DEFAULT NULL COMMENT '操作时间戳',
  `is_open` tinyint(1) DEFAULT '1' COMMENT '是否开启:0未开启，1:开启中',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_presale
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_present`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_present`;
CREATE TABLE `pigcms_present` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) NOT NULL COMMENT '添加时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `name` varchar(255) NOT NULL COMMENT '赠品名称',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠品开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠品结束时间',
  `expire_date` int(11) NOT NULL DEFAULT '0' COMMENT '领取有效期，此只对虚拟产品,保留字段',
  `expire_number` int(11) NOT NULL DEFAULT '0' COMMENT '领取限制，此只对虚拟产品，保留字段',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '领取次数',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效，1：有效，0：无效，',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`,`start_time`,`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='赠品表';

-- ----------------------------
-- Records of pigcms_present
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_present_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_present_product`;
CREATE TABLE `pigcms_present_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '赠品表ID',
  `product_id` int(11) NOT NULL COMMENT '产品表ID',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='赠品产品列表';

-- ----------------------------
-- Records of pigcms_present_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product`;
CREATE TABLE `pigcms_product` (
  `product_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `category_fid` int(11) NOT NULL,
  `category_id` int(10) NOT NULL DEFAULT '0' COMMENT '分类id',
  `group_id` int(10) NOT NULL DEFAULT '0' COMMENT '分组id',
  `name` varchar(300) NOT NULL DEFAULT '' COMMENT '商品名称',
  `sale_way` char(1) NOT NULL DEFAULT '0' COMMENT '出售方式 0一口价 1拍卖',
  `buy_way` char(1) NOT NULL DEFAULT '1' COMMENT '购买方式 1店内购买 0店外购买',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '商品类型 0实物 1虚拟',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `original_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `weight` float(10,2) NOT NULL COMMENT '产品重量，单位：克',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '商品编码',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '商品主图',
  `image_size` varchar(200) NOT NULL,
  `send_other` enum('0','1') NOT NULL DEFAULT '0' COMMENT '产品是否可以送他人,0:否，1：是',
  `send_other_postage` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '送他人统一邮费',
  `postage_type` char(1) NOT NULL DEFAULT '0' COMMENT '邮费类型 0统计邮费 1邮费模板 ',
  `postage` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',
  `postage_template_id` int(10) NOT NULL DEFAULT '0' COMMENT '邮费模板',
  `buyer_quota` int(5) NOT NULL DEFAULT '0' COMMENT '买家限购',
  `allow_discount` char(1) NOT NULL DEFAULT '1' COMMENT '参加会员折扣',
  `invoice` char(1) NOT NULL DEFAULT '0' COMMENT '发票 0无 1有',
  `warranty` char(1) NOT NULL DEFAULT '0' COMMENT '保修 0无 1有',
  `sold_time` int(11) NOT NULL DEFAULT '0' COMMENT '开售时间 0立即开售',
  `sales` int(10) NOT NULL DEFAULT '0' COMMENT '商品销量',
  `show_sku` char(1) NOT NULL DEFAULT '1' COMMENT '显示库存 0 不显示 1显示',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 0仓库中 1上架 2 删除',
  `date_added` varchar(20) NOT NULL DEFAULT '0' COMMENT '添加日期',
  `soldout` char(1) NOT NULL DEFAULT '0' COMMENT '售完 0未售完 1已售完',
  `pv` int(10) NOT NULL DEFAULT '0' COMMENT '商品浏览量',
  `uv` int(10) NOT NULL DEFAULT '0' COMMENT '商品浏览人数',
  `buy_url` varchar(200) NOT NULL DEFAULT '' COMMENT '外部购买地址',
  `intro` varchar(300) NOT NULL DEFAULT '' COMMENT '商品简介',
  `info` text NOT NULL COMMENT '商品描述',
  `has_custom` tinyint(4) NOT NULL COMMENT '有没有自定义文本',
  `has_category` tinyint(4) NOT NULL COMMENT '有没有商品分组',
  `properties` text NOT NULL COMMENT '商品属性',
  `has_property` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有商品属性 0否 1是',
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分销商品',
  `unified_price` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '统一零售价',
  `fx_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分销类型 0全网分销 1排他分销',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价格',
  `min_fx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销最低价格',
  `max_fx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销最高价格',
  `is_recommend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商家推荐',
  `recommend_title` varchar(15) DEFAULT '' COMMENT '推荐语',
  `source_product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销来源商品id',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商店铺id',
  `delivery_address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收货地址 0为买家地址，大于0为分销商地址',
  `last_edit_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `original_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销原始id,同一商品各分销商相同',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_fx_setting` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已设置分销信息',
  `collect` int(11) unsigned NOT NULL COMMENT '收藏数',
  `attention_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数',
  `drp_profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品分销利润总额',
  `drp_seller_qty` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商数量(被分销次数)',
  `drp_sale_qty` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商品销量',
  `unified_price_setting` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '供货商统一定价',
  `drp_level_1_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品价格',
  `drp_level_2_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品价格',
  `drp_level_3_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品价格',
  `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品成本价格',
  `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品成本价格',
  `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品成本价格',
  `is_hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否热门 0否 1是',
  `is_wholesale` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '批发商品',
  `wholesale_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '批发价格',
  `sale_min_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '建议最低售价',
  `sale_max_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '建议最高售价',
  `wholesale_product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '批发商品id',
  `public_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启后将会在微信综合商城和pc综合商城展示,0不展示1展示',
  `unified_profit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否统一直销利润',
  `is_whitelist` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否是白名单商品',
  `check_give_points` tinyint(1) DEFAULT '0' COMMENT '是否启用额外赠送会员积分（0：未启用，1：启用中）',
  `check_degree_discount` tinyint(1) DEFAULT '0' COMMENT '是否启用额外会员等级优惠（0：未启用，1：启用中）',
  `give_points` int(11) DEFAULT NULL COMMENT '额外赠送会员积分',
  `after_subscribe_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '关注后价格',
  `is_present` tinyint(1) DEFAULT '0' COMMENT '是否积分商城商品（0: 普通商品 1：积分兑换商品）',
  `open_return_point` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启送平台积分 0 未开启 1 已开启',
  `after_subscribe_discount` decimal(5,2) unsigned NOT NULL COMMENT '关注后折扣',
  `drp_custom_setting` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分销自定义设置',
  `return_point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '返还积分',
  PRIMARY KEY (`product_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `category_id` (`category_id`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE,
  KEY `postage_template_id` (`postage_template_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品';

-- ----------------------------
-- Records of pigcms_product
-- ----------------------------
INSERT INTO `pigcms_product` VALUES ('1', '6', '3', '3', '1', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '1', '0', '', '', '', '0', '1', '', '0', '0', '1', '0', '0.00', '0.00', '0.00', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0', '0.00', '0.00', '0.00', '0', '1', '0', '0', '0', '0', null, '0.00', '0', '0', '0.00', '0', '0.00');
INSERT INTO `pigcms_product` VALUES ('2', '6', '3', '3', '1', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '3', '0', '', '', '', '0', '1', '', '0', '0', '1', '0', '0.00', '0.00', '0.00', '0', '', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0.00', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0', '0.00', '0.00', '0.00', '0', '1', '0', '0', '0', '0', null, '0.00', '0', '0', '0.00', '0', '0.00');
INSERT INTO `pigcms_product` VALUES ('3', '6', '3', '3', '1', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '3', '0', '', '', '', '0', '1', '', '0', '0', '1', '0', '0.00', '0.00', '0.00', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0', '0.00', '0.00', '0.00', '0', '1', '0', '0', '0', '0', null, '0.00', '0', '0', '0.00', '0', '0.00');
INSERT INTO `pigcms_product` VALUES ('4', '9', '12', '1', '16', '0', '测试商品', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/000/000/012/201605/5747aeb89fece.jpg', '', '1', '0.00', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1464315634', '0', '3', '0', '', '', '<p><img src=\"http://www.ediancha.com/upload/images/000/000/012/201605/5747aeee81786.jpg\"/></p>', '0', '0', '', '0', '1', '1', '0', '4.00', '10.00', '10.00', '0', '', '0', '0', '0', '1464347828', '0', '0', '1', '0', '0', '0.00', '0', '0', '1', '10.00', '10.00', '10.00', '4.00', '5.00', '7.00', '0', '0', '0.00', '0.00', '0.00', '0', '1', '1', '0', '0', '0', '0', '0.00', '0', '0', '0.00', '0', '0.00');
INSERT INTO `pigcms_product` VALUES ('5', '5', '18', '3', '2', '0', '餐饮外卖1', '0', '1', '0', '100', '10.00', '0.00', '0.00', '', 'images/eg1.jpg', '', '0', '0.00', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003015', '0', '4', '0', '', '', '', '0', '1', '', '0', '0', '1', '0', '0.00', '0.00', '0.00', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0', '0.00', '0.00', '0.00', '0', '1', '0', '0', '0', '0', null, '0.00', '0', '0', '0.00', '0', '0.00');
INSERT INTO `pigcms_product` VALUES ('6', '5', '18', '3', '2', '0', '餐饮外卖2', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg2.jpg', '', '0', '0.00', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003109', '0', '3', '0', '', '', '', '0', '1', '', '0', '0', '1', '0', '0.00', '0.00', '0.00', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0', '0.00', '0.00', '0.00', '0', '1', '0', '0', '0', '0', null, '0.00', '0', '0', '0.00', '0', '0.00');
INSERT INTO `pigcms_product` VALUES ('7', '5', '18', '3', '2', '0', '餐饮外卖3', '0', '1', '0', '10', '10.00', '0.00', '0.00', '', 'images/eg3.jpg', '', '0', '0.00', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '1', '1', '1439003188', '0', '5', '0', '', '', '', '0', '1', '', '0', '0', '1', '0', '0.00', '0.00', '0.00', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0.00', '0', '0', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0', '0.00', '0.00', '0.00', '0', '1', '0', '0', '0', '0', null, '0.00', '0', '0', '0.00', '0', '0.00');

-- ----------------------------
-- Table structure for `pigcms_product_activity`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_activity`;
CREATE TABLE `pigcms_product_activity` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `product_id` int(255) NOT NULL COMMENT '商品ID',
  `activity_name` varchar(255) NOT NULL COMMENT '活动名',
  `activity_id` int(255) NOT NULL COMMENT '活动ID',
  `activity_status` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '活动状态，1开启0关闭',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_product_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_category`;
CREATE TABLE `pigcms_product_category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `cat_desc` varchar(1000) NOT NULL COMMENT '描述',
  `cat_fid` int(10) NOT NULL DEFAULT '0' COMMENT '父类id',
  `cat_pic` varchar(50) NOT NULL COMMENT 'wap端栏目图片',
  `cat_pc_pic` varchar(50) NOT NULL COMMENT 'pc端栏目图片',
  `cat_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `wx_cat_status` tinyint(1) DEFAULT '1' COMMENT '微信端显示状态',
  `cat_sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序，值越大优前',
  `cat_path` varchar(1000) NOT NULL,
  `cat_level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `filter_attr` varchar(255) NOT NULL COMMENT '拥有的属性id 用,号分割',
  `tag_str` varchar(1024) NOT NULL COMMENT 'tag列表，每个tag_id之间用逗号分割',
  `cat_parent_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '父类状态',
  PRIMARY KEY (`cat_id`),
  KEY `parent_category_id` (`cat_fid`) USING BTREE,
  KEY `cat_sort` (`cat_sort`) USING BTREE,
  KEY `cat_name` (`cat_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分类';

-- ----------------------------
-- Records of pigcms_product_category
-- ----------------------------
INSERT INTO `pigcms_product_category` VALUES ('93', '绿茶', '绿茶', '0', 'category/2016/06/574eaf5a2c3d42553741.jpg', 'category/2016/06/574eaf5a2ca7c7829925.jpg', '1', '1', '2', '0,93', '1', '24,23,22,21,20', '', '1');
INSERT INTO `pigcms_product_category` VALUES ('92', '茶具', '茶具分类', '0', 'category/2016/06/574e5dcbc935f1580078.png', 'category/2016/06/574e5dcbcac212094512.png', '1', '1', '1', '0,92', '1', '21,20', '1,2,3,4', '1');

-- ----------------------------
-- Table structure for `pigcms_product_custom_field`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_custom_field`;
CREATE TABLE `pigcms_product_custom_field` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `field_name` varchar(30) NOT NULL DEFAULT '' COMMENT '自定义字段名称',
  `field_type` varchar(30) NOT NULL DEFAULT '' COMMENT '自定义字段类型',
  `multi_rows` tinyint(1) NOT NULL DEFAULT '0' COMMENT '多行 0 否 1 是',
  `required` tinyint(1) NOT NULL DEFAULT '0' COMMENT '必填 0 否 1是',
  PRIMARY KEY (`pigcms_id`),
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品自定义字段';

-- ----------------------------
-- Records of pigcms_product_custom_field
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_discount`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_discount`;
CREATE TABLE `pigcms_product_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `degree_name` varchar(200) DEFAULT NULL COMMENT '等级名称',
  `discount` double(3,1) NOT NULL DEFAULT '10.0' COMMENT '折扣10.0 为不打折',
  `degree_id` int(11) DEFAULT NULL COMMENT '对应等级id',
  `timestamp` int(11) DEFAULT NULL COMMENT '最近操作的时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_product_discount
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_drp_degree`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_drp_degree`;
CREATE TABLE `pigcms_product_drp_degree` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `degree_id` int(11) unsigned DEFAULT '0' COMMENT '等级id',
  `seller_reward_1` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '一级分销商奖励比率',
  `seller_reward_2` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '二级分销商奖励比率',
  `seller_reward_3` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '三级分销商奖励比率',
  PRIMARY KEY (`pigcms_id`),
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `degree_id` (`degree_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='分销商品等级利润';

-- ----------------------------
-- Records of pigcms_product_drp_degree
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_group`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_group`;
CREATE TABLE `pigcms_product_group` (
  `group_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品分组id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `group_name` varchar(50) NOT NULL COMMENT '分组名称',
  `is_show_name` char(1) NOT NULL DEFAULT '0' COMMENT '显示商品分组名称',
  `first_sort` varchar(30) NOT NULL DEFAULT '' COMMENT '商品排序',
  `second_sort` varchar(30) NOT NULL DEFAULT '' COMMENT '商品排序',
  `list_style_size` char(1) NOT NULL DEFAULT '0' COMMENT '列表大小 0大图 1小图 2一大两小 3详细列表',
  `list_style_type` char(1) NOT NULL DEFAULT '0' COMMENT '列表样式 0卡片样式 1瀑布流 2极简样式',
  `is_show_price` char(1) NOT NULL DEFAULT '1' COMMENT '显示价格',
  `is_show_product_name` char(1) NOT NULL DEFAULT '0' COMMENT '显示商品名 0不显示 1显示',
  `is_show_buy_button` char(1) NOT NULL DEFAULT '1' COMMENT '显示购买按钮',
  `buy_button_style` char(1) NOT NULL DEFAULT '1' COMMENT '购买按钮样式 1样式1 2样式2 3样式3 4 样式4',
  `group_label` text NOT NULL COMMENT '商品标签简介',
  `product_count` int(10) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `has_custom` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分组';

-- ----------------------------
-- Records of pigcms_product_group
-- ----------------------------
INSERT INTO `pigcms_product_group` VALUES ('1', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');
INSERT INTO `pigcms_product_group` VALUES ('2', '567', '餐饮外卖', '1', '0', '0', '0', '0', '1', '0', '1', '1', '', '3', '0', '1439003225');

-- ----------------------------
-- Table structure for `pigcms_product_image`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_image`;
CREATE TABLE `pigcms_product_image` (
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '商品图片',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `sort` (`sort`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品图片';

-- ----------------------------
-- Records of pigcms_product_image
-- ----------------------------
INSERT INTO `pigcms_product_image` VALUES ('4', 'images/000/000/012/201605/5747aeb89fece.jpg', '1');

-- ----------------------------
-- Table structure for `pigcms_product_property`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_property`;
CREATE TABLE `pigcms_product_property` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品属性名';

-- ----------------------------
-- Records of pigcms_product_property
-- ----------------------------
INSERT INTO `pigcms_product_property` VALUES ('1', '尺寸');
INSERT INTO `pigcms_product_property` VALUES ('2', '净重');
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
  `vid` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品属性值id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品属性名id',
  `value` varchar(50) NOT NULL DEFAULT '' COMMENT '商品属性值',
  `image` varchar(255) NOT NULL COMMENT '属性对应图片',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示 0：不显示，1：显示',
  PRIMARY KEY (`vid`),
  KEY `pid` (`pid`) USING BTREE,
  KEY `pid_2` (`pid`,`value`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品属性值';

-- ----------------------------
-- Records of pigcms_product_property_value
-- ----------------------------
INSERT INTO `pigcms_product_property_value` VALUES ('1', '1', '5寸', '', '1');
INSERT INTO `pigcms_product_property_value` VALUES ('2', '1', '6寸', '', '1');
INSERT INTO `pigcms_product_property_value` VALUES ('3', '3', '国产', '', '1');
INSERT INTO `pigcms_product_property_value` VALUES ('4', '3', '进口', '', '1');

-- ----------------------------
-- Table structure for `pigcms_product_qrcode_activity`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_qrcode_activity`;
CREATE TABLE `pigcms_product_qrcode_activity` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `buy_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '购买方式 0扫码直接购买',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠方式 0扫码折扣 1扫码可减优惠',
  `discount` float NOT NULL DEFAULT '0' COMMENT '折扣',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品扫码活动';

-- ----------------------------
-- Records of pigcms_product_qrcode_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_relation`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_relation`;
CREATE TABLE `pigcms_product_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned DEFAULT '0' COMMENT '产品ID',
  `relation_id` int(11) unsigned DEFAULT '0' COMMENT '关联产品ID',
  `sort` tinyint(1) unsigned DEFAULT '0' COMMENT '排序，显示从小到大',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品关联产品表';

-- ----------------------------
-- Records of pigcms_product_relation
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_sku`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_sku`;
CREATE TABLE `pigcms_product_sku` (
  `sku_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '库存id',
  `product_id` int(10) NOT NULL,
  `properties` varchar(500) NOT NULL DEFAULT '' COMMENT '商品属性组合 pid1:vid1;pid2:vid2;pid3:vid3',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '库存',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `return_point` decimal(10,2) DEFAULT '0.00' COMMENT '赠送的平台积分，当购选额外积分时，0或空都表示不送积分',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '相应规格的重量',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '库存编码',
  `sales` int(10) NOT NULL DEFAULT '0' COMMENT '销量',
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '成本价格',
  `min_fx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销最低价格',
  `max_fx_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分销最高价格',
  `drp_level_1_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品价格',
  `drp_level_2_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品价格',
  `drp_level_3_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品价格',
  `drp_level_1_cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT ' 一级分销商商品成本价格',
  `drp_level_2_cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品成本价格',
  `drp_level_3_cost_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品成本价格',
  `wholesale_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '批发价格',
  `sale_min_price` decimal(10,2) NOT NULL,
  `sale_max_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '建议最高售价',
  `after_subscribe_price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '关注后库存价格',
  `after_subscribe_discount` decimal(5,2) unsigned NOT NULL COMMENT '关注后折扣',
  `wholesale_sku_id` int(11) unsigned NOT NULL COMMENT '原商品库存id',
  PRIMARY KEY (`sku_id`),
  KEY `code` (`code`) USING BTREE,
  KEY `product_id` (`product_id`,`quantity`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品库存';

-- ----------------------------
-- Records of pigcms_product_sku
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_to_group`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_to_group`;
CREATE TABLE `pigcms_product_to_group` (
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组id',
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分组关联';

-- ----------------------------
-- Records of pigcms_product_to_group
-- ----------------------------
INSERT INTO `pigcms_product_to_group` VALUES ('1', '1');
INSERT INTO `pigcms_product_to_group` VALUES ('2', '1');
INSERT INTO `pigcms_product_to_group` VALUES ('3', '1');
INSERT INTO `pigcms_product_to_group` VALUES ('5', '2');
INSERT INTO `pigcms_product_to_group` VALUES ('6', '2');
INSERT INTO `pigcms_product_to_group` VALUES ('7', '2');

-- ----------------------------
-- Table structure for `pigcms_product_to_property`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_to_property`;
CREATE TABLE `pigcms_product_to_property` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品属性id',
  `order_by` int(5) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`pigcms_id`),
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品关联属性id';

-- ----------------------------
-- Records of pigcms_product_to_property
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_to_property_value`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_to_property_value`;
CREATE TABLE `pigcms_product_to_property_value` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品属性id',
  `vid` int(10) NOT NULL DEFAULT '0' COMMENT '商品属性值id',
  `order_by` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`pigcms_id`),
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  KEY `vid` (`vid`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品关联属性值';

-- ----------------------------
-- Records of pigcms_product_to_property_value
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_visited`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_visited`;
CREATE TABLE `pigcms_product_visited` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id，使用uid可分析 访问者性别，来源',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `visits` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问次数',
  `sales` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `duration_time` float unsigned NOT NULL DEFAULT '0' COMMENT '累计停留时间，duration_time/visits = 平均停留时间',
  `last_time_visited` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次访问时间',
  `last_ip_visited` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pigcms_id`),
  KEY `uid` (`uid`,`store_id`,`product_id`) USING BTREE,
  KEY `product_id` (`product_id`,`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='商品访问记录';

-- ----------------------------
-- Records of pigcms_product_visited
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_product_whitelist`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_product_whitelist`;
CREATE TABLE `pigcms_product_whitelist` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '经销商id',
  `sales` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '经销商销量',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '加入白名单时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `product_id` (`product_id`,`supplier_id`) USING BTREE,
  KEY `seller_id` (`seller_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of pigcms_product_whitelist
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_project`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_project`;
CREATE TABLE `pigcms_project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '项目id主键自增',
  `realName` varchar(50) NOT NULL COMMENT '联系人',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `email` varchar(100) DEFAULT NULL COMMENT '联系邮箱',
  `sponsorWeixin` varchar(50) DEFAULT NULL COMMENT '微信号',
  `type` tinyint(2) DEFAULT NULL COMMENT '1个人，2企业',
  `projectName` varchar(255) DEFAULT NULL COMMENT '项目名称',
  `projectSubtitle` varchar(500) DEFAULT NULL COMMENT '一句话介绍',
  `label` varchar(20) DEFAULT NULL COMMENT '标签',
  `projectProvince` varchar(50) DEFAULT NULL COMMENT '所在省',
  `ckFlag` tinyint(2) DEFAULT NULL COMMENT '是否需要领投 1是 2否',
  `companyCreatetime` varchar(30) DEFAULT NULL COMMENT '成立时间',
  `foundingNum` tinyint(2) DEFAULT NULL COMMENT '创始人人数 1：1人、2：2人、3：3人、4：4人、5：5人、6：6人、7：7人以上',
  `projectTeamcount` tinyint(2) DEFAULT NULL COMMENT '员工数量 1：0-50、2：50-100、3：100-150、4：150-200、5：200以上',
  `projectStage` tinyint(2) DEFAULT NULL COMMENT '项目阶段 1概念阶段、2研发中、3产品已发布、4产品已盈利、5其他',
  `financingRoundsNumber` tinyint(2) DEFAULT NULL COMMENT '本轮融资轮数 1:种子期2：天使期、3：Pre-A轮、4：A轮、5：B轮、6：C轮、7：D轮、8：并购',
  `companyRevenue` tinyint(2) DEFAULT NULL COMMENT '年收入情况 1：100万一下、2：100-500万、3：500-1000万、4：1000-2000万、5：2000-5000万、6：5000-1亿、7： 一亿以上',
  `operatingData` varchar(500) DEFAULT NULL COMMENT '运营数据',
  `listImg` varchar(255) DEFAULT NULL COMMENT '列表页图片',
  `projectDetails` varchar(5000) DEFAULT NULL COMMENT '项目详情',
  `pastFinancing` tinyint(2) DEFAULT '0' COMMENT '过往融资次数 0.无、1.1、2.2、3.3、4.4、5.5、6.6次以上',
  `pastAmount` tinyint(2) DEFAULT '0' COMMENT '过往融资金额 0：无、1：100-500万、2：500-1000万、3：1000-2000万、4：2000-5000万、5：5000-1亿、6：一亿以上',
  `valuation` int(11) DEFAULT NULL COMMENT '投资估值   万元',
  `amount` int(11) DEFAULT NULL COMMENT '此次融资金额 万元',
  `sellShares` decimal(4,2) DEFAULT NULL COMMENT '此次出让股份',
  `prospectusUrl` varchar(255) DEFAULT NULL COMMENT '融资计划书URL',
  `status` tinyint(2) DEFAULT NULL COMMENT '状态   0.初审待审核 1.审核成功 路演中 2.审核失败 3.融资中 4.融资成功 5.融资失败',
  `uid` int(11) DEFAULT NULL COMMENT '添加用户的id',
  `projectCity` varchar(255) DEFAULT NULL COMMENT '城市',
  `addTime` int(11) DEFAULT NULL COMMENT '添加时间',
  `endTime` int(11) DEFAULT NULL COMMENT '结束时间',
  `collect` int(11) DEFAULT '0' COMMENT '以募集',
  `attention` int(11) DEFAULT '0' COMMENT '关注数',
  `praise` int(11) DEFAULT '0' COMMENT '点赞数量',
  `is_recommend` tinyint(2) DEFAULT '0' COMMENT '是否推荐',
  `recommend_order` int(11) DEFAULT '0' COMMENT '推荐排序',
  `is_release` tinyint(2) DEFAULT '0' COMMENT '是否发布 0为不发布 1为发布',
  `invest_number` int(11) DEFAULT '0' COMMENT '投资人数',
  `leader_uid` int(11) NOT NULL COMMENT '领头人UID',
  `leader_name` varchar(200) NOT NULL COMMENT '领投人姓名',
  `financing` varchar(2000) DEFAULT NULL COMMENT '融资资料',
  `isShow` tinyint(2) DEFAULT '0' COMMENT '是否展示',
  `maxShareholder` int(11) DEFAULT '0' COMMENT '大东家数量',
  `maxShareholderMoney` int(11) DEFAULT '0' COMMENT '大东家起投金额',
  `minShareholder` int(11) DEFAULT '0' COMMENT '小东家数量',
  `minShareholderMoney` int(11) DEFAULT '0' COMMENT '小东家起投金额',
  `hopeword` text NOT NULL COMMENT '领投人寄语',
  `project_hits` int(11) DEFAULT '0' COMMENT '浏览次数',
  `projectFirstImg` varchar(255) DEFAULT NULL COMMENT '首页图片',
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COMMENT='众筹项目表';

-- ----------------------------
-- Records of pigcms_project
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_project_attention`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_project_attention`;
CREATE TABLE `pigcms_project_attention` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关注id主键自增',
  `project_id` int(11) NOT NULL COMMENT '关注项目id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '关注类型 股权众筹1 产品众筹2 ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='项目关注表';

-- ----------------------------
-- Records of pigcms_project_attention
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_project_notice`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_project_notice`;
CREATE TABLE `pigcms_project_notice` (
  `n_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关注id主键自增',
  `project_id` int(11) NOT NULL COMMENT '项目id',
  `content` varchar(500) NOT NULL COMMENT '内容',
  `contentImg` varchar(255) NOT NULL COMMENT '内容图片',
  `addTime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`n_id`),
  KEY `project_id` (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='项目公告表';

-- ----------------------------
-- Records of pigcms_project_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_project_praise`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_project_praise`;
CREATE TABLE `pigcms_project_praise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '关注类型 1股权众筹 2产品众筹',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='项目点赞表';

-- ----------------------------
-- Records of pigcms_project_praise
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_project_team`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_project_team`;
CREATE TABLE `pigcms_project_team` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团队成员id',
  `project_id` int(11) NOT NULL COMMENT '项目id',
  `teamImg` varchar(255) NOT NULL COMMENT '成员头像',
  `teamName` varchar(50) NOT NULL COMMENT '名称',
  `teamTitle` varchar(100) NOT NULL COMMENT '职位',
  `teamIntroduce` varchar(500) NOT NULL COMMENT '介绍',
  PRIMARY KEY (`team_id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='众筹项目团队成员表';

-- ----------------------------
-- Records of pigcms_project_team
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_promotion_reward_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_promotion_reward_log`;
CREATE TABLE `pigcms_promotion_reward_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_offline_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '线下做单ID',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推广人员id',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作金额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 未处理 1 已处理',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型 0 奖励 + 1 提现 -',
  `reward_rate` decimal(10,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '奖励比率',
  `service_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '当时服务费',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `bak` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `reward_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '推广奖励总额',
  `reward_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '推广奖励可提现总额',
  `send_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '发放奖金方式：1银行转账 2微信 3支付宝 默认0 其他',
  `send_aid` int(11) NOT NULL DEFAULT '0' COMMENT '发送者admin_id',
  PRIMARY KEY (`pigcms_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  KEY `admin_id` (`admin_id`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `order_offline_id` (`order_offline_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_promotion_reward_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_qrcode_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_qrcode_record`;
CREATE TABLE `pigcms_qrcode_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `openid` char(60) NOT NULL COMMENT '身份id',
  `record_time` char(15) NOT NULL COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_qrcode_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_rbac_action`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_rbac_action`;
CREATE TABLE `pigcms_rbac_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `controller_id` varchar(25) DEFAULT NULL COMMENT '控制器ID',
  `action_id` varchar(25) DEFAULT NULL COMMENT '动作ID',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=376 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_rbac_action
-- ----------------------------
INSERT INTO `pigcms_rbac_action` VALUES ('352', '11', 'goods', 'index', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('353', '11', 'goods', 'stockout', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('354', '11', 'goods', 'soldout', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('355', '11', 'goods', 'category', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('356', '11', 'goods', 'product_comment', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('357', '11', 'goods', 'store_comment', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('358', '11', 'goods', 'create', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('359', '11', 'goods', 'edit', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('360', '11', 'goods', 'del_product', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('361', '11', 'goods', 'checkoutProduct', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('362', '11', 'goods', 'goods_category_add', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('363', '11', 'goods', 'goods_category_edit', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('364', '11', 'goods', 'goods_category_delete', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('365', '11', 'goods', 'edit_group', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('366', '11', 'goods', 'save_qrcode_activity', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('367', '11', 'goods', 'get_qrcode_activity', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('368', '11', 'goods', 'del_qrcode_activity', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('369', '11', 'goods', 'del_comment', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('370', '11', 'goods', 'set_comment_status', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('371', '11', 'order', 'add', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('372', '11', 'order', 'orderprint', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('373', '11', 'order', 'check', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('374', '11', 'order', 'package_product', '1464769599', '1464769599');
INSERT INTO `pigcms_rbac_action` VALUES ('375', '11', 'trade', 'income', '1464769599', '1464769599');

-- ----------------------------
-- Table structure for `pigcms_rbac_package`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_rbac_package`;
CREATE TABLE `pigcms_rbac_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '套餐ID',
  `rbac_val` varchar(500) NOT NULL COMMENT '权限控制',
  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_rbac_package
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_recognition`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_recognition`;
CREATE TABLE `pigcms_recognition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `third_type` varchar(30) NOT NULL,
  `third_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `ticket` varchar(200) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_recognition
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_release_point`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_release_point`;
CREATE TABLE `pigcms_release_point` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '每日释放积分总额',
  `users` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发放积分用户数',
  `cash_provision_balance_before` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实时平台备付金(扣除前)',
  `cash_provision_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实时平台备付金',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `add_date` int(8) unsigned NOT NULL COMMENT '日期',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态（1为发放成功，0为未发放或未完全发放）',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='平台释放积分统计';

-- ----------------------------
-- Records of pigcms_release_point
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_release_point_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_release_point_log`;
CREATE TABLE `pigcms_release_point_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `release_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '释放积分id',
  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `add_date` int(8) unsigned NOT NULL,
  `send_point` int(11) unsigned NOT NULL COMMENT '释放平台币点数',
  `point_weight` float(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分权数',
  `user_point_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户积分可用余额',
  `user_point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户积分可总额',
  `point_send_base` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '基数',
  PRIMARY KEY (`pigcms_id`),
  KEY `release_id` (`release_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='平台释放积分日志';

-- ----------------------------
-- Records of pigcms_release_point_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_reply_relation`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reply_relation`;
CREATE TABLE `pigcms_reply_relation` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '[0:文本，1：图文，2：音乐，3：商品，4：商品分类，5：微页面，6：微页面分类，7：店铺主页，8：会员主页]',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_reply_relation
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_reply_tail`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reply_tail`;
CREATE TABLE `pigcms_reply_tail` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `is_open` tinyint(1) NOT NULL COMMENT '是否开启（0：关，1：开）',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_reply_tail
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_return`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_return`;
CREATE TABLE `pigcms_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_no` varchar(50) NOT NULL DEFAULT '' COMMENT '退货单号，分销订单退货单号统一',
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '退货申请时间',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID号',
  `order_no` varchar(50) NOT NULL COMMENT '订单号',
  `order_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '当退货时，记录当时订单表的status',
  `type` tinyint(1) NOT NULL DEFAULT '3' COMMENT '退货类型，1、买/卖双方协商一致，2、买错/多买/不想要，3、商品质量问题，4、未到货品，5、其它',
  `phone` varchar(20) DEFAULT NULL COMMENT '退货人的联系方式',
  `content` varchar(1024) NOT NULL COMMENT '退货说明',
  `images` varchar(1024) DEFAULT NULL COMMENT '图片列表，图片数组序列化',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '申请状态，1：申请中，2：商家审核不通过，3：商家审核通过，4：退货物流，5：退货完成，6：退货取消',
  `cancel_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '商家不同意退款时间',
  `user_cancel_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '取消退货时间',
  `store_content` varchar(1024) DEFAULT NULL COMMENT '商家不同意退款说明',
  `shipping_method` varchar(50) DEFAULT NULL COMMENT '物流方式 express快递发货 selffetch亲自送货',
  `express_code` varchar(50) DEFAULT NULL COMMENT '快递公司代码',
  `express_company` varchar(50) DEFAULT NULL COMMENT '快递公司',
  `express_no` varchar(50) DEFAULT NULL COMMENT '快递单号',
  `address` text COMMENT '收货详细地址',
  `address_user` varchar(20) DEFAULT NULL COMMENT '收货人',
  `address_tel` varchar(20) DEFAULT NULL COMMENT '收货人电话',
  `product_money` float(8,2) DEFAULT '0.00' COMMENT '产品退货的费用',
  `postage_money` float(8,2) DEFAULT '0.00' COMMENT '产品退货的物流费用',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含分销商品 0 否 1是',
  `user_return_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户申请退货单ID，',
  `is_delivered` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '退货商品是否已发货 0 未发货 1 已发货',
  `refund_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 已退款 2 退款取消',
  `refund_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '退款处理时间',
  UNIQUE KEY `id` (`id`),
  KEY `order_id` (`order_id`),
  KEY `user_return_id` (`user_return_id`),
  KEY `store_id` (`store_id`),
  KEY `return_no` (`return_no`,`store_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_return
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_return_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_return_product`;
CREATE TABLE `pigcms_return_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `return_id` int(11) NOT NULL DEFAULT '0' COMMENT '退货单ID',
  `order_product_id` int(11) NOT NULL DEFAULT '0' COMMENT 'order_product表的pigcms_id值',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '产品ID',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '库存ID',
  `sku_data` text COMMENT '库存信息',
  `pro_num` int(11) NOT NULL DEFAULT '1' COMMENT '数量',
  `pro_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购买时的价格',
  `is_packaged` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已打包，0：未打包，1：已打包',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商ID',
  `original_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '源商品ID',
  `discount` double(3,1) NOT NULL DEFAULT '10.0' COMMENT '折扣',
  `user_return_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户退货单ID',
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `order_id` (`order_id`),
  KEY `return_id` (`return_id`),
  KEY `order_product_id` (`order_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_return_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_reward`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reward`;
CREATE TABLE `pigcms_reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) NOT NULL COMMENT '添加时间',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `name` varchar(255) NOT NULL COMMENT '活动名称',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠方式，1：普通优惠，2：多级优惠，每级优惠不累积',
  `is_all` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否所有商品都参与活动，1：全部商品，2：部分商品',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效，1：有效，0：无效，',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`store_id`,`start_time`,`end_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='满减/送表';

-- ----------------------------
-- Records of pigcms_reward
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_reward_condition`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reward_condition`;
CREATE TABLE `pigcms_reward_condition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL COMMENT '满减/送表ID',
  `money` int(11) NOT NULL COMMENT '钱数限制',
  `cash` int(11) NOT NULL DEFAULT '0' COMMENT '减现金，0：表示没有此选项',
  `postage` int(11) NOT NULL DEFAULT '0' COMMENT '免邮费，0：表示没有此选项',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '送积分，0：表示没有此选项',
  `coupon` int(11) NOT NULL DEFAULT '0' COMMENT '送优惠，0：表示没有此选项',
  `present` int(11) NOT NULL DEFAULT '0' COMMENT '送赠品，0：表示没有此选项',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='优惠条件表';

-- ----------------------------
-- Records of pigcms_reward_condition
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_reward_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_reward_product`;
CREATE TABLE `pigcms_reward_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL COMMENT '满减/送表ID',
  `product_id` int(11) NOT NULL COMMENT '产品表ID',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='满减/送产品列表';

-- ----------------------------
-- Records of pigcms_reward_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_rights`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_rights`;
CREATE TABLE `pigcms_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '维权申请时间',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID号',
  `order_no` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '退货类型，1、商品质量问题，2、未到货品，3、其它',
  `phone` varchar(20) DEFAULT NULL COMMENT '维权人的联系方式',
  `content` text COMMENT '维权说明',
  `images` varchar(1024) DEFAULT NULL COMMENT '图片列表，图片数组序列化',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '申请状态，1：申请中，2：维权中，3：维权完成，10：维权取消',
  `user_cancel_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '取消维权时间',
  `complete_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '维权完成时间',
  `platform_content` text COMMENT '维权结果',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含分销商品 0 否 1是',
  `user_rights_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户申请维权单ID',
  UNIQUE KEY `id` (`id`),
  KEY `order_id` (`order_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='维权申请表';

-- ----------------------------
-- Records of pigcms_rights
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_rights_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_rights_product`;
CREATE TABLE `pigcms_rights_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `order_no` varchar(50) NOT NULL COMMENT '订单号',
  `rights_id` int(11) NOT NULL DEFAULT '0' COMMENT '维权单ID',
  `order_product_id` int(11) NOT NULL DEFAULT '0' COMMENT 'order_product表的pigcms_id值',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '产品ID',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '库存ID',
  `sku_data` text COMMENT '库存信息',
  `pro_num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `pro_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购买时的价格',
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商ID',
  `original_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '源商品ID',
  `user_rights_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户退货单ID',
  UNIQUE KEY `id` (`id`),
  KEY `order_id` (`order_id`),
  KEY `rights_id` (`rights_id`),
  KEY `order_product_id` (`order_product_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='维权商品表';

-- ----------------------------
-- Records of pigcms_rights_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_rule`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_rule`;
CREATE TABLE `pigcms_rule` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '规则类型（0：手动添加的，1：系统默认的）',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='规则表';

-- ----------------------------
-- Records of pigcms_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_sale_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_sale_category`;
CREATE TABLE `pigcms_sale_category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '类目id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '类目名称',
  `desc` varchar(1000) NOT NULL DEFAULT '' COMMENT '描述',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '父类id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `order_by` int(10) NOT NULL DEFAULT '0' COMMENT '排序，值小优越',
  `path` varchar(1000) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `parent_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '父类状态',
  `stores` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺数量',
  `cat_pic` varchar(120) NOT NULL COMMENT '图片',
  PRIMARY KEY (`cat_id`),
  KEY `parent_category_id` (`parent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='店铺主营类目';

-- ----------------------------
-- Records of pigcms_sale_category
-- ----------------------------
INSERT INTO `pigcms_sale_category` VALUES ('21', '茶具', '', '0', '1', '0', '0,21', '1', '1', '0', '');
INSERT INTO `pigcms_sale_category` VALUES ('22', '茶叶', '', '0', '1', '0', '0,22', '1', '1', '0', '');

-- ----------------------------
-- Table structure for `pigcms_search_hot`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_search_hot`;
CREATE TABLE `pigcms_search_hot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `url` varchar(500) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `sort` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='热门搜索';

-- ----------------------------
-- Records of pigcms_search_hot
-- ----------------------------
INSERT INTO `pigcms_search_hot` VALUES ('1', '休闲零食', 'http://www.ediancha.com/category/35', '1', '0', '1432971333');
INSERT INTO `pigcms_search_hot` VALUES ('2', '婚庆摄影', 'http://www.ediancha.com/category/14', '1', '0', '1432971431');
INSERT INTO `pigcms_search_hot` VALUES ('3', '茶饮冲调', 'http://www.ediancha.com/category/36', '0', '0', '1432971589');
INSERT INTO `pigcms_search_hot` VALUES ('4', '数码家电', 'http://www.ediancha.com/category/7', '1', '0', '1432975713');
INSERT INTO `pigcms_search_hot` VALUES ('5', '美妆', 'http://www.ediancha.com/category/4', '0', '0', '1432971701');
INSERT INTO `pigcms_search_hot` VALUES ('6', '男装', 'http://www.ediancha.com/category/37', '0', '0', '1432971775');
INSERT INTO `pigcms_search_hot` VALUES ('7', '男鞋', 'http://www.ediancha.com/category/33', '0', '0', '1432971892');

-- ----------------------------
-- Table structure for `pigcms_search_tmp`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_search_tmp`;
CREATE TABLE `pigcms_search_tmp` (
  `md5` varchar(32) NOT NULL COMMENT 'md5系统分类表id字条串，例md5(''1,2,3'')',
  `product_id_str` text COMMENT '满足条件的产品id字符串，每个产品id以逗号分割',
  `expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  UNIQUE KEY `md5` (`md5`) USING BTREE,
  KEY `expire_time` (`expire_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统分类筛选产品临时表';

-- ----------------------------
-- Records of pigcms_search_tmp
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_seckill`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_seckill`;
CREATE TABLE `pigcms_seckill` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '活动名称',
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL COMMENT '秒杀活动商品id',
  `sku_id` int(11) unsigned NOT NULL COMMENT '商品规格id',
  `seckill_price` float(10,2) NOT NULL COMMENT '秒杀价',
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `preset_time` int(11) NOT NULL COMMENT '好友分享提前时间',
  `description` text NOT NULL,
  `is_subscribe` tinyint(1) NOT NULL COMMENT '是否关注公众号',
  `reduce_point` int(11) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL COMMENT '是否删除 0正常  1已删除 ',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '秒杀状态 1 正常 2 失效',
  `sales_volume` int(11) NOT NULL COMMENT '活动商品销量',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `pigcms_id` (`pigcms_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_seckill
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_seckill_share_user`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_seckill_share_user`;
CREATE TABLE `pigcms_seckill_share_user` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seckill_user_id` int(11) unsigned NOT NULL COMMENT '秒杀活动用户id',
  `user_id` int(11) NOT NULL COMMENT '帮助用户id',
  `seckill_id` int(11) unsigned NOT NULL COMMENT '秒杀Id',
  `preset_time` int(11) unsigned NOT NULL COMMENT '提前时间',
  `add_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_seckill_share_user
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_seckill_user`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_seckill_user`;
CREATE TABLE `pigcms_seckill_user` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seckill_user_id` int(11) unsigned NOT NULL COMMENT '参与秒杀的用户',
  `seckill_id` int(11) unsigned NOT NULL COMMENT '秒杀id',
  `preset_time` int(11) unsigned NOT NULL COMMENT '提前秒数',
  `add_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_seckill_user
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_seller_fx_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_seller_fx_product`;
CREATE TABLE `pigcms_seller_fx_product` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商店铺id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商店铺id',
  `source_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '源商品id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  PRIMARY KEY (`pigcms_id`),
  KEY `supplier_id` (`supplier_id`) USING BTREE,
  KEY `seller_id` (`seller_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='分销商分销商品';

-- ----------------------------
-- Records of pigcms_seller_fx_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_service`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_service`;
CREATE TABLE `pigcms_service` (
  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
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
  PRIMARY KEY (`service_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='店铺客服列表';

-- ----------------------------
-- Records of pigcms_service
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_shakelottery`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_shakelottery`;
CREATE TABLE `pigcms_shakelottery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_name` varchar(50) NOT NULL DEFAULT '' COMMENT '活动名称',
  `reply_title` varchar(50) NOT NULL DEFAULT '',
  `reply_content` varchar(200) NOT NULL DEFAULT '',
  `reply_pic` varchar(255) NOT NULL DEFAULT '',
  `action_desc` text NOT NULL COMMENT '活动简介',
  `keyword` varchar(50) NOT NULL DEFAULT '',
  `remind_word` varchar(255) NOT NULL DEFAULT '' COMMENT '广告提示语和链接',
  `remind_link` varchar(255) NOT NULL DEFAULT '' COMMENT '广告语链接',
  `totaltimes` int(11) NOT NULL DEFAULT '1' COMMENT '每人总摇奖次数',
  `everydaytimes` int(11) NOT NULL DEFAULT '0' COMMENT '每人每天摇奖次数',
  `starttime` int(11) NOT NULL COMMENT '活动开始时间',
  `endtime` int(11) NOT NULL COMMENT '活动结束时间',
  `timespan` int(11) NOT NULL COMMENT '每人每次中奖时间间隔',
  `record_nums` int(11) NOT NULL COMMENT '获奖记录显示条数',
  `is_limitwin` int(11) NOT NULL COMMENT '限制每人每天中奖次数',
  `is_follow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '未关注是否可以参与',
  `is_register` tinyint(1) NOT NULL DEFAULT '1',
  `share_count` int(11) NOT NULL COMMENT '转发分享数',
  `custom_sharetitle` varchar(255) NOT NULL COMMENT '自定义分享标题',
  `custom_sharedsc` varchar(500) NOT NULL COMMENT '自定义分享描述',
  `follow_msg` varchar(255) NOT NULL COMMENT '未关注默认提示语',
  `follow_btn_msg` varchar(255) NOT NULL COMMENT '引导关注按钮提示语',
  `register_msg` varchar(255) NOT NULL COMMENT 'register_msg',
  `custom_follow_url` varchar(255) NOT NULL COMMENT 'custom_follow_url',
  `token` varchar(30) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL COMMENT '活动状态1开启,0关闭',
  `join_number` int(11) NOT NULL COMMENT '预计参与人数',
  `actual_join_number` int(11) NOT NULL COMMENT '实际参与人数',
  `other_source` varchar(30) DEFAULT NULL COMMENT '其他活动对接来源',
  `scene_time` int(10) unsigned NOT NULL DEFAULT '0',
  `scene_state` int(10) unsigned NOT NULL DEFAULT '0',
  `is_amount` tinyint(1) NOT NULL COMMENT '手机端是否显示奖品数量',
  `store_id` int(11) NOT NULL COMMENT '店铺ID',
  `integral_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启活动积分玩法',
  `integral_nub` mediumint(7) NOT NULL COMMENT '消耗店铺积分数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_shakelottery
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_shakelottery_prize`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_shakelottery_prize`;
CREATE TABLE `pigcms_shakelottery_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL,
  `prizename` varchar(50) NOT NULL DEFAULT '' COMMENT '奖品名称',
  `prizeimg` varchar(255) NOT NULL DEFAULT '',
  `prizenum` int(11) NOT NULL COMMENT '奖品数量',
  `expendnum` int(11) NOT NULL DEFAULT '0' COMMENT '花掉的奖品数量',
  `provider` varchar(100) NOT NULL DEFAULT '' COMMENT '奖品提供方',
  `token` varchar(30) NOT NULL DEFAULT '',
  `prize_type` tinyint(1) NOT NULL COMMENT '1实物奖品,2优惠券,3店铺积分',
  `hongbao_configure` varchar(800) NOT NULL,
  `sku_id` int(10) NOT NULL COMMENT '库存id',
  `product_id` int(11) NOT NULL COMMENT '产品ID',
  `value` varchar(20) NOT NULL DEFAULT '' COMMENT '奖品名称对应值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COMMENT='奖品表';

-- ----------------------------
-- Records of pigcms_shakelottery_prize
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_shakelottery_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_shakelottery_record`;
CREATE TABLE `pigcms_shakelottery_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL COMMENT '活动ID',
  `user_id` int(11) NOT NULL,
  `prizeid` int(11) NOT NULL COMMENT '奖品ID',
  `prizename` varchar(50) NOT NULL COMMENT '奖品名称',
  `iswin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否中奖',
  `shaketime` int(11) NOT NULL COMMENT '摇奖时间',
  `isaccept` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否领取',
  `accepttime` int(11) NOT NULL COMMENT '领取时间',
  `phone` varchar(15) NOT NULL COMMENT '手机号',
  `wecha_name` char(50) NOT NULL,
  `token` char(30) NOT NULL,
  `prize_type` tinyint(1) NOT NULL,
  `order_id` int(11) NOT NULL COMMENT '订单id 只有实物产品才有',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1706 DEFAULT CHARSET=utf8 COMMENT='摇奖记录表';

-- ----------------------------
-- Records of pigcms_shakelottery_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_shakelottery_users`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_shakelottery_users`;
CREATE TABLE `pigcms_shakelottery_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '参与人标示ID',
  `aid` int(11) NOT NULL,
  `total_shakes` int(11) NOT NULL COMMENT '总的摇奖次数',
  `today_shakes` int(11) NOT NULL COMMENT '今天的摇奖次数',
  `wecha_id` varchar(50) NOT NULL DEFAULT '',
  `wecha_name` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `wecha_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `phone` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  `token` varchar(30) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL COMMENT '登陆的用户id',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COMMENT='参加摇一摇用户表';

-- ----------------------------
-- Records of pigcms_shakelottery_users
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_share_link`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_share_link`;
CREATE TABLE `pigcms_share_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '分享者uid',
  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商店铺ID',
  `open_id` varchar(255) DEFAULT NULL COMMENT '访问者的open_id',
  `user_type` enum('1','0') NOT NULL DEFAULT '0' COMMENT '用户积分状态,0:未加,1:已加',
  `store_type` enum('1','0') NOT NULL DEFAULT '0' COMMENT '店铺积分状态,0:未加,1:已加',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`,`uid`),
  KEY `open_id` (`open_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户分享链接点击表';

-- ----------------------------
-- Records of pigcms_share_link
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_share_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_share_record`;
CREATE TABLE `pigcms_share_record` (
  `share_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '分享得店铺id',
  `key` varchar(150) NOT NULL COMMENT '分享唯一key',
  `uid` int(11) NOT NULL COMMENT '分享者uid',
  `addtime` int(11) NOT NULL COMMENT '分享时间',
  PRIMARY KEY (`share_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分享记录列表';

-- ----------------------------
-- Records of pigcms_share_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_share_visit`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_share_visit`;
CREATE TABLE `pigcms_share_visit` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `openid` varchar(50) NOT NULL DEFAULT '' COMMENT '用户店铺openid',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推广类型 0 分享链接， 1 推广海报',
  `code` varchar(50) NOT NULL DEFAULT '' COMMENT '分享内容代码 store 店铺 page 微页面  product 商品 qrcode 推广海报',
  `visited` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否已访问 0未访问 1已访问 ',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `uid` (`uid`,`store_id`) USING BTREE,
  KEY `openid` (`openid`,`store_id`) USING BTREE,
  KEY `supplier_id` (`supplier_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='推广分享记录表';

-- ----------------------------
-- Records of pigcms_share_visit
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_slider`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_slider`;
CREATE TABLE `pigcms_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `pic` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL,
  `last_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='导航表';

-- ----------------------------
-- Records of pigcms_slider
-- ----------------------------
INSERT INTO `pigcms_slider` VALUES ('1', '2', '餐具', 'http://www.ediancha.com/wap/category.php?keyword=%E9%9B%B6%E9%A3%9F&id=14', 'slider/2015/06/5570f82e5d4ea.png', '0', '1433727140', '1');
INSERT INTO `pigcms_slider` VALUES ('2', '2', '居家', 'http://www.ediancha.com/wap/category.php?keyword=%E5%AE%B6%E7%BA%BA&id=40', 'slider/2015/06/5570f85fc0844.png', '0', '1433727124', '1');
INSERT INTO `pigcms_slider` VALUES ('3', '2', '娱乐', 'http://www.ediancha.com/wap/category.php?keyword=%E9%AA%91%E8%A1%8C%E8%BF%90%E5%8A%A8&id=56', 'slider/2015/06/5570f87bb0b60.png', '0', '1433727106', '1');
INSERT INTO `pigcms_slider` VALUES ('4', '2', '户外', 'http://www.ediancha.com/wap/category.php?keyword=%E8%BF%90%E5%8A%A8%E9%9E%8B%E5%8C%85&id=50', 'slider/2015/06/5570f8b047c7f.png', '0', '1433727067', '1');
INSERT INTO `pigcms_slider` VALUES ('5', '1', '运动鞋包', 'http://www.ediancha.com/category/50', '', '1', '1433395845', '1');
INSERT INTO `pigcms_slider` VALUES ('6', '1', '食品酒水', 'http://www.ediancha.com/category/11', '', '2', '1433572631', '1');
INSERT INTO `pigcms_slider` VALUES ('7', '1', '热卖男鞋', 'http://www.ediancha.com/category/6', '', '3', '1437208910', '1');
INSERT INTO `pigcms_slider` VALUES ('8', '1', '宝宝用品', 'http://www.ediancha.com/category/34', '', '0', '1433495147', '1');
INSERT INTO `pigcms_slider` VALUES ('9', '1', '沐浴洗护', 'http://www.ediancha.com/category/29', '', '0', '1433495177', '1');
INSERT INTO `pigcms_slider` VALUES ('10', '1', '居家百货', 'http://www.ediancha.com/category/39', '', '0', '1433495207', '1');
INSERT INTO `pigcms_slider` VALUES ('11', '1', '电脑数码', 'http://www.ediancha.com/category/64', '', '0', '1433495234', '1');
INSERT INTO `pigcms_slider` VALUES ('12', '1', '手表饰品', 'http://www.ediancha.com/category/75', '', '0', '1437550162', '0');
INSERT INTO `pigcms_slider` VALUES ('13', '1', '汽车用品', 'http://www.ediancha.com/category/79', '', '0', '1437550155', '0');
INSERT INTO `pigcms_slider` VALUES ('14', '1', '服装配件', 'http://www.ediancha.com/category/17', '', '0', '1437550147', '0');
INSERT INTO `pigcms_slider` VALUES ('15', '2', '小吃', 'http://www.ediancha.com/wap/home.php?id=1068', 'slider/2015/07/55b72442a47f3.png', '0', '1438065730', '1');
INSERT INTO `pigcms_slider` VALUES ('16', '2', '汽车', 'http://www.ediancha.com/wap/home.php?id=1687', 'slider/2015/07/55b7250a9ac5c.png', '0', '1438065930', '1');
INSERT INTO `pigcms_slider` VALUES ('17', '2', '户外', 'http://www.ediancha.com/wap/home.php?id=944', 'slider/2015/07/55b7256302c82.png', '0', '1438066018', '1');
INSERT INTO `pigcms_slider` VALUES ('18', '2', '电器', 'http://www.ediancha.com/wap/home.php?id=674', 'slider/2015/07/55b725c472c82.png', '0', '1438066116', '1');

-- ----------------------------
-- Table structure for `pigcms_slider_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_slider_category`;
CREATE TABLE `pigcms_slider_category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` char(20) NOT NULL,
  `cat_key` char(20) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='导航归类表';

-- ----------------------------
-- Records of pigcms_slider_category
-- ----------------------------
INSERT INTO `pigcms_slider_category` VALUES ('1', 'PC端导航', 'pc_nav');
INSERT INTO `pigcms_slider_category` VALUES ('2', '手机端-首页导航', 'wap_index_nav');

-- ----------------------------
-- Table structure for `pigcms_sms_by_code`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_sms_by_code`;
CREATE TABLE `pigcms_sms_by_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `code` int(11) DEFAULT NULL COMMENT '短信验证码',
  `is_use` tinyint(1) DEFAULT '0' COMMENT '是否使用过（0:未使用；1:已使用）',
  `timestamp` int(11) DEFAULT NULL COMMENT '发送的时间戳',
  `last_ip` bigint(20) DEFAULT NULL COMMENT '最后的ip',
  `type` varchar(30) DEFAULT NULL COMMENT '取到验证码类型(reg:注册,forget:找回密码)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_sms_by_code
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_sms_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_sms_record`;
CREATE TABLE `pigcms_sms_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '发送者的uid',
  `store_id` int(11) DEFAULT NULL COMMENT '操作的店铺id',
  `price` smallint(2) NOT NULL DEFAULT '0' COMMENT '短信单价',
  `mobile` varchar(20) DEFAULT NULL COMMENT '发送到的手机号',
  `text` text NOT NULL COMMENT '短信内容',
  `time` int(11) DEFAULT NULL COMMENT '发送的时间戳',
  `last_ip` bigint(20) DEFAULT NULL COMMENT '最后登录的ip',
  `status` varchar(250) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_sms_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_source_material`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_source_material`;
CREATE TABLE `pigcms_source_material` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `it_ids` varchar(500) NOT NULL COMMENT '图文表id集合',
  `store_id` int(10) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL COMMENT '图文类型（0：单图文，1：多图文）',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_source_material
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_sql_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_sql_log`;
CREATE TABLE `pigcms_sql_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `hash` char(40) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `code` smallint(6) NOT NULL DEFAULT '0',
  `exception` text NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=497 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_sql_log
-- ----------------------------
INSERT INTO `pigcms_sql_log` VALUES ('1', '16680', '650dc670face661e50f7dc18392b0b6ce1d6b9d6', '1', '0', '', '1464245416', '1464245416');
INSERT INTO `pigcms_sql_log` VALUES ('2', '16740', '65ee4cae5ba1bef831b2c71e6f3b1bbd716a9432', '0', '0', '', '1464245419', '1464245417');
INSERT INTO `pigcms_sql_log` VALUES ('3', '16800', '0c55b1876b1380f8d635042f240fc6858b62bc91', '1', '0', '', '1464245420', '1464245420');
INSERT INTO `pigcms_sql_log` VALUES ('4', '16860', '934d187e9a73a194cc3ffc60534d1f8945856b4c', '1', '0', '', '1464245421', '1464245421');
INSERT INTO `pigcms_sql_log` VALUES ('5', '16920', 'a64ba61c598ebad6bc5c8d4e6a89b4a896fcddfa', '1', '0', '', '1464245423', '1464245423');
INSERT INTO `pigcms_sql_log` VALUES ('6', '16980', '5d1e00fe77edb7cc4a26a44e089eee4f957cdcd0', '1', '0', '', '1464245424', '1464245424');
INSERT INTO `pigcms_sql_log` VALUES ('7', '17040', 'be1e3490477af49e84246d76c3c86ea390eb3035', '1', '0', '', '1464245426', '1464245426');
INSERT INTO `pigcms_sql_log` VALUES ('8', '17100', 'a52092e5f13d9a571e6f8c5fcc223fecfc0c275b', '1', '0', '', '1464245427', '1464245427');
INSERT INTO `pigcms_sql_log` VALUES ('9', '17160', '191782be5a47a2d40d76ca6d962617401da9afa8', '1', '0', '', '1464245429', '1464245429');
INSERT INTO `pigcms_sql_log` VALUES ('10', '17220', 'dcf436cac2602ea73e717f7caf5be09e07f3db3f', '1', '0', '', '1464245430', '1464245430');
INSERT INTO `pigcms_sql_log` VALUES ('11', '17280', 'ad6d789a10fbae81b848c6026490145601801ae7', '1', '0', '', '1464245432', '1464245432');
INSERT INTO `pigcms_sql_log` VALUES ('12', '17340', 'e64699eb580e2a33b2368a8db68fb692e3e4b54d', '1', '0', '', '1464245433', '1464245433');
INSERT INTO `pigcms_sql_log` VALUES ('13', '17400', '4e53189b4f89164b54b4983438784d2c08cb473b', '1', '0', '', '1464245434', '1464245434');
INSERT INTO `pigcms_sql_log` VALUES ('14', '17460', '7a2afdd550673f3a79580c5a2edda34961eaaf3e', '1', '0', '', '1464245436', '1464245436');
INSERT INTO `pigcms_sql_log` VALUES ('15', '17520', '005d02420879b60a80e6b03fd133549c906e7912', '1', '0', '', '1464245437', '1464245437');
INSERT INTO `pigcms_sql_log` VALUES ('16', '17580', 'dd969bf99b16bebdca4aa1705125b17cdfc20e5f', '1', '0', '', '1464245439', '1464245439');
INSERT INTO `pigcms_sql_log` VALUES ('17', '17640', '21f9545b497f9ac4282496baa2fec3c327b4c80f', '1', '0', '', '1464245440', '1464245440');
INSERT INTO `pigcms_sql_log` VALUES ('18', '17700', 'a005a1a2b2bf87901638e1d3dd3dd945d7b06c84', '1', '0', '', '1464245442', '1464245442');
INSERT INTO `pigcms_sql_log` VALUES ('19', '17760', '6e1193ee8598b62ad22555d54949a51478b50116', '1', '0', '', '1464245443', '1464245443');
INSERT INTO `pigcms_sql_log` VALUES ('20', '17820', 'e2fb1b1bc3ce616988b91c150f2d443172d339b8', '1', '0', '', '1464245444', '1464245444');
INSERT INTO `pigcms_sql_log` VALUES ('21', '17880', '61b9d6d38cf2e7ca904121f2266302af9f56508a', '1', '0', '', '1464245446', '1464245446');
INSERT INTO `pigcms_sql_log` VALUES ('22', '17940', 'a53996b07f01be375c20452ea5bf4fc303549603', '1', '0', '', '1464245447', '1464245447');
INSERT INTO `pigcms_sql_log` VALUES ('23', '18120', 'd66fefd921119526f22066a851c52a0b5f3af018', '1', '0', '', '1464245449', '1464245449');
INSERT INTO `pigcms_sql_log` VALUES ('24', '18180', 'eafed32f623f21b7af025272f5c2b9d902d89dcc', '1', '0', '', '1464245450', '1464245450');
INSERT INTO `pigcms_sql_log` VALUES ('25', '18240', 'ea8eb29fce10856a6ae3b551470a81064b624543', '1', '0', '', '1464245452', '1464245452');
INSERT INTO `pigcms_sql_log` VALUES ('26', '18360', '96edf0a98ca9f225bc95eeae823568cec97c1df0', '1', '0', '', '1464245453', '1464245453');
INSERT INTO `pigcms_sql_log` VALUES ('27', '18420', 'cb55b1658ad8003b300106333e5ee41ec3e2f944', '1', '0', '', '1464245454', '1464245454');
INSERT INTO `pigcms_sql_log` VALUES ('28', '18480', '0c590425eba8593f5beb567d5cbbdb6cbb08b97a', '1', '0', '', '1464245456', '1464245456');
INSERT INTO `pigcms_sql_log` VALUES ('29', '18540', '854a7730d6dd54ceaa19b93915df5eb3e1ed2fee', '1', '0', '', '1464245457', '1464245457');
INSERT INTO `pigcms_sql_log` VALUES ('30', '18660', '9de83f51f28fe0e445b848bc624aae41b60178b5', '1', '0', '', '1464245459', '1464245459');
INSERT INTO `pigcms_sql_log` VALUES ('31', '18720', '3baf20a09ae17735949b1d9d1ee6ca9b70f3124b', '1', '0', '', '1464245460', '1464245460');
INSERT INTO `pigcms_sql_log` VALUES ('32', '18780', '530bb7efb4787eb0d0aada42460664f4ed61b0a5', '1', '0', '', '1464245462', '1464245462');
INSERT INTO `pigcms_sql_log` VALUES ('33', '18900', '530bb7efb4787eb0d0aada42460664f4ed61b0a5', '0', '0', '', '1464245465', '1464245463');
INSERT INTO `pigcms_sql_log` VALUES ('34', '18960', '5d553f5984fbdd696fdbce615403bf4a548e28e7', '1', '0', '', '1464245468', '1464245468');
INSERT INTO `pigcms_sql_log` VALUES ('35', '19080', 'ac53ca3dcc00a1a11d9e7732c40481186bddc792', '0', '0', '', '1464245471', '1464245469');
INSERT INTO `pigcms_sql_log` VALUES ('36', '19140', 'cc476772d14f9e5306a385029771efdc29502656', '1', '0', '', '1464245472', '1464245472');
INSERT INTO `pigcms_sql_log` VALUES ('37', '19200', '4d982a9317a4908d3887a5a00c6ff897ed72e3d8', '1', '0', '', '1464245474', '1464245474');
INSERT INTO `pigcms_sql_log` VALUES ('38', '19260', '034df31a92660cf1f753e33c27a23df3c3b96dcc', '1', '0', '', '1464245476', '1464245476');
INSERT INTO `pigcms_sql_log` VALUES ('39', '19320', '85fd77694469e57821fc2d958c83e5fd452645cb', '1', '0', '', '1464245477', '1464245477');
INSERT INTO `pigcms_sql_log` VALUES ('40', '19800', '0d5c5d4da509a3f3121d587ac577f0f2fd435ebb', '1', '0', '', '1464245479', '1464245479');
INSERT INTO `pigcms_sql_log` VALUES ('41', '19860', 'f3390db4c95e836fd361d948b8ffa6c7c815ca38', '1', '0', '', '1464245480', '1464245480');
INSERT INTO `pigcms_sql_log` VALUES ('42', '19920', 'e6dcf916a337cc5ce651c68ef47d6092c55f38ad', '1', '0', '', '1464245482', '1464245482');
INSERT INTO `pigcms_sql_log` VALUES ('43', '19980', '5bf2a29e8b7a19a8dfde9816e90a4b6c00619c0f', '1', '0', '', '1464245483', '1464245483');
INSERT INTO `pigcms_sql_log` VALUES ('44', '20040', '16edc32b28d994010cf77b397973c228dbafe340', '1', '0', '', '1464245485', '1464245485');
INSERT INTO `pigcms_sql_log` VALUES ('45', '20100', 'ef5d8e374678af0a127255a8d830b1096c7438cc', '1', '0', '', '1464245486', '1464245486');
INSERT INTO `pigcms_sql_log` VALUES ('46', '20220', '695a1fa8d1036a598fe2234db731cbaaf34fa2c6', '1', '0', '', '1464245487', '1464245487');
INSERT INTO `pigcms_sql_log` VALUES ('47', '20280', '2f08ab75dcfc5dad57d28fd6e112cb848eb8b4a2', '1', '0', '', '1464245489', '1464245489');
INSERT INTO `pigcms_sql_log` VALUES ('48', '20340', 'bc753e41e912fd27a3a0f53509b6fec3c8133883', '1', '0', '', '1464245490', '1464245490');
INSERT INTO `pigcms_sql_log` VALUES ('49', '20400', '426c44240c474afb90fc49dac0b0edf04d944570', '1', '0', '', '1464245492', '1464245492');
INSERT INTO `pigcms_sql_log` VALUES ('50', '20460', '3f96984f30fb692de511584eac4fa2b30edffce8', '1', '0', '', '1464245493', '1464245493');
INSERT INTO `pigcms_sql_log` VALUES ('51', '20520', '55a4f4b4bfb079ce9e08209aeafe1cb66062bfe9', '1', '0', '', '1464245494', '1464245494');
INSERT INTO `pigcms_sql_log` VALUES ('52', '20580', '4cd8faebff7b7c1f559a544c88d460db1f28074b', '1', '0', '', '1464245496', '1464245496');
INSERT INTO `pigcms_sql_log` VALUES ('53', '20640', '5a8db84811592330c5a3afb45aa372282cb5fc49', '1', '0', '', '1464245497', '1464245497');
INSERT INTO `pigcms_sql_log` VALUES ('54', '20700', 'b4bba3c9f5b0ebd304cd04d4222333219438526a', '1', '0', '', '1464245499', '1464245499');
INSERT INTO `pigcms_sql_log` VALUES ('55', '20760', '48189569f183407282821c62112814322c3649eb', '1', '0', '', '1464245500', '1464245500');
INSERT INTO `pigcms_sql_log` VALUES ('56', '20880', 'fc25f095024fd942ddd2c44050856ad71a4b8283', '1', '0', '', '1464245502', '1464245502');
INSERT INTO `pigcms_sql_log` VALUES ('57', '20940', 'bedb025fe66ba98b9837b2d945ea077d4dfbbf55', '1', '0', '', '1464245504', '1464245504');
INSERT INTO `pigcms_sql_log` VALUES ('58', '21180', '35b9929e7626f928a7cc1cb9798cb922014dc074', '1', '0', '', '1464245506', '1464245506');
INSERT INTO `pigcms_sql_log` VALUES ('59', '21240', 'b19c20f53d7cdaf2d02be159a5fff46b4f71ecb1', '1', '0', '', '1464245508', '1464245508');
INSERT INTO `pigcms_sql_log` VALUES ('60', '21300', '801bb4378908eda6c9240dfc800b45ff19a42539', '1', '0', '', '1464245510', '1464245510');
INSERT INTO `pigcms_sql_log` VALUES ('61', '21360', '0c0089d37ab982732f36cb8a1dd2fd961841bafc', '1', '0', '', '1464245512', '1464245512');
INSERT INTO `pigcms_sql_log` VALUES ('62', '21660', '3aac918cdd37306dfe58d1cfc0c0cdca1d3333a4', '1', '0', '', '1464245515', '1464245515');
INSERT INTO `pigcms_sql_log` VALUES ('63', '21720', 'c50cb28f840b3599b61e622b8687d3dde23e36d7', '1', '0', '', '1464245517', '1464245517');
INSERT INTO `pigcms_sql_log` VALUES ('64', '21840', 'a34a51b1132495fc261042bbd5a216867cf530e2', '1', '0', '', '1464245519', '1464245519');
INSERT INTO `pigcms_sql_log` VALUES ('65', '21900', 'c243cbbf7a1a2712327c548a32115106fe858a9f', '1', '0', '', '1464245521', '1464245521');
INSERT INTO `pigcms_sql_log` VALUES ('66', '21960', '008502b23313beadb09e3743db30f8b5d22ef179', '1', '0', '', '1464245523', '1464245523');
INSERT INTO `pigcms_sql_log` VALUES ('67', '22020', '96ea7e530abc2c52bbb45a288314be494e2b56b6', '1', '0', '', '1464245525', '1464245525');
INSERT INTO `pigcms_sql_log` VALUES ('68', '22080', '64d8e58bea806b472d7059265ba16c3b5b863af9', '1', '0', '', '1464245527', '1464245527');
INSERT INTO `pigcms_sql_log` VALUES ('69', '22140', 'c5d147ac4607c7e3fa4ebdca860bda3da6c6741c', '1', '0', '', '1464245529', '1464245529');
INSERT INTO `pigcms_sql_log` VALUES ('70', '22200', 'b9fcef65a1222cfc75459f6615605f67f0d76422', '1', '0', '', '1464245531', '1464245531');
INSERT INTO `pigcms_sql_log` VALUES ('71', '22260', 'eaeeac71efc8726903607134460513ba6ec8b032', '1', '0', '', '1464245533', '1464245533');
INSERT INTO `pigcms_sql_log` VALUES ('72', '22320', '821682ee72bd4dfd4e8266f243d88db76c30f48d', '1', '0', '', '1464245535', '1464245535');
INSERT INTO `pigcms_sql_log` VALUES ('73', '22380', '1d5e2e081098d61b56c824ea69e34adc4c82291e', '1', '0', '', '1464245537', '1464245537');
INSERT INTO `pigcms_sql_log` VALUES ('74', '22440', '54f05d4c2e2e29b1f30e56ea561770bc0b48c664', '1', '0', '', '1464245539', '1464245539');
INSERT INTO `pigcms_sql_log` VALUES ('75', '22500', '583be735488545ffa65c0a8a248aead570107881', '1', '0', '', '1464245541', '1464245541');
INSERT INTO `pigcms_sql_log` VALUES ('76', '22560', '1599fe2d1cbd93c73098f36abc197157362063ae', '1', '0', '', '1464245543', '1464245543');
INSERT INTO `pigcms_sql_log` VALUES ('77', '22620', '59b988fe8e2a8336de837d2ff285c2248be4d077', '1', '0', '', '1464245545', '1464245545');
INSERT INTO `pigcms_sql_log` VALUES ('78', '22680', 'c69017144d386e27253783a40364ab320126acaf', '1', '0', '', '1464245547', '1464245547');
INSERT INTO `pigcms_sql_log` VALUES ('79', '23220', '91f4e4d2d6daa3d8910e7ab50d61199663843ad8', '1', '0', '', '1464245549', '1464245549');
INSERT INTO `pigcms_sql_log` VALUES ('80', '23280', 'e39c259680cdaf85dcc7d361db72e7a8b40b9aed', '1', '0', '', '1464245551', '1464245551');
INSERT INTO `pigcms_sql_log` VALUES ('81', '23340', '1aa3a2e5a45ae130e74e9a7e8f826d708a31db4e', '1', '0', '', '1464245553', '1464245553');
INSERT INTO `pigcms_sql_log` VALUES ('82', '23460', '7909bb968e73b21948a2d57044ab0324d7248c66', '1', '0', '', '1464245555', '1464245555');
INSERT INTO `pigcms_sql_log` VALUES ('83', '23520', 'f8a43b2e9cf4115426bc3a4d8b52e042165a9290', '1', '0', '', '1464245557', '1464245557');
INSERT INTO `pigcms_sql_log` VALUES ('84', '23580', '8f493e65973e7351666d5fc8e8954126606eb3b7', '1', '0', '', '1464245559', '1464245559');
INSERT INTO `pigcms_sql_log` VALUES ('85', '23640', '9d9c093a414be51a41563328246414b46f0ffbef', '1', '0', '', '1464245561', '1464245561');
INSERT INTO `pigcms_sql_log` VALUES ('86', '23700', '7f1dd80004c464c3a04af0c76606baa5938a42e5', '1', '0', '', '1464245563', '1464245563');
INSERT INTO `pigcms_sql_log` VALUES ('87', '23760', 'dc220d9fafabb4204ca9f5dd878a8676b2ffbbf7', '1', '0', '', '1464245565', '1464245565');
INSERT INTO `pigcms_sql_log` VALUES ('88', '23820', '8b72a3c654b0a6402ba31964720cec9283e11a7c', '1', '0', '', '1464245567', '1464245567');
INSERT INTO `pigcms_sql_log` VALUES ('89', '23880', '05f267be2f4752a84a5216c2625cf557b796f7bd', '1', '0', '', '1464245569', '1464245569');
INSERT INTO `pigcms_sql_log` VALUES ('90', '24000', '511e403ea199d37113358989c8035018d41911bb', '1', '0', '', '1464245571', '1464245571');
INSERT INTO `pigcms_sql_log` VALUES ('91', '24060', 'a96fc3366442bb407f437d689e8173f9b3f749a6', '1', '0', '', '1464245573', '1464245573');
INSERT INTO `pigcms_sql_log` VALUES ('92', '24180', '108102a271bf8494b82044b18a608eb81b6fcb12', '0', '0', '', '1464245578', '1464245575');
INSERT INTO `pigcms_sql_log` VALUES ('93', '24240', 'c2d3455867644eaa8e76c1eac97144ef1dd336eb', '1', '0', '', '1464245579', '1464245579');
INSERT INTO `pigcms_sql_log` VALUES ('94', '24300', '07e07b50a352df48a9c1979c41fbc481042d9a68', '1', '0', '', '1464245581', '1464245581');
INSERT INTO `pigcms_sql_log` VALUES ('95', '24420', '17f1be214feaffeb9e82f87000007d7a3d3faf60', '1', '0', '', '1464245583', '1464245583');
INSERT INTO `pigcms_sql_log` VALUES ('96', '24480', 'ff897481c43b79edd86b2bc834a5db413609981f', '0', '0', '', '1464245587', '1464245585');
INSERT INTO `pigcms_sql_log` VALUES ('97', '24540', '277d2bfbb558035f85b9b3bfe0d7ced952d2febf', '0', '0', '', '1464245592', '1464245589');
INSERT INTO `pigcms_sql_log` VALUES ('98', '24660', '8b618b140299433e67cc6538e851719ae1a1e91f', '1', '0', '', '1464245593', '1464245593');
INSERT INTO `pigcms_sql_log` VALUES ('99', '24720', '33774580cfc27d5f462c8e98773113b728091933', '1', '0', '', '1464245595', '1464245595');
INSERT INTO `pigcms_sql_log` VALUES ('100', '24780', '49daec100248c0bd75edc3b3c80fbe1083843d64', '1', '0', '', '1464245598', '1464245598');
INSERT INTO `pigcms_sql_log` VALUES ('101', '24840', '015095017107f17dbf1a7a7d0fc48ce6cd20db28', '1', '0', '', '1464245599', '1464245599');
INSERT INTO `pigcms_sql_log` VALUES ('102', '24900', 'ea8873f22147c29bcb6eb3399506144b2a298c6b', '1', '0', '', '1464245601', '1464245601');
INSERT INTO `pigcms_sql_log` VALUES ('103', '24960', '9b1a27c357a9227fa1902b6285112942a84cdd40', '1', '0', '', '1464245603', '1464245603');
INSERT INTO `pigcms_sql_log` VALUES ('104', '25080', '7ebe48aab16983568be26b7d2824fa3b6e016b53', '1', '0', '', '1464245605', '1464245605');
INSERT INTO `pigcms_sql_log` VALUES ('105', '25140', '16989707492c1911585c20cc151a2b8b07170e1b', '1', '0', '', '1464245607', '1464245607');
INSERT INTO `pigcms_sql_log` VALUES ('106', '25200', '72a2967c326623ce7adb67ad121ccf42d5514480', '1', '0', '', '1464245609', '1464245609');
INSERT INTO `pigcms_sql_log` VALUES ('107', '25260', '4d25795a69c8836dc369b206a8042b458a351709', '0', '0', '', '1464245613', '1464245612');
INSERT INTO `pigcms_sql_log` VALUES ('108', '25320', 'd7765edc0b12c70e3b78388dcc78239b6423bdfb', '1', '0', '', '1464245615', '1464245615');
INSERT INTO `pigcms_sql_log` VALUES ('109', '25440', 'ee6e420ab8e3f72eb09ef911f0085e8f30648329', '1', '0', '', '1464245617', '1464245617');
INSERT INTO `pigcms_sql_log` VALUES ('110', '25560', '029318c2d9ab4b34f87aab78494697fc321270f0', '1', '0', '', '1464245619', '1464245619');
INSERT INTO `pigcms_sql_log` VALUES ('111', '25620', '7d950cb7c9fc80a5112ceb91da0d90d75cfe3c98', '1', '0', '', '1464245621', '1464245621');
INSERT INTO `pigcms_sql_log` VALUES ('112', '25680', '40a117c4c23451e443aa45265724bb8004714ac2', '1', '0', '', '1464245623', '1464245623');
INSERT INTO `pigcms_sql_log` VALUES ('113', '25740', '7d053b4362956afd0042b3e2ff9c0f85b3bd4da5', '1', '0', '', '1464245625', '1464245625');
INSERT INTO `pigcms_sql_log` VALUES ('114', '25800', '47a36bdc39d74435f44e27f4ead62258c26c75b3', '1', '0', '', '1464245627', '1464245627');
INSERT INTO `pigcms_sql_log` VALUES ('115', '25860', '8bf921ac384a6adcd71ad9be276830addc4d64f6', '1', '0', '', '1464245629', '1464245629');
INSERT INTO `pigcms_sql_log` VALUES ('116', '25920', 'a29877aa975b773eefd11a2f88fc526dc5ef5064', '1', '0', '', '1464245631', '1464245631');
INSERT INTO `pigcms_sql_log` VALUES ('117', '25980', 'b73602dca818f048bcda6d9296203c313d770b83', '1', '0', '', '1464245633', '1464245633');
INSERT INTO `pigcms_sql_log` VALUES ('118', '26040', '0bb69185e56e9ab0cf9f008ee62ebeb32b67864d', '1', '0', '', '1464245637', '1464245637');
INSERT INTO `pigcms_sql_log` VALUES ('119', '26100', '34c91747607264880b74f4e33bc89c826ba74fd4', '0', '0', '', '1464245641', '1464245639');
INSERT INTO `pigcms_sql_log` VALUES ('120', '26160', 'c4bc9b972dcc7b11ae756de3ba9c60d934034d41', '1', '0', '', '1464245643', '1464245643');
INSERT INTO `pigcms_sql_log` VALUES ('121', '26220', 'e8a24a194f97d975e780df698a4c7afdc50535d5', '1', '0', '', '1464245645', '1464245645');
INSERT INTO `pigcms_sql_log` VALUES ('122', '26280', '336ae157353608dc7fffad739a6bce8d25ad381f', '1', '0', '', '1464245647', '1464245647');
INSERT INTO `pigcms_sql_log` VALUES ('123', '26340', '47961ba2b7cedf8cb67b868a7388aecb9b0ea6c2', '1', '0', '', '1464245649', '1464245649');
INSERT INTO `pigcms_sql_log` VALUES ('124', '26400', '4787fcfeb22320d65796fd60769e76d1f7702414', '1', '0', '', '1464245651', '1464245651');
INSERT INTO `pigcms_sql_log` VALUES ('125', '26460', 'c1cf321c9789dafe9438809fae9f657e22f7c11e', '1', '0', '', '1464245653', '1464245653');
INSERT INTO `pigcms_sql_log` VALUES ('126', '26580', '89feaf22fdb471522f8d7c13159b29f889b93696', '1', '0', '', '1464245655', '1464245655');
INSERT INTO `pigcms_sql_log` VALUES ('127', '26640', 'ee3e4fcc56b20a36c645142fa9ea14d69bcbbd4e', '1', '0', '', '1464245657', '1464245657');
INSERT INTO `pigcms_sql_log` VALUES ('128', '26700', '15892ad0301e230d950ed1f13e0acd76037d2d8b', '1', '0', '', '1464245659', '1464245659');
INSERT INTO `pigcms_sql_log` VALUES ('129', '26760', '6feec2f214548b8abf7d3d3fb2db0843ef24beef', '1', '0', '', '1464245661', '1464245661');
INSERT INTO `pigcms_sql_log` VALUES ('130', '26820', '93465d86c5360970279ddf4bd86517f74582e6e4', '1', '0', '', '1464245663', '1464245663');
INSERT INTO `pigcms_sql_log` VALUES ('131', '26880', 'c486e723634e519c3e6b2063bda2bf602b6defaa', '1', '0', '', '1464245665', '1464245665');
INSERT INTO `pigcms_sql_log` VALUES ('132', '27000', '8bd8ca913544f80062ce2585cc7da896ae4f4d2b', '1', '0', '', '1464245667', '1464245667');
INSERT INTO `pigcms_sql_log` VALUES ('133', '27060', '21e99dc0e40b37e7af3a8d8fc5ed60c2bedc1ba8', '1', '0', '', '1464245669', '1464245669');
INSERT INTO `pigcms_sql_log` VALUES ('134', '27120', '4ebba7435b54c14acdab1686f74c849b0d0d91a0', '0', '0', '', '1464245673', '1464245672');
INSERT INTO `pigcms_sql_log` VALUES ('135', '27180', '5a7b579a3530b34c09aaf6f9f5ba3f29fd00363f', '1', '0', '', '1464245674', '1464245674');
INSERT INTO `pigcms_sql_log` VALUES ('136', '27240', '6806fcee8207c02ef3526698441bd7552c66ef31', '1', '0', '', '1464245676', '1464245676');
INSERT INTO `pigcms_sql_log` VALUES ('137', '27300', 'b689bbbec7dca31e243b3f120e38719f8ca4bf36', '1', '0', '', '1464245677', '1464245677');
INSERT INTO `pigcms_sql_log` VALUES ('138', '27360', '7da829fc5b88c7dce00189c3962e2d6589a90725', '1', '0', '', '1464245679', '1464245679');
INSERT INTO `pigcms_sql_log` VALUES ('139', '27420', 'c4bc9b972dcc7b11ae756de3ba9c60d934034d41', '0', '0', '', '1464245682', '1464245680');
INSERT INTO `pigcms_sql_log` VALUES ('140', '27480', 'e8a24a194f97d975e780df698a4c7afdc50535d5', '0', '0', '', '1464245684', '1464245683');
INSERT INTO `pigcms_sql_log` VALUES ('141', '27540', '336ae157353608dc7fffad739a6bce8d25ad381f', '1', '0', '', '1464245686', '1464245686');
INSERT INTO `pigcms_sql_log` VALUES ('142', '27600', '1dd02934932bacef03f4e216c88ad171de2bc087', '1', '0', '', '1464245687', '1464245687');
INSERT INTO `pigcms_sql_log` VALUES ('143', '27660', '9aebd7253a3396cac9765405185b5c783778f64a', '1', '0', '', '1464245690', '1464245690');
INSERT INTO `pigcms_sql_log` VALUES ('144', '27720', 'd63add671e23532e3d040d984c052ba551f6c845', '1', '0', '', '1464245691', '1464245691');
INSERT INTO `pigcms_sql_log` VALUES ('145', '27780', 'e9cb3eeb261159abab7bfd42815b4d1e986b0144', '0', '0', '', '1464245694', '1464245693');
INSERT INTO `pigcms_sql_log` VALUES ('146', '27840', 'b6d220ab68913236adcb7bb05e4ac2788e2ce1ae', '0', '0', '', '1464245697', '1464245696');
INSERT INTO `pigcms_sql_log` VALUES ('147', '27900', '888539ea8db8d80715aeacd68d69021efd6df7da', '1', '0', '', '1464245699', '1464245699');
INSERT INTO `pigcms_sql_log` VALUES ('148', '27960', '6d02f7a32dd3f627d28a3753deb7063b4b655ffa', '1', '0', '', '1464245700', '1464245700');
INSERT INTO `pigcms_sql_log` VALUES ('149', '28020', '177fb242949f03fed3173a603056a8d73841748e', '1', '0', '', '1464245701', '1464245701');
INSERT INTO `pigcms_sql_log` VALUES ('150', '28080', 'cca9daa767fc7d73f0dd6f34fdb8096919f34614', '1', '0', '', '1464245703', '1464245703');
INSERT INTO `pigcms_sql_log` VALUES ('151', '28140', '697cd10e702b4810cdcf811baea3a6747539c517', '0', '0', '', '1464245706', '1464245704');
INSERT INTO `pigcms_sql_log` VALUES ('152', '28200', 'dd88f87b7f805eb0f5c73c3e3aacc06d4f374881', '1', '0', '', '1464245707', '1464245707');
INSERT INTO `pigcms_sql_log` VALUES ('153', '28320', 'd89c35f3d16d06868de46d6275d330c6e89e95ae', '1', '0', '', '1464245708', '1464245708');
INSERT INTO `pigcms_sql_log` VALUES ('154', '28380', 'b7cf15035bf940fdb5eff4aa8282b98e7ab13b04', '1', '0', '', '1464245710', '1464245710');
INSERT INTO `pigcms_sql_log` VALUES ('155', '28440', 'bc6b1a337b4eafceaf05807c86926ee593b2e0eb', '1', '0', '', '1464245711', '1464245711');
INSERT INTO `pigcms_sql_log` VALUES ('156', '28500', 'a5ee286d763cf429e1b14d77a85f3aeca1d6fab6', '1', '0', '', '1464245713', '1464245713');
INSERT INTO `pigcms_sql_log` VALUES ('157', '28560', 'a0d48f5ab03317d5c64ed070248c1ade04074bf6', '1', '0', '', '1464245714', '1464245714');
INSERT INTO `pigcms_sql_log` VALUES ('158', '28620', '4b2bf4eb8e33310791398988d0760cd07327a1be', '1', '0', '', '1464245716', '1464245716');
INSERT INTO `pigcms_sql_log` VALUES ('159', '28680', '52baef49ab309240bb4f5e6430e5bd362317437b', '1', '0', '', '1464245717', '1464245717');
INSERT INTO `pigcms_sql_log` VALUES ('160', '28740', '71179a61d66582a27eb2f7fd4aaae7d90a52c9d5', '1', '0', '', '1464245719', '1464245719');
INSERT INTO `pigcms_sql_log` VALUES ('161', '28800', '8f65e3912afd7c0e800b56a52123be247a09a5b6', '1', '0', '', '1464245720', '1464245720');
INSERT INTO `pigcms_sql_log` VALUES ('162', '28860', 'a42152f868e2103c86ae75b7515c8b63392015c4', '1', '0', '', '1464245721', '1464245721');
INSERT INTO `pigcms_sql_log` VALUES ('163', '28980', 'df7333c5eee440022880c5596a10e30616b13e7c', '1', '0', '', '1464245723', '1464245723');
INSERT INTO `pigcms_sql_log` VALUES ('164', '29040', '176d16c26d62064ed5e272118e36720429e66c34', '1', '0', '', '1464245724', '1464245724');
INSERT INTO `pigcms_sql_log` VALUES ('165', '29100', 'f48f8a8e3df8d66f0b7369f58da85696e1b1b465', '1', '0', '', '1464245726', '1464245726');
INSERT INTO `pigcms_sql_log` VALUES ('166', '29160', '9d0b7f08d9dc6e7075ddbf29fb6b11624b1d3f32', '1', '0', '', '1464245727', '1464245727');
INSERT INTO `pigcms_sql_log` VALUES ('167', '29220', '623d7e57ffecefec6f5d1eafd95e3879ec7a8822', '1', '0', '', '1464245729', '1464245729');
INSERT INTO `pigcms_sql_log` VALUES ('168', '29280', 'e52c8a3f8170bd08a72dd20521a144d02902363d', '1', '0', '', '1464245730', '1464245730');
INSERT INTO `pigcms_sql_log` VALUES ('169', '29340', '322d8035332cfed55f9f4a86d5d5862d7b9eb9b0', '1', '0', '', '1464245732', '1464245732');
INSERT INTO `pigcms_sql_log` VALUES ('170', '29400', '4dbb3dd6c659db513f3894bf0cd5f02045cd29eb', '1', '0', '', '1464245735', '1464245734');
INSERT INTO `pigcms_sql_log` VALUES ('171', '29460', 'e633b9143b3b1cfb91fd2fbaedd34269462f68b4', '1', '0', '', '1464245736', '1464245736');
INSERT INTO `pigcms_sql_log` VALUES ('172', '29520', '00de4654504b96679e8e3a47c2fd3a48c154237f', '1', '0', '', '1464245738', '1464245738');
INSERT INTO `pigcms_sql_log` VALUES ('173', '29580', '272c33fe468d59532398e17483e4a116619a1e23', '1', '0', '', '1464245740', '1464245740');
INSERT INTO `pigcms_sql_log` VALUES ('174', '29700', '255a2eef1904c57f2b720ff26341532d69320075', '1', '0', '', '1464245742', '1464245742');
INSERT INTO `pigcms_sql_log` VALUES ('175', '29760', '1c6781b26801cac3c7b8a33d66aee2f1802a3d99', '1', '0', '', '1464245745', '1464245745');
INSERT INTO `pigcms_sql_log` VALUES ('176', '29820', 'c712035b4d51d0d5d53f9002258c64334ca8bf0a', '1', '0', '', '1464245746', '1464245746');
INSERT INTO `pigcms_sql_log` VALUES ('177', '29880', 'b026a3ede0133812f4d2061e637bf621bbc6ef4e', '1', '0', '', '1464245748', '1464245748');
INSERT INTO `pigcms_sql_log` VALUES ('178', '29940', 'e5f50670b6f793d158b1db52aed97644d5dd231d', '1', '0', '', '1464245750', '1464245750');
INSERT INTO `pigcms_sql_log` VALUES ('179', '30000', 'fc8ea8f7bc48efd437acee1811995f1d25bf6bd6', '1', '0', '', '1464245752', '1464245752');
INSERT INTO `pigcms_sql_log` VALUES ('180', '30060', '8055730c1dc63693a04e58e88968d25d531df259', '1', '0', '', '1464245754', '1464245754');
INSERT INTO `pigcms_sql_log` VALUES ('181', '30120', '507cb372e498bb586c8a9edf63a69701010767bd', '1', '0', '', '1464245756', '1464245756');
INSERT INTO `pigcms_sql_log` VALUES ('182', '30180', '2fc8129f2ed7b5725435a149e30784994e6bb508', '1', '0', '', '1464245760', '1464245760');
INSERT INTO `pigcms_sql_log` VALUES ('183', '30240', '4a61c71871b1779732f42f63a7bf6e4ff7bfaa5a', '1', '0', '', '1464245762', '1464245762');
INSERT INTO `pigcms_sql_log` VALUES ('184', '30300', '1132873633ab09778fddce462a877e397f854da7', '1', '0', '', '1464245764', '1464245764');
INSERT INTO `pigcms_sql_log` VALUES ('185', '30360', 'db8270b08bebd84d833a16510a2a823c3bd0912f', '1', '0', '', '1464245766', '1464245766');
INSERT INTO `pigcms_sql_log` VALUES ('186', '30420', '3b8df7008dab426bf6b4e1e562dea9698c16c186', '1', '0', '', '1464245768', '1464245768');
INSERT INTO `pigcms_sql_log` VALUES ('187', '30480', 'c74298db5c3a889a09cf50e5e0aaf4da7a82855f', '1', '0', '', '1464245770', '1464245770');
INSERT INTO `pigcms_sql_log` VALUES ('188', '30540', '31a050b45c20c7213c8d0b295bde0858380146fd', '1', '0', '', '1464245773', '1464245773');
INSERT INTO `pigcms_sql_log` VALUES ('189', '30780', '3fe4ed7e2a72fcb70bd3da34813c18e2d52dd2b6', '1', '0', '', '1464245774', '1464245774');
INSERT INTO `pigcms_sql_log` VALUES ('190', '30840', '740c09bd889f1ead7818ad8a857b69480121563c', '1', '0', '', '1464245776', '1464245776');
INSERT INTO `pigcms_sql_log` VALUES ('191', '30900', '10a760550444164528083a8c91e0434e92f34526', '1', '0', '', '1464245778', '1464245778');
INSERT INTO `pigcms_sql_log` VALUES ('192', '30960', 'ffc76a7c385f0c3cdf2e15c699d0dbea5965307f', '1', '0', '', '1464245780', '1464245780');
INSERT INTO `pigcms_sql_log` VALUES ('193', '31020', 'a7948a4ff8afaf9f43c1f36a97e15f21bab13055', '1', '0', '', '1464245782', '1464245782');
INSERT INTO `pigcms_sql_log` VALUES ('194', '31080', '6e4af02a4bc693b4ff3842e46b8a399cb27e2173', '1', '0', '', '1464245784', '1464245784');
INSERT INTO `pigcms_sql_log` VALUES ('195', '31140', 'a5621c3138c5d6ac3cee5cddebaa12b1aede8808', '1', '0', '', '1464245786', '1464245786');
INSERT INTO `pigcms_sql_log` VALUES ('196', '31200', 'c0cf0578567f25c8b0d341f3e4be9a0c6d791681', '0', '0', '', '1464245790', '1464245788');
INSERT INTO `pigcms_sql_log` VALUES ('197', '31260', '0165779e0e84e8af13c8d8d32671a59b1fdd5a1a', '1', '0', '', '1464245792', '1464245792');
INSERT INTO `pigcms_sql_log` VALUES ('198', '31320', 'de02eab72796d669ab89dcf9092b2f460d1d038c', '1', '0', '', '1464245794', '1464245794');
INSERT INTO `pigcms_sql_log` VALUES ('199', '32400', '7bda019e5dce19234446fbf25e42107481667637', '1', '0', '', '1464245796', '1464245796');
INSERT INTO `pigcms_sql_log` VALUES ('200', '32460', '683a83d030ec323a8b88e88c8d4ad3081d29b8e8', '1', '0', '', '1464245799', '1464245799');
INSERT INTO `pigcms_sql_log` VALUES ('201', '32520', 'd7333ba8c5d38a620458765f473554e86fcf8d6f', '1', '0', '', '1464245800', '1464245800');
INSERT INTO `pigcms_sql_log` VALUES ('202', '32580', '7069e081572ad1952e67c11683c5eb5d74d9f816', '1', '0', '', '1464245801', '1464245801');
INSERT INTO `pigcms_sql_log` VALUES ('203', '32700', '10ab0f652a23bf1f4087ca8e3fac0fd4300825a7', '1', '0', '', '1464245803', '1464245803');
INSERT INTO `pigcms_sql_log` VALUES ('204', '32820', 'fed62ef463d5322b600c2909bbd68ca5deb312a5', '1', '0', '', '1464245804', '1464245804');
INSERT INTO `pigcms_sql_log` VALUES ('205', '32940', '5e1ea80ebe3851f6084924c1c00e005ddb81934c', '1', '0', '', '1464245806', '1464245806');
INSERT INTO `pigcms_sql_log` VALUES ('206', '33000', 'f86b89d156a6fd2bd49525796f610ff4e3cc4aa8', '1', '0', '', '1464245807', '1464245807');
INSERT INTO `pigcms_sql_log` VALUES ('207', '33060', '957f16fba0655a5f14242f8bba80345e7b30ecc7', '1', '0', '', '1464245809', '1464245809');
INSERT INTO `pigcms_sql_log` VALUES ('208', '33120', '6929bf4d3246e8005efed2ee86d6c11a57015567', '1', '0', '', '1464245811', '1464245811');
INSERT INTO `pigcms_sql_log` VALUES ('209', '33180', 'f76f025001dc64a21120f0db7f4b5bbdde79de84', '1', '0', '', '1464245813', '1464245813');
INSERT INTO `pigcms_sql_log` VALUES ('210', '33300', '42fa4f919e41ecd757a69f154e267caec7bec3ac', '1', '0', '', '1464245814', '1464245814');
INSERT INTO `pigcms_sql_log` VALUES ('211', '33420', '2cb369d6d817a7bcec1a69b6dea83ada95d54eb4', '1', '0', '', '1464245816', '1464245816');
INSERT INTO `pigcms_sql_log` VALUES ('212', '33540', 'f489de609555ff447b95432450e953b25339b12c', '1', '0', '', '1464245817', '1464245817');
INSERT INTO `pigcms_sql_log` VALUES ('213', '33660', '0a025c151b92acfa563aee6cb9d509b19be06e1d', '1', '0', '', '1464245818', '1464245818');
INSERT INTO `pigcms_sql_log` VALUES ('214', '33780', '78ed6237b5225c2733e3079dd20e80e26df68eae', '1', '0', '', '1464245820', '1464245820');
INSERT INTO `pigcms_sql_log` VALUES ('215', '33900', '293a9c071d223f20859a74074a8c7bb553a1e855', '1', '0', '', '1464245821', '1464245821');
INSERT INTO `pigcms_sql_log` VALUES ('216', '34020', '7569504d720389c4ffcebe2b493d510e6c7f67eb', '1', '0', '', '1464245823', '1464245823');
INSERT INTO `pigcms_sql_log` VALUES ('217', '34200', '118efc86e2efd9c1d327c8b71ec91a308391c87e', '1', '0', '', '1464245824', '1464245824');
INSERT INTO `pigcms_sql_log` VALUES ('218', '34320', '54c622a5db7ddd7be256a8e76963963a6423b201', '1', '0', '', '1464245826', '1464245825');
INSERT INTO `pigcms_sql_log` VALUES ('219', '34800', '67e5accb9d86c943ecfbf2349f8cd76cde86425b', '1', '0', '', '1464245827', '1464245827');
INSERT INTO `pigcms_sql_log` VALUES ('220', '34860', 'ea262b86a3d6467d1084eaa1a109bbb785cb62e8', '1', '0', '', '1464245828', '1464245828');
INSERT INTO `pigcms_sql_log` VALUES ('221', '34920', 'de4be8fdcdc0829c60520e1c3b5b5c5cb045c01a', '1', '0', '', '1464245830', '1464245830');
INSERT INTO `pigcms_sql_log` VALUES ('222', '34980', '8fec0cfb39d30b0764bcf575ddf4f12c912c07e5', '1', '0', '', '1464245832', '1464245832');
INSERT INTO `pigcms_sql_log` VALUES ('223', '35040', '7e5e71a527738447d75c1fb7a2c48d064ffcf921', '1', '0', '', '1464245834', '1464245834');
INSERT INTO `pigcms_sql_log` VALUES ('224', '35100', '859cb8ff8a9292dea9d7a5c85f081a0d6b5859e2', '1', '0', '', '1464245836', '1464245836');
INSERT INTO `pigcms_sql_log` VALUES ('225', '35160', '5995a7438c81d2bbfa915ccd399596cea5c18b34', '1', '0', '', '1464245838', '1464245838');
INSERT INTO `pigcms_sql_log` VALUES ('226', '35220', 'd3a03971e40c16daf1f0596481f7faa01b3d5469', '1', '0', '', '1464245840', '1464245840');
INSERT INTO `pigcms_sql_log` VALUES ('227', '35280', '2dc79c342ea61e4439e92ea10bb3f53a63796f4d', '1', '0', '', '1464245842', '1464245842');
INSERT INTO `pigcms_sql_log` VALUES ('228', '35340', '6193ef7e1d99ef0d484053e74da3243034edbc09', '1', '0', '', '1464245844', '1464245844');
INSERT INTO `pigcms_sql_log` VALUES ('229', '35400', '1e125ce08c136dc74cb12ebfbbda78c7d916ea5a', '1', '0', '', '1464245846', '1464245846');
INSERT INTO `pigcms_sql_log` VALUES ('230', '35460', '34b6379170e447c4a602641c833d1f21953eeebb', '1', '0', '', '1464245848', '1464245848');
INSERT INTO `pigcms_sql_log` VALUES ('231', '35520', 'a9cc167e09854084a8b565cccdd922e951f2e20a', '1', '0', '', '1464245850', '1464245850');
INSERT INTO `pigcms_sql_log` VALUES ('232', '35580', 'f9836094698c31da6d5e87f57de75017e7b95f82', '1', '0', '', '1464245852', '1464245852');
INSERT INTO `pigcms_sql_log` VALUES ('233', '35700', 'b2ec21f895a288bf214eb0d48a2513de28078c4b', '1', '0', '', '1464245854', '1464245854');
INSERT INTO `pigcms_sql_log` VALUES ('234', '35820', 'caf779701ffd95a2013548f2111dfb841cfdf464', '1', '0', '', '1464245856', '1464245856');
INSERT INTO `pigcms_sql_log` VALUES ('235', '35940', '460ad2ab70db05b6216603388c677f87a3b9a83a', '1', '0', '', '1464245859', '1464245859');
INSERT INTO `pigcms_sql_log` VALUES ('236', '37560', '90c66f48026a35e90195b723a8e6528fa43f6a34', '1', '0', '', '1464245860', '1464245860');
INSERT INTO `pigcms_sql_log` VALUES ('237', '37620', '81b0811c3052e8426fcd42882a3dc9338462b36c', '1', '0', '', '1464245862', '1464245862');
INSERT INTO `pigcms_sql_log` VALUES ('238', '37680', '23d123c1993fe86bea5201a7cd52ccda718a88c6', '0', '0', '', '1464245866', '1464245864');
INSERT INTO `pigcms_sql_log` VALUES ('239', '37740', '412cda1f5eee6c24f41f4638208a6d71721123e3', '1', '0', '', '1464245868', '1464245868');
INSERT INTO `pigcms_sql_log` VALUES ('240', '37800', '472255ef27511f5b3ff87ab9e073f7aa4ece0f69', '1', '0', '', '1464245870', '1464245870');
INSERT INTO `pigcms_sql_log` VALUES ('241', '37860', 'c74643ba3c48233250f7b1cf6945684c56db1e1a', '1', '0', '', '1464245872', '1464245872');
INSERT INTO `pigcms_sql_log` VALUES ('242', '37920', '8131154611fe5df5ff5ac9c35efe093225c629d2', '1', '0', '', '1464245874', '1464245874');
INSERT INTO `pigcms_sql_log` VALUES ('243', '37980', 'a9bd3b5c8f6d4406dc682ddd894a1c99ff0dd8aa', '1', '0', '', '1464245876', '1464245876');
INSERT INTO `pigcms_sql_log` VALUES ('244', '38040', '9e7f37838a0f0a3edb54f053656c3db5f52fe6a1', '1', '0', '', '1464245878', '1464245878');
INSERT INTO `pigcms_sql_log` VALUES ('245', '38100', '4423f1395cd3e7d193a3ec9f2910959a93891280', '1', '0', '', '1464245879', '1464245879');
INSERT INTO `pigcms_sql_log` VALUES ('246', '38160', '6233e2a503a7d09215cd715cf2bc04805217e4a5', '1', '0', '', '1464245881', '1464245881');
INSERT INTO `pigcms_sql_log` VALUES ('247', '38220', '0578f6d26118413f7fe982e91f7868846e34948f', '1', '0', '', '1464245882', '1464245882');
INSERT INTO `pigcms_sql_log` VALUES ('248', '38280', '8e3c1e7a1702244624cdf23eaeec137eeb8945d2', '1', '0', '', '1464245883', '1464245883');
INSERT INTO `pigcms_sql_log` VALUES ('249', '38340', '446276a0ebedc030bc6073d2d3f0fb37694b015a', '1', '0', '', '1464245885', '1464245885');
INSERT INTO `pigcms_sql_log` VALUES ('250', '38400', '89c701e5e9a89f002540076906b8a29814c5144d', '1', '0', '', '1464245886', '1464245886');
INSERT INTO `pigcms_sql_log` VALUES ('251', '38460', '3548a39ce34f970fe6f19c86cfbf335bbe1fbf2a', '1', '0', '', '1464245888', '1464245888');
INSERT INTO `pigcms_sql_log` VALUES ('252', '38520', 'ccff7d869a38fd3c9426b4bc47ba6e73c0e81602', '1', '0', '', '1464245889', '1464245889');
INSERT INTO `pigcms_sql_log` VALUES ('253', '38580', 'f8c3496152c5800485dfb8c4185ebb2803ad7dea', '1', '0', '', '1464245892', '1464245892');
INSERT INTO `pigcms_sql_log` VALUES ('254', '38640', '73e7715b13e7a195e36c3f87fc65dcd44d750300', '1', '0', '', '1464245893', '1464245893');
INSERT INTO `pigcms_sql_log` VALUES ('255', '38700', 'eb19d5c01ec73d4d0de8d602e37878bde5f36d6b', '1', '0', '', '1464245895', '1464245895');
INSERT INTO `pigcms_sql_log` VALUES ('256', '38760', '7567d17838d72081cb122fd5df0ea3b36e392728', '1', '0', '', '1464245897', '1464245897');
INSERT INTO `pigcms_sql_log` VALUES ('257', '38820', '230d54827b744e23ef9592e4faa2e3067aa3e03d', '1', '0', '', '1464245899', '1464245899');
INSERT INTO `pigcms_sql_log` VALUES ('258', '38880', '1fc0fd365bfc107e389972a46c7c4b04ed7e0f60', '1', '0', '', '1464245901', '1464245901');
INSERT INTO `pigcms_sql_log` VALUES ('259', '38940', '5585df2cc951af3c5d75c466c4fc6a639c629816', '1', '0', '', '1464245904', '1464245903');
INSERT INTO `pigcms_sql_log` VALUES ('260', '39000', '9b5726a800f231de5144acaa6b42f01fc4a96a4a', '1', '0', '', '1464245905', '1464245905');
INSERT INTO `pigcms_sql_log` VALUES ('261', '39060', 'a308c71ebb4200668cbf9497097824b58af697f6', '1', '0', '', '1464245907', '1464245907');
INSERT INTO `pigcms_sql_log` VALUES ('262', '39180', 'beb2237443fe7a9a83024804ed244e79456c7768', '1', '0', '', '1464245909', '1464245909');
INSERT INTO `pigcms_sql_log` VALUES ('263', '39240', 'fe7fd9fb0dbf51dc78782c8b10a7f518749a2655', '1', '0', '', '1464245911', '1464245911');
INSERT INTO `pigcms_sql_log` VALUES ('264', '39360', '885b53e793606b39c4c7634442818c78c3416c44', '1', '0', '', '1464245913', '1464245913');
INSERT INTO `pigcms_sql_log` VALUES ('265', '39420', '8c61e04783665c3655c87f31177cc0d8e64a7501', '1', '0', '', '1464245915', '1464245915');
INSERT INTO `pigcms_sql_log` VALUES ('266', '39480', '32a5523b5d5affcb5bde1f9839c3775cd49fdfbe', '1', '0', '', '1464245917', '1464245917');
INSERT INTO `pigcms_sql_log` VALUES ('267', '39540', 'd1d2923bd0a395489de3a5e540c1c1e4011ae4b4', '1', '0', '', '1464245920', '1464245920');
INSERT INTO `pigcms_sql_log` VALUES ('268', '39600', '127621228fe19bcf1a9d2c28aafe06f62d5c0254', '1', '0', '', '1464245929', '1464245929');
INSERT INTO `pigcms_sql_log` VALUES ('269', '39660', '892a4d5b78e0b760165252da89ac66a1d626a027', '1', '0', '', '1464245931', '1464245931');
INSERT INTO `pigcms_sql_log` VALUES ('270', '39720', '345eabd88bcfc99af30c9dba6b051292fadb6433', '1', '0', '', '1464245934', '1464245934');
INSERT INTO `pigcms_sql_log` VALUES ('271', '39780', '18e56c71edc0ded91d09c5745fb19116f3ea3330', '1', '0', '', '1464245936', '1464245936');
INSERT INTO `pigcms_sql_log` VALUES ('272', '39840', 'ed14668d78f004e6ddeca4c0853eca002ff56fe0', '1', '0', '', '1464245938', '1464245938');
INSERT INTO `pigcms_sql_log` VALUES ('273', '39900', '02bb412af6396e53fa5f85b8c5925a183b8328a0', '1', '0', '', '1464245941', '1464245941');
INSERT INTO `pigcms_sql_log` VALUES ('274', '39960', '6b7e7738d9e50b04cfb107460b861ccf84e7fa85', '1', '0', '', '1464245943', '1464245943');
INSERT INTO `pigcms_sql_log` VALUES ('275', '40020', '5fb9a5f72c03a7394047d3c02361ee7b8e3945c1', '1', '0', '', '1464245946', '1464245946');
INSERT INTO `pigcms_sql_log` VALUES ('276', '40080', 'ef1354d482846f3dcce25397925c5fbb0ab1e330', '1', '0', '', '1464245948', '1464245948');
INSERT INTO `pigcms_sql_log` VALUES ('277', '40140', '05c779e0a7e1ae4860c1bf9b10bc57a1f3dc0179', '1', '0', '', '1464245950', '1464245950');
INSERT INTO `pigcms_sql_log` VALUES ('278', '40200', '41e97a4d22ca39475d9e783deaeacfeed0cd3ec1', '1', '0', '', '1464245953', '1464245952');
INSERT INTO `pigcms_sql_log` VALUES ('279', '40260', 'b78c09e66536bee54971873f0be21736b6953952', '1', '0', '', '1464245955', '1464245955');
INSERT INTO `pigcms_sql_log` VALUES ('280', '40320', '0038ab69f5709becccd725762d0a4ff5dd02e970', '1', '0', '', '1464245956', '1464245956');
INSERT INTO `pigcms_sql_log` VALUES ('281', '40380', 'b57085446979fe1f75280dd14a44f0f0d3d6c6c3', '1', '0', '', '1464245961', '1464245961');
INSERT INTO `pigcms_sql_log` VALUES ('282', '40440', '480c1ccfe847def3a2fc9ff24df064c0fb52aadd', '1', '0', '', '1464245963', '1464245963');
INSERT INTO `pigcms_sql_log` VALUES ('283', '40500', 'b265b0af94d05e40e13ad263d0af095ceab4830e', '1', '0', '', '1464245964', '1464245964');
INSERT INTO `pigcms_sql_log` VALUES ('284', '40560', '6117a896bf2457af817899a3dfb321a900c283e6', '1', '0', '', '1464245965', '1464245965');
INSERT INTO `pigcms_sql_log` VALUES ('285', '40620', '0d68b31a9ab1e160a02e908e9551961f4331e8a2', '1', '0', '', '1464245967', '1464245967');
INSERT INTO `pigcms_sql_log` VALUES ('286', '40680', 'dcb539167713f5ae5ce16298481f08551b02ba8e', '1', '0', '', '1464245968', '1464245968');
INSERT INTO `pigcms_sql_log` VALUES ('287', '40740', '07b7e227e6b5d89d1f2353e45722ad2fbbce0ec1', '1', '0', '', '1464245970', '1464245970');
INSERT INTO `pigcms_sql_log` VALUES ('288', '40800', '91635cabe493e10b8a407c86f6458bbd213a4e1e', '1', '0', '', '1464245972', '1464245972');
INSERT INTO `pigcms_sql_log` VALUES ('289', '40860', 'b2292ee0df7e5673e0aaa329941c621e4830b206', '1', '0', '', '1464245973', '1464245973');
INSERT INTO `pigcms_sql_log` VALUES ('290', '40920', 'a4edd0bb5c6baf2e8ba706659ba7f9425ca1aebf', '1', '0', '', '1464245975', '1464245975');
INSERT INTO `pigcms_sql_log` VALUES ('291', '40980', 'b4c981fceded5af2b5bd85aa2ff2d0d5f0ffb9a2', '1', '0', '', '1464245976', '1464245976');
INSERT INTO `pigcms_sql_log` VALUES ('292', '41040', 'd0567b9bdba2732cce65c251a2a958f3a7f1fedc', '0', '0', '', '1464245979', '1464245978');
INSERT INTO `pigcms_sql_log` VALUES ('293', '41100', '793f31d0fc84dabecae4a8d97dd00be8984f8e5b', '0', '0', '', '1464245982', '1464245980');
INSERT INTO `pigcms_sql_log` VALUES ('294', '41160', '83751d52882a928afe4b3a471d19f9d54bd726a7', '1', '0', '', '1464245983', '1464245983');
INSERT INTO `pigcms_sql_log` VALUES ('295', '41220', 'da3cfa2a7bb7aab47792520f1111e4e20152b5b8', '1', '0', '', '1464245985', '1464245985');
INSERT INTO `pigcms_sql_log` VALUES ('296', '41280', '2df54b8648c14c010ecdd06e9a6018b6a52d983f', '1', '0', '', '1464245986', '1464245986');
INSERT INTO `pigcms_sql_log` VALUES ('297', '42780', 'ed4e87e60ed543ead4b79ad8900ef9a49ef660c5', '1', '0', '', '1464245988', '1464245988');
INSERT INTO `pigcms_sql_log` VALUES ('298', '42840', 'af29441ed702e3c13d650858c9277f308bae5aeb', '1', '0', '', '1464245989', '1464245989');
INSERT INTO `pigcms_sql_log` VALUES ('299', '42900', 'a4ee69d14631f0bfb33cc66ae4996127a97b69ab', '1', '0', '', '1464245991', '1464245991');
INSERT INTO `pigcms_sql_log` VALUES ('300', '42960', 'e69d2408092ecc0223ade56bdd58fad1b27e754b', '1', '0', '', '1464245993', '1464245993');
INSERT INTO `pigcms_sql_log` VALUES ('301', '43020', 'b083e2c32c30ca211b9fd0ac5f42cbf34f257d59', '0', '0', '', '1464245997', '1464245995');
INSERT INTO `pigcms_sql_log` VALUES ('302', '43080', '343ab8d27e4dd7a8051bd8a5ca092706b63f3fb9', '1', '0', '', '1464245999', '1464245999');
INSERT INTO `pigcms_sql_log` VALUES ('303', '43140', 'e876b3413f759ee9691b441a6249fcf095c8c2ab', '1', '0', '', '1464246001', '1464246001');
INSERT INTO `pigcms_sql_log` VALUES ('304', '43200', 'd77bc0d548e5f7cadd92243ccdc811072c0b3ffb', '1', '0', '', '1464246004', '1464246004');
INSERT INTO `pigcms_sql_log` VALUES ('305', '43260', 'a6dc798ae50ab3bc93acc7c40f5d0f2f5e12a2b5', '1', '0', '', '1464246005', '1464246005');
INSERT INTO `pigcms_sql_log` VALUES ('306', '43320', 'cfc5a194bbbc5db56f4f0d748a42536dd1300d34', '1', '0', '', '1464246007', '1464246007');
INSERT INTO `pigcms_sql_log` VALUES ('307', '43380', '92836f9fbba02a51ce291b7d3c5c4e58a871b627', '1', '0', '', '1464246009', '1464246009');
INSERT INTO `pigcms_sql_log` VALUES ('308', '43440', '499451cb411478b139704a0f6134a63730a61a7b', '1', '0', '', '1464246011', '1464246011');
INSERT INTO `pigcms_sql_log` VALUES ('309', '43500', '08e280c3a311470ae04f1c6f8314cc60ffaf11c7', '1', '0', '', '1464246014', '1464246013');
INSERT INTO `pigcms_sql_log` VALUES ('310', '43560', 'a2bbcd1551fb64529fd3849d230bde71c9d42429', '1', '0', '', '1464246016', '1464246016');
INSERT INTO `pigcms_sql_log` VALUES ('311', '43620', 'a78fef97d649a4fc04cf16c6f55d7ca8841a9e32', '1', '0', '', '1464246018', '1464246017');
INSERT INTO `pigcms_sql_log` VALUES ('312', '43680', '7170d21d29494d89dad25752a10c1ef98d2b1176', '1', '0', '', '1464246019', '1464246019');
INSERT INTO `pigcms_sql_log` VALUES ('313', '43740', 'ad492cb0a2188f16f6c839d0afe107453616b5b1', '1', '0', '', '1464246021', '1464246021');
INSERT INTO `pigcms_sql_log` VALUES ('314', '43800', 'e8b14716980233a5e2f817c150b451b5dc5513c9', '1', '0', '', '1464246024', '1464246023');
INSERT INTO `pigcms_sql_log` VALUES ('315', '43860', '7e86a6177d06b9cb2af3cffb50f1dca6f8dedfbe', '1', '0', '', '1464246025', '1464246025');
INSERT INTO `pigcms_sql_log` VALUES ('316', '43920', '3f22823b5295e6e9b391904c8c1719350e332372', '1', '0', '', '1464246027', '1464246027');
INSERT INTO `pigcms_sql_log` VALUES ('317', '43980', 'f8a3159d62c88930cc3215e592adea54ef17d3c5', '1', '0', '', '1464246029', '1464246029');
INSERT INTO `pigcms_sql_log` VALUES ('318', '44040', '89faccaec1795be897184b01fa4c4fa45c30aca5', '1', '0', '', '1464246031', '1464246031');
INSERT INTO `pigcms_sql_log` VALUES ('319', '44100', 'af3d4794057f3441ce8d185252aac0e842a5f684', '1', '0', '', '1464246033', '1464246033');
INSERT INTO `pigcms_sql_log` VALUES ('320', '44160', '8e7d3ab8448f5f327b5cc67967fb011f15674e10', '1', '0', '', '1464246036', '1464246036');
INSERT INTO `pigcms_sql_log` VALUES ('321', '44220', 'eaa1e67a5db04bcd34ee877f8b3073b0455c5bf6', '1', '0', '', '1464246037', '1464246037');
INSERT INTO `pigcms_sql_log` VALUES ('322', '44280', '89d7a69cfa10d7b5b546256fec6a42245fcd8f51', '1', '0', '', '1464246039', '1464246039');
INSERT INTO `pigcms_sql_log` VALUES ('323', '44340', '084275c07340b2baa2fcfa337a566c37f911ec4d', '1', '0', '', '1464246041', '1464246041');
INSERT INTO `pigcms_sql_log` VALUES ('324', '44400', 'a59d7b689f91b388cd700481a32d41404bbef2bf', '1', '0', '', '1464246043', '1464246043');
INSERT INTO `pigcms_sql_log` VALUES ('325', '44460', '5698413c2225a01ae1ca6cf33603874022a29f86', '1', '0', '', '1464246045', '1464246045');
INSERT INTO `pigcms_sql_log` VALUES ('326', '44640', '6d9fa5ff3ff3a7a00dba63d0dcf124a9e7a3b9e2', '1', '0', '', '1464246047', '1464246047');
INSERT INTO `pigcms_sql_log` VALUES ('327', '44700', 'd19be130bc232d468d8f8407c2d67de8fc055101', '1', '0', '', '1464246051', '1464246051');
INSERT INTO `pigcms_sql_log` VALUES ('328', '44760', '25d397986075bd0164c489bce2c9537520509650', '1', '0', '', '1464246055', '1464246055');
INSERT INTO `pigcms_sql_log` VALUES ('329', '44820', '56ad4b83708bd9d0917b2adc54e8d17864d4e805', '1', '0', '', '1464246056', '1464246056');
INSERT INTO `pigcms_sql_log` VALUES ('330', '44880', 'e9d8d02f665b3bd357a222d6b448803043ba7f3c', '1', '0', '', '1464246059', '1464246059');
INSERT INTO `pigcms_sql_log` VALUES ('331', '44940', '3240f5ac82df8ac46b25df27171011247fc1f6ab', '1', '0', '', '1464246060', '1464246060');
INSERT INTO `pigcms_sql_log` VALUES ('332', '45000', '38510fb67a1ecdc67cb93d4549a5384baa4a3518', '1', '0', '', '1464246062', '1464246062');
INSERT INTO `pigcms_sql_log` VALUES ('333', '45060', '91ec5f7adcc80fd5c4432357e89dd3795a371f15', '1', '0', '', '1464246064', '1464246064');
INSERT INTO `pigcms_sql_log` VALUES ('334', '45120', 'ea00afb4a6762cc2d169c6673d1344afa6f0ce45', '0', '0', '', '1464246068', '1464246066');
INSERT INTO `pigcms_sql_log` VALUES ('335', '45180', 'c85f8f6ed0ab7b05134300fd4abd6cec4049909a', '1', '0', '', '1464246070', '1464246070');
INSERT INTO `pigcms_sql_log` VALUES ('336', '45240', 'bd67e9704d825f25383ba1c364a734e8b194fff8', '1', '0', '', '1464246072', '1464246072');
INSERT INTO `pigcms_sql_log` VALUES ('337', '45300', 'b058f525654cdaab4b25551699da075303e93099', '1', '0', '', '1464246074', '1464246074');
INSERT INTO `pigcms_sql_log` VALUES ('338', '45360', 'b5d04064c2e0d06a14bdcd076918fd3e914dd9b6', '1', '0', '', '1464246076', '1464246076');
INSERT INTO `pigcms_sql_log` VALUES ('339', '45420', 'f05f53165277cc0dca7639f11211143d9b4defd1', '1', '0', '', '1464246078', '1464246078');
INSERT INTO `pigcms_sql_log` VALUES ('340', '45480', 'b85fe2b12459171dbc14596fedf4d6070267cb80', '1', '0', '', '1464246080', '1464246080');
INSERT INTO `pigcms_sql_log` VALUES ('341', '45540', 'a47ef6d970f1bcdd80fadab86d556963e84cef34', '1', '0', '', '1464246082', '1464246082');
INSERT INTO `pigcms_sql_log` VALUES ('342', '45600', '1e28b8506557d0fc5526bec6d03c88c112a1a549', '1', '0', '', '1464246084', '1464246084');
INSERT INTO `pigcms_sql_log` VALUES ('343', '45660', 'c330281e87c719ea3031e90cf940cf39ef769fe2', '1', '0', '', '1464246086', '1464246086');
INSERT INTO `pigcms_sql_log` VALUES ('344', '45720', '0ba2ed793d4b0bd326e1d5db09a0776cd5c09732', '1', '0', '', '1464246088', '1464246088');
INSERT INTO `pigcms_sql_log` VALUES ('345', '45780', 'cc10ad9dcd4acc2ee803c94f5344f6bef17c9829', '1', '0', '', '1464246090', '1464246090');
INSERT INTO `pigcms_sql_log` VALUES ('346', '45840', '38eb4ac2c176e7ac8ad87204fb22515101358bb1', '1', '0', '', '1464246092', '1464246092');
INSERT INTO `pigcms_sql_log` VALUES ('347', '45900', 'f2fff9027d44cb6d9beabaa36b783cc40df7c3a8', '1', '0', '', '1464246094', '1464246094');
INSERT INTO `pigcms_sql_log` VALUES ('348', '45960', 'b3411f1ddc95365d99c2c2ca2bb20cacc5569bc7', '1', '0', '', '1464246096', '1464246096');
INSERT INTO `pigcms_sql_log` VALUES ('349', '46020', 'cab99e229e9bb2b0b7179aa704329839493e9357', '1', '0', '', '1464246099', '1464246099');
INSERT INTO `pigcms_sql_log` VALUES ('350', '46080', '6d7a2e482c62a57d54e8bf759a90e7949b36f0ae', '1', '0', '', '1464246113', '1464246113');
INSERT INTO `pigcms_sql_log` VALUES ('351', '46140', '289f374c30245e7cdb19c217ca14d6511be3a622', '1', '0', '', '1464246114', '1464246114');
INSERT INTO `pigcms_sql_log` VALUES ('352', '46200', 'c9374f36a25bcd14ddabdfbc647e6468d37818f9', '1', '0', '', '1464246116', '1464246116');
INSERT INTO `pigcms_sql_log` VALUES ('353', '46260', '3018a9ad091b7ea18b5de294ec9fbcb789f45d25', '1', '0', '', '1464246117', '1464246117');
INSERT INTO `pigcms_sql_log` VALUES ('354', '46320', '019125b433dba5ebb63796f01f8590ab60e4e52a', '1', '0', '', '1464246119', '1464246119');
INSERT INTO `pigcms_sql_log` VALUES ('355', '46380', '4415fa89d5d0750c53cfccad63f0169ac4ff7d24', '1', '0', '', '1464246120', '1464246120');
INSERT INTO `pigcms_sql_log` VALUES ('356', '46440', '4ec33d9b37e17173fd2c8b351fff74a9d67ce4ec', '1', '0', '', '1464246122', '1464246122');
INSERT INTO `pigcms_sql_log` VALUES ('357', '46500', '361430e65398226657053e2a1844e1f71f7ebc5c', '1', '0', '', '1464246123', '1464246123');
INSERT INTO `pigcms_sql_log` VALUES ('358', '46560', '25673d502ddf4706053cba94f6c211b31ecf7ec0', '1', '0', '', '1464246124', '1464246124');
INSERT INTO `pigcms_sql_log` VALUES ('359', '46680', '64d7f93a99800f7b2881dd817ef5a4a2b65787ed', '1', '0', '', '1464246126', '1464246126');
INSERT INTO `pigcms_sql_log` VALUES ('360', '46740', 'a799d9d88e2674ce54e25235f94179eb8686cb84', '1', '0', '', '1464246127', '1464246127');
INSERT INTO `pigcms_sql_log` VALUES ('361', '46800', '81c287c0b35a61b1477523e14a18666414bb78b6', '1', '0', '', '1464246129', '1464246129');
INSERT INTO `pigcms_sql_log` VALUES ('362', '46860', '6b7c96105ce6b185a9be522ad63c396f36a27f0d', '1', '0', '', '1464246130', '1464246130');
INSERT INTO `pigcms_sql_log` VALUES ('363', '46920', '8c4c0a584b3552314e4cc90f0719e67d14a07674', '1', '0', '', '1464246132', '1464246132');
INSERT INTO `pigcms_sql_log` VALUES ('364', '46980', '0d398db641113e72b5264b5bf183824dd54d1206', '1', '0', '', '1464246133', '1464246133');
INSERT INTO `pigcms_sql_log` VALUES ('365', '47040', 'b1389f3377513377806ca38020e969dd10cfd08f', '1', '0', '', '1464246135', '1464246135');
INSERT INTO `pigcms_sql_log` VALUES ('366', '47100', '87e730d8c99631e839890209683a5653021e43dd', '1', '0', '', '1464246136', '1464246136');
INSERT INTO `pigcms_sql_log` VALUES ('367', '47160', '200cd10a06552390361bd3c01cb47ee3853bce7f', '1', '0', '', '1464246137', '1464246137');
INSERT INTO `pigcms_sql_log` VALUES ('368', '47220', '3ca260d0058da5620f73d9d2c9a8c18b8eed77db', '1', '0', '', '1464246139', '1464246139');
INSERT INTO `pigcms_sql_log` VALUES ('369', '47280', '00521c45862b897f556871b5450c1aa0246e6e39', '1', '0', '', '1464246140', '1464246140');
INSERT INTO `pigcms_sql_log` VALUES ('370', '47340', '03805ed746e3417debe253f3f37ec64a21772837', '1', '0', '', '1464246142', '1464246142');
INSERT INTO `pigcms_sql_log` VALUES ('371', '47400', '9e7a8b5f45ee7524f6d7accd144f7caeb54ef581', '1', '0', '', '1464246143', '1464246143');
INSERT INTO `pigcms_sql_log` VALUES ('372', '47460', 'f8c0f8965178c31d84259d25e73fdbaa54c89fd7', '1', '0', '', '1464246145', '1464246145');
INSERT INTO `pigcms_sql_log` VALUES ('373', '47520', '6e6fb588993c22d6bd5c51ffeaba9ccd9aa6ea5a', '1', '0', '', '1464246146', '1464246146');
INSERT INTO `pigcms_sql_log` VALUES ('374', '47580', '9a9f435f374a9f68c1c4f40100cf3eee258dbeaf', '1', '0', '', '1464246147', '1464246147');
INSERT INTO `pigcms_sql_log` VALUES ('375', '47640', 'bb1215ce739dab804fa1512a4ab6d1e1321f9740', '1', '0', '', '1464246149', '1464246149');
INSERT INTO `pigcms_sql_log` VALUES ('376', '47700', 'd3f3edfce5fc0af4ea0d76aa5c2878bdc768e799', '1', '0', '', '1464246150', '1464246150');
INSERT INTO `pigcms_sql_log` VALUES ('377', '47760', 'e66c92b5ee8e013a6e5caf2ff14e39968d38f790', '1', '0', '', '1464246152', '1464246152');
INSERT INTO `pigcms_sql_log` VALUES ('378', '47820', '57c58a6a71ac9b07cbb9fb937e59a0863cf3bb3f', '1', '0', '', '1464246153', '1464246153');
INSERT INTO `pigcms_sql_log` VALUES ('379', '47880', '06038f280dbc3ee20e17bf9e8a37b6ede47b5d40', '1', '0', '', '1464246155', '1464246155');
INSERT INTO `pigcms_sql_log` VALUES ('380', '47940', 'a0ecffefcc759755411d931d75bbf0d10f26035b', '1', '0', '', '1464246156', '1464246156');
INSERT INTO `pigcms_sql_log` VALUES ('381', '48000', '9efbe286026a27a4a81be238b04a48c385b68c96', '1', '0', '', '1464246158', '1464246158');
INSERT INTO `pigcms_sql_log` VALUES ('382', '48060', '89bb0087c59370624c19ab6d6175a73dec66488c', '1', '0', '', '1464246159', '1464246159');
INSERT INTO `pigcms_sql_log` VALUES ('383', '48120', 'e35b14c955ca015db03f6fe22ea6e96ae93a3a0b', '1', '0', '', '1464246160', '1464246160');
INSERT INTO `pigcms_sql_log` VALUES ('384', '48180', 'c86d11b8f02646ffec7bca9bfed7bfc8b8a2e123', '1', '0', '', '1464246162', '1464246162');
INSERT INTO `pigcms_sql_log` VALUES ('385', '48240', 'afd9b11e2427bf13e84ed78d2c44242a6ae2029b', '1', '0', '', '1464246163', '1464246163');
INSERT INTO `pigcms_sql_log` VALUES ('386', '48360', '1bc711392c4a112a9636e0e946ddaf48b2e5577b', '1', '0', '', '1464246165', '1464246165');
INSERT INTO `pigcms_sql_log` VALUES ('387', '48420', 'bfb8084b5d4e7a7edd8a97a81dd1f9a239414af5', '1', '0', '', '1464246166', '1464246166');
INSERT INTO `pigcms_sql_log` VALUES ('388', '48540', 'cc93e81d0089465286e17727fbdd610f2ae4506e', '1', '0', '', '1464246168', '1464246168');
INSERT INTO `pigcms_sql_log` VALUES ('389', '48600', 'ae9fd9046e5b5a4e5c779dd1413de136b718289d', '1', '0', '', '1464246169', '1464246169');
INSERT INTO `pigcms_sql_log` VALUES ('390', '48660', '0d63416ab22aee003cc23b58171182ad4d444236', '1', '0', '', '1464246171', '1464246171');
INSERT INTO `pigcms_sql_log` VALUES ('391', '48720', '04072833d5ae9f95be4d35ac00ffa813a230c0c2', '1', '0', '', '1464246174', '1464246174');
INSERT INTO `pigcms_sql_log` VALUES ('392', '48780', 'ecd08fec52f52c6fe18330c5fb4add6bdc12f906', '1', '0', '', '1464246175', '1464246175');
INSERT INTO `pigcms_sql_log` VALUES ('393', '48840', '7c5157a43ea55549275eb17b36885cb2c0182e70', '1', '0', '', '1464246176', '1464246176');
INSERT INTO `pigcms_sql_log` VALUES ('394', '48900', '9d667c2579e3249e30e967043573466036532dc0', '1', '0', '', '1464246178', '1464246178');
INSERT INTO `pigcms_sql_log` VALUES ('395', '49020', '051fc85e391ce9b9c9cbca34c74e553ca2ed9c9d', '1', '0', '', '1464246179', '1464246179');
INSERT INTO `pigcms_sql_log` VALUES ('396', '49080', '5e1adf165fb551cda7087af91d3536b2e5dd14ad', '1', '0', '', '1464246181', '1464246181');
INSERT INTO `pigcms_sql_log` VALUES ('397', '49140', '2154e37595ed8dbfc8acb9f14b9002e2619bc659', '1', '0', '', '1464246182', '1464246182');
INSERT INTO `pigcms_sql_log` VALUES ('398', '49200', '89ea53a3d7f86c66a031ff30206bffcc610caa9e', '1', '0', '', '1464246184', '1464246184');
INSERT INTO `pigcms_sql_log` VALUES ('399', '49260', 'c71f3ff44564486798938d50ddfb165210ccb873', '1', '0', '', '1464246185', '1464246185');
INSERT INTO `pigcms_sql_log` VALUES ('400', '49320', '4496a0e77e2ed59b97cb047e1e13a8fdd613fdea', '1', '0', '', '1464246186', '1464246186');
INSERT INTO `pigcms_sql_log` VALUES ('401', '49380', '9d49876b32fc6b39104a69891fecfb73631e96b5', '1', '0', '', '1464246188', '1464246188');
INSERT INTO `pigcms_sql_log` VALUES ('402', '49440', 'e5e1ea8f1083666dc2de79700c801d7c9a477928', '1', '0', '', '1464246189', '1464246189');
INSERT INTO `pigcms_sql_log` VALUES ('403', '49500', 'e913af4a45d39e7a6e754ad52257b33eaacd056f', '1', '0', '', '1464246191', '1464246191');
INSERT INTO `pigcms_sql_log` VALUES ('404', '49560', '18921289ad9169b7bdf6f9998961eb32fcd087b3', '1', '0', '', '1464246192', '1464246192');
INSERT INTO `pigcms_sql_log` VALUES ('405', '49620', 'b6adb0a1dd35752a4376b9c72e7a3f61332c7833', '1', '0', '', '1464246194', '1464246194');
INSERT INTO `pigcms_sql_log` VALUES ('406', '49680', '48830548733c2b98cfc658e5b88e19c85f6114a3', '1', '0', '', '1464246195', '1464246195');
INSERT INTO `pigcms_sql_log` VALUES ('407', '49740', 'cb27c388c523fc5c85c3369cb7cd2985cfec4474', '1', '0', '', '1464246197', '1464246197');
INSERT INTO `pigcms_sql_log` VALUES ('408', '49800', 'fa7f85e2fae01b334ecb7d9f0a0bcc012ea5ce17', '1', '0', '', '1464246198', '1464246198');
INSERT INTO `pigcms_sql_log` VALUES ('409', '49860', '94a196d0cc71060a5bdd8220b51919676510f596', '1', '0', '', '1464246200', '1464246200');
INSERT INTO `pigcms_sql_log` VALUES ('410', '49920', 'ed0fbaed7653cf77bc19fc2a6e5d66b73e483416', '1', '0', '', '1464246201', '1464246201');
INSERT INTO `pigcms_sql_log` VALUES ('411', '49980', 'f81132afaefebbc32893cb05209fde535c5cfdc8', '1', '0', '', '1464246203', '1464246203');
INSERT INTO `pigcms_sql_log` VALUES ('412', '50040', '5a34ac6d995f9e49440e75ec7c4e2e2bb58ba935', '1', '0', '', '1464246204', '1464246204');
INSERT INTO `pigcms_sql_log` VALUES ('413', '50100', '245e6c2ea000ca8d2696af3f30ec6ba4a4f144a5', '1', '0', '', '1464246205', '1464246205');
INSERT INTO `pigcms_sql_log` VALUES ('414', '50160', 'fffe68bc07c9a7cc7d5b8062546b6ef5e24acb80', '1', '0', '', '1464246207', '1464246207');
INSERT INTO `pigcms_sql_log` VALUES ('415', '50220', '242d0b7f3f95a7351c82c733a0bf8c4fae208cee', '1', '0', '', '1464246208', '1464246208');
INSERT INTO `pigcms_sql_log` VALUES ('416', '50340', '53439163cf044e06a4fdb92fe79b7a6c63c07d22', '1', '0', '', '1464246210', '1464246210');
INSERT INTO `pigcms_sql_log` VALUES ('417', '50460', 'a7d7fa097a9db4a72608dd9b20c29fc8d32037a7', '1', '0', '', '1464246211', '1464246211');
INSERT INTO `pigcms_sql_log` VALUES ('418', '50580', '99dbd3d1354083e37413d871cc6a5bc108037f60', '1', '0', '', '1464246213', '1464246213');
INSERT INTO `pigcms_sql_log` VALUES ('419', '50700', '1c876f7c52c642de918f3d09c1202e12d88b84bb', '1', '0', '', '1464246214', '1464246214');
INSERT INTO `pigcms_sql_log` VALUES ('420', '50760', '8911557b001ff8e276508080d1fa17e2a8baf540', '1', '0', '', '1464246215', '1464246215');
INSERT INTO `pigcms_sql_log` VALUES ('421', '50820', 'de3bb56dfbc773ef2af1025b63e0bed284ff8e4d', '1', '0', '', '1464246217', '1464246217');
INSERT INTO `pigcms_sql_log` VALUES ('422', '50880', '96b9e51338a2125e771b86286b0a30730d34a0a4', '1', '0', '', '1464246218', '1464246218');
INSERT INTO `pigcms_sql_log` VALUES ('423', '50940', '931325ff6f573d16a9a9dbc6f7164155a114d9ac', '1', '0', '', '1464246220', '1464246220');
INSERT INTO `pigcms_sql_log` VALUES ('424', '51000', '45a361b9afa52c3c7c0e984bcd6a8a01344c0250', '1', '0', '', '1464246221', '1464246221');
INSERT INTO `pigcms_sql_log` VALUES ('425', '51120', '8453e50e9f8685da8b4a73cf252e735110175388', '1', '0', '', '1464246223', '1464246223');
INSERT INTO `pigcms_sql_log` VALUES ('426', '51180', '1aff2403415ccece64bee4587e197c65321a275a', '1', '0', '', '1464246224', '1464246224');
INSERT INTO `pigcms_sql_log` VALUES ('427', '51240', '32c4291203bddc14029979d1d0d4a8239e5bf180', '1', '0', '', '1464246226', '1464246226');
INSERT INTO `pigcms_sql_log` VALUES ('428', '51300', '5696836b362e90e2e1cd4dd54b7fc621c8ceb70d', '1', '0', '', '1464246227', '1464246227');
INSERT INTO `pigcms_sql_log` VALUES ('429', '51360', '32c4291203bddc14029979d1d0d4a8239e5bf180', '0', '0', '', '1464246230', '1464246229');
INSERT INTO `pigcms_sql_log` VALUES ('430', '51420', '3a11a5dd493615d4f672152543dcd1fec84eee47', '1', '0', '', '1464246231', '1464246231');
INSERT INTO `pigcms_sql_log` VALUES ('431', '51480', 'cdc0b788c18c7eb9d39a58d00ce9f67c4aa31d02', '1', '0', '', '1464246233', '1464246233');
INSERT INTO `pigcms_sql_log` VALUES ('432', '51540', '8e9a71b754815ec6fef3955a55b76e0a52f80d43', '1', '0', '', '1464246234', '1464246234');
INSERT INTO `pigcms_sql_log` VALUES ('433', '51600', 'a268ce5e43ad4773895c6e7aae2dc10e6082b373', '1', '0', '', '1464246236', '1464246236');
INSERT INTO `pigcms_sql_log` VALUES ('434', '51660', '9ed99dd2693d669defbe9594e4041adf1f2fc882', '1', '0', '', '1464246237', '1464246237');
INSERT INTO `pigcms_sql_log` VALUES ('435', '51720', '370d8bf1f3adc8e06bac8ccbd82ee2755406acac', '1', '0', '', '1464246239', '1464246239');
INSERT INTO `pigcms_sql_log` VALUES ('436', '51780', 'f28f52acb08a10a920c02e2ee7a80b16c1583c8f', '1', '0', '', '1464246240', '1464246240');
INSERT INTO `pigcms_sql_log` VALUES ('437', '51840', '5d3cc5d9fddd51a57088b88d9747d31a61984ff6', '1', '0', '', '1464246241', '1464246241');
INSERT INTO `pigcms_sql_log` VALUES ('438', '51900', '61c7f02f188e974e5f69fa63aa4bddd7ff14700d', '1', '0', '', '1464246243', '1464246243');
INSERT INTO `pigcms_sql_log` VALUES ('439', '51960', 'db59fad2b494ec21aaf193374e7947acc6feef26', '1', '0', '', '1464246244', '1464246244');
INSERT INTO `pigcms_sql_log` VALUES ('440', '52020', '85a1e0b54687e02e4f16943ff729016664929b3b', '1', '0', '', '1464246246', '1464246246');
INSERT INTO `pigcms_sql_log` VALUES ('441', '52080', 'eb3a293ed38e15b9364018aaf5ccdafd3722614f', '1', '0', '', '1464246247', '1464246247');
INSERT INTO `pigcms_sql_log` VALUES ('442', '52140', 'c3ad8dbf1f32e8031e7742bb829d6b549d63b43e', '1', '0', '', '1464246249', '1464246249');
INSERT INTO `pigcms_sql_log` VALUES ('443', '52200', '004079606a986098463d5eb0ff7498c338efa62f', '1', '0', '', '1464246250', '1464246250');
INSERT INTO `pigcms_sql_log` VALUES ('444', '52260', 'a003bea7b6bc7de627c642fd2d3ab9d78998f59f', '0', '0', '', '1464246253', '1464246251');
INSERT INTO `pigcms_sql_log` VALUES ('445', '52320', '7493030673e2879034eecd2e5da24d4d87f5dcde', '1', '0', '', '1464246254', '1464246254');
INSERT INTO `pigcms_sql_log` VALUES ('446', '52380', '35f823077f53a58189f6e4178f8c07c48ff9587f', '1', '0', '', '1464246256', '1464246256');
INSERT INTO `pigcms_sql_log` VALUES ('447', '52440', 'e278225119d38f586e9f4af7c49a5cd35a0186f3', '1', '0', '', '1464246257', '1464246257');
INSERT INTO `pigcms_sql_log` VALUES ('448', '52500', 'cadeb67bf57d791517011e5d4eb902205f144287', '1', '0', '', '1464246259', '1464246259');
INSERT INTO `pigcms_sql_log` VALUES ('449', '52560', 'd013fecebc1451faf89db77851225d1bf6577c1e', '1', '0', '', '1464246260', '1464246260');
INSERT INTO `pigcms_sql_log` VALUES ('450', '52620', 'c524541f665e5c8eacbcfef183567f5535044ef4', '1', '0', '', '1464246262', '1464246262');
INSERT INTO `pigcms_sql_log` VALUES ('451', '52680', '558d7352fc74da5a860591441cb1c67c6488b991', '1', '0', '', '1464246263', '1464246263');
INSERT INTO `pigcms_sql_log` VALUES ('452', '52740', '610ea46a854f02df4222fc0a53ba9d1cac189362', '1', '0', '', '1464246265', '1464246265');
INSERT INTO `pigcms_sql_log` VALUES ('453', '52800', '0ded5858ec2895d4d261b4bd199ddeacdbe7af3b', '1', '0', '', '1464246266', '1464246266');
INSERT INTO `pigcms_sql_log` VALUES ('454', '52860', '48556e78c63845e22c89e391cbd53076a28609da', '1', '0', '', '1464246268', '1464246267');
INSERT INTO `pigcms_sql_log` VALUES ('455', '52920', 'ca841baf12431af6c772b45df9cc09194bf3b17d', '1', '0', '', '1464246269', '1464246269');
INSERT INTO `pigcms_sql_log` VALUES ('456', '52980', 'ed7f3c1af57907d9442d70758d5bf877d78ca445', '1', '0', '', '1464246270', '1464246270');
INSERT INTO `pigcms_sql_log` VALUES ('457', '53040', 'cd009acf49aef27d2055740071725f95679ff542', '1', '0', '', '1464246272', '1464246272');
INSERT INTO `pigcms_sql_log` VALUES ('458', '53100', '64c3156f50986552dedfc1223b0a88c85d9d65aa', '1', '0', '', '1464246273', '1464246273');
INSERT INTO `pigcms_sql_log` VALUES ('459', '53160', '9778a7b81e54efd0ba8cd832c78bc9190312a5f2', '1', '0', '', '1464246275', '1464246275');
INSERT INTO `pigcms_sql_log` VALUES ('460', '53220', 'bf0da7e2eaa92fdebc9af1cd9cece7874f3efc83', '1', '0', '', '1464246276', '1464246276');
INSERT INTO `pigcms_sql_log` VALUES ('461', '53280', '3f8d037f9ea05825d22dc97e760fa5f7a67e4a6b', '1', '0', '', '1464246278', '1464246278');
INSERT INTO `pigcms_sql_log` VALUES ('462', '53340', 'ecbd715f368ab521667c5a418414a705a13930fa', '1', '0', '', '1464246279', '1464246279');
INSERT INTO `pigcms_sql_log` VALUES ('463', '53400', '51dfcb66621cedc8962c2dbb4244682a08412849', '0', '0', '', '1464246282', '1464246281');
INSERT INTO `pigcms_sql_log` VALUES ('464', '53460', 'b4af70085655ca063d9f6bca0bbd5286223d8bcd', '1', '0', '', '1464246283', '1464246283');
INSERT INTO `pigcms_sql_log` VALUES ('465', '53520', '490b2e22cf4d545ef3badfd4aa94befda2870e34', '1', '0', '', '1464246285', '1464246285');
INSERT INTO `pigcms_sql_log` VALUES ('466', '53700', '300b10dcadb2ad8436a8edc2cc8c5248efed56dc', '1', '0', '', '1464246286', '1464246286');
INSERT INTO `pigcms_sql_log` VALUES ('467', '53760', '57ae244e2721d3280e6780133e3ce940162970a1', '1', '0', '', '1464246288', '1464246288');
INSERT INTO `pigcms_sql_log` VALUES ('468', '53820', '69e8392a67a43980bae77146eb2ff85759f7bcca', '1', '0', '', '1464246289', '1464246289');
INSERT INTO `pigcms_sql_log` VALUES ('469', '53880', '3a5ddf9bc17429e6c3dacdd31a24b9d6e59430a6', '1', '0', '', '1464246291', '1464246291');
INSERT INTO `pigcms_sql_log` VALUES ('470', '53940', '600dd4ad7dab70eaf460495953f1c86b2e36da6f', '1', '0', '', '1464246292', '1464246292');
INSERT INTO `pigcms_sql_log` VALUES ('471', '54000', 'f3f80411bbf3189e4925b717c24d9a8cff606b44', '1', '0', '', '1464246293', '1464246293');
INSERT INTO `pigcms_sql_log` VALUES ('472', '54060', 'a76e95c814bc023772db85a14c4e814d35a2742b', '1', '0', '', '1464246295', '1464246295');
INSERT INTO `pigcms_sql_log` VALUES ('473', '54120', '1f6c3506b04c978806cb5956a1b5e5511e0f0e1b', '1', '0', '', '1464246296', '1464246296');
INSERT INTO `pigcms_sql_log` VALUES ('474', '54180', 'dcc38ef371c3ec1ce389458ab0a6d38cfac2b7a6', '1', '0', '', '1464246299', '1464246299');
INSERT INTO `pigcms_sql_log` VALUES ('475', '54240', '31c30dbe105438a28e3665a83b561ea7ba584d8d', '1', '0', '', '1464246300', '1464246300');
INSERT INTO `pigcms_sql_log` VALUES ('476', '54300', '1ef3664be584b8ff818fbbd97a8eb86a0890a258', '1', '0', '', '1464246302', '1464246302');
INSERT INTO `pigcms_sql_log` VALUES ('477', '54360', '1164bff75855c47dfa129b8005de38376cd5f338', '1', '0', '', '1464246303', '1464246303');
INSERT INTO `pigcms_sql_log` VALUES ('478', '54420', 'e4d8c9147bf6d0557d472ea804a68284f35370f7', '1', '0', '', '1464246305', '1464246305');
INSERT INTO `pigcms_sql_log` VALUES ('479', '54480', 'd5e881558bfb8dcdcd39f58fc38ae687daf3fcbc', '1', '0', '', '1464246306', '1464246306');
INSERT INTO `pigcms_sql_log` VALUES ('480', '54540', '823dd836590de83fa00648a94aa6b791783f4213', '1', '0', '', '1464246308', '1464246308');
INSERT INTO `pigcms_sql_log` VALUES ('481', '54600', '34b1509ad5c8eb392a2943e29c9d86dfd3dfba0a', '1', '0', '', '1464246309', '1464246309');
INSERT INTO `pigcms_sql_log` VALUES ('482', '54660', '51dbff0cf9ace488d4c33cc3f4a1296a6ead6b21', '1', '0', '', '1464246311', '1464246311');
INSERT INTO `pigcms_sql_log` VALUES ('483', '54720', '75fc5834e39a32765776a9c3f8ff5bf9b4b4fcaa', '1', '0', '', '1464246312', '1464246312');
INSERT INTO `pigcms_sql_log` VALUES ('484', '54780', '99e9f614c011aa6eb1d5b73c3fae5da9f72d3239', '1', '0', '', '1464246313', '1464246313');
INSERT INTO `pigcms_sql_log` VALUES ('485', '54840', 'e4f8430009b540a8822f9ebfe66570314e279707', '1', '0', '', '1464246315', '1464246315');
INSERT INTO `pigcms_sql_log` VALUES ('486', '54900', '08d3149e93fa394b74bf6d75b849dc9989f2145c', '1', '0', '', '1464246316', '1464246316');
INSERT INTO `pigcms_sql_log` VALUES ('487', '54960', 'f46f1946d62611e541b73fba459bff52092ac2f0', '1', '0', '', '1464246318', '1464246318');
INSERT INTO `pigcms_sql_log` VALUES ('488', '55020', 'bd878425870339a16635cdff0083cc68953c9854', '0', '0', '', '1464246321', '1464246319');
INSERT INTO `pigcms_sql_log` VALUES ('489', '55080', 'f349361e278aff9a3c505a8e90cd440192190392', '1', '0', '', '1464416847', '1464416847');
INSERT INTO `pigcms_sql_log` VALUES ('490', '55200', 'ae71f26d727acbe92c70d83cec5996ea49f6eb88', '1', '0', '', '1464416848', '1464416848');
INSERT INTO `pigcms_sql_log` VALUES ('491', '55320', '7dee3681c2f2293a2b04158974f1bdb5aef0e195', '1', '0', '', '1464416850', '1464416850');
INSERT INTO `pigcms_sql_log` VALUES ('492', '55380', '473cac73f3fbaac175fdb4bee9f7b3e3ae31e483', '1', '0', '', '1464418124', '1464418124');
INSERT INTO `pigcms_sql_log` VALUES ('493', '55440', '6ce5970e860ab525a548c9668e557b4019c86595', '1', '0', '', '1464418125', '1464418125');
INSERT INTO `pigcms_sql_log` VALUES ('494', '55500', '7b8778693d5af900f8d718a1e98a70f2899d7b17', '1', '0', '', '1464745251', '1464745251');
INSERT INTO `pigcms_sql_log` VALUES ('495', '55560', '8489193d0b1c027bdcead531ca50cf6511e1da15', '1', '0', '', '1464745252', '1464745252');
INSERT INTO `pigcms_sql_log` VALUES ('496', '55620', 'bfeea1657c0a7eb2b9e929d9cac51a53cdc59d77', '1', '0', '', '1464745254', '1464745254');

-- ----------------------------
-- Table structure for `pigcms_store`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store`;
CREATE TABLE `pigcms_store` (
  `store_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺id',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '会员id',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '店铺名称',
  `edit_name_count` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '店铺名修改次数',
  `logo` varchar(200) NOT NULL DEFAULT '' COMMENT '店铺logo',
  `qcode` varchar(300) NOT NULL COMMENT '店铺二维码',
  `openid` varchar(50) NOT NULL COMMENT '微信唯一标识 (关联绑定公众号)',
  `qcode_starttime` int(11) NOT NULL COMMENT '二维码开始生效时间',
  `sale_category_fid` int(11) NOT NULL,
  `sale_category_id` int(10) NOT NULL DEFAULT '0' COMMENT '主营类目',
  `linkman` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `legal_person` varchar(30) NOT NULL DEFAULT '' COMMENT '店铺法人姓名',
  `tel` varchar(20) NOT NULL DEFAULT '' COMMENT '电话',
  `intro` varchar(1000) NOT NULL DEFAULT '' COMMENT '店铺简介',
  `approve` char(1) NOT NULL DEFAULT '0' COMMENT '认证 0未认证 1已证',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '状态 0禁用 1启用',
  `public_display` tinyint(1) DEFAULT '1' COMMENT '开启后将会在微信综合商城 和 pc综合商城展示 0：不展示，1：展示',
  `date_added` varchar(20) NOT NULL DEFAULT '' COMMENT '店铺入驻时间',
  `service_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '客服电话',
  `service_qq` varchar(15) NOT NULL DEFAULT '' COMMENT '客服qq',
  `service_weixin` varchar(60) NOT NULL DEFAULT '' COMMENT '客服微信',
  `bind_weixin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '绑定微信 0未绑定 1已绑定',
  `weixin_name` varchar(60) NOT NULL DEFAULT '' COMMENT '公众号名称',
  `weixin_original_id` varchar(20) NOT NULL DEFAULT '' COMMENT '微信原始ID',
  `weixin_id` varchar(20) NOT NULL DEFAULT '' COMMENT '微信ID',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'qq',
  `open_weixin` char(1) NOT NULL DEFAULT '0' COMMENT '绑定微信',
  `buyer_selffetch` char(1) NOT NULL DEFAULT '0' COMMENT '买家上门自提',
  `buyer_selffetch_name` varchar(50) NOT NULL COMMENT '“上门自提”自定义名称',
  `pay_agent` char(1) NOT NULL DEFAULT '0' COMMENT '代付',
  `offline_payment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支持货到付款，0：是，1：否',
  `open_logistics` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启物流配送，1：开启，0：关闭',
  `open_friend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启送朋友，1：是，0：否',
  `open_autoassign` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启订单自动分配到门店： 1是 0否',
  `open_local_logistics` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用本地化物流: 0否 1是',
  `warn_sp_quantity` int(8) NOT NULL DEFAULT '0' COMMENT '门店库存报警：0为不报警',
  `open_nav` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启店铺导航',
  `nav_style_id` tinyint(1) NOT NULL DEFAULT '1' COMMENT '店铺导航样式',
  `use_nav_pages` varchar(20) NOT NULL DEFAULT '1' COMMENT '使用导航菜单的页面 1店铺主页 2会员主页 3微页面及分类 4商品分组 5商品搜索',
  `open_ad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开启广告',
  `has_ad` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有店铺广告',
  `ad_position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '广告位置 0页面头部 1页面底部',
  `use_ad_pages` varchar(20) NOT NULL DEFAULT '' COMMENT '使用广告的页面 1微页面 2微页面分类 3商品 4商品分组 5店铺主页 6会员主页',
  `date_edited` varchar(20) NOT NULL DEFAULT '' COMMENT '更新时间',
  `sales` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '销售额',
  `income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '店铺收入',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '未提现余额',
  `unbalance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '不可用余额',
  `margin_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '保证金余额',
  `point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分总额',
  `point_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分余额',
  `point2money` float(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '变现积分可提现余额',
  `point2money_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总额(变现积分)',
  `point2money_service_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分变现服务费总额',
  `point2money_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已提现金额(积分兑换)',
  `point2money_withdrawal` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `point2user` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '店铺积分转用户积分',
  `cash_point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '店铺抵现积分(线下做单)',
  `margin_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '保证金总额',
  `orders` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单数',
  `store_pay_income` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '店铺收款总额',
  `withdrawal_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '已提现金额',
  `withdrawal_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '提现方式 0对私 1对公',
  `bank_id` int(5) NOT NULL DEFAULT '0' COMMENT '开户银行',
  `bank_card` varchar(30) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `bank_card_user` varchar(30) NOT NULL DEFAULT '' COMMENT '开卡人姓名',
  `opening_bank` varchar(30) NOT NULL DEFAULT '' COMMENT '开户行',
  `last_edit_time` varchar(20) NOT NULL DEFAULT '' COMMENT '最后修改时间',
  `physical_count` smallint(6) NOT NULL,
  `drp_supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销店铺供货商id',
  `root_supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '顶级供货商id',
  `drp_level` tinyint(3) NOT NULL DEFAULT '0' COMMENT '分销级别',
  `collect` int(11) unsigned NOT NULL COMMENT '店铺收藏数',
  `wxpay` tinyint(1) NOT NULL DEFAULT '0',
  `open_drp_approve` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启分销商审核',
  `drp_approve` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分销商审核状态',
  `drp_profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润',
  `drp_profit_withdrawal` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润提现',
  `dividends1` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分红',
  `open_service` tinyint(1) NOT NULL COMMENT '是否开启客服',
  `attention_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数',
  `source_site_url` varchar(200) NOT NULL DEFAULT '' COMMENT '对接来源网站url',
  `payment_url` varchar(200) NOT NULL DEFAULT '' COMMENT '站外支付地址',
  `notify_url` varchar(200) NOT NULL DEFAULT '' COMMENT '通知地址',
  `oauth_url` varchar(200) NOT NULL DEFAULT '' COMMENT '对接网站用户认证地址',
  `token` varchar(100) NOT NULL DEFAULT '' COMMENT '微信token',
  `open_drp_guidance` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '店铺分销引导',
  `open_drp_limit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分销限制',
  `drp_limit_buy` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '消费多少金额可分销',
  `drp_limit_share` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分享多少次可分销',
  `drp_limit_condition` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 或（2个条件满足一个即可分销） 1 和（2个条件都满足即可分销）',
  `pigcmsToken` char(100) DEFAULT NULL,
  `template_cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺模板ID',
  `template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板ID',
  `tag_id` int(11) unsigned NOT NULL COMMENT '店铺标签ID',
  `open_drp_setting_price` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '开启分销价设置',
  `unified_price_setting` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '供货商统一定价',
  `open_drp_diy_store` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启分销商装修店铺配置',
  `drp_diy_store` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否有装修店铺权限',
  `open_drp_subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分销是否需要先关注公众号',
  `open_drp_subscribe_auto` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '关注自动分销',
  `drp_subscribe_tpl` varchar(500) NOT NULL DEFAULT '' COMMENT '关注后发送的消息',
  `reg_drp_subscribe_tpl` varchar(500) NOT NULL DEFAULT '' COMMENT '申请分销商关注后发送的消息',
  `is_show_drp_tel` tinyint(1) NOT NULL DEFAULT '0' COMMENT '供货商设定的分销商店铺是显示分销商电话:0，供货商电话:1',
  `degree_exchange_type` tinyint(1) DEFAULT '1' COMMENT '兑换类型：1手工兑换,2:自动升级',
  `drp_subscribe_img` varchar(500) NOT NULL DEFAULT '' COMMENT '关注后发送的消息封面图片',
  `reg_drp_subscribe_img` varchar(500) NOT NULL DEFAULT '' COMMENT '申请分销商关注后发送的消息封面图片',
  `update_drp_store_info` tinyint(1) DEFAULT '1' COMMENT '是否允许分销商修改店铺名称(默认允许)',
  `is_official_shop` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为官方店铺',
  `setting_fans_forever` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝是否终身制',
  `is_fanshare_drp` tinyint(1) DEFAULT '0' COMMENT '分享自动成为分销商：0否，1是',
  `is_required_to_audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要审核批发商(默认不允许)',
  `is_required_margin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要审核交纳保证金(默认不需要)',
  `bond` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金额度',
  `setting_canal_qrcode` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '设置渠道二维码',
  `canal_qrcode_img` varchar(500) NOT NULL COMMENT '分销渠道二维码图片',
  `canal_qrcode_tpl` varchar(500) NOT NULL COMMENT '渠道二维码消息模版',
  `open_drp_team` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启分销团队',
  `drp_team_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销团队id',
  `is_point_mall` tinyint(1) DEFAULT '0' COMMENT '是否积分商城 0:否 1:是',
  `open_store_whole` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排他批发',
  `drp_deduct_point_month` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '扣除分销商等级积分条件(月数)',
  `drp_deduct_point_sales` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '扣除分销商等级积分条件(销售额)',
  `drp_deduct_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扣除分销商等级积分',
  `last_time_statistics` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次统计销售额时间（扣分销商等级积分）',
  `last_recharge_notice_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '保证金充值最后通知时间',
  `recharge_notice_count` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '保证金充值每日最大通知次数',
  `drp_degree_id` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '分销商等级id',
  `open_drp_degree` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启分销商等级',
  `is_show_float_menu` tinyint(3) unsigned NOT NULL COMMENT '是否显示浮动菜单',
  `last_fh_sendtime_1` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次分红发放时间（对象：经销商）',
  `last_fh_sendtime_2` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次分红发放时间（对象：团队）',
  `last_fh_sendtime_3` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次分红发放时间（对象：分销商）',
  `is_show_recharge_button` tinyint(1) unsigned NOT NULL COMMENT '商铺是否显示保证金充值按钮 0 不显示（默认） 1显示',
  `is_available` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '店铺是否有效',
  `expiration` int(11) unsigned NOT NULL COMMENT '店铺到期时间',
  `margin_withdrawal` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台保证金已提现金额',
  `store_pic` varchar(50) DEFAULT NULL COMMENT '门头照',
  `contract` text COMMENT '合同照片',
  `drp_withdrawal_min` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销商最低提现金额',
  `sales_ratio` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商家销售分成比例',
  `order_notice_open` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启: 默认0否 1是',
  `order_notice_time` int(10) unsigned NOT NULL DEFAULT '5' COMMENT '消息提示的时间(秒): 默认5秒',
  `margin_amount` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启保证金最低额度提醒',
  `margin_minimum` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金最低额度',
  PRIMARY KEY (`store_id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `token` (`token`),
  KEY `drp_team_id` (`drp_team_id`) USING BTREE,
  KEY `drp_degree_id` (`drp_degree_id`),
  KEY `last_time_statistics` (`last_time_statistics`) USING BTREE,
  KEY `tag_id` (`tag_id`),
  KEY `root_supplier_id` (`root_supplier_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='店铺';

-- ----------------------------
-- Records of pigcms_store
-- ----------------------------
INSERT INTO `pigcms_store` VALUES ('1', '6', '111111', '0', '', '', '', '0', '1', '0', '111111', '111111', '18730608396', '', '2', '1', '1', '1464247764', '', '', '', '0', '', '', '', '111111', '0', '0', '', '1', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', '39d5f4770ff54bcc', '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '1', '1', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('2', '6', '1111112', '0', '', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQG08DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzJVTWltQS1sdTRUQ00wWHl4VzF1AAIEJMVPVwMEgDoJAA%3D%3D', '', '1464845604', '1', '0', '111111', '111111', '11111111111', '', '0', '1', '1', '1464247788', '', '', '', '0', '', '', '', '111111', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('18', '5', '官方示例店铺', '0', '', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQH77zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3BVUEg2cVRsWFlRa2xqbURJRzF1AAIEXd9OVwMEgDoJAA%3D%3D', '', '1464786781', '1', '0', '测试', '', '13000000000', '', '0', '1', '1', '1438825585', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '1', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '6', '6', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '1', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('4', '5', '平台积分商城', '0', '', '', '', '0', '1', '0', '测试', '', '13000000000', '', '0', '1', '1', '1438825585', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '1', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('5', '7', '1111222', '0', '', '', '', '0', '1', '0', '111', '1111222', '18730608396', '', '0', '1', '1', '1464258428', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', '49cd4215d0bb4c6f', '3', '4', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('6', '5', '1111222ww', '0', '', '', '', '0', '1', '0', '111111', '1111222', '13800138000', '', '0', '1', '1', '1464258673', '', '', '', '0', '', '', '', '111111', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('7', '7', '1111222e', '0', '', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQH98DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3pFTUF2ZExsOVlTTTNsQzc1MjF1AAIEboFQVwMEgDoJAA%3D%3D', '', '1464893806', '1', '0', '111111', '1111222', '13800138000', '', '0', '1', '1', '1464258704', '', '', '', '0', '', '', '', '111111', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('8', '7', '111122222g', '0', '', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQGk8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3FVTlljWkhsMElTcE5EVUt2MjF1AAIEIMZPVwMEgDoJAA%3D%3D', '', '1464845856', '1', '0', '111111', '1111222', '13800138000', '', '0', '1', '1', '1464259366', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '3', '4', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('9', '8', '11111111', '0', '', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQHg7zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLy1FTXZCRGZsc29UTHNtQnF5RzF1AAIEXt9OVwMEgDoJAA%3D%3D', '', '1464786782', '1', '0', '111', '11111', '13800138000', '', '2', '1', '1', '1464260591', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '6', '7', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('10', '5', '111122212d', '0', '', '', '', '0', '1', '0', '111111', '1111222', '13800138000', '', '0', '4', '1', '1464312520', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('11', '7', '1111222ddd', '0', '', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQEZ8ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzkwTWVUbC1sZzRUNm0yc2dfVzF1AAIE2MVPVwMEgDoJAA%3D%3D', '', '1464845784', '1', '0', '111111', '1111222', '13800138000', '', '0', '1', '1', '1464312601', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '5', '6', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('12', '9', '呼呼店铺', '0', 'images/default_shop_2.jpg', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQH07zoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzBVTXVrY3psdm9USDhVM3l5VzF1AAIE4iFRVwMEgDoJAA%3D%3D', '', '1464934882', '2', '0', '呼呼', '呼呼', '13822222222', '', '2', '1', '1', '1464315126', '', '', '', '0', '', '', '', '58942556', '0', '0', '', '0', '0', '1', '0', '0', '0', '10', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '1', '', '', '', '1464347854', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '0', '1', '10.00', '0', '0', null, '7', '8', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '0', '0', '1', '0', '1', '1', '10.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '0.00', null, 'null', '10.00', '0.00', '0', '5', '0', '10.00');
INSERT INTO `pigcms_store` VALUES ('13', '7', '333', '0', '', '', '', '0', '1', '0', '33', '33333', '33333333333', '', '0', '1', '1', '1464319111', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '1', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '3', '4', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '0.00', null, 'null', '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('14', '7', '666666', '0', '', '', '', '0', '1', '0', '6666', '6666', '66666666666', '', '0', '1', '1', '1464340760', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('15', '7', '666', '0', '', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQHT8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL3UwTWNBQjdsaFlUODJDZHFfMjF1AAIERMRPVwMEgDoJAA%3D%3D', '', '1464845380', '1', '0', '666', '666666', '66666666666', '', '0', '1', '1', '1464340915', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('16', '7', '44', '0', '', '', '', '0', '2', '0', '4444', '4444', '44444444444', '', '0', '1', '1', '1464343879', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('17', '9', '哈哈哈', '0', '', '', '', '0', '2', '0', '呼呼', '呼呼', '15249917505', '', '2', '1', '1', '1464346625', '', '', '', '0', '', '', '', '8545155', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '6', '7', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('19', '7', '444', '0', '', '', '', '0', '1', '0', '4444', '4444', '44444444444', '', '0', '1', '1', '1464588217', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('20', '7', '444444', '0', '', '', '', '0', '1', '0', '4444', '4444', '44444444444', '', '0', '1', '1', '1464588359', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('21', '7', '33', '0', '', 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQH08DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL25FTkxiMFBsd1lTNHpRQVdyRzF1AAIE9IdQVwMEgDoJAA%3D%3D', '', '1464895476', '1', '0', '33', '3333', '33333333333', '', '0', '1', '1', '1464596171', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('22', '7', '33yy', '0', '', '', '', '0', '1', '0', '33', '3333', '33333333333', '', '0', '1', '1', '1464596508', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '0', '0', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('23', '7', 'www', '0', '', '', '', '0', '1', '0', 'wwww', '111', '11111111111', '', '0', '1', '1', '1464603551', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '20', '35', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('24', '7', 'rryt6', '0', '', '', '', '0', '1', '0', 'rr', 'rr', '88888888888', '', '0', '1', '1', '1464604920', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '17', '32', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');
INSERT INTO `pigcms_store` VALUES ('25', '7', '886', '0', '', '', '', '0', '1', '0', '777', '777', '77979999999', '', '0', '1', '1', '1464608695', '', '', '', '0', '', '', '', '', '0', '0', '', '0', '0', '1', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '0.00', '0.00', '0', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '1', '0.00', '0.00', '0.00', '0', '0', '', '', '', '', '', '1', '0', '0.00', '0', '0', null, '20', '35', '0', '1', '1', '1', '1', '0', '0', '', '', '0', '1', '', '', '1', '0', '0', '0', '0', '0', '0.00', '0', '', '', '1', '0', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0.00', null, null, '0.00', '0.00', '0', '5', '0', '0.00');

-- ----------------------------
-- Table structure for `pigcms_store_analytics`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_analytics`;
CREATE TABLE `pigcms_store_analytics` (
  `pigcms_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问用户id',
  `module` varchar(30) NOT NULL DEFAULT '' COMMENT '模块名',
  `title` varchar(300) NOT NULL DEFAULT '' COMMENT '页面标题',
  `page_id` int(10) NOT NULL DEFAULT '0' COMMENT '页面id',
  `visited_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '访问时间',
  `visited_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '访问ip',
  `duration_time` float unsigned NOT NULL DEFAULT '0' COMMENT '页面停留时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`uid`,`store_id`,`visited_time`,`visited_ip`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='店铺访问统计';

-- ----------------------------
-- Records of pigcms_store_analytics
-- ----------------------------
INSERT INTO `pigcms_store_analytics` VALUES ('1', '1', '0', 'home', '这是您的第一篇微杂志', '1', '1464251098', '1786315414', '4.791');
INSERT INTO `pigcms_store_analytics` VALUES ('2', '1', '0', 'home', '这是您的第一篇微杂志', '1', '1464251247', '2071355825', '0');
INSERT INTO `pigcms_store_analytics` VALUES ('3', '1', '0', 'home', '这是您的第一篇微杂志', '1', '1464251323', '1786315414', '1.614');
INSERT INTO `pigcms_store_analytics` VALUES ('4', '3', '0', 'wei_page', '微页面 - 美妆电商模板', '6', '1464257666', '2071355825', '2.416');
INSERT INTO `pigcms_store_analytics` VALUES ('5', '3', '0', 'wei_page', '微页面 - 鲜花速递模板', '8', '1464258215', '2071355825', '0');
INSERT INTO `pigcms_store_analytics` VALUES ('6', '5', '0', 'wei_page', '微页面 - 餐饮外卖模板', '9', '1464258552', '2071355825', '0');
INSERT INTO `pigcms_store_analytics` VALUES ('7', '3', '0', 'wei_page', '微页面 - 测试模版', '10', '1464258628', '2071355825', '1.371');
INSERT INTO `pigcms_store_analytics` VALUES ('8', '3', '0', 'wei_page', '微页面 - 食品电商模板', '5', '1464258756', '2071355825', '0');
INSERT INTO `pigcms_store_analytics` VALUES ('9', '3', '0', 'wei_page', '微页面 - 餐饮外卖模板', '4', '1464260669', '2073503778', '0');
INSERT INTO `pigcms_store_analytics` VALUES ('10', '3', '0', 'wei_page', '微页面 - 鲜花速递模板', '8', '1464336249', '3722210107', '0');
INSERT INTO `pigcms_store_analytics` VALUES ('11', '16', '0', 'wei_page', '微页面 - 这是您的第一篇微杂志', '22', '1464582807', '2071356411', '1.8');

-- ----------------------------
-- Table structure for `pigcms_store_area_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_area_record`;
CREATE TABLE `pigcms_store_area_record` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺',
  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '市',
  `county` varchar(30) NOT NULL DEFAULT '' COMMENT '区',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态：0关闭 1使用 默认为0',
  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '修改管理员admin_id，默认0 为用户修改记录',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='店铺区域修改记录';

-- ----------------------------
-- Records of pigcms_store_area_record
-- ----------------------------
INSERT INTO `pigcms_store_area_record` VALUES ('1', '1', '120000', '120100', '120101', '1464247764', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('2', '2', '110000', '110100', '110101', '1464247788', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('3', '5', '110000', '110100', '110101', '1464258428', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('4', '6', '110000', '110100', '110101', '1464258673', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('5', '7', '110000', '110100', '110101', '1464258704', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('6', '8', '110000', '110100', '110101', '1464259366', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('7', '9', '110000', '110100', '110101', '1464260591', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('8', '10', '110000', '110100', '110101', '1464312520', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('9', '11', '110000', '110100', '110101', '1464312601', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('10', '12', '340000', '340100', '340186', '1464315126', '0', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('11', '13', '110000', '110100', '110101', '1464319111', '0', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('12', '13', '110000', '110100', '110101', '1464332888', '1', '1');
INSERT INTO `pigcms_store_area_record` VALUES ('13', '14', '110000', '110100', '110101', '1464340760', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('14', '15', '110000', '110100', '110101', '1464340915', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('15', '16', '110000', '110100', '110101', '1464343879', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('16', '17', '110000', '110200', '110228', '1464346625', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('17', '12', '340000', '340100', '340186', '1464347203', '1', '1');
INSERT INTO `pigcms_store_area_record` VALUES ('18', '19', '110000', '110100', '110105', '1464588217', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('19', '20', '110000', '110100', '110101', '1464588359', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('20', '21', '110000', '110100', '110101', '1464596171', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('21', '22', '110000', '110100', '110101', '1464596508', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('22', '23', '110000', '110100', '110102', '1464603551', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('23', '24', '110000', '110100', '110101', '1464604920', '1', '0');
INSERT INTO `pigcms_store_area_record` VALUES ('24', '25', '110000', '110100', '110101', '1464608695', '1', '0');

-- ----------------------------
-- Table structure for `pigcms_store_brand`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_brand`;
CREATE TABLE `pigcms_store_brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL COMMENT '商铺品牌名',
  `pic` varchar(200) NOT NULL COMMENT '品牌图片',
  `order_by` int(100) NOT NULL DEFAULT '0' COMMENT '排序，越小越前面',
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `type_id` int(11) NOT NULL COMMENT '所属品牌类别id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用（1：启用；  0：禁用）',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商铺品牌表';

-- ----------------------------
-- Records of pigcms_store_brand
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_brand_type`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_brand_type`;
CREATE TABLE `pigcms_store_brand_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) NOT NULL COMMENT '商铺品牌类别名',
  `order_by` int(10) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '品牌状态（1：开启，0：禁用）',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商铺品牌类别表';

-- ----------------------------
-- Records of pigcms_store_brand_type
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_config`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_config`;
CREATE TABLE `pigcms_store_config` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `drp_profit_1` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分润百分比',
  `drp_profit_2` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分润百分比',
  `drp_profit_3` decimal(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '统一直销利润',
  `unified_profit` tinyint(1) NOT NULL,
  `drp_original_setting` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '保留原分销设置',
  `last_edit_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后一次修改时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='店铺配置';

-- ----------------------------
-- Records of pigcms_store_config
-- ----------------------------
INSERT INTO `pigcms_store_config` VALUES ('11', '12', '10.00', '20.00', '30.00', '1', '1', '1464347828');

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
  PRIMARY KEY (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_store_contact
-- ----------------------------
INSERT INTO `pigcms_store_contact` VALUES ('1', '', '', '120000', '120100', '120101', '111111333', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('2', '', '', '110000', '110100', '110101', '111111', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('5', '', '', '110000', '110100', '110101', '1111', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('6', '', '', '110000', '110100', '110101', '111111333', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('7', '', '', '110000', '110100', '110101', '666666', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('8', '', '', '110000', '110100', '110101', '666666', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('9', '', '', '110000', '110100', '110101', '1111', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('10', '', '', '110000', '110100', '110101', '111111333', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('11', '', '', '110000', '110100', '110101', '111111333', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('12', '122', '2255448', '340000', '340100', '340186', '天鹅湖路', '117.234550', '31.828780', '1464316648');
INSERT INTO `pigcms_store_contact` VALUES ('13', '', '', '110000', '110100', '110101', '33', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('14', '', '', '110000', '110100', '110101', '66', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('15', '', '', '110000', '110100', '110101', '66', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('16', '', '', '110000', '110100', '110101', '44', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('17', '', '', '110000', '110200', '110228', '和散热', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('19', '', '', '110000', '110100', '110105', '44', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('20', '', '', '110000', '110100', '110101', '44', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('21', '', '', '110000', '110100', '110101', '333', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('22', '', '', '110000', '110100', '110101', '333', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('23', '', '', '110000', '110100', '110102', '111', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('24', '', '', '110000', '110100', '110101', 'eyt', '0.000000', '0.000000', '0');
INSERT INTO `pigcms_store_contact` VALUES ('25', '', '', '110000', '110100', '110101', '88', '0.000000', '0.000000', '0');

-- ----------------------------
-- Table structure for `pigcms_store_fans_forever`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_fans_forever`;
CREATE TABLE `pigcms_store_fans_forever` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `openid` varchar(50) NOT NULL DEFAULT '' COMMENT '粉丝店铺openid',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关注时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 不限制  1 限制',
  PRIMARY KEY (`pigcms_id`),
  KEY `uid` (`uid`,`store_id`) USING BTREE,
  KEY `store_id` (`store_id`,`openid`) USING BTREE,
  KEY `openid` (`openid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户最后访问店铺记录';

-- ----------------------------
-- Records of pigcms_store_fans_forever
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_media`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_media`;
CREATE TABLE `pigcms_store_media` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商id',
  `seller_id` int(11) unsigned NOT NULL COMMENT '分销商id',
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `media_id` varchar(250) NOT NULL COMMENT '推广图片媒体id',
  `media_time` int(11) unsigned NOT NULL COMMENT '媒体图片上传时间',
  `add_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `supplier_id` (`supplier_id`,`seller_id`,`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_store_media
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_nav`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_nav`;
CREATE TABLE `pigcms_store_nav` (
  `store_nav_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '店铺导航id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `style` tinyint(1) NOT NULL DEFAULT '1' COMMENT '导航样式',
  `bgcolor` char(7) NOT NULL DEFAULT '' COMMENT '背景颜色',
  `data` text NOT NULL COMMENT '店铺导航数据',
  `date_added` varchar(20) NOT NULL,
  PRIMARY KEY (`store_nav_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `store_nav_template_id` (`style`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='店铺导航';

-- ----------------------------
-- Records of pigcms_store_nav
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_notice_manage`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_notice_manage`;
CREATE TABLE `pigcms_store_notice_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',
  `has_power` varchar(250) DEFAULT NULL COMMENT '拥有的权限,例:88^1,2|  88表示模板消息id, 1代表拥有短信 2代表拥有微信通知权限',
  `timestamp` int(11) DEFAULT NULL COMMENT '最近修改的时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺短信/通知权限表';

-- ----------------------------
-- Records of pigcms_store_notice_manage
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_orderprint_machine`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_orderprint_machine`;
CREATE TABLE `pigcms_store_orderprint_machine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `mobile` char(20) DEFAULT NULL COMMENT '绑定手机号',
  `username` varchar(250) DEFAULT NULL COMMENT '绑定帐号',
  `terminal_number` varchar(250) DEFAULT NULL COMMENT '终端号',
  `keys` varchar(250) DEFAULT NULL COMMENT '密钥',
  `counts` int(11) NOT NULL DEFAULT '0' COMMENT '打印份数',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '打印类型:1.只打印付过款的,2:无论是否付款都打印',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启:0.关闭，1.开启',
  `timestamp` int(11) DEFAULT NULL COMMENT '保存/修改的 时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商铺订单打印机';

-- ----------------------------
-- Records of pigcms_store_orderprint_machine
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_pay_agent`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_pay_agent`;
CREATE TABLE `pigcms_store_pay_agent` (
  `agent_id` int(10) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `nickname` varchar(30) NOT NULL DEFAULT '' COMMENT '昵称',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '类型 0 发起人 1 代付人',
  `content` varchar(200) NOT NULL DEFAULT '' COMMENT '内容',
  PRIMARY KEY (`agent_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='找人代付';

-- ----------------------------
-- Records of pigcms_store_pay_agent
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_physical`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_physical`;
CREATE TABLE `pigcms_store_physical` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_store_physical
-- ----------------------------
INSERT INTO `pigcms_store_physical` VALUES ('1', '18', '010', '69889988', '110000', '110100', '110101', '后挨饿哦啊是发的', '116.408847', '39.921694', '1464769522', '精品蔬菜', 'images/000/000/018/201606/574e9beeacb56.jpg', '', '');

-- ----------------------------
-- Table structure for `pigcms_store_physical_courier`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_physical_courier`;
CREATE TABLE `pigcms_store_physical_courier` (
  `courier_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` char(50) NOT NULL COMMENT '配送员名称',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别(默认1)：0女 1男',
  `avatar` char(150) NOT NULL COMMENT '客服头像',
  `tel` char(20) NOT NULL COMMENT '手机号',
  `openid` char(60) NOT NULL COMMENT '绑定openid',
  `store_id` int(11) NOT NULL COMMENT '所属店铺',
  `physical_id` int(11) NOT NULL COMMENT '所属门店',
  `status` tinyint(4) NOT NULL COMMENT '配送员状态：0关闭 1启用',
  `long` decimal(10,6) NOT NULL COMMENT '配送员 经度',
  `lat` decimal(10,6) NOT NULL COMMENT '配送员 纬度',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `location_time` int(11) NOT NULL COMMENT '最后上报坐标时间',
  PRIMARY KEY (`courier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='本地化物流-配送员';

-- ----------------------------
-- Records of pigcms_store_physical_courier
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_physical_quantity`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_physical_quantity`;
CREATE TABLE `pigcms_store_physical_quantity` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `physical_id` int(10) NOT NULL DEFAULT '0' COMMENT '仓库/门店id',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT 'sku规格id',
  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '库存',
  PRIMARY KEY (`pigcms_id`),
  KEY `sku_id` (`sku_id`) USING BTREE,
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='仓库分配库存关系';

-- ----------------------------
-- Records of pigcms_store_physical_quantity
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_points`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_points`;
CREATE TABLE `pigcms_store_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分所属供货商店铺id',
  `drp_store_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商店铺id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分来源的订单',
  `share_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分来源的分享记录',
  `points` int(11) NOT NULL DEFAULT '0' COMMENT '获取积分数',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '积分来源 - 1:发展分销商送 2:销售额比例生成 3:分享送 4:签到送 5:推广增加 6:销售额未达标扣积分',
  `is_available` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用：0：不可以用，1可以使用',
  `is_call_to_fans` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:不发送；1发送通知粉丝获得积分',
  `timestamp` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_store_points
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_points_config`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_points_config`;
CREATE TABLE `pigcms_store_points_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '所属店铺id',
  `is_offset` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '【设置】用户积分是否允许抵现: 0否 1是',
  `price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分兑换价值：1元兑换的积分数量',
  `is_percent` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '【设置】抵现是否限制百分比：0否 1是',
  `offset_cash` decimal(5,2) unsigned NOT NULL COMMENT '抵现百分比 0-100 小数位两位数字 例如88.00',
  `is_limit` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】是否使用金额上限: 0否 1是',
  `offset_limit` int(8) unsigned NOT NULL COMMENT '每单用户积分抵现上限(金额)',
  `order_consume` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】积分赠送方式: 0满送 1消费送',
  `consume_money` int(11) unsigned NOT NULL COMMENT '单笔满送-价格(用户积分)',
  `consume_point` int(11) unsigned NOT NULL COMMENT '单笔满送-积分(用户积分)',
  `proport_money` int(11) unsigned NOT NULL COMMENT '实际消费抵换需要金额 (兑换1用户积分的金额)',
  `point_from` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】用户积分来源： 0单笔满送 1实际消费金额抵换',
  `drp1_spoint_money` int(11) unsigned NOT NULL COMMENT '销售店铺获取 (兑换1分销积分的金额)',
  `drp2_spoint_money` int(11) unsigned NOT NULL COMMENT '上一级获取积分比例(兑换1分销积分的金额)',
  `drp3_spoint_money` int(11) unsigned NOT NULL COMMENT '上二级获取积分比例(兑换1分销积分的金额)',
  `is_subscribe` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】是否开启多级推广: 0否 1是',
  `drp1_subscribe_point` int(11) unsigned NOT NULL COMMENT '关注本店获取用户积分',
  `drp2_subscribe_point` int(11) unsigned NOT NULL COMMENT '上一级推荐关注获取积分',
  `drp3_subscribe_point` int(11) unsigned NOT NULL COMMENT '上二级推荐关注获取积分',
  `is_share` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】是否开启分享获取积分 0否 1是',
  `share_click_num` int(11) unsigned NOT NULL COMMENT '分享点击(扫)数量',
  `share_click_point` int(11) unsigned NOT NULL COMMENT '分享点击(扫)-兑换的积分数',
  `drp1_spoint` int(11) unsigned NOT NULL COMMENT '成为分销商，获取店铺积分',
  `drp2_spoint` int(11) unsigned NOT NULL COMMENT '成为分销商，下一级获取积分',
  `drp3_spoint` int(11) unsigned NOT NULL COMMENT '成为分销商，下二级获取积分',
  `sign_set` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】是否开启签到：0否 1是',
  `sign_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】签到模式: 0每日积分相同 1累计模式',
  `sign_fixed_point` int(11) unsigned NOT NULL COMMENT '固定签到获取积分数',
  `sign_plus_start` int(11) unsigned NOT NULL COMMENT '首次签到积分',
  `sign_plus_addition` int(11) unsigned NOT NULL COMMENT '每日签到额外添加积分数',
  `sign_plus_day` int(11) unsigned NOT NULL COMMENT '连续签到上限天数',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='店铺积分配置';

-- ----------------------------
-- Records of pigcms_store_points_config
-- ----------------------------
INSERT INTO `pigcms_store_points_config` VALUES ('1', '12', '1', '10', '1', '20.00', '1', '10', '1', '10', '1', '10', '0', '10', '6', '2', '1', '3', '2', '1', '1', '1', '1', '3', '2', '1', '1', '0', '1', '0', '0', '0');
INSERT INTO `pigcms_store_points_config` VALUES ('2', '6', '0', '0', '0', '0.00', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `pigcms_store_point_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_point_log`;
CREATE TABLE `pigcms_store_point_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_offline_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺手工线下订单ID',
  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `point` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作积分',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '积分对应的金额',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 未处理 1 已处理',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型 0 消费产生积分+ 1 消费返还积分- 2 积分变现- 3 退货返还积分-  4 积分流转服务费-',
  `service_fee_rate` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台服务费 %（积分）',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '操作前积分总额',
  `point_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '操作前积分余额',
  `channel` tinyint(1) unsigned NOT NULL COMMENT '渠道(0表示线上交易,1表示线下交易)',
  `bak` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `order_no` (`order_no`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_store_point_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_printing_order_template`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_printing_order_template`;
CREATE TABLE `pigcms_store_printing_order_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT '订单模版所属店铺',
  `text` longtext COMMENT '订单模版内容',
  `typeid` int(11) DEFAULT NULL COMMENT '模版所属类型',
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_store_printing_order_template
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_promote_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_promote_setting`;
CREATE TABLE `pigcms_store_promote_setting` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自定义页面id',
  `store_nickname` varchar(50) NOT NULL COMMENT '店铺昵称',
  `name` varchar(50) NOT NULL COMMENT '海报名称',
  `descr` varchar(255) NOT NULL COMMENT '活动描述',
  `start_time` int(11) unsigned NOT NULL COMMENT '开始时间',
  `end_time` int(11) unsigned NOT NULL COMMENT '结束时间',
  `banner_config` text NOT NULL COMMENT '海报设置',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL COMMENT '1 正常 2 删除',
  `store_id` int(11) unsigned NOT NULL COMMENT '店铺ID',
  `update_time` int(11) unsigned NOT NULL COMMENT '修改时间',
  `poster_type` tinyint(2) unsigned NOT NULL COMMENT '1 横式模板 2 竖式模板 3 正方形模板',
  `type` tinyint(1) unsigned NOT NULL COMMENT '0 未启用 1 已启用',
  `owner` tinyint(2) unsigned NOT NULL COMMENT '1 商家 2 平台',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_store_promote_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_subject_data`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_subject_data`;
CREATE TABLE `pigcms_store_subject_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL COMMENT '指定专题',
  `dz_count` int(11) DEFAULT '0' COMMENT '专题点赞总数',
  `share_count` int(11) DEFAULT '0' COMMENT '分享次数',
  `pinlun_count` int(11) DEFAULT '0' COMMENT '评论数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_store_subject_data
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_supplier`;
CREATE TABLE `pigcms_store_supplier` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商店铺id',
  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商店铺id',
  `supply_chain` varchar(500) NOT NULL DEFAULT '' COMMENT '供货链',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '级别',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分销类型，0 全网分销 1排他分销',
  `root_supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '顶级供货商店铺id',
  PRIMARY KEY (`pigcms_id`),
  KEY `supplier_id` (`supplier_id`) USING BTREE,
  KEY `seller_id` (`seller_id`) USING BTREE,
  KEY `root_supplier_id` (`root_supplier_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='供货商';

-- ----------------------------
-- Records of pigcms_store_supplier
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_system_notice_manage`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_system_notice_manage`;
CREATE TABLE `pigcms_store_system_notice_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',
  `has_power` varchar(250) DEFAULT NULL COMMENT '拥有的权限,例:88^1,2|  88表示模板消息id, 1代表拥有短信 2代表拥有微信通知权限',
  `timestamp` int(11) DEFAULT NULL COMMENT '最近修改的时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='店铺短信/通知权限表';

-- ----------------------------
-- Records of pigcms_store_system_notice_manage
-- ----------------------------
INSERT INTO `pigcms_store_system_notice_manage` VALUES ('1', '12', '1^1,2|2^1,2|3^1,2|4^1,2|5^1,2|6^1,2|7^1,2|8^1,2|9^1,2|10^1,2|11^1,2|12^1,2', '1464417120');
INSERT INTO `pigcms_store_system_notice_manage` VALUES ('2', '1', '', '1464413502');
INSERT INTO `pigcms_store_system_notice_manage` VALUES ('3', '5', '', '1464413729');

-- ----------------------------
-- Table structure for `pigcms_store_tag`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_tag`;
CREATE TABLE `pigcms_store_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL COMMENT '名称',
  `order_by` int(100) NOT NULL DEFAULT '0' COMMENT '排序，越小越前面',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用（1：启用；  0：禁用）',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺类别表';

-- ----------------------------
-- Records of pigcms_store_tag
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_user_data`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_user_data`;
CREATE TABLE `pigcms_store_user_data` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `point` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺返还积分(有消耗)',
  `point_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺返还总积分(无消耗)',
  `store_point` int(11) NOT NULL DEFAULT '0' COMMENT '用户分销商店铺的积分（可消费）',
  `store_point_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户分销商店铺的积分（不可消费）',
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '店铺消费总金额',
  `order_unpay` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '未付款订单数',
  `order_unsend` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '未发货订单数',
  `order_send` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '已发货订单数',
  `order_complete` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '交易完成订单数',
  `sign_days` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '连续签到天数',
  `sign_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次签到日期，格式：年月日',
  `degree_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员所属等级',
  `degree_date` int(11) NOT NULL DEFAULT '0' COMMENT '用户等级到期时间，0表示未统计',
  `degree_update_date` int(11) NOT NULL DEFAULT '0' COMMENT '等级变更日期，用于每天更新一次，减少服务器压力',
  `last_time` int(11) NOT NULL,
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`,`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='店铺用户数据表';

-- ----------------------------
-- Records of pigcms_store_user_data
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_store_withdrawal`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_store_withdrawal`;
CREATE TABLE `pigcms_store_withdrawal` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `trade_no` varchar(100) NOT NULL DEFAULT '' COMMENT '交易号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',
  `bank_id` int(11) NOT NULL DEFAULT '0' COMMENT '银行id',
  `opening_bank` varchar(30) NOT NULL DEFAULT '' COMMENT '开户行',
  `bank_card` varchar(30) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `bank_card_user` varchar(30) NOT NULL DEFAULT '' COMMENT '开卡人姓名',
  `withdrawal_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '提现方式 0对私 1对公',
  `add_time` varchar(20) NOT NULL DEFAULT '' COMMENT '申请时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1申请中 2银行处理中 3提现成功 4提现失败',
  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `complate_time` varchar(20) NOT NULL DEFAULT '' COMMENT '完成时间',
  `sales_ratio` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台服务费',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT ' 0 分销商提现，1 供货商提现 2 经销商提现 3 积分兑换提现',
  `channel` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道 0 收益提现 1 积分兑换提现',
  `bak` varchar(500) NOT NULL COMMENT '备注',
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `bank_id` (`bank_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='提现';

-- ----------------------------
-- Records of pigcms_store_withdrawal
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_subject`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_subject`;
CREATE TABLE `pigcms_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '图文专题名称',
  `pic` varchar(200) DEFAULT NULL COMMENT '图片',
  `description` text COMMENT '图文专题描述内容',
  `show_index` tinyint(1) DEFAULT '1' COMMENT '是否首页显示',
  `store_id` int(11) DEFAULT NULL COMMENT '关联的店铺id',
  `subject_typeid` int(11) DEFAULT NULL COMMENT '所属专题分类',
  `dz_count` int(11) DEFAULT NULL COMMENT '点赞总数',
  `px` int(11) DEFAULT NULL COMMENT '排序',
  `timestamp` int(11) DEFAULT NULL COMMENT '操作的时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='专题表';

-- ----------------------------
-- Records of pigcms_subject
-- ----------------------------
INSERT INTO `pigcms_subject` VALUES ('1', '11', 'images/000/000/012/201605/574829d9d731f.jpg', '33', '1', '12', '2', null, '0', '1464347118');

-- ----------------------------
-- Table structure for `pigcms_subject_comment`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_subject_comment`;
CREATE TABLE `pigcms_subject_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '评论者uid',
  `store_id` int(11) DEFAULT NULL COMMENT '被评论的 商铺id',
  `top_store_id` int(11) DEFAULT NULL COMMENT '供货商店铺id',
  `subject_id` int(11) DEFAULT NULL COMMENT '专题id',
  `content` text COMMENT '评论的内容',
  `is_show` tinyint(1) DEFAULT '1' COMMENT '是否显示0:不显示 1:显示',
  `timestamp` int(11) DEFAULT NULL COMMENT '操作的时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_subject_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_subject_diy_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_subject_diy_keywords`;
CREATE TABLE `pigcms_subject_diy_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',
  `keys` varchar(200) DEFAULT NULL COMMENT '标识',
  `content` text COMMENT '替换内容',
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_subject_diy_keywords
-- ----------------------------
INSERT INTO `pigcms_subject_diy_keywords` VALUES ('1', '12', null, 'a:2:{s:12:\"subject_type\";s:6:\"哈哈\";s:15:\"subject_display\";s:6:\"呼呼\";}', '1464347057');

-- ----------------------------
-- Table structure for `pigcms_subject_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_subject_product`;
CREATE TABLE `pigcms_subject_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL COMMENT '对应产品id',
  `piclist` text COMMENT '专题关联产品对应的图片',
  `subject_id` int(11) DEFAULT NULL COMMENT '关联的专题id',
  `store_id` int(11) DEFAULT NULL COMMENT '对应的店铺',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `timestamp` int(11) DEFAULT NULL COMMENT '操作的时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='专题关联产品表';

-- ----------------------------
-- Records of pigcms_subject_product
-- ----------------------------
INSERT INTO `pigcms_subject_product` VALUES ('1', '4', 'images/000/000/012/201605/5747aeb89fece.jpg', '1', '12', '0', '1464347118');

-- ----------------------------
-- Table structure for `pigcms_subscribe_general`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_subscribe_general`;
CREATE TABLE `pigcms_subscribe_general` (
  `sub_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sub_id',
  `uid` int(10) NOT NULL COMMENT '用户id',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `addtime` int(11) NOT NULL COMMENT '关注时间',
  PRIMARY KEY (`sub_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='非认证服务号 关注记录';

-- ----------------------------
-- Records of pigcms_subscribe_general
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_subscribe_store`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_subscribe_store`;
CREATE TABLE `pigcms_subscribe_store` (
  `sub_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝id',
  `openid` varchar(200) NOT NULL DEFAULT '' COMMENT '粉丝对应被关注店铺公众号openid',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被关注店铺id',
  `subscribe_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '关注时间',
  `is_leave` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否取消关注：0否 1是',
  `leave_time` int(11) NOT NULL COMMENT '取消关注时间',
  `user_subscribe_time` int(11) NOT NULL COMMENT '用户关注店铺时间（成为粉丝时间）',
  PRIMARY KEY (`sub_id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `openid` (`openid`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='粉丝关注店铺';

-- ----------------------------
-- Records of pigcms_subscribe_store
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_subtype`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_subtype`;
CREATE TABLE `pigcms_subtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL COMMENT '专题类目的店铺id',
  `typename` varchar(200) NOT NULL COMMENT '专题名称',
  `typepic` varchar(200) DEFAULT NULL COMMENT '专题图片',
  `px` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否开启(0:关闭；1:开启)',
  `topid` smallint(5) DEFAULT NULL COMMENT '顶级栏目id',
  `upid` smallint(5) DEFAULT NULL COMMENT '上级栏目id',
  `timtstamp` int(11) DEFAULT NULL COMMENT '最近操作的时间戳',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='专题栏目表';

-- ----------------------------
-- Records of pigcms_subtype
-- ----------------------------
INSERT INTO `pigcms_subtype` VALUES ('1', '12', '春装', '', '0', '1', '0', '0', null);
INSERT INTO `pigcms_subtype` VALUES ('2', '12', '衣服', 'images/000/000/012/201605/5748299e024d8.jpg', '0', '1', '1', '1', null);

-- ----------------------------
-- Table structure for `pigcms_supp_dis_relation`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_supp_dis_relation`;
CREATE TABLE `pigcms_supp_dis_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关系表id',
  `supplier_id` int(11) NOT NULL COMMENT '供货商ID',
  `distributor_id` int(11) NOT NULL COMMENT '经销商ID（批发商ID）',
  `authen` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 未认证 1 认证中 2 已认证',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '认证通过时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `bond` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金剩余额度',
  `apply_recharge` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '申请充值额度',
  `bank_id` int(5) NOT NULL DEFAULT '0' COMMENT '开户银行',
  `bank_card` varchar(30) NOT NULL DEFAULT '0' COMMENT '银行卡号',
  `bank_card_user` varchar(30) NOT NULL DEFAULT '0' COMMENT '开卡人姓名',
  `opening_bank` varchar(30) DEFAULT '0' COMMENT '开户行',
  `phone` varchar(20) NOT NULL DEFAULT '0' COMMENT '打款人手机号',
  `not_paid` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '未支付',
  `paid` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已支付',
  `return_owe` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '退货欠供货商金额',
  `clear_return_owe` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已销账退货欠款',
  `profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '经销商批发利润',
  `sales` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '经销商销售额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_supp_dis_relation
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_system_info`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_info`;
CREATE TABLE `pigcms_system_info` (
  `lastsqlupdate` int(10) NOT NULL,
  `version` varchar(10) NOT NULL,
  `currentfileid` varchar(40) NOT NULL DEFAULT '0',
  `currentsqlid` varchar(40) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_system_info
-- ----------------------------
INSERT INTO `pigcms_system_info` VALUES ('55620', '1461836940', '201604281749', '0');

-- ----------------------------
-- Table structure for `pigcms_system_menu`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_menu`;
CREATE TABLE `pigcms_system_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `name` char(20) NOT NULL,
  `module` char(20) NOT NULL,
  `action` char(20) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(4) NOT NULL COMMENT '超级管理员权限',
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统后台菜单表';

-- ----------------------------
-- Records of pigcms_system_menu
-- ----------------------------
INSERT INTO `pigcms_system_menu` VALUES ('1', '0', '后台首页', '', '', '10', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('2', '0', '系统设置', '', '', '9', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('3', '0', '商品管理', '', '', '7', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('4', '0', '订单管理', '', '', '6', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('5', '0', '用户管理', '', '', '5', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('6', '1', '后台首页', 'Index', 'main', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('7', '1', '修改密码', 'Index', 'pass', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('8', '1', '个人资料', 'Index', 'profile', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('9', '1', '更新缓存', 'Index', 'cache', '0', '0', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('10', '2', '站点配置', 'Config', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('11', '2', '友情链接', 'Flink', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('12', '0', '店铺管理', '', '', '4', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('13', '12', '店铺列表', 'Store', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('14', '2', '城市区域', 'Area', 'index', '0', '0', '0', '0');
INSERT INTO `pigcms_system_menu` VALUES ('15', '3', '商品列表', 'Product', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('16', '3', '商品分类', 'Product', 'category', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('17', '2', '广告管理', 'Adver', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('19', '2', '导航管理', 'Slider', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('20', '2', '热门搜索词', 'Search_hot', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('21', '24', '自定义菜单', 'Diymenu', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('22', '2', '快递公司', 'Express', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('23', '12', '收支明细', 'Store', 'inoutdetail', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('24', '0', '微信设置', '', '', '8', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('25', '24', '首页回复配置', 'Home', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('28', '4', '所有订单', 'Order', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('29', '5', '用户列表', 'User', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('30', '24', '首次关注回复', 'Home', 'first', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('31', '24', '关键词回复', 'Home', 'other', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('32', '2', '平台会员卡', 'Card', 'index', '0', '0', '0', '0');
INSERT INTO `pigcms_system_menu` VALUES ('33', '24', '模板消息', 'TemplateMsg', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('34', '4', '到店自提订单', 'Order', 'selffetch', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('35', '4', '货到付款订单', 'Order', 'codpay', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('36', '4', '代付的订单', 'Order', 'payagent', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('37', '12', '主营类目', 'Store', 'category', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('38', '12', '提现记录', 'Order', 'withdraw', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('40', '3', '商品分组', 'Product', 'group', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('41', '2', '商品栏目属性类别管理', 'Sys_product_property', 'propertyType', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('42', '3', '商品属性列表', 'Product_property', 'property', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('43', '3', '商品属性值列表', 'Product_property', 'propertyValue', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('44', '2', '商城筛选属性列表', 'Sys_product_property', 'property', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('45', '2', '商城筛选属性值列表', 'Sys_product_property', 'propertyValue', '0', '0', '0', '0');
INSERT INTO `pigcms_system_menu` VALUES ('46', '2', '商城评论标签', 'Tag', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('49', '2', '敏感词', 'Ng_word', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('50', '12', '品牌类别管理', 'Store', 'brandtype', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('51', '12', '品牌管理', 'Store', 'brand', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('53', '12', '营销活动管理', 'Store', 'activityManage', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('54', '12', '营销活动展示', 'Store', 'activityRecommend', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('55', '12', '店铺对账日志', 'Order', 'checklog', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('58', '3', '被分销的源商品列表', 'Product', 'fxlist', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('59', '3', '商品评价管理', 'Product', 'comment', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('60', '12', '店铺评价管理', 'Store', 'comment', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('61', '2', '收款银行', 'Bank', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('62', '1', '更新程序', 'System', 'checkUpdate', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('63', '1', '更新数据库', 'System', 'sqlUpdate', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('64', '4', '商家购买的短信订单', 'Order', 'smspay', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('65', '4', '退货列表', 'Order', 'return_order', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('66', '4', '维权列表', 'Order', 'rights', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('67', '12', '认证自定义表单', 'Store', 'diyAttestation', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('68', '5', '用户导出', 'User', 'checkout', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('69', '12', '分销商等级', 'Store', 'drp_degree', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('70', '0', '平台积分', '', '', '3', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('71', '70', '积分概述', 'Credit', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('72', '70', '积分规则', 'Credit', 'rules', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('73', '70', '保证金流水', 'Credit', 'depositRecord', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('74', '70', '积分流水', 'Credit', 'record', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('80', '75', '管理员奖金配置', 'Admin', 'bonus_config', '0', '1', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('79', '75', '客户经理(代理商)', 'Admin', 'agent', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('78', '75', '区域管理员', 'Admin', 'area', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('77', '75', '管理员列表', 'Admin', 'index', '0', '1', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('76', '75', '管理员组', 'Admin', 'group', '0', '1', '1', '1');
INSERT INTO `pigcms_system_menu` VALUES ('75', '0', '管理员管理', '', '', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('81', '4', '店铺添加订单', 'Order', 'offline', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('82', '4', '财务概览', 'Order', 'dashboard', '2', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('83', '1', '客户经理(代理商)邀请码', 'Admin', 'agentcode', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('84', '2', '前台LBS展示区域', 'Lbs', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('85', '2', '推广海报设置', 'Promotion', 'index', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('86', '4', '奖金流水记录', 'Order', 'promotionRecord', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('87', '1', '我的奖金', 'Order', 'myPromotionRecord', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('88', '12', '店铺特权套餐', 'Store', 'package', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('90', '70', '保证金返还', 'Credit', 'returnRecord', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('91', '12', '特色类别管理', 'Store', 'tag', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('92', '1', '查看下属奖金流水', 'Order', 'subPromotionRecord', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('93', '1', '下属店铺充值流水', 'Credit', 'myDepositRecord', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('94', '12', '抽奖活动管理', 'Store', 'game', '0', '1', '1', '0');
INSERT INTO `pigcms_system_menu` VALUES ('95', '1', '微信绑定', 'Promotion', 'agent_to_wchat', '0', '1', '1', '0');

-- ----------------------------
-- Table structure for `pigcms_system_product_property`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_product_property`;
CREATE TABLE `pigcms_system_product_property` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序字段',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1：启用，0：关闭',
  `property_type_id` smallint(5) NOT NULL COMMENT '产品属性所属类别id',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品栏目属性名表';

-- ----------------------------
-- Records of pigcms_system_product_property
-- ----------------------------
INSERT INTO `pigcms_system_product_property` VALUES ('24', '净含量', '5', '1', '16');
INSERT INTO `pigcms_system_product_property` VALUES ('23', '用途', '4', '1', '16');
INSERT INTO `pigcms_system_product_property` VALUES ('22', '采摘季节', '3', '1', '16');
INSERT INTO `pigcms_system_product_property` VALUES ('21', '等级', '2', '1', '16');
INSERT INTO `pigcms_system_product_property` VALUES ('20', '品牌', '1', '1', '16');

-- ----------------------------
-- Table structure for `pigcms_system_product_to_property_value`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_product_to_property_value`;
CREATE TABLE `pigcms_system_product_to_property_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '系统筛选表id',
  `vid` int(10) NOT NULL DEFAULT '0' COMMENT '系统筛选属性值id',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`) USING BTREE,
  KEY `vid` (`vid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品关联筛选属性值表';

-- ----------------------------
-- Records of pigcms_system_product_to_property_value
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_system_property_type`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_property_type`;
CREATE TABLE `pigcms_system_property_type` (
  `type_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(80) NOT NULL COMMENT '属性类别名',
  `type_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1为开启，0为关闭',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='产品属性的类别表';

-- ----------------------------
-- Records of pigcms_system_property_type
-- ----------------------------
INSERT INTO `pigcms_system_property_type` VALUES ('16', '绿茶', '1');

-- ----------------------------
-- Table structure for `pigcms_system_property_value`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_property_value`;
CREATE TABLE `pigcms_system_property_value` (
  `vid` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品栏目属性值id',
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品栏目属性名id',
  `value` varchar(50) NOT NULL DEFAULT '' COMMENT '商品栏目属性值',
  PRIMARY KEY (`vid`),
  KEY `pid` (`pid`) USING BTREE,
  KEY `pid_2` (`pid`,`value`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品栏目属性值';

-- ----------------------------
-- Records of pigcms_system_property_value
-- ----------------------------
INSERT INTO `pigcms_system_property_value` VALUES ('1', '1', '纯棉');
INSERT INTO `pigcms_system_property_value` VALUES ('2', '1', '真丝T恤');
INSERT INTO `pigcms_system_property_value` VALUES ('3', '1', '文艺T恤');
INSERT INTO `pigcms_system_property_value` VALUES ('4', '4', 'T恤');
INSERT INTO `pigcms_system_property_value` VALUES ('5', '4', '短裙');
INSERT INTO `pigcms_system_property_value` VALUES ('6', '5', '8G');
INSERT INTO `pigcms_system_property_value` VALUES ('7', '5', '16G');
INSERT INTO `pigcms_system_property_value` VALUES ('8', '5', '32G');
INSERT INTO `pigcms_system_property_value` VALUES ('9', '7', '1920*1240');
INSERT INTO `pigcms_system_property_value` VALUES ('10', '9', '宽松');
INSERT INTO `pigcms_system_property_value` VALUES ('11', '9', '修身');
INSERT INTO `pigcms_system_property_value` VALUES ('12', '8', '圆领');
INSERT INTO `pigcms_system_property_value` VALUES ('13', '8', 'V领');
INSERT INTO `pigcms_system_property_value` VALUES ('14', '10', '办公室');
INSERT INTO `pigcms_system_property_value` VALUES ('15', '10', '客厅');
INSERT INTO `pigcms_system_property_value` VALUES ('16', '10', '厨房');
INSERT INTO `pigcms_system_property_value` VALUES ('17', '11', '项链');
INSERT INTO `pigcms_system_property_value` VALUES ('18', '11', '戒指');
INSERT INTO `pigcms_system_property_value` VALUES ('19', '11', '手镯');
INSERT INTO `pigcms_system_property_value` VALUES ('20', '12', '益智');
INSERT INTO `pigcms_system_property_value` VALUES ('21', '12', '故事');
INSERT INTO `pigcms_system_property_value` VALUES ('22', '12', '文学');
INSERT INTO `pigcms_system_property_value` VALUES ('23', '12', '百科');
INSERT INTO `pigcms_system_property_value` VALUES ('24', '13', '饼干');
INSERT INTO `pigcms_system_property_value` VALUES ('25', '13', '点心');
INSERT INTO `pigcms_system_property_value` VALUES ('26', '13', '巧克力');
INSERT INTO `pigcms_system_property_value` VALUES ('27', '14', '奶瓶');
INSERT INTO `pigcms_system_property_value` VALUES ('28', '14', '纱/布尿裤');
INSERT INTO `pigcms_system_property_value` VALUES ('29', '14', '睡袋/抱被/抱毯');
INSERT INTO `pigcms_system_property_value` VALUES ('30', '15', 'BB霜');
INSERT INTO `pigcms_system_property_value` VALUES ('31', '15', '眼影');
INSERT INTO `pigcms_system_property_value` VALUES ('32', '15', '眉笔/眉粉/眉膏');
INSERT INTO `pigcms_system_property_value` VALUES ('33', '17', '安全座椅');
INSERT INTO `pigcms_system_property_value` VALUES ('34', '17', '影音娱乐');
INSERT INTO `pigcms_system_property_value` VALUES ('35', '17', '内饰用品');
INSERT INTO `pigcms_system_property_value` VALUES ('36', '18', '登山');
INSERT INTO `pigcms_system_property_value` VALUES ('37', '18', '冲锋衣');
INSERT INTO `pigcms_system_property_value` VALUES ('38', '19', '雪橇');
INSERT INTO `pigcms_system_property_value` VALUES ('39', '19', '睡袋');
INSERT INTO `pigcms_system_property_value` VALUES ('40', '20', '谢裕大茶业');
INSERT INTO `pigcms_system_property_value` VALUES ('41', '20', '徽六');
INSERT INTO `pigcms_system_property_value` VALUES ('42', '20', '御牌');
INSERT INTO `pigcms_system_property_value` VALUES ('43', '20', '吴郡茶业');
INSERT INTO `pigcms_system_property_value` VALUES ('44', '20', '塔山');
INSERT INTO `pigcms_system_property_value` VALUES ('45', '20', '大山坞');
INSERT INTO `pigcms_system_property_value` VALUES ('46', '20', '恒盛白茶');
INSERT INTO `pigcms_system_property_value` VALUES ('47', '21', '特级');
INSERT INTO `pigcms_system_property_value` VALUES ('48', '21', '一级');
INSERT INTO `pigcms_system_property_value` VALUES ('49', '21', '二级');
INSERT INTO `pigcms_system_property_value` VALUES ('50', '21', '其它');
INSERT INTO `pigcms_system_property_value` VALUES ('51', '22', '春茶');
INSERT INTO `pigcms_system_property_value` VALUES ('52', '22', '明前');
INSERT INTO `pigcms_system_property_value` VALUES ('53', '22', '雨前');
INSERT INTO `pigcms_system_property_value` VALUES ('54', '22', '雨后');
INSERT INTO `pigcms_system_property_value` VALUES ('55', '22', '谷雨');
INSERT INTO `pigcms_system_property_value` VALUES ('56', '23', '自饮');
INSERT INTO `pigcms_system_property_value` VALUES ('57', '23', '送礼（简装礼盒）');
INSERT INTO `pigcms_system_property_value` VALUES ('58', '23', '送礼（精美礼盒）');
INSERT INTO `pigcms_system_property_value` VALUES ('59', '24', '50克以下');
INSERT INTO `pigcms_system_property_value` VALUES ('60', '24', '50-100克');
INSERT INTO `pigcms_system_property_value` VALUES ('61', '24', '101-250克');
INSERT INTO `pigcms_system_property_value` VALUES ('62', '24', '251-500克');
INSERT INTO `pigcms_system_property_value` VALUES ('63', '24', '501-1000克');
INSERT INTO `pigcms_system_property_value` VALUES ('64', '24', '1001克以上');

-- ----------------------------
-- Table structure for `pigcms_system_rbac_menu`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_rbac_menu`;
CREATE TABLE `pigcms_system_rbac_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '父级控制器id',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `module` varchar(60) NOT NULL DEFAULT '' COMMENT 'module控制器',
  `action` varchar(60) NOT NULL DEFAULT '' COMMENT 'action方法',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：1使用 0关闭 默认为1',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=209 DEFAULT CHARSET=utf8 COMMENT='另外的rbac列表';

-- ----------------------------
-- Records of pigcms_system_rbac_menu
-- ----------------------------
INSERT INTO `pigcms_system_rbac_menu` VALUES ('1', '0', '后台敏感词基础类', 'Ng_word', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('2', '0', '广告管理', 'Adver', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('3', '0', '收款银行', 'Bank', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('4', '0', '站点配置', 'Config', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('5', '0', '总后台积分配置', 'Credit', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('6', '0', '微信自定义菜单', 'Diymenu', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('7', '0', '快递公司', 'Express', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('8', '0', '友情链接', 'Flink', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('9', '0', '微信首页回复', 'Home', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('10', '0', '总后台首页', 'Index', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('11', '0', '订单', 'Order', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('12', '0', '商品属性', 'Product_property', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('13', '0', '商品列表', 'Product', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('14', '0', '热门关键词', 'Search_hot', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('15', '0', '导航管理', 'Slider', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('16', '0', '店铺', 'Store', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('17', '0', '系统商品属性', 'Sys_product_property', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('18', '0', '标签tag', 'Tag', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('19', '0', '模板消息', 'TemplateMsg', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('20', '0', '用户', 'User', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('21', '0', 'LBS展示区域', 'Lbs', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('22', '0', '管理员管理', 'Admin', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('23', '0', '推广管理', 'Promotion', '', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('24', '1', '列表', 'Ng_word', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('25', '1', '添加', 'Ng_word', 'add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('26', '1', '删除', 'Ng_word', 'delete', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('27', '1', '修改', 'Ng_word', 'edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('28', '2', '分类列表', 'Adver', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('29', '2', '分类添加', 'Adver', 'cat_modify', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('30', '2', '分类编辑', 'Adver', 'cat_amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('31', '2', '分类删除', 'Adver', 'cat_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('32', '2', '广告列表', 'Adver', 'adver_list', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('33', '2', '广告添加', 'Adver', 'adver_modify', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('34', '2', '广告编辑', 'Adver', 'adver_amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('35', '2', '广告删除', 'Adver', 'adver_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('36', '3', '列表', 'Bank', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('37', '3', '添加', 'Bank', 'modify', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('38', '3', '修改', 'Bank', 'amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('39', '3', '删除', 'Bank', 'del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('40', '4', '站点配置', 'Config', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('41', '4', '站点修改', 'Config', 'amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('42', '4', '微信API接口填写信息', 'Config', 'show', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('43', '4', '测试短信接口', 'Config', 'sendmsg', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('44', '5', '配置表单', 'Credit', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('45', '5', '修改配置记录状态', 'Credit', 'chgStatus', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('46', '5', '修改积分权数', 'Credit', 'chgTodayCreditWeight', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('47', '5', '积分规则', 'Credit', 'rules', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('48', '5', '修改规则', 'Credit', 'upRules', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('49', '5', '保证金记录', 'Credit', 'depositRecord', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('50', '5', '积分记录', 'Credit', 'record', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('51', '5', '下属店铺充值流水', 'Credit', 'myDepositRecord', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('52', '6', '列表', 'Diymenu', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('53', '6', '添加', 'Diymenu', 'class_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('54', '6', '修改', 'Diymenu', 'class_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('55', '6', '删除', 'Diymenu', 'class_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('56', '6', '发送到微信设置', 'Diymenu', 'class_send', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('57', '7', '列表', 'Express', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('58', '7', '添加', 'Express', 'modify', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('59', '7', '修改', 'Express', 'amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('60', '7', '删除', 'Express', 'del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('61', '8', '列表', 'Flink', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('62', '8', '添加', 'Flink', 'modify', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('63', '8', '修改', 'Flink', 'amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('64', '8', '删除', 'Flink', 'del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('65', '9', '首页回复表单', 'Home', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('66', '9', '首次关注回复', 'Home', 'first', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('67', '9', '关键词回复', 'Home', 'other', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('68', '9', '关键词添加', 'Home', 'other_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('69', '9', '关键词修改', 'Home', 'other_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('70', '9', '关键词删除', 'Home', 'other_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('71', '10', '后台首页', 'Index', 'main', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('72', '10', '修改密码', 'Index', 'amend_pass', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('73', '10', '修改个人资料', 'Index', 'amend_profile', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('74', '10', '清除缓存', 'Index', 'cache', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('75', '10', '创建官方店铺', 'Index', 'offical_tore', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('76', '11', '账务概况', 'Order', 'dashboard', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('77', '11', '平台收款记录', 'Order', 'paymentRecord', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('78', '11', '平台收益', 'Order', 'incomeRecord', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('79', '11', '所有订单(不含临时订单)', 'Order', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('80', '11', '到店自提订单(不含临时订单)', 'Order', 'selffetch', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('81', '11', '货到付款订单(不含临时订单)', 'Order', 'codpay', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('82', '11', '代付的订单(不含临时订单)', 'Order', 'payagent', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('83', '11', '退款', 'Order', 'refund_peerpay', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('84', '11', '提现记录', 'Order', 'withdraw', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('85', '11', '获取提现状态', 'Order', 'withdraw_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('86', '11', '短信订单列表', 'Order', 'smspay', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('87', '11', '订单详情', 'Order', 'detail', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('88', '11', '对账列表', 'Order', 'check', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('89', '11', '对账日志', 'Order', 'checklog', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('90', '11', '详细对账抽成比例', 'Order', 'alert_check', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('91', '11', '修改出账状态', 'Order', 'check_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('92', '11', '退货列表', 'Order', 'return_order', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('93', '11', '退货详情', 'Order', 'return_detail', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('94', '11', '维权列表', 'Order', 'rights', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('95', '11', '维权详情', 'Order', 'rights_detail', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('96', '11', '修改维权状态', 'Order', 'rights_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('97', '11', '奖金流水记录', 'Order', 'promotionRecord', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('98', '11', '我的奖金', 'Order', 'myPromotionRecord', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('99', '11', '查看下属奖金流水', 'Order', 'subPromotionRecord', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('100', '12', '商品属性列表', 'Product_property', 'property', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('101', '12', '修改商品属性分类的状态', 'Product_property', 'property_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('102', '12', '修改商品属性值的分类状态', 'Product_property', 'propertyvalue_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('103', '12', '商品属性修改', 'Product_property', 'property_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('104', '12', '属性删除', 'Product_property', 'property_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('105', '12', '属性添加', 'Product_property', 'property_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('106', '12', '商品属性值列表', 'Product_property', 'propertyValue', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('107', '12', '商品属性对应商品属性值的列表', 'Product_property', 'getOnePropertyValueList', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('108', '12', '商品属性修改', 'Product_property', 'propertyValue_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('109', '12', '商品属性删除', 'Product_property', 'propertyValue_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('110', '13', '产品列表', 'Product', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('111', '13', '分类列表', 'Product', 'category', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('112', '13', '修改产品状态', 'Product', 'status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('113', '13', '添加商品分类', 'Product', 'category_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('114', '13', '修改', 'Product', 'category_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('115', '13', '删除', 'Product', 'category_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('116', '13', '状态修改', 'Product', 'category_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('117', '13', '产品组列表', 'Product', 'group', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('118', '13', '被分销的商品列表', 'Product', 'fxlist', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('119', '13', '评价删除', 'Product', 'comment_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('120', '13', '评价状态修改', 'Product', 'comment_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('121', '13', '评价列表', 'Product', 'comment', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('122', '14', '列表', 'Search_hot', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('123', '14', '添加', 'Search_hot', 'modify', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('124', '14', '修改', 'Search_hot', 'amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('125', '14', '删除', 'Search_hot', 'del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('126', '15', '分类列表', 'Slider', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('127', '15', '分类添加', 'Slider', 'cat_modify', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('128', '15', '分类修改', 'Slider', 'cat_amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('129', '15', '分类删除', 'Slider', 'cat_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('130', '15', '导航列表', 'Slider', 'slider_list', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('131', '15', '导航添加', 'Slider', 'slider_modify', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('132', '15', '导航修改', 'Slider', 'slider_amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('133', '15', '导航删除', 'Slider', 'slider_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('134', '16', '店铺列表', 'Store', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('135', '16', '店铺详情', 'Store', 'detail', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('136', '16', '认证详情', 'Store', 'certification_detail', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('137', '16', '状态修改', 'Store', 'status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('138', '16', '认证通过', 'Store', 'approve', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('139', '16', '收支明细', 'Store', 'inoutdetail', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('140', '16', '主营类目列表', 'Store', 'category', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('141', '16', '主营类目添加', 'Store', 'category_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('142', '16', '主营类目编辑', 'Store', 'category_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('143', '16', '主营类目状态修改', 'Store', 'category_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('144', '16', '主营类目删除', 'Store', 'category_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('145', '16', '品牌类别列表', 'Store', 'brandType', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('146', '16', '品牌类别状态', 'Store', 'brandType_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('147', '16', '品牌类别添加', 'Store', 'brandtype_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('148', '16', '品牌类别修改', 'Store', 'brandtype_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('149', '16', '品牌类别删除', 'Store', 'brandtype_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('150', '16', '品牌列表', 'Store', 'brand', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('151', '16', '品牌状态修改', 'Store', 'brand_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('152', '16', '品牌添加', 'Store', 'brand_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('153', '16', '品牌编辑', 'Store', 'brand_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('154', '16', '品牌删除', 'Store', 'brand_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('155', '16', '获取对接营销活动列表', 'Store', 'activityManage', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('156', '16', '对接活动添加', 'Store', 'activityRecommendAdd', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('157', '16', '本站活动记录', 'Store', 'activityRecommend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('158', '16', '对接活动删除', 'Store', 'activityRecommendDel', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('159', '16', '添加到本站活动记录', 'Store', 'activityRecommendRecAdd', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('160', '16', '本站活动记录删除', 'Store', 'activityRecommendRecDel', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('161', '16', '店铺对账', 'Store', 'check', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('162', '16', '评价删除', 'Store', 'comment_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('163', '16', '评价状态修改', 'Store', 'comment_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('164', '16', '店铺商品评价', 'Store', 'comment', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('165', '16', '认证自定义表单', 'Store', 'diyAttestation', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('166', '16', '认证自定义表单删除', 'Store', 'diyAttestation_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('167', '16', '分销商等级', 'Store', 'drp_degree', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('168', '16', '分销商等级添加', 'Store', 'drp_degree_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('169', '16', '分销商等级修改', 'Store', 'drp_degree_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('170', '16', '分销商等级状态修改', 'Store', 'drp_degree_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('171', '16', '分销商等级删除', 'Store', 'drp_degree_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('172', '16', '店铺保证金充值按钮', 'Store', 'showButton', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('173', '16', '店铺综合展示操作', 'Store', 'change_public_display', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('174', '17', '商品属性类别', 'Sys_product_property', 'propertyType', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('175', '17', '商品属性类别状态', 'Sys_product_property', 'propertytype_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('176', '17', '商品属性类别添加', 'Sys_product_property', 'propertyType_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('177', '17', '商品属性类别修改', 'Sys_product_property', 'propertyType_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('178', '17', '商品属性类别删除', 'Sys_product_property', 'propertyType_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('179', '17', '商品属性', 'Sys_product_property', 'property', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('180', '17', '商品属性状态', 'Sys_product_property', 'property_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('181', '17', '商品属性修改', 'Sys_product_property', 'property_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('182', '17', '商品属性删除', 'Sys_product_property', 'property_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('183', '17', '商品属性添加', 'Sys_product_property', 'property_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('184', '17', '商品属性值', 'Sys_product_property', 'propertyValue', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('185', '17', '商品属性值添加', 'Sys_product_property', 'propertyValue_add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('186', '17', '商品属性值状态修改', 'Sys_product_property', 'propertyvalue_status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('187', '17', '商品属性值修改', 'Sys_product_property', 'propertyValue_edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('188', '17', '商品属性值删除', 'Sys_product_property', 'propertyValue_del', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('189', '18', '列表', 'Tag', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('190', '18', '添加', 'Tag', 'add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('191', '18', '删除', 'Tag', 'delete', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('192', '18', '修改', 'Tag', 'edit', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('193', '18', '状态修改', 'Tag', 'status', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('194', '19', '列表和操作', 'TemplateMsg', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('195', '20', '列表', 'User', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('196', '20', '用户修改', 'User', 'amend', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('197', '20', '查看拥有店铺列表', 'User', 'stores', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('198', '20', '进入商家店铺 ', 'User', 'tab_store', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('199', '20', '导出列表', 'User', 'checkout', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('200', '20', '给用户绑定客户经理(代理商)', 'User', 'agent_invite', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('201', '21', '列表', 'Lbs', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('202', '21', '操作', 'Lbs', 'set_to_hot', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('203', '22', '发送奖金', 'Admin', 'send_reward', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('204', '23', '首页', 'Promotion', 'index', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('205', '23', '更新', 'Promotion', 'upload', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('206', '23', '添加', 'Promotion', 'add', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('207', '23', '绑定区域代理微信', 'Promotion', 'agent_to_wchat', '0', '1', '1464246661');
INSERT INTO `pigcms_system_rbac_menu` VALUES ('208', '23', '解除绑定', 'Promotion', 'detach', '0', '1', '1464246661');

-- ----------------------------
-- Table structure for `pigcms_system_tag`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_system_tag`;
CREATE TABLE `pigcms_system_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT '0' COMMENT 'system_property_type表type_id，主要是为了方便查找',
  `name` varchar(100) NOT NULL COMMENT 'tag名',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1为开启，0：关闭',
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `tid` (`tid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统标签表';

-- ----------------------------
-- Records of pigcms_system_tag
-- ----------------------------
INSERT INTO `pigcms_system_tag` VALUES ('1', '0', '大品牌', '1');
INSERT INTO `pigcms_system_tag` VALUES ('2', '0', '正品行货', '1');
INSERT INTO `pigcms_system_tag` VALUES ('3', '0', '价格公道', '1');
INSERT INTO `pigcms_system_tag` VALUES ('4', '0', '服务态度好', '1');

-- ----------------------------
-- Table structure for `pigcms_tempmsg`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_tempmsg`;
CREATE TABLE `pigcms_tempmsg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tempkey` char(50) NOT NULL,
  `name` char(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `industry` char(50) NOT NULL,
  `topcolor` char(10) NOT NULL DEFAULT '#029700',
  `textcolor` char(10) NOT NULL DEFAULT '#000000',
  `token` char(40) NOT NULL,
  `tempid` char(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tempkey` (`tempkey`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_tempmsg
-- ----------------------------
INSERT INTO `pigcms_tempmsg` VALUES ('1', 'OPENTM201752540', '订单支付成功通知', '\r\n                    {{first.DATA}}\r\n                    订单商品：{{keyword1.DATA}}\r\n                    订单编号：{{keyword2.DATA}}\r\n                    支付金额：{{keyword3.DATA}}\r\n                    支付时间：{{keyword4.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('2', 'OPENTM205213550', '订单生成通知', '\r\n                    {{first.DATA}}\r\n                    时间：{{keyword1.DATA}}\r\n                    商品名称：{{keyword2.DATA}}\r\n                    订单号：{{keyword3.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('3', 'OPENTM202521011', '订单完成通知', '\r\n                    {{first.DATA}}\r\n                    订单号：{{keyword1.DATA}}\r\n                    完成时间：{{keyword2.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('4', 'OPENTM200565259', '订单发货提醒', '\r\n                    {{first.DATA}}\r\n                    订单编号：{{keyword1.DATA}}\r\n                    物流公司：{{keyword2.DATA}}\r\n                    物流单号：{{keyword3.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('5', 'OPENTM206547887', '分销订单通知', '\r\n                    {{first.DATA}}\r\n                    订单编号：{{keyword1.DATA}}\r\n                    商品名称：{{keyword2.DATA}}\r\n                    下单时间：{{keyword3.DATA}}\r\n                    下单金额：{{keyword4.DATA}}\r\n                    分销商名称：{{keyword5.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('6', 'OPENTM206328960', '分销订单支付成功通知', '\r\n                    {{first.DATA}}\r\n                    商品名称：{{keyword1.DATA}}\r\n                    商品佣金：{{keyword2.DATA}}\r\n                    订单状态：{{keyword3.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('7', 'OPENTM206328970', '分销订单下单成功通知', '\r\n                    {{first.DATA}}\r\n                    商品名称：{{keyword1.DATA}}\r\n                    商品佣金：{{keyword2.DATA}}\r\n                    下单时间：{{keyword3.DATA}}\r\n                    订单状态：{{keyword4.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('8', 'OPENTM220197216', '分销订单提成通知', '\r\n                    {{first.DATA}}\r\n                    订单号：{{keyword1.DATA}}\r\n                    订单金额：{{keyword2.DATA}}\r\n                    分成金额：{{keyword3.DATA}}\r\n                    时间：{{keyword4.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('9', 'OPENTM207126233', '分销商申请成功提醒', '\r\n                    {{first.DATA}}\r\n                    分销商名称：{{keyword1.DATA}}\r\n                    分销商电话：{{keyword2.DATA}}\r\n                    申请时间：{{keyword3.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('10', 'TM204601671', '访客消息通知', '\r\n                    {{first.DATA}}\r\n                    消息来自：{{keynote1.DATA}}\r\n                    发送时间：{{keynote2.DATA}}\r\n                    {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('11', 'OPENTM201072360', '余额不足提醒', '{{first.DATA}}\r\n                 账号：{{keyword1.DATA}}\r\n                 当前余额：{{keyword2.DATA}}\r\n                {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');
INSERT INTO `pigcms_tempmsg` VALUES ('12', 'OPENTM401560049', '店铺审核通知', '{{first.DATA}}\r\n                店铺编号：{{keyword1.DATA}}\r\n                店铺名称：{{keyword2.DATA}}\r\n                店铺店主：{{keyword3.DATA}}\r\n                手机号码：{{keyword4.DATA}}\r\n                注册时间：{{keyword5.DATA}}\r\n                {{remark.DATA}}', '', '#029700', '#000000', 'system', '', '0');

-- ----------------------------
-- Table structure for `pigcms_text`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_text`;
CREATE TABLE `pigcms_text` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `content` varchar(200) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_text
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_trade_selffetch`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_trade_selffetch`;
CREATE TABLE `pigcms_trade_selffetch` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `province` mediumint(9) NOT NULL,
  `city` mediumint(9) NOT NULL,
  `county` mediumint(9) NOT NULL,
  `address` varchar(150) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `last_time` int(11) NOT NULL,
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='买家上门自提';

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
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='交易物流通知';

-- ----------------------------
-- Records of pigcms_trade_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_tuan`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_tuan`;
CREATE TABLE `pigcms_tuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `name` varchar(100) DEFAULT NULL COMMENT '团购名称',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户UID',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `start_price` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '团购起步价',
  `start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开团开始时间',
  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开团结束时间 ',
  `description` text COMMENT '开团说明',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '团购状态，1：正常，2：失效',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '开团次数,有多少团长',
  `tuan_config_id` int(11) NOT NULL DEFAULT '0' COMMENT '达标的团购项ID',
  `operation_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '设置团购达标时间',
  `delete_flg` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_tuan
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_tuan_config`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_tuan_config`;
CREATE TABLE `pigcms_tuan_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tuan_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团购ID',
  `number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '参团人数',
  `price` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '团购价格',
  `discount` float(8,1) NOT NULL DEFAULT '10.0' COMMENT '折扣',
  `start_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '初始人数',
  PRIMARY KEY (`id`),
  KEY `tuan_id` (`tuan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_tuan_config
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_tuan_team`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_tuan_team`;
CREATE TABLE `pigcms_tuan_team` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `tuan_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID，开团人UID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '团购类型，0：人缘团，1：最优团',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购项',
  `real_item_id` int(11) NOT NULL DEFAULT '0' COMMENT '开团实际达标等级',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '拼团状态，0：进行中，1：成功，2：失败',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开团是否成功，判断标准为是否支付，0：不成功，1：成功',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '团长开团的订单ID',
  `number` int(11) NOT NULL DEFAULT '0' COMMENT '团长开团所选团购项的达标数量',
  `order_number` int(11) NOT NULL DEFAULT '0' COMMENT '此开团的购买数量',
  `price` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '此开团所选团购项的折扣后价格',
  PRIMARY KEY (`team_id`),
  KEY `tuan_id` (`tuan_id`),
  KEY `order_id` (`order_id`),
  KEY `price` (`price`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_tuan_team
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_ucenter`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_ucenter`;
CREATE TABLE `pigcms_ucenter` (
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `page_title` varchar(100) NOT NULL COMMENT '页面名称',
  `bg_pic` varchar(200) NOT NULL COMMENT '背景图片',
  `show_level` char(1) NOT NULL DEFAULT '1' COMMENT '显示会员等级 0不显示 1显示',
  `show_point` char(1) NOT NULL DEFAULT '1' COMMENT '显示用户积分 0不显示 1显示',
  `has_custom` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有自定义字段',
  `last_time` int(11) NOT NULL COMMENT '最后编辑时间',
  `promotion_content` text NOT NULL COMMENT '个人中心推广内容',
  `member_content` text NOT NULL COMMENT '会员内容',
  `class_content` text NOT NULL,
  `promotion_field` varchar(250) NOT NULL,
  `consumption_field` varchar(250) NOT NULL COMMENT '消费中心字段',
  `store_banner_field` text NOT NULL,
  `tab_name` text NOT NULL COMMENT '个人中心tab切换',
  UNIQUE KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户中心';

-- ----------------------------
-- Records of pigcms_ucenter
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_unitary`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_unitary`;
CREATE TABLE `pigcms_unitary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称/微信中图文信息标题',
  `logopic` varchar(100) NOT NULL DEFAULT '' COMMENT 'logo图片',
  `cat_fid` int(11) NOT NULL DEFAULT '0' COMMENT '夺宝活动商品所属的 大分类category_id',
  `fistpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片1',
  `secondpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片2',
  `thirdpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片3',
  `fourpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片4',
  `fivepic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片5',
  `sixpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片6',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺组id',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `opentime` int(11) NOT NULL DEFAULT '0' COMMENT '结束后展示结果倒计时',
  `endtime` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '活动开关',
  `renqi` int(11) NOT NULL DEFAULT '0' COMMENT '人气',
  `lucknum` int(11) NOT NULL DEFAULT '0' COMMENT '幸运数字',
  `proportion` double NOT NULL DEFAULT '0',
  `lasttime` int(11) NOT NULL DEFAULT '0',
  `lastnum` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '价格',
  `store_id` int(11) DEFAULT '0' COMMENT '所属店铺',
  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联产品id',
  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格id，无则为空',
  `item_price` int(11) NOT NULL DEFAULT '0' COMMENT '夺宝价格',
  `total_num` int(11) NOT NULL DEFAULT '0' COMMENT '总共需要购买份数',
  `descript` varchar(100) NOT NULL DEFAULT '' COMMENT '夺宝说明',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_unitary
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_unitary_cart`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_unitary_cart`;
CREATE TABLE `pigcms_unitary_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitary_id` int(11) NOT NULL DEFAULT '0' COMMENT '夺宝活动id',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `state` int(11) NOT NULL DEFAULT '0' COMMENT '购买/购物车状态',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_unitary_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_unitary_join`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_unitary_join`;
CREATE TABLE `pigcms_unitary_join` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `unitary_id` int(11) NOT NULL DEFAULT '0' COMMENT '夺宝活动id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',
  `addtime` double NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户参与的夺宝关联记录';

-- ----------------------------
-- Records of pigcms_unitary_join
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_unitary_lucknum`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_unitary_lucknum`;
CREATE TABLE `pigcms_unitary_lucknum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '一元夺宝订单id',
  `lucknum` int(11) NOT NULL DEFAULT '0',
  `addtime` double NOT NULL DEFAULT '0',
  `unitary_id` int(11) NOT NULL DEFAULT '0',
  `cart_id` int(11) NOT NULL DEFAULT '0' COMMENT '购物id',
  `state` int(11) NOT NULL DEFAULT '0',
  `paifa` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_unitary_lucknum
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_unitary_lucknum_caculate`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_unitary_lucknum_caculate`;
CREATE TABLE `pigcms_unitary_lucknum_caculate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lucknum_id` int(11) NOT NULL DEFAULT '0',
  `lucknum` int(11) NOT NULL DEFAULT '0',
  `addtime` double NOT NULL DEFAULT '0',
  `unitary_id` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='夺宝完结幸运号计算记录';

-- ----------------------------
-- Records of pigcms_unitary_lucknum_caculate
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_unitary_order`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_unitary_order`;
CREATE TABLE `pigcms_unitary_order` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(11) NOT NULL DEFAULT '0' COMMENT '总价',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `paytype` varchar(50) NOT NULL DEFAULT '' COMMENT '来自于何种支付(英文格式)',
  `paid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支付，1代表已支付',
  `third_id` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方支付平台的订单ID，用于对帐。',
  `orderid` varchar(255) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',
  `third_data` text NOT NULL COMMENT '第三方支付返回内容',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `address` text NOT NULL COMMENT '收货人地址',
  `address_user` varchar(30) NOT NULL COMMENT '收货人姓名',
  `address_tel` varchar(20) NOT NULL COMMENT '收货人电话',
  `trade_no` varchar(100) NOT NULL COMMENT '支付流水号',
  `total` decimal(10,2) NOT NULL COMMENT '实际支付数额',
  `pay_openid` varchar(50) NOT NULL COMMENT '支付人openid',
  PRIMARY KEY (`pigcms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_unitary_order
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user`;
CREATE TABLE `pigcms_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `openid` varchar(50) NOT NULL COMMENT '微信唯一标识',
  `app_openid` varchar(50) DEFAULT NULL COMMENT 'app端微信唯一标识',
  `reg_time` int(10) unsigned NOT NULL,
  `reg_ip` bigint(20) unsigned NOT NULL,
  `last_time` int(10) unsigned NOT NULL,
  `last_ip` bigint(20) unsigned NOT NULL,
  `check_phone` tinyint(1) NOT NULL DEFAULT '0',
  `login_count` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `intro` varchar(500) NOT NULL DEFAULT '' COMMENT '个人签名',
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '头像',
  `is_weixin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是微信用户 0否 1是',
  `stores` smallint(6) NOT NULL DEFAULT '0' COMMENT '店铺数量',
  `token` varchar(100) NOT NULL DEFAULT '' COMMENT '微信token',
  `smscount` int(10) NOT NULL DEFAULT '0' COMMENT '剩余短信数量',
  `point_balance` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台积分，可直接当现金使用',
  `point_unbalance` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台总积分，不可用的积分',
  `point_gift` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台积分，礼物兑换积分',
  `spend_point_gift` decimal(10,2) DEFAULT '0.00' COMMENT '消耗的平台积分',
  `point_used` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已抵现使用的积分',
  `session_id` varchar(50) NOT NULL DEFAULT '' COMMENT 'session id',
  `server_key` varchar(50) NOT NULL DEFAULT '',
  `source_site_url` varchar(200) NOT NULL DEFAULT '' COMMENT '来源网站',
  `payment_url` varchar(200) NOT NULL DEFAULT '' COMMENT '站外支付地址',
  `notify_url` varchar(200) NOT NULL DEFAULT '' COMMENT '通知地址',
  `oauth_url` varchar(200) NOT NULL DEFAULT '' COMMENT '对接网站用户认证地址',
  `is_seller` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是卖家',
  `third_id` varchar(50) NOT NULL DEFAULT '' COMMENT '第三方id',
  `drp_store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户所属店铺',
  `app_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对接应用id',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '后台ID',
  `item_store_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `weixin_bind` tinyint(1) DEFAULT '1' COMMENT '1:需要绑定手机号方可登陆wap，2.无需绑定即可登陆',
  `sex` tinyint(2) NOT NULL DEFAULT '0' COMMENT '性别：1男 2女 0未知',
  `province` varchar(50) NOT NULL COMMENT '省份',
  `city` varchar(50) NOT NULL COMMENT '城市',
  `point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分总额',
  `invite_admin` int(11) NOT NULL DEFAULT '0' COMMENT '邀请者(总后台代理商)的id',
  `point_given` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已赠送积分',
  `point_received` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '已获赠积分',
  `package_id` int(11) unsigned NOT NULL COMMENT '套餐ID',
  PRIMARY KEY (`uid`),
  KEY `phone` (`phone`) USING BTREE,
  KEY `nickname` (`nickname`) USING BTREE,
  KEY `openid` (`openid`) USING BTREE,
  KEY `app_openid` (`app_openid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_user
-- ----------------------------
INSERT INTO `pigcms_user` VALUES ('5', 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', null, '1439548620', '0', '1439548620', '0', '0', '0', '1', '', '', '0', '4', '', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '1', '', '0', '0', '1', '0', '0', '1', '0', '', '', '0.00', '0', '0.00', '0.00', '0');
INSERT INTO `pigcms_user` VALUES ('6', '111111', '96e79218965eb72c92a549dd5a330112', '18730608396', '', null, '1464247739', '2071355825', '1464247739', '2071355825', '0', '0', '1', '', '', '0', '2', '', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '1', '', '0', '0', '0', '0', '0', '1', '0', '', '', '0.00', '0', '0.00', '0.00', '0');
INSERT INTO `pigcms_user` VALUES ('7', '18518677684', '96e79218965eb72c92a549dd5a330112', '18518677684', '', null, '1464258406', '2071355825', '1464772459', '0', '0', '10', '1', '', '', '0', '15', '', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '1', '', '0', '0', '0', '0', '0', '1', '0', '', '', '0.00', '0', '0.00', '0.00', '0');
INSERT INTO `pigcms_user` VALUES ('9', '呼呼测试', 'e10adc3949ba59abbe56e057f20f883e', '15249917505', '', null, '1464315067', '604467071', '1464418262', '604467071', '0', '7', '1', '', '', '0', '2', '', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '1', '', '0', '0', '0', '0', '0', '1', '0', '', '', '0.00', '0', '0.00', '0.00', '0');
INSERT INTO `pigcms_user` VALUES ('8', 'panda', '96e79218965eb72c92a549dd5a330112', '13699281135', '', null, '1464260107', '2071355825', '1464745291', '0', '0', '1', '1', '', '', '0', '1', '', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '1', '', '0', '0', '0', '0', '0', '1', '0', '', '', '0.00', '0', '0.00', '0.00', '0');
INSERT INTO `pigcms_user` VALUES ('11', 'test', '96e79218965eb72c92a549dd5a330112', '13800138000', '', null, '1464769599', '0', '1464769599', '0', '0', '0', '1', '', '', '0', '0', '', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '0', '', '18', '0', '0', '1', '1', '1', '0', '', '', '0.00', '0', '0.00', '0.00', '0');
INSERT INTO `pigcms_user` VALUES ('10', 'uuuu', '8de1ebe5220196d6acdb486f346fe162', '18910806198', '', null, '1464332983', '0', '1464332983', '0', '0', '0', '1', '', '', '0', '0', '', '0', '0.00', '0.00', '0.00', '0.00', '0.00', '', '', '', '', '', '', '0', '', '0', '0', '0', '0', '0', '1', '0', '', '', '0.00', '0', '0.00', '0.00', '0');

-- ----------------------------
-- Table structure for `pigcms_user_address`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_address`;
CREATE TABLE `pigcms_user_address` (
  `address_id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `session_id` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人',
  `tel` varchar(20) NOT NULL COMMENT '联系电话',
  `province` mediumint(9) NOT NULL COMMENT '省code',
  `city` mediumint(9) NOT NULL COMMENT '市code',
  `area` mediumint(9) NOT NULL COMMENT '区code',
  `address` varchar(300) NOT NULL DEFAULT '' COMMENT '详细地址',
  `zipcode` varchar(10) NOT NULL COMMENT '邮编',
  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认收货地址',
  `add_time` int(11) NOT NULL,
  PRIMARY KEY (`address_id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='收货地址';

-- ----------------------------
-- Records of pigcms_user_address
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_apply_invest`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_apply_invest`;
CREATE TABLE `pigcms_user_apply_invest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '真实姓名',
  `phone` varchar(11) NOT NULL,
  `isforeign` tinyint(1) NOT NULL COMMENT '是否外籍',
  `card_img` varchar(255) NOT NULL COMMENT '名片',
  `iscompany` tinyint(1) NOT NULL COMMENT '是否是企业',
  `person_type` tinyint(1) NOT NULL COMMENT '自然人条件类型',
  `company_name` varchar(200) NOT NULL COMMENT '公司名称',
  `job_grade` varchar(50) NOT NULL COMMENT '职位头衔',
  `description` text NOT NULL COMMENT '自我描述',
  `iscommit` tinyint(1) NOT NULL COMMENT '是否承诺',
  `time` int(10) NOT NULL COMMENT '申请成为投资人时间',
  `status` smallint(2) NOT NULL COMMENT '投资人审核状态',
  `email` varchar(50) NOT NULL,
  `weixin` varchar(50) NOT NULL COMMENT '微信号',
  `province` varchar(12) NOT NULL COMMENT '省份',
  `city` varchar(50) NOT NULL COMMENT '城市',
  `company_type` smallint(2) NOT NULL COMMENT '公司类型',
  `education_back` tinyint(1) NOT NULL COMMENT '教育背景',
  `work_experience` text NOT NULL COMMENT '教育经历',
  `business_prefer` varchar(20) NOT NULL COMMENT '行业偏好',
  `stage_prefer` varchar(20) NOT NULL COMMENT '阶段偏好',
  `investment_time` int(4) NOT NULL,
  `investment_num` tinyint(1) NOT NULL COMMENT '投资项目数',
  `investment_name` varchar(240) NOT NULL COMMENT '已投资项目名称',
  `next_num` smallint(2) NOT NULL COMMENT '项目已到下轮',
  `out_num` smallint(2) NOT NULL COMMENT '成功退出项目',
  `suncess_name` varchar(255) NOT NULL COMMENT '成功项目名称',
  `suncess_intro` text NOT NULL COMMENT '成功案例简介',
  `isinteraction` tinyint(1) NOT NULL COMMENT '与跟投方互动',
  `leader_status` smallint(2) NOT NULL COMMENT '申请领投人状态',
  `apply_leader_time` int(10) NOT NULL COMMENT '申请领投人时间',
  `beilv` int(11) NOT NULL COMMENT '倍率',
  PRIMARY KEY (`id`),
  KEY `id,uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=198 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_user_apply_invest
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_attention`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_attention`;
CREATE TABLE `pigcms_user_attention` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `data_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',
  `data_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型  1，商品 2，店铺',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_user_attention
-- ----------------------------
INSERT INTO `pigcms_user_attention` VALUES ('1', '7', '2', '1', '1464341529', '3');

-- ----------------------------
-- Table structure for `pigcms_user_cart`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_cart`;
CREATE TABLE `pigcms_user_cart` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为分销商品',
  PRIMARY KEY (`pigcms_id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `session_id` (`session_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户的购物车';

-- ----------------------------
-- Records of pigcms_user_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_certificate`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_certificate`;
CREATE TABLE `pigcms_user_certificate` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `certificate` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登陆凭证',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`pigcms_id`),
  UNIQUE KEY `uid` (`uid`) USING BTREE,
  KEY `add_time` (`add_time`) USING BTREE,
  KEY `certificate` (`certificate`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_user_certificate
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_collect`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_collect`;
CREATE TABLE `pigcms_user_collect` (
  `collect_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `dataid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL COMMENT '1:为商品；2:为店铺',
  `is_attention` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否被关注(0:不关注，1：关注)',
  `store_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`collect_id`),
  KEY `user_id` (`user_id`),
  KEY `goods_id` (`dataid`),
  KEY `is_attention` (`is_attention`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户收藏店铺or商品';

-- ----------------------------
-- Records of pigcms_user_collect
-- ----------------------------
INSERT INTO `pigcms_user_collect` VALUES ('1', '7', '2', '1464341532', '1', '0', '0');

-- ----------------------------
-- Table structure for `pigcms_user_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_coupon`;
CREATE TABLE `pigcms_user_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `store_id` int(11) NOT NULL COMMENT '商铺id',
  `coupon_id` int(11) NOT NULL COMMENT '优惠券ID',
  `card_no` char(32) NOT NULL COMMENT '卡号',
  `cname` varchar(255) NOT NULL COMMENT '优惠券名称',
  `face_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券面值(起始)',
  `limit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',
  `start_time` int(11) NOT NULL COMMENT '生效时间',
  `end_time` int(11) NOT NULL COMMENT '过期时间',
  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',
  `is_share` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',
  `is_all_product` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',
  `is_original_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',
  `description` text NOT NULL COMMENT '使用说明',
  `is_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用',
  `is_valid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:不可以使用，1：可以使用',
  `use_time` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券使用时间',
  `timestamp` int(11) NOT NULL COMMENT '领取优惠券的时间',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '券类型（1：优惠券，2：赠送券）',
  `give_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '赠送的订单id',
  `use_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用的订单id',
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除(0:未删除，1：已删除)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_no` (`card_no`),
  KEY `coupon_id` (`coupon_id`),
  KEY `uid` (`uid`),
  KEY `type` (`type`),
  KEY `store_id` (`store_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户领取的优惠券信息';

-- ----------------------------
-- Records of pigcms_user_coupon
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_degree`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_degree`;
CREATE TABLE `pigcms_user_degree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `name` varchar(600) DEFAULT NULL,
  `level_pic` varchar(600) DEFAULT NULL,
  `rule_type` varchar(33) DEFAULT NULL,
  `level_num` int(11) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `is_postage_free` tinyint(1) DEFAULT NULL,
  `is_discount` tinyint(1) DEFAULT '0' COMMENT '是否开启享受会员折扣',
  `degree_month` smallint(3) DEFAULT '0' COMMENT '等级有效期(单位:月)',
  `points_discount_toplimit` double(3,1) DEFAULT '0.0' COMMENT '积分抵现上限每单(元）　',
  `points_discount_ratio` double(3,1) DEFAULT '0.0' COMMENT '积分在订单金额抵现比例（百分比）',
  `trade_limit` int(11) DEFAULT NULL,
  `amount_limit` int(11) DEFAULT NULL,
  `points_limit` int(11) DEFAULT NULL,
  `description` varchar(750) DEFAULT NULL,
  `is_points_discount_toplimit` tinyint(1) DEFAULT '0' COMMENT '是否开启（每单）有积分抵现上限',
  `is_points_discount_ratio` tinyint(1) DEFAULT '0' COMMENT '是否开启积分在订单金额抵现比例',
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_user_degree
-- ----------------------------
INSERT INTO `pigcms_user_degree` VALUES ('1', '9', '12', '普通会员', './static/images/huiyuan/1_04.png', '1', '100', '9.9', '0', '1', '12', '0.0', '0.0', '0', '0', '100', '123', '0', '0', '1464347419');

-- ----------------------------
-- Table structure for `pigcms_user_points`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_points`;
CREATE TABLE `pigcms_user_points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分所属供货商店铺id',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分来源的订单',
  `share_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分来源的分享记录',
  `points` int(11) NOT NULL DEFAULT '0' COMMENT '获取积分数',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '积分来源 - 1:关注公众号送 2:订单满送 3:消费送 4:分享送 5:签到送 6:买特殊商品所送 7:手动增加 8:推广增加',
  `is_available` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用：0：不可以用，1可以使用',
  `is_call_to_fans` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:不发送；1发送通知粉丝获得积分',
  `timestamp` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `bak` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_user_points
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_points_record`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_points_record`;
CREATE TABLE `pigcms_user_points_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户uid',
  `store_id` int(11) DEFAULT NULL COMMENT '获取积分的 来源商铺id',
  `order_id` int(11) DEFAULT NULL COMMENT '赠送积分来源的订单',
  `points` int(11) DEFAULT NULL COMMENT '获取积分数',
  `type` tinyint(1) DEFAULT NULL COMMENT '获取积分方式：1:关注我的微信；2:成功交易数量；3:购买金额达到多少,5:满减送送的积分',
  `is_available` tinyint(1) DEFAULT '1' COMMENT '是否可用：0：不可以用，1可以使用',
  `is_call_to_fans` tinyint(1) DEFAULT NULL COMMENT '0:不发送；1发送通知粉丝获得积分',
  `timestamp` int(11) DEFAULT NULL,
  `money` double(10,2) DEFAULT '0.00' COMMENT '变更金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_user_points_record
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_user_point_log`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_user_point_log`;
CREATE TABLE `pigcms_user_point_log` (
  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `order_offline_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺手工做线下订单ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',
  `point` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作积分',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作状态 0 进行中 1已完成',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型 0 消费产生积分 + 1 消费抵现积分 -',
  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `add_date` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期 格式：19700101',
  `point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分总额',
  `point_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分余额',
  `point_unbalance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分不可用余额',
  `point_send_base` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分发放基数',
  `channel` tinyint(1) unsigned NOT NULL COMMENT '渠道(0表示线上交易,1表示线下交易)',
  `bak` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`pigcms_id`),
  KEY `order_id` (`order_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `order_no` (`order_no`) USING BTREE,
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `supplier_id` (`supplier_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of pigcms_user_point_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_weixin_bind`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_weixin_bind`;
CREATE TABLE `pigcms_weixin_bind` (
  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  `hurl` varchar(150) NOT NULL COMMENT '公众号快速关注链接',
  `idc` tinyint(4) NOT NULL,
  PRIMARY KEY (`pigcms_id`),
  KEY `store_id` (`store_id`) USING BTREE,
  KEY `user_name` (`user_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='绑定微信信息';

-- ----------------------------
-- Records of pigcms_weixin_bind
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_wei_page`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_wei_page`;
CREATE TABLE `pigcms_wei_page` (
  `page_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '页面id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `page_name` varchar(50) NOT NULL COMMENT '页面标题',
  `page_desc` varchar(1000) NOT NULL COMMENT '页面描述',
  `bgcolor` varchar(10) NOT NULL COMMENT '背景颜色',
  `is_home` tinyint(1) NOT NULL DEFAULT '0' COMMENT '主页 0否 1是',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
  `product_count` int(10) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `hits` int(10) NOT NULL DEFAULT '0' COMMENT '页面浏览量',
  `page_sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `has_category` tinyint(1) NOT NULL,
  `has_custom` tinyint(1) NOT NULL,
  `show_head` tinyint(1) DEFAULT '1' COMMENT '是否显示头部,1：显示，2：不显示',
  `show_footer` tinyint(1) DEFAULT '1' COMMENT '是否显示头部,1：显示，2：不显示',
  `type` tinyint(1) DEFAULT '0' COMMENT '特殊微页面分类：1:团购,2:一元夺宝',
  PRIMARY KEY (`page_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='微页面';

-- ----------------------------
-- Records of pigcms_wei_page
-- ----------------------------
INSERT INTO `pigcms_wei_page` VALUES ('1', '1', '这是您的第一篇微杂志', '', '', '1', '1464247764', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('2', '2', '这是您的第一篇微杂志', '', '', '1', '1464248333', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('3', '3', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('4', '3', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '1', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('5', '3', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '1', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('13', '8', '餐饮外卖模板', '餐饮外卖模板', '', '1', '1438999668', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('8', '3', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '2', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('14', '9', '这是您的第一篇微杂志', '', '', '1', '1464260591', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('9', '5', '餐饮外卖模板', '餐饮外卖模板', '', '1', '1438999668', '0', '1', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('10', '3', '测试模版', '', '', '0', '1464258594', '0', '1', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('11', '6', '这是您的第一篇微杂志', '', '', '1', '1464258673', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('12', '7', '这是您的第一篇微杂志', '', '', '1', '1464258704', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('15', '9', '微页面标题', '', '', '0', '1464260788', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('16', '10', '这是您的第一篇微杂志', '', '', '1', '1464312520', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('17', '11', '这是您的第一篇微杂志', '', '', '1', '1464312601', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('18', '12', '鲜花速递模板', '鲜花速递模板', '', '1', '1464315674', '0', '1', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('19', '13', '餐饮外卖模板', '餐饮外卖模板', '', '1', '1438999668', '0', '1', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('20', '14', '这是您的第一篇微杂志', '', '', '1', '1464340760', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('21', '15', '这是您的第一篇微杂志', '', '', '1', '1464340915', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('22', '16', '这是您的第一篇微杂志', '', '', '1', '1464343879', '0', '1', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('23', '13', '微页面标题', '', '', '0', '1464345134', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('24', '13', '微页面标题', '', '', '0', '1464345134', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('25', '13', '微页面标题', '', '', '0', '1464345135', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('26', '13', '微页面标题', '', '', '0', '1464345138', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('27', '13', '微页面标题', '', '', '0', '1464345139', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('28', '13', '微页面标题', '', '', '0', '1464345139', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('29', '17', '这是您的第一篇微杂志', '', '', '1', '1464346625', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('30', '18', '通用模板', '通用模板', '', '0', '1438999689', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('31', '18', '餐饮外卖模板', '餐饮外卖模板', '', '0', '1438999668', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('32', '18', '食品电商模板', '食品电商模板', '', '0', '1438999652', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('33', '18', '美妆电商模板', '美妆电商模板', '', '0', '1438999625', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('34', '18', '线下门店模板', '线下门店模板', '', '0', '1438999588', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('35', '18', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('36', '19', '这是您的第一篇微杂志', '', '', '1', '1464588217', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('37', '20', '这是您的第一篇微杂志', '', '', '1', '1464588359', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('38', '21', '这是您的第一篇微杂志', '', '', '1', '1464596171', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('39', '22', '这是您的第一篇微杂志', '', '', '1', '1464596508', '0', '0', '0', '0', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('40', '23', '鲜花速递模板', '鲜花速递模板', '', '1', '1438999567', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('41', '24', '食品电商模板', '食品电商模板', '', '1', '1438999652', '0', '0', '0', '1', '1', '1', '1', '0');
INSERT INTO `pigcms_wei_page` VALUES ('42', '25', '鲜花速递模板', '鲜花速递模板', '', '1', '1464609847', '0', '0', '0', '0', '1', '1', '1', '0');

-- ----------------------------
-- Table structure for `pigcms_wei_page_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_wei_page_category`;
CREATE TABLE `pigcms_wei_page_category` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '微页面分类id',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名',
  `first_sort` varchar(20) NOT NULL DEFAULT '' COMMENT '排序 pv DESC order_by DESC',
  `second_sort` varchar(20) NOT NULL DEFAULT '' COMMENT '排序 date_added DESC date_added DESC pv DESC',
  `show_style` char(1) NOT NULL DEFAULT '0' COMMENT '显示样式 0仅显示杂志列表 1用期刊方式展示',
  `cat_desc` text NOT NULL COMMENT '简介',
  `page_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '微页面数',
  `has_custom` tinyint(1) NOT NULL,
  `add_time` int(11) NOT NULL COMMENT '创建日期',
  `cover_img` varchar(100) NOT NULL DEFAULT '' COMMENT '封面路径',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `page_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`),
  KEY `store_id` (`store_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='微页面分类';

-- ----------------------------
-- Records of pigcms_wei_page_category
-- ----------------------------
INSERT INTO `pigcms_wei_page_category` VALUES ('1', '1', '1111111', '0', '0', '0', '', '0', '0', '1464251852', '', '6', '0');
INSERT INTO `pigcms_wei_page_category` VALUES ('2', '3', '通用模板', '0', '0', '0', '<p>通用模板描述。</p>', '1', '0', '1438998819', '/upload/images/icon_03.png', '6', '3');
INSERT INTO `pigcms_wei_page_category` VALUES ('3', '3', '餐饮外卖', '0', '0', '0', '<p>餐饮外卖描述。</p>', '1', '0', '1438998801', '/upload/images/icon_05.png', '6', '4');
INSERT INTO `pigcms_wei_page_category` VALUES ('4', '3', '食品电商', '0', '0', '0', '<p>食品电商描述</p>', '1', '0', '1438998781', '/upload/images/icon_07.png', '6', '5');
INSERT INTO `pigcms_wei_page_category` VALUES ('5', '3', '美妆电商', '1', '0', '0', '<p>美妆电商描述。</p>', '1', '0', '1438998760', '/upload/images/icon_12.png', '6', '6');
INSERT INTO `pigcms_wei_page_category` VALUES ('6', '3', '线下门店', '0', '0', '0', '<p>线下门店描述</p>', '1', '0', '1438998738', '/upload/images/icon_13.png', '6', '7');
INSERT INTO `pigcms_wei_page_category` VALUES ('7', '3', '鲜花速递', '0', '0', '0', '<p>鲜花速递描述。</p>', '1', '0', '1438998718', '/upload/images/icon_14.png', '6', '8');
INSERT INTO `pigcms_wei_page_category` VALUES ('8', '5', '餐饮外卖', '0', '0', '0', '<p>餐饮外卖描述。</p>', '1', '0', '1438998801', '/upload/images/icon_05.png', '7', '4');
INSERT INTO `pigcms_wei_page_category` VALUES ('9', '8', '餐饮外卖', '0', '0', '0', '<p>餐饮外卖描述。</p>', '1', '0', '1438998801', '/upload/images/icon_05.png', '7', '4');
INSERT INTO `pigcms_wei_page_category` VALUES ('10', '9', '线下门店', '0', '0', '0', '<p>线下门店描述</p>', '1', '0', '1438998738', '/upload/images/icon_13.png', '8', '7');
INSERT INTO `pigcms_wei_page_category` VALUES ('11', '11', '美妆电商', '1', '0', '0', '<p>美妆电商描述。</p>', '1', '0', '1438998760', '/upload/images/icon_12.png', '7', '6');
INSERT INTO `pigcms_wei_page_category` VALUES ('12', '12', '鲜花速递', '0', '0', '0', '<p>鲜花速递描述。</p>', '1', '0', '1438998718', '/upload/images/icon_14.png', '9', '8');
INSERT INTO `pigcms_wei_page_category` VALUES ('13', '13', '餐饮外卖', '0', '0', '0', '<p>餐饮外卖描述。</p>', '1', '0', '1438998801', '/upload/images/icon_05.png', '7', '4');
INSERT INTO `pigcms_wei_page_category` VALUES ('14', '17', '线下门店', '0', '0', '0', '<p>线下门店描述</p>', '1', '0', '1438998738', '/upload/images/icon_13.png', '9', '7');
INSERT INTO `pigcms_wei_page_category` VALUES ('15', '18', '通用模板', '0', '0', '0', '<p>通用模板描述。</p>', '1', '0', '1438998819', '/upload/images/icon_03.png', '5', '30');
INSERT INTO `pigcms_wei_page_category` VALUES ('16', '18', '餐饮外卖', '0', '0', '0', '<p>餐饮外卖描述。</p>', '1', '0', '1438998801', '/upload/images/icon_05.png', '5', '31');
INSERT INTO `pigcms_wei_page_category` VALUES ('17', '18', '食品电商', '0', '0', '0', '<p>食品电商描述</p>', '1', '0', '1438998781', '/upload/images/icon_07.png', '5', '32');
INSERT INTO `pigcms_wei_page_category` VALUES ('18', '18', '美妆电商', '1', '0', '0', '<p>美妆电商描述。</p>', '1', '0', '1438998760', '/upload/images/icon_12.png', '5', '33');
INSERT INTO `pigcms_wei_page_category` VALUES ('19', '18', '线下门店', '0', '0', '0', '<p>线下门店描述</p>', '1', '0', '1438998738', '/upload/images/icon_13.png', '5', '34');
INSERT INTO `pigcms_wei_page_category` VALUES ('20', '18', '鲜花速递', '0', '0', '0', '<p>鲜花速递描述。</p>', '1', '0', '1438998718', '/upload/images/icon_14.png', '5', '35');
INSERT INTO `pigcms_wei_page_category` VALUES ('21', '23', '鲜花速递', '0', '0', '0', '<p>鲜花速递描述。</p>', '1', '0', '1438998718', '/upload/images/icon_14.png', '7', '35');
INSERT INTO `pigcms_wei_page_category` VALUES ('22', '24', '食品电商', '0', '0', '0', '<p>食品电商描述</p>', '1', '0', '1438998781', '/upload/images/icon_07.png', '7', '32');
INSERT INTO `pigcms_wei_page_category` VALUES ('23', '25', '鲜花速递', '0', '0', '0', '<p>鲜花速递描述。</p>', '1', '0', '1438998718', '/upload/images/icon_14.png', '7', '35');

-- ----------------------------
-- Table structure for `pigcms_wei_page_to_category`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_wei_page_to_category`;
CREATE TABLE `pigcms_wei_page_to_category` (
  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL DEFAULT '0' COMMENT '微页面id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '微页面分类id',
  PRIMARY KEY (`pigcms_id`),
  KEY `wei_page_id` (`page_id`) USING BTREE,
  KEY `wei_page_category_id` (`cat_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='微页面关联分类';

-- ----------------------------
-- Records of pigcms_wei_page_to_category
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_yousetdiscount`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_yousetdiscount`;
CREATE TABLE `pigcms_yousetdiscount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '活动名称',
  `startdate` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `enddate` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `playtime` int(11) NOT NULL DEFAULT '10' COMMENT '每人玩耍时间(秒)',
  `info` text COMMENT '活动规则',
  `bg1` varchar(200) NOT NULL DEFAULT '' COMMENT '背景图片1',
  `bg2` varchar(200) NOT NULL DEFAULT '' COMMENT '背景图片2',
  `bg3` varchar(200) NOT NULL DEFAULT '' COMMENT '背景图片3',
  `gamepic1` varchar(200) NOT NULL DEFAULT '' COMMENT '游戏图片1',
  `gamepic2` varchar(200) NOT NULL DEFAULT '' COMMENT '游戏图片2',
  `my_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '直接参与者的玩耍次数',
  `friends_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '朋友帮玩的次数',
  `money_start` double NOT NULL DEFAULT '0' COMMENT '每轮最低价格',
  `money_end` double NOT NULL DEFAULT '0' COMMENT '每轮最高价格',
  `is_open` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启:0开启 1关闭',
  `is_attention` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要关注公众号: 0否 1是',
  `addtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `discount_endtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '优惠结束时间',
  `fxtitle` varchar(500) NOT NULL DEFAULT '' COMMENT '分享标题',
  `fxinfo` varchar(500) NOT NULL DEFAULT '' COMMENT '分享描述',
  `fxtitle2` varchar(500) NOT NULL DEFAULT '' COMMENT '游戏中分享标题',
  `fxinfo2` varchar(500) NOT NULL DEFAULT '' COMMENT '游戏中分享描述',
  `fxpic` varchar(200) DEFAULT '' COMMENT '分享图片自定义',
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `name` (`name`),
  KEY `is_open` (`is_open`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_yousetdiscount
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_yousetdiscount_direction`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_yousetdiscount_direction`;
CREATE TABLE `pigcms_yousetdiscount_direction` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `yid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联活动表主键id',
  `at_least` double NOT NULL DEFAULT '0' COMMENT '满xxx分数',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠劵id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_yousetdiscount_direction
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_yousetdiscount_helps`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_yousetdiscount_helps`;
CREATE TABLE `pigcms_yousetdiscount_helps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `yid` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `help` varchar(100) NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `playcount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_yousetdiscount_helps
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_yousetdiscount_helps_data`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_yousetdiscount_helps_data`;
CREATE TABLE `pigcms_yousetdiscount_helps_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `yid` int(11) NOT NULL,
  `hid` int(11) NOT NULL,
  `discount` double NOT NULL DEFAULT '0' COMMENT '帮忙获得的分数',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '帮忙时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_yousetdiscount_helps_data
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_yousetdiscount_users`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_yousetdiscount_users`;
CREATE TABLE `pigcms_yousetdiscount_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `yid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联接力活动id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `share_key` varchar(100) NOT NULL DEFAULT '' COMMENT '分享帮忙的key',
  `state` tinyint(2) NOT NULL DEFAULT '0' COMMENT '领取状态默认0：0未领取 1已领取',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '分享时间',
  `discount` double NOT NULL DEFAULT '0' COMMENT '最终获取的分数',
  `did` int(11) NOT NULL DEFAULT '0' COMMENT '优惠等级的direction表 id',
  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠劵id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_yousetdiscount_users
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_zc_product`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_zc_product`;
CREATE TABLE `pigcms_zc_product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品id 主键自增',
  `uid` int(11) NOT NULL COMMENT '项目发起人uid',
  `label` varchar(50) NOT NULL COMMENT '标签',
  `productType` tinyint(2) NOT NULL COMMENT '项目类型 1,回报众筹  2,公益捐助众筹',
  `productName` varchar(100) NOT NULL COMMENT '项目名称',
  `productAdWord` varchar(255) NOT NULL COMMENT '项目一句话介绍',
  `amount` int(11) NOT NULL COMMENT '筹资金额',
  `toplimit` int(11) NOT NULL COMMENT '筹资上限',
  `collectDays` int(11) NOT NULL COMMENT '筹资天数',
  `raiseType` tinyint(1) NOT NULL COMMENT '筹资类型',
  `productThumImage` varchar(100) NOT NULL COMMENT '产品预热图片',
  `productListImg` varchar(100) NOT NULL COMMENT '列表页图片',
  `productFirstImg` varchar(100) NOT NULL COMMENT '首页图片',
  `productImage` varchar(100) NOT NULL COMMENT '项目图片',
  `productImageMobile` varchar(100) NOT NULL COMMENT '移动端图片',
  `videoAddr` varchar(100) NOT NULL COMMENT '视频介绍',
  `productSummary` varchar(255) NOT NULL COMMENT '项目简介',
  `productDetails` text NOT NULL COMMENT '项目详情',
  `time` char(10) NOT NULL COMMENT '添加时间',
  `praise` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数量',
  `status` tinyint(1) NOT NULL COMMENT '项目状态 0 草稿 1申请中 2审核通过预热中 3审核拒绝  4融资中 6融资成功 7融资失败',
  `collect` int(11) NOT NULL DEFAULT '0' COMMENT '以募集金额(元)',
  `people_number` int(11) DEFAULT '0' COMMENT '总募集人数',
  `start_time` char(10) NOT NULL COMMENT '众筹开始时间',
  `attention` int(11) NOT NULL COMMENT '关注',
  `class` tinyint(2) NOT NULL COMMENT '项目分类',
  `classname` varchar(20) NOT NULL COMMENT '分类名',
  `isShow` tinyint(1) DEFAULT '0' COMMENT '是否开启展示 0为不开启 1为开启',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `endtime` char(10) NOT NULL COMMENT '结束时间',
  PRIMARY KEY (`product_id`),
  KEY `jihua` (`raiseType`,`status`,`endtime`) USING BTREE,
  KEY `collect` (`status`,`collect`) USING BTREE,
  KEY `people_number` (`status`,`people_number`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=222 DEFAULT CHARSET=utf8 COMMENT='众筹产品表';

-- ----------------------------
-- Records of pigcms_zc_product
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_zc_product_class`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_zc_product_class`;
CREATE TABLE `pigcms_zc_product_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '分类名',
  `time` varchar(10) NOT NULL,
  `sort` smallint(3) NOT NULL COMMENT '排序',
  `img` varchar(80) NOT NULL COMMENT '分类图片',
  `remark` varchar(200) NOT NULL COMMENT '备注',
  `icon` varchar(80) NOT NULL COMMENT '分类图标',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pigcms_zc_product_class
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_zc_product_load`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_zc_product_load`;
CREATE TABLE `pigcms_zc_product_load` (
  `load_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '项目进展id',
  `time` int(10) NOT NULL COMMENT '添加时间',
  `type` tinyint(1) NOT NULL COMMENT '类型 1为产品众筹',
  `content` varchar(500) NOT NULL COMMENT '项目进展内容',
  `product_id` int(11) NOT NULL COMMENT '产品id',
  PRIMARY KEY (`load_id`),
  KEY `product_id` (`load_id`,`product_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='产品众筹 项目进展表';

-- ----------------------------
-- Records of pigcms_zc_product_load
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_zc_product_repay`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_zc_product_repay`;
CREATE TABLE `pigcms_zc_product_repay` (
  `repay_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT '项目id',
  `redoundType` tinyint(1) NOT NULL COMMENT '回报类别',
  `raffleType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为抽奖档',
  `raffleRule` tinyint(1) NOT NULL COMMENT '抽奖规则',
  `platform` tinyint(1) NOT NULL COMMENT '回报档位 0普通  1手机专享 2手机优惠  5老友专享',
  `amount` int(11) NOT NULL COMMENT '支持金额',
  `mamount` int(10) NOT NULL COMMENT '手机端金额',
  `redoundContent` text NOT NULL COMMENT '回报内容',
  `images` varchar(100) NOT NULL COMMENT '说明图片',
  `scrambleStatus` tinyint(1) NOT NULL COMMENT '是否设置抢购',
  `limits` int(10) NOT NULL COMMENT '限定名额',
  `collect_nub` int(10) NOT NULL COMMENT '该档位已筹集人数',
  `freight` int(4) NOT NULL COMMENT '运费',
  `invoiceStatus` tinyint(1) NOT NULL COMMENT '是否开发票',
  `remarkStatus` tinyint(1) NOT NULL COMMENT '是否填写备注信息',
  `remark` varchar(255) NOT NULL COMMENT '备注信息',
  `redoundDays` mediumint(4) NOT NULL COMMENT '回报时间 单位天',
  `raffleBase` mediumint(6) NOT NULL COMMENT '每满抽奖规则1的人数',
  `raffleReword` varchar(50) NOT NULL COMMENT '抽奖规则1的奖品',
  `luckyCount` mediumint(6) NOT NULL COMMENT '每满抽奖规则2的人数',
  `luckyReword` varchar(50) NOT NULL COMMENT '抽奖规则2的奖品',
  `isSelfless` tinyint(1) NOT NULL COMMENT '是否是无私奉献档位',
  `time` int(10) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`repay_id`),
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='产品众筹回报设置表';

-- ----------------------------
-- Records of pigcms_zc_product_repay
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_zc_product_sponsor`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_zc_product_sponsor`;
CREATE TABLE `pigcms_zc_product_sponsor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(20) NOT NULL COMMENT '联系人别名',
  `uid` int(11) NOT NULL,
  `introduce` varchar(90) NOT NULL COMMENT '自我描述',
  `sponsorDetails` text NOT NULL COMMENT '详细自我介绍',
  `weiBo` varchar(100) NOT NULL COMMENT '微博/博客地址',
  `thankMess` text NOT NULL,
  `sponsorPhone` varchar(40) NOT NULL COMMENT '发起人电话',
  `holderName` varchar(50) NOT NULL DEFAULT '' COMMENT '收款人或收款公司名称',
  `bankNo` smallint(2) NOT NULL COMMENT '银行id号',
  `directBranch` varchar(40) NOT NULL COMMENT '支行',
  `cardNo` varchar(30) NOT NULL COMMENT '银行卡号',
  `bankCode` varchar(30) NOT NULL DEFAULT '' COMMENT '联行号',
  `time` int(11) NOT NULL,
  `avatar` varchar(200) NOT NULL COMMENT '头像',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目发起人表';

-- ----------------------------
-- Records of pigcms_zc_product_sponsor
-- ----------------------------

-- ----------------------------
-- Table structure for `pigcms_zc_product_topic`
-- ----------------------------
DROP TABLE IF EXISTS `pigcms_zc_product_topic`;
CREATE TABLE `pigcms_zc_product_topic` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '回复的话题',
  `title` varchar(100) NOT NULL COMMENT '名称',
  `praise` int(11) NOT NULL COMMENT '点赞数量',
  `product_id` int(11) NOT NULL COMMENT '产品项目id',
  `time` int(10) NOT NULL,
  `uid` int(11) NOT NULL COMMENT '添加人',
  `puid` int(11) NOT NULL COMMENT '回复的对象uid',
  PRIMARY KEY (`topic_id`),
  KEY `product_id` (`pid`,`product_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COMMENT='产品众筹 话题表';

-- ----------------------------
-- Records of pigcms_zc_product_topic
-- ----------------------------
