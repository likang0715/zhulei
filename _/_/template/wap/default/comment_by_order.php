<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>发表评论</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="<?php echo TPL_URL;?>css/comment_add.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/order_list.css?time='<?php echo time()?>'"/>
<script>var order_store_id = '<?php echo $order_id;?>';
var order_id = '<?php echo $storeid;?>'
//alert(order_store_id)
</script>
<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo STATIC_URL;?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/comment_by_order.js"></script>


<style>
	.motify{display:none;position:fixed;top:35%;left:50%;width:220px;padding:0;margin:0 0 0 -110px;z-index:9999;background:rgba(0, 0, 0, 0.8);color:#fff;font-size:14px;line-height:1.5em;border-radius:6px;-webkit-box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);box-shadow:0px 1px 2px rgba(0, 0, 0, 0.2);@-webkit-animation-duration 0.15s;@-moz-animation-duration 0.15s;@-ms-animation-duration 0.15s;@-o-animation-duration 0.15s;@animation-duration 0.15s;@-webkit-animation-fill-mode both;@-moz-animation-fill-mode both;@-ms-animation-fill-mode both;@-o-animation-fill-mode both;@animation-fill-mode both;}
	.motify .motify-inner{padding:10px 10px;text-align:center;word-wrap:break-word;}
	.motify p{margin:0 0 5px;}.motify p:last-of-type{margin-bottom:0;}
	.name-card.name-card-3col{padding-right:0px;}
	.name-card .detail {margin-left:60px;text-align:left;}
	.shop_pinjgia_form .textarea,.shop_pingjia_form_list{border-bottom:0px;}
	.shop_pingjia .form_textarea{height:auto; min-height:50px;overflow-x:hidden;}
	.shop_pingjia_form_list_zong b{font-weight:700}
	.uls li{float:left;margin-right:5px;}
	.uls li img{width:55px;height:55px;}
	
	.block-item .prices ul{padding-right:0px;}
	.shop_pinjgia_form{padding-bottom:2px;}
</style>

</head>
<body style="background:#fff">

	
	<div class="content">
		<div id="order-list-container">
			<div class="b-list">
				<!-- -------- -->
				<?php foreach($order_product as $k=>$product) {?>
				<li data_pro_id = "<?php echo $product['product_id'];?>"; class="block 	<?php if($product['return_status']==0){?>block-order<?php }?> animated">
					<div class="block block-list block-border-top-none block-border-bottom-none">
						<div class="block-item name-card name-card-3col clearfix">
							<a href="javascript:void(0)" class="thumb">
								<img src="<?php echo $product['image']?>"/>
							</a>
							<?php if(count($order_product_comment['comment_list'][$product['product_id']])) {//有评价 ?>			
							<div class="detail">
								<a href="javascript:void(0)"><h3 style="margin-bottom:6px;"><p class="c-gray ellipsis"><div class="prices" style="text-align:inherit;padding-left:10px;">已评</div></p></h3></a>
								<p class="c-gray ellipsis"><div class="prices" style="text-align:inherit;color:#000;padding-left:10px;">
									<?php 
										echo trim(strip_tags($order_product_comment['comment_list'][$product['product_id']]['content']));
									?>
								
								
									<ul class="uls">
										<?php 
											if(count($order_product_comment['comment_list'][$product['product_id']]['attachment_list'])) {
												foreach($order_product_comment['comment_list'][$product['product_id']]['attachment_list'] as $k1=>$fujian) {	
										?>
													<li><img src="<?php echo $fujian['file']?>"/></li>
										<?php
												}
											}
										?>
									</ul>	
								</div></p>
							</div>
							<div class="right-col">
								<div class="price">
								
									<?php if(count($order_product_comment['comment_list'][$product['product_id']])) { echo date("Y-m-d", $order_product_comment['comment_list'][$product['product_id']]['dateline']);  }?>
								</div>
									<div class="num"><span class="num-txt"></span></div>
							</div>
							<?php } else {?>
								<!-- 未评价 -->
								<div class="detail detail_no">
							<a href="javascipt:void(0)"><h3 style="margin-bottom:6px;"><p class="c-gray ellipsis"><div class="prices" style="text-align:inherit;padding-left:10px;"><?php if($product['return_status']!=0) {?>已退款，无需评价<?php } else{?>尚未评价<?php }?></div></p></h3></a>
									<p class="c-gray ellipsis"><div class="prices" style="text-align:inherit;color:#000">
										
										<ul class="uls">
											
										</ul>	
									</div></p>
								</div>
								<div class="right-col">
									<div class="price">
									
										
									</div>
										<div class="num"><span class="num-txt"></span></div>
								</div>								
								
							<?php }?>
						</div>
					</div>
					<?php 
						if(count($order_product_comment['comment_list'][$product['product_id']])==0) {//无评价
							if($product['return_status']!=1){
								echo "<hr class='margin-0 left-10'>";
							}
						}
					?>		

					<div class="shop_pingjia">  
						<div class="shop_pinjgia_form" 
							
							<?php if(count($order_product_comment['comment_list'][$product['product_id']])) {//无评价?>
								style="border-top:0px;"
							<?php }?>
							
						>
						
							<?php 
								if(count($order_product_comment['comment_list'][$product['product_id']])==0) {//无评价
							?>
							<?php if($product['return_status']==0){?>
							<div class="shop_pingjia_form_list  appraise_li-list_top ">
								<div class="shop_pingjia_form_list_zong"><b><?php if(count($order_product_comment['comment_list'][$k])) { echo "已评价";  }else{echo "追加评价";}?></b></div>
								<ul>
									<li class="red">
										<div class="appraise_li-list_top_icon manyi">
											<input type="radio" class="ui-checkbox"  <?php if($product['score']>4) {?>checked="checked" <?php }elseif($product['score']=='0' || $product['score']=='') {?>checked="checked"<?php }?>value="5" name="manyi<?php echo $product['product_id']?>" />
											<label for="refund-reason00"><span>满意</span></label>
										</div>
									</li>
									<li class="yellow">
										<div class="appraise_li-list_top_icon yiban">
											<input type="radio" class="ui-checkbox" <?php if($product['score']==3) {?>checked="checked" <?php }?>  value="3" name="manyi<?php echo $product['product_id']?>" />
											<label for="refund-reason001"><span>一般</span></label>
										</div>
									</li>
									<li class="gray">
										<div class="appraise_li-list_top_icon bumanyi">
											<input type="radio" class="ui-checkbox" <?php if(in_array($product['score'],array(1,2))) {?>checked="checked" <?php }?> value="1" name="manyi<?php echo $product['product_id']?>" />
											<label for="refund-reason002"><span>不满意</span></label>
										</div>
									</li>
								</ul>
								<div style="clear:both"></div>
							</div>
							
								<div class="shop_pingjia_form_list  appraise_li-list_top " style="">
									<div class="shop_pingjia_form_list_zong">标签:</div>
									<ul class="biaoqian">
										<?php 
										if(is_array($tag_slist[$product['category_id']])) {
											foreach ($tag_slist[$product['category_id']] as $key => $tag) {
										?>
											<li>
												<input type="checkbox" class="ui-checkbox js-tag" id="tag_<?php echo $key ?>" value="<?php echo $key ?>" />
												<label for="tag_<?php echo $key ?>"><?php echo htmlspecialchars($tag) ?></label>
											</li>
										<?php 
											}
										}
										?>
									</ul>
								</div>
							<?php }?>

							<?php 
								if(count($order_product_comment['comment_list'][$product['product_id']])==0) {//无评价
							?>
							
							<?php 
									//}
								}
							?>
							<div class="textarea">
								<?php if($product['return_status']!=0){?>
									<textarea readonly="readonly"  name='contents<?php echo $product['product_id'];?>'  placeholder="该商品已退款，无需评论" cols="" rows="" class="form_textarea contents<?php echo $product['product_id'];?>"></textarea>
								<?php }else {?>
								<textarea  name='contents<?php echo $product['product_id'];?>'  placeholder="请写下对宝贝的感受吧，对他人帮助很大哦！" cols="" rows="" class="form_textarea contents<?php echo $product['product_id'];?>" style="border: solid #d9d9d9 1px;"></textarea>
								<?php }?>
							</div>
							
							<div class="shop_pingjia_form_list  appraise_li-list_top " style="border:0;">
								<div class="shop_pingjia_form_list_zong">图片:</div>
								<!--图片上传-->
								<div class="shop_pingjia_list shop_pingjia_list<?php echo $product['product_id'];?>">
								<ul>
									<li class="shop_add" id="shop_add">
										<form enctype="multipart/form-data"  class="upload_image_form" id="upload_image_form" target="iframe_upload_image" method="post" action="comment_attachment.php">
											<div class="updat_pic"> <a href="javascript:" id="upload_message">
												<img src="<?php echo TPL_URL;?>images/jiahao.png" /></a>
												<input type="file" <?php if($product['return_status']!=0){?>disabled="disabled"<?php }?> class="ehdel_upload <?php if($product['return_status']==0){?>upload_image<?php }?>"  id="upload_image" name="file" />
												<p style="z-index:-1">0/10</p>
											</div>
										</form>
									</li>
								</ul>
								</div>
								<iframe name="iframe_upload_image" style="width:0px; height:0px; display:none;"></iframe>
								<!--图片上传--> 
							</div>
							<?php if($product['return_status']==0){?>
								<?php if(count($order_product_comment['comment_list'][$product['product_id']])) {}else{?>
									<div style="width:auto;line-height:22px;background:#fff">
										<button class="form_button js_save" js_submit_proid = "<?php echo $product['product_id'];?>" data-pid="<?php echo $product['pigcms_id'] ?>" style="width:auto;line-height:22px; float:right;background:#00BB88;height:34px;color:#fff;padding:7px;">发表评论</button>
									</div>
								<?php }}?>
							<?php }?>
							
							
							
						</div>
					</div>
				</li>	
				<?php }?>	
				<!------>
				
				
				<!------>
				
												
			</div>
		</div>
	</div>
	<!-- ----------------------------------------------------------->
	<!-- 
	<div style="position:fixed;bottom:0px;width:100%;background:#fff">
		<button class="form_button js_save" style="float:right;background:#00BB88;height:34px;color:#fff;padding:7px;">发表评论</button>
	</div>
	-->
</body>
</html>
