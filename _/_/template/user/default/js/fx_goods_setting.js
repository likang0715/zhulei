var unified_sale_price = 1;
$(function(){

    load_page('.app__content',load_url,{page:'goods_fx_setting_content', 'id': product_id},'',function(){
        $('#unified-profit .setting-price-method:eq(1)').trigger('click');
    });

    $('#unified-profit .setting-price-method').live('click',function(){
        var profit = $(this).children('a').data("profit");
        var sku_content = $(".sku_content").val();  //是否存在库存  1 有
        $(this).addClass('active').siblings().removeClass('active').end();

        if(profit == 1) {
            unified_sale_price = 1;
            $('.unified-profit-setting').show();
            $('.goods-fx-setting').hide();
            $(".unified-profit-1").show();
            $(".unified-profit-2").hide();
            $("#unified-profit-3").hide();
            $(".hidden-data-profit").val(profit);
        } else if(profit == 2){
            unified_sale_price = 0;
            $('.unified-profit-setting').hide();
            $('.goods-fx-setting').show();
            $(".unified-profit-2").show();
            $(".unified-profit-1").hide();
            if(sku_content == 1){
                $("#unified-profit-3").show();
            }else if(sku_content == 0){
                $("#unified-profit-3").show();
            }
            $(".hidden-data-profit").val(profit);
        }
        no_submit();
    });

    //成本价
    var fx_sku_price_arr_1 = [];
    var fx_sku_price_arr_2 = [];
    var fx_sku_price_arr_3 = [];
    $(".table-sku-stock-1 > tbody > .sku input[name='cost_sku_price']").live('blur', function(){
        if ($(this).val() == '') {
            return false;
        }
        var fx_sku_price = parseFloat($(this).val());
        if(isNaN(fx_sku_price)){
            layer_tips(1, '请正确填写成本价');
            $(this).val('');
            $(this).eq(i).focus();
            no_submit();
            return false;
        }

        var i = 0;
        //取同等级中最低的成本为商品成本
        $(".table-sku-stock-1").find("input[name='cost_sku_price']").each(function() {
            if ($(this).val() != '' && parseFloat($(this).val()) > 0) {
                fx_sku_price_arr_1[i] = parseFloat($(this).val());
                i++;
            }
        })
        $(".cost-price-1").val(Math.min.apply(null, fx_sku_price_arr_1).toFixed(2));

        var fx_cost = parseFloat($(this).val());
        var fx_price = parseFloat($(this).parent('td').next("td").find("input[name='sku_price']").val());
        if(fx_price < fx_cost){
            layer_tips(1, '分销价必须大于成本价');
            $(this).focus();
            $(this).val('');
            no_submit();
            return false;
        }
        $(this).val(fx_cost.toFixed(2));
        check_submit();
    })

    $(".table-sku-stock-2 > tbody > .sku input[name='cost_sku_price']").live('blur', function(){
        if ($(this).val() == '') {
            return false;
        }
        var fx_sku_price = parseFloat($(this).val());
        if(isNaN(fx_sku_price)){
            layer_tips(1, '请正确填写成本价');
            $(this).eq(i).focus();
            $(this).eq(i).val('');
            no_submit();
            return false;
        }
        var i = 0;
        //取同等级中最低的成本为商品成本
        $(".table-sku-stock-2").find("input[name='cost_sku_price']").each(function() {
            if ($(this).val() != '' && parseFloat($(this).val()) > 0) {
                fx_sku_price_arr_2[i] = parseFloat($(this).val());
                i++;
            }
        })
        $(".cost-price-2").val(Math.min.apply(null, fx_sku_price_arr_2).toFixed(2));

        var fx_cost = parseFloat($(this).val());
        var fx_price = parseFloat($(this).parent('td').next("td").find("input[name='sku_price']").val());
        if(fx_price < fx_cost){
            layer_tips(1, '分销价必须大于成本价');
            $(this).focus();
            $(this).val('');
            no_submit();
            return false;
        }
        $(this).val(fx_cost.toFixed(2));
        check_submit();
    })

    $(".table-sku-stock-3 > tbody > .sku input[name='cost_sku_price']").live('blur', function(){
        if ($(this).val() == '') {
            return false;
        }
        var fx_sku_price = parseFloat($(this).val());
        if(isNaN(fx_sku_price)){
            layer_tips(1, '请正确填写成本价');
            $(this).eq(i).focus();
            $(this).eq(i).val('');
            no_submit();
            return false;
        }

        var i = 0;
        //取同等级中最低的成本为商品成本
        $(".table-sku-stock-3").find("input[name='cost_sku_price']").each(function() {
            if ($(this).val() != '' && parseFloat($(this).val()) > 0) {
                fx_sku_price_arr_3[i] = parseFloat($(this).val());
                i++;
            }
        })
        $(".cost-price-3").val(Math.min.apply(null, fx_sku_price_arr_3).toFixed(2));

        var fx_cost = parseFloat($(this).val());
        var fx_price = parseFloat($(this).parent('td').next("td").find("input[name='sku_price']").val());
        if(fx_price < fx_cost){
            layer_tips(1, '分销价必须大于成本价');
            $(this).focus();
            $(this).val('');
            no_submit();
            return false;
        }
        $(this).val(fx_cost.toFixed(2));
        check_submit();
    })

    //分销价
    var js_fx_price_arr_1 = [];
    var js_fx_price_arr_2 = [];
    var js_fx_price_arr_3 = [];
    $(".table-sku-stock-1 > tbody > .sku input[name='sku_price']").live('blur', function(){
        if ($(this).val() == '') {
            return false;
        }
        var js_fx_price = parseFloat($(this).val());
        if(isNaN(js_fx_price)){
            layer_tips(1, '请正确填写成本价');
            $(this).val('');
            $(this).focus();
            no_submit();
            return false;
        }

        var i = 0;
        //取同等级中最低的售价为商品售价
        $(".table-sku-stock-1").find("input[name='sku_price']").each(function() {
            if ($(this).val() != '' && parseFloat($(this).val()) > 0) {
                js_fx_price_arr_1[i] = parseFloat($(this).val());
                i++;
            }
        })
        $(".fx-price-1").val(Math.min.apply(null, js_fx_price_arr_1).toFixed(2));

        var fx_price = parseFloat($(this).val());
        var fx_cost = parseFloat($(this).parent('td').prev("td").find("input[name='cost_sku_price']").val());
        if(fx_price < fx_cost){
            layer_tips(1, '分销价必须大于成本价');
            $(this).val('');
            $(this).focus();
            no_submit();
            return false;
        }
        $(this).val(fx_price.toFixed(2));
        check_submit();
    })

    $(".table-sku-stock-2 > tbody > .sku input[name='sku_price']").live('blur', function(){
        if ($(this).val() == '') {
            return false;
        }
        var js_fx_price = ($(this).val());
        if(isNaN(js_fx_price)){
            layer_tips(1, '请正确填写分销价');
            $(this).val('');
            $(this).eq(i).focus();
            no_submit();
            return false;
        }

        var i = 0;
        //取同等级中最低的售价为商品售价
        $(".table-sku-stock-2").find("input[name='sku_price']").each(function() {
            if ($(this).val() != '' && parseFloat($(this).val()) > 0) {
                js_fx_price_arr_2[i] = parseFloat($(this).val());
                i++;
            }
        })
        $(".fx-price-2").val(Math.min.apply(null, js_fx_price_arr_2).toFixed(2));

        var fx_price = parseFloat($(this).val());
        var fx_cost = parseFloat($(this).parent('td').prev("td").find("input[name='cost_sku_price']").val());
        if(fx_price < fx_cost){
            layer_tips(1, '分销价必须大于成本价');
            $(this).val('');
            $(this).focus();
            no_submit();
            return false;
        }
        $(this).val(fx_price.toFixed(2));
        check_submit();
    })

    $(".table-sku-stock-3 > tbody > .sku input[name='sku_price']").live('blur', function(){
        if ($(this).val() == '') {
            return false;
        }
        var js_fx_price = ($(this).val());
        if(isNaN(js_fx_price)){
            layer_tips(1, '请正确填写分销价');
            $(this).val('');
            $(this).focus();
            no_submit();
            return false;
        }

        var i = 0;
        //取同等级中最低的售价为商品售价
        $(".table-sku-stock-3").find("input[name='sku_price']").each(function() {
            if ($(this).val() != '' && parseFloat($(this).val()) > 0) {
                js_fx_price_arr_3[i] = parseFloat($(this).val());
                i++
            }
        })
        $(".fx-price-3").val(Math.min.apply(null, js_fx_price_arr_3).toFixed(2));

        var fx_price = parseFloat($(this).val());
        var fx_cost = parseFloat($(this).parent('td').prev("td").find("input[name='cost_sku_price']").val());
        if(fx_price < fx_cost){
            layer_tips(1, '分销价必须大于成本价');
            $(this).val('');
            $(this).focus();
            no_submit();
            return false;
        }
        $(this).val(fx_price.toFixed(2));
        check_submit();
    })


    //批量设置
    var js_batch_type2 = '';
    $('.js-batch-cost2').live('click', function() {
        js_batch_type2 = 'cost';
        $(this).parent('span').next('.js-batch-form2').html('<input type="text" class="fx-cost-price input-mini" placeholder="成本价" /> <a class="js-batch-save2" href="javascript:;">保存</a> <a class="js-batch-cancel2" href="javascript:;">取消</a><p class="help-desc"></p>');
        $(this).parent('span').next('.js-batch-form2').show();
        $(this).parent('span').hide();
    })

    $('.js-batch-price2').live('click',function(){
        js_batch_type2 = 'price';
        $(this).parent('span').next('.js-batch-form2').html('<input type="text" class="fx-price input-mini" placeholder="分销价" /> <a class="js-batch-save2" href="javascript:;">保存</a> <a class="js-batch-cancel2" href="javascript:;">取消</a><p class="help-desc"></p>');
        $(this).parent('span').next('.js-batch-form2').show();
        $(this).parent('span').hide();
    });

    $('.js-batch-save2').live('click', function() {
        var level = $(this).closest('table').data('level'); //分销商等级
        $(this).closest('td').removeClass('manual-valid-error');
        $('.help-desc').next('.error-message').remove();
        if (js_batch_type2 == 'price') {
            var cost_price = $(this).closest('.js-batch-form2').prev('.js-batch-type2').children('.js-batch-cost2').data('batch-cost-price');
            var fx_price = $.trim($(this).prev('.fx-price').val());
            if (fx_price == '' || fx_price == 0) {
                return false;
            } else if (parseFloat(fx_price) < 0 || !/^\d+(\.\d+)?$/.test(fx_price)) {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">分销价只能填写大于零数字</div>');
                return false;
            } else if (cost_price != undefined && parseFloat(fx_price) < parseFloat(cost_price)) { //分销价低于成本价
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">分销价不能低于成本价</div>');
                return false;
            }
            fx_price = parseFloat(fx_price);
            $(this).closest('table').find('.js-price').val(fx_price.toFixed(2));
            $('.fx-price-' + level).val(fx_price.toFixed(2));
            $(this).parent('.js-batch-form2').prev('.js-batch-type2').children('.js-batch-price2').attr('data-batch-price', fx_price.toFixed(2));
        } else if (js_batch_type2 == 'cost') {
            var fx_price = $(this).closest('.js-batch-form2').prev('.js-batch-type2').children('.js-batch-price2').data('batch-price');
            var cost_price = parseFloat($.trim($(this).prev('.fx-cost-price').val()));
            if (cost_price == '' || cost_price == 0) {
                return false;
            } else if (parseFloat(cost_price) < 0 || !/^\d+(\.\d+)?$/.test(cost_price)) {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">成本价只能填写大于零数字</div>');
                return false;
            } else if (fx_price != undefined && cost_price > parseFloat(fx_price)) {
                $(this).closest('td').addClass('manual-valid-error');
                $('.help-desc').after('<div class="error-message" style="margin-left: 60px">成本价不能高于分销价</div>');
                return false;
            }
            $('.cost-price-' + level).val(cost_price.toFixed(2));
            $(this).closest('table').find('.js-cost-price').val(cost_price.toFixed(2));
            $(this).parent('.js-batch-form2').prev('.js-batch-type2').children('.js-batch-cost2').attr('data-batch-cost-price', cost_price.toFixed(2));
        }
        $(this).parent('.js-batch-form2').hide();
        $(this).parent('.js-batch-form2').prev('.js-batch-type2').show();
        $(this).parent('.js-batch-form2').html('');
        check_submit();
    })

    $('.js-batch-cancel2').live('click', function() {
        $(this).closest('td').removeClass('manual-valid-error');
        $(this).next('.help-desc').next('.error-message').remove();
        $(this).parent('.js-batch-form2').hide();
        $(this).parent('.js-batch-form2').prev('.js-batch-type2').show();
        $(this).parent('.js-batch-form2').html('');
        check_submit();
    })

    $('.js-btn-save').live('click', function(){
        var hidden_data_profit = $('.hidden-data-profit').val();
        if(hidden_data_profit == 1) {
            var profit_1 = parseFloat($(".profit-price_1").val()); //一级利润
            var profit_2 = parseFloat($(".profit-price_2").val()); //二级利润
            var profit_3 = parseFloat($(".profit-price_3").val()); //三级利润

            var product_cost = parseFloat($('.sale-price').val());  //分销价
            var sku_content = $(".sku_content").val();  //是否存在库存  1 有
            var wholesale_product = $(".wholesale_product").val();  //是否是批发商品 1 是

            if (wholesale_product == 1) {
                var wholesale_product_price = parseFloat($(".wholesale_price").val());  //商品的批发价格
            }

            if (wholesale_product == 0) {//自营商品
                if (isNaN($(".profit-price_1").val()) || $(".profit-price_1").val() == '' || $(".profit-price_1").val() == undefined || parseFloat($(".profit-price_1").val()) <= 0) {
                    layer_tips(1, '请填写各级分销商利润');
                    $('.profit-price_1').focus();
                    $('.profit-price_1').val('');
                    no_submit();
                    return false;
                }
                if (isNaN($(".profit-price_2").val()) || $(".profit-price_2").val() == '' || $(".profit-price_2").val() == undefined || parseFloat($(".profit-price_2").val()) <= 0) {
                    layer_tips(1, '请填写各级分销商利润');
                    $('.profit-price_2').focus();
                    $('.profit-price_2').val('');
                    no_submit();
                    return false;
                }
                if (isNaN($(".profit-price_3").val()) || $(".profit-price_3").val() == '' || $(".profit-price_3").val() == undefined || parseFloat($(".profit-price_3").val()) <= 0) {
                    layer_tips(1, '请填写各级分销商利润');
                    $('.profit-price_3').focus();
                    $('.profit-price_3').val('');
                    no_submit();
                    return false;
                }

                /*if (profit_1 * 3 >= product_cost * 0.91) {
                    layer_tips(1, '一级分销的利润不能大于分销价的90%。');
                    $('.profit-price_1').focus();
                    $('.profit-price_1').val('');
                    no_submit();
                    return false;
                }
                if (profit_1 < profit_2) {
                    layer_tips(1, '二级分销的利润不能大于一级分销的利润。');
                    $('.profit-price_2').focus();
                    $('.profit-price_2').val('');
                    no_submit();
                    return false;
                }
                if (profit_2 < profit_3) {
                    layer_tips(1, '三级分销的利润不能大于二级分销的利润。');
                    $('.profit-price_3').focus();
                    $('.profit-price_3').val('');
                    no_submit();
                    return false;
                }*/
            } else if (wholesale_product == 1) {//批发商品
                var product_cost_price = product_cost - wholesale_product_price;
                if (isNaN($(".profit-price_1").val()) || $(".profit-price_1").val() == '' || $(".profit-price_1").val() == undefined || parseFloat($(".profit-price_1").val()) <= 0) {
                    layer_tips(1, '请填写一级分销商利润');
                    $('.profit-price_1').focus();
                    $('.profit-price_1').val('');
                    no_submit();
                    return false;
                }

                if (isNaN($(".profit-price_2").val()) || $(".profit-price_2").val() == '' || $(".profit-price_2").val() == undefined || parseFloat($(".profit-price_2").val()) <= 0) {
                    layer_tips(1, '请填写二级分销商利润');
                    $('.profit-price_2').focus();
                    $('.profit-price_2').val('');
                    no_submit();
                    return false;
                }

               if (isNaN($(".profit-price_3").val()) || $(".profit-price_3").val() == '' || $(".profit-price_3").val() == undefined || parseFloat($(".profit-price_3").val()) <= 0) {
                    layer_tips(1, '请填写三级分销商利润');
                    $('.profit-price_3').focus();
                    $('.profit-price_3').val('');
                    no_submit();
                    return false;
                }
            }
            var cost_price_3 = product_cost - profit_1; //三级分销商成本
            var cost_price_2 = product_cost - profit_2; //二级分销商成本
            var cost_price_1 = product_cost - profit_3; //一级分销商成本
            //根据设置的利润算出此商品的成本价和分销价 && 如果有商品属

            if (sku_content == 1) {
                var hidden_cost_sku_price_1 = [];
                var hidden_cost_sku_price_2 = [];
                var hidden_cost_sku_price_3 = [];
                var cost_price_sku_1 = [];
                var cost_price_sku_2 = [];
                var cost_price_sku_3 = [];
                var price_sku_1 = [];
                var price_sku_2 = [];
                var price_sku_3 = [];
                $(".table-sku-stock-1 > tbody > .sku input[name='cost_sku_price']").each(function (i) {
                    var hidden_cost_sku_price = parseFloat($(".hidden_cost_sku_price").eq(i).val());//商品售价
                    hidden_cost_sku_price_1[i] = [hidden_cost_sku_price];
                    if (unified_sale_price) {
                        $(this).val((hidden_cost_sku_price - (profit_1 + profit_2 + profit_3)).toFixed(2));
                        $(".table-sku-stock-1 > tbody > .sku input[name='sku_price']").eq(i).val(hidden_cost_sku_price.toFixed(2));
                    }
                    //$(".cost-price-1").val((Math.min.apply(null, hidden_cost_sku_price_1) - (profit_1 + profit_2 + profit_3)).toFixed(2)); //成本
                    cost_price_sku_1[i] = $(this).val();
                    price_sku_1[i] = hidden_cost_sku_price;
                });
                $(".table-sku-stock-2 > tbody > .sku input[name='cost_sku_price']").each(function (i) {
                    var hidden_cost_sku_price = parseFloat($(".hidden_cost_sku_price").eq(i).val());
                    hidden_cost_sku_price_2[i] = [hidden_cost_sku_price];
                    if (unified_sale_price) {
                        $(this).val((hidden_cost_sku_price - (profit_2 + profit_3)).toFixed(2));
                        $(".table-sku-stock-2 > tbody > .sku input[name='sku_price']").eq(i).val(hidden_cost_sku_price.toFixed(2));
                    }
                    //$(".cost-price-2").val((Math.min.apply(null, hidden_cost_sku_price_2) - (profit_1+profit_3)).toFixed(2)); //成本
                    cost_price_sku_2[i] = $(this).val();
                    price_sku_2[i] = hidden_cost_sku_price;
                });
                $(".table-sku-stock-3 > tbody > .sku input[name='cost_sku_price']").each(function (i) {
                    var hidden_cost_sku_price = parseFloat($(".hidden_cost_sku_price").eq(i).val());
                    hidden_cost_sku_price_3[i] = [hidden_cost_sku_price];
                    if (unified_sale_price) {
                        $(this).val((hidden_cost_sku_price - (profit_3)).toFixed(2));
                        $(".table-sku-stock-3 > tbody > .sku input[name='sku_price']").eq(i).val(hidden_cost_sku_price.toFixed(2));
                    }
                    //$(".cost-price-3").val((Math.min.apply(null, hidden_cost_sku_price_3) - profit_3).toFixed(2)); //成本
                    cost_price_sku_3[i] = $(this).val();
                    price_sku_3[i] = hidden_cost_sku_price;
                });

                var tmp_profits = [profit_3, profit_2, profit_1];
                var tmp_cost_price = [];
                i = 0;
                //利润转成本(统一利润)
                var _profit2cost = function(i, price) {
                    if (tmp_profits[i] == undefined) {
                        return;
                    }
                    price -= tmp_profits[i];
                    tmp_cost_price[i] = price;
                    i++;
                    _profit2cost(i, price);
                };
                _profit2cost(0, product_cost);
                tmp_cost_price = tmp_cost_price.reverse();
                $(".cost-price-1").val(Math.min.apply(null, cost_price_sku_1).toFixed(2));
                $(".cost-price-2").val(Math.min.apply(null, cost_price_sku_2).toFixed(2));
                $(".cost-price-3").val(Math.min.apply(null, cost_price_sku_3).toFixed(2));
                if (unified_sale_price) {
                    $(".fx-price-1").val(Math.min.apply(null, price_sku_1).toFixed(2));
                    $(".fx-price-2").val(Math.min.apply(null, price_sku_1).toFixed(2));
                    $(".fx-price-3").val(Math.min.apply(null, price_sku_1).toFixed(2));
                }
            } else { //没有商品属性

                var tmp_profits = [profit_3, profit_2, profit_1];
                var tmp_cost_price = [];
                i = 0;
                //利润转成本(统一利润)
                var _profit2cost = function(i, price) {
                    if (tmp_profits[i] == undefined) {
                        return;
                    }
                    price -= tmp_profits[i];
                    tmp_cost_price[i] = price;
                    i++;
                    _profit2cost(i, price);
                };
                _profit2cost(0, product_cost);
                tmp_cost_price = tmp_cost_price.reverse();
                if (unified_sale_price) {
                    $(".cost-price-1").val(tmp_cost_price[0].toFixed(2));
                    $(".cost-price-2").val(tmp_cost_price[1].toFixed(2));
                    $(".cost-price-3").val(tmp_cost_price[2].toFixed(2));
                }
                $(".fx-price-1").val(product_cost.toFixed(2));
                $(".fx-price-2").val(product_cost.toFixed(2));
                $(".fx-price-3").val(product_cost.toFixed(2));

            }
        }


            $('td').removeClass('manual-valid-error');
            $('.error-message').remove();
            var unified_price_setting = 1; // 供货商统一定价
            var sku_content = $(".sku_content").val();  //是否存在库存  1 有
            var wholesale_product = $(".wholesale_product").val();  //是否是批发商品 1 是
            var cost_sku_price_1 = []; //一级成本价
            var cost_sku_price_2 = []; //二级成本价
            var cost_sku_price_3 = []; //三级成本价

            var sku_price_1 = [];      //一级分销价
            var sku_price_2 = [];      //二级分销价
            var sku_price_3 = [];      //三级分销价
            var flag_1 = true;
            var flag_2 = true;
            var flag_3 = true;
            var flag_4 = true;
            var flag_whole_price = true;
            if (wholesale_product == 1) {
                var wholesale_product_price = parseFloat($(".wholesale_price").val());  //商品的批发价格

                $(".table-sku-stock-1 > tbody > .sku input[name='cost_sku_price']").each(function (i) {
                    if (parseFloat($(this).val()) < wholesale_product_price) {
                        layer_tips(1, '一级分销商的成本必须大于等于商品的批发成本');
                        $($(this).eq(i)).focus();
                        $($(this).eq(i)).val('');
                        no_submit();
                        flag_whole_price = false;
                    }
                });
                if(!flag_whole_price) {
                    return false;
                }
            }
            if (unified_price_setting == 1) {
                if (sku_content == 1) {
                    $('.js-fx-price:visible').each(function (i) {
                        if (isNaN($(this).val()) || $(this).val() == '' || $(this).val() == undefined || parseFloat($(this).val()) <= 0) {
                            layer_tips(1, '请填写合法的分销价');
                            $(this).focus();
                            $(this).val('');
                            no_submit();
                            flag_1 = false;
                        }
                    });
                    if(!flag_1) {
                        return false;
                    }
                    $('.js-cost-price:visible').each(function (i) {
                        if (isNaN($(this).val()) || $(this).val() == undefined || parseFloat($(this).val()) <= 0) {
                            layer_tips(1, '请填写合法的成本价');
                            $(this).focus();
                            $(this).val('');
                            no_submit();
                            flag_2 = false;
                        }
                    });
                    if(!flag_2) {
                        return false;
                    }

                    $(".table-sku-stock-2 > tbody > .sku input[name='cost_sku_price']").each(function (i) {
                        if (parseFloat($(this).val()) > parseFloat($(".table-sku-stock-3 > tbody > .sku input[name='cost_sku_price']").eq(i).val())) {
                            layer_tips(1, '三级分销商的成本必须大于等于二级的成本');
                            $($(".table-sku-stock-3 > tbody > .sku input[name='cost_sku_price']").eq(i)).focus();
                            $($(".table-sku-stock-3 > tbody > .sku input[name='cost_sku_price']").eq(i)).val('');
                            no_submit();
                            flag_3 = false;
                        }
                    });
                    if(!flag_3) {
                        return false;
                    }
                    $(".table-sku-stock-1 > tbody > .sku input[name='cost_sku_price']").each(function (i) {
                        if (parseFloat($(this).val()) > parseFloat($(".table-sku-stock-2 > tbody > .sku input[name='cost_sku_price']").eq(i).val())) {
                            layer_tips(1, '二级分销商的成本必须大于等于一级的成本');
                            $($(".table-sku-stock-2 > tbody > .sku input[name='cost_sku_price']").eq(i)).focus();
                            $($(".table-sku-stock-2 > tbody > .sku input[name='cost_sku_price']").eq(i)).val('');
                            no_submit();
                            flag_4 = false;
                        }
                    });
                    if(!flag_4) {
                        return false;
                    }

                }else{

                    if ($('.cost-price-1 .cost-price-1:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.cost-price-1 .cost-price-1').val())) {
                        layer_tips(1,'一级分销商成本价格输入有误');
                        $('.cost-price-1 .cost-price-1').focus();
                        $('.cost-price-1 .cost-price-1').val('');
                        no_submit();
                        return false;
                    }
                    if ($('.cost-price-1 .cost-price-2:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.cost-price-1 .cost-price-2').val()) || parseFloat($('.cost-price-1 .cost-price-1').val()) > parseFloat($('.cost-price-1 .cost-price-2').val())) {
                        layer_tips(1,'二级分销商成本价格输入有误/不能小于一级分销商成本价');
                        $('.cost-price-1 .cost-price-2').focus();
                        $('.cost-price-1 .cost-price-2').val('');
                        no_submit();
                        return false;
                    }
                    if ($('.cost-price-1 .cost-price-3:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.cost-price-1 .cost-price-3').val()) || parseFloat($('.cost-price-1 .cost-price-2').val()) > parseFloat($('.cost-price-1 .cost-price-3').val())) {
                        layer_tips(1,'三级分销商成本价格输入有误/不能小于二级分销商成本价');
                        $('.cost-price-1 .cost-price-3').focus();
                        $('.cost-price-1 .cost-price-3').val('');
                        no_submit();
                        return false;
                    }

                    if ($('.price-1 .fx-price-1:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.price-1 .fx-price-1').val()) || parseFloat($('.price-1 .fx-price-1').val()) < parseFloat($('.cost-price-1 .cost-price-1').val())) {
                        layer_tips(1,'一级分销商零售价格输入有误/不能低于一级分销商成本价');
                        $('.price-1 .fx-price-1').focus();
                        $('.price-1 .fx-price-1').val('');
                        no_submit();
                        return false;
                    }
                    if ($('.price-1 .fx-price-2:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.price-1 .fx-price-2').val()) || parseFloat($('.price-1 .fx-price-2').val()) < parseFloat($('.cost-price-1 .cost-price-2').val())) {
                        layer_tips(1,'二级分销商零售价格输入有误/不能低于二级分销商成本价');
                        $('.price-1 .fx-price-2').focus();
                        $('.price-1 .fx-price-2').val('');
                        no_submit();
                        return false;
                    }
                    if ($('.price-1 .fx-price-3:visible').length > 0 && !/^\d+(\.\d+)?$/.test($('.price-1 .fx-price-3').val()) || parseFloat($('.price-1 .fx-price-3').val()) < parseFloat($('.cost-price-1 .cost-price-3').val())) {
                        layer_tips(1,'三级分销商零售价格输入有误/不能低于三级分销商成本价');
                        $('.price-1 .fx-price-3').focus();
                        $('.price-1 .fx-price-3').val('');
                        no_submit();
                        return false;
                    }
                }
            }
            if ($('.error-message').length > 0) {
                layer_tips(1, '信息填写有误，请检查');
                return false;
            }

            //库存信息
            var skus = [];
            var drp_level_1_cost_price = 0;
            var drp_level_2_cost_price = 0;
            var drp_level_3_cost_price = 0;
            var drp_level_1_price = 0;
            var drp_level_2_price = 0;
            var drp_level_3_price = 0;
            /*var is_edit_name = 0;
            var is_edit_desc = 0;*/
            if (unified_price_setting == 1) {
                if ($('.table-sku-stock:eq(1) > tbody > .sku').length > 0) {
                    $('.table-sku-stock:eq(1) > tbody > .sku').each(function (i) {
                        var drp_level = $(this).closest('table').data('level');
                        var sku_id = $(this).attr('sku-id');
                        var cost_price = 0;
                        var min_fx_price = 0;
                        var max_fx_price = 0;

                        var drp_level_1_cost_price = $('.table-sku-stock-1 > tbody > .sku').eq(i).find('.js-cost-price').val();
                        var drp_level_1_price = $('.table-sku-stock-1 > tbody > .sku').eq(i).find('.js-price').val();
                        var drp_level_2_cost_price = $('.table-sku-stock-2 > tbody > .sku').eq(i).find('.js-cost-price').val();
                        var drp_level_2_price = $('.table-sku-stock-2 > tbody > .sku').eq(i).find('.js-price').val();
                        var drp_level_3_cost_price = $('.table-sku-stock-3 > tbody > .sku').eq(i).find('.js-cost-price').val();
                        var drp_level_3_price = $('.table-sku-stock-3 > tbody > .sku').eq(i).find('.js-price').val();

                        var properties = $(this).attr('properties');
                        skus[i] = {
                            'sku_id': sku_id,
                            'cost_price': cost_price,
                            'min_fx_price': min_fx_price,
                            'max_fx_price': max_fx_price,
                            'properties': properties,
                            'drp_level_1_cost_price': drp_level_1_cost_price,
                            'drp_level_2_cost_price': drp_level_2_cost_price,
                            'drp_level_3_cost_price': drp_level_3_cost_price,
                            'drp_level_1_price': drp_level_1_price,
                            'drp_level_2_price': drp_level_2_price,
                            'drp_level_3_price': drp_level_3_price
                        };
                    });
                }

                var cost_price = $("input[name='cost_price']").val();
                var drp_level_1_cost_price = $('.cost-price-1 .cost-price-1').val();
                var drp_level_2_cost_price = $('.cost-price-1 .cost-price-2').val();
                var drp_level_3_cost_price = $('.cost-price-1 .cost-price-3').val();
                var drp_level_1_price = $('.fx-price-1').val();
                var drp_level_2_price = $('.fx-price-2').val();
                var drp_level_3_price = $('.fx-price-3').val();
                var min_fx_price = $("input[name='fx-min-price']").val();
                var max_fx_price = $("input[name='fx-max-price']").val();

                //是否推荐
                if ($("input[name='is_recommend']:checked").length) {
                    var is_recommend = $("input[name='is_recommend']:checked").val();
                }
                //是否统一直销价
                if ($("input[name='unified_profit']:checked").length) {
                    var unified_profit = $("input[name='unified_profit']:checked").val();
                }

                var product_id = $(this).attr('data-product-id');

                //统一零售价
                if (unified_sale_price == 1) {
                    min_fx_price = parseFloat($('.sale-price').val()).toFixed(2);
                    max_fx_price = min_fx_price;
                    drp_level_1_price = min_fx_price;
                    drp_level_2_price = min_fx_price;
                    drp_level_3_price = min_fx_price;
                }

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
                    $.post(fx_url, {
                        'product_id': product_id,
                        'cost_price': cost_price,
                        'min_fx_price': min_fx_price,
                        'max_fx_price': max_fx_price,
                        'is_recommend': is_recommend,
                        'unified_profit': unified_profit, //统一利润
                        'skus': skus,
                        'drp_level_1_cost_price': drp_level_1_cost_price,
                        'drp_level_2_cost_price': drp_level_2_cost_price,
                        'drp_level_3_cost_price': drp_level_3_cost_price,
                        'drp_level_1_price': drp_level_1_price,
                        'drp_level_2_price': drp_level_2_price,
                        'drp_level_3_price': drp_level_3_price,
                        'unified_price_setting': unified_price_setting,
                        'unified_price': unified_sale_price, //统一零售价
                        'degrees_profit': degrees_profit //分销商等级奖励
                    }, function (data) {
                        if (data.err_code == 0) {
                            var type = data.err_msg;
                            $('.notifications').html('<div class="alert in fade alert-success">商品保存成功</div>');
                            if (type == 1) {
                                location.href = wholesale_setting_url + "&id=" + product_id + "&role=supplier";
                            } else {
                                t = setTimeout('msg_hide(true, "' + data.err_msg + '")', 1000);
                            }
                        }
                    });
                }
            }
    });

    var level = {
        'level_1': '一',
        'level_2': '二',
        'level_3': '三',
        'getName': function(level) {
            return this['level_' + level];
        }
    };

    //处理change事件
    $(".goods-fx-setting").find("input[name='cost_price']").live('change', function() {
        $(this).attr('changed', true);
    });
    $(".goods-fx-setting").find("input[name='cost_price']").live('focus', function() {
        $(this).attr('data-value', $(this).val());
    });
    //商品分销价格
    $(".goods-fx-setting").find("input[name='cost_price']").live('blur', function(e) {
        //修改前的值
        var before_change_value = parseFloat($(this).data('data-value'));
        before_change_value = isNaN(before_change_value) ? 0 : before_change_value;
        //修改后的浮动值
        var after_change_floating = 0;
        var cost_price = $(this).val().trim();
        var drp_level = $(this).data('level');

        if (cost_price == '') {
            return false;
        }

        if (isNaN(cost_price)) {
            layer_tips(1,'成本价填写有误');
            $(this).val('');
            $(this).focus();
            no_submit();
            return false;
        }

        cost_price = parseFloat(cost_price);

        if (drp_level > 1) {
            //与上级比较
            var sup_drp_level = $(this).closest('tr').prev('tr').find("input[name='cost_price']").data('level');
            var sup_level_cost_price = $(this).closest('tr').prev('tr').find("input[name='cost_price']").val().trim();
            if (sup_level_cost_price >= cost_price) {
                layer_tips(1, level.getName(drp_level) + '级成本价必须大于' + level.getName(sup_drp_level) + '级成本价');
                $(this).val('');
                $(this).focus();
                no_submit();
                return false;
            }
        }
        if (drp_level < 3) {
            //与下级比较
            var sub_drp_level = $(this).closest('tr').next('tr').find("input[name='cost_price']").data('level');
            var sub_level_cost_price = $(this).closest('tr').next('tr').find("input[name='cost_price']").val().trim();
            sub_level_cost_price = parseFloat(sub_level_cost_price);
            if (sub_level_cost_price > 0 && sub_level_cost_price <= cost_price) {
                layer_tips(1, level.getName(drp_level) + '级成本价必须小于' + level.getName(sub_drp_level) + '级成本价');
                $(this).val('');
                $(this).focus();
                no_submit();
                return false;
            }
        }

        if ($(this).attr('changed') == undefined) {
            return false;
        }
        //修改后的浮动值
        if (cost_price != before_change_value) {
            after_change_floating = cost_price - before_change_value;
        }

        if ($('.goods-sku-fx-setting').length > 0) {
            if (cost_price > 0 || $(this).attr('changed')) {
                if (after_change_floating != cost_price) {
                    $('.goods-sku-fx-setting').find('.table-sku-stock-' + drp_level).find("input[name='cost_sku_price']").each(function(i) {
                        var tmp_sku_cost_price = parseFloat($(this).val());
                        tmp_sku_cost_price += after_change_floating;
                        $(this).val(tmp_sku_cost_price.toFixed(2));
                    });
                } else {
                    $('.goods-sku-fx-setting').find('.table-sku-stock-' + drp_level).find("input[name='cost_sku_price']").val(cost_price.toFixed(2));
                }
            }
        }
        $(this).val(cost_price.toFixed(2));
        $(this).attr('data-value', cost_price.toFixed(2));
        check_submit();
    });

    //处理change事件
    $(".goods-fx-setting").find("input[name='fx_price']").live('change', function() {
        $(this).attr('changed', true);
    });
    $(".goods-fx-setting").find("input[name='fx_price']").live('focus', function() {
        $(this).attr('data-value', $(this).val());
    });
    //商品销售价格
    $(".goods-fx-setting").find("input[name='fx_price']").live('blur', function(e) {
        //修改前的值
        var before_change_value = parseFloat($(this).data('data-value'));
        before_change_value = isNaN(before_change_value) ? 0 : before_change_value;
        //修改后的浮动值
        var after_change_floating = 0;
        var cost_price = parseFloat($(this).closest('td').prev('td').find("input[name='cost_price']").val().trim());
        var fx_price = $(this).val().trim();
        var drp_level = $(this).data('level');
        if (fx_price == '') {
            return false;
        }
        if (isNaN(fx_price)) {
            layer_tips(1,'分销价填写有误');
            $(this).focus();
            no_submit();
            return false;
        }

        fx_price = parseFloat(fx_price);
        if (cost_price >= fx_price) {
            layer_tips(1,'分销价必须大于成本价');
            $(this).focus();
            no_submit();
            return false;
        }

        if ($(this).attr('changed') == undefined) {
            return false;
        }
        //修改后的浮动值
        if (fx_price != before_change_value) {
            after_change_floating = fx_price - before_change_value;
        }

        if ($('.goods-sku-fx-setting').length > 0) {
            if (fx_price > 0 || $(this).attr('changed')) {
                if (after_change_floating != fx_price) {
                    $('.goods-sku-fx-setting').find('.table-sku-stock-' + drp_level).find("input[name='sku_price']").each(function(i) {
                        var tmp_sku_fx_price = parseFloat($(this).val());
                        tmp_sku_fx_price += after_change_floating;
                        $(this).val(tmp_sku_fx_price.toFixed(2));
                    });
                } else {
                    $('.goods-sku-fx-setting').find('.table-sku-stock-' + drp_level).find("input[name='sku_price']").val(fx_price.toFixed(2));
                }
            }
        }
        $(this).val(fx_price.toFixed(2));
        $(this).attr('data-value', fx_price.toFixed(2));
        check_submit();
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

    //默认等级利润
    $(".unified-profit-setting").find("input[name='default_profit']").live('blur', function(e) {
        var default_profit = $(this).val().trim();
        var drp_level = $(this).data('level');
        var sale_price = parseFloat($('.sale-price').val());

        if (default_profit == '') {
            return false;
        }

        if (isNaN(default_profit)) {
            layer_tips(1,'默认等级利润填写有误');
            $(this).val('');
            $(this).focus();
            no_submit();
            return false;
        }

        if (default_profit >= sale_price) {
            layer_tips(1,'默认等级利润必须小于该商品' + sale_price.toFixed(2) + '元销售价');
            $(this).val('');
            $(this).focus();
            no_submit();
            return false;
        }

        //分销商等级奖励利润总额
        var degree_profit_reward_total = 0;
        default_profit = parseFloat(default_profit);
        //分销商默认等级利润总额
        var default_profit_total = default_profit;

        //分销商等级利润
        if ($(this).closest('td').nextAll('td').find("input[name='degree_profit']").length > 0) {
            var tmp_profit_percent = 0;
            $(this).closest('td').nextAll('td').find("input[name='degree_profit']").each(function(i){
                tmp_profit_percent += parseFloat($(this).val());
            });
            degree_profit_reward_total += default_profit * (tmp_profit_percent / 100);
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

        $(this).val(default_profit.toFixed(2));
        check_submit();
    });


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

    function dump(val) {
        console.log(val);
    }
    /*$('.open-drp-degree:checked').live('click', function() {
        /!*if ($('.drp-degrees').length > 0) {
            var drp_degrees = $('.drp-degrees').text();
            drp_degrees = $.parseJSON(drp_degrees);
            if (drp_degrees != '') {
                var drp_degrees_array = [];
                for (i in drp_degrees) {
                    drp_degree.setNode('td');
                    drp_degree.setAttr({'class': 'text-center bg'});
                    drp_degree.setValue(drp_degrees[i].name);
                    drp_degree.createNode();
                    drp_degree.after($('.default-degree > td').eq(parseInt(i) + 1));
                }
            }
        }*!/
    });*/

    /*var drp_degrees = [];
    $(".open-drp-degree").live("click", function () {
        var drp_degree_json = $('.drp-degrees').text();
        if ($(this).is(':checked')) {
            drp_degree_json = $.parseJSON(drp_degree_json);
            if (drp_degree_json != '') {
                for (i in drp_degree_json) {
                    i = parseInt(i);

                    //显示分销商等级
                    drp_degree0 = new Degree(drp_degree_json[i], $('.default-degree > td'), (i+1));
                    drp_degree0.setDegreeName({
                        'node': 'td',
                        'attr': {
                            'class': 'text-center bg new-append'
                        }
                    });

                    //显示一级分销商等级奖励
                    var default_profit = parseFloat($('.default-degree-1 > td:eq(1)').find('input').val());
                    drp_degree1 = new Degree(drp_degree_json[i], $('.default-degree-1 > td'), (i+1));
                    drp_degree1.setProfitValue({
                        'level': 1,
                        'node': 'td',
                        'attr': {
                            'class': 'text-center new-append'
                        },
                        'value': '<div class="input-prepend"><input type="text" maxlength="10" name="profit-price" class="profit-price_1 input-small input-1-' + i + '" style="width: 80px;" value="' + (default_profit + parseFloat(drp_degree_json[i].supplier_reward)).toFixed(2) + '" /></div>'
                    });

                    //显示二级分销商等级奖励
                    var default_profit = parseFloat($('.default-degree-2 > td:eq(1)').find('input').val());
                    drp_degree2 = new Degree(drp_degree_json[i], $('.default-degree-2 > td'), (i+1));
                    drp_degree2.setProfitValue({
                        'level': 2,
                        'node': 'td',
                        'attr': {
                            'class': 'text-center new-append'
                        },
                        'value': '<div class="input-prepend"><input type="text" maxlength="10" name="profit-price" class="profit-price_1 input-small input-2-' + i + '" style="width: 80px;" value="' + (default_profit + parseFloat(drp_degree_json[i].supplier_reward)).toFixed(2) + '" /></div>'
                    });

                    //显示三级分销商等级奖励
                    var default_profit = parseFloat($('.default-degree-3 > td:eq(1)').find('input').val());
                    drp_degree3 = new Degree(drp_degree_json[i], $('.default-degree-3 > td'), (i+1));
                    drp_degree3.setProfitValue({
                        'level': 3,
                        'node': 'td',
                        'attr': {
                            'class': 'text-center new-append'
                        },
                        'value': '<div class="input-prepend"><input type="text" maxlength="10" name="profit-price" class="profit-price_1 input-small input-3-' + i + '" style="width: 80px;" value="' + (default_profit + parseFloat(drp_degree_json[i].supplier_reward)).toFixed(2) + '" /></div>'
                    });
                }
            }
        } else {
            Degree.destory();
        }
    });*/
});

function msg_hide(redirect, url) {
    if (redirect) {
        window.location.href = url;
    }
    $('.notifications').html('');
    clearTimeout(t);
}

//删除所有动态创建的html元素
/*
Degree.destory = function() {
    $('.new-append').remove();
}

function Degree(data, ele, degree) {
    this.data = data;
    this.ele = ele;
    this.degree = degree; //分销商等级
    this.html = '';
    this.level = 0; //分润级别
    this.input = [];

    //设置html元素
    this.setNode = function(node) {
        this.node = node;
    };

    //设置html元素属性
    this.setAttr = function(attrs) {
        var str_attr = ' ';
        for (key in attrs) {
            str_attr += key + '=' + '"' + attrs[key] + '" ';
        }
        this.attr = str_attr;
    };

    //设置html元素内容
    this.setValue = function(value) {
        this.value = value;
    };

    //创建html元素
    this.createNode =  function () {
        this.html = '<' + this.node + ' ' + this.attr + '>' + this.value + '</' + this.node + '>';
        //插入元素
        this.ele.eq(parseInt(this.degree - 1) + 1).after(this.html);
    };

    //设置级别
    this.setDegreeName = function (data) {
        if (data.level != undefined) {
            this.setLevel(data.level);
        }
        this.setNode(data.node);
        this.setAttr(data.attr);
        this.setValue('<span>' + this.data.name + '</span>');
        this.createNode();
    }

    //设置利润
    this.setProfitValue = function (data) {
        this.setNode(data.node);
        this.setAttr(data.attr);
        this.setValue(data.value);
        this.createNode();
        this.bind('blur', this.ele);
    }

    //设置分润级别
    this.setLevel = function(level) {
        this.level = level;
    }

    //删除html元素
    this.destory = function (i) {
        this.node.remove();
    }

    //绑定事件
    this.bind = function(eventType, ele) {
        if (ele.find('input').length > 0) {
            var obj = this;
            ele.find('input').live(eventType, function(e) {
                obj.validate(this, $(this).val());
            });
        }
    }

    //数据校验证
    this.validate = function(obj, value) {
        if ($(obj).val() == '') {
            console.log('error');
        }
    }
}*/
