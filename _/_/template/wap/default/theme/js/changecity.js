// JavaScript Document
$(function(){
	$('html, body').scrollTop(0);
	getLocation();
})


var long = 0;
var lat = 0;
function getLocation() {
	var options = {
		enableHighAccuracy:false,
        timeout:8000,
		maximumAge:1000
	}
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(onSuccess, onError, options);
	} else {
        alert( '您当前使用的浏览器不支持Geolocation服务' );
	}
}

//定位成功时
function onSuccess(position){
	long = position.coords.longitude;
	lat = position.coords.latitude;

    locateCity();
}

//定位失败时
function onError(error) {
    switch(error.code)
    {
        case 0:
            alert("尝试获取您的位置信息时发生错误：" + error.message);
            break;
        case 1:
            alert("用户拒绝了获取位置信息请求。");
            break;
        case 2:
            alert("浏览器无法获取您的位置信息：" + error.message);
            break;
        case 3:
            alert("获取您位置信息超时。");
            break;
    }
}

function locateCity(){
    if (long == 0 || lat == 0) {
        return;
    }

    $.post("./changecity.php?action=location_city",{"lng":long,"lat":lat},function(data){
        if(data.status==1){
            $('#location').text(data.city);
            $('#location').attr("data-code",data.city_code);
            $('#location').addClass("click_code");
        }else{
            $('#location').text("定位失败");
        }
    });
}
