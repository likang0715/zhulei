/**
 * Created by pigcms-89 on 2016/01/09.
 */
$(function() {

	// 消费input-radio切换效果
	$("input[name=order_consume]").on("change", function(){
		var v = $(this).val();
		$("input[name=order_consume]").parents(".widget-app-board").removeClass("check-on");
		$("input[name=order_consume]:eq("+v+")").parents(".widget-app-board:first").addClass("check-on");
	});

	// 价值check-box 选中效果
	$("input[name=is_percent],input[name=is_limit]").on("change", function(){
		var v = $(this).attr("checked");
		var self = $(this);
		if (v == 'checked') {
			self.parents(".widget-app-board:first").addClass("check-on");
		} else {
			self.parents(".widget-app-board:first").removeClass("check-on");
		}
	});


	$(".js-title-list li").on("click", function(){
		var self  = $(this);
		var v = $(this).index();
		self.siblings(".active").removeClass("active").end().addClass("active");

		$(".points-section").removeClass("section-on");
		$(".points-section:eq("+v+")").addClass('section-on');

	});

	// 签到input-radio切换效果
	$("input[name=sign_type]").on("change", function(){
		var v = $(this).val();
		$("input[name=sign_type]").parents(".widget-app-board").removeClass("check-on");
		$("input[name=sign_type]:eq("+v+")").parents(".widget-app-board:first").addClass("check-on");
	});

	// init
	function location_page(mark,dom){
		var mark_arr = mark.split('/');
		$(".points-section").removeClass("section-on");
		switch(mark_arr[0]){
			case '#config_trade':
				$('.js-title-list '+mark_arr[0]).trigger("click");
				break;
			case '#config_worth':
				$('.js-title-list '+mark_arr[0]).trigger("click");
				break;
			case '#config_checkin':
				$('.js-title-list '+mark_arr[0]).trigger("click");
				break;
			default:
				mark_arr[0] = '#config_spread';
				$('.js-title-list '+mark_arr[0]).trigger("click");
				break;
		}
	}
	location_page(location.hash);

	var checkPointsConfig = function(formObj) {

		var unSetType = ['type', 'order_consume', 'is_percent', 'is_limit', 'sign_type'];

		for (var i in formObj) {

			var value = formObj[i];

			/* 禁止所有input输入数字以外值 */
			if ($.inArray(i, unSetType) < 0) {
				if (value != '' && !/^\d+(\.\d+)?$/.test(value)) {
					layer_tips(1, '不允许输入非数字符串或负值');
					$('input[name="'+i+'"]').focus();
					return false;
				}
			}
			if (i == 'order_consume') {
				var consume = value;
			}
			switch (i) {
				case 'proport_money': /* 消费送积分的 金额数 */
					if (consume==1 && value <= 0) {
						layer_tips(1, '消费送积分价格不能为 0');
						$('input[name="'+i+'"]').focus();
						return false;
					}
					break;
			}
		}

		return true;
	};

	// 提交修改 分别为四个form
	$('.js-config-save').click(function(){

		var nowDom = $(this);
		var formObj = {};
		var form = $('.section-on .section-form').serializeArray();

		$.each(form,function(i,field){
			formObj[field.name] = field.value;
		});

		layer.closeAll();
		
		if (!checkPointsConfig(formObj)) {
			return;
		}

		$.post(store_points_edit, formObj, function(result){
			if (typeof(result) == 'object') {
			    if (result.err_code) {
			        layer_tips(1, result.err_msg);
			    } else {
			        layer_tips(0, result.err_msg);
			        setTimeout(function(){
				        window.location.reload();
			        }, 500);
			    }
			} else {
			    layer_tips(1, '系统异常，请重试提交');
			}
		});
    });

	// 积分配置-多级推广开启
    $('.js-config-subscribe').bind('click', function(){
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(set_config_subscribe, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
				if (status) {
					layer_tips(0, '开启完毕');
				} else {
					layer_tips(1, '关闭成功');
				}
			}
		})
	});

	// 积分配置-分享得积分开启
    $('.js-config-share').bind('click', function(){
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(set_config_share, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
				if (status) {
					layer_tips(0, '开启完毕');
				} else {
					layer_tips(1, '关闭成功');
				}
			} else {
				layer_tips(1, data.err_msg);
			}
		})
	});

	// 积分配置-积分兑换开启
    $('.js-config-offset').bind('click', function(){
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(set_config_offset, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
				if (status) {
					layer_tips(0, '开启完毕');
				} else {
					layer_tips(1, '关闭成功');
				}
			}
		})
	});

    // 积分配置-签到开启
    $('.js-config-sign').bind('click', function(){
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(set_config_sign, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
				if (status) {
					layer_tips(0, '开启完毕');
				} else {
					layer_tips(1, '关闭成功');
				}
			}
		})
	});

})