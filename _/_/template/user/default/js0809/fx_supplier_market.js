/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var category_id = 0;
var category_fid = 0;
var index = 0;
var text = '';
var keyword = '';
var store_arr = [];

$(function(){

    $('.app__content').load(load_url,{page:'supplier_market_content','is':is,'p': page}, '', function(){
        $('.chosen-single > span').text(text);
        $('.active-result').not(index).removeClass('result-selected highlighted')
        $('.active-result').eq(index).addClass('result-selected highlighted');
        $('.js-list-search > .js-keyword').val(keyword);
    });

    $('.ui-nav > ul > li').live('click', function() {
        $(this).addClass('active').end().siblings().removeClass('active');
        var is = $(this).children('a').data('is');
        load_page('.app__content', load_url, {page:'supplier_market_content','is':is}, '', function(){
        });
    })

    //分页
    $('.pagenavi > a').live('click', function(e){
        var p = $(this).attr('data-page-num');
        var category = $('.result-selected').data('option-array-index');
        var is = $('.page-is').data('is');
        if (category != undefined && category != '') {
            var category = category.split('|');
            category_fid = category[0];
            category_id = category[1];
            if (category_fid == 0) {
                category_fid = category_id;
                category_id = 0;
            } else {
                category_fid = 0;
            }
        }
        index = $('.result-selected').index('.active-result');
        text = $('.result-selected').text();

        keyword = $.trim($('.js-list-search > .js-keyword').val());
        $('.app__content').load(load_url, {page: 'supplier_market_content', 'p': p, 'is':is, 'category_id': category_id, 'category_fid': category_fid, 'keyword': keyword}, function(){
            $('.chosen-single > span').text(text);
            $('.active-result').not(index).removeClass('result-selected highlighted')
            $('.active-result').eq(index).addClass('result-selected highlighted');
            $('.js-list-search > .js-keyword').val(keyword);
        });
    })

    //选择分类触发
    $('.active-result').live('click', function(){
        var category = $(this).data('option-array-index');
        if(category!=0){
            var category = category.split('|');
            category_fid = category[0];
            category_id = category[1];
            if (category_fid == 0) {
                category_fid = category_id;
                category_id = 0;
            } else {
                category_fid = 0;
            }
            index = $('.result-selected').index('.active-result');
            text = $('.result-selected').text();
            load_page('.app__content', load_url, {page: 'supplier_market_content', 'category_id': category_id, 'category_fid': category_fid}, '', function(){
                $('.chosen-single > span').text(text);
                $('.active-result').not(index).removeClass('result-selected highlighted')
                $('.active-result').eq(index).addClass('result-selected highlighted');
            });
        }else{
            index = $('.result-selected').index('.active-result');
            text = $('.result-selected').text();
            load_page('.app__content', load_url, {page: 'supplier_market_content'}, '', function(){
                $('.chosen-single > span').text(text);
                $('.active-result').not(index).removeClass('result-selected highlighted')
                $('.active-result').eq(index).addClass('result-selected highlighted');
            });
        }

    })

    $('.market-search-btn').live('click', function(){
        var category = $('.result-selected').data('option-array-index');
        if (category) {
            category = category.split('|');
            category_fid = category[0];
            category_id = category[1];
        } else {
            category_fid = 0;
            category_id = 0;
        }
        if (category_fid == 0) {
            category_fid = category_id;
            category_id = 0;
        } else {
            category_fid = 0;
        }
        var index = $('.result-selected').index('.active-result');
        var text = $('.result-selected').text();
        var keyword = $.trim($('.js-list-search > .js-keyword').val());
        var is = $('.page-is').data('is');
        load_page('.app__content', load_url, {page: 'supplier_market_content', 'category_id': category_id, 'category_fid': category_fid, 'keyword': keyword, 'is':is}, '', function(){
            $('.chosen-single > span').text(text);
            $('.active-result').not(index).removeClass('result-selected highlighted')
            $('.active-result').eq(index).addClass('result-selected highlighted');
            $('.js-list-search > .js-keyword').val(keyword);
            $('.js-list-search > .js-keyword').focus();
        });
    })
    //取消分销
    $('.js-cancel-to-fx').live('click', function(e){
        var product_id = $(this).data('id');
        var is = $(this).data('is'); // 1 是分销商品
        button_box($(this), e, 'left', 'confirm', '确认取消？', function(){
        $.post(supplier_market_url, {'product_id': product_id, 'is': is}, function(data){
            close_button_box();
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">取消成功</div>');
                setTimeout('location.replace("'+ data.err_msg +'")',1000);//延时1秒
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">取消失败</div>');
                setTimeout('location.replace("'+ data.err_msg +'")',1000);//延时1秒
            }
        });
    });
    });

    //取消批发
    $('.js-cancel-to-wholesale').live('click', function(e){
        var product_id = $(this).data('id');
        var is = $(this).data('is'); // 2 是批发商品
        button_box($(this), e, 'left', 'confirm', '确认取消？', function(){
        $.post(supplier_market_url, {'product_id': product_id, 'is': is}, function(data){
            close_button_box();
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">取消成功</div>');
                setTimeout('location.replace("'+ data.err_msg +'")',1000);//延时1秒
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">取消失败</div>');
                setTimeout('location.replace("'+ data.err_msg +'")',1000);//延时1秒
            }
        });
        });
    });

    /*$('.js-batch-cancel-to-fx').live('click', function(){
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品。</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        var products = [];
        $('.js-check-toggle:checked').each(function(i){
            products[i] = $(this).val();
        })
        $.post(supplier_market_url, {'products': products.toString()}, function(data){
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                load_page('.app__content', load_url, {page:'supplier_market_content', 'category_id': category_id, 'category_fid': category_fid, 'keyword': keyword}, '', function(){
                    if (text != '' && text != undefined && index != undefined) {
                        $('.chosen-single > span').text(text);
                        $('.active-result').not(index).removeClass('result-selected highlighted')
                        $('.active-result').eq(index).addClass('result-selected highlighted');
                    }
                    if (keyword != '' && keyword != undefined) {
                        $('.js-list-search > .js-keyword').val(keyword);
                    }
                });
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })*/

    $(".js-keyword").live('keyup', function(e){
        if (event.keyCode == 13) { //回车
            $('.market-search-btn').trigger('click');
        }
    });

    /***************/

    //选中可选经销商  btn btn-default btn-wide area-editor-add-btn js-area-editor-translate
    $('.js-area-editor-notused .area-editor-list-title').live('click',function(){
        if($(this).hasClass('area-editor-list-select')){
            $(this).removeClass('area-editor-list-select');
        }else{
            $(this).addClass('area-editor-list-select');
        }
    });

    //添加到已选经销商
    $('.js-area-editor-translate').live('click',function(){
        var selected_num = 0;
        var area_used_html = '';
        $.each($('.area-editor-list-select').closest('li'),function(i,item){
            $(item).remove();
            var store_id = $(item).attr('area-id');
            var agency_name = $(item).attr('agenct-name');
            var product_id = $(item).attr('product-id');
            area_used_html += '<li product-id="'+ product_id +'" area-id="'+store_id+'" agenct-name="' + agency_name +'"><div class="area-editor-list-title"><div class="area-editor-list-title-content js-ladder-select"><div class="js-ladder-toggle area-editor-ladder-toggle extend">+</div>'+agency_name+'<div class="area-editor-remove-btn js-ladder-remove">×</div></div></div></li>';

        });
        $('.js-area-editor-used .area-editor-depth').append(area_used_html);
    });

    //保存
    $('.js-modal-save').live('click',function(){
        var used_li = $('.js-area-editor-used .area-editor-depth li');
        if(used_li.length == 0){
            alert('请先选择经销商！');
        }else{
            //白名单经销商
            var whitelist = [];
            var product_id =$(used_li).attr('product-id');
            if($('.js-area-editor-used .area-editor-depth li').length > 0){
                $('.js-area-editor-used .area-editor-depth li').each(function(i){
                    var whitewhole_id = $(this).attr('area-id');
                    whitelist[i] = {'seller_id':whitewhole_id};
                });
            }

            $.post(product_whitelist_url, {'product_id':product_id,'seller_id':whitelist}, function(data) {
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">白名单设置成功</div>');
                    window.location.reload();
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">白名单设置失败</div>');
                    window.location.reload();
                }
            })
        }
    });

    $('.js-modal-close').live('click',function(){
        $('.area-modal-wrap').remove();
    });

    //编辑
    $('.js-edit-cost-item').live('click',function(){
        var product_id = $(this).data('product');
        var area_span = $(this).closest('td').find('span');
        $.post(get_whitelist, {'product_id':product_id}, function(data) {
            for (var key in data.err_msg) {
                store_arr.push(data.err_msg[key]['store_id']);
              }
        });
        var html = '<div class="area-modal-wrap"><div class="modal-mask"><div class="area-modal"><div class="area-modal-head">选择可批发的经销商</div><div class="area-modal-content"><div class="area-editor-wrap clearfix"><div class="area-editor-column js-area-editor-notused"><div class="area-editor"><h4 class="area-editor-head">可选的经销商</h4><ul class="area-editor-list"><li><ul class="area-editor-list area-editor-depth">';
        $.post(agency_url, {}, function(data) {
            for (var key in data.err_msg) {
                 if($.inArray(data.err_msg[key]['store_id'], store_arr) == '-1') {
                html += '<li product-id="'+ product_id +'" area-id="' + data.err_msg[key]['store_id'] + '" agenct-name="' + data.err_msg[key]['name'] +'"><div class="area-editor-list-title"><div class="area-editor-list-title-content js-ladder-select"><div class="js-ladder-toggle area-editor-ladder-toggle extend">+</div>' + data.err_msg[key]['name'] + '</div></div></li>';
                }
            }
            html += '</ul></li></ul></div></div><button class="btn btn-default btn-wide area-editor-add-btn js-area-editor-translate">添加</button><div class="area-editor-column area-editor-column-used js-area-editor-used"><div class="area-editor"><h4 class="area-editor-head">已选经销商</h4><ul class="area-editor-list"><li><ul class="area-editor-list area-editor-depth">';
            $.post(get_whitelist, {'product_id':product_id}, function(data) {
                for (var key in data.err_msg) {
                    html += '<li product-id="'+ product_id +'" area-id="' + data.err_msg[key]['store_id'] + '" agenct-name="' + data.err_msg[key]['name'] + '"><div class="area-editor-list-title"><div class="area-editor-list-title-content js-ladder-select"><div class="js-ladder-toggle area-editor-ladder-toggle extend">+</div>' + data.err_msg[key]['name'] + '<div class="area-editor-remove-btn js-ladder-remove">×</div></div></div></li>';
                }
                html += '</ul></li></ul></div></div></div></div><div class="area-modal-foot"><button class="btn btn-primary btn-wide js-modal-save">确定</button>&nbsp;&nbsp;<button class="btn btn-default btn-wide js-modal-close">取消</button></div></div></div></div>';
                $('body').append(html);
            });

        });
    });
    //删除
    $('.js-delete-cost-item').live('click',function(e){
        var product_id = $(this).data('product');

        button_box($(this), e, 'left', 'confirm', '确认取消？', function(){
            $.post(detach_whitelist_url,{'product_id':product_id},function(data){
                close_button_box();
                if(data.err_code==0){
                    $('.notifications').html('<div class="alert in fade alert-success">'+ data.err_msg +'</div>');
                    window.location.reload();
                }
            });
        });
    });

    $('.js-ladder-remove').live('click',function(){
        var area_id = $(this).closest('li').attr('area-id');
        var seller = $(this).closest('li').attr('agenct-name');
        var li = '<li area-id="' + area_id + '" agenct-name="' + seller +'"><div class="area-editor-list-title"><div class="area-editor-list-title-content js-ladder-select"><div class="js-ladder-toggle area-editor-ladder-toggle extend">+</div>' + seller + '</div></div></li>';
        $(this).closest('li').remove();
        $('.area-editor-depth:eq(0)').append(li);
    });

    $(".drp-degree-setting").live("click", function(e){
        var product = $(this).closest('td').prevAll('td').find('.goods-title > a').attr('title');
        var product_id = $(this).data('id');
        $.layer({
            type: 2,
            shadeClose: true,
            title: '分销商品 - 特权设置 【' + product + product + '】',
            closeBtn: [0, true],
            shade: [0.5, '#000'],
            border: [0],
            maxmin: true,
            fix : false,
            area: ['850px', '250px'], //宽度，高度
            iframe: {src: goods_drp_degree_url + '&product_id=' + product_id}
        });
    })
})

function msg_hide(redirect, url) {
    if (redirect) {
        window.location.href = url;
    }
    $('.notifications').html('');
    clearTimeout(t);
}
