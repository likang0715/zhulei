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

    .account-info .account-info-meta label {
        display: inline;
        color: #999;
        cursor: text;
    }
    .account-info img {
        float: left;
        width: 80px;
        height: 80px;
        margin-right:8px;
    }

    .account-info {
        padding: 20px 20px 20px 20px;
        background: rgba(255,255,255,0.3);
        zoom: 1;
    }
    .account-info .account-info-meta {
        width:25%;
        float:left;
    }

    .account-info .info-item {
        margin-top: 7px;
    }

    .help {
        position: absolute;
        top: -106px;
        right: 14px;
    }
    .widget-head {
        position: relative;
        /*height: 20px;
        padding: 10px;
        padding-bottom: 30px;*/
        line-height: 20px;
        background: rgba(255,255,255,1);
    }

    .help a {
        display: inline-block;
        width: 16px;
        height: 16px;
        line-height: 18px;
        border-radius: 8px;
        font-size: 12px;
        text-align: center;
        background: #D5CD2F;
        color: #fff;
    }
   p{
        margin: 0;
        padding: 0;
        list-style: none;
        font-style: normal;
    }


    .popover-inner {
        padding: 3px;
        width: 280px;
        overflow: hidden;
        background: #000;
        background: rgba(0,0,0,0.8);
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-box-shadow: 0 3px 7px rgba(0,0,0,0.3);
        -moz-box-shadow: 0 3px 7px rgba(0,0,0,0.3);
        box-shadow: 0 3px 7px rgba(0,0,0,0.3);
    }
    .popover-help-notes.bottom:not(.center) .popover-inner, .popover-intro.bottom:not(.center) .popover-inner {
        margin-left: -240px;
    }
    .popover-content {
        padding: 10px;
        background-color: #fff;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding-box;
        background-clip: padding-box;
    }
    .popover-help-notes .popover-inner p, .popover-intro .popover-inner p {
        font-size: 12px;
        line-height: 14px;
        margin-bottom: 5px;
    }

    .help a:after {
        content: "?";
    }
