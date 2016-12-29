<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>提现账户信息</title>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/my_store_withdrawal.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>css/font-awesome.min.css"/>
    <script src="<?php echo $config['site_url']; ?>/static/js/jquery.min.js"></script>
    <script src="<?php echo TPL_URL; ?>js/jquery.ba-hashchange.js"></script>
    <script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
    <script type="text/javascript">
        var type = "<?php echo !empty($_GET['type']) ? $_GET['type'] : 'amount'?>";
    </script>
    <style type="text/css">
        html {
            background: #f5f5f5;
        }

        .alert {
            padding: 8px 35px 8px 14px;
            margin-bottom: 20px;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
            background-color: #fcf8e3;
            border: 1px solid #fbeed5;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            line-height: 17px;
        }

        .alert, .alert h4 {
            font-size: 12px;
            color: #666;
        }

        .text-strong {
            color: #FF6600;
        }

        .buesstido-inp {
            border-radius: 4px;
            font-family: "微软雅黑";
            width: calc(100% - 100px);
            width: -webkit-calc(100% - 85px);
            border: solid 1px #e1e1e1;
            height: auto;
            line-height: 25px;
            background: none;
            padding: 5px 5px;
        }

        .buesstido-sel {
            height: 38px;
            padding-left: 5px;
            width: -webkit-calc(100% - 73px);
        }

        .buesstido-tit {
            line-height: 36px;
        }
        .cancel-btn {
            margin-top: 0px;
            background-color: lightgrey;
        }
    </style>
    <script type="text/javascript">
        var t = '';
        var withdrawal_type = 0
        var index = parseInt("<?php echo $store['withdrawal_type']; ?>");
        var type = "<?php echo $_GET['type']; ?>";
        var click = false;
        $(function () {

            if ($("input[name='bank_card']").val() != '') {
                formatBankNo();
            }
            var card_user_label = ['持卡用户', '公司名称'];
            $('.accountnav > .accountnavli').click(function (e) {
                click = true;
                var desc = ['1. 请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责；<br>2. 只支持提现到银行借记卡，<span class="text-strong">不支持信用卡和存折</span>。提现审核周期为3个工作日；', '1. 请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责；<br>2. 只支持提现到的公司银行卡账户，<span class="text-strong">不支持信用卡和存折</span>，提现审核周期为1个工作日；<br>3. 准确填写银行开户许可证上的公司名称，否则无法提现；']
                index = $(this).index('.accountnav > .accountnavli');
                $(this).addClass('accountnavli-active').siblings('.accountnavli').removeClass('accountnavli-active');
                $('.card-user-label').text(card_user_label[index]);
                $('.alert').html(desc[index]);
                withdrawal_type = index;
                window.location.hash = index;
            })

            if (window.location.hash != undefined) {
                var hash = window.location.hash;
                hash = hash.toLowerCase();
                if (hash == '#0') {
                    index = 0;
                    $('.accountnav > .accountnavli').eq(0).trigger('click');
                } else {
                    index = 1;
                    $('.accountnav > .accountnavli').eq(1).trigger('click');
                }
                click = false;
            }

            $('.save-btn').click(function(e){
                var bank_id = $(".bank_id").val();
                var opening_bank = $("input[name='opening_bank']").val().trim();
                var bank_card = $("input[name='bank_card']").val().trim();
                var bank_card_user = $("input[name='bank_card_user']").val().trim();
                bank_card = bank_card.split(' ').join('');
                if (!bank_id) {
                    motify.log('请选择发卡银行');
                    return false;
                } else if (opening_bank == '') {
                    motify.log('请输入开户银行');
                    return false;
                } else if (bank_card == '') {
                    motify.log('请输入银行卡号');
                    return false;
                } else if (bank_card_user == '') {
                    motfiy.log('请输入' + card_user_label[index]);
                }

                $.post("my_store.php?action=account&store_id=<?php echo $store['store_id']; ?>", {'bank_id': bank_id, 'opening_bank': opening_bank, 'bank_card': bank_card, 'bank_card_user': bank_card_user, 'withdrawal_type': withdrawal_type}, function(data) {
                    if (!data.err_code) {
                        motify.log(data.err_msg);
                        t = setTimeout(redirect(type), 1000);
                    } else {
                        motify.log(data.err_msg);
                    }
                });
            })

            $('.cancel-btn').click(function(e){
                var ref = document.referrer;
                if (ref.indexOf('margin_withdrawal') >= 0) {
                    window.location.href = document.referrer;
                } else {
                    window.location.href = "my_store.php?action=withdrawal&id=<?php echo $store['store_id']; ?>#" + type;
                }
            });

            $(window).hashchange( function(){
                var back_hash = window.location.hash;
                if (back_hash != $('.accountnav > .accountnavli-active').data('hash')) {
                    var ref = document.referrer;
                    if (ref.indexOf('margin_withdrawal') >= 0) {
                        window.location.href = document.referrer;
                    } else {
                        window.location.href = "my_store.php?action=withdrawal&id=<?php echo $store['store_id']; ?>#" + type;
                    }
                }
                click = false;
            });
        })

        function formatBankNo (BankNo){
            if (BankNo == undefined) {
                BankNo = $("input[name='bank_card']");
            }
            if (BankNo.val() == "") return;
            var account = new String(BankNo.val());
            account = account.substring(0,22); /*帐号的总数, 包括空格在内 */
            if (account.match (".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}") == null) {
                /* 对照格式 */
                if (account.match (".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}|" + ".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}|" + ".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}|" + ".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}") == null){
                    var accountNumeric = accountChar = "", i;
                    for (i=0;i<account.length;i++){
                        accountChar = account.substr (i,1);
                        if (!isNaN (accountChar) && (accountChar != " ")) accountNumeric = accountNumeric + accountChar;
                    }
                    account = "";
                    for (i=0;i<accountNumeric.length;i++){    /* 可将以下空格改为-,效果也不错 */
                        if (i == 4) account = account + " "; /* 帐号第四位数后加空格 */
                        if (i == 8) account = account + " "; /* 帐号第八位数后加空格 */
                        if (i == 12) account = account + " ";/* 帐号第十二位后数后加空格 */
                        account = account + accountNumeric.substr (i,1)
                    }
                }
            } else {
                account = " " + account.substring (1,5) + " " + account.substring (6,10) + " " + account.substring (14,18) + "-" + account.substring(18,25);
            }
            if (account != BankNo.val()) {
                BankNo.val(account);
            }
        }

        function redirect(type) {
            var ref = document.referrer;
            if (ref.indexOf('margin_withdrawal') >= 0) {
                window.location.href = document.referrer;
            } else {
                window.location.href = "my_store.php?action=withdrawal&id=<?php echo $store['store_id']; ?>#" + type;
            }
        }
    </script>
