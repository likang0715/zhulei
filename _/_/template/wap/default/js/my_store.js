var t = '';
var click = false;
$(function() {
    window.onpopstate = function(event) {
        var back_hash = window.location.hash;
        if (back_hash == $('.accountnav > .accountnavli-active').data('hash') && click == false) {
            window.location.href = 'my_point.php#1';
        }
        click = false;
    };
    //绑定事件处理函数.
    history.pushState("", "", "");

    var index = 0;
    $('.accountnav > .accountnavli').click(function() {
        click = true;
        index = $(this).index('.accountnav > .accountnavli');
        $(this).addClass('accountnavli-active').siblings('.accountnavli').removeClass('accountnavli-active');
        $('.accountdiv').eq(index).show().siblings('.accountdiv').hide();
        if (index) {
            window.location.hash = '#amount';
        } else {
            window.location.hash = '#point';
        }
    });

    if (window.location.hash != undefined) {
        var hash = window.location.hash;
        hash = hash.toLowerCase();
        if (hash == '#point') {
            index = 0;
            $('.accountnav > .accountnavli').eq(0).trigger('click');
        } else if (hash == '#amount') {
            index = 1;
            $('.accountnav > .accountnavli').eq(1).trigger('click');
        }
        click = false;
    }

    $(window).hashchange(function(){
        var back_hash = window.location.hash;
        if (back_hash != $('.accountnav > .accountnavli-active').data('hash')) {
            window.location.href = 'my_point.php#1';
        }
    });

    $('.money').blur(function(e){
        var point2money_balance = parseFloat($('.point2money-balance').text().trim());
        var money = $(this).val().trim();
        var sales_ratio_100 = (sales_ratio / 100);
        if (money == '') {
            return false;
        }
        if (!isNaN(money) && parseFloat(money) <= point2money_balance) {
            money = parseFloat(money);
            service_fee = money * sales_ratio_100;
            $('.service-fee-money').text(service_fee.toFixed(2));
            $(this).val(money.toFixed(2));
            $('.to-money').text((money - service_fee).toFixed(2));
            $('.to-money-div').slideDown(300);
        } else {
            motify.log('提现金额输入无效');
            $(this).val('');
            $('.service-fee-money').text('0.00');
            $('.to-money-div').slideUp(300);
        }
    });

    $('.amount').blur(function(e){
        var balance = parseFloat($('.balance').text().trim());
        var amount = $('.amount').val().trim();
        var sales_ratio_100 = (sales_ratio / 100);
        if (amount == '') {
            return false;
        }
        if (!isNaN(amount) && amount != '' && parseFloat(amount) <= balance) {
            amount = parseFloat(amount);
            service_fee = amount * sales_ratio_100;
            $('.sales-ratio-money').text(service_fee.toFixed(2));
            $(this).val(amount.toFixed(2));
            $('.withdrawal-money').text((amount - service_fee).toFixed(2));
            $('.withdrawal-money-div').slideDown(300);
        } else {
            motify.log('提现金额输入无效');
            $(this).val('');
            $('.sales-ratio-money').text('0.00');
            $('.withdrawal-money-div').slideUp(300);
        }
    });

    //提现申请提交(积分兑换)
    $('.save-btn:eq(0)').click(function(e) {
        var money = $('.money').val().trim();
        var point2money_balance = $('.point2money-balance').text().trim();
        point2money_balance = parseFloat(point2money_balance);
        var bank_card = $('.bank-card').text().trim();
        if (bank_card == '') {
            motify.log('银行卡号不能为空');
            return false;
        }
        if (money == '') {
            motify.log('提现金额不能为空');
            return false;
        }
        if (isNaN(money)) {
            motify.log('提现金额输入无效');
            return false;
        }
        money = parseFloat(money);
        if (money > point2money_balance) {
            motify.log('可提现的金额不足');
            return false;
        }

        $.post(post_url, {'value': money, 'type': 'point'}, function(data) {
            if (!data.err_code) {
                motify.log(data.err_msg);
                t = setTimeout('redirect()', 1000);
            } else {
                motify.log(data.err_msg);
            }
        });
    });

    //提现申请提交
    $('.save-btn:eq(1)').click(function(e) {
        var amount = $('.amount').val().trim();
        var balance = $('.balance').val().trim();
        balance = parseFloat(balance);
        var bank_card = $('.bank-card').text().trim();
        if (bank_card == '') {
            motify.log('银行卡号不能为空');
            return false;
        }
        if (isNaN(amount)) {
            motify.log('提现金额输入无效');
            return false;
        }
        amount = parseFloat(amount);
        if (amount < balance) {
            motify.log('可提现的金额不足');
            return false;
        }

        $.post(post_url, {'value': amount, 'type': 'amount'}, function(data) {
            if (!data.err_code) {
                motify.log(data.err_msg);
                t = setTimeout('redirect()', 1000);
            } else {
                motify.log(data.err_msg);
            }
        });
    });

    $('.cancel-btn').click(function(e){
        //window.location.href = 'my_point.php';
        window.history.back();
    });
})

function redirect() {
    window.location.reload();
}