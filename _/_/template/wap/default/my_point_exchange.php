<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php echo $store['name']; ?> - <?php echo $point_alias?>转移</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css"/>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<script src="<?php echo TPL_URL; ?>js/jquery.ba-hashchange.js"></script>
		<script type="text/javascript">
			var service_fee_rate = parseFloat("<?php echo $point2money_rate?>");
		</script>
		<style type="text/css">
			.userMoreInfo{text-align:right}
			.my-store > a:before {
				content: normal;
				display: block;
			}
			#point {
				margin: 0 auto;
				margin-top: 10px;
				width: 95%;
			}
			.point {
				background: white;
				color:black;
				height: 50px;
				line-height: 50px;
				font-size: 14px;
				font-family: Microsoft YaHei, Arial;
				padding: 0;
			}
			.label-title {
				display: inline-block;
				margin-left: 10px;
				width: 40%;
			}
			.point-store {
				border-bottom: 1px solid #eee;
			}
			.point input {
				margin-left: 10px;
				height: 30px;
				line-height: 30px;
				font-size: 16px;
				font-family: Microsoft YaHei, Arial;
				border: none;
				text-align: right;
				width: 50%;
			}
			.point-exchange {
				margin-top: 10px;
				border: 1px solid #eee;
				border-radius: 4px;
			}
			.button {
				clear: both;
				margin-top: 20px;
				padding: 0;
				font-family: Microsoft YaHei, Arial;
			}
			.button input {
				height: 50px;
				line-height: 30px;
				width: 100%;
				border: none;
				font-size: 18px;
				border-radius: 4px;
				color: white;
			}
			.btn-cancel {
				margin-top: 10px;
				background: #CACACA;
			}
			.btn-submit {
				display: inline-block;
				background: #FF7216;
			}
			.accountnav {
				width: 100%;
				background: #fff;
				border-bottom: solid 1px #e1e1e1;
			}
			.accountnavli-active {
				color: #ff7216;
				border-bottom: solid 2px #ff7216;
				height: 38px;
			}
			.accountnavli {
				width: 50%;
				height: 40px;
				line-height: 40px;
				color: #999;
				text-align: center;
				font-size: 16px;
			}
			.fl {
				display: block;
				float: left;
				font-family: "微软雅黑";
			}
			.clear {
				clear: both;
			}
			.accountdiv {
				background: #fff;
				padding: 10px;
				margin-top: 5px;
				border-top: solid 1px #e1e1e1;
				border-bottom: solid 1px #e1e1e1;
			}
			.accountdiva {
				padding: 10px;
				background: #fff;
				border-bottom: solid 1px #e1e1e1;
			}
			.accountdiva {
				height: 25px;
				line-height: 25px;
				color: #333;
			}
			.buesscash-fl {
				width: 100px;
			}
			input {
				border: none;
				outline: medium;
			}
			.btn {
				display: inline-block;
				background-color: #fff;
				border: 1px solid #e5e5e5;
				border-radius: 3px;
				padding: 4px;
				text-align: center;
				margin: 0;
				color: #999;
				font-size: 12px;
				cursor: pointer;
				line-height: 18px;
			}
			.btn {
				color: #fff;
				width: calc(100% - 20px);
				width: -webkit-calc(100% - 20px);
				background: #ff7216;
				height: 35px;
				line-height: 35px;
				text-align: center;
				margin-left: 5px;
				margin-top: 25px;
				-webkit-border-radius: 3px;
				border-radius: 3px;
				margin-bottom: 10px;
				letter-spacing: 1px;
				font-size: 16px;
				font-family: Microsoft YaHei, Arial;
			}
			.buesscash-span {
				margin-right: 30px;
			}
		</style>
	</head>
	<body style="padding-bottom:70px;">
		<div class="wx_wrap">

			<div class="my_head">
				<div class="userAvatr">
					<div class="avatarImg">
						<img src="<?php echo $store['logo']; ?>" />
					</div>
					<div class="userDesc"> <?php echo $store['name']; ?></div>
				</div>
				<div class="userMoreInfo">
					<ul>
						<li>商家积分<em><a href="my_point.php?action=store_point&store_id=<?php echo $store['store_id']; ?>"><?php echo $store['point_balance']; ?></a></em></li>
						<li>可用积分(用户)<em><a href="my_point.php?action=user_point&store_id=<?php echo $store['store_id']; ?>"><?php echo $user_info['point_balance']; ?></a></em></li>
						<li>已兑现商家积分<em><a href=""><?php echo $store['point2money']; ?></a></em></li>
					</ul>
				</div>
			</div>

			<div class="accountnav" style="margin-bottom: 10px;">
				<div class="fl accountnavli" data-hash="#transfer">商家积分转移</div>
				<div class="fl accountnavli" data-hash="#exchange">商家积分兑换</div>
				<div class="clear"></div>
			</div>
			<div>
				<div class="accountdiv" id="point" style="display: none;">
					<div style="border: 1px solid #eee; border-radius: 4px;">
						<div class="point point-store">
							<label class="label-title">商家积分</label>
							<input type="text" name="store_point" value="<?php echo $store['point_balance']; ?>" readonly="true" />
						</div>
						<div class="point point-user">
							<label class="label-title">用户积分</label>
							<input type="text" name="user_point" value="<?php echo $user_info['point_balance']; ?>" readonly="true" />
						</div>
					</div>

					<div class="point point-exchange">
						<label class="label-title">转移</label>
						<input type="text" name="point" placeholder="输入转移数量" />
					</div>

					<div class="button">
						<input type="button" class="btn-submit" name="btn-submit" value="确 定" />
						<input type="button" class="btn-cancel" name="btn-cancel" value="返 回" />
					</div>
				</div>
				<div class="accountdiv" id="point">
					<div class="accountdiva">
						<div class="fl buesscash-fl">已兑换数量</div>
						<div class="fl"><?php echo $store['point2money']; ?></div>
						<div class="clear"></div>
					</div>

					<div class="accountdiva">
						<div class="fl buesscash-fl">可兑换数量</div>
						<div class="fl point-balance"><?php echo $store['point_balance']; ?></div>
						<div class="clear"></div>
					</div>
					<div class="accountdiva">
						<div class="fl buesscash-fl">输入数量</div>
						<div class="fl"><input type="text" name="point2" placeholder="请输入兑换数量" /></div>
						<div class="clear"></div>
					</div>

					<div class="accountdiva">
						<div class="fl buesscash-fl">服务费</div>
						<div class="fl"><span class="buesscash-span service-fee-rate"><?php echo $point2money_rate; ?>%</span><span class="service-fee-money">0.00</span></div>
						<div class="clear"></div>
					</div>

					<div class="accountdiva to-money-div" style="display: none;">
						<div class="fl buesscash-fl">可兑换现金</div>
						<div class="fl to-money">0.00</div>
						<div class="clear"></div>
					</div>
					<div class="button">
						<input type="button" class="btn-submit" name="btn-exchange" value="我要兑换" />
						<input type="button" class="btn-cancel" name="btn-cancel" value="返 回" />
					</div>
				</div>
			</div>
		</div>
		<div class="wx_nav">
			<a href="./index.php" class="nav_index">首页</a>
			<a href="./category.php" class="nav_search">分类</a>
			<a href="./weidian.php" class="nav_shopcart">店铺</a>
			<a href="./my.php" class="nav_me on">个人中心</a>
		</div>
		<?php echo $shareData;?>
		<script type="text/javascript">
			var t = '';
			var click = false;
			$(function() {
				window.onpopstate = function(event) {
					var back_hash = window.location.hash;
					if (back_hash == $('.accountnav > .accountnavli-active').data('hash') && click == false && ref.indexOf('my.php') <= 0) {
						window.location.href = 'my.php';
					}
					click = false;
				};
				//绑定事件处理函数.
				history.pushState("", "", "");

				var index = 0;
				$('.accountnav > .accountnavli').click(function(e) {
					click = true;
					index = $(this).index('.accountnav > .accountnavli');
					$(this).addClass('accountnavli-active').siblings('.accountnavli').removeClass('accountnavli-active');
					$('.accountdiv').eq(index).show().siblings('.accountdiv').hide();
					if (index) {
						window.location.hash = '#exchange';
					} else {
						window.location.hash = '#transfer';
					}
				})

				if (window.location.hash != undefined) {
					var hash = window.location.hash;
					hash = hash.toLowerCase();
					if (hash == '#transfer') {
						index = 0;
						$('.accountnav > .accountnavli').eq(0).trigger('click');
					} else {
						index = 1;
						$('.accountnav > .accountnavli').eq(1).trigger('click');
					}
					click = false;
				}

				$("input[name='point']").blur(function(e){
					var store_point = parseFloat($("input[name='store_point']").val());
					var exchange_point = $(this).val();
					if (exchange_point == '') {
						return false;
					}
					if (store_point == 0) {
						motify.log('没有可转移的店铺<?php echo $point_alias; ?>');
						return false;
					}
					if (exchange_point == '' || isNaN(exchange_point) || parseFloat(exchange_point) <= 0) {
						motify.log('无效的转移数量');
						return false;
					}
					if (parseFloat(exchange_point) > store_point) {
						motify.log('可转移的店铺<?php echo $point_alias; ?>不足');
						return false;
					}
					exchange_point = parseInt(parseFloat(exchange_point) * 100) / 100;
					$("input[name='point']").val(exchange_point.toFixed(2));
				})

				$("input[name='point2']").blur(function(e){
					var point_balance = parseFloat($('.point-balance').text().trim());
					var point = $(this).val().trim();
					if (point == '') {
						return false;
					}
					var service_fee_rate_100 = (service_fee_rate / 100);
					if (!isNaN(point) && point != '' && parseFloat(point) <= point_balance) {
						point = parseFloat(point);
						service_fee = point * service_fee_rate_100;
						$('.service-fee-money').text(service_fee.toFixed(2));
						$(this).val(point.toFixed(2));
						$('.to-money').text((point - service_fee).toFixed(2));
						$('.to-money-div').slideDown(300);
					} else {
						motify.log('兑换数量输入无效');
						$(this).val('');
						$('.service-fee-money').text('0.00');
						$('.to-money-div').slideUp(300);
					}
				});

				$("input[name='btn-exchange']").click(function(e) {
					var point = $("input[name='point2']").val().trim();
					var point_balance = $('.point-balance').text().trim();
					point_balance = parseFloat(point_balance);
					if (point == '') {
						motify.log('兑换数量不能为空');
						return false;
					}
					if (isNaN(point)) {
						motify.log('兑换数量输入无效');
						return false;
					}
					point = parseFloat(point);
					if (point > point_balance) {
						motify.log('可兑换的数量不足');
						return false;
					}

					$.post("my_point.php?action=exchange&store_id=<?php echo $store['store_id']?>", {'point': point, 'type': 'exchange'}, function(data) {
						if (!data.err_code) {
							motify.log(data.err_msg);
							t = setTimeout('redirect()', 1000);
						} else {
							motify.log(data.err_msg);
						}
					});
				})

				$("input[name='btn-submit']").click(function(e) {
					var store_point = parseFloat($("input[name='store_point']").val());
					var exchange_point = $("input[name='point']").val();
					if (store_point == 0) {
						motify.log('没有可转移的店铺<?php echo $point_alias; ?>');
						return false;
					}
					if (exchange_point == '' || isNaN(exchange_point) || parseFloat(exchange_point) <= 0) {
						motify.log('无效的转移数量');
						return false;
					}
					if (parseFloat(exchange_point) > store_point) {
						motify.log('可转移的店铺<?php echo $point_alias; ?>不足');
						return false;
					}

					$(this).attr('disabled', true);
					$.post('my_point.php?action=exchange&store_id=<?php echo $store["store_id"]; ?>', {'point': exchange_point, 'type': 'transfer'}, function(data){
						if (data.err_code == 0) {
							motify.log(data.err_msg);
							t = setTimeout('redirect()', 1000);
						} else {
							motify.log(data.err_msg);
						}
						$('.btn-submit').attr('disabled', false);
					})
				})

				$(window).hashchange( function(){
					var back_hash = window.location.hash;
					if (back_hash != $('.accountnav > .accountnavli-active').data('hash')) {
						window.location.href = 'my_point.php#1';
					}
				})

				$('.btn-cancel').click(function(e) {
					window.location.href = 'my_point.php#1';
				})
			})

			function redirect() {
				window.location.reload();
			}
		</script>
	</body>
</html>