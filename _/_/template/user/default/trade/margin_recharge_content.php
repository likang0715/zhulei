<style type="text/css" xmlns="http://www.w3.org/1999/html">
    .payment-method {
        cursor: pointer;
        height: 26px;
        line-height: 26px;
        width: auto;
        padding: 5px 10px;
        margin-right: 10px;
        display: inline-block;
        text-align: center;
        border: 1px solid rgb(14,147,46) !important;
    }
    .payment-methods > .active {
        background: url("<?php echo TPL_URL;?>images/6.png") right bottom no-repeat;
        border: 1px solid rgb(0,102,204) !important;
    }
    .tips {
        margin-top: 50px;
        color: gray;
    }
    .btn {
        border-radius: 2px;
    }
    .btn-primary, .team .btn-default {
        font-family: 'Microsoft YaHei',sans-serif;
    }
    .btn-large {
        font-size: 16px;
        padding: 8px 30px;
    }
    .form-actions {
        text-align: center;
    }
    .disabled {
        border: 1px dashed lightgrey!important;
        color: lightgrey;
        cursor: no-drop;
    }
</style>
<div>
    <div class="page-settlement">
        <div class="ui-box applyWithdrawal-region">
            <div class="header"><a href="<?php dourl('trade:income'); ?>#platform_margin">平台保证金</a> >> 平台保证金充值</div>

            <div class="form-horizontal">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label"><em class="required">*</em>充值金额：</label>
                        <div class="controls">
                            <input class="js-money" type="text" data-min="<?php echo $recharge_min_amount; ?>" name="money" placeholder="最低充值金额<?php echo $recharge_min_amount; ?> 元" />&nbsp;&nbsp;元
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><em class="required">*</em>支付方式：</label>
                        <div class="controls payment-methods">
                            <?php if (!empty($payment_methods)) { ?>
                            <?php foreach ($payment_methods as $payment_method) { ?>
                            <span class="payment-method<?php if ($payment_method['type'] == 'allinpay') { ?> active<?php } ?>" data-method="<?php echo $payment_method['type']; ?>" title="<?php if ($payment_method['type'] == 'allinpay') { ?><?php echo $payment_method['name']; ?><?php } else { ?>暂不支持<?php } ?>"><?php echo $payment_method['name']; ?></span>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions" data-loading="<?php echo TPL_URL;?>images/loader@2x.gif">
                    <button class="btn btn-large btn-primary js-btn-submit" type="button" data-loading-text="正在提交...">确认充值</button>
                    <a href="<?php dourl('trade:income'); ?>#platform_margin" class="btn btn-large" type="button" data-loading-text="正在返回...">返回</a>
                </div>
                <?php if (!empty($notes)) { ?>
                <div class="control-group tips">
                    <label class="control-label"><em class="required">*</em>使用须知：</label>
                    <div class="controls">
                        <?php echo $notes; ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>