<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title><?php echo $config['site_name'];?></title>
	<meta name="keywords" content="<?php echo $config['seo_keywords'] ?>" />
	<meta name="description" content="<?php echo $config['seo_description'] ?>" />
	<link rel="icon"  href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
	<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/index-slider.v7062a8fb.css">
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/animate.css">
	<link href=" " type="text/css" rel="stylesheet" id="sc">
	<link href="<?php echo TPL_URL;?>css/public.css" type="text/css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>

	<script src="<?php echo TPL_URL;?>js/index2.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
	<!--[if lt IE 9]>
	<script src="<?php echo TPL_URL;?>js/html5shiv.min-min.v01cbd8f0.js"></script>
	<![endif]-->
		<!--[if IE 6]>
	<script  src="js/DD_belatedPNG_0.0.8a.js" mce_src="<?php echo TPL_URL;?>js/DD_belatedPNG_0.0.8a.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('*');</script>
	<style type="text/css"> 
	body{ behavior:url("csshover.htc");}
	</style>
	<![endif]-->
<style>
.footer1{margin-top:40px;}
.address_content{padding-bottom:70px;}
</style>
<script>
$(function(){
	
	$(".click_code").click(function(){
		var city_code = $(this).data("code");
		var city_name = $(this).html();
		if(city_code) {
			$.post("/index.php?c=changecity&a=set_city",{"city_code":city_code,"city_name":city_name},function(obj){
				if(city_code) {
					window.location.href="<?php echo $config['site_url'];?>";
				}
			},
			'json'
			)
		}
	});
    $(".button_select_city").click(function(){
        var select_province = $("select[name='province']").val();
        var province_name=$("select[name='province']").find("option[value='"+select_province+"']").html();
        var select_city = $("select[name='city']").val();
        var city_name=$("select[name='city']").find("option[value='"+select_city+"']").html();
        var select_area = $("select[name='area']").val();
        var area_name=$("select[name='area']").find("option[value='"+select_area+"']").html();

        if( ((select_city==''|| select_city=='选择城市') && (select_area==''  || select_area=='选择地区')) ) {
            layer_tips(1,'请选择城市或区域');
        };
        if( !(select_area==''  || select_area=='选择地区') ){
            $.post("/index.php?c=changecity&a=set_city",{"province_code":select_province,"province_name":province_name,"city_code":select_city,"city_name":city_name,"area_code":select_area,"area_name":area_name},function(obj){
                    if(select_city) {
                        window.location.href="<?php echo $config['site_url'];?>";
                    }
                },
                'json'
            );
            return false;
        }else if(select_city) {
            $.post("/index.php?c=changecity&a=set_city",{"province_code":select_province,"province_name":province_name,"city_code":select_city,"city_name":city_name},function(obj){
                    if(select_city) {
                        window.location.href="<?php echo $config['site_url'];?>";
                    }
                },
                'json'
            );
        }

    });

	$(".to_china").click(function(){
		$.post("/index.php?c=changecity&a=set_city",{"city_code":"to_china"},function(obj){
				window.location.href="<?php echo $config['site_url'];?>";
		},
		'json'
		)
	})

    $(".select_area_confirm").click(function(){
        var city_code = $('input[name="write_city"]').attr('data-city_code');
        var city_name = $('input[name="write_city"]').attr('data-city_name');
        if(city_code) {
            $.post("/index.php?c=changecity&a=set_city",{"city_code":city_code,"city_name":city_name},function(obj){
                    if(city_code) {
                        window.location.href="./index.php";
                    }
                },
                'json'
            )
        }
    });

})

</script>
</head>

