<style type="text/css" xmlns="http://www.w3.org/1999/html">
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
    .service-fee {
        font-size: 20px;
        color: red;
    }
    .exchange-rate {
        color: green;
        font-size: 20px;
    }
    .exchange-tips {
        color: #bbb;
    }
    .point2other {
        font-size: 24px;
        color:grey;
    }
    .desc {
        margin-top: 10px;
        padding: 10px 0 0 10px;
        color: gray;
        border: 1px dashed #E4E4E4;
    }
    .desc p {
        margin: 0 0 10px;
    }
</style>
<div>
    <div class="page-settlement">
        <div class="ui-box applyWithdrawal-region">
            <div class="header"><a href="<?php dourl('trade:income'); ?>#platform_margin">平台保证金</a> >> 店铺<?php echo $point_alias; ?>兑换</div>

            <div class="form-horizontal">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" style="padding-top: 0;">兑换目标：</label>
                        <div class="controls">
                            <div class="balance-content">
                                <label style="display: inline-block;"><input type="radio" name="target" class="target" data-checked="<?php echo $store['point2money']; ?>" checked="true" value="0" style="margin-top: 0px" /> 提现金额</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label style="display: inline-block;"><input type="radio" name="target" class="target" data-checked="<?php echo $store['point2user']; ?>" value="1" style="margin-top: 0px" /> 用户积分</label>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="padding-top: 0;">已兑换<?php echo $point_alias; ?>：</label>
                        <div class="controls">
                            <div class="balance-content">
                                <span class="point2other"><?php echo $store['point2money']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="padding-top: 0;">可兑换<?php echo $point_alias; ?>：</label>
                        <div class="controls">
                            <div class="balance-content">
                                <span class="money"><?php echo $store['point_balance']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group targets target-0">
                        <label class="control-label" style="padding-top: 0;">平台服务费：</label>
                        <div class="controls">
                            <div class="balance-content">
                                <span class="service-fee"><?php echo $service_fee; ?>%</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group targets target-0">
                        <label class="control-label" style="padding-top: 0;">目标兑换率：</label>
                        <div class="controls">
                            <div class="balance-content">
                                <span class="exchange-rate">1 : <?php echo round(1 / $exchange_rate, 2); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="control-group targets target-1" style="display: none;">
                        <label class="control-label" style="padding-top: 0;">目标兑换率：</label>
                        <div class="controls">
                            <div class="balance-content">
                                <span class="exchange-rate">1 : 1</span>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><span class="required">*</span>本次兑换：</label>
                        <div class="controls">
                            <input name="point" class="js-point" type="text" data-max="<?php echo $store['point_balance']; ?>" name="money" placeholder="最多可兑换<?php echo $store['point_balance']; ?> <?php echo $point_alias; ?>" />&nbsp;&nbsp;<?php echo $point_alias; ?>
                        </div>
                    </div>
                    <?php if ($sync_withdrawal) { ?>
                    <div class="control-group targets target-0">
                        <label class="control-label" style="padding-top: 0;"><input type="checkbox" name="sync_withdrawal" value="1" style="margin-top: 0" /> 申请提现</label>
                        <div class="controls">
                            <p class="gray">* <?php echo $point_alias; ?>兑换成功后提交提现申请</p>
                        </div>
                        <div class="controls withdrawal-info" style="display:none;padding: 5px;margin-left: 42px;border: 1px solid lightgrey;width:350px;margin-top:5px;border-radius: 4px;">
                            <?php if (!empty($store['sales_ratio'])) { ?>
                            <p style="color:red;"><label style="display: inline-block;width: 80px;text-align: right"><b>服务费：</b></label> <?php echo $store['sales_ratio']; ?>%</p>
                            <?php } ?>
                            <p><label style="display: inline-block;width: 80px;text-align: right"><b>银行卡：</b></label> <?php echo $store['bank_card']; ?></p>
                            <p><label style="display: inline-block;width: 80px;text-align: right"><b>持卡人：</b></label> <?php echo $store['bank_card_user']; ?></p>
                            <p><label style="display: inline-block;width: 80px;text-align: right"><b>发卡银行：</b></label> <?php echo $store['bank']; ?></p>
                            <p><label style="display: inline-block;width: 80px;text-align: right"><b>开户银行：</b></label> <?php echo $store['opening_bank']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php dourl('income'); ?>#editwithdrawal">编辑</a></p>
                        </div>
                    </div>
                    <?php } ?>
                </fieldset>
                <div class="form-actions" data-loading="<?php echo TPL_URL;?>images/loader@2x.gif">
                    <button class="btn btn-large btn-primary js-btn-submit" type="button" data-loading-text="正在提交...">确认兑换</button>
                    <a href="<?php dourl('trade:income'); ?>#platform_margin" class="btn btn-large btn-primary" type="button" data-loading-text="正在返回...">返回</a>
                </div>
            </div>
        </div>
        <div class="desc">
            <p>* <b>兑换目标：</b>用<?php echo $point_alias; ?>兑换的目标，提现金额是指可以提现的金额，用户积分是指店铺所属用户的可抵现积分。</p>
            <p>* <b>目标兑换率：</b>1 <?php echo $point_alias; ?>可兑换的现金/用户积分比率。</p>
        </div>
    </div>
</div>