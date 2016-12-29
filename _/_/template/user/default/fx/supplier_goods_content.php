<style>
    .ui-nav li.active a {
        font-size: 100%;
        border-bottom-color: #fff;
        background: #fff;
        margin:0px;
        line-height: 32px;
    }

</style>

<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <nav class="ui-nav clearfix">
            <ul class="pull-left">
                <li class="<?php echo $is == 1 ? 'active' : ''?>">
                    <a href="#1" data-is="1">可设置分销的商品</a>
                </li>
                <li class="<?php echo $is == 2 ? 'active' : ''?>">
                    <a href="#2" data-is="2">可设置批发的商品</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
            <?php if (!empty($products)) { ?>
            <tr>
                <th>商品</th>
                <th></th>
                <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
                    库存
                </th>
                <th class="cell-12" style="min-width: 102px; max-width: 102px;">
                    创建时间
                </th>
                <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
                    销量
                </th>
                <th class="cell-10 text-right" style="min-width: 85px; max-width: 85px;">人气</th>
                <th class="cell-15 text-right" style="min-width: 127px; max-width: 127px;">操作</th>
            </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td class="goods-image-td">
                        <div class="goods-image js-goods-image ">
                            <img src="<?php echo $product['image']; ?>" />
                        </div>
                    </td>
                    <td class="goods-meta">
                        <p class="goods-title">
                            <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                                <?php echo $product['name']; ?>
                            </a>
                        </p>
                        <p><span class="goods-price" goods-price="<?php echo $product['price']; ?>">￥<?php echo $product['price']; ?></span></p>
                    </td>
                    <td class="text-right"><?php echo $product['quantity']; ?></td>
                    <td class=""><?php echo date('Y-m-d H:i:s', $product['date_added']); ?></td>
                    <td class="text-right">
                        <?php echo $product['sales']; ?>
                    </td>
                    <td class="text-right">
                        <?php echo $product['pv']; ?>
                    </td>
                    <td class="text-right">
                        <?php if($is == 1) {?>
                        <p>
                            <a href="<?php echo dourl('goods_fx_setting', array('id' => $product['product_id'], 'role' => 'supplier')); ?>">设置分销</a><span></span>
                        </p>
                        <?php } else if ($is ==2){?>
                        <p>
                            <a href="<?php echo dourl('goods_wholesale_setting', array('id' => $product['product_id'], 'role' => 'supplier')); ?>">设置批发</a><span></span>
                        </p>
                        <?php }?>
                    </td>
                </tr>
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
            <div class="js-page-list ui-box pagenavi"><?php echo $page;?></div>
        </div>
        <?php } ?>
    </div>
</div>					