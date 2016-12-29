<div>
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div>
            <a href="<?php dourl('banner#create'); ?>" class="ui-btn ui-btn-primary js-add-banner">新增店铺横幅广告</a>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <?php if (!empty($banner_lists)) { ?>
            <tr>
                <th class="cell-30">名称</th>
                <th class="cell-30">图片</th>
                <th class="cell-30">链接地址</th>
                <th class="cell-30">横幅状态</th>
                <th class="text-right">操作</th>
            </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php if (!empty($banner_lists)) { ?>
            <?php foreach ($banner_lists as $banner_list) { ?>
            <tr id="<?php echo $banner_list['id'];?>">
                <td><a href="#" target="_blank" class="new-window"><?php echo msubstr($banner_list['name'],0,10); ?></a></td>
                <td><img src="<?php echo $banner_list['pic']; ?>" width="300" height="50"/></td>
                <td><a href="<?php echo $banner_list['url']; ?>" title="<?php echo $banner_list['url']; ?>" target="_blank" class="new-window"><?php echo substr($banner_list['url'],0,30); ?></a></td>
                <td><?php if($banner_list['status']==1){ ?><span class="status">启用</span><?php }else if($banner_list['status']==0){ ?><span class="status">关闭</span><?php } ?></td>
                <td class="text-right">
                    <a href="javascript:void(0);" class="js-change-status" data-status="<?php echo $banner_list['status']; ?>">
                    <?php if($banner_list['status']==1){ ?><span>启用</span><?php }else if($banner_list['status']==0){ ?><span style="color: #808080;">关闭</span><?php } ?>
                    </a>
                    <span>-</span>
                    <a href="#edit/<?php echo $banner_list['id']; ?>" class="js-banner-edit">编辑</a>
                    <span>-</span>
                    <a href="javascript:void(0);" class="js-change-delete">删除</a>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($banner_lists)) { ?>
            <div class="no-result">还没有相关数据。</div>
            <?php } ?>
        </div>
    </div>
    <div class="js-banner_list_page ui-box">
        <div>
            <div class="pagenavi"><?php echo $pages; ?></div>
        </div>
    </div>
</div>
