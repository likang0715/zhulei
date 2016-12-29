<style type="text/css">
    .ui-money-outlay {
        color: #f00;
        font-weight: bold;
    }
    .caret {
        display: inline-block;
        width: 0;
        height: 0;
        vertical-align: top;
        border-top: 4px solid #000000;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
        content: "";
    }
    .caret {
        margin-top: 7px;
        margin-left: 5px;
    }
    .popover.bottom {
        margin-left: -15px!important;
    }
    .popover-content > .js-content {
        font-size: 12px;
    }
</style>
<div class="goods-list">
    <div>
        <?php if (!empty($withdrawal_records)) { ?>
        <table class="ui-table ui-table-list" style="padding: 0px;">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                    <tr class="widget-list-header">
                        <th style="text-align: center">ID</th>
                        <th style="text-align: right">提现金额(元)</th>
                        <th>提现银行 | 编号</th>
                        <th style="text-align: center">申请时间</th>
                        <th style="text-align: center">状态</th>
                        <th style="text-align: center">备注</th>
                        <th style="text-align: center;width: 132px;">操作</th>
                    </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($withdrawal_records as $withdrawal_record) { ?>
                    <tr class="widget-list-item">
                        <td style="text-align: center"><?php echo $withdrawal_record['pigcms_id']; ?></td>
                        <td class="text-right ui-money-outlay"><?php echo number_format($withdrawal_record['amount'], 2, '.', ''); ?></td>
                        <td>
                            <?php if ($withdrawal_record['withdrawal_type']) { ?>公司账户<?php } else { ?>个人账户<?php } ?> |
                            <span class="js-bank-detail" style="cursor: pointer;"><?php echo mb_substr($withdrawal_record['bank'], 0, 4, 'UTF-8'); ?>...<?php echo substr($withdrawal_record['bank_card'], -4); ?><b class="caret" data-bank="<?php echo $withdrawal_record['bank']; ?>" data-opening-bank="<?php echo $withdrawal_record['opening_bank']; ?>" data-bank-card="<?php echo $withdrawal_record['bank_card']; ?>" data-bank-account="<?php echo $withdrawal_record['bank_card_user']; ?>"></b></span>
                            <br>
                            <span class="c-gray"><?php echo $withdrawal_record['trade_no']; ?></span>
                        </td>
                        <td style="text-align: center"><?php echo date('Y-m-d H:i:s', $withdrawal_record['add_time']); ?></td>
                        <td style="text-align: center">
                            <?php if($withdrawal_record['status'] == 3) { ?>
                                提现成功
                            <?php } else if ($withdrawal_record['status'] == 2) { ?>
                                银行处理中
                            <?php } else if ($withdrawal_record['status'] == 1) { ?>
                                申请中
                            <?php } else { ?>
                                提现失败
                            <?php } ?>
                        </td>
                        <td>
                            <span class="bak-content"><?php echo $withdrawal_record['bak']; ?></span><br/>
                            <a href="javascript:void(0);" class="add-bak" data-id="<?php echo $withdrawal_record['pigcms_id'];?>">添加备注</a>
                        </td>
                        <td class="status">
                            <select <?php if (in_array($withdrawal_record['status'], array(3,4))) { ?>disabled="true"<?php } ?> style="width: 100px;" data-status="<?php echo $withdrawal_record['status']; ?>" name="icome-status-<?php echo $withdrawal_record['pigcms_id'];?>" data-id="<?php echo $withdrawal_record['pigcms_id'];?>" class="js-status-select">
                                <?php  foreach($status as $key => $value) {?>
                                    <?php if ($key < $withdrawal_record['status']) { continue; } ?>
                                    <option value="<?php echo $key;?>" <?php if ($key == $withdrawal_record['status']) { ?>selected="true"<?php } ?>><?php echo $value;?></option>
                                <?php }?>
                            </select>
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
        <div class="widget-list-footer">
            <div class="pagenavi ui-box"><?php echo $page;?></div>
        </div>
    </div>
</div>