var t = '';
$(function() {

    $('.amount').blur(function(e){
        var balance = parseFloat($('.balance').text().trim());
        var amount = $('.amount').val().trim();
        if (amount == '') {
            return false;
        }
        if (!isNaN(amount) && amount != '' && parseFloat(amount) <= balance) {
            amount = parseFloat(amount);
            $(this).val(amount.toFixed(2));
        } else {
            motify.log('金额输入无效');
            $(this).val('');
        }
    });

    //提现申请提交
    $('.save-btn').click(function(e) {
        var amount = $('.amount').val().trim();
        var balance = $('.balance').val().trim();
        balance = parseFloat(balance);
        var bank_card = $('.bank-card').text().trim();
        if (bank_card == '') {
            motify.log('银行卡号不能为空');
            return false;
        }
        if (isNaN(amount) || amount <= 0) {
            motify.log('金额输入无效');
            return false;
        }
        amount = parseFloat(amount);
        if (amount < balance) {
            motify.log('可返还的金额不足');
            return false;
        }

        $.post(post_url, {'amount': amount}, function(data) {
            if (!data.err_code) {
                motify.log(data.err_msg);
                t = setTimeout('redirect()', 1000);
            } else {
                motify.log(data.err_msg);
            }
        });
    });

    $('.cancel-btn').click(function(e){
        window.location.href = 'my_point.php#1';
    });
})

function redirect() {
    window.location.reload();
}