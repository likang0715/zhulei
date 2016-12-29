<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link href="<?php echo TPL_URL;?>css/new/base.css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/new/index.css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/new/animate.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/new/swiper.min.css" type="text/css">
<title><?php echo $subject_info[name]?></title>
<script src="<?php echo TPL_URL;?>js/swiper.min.js"></script>
<script src="<?php echo TPL_URL;?>js/rem.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
<script>
	var page_url = '<?php echo $page_url;?>&ajax=1';
	var dianzan_url = '<?php echo $dianzan_url?>';

</script>
<style>
.product .product_content .product_con_list .product_info{line-height:1.5rem}
@font-face{
    font-family:'方正兰亭纤黑_GBK';
    src: url('<?php echo STATIC_URL;?>font/方正兰亭纤黑_GBK.ttf');
}
body{font-family:"方正兰亭纤黑_GBK","Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; position:static;}
a{font-family:"方正兰亭纤黑_GBK","Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;-webkit-tap-highlight-color: rgba(0,0,0,0);}
h1, h2, h3, h4, h5, h6{font-family:"方正兰亭纤黑_GBK";}

/*头图*/
.product .product_show{
    max-height: none;
}
/*专题标题*/
.product .product_show p{
    font-size: 1rem;
    width:99%;
}
/*专题标题*/
.product .product_content .product_con_list .product_title{
    font-size: 0.87rem;
    line-height: 1.3rem;
}
.product .product_content .product_con_list .product_title i{
    font-size: 0.7rem;
    height: 1.1rem;
    width: 1.1rem;
    line-height: 1.2rem;
}
/*专题描述*/
.product .product_content .product_introduce{
    font-size: 0.8rem;
}
.product .product_content .product_con_list .product_info{
    font-size: 0.8rem;
}
/*点赞*/
.product .product_content .product_con_list p{
    font-size: .65rem;
}
/*价格*/
.product .product_content .product_con_list .product_detailed span p:nth-child(1){
    font-size: .81rem;
    padding-bottom: .3rem;
    color: #f4444a;
    font-weight: bold;
}
/*查看详情*/
.product .product_content .product_con_list .product_detailed span:nth-child(2){
    margin-top: .15rem;
    border: 1px solid #f5555a;

}
.product .product_content .product_con_list .product_detailed span:nth-child(2) a{
    color: #ee536b !important;
}
/*整体边距*/
.product .product_content .product_con_list >li{
    padding: 0;
}
.product .product_content{
    width: 90%;
    margin: auto;
}
.product .product_content .product_introduce{
    width: 100%;
    margin: auto;
    padding: .5rem 0;
    border:none;
}
/*底部菜单*/
footer ul.product_footer li{
    margin: .4rem 0;
}
footer ul.product_footer li:nth-child(1) i{
    background-size: 16px;
    width: 16px;
    height: 13px;
}
footer ul.product_footer li:nth-child(2) i{
    background-size: 14px;
    width: 14px;
    height: 16.5px;
}
footer ul.product_footer li:nth-child(3) i{
    background-size: 17px;
    width: 17px;
    height: 14px;
}
</style>

<script type="text/javascript" src="<?php echo TPL_URL;?>js/subinfo.js"></script>
</head>

<body class="product">

    <!-- 专题信息 -->
    <div class="product_show" style="text-align:center;text-align:center;padding-bottom:.3rem"> <img style="max-height:100%;" src="<?php echo $subject_info[pic];?>"  />
        <p><?php echo $subject_info['name']?></p>
    </div>

<article class="article_show">
    <section class="product_content">
        <div class="product_introduce"> <?php echo $subject_info['description'];?> </div>
        <ul class="product_con_list">
        
        
        	<!--  
            <li>
                <div class="product_title"><i>1</i>百安思·保温杯</div>
                <p class="product_info">必败理由：欢乐的圣诞保温杯，点亮你的圣诞氛围。还可以刻字哦，定制专属你的圣诞杯，自己用或是送人都不错~?</p>
                <div class="product_img">
                    <ul>
                        <li> <img src="<?php echo TPL_URL;?>css/new_images/22_8.jpg" /></li>
                        <li> <img src="<?php echo TPL_URL;?>css/new_images/22_9.jpg" /></li>
                    </ul>
                </div>
                <p>肉疼原价：<span>252.00元</span></p>
                <p>优惠：店铺红包可抵5.00元，送杯套、杯刷、杯垫</p>
                <div  class="product_detailed"><span>
                    <p>￥55555</p>
                    <p><i>81</i>人喜欢</p>
                    </span><span><a href="product_minute.html">查看详情</a></span></div>
            </li>
            
            
            
            <li>
                <div class="product_title"><i>2</i>格纹保温杯</div>
                <p class="product_info">必败理由：很让人舒心的一款杯子，格纹图案优雅不做作，简约又不失时尚之感。广角杯口易于清洗，杯子内带有茶漏，方便品茗，非常适合喜欢 文艺范的美少年和美少女们</p>
                <div class="product_img">
                    <ul>
                        <li> <img src="<?php echo TPL_URL;?>css/new_images/22_10.jpg" /></li>
                        <li> <img src="<?php echo TPL_URL;?>css/new_images/22_12.jpg" /></li>
                    </ul>
                </div>
                <p>肉疼原价：<span>252.00元</span></p>
                <p>优惠：店铺红包可抵5.00元，送杯套、杯刷、杯垫</p>
                <div  class="product_detailed"><span>
                    <p>￥55555</p>
                    <p><i>81</i>人喜欢</p>
                    </span><span><a href="product_minute.html">查看详情</a></span></div>
            </li>
            
            
            
            <li>
                <div class="product_title"><i>3</i>优道·保温杯</div>
                <p class="product_info">必败理由：这是一款fDA认证的轻量便携式保温杯，瓶身采用表面处理技术，嫩肌手感，细腻爽滑，手握舒适，而且易拆洗。绚丽的糖果色，多种颜色可选，随你喜欢。?</p>
                <div class="product_img">
                    <ul>
                        <li> <img src="<?php echo TPL_URL;?>css/new_images/12.jpg" /></li>
                        <li> <img src="<?php echo TPL_URL;?>css/new_images/22_11.jpg" /></li>
                    </ul>
                </div>
                <p>肉疼原价：<span>252.00元</span></p>
                <p>优惠：店铺红包可抵5.00元，送杯套、杯刷、杯垫</p>
                <div  class="product_detailed"><span>
                    <p>￥55555</p>
                    <p><i>81</i>人喜欢</p>
                    </span><span><a href="product_minute.html">查看详情</a></span></div>
            </li>
            -->
            
            
        </ul>
    </section>
    
  <div class="wx_loading2"><i class="wx_loading_icon"></i></div>
    
    
    
    
    
 
    <section class="product_bottom" style="position1:fixed;bottom:35px;display:none">
        <ul class="clearfix">
            <li> <i class="dianzan  <?php if($dz_status == 1) {?> dianzan_selected <?php }?>"></i><span>点赞</span>
                <p><em class="dz_count"><?php echo $dz_count;?></em>人点赞</p>
            </li>
            <li class="js-open-share" ><i></i><span>分享</span>
                <p><em><?php echo $share_count;?></em>分享</p>
            </li>
            <li class="pinlun"><i></i><span>评论</span>
                <p><em><?php echo $subject_comment_count;?></em>评论</p>
            </li>
        </ul>
    </section>
    


  <div id="js_share_guide" class="js-fullguide fullscreen-guide hide" style="font-size: 16px; line-height: 35px; color: #fff; text-align: center;"><span class="js-close-guide guide-close">×</span><span class="guide-arrow"></span><div class="guide-inner">请点击右上角<br>通过【发送给朋友】功能<br>或【分享到朋友圈】功能<br>把礼物分享给小伙伴哟～</div></div>  
<script>    
$(function(){
	$(".js-open-share").click(function () {
		$("#js_share_guide").removeClass("hide");
	});
	
	$(".js-close-guide").live("click",function () {
		$("#js_share_guide").addClass("hide");
		return;
	});

	$(".pinlun").live("click",function() {
		location.href='<?php echo $pinlun_url;?>'
	})

})
</script>

	
</article>
<footer class="footer" style=" padding:0">
    <ul class="clearfix product_footer" style="     margin-top: 0.25rem;">
        <li ><i class="dianzan <?php if($dz_status == 1) {?>dianzan_selected <?php }?>"></i><span class="dz_count"><?php echo $dz_count;?></span></li>
        <li class="js-open-share"><i></i><?php echo $share_count;?></li>
        <li class="pinlun"><i></i><?php echo $subject_comment_count;?></li>
    </ul>
</footer>
<?php echo $shareData;?>
</body>
</html>
