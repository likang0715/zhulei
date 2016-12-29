var t = '';
$(function(){
	load_page('.app__content',load_url,{page:'setting_supplier_content'},'');


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
	
	    //开启渠道二维码
    /*$('.setting_canal_qrcode > .ui-switch-off').live('click', function(e) {
        var obj = this;
        $.post(setting_canal_qrcode_url, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })
    //关闭渠道二维码
    $('.setting_canal_qrcode> .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(setting_canal_qrcode_url, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })*/


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

    $('.fans-list').live('click', function(e) {
        $('.modal-backdrop,.modal').remove();
        $('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');
        modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="' + fans_list_url + '" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
        $('body').append(modalDom);
        modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
    });
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}