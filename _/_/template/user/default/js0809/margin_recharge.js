/**
 * Created by pigcms_21 on 2015/2/4.
 */
var clock = '';
var order_no = ''; //订单号
var start_time = ''; //起始时间
var stop_time  = ''; //结束时间
var type = ''; //类型
var status = ''; //状态
var t = '';
var order_no = ''; // 订单编号
$(function() {

    load_page('.app__content',load_url,{page:'margin_recharge_content'},'', function () {
        if (location.hash == '#success') {
            $('.notifications').html('<div class="alert in fade alert-success">保证金充值成功</div>');
        } else if (location.hash == '#faild') {
            $('.notifications').html('<div class="alert in fade alert-error">保证金充值失败</div>');
        }
        t = setTimeout('msg_hide()', 3000);
        location.hash = '';
    });


    $('.payment-methods > .payment-method').live('click', function(e) {
        if ($(this).hasClass('disabled')) {
            return false;
        }
        $(this).addClass('active').siblings('.payment-method').removeClass('active');
        var method = $(this).data('method').toLowerCase();
        var loading = $('.form-actions').data('loading');
        $('.form-actions > img').remove();
        if (method == 'allinpay') { //通联
            $('.js-btn-submit').show();
        } else if (method == 'platform_weixin') { //微信
            $('.js-btn-submit').show();
            //$('.form-actions').append('<img src="' + loading + '" />');
        } else if (method == 'platform_alipay') { //支付宝
            $('.js-btn-submit').show();
            //$('.form-actions').append('<img src="' + loading + '" />');
        } else if (method == 'tenpay') { //财富通
            $('.js-btn-submit').hide();
            $('.form-actions').append('<img src="' + loading + '" />');
        } else {
            $('.js-btn-submit').attr('disabled', true);
            $('.js-btn-submit').addClass('disabled');
        }
    })

	$('.js-btn-submit').live('click', function(){
		var method = $('.payment-methods > .active').data('method').toLowerCase();
		if (validate()) {
			$('.js-btn-submit').attr('disabled', true);
			var amount = parseFloat($('.js-money').val().trim());
			$.post(pay_url, {'method': method, 'amount': amount}, function(data) {
				if (data.err_code != 0) {
					$('.js-btn-submit').attr('disabled', false);
					$('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
					t = setTimeout('msg_hide()', 3000);
				} else {
					if (method == 'allinpay') {
						$('.js-btn-submit').attr('disabled', false);
						$('body').html(data.err_msg);
					} else if (method == 'platform_alipay' || method == 'platform_weixin') {
						var html_obj = $('<div class="modal hide fade order-price in js-scan-container" style="margin-top: -1000px; display: block; width:300px;" aria-hidden="false">\
											<div class="modal-header">\
												<a class="close js-scan-close" data-dismiss="modal">×</a>\
												<h3 class="title">扫码进行支付</h3>\
											</div>\
											<div class="modal-body js-detail-container">\
												<div>\
													<img src="' + data.err_dom + '" style="width:180px; height:180px; padding-left:45px;" />\
												</div>\
												<div style="width:100%; color:green; text-align:center; height:20px; line-height:24px;" class="js-scan-message"></div>\
											</div>\
										</div>');
						
						$('body').append(html_obj);
						order_no = data.err_msg;
						$('.js-scan-container').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow", function () {
							qrcode();
						});
					}
				}
			});
		}
	});
	
	$(".close, .js-close").live("click", function () {
		$('.modal').animate({'margin-top': '-1000px'}, "slow", function () {
			$(".modal").remove();
			$('.form-actions > img').remove();
			$('.js-btn-submit').attr('disabled', false);
			order_no = '';
		});
	});

    $('.js-money').live('blur', function(){
        var money = $(this).val().trim();
        if (validate()) {
            $(this).val(parseFloat(money).toFixed(2));
        }
    })

});

function qrcode() {
	if (order_no.length == 0) {
		return;
	}
	$.post(pay_qrcode_url, {order_no: order_no}, function(data) {
		if (data.err_code == "1000") {
			
		} else if (data.err_code == "10") {
			// 重新请求
			qrcode();
		} else if (data.err_code == "0") {
			$('.notifications').html('<div class="alert in fade alert-success">保证金充值成功</div>');
			$('.modal').animate({'margin-top': '-1000px'}, "slow", function () {
				// 支付完成跳到支付流水页
				location.href = "user.php?c=trade&a=margin_details";
			});
		}
	});
}

function validate() {
    $('.js-money').closest('.control-group').removeClass('error');
    $('.js-money').parent('.controls').children('.error-message').remove();
    var money = $('.js-money').val().trim();
    var min_money = parseFloat($('.js-money').data('min').trim());
    if (money == '') {
        $('.js-money').val('');
        $('.js-money').focus();
        $('.js-money').closest('.control-group').addClass('error');
        $('.js-money').parent('.controls').append('<p class="help-block error-message">充值金额不能为空</p>');
        return false;
    } else if (isNaN(money) || money <= 0) {
        $('.js-money').val('');
        $('.js-money').focus();
        $('.js-money').closest('.control-group').addClass('error');
        $('.js-money').parent('.controls').append('<p class="help-block error-message">充值金额填写有误</p>');
        return false;
    } else if (money < min_money) {
        $('.js-money').val('');
        $('.js-money').focus();
        $('.js-money').closest('.control-group').addClass('error');
        $('.js-money').parent('.controls').append('<p class="help-block error-message">充值金额不能小于最低限额</p>');
        return false;
    }
    return true;
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}