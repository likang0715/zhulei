<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>我的一元夺宝 - <?php echo $now_store['name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/customer.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/coupon.css"/>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/coupon11.js"></script>
<style>
.wrapper {
    min-width: 320px;
    width: 100%;
    margin: 0 auto;
    background: #fff;
}
.calCon {
    width: 100%;
    margin-bottom: 77px;
}
.calCon .dl1, .calCon .dl3 {
    color: #999;
}
.calCon dl {
    clear: both;
    line-height: 34px;
}
.calCon .dl1 dt {
    background: #f7f7f7;
    height: 34px;
    line-height: 34px;
    font-size: 14px;
}

.calCon span {
    width: 25%;
    height: 34px;
    display: block;
    float: left;
    text-align: center;
}
.calCon .dl1 dt span:nth-child(5n-4) {
    text-indent: -1em;
}
.calCon dd {
    height: 34px;
    font-size: 10px;
    font-size: 11px;
}
.calCon .dl1 dd {
    border-top: 1px solid #dedede;
}
.calCon span {
    width: 25%;
    height: 34px;
    display: block;
    float: left;
    text-align: center;
}
.calCon .dl2 {
    color: #666;
    background: #fffcda;
}
.calCon dl {
    clear: both;
    line-height: 34px;
}
.calCon .dl2 dt {
    font-size: 12px;
    background: #f60;
    padding: 15px 0;
    text-align: center;
    color: #fff;
    line-height: 18px;
    word-wrap: break-word;
}
.calCon .dl2 dd {
    border-bottom: 1px solid #ffe197;
}
.calCon .dl2 span {
    position: relative;
}
.calCon .dl2 span {
    position: relative;
}

.calCon .dl2 span:nth-child(4n-1) {
    color: #f60;
}
.calCon .dl2 em {
    white-space: nowrap;
    word-break: keep-all;
}
.calCon .dl2 i {
    border-style: solid;
    border-width: 4px 0 4px;
    border-color: transparent;
    border-left: 4px solid rgb(255,102,0);
    width: 0;
    height: 0;
    font-size: 0;
    line-height: 0;
    position: absolute;
    top: 13px;
    left: 0;
}
.calCon .dl2 i em {
    border-style: solid;
    _border-style: dashed;
    border-width: 4px;
    border-color: transparent;
    border-left-width: 0;
    border-left: 4px solid #fffcda;
    width: 0;
    height: 0;
    font-size: 0;
    line-height: 0;
    position: absolute;
    top: -4px;
    left: -5px;
}
.calCon .dl2 em {
    white-space: nowrap;
    word-break: keep-all;
}
.calCon .dl2 span:nth-child(3n-1) s, .calCon .dl2 span:nth-child(4n-1) s {
    width: 1px;
    height: 35px;
    background: #F60;
    position: absolute;
    top: 0;
    right: 0;
}


.calCon .dl1, .calCon .dl3 {
    color: #999;
}
.calCon .dl3 dt {
    font-size: 12px;
    background: #f60;
    padding: 15px;
    color: #fff;
    line-height: 18px;
    position: relative;
}
</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
<!----------------------->

<body>
<body>
	<div class="wrapper">
		<div id="calResult" class="calCon">
			<dl class="dl1">
				<dt><span>购买时间</span><span></span><span>转换数据</span><span>会员账号</span></dt>
				<dd><span>2016-02-27</span><span>14:27:02.095</span><span></span><span>祝超</span></dd>
				<dd><span>2016-02-27</span><span>14:25:21.880</span><span></span><span>祝超</span></dd>
				<dd><span>2016-02-27</span><span>14:25:21.880</span><span></span><span>祝超</span></dd>
				<dd><span>2016-02-27</span><span>14:25:21.880</span><span></span><span>祝超</span></dd>
				<dd><span>2016-02-27</span><span>14:25:21.820</span><span></span><span>祝超</span></dd>
			</dl>
			<dl class="dl2"><dt>最后一位购买时间【2016-02-27 09:46:13.182】<br>之前100条全站购买时间记录</dt>
			<dd><span>2016-02-27<b></b></span><span>09:46:13.182<s></s></span><span><i><em></em></i>094613182<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:46:13.181<s></s></span><span><i><em></em></i>094613181<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:42:15.260<s></s></span><span><i><em></em></i>094215260<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:41:41.313<s></s></span><span><i><em></em></i>094141313<s></s></span><span>祝超</span></dd>
			<dd><span>2016-02-27<b></b></span><span>09:40:03.284<s></s></span><span><i><em></em></i>094003284<s></s></span><span>祝超</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.069<s></s></span><span><i><em></em></i>093255069<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd><dd>
			<span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd><dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd><dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.068<s></s></span><span><i><em></em></i>093255068<s></s></span><span>亚樱</span></dd>
			<dd><span>2015-11-18<b></b></span><span>09:32:55.058<s></s></span><span><i><em></em></i>093255058<s></s></span><span>亚樱</span></dd>
		</dl>
		<dl class="dl3">
			<dt>1、求和：9339459438 (上面100条购买记录时间取值相加之和)<br>2、取余：9339459438 (100条时间记录之和) % 100 (本商品总需参与人次) = 38(余数)<br>3、结果：38(余数) + 100000 = 100038 (最终结果)<i></i></dt>
			<dd><span>2015-11-18</span><span>09:32:55.068</span><span></span><span>亚樱</span></dd>
			<dd><span>2015-11-18</span><span>09:32:55.068</span><span></span><span>亚樱</span></dd>
			<dd><span>2015-11-18</span><span>09:32:55.068</span><span></span><span>亚樱</span></dd>
			<dd><span>2015-11-18</span><span>09:32:55.068</span><span></span><span>亚樱</span></dd>
			<dd><span>2015-11-18</span><span>09:32:55.068</span><span></span><span>亚樱</span></dd>
		</dl>
	</div>
</div>
	
</body>
			

			
<!-------------------------->			
			</div>
			
		</div>
	</body>
</html>