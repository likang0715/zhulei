<style type="text/css">
    .page-settlement .account-info .account-info-meta label {
        line-height: 0px;
    }
    .page-settlement .account-info img {
        width:90px;
        height: 90px;
    }
    .money{
        font-size: 25px;
    }
    .page-settlement .balance .balance-info {
        width: 24.33%;
    }
    .widget {
        margin-bottom: 30px;
    }
    .widget .widget-head {
        position: relative;
        height: 20px;
        padding: 10px;
        padding-bottom: 30px;
        line-height: 20px;
        background: rgba(255,255,255,1);
    }
    .widget .widget-head .widget-title {
        display: inline-block;
        margin: 0 12px 0 0;
        padding: 0 0 0 10px;
        font-size: 14px;
        font-weight: bold;
        line-height: 20px;
    }
    .widget .widget-nav {
        font-size: 12px;
        display: inline-block;
        vertical-align: baseline;
    }
    .widget .widget-head .help {
        position: absolute;
        top: 10px;
        right: 14px;
    }
    .margin-total .arrow {
        left: 31%!important;
    }
    .margin-balance .arrow {
        left: 23%!important;
    }
    .point-total .arrow {
        left: 57%!important;
    }
    .point-balance .arrow {
        left: 57%!important;
    }
    .order-point .arrow, .pont2money .arrow {
        left: 57%!important;
    }
    .ui-nav-table li a {
        display: inline-block;
        padding: 0 12px;
        line-height: 35px;
        color: #333;
        border: 1px solid #ccc;
        background: #f8f8f8;
        min-width: 80px;
        text-align: center;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .ui-nav-table {
        position: relative;
        top: 2px;
    }
    .ui-nav-table li {
        float: left;
        margin-left: -1px;
    }
    .ui-nav-table li.active a {
        border-color: #E5E5E5 #E5E5E5 #fff;
        background: #F7F7F7;
        color: #07d;
    }
    .widget {
        margin-bottom: 30px;
        margin-top: 30px;
    }
    .widget .chart-body {
        clear: none;
        width: 100%;
        min-height: 281px;
        height: 281px;
        float: left;
    }
    .widget .widget-body {
        background: rgba(255,255,255,1);
        min-height: 150px;
    }
    .widget .chart-body {
        height: 310px;
    }
    .widget-pagedata .arrow {
        left: 93%!important;
    }
    .ui-block-head {
        position: relative;
        overflow: visible;
        height: 50px;
        line-height: 50px;
    }
    .ui-block-head>.block-title {
        display: inline-block;
        margin: 0 12px 0 0;
        padding: 0 0 0 10px;
        line-height: 20px;
        font-size: 16px;
    }
    .ui-block {
        margin-bottom: 15px;
    }
    .app-block-pagerank {
        background: #fff;
    }
    .app-block-pagerank .ui-table {
        border: none;
        border-top: 1px solid #ccc;
    }
    .ui-table th a {
        color: #07d;
    }
    .pagenavi {
        margin-top: 10px;
    }
    .page_input {
        margin-bottom: 5px!important;
    }
</style>
<div>
    <div class="page-settlement">
        <div class="ui-box settlement-info">
            <?php if ($open_margin_recharge && empty($_SESSION['store']['drp_supplier_id'])) { ?>
            <div class="balance">
                <div class="balance-info margin-total" style="border-left: none; position:relative">
                    <div class="balance-title">充值账户总额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>充值账户总额:</strong> 向平台缴纳的保证金总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['margin_total']; ?></span>
                        <span class="unit">元</span><br/>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo dourl('margin_details'); ?>">明细</a></span>
                    </div>
                </div>

                <div class="balance-info margin-balance" style="position:relative">
                    <div class="balance-title">充值账户余额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>充值账户余额:</strong> 平台充值账户尚未使用的余额</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['margin_balance']; ?></span>
                        <span class="unit">元</span><br/>
                        <?php if($store['is_show_recharge_button']) { ?>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo dourl('margin_recharge'); ?>">我要充值</a></span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('trade:income', array('to' => 'platform', 'withdrawal' => 'margin')); ?>#applywithdrawal">申请返还</a></span>
                        <?php } ?>
                    </div>
                </div>

                <div class="balance-info margin-balance" style="position:relative">
                    <div class="balance-title">已消耗充值金额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>已消耗充值金额:</strong> 店铺产生交易时，平台收取的服务费</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['margin_used']; ?></span>
                        <span class="unit">元</span><br/>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('margin_details', array('type' => 2)); ?>">明细</a></span>
                    </div>
                </div>

                <div class="balance-info point-total" style="position:relative">
                    <div class="balance-title">已充值返还金额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: -80px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>已充值返还金额:</strong> 已申请返还并提现的金额。</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="balance-content">
                        <span class="money"><?php echo $store['margin_returned']; ?></span>
                        <span class="unit">元</span><br/>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('margin_details', array('type' => 1)); ?>">明细</a></span>
                    </div>
                </div>

                <div style="clear: both"></div>
            </div>
            <div class="balance">
                <div class="balance-info margin-total" style="border-left: none; position:relative">
                    <div class="balance-title">累计商家积分总额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>累计商家积分总额:</strong> 商家获得的积分总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['point_total']; ?></span>
                        <span class="unit">积分</span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo dourl('point_details'); ?>">明细</a></span>
                    </div>
                </div>

                <div class="balance-info margin-balance" style="position:relative">
                    <div class="balance-title">商家积分余额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>商家积分余额:</strong> 商家剩余的可用积分。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['point_balance']; ?></span>
                        <span class="unit">积分</span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo dourl('point_exchange'); ?>">兑换</a></span>
                    </div>
                </div>

                <div class="balance-info margin-balance" style="position:relative">
                    <div class="balance-title">累计转可用积分
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>累计转可用积分:</strong> 商家转用户积分的总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['point2user']; ?></span>
                        <span class="unit">元</span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo dourl('point_details'); ?>">明细</a></span>
                    </div>
                </div>

                <div class="balance-info pont2money" style="position:relative">
                    <div class="balance-title">累计转可兑现现金
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: -80px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>累计转可兑现现金:</strong> 累计转可兑现现金总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['point2money_total']; ?></span>
                        <span class="unit">元</span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('point_details'); ?>">明细</a></span>
                    </div>
                </div>

                <div style="clear: both"></div>
            </div>

            <div class="balance">
                <div class="balance-info margin-total" style="border-left: none; position:relative">
                    <div class="balance-title">累计已兑现现金
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 25px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>累计已兑现现金:</strong> 商家积分兑现后已提现的总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['point2money_withdrawal']; ?></span>
                        <span class="unit">元</span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo dourl('income'); ?>&type=3#withdraw">明细</a></span>
                    </div>
                </div>

                <div class="balance-info margin-balance" style="position:relative">
                    <div class="balance-title">可兑现现金余额
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>可兑现现金余额:</strong> 商家积分兑现后可提现余额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['point2money_balance']; ?></span>
                        <span class="unit">元</span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php dourl('trade:income', array('to' => 'platform', 'withdrawal' => 'point2money')); ?>#applywithdrawal">提现</a></span>
                    </div>
                </div>

                <div class="balance-info margin-balance" style="position:relative">
                    <div class="balance-title">累计已扣兑现服务费
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: 35px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>累计已扣兑现服务费:</strong> 商家积分兑现平台收取的服务费总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['point2money_service_fee']; ?></span>
                        <span class="unit">积分</span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo dourl('point_details'); ?>#fee">明细</a></span>
                    </div>
                </div>

                <div class="balance-info order-point" style="position:relative">
                    <div class="balance-title">累计商家积分转做单
                        <div class="help"></div>
                        <div class="js-intro-popover popover popover-help-notes bottom" style="top: 15px; left: -80px; display: none;">
                            <div class="arrow"></div>
                            <div class="popover-inner">
                                <div class="popover-content">
                                    <p><strong>累计商家积分转做单:</strong> 线下做单使用商家积分抵服务费的积分总额。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="balance-content">
                        <span class="money"><?php echo $store['point2service_fee']; ?></span>
                        <span class="unit">积分</span>
                        <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo dourl('point_details'); ?>#order">明细</a></span>
                    </div>
                </div>

                <div style="clear: both"></div>
            </div>

            <div id="js-pagerank" class="ui-block app-block-pagerank ui-block-no-data">
                <div class="ui-block-head">
                    <h3 class="block-title"><?php echo $point_alias; ?>抵现</h3>
                </div>

                <div class="ui-block-body">
                    <?php if (!empty($orders)) { ?>
                    <div class="js-body">
                        <table class="ui-table">
                            <thead>
                            <tr>
                                <th>订单号</th>
                                <th class="text-right">支付金额(元)</th>
                                <th class="text-right">抵现<?php echo $point_alias; ?></th>
                                <th class="text-right">赠送<?php echo $point_alias; ?></th>
                                <th class="text-right">总额(元)</th>
                                <th class="text-right">服务费(元)</th>
                                <th class="text-left">下单用户</th>
                                <th class="text-center">渠道</th>
                                <th class="text-center">下单时间</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="js-list-tbody">
                            <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td><?php echo $order['order_no']; ?></td>
                                <td class="text-right"><?php echo $order['pay_money']; ?></td>
                                <td class="text-right"><?php echo $order['cash_point']; ?></td>
                                <td class="text-right"><?php echo $order['return_point']; ?></td>
                                <td class="text-right"><?php echo $order['total']; ?></td>
                                <td class="text-right"><?php echo $order['service_fee']; ?></td>
                                <td class="text-left"><?php echo $order['user']; ?></td>
                                <th class="text-center"><?php echo $order['channel']; ?></th>
                                <td class="text-center"><?php echo date('Y-m-d H:i:s', $order['add_time']); ?></td>
                                <td class="text-center"><a href="<?php dourl('order:detail', array('id' => $order['order_id'])); ?>">详细</a></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="js-list-footer-region ui-box">
                        <div class="widget-list-footer">
                            <div class="pagenavi"><?php echo $page; ?></div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="js-list-empty-region">
                        <div>
                            <div class="no-result widget-list-empty">还没有相关数据。</div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } else { ?>
                <div class="js-list-empty-region">
                    <div>
                        <div class="no-result widget-list-empty">您访问的页面不存在。</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
