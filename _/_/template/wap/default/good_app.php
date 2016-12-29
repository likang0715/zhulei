<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" 	content="<?php echo $config['seo_description'];?>" />
	<meta name="HandheldFriendly" content="true" />
	<meta name="MobileOptimized" content="320" />
	<meta name="format-detection" content="telephone=no" />
	<meta http-equiv="cleartype" content="on" />
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<title><?php echo $nowProduct['name'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css?time=<?php echo time()?>" />
	<?php if($is_mobile){ ?>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css" />
		<script>var is_mobile = true;</script>
	<?php }else{ ?>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css" />
		<script>var is_mobile = false;</script>
	<?php } ?>
	<script>
		var is_logistics = <?php echo $nowProduct['wholesale_product_id'] ? ($store_original['open_logistics'] ? 'true' : 'false') : ($now_store['open_logistics'] ? 'true' : 'false') ?>;
		var is_selffetch = <?php echo $nowProduct['buyer_selffetch'] ? ($store_original['buyer_selffetch'] ? 'true' : 'false') : ($now_store['buyer_selffetch'] ? 'true' : 'false') ?>;
		var create_fans_supplier_store_url="<?php echo $config['site_url'] ?>/wap/create_fans_supplier_store.php";
		var store_online_trade = <?php echo $store_online_trade == 1 ? 'true' : 'false' ?>;
	</script>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/goods.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/drp_notice.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/coupon.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL?>css/comment.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/font/icon.css" />
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/fancybox.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css">
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
	<style type="text/css">
	#fancybox-left span {left : auto; left : 20px;}
	#fancybox-right span {left : auto; right : 20px;}

    .layer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.5);
        z-index: 9;
    }

    .layer_content {
        background: #fff;
        position: fixed;
        width: 15rem;
        left: .5rem;
        top: 50%;
        text-align: center;
        z-index: 10;
        height: 19rem;
        margin-top: -8.5rem;
    }
    .layer_content .layer_title {
        font-size: .55rem;
        color: #fff;
        line-height: .9rem;
        padding: .3rem .5rem;
        background: #45a5cf;
        text-align: left;
        text-indent: 1.2rem;
    }
    .layer_content p {
        font-size: .55rem;
        color: #333333;
        line-height: 1.4rem;
    }
    .layer_content img {
        width: 8rem;
        margin: 1rem 0;
    }
    .layer_content p span {
        font-size: .45rem;
        color: #999;
        line-height: 0.9rem;
    }

    .layer_content button {
        background: #ff9c00;
        width: 5.5rem;
        height: 1.5rem;
        color: #fff;
        line-height: 1.5rem;
        border-radius: 1.5rem;
        margin: .6rem 0;
    }

    .layer_content i {
        background: url(/template/wap/default/ucenter/images/weidian_25.png) no-repeat;
        background-size: 1rem;
        height: 1.2rem;
        width: 1.24rem;
        display: inline-block;
        vertical-align: middle;
        position: absolute;
        right: -.5rem;
        top: -.5rem;
    }
	.profit, .nickname {
		color: #26CB40;
	}

    /* ueditor 表格样式 */
    .selectTdClass{background-color:#edf5fa !important}table.noBorderTable td,table.noBorderTable th,table.noBorderTable caption{border:1px dashed #ddd !important}table{margin-bottom:10px;border-collapse:collapse;display:table;}td,th{padding: 5px 10px;border: 1px solid #DDD;}caption{border:1px dashed #DDD;border-bottom:0;padding:3px;text-align:center;}th{border-top:1px solid #BBB;background-color:#F7F7F7;}table tr.firstRow th{border-top-width:2px;}.ue-table-interlace-color-single{ background-color: #fcfcfc; } .ue-table-interlace-color-double{ background-color: #f7faff; }td p{margin:0;padding:0;}

    /* 店铺订单消息提示 */
    .orderLayer { position: fixed; left: 10px; margin-left: 0; top: 60px; line-height: 1.2rem; background: rgba(0,0,0,.4); padding: 5px; z-index: 7; width: 90%; color: #fff; font-size: .55rem; border-radius: 1.5rem; }
	.orderLayer .orderImg { display: inline-block; vertical-align: middle; overflow: hidden; }
	.orderLayer .orderImg img { vertical-align: top; width: 32px; height: 32px; border-radius: 50% }
	.orderLayer .orderInfo { display: inline-block; vertical-align: middle; margin-left: 5px; width:87% }
	.orderLayer .orderInfo i { color:#FF9E40; width: 60px; display: inline-block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; vertical-align: middle; margin-top: -.1rem; }
	.orderLayer .orderInfo span { display:inline-block; margin-left:16px; float: right; }

	</style>
	<?php if (empty($drp_button)) { ?>
	<style type="text/css">
		#drp-notice ul .msg-li {
			margin-left: 5px;
			width: 75%;
		}
	</style>
	<?php }?>
	<script type="text/javascript">
		var is_present_product = <?php echo $is_present_product;?>,
			storeId=<?php echo $now_store['store_id'];?>,
			product_id=<?php echo $nowProduct['product_id'];?>,
			showBuy=!!<?php echo intval($_GET['buy'])?>,
			hasActivity=!!<?php echo intval($nowActivity);?>,
			activityId=<?php echo intval($nowActivity['pigcms_id']);?>,
			activityType=<?php echo intval($nowActivity['type']);?>,
			activityDiscount=<?php echo floatval($nowActivity['discount']);?>,
			activityPrice=<?php echo floatval($nowActivity['price'])?>,
			after_subscribe_discount=<?php echo $nowProduct['after_subscribe_discount'];?>;
			after_subscribe_price=<?php echo $nowProduct['after_subscribe_price'];?>;
			follow = <?php echo !empty($follow)? 1:0;?>;
	</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.waterfall.js"></script>
	<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>

	<script src="<?php echo TPL_URL;?>js/base.js?time=<?php echo time()?>"></script>
	
	<?php if($is_present_product == 1) {?>
		<script src="<?php echo TPL_URL;?>js/pointgood.js"></script>
		<script src="<?php echo TPL_URL;?>js/pointsku.js"></script>
	<?php }else {?>
		<script src="<?php echo TPL_URL;?>js/good.js"></script>
		<script src="<?php echo TPL_URL;?>js/sku.js"></script>
	<?php }?>

	<script src="<?php echo TPL_URL;?>js/drp_notice.js"></script>
	<!-- 活动模块 -->
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/weidian_files/style.css">
	<script src="<?php echo TPL_URL;?>/weidian_files/iscroll.js"></script>
	<script type="text/javascript">
		$(function () {
			$(".scroller").each(function (i) {
				var li = $(this).find("li");
				var liW = li.width() + 18;
				var liLen = li.length;
				$(this).width(liW * liLen);
				
				var class_name = $(this).parent().attr("class");
				new IScroll("." + class_name, { scrollX: true, scrollY: false, mouseWheel: false, click: true });
			});
		});
	</script>
	<!-- 活动模块-->

<style>
	body,.container{background: #eaeaea;}
</style>
</head>

<body class="body-fixed-bottom">


						<div class="row proDetail js-content-detail">
							<?php echo htmlspecialchars_decode($nowProduct['info']);?>
						</div>
						
</html>
