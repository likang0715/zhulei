<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>出售中的商品 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="description" content="<?php echo $config['seo_description'];?>">
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
        <meta name="renderer" content="webkit">
        <meta name="referrer" content="always">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <!-- ▼ Base CSS -->
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Base CSS -->
        <!-- ▼ Goods CSS -->
		<link href="<?php echo TPL_URL;?>css/goods.css" type="text/css" rel="stylesheet"/>
        <!-- ▲ Goods CSS -->
        <!-- ▼ Base JS -->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
        <!-- ▲ Base JS -->
        <!-- ▼ Constant JS -->
		<script type="text/javascript">var checkout_url="<?php dourl('checkoutProduct');?>", load_url="<?php dourl('goods_load');?>",add_url="<?php dourl('delivery_modify');?>",delete_url="<?php dourl('delivery_delete');?>",copy_url="<?php dourl('delivery_copy');?>",edit_url="<?php dourl('delivery_amend');?>", soldout_url="<?php dourl('soldout'); ?>", allow_discount_url="<?php dourl('allow_discount'); ?>", page_content="selling_content", goods_group_url="<?php dourl('category'); ?>", edit_group_url="<?php dourl('edit_group'); ?>", save_qrcode_activity_url="<?php dourl('save_qrcode_activity'); ?>", get_qrcode_activity_url="<?php dourl('get_qrcode_activity'); ?>", del_qcode_activity_url="<?php dourl('del_qrcode_activity'); ?>", copy_product_url="<?php dourl('copy_product'); ?>", del_product_url="<?php dourl('del_product'); ?>", sort_url="<?php dourl('set_sort'); ?>";</script>
        <!-- ▲ Constant JS -->
        <!-- ▼ Goods JS -->
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/goods.js"></script>
        <!-- ▲ Goods JS -->
	</head>
	<body class="font14 usercenter">
		<?php include display('public:first_sidebar');?>
		<?php include display('sidebar');?>
		<div id="container" class="clearfix container right-sidebar">
			<div id="container-left">
				<!-- ▼ Third Header -->
				<div id="third-header">
				    <ul class="third-header-inner">
				        <?php if (checkIsShow('index', $uid)) { ?>
				        <li <?php if($select_sidebar == 'index') echo 'class="active"';?>>
				            <a href="<?php dourl('index');?>">出售中</a>
				        </li>
				        <?php } ?>
				        <?php if (checkIsShow('stockout', $uid)) { ?>
				        <li <?php if($select_sidebar == 'stockout') echo 'class="active"';?>>
				            <a href="<?php dourl('stockout'); ?>">已售罄</a>
				        </li>
				        <?php } ?>

				        <?php if (checkIsShow('soldout', $uid)) { ?>
				        <li <?php if($select_sidebar == 'soldout') echo 'class="active"';?>>
				            <a href="<?php dourl('soldout'); ?>">仓库中</a>
				        </li>
				        <?php } ?>
				    </ul>
				</div>
				<!-- ▲ Third Header -->
				<!-- ▼ Container App -->
				<div class="container-app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<div class="app__content js-app-main"></div>
						</div>
					</div>
				</div>
				<!-- ▲ Container App -->
			</div>
		</div>
		<!-- ▲ Container -->
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>