</head>
<body>
    <div class="accountnav" style="margin-bottom: 10px;">
        <div class="fl accountnavli" data-hash="#0">对私帐号</div>
        <div class="fl accountnavli accountnavli-active" data-hash="#1">对公帐号</div>
        <div class="clear"></div>
    </div>
    <div class="buesstido-div">
        <div class="fl buesstido-tit">发卡银行</div>
        <select class="fl buesstido-inp buesstido-sel bank_id">
            <option value="0">选择银行</option>
            <?php if (!empty($banks)) { ?>
                <?php foreach ($banks as $bank) { ?>
                    <option value="<?php echo $bank['bank_id']; ?>" <?php if ($bank['bank_id'] == $store['bank_id']) { ?>selected="true"<?php } ?>><?php echo $bank['name']; ?></option>
                <?php } ?>
            <?php } ?>
        </select>

        <div class="clear"></div>
    </div>
    <div class="buesstido-div">
        <div class="fl buesstido-tit">开户银行</div>
        <input class="fl buesstido-inp" type="text" name="opening_bank" value="<?php echo $store['opening_bank']; ?>"/>

        <div class="clear"></div>
    </div>

    <div class="buesstido-div">
        <div class="fl buesstido-tit">银行卡号</div>
        <input class="fl buesstido-inp" type="text" onkeyup="formatBankNo(this)" onkeydown="formatBankNo(this)" name="bank_card" value="<?php echo $store['bank_card']; ?>"/>

        <div class="clear"></div>
    </div>

    <div class="buesstido-div">
        <!-- 如果选择的是对私帐号这里公司名称改为 姓名 就行了 -->
        <div class="fl buesstido-tit card-user-label">公司名称</div>
        <input class="fl buesstido-inp" type="text" name="bank_card_user" value="<?php echo $store['bank_card_user']; ?>"/>

        <div class="clear"></div>
    </div>
    <div class="btn save-btn">保存</div>
    <div class="btn cancel-btn">返回</div>
    <div class="buesstidocontent">
        <div class="fl">
            <div class="alert">
                1. 请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责；<br>
                2. 只支持提现到银行借记卡，<span class="text-strong">不支持信用卡和存折</span>。提现审核周期为3个工作日；
            </div>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>