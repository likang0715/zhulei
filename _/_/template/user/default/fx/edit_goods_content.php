<style type="text/css">
    .controls {
        margin-top: 5px;
    }
    .ui-nav {
        width: 100%;
        position: relative;
        margin-bottom: -29px;
        margin-top: 15px;
        background: #F5F5F5;
        border: none;
        width: 693px;
        margin-left: 20px;
        border-left: 1px solid rgba(126, 88, 139, 0.13);
        border-bottom: 1px solid rgba(126, 88, 139, 0.13);
    }
    .ui-nav ul {
        width: 100%;
        margin: 0;
        padding: 0;
    }
    .ui-nav li {
        margin: 0px;
        padding: 0px;
        background: white;
        border-top: 1px solid rgba(126, 88, 139, 0.13);
        border-right: 1px solid rgba(126, 88, 139, 0.13);
        text-align: center;
        width: 200px;
    }
    .ui-nav li.active {
        position: relative;
        margin-bottom: -1px;
    }
    .ui-nav li.active a {
        padding: 0px;
        color: #07d;
        border-bottom-color: #fff;
        background: #fff;
        margin: 0px;
        font-size: 14px;
        line-height: 43px;
    }
    .product-price-setting tr .bg {
        background-color: #eee;
    }
    .product-price-setting thead tr td {
        padding: 5px 0px;
    }
    .text-center {
        text-align: center;
    }
    .input-3 {
        width: 80px
    }
    .input-4 {
        width: 50px;
    }
    .input2-3 {
        width: 50px;
    }
    .input2-4 {
        width: 50px;
    }
