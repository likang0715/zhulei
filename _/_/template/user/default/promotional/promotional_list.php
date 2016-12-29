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
    input, textarea, .uneditable-input {
        width: 100px;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">

        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    <a href="<?php dourl('add'); ?>"><input type="button" class="ui-btn ui-btn-primary js-dump-btn" value="添加推广海报"></a>
                    <div style="float:right; margin-top: -13px;">
                        <input style="width:100px;" class="filter-box-search js-search js-fx-seller" type="text" placeholder="海报名称" />&nbsp;&nbsp;
                        <input style="margin-top:10px;" type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($promote_list)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th>海报名称</th>
                    <th>修改时间</th>
                    <th style="text-align: center">海报类型</th>
                    <th style="text-align: center">状态</th>
                    <th style="text-align: center">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($promote_list as $list) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-meta">
                           <?php echo $list['name']; ?>
                        </td>
                        <td>
                            <?php echo date("Y-m-d H:i:s",$list['update_time']);?>
                        </td>
                        <td style="text-align: center">
                            <?php if($list['poster_type'] == 1) {?>
                                横式模板
                            <?php } elseif ($list['poster_type'] == 2) {?>
                                竖式模板
                            <?php } elseif ($list['poster_type'] == 3) {?>
                                正方形模板
                            <?php } ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $list['status'] == 1 ? '有效' : '<span style="color:red;">已删除</span>';?>
                        </td>

                        <td style="text-align: center">
                            <?php if($list['type']){?>
                            <a href="javascript:;" data-id="<?php echo $list['pigcms_id']; ?>" class="js-enable-down">已启用</a>
                            <?php } elseif (empty($list['type'])) {?>
                                <a href="javascript:;" data-id="<?php echo $list['pigcms_id']; ?>" class="js-enable-up">未启用</a>
                            <?php }?>
                            <a href="<?php dourl('edit', array('pigcms_id' => $list['pigcms_id'])); ?>">修改</a>
                            <a href="javascript:;" data-id="<?php echo $list['pigcms_id']; ?>" class="js-cancel-to-fx">删除</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($promote_list)) { ?>
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <input type="hidden" data-is="<?php echo $level;?>" class="page-is">
            <div class="js-page-list pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>


