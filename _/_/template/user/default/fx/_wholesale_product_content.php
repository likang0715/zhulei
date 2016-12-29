<style type="text/css">
    .red {
        color: red;
    }
</style>
<div class="goods-list">
    <div class="ui-box">
        <?php if (!empty($products)) { ?>
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
                <tr>
                    <th class="cell-10">商品图片</th>
                    <th class="cell-35">商品名称</th>
                    <th class="cell-10 text-right" style="min-width: 85px; max-width: 85px;">成本价(元)</th>
                    <th class="cell-15 text-right" style="min-width: 85px; max-width: 85px;">建议零售价(元)</th>
                    <th class="cell-10 text-right" style="min-width: 85px; max-width: 85px;">利润(元)</th>
                    <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">库存</th>
                    <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">总销量</th>
                    <th class="cell-8 text-center" style="min-width: 68px; max-width: 68px;">状态</th>
                </tr>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td class="goods-image-td">
                        <div class="goods-image js-goods-image ">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" />
                        </div>
                    </td>
                    <td class="goods-meta">
                        <p class="goods-title">
                            <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                        </p>
                        <?php if ($product['is_recommend']) { ?>
                            <img class="js-help-notes" src="<?php echo TPL_URL; ?>/images/jian.png" alt="推荐" width="19" height="19" /><br/>
                        <?php } ?>
                    </td>
                    <td class="text-right"><div><?php echo $product['wholesale_price']; ?></div></td>
                    <td class="text-right">
                        <span><?php echo $product['sale_min_price']; ?></span>
                        <span>- <?php echo $product['sale_max_price']; ?></span>
                    </td>
                    <td class="text-right">
                        <span><?php echo number_format($product['sale_min_price'] - $product['wholesale_price'], 2, '.', ''); ?></span>
                        <span>- <?php echo number_format($product['sale_max_price'] - $product['wholesale_price'], 2, '.', ''); ?></span>
                    </td>
                    <td class="text-right"><?php echo $product['quantity']; ?></td>
                    <td class="text-right"><?php echo $product['sales']; ?></td>
                    <td class="text-center">
                        <?php if (empty($product['status'])){?>
                        仓库中
                        <?php } else if ($product['status']==1){?>
                        热销中
                        <?php }?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
            <div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
        <?php } ?>
    </div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($products)) { ?>
            <div>
                <div class="js-page-list ui-box pagenavi"><?php echo $page;?></div>
            </div>
        <?php } ?>
    </div>
</div>