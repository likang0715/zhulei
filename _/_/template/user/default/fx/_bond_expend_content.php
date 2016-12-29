<div class="bond-expend-list">
    <div>
        <?php if (!empty($bond_expends)) { ?>
        <table class="ui-table ui-table-list" style="padding: 0px;">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th>订单号</th>
                    <th style="text-align: right;">扣除额度(元)</th>
                    <th style="text-align: right;">剩余额度(元)</th>
                    <th style="text-align: center">扣款时间</th>
                    <th style="text-align: center">状态</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($bond_expends as $bond_expend) { ?>
                    <tr class="widget-list-item">
                        <td><?php echo $bond_expend['order_no']; ?></td>
                        <td style="text-align: right;"><?php echo $bond_expend['deduct_bond']; ?></td>
                        <td style="text-align: right;"><?php echo $bond_expend['residue_bond']; ?></td>
                        <td style="text-align: center"><?php echo date('Y-m-d H:i:s', $bond_expend['add_time']); ?></td>
                        <td style="text-align: center">
                            <?php if(empty($bond_expend['status'])){?>
                                进行中
                            <?php } else if($bond_expend['status'] == 1) {?>
                                交易已完成
                            <?php } else if($bond_expend['status'] == 2) {?>
                                已退货
                            <?php }?>
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