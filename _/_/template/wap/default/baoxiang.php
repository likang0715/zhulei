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
	<title><?php echo $meal['name'];?></title>
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
	var create_fans_supplier_store_url="<?php echo $config['site_url'] ?>/wap/create_fans_supplier_store.php";
	</script>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/tables.css" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/comment.css" />
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>css/fancybox.css"/>
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
	var storeId=<?php echo $now_store['store_id'];?>,
	cz_id=<?php echo $meal['cz_id'];?>,
	showBuy=<?php echo $meal['status'];?>
	</script>
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
	<script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>
	<script src="<?php echo TPL_URL;?>js/base.js?time=<?php echo time()?>"></script>
	<script src="<?php echo TPL_URL;?>js/tables.js"></script>
	<style>
	body,.container{background: #eaeaea;}
	</style>
</head>

<body <?php if($is_mobile){ ?> class="body-fixed-bottom" <?php } ?>>
	<div class="container">
		<div class="header">
			<?php 
			if (!$is_mobile && $_SESSION['user'] && $meal['uid'] == $_SESSION['user']['uid']) {
				?>
				<!-- '$meal['uid']'没有 -->
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
							<a href="<?php dourl('user:goods:edit',array('id'=>$meal['cz_id']),true);?>" class="js-no-follow">重新编辑</a>
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
				<div class="js-image-swiper custom-image-swiper custom-goods-swiper">
					<div class="swiper-container" style="width:100%;">
						<div class="swiper-wrapper" style="width:100%;">
							<?php 
							$images=explode(',',$meal['images']);
							foreach ($images as $value) {
								?>
								<div class="swiper-slide" style="width:100%;">
									<a class="js-no-follow" href="javascript:;" style="width:100%;"> <img src="<?php echo $value;?>" /></a>
								</div>
								<?php 
							}
							?>
						</div>
					</div>
					<div class="swiper-pagination">
						<?php 
						$images=explode(',',$meal['images']);
						if (count($images) > 1) {
							for ($i = 0; $i < count($images); $i++) {
								?>
								<span class="swiper-pagination-switch <?php if ($i == 0) { ?>swiper-active-switch<?php } ?>"></span>
								<?php 
							}
						}
						?>
					</div>
				</div>

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
				<?php if ($meal['sale']) { ?>
				<div class="proInfo">
					<div class="infoSale"><i>优惠政策：</i><span class="infoSale-text"><?php echo $meal['sale']?></span></div>
				</div>
				<?php } ?>
				<div class="proInfo">
					<div class="infoTop" style="padding-bottom:0;">
						<h2 style="height: 30px;line-height: 30px;margin-top: 5px;"><?php echo $meal['name'];?></h2>
						<div class="btns">
							<?php if ($is_collect) { ?>
							<a href="javascript:void(0)" class="js-collect favorites on" data-table-id="<?php echo $meal['cz_id'];?>" data-store-id="<?php echo $store_id ?>"><i></i> 喜欢</a>
							<?php } else { ?>
							<a href="javascript:void(0)" class="js-collect favorites" data-table-id="<?php echo $meal['cz_id'];?>" data-store-id="<?php echo $now_store['store_id']?>"><i></i> 喜欢</a>
							<?php } ?>
						</div>
					</div>
					<div class="infoPrice">
						<div class="current-price">
							<i class="js-table-price price"><?php echo $meal['price'];?>元/小时</i> 
						</div>
						<div class="current-contain">容纳人数:<?php echo $meal['zno'];?></div>
					</div>
					
				</div>
			</div>
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
							<em class="arrow">查看分店<i></i></em>
							<span>
								<i><img src="<?php echo TPL_URL ?>images/i2.png"/></i>
								其它分店
							</span>
						</a>
					</div>
					<?php 
				}
				?>
			</div>
			<div data-product-id="<?php echo $meal['cz_id'];?>" class="section_body info_detail">
				<div class="dTab detailtab">
					<div class="hd">
						<ul>
							<li class="on xuanxiangka"><a href="javascript:;">图文详情</a></li>
							<li class="xuanxiangka"><a href="javascript:;">预约记录</a></li>
						</ul>
					</div>
					<div class="bd">
						<div class="row proDetail js-content-detail">
							<?php echo $meal['content']?>
						</div>
						<div class="row records js-content-detail" style="display: none;">
							<div class="tables-recordsLsit recordsLsit js-buy_history">
								<ul>
								<?php foreach ($meal_order as $value) {?>
									<li>
										<img src="<?php echo $value['avatar'];?>" data-time="<?php echo $value['nickname'];?>" alt="<?php echo $value['nickname'];?>" />
									</li>
								<?php }	?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if(!empty($storeNav)){ echo $storeNav;}?>
		<?php 
		if ($pageHasAd && $pageAdPosition == 1 && $pageAdFieldCon) {
			echo $pageAdFieldCon;
		}
		?>
		<?php include display('footer');?>
		<div class="dFooter">
			<ul class="js-bottom-opts">
				<?php
				if ($meal['status']==2) {
					?>
					<li class="no-Order"><a href="javascript:;"> 不可预约 </a></li>
					<?php
				} else if ($meal['status'] == 1) {
					?>
					<li class="yes-Order" style="background: #F15A0C;"><a href="./diancha.php?id=<?php echo $now_store['store_id']?>&fid=<?php echo $meal['physical_id'];?>&bid=<?php echo $meal['cz_id'];?>">立即预约 </a></li>
					<?php 
				}
				?>
			</ul>
		</div>
	</div>

	<script type="text/javascript">
	var jsCollectLock = false;
	$(".js-collect").click(function(){
		var self = $(this);
		var table_id = self.attr("data-table-id");
		var store_id = self.attr("data-store-id");
		if (self.hasClass("on")) {		// 取消喜欢
			var url = "collect.php?action=cancel&store_id=" + store_id + "&id=" + table_id+"&type=4";
		} else {						// 喜欢
			var url = "collect.php?action=add&store_id=" + store_id + "&id=" + table_id+"&type=4";
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
	</script>
<?php echo $shareData;?>
</body>
</html>
<?php Analytics($now_store['store_id'], 'goods', $nowProduct['name'], $_GET['id']); ?>