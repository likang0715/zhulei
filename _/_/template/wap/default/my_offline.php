<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>创建订单</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_offline.css?time=11112222">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css">
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
	var store_id = "<?php echo $store['store_id'] ?>";
	var credit_setting = <?php echo json_encode(option("credit")) ?>;
	var scan_qrcode_scenario = "<?php echo $scan_qrcode_scenario; ?>";
	var product_category_list = <?php echo json_encode($product_category_list) ?>;
	var noCart = true;
	</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
	<script src="<?php echo TPL_URL;?>js/my_offline.js?time=<?php echo time() ?>"></script>
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
</head>
<body>
<article class="main" >
<!-- 顶部 -->
	<section class="userinfo">
		<div class="phone">
			<span class="fl userphonetit">用户手机号</span>
			<span class="fl userphone">
				<input type="text" class="js-userphone" old-data="" />
				<ul class="userphone-search fl js-userphone_list" id="scrollbar1" style="display: none; height: auto;">
					
				</ul>
			</span>
			<span class="fl userphonebtn js-userphone_btn">确定</span>
			<span class="fl sweep">
				<img class="fl js-scan" src="<?php echo TPL_URL;?>images/twocode.png" alt="">
				<span class="fl js-scan">扫一扫</span>
				<div class="clear"></div>
			</span>
			<div class="clear"></div>
		</div>
		<div class="nowuser js-nowuser" style="display: none;">
			<img class="fl" src="<?php echo TPL_URL;?>images/user.png" alt="">
			<span class="fl">当前用户为：</span>
		</div>
	</section>
	
	 <!-- 商家名称 -->
	<ul class="buessdo-info">
		<li>
			<div class="fl">商家名称</div>
			<div class="fr"><?php echo htmlspecialchars($store['name']) ?></div>
			<div class="clear"></div>
		</li>
		<li>
			<div class="fl">用户昵称</div>
			<div class="fr"><?php echo $user['nickname'] ?></div>
			<div class="clear"></div>
		</li>
		<li>
			<div class="fl">本单金额</div>
			<div class="fr"><input type="text" class="bessdoinfo-inp js-total" placeholder="请输入本单金额" name="total" old-value="" /></div>
			<div class="clear"></div>
		</li>
		<li>
			<div class="fl">本单需支付服务费</div>
			<div class="fr orange js-service_fee">0</div>
			<div class="clear"></div>
		</li>
		<li>
			<div class="fl">本单发放<?php echo option('credit.platform_credit_name') ?>数</div>
			<div class="fr orange js-send_platform_point">0</div>
			<div class="clear"></div>
		</li>
	</ul>
	
	<!-- 商家财务 -->
	<section class="buessdo-finance">
		<div class="buessdo-tit">商家财务</div>
		<ul class="">
			<li class="fl buessdo-finance-li">
				<p class="buessdo-finance-price"><?php echo $user['point_balance'] ?></p>
				<p class="buessdo-finance-con">商家可用<?php echo option('credit.platform_credit_name') ?></p>
			</li>
			<li class="fl buessdo-finance-li">
				<p class="buessdo-finance-price"><?php echo $store['point_balance'] ?></p>
				<p class="buessdo-finance-con">商家<?php echo option('credit.platform_credit_name') ?></p>
			</li>
			<li class="fl buessdo-finance-li">
				<p class="buessdo-finance-price"><?php echo $store['margin_balance'] ?></p>
				<p class="buessdo-finance-con">充值现金</p>
			</li>
			<li class="clear"></li>
		</ul>
	</section>


	<!-- 商家支付 -->
	<section class="buessdo-pay">
		<div class="buessdo-tit">商家支付</div>
		<ul class="buess-pay-ula">
			<li>
				<div class="fl">
					<img src="<?php echo TPL_URL;?>images/icon-k.png" class="fl buessdo-pay-img" alt="">
					<span class="fl buessdo-pay-tit orange">现金</span>
					<div class="clear"></div>
				</div>
				<div class="fr"><input type="text" placeholder="请输入现金金额" name="cash" class="js_cash" /></div>
				<div class="clear"></div>
			</li>
			<li>
				<div class="fl">
					<img src="<?php echo TPL_URL;?>images/icon-b.png" class="fl buessdo-pay-img buessdo-pay-img-b" alt="">
					<span class="fl buessdo-pay-tit orange">积分</span>
					<div class="clear"></div>
				</div>
				<div class="fr"><input type="text" placeholder="请输入<?php echo option('credit.platform_credit_name') ?>个数" name="platform_point" class="js_platform_point" /></div>
				<div class="clear"></div>
			</li>
		</ul>
		<ul class="buess-pay-ula">
			<li>
				<div class="fl buessdo-pay-tit">商品类别</div>
				<div class="fr buess-pay-doselect">
					<span style="padding-left: 10px;">
						<select class="js-product_category buess-pay-select" style="width: auto;">
							<option value="0">请选择</option>
							<?php 
							foreach ($product_category_list as $product_category) {
							?>
								<option value="<?php echo $product_category['cat_id'] ?>"><?php echo htmlspecialchars($product_category['cat_name']) ?></option>
							<?php 
							}
							?>
						</select>
					</span>
					<span class="js-product_category_container">
						
					</span>
				</div>
				<div class="clear"></div>
			</li>
			<li>
				<div class="fl buessdo-pay-tit">商品名称</div>
				<div class="fr"><input type="text" placeholder="请输入商品名称" name="product_name" class="js_product_name" /></div>
				<div class="clear"></div>
			</li>
			<li>
				<div class="fl buessdo-pay-tit">商品数量</div>
				<div class="fr"><input type="text" placeholder="请输入商品数量" value="1" name="number" class="js-number" /></div>
				<div class="clear"></div>
			</li>
			<li>
				<div class="fl buessdo-pay-tit">备注</div>
				<div class="fr"><input type="text" placeholder="请输入备注" class="js-bak" /></div>
				<div class="clear"></div>
			</li>
		</ul>
	</section>

	<!-- 完成按钮 -->
	<div class="btn js-save_order js-btn-save" data-loading-text="做单提交中">完成做单</div>
