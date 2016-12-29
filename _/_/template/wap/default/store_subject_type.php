<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link href="<?php echo TPL_URL;?>css/new/base.css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/new/index.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/new/swiper.min.css" type="text/css">
<title><?php if($arr_diy_keywords['subject_type']) { echo $arr_diy_keywords['subject_type'];?><?php }else{?>专题分类<?php }?>展示</title>
<script src="<?php echo TPL_URL;?>js/swiper.min.js"></script>
<script src="<?php echo TPL_URL;?>js/rem.js"></script>
<?php if($is_mobile){ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
<?php }else{ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
<?php } ?>
<style>
.category_table >li > ul >li img{width:auto;height:2.6rem;border-radius:50%;}
</style>
</head>

<body>
<div class="category_top">
	<ul class="clearfix">
		<li  class="active"><a href="javascript:void(0)"><?php if($arr_diy_keywords['subject_type']) { echo $arr_diy_keywords['subject_type'];?><?php }else{?>专题分类<?php }?></a></li>
		<li><a href="<?php echo $store_product_list_url;?>"><?php if($arr_diy_keywords['subject_display']) { echo $arr_diy_keywords['subject_display'];?><?php }else{?>商品展示<?php }?></a></li>
	</ul>
	<!--  <i></i>--> </div>
<header class="margin"> </header>
<article>
	<section>
		<ul class="category_table">
			
			<?php if(is_array($array)) {?>
			<?php foreach($array as $k=>$v):?>
			 <li>
				<div class="category_table_title"> <?php echo $v['typename'];?> </div>
				<ul class="category_list clearfix">
				<?php if(count($v['childArray']) > 0) :?>
					<?php foreach($v['childArray'] as $k1=>$v1) :?>
				 <li> <a href="subtype.php?id=<?php echo $store_id;?>&sid=<?php echo $v1[id];?>">
				 	
						<div class="category_img"><img src="<?php echo $v1['typepic']?>" /></div>
						<p><?php echo $v1['typename'];?></p>
						</a> </li>
					<?php endforeach;?>	
				<?php endif;?>		

				</ul>
			</li>
			<?php endforeach;?>
			<?php }?>

		</ul>
	</section>
</article>
<footer>
<?php if(!empty($storeNav)){ echo $storeNav;}?>
	
</footer>
</body>
</html>
