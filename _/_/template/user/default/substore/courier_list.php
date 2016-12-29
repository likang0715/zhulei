<div class="widget-list">
    <div class="ui-box">

        <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
            <div>
                <a href="javascript:void(0);" class="ui-btn ui-btn-primary bind_qrcode">添加配送员</a>
            </div>
        </div>

        <?php if(!empty($courier_list)){ ?>
            <table class="ui-table ui-table-list physical_list">
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th class="cell-12">配送员</th>
                    <th class="cell-20">手机号</th>
                    <th class="cell-12">openid</th>
                    <th class="cell-12">所属门店</th>
                    <th class="cell-12">添加时间</th>
                    <th class="cell-10">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach($courier_list as $courier){ ?>
                    <tr class="widget-list-item">
                        <td><a href="<?php dourl('substore:courier_package', array('courier_id'=>$courier['courier_id'])); ?>" target="_blank"><?php echo $courier['name'] ?></a></td>
                        <td><?php echo $courier['tel'] ?></td>
                        <td><?php echo $courier['openid'] ?></td>
                        <td><?php echo $store_physical_name[$courier['physical_id']] ?></td>
                        <td><?php echo date("Y-m-d", $courier['add_time']) ?></td>
                        <td class="dianpu">
                            <a href="#courier_edit/<?php echo $courier['courier_id'];?>" class="js-edit">编辑</a>
                             - 
                            <a href="javascript:;" class="js-delete" data-id="<?php echo $courier['courier_id'];?>">删除</a>
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