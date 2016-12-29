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
    .js-cancel-to-fx {
        color: red!important;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
        <div class="widget-list-filter"><h3 class="list-title js-list-title">分销中的商品</h3>

            <div class="ui-block-head-help soldout-help js-soldout-help hide">
                <a href="javascript:void(0);" class="js-help-notes" data-class="right"></a>

                <div class="js-notes-cont hide">
                    <p>当商品的所有规格或者某一个规格的库存变为0时，将显示在已售罄的商品列表中</p>
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal">
            <?php if (!empty($products)) { ?>
            <tr class="widget-list-header">
                <th class="cell-10">图片</th>
                <th class="cell-25 text-center">商品名称</th>
                <th class="cell-10 text-right">建议零售价</th>
                <th class="cell-10 text-right">利润</th>
                <th class="cell-10">供货商</th>
                <th class="cell-10 text-right"><a href="javascript:;" data-orderby="stock_num">库存</a></th>
                <th class="cell-10 text-right"><a href="javascript:;" data-orderby="sold_num">本店销量</a></th>
            </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php if (!empty($products)) { ?>
            <?php foreach ($products as $product) { ?>
            <tr class="widget-list-item">
                <td class="goods-image-td">
                    <div class="goods-image js-goods-image">
                        <img src="<?php echo $product['image']; ?>" />
                    </div>
                </td>
                <td class="goods-meta">
                    <p class="goods-title">
                        <a href="wap/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $_SESSION['store']['store_id']; ?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                            <?php echo $product['name']; ?>
                        </a>
                    </p>
                </td>
                <td class="text-right">
                    <p style="color: #c91623;">￥<?php echo $product['fx_price']; ?></p>
                </td>
                <td class="text-right">
                    <p style="color: green;">￥<?php echo $product['fx_profit']; ?></p>
                </td>
                <td>
                    <?php echo $product['supplier']; ?>
                </td>
                <td class="text-right">
                    <p><?php echo $product['quantity']; ?></p>
                </td>
                <td class="text-right">
                    <?php echo $product['sales']; ?>
                </td>
            </tr>
            <?php } ?>
            <?php } ?>
            </tbody>
        </table>
        <div class="js-list-empty-region">
            <?php if (empty($products)) { ?>
                <div><div class="no-result">还没有相关数据。</div></div>
            <?php } ?>
        </div>
    </div>
    <div class="js-list-footer-region ui-box">
        <div class="widget-list-footer">
            <?php if (!empty($products)) { ?>
            <div class="pagenavi"><?php echo $page; ?></div>
            <?php } ?>
        </div>
    </div>
</div>