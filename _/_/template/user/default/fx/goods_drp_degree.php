<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>分销商品设置 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
    <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/goods_create.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
    <style type="text/css">
        body {
            width: auto;
            margin: auto;
        }
        .app__content {
            width: auto;
        }
        .container {
            margin: 0;
        }
        .app {
            float: none;
            width: auto;
        }
        .goods-info-group .info-group-cont {
            border: none;
        }
        .page-content, .app__content {
            min-height: 0;
        }
        .app-inner {
            min-height: 0;
            padding-bottom: 0;
        }
        .form-horizontal.fm-goods-info .control-group {
            margin: 0;
        }
        .goods-info-group .group-inner {
            padding: 5px;
        }
        #stock-region {
            padding: 0px;
        }
        td {
            padding: 5px;
        }
        .bg {
            background-color: #eee;
        }
        .ui-btn {
            display: inline-block;
            border-radius: 2px;
            height: 26px;
            line-height: 26px;
            padding: 0 12px;
            cursor: pointer;
            color: #333;
            background: #f8f8f8;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            -webkit-box-sizing: content-box;
            -moz-box-sizing: content-box;
            box-sizing: content-box;
        }
        .ui-btn-primary {
            color: #fff;
            background: #07d;
            border-color: #006cc9;
        }
        .disabled{
            color: #ffffff;
            background-color: #8db0ce;
            border-color: #82a2bd;
        }
        input[disabled], select[disabled], textarea[disabled], input[readonly], select[readonly], textarea[readonly] {
            cursor: pointer;
            color: #ffffff;
            background-color: #8db0ce;
            border-color: #82a2bd;
        }
    </style>
    <script type="text/javascript">
        var t = '';
        <?php if ($product['unified_price'] == 1) { ?>
        var unified_sale_price = 1;
        <?php } else { ?>
        var unified_sale_price = 0;
        <?php } ?>
        var goods_drp_degree_url = "<?php dourl('goods_drp_degree'); ?>";
        var index = parent.layer.getFrameIndex(window.name);

        $(function() {
            $('.js-btn-cancel').click(function(e) {
                parent.layer.close(index); //执行关闭
            });

            $("input[name='degree_profit']").live('blur', function(e) {
                var degree_profit = $(this).val().trim();
                var degree_name = $(this).data('degree-name');
                var sale_price = parseFloat($('.sale-price').val());
                if (degree_profit == '') {
                    return false;
                }
                if (isNaN(degree_profit)) {
                    layer_tips(1,'分销等级奖励填写有误');
                    $(this).val('');
                    $(this).focus();
                    no_submit();
                    return false;
                }
                degree_profit = parseFloat(degree_profit);

                //下级
                if ($(this).closest('td').prev('td').find("input[name='degree_profit']").length > 0) {
                    var sub_degree_profit = $(this).closest('td').prev('td').find("input[name='degree_profit']").val();
                    var sub_degree_name = $(this).closest('td').prev('td').find("input[name='degree_profit']").data('degree-name');
                    sub_degree_profit = parseFloat(sub_degree_profit);
                    if (degree_profit < sub_degree_profit) {
                        layer_tips(1, degree_name + '分销奖励必须大于或等于' + sub_degree_name + '分销奖励');
                        $(this).val('');
                        $(this).focus();
                        no_submit();
                        return false;
                    }
                }

                //上级
                if ($(this).closest('td').next('td').find("input[name='degree_profit']").length > 0) {
                    var sup_degree_profit = $(this).closest('td').next('td').find("input[name='degree_profit']").val();
                    var sup_degree_name = $(this).closest('td').next('td').find("input[name='degree_profit']").data('degree-name');
                    sup_degree_profit = parseFloat(sup_degree_profit);
                    if (degree_profit > sup_degree_profit) {
                        layer_tips(1, degree_name + '分销奖励必须小于或等于' + sup_degree_name + '分销奖励');
                        $(this).val('');
                        $(this).focus();
                        no_submit();
                        return false;
                    }
                }

                if (unified_sale_price == 1) {
                    var default_profit_total = parseFloat($(this).closest('td').prevAll('td').find("input[name='default_profit']").val());
                    var degree_profit_reward_total = 0;

                    if ($(this).closest('td').prevAll('td').find("input[name='default_profit']").length > 0) {
                        var tmp_profit_percent = 0;
                        var tmp_default_profit = $(this).closest('td').prevAll('td').find("input[name='default_profit']").val();
                        if (tmp_default_profit == '') {
                            tmp_default_profit = 0;
                        } else {
                            tmp_default_profit = parseFloat(tmp_default_profit);
                        }
                        if (tmp_default_profit > 0) {
                            $(this).closest('td').prevAll('td').find("input[name='default_profit']").closest('td').nextAll('td').find("input[name='degree_profit']").each(function(i){
                                tmp_profit_percent += parseFloat($(this).val());
                            });
                            degree_profit_reward_total += tmp_default_profit * (tmp_profit_percent / 100);
                        }
                    }

                    //上级
                    if ($(this).closest('tr').prevAll('tr').find("input[name='default_profit']").length > 0) {
                        $(this).closest('tr').prevAll('tr').find("input[name='default_profit']").each(function(i){
                            if ($(this).val() != '') {
                                default_profit_total += parseFloat($(this).val());
                                var tmp_default_profit = parseFloat($(this).val());
                                if ($(this).closest('td').nextAll('td').find("input[name='degree_profit']").length > 0) {
                                    var tmp_profit_percent = 0;
                                    $(this).closest('td').nextAll('td').find("input[name='degree_profit']").each(function(i){
                                        tmp_profit_percent += parseFloat($(this).val());
                                    });
                                    degree_profit_reward_total += tmp_default_profit * (tmp_profit_percent / 100);
                                }
                            }
                        })
                    }
                    //下级
                    if ($(this).closest('tr').nextAll('tr').find("input[name='default_profit']").length > 0) {
                        $(this).closest('tr').nextAll('tr').find("input[name='default_profit']").each(function(i){
                            if ($(this).val() != '') {
                                default_profit_total += parseFloat($(this).val());
                                var tmp_default_profit = parseFloat($(this).val());
                                if ($(this).closest('td').nextAll('td').find("input[name='degree_profit']").length > 0) {
                                    var tmp_profit_percent = 0;
                                    $(this).closest('td').nextAll('td').find("input[name='degree_profit']").each(function(i){
                                        tmp_profit_percent += parseFloat($(this).val());
                                    });
                                    degree_profit_reward_total += tmp_default_profit * (tmp_profit_percent / 100);
                                }
                            }
                        })
                    }

                    default_profit_total = parseFloat(default_profit_total);
                    default_profit_total += degree_profit_reward_total;
                    if (default_profit_total >= sale_price) {
                        layer_tips(1,'默认等级利润相加必须小于该商品' + sale_price.toFixed(2) + '元销售价');
                        $(this).val('');
                        $(this).focus();
                        no_submit();
                        return false;
                    }
                }

                $(this).val(degree_profit.toFixed(1));
                check_submit();
            });

            $('.js-btn-save').click(function(e) {
                var product_id = parseInt($('.product-id').val());
                var flag = true;
                var degrees_profit = [];
                if ($("input[name='degree_profit']:visible").length > 0) {
                    $("input[name='degree_profit']:visible").each(function(i) {
                        if ($(this).val() == '') {
                            layer_tips(1, '信息填写不完整，请检查');
                            $(this).focus();
                            no_submit();
                            return false;
                        }

                        if (degrees_profit[$(this).data('degree-id')] == undefined) {
                            degrees_profit[$(this).data('degree-id')] = [];
                        }
                        degrees_profit[$(this).data('degree-id')][$(this).data('level')] = parseFloat($(this).val()).toFixed(2);
                    })
                }

                if (flag) {
                    $.post(goods_drp_degree_url, {'product_id': product_id, 'degrees_profit': degrees_profit}, function(data) {
                        if (data.err_code == 0) {
                            $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                        } else {
                            $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                        }
                        t = setTimeout('msg_hide()', 1000);
                    });
                }
            });
        })

        function no_submit() {
            if (!check_submit()) {
                $('.js-btn-save').attr('disabled', true);
                $('.js-btn-save').addClass('disabled');
            }
        }

        function check_submit() {
            if ($("input[type='text'][value='']:visible").length == 0) {
                $('.js-btn-save').attr('disabled', false);
                $('.js-btn-save').removeClass('disabled');
                return true;
            }
            return false;
        }

        function msg_hide() {
            parent.layer.close(index); //执行关闭
            $('.notifications').html('');
            clearTimeout(t);
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="app">
        <div class="app-inner clearfix">
            <div class="app-init-container">
                <div class="app__content js-app-main">
                    <div class="goods-edit-area">
                        <div id="step-content-region">
                            <form class="form-horizontal fm-goods-info">


                                <div id="step-2" class="js-step">

                                    <div id="goods-info-region" class="goods-info-group">

                                        <div id="sku-info-region" class="goods-info-group">
                                            <div class="goods-info-group-inner">

                                                <div class="info-group-cont vbox">

                                                    <div class="group-inner">

                                                        <!-- 统一利润开始 -->
                                                        <div class="js-goods-stock control-group unified-profit-setting">
                                                            <div id="stock-region" class="controls sku-stock" style="margin-left: 0;">
                                                                <div class="unified-profit-1">
                                                                    <div class="cost-price-1">
                                                                        <table class="product-price-setting" width="100%">
                                                                            <?php if (!empty($product) && !empty($drp_degrees)) { ?>
                                                                            <tr class="default-degree">
                                                                                <td class="text-center bg" width="80">分润级别</td>
                                                                                <?php if (!empty($product['unified_price'])) { ?>
                                                                                <td class="text-center bg default-degree">默认等级(元)</td>
                                                                                <?php } else { ?>
                                                                                    <td class="text-center bg default-degree">成本价</td>
                                                                                    <td class="text-center bg default-degree">分销价</td>
                                                                                <?php } ?>
                                                                                <?php if (!empty($drp_degrees)) { ?>
                                                                                    <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                                        <td class="text-center bg"><?php echo $drp_degree['name']; ?>(+%)</td>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                            <tr class="default-degree-1">
                                                                                <td class="text-center bg">一级分润</td>
                                                                                <?php if (!empty($product['unified_price'])) { ?>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_1_profit']; ?>
                                                                                        <input type="hidden" name="default_profit" value="<?php echo $product['drp_level_1_profit']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <?php } else { ?>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_1_cost_price']; ?>
                                                                                        <input type="hidden" name="cost_price" value="<?php echo $product['drp_level_1_cost_price']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_1_price']; ?>
                                                                                        <input type="hidden" name="fx_price" value="<?php echo $product['drp_level_1_price']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <?php } ?>
                                                                                <?php if (!empty($drp_degrees)) { ?>
                                                                                    <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                                        <td class="text-center">
                                                                                            <div class="input-prepend">
                                                                                                <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small" style="width: 80px;" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-level="1" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" value="<?php echo $drp_degree['seller_reward_1']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%
                                                                                            </div>
                                                                                        </td>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                            <tr class="default-degree-2">
                                                                                <td class="text-center bg">二级分润</td>
                                                                                <?php if (!empty($product['unified_price'])) { ?>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_2_profit']; ?>
                                                                                        <input type="hidden" name="default_profit" value="<?php echo $product['drp_level_2_profit']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <?php } else { ?>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_2_cost_price']; ?>
                                                                                        <input type="hidden" name="cost_price" value="<?php echo $product['drp_level_2_cost_price']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_2_price']; ?>
                                                                                        <input type="hidden" name="fx_price" value="<?php echo $product['drp_level_2_price']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <?php } ?>
                                                                                <?php if (!empty($drp_degrees)) { ?>
                                                                                    <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                                        <td class="text-center">
                                                                                            <div class="input-prepend">
                                                                                                <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small" style="width: 80px;" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-level="2" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" value="<?php echo $drp_degree['seller_reward_2']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%</span>
                                                                                            </div>
                                                                                        </td>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                            <tr class="default-degree-3">
                                                                                <td class="text-center bg">三级分润</td>
                                                                                <?php if (!empty($product['unified_price'])) { ?>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_3_profit']; ?>
                                                                                        <input type="hidden" name="default_profit" value="<?php echo $product['drp_level_3_profit']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <?php } else { ?>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_3_cost_price']; ?>
                                                                                        <input type="hidden" name="cost_price" value="<?php echo $product['drp_level_3_cost_price']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="input-prepend">
                                                                                        ￥<?php echo $product['drp_level_3_price']; ?>
                                                                                        <input type="hidden" name="fx_price" value="<?php echo $product['drp_level_3_price']; ?>" />
                                                                                    </div>
                                                                                </td>
                                                                                <?php } ?>
                                                                                <?php if (!empty($drp_degrees)) { ?>
                                                                                    <?php foreach ($drp_degrees as $drp_degree) { ?>
                                                                                        <td class="text-center">
                                                                                            <div class="input-prepend">
                                                                                                <input type="text" maxlength="10" name="degree_profit" class="degree-profit input-small" style="width: 80px;" data-degree="<?php echo $drp_degree['value']; ?>" data-degree-name="<?php echo $drp_degree['name']; ?>" data-level="3" data-degree-id="<?php echo $drp_degree['pigcms_id']; ?>" value="<?php echo $drp_degree['seller_reward_3']; ?>" /><span class="add-on" style="margin-right: 0;margin-left:-1px">%
                                                                                            </div>
                                                                                        </td>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="text-center bg" <?php if (!empty($product['unified_price'])) { ?>colspan="5"<?php } else { ?>colspan="6"<?php } ?>>
                                                                                    <input class="ui-btn ui-btn-primary js-btn-save" type="button" value="保 存" />&nbsp;&nbsp;&nbsp;
                                                                                    <input class="btn js-btn-unload js-btn-cancel" type="button" value="关 闭" />
                                                                                    <input type="hidden" name="product_id" class="product-id" value="<?php echo $product['product_id']; ?>" />
                                                                                </td>
                                                                            </tr>
                                                                            <?php } else { ?>
                                                                            <tr>
                                                                                <td style="color:red;text-align: center">没有数据</td>
                                                                            </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- 统一利润结束 -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="js-notifications notifications"></div>
</body>
</html>