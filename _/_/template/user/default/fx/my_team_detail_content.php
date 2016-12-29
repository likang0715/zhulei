<style type="text/css">
    .red {
        color:red;
    }
    .control-label {
        width: 90px;
        font-size: 12px;
    }
    .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 12px;
        border-radius: 4px;
    }
    .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 12px;
        border-radius: 4px;
    }
    input {
        width: 100px;
    }
    .th {
        width: 100%;
        height: 100%;
        display: block;
        float: left;
    }
    .th div span {
        display: block;
        width: 7px;
        height: 7px;
    }
    .th div span b {
        display: inline-block;
        width: 100%;
        height: 100%;
        background: url(<?php echo TPL_URL;?>/images/chosen-sprite.png) no-repeat -2px -6px;
    }
    div .asc b {
        background-position: -20px -6px!important;
    }
    .cursor {
        cursor: pointer;
    }
    .th div {
        float: right;
    }
    .sort {
        padding: 2px;
    }
</style>
<div class="goods-list">
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($members)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="text-center">店铺Logo</th>
                    <th>成员名称</th>
                    <th>
                        <div class="th">
                            <div class="sort">
                                <span class="asc cursor" data-method="asc" data-field="drp_level"><b>&nbsp;</b></span>
                                <span class="desc cursor" data-method="desc" data-field="drp_level"><b>&nbsp;</b></span>
                            </div>
                            <div class="label">
                                <a href="javascript:void(0);">分销级别</a>
                            </div>
                        </div>
                    </th>
                    <th class="text-right">
                        <div class="th">
                            <div class="sort">
                                <span class="asc cursor" data-method="asc" data-field="orders"><b>&nbsp;</b></span>
                                <span class="desc cursor" data-method="desc" data-field="orders"><b>&nbsp;</b></span>
                            </div>
                            <div class="label">
                                <a href="javascript:void(0);">订单数</a>
                            </div>
                        </div>
                    </th>
                    <th class="text-right">
                        <div class="th">
                            <div class="sort">
                                <span class="asc cursor" data-method="asc" data-field="sales"><b>&nbsp;</b></span>
                                <span class="desc cursor" data-method="desc" data-field="sales"><b>&nbsp;</b></span>
                            </div>
                            <div class="label">
                                <a href="javascript:void(0);">销售额(元)</a>
                            </div>
                        </div>
                    </th>
                    <th class="text-center">
                        <div class="th">
                            <div class="label" style="float: left">
                                <a href="javascript:void(0);">创建时间</a>
                            </div>
                            <div class="sort" style="float: left">
                                <span class="asc cursor" data-method="asc" data-field="date_added"><b>&nbsp;</b></span>
                                <span class="desc cursor" data-method="desc" data-field="date_added"><b>&nbsp;</b></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($members as $member) { ?>
                    <tr class="widget-list-item">
                        <td class="text-center">
                            <img src="<?php echo $member['logo']; ?>" width="60" height="60" />
                        </td>
                        <td><?php echo $member['name']; ?></td>
                        <td class="text-right" style="color: #FF6600"><?php echo $member['drp_level']; ?>级分销商</td>
                        <td class="text-right"><?php echo $member['orders']; ?></td>
                        <td class="text-right"><?php echo number_format($member['sales'], 2, '.', ''); ?></td>
                        <td class="text-left"><?php echo date('Y-m-d H:i:s', $member['date_added']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($members)) { ?>
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <div class="js-page-list pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>