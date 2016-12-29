/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var page   = 1;
var type = 'add';
var index = 0;
$(function() {

    if (window.location.hash) {
        if (window.location.hash.replace('#', '').toLowerCase() == 'add') {
            index = 0
        } else if (window.location.hash.replace('#', '').toLowerCase() == 'log') {
            index = 1
        }
    }

    $('.ui-nav > ul > li').live('click', function (e) {
        type = $(this).data('type');
        var obj = this;
        load_page('.app__content', load_url, {page: 'clear_return_owe_' + type + '_content', 'dealer_id': dealer_id}, '', function(){
            $(obj).addClass('active').siblings('li').removeClass('active');
        });
    }).eq(index).trigger('click');

    $('.pagenavi > a').live('click', function(){
        page  = $(this).attr('data-page-num');
        type = 'log';
        var obj = this;
        load_page('.app__content', load_url, {page: 'clear_return_owe_' + type + '_content', 'p': page, 'dealer_id': dealer_id}, '', function(){
            $(obj).addClass('active').siblings('li').removeClass('active');
        });
    })

    $('.amount').live('focus', function(e) {
        $(this).closest('.control-group').removeClass('error');
        $(this).next('.error-message').remove();
    });

    $('.btn-save').live('click', function(e) {
        var amount = $('.amount').val().trim();
        var bak = $('.bak').val().trim();

        $(".amount").closest('.control-group').removeClass('error');
        $('.amount').next('.error-message').remove();
        if (isNaN(amount) || amount == '' || parseFloat(amount) <= 0) {
            $(".amount").closest('.control-group').addClass('error');
            $('.amount').after("<p class='error-message'>无效的销账金额</p>");
            return false;
        }

        $.post(clear_return_owe_url, {'dealer_id': dealer_id, 'amount': amount, 'bak': bak}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                window.location.reload();
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 2000);
        })
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
