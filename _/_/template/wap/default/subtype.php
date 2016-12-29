<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title><?php echo $subtype_infos['typename'] ? $subtype_infos['typename']: "专题分类";?></title>
<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
<link href="<?php echo TPL_URL;?>css/new/base.css" rel="stylesheet"  type="text/css">
<link href="<?php echo TPL_URL;?>css/new/index.css" rel="stylesheet"  type="text/css">
<link href="<?php echo TPL_URL;?>css/new/swiper.min.css" rel="stylesheet"  type="text/css">
<script  type="text/javascript"  src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script  type="text/javascript"  src="<?php echo TPL_URL;?>js/rem.js"></script>
<script  type="text/javascript"  src="<?php echo TPL_URL;?>js/swiper.min.js"></script>
<script  type="text/javascript"  src="<?php echo TPL_URL;?>js/index.js"></script>
<link  href="<?php echo TPL_URL;?>css/new/mui.min.css"  rel="stylesheet" type="text/css"/>
<?php if($is_mobile){ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css"/>
<?php }else{ ?>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css"/>
<?php } ?>
<!--App自定义的css-->
<link  href="<?php echo TPL_URL;?>css/new/app.css" rel="stylesheet" type="text/css"/>
<!--  
<script type="text/javascript" src="<?php echo TPL_URL;?>js/mui.min.js"></script> 
-->
<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
<script src="<?php echo TPL_URL;?>js/base.js"></script>
<script>var page_url = '<?php echo $page_url;?>&ajax=1';var dianzan_url = '<?php echo $dianzan_url?>'</script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/subtype.js"></script>
<style>
 menu .menu_list ul { width: 100%; height: 1.5rem; overflow: hidden; }
 
 .mui-scroll-wrapper{overflow:auto;}
  .menu ul li{width:25%;float:left;margin:0;padding:0;border:0;}
 .menu ul li .li_class{border:1px solid #d9d9d9;width:87%;display:block;
 text-align:center;
  margin: 0.3rem;
  padding: 0.38rem 0.40rem;
   border-radius: 0.15rem;
 	
 }
 .menu .menu_titel span{text-align:left}
 .menu .menu_titel span{padding:0 0.4rem}
 
 .show_list .product_show li p { padding: 10% 0.5rem 0.5rem 0.5rem;    color: #fff;    position: absolute;    bottom: 0;    line-height: 1.0rem;   text-align: center;    width: 100%;    text-overflow: ellipsis;    overflow: hidden;    white-space: nowrap;
    background: -moz-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 3%, rgba(0,0,0,0.65) 97%, rgba(0,0,0,0.65) 100%);
    background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%,rgba(0,0,0,0) 3%,rgba(0,0,0,0.65) 97%,rgba(0,0,0,0.65) 100%);
    background: linear-gradient(to bottom, rgba(0,0,0,0) 0%,rgba(0,0,0,0) 3%,rgba(0,0,0,0.65) 97%,rgba(0,0,0,0.65) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 );
}
 .show_list .product_show li{    max-height: 7.5rem;    display: block;    overflow: hidden;    text-align: center;    background: #fff;    padding: 0px;    width: 98%;    margin-top: 0px;    margin-bottom: 0.5rem;    margin-left: 1%;}
  .show_list .product_show li a {   display: block;  width: 100%;  height: 100%;  text-align: center;
}
article{margin-bottom:1.1rem}
 .mui-slider .mui-slider-group .mui-slider-item img{ vertical-align:middle;width:100%; }
 .mui-slider-progress-bar{background:#fa4345}
</style>
<script src="<?php echo TPL_URL?>js/display_subject_display.js"></script>
</head>

<body>
<div id="slider" class="mui-slider">
	<menu class=""> <span class=""><i></i></span>
		<div class="menu">
			<div class="menu_titel"><span>切换频道</span><span style="display:none;">排序或删除</span></div>
			<ul>
				<li> 礼物 </li>
				<li> 美食 </li>
				<li> 家居 </li>
			</ul>
		</div>
		<div id="sliderSegmentedControl" class="mui-slider-indicator mui-segmented-control mui-segmented-control-inverted menu_list">
			<ul class="clearfix">
				<?php foreach($subtype_info as $k=>$v) {?>
				<?php if($k==0) {?>
				<li class=" "><a class="mui-control-item" href="<?php echo option('config.wap_site_url')?>/home.php?id=<?php echo $store_id;?>">精选</a> </li>
				<?php }?>
				<li class=" "><a class="mui-control-item <?php if($sid == $v['id']) {?>mui-active<?php }?>" href="<?php echo option('config.wap_site_url')?>/subtype.php?id=<?php echo $store_id;?>&sid=<?php echo $v[id];?>"><?php echo msubstr($v['typename'],0,4,false);?></a>
				
				<?php if($sid == $v['id']) {?><div id="sliderProgressBar" class="mui-slider-progress-bar mui-col-xs-4"></div><?php }?>
				
				 </li>
				
				<?php }?>

			</ul>
		</div>
		<!--
		
		-->
	</menu>
	<div class="mui-slider-group">

		<div id="item2mobile" class="mui-slider-item mui-control-content">
			<div id="scroll2" class="mui-scroll-wrapper">
				<div class="mui-scroll">
					<article class="margin">
						<section>
							<ul class="show_list">
							   
								<li style="background:#f0eff5;border:0px;">
								
									<ul class="product_show" id="subject_show">

									</ul>
									
									<div class="wx_loading2"><i class="wx_loading_icon"></i></div>
								</li>
							</ul>
						</section>
					</article>
				</div>
			</div>
		</div>
	</div>
</div>




<script>
//* /向下滚动*/
	mui.init({
		swipeBack: false
	});
 	(function($) {
		$('.mui-scroll-wrapper').scroll({
			indicators: true //是否显示滚动条
		});
		var html2 = '<ul class="mui-table-view"><li class="mui-table-view-cell">第二个选项卡子项-1</li><li class="mui-table-view-cell">第二个选项卡子项-2</li><li class="mui-table-view-cell">第二个选项卡子项-3</li><li class="mui-table-view-cell">第二个选项卡子项-4</li><li class="mui-table-view-cell">第二个选项卡子项-5</li></ul>';
		var html3 = '<ul class="mui-table-view"><li class="mui-table-view-cell">第三个选项卡子项-1</li><li class="mui-table-view-cell">第三个选项卡子项-2</li><li class="mui-table-view-cell">第三个选项卡子项-3</li><li class="mui-table-view-cell">第三个选项卡子项-4</li><li class="mui-table-view-cell">第三个选项卡子项-5</li></ul>';
		var item2 = document.getElementById('item2mobile');
		var item3 = document.getElementById('item3mobile');
		document.getElementById('slider').addEventListener('slide', function(e) {
			if (e.detail.slideNumber === 1) {
				if (item2.querySelector('.mui-loading')) {
					setTimeout(function() {
						item2.querySelector('.mui-scroll').innerHTML = html2;
					}, 500);
				}
			} else if (e.detail.slideNumber === 2) {
				if (item3.querySelector('.mui-loading')) {
					setTimeout(function() {
						item3.querySelector('.mui-scroll').innerHTML = html3;
					}, 500);
				}
			}
		});
		var sliderSegmentedControl = document.getElementById('sliderSegmentedControl');
		$('.mui-input-group').on('change', 'input', function() {
			if (this.checked) {
				sliderSegmentedControl.className = 'mui-slider-indicator mui-segmented-control mui-segmented-control-inverted mui-segmented-control-' + this.value;
				//force repaint
				sliderProgressBar.setAttribute('style', sliderProgressBar.getAttribute('style'));
			}
		});
	})(mui);  
		</script>




<?php if(!empty($storeNav)){ echo $storeNav;}?>
</body>
</html>