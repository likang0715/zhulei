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
.g-Cart-list {
    width: 100%;
}
.marginB {
    margin-bottom: 100px;
}
.g-Cart-list li {
    clear: both;
    padding: 10px;
    border-bottom: 1px solid #dedede;
}
.g-Cart-list .u-Cart-img {
    display: block;
    padding: 5px;
    border: 1px solid #e5e5e5;
    border-radius: 3px;
}
.fl {
    float: left;
}
.g-Cart-list .u-Cart-img img {
    display: block;
    width: 50px;
}
.g-Cart-list .u-Cart-r {
    margin-left: 70px;
    position: relative;
}
.u-Cart-r a.gray6 {
    display: block;
    height: 16px;
    line-height: 16px;
    overflow: hidden;
    font-size: 14px;
}
.gray6 {
    color: #666;
}
.u-Cart-r span {
    display: block;
    margin: 3px 0;
}
.gray9 {
    color: #999;
}
.wrapper em {
    margin: 0 3px;
    font-family: Arial,Helvetica,sans-serif;
}
.u-Cart-r input {
    border: 1px solid #dedede;
    border-radius: 3px;
    background: #fff;
    width: 60px;
    height: 22px;
    line-height: 22px;
    padding: 0 3px;
    text-align: center;
}
.u-Cart-r a.z-del {
    display: block;
    padding: 5px;
    position: absolute;
    bottom: 0;
    right: 0;
}
.cerror {
    width: 256px;
    height: 46px;
    position: absolute;
    left: 50%;
    margin-left: -128px;
    top: -5px;
    display: none;
}
.Prompt {
    color: #fff;
    border-radius: 5px;
    width: 100%;
    height: 100%;
    line-height: 45px;
    margin: 0 auto;
    text-align: center;
    background: rgba(0,0,0,0.7);
    font-size: 16px;
}
.empty {
    text-align: center;
    font-size: 18px;
    padding: 50px 0;
    color: #999;
}
.g-Total-bt {
    clear: both;
    width: 100%;
    line-height: 30px;
    font-size: 14px;
    background: #f7f7f7;
    position: absolute;
    position: fixed;
    bottom: 0;
    display: inline-block;
}
.g-Total-bt dt {
    background: #fafafa;
}
.g-Total-bt dt, .g-Total-bt dd {
    border-top: 1px solid #dedede;
    padding: 0 10px;
}
.g-Total-bt span {
    margin-right: 10px;
}
.wrapper em {
    margin: 0 3px;
    font-family: Arial,Helvetica,sans-serif;
}
.orange {
    color: #f60;
}
.g-Total-bt dd {
    background: #f7f7f7;
}
.g-Total-bt dt, .g-Total-bt dd {
    border-top: 1px solid #dedede;
    padding: 0 10px;
}
.g-Total-bt a.w_account {
    display: block;
    width: 100%;
}
.g-Total-bt a {
    font-size: 16px;
    height: 35px;
    line-height: 35px;
    text-align: center;
    border-radius: 5px;
    margin: 8px 0;
}
.orangeBtn {
    background: #f60;
    color: #fff;
}

.u-Cart-r a.z-del s {
    display: block;
    background-position: 0 -18px;
    width: 15px;
    height: 17px;
}
.u-Cart-r a.z-del s, .other_pay s, .other_pay i, .g-pay-auto s, .g-pay-auto i {
    background: url(http://demo.pigcms.cn/tpl/static/unitary/css/img/c_set.png?v=140902);
    background-size: 25px auto;
}
.cart_del {
    width: 256px;
    height: 126px;
    position: fixed;
    left: 50%;
    margin-left: -128px;
    top: 50%;
    margin-top: -63px;
    display: none;
    z-index: 102;
}
body {
    min-width: 320px;
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
<div id="loadingPicBlock">
	<div class="wrapper">
		<div class="g-Cart-list marginB">
			<ul id="cartBody">
				<li class="unitary_cart" unitaryid="754" id="unitary_cart8496" style="position:relative;">
					<a class="fl u-Cart-img"><img src="http://image.pigcms.com/pyxtbb1440638937/2015/10/28/1445995308_1i39sy0cgvjbnl72.jpg" border="0" alt=""></a>
					<div class="u-Cart-r">
						<a class="gray6">活动名称</a>
						<span class="gray9">剩余<em id="ycount8496">493969</em>人次 </span>
						<input cid="8496" name="" maxlength="7" type="number" id="cart_count8496" class="gray6 cart_count" value="3"><a cid="8496" class="z-del"><s></s></a>
					</div>
					<div class="cerror" id="cerror8496"><div class="Prompt"></div></div>
				</li>
			</ul>
			<div id="divNone" class="empty" style="display: none;"><s></s>
						购物车为空
			</div>
		</div>
		<div id="mycartpay" class="g-Total-bt" style="bottom: 0px;">
			<dl><dt class="gray6"><span>共<em class="orange" id="sum">1</em>个商品</span>合计<em class="orange" id="total">3.00</em>元</dt><dd><a href="javascript:buy();" class="orangeBtn w_account">去结算</a></dd></dl>
		</div>
		<div class="footer" style="display:none;">
			<ul>
				<li class="f_whole"><a href="/index.php?g=Wap&amp;m=Unitary&amp;a=index&amp;token=pyxtbb1440638937" title="所有商品"><i></i>所有商品</a></li>
				<li class="f_car"><a id="btnCart" href="/index.php?g=Wap&amp;m=Unitary&amp;a=cart&amp;token=pyxtbb1440638937" class="hover" title="购物车"><i></i>购物车</a></li>
				<li class="f_personal"><a href="/index.php?g=Wap&amp;m=Unitary&amp;a=my&amp;token=pyxtbb1440638937" title="我的"><i></i>我的</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="pageDialogBG" class="pageDialogBG"></div>
<div id="cart_del" class="cart_del">
	<div class="clearfix m-round u-tipsEject">
		<div class="u-tips-txt">您确定要删除吗？</div>
		<div class="u-Btn"><div class="u-Btn-li"><a id="btnMsgCancel" class="z-CloseBtn">取消</a></div><div class="u-Btn-li"><a id="btnMsgOK" class="z-DefineBtn">确定</a></div></div>
	</div>
</div>
<div id="error" class="error"><div class="Prompt"></div></div>
				


			
<!-------------------------->			
			</div>
			
		</div>
	</body>
</html>