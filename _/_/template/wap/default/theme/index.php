<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="email=no">
	<meta name="apple-mobile-web-app-title" content="易点茶">
	<title><?php echo $config['site_name'];?></title>
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />
	<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/style.css" type="text/css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/index.css"  type="text/css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/gonggong.css"  type="text/css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/article/shopIndex.css"  type="text/css">
	<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script src="<?php echo TPL_URL;?>js/common.js"></script>
	<script async="" src="<?php echo TPL_URL;?>theme/js/index.js"></script>
	<script src="<?php echo  STATIC_URL?>js/layer_mobile/layer.m.js"></script>
	<script async="" src="<?php echo TPL_URL;?>theme/js/mobile-common.js"></script>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/common.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/index.css">
	<script src="<?php echo TPL_URL;?>pingtai/js/jquery.touchSlider.js"></script>
	<script src="<?php echo TPL_URL;?>pingtai/js/jquery.event.drag-1.5.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>pingtai/js/jquery.transform.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>pingtai/js/jquery.jplayer.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>pingtai/js/mod.csstransforms.min.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>pingtai/js/circle.player.js"></script>
	<script type="text/javascript" src="<?php echo TPL_URL;?>pingtai/js/jquery.tabs.js"></script>
	<!–[if lt IE 9]>
	<script src="<?php echo TPL_URL;?>pingtai/js/html5shiv.js"></script>
	<script src="<?php echo TPL_URL;?>pingtai/js/respond.min.js"></script>
	<![endif]–>
	<script type="text/javascript">
	$(document).ready(function () {
		$(".main_visual").hover(function(){
			$("#btn_prev,#btn_next").fadeIn()
		},function(){
			$("#btn_prev,#btn_next").fadeOut()
		})
		$dragBln = false;
		$(".main_image").touchSlider({
			flexible : true,
			speed : 200,
			btn_prev : $("#btn_prev"),
			btn_next : $("#btn_next"),
			paging : $(".flicking_con a"),
			counter : function (e) {
				$(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
			}
		});
		$(".main_image").bind("mousedown", function() {
			$dragBln = false;
		})
		$(".main_image").bind("dragstart", function() {
			$dragBln = true;
		})
		$(".main_image a").click(function() {
			if($dragBln) {
				return false;
			}
		})
		timer = setInterval(function() { $("#btn_next").click();}, 5000);
		$(".main_visual").hover(function() {
			clearInterval(timer);
		}, function() {
			timer = setInterval(function() { $("#btn_next").click();}, 5000);
		})
		$(".main_image").bind("touchstart", function() {
			clearInterval(timer);
		}).bind("touchend", function() {
			timer = setInterval(function() { $("#btn_next").click();}, 5000);
		})
	});
</script>
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
	<div class="common_header">
		<h5>e点茶微商城</h5>
		<img src="<?php echo TPL_URL;?>pingtai/images/index_search_icon.png" class="common_header_search">
		<img src="<?php echo TPL_URL;?>pingtai/images/exit_icon.png" class="common_header_back hide">
	</div>
	<div class="index_search hide">

		<input type="search" class="index_search_box" placeholder="请输入搜索关键词">
		<button type="button" class="index_search_submit"></button>

	</div>
	<div class="index_search_hot">
		<h4>热门搜索</h4>
		<ul>
			<li><a href="javascript:;" onclick="searchKeyword('福祥茶馆');">福祥茶馆</a></li>
			<li><a href="javascript:;" onclick="searchKeyword('顺兴老茶馆');">顺兴老茶馆</a></li>
			<li><a href="javascript:;" onclick="searchKeyword('老舍茶馆');">老舍茶馆</a></li>
			<li><a href="javascript:;" onclick="searchKeyword('露雨轩茶楼');">露雨轩茶楼</a></li>
			<li><a href="javascript:;" onclick="searchKeyword('泰元坊茶艺馆');">泰元坊茶艺馆</a></li>
			<li><a href="javascript:;" onclick="searchKeyword('金骏眉茶叶');">金骏眉茶叶</a></li>
			<li><a href="javascript:;" onclick="searchKeyword('龙井茶');">龙井茶</a></li>
		</ul>
	</div>
	<script >
	function searchKeyword (val) {
		var val = val?val:$.trim($(".index_search_box").val());
		if (val.length == 0) {
			return;
		} else {
			window.location.href = './category.php?keyword='+encodeURIComponent(val);
		}
	}
	$(function(){
		$('.index_search_box').keyup(function(e){
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
		$(".index_search_submit").click(function () {
			searchKeyword ();
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
	<script type="text/javascript">
	$(document).ready(function(){
		$(".common_header_search").click(function(){
			$(".index_main,.common_header_search").hide();
			$(".index_search,.common_header_back,.index_search_hot").show();
			$(".index_search_box").focus();
		})
		$(".common_header_back").click(function(){
			$(".index_main,.common_header_search").show();
			$(".index_search,.common_header_back,.index_search_hot").hide();
		})
	})
	</script>
	<!-- 首页主体 -->
	<div class="index_main">
		<!-- 轮播图部分 -->
		<div class="index_slider">
			<div class="main_visual">
				<div class="flicking_con">
					<?php
					foreach ($slide as $key => $value) {
						$i=$key+1;
						?>
						<a href="<?php echo $value['url']; ?>"><?php echo $i; ?></a>
						<?php
					}
					?>
				</div>
				<div class="main_image">
					<ul>
						<?php
						foreach ($slide as $key => $value) {
							?>

							<li><a href="<?php echo $value['url']; ?>"><img src="<?php echo $value['pic'];?>" alt="<?php echo $value['name'];?>"> </a></li>	
							<?php
						}
						?>

						<li><img src="<?php echo TPL_URL;?>pingtai/images/index_slider_01.jpg"> </li>
						<li><img src="<?php echo TPL_URL;?>pingtai/images/index_slider_01.jpg"> </li>
					</ul>
					<a href="javascript:;" id="btn_prev" ></a>
					<a href="javascript:;" id="btn_next" ></a>
				</div>
			</div>
		</div>
		<!-- 菜单部分 -->
		<div class="index_menu main">
			<ul>
				<?php

				if ($slider_nav) {
					?>
					<?php
					$is_div_end = true;
					$i = 0;
					foreach($slider_nav as $key => $value){
						$i++;
						?>
						<a href="<?php echo $value['url'];?>">
							<li class="index_menu_li">
								<img src="<?php echo $value['pic'] ?>">
								<p class="index_menu_li_p"><?php echo $value['name'] ?></p>
							</li>
						</a>

						<?php
					}
				}	
				?>


			</ul>
		</div>
		<!-- 活动部分 -->
		<?php
		if ($hot_brand_slide) {
			?>
			<div class="index_act main">
				<?php
				foreach($hot_brand_slide as $key=>$value) {
					?>
					<?php if($key==0){ ?>  <div class="index_act_l fl"><?php
				}elseif($key==1){ 
					?>  <div class="index_act_r fl">
					<?php
				}elseif($key==3){ 
					?><div class="index_act_b fl"><?php
				}
				?>
				<a href="<?php echo $value['url'] ?>">
					<div>
						<h3><?php echo $value['name'] ?></h3>
						<p><?php echo $value['description'] ?></p>
						<img src="<?php echo $value['pic'] ?>" alt="<?php echo $value['name'] ?>" />
					</div>
				</a>
				<?php if($key==0 || $key==2 || $key==4){ ?>  </div><?php
				}
				?>
				<?php
			}	
			?>	 
		</div>
		<?php
	}	
	?>	

	<?php

	if ($hot_physical) {
		?>		
		<!-- 店铺推荐部分 -->
		<div class="index_teahouse_tuijian cf">
			<a href="weidian.php">
				<div class="index_teahouse_tuijian_t">
					<h5>店铺推荐</h5>
				</div>
			</a>
			<div class="index_tuijian_con">
				<ul class="index_tuijian_list">
					<?php
					foreach($hot_physical as $key=>$value) {
						?>
						<a href="<?php echo $value['url']; ?>"><li class="cf">
							<div class="index_tuijian_l">
								<img src="/upload/<?php echo $value['logo']; ?>">
							</div>
							<div class="index_tuijian_r">
								<ul>
									<li>
										<h3><?php echo $value['name']; ?></h3>
										<?php if($value['tuan']){ ?><span class="index_tuan">团</span><?php	}	?>		
										<?php if($value['is_yuding']>0){ ?><span class="index_ding">订</span><?php	}	?>	
										<?php if($value['hui']){ ?><span class="index_hui">惠</span><?php	}	?>
									</li>
									<li>
										￥<?php echo $value['price']; ?>元/人
									</li>
									<li><?php echo $value['address'] ?></li>
									<?php if($value['tuan']){ ?>
									<li class="index_discount">
										<span class="index_tuan">团</span><?php echo $value['tuan']; ?>
									</li>
									<?php	}	?>	
									<?php if($value['hui']){ ?>
									<li class="index_discount">
										<span class="index_hui">惠</span><?php echo $value['hui']; ?>
									</li>
									<?php	}	?>
								</ul>
							</div>
						</li>
					</a>
					<?php
				}	
				?>	


			</ul>
		</div>
	</li>
</ul>
</div>
</div>
<?php
}	
?>	

</div>
</div>
<!-- 茶会精选部分 -->
<div class="index_teaparty cf">
	<a href="chahui.php">
		<div class="index_teaparty_t">
			<h5>茶会精选</h5>
		</div>
	</a>
	<div class="index_teaparty_m cf">
		<ul>
			<?php foreach($chahui as $value){ ?>
			<li>
				<div class="index_teaparty_m_img"><a href="<?php echo $value['url'];?>"><img src="../upload/<?php echo $value['images'];?>"></a> </div>
				<h5><?php echo $value['name'];?>
					<div class="index_teaparty_fuxiang"><img src="<?php echo $value['logo'];?>"></div>
				</h5>
				<div class="index_teaparty_m_label">
					<p><?php echo $value['address'];?></p>
					<p class="index_main_time"><?php echo $value['time'];?><span><?php if($value['price']>0){ echo $value['price'];}else{echo '免费';}?></span></p>
				</div>
			</li>
			<?php } ?>

		</ul>
	</div>
</div>
<!-- 选项卡部分 -->
<div class="index_near main">
	<ul class="index_near_menu">
		<li class="current">附近茶馆</li>
		<li>附近茶会</li>
		<li>附近商品</li>
	</ul>
	<div class="index_near_con main">
		<div class="index_near_con_01" data-type="default">
			<ul>
				
			</ul>
		</div>
		<div class="index_near_con_02 hide" data-type="default">
			<ul>
				
			</ul>
		</div>
		<div class="index_near_con_03 hide" data-type="default">
			<ul>
				
			</ul>
		</div>
	</div>
</div>

<div class="common_nav">
	<div class="common_nav_main ">
		<ul>
			<a href="#"> <li>
				<img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon01_cur.png">
				<p class="common_nav_cur">首页</p>
			</li></a>
			<a href="teatype.html"> <li>
				<img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon02.png">
				<p>茶品</p>
			</li></a>
			<a href="teahouse.html"> <li>
				<img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon03.png">
				<p>茶馆</p>
			</li></a>
			<a href="teaparty.html"> <li>
				<img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon04.png">
				<p>茶会</p>
			</li></a>
			<a href="home.html"> <li>
				<img src="<?php echo TPL_URL;?>pingtai/images/common_nav_main_icon05.png">
				<p>我的</p>
			</li></a>
		</ul>
	</div>
</div>
<div class="common_footer"></div>
</div>

<?php include display('public_search');?>
<?php include display('public_menu');?>
<?php echo $shareData;?>
</body>
</html>