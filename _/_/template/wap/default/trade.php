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
		<title>购物记录</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/order_list.css"/>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var page_url = '<?php echo $page_url;?>&ajax=1';</script>
		<script src="<?php echo TPL_URL;?>js/trade_fenye.js"></script>
		<script>
		$(function () {
			$("#pages a").click(function () {
				var page = $(this).attr("data-page-num");
				location.href = "trade.php?id=<?php echo $store_id ?>&page=" + page;
			});
		});
		</script>
		<style>
			.opt-btn .btn{width:auto;padding:4px 8px;}
			.block.block-order .bottom{line-height:30px;height:auto;padding-left:10px;}
			.block.block-order .bottom{padding:8px 6px 0px 6px}
			.return_btn {margin-top:16px; margin-left:5px; border:1px solid #f60; padding:0px 2px;border-radius:3px; color:#fff; background:#f60}
			.detail .return_btn {color:#FFF;}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="tabber tabber-n2 tabber-double-11 clearfix">
					<a href="./cart.php?id=<?php echo $now_store['store_id']?>">购物车</a>
					<a class="active" href="./trade.php?id=<?php echo $now_store['store_id']?>">购物记录</a>
				</div>
				<p style="height:10px;">&nbsp;</p>
				<div id="order-list-container">
					<div class="b-list">
						<!--
						<div class="bottom" id="pages" style="display:none">
							<?php echo $pages ?>
						</div>
						-->
					</div>
					<div class="wx_loading2"><i class="wx_loading_icon"></i></div>
					<div class="empty-list list-finished" style="padding-top:60px;display:none;">
						<div>
							<h4>居然还没有订单</h4>
							<p class="font-size-12">好东西，手慢无</p>
						</div>
						<div><a href="<?php echo $now_store['url'];?>" class="tag tag-big tag-orange" style="padding:8px 30px;">去逛逛</a></div>
					</div>
				</div>
			</div>
			<?php include display('footer');?>
		</div>
		<?php echo $shareData;?>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>