</style>
<div class="goods-edit-area">
    <ul class="ui-nav-tab">
        <li data-next-step="2" class="js-switch-step js-step-2 active"><a href="javascript:;">分销商品信息修改</a></li>
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
                                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" width="100" height="100"/>
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
                                    <label class="control-label">成本价格：</label>
                                    <div class="controls">
                                        ￥<?php echo $product['drp_level_1_cost_price']; ?>
                                        <input type="hidden" value="<?php echo $product['price']; ?>"
                                               class="cost_price_hidden">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">建议售价：</label>
                                    <div class="controls">
                                        ￥<?php echo $fx_price_min; ?>
                                        <input type="hidden" value="<?php echo $fx_price_min; ?>" class="sale-price" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sku-info-region" class="goods-info-group">
                    <div class="goods-info-group-inner">
                        <div class="info-group-title vbox">
                            <div class="group-inner">分销设置</div>
                        </div>
                        <div class="info-group-cont vbox">
                            <div class="group-inner">
                                <div class="control-group">
                                    <label class="control-label">商家推荐：</label>
                                    <div class="controls">
                                        <input type="checkbox" name="is_recommend" value="1" <?php if ($product['is_recommend']) { ?>checked="true"<?php } ?> /> 是
                                        <span class="gray">(全网最低价格、新品、热卖商品)</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">统一直销利润：</label>
                                    <div class="controls">
                                        <input type="checkbox" name="unified_profit" value="1" <?php if ($product['unified_profit']) { ?>checked="true"<?php } ?> /> 是
                                        <span class="gray" style="color:red;">(勾选后各级店铺卖出此商品，利润统一按第“三级分润”发放。)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="goods-info-group-inner">
                        <div class="info-group-title vbox">
                            <div class="group-inner">库存/规格</div>
                        </div>
                        <div class="info-group-cont vbox">
                            <div>
                                <nav class="ui-nav clearfix">
                                    <ul id="setting-price-methods" class="pull-left">
                                        <li class="setting-price-method<?php if (empty($product['unified_price'])) { ?> active<?php } ?>" data-method="0">
                                            <a style='cursor:pointer;'>分别设置零售价</a>
                                        </li>
                                        <li class="setting-price-method<?php if (!empty($product['unified_price'])) { ?> active<?php } ?>" data-method="1">
                                            <a style='cursor:pointer;'>统一零售价</a>
                                        </li>
                                        <li style="width: auto;border: none;background: none;"><a style="color: gray">* 两种定价方式任选一种设置即可</a></li>
                                        <input type="hidden" class="hidden-data-profit" />
                                    </ul>
                                </nav>
                            </div>
                            <div class="group-inner">
                                <div class="setting-price-method-content setting-price-method-0-content">
                                    <input type="hidden" value="<?php echo !empty($sku_content2) ? '1' : '0'; ?>" class="sku_content">
                                    <?php if (!empty($sku_content)) { ?>
                                        <div class="js-goods-stock control-group goods-sku-fx-setting">
                                            <div id="stock-region" class="controls sku-stock" style="margin-left: 0;">
                                                <div class="sku-price-1 <?php if (empty($open_drp_setting_price) || empty($unified_price_setting)) { ?><?php } ?>">
                                                    <br/>
                                                    <p class="tip" style="color: orange">* <b>温馨提示：</b>如果您为各级分销商设置了统一的成本价格或分销价格就可以使用微店的多级分销功能。
                                                    </p>
                                                    <br/>
                                                    <b style="color: #07d">一级分销商定价(<b class="tip" style="color: red">温馨提示：成本价是您给分销商的价格,分销价是指分销商卖给消费者的终端价</b>)</b>
                                                    <table class="table-sku-stock table-sku-stock-1" data-level="1">
                                                        <?php echo $sku_content; ?>
                                                    </table>
                                                    <br/>
                                                    <b style="color: #07d">二级分销商定价(<b class="tip" style="color: red">温馨提示：成本价是您给分销商的价格,分销价是指分销商卖给消费者的终端价</b>)</b>
                                                    <table class="table-sku-stock table-sku-stock-2" data-level="2">
                                                        <?php echo $sku_content2; ?>
                                                    </table>
                                                    <br/>
                                                    <b style="color: #07d">三级及以上分销商定价(<b class="tip" style="color: red">温馨提示：成本价是您给分销商的价格,分销价是指分销商卖给消费者的终端价</b>)</b>
                                                    <table class="table-sku-stock table-sku-stock-3" data-level="3">
                                                        <?php echo $sku_content3; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <!-- 统一利润开始 -->
                                <div class="js-goods-stock control-group setting-price-method-content setting-price-method-1-content" <?php if (empty($product['unified_price'])) { ?>style="display:none;"<?php } ?>>
                                    <div id="stock-region" class="controls sku-stock" style="margin-left: 0;">
                                        <div class="unified-profit-1">
                                            <br/>
                                            <p class="tip" style="color: red">* <b>温馨提示：统一分销商利润,每级分销商得到的利润将按照您的设置来分配.</p>
                                            <br/>
                                            <div class="cost-price-1">
                                                <table width="100%">
                                                    <thead>
                                                        <tr class="default-degree">
                                                            <td class="text-center bg" width="80">分润级别</td>
                                                            <td class="text-center bg default-degree">默认等级</td>
                                                            <?php if (!empty($drp_degrees)) { ?>
                                                                <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                    <td class="text-center bg"><?php echo $drp_degree['name']; ?>(+%)</td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="default-degree-1">
                                                            <td class="text-center bg">一级分润</td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="1" name="default_profit" value="<?php echo $product['drp_level_1_profit']; ?>" class="profit-price_1 input-small input-<?php echo count($drp_degrees); ?>" />
                                                                </div>
                                                            </td>
                                                            <?php if (!empty($drp_degrees)) { ?>
                                                                <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                    <td class="text-center">
                                                                        <div class="input-prepend">
                                                                            <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small input-<?php echo count($drp_degrees); ?>" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-level="1" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" value="<?php echo $drp_degree['seller_reward_1']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr class="default-degree-2">
                                                            <td class="text-center bg">二级分润</td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="2" name="default_profit" value="<?php echo $product['drp_level_2_profit']; ?>" class="profit-price_2 input-small input-<?php echo count($drp_degrees); ?>" />
                                                                </div>
                                                            </td>
                                                            <?php if (!empty($drp_degrees)) { ?>
                                                                <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                    <td class="text-center">
                                                                        <div class="input-prepend">
                                                                            <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small input-<?php echo count($drp_degrees); ?>" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-level="2" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" value="<?php echo $drp_degree['seller_reward_2']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%</span>
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr class="default-degree-3">
                                                            <td class="text-center bg">三级分润</td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="3" name="default_profit" value="<?php echo $product['drp_level_3_profit']; ?>" class="profit-price_3 input-small input-<?php echo count($drp_degrees); ?>" />
                                                                </div>
                                                            </td>
                                                            <?php if (!empty($drp_degrees)) { ?>
                                                                <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                    <td class="text-center">
                                                                        <div class="input-prepend">
                                                                            <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small input-<?php echo count($drp_degrees); ?>" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-level="3" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" value="<?php echo $drp_degree['seller_reward_3']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php if (!empty($drp_degrees)) { ?>
                                            <br/>
                                            <p class="tip" style="color: red;font-weight: normal"><span style="color: orange;font-weight: bold;">温馨提示：</span><span style="color: gray;">分销商达到指定的分销等级，分润时可额外获得 “<span style="color: #07d;">分销利润 * 分销等级奖励百分比</span>” 的奖励。</span></p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- 统一利润结束 -->

                                <!--商品分销价格开始-->
                                <div class="js-goods-stock control-group setting-price-method-content setting-price-method-0-content">
                                    <div id="stock-region" class="controls sku-stock" style="margin-left: 0;">
                                        <div class="control-group" id="unified-profit-3">
                                            <br/>
                                            <p class="tip" style="color: orange">* <b>温馨提示：</b>各级分销商的<b style = 'color:red;'>成本价格</b>是您给分销商的价格,各级分销商的<b style="color:red;">建议售价</b>是分销商卖给消费者的终端价</p>
                                            <br/>
                                            <div class="cost-price-1">
                                                <table width="100%">
                                                    <thead>
                                                        <tr class="default-degree">
                                                            <td class="text-center bg" width="80">分润级别</td>
                                                            <td class="text-center bg default-degree">成本价</td>
                                                            <td class="text-center bg default-degree">销售价</td>
                                                            <?php if (!empty($drp_degrees)) { ?>
                                                                <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                    <td class="text-center bg"><?php echo $drp_degree['name']; ?>(+%)</td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="default-degree-1">
                                                            <td class="text-center bg">一级分润</td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="1" data-min-cost-price="<?php echo $product['min_cost_price']; ?>" data-min-sale-price="<?php echo $product['min_sale_price']; ?>" name="cost_price" value="<?php echo $product['drp_level_1_cost_price']; ?>" class="cost-price-1 input-small" style="width: 50px;" />
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="1" data-min-sale-price="<?php echo $product['min_sale_price']; ?>" data-max-sale-price="<?php echo $product['max_sale_price']; ?>" name="fx_price" value="<?php echo $product['drp_level_1_price']; ?>" class="fx-price-1 input-small" style="width: 50px;" />
                                                                </div>
                                                            </td>
                                                            <?php if (!empty($drp_degrees)) { ?>
                                                                <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                    <td class="text-center">
                                                                        <div class="input-prepend">
                                                                            <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small input2-<?php echo count($drp_degrees); ?>" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" data-level="1" value="<?php echo $drp_degree['seller_reward_1']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr class="default-degree-2">
                                                            <td class="text-center bg">二级分润</td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="2" data-min-cost-price="<?php echo $product['min_cost_price']; ?>" data-min-sale-price="<?php echo $product['min_sale_price']; ?>" name="cost_price" value="<?php echo $product['drp_level_2_cost_price']; ?>" class="cost-price-2 input-small" style="width: 50px;" />
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="2" data-min-sale-price="<?php echo $product['min_sale_price']; ?>" data-max-sale-price="<?php echo $product['max_sale_price']; ?>" name="fx_price" value="<?php echo $product['drp_level_2_price']; ?>" class="fx-price-2 input-small" style="width: 50px;" />
                                                                </div>
                                                            </td>
                                                            <?php if (!empty($drp_degrees)) { ?>
                                                                <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                    <td class="text-center">
                                                                        <div class="input-prepend">
                                                                            <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small input2-<?php echo count($drp_degrees); ?>" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" data-level="2" value="<?php echo $drp_degree['seller_reward_2']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%</span>
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                        <tr class="default-degree-3">
                                                            <td class="text-center bg">三级分润</td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="3" data-min-cost-price="<?php echo $product['min_cost_price']; ?>" data-min-sale-price="<?php echo $product['min_sale_price']; ?>" name="cost_price" value="<?php echo $product['drp_level_3_cost_price']; ?>" class="cost-price-3 input-small" style="width: 50px;" />
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-prepend">
                                                                    <span class="add-on">￥</span><input type="text" maxlength="10" data-level="3" data-min-sale-price="<?php echo $product['min_sale_price']; ?>" data-max-sale-price="<?php echo $product['max_sale_price']; ?>" name="fx_price" value="<?php echo $product['drp_level_3_price']; ?>" class="fx-price-3 input-small" style="width: 50px;" />
                                                                </div>
                                                            </td>
                                                            <?php if (!empty($drp_degrees)) { ?>
                                                                <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                    <td class="text-center">
                                                                        <div class="input-prepend">
                                                                            <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small input2-<?php echo count($drp_degrees); ?>" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" data-level="3" value="<?php echo $drp_degree['seller_reward_3']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br/>
                                            <p class="tip" style="color: red;font-weight: normal"><span style="color: orange;font-weight: bold;">温馨提示：</span><span style="color: gray">上面显示的“<span style="color: #07d;">成本价</span>”、“<span style="color: #07d;">销售价</span>”均为各分销级别中不同商品规格参数的最低价格，购买中以选择的商品规格实际价格为准，若修改此处的“<span style="color: #07d;">成本价</span>”、“<span style="color: #07d;">分销价</span>”会批量修改上面的规格对应的“<span style="color: #07d;">成本价</span>”、“<span style="color: #07d;">分销价</span>”，<span style="color: red">如果上面的规格对应的“<span style="color: #07d;">成本价</span>”、“<span style="color: #07d;">分销价</span>”设置完成，这里不建议修改。</span></span></p>
                                        </div>
                                    </div>
                                </div>
                                <!--商品分销价格结束-->
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
        <input class="btn btn-primary js-btn-load js-btn-save" type="button" value="保存"
               data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="保存...">
        <input class="btn js-btn-unload js-btn-cancel" type="button" value="取消"
               data-product-id="<?php echo $product['product_id']; ?>" data-loading-text="取消...">
    </div>
</div>