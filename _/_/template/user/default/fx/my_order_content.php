<style type="text/css">
    .order-no {
        color: #FF6600;
    }
    .bgcolor {
        background-color: lightblue;
    }
    .popover.bottom .arrow {
        top: -4px;
        left: 50%;
        margin-left: -5px;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid #000;
    }
    .popover.bottom .arrow:after {
        top: 0px;
        margin-left: -10px;
        border-bottom-color: #ffffff;
        border-top-width: 0;
    }
    .cell-12 {
        color: black;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix">
        <div class="widget-list-filter">
            <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="clearfix">
                    <div class="filter-groups">
                        <div class="control-group">
                            <label class="control-label">订单号：</label>
                            <div class="controls">
                                <input type="text" name="order_no" value="<?php echo !empty($_POST['order_no']) ? $_POST['order_no'] : ''; ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">供货商：</label>
                            <div class="controls">
                                <select class="supplier-select js-supplier-select" name="supplier_id">
                                    <option value="0">所有供货商</option>
                                    <?php if (!empty($suppliers)) { ?>
                                        <?php foreach ($suppliers as $supplier) { ?>
                                            <option value="<?php echo $supplier['store_id']; ?>" <?php if ($supplier['store_id'] == $supplier_id) { ?>selected="true"<?php } ?>><?php echo $supplier['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="pull-left">
                        <div class="time-filter-groups clearfix">
                            <div class="control-group">
                                <label class="control-label">下单时间：</label>
                                <div class="controls">
                                    <input type="text" name="start_time" id="js-start-time" class="js-start-time" value="<?php echo !empty($_POST['start_time']) ? date('Y-m-d H:i:s', $_POST['start_time']) : ''?>" />
                                    <span>至</span>
                                    <input type="text" name="stop_time" id="js-end-time" class="js-end-time" value="<?php echo !empty($_POST['stop_time']) ? date('Y-m-d H:i:s', $_POST['stop_time']) : ''?>" />
                                    <span class="date-quick-pick" data-days="7">最近7天</span>
                                    <span class="date-quick-pick" data-days="30">最近30天</span>
                                </div>
                            </div>
                        </div>
                        <div class="filter-groups">
                            <div class="control-group">
                                <label class="control-label">订单状态：</label>
                                <div class="controls">
                                    <select class="state-select js-state-select" name="state">
                                        <option value="1">等待经销商付款</option>
                                        <option value="2">等待供货商发货</option>
                                        <option value="3">供货商已发货</option>
                                        <option value="4">交易完成</option>
                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在筛选...">筛选</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div></div>
    <div class="ui-box order-list-ui-box">
        <nav class="ui-nav clearfix">
            <ul class="pull-left">
                <li class="active status-1" data-status="1"><a href="#1">等我付款</a></li>
                <li class="status-2" data-status="2"><a href="#2">我已付款</a></li>
                <li class="status-3" data-status="3"><a href="#3">供货商已发货</a></li>
                <li class="status-4" data-status="4"><a href="#4">交易完成</a></li>
            </ul>
        </nav>
        <table class="ui-table-order" style="padding: 0px;">
            <?php if (!empty($orders)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="checkbox cell-35" colspan="2">
                        <label class="checkbox inline order-list">商品</label>
                    </th>
                    <th class="cell-12 text-right">单价(元)/数量</th>
                    <th class="cell-12 text-center">状态</th>
                    <th class="cell-12 text-center">下单时间</th>
                    <th class="cell-15 text-center">成交额(元)</th>
                </tr>
                </thead>
                <?php foreach ($orders as $order) { ?>
                <tbody class="widget-list-item">
                <tr class="separation-row">
                    <td colspan="6"></td>
                </tr>
                    <tr class="header-row">
                        <td colspan="5">
                            <div>
                                <label>
                                    <b class="order-no">订单号: <?php echo $order['order_no']; ?></b>
                                    <span class="c-gray">
                                        供货商：<?php echo $order['supplier']; ?>
                                    </span>
                                    <span class="c-gray">订单来源：<?php echo $order['seller']; ?></span>
                                </label>
                            </div>
                        </td>
                        <td colspan="1"><span class="c-gray">买家支付方式: <?php echo $payment_method[$order['buyer_payment_method']]; ?></span></td>
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
                                </p>
                            </td>
                            <td class="price-cell">
                                <p class="goods-price"><?php echo number_format($product['pro_price'] - $product['profit'], 2, '.', ''); ?></p>
                                <p>(<?php echo $product['pro_num']; ?>件)</p>
                            </td>
                            <?php if (count($order['products']) > 0 && $key == 0) { ?>

                                <td class="state-cell" rowspan="<?php echo count($order['products']); ?>">
                                    <div class="td-cont">
                                        <p class="js-order-state">
                                            <?php
                                                echo $ws_alias_status[$order['status']];
                                            ?>
                                        </p>
                                        <?php if (!empty($order['paid_time'])) { ?>
                                            <?php if (!empty($order['use_deposit_pay'])) { ?>
                                            <p>
                                                <span class="c-gray">支付方式: 扣保证金</span>
                                            </p>
                                            <?php } else { ?>
                                                <span class="c-gray">支付方式: 微信支付</span>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td class="time-cell" rowspan="<?php echo count($order['products']); ?>">
                                    <div class="td-cont">
                                        <?php echo $order['add_time']; ?>
                                    </div>
                                </td>
                                <td class="pay-price-cell" rowspan="<?php echo count($order['products']); ?>">
                                    <div class="price-container">
                                        <p class="goods-price">
                                            <?php echo $order['total']; ?>
                                            <br/>
                                            <span class="c-gray">(含运费: <?php echo $order['postage']; ?>)</span>
                                        </p>
                                    </div>
                                    <div class="td-cont text-center">
                                        <div>
                                            <?php if ($order['status'] == 1) { ?>
                                                <p><a href="<?php dourl('fx:recharge', array('store_id' => $order['supplier_id'])); ?>">保证金充值</a></p>
                                                <a href="javascript:;" data-id="<?php echo $order['fx_order_id']; ?>" class="js-pay-btn">给供货商付款</a>
                                                <span class="js-notes-cont hide">
                                                    <p>手机扫码支付：</p>
                                                    <p class="team-code">
                                                        <img src="<?php echo option('config.site_url')."/source/qrcode.php?type=pay&id=".$order['order_no']."&sid=" . $order['supplier_id']."&timestamp={timestamp}&paykey=". $order['paykey'] . '&payer=' . $order['payer'] . '&oid='. $order['my_order_id'];?>" alt="手机扫码支付" />
                                                    </p>
                                                    <p>
                                                        收款方：<?php if (!empty($order['wxpay'])) { ?><?php echo $order['supplier']; ?><?php } else { ?>平台代收款<?php } ?>
                                                    </p>
                                                </span>
                                            <?php } else { ?>
                                                <a href="<?php dourl('order_detail', array('id' => $order['fx_order_id'])); ?>">查看</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>

                </tbody>
                <?php } ?>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($orders)) { ?>
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($orders)) { ?>
            <div class="widget-list-footer">
                <!--<div class="pull-left">
                    <a href="javascript:;" class="ui-btn js-batch-pay">合并付款</a>
                </div>-->
                <div class="pagenavi"><?php echo $page; ?></div>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.js-pay-btn').hover(function(){
            var timestamp = Date.parse(new Date());
            var qrcode_url = $(this).next('.js-notes-cont').find('.team-code img').attr('src');
            qrcode_url = qrcode_url.replace(/\{timestamp\}/, timestamp);
            $(this).next('.js-notes-cont').find('.team-code img').attr('src', qrcode_url);
            var content = $(this).next('.js-notes-cont').html();
            $('.popover-intro').remove();
            var html = '<div class="js-intro-popover popover popover-intro bottom center" style="display: none; top: ' + ($(this).offset().top + $(this).height()) + 'px; left: ' + ($(this).offset().left - 65) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
            $('body').append(html);
            $('.popover-intro').show();
        }, function(){
            t = setTimeout('hide()', 200);
        })

        $('.popover-intro').live('mouseleave', function(){
            clearTimeout(t);
            hide();
        })

        $('.popover-intro').live('mouseover', function(){
            clearTimeout(t);
        })

        $('.js-help-notes').hover(function(){
            var content = $(this).next('.js-notes-cont').html();
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left - 250) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
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