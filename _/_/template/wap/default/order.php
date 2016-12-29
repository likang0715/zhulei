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
		<!--title><?php echo $pageTitle;?> - <?php echo $now_store['name'];?></title-->
		<title><?php echo $pageTitle;?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/order_list.css?time='<?php echo time()?>'"/>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var page_url = '<?php echo $page_url;?>&ajax=1'; var comment_url = '<?php echo $comment_url;?>&ajax=1';;var orderid_prefix ='<?php echo option('config.orderid_prefix');?>';</script>
		<script src="<?php echo TPL_URL;?>js/order_fenye.js"></script>

		<script>
			$(function () {
				$("#pages a").click(function () {
					var page = $(this).attr("data-page-num");
					location.href = "<?php echo $page_url ?>&page=" + page;
				});
			});
		</script>
		
		<style>
			.js-footer {overflow: hidden;height: 49px;border-top: 1px solid #ddd;position: fixed;z-index: 900;width: 100%;bottom: 0;left: 0;}.content{margin-bottom:50px;}.opt-btn .btn{width:auto;padding:4px 8px;}
			html {font-size: 312.5%;-webkit-tap-highlight-color: transparent;height: 100%;min-width: 320px;overflow-x: hidden;}			
			.navbar{background:#eee}
			.navbar {border-bottom: 1px solid #06bf04;}
			 a {color: #FF658E;text-decoration: none;outline: 0;}
			.home{background:url('<?php echo TPL_URL;?>css/img/ico_home@2x.png') no-repeat scroll center center;background-size:25px 25px; text-indent:-10000px}
			.navbar {background:#eee;;height: 1.01rem;color: #999;border-bottom: 1px solid #06bf04;/* background: #06bf04; */display: -webkit-box;display: -ms-flexbox;position: relative;}
			.navbar .nav-wrap-left {height: 1.01rem;line-height: 1.01rem;}
			 a.react, label.react {display: block;color: inherit;height: 100%;}
			.nav-wrap-left a.back {height: 1rem;width: --.45rem;line-height: 0.85rem;padding: 0 0 0 .3rem}
			.text-icon {font-family: base_icon;display: inline-block;vertical-align: middle;font-style: normal;}
			.text-icon.icon-back {width: .45rem;height: .45rem;vertical-align: middle;position: relative;}
			.text-icon.icon-back:before {content: '';display: block;position: absolute;left: .07rem;top: 0;width: .4rem;height: .4rem;border-bottom: .04rem solid #999;border-left: .04rem solid #999;-webkit-transform: scaleY(0.7) rotateZ(45deg);-moz-transform: scaleY(0.7) rotateZ(45deg);-ms-transform: scaleY(0.7) rotateZ(45deg);}
			.text-icon.icon-back:afters {content: '';display: block;position: absolute;top: .2rem;left: .03rem;border-top: .04rem solid #fff;height: 0;width: .45rem;}
			.navbar h1.nav-header {-webkit-box-flex: 1;-ms-flex: 1;font-size: .36rem;font-weight: lighter;text-align: left;line-height: 1rem;margin: 0;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;}
			.navbar .nav-wrap-right {height: 100%;}
			.nav-wrap-right a { display: inline-block; height: 100%;line-height: 1rem;text-align: center; width: .94rem;}
			.nav-wrap-right a:last-child {margin-right: .04rem;}		
			.tabber button, .tabber a{width:20%}
			.block.block-order .bottom{line-height:30px;height:auto;padding-left:10px;}
			.block.block-order .bottom{padding:8px 6px 0px 6px}
			.return_btn {margin-top:16px; margin-left:5px; border:1px solid #f60; padding:0px 2px;border-radius:3px; color:#fff; background:#f60}
			.detail .return_btn {color:#FFF;}
		</style>
		
	</head>
	<body>
		<!--
		<header  class="navbar" style="z-index:1111">
			<div class="nav-wrap-left">
				<a class="react back" href="ucenter.php?id=<?php echo $store_id;?>"><i class="text-icon icon-back"></i></a>
			</div>
			<h1 class="nav-header">订单中心</h1>
			<div class="nav-wrap-right">
				<a class="home react" href="./index.php">主页</a>
			</div>
		</header>
		-->
		
	
		<div class="container">
		<div class="tabber tabber-n2 tabber-double-11 clearfix" style="margin-bottom:5px;position:fixed;top:0px;height:40px;z-index:900"> 
			<a <?php if($_GET['action'] == 'all' || $_GET['action'] == '') {?>class="active"<?php }?> href="./order.php?id=<?php echo $store_id;?>">全部</a> 
			<a  <?php if($_GET['action'] == 'unpay') {?> class="active" <?php }?> href="./order.php?id=<?php echo $store_id;?>&action=unpay">待付款</a>
			<a  <?php if($_GET['action'] == 'unsend') {?> class="active" <?php }?> href="./order.php?id=<?php echo $store_id;?>&action=unsend">待发货</a> 
			<a  <?php if($_GET['action'] == 'send') {?> class="active" <?php }?> href="./order.php?id=<?php echo $store_id;?>&action=send">待收货</a>
			<a  <?php if($_GET['action'] == 'complete') {?> class="active" <?php }?> href="./order.php?id=<?php echo $store_id;?>&action=complete">已完成</a>		
		</div>
	
		
			<div class="content">
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
			<?php echo $shareData;?>
		</div>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>