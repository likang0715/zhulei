var t = '';
var product_id = 0;
var flag = true;
var is_fx_products = 0;
var fx_processed = false;
var tmp_products = 0;
var tmp_last_product_id = 0;

$(function(){
	load_page('.app__content',load_url,{page:'setting_content'},'');


    $("input[name='qcode']").live('click',function(){
        var qcode = $(this).val();
        if(qcode == 1){
            var obj = this;
            $.post(setting_canal_qrcode_url, {'status':1}, function(data){
                if (data) {
                }
            });

            $('.widget-app-qcode').show();
        }else{
            var obj = this;
            $.post(setting_canal_qrcode_url, {'status':0}, function(data){
                if (data) {
                }
            });
            $('.widget-app-qcode').hide();
        }
    });


    //启用分销商等级
    $('.drp-degree > .ui-switch-off').live('click', function(e) {
        var obj = this;
        $.post(open_drp_degree_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    });

    //关闭分销商等级
    $('.drp-degree > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_degree_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    });

    //保存扣分规则
    $('.save-btn5').live('click', function(e) {
        $(this).next('.error').remove();
        var drp_deduct_point_month = $.trim($("input[name='drp_deduct_point_month']").val());
        drp_deduct_point_month = !isNaN(drp_deduct_point_month) && parseInt(drp_deduct_point_month) || 0;
        var drp_deduct_point_sales = $.trim($("input[name='drp_deduct_point_sales']").val());
        drp_deduct_point_sales = !isNaN(drp_deduct_point_sales) && parseFloat(drp_deduct_point_sales) || 0;
        var drp_deduct_point = $.trim($("input[name='drp_deduct_point']").val());
        drp_deduct_point = !isNaN(drp_deduct_point) && parseInt(drp_deduct_point) || 0;

        if (drp_deduct_point_month <= 0) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 86px">* 连续月数填写有误</div>');
            return false;
        }
        $("input[name='drp_deduct_point_month']").val(drp_deduct_point_month);
        if (drp_deduct_point_sales <= 0) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 264px">* 销售额填写有误</div>');
            return false;
        }
        $("input[name='drp_deduct_point_sales']").val(drp_deduct_point_sales.toFixed(2));
        if (drp_deduct_point <= 0) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 393px">* 扣除积分填写有误</div>');
            return false;
        }
        $("input[name='drp_deduct_point']").val(drp_deduct_point);

        $.post(open_drp_degree_url, {'type': 'deduct_point_rule', 'drp_deduct_point_month': drp_deduct_point_month, 'drp_deduct_point_sales': drp_deduct_point_sales, 'drp_deduct_point': drp_deduct_point}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    });

    //启用分销团队
    $('.drp-team > .ui-switch-off').live('click', function(e) {
        var obj = this;
        $.post(open_drp_team_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    });

    //关闭分销团队
    $('.drp-team > .ui-switch-on').live('click', function(e) {
        var obj = this;
        $.post(open_drp_team_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    });

    //启用分销商审核
    $('.approve > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_drp_approve_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭分销商审核
    $('.approve > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_approve_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //启用分销引导
    $('.guidance > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_drp_guidance_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭分销引导
    $('.guidance > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_guidance_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })
	
	//启用粉丝终身制
    $('.fans_lifelong > .ui-switch-off').live('click', function(e){
		
		if(confirm('确认开启该配置？')){
			var obj = this;
			$.post(fans_lifelong_url, {'status':1}, function(data){
				if (data) {
					$(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
				}
			});
		}
    })


    $('.is_fanshare_drp > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(fanshare_drp_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })
	
	//关闭粉丝终身制
    $('.is_fanshare_drp > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(fanshare_drp_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })



    //允许分销商修改店铺名称
    $('.update_name > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(drp_update_store_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //禁止分销商修改店铺名称
    $('.update_name > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(drp_update_store_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //关闭粉丝终身制
    $('.fans_lifelong > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(fans_lifelong_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })


    //启用分销限制
    $('.limit > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_drp_limit_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭分销限制
    $('.limit > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_limit_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //启用店铺装修
    $('.drp-diy-store > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_drp_diy_store_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭店铺装修
    $('.drp-diy-store > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_diy_store_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //启用分销定价
    $('.drp-setting-price > .ui-switch-off').live('click', function(e) {
        var obj = this;
        $.post(open_drp_setting_price_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })
    //关闭分销定价
    $('.drp-setting-price > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_setting_price_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //关注公众号
    $('.drp-subscribe > .ui-switch-off').live('click', function(e) {
        var obj = this;
        $.post(open_drp_subscribe_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })
    //关注公众号
    $('.drp-subscribe > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_drp_subscribe_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //自动分销（关注公众号）
    $('.drp-subscribe-auto > .ui-switch-off').live('click', function(e) {
        var obj = this;
        $.post(open_drp_subscribe_auto_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })
    //自动分销（关注公众号）
    $('.drp-subscribe-auto > .ui-switch-on').live('click', function(e) {
        var obj = this;
        $.post(open_drp_subscribe_auto_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //保存
    $('.save-btn').live('click', function(e) {
        $(this).next('.error').remove();
        var drp_limit_buy = $.trim($('.drp-limit-buy').val());
        var drp_limit_share = $.trim($('.drp-limit-share').val());
        var drp_limit_condition = $('.drp-limit-condition:checked').val();

        if (($('.drp-limit-buy').val() == '' && $('.drp-limit-share').val() == '') || ($('.drp-limit-buy').val() == 0 && $('.drp-limit-share').val() == 0)) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">必须填写一个条件</div>');
            return false;
        }
        if (isNaN(drp_limit_buy) || parseFloat(drp_limit_buy) < 0) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">消费金额填写有误</div>');
            return false;
        }
        if (isNaN(drp_limit_share) || parseFloat(drp_limit_share) < 0) {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">分享次数填写有误</div>');
            return false;
        }

        $.post(save_drp_limit_url, {'drp_limit_buy': drp_limit_buy, 'drp_limit_share': drp_limit_share, 'drp_limit_condition': drp_limit_condition}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })

    $('.save-withdrawal-btn').live('click', function() {
        $(this).next('.error').remove();
        var drp_withdrawal_min = $('.drp-withdrawal-min').val();
        if (isNaN(drp_withdrawal_min) || parseFloat(drp_withdrawal_min) < 0 || drp_withdrawal_min == '') {
            $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">最低额填写有误</div>');
            return false;
        }

        $.post(drp_withdrawal_min_url, {'drp_withdrawal_min': drp_withdrawal_min}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    });

    //分销定价设置保存
    $('.save-btn2').live('click', function() {
        var setting = $("input[name='unified_price_setting']:checked").val();

        $.post(save_unified_price_setting_url, {'setting': setting}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })

    //申请分销商关注公众号模板消息设置保存
    $('.save-btn1').live('click', function() {
        var reg_drp_subscribe_tpl = $('.reg-drp-subscribe-tpl').val();
        var reg_drp_subscribe_img = $('.preview1').attr('src');
        $.post(reg_drp_subscribe_tpl_url, {'reg_drp_subscribe_tpl': reg_drp_subscribe_tpl, 'reg_drp_subscribe_img': reg_drp_subscribe_img}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        });
    })


    //申请分销商关注公众号模板消息设置保存
    $('.save-btn-can').live('click', function() {
        var canal_qrcode_tpl = $('.canal_qrcode-tpl').val();
        var canal_qrcode_img = $('.preview1').attr('src');
        $.post(canal_qrcode_tpl_url, {'canal_qrcode_tpl': canal_qrcode_tpl, 'canal_qrcode_img': canal_qrcode_img}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        });
    })

    //关注公众号模板消息设置保存
    $('.save-btn3').live('click', function() {
        var drp_subscribe_tpl = $('.drp-subscribe-tpl').val();
        var drp_subscribe_img = $('.preview2').attr('src');
        $.post(drp_subscribe_tpl_url, {'drp_subscribe_tpl': drp_subscribe_tpl, 'drp_subscribe_img': drp_subscribe_img}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        });
    });

    $('.drp-limit-buy').live('blur', function(e) {
        var drp_limit_buy = $.trim($(this).val());
        if (isNaN(drp_limit_buy) || parseFloat(drp_limit_buy) < 0) {
            $('.save-btn').after('<div class="error" style="color:#b94a48;margin-left: 30px">消费金额填写有误</div>');
            return false;
        }
        if ($(this).val() != '' && !isNaN($(this).val())) {
            $(this).val(parseFloat(drp_limit_buy).toFixed(2));
        }
    })
    $('.drp-limit-share').live('blur', function(e) {
        var drp_limit_share = $.trim($(this).val());
        if (isNaN(drp_limit_share) || parseFloat(drp_limit_share) < 0) {
            $('.save-btn').after('<div class="error" style="color:#b94a48;margin-left: 30px">分享次数填写有误</div>');
            return false;
        }
    })
    $('.drp-limit-buy').live('focus', function(e) {
        $('.save-btn').next('.error').remove();
    })
    $('.drp-limit-share').live('focus', function(e) {
        $('.save-btn').next('.error').remove();
    })

    $('.default-img1').live('click', function(e) {
        var img = $(this).data('img');
        $('.preview1').attr('src', img);
    })

    $('.default-img2').live('click', function(e) {
        var img = $(this).data('img');
        $('.preview2').attr('src', img);
    })

    $('.default-img3').live('click', function(e) {
        var img = $(this).data('img');
        $('.preview3').attr('src', img);
    })

    $('.upload-img1').live('click', function(e) {
        upload_pic_box(1,true,function(pic_list){
            if(pic_list.length > 0){
                for(var i in pic_list){
                    var list_size = $('.js-picture-list .sort').size();
                    if(list_size > 1) {
                        layer_tips(1,'封面图片最多支持 1 张');
                        return false;
                    } else {
                        $('.preview1').attr('src', pic_list[i]);
                    }
                }
            }
        },1);
    })

    $('.upload-img2').live('click', function(e) {
        upload_pic_box(1,true,function(pic_list){
            if(pic_list.length > 0){
                for(var i in pic_list){
                    var list_size = $('.js-picture-list .sort').size();
                    if(list_size > 1) {
                        layer_tips(1,'封面图片最多支持 1 张');
                        return false;
                    } else {
                        $('.preview2').attr('src', pic_list[i]);
                    }
                }
            }
        },1);
    })

    $('.upload-img3').live('click', function(e) {
        upload_pic_box(1,true,function(pic_list){
            if(pic_list.length > 0){
                for(var i in pic_list){
                    var list_size = $('.js-picture-list .sort').size();
                    if(list_size > 1) {
                        layer_tips(1,'封面图片最多支持 1 张');
                        return false;
                    } else {
                        $('.preview3').attr('src', pic_list[i]);
                    }
                }
            }
        },1);
    })

    $('.drp-profit').live('blur', function(e) {
        var drp_profit = $.trim($(this).val());
        if (drp_profit == '' || isNaN(drp_profit)) {

        } else {
            $('.save-fx-btn').next('.error').remove();
            drp_profit = parseFloat(drp_profit).toFixed(2);
            $(this).val(drp_profit);
        }
    })

    $('.save-fx-btn').live('click', function(e){
        button_box($(this), e, 'bottom', 'confirm', '确定保存分润配置？', function(){
            var save_original_setting = 0;
            var unified_profit = 0;
            tmp_last_product_id = last_product_id;
            tmp_products = products;

            if ($('.save-original-setting:checked').val()) {
                tmp_products = products - custom_drp_products;
                tmp_last_product_id = custom_drp_last_product_id;
                save_original_setting = 1;
            };
            is_fx_products = 0;
            fx_processed = false;
            var drp_profit_1 = $.trim($('.drp-profit-1').val());
            var drp_profit_2 = $.trim($('.drp-profit-2').val());
            var drp_profit_3 = $.trim($('.drp-profit-3').val());
            if ($('.unified-profit:checked').val()) {
                unified_profit = 1;
            }
            $(this).next('.error').remove();
            if (drp_profit_1 == '' || isNaN(drp_profit_1)) {
                $('.drp-profit-1').focus();
                $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">* 一级分润填写有误！</div>');
                return false;
            } else if (drp_profit_2 == '' || isNaN(drp_profit_2)) {
                $('.drp-profit-2').focus();
                $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">* 二级分润填写有误！</div>');
                return false;
            } else if (drp_profit_3 == '' || isNaN(drp_profit_3)) {
                $('.drp-profit-3').focus();
                $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">* 三级分润填写有误！</div>');
                return false;
            } else {
                drp_profit_total = parseFloat(drp_profit_1) + parseFloat(drp_profit_2) + parseFloat(drp_profit_3);
                if (drp_profit_total >= 100) {
                    $(this).after('<div class="error" style="color:#b94a48;margin-left: 30px">* 各级分润相加不能大于100%，<br/>建议设置小于60%！</div>');
                    return false;
                }
            }

            var html = '';
            html = '<div class="modal-backdrop in"></div>';
            html += '<div class="modal hide widget-product in" aria-hidden="false" style="display: block; margin-top: -0;">';
            html += '		<div class="modal-header ">';
            html += '			<a class="close" data-dismiss="modal">×</a>';
            html += '			<h3 class="title">批量设置分销商品';
            html += '			</h3>';
            html += '		</div>';
            html += '		<div class="modal-body">';
            html += '           <div class="loading alert" style="font-size: 12px;text-align: center;margin-bottom: 10px;">';
            html += '               <img src="' + load_image_url + '" style="vertical-align:middle;" /> <span>处理中<span style="color:green;">（<span class="product-num" style="color: red;">' + tmp_products + '</span>/<span class="processed">0</span>）</span>... ，耐心等待，请勿关闭或刷新！</span>';
            html += '           </div>';
            html += '			<table class="ui-table">';
            html += '				<thead>';
            html += '					<tr>';
            html += '                       <th>ID</th>';
            html += '                       <th>图片</th>';
            html += '						<th>商品</th>';
            html += '						<th width="60">状态</th>';
            html += '						<th width="50">编辑</th>';
            html += '					</tr>';
            html += '				</thead>';
            html += '				<tbody>';
            html += '				</tbody>';
            html += '			</table>';
            html += '       </div>';
            html += '       <div class="modal-footer">';
            html += '           <div class="left">* 温馨提示：自营商品以零售价、批发商品以批发利润做为分润参考。</div>';
            html += '       </div>';
            html += '</div>';
            if ($('.widget-product').length == 0) {
                $('body').append(html);
            }

            post(0, {
                'drp_profit_1': parseFloat(drp_profit_1),
                'drp_profit_2': parseFloat(drp_profit_2),
                'drp_profit_3': parseFloat(drp_profit_3),
                'unified_profit': parseInt(unified_profit),
                'save_original_setting': parseInt(save_original_setting)
            });
        });
    });

    $('.modal-header > .close').live('click', function(){
        if (fx_processed) {
            $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
                $('.modal-backdrop,.modal').remove();
                if ($('.select2-display-none').length > 0) {
                    $('.select2-display-none').remove();
                }
                $('.js-express-goods').removeClass('express-active');
            });
        } else {
            $('.notifications').html('<div class="alert in fade alert-error">正在设置分销商品，请在处理完成后再关闭窗口。</div>');
            t = setTimeout('msg_hide()', 3000);
        }
    })

    $('.fans-list').live('click', function(e) {
        $('.modal-backdrop,.modal').remove();
        $('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');
        modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="' + fans_list_url + '" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
        $('body').append(modalDom);
        modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
    });
});

function post(product_id, data_obj)
{
    $.ajax({
        type: "POST",
        dataType: "json",
        url: drp_product_setting_url,
        timeout: 80000, //ajax请求超时时间80秒
        data: {
            'time': 3,
            'product_id': product_id,
            'drp_profit_1': data_obj.drp_profit_1,
            'drp_profit_2': data_obj.drp_profit_2,
            'drp_profit_3': data_obj.drp_profit_3,
            'unified_profit': data_obj.unified_profit,
            'save_original_setting': data_obj.save_original_setting
        }, //3秒后无论结果服务器都返回数据
        success: function(data) {
            //从服务器得到数据，显示数据并继续查询
            if (data.err_code == 0) {
                is_fx_products++;
                $('.processed').text(is_fx_products);
                tr_html = '';
                tr_html += '					<tr>';
                tr_html += '						<td>' + data.err_msg.product_id + '</td>';
                tr_html += '						<td><img src="' + data.err_msg.image + '" width="50" height="50" /></td>';
                tr_html += '						<td>' + data.err_msg.name;
                if (parseInt(data.err_msg.supplier_id) > 0) {
                    tr_html += '                        <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">批发</i>';
                } else {
                    tr_html += '                        <i class="platform-tag" style="background-color: green;padding: 0px 2px 0px 3px;">自营</i>';
                }
                tr_html += '                            <br/>';
                tr_html += '                            <span class="price">零售价：' + data.err_msg.price + '元</span>';
                if (data_obj.unified_profit == 1) {
                    tr_html += '                        <span class="profit">直销利润：' + data.err_msg.profit + '元</span>';
                }
                if (parseInt(data.err_msg.supplier_id) > 0) {
                    tr_html += '                        <span class="wholesale-profit">批发利润：' + data.err_msg.wholesale_profit + '元</span>';
                }
                tr_html += '                            <br/>';
                tr_html += '                            <span class="cost">1级成本：' + data.err_msg.drp_level_1_cost_price + '元，</span>';
                tr_html += '                            <span class="cost">2级成本：' + data.err_msg.drp_level_2_cost_price + '元，</span>';
                tr_html += '                            <span class="cost">3级成本：' + data.err_msg.drp_level_3_cost_price + '元</span>';
                tr_html += '                        </td>';
                tr_html += '						<td class="green">' + data.err_msg.status + '</td>';
                tr_html += '						<td class="green"><a href="' + edit_fx_url + '&id=' + data.err_msg.product_id + '" target="_blank">编辑</a></td>';
                tr_html += '                   </tr>';
                $('.modal-body > table > tbody').prepend(tr_html);
                if (tmp_last_product_id != parseInt(data.err_msg.product_id)) {
                    post(data.err_msg.product_id, data_obj);
                } else {
                    fx_processed = true;
                    $('.loading').fadeOut(300);
                    td_html = '<img src="' + success_image_url + '" style="vertical-align:top;" width="20" /> <span style="padding-top: 2px;display: inline-block;">处理完成<span style="color:green;">（<span class="product-num" style="color: red;">' + tmp_products + '</span>/<span class="processed">' + is_fx_products + '</span>）</span>，分销利润请参考下面各级利润！</span>';
                    $('.loading').html(td_html);
                    $('.loading').fadeIn(300);
                    $('.product-num').css('color', 'green');
                }
            }
        },
        //Ajax请求超时，继续查询
        error: function(XMLHttpRequest, textStatus) {
            if (textStatus == "timeout") {
                post(product_id, data_obj)
            }
        }
    });
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}