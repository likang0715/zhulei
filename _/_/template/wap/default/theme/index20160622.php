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
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/swiper.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/index.css"  type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>theme/css/gonggong.css"  type="text/css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/article/shopIndex.css"  type="text/css">

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











<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/reset.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/common.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>pingtai/css/index.css">
	<script src="<?php echo TPL_URL;?>pingtai/js/jquery-1.7.min.js"></script>
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
			<button type="submit" class="index_search_submit"></button>
	
	</div>
	<div class="index_search_hot">
	    <h4>热门搜索</h4>
	    <ul>
	        <li><a href="#">福祥茶馆</a></li>
	        <li><a href="#">顺兴老茶馆</a></li>
	        <li><a href="#">老舍茶馆</a></li>
	        <li><a href="#">露雨轩茶楼</a></li>
	        <li><a href="#">泰元坊茶艺馆</a></li>
	        <li><a href="#">金骏眉茶叶</a></li>
	        <li><a href="#">龙井茶</a></li>
	    </ul>
	</div>
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
	<script type="text/javascript">
    $(document).ready(function(){
        $(".common_header_search").click(function(){
            $(".index_main").hide();
            $(".index_search").show();
            $(".common_header_search").hide();
            $(".common_header_back").show();
            $(".index_search_hot").show();
            $(".index_search_box").focus();
        })
        $(".common_header_back").click(function(){
            $(".index_main").show();
            $(".index_search").hide();
            $(".common_header_search").show();
            $(".common_header_back").hide();
            $(".index_search_hot").hide();
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
								<?php if($value['score']>0){ ?>
		            				<img src="<?php echo TPL_URL;?>pingtai/images/index_xing_<?php echo $value['score']; ?>.jpg">	<?php
			}else{	
		?>	
		            			还没有人评价&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<?php
			}	
		?>		
		            				&nbsp;&nbsp;￥<?php echo $value['price']; ?>元/人
		            			</li>
		            			<li><?php echo $value['address'] ?><span>js获取getRange(<?php echo $value['juli']; ?>)</span></li>
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
		<!-- 茶品分类部分 -->
		<div class="index_teatype">
	 <a href="category.php">
		        <div class="index_teatype_t">
		            <h5>茶品分类</h5>
		        </div>
		 </a>  
		    <div class="index_teatype_m cf">
		    	<table>	
				<?php
					$is_ul_end = true;
					foreach($cat as $key => $value) {
						if ($key % 4 == 0) {
							$is_ul_end = false;
							echo '<tr>';
						}
					?>
		    		
		    			<td<?php if ($key % 4 == 0) {?> class="border_left"<?php }elseif ($key % 4 == 3) {	?> class="border_right"<?php	}?>	>
		    			<a href="./category.php?keyword=<?php echo $value['cat_name'] ?>&id=<?php echo $value['cat_id'] ?>">
			            		<img src="<?php echo $value['cat_pic'] ?>">
			            		<p class="index_teatype_p"><?php echo $value['cat_name'] ?></p>
			        		</a>
		    			</td>
						
					<?php
						if ($key % 4 == 3) {
							echo '</tr>';
							$is_ul_end = true;
						}
				
					}
					?>	
					<?php
					
	if (!$is_ul_end) {
						echo '</tr>';
					}
	?>	
				
		    	</table>
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
		        <li>附近商品</li>
		        <li>附近茶会</li>
		    </ul>
		    <div class="index_near_con main">
		        <div class="index_near_con_01">
		        	<ul>
		        		<li>
		        			 <a href="#" class="cf">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_chaguan_01.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>易和茶馆<span class="index_tuan">团</span><span class="index_ding">订</span></h3>
				            		<p class="index_price"><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt="">&nbsp;&nbsp;￥85/人</p>
				            		<p class="index_dis">建国门 茶馆<span>1.0km</span></p>
				            		<p class="index_discount"><span class="index_tuan">团</span>卡座双人套餐79元，卡座四人套餐128元</p>
				            	</div>
				            </a>
		        		</li>
		        		<li>
		        			<a href="#" class="cf">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_chaguan_02.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>泰元坊茶馆<span class="index_tuan">团</span><span class="index_ding">订</span><span class="index_hui">惠</span></h3>
				            		<p class="index_price"><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt="">&nbsp;&nbsp;￥85/人</p>
				            		<p class="index_dis">新街口 茶馆<span>1.0km</span></p>
				            		<p class="index_discount"><span class="index_tuan">团</span>卡座双人套餐79元，卡座四人套餐128元</p>
				            		<p class="index_discount"><span class="index_hui">惠</span>满100减20（买单立享）</p>
				            	</div>
				            </a>
		        		</li>
		        		<li>
		        			 <a href="#" class="cf border_none">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_chaguan_03.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>名都茶艺馆<span class="index_tuan">团</span><span class="index_ding">订</span><span class="index_hui">惠</span></h3>
				            		<p class="index_price"><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt="">&nbsp;&nbsp;￥85/人</p>
				            		<p class="index_dis">亚运村 茶馆<span>1.0km</span></p>
				            		<p class="index_discount"><span class="index_tuan">团</span>卡座双人套餐79元，卡座四人套餐128元</p>
				            		<p class="index_discount"><span class="index_hui">惠</span>满100减20（买单立享）</p>	
				            	</div>
				            </a>
		        		</li>
		        	</ul>
		        </div>
		        <div class="index_near_con_02 hide">
		        	<ul>
		        		<li>
		        			 <a href="#" class="cf">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_shangpin_01.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>金骏眉买一送一，正宗三只松鼠金骏眉茶叶</h3>
				            		<p class="index_price">￥89&nbsp;&nbsp;<span>￥189</span></p>
				            		<p class="index_dis"><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><span>包邮</span></p>
				            	</div>
				            </a>
		        		</li>
		        		<li>
		        			<a href="#" class="cf">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_shangpin_02.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>2015 新茶 龙井茶 茶叶 绿茶龙井礼盒装 绿茶西湖美景香浓耐泡</h3>
				            		<p class="index_price">￥89&nbsp;&nbsp;<span>￥189</span></p>
				            		<p class="index_dis"><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><span>包邮</span></p>
				            	</div>
				            </a>
		        		</li>
		        		<li>
		        			 <a href="#" class="cf border_none">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_shangpin_03.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>古陌茶叶 布朗山金芽老茶头 云南勐海普洱熟茶散茶</h3>
				            		<p class="index_price">￥89&nbsp;&nbsp;<span>￥389</span></p>
				            		<p class="index_dis border_none"><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><img src="<?php echo TPL_URL;?>pingtai/images/index_xing.jpg" alt=""><span>包邮</span></p>
				            	</div>
				            </a>
		        		</li>
		        	</ul>
		        </div>
		        <div class="index_near_con_03 hide">
		        	<ul>
		        		<li>
		        			<a href="#" class="cf">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_chahui_01.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>节日茶会</h3>
				            		<p class="index_des">以庆祝国定节日而举行的各种茶会，如国庆茶会、春节茶会（迎春茶会）等</p>
				            		<p class="index_time">11/26 9:00<span>免费</span></p>
				            	</div>
				            </a>
		        		</li>
		        		<li>
		        			<a href="#" class="cf">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_chahui_01.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>节日茶会</h3>
				            		<p class="index_des">以庆祝国定节日而举行的各种茶会，如国庆茶会、春节茶会（迎春茶会）等</p>
				            		<p class="index_time">11/26 9:00<span>免费</span></p>
				            	</div>
				            </a>
		        		</li>
		        		<li>
		        			<a href="#" class="cf border_none">
				            	<div class="index_near_l">
				            		<img src="<?php echo TPL_URL;?>pingtai/images/index_near_chahui_01.png">
				            	</div>
				            	<div class="index_near_r">
				            		<h3>节日茶会</h3>
				            		<p class="index_des">以庆祝国定节日而举行的各种茶会，如国庆茶会、春节茶会（迎春茶会）等</p>
				            		<p class="index_time border_none">11/26 9:00<span>￥56/人</span></p>
				            	</div>
				            </a>
		        		</li>
		        	</ul>
		        </div>
		    </div>
		</div>
		<script type="text/javascript">
		    $(function(){
		        $('.index_near').Tabs();    
		    });
		</script>

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
	<div id="J_toast" class="toast ">你可以hhhh在这输入商品名称</div>
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
	                    <h2>一00元夺宝</h2>
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
											<div class="shopname">5555555555<?php echo $value['name'] ?></div>
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