<!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>我的<?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?></title>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<meta name="format-detection" content="telephone=no">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">
		<meta name="applicable-device" content="mobile">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css">
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script>var page_url = '<?php echo $page_url;?>';var page_type = '<?php echo $action;?>';</script>
		<script src="<?php echo TPL_URL;?>js/index_mypoint.js"></script>
		<script>var platform_credit_name = "<?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?>";</script>
		<style type="text/css">
			.promote .secttion1 li {
				width: 50%;
			}
		</style>
	</head>
	<body>
	<script type="text/javascript">
		$(function(){
			myFun.tab(".promote");
		})
	</script>
		<div class="promote">
			<div class="hd">
				<ul class="flex">
					
					<li class="on">
						<a  href="./my_point.php?action=tuiguang">分享积分</a>
					</li>
				</ul>
			</div>
			<div class="bd">
				<?php if($_GET['action'] != 'tuiguang') {?>
				<div class="row">
					<div class="secttion0">
						<ul class="flex">
							<li>
								<span><?php echo $user_info['point_balance'];?></span>
								<p style="margin-top: 5px">可用<?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?></p>
							</li>
							<li>
								<span><?php echo $user_info['point_unbalance']?></span>
								<p><?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?>待释放 <?php if (!empty($check_give_point)) { ?>【<a href="my_point.php?action=give" style="color: #07d;font-size: 16px;">赠送</a>】<?php } ?></p>
							</li>
							<li>
								<span><?php echo $user_info['point_used']?$user_info['point_used']:'0';?></span>
								<p style="margin-top: 5px">已消耗<?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?></p>
							</li>
						</ul>
					</div>
					<div class="secttion1">
						<ul class="flex">
							<li><a href="javascript:;">累计消费<?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?> <em><?php echo  $user_info['point_used '] ? $user_info['point_used '] : '0.00'; ?></em></a></li>
							<li><a href="javascript:;">累计可用<?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?> <em><?php echo  ($user_info['point_balance '] + $user_info['point_used ']) > 0 ? number_format($user_info['point_balance '] + $user_info['point_used '], 2, '.', '') : '0.00'; ?></em></a> </li>
						</ul>
					</div>
					<div class="secttion1">
						<ul class="flex">
							<li><a href="javascript:;">今日释放<?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?>点数 <em><?php echo  $point_log['send_point '] ? $point_log['send_point '] : '0.00'; ?></em></a></li>
							<li><a href="javascript:;">今日新增可用<?php echo $setting['platform_credit_name'] ? $setting['platform_credit_name'] : '平台币';?> <em><?php echo  $point_log['point '] ? $point_log['point '] : '0.00'; ?></em></a> </li>
						</ul>
					</div>

					<div class="secttion2">
						<ul>

						</ul>
					</div>
				</div>
				<?php }?>
				
				<?php if($_GET['action'] == 'tuiguang') {?>
				<div class="row">
					<div class="secttion0">
						<ul class="flex">
							
							<li>
								<span><?php echo $user_info['point_gift'];?></span>
								<p>分享积分总额</p>
							</li>
							<li>
								<span><?php echo $user_info['spend_point_gift'];?></span>
								<p>已消耗分享积分</p>
							</li>
						</ul>
					</div>

					<div class="secttion2 displayTable">
						<ul>

						</ul>
					</div>
				</div>
				<?php }?>
			</div>
		</div>
	</body>
</html>