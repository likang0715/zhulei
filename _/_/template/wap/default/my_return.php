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
		<title>我的退货</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/order_list.css"/>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>
		$(function () {
			if($('li.block-order').size() == 0){
				$('.empty-list').show();
			}
			$("#pages a").click(function () {
				var page = $(this).attr("data-page-num");
				location.href = "my_return.php?page=" + page;
			});

			$(".js-cancel-return").click(function () {
				var id = $(this).data("id");
				$.post("", {id : id, action : "cancel"}, function (data) {
					if (data.status == true) {
						motify.log(data.msg);
						location.reload();
					} else {
						motify.log(data.msg);
					}
				}, "json");
			});
		});
		</script>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div id="order-list-container">
					<div class="b-list">
						<?php foreach($return_list as $return){?>
							<li class="block block-order animated">
								<div class="header">
									<span class="font-size-12">退货状态：<?php echo $return['status_txt'] ?></span>
									<?php
									if($return['status'] < 5) {
									?>
										<a class="js-cancel-return pull-right font-size-12 c-blue" href="javascript:;" data-id="<?php echo $return['id'];?>">取消退货</a>
									<?php
									}
									?>
								</div>
								<hr class="margin-0 left-10"/>
								<div class="block block-list block-border-top-none block-border-bottom-none">
									<div class="block-item name-card name-card-3col clearfix">
										<a href="good.php?id=<?php echo $return['product_id'] ?>&store_id=<?php echo $return['store_id'] ?>" class="thumb">
											<img src="<?php echo $return['image'];?>"/>
										</a>
										<div class="detail">
											<a href="good.php?id=<?php echo $return['product_id'] ?>&store_id=<?php echo $return['store_id'] ?>"><h3 style="margin-bottom:6px;"><?php echo $return['name'];?></h3></a>
											<?php
												if($return['sku_data']){
													$sku_data_arr = unserialize($return['sku_data']);
													foreach($sku_data_arr as $v){
											?>
														<p class="c-gray ellipsis"><?php echo $v['name'];?>：<?php echo $v['value'];?></p>
											<?php 
													}
												}
											?>
										</div>
										<div class="right-col">
											<div class="price">¥&nbsp;<span><?php echo $return['pro_price'];?></span></div>
											<div class="num">退货数量：<span class="num-txt"><?php echo $return['pro_num'];?></span></div>
										</div>
									</div>
								</div>
								<hr class="margin-0 left-10"/>
								<div class="bottom">
									<div class="opt-btn">
										<?php
										if($return['status'] < 5) {
										?>
											<a class="btn btn-in-order-list js-cancel-return" data-id="<?php echo $return['id'] ?>" style="width:70px;" href="javascript:">取消退货</a>
										<?php
										}
										?>
										<a class="btn btn-in-order-list" style="width:70px;" href="return_detail.php?id=<?php echo $return['id'] ?>">退货详情</a>
									</div>
								</div>
							</li>
						<?php } ?>
						<div class="bottom" id="pages">
							<?php echo $pages ?>
						</div>
					</div>
					<div class="empty-list list-finished" style="padding-top:60px;display:none;">
						<div>
							<h4>您没有退货</h4>
						</div>
						<div><a href="index.php" class="tag tag-big tag-orange" style="padding:8px 30px;">去逛逛</a></div>
					</div>
				</div>
			</div>
		</div>
		<?php echo $shareData;?>
	</body>
</html>
<?php Analytics($now_store['store_id'], 'return', '退货记录', $now_store['store_id']); ?>