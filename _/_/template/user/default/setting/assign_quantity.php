<script type="text/javascript">
    var product_groups_json = '<?php echo $product_groups_json; ?>';
</script>
<style type="text/css">
    .red {
        color: red;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div>
            <h3 class="list-title js-goods-list-title">&nbsp;</h3>
            <div class="js-list-tag-filter ui-chosen" style="width: 200px;">
                <div class="chosen-container chosen-container-single" style="width: 0px;" title="">
                    <a class="chosen-single" tabindex="-1"><span>所有分组</span>
                        <div><b></b></div>
                    </a>
                    <div class="chosen-drop">
                        <div class="chosen-search"><input type="text" autocomplete="off"></div>
                        <ul class="chosen-results">
                            <li class="active-result result-selected highlighted" style="" data-option-array-index="0">所有分组</li>
                            <?php foreach ($product_groups as $product_group) { ?>
                            <li class="active-result" style="" data-option-array-index="<?php echo $product_group['group_id']; ?>"><?php echo $product_group['group_name']; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="js-list-search ui-search-box">
                <input class="txt" type="text" placeholder="搜索" value="">
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
            <?php if (!empty($products)) { ?>
            <tr>
                <th class="checkbox cell-35" colspan="3" style="min-width: 332px; max-width: 332px;">
                    <label class="checkbox inline"><!-- <input type="checkbox" class="js-check-all"> -->商品</label>
                    <a href="javascript:;" class="orderby" data-orderby="price">价格</a>
                </th>
                <th class="cell-10" style="min-width: 85px; max-width: 85px;">访问量</th>
                <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
                    <a href="javascript:;" class="orderby" data-orderby="quantity">库存</a>
                </th>
                <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
                    <a href="javascript:;" class="orderby" data-orderby="sales">总销量</a>
                </th>
                <th class="cell-12" style="min-width: 102px; max-width: 102px;">
                    <a href="javascript:;" class="orderby" data-orderby="date_added">创建时间</th>
                <th class="cell-15 text-right" style="min-width: 127px; max-width: 127px;">操作</th>
            </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td class="checkbox">
                        <!-- <input type="checkbox" class="js-check-toggle" value="<?php echo $product['product_id']; ?>" /> -->
                        &nbsp;
                    </td>
                    <td class="goods-image-td">
                        <div class="goods-image js-goods-image ">
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
                        <p>
                            <span class="goods-price" goods-price="<?php echo $product['price']; ?>">￥<?php echo $product['price']; ?></span>
                            <?php if (!empty($product['wholesale_product_id'])) { ?>
                                <i class="platform-tag" style="background-color: #07d">批发</i>
                            <?php } else if (!empty($product['supplier_id'])) { ?>
                                <i class="platform-tag">分销</i>
                            <?php } ?>
                        </p>
                    </td>
                    <td>
                        <div>PV: <?php echo $product['pv']; ?></div>
                    </td>
                    <td class="text-right"><?php echo $product['quantity']; ?></td>
                    <td class="text-right"><?php echo $product['sales']; ?></td>
                    <td class=""><?php echo date('Y-m-d', $product['date_added']); ?></td>
                    <td class="text-right">
                        <p>
                            <?php if (empty($product['has_property'])) { ?>
                            <a href="javascript:void(0);" class="js-show-assign" data-product_id="<?php echo $product['product_id']; ?>">分配库存</a>
                            <?php } ?>
                        </p>
                    </td>
                </tr>
                <?php if (!empty($product['has_property']) && !empty($product['sku'])) { //商品规格列表 ?>
                    <?php foreach ($product['sku'] as $product_sku) { ?>
                    <tr>
                        <td class="checkbox">&nbsp;</td>
                        <td class="goods-image-td">
                            <p>
                                <?php if (!empty($_POST['keyword'])) { ?>
                                <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $product['name']); ?>
                                <?php } else { ?>
                                <?php echo $product['name']; ?>
                                <?php } ?>
                                [规格]
                            </p>
                        </td>
                        <td class="goods-meta">
                            <p class="goods-title">
                                <?php foreach ($product_sku['_property'] as $_property) { ?>
                                    <div class="goods-image js-goods-image" style="float: left; padding-right: 10px;">
                                        <img src="<?php echo $_property['image']; ?>" title="<?php echo $_property['name'].':'.$_property['value'] ?>" />
                                    </div>
                                <?php } ?>

                                <?php foreach ($product_sku['_property'] as $_property) { ?>
                                    <?php echo '['.$_property['name'].':'.$_property['value'].']' ?>
                                <?php } ?>
                            </p>
                            <p>
                                <span>￥<?php echo $product_sku['price']; ?></span>
                                <?php if (!empty($product['wholesale_product_id'])) { ?>
                                    <i class="platform-tag" style="background-color: #07d">批发</i>
                                <?php } else if (!empty($product['supplier_id'])) { ?>
                                    <i class="platform-tag">分销</i>
                                <?php } ?>
                            </p>
                        </td>
                        <td>
                            <div>----</div>
                        </td>
                        <td class="text-right"><?php echo $product_sku['quantity']; ?></td>
                        <td class="text-right"><?php echo $product_sku['sales']; ?></td>
                        <td class="">----</td>
                        <td class="text-right">
                            <p>
                                <a href="javascript:void(0);" class="js-show-assign" data-sku_id="<?php echo $product_sku['sku_id'] ?>" data-product_id="<?php echo $product['product_id']; ?>">分配库存</a>
                            </p>
                        </td>
                    </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <?php if (empty($products)) { ?>
        <div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
        <?php } ?>
    </div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($products)) { ?>
        <div>
            <div class="pull-left">
                <!-- <a href="javascript:;" class="ui-btn js-batch-tag" data-loading-text="加载...">改分组</a>
                <a href="javascript:;" class="ui-btn js-batch-unload">下架</a>
                <a href="javascript:;" class="ui-btn js-batch-delete">删除</a> -->
                <!--<a href="javascript:;" class="ui-btn js-batch-discount">会员折扣</a>-->
            </div>
            <div class="js-page-list ui-box pagenavi"><?php echo $page;?></div>
        </div>
        <?php } ?>
    </div>
</div>                  