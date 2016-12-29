var app_type = '';
var data_app_json = "";

$(function() {
	var nowScroll=0;
	var payShowAfter = function(){
		$('html').css({'overflow':'visible','height':'auto','position':'static'});
		$('body').css({'overflow':'visible','height':'auto','padding-bottom':'45px'});
		$(window).scrollTop(nowScroll);
	}
	
	$('#confirm-pay-way-opts .btn-pay').click(function(){
		var pay_type = $(this).data('pay-type');
		var post_data = {pay_type : pay_type, order_no : order_no};
		
		var loadingCon = $('<div style="overflow:hidden;visibility:visible;position:absolute;z-index:1100;transition:opacity 300ms ease;-webkit-transition:opacity 300ms ease;opacity:1;top:'+(($(window).height()-100)/2)+'px;left:'+(($(window).width()-200)/2)+'px;"><div class="loader-container"><div class="loader center">处理中</div></div></div>');
		var loadingBg = $('<div style="height:100%;position:fixed;top:0px;left:0px;right:0px;z-index:1000;opacity:1;transition:opacity 0.2s ease;-webkit-transition:opacity 0.2s ease;background-color:rgba(0,0,0,0.901961);"></div>');
		$('html').css({'position':'relative','overflow':'hidden','height':$(window).height()+'px'});
		$('body').css({'overflow':'hidden','height':$(window).height()+'px','padding':'0px'}).append(loadingCon).append(loadingBg);
		nowScroll = $(window).scrollTop();
		//本地测试使用
		if (pay_type == 'test') {
			setTimeout(function() {
				loadingCon.remove();
				loadingBg.remove();
			}, 200);
			$.post('saveorder.php?action=test_pay_platform', post_data, function(result) {
				if (!result.err_code) {
					window.location.href = result.err_msg;
				} else {
					motify.log(result.err_msg);
				}
			})
			return true;
		}
		
		$.post('saveorder.php?action=pay_platform', post_data, function(result) {
			payShowAfter();
			loadingBg.css('opacity',0);
			setTimeout(function () {
				loadingCon.remove();
				loadingBg.remove();
			}, 200);
			if (typeof(result) == 'object') {
				if (result.err_code == 0) {
					if (pay_type == 'platform_weixin' && window.WeixinJSBridge) {
						if (typeof result.err_dom != "undefined" && result.err_dom == "not_pay") {
							window.location.href = result.err_msg;
							return;
						}
						
						window.WeixinJSBridge.invoke("getBrandWCPayRequest", result.err_msg, function(res) {
							WeixinJSBridge.log(res.err_msg);
							if (res.err_msg=="get_brand_wcpay_request:ok") {
								window.location.href = './order_platform.php?order_no='+order_no;
							} else {
								if (res.err_msg == "get_brand_wcpay_request:cancel") {
									var err_msg = "您取消了微信支付";
								} else if (res.err_code == 3) {
									var err_msg = "您正在进行跨号支付<br/>正在为您转入扫码支付......";
								} else if (res.err_msg == "get_brand_wcpay_request:fail") {
									var err_msg = "微信支付失败<br/>错误信息："+res.err_desc + obj2String(result);
								} else {
									var err_msg = res.err_msg +"<br/>"+res.err_desc + obj2String(result);
								}
								motify.log(err_msg);
								if (res.err_code == 3) {
									wx_qrcode_pay(post_data);
								}
							}
						});
					} else {
						window.location.href = result.err_msg;
					}
				} else {
					if (result.err_code == 1008) {
						motify.log("此订单为货到付款，现在无须支付");
						window.location.href = result.err_msg;
						return;
					}
					
					if (result.err_code == 10000) {
						motify.log(result.err_msg);
						return;
					}
					
					motify.log(result.err_msg);
					if(result.err_code == 1007) {
						window.location.href = './order.php?orderno=' + orderNo;
					}
				}
			} else {
				motify.log(result.err_msg);
			}
		});
	});
});

function wx_qrcode_pay(post_data){
	$.post('saveorder.php?action=pay_platform&qrcode_pay=1', post_data, function(result) {
		if (result.err_code == 0) {
			$('#pay-qrcode').attr('src', result.err_msg);
			$('#confirm-pay-way-opts').css('display', 'none');
			$('#confirm-qrcode-pay').css('display', 'block');
		}
	});
}



var obj2String = function(_obj) {
	var t = typeof(_obj);
	if (t != 'object' || _obj === null) {
		// simple data type
		if (t == 'string') {
			_obj = '"' + _obj + '"';
		}
		return String(_obj);
	} else {
		if (_obj instanceof Date) {
			return _obj.toLocaleString();
		}
		// recurse array or object
		var n, v, json = [],
		arr = (_obj && _obj.constructor == Array);
		for (n in _obj) {
			v = _obj[n];
			t = typeof(v);
			if (t == 'string') {
				v = '"' + v + '"';
			} else if (t == "object" && v !== null) {
				v = this.obj2String(v);
			}
			json.push((arr ? '': '"' + n + '":') + String(v));
		}
		return (arr ? '[': '{') + String(json) + (arr ? ']': '}');
	}
};