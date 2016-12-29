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
    .service-fee {
        color: gray;
        font-weight: normal;
        font-style: italic;
    }
    .exchange-amount {
        color: green;
        font-weight: normal;
        font-style: italic;
    }
</style>
<div>
    <div class="page-margin">
        <div class="ui-box">
            <div class="header"><a href="<?php dourl('trade:income'); ?>#platform_margin">平台保证金</a> >> 商家积分流水</div>

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
                            &nbsp;&nbsp;&nbsp;渠道：
                            <select name="channel" class="js-channel-select">
                                <option value="*">全部</option>
                                <?php foreach ($channels as $key => $channel) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $channel; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">单号：</label>
                        <div class="controls">
                            <input type="text" name="order_no" class="span4" style="width: 283px;" placeholder="订单号" />
                            <span style="margin-left: 18px;">类型：</span>
                            <select name="type" class="js-type-select">
                                <option value="*">全部</option>
                                <?php foreach ($types as $key => $type) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $type; ?></option>
                                <?php } ?>
                            </select>&nbsp;&nbsp;&nbsp;
                            <button class="ui-btn ui-btn-primary js-filter" style="margin-left: 0;height: auto" data-loading-text="正在筛选...">筛选</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php if (!empty($point_logs)) { ?>
            <table class="ui-table ui-table-list" style="padding: 0px;margin-top:15px">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-15">订单号 | 类型</th>
                    <th class="cell-10 text-right"><?php echo $point_alias; ?></th>
                    <th class="cell-10 text-center">状态</th>
                    <th class="cell-10 text-center">渠道</th>
                    <th class="cell-10">备注</th>
                    <th class="cell-10 text-center">添加时间</th>
                    <th class="cell-10 text-right">余额(<?php echo $point_alias; ?>)</th>
                    <th class="cell-25 text-right">总额(<?php echo $point_alias; ?>)</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($point_logs as $point_log) { ?>
                <tr class="widget-list-item">
                    <td><?php echo $types[$point_log['type']]; ?><br/><?php echo $point_log['order_no']; ?></td>
                    <td class="text-right ui-money <?php if ($point_log['point'] > 0) { ?>ui-money-income<?php } else { ?>ui-money-outlay<?php } ?>">
                        <?php echo $point_log['point']; ?><br/>
                        <?php if ($point_log['service_fee_rate'] > 0) { ?>
                        <span class="service-fee">服务费：<?php echo $point_log['service_fee_rate']; ?>%</span><br/>
                        <?php if ($point_log['type'] == 2) { ?>
                        <span class="exchange-amount">兑现金：<?php echo $point_log['amount']; ?>元</span>
                        <?php } ?>
                        <?php } ?>
                    </td>
                    <td class="text-center"><?php echo $status[$point_log['status']]; ?></td>
                    <td class="text-center"><?php echo $channels[$point_log['channel']]; ?></td>
                    <td><?php echo $point_log['bak']; ?></td>
                    <td class="text-center"><?php echo date('Y-m-d H:i:s', $point_log['add_time']); ?></td>
                    <td class="text-right"><?php echo $point_log['point_balance']; ?></td>
                    <td class="text-right"><?php echo $point_log['point_total']; ?></td>
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