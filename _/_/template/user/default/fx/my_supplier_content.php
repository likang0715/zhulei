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
    .ui-nav-table {
        position: relative;
        border-bottom: 1px solid #ccc;
        margin-bottom: 15px;
    }

    .ui-nav-table ul {
        zoom: 1;
        margin-bottom: -1px;
        margin-left: 1px;
    }
    .pull-left {
        float: left;
    }
    .ui-nav-table li {
        float: left;
        margin-left: -1px;
    }

    .ui-nav-table li.active a {
        border-color: #ccc #ccc #fff;

        background: #fff;
        color: #07d;
    }
    .block-help>a:after {
        content: "?";
    }
    .ui-nav-table li a {  display: inline-block;  padding: 0 12px;  line-height: 40px;  color: #333;  border: 1px solid #ccc;  background: #f8f8f8;  min-width: 80px;  text-align: center;  -webkit-box-sizing: border-box;  -moz-box-sizing: border-box;  box-sizing: border-box;  }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter">
            <div class="filter-box">
                <div class="js-list-search">
                    供货商名称：<input class="filter-box-search js-search" type="text" placeholder="搜索" value="">
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
                    <th colspan="2">供货商</th>
                    <th>主营类目</th>
                    <th style="text-align: center">联系人</th>
                    <th style="text-align: center">手机号</th>
                    <th style="text-align: center">商品数</th>
                    <th style="text-align: center;color:red;">保证金余额(元)
                        <span class="block-help">
					    <a href="javascript:void(0);" class="js-help-notes"></a>
					    <div class="js-notes-cont hide">
                            <p><strong>保证金余额：</strong>在当前供货商的店铺交纳的保证金，批发商品出售后扣除掉批发价后的剩余额度.</p>
                        </div>
				       </span>
                    </th>
                    <th style="text-align: center">入驻时间</th>
                    <th style="text-align: center">获取证书</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($suppliers as $supplier) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-image-td">
                            <div class="goods-image">
                                <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $supplier['store_id']; ?>" target="_blank"><img src="<?php if ($supplier['logo'] == './upload/images/' || $supplier['logo'] == '') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $supplier['logo']; ?><?php } ?>" alt="<?php echo $supplier['store_name']; ?>" /></a>
                            </div>
                        </td>
                        <td class="goods-meta">
                            <a class="new-window" href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $supplier['store_id']; ?>" target="_blank">
                                <?php if (!empty($_POST['keyword'])) { ?>
                                    <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $supplier['store_name']); ?>
                                <?php } else { ?>
                                    <?php echo $supplier['store_name']; ?>
                                <?php } ?>
                            </a>
                            <?php if(!empty($supplier['open_store_whole'])) {?>
                                <br/> <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">排他批发</i>
                            <?php }?>
                            <?php if($supplier['is_required_to_audit']==1) {?>
                                <br/> <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">需审核</i>
                            <?php }?>
                            <?php if($supplier['is_required_margin']==1) {?>
                                <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">需保证金</i>
                            <?php }?>

                        </td>
                        <td>
                            <?php echo $supplier['category_name']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $supplier['linkman']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $supplier['tel']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $supplier['product_count']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo isset($supplier['bond']) ? $supplier['bond'] : '0.00'; ?>
                        </td>

                        <td style="text-align: center">
                            <?php echo date('Y-m-d', $supplier['date_added']);?>
                        </td>
                        <td style="text-align: center">
                            <a href="<?php dourl('obtain_tpl'); ?>&id=<?php echo $supplier['store_id']; ?>">获取证书</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($suppliers)) { ?>
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