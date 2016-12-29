<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8"/>
<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
<meta name="description" content="<?php echo $config['seo_description'];?>" />
<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
<title>商品收藏与关注</title>
<meta name="format-detection" content="telephone=no"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />
<meta name="applicable-device" content="mobile"/>
<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/history.css"/>
</head>
<style type="text/css">
.tabber { width: 100%; color: #333; font-size: 14px; background-color: #fff; -webkit-border-image: url("/v2/image/wap/border-line.png") 2 stretch; -moz-border-image: url("/v2/image/wap/border-line.png") 2 stretch; border-image: url("/v2/image/wap/border-line.png") 2 stretch; border-top: 2px solid #e5e5e5 }
@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min--moz-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5) {
.tabber {
border-top-width:1px;
}
}
.tabber button, .tabber a { float: left; width: 50%; height: 40px; line-height: 40px; border: 0px none; -webkit-border-image: url("/v2/image/wap/border-line.png") 2 stretch; -moz-border-image: url("/v2/image/wap/border-line.png") 2 stretch; border-image: url("/v2/image/wap/border-line.png") 2 stretch; border-bottom: 2px solid #e5e5e5; outline: 0px none; background-color: #fff; position: relative; text-align: center; text-overflow: ellipsis; white-space: nowrap; overflow: hidden }
@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min--moz-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5) {
.tabber button, .tabber a {
border-bottom-width:1px;
}
}
.tabber button.active, .tabber a.active { color: #22C415; -webkit-border-image: initial; -moz-border-image: initial; border-image: initial; border-bottom: 1px solid #22C415 }
.tabber button.first, .tabber a.first { border-right: 0px none }
.tabber.tabber-top button.active, .tabber.tabber-top a.active { border-top: 1px solid #22C415; -webkit-border-image: initial; -moz-border-image: initial; border-image: initial; border-bottom: 0px none }
.tabber.tabber-top button.first, .tabber.tabber-top a.first { border-right: 1px solid #e5e5e5 }
.tabber.tabber-n3 button, .tabber.tabber-n3 a { width: 33.3% }
.tabber.tabber-n4 button, .tabber.tabber-n4 a { width: 25% }
.tabber.tabber-n5 button, .tabber.tabber-n5 a { width: 20% }
.tabber.orange { color: #f60 }
.tabber.orange button.active, .tabber.orange a.active { color: #f60; border-bottom: 1px solid #f60 }
.tabber.red { color: #333 }
.tabber.red button.active, .tabber.red a.active { color: #ed5050; border-bottom: 1px solid #ed5050 }
.tabber.tabber-double-11 { border: 0px none; overflow: hidden; margin-bottom: 1px }
.tabber.tabber-double-11 a { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; border: 0px none; color: #999; display: block; -webkit-border-image: url("/v2/image/wap/border-line.png") 2 stretch; -moz-border-image: url("/v2/image/wap/border-line.png") 2 stretch; border-image: url("/v2/image/wap/border-line.png") 2 stretch; border-bottom: 2px solid #e5e5e5 }
@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min--moz-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5) {
.tabber.tabber-double-11 a {
border-bottom-width:1px;
}
}
.tabber.tabber-double-11 a.active { color: #F15A0C; border-top: 0px none; border-bottom: 2px solid #F15A0C; -webkit-border-image: initial; -moz-border-image: initial; border-image: initial }
.tabber.tabber-double-11.tabber-fixed { z-index: 9; position: fixed; top: 0; left: 0; width: 100% }
.tabber.tabber-double-11.tabber-fixed a { background-color: #fff }
.tabber.tabber-double-11.tabber-one-line { height: 40px }
.tabber.tabber-double-11.tabber-two-line { height: 80px }
</style>
<body>
<div class="tabber tabber-n2 tabber-double-11 clearfix"> <a <?php if($_GET['action']=='guanzhu'){?>class="active"<?php } ?> href="./my_goods.php?action=guanzhu">关注</a> <a <?php if($_GET['action']=='shoucang'){?>class="active"<?php } ?> href="./my_goods.php?action=shoucang">收藏</a></div>

<div class="wx_wrap"><?php if(is_array($attention_list)){ ?>
	<ul class="mod_list recent" id="recentList">
		<?php foreach($attention_list as $v){ ?>
		<li class="hproduct"> <a href="<?php echo $new_product_list[$v['data_id']]['link'];?>">
			<div class="list_inner">
				<div class="photo"><img src="<?php echo $new_product_list[$v['data_id']]['image'];?>"/></div>
				<div class="info">
					<p class="title"><?php echo $new_product_list[$v['data_id']]['name'];?></p>
					<p class="price">¥<?php echo $new_product_list[$v['data_id']]['price'];?></p>
				</div>
				<div class="time" style="white-space:nowrap;"><?php echo time_tran(date('Y-m-d H:i:s',$v['add_time']));?></div>
			</div>
			</a> 
			<p><span style="cursor:pointer" class="cancel_guanzhu" onClick="cancel_goods($(this),'attention_cancel')" product-id="<?php echo $v['data_id']?>">取消关注</span></p>
			</li>
		<?php } ?>
	</ul>
<?php } ?>
</div>



<div class="wx_wrap" style=" display:none"><?php if(is_array($collect_list)){ ?>
	<ul class="mod_list recent" id="recentList">
		<?php foreach($collect_list as $v){ ?>
		<li class="hproduct"> <a href="<?php echo $new_product_list[$v['dataid']]['link'];?>">
			<div class="list_inner">
				<div class="photo"><img src="<?php echo $new_product_list[$v['dataid']]['image'];?>"/></div>
				<div class="info">
					<p class="title"><?php echo $new_product_list[$v['dataid']]['name'];?></p>
					<p class="price">¥<?php echo $new_product_list[$v['dataid']]['price'];?></p>
				</div>
				
				<div class="time" style="white-space:nowrap;"><?php echo time_tran(date('Y-m-d H:i:s',$v['add_time']));?></div>
			</div>
			</a><p><span style="cursor:pointer" class="cancel_shoucang" onClick="cancel_goods($(this),'cancel')" product-id="<?php echo $v['dataid']?>">取消收藏</span></p> </li>
		<?php } ?>
	</ul>
<?php } ?>
</div>

<?php echo $shareData;?> 
<script type="text/javascript">
<?php if($_GET['action']=='guanzhu'){?>
$('.wx_wrap').eq(0).show();
$('.wx_wrap').eq(1).hide();
<?php }else if($_GET['action']=='shoucang'){ ?>
$('.wx_wrap').eq(1).show();
$('.wx_wrap').eq(0).hide();
<?php } ?>


function cancel_goods(obj,sMethod){
	var product_id=obj.attr('product-id');
	var url = "/index.php?c=collect&a="+sMethod+"&id=" + product_id + "&type=1";
	$.get(url,function(data){
		if(data.status){
			alert(data.msg);
			location.reload();
		}
	},'json');
}
</script>
</body>
</html>