<style type="text/css">
    .page-settlement .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: rgba(255,255,255,0.4);
        zoom: 1;
    }
    .page-settlement .balance .balance-info {
        float: left;
        width: 50%;
        margin-left: -1px;
        padding: 0 20px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .page-settlement .balance .balance-info .balance-title {
        font-size: 14px;
        color: #000;
        margin-bottom: 10px;
    }
    .page-settlement .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .page-settlement .balance .balance-info .balance-content span, .page-settlement .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 28px;
    }
    .page-settlement .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .page-settlement .balance .balance-info .balance-content span, .page-settlement .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 28px;
    }
    .wait-profit {
        margin-top: 10px;
    }
    .red {
        color:red;
        font-weight: bold;
    }
    .disabled {
        background-color: lightgray;
        border: 1px solid lightgray;
        cursor: no-drop;
    }
</style>
<div class="page-settlement">
    <div class="ui-box settlement-info">
        <div class="balance">
            <div class="balance-info platform-unbalance" style="position:relative">
                <div class="balance-title">待结算金额
                    <div class="help"></div>
                    <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 255px; display: none;">
                        <div class="arrow"></div>
                        <div class="popover-inner">
                            <div class="popover-content">
                                <p><strong>待结算金额:</strong> 交易未完成，暂时不能提现的金额。</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="balance-content">
                    <span class="money"><?php echo $unbalance; ?></span>
                    <span class="unit">元</span>
                    <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('trade:income', array('status' => 1)); ?>#inoutdetail">查看明细</a></span>
                </div>
                <div class="wait-profit">
                    待支出分润：<span class="red"><?php echo $seller_unbalance; ?></span> 元 <div class="help"></div>
                    <div class="js-intro-popover popover popover-help-notes bottom" style="top: 85px; left: 255px; display: none;">
                        <div class="arrow"></div>
                        <div class="popover-inner">
                            <div class="popover-content">
                                <p><strong>待支出分润:</strong> 下级分销商的分润，待结算金额中包含的分销利润。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="balance-info platform-balance" style="border-left: none; position:relative">
                <div class="balance-title">可提现金额 <div class="help"></div>
                    <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 255px; display: none;">
                        <div class="arrow"></div>
                        <div class="popover-inner">
                            <div class="popover-content">
                                <p><strong>可提现金额:</strong> 交易完成，可以向平台提现的金额。</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="balance-content">
                    <span class="money"><?php echo $balance; ?></span>
                    <span class="unit">元</span>
                    <span>&nbsp;&nbsp;&nbsp;<a href="<?php if ($balance > 0) { ?><?php dourl('trade:income', array('to' => 'platform')); ?>#applywithdrawal<?php } else { ?>javascript:void(0);<?php } ?>" class="ui-btn ui-btn-primary js-go-to <?php if ($balance <= 0) { ?>disabled<?php } ?>" >我要提现</a></span>
                    <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('trade:income'); ?>#withdraw">提现记录</a></span>
                </div>
                <div class="wait-profit wait-profit-balance">
                    待支出分润：<span class="red"><?php echo $seller_balance; ?></span> 元 <div class="help"></div>
                    <div class="js-intro-popover popover popover-help-notes bottom" style="top: 85px; left: 255px; display: none;">
                        <div class="arrow"></div>
                        <div class="popover-inner">
                            <div class="popover-content">
                                <p><strong>待支出分润:</strong> 下级分销商的分润，可提现金额中包含的分销利润。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
    <div class="js-list-filter-region clearfix">
        <div>
            <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="clearfix">
                    <div class="filter-groups">
                        <div class="control-group">
                            <label class="control-label">支付流水号：</label>
                            <div class="controls">
                                <input type="text" name="third_id" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">订单号：</label>
                            <div class="controls">
                                <input type="text" name="order_no" />
                            </div>
                        </div>
                    </div>
                    <div class="pull-left">
                        <div class="time-filter-groups clearfix">
                            <div class="control-group">
                                <div class="controls" style="margin-left: 30px;">
                                    <input type="text" name="start_time" value="" class="js-start-time" id="js-start-time" />
                                    <span>至</span>
                                    <input type="text" name="end_time" value="" class="js-end-time" id="js-end-time" />
                                    <span class="date-quick-pick" data-days="7">最近7天</span>
                                    <span class="date-quick-pick" data-days="30">最近30天</span>
                                </div>
                            </div>
                        </div>
                        <div class="filter-groups">
                            <div class="control-group">
                                <label class="control-label">订单状态：</label>
                                <div class="controls">
                                    <select name="status" class="js-state-select">
                                        <option value="*" selected="selected">全部</option>
                                        <option value="1">待结算</option>
                                        <option value="2">已结算</option>
                                        <option value="3">已对账</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-groups">

                            <div class="control-group">
                                <div class="controls">
                                    <div class="ui-btn-group">
                                        <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在筛选...">筛选</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="ui-box orders">
    <?php include display('_checklist'); ?>
    <?php if (empty($orders)) { ?>
    <?php include display('_empty'); ?>
    <?php } ?>
</div>
<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div></div>