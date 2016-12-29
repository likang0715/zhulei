
// JavaScript Document
$(function(){
	$(".toast").fadeTo(5000,0);
	$(".title_tab li").click(function () {
		var index = $(".title_tab li").index($(this));
		if ($(".js-near-content li").eq(index).find("div").data("type") == "default") {
			
			if (index == 0) {
				getStore();
			} else if (index == 1) {
				getActive();
			} else if (index == 2) {
				getGoods();
			}
		}
	});
	
	$('html, body').scrollTop(0);
	getLocation();
})


$(function(){
	var w=document.body.clientWidth;
	var w1=w-86;
    $("#yScroll2").css("width",w1);
	})

$(".swiper-slide").click(function() {
	$(this).addClass(" cur").siblings().removeClass("cur")
});


var long = 0;
var lat = 0;
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

}

function getStore() {
	if (long == 0 || lat == 0) {
		return;
	}
	$(".js-near-content li").eq(0).find("div").data("type", "load");
	$.getJSON("./index_ajax.php?action=nearstore&long=" + long + "&lat=" + lat, function (data) {
		try {
			if (data.err_code != 0) {
				
			} else {
				var html = "";
				for(var i in data.err_msg) {
					html += '<a href="' + data.err_msg[i].url + '&platform=1" class="item Fix">';
					html += '	<div class="cnt" style="height:auto"> <img class="pic" src="' + data.err_msg[i].logo + '" style="width:90px;height:90px;">';
					html += '		<div class="wrap">';
					html += '			<div class="wrap2">';
					html += '				<div class="content">';
					html += '					<div class="shopname">' + data.err_msg[i].name + '</div>';
					html += '					<div class="title">' + substrs(data.err_msg[i].intro,'22') + '</div>';
					html += '					<div class="info"><span><i></i>' + getRange(data.err_msg[i].juli) + '</span></div>';
					html += '				</div>';
					html += '			</div>';
					html += '		</div>';
					html += '	</div>';
					html += '</a>';
				}
				$(".js-store-list").html(html);
			}
		} catch(e) {
			
		}
	});
}


function getActive() {

	if (long == 0 || lat == 0) {
		return;
	}
	
	$(".js-near-content li").eq(1).find("div").data("type", "load");
	$.getJSON("./index_ajax.php?action=nearactive&long=" + long + "&lat=" + lat, function (data) {
		try {
			if (data.err_code != 0) {
				
			} else {
				var html = "";
				for(var i in data.err_msg) {
					html += '<a href="' + data.err_msg[i].url + '" class="item Fix">';
					html += '	<div class="cnt"> <img class="pic" src="' + data.err_msg[i].image + '">';
					html += '		<div class="wrap">';
					html += '			<div class="wrap2">';
					html += '				<div class="content">';
					html += '					<div class="shopname">' + substrs(data.err_msg[i].title,'14') + '</div>';
					html += '					<div class="title">' + substrs(data.err_msg[i].info,'22')  + '</div>';
					html += '					<div class="info">参与人数:'+data.err_msg[i].ucount+'人&#12288;<span><i></i>' + getRange(data.err_msg[i].juli) + '</span></div>';
					html += '				</div>';
					html += '			</div>';
					html += '		</div>';
					html += '	</div>';
					html += '</a>';
				}
				
				$(".js-active-list").html(html);
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

	$(".js-near-content li").eq(2).find("div").data("type", "load");
	$.getJSON("./index_ajax.php?action=neargoods&long=" + long + "&lat=" + lat, function (data) {
		try {
			if (data.err_code != 0) {
				
			} else {
				var is_open_margin_recharge = $('#is_open_margin_recharge').val();
				var platform_credit_name = $('#platform_credit_name').val();
				var credit_platform_credit_rule = $('#credit_platform_credit_rule').val();
				var html = "";
				for(var i in data.err_msg) {
					html += '<a href="' + data.err_msg[i].url + '&platform=1" class="item Fix">';
					html += '	<div class="cnt" style="height:88px;"> <img class="pic" src="' + data.err_msg[i].image + '">';
					html += '		<div class="wrap">';
					html += '			<div class="wrap2">';
					html += '				<div class="content">';
					html += '					<div class="shopname">' + data.err_msg[i].name + '</div>';
					html += '					<div class="title">' + data.err_msg[i].intro + '</div>';
					html += '					<div class="info">';
					html += '						<span class="symbol">¥</span>';
					html += '						<span class="price">' + data.err_msg[i].price + '</span>';
					html += '						<del class="o-price">¥' + data.err_msg[i].original_price + '</del>';
					html += '						<span class="sale ">立减' + data.err_msg[i].youhui_price + '元</span> <span class="distance"></span>';
					html += '					</div>';
					if(is_open_margin_recharge){
						var points_name = '赠送'+platform_credit_name+'：';
						var points_price = data.err_msg[i].give_points;
						if(data.err_msg[i].open_return_point){
							points_price = data.err_msg[i].return_point;
						}else{
							points_price = data.err_msg[i].price * credit_platform_credit_rule;
						}
						html += '				<div class="info">';
						html += '					<span style="color:#f60;">'+points_name + points_price+'</span>';
						html += '				</div>';
					}
					html += '				</div>';
					html += '			</div>';
					html += '		</div>';
					html += '	</div>';
					html += '</a>';
				}
				
				$(".js-goods-list").html(html);
			}
		} catch(e) {
			alert(e.toString());
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
