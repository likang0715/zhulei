<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="1元夺宝，就是指只需1元就有机会获得一件商品，是基于网易邮箱平台孵化的新项目，好玩有趣，不容错过。">
	<meta name="keywords" content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵">
	<title>小猪电商夺宝 - 一个收获惊喜的网站</title>
	<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/bef6decb938119df87327e5e548e997f221af746.css">
	<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/7a056a50e1ab75b10e47a6ae1f426a513a8165be.css">
	<link rel="stylesheet" href="<?php echo STATIC_URL;?>unitary/css/ScrollPic.css">
	<script src="<?php echo STATIC_URL;?>unitary/js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?php echo STATIC_URL;?>unitary/js/jquery.ScrollPic.js" type="text/javascript"></script>
</head>
<body>
<?php include display('public:header_unitary'); ?>
<div class="g-body">
	<div module="index/Index" id="pro-view-6" module-id="module-5" module-launched="true">
		<div class="m-index">
			<div class="g-wrap g-body-hd f-clear">
				<div class="g-main">
					<div class="g-main-m">
						<div class="w-slide m-index-promot" id="pro-view-7">
							<div class="yiz-slider-3 yiz-slider" id="yiz-slider" data-yiz-slider="3">
								<ul>
								<?php foreach ($adverTop as $val) { ?>
									<li><a href="<?php echo $val['url'] ?>" target="_blank">
										<img src="<?php echo $val['pic'] ?>"/>
									</a></li>
								<?php } ?>
								</ul>
							</div>
						</div>
						<div id="newestResult" class="w-slide m-index-newReveal">
							<h4>最新揭晓</h4>
							<div class="w-slide-wrap w-slide-bottom-banner">
								<ul class="w-slide-wrap-list" pro="list">
								<?php foreach ($unitaryTopNew as $val) { ?>
									<li pro="item" class="w-slide-wrap-list-item">
										<div class="w-goods-newReveal">
											<i class="ico ico-label ico-label-newReveal" title="最新揭晓"></i>
											<p class="w-goods-title"><a href="<?php echo dourl('unitary:detail', array('id'=>$val['id'])) ?>" title="<?php echo $val['name'] ?>" target="_blank"><?php echo $val['name'] ?></a></p>
											<div class="w-goods-pic">
												<a title="<?php echo $val['name'] ?>" href="<?php echo dourl('unitary:detail', array('id'=>$val['id'])) ?>" target="_blank">
													<img width="120" height="120" class="lazyimg" data-src="<?php echo $val['logopic'] ?>" src="<?php echo STATIC_URL;?>unitary/images/s.png">
												</a>
											</div>
											<!-- <p class="w-goods-period">期号：xxxxxx</p> -->
											<p class="w-goods-period">总需：<?php echo $val['total_num'] ?>人次</p>
											<div class="w-goods-record">
												<p class="w-goods-owner f-txtabb">获得者：<a href="javascript:void(0)" title="<?php echo $val['user_name'] ?>"><b><?php echo $val['user_name'] ?></b></a></p>
												<p>本期参与：<?php echo $val['total_num'] ?>人次</p>
												<p>幸运号码：<?php echo $val['lucknum'] ?></p>
											</div>
										</div>
									</li>
								<?php } ?>
								</ul>
							</div>
							<div class="w-slide-controller w-slide-bannerbtn-bottom">
								<div class="w-slide-controller-btn w-slide-bannerbtn-bottom" pro="controllerBtn" >
									<a class="prev w-slide-bannerbtn-bottom-prev" pro="prev" href="javascript:void(0)"><i class="ico ico-arrow-large ico-arrow-large-l"></i><span class="f-txtHide">最新揭晓上一帧</span></a>
									<a class="next w-slide-bannerbtn-bottom-next" pro="next" href="javascript:void(0)"><i class="ico ico-arrow-large ico-arrow-large-r"></i><span class="f-txtHide">最新揭晓下一帧</span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="g-side">
					<div class="m-index-recommend">
					<?php if (!empty($unitaryFirst)) { ?>
						<h4>推荐商品</h4>
						<i class="ico ico-label ico-label-recommend" title="推荐夺宝"></i>
						<div class="w-goods w-goods-ing w-goods-recommend">
							<div class="w-goods-pic">
								<a href="<?php echo dourl('unitary:detail', array('id'=>$unitaryFirst['unitary']['id'])) ?>" title="<?php echo $unitaryFirst['unitary']['name'] ?>" target="_blank">
									<img width="180" height="180" alt="<?php echo $unitaryFirst['unitary']['name'] ?>" class="lazyimg" data-src="<?php echo $unitaryFirst['unitary']['logopic'] ?>" src="<?php echo STATIC_URL;?>unitary/images/l.png">
								</a>
							</div>
							<p class="w-goods-title f-txtabb">
								<a title="<?php echo $unitaryFirst['unitary']['name'] ?>" href="<?php echo dourl('unitary:detail', array('id'=>$unitaryFirst['unitary']['id'])) ?>" target="_blank"><?php echo $unitaryFirst['unitary']['name'] ?></a>
							</p>
							<p class="w-goods-price">总需：<?php echo $unitaryFirst['unitary']['total_num'] ?> 人次</p>
							<div class="w-progressBar" title="<?php echo $unitaryFirst['unitary']['proportion'] ?>%">
								<p class="w-progressBar-wrap">
									<span class="w-progressBar-bar" style="width:<?php echo $unitaryFirst['unitary']['proportion'] ?>%;"></span>
								</p>
								<p class="w-progressBar-txt">已完成<?php echo $unitaryFirst['unitary']['proportion'] ?>%，剩余<strong><?php echo $unitaryFirst['unitary']['left_count'] ?></strong></p>
							</div>
							<div class="w-goods-opr" data-id="<?php echo $unitaryFirst['unitary']['id'] ?>">
								<a class="w-button w-button-main w-button-l js-quickBuy" href="javascript:void(0)" style="width:70px;" target="_blank">立即夺宝</a>
							</div>
						</div>
					<?php } ?>
					</div>
					<div class="w-slide m-index-newGoods" id="pro-view-8">
						<i class="ico ico-label ico-label-newRecommend" title="新品推荐">
							<a style="display:block;width:100%;height:100%" href="#newArrivals"></a>
						</i>
						<div class="w-slide-wrap">
							<div class="yiz-slider-2 yiz-slider">
								<ul>
									<?php foreach ($unitaryNewRecommend as $val) { ?>
									<li>
										<a href="<?php echo dourl('unitary:detail', array('id'=>$val['unitary']['id'])) ?>"><img class="lazyimg" data-src="<?php echo $val['unitary']['logopic'] ?>" src="<?php echo STATIC_URL;?>unitary/images/l.png" /></a>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="g-wrap g-body-bd f-clear">
				<div class="g-main">
					<div class="m-index-mod m-index-goods-hotest">
						<div class="w-hd">
							<h3 class="w-hd-title">最热商品</h3>
							<a class="w-hd-more" href="<?php echo dourl('unitary:category') ?>">更多商品，点击查看&gt;&gt;</a>
						</div>
						<div class="m-index-mod-bd">
							<ul class="w-goodsList f-clear">
								<?php foreach ($unitaryHot as $val) { ?>
								<li class="w-goodsList-item row-first">
									<?php if (in_array($val['unitary']['item_price'], $area_ids)) { ?>
		                                <i class="ico ico-label " style="background: url(<?php echo $area_icons[$val['unitary']['item_price']] ?>)"></i>
		                            <?php } ?>
									<div class="w-goods w-goods-ing">
										<div class="w-goods-pic">
											<a href="<?php echo dourl('unitary:detail', array('id'=>$val['unitary']['id'])) ?>" title="<?php echo $val['unitary']['name'] ?>" target="_blank">
												<img width="200" height="200" alt="<?php echo $val['unitary']['name'] ?>" class="lazyimg" data-src="<?php echo $val['unitary']['logopic'] ?>" src="<?php echo STATIC_URL;?>unitary/images/l.png">
											</a>
										</div>
										<p class="w-goods-title f-txtabb"><a title="<?php echo $val['unitary']['name'] ?>" href="<?php echo dourl('unitary:detail', array('id'=>$val['unitary']['id'])) ?>" target="_blank"><?php echo $val['unitary']['name'] ?></a></p>
										<p class="w-goods-price">总需：<?php echo $val['unitary']['total_num'] ?> 人次</p>
										<div class="w-progressBar" title="<?php echo $val['unitary']['proportion'] ?>%">
											<p class="w-progressBar-wrap">
												<span class="w-progressBar-bar" style="width:<?php echo $val['unitary']['proportion'] ?>%;"></span>
											</p>
											<ul class="w-progressBar-txt f-clear">
												<li class="w-progressBar-txt-l">
													<p><b><?php echo $val['unitary']['pay_count'] ?></b></p>
													<p>已参与人次</p>
												</li>
												<li class="w-progressBar-txt-r">
													<p><b><?php echo $val['unitary']['left_count'] ?></b></p>
													<p>剩余人次</p>
												</li>
											</ul>
										</div>
										<p class="w-goods-progressHint">
											<b class="txt-blue"><?php echo $val['unitary']['pay_count'] ?></b>人次已参与，赶快去参加吧！剩余<b class="txt-red"><?php echo $val['unitary']['left_count'] ?></b>人次
										</p>
										<div class="w-goods-opr" data-id="<?php echo $val['unitary']['id'] ?>">
											<a class="w-button w-button-main w-button-l w-goods-quickBuy js-quickBuy" href="javascript:void(0)" title="立即夺宝">立即夺宝</a>
											<a class="w-button-addToCart js-addToCart" href="javascript:void(0)" title="添加到购物车"></a>
										</div>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="g-side">
					<div class="m-index-mod m-index-recordRank m-index-recordRank-nb">
						<div class="m-index-mod-hd">
							<h3>一元传奇</h3>
						</div>
						<div class="m-index-mod-bd">
							<ul class="w-intervalScroll">
								<?php foreach ($oneLuckDog as $key => $val) { ?>
								<li pro="item" class="w-intervalScroll-item <?php if ($key%2 == 1) { echo 'odd'; } else { echo 'even'; } ?>">
									<div class="w-record-avatar">
										<img width="40" height="40" src="<?php echo $val['avatar'] ?>">
									</div>
									<div class="w-record-detail">
										<p class="w-record-intro">
											<a class="w-record-user f-txtabb" href="javascript:void(0)" target="_blank" title="<?php echo $val['nickname'] ?>"><?php echo $val['nickname'] ?></a>
											<span class="w-record-date">于<?php echo date('m月d日', $val['addtime']) ?></span>
										</p>
										<p class="w-record-title f-txtabb"><strong>1人次</strong>夺得<a title="<?php echo $val['name'] ?>" href="<?php dourl('unitary:detail', array('id'=>$val['unitary_id'])) ?>" target="_blank"><?php echo $val['name'] ?></a></p>
										<p class="w-record-price">总需：<?php echo $val['total_num'] ?> 人次</p>
									</div>
								</li>
								<?php } ?>
							</ul>
						</div>
						<div class="m-index-mod-ft">看看谁的狗屎运最好！</div>
					</div>
				</div>
			</div>
			<div class="g-wrap g-body-ft f-clear">
				<?php foreach ($unitaryCustom as $val) { ?>
				<div class="m-index-mod m-index-goods-catlog">
					<div class="w-hd">
						<h3 class="w-hd-title"><?php echo $val['cat_name'] ?></h3>
						<a class="w-hd-more" href="<?php echo dourl('unitary:category') ?>">更多商品，点击查看&gt;&gt;</a>
					</div>
					<div class="m-index-mod-bd f-clear">
						<!-- 推荐大图位置 -->
						<div class="w-slide m-index-promotGoods">
							<div class="w-slide-wrap">
								<?php if (!empty($val['custom'])) { ?>
								<ul class="w-slide-wrap-list" pro="list">
									<li pro="item" class="w-slide-wrap-list-item">
										<a href="<?php echo dourl('unitary:detail', array('id'=>$val['custom']['id'])) ?>" target="_blank">
											<img width="239" height="400" class="lazyimg" data-src="<?php echo $val['custom']['adver_pic'] ?>" src="<?php echo STATIC_URL;?>unitary/images/l.png">
										</a>
									</li>
								</ul>
								<?php } ?>
							</div>
							<div class="w-slide-controller">
								<div class="w-slide-controller-btn" pro="controllerBtn">
									<a class="prev" pro="prev" href="javascript:void(0)"><i class="ico ico-arrow-large ico-arrow-large-l"></i></a>
									<a class="next" pro="next" href="javascript:void(0)"><i class="ico ico-arrow-large ico-arrow-large-r"></i></a>
								</div>
							</div>
						</div>
						<!-- 该推荐的其他夺宝活动 -->
						<ul class="w-goodsList">
							<?php foreach ($val['list'] as $v) { ?>
							<li class="w-goodsList-item">
								<?php if (in_array($v['item_price'], $area_ids)) { ?>
	                                <i class="ico ico-label " style="background: url(<?php echo $area_icons[$v['item_price']] ?>)"></i>
	                            <?php } ?>
								<div class="w-goods w-goods-ing">
									<div class="w-goods-pic">
										<a href="<?php echo dourl('unitary:detail', array('id'=>$v['id'])) ?>" title="<?php echo $v['name'] ?>" target="_blank">
											<img width="200" class="lazyimg" height="200" alt="<?php echo $v['name'] ?>" data-src="<?php echo $v['logopic'] ?>" src="<?php echo STATIC_URL;?>unitary/images/l.png">
										</a>
									</div>
									<p class="w-goods-title f-txtabb"><a title="<?php echo $v['name'] ?>" href="<?php echo dourl('unitary:detail', array('id'=>$v['id'])) ?>" target="_blank"><?php echo $v['name'] ?></a></p>
									<p class="w-goods-price">总需：<?php echo $v['total_num'] ?> 人次</p>
									<div class="w-progressBar" title="96.4%">
										<p class="w-progressBar-wrap">
											<span class="w-progressBar-bar" style="width:<?php echo $v['proportion'] ?>%;"></span>
										</p>
										<ul class="w-progressBar-txt f-clear">
											<li class="w-progressBar-txt-l">
												<p><b><?php echo $v['pay_count'] ?></b></p>
												<p>已参与人次</p>
											</li>
											<li class="w-progressBar-txt-r">
												<p><b><?php echo $v['left_count'] ?></b></p>
												<p>剩余人次</p>
											</li>
										</ul>
									</div>
									<p class="w-goods-progressHint">
										<b class="txt-blue"><?php echo $v['pay_count'] ?></b>人次已参与，赶快去参加吧！剩余<b class="txt-red"><?php echo $v['left_count'] ?></b>人次
									</p>
									<div class="w-goods-opr" data-id="<?php echo $v['id'] ?>">
										<a class="w-button w-button-main w-button-l w-goods-quickBuy js-quickBuy" href="javascript:void(0)" style="width:70px;" title="立即夺宝">立即夺宝</a>
										<a class="w-button-addToCart js-addToCart" href="javascript:void(0)" title="添加到购物车"></a>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<?php } ?>
				<a name="newArrivals"></a>
				<div class="m-index-mod m-index-newArrivals">
					<div class="w-hd">
						<h3 class="w-hd-title">最新上架</h3>
						<a class="w-hd-more" href="<?php echo dourl('unitary:category') ?>">更多新品，点击查看&gt;&gt;</a>
					</div>
					<div class="m-index-mod-bd">
						<ul class="w-goodsList f-clear">
							<?php foreach ($unitaryNew as $val) { ?>
							<li class="w-goodsList-item">
								<?php if (in_array($val['unitary']['item_price'], $area_ids)) { ?>
	                                <i class="ico ico-label " style="background: url(<?php echo $area_icons[$val['unitary']['item_price']] ?>)"></i>
	                            <?php } ?>
								<div class="w-goods w-goods-brief">
									<div class="w-goods-pic">
										<a href="<?php echo dourl('unitary:detail', array('id'=>$val['unitary']['id'])) ?>" title="<?php echo $val['unitary']['name'] ?>" target="_blank">
											<img width="200" class="lazyimg" height="200" alt="<?php echo $val['unitary']['name'] ?>" data-src="<?php echo $val['unitary']['logopic'] ?>" src="<?php echo STATIC_URL;?>unitary/images/l.png" style="min-height: 40px; min-width: 40px;">
										</a>
									</div>
									<p class="w-goods-title f-txtabb"><a title="<?php echo $val['unitary']['name'] ?>" href="<?php echo dourl('unitary:detail', array('id'=>$val['unitary']['id'])) ?>" target="_blank"><?php echo $val['unitary']['name'] ?></a></p>
									<p class="w-goods-price">总需：<?php echo $val['unitary']['total_num'] ?> 人次</p>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include display('public:footer_unitary'); ?>
</body>
<script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/common.js"></script>
<script type="text/javascript">
	$(function(){
		$('.yiz-slider-3').ScrollPic({
			Time: 4000,    //自动切换时间
			speed: 1000,   //图片切换速度
			autoscrooll: true, //设置是否自动切换
			arrowcontrol: true, //开启开右箭头
			numbercontrol: false //关闭右下角按钮
		});

		$('.yiz-slider-2').ScrollPic({
			Time: 4000,    //自动切换时间
			speed: 1000,   //图片切换速度
			autoscrooll: true, //设置是否自动切换
			arrowcontrol: true, //开启开右箭头
			numbercontrol: false //关闭右下角按钮
		});

		// 调用夺宝与购物
		$(".w-goods-opr").setAddCart({
	        "redirect": cart_url,
	        "addCartUrl": add_cart_url,
	    });


	    clickfiy.init($(".js-addToCart"), $(".w-miniCart"));    // 飞入效果
	    scrollnav.init($('.m-nav'), $(".m-index-newReveal"));    // 滚动效果
		imgup.init($(".w-intervalScroll"));    // 侧边框自动向上滚动效果
		$(".lazyimg").lazyLoad();

	})

	var showbanner = (function() {
		var bannershownum = 0,
				$newestResult = $("#newestResult"),
				$ul = $(".w-slide-bottom-banner ul"),
				$li = $(".w-slide-bottom-banner li");

		$ul.css({
			width : ($li.length * $li.width() + $li.length) * 2
		});

		function showanimate(obj, num) {
			$(obj).animate({
				"left" : num
			}, 500);
		}

		$newestResult.on("mouseenter",function() {
			$(".w-slide-bannerbtn-bottom").show();
		});

		$newestResult.on("mouseleave",function() {
			$(".w-slide-bannerbtn-bottom").hide();
		});


		$(".w-slide-bannerbtn-bottom-prev").on("click",function() {
			if($ul.css("left").indexOf("-") > -1) {
				if($ul.css("left").split("-")[1].split("px")[0] >= 2 * $li.width()) {
					bannershownum -= 2 * $(".w-slide-bottom-banner li").width();
					showanimate($(".w-slide-bottom-banner ul"), -bannershownum)
				}else{

				}
			}else{
				bannershownum = $li.length * $li.width();
				showanimate($(".w-slide-bottom-banner ul"), -bannershownum)
			}
		});

		$(".w-slide-bannerbtn-bottom-next").on("click",function() {
			if($ul.css("left").indexOf("-") > -1){
				if($ul.css("left").split("-")[1].split("px")[0] >= ($li.length * $li.width()) - (2 * $li.width())) {
					bannershownum = 0;
					showanimate($(".w-slide-bottom-banner ul"), bannershownum)
				}else{
					bannershownum += 2 * $(".w-slide-bottom-banner li").width();
					showanimate($(".w-slide-bottom-banner ul"), -bannershownum)
				}
			}else{
				bannershownum = 2 * $(".w-slide-bottom-banner li").width();
				showanimate($(".w-slide-bottom-banner ul"), -bannershownum)

			}
		});
	})()


	loadmouse($("#pro-view-8"))
	loadmouse($("#pro-view-7"))

	function loadmouse(obj) {
		$(obj).on("mouseleave",function() {
			$(this).find(".yiz-leftarrow").hide();
			$(this).find(".yiz-rightarrow").hide();
		});
		$(obj).on("mouseenter",function() {
			$(this).find(".yiz-leftarrow").show();
			$(this).find(".yiz-rightarrow").show();
		});
	}
</script>
</html>