</article>
</body>
<script>
	$(function() {
		// 设置子导航的height
		$(".nav-son-bj").height($(".nav-son-con div").length * 35 + 5)
		var js_bak = document.querySelector('.js-bak'); //input框 ID
	    var js_number = document.querySelector('.js-number'); //input框 ID
	    var js_platform_point = document.querySelector('.js_platform_point'); //input框 ID
	    var js_cash = document.querySelector('.js_cash'); //input框 ID
	    var js_product_name = document.querySelector('.js_product_name'); //input框 ID

	    showup(js_bak)
	    showup(js_number)
	    showup(js_platform_point)
	    showup(js_cash)
	    showup(js_product_name)

	    function showup(obj) {
	        obj.onfocus = function(){
	            //输入框获得焦点的时候，追加body高度，给一个比页面高的值。
	            document.querySelector('body').style.height = '9999px';
	            //这里添加个延迟，键盘弹出需要时间
	            setTimeout(function(){
	                //要让input移到顶部，需要把body的scrollTop设置成input距离页面顶部的距离。
	                document.body.scrollTop = document.documentElement.scrollTop = obj.getBoundingClientRect().top + pageYOffset -100;
	            },50);
	        };

	        obj.onblur = function(){
	            document.querySelector('body').style.height="auto";
	        };
	    }

	});
</script>
<?php echo $share_data ?>

<script>
//扫一扫回调
function scan_qrcode_callback(data) {
	if (data == '' || data == undefined) {
		motify.log('未找到用户');
	}
	
	var data = data.split('-');
	var card = data[0]; // 1条形码 2二维码
	var scene = data[1];
	var uid_tmp = data[2];

	if (card != 1 && card != 2) {
		motify.log('扫一扫只能扫描用户的会员卡的条形码或二维码');
		return false;
	}

	if (scan_qrcode_scenario != scene) {
		motify.log('扫码场景有误，请扫描本站其它用户的会员卡');
		return false;
	}
	
	if (uid_tmp == undefined || uid_tmp == '') {
		motify.log('用户不存在');
	}
	
	$.post("user.php?store_id=" + store_id + "&action=scan", {'uid': uid_tmp, 'card': card, 'scene': scene}, function(result) {
		if (result.err_code == 0) {
			$(".js-nowuser img").attr("src", result.err_msg.avatar);
			$(".js-nowuser span").html("当前用户为：" + result.err_msg.nickname);
			$(".js-userphone").val(result.err_msg.nickname);
			uid = result.err_msg.uid;
			$(".js-nowuser").show();
		} else {
			motify.log(result.err_msg);
		}
	});
}


</script>


</html>
<?php Analytics($store['store_id'], 'my_offline', '店铺做单', $store['store_id']); ?>