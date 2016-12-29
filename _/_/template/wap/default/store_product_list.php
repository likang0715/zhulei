<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link href="<?php echo TPL_URL;?>css/new/base.css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/new/index.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/new/swiper.min.css" type="text/css">
<title><?php if($arr_diy_keywords['subject_display']) { echo $arr_diy_keywords['subject_display'];?><?php }else{?>商品<?php }?>展示</title>
<script src="<?php echo TPL_URL;?>js/swiper.min.js"></script>
<script src="<?php echo TPL_URL;?>js/rem.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/fastclick.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script src="<?php echo TPL_URL;?>index_style/js/store_category1.js"></script>
<?php if($is_mobile){ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
<?php }else{ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
<?php } ?>
<style>
.xuanzhong{background:#fff}
article{margin-bottom:0px;}
</style>
</head>

<body>
<div class="category_top">
	<ul class="clearfix">
		<li  ><a href="<?php echo $store_subjet_type_url;?>"><?php if($arr_diy_keywords['subject_type']) { echo $arr_diy_keywords['subject_type'];?><?php }else{?>专题分类<?php }?></a></li>
		<li class="active"><a href="javascript:void(0)"><?php if($arr_diy_keywords['subject_display']) { echo $arr_diy_keywords['subject_display'];?><?php }else{?>商品展示<?php }?></a></li>
	</ul>
	<!--  <i></i>--> </div>
<article>
	<section>
		<div class="shop_list_hr"></div>
		<div class="shop_list_content clearfix  ">
			<div id=" " class="shop_menu"  >
				<ul class="barNavLi" id="allcontent">
					<?php foreach ($cat_list as $k=>$value) { ?>
					<li class="cat_li <?php if($k==0) { echo 'active';}?>"> <a href="#f_<?php echo $value['cat_id']; ?>"><?php echo mb_substr($value['cat_name'],0,5,'utf-8'); ?></a> </li>
					<?php } ?>
					
					 <?php if(!empty($storeNav)){?>
						 <li class="cat_li" style="height:50px;"></li>
					<?php }?>

				</ul>
			</div>
			<div class="shop_product" >
				<?php foreach ($cat_list as $values) { ?>
					<div class="shop_title"><?php echo $values['cat_name']; ?></div>
					<ul class="clearfix" id="f_<?php echo $values['cat_id']; ?>" >
						<?php if (!empty($values['cat_list'])) { ?>
							<?php foreach ($values['cat_list'] as $v2) {?>
								<li>
									<a href="<?php echo $store_product_search_url."&cat_id=".$v2['cat_id']; ?>">
										<div class="shop_img"><img src="<?php echo $v2['cat_pic']; ?>" ></div>
										<p class="product_name"> <?php echo $v2['cat_name']; ?></p>
									</a>
								</li>
							<?php  } ?>
							
						<?php  } ?>
					</ul>	
				 <?php } ?>
			</div>
		</div>
	</section>
</article>
<script>
$(function(){
	
	 $("#allcontent .cat_li").live("click",function(){
		 $("#allcontent .cat_li").removeClass("active");
		 $(this).addClass("active"); 
	 })
	 $('.barNavLi').onePageNav();	
	
})


 </script>
 <?php if(!empty($storeNav)){

 echo "<div class='nav-menu-2' style='clear:both;display:block'></div>";

 echo $storeNav;}?>
</body>
</html>
