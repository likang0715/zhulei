<style type="text/css">
    .red {
        color:red;
    }
</style>
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
    input, textarea, .uneditable-input {
        width: 100px;
    }
</style>
<div class="goods-list">
    <!--<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    分销商名称：<input class="filter-box-search js-search" type="text" placeholder="搜索" />&nbsp;&nbsp;&nbsp;&nbsp;
                    审核状态：
                    <select class="js-search-drp-approve" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="*">审核状态</option>
                        <option value="0">未审核</option>
                        <option value="1">已审核</option>
                    </select>
                    <input type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>-->
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    分销商名称：<input class="filter-box-search js-search js-fx-seller" type="text" placeholder="分销商名称" />&nbsp;&nbsp;
                    团队名称：<input class="filter-box-team filter-box-search js-search" type="text" placeholder="团队名称" />&nbsp;&nbsp;
                    审核状态：
                    <select class="js-search-drp-approve" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="*">审核状态</option>
                        <option value="0">未审核</option>
                        <option value="1">已审核</option>
                    </select>
                    分销商推广级别：
                    <select class="js-search-drp-degree" style="margin-bottom: 0px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                        <option value="*">全部</option>
                        <?php if(!empty($drp_degree_list)) {?>
                            <?php foreach($drp_degree_list as $d){?>
                                <option value="<?php echo $d['is_platform_degree_name']?>"><?php echo $d['name']?></option>
                            <?php }?>
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                        <span class="controls">
                            入驻时间：
                            <input type="text" name="start_time" value="" class="js-start-time" id="js-start-time" width="20px"/>
                            <span>至</span>
                            <input type="text" name="end_time" value="" class="js-end-time" id="js-end-time" width="20px"/>
                            <span class="date-quick-pick" data-days="7">最近7天</span>
                            <span class="date-quick-pick" data-days="30">最近30天</span>
                        </span>

                    <input style="margin-top:10px;" type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($sellers)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th>LOGO</th>
                    <th>分销商</th>
                    <th>联系电话</th>
                    <th>所属团队</th>
                    <th>推广级别</th>
                    <th>状态</th>
                    <th style="text-align: center">注册时间</th>
                    <th style="text-align: center">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($sellers as $seller) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-image-td">
                            <div class="goods-image">
                                <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $seller['fx_store_id']; ?>" target="_blank"><img src="<?php if ($seller['store_logo'] == '' || $seller['store_logo'] == './upload/images/') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $seller['store_logo']; ?><?php } ?>" /></a>
                            </div>
                        </td>
                        <td class="goods-meta">
                            <a class="new-window" href="<?php dourl('fx_store_info',array('store_id'=>$seller['fx_store_id'])) ?>" target="_blank">
                                <?php if (isset($_POST['keyword']) && $_POST['keyword'] != '') { ?>
                                    <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $seller['name']); ?>
                                <?php } else { ?>
                                    <?php echo $seller['name']; ?>
                                <?php } ?>
                            </a>
                            <br /><span style="color: orange"><?php echo $seller['drp_level']; ?>&nbsp;级分销商</span>
                        </td>
                        <td>
                            <?php echo $seller['tel']; ?>
                        </td>
                        <td>
                            <?php echo $seller['team_name'] ;?>

                        </td>
                        <td>
                            <?php echo $seller['degree_name']; ?>
                        </td>
                        <td>
                            <?php if ($seller['status'] == 5) { ?><span style="color:gray">已禁用</span><?php } else if (!empty($seller['drp_approve'])) { ?><span style="color:green">已审核</span><?php } else { ?><span style="color:red">未审核</span><?php } ?>
                        </td>

                        <td style="text-align: center">
                            <?php echo date('Y-m-d H:i:s', $seller['date_added']); ?>
                        </td>
                        <td style="text-align: center">
                            <?php if (!empty($seller['drp_approve'])) { ?>
                                <span class="gray" style="cursor: no-drop">审核</span>
                            <?php } else { ?>
                                <a href="javascript:;" class="js-drp-approve" data-id="<?php echo $seller['fx_store_id']; ?>">审核</a>
                            <?php } ?>
                            <span>-</span>
                            <a href="javascript:;" class="<?php if ($seller['status'] == 1) { ?>js-drp-disabled<?php } else if ($seller['status'] == 5) { ?>js-drp-enabled<?php } ?>" data-id="<?php echo $seller['fx_store_id']; ?>"><?php if ($seller['status'] == 1) { ?>禁用<?php } else if ($seller['status'] == 5) { ?>启用<?php } ?></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($sellers)) { ?>
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