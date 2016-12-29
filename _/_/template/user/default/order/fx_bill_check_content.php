<style type="text/css">
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
    a.new-window {
        color: #4a4a4a;
    }
    a {
        color: #07d;
        text-decoration: none;
    }
    .order-no {
        color: #FF6600;
    }
    .popover-inner {
        padding: 3px;
        width: 320px;
        overflow: hidden;
        background: #000000;
        background: rgba(0, 0, 0, 0.8);
        border-radius: 4px;
        -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    }
    .popover.bottom .arrow {
        /* left: 50%; */
        margin-left: 105px;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid #000000;
    }
    .popover.bottom .arrow:after {
        top: 1px;
        border-bottom-color: #ffffff;
        border-top-width: 0;
    }
    .team-opt-wrapper .block-help>a:hover {
        background: #4b0;
        color:#fff
    }


    .block-help>a {
        display: inline-block;
        width: 16px;
        height: 16px;
        line-height: 18px;
        border-radius: 8px;
        font-size: 12px;
        text-align: center;
        background: #bbb;
        color: #fff;
    }
    .block-help>a:after {
        content: "?";
    }
    .bgcolor {
        background-color: lightblue;
    }
    .goods-image {
        width: 60px;
        height: 60px;
        text-align: center;
        cursor: pointer;
    }
    .goods-image img {
        max-width: 60px;
        max-height: 60px;
        vertical-align: middle;
    }
    .ui-table-order {
        width: 100%;
    }
