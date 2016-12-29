<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>配送员位置</title>
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
        <a href="javascript:history.back();"><span></span></a>
        <div class="header_txt">配送员位置</div>
    </div>
    <div class="order_txt clearfix">
        <div class="order_num"><span>配送员 【</span><span><?php echo $courier_info['name'] ?>】</span> 距离目的地 <span class="js-distance">0</span> 米</div>
        <div class="order_state"></div>
    </div>
    <div class="map" id="js-map"></div>
</div>

<script type="text/javascript" src="http://api.map.baidu.com/api?type=quick&ak=4c1bb2055e24296bbaef36574877b4e2&v=1.0"></script>
<script type="text/javascript">

    /**
     * 计算两点之间距离
     * @param start
     * @param end
     * @return 米
     */
    function getDistance(_start, _end){
        var lat1 = (Math.PI/180)*_start.lat;
        var lat2 = (Math.PI/180)*_end.lat;
        
        var lon1 = (Math.PI/180)*_start.lng;
        var lon2 = (Math.PI/180)*_end.lng;
        
        var R = 6371;
        var d =  Math.acos(Math.sin(lat1)*Math.sin(lat2)+Math.cos(lat1)*Math.cos(lat2)*Math.cos(lon2-lon1))*R;
        return d*1000;
    }

    $('#js-map').height($(window).height() - 100);


    var p_lon = "<?php echo $long;?>";
    var p_lat = "<?php echo $lat;?>";
    var p_name = "<?php echo $courier_info['name'] ?>";

    var map = new BMap.Map("js-map");
    var point = new BMap.Point(p_lon, p_lat);
        map.centerAndZoom(new BMap.Point("<?php echo $address_location['lng'] ?>", "<?php echo $address_location['lat'] ?>"), 15);


    // 加标注 
    var marker = new BMap.Marker(point);
    var myIcon = new BMap.Icon("<?php echo TPL_URL;?>/courier_style/images/deliver_pos.png", new BMap.Size(22,60));
    var marker = new BMap.Marker(point,{icon:myIcon});  // 创建标注

    var infoWindow = new BMap.InfoWindow("<div>"+"<?php echo date('Y/m/d H:i:s', $courier_info['location_time']) ?>"+"</div><div>配送员【"+p_name+"】在此</div>");
        marker.addEventListener("click", function(){this.openInfoWindow(infoWindow);});
        map.addOverlay(marker);

    // //店铺图标
    var pt2 = new BMap.Point("<?php echo $physical_info['long'] ?>", "<?php echo $physical_info['lat'] ?>");
    var storeIcon = new BMap.Icon("<?php echo TPL_URL;?>/courier_style/images/store_pos.png", new BMap.Size(22,60));
    var marker2 = new BMap.Marker(pt2,{icon:storeIcon});  // 创建标注

    var infoWindow2 = new BMap.InfoWindow("<div>门店 【<?php echo $physical_info['name'] ?>】 为您服务</div>");
        marker2.addEventListener("click", function(){this.openInfoWindow(infoWindow2);});
        map.addOverlay(marker2);

    // 收货地址图标
    var pt1 = new BMap.Point("<?php echo $address_location['lng'] ?>", "<?php echo $address_location['lat'] ?>");
    var myIcon = new BMap.Icon("<?php echo TPL_URL;?>/courier_style/images/my_pos.png", new BMap.Size(60,60));
    var marker1 = new BMap.Marker(pt1,{icon:myIcon});  // 创建标注
        var infoWindow1 = new BMap.InfoWindow("<div>检测到的收货地址:</div><div><?php echo $address_location['name'] ?></div>");
        marker1.addEventListener("click", function(){this.openInfoWindow(infoWindow1);});
        map.addOverlay(marker1);

    // 折线
    var polyline = new BMap.Polyline(
        [new BMap.Point(p_lon,p_lat), new BMap.Point("<?php echo $address_location['lng'] ?>", "<?php echo $address_location['lat'] ?>")], 
        {strokeColor:"red", strokeWeight:2, strokeOpacity:0.8}
    );   //创建折线
    map.addOverlay(polyline);   //增加折线
    // 配送员 和收货地址距离
    var distance = getDistance(new BMap.Point("<?php echo $address_location['lng'] ?>", "<?php echo $address_location['lat'] ?>"),new BMap.Point("<?php echo $long;?>", "<?php echo $lat;?>"));
    $(".js-distance").text(Math.round(distance));

    map.addControl(new BMap.ZoomControl());

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
