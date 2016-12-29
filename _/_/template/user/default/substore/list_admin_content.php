<div class="widget-list">
    <div class="ui-box">
        <div class="js-list-filter-region clearfix">
            <div class="widget-list-filter">
                <div class="ui-box dianpu">
                    <a class="ui-btn ui-btn-success" href="#add_admin">新建</a>
                </div>
            </div>
        </div>
        <?php if(!empty($store_admin_list)){ ?>
            <table class="ui-table ui-table-list physical_list">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-12">昵称</th>
                    <th class="cell-20">联系电话</th>
                    <th class="cell-12">管理店铺名</th>
                    <th class="cell-10">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach($store_admin_list as $value){ ?>
                    <tr class="widget-list-item">
                        <td><?php echo $value['nickname'];?></td>
                        <td><?php echo $value['phone'];?></td>
                        <td>
                           <?php echo $store_physical_name[$value['uid']]['name'];?>
                        </td>
                        <td class="dianpu">
                            <a href="#store_admin_edit/<?php echo $value['uid'];?>" class="js-edit">编辑</a> - <a href="javascript:;" class="js-delete" data-id="<?php echo $value['uid'];?>">删除</a>
                        </td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php }else{ ?>
            <div class="js-list-empty-region">
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="js-list-footer-region ui-box"></div>
</div>