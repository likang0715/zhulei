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
		<title>找人代付</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
		<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/order_share.css">
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script src="<?php echo TPL_URL;?>js/order_share.js"></script>
	</head>
	<body>
		<div class="container js-page-content wap-page-order">
			<div class="content confirm-container">
				<div class="app app-order  peerpay-gift ">
					<div class="app-inner inner-order" id="js-page-content">
                        <!-- 通知 -->
                        <!-- 商品列表 -->
						<div class="block block-order block-border-top-none">
							<div class="header">
								<span>来自小伙伴的的代付订单</span>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="block block-list block-border-top-none block-border-bottom-none">
								<?php if(isset($_GET['orderName'])){?>
									<div class="block-item name-card name-card-3col clearfix">
										<div class="detail" style="margin-left:0px;">
											<a href="javascript:void(0)"><h3><?php echo $_GET['orderName'];?></h3></a>
										</div>
										<div class="right-col">
											<div class="price">￥<span><?php echo $nowOrder['sub_total']?></span></div>
											<div class="num">×<span class="num-txt">1</span></div>
										</div>
									</div>
								<?php } ?>
								<?php foreach($nowOrder['proList'] as $value){ ?>
									<div class="block-item name-card name-card-3col clearfix js-product-detail">
										<a href="javascript:;" class="thumb">
											<img class="js-view-image" src="<?php echo $value['image'];?>" alt="<?php echo $value['name'];?>"/>
										</a>
										<div class="detail">
											<a href="./good.php?id=<?php echo $value['product_id'];?>"><h3><?php echo $value['name'];?></h3></a>
											<?php 
											if ($value['is_present']) {
												echo '<span style="color:#f60">赠品</span>';
											}
											?>
											<?php
												if($value['sku_data_arr']){
													foreach($value['sku_data_arr'] as $v){
											?>
														<p class="c-gray ellipsis"><?php echo $v['name'];?>：<?php echo $v['value'];?></p>
											<?php 
													}
												}
											?>
										</div>
										<div class="right-col">
											<div class="price">￥<span><?php echo number_format($value['pro_num']*$value['pro_price'],2);?></span></div>
											<div class="num">×<span class="num-txt"><?php echo $value['pro_num'];?></span></div>
											<?php if($value['comment_arr']){?>
												<a class="link pull-right message js-show-message" data-comment='<?php echo json_encode($value['comment_arr']) ?>' href="javascript:;">查看留言</a>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>
							<hr class="margin-0 left-10"/>
							<div class="bottom">总价<span class="c-orange pull-right">￥<?php echo $nowOrder['sub_total']?></span></div>
						</div>
					</div>
					
					<div class="block block-border-top-none">
						<div class="js-type-selector tabber tabber-top" style="border:none;">
							<button class="first active" data-type="onepay">单人代付</button>
							<button data-type="multipay">多人代付</button>
						</div>
						<div class="js-onepay steps ">
							<div class="step-3 step-x center">
								<hr>
								<div class="step step-3-1"></div>
								<p>留言并分享</p>
							</div>
							<div class="step-3 step-x center">
								<hr>
								<div class="step step-3-2"></div>
								<p>朋友全额付款</p>
							</div>
							<div class="step-3 step-x center">
								<hr>
								<div class="step step-3-3"></div>
								<p>代付成功</p>
							</div>
						</div>
						<div class="js-multipay steps center hide">
							<div class="step-4 step-x center">
								<hr>
								<div class="step step-4-1"></div>
								<p>留言并分享</p>
							</div>
							<div class="step-4 step-x center">
								<hr>
								<div class="step step-4-2"></div>
								<p>多人参与付款</p>
							</div>
							<div class="step-4 step-x center">
								<hr>
								<div class="step step-4-3"></div>
								<p>筹集完金额</p>
							</div>
							<div class="step-4 step-x center">
								<hr>
								<div class="step step-4-4"></div>
								<p>代付成功</p>
							</div>
						</div>
					</div>
					<div class="invite-message">
					<textarea id="peerpay_content" class="txt txt-black time-line-title" placeholder="说点什么吧？" maxlength="200"><?php echo htmlspecialchars($store_pay_agent['content']) ?></textarea>
				</div>
					<div class="app-inner inner-order peerpay-gift" style=";" id="sku-message-poppage">
						<div class="action-container">
							<button type="button" class="btn-pay btn btn-block btn-large btn-peerpay btn-green">下一步</button>
							<button class="btn btn-white btn-block js-cancel" data-orderid="<?php echo $nowOrder['order_id'] ?>">查看订单详情</button>
						</div>
					</div>
				</div>
			</div>
			<?php $noFooterLinks=true; include display('footer');?>
		</div>
	</body>
</html>
<?php Analytics($nowOrder['store_id'], 'pay', '订单支付', $nowOrder['order_id']); ?>