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
	<title><?php echo $meal['name'];?></title>
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
	var create_fans_supplier_store_url="<?php echo $config['site_url'] ?>/wap/create_fans_supplier_store.php";
	</script>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/tables.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/comment.css" />
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/fancybox.css"/>
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
	var storeId=<?php echo $now_store['store_id'];?>,
	cz_id=<?php echo $meal['cz_id'];?>,
	showBuy=<?php echo $meal['status'];?>
	</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js?time=<?php echo time()?>"></script>
	<script src="<?php echo TPL_URL;?>js/tables.js"></script>
	<style>
	body,.container{background: #eaeaea;}
	</style>
</head>

<body class="body-fixed-bottom">


	
						<div class="row proDetail js-content-detail">
							<?php echo $meal['content']?>
						</div>
						


</body>
</html>
