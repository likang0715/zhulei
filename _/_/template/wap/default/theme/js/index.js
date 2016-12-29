var long = 116.301747;
var lat = 39.918424;
// JavaScript Document
$(function(){
	$('.index_near').Tabs();
	$('html, body').scrollTop(0);
	getLocation();
	$(".index_near_menu li").click(function () {
		var index = $(".index_near_menu li.current").index();
		if ($(".index_near_con>div").eq(index).attr("data-type") == "default") {
			if (index == 0) {
				getStore();
			} else if (index == 1) {
				getActive();
			} else if (index == 2) {
				getGoods();
			}
		}
	});
})
function getLocation() {
	var options = {
		enableHighAccuracy:true, 
		maximumAge:1000
	}
	if(navigator.geolocation) {
	//浏览器支持geolocation
	navigator.geolocation.getCurrentPosition(onSuccess, onError, options);
} else {
	//浏览器不支持geolocation
	alert("浏览器不支持geolocation");
}
}

//成功时
function onSuccess(position){
	long = position.coords.longitude;
	lat = position.coords.latitude;
	getStore();
	if(!getCookie('Web_user')){
		locateCity();
	}
}
//失败时
function onError(error) {
	alert('获取位置失败')
}
function getStore() {
	if (long == 0 || lat == 0) {
		return;
	}
	$(".index_near_con>div").eq(0).attr("data-type","load");
	$.getJSON("./index_ajax.php?action=nearstore&long=" + long + "&lat=" + lat, function (data) {
		try {
			if (data.err_code != 0) {

			} else {
				var html = "";
				for(var i in data.err_msg) {
					html += '<li>';
					html += '<a href="'+data.err_msg[i].url+'" class="cf">';
					html += '<div class="index_near_l">';
					html += '<img src="'+data.err_msg[i].logo+'">';
					html += '</div>';
					html += '<div class="index_near_r">';
					html += '<h3>' + data.err_msg[i].name + '<span class="index_tuan">团</span><span class="index_ding">订</span></h3>';
					html += '<p class="index_price">&nbsp;&nbsp;￥'+data.err_msg[i].price+'/人</p>';
					html += '<p class="index_dis">' + data.err_msg[i].address + '<span>' + getRange(data.err_msg[i].juli) + '</span></p>';
					if (data.err_msg[i].tuan.length>0) {
						html += '<p class="index_discount"><span class="index_tuan">团</span>' + data.err_msg[i].tuan + '</p>';
					};
					if (data.err_msg[i].hui.length>0) {
						html += '<p class="index_discount"><span class="index_hui">惠</span>' + data.err_msg[i].hui + '</p>';
					};
					html += '</div>';
					html += '</a>';
					html += '</li>';
				}
				$(".index_near_con_01 ul").html(html);
			}
		} catch(e) {

		}
	});
}


function getActive() {

	if (long == 0 || lat == 0) {
		return;
	}
	$(".index_near_con>div").eq(1).attr("data-type","load");
	$.getJSON("./index_ajax.php?action=nearchahui&long=" + long + "&lat=" + lat, function (data) {
		try {
			if (data.err_code != 0) {

			} else {
				var html = "";
				for(var i in data.err_msg) {
					html += '<li>';
					html += '	<a href="' + data.err_msg[i].url + '" class="cf">';
					html += '		<div class="index_near_l">';
					html += '			<img src="' + data.err_msg[i].images + '">';
					html += '		</div>';
					html += '		<div class="index_near_r">';
					html += '			<h3>' + data.err_msg[i].name + '</h3>';
					html += '			<p class="index_des">' + substrs(data.err_msg[i].description,'30')+ '</p>';
					if (data.err_msg[i].price == '免费') {
						html += '			<p class="index_time">' + data.err_msg[i].sttime + '<span>' + data.err_msg[i].price + '</span></p>';
					}else{
						html += '			<p class="index_time">' + data.err_msg[i].sttime + '<span>' + data.err_msg[i].price + '元/人</span></p>';
					}
					html += '		</div>';
					html += '	</a>';
					html += '</li>';
				}
				$(".index_near_con_02 ul").html(html);
			}
		} catch(e) {
			alert(e.toString());
		}
	});
}



function getGoods() {

	if (long == 0 || lat == 0) {
		return;
	}

	$(".index_near_con>div").eq(2).attr("data-type","load");
	$.getJSON("./index_ajax.php?action=neargoods&long=" + long + "&lat=" + lat, function (data) {
		try {
			if (data.err_code != 0) {

			} else {
				var html = "";
				for(var i in data.err_msg) {
				html +='<li>';
				html +='	<a href="' + data.err_msg[i].url + '" class="cf">';
				html +='		<div class="index_near_l">';
				html +='			<img src="' + data.err_msg[i].image + '">';
				html +='		</div>';
				html +='		<div class="index_near_r">';
				html +='			<h3>' + data.err_msg[i].name + '</h3>';
				if (data.err_msg[i].is_recommend == '免费') {
				html +='			<p class="index_desc">' + data.err_msg[i].recommend_title + '</p>';
				}
				html +='			<p class="index_price">';
				html +='				<span class="cur_price">￥' + data.err_msg[i].price + '</span>';
				html +='				<span class="old_price">￥'+ data.err_msg[i].original_price +'</span>';
				html +='				<span class="delivery">包邮</span>';
				html +='			</p>';
				html +='		</div>';
				html +='	</a>';
				html +='</li>';
				}
				$(".index_near_con_03 ul").html(html);
			}
		} catch(e) {
			// alert(e.toString());
		}
	});
}

function getRange(range){
	range = parseInt(range);
	if(!range) return "0km";
	if(range < 1000){
		return range+'m';
	}else if(range<5000){
		return (range/1000).toFixed(2)+'km';
	}else if(range<10000){
		return (range/1000).toFixed(1)+'km';
	}else{
		return Math.floor(range/1000)+'km';
	}
}

function substrs(str,showlen){
	lengths = str.length;
	if(showlen>lengths){
		show_str = str;
	} else {
		show_str = str.substr(0,showlen)+'..';

	}
	return show_str;
}

function locateCity(){
	if (long == 0 || lat == 0) {
		return;
	}

	$.post("./changecity.php?action=set_location",{"lng":long,"lat":lat},function(obj){
		window.location.href= "./index.php";
	})
}
