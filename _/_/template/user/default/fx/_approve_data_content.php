<div class="approve-data">
    <div>
        <?php if (!empty($approve_data)) { ?>
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php foreach ($approve_data as $label => $value) { ?>
                <tr class="widget-list-item">
                    <td style="text-align: right;width:150px"><?php echo $label; ?>：</td>
                    <td><?php echo $value; ?></td>
                </tr>
            <?php } ?>
        </table>
        <?php } else { ?>
        <div class="js-list-empty-region">
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
        </div>
        <?php } ?>
    </div>
</div>