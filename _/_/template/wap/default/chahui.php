<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
<head>
	<meta charset="utf-8"/>
	<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
	<meta name="description" content="<?php echo $config['seo_description'];?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no" />
	<meta name="format-detection" content="email=no" />
	<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
	<title>茶会列表</title>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>diancha/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/gonggong.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>diancha/css/jquery-weui.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/diancha/css/event_list.css">
	<script src="<?php echo TPL_URL;?>/diancha/js/jquery-1.11.0.min.js"></script>
	<script src="<?php echo TPL_URL;?>/diancha/js/jquery-weui.js"></script>
	<script type="text/javascript">
	$(function() {
		$('.more_item .item_all').each(function() {
			var pid = $(this).attr('id');
			$(this).find('input').each(function() {
				$(this).attr('id', pid+'_'+$(this).index());
				$(this).after('<label for="'+pid+'_'+$(this).index()+'">'+$(this).attr('data-name')+'</label>');
			});
		});
		$('ul.search_menu li').click(function() {
			var i = $(this).index();
			if ($(this).hasClass('submenu_cur')) {
				$('.search_submenu .submenu_item,.body_dark').hide();
				$('.submenu_cur').removeClass('submenu_cur');
				$("body").removeClass('overHide');
			} else{
				$('.search_submenu .submenu_item').hide();
				$('.search_submenu .submenu_item').eq(i).show();
				$('.body_dark').show();
				$('.submenu_cur').removeClass('submenu_cur');
				$(this).addClass('submenu_cur');
				$("html,body").animate({scrollTop:"50"},0);
				$("body").addClass('overHide');
			};
		});
		$('.body_dark').click(function() {
			$('.search_submenu .submenu_item,.body_dark').hide();
			$('.submenu_cur').removeClass('submenu_cur');
			$("body").removeClass('overHide');
		});
	});
