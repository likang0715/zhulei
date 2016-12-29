<style>
    .ui-nav {
        border: none;
        background: none;
        position: relative;
        border-bottom: 1px solid #e5e5e5;
        margin-bottom: 15px;
        margin-top: 23px;
    }
    .ui-nav ul {
        zoom: 1;
        margin-bottom: -1px;
        margin-left: 1px;
    }
    .ui-nav li {
        float: left;
        margin-left: -1px;
    }
    .ui-nav li a {
        display: inline-block;
        padding: 0 12px;
        line-height: 32px;
        color: #333;
        border: 1px solid #e5e5e5;
        background: #f8f8f8;
        min-width: 80px;
        text-align: center;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .ui-nav li.active a {
        font-size: 100%;
        border-bottom-color: #fff;
        background: #fff;
        margin:0px;
        line-height: 32px;
    }
    .popover-help-notes.bottom:not(.center) .popover-inner, .popover-intro.bottom:not(.center) .popover-inner {
        margin-left: 86px;
        background-color: #211D1D;
        width:80px;
    }
    .popover-help-notes.bottom:not(.center) .arrow, .popover-intro.bottom:not(.center) .arrow {
        margin-left: 68px;
    }
    input {
        width: 100px;
    }

    .desc {
        width: 309px;
        height: 50px;
    }
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
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix">
        <div class="widget-list-filter">
            <nav class="ui-nav clearfix">
                <ul class="pull-left">
                    <li class="<?php echo $is == 1 ? 'active' : ''?>">
                        <a href="#fx" data-is="1">分销商排名</a>
                    </li>
                    <li class="<?php echo $is == 2 ? 'active' : ''?>">
                        <a href="#team" data-is="2">团队排名</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <?php if($is == 1){?>
    <div class="js-list-filter-region clearfix ui-box" style="position: relative; margin-top: 0px;">
        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    店铺名称：<input style="width:70px;" placeholder="店铺名称" type="text" class="store_name" />&nbsp;
                    名称：<input style="width:70px;" placeholder="团队名称" type="text" class="team_name" />&nbsp;
                    注册时间：
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
    <div class="ui-box" style="margin-top: -15px;">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($sellerRank)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th>LOGO</th>
                    <th>分销店铺</th>
                    <th>分销级别</th>
                    <th>所属团队</th>
                    <th>客服微信</th>
                    <th>状态</th>
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
                                <a href="javascript:void(0);">注册时间</a>
                            </div>
                            <div class="sort" style="float: left">
                                <span class="asc cursor" data-method="asc" data-field="date_added"><b>&nbsp;</b></span>
                                <span class="desc cursor" data-method="desc" data-field="date_added"><b>&nbsp;</b></span>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </th>
                    <th style="text-align: center">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($sellerRank as $key => $seller) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-image-td">
                            <div class="goods-image">
                                <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['fx_store_id']; ?>" target="_blank"><img src="<?php if ($seller['store_logo'] == '' || $seller['store_logo'] == './upload/images/') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $seller['store_logo']; ?><?php } ?>" /></a>
                            </div>
                        </td>
                        <td class="goods-meta">
                            <a class="new-window" href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['fx_store_id']; ?>" target="_blank">
                                <?php if (isset($_POST['keyword']) && $_POST['keyword'] != '') { ?>
                                    <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $seller['name']); ?>
                                <?php } else { ?>
                                    <?php echo $seller['store_name']; ?>
                                <?php } ?>
                            </a>
                            <br /><span style="color: orange"><?php echo $seller['drp_level']; ?>级分销商</span>
                        </td>
                        <td>
                            <img data-degreename ="<?php echo $seller['degree_name']; ?>" title="<?php echo !empty($seller['degree_name']) ? $seller['degree_name'] : '默认级别'; ?>" class="fx-icon" style="width: 40px;height:50px;" src="<?php echo !empty($seller['icon']) ? $seller['icon'] :  TPL_URL.'/images/kong.png'; ?>" />
                        </td>

                        <td>
                            <?php echo !empty($seller['team_name']) ? $seller['team_name'] : '尚未成立'; ?>
                        </td>
                        <td>
                            <?php echo $seller['service_weixin']; ?>
                        </td>
                        <td>
                            <?php if ($seller['store_status'] == 5) { ?><span style="color:gray">已禁用</span><?php } else if (!empty($seller['drp_approve'])) { ?><span style="color:green">已审核</span><?php } else { ?><span style="color:red">未审核</span><?php } ?>
                        </td>
                        <td style="text-align: right">
                            <?php if ($seller['store_sales'] > 0) { ?>
                            <a href="<?php dourl('statistics', array('store_id' => $seller['fx_store_id']));?>"><?php echo $seller['store_sales']; ?></a>
                            <?php } else { ?>
                            <?php echo $seller['store_sales']; ?>
                            <?php } ?>
                        </td>
                        <td style="text-align: left;">
                            <?php echo date('Y-m-d', $seller['date_added']); ?>
                        </td>
                        <td style="text-align: center">
                            <a href="javascript:;" class="<?php if ($seller['store_status'] == 1) { ?>js-drp-disabled<?php } else if ($seller['store_status'] == 5) { ?>js-drp-enabled<?php } ?>" data-id="<?php echo $seller['fx_store_id']; ?>"><?php if ($seller['store_status'] == 1) { ?>禁用<?php } else if ($seller['store_status'] == 5) { ?>启用<?php } ?></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($sellerRank)) { ?>
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <input type="hidden" value="<?php echo $is;?>" class="fx-team"/>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($sellerRank)) { ?>
            <div class="widget-list-footer">
                <div class="pagenavi"><?php echo $page; ?></div>
            </div>
        <?php } ?>
    </div>
</div>
<?php } else if($is == 2){?>
    <style type="text/css">
        .logo {
            float: left;
            text-align: center;
        }
        .edit-logo {
            padding-top: 10px;
            clear: both;
        }
        .desc {
            width: 309px;
            height: 50px;
        }
        .error {
            border: 1px solid #b94a48!important;
        }

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
    </style>
    <div class="goods-list">
        <div class="js-list-filter-region clearfix ui-box" style="position: relative;margin-top: 0px;">
            <div class="widget-list-filter">
                <div class="filter-box">
                    <div class="js-list-search">
                        团队名称：<input style="width:70px;" placeholder="团队名称" type="text" class="name" />&nbsp;&nbsp;&nbsp;&nbsp;
                        创建者：<input style="width:70px;" placeholder="创建者" type="text" class="owner" />&nbsp;&nbsp;&nbsp;&nbsp;
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
    <div class="ui-box" style="margin-top: -15px;">
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
                <th style="text-align: right;">
                    <div class="th" style="text-align: right;">
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
					<img src="<?php echo $drp_team['logo']; ?>" width="60" height="60" />
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

                <td style="text-align: left;">
                    <?php echo date('Y-m-d', $drp_team['add_time']); ?>
                </td>
                <td class="text-center">
                    <a href="">查看</a>
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
    <div class="js-list-footer-region ui-box">
        <div>
            <input type="hidden" value="<?php echo $is;?>" class="fx-team"/>
            <div class="js-page-list pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>
<?php }?>
