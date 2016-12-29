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
        margin-left: 0px;
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
    .ui-table.ui-table-list {
        border: none;
        border: 0px solid #ccc;
    }

</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="height:50px;position: relative;margin-bottom: 10px;">
        <div class="widget-list-filter">
            <div class="filter-box" style="margin-top:10px;margin-left: 8px;">
                <div class="js-list-search">
                    团队名称：<input style="width:70px;" type="text" class="name" />&nbsp;&nbsp;&nbsp;&nbsp;
					创建者：<input style="width:70px;" type="text" class="owner" />&nbsp;&nbsp;&nbsp;&nbsp;
					创建时间：
					<input type="text" name="start_time" class="js-start-time" id="js-start-time" />
					<span>至</span>
					<input type="text" name="end_time" class="js-end-time" id="js-end-time" />
					<span class="date-quick-pick" data-days="7">最近7天</span>
					<span class="date-quick-pick" data-days="30">最近30天</span>
					<input type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>

    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($drp_teams)) { ?>
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <tr class="widget-list-header">
                <th class="text-center">团队Logo</th>
				<th>团队名称</th>
                <th>创建者</th>
                <th class="text-right active">
                    <div class="th">
                        <div class="sort">
                            <span class="asc cursor" data-method="asc" data-field="members"><b>&nbsp;</b></span>
                            <span class="desc cursor" data-method="desc" data-field="members"><b>&nbsp;</b></span>
                        </div>
                        <div class="label">
                            <a href="javascript:void(0);">成员数</a>
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
                            <span class="asc cursor" data-method="asc" data-field="add_time"><b>&nbsp;</b></span>
                            <span class="desc cursor" data-method="desc" data-field="add_time"><b>&nbsp;</b></span>
                        </div>
                        <div class="clear"></div>
                    </div>
                </th>
                <th class="text-center">操作</th>
            </tr>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($drp_teams as $drp_team) { ?>
            <tr class="widget-list-item">
                <td class="text-center">
					<a href="<?php dourl('my_team_detail', array('id' => $drp_team['pigcms_id'])); ?>"><img src="<?php echo $drp_team['logo']; ?>" width="60" height="60" /></a>
                </td>
				<td>
					<?php if (isset($_POST['name']) && $_POST['name'] != '') { ?>
						<?php echo str_replace($_POST['name'], '<span class="red">' . $_POST['name'] . '</span>', $drp_team['name']); ?>
					<?php } else { ?>
						<?php echo $drp_team['name']; ?>
					<?php } ?>
				</td>
                <td>
					<?php if (isset($_POST['owner']) && $_POST['owner'] != '') { ?>
						<?php echo str_replace($_POST['owner'], '<span class="red">' . $_POST['owner'] . '</span>', $drp_team['owner']); ?>
					<?php } else { ?>
						<?php echo $drp_team['owner']; ?>
					<?php } ?>
                </td>
                <td class="text-right">
                    <?php echo $drp_team['members']; ?>
                </td>
                <td class="text-right">
                    <?php echo $drp_team['sales']; ?>
                </td>

                <td class="text-left">
                    <?php echo date('Y-m-d H:i:s', $drp_team['add_time']); ?>
                </td>
                <td class="text-center">
                    <a href="<?php dourl('my_team_detail', array('id' => $drp_team['pigcms_id'])); ?>">查看</a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($drp_teams)) { ?>
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region">
        <div>
            <div class="js-page-list pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>