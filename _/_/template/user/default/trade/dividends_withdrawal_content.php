<div><div class="page-settlement">
        <div class="ui-box applyWithdrawal-region">
            <div class="header"><?php if ($to == 'platform') { ?>向平台<?php } else { ?>向供货商<?php if (!empty($supplier_name)) { ?>“<?php echo $supplier_name; ?>”<?php } ?><?php } ?>申请提现</div>

            <div class="form-horizontal">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label">可提现分红：</label>
                        <div class="controls">
                            <span class="money"><?php echo $dividends; ?></span> <span class="unit">元</span>
                        </div>
                    </div>
                    <div class="control-group bank-group">
                        <label class="control-label"><em class="required">*</em>选择提现银行：</label>
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
                                            <li><a href="#editwithdrawal" class="js-edit" data-type="fh" >编辑</a></li>
                                            <li><a href="javascript:;" class="js-delete-dividends">删除</a></li>
                                        </ul>
                                    </div>
                                    <span class="c-gray account_name"><?php echo $store['bank_card_user']; ?>（****<?php echo substr($store['bank_card'], -4); ?>）</span>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php if (empty($store['bank_id'])) { ?>
                        <div class="controls" style="padding-top: 5px;"><a href="#settingwithdrawal" class="js-add-bankcard-dividends" >添加银行卡</a></div>
                        <?php } ?>
                    </div>

                    
                    <div class="control-group">
                        <label class="control-label"><em class="required">*</em>提现金额：</label>
                        <div class="controls">
                            <input class="js-money-dividends" type="text"  data-dividends="<?php echo $dividends; ?>" name="money" placeholder="最多可输入<?php echo $dividends; ?>">&nbsp;&nbsp;元
                        </div>
                    </div>
                    <div class="control-group period-group">
                        <label class="control-label">提现审核周期：</label>
                        <div class="controls">
						<span>个人认证店铺为3个工作日</span>
                        </div>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <button class="btn btn-primary js-submit-dividends" data-loading-text="提现中...">确认提现</button>
                </div>
            </div>
        </div>
    </div></div>