<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>店铺</title>
		<meta name="format-detection" content="telephone=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />
		<meta name="applicable-device" content="mobile"/>
		
		
		
		
		
		<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/common.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/teahouse.css">
	<script src="<?php echo TPL_URL;?>pingtai/js/jquery-1.7.min.js"></script>
	<script src="<?php echo TPL_URL;?>pingtai/js/jquery.raty.js"></script>
	<script type="text/javascript">
	$(function(){
		$(".nav_zonghe span").click(function(){
			$(".nav_zonghe p").slideToggle(500);
			$(".tea_con_a").toggle();
		})
		$(".nav_detail span").click(function(){
			$(".nav_detail_main").slideToggle(500);
			$(".tea_con_a").toggle();
		})
		$(".tea_con_a").click(function(){
			$(".nav_zonghe p").slideUp(500);
			$(".nav_detail_main").slideUp(500);
			$(".tea_con_a").hide();
		});
		$('#star').raty({ score: 3 }); 
		$(".reset").click(function(){
			
		})
        $(".common_header_search").click(function(){
            $(".teahouse_con").hide();
            $(".teahouse_nav").hide();
            $(".index_search").show();
            $(".common_header_search").hide();
            $(".common_header_back").show();
            $(".index_search_hot").show();
            $(".index_search_box").focus();
        })
        $(".common_header_back").click(function(){
            $(".teahouse_con").show();
            $(".teahouse_nav").show();
            $(".index_search").hide();
            $(".common_header_search").show();
            $(".common_header_back").hide();
            $(".index_search_hot").hide();
        })
    })
    </script>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/main.css"/>

		<link rel="stylesheet" href="<?php echo TPL_URL;?>index_style/css/weidian.css"/>
		<link rel="stylesheet" href="<?php echo TPL_URL;?>css/gonggong.css"/>
		<style>
		#divMyShopTags span{
			color:#ed870f;
			padding:0 10px;
			border:1px solid #ed870f;
			border-radius:10px;
			line-height:18px;
			float:right;
			margin-right:10px;
			margin-top:5px;
		}
		#divMyShopTags a{
			margin-top:5px;
		}
		</style>
		<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
		
		<script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
		<script>var keyword='<?php echo $keyword;?>',key_id='<?php echo $key_id;?>',tag_id='<?php echo $tag_id; ?>';</script>
		<script src="<?php echo TPL_URL;?>index_style/js/index_shop_detail.js"></script>
		<script>
		var sonCatStoreList = '<?php echo json_encode($son_cat_store_list);?>';
		$(function(){
			$(".toast").fadeTo(5000,0, function () {
				$(this).hide();
			});
			$(".s-combobox-input").val("");

			$('.s-combobox-input').keyup(function(e){
				var val = $.trim($(this).val());
				if(e.keyCode == 13){
					if(val.length > 0){
						window.location.href = './weidian.php?keyword='+encodeURIComponent(val);
					}else{
						motify.log('请输入搜索关键词');
					}
				}
				$('.j_PopSearchClear').show();
			});
			$(".js_product_search").click(function () {
				var val = $.trim($(".s-combobox-input").val());
				if (val.length == 0) {
					return;
				} else {
					window.location.href = './weidian.php?keyword='+encodeURIComponent(val);
				}
			});
		})
		</script>
		<script src="<?php echo TPL_URL;?>index_style/js/weidian.js?dsfdsfsd"></script>
	</head>
	<body style="padding-bottom:50px;">
	
	<div class="common_header">
		<h5>茶馆</h5>
		<img src="<?php echo TPL_URL;?>pingtai/images/index_search_icon.png" class="common_header_search">
	
	</div>
	<div class="index_search hide">
		<form action="./weidian.php" method="post">
			<input type="search" class="index_search_box" name="keyword" placeholder="请输入关键字">
			<button type="submit" class="index_search_submit"></button>
		</form>
	</div>
	<div class="index_search_hot">
	    <h4>热门搜索</h4>
	    <ul>
	        <li><a href="#">福祥茶业</a></li>
	        <li><a href="#">顺兴老茶馆</a></li>
	        <li><a href="#">老舍茶馆</a></li>
	        <li><a href="#">露雨轩茶楼</a></li>
	        <li><a href="#">泰元坊茶艺馆</a></li>
	        <li><a href="#">金骏眉茶叶</a></li>
	        <li><a href="#">龙井茶</a></li>
	    </ul>
	</div>
	<div class="teahouse_main">
		<!-- nav -->
		<div class="teahouse_nav cf">
			<ul>
				<li class="nav_zonghe">
					<span class="nav_zonghe_current">综合<i></i></span>
					<p style="display:none;">
						<a href="./weidian.php" class="nav_zonghe_current">综合</a>
						<?php foreach($category_list as $key=>$value){ ?>
					<a href="./weidian.php?cat_id=<?php echo $value['cat_id'];?>"><?php echo $value['name'];?></a>
						<?php } ?>
					
					</p>
				</li>
				<li class="nav_hot">
					<span>评分高</span>
				</li>
				<li class="nav_dis">
			<!--	<a id="aFollowShopBtn" href="javascript:;">身边的微店</a>-->
			附近茶馆	$.getJSON("./index_ajax.php?action=nearchaguan&size=100&long=" + long + "&lat=" + lat, function (data) {
					<span>距离近</span>
				</li>
				<li class="nav_detail">
					<span><i></i>筛选</span>  
					<div class="nav_detail_main" style="display:none;">
						<div class="main_money">
							<h3>门票（元）<input type="text">——<input type="text"></h3>
						</div>
						<div class="main_distance cf">
							<h3>距离</h3>
							<input type="range" min="1" max="6">
							<ul>
								<li>500m</li>
								<li>1km</li>
								<li>2km</li>
								<li>3km</li>
								<li>4km</li>
								<li>不限</li>
							</ul>
						</div>
						<div class="main_time clear cf">
							<h3>时间</h3>
							<input type="range" min="1" max="5">
							<ul>
								<li class="nav_text_left">8:30</li>
								<li class="nav_text_left">10:30</li>
								<li>14:00</li>
								<li>16:00</li>
								<li>不限</li>
							</ul>
						</div>
						<div class="main_score cf">
							<h3>评分</h3>
							<div id="star"></div>
						</div>
						<div class="main_all cf">
							<h3>全部分类</h3>
							<ul class="cf">
								<li class="all">全部</li>
								<li>节日茶会</li>
								<li>纪念茶会</li>
								<li>研讨茶会</li>
								<li>品茗茶会</li>
								<li>推广茶会</li>
								<li>联谊茶会</li>
								<li>交流茶会</li>
								<li>艺术茶会</li>	
								<li>无主题茶会</li>
								<li>节日茶会</li>
							</ul>
						</div>	  
						<h4 class="reset cf">重置</h4>
						<h4 class="ok">确定</h4>
					</div>
				</li>       
			</ul>
		</div>
		<!-- main -->
		<div class="teahouse_con cf">
			<div class="tea_con_a"></div>
			<ul>
			<?php foreach($hot_physical as $key=>$value){ ?>
				<li>
					<a href="<?php echo $value['url']; ?>" class="cf">
		            	<div class="teahouse_main_l">
		            		<img src="/upload/<?php echo $value['logo']; ?>">
		            	</div>
		            	<div class="teahouse_main_r">
		            		<h3><?php echo $value['name'];?>
							<?php if($value['tuan']){ ?><span class="index_tuan">团</span><?php	}	?>		
		            				<?php if($value['is_yuding']>0){ ?><span class="index_ding">订</span><?php	}	?>	
									<?php if($value['hui']){ ?><span class="index_hui">惠</span><?php	}	?></h3>
		            		<p class="index_price">￥<?php echo $value['price']; ?>元/人</p>
		            		<p class="index_dis"><?php echo $value['address'] ?><span></span></p>
		            	
							<?php if($value['tuan']){ ?>
								<p class="index_discount">
		            				<span class="index_tuan">团</span><?php echo $value['tuan']; ?>
		            			</p>
								<?php	}	?>	
								<?php if($value['hui']){ ?>
								<p class="index_discount">
			            			<span class="index_hui">惠</span><?php echo $value['hui']; ?>
			            	</p>
								<?php	}	?>
		            	</div>
		            </a>
				</li>
				<?php } ?>
				
			</ul>
		</div>
		<?php include display('footer');?>
		<div class="common_footer"></div>
	</div>
	<script>
	$(function(){
		$(".main_all li").click(function(){
			$(this).toggleClass("li_click");
			$(".main_all li:first-child").removeClass("all").addClass("all_qx");
		})
		$(".main_all li:first-child").click(function(){
			$(".main_all li").removeClass("li_click");
			$(".main_all li:first-child").removeClass("all_qx").addClass("all");
		})
	})
	</script>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		<header class="index-head" style="position:absolute;">
			<a class="logo" href="./index.php"><img src="<?php echo TPL_URL;?>images/danye_03.png" /></a>
            <?php if($user_location_area_name){ ?>
                <a href="./changecity.php" class="areaSelect"><?php echo $user_location_area_name;?><i></i></a>
            <?php }elseif($user_location_city_name) {?>
                <a href="./changecity.php" class="areaSelect"><?php echo $user_location_city_name;?><i></i></a>
            <?php } else {?>
                <a href="./changecity.php" class="areaSelect">全国<i></i></a>
            <?php }?>
			<div class="search J_search">
				<span class="js_product_search"></span><input placeholder="输入店铺名" class="search_input s-combobox-input" />
			</div>
			<a href="./my.php" class="me"></a>
			<div id="J_toast" class="toast ">你可以在这输入店铺名称</div>
		</header>
		<!--    <div id="J_TmMobileHeader" class="tm-mobile-header mui-flex">
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
	          	<a href="index.php" target="_self" class="category-index">???</a>
			</div>
	      </div> -->
		<div class="wx_wrap wei_v2" style="padding-top:60px;">
			<div class="wei_tab_box" id="divTabList">
				<div class="mod_fix">
					<div class="wei_tab">
						<a id="aRecommendShopBtn" class="cur" href="javascript:;">推荐微店</a>
						<a id="aFollowShopBtn" href="javascript:;">身边的微店</a>
						<?php
						if($store_tags_arr){
						?>
						<a id="aShopTagBtn" href="javascript:;">特色类目</a>
						<?php	
						}
						?>
					</div>
				</div>
			</div>
			<div id="divRecommendShop" class="wei_tab_body">
				<?php
					if(!empty($sale_category_list)){
						foreach($sale_category_list as $value){
				?>
							<section class="wei_section">
								<div class="wei_section_title">
									<h2><?php echo $value['name'];?></h2>
									<span><?php echo $value['desc'];?></span>
								</div>
								<?php if(!empty($value['cat_list'])){ ?>
									<div class="wei_tag_box">
										<?php foreach($value['cat_list'] as $cat_key=>$cat_value){ ?>
											<a href="javascript:;" data-index="<?php echo $cat_value['cat_id'];?>" <?php if($cat_key==0){ ?>class="cur"<?php } ?>><span><?php echo $cat_value['name'];?></span></a>
										<?php } ?>
									</div>
								<?php } ?>
								<div class="wei_shop_list">
									<?php
										if(!empty($value['store_list'])){
											foreach($value['store_list'] as $store_value){
									?>
												<div class="item">
													<a href="<?php echo $store_value['url'];?>" class="url">
														<div class="img">
															<img src="<?php echo $store_value['logo'];?>">
														</div>
														<div class="info">
															<div class="name"><?php echo $store_value['name'];?></div>
														</div>
													</a>
												</div>
									<?php
											}
										}else if(!empty($value['cat_list'][0]['store_list'])){
											foreach($value['cat_list'][0]['store_list'] as $store_value){
									?>
												<div class="item">
													<a href="<?php echo $store_value['url'];?>" class="url">
														<div class="img">
															<img src="<?php echo $store_value['logo'];?>">
														</div>
														<div class="info">
															<div class="name"><?php echo $store_value['name'];?></div>
														</div>
													</a>
												</div>
									<?php
											}
										}
									?>
								</div>
							</section>
				<?php
						}
					}
				?>
			</div>
			<div id="divFollowShop" class="wei_tab_body" style="display:none;">
				<section class="wei_section">
					<div class="wei_row_msg" id="divEmptyFollow">
						<div id="arroundErrorTip" style="display:none;"></div>
						<div class="btn_wrap" id="divRecommendShopBtn" style="display:none;">
							<a href="javascript:;" class="btn" ptag="37529.3.1">查看推荐微店</a>
						</div>
					</div>
					<div id="divMyShopList" style="display:none;"></div>
				</section>
			</div>

			<div id="divShopTag" class="wei_tab_body" style="display:none;">
				<section class="wei_section">
					<div id="divMyShopTags">
						<div class="wei_row_msg"></div>
						
						<?php
						foreach ($store_tags_arr as $key => $value) {
						?>

						<div class="wei_item wei_item_foc">
							<a href="javascript:;" class="wei_logo">
							<p><?php echo $value ?><span><?php echo intval($store_tags_count_arr[$key]);?></span></p>
							</a>
							<a href="weidian.php?tag_id=<?php echo $key ?>" class="btn_enter">
							去逛逛
							</a>
						</div>

						<?php
						}
						?>
						
						
					</div>
				</section>
			</div>
			


			<div class="wx_loading2 hide"><i class="wx_loading_icon"></i></div>
		</div>
	
		<?php echo $shareData;?>
	</body>
</html>