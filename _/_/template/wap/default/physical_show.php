<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
<head>
	<meta charset="utf-8"/>
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />
	<title><?php echo $store_physical['name'];?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no" />
	<meta name="format-detection" content="email=no" />
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css?time=<?php echo time()?>" />
	<?php if($is_mobile){ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css" />
	<script>var is_mobile = true;</script>
	<?php }else{ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css" />
	<script>var is_mobile = false;</script>
	<?php } ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/shop_details.css">
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js?time=<?php echo time()?>"></script>
</head>
<body class="shop_details FastClick">
	<div class="shop_info_box">
		<div class="shop_thumb">
			<div class="js-image-swiper custom-image-swiper custom-goods-swiper">
				<div class="swiper-container" style="width:100%;">
					<div class="swiper-wrapper" style="width:100%;">
						<?php $images=explode(',',$store_physical['pics']); foreach($images as $value){?>
						<div class="swiper-slide" style="width:100%;">
							<a class="js-no-follow" href="javascript:;" style="width:100%;"> <img src="../upload/<?php echo $value;?>" /></a>
						</div>
						<?php }?>
					</div>
				</div>
				<div class="swiper-pagination">
					<?php 
					$images=explode(',',$store_physical['pics']);
					if (count($images) > 1) {
						for ($i = 0; $i < count($images); $i++) {
							?>
							<span class="swiper-pagination-switch <?php if ($i == 0) { ?>swiper-active-switch<?php } ?>"></span>
							<?php 
						}
					}
					?>
				</div>
			</div>
		</div>
		<div class="shop_title c_main">
			<h3><?php echo $store_physical['name'];?></h3>
			<div class="shop_address"><i></i><span><?php echo $store_physical['address'];?></span><a href="./physical_detail.php?id=<?php echo $store_physical['pigcms_id'];?>">&nbsp;&nbsp;查看位置</a></div>
		</div>
		<div class="shop_time c_main">
			<span>营业时间：<?php echo $store_physical['business_hours'];?></span>
		</div>
		<div class="shop_desc c_main">
			<span class="desc_text"><?php echo $store_physical['description'];?></span>
		</div>
	</div>
	<div class="shop_tables">
		<h3 class="shop-table-t c_main">包厢列表</h3>
		<div class="shop-table-m c_main">
			<?php foreach($list as $value){ ?>
			<a href="<?php echo $value['url'];?>" class="cf tables-tiem">
				<div class="tables-thumb">
					<?php if($value['image']){ ?>
					<img src="<?php echo $value['image'];?>">
					<?php }else{ ?>
					<img src="../upload/images/first_demo_tables.jpg">
					<?php } ?>
				</div>
				<div class="tables-text">
					<p class="tables-contain"><i class="tables-contain-before"></i><span class="tables-contain-main">6人间</span><i class="tables-contain-after"></i></p>
					<h4 class="tables-title"><?php echo $value['name'];?></h4>
					<p class="tables-desc"><?php echo $value['price'];?>元/小时</p>
				</div>
				<div class="tables-btn">
					<span class="tables-order-btn">我要预订</span>
				</div>
			</a>
			<?php } ?>
		</div>
	</div>
	<div class="shop_bottom">
		<div class="shop_bottom_nav">
			<ul>
				<li class="nav_more inner_border">
					<span class="more_toggle">更多</span>
					<div class="list_more_show" style="display:none">
						<ul>
							<li><a href="<?php echo $now_store['url'];?>">店铺首页</a></li>
							<li><a href="<?php echo $now_store['ucenter'];?>">个人中心</a></li>
							<li><a href="physical.php?id=<?php echo $now_store['store_id'];?>">全部分店</a></li>
							<li><a href="chahui.php">更多茶馆</a></li>
						</ul>
					</div>
				</li>
				<li class="nav_tel inner_border">
					<a href="tel:<?php echo $store_physical['phone1'];?><?php echo $store_physical['phone2'];?>"><span>联系茶馆</span></a>
				</li>
				<li class="nav_submit inner_border" id="shop_sign"><a style="color:#fff" href="diancha.php?id=18&fid=<?php echo $store_physical['pigcms_id'];?>">预约订座</a></li>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
	$(function() {
		$('.more_toggle').click(function() {
			$('.list_more_show').toggle();
		});
	});
	</script>
	<script src="<?php echo TPL_URL;?>/diancha/js/fastclick.js"></script>
	<script>
	window.addEventListener('load', function () {
		FastClick.attach(document.body);
	}, false);
	</script>
</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>