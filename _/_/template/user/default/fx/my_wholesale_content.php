<script type="text/javascript">
    var product_groups_json = '<?php echo $product_groups_json; ?>';
</script>
<style type="text/css">
    .red {
        color: red;
    }
    .ui-nav, .ui-nav2 {
        position: relative;
        margin-bottom: 0px;
        margin-top: 0px;
        background: #fff;
        width: 100%;
        border: 0px solid #ccc;
    }
    .ui-nav li.active a {
        display: block;
        color: #07d;
        font-size: 12px;
    }
</style>
<div class="goods-list">
    <div class="js-list-filter-region clearfix ui-box" style="position: relative;width: auto;">
        <div>
            <h3 class="list-title js-goods-list-title">我卖的商品(批发)</h3>
            <nav class="ui-nav clearfix" style="border-bottom: 2px solid #DADADA;">
                <ul class="pull-left">
                    <li class="<?php echo $is == 1 ? 'active' : ''?>">
                        <a href="#up" data-is="1">已上架商品</a>
                    </li>
                    <li class="<?php echo $is == 2 ? 'active' : ''?>">
                        <a href="#down" data-is="2">仓库中商品</a>
                    </li>
                </ul>
            </nav>
            <div class="widget-list-filter" style="height:48px;background: #fff;">
                <div class="filter-box" >
                    <div class="js-list-search">
                        <input type="hidden" class="data-is" data-is="<?php echo $is;?>">
                        <span style="margin-left: 8px;">商品名称</span>：<input style="width:120px;" class="filter-box-team filter-box-search js-search" name="good_name" type="text" placeholder="商品名称" />&nbsp;&nbsp;

                        商品分组：
                        <select class="js-search-drp-group" style="margin-top: 5px;margin-left:8px;height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
                            <option value="">全部</option>
                            <?php foreach ($product_groups as $product_group) { ?>
                                <option value="<?php echo $product_group['group_id']; ?>" data-group="<?php echo $product_group['group_name']; ?>"><?php echo $product_group['group_name']; ?></option>
                            <?php } ?>
                        </select>
                        <input style="margin-top:10px;" type="button" class="ui-btn ui-btn-primary js-search-btn" value="搜索">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ui-box">
        <table class="ui-table ui-table-list" style="padding: 0px;">
            <thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
            <?php if (!empty($products)) { ?>
                <tr>
                    <th class="checkbox cell-35" colspan="3">
                        <label class="checkbox inline">
                            <input type="checkbox" class="js-check-all">
                            商品
                        </label>
                    </th>
                    <th class="cell-10" style="min-width: 85px; max-width: 85px;">批发价</th>
                    <th class="cell-10" style="min-width: 85px; max-width: 85px;">建议零售价</th>
                    <th class="cell-10" style="min-width: 85px; max-width: 85px;">利润</th>
                    <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
                        <a href="javascript:;" class="orderby" data-orderby="quantity">库存</a>
                    </th>
                    <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
                        <a href="javascript:;" class="orderby" data-orderby="sales">总销量</a>
                    </th>
                    <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
                        状态
                    </th>
                    <th class="cell-8 text-right" style="min-width: 127px; max-width: 127px;">操作</th>
                </tr>
            <?php } ?>
            </thead>
            <tbody class="js-list-body-region">
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td class="checkbox">
                        <input type="checkbox" class="js-check-toggle" value="<?php echo $product['product_id']; ?>" />
                    </td>
                    <td class="goods-image-td">
                        <div class="goods-image js-goods-image ">
                            <img src="<?php echo $product['image']; ?>" />
                        </div>
                    </td>
                    <td class="goods-meta">
                        <p class="goods-title">
                            <a href="<?php echo $config['wap_site_url']; ?>/good.php?id=<?php echo $product['product_id']; ?>&store_id=<?php echo $product['store_id']?>" target="_blank" class="new-window" title="<?php echo $product['name']; ?>">
                                <?php if (!empty($_POST['keyword'])) { ?>
                                    <?php echo str_replace($_POST['keyword'], '<span class="red">' . $_POST['keyword'] . '</span>', $product['name']); ?>
                                <?php } else { ?>
                                    <?php echo $product['name']; ?>
                                <?php } ?>
                            </a>
                        </p>
                        <p>
                            <span class="goods-price" ><span style="color:#2A2727;">供货商</span>：<?php echo $product['supplier_name']; ?></span>
                        </p>
                        <?php if ($product['is_recommend']) { ?>
                            <i class="platform-tag" style="background-color: #DB2E2E;padding: 0px 2px 0px 3px;">荐</i>
                        <?php } ?>
                        <?php if (!empty($product['wholesale_product_id']) && empty($product['is_fx'])) { ?>
                            <i class="platform-tag" style="background-color: #07d">批发</i>
                        <?php } else if (!empty($product['wholesale_product_id']) && !empty($product['is_fx'])) { ?>
                            <i class="platform-tag">已设分销</i>
                        <?php } ?>
                    </td>
                    <td>
                        <div>￥<?php echo $product['wholesale_price']; ?></div>
                    </td>
                    <td>
                        <span>￥<?php echo $product['sale_min_price']; ?></span>
                        <span>- ￥<?php echo $product['sale_max_price']; ?></span>
                    </td>
                    <td>
                        <span>￥<?php echo number_format($product['sale_min_price'] - $product['wholesale_price'], 2, '.', ''); ?></span>

                        <span>- ￥<?php echo number_format($product['sale_max_price'] - $product['wholesale_price'], 2, '.', ''); ?></span>
                    </td>
                    <td class="text-right"><?php echo $product['quantity']; ?></td>
                    <td class="text-right"><?php echo $product['sales']; ?></td>
                    <td class="text-right">
                        <?php if (empty($product['status'])){?>
                        仓库中
                        <?php } else if ($product['status']==1){?>
                        <span class="red">热销中</span>
                        <?php }?>
                    </td>
                    <td class="text-right">
                        <p>
                            <a href="<?php echo dourl('goods:edit', array('id' => $product['product_id'], 'referer' => 'is_wholesale')); ?>">编辑</a><span>-</span>
                            <?php if($product['status'] == 1 && empty($product['is_fx'])) {?>
                            <a href="<?php echo dourl('goods_fx_setting', array('id' => $product['product_id'])); ?>">设置分销</a>
                            <?php } else if($product['status'] == 0 & empty($product['is_fx'])) {?>
                                <a>设置分销</a>
                            <?php } else {?>
                                已设分销
                            <?php }?>
                        </p>
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
        <?php if (!empty($products) && $is == 2) { ?>
            <div>
                <div class="pull-left">
                    <a href="javascript:;" data-is="<?php echo $is ;?>" class="ui-btn ui-btn js-batch-load">上架</a>
                    <a href="javascript:;" data-is="<?php echo $is ;?>" class="ui-btn js-batch-delete">删除</a>
                </div>
                <div data-is="<?php echo $is ;?>" class="js-page-list ui-box pagenavi"><?php echo $page;?></div>
            </div>
        <?php } else if(!empty($products) && $is == 1) {?>
            <div>
                <div class="pull-left">
                    <a href="javascript:;" data-is="<?php echo $is ;?>" class="ui-btn js-batch-unload">下架</a>
                    <a href="javascript:;" data-is="<?php echo $is ;?>" class="ui-btn js-batch-delete">删除</a>
                </div>
                <div data-is="<?php echo $is ;?>" class="js-page-list ui-box pagenavi"><?php echo $page;?></div>
            </div>
        <?php }?>
    </div>
</div>
