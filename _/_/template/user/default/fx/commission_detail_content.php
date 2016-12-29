<style type="text/css" xmlns="http://www.w3.org/1999/html">
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
    .section-title .sub-title {
        font-size: 12px;
        font-weight: normal;
        height: 34px;
        line-height: 34px;
    }
    .order-no {
        width: 270px;
        color: #FF6600;
        float: left;
    }
    .postage {
        float: left;
    }
   .store-name {
        width: 250px;
        float: left;
        display:block;
       white-space:nowrap;
       overflow:hidden;
       text-overflow:ellipsis;
    }
    .profit {
        width: 200px;
        color:green;
        float: right;
        text-align: right;
    }
    .align-right {
        text-align: right!important;
    }
    .hide {
        display: none!important;
    }
    .open-close {
        display: inline-block;
        font-weight: normal;
        font-size: 12px;
        margin-left: 20px;
    }
    .tb-total {
        color:green;
        font-weight: bold;
    }
    .tb-cost-price {
        color:red;
        font-weight: bold;
    }
    .desc {
        padding:10px 0 0 10px;
        color:gray;
        border: 1px dashed #E4E4E4;
    }
    .ui-money-return {
        color:red;
        font-weight: bold;
    }
    .bgcolor{
        background-color: lightblue;
    }
    .disabled {
        color: grey;
        text-decoration:line-through;
    }
