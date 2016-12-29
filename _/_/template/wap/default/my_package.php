<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>包裹状态</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	</head>
	<body class=" hIphone" style="padding-bottom: initial;background: #ecedf1;">
	<div id="fis_elm__0"></div>
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>courier_style/css/lib.css">
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>courier_style/css/style_package.css">
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>courier_style/css/order.css">
	<script type="text/javascript" src="<?php echo TPL_URL;?>courier_style/js/jquery-1.7.2.js"></script>
	<div id="fis_elm__1"></div>
	<img src="<?php echo TPL_URL ?>courier_style/images/hm.gif" width="0" height="0" style="display:block">
	<div id="wrapper" class="">
		<div id="fis_elm__2">
	        <div id="common-widget-nav" class="common-widget-nav ">
	            <div class="left-slogan"> <a class="left-arrow icon-arrow-left2" data-node="navBack" href="javascript:history.go(-1);"></a> </div>
	            <div class="center-title"> <a href="javascript:void(0)"><?php echo $nowPhysical['name'] ?></a> </div>
	            <div class="right-slogan "> <a class="tel-btn" href="tel:<?php echo $nowPhysical['phone'] ?>"><i class="icon-phone"></i></a> </div>
	        </div>
	    </div>
	    <div id="fis_elm__3">
	        <div id="common-widget-tab" class="common-widget-tab">
	            <ul class="order-tab">
	            <?php foreach ($myPackages as $key => $package) { ?>
	                <li class="<?php if ($package_id == $package['package_id']) echo 'active'; ?>"><a href="./my_package.php?order_id=<?php echo $order_id ?>&package_id=<?php echo $package['package_id'] ?>">包裹<?php echo $key + 1 ?></a></li>
	            <?php } ?>
	            </ul>
	        </div>
	    </div>
	    <div id="fis_elm__4">
	        <div id="order-widget-orderhistory" class="order-widget-orderhistory">
	            <div data-node="timeLine" class="timeline" style="height:64.98%"></div>
	            <div class="relative-wrapper">
	                <div class="item">
	                    <div class="status-icon">
	                    	<span class="-mark">
	                    		<img src="<?php echo TPL_URL ?>courier_style/images/3.png">
		                    </span>
	                  	</div>
	                    <div class="status-card">
	                        <div class="card-arrow"></div>
	                        <div class="card-content">
	                            <p class="big">
	                            	订单提交成功<span><?php echo date('Y-m-d H:i', $nowOrder['add_time']) ?></span>
	                            </p>
	                            <p class="small"> 
	          						<span>订单编号：<?php echo $nowOrder['order_no_txt'] ?></span>
	                            </p>
	                        </div>
	                    </div>
	                </div>
	                <div class="item">
	                    <div class="status-icon">
	                    	<span class="-mark">
	                    		<img src="<?php echo TPL_URL ?>courier_style/images/1.png">
		                    </span>
	                  	</div>
	                    <div class="status-card">
	                        <div class="card-arrow"></div>
	                        <div class="card-content">
	                            <p class="big">
	                            	 商家确认订单<span><?php echo date('Y-m-d H:i', $nowPackage['add_time']) ?></span>
	                            </p>
	                            <p class="small"> 
	          						 <span> 门店【<?php echo $nowPhysical['name'] ?>】正在为您准备商品 </span>
	                            </p>
	                        </div>
	                    </div>
	                </div>

	                <?php if ($nowPackage['status'] > 1) { ?>
	                <div class="item">
	                    <div class="status-icon">
	                    	<span class="-mark">
	                    		<img src="<?php echo TPL_URL ?>courier_style/images/5.png">
	                        </span>
	                  	</div>
	                    <div class="status-card">
	                        <div class="card-arrow"></div>
	                        <div class="card-content">
	                            <p class="big">
	                            	 配送员已取货<span><?php echo date('Y-m-d H:i', $nowPackage['send_time']) ?></span>
	                            </p>
	                            <p class="small"> 
	          						 <span>配送员姓名：<?php echo $nowCourier['name'] ?></span>
	                            </p>
	                            <p class="small">
	                            	<span>电话：<a class="tel-btn" href="tel:<?php echo $nowCourier['tel'] ?>"><?php echo $nowCourier['tel'] ?></a></span>
	                            </p>
	                        </div>
	                    </div>
	                </div>
	                <div class="item">
	                    <div class="status-icon">
	                    	<span class="-mark">
	                    		<img src="<?php echo TPL_URL ?>courier_style/images/5.png">
		                    </span>
	                  	</div>
	                    <div class="status-card">
	                        <div class="card-arrow"></div>
	                        <div class="card-content">
	                            <p class="big">
	                            	 正在配送<span><?php echo date('Y-m-d H:i', $nowPackage['send_time']) ?></span>
	                            </p>
	                            <p class="small"> 
	          						 <span>请耐心等待<a href="./courier_location.php?package_id=<?php echo $package_id ?>&courier_id=<?php echo $nowPackage['courier_id'] ?>" style="float:right">查看配送员位置</a></span>
	                            </p>
	                        </div>
	                    </div>
	                </div>
	                <?php } ?>

	                <?php if ($nowPackage['status'] > 2) { ?>
	                <div class="item">
	                    <div class="status-icon">
	                    	<span class="-mark">
	                    		<img src="<?php echo TPL_URL ?>courier_style/images/2.png">
		                    </span>
	                  	</div>
	                    <div class="status-card">
	                        <div class="card-arrow"></div>
	                        <div class="card-content">
	                            <p class="big">
	                            	 包裹送达<span><?php echo date("Y-m-d H:i", $nowPackage['arrive_time']) ?></span>
	                            </p>
	                            <p class="small"> 
	          						 <span>欢迎您的任何意见和吐槽</span>
	                            </p>
	                        </div>
	                    </div>
	                </div>
	                <?php } ?>
	            </div>
	            <div class="time-btm"> <img src="<?php echo TPL_URL ?>courier_style/images/timer.png">
	                <div class="right-btn">
	                    <div class="title none"> <a class="cui-btn active" href="./my_order.php?action=send">返回订单列表</a> </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="global-mask layout"></div>
	</body>
</html>