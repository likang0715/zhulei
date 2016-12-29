<div class="widget-list">
    <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
            <a href="#create" class="ui-btn ui-btn-primary btn-helping-add">添加微助力</a>
            <a href="javascript:history.go(-1);" class="ui-btn ui-btn-primary">返回列表</a>
        </div>
    </div>
</div>

<div class="ui-box">
    <?php
    if($helping_log) {
        ?>
        <table class="ui-table ui-table-list" style="padding:0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <tr>
                <th class="cell-15">序号</th>
                <th class="cell-15">奖品名称</th>
                <th class="cell-15">手机号</th>
                <th class="cell-15">是否领取</th>
                <th class="cell-15">领取时间</th>
                <th class="cell-25 text-right">操作</th>
            </tr>
            </thead>
            <tbody class="js-list-body-region">
            <?php
            foreach($helping_log as $logk=>$logv) {
                ?>
                <tr class="js-present-detail">
                    <td><?php echo $logv['id']; ?></td>
                    <td><?php echo $logv['title']; ?></td>
                    <td><?php echo $logv['code']; ?></td>
                    <td><?php echo $logv['is_cash']==0?'未领取':'已领取';?></td>
                    <td><?php echo $logv['prize_time']>0?date('Y-m-d H:i:s',$logv['prize_time']):'-';?></td>
                    <td class="text-right js-operate" data-record_id="<?php echo $helping_log['id'] ?>">
                        <!-- 奖品为商品时才显示兑奖订单 -->
                        <?php if($helping_log['type']==1){?>
                            <a href="/user.php?c=order&a=detail&id=<?php echo $record['is_cash']?>" target="_blank">兑奖订单</a>
                        <?php }else{ ?>
                            -
                        <?php } ?>
                    </td>
                </tr>
            <?php
            }
            if ($pages) {
                ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr>
                    <td colspan="5">
                        <div class="pagenavi js-data_list_page">
                            <span class="total" data-id="<?php echo $lottery['id']?>"><?php echo $pages ?></span>
                        </div>
                    </td>
                </tr>
                </thead>
            <?php
            }
            ?>
            </tbody>
        </table>
    <?php
    }else{
        ?>
        <div class="js-list-empty-region">
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<div class="js-list-footer-region ui-box"></div>
