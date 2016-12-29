<style>
    .title-leng{
        width:199px; line-height:25px;
        text-overflow:ellipsis;
        white-space:nowrap;
        overflow:hidden;
    }
</style>

<?php if($_POST['checked']==1){?>
<div class="goods-list">
    <div class="market-filter-container">
            <div class="js-list-tag-filter ui-chosen market-filter">
                <div class="chosen-container chosen-container-single" style="width: 98px!important;" title=""><a class="chosen-single" tabindex="-1"><span>所有类目</span>

                        <div><b></b></div>
                    </a>

                    <div class="chosen-drop">
                        <ul class="chosen-results">
                            <li class="active-result result-selected highlighted" data-option-array-index="0|0">所有类目</li>
                            <?php foreach ($categories as $category) { ?>
                            <li class="active-result" style="" data-option-array-index="<?php echo $category['parent_id']; ?>|<?php echo $category['cat_id']; ?>"><?php if ($category['level'] > 1) { ?><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $category['level']) . '|-- ' . $category['name']; ?><?php } else { ?><b><?php echo $category['name'];?></b><?php } ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="js-list-search">
                <input style="width:180px;" class="js-keyword txt market-serach-input" type="text" placeholder="店铺名称" value="<?php echo $_POST['store_name']; ?>" style="left: 185px!important;">
                <input type="button" class="market-search-btn ui-btn ui-btn-primary" value="搜索" style="left: 330px" />

            </div>
            <!--<div class="search-result">共找到&nbsp;<?php /*echo empty($is_open_store_whole) ? $store_count : '0'; */?>&nbsp;个店铺</div>-->
        <?php if($sullierIds) {?>
        <div class="alert" style="float: right;width:auto;margin-left: 20px;">
            <span style="color:#CC1212;" class="text-strong">温馨提示：</span><br>
            您是开启排他批发供货商的经销商，批发店铺只显示您的供货商店铺。<br/>
        </div>
        <?php }?>
        </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <?php if (!empty($storeInfo)) { ?>
                <thead class="js-list-header-region tableFloatingHeaderOriginal">
                <tr class="widget-list-header">
                    <th colspan="">LOGO</th>
                    <th colspan="">供货商</th>
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
                    <th style="text-align: center">操作</th>
                </tr>
                </thead>
                <tbody class="js-list-body-region">
                <?php foreach ($storeInfo as $store) { ?>
                    <tr class="widget-list-item">
                        <td class="goods-image-td">
                            <div class="goods-image">
                                <a href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $store['store_id']; ?>" target="_blank"><img src="<?php if ($store['logo'] == '' || $store['logo'] == './upload/images/') { ?><?php echo TPL_URL; ?>/images/logo.png<?php } else { ?><?php echo $store['logo']; ?><?php } ?>" /></a>
                            </div>
                        </td>
                        <td class="goods-meta">
                            <a class="new-window" href="<?php echo option('config.wap_site_url'); ?>/home.php?id=<?php echo $store['store_id']; ?>" target="_blank">
                                <?php if (isset($_POST['store_name']) && $_POST['store_name'] != '') { ?>
                                    <?php echo str_replace($_POST['store_name'], '<span class="red">' . $_POST['store_name'] . '</span>', $store['store_name']); ?>
                                <?php } else { ?>
                                    <?php echo $store['store_name']; ?>
                                <?php } ?>
                            </a>
                            <?php if($store['is_required_to_audit']==1) {?>
                               <br/> <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">需审核</i>
                            <?php }?>
                            <?php if($store['is_required_margin']==1) {?>
                                <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">需保证金</i>
                            <?php }?>
                            <?php if($store['open_store_whole']==1) {?>
                                <br/> <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">排他批发</i>
                            <?php }?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $store['category_name']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $store['linkman']; ?>
                        </td>
                        <td style="text-align:center">
                            <?php echo $store['tel']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo $store['product_count']; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo isset($store['bond']) ? $store['bond'] : '0.00'; ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo date('Y-m-d',$store['date_added']); ?>
                        </td>
                        <td style="text-align: center">

                            <a href="<?php echo dourl('market');?>&store_id=<?php echo $store['store_id'];?>">我要批发</a><br/>

                            <a href="<?php echo dourl('my_bond_log');?>&store_id=<?php echo $store['store_id'];?>">充值记录</a><br/>

                            <a href="<?php echo dourl('bond_record');?>&store_id=<?php echo $store['store_id'];?>">消费记录</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            <?php } ?>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($storeInfo) || !empty($is_open_store_whole)) { ?>
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($storeInfo) && empty($is_open_store_whole)) { ?>
            <div class="widget-list-footer">
                <div class="pagenavi"><?php echo $page; ?></div>
            </div>
        <?php } ?>
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
<?php }else if($_POST['checked']==2){ ?>
<div class="goods-list">
    <div class="market-filter-container">
            <div class="js-list-tag-filter ui-chosen market-filter">
                <div class="chosen-container chosen-container-single" style="width: 98px!important;" title=""><a class="chosen-single" tabindex="-1"><span>所有类目</span>

                        <div><b></b></div>
                    </a>


                    <div class="chosen-drop">
                        <ul class="chosen-results">
                            <li class="active-result result-selected highlighted" data-option-array-index="0|0">所有类目</li>
                            <?php foreach ($categories as $category) { ?>
                            <li class="active-result" style="" data-option-array-index="<?php echo $category['cat_fid']; ?>|<?php echo $category['cat_id']; ?>"><?php if ($category['cat_level'] > 1) { ?><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $category['cat_level']) . '|-- ' . $category['cat_name']; ?><?php } else { ?><b><?php echo $category['cat_name'];?></b><?php } ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="js-list-search">
                <input style="width:180px;" class="js-keyword txt market-serach-input" type="text" placeholder="商品名称" value="<?php echo $_POST['keyword']; ?>" style="left: 185px!important;">
                <input type="button" class="market-search-btn ui-btn ui-btn-primary" value="搜索" style="left: 330px" />

            </div>
            <!--<div class="search-result">共找到&nbsp;<?php /*echo $product_total; */?>&nbsp;件商品</div>-->
        <?php if($sullierIds) {?>
            <div class="alert" style="float: right;width:auto;margin-left: 20px;">
                <span style="color:#CC1212;" class="text-strong">温馨提示：</span><br>
                您是开启排他批发供货商的经销商，批发商品只显示您的供货商店铺的商品。<br/>
            </div>
        <?php }?>
        </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
<?php if (!empty($products) && empty($is_open_store_whole)) { ?>
<thead class="js-list-header-region tableFloatingHeaderOriginal">
<tr class="widget-list-header">
    <th class="" colspan="1">LOGO</th>
    <th class="checkbox cell-33" colspan="1">商品</th>
    <th style="text-align: right;"><a href="javascript:;" data-orderby="fx_price">批发价</a></th>
    <th style="text-align: right;">建议零售价</th>
    <th style="text-align: right;">利润</th>
    <th style="text-align: center;"><a href="javascript:;" data-orderby="stock_num">库存</a></th>
    <th style="text-align: center;"><a href="javascript:;" data-orderby="sold_num">销量</a></th>
    <th style="text-align: center;"><a href="javascript:;" data-orderby="fx_count">主营类目</a></th>
    <th style="text-align: center;width:68px;">操作</th>
</tr>
</thead>
<tbody class="js-list-body-region">
<?php foreach($products as $product) { ?>
<tr class="widget-list-item">
    <td class="goods-image-td">
        <div class="goods-image js-goods-image">
            <img src="<?php echo $product['image']; ?>" />
        </div>
    </td>
    <td class="goods-meta">
        <p class="goods-title" style="display:block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;width:200px;">
            <?php if (in_array($product['product_id'], $wholesale_products) || in_array($product['product_id'], $fx_products)) { ?>
                <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $_SESSION['store']['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                    <?php if (!empty($_POST['store_name'])) { ?>
                        <?php echo str_replace($_POST['store_name'], '<span class="red">' . $_POST['store_name'] . '</span>', $product['name']); ?>
                    <?php } else { ?>
                        <?php echo $product['name']; ?>
                    <?php } ?>

                </a>
            <?php } else { ?>
                <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $product['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                    <?php if (!empty($_POST['store_name'])) { ?>
                        <?php echo str_replace($_POST['store_name'], '<span class="red">' . $_POST['store_name'] . '</span>', $product['name']); ?>
                    <?php } else { ?>
                        <?php echo $product['name']; ?>
                    <?php } ?>
                </a>
            <?php } ?>
            <span class="goods-price" ><span style="color:#2A2727;">供货商</span>：<?php echo $product['supplier']; ?></span>
        </p>
        <?php if ($product['is_recommend']) { ?>
            <i class="platform-tag" style="background-color: #DB2E2E;padding: 0px 2px 0px 3px;">荐</i>
        <?php } ?>
        <?php if($product['open_store_whole']==1) {?>
            <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">排他批发</i>
        <?php }?>
    </td>
    <?php if($type == 'wholesale') {?>
        <td class="text-right">
            <p>￥<?php echo $product['wholesale_price']; ?></p>
        </td>
        <td class="text-right">
            <p>￥<?php echo $product['sale_min_price']; ?></p>
        </td>
    <?php } else if($type == 'fx') { ?>
         <td class="text-right">
            <p>￥<?php echo $product['cost_price']; ?></p>
        </td>
        <td class="text-right">
            <p>￥<?php echo $product['min_fx_price']; ?></p>
        </td>
    <?php }?>
    <?php if($type == 'wholesale') {?>
    <td class="text-right">
        <p>￥<?php echo number_format($product['sale_min_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>
    </td>
    <?php } else if($type == 'fx'){?>
     <td class="text-right">
        <p>￥<?php echo number_format($product['min_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>
    </td>
    <?php }?>
   
    <td class="text-right">
        <p><?php echo $product['quantity']; ?></p>
    </td>
    <td class="text-center">
        <?php echo max($product['sales'], 0); ?>
    </td>
    <td class="text-center">
        <?php echo $CategoriesArr[$product['category_fid']]['cat_name'].'-'.$CategoriesArr[$product['category_id']]['cat_name']; ?>
    </td>
    <td class="text-right">
        <p class="js-opts">
            <?php if (in_array($product['product_id'], $wholesale_products)) { ?>
                已添加
            <?php } else {?>
                <a target="_blank" href="<?php echo dourl('market');?>&store_id=<?php echo $product['store_id'];?>" >我要批发</a>
            <?php }?>
        </p>
    </td>
</tr>
<?php } ?>
</tbody>
<?php } ?>
</table>
        <div class="js-list-empty-region">
            <?php if (empty($products) || !empty($is_open_store_whole)) { ?>
                <div>
                    <div class="no-result widget-list-empty">还没有相关数据。</div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($products) && empty($is_open_store_whole)) { ?>
            <div class="widget-list-footer">
                <div class="pagenavi"><?php echo $page; ?></div>
            </div>
        <?php }?>
    </div>
</div>
<?php } ?>
</div>
