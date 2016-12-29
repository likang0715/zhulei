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

			<title>茶会报名</title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/offline_shop.css"/>
		
			<link href="<?php echo TPL_URL;?>skin/css/style.css" type="text/css" rel="stylesheet">
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>

	</head>
	<body>
	<div class="content">

 <?php echo $ok_tips;?>
 
        </div>
    </div>

	
	
	
	
	
			<?php include display('footer');?>

		<?php if($is_weixin){ ?>
			<script>
				$('.js-view-image-list').click(function(){
					var t = [];
					$.each($(this).find('.js-view-image-item'),function(i,item){
						t[i] = $(item).attr('src');
					});
					var i = t[0];
					window.WeixinJSBridge && window.WeixinJSBridge.invoke("imagePreview",{current:i,urls:t});
				});
			</script>
		<?php } ?>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>