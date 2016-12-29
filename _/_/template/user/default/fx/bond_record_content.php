<style type="text/css">
    .red {
        color:red;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    订单号：<input class="filter-box-search js-search" type="text" placeholder="搜索" value="">
                    <input type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($bond_records)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th>供货商</th>
                    <th>订单号</th>
                    <th style="text-align: center;color:red;">扣除额度(元)</th>
                    <th style="text-align: center;color:red;">剩余额度(元)</th>
                    <!--<th>手机号</th>
                    <th style="color:red;">充值额度(元)</th>-->
                    <th style="text-align: center">扣除时间</th>
                    <th style="text-align: center">状态</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($bond_records as $bond) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-meta">
                            <?php echo $bond['store_name']; ?>
                        </td>
                        <td class="goods-meta">
                            <?php echo $bond['order_no']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $bond['deduct_bond']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $bond['residue_bond']; ?>
                        </td>
                       <!-- <td>
                            <?php echo $bond['phone']; ?>
                        </td>
                        <td>
                            <?php echo $bond['apply_recharge']; ?>
                        </td>-->
                        <td style="text-align: center">
                            <?php echo date('Y-m-d H:i:s', $bond['add_time']); ?>
                        </td>
                        <td style="text-align: center">
                            <?php if(empty($bond['status'])){?>
                                <a>进行中</a>
                            <?php } else if($bond['status'] == 1) {?>
                                交易已完成
                            <?php } else if($bond['status'] == 2) {?>
                                已退货
                            <?php }?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($bond_records)) { ?>
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div class="widget-list-footer">
            <div class="pull-left">
            </div>
            <input type="hidden" data-authen="<?php echo $authen ;?>" class="authen">
            <div class="pagenavi ui-box"><?php echo $page;?></div>
        </div>
    </div>
</div>