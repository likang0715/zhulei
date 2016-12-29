<style type="text/css">
    .select2-container .select2-choice {
        border-radius:0;
    }
    .select2-container .select2-choice {
        background-image: none;
    }
    .select2-container .select2-choice .select2-arrow {
        border-left: none;
        background: none;
        background-image: none;
    }
    .select2-drop {
        border-radius: 0;
    }
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

.ui-nav-table li a {  display: inline-block;  padding: 0 12px;  line-height: 40px;  color: #333;  border: 1px solid #ccc;  background: #f8f8f8;  min-width: 80px;  text-align: center;  -webkit-box-sizing: border-box;  -moz-box-sizing: border-box;  box-sizing: border-box;  }
</style>


<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li>
			<a href="/user.php?c=fx&a=wholesale_market">可批发店铺</a>
		</li>
        <li class="active">
			<a href="/user.php?c=fx&a=wholesale_market_product">可批发商品</a>
		</li>
	</ul>
</nav>
<!--<h3 style="margin-bottom:4px;">可批发商品的店铺</h3>-->




<div class="goods-list">
    <div class="market-filter-container">
            <div class="js-list-tag-filter ui-chosen market-filter">
                <div class="chosen-container chosen-container-single" style="width: 160px!important;" title=""><a class="chosen-single" tabindex="-1"><span>所有类目</span>

                        <div><b></b></div>
                    </a>

                    <div class="chosen-drop">
                        <ul class="chosen-results">
                            <li class="active-result result-selected2 highlighted" data-option-array-index="0|0">所有类目</li>
                            <?php foreach ($categories as $category) { ?>
                            <li class="active-result" style="" data-option-array-index="<?php echo $category['cat_fid']; ?>|<?php echo $category['cat_id']; ?>"><?php if ($category['cat_level'] > 1) { ?><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $category['cat_level']) . '|-- ' . $category['cat_name']; ?><?php } else { ?><b><?php echo $category['cat_name'];?></b><?php } ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="js-list-search">
                <input class="js-keyword txt market-serach-input" type="text" placeholder="商品名称" value="<?php echo $_POST['keyword']; ?>" style="left: 185px!important;">
                <input type="button" class="market-search-btn ui-btn ui-btn-primary" value="搜索" style="left: 408px" />

            </div>
            <div class="search-result">共找到&nbsp;<?php echo $product_total; ?>&nbsp;件商品</div>
        </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
<?php if (!empty($products)) { ?>
<thead class="js-list-header-region tableFloatingHeaderOriginal">
<tr class="widget-list-header">
    <th class="checkbox cell-35" colspan="3">
        <label class="checkbox inline">
            <input type="checkbox" class="js-check-all">
            商品
        </label>
    </th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_price">批发价</a></th>
    <th class="cell-10 text-right">建议零售价</th>
    <th class="cell-10 text-right">利润</th>
    <th class="cell-8 text-right"><a href="javascript:;" data-orderby="stock_num">库存</a></th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="sold_num">销量</a></th>
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_count">主营类目</a></th>
    <th class="cell-15 text-right">操作</th>
</tr>
</thead>
<tbody class="js-list-body-region">
<?php foreach($products as $product) { ?>
<tr class="widget-list-item">
    <td class="checkbox">
        <?php if($product['uid'] == $uid) {?>
        <?php } else {?>
        <input type="checkbox" class="js-check-toggle" <?php if (in_array($product['product_id'], $fx_products)) { ?>disabled="true" <?php } ?> value="<?php echo $product['product_id']; ?>" />
        <?php }?>
    </td>

    <td class="goods-image-td">
        <div class="goods-image js-goods-image">
            <img src="<?php echo $product['image']; ?>" />
        </div>
    </td>
    <td class="goods-meta">
        <p class="goods-title">
            <?php if (in_array($product['product_id'], $wholesale_products) || in_array($product['product_id'], $fx_products)) { ?>
                <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $_SESSION['store']['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                    <?php if (!empty($_POST['keyword'])) { ?>
                        <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $product['name']); ?>
                    <?php } else { ?>
                        <?php echo $product['name']; ?>
                    <?php } ?>
                </a>
            <?php } else { ?>
                <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $product['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                    <?php if (!empty($_POST['keyword'])) { ?>
                        <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $product['name']); ?>
                    <?php } else { ?>
                        <?php echo $product['name']; ?>
                    <?php } ?>
                </a>
            <?php } ?>


        </p>
        <?php if ($product['is_recommend']) { ?>
        <img class="js-help-notes" src="<?php echo TPL_URL; ?>/images/jian.png" alt="推荐" width="19" height="19" /><br/>
        <?php } ?>
    </td>
    <?php if($type == 'wholesale') {?>
        <td class="text-right">
            <p>￥<?php echo $product['wholesale_price']; ?></p>
        </td>
        <td class="text-right">
            <p>￥<?php echo $product['sale_min_price']; ?></p>
            <!--<p>- ￥<?php echo $product['sale_max_price']; ?></p>-->
        </td>
    <?php } else if($type == 'fx') { ?>
         <td class="text-right">
            <p>￥<?php echo $product['cost_price']; ?></p>
        </td>
        <td class="text-right">
            <p>￥<?php echo $product['min_fx_price']; ?></p>
           <!-- <p>- ￥<?php echo $product['max_fx_price']; ?></p>-->
        </td>
    <?php }?>
    <?php if($type == 'wholesale') {?>
    <td class="text-right">
        <p>￥<?php echo number_format($product['sale_min_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>

        <!--<p>- ￥<?php echo number_format($product['sale_max_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>-->
    </td>
    <?php } else if($type == 'fx'){?>
     <td class="text-right">
        <p>￥<?php echo number_format($product['min_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>

       <!-- <p>- ￥<?php echo number_format($product['max_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>-->
    </td>
    <?php }?>

    <td class="text-right">
        <p><?php echo $product['quantity']; ?></p>
    </td>
    <td class="text-right">
        <?php echo $product['sales']; ?>
    </td>
    <td class="text-right">
        <?php echo $CategoriesArr[$product['category_fid']]['cat_name'].'-'.$CategoriesArr[$product['category_id']]['cat_name']; ?>
    </td>
    <td class="text-right">
        <!--<p class="js-opts">
            <?php if (in_array($product['product_id'], $wholesale_products)) { ?>
                已添加
            <?php } else { ?>
                <?php if(!empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin']) && empty($is_authen)) {?>
                    <a>等待审核通过</a>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin']) && !empty($is_authen)){?>
                    <a href="<?php echo dourl('market');?>&store_id=<?php echo $product['store_id'];?>" >我要批发</a>
                <?php } else if(!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && empty($is_authen)) {?>
                    <a>等待审核通过</a>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && !empty($is_authen) && $bond['bond'] == 0){?>
                   <a href="<?php dourl('recharge');?>&store_id=<?php echo $store_id;?>">请先充值</a>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && !empty($is_authen) && $bond['bond'] > 0) {?>
                    <a href="<?php echo dourl('market');?>&store_id=<?php echo $product['store_id'];?>" >我要批发</a>
                <?php } else if(empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin'])) { ?>
                    <a href="<?php echo dourl('market');?>&store_id=<?php echo $product['store_id'];?>" >我要批发</a>
                <?php } else if(empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && $bond['bond'] > 0) {?>
                    <a href="<?php echo dourl('market');?>&store_id=<?php echo $product['store_id'];?>" >我要批发</a>
                <?php } else if (empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && $bond['bond'] == 0) {?>
                    <a href="<?php dourl('recharge');?>&store_id=<?php echo $store_id;?>">请先充值</a>
                <?php }?>
            <?php }?>
        </p>-->


        <p class="js-opts">
            <a href="<?php echo dourl('market');?>&store_id=<?php echo $product['store_id'];?>" >我要批发</a>
        </p>
    </td>
</tr>
<?php } ?>
</tbody>
<?php } ?>
</table>

    </div>
    <div class="js-list-footer-region ui-box">
            <div class="widget-list-footer">
                <div class="pagenavi"><?php echo $page; ?></div>
            </div>
    </div>


</div>
</div>
<!--<script type="text/javascript">
    var t2 = '';
    var t0 = '';
    $('.js-help-notes').hover(function(){
        var content = $(this).next('.js-notes-cont').html();
		alert(content);
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
</script>-->