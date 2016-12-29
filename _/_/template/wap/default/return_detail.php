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
		<title>退货详细</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/fancybox.css"/>
		<script>
		var id = "<?php echo $return['id'] ?>";
		</script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/return_detail.js"></script>
		<style>
		.block select {border:1px solid #e5e5e5; padding:3px; border-radius:4px; background: #fff url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAKCAYAAACjd+4vAAAA10lEQVQ4T7XSPxJFMBAG8G8PQK/TiFP4U3BcOgegMxq1Eyh0Gqo8m5m8wQQzed5WJnbyy7cJya26roPrugjDEE+1taNpGnieByHEU/vlf2rbVvZ9DyJCHMe3OKN1XWMYBtWfJIk1TkVRyGma1Mnu8D2qY3DiNE2tUtOyLLKqKtzhJjQIAoXyYW2K+I7XdcUV/g9UTZdh/jDhURRhHEd1p7p+Tar3+cIm/DzCt9BDYo2ck7+d1Jh4j5dliXme1ZLv+8jz3PohmR7fYdT7Bp3ccRxkWfYqys4HBLeZ4wvKfMkAAAAASUVORK5CYII=") no-repeat scroll right center / 15px 5px}
		</style>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order">
					<div class="app-inner inner-order" id="js-page-content">
						<div class="block block-order block-border-top-none">
							<div class="header">
								申请退货状态 <?php echo $return['status_txt'] ?>
							</div>
						</div>
						<div class="block block-order block-border-top-none">
							<div class="header">
								<span>退货商品信息</span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<div class="block-item name-card name-card-3col clearfix js-product-detail">
									<a href="javascript:;" class="thumb">
										<img class="js-view-image" src="<?php echo $return['image'] ?>" alt="<?php echo $return['name'] ?>"/>
									</a>
									<div class="detail">
										<a href="./good.php?id=<?php echo $return['product_id'] ?>&store_id=<?php echo $return['store_id'] ?>"><h3><?php echo $return['name'] ?></h3></a>
										<?php
											if($return['sku_data']) {
												$sku_data_arr = unserialize($return['sku_data']);
												foreach($sku_data_arr as $v){
										?>
													<p class="c-gray ellipsis">
														<?php echo $v['name'] ?>：<?php echo $v['value'] ?>
													</p>
										<?php 
												}
											}
										?>
									</div>
									<div class="right-col">
										<div class="price">￥<span><?php echo number_format($return['pro_num'] * $return['pro_price'], 2) ?></span></div>
										<div class="num">
											<?php 
											if ($return['discount'] && $return['discount'] != 10) {
											?>
												<span style="padding:0px 5px; background:#f60; color:white; border-radius:3px;"><?php echo $return['discount'] ?>折</span>
											<?php 
											}
											?>
											×<span class="num-txt"><?php echo $return['pro_num'] ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="block block-order block-border-top-none">
							<div class="header">
								<span>申请退货信息</span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<div class="action-tip">申请时间：<?php echo date('Y-m-d H:i', $return['dateline']) ?></div>
								<div class="action-tip">退货类型：<?php echo $return['type_txt'] ?></div>
								<div class="action-tip">手机号码：<?php echo $return['phone'] ?></div>
								<div class="action-tip">退货理由：<?php echo htmlspecialchars($return['content']) ?></div>
								<?php 
								if ($return['images']) {
								?>
									<style>
									.image_list {padding:0px; margin:0px; list-style:none;}
									.image_list li {float:left; width:50px; height:50px; padding-right:5px; overflow:hidden; padding-bottom:5px; position:relative;}
									.image_list li img {max-width:50px; max-height:50px;}
									.image_list li span {background: url(<?php echo TPL_URL;?>/images/weidian_icon.png) 193px -412px; width: 15px; height: 15px; position: absolute; top: 0; right: 5px;}
									</style>
									<div class="action-tip">
										<div style="float:left;">
											图&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;片：
										</div>
										<div style="float:left;">
											<ul class="image_list">
												<?php 
												foreach ($return['images'] as $image) {
												?>
													<li><a href="<?php echo $image ?>" rel="show_img"><img src="<?php echo $image ?>" /></a></li>
												<?php 
												}
												?>
											</ul>
										</div>
									</div>
								<?php 
								}
								?>
							</div>
						</div>
						
						<!-- 商家回复信息 -->
						<?php 
						if ($return['status'] != 1 && $return['status'] != 6) {
						?>
							<div class="block block-order block-border-top-none">
								<div class="header">
									<span>商家审核信息</span>
								</div>
								<hr class="margin-0 left-10"/>
								<div class="block block-list block-border-top-none block-border-bottom-none">
									<?php 
									if ($return['status'] == 2) {
									?>
										<div class="action-tip">不同意退货时间：<?php echo date('Y-m-d H:i', $return['cancel_dateline']) ?></div>
										<div class="action-tip">不同意退货理由：<?php echo htmlspecialchars($return['store_content']) ?></div>
									<?php 
									} else {
									?>
										<div class="action-tip">退款总费用：￥<?php echo sprintf('%.2f', $return['product_money'] + $return['postage_money']) ?> = 产品金额：<?php echo $return['product_money'] ?> + 物流金额：<?php echo $return['postage_money'] ?></div>
										<?php 
										if ($return['platform_point'] > 0) {
										?>
											<div class="action-tip">退还<?php echo option('credit.platform_credit_name') ?>：<?php echo $return['platform_point'] ?></div>
										<?php
										}
										if ($return['address']) {
										?>
											<div class="action-tip">收货人姓名：<?php echo $return['address_user'] ?></div>
											<div class="action-tip">收货人电话：<?php echo $return['address_tel'] ?></div>
											<div class="action-tip">收货人地址：<?php echo $return['province_txt'] . $return['city_txt'] . $return['area_txt'] . $return['address_txt'] ?></div>
									<?php
										} 
									}
									?>
								</div>
							</div>
						<?php 
						}
						if ($return['status'] == 3 && empty($return['express_no']) && !empty($return['address'])) {
						?>
							<div class="block block-order block-border-top-none">
								<div class="header">
									<span>物流信息</span>
								</div>
								<hr class="margin-0 left-10"/>
								<div class="block block-list block-border-top-none block-border-bottom-none">
									<div class="action-tip">
										快递公司：
										<select name="express_code" style="width:200px;">
											<option value="">请选择快递公司</option>
											<?php 
											foreach ($express_list as $tmp) {
											?>
												<option value="<?php echo $tmp['code'] ?>"><?php echo $tmp['name'] ?></option>
											<?php
											}
											?>
										</select>
									</div>
									<div class="action-tip ">
										快递单号：<input type="text" name="express_no" class="txt txt-black ellipsis" style="padding:5px;" placeholder="请填写快递单号" />
										<a href="javascript:" class="btn btn-green js-submit-btn" data-id="<?php echo $return['id'] ?>">提交</a>
									</div>
								</div>
							</div>
						<?php
						} else if (!empty($return['express_no'])) {
						?>
							<div class="block block-order block-border-top-none">
								<div class="header">
									<span>物流信息</span>
								</div>
								<hr class="margin-0 left-10"/>
								<div class="block block-list block-border-top-none block-border-bottom-none">
									<div class="action-tip">
										快递公司：<?php echo $return['express_company'] ?>
									</div>
									<div class="action-tip ">
										快递单号：<?php echo $return['express_no'] ?>
										<a href="javascript:" class="btn btn-green js-express-btn" data-type="<?php echo $return['express_code'] ?>" data-express_no="<?php echo $return['express_no'] ?>">查看物流信息</a>
									</div>
									<style>
									.express_detail td {padding-top:10px;}
									</style>
									<div class="express_detail" data-is_has="0" style="display:none;">
									</div>
								</div>
							</div>
						<?php
						}
						if ($return_list) {
						?>
							<div class="block block-order block-border-top-none">
								<div class="header">
									<span>此商品的其它退货</span>
								</div>
								<hr class="margin-0 left-10"/>
								<div class="block block-list block-border-top-none block-border-bottom-none">
									<?php 
									foreach ($return_list as $return_tmp) {
									?>
										<div class="action-tip"><a href="return_detail.php?id=<?php echo $return_tmp['id'] ?>"><?php echo date('Y-m-d H:i', $return_tmp['dateline']) ?>的退货，退货状态：<?php echo $return_tmp['status_txt'] ?></a></div>
									<?php 
									}
									?>
								</div>
							</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
			<?php include display('footer');?>
		</div>

		<?php echo $shareData;?>
	</body>
</html>