<!-- header start -->
<body>
<?php include display( 'public:header');?>
<!-- header end -->		
	
	
	<article name="address_name" class="address_content">
		<section class="">
			<dl>
				<dt class="clearfix">
					<div class="address_name">进入<span class="to_china cursor">全国</span></div>
 					<div class="select"><span>按省份选择:</span>
                        <span>
                        <select id="lo1" name="province" class="province">
                            <option value="">选择省份</option>
                        </select>
                        </span>
                        <span>
                        <select id="lo2" name="city" class="city">
                            <option value="">选择城市</option>
                        </select>
                        </span>
                        <span>
                        <select id="lo3" name="area" class="area">
                            <option value="">选择地区</option>
                        </select>
                        </span>
						<button class="button_select_city">确定</button>
					</div>
					<div class="select ss"><span>直接输入:</span>
						<input class="write_city" id="write_city" name="write_city"  type="text" placeholder="直接输入城市中文或拼音"/>
						<div class="js-drop-dia" style="position:relative;z-index:99999; left: 0px; border: 2px solid rgb(204, 204, 204); width: 200px; max-height: 200px; overflow-y: scroll; background: rgb(255, 255, 255) none repeat scroll 0% 0%; top: 0px; display:none ;">
					<ul>

					</ul>
				</div>
						
	<style>.js-drop-dia li:hover{background-color:#f7f7f7;cursor:pointer}</style>
	<script>
		
		$(".write_city").live("keyup focus", function (event) {
			var dom = $(this);
			var dom_offset = $(this).offset();
			var popover_height = $(this).height();
			var popover_width = $(this).width();
			$('.js-drop-dia').css({display:'inline',position:'absolute',width:popover_width+5,top:dom_offset.top+dom.height()+2,left:dom_offset.left - ((popover_width+5)/2) + (dom.width()/2)});
			
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
			var select_city_url = "/index.php?c=changecity&a=select_city"
			var keyword = $(this).val();
			
			$.post(select_city_url, {"keyword" : keyword}, function (result) {
			
				if (result.err_code == "0") {
					var html = "";
					var city_list = result.err_msg;
					for(var i in city_list) {
						html += '<li style="margin-left:10px;text-align:left" class="js_city_detail" data-code="' + city_list[i].code + '">' + city_list[i].name + '</li>';
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

                $('input[name="write_city"]').val(city_name);
                $('input[name="write_city"]').attr('data-city_code',city_code);
                $('input[name="write_city"]').attr('data-city_name',city_name);
                $('.js-drop-dia').hide();
			});

		})

	</script>
		<style>
			.select .input_select{height:auto;}
		</style>
		<span id="input_select">
			<select  class="input_select" name="input_select" size="10" style="display:none">
				<?php foreach($all_city as $k=>$v) {?>
					<option value="<?php echo $k;?>"><?php echo $v;?></option>
				<?php }?>
			</select>
		</span>
            <button class="select_area_confirm">确定</button>
		</div>
	</dt>
				
				<?php if(count($hot_city)) {?>
				<dd>
					<span>热门城市:</span>
					<?php foreach($hot_city as $k=>$v) {?>
						<i class="click_code" data-code="<?php echo $k;?>"><?php echo $v;?></i>
					<?php }?>
				</dd>
				<?php }?>
				
				<?php if(is_array($zimu_area)) {?>
				<dd><span>按首字母选择:</span>
					<?php foreach($zimu_area as $k=>$v){?>
						<i><a href="#<?php echo strtoupper($v);?>1"><?php echo strtoupper($v);?></a></i>
					<?php }?>
				</dd>
				<?php }?>
				
				<?php if(is_array($city_array)) {?>
					<?php foreach($city_array as $k=>$v) {?>
						<dd class="on" id="<?php echo strtoupper($k);?>1">
							<i class="city"><?php echo strtoupper($k);?></i>
							
							<?php if(is_array($v)) {?>
								<?php foreach($v as $k1=>$v1) {?>
								<i class="click_code" data-code="<?php echo $v1['code']?>"><?php echo $v1['name'];?></i>
								<?php }?>
							<?php }?>
						</dd>
					<?php }?>
				<?php }?>

			</dl>
		</section>
	</article>
	<?php include display( 'public:footer');?>
</body>
	<script>  

		$(function(){  
			//锚点跳转滑动效果  
			$('a[href*=#],area[href*=#]').click(function() {  
				console.log(this.pathname)  
				if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {  
					var $target = $(this.hash);  
					$target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');  
					if ($target.length) {  
						var targetOffset = $target.offset().top;  
						$('html,body').animate({  
									scrollTop: targetOffset  
								},  
								100);  
						return false;  
					}  
				}  
			});  
		})  

        getProvinces('lo1', '');
        $('#lo1').change(function(){
            $('#lo2').html('<option>选择城市</option>');
            if($(this).val() != ''){
                getCitys('lo2','lo1','');
            }
            $('#lo3').html('<option>选择地区</option>');
        });
        $('#lo2').change(function () {
            getAreas('lo3', 'lo2', '');
        });
	</script>  
</html>
