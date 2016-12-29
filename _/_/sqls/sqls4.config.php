<?php
header("Content-type: text/html; charset=utf-8");
return array(
/*sqls*/
//2016-04-10 16:46:34
array('time'=>mktimes(1970,1,1,21,3),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}admin`ADD COLUMN `open_id`  varchar(50) NOT NULL COMMENT '区域管理员微信id （用于消息通知）' AFTER `agent_code`",'des'=>'...'),

//2016-04-10 14:38:06
array('time'=>mktimes(1970,1,1,21,2),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}unitary_join` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',  `unitary_id` int(11) NOT NULL DEFAULT '0' COMMENT '夺宝活动id',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',  `addtime` double NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户参与的夺宝关联记录' AUTO_INCREMENT=1",'des'=>'...'),

//2016-04-10 14:37:55
array('time'=>mktimes(1970,1,1,21,1),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}unitary_lucknum_caculate` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `lucknum_id` int(11) NOT NULL DEFAULT '0',  `lucknum` int(11) NOT NULL DEFAULT '0',  `addtime` double NOT NULL DEFAULT '0',  `unitary_id` int(11) NOT NULL DEFAULT '0',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='夺宝完结幸运号计算记录' AUTO_INCREMENT=1",'des'=>'...'),


//2016-04-08 18:19:18
array('time'=>mktimes(1970,1,1,20,60),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `tag_id` INT( 11 ) UNSIGNED NOT NULL COMMENT  '店铺标签ID' AFTER  `template_id` ,ADD INDEX (  `tag_id` )",'des'=>'...'),

//2016-04-08 18:19:41
array('time'=>mktimes(1970,1,1,20,59),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`, `is_admin`) VALUES ('91', '12', '特色类别管理', 'Store', 'tag', '0', '1', '1', '0')",'des'=>'...'),