</script>
</head>
<body class="event_list FastClick">
	<div class="event_search" id="event_search">
		<ul class="search_menu">
			<li>
				<div class="menu_box">
					<span class="icon-nav-menu"><span></span></span>
					<span class="menu_item">主题</span>
				</div>
			</li>
			<li class="center_item inner_border">
				<div class="menu_box">
					<span class="icon-nav-menu"><span></span></span>
					<span class="menu_item">时间</span>
				</div>
			</li>
			<li class="search_more">
				<div class="menu_box">
					<span class="icon-nav-menu"><span></span></span>
					<span class="menu_item">筛选</span>
				</div>
			</li>
		</ul>
		<div class="search_submenu">
			<div class="submenu_item" style="display: none;">
				<ul>
					
					<a href="./chahui.php?id=<?php echo $store_id;?>"><li class="type_item">
						<span class="type_icon"><img src="<?php echo TPL_URL;?>/diancha/images/demo_store.jpg"></span>
						<span class="type_name">全部</span>
					</li></a>
					<?php foreach($category as $key => $r){ ?>

					<a href="./chahui.php?id=<?php echo $store_id;?>&zt=<?php echo $r['cat_id'];?>"><li class="type_item">
						<span class="type_icon"><img src="../upload/<?php echo $r['cat_pic'];?>"></span>
						<span class="type_name"><?php echo $r['cat_name'];?></span>
					</li></a>
					<?php }?>
					
				</ul>
			</div>
			<div class="submenu_item" style="display: none;">
				<ul>
					<a href="./chahui.php?id=<?php echo $store_id;?><?php if($zt){?>&zt=<?php echo $zt; }?>"><li class="type_item">
						<span class="type_en">ALL</span>
						<span class="type_name">全部</span>
					</li></a>
					<a href="./chahui.php?id=<?php echo $store_id;?>&time=week<?php if($zt){?>&zt=<?php echo $zt; }?>"><li class="type_item">
						<span class="type_en">Last week</span>
						<span class="type_name">最近一周</span>
					</li></a>
					<a href="./chahui.php?id=<?php echo $store_id;?>&time=month<?php if($zt){?>&zt=<?php echo $zt; }?>"><li class="type_item">
						<span class="type_en">Last month</span>
						<span class="type_name">最近一月</span>
					</li></a>
					<a href="./chahui.php?id=<?php echo $store_id;?>&time=today<?php if($zt){?>&zt=<?php echo $zt; }?>"><li class="type_item">
						<span class="type_en">Today</span>
						<span class="type_name">今天</span>
					</li></a>
					<a href="./chahui.php?id=<?php echo $store_id;?>&time=tomorrow<?php if($zt){?>&zt=<?php echo $zt; }?>"><li class="type_item">
						<span class="type_en">Tomorrow</span>
						<span class="type_name">明天</span>
					</li></a>
					<a href="./chahui.php?id=<?php echo $store_id;?>&time=weekend<?php if($zt){?>&zt=<?php echo $zt; }?>"><li class="type_item">
						<span class="type_en">Weekend</span>
						<span class="type_name">周末</span>
					</li></a>
				</ul>
			</div>
			<div class="submenu_item search_more">
				<form action="./chahui.php?id=<?php echo $store_id;?><?php echo $sort;?>" method="post">
					<div class="more_item">
						<h4 class="item_title">费用</h4>
						<div class="item_all" id="price">
							<input type="radio" name="price" value="0" data-name="全部">
							<input type="radio" name="price" value="1" data-name="0-199">
							<input type="radio" name="price" value="2" data-name="200-499">
							<input type="radio" name="price" value="3" data-name="500-999">
							<input type="radio" name="price" value="4" data-name="1000以上">
						</div>
					</div>
					<div class="more_item hide">
						<h4 class="item_title">特色</h4>
						<div class="item_all" id="special">
							<input type="radio" name="special" value="0" data-name="全部">
							<input type="radio" name="special" value="1" data-name="标签">
							<input type="radio" name="special" value="1" data-name="标签">
							<input type="radio" name="special" value="2" data-name="标签">
							<input type="radio" name="special" value="3" data-name="标签">
							<input type="radio" name="special" value="4" data-name="标签">
						</div>
					</div>
					<div class="more_btn">
						<input type="reset" class="reset_btn" value="重置">
						<input type="submit" class="submit_btn" value="确定">
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="event_con">
		<div class="tea_con_a"></div>
		<ul id="event_list">
			<?php foreach($list as $value){ ?>
			<a href="<?php echo $value['url'];?>">
				<li>
					<div class="event_img">
						<img src="../upload/<?php echo $value['images'];?>">
					</div>
					<h5><?php echo $value['name'];?>
						<div class="event_fuxiang"><img src="<?php echo $value['logo'];?>"></div>
					</h5>
					<div class="event_label">
						<p><?php echo $value['address'];?></p>
						<p class="event_time"><?php echo $value['time'];?><span><?php if($value['price']>0){ echo $value['price'];}else{echo '免费';}?></span></p>
					</div>
				</li>
			</a>
			<?php } ?>
		</ul>
		<div class="weui-infinite-scroll">
			<div class="infinite-preloader"></div>
			正在加载
		</div>
	</div>
	<div class="body_dark"></div>
	<script src="<?php echo TPL_URL;?>/diancha/js/fastclick.js"></script>
	<script>
	window.addEventListener('load', function () {
		var t = document.querySelectorAll('.FastClick');
		for (var i = 0; i < t.length; i++) {
			FastClick.attach(t[i]);
		};
	}, false);
	</script>
	<script>
	var loading = false;
	var endPage = false;
	var totalPage = <?php echo $total_pages? $total_pages : 1 ;?> ; //总页数
	var reedyPage = <?php echo $page;?> ; //初始页数
	var reedyUrl = "./chahui.php?id=<?php echo $store_id;?><?php echo $sort;?>&page=<?php echo $page;?>" ; //初始url
	var nowPage = <?php echo $page;?> ; //当前页数
	var baseUrl = "./chahui.php?id=<?php echo $store_id;?><?php echo $sort;?>&page=" ; //基础url
	$(document).ready(function() {
		if (totalPage==1) {
			endPage = true;
			$('.weui-infinite-scroll').remove();
			$('.event_con').append('<div class="endpage">已加载全部内容</div>');
			return false;
		};
	});
	$(document.body).infinite().on("infinite", function() {
		if(loading) return;
		if(endPage) return;
		loading = true;
		setTimeout(function() {
			ajaxData ('load');
			loading = false;
		}, 1000);
	});
	function ajaxData (action) {
		var el, li, i;
		el = $('#event_list');
		if (totalPage==nowPage) {
			endPage = true;
			return;
		};
		if (action=='refresh') {
			el.html();
			el.load(reedyUrl+' #event_list');
		} else if(action=='load'){
			if (totalPage==1) {
				endPage = true;
				$('.weui-infinite-scroll').remove();
				$('.event_con').append('<div class="endpage">已加载全部内容</div>');
				return false;
			};
			var nextPage = parseInt(nowPage)+1;
			newdiv = $('<div></div>').addClass('page_'+nextPage);
			newdiv.load(baseUrl+nextPage+' #event_list',function(html) {
				$('#event_list').append(newdiv);
				nowPage++;
				if (totalPage==nowPage) {
					endPage = true;
					$('.weui-infinite-scroll').remove();
					$('.event_con').append('<div class="endpage">已加载全部内容</div>')
				};
			});

		}
	};
	</script>
	<?php if(!empty($storeNav)){ echo $storeNav;}?>
	<?php include display('footer');?>
	<?php echo $shareData;?>
	<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>
</body>
</html>