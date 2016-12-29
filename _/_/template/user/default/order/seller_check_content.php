<style type="text/css">
    .page-settlement .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: rgba(255,255,255,0.4);
        zoom: 1;
    }
    .page-settlement .balance .balance-info {
        float: left;
        width: 24.33%;
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
    .red {
        color:red;
        font-weight: bold;
    }
    .ui-table-order {
        width: 100%;
    }
    .text-right {
        text-align: right;
    }
    .text-center {
        text-align: center;
    }
    .text-left {
        text-align: left;
    }
</style>
<div class="page-settlement">
    <div class="ui-box settlement-info">
        <div class="balance">
            <div class="balance-info" style="position:relative">
                <div class="balance-title">销售总额
                    <div class="help">
                        <a href="javascript:void(0);" class="js-help-notes"></a>
                    </div>
                </div>
                <div class="balance-content">
                    <span class="money"><?php echo $seller_sales; ?></span>
                    <span class="unit">元</span>
                </div>
            </div>

            <div class="balance-info" style="border-left: none; position:relative">
                <div class="balance-title">待支出(可提现)<div class="help"></div></div>
                <div class="balance-content">
                    <span class="money"><?php echo $seller_profit_balance; ?></span>
                    <span class="unit">元</span>
                </div>
            </div>

            <div class="balance-info" style="border-left: none; position:relative">
                <div class="balance-title">已支出(已提现)<div class="help"></div></div>
                <div class="balance-content">
                    <span class="money"><?php echo $seller_withdrawal_processed; ?></span>
                    <span class="unit">元</span>
                </div>
            </div>

            <div class="balance-info" style="border-left: none; position:relative">
                <div class="balance-title">待结算<div class="help"></div></div>
                <div class="balance-content">
                    <span class="money"><?php echo $seller_profit_unbalance; ?></span>
                    <span class="unit">元</span>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="balance" style="clear: both;height: 20px">
            <div class="balance-info" style="border-left: none; position:relative">
                分销商数量：<span style="font-size: 20px;color: #f60;"><?php echo $seller_count; ?></span>
            </div>
            <div class="balance-info" style="border-left: none; position:relative">
                未处理提现：<span style="font-size: 20px;color: #f60;"><?php echo $seller_withdrawals; ?></span>
            </div>
        </div>
    </div>
    <div class="js-list-filter-region clearfix">
        <div>
            <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="clearfix">
                    <div class="filter-groups">
                        <div class="control-group">
                            <label class="control-label">分销商名称：</label>
                            <div class="controls">
                                <input type="text" name="name" />
                            </div>
                        </div>
                    </div>
                    <div class="pull-left">
                        <div class="filter-groups">
                            <div class="control-group">
                                <label class="control-label">分销商等级：</label>
                                <div class="controls">
                                    <select name="level" class="js-state-select">
                                        <option value="0" selected="selected">全部</option>
                                        <option value="1">一级</option>
                                        <option value="2">二级</option>
                                        <option value="3">三级</option>
                                        <option value="4">四级</option>
                                        <option value="5">五级</option>
                                        <option value="6">六级</option>
                                        <option value="7">七级</option>
                                        <option value="8">八级</option>
                                        <option value="9">九级及以上</option>
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
    <?php if (!empty($sellers)) { ?>
        <table class="ui-table-order">
            <thead class="js-list-header-region">
            <tr>
                <th class="text-left">分销商名称</th>
                <th class="text-center">分销商等级</th>
                <th class="text-right">销售额(元)</th>
                <th class="text-right">待结算(元)</th>
                <th class="text-right">可提现(元)</th>
                <th class="text-right">提现中(元)</th>
                <th class="text-center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sellers as $seller) { ?>
                <tr>
                    <td class="text-left"><?php echo $seller['name']; ?></td>
                    <td class="text-center"><?php echo $seller['drp_level']; ?></td>
                    <td class="text-right"><?php echo $seller['sales']; ?></td>
                    <td class="text-right"><?php echo $seller['unbalance']; ?></td>
                    <td class="text-right"><?php echo $seller['balance']; ?></td>
                    <td class="text-right"><?php echo $seller['withdrawal_pending_amount']; ?></td>
                    <td class="text-center">
                        <a href="<?php echo dourl('order:fx_bill_check', array('store_id' => $seller['seller_id'])); ?>">查看明细</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php dourl('trade:income', array('seller_id' => $seller['seller_id'])); ?>#seller_withdraw">未处理提现(<span class="red"><?php echo $seller['withdrawal_pending']; ?></span>)</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
    <?php } ?>
</div>
<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div></div>