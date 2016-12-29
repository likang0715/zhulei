<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>地图</title>
<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
<link rel="stylesheet" href="<?php echo TPL_URL;?>courier_style/css/style.css"/>
<script src="<?php echo TPL_URL;?>courier_style/js/jquery-1.7.2.js"></script>
<style type="text/css">
    .arrive_address,.go_search {
        border: 1px solid #fff;
        border-radius: 4px;
        float: right;
        padding: 0 5px;
    }
</style>
</head>

<body>
<div class="content">
    <div class="header clearfix">
        <a href="/wap/courier.php"><span></span></a>
        <div class="header_txt">地图</div>
    </div>
    <div class="order_txt clearfix">
        <div class="order_num"><span>订单号:</span><span><?php echo $order_info['order_no'] ?></span></div>
        <div class="order_state">
        <?php
            if ($package_info['status'] == 1) {
                echo '未配送';
            } else if ($package_info['status'] = 2) {
                echo '配送中';
            } else if ($package_info['status'] = 3) {
                echo '已送达';                
            }
        ?>
        </div>
    </div>
    <div class="map" id="js-map"></div>
    <div class="address clearfix"><i></i>
        <div class="address_txt">地址:<span><?php echo $order_info['address_string'] ?></span></div>
    </div>
    <div class="contact clearfix">
    <div class="contact_txt">联系人:<span><?php echo $order_info['address_tel'] ?>(<?php echo $order_info['address_user'] ?>)</span></div>
        <a href="tel:<?php echo $order_info['address_tel'] ?>"><i></i></a>
    </div>
</div>

<script type="text/javascript" src="http://api.map.baidu.com/api?type=quick&ak=4c1bb2055e24296bbaef36574877b4e2&v=1.0"></script>
<script type="text/javascript">
    $('#js-map').height($(window).height()-200);
    var points = '<?php echo $points ?>';
    points = $.parseJSON(points);

    var p_lon = "<?php echo $physical_info['long'];?>";
    var p_lat = "<?php echo $physical_info['lat'];?>";

    var map = new BMap.Map("js-map");
    var point = new BMap.Point(p_lon,p_lat);
    map.centerAndZoom(point, 13);
    map.addControl(new BMap.ZoomControl());

    function addMarker(point, address){

        // 加标注 
        var marker = new BMap.Marker(point);
        var infoWindow = new BMap.InfoWindow("<div>"+address+"</div><div class=\"arrive_address\">查看详情</div>");
        marker.addEventListener("click", function(){this.openInfoWindow(infoWindow);});
        infoWindow.addEventListener("open",function(e){
            $('.arrive_address').click(function(){
                window.location.href = 'http://map.baidu.com/mobile/webapp/search/search/qt=s&wd='+address+'/?third_party=uri_api';
            });
        });

        map.addOverlay(marker);

    }

    for (i in points) {
        var point = new BMap.Point(points[i].lng, points[i].lat);
        addMarker(point, points[i].name);
        map.centerAndZoom(point, 20);
    }

    if (points.length == 0) {

        var point = new BMap.Point(p_lon,p_lat);
        var marker = new BMap.Marker(point);
        var infoWindow = new BMap.InfoWindow("<div>未匹配到收件地址</div><div class=\"go_search\">去搜索</div>");
        marker.addEventListener("click", function(){this.openInfoWindow(infoWindow);});
        infoWindow.addEventListener("open",function(e){
            $('.go_search').click(function(){
                window.location.href = 'http://map.baidu.com/mobile/webapp/search/search/qt=s&wd=<?php echo $order_info["address"]["address"] ?>/?third_party=uri_api';
            });
        });

        // map.addOverlay(marker);
        map.openInfoWindow(infoWindow,point);
    }

</script>
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
