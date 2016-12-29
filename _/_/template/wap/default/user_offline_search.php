<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>用户创建订单-<?php echo option('config.site_name') ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/user_offline_search.css">	
	<style>
	.motify{
		display:none;
		position:fixed;
		top:35%;
		left:50%;
		width:220px;
		padding:0;
		margin:0 0 0 -110px;
		z-index:9999;
		background:rgba(0, 0, 0, 0.8);
		color:#fff;
		font-size:14px;
		line-height:1.5em;
		border-radius:6px;
		-webkit-box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);
		box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);
		@-webkit-animation-duration 0.15s;
		@-moz-animation-duration 0.15s;
		@-ms-animation-duration 0.15s;
		@-o-animation-duration 0.15s;
		@animation-duration 0.15s;
		@-webkit-animation-fill-mode both;
		@-moz-animation-fill-mode both;
		@-ms-animation-fill-mode both;
		@-o-animation-fill-mode both;
		@animation-fill-mode both;
	}
	.motify .motify-inner{
		padding:10px 10px;
		text-align:center;
		word-wrap:break-word;
	}
	.motify p{
		margin:0 0 5px;
	}
	.motify p:last-of-type{
		margin-bottom:0;
	}
	@-webkit-keyframes motifyFx{
		0%{-webkit-transform-origin:center center;-webkit-transform:scale(1);opacity:1;}
		100%{-webkit-transform-origin:center center;-webkit-transform:scale(0.85);}
	}
	@-moz-keyframes motifyFx{
		0%{-moz-transform-origin:center center;-moz-transform:scale(1);opacity:1;}
		100%{-moz-transform-origin:center center;-moz-transform:scale(0.85);}
	}
	@keyframes motifyFx{
		0%{-webkit-transform-origin:center center;-moz-transform-origin:center center;transform-origin:center center;-webkit-transform:scale(1);-moz-transform:scale(1);transform:scale(1);opacity:1;}
		100%{-webkit-transform-origin:center center;-moz-transform-origin:center center;transform-origin:center center;-webkit-transform:scale(0.85);-moz-transform:scale(0.85);transform:scale(0.85);}
	}
	.motifyFx{@-webkit-animation-name motifyFx;@-moz-animation-name motifyFx;@-ms-animation-name motifyFx;@-o-animation-name motifyFx;@animation-name motifyFx;}
		
	</style>
	<script>
	var noCart = true;
	</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
	<script src="<?php echo TPL_URL;?>js/user_offline_search.js?time=<?php echo time() ?>"></script>
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
</head>
<body>
	<div class="twocode js-scan">
		<img src="<?php echo TPL_URL;?>images/twocode.png" alt="" />
		扫一扫
	</div>
	<div class="search">
		<input class="fl js-phone" type="text" placeholder="请输入商家手机号" />
		<span class="fr searchbtn js-searchbtn"></span>
		<div class="clear"></div>
	</div>

	<!-- 有数据的时候 -->
	<div class="shop_content" >
		<ul class="shoplist js-shop_list">
		</ul>
	</div>
	<?php echo $share_data ?>
<script type="text/javascript">
	var scan_qrcode_scenario = "<?php echo $scene ?>";
	$(function() {
		$(".js-scan").click(function () {
			scan_qrcode_func();
		});
	});
	//扫一扫回调
	function scan_qrcode_callback(data) {
		if (data == '' || data == undefined) {
			motify.log('未找到店铺');
		}
		
		var data = data.split('-');
		var card = data[0]; // 1条形码 2二维码
		var scene = data[1];
		var store_id = data[2];
		
		if (card != 2) {
			motify.log('扫一扫只能扫描店铺做单二维码');
			return false;
		}
		
		if (scan_qrcode_scenario != scene) {
			motify.log('扫码场景有误，请扫描本站的店铺做单二维码');
			return false;
		}
		
		if (store_id == undefined || store_id == '') {
			motify.log('店铺不存在');
		}
		
		$.post("check_ewm.php?action=store_scan", {'store_id': store_id, 'card': card, 'scene': scene}, function(result) {
			if (result.err_code == 0) {
				location.href = "user_offline.php?store_id=" + store_id;
			} else {
				motify.log(result.err_msg);
			}
		});
	}
</script>
</body>
</html>