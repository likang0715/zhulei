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
		<title>维权详细</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/fancybox.css"/>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/return_detail.js"></script>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order">
					<div class="app-inner inner-order" id="js-page-content">
						<div class="block block-order block-border-top-none">
							<div class="header">
								维权状态 <?php echo $rights['status_txt'] ?>
							</div>
						</div>
						<div class="block block-order block-border-top-none">
							<div class="header">
								<span>维权商品信息</span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<div class="block-item name-card name-card-3col clearfix js-product-detail">
									<a href="javascript:;" class="thumb">
										<img class="js-view-image" src="<?php echo $rights['image'] ?>" alt="<?php echo $rights['name'] ?>"/>
									</a>
									<div class="detail">
										<a href="./good.php?id=<?php echo $rights['product_id'] ?>"><h3><?php echo $rights['name'] ?></h3></a>
										<?php
											if($rights['sku_data']) {
												$sku_data_arr = unserialize($rights['sku_data']);
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
										<div class="price">￥<span><?php echo number_format($rights['pro_num'] * $rights['pro_price'], 2) ?></span></div>
										<div class="num">×<span class="num-txt"><?php echo $rights['pro_num'] ?></span></div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="block block-order block-border-top-none">
							<div class="header">
								<span>申请维权信息</span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<div class="action-tip">申请时间：<?php echo date('Y-m-d H:i', $rights['dateline']) ?></div>
								<div class="action-tip">维权类型：<?php echo $rights['type_txt'] ?></div>
								<div class="action-tip">手机号码：<?php echo $rights['phone'] ?></div>
								<div class="action-tip">维权理由：<?php echo htmlspecialchars($rights['content']) ?></div>
								<?php 
								if ($rights['images']) {
								?>
									<style>
									.image_list {padding:0px; margin:0px; list-style:none;}
									.image_list li {float:left; width:50px; height:50px; padding-right:5px; overflow:hidden; padding-bottom:5px; position:relative;}
									.image_list li img {max-width:50px; max-height:50px;}
									</style>
									<div class="action-tip">
										<div style="float:left;">
											图&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;片：
										</div>
										<div style="float:left;">
											<ul class="image_list">
												<?php 
												foreach ($rights['images'] as $image) {
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
						if ($rights['complete_dateline'] && $rights['platform_content']) {
						?>
							<div class="block block-order block-border-top-none">
								<div class="header">
									<span>处理信息</span>
								</div>
								<hr class="margin-0 left-10"/>
								<div class="block block-list block-border-top-none block-border-bottom-none">
									<div class="action-tip">完成时间：<?php echo date('Y-m-d H:i', $rights['complete_dateline']) ?></div>
									<div class="action-tip">处理结果：<?php echo nl2br(htmlspecialchars($rights['platform_content'])) ?></div>
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