</style>
<?php $uid = $_SESSION['store']['uid'];?>
<div class="goods-list">
<div class="js-list-filter-region clearfix ui-box" style="position: relative;">
    <div class="widget-list-filter">

        <div class="market-filter-container">
            <div class="js-list-tag-filter ui-chosen market-filter">
                <div class="chosen-container chosen-container-single" style="width: 160px!important;" title=""><a
                        class="chosen-single" tabindex="-1"><span>所有类目</span>

                        <div><b></b></div>
                    </a>

                    <div class="chosen-drop">
                        <ul class="chosen-results">
                            <li class="active-result result-selected highlighted" data-option-array-index="0|0">所有类目</li>
                            <?php foreach ($categories as $category) { ?>
                            <li class="active-result" style="" data-option-array-index="<?php echo $category['cat_fid']; ?>|<?php echo $category['cat_id']; ?>"><?php if ($category['cat_level'] > 1) { ?><?php echo str_repeat('&nbsp;&nbsp;&nbsp;', $category['cat_level']) . '|-- ' . $category['cat_name']; ?><?php } else { ?><b><?php echo $category['cat_name'];?></b><?php } ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="js-list-search">
                <input  class="js-keyword txt market-serach-input" type="text" placeholder="商品名称" value="<?php echo $_POST['keyword']; ?>" style="left: 185px!important;">
                <input type="button" class="market-search-btn ui-btn ui-btn-primary" value="搜索" style="left:408px;"/>
            </div>
            <!--<div class="search-result">共找到<?php /*echo $product_total; */?>件商品</div>-->
            <div class="alert" style="float: right;width:auto;margin-left: 20px;">
                <span style="color:#CC1212;" class="text-strong">温馨提示：</span><br>
                白名单商品只有供货商指定的经销商才能批发。<br/>
            </div>
        </div>
    </div>
    <div class="ui-box settlement-info">
        <?php if(!empty($supplier_store_info['is_required_margin'])) {?>
        <h3 style="background: #F2F2F2;height:23px;padding:5px;margin-bottom:2px;">
            <p style="color:orange;">批发本店商品需要批发商审核，并在审核通过后交纳<span style="color:#f00">￥<?php echo $supplier_store_info['bond']?>元</span>保证金方可批发。</p>
        </h3>
        <?php }?>
        <div class="account-info">
            <img class="logo" src="<?php if ($supplier_store_info['logo'] == '' || $supplier_store_info['logo'] == './upload/images/') { ?><?php echo TPL_URL; ?>/upload/images/logo.png<?php } else { ?><?php echo $supplier_store_info['logo']; ?><?php } ?>" />
            <div class="account-info-meta">
                <div class="info-item">
                    <label>供货商：</label>
                    <span><?php echo $supplier_store_info['name']; ?></span>
                    <?php if($supplier_store_info['open_store_whole']==1) {?>
                         <i class="platform-tag" style="background-color: #07d;padding: 0px 2px 0px 3px;">排他批发</i>
                    <?php }?>
                </div>
                <div class="info-item">
                    <label>联系人：</label>
                    <span><?php if (!empty($supplier_store_info['linkman'])) { ?><?php echo $supplier_store_info['linkman']; ?><?php } else { ?>未填写<?php } ?></span>
                </div>
                <div class="info-item">
                    <label>手机号：</label>
                    <span><?php if (!empty($supplier_store_info['tel'])) { ?><?php echo $supplier_store_info['tel']; ?><?php } else { ?>未填写<?php } ?></span>
                </div>

            </div>

            <div class="account-info-meta">
                <div class="info-item">
                    <label>收款账户：</label>
                    <span><?php if (!empty($margin_account['bank_card_user'])) { ?><?php echo $margin_account['bank_card_user']; ?><?php } else { ?>未填写<?php } ?></span>
                </div>
                <div class="info-item">
                    <label>银行卡号：</label>
                    <span><?php if (!empty($margin_account['bank_card'])) { ?><?php echo $margin_account['bank_card']; ?><?php } else { ?>未填写<?php } ?></span>
                </div>
                <div class="info-item">
                    <label>入驻时间：</label>
                    <span><?php echo date('Y-m-d ', $supplier_store_info['date_added']); ?></span>
                </div>
            </div>

            <div class="account-info-meta">

                <div class="info-item">
                    <?php if(!empty($supplier_store_info['is_required_to_audit']) && empty($authen) && empty($is_authen)) {?>
                        <?php if($is_open_store_whole && !empty($supplier_store_info['open_store_whole'])){?>
                            <span class="js-own-product" style="cursor: help;">
                             <a>提交审核资料</a>
                            </span>
                        <?php } else {?>
                            <span><a target="_blank" href="<?php dourl('store:certification'); ?>&store_id=<?php echo $store_id;?>">提交审核资料</a></span>
                        <?php }?>
                    <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && !empty($authen) && empty($is_authen)) {?>
                        <span><a>资料正在审核中</a></span>
                    <?php } else if(!empty($supplier_store_info['is_required_to_audit']) && !empty($authen) && !empty($is_authen)) {?>
                        <span><a>通过审核</a></span>
                    <?php } else if(!empty($supplier_store_info['is_required_to_audit']) && empty($authen) && !empty($is_authen)) {?>
                        <span><a>通过审核</a></span>
                    <?php }?>
                </div>
                <div class="info-item">
                    <?php if(!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && empty($is_authen)) {?>
                        <span><a style="cursor: no-drop;color: #bbb;">我要充值</a></span>
                    <?php } else if (empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin'])){?>
                        <span><a href="<?php dourl('recharge');?>&store_id=<?php echo $store_id;?>">我要充值</a></span>
                    <?php } else if(!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && !empty($is_authen)) {?>
                        <span><a href="<?php dourl('recharge');?>&store_id=<?php echo $store_id;?>">我要充值</a></span>
                    <?php }?>
                </div>
                <div class="info-item">
                    <?php if(!empty($supplier_store_info['is_required_margin'])) {?>

                        <label>我的账户余额：</label>
                        <span style="color:red;"><?php echo empty($bond['bond']) ? '0.00' : $bond['bond'];?></span>
                        <a target="_blank" href="<?php echo dourl('bond_record');?>&store_id=<?php echo $supplier_store_info['store_id'];?>">消费记录</a>

                    <?php } ?>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div class="widget-head">
        <div class="help">
            <a href="javascript:void(0);" class="js-help-notes"></a>
            <div class="js-notes-cont hide">
                <p>批发本店商品需要提交审核资料,供货商审核通过方可批发</p>
                <p>批发本店商品需要提前向供货商交纳保证金,额度由供货商订</p>
            </div>
        </div>
        </div>
        <div style="clear:both"></div>
        <h4 style="background: #F2F2F2;height:30px;padding:5px;margin-bottom:2px;">
            店铺简介：<?php echo $supplier_store_info['intro']; ?>
        </h4>
    </div>
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
    <th class="cell-10 text-right"><a href="javascript:;" data-orderby="fx_count">人气</a></th>
    <th class="cell-15 text-right">操作</th>
</tr>
</thead>
<tbody class="js-list-body-region">
<?php foreach($products as $product) { ?>
<tr class="widget-list-item">
    <td class="checkbox">
        <?php if($product['uid'] == $uid || in_array($product['product_id'], $wholesale_products)) {?>
        <?php } else {?>
            <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                <input type="checkbox" class="js-check-toggle" <?php if (in_array($product['product_id'], $fx_products)) { ?>disabled="true" <?php } ?> value="<?php echo $product['product_id']; ?>" />
            <?php } else if(empty($product['is_whitelist'])) {?>
                <input type="checkbox" class="js-check-toggle" <?php if (in_array($product['product_id'], $fx_products)) { ?>disabled="true" <?php } ?> value="<?php echo $product['product_id']; ?>" />
            <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>

            <?php }?>
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
            <i class="platform-tag" style="background-color: #DB2E2E">荐</i>
        <?php } ?>
        <?php if(!empty($product['is_whitelist'])) {?>
            <i class="platform-tag" style="background-color: green">白名单</i>
        <?php }?>
    </td>
    <?php if($type == 'wholesale') {?>
        <td class="text-right">
            <p>￥<?php echo $product['wholesale_price']; ?></p>
        </td>
        <td class="text-right">
            <p>￥<?php echo $product['sale_min_price']; ?></p>
            <p>- ￥<?php echo $product['sale_max_price']; ?></p>
        </td>
    <?php } else if($type == 'fx') { ?>
         <td class="text-right">
            <p>￥<?php echo $product['cost_price']; ?></p>
        </td>
        <td class="text-right">
            <p>￥<?php echo $product['min_fx_price']; ?></p>
            <p>- ￥<?php echo $product['max_fx_price']; ?></p>
        </td>
    <?php }?>
    <?php if($type == 'wholesale') {?>
    <td class="text-right">
        <p>￥<?php echo number_format($product['sale_min_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>

        <p>- ￥<?php echo number_format($product['sale_max_price'] - $product['wholesale_price'], 2, '.', ''); ?></p>
    </td>
    <?php } else if($type == 'fx'){?>
     <td class="text-right">
        <p>￥<?php echo number_format($product['min_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>

        <p>- ￥<?php echo number_format($product['max_fx_price'] - $product['cost_price'], 2, '.', ''); ?></p>
    </td>
    <?php }?>
   
    <td class="text-right">
        <p><?php echo $product['quantity']; ?></p>
    </td>
    <td class="text-right">
        <?php echo max($product['sales'],0); ?>
    </td>
    <td class="text-right">
        <?php echo $product['pv']; ?>
    </td>
    <td class="text-right">
        <p class="js-opts">
            <?php if (in_array($product['product_id'], $wholesale_products)) { ?>
                已添加
            <?php } else { ?>
                <?php if(!empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin']) && empty($is_authen)) {?>
                    <a>等待审核通过</a>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin']) && !empty($is_authen)){?>
                    <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                        <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                    <?php } else if(empty($product['is_whitelist'])) {?>
                        <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                    <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>
                        <a style="color:#999" href="javascript:;">添加到店铺</a>
                    <?php }?>
                <?php } else if(!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && empty($is_authen)) {?>
                    <a>等待审核通过</a>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && !empty($is_authen) && $bond['bond'] == 0){?>
                   <a href="<?php dourl('recharge');?>&store_id=<?php echo $store_id;?>">请先充值</a>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && !empty($is_authen) && $bond['bond'] > 0) {?>
                    <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                        <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                    <?php } else if(empty($product['is_whitelist'])) {?>
                        <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                    <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>
                        <a style="color:#999" href="javascript:;">添加到店铺</a>
                    <?php }?>
                <?php } else if(empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin'])) { ?>
                    <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                        <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                    <?php } else if(empty($product['is_whitelist'])) {?>
                        <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                    <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>
                        <a style="color:#999" href="javascript:;">添加到店铺</a>
                    <?php }?>
                <?php } else if(empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && $bond['bond'] > 0) {?>
                    <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                        <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                    <?php } else if(empty($product['is_whitelist'])) {?>
                        <a href="javascript:;" data-id="<?php echo $product['product_id']; ?>" data-type="<?php echo $type; ?>" class="js-add-to-shop">添加到店铺</a>
                    <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>
                        <a style="color:#999" href="javascript:;">添加到店铺</a>
                    <?php }?>
                <?php } else if (empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && $bond['bond'] == 0) {?>
                    <a href="<?php dourl('recharge');?>&store_id=<?php echo $store_id;?>">请先充值</a>
                <?php }?>
            <?php }?>
        </p>
    </td>
</tr>
<?php } ?>
</tbody>
<?php } ?>
</table>
    <div class="js-list-empty-region">
        <?php if (empty($products)) { ?>
        <div>
            <div class="no-result widget-list-empty">还没有相关数据。</div>
        </div>
        <?php } ?>
    </div>
