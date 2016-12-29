<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title><?php echo $user['nickname']; ?> - 用户<?php echo $point_alias?>赠送</title>
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
		<script type="text/javascript">var search_user_url = "my_point.php?action=give", scan_qrcode_scenario = "<?php echo $scan_qrcode_scenario; ?>";</script>
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
				font-size: 16px;
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
				clear: both;
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
			.title {
				font-size: 16px;
				padding: 10px;
				margin-bottom: 10px;
				background: orange;
				border-radius: 10px;
				color:white;
				text-align: center;
			}
			.search {
				border: none;
				width: 100%;
				margin: 10px auto;
				clear: both;
			}
			.search input {
				width: 45%;
				height: 30px;
				border-radius: 10px;
				background: #FF7216;
				color: white;
				margin: 0;
				padding: 0;
				float: left;
				border: none;
			}
			.clear {
				clear: both;
			}
			.btn-search {
				background: #07d!important;
			}
		</style>
	</head>
	<body style="padding-bottom:70px;">
		<div class="wx_wrap">
			
			<div class="my_head">
				<div class="userAvatr">
					<div class="avatarImg">
						<img src="<?php echo $avatar; ?>" />
					</div>
					<div class="userDesc"> <?php echo $user['nickname']; ?></div>
				</div>
				<div class="userMoreInfo">
					<ul>
						<li>待发放<?php echo $point_alias; ?><em><a href="javascript:void(0);"><?php echo $user['point_unbalance']; ?></a></em></li>
						<li>已赠送<?php echo $point_alias; ?><em><a href="javascript:void(0);"><?php echo $user['point_given']; ?></a></em></li>
						<li>已获赠<?php echo $point_alias; ?><em><a href="javascript:void(0);"><?php echo $user['point_received']; ?></a></em></li>
					</ul>
				</div>
			</div>
			<div id="point">
				<div class="title">
					<h3>用户<?php echo $point_alias; ?>赠送</h3>
				</div>
				<div style="border: 1px solid #eee; border-radius: 4px;">
					<div class="point point-store">
						<label class="label-title">受赠者</label>
						<input type="text" name="phone" class="phone" placeholder="输入手机号查询" />
					</div>
					<div class="search">
						<div style="width: 100%">
							<input type="button" class="btn-search" name="btn-search" value="找一找" />
							<span style="display: inline-block;width: 10%;float: left">&nbsp;</span>
							<input type="button" class="btn-scan" name="btn-scan" value="扫一扫" />
						</div>
						<div class="clear"></div>
					</div>
					<div class="point point-store">
						<label class="label-title">昵称</label>
						<input type="text" name="nickname" class="nickname" placeholder="获赠用户的昵称" readonly="true" />
					</div>
				</div>

				<div class="point point-exchange">
					<label class="label-title">最多可赠</label>
					<input type="text" name="max_give_point" value="<?php echo $user['point_unbalance']; ?>" readonly="true" />
				</div>
				<div class="point point-exchange">
					<label class="label-title">我要赠送</label>
					<input type="text" name="give_point" class="give_point" placeholder="输入赠送数量" />
				</div>

				<div class="point point-exchange">
					<label class="label-title">服务费(%)</label>
					<input type="text" name="service_fee" class="service_fee" value="<?php echo $give_point_service_fee; ?>" placeholder="平台收取的服务费" readonly="true" />
				</div>

				<div class="button">
					<input type="button" class="btn-submit" name="btn-submit" value="确 定" />
					<input type="button" class="btn-cancel" onclick="javascript:window.history.go(-1);" name="btn-cancel" value="返 回" />
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
			var get_uid = 0; //获赠用户id
			var card = ''; //扫码类型
			var scene = ''; //扫码场景
			var get_user = ''; //获取获赠用户方式 手机号 扫码
			$(function() {

				$("input[name='point']").blur(function(e){
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
					exchange_point = parseInt(parseFloat(exchange_point) * 100) / 100;
					$("input[name='point']").val(exchange_point.toFixed(2));
				})

				//查找获赠用户
				$('.btn-search').click(function(e) {
					//清除前一次结果
					get_uid = 0;
					$('.nickname').val('');
					$('.give_point').val('');
					$('.service_fee').val('');
					get_user = 'phone';
					var phone = $.trim($('.phone').val());
					if (phone == '') {
						motify.log('手机号码不能为空');
						return false;
					}
					if(!/^[0-9]{11}$/.test(phone)){
						motify.log("请填写正确手机号码");
						return false;
					}
					//搜索用户
					$.post(search_user_url, {'phone': phone, 'type': 'search_user'}, function(data) {
						if (data.err_code == 0) {
							var user = data.err_msg;
							if (user.nickname == '') {
								user.nickname = phone;
							}
							$('.nickname').val(user.nickname);
							get_uid = user.uid;
						} else {
							motify.log(data.err_msg);
						}
					});
				});

				//扫一扫
				$('.btn-scan').click(function(e) {
					get_uid = 0;
					scan_qrcode_func();
				})

				$('.btn-submit').click(function(e) {
					if (get_uid == 0) {
						motify.log('请先选择一个获赠的用户');
						return false;
					}
					var give_point = $("input[name='give_point']").val();
					var max_give_point = parseFloat($("input[name='max_give_point']").val());
					if (isNaN(give_point) || give_point == '') {
						motify.log('无效的赠送数量');
						return false;
					}
					if (parseFloat(give_point) > max_give_point) {
						motify.log('可赠送的<?php echo $point_alias; ?>不足');
						return false;
					}

					$('.btn-submit').attr('disabled', true);
					$.post('my_point.php?action=give', {'give_point': give_point, 'give_uid': get_uid, 'type': 'give_point', 'get_user': get_user, 'card': card, 'scene': scene}, function(data){
						if (data.err_code == 0) {
							motify.log(data.err_msg);
							window.location.reload();
						} else {
							motify.log(data.err_msg);
						}
						$('.btn-submit').attr('disabled', false);
					})
				})
			})
			//扫码回调处理
			function scan_qrcode_callback(data) {
				if (data == '' || data == undefined) {
					motify.log('未找到获赠的用户');
				}
				get_user = 'scan';
				var data = data.split('-');
				card = data[0]; // 1条形码 2二维码
				scene = data[1];
				var uid = data[2];

				if (card != 1 && card != 2) {
					motify.log('扫一扫只能扫描用户的会员卡的条形码或二维码');
					return false;
				}
				if (scan_qrcode_scenario != scene) {
					motify.log('扫码场景有误，请扫描本站其它用户的会员卡');
					return false;
				}
				if (uid == undefined || uid == '') {
					motify.log('用户不存在');
					return false;
				}

				$.post(search_user_url, {'uid': uid, 'type': 'search_user', 'card': card, 'scene': scene}, function(data) {
					if (data.err_code == 0) {
						var user = data.err_msg;
						if (user.nickname == '') {
							user.nickname = phone;
						}
						$('.phone').val(user.phone);
						$('.nickname').val(user.nickname);
						get_uid = user.uid;
					} else {
						motify.log(data.err_msg);
					}
				});
			}
		</script>
	</body>
</html>