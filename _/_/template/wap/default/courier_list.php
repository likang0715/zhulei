<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>配送</title>
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
<link rel="stylesheet" href="<?php echo TPL_URL;?>courier_style/css/style.css"/>

<script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
<script src="<?php echo TPL_URL;?>js/courier.js"></script>
<script type="text/javascript">
    var img_tpl = "<?php echo TPL_URL ?>";
</script>
</head>

<body>
<script>
$(function(){
	$(".dist_bottom li").click(function(){
		$(this).closet("active").removeClass("active").addClass("active").siblings().removeClass("active");
	})
})
</script>
<div class="content">
    <div class="header clearfix">
        <span onclick="WeixinJSBridge.call('closeWindow');"></span>
        <div class="header_txt">门店配送</div>
    </div>
    <div class="shop_title clearfix">
        <div class="shop_title_img"><img src="<?php echo $physical_info['images'] ?>" /></div>
        <div class="shop_title_txt">
            <p class="shop_name"> <?php echo $store_info['name'].'（'.$physical_info['name'].'）'; ?></p>
            <p>配送员：<span><?php echo $courier_info['name'] ?></span></p>
        </div>
    </div>
    <div class="order_list">
        <ul>

        </ul>
    </div>
    <div style="padding: 40px; text-align: center;" class="hide" id="sNull01">配送包裹空空如也</div>
    <div style="height:150px;">
        <div class="wx_loading2" style="display: block;"><i class="wx_loading_icon"></i></div>
    </div>
    <div class="dist_bottom clearfix">
        <ul class="clearfix">
            <a href="/wap/courier.php?openid=<?php echo $openid; ?>">
                <li class="index <?php if ($action == 'all') echo 'active' ?>" data-action="all" style="border:0"><i></i>
                    <p>全部</p>
                </li>
            </a>
            <a href="/wap/courier.php?openid=<?php echo $openid; ?>&action=wait">
                <li class="weipeisong <?php if ($action == 'wait') echo 'active' ?>" data-action="wait"><i></i>
                    <p>未配送</p>
                </li>
            </a>
            <a href="/wap/courier.php?openid=<?php echo $openid; ?>&action=send">
                <li class="peisongzhong <?php if ($action == 'send') echo 'active' ?>" data-action="send"><i></i>
                    <p>配送中</p>
                </li>
            </a>
            <a href="/wap/courier.php?openid=<?php echo $openid; ?>&action=arrive">
                <li class="yipeisong <?php if ($action == 'arrive') echo 'active' ?>" data-action="arrive"><i></i>
                    <p>已送达</p>
                </li>
            </a>
        </ul>
    </div>
</div>
<?php 
$share_conf     = array(
    'title'     => 'test_title', // 分享标题
    'desc'      => 'test_desc', // 分享描述
    'link'      => 'test_link', // 分享链接
    'imgUrl'    => 'img_url', // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share      = new WechatShare();
$shareData  = $share->getSgin($share_conf);
echo $shareData;
?>
<script type="text/javascript">

    var locationIsAjax = false;
    function ajaxLocation(res) {
        
        productIsAjax = true;
        $.ajax({
            type:"POST",
            url:'courier_ajax.php?action=location',
            data:'lat='+res.latitude+'&long='+res.longitude,
            dataType:'json',
            success:function(result){
                locationIsAjax = false;
            },
            error:function(){
                locationIsAjax = false;
            }
        });
        
    }

    function getLocation() {

        wx.getLocation({
            success: function (res) {
                ajaxLocation(res);
            },
            cancel: function (res) {
                // alert('拒绝获取');
            }
        })

        setTimeout(function(){
            getLocation();
        }, 5000)   
    }

    getLocation();


</script>
</body>
</html>
