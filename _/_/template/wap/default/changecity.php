<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0035)http://dd2.pigcms.com/wap/index.php -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="format-detection" content="email=no">
<meta name="apple-mobile-web-app-title" content="小猪cms">
<title>区域选择</title>
<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
<meta name="description" content="<?php echo $config['seo_description'];?>" />
<link href="favicon.ico"  rel="icon" />
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/swiper.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/index.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/gonggong.css"  type="text/css">
<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
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
<script src="<?php echo TPL_URL;?>js/common.js"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/changecity.js?v=<?php echo time();?>"></script>
<script async="" src="<?php echo TPL_URL;?>theme/js/iscroll.js"></script>
<script1 type="text/javascript" src="<?php echo TPL_URL;?>theme/js/example.js"></script>
<link rel="stylesheet" type="text/css" href="css/bmap.css">
<style>
.hotArea ul li{padding:0px 10px;width:auto}
</style>
<script>
$(function(){

	$(".button_select_city").click(function(){
		var select_city = $("select[name='select_city']").val();
		if(!select_city) {
			
		}
	})
	

	$(".click_code").click(function(){
		var city_code = $(this).data("code");
		var city_name = $(this).html();
		if(city_code && city_name!="定位中") {
			$.post("./changecity.php?action=set_city",{"city_code":city_code,"city_name":city_name},function(obj){
				if(city_code) {
					window.location.href="./index.php";
				}
			},
			'json'
			)
		}
	})
	
	$(".button_select_city").click(function(){
		var select_city = $("select[name='select_city']").val();
		var city_name=$("select[name='select_city']").find("option[value='"+select_city+"']").html();

		if(select_city) {
			$.post("./changecity.php?action=set_city",{"city_code":select_city,"city_name":city_name},function(obj){
				if(select_city) {
					window.location.href="./index.php";
				}
			},
			'json'
			)
		}			
	})
	
	$(".select_city_by_input").live("keyup focus", function (event) {
		if ($(this).prop("readonly")) {
			return;
		}

		if ($(this).val().length > 0 && event.type == 'focusin' && $(this).attr("old-data") == $(this).val()) {
			if ($(".js-drop-dia").find("li").size() > 0) {
				$(".js-drop-dia").show();
			}
			return;
		}
		
		if ($(this).attr("old-data") == $(this).val()) {
			return;
		}

		uid = 0;
		if ($(this).val().length == 0) {
			$(".js-drop-dia").hide();
			return;
		}

		$(this).attr("old-data", $(this).val());
		//var user_search_url = "http://www.weidian.com/user.php?c=user&a=user_search";
		var select_city_url = "./changecity.php?action=select_city"
		var keyword = $(this).val();
		
		// layer.open({content: '地理位置已确认，正在跳转……',time: 200});
		$.post(select_city_url, {"keyword" : keyword}, function (result) {
		
			
			if (result.err_code == "0") {
				var html = "";
				var city_list = result.err_msg;
				for(var i in city_list) {
					html += '<li class="js_city_detail" data-code="' + city_list[i].code + '">' + city_list[i].name + '</li>';
				}
				$(".js-drop-dia").find("ul").html(html);
				$(".js-drop-dia").show();
			} else {
				$(".js-drop-dia").find("ul").html("");
				$(".js-drop-dia").hide();
			}
		})
		
		
		$(".js_city_detail").live("click",function(){
			var city_code = $(this).data("code");
			var city_name = $(this).html();
			if(city_code) {
				$.post("./changecity.php?action=set_city",{"city_code":city_code,"city_name":city_name},function(obj){
					if(city_code) {
						window.location.href="./index.php";
					}
				},
				'json'
				)
			}			
		})

	
	})
})

</script>
</head>

