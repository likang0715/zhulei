<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>申请退货</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.form.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var orderNo='<?php echo $nowOrder['order_no_txt'];?>';</script>
		<script src="<?php echo TPL_URL;?>js/return_apply.js"></script>
		<style>
		.block select {border:1px solid #e5e5e5; padding:5px; border-radius:4px; background: #fff url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAKCAYAAACjd+4vAAAA10lEQVQ4T7XSPxJFMBAG8G8PQK/TiFP4U3BcOgegMxq1Eyh0Gqo8m5m8wQQzed5WJnbyy7cJya26roPrugjDEE+1taNpGnieByHEU/vlf2rbVvZ9DyJCHMe3OKN1XWMYBtWfJIk1TkVRyGma1Mnu8D2qY3DiNE2tUtOyLLKqKtzhJjQIAoXyYW2K+I7XdcUV/g9UTZdh/jDhURRhHEd1p7p+Tar3+cIm/DzCt9BDYo2ck7+d1Jh4j5dliXme1ZLv+8jz3PohmR7fYdT7Bp3ccRxkWfYqys4HBLeZ4wvKfMkAAAAASUVORK5CYII=") no-repeat scroll right center / 15px 5px}
		</style>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order">
					<div class="app-inner inner-order" id="js-page-content">
					
						<div class="block block-form">
							<!-- 快递 -->
							<div class="block-item " style="padding:5px 0; font-weight:bold;">
								<ul>
									<li style="clear:both; height:24px; line-height:24px;">
										<span style="float:left; padding:0px; color:#CCC;">商品名称：</span>
										<span style="float:right; padding:0px; color:#666;"><?php echo htmlspecialchars($order_product['name']) ?></span>
									</li>
									<li style="clear:both; height:24px; line-height:24px;">
										<span style="float:left; padding:0px; color:#CCC;">商品单价：</span>
										<span style="float:right; padding:0px; color:#666;">￥<?php echo $order_product['pro_price'] ?></span>
									</li>
									<li style="clear:both; height:24px; line-height:24px;">
										<span style="float:left; padding:0px; color:#CCC;">订单编号：</span>
										<span style="float:right; padding:0px; color:#666;"><?php echo option('config.orderid_prefix') . $order['order_no'] ?></span>
									</li>
									<li style="clear:both; height:24px; line-height:24px;">
										<span style="float:left; padding:0px; color:#CCC;">交易时间 	：</span>
										<span style="float:right; padding:0px; color:#666;"><?php echo date('Y-m-d H:i:s', $order['add_time']) ?></span>
									</li>
								</ul>
							</div>
						</div>
					
						<div class="block block-top-0 block-border-top-none">
							<div class=" action-tip" style=" height:30px; line-height:30px;">
								退货数量：
								<select name="pro_num" style="width:200px;">
									<?php 
									for ($i = 1; $i <= $order_product['pro_num'] - $return_number; $i++) {
									?>
										<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class=" action-tip" style=" height:30px; line-height:30px;">
								退货原因：
								<select style="width:200px;" name="type">
									<option value="">请选择退货理由</option>
									<?php 
									foreach ($type_arr as $key => $type) {
									?>
										<option value="<?php echo $key ?>"><?php echo $type ?></option>
									<?php
									}
									?>
								</select>
							</div>
							<div class=" action-tip" style=" height:30px; line-height:30px;">
								手机号码：
								<input type="text" name="phone" class="txt txt-black ellipsis" placeholder="请填写手机号便于卖家联系您" />
							</div>
							<div class=" action-tip" style=" height:30px; line-height:30px;">
								退货说明：
								<input type="text" name="content" class="txt txt-black ellipsis" placeholder="最多可填写200个字" maxlength="200" />
							</div>
							<div class=" action-tip">
								图片举证：可上传5张图片
							</div>
							<style>
							.image_list {padding:0px; margin:0px; list-style:none;}
							.image_list li {float:left; width:50px; height:50px; padding-right:5px; overflow:hidden; padding-bottom:5px; position:relative;}
							.image_list li img {max-width:50px; max-height:50px;}
							.image_list li span {background: url(<?php echo TPL_URL;?>/images/weidian_icon.png) 193px -412px; width: 15px; height: 15px; position: absolute; top: 0; right: 5px;}
							</style>
							<div class=" action-tip shop_pingjia_list" style="padding-left:75px;">
								<ul class="image_list">
								</ul>
								<form enctype="multipart/form-data" id="upload_image_form" target="iframe_upload_image" method="post" action="comment_attachment.php">
									<div class="updat_pic"> <a href="javascript:" id="upload_message"><img src="<?php echo TPL_URL;?>images/jiahao.png" style="width:50px; height:50px;" /></a>
										<input type="file" accept="image/*" class="ehdel_upload hide" id="upload_image" name="file" />
									</div>
								</form>
								<iframe name="iframe_upload_image" style="width:0px; height:0px; display:none;"></iframe>
							</div>
						</div>
					</div>
					
					<div class="js-step-topay ">
						<div class="action-container">
							<div style="margin-bottom:10px;">
								<button type="button" class="btn-pay btn btn-block btn-large btn-green js-save-btn">提交</button>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			<?php include display('footer');?>
		</div>
		<?php echo $shareData;?>
	</body>
</html>