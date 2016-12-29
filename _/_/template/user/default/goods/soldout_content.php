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
        <a class="ui-btn ui-btn-primary" href="<?php dourl('create');?>">发布商品</a>
        <?php if(in_array(PackageConfig::getRbacId(7,'goods','dump'), $rbac_result) || $package_id == 0){?>
             <?php if(!$_SESSION['store']['drp_supplier_id']) {?>
            <!-- <div class="js-list-tag-filter ui-chosen" style="right:210px;">
    			<span style="background-color:#e5e5e5;display:inline-block;">
    				<select id="select_level" style="height: auto;line-height: normal;width: auto;font-size: 12px;font-family: Helvetica,STHeiti,'Microsoft YaHei',Verdana,Arial,Tahoma,sans-serif;">
    					<option value="soldout">导出当前类别商品</option>
    					<option value="all">导出全部商品</option>
    				</select>
    				<input type="button" class="ui-btn ui-btn-primary js-dump-btn" value="商品导出">
    			</span>
            </div> -->
               <?php }?>
        <?php }?>
            
            <!-- <div class="ui-block-head-help soldout-help js-soldout-help hide" style="display: none;">
                <a href="javascript:void(0);" class="js-help-notes" data-class="right"></a>
                <div class="js-notes-cont hide">
                    <p>当商品的所有规格或者某一个规格的库存变为0时，将显示在已售罄的商品列表中</p>
                </div>
            </div> -->
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
                    <label class="checkbox inline"><input type="checkbox" class="js-check-all">商品</label>
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
                    <a href="javascript:;" class="orderby" data-orderby="date_added">创建时间</a></th>
                <th class="cell-8 text-right" style="min-width: 68px; max-width: 68px;">
                    <a href="javascript:;" class="orderby" data-orderby="sort">序号<span class="orderby-arrow desc"></span></a>
                </th>
                <th class="cell-15 text-right" style="min-width: 127px; max-width: 127px;">操作</th>
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
                        </p>
                    </td>
                    <td>
                        <div>PV: <?php echo $product['pv']; ?></div>
                    </td>
                    <td class="text-right"><?php echo $product['quantity']; ?></td>
                    <td class="text-right"><?php echo max($product['sales'], 0); ?></td>
                    <td class=""><?php echo date('Y-m-d', $product['date_added']); ?></td>
                    <td class="text-right">
                        <a class="js-change-num" href="javascript:void(0);"><?php echo $product['sort']; ?></a>
                        <input class="input-mini js-input-num" type="number" min="0" maxlength="8" style="display: none;" data-id="<?php echo $product['product_id']; ?>" value="<?php echo $product['sort']; ?>">
                    </td>
                    <td class="text-right">
                        <p>
                            <a href="<?php echo dourl('edit', array_merge(array('id' => $product['product_id']), $search_arr)); ?>">编辑</a><span>-</span>
                            <a href="javascript:void(0);" class="js-delete" data="<?php echo $product['product_id']; ?>">删除</a>
                           
                        <?php if(in_array(PackageConfig::getRbacId(7,'goods','promotion'), $rbac_result) || $package_id == 0){?>
                            <span>-</span>
                            <a href="javascript:void(0);" class="js-promotion-btn" data="<?php echo $product['product_id']; ?>">推广商品</a>
                        <?php } ?>
                        </p>
                        <p><a href="javascript:;" class="js-copy hover-show">复制</a></p>
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
            <div class="pull-left">
                <a href="javascript:;" class="ui-btn js-batch-tag" data-loading-text="加载...">改分组</a>
                <a href="javascript:;" class="ui-btn ui-btn js-batch-load">上架</a>
                <a href="javascript:;" class="ui-btn js-batch-delete">删除</a>
                <!--<a href="javascript:;" class="ui-btn js-batch-discount">会员折扣</a>-->
            </div>
            <div class="js-page-list ui-box pagenavi"><?php echo $page;?></div>
        </div>
        <?php } ?>
    </div>
</div>					