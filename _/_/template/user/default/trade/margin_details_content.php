<style type="text/css">
    .page-margin .header {
        font-size: 14px;
        color: #333;
        background: #f8f8f8;
        height: 40px;
        line-height: 40px;
        padding-left: 12px;
        border-bottom: 1px solid #e5e5e5;
    }
</style>
<div>
    <div class="page-margin">
        <div class="ui-box">
            <div class="header"><a href="<?php dourl('trade:income'); ?>#platform_margin">平台保证金</a> >> 平台保证金流水</div>

            <div class="widget-list-filter clearfix">
                <form class="form-horizontal list-filter-form" onsubmit="return false;">
                    <div class="control-group">
                        <label class="control-label">时间：</label>
                        <div class="controls">
                            <input type="text" name="stime" class="js-stime" id="js-stime">
                            <span>至</span>
                            <input type="text" name="etime" class="js-etime" id="js-etime">
                            <span class="date-quick-pick" data-days="7">最近7天</span>
                            <span class="date-quick-pick" data-days="30">最近30天</span>

                            <span style="margin-left: 18px;">类型：</span>
                            <select name="type" class="js-type-select">
                                <option value="*">全部</option>
                                <?php foreach ($types as $key => $type) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">单号：</label>
                        <div class="controls">
                            <input type="text" name="order_no" class="span4" style="width: 283px;" placeholder="订单号/支付流水号" />
                            <span style="margin-left: 18px;">支付方式（充值）：</span>
                            <select name="payment_method" class="js-payment-select">
                                <option value="*">全部</option>
                                <?php foreach ($payment_methods as $key => $payment_method) { ?>
                                    <?php
                                    $pigcms_key = 'pay_'.$key.'_open';
                                    $pigcms_key2 = $key . '_open';
                                    if(empty($payment_method['config'][$pigcms_key]) && empty($payment_method['config'][$pigcms_key2])){
                                        continue;
                                    }
                                    ?>
                                    <option value="<?php echo $key; ?>"><?php echo $payment_method['name']; ?></option>
                                <?php } ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;
                            <button class="ui-btn ui-btn-primary js-filter" style="margin-left: 0;height: auto" data-loading-text="正在筛选...">筛选</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if (!empty($margin_logs)) { ?>
            <table class="ui-table ui-table-list" style="padding: 0px;margin-top:15px">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-15">订单号 | 支付流水号</th>
                    <th class="cell-20">类型</th>
                    <th class="cell-10 text-right">金额(元) </th>
                    <th class="cell-10 text-center">状态</th>
                    <th class="cell-10">备注</th>
                    <th class="cell-10 text-center">添加时间</th>
                    <th class="cell-10 text-right">余额(元)</th>
                    <th class="cell-25 text-right">总额(元)</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($margin_logs as $margin_log) { ?>
                <tr class="widget-list-item">
                    <td>
                    	<?php echo $margin_log['order_no']; ?>
                    	<?php 
                    	if ($margin_log['type'] == 0 && $margin_log['paid_time'] > 0 && $margin_log['trade_no']) {
                    		echo '<br /><span class="c-gray">' . $margin_log['trade_no'] . '</span><br/><span class="c-gray">' . (!empty($payment_methods[$margin_log['payment_method']]['name']) ? $payment_methods[$margin_log['payment_method']]['name'] : '其他') . '</span>';
                    	}
                    	?>
                    </td>
                    <td><?php echo $types[$margin_log['type']]; ?></td>
                    <td class="text-right ui-money <?php if ($margin_log['amount'] > 0) { ?>ui-money-income<?php } else { ?>ui-money-outlay<?php } ?>"><?php echo $margin_log['amount']; ?></td>
                    <td class="text-center"><?php echo $status[$margin_log['status']]; ?></td>
                    <td><?php echo $margin_log['bak']; ?></td>
                    <td class="text-center"><?php echo date('Y-m-d H:i:s', $margin_log['add_time']); ?></td>
                    <td class="text-right"><?php echo $margin_log['margin_balance']; ?></td>
                    <td class="text-right"><?php echo $margin_log['margin_total']; ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>

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
</div>