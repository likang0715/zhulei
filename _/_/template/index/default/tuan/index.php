<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title><?php echo $config['site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/animate.css" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css" />
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/myindex.js"></script>
<link href=" " type="text/css" rel="stylesheet" id="sc" />
<script src="<?php echo TPL_URL;?>js/index2.js"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->
<style>
	.activi_header .activi_header_content .activi_header_bottom{
		position: relative;
	}
	.recommend .content_list_erweima{
		width: 100%;
		height: 100%;
		position: absolute;
		top: 0;
		left: 0;
		background: rgba(0,0,0,0.7);
		display: none;
		filter: alpha(opacity=50);
		filter: progid:DXImageTransform.Microsoft.gradient(startcolorstr=#7F000000, endcolorstr=#7F000000);
		overflow: hidden;
	}
	.recommend:hover .content_list_erweima{
		display: block;
	}
</style>
<script>
$(function () {
	$("#hot_prev").click(function (event) {
		event.stopPropagation();
		var slider_index = $('.component-index-slider1 .mt-slider-trigger-container li.mt-slider-current-trigger').index() - 1;
		if (slider_index < 0) {
			slider_index = $('.component-index-slider1 .mt-slider-trigger-container li').size() - 1;
		}
		$('.component-index-slider1 .content li').eq(slider_index).show().siblings().hide();
		$('.component-index-slider1 .mt-slider-trigger-container li').eq(slider_index).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');
	});

	$("#hot_next").click(function (event) {
		var slider_index = $('.component-index-slider1 .mt-slider-trigger-container li.mt-slider-current-trigger').index() + 1;
		if (slider_index == $('.component-index-slider1 .mt-slider-trigger-container li').size()) {
			slider_index = 0;
		}
		$('.component-index-slider1 .content li').eq(slider_index).show().siblings().hide();
		$('.component-index-slider1 .mt-slider-trigger-container li').eq(slider_index).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');
	});

	$("#fj_prev").click(function (event) {
		event.stopPropagation();
		var slider_index = $('.component-index-slider2 .mt-slider-trigger-container li.mt-slider-current-trigger').index() - 1;
		if (slider_index < 0) {
			slider_index = $('.component-index-slider2 .mt-slider-trigger-container li').size() - 1;
		}
		$('.component-index-slider2 .content li').eq(slider_index).show().siblings().hide();
		$('.component-index-slider2 .mt-slider-trigger-container li').eq(slider_index).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');
	});

	$("#fj_next").click(function (event) {
		var slider_index = $('.component-index-slider2 .mt-slider-trigger-container li.mt-slider-current-trigger').index() + 1;
		if (slider_index == $('.component-index-slider2 .mt-slider-trigger-container li').size()) {
			slider_index = 0;
		}
		$('.component-index-slider2 .content li').eq(slider_index).show().siblings().hide();
		$('.component-index-slider2 .mt-slider-trigger-container li').eq(slider_index).addClass('mt-slider-current-trigger').siblings().removeClass('mt-slider-current-trigger');
	});
});
</script>
</head>
<body>
<?php include display('public:header_tuan');?>

<div class="activi_header">
	<div class="activi_header_content">
		<div class="activi_header_content_left">
			<div class="content__cell content__cell--slider">
				<div class="component-index-slider">
					<div class="index-slider ui-slider log-mod-viewed">
						<div class="pre-next">
							<a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-previous sp-slide--previous"></a>
							<a style="opacity: 0.6; display: block;" href="javascript:;" hidefocus="true" class="mt-slider-next sp-slide--next"></a> 
						</div>
						<div class="head ccf">
							<ul class="trigger-container ui-slider__triggers mt-slider-trigger-container">
								<?php 
								foreach ($adver_list as $key => $adver) {
								?>
									<li class="mt-slider-trigger <?php echo $key == 0 ? 'mt-slider-current-trigger' : '' ?>"></li>
								<?php 
								}
								?>
								
								<div style="clear:both"></div>
							</ul>
						</div>
						<ul class="content">
							<?php 
							foreach ($adver_list as $key => $adver) {
							?>
								<li class="cf" style="opacity: 1; display: <?php echo $key == 0 ? 'block' : 'none' ?>;">
									<a href="<?php echo $adver['url'] ? $adver['url'] : '#' ?>"><img src="<?php echo $adver['pic'] ?>" /></a>
								</li>
							<?php 
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="activi_header_content_right ptTop">
			<div class="activi_header_top">
				<div class="activi_header_title"><span></span>今日推荐</div>
			</div>
			<div class="content_list_img activi_header_bottom clearfix">
				<?php 
				if (!empty($tuan_today_recomment)) {
				?>
					<a href="javascript:;" class="recommend tuan clearfix" data-json="{'name':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan_today_recomment['name'])) ?>','type':'tuan','typename':'拼团','wx_image':'./source/qrcode.php?type=tuan&id=<?php echo $tuan_today_recomment['tuan_id'] ?>','cyrs':'<?php echo $tuan_today_recomment['count']?>','intro':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan_today_recomment['description'])) ?>'}">
						<div class="imgDesc"><p><?php echo htmlspecialchars($tuan_today_recomment['t_name']) ?></p><span>开团量：<?php echo $tuan_today_recomment['count'] ?></span></div>
						<div class="imgThis">
							<img src="<?php echo $tuan_today_recomment['image'] ?>" />
						</div>
						<div class="content_list_erweima">
							<div class="content_list_erweima_img " style="padding-top: 15px;"><img class="code_img" height="159" src="./source/qrcode.php?type=tuan&id=<?php echo $tuan_today_recomment['tuan_id'] ?>" /></div>
						</div>
					</a>
				<?php 
				}
				?>
			</div>

			<div class="activi_header_top minFlshTit">
				<div class="activi_header_title"><span></span>新品推荐</div>
			</div>
			<div class="minFlash" id="minFlash">
				<div class="scrollBox clearfix">
					<ul class="content">
						<?php 
						foreach ($tuan_new_recomment_list as $tuan) {
						?>
							<li class="tuan" data-json="{'name':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['name'])) ?>','type':'tuan','typename':'拼团','wx_image':'./source/qrcode.php?type=tuan&id=<?php echo $tuan['tuan_id'] ?>','cyrs':'<?php echo $tuan['count']?>','intro':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['description'])) ?>'}">
								<a href="#">
									<div class="imgDesc"><p><?php echo htmlspecialchars($tuan['t_name']) ?></p><span>开团量：<?php echo $tuan['count'] ?></span></div>
									<div class="imgThis">
										<img src="<?php echo $tuan['image'] ?>" />
									</div>
								</a>
							</li>
						<?php 
						}
						?>
					</ul>
					<ol>
						<?php 
						foreach ($tuan_new_recomment_list as $key => $tuan) {
						?>
							<li <?php echo $key == 0 ? 'class="on"' : '' ?>><?php echo $key + 1 ?></li>
						<?php 
						}
						?>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	var t=null;
	var i=0;
	var li=$("#minFlash ul li");
	var l=$("#minFlash ul li").length;
	var w=$("#minFlash ul li").width();

	var oLi=$("#minFlash ol li");
	var oL=$("#minFlash ol li").length;

	function right() {
		i++;
		if (i == l) {
			i = 0
		}
	}
	function run(){
		oLi.eq(i).addClass("on").siblings().removeClass("on");
		li.eq(i).fadeIn(600).siblings().fadeOut(600).hide();
	}
	oLi.each(function(index){
		$(this).hover(function(){
			i=index;
			run();
		});
	}).eq(0).mouseover();;
	function runn(){
		right();
		run();
	}

	timer= setInterval(runn, 3000);
	$("#minFlash").hover(function(){
		clearInterval(timer);
	},function(){
		timer = setInterval(runn, 3000);
	});
});
</script>
<div class="content activity">
	<div class="content_commodity content_activity hot_activity"  >
		<div class="content_commodity_title">
			<div class="content_commodity_title_left"><a href="###">火爆拼团</a></div>
			<div class="content_commodity_title_right"><a href="###">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list_activity cur">
			<ul class="content_list_ul ptAddPb">
				<?php 
				foreach ($tuan_hot_list as $tuan) {
				?>
					<li class="tuan" data-json="{'name':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['name'])) ?>','type':'tuan','typename':'拼团','wx_image':'./source/qrcode.php?type=tuan&id=<?php echo $tuan['tuan_id'] ?>','cyrs':'<?php echo $tuan['count']?>','intro':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['description'])) ?>'}">
						<a href="javascript:;">
							<div class="content_list_img">
								<img onload="AutoResizeImage(224,224,this)" src="<?php echo $tuan['image'] ?>">
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img class="code_img" height="159" src="./source/qrcode.php?type=tuan&id=<?php echo $tuan['tuan_id'] ?>" srcs="./source/qrcode.php?type=tuan&id=<?php echo $tuan['tuan_id'] ?>" /></div>
									<div class="content_shop_name"><?php echo htmlspecialchars($tuan['name']) ?></div>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo htmlspecialchars($tuan['t_name']) ?></div>
								<div class="content_list_dec">已开团<i class="red"><?php echo $tuan['count'] ?></i></div>
							</div>
							<div class="openPt">
								最高价：<span class="now">￥<i><?php echo $tuan['config']['price'] ?></i></span><span class="odd">￥<?php echo $tuan['price'] ?></span>
							</div>
						</a>
					</li>
				<?php 
				}
				?>
			</ul>
		</div>
	</div>
	<div class="content_commodity content_activity nearby_activity"  >
		<div class="content_commodity_title">
			<div class="content_commodity_title_left"><a href="###"> 今日新单</a></div>
			<div class="content_commodity_title_right"><a href="###">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list_activity cur">
			<ul class="content_list_ul ptAddPb">
				<?php 
				foreach ($tuan_new_list as $tuan) {
				?>
					<li class="tuan" data-json="{'name':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['name'])) ?>','type':'tuan','typename':'拼团','wx_image':'./source/qrcode.php?type=tuan&id=<?php echo $tuan['tuan_id'] ?>','cyrs':'<?php echo $tuan['count']?>','intro':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['description'])) ?>'}">
						<a href="javascript:;">
							<div class="content_list_img">
								<img onload="AutoResizeImage(224,224,this)" src="<?php echo $tuan['image'] ?>">
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img class="code_img" height="159" src="./source/qrcode.php?type=tuan&id=<?php echo $tuan['tuan_id'] ?>" srcs="./source/qrcode.php?type=tuan&id=<?php echo $tuan['tuan_id'] ?>" /></div>
									<div class="content_shop_name"><?php echo htmlspecialchars($tuan['name']) ?></div>
								</div>
							</div>
							<div class="content_list_txt">
								<div class="content_shop_name"><?php echo htmlspecialchars($tuan['t_name']) ?></div>
								<div class="content_list_dec">已开团<i class="red"><?php echo $tuan['count'] ?></i></div>
							</div>
							<div class="openPt">
								最高价：<span class="now">￥<i><?php echo $tuan['config']['price'] ?></i></span><span class="odd">￥<?php echo $tuan['price'] ?></span>
							</div>
						</a>
					</li>
				<?php 
				}
				?>
			</ul>
		</div>
	</div>
	<div class="content_commodity content_activity tz_activity"  >
		<div class="content_commodity_title">
			<div class="content_commodity_title_left"><a href="###"> 今日团长</a></div>
			<div class="content_commodity_title_right"><a href="<?php echo url('tuan:team') ?>">更多&gt;&gt;</a></div>
		</div>
		<div class="content_list_activity cur">
			<div class="indexScroll">
				<div class="scrollWidth">
					<?php 
					if (!empty($tuan_team_list)) {
					?>
					<ul class="content_list_ul pinTuan">
						<?php 
						foreach ($tuan_team_list as $tuan) {
							$width = 0;
							$width = min(100, floor($tuan['order_count'] / $tuan['tuan_number'] * 100));
						?>
							<li class="tuan" data-json="{'name':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['name'])) ?>','type':'tuan_team','typename':'拼团','wx_image':'./source/qrcode.php?type=tuan_team&id=<?php echo $tuan['team_id'] ?>','cyrs':'<?php echo $tuan['order_count']?>','intro':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['description'])) ?>'}">
								<a href="javascript:;" class="">
									<div class="content_list_img">
										<img onload="AutoResizeImage(224,224,this)" src="<?php echo $tuan['image'] ?>" />
										<em class="typeTag ry"><?php echo $tuan['type'] == 1 ? '最优' : '人缘' ?></em>
										<div class="content_list_erweima">
											<div class="content_list_erweima_img"><img class="code_img" height="159" src="./source/qrcode.php?type=tuan_team&id=<?php echo $tuan['team_id'] ?>"></div>
											<div class="content_shop_name"><?php echo htmlspecialchars($tuan['name']) ?></div>
										</div>
									</div>
									<div class="content_list_txt">
										<div class="content_list_pice">￥<span><?php echo $tuan['tuan_price'] ?></span></div>
										<div class="content_shop_name"><?php echo htmlspecialchars($tuan['t_name']) ?></div>
									</div>
									<div class="rangeBox clearfix">
										<span class="count"><?php echo $tuan['order_count'] ?>/<?php echo $tuan['tuan_number'] ?></span>
										<div class="range">
											<span style="width: <?php echo $width ?>%"></span>
										</div>
									</div>
									<p class="ptName">团长:<?php echo $tuan['team_nickname'] ?></p>
								</a>
							</li>
						<?php 
						}
						?>
					</ul>
					<?php 
					} else {
					?>
						<div style="height: 80px; line-height: 80px;">暂无团长</div>
					<?php 
					}
					?>
				</div>
				<div class="scrollBtn">
					<a href="javascript:;" class="prev"></a><a href="javascript:;" class="next"></a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include display( 'public:footer');?>

<script type="text/javascript">
	$(function(){
		$(function(){
			var thisScroll=$(".indexScroll ");

			thisScroll.each(function(){
				var r=0;
				var singleLi=$(this).find("li");
				var liLen=singleLi.length;
				var liW=singleLi.outerWidth(true);
				var scrollUl=$(this).find('ul');
				scrollUl.width(liW*liLen);
				var prev=$(this).find('.prev');
				var next=$(this).find('.next');
				var li4=Math.ceil(liLen/4);
				var li4W=liW*4;

				/*if(liLen<5){
					next.hide();
					prev.hide();
				}*/
				prev.bind('click',function(){
					prevBtn();
					Scroll();
				});
				next.bind('click',function(){
					nextBtn();
					Scroll();
				});
				function nextBtn() {
					r++;
					if (r == li4) {
						r = 0
					}
				}
				function prevBtn() {
					r--;
					if (r < 0) {
						r = li4 - 1
					}
				}
				function Scroll(){
					scrollUl.stop().animate({
								'margin-left': -li4W * r + 'px'
							},
							1000);
				}
			})
		});
	});
</script>
</body>
</html>
