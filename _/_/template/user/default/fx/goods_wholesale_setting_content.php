<style type="text/css">
    input[type="radio"], input[type="checkbox"] {
        margin:0
    }
    .controls {
        margin-top: 5px;
    }
</style>
<div class="goods-edit-area">
<ul class="ui-nav-tab">
    <li data-next-step="2" class="js-switch-step js-step-2 active"><a href="javascript:;">批发商品设置</a></li>
</ul>
<div id="step-content-region">
<form class="form-horizontal fm-goods-info">



<div id="step-2" class="js-step">
<div id="base-info-region" class="goods-info-group">
    <div class="goods-info-group-inner">
        <div class="info-group-title vbox">
            <div class="group-inner">商品信息</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <div class="control-group">
                    <label class="control-label">商品图片：</label>
                    <div class="controls">
                        <img src="<?php echo $product['image']; ?>" width="100" height="100" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品类目：</label>
                    <div class="controls">
                        <?php echo $product['category']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品名称：</label>

                    <div class="controls">
                        <?php echo $product['name']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">商品库存：</label>
                    <div class="controls">
                        <?php echo $product['quantity']; ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">本店售价：</label>
                    <div class="controls">
                        ￥<?php echo $product['price']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="goods-info-region" class="goods-info-group">
<div class="goods-info-group-inner">
    <div class="info-group-title vbox">
        <div class="group-inner">批发设置</div>
    </div>
    <div class="info-group-cont vbox">
        <div class="group-inner">
            <div class="control-group">
                <label class="control-label">商家推荐：</label>
                <div class="controls">
                    <input type="checkbox" name="is_recommend" value="1" <?php if ($product['is_recommend']) { ?>checked="true"<?php } ?> /> 是 <span class="gray">(全网最低价格、新品、热卖商品)</span>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label">是否加入白名单：</label>
                <div class="controls is_whitelist">
                    <input type="checkbox" name="is_whitelist" value="1" <?php if ($product['is_whitelist']) { ?>checked="true"<?php } ?> /> 是 <span class="gray">(加入白名单指定的经销商才能批发此商品)</span>
                </div>
            </div>
            <div class="controls">
                <table class="freight-template-table freight-template-item">
                    <tbody>
                    </tbody>
                    <tfoot class="js-freight-tablefoot" style="display:table-footer-group;">
                    <tr>
                        <td><a href="javascript:;" class="js-assign-cost">选择经销商</a></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
</div>
<div id="sku-info-region" class="goods-info-group"><div class="goods-info-group-inner"><div class="info-group-title vbox">
            <div class="group-inner">库存/规格</div>
        </div>
        <div class="info-group-cont vbox">
            <div class="group-inner">
                <?php if (!empty($sku_content)) { ?>
                    <div class="js-goods-stock control-group">
                        <div id="stock-region" class="controls sku-stock" style="margin-left: 0;">
                                <div class="sku-price-1">
                                    <br/>
                                        <br/>
                                        <b style="color: #0000ff">经销商定价(<b class="tip" style="color: red">温馨提示：批发价是您给经销商的价格,零售价是指经销商卖给消费者的终端价</b>)</b>
                                        <table class="table-sku-stock table-sku-stock-1" data-level="1">
                                            <?php echo $sku_content2; ?>
                                        </table>
                                </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="control-group">
                        <label class="control-label"><em class="required">*</em>批发价格：</label>
                        <div class="cost-price-1">
                                <div class="controls">
                                    <div class="input-prepend">
                                        <span class="add-on">￥</span><input type="text" maxlength="10" name="min_wholesale_price" class="wholesale-price-one input-small" value="<?php echo !empty($is_supplier) ? '' : $wholesale_price; ?>" />
                                    </div>
                                </div>
                        </div>
                </div>
                <div class="control-group">
                        <label class="control-label"><em class="required">*</em>建议售价：</label>
                        <div class="price-1 ">
                                <div class="controls">
                                    <div class="input-prepend">
                                        <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-min-price" class="input-small fx-min-price" data-min-price="<?php echo $sale_min_price; ?>" value="<?php echo !empty($is_supplier) ? '' : $sale_min_price; ?>"/> <span style="display:inline-block;margin-top:10px">-</span> <span class="add-on">￥</span><input type="text" maxlength="10" name="fx-max-price" class="fx-max-price input-small" data-max-price="<?php echo $sale_max_price; ?>" value="<?php echo !empty($is_supplier) ? '' : $sale_max_price; ?>"/>
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>
</form>
</div>
</div>
<style type="text/css">
    .app-actions {
        position: fixed;
        bottom: 0;
        width: 850px;
        padding-top: 20px;
        clear: both;
        text-align: center;
        z-index: 2;
    }
    .app-actions .form-actions {
        padding: 10px;
        margin: 0;
    }
</style>
<div class="app-actions" style="bottom: 0px;">
    <div class="form-actions text-center">
        <input class="btn btn-primary js-btn-load js-btn-save" type="button" value="保存" data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="保存...">
        <input class="btn js-btn-unload js-btn-cancel" type="button" value="取消" data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="取消...">
    </div>
</div>