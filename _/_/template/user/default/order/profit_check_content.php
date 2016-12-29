<style type="text/css">
    .page-settlement .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: rgba(255,255,255,0.4);
        zoom: 1;
    }
    .page-settlement .balance .balance-info {
        float: left;
        width: 33.33%;
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
    .ui-table-order {
        width: 100%;
    }
    .text-right {
        text-align: right;
    }
    .text-center {
        text-align: center;
    }
    .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 12px;
        border-radius: 4px;
        line-height: normal;
    }
    .date-quick-pick:hover {
        border-color:#ddd;
    }
    .c-gray {
        color: #5a5a5a;
    }
    .green {
        color: green;
    }
    .red {
        color: red;
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

            <div class="balance-info" style="border-left: none; position:relative">
                <div class="balance-title">待结算金额<div class="help"></div></div>
                <div class="balance-content">
                    <span class="money"><?php echo $store['unbalance']; ?></span>
                    <span class="unit">元</span>
                    <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('trade:income', array('status' => 1)); ?>#inoutdetail">查看明细</a></span>
                </div>
            </div>

            <div class="balance-info" style="position:relative">
                <div class="balance-title">可提现金额
                    <div class="help">
                        <a href="javascript:void(0);" class="js-help-notes"></a>
                    </div>
                </div>
                <div class="balance-content">
                    <span class="money"><?php echo $store['balance']; ?></span>
                    <span class="unit">元</span>
                    <span>&nbsp;&nbsp;&nbsp;<a href="<?php if ($store['balance'] > 0) { ?><?php dourl('trade:income'); ?>#applywithdrawal<?php } else { ?>javascript:void(0);<?php } ?>" class="ui-btn ui-btn-primary js-go-to <?php if ($store['balance'] <= 0) { ?>disabled<?php } ?>" >我要提现</a></span>
                    <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('trade:income'); ?>#withdraw">提现记录</a></span>
                </div>
            </div>
            
            <div class="balance-info" style="position:relative">
                <div class="balance-title">可提现分红
                    <div class="help">
                        <a href="javascript:void(0);" class="js-help-notes"></a>
                    </div>
                </div>
                <div class="balance-content">
                    <span class="money"><?php echo $store['dividends']; ?></span>
                    <span class="unit">元</span>
                    <span>&nbsp;&nbsp;&nbsp;<a href="<?php if ($store['dividends'] > 0) { ?><?php dourl('trade:income'); ?>#dividends_withdrawal<?php } else { ?>javascript:void(0);<?php } ?>" class="ui-btn ui-btn-primary js-go-to <?php if ($store['dividends'] <= 0) { ?>disabled<?php } ?>" >我要提现</a></span>
                    <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('trade:income'); ?>#my_dividends">奖金记录</a></span>
                </div>
            </div>



            <div style="clear: both"></div>
        </div>
        <div class="balance" style="clear: both;height: 20px">
            <div class="balance-info" style="border-left: none; position:relative">
                我的供货商：<span style="font-size: 20px;color: #f60;"><?php echo $supplier_name; ?></span>
            </div>
        </div>
    </div>
    <div class="js-list-filter-region clearfix">
        <div>
            <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="clearfix">
                    <div class="filter-groups">
                        <div class="control-group">
                            <label class="control-label">下单时间：</label>
                            <div class="controls">
                                <input type="text" name="start_time" value="" class="js-start-time" id="js-start-time" /> 至
                                <input type="text" name="end_time" value="" class="js-end-time" id="js-end-time" />
                                <span class="date-quick-pick" data-days="7">最近7天</span>
                                <span class="date-quick-pick" data-days="30">最近30天</span>
                            </div>
                        </div>
                    </div>
                    <div class="pull-left">
                        <div class="filter-groups">
                            <div class="control-group">
                                <label class="control-label">支付/订单号：</label>
                                <div class="controls">
                                    <input type="text" name="order_no">
                                </div>
                            </div>

                        </div>
                        <div class="filter-groups">
                            <div class="control-group">
                                <label class="control-label">结算状态：</label>
                                <div class="controls">
                                    <select name="status" class="js-state-select">
                                        <option value="0" selected="selected">全部</option>
                                        <option value="1">待结算</option>
                                        <option value="2">已结算</option>
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
    <?php if (!empty($orders)) { ?>
        <table class="ui-table-order">
            <thead class="js-list-header-region">
            <tr>
                <th class="text-center" style="width: 80px">订单ID</th>
                <th class="text-left">订单NO.</th>
                <th class="text-right">订单金额(元)</th>
                <th class="text-right">分销利润(元)</th>
                <th class="text-right">已退货(元)</th>
                <th class="text-center">结算状态</th>
                <th class="text-center">下单时间</th>
                <th class="text-center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td class="text-center"><?php echo $order['order_id']; ?></td>
                    <td class="text-left">
                        <?php echo $order['order_no']; ?><br/>
                        <div class="clearfix">
                            <div style="margin-top: 4px;" class="pull-left">
                                <span class="c-gray">支付流水号: <?php echo $order['third_id']; ?></span>
                            </div>
                        </div>
                    </td>
                    <td class="text-right"><?php echo $order['total']; ?></td>
                    <td class="text-right"><?php echo $order['profit']; ?></td>
                    <td class="text-right red"><?php echo $order['return']; ?></td>
                    <td class="text-center"><?php if ($order['status'] == 4) { ?><span class="green">已结算</span><?php } else { ?><span class="red">待结算</span><?php } ?></td>
                    <td class="text-center"><?php echo date('Y-m-d H:i:s', $order['add_time']); ?></td>
                    <td class="text-center">
                        <a href="<?php echo dourl('fx:commission_detail', array('id' => $order['order_id'])); ?>">查看明细</a>
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