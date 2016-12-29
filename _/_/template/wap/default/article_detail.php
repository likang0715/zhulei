
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimum-scale=1.0,maximum-scale=1.0,minimal-ui">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<title>店铺动态</title>
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css" />
<style type="text/css">
body{font-family: 'Microsoft YaHei'}
.shopIndex{   background:#fff; margin-top:8px; border-bottom:1px solid #e6e6e6; border-top:1px solid #e6e6e6; padding:0 10px;} 
.shopIndex .title{ line-height:35px; border-bottom:1px solid #e6e6e6;}
.shopIndex .title span{ display:inline-block; width:50%; color:#333; font-size:14px;}
.shopIndex .title span:last-child{ font-size:10px; color:#999; text-align:right}
.shopIndex .title span i{ width:11px; height:11px; background:url(../images/UI1_27.png); background-size:100%;    display: inline-block;}
.shopIndex .shopInfo{padding: 10px 0;}
.shopIndex .shopInfo .shopImg{ float:left; width:84px;}
.shopIndex .shopInfo .shopTxt{ float:left;margin-left: 10px;    line-height: 40px; }
.shopIndex .shopInfo .shopTxt h2{ font-size:12px; color:#333333;  font-weight:normal ; width: 141px;    overflow: hidden;    text-overflow: ellipsis;    white-space: nowrap;}
.shopIndex .shopInfo .shopTxt p{font-size:10px; color:#999999;    }
.shopIndex .shopInfo button{    margin-top: 20px; background:none; float:right; width:65px; height:30px; border:2px solid #ff5c5c; line-height:30px; border-radius:3px; color:#ff5c5c}
.shopIndex .shopInfo button i{ display:inline-block; width:15px; height:15px; background:url(<?php echo TPL_URL;?>/images/icons/UI2_34.png) no-repeat; background-size:100%;vertical-align: middle;    margin-top: -3px;    margin-right: 3px;}
.shopIndex .shopInfo button i.active{ background:url(<?php echo TPL_URL;?>/images/icons/UI2_34-1.png) no-repeat; background-size:100%}
.shopIndex .shopList{}
.shopIndex .shopList>li{position: relative;    padding-bottom: 20px;}
.shopIndex .shopList>li>p{ font-size:12px; color:#666;    width: 100%;    white-space: nowrap;    overflow: hidden;    text-overflow: ellipsis;}
.shopIndex .shopList>li ul li{ float:left; width:31%; margin:10px 0;    text-align: center; } 
.shopIndex .shopSpot {  bottom:20px}

.shopDynamic{ background:#fff; margin-top:8px; border-bottom:1px solid #e6e6e6; border-top:1px solid #e6e6e6; padding:0 10px;}
.shopDynamic .title{    padding: 10px 0;}
.shopDynamic .title p{ font-size:10px; color:#999}
.shopDynamic .title h2{ font-size:12px; color:#333; float:left; line-height:30px; font-weight:normal}
.shopDynamic .title .button{ float:right;}
.shopDynamic .title .button span{vertical-align: top; text-align:center; font-size:12px;  display:inline-block; background:#ff6634;  width:65px; height:30px; line-height:30px; border-radius:3px; color:#fff}
.shopDynamic .button button{vertical-align: top;  font-size:12px; background:none;  width:65px; height:30px; border:2px solid #ff5c5c; line-height:26px; border-radius:3px; color:#ff5c5c}
.shopDynamic .button button i{ display:inline-block; width:15px; height:15px; background:url(<?php echo TPL_URL;?>/images/icons/UI2_34.png) no-repeat; background-size:100%;vertical-align: middle;    margin-top: -3px;    margin-right: 3px;}
.shopDynamic .button button i.active{ background:url(<?php echo TPL_URL;?>/images/icons/UI2_34-1.png) no-repeat; background-size:100%}
.shopDynamic .shopInfo{}
.shopDynamic .shopInfo p{ font-size:12px; color:#333333; line-height:20px;}
.shopDynamic .shopInfo li{ float:left; width:31%; margin:8px 1.17%; text-align:center;}
.shopShopping{ background:#f5f5f5; padding:5px;    margin-bottom: 50px;}
.shopShopping .shopImg{ float:left; width:40px; overflow:hidden;}
.shopShopping h1{font-weight:normal; font-size:12px; color:#666666; line-height:40px; float:left;    margin-left: 5px;    width: 194px;    overflow: hidden;    white-space: nowrap;    text-overflow: ellipsis;}
.shopShopping span{ float:right; font-size:10px; color:#999999;line-height:40px;}
.shopShopping span i{width:11px; height:11px; background:url(<?php echo TPL_URL;?>/images/icons/UI1_27.png); background-size:100%;    display: inline-block;}
</style>
</head>

<body style="background:#f9f9f9">
<div class="shopDynamic">
    <div class="title clearfix">
        <h2><?php echo $article['title']?></h2>
        <div class="button">
            <a href="/wap/home.php?id=<?php echo $article['store_id']?>" ><span>逛店铺</span></a>
            <button><i></i>5436</button>
        </div>
        <div style="clear:both"></div>
        <p><?php echo date('Y-m-d H:i:s',$article['dateline'])?></p>
    </div>
    <div class="shopInfo">
        <p><?php echo $article['desc']?></p>
        <ul class="clearfix">
        <?php $imgs = explode(',',$article['pictures']);?>
        <?php foreach($imgs as $img){?>
            <li><img src="<?php echo getAttachmentUrl($img)?>" width=110 height=110 /></li>
        <?php }?>
        </ul>
    </div>
    <div class="shopShopping clearfix">
    <div class="shopImg"><img src="<?php echo getAttachmentUrl($product['image'])?>" width=40 height=40 /></div>
    <h1><?php echo $product['name']?></h1>
    <a href="/wap/good.php?id=<?php echo $product['product_id']?>&platform=1"><span>去购买<i></i></span></a>
    </div>
</div>
</body>
<script src="js/jquery-1.7.2.js" type="text/javascript"></script>
 
<script>
$(function(){
	$(".shopDynamic .button button").click(function(){
		$(this).find("i").addClass("active");
		});
	});
</script>
</html>
