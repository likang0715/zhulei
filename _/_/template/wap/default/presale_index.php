<!DOCTYPE html>
<html>
<head>
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
		
	<title>预售</title>
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="address=no">
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />	
	<?php if($is_mobile){ ?>
		<script>var is_mobile = true;</script>
	<?php }else{ ?>
		<script>var is_mobile = false;</script>
	<?php } ?>		
	<script>
		var is_logistics = true;
		var is_selffetch = true;
		var create_fans_supplier_store_url="<?php echo $config['site_url'] ?>/wap/create_fans_supplier_store.php";
		var product_id='<?php echo $product_id;?>';
		var storeId='<?php echo $now_store['store_id'];?>';
		var buytype="presale";	//标注
		var presale_id = '<?php echo $id;?>';
		var presale_price = "<?php echo $presale_info['dingjin'];?>";
	</script>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/presale/base.css">
	<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/presale/style.css">
	<script src="<?php echo TPL_URL; ?>js/jquery-1.7.2.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.waterfall.js"></script>
	<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>	
	<script src="<?php echo TPL_URL; ?>js/index.js"></script>
	<script src="<?php echo TPL_URL; ?>js/rem.js"></script>
	<script src="<?php echo TPL_URL; ?>js/presale.js"></script>
	<style>
	.group_info table td{width:auto}
	</style>
	<script>

	</script>
	<script src="<?php echo TPL_URL;?>js/sku.js"></script>
</head>

<body>
	<div id="js_share_guide" class="js-fullguide fullscreen-guide hide" style="font-size: 16px; line-height: 35px; color: #fff; text-align: center;"><span class="js-close-guide guide-close">×</span><span class="guide-arrow"></span><div class="guide-inner">请点击右上角<br>通过【发送给朋友】功能<br>或【分享到朋友圈】功能<br>把好商品分享给小伙伴哟～</div></div>  

	<header class="header_title"> 
	<a href="javascript:void(0)" onclick="javascript:history.go(-1);"><i></i></a>
		<p><?php echo $presale_info['name'];?></p>
	</header>
	<article>
		<section class="index_group">
			<div class="product_info clearfix">
				<div class="product_img"><img src="<?php echo $presale_info['image'];?>" alt=""> </div>
				<div class="product_txt clearfix">
					<div class="produc_name">
						<h1><?php echo $presale_info['product_name'];?></h1>
						<p><span>定金:￥<?php echo $presale_info['dingjin'];?></span><span><i>总价:￥<?php echo $presale_info['price'];?></i></span></p>
					</div>
					<div class="product_but sale_index_but">
					<a href="javascript:void(0)">
					
					<span class="js-open-share">分享</span>
					<?php if($presale_info['is_open']!=1) {?>
						<!-- 尚未开启预售 -->
						<span  class="js-buy_history sale_but" data-type="unstart">预定</span>
					<?php } else if(time() > $presale_info['final_paytime']) {?>
						<!-- 预售已结束 -->
						<span  class="js-buy_history sale_but"  data-type="end">预定</span>
					<?php }else if($presale_info['status'] !=0) {?>
						<!-- 商品不在仓库中 -->
						<span  class="js-buy_history sale_but"   data-type="unsoldout">预定</span>
					<?php } else if(($presale_info['soldout'] == 1) || ($presale_info['quantity'] <= 0)) {?>
						<!-- 商品无库存 -->
						<span  class="js-buy_history sale_but " data-type="unquantity">预定</span>
					<?php } else if($presale_info['presale_amount'] <= $presale_info['buy_count']) {?>
						<!-- 商品无库存 -->
						<span  class="js-buy_history sale_but " data-type="unquantity">预定</span>
					<?php } else {?>
						<span  class="js-buy_history sale_but">预定</span>
					<?php }?>
				
					</a></div>
				</div>
			</div>
			<ul class="group_explain sale_reserve">
				<li><span>已预定人数</span><span><?php echo ($presale_info['presale_person']+$presale_info['pre_buyer_count']);?></span></li>
				<li><span>本预售有效期</span><span class="time"><?php echo date("Y-m-d",$presale_info['starttime']);?>&nbsp;&nbsp;<?php echo date("Y-m-d",$presale_info['endtime']);?></span></li>
				<li><span>尾款支付截止日期</span><span class="ye_time"><?php echo date("Y年m月d日",$presale_info['final_paytime']);?></span></li>
			</ul>
			<div class="group_active sale_active">
				<h2>预售特权</h2>
				<p>
				
					<!--<span>1.定金可以算作购款额</span> -->
					<?php $i=0;?>
					
					<?php foreach($power as $k=>$v) {?>
						<?php if(($k=='cash') && ($v>0)) {?>
							<?php $i++;?>
							<span><?php echo $i;?>.支付尾款，可减免<?php echo (int)$v;?>元</span> 
						<?php }?>
										
						<?php if($k == 'coupon') {?>
							<?php $i++;?>
							<span><?php echo $i;?>.支付尾款，赠优惠券</span> 	
						<?php }?>
						
						<?php if($k == 'present') {?>
							<?php $i++;?>
							<span><?php echo $i;?>.支付尾款，送赠品</span> 	
						<?php }?>
						
					<?php }?>
					<?php unset($i);?>
					

				</p>
			</div>
			<div class="group_active">
				<h2>预售说明</h2>
				<p><?php echo $presale_info['description'];?></p>
			</div>
		</section>
		<nav class="title_table activity_title">
			<ul class="clearfix">
				<li class=" active"><a href="javascript:void(0)">商品详情</a></li>
				<li ><a href="javascript:void(0)">预订记录</a></li>
			</ul>
		</nav>
		<ul class="sala_list acticity_list">
			<li>
				<section class="sala_info">
					<p><?php echo $presale_info['info']?></p>
				</section>
			</li>
			<li>
				<section class="group_info">
					<table>
						<thead>
							<tr>
								<td>用户</td>
								<td>预定价格</td>
								<td>预定时间</td>
							</tr>
						</thead>
						<tbody class="order_list" data-type="default" data-page="1" next="true">
						</tbody>
						<tr>
							<td colspan="3" class="noData"></td>
						</tr>
					</table>
				</section>
			</li>
		</ul>
 
	</article>

<?php include display('footer');?>

</body>


</html>
