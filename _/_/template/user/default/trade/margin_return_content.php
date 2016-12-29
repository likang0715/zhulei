<script type="text/javascript">
    var margin_returns = parseFloat("<?php echo count($margin_returns); ?>");
</script>
<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="js-list-filter-region clearfix">
                <form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
                    <div class="control-group">
                        <label class="control-label">
                            起止时间：
                        </label>
                        <div class="controls">
                            <input type="text" name="stime" class="js-stime" id="js-stime" />
                            <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                            <input type="text" name="etime" class="js-etime" id="js-etime" />
                            <span class="date-quick-pick" data-days="7">最近7天</span>
                            <span class="date-quick-pick" data-days="30">最近30天</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">
                            返还状态：
                        </label>
                        <div class="controls">
                            <select name="status" class="js-status-select">
                                <option value="0" selected="">全部</option>
                                <?php foreach ($status as $key => $value) { ?>
                                <?php if ($key > 0) { ?>
                                <option value="<?php echo $key; ?>" <?php if ($default_status == $key) { ?>selected<?php } ?>><?php echo $value; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <a href="javascript:;" class="ui-btn ui-btn-primary js-filter" data-loading-text="正在查询...">查询</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <?php if (!empty($margin_returns)) { ?>
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-10">申请时间</th>
                    <th class="cell-22">提现银行 | 编号</th>
                    <th class="cell-12 text-right">返还金额(元)</th>
                    <th class="cell-15">状态</th>
                    <th class="cell-15">申请人</th>
                    <th class="cell-12 text-right">余额(元)</th>
                    <th class="cell-12 text-right">总额(元)</th>
                    <th class="cell-15">备注</th>
                </tr>
            </thead>
            <tbody class="js-list-body-region">
                <?php foreach ($margin_returns as $margin_return) { ?>
                <tr class="widget-list-item">
                    <td width="90"><?php echo date('Y-m-d H:i:s', $margin_return['add_time'])?></td>
                    <td width="195">
                        <?php if (!empty($store['bank_id'])) { ?>
                        <?php if ($store['withdrawal_type']) { ?>公司账户<?php } else { ?>个人账户<?php } ?> |
                        <span class="js-bank-detail" style="cursor: pointer;"><?php echo mb_substr($bank['name'], 0, 4, 'UTF-8'); ?>...<?php echo substr($store['bank_card'], -4); ?><b class="caret" data-bank="<?php echo $bank['name']; ?>" data-opening-bank="<?php echo $store['opening_bank']; ?>" data-bank-card="<?php echo $store['bank_card']; ?>" data-bank-account="<?php echo $store['bank_card_user']; ?>"></b></span>
                        <?php } else { ?>
                        无
                        <?php } ?>
                        <br>
                        <span class="c-gray"><?php echo $margin_return['order_no']; ?></span>
                    </td>
                    <td class="text-right ui-money-outlay"><?php echo $margin_return['amount']; ?></td>
                    <td class=""><?php echo $status[$margin_return['status']]; ?></td>
                    <td>
                        <?php echo $user['nickname']; ?>
                        <br>
                        <span class="c-gray"><?php echo $store['tel']; ?></span>
                    </td>
                    <td class="text-right"><?php echo $margin_return['margin_total']; ?></td>
                    <td class="text-right"><?php echo $margin_return['margin_balance']; ?></td>
                    <td>
                        <?php echo $margin_return['bak']; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } ?>
        <div class="js-list-empty-region">
            <?php if (empty($margin_returns)) { ?>
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