/**
 * Created by Administrator on 2015/10/31.
 */
var t = '';
$(function(){
    load_page('.app__content', load_url, {page:'recharge_content','store_id': store_id,'id':id}, '', function(){

    });

    //卡号每4位分隔显示
    $('.js_bank_card').live('keyup', function(){
        var value = $(this).val();
        var tmp_value = '';
        if (value.length > 4 && value[4] != '') {
            for (i in value) {
                i++;
                tmp_value += value[i-1];
                if (i > 0 && i % 4 == 0) {
                    tmp_value += ' ';
                }
            }
            value = tmp_value;
        }
        $(this).next('.js-account-pretty').text(value);
        $(this).next('.js-account-pretty').show();
    })

    $('.js_bank_card').live('blur', function(){
        $(this).next('.js-account-pretty').hide();
    })

    $("input[name='bank_card']").live('blur', function(){
        if (isNaN($("input[name='bank_card']").val())) {
            $('.widget-account-pretty').closest('.control-group').removeClass('error');
            $('.widget-account-pretty').next('.error-message').remove();

            $('.widget-account-pretty').closest('.control-group').addClass('error');
            $('.widget-account-pretty').after('<p class="help-block error-message">银行卡只能为数字</p>');
            return false;
        }
        if ($("input[name='bank_card']").val() != '') {
            $('.widget-account-pretty').closest('.control-group').removeClass('error');
            $('.widget-account-pretty').next('.error-message').remove();
        }
    })

    $("input[name='apply_recharge']").live('blur', function(){
        if (isNaN($("input[name='apply_recharge']").val()) || parseFloat($("input[name='apply_recharge']").val()) < 0) {
            $('.apply_recharge-pretty').closest('.control-group').removeClass('error');
            $('.apply_recharge-pretty').next('.error-message').remove();

            $('.apply_recharge-pretty').closest('.control-group').addClass('error');
            $('.apply_recharge-pretty').after('<p class="help-block error-message">申请额度只能为数字不能小于零</p>');
            return false;
        }
        if ($("input[name='apply_recharge']").val() != '' && parseFloat($("input[name='apply_recharge']").val()) > 0) {
            $('.apply_recharge-pretty').closest('.control-group').removeClass('error');
            $('.apply_recharge-pretty').next('.error-message').remove();
        }
    })

    $("input[name='phone']").live('blur', function(){
        if (isNaN($("input[name='phone']").val()) || $("input[name='phone']").val().length < 11) {
            $('.phone-pretty').closest('.control-group').removeClass('error');
            $('.phone-pretty').next('.error-message').remove();

            $('.phone-pretty').closest('.control-group').addClass('error');
            $('.phone-pretty').after('<p class="help-block error-message">手机号码填写错误</p>');
            return false;
        }
        if ($("input[name='phone']").val() != '' && parseFloat($("input[name='phone']").val()) > 0) {
            $('.phone-pretty').closest('.control-group').removeClass('error');
            $('.phone-pretty').next('.error-message').remove();
        }
    })

    $('.js-submit-btn').live('click', function(){
        var obj = this;
        //var bank_id = $("select[name='bank']").val();
        var opening_bank = $("input[name='opening_bank']").val();
        var bank_card = $("input[name='bank_card']").val();
        var bank_card_user = $("input[name='bank_card_user']").val();
        var phone = $("input[name='phone']").val();
        var apply_recharge = $("input[name='apply_recharge']").val();

        var store_id = $(".supplier_id").data('storeid');
        var redirect_url = bond_log_url + "&store_id="+store_id;
        var flag = true;
        $("input[name='opening_bank']").closest('.control-group').removeClass('error');
        $("input[name='opening_bank']").next('.error-message').remove();
        if (opening_bank == '') {
            flag = false;
            $("input[name='opening_bank']").closest('.control-group').addClass('error');
            $("input[name='opening_bank']").after('<p class="help-block error-message">不能为空</p>');
        }
        $('.widget-account-pretty').closest('.control-group').removeClass('error');
        $('.widget-account-pretty').next('.error-message').remove();
        if (bank_card == '') {
            flag = false;
            $('.widget-account-pretty').closest('.control-group').addClass('error');
            $('.widget-account-pretty').after('<p class="help-block error-message">不能为空</p>');
        }
        if (isNaN($("input[name='bank_card']").val())) {
            flag = false;
            $('.widget-account-pretty').closest('.control-group').addClass('error');
            $('.widget-account-pretty').after('<p class="help-block error-message">银行卡只能为数字</p>');
        }

        $("input[name='bank_card_user']").closest('.control-group').removeClass('error');
        $("input[name='bank_card_user']").next('.error-message').remove();
        if (bank_card_user == '') {
            flag = false;
            $("input[name='bank_card_user']").closest('.control-group').addClass('error');
            $("input[name='bank_card_user']").after('<p class="help-block error-message">不能为空</p>');
        }

        $("input[name='phone']").closest('.control-group').removeClass('error');
        $("input[name='phone']").next('.error-message').remove();
        if (phone == '') {
            flag = false;
            $("input[name='phone']").closest('.control-group').addClass('error');
            $("input[name='phone']").after('<p class="help-block error-message">不能为空</p>');
        }

        $("input[name='apply_recharge']").closest('.control-group').removeClass('error');
        $("input[name='apply_recharge']").next('.error-message').remove();
        if (apply_recharge == '') {
            flag = false;
            $("input[name='apply_recharge']").closest('.control-group').addClass('error');
            $("input[name='apply_recharge']").after('<p class="help-block error-message">不能为空</p>');
        }

        if (flag) {
            $.post(withdrawal_url, {'store_id': store_id, 'id':id,'opening_bank': opening_bank, 'bank_card': bank_card, 'bank_card_user': bank_card_user, 'phone': phone, 'apply_recharge': apply_recharge}, function(data) {
                if (data) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + '信息提交成功' + '</div>');

                    setTimeout('location.replace("'+ redirect_url +'")',2000);//延时2秒
                }
                else
                {
                    $('.notifications').html('<div class="alert in fade alert-error">' + '信息提交失败' + '</div>');
                    location.replace(location);
                }
            })
        }
    })
});

function msg_hide(redirect, url) {
    if (redirect) {
        window.location.href = url;
    }
    $('.notifications').html('');
    clearTimeout(t);
}

