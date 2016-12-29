<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no" />
	<meta name="format-detection" content="email=no" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>收银台</title>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/event_list.css">
	<script src="<?php echo TPL_URL;?>/diancha/js/jquery-1.11.0.min.js"></script>
	   <script type="text/javascript">
		$(function() {
			$('.more_item .item_all').each(function() {
				var pid = $(this).attr('id');
				$(this).find('input').each(function() {
					$(this).attr('id', pid+'_'+$(this).index());
					$(this).after('<label for="'+pid+'_'+$(this).index()+'">'+$(this).attr('data-name')+'</label>');
				});
			});
			$('ul.search_menu li').click(function() {
				var i = $(this).index();
				if ($(this).hasClass('submenu_cur')) {
					$('.search_submenu .submenu_item,.body_dark').hide();
					$('.submenu_cur').removeClass('submenu_cur');
				} else{
					$('.search_submenu .submenu_item').hide();
					$('.search_submenu .submenu_item').eq(i).show();
					$('.body_dark').show();
					$('.submenu_cur').removeClass('submenu_cur');
					$(this).addClass('submenu_cur');
				};
			});
			$('.body_dark').click(function() {
				$('.search_submenu .submenu_item,.body_dark').hide();
				$('.submenu_cur').removeClass('submenu_cur');
			});
		});
		</script>

	</head>
	<body>
	<div class="event_search">
	
	<p class="team-code">

							<img src="<?php echo $config['wap_site_url']."/shoukuan.php?id=18";?>" alt="">
                        </p>
	</div>
	
	</body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>