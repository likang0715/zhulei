<div class="goods-list">
    <div>
        <?php if (!empty($bond_recharges)) { ?>
        <table class="ui-table ui-table-list" style="padding: 0px;">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                    <tr class="widget-list-header">
                        <th style="text-align: center">ID</th>
                        <th style="text-align: right">充值额度(元)</th>
                        <th style="text-align: center">充值时间</th>
                        <th style="text-align: center">状态</th>
                    </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($bond_recharges as $bond_recharge) { ?>
                    <tr class="widget-list-item">
                        <td style="text-align: center"><?php echo $bond_recharge['id']; ?></td>
                        <td style="text-align: right"><?php echo number_format($bond_recharge['apply_recharge'], 2, '.', ''); ?></td>
                        <td style="text-align: center"><?php echo date('Y-m-d H:i:s', $bond_recharge['add_time']); ?></td>
                        <td style="text-align: center">
                            <?php if(empty($bond_recharge['status'])){?>
                                供货商未确认
                            <?php } else {?>
                                供货商已确认
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