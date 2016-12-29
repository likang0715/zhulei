<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>店铺搜索</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/main.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/prop.css"/>
		
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/weidian1.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/category_detail.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/gonggong.css"/>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
		<script src="<?php echo TPL_URL;?>js/base.js"></script>
		<script>var keyword='<?php echo $keyword;?>',key_id='<?php echo $key_id;?>',tag_id='<?php echo $tag_id; ?>',noCart=true;</script>
		<script src="<?php echo TPL_URL;?>index_style/js/index_shop_detail.js"></script>
		<style>
		.wx_wrap {background: #efefef;color: #333;font-size: 12px;border-bottom: 1px solid #ddd;}
		.wei_tab { height: 40px;background: #fff;}
		.wei_tab_box {height: 40px;}
		.wei_tab {height: 40px;background: #fff;}
		.wei_tab > a {display: block; flex: 1; -ms-flex: 1; -webkit-flex: 1; box-flex: 1;-ms-box-flex: 1;webkit-box-flex: 1; }
		.wei_tab > a {text-align: center;line-height: 40px;font-size: 14px;position: relative;}	
		.wei_tab > a.cur {border-bottom: 3px solid #e4393c;color: #e4393c;}
		.wei_v2 .wei_tab a {font-size: 12px;position: relative;}
		.wei_v2 .wei_tab a.cur:after {background-position: 0px -15px;}
		.wei_v2 .wei_tab a.cur:after {content: '';width: 15px;height: 10px;position: absolute;left: 50%;margin-left: -7px;bottom: 0px;}
		.wei_v2 .wei_tab a:before {top: 10px;bottom: 10px;margin: 0;}
		.wei_tab { display: box;display: -ms-box; /* display: -webkit-box; */display: flex; display: -ms-flexbox;/* display: -webkit-flex; */}
		</style>
		<script >
		$(function(){
			$(".toast").fadeTo(5000,0, function () {
				$(this).hide();
			});
			$(".s-combobox-input").val("");

			$('.search_inputs').keyup(function(e){
				var val = $.trim($(this).val());
				if(e.keyCode == 13){
					if(val.length > 0){
						if(tag_id){
							window.location.href = './weidian.php?tag_id='+tag_id+'&keyword='+encodeURIComponent(val);
						}else{
							window.location.href = './weidian.php?keyword='+encodeURIComponent(val);
						}
						
					}else{
						motify.log('请输入搜索关键词1');
					}
				}
				$('.j_PopSearchClear').show();
			});
		})	
		</script>
	</head>
	<body>
		<!-- <div id="J_TmMobileHeader" class="tm-mobile-header mui-flex">
	        <div class="category-menu cell fixed">
	          <a href="category.php" target="_self" id="J_CategoryTrigger" class="category-trigger">????</a>
	        </div>
	        <div id="J_MobileSearch" class="mobile-search cell">
	          <form id="J_SearchForm" action="" method="post" onsubmit="return false;">
	            <div class="s-combobox-input-wrap">
	              <input placeholder="搜索商品" name="q" value="" class="search-input" type="search" accesskey="s" autocomplete="off">
	            </div>
	            <input type="submit" class="search-button">
	          </form>
	        </div>
	        <div class="my-info cell fixed">
	          <?php if(empty($wap_user)){?>
	          <a href="login.php" target="_self"  class="my-info-trigger">登录</a>
	          <?php }else{?>
	          <a href="my_cart.php" target="_self"  class="category-cart">???</a>
	          <?php }?>
	        </div>
	    </div> -->
	    <header class="index-head" style="position:absolute;">
			<a class="logo" href="./index.php"><img src="<?php echo TPL_URL;?>images/danye_03.png" /></a>
			<div class="search J_search">
				<span class="js_product_search"></span><input <?php if($keyword) {?>value='<?php echo $keyword;?>'<?php }?> placeholder="<?php if($keyword) { echo $keyword;?><?php }else{?>输入店铺名<?php }?>" class="search_input search_inputs 1s-combobox-input" />
			</div>
			<a href="./my.php" class="me"></a>
			<div id="J_toast" class="toast ">你可以在这输入店铺名称</div>
		</header>
		<div class="wx_wrap" style="padding-top:60px;">
			<div id="searchResBlock">
				<!-- <div class="wei_tab_box" id="divTabList">
				 <div class="mod_fix">
					<div class="wei_tab">
						<a id="aRecommendShopBtn" style="width:50%" class="cur" href="javascript:;">推荐微店</a>
						<a id="aFollowShopBtn" style="width:50%;flex:1"; href="javascript:;">身边的微店</a>
					</div>
				</div>
			</div>-->
				<div class="s_null hide" id="sNull01">
					<h5>抱歉，没有找到符合条件的店铺。</h5>
				</div>
				<div class="s_found hide" id="sFound">
					<p class="found_tip_2">找到相关店铺 <span id="totResult"></span> 个。</p>
				</div>
				<div class="mod_itemgrid hide" id="itemList"></div>
				<div class="wx_loading2"><i class="wx_loading_icon"></i></div>
				<div class="s_empty hide" id="noMoreTips">已无更多店铺，您可以换一个关键字搜一下哦~</div>
			</div>
		</div>
		<?php include display('public_search');?>
	    <?php include display('public_menu');?>
	    <?php echo $shareData;?>

		<div class="sidebar-content" style="-webkit-transform-origin: 0px 0px 0px; opacity: 1; -webkit-transform: scale(1, 1); display:none;">
			<div class="sidebar-header">
				<div class="sidebar-header-right">
					<span class="sidebar-btn-reset J_search_reset" report-eventid="MFilter_Reset" report-eventparam="">
						重置
					</span>
					<span class="sidebar-btn-confirm J_search_prop" report-eventid="MFilter_Confirm" report-eventparam="">
						确定
					</span>
				</div>
			</div>
			<div class="sidebar-items-container">
				<div class="spacer44"></div>
				<ul class="sidebar-list sidebar-categories">
					<?php
					if (count($property_list['property_list']) > 0) {
						foreach ($property_list['property_list'] as $property) {
					?>
							<li class="">
								<a href="javascript:void(0);">
									<i class="arrow"></i>
									<span class="sort-of-brand"><?php echo $property['name'] ?></span>
									<small class="sort-of-brand">全部</small>
								</a>
								<div style="max-height:360px; overflow-y: auto;">
									<ul id="m_searchitem_2934" class="tab-con brand" style="display:none;">
										<li id="m_searchItembutton_2935" class="">
											<i class="tick"></i>
											<span>全部</span>
										</li>
										<?php
										if (!empty($property_list['property_value_list'][$property['pid']])) {
											foreach ($property_list['property_value_list'][$property['pid']] as $property_value) {
										?>
												<li data-prop_id="<?php echo $property_value['vid'] ?>" class="">
													<i class="tick"></i>
													<span data-prop_id="<?php echo $property_value['vid'] ?>"><?php echo $property_value['value'] ?></span>
												</li>
										<?php
											}
										}
										?>
									</ul>
								</div>
							</li>
					<?php
						}
					}
					?>
				</ul>
			</div>
		</div>
	</body>
</html>