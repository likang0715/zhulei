<script type="text/javascript">
    if (withdrawal == 'margin') {
        var withdrawal_amount_min = parseFloat("<?php echo !empty($withdrawal_amount_min) ? $withdrawal_amount_min : 0; ?>").toFixed(2);
    }
</script>
<style type="text/css">
    .min-money {
        color: lightgrey;
    }
</style>
<div>
    <div class="page-settlement">
        <div class="ui-box applyWithdrawal-region">
            <div class="header">
                <?php if ($withdrawal == 'margin') { ?>
                申请充值现金余额返还
                <?php } else { ?>
                <?php if ($to == 'platform') { ?>向平台<?php } else { ?>向供货商<?php if (!empty($supplier_name)) { ?>“<?php echo $supplier_name; ?>”<?php } ?>
                <?php } ?>申请提现<?php if ($withdrawal == 'point2money') { ?>(积分兑现)<?php } ?>
                <?php } ?>
            </div>
            <div class="form-horizontal">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label">
                            <?php if ($withdrawal == 'margin') { ?>
                            可返还金额：
                            <?php } else { ?>
                            可提现金额：
                            <?php } ?>
                        </label>
                        <div class="controls">
                            <span class="money"><?php echo $balance; ?></span> <span class="unit">元</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="position: relative;">
                            <div class="help"></div>&nbsp;最低提现金额：
                            <div class="js-intro-popover popover popover-help-notes bottom" style="top: 20px; left: -28px; display: none;">
                                <div class="arrow" style="left: 33%"></div>
                                <div class="popover-inner">
                                    <div class="popover-content">
                                        <p style="text-align: left"><strong>最低提现金额:</strong> 单次最低提现额度，若可提现金额或输入的提现金额小于该限额将无法提现。</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <?php if ($withdrawal_amount_min > 0) { ?>
                        <div class="controls">
                            <span class="money min-money"><?php echo $withdrawal_amount_min; ?></span> <span class="unit">元</span>
                        </div>
                        <?php } else { ?>
                        <div class="controls">
                            <label class="control-label" style="text-align: left">不限</label>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="control-group bank-group">
                        <label class="control-label"><em class="required">*</em>选择收款银行：</label>
                        <div class="controls js-bank-list-region">
                            <ul>
                                <?php if (!empty($store['bank_id'])) { ?>
                                <li class="bank active" data-id="<?php echo $store['bank_id']; ?>" data-opening-bank="<?php echo $store['opening_bank']; ?>" data-user="<?php echo $store['bank_card_user']; ?>" data-card="<?php echo $store['bank_card']; ?>" data-type="<?php echo $store['withdrawal_type']; ?>" >
                                    <span class="bank_name"><?php echo $bank; ?> - <?php echo $store['opening_bank']; ?></span>
                                    <div class="dropdown hover dropdown-right">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="txt">管理</span>
                                            <i class="caret"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#editwithdrawal" class="js-edit">编辑</a></li>
                                            <!--li><a href="javascript:;" class="js-delete">删除</a></li-->
                                        </ul>
                                    </div>
                                    <span class="c-gray account_name"><?php echo $store['bank_card_user']; ?>（****<?php echo substr($store['bank_card'], -4); ?>）</span>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php if (empty($store['bank_id'])) { ?>
                        <div class="controls" style="padding-top: 5px;"><a href="#settingwithdrawal" class="js-add-bankcard">添加银行卡</a></div>
                        <?php } ?>
                    </div>
                    <?php if ($withdrawal != 'margin') { ?>
                    <div class="control-group sales-ratio">
                        <label class="control-label"><?php if ($to == 'platform') { ?>平台<?php } ?>服务费：</label>
                        <div class="controls"><span class="money" style="color:red"><?php echo $sales_ratio; ?>%</span></div>
                    </div>
                    <?php } ?>
                    <div class="control-group">
                        <label class="control-label"><em class="required">*</em>
                            <?php if ($withdrawal == 'margin') { ?>
                                返还金额：
                            <?php } else { ?>
                                提现金额：
                            <?php } ?>
                        </label>
                        <div class="controls">
                            <input class="js-money" type="text" data-sales-ratio="<?php echo $sales_ratio; ?>" data-balance="<?php echo $balance; ?>" name="money" placeholder="最多可输入<?php echo $balance; ?>">&nbsp;&nbsp;元
                        </div>
                    </div>
                    <div class="control-group period-group">
                        <label class="control-label">审核周期：</label>
                        <div class="controls">
						<span>个人认证店铺为3个工作日</span>
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <button class="btn btn-primary js-submit <?php if ($balance < $withdrawal_amount_min) { ?>disabled<?php } ?>" data-loading-text="提现中...">提交申请</button>
                    <button class="btn btn-cancel js-cancel">返回</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.js-cancel').click(function(e){
            if (withdrawal == '') {
                window.location.href = "<?php dourl('trade:income'); ?>";
            } else {
                window.location.href = "<?php dourl('trade:income'); ?>#platform_margin";
            }
        });
    })
</script>