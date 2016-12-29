<style type="text/css">
    p {
        margin: 0;
        padding: 0;
        list-style: none;
        font-style: normal;
    }
    .gray {
        color: gray;
    }
</style>
<div class="goods-list">
<div>
    <?php if (!empty($orders)) { ?>
    <table class="ui-table-order">
        <thead class="js-list-header-region">
        <tr>
            <th>订单ID</th>
            <th>订单NO.</th>
            <th>支付流水NO.</th>
            <th class="text-right"><?php if ($status == 1) { ?>待<?php } else if ($status == 2) { ?>已<?php } ?>支付金额(元)</th>
            <th class="text-right">经销商利润(元)</th>
            <th class="text-right">经销商收款(元)</th>
            <th class="txt-center">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order) { ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo $order['order_no']; ?></td>
            <td>
                <?php if ($status == 2) { ?>
                付款方式：<?php if (!empty($order['use_deposit_pay'])) { ?>扣保证金<?php } else if ($order['payment_method'] == 'weixin') { ?>微信支付<?php } else { ?>其它<?php } ?><br/>
                <?php } ?>
                <span class="gray"><?php echo $order['third_id']; ?></span>
            </td>
            <td class="text-right"><?php echo $order['total']; ?></td>
            <td class="text-right"><?php echo $order['dealer_profit']; ?></td>
            <td class="text-right"><?php echo $order['sale_total']; ?></td>
            <td class="text-center">
                <a href="<?php dourl('fx:commission_detail', array('id' => $order['order_id'])); ?>">查看明细</a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
    <div class="js-list-empty-region">
        <div>
            <div class="no-result widget-list-empty">还没有相关数据。</div>
        </div>
    </div>
    <?php } ?>
</div>
<div class="js-list-footer-region ui-box">
    <div>
        <div class="pagenavi"><?php echo $page; ?>
        </div>
    </div>
</div>
</div>