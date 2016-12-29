<style type="text/css">
    .red {
        color:red;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <nav class="ui-nav clearfix">
                <ul class="pull-left">
                    <li class="<?php echo $status == 1 ? 'active' : ''?>">
                        <a href="#1" data-status="1">确认到帐的打款</a>
                    </li>
                    <li class="<?php echo $status == 2 ? 'active' : ''?>">
                        <a href="#2" data-status="2">未确认到帐的打款</a>
                    </li>
                </ul>
            </nav>
            <div class="filter-box">
                <div class="js-list-search">
                    开户行：<input class="filter-box-search js-search" type="text" placeholder="搜索" value="">
                    <input type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($bondlist)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th>经销商</th>
                    <th >开户行</th>
                    <th style="text-align: center">开户人</th>
                    <th style="text-align: center">卡号</th>
                    <th>手机号</th>
                    <th style="color:red;">充值额度(元)</th>
                    <th style="text-align: center">充值时间</th>
                    <th style="text-align: center">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($bondlist as $bond) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-meta">
                            <?php echo $bond['whole_name']; ?>
                        </td>
                        <td class="goods-meta">
                            <?php echo $bond['opening_bank']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $bond['bank_card_user']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $bond['bank_card']; ?>
                        </td>
                        <td>
                            <?php echo $bond['phone']; ?>
                        </td>
                        <td>
                            <?php echo $bond['apply_recharge']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo date('Y-m-d', $bond['add_time']); ?>
                        </td>
                        <td style="text-align: center">
                            <?php if(empty($bond['status'])){?>
                             <a href="javascript:void(0);" data-id="<?php echo $bond['id'];?>" class="confirmation_arrival">确认到账</a>
                            <?php } else {?>
                                <a>已确认</a>
                            <?php }?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($bondlist)) { ?>
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
            <input type="hidden" data-status="<?php echo $status ;?>" class="status">
            <div class="pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>