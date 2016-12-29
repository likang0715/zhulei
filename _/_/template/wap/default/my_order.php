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
		<title><?php echo $pageTitle;?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/order_list.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/my.css"/>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
				<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var page_url = '<?php echo $page_url;?>&ajax=1'; var comment_url = '<?php echo $comment_url;?>&ajax=1';;var orderid_prefix ='<?php echo option('config.orderid_prefix');?>';</script>
		<script src="<?php echo TPL_URL;?>js/order.js"></script>
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
			
			.content{margin-bottom:-21px;margin-top:40px}
		</style>
	</head>
	<body style="padding-bottom: 70px;">
		<div class="container">
		<div class="tabber tabber-n2 tabber-double-11 clearfix" style="margin-bottom:5px;position:fixed;top:0px;height:40px;z-index:900"> 
			<a <?php if($_GET['action'] == 'all' || $_GET['action'] == '') {?>class="active"<?php }?> href="./my_order.php">全部</a> 
			<a  <?php if($_GET['action'] == 'unpay') {?> class="active" <?php }?> href="./my_order.php?action=unpay">待付款</a>
			<a  <?php if($_GET['action'] == 'unsend') {?> class="active" <?php }?> href="./my_order.php?action=unsend">待发货</a> 
			<a  <?php if($_GET['action'] == 'send') {?> class="active" <?php }?> href="./my_order.php?action=send">待收货</a>
			<a  <?php if($_GET['action'] == 'complete') {?> class="active" <?php }?> href="./my_order.php?action=complete">已完成</a>		
		</div>
			<!--  
			<div class="content">
				<div id="order-list-container">
					<div class="b-list">
						<?php 
							foreach($order_list as $order){
						?>
							<li class="block block-order animated">
								<div class="header">
									<span class="font-size-12">订单号：<?php echo $order['order_no_txt'];?></span>
									<?php if($order['status']<2){ ?>
										<a class="js-cancel-order pull-right font-size-12 c-blue" href="javascript:;" data-id="<?php echo $order['order_id'];?>">取消</a>
									<?php } ?>
								</div>
								<hr class="margin-0 left-10"/>
								<?php 
								foreach ($order['product_list'] as $product) {
								?>
									<div class="block block-list block-border-top-none block-border-bottom-none">
										<div class="block-item name-card name-card-3col clearfix">
											<a href="<?php echo $product['url'];?>" class="thumb">
												<img src="<?php echo $product['image'];?>"/>
											</a>
											<div class="detail">
												<a href="<?php echo $product['url'];?>"><h3 style="margin-bottom:6px;"><?php echo $product['name'];?></h3></a>
												<?php
													if($product['sku_data_arr']){
														foreach($product['sku_data_arr'] as $v){
												?>
															<p class="c-gray ellipsis"><?php echo $v['name'];?>：<?php echo $v['value'];?></p>
												<?php 
														}
													}
												?>
											</div>
											<div class="right-col">
												<div class="price">¥&nbsp;<span><?php echo $product['pro_price'];?></span><?php echo $product['is_present'] == 1 ? ' <span style="color:#f60;">赠品</span>' : '' ?></div>
												<div class="num">×<span class="num-txt"><?php echo $product['pro_num'];?></span></div>
											</div>
										</div>
									</div>
								<?php 
								}
								if ($order['shipping_method'] == 'selffetch') {
								?>
									<hr class="margin-0 left-10"/>
									<div class="bottom">
										<?php 
										if ($order['address']['physical_id']) {
										?>
											<?php echo $physical_list[$order['address']['physical_id']]['buyer_selffetch_name'] ?> (<?php echo $physical_list[$order['address']['physical_id']]['name'] ?>)
											<div class="opt-btn">
												<a class="btn btn-in-order-list" href="./physical_detail.php?id=<?php echo $order['address']['physical_id'] ?>">查看</a>
											</div>
										<?php
										} else if ($order['address']['store_id']) {
										?>
											<?php echo $store_contact_list[$order['address']['store_id']]['buyer_selffetch_name'] ?> (<?php echo $store_contact_list[$order['address']['store_id']]['name'] ?>)
											<div class="opt-btn">
												<a class="btn btn-in-order-list" href="./physical_detail.php?store_id=<?php echo $order['address']['store_id'] ?>">查看</a>
											</div>
										<?php
										}
										?>
										
									</div>
								<?php
								}
								?>
								<hr class="margin-0 left-10"/>
								<div class="bottom">
									<?php if($order['total']){ ?>
										总价：<span class="c-orange">￥<?php echo $order['total'];?></span>
									<?php }else{ ?>
										商品价格：<span class="c-orange">￥<?php echo $order['sub_total'];?></span>
									<?php } ?>
									<div class="opt-btn">
										<?php if($order['status']<2){ ?>
											<a class="btn btn-orange btn-in-order-list" href="<?php echo $order['url'];?>">付款</a>
										<?php }else{ ?>
											<?php if ($order['status'] > 2 && $order['has_physical_send'] == 1) { ?>
											<a class="btn btn-green" style="width: 5em;" href="./my_package.php?order_id=<?php echo $order['order_id'] ?>">配送详情</a>
											<?php } ?>
											<a class="btn btn-in-order-list" href="<?php echo $order['url'];?>">详情</a>
										<?php } ?>
									</div>
								</div>
							</li>
						<?php
						}
						?>
						<div class="bottom" id="pages">
							<?php echo $pages ?>
						</div>
					</div>
					<div class="empty-list list-finished" style="padding-top:60px;display:none;">
						<div>
							<h4>居然还没有订单</h4>
							<p class="font-size-12">好东西，手慢无</p>
						</div>
						<div><a href="./index.php" class="tag tag-big tag-orange" style="padding:8px 30px;">去逛逛</a></div>
					</div>
				</div>
			</div>
			-->
			
			<div class="content" >
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
			
			<?php $noFooterLinks=true;$noFooterCopy=true;include display('footer');?>
		</div>
		<div class="wx_nav">
			<a href="./index.php" class="nav_index">首页</a>
			<a href="./category.php" class="nav_search">分类</a>
			<a href="./weidian.php" class="nav_shopcart">店铺</a>
			<a href="./my.php" class="nav_me on">个人中心</a>
		</div>
		<?php echo $shareData;?>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>