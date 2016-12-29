<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<meta name="apple-mobile-web-app-title" content="小猪cms">
<title><?php echo $config['site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
<meta name="description" content="<?php echo $config['seo_description'];?>" />
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/swiper.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/index.css"  type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/gonggong.css"  type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/article/shopIndex.css"  type="text/css">
<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/index.js"></script>
<script src="<?php echo TPL_URL;?>theme/js/swiper.min.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-common.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-main-common.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-download-banner.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/m-performance.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/-mod-wepp-module-event-0.2.1-wepp-module-event.js,-mod-wepp-module-overlay-0.3.0-wepp-module-overlay.js,-mod-wepp-module-toast-0.3.0-wepp-module-toast.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-common-search.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/-mod-hippo-1.2.8-hippo.js,-mod-cookie-0.2.0-cookie.js,-mod-cookie-0.1.2-cookie.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-dianping-index.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/nugget-mobile.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/swipe.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/openapp.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/app-m-style.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/util-m-monitor.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/xss.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/whereami.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/iscroll.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>theme/js/example.js"></script>
<script src="http://api.map.baidu.com/api?v=1.2" type="text/javascript"></script>
<script src="<?php echo  STATIC_URL?>js/layer_mobile/layer.m.js"></script>
<style>
.clearfix {
    *zoom:1
}
.clearfix:before,.clearfix:after {
    display:table;
    content:"";
    line-height:0
}
.clearfix:after {
    clear:both
}
#scrollThis .scroller{ width:100%; border-right: 1px solid #e3e3e3;}
 #scrollThis .scroller li {
     -webkit-box-sizing: border-box; 
    box-sizing: border-box;
}
.scrollBox {
    position: relative;
    height: 200px;
    margin: 0 8px;
    padding: 0 7px;
}
 
</style>
</head>

<body>
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
		<span class="js_product_search"></span><input placeholder="输入商品名" class="search_input s-combobox-input" />
	</div>
	<a href="./my.php" class="me"></a>
	<div id="J_toast" class="toast ">你可以在这输入商品名称</div>
