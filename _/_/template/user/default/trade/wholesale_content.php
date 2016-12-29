<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="js-list-filter-region clearfix">
                <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                <div class="control-group">
                    <label class="control-label">订单号：</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="order_no" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">起止时间：</label>
                    <div class="controls">
                        <input type="text" name="stime" class="js-stime" id="js-stime" />
                        <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                        <input type="text" name="etime" class="js-etime" id="js-etime" />
                        <span class="date-quick-pick" data-days="7">最近7天</span>
                        <span class="date-quick-pick" data-days="30">最近30天</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否分佣：</label>
                    <div class="controls">
                        <select name="type" class="js-type-select">
                            <option value="0" selected="true">全部</option>
                            <option value="1">未分佣</option>
                            <option value="2">已分佣</option>
                        </select>
                        <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在查询...">查询</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <?php if (!empty($records)) { ?>
        <div style="padding: 5px;text-align: right">
            <b style="color: #07d">批发盈利小计(元)：<span class="ui-money-income"><?php echo $profit_sub_total; ?></span></b> / <b style="color: #07d">批发盈利总计(元)：<span class="ui-money-income"><?php echo $profit_total; ?></span></b>
        </div>
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-15">订单号</th>
                    <th class="cell-20">供货商</th>
                    <th class="cell-10 text-right">盈利(元) </th>
                    <th class="cell-10 text-right">成本(元)</th>
                    <th class="cell-10 text-center">日期</th>
                    <th class="cell-10 text-right">是否已分佣</th>
                    <th class="cell-25">支付渠道 | 单号</th>
                    <th class="cell-10">操作</th>
                </tr>
            </thead>
            <tbody class="js-list-body-region">
                <?php foreach ($records as $record) { ?>
                <tr class="widget-list-item">
                    <td>
                        <?php echo $record['order_no']; ?>
                        <br/>
                        <span class="c-gray"><?php echo $record['trade_no']; ?></span>
                    </td>
                    <td>
                        <span><?php echo $record['supplier']; ?></span>
                    </td>
                    <td class="text-right ui-money ui-money-income"><?php echo $record['profit']; ?></td>
                    <td class="text-right ui-money ui-money-outlay"><?php echo $record['income']; ?></td>
                    <td class="text-center"><?php echo date('Y-m-d H:i:s', $record['add_time']); ?></td>
                    <td class="text-center"><?php if ($record['status'] == 3) { ?>已分佣<?php } else { ?>未分佣<?php } ?></td>
                    <td>
                        <?php echo $payment_methods[$record['payment_method']]; ?>
                        <br/>
                        <span class="c-gray"><?php echo $record['third_id']; ?></span>
                    </td>
                    <td>
                        <a href="<?php echo dourl('fx:commission_detail', array('id' => $record['order_id'])); ?>" target="_blank">详情</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
        <div class="js-list-empty-region">
            <?php if (empty($records)) { ?>
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div class="widget-list-footer">
            <div class="pagenavi"><?php echo $page; ?></div>
        </div>
    </div>
</div>