</div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($products)) { ?>
            <div class="widget-list-footer">
                <?php if(!empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin']) && empty($is_authen)) {?>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin']) && !empty($is_authen)){?>
                    <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                        <div class="pull-left">
                            <a href="javascript:;" data-type="<?php echo $type; ?>" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
                        </div>
                    <?php } else if(empty($product['is_whitelist'])) {?>
                        <div class="pull-left">
                            <a href="javascript:;" data-type="<?php echo $type; ?>" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
                        </div>
                    <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>

                    <?php }?>
                <?php } else if(!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && empty($is_authen)) {?>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && !empty($is_authen) && $bond['bond'] == 0){?>
                <?php } else if (!empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && !empty($is_authen) && $bond['bond'] > 0) {?>
                    <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                        <div class="pull-left">
                            <a href="javascript:;" data-type="<?php echo $type; ?>" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
                        </div>
                    <?php } else if(empty($product['is_whitelist'])) {?>
                        <div class="pull-left">
                            <a href="javascript:;" data-type="<?php echo $type; ?>" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
                        </div>
                    <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>
                    <?php }?>
                <?php } else if(empty($supplier_store_info['is_required_to_audit']) && empty($supplier_store_info['is_required_margin'])) { ?>
                    <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                        <div class="pull-left">
                            <a href="javascript:;" data-type="<?php echo $type; ?>" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
                        </div>
                    <?php } else if(empty($product['is_whitelist'])) {?>
                        <div class="pull-left">
                            <a href="javascript:;" data-type="<?php echo $type; ?>" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
                        </div>
                    <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>

                    <?php }?>
                <?php } else if(empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && $bond['bond'] > 0) {?>
                    <?php if($product['is_whitelist'] && in_array($product['product_id'],$whilelists)) {?>
                        <div class="pull-left">
                            <a href="javascript:;" data-type="<?php echo $type; ?>" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
                        </div>
                    <?php } else if(empty($product['is_whitelist'])) {?>
                        <div class="pull-left">
                            <a href="javascript:;" data-type="<?php echo $type; ?>" class="ui-btn js-batch-add-to-shop">批量添加到店铺</a>
                        </div>
                    <?php } else if($product['is_whitelist'] && !in_array($product['product_id'],$whilelists)){?>

                    <?php }?>
                <?php } else if (empty($supplier_store_info['is_required_to_audit']) && !empty($supplier_store_info['is_required_margin']) && $bond['bond'] == 0) {?>
                <?php }?>
                <input type="hidden" data-store="<?php echo $store_id;?>" class="store_id">
                <div class="pagenavi"><?php echo $page; ?></div>
            </div>
        <?php } ?>
    </div>
<script type="text/javascript">
    var t= '';
    $(function(){
        $('.js-help-notes').hover(function(){
            $('.popover-help-notes').remove();
            var help_content = $('.js-notes-cont').html();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 20) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">' + help_content + '</div></div></div>';
            $('body').append(html);
            $('.popover-help-notes').show();
        }, function(){
            t = setTimeout('hide()', 200);
        })

        $('.popover-help-notes').live('mouseleave', function(){
            clearTimeout(t);
            hide();
        })

        $('.popover-help-notes').live('mouseover', function(){
            clearTimeout(t);
        })

    })

    function hide() {
        $('.popover-help-notes').remove();
    }

    $('.js-own-product').hover(function(){
        var content = $(this).next('.js-notes-cont').html();
        $('.popover-help-notes').remove();
        var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="font-size: xx-small;display: none; top: ' + ($(this).offset().top + 16) + 'px; left: ' + 859 +'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">您已成为其他供货商的批发商，不可申请成为排他批发的批发商</div></div></div>';
        $('body').append(html);
        $('.popover-help-notes').show();
    }, function(){
        t2 = setTimeout('hide2()', 200);
    });

</script>
</div>