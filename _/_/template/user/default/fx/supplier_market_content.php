<style type="text/css">
    .red {
        color:red;
    }

    .ui-nav {
        border: none;
        background: none;
        position: relative;
        border-bottom: 1px solid #e5e5e5;
        margin-bottom: 15px;
        margin-top: 23px;
    }
    .pull-left {
        float: left;
    }
    .ui-nav ul {
        zoom: 1;
        margin-bottom: -1px;
        margin-left: 1px;
    }
    .ui-nav li {
        float: left;
        margin-left: -1px;
    }
    .ui-nav li a {
        display: inline-block;
        padding: 0 12px;
        line-height: 32px;
        color: #333;
        border: 1px solid #e5e5e5;
        background: #f8f8f8;
        min-width: 80px;
        text-align: center;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .ui-nav li.active a {
        font-size: 100%;
        border-bottom-color: #fff;
        background: #fff;
        margin:0px;
        line-height: 32px;
    }
    .popover-inner {
        padding: 3px;
        /* width: 280px; */
        /* overflow: hidden; */
        /* background: #000000; */
        background: rgba(0, 0, 0, 0.8);
        border-radius: 4px;
        -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
        box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    }
</style>
<?php $version = option('config.weidian_version');?>
<div class="goods-list">
<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
    <div class="widget-list-filter">
        <nav class="ui-nav clearfix">
            <ul class="pull-left">
              <li class="<?php echo $is == 3 ? 'active' : ''?>">
                    <a href="#all" data-is="3">所有的商品</a>
                </li>
                
                <?php if(in_array(PackageConfig::getRbacId(14,'fx','setting'), $rbac_result) || $package_id == 0){?>
                    <li class="<?php echo $is == 1 ? 'active' : ''?>">
                        <a href="#fx" data-is="1">已设置分销的商品</a>
                    </li>
                <?php } ?>
               
               <?php if(in_array(PackageConfig::getRbacId(15,'fx','whole_setting'), $rbac_result) || $package_id == 0){?>  
                    <?php if(empty($version) && !empty($allow_platform_drp)){?>
                    <li class="<?php echo $is == 2 ? 'active' : ''?>">
                        <a href="#wholesale" data-is="2">已设置批发的商品</a>
                    </li>
                    <?php } ?>
                <?php } ?>
            

            </ul>
        </nav>
        <div class="market-filter-container">

            <div class="js-list-tag-filter ui-chosen market-filter">
                <div class="chosen-container chosen-container-single" style="width: 160px!important;" title="">
                    <a class="chosen-single" tabindex="-1"><span>所有类目</span>
                        <div><b></b></div>
                    </a>

                    <div class="chosen-drop">
                        <ul class="chosen-results">
                            <li class="active-result result-selected highlighted" data-option-array-index="0">所有类目</li>
                            <?php foreach ($categories as $category) { ?>
                            <li class="active-result" style="" data-option-array-index="<?php echo $category['cat_fid']; ?>|<?php echo $category['cat_id']; ?>"><?php if ($category['cat_level'] > 1) { ?><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $category['cat_level']) . '|-- ' . $category['cat_name']; ?><?php } else { ?><b><?php echo $category['cat_name'];?></b><?php } ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="js-list-search">
                <input class="js-keyword txt market-serach-input" type="text" placeholder="商品名称" value="" style="left: 185px!important;">

                <input type="button" class="market-search-btn ui-btn ui-btn-primary" value="搜索" style="left: 408px" />
            </div>
        </div>
    </div>
</div>
<div class="ui-box">
<table class="ui-table ui-table-list" style="padding: 0px;">
<?php if (!empty($products)) { ?>
<thead class="js-list-header-region tableFloatingHeaderOriginal">
<tr class="widget-list-header">
    <th class="cell-35 text-align" style="text-align:center;" colspan="">LOGO</th>
    <th class="cell-35 text-align" style="text-align:center;" colspan="">商品</th>
    <?php if($is == 3) {?>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_price">本店售价</a></th>
    <?php }else{?>
        <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_price">成本价</a></th>
    <?php }?>
    <?php if($is != 3) {?>
    <th class="cell-10 text-right">建议零售价</th>
    <th class="cell-10 text-right">利润</th>
    <?php }?>
    <th class="cell-8 text-right"><a href="javascript:;" data-orderby="stock_num">库存</a></th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="sold_num">销量</a></th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_count">人气</a></th>
    <th class="cell-15 text-right">操作</th>
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
        <p class="goods-title">
            <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                <?php if (!empty($_POST['keyword'])) { ?>
                <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $product['name']); ?>
                <?php } else { ?>
                <?php echo $product['name']; ?>
                <?php } ?>
            </a>
        </p>
        <span class="js-tuijian-product" style="cursor: help;">
        <?php if ($product['is_recommend']) { ?>
            <i class="platform-tag" style="background-color: #DB2E2E;padding: 0px 2px 0px 3px;">荐</i>
        <?php } ?>
        </span>
        <?php if (!empty($allow_platform_drp)) { ?>
        <span class="js-baiming-product" style="cursor: help;">
        <?php if($is == 2 && !empty($product['is_whitelist'])) {?>
            <i class="platform-tag" style="background-color: green">白名单</i>
        <?php }?>
        </span>
        <span class="js-whole-product" style="cursor: help;">
        <?php if($is == 3 && $product['supplier_id'] > 0 && !empty($product['wholesale_product_id'])) {?>
            <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">批发</i>
        <?php }?>
        </span>
        <?php } ?>
        <span class="js-own-product" style="cursor: help;">
        <?php if($is == 3 && $product['supplier_id'] == 0) {?>
            <i class="platform-tag" style="background-color: green;padding: 0px 2px 0px 3px;">自营</i>
        <?php }?>
        </span>
        <?php if (!empty($allow_platform_drp)) { ?>
        <span class="js-whole-product" style="cursor: help;">
        <?php if($is == 1 && $product['supplier_id'] > 0 && !empty($product['wholesale_product_id'])) {?>
            <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">批发</i>
        <?php }?>
        </span>
        <?php } ?>
        <span class="js-own-product" style="cursor: help;">
        <?php if($is == 1 && $product['supplier_id'] == 0) {?>
            <i class="platform-tag" style="background-color: green;padding: 0px 2px 0px 3px;">自营</i>
        <?php }?>
        </span>
    </td>

    <?php if($is == 3 && !$product['supplier_id'] > 0){?>
        <td class="text-right">
            <p>￥<?php echo $product['price']; ?></p>
        </td>
    <?php } else if($is == 3 && $product['supplier_id'] > 0){?>
        <td class="text-right">
            <p>￥<?php echo $product['price']; ?></p>
        </td>
    <?php }?>

    <?php if($is == 1){?>
        <td class="text-right">
            <p>￥<?php echo $product['drp_level_1_cost_price']; ?></p>
        </td>
    <?php } else if($is == 2 ){?>
        <td class="text-right">
            <p>￥<?php echo $product['wholesale_price']; ?></p>
        </td>
    <?php }?>

    <?php if($is == 1){?>
        <td class="text-right">
            <p>￥<?php echo $product['min_fx_price']; ?></p>
        </td>
    <?php } else if($is == 2){?>
        <td class="text-right">
            <p>￥<?php echo $product['sale_min_price']; ?></p>
            <p>-￥<?php echo $product['sale_max_price']; ?></p>
        </td>
    <?php }?>

   <?php if($is != 3){?>
    <td class="text-right">
    <?php if ($is == 1){?>
        <p>￥<?php echo number_format($product['drp_level_1_price'] - $product['drp_level_1_cost_price'], 2, '.', ''); ?></p>
    <?php }else if($is==2){?>
        <p>￥<?php echo number_format($product['sale_min_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>

        <p>- ￥<?php echo number_format($product['sale_max_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>
    <?php }?>
    </td>
   <?php }?>
    <td class="text-right">
        <p><?php echo $product['quantity']; ?></p>
    </td>
    <td class="text-right">
        <?php echo max($product['sales'], 0); ?>
    </td>
    <td class="text-right">
        <?php echo $product['pv']; ?>
    </td>

    <td class="text-right">
        <p class="js-opts">
            <?php if($is ==1 && $product['supplier_id']>0 && empty($product['wholesale_product_id'])){?>
                修改分销<br/>
                取消分销
            <?php } else if($is == 1 && $product['supplier_id']>0 && !empty($product['wholesale_product_id'])){?>
                <p><a href="<?php echo dourl('edit_goods', array('id' => $product['product_id'], 'page'=>$p)); ?>">修改分销</a></p>
                <p><a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-is="<?php echo $is; ?>" class="js-cancel-to-fx">取消分销</a></p>
                <?php if (!empty($open_drp_degree) && !empty($drp_degrees)) { ?>
                <p><a href="javascript:;" class="drp-degree-setting" data-id="<?php echo $product['product_id']; ?>">分销特权</a></p>
                <?php } ?>
            <?php } else if($is == 1 && empty($product['supplier_id'])){?>
                <p><a href="<?php echo dourl('edit_goods', array('id' => $product['product_id'], 'page'=>$p)); ?>">修改分销</a></p>
                <p><a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-is="<?php echo $is; ?>" class="js-cancel-to-fx">取消分销</a></p>
                <?php if (!empty($open_drp_degree) && !empty($drp_degrees)) { ?>
                <p><a href="javascript:;" class="drp-degree-setting" data-id="<?php echo $product['product_id']; ?>">分销特权</a></p>
                <?php } ?>
            <?php } else if($is == 2 && !empty($allow_platform_drp)){?>
                <a href="<?php echo dourl('edit_wholesale', array('id' => $product['product_id'], 'page'=>$p)); ?>">修改批发</a><br/>
                <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-is="<?php echo $is; ?>" class="js-cancel-to-wholesale">取消批发</a><br/>
                <?php if($product['is_whitelist']) {?>
                    <a href="javascript:;" data-product="<?php echo $product['product_id']; ?>" class="js-edit-cost-item">修改白名单</a><br/>
                    <a href="javascript:;" data-product="<?php echo $product['product_id']; ?>" class="js-delete-cost-item">取消白名单</a><br/>
                <?php } else {?>
                    <a href="javascript:;" data-product="<?php echo $product['product_id']; ?>" class="js-edit-cost-item">设置白名单</a>
                <?php }?>

            <?php } else if($is == 3){?>
              

            <?php if(in_array(PackageConfig::getRbacId(14,'fx','setting'), $rbac_result) || $package_id == 0){?>
                   <?php if($product['supplier_id'] > 0 && empty($product['is_fx']) && empty($product['wholesale_product_id'])){?>
                        设置分销
                   <?php } else if($product['supplier_id'] > 0 && $product['is_fx'] == 1 && !empty($product['wholesale_product_id'])){?>
                        已分销
                   <?php } else if($product['supplier_id'] > 0 && empty($product['is_fx']) && !empty($product['wholesale_product_id'])) {?>
                        <a href="<?php echo dourl('goods_fx_setting', array('id' => $product['product_id'])); ?>">设置分销</a>
                   <?php }?>
                <?php if(!$product['supplier_id'] > 0 && empty($product['is_fx'])){?>
                    <a href="<?php echo dourl('goods_fx_setting', array('id' => $product['product_id'])); ?>">设置分销</a><br/>
                <?php } else if (!$product['wholesale_product_id'] > 0 && !empty($product['is_fx'])){?>
                        已分销<br/>
                <?php }?>
             <?php } ?>
            <?php if(in_array(PackageConfig::getRbacId(15,'fx','whole_setting'), $rbac_result) || $package_id == 0){?> 
                       
                <?php if(empty($version) && !empty($allow_platform_drp)){?>
                    <?php if(!$product['supplier_id'] > 0 && empty($product['is_wholesale'])){?>
                        <a href="<?php echo dourl('goods_wholesale_setting', array('id' => $product['product_id'])); ?>">设置批发</a>
                    <?php } else if (!$product['supplier_id'] > 0 && !empty($product['is_wholesale'])){?>
                        已批发
                    <?php }?>
                <?php }?>

            <?php } ?>

            <?php }?>
        </p>
    </td>
</tr>
<?php } ?>
</tbody>
<?php } ?>
</table>
    <div class="js-list-empty-region">
        <?php if (empty($products)) { ?>
        <div>
            <div class="no-result widget-list-empty">还没有相关数据。</div>
        </div>
        <?php } ?>
    </div>
</div>
<div class="js-list-footer-region ui-box">
    <?php if (!empty($products)) { ?>
    <div class="widget-list-footer">
        <div class="pull-left">
            <!--<a href="javascript:;" class="ui-btn js-batch-cancel-to-fx">批量取消分销</a>-->
        </div>
        <input type="hidden" data-is="<?php echo $is;?>" class="page-is">
        <div class="pagenavi ui-box"><?php echo $page; ?></div>
    </div>
    <?php } ?>
</div>
</div>

<script>
    var t1 = '';
    var t2 = '';
    var t3 = '';
    var t4 = '';
    var t0 = '';

    $('.js-baiming-product').hover(function(){
        var content = $(this).next('.js-notes-cont').html();
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="font-size: xx-small;display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left-140) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">加入白名单的商品只有指定的经销商才能批发(添加到店铺)</div></div></div>';
        $('body').append(html);
        $('.popover-help-notes').show();
    }, function(){
        t4 = setTimeout('hide2()', 200);
    })
    $('.popover-help-notes').live('hover', function(event){
        if (event.type == 'mouseenter') {
            clearTimeout(t4);
        } else {
            clearTimeout(t4);
            hide2();
        }
    })

    $('.js-tuijian-product').hover(function(){
        var content = $(this).next('.js-notes-cont').html();
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="font-size: xx-small;display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left-140) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">全网最低价格、新品、热卖商品</div></div></div>';
        $('body').append(html);
        $('.popover-help-notes').show();
    }, function(){
        t1 = setTimeout('hide2()', 200);
    })
    $('.popover-help-notes').live('hover', function(event){
        if (event.type == 'mouseenter') {
            clearTimeout(t1);
        } else {
            clearTimeout(t1);
            hide2();
        }
    })

    $('.js-own-product').hover(function(){
        var content = $(this).next('.js-notes-cont').html();
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="font-size: xx-small;display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left-140) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">自己生产自己经营的商品或者不是从本平台经营者(供货商)店铺添加到自己店铺的商品</div></div></div>';
        $('body').append(html);
        $('.popover-help-notes').show();
    }, function(){
        t2 = setTimeout('hide2()', 200);
    });

    $('.popover-help-notes').live('hover', function(event){
        if (event.type == 'mouseenter') {
            clearTimeout(t2);
        } else {
            clearTimeout(t2);
            hide2();
        }
    });

    $('.js-whole-product').hover(function(){
        var content = $(this).next('.js-notes-cont').html();
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="font-size: xx-small;display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + ($(this).offset().left-140) +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">从其他经营者(供货商)店铺添加到自己店铺的商品</div></div></div>';
        $('body').append(html);
        $('.popover-help-notes').show();
    }, function(){
        t3= setTimeout('hide2()', 200);
    })

    $('.popover-help-notes').live('hover', function(event){
        if (event.type == 'mouseenter') {
            clearTimeout(t3);
        } else {
            clearTimeout(t3);
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