</header>
<script >
$(function(){
	$(".toast").fadeTo(5000,0, function () {
		$(this).hide();
	});
	$(".s-combobox-input").val("");
	$('.s-combobox-input').keyup(function(e){
		var val = $.trim($(this).val());
		if(e.keyCode == 13){
			if(val.length > 0){
				window.location.href = './category.php?keyword='+encodeURIComponent(val);
			}else{
				return;
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
			window.location.href = './category.php?keyword='+encodeURIComponent(val);
		}
	});
});

function getRTime(time, id)
{
	var d = Math.floor(time/60/60/24);
	var h = Math.floor(time/60/60%24);
	var m = Math.floor(time/60%60);
	var s = Math.floor(time%60);
	if (d > 0) {
		$("#day_" + id).html(d);
	} else {
		$("#day_" + id).next('em').remove();
		$("#day_" + id).remove();
	}
	$("#hour_" + id).html(h);
	$("#minute_" + id).html(m);
	$("#second_" + id).html(s);
	setTimeout(getRTime, 1000, time - 1, id);
}
</script>
<?php
if ($slide) {
?>
	<div class="banner">
		<div class="swiper-container s1 swiper-container-horizontal">
			<div class="swiper-wrapper">
				<?php
				foreach ($slide as $key => $value) {
					$class = '';
					if ($key == 0) {
						$class = 'swiper-slide-active';
					} else{
						$class = 'swiper-slide-next';
					}

				?>
					<div class="swiper-slide blue-slide pulse <?php echo $class ?>">
						<a href="<?php echo $value['url'] ?>">
							<img src="<?php echo $value['pic'];?>" alt="<?php echo $value['name'];?>" />
						</a>
					</div>
				<?php
				}
				?>
			</div>
			<div class="swiper-pagination p1 swiper-pagination-clickable">
				<?php
				foreach ($slide as $key => $value) {
					$class = '';
					if ($key == 0) {
						$class = 'swiper-pagination-bullet-active';
					}
				?>
					<span class="swiper-pagination-bullet <?php echo $class ?>"></span>
				<?php
				}
				?>
			</div>
		</div>
	</div>

<?php
}
if ($slider_nav) {
?>
	<div class="index-category Fix">
		<div class="swiper-container s2 swiper-container-horizontal">
			<div class="swiper-wrapper">
				<?php
				$is_div_end = true;
				$i = 0;
				foreach($slider_nav as $key => $value){
					$class = 'swiper-slide-next';
					if ($key == 0) {
						$class = 'swiper-slide-active';
					}

					if ($key % 8 == 0) {
						$i == 0;
						$is_div_end = false;
						echo '<div class="swiper-slide blue-slide   pulse ' . $class . '" style="width: 414px;">';
						echo '	<div class="Fix page icon_list" data-index="0" style="  left: 0px; transition-duration: 300ms; -webkit-transition-duration: 300ms; -webkit-transform: translate(0px, 0px) translateZ(0px);">';
					}
					$i++;
				?>
							<a href="<?php echo $value['url'];?>" class="item" >
								<div class="icon fadeInLeft yanchi<?php echo $i ?>" style="background:url(<?php echo $value['pic'] ?>); background-size:44px 44px; background-repeat:no-repeat;"> </div>
								<?php echo $value['name'] ?>
							</a>
				<?php
					if ($key % 8 == 7) {
						echo '	</div>';
						echo '</div>';
						$is_div_end = true;
					}
				}
				if (!$is_div_end) {
					echo '	</div>';
					echo '</div>';
				}
				?>
			</div>
			<div class="swiper-pagination p2 swiper-pagination-clickable">
				<?php
				for ($i = 0; $i < ceil(count($slider_nav) / 8); $i++) {
					$class = '';
					if ($i == 0) {
						$class = 'swiper-pagination-bullet-active';
					}
				?>
				<span class="swiper-pagination-bullet <?php echo $class ?>"></span>
				<?php
				}
				?>
			</div>
		</div>

	</div>
<?php
}
// if ($newFun) {
?>
	<section class="newFun clearfix">
        <ul>
            <li>
                <a href="./activity.php?table_name=unitary">
	                <div class="d-icon">
	                    <img src="<?php echo TPL_URL;?>activity_style/images/i8.png">
	                </div>
	                <div class="desc">
	                    <h2>一元夺宝</h2>
	                    <small>新用户专享</small>
	                </div>
                </a>
            </li>
            <li>
                <a href="./activity.php?table_name=seckill">
	                <div class="d-icon">
	                    <img src="<?php echo TPL_URL;?>activity_style/images/i1.png">
	                </div>
	                <div class="desc">
	                    <h2>秒杀</h2>
	                    <small>新用户专享</small>
	                </div>
                </a>
            </li>
            <li>
                <a href="./activity.php?table_name=crowdfunding">
	                <div class="d-icon">
	                    <img src="<?php echo TPL_URL;?>activity_style/images/i2.png">
	                </div>
	                <div class="desc">
	                    <h2>众筹</h2>
	                    <small>新用户专享</small>
	                </div>
                </a>
            </li>
            <li>
                <a href="./activity.php?table_name=bargain">
	                <div class="d-icon">
	                    <img src="<?php echo TPL_URL;?>activity_style/images/i3.png">
	                </div>
	                <div class="desc">
	                    <h2>砍价</h2>
	                    <small>新用户专享</small>
	                </div>
                </a>
            </li>
            <li>
                <a href="./activity.php?table_name=cutprice">
	                <div class="d-icon">
	                    <img src="<?php echo TPL_URL;?>activity_style/images/i5.png">
	                </div>
	                <div class="desc">
	                    <h2>降价拍</h2>
	                    <small>新用户专享</small>
	                </div>
                </a>
            </li>
            <li>
                <a href="./activity.php?table_name=lottery">
	                <div class="d-icon">
	                    <img src="<?php echo TPL_URL;?>activity_style/images/i4.png">
	                </div>
	                <div class="desc">
	                    <h2>抽奖专场</h2>
	                    <small>新用户专享</small>
	                </div>
                </a>
            </li>
        </ul>
    </section>
<?php
// }
if ($slideFun=true) {
?>
	<script type="text/javascript">
	 /*   var myScroll;
	    function loaded () {
	        myScroll = new IScroll('#scrollThis', { scrollX: true, scrollY: false, mouseWheel: true, 	preventDefault: false});
	    }
	    window.onload=function(){
	        var li=$("#scrollThis .scroller li");
	        var liW=li.width()+20;
	        var liLen=li.length;
	        $("#scrollThis .scroller").width(liW*liLen);
	        loaded();
	    }*/
	</script>
	<section class="scrollGoods">
        <h2>今日活动</h2>
        <div class="scrollBox">
            <div id="scrollThis">
                <div class="scroller swiper-container s3 swiper-container-horizontal" style="">
                	<ul class="swiper-wrapper clearfix">
						<?php echo $html; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>


<!--店铺动态-->
<?php if($articles){?>
<div class="shopIndex  swiper-container s4 swiper-container-horizontal">
    <div class="title"><span>店铺动态</span><span><a href="javascript:;" onclick="getmore(this)" aid="<?php echo $articles[0]['article_info']['id']?>" id="a_get_more">查看更多</a><i></i></span></div>
    <ul class="swiper-wrapper" id="shop_article">
    	<?php foreach($articles as $article){?>
        <li class="swiper-slide swiper-slide-active" style="width: 355px; margin-right: 10px;" aid="<?php echo $article['article_info']['id']?>" store_id="<?php echo $article['store_id']?>">
            <div class="shopInfo clearfix">
	                <div class="shopImg">
	                	<a href="/wap/good.php?id=<?php echo $article['product_id']?>&platform=1"><img src="<?php echo getAttachmentUrl($products[$article['product_id']]['image'])?>" width=84 height=84></a>
	                </div>
	                <div class="shopTxt">
	                    <h2><?php echo $stores[$article['store_id']]['name']?></h2>
	                    <p><?php echo getHumanTime(time()-$article['article_info']['dateline']).'前'?></p>
	                </div>
	                <button onclick="collections(this)" aid=<?php echo $article['article_info']['id']?>  store_id=<?php echo $article['store_id']?>>
	                <i <?php if($article['iscollect']){echo 'class="active"';}?>></i><span><?php echo $article['collect_count']?><span></button>
            </div>
            <ul class="shopList">
                <li class="">
                	<p><?php echo $article['article_info']['desc']?></p>
                    <ul class="clearfix ">
                    <?php $images = explode(',',$article['article_info']['pictures']);?>
                    <?php foreach($images as $k => $img){?>
                    	<?php if($k<=2){?>
                        	<li><img src="<?php echo getAttachmentUrl($img);?>" width=110 height=110></li>
                        <?php }?>
                    <?php }?>
                    </ul>
                </li>
            </ul>
        </li>
        <?php }?>
    </ul>
    <ul class="shopSpot swiper-pagination p4 swiper-pagination-clickable">
		<?php
		for ($i = 0; $i < count($articles) / 1; $i++) {
			$class = '';
			if ($i == 0) {
				$class = 'swiper-pagination-bullet-active';
			}
		?>
		<span class="swiper-pagination-bullet <?php echo $class ?>"></span>
		<?php
		}
		?>
    </ul>
</div>
<?php }?>










<?php
}
if ($hot_brand_slide) {
?>
	<div class="index-event">
		<div class="bord"></div>
		<div class="cnt">
			<?php
			foreach($hot_brand_slide as $key=>$value) {
			?>
				<a class="item" href="<?php echo $value['url'] ?>">
					<img src="<?php echo $value['pic'] ?>" alt="<?php echo $value['name'] ?>" />
				</a>
			<?php
			}
			?>
		</div>
	</div>
<?php
}
?>   		<script>
		var swiperBanner = new Swiper('.s1',{
		loop: false,
		autoplay: 3000,
		pagination: '.p1',
		paginationClickable: true
		});
		var swiperCategory = new Swiper('.s2',{
		loop: false,
		autoplay:6500,
		pagination: '.p2',
		paginationClickable: true
	  });
	  var swiperActivity = new Swiper('.s3', {
        slidesPerView: 2.5,
        paginationClickable: true,
        spaceBetween: 13,
        freeMode: true
    }); 
		</script>
<div class="bord"></div>
<div class="index-rec J_reclist">
	<?php
	if ($cat) {
	?>
		<div class="home-tuan-list" id="home-tuan-list">
			<div class="market-floor" id="J_MarketFloor">
				<h3 class="modules-title"> 热门分类 </h3>
				<div class="modules-content market-list">
					<?php
					$is_ul_end = true;
					foreach($cat as $key => $value) {
						if ($key % 2 == 0) {
							$is_ul_end = false;
							echo '<ul class="mui-flex">';
						}
					?>
							<li class="region-block cell">
								<a href="./category.php?keyword=<?php echo $value['cat_name'] ?>&id=<?php echo $value['cat_id'] ?>">
									<em class="main-title"><?php echo $value['cat_name'] ?></em>
									<span class="sub-title"> </span>
									<img class="market-pic" src="<?php echo $value['cat_pic'] ?>" width="50" height="50">
								</a>
							</li>
					<?php
						if ($key % 2 == 1) {
							echo '</ul>';
							$is_ul_end = true;
						}
					}
					if (!$is_ul_end) {
						echo '</ul>';
					}
					?>
				</div>
			</div>
		</div>
	<?php
	}
	?>
	<div class="bord"></div>
	<div class=" title_list">
	<!--
		<ul class="title_tab">
			<li class="nar_shop product_on">附近店铺</li>
			<li class="nar_activity">附近活动</li>
			<li class="nar_product">附近商品</li>
		</ul>
		-->
        <ul class="title_tab" id="example-one" >
            <li class="nar_shop product_on current_page_item" style="width:<?php echo $is_have_activity == '1' ? '33%' : '50%' ?>"><a href="javascript:;">附近店铺</a></li>
            <li class="nar_activity" style="display:<?php echo $is_have_activity == '1' ? 'block' : 'none;' ?>"><a href="javascript:;"> 附近活动</a> </li>
            <li class="nar_product" style="width:<?php echo $is_have_activity == '1' ? '33%' : '50%' ?>"><a href="javascript:;">附近商品</a></li>
        </ul>

	</div>
	<ul class="product_list js-near-content">
		<li class="pro_shop" style="display:block;">
			<div class="home-tuan-list js-store-list" data-type="default">
				<?php
				if ($brand) {
					foreach ($brand as $key => $value) {
					if ($key >= 4) {
						break;
					}
				?>
						<a href="<?php echo $value['url'] ?>&platform=1" class="item Fix">
							<div class="cnt" style="height:auto;"> <img class="pic" src="<?php echo $value['logo'] ?>" style="width:90px;height:90px;">
								<div class="wrap">
									<div class="wrap2">
										<div class="content">
											<div class="shopname"><?php echo $value['name'] ?></div>
											<div class="title"><?php echo msubstr($value['intro'], 0 , 20,'utf-8') ?></div>
											<div class="info"><span><i></i>请设置位置</span></div>
										</div>
									</div>
								</div>
							</div>
						</a>
				<?php
					}
				}
				?>
			</div>
		</li>
		 <li class="pro_activity">
			<div class="home-tuan-list js-active-list"  data-type="default">

				<?php

				if($active_list) {
					foreach($active_list as $value) {

				?>
				<a href="<?php echo $value['wap_url']?>" class="item Fix">
				<div class="cnt"> <img class="pic" src="<?php echo $value['image'];?>">
					<div class="wrap">
						<div class="wrap2">
							<div class="content">
								<div class="shopname"><?php echo msubstr($value['name'], 0 , 12,'utf-8');?></div>
								<div class="title"><?php echo msubstr($value['intro'], 0 , 20,'utf-8');?></div>
								<div class="info"> 参与人数:<?php echo msubstr($value['count'], 0 , 20,'utf-8');?>人&#12288;<span><i></i>请设置位置</span></div>
							</div>
						</div>
					</div>
				</div>
				</a>
				<?php
					}
				}
				?>


				</div>
		</li>
		<li class="pro_product">
			<div class="home-tuan-list js-goods-list" data-type="default">
			<input type="hidden" id="is_open_margin_recharge" value="<?php echo $open_margin_recharge;?>" />
			<input type="hidden" id="platform_credit_name" value="<?php echo $platform_credit_name;?>"/>
			<input type="hidden" id="credit_platform_credit_rule" value="<?php echo option('credit.platform_credit_rule');?>"/>
				<?php
				if ($product_list) {
					foreach ($product_list as $value) {
				?>
					<a href="./good.php?id=<?php echo $value['product_id'] ?>&platform=1" class="item Fix">
						<div class="cnt" style="height:88px;"> <img class="pic" src="<?php echo $value['image'] ?>">
							<div class="wrap">
								<div class="wrap2">
									<div class="content">
										<div class="shopname"><?php echo $value['name'] ?></div>
										<div class="title"><?php echo msubstr($value['intro'], 0 , 20,'utf-8');?></div>
										<div class="info">
											<span class="symbol">¥</span>
											<span class="price"><?php echo $value['price'] ?></span>
											<del class="o-price">¥<?php $value['original_price'] = ($value['price'] >= $value['original_price'] ? $value['price'] : $value['original_price']); echo $value['original_price']; ?></del>
											<span class="sale">立减<?php echo $value['original_price'] - $value['price'] ?>元</span> <span class="distance"></span>
										</div>
										<!-- 积分显示 -->
										<?php
											$points_name = '赠送'.$platform_credit_name.'：';
											$points_price = $value['give_points'];
											if($value['open_return_point']){
												$points_price = $value['return_point'];
											}else{
												$points_price = $value['price']*option('credit.platform_credit_rule');
											}
										?>
										<?php if($open_margin_recharge){?>
										<div class="info">
											<span style="color:#f60;"><?php echo $points_name . $points_price;?></span>
										</div>
										<?php }?>
									</div>
								</div>
							</div>
						</div>
					</a>
				<?php
					}
				}
				?>
			</div>
		</li>
	</ul>
</div>
<script>
	$(function() {
	$(".nar_shop").click(function() {
		aaa('pro_activity', 'pro_product', 'pro_shop');
		$(this).addClass("product_on").siblings().removeClass("product_on")
	});
	$(".nar_activity").click(function() {
		aaa('pro_product', 'pro_shop', 'pro_activity');
		$(this).addClass("product_on").siblings().removeClass("product_on")
	});
	 $(".nar_product").click(function() {
		aaa('pro_activity', 'pro_shop', 'pro_product');
		$(this).addClass("product_on").siblings().removeClass("product_on")
	});


	function aaa(sClass1, sClass2, sClass3) {
		$('.' + sClass1).hide();
		$('.' + sClass2).hide();
		$('.' + sClass3).show();
	}

	var swiperShopNotice = new Swiper('.s4', {
        pagination: '.p4',
        paginationClickable: true,
        spaceBetween: 10,
        onSlideChangeEnd: function(){
        	var aid = $('#shop_article').children('li[class*="swiper-slide-active"]').attr('aid');
			$('#a_get_more').attr('aid',aid);
        }
    });

});

// 添加/删除收藏
function collections(obj){
	var aid = $(obj).attr('aid');
	var store_id = $(obj).attr('store_id');
	$.post('/wap/article.php?action=collect',{'aid':aid,'store_id':store_id},function(response){
		if(response.err_code>0){
			layer.open({title:["系统提示","background-color:#FF6600;color:#fff;"],content: response.err_msg});
			return;
		}
		var isactive = $(obj).find("i").hasClass('active');
		var collect_count = parseInt($(obj).find('span').text());
		if(isactive){
			$(obj).find("i").removeClass('active');
			$(obj).find('span').text(collect_count-1);
		}else{
			$(obj).find("i").addClass("active");
			$(obj).find('span').text(collect_count+1);
		}
	},'json');
}

// 查看更多
function getmore(obj){
	var aid = $(obj).attr("aid");
    var target = "/wap/article.php?action=index&aid="+aid;
    window.location.href=target;
}
</script>
<br /><br /><br />
<?php include display('public_search');?>
<?php include display('public_menu');?>
<?php echo $shareData;?>
</body>
</html>