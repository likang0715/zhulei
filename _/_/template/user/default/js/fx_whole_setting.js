/**
 * Created by Administrator on 2015/10/29.
 */
var t = '';
$(function(){
    load_page('.app__content',load_url,{page:'whole_setting_content'},'');


    //启用审核批发商
    $('.audit > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(is_required_to_audit, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭审核批发商
    $('.audit > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(is_required_to_audit, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //开启保证金模式
    $('.guidance > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(is_required_margin, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    })

    //关闭保证金模式
    $('.guidance > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(is_required_margin, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    })

    //设置店铺保证金额度
    $('.ui-btn-bond').live('click',function(e){
        var bond = parseFloat($("input[name='bond']").val());

        if(!/^\d+(\.\d+)?$/.test(bond))
        {
            alert('只能填写数字');
            return false;
        }

        $.post(update_store_bond, {'bond':bond}, function(data){
            if (data) {
                location.replace(location);
               // $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    });


    //开启保证金最低额度提醒
    $('.margin_amount > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(margin_amount, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    });

    //关闭保证金最低额度提醒
    $('.margin_amount > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(margin_amount, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    });

    //设置保证金最低额度
    $('.ui-btn-margin').live('click',function(e){
        var margin_minimum = parseFloat($("input[name='margin_minimum']").val());
        if(!/^\d+(\.\d+)?$/.test(margin_minimum))
        {
            alert('只能填写数字');
            return false;
        }

        $.post(update_margin_minimum, {'margin_minimum':margin_minimum}, function(data){
            if (data) {
                location.replace(location);
                // $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    });



    //开启排他分销
    $('.open-store > .ui-switch-off').live('click', function(e){
        var obj = this;
        $.post(open_store_whole, {'status':1}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-off').addClass('ui-switch-on');
            }
        });
    });

    //关闭排他分销
    $('.open-store > .ui-switch-on').live('click', function(e){
        var obj = this;
        $.post(open_store_whole, {'status':0}, function(data){
            if (data) {
                $(obj).removeClass('ui-switch-on').addClass('ui-switch-off');
            }
        });
    });



});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
