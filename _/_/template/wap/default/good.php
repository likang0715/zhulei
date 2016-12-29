<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" 	content="<?php echo $config['seo_description'];?>" />
	<meta name="HandheldFriendly" content="true" />
	<meta name="MobileOptimized" content="320" />
	<meta name="format-detection" content="telephone=no" />
	<meta http-equiv="cleartype" content="on" />
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<title><?php echo $nowProduct['name'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css?time=<?php echo time()?>" />
	<?php if($is_mobile){ ?>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css" />
		<script>var is_mobile = true;</script>
	<?php }else{ ?>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css" />
		<script>var is_mobile = false;</script>
	<?php } ?>
	<script>
		var is_logistics = <?php echo $nowProduct['wholesale_product_id'] ? ($store_original['open_logistics'] ? 'true' : 'false') : ($now_store['open_logistics'] ? 'true' : 'false') ?>;
		var is_selffetch = <?php echo $nowProduct['buyer_selffetch'] ? ($store_original['buyer_selffetch'] ? 'true' : 'false') : ($now_store['buyer_selffetch'] ? 'true' : 'false') ?>;
		var create_fans_supplier_store_url="<?php echo $config['site_url'] ?>/wap/create_fans_supplier_store.php";
		var store_online_trade = <?php echo $store_online_trade == 1 ? 'true' : 'false' ?>;
	</script>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/goods.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/drp_notice.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/coupon.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL?>css/comment.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/font/icon.css" />
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/fancybox.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css">
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
	<style type="text/css">
	#fancybox-left span {left : auto; left : 20px;}
	#fancybox-right span {left : auto; right : 20px;}

    .layer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.5);
        z-index: 9;
    }

    .layer_content {
        background: #fff;
        position: fixed;
        width: 15rem;
        left: .5rem;
        top: 50%;
        text-align: center;
        z-index: 10;
        height: 19rem;
        margin-top: -8.5rem;
    }
    .layer_content .layer_title {
        font-size: .55rem;
        color: #fff;
        line-height: .9rem;
        padding: .3rem .5rem;
        background: #45a5cf;
        text-align: left;
        text-indent: 1.2rem;
    }
    .layer_content p {
        font-size: .55rem;
        color: #333333;
        line-height: 1.4rem;
    }
    .layer_content img {
        width: 8rem;
        margin: 1rem 0;
    }
    .layer_content p span {
        font-size: .45rem;
        color: #999;
        line-height: 0.9rem;
    }

    .layer_content button {
        background: #ff9c00;
        width: 5.5rem;
        height: 1.5rem;
        color: #fff;
        line-height: 1.5rem;
        border-radius: 1.5rem;
        margin: .6rem 0;
    }

    .layer_content i {
        background: url(/template/wap/default/ucenter/images/weidian_25.png) no-repeat;
        background-size: 1rem;
        height: 1.2rem;
        width: 1.24rem;
        display: inline-block;
        vertical-align: middle;
        position: absolute;
        right: -.5rem;
        top: -.5rem;
    }
	.profit, .nickname {
		color: #26CB40;
	}

    /* ueditor 表格样式 */
    .selectTdClass{background-color:#edf5fa !important}table.noBorderTable td,table.noBorderTable th,table.noBorderTable caption{border:1px dashed #ddd !important}table{margin-bottom:10px;border-collapse:collapse;display:table;}td,th{padding: 5px 10px;border: 1px solid #DDD;}caption{border:1px dashed #DDD;border-bottom:0;padding:3px;text-align:center;}th{border-top:1px solid #BBB;background-color:#F7F7F7;}table tr.firstRow th{border-top-width:2px;}.ue-table-interlace-color-single{ background-color: #fcfcfc; } .ue-table-interlace-color-double{ background-color: #f7faff; }td p{margin:0;padding:0;}

    /* 店铺订单消息提示 */
    .orderLayer { position: fixed; left: 10px; margin-left: 0; top: 60px; line-height: 1.2rem; background: rgba(0,0,0,.4); padding: 5px; z-index: 7; width: 90%; color: #fff; font-size: .55rem; border-radius: 1.5rem; }
	.orderLayer .orderImg { display: inline-block; vertical-align: middle; overflow: hidden; }
	.orderLayer .orderImg img { vertical-align: top; width: 32px; height: 32px; border-radius: 50% }
	.orderLayer .orderInfo { display: inline-block; vertical-align: middle; margin-left: 5px; width:87% }
	.orderLayer .orderInfo i { color:#FF9E40; width: 60px; display: inline-block; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; vertical-align: middle; margin-top: -.1rem; }
	.orderLayer .orderInfo span { display:inline-block; margin-left:16px; float: right; }

	</style>
	<?php if (empty($drp_button)) { ?>
	<style type="text/css">
		#drp-notice ul .msg-li {
			margin-left: 5px;
			width: 75%;
		}
	</style>
	<?php }?>
	<script type="text/javascript">
		var is_present_product = <?php echo $is_present_product;?>,
			storeId=<?php echo $now_store['store_id'];?>,
			product_id=<?php echo $nowProduct['product_id'];?>,
			showBuy=!!<?php echo intval($_GET['buy'])?>,
			hasActivity=!!<?php echo intval($nowActivity);?>,
			activityId=<?php echo intval($nowActivity['pigcms_id']);?>,
			activityType=<?php echo intval($nowActivity['type']);?>,
			activityDiscount=<?php echo floatval($nowActivity['discount']);?>,
			activityPrice=<?php echo floatval($nowActivity['price'])?>,
			after_subscribe_discount=<?php echo $nowProduct['after_subscribe_discount'];?>;
			after_subscribe_price=<?php echo $nowProduct['after_subscribe_price'];?>;
			follow = <?php echo !empty($follow)? 1:0;?>;
	</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.waterfall.js"></script>
	<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>

	<script src="<?php echo TPL_URL;?>js/base.js?time=<?php echo time()?>"></script>
	
	<?php if($is_present_product == 1) {?>
		<script src="<?php echo TPL_URL;?>js/pointgood.js"></script>
		<script src="<?php echo TPL_URL;?>js/pointsku.js"></script>
	<?php }else {?>
		<script src="<?php echo TPL_URL;?>js/good.js"></script>
		<script src="<?php echo TPL_URL;?>js/sku.js"></script>
	<?php }?>

	<script src="<?php echo TPL_URL;?>js/drp_notice.js"></script>
	<!-- 活动模块 -->
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/weidian_files/style.css">
	<script src="<?php echo TPL_URL;?>/weidian_files/iscroll.js"></script>
	<script type="text/javascript">
		$(function () {
			$(".scroller").each(function (i) {
				var li = $(this).find("li");
				var liW = li.width() + 18;
				var liLen = li.length;
				$(this).width(liW * liLen);
				
				var class_name = $(this).parent().attr("class");
				new IScroll("." + class_name, { scrollX: true, scrollY: false, mouseWheel: false, click: true });
			});
		});
	</script>
	<!-- 活动模块-->

<style>
	body,.container{background: #eaeaea;}
</style>
</head>

<body <?php if($is_mobile){ ?> class="body-fixed-bottom" <?php } ?>>
<?php if ($store_bind['error_code'] == 0 && empty($follow) && $is_mobile) {?>
<aside>
    <div class="layer"></div>
    <div class="layer_content">
        <i class="close"></i>
        <div class="layer_title">亲，店家发现你还未关注店家的公众号，可以关注再购买宝贝哦，关注后，可享受 <?php echo $nowProduct['after_subscribe_discount'];?> 折优惠！</div>
        <div class="layer_text">
            <p>第一步：长按二维码并识别</p>
            <img src="<?php echo $store_bind['qrcode'];?>" >
            <p>第二步：打开图文进入店铺</p>
            <p>亲，进入店铺后购买宝贝即可享受<?php echo $nowProduct['after_subscribe_discount'];?>折优惠</p>
            <p><em>贴心小提示：成为店铺会员购物一直有特权哦！</em></p>
        </div>
    </div>
</aside>
<?php
}
?>
	<?php if ($allow_drp) { ?>
		<div id="drp-notice">
			<ul>
				<li class="img-li"><img class="mp-image" width="24" height="24" src="<?php echo !empty($avatar) ? $avatar : option('config.site_url') . '/static/images/avatar.png'; ?>" alt="<?php echo $now_store['name'];?>"/></li>
				<li class="msg-li"><?php echo $msg; ?></li>
				<?php if (!empty($drp_button)) { ?>
				<li class="btn-li"><a href="<?php echo $drp_register_url; ?>" class="button green"><?php echo $drp_button; ?></a></li>
				<?php } ?>
				<li class="last-li"><b class="close"></b></li>
			</ul>
		</div>
	<?php } ?>

<div class="container">
	<div class="header">
		<?php 
		if (!$is_mobile && $_SESSION['user'] && $nowProduct['uid'] == $_SESSION['user']['uid']) {
		?>
			<div class="headerbar">
				<div class="headerbar-wrap clearfix">
					<div class="headerbar-preview">
						<span>预览：</span>
						<ul>
							<li><a href="<?php echo $now_url;?>&ps=320"
								class="js-no-follow<?php if(empty($_GET['ps']) || $_GET['ps'] == '320') echo ' active';?>">iPhone版</a>
							</li>
							<li><a href="<?php echo $now_url;?>&ps=540"
								class="js-no-follow<?php if($_GET['ps'] == '540') echo ' active';?>">三星Note3版</a>
							</li>
							<?php 
							if (option('config.synthesize_store')) {
							?>
								<li><a href="<?php echo $now_url;?>&ps=800"
									class="js-no-follow<?php if($_GET['ps'] == '800') echo ' active';?>">PC版</a>
								</li>
							<?php 
							}
							?>
						</ul>
					</div>
					<div class="headerbar-reedit">
						<a href="<?php dourl('user:goods:edit',array('id'=>$nowProduct['product_id']),true);?>" class="js-no-follow">重新编辑</a>
					</div>
				</div>
			</div>
		<?php 
		}
		?>
		<!-- ▼顶部通栏 -->

		<div class="js-mp-info share-mp-info">
			<a class="page-mp-info" href="<?php echo $now_store['url'];?>">
				<img class="mp-image" width="24" height="24" src="<?php echo $now_store['logo'];?>" alt="<?php echo $now_store['name'];?>" />
				<i class="mp-nickname"><?php echo $now_store['name'];?></i>
			</a>
			<div class="links">
				<a class="mp-homepage" href="<?php echo $now_store['ucenter_url'];?>">会员中心</a>
			</div>
		</div>
		<!-- ▲顶部通栏 -->
	</div>

	<div class="content">
		<div class="content-body">
			<?php 
			if ($pageHasAd && $pageAdPosition == 0 && $pageAdFieldCon) {
				echo $pageAdFieldCon;
			}
			?>
		
			<div class="js-image-swiper custom-image-swiper custom-goods-swiper"  data-max-height="<?php echo $nowProduct['image_size']['height'];?>" data-max-width="<?php echo $nowProduct['image_size']['width'];?>">
				<div class="swiper-container" style="width:100%;">
					<div class="swiper-wrapper" style="width:100%;">
						<?php 
						foreach ($nowProduct['images'] as $value) {
						?>
							<div class="swiper-slide" style="width:100%;">
								<a class="js-no-follow" href="javascript:;" style="width:100%;"> <img src="<?php echo $value['image'];?>" /></a>
							</div>
						<?php 
						}
						?>
					</div>
				</div>
				<div class="swiper-pagination">
					<?php 
					if ($nowProduct['images_num'] > 1) {
						for ($i = 0; $i < $nowProduct['images_num']; $i++) {
					?>
						<span class="swiper-pagination-switch <?php if ($i == 0) { ?>swiper-active-switch<?php } ?>"></span>
					<?php 
						}
					}
					?>
				</div>
			</div>

			<?php if(!empty($product_activitys)) { ?>
				<div class="showTags">
					<span>已参加活动：</span>
					<?php foreach($product_activitys as $product_activity) {
						$i++;
						if($i>3){
							$i = 1;
						}
						echo '<a href="##" class='.$color[$i].'>'.$product_activity['activity_name'].'</a>';

					}
					?>
				</div>
			<?php } ?>

			<hr style="border: 1px;">

			<style type="text/css">
				.showTags{background:white;padding: 10px 0;}
				.showTags span{margin-left:5px;color:#808080;font-size:14px;}
				.showTags a{display: inline-block;border-radius: 5px;color: #fff;font-size: 12px;vertical-align: middle;padding: 5px 8px;margin-right: 5px;}
				.showTags a.red{background:#FE5842}
				.showTags a.yellow{background:#FF9333}
				.showTags a.purple{background:#F164BE}
				.proInfo .infoTop .btns .favorites {
					background: #fff;
					color: #f62a1f;
					margin-top: 5px;
				}
			</style>

			<div class="proInfo">
				<div class="infoTop">
					<h2><?php echo $nowProduct['name'] ?></h2>
					<div class="parice">
						<span>
							<?php if($nowActivity){?>
							<div class="current-price">
								<span>￥&nbsp;</span> <i class="js-goods-price price">
										<?php
									if ($nowActivity ['type'] == 1) {
										echo ($maxPrice != 0 && $minPrice != $maxPrice) ? round ( $minPrice - $nowActivity['price'], 2 ) . '-' . round ( $maxPrice - $nowActivity['price'], 2 ) : round ( $minPrice - $nowActivity['price'], 2 );
									} else {
										echo ($maxPrice != 0 && $minPrice != $maxPrice) ? round ( $minPrice * $nowActivity['discount'] / 10, 2 ) . '-' . round ( $maxPrice * $nowActivity['discount'] / 10, 2 ) : round ( $minPrice * $nowActivity['discount'] / 10, 2 );
									}
									?>
										</i> <span class="price-tag">扫码折扣价</span>
							</div>
						<div class="original-price">价格:￥<?php echo ($maxPrice!=0 && $minPrice!=$maxPrice) ? $minPrice.' - '.$maxPrice : $minPrice;?></div>
							<?php }else{ ?>
							<div class="current-price">
<!--							<span>￥&nbsp;</span><i class="js-goods-price price" style="border: 4px solid red">--><?php //echo ($maxPrice!=0 && $minPrice!=$maxPrice) ? $minPrice.'-'.$maxPrice : $minPrice;?><!--</i>-->
								<?php if($nowProduct['after_subscribe_discount'] >= 1) { ?>
								<span>￥&nbsp;</span><i class="js-goods-price price"><?php echo number_format(($nowProduct['after_subscribe_discount']/10)*$nowProduct['price'], 2 , '.', ''); ?></i><span class="price-tag">关注后价格</span>
								<?php }else{ ?>
								<?php if($is_present_product) {?>
								
								<span><span class="point_ico"></span>&nbsp;</span><i class="js-goods-price price"><?php echo $nowProduct['price']?></i>
								<?php }else {?>
								<span>￥&nbsp;</span><i class="js-goods-price price"><?php echo $nowProduct['price']?></i>
								<!-- 增加商品原价显示 -->
								<?php
								if($nowProduct['original_price'] >0){
									?>
									<div class="original-price">￥<?php echo $nowProduct['original_price']?></div>
									<?php
								}
								?>
								
								
								<?php }?>
								
								
								
								<?php } ?>

						</div>
							<?php if($nowProduct['after_subscribe_discount'] >= 1){ ?>
										<div class="original-price">原价:￥<?php echo $nowProduct['price'];?></div>
							<?php
								}
							}
							?>
						</span>
					</div>
					<div class="btns">
						<?php if (!empty($drp_button)) { ?>
						<a href="<?php echo $drp_register_url ?>" style="<?php echo !$allow_drp ? 'display: none;' : '' ?>"><?php echo $drp_button; ?></a>
						<?php } ?>
						<?php if ($is_collect) { ?>
							<a href="javascript:void(0)" class="js-collect favorites on" data-product_id="<?php echo $product_id ?>" data-store_id="<?php echo $store_id ?>"><i></i> 喜欢</a>
						<?php } else { ?>
							<a href="javascript:void(0)" class="js-collect favorites" data-product_id="<?php echo $product_id ?>" data-store_id="<?php echo $store_id ?>"><i></i> 喜欢</a>
						<?php } ?>
					</div>
					<?php
					if ($reward) {
					?>
						<div class="manjian"><i>满减</i><?php echo $reward?></div>
					<?php 
					}
					?>
				</div>
                <!-- 20160302 -->
                <style>
                    .integral{background: #FEF2F2;padding: 15px 0px;font-size: 12px;margin-bottom: 15px}
                    .integral span:first-child{margin-right: 15px}
                    .integral i{display: inline-block;vertical-align: middle;width: 20px;height: 20px;margin-right: 5px}
                    .integral i img{width: 100%}
                </style>

                <div class="integral" style="display:<?php echo empty($nowProduct['check_give_points']) && empty($open_margin_recharge) ? 'none' : 'block'?> ">
                  <?php if($nowProduct['check_give_points']) {?>
                      <span><i><img src="<?php echo TPL_URL;?>ucenter/images/s1.png"/></i>赠送店铺积分：<?php echo $nowProduct['give_points'] ?></span>
                  <?php }?>
                  <?php if($open_margin_recharge){?>
                      <span><i><img src="<?php echo TPL_URL;?>ucenter/images/s0.png"/></i>赠送<?php echo $platform_credit_name;?>：
                          <?php if($nowProduct['open_return_point']) {?>
                              <?php echo $nowProduct['return_point'] ?>
                          <?php } else {?>
                              <?php echo $nowProduct['price']*option('credit.platform_credit_rule');?>
                          <?php }?></span>
                  <?php }?>
                </div>
                <!-- 20160302 end -->

                <div class="infoMore">
					<ul class="flex-box">
						<li>运费：￥<?php echo $nowProduct['postage_tpl'] ? $nowProduct['postage_tpl']['min'].'~'.$nowProduct['postage_tpl']['max'] : $nowProduct['postage']?></li>
						<li>&nbsp;销量：<?php echo $nowProduct['sales'];?></li>
						<?php 
						if($nowProduct['show_sku']){
						?>
							<li>&nbsp;剩余：<?php echo $nowProduct['quantity'];?>件</li>
						<?php 
						}
						?>
						<?php 
						if (!empty($nowProduct['buyer_quota'])) {
						?>
							<li data-buy-quantity="<?php echo $buy_quantity; ?>"  class="buyer-quota">&nbsp;限购:<?php echo $nowProduct['buyer_quota'] ?>件</li>
						<?php 
						}
						?>
						
					</ul>
				</div>
				
				<?php 
				if ($newPropertyList) {
				?>
					<div class="spec">
						<h3><em>宝贝规格</em></h3>
						<div class="specDesc">
							<?php 
							foreach ($newPropertyList as $value) {
								if (!empty($value['values'])) {
									echo $value['name'] . '：';
									$i=1;
									$count=count($value['values']);
									foreach ($value['values'] as $v) {
										echo $v['value'];
										if ($i!=$count) {
											echo '、';
										}
										$i++;
									}
								}
								echo '<br />';
							}
							?>
						</div>
					</div>
				<?php 
				}
				?>
			</div>
			<?php 
			if ($nowProduct['is_recommend'] && !empty($nowProduct['recommend_title'])) {
			?>
				<div class="recommend">
					<span> <em>掌柜推荐</em><i></i> </span>
					<?php echo htmlspecialchars($nowProduct['recommend_title']) ?>
				</div>
			<?php 
			}
			?>
			<div class="storeInfo">
				<div class="row">
					<a href="./home.php?id=<?php echo $now_store['store_id'] ?>">
						<em class="arrow">进入店铺<i></i></em>
						<span>
							<i><img src="<?php echo TPL_URL ?>images/i0.png"/></i>
							<?php echo $now_store['name'];?>
						</span>
					</a>
				</div>
				<div class="row">
					<a href="tel:<?php echo $now_store['tel'] ?>">
						<em class="arrow">立即拨打<i></i></em>
					</a>
					<span>
						<i><img src="<?php echo TPL_URL ?>images/i1.png"/></i>
						<div class="inlineBlock storeContact"
							login-status="<?php if(empty($_SESSION['wap_user'])){echo 0;}else{echo 1;}?>"
							open-url="<?php echo $imUrl;?>"
							data-tel="<?php echo $now_store['tel'] ?>"></div>
					</span>
				</div>
				<?php 
				if ($now_store['physical_count']) {
				?>
					<div class="row">
						<a href="<?php echo $now_store['physical_url'];?>">
							<em class="arrow">查看门店<i></i></em>
							<span>
								<i><img src="<?php echo TPL_URL ?>images/i2.png"/></i>
								线下门店
							</span>
						</a>
					</div>
				<?php 
				}
				?>
				<div class="aptitude">
					<ul>
						<?php 
						if ($now_store['approve'] == '1') {
						?>
							<li><i></i>认证店铺</li>
						<?php 
						}
						if ($now_store['wxpay'] == '0') {
						?>
							<li><i></i>担保交易</li>
						<?php 
						}
						if ($now_store['physical_count']) {
						?>
							<li><i></i>线下门店</li>
						<?php 
						}
						?>
						<li><i></i>无条件退换</li>
					</ul>
				</div>
			</div>
			<?php 
			if ($homeCustomField) {
			?>
				<div class="js-components-container components-container">
					<?php 
					foreach ($homeCustomField as $value) {
						echo $value['html'];
					}
					?>
				</div>
			<?php 
			}
			?>
			<div data-product-id="<?php echo $nowProduct['product_id'];?>" class="section_body info_detail">
				<div class="dTab detailtab">
					<div class="hd">
						<ul>
							<li class="on xuanxiangka"><a href="javascript:;">图文详情</a></li>
							<li class="xuanxiangka"><a href="javascript:;">成交记录</a></li>
							<li class="xuanxiangka"><a href="javascript:;">评价</a></li>
						</ul>
					</div>
					<div class="bd">
						<div class="row proDetail js-content-detail">
							<?php echo htmlspecialchars_decode($nowProduct['info']);?>
						</div>
						<div class="row records js-content-detail" style="display: none;">
							<div class="recordsLsit js-buy_history" data-type="default" data-page="1" next="true">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<th scope="col">时间</th>
										<th scope="col">件数</th>
										<th scope="col">用户名称</th>
									</tr>
									<tbody class="js-buy_history_list">
									</tbody>
									<tr>
										<td colspan="3" class="noData"></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="row rank js-content-detail" style="display: none;">
							<div class="dTab rankTab">
								<div class="hd">
									<ul class="js-comment-tab">
										<li class="on" data-tab="0">
											<p>好评</p>
											<em>(<?php echo $comment_data['t3'] + 0 ?>)</em>
										</li>
										<li data-tab="1">
											<p>中评</p>
											<em>(<?php echo $comment_data['t2'] + 0 ?>)</em>
										</li>
										<li data-tab="2">
											<p>差评</p>
											<em>(<?php echo $comment_data['t1'] + 0 ?>)</em>
										</li>
										<li data-tab="3">
											<p>有图</p>
											<em>(<?php echo $comment_data['t4'] + 0 ?>)</em>
										</li>
									</ul>
								</div>
								<div class="bd" id="list_comments">
									<div class="row" >
										<ul class="list_comments on" id="list_comments_0" data-page="1" <?php echo $comment_data['t3'] > 0 ? 'data-type="default" next="true"' : 'data-type="value" next="false"' ?>">
											<?php 
											if ($comment_data['t3'] < 1) {
											?>
												<li><div class="noData" style="display: block;">已无更多评价！</div></li>
											<?php 
											}
											?>
										</ul>
										<ul class="list_comments" id="list_comments_1" data-page="1" style="display: none;" <?php echo $comment_data['t2'] > 0 ? 'data-type="default" next="true"' : 'data-type="value" next="false"' ?>">
											<?php 
											if ($comment_data['t2'] < 1) {
											?>
												<li><div class="noData" style="display: block;">已无更多评价！</div></li>
											<?php 
											}
											?>
										</ul>
										<ul class="list_comments" id="list_comments_2"  data-page="1" style="display: none;" <?php echo $comment_data['t1'] > 0 ? 'data-type="default" next="true"' : 'data-type="value" next="false"' ?>">
											<?php 
											if ($comment_data['t2'] < 1) {
											?>
												<li><div class="noData" style="display: block;">已无更多评价！</div></li>
											<?php 
											}
											?>
										</ul>
										<ul class="list_comments" id="list_comments_3"  data-page="1" style="display: none;" <?php echo $comment_data['t4'] > 0 ? 'data-type="default" next="true"' : 'data-type="value" next="false"' ?>">
											<?php 
											if ($comment_data['t4'] < 1) {
											?>
												<li><div class="noData" style="display: block;">已无更多评价！</div></li>
											<?php 
											}
											?>
										</ul>
										<ul class="js-load-comment" style="display: none;">
											<li><div class="noData" style="display: block;">努力加载中！</div></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if(!$is_mobile){ ?>
			<div class="content-sidebar">
				<a href="<?php echo $now_store['url'];?>" class="link">
					<div class="sidebar-section shop-card">
						<div class="table-cell">
							<img src="<?php echo $now_store['logo'];?>" width="60" height="60" class="shop-img" alt="<?php echo $now_store['name'];?>" />
						</div>
						<div class="table-cell">
							<p class="shop-name"><?php echo $now_store['name'];?></p>
						</div>
					</div>
				</a>
				<div class="sidebar-section qrcode-info">
					<div class="section-detail">
						<p class="text-center shop-detail">
							<strong>手机扫码访问</strong>
						</p>
						<p class="text-center weixin-title">微信“扫一扫”分享到朋友圈</p>
						<p class="text-center qr-code">
							<img width="158" height="158" src="<?php echo $config['site_url'];?>/source/qrcode.php?type=good&id=<?php echo $nowProduct['product_id'];?>&store_id=<?php echo $now_store['store_id']; ?>">
						</p>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if(!empty($storeNav)){ echo $storeNav;}?>
		<?php 
		if ($pageHasAd && $pageAdPosition == 1 && $pageAdFieldCon) {
			echo $pageAdFieldCon;
		}
		?>
	</div>
	<?php include display('footer');?>
	<div class="dFooter">
		<ul class="js-bottom-opts">
			<?php
			if ($constraint_sold_out) {
			?>
				<li><a href="javascript:" class="noBuy"><i></i> 暂停出售 </a></li>
			<?php
			} else if ($nowProduct['quantity'] <= 0) {
			?>
				<li><a href="javascript:" class="noBuy"><i></i> 商品已售罄 </a></li>
			<?php 
			} else if ($buyer_quota) {
			?>
				<li><a href="javascript:" class="noBuy"><i></i>限购，您已购买<?php echo $buy_quantity; ?>件</a></li>
			<?php 
			} else {
			?>
				<li class="ziji"><a href="javascript:" class="js-buy-it"><i></i>自己买</a></li>
				<?php 
				if ($now_store['pay_agent']) {
				?>
					<li class="zhaoren"><a href="javascript:" class="js-peerpay"><i></i>找人送</a></li>
				<?php 
				}
				if (($nowProduct['wholesale_product_id'] > 0 && $product_original['send_other'] && $store_original['open_logistics'] && $store_original['open_friend']) || ($nowProduct['wholesale_product_id'] == 0 && $nowProduct['send_other'] && $now_store['open_logistics'] && $now_store['open_friend'])) {
				?>
					<li class="song"><a href="javascript:" class="js-send_other"><i></i>送他人 </a></li>
				<?php 
				}
				if (empty($nowActivity)) {
				?>
					<li style="background: #F15A0C;"><a href="javascript:" class="js-add-cart"><i></i><font style="color: #F9F9F9;">加入购物车</font></a></li>
				<?php 
				}
				?>
			<?php 
			}
			?>
		</ul>
	</div>
	<?php if($config['is_show_float_menu'] && $now_store['is_show_float_menu']) {?>
	<div class="wx_aside" id="quckArea"> <a href="javascript:void(0);" id="quckIco2" class="btn_more">更多</a>
		<div class="wx_aside_item" id="quckMenu"> <a href="./index.php" class="item_index">首页</a> <a href="./category.php" class="item_fav">商品分类</a> <a href="./weidian.php" class="item_cart">微店列表</a> <a href="./my.php" class="item_uc">个人中心</a> </div>
	</div>
	<?php } ?>
</div>

<!-- 店铺订单消息通知 -->
<script type="text/javascript" src="<?php echo TPL_URL; ?>js/store_notice.js"></script>
<?php if ($is_mobile && $now_store['order_notice_open']) { ?>
<script type="text/javascript">
$(function(){
	$('body').shopNotice({storeId:"<?php echo $store_id; ?>",fadeoutTime:"<?php echo $now_store['order_notice_time']; ?>"});
});
</script>
<?php } ?>

<?php 
if (!$is_mobile) {
?>
	<div class="popover popover-goods js-popover-goods">
		<div class="popover-inner">
			<h4 class="title clearfix">
				<span class="icon-weixin pull-left"></span>手机启动微信<br>扫一扫购买aaa
			</h4>
			<div class="js-async ui-goods-qrcode">
				<img src="<?php echo $config['site_url'];?>/source/qrcode.php?type=good&id=<?php echo $nowProduct['product_id'];?>&store_id=<?php echo $now_store['store_id']; ?>" alt="二维码" class="qrcode-img" />
			</div>
		</div>
	</div>
	<script>
	$(function(){
		$('.js-qrcode-buy').hover(function(){
			$('.js-popover-goods').css({'left':$(this).offset().left+$(this).width()+50+'px','top':$(this).offset().top-100+'px'}).show();
		},function(){
			$('.js-popover-goods').hide();
		});
		
	
	});
	</script>
<?php 
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		var mousex = 0, mousey = 0;
		var divLeft = 0, divTop = 0, left = 0, top = 0;
		document.getElementById("enter_im_div").addEventListener('touchstart', function(e){
			//e.preventDefault();
			var offset = $(this).offset();
			divLeft = parseInt(offset.left,10);
			divTop = parseInt(offset.top,10);
			mousey = e.touches[0].pageY;
			mousex = e.touches[0].pageX;
			return false;
		});
		document.getElementById("enter_im_div").addEventListener('touchmove', function(event){
			event.preventDefault();
			left = event.touches[0].pageX-(mousex-divLeft);
			top = event.touches[0].pageY-(mousey-divTop)-$(window).scrollTop();
			if(top < 1){
				top = 1;
			}
			if(top > $(window).height()-(50+$(this).height())){
				top = $(window).height()-(50+$(this).height());
			}
			if(left + $(this).width() > $(window).width()-5){
				left = $(window).width()-$(this).width()-5;
			}
			if(left < 1){
				left = 1;
			}
			$(this).css({'top':top + 'px', 'left':left + 'px', 'position':'fixed'});
			//return false;
		});
	});

	$('.goods_guanzhu').click(function(){
		var url = "collect.php?action=attention&id=" + <?php echo $_GET['id']+0; ?> + "&type=1&store_id="+<?php echo $_GET['store_id'] ? $_GET['store_id'] : $nowProduct['store_id'] ?>;
		var number = parseInt($(this).find("span").html());
		$.get(url,function(data){
			motify.log(data.msg);
			if(data.status){
				$('.goods_guanzhu').find("span").html(number + 1);
			}
		},'json');
	});

	$('.goods_shoucang').click(function(){
		var url = "collect.php?action=add&id=" + <?php echo $_GET['id']+0; ?> + "&type=1&store_id="+<?php echo $_GET['store_id'] ? $_GET['store_id'] : $nowProduct['store_id'] ?>;
		var number = parseInt($(this).find("span").html());
		$.get(url,function(data){
			motify.log(data.msg);
			if(data.status){
				$('.goods_shoucang').find("span").html(number + 1);
			}
		},'json');
	}); 

	var jsCollectLock = false;
	$(".js-collect").click(function(){
		var self = $(this);
		var goods_id = self.attr("data-product_id");
		var store_id = self.attr("data-store_id");
		if (self.hasClass("on")) {		// 去取消喜欢
			var url = "collect.php?action=cancel&store_id=" + store_id + "&id=" + goods_id + "&type=1";
		} else {						// 喜欢
			var url = "collect.php?action=add&store_id=" + store_id + "&id=" + goods_id + "&type=1";
		}

		if (jsCollectLock) {
			return false;
		}

		jsCollectLock = true;
		$.get(url,function(data){

			if(data.status){

				if (self.hasClass("on")) {
					self.removeClass("on");
				} else {
					self.addClass("on");
				}

			} else {
				alert(data.msg);
			}

			jsCollectLock = false;
		},'json');

	});



    $(function() {
        $(".close").click(function() {
            $(".layer").fadeToggle("300");
            $(".layer_content").fadeToggle("200");
        });

        $(".product_title i").on("click", function() {
            $(".product_title_table").slideToggle(300);
            $(this).toggleClass('active');
            $(".product_title_table .active").removeClass('active');
        });


        $(".product_title_table li").click(function() {

            var txt = $(this).html();
            var txt_li = $(".product_title_list .active").html();
            $(this).html(txt_li);
            $(".product_title_list .active").html(txt)

        });

    });

</script>
<?php echo $shareData;?>
</body>
</html>
<?php Analytics($now_store['store_id'], 'goods', $nowProduct['name'], $_GET['id']); ?>