</style>
<h1 class="order-title">订单号：<?php echo $order['order_no']; ?></h1>
<div class="section">
    <h2 class="section-title clearfix">订单概况</h2>
    <div class="section-detail clearfix">
        <div class="pull-left">
            <table>
                <tbody>
                <tr>
                    <td>订单状态：</td>
                    <td><?php echo $status[$order['status']]; ?> <?php if ($order['status'] == 5) { ?><?php if ($order['cancel_method'] == 1) { ?>(卖家取消)<?php } else if ($order['cancel_method'] == 2) { ?>(买家取消)<?php } else { ?>(自动过期)<?php } ?><?php } ?></td>
                </tr>
                <tr>
                    <td>订单金额：</td>
                    <td><strong class="ui-money-income">￥<?php echo $order['total']; ?></strong>（含运费 <?php echo $order['postage']; ?> ）</td>
                </tr>
                <?php if ($order['type'] != 5) { ?>
                <tr>
                    <td>实付金额：</td>
                    <td><strong class="ui-money-income">￥<?php echo $order['pay_amount']; ?></strong>（含运费 <?php echo $order['postage']; ?> ）</td>
                </tr>
                <?php if ($order['service_fee'] > 0) { ?>
                <tr>
                    <td>服务费：</td>
                    <td><strong class="ui-money-income" style="color: red;">￥<?php echo $order['service_fee']; ?></strong></td>
                </tr>
                <?php } ?>
                <?php } ?>
                <?php if ($order['cash_point'] > 0) { ?>
                <tr>
                    <td>订单抵现：</td>
                    <td><strong class="ui-money-income"><?php echo $order['cash_point']; ?></strong>（<?php echo $point_alias; ?>）&nbsp;&nbsp;&nbsp;抵现金额：<b class="ui-money-income">￥<?php echo number_format($order['cash_point'] / $order['point2money_rate'], 2, '.', ''); ?></b> <?php if ($order['point_trade_fee'] > 0) { ?>&nbsp;&nbsp;&nbsp;流转服务费扣：<b style="color:red"><?php echo $order['point_trade_fee']; ?> <?php echo $point_alias; ?></b><?php } ?></td>
                </tr>
                <?php } ?>
                <?php if ($order['return'] > 0) { ?>
                <tr>
                    <td><b>退货款：</b></td>
                    <td><b class="ui-money-return">￥<?php echo $order['return']; ?></b></td>
                </tr>
                <?php } ?>
                <?php if ($order['my_return_profit'] > 0) { ?>
                <tr>
                    <td><b>分润减：</b></td>
                    <td><b class="ui-money-return">￥<?php echo $order['my_return_profit']; ?></b></td>
                </tr>
                <?php } ?>
                <tr>
                    <td>消费者：</td>
                    <td><?php echo !empty($order['buyer']) ? $order['buyer']: $order['address_user']; ?> <?php if ($order['points'] > 0) { ?>(<span class="ui-money-income">获赠 <?php echo $order['points']; ?> 积分</span>)<?php } ?></td>
                </tr>
                <tr>
                    <td>手机号：</td>
                    <td><?php echo !empty($order['phone']) ? $order['phone'] : $order['address_tel'];?></td>
                </tr>
                <?php if ($order['return_point'] > 0) { ?>
                    <tr>
                        <td>消费获赠：</td>
                        <td><strong class="ui-money-income"><?php echo $order['return_point']; ?></strong>（<?php echo $point_alias; ?>）</td>
                    </tr>
                <?php } ?>
                <tr>
                    <td>订单来源：</td>
                    <td><?php echo $order['from']; ?></td>
                </tr>
                <tr>
                    <td>付款方式：</td>
                    <td><?php echo $order['payment_method']; ?></td>
                </tr>
                <tr>
                    <td>物流方式：</td>
                    <td>
                        <?php
                        if ($order['shipping_method'] == 'express' || $order['shipping_method'] == 'friend') {
                            ?>
                            快递配送
                            <?php
                        } else if ($order['shipping_method'] == 'selffetch') {
                            echo $store_session['buyer_selffetch_name'] ? $store_session['buyer_selffetch_name'] : '上门自提';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>收货地址：</td>
                    <td><?php echo $order['address']['province']; ?> <?php echo $order['address']['city']; ?> <?php echo $order['address']['area']; ?> <?php echo $order['address']['address']; ?></td>
                </tr>
                <tr>
                    <td>收货人：</td>
                    <td><?php echo $order['address_user']; ?></td>
                </tr>
                <tr>
                    <td>联系电话：</td>
                    <td><?php echo $order['address_tel']; ?></td>
                </tr>
                <tr>
                    <td>买家留言：</td>
                    <td style="color:red"><?php echo $order['comment']; ?></td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="pull-right section-sidebar" style="color: green">
            <?php $money = 0; ?>
            <!--满减-->
            <?php if (!empty($order['activities']['order_ward_list'])) { ?>
                <?php foreach ($order['activities']['order_ward_list'] as $order_ward_list) { ?>
                    <?php foreach ($order_ward_list as $order_ward) { ?>
                    <p><?php echo getRewardStr($order_ward['content']); $money += $order_ward['content']['cash']; ?></p>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

            <!--优惠券-->
            <?php if (!empty($order['activities']['order_coupon_list'])) { ?>
                <?php foreach ($order['activities']['order_coupon_list'] as $order_coupon) { ?>
                    <p><?php echo $order_coupon['name'] ?> - <?php echo $order_coupon['money']; $money += $order_coupon['money']; ?>元</p>
                <?php } ?>
            <?php } ?>

            <!--折扣-->
            <?php if (!empty($order['activities']['discount_money']) && !empty($order['activities']['order_discount_list'])) { ?>
            <p>会员享 <?php echo $order['activities']['order_discount_list'][1]; ?> 折 (减<?php echo number_format($order['activities']['discount_money'], 2, '.', ''); $money += $order['activities']['discount_money']; ?>元)</p>
            <?php } ?>

            <!--用户积分抵现-->
            <?php if (!empty($order['activities']['order_point']) && $order['activities']['order_point']['money'] > 0) { ?>
                <p>积分抵现 <?php echo number_format($order['activities']['order_point']['money'], 2, '.', ''); $money += $order['activities']['order_point']['money']; ?> 元 (消耗 <?php echo $order['activities']['order_point']['point']; ?> 积分)</p>
            <?php } ?>
            <!--积分-->
            <?php if (!empty($order['points'])) { ?>
            <p>赠送 <?php echo $order['points']; ?> 积分</p>
            <?php } ?>

            <?php if ($money > 0) { ?>
            <p><b>共减免 <?php echo number_format($money, 2, '.', ''); ?> 元</b></p>
            <?php  } ?>
        </div>
    </div>
</div>

<?php foreach ($orders as $order) { ?>
<div class="section section-express">
    <div class="section-title clearfix">
        <div class="sub-title">
            <div class="store-name"><?php if (!empty($order['seller_drp_level'])){ ?><span style="color: red"><?php echo $order['seller_drp_level']; ?></span> 级分销商<?php } else { ?><?php if ($order['is_wholesale']) { ?>经销商<?php } else { ?>供货商<?php } ?><?php } ?>：<a href="<?php echo $order['seller_store']; ?>" target="_blank"><?php echo $order['seller']; ?></a></div>
            <div class="order-no"><?php if (empty($order['user_order_id'])) { ?>主订单号<?php } else { ?>订单号<?php } ?>：<?php echo $order['order_no']; ?></div>
            <div class="postage">运费：<?php echo $order['supplier_postage']; ?></div>
            <div class="profit"><?php if ($order['profit'] >= 0) { ?>利润：+<?php echo number_format($order['profit'], 2, '.', ''); ?><?php } else { ?><span style="color: red;">亏损：<?php echo number_format(abs($order['profit']), 2, '.', ''); ?></span><?php } ?><span class="open-close"><a href="javascript:void(0);">+ 展开</a></span></div>
        </div>
    </div>
    <div class="section-detail" style="display: none">
        <table class="table order-goods">
            <thead>
            <tr>
                <th class="tb-thumb"></th>
                <th class="tb-name">商品名称</th>
                <th class="tb-pric align-right">成本价（元）</th>
                <?php if (!empty($order['is_fx'])) { ?>
                <th class="tb-price align-right">零售价（元）</th>
                <?php } else if ($order['type'] == 5) { ?>
                <th class="tb-price align-right">批发价（元）</th>
                <?php } else { ?>
                <th class="tb-price align-right">分销价（元）</th>
                <?php } ?>
                <th class="tb-num align-right">数量</th>
                <th class="tb-total align-right">利润（元）</th>
                <th class="tb-postage align-right">运费（元）</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $key = 0;
                foreach ($order['products'] as $product) { ?>
                <?php $skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; ?>
                <?php $comments = !empty($product['comment']) ? unserialize($product['comment']) : ''; ?>
                <tr data-order-id="<?php echo $order['order_id']; ?>">
                    <td class="tb-thumb" <?php if (!empty($comments)) { ?>rowspan="2"<?php } ?>><img src="<?php echo $product['image']; ?>" width="60" height="60" /></td>
                    <td class="tb-name">
                        <a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>&store_id=<?php echo $order['store_id']; ?>" class="new-window" target="_blank"><?php echo $product['name']; ?></a>
                        <?php if ($skus) { ?>
                            <p>
                                <span class="goods-sku"><?php foreach ($skus as $sku) { ?><?php echo $sku['name']; ?>: <?php echo $sku['value']; ?>&nbsp;<?php } ?></span>
                                <?php if (!empty($product['return_status'])) { ?>
                                    <span class="platform-tag" style="background-color: #999;">已退货 <?php if (!empty($product['return_quantity'])) { ?>x<?php echo $product['return_quantity']; ?><?php } ?></span>
                                <?php } ?>
                            </p>
                        <?php } else { ?>

                            <?php if (!empty($product['return_status'])) { ?>
                            <p>
                                <span class="platform-tag" style="background-color: #999;">已退货 <?php if (!empty($product['return_quantity'])) { ?>x<?php echo $product['return_quantity']; ?><?php } ?></span>
                             </p>
                            <?php } ?>

                        <?php } ?>
                        <p><a href="javascript:void(0);">商品来源：<?php echo $product['from']; ?></a></p>
                    </td>
                    <td class="tb-price tb-cost-price align-right"><?php echo $product['cost_price']; ?></td>
                    <td class="tb-price align-right"><?php echo $product['pro_price']; ?></td>
                    <td class="tb-num align-right"><?php echo $product['pro_num']; ?></td>
                    <td class="tb-total align-right">
                        <span <?php if ($order['profit'] < 0) { ?>class="disabled"<?php } ?>>+<?php echo $product['profit']; ?></span>
                        <?php if ($product['drp_degree_profit'] > 0) { ?><br/><span style="color:green;font-weight: normal;">(含：<?php echo $order['drp_degree_name']; ?>奖励 +<?php echo number_format($product['drp_degree_profit'], 2, '.', ''); ?>)</span><?php } ?></td>
                    <?php if (count($order['comment_count']) > 0 && $key == 0) { ?>
                        <td class="tb-postage align-right" rowspan="<?php echo $order['rows']; ?>">
                            <?php echo $order['postage']; ?>
                        </td>
                    <?php } ?>
                </tr>
                <?php if (!empty($comments)) { ?>
                    <?php foreach ($comments as $comment) { ?>
                        <tr class="msg-row">
                            <td colspan="5"><?php echo $comment['name']; ?>：<?php echo $comment['value']; ?><br></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php $key++; } ?>
            </tbody>
        </table>
        <style type="text/css">
            .tb-total td:first-child {
                width: auto;
            }
        </style>
        <div class="clearfix section-final tb-total">
            <div class="pull-right text-right">
                <table>
                    <tbody>
                    <tr>
                        <td>商品小计（元）:</td>
                        <td><?php echo $order['sub_total']; ?></td>
                    </tr>
                    <tr>
                        <td>运费（元）:</td>
                        <td><span class="order-postage"><?php echo $order['postage']; ?></span></td>
                    </tr>
                    <?php if (!empty($order['float_amount']) && $order['float_amount'] != '0.00') { ?>
                        <tr>
                            <td>卖家改价（元）:</td>
                            <?php if ($order['float_amount'] > 0) { ?>
                                <td>+<?php echo $order['float_amount']; ?></td>
                            <?php } else { ?>
                                <td>-<?php echo number_format(abs($order['float_amount']), 2, '.', ''); ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    <?php if (!empty($main_order['activities']['order_point']) && $main_order['activities']['order_point']['money'] > 0) { ?>
                    <tr>
                        <td>积分抵现（元）:</td>
                        <td><span class="ui-money-income" style="color: red;"><span class="order-total">-<?php echo $main_order['activities']['order_point']['money']; ?></span></span></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td>应收款（元）:</td>
                        <td><span class="ui-money-income"><span class="order-total"><?php echo $order['total']; ?></span></span></td>
                    </tr>
                    <?php if ($order['drp_degree_profit'] > 0) { ?>
                        <tr>
                            <td><?php echo $order['drp_degree_name']; ?>奖励（元）:</td>
                            <td><span class="ui-money-income"><span class="order-total"><?php echo $order['drp_degree_profit']; ?></span></span></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td><b><?php if (!empty($supplier['drp_supplier_id'])) { ?>分销利润（元）:<?php } else { ?><?php if ($order['profit'] >= 0) { ?>利润<?php } else { ?>亏损<?php } ?>（元）:<?php } ?></b></td>
                        <td><span class="ui-money-income" <?php if ($order['profit'] < 0) { ?>style="color: red"<?php } ?>><span class="order-total"><b><?php echo number_format(abs($order['profit']), 2, '.', ''); ?></b></span></span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="desc">
    <p>* <b>主订单号：</b>消费者订单的订单号</p>
    <p>* <b>订单号：</b>上级分销商及供货商订单的订单号</p>
    <p>* <b>零售价：</b>终端销售价格</p>
    <p>* <b>批发价：</b>经销商批发供货商商品的批发价格</p>
    <p>* <b>分销价：</b>下级分销商分销上级分销商或供货商的商品的分销价格</p>
    <p>* <b>退货减：</b>消费者申请退货的金额</p>
    <p>* <b>实付金额：</b>消费者下单时支付的金额减退货金额</p>
    <p>* <b>积分抵现：</b>用户使用商家赠送的积分抵现，抵现部分成本由商家承担，分销商利润不受影响。</p>
</div>
