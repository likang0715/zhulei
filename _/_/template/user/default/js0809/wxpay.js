$(function(){
	$('.js-wxpay-header-region .js-switch').click(function(){
		var nowDom = $(this);
		var wxpayStatus = $(this).hasClass('ui-switcher-on') ? 0 : 1;
		$.post('./user.php?c=payment&a=open_wxpay',{wxpay:wxpayStatus},function(result){
			if(result.err_msg == 'ok'){
				if(wxpayStatus){
					nowDom.removeClass('ui-switcher-off').addClass('ui-switcher-on');
				}else{
					nowDom.removeClass('ui-switcher-on').addClass('ui-switcher-off');
				}
			}else{
				alert((wxpayStatus ? '开启' : '关闭')+'失败！请重试。');
			}
		});
		
	});
	$('.js-change-wxpay-type').click(function() {
		if (!wxpayText.length) {
			return false;
		};
		teaLayer(1,wxpayText,'微信支付设置',function () {
			$('.wxpay-btn-'+wxpayType).addClass('ui-btn-primary').removeClass('ui-btn-blue').text("正在使用")
			$('.wxpay-alert-body .js-wxpay-change').click(function() {
				var _this = $(this);
				if ($(this).hasClass('ui-btn-primary')) {
					return false;
				} else{
					var type = $(this).attr('data-set-wxpay-type');
					_this.text("启用中");
					if (type=='unbind') {
						if (wxpayBind) {
							$("#zy_form input").val('');
							$.post('./user.php?c=payment&a=save_wxpay',$("#zy_form").serialize(),function(result){
								if(result.err_msg == 'ok'){
									teaAlert('修改成功')
									_this.addClass('ui-btn-primary').removeClass('ui-btn-blue').text("正在使用");
									$('.wxpay-btn-bind').addClass('ui-btn-blue').removeClass('ui-btn-primary').text("立即启用");
									$('.widget-image,.modal-backdrop').remove();
									window.location.reload();
								}else{
									teaAlert(result.err_msg)
									_this.text("立即启用");
									window.location.reload();
								}
					        })
						} else{
							wxpayType = "unbind";
							_this.addClass('ui-btn-primary').removeClass('ui-btn-blue').text("立即启用");
							$('.wxpay-btn-bind').addClass('ui-btn-blue').removeClass('ui-btn-primary').text("正在使用");
							$('.js-wxpay-zy').show();
							$('.js-wxpay-dx').hide();
							$('.widget-image,.modal-backdrop').remove();
						};
					} else if (type=='bind') {
						wxpayType = "bind";
						$('.wxpay-btn-unbind').addClass('ui-btn-primary').removeClass('ui-btn-blue').text("立即启用");
						_this.addClass('ui-btn-blue').removeClass('ui-btn-primary').text("正在使用");
						$('.js-wxpay-zy').show();
						$('.js-wxpay-dx').hide();
						$('.widget-image,.modal-backdrop').remove();
						teaAlert('修改成功,填写商户号和密钥后生效')
					};
				};
			});
		})
	});
    $('.js-save').click(function(){
		$('input[name="wxpay_mchid"]').val($.trim($('input[name="wxpay_mchid"]').val()));
		if($('input[name="wxpay_mchid"]').val().length == 0){
			teaAlert('请填写商户号');
			return false;
		}
		$('input[name="wxpay_key"]').val($.trim($('input[name="wxpay_key"]').val()));
		if($('input[name="wxpay_key"]').val().length == 0){
			teaAlert('请填写密钥');
			return false;
		}
		if($('input[name="wx_domain_auth"]').prop('checked') == false){
			teaAlert('您必须同意微信网页授权');
			return false;
		}
        $.post('./user.php?c=payment&a=save_wxpay',$("#zy_form").serialize(),function(result){
			if(result.err_msg == 'ok'){
				teaAlert('保存成功');
			}else{
				teaAlert(result.err_msg);
			}
			window.location.reload();
        })
    });
})
