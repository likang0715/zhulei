//读取cookies
function getCookie(objName){//获取指定名称的cookie的值
//alert(objName)
	var arrStr = document.cookie.split("; ");
	for(var i = 0;i < arrStr.length;i ++){
		var temp = arrStr[i].split("=");
		if(temp[0] == objName) return unescape(temp[1]);
	}
}


//写cookies
function addCookie(objName,objValue,objHours){//添加cookie
	var str = objName + "=" + escape(objValue);
	if(objHours > 0){//为0时不设定过期时间，浏览器关闭时cookie自动消失
		var date = new Date();
		var ms = objHours*3600*1000;
		date.setTime(date.getTime() + ms);
		str += "; expires=" + date.toGMTString();
	}
	document.cookie = str;
}

//删除cookies
function delCookie(name){//为了删除指定名称的cookie，可以将其过期时间设定为一个过去的时间
	var date = new Date();
	date.setTime(date.getTime() - 10000);
	document.cookie = name + "=a; expires=" + date.toGMTString();
}

$(function(){


	$.fn.shopNotice = function (option) {

		var body = $(this);
		var defaults = { fadeoutTime:5, url:'./store_notice.php?action=get', storeId:0 };
		var options = $.extend(defaults, option);
		var timer = null;
		var timeout = null;
		var local_cookie;
		defaults.fadeoutTime = defaults.fadeoutTime*1000;

		if (defaults.storeId == 0) {
			console.log('缺少店铺ID');
			return;
		}

		var shopInit = {
			getPost : function () {
				local_cookie = shopInit.getLocal();
				$.post(options.url, { cookie_data:local_cookie, store_id:defaults.storeId }, function (data) {

					if (data.err_code == 0) {
						addCookie('shop_notice', data.err_msg.cookie_str);
						var orderInfo = data.err_msg.order_info;

						if (orderInfo.order_id > 0) {
							var htm = $('<div class="orderLayer clearfix" style="display:none">' +
							        '<div class="orderImg"><img src="' + orderInfo.avatar + '" alt=""></div>'+'<p class="orderInfo"><i>' + orderInfo.nickname + '</i>下了<em>1</em>笔订单<span>' + orderInfo.dis_time + '前</span></p>' +
							    '</div>');
							body.prepend(htm);
							htm.fadeIn(300);
							timeout = setTimeout(function(){
								htm.fadeOut(300);
							}, defaults.fadeoutTime);
						}

					} else {
						console.log('出错');
					}
				}, "json");

			},
			getLocal : function () {
				var tmp_shop_notice = getCookie('shop_notice');
				if (typeof tmp_shop_notice == 'null' || typeof tmp_shop_notice == 'undefined') {
					tmp_shop_notice = 0;
				}
				return tmp_shop_notice;
			},
			setLoopGet : function () {
				timer = setInterval(function(){
					shopInit.getPost();
				}, 10000);
			},
			init : function () {
				shopInit.getPost();
				shopInit.setLoopGet();
			}
		};

		shopInit.init();

	}

});