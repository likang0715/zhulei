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
$(function() {

    load_page('.app__content',load_url,{page:'point_exchange_content'},'', function () {});

    $('.target').live('click', function(e) {
        var target = $(this).val();
        //已兑换的积分
        var exchanged = $(this).data('checked');
        $('.point2other').text(exchanged);
        if ($('.target-' + target + ':visible').length == 0) {
            $('.targets').hide(300);
            $('.target-' + target).show(300);
        }
    })

    $("input[name='sync_withdrawal']").live('click', function(e) {
        var point = $.trim($("input[name='point']").val());
        $('.js-btn-submit').attr('disabled', true);
        if ($(this).is(':checked')) {
            $('.withdrawal-info').slideDown();

            var sync_withdrawal = 1;
            $.post(exchange_url, {'type': 'calculate', 'point': parseFloat(point), 'sync_withdrawal': sync_withdrawal}, function(data) {
                if (data > 1) {
                    html(data);
                }
                $('.js-btn-submit').attr('disabled', false);
            });
        } else {
            $('.withdrawal-info').slideUp();

            var sync_withdrawal = 0;
            $.post(exchange_url, {'type': 'calculate', 'point': parseFloat(point), 'sync_withdrawal': sync_withdrawal}, function(data) {
                if (data > 0) {
                    html(data);
                }
                $('.js-btn-submit').attr('disabled', false);
            });
        }
    })

    $('.js-btn-submit').live('click', function(){
        if (validate()) {
            var target = $('.target:checked').val();
            var point = parseFloat($.trim($('.js-point').val())).toFixed(2);
            var sync_withdrawal = $("input[name='sync_withdrawal']:checked").val();
            sync_withdrawal = sync_withdrawal || 0;
            $.post(exchange_url, {'point': point, 'sync_withdrawal': sync_withdrawal, 'target': target}, function(data) {
                if (data.err_code != 0) {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    load_page('.app__content',load_url,{page:'point_exchange_content'},'');
                }
                t = setTimeout('msg_hide()', 3000);
            })
        }
    })

    $('.js-point').live('blur', function(){
        if ($('.target:checked').val() == undefined) {
            return false;
        }
        var point = $.trim($(this).val());
        var sync_withdrawal = $("input[name='sync_withdrawal']:checked").val();
        sync_withdrawal = sync_withdrawal || 0;
        $('.js-btn-submit').attr('disabled', true);
        if (validate()) {
            $(this).val(parseFloat(point).toFixed(2));
            $.post(exchange_url, {'type': 'calculate', 'point': parseFloat(point), 'sync_withdrawal': sync_withdrawal}, function(data) {
                $('.js-btn-submit').attr('disabled', false);
                html(data);
            });
        }
    })

});

function html(data) {
    $('fieldset > .last').remove();
    var html = '<div class="control-group last">';
    html += '<label class="control-label" style="padding-top: 0;">兑换金额：</label>';
    html += '<div class="controls">';
    html += '<span style="color: green;font-size: 20px">' + data + '</span> 元';
    html += '</div>';
    html += '</div>';
    $('fieldset').append(html);
}

function validate() {
    $('.js-point').closest('.control-group').removeClass('error');
    $('.js-point').parent('.controls').children('.error-message').remove();
    var point = $.trim($('.js-point').val());
    var max_point = parseFloat($.trim($('.js-point').data('max')));
    if (point == '') {
        $('.js-point').val('');
        $('.js-point').focus();
        $('.js-point').closest('.control-group').addClass('error');
        $('.js-point').parent('.controls').append('<p class="help-block error-message">兑换' + point_alias + '不能为空</p>');
        return false;
    } else if (isNaN(point) || parseFloat(point) <= 0) {
        $('.js-point').val('');
        $('.js-point').focus();
        $('.js-point').closest('.control-group').addClass('error');
        $('.js-point').parent('.controls').append('<p class="help-block error-message">兑换' + point_alias + '填写有误</p>');
        return false;
    } else if (parseFloat(point) > max_point) {
        $('.js-point').val('');
        $('.js-point').focus();
        $('.js-point').closest('.control-group').addClass('error');
        $('.js-point').parent('.controls').append('<p class="help-block error-message">不能大于可兑换' + point_alias + '</p>');
        return false;
    }
    return true;
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}