<body youdao="bind" cz-shortcut-listen="true">
	<div class="areaBox">
		<div class="areaInput">
			<div>
			<input placeholder="输入城市名或拼音查询" type="text" class="select_city_by_input"/>
				<div class="js-drop-dia" style="position:relative;z-index:99999; left: 0px; border: 2px solid rgb(204, 204, 204); width: 100%; max-height: 200px; overflow-y: scroll; background: rgb(255, 255, 255) none repeat scroll 0% 0%; top: 0px; display:none ;">
					<ul>
					</ul>
				</div>
			</div>
		</div>
	</div>
<div class="mapPosition">
	<a href="./changecity.php?action=map" class="positionTarget"><i></i>精准定位</a>
    <span class="to_china" style="float: right;margin-right: 10px;cursor: pointer">进入全国</span>
<?php if($user_location_area_name) {?>
    <h3 id="header_city"><?php echo $user_location_area_name_all;?></h3>
<?php }elseif($user_location_city_name) {?>
	<h3 id="header_city"><?php echo $user_location_city_name_all;?></h3>
<?php } else {?>
    <h3 id="header_city">全国</h3>
<?php }?>	
	
	
</div>

<div class="hotArea clearfix">
    <h3><a href="javascript:void(0)">定位城市</a></h3>
    <ul>
        <li><a class="click_code" id="location" data-code="340100" href="javascript:void(0)">定位中</a></li>
    </ul>
</div>

<?php if(count($hot_city)) {?>
<div class="hotArea clearfix">
	<h3>热门城市</h3>
	<ul>
	<?php foreach($hot_city as $k=>$v) {?>
		<li  ><a class="click_code" data-code="<?php echo $k;?>" href="javascript:void(0)"><?php echo $v;?></a> </li>	
	<?php }?>
	</ul>
</div>
<?php }?>

<div class="areaList">
<?php if(is_array($city_array)) {?>
	
	<ul>
		<?php foreach($city_array as $k=>$v) {?>
		<li>
			<h3 id="<?php echo strtoupper($k);?>1"><?php echo strtoupper($k);?></h3>
			<ol>
				<?php if(is_array($v)) {?>
					<?php foreach($v as $k1=>$v1) {?>
				<li>
					<a href="javascript:void(0)" class="click_code" data-code="<?php echo $v1['code']?>"><?php echo $v1['name'];?></a><a href="javascript:void(0);" class="select_area" style="float: right;margin-right:30px;margin-top: -40px;color: #4F6CF9;">区域展开</a>
                    <ol style="display: none;">
                        <?php foreach($v1['area'] as $k2=>$v2){ ?>
                            <li>
                                <a href="javascript:void(0)" class="click_code" data-code="<?php echo $v2['area_code']?>" style="margin-left: 13px;"><?php echo $v2['area'];?></a>
                            </li>
                        <?php } ?>
                    </ol>
				</li>
					<?php }?>
				<?php }?>

			</ol>
		</li>
		<?php }?>
	</ul>
<?php }?>
</div>

<?php if(is_array($zimu_area)) {?>
<div class="letterNav">
	<h3><a href="javascript:void(0)">热门</a></h3>
	<ul>
		<?php foreach($zimu_area as $k=>$v){?>
			<li><a href="#<?php echo strtoupper($v);?>1"><?php echo strtoupper($v);?></a></li>
		<?php }?>
	</ul>
</div>
<?php }?>
<script type="text/javascript">
    $(function(){
        $('.select_area').click(function(){
            var text = $(this).text();
            if(text=='区域展开'){
                $(this).next('ol').slideToggle("slow");
                $(this).text('区域收起');
            }else if(text=='区域收起'){
                $(this).next('ol').slideToggle("slow");
                $(this).text('区域展开')
            }
        });
        $(".to_china").click(function(){
            $.post("/wap/changecity.php?action=set_city",{"city_code":"to_china"},function(obj){
                    window.location.href="<?php echo $config['site_url'];?>/wap/index.php";
                },
                'json'
            )
        })
    })
</script>
</body>
</html>