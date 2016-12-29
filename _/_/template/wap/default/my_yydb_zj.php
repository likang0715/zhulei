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
.gray6 {
    color: #666;
}
.wrapper {
    min-width: 320px;
    width: 100%;
    margin: 0 auto;
    background: #fff;
}
.m_buylistDet {
    padding: 15px 8px;
}
.m_buylistDet cite {
    float: left;
    width: 102px;
    height: 102px;
    border: 1px solid #e5e5e5;
    border-radius: 3px;
    position: relative;
}
.m_buylistDet cite img {
    width: 92px;
    height: 92px;
    padding: 5px;
}
fieldset, img {
    border: 0;
}
.m_buylistDet dl {
    margin-left: 112px;
    color: #666;
}
.m_buylistDet dt {
    height: 18px;
    line-height: 18px;
    overflow: hidden;
    position: relative;
    top: -2px;
}
.m_buylistDet dd {
    overflow: hidden;
    margin-bottom: 2px;
}
.orange {
    color: #f60;
}
.wrapper em {
    font-family: Arial,Helvetica,sans-serif;
}
.m_buylistDet dd em.orange {
    margin: 0 3px;
}
.Progress-bar {
    zoom: 1;
}
.u-progress {
    height: 5px;
    background: #e7e7e7;
    position: relative;
    border-radius: 3px;
    overflow: hidden;
}
.u-progress .pgbar, .u-progress .pging {
    display: block;
    width: 100%;
    height: 100%;
    border-radius: 3px;
}
.u-progress .pging {
    background: #f60;
}
.Progress-bar .Pro-bar-li li {
    float: left;
    color: #ccc;
    font-size: 10px;
    font-family: 宋体;
    border: none;
    margin: 0;
    padding: 0;
    box-shadow: none;
    border-radius: none;
}
.gRate .Progress-bar li {
    font-size: 12px;
    color: #bbb;
}
.Progress-bar .Pro-bar-li li.P-bar01 {
    width: 30%;
    text-align: left;
}
.Progress-bar .Pro-bar-li li em {
    display: block;
    font-size: 10px;
    font-family: arial;
    height: 14px;
    padding: 2px 0 0 0;
    font-style: normal;
}
.gRate .Progress-bar li em {
    margin: 0;
    padding: 0;
}
.Progress-bar .Pro-bar-li li.P-bar01 em {
    color: #F60;
}
.Progress-bar .Pro-bar-li li.P-bar02 {
    width: 40%;
    text-align: center;
}
.Progress-bar .Pro-bar-li li.P-bar02 em {
    color: #999;
}
.Progress-bar .Pro-bar-li li.P-bar03 {
    width: 30%;
    float: right;
    text-align: right;
}
.Progress-bar .Pro-bar-li li.P-bar03 em {
    color: #2AF;
}
.m_buylistDet dd {
    overflow: hidden;
    margin-bottom: 2px;
}
input, select, textarea {
    -webkit-tap-highlight-color: rgba(0,0,0,0);
    -webkit-appearance: none;
    border: 0;
    border-radius: 0;
}
.m_now dd input, .m_now dd a {
    display: inline-block;
    border-radius: 3px;
    height: 24px;
    border: 1px solid #f60;
}
.m_now dd input {
    background: #fff;
    padding: 0 3px;
    color: #666;
    width: 50px;
    float: left;
    text-align: center;
}
.orangeBtn, .grayBtn, .whiteBtn {
    text-align: center;
    border-radius: 5px;
}
.orangeBtn {
    background: #f60;
    color: #fff;
}
.m_now dd input, .m_now dd a {
    display: inline-block;
    border-radius: 3px;
    height: 24px;
    border: 1px solid #f60;
}
.m_buylistDet dd a.orangeBtn, .m_buylistDet dd a.grayBtn {
    border-radius: 3px;
    line-height: 26px;
    line-height: 26px;
    font-size: 14px;
    display: block;
    margin-top: 2px;
}
.m_now dd a.orangeBtn {
    margin-left: 68px;
    margin-top: 0;
}



