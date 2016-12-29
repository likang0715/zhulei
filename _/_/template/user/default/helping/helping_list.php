<nav class="ui-nav-table clearfix">
    <ul class="pull-left js-list-filter-region">
        <li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
            <a href="#all">所有助力</a>
        </li>
        <li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
            <a href="#future">未开始</a>
        </li>
        <li id="js-list-nav-on" <?php echo $type == 'on' ? 'class="active"' : '' ?>>
            <a href="#on">进行中</a>
        </li>
        <li id="js-list-nav-end" <?php echo $type == 'end' ? 'class="active"' : '' ?>>
            <a href="#end">已结束</a>
        </li>
    </ul>
</nav>

<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
            <a href="#create" class="ui-btn ui-btn-primary btn-helping-add">添加助力</a>
            <div class="js-list-search ui-search-box" data-type="all" data-keyword="">
                <input class="txt js-helping-keyword" type="text" placeholder="搜索" value="">
            </div>
        </div>
    </div>
</div>

<div class="ui-box">
    <?php if($helping_list) { ?>
    <table class="ui-table ui-table-list" style="padding:0px;">
        <thead class="js-list-header-region tableFloatingHeaderOriginal">
        <tr>
            <th class="cell-15">助力活动名称</th>
            <th class="cell-25">有效时间</th>
            <th class="cell-15">活动状态</th>
            <th class="cell-15">是否开启</th>
            <th class="cell-25 text-right">操作</th>
        </tr>
        </thead>
        <tbody class="js-list-body-region">
        <foreach name="helping_list" item="vo">
        <?php foreach($helping_list as $hk=>$hv){ ?>
        <tr class="js-present-detail js-id-39" service-id="39">
            <td>
                <p style="width: 100px; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" title="<?php echo $hv['title'];?>"><?php echo $hv['title'];?></p>
            </td>
            <td>
                <?php echo $hv['start_time'];?><br>至<br><?php echo $hv['end_time'];?>
            </td>
            <td>
                <?php echo $hv['status'];?>
            </td>
            <td>
                <?php if($hv['is_open']==1){echo "开启";}else{echo "关闭";};?>
            </td>
            <td class="text-right js-operate" data-helping_id="0">
                <a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $hv['id'];?>" data-store_id="<?php echo $hv['store_id'];?>">手机查看</a><span>-</span>
                <a href="#edit/<?php echo $hv['id'];?>" class="js-helping-edit" data-id="<?php echo $hv['id'];?>">编辑资料</a><span>-</span>
                <a href="javascript:drop_confirm('您确定要删除【<?php echo htmlspecialchars($hv['title']) ?>】吗?', '/user.php?c=helping&amp;a=helping_delete&amp;pid=<?php echo $hv['id'];?>')">删除</a><span>-</span>
                <a href="#log/<?php echo $hv['id'];?>" class="js-log">领奖纪录</a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        <thead class="js-list-header-region tableFloatingHeaderOriginal">
        <tr>
            <td colspan="7">
                <div class="pagenavi js-list_page">
                    <span class="total"><?php echo $pages ?></span>
                </div>
            </td>
        </tr>
        </thead>

    </table>
    <?php }else{ ?>
    <div class="js-list-empty-region">
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
        </div>
    <?php }?>
</div>

<div class="js-list-footer-region ui-box"></div>
<script type="text/javascript">
    function drop_confirm(msg, url)
    {
        if (confirm(msg)) {
            window.location.href = url;
        }
    };
</script>