//2016-04-08 18:19:28
array('time'=>mktimes(1970,1,1,20,58),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_tag` (  `tag_id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(250) NOT NULL COMMENT '名称',  `order_by` int(100) NOT NULL DEFAULT '0' COMMENT '排序，越小越前面',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用（1：启用；  0：禁用）',  PRIMARY KEY (`tag_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺类别表'",'des'=>'...'),

//2016-04-08 17:27:29
array('time'=>mktimes(1970,1,1,20,56),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}news`ADD COLUMN `imgUrl`  varchar(255) NULL",'des'=>'...'),
array('time'=>mktimes(1970,1,1,20,55),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}news`CHANGE COLUMN `cat_id` `cat_key`  varchar(20) NULL DEFAULT NULL",'des'=>'...'),

//2016-04-07 19:41:02
array('time'=>mktimes(1970,1,1,20,54),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `point2money_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '总额(变现积分)' AFTER `point2money`",'des'=>'...'),

//2016-04-07 19:29:55
array('time'=>mktimes(1970,1,1,20,53),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`, `is_admin`) VALUES ('90', '70', '保证金返还', 'Credit', 'returnRecord', '0', '1', '1', '0')",'des'=>'...'),

//2016-04-07 11:10:56
array('time'=>mktimes(1970,1,1,20,52),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}platform_margin_log`MODIFY COLUMN `status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0未支付 1未处理 2已处理 3已取消' AFTER `type`",'des'=>'...'),

//2016-04-07 11:09:23
array('time'=>mktimes(1970,1,1,20,51),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_point_log`ADD COLUMN `amount`  decimal(10,2) NOT NULL DEFAULT 0 COMMENT '积分对应的金额' AFTER `point`",'des'=>'...'),

//2016-04-07 11:08:32
array('time'=>mktimes(1970,1,1,20,50),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`key`, `value`, `bak`) VALUES ('margin_withdrawal', '0.00', '保证金已提现金额')",'des'=>'...'),

//2016-04-07 11:08:17
array('time'=>mktimes(1970,1,1,20,49),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `margin_withdrawal`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台保证金已提现金额' AFTER `expiration`",'des'=>'...'),

//2016-04-07 10:26:36
array('time'=>mktimes(1970,1,1,20,48),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}promotion_reward_log` ADD  `service_fee` DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0.00' COMMENT  '当时服务费' AFTER  `reward_rate`",'des'=>'...'),

//2016-04-07 10:17:24
array('time'=>mktimes(1970,1,1,20,47),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}seckill_user` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `seckill_user_id` int(11) unsigned NOT NULL COMMENT '参与秒杀的用户',  `seckill_id` int(11) unsigned NOT NULL COMMENT '秒杀id',  `preset_time` int(11) unsigned NOT NULL COMMENT '提前秒数',  `add_time` int(11) unsigned NOT NULL,  `update_time` int(11) unsigned NOT NULL,  PRIMARY KEY (`pigcms_id`)) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-04-07 10:17:11
array('time'=>mktimes(1970,1,1,20,46),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}seckill_share_user` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `seckill_user_id` int(11) unsigned NOT NULL COMMENT '秒杀活动用户id',  `user_id` int(11) NOT NULL COMMENT '帮助用户id',  `seckill_id` int(11) unsigned NOT NULL COMMENT '秒杀Id',  `preset_time` int(11) unsigned NOT NULL COMMENT '提前时间',  `add_time` int(11) unsigned NOT NULL,  PRIMARY KEY (`pigcms_id`)) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-04-07 10:16:50
array('time'=>mktimes(1970,1,1,20,45),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}seckill` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(50) NOT NULL COMMENT '活动名称',  `store_id` int(11) NOT NULL,  `product_id` int(11) NOT NULL COMMENT '秒杀活动商品id',  `sku_id` int(11) unsigned NOT NULL COMMENT '商品规格id',  `seckill_price` float(10,2) NOT NULL COMMENT '秒杀价',  `start_time` int(11) NOT NULL,  `end_time` int(11) NOT NULL,  `preset_time` int(11) NOT NULL COMMENT '好友分享提前时间',  `description` text NOT NULL,  `is_subscribe` tinyint(1) NOT NULL COMMENT '是否关注公众号',  `reduce_point` int(11) NOT NULL,  `delete_flag` tinyint(1) NOT NULL COMMENT '是否删除 0正常  1已删除 ',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '秒杀状态 1 正常 2 失效',  `sales_volume` int(11) NOT NULL COMMENT '活动商品销量',  `add_time` int(11) NOT NULL COMMENT '添加时间',  `update_time` int(11) NOT NULL COMMENT '修改时间',  PRIMARY KEY (`pigcms_id`)) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-04-07 9:40:14
array('time'=>mktimes(1970,1,1,20,44),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('133', 'is_change_bankcard_open', 'type=radio&value=1:是|0:否', '0', '店铺修改提现银行卡', '开启后，店铺可以自由修改提现银行卡账号。关闭后用户不能随意修改银行卡账号。', '0', '', '2', '0', '1')",'des'=>'...'),

//2016-04-07 9:12:57
array('time'=>mktimes(1970,1,1,20,43),'type'=>'sql','sql'=>"UPDATE  `{tableprefix}config` SET  `desc` =  '多个帐号用逗号‘,’隔开，顺序为：普通交易货款,积分保证金' WHERE  `{tableprefix}config`.`id` =45",'des'=>'...'),
array('time'=>mktimes(1970,1,1,20,42),'type'=>'sql','sql'=>"UPDATE  `{tableprefix}config` SET  `desc` =  '多个帐号用逗号‘,’隔开，顺序为：普通交易货款,积分保证金' WHERE  `{tableprefix}config`.`id` =44",'des'=>'...'),

//2016-04-06 18:59:54
array('time'=>mktimes(1970,1,1,20,41),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}news`ADD COLUMN `newsType`  tinyint(1) NULL DEFAULT 0 COMMENT '文章类型'",'des'=>'...'),

//2016-04-06 11:42:17
array('time'=>mktimes(1970,1,1,20,40),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('141', 'store_point_total', 'type=text&size=20&validate=required:true,number:true,maxlength:10', '0', '店铺每日做单限额', '商家每日做单，返送的积分，达到此值，当日就不能再次做单了，0表示不限', '', '店铺每日做单限额', '17', '0', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,20,39),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('140', 'user_point_total', 'type=text&size=20&validate=required:true,number:true,maxlength:10', '0', '用户积分购买', '当用户所有积分总额（待释放+可用）超过此值，用户不能用现金购物，不能受赠，0表示不限', '', '用户积分购买', '17', '0', '1')",'des'=>'...'),

//2016-04-06 9:58:28
array('time'=>mktimes(1970,1,1,20,38),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}zc_product_class`ADD COLUMN `icon`  varchar(80) NOT NULL COMMENT '分类图标'",'des'=>'...'),

//2016-04-05 11:19:13
array('time'=>mktimes(1970,1,1,20,37),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}package` ADD  `store_online_trade` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' COMMENT  '店铺线上交易' AFTER  `store_nums`",'des'=>'...'),

//2016-04-05 11:00:01
array('time'=>mktimes(1970,1,1,20,36),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_sku`ADD COLUMN `wholesale_sku_id`  int(11) UNSIGNED NOT NULL COMMENT '原商品库存id'",'des'=>'...'),

//2016-04-05 9:36:45
array('time'=>mktimes(1970,1,1,20,35),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}project_praise`ADD COLUMN `type`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '关注类型 1股权众筹 2产品众筹'",'des'=>'...'),

//2016-04-05 9:36:38
array('time'=>mktimes(1970,1,1,20,34),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}project_attention`ADD COLUMN `type`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '关注类型 股权众筹1 产品众筹2 '",'des'=>'...'),

//2016-04-01 17:02:09
array('time'=>mktimes(1970,1,1,20,33),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_withdrawal`ADD COLUMN `channel`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '渠道 0 收益提现 1 积分兑换提现' AFTER `type`",'des'=>'...'),

//2016-04-01 17:01:55
array('time'=>mktimes(1970,1,1,20,32),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_withdrawal`ADD COLUMN `type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT ' 0 分销商提现，1 供货商提现 2 经销商提现 3 积分兑换提现' AFTER `sales_ratio`",'des'=>'...'),

//2016-04-01 14:13:16
array('time'=>mktimes(1970,1,1,20,31),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` VALUES ('132', 'reg_readme_content', 'type=textarea&rows=20&cols=93', '', '用户注册协议', '用户注册前必须先阅读并同意该协议', '0', '', '1', '0', '1')",'des'=>'...'),

//2016-03-30 18:02:59
array('time'=>mktimes(1970,1,1,20,30),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}flink_config` (  `key` varchar(100) NOT NULL,  `value` varchar(100) NOT NULL,  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示为友情链接顶级分类',  UNIQUE KEY `key` (`key`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='首页底部配置表'",'des'=>'...'),

//2016-03-30 18:02:43
array('time'=>mktimes(1970,1,1,20,29),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}flink` ADD  `parent_key` VARCHAR( 100 ) NOT NULL COMMENT  '父键(关联配置表)'",'des'=>'...'),

//2016-03-30 17:56:02
array('time'=>mktimes(1970,1,1,20,28),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}zc_product`ADD COLUMN `isShow`  tinyint(1) NULL DEFAULT 0 COMMENT '是否开启展示 0为不开启 1为开启'",'des'=>'...'),

//2016-03-30 17:38:16
array('time'=>mktimes(1970,1,1,20,27),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}zc_product_sponsor`ADD COLUMN `avatar`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '头像'",'des'=>'...'),

//2016-03-30 15:40:26
array('time'=>mktimes(1970,1,1,20,26),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}invest_slide`ADD COLUMN `remark`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注'",'des'=>'...'),

//2016-03-30 14:44:07
array('time'=>mktimes(1970,1,1,20,25),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}invest_order`ADD COLUMN `pay_money`  int(11) NULL,ADD COLUMN `order_type`  int(11) NULL,ADD COLUMN `freight`  int(11) NULL,ADD COLUMN `is_delete`  tinyint(1) NULL,ADD COLUMN `remark`  varchar(500) NULL,ADD COLUMN `repay_id`  int(11) NULL,ADD COLUMN `order_status`  tinyint(1) NULL,ADD COLUMN `extract_number`  varchar(50) NULL",'des'=>'...'),

//2016-03-30 14:25:15
array('time'=>mktimes(1970,1,1,20,24),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES ('89', '100', '产品众筹管理', 'Invest', 'product', '0', '1', '1')",'des'=>'...'),


//2016-03-30 13:12:59
array('time'=>mktimes(1970,1,1,20,21),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}zc_product_topic` (  `topic_id` int(11) NOT NULL AUTO_INCREMENT,  `pid` int(11) NOT NULL COMMENT '回复的话题',  `title` varchar(100) NOT NULL COMMENT '名称',  `praise` int(11) NOT NULL COMMENT '点赞数量',  `product_id` int(11) NOT NULL COMMENT '产品项目id',  `time` int(10) NOT NULL,  `uid` int(11) NOT NULL COMMENT '添加人',  `puid` int(11) NOT NULL COMMENT '回复的对象uid',  PRIMARY KEY (`topic_id`)) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COMMENT='产品众筹 话题表'",'des'=>'...'),

//2016-03-30 13:12:48
array('time'=>mktimes(1970,1,1,20,20),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}zc_product_sponsor` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `nickname` varchar(20) NOT NULL COMMENT '联系人别名',  `uid` int(11) NOT NULL,  `introduce` varchar(90) NOT NULL COMMENT '自我描述',  `sponsorDetails` text NOT NULL COMMENT '详细自我介绍',  `weiBo` varchar(100) NOT NULL COMMENT '微博/博客地址',  `thankMess` text NOT NULL,  `sponsorPhone` varchar(11) NOT NULL COMMENT '发起人电话',  `holderName` varchar(50) NOT NULL DEFAULT '' COMMENT '收款人或收款公司名称',  `bankNo` smallint(2) NOT NULL COMMENT '银行id号',  `directBranch` varchar(40) NOT NULL COMMENT '支行',  `cardNo` varchar(30) NOT NULL COMMENT '银行卡号',  `bankCode` varchar(30) NOT NULL DEFAULT '' COMMENT '联行号',  `time` int(11) NOT NULL,  PRIMARY KEY (`id`),  KEY `uid` (`uid`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目发起人表'",'des'=>'...'),

//2016-03-30 13:12:37
array('time'=>mktimes(1970,1,1,20,19),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}zc_product_repay` (  `repay_id` int(11) NOT NULL AUTO_INCREMENT,  `product_id` int(11) NOT NULL COMMENT '项目id',  `redoundType` tinyint(1) NOT NULL COMMENT '回报类别',  `raffleType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为抽奖档',  `raffleRule` tinyint(1) NOT NULL COMMENT '抽奖规则',  `platform` tinyint(1) NOT NULL COMMENT '回报档位 0普通  1手机专享 2手机优惠  5老友专享',  `amount` int(11) NOT NULL COMMENT '支持金额',  `mamount` int(10) NOT NULL COMMENT '手机端金额',  `redoundContent` text NOT NULL COMMENT '回报内容',  `images` varchar(100) NOT NULL COMMENT '说明图片',  `scrambleStatus` tinyint(1) NOT NULL COMMENT '是否设置抢购',  `limits` int(10) NOT NULL COMMENT '限定名额',  `collect_nub` int(10) NOT NULL COMMENT '该档位已筹集人数',  `freight` int(4) NOT NULL COMMENT '运费',  `invoiceStatus` tinyint(1) NOT NULL COMMENT '是否开发票',  `remarkStatus` tinyint(1) NOT NULL COMMENT '是否填写备注信息',  `remark` varchar(255) NOT NULL COMMENT '备注信息',  `redoundDays` mediumint(4) NOT NULL COMMENT '回报时间 单位天',  `raffleBase` mediumint(6) NOT NULL COMMENT '每满抽奖规则1的人数',  `raffleReword` varchar(50) NOT NULL COMMENT '抽奖规则1的奖品',  `luckyCount` mediumint(6) NOT NULL COMMENT '每满抽奖规则2的人数',  `luckyReword` varchar(50) NOT NULL COMMENT '抽奖规则2的奖品',  `isSelfless` tinyint(1) NOT NULL COMMENT '是否是无私奉献档位',  `time` int(10) NOT NULL,  `uid` int(11) NOT NULL,  PRIMARY KEY (`repay_id`)) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='产品众筹回报设置表'",'des'=>'...'),

//2016-03-30 13:12:25
array('time'=>mktimes(1970,1,1,20,18),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}zc_product_load` (  `load_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '项目进展id',  `time` int(10) NOT NULL COMMENT '添加时间',  `type` tinyint(1) NOT NULL COMMENT '类型 1为产品众筹',  `content` varchar(500) NOT NULL COMMENT '项目进展内容',  `product_id` int(11) NOT NULL COMMENT '产品id',  PRIMARY KEY (`load_id`)) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='产品众筹 项目进展表'",'des'=>'...'),

//2016-03-30 13:12:09
array('time'=>mktimes(1970,1,1,20,17),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}zc_product_class` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(30) NOT NULL COMMENT '分类名',  `time` varchar(10) NOT NULL,  `sort` smallint(3) NOT NULL COMMENT '排序',  `img` varchar(80) NOT NULL COMMENT '分类图片',  `remark` varchar(200) NOT NULL COMMENT '备注',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-30 13:11:57
array('time'=>mktimes(1970,1,1,20,16),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}zc_product` (  `product_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品id 主键自增',  `uid` int(11) NOT NULL COMMENT '项目发起人uid',  `label` varchar(50) NOT NULL COMMENT '标签',  `productType` tinyint(2) NOT NULL COMMENT '项目类型 1,回报众筹  2,公益捐助众筹',  `productName` varchar(100) NOT NULL COMMENT '项目名称',  `productAdWord` varchar(255) NOT NULL COMMENT '项目一句话介绍',  `amount` int(11) NOT NULL COMMENT '筹资金额',  `toplimit` int(11) NOT NULL COMMENT '筹资上限',  `collectDays` int(11) NOT NULL COMMENT '筹资天数',  `raiseType` tinyint(1) NOT NULL COMMENT '筹资类型',  `productThumImage` varchar(100) NOT NULL COMMENT '产品预热图片',  `productListImg` varchar(100) NOT NULL COMMENT '列表页图片',  `productFirstImg` varchar(100) NOT NULL COMMENT '首页图片',  `productImage` varchar(100) NOT NULL COMMENT '项目图片',  `productImageMobile` varchar(100) NOT NULL COMMENT '移动端图片',  `videoAddr` varchar(100) NOT NULL COMMENT '视频介绍',  `productSummary` varchar(255) NOT NULL COMMENT '项目简介',  `productDetails` text NOT NULL COMMENT '项目详情',  `time` char(10) NOT NULL COMMENT '添加时间',  `praise` int(11) NOT NULL DEFAULT '0' COMMENT '点赞数量',  `status` tinyint(1) NOT NULL COMMENT '项目状态 0 草稿 1申请中 2审核通过预热中 3审核拒绝  4融资中 6融资成功 7融资失败',  `collect` int(11) NOT NULL DEFAULT '0' COMMENT '以募集金额(元)',  `people_number` int(11) DEFAULT '0' COMMENT '总募集人数',  `start_time` char(10) NOT NULL COMMENT '众筹开始时间',  `attention` int(11) NOT NULL COMMENT '关注',  `class` tinyint(2) NOT NULL COMMENT '项目分类',  `classname` varchar(20) NOT NULL COMMENT '分类名',  PRIMARY KEY (`product_id`)) ENGINE=MyISAM AUTO_INCREMENT=222 DEFAULT CHARSET=utf8 COMMENT='众筹产品表'",'des'=>'...'),

//2016-03-30 12:30:48
array('time'=>mktimes(1970,1,1,20,15),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}fx_store_product` (  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录id',  `store_id` int(10) unsigned NOT NULL COMMENT '店铺id',  `product_id` int(10) unsigned NOT NULL COMMENT '商品id',  PRIMARY KEY (`id`),  KEY `store_id` (`store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2016-03-29 15:06:39
array('time'=>mktimes(1970,1,1,20,14),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`key`, `value`, `bak`) VALUES ('withdrawal_service_fee', '0.00', '提现服务费')",'des'=>'...'),

//2016-03-29 15:06:24
array('time'=>mktimes(1970,1,1,20,13),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}credit_setting`ADD COLUMN `promotion_reward_rate`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '默认推广奖励' AFTER `open_promotion_reward`",'des'=>'...'),

//2016-03-29 15:05:59
array('time'=>mktimes(1970,1,1,20,12),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}credit_setting`ADD COLUMN `open_promotion_reward`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否开启推广奖励' AFTER `min_margin_balance`",'des'=>'...'),

//2016-03-29 15:05:27
array('time'=>mktimes(1970,1,1,20,11),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}credit_setting`ADD COLUMN `min_margin_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '保证金最低余额' AFTER `give_point_service_fee`",'des'=>'...'),

//2016-03-29 8:57:12
array('time'=>mktimes(1970,1,1,20,10),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_sku`ADD COLUMN `return_point`  decimal(10,2) NULL DEFAULT 0.00 COMMENT '赠送的平台积分，当购选额外积分时，0或空都表示不送积分' AFTER `price`",'des'=>'...'),

//2016-03-28 16:28:11
array('time'=>mktimes(1970,1,1,20,9),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}package` ADD  `distributor_nums` VARCHAR( 50 ) NOT NULL DEFAULT '0' COMMENT  '店铺发展分销商数量限制' AFTER  `store_nums`",'des'=>'...'),

//2016-03-28 16:27:59
array('time'=>mktimes(1970,1,1,20,8),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}package` ADD  `store_pay_weixin_open` TINYINT( 1 ) UNSIGNED NOT NULL COMMENT  '店铺是否支持独立收款' AFTER  `store_nums`",'des'=>'...'),

//2016-03-28 13:26:05
array('time'=>mktimes(1970,1,1,20,7),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}unitary_order` ADD COLUMN `third_data` text NOT NULL COMMENT '第三方支付返回内容',ADD COLUMN `pay_time` int(11) NOT NULL COMMENT '支付时间',ADD COLUMN `address`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人地址',ADD COLUMN `address_user`  varchar(30) NOT NULL COMMENT '收货人姓名',ADD COLUMN `address_tel`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人电话'",'des'=>'...'),


//2016-03-25 17:43:39
array('time'=>mktimes(1970,1,1,20,6),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}promotion_reward_log` CHANGE  `reward_rate`  `reward_rate` DECIMAL( 10, 3 ) UNSIGNED NOT NULL DEFAULT  '0.00' COMMENT  '奖励比率'",'des'=>'...'),

//2016-03-25 17:13:27
array('time'=>mktimes(1970,1,1,20,5),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `expiration` INT( 11 ) UNSIGNED NOT NULL COMMENT  '店铺到期时间'",'des'=>'...'),

//2016-03-25 17:12:32
array('time'=>mktimes(1970,1,1,20,4),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `is_available` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' COMMENT  '店铺是否有效'",'des'=>'...'),

//2016-03-25 16:30:15
array('time'=>mktimes(1970,1,1,20,3),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan_team` ADD INDEX (`price`)",'des'=>'...'),

//2016-03-25 16:30:00
array('time'=>mktimes(1970,1,1,20,2),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan_team`ADD COLUMN `number`  int(11) NOT NULL DEFAULT 0 COMMENT '团长开团所选团购项的达标数量' AFTER `order_id`,ADD COLUMN `order_number`  int(11) NOT NULL DEFAULT 0 COMMENT '此开团的购买数量' AFTER `number`,ADD COLUMN `price`  float(8,2) NOT NULL DEFAULT 0.00 COMMENT '此开团所选团购项的折扣后价格' AFTER `order_number`",'des'=>'...'),

//2016-03-24 15:48:48
array('time'=>mktimes(1970,1,1,20,1),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`, `is_admin`) VALUES (88, '12', '店铺特权套餐', 'Store', 'package', '0', '1', '1', '0')",'des'=>'...'),

//2016-03-24 14:47:40
array('time'=>mktimes(1970,1,1,20,0),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}rbac_package` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `pid` int(11) NOT NULL COMMENT '套餐ID',  `rbac_val` varchar(500) NOT NULL COMMENT '权限控制',  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',  PRIMARY KEY (`id`),  KEY `pid` (`pid`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,59),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}package` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '套餐id',  `name` varchar(50) NOT NULL COMMENT '套餐名称',  `time` tinyint(3) unsigned NOT NULL COMMENT '套餐有效时间',  `store_nums` varchar(50) NOT NULL COMMENT '开店数量',  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-24 14:47:29
array('time'=>mktimes(1970,1,1,19,58),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD COLUMN `package_id` int(11) unsigned NOT NULL COMMENT '套餐ID'",'des'=>'...'),

//2016-03-24 13:52:37
array('time'=>mktimes(1970,1,1,19,57),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan_home`MODIFY COLUMN `cat_id`  int(11) NULL DEFAULT NULL COMMENT '推荐活动分类id' AFTER `id`,MODIFY COLUMN `sort`  tinyint(3) NULL DEFAULT 0 COMMENT '排序' AFTER `cat_id`,MODIFY COLUMN `last_time`  int(11) NULL DEFAULT NULL COMMENT '上次操作时间' AFTER `sort`,MODIFY COLUMN `tuan_id`  int(11) NULL DEFAULT NULL COMMENT '团购id' AFTER `last_time`,MODIFY COLUMN `product_id`  int(11) NULL DEFAULT NULL COMMENT '商品id' AFTER `tuan_id`,MODIFY COLUMN `status`  tinyint(3) NULL DEFAULT NULL COMMENT '推荐状态 0未推荐1推荐' AFTER `product_id`",'des'=>'...'),

//2016-03-24 11:40:56
array('time'=>mktimes(1970,1,1,19,56),'type'=>'sql','sql'=>"UPDATE `{tableprefix}config` SET `info` = '全网分销' WHERE id=61",'des'=>'...'),

//2016-03-24 11:39:40
array('time'=>mktimes(1970,1,1,19,55),'type'=>'sql','sql'=>"UPDATE `{tableprefix}config` SET `info` = '分销级别',`desc` = '允许分销的最大级别，0或空为无限级分销' WHERE `id` =59",'des'=>'...'),

//2016-03-24 11:31:11
array('time'=>mktimes(1970,1,1,19,54),'type'=>'sql','sql'=>"UPDATE `{tableprefix}config` SET `value` = '-1',`desc` = '限制开店数量，-1为不限制' WHERE `id` =54",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,53),'type'=>'sql','sql'=>"UPDATE `{tableprefix}config` SET `info` = '分销开关' WHERE id=60",'des'=>'...'),

//2016-03-24 9:52:15
array('time'=>mktimes(1970,1,1,19,28),'type'=>'sql','sql'=>"DELETE FROM `{tableprefix}adver_category` WHERE `cat_id` = 14",'des'=>'...'),

//2016-03-23 18:18:48
array('time'=>mktimes(1970,1,1,19,27),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}release_point_log` ADD COLUMN  `point_send_base` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '基数'",'des'=>'...'),

//2016-03-23 9:12:27
array('time'=>mktimes(1970,1,1,19,26),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`MODIFY COLUMN `point2money_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '已提现金额(积分兑换)' AFTER `point2money_service_fee`,ADD COLUMN `point2money_withdrawal`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 AFTER `point2money_balance`",'des'=>'...'),

//2016-03-22 15:23:27
array('time'=>mktimes(1970,1,1,19,25),'type'=>'sql','sql'=>"Insert into {tableprefix}lbs_area(`code`,`name`,`first_spell`,`chinese_spell`,`is_hot`,`is_open`) select `code`,`name`,`first_spell`,`chinese_spell`,0,2 from {tableprefix}area",'des'=>'...'),

//2016-03-21 19:37:25
array('time'=>mktimes(1970,1,1,19,24),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_withdrawal`ADD COLUMN `channel`  tinyint(1) UNSIGNED NOT NULL DEFAULT 渠道 COMMENT '0 收益提现 1 积分兑换提现' AFTER `type`",'des'=>'...'),

//2016-03-21 19:36:45
array('time'=>mktimes(1970,1,1,19,23),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_withdrawal`MODIFY COLUMN `type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT ' 0 分销商提现，1 供货商提现 2 经销商提现 3 积分兑换提现' AFTER `sales_ratio`",'des'=>'...'),

//2016-03-21 19:36:28
array('time'=>mktimes(1970,1,1,19,22),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`MODIFY COLUMN `point2money`  float(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '变现积分可提现余额' AFTER `point_balance`,ADD COLUMN `point2money_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 AFTER `point2money_service_fee`",'des'=>'...'),

//2016-03-21 15:32:54
array('time'=>mktimes(1970,1,1,19,21),'type'=>'sql','sql'=>"update `{tableprefix}system_menu` set name='客户经理(代理商)邀请码' where name = '代理商邀请码'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,20),'type'=>'sql','sql'=>"update `{tableprefix}system_menu` set name='客户经理(代理商)' where name = '代理商'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,19),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin_bonus_config` CHANGE  `foreign_offline`  `foreign_offline` DECIMAL( 6, 3 ) UNSIGNED NOT NULL COMMENT  '海外店铺-线下(%)'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,18),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin_bonus_config` CHANGE  `foreign_online`  `foreign_online` DECIMAL( 6, 3 ) UNSIGNED NOT NULL COMMENT  '海外店铺-线上(%)'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,17),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin_bonus_config` CHANGE  `platform_offline`  `platform_offline` DECIMAL( 6, 3 ) UNSIGNED NOT NULL COMMENT  '平台经营-线下(%)'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,16),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin_bonus_config` CHANGE  `platform_online`  `platform_online` DECIMAL( 6, 3 ) UNSIGNED NOT NULL COMMENT  '平台经营-线上(%)'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,15),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin_bonus_config` CHANGE  `self_offline`  `self_offline` DECIMAL( 6, 3 ) UNSIGNED NOT NULL COMMENT  '自营店铺-线下(%)'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,14),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin_bonus_config` CHANGE  `self_online`  `self_online` DECIMAL( 6, 3 ) UNSIGNED NOT NULL COMMENT  '自营店铺-线上(%)'",'des'=>'...'),

//2016-03-21 14:10:52
array('time'=>mktimes(1970,1,1,19,13),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}order_offline` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `order_no` varchar(50) NOT NULL COMMENT '订单号',  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',  `total` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单总额',  `service_fee` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '服务费',  `cash` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '使用现金数，（平台备付金使用数）',  `point` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '使用平台积分数',  `store_point` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '平台积分，店铺积分使用数',  `store_user_point` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台积分，店铺用户积分使用数',  `cat_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',  `product_name` varchar(255) NOT NULL COMMENT '产品名称，自定义',  `number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品数量',  `return_point` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '返还积分',  `point2money_rate` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分抵现兑换比率',  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态，0：临时状态，1：已发放积分',  `check_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态，0：未审核，1：审核通过，2：审核未通过',  `check_dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '审核时间',  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '审核管理员ID',  `bak` varchar(1024) DEFAULT NULL COMMENT '备注',  `promotion_reward` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '推广奖励',  PRIMARY KEY (`id`),  UNIQUE KEY `order_no` (`order_no`),  KEY `store_id` (`store_id`),  KEY `uid` (`uid`)) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='线下店铺手工做单表'",'des'=>'...'),


//2016-03-18 15:46:45
array('time'=>mktimes(1970,1,1,19,12),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` DROP INDEX `trade_no` ,ADD INDEX `trade_no` (`trade_no`) USING BTREE",'des'=>'...'),

//2016-03-18 19:32:34
array('time'=>mktimes(1970,1,1,19,12),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}promotion_reward_log`ADD COLUMN `order_offline_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '线下做单ID' AFTER `order_id`,ADD INDEX `order_offline_id` (`order_offline_id`)",'des'=>'...'),

//2016-03-18 11:47:43
array('time'=>mktimes(1970,1,1,19,11),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}credit_setting`ADD COLUMN `open_user_give_point`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否开启用户互赠积分' AFTER `recharge_notice_maxcount`,ADD COLUMN `give_point_service_fee`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户互赠积分服务费' AFTER `open_user_give_point`",'des'=>'...'),

//2016-03-18 10:18:45
array('time'=>mktimes(1970,1,1,19,10),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user_point_log`ADD COLUMN `order_offline_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺手工做线下订单ID' AFTER `order_id`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,9),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_point_log`ADD COLUMN `order_offline_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺手工线下订单ID' AFTER `order_id`",'des'=>'...'),

//2016-03-18 10:01:44
array('time'=>mktimes(1970,1,1,19,8),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}platform_margin_log`ADD COLUMN `order_offline_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '线下订单ID' AFTER `order_id`",'des'=>'...'),

//2016-03-18 9:06:48
array('time'=>mktimes(1970,1,1,19,7),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` CHANGE  `platform_credit_points`  `platform_credit_points` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '用户可以获得的发放点数'",'des'=>'...'),

//2016-03-17 17:38:42
array('time'=>mktimes(1970,1,1,19,6),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` CHANGE  `offline_trade_money`  `offline_trade_money` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '线下做单现金积分比（现金）'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,5),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` CHANGE  `online_trade_money`  `online_trade_money` DECIMAL( 5, 2 ) UNSIGNED NOT NULL DEFAULT  '0.00' COMMENT  '线上订单现金积分比（现金）'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,4),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` CHANGE  `storecredit_to_money_charges`  `storecredit_to_money_charges` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '店铺积分变现手续费'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,3),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` CHANGE  `credit_flow_charges`  `credit_flow_charges` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '积分流转手续费'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,2),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` CHANGE  `cash_provisions`  `cash_provisions` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '提现备付金'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,19,1),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` CHANGE  `credit_deposit_ratio`  `credit_deposit_ratio` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '积分保证金扣除比例'",'des'=>'...'),

//2016-03-17 15:29:36
array('time'=>mktimes(1970,1,1,19,0),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}invest_order` ADD COLUMN `address`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人地址', ADD COLUMN `address_user`  varchar(30) NOT NULL COMMENT '收货人姓名', ADD COLUMN `address_tel`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人电话'",'des'=>'...'),

//2016-03-17 15:04:57
array('time'=>mktimes(1970,1,1,18,59),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('131', 'allow_account_pwd_confirm', 'type=radio&value=1:是|0:否', '0', '开启我的账号密码确认', '', '0', '', '1', '0', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,18,58),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('130', 'allow_store_public_display', 'type=radio&value=1:是|0:否', '1', '开启店铺综合展示', '', '0', '', '1', '0', '1')",'des'=>'...'),

//2016-03-17 10:25:54
array('time'=>mktimes(1970,1,1,18,57),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `is_show_recharge_button`  tinyint(1) UNSIGNED NOT NULL COMMENT '商铺是否显示保证金充值按钮 0 不显示（默认） 1显示'",'des'=>'...'),

//2016-03-15 15:31:38
array('time'=>mktimes(1970,1,1,18,56),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_name`, `gid`) VALUES ('129', 'is_need_sub_register', 'type=radio&value=1:开启|0:关闭', '0', '强制pc用户关注后再注册', '开启后，pc注册需要先扫码关注公众号', '', '2')",'des'=>'...'),

//2016-03-15 15:16:00
array('time'=>mktimes(1970,1,1,18,54),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}plat_sub_qrcode` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `ticket` varchar(500) DEFAULT NULL,  `openid` varchar(50) DEFAULT NULL,  `timestamp` int(11) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-14 18:18:17
array('time'=>mktimes(1970,1,1,18,53),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}plat_subscribe`( `id` INT(11) NOT NULL AUTO_INCREMENT, `openid` VARCHAR(50) COMMENT '扫码者oenid', `is_sub` TINYINT(1) DEFAULT 1 COMMENT '是否关注:0不关注，1:关注', `last_time` INT(11) COMMENT '最后操作的时间戳', PRIMARY KEY (`id`) ) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_general_ci",'des'=>'...'),

//2016-03-14 16:41:01
array('time'=>mktimes(1970,1,1,18,51),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}project` ADD COLUMN `project_hits`  int(11) NULL DEFAULT 0 COMMENT '浏览次数'",'des'=>'...'),

//2016-03-14 16:33:44
array('time'=>mktimes(1970,1,1,18,50),'type'=>'sql','sql'=>"ALTER TABLE {tableprefix}store ADD COLUMN `dividends1` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分红' AFTER `drp_profit_withdrawal`",'des'=>'...'),

//2016-03-14 16:28:21
array('time'=>mktimes(1970,1,1,18,49),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}dividends_send_log` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `record_id` int(11) unsigned NOT NULL COMMENT '发放总记录id',  `store_id` int(11) unsigned NOT NULL COMMENT '店铺id',  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商id',  `dividends_type` tinyint(1) unsigned NOT NULL,  `sales` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '累计进货交易额（销售额）',  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '获得的奖金金额',  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',  `add_date` int(8) unsigned NOT NULL COMMENT '添加日期',  PRIMARY KEY (`pigcms_id`),  KEY `record_id` (`record_id`) USING BTREE,  KEY `store_id` (`store_id`) USING BTREE,  KEY `supplier_id` (`supplier_id`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分红发放记录表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,18,48),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}dividends_send` (  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商ID',  `dividends_type` tinyint(1) unsigned NOT NULL COMMENT '奖励对象（1.经销商|2.团队|3.分销商）',  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',  `add_date` int(8) unsigned NOT NULL COMMENT '添加日期',  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',  PRIMARY KEY (`pigcms_id`),  KEY `supplier_id` (`supplier_id`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分红发放主表'",'des'=>'...'),

//2016-03-14 16:21:32
array('time'=>mktimes(1970,1,1,18,47),'type'=>'sql','sql'=>"ALTER TABLE {tableprefix}store ADD COLUMN `last_fh_sendtime_1` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次分红发放时间（对象：经销商）',ADD COLUMN `last_fh_sendtime_2` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次分红发放时间（对象：团队）',ADD COLUMN `last_fh_sendtime_3` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上次分红发放时间（对象：分销商）'",'des'=>'...'),

//2016-03-14 10:40:22
array('time'=>mktimes(1970,1,1,18,46),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user_point_log`ADD COLUMN `point_unbalance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '积分不可用余额' AFTER `point_balance`,ADD COLUMN `point_send_base`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '积分发放基数' AFTER `point_unbalance`",'des'=>'...'),

//2016-03-12 17:20:54
array('time'=>mktimes(1970,1,1,18,45),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}unitary_order` (  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,  `price` int(11) NOT NULL DEFAULT '0' COMMENT '总价',  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `paytype` varchar(50) NOT NULL DEFAULT '' COMMENT '来自于何种支付(英文格式)',  `paid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支付，1代表已支付',  `third_id` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方支付平台的订单ID，用于对帐。',  `orderid` varchar(255) NOT NULL DEFAULT '',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2016-03-12 17:20:44
array('time'=>mktimes(1970,1,1,18,44),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}unitary_lucknum` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '一元夺宝订单id',  `lucknum` int(11) NOT NULL DEFAULT '0',  `addtime` double NOT NULL DEFAULT '0',  `unitary_id` int(11) NOT NULL DEFAULT '0',  `cart_id` int(11) NOT NULL DEFAULT '0' COMMENT '购物id',  `state` int(11) NOT NULL DEFAULT '0',  `paifa` int(11) NOT NULL DEFAULT '0',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2016-03-12 17:20:33
array('time'=>mktimes(1970,1,1,18,43),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}unitary_cart` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `unitary_id` int(11) NOT NULL DEFAULT '0' COMMENT '夺宝活动id',  `count` int(11) NOT NULL DEFAULT '0' COMMENT '数量',  `state` int(11) NOT NULL DEFAULT '0' COMMENT '购买/购物车状态',  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2016-03-12 17:20:25
array('time'=>mktimes(1970,1,1,18,42),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}unitary` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称/微信中图文信息标题',  `logopic` varchar(100) NOT NULL DEFAULT '' COMMENT 'logo图片',  `fistpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片1',  `secondpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片2',  `thirdpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片3',  `fourpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片4',  `fivepic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片5',  `sixpic` varchar(100) NOT NULL DEFAULT '' COMMENT '展示图片6',  `type` int(11) NOT NULL DEFAULT '0' COMMENT '所属店铺组id',  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `opentime` int(11) NOT NULL DEFAULT '0' COMMENT '结束后展示结果倒计时',  `endtime` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',  `state` int(11) NOT NULL DEFAULT '0' COMMENT '活动开关',  `renqi` int(11) NOT NULL DEFAULT '0' COMMENT '人气',  `lucknum` int(11) NOT NULL DEFAULT '0' COMMENT '幸运数字',  `proportion` double NOT NULL DEFAULT '0',  `lasttime` int(11) NOT NULL DEFAULT '0',  `lastnum` int(11) NOT NULL DEFAULT '0',  `price` int(11) NOT NULL DEFAULT '0' COMMENT '价格',  `store_id` int(11) DEFAULT '0' COMMENT '所属店铺',  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联产品id',  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格id，无则为空',  `item_price` int(11) NOT NULL DEFAULT '0' COMMENT '夺宝价格',  `total_num` int(11) NOT NULL DEFAULT '0' COMMENT '总共需要购买份数',  `descript` varchar(100) NOT NULL DEFAULT '' COMMENT '夺宝说明',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2016-03-11 11:13:25
array('time'=>mktimes(1970,1,1,18,41),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('128', 'open_test_payment', 'type=radio&value=1:开启|0:禁用', '0', '测试支付', '慎用，不建议在运营或正式环境开启，仅用于内部测试。', 'test_pay', '平台测试支付', '7', '0', '1')",'des'=>'...'),

//2016-03-11 9:28:43
array('time'=>mktimes(1970,1,1,18,40),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`pigcms_id`, `key`, `value`, `bak`) VALUES ('16', 'trade_net_income', '0.00', '交易纯收入（不含备付金和推广奖励）')",'des'=>'...'),

//2016-03-10 17:47:18
array('time'=>mktimes(1970,1,1,18,39),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}adver` ADD  `store_id` INT( 10 ) NOT NULL DEFAULT  '0' AFTER  `id`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,18,38),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}adver` CHANGE  `pic`  `pic` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",'des'=>'...'),
array('time'=>mktimes(1970,1,1,18,37),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}adver_category` ( `cat_id`, `cat_name`, `cat_key` ) VALUES ( '14', 'pc-店铺首页横幅', 'pc_store_index' )",'des'=>'...'),

//2016-03-10 16:37:46
array('time'=>mktimes(1970,1,1,18,36),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `cash_point`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺抵现积分(线下做单)' AFTER `point2user`",'des'=>'...'),

//2016-03-10 16:16:21
array('time'=>mktimes(1970,1,1,18,35),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}bargain` ADD  `store_id` INT( 10 ) NOT NULL AFTER  `pigcms_id`",'des'=>'...'),

//2016-03-10 14:54:02
array('time'=>mktimes(1970,1,1,18,34),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user`ADD COLUMN `point_given`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '已赠送积分' AFTER `invite_admin`,ADD COLUMN `point_received`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '已获赠积分' AFTER `point_given`",'des'=>'...'),

//2016-03-10 10:39:25
array('time'=>mktimes(1970,1,1,18,33),'type'=>'sql','sql'=>"alter table `{tableprefix}user_point_log` add column `add_date` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期 格式：19700101' after `add_time`",'des'=>'...'),

//2016-03-10 8:56:11
array('time'=>mktimes(1970,1,1,18,32),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}bargain_kanuser` ADD  `name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci AFTER  `orderid`",'des'=>'...'),

//2016-03-08 18:02:40
array('time'=>mktimes(1970,1,1,18,31),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}cash_provision_log` ADD  `order_no` VARCHAR( 50 ) NOT NULL DEFAULT  '' COMMENT  '订单号' AFTER  `pigcms_id` ,ADD  `store_id` INT( 11 ) UNSIGNED NOT NULL COMMENT  '店铺id' AFTER  `order_no` ,ADD INDEX (  `order_no` ,  `store_id` )",'des'=>'...'),

//2016-03-08 16:04:08
array('time'=>mktimes(1970,1,1,18,30),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}release_point`  ADD COLUMN `cash_provision_balance_before` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实时平台备付金(扣除前)' AFTER `users`,ADD COLUMN `cash_provision_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实时平台备付金' AFTER `cash_provision_balance_before`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,18,29),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}cash_provision_log`  ADD COLUMN `add_date` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期' AFTER `add_time`",'des'=>'...'),

//2016-03-07 13:12:47
array('time'=>mktimes(1970,1,1,18,28),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`pigcms_id`, `key`, `value`, `bak`) VALUES ('margin_used', '0', '已扣除保证金')",'des'=>'...'),

//2016-03-07 11:58:16
array('time'=>mktimes(1970,1,1,18,27),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `last_recharge_notice_date`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '保证金充值最后通知时间' AFTER `last_time_statistics`,ADD COLUMN `recharge_notice_count`  tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '保证金充值每日最大通知次数' AFTER `last_recharge_notice_date`",'des'=>'...'),

//2016-03-07 10:55:48
array('time'=>mktimes(1970,1,1,18,26),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}credit_setting`ADD COLUMN `recharge_notice_open`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '保证金余额不足通知' AFTER `recommend_follow_self_credit`,ADD COLUMN `recharge_notice_maxcount`  tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '单日最大通知次数' AFTER `recharge_notice_open`",'des'=>'...'),

//2016-03-05 9:37:11
array('time'=>mktimes(1970,1,1,17,59),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}news` (  `news_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新闻id',  `news_title` varchar(500) NOT NULL COMMENT '新闻标题',  `pic` varchar(255) DEFAULT NULL COMMENT '新闻图片',  `news_content` text NOT NULL COMMENT '新闻内容',  `cat_id` int(11) NOT NULL COMMENT '分类id',  `state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态 1为显示 0为不显示',  `add_time` int(11) NOT NULL COMMENT '添加时间',  `uid` int(11) NOT NULL COMMENT '添加人id',  `hits` int(11) DEFAULT NULL COMMENT '查看次数',  `abstract` varchar(255) DEFAULT NULL COMMENT '摘要',  PRIMARY KEY (`news_id`)) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='新闻表'",'des'=>'...'),

//2016-03-05 9:36:53
array('time'=>mktimes(1970,1,1,17,57),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}invest_slide` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `class` tinyint(1) NOT NULL COMMENT '幻灯片分类',  `time` int(10) NOT NULL,  `name` varchar(200) NOT NULL COMMENT '幻灯片名称',  `url` varchar(200) NOT NULL,  `link` varchar(200) NOT NULL COMMENT '图片链接地址',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-05 9:36:42
array('time'=>mktimes(1970,1,1,17,55),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}invest_question` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `class` tinyint(1) NOT NULL COMMENT '分类',  `question_name` varchar(255) NOT NULL,  `question_answer` text NOT NULL COMMENT '常见问题答案',  `sort` int(11) NOT NULL COMMENT '排序',  `time` int(10) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-05 9:36:31
array('time'=>mktimes(1970,1,1,17,53),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}user_apply_invest` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL,  `name` varchar(50) NOT NULL COMMENT '真实姓名',  `phone` varchar(11) NOT NULL,  `isforeign` tinyint(1) NOT NULL COMMENT '是否外籍',  `card_img` varchar(255) NOT NULL COMMENT '名片',  `iscompany` tinyint(1) NOT NULL COMMENT '是否是企业',  `person_type` tinyint(1) NOT NULL COMMENT '自然人条件类型',  `company_name` varchar(200) NOT NULL COMMENT '公司名称',  `job_grade` varchar(50) NOT NULL COMMENT '职位头衔',  `description` text NOT NULL COMMENT '自我描述',  `iscommit` tinyint(1) NOT NULL COMMENT '是否承诺',  `time` int(10) NOT NULL COMMENT '申请成为投资人时间',  `status` smallint(2) NOT NULL COMMENT '投资人审核状态',  `email` varchar(50) NOT NULL,  `weixin` varchar(50) NOT NULL COMMENT '微信号',  `province` varchar(12) NOT NULL COMMENT '省份',  `city` varchar(50) NOT NULL COMMENT '城市',  `company_type` smallint(2) NOT NULL COMMENT '公司类型',  `education_back` tinyint(1) NOT NULL COMMENT '教育背景',  `work_experience` text NOT NULL COMMENT '教育经历',  `business_prefer` varchar(20) NOT NULL COMMENT '行业偏好',  `stage_prefer` varchar(20) NOT NULL COMMENT '阶段偏好',  `investment_time` int(4) NOT NULL,  `investment_num` tinyint(1) NOT NULL COMMENT '投资项目数',  `investment_name` varchar(240) NOT NULL COMMENT '已投资项目名称',  `next_num` smallint(2) NOT NULL COMMENT '项目已到下轮',  `out_num` smallint(2) NOT NULL COMMENT '成功退出项目',  `suncess_name` varchar(255) NOT NULL COMMENT '成功项目名称',  `suncess_intro` text NOT NULL COMMENT '成功案例简介',  `isinteraction` tinyint(1) NOT NULL COMMENT '与跟投方互动',  `leader_status` smallint(2) NOT NULL COMMENT '申请领投人状态',  `apply_leader_time` int(10) NOT NULL COMMENT '申请领投人时间',  `beilv` int(11) NOT NULL COMMENT '倍率',  PRIMARY KEY (`id`),  KEY `id,uid` (`uid`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=198 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-05 9:36:18
array('time'=>mktimes(1970,1,1,17,52),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}project_team` (  `team_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '团队成员id',  `project_id` int(11) NOT NULL COMMENT '项目id',  `teamImg` varchar(255) NOT NULL COMMENT '成员头像',  `teamName` varchar(50) NOT NULL COMMENT '名称',  `teamTitle` varchar(100) NOT NULL COMMENT '职位',  `teamIntroduce` varchar(500) NOT NULL COMMENT '介绍',  PRIMARY KEY (`team_id`)) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='众筹项目团队成员表'",'des'=>'...'),

//2016-03-05 9:36:09
array('time'=>mktimes(1970,1,1,17,51),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}project_praise` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `project_id` int(11) NOT NULL,  `uid` int(11) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='项目点赞表'",'des'=>'...'),

//2016-03-05 9:36:00
array('time'=>mktimes(1970,1,1,17,50),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}project_notice` (  `n_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关注id主键自增',  `project_id` int(11) NOT NULL COMMENT '项目id',  `content` varchar(500) NOT NULL COMMENT '内容',  `contentImg` varchar(255) NOT NULL COMMENT '内容图片',  `addTime` int(11) NOT NULL COMMENT '添加时间',  PRIMARY KEY (`n_id`),  KEY `project_id` (`project_id`)) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='项目公告表'",'des'=>'...'),

//2016-03-05 9:35:49
array('time'=>mktimes(1970,1,1,17,49),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}project_attention` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关注id主键自增',  `project_id` int(11) NOT NULL COMMENT '关注项目id',  `uid` int(11) NOT NULL COMMENT '用户id',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='项目关注表'",'des'=>'...'),

//2016-03-05 9:35:33
array('time'=>mktimes(1970,1,1,17,48),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}project` (  `project_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '项目id主键自增',  `realName` varchar(50) NOT NULL COMMENT '联系人',  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',  `email` varchar(100) DEFAULT NULL COMMENT '联系邮箱',  `sponsorWeixin` varchar(50) DEFAULT NULL COMMENT '微信号',  `type` tinyint(2) DEFAULT NULL COMMENT '1个人，2企业',  `projectName` varchar(255) DEFAULT NULL COMMENT '项目名称',  `projectSubtitle` varchar(500) DEFAULT NULL COMMENT '一句话介绍',  `label` varchar(20) DEFAULT NULL COMMENT '标签',  `projectProvince` varchar(50) DEFAULT NULL COMMENT '所在省',  `ckFlag` tinyint(2) DEFAULT NULL COMMENT '是否需要领投 1是 2否',  `companyCreatetime` varchar(30) DEFAULT NULL COMMENT '成立时间',  `foundingNum` tinyint(2) DEFAULT NULL COMMENT '创始人人数 1：1人、2：2人、3：3人、4：4人、5：5人、6：6人、7：7人以上',  `projectTeamcount` tinyint(2) DEFAULT NULL COMMENT '员工数量 1：0-50、2：50-100、3：100-150、4：150-200、5：200以上',  `projectStage` tinyint(2) DEFAULT NULL COMMENT '项目阶段 1概念阶段、2研发中、3产品已发布、4产品已盈利、5其他',  `financingRoundsNumber` tinyint(2) DEFAULT NULL COMMENT '本轮融资轮数 1:种子期2：天使期、3：Pre-A轮、4：A轮、5：B轮、6：C轮、7：D轮、8：并购',  `companyRevenue` tinyint(2) DEFAULT NULL COMMENT '年收入情况 1：100万一下、2：100-500万、3：500-1000万、4：1000-2000万、5：2000-5000万、6：5000-1亿、7： 一亿以上',  `operatingData` varchar(500) DEFAULT NULL COMMENT '运营数据',  `listImg` varchar(255) DEFAULT NULL COMMENT '列表页图片',  `projectDetails` varchar(5000) DEFAULT NULL COMMENT '项目详情',  `pastFinancing` tinyint(2) DEFAULT '0' COMMENT '过往融资次数 0.无、1.1、2.2、3.3、4.4、5.5、6.6次以上',  `pastAmount` tinyint(2) DEFAULT '0' COMMENT '过往融资金额 0：无、1：100-500万、2：500-1000万、3：1000-2000万、4：2000-5000万、5：5000-1亿、6：一亿以上',  `valuation` int(11) DEFAULT NULL COMMENT '投资估值   万元',  `amount` int(11) DEFAULT NULL COMMENT '此次融资金额 万元',  `sellShares` decimal(4,2) DEFAULT NULL COMMENT '此次出让股份',  `prospectusUrl` varchar(255) DEFAULT NULL COMMENT '融资计划书URL',  `status` tinyint(2) DEFAULT NULL COMMENT '状态   0.初审待审核 1.审核成功 路演中 2.审核失败 3.融资中 4.融资成功 5.融资失败',  `uid` int(11) DEFAULT NULL COMMENT '添加用户的id',  `projectCity` varchar(255) DEFAULT NULL COMMENT '城市',  `addTime` int(11) DEFAULT NULL COMMENT '添加时间',  `endTime` int(11) DEFAULT NULL COMMENT '结束时间',  `collect` int(11) DEFAULT '0' COMMENT '以募集',  `attention` int(11) DEFAULT '0' COMMENT '关注数',  `praise` int(11) DEFAULT '0' COMMENT '点赞数量',  `is_recommend` tinyint(2) DEFAULT '0' COMMENT '是否推荐',  `recommend_order` int(11) DEFAULT '0' COMMENT '推荐排序',  `is_release` tinyint(2) DEFAULT '0' COMMENT '是否发布 0为不发布 1为发布',  `invest_number` int(11) DEFAULT '0' COMMENT '投资人数',  `leader_uid` int(11) NOT NULL COMMENT '领头人UID',  `leader_name` varchar(200) NOT NULL COMMENT '领投人姓名',  `financing` varchar(2000) DEFAULT NULL COMMENT '融资资料',  `isShow` tinyint(2) DEFAULT '0' COMMENT '是否展示',  `maxShareholder` int(11) DEFAULT '0' COMMENT '大东家数量',  `maxShareholderMoney` int(11) DEFAULT '0' COMMENT '大东家起投金额',  `minShareholder` int(11) DEFAULT '0' COMMENT '小东家数量',  `minShareholderMoney` int(11) DEFAULT '0' COMMENT '小东家起投金额',  `hopeword` text NOT NULL COMMENT '领投人寄语',  PRIMARY KEY (`project_id`)) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COMMENT='众筹项目表'",'des'=>'...'),

//2016-03-05 9:35:08
array('time'=>mktimes(1970,1,1,17,47),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}news_category` (  `cat_id` int(11) NOT NULL AUTO_INCREMENT,  `cat_name` varchar(100) NOT NULL COMMENT '新闻分类 名称',  `cat_key` varchar(15) NOT NULL COMMENT '新闻模块key',  `cat_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '类型 默认为0',  `cat_state` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态 1为正常 0为不正常',  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',  `desc` varchar(50) NOT NULL COMMENT '分类描述',  `icon` varchar(200) NOT NULL COMMENT '图标',  PRIMARY KEY (`cat_id`)) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-05 9:34:56
array('time'=>mktimes(1970,1,1,17,46),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}invest_order` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',  `project_id` int(11) NOT NULL COMMENT '项目id',  `zcpay_no` varchar(100) DEFAULT NULL COMMENT '众筹微信支付订单号，格式：ZCPAY_生成另外订单号',  `intention_amount` decimal(10,2) NOT NULL COMMENT '意向金',  `margin_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金',  `time` int(10) NOT NULL,  `uid` int(11) NOT NULL,  `type` tinyint(1) NOT NULL COMMENT '订单类型1小东家订单，2大东家订单',  `status` tinyint(1) NOT NULL COMMENT '订单状态，1为未支付，2为已支付',  `pay_openid` varchar(50) DEFAULT NULL COMMENT '支付人openid',  `third_id` varchar(100) NOT NULL COMMENT '第三方支付ID',  `third_data` text NOT NULL COMMENT '第三方支付返回内容',  `pay_time` int(11) NOT NULL COMMENT '支付时间',  `trade_no` varchar(100) NOT NULL COMMENT '交易流水号',  `invest_state` tinyint(2) DEFAULT '0' COMMENT '投资人状态 0为正常投资人 1为候选投资人',  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-05 9:33:51
array('time'=>mktimes(1970,1,1,17,45),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}invest_config` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `key` varchar(100) NOT NULL,  `value` varchar(100) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-04 10:42:18
array('time'=>mktimes(1970,1,1,17,44),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan_team`ADD COLUMN `real_item_id`  int(11) NOT NULL DEFAULT 0 COMMENT '开团实际达标等级' AFTER `item_id`",'des'=>'...'),

//2016-03-03 16:27:23
array('time'=>mktimes(1970,1,1,17,43),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}wei_page` ADD COLUMN `type` TINYINT(1) DEFAULT 0 NULL COMMENT '特殊微页面分类：1:团购,2:一元夺宝' AFTER `show_footer`",'des'=>'...'),

//2016-03-03 11:35:30
array('time'=>mktimes(1970,1,1,17,42),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan_team`ADD COLUMN `pay_status`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '开团是否成功，判断标准为是否支付，0：不成功，1：成功' AFTER `status`,ADD COLUMN `order_id`  int(11) NOT NULL DEFAULT 0 COMMENT '团长开团的订单ID' AFTER `pay_status`,ADD INDEX (`order_id`)",'des'=>'...'),

//2016-03-03 9:21:52
array('time'=>mktimes(1970,1,1,17,41),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan_team`ADD COLUMN `status`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '拼团状态，0：进行中，1：成功，2：失败' AFTER `item_id`",'des'=>'...'),

//2016-03-02 20:04:02
array('time'=>mktimes(1970,1,1,17,40),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product`ADD COLUMN `subscribed_discount`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '关注后的折扣' AFTER `data_id`",'des'=>'...'),

//2016-03-02 17:12:32
array('time'=>mktimes(1970,1,1,17,32),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}ucenter` ADD  `store_banner_field` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER  `consumption_field`",'des'=>'...'),

//2016-03-02 17:11:54
array('time'=>mktimes(1970,1,1,17,30),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}ucenter` ADD  `class_content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER  `member_content`",'des'=>'...'),

//2016-03-02 16:22:11
array('time'=>mktimes(1970,1,1,17,27),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}tuan_team` (  `team_id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `tuan_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购ID',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID，开团人UID',  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '团购类型，0：人缘团，1：最优团',  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT '团购项',  PRIMARY KEY (`team_id`),  KEY `tuan_id` (`tuan_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-02 13:33:12
array('time'=>mktimes(1970,1,1,17,25),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan`ADD COLUMN `count`  int(11) NOT NULL DEFAULT 0 COMMENT '开团次数,有多少团长' AFTER `status`",'des'=>'...'),

//2016-03-02 11:33:03
array('time'=>mktimes(1970,1,1,17,23),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}presale` ADD COLUMN `buy_count` INT(11) DEFAULT 0 NULL COMMENT '购买预售的商品的数量' AFTER `buyer_count`",'des'=>'...'),

//2016-03-02 9:04:32
array('time'=>mktimes(1970,1,1,17,21),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}platform_user_points_log` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `user_id` int(11) unsigned NOT NULL COMMENT '会员id',  `store_id` int(11) DEFAULT '0' COMMENT '被操作的店铺id',  `order_id` int(11) DEFAULT '0',  `point` int(11) unsigned NOT NULL COMMENT '新增积分点数',  `point_type` tinyint(1) NOT NULL COMMENT '1 首次关注公众号（送） 2 分享链接达到点击数（送） 3 兑换礼物（消耗）',  `add_time` int(11) NOT NULL,  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-03-01 09:03:37
array('time'=>mktimes(1970,1,1,17,19),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD COLUMN `spend_point_gift` DECIMAL(10,2) DEFAULT 0.00 NULL COMMENT '消耗的平台积分' AFTER `point_gift`",'des'=>'...'),

//2016-03-01 17:27:10
array('time'=>mktimes(1970,1,1,17,17),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`key`, `value`, `bak`) VALUES ('cash_provision_balance', '5.00', '平台提现备付金余额')",'des'=>'...'),

//2016-03-01 17:26:28
array('time'=>mktimes(1970,1,1,17,15),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}cash_provision_log` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作金额',  `point` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '返还/发放的积分',  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 交易完成平台添加备付金 1 积分发放扣除备付金',  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `cash_provision_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '平台备付金余额',  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='平台提现备付金流水'",'des'=>'...'),

//2016-02-29 19:06:43
array('time'=>mktimes(1970,1,1,17,13),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `point2user`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺积分转用户积分' AFTER `point2money_service_fee`",'des'=>'...'),

//2016-02-29 19:06:29
array('time'=>mktimes(1970,1,1,17,12),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}clear_return_owe_log` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '经销商id',  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '销账金额',  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '销账记录类型 0 退货欠款 ',  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`pigcms_id`),  KEY `store_id` (`store_id`,`supplier_id`) USING BTREE,  KEY `add_time` (`add_time`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='退货欠款记录'",'des'=>'...'),

//2016-02-29 19:06:07
array('time'=>mktimes(1970,1,1,17,11),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}supp_dis_relation`ADD COLUMN `clear_return_owe`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '已销账退货欠款' AFTER `return_owe`",'des'=>'...'),

//2016-02-29 15:37:40
array('time'=>mktimes(1970,1,1,17,10),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD `is_show_float_menu` TINYINT UNSIGNED NOT NULL COMMENT '是否显示浮动菜单'",'des'=>'...'),

//2016-02-29 10:48:10
array('time'=>mktimes(1970,1,1,17,9),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}subject_product` ADD COLUMN `sort` INT(11) DEFAULT 0 NULL COMMENT '排序' AFTER `store_id`",'des'=>'...'),

//2016-02-27 19:13:33
array('time'=>mktimes(1970,1,1,17,7),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}sms_by_code` ADD COLUMN `last_ip` BIGINT(20) NULL COMMENT '最后的ip' AFTER `timestamp`",'des'=>'...'),

//2016-02-27 18:56:20
array('time'=>mktimes(1970,1,1,17,5),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}sms_record` ADD COLUMN `last_ip` BIGINT(20) NULL COMMENT '最后登录的ip' AFTER `time`",'des'=>'...'),

//2016-02-27 14:12:29
array('time'=>mktimes(1970,1,1,17,3),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}bargain_kanuser` CHANGE  `wecha_id`  `wecha_id` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",'des'=>'...'),

//2016-02-27 11:17:14
array('time'=>mktimes(1970,1,1,17,2),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}presale` ADD COLUMN `pre_buyer_count` INT(11) DEFAULT 0 NULL COMMENT '真实支付预付款人数' AFTER `presale_person`, CHANGE `buyer_count` `buyer_count` INT(11) DEFAULT 0 NULL COMMENT '真实支付尾款人数'",'des'=>'...'),

//2016-02-26 18:54:15
array('time'=>mktimes(1970,1,1,17,1),'type'=>'sql','sql'=>"CREATE TABLE `pigcms_bargain_kanuser` ( `pigcms_id` INT (11) NOT NULL AUTO_INCREMENT, `token` VARCHAR (100) NOT NULL, `wecha_id` VARCHAR (100) NOT NULL, `bargain_id` INT (11) NOT NULL, `orderid` VARCHAR (30) NOT NULL, `friend` VARCHAR (100) NOT NULL, `dao` INT (20) NOT NULL, `addtime` INT (11) NOT NULL, PRIMARY KEY (`pigcms_id`), KEY `token` (`token`), KEY `wecha_id` (`wecha_id`), KEY `bargain_id` (`bargain_id`), KEY `orderid` (`orderid`), KEY `friend` (`friend`)) ENGINE = MyISAM DEFAULT CHARSET = utf8",'des'=>'...'),
array('time'=>mktimes(1970,1,1,17,0),'type'=>'sql','sql'=>"CREATE TABLE `pigcms_bargain` ( `pigcms_id` INT (100) NOT NULL AUTO_INCREMENT, `token` VARCHAR (100) NOT NULL, `name` VARCHAR (100) NOT NULL COMMENT '商品名称', `keyword` VARCHAR (100) NOT NULL COMMENT '关键词', `wxtitle` VARCHAR (100) NOT NULL COMMENT '图文回复标题', `wxpic` VARCHAR (100) NOT NULL COMMENT '图文回复图片', `wxinfo` VARCHAR (200) DEFAULT NULL COMMENT '图文回复简单描述', `logoimg1` VARCHAR (100) NOT NULL COMMENT '商品图片1', `logourl1` VARCHAR (200) DEFAULT NULL COMMENT '商品图片链接1', `logoimg2` VARCHAR (100) DEFAULT NULL COMMENT '商品图片2', `logourl2` VARCHAR (200) DEFAULT NULL COMMENT '商品图片链接2', `logoimg3` VARCHAR (100) DEFAULT NULL COMMENT '商品图片3', `logourl3` VARCHAR (200) DEFAULT NULL COMMENT '商品图片链接3', `info` MEDIUMTEXT COMMENT '商品描述', `guize` MEDIUMTEXT, `original` INT (20) NOT NULL COMMENT '原价', `minimum` INT (20) NOT NULL COMMENT '底价', `starttime` INT (20) NOT NULL COMMENT '开始时间', `inventory` INT (20) NOT NULL COMMENT '库存', `qdao` INT (11) DEFAULT NULL COMMENT '前n刀', `qprice` INT (20) DEFAULT NULL COMMENT '前n刀砍去多少钱', `dao` INT (11) DEFAULT NULL COMMENT '总共需要n刀', `pv` INT (11) NOT NULL DEFAULT '0', `state` INT (11) NOT NULL DEFAULT '1' COMMENT '开始-关闭', `addtime` INT (11) NOT NULL COMMENT '添加时间', `is_new` INT (11) NOT NULL DEFAULT '1', `kan_min` INT (20) NOT NULL DEFAULT '0', `kan_max` INT (20) NOT NULL DEFAULT '0', `rank_num` INT (11) NOT NULL DEFAULT '10', `logotitle1` VARCHAR (50) DEFAULT NULL, `logotitle2` VARCHAR (50) DEFAULT NULL, `logotitle3` VARCHAR (50) DEFAULT NULL, `is_attention` INT (10) UNSIGNED NOT NULL DEFAULT '1', `is_reg` INT (10) UNSIGNED NOT NULL DEFAULT '1', `is_subhelp` INT (10) UNSIGNED NOT NULL DEFAULT '1', `product_id` INT (10) UNSIGNED NOT NULL DEFAULT '0', `sku_id` INT (10) UNSIGNED NOT NULL DEFAULT '0', `delete_flag` TINYINT (3) DEFAULT '0', PRIMARY KEY (`pigcms_id`), KEY `token` (`token`), KEY `name` (`name`), KEY `state` (`state`)) ENGINE = MyISAM DEFAULT CHARSET = utf8",'des'=>'...'),


//2016-03-09 13:17:27
array('time'=>mktimes(1970,1,1,16,42),'type'=>'sql','sql'=>"UPDATE `{tableprefix}system_menu` SET `module` = 'Order' WHERE `id` =38",'des'=>'...'),

//2016-03-08 11:59:23
array('time'=>mktimes(1970,1,1,16,41),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('127', 'is_allow_diy_drp_degree', 'type=radio&value=1:开启|0:关闭', '1', '店铺自定义分销等级', '是否允许供货商自定义分销等级，修改平台设置的默认等级名称，图标', '0', '', '12', '0', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,16,40),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('126', 'open_platform_drp', 'type=radio&value=1:开启|0:关闭', '1', '全网批发', '', '0', '', '12', '0', '1')",'des'=>'...'),

//2016-02-26 16:36:47
array('time'=>mktimes(1970,1,1,16,39),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('125', 'is_show_float_menu', 'type=radio&value=1:开启|0:关闭', '0', '是否显示浮动菜单', '开启后，wap店铺首页和商品详情页右下角将会显示浮动菜单', '0', '', '11', '0', '0')",'des'=>'...'),

//2016-02-26 17:05:11
array('time'=>mktimes(1970,1,1,16,38),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}dividends_send_rules` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商id',  `type` tinyint(1) unsigned NOT NULL COMMENT '发放类型',PRIMARY KEY (`pigcms_id`),  UNIQUE KEY `supplier_id` (`supplier_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-02-26 17:05:00
array('time'=>mktimes(1970,1,1,16,37),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}dividends_rules` (  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `supplier_id` int(11) unsigned NOT NULL COMMENT '供货商id',  `dividends_type` tinyint(1) unsigned NOT NULL COMMENT '奖励对象（1.经销商|2.团队|3.分销商）',  `rule_type` tinyint(1) unsigned NOT NULL COMMENT '规则',  `is_bind` tinyint(1) unsigned NOT NULL COMMENT '是否绑定规则3',  `month` tinyint(2) unsigned NOT NULL COMMENT '规则定义的月份',  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '规则定义的金额',  `rule3_month` tinyint(2) unsigned NOT NULL COMMENT '规则3:月份',  `rule3_seller_1` int(10) unsigned NOT NULL COMMENT '规则3：发展下一级分销商的个数',  `rule3_seller_2` int(10) unsigned NOT NULL COMMENT '规则3：发展下二级分销商的个数',  `percentage` tinyint(3) unsigned NOT NULL COMMENT '周期内累计交易额的比例',  `fixed_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额(固定值)',  `percentage_or_fix` tinyint(1) unsigned NOT NULL COMMENT '是否按照固定值发放(1比例2固定值)',  `upper_limit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '分红上限',  `is_limit` tinyint(1) unsigned NOT NULL COMMENT '是否按照设置的上限发放',  `team_owner_percentage` tinyint(3) unsigned NOT NULL COMMENT '团队所属者获得的奖金比',  `is_team_dividend` tinyint(1) unsigned NOT NULL COMMENT '是否按照指定比例进行团队分红',  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',  PRIMARY KEY (`pigcms_id`),  KEY `supplier_id` (`supplier_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='奖金分红规则表'",'des'=>'...'),

//2016-02-26 9:36:47
array('time'=>mktimes(1970,1,1,16,36),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}presale` ADD COLUMN `product_quantity` INT(11) DEFAULT 0 NULL COMMENT '商品原总库存(不同规格综合)' AFTER `price`",'des'=>'...'),

//2016-02-25 10:51:18
array('time'=>mktimes(1970,1,1,16,35),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}credit_setting`ADD COLUMN `offline_trade_store_type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '线下店铺做单赠送积分基数' AFTER `offline_trade_credit_type`",'des'=>'...'),

//2016-02-25 9:32:24
array('time'=>mktimes(1970,1,1,16,34),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}presale` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(200) DEFAULT NULL COMMENT '预售名称',  `product_id` int(11) DEFAULT NULL COMMENT '预售产品id',  `uid` int(11) DEFAULT NULL COMMENT '操作的用户uid',  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',  `dingjin` double(10,2) DEFAULT '0.00' COMMENT '定金',  `price` double(10,2) DEFAULT '0.00' COMMENT '商品原价',  `product_count` int(11) DEFAULT '0' COMMENT '商品总库存',  `privileged_cash` double(10,2) DEFAULT '0.00' COMMENT '特权_减多少现金',  `privileged_coupon` int(11) DEFAULT '0' COMMENT '特权_赠送券id',  `privileged_present` int(11) DEFAULT '0' COMMENT '特权_赠品id',  `presale_person` int(11) DEFAULT '0' COMMENT '预售人数',  `buyer_count` int(11) DEFAULT '0' COMMENT '购买人数',  `starttime` int(11) DEFAULT NULL COMMENT '开始时间',  `endtime` int(11) DEFAULT NULL COMMENT '结束时间',  `final_paytime` int(11) DEFAULT NULL COMMENT '尾款支付截止时间',  `presale_amount` int(11) DEFAULT NULL COMMENT '预售数量限制',  `description` text COMMENT '预售说明',  `timestamp` int(11) DEFAULT NULL COMMENT '操作时间戳',  `is_open` tinyint(1) DEFAULT '1' COMMENT '是否开启:0未开启，1:开启中',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-02-25 9:28:52
array('time'=>mktimes(1970,1,1,16,33),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}platform_share_log` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `user_id` int(11) unsigned NOT NULL COMMENT '分享连接的用户id',  `share_num` int(11) unsigned NOT NULL COMMENT '被分享的次数',  `share_ip` text NOT NULL COMMENT '点击者的ip',  `share_time` int(11) unsigned NOT NULL,  `update_time` int(11) NOT NULL,  `share_num_count` int(11) unsigned NOT NULL COMMENT '分享总点击数',  PRIMARY KEY (`pigcms_id`)) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-02-24 17:27:26
array('time'=>mktimes(1970,1,1,16,29),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `point2money_service_fee`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '积分变现服务费总额' AFTER `point2money`",'des'=>'...'),

//2016-02-24 17:06:46
array('time'=>mktimes(1970,1,1,16,28),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`, `is_admin`) VALUES ('87', '1', '我的奖金', 'Order', 'myPromotionRecord', '0', '1', '1', '0')",'des'=>'...'),

//2016-02-24 15:53:16
array('time'=>mktimes(1970,1,1,16,27),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`, `is_admin`) VALUES ('86', '4', '奖金流水记录', 'Order', 'promotionRecord', '0', '1', '1', '0')",'des'=>'...'),

//2016-02-24 15:29:54
array('time'=>mktimes(1970,1,1,16,26),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}promotion_reward_log` ADD COLUMN  `send_type` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '发放奖金方式：1银行转账 2微信 3支付宝 默认0 其他',ADD COLUMN  `send_aid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '发送者admin_id'",'des'=>'...'),

//2016-02-24 14:30:39
array('time'=>mktimes(1970,1,1,16,25),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan`ADD COLUMN `start_price`  float(8,2) NOT NULL DEFAULT 0.00 COMMENT '团购起步价' AFTER `product_id`",'des'=>'...'),

//2016-02-24 13:52:55
array('time'=>mktimes(1970,1,1,16,24),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin` ADD COLUMN `group_id` INT NOT NULL DEFAULT  '0' COMMENT  '所属权限组id',ADD COLUMN `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '后台管理类别: 0超级管理员 1普通管理员 2区域管理 3代理商',ADD COLUMN `creator` INT NOT NULL DEFAULT '0' COMMENT  '创建者uid',ADD COLUMN `province` varchar(30) NOT NULL DEFAULT '' COMMENT  '省份',ADD COLUMN `city` varchar(30) NOT NULL DEFAULT '' COMMENT  '市区',ADD COLUMN `county` varchar(30) NOT NULL DEFAULT '' COMMENT  '区县',ADD COLUMN `area_level` tinyint(2) NOT NULL DEFAULT 0 COMMENT  '区域等级：0非区域管理 1省级 2市级 3区县级',ADD COLUMN `agent_code` varchar(100) NOT NULL DEFAULT '' COMMENT  '代理商邀请码'",'des'=>'...'),


//2016-02-24 13:46:07
array('time'=>mktimes(1970,1,1,16,23),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `offline_type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '线下订单类型，0：使用用户的平台积分，1：使用店铺的平台积分' AFTER `is_offline`",'des'=>'...'),

//2016-02-24 13:15:17
array('time'=>mktimes(1970,1,1,16,22),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}admin`ADD COLUMN `reward_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '奖励总额' AFTER `status`,ADD COLUMN `reward_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '可用奖励金额' AFTER `reward_total`,ADD COLUMN `reward_unbalance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '不可用奖励金额' AFTER `reward_balance`",'des'=>'...'),

//2016-02-24 13:14:08
array('time'=>mktimes(1970,1,1,16,21),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}admin_rbac` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员组id',  `module` varchar(30) NOT NULL DEFAULT '' COMMENT 'module控制器',  `action` varchar(30) NOT NULL DEFAULT '' COMMENT 'action方法',  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT 'system_rbac_menu记录的id',  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `is_module` tinyint(2) NOT NULL DEFAULT  '0' COMMENT  '是否为父级控制器：0否 1是 默认为0',  PRIMARY KEY (`id`),  KEY `group_id` (`group_id`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='总后台管理员权限表' AUTO_INCREMENT=1",'des'=>'...'),

//2016-02-24 12:58:37
array('time'=>mktimes(1970,1,1,16,20),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}admin_group` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(60) NOT NULL COMMENT '组名',  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否可用: 0否 1是',  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',  `remark` varchar(100) NOT NULL COMMENT '备注',  `menu_ids` varchar(300) NOT NULL DEFAULT  '' COMMENT  '保存system_menu id记录',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组管理' AUTO_INCREMENT=1",'des'=>'...'),

//2016-02-24 11:37:33
array('time'=>mktimes(1970,1,1,16,19),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` VALUES ('85', '2', '推广海报设置', 'Promotion', 'index', '0', '1', '1', '0')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,16,18),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` VALUES ('84', '2', '前台LBS展示区域', 'Lbs', 'index', '0', '1', '1', '0')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,16,17),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` VALUES ('83', '1', '代理商邀请码', 'Admin', 'agentcode', '0', '1', '1', '0')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,16,16),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` VALUES ('82', '4', '财务概览', 'Order', 'dashboard', '2', '1', '1', '0')",'des'=>'...'),

//2016-02-24 11:31:33
array('time'=>mktimes(1970,1,1,16,15),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_promote_setting` ADD `type` tinyint(1) unsigned NOT NULL COMMENT '1 店铺 2 平台'",'des'=>'...'),

//2016-02-24 10:49:00
array('time'=>mktimes(1970,1,1,16,13),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product` ADD COLUMN `data_id`  int(11) NOT NULL DEFAULT 0 COMMENT '团购、预售类型时的团购、预售ID' AFTER `type`",'des'=>'...'),

//2016-02-24 10:48:40
array('time'=>mktimes(1970,1,1,16,12),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product` ADD COLUMN `type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单产品类型，0：普通，1：团购，2：预售' AFTER `return_point`",'des'=>'...'),

//2016-02-24 10:48:12
array('time'=>mktimes(1970,1,1,16,11),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product` ADD COLUMN `return_point`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '购买返积分' AFTER `drp_degree_profit`",'des'=>'...'),

//2016-02-24 10:45:45
array('time'=>mktimes(1970,1,1,16,10),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `is_offline`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否是线下订单，1：是，0否' AFTER `point2money_rate`",'des'=>'...'),

//2016-02-24 10:44:32
array('time'=>mktimes(1970,1,1,16,9),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `point2money_rate`  float(8,2) UNSIGNED NOT NULL DEFAULT 1.00 COMMENT '积分抵现兑换比率' AFTER `return_point`",'des'=>'...'),

//2016-02-24 10:44:11
array('time'=>mktimes(1970,1,1,16,8),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `return_point`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '返还积分' AFTER `cash_point`",'des'=>'...'),

//2016-02-24 10:41:15
array('time'=>mktimes(1970,1,1,16,7),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `cash_point`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '抵现积分' AFTER `promotion_reward`",'des'=>'...'),

//2016-02-24 10:33:25
array('time'=>mktimes(1970,1,1,16,6),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `promotion_reward`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '推广奖励总额' AFTER `drp_team_id`",'des'=>'...'),

//2016-02-24 10:31:18
array('time'=>mktimes(1970,1,1,16,5),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `drp_team_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销团队id' AFTER `order_pay_point`",'des'=>'...'),

//2016-02-24 10:18:01
array('time'=>mktimes(1970,1,1,16,4),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('122', 'open_drp_degree', 'type=radio&value=1:开启|0:关闭', '1', '分销等级', '', '0', '', '12', '0', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,16,3),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('123', 'open_drp_team', 'type=radio&value=1:开启|0:关闭', '1', '分销团队', '是否允许店铺开启分销团队', '0', '', '12', '0', '1')",'des'=>'...'),

//2016-02-24 10:12:25
array('time'=>mktimes(1970,1,1,16,1),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`key`, `value`, `bak`) VALUES ('promotion_reward', '0', '平台推广奖励总额')",'des'=>'...'),

//2016-02-24 10:12:15
array('time'=>mktimes(1970,1,1,16,0),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`key`, `value`, `bak`) VALUES ('margin', '0', '平台保证金总额')",'des'=>'...'),

//2016-02-23 18:57:44
array('time'=>mktimes(1970,1,1,15,59),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}user_point_log` (`pigcms_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,`order_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单id' ,`uid`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id' ,`order_no`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单号' ,`point`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '操作积分' ,`status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作状态 0 进行中 1已完成' ,`type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作类型 0 消费产生积分 + 1 消费抵现积分 -' ,`store_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺id' ,`supplier_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '供货商id' ,`add_time`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '添加时间' ,`point_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '积分总额' ,`point_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '积分余额' ,`channel`  tinyint(1) UNSIGNED NOT NULL COMMENT '渠道(0表示线上交易,1表示线下交易)' ,`bak`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注' ,PRIMARY KEY (`pigcms_id`),INDEX `order_id` (`order_id`) USING BTREE ,INDEX `uid` (`uid`) USING BTREE ,INDEX `order_no` (`order_no`) USING BTREE ,INDEX `store_id` (`store_id`) USING BTREE ,INDEX `supplier_id` (`supplier_id`) USING BTREE )ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0",'des'=>'...'),

//2016-02-23 18:56:37
array('time'=>mktimes(1970,1,1,15,58),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD COLUMN `point_used`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '已抵现使用的积分' AFTER `point_gift`",'des'=>'...'),

//2016-02-23 18:55:37
array('time'=>mktimes(1970,1,1,15,57),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD COLUMN `point_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '积分总额' AFTER `city`",'des'=>'...'),

//2016-02-23 18:54:32
array('time'=>mktimes(1970,1,1,15,56),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}supp_dis_relation` ADD COLUMN `sales`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '经销商销售额' AFTER `profit`",'des'=>'...'),


//2016-02-23 18:46:58
array('time'=>mktimes(1970,1,1,15,55),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `point2money`  float(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '变现积分' AFTER `point_balance`",'des'=>'...'),

//2016-02-23 18:46:39
array('time'=>mktimes(1970,1,1,15,54),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `point_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '积分余额' AFTER `point_total`",'des'=>'...'),

//2016-02-23 18:46:24
array('time'=>mktimes(1970,1,1,15,53),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `point_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '积分总额' AFTER `margin_balance`",'des'=>'...'),

//2016-02-23 18:43:22
array('time'=>mktimes(1970,1,1,15,52),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}promotion_reward_log` (`pigcms_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,`order_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单id' ,`admin_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '推广人员id' ,`amount`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '操作金额' ,`status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 未处理 1 已处理' ,`type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作类型 0 奖励 + 1 提现 -' ,`reward_rate`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '奖励比率' ,`store_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺id' ,`add_time`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '添加时间' ,`bak`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注' ,`reward_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '推广奖励总额' ,`reward_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '推广奖励可提现总额' ,PRIMARY KEY (`pigcms_id`),INDEX `order_id` (`order_id`) USING BTREE ,INDEX `admin_id` (`admin_id`) USING BTREE ,INDEX `store_id` (`store_id`) USING BTREE )ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0",'des'=>'...'),

//2016-02-23 18:42:28
array('time'=>mktimes(1970,1,1,15,50),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}platform_point_log` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',  `point` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作积分',  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 未处理 1 已处理',  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型 0 用户积分抵现 + 1 积分转现 +',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `point_income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '操作前平台积分总额',  `channel` tinyint(1) unsigned NOT NULL COMMENT '渠道(0表示线上交易,1表示线下交易)',  `bak` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',  PRIMARY KEY (`pigcms_id`),  KEY `order_no` (`order_no`) USING BTREE,  KEY `store_id` (`store_id`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='平台积分收入日志'",'des'=>'...'),

//2016-02-23 18:34:39
array('time'=>mktimes(1970,1,1,15,49),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `offline_status`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '线下订单审核状态，1：审核通过，0：未审核，2：审核不通过' AFTER `is_offline`,ADD COLUMN `offline_dateline`  int(11) NOT NULL DEFAULT 0 COMMENT '线下订单审核时间' AFTER `offline_status`,ADD COLUMN `offline_admin_id`  int(11) NOT NULL DEFAULT 0 COMMENT '线下订单审核管理员ID' AFTER `offline_dateline`",'des'=>'...'),

//2016-02-23 18:27:20
array('time'=>mktimes(1970,1,1,15,48),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}financial_record` ADD COLUMN `supplier_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '供货商/经销商id' AFTER `return_id`",'des'=>'...'),

//2016-02-23 14:51:31
array('time'=>mktimes(1970,1,1,15,47),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}platform_margin_log` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '交易单号',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',  `payment_method` varchar(20) NOT NULL DEFAULT '' COMMENT '支付方式',  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0充值 1提现 2扣除 3 退货',  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未支付 1未处理 2已处理',  `paid_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `bak` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',  `margin_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '操作前保证金总额',  `margin_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '操作前保证金余额',  PRIMARY KEY (`pigcms_id`),  UNIQUE KEY `order_no` (`order_no`) USING BTREE,  KEY `store_id` (`store_id`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COMMENT='平台保证金流水记录'",'des'=>'...'),

//2016-02-23 14:21:00
array('time'=>mktimes(1970,1,1,15,46),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_point_log`MODIFY COLUMN `type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作类型 0 消费产生积分+ 1 消费返还积分- 2 积分变现- 3 退货返还积分-  4 积分流转服务费-' AFTER `status`",'des'=>'...'),

//2016-02-23 14:20:42
array('time'=>mktimes(1970,1,1,15,45),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_point_log`MODIFY COLUMN `status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 未处理 1 已处理' AFTER `point`",'des'=>'...'),

//2016-02-23 14:20:31
array('time'=>mktimes(1970,1,1,15,44),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}platform_income`ADD COLUMN `status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态 0 未处理 1 已处理' AFTER `add_time`",'des'=>'...'),

//2016-02-23 14:20:18
array('time'=>mktimes(1970,1,1,15,43),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_point_log`ADD COLUMN `order_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单id' AFTER `store_id`",'des'=>'...'),

//2016-02-23 18:50:07
array('time'=>mktimes(1970,1,1,15,42),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_point_log` (`pigcms_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,`store_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺id' ,`order_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单id' ,`order_no`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单号' ,`point`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '操作积分' ,`status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 未处理 1 已处理' ,`type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '操作类型 0 消费产生积分+ 1 消费返还积分- 2 积分变现- 3 退货返还积分-  4 积分流转服务费-' ,`service_fee_rate`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '平台服务费 %（积分）' ,`add_time`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '添加时间' ,`point_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '操作前积分总额' ,`point_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '操作前积分余额' ,`channel`  tinyint(1) UNSIGNED NOT NULL COMMENT '渠道(0表示线上交易,1表示线下交易)' ,`bak`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注' ,PRIMARY KEY (`pigcms_id`),INDEX `store_id` (`store_id`) USING BTREE ,INDEX `order_no` (`order_no`) USING BTREE )ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0",'des'=>'...'),

//2016-02-23 14:20:01
array('time'=>mktimes(1970,1,1,15,41),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}platform_income`MODIFY COLUMN `income`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '收入/支出' AFTER `pigcms_id`,MODIFY COLUMN `type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型：1交易服务费 2店铺认证费用 3 保证金服务费 4 推广奖励' AFTER `add_time`",'des'=>'...'),

//2016-02-23 18:33:52
array('time'=>mktimes(1970,1,1,15,40),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}platform_income` (`pigcms_id`  int(11) UNSIGNED NOT NULL AUTO_INCREMENT ,`income`  decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '收入/支出' ,`add_time`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '添加时间' ,`status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态 0 未处理 1 已处理' ,`type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型：1交易服务费 2店铺认证费用 3 保证金服务费 4 推广奖励' ,`store_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺id' ,`bak`  varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '备注' ,PRIMARY KEY (`pigcms_id`),INDEX `store_id` (`store_id`) USING BTREE )ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci CHECKSUM=0 ROW_FORMAT=Dynamic DELAY_KEY_WRITE=0",'des'=>'...'),

//2016-02-23 14:16:02
array('time'=>mktimes(1970,1,1,15,39),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_points`MODIFY COLUMN `type`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '积分来源 - 1:发展分销商送 2:销售额比例生成 3:分享送 4:签到送 5:推广增加 6:销售额未达标扣积分' AFTER `points`",'des'=>'...'),

//2016-02-23 14:09:55
array('time'=>mktimes(1970,1,1,15,38),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `last_time_statistics`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上次统计销售额时间（扣分销商等级积分）' AFTER `drp_deduct_point`,ADD INDEX (`last_time_statistics`) USING BTREE",'des'=>'...'),

//2016-02-23 14:09:13
array('time'=>mktimes(1970,1,1,15,37),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `drp_deduct_point_month`  tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '扣除分销商等级积分条件(月数)' AFTER `open_store_whole`,ADD COLUMN `drp_deduct_point_sales`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '扣除分销商等级积分条件(销售额)' AFTER `drp_deduct_point_month`,ADD COLUMN `drp_deduct_point`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '扣除分销商等级积分' AFTER `drp_deduct_point_sales`",'des'=>'...'),

//2016-02-23 18:19:34
array('time'=>mktimes(1970,1,1,15,36),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES(81, 4, '店铺添加订单', 'Order', 'offline', 0, 1, 1)",'des'=>'...'),

//2016-02-23 18:11:35
array('time'=>mktimes(1970,1,1,15,35),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES('121', 'offline_money', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '0', '订单额度', '需要总管里员审核的订单额度，0表示不需要', '', '订单额度', 17, 0, 1)",'des'=>'...'),

//2016-02-23 18:11:25
array('time'=>mktimes(1970,1,1,15,34),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config_group` (`gid`, `gname`, `gsort`, `status`) VALUES (17, '店铺自主做单', '0', '1')",'des'=>'...'),

//2016-02-23 17:09:12
array('time'=>mktimes(1970,1,1,15,33),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`, `is_admin`) VALUES(80, 75, '管理员奖金配置', 'Admin', 'bonus_config', '0', '1', '1', '1'),(79, 75, '代理商', 'Admin', 'agent', 0, 1, 1, 0),(78, 75, '区域管理员', 'Admin', 'area', 0, 1, 1, 0),(77, 75, '管理员列表', 'Admin', 'index', 0, 1, 1, 1),(76, 75, '管理员组', 'Admin', 'group', 0, 1, 1, 1),(75, 0, '管理员管理', '', '', 0, 1, 1, 0)",'des'=>'...'),

//2016-02-23 16:22:00
array('time'=>mktimes(1970,1,1,15,32),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store_points_config` ADD  `order_consume` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '【设置】积分赠送方式: 0满送 1消费送' AFTER  `offset_limit`",'des'=>'...'),

//2016-02-23 14:19:03
array('time'=>mktimes(1970,1,1,15,31),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product` ADD COLUMN `presale_pro_price` DECIMAL(10,2) DEFAULT 0 NULL COMMENT '当为预售订单商品时，此为购买商品原价' AFTER `pro_price`",'des'=>'...'),

//2016-02-23 13:57:31
array('time'=>mktimes(1970,1,1,15,30),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}release_point` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '每日释放积分总额',  `users` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发放积分用户数',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `add_date` int(8) unsigned NOT NULL COMMENT '日期',  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态（1为发放成功，0为未发放或未完全发放）',  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='平台释放积分统计'",'des'=>'...'),

//2016-02-23 11:29:15
array('time'=>mktimes(1970,1,1,15,28),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `presale_order_id` INT(11) DEFAULT 0 NULL COMMENT '预售订单id(首次支付：默认为0，直付尾款：为预售order的id)' AFTER `data_id`",'des'=>'...'),

//2016-02-22 17:52:18
array('time'=>mktimes(1970,1,1,15,27),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}day_platform_service_fee` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '金额',  `add_date` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期 格式：19700101',  PRIMARY KEY (`pigcms_id`),  UNIQUE KEY `add_date` (`add_date`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='每日平台服务费流水'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,15,26),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}day_platform_point` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分',  `add_date` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期 格式：19700101',  PRIMARY KEY (`pigcms_id`),  UNIQUE KEY `add_date` (`add_date`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='每日返积分日志'",'des'=>'...'),

//2016-02-22 16:35:38
array('time'=>mktimes(1970,1,1,15,25),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}release_point_log` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `release_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '释放积分id',  `order_no` varchar(50) NOT NULL DEFAULT '' COMMENT '订单号',  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',  `point` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `add_date` int(8) unsigned NOT NULL,  `send_point` int(11) unsigned NOT NULL COMMENT '释放平台币点数',  `point_weight` float(5,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分权数',  `user_point_balance` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户积分可用余额',  `user_point_total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '用户积分可总额',  PRIMARY KEY (`pigcms_id`),  KEY `release_id` (`release_id`) USING BTREE,  KEY `uid` (`uid`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='平台释放积分日志'",'des'=>'...'),

//2016-02-22 13:41:43
array('time'=>mktimes(1970,1,1,15,24),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}product_activity` (  `id` int(255) NOT NULL AUTO_INCREMENT,  `product_id` int(255) NOT NULL COMMENT '商品ID',  `activity_name` varchar(255) NOT NULL COMMENT '活动名',  `activity_id` int(255) NOT NULL COMMENT '活动ID',  `activity_status` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '活动状态，1开启0关闭',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-02-22 13:18:44
array('time'=>mktimes(1970,1,1,15,23),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` CHANGE  `today_credit_weight`  `today_credit_weight` FLOAT( 8, 2 ) UNSIGNED NOT NULL COMMENT  '今日积分权数值', CHANGE  `platform_credit_points`  `platform_credit_points` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '用户可以获得的发放点数'",'des'=>'...'),

//2016-02-20 14:58:12
array('time'=>mktimes(1970,1,1,15,21),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}commonweal_address` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',  `title` varchar(256) DEFAULT NULL COMMENT '送公益标题',  `name` varchar(50) NOT NULL COMMENT '收货人',  `tel` varchar(20) NOT NULL COMMENT '联系电话',  `province` mediumint(9) NOT NULL DEFAULT '0' COMMENT '省code',  `city` mediumint(9) NOT NULL DEFAULT '0' COMMENT '市code',  `area` mediumint(9) NOT NULL DEFAULT '0' COMMENT '区code',  `address` varchar(256) NOT NULL COMMENT '详细地址',  `zipcode` varchar(10) DEFAULT NULL COMMENT '邮编',  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认收货地址,1:是，0:否',  PRIMARY KEY (`id`),  KEY `store_id` (`store_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='送公益收货地址'",'des'=>'...'),


//2016-02-19 13:29:33
array('time'=>mktimes(1970,1,1,15,20),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan`ADD COLUMN `operation_dateline`  int(11) NOT NULL DEFAULT 0 COMMENT '设置团购达标时间' AFTER `tuan_config_id`",'des'=>'...'),

//2016-02-19 17:12:08
array('time'=>mktimes(1970,1,1,15,19),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name` , `type` , `value` , `info` , `desc` , `tab_id` , `tab_name` , `gid` , `sort` , `status` ) VALUES (120, 'withdraw_limit',  'type=text&size=10&validate=required:true,number:true,min:0',  '0',  '提现审批金额限制',  '大于该金额的提现记录不允许非超级管理员操作，0为不做限制',  '0',  '',  '1',  '0',  '1')",'des'=>'...'),

//2016-02-19 11:28:34
array('time'=>mktimes(1970,1,1,15,18),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_points`MODIFY COLUMN `type`  tinyint(2) NOT NULL DEFAULT 0 COMMENT '积分来源 - 1:发展分销商送 2:销售额比例生成 3:分享送 4:签到送 5:推广增加 6:销售额未达标扣积分' AFTER `points`",'des'=>'...'),

//2016-02-19 11:28:19
array('time'=>mktimes(1970,1,1,15,17),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `last_time_statistics`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上次统计销售额时间（扣分销商等级积分）' AFTER `drp_deduct_point`,ADD INDEX (`last_time_statistics`) USING BTREE",'des'=>'...'),

//2016-02-19 11:27:59
array('time'=>mktimes(1970,1,1,15,16),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `drp_deduct_point_month`  tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '扣除分销商等级积分条件(月数)' AFTER `open_store_whole`,ADD COLUMN `drp_deduct_point_sales`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '扣除分销商等级积分条件(销售额)' AFTER `drp_deduct_point_month`,ADD COLUMN `drp_deduct_point`  int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '扣除分销商等级积分' AFTER `drp_deduct_point_sales`",'des'=>'...'),

//2016-02-19 11:24:30
array('time'=>mktimes(1970,1,1,15,15),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`MODIFY COLUMN `point2money_rate`  float(8,2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '积分抵现兑换比率' AFTER `return_point`",'des'=>'...'),

//2016-02-18 19:03:50
array('time'=>mktimes(1970,1,1,15,14),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}subscribe_store`ADD COLUMN `user_subscribe_time`  int(11) NOT NULL COMMENT '用户关注店铺时间（成为粉丝时间）' AFTER `leave_time`",'des'=>'...'),


//2016-02-18 17:23:59
array('time'=>mktimes(1970,1,1,15,13),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`,`type`,`value`,`info`,`desc`,`gid`,`status`,`tab_name`) VALUES ('119','lbs_distance_limit', 'type=text&validate=required:true,number:true,maxlength:5','0','前台LBS距离设定','在扫码或能得到精确坐标后，将限定显示在此距离范围内的商家或商品数据(单位:km)','1','0','')",'des'=>'...'),

//2016-02-18 14:01:08
array('time'=>mktimes(1970,1,1,15,12),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store_area_record` ADD  `creator` INT NOT NULL DEFAULT  '0' COMMENT  '修改管理员admin_id，默认0 为用户修改记录'",'des'=>'...'),

//2016-02-18 11:07:49
array('time'=>mktimes(1970,1,1,15,11),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan`ADD COLUMN `tuan_config_id`  int(11) NOT NULL DEFAULT 0 COMMENT '达标的团购项ID' AFTER `status`",'des'=>'...'),

//2016-02-18 10:58:05
array('time'=>mktimes(1970,1,1,15,10),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `data_money`  float(8,2) NOT NULL DEFAULT 0.00 COMMENT '团购需要退的钱，预售需要加的钱' AFTER `data_item_id`",'des'=>'...'),

//2016-02-17 14:58:23
array('time'=>mktimes(1970,1,1,15,9),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product`ADD COLUMN `open_return_point`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '开启送平台积分 0 未开启 1 已开启' AFTER `is_present`",'des'=>'...'),

//2016-02-17 14:57:45
array('time'=>mktimes(1970,1,1,15,8),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product`ADD COLUMN `return_point`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '返还积分'",'des'=>'...'),

//2016-02-17 13:46:27
array('time'=>mktimes(1970,1,1,15,7),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_sku` ADD `after_subscribe_discount` decimal(5,2) unsigned NOT NULL COMMENT '关注后折扣'",'des'=>'...'),

//2016-02-03 10:48:36
array('time'=>mktimes(1970,1,1,15,6),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_sku` ADD `after_subscribe_price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '关注后库存价格'",'des'=>'...'),

//2016-02-02 14:15:24
array('time'=>mktimes(1970,1,1,15,4),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD `after_subscribe_discount` decimal(5,2) unsigned NOT NULL COMMENT '关注后折扣'",'des'=>'...'),

//2016-02-17 10:58:42
array('time'=>mktimes(1970,1,1,15,2),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}lbs_area` (  `code` int(11) NOT NULL COMMENT '城市代码',  `name` varchar(200) DEFAULT NULL COMMENT '城市名称',  `first_spell` varchar(200) DEFAULT NULL COMMENT '城市中文首字母',  `chinese_spell` varchar(200) DEFAULT NULL COMMENT '城市中文全拼',  `is_hot` tinyint(1) DEFAULT '0' COMMENT '是否热门城市(0:否 1:是)',  `is_open` tinyint(1) DEFAULT '0' COMMENT '是否开启',  PRIMARY KEY (`code`)) ENGINE=MyISAM DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-02-17 10:50:03
array('time'=>mktimes(1970,1,1,15,1),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product`ADD COLUMN `type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单产品类型，0：普通，1：团购，2：预售' AFTER `return_point`,ADD COLUMN `data_id`  int(11) NOT NULL DEFAULT 0 COMMENT '团购、预售类型时的团购、预售ID' AFTER `type`",'des'=>'...'),

//2016-02-17 10:41:47
array('time'=>mktimes(1970,1,1,15,0),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `data_id`  int(11) NOT NULL DEFAULT 0 COMMENT '当type为6、7时，所对应团购ID，预售ID' AFTER `type`,ADD COLUMN `data_type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '团购订单时，团购类型，0：人缘开团，1：最优开团' AFTER `data_id`,ADD COLUMN `data_item_id`  int(11) NOT NULL DEFAULT 0 COMMENT '团购订单时，参加的团购项' AFTER `data_type`",'des'=>'...'),

//2016-02-16 16:49:18
array('time'=>mktimes(1970,1,1,14,59),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin_bonus_config` CHANGE  `self_online`  `self_online` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '自营店铺-线上(%)',		CHANGE  `self_offline`  `self_offline` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '自营店铺-线下(%)',		CHANGE  `platform_online`  `platform_online` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '平台经营-线上(%)',		CHANGE  `platform_offline`  `platform_offline` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '平台经营-线下(%)',		CHANGE  `foreign_online`  `foreign_online` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '海外店铺-线上(%)',		CHANGE  `foreign_offline`  `foreign_offline` DECIMAL( 5, 2 ) UNSIGNED NOT NULL COMMENT  '海外店铺-线下(%)'",'des'=>'...'),

//2016-02-16 16:49:04
array('time'=>mktimes(1970,1,1,14,58),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (118 ,  'allow_agent_invite',  'type=radio&value=1:是|0:否',  '1',  '推广邀请码注册',  '',  '0',  '',  '1',  '0',  '1')",'des'=>'...'),

//2016-02-16 10:34:56
array('time'=>mktimes(1970,1,1,14,56),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}tuan_config`ADD COLUMN `discount`  float(8,1) NOT NULL DEFAULT 10 COMMENT '折扣' AFTER `price`",'des'=>'...'),

//2016-02-14 16:41:40
array('time'=>mktimes(1970,1,1,14,55),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_category` ADD COLUMN `wx_cat_status` TINYINT(1) DEFAULT 1 NULL COMMENT '微信端显示状态' AFTER `cat_status`",'des'=>'...'),

array('time'=>mktimes(1970,1,1,14,54),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}gift_point_record`( `id` INT(11) NOT NULL AUTO_INCREMENT, `uid` INT(11) COMMENT '被操作的用户uid', `store_id` INT(11), `point` INT(11) COMMENT '变更的积分', `type` TINYINT(1) COMMENT '1:订单消耗', `timestamp` INT(11), `order_id` INT(11) COMMENT '订单消耗的order_id', PRIMARY KEY (`id`) ) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_general_ci",'des'=>'...'),

//2016-02-05 10:21:10
array('time'=>mktimes(1970,1,1,14,53),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}admin_bonus_config` (  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '管理员类型,默认0: 0,1保留 2区域管理员 3代理商 ',  `area_level` tinyint(2) NOT NULL DEFAULT '0' COMMENT '区域等级,默认0: 0非区域管理员 1省级 2市级 3区县级',  `self_online` decimal(4,2) UNSIGNED NOT NULL COMMENT '自营店铺-线上(%)',  `self_offline` decimal(4,2) UNSIGNED NOT NULL COMMENT '自营店铺-线下(%)',  `platform_online` decimal(4,2) UNSIGNED NOT NULL COMMENT '平台经营-线上(%)',  `platform_offline` decimal(4,2) UNSIGNED NOT NULL COMMENT '平台经营-线下(%)',  `foreign_online` decimal(4,2) UNSIGNED NOT NULL COMMENT '海外店铺-线上(%)',  `foreign_offline` decimal(4,2) UNSIGNED NOT NULL COMMENT '海外店铺-线下(%)',  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态: 0关闭 1使用 默认0',  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '配置创建者',  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员奖金比例配置' AUTO_INCREMENT=1",'des'=>'...'),

//2016-02-05 10:21:00
array('time'=>mktimes(1970,1,1,14,52),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}agent_invite` (  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联代理商的admin表id',  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '关系建立来源：0管理员手动 1邀请码注册',  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '手动添加的管理员id',  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`pigcms_id`),  KEY `uid` (`uid`) USING BTREE,  KEY `admin_id` (`admin_id`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代理商邀请用户注册关系记录表' AUTO_INCREMENT=1",'des'=>'...'),

//2016-02-05 9:24:57
array('time'=>mktimes(1970,1,1,14,51),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`  ADD COLUMN `is_point_order` TINYINT(1) DEFAULT 0 NULL COMMENT '是否积分商城兑换订单 0:否 1：是' AFTER `drp_degree_id`, ADD COLUMN `order_pay_point` TINYINT(1) DEFAULT 0 NULL COMMENT '积分商城该订单需要支付多少积分' AFTER `is_point_order`",'des'=>'...'),

//2016-02-04 17:43:53
array('time'=>mktimes(1970,1,1,14,49),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `is_offline`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否是线下订单，1：是，0否' AFTER `point2money_rate`",'des'=>'...'),

//2016-02-04 15:45:14
array('time'=>mktimes(1970,1,1,14,48),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` DROP COLUMN `is_point_order`, ADD COLUMN `is_point_order` TINYINT(1) DEFAULT 0 NULL COMMENT '是否积分商城兑换订单 0:否 1：是' AFTER `drp_degree_id`, ADD COLUMN `order_pay_point` INT(11) NULL COMMENT '积分商城该订单需要支付多少积分' AFTER `is_point_order`",'des'=>'...'),

//2016-02-03 16:17:31
array('time'=>mktimes(1970,1,1,14,47),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `is_present` TINYINT(1) DEFAULT 0 NULL COMMENT '是否积分商城商品（0: 普通商品 1：积分兑换商品）' AFTER `after_subscribe_price`",'des'=>'...'),

array('time'=>mktimes(1970,1,1,14,45),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}credit_setting` ADD  `cash_min_amount` INT UNSIGNED NOT NULL COMMENT  '保证金充值最小额度' AFTER  `credit_deposit_ratio`",'des'=>'...'),

//2016-02-03 15:05:01
array('time'=>mktimes(1970,1,1,14,44),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}store_area_record` (  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺',  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省',  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '市',  `county` varchar(30) NOT NULL DEFAULT '' COMMENT '区',  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态：0关闭 1使用 默认为0',  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺区域修改记录' AUTO_INCREMENT=1",'des'=>'...'),

//2016-02-03 15:04:53
array('time'=>mktimes(1970,1,1,14,43),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}admin_rbac` ADD  `is_module` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '是否为父级控制器：0否 1是 默认为0'",'des'=>'...'),

//2016-02-03 15:04:30
array('time'=>mktimes(1970,1,1,14,41),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_rbac_menu` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '父级控制器id',  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',  `module` varchar(60) NOT NULL DEFAULT '' COMMENT 'module控制器',  `action` varchar(60) NOT NULL DEFAULT '' COMMENT 'action方法',  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：1使用 0关闭 默认为1',  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='另外的rbac列表' AUTO_INCREMENT=1",'des'=>'...'),

//2016-02-03 15:04:17
array('time'=>mktimes(1970,1,1,14,40),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}user` ADD  `invite_admin` int(11) NOT NULL DEFAULT 0 COMMENT  '邀请者(总后台代理商)的id'",'des'=>'...'),

//2016-02-03 9:31:19
array('time'=>mktimes(1970,1,1,14,38),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `is_point_mall` TINYINT(1) DEFAULT 0 NULL COMMENT '是否积分商城 0:否 1:是' AFTER `drp_team_id`",'des'=>'...'),

//2016-02-02 17:57:08
array('time'=>mktimes(1970,1,1,14,37),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}subject_diy_keywords` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',  `keys` varchar(200) DEFAULT NULL COMMENT '标识',  `content` text COMMENT '替换内容',  `timestamp` int(11) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-02-02 17:39:18
array('time'=>mktimes(1970,1,1,14,36),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_degree`  int(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否开启分销商等级'",'des'=>'...'),

//2016-02-02 15:27:34
array('time'=>mktimes(1970,1,1,14,35),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user`MODIFY COLUMN `point_balance`  float(8,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台积分，可直接当现金使用' AFTER `smscount`,MODIFY COLUMN `point_unbalance`  float(8,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台总积分，不可用的积分' AFTER `point_balance`,MODIFY COLUMN `point_gift`  float(8,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台积分，礼物兑换积分' AFTER `point_unbalance`",'des'=>'...'),

//2016-02-02 9:21:14
array('time'=>mktimes(1970,1,1,14,34),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user`ADD COLUMN `point_balance`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台积分，可直接当现金使用' AFTER `smscount`,ADD COLUMN `point_unbalance`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台总积分，不可用的积分' AFTER `point_balance`,ADD COLUMN `point_gift`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台积分，礼物兑换积分' AFTER `point_unbalance`",'des'=>'...'),

//2016-02-01 16:21:53
array('time'=>mktimes(1970,1,1,14,33),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `drp_degree_id`  int(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销商等级id',ADD INDEX (`drp_degree_id`)",'des'=>'...'),

//2016-02-01 10:20:30
array('time'=>mktimes(1970,1,1,14,32),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}certification`ADD COLUMN `supplier_id`int(11) NOT NULL COMMENT '供货商'",'des'=>'...'),

//2016-02-01 10:17:57
array('time'=>mktimes(1970,1,1,14,31),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_store_whole` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排他批发'",'des'=>'...'),

//2016-02-01 10:08:33
array('time'=>mktimes(1970,1,1,14,29),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}credit_setting` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `platform_credit_open` tinyint(1) NOT NULL COMMENT '开启平台积分(0不开启,1开启)',  `force_use_platform_credit` tinyint(1) unsigned NOT NULL COMMENT '强制开启平台积分(1.开启|0.关闭)',  `store_credit_open` tinyint(1) NOT NULL COMMENT '开启店铺积分(0不开启,1开启)',  `platform_credit_name` varchar(50) NOT NULL COMMENT '平台积分前端展示名称',  `platform_credit_points` VARCHAR( 80 ) NOT NULL COMMENT '用户可以获得的发放点数',  `credit_deposit_ratio` tinyint(3) unsigned NOT NULL COMMENT '积分保证金扣除比例',  `cash_provisions` tinyint(3) unsigned NOT NULL COMMENT '提现备付金',  `credit_flow_charges` tinyint(3) unsigned NOT NULL COMMENT '积分流转手续费',  `storecredit_to_money_charges` tinyint(3) unsigned NOT NULL COMMENT '店铺积分变现手续费',  `online_trade_money` tinyint(3) unsigned NOT NULL COMMENT '线上订单现金积分比（现金）',  `online_trade_credit_type` tinyint(1) unsigned NOT NULL COMMENT '线上订单赠送积分基数(0为订单全额,1为现金部分)',  `offline_trade_money` tinyint(3) unsigned NOT NULL COMMENT '线下做单现金积分比（现金）',  `offline_trade_credit_type` tinyint(1) unsigned NOT NULL COMMENT '线下做单赠送积分基数(0为订单全额,1为现金部分)',  `platform_credit_rule` int(11) unsigned NOT NULL COMMENT '平台生成规则设置:1元消费额等于xx积分',  `platform_credit_use_value` int(11) unsigned NOT NULL COMMENT '使用价值设置:1元人民币等于xx积分',  `credit_weight` int(11) unsigned NOT NULL COMMENT '积分权数值',  `today_credit_weight` FLOAT( 8, 2 ) unsigned NOT NULL COMMENT '今日积分权数值',  `day_send_credit_time` time NOT NULL COMMENT '每日默认发送积分时间',  `share_qrcode_effective_click` int(11) NOT NULL COMMENT '分享二维码点击（有效点击数设置）',  `share_qrcode_credit` int(11) NOT NULL COMMENT '分享二维码点击（送积分设置）',  `follow_platform_credit` int(11) NOT NULL COMMENT '关注平台二维码可得积分(首次)',  `recommend_follow_self_credit` int(11) NOT NULL COMMENT '推荐别人关注自身可得积分(每次)',  PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='积分配置表' AUTO_INCREMENT=2",'des'=>'...'),

//2016-02-01 9:25:14
array('time'=>mktimes(1970,1,1,14,28),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `margin_balance`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '保证金余额' AFTER `unbalance`",'des'=>'...'),

//2016-02-01 9:24:57
array('time'=>mktimes(1970,1,1,14,27),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `margin_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '保证金总额' AFTER `unbalance`",'des'=>'...'),

//2016-01-30 15:09:22
array('time'=>mktimes(1970,1,1,14,18),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD `after_subscribe_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '关注后价格'",'des'=>'...'),

//2016-01-29 18:06:06
array('time'=>mktimes(1970,1,1,14,17),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}location_qrcode` ADD COLUMN `phone` VARCHAR(20) NULL AFTER `add_time`",'des'=>'...'),

//2016-01-29 18:05:25
array('time'=>mktimes(1970,1,1,14,16),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}login_qrcode` ADD COLUMN `phone` INT(11) NULL COMMENT '注册手机号' AFTER `add_time`, ADD COLUMN `other_info` VARCHAR(250) NULL COMMENT '注册的其他信息' AFTER `phone`",'des'=>'...'),

//2016-01-29 15:44:37
array('time'=>mktimes(1970,1,1,14,15),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES (74, '70', '积分流水', 'Credit', 'record', '0', '1', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,14,14),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES (73, '70', '保证金流水', 'Credit', 'depositRecord', '0', '1', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,14,13),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES (72, '70', '积分规则', 'Credit', 'rules', '0', '1', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,14,12),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES (71, '70', '积分概述', 'Credit', 'index', '0', '1', '1')",'des'=>'...'),

//2016-01-29 15:44:21
array('time'=>mktimes(1970,1,1,14,11),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}system_menu` (`id` ,`fid` ,`name` ,`module` ,`action` ,`sort` ,`show` ,`status`)VALUES (70 ,  '0',  '平台积分',  '',  '',  '3',  '1',  '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,14,10),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}system_menu` ADD `is_admin` TINYINT NOT NULL COMMENT '超级管理员权限'",'des'=>'...'),


//2016-01-29 15:34:50
array('time'=>mktimes(1970,1,1,14,9),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}credit_flow` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `order_id` int(11) unsigned NOT NULL COMMENT '保证金流水订单id',  `order_no` varchar(100) NOT NULL COMMENT '订单号',  `store_id` int(11) unsigned NOT NULL COMMENT '商户id',  `uid` int(11) unsigned NOT NULL COMMENT '用户uid',  `u_credit` int(11) unsigned NOT NULL COMMENT '用户积分值',  `u_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户积分值类型：0为扣除,1为增加',  `s_credit` int(11) unsigned NOT NULL COMMENT '店铺积分值',  `s_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '店铺积分值类型：0为扣除,1为增加',  `p_credit` int(11) unsigned NOT NULL COMMENT '平台积分值',  `p_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '平台积分值类型：0为扣除,1为增加',  `msg` varchar(255) NOT NULL COMMENT '内容',  `timestamp` int(11) unsigned NOT NULL COMMENT '时间',  PRIMARY KEY (`id`),  UNIQUE KEY `order_id` (`order_id`),  UNIQUE KEY `order_no` (`order_no`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='积分流水表'",'des'=>'...'),

//2016-01-29 15:33:09
array('time'=>mktimes(1970,1,1,14,8),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}credit_deposit_flow` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `order_id` int(11) unsigned NOT NULL COMMENT '保证金流水订单id',  `order_no` varchar(100) NOT NULL COMMENT '订单号',  `store_id` int(11) unsigned NOT NULL COMMENT '来源商铺id',  `money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '方式类型:1.充值2.扣除',  `msg` varchar(255) NOT NULL COMMENT '内容',  `timestamp` int(11) unsigned NOT NULL COMMENT '时间',  PRIMARY KEY (`id`),  UNIQUE KEY `order_no` (`order_no`),  UNIQUE KEY `order_id` (`order_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='保证金流水'",'des'=>'...'),

//2016-01-26 13:41:40
array('time'=>mktimes(1970,1,1,14,7),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `orders`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单数' AFTER `unbalance`",'des'=>'...'),

//2016-01-26 13:41:29
array('time'=>mktimes(1970,1,1,14,6),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `drp_team_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销团队id',ADD INDEX `drp_team_id` (`drp_team_id`) USING BTREE",'des'=>'...'),

//2016-01-26 13:41:11
array('time'=>mktimes(1970,1,1,14,5),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}drp_team` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '团队名称',  `logo` varchar(200) NOT NULL DEFAULT '' COMMENT '团队logo',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队所有者',  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队供货商',  `sales` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '团队销售额',  `members` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队成员数',  `desc` varchar(500) NOT NULL DEFAULT '' COMMENT '团队描述',  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '团队状态',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团队创建时间',  PRIMARY KEY (`pigcms_id`),  UNIQUE KEY `store_id` (`store_id`) USING BTREE,  KEY `sales` (`sales`) USING BTREE,  KEY `members` (`members`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='分销团队'",'des'=>'...'),

//2016-01-26 13:40:33
array('time'=>mktimes(1970,1,1,14,4),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_team`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否开启分销团队'",'des'=>'...'),

//2016-01-26 9:28:22
array('time'=>mktimes(1970,1,1,14,2),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}tuan_config` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `tuan_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '团购ID',  `number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '参团人数',  `price` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '团购价格',  `start_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '初始人数',  PRIMARY KEY (`id`),  KEY `tuan_id` (`tuan_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-01-26 9:28:03
array('time'=>mktimes(1970,1,1,14,1),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}tuan` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `name` varchar(100) DEFAULT NULL COMMENT '团购名称',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户UID',  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',  `start_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开团开始时间',  `end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '开团结束时间 ',  `description` text COMMENT '开团说明',  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '团购状态，1：正常，2：失效',  `delete_flg` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',  PRIMARY KEY (`id`),  KEY `store_id` (`store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-01-12 11:50:04(补)
array('time'=>mktimes(1970,1,1,13,56),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `degree_exchange_type` TINYINT(1) DEFAULT 1 NULL COMMENT '兑换类型：1手工兑换,2:自动升级' AFTER `is_show_drp_tel`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,13,55),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `is_fanshare_drp` TINYINT(1) DEFAULT 0 NULL COMMENT '分享自动成为分销商：0否，1是' AFTER `is_show_drp_tel`",'des'=>'...'),

//2016-01-16 17:34:01
array('time'=>mktimes(1970,1,1,13,54),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user_degree` CHANGE `points_discount_toplimit` `points_discount_toplimit` DOUBLE(3,1) DEFAULT 0 NULL COMMENT '积分抵现上限每单(元）　', CHANGE `points_discount_ratio` `points_discount_ratio` DOUBLE(3,1) DEFAULT 0 NULL COMMENT '积分在订单金额抵现比例（百分比）'",'des'=>'...'),

//2016-01-16 17:03:31
array('time'=>mktimes(1970,1,1,13,53),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user_degree` ADD COLUMN `is_points_discount_toplimit` TINYINT(1) DEFAULT 0 NULL COMMENT '是否开启（每单）有积分抵现上限' AFTER `description`, ADD COLUMN `is_points_discount_ratio` TINYINT(1) DEFAULT 0 NULL COMMENT '是否开启积分在订单金额抵现比例' AFTER `is_points_discount_toplimit`, ADD COLUMN `is_discount` TINYINT(1) DEFAULT 0 NULL COMMENT '是否开启享受会员折扣' AFTER `is_postage_free`, ADD COLUMN `degree_month` SMALLINT(3) DEFAULT 0 NULL COMMENT '等级有效期(单位:月)' AFTER `is_discount`, ADD COLUMN `points_discount_toplimit` SMALLINT(3) DEFAULT 0 NULL COMMENT '积分抵现上限每单(元）' AFTER `degree_month`, ADD COLUMN `points_discount_ratio` SMALLINT(3) DEFAULT 0 NULL COMMENT '积分在订单金额抵现比例（百分比）' AFTER `points_discount_toplimit`",'des'=>'...'),

//2015-12-14 16:55:46
array('time'=>mktimes(1970,1,1,13,49),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}subscribe_general` (  `sub_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sub_id',  `uid` int(10) NOT NULL COMMENT '用户id',  `store_id` int(11) NOT NULL COMMENT '店铺id',  `addtime` int(11) NOT NULL COMMENT '关注时间',  PRIMARY KEY (`sub_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='非认证服务号 关注记录' AUTO_INCREMENT=1",'des'=>'...'),

//2015-12-14 9:26:15
array('time'=>mktimes(1970,1,1,13,48),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}weixin_bind` ADD  `hurl` VARCHAR( 150 ) NOT NULL COMMENT  '公众号快速关注链接'",'des'=>'...'),

//2016-01-22 11:09:23
array('time'=>mktimes(1970,1,1,13,46),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store_points_config` CHANGE  `price`  `price` INT UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '积分兑换价值：1元兑换的积分数量'",'des'=>'...'),

//2016-01-21 11:49:26
array('time'=>mktimes(1970,1,1,13,45),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}product_drp_degree` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',  `degree_id` int(11) unsigned DEFAULT '0' COMMENT '等级id',  `seller_reward_1` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '一级分销商奖励比率',  `seller_reward_2` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '二级分销商奖励比率',  `seller_reward_3` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '三级分销商奖励比率',  PRIMARY KEY (`pigcms_id`),  KEY `product_id` (`product_id`) USING BTREE,  KEY `store_id` (`store_id`) USING BTREE,  KEY `degree_id` (`degree_id`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='分销商品等级利润'",'des'=>'...'),

//2016-01-20 15:07:05
array('time'=>mktimes(1970,1,1,13,44),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `root_supplier_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '顶级供货商id' AFTER `drp_supplier_id`,ADD INDEX (`root_supplier_id`) USING BTREE",'des'=>'...'),
array('time'=>mktimes(1970,1,1,13,43),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_supplier`ADD COLUMN `root_supplier_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '顶级供货商店铺id' AFTER `type`,ADD INDEX (`root_supplier_id`) USING BTREE",'des'=>'...'),

//2016-01-20 10:48:22
array('time'=>mktimes(1970,1,1,13,44),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}share_link` CHANGE  `uid`  `uid` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '分享者uid'",'des'=>'...'),

//2016-01-20 10:19:11
array('time'=>mktimes(1970,1,1,13,43),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}share_link`ADD COLUMN `open_id`  varchar(255) NULL COMMENT '访问者的open_id' AFTER `seller_id`,ADD INDEX (`open_id`)",'des'=>'...'),

//2016-01-19 16:07:26
array('time'=>mktimes(1970,1,1,13,42),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product`ADD COLUMN `unified_price`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '统一零售价' AFTER `is_fx`",'des'=>'...'),

//2016-01-19 16:07:14
array('time'=>mktimes(1970,1,1,13,41),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `drp_degree_id`  int(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销商等级id'",'des'=>'...'),

//2016-01-19 16:06:57
array('time'=>mktimes(1970,1,1,13,40),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product`ADD COLUMN `drp_degree_profit`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销商等级利润'",'des'=>'...'),

//2016-01-19 14:42:07
array('time'=>mktimes(1970,1,1,13,39),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}store_points_config` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) NOT NULL COMMENT '所属店铺id',  `is_offset` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '【设置】用户积分是否允许抵现: 0否 1是',  `price` decimal(10,2) UNSIGNED NOT NULL COMMENT '用户积分兑换价值',  `is_percent` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '【设置】抵现是否限制百分比：0否 1是',  `offset_cash` decimal(4,2) UNSIGNED NOT NULL COMMENT '抵现百分比88.00',  `is_limit` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】是否使用金额上限: 0否 1是',  `offset_limit` int(8) UNSIGNED NOT NULL COMMENT '每单用户积分抵现上限(金额)',  `order_consume` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】积分赠送方式: 0满送 1消费送',  `consume_money` int(11) UNSIGNED NOT NULL COMMENT '单笔满送-价格(用户积分)',  `consume_point` int(11) UNSIGNED NOT NULL COMMENT '单笔满送-积分(用户积分)',  `proport_money` int(11) UNSIGNED NOT NULL COMMENT '实际消费抵换需要金额 (兑换1用户积分的金额)',  `point_from` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】用户积分来源： 0单笔满送 1实际消费金额抵换',  `drp1_spoint_money` int(11) UNSIGNED NOT NULL COMMENT '销售店铺获取 (兑换1分销积分的金额)',  `drp2_spoint_money` int(11) UNSIGNED NOT NULL COMMENT '上一级获取积分比例(兑换1分销积分的金额)',  `drp3_spoint_money` int(11) UNSIGNED NOT NULL COMMENT '上二级获取积分比例(兑换1分销积分的金额)',  `is_subscribe` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】是否开启多级推广: 0否 1是',  `drp1_subscribe_point` int(11) UNSIGNED NOT NULL COMMENT '关注本店获取用户积分',  `drp2_subscribe_point` int(11) UNSIGNED NOT NULL COMMENT '上一级推荐关注获取积分',  `drp3_subscribe_point` int(11) UNSIGNED NOT NULL COMMENT '上二级推荐关注获取积分',  `is_share` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】是否开启分享获取积分 0否 1是',  `share_click_num` int(11) UNSIGNED NOT NULL COMMENT '分享点击(扫)数量',  `share_click_point` int(11) UNSIGNED NOT NULL COMMENT '分享点击(扫)-兑换的积分数',  `drp1_spoint` int(11) UNSIGNED NOT NULL COMMENT '成为分销商，获取店铺积分',  `drp2_spoint` int(11) UNSIGNED NOT NULL COMMENT '成为分销商，下一级获取积分',  `drp3_spoint` int(11) UNSIGNED NOT NULL COMMENT '成为分销商，下二级获取积分',  `sign_set` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】是否开启签到：0否 1是',  `sign_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '【设置】签到模式: 0每日积分相同 1累计模式',  `sign_fixed_point` int(11) UNSIGNED NOT NULL COMMENT '固定签到获取积分数',  `sign_plus_start` int(11) UNSIGNED NOT NULL COMMENT '首次签到积分',  `sign_plus_addition` int(11) UNSIGNED NOT NULL COMMENT '每日签到额外添加积分数',  `sign_plus_day` int(11) UNSIGNED NOT NULL COMMENT '连续签到上限天数',  PRIMARY KEY (`id`),  KEY `store_id` (`store_id`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺积分配置' AUTO_INCREMENT=1",'des'=>'...'),

//2016-01-19 10:56:28
array('time'=>mktimes(1970,1,1,13,38),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_user_data`ADD COLUMN `degree_update_date`  int(11) NOT NULL DEFAULT 0 COMMENT '等级变更日期，用于每天更新一次，减少服务器压力' AFTER `degree_date`",'des'=>'...'),

//2016-01-19 10:35:15
array('time'=>mktimes(1970,1,1,13,37),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}share_record` (  `share_id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) NOT NULL COMMENT '分享得店铺id',  `key` varchar(150) NOT NULL COMMENT '分享唯一key',  `uid` int(11) NOT NULL COMMENT '分享者uid',  `addtime` int(11) NOT NULL COMMENT '分享时间',  PRIMARY KEY (`share_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分享记录列表' AUTO_INCREMENT=1",'des'=>'...'),

//2016-01-18 9:09:48
array('time'=>mktimes(1970,1,1,13,35),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}drp_degree` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',  `degree_alias` varchar(50) DEFAULT '' COMMENT '等级别名',  `value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '等级值',  `is_platform_degree_name1` tinyint(1) DEFAULT '0' COMMENT '0：本地等级名；大于0：平台等级名id',  `is_platform_degree_icon1` tinyint(1) DEFAULT '0',  `is_platform_degree_name` tinyint(1) unsigned DEFAULT '0' COMMENT '0：本地等级名；大于0：平台等级名id',  `is_platform_degree_icon` tinyint(1) DEFAULT '0' COMMENT '0：本地等级图标；大于0：系统等级图标id',  `degree_icon_custom` varchar(200) DEFAULT '' COMMENT '等级自定义图标',  `condition_point` int(11) unsigned DEFAULT '0' COMMENT '条件积分',  `seller_reward_1` decimal(3,1) unsigned DEFAULT '0.0' COMMENT '一级分销商奖励比率',  `seller_reward_2` decimal(3,1) unsigned DEFAULT '0.0' COMMENT '二级分销商奖励比率',  `seller_reward_3` decimal(3,1) unsigned DEFAULT '0.0' COMMENT '三级分销商奖励比率',  `description` varchar(500) DEFAULT '' COMMENT '使用须知',  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0 禁用 1启用',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`pigcms_id`),  KEY `store_id` (`store_id`) USING BTREE,  KEY `degree_icon_id` (`is_platform_degree_name`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC",'des'=>'...'),


//2016-01-16 18:11:04
array('time'=>mktimes(1970,1,1,13,34),'type'=>'sql','sql'=>"insert into `{tableprefix}platform_drp_degree` (`pigcms_id`, `name`, `value`, `icon_id`, `icon`, `condition_point`, `description`, `status`, `add_time`) values('4','普通分销商','100','0','images/drp_degree_icon/4.png','0','','1','1452841604')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,13,33),'type'=>'sql','sql'=>"insert into `{tableprefix}platform_drp_degree` (`pigcms_id`, `name`, `value`, `icon_id`, `icon`, `condition_point`, `description`, `status`, `add_time`) values('3','铜牌分销商','200','0','images/drp_degree_icon/3.png','2','','1','1452841572')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,13,32),'type'=>'sql','sql'=>"insert into `{tableprefix}platform_drp_degree` (`pigcms_id`, `name`, `value`, `icon_id`, `icon`, `condition_point`, `description`, `status`, `add_time`) values('2','银牌分销商','300','0','images/drp_degree_icon/2.png','113','','1','0')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,13,31),'type'=>'sql','sql'=>"insert into `{tableprefix}platform_drp_degree` (`pigcms_id`, `name`, `value`, `icon_id`, `icon`, `condition_point`, `description`, `status`, `add_time`) values('1','金牌分销商','400','0','images/drp_degree_icon/1.png','33','','1','0')",'des'=>'...'),

//2016-01-16 18:14:24
array('time'=>mktimes(1970,1,1,13,30),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}platform_drp_degree` (  `pigcms_id` int(5) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '等级名称',  `value` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '等级值',  `icon_id` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '默认等级图标id(废弃)',  `icon` varchar(200) NOT NULL COMMENT '图标',  `condition_point` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '条件积分',  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '使用须知',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0 禁用 1启用',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`pigcms_id`),  UNIQUE KEY `name` (`name`) USING BTREE,  KEY `icon_id` (`icon_id`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC",'des'=>'...'),

//2016-01-16 16:13:04
array('time'=>mktimes(1970,1,1,13,22),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}share_link` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户UID',  `seller_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商店铺ID',  `user_type` enum('1','0') NOT NULL DEFAULT '0' COMMENT '用户积分状态,0:未加,1:已加',  `store_type` enum('1','0') NOT NULL DEFAULT '0' COMMENT '店铺积分状态,0:未加,1:已加',  PRIMARY KEY (`id`),  KEY `store_id` (`store_id`,`uid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户分享链接点击表'",'des'=>'...'),

//2016-01-16 16:12:35
array('time'=>mktimes(1970,1,1,13,21),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}order_point` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '主订单ID',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商ID',  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户UID',  `money` float(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分抵用的现金数',  `point` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所抵用的积分',  PRIMARY KEY (`id`),  KEY `order_id` (`order_id`),  KEY `store_id` (`store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-01-16 16:07:08
array('time'=>mktimes(1970,1,1,13,20),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user_points`ADD COLUMN `bak`  varchar(255) NULL COMMENT '备注' AFTER `timestamp`",'des'=>'...'),


//2016-01-16 15:00:18
array('time'=>mktimes(1970,1,1,13,19),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}subscribe_store` ADD  `is_leave` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '是否取消关注：0否 1是',ADD  `leave_time` INT NOT NULL COMMENT  '取消关注时间'",'des'=>'...'),

//2016-01-15 20:20:31
array('time'=>mktimes(1970,1,1,13,18),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}platform_drp_degree` CHANGE `icon_id` `icon_id` INT(5) UNSIGNED DEFAULT 0 NOT NULL COMMENT '默认等级图标id(废弃)', ADD COLUMN `icon` VARCHAR(200) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图标' AFTER `icon_id`",'des'=>'...'),


//2016-01-15 18:39:08
array('time'=>mktimes(1970,1,1,13,16),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES ('69', '12', '分销商等级', 'Store', 'drp_degree')",'des'=>'...'),


//2016-01-15 17:45:02
array('time'=>mktimes(1970,1,1,13,15),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}user` ADD  `sex` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '性别：1男 2女 0未知',ADD  `province` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '省份',ADD  `city` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '城市'",'des'=>'...'),


//2016-01-14 13:46:28
array('time'=>mktimes(1970,1,1,13,13),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}user` ADD  `sex` TINYINT( 2 ) NOT NULL DEFAULT  '0' COMMENT  '性别：1男 2女 0未知',ADD  `province` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '省份',ADD  `city` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '城市'",'des'=>'...'),

//2016-01-14 13:42:37
array('time'=>mktimes(1970,1,1,13,12),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}source_material` CHANGE `it_ids` `it_ids` VARCHAR( 500 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图文表id集合'",'des'=>'...'),


//2016-01-13 12:50:10
array('time'=>mktimes(1970,1,1,13,11),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}wei_page` ADD COLUMN `show_head` TINYINT(1) DEFAULT 1 NULL COMMENT '是否显示头部,1：显示，2：不显示' AFTER `has_custom`, ADD COLUMN `show_footer` TINYINT(1) DEFAULT 1 NULL COMMENT '是否显示头部,1：显示，2：不显示' AFTER `show_head`",'des'=>'...'),

//2016-01-12 11:45:59
array('time'=>mktimes(1970,1,1,13,9),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_user_data`ADD COLUMN `degree_id`  int(11) NOT NULL DEFAULT 0 COMMENT '会员所属等级' AFTER `sign_date`,ADD COLUMN `degree_date`  int(11) NOT NULL DEFAULT 0 COMMENT '用户等级到期时间，0表示未统计' AFTER `degree_id`",'des'=>'...'),

//2016-01-12 10:22:41
array('time'=>mktimes(1970,1,1,13,8),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product`ADD COLUMN `point`  int(10) NULL DEFAULT 0 COMMENT '会员特权，额外赠送积分' AFTER `pro_weight`,ADD COLUMN `discount`  float(8,2) NULL DEFAULT 0 COMMENT '会员等级特权享受的折扣，优先于等级折扣，0表示没有特权折扣' AFTER `point`",'des'=>'...'),

//2016-01-11 20:29:08
array('time'=>mktimes(1970,1,1,13,7),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}product_discount` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `product_id` int(11) DEFAULT NULL,  `store_id` int(11) DEFAULT NULL,  `degree_name` varchar(200) DEFAULT NULL COMMENT '等级名称',  `discount` double(3,1) NOT NULL DEFAULT '10.0' COMMENT '折扣10.0 为不打折',  `degree_id` int(11) DEFAULT NULL COMMENT '对应等级id',  `timestamp` int(11) DEFAULT NULL COMMENT '最近操作的时间戳',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-01-11 20:28:52
array('time'=>mktimes(1970,1,1,13,6),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `check_give_points` TINYINT(1) DEFAULT 0 NULL COMMENT '是否启用额外赠送会员积分（0：未启用，1：启用中）' AFTER `is_whitelist`, ADD COLUMN `check_degree_discount` TINYINT(1) DEFAULT 0 NULL COMMENT '是否启用额外会员等级优惠（0：未启用，1：启用中）' AFTER `check_give_points`, ADD COLUMN `give_points` INT(11) NULL COMMENT '额外赠送会员积分' AFTER `check_degree_discount`",'des'=>'...'),

//2016-01-09 9:18:56
array('time'=>mktimes(1970,1,1,13,4),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_points` (      `id` int(11) NOT NULL AUTO_INCREMENT,      `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',      `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分所属供货商店铺id',      `drp_store_id` int(11) NOT NULL DEFAULT '0' COMMENT '分销商店铺id',      `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分来源的订单',      `share_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分来源的分享记录',      `points` int(11) NOT NULL DEFAULT '0' COMMENT '获取积分数',      `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '积分来源 - 1:发展分销商送 2:销售额比例生成 3:分享送 4:签到送 5:推广增加',      `is_available` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用：0：不可以用，1可以使用',      `is_call_to_fans` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:不发送；1发送通知粉丝获得积分',      `timestamp` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',    PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-01-09 9:18:22
array('time'=>mktimes(1970,1,1,13,3),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}user_points` (      `id` int(11) NOT NULL AUTO_INCREMENT,      `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',      `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分所属供货商店铺id',      `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分来源的订单',      `share_id` int(11) NOT NULL DEFAULT '0' COMMENT '积分来源的分享记录',      `points` int(11) NOT NULL DEFAULT '0' COMMENT '获取积分数',      `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '积分来源 - 1:关注公众号送 2:订单满送 3:消费送 4:分享送 5:签到送 6:买特殊商品所送 7:手动增加 8:推广增加',      `is_available` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可用：0：不可以用，1可以使用',      `is_call_to_fans` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:不发送；1发送通知粉丝获得积分',      `timestamp` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',    PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-01-08 18:30:59
array('time'=>mktimes(1970,1,1,13,2),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_user_data`ADD COLUMN `store_point`  int(11) NOT NULL DEFAULT 0 COMMENT '用户分销商店铺的积分（可消费）' AFTER `point_count`,ADD COLUMN `store_point_count`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户分销商店铺的积分（不可消费）' AFTER `store_point`,ADD COLUMN `sign_days`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '连续签到天数' AFTER `order_complete`,ADD COLUMN `sign_date`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上次签到日期，格式：年月日' AFTER `sign_days`",'des'=>'...'),

//2016-01-06 18:50:09
array('time'=>mktimes(1970,1,1,12,59),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_promote_setting` ADD `media_id` CHAR( 200 ) NOT NULL COMMENT '微信附件id'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,12,58),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_promote_setting` ADD `promote_qrcode` VARCHAR( 150 ) NOT NULL COMMENT '推广图片地址'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,12,57),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}qrcode_record` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) NOT NULL COMMENT '店铺id',  `openid` char(60) NOT NULL COMMENT '身份id',  `record_time` char(15) NOT NULL COMMENT '记录时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2016-01-07 15:54:46
array('time'=>mktimes(1970,1,1,12,56),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`key`, `value`, `bak`) VALUES ('total', '0', '总收款')",'des'=>'...'),

//2016-01-07 15:54:38
array('time'=>mktimes(1970,1,1,12,55),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`key`, `value`, `bak`) VALUES ('withdrawal', '0', '已提现')",'des'=>'...'),

//2016-01-07 15:54:28
array('time'=>mktimes(1970,1,1,12,54),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}common_data` (`key`, `value`, `bak`) VALUES ('income', '0', '平台收入')",'des'=>'...'),

//2016-01-07 15:54:17
array('time'=>mktimes(1970,1,1,12,53),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `sales`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '销售额' AFTER `date_edited`",'des'=>'...'),

//2016-01-07 15:54:05
array('time'=>mktimes(1970,1,1,12,52),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}supp_dis_relation`ADD COLUMN `profit`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '经销商批发利润'",'des'=>'...'),

//2016-01-07 15:53:54
array('time'=>mktimes(1970,1,1,12,51),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}supp_dis_relation`ADD COLUMN `return_owe`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '退货欠供货商金额'",'des'=>'...'),

//2016-01-07 15:53:33
array('time'=>mktimes(1970,1,1,12,50),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_withdrawal`ADD COLUMN `bak`  varchar(500) NOT NULL COMMENT '备注'",'des'=>'...'),

//2016-01-07 15:52:38
array('time'=>mktimes(1970,1,1,12,49),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}supp_dis_relation`ADD COLUMN `not_paid`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '未支付' AFTER `phone`,ADD COLUMN `paid`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '已支付' AFTER `not_paid`",'des'=>'...'),

//2016-01-07 15:52:09
array('time'=>mktimes(1970,1,1,12,48),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_withdrawal`ADD COLUMN `type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT ' 0 分销商提现，1 供货商提现' AFTER `sales_ratio`",'des'=>'...'),

//2016-01-07 15:51:42
array('time'=>mktimes(1970,1,1,12,47),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `store_pay_income`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺收款总额' AFTER `unbalance`",'des'=>'...'),

//2016-01-07 15:50:10
array('time'=>mktimes(1970,1,1,12,46),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_withdrawal`ADD COLUMN `sales_ratio`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '平台服务费' AFTER `complate_time`",'des'=>'...'),

//2016-01-07 15:49:20
array('time'=>mktimes(1970,1,1,12,45),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `sale_total`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '自营商品销售总额' AFTER `total`",'des'=>'...'),

//2016-01-06 18:43:10
array('time'=>mktimes(1970,1,1,12,44),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}subtype` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) DEFAULT NULL COMMENT '专题类目的店铺id',  `typename` varchar(200) NOT NULL COMMENT '专题名称',  `typepic` varchar(200) DEFAULT NULL COMMENT '专题图片',  `px` int(11) NOT NULL DEFAULT '0' COMMENT '排序',  `status` tinyint(1) DEFAULT '1' COMMENT '是否开启(0:关闭；1:开启)',  `topid` smallint(5) DEFAULT NULL COMMENT '顶级栏目id',  `upid` smallint(5) DEFAULT NULL COMMENT '上级栏目id',  `timtstamp` int(11) DEFAULT NULL COMMENT '最近操作的时间戳',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='专题栏目表'",'des'=>'...'),

//2016-01-06 18:42:40
array('time'=>mktimes(1970,1,1,12,43),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}subject_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `product_id` int(11) DEFAULT NULL COMMENT '对应产品id',  `piclist` text COMMENT '专题关联产品对应的图片',  `subject_id` int(11) DEFAULT NULL COMMENT '关联的专题id',  `store_id` int(11) DEFAULT NULL COMMENT '对应的店铺',  `timestamp` int(11) DEFAULT NULL COMMENT '操作的时间戳',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='专题关联产品表'",'des'=>'...'),

//2016-01-06 18:42:20
array('time'=>mktimes(1970,1,1,12,42),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}subject_comment` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) DEFAULT NULL COMMENT '评论者uid',  `store_id` int(11) DEFAULT NULL COMMENT '被评论的 商铺id',  `top_store_id` int(11) DEFAULT NULL COMMENT '供货商店铺id',  `subject_id` int(11) DEFAULT NULL COMMENT '专题id',  `content` text COMMENT '评论的内容',  `is_show` tinyint(1) DEFAULT '1' COMMENT '是否显示0:不显示 1:显示',  `timestamp` int(11) DEFAULT NULL COMMENT '操作的时间戳',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-01-06 18:41:39
array('time'=>mktimes(1970,1,1,12,41),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}subject` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(200) NOT NULL COMMENT '图文专题名称',  `pic` varchar(200) DEFAULT NULL COMMENT '图片',  `description` text COMMENT '图文专题描述内容',  `show_index` tinyint(1) DEFAULT '1' COMMENT '是否首页显示',  `store_id` int(11) DEFAULT NULL COMMENT '关联的店铺id',  `subject_typeid` int(11) DEFAULT NULL COMMENT '所属专题分类',  `dz_count` int(11) DEFAULT NULL COMMENT '点赞总数',  `px` int(11) DEFAULT NULL COMMENT '排序',  `timestamp` int(11) DEFAULT NULL COMMENT '操作的时间戳',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='专题表'",'des'=>'...'),

//2016-01-06 18:41:18
array('time'=>mktimes(1970,1,1,12,40),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_subject_data` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) DEFAULT NULL,  `subject_id` int(11) DEFAULT NULL COMMENT '指定专题',  `dz_count` int(11) DEFAULT '0' COMMENT '专题点赞总数',  `share_count` int(11) DEFAULT '0' COMMENT '分享次数',  `pinlun_count` int(11) DEFAULT '0' COMMENT '评论数',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2016-01-05 13:35:38
array('time'=>mktimes(1970,1,1,12,39),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}activity_spread` ADD  `product_id` INT NOT NULL DEFAULT  '0' COMMENT  '关联产品id',ADD  `sku_id` INT NOT NULL DEFAULT  '0' COMMENT  '关联产品规格id'",'des'=>'...'),

//2015-12-29 10:11:37
array('time'=>mktimes(1970,1,1,12,38),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product`ADD COLUMN `recommend_title`  varchar(15) NULL DEFAULT '' COMMENT '推荐语' AFTER `is_recommend`",'des'=>'...'),


//2015-12-25 9:29:32
array('time'=>mktimes(1970,1,1,12,37),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}ucenter`ADD COLUMN `promotion_content`  text CHARACTER SET utf8 NOT NULL COMMENT '个人中心推广内容' ,ADD COLUMN `member_content`  text CHARACTER SET utf8 NOT NULL COMMENT '会员内容' ,ADD COLUMN `promotion_field`  varchar(250) NOT NULL AFTER `member_content`,ADD COLUMN `consumption_field`  varchar(250) CHARACTER SET utf8 NOT NULL COMMENT '消费中心字段' ,ADD COLUMN `tab_name`  text CHARACTER SET utf8 NOT NULL COMMENT '个人中心tab切换'",'des'=>'...'),


//2015-12-24 13:30:24
array('time'=>mktimes(1970,1,1,12,36),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}order_friend_address` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  `order_id` varchar(100) NOT NULL COMMENT '订单ID',  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户UID',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',  `name` varchar(100) NOT NULL COMMENT '收货人姓名',  `phone` varchar(20) NOT NULL COMMENT '收货人电话',  `pro_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '产品数量',  `address` varchar(1024) DEFAULT NULL COMMENT '省市县序列化',  `package_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '包裹ID', `package_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '包裹创建时间',  `default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是默认收货地址，0：否，1：是', `openid` varchar(256) NOT NULL COMMENT '用户openid,用户唯一领取用',  PRIMARY KEY (`id`),  KEY `order_id` (`order_id`),  KEY `openid` (`openid`)) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-12-23 9:00:21
array('time'=>mktimes(1970,1,1,12,35),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `send_other_comment`  varchar(1024) CHARACTER SET utf8 NULL COMMENT '送他人，赠言' AFTER `send_other_hour`",'des'=>'...'),

//2015-12-23 8:59:49
array('time'=>mktimes(1970,1,1,12,34),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `send_other_number`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '送他人送的份数' AFTER `send_other_type`,ADD COLUMN `send_other_per_number`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '送他人，每份的数量' AFTER `send_other_number`",'des'=>'...'),

//2015-12-22 17:00:03
array('time'=>mktimes(1970,1,1,12,33),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order` ADD  `activity_orderid` VARCHAR( 100 ) NOT NULL COMMENT  '活动唯一订单id(砍价)'",'des'=>'...'),

//2015-12-22 17:00:00
array('time'=>mktimes(1970,1,1,12,32),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order` ADD  `activity_id` INT NOT NULL COMMENT  '对接活动id',ADD  `activity_type` VARCHAR( 50 ) NOT NULL COMMENT  '对接活动类型'",'des'=>'...'),

//2015-12-22 16:59:20
array('time'=>mktimes(1970,1,1,12,30),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}activity_spread` ADD  `keyword` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '活动关键词'",'des'=>'...'),

//2015-12-18 15:26:53
array('time'=>mktimes(1970,1,1,12,29),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `send_other_hour`  smallint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '送他人订单时，领取有效时间，单位：小时' AFTER `send_other_type`",'des'=>'...'),

//2015-12-18 15:21:09
array('time'=>mktimes(1970,1,1,12,28),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `send_other_type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '当shipping_method值为other_friend,送他人类型，0:默认值，1：送单人，2：送公益，3：送多人' AFTER `shipping_method`",'des'=>'...'),

//2015-12-16 9:46:31
array('time'=>mktimes(1970,1,1,12,27),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product`ADD COLUMN `send_other`  enum('0','1') NOT NULL DEFAULT '0' COMMENT '产品是否可以送他人,0:否，1：是' AFTER `image_size`,ADD COLUMN `send_other_postage`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '送他人统一邮费' AFTER `send_other`",'des'=>'...'),

//2015-12-14 9:02:21
array('time'=>mktimes(1970,1,1,12,26),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}activity_spread` (  `pigcms_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'pigcms_id',  `modelId` int(10) NOT NULL COMMENT '活动id',  `model` char(20) NOT NULL COMMENT '活动类型',  `title` varchar(500) NOT NULL COMMENT '活动标题',  `info` varchar(2000) NOT NULL COMMENT '活动简介',  `image` varchar(200) NOT NULL COMMENT '活动图片地址',  `token` char(50) NOT NULL COMMENT 'token',  `qcode` varchar(200) NOT NULL COMMENT '临时二维码地址',  `addtime` int(11) NOT NULL COMMENT '添加时间',  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='活动推广-参数二维码' AUTO_INCREMENT=1",'des'=>'...'),

//2015-12-12 17:25:09
array('time'=>mktimes(1970,1,1,12,25),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `receive_time`  int(11) NOT NULL DEFAULT 0 COMMENT '货到付款时，收款时间' AFTER `delivery_time`",'des'=>'...'),

//2015-12-12 15:25:28
array('time'=>mktimes(1970,1,1,12,24),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_group`MODIFY COLUMN `group_label`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品标签简介' AFTER `buy_button_style`",'des'=>'...'),

//2015-12-11 17:19:54
array('time'=>mktimes(1970,1,1,12,23),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `canal_qrcode_img`  varchar(500) CHARACTER SET utf8 NOT NULL COMMENT '分销渠道二维码图片',ADD COLUMN `canal_qrcode_tpl`  varchar(500) CHARACTER SET utf8 NOT NULL COMMENT '渠道二维码消息模版'",'des'=>'...'),

//2015-12-11 15:04:56
array('time'=>mktimes(1970,1,1,12,22),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `setting_canal_qrcode`  tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '设置渠道二维码'",'des'=>'...'),

//2015-12-11 10:41:00
array('time'=>mktimes(1970,1,1,12,21),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('116', 'pay_weixin_app_key', 'type=text&size=80', '', 'Key', '商户支付密钥Key。审核通过后，在微信发送的邮件中查看。', 'weixinapp', 'APP微信支付', '7', '0', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,12,20),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('115', 'pay_weixin_app_mchid', 'type=text&size=80', '', 'Mchid', '受理商ID，身份标识', 'weixinapp', 'APP微信支付', '7', '0', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,12,19),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES ('114', 'pay_weixin_app_appid', 'type=text&size=80', '', 'Appid', '微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看。', 'weixinapp', 'APP微信支付', '7', '0', '1')",'des'=>'...'),

//2015-12-09 10:12:23
array('time'=>mktimes(1970,1,1,12,18),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_promote_setting` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自定义页面id',  `store_id` int(11) unsigned NOT NULL COMMENT '店铺ID',  `title` varchar(50) NOT NULL COMMENT '页面自定义标题',  `content` varchar(255) NOT NULL COMMENT '页面自定义简介',  `image` varchar(255) NOT NULL COMMENT '背景图片',  `description` varchar(50) NOT NULL COMMENT '页面自定义描述',  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',  `update_time` int(11) unsigned NOT NULL COMMENT '修改时间',  PRIMARY KEY (`pigcms_id`)) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-12-05 11:42:41
array('time'=>mktimes(1970,1,1,12,17),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_system_notice_manage` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',  `has_power` varchar(250) DEFAULT NULL COMMENT '拥有的权限,例:88^1,2|  88表示模板消息id, 1代表拥有短信 2代表拥有微信通知权限',  `timestamp` int(11) DEFAULT NULL COMMENT '最近修改的时间戳',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='店铺短信/通知权限表'",'des'=>'...'),

//2015-12-05 11:42:07
array('time'=>mktimes(1970,1,1,12,16),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_notice_manage` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) DEFAULT NULL COMMENT '店铺id',  `has_power` varchar(250) DEFAULT NULL COMMENT '拥有的权限,例:88^1,2|  88表示模板消息id, 1代表拥有短信 2代表拥有微信通知权限',  `timestamp` int(11) DEFAULT NULL COMMENT '最近修改的时间戳',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='店铺短信/通知权限表'",'des'=>'...'),


//2015-12-02 17:31:36
array('time'=>mktimes(1970,1,1,12,15),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES(113, 'im_url', 'type=text&validate=url:true', '', '交友聊天系统URL','交友聊天系统URL，如需绑定域名，请将域名cname指向到?im-link.meihua.com', '0', '', 1, 0, 1)",'des'=>'...'),

//2015-11-27 13:31:36
array('time'=>mktimes(1970,1,1,12,14),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user_points_record` ADD COLUMN `money` DOUBLE(10,2) DEFAULT 0.00 NULL COMMENT '变更金额' AFTER `timestamp`",'des'=>'...'),

//2015-11-27 11:11:43
array('time'=>mktimes(1970,1,1,12,13),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_orderprint_machine` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) NOT NULL COMMENT '店铺id',  `mobile` char(20) DEFAULT NULL COMMENT '绑定手机号',  `username` varchar(250) DEFAULT NULL COMMENT '绑定帐号',  `terminal_number` varchar(250) DEFAULT NULL COMMENT '终端号',  `keys` varchar(250) DEFAULT NULL COMMENT '密钥',  `counts` int(11) NOT NULL DEFAULT '0' COMMENT '打印份数',  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '打印类型:1.只打印付过款的,2:无论是否付款都打印',  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启:0.关闭，1.开启',  `timestamp` int(11) DEFAULT NULL COMMENT '保存/修改的 时间戳',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商铺订单打印机'",'des'=>'...'),

//2015-11-27 9:56:24
array('time'=>mktimes(1970,1,1,12,12),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}order_discount` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID（供货商店铺ID）',  `discount` double(3,1) NOT NULL DEFAULT '10.0' COMMENT '折扣',  `is_postage_free` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包邮，1：是包邮，0：不包邮',  `postage_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',  UNIQUE KEY `id` (`id`),  KEY `order_id` (`order_id`),  KEY `store_id` (`store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单折扣表'",'des'=>'...'),

//2015-11-27 9:54:49
array('time'=>mktimes(1970,1,1,12,11),'type'=>'sql','sql'=>"update {tableprefix}store set drp_diy_store = 0 where drp_level > 0",'des'=>'...'),

//2015-11-26 10:36:59
array('time'=>mktimes(1970,1,1,12,10),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `is_whitelist`  int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否是白名单商品'",'des'=>'...'),

//2015-11-26 10:32:30
array('time'=>mktimes(1970,1,1,12,9),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}product_whitelist` (  `pigcms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',  `supplier_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '供货商id',  `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '经销商id',  `sales` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '经销商销量',  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '加入白名单时间',  PRIMARY KEY (`pigcms_id`),  KEY `product_id` (`product_id`,`supplier_id`) USING BTREE,  KEY `seller_id` (`seller_id`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED",'des'=>'...'),

//2015-11-24 15:04:11
array('time'=>mktimes(1970,1,1,12,8),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD COLUMN `app_openid`  varchar(50) NULL COMMENT 'app端微信唯一标识' AFTER `openid`, ADD INDEX (`openid`) USING BTREE , ADD INDEX (`app_openid`) USING BTREE",'des'=>'...'),

//2015-11-23 15:11:10
array('time'=>mktimes(1970,1,1,12,7),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}activity_recommend` ADD  `price` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '价格',ADD  `endtime` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '结束时间',ADD  `type` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '抽奖类型',ADD  `original_price` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '原价'",'des'=>'...'),

//2015-11-23 13:35:07
array('time'=>mktimes(1970,1,1,12,6),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}user_points_record` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) DEFAULT NULL COMMENT '用户uid',  `store_id` int(11) DEFAULT NULL COMMENT '获取积分的 来源商铺id',  `order_id` int(11) DEFAULT NULL COMMENT '赠送积分来源的订单',  `points` int(11) DEFAULT NULL COMMENT '获取积分数',  `type` tinyint(1) DEFAULT NULL COMMENT '获取积分方式：1:关注我的微信；2:成功交易数量；3:购买金额达到多少,5:满减送送的积分',  `is_available` tinyint(1) DEFAULT '1' COMMENT '是否可用：0：不可以用，1可以使用',  `is_call_to_fans` tinyint(1) DEFAULT NULL COMMENT '0:不发送；1发送通知粉丝获得积分',  `timestamp` int(11) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-11-23 9:56:12
array('time'=>mktimes(1970,1,1,12,5),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `unified_profit`  tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否统一直销利润'",'des'=>'...'),

//2015-11-20 18:17:37
array('time'=>mktimes(1970,1,1,12,4),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}points` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) DEFAULT NULL,  `store_id` int(11) DEFAULT NULL COMMENT '积分店铺id',  `points` int(11) DEFAULT NULL COMMENT '积分数',  `type` tinyint(1) DEFAULT NULL COMMENT '给积分类别: 1:关注我的微信,2:每成功交易笔数, 3:每购买金额多少元',  `trade_or_amount` int(11) DEFAULT NULL COMMENT '当type=2:为交易笔数值,type=3：为购买金额数',  `is_call_to_fans` tinyint(1) DEFAULT NULL COMMENT '是否通知粉丝',  `starttime` int(2) DEFAULT NULL COMMENT '开始时间 整点',  `endtime` int(2) DEFAULT NULL COMMENT '结束时间 整点',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:关闭,1开启',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-11-18 17:32:01
array('time'=>mktimes(1970,1,1,12,3),'type'=>'sql','sql'=>"insert into `{tableprefix}order_printing_template` (`id`, `typename`, `folder`, `filename`, `text`, `timestamp`, `status`) values('2','配货单','order_print','invoice.php','','1412456111','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,12,2),'type'=>'sql','sql'=>"insert into `{tableprefix}order_printing_template` (`id`, `typename`, `folder`, `filename`, `text`, `timestamp`, `status`) values('1','购物清单 ','order_print','shopper.php','','1412456123','1')",'des'=>'...'),

//2015-11-18 17:31:50
array('time'=>mktimes(1970,1,1,12,1),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}order_printing_template` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `typename` varchar(50) NOT NULL COMMENT '系统模板类型名',  `folder` varchar(200) DEFAULT NULL COMMENT '系统模板所在static下的文件夹',  `filename` varchar(200) NOT NULL COMMENT '调用的系统模板名',  `text` longtext COMMENT '系统模板具体内容',  `timestamp` int(11) NOT NULL COMMENT '操作的时间戳',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '模板状态开启:1/关闭:0',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-11-17 11:37:54
array('time'=>mktimes(1970,1,1,12,0),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product`MODIFY COLUMN `profit`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '分销单件商品利润'",'des'=>'...'),

//2015-11-17 9:06:24
array('time'=>mktimes(1970,1,1,11,59),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_printing_order_template` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(11) DEFAULT NULL COMMENT '订单模版所属店铺',  `text` longtext COMMENT '订单模版内容',  `typeid` int(11) DEFAULT NULL COMMENT '模版所属类型',  `timestamp` int(11) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-11-13 15:13:01
array('time'=>mktimes(1970,1,1,11,58),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order` ADD  `has_physical_send` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '是否有门店配送项:0无 1有'",'des'=>'...'),

//2015-11-13 13:35:17
array('time'=>mktimes(1970,1,1,11,57),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `storePay`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '收款店铺id' AFTER `useStorePay`,ADD INDEX (`storePay`) USING BTREE",'des'=>'...'),

//2015-11-13 13:35:10
array('time'=>mktimes(1970,1,1,11,56),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `use_deposit_pay`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否满足保证金扣款' AFTER `activity_data`",'des'=>'...'),

//2015-11-13 13:34:57
array('time'=>mktimes(1970,1,1,11,55),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_withdrawal`ADD COLUMN `supplier_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '供货商id' AFTER `store_id`",'des'=>'...'),

//2015-11-09 17:54:27
array('time'=>mktimes(1970,1,1,11,54),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}bond_record` (  `bond_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',  `order_no` varchar(50) NOT NULL DEFAULT '0' COMMENT '主订单号',  `transaction_no` varchar(50) NOT NULL DEFAULT '0' COMMENT '交易单号',  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品最终供货商id',  `wholesale_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品经销商',  `add_time` varchar(50) NOT NULL DEFAULT '0' COMMENT '记录生成时间',  `status` tinyint(6) NOT NULL DEFAULT '0' COMMENT '状态  0 进行中 1 交易完成 2 退款',  `deduct_bond` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '扣除的保证金',  `residue_bond` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '剩余的保证金',  PRIMARY KEY (`bond_id`)) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8",'des'=>'...'),


//2015-11-07 10:08:24
array('time'=>mktimes(1970,1,1,11,52),'type'=>'sql','sql'=>"UPDATE `{tableprefix}config` SET `type`='',`value`='',`status` = '0' WHERE `name` ='weidian_version_type'",'des'=>'...'),


//2015-11-06 16:16:29
array('time'=>mktimes(1970,1,1,11,51),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}_store` ADD COLUMN `margin_minimum`float(10,2) NOT NULL DEFAULT '0' COMMENT '保证金最低额度'",'des'=>'...'),

//2015-11-05 17:31:13
array('time'=>mktimes(1970,1,1,11,50),'type'=>'sql','sql'=>"UPDATE {tableprefix}store SET setting_fans_forever =0 WHERE setting_fans_forever =1",'des'=>'...'),

//2015-11-06 16:14:31
array('time'=>mktimes(1970,1,1,11,49),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}_store` ADD COLUMN `margin_amount`tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启保证金最低额度提醒'",'des'=>'...'),


//2015-11-05 16:42:56
array('time'=>mktimes(1970,1,1,11,48),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}financial_record`ADD COLUMN `return_id`  int(11) UNSIGNED NULL DEFAULT 0 COMMENT '退货id' AFTER `bak`,ADD INDEX (`return_id`) USING BTREE",'des'=>'...'),

//2015-11-05 16:14:20
array('time'=>mktimes(1970,1,1,11,47),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `openid` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信唯一标识 (关联绑定公众号)' AFTER  `qcode`",'des'=>'...'),

//2015-11-05 15:48:46
array('time'=>mktimes(1970,1,1,11,46),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `public_display` TINYINT(1) DEFAULT 1 NULL COMMENT '开启后将会在微信综合商城 和 pc综合商城展示 0：不展示，1：展示' AFTER `status`",'des'=>'...'),


//2015-11-05 15:15:40
array('time'=>mktimes(1970,1,1,11,45),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store_user_data`MODIFY COLUMN `point`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺返还积分(有消耗)' AFTER `uid`,MODIFY COLUMN `point_count`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺返还总积分(无消耗)' AFTER `point`,MODIFY COLUMN `order_unpay`  mediumint(9) UNSIGNED NOT NULL DEFAULT 0 COMMENT '未付款订单数' AFTER `point_count`,MODIFY COLUMN `order_unsend`  mediumint(9) UNSIGNED NOT NULL DEFAULT 0 COMMENT '未发货订单数' AFTER `order_unpay`,MODIFY COLUMN `order_send`  mediumint(9) UNSIGNED NOT NULL DEFAULT 0 COMMENT '已发货订单数' AFTER `order_unsend`,MODIFY COLUMN `order_complete`  mediumint(9) UNSIGNED NOT NULL DEFAULT 0 COMMENT '交易完成订单数' AFTER `order_send`,ADD COLUMN `money`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '店铺消费总金额' AFTER `point_count`",'des'=>'...'),

//2015-11-05 15:06:46
array('time'=>mktimes(1970,1,1,11,44),'type'=>'sql','sql'=>"UPDATE `{tableprefix}config` SET `type`='type=text&validate=required:false'  WHERE `name`='bbs_url' OR `value`='type=text&validate=required:false'",'des'=>'...'),


//2015-11-03 17:44:05
array('time'=>mktimes(1970,1,1,11,43),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}margin_recharge_log` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '充值记录id',  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '收款方店铺id',  `distributor_id` int(11) NOT NULL DEFAULT '0' COMMENT '打款方店铺id',  `bank_id` int(11) NOT NULL DEFAULT '0' COMMENT '开户银行',  `bank_card` varchar(30) NOT NULL DEFAULT '0' COMMENT '银行卡号',  `bank_card_user` varchar(20) NOT NULL DEFAULT '0' COMMENT '开卡人姓名',  `opening_bank` varchar(30) NOT NULL DEFAULT '0' COMMENT '开户行',  `phone` varchar(20) NOT NULL DEFAULT '0' COMMENT '打款人手机号',  `apply_recharge` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '充值额度',  `add_time` varchar(30) NOT NULL DEFAULT '0' COMMENT '充值时间',  `status` tinyint(5) NOT NULL DEFAULT '0' COMMENT '0 未确认 1 已确认',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-11-03 17:42:52
array('time'=>mktimes(1970,1,1,11,42),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}supp_dis_relation` (  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '关系表id',  `supplier_id` int(11) NOT NULL COMMENT '供货商ID',  `distributor_id` int(11) NOT NULL COMMENT '经销商ID（批发商ID）',  `authen` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 未认证 1 认证中 2 已认证',  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '认证通过时间',  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',  `bond` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金剩余额度',  `apply_recharge` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '申请充值额度',  `bank_id` int(5) NOT NULL DEFAULT '0' COMMENT '开户银行',  `bank_card` varchar(30) NOT NULL DEFAULT '0' COMMENT '银行卡号',  `bank_card_user` varchar(30) NOT NULL DEFAULT '0' COMMENT '开卡人姓名',  `opening_bank` varchar(30) DEFAULT '0' COMMENT '开户行',  `phone` varchar(20) NOT NULL DEFAULT '0' COMMENT '打款人手机号',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-11-03 17:16:13
array('time'=>mktimes(1970,1,1,11,41),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `bond`float(10,2) NOT NULL DEFAULT '0.00' COMMENT '保证金额度'",'des'=>'...'),

//2015-11-03 17:15:07
array('time'=>mktimes(1970,1,1,11,40),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `is_required_margin`tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要审核交纳保证金(默认不需要)'",'des'=>'...'),

//2015-11-03 17:09:58
array('time'=>mktimes(1970,1,1,11,39),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `is_required_to_audit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否需要审核批发商(默认不允许)'",'des'=>'...'),

//2015-10-21 18:04:17
array('time'=>mktimes(1970,1,1,11,38),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product`ADD COLUMN `profit`  decimal(10,0) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销单件商品利润'",'des'=>'...'),

//2015-11-04 13:57:10
array('time'=>mktimes(1970,1,1,11,37),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES (67, 12, '认证自定义表单', 'Store', 'diyAttestation', 0, 1, 1)",'des'=>'...'),


//2015-11-03 18:47:10
array('time'=>mktimes(1970,1,1,11,36),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `warn_sp_quantity` INT( 8 ) NOT NULL DEFAULT  '0' COMMENT  '门店库存报警：0为不报警' AFTER  `open_local_logistics`",'des'=>'...'),

//2015-10-31 15:25:26
array('time'=>mktimes(1970,1,1,11,35),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `is_show_drp_tel` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '供货商设定的分销商店铺是显示分销商电话:0，供货商电话:1' AFTER `reg_drp_subscribe_tpl`",'des'=>'...'),

//2015-10-30 11:55:28
array('time'=>mktimes(1970,1,1,11,34),'type'=>'sql','sql'=>"alter table {tableprefix}store add `setting_fans_forever` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝是否终身制'",'des'=>'...'),

//2015-10-29 18:12:02
array('time'=>mktimes(1970,1,1,11,33),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order_package` ADD  `send_time` INT NOT NULL DEFAULT  '0' COMMENT  '配送员开始配送时间',ADD  `arrive_time` INT NOT NULL DEFAULT  '0' COMMENT  '配送员送达时间'",'des'=>'...'),

//2015-10-29 10:22:45
array('time'=>mktimes(1970,1,1,11,31),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `public_display` TINYINT(1) DEFAULT 1 NOT NULL COMMENT '开启后将会在微信综合商城和pc综合商城展示,0不展示1展示'",'des'=>'...'),

//2015-10-29 10:08:48
array('time'=>mktimes(1970,1,1,11,30),'type'=>'sql','sql'=>"ALTER TABLE {tableprefix}store add `is_official_shop` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为官方店铺'",'des'=>'...'),

//2015-10-21 18:04:17
array('time'=>mktimes(1970,1,1,11,29),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product`ADD COLUMN `profit`  decimal(10,0) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销单件商品利润'",'des'=>'...'),

//2015-10-23 15:18:57
array('time'=>mktimes(1970,1,1,11,28),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store_physical_courier` ADD  `location_time` INT NOT NULL COMMENT  '最后上报坐标时间'",'des'=>'...'),

//2015-10-23 15:18:48
array('time'=>mktimes(1970,1,1,11,27),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store_physical_courier` ADD  `long` DECIMAL( 10, 6 ) NOT NULL COMMENT  '配送员 经度' AFTER  `status` ,ADD  `lat` DECIMAL( 10, 6 ) NOT NULL COMMENT  '配送员 纬度' AFTER  `long`",'des'=>'...'),

//2015-10-21 17:28:45
array('time'=>mktimes(1970,1,1,11,26),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}comment` ADD  `store_id` INT NOT NULL DEFAULT  '0' AFTER  `uid`",'des'=>'...'),

//2015-10-20 9:05:00
array('time'=>mktimes(1970,1,1,11,25),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}product_sku` ADD  `weight` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '相应规格的重量' AFTER  `price`",'des'=>'...'),

//2015-10-19 14:59:21
array('time'=>mktimes(1970,1,1,11,24),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}store_physical_courier` (  `courier_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',  `name` char(50) NOT NULL COMMENT '配送员名称',  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别(默认1)：0女 1男',  `avatar` char(150) NOT NULL COMMENT '客服头像',  `tel` char(20) NOT NULL COMMENT '手机号',  `openid` char(60) NOT NULL COMMENT '绑定openid',  `store_id` int(11) NOT NULL COMMENT '所属店铺',  `physical_id` int(11) NOT NULL COMMENT '所属门店',  `status` tinyint(4) NOT NULL COMMENT '配送员状态：0关闭 1启用',  `add_time` int(11) NOT NULL COMMENT '添加时间',  PRIMARY KEY (`courier_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='本地化物流-配送员' AUTO_INCREMENT=1",'des'=>'...'),

//2015-10-19 14:58:58
array('time'=>mktimes(1970,1,1,11,23),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `open_local_logistics` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '是否使用本地化物流: 0否 1是' AFTER  `open_autoassign`",'des'=>'...'),

//2015-10-19 9:57:06
array('time'=>mktimes(1970,1,1,11,22),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_package` ADD COLUMN `order_products`  varchar(500) NOT NULL DEFAULT '' COMMENT '订单商品集合'",'des'=>'...'),

//2015-10-19 10:58:18
array('time'=>mktimes(1970,1,1,11,21),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}user_degree` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) DEFAULT NULL,  `store_id` int(11) DEFAULT NULL,  `name` varchar(600) DEFAULT NULL,  `level_pic` varchar(600) DEFAULT NULL,  `rule_type` varchar(33) DEFAULT NULL,  `level_num` int(11) DEFAULT NULL,  `discount` double DEFAULT NULL,  `is_postage_free` tinyint(1) DEFAULT NULL,  `trade_limit` int(11) DEFAULT NULL,  `amount_limit` int(11) DEFAULT NULL,  `points_limit` int(11) DEFAULT NULL,  `description` varchar(750) DEFAULT NULL,  `timestamp` int(11) DEFAULT NULL,  PRIMARY KEY (`id`)) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2016-03-07 15:28:17
array('time'=>mktimes(1970,1,1,11,20),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}return`ADD COLUMN `platform_point`  float(8,2) NOT NULL DEFAULT 0.00 COMMENT '退还用户平台积分' AFTER `product_money`",'des'=>'...'),

//2015-10-16 10:49:30
array('time'=>mktimes(1970,1,1,11,19),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order_product` ADD  `sp_id` INT NOT NULL DEFAULT  '0' COMMENT  '门店id'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,11,18),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order_package` ADD  `physical_id` INT NOT NULL DEFAULT  '0' COMMENT  '门店id',ADD  `courier_id` INT NOT NULL DEFAULT  '0' COMMENT  '配送员id'",'des'=>'...'),

//2015-10-15 13:29:54
array('time'=>mktimes(1970,1,1,11,17),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES(68, 5, '用户导出', 'User', 'checkout', 0, 1, 1)",'des'=>'...'),

//2015-10-14 17:48:03
array('time'=>mktimes(1970,1,1,11,16),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}subscribe_store` (  `sub_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝id',  `openid` varchar(200) NOT NULL DEFAULT '' COMMENT '粉丝对应被关注店铺公众号openid',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被关注店铺id',  `subscribe_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '关注时间',  PRIMARY KEY (`sub_id`),  KEY `uid` (`uid`) USING BTREE,  KEY `openid` (`openid`) USING BTREE,  KEY `store_id` (`store_id`) USING BTREE) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='粉丝关注店铺'",'des'=>'...'),

//2015-10-14 17:41:38
array('time'=>mktimes(1970,1,1,11,15),'type'=>'sql','sql'=>"ALTER TABLE {tableprefix}user_attention add store_id int UNSIGNED not null  default 0",'des'=>'...'),

//2015-10-14 17:41:08
array('time'=>mktimes(1970,1,1,11,14),'type'=>'sql','sql'=>"ALTER TABLE {tableprefix}user_collect add store_id int UNSIGNED not null  default 0",'des'=>'...'),

//2015-10-13 18:54:22
array('time'=>mktimes(1970,1,1,11,13),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD COLUMN `weixin_bind` TINYINT(1) DEFAULT 1 NULL COMMENT '1:需要绑定手机号方可登陆wap，2.无需绑定即可登陆' AFTER `type`",'des'=>'...'),

//2015-10-13 17:29:30
array('time'=>mktimes(1970,1,1,11,12),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order` ADD  `is_assigned` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '订单里商品是否已经分配到门店,0:未分配,1:部分分配,2:全部分配 '",'des'=>'...'),

//2015-10-13 14:05:33
array('time'=>mktimes(1970,1,1,11,11),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES(110,'weidian_version', '', '0', '微店版本', '微店版本 0 普通 1 对接', '0', '', 1, 0, 0)",'des'=>'...'),

//2015-10-13 9:18:55
array('time'=>mktimes(1970,1,1,11,10),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` add `update_drp_store_info` tinyint(1) DEFAULT '1' COMMENT '是否允许分销商修改店铺名称(默认允许)'",'des'=>'...'),

//2015-10-09 18:10:34
array('time'=>mktimes(1970,1,1,11,9),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}diy_attestation` (  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',  `type` varchar(150) NOT NULL DEFAULT '' COMMENT '类型',  `info` varchar(20) NOT NULL DEFAULT '' COMMENT '信息',  `desc` varchar(250) NOT NULL DEFAULT '' COMMENT '描述',  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态',  PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-10-09 18:10:12
array('time'=>mktimes(1970,1,1,11,8),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}certification` (  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',  `certification_info` text NOT NULL COMMENT '认证信息',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-10-08 18:28:16
array('time'=>mktimes(1970,1,1,11,7),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('111','is_open_wap_login_sms_check','type=select&value=0:不开启微信短信注册验证|1:开启短信注册验证','0','wap站注册短信验证','wap站注册是否开启短信验证','0','','2','0','1')",'des'=>'...'),

//2015-09-30 11:33:19
array('time'=>mktimes(1970,1,1,11,6),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES(107, 'order_return_date', 'type=text&size=2&validate=required:true,number:true,maxlength:2', '7', '退货周期', '确认收货后多长时间内可以退货', '0', '', 1, 0, 1),(108, 'order_complete_date', 'type=text&size=2&validate=required:true,number:true,maxlength:2', '15', '默认交易完成时间', '发货后，用户一直没有确认收货，此值为发货后的交易完成时间周期', '0', '', 1, 0, 1)",'des'=>'...'),

//2015-09-29 16:14:50
array('time'=>mktimes(1970,1,1,11,5),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_coupon` ADD COLUMN  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID' after `coupon_id`",'des'=>'...'),

//2015-09-29 16:08:13
array('time'=>mktimes(1970,1,1,11,4),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}return_product` ADD COLUMN  `discount` double(3,1) NOT NULL DEFAULT '10.0' COMMENT '折扣' after `original_product_id`",'des'=>'...'),

//2015-09-29 15:18:14
array('time'=>mktimes(1970,1,1,11,3),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `open_autoassign` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '是否开启订单自动分配到门店： 1是 0否' AFTER  `open_friend`",'des'=>'...'),

//2015-09-25 18:00:31
array('time'=>mktimes(1970,1,1,11,2),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product`ADD COLUMN `profit`  decimal(10,) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销单件商品利润'",'des'=>'...'),

//2015-09-25 16:09:45
array('time'=>mktimes(1970,1,1,11,1),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}order_product_physical` (  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单id',  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '规格sku_id',  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单商品id',  `physical_id` int(10) NOT NULL DEFAULT '0' COMMENT '仓库/门店id',  PRIMARY KEY (`pigcms_id`),  KEY `sku_id` (`sku_id`) USING BTREE,  KEY `product_id` (`product_id`) USING BTREE,  KEY `physical_id` (`physical_id`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='门店分配订单商品关系' AUTO_INCREMENT=1",'des'=>'...'),

//2015-09-21 17:05:11
array('time'=>mktimes(1970,1,1,11,0),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}store_physical_quantity` (  `pigcms_id` int(11) NOT NULL AUTO_INCREMENT,  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺id',  `physical_id` int(10) NOT NULL DEFAULT '0' COMMENT '仓库/门店id',  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT 'sku规格id',  `quantity` int(10) NOT NULL DEFAULT '0' COMMENT '库存',  PRIMARY KEY (`pigcms_id`),  KEY `sku_id` (`sku_id`) USING BTREE,  KEY `product_id` (`product_id`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='仓库分配库存关系' AUTO_INCREMENT=1",'des'=>'...'),

//2015-09-17 10:02:06
array('time'=>mktimes(1970,1,1,10,59),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order_product` ADD  `rights_status` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '产品维权状态，0：未维权，1：部分维权，2：全部维权' AFTER  `return_status`",'des'=>'...'),

//2015-09-16 9:33:28
array('time'=>mktimes(1970,1,1,10,58),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order`ADD COLUMN `activity_data`  text NULL COMMENT '营销系统活动订单数据'",'des'=>'...'),

//2015-09-16 9:33:21
array('time'=>mktimes(1970,1,1,10,57),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_sku`ADD COLUMN `wholesale_price`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '批发价格' AFTER `drp_level_3_cost_price`,ADD COLUMN `sale_min_price`  decimal(10,2) NOT NULL AFTER `wholesale_price`,ADD COLUMN `sale_max_price`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '建议最高售价' AFTER `sale_min_price`",'des'=>'...'),

//2015-09-16 9:33:12
array('time'=>mktimes(1970,1,1,10,56),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product`ADD COLUMN `is_wholesale`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '批发商品' AFTER `is_hot`,ADD COLUMN `wholesale_price`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '批发价格' AFTER `is_wholesale`,ADD COLUMN `sale_min_price`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '建议最低售价' AFTER `wholesale_price`,ADD COLUMN `sale_max_price`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '建议最高售价' AFTER `sale_min_price`,ADD COLUMN `wholesale_product_id`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '批发商品id' AFTER `sale_max_price`",'des'=>'...'),

//2015-09-16 9:33:04
array('time'=>mktimes(1970,1,1,10,55),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}subscribe_store` (  `sub_id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝id',  `openid` varchar(200) NOT NULL DEFAULT '' COMMENT '粉丝对应被关注店铺公众号openid',  `store_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被关注店铺id',  `subscribe_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '关注时间',  PRIMARY KEY (`sub_id`),  KEY `uid` (`uid`) USING BTREE,  KEY `openid` (`openid`) USING BTREE,  KEY `store_id` (`store_id`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='粉丝关注店铺'",'des'=>'...'),

//2015-09-16 9:32:56
array('time'=>mktimes(1970,1,1,10,54),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `drp_subscribe_img`  varchar(500) NOT NULL DEFAULT '' COMMENT '关注后发送的消息封面图片',ADD COLUMN `reg_drp_subscribe_img`  varchar(500) NOT NULL DEFAULT '' COMMENT '申请分销商关注后发送的消息封面图片'",'des'=>'...'),

//2015-09-16 9:32:48
array('time'=>mktimes(1970,1,1,10,53),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `reg_drp_subscribe_tpl` varchar(500) NOT NULL DEFAULT '' COMMENT '申请分销商关注后发送的消息'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,52),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_subscribe`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销是否需要先关注公众号',ADD COLUMN `open_drp_subscribe_auto`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '关注自动分销',ADD COLUMN `drp_subscribe_tpl`  varchar(500) NOT NULL DEFAULT '' COMMENT '关注后发送的消息'",'des'=>'...'),


//2015-09-15 16:28:57
array('time'=>mktimes(1970,1,1,10,51),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('109','emergent_mode','type=radio&value=1:开启|0:关闭','0','紧急模式','请不要随意开启，开启后会导致无法升级，使用短信等服务（接到小猪紧急通知时可开启此项）。','0','平台短信平台','1','0','0')",'des'=>'...'),

//2015-09-15 13:55:57
array('time'=>mktimes(1970,1,1,10,50),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}rights_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',  `order_no` varchar(50) NOT NULL COMMENT '订单号',  `rights_id` int(11) NOT NULL DEFAULT '0' COMMENT '维权单ID',  `order_product_id` int(11) NOT NULL DEFAULT '0' COMMENT 'order_product表的pigcms_id值',  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '产品ID',  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '库存ID',  `sku_data` text COMMENT '库存信息',  `pro_num` int(11) NOT NULL DEFAULT '0' COMMENT '数量',  `pro_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购买时的价格',  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商ID',  `original_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '源商品ID',  `user_rights_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户退货单ID',  UNIQUE KEY `id` (`id`),  KEY `order_id` (`order_id`),  KEY `rights_id` (`rights_id`),  KEY `order_product_id` (`order_product_id`,`product_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='维权商品表'",'des'=>'...'),

//2015-09-15 13:55:49
array('time'=>mktimes(1970,1,1,10,49),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}rights` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '维权申请时间',  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID号',  `order_no` varchar(50) NOT NULL,  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '退货类型，1、商品质量问题，2、未到货品，3、其它',  `phone` varchar(20) DEFAULT NULL COMMENT '维权人的联系方式',  `content` text COMMENT '维权说明',  `images` varchar(1024) DEFAULT NULL COMMENT '图片列表，图片数组序列化',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '申请状态，1：申请中，2：维权中，3：维权完成，10：维权取消',  `user_cancel_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '取消维权时间',  `complete_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '维权完成时间',  `platform_content` text COMMENT '维权结果',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含分销商品 0 否 1是',  `user_rights_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户申请维权单ID',  UNIQUE KEY `id` (`id`),  KEY `order_id` (`order_id`),  KEY `store_id` (`store_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='维权申请表'",'des'=>'...'),

//2015-09-15 13:55:33
array('time'=>mktimes(1970,1,1,10,48),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}return_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID',  `return_id` int(11) NOT NULL DEFAULT '0' COMMENT '退货单ID',  `order_product_id` int(11) NOT NULL DEFAULT '0' COMMENT 'order_product表的pigcms_id值',  `product_id` int(11) NOT NULL DEFAULT '0' COMMENT '产品ID',  `sku_id` int(11) NOT NULL DEFAULT '0' COMMENT '库存ID',  `sku_data` text COMMENT '库存信息',  `pro_num` int(11) NOT NULL DEFAULT '1' COMMENT '数量',  `pro_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '购买时的价格',  `is_packaged` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已打包，0：未打包，1：已打包',  `supplier_id` int(11) NOT NULL DEFAULT '0' COMMENT '供货商ID',  `original_product_id` int(11) NOT NULL DEFAULT '0' COMMENT '源商品ID',  `user_return_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户退货单ID',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `order_id` (`order_id`),  KEY `return_id` (`return_id`),  KEY `order_product_id` (`order_product_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-09-15 13:55:22
array('time'=>mktimes(1970,1,1,10,47),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}return` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '退货申请时间',  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单ID号',  `order_no` varchar(50) NOT NULL COMMENT '订单号',  `type` tinyint(1) NOT NULL DEFAULT '3' COMMENT '退货类型，1、买/卖双方协商一致，2、买错/多买/不想要，3、商品质量问题，4、未到货品，5、其它',  `phone` varchar(20) DEFAULT NULL COMMENT '退货人的联系方式',  `content` varchar(1024) NOT NULL COMMENT '退货说明',  `images` varchar(1024) DEFAULT NULL COMMENT '图片列表，图片数组序列化',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '申请状态，1：申请中，2：商家审核不通过，3：商家审核通过，4：退货物流，5：退货完成，6：退货取消',  `cancel_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '商家不同意退款时间',  `user_cancel_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '取消退货时间',  `store_content` varchar(1024) DEFAULT NULL COMMENT '商家不同意退款说明',  `shipping_method` varchar(50) DEFAULT NULL COMMENT '物流方式 express快递发货 selffetch亲自送货',  `express_code` varchar(50) DEFAULT NULL COMMENT '快递公司代码',  `express_company` varchar(50) DEFAULT NULL COMMENT '快递公司',  `express_no` varchar(50) DEFAULT NULL COMMENT '快递单号',  `address` text COMMENT '收货详细地址',  `address_user` varchar(20) DEFAULT NULL COMMENT '收货人',  `address_tel` varchar(20) DEFAULT NULL COMMENT '收货人电话',  `product_money` float(8,2) DEFAULT '0.00' COMMENT '产品退货的费用',  `postage_money` float(8,2) DEFAULT '0.00' COMMENT '产品退货的物流费用',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户UID',  `is_fx` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否包含分销商品 0 否 1是',  `user_return_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户申请退货单ID，',  UNIQUE KEY `id` (`id`),  KEY `order_id` (`order_id`),  KEY `user_return_id` (`user_return_id`),  KEY `store_id` (`store_id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-09-12 11:09:08
array('time'=>mktimes(1970,1,1,10,46),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES ('66', '4', '维权列表', 'Order', 'rights', '0', '1', '1')",'des'=>'...'),

//2015-09-12 11:08:21
array('time'=>mktimes(1970,1,1,10,45),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES ('65', '4', '退货列表', 'Order', 'return_order', '0', '1', '1')",'des'=>'...'),

//2015-09-08 17:09:42
array('time'=>mktimes(1970,1,1,10,44),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_property_value` ADD `status` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '是否显示 0：不显示，1：显示' AFTER `image`",'des'=>'...'),

//2015-09-08 17:08:42
array('time'=>mktimes(1970,1,1,10,43),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD `qcode_starttime` INT( 11 ) NOT NULL COMMENT '二维码开始生效时间' AFTER `qcode`",'des'=>'...'),

//2015-09-08 17:08:15
array('time'=>mktimes(1970,1,1,10,42),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}activity_recommend` ADD `qcode_starttime` INT( 11 ) NOT NULL COMMENT '二维码开始生效时间' AFTER `qcode`",'des'=>'...'),


//2015-09-08 17:01:21
array('time'=>mktimes(1970,1,1,10,41),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES (64, 4, '商家购买的短信订单', 'Order', 'smspay', 0, 1, 1)",'des'=>'...'),

//2015-09-08 16:59:51
array('time'=>mktimes(1970,1,1,10,40),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}order_sms` (  `sms_order_id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `uid` int(11) NOT NULL COMMENT '购买人uid',  `pay_openid` varchar(50) DEFAULT NULL COMMENT '支付人openid',  `smspay_no` varchar(100) DEFAULT NULL COMMENT '短信支付订单号，格式：SMSPAY_生成另外订单号',  `trade_no` varchar(100) NOT NULL COMMENT '交易流水号 ',  `sms_price` int(11) DEFAULT '0' COMMENT '短信单价(单位：分)',  `sms_num` int(11) DEFAULT NULL COMMENT '购买短信数量',  `money` float(8,2) NOT NULL COMMENT '支付金额',  `name` varchar(50) DEFAULT NULL COMMENT '支付人姓名',  `content` varchar(255) DEFAULT NULL COMMENT '支付人留言',  `pay_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',  `third_id` varchar(100) NOT NULL COMMENT '第三方支付ID',  `third_data` text NOT NULL COMMENT '第三方支付返回内容',  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态，0：未支付，1：已支付',  PRIMARY KEY (`sms_order_id`),  UNIQUE KEY `id` (`sms_order_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='短信订单表'",'des'=>'...'),

//2015-09-08 16:02:42
array('time'=>mktimes(1970,1,1,10,39),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order` ADD  `delivery_time` INT( 11 ) NOT NULL DEFAULT  '0' COMMENT  '收货时间' AFTER  `sent_time`",'des'=>'...'),

//2015-09-08 15:51:53
array('time'=>mktimes(1970,1,1,10,38),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD `item_store_id` INT NOT NULL ,ADD `type` TINYINT NOT NULL",'des'=>'...'),

//2015-09-08 15:43:26
array('time'=>mktimes(1970,1,1,10,37),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}rbac_action` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL COMMENT '用户ID',  `controller_id` varchar(25) DEFAULT NULL COMMENT '控制器ID',  `action_id` varchar(25) DEFAULT NULL COMMENT '动作ID',  `add_time` int(11) DEFAULT NULL COMMENT '添加时间',  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=352 DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-09-04 9:53:51
array('time'=>mktimes(1970,1,1,10,36),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `source_site_url` varchar(200) NOT NULL DEFAULT '' COMMENT '来源网站',ADD COLUMN `payment_url` varchar(200) NOT NULL DEFAULT '' COMMENT '站外支付地址',ADD COLUMN `notify_url` varchar(200) NOT NULL DEFAULT '' COMMENT '通知地址',ADD COLUMN `oauth_url` varchar(200) NOT NULL DEFAULT '' COMMENT '对接网站用户认证地址',ADD COLUMN `token` varchar(100) NOT NULL DEFAULT '' COMMENT '微信token'",'des'=>'...'),


//2015-08-27 18:42:50
array('time'=>mktimes(1970,1,1,10,35),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`MODIFY COLUMN `open_drp_diy_store`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否开启分销商装修店铺配置' AFTER `unified_price_setting`,ADD COLUMN `drp_diy_store`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否有装修店铺权限' AFTER `open_drp_diy_store`",'des'=>'...'),

//2015-08-27 18:42:43
array('time'=>mktimes(1970,1,1,10,34),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_diy_store`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '分销商是否可以装修店铺' AFTER `unified_price_setting`",'des'=>'...'),

//2015-08-27 18:42:34
array('time'=>mktimes(1970,1,1,10,33),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_setting_price`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '开启分销价设置' AFTER `template_id`,ADD COLUMN `unified_price_setting`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '供货商统一定价' AFTER `open_drp_setting_price`",'des'=>'...'),

//2015-08-27 18:42:25
array('time'=>mktimes(1970,1,1,10,32),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}financial_record`ADD COLUMN `bak`  varchar(500) NULL DEFAULT '' COMMENT '备注' AFTER `storeOwnPay`",'des'=>'...'),

//2015-08-27 18:42:11
array('time'=>mktimes(1970,1,1,10,31),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_image`ADD COLUMN `sort`  tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序' AFTER `image`,ADD INDEX (`sort`) USING BTREE",'des'=>'...'),

//2015-08-27 18:42:02
array('time'=>mktimes(1970,1,1,10,30),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `drp_limit_condition`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 或（2个条件满足一个即可分销） 1 和（2个条件都满足即可分销）' AFTER `drp_limit_share`",'des'=>'...'),

//2015-08-27 18:41:43
array('time'=>mktimes(1970,1,1,10,29),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_guidance`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '店铺分销引导' AFTER `token`,ADD COLUMN `open_drp_limit`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销限制' AFTER `open_drp_guidance`,ADD COLUMN `drp_limit_buy`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '消费多少金额可分销' AFTER `open_drp_limit`,ADD COLUMN `drp_limit_share`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分享多少次可分销' AFTER `drp_limit_buy`,ADD INDEX `token` (`token`) USING BTREE",'des'=>'...'),


//2015-08-27 18:18:20
array('time'=>mktimes(1970,1,1,10,28),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('106','sms_open','type=radio&value=1:开启|0:关闭','1','短信是否开启','在以上内容全部完整的情况下，开启有效','0','平台短信平台','15','0','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,27),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES('105', 'sms_test_mobile', 'type=otext&validate=required:false,mobile:true', '', '测试', '输入手机号以后，然后<a href='javascript:test_send_sms();'>点击这里</a>进行测试', '0', '平台短信平台', 15, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,26),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('104','sms_sign','type=text&validate=required:true,maxlength:5','','短信签名','短信的前缀（一起发送给客户的）','0','平台短信平台','15','0','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,25),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('103','sms_price','type=text&validate=required:true,number:true,maxlength:2','','短信价格(单位:分)','每条多少分钱(卖给客户的)','0','平台短信平台','15','0','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,24),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('102','sms_key','type=text&validate=required:true','','短信key','短信的key（必填）','0','平台短信平台','15','0','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,23),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values('101','sms_topdomain','type=text&validate=required:true,url:true','','发送短信授权域名','发送短信授权域名','0','平台短信平台','15','0','1')",'des'=>'...'),

//2015-08-27 18:18:11
array('time'=>mktimes(1970,1,1,10,22),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config_group` (`gid`, `gname`, `gsort`) VALUES ('15', '平台短信接口配置', '0')",'des'=>'...'),


//2015-08-27 18:17:52
array('time'=>mktimes(1970,1,1,10,21),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}activity_recommend` ADD COLUMN `qcode` VARCHAR(200) NULL COMMENT '活动二维码本地路径' AFTER `image`",'des'=>'...'),

//2015-08-27 18:17:40
array('time'=>mktimes(1970,1,1,10,20),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}sms_by_code` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',  `code` int(11) DEFAULT NULL COMMENT '短信验证码',  `is_use` tinyint(1) DEFAULT '0' COMMENT '是否使用过（0:未使用；1:已使用）',  `timestamp` int(11) DEFAULT NULL COMMENT '发送的时间戳',  `type` varchar(30) DEFAULT NULL COMMENT '取到验证码类型(reg:注册,forget:找回密码)',  PRIMARY KEY (`id`)) ENGINE=MyISAM  CHARSET=utf8",'des'=>'...'),

//2015-08-27 18:17:28
array('time'=>mktimes(1970,1,1,10,19),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}sms_record`( `id` INT(11) NOT NULL AUTO_INCREMENT, `uid` INT(11) COMMENT '发送者的uid', `store_id` INT(11) COMMENT '操作的店铺id', `price` smallint(2) NOT NULL DEFAULT 0 COMMENT '短信单价', `mobile` varchar(20) COMMENT '发送到的手机号', `text` TEXT NOT NULL COMMENT '短信内容', `time` INT(11) COMMENT '发送的时间戳', `status` VARCHAR(250) COMMENT '状态', PRIMARY KEY (`id`) ) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_general_ci",'des'=>'...'),

//2015-08-27 18:17:09
array('time'=>mktimes(1970,1,1,10,18),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD COLUMN `smscount` INT(10) DEFAULT 0 NOT NULL COMMENT '剩余短信数量' AFTER `token`",'des'=>'...'),

//2015-08-25 10:54:23
array('time'=>mktimes(1970,1,1,10,17),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order_product` ADD  `return_status` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '产品退款状态，0：未退款，1：部分退款，2：全部退完' AFTER  `is_comment`",'des'=>'...'),

//2015-08-25 10:06:32
array('time'=>mktimes(1970,1,1,10,16),'type'=>'sql','sql'=>"INSERT INTO {tableprefix}system_menu (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values ('63', '1', '更新数据库', 'System', 'sqlUpdate', 0, 1, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,15),'type'=>'sql','sql'=>"INSERT INTO {tableprefix}system_menu (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values ('62', '1', '更新程序', 'System', 'checkUpdate', 0, 1, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,14),'type'=>'sql','sql'=>"INSERT INTO {tableprefix}system_menu (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values ('61', '2', '收款银行', 'Bank', 'index', 0, 1, 1)",'des'=>'...'),

//2015-08-22 13:46:10
array('time'=>mktimes(1970,1,1,10,13),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}order_peerpay` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',  `order_id` int(11) NOT NULL COMMENT '订单表ID',  `peerpay_no` varchar(100) NOT NULL COMMENT '代支付订单号，格式：PEERPAY_生成另外订单号',  `money` float(8,2) NOT NULL COMMENT '支付金额',  `name` varchar(50) DEFAULT NULL COMMENT '支付人姓名',  `content` varchar(255) DEFAULT NULL COMMENT '支付人留言',  `pay_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',  `third_id` varchar(100) NOT NULL COMMENT '第三方支付ID',  `third_data` text NOT NULL COMMENT '第三方支付返回内容',  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付状态，0：未支付，1：已支付',  `untread_money` float(8,2) NOT NULL DEFAULT '0.00' COMMENT '退回金额',  `untread_dateline` int(11) NOT NULL DEFAULT '0' COMMENT '退回时间',  `untread_content` varchar(200) DEFAULT NULL COMMENT '退回申请说明',  `untread_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '退回状态，0：未完成，1：已完成',  UNIQUE KEY `id` (`id`),  UNIQUE KEY `peerpay_no` (`peerpay_no`),  KEY `order_id` (`order_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代付表'",'des'=>'...'),

//2015-08-21 13:26:00
array('time'=>mktimes(1970,1,1,10,12),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD COLUMN `qcode` VARCHAR(300) NOT NULL COMMENT '店铺二维码' AFTER `logo`",'des'=>'...'),

//2015-08-21 10:25:29
array('time'=>mktimes(1970,1,1,10,11),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}activity_recommend` ADD COLUMN `qcode` VARCHAR(200) NULL COMMENT '活动二维码本地路径' AFTER `image`",'des'=>'...'),

//2015-08-18 11:15:25
array('time'=>mktimes(1970,1,1,10,10),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order` ADD  `peerpay_content` VARCHAR( 200 ) NOT NULL COMMENT  '代付订单时，代付人求助语' AFTER  `peerpay_type`",'des'=>'...'),

//2015-08-18 11:08:59
array('time'=>mktimes(1970,1,1,10,9),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order` ADD  `peerpay_type` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '订单为代付订单时，1：单人付，2：多人付' AFTER  `payment_method`",'des'=>'...'),


//2015-08-15 14:51:58
array('time'=>mktimes(1970,1,1,10,8),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}business_hour` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`store_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',`start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',`end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',`is_open` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2015-08-13 15:27:17
array('time'=>mktimes(1970,1,1,10,6),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD template_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模板ID'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,5),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store` ADD template_cat_id int(11) NOT NULL DEFAULT '0' COMMENT '店铺模板ID'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,4),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}wei_page_category` ADD page_id int(10) unsigned NOT NULL DEFAULT '0'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,3),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}user` ADD admin_id int(10) unsigned NOT NULL DEFAULT '0' COMMENT '后台ID'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,2),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}wei_page_category` ADD uid int(10) unsigned NOT NULL DEFAULT '0'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,10,1),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}wei_page_category` ADD cover_img char(100)  NOT NULL",'des'=>'...'),

//2015-08-12 13:27:55
array('time'=>mktimes(1970,1,1,10,0),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES(100, 'synthesize_store', '', '1', '', '综合商城预览', '0', '', 1, 0, 0)",'des'=>'...'),

//2015-08-12 10:50:20
array('time'=>mktimes(1970,1,1,9,59),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (99, 'ischeck_store', 'type=select&value=1:开店需要审核|0:开店无需审核', '0', '开店是否要审核', '开启后，会员开店需要后台审核通过后，店铺才能正常使用', '0', '', '1', '0', '1')",'des'=>'...'),
//2015-08-11 17:26:51
array('time'=>mktimes(1970,1,1,9,58),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values('60','12','店铺评价管理','Store','comment','0','1','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,57),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values('59','3','商品评价管理','Product','comment','0','1','1')",'des'=>'...'),

//2015-08-10 10:07:58
array('time'=>mktimes(1970,1,1,9,56),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}tempmsg` (  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `tempkey` char(50) NOT NULL,  `name` char(100) NOT NULL,  `content` varchar(1000) NOT NULL,  `industry` char(50) NOT NULL,  `topcolor` char(10) NOT NULL DEFAULT '#029700',  `textcolor` char(10) NOT NULL DEFAULT '#000000',  `token` char(40) NOT NULL,  `tempid` char(100) DEFAULT NULL,  `status` tinyint(4) NOT NULL DEFAULT '0',  PRIMARY KEY (`id`),  KEY `tempkey` (`tempkey`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),

//2015-08-08 16:39:36
array('time'=>mktimes(1970,1,1,9,55),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_sku` ADD COLUMN `drp_level_1_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品价格' AFTER `max_fx_price`,ADD COLUMN `drp_level_2_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品价格' AFTER `drp_level_1_price`,ADD COLUMN `drp_level_3_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品价格' AFTER `drp_level_2_price`,ADD COLUMN `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品成本价格' AFTER `drp_level_3_price`,ADD COLUMN `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品成本价格' AFTER `drp_level_1_cost_price`,ADD COLUMN `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品成本价格' AFTER `drp_level_2_cost_price`",'des'=>'...'),


array('time'=>mktimes(1970,1,1,9,53),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `open_service` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '是否开启客服，1：是，0：否' AFTER  `drp_profit_withdrawal`",'des'=>'...'),

//2015-08-07 13:16:25
array('time'=>mktimes(1970,1,1,9,52),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `open_friend` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '是否开启送朋友，1：是，0：否' AFTER  `open_logistics`",'des'=>'...'),

array('time'=>mktimes(1970,1,1,9,51),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `open_logistics` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '是否开启物流配送，1：开启，0：关闭' AFTER  `offline_payment`",'des'=>'...'),

//2015-08-06 13:43:58
array('time'=>mktimes(1970,1,1,9,50),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) values(58, '3','被分销的源商品列表','Product','fxlist','0','1','1')",'des'=>'...'),

//2015-08-06 13:09:26
array('time'=>mktimes(1970,1,1,9,49),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `is_hot` TINYINT(1) DEFAULT 0 NOT NULL COMMENT '是否热门 0否 1是' AFTER `drp_level_3_cost_price`",'des'=>'...'),

//2015-08-06 10:19:42
array('time'=>mktimes(1970,1,1,9,48),'type'=>'sql','sql'=>"UPDATE `{tableprefix}config` SET `type` = 'type=text&size=3&validate=required:true,number:true,maxlength:2' WHERE `{tableprefix}config`.`name` = 'sales_ratio'",'des'=>'...'),

//2015-08-05 17:52:15
array('time'=>mktimes(1970,1,1,9,47),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD COLUMN `sales_ratio` DECIMAL(10,2) NOT NULL COMMENT '商家销售分成比例,按照所填百分比进行扣除' AFTER `storeOpenid`",'des'=>'...'),

//2015-08-05 17:04:29
array('time'=>mktimes(1970,1,1,9,46),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values(96,'sales_ratio','type=text&size=3&validate=required:true,number:true,maxlength:3','2','商家销售分成比例','例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除','0','','1','0','1')",'des'=>'...'),

//2015-08-01 15:41:32
array('time'=>mktimes(1970,1,1,9,45),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_image`ADD COLUMN `sort`  tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序' AFTER `image`,ADD INDEX (`sort`) USING BTREE",'des'=>'...'),

//2015-07-30 9:06:04
array('time'=>mktimes(1970,1,1,9,44),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `drp_limit_condition`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 或（2个条件满足一个即可分销） 1 和（2个条件都满足即可分销）' AFTER `drp_limit_share`",'des'=>'...'),

//2015-07-30 9:05:45
array('time'=>mktimes(1970,1,1,9,43),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_guidance`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '店铺分销引导' AFTER `token`,ADD COLUMN `open_drp_limit`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分销限制' AFTER `open_drp_guidance`,ADD COLUMN `drp_limit_buy`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '消费多少金额可分销' AFTER `open_drp_limit`,ADD COLUMN `drp_limit_share`  int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分享多少次可分销' AFTER `drp_limit_buy`,ADD INDEX `token` (`token`) USING BTREE",'des'=>'...'),



//2015-08-03 19:01:19
array('time'=>mktimes(1970,1,1,9,42),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES (13, 'pc-首页活动广告', 'pc_index_activity')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,41),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES (12, 'pc-活动页附近活动（4）', 'pc_activity_nearby')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,40),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES (11, 'pc-活动页热门活动（4）', 'pc_activity_hot')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,39),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES (10, 'pc-活动页今日推荐（1）', 'pc_activity_rec')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,38),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}adver_category` VALUES ( 9, 'pc-活动页头部幻灯片（6）', 'pc_activity_slider')",'des'=>'...'),


//2015-08-03 11:29:48
array('time'=>mktimes(1970,1,1,9,37),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values(95,'pc_shopercenter_logo','type=image&validate=required:true,url:true','','商家中心LOGO图','请填写带LOGO的网址，包含（http://域名）','0','','1','0','1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,36),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values(94,'pc_usercenter_logo','type=image&validate=required:true,url:true','','PC-个人用户中心LOGO图','请填写带LOGO的网址，包含（http://域名）','0','','1','0','1')",'des'=>'...'),

//2015-08-01 15:48:33
array('time'=>mktimes(1970,1,1,9,34),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}config` (`id`, `name` ,`type` ,`value` ,`info` ,`desc` ,`tab_id`, `tab_name` ,`gid` ,`sort` ,`status`) VALUES (93,'is_have_activity',  'type=radio&value=1:有|0:没有',  '1',  '活动',  '首页是否需要展示营销活动',  '0',  '0',  '1',  '0',  '1')",'des'=>'...'),

//2015-08-01 15:14:44
array('time'=>mktimes(1970,1,1,9,33),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}order_check_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(10) DEFAULT NULL COMMENT '订单id',  `order_no` varchar(100) DEFAULT NULL COMMENT '订单号',  `store_id` int(11) DEFAULT NULL COMMENT '被操作的商铺id',  `description` varchar(255) DEFAULT NULL COMMENT '描述',  `admin_uid` int(11) DEFAULT NULL COMMENT '操作人uid',  `ip` bigint(20) DEFAULT NULL COMMENT '操作人ip',  `timestamp` int(11) DEFAULT NULL COMMENT '记录的时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,32),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order` ADD `is_check` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT '是否对账，1：未对账，2：已对账' AFTER `storeOpenid`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,31),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES(55, 12, '店铺对账日志', 'Order', 'checklog', 0, 1, 1)",'des'=>'...'),

//2015-08-01 15:10:52
array('time'=>mktimes(1970,1,1,9,30),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}activity_recommend` ADD  `is_rec` TINYINT( 1 ) NOT NULL ,ADD  `ucount` INT NOT NULL",'des'=>'...'),

//2015-07-31 16:36:09
array('time'=>mktimes(1970,1,1,9,29),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}activity_recommend` ADD COLUMN `time`  int NULL",'des'=>'...'),

array('time'=>mktimes(1970,1,1,9,28),'type'=>'sql','sql'=>"CREATE TABLE If Not Exists `{tableprefix}activity_recommend` (`id`  int NOT NULL AUTO_INCREMENT ,`modelId`  int NULL ,`title`  varchar(500) NULL ,`info`  varchar(2000) NULL ,`image`  varchar(200) NULL ,`token`  char(50) NULL ,`model`  char(20) NULL ,PRIMARY KEY (`id`),INDEX (`modelId`, `token`, `model`) USING BTREE )ENGINE=MyISAM DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci COMMENT='推荐活动' CHECKSUM=0 DELAY_KEY_WRITE=0",'des'=>'...'),

//2015-07-29 9:49:14
array('time'=>mktimes(1970,1,1,9,27),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES (54,'12', '营销活动展示', 'Store', 'activityRecommend')",'des'=>'...'),

//2015-07-29 9:42:23
array('time'=>mktimes(1970,1,1,9,26),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES (53, '12', '营销活动管理', 'Store', 'activityManage')",'des'=>'...'),


//2015-07-28 17:57:53
array('time'=>mktimes(1970,1,1,9,25),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (88,'syn_domain', 'type=text', '', '营销活动地址', '部分功能需要调用平台内容，需要用到该网址', '0', '', '8', '-2', '1'), (89, 'withdrawal_min_amount', 'type=text&validate=required:true,number:true', '0', '单次提现最低金额', '单次提现最低金额，0为不限', '0', '', '1', '0', '1'), (90,'encryption', 'type=text', '', '营销活动key', '与平台对接时需要用到', '0', '', '8', '-1', '1')",'des'=>'...'),

//2015-07-27 16:51:55
array('time'=>mktimes(1970,1,1,9,24),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `pigcmsToken` CHAR( 100 ) NULL",'des'=>'...'),


//2015-07-20 17:08:46
array('time'=>mktimes(1970,1,1,9,23),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}location_qrcode` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `ticket` varchar(500) NOT NULL,  `status` tinyint(1) NOT NULL,  `add_time` int(11) NOT NULL,  `openid` char(40) NOT NULL,  `lat` char(10) NOT NULL,  `lng` char(10) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=400000000 DEFAULT CHARSET=utf8 COMMENT='使用微信登录生成的临时二维码'",'des'=>'...'),

//2015-07-18 15:15:38
array('time'=>mktimes(1970,1,1,9,22),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES (51, '12', '品牌管理', 'Store', 'brand')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,21),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`) VALUES (50, '12', '品牌类别管理', 'Store', 'brandtype')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,20),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}store`ADD COLUMN `open_drp_approve` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启分销商审核' AFTER `wxpay`,ADD COLUMN `drp_approve` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分销商审核状态' AFTER `open_drp_approve`,ADD COLUMN `drp_profit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润' AFTER `drp_approve`,ADD COLUMN `drp_profit_withdrawal` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '分销利润提现' AFTER `drp_profit`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,19),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (98,'weidian_key', 'type=salt', 'pigcms', '微店KEY', '对接微店使用的KEY，请妥善保管', '0', '', '1', '0', '1')",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,18),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product` ADD COLUMN `drp_profit` decimal(11,) unsigned NOT NULL DEFAULT '0' COMMENT '商品分销利润总额' AFTER `attention_num`,ADD COLUMN `drp_seller_qty` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商数量(被分销次数)' AFTER `drp_profit`,ADD COLUMN `drp_sale_qty` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分销商品销量' AFTER `drp_seller_qty`,ADD COLUMN `unified_price_setting` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '供货商统一定价' AFTER `drp_sale_qty`,ADD COLUMN `drp_level_1_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品价格' AFTER `unified_price_setting`,ADD COLUMN `drp_level_2_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品价格' AFTER `drp_level_1_price`,ADD COLUMN `drp_level_3_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品价格' AFTER `drp_level_2_price`,ADD COLUMN `drp_level_1_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '一级分销商商品成本价格' AFTER `drp_level_3_price`,ADD COLUMN `drp_level_2_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '二级分销商商品成本价格' AFTER `drp_level_1_cost_price`,ADD COLUMN `drp_level_3_cost_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '三级分销商商品成本价格' AFTER `drp_level_2_cost_price`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,17),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}product` ADD  `attention_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,16),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `attention_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注数'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,15),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}user_attention` (  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',  `data_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',  `data_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型  1，商品 2，店铺',  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8",'des'=>'...'),

array('time'=>mktimes(1970,1,1,9,14),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `offline_payment` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '是否支持货到付款，1：是，0：否' AFTER  `buyer_selffetch_name`",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,13),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` ADD  `buyer_selffetch_name` VARCHAR( 50 ) NOT NULL COMMENT  '“上门自提”自定义名称' AFTER  `buyer_selffetch`",'des'=>'...'),


//2015-07-18 14:04:36
array('time'=>mktimes(1970,1,1,9,12),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}ng_word` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `ng_word` varchar(100) NOT NULL,  `replace_word` varchar(100) NOT NULL,  PRIMARY KEY (`id`),  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `ng_word` (`ng_word`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='敏感词表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,11),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}system_tag` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `tid` int(11) NOT NULL DEFAULT '0' COMMENT 'system_property_type表type_id，主要是为了方便查找',  `name` varchar(100) NOT NULL COMMENT '标签名',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，1为开启，0：关闭',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `tid` (`tid`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统标签表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,10),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}comment_tag` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '评论表ID',  `tag_id` int(11) NOT NULL DEFAULT '0' COMMENT '系统标签表ID',  `relation_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',  `type` enum('PRODUCT','STORE') NOT NULL DEFAULT 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `cid` (`cid`) USING BTREE,  KEY `tag_id` (`tag_id`,`relation_id`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,9),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}comment_reply` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',  `cid` int(11) unsigned NOT NULL COMMENT '评论表ID',  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',  `content` text COMMENT '回复内容',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `cid` (`cid`) USING BTREE,  KEY `uid` (`uid`) USING BTREE) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论回复表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,8),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}comment_attachment` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `cid` int(11) NOT NULL DEFAULT '0' COMMENT '评论表ID',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0为图片，1为语音，2为视频',  `file` varchar(100) DEFAULT NULL COMMENT '文件地址',  `size` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小，byte字节数',  `width` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片宽度',  `height` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图片高度',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `cid` (`cid`) USING BTREE,  KEY `uid` (`uid`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论附件表'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,9,7),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}comment` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单表ID,对产品评论时，要加订单ID，其它为0',  `relation_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联评论ID，例：产品ID，店铺ID等',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',  `score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '满意度，1-5，数值越大，满意度越高',  `logistics_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '物流满意度，1-5，数值越大，满意度越高',  `description_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '描述相符，1-5，数值越大，满意度越高',  `speed_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '发货速度，1-5，数值越大，满意度越高',  `service_score` tinyint(1) NOT NULL DEFAULT '5' COMMENT '服务态度，1-5，数值越大，满意度越高',  `type` enum('PRODUCT','STORE') NOT NULL DEFAULT 'PRODUCT' COMMENT '评论的类型，PRODUCT:对产品评论，STORE:对店铺评论',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态，主要用于审核评论，1：通过审核，0：未通过审核',  `has_image` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有图片，1为有，0为没有',  `content` text NOT NULL COMMENT '评论内容',  `reply_number` int(11) NOT NULL DEFAULT '0' COMMENT '回复数',  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '删除标记，1：删除，0：未删除',  UNIQUE KEY `id` (`id`) USING BTREE,  KEY `relation_id` (`relation_id`) USING BTREE,  KEY `order_id` (`order_id`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论表'",'des'=>'...'),

//2015-07-17 11:08:34
array('time'=>mktimes(1970,1,1,9,6),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}order_product` ADD  `pro_weight` FLOAT( 10, 2 ) NOT NULL COMMENT  '每一个产品的重量，单位：克' AFTER  `pro_price`",'des'=>'...'),

//2015-07-17 10:32:36
array('time'=>mktimes(1970,1,1,9,5),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}product` ADD  `weight` FLOAT( 10, 2 ) NOT NULL COMMENT  '产品重量，单位：克' AFTER  `original_price`",'des'=>'...'),

//2015-07-14 14:18:01
array('time'=>mktimes(1970,1,1,9,4),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_brand` (  `brand_id` int(11) NOT NULL AUTO_INCREMENT,  `name` varchar(250) NOT NULL COMMENT '商铺品牌名',  `pic` varchar(200) NOT NULL COMMENT '品牌图片',  `order_by` int(100) NOT NULL DEFAULT '0' COMMENT '排序，越小越前面',  `store_id` int(11) NOT NULL COMMENT '商铺id',  `type_id` int(11) NOT NULL COMMENT '所属品牌类别id',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用（1：启用；  0：禁用）',  PRIMARY KEY (`brand_id`)) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='商铺品牌表'",'des'=>'...'),

//2015-07-14 14:17:37
array('time'=>mktimes(1970,1,1,9,3),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}store_brand_type` (  `type_id` int(11) NOT NULL AUTO_INCREMENT,  `type_name` varchar(100) NOT NULL COMMENT '商铺品牌类别名',  `order_by` int(10) NOT NULL COMMENT '排序',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '品牌状态（1：开启，0：禁用）',  PRIMARY KEY (`type_id`)) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='商铺品牌类别表'",'des'=>'...'),

//2015-07-13 16:22:32
array('time'=>mktimes(1970,1,1,9,2),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_category` CHANGE `cat_pic` `cat_pic` VARCHAR(50) CHARSET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'wap端栏目图片', ADD COLUMN `cat_pc_pic` VARCHAR(50) NOT NULL COMMENT 'pc端栏目图片' AFTER `cat_pic`",'des'=>'...'),

//2015-07-06 10:18:49
array('time'=>mktimes(1970,1,1,9,1),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_property_value` ADD `image` VARCHAR(255) NOT NULL COMMENT '属性对应图片'",'des'=>'...'),

//2015-07-04 14:15:05
array('time'=>mktimes(1970,1,1,9,0),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES (46, 2, '商城评论标签', 'Tag', 'index', 0, 1, 1),(49, 2, '敏感词', 'Ng_word', 'index', 0, 1, 1)",'des'=>'...'),

//2015-07-03 17:16:51
array('time'=>mktimes(1970,1,1,8,59),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_category` ADD `tag_str` VARCHAR(1024) NOT NULL COMMENT '标签列表，每个tag_id之间用逗号分割' AFTER `filter_attr`",'des'=>'...'),

//2015-07-03 9:54:24
array('time'=>mktimes(1970,1,1,8,58),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product` ADD `is_comment` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否已评论，1：是，0：否'",'des'=>'...'),

//2015-07-02 14:37:49
array('time'=>mktimes(1970,1,1,8,57),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}present_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `pid` int(11) NOT NULL COMMENT '赠品表ID',  `product_id` int(11) NOT NULL COMMENT '产品表ID',  PRIMARY KEY (`id`),  KEY `pid` (`pid`,`product_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='赠品产品列表'",'des'=>'...'),

//2015-07-02 14:36:03
array('time'=>mktimes(1970,1,1,8,56),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}present` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL COMMENT '添加时间',  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',  `store_id` int(11) NOT NULL DEFAULT '0' COMMENT '店铺ID',  `name` varchar(255) NOT NULL COMMENT '赠品名称',  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠品开始时间',  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠品结束时间',  `expire_date` int(11) NOT NULL DEFAULT '0' COMMENT '领取有效期，此只对虚拟产品,保留字段',  `expire_number` int(11) NOT NULL DEFAULT '0' COMMENT '领取限制，此只对虚拟产品，保留字段',  `number` int(11) NOT NULL DEFAULT '0' COMMENT '领取次数',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效，1：有效，0：无效，',  PRIMARY KEY (`id`),  KEY `store_id` (`store_id`,`start_time`,`end_time`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='赠品表'",'des'=>'...'),

//2015-07-02 14:34:32
array('time'=>mktimes(1970,1,1,8,55),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}reward_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `rid` int(11) NOT NULL COMMENT '满减/送表ID',  `product_id` int(11) NOT NULL COMMENT '产品表ID',  PRIMARY KEY (`id`),  KEY `rid` (`rid`,`product_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='满减/送产品列表'",'des'=>'...'),

//2015-07-02 14:33:54
array('time'=>mktimes(1970,1,1,8,54),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}reward_condition` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `rid` int(11) NOT NULL COMMENT '满减/送表ID',  `money` int(11) NOT NULL COMMENT '钱数限制',  `cash` int(11) NOT NULL DEFAULT '0' COMMENT '减现金，0：表示没有此选项',  `postage` int(11) NOT NULL DEFAULT '0' COMMENT '免邮费，0：表示没有此选项',  `score` int(11) NOT NULL DEFAULT '0' COMMENT '送积分，0：表示没有此选项',  `coupon` int(11) NOT NULL DEFAULT '0' COMMENT '送优惠，0：表示没有此选项',  `present` int(11) NOT NULL DEFAULT '0' COMMENT '送赠品，0：表示没有此选项',  PRIMARY KEY (`id`),  KEY `rid` (`rid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠条件表'",'des'=>'...'),

//2015-07-02 14:33:20
array('time'=>mktimes(1970,1,1,8,53),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}reward` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `dateline` int(11) NOT NULL COMMENT '添加时间',  `uid` int(11) NOT NULL COMMENT '会员ID',  `store_id` int(11) NOT NULL COMMENT '店铺ID',  `name` varchar(255) NOT NULL COMMENT '活动名称',  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠方式，1：普通优惠，2：多级优惠，每级优惠不累积',  `is_all` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否所有商品都参与活动，1：全部商品，2：部分商品',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效，1：有效，0：无效，',  PRIMARY KEY (`id`),  KEY `uid` (`uid`,`store_id`,`start_time`,`end_time`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='满减/送表'",'des'=>'...'),

//2015-07-02 14:31:48
array('time'=>mktimes(1970,1,1,8,52),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}order_coupon` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(11) NOT NULL DEFAULT '0',  `uid` int(11) NOT NULL DEFAULT '0',  `coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券ID',  `name` varchar(255) NOT NULL COMMENT '优惠券名称',  `user_coupon_id` int(11) NOT NULL DEFAULT '0' COMMENT 'user_coupon表id',  `money` float(8,2) NOT NULL COMMENT '优惠券金额',  PRIMARY KEY (`id`),  KEY `uid` (`uid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8",'des'=>'...'),

//2015-07-02 14:30:07
array('time'=>mktimes(1970,1,1,8,51),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}order_reward` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `order_id` int(11) NOT NULL COMMENT '订单表ID',  `uid` int(11) NOT NULL COMMENT '会员ID',  `rid` int(11) NOT NULL COMMENT '满减/送ID',  `name` varchar(255) NOT NULL COMMENT '活动名称',  `content` text NOT NULL COMMENT '描述序列化数组',  PRIMARY KEY (`id`),  KEY `order_id` (`order_id`,`uid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单优惠表'",'des'=>'...'),

//2015-07-02 14:25:22
array('time'=>mktimes(1970,1,1,8,50),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}coupon` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL,  `store_id` int(11) NOT NULL COMMENT '商铺id',  `name` varchar(255) NOT NULL COMMENT '优惠券名称',  `face_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券面值(起始)',  `limit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',  `most_have` int(11) NOT NULL COMMENT '单人最多拥有优惠券数量（0：不限制）',  `total_amount` int(11) NOT NULL COMMENT '发放总量',  `start_time` int(11) NOT NULL COMMENT '生效时间',  `end_time` int(11) NOT NULL COMMENT '过期时间',  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',  `is_share` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',  `is_all_product` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',  `is_original_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',  `timestamp` int(11) NOT NULL COMMENT '添加优惠券的时间',  `description` text NOT NULL COMMENT '使用说明',  `used_number` int(11) NOT NULL DEFAULT '0' COMMENT '已使用数量',  `number` int(11) NOT NULL DEFAULT '0' COMMENT '已领取数量',  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否失效（0：失效；1：未失效）',  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '券类型（1：优惠券； 2:赠送券）',  UNIQUE KEY `id` (`id`),  KEY `uid` (`uid`,`store_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠券' AUTO_INCREMENT=21",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,49),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}user_coupon` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `uid` int(11) NOT NULL COMMENT '用户id',  `store_id` int(11) NOT NULL COMMENT '商铺id',  `coupon_id` int(11) NOT NULL COMMENT '优惠券ID',  `card_no` char(32) NOT NULL COMMENT '卡号',  `cname` varchar(255) NOT NULL COMMENT '优惠券名称',  `face_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠券面值(起始)',  `limit_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用优惠券的订单金额下限（为0：为不限定）',  `start_time` int(11) NOT NULL COMMENT '生效时间',  `end_time` int(11) NOT NULL COMMENT '过期时间',  `is_expire_notice` tinyint(1) NOT NULL COMMENT '到期提醒（0：不提醒；1：提醒）',  `is_share` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许分享链接（0：不允许；1：允许）',  `is_all_product` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否全店通用（0：全店通用；1：指定商品使用）',  `is_original_price` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:非原价购买可使用；1：原价购买商品时可',  `description` text NOT NULL COMMENT '使用说明',  `is_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用',  `is_valid` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:不可以使用，1：可以使用',  `use_time` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券使用时间',  `timestamp` int(11) NOT NULL COMMENT '领取优惠券的时间',  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '券类型（1：优惠券，2：赠送券）',  `give_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '赠送的订单id',  `use_order_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用的订单id',  `delete_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除(0:未删除，1：已删除)',  PRIMARY KEY (`id`),  UNIQUE KEY `card_no` (`card_no`),  KEY `coupon_id` (`coupon_id`),  KEY `uid` (`uid`),  KEY `type` (`type`),  KEY `store_id` (`store_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户领取的优惠券信息' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,48),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}coupon_to_product` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `coupon_id` int(11) NOT NULL COMMENT '优惠券id',  `product_id` int(11) NOT NULL COMMENT '产品id',  PRIMARY KEY (`id`),  UNIQUE KEY `id` (`id`),  UNIQUE KEY `id_2` (`id`),  KEY `coupon_id` (`coupon_id`,`product_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠券产品对应表' AUTO_INCREMENT=1",'des'=>'...'),

//2015-07-01 10:18:38
array('time'=>mktimes(1970,1,1,8,47),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}attachment` ADD `ip` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '用户IP地址' , ADD `agent` VARCHAR(1024) NOT NULL COMMENT '用户浏览器信息'",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,46),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}attachment_user` ADD `ip` BIGINT(20) NOT NULL DEFAULT '0' COMMENT '用户IP地址' , ADD `agent` VARCHAR(1024) NOT NULL COMMENT '用户浏览器信息'",'des'=>'...'),

//2015-06-26 15:48:31
array('time'=>mktimes(1970,1,1,8,45),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}service` (  `service_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',  `nickname` char(50) NOT NULL COMMENT '客服昵称',  `truename` char(50) NOT NULL COMMENT '真实姓名',  `avatar` char(150) NOT NULL COMMENT '客服头像',  `intro` text NOT NULL COMMENT '客服简介',  `tel` char(20) NOT NULL COMMENT '电话',  `qq` char(11) NOT NULL COMMENT 'qq',  `email` char(45) NOT NULL COMMENT '联系邮箱',  `openid` char(60) NOT NULL COMMENT '绑定openid',  `add_time` char(15) NOT NULL COMMENT '添加时间',  `status` tinyint(4) NOT NULL COMMENT '客服状态',  `store_id` int(11) NOT NULL COMMENT '所属店铺',  PRIMARY KEY (`service_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='店铺客服列表' AUTO_INCREMENT=1",'des'=>'...'),

//2015-06-26 11:20:39
array('time'=>mktimes(1970,1,1,8,44),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}order_product` ADD `is_present` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '是否为赠品，1：是，0：否'",'des'=>'...'),

//2015-08-07 15:51:28
array('time'=>mktimes(1970,1,1,9,43),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values(92,'ischeck_to_show_by_comment','type=select&value=1:不需要审核评论才显示|0:需审核即可显示评论','1','评论是否需要审核显示','开启后，需商家或管理员审核方可显示，反之：不需审核即可显示','0','','1','0','1')",'des'=>'...'),

//2015-08-12 10:10:28
array('time'=>mktimes(1970,1,1,9,42),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) values(91,'is_allow_comment_control','type=select&value=1:允许商户管理评论|2:不允许商户管理评论','1','是否允许商户管理评论','开启后，商户可对评论进行增、删、查操作','0','','1','0','1')",'des'=>'...'),

//2015-06-18 10:16:25
array('time'=>mktimes(1970,1,1,8,41),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_property_value` (`vid` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品栏目属性值id', `pid` int(10) NOT NULL DEFAULT '0' COMMENT '商品栏目属性名id',`value` varchar(50) NOT NULL DEFAULT '' COMMENT '商品栏目属性值', PRIMARY KEY (`vid`), KEY `pid` (`pid`) USING BTREE, KEY `pid_2` (`pid`,`value`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品栏目属性值' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,40),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_property_type` (`type_id` smallint(5) NOT NULL AUTO_INCREMENT,`type_name` varchar(80) NOT NULL COMMENT '属性类别名',`type_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1为开启，0为关闭',PRIMARY KEY (`type_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='产品属性的类别表' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,39),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_product_to_property_value` ( `id` int(11) NOT NULL AUTO_INCREMENT,`product_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品id',`pid` int(10) NOT NULL DEFAULT '0' COMMENT '系统筛选表id',`vid` int(10) NOT NULL DEFAULT '0' COMMENT '系统筛选属性值id',PRIMARY KEY (`id`), KEY `product_id` (`product_id`) USING BTREE,KEY `vid` (`vid`) USING BTREE) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品关联筛选属性值表' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,38),'type'=>'sql','sql'=>"CREATE TABLE IF NOT EXISTS `{tableprefix}system_product_property` (`pid` int(10) NOT NULL AUTO_INCREMENT, `name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',`sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序字段',`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1：启用，0：关闭',`property_type_id` smallint(5) NOT NULL COMMENT '产品属性所属类别id', PRIMARY KEY (`pid`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品栏目属性名表' AUTO_INCREMENT=1",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,36),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}product_category` ADD `filter_attr` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '拥有的属性id 用,号分割' AFTER `cat_level`",'des'=>'...'),

//2015-06-15 17:48:03
array('time'=>mktimes(1970,1,1,8,34),'type'=>'sql','sql'=>"UPDATE `{tableprefix}system_menu` SET `fid` = '2' WHERE `{tableprefix}system_menu`.`id` = 41",'des'=>'...'),

//2015-06-15 17:45:29
array('time'=>mktimes(1970,1,1,8,33),'type'=>'sql','sql'=>"UPDATE `{tableprefix}system_menu` SET `name` = '商品栏目属性类别管理', `module` = 'Sys_product_property' WHERE `{tableprefix}system_menu`.`id` = 41",'des'=>'...'),

//2015-06-15 17:42:59
array('time'=>mktimes(1970,1,1,8,32),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}system_menu` (`id`, `fid`, `name`, `module`, `action`, `sort`, `show`, `status`) VALUES(44, 2, '商品栏目属性列表', 'Sys_product_property', 'property', 0, 1, 1),(45, 2, '商品栏目属性值列表', 'Sys_product_property', 'propertyValue', 0, 1, 1)",'des'=>'...'),


//2015-06-13 16:14:39
array('time'=>mktimes(1970,1,1,8,23),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}search_tmp` (  `md5` varchar(32) NOT NULL COMMENT 'md5系统分类表id字条串，例md5(''1,2,3'')',  `product_id_str` text COMMENT '满足条件的产品id字符串，每个产品id以逗号分割',  `expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',  UNIQUE KEY `md5` (`md5`) USING BTREE,  KEY `expire_time` (`expire_time`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统分类筛选产品临时表'",'des'=>'...'),


//2015-06-08 17:05:00
array('time'=>mktimes(1970,1,1,8,19),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (87,'attachment_upload_unlink', 'type=select&value=0:不删除本地附件|1:删除本地附件', '0', '是否删除本地附件', '当附件存放在远程时，如果本地服务器空间充足，不建议删除本地附件', 'base', '基础配置', '14', '0', '1')",'des'=>'...'),

//2015-06-06 16:59:46
array('time'=>mktimes(1970,1,1,8,18),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (84,'notify_appkey', '', '', '', '通知的KEY', '0', '', 0, 0, 0)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,17),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (83,'notify_appid', '', '', '', '通知的appid', '0', '', 0, 0, 0)",'des'=>'...'),

//2015-06-06 15:28:21
array('time'=>mktimes(1970,1,1,8,16),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}config` (`id`,`name` ,`type` ,`value` ,`info` ,`desc` ,`tab_id` ,`tab_name` ,`gid` ,`sort` ,`status`)VALUES (86,'service_key',  'type=text&validate=required:false',  '',  '服务key',  '请填写购买产品时的服务key',  '0',  '',  '1',  '0',  '1')",'des'=>'...'),

//2015-06-06 15:20:41
array('time'=>mktimes(1970,1,1,8,15),'type'=>'sql','sql'=>"INSERT INTO  `{tableprefix}config` (`id`, `name` ,`type` ,`value` ,`info` ,`desc` ,`tab_id` ,`tab_name` ,`gid` ,`sort` ,`status`)VALUES (85,'is_diy_template',  'type=radio&value=1:开启|0:关闭',  '0',  '是否使用自定模板',  '是否使用自定模板',  '0',  '',  '11',  '3',  '1')",'des'=>'...'),

//2015-06-02 18:09:59
array('time'=>mktimes(1970,1,1,8,14),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (82,'web_index_cache', 'type=text&size=20&validate=required:true,number:true,maxlength:5', '0', 'PC端首页缓存时间', 'PC端首页缓存时间，0为不缓存', '0', '', 1, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,13),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (81,'attachment_up_domainname', 'type=text&size=50', 'chenyun.b0.upaiyun.com', '云存储域名', '云存储域名 不包含http://', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,12),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (80,'attachment_up_password', 'type=text&size=50', 'lomos516626', '操作员密码', '操作员密码', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,11),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (79,'attachment_up_username', 'type=text&size=50', 'chenyun', '操作员用户名', '操作员用户名', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,10),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (78,'attachment_up_form_api_secret', 'type=text&size=50', 'rY7h9T/vwffDcQN4tLtJWtn9If4=', 'FORM_API_SECRET', 'FORM_API_SECRET', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,9),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (77,'attachment_up_bucket', 'type=text&size=50', 'chenyun', 'BUCKET', 'BUCKET', 'upyun', '又拍云', 14, 0, 1)",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,8),'type'=>'sql','sql'=>"INSERT INTO `{tableprefix}config` (`id`, `name`, `type`, `value`, `info`, `desc`, `tab_id`, `tab_name`, `gid`, `sort`, `status`) VALUES (76,'attachment_upload_type', 'type=select&value=0:保存到本服务器|1:保存到又拍云', '1', '附件保存方式', '附件保存方式', 'base', '基础配置', 14, 0, 1)",'des'=>'...'),

//2015-08-12 10:20:01
array('time'=>mktimes(1970,1,1,8,7),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}config` ADD UNIQUE (`name`)",'des'=>'...'),
//2015-08-07 13:17:27
array('time'=>mktimes(1970,1,1,8,6),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}config` ADD `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST",'des'=>'...'),
array('time'=>mktimes(1970,1,1,8,5),'type'=>'sql','sql'=>"ALTER TABLE `{tableprefix}config` DROP PRIMARY KEY",'des'=>'...'),


//2015-06-02 10:27:47
array('time'=>mktimes(1970,1,1,8,4),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}attachment_user` (  `pigcms_id` int(11) NOT NULL auto_increment COMMENT '自增ID',  `uid` int(11) NOT NULL COMMENT 'UID',  `name` varchar(50) NOT NULL COMMENT '名称',  `from` tinyint(1) NOT NULL default '0' COMMENT '0为上传，1为导入，2为收藏',  `type` tinyint(1) NOT NULL default '0' COMMENT '0为图片，1为语音，2为视频',  `file` varchar(100) NOT NULL COMMENT '文件地址',  `size` bigint(20) NOT NULL COMMENT '尺寸，byte字节',  `width` int(11) NOT NULL COMMENT '图片宽度',  `height` int(11) NOT NULL COMMENT '图片高度',  `add_time` int(11) NOT NULL COMMENT '添加时间',  `status` tinyint(4) NOT NULL default '1' COMMENT '状态',  PRIMARY KEY  (`pigcms_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员附件表'",'des'=>'...'),

//2015-05-26 10:27:21
array('time'=>mktimes(1970,1,1,8,3),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}store` CHANGE  `collect`  `collect` INT( 11 ) UNSIGNED NOT NULL COMMENT  '店铺收藏数'",'des'=>'...'),

//2015-05-26 10:26:37
array('time'=>mktimes(1970,1,1,8,2),'type'=>'sql','sql'=>"ALTER TABLE  `{tableprefix}product` CHANGE  `collect`  `collect` INT( 11 ) UNSIGNED NOT NULL COMMENT  '收藏数'",'des'=>'...'),

//2015-05-25 13:39:21
array('time'=>mktimes(1970,1,1,8,1),'type'=>'sql','sql'=>"CREATE TABLE `{tableprefix}user_collect` (  `collect_id` int(11) unsigned NOT NULL auto_increment,  `user_id` mediumint(8) unsigned NOT NULL default '0',  `dataid` int(11) unsigned NOT NULL default '0' COMMENT '当type=1，这里值为商品id，type=2，此值为店铺id',  `add_time` int(11) unsigned NOT NULL default '0',  `type` tinyint(1) NOT NULL COMMENT '1:为商品；2:为店铺',  `is_attention` tinyint(1) NOT NULL default '0' COMMENT '是否被关注(0:不关注，1：关注)',  PRIMARY KEY  (`collect_id`),  KEY `user_id` (`user_id`),  KEY `goods_id` (`dataid`),  KEY `is_attention` (`is_attention`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户收藏店铺or商品' AUTO_INCREMENT=1",'des'=>'...'),


);
?>