</style>
<?php if (!empty($is_check)) { ?>
<div class="ui-box orders">
    <?php if (empty($orders)) { ?>
    <?php include display('_empty'); ?>
    <?php } else { ?>
        <table class="ui-table-order">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <tr>
                <th class="" colspan="2">商品</th>
                <th class="price-cell">单价/数量</th>
                <th class="time-cell">下单时间</th>
                <th class="customer-cell">订单金额(元)
                <span class="block-help">
					<a href="javascript:void(0);" class="js-help-notes"></a>
					<div class="js-notes-cont hide">
                        <p><strong>订单金额：</strong>粉丝购买时实际支付的金额。</p>
                    </div>
				</span>
                </th>
                <th class="state-cell">对账金额(元)
                <span class="block-help">
					<a href="javascript:void(0);" class="js-help-notes"></a>
					<div class="js-notes-cont hide">
                        <p><strong>对账金额：</strong><?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>每笔订单供货商应给分销商的分销佣金。<?php } else { ?>每笔分销订单您所获得的分销佣金。<?php } ?></p>
                    </div>
				</span>
                </th>
                <th class="pay-price-cell"></th>
            </tr>
            </thead>
            <?php foreach ($orders as $order) { ?>
                <tbody>
                    <tr class="separation-row">
                        <td colspan="7"></td>
                    </tr>
                    <tr class="header-row">
                        <td colspan="5">
                            <div>
                                <b class="order-no">订单号: <?php echo $order['order_no']; ?></b>
                                <span><?php if (array_key_exists($order['payment_method'], $payment_method)) { ?><?php echo $payment_method[$order['payment_method']]; ?><?php } ?></span>
                                <?php if ($order['type'] == 3) { ?>
                                    <span class="c-gray">订单来源：<?php echo $order['seller']; ?></span>
                                <?php } ?>
                            </div>
                            <div class="clearfix">
                                <?php if (!empty($order['trade_no'])) { ?>
                                    <div style="margin-top: 4px;margin-right: 20px;" class="pull-left">
                                        外部订单号: <span class="c-gray"><?php echo $order['trade_no']; ?></span>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($order['third_id'])) { ?>
                                    <div style="margin-top: 4px;" class="pull-left">
                                        支付流水号: <span class="c-gray"><?php echo $order['third_id']; ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </td>
                        <td colspan="2" class="text-right">

                        </td>
                    </tr>

                    <?php foreach ($order['products'] as $key => $product) { ?>
                        <tr class="content-row">
                            <td class="image-cell">
                                <img src="<?php echo $product['image']; ?>" />
                            </td>
                            <td class="title-cell">
                                <p class="goods-title">
                                    <a href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>&store_id=<?php echo $_SESSION['store']['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                                        <?php echo $product['name']; ?>
                                    </a>
                                </p>
                                <p>
                                    <?php $skus = !empty($product['sku_data']) ? unserialize($product['sku_data']) : ''; ?>
                                    <?php if ($skus) { ?>
                                        <?php foreach ($skus as $sku) { ?>
                                            <span class="goods-sku"><?php echo $sku['value']; ?></span>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if (!empty($product['return_status'])) { ?>
                                        <span class="platform-tag" style="background-color: #999;">已退货 <?php if (!empty($product['return_quantity'])) { ?>x<?php echo $product['return_quantity']; ?><?php } ?></span>
                                    <?php } ?>
                                </p>
                            </td>
                            <td class="price-cell">
                                <p><?php echo $product['pro_price']; ?></p>
                                <p>(<?php echo $product['pro_num']; ?>件)</p>
                            </td>
                            <?php if (count($order['products']) > 0 && $key == 0) { ?>
                                <td class="time-cell" rowspan="<?php echo count($order['products']); ?>">
                                    <div class="td-cont">
                                        <?php echo date('Y-m-d H:i:s', $order['add_time']); ?>
                                    </div>
                                </td>
                                <td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
                                    <div class="td-cont">
                                        <p class="js-order-state"><span class="order-total"><?php echo $order['total']; ?></span></p>
                                    </div>
                                </td>
                                <td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
                                    <div class="td-cont">
                                        <p class="js-order-state">
                                            <span class="order-total"><?php echo $order['check_amount']; ?></span>
                                        </p>
                                    </div>
                                </td>
                                <td class="state-cell" rowspan="<?php echo count($order['products']); ?>">
                                    <div class="td-cont text-center">
                                        <?php if ($is_check < 2) { ?>
                                        <?php if (empty($_SESSION['store']['drp_supplier_id'])) { ?>
                                        <div>
                                            <a href="javascript:;" data-order-id="<?php echo $order['original_order_id']; ?>" class="btn btn-small js-comfirm-check">确认对账</a>
                                        </div>
                                        <?php } else { ?>
                                        <div>
                                            <a href="javascript:;" class="btn btn-small" style="background: lightgray;cursor: no-drop;">未对账</a>
                                        </div>
                                        <?php } ?>
                                        <br/>
                                        <?php } else { ?>
                                        <div>
                                            <a href="javascript:;" class="btn btn-small" style="background: lightgray;cursor: no-drop;">已对账</a>
                                        </div>
                                        <br/>
                                        <?php } ?>
                                        <p>
                                            <a href="<?php dourl('fx:commission_detail', array('id' => $order['order_id'])); ?>" class="js-order-detail">分润明细</a>
                                        </p>
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    <?php foreach ($order['sellers'] as $seller) { ?>
                    <tr>
                        <td colspan="7">
                            <b><span style="color: red;"><?php echo $seller['drp_level']; ?></span>级分销商</b>【<?php echo $seller['name']; ?>】对账金额：<b style="color:green"><?php echo $seller['check_amount']; ?></b> 元
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            <?php } ?>
        </table>
    <?php } ?>
</div>
<?php } else { ?>
<div class="ui-box orders">
    <?php if (empty($sellers)) { ?>
        <?php include display('_empty'); ?>
    <?php } else { ?>
        <table class="ui-table-order">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <tr class="widget-list-header">
                <th colspan="2">分销商</th>
                <th>客服电话</th>
                <th style="text-align: center">客服 QQ</th>
                <th>客服微信</th>
                <th style="text-align: right">未对账佣金(元)</th>
                <th style="">已对账佣金(元)</th>
                <th style="text-align: right">未对账订单</th>
                <th>销售额(元)</th>
            </tr>
            </thead>
            <?php foreach ($sellers as $seller) { ?>
                <tbody>
                <tr class="widget-list-item">
                    <td class="goods-image-td">
                        <div class="goods-image">
                            <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['store_id']; ?>" target="_blank">
                                <img src="<?php echo $seller['logo']; ?>" />
                            </a>
                        </div>
                    </td>
                    <td class="goods-meta">
                        <a class="new-window" href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['store_id']; ?>" target="_blank">
                            <?php if (isset($_POST['keyword']) && $_POST['keyword'] != '') { ?>
                                <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $seller['name']); ?>
                            <?php } else { ?>
                                <?php echo $seller['name']; ?>
                            <?php } ?>
                        </a>
                        <br /><span style="color: orange"><?php echo $seller['drp_level']; ?>&nbsp;级分销商</span>
                    </td>
                    <td>
                        <?php echo $seller['service_tel']; ?>
                    </td>
                    <td>
                        <?php if (!empty($seller['service_qq'])) { ?>
                            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $seller['service_qq']; ?>&amp;site=qq&amp;menu=yes"><img src="<?php echo TPL_URL; ?>/images/qq.png" /></a>
                        <?php } else { ?>
                            <img src="<?php echo TPL_URL; ?>/images/unqq.png" />
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo $seller['service_weixin']; ?>
                    </td>
                    <td style="text-align: right">
                        <a href="<?php dourl('fx_bill_check', array('store_id' => $seller['store_id'])); ?>#uncheck"><?php echo $seller['uncheck_profit']; ?></a>
                    </td>
                    <td style="text-align: right">
                        <a href="javascript:void(0)"><?php echo $seller['checked_profit']; ?></a>
                    </td>
                    <td style="text-align: right">
                        <a href="<?php dourl('fx_bill_check', array('store_id' => $seller['store_id'])); ?>#uncheck"><?php echo $seller['uncheck_order']; ?></a>
                    </td>
                    <td style="text-align: right">
                        <a href="<?php dourl('fx:statistics', array('store_id' => $seller['store_id'])); ?>"><?php echo $seller['sales']; ?></a>
                    </td>
                </tr>
                </tbody>
            <?php } ?>
        </table>
    <?php } ?>
</div>
<?php } ?>
<div class="js-list-footer-region ui-box"><div><div class="pagenavi"><?php echo $page; ?></div></div></div></div>
<script type="text/javascript">
    var t2 = '';
    var t0 = '';
    $('.js-help-notes').hover(function(){
        var content = $(this).next('.js-notes-cont').html();
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left-40) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
        $('body').append(html);
        $('.popover-help-notes').show();
    }, function(){
        t2 = setTimeout('hide2()', 200);
    })
    $('.popover-help-notes').live('hover', function(event){
        if (event.type == 'mouseenter') {
            clearTimeout(t2);
        } else {
            clearTimeout(t2);
            hide2();
        }
    })
    function hide() {
        $('.popover-intro').remove();
    }
    function hide2() {
        $('.popover-help-notes').remove();
    }
    function msg_hide() {
        $('.notifications').html('');
        clearTimeout(t0);
    }
</script>