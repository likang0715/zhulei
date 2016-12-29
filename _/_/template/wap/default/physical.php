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
		<?php if($is_weixin){ ?>
			<title>线下门店</title>
		<?php }else{ ?>
			<title>线下门店 - <?php echo $now_store['name'];?></title>
		<?php } ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>diancha/css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>diancha/css/offline_shop.css"/>
		<link href="<?php echo TPL_URL;?>diancha/skin/css/style.css" type="text/css" rel="stylesheet">
		<link href="<?php echo TPL_URL;?>diancha/skin/css/mystyle.css" type="text/css" rel="stylesheet">
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.min.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/jquery.waterfall.js"></script>
		<script src="<?php echo $config['site_url'];?>/static/js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>diancha/js/base.js"></script>
	</head>
	<body>
	
	 <div class="content">
	 		<?php
					if($store_physical){
						foreach($store_physical as $value){
				?>
        <div class="store_list">
            <div class="store_logo_div">
			<?php
			$value['images']=explode(',',$value['images']);
						foreach($value['images'] as $r){
						$images = $r;
						
				break;
						}
				?>
                <img src="<?php echo $images;?>" class="store_logo">
            </div>
           <a <?php if($value['linkurl']){ ?> href="<?php echo $value['linkurl'];?>"<?php }	?> class="store_show">
                <b class="store_name"><?php echo $value['name'];?></b>
                <p class="store_address"><?php echo $value['province_txt'];?><?php echo $value['city_txt'];?><?php echo $value['county_txt'];?> <?php echo $value['address'];?></p>
				
        </a>
            <div class="store_con">
                <a href="./diancha.php?id=<?php echo $value['store_id'];?>&pigcmsid=<?php echo $value['pigcms_id'];?>" class="order_tea"><img src="<?php echo TPL_URL;?>diancha/skin/images/order_tea.png">点茶</a>
                <a href="tel:<?php if($value['phone1']){ echo $value['phone1'];}?><?php echo $value['phone2'];?>" class="store_contact"><img src="<?php echo TPL_URL;?>diancha/skin/images/store_contact.png">电话</a>
                <a href="./physical_detail.php?id=<?php echo $value['pigcms_id'];?>" class="order_nav"><img src="<?php echo TPL_URL;?>diancha/skin/images/order_nav.png">导航</a>
            </div>
        </div>

 	<?php
						}
					}
				?>

    </div>
	

		<div class="container">
		
			<?php include display('footer');?>
		</div>
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