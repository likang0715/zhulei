<style type="text/css">
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
    .platform-tag {
        display: inline-block;
        vertical-align: middle;
        padding: 3px 7px 3px 7px;
        background-color: #f60;
        color: #fff;
        font-size: 12px;
        line-height: 14px;
        border-radius: 2px;
    }
</style>
<?php if (!empty($orders)) { ?>
    <table class="ui-table-order">
        <thead class="js-list-header-region">
            <tr>
                <th class="text-center">订单ID</th>
                <th class="text-left">订单NO.</th>
                <th class="text-right">订单金额(元)</th>
                <th class="text-right">收益(元)</th>
                <th class="text-right">分润(元)</th>
                <th class="text-right">退货(元)</th>
                <th class="text-center">订单状态</th>
                <th class="text-center">下单时间</th>
                <th class="text-center" style="width: 50px">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) { ?>
            <tr style="border-bottom: none;">
                <td class="text-center"><?php echo $order['order_id']; ?></td>
                <td class="text-left">
                    <?php echo $order['order_no']; ?> <?php if ($order['type'] == 5 || !empty($order['is_ws'])) { ?><span class="platform-tag" style="background-color:#07d">批发</span><?php } else if ($order['type'] == 3 && empty($order['is_ws'])) { ?><span class="platform-tag">分销</span><?php } ?>
                    <div class="clearfix">
                        <div style="margin-top: 4px;" class="pull-left">
                            <span class="c-gray">支付流水号: <?php echo $order['third_id']; ?></span>
                        </div>
                    </div>
                </td>
                <td class="text-right"><?php echo $order['income']; ?></td>
                <td class="text-right"><?php echo $order['profit']; ?></td>
                <td class="text-right"><?php echo $order['seller_profit']; ?></td>
                <td class="text-right"><?php if ($order['return_amount'] > 0) { ?><a href="<?php dourl('order:order_return'); ?>#detail/<?php echo $order['order_id']; ?>"><?php echo $order['return_amount']; ?></a><?php } else { ?><?php echo $order['return_amount']; ?><?php } ?></td>
                <td class="text-center"><?php echo $order['status']; ?></td>
                <td class="text-center"><?php echo date('Y-m-d H:i', $order['add_time']); ?></td>
                <td class="text-center"><a href="<?php dourl('order:detail', array('id' => $order['order_id'])); ?>">查看</a></td>
            </tr>
            <tr>
                <td colspan="8" class="text-right" style="background-color: #eee;padding:5px 10px;">
                    待结算(元)：<br/>
                    已结算(元)：<br/>
                    待分润(元)：<br/>
                </td>
                <td colspan="1" class="text-right" style="background-color: #eee;padding:5px 10px">
                    <span style="color: red;"><?php echo $order['uncheckout']; ?></span><br/>
                    <span style="color: green;"><?php echo $order['checkout']; ?></span><br/>
                    <span style="color: red;"><?php echo $order['seller_profit']; ?></span><br/>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>