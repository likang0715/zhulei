<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title>开团列表-<?php echo $config['site_name'];?></title>
<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
<meta name="description" content="<?php echo $config['seo_description'] ?>" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet" />
<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css" />
<link href="<?php echo TPL_URL;?>css/category_style.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/animate.css" />
<link href=" " type="text/css" rel="stylesheet" id="sc" />
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/jquery.lazyload.min.js"></script>
<script src="<?php echo TPL_URL;?>js/jquery.nav.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/provice_city.js"></script>
<script src="<?php echo TPL_URL;?>js/category.js"></script>
<script src="<?php echo TPL_URL;?>js/distance.js"></script>

<script src="template/index/default/js/index2.js"></script>
<!--[if lt IE 9]>
<script src="template/index/default/js/html5shiv.min-min.v01cbd8f0.js"></script>
<![endif]-->
<!--[if IE 6]>
<script  src="template/index/default/js/DD_belatedPNG_0.0.8a.js" mce_src="template/index/default/js/DD_belatedPNG_0.0.8a.js"></script>
<script type="text/javascript">DD_belatedPNG.fix('*');</script>
<style type="text/css"> 
body{ behavior:url("csshover.htc");}
</style>
<![endif]-->
<style>
.menu_list li{height:51px;line-height:51px;}
.menu_list li.prop_show_more{height:auto}
.category .category_menu ul.menu_list li dl{overflow:hidden}
.cata_table .li_txt{float:left;}
.cata_table .li_img,.cata_table dl dd .nxz{margin-top:18px;margin-left:3px;width:14px;height:14px;background:transparent url("template/index/default/images/ico/list_03.png") repeat scroll 0 0;float:left;}
.cata_table .asc .li_img,.cata_table dl dd .xz_asc{margin-top:18px;margin-left:3px;width:14px;height:14px;background:transparent url("template/index/default/images/ico/list_04_h.png") repeat scroll 0 0;float:left;}
.cata_table .desc .li_img,.cata_table dl dd .xz_desc{margin-top:18px;margin-left:3px;width:14px;height:14px;background:transparent url("template/index/default/images/ico/list_03_h.png") repeat scroll 0 0;float:left;}
</style>
<script>
		$(function(){
			$(".cata_table .cata_table_li").hover(function(){
				$(this).find(".li_img").removeClass("xz_asc").removeClass("xz_desc");
				if($(this).hasClass("asc")) {
					$(this).find(".li_img").addClass("xz_asc");
				} else {
					$(this).find(".li_img").addClass("xz_desc");
				}
				
			},function(){
					$(this).find(".li_img").removeClass("xz_asc").removeClass("xz_desc");			
			})
			
		})
</script>
</head>

