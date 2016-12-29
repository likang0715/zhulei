<script type="text/javascript">
    var product_groups_json = '<?php echo $product_groups_json; ?>';
</script>
<style type="text/css">
    .red {
        color: red;
    }
    .ui-table td.goods-meta {
        width: 240px;
    }
</style>
<div class="goods-list">
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
            <?php if (!empty($warn_list)) { ?>
            <tr>
                <th class="checkbox cell-25" colspan="2" style="min-width: 332px; max-width: 332px;">
                    <label class="checkbox inline">商品</label>
                </th>
                <th class="cell-15 text-right" style="min-width: 68px; max-width: 68px;"><a href="javascript:;">价格</a></th>
                <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">门店库存</th>
                <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">所属门店</th>
                <th class="cell-15 text-right" style="min-width: 127px; max-width: 127px;">操作</th>
            </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($warn_list as $product) { ?>
                <tr>
                    <td class="goods-image-td">
                        <?php echo $product['product']['name'] ?>
                    </td>
                    <?php if (!empty($product['sku'])) { ?>
                        <td class="goods-meta">
                            <p class="goods-title">
                                <?php foreach ($product['sku']['_property'] as $_property) { ?>
                                    <div class="goods-image js-goods-image" style="float: left; padding-right: 10px;">
                                        <img src="<?php echo $_property['image']; ?>" title="<?php echo $_property['name'].':'.$_property['value'] ?>" />
                                    </div>
                                <?php } ?>
                                <?php foreach ($product['sku']['_property'] as $_property) { ?>
                                    <?php echo '['.$_property['name'].':'.$_property['value'].']' ?>
                                <?php } ?>
                                
                            </p>
                        </td>
                    <?php } else { ?>
                        <td class="goods-meta">
                            <p class="goods-title">
                                <div class="goods-image js-goods-image ">
                                    <img src="<?php echo $product['product']['image']; ?>" />
                                </div>
                            </p>
                        </td>
                    <?php } ?>
                    <td class="text-right">
                        <?php if (!empty($product['sku'])) { ?>
                            <?php echo $product['sku']['price'] ?>
                        <?php } else { ?>
                            <?php echo $product['product']['price'] ?>
                        <?php } ?>
                    </td>
                    <td class="text-right">
                        <p class="data-quantity"><?php echo $product['quantity'] ?></p>
                    </td>
                    <td class="text-right">
                        【<?php echo $product['physical']['name'] ?>】
                    </td>
                    <td class="text-right">
                    <?php if ($this->user_session['type'] == 0) { ?>
                        <a href="javascript:void(0);" class="js-physical-quantity-edit" data-id="<?php echo $product['pigcms_id'] ?>">修改库存</a>
                    <?php } else { ?>
                        无
                    <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php if (empty($warn_list)) { ?>
        <div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
        <?php } ?>
    </div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($warn_list)) { ?>
        <div>
            <div class="pull-left">
            </div>
            <div class="js-page-list ui-box pagenavi"><?php echo $page;?></div>
        </div>
        <?php } ?>
    </div>
</div>                  