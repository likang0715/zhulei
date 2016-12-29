<style type="text/css">
    .red {
        color:red;
    }

    .block-help>a {
        display: inline-block;
        width: 16px;
        height: 16px;
        line-height: 18px;
        border-radius: 8px;
        font-size: 12px;
        text-align: center;
        background: #bbb;
        color: #fff;
    }
    .block-help>a:after {
        content: "?";
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <nav class="ui-nav clearfix">
                <ul class="pull-left">
                    <li class="<?php echo $authen == 1 ? 'active' : ''?>">
                        <a href="#1" data-authen="1">已审核的经销商</a>
                    </li>
                    <li class="<?php echo $authen == 2 ? 'active' : ''?>">
                        <a href="#2" data-authen="2">未审核的经销商</a>
                    </li>
                    <li class="<?php echo $authen == 3 ? 'active' : ''?>">
                        <a href="#3" data-authen="3">所有店铺</a>
                    </li>
                </ul>
            </nav>
            <div class="filter-box">
                <div class="js-list-search">
                    店铺名：<input class="filter-box-search js-search" type="text" placeholder="搜索" value="">
                    <input type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($suppliers)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th colspan="2">店铺名</th>
                    <th>联系人</th>
                    <?php if($authen != 3) {?>
                    <th style="text-align: center">手机号</th>
                    <?php }?>
                    <!--<th>客服微信</th>-->
                    <?php if($authen != 3) {?>
                    <th style="text-align: center;color:red;">保证金余额(元)</th>
                    <?php }?>
                    <?php if($authen == 1) {?>
                    <th style="text-align: center;color:red;">未对账金额(元)</th>
                    <th style="text-align: center;color:red;">未对账订单</th>
                    <th style="text-align: center;color:red;">销售额(元)</th>
                    <?php }?>
                    <th style="text-align: center">入驻时间</th>
                    <th style="text-align: center">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($suppliers as $supplier) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-image-td">
                            <div class="goods-image">
                                <a href="<?php dourl('fx:ws_store_info', array('store_id' => $supplier['store_id'])); ?>"><img src="<?php if ($supplier['logo'] == './upload/images/' || $supplier['logo'] == '') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $supplier['logo']; ?><?php } ?>" alt="<?php echo $supplier['name']; ?>" /></a>
                            </div>
                        </td>
                        <td class="goods-meta">
                            <a class="new-window" href="<?php dourl('fx:ws_store_info', array('store_id' => $supplier['store_id'])); ?>">
                                <?php if (!empty($_POST['keyword'])) { ?>
                                    <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $supplier['name']); ?>
                                <?php } else { ?>
                                    <?php echo $supplier['name']; ?>
                                <?php } ?>
                            </a>
                            <br /><span style="color: orange"><?php if ($store['approve']==0){?>平台未认证<?php } elseif($store['approve']==2){?>平台认证中<?php } elseif($store['approve']==3) {?>平台已认证<?php }?></span>
                        </td>
                        <td>
                            <?php echo $supplier['linkman']; ?>
                        </td>
                        <?php if($authen != 3){?>
                        <td style="text-align: center">
                            <?php echo $supplier['tel']; ?>
                        </td>
                        <?php }?>
                        <!--<td>
                            <?php echo $supplier['service_weixin']; ?>
                        </td>-->
                        <?php if($authen != 3) {?>
                        <td style="text-align: center">
                            <?php echo empty($supplier['bond']) ? '0.00' : $supplier['bond']; ?>
                        </td>
                        <?php } ?>
                        <?php if($authen == 1) {?>
                             <td style="text-align:center">
                                <a href="<?php dourl('order:ws_bill_check', array('store_id' => $supplier['store_id'])); ?>"><?php echo empty($supplier['unseller']) ? '0.00' : $supplier['unseller']; ?></a>
                            </td>
                            <td style="text-align:center">
                                <a href="<?php dourl('order:ws_bill_check', array('store_id' => $supplier['store_id'])); ?>"><?php echo empty($supplier['order_count']) ? '0' : $supplier['order_count']; ?></a>
                            </td>
                            <td style="text-align:center">
                                <?php echo empty($supplier['seller']) ? '0' : $supplier['seller']; ?>
                            </td>
                        <?php }?>
                        <td style="text-align: center">
                            <?php echo date('Y-m-d', $supplier['date_added']); ?>
                        </td>
                        <td style="text-align: center">
                            <?php if($authen==2){?>
                                <a target="_blank" href="<?php dourl('whole_detail'); ?>&store_id=<?php echo $supplier['store_id'];?>">查看审核资料</a>
                            <?php } else if ($authen == 3) {?>
                                <a href="javascript:;" data-id="<?php echo $supplier['store_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-agency">加为经销商</a>
                            <?php } else {?>
                                <a target="_blank" href="<?php dourl('bond_log'); ?>&store_id=<?php echo $supplier['store_id'];?>">保证金记录</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($suppliers)) { ?>
                <div>
                    <?php if($authen == 3){?>
                        <div class="no-result widget-list-empty" style="color:red;">所有店铺默认不显示，搜索店铺名可看到相应的店铺信息。</div>
                    <?php } else {?>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                    <?php }?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div class="widget-list-footer">
            <div class="pull-left">
            </div>
            <input type="hidden" data-authen="<?php echo $authen ;?>" class="authen">
            <div class="pagenavi ui-box"><?php echo $page; ?></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var t2 = '';
    var t0 = '';
    $('.js-help-notes').hover(function(){
        var content = $(this).next('.js-notes-cont').html();
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left-40) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + content + '</div></div></div>';
        $('body').append(html);
        $('.popover-help-notes').show();
    }, function(){
        t2 = setTimeout('hide2()', 200);
    })
    $('.popover-help-notes').live('hover', function(event){
        if (event.type == 'mouseenter') {
            clearTimeout(t2);
        } else {
            clearTimeout(t2);
            hide2();
        }
    })
    function hide() {
        $('.popover-intro').remove();
    }
    function hide2() {
        $('.popover-help-notes').remove();
    }
    function msg_hide() {
        $('.notifications').html('');
        clearTimeout(t0);
    }
</script>