<body>
<?php include display('public:header_tuan');?>
	<div class="content category">
	<div class="category_menu">
		<div class="menu_title"> 
			<div class="filter-breadcrumb ">
				<span class="breadcrumb__item">
					<a class="filter-tag filter_tag_style filter-tag--all" href="<?php echo url('tuan:team') ?>">全部开团</a>
				</span>
				<span class="breadcrumb__crumb"></span> 
				<span class="breadcrumb__item" >
					<span class="breadcrumb_item__title filter-tag">
						<?php echo $category_first_href ?>
						<i class="tri"></i>
					</span>
					<span class="breadcrumb_item__option">
						<span class="option-list--wrap inline-block">
							<span class="option-list--inner inline-block"><a href="<?php echo url('tuan:team') ?>" class="log-mod-viewed">全部</a>
								<?php 
								if($top_cate_list) {
									foreach($top_cate_list as $v) {
								?>
									<a class="<?php if($_GET['id'] == $v['cat_id'] || $product_category['cat_fid'] == $v['cat_id']){?>current<?php } ?> log-mod-viewed" href="<?php echo url('tuan:team', array('id' => $v['cat_id'])) ?>" ><?php echo $v['cat_name']?></a>
								<?php 
									}
								}
								?>
							</span>
						</span>
					</span>
				</span>
				<?php
				if ($product_category['cat_level'] == 2) {
				?>
					<span class="breadcrumb__crumb"></span>
					<span class="breadcrumb__item">
						<div>
							<span class="breadcrumb_item__title filter-tag">
								<?php 
								if($product_category['cat_fid']){
									echo $product_category['cat_name'];
								}
								?>
								<i class="tri"></i>
							</span>
							<span class="breadcrumb_item__option">
								<span class="option-list--wrap inline-block">
									<span class="option-list--inner inline-block">
										<a href="<?php echo url('tuan:team', array('id' => $product_category['cat_fid'])) ?>" class="<?php if($product_category['cat_id'] != $_GET['id']){?>current<?php } ?> log-mod-viewed">全部</a>
										<?php foreach($s_category as $v) {?>
											<a class="<?php if($_GET['id'] == $v['cat_id']){?>current<?php } ?> log-mod-viewed" href="<?php echo url('tuan:team', array('id' => $v['cat_id'])) ?>"><?php echo $v['cat_name']?></a>
										<?php } ?>
									</span>
								</span>
							</span>
						</div>
					</span>
				<?php 
				}
				?>
			</div>
		</div>
		<div class="menu_content">
			<div class="menu_content_title"> 
				<dl>
					<dd>商品筛选</dd>
					<dd><a href="javascript:void(0)"><span>共<?php echo $count ?>个拼团</span></a></dd>
				</dl>
			</div>
			
			<?php 
			if (!empty($product_category_nav_list)) {
			?>
				<ul class="menu_list js-property-value">
					<style>
					.category .category_menu ul.menu_list li .menu-store-div dd{float: left;padding: 0 22px;font-size: 14px;color: #454545;clear:none;position:inherit}
					</style>
					<li index="0">
						<dl>
							<dt>分类：</dt>
							<dt class="menu_right">
								<div class="more"><a href="javascript:void(0)">更多<span></span></a></div>
							</dt>
							<?php 
							foreach ($product_category_nav_list as $product_catgory) {
							?>
								<dd style="position:static;top:0px;clear:none;"><a href="<?php echo url('tuan:team', array('id' => $product_catgory['cat_id'])) ?>"><?php echo $product_catgory['cat_name'] ?></a></dd>
							<?php 
							}
							?>
						</dl>
					</li>
				</ul>
			<?php 
			}
			?>
		</div>
	</div>
	<div class="cata_table content_commodity">
		<div class="cata_table content_commodity">
			<form action="index.php?c=category&a=index&">
				<dl>
					<dd class="cata_table_li <?php echo $order == 'id' ? 'cata_curnt' : '' ?>"><a data-sort="default" href="<?php echo url('tuan:team', $param_default) ?>">默认</a></dd>
					<dd class="ccc cata_table_li <?php echo $order == 'complete' ? 'cata_curnt ' . $sort : '' ?>" onclick="location.href='<?php echo url('tuan:team', $param_complete) ?>'"><div class="li_txt">达标程度</div><div class="li_img"></div></dd>
					<dd class="cata_table_li <?php echo $order == 'hot' ? 'cata_curnt ' . $sort : '' ?>" onclick="location.href='<?php echo url('tuan:team', $param_hot) ?>'"><div class="li_txt">拼团人气</div><div class="li_img"></div></dd>
					<dd class="cata_table_li <?php echo $order == 'price' ? 'cata_curnt ' . $sort : '' ?>" onclick="location.href='<?php echo url('tuan:team', $param_price) ?>'"><div class="li_txt">拼团价格</div><div class="li_img"></div></dd>
					<div class="price_btn">
						<input placeholder="￥" id="start_price" />
						<span>-</span>
						<input placeholder="￥" id="end_price" />
						<input type="button" value="确定" class="orangeBtn j_filterPriceSubmit" onclick="searchTuan()" />
					</div>
					<div class="pt-priceSelect">
						<select name="type" class="js-tuan_type">
							<option value="">
								全部
							</option>
							<option value="1" <?php echo $_GET['type'] == 1 ? 'selected="selected"' : '' ?>>
								人缘
							</option>
							<option value="2" <?php echo $_GET['type'] == 2 ? 'selected="selected"' : '' ?>>
								最优
							</option>
						</select>
					</div>
					<dt>
						<div class="cata_left"></div>
						<div class="cata_right"></div>
					</dt>
					<dt>
						<?php 
						if ($count > 0) {
						?>
							<span><?php echo $p ?></span>/<?php echo $total_pages ?>
						<?php 
						}
						?>
					</dt>
				</dl>
			</form>
			<div class="content_list">
				<ul class="content_list_ul pinTuan">
					<?php 
					foreach ($tuan_list as $tuan) {
						$width = 0;
						$width = min(100, floor($tuan['order_count'] / $tuan['tuan_number'] * 100));
					?>
						<li class="tuan" style="cursor: pointer;" data-json="{'name':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['name'])) ?>','type':'tuan_team','typename':'拼团','wx_image':'./source/qrcode.php?type=tuan_team&id=<?php echo $tuan['team_id'] ?>','cyrs':'<?php echo $tuan['order_count']?>','intro':'<?php echo htmlspecialchars(str_replace(array('"', "'"), '', $tuan['description'])) ?>'}">
							<div class="content_list_img">
								<img onload="AutoResizeImage(224,224,this)" src="<?php echo $tuan['image'] ?>" />
								<em class="typeTag <?php echo $tuan['type'] == 1 ? 'zy' : 'ry' ?>"><?php echo $tuan['type'] == 1 ? '最优' : '人缘' ?></em>
								<div class="content_list_erweima">
									<div class="content_list_erweima_img"><img class="code_img" height="159" src="./source/qrcode.php?type=tuan_team&id=<?php echo $tuan['team_id'] ?>" /></div>
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
						</li>
					<?php 
					}
					?>
				</ul>
			</div>
		</div>
	<!--分页-->
	<div style="display: block ;margin:auto" class="form mt20 page_list" id="J_form">
		<div class="pagination" id="pages">
			<?php echo $pages ?>
		</div>
		<div title="" style="display: none;" class="pagesNum"></div>
	</div>
	<!--分页--> 
</div>

<?php include display( 'public:footer');?>
<?php include display( 'public:alt_login');?>
<script type="text/javascript">
$('.breadcrumb__item').hover(function(){
	if($(this).find('.breadcrumb_item__option').html()){
		$(this).addClass('dropdown--open');
	}
},function(){
	$(this).removeClass('dropdown--open');
});

$('.category_list_img').mouseover(function(){
	$(this).find('.bmbox').css('display', 'block');
}).mouseout(function(){
	$(this).find('.bmbox').css('display', 'none');
});
var url = "<?php echo url('tuan:team', $param_current) ?>";
var search_url = "<?php echo trim(url('tuan:team', array('id' => $_GET['id'])), '&') ?>";

function searchTuan() {
	var start_price = $("#start_price").val();
	var end_price 	= $("#end_price").val();

	if(start_price == '' || end_price == ''){
		tusi('价格区间必须填写');
	}else{
		var reg1 =  /^\d+$/;
		if(start_price.match(reg1) == null) {
			tusi('开始价格请用正整数');
			return;
		}
		
		if(end_price.match(reg1) == null) {
			tusi('结束价格请用正整数');
			return;
		}
			
		if(start_price < end_price){
			var start = start_price;
			var end_price = end_price;
		}else{
			var start = end_price;
			var end_price = start_price;
		}
		
		if (start.length > 0) {
			search_url += '&price1=' + start;
		}
		
		if (end_price.length > 0) {
			search_url += '&price2=' + end_price;
		}
		
		location.href = search_url;
	}
}

function changePage(page) {
	if (page.length == 0) {
		return;
	}

	var re = /^[0-9]*[1-9][0-9]*$/;
	if (!re.test(page)) {
		alert("请填写正确的页数");
		return;
	}
	
	location.href = url + "&p=" + page;
}

$(function () {
	$("#pages a").click(function () {
		var page = $(this).attr("data-page-num");
		changePage(page);
	});
});

function jumpPage() {
	var page = $("#jump_page").val();
	changePage(page);
}

var cur_page = <?php echo $p ?>;
var tol_page = <?php echo $total_pages ?>;

if(cur_page>=tol_page){
	$('.cata_right').css('background-position','340px -82px');
	$('.cata_right').addClass("nopage");
}

if((cur_page==1)) {
	$('.cata_left').css('background-position','367px -82px')
	$('.cata_left').addClass("nopage");
}


$('.cata_right').click(function(){
	if ($(this).hasClass("nopage")) {
		return;
	}
	var page = <?php echo $p ?>;
	page++;
	changePage(page);
});

$('.cata_left').click(function(){
	if ($(this).hasClass("nopage")) {
		return;
	}
	var page = <?php echo $p ?>;
	page--;
	
	if(page <= 0) {
		return;	
	}
	changePage(page);
});

$(".js-tuan_type").change(function () {
	<?php unset($param_current['type']) ?>
	var jump_url = "<?php echo url('tuan:team', $param_current) ?>";
	var type = $(this).val();
	
	if (type.length == 0) {
		location.href = jump_url;
	} else {
		location.href = jump_url + "&type=" + type;
	}
});
</script>
</body>
</html>
