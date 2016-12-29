<div><div class="page-settlement">
        <div class="ui-box settingWithdrawal-region">
            <div class="header">收款人帐号信息</div>
            <form class="form-horizontal">
                <div class="form-top-info" style="margin-top:0px;">
                    <div class="control-group">
                        <label class="control-label">供货商：</label>
                        <div class="controls">
                            <p class="info-row"><?php echo $storeInfo['name']; ?></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">开户行：</label>
                        <div class="controls">
                            <p class="info-row"><?php echo $marginInfo['opening_bank']; ?></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">开户人：</label>
                        <div class="controls">
                            <p class="info-row"><?php echo $marginInfo['bank_card_user']; ?></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">银行卡号：</label>
                        <div class="controls">
                            <p class="info-row"><?php echo $marginInfo['bank_card']; ?></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">联系人：</label>
                        <div class="controls">
                            <p class="info-row"><?php echo $storeInfo['linkman']; ?></p>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">手机号：</label>
                        <div class="controls">
                            <p class="info-row"><?php echo $storeInfo['tel']; ?></p>
                        </div>
                    </div>
                </div>

                    <div class="type-content">
                        <div class="header"><h4>请填写打款人帐号信息</h4></div>
                        <div class="js-type-0 js-type">
                            <div class="alert">
                                1. 请仔细填写账户信息，如果由于您填写错误导致资金流失，平台概不负责；
                            </div>
                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>开户银行：</label>
                                <div class="controls">
                                    <input type="text" placeholder="准确填写银行卡开户银行" name="opening_bank" class="js_opening_bank" value="<?php echo $bond_log_info['opening_bank']; ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>银行卡卡号：</label>
                                <div class="controls">
                                    <div class="widget-account-pretty">
                                        <div class="widget-account-pretty-input">
                                            <input type="text" placeholder="只支持提现至借记卡，不支持信用卡和存折；" name="bank_card" class="js_bank_card" value="<?php echo $bond_log_info['bank_card']; ?>" />
                                            <div class="widget-account-pretty-text js-account-pretty"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>开卡人姓名：</label>
                                <div class="controls">
                                    <input type="text" placeholder="准确填写银行卡开卡人姓名，以便核实打款信息" name="bank_card_user" class="js_bank_card_user" value="<?php echo $bond_log_info['bank_card_user']; ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>手机号：</label>
                                <div class="controls">
                                    <div class="phone-pretty">
                                    <input type="text" placeholder="请正确填写联系方式，以便核实打款信息" name="phone" class="js_bank_card_user" value="<?php echo $bond_log_info['phone']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" data-storeid="<?php echo $store_id?>" class="supplier_id">
                            <div class="control-group">
                                <label class="control-label"><em class="required">*</em>充值额度：</label>
                                <div class="controls">
                                    <div class="apply_recharge-pretty">
                                      <input type="text" placeholder="" name="apply_recharge" class="js_bank_card_user" value="<?php echo empty($apply_recharge) ? $store_info['bond'] : $apply_recharge ;?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button class="btn btn-primary js-submit-btn <?php echo $param; ?>" type="button" data-loading-text="保存中...">保存</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>