.g-Record-ctlst {
    clear: both;
    width: 100%;
}
.marginB {
    margin-bottom: 100px;
}
.g-Record-ctlst li {
    line-height: 22px;
    color: #666;
    border-top: 1px solid #e5e5e5;
    padding: 5px 0 5px 0;
    cursor: pointer;
}
.g-Record-ctlst li p {
    margin: 0 10px;
    color: #bbb;
}
.g-Record-ctlst li span {
    margin-left: 15px;
}
.g-Record-ctlst li b {
    width: 76px;
    display: inline-block;
    text-align: left;
    text-align: center;
	font-weight:normal;
}







address, em, i, cite, s {
    font-style: normal;
}
.m_buylistDet cite i {
    display: block;
    width: 104px;
    height: 18px;
    line-height: 18px;
    color: #fff;
    position: absolute;
    left: -1px;
    bottom: -1px;
    text-align: center;
    filter: alpha(opacity=30);
    -moz-opacity: 0.3;
    -khtml-opacity: 0.3;
    opacity: 0.3;
    border-radius: 0 0 2px 2px;
}
.m_buylistDet cite i {
    background: #000;
}
.m_now cite i {
    background: #f60;
}
body {
    /* min-width: 320px; */
    font-size: 12px;
    font-family: 'microsoft yahei',Verdana,Arial,Helvetica,sans-serif;
    color: #000;
    -webkit-text-size-adjust: none;
}


</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
<!----------------------->

<body>
	<div id="loadingPicBlock">
		<div class="wrapper">
			<div class="m_buylistDet m_now">
				<cite>
					<a href="/index.php?g=Wap&amp;m=Unitary&amp;a=goodswhere&amp;token=pyxtbb1440638937&amp;unitaryid=754">
						<img src="http://image.pigcms.com/pyxtbb1440638937/2015/10/28/1445995308_1i39sy0cgvjbnl72.jpg"><i>进行中</i>
					</a>
				</cite>
				<dl>
					<dt><a href="javascript:;" class="gray6">活动名称</a></dt>
					<dd>已参与<em class="orange">6031</em>人次</dd>
					<dd>
						<div class="gRate">
							<div class="Progress-bar">
								<p class="u-progress" title=""><span class="pgbar" style="width:1.2062%;"><span class="pging"></span></span></p>
								<ul class="Pro-bar-li"><li class="P-bar01"><em>6031</em>已参与</li><li class="P-bar02"><em>500000</em>总需人次</li><li class="P-bar03"><em>493969</em>剩余</li></ul>
							</div>
						</div>
					</dd>
					<dd class="m_addto">
						<input id="txtNum" type="number" maxlength="7" value="1"><a id="btnBuy" href="./my_yydb_detail.php?action=zjjs" class="orangeBtn">追加</a>
					</dd>
				</dl>
			</div>
			<div class="g-Record-ctlst marginB">
				<ul class="lucknum">
					<li><p>2016-02-27 14:27:02<span>1人次</span></p><b>596508</b></li>
				</ul>
				<ul class="lucknum"><li><p>2016-02-27 14:25:21<span>1人次</span></p><b>495644</b></li></ul>
				<ul class="lucknum"><li><p>2016-02-27 14:25:21<span>1人次</span></p><b>394258</b></li></ul
				><ul class="lucknum"><li><p>2016-02-27 14:25:21<span>1人次</span></p><b>359761</b></li></ul>
				<ul class="lucknum"><li><p>2016-02-27 14:25:21<span>1人次</span></p><b>316804</b></li></ul>
				<ul class="lucknum"><li><p>2016-02-27 09:40:03<span>1人次</span></p><b>195970</b></li></ul>
				<div id="divGoodsLoading" class="loading" style="display: none;"><b></b>正在加载</div>
				<div class="load_more" id="btnLoadMore" style="display:none;border-top: 1px solid #e5e5e5;">共6人次</div>
			</div>
			
			
			
			<?php include display('footer');?>
		</div>
	</div>
			

			
<!-------------------------->			
			</div>
			
		</div>
	</body>
</html>