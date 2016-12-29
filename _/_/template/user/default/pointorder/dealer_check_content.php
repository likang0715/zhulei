<style type="text/css">
    .page-settlement .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: rgba(255,255,255,0.4);
        zoom: 1;
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
    .disabled {
        background-color: lightgray;
        border: 1px solid lightgray;
        cursor: no-drop;
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
    .red {
        color: red;
    }
    .gray {
        color: gray;
    }
    .green {
        color: green;
    }
</style>
<div class="page-settlement">
    <div class="ui-box settlement-info">
        <div class="balance" style="clear: both;height: 20px">
            <?php if ($type == 1) { ?>
            <div class="balance-info" style="border-left: none; position:relative;width: 33.33%">
                保证金剩余：<span style="font-size: 20px;color: #f60;"><?php echo $bond_balance; ?></span> <span style="font-size: 12px;color: #666;">元</span>
            </div>
            <?php } ?>
            <?php if ($type == 1) { ?>
            <div class="balance-info" style="border-left: none; position:relative">
                充值提醒：<span style="font-size: 20px;color: #f60;"><?php echo $recharge_notice; ?></span>
            </div>
            <?php } ?>
            <?php if ($type == 2) { ?>
            <div class="balance-info" style="border-left: none; position:relative;width: 50%">
                待支付：<span style="font-size: 20px;color: #f60;"><?php echo $unpay_total; ?></span> <span style="font-size: 12px;color: #666;">元</span>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-filter-region clearfix">
        <div>
            <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="clearfix">
                    <div class="filter-groups">
                        <div class="control-group">
                            <label class="control-label">经销商对账：</label>
                            <div class="controls">
                                <input type="text" name="name" />
                            </div>
                        </div>
                    </div>
                    <div class="pull-left">
                        <div class="filter-groups">
                            <div class="control-group">
                                <?php if ($type == 1) { ?>
                                <label class="control-label">批发状态：</label>
                                <div class="controls">
                                    <select name="status" class="js-state-select">
                                        <option value="0" selected="selected">全部</option>
                                        <option value="1">正常</option>
                                        <option value="2">保证金余额不足</option>
                                    </select>
                                </div>
                                <?php } else { ?>
                                <label class="control-label">支付状态：</label>
                                <div class="controls">
                                    <select name="status" class="js-state-select">
                                        <option value="0" selected="selected">全部</option>
                                        <option value="1">未支付</option>
                                        <option value="2">已支付</option>
                                    </select>
                                </div>
                                <?php } ?>
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
    <?php if (!empty($dealers)) { ?>
        <table class="ui-table-order">
            <thead class="js-list-header-region">
            <tr>
                <th class="text-left">经销商名称</th>
                <th class="text-right">待收款(元)</th>
                <th class="text-right">待收退货款(元)</th>
                <th class="text-right">分润(元)</th>
                <?php if ($type == 1) { ?>
                <th class="text-right">保证金余额(元)</th>
                <?php } ?>
                <th class="text-right">销售额(元)</th>
                <?php if ($type == 1) { ?>
                <th class="text-center">保证金状态</th>
                <?php } else { ?>
                <th class="text-center">支付状态</th>
                <?php } ?>
                <th class="text-center">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dealers as $dealer) { ?>
                <tr>
                    <td><?php echo $dealer['name']; ?></td>
                    <td class="text-right red"><?php echo $dealer['not_paid']; ?></td>
                    <td class="text-right red"><?php echo $dealer['return_owe']; ?></td>
                    <td class="text-right"><?php echo $dealer['profit']; ?></td>
                    <?php if ($type == 1) { ?>
                    <td class="text-right"><?php echo $dealer['bond']; ?></td>
                    <?php } ?>
                    <td class="text-right"><?php echo $dealer['sales']; ?></td>
                    <td class="text-center">
                        <?php if ($type == 1) { ?>
                        <?php if ($dealer['bond'] <= 0) { ?>
                            <span class="red">余额不足</span>
                        <?php } else { ?>
                            <span class="green">正常</span>
                        <?php } ?>
                        <?php } else { ?>
                            <?php if ($dealer['not_paid'] > 0) { ?>
                            <span class="red">未支付</span>
                            <?php } else { ?>
                            <span class="green">已支付</span>
                            <?php }?>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <?php if ($type == 1 || $dealer['unbalance'] == 0) { ?>
                        <a href="<?php echo dourl('fx:ws_store_info', array('store_id' => $dealer['dealer_id'])); ?>">查看明细</a>
                        <?php } else { ?>
                        <a href="<?php echo dourl('fx:my_order', array('supplier_id' => $dealer['supplier_id'])); ?>">去付款</a>
                        <?php } ?>
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