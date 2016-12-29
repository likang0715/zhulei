/**
 * Created by pigcms_21 on 2015/9/19.
 */
var t;
$(function(){
    location_page(location.hash);
    $('.dianpu_left a').live('click',function(){
        try {
            var mark_arr = $(this).attr("href").split("#");
            location_page("#" + mark_arr[1]);
        } catch(e) {
            location_page(location.hash);
        }
    });
    //用户中心左侧菜单专用
    $(".dianpu a").live('click',function(){
        var marks2 = $(this).attr('href').split('#');
        if(marks2[1]) {
            if($(this).attr('href')) location_page("#"+marks2[1],$(this));
        }
    })


    function location_page(mark,dom){
        var mark_arr = mark.split('/');
        switch(mark_arr[0]){
            case '#list':
                $(".dianpu_left .product").addClass("active").siblings().removeClass("active");
                $('.js-app-nav.product').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'list_admin_content'}, '');
                break;
            default:
                $(".dianpu_left .product").addClass("active").siblings().removeClass("active");
                $('.js-app-nav.product').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'assign_quantity'}, '');

        }
    }

    //分页
    $('.js-page-list > a').live('click', function(e){
        var p = $(this).attr('data-page-num');
        var orderbyfield = '';
        var orderbymethod = '';
        var index = 0;
        //保留排序
        $('.orderby').each(function(i){
            if ($(this).children('span').length > 0) {
                index = i;
                orderbyfield = $(this).attr('data-orderby');
                if ($(this).children('span').hasClass('desc')) {
                    orderbymethod = 'desc';
                }
                if ($(this).children('span').hasClass('asc')) {
                    orderbymethod = 'asc';
                }
            }
        })
        //保留分组
        var group_id = '';
        var group = '';
        if ($('.chosen-single').attr('group-id') != '') {
            group_id = $('.chosen-single').attr('group-id');
            group = $('.chosen-single > span').text();
        }
        //保留关键字
        var keyword = '';
        if ($('.js-list-search > .txt').val() != '') {
            keyword = $('.js-list-search > .txt').val();
        }
        $('.app__content').load(load_url, {page: page_content, 'p': p, 'keyword': keyword, 'group_id': group_id, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
            if (group != '') {
                $('.chosen-single > span').text(group);
            }
            if (keyword != '') {
                $('.js-list-search > .txt').val(keyword);
            }
            $('.orderby').children('span').remove();
            if (orderbymethod == 'asc') {
                $('.orderby').eq(index).append('<span class="orderby-arrow asc"></span>');
            } else {
                $('.orderby').eq(index).append('<span class="orderby-arrow desc"></span>');
            }
        });
    })

    //排序
    $('.orderby').live('click', function(e){
        var index = $(this).index('.orderby');
        var orderbyfield = $(this).attr('data-orderby');
        if ($(this).children('span').length > 0) {
            if ($(this).children('span').hasClass('desc')) {
                var orderbymethod = 'asc';
            } else {
                var orderbymethod = 'desc';
            }
        } else {
            var orderbymethod = 'desc';
        }
        $('.app__content').load(load_url, {page: page_content, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
            if (orderbymethod == 'asc') {
                $('.orderby').children('span').remove();
                $('.orderby').eq(index).append('<span class="orderby-arrow asc"></span>');
            } else {
                $('.orderby').children('span').remove();
                $('.orderby').eq(index).append('<span class="orderby-arrow desc"></span>');
            }
        });
    })

    //全选
    $('.js-check-all').live('click', function(){
        if ($(this).is(':checked')) {
            $('.js-check-toggle').attr('checked', true);
        } else {
            $('.js-check-toggle').attr('checked', false);
        }
    })

    //批量修改分组
    $('.js-batch-tag').live('click', function(){
        if (product_groups_json != '') {
            var product_groups = $.parseJSON(product_groups_json);
        } else {
            var product_groups = '';
        }
        var list = '';
        if (product_groups != '') {
            for(group in product_groups) {
                list += '<li data-id="' + product_groups[group]['group_id'] + '" class="clearfix"><span class="js-category-check category-check category-check-none"></span><span class="category-title">' + product_groups[group]['group_name'] + '</span></li>';
            }
        }
        if (list == '') {
            list = '<span style="color:red">没有商品分组！</span>';
        }
        if ($('.js-check-toggle:checked').length == 0) {
            $('.notifications').html('');
            $('.notifications').html('<div class="alert in fade alert-error"><a href="javascript:;" class="close pull-right">×</a>请选择商品</div>');
            $('body').append('<div class="notify-backdrop fade in"></div>');
            return false;
        }
        $('body').children('.popover').remove();
        var html = '<div class="popover bottom" style="display: block; top: ' + ($(this).offset().top + $(this).height()) + 'px; left: ' + ($(this).offset().left - $(this).width() - 5) + 'px;"><div class="arrow"></div><div class="popover-inner popover-category2"><div class="popover-header clearfix">修改分组<a href="' + goods_group_url + '" target="_blank" class="pull-right">管理</a></div><div class = "popover-content" ><ul class="popover-content-categories js-popover-content-categories">' + list + '</ul></div><div class="popover-footer"><a href="javascript:;" class="ui-btn ui-btn-primary js-btn-confirm">保存</a><a href="javascript:;" class="ui-btn js-btn-cancel">取消</a></div></div></div>';
        $('body').append(html);
    })

    //选择分组
    $('.js-popover-content-categories > li').live('click', function(e){
        if ($(this).children('.js-category-check').hasClass('category-check-all')) {
            $(this).children('.js-category-check').removeClass('category-check-all').addClass('category-check-none');
        } else {
            $(this).children('.js-category-check').removeClass('category-check-none').addClass('category-check-all');
        }
    });

    //关闭提示窗
    $('.close').live('click', function(e){
        $('.notifications').html('');
        $('.notify-backdrop').remove();
    })

    //按esc键关闭提示窗
    $('body').live('keyup', function(){
        if(event.keyCode == 27 && $(this).has('.notify-backdrop')) {
            $('.notifications').html('');
            $('.notify-backdrop').remove();
        }
    })

    //点击取消安钮，删除分组修改窗口
    $('.js-btn-cancel').live('click', function(){
        $('body').children('.popover').remove();
    })

    //点击“删除窗口”之外区域删除“删除窗口”
    $('body').click(function(e){
        var _con = $('.popover');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            $('.popover').remove();
        }
    })

    //搜索框动画
    $('.ui-search-box :input').live('focus', function(){
        $(this).animate({width: '180px'}, 100);
    })
    $('.ui-search-box :input').live('blur', function(){
        $(this).animate({width: '70px'}, 100);
    })

    //回车提交搜索
    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.ui-search-box .txt').is(':focus')) {
            var keyword = $('.ui-search-box .txt').val();
            var group_id = '';
            var group = '';
            if ($('.chosen-single').attr('group-id') != '') {
                group_id = $('.chosen-single').attr('group-id');
                group = $('.chosen-single > span').text();
            }
            $('.app__content').load(load_url, {page: page_content, 'keyword': keyword, 'group_id': group_id}, function(){
                $('.chosen-single > span').text(group);
                $('.chosen-single').attr('group-id', group_id);
                $('.ui-search-box .txt').val(keyword);
            });
        }
    })

    $('.chosen-single').live('click', function(){
        $(".chosen-search input").focus();
        if ($(this).closest('.chosen-container-single').hasClass('chosen-container-active')) {
            $(this).closest('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
        } else {
            $(this).closest('.chosen-container-single').addClass('chosen-container-active').addClass('chosen-with-drop');
        }
    })

    //分组选择
    $('.active-result').live('hover', function(){
        $(this).addClass('result-selected').addClass('highlighted');
        $(this).siblings('.active-result').removeClass('result-selected').removeClass('highlighted');
    })

    //选择分组触发
    $('.active-result').live('click', function(){

    })

    $('body').click(function(e){
        var _con = $('.chosen-container');   // 设置目标区域
        if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
            if ($('.chosen-container-single').hasClass('chosen-with-drop')) {
                $('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
            }
        }
    })

    $(".chosen-search input").live('keyup', function(e){
        if (event.keyCode == 38 && $('.chosen-container').hasClass('chosen-container-active')) { //向上
            if ($('.result-selected').prev('.active-result').length > 0) {
                var index = $('.result-selected').index('.active-result');
                $('.active-result').eq(index).removeClass('result-selected').removeClass('highlighted');
                $('.active-result').eq(index).prev('.active-result').addClass('result-selected').addClass('highlighted');
            }
        }
        if (event.keyCode == 40 && $('.chosen-container').hasClass('chosen-container-active')) { //向下
            if ($('.result-selected').next('.active-result').length > 0) {
                var index = $('.result-selected').index('.active-result');
                $('.active-result').eq(index).removeClass('result-selected').removeClass('highlighted');
                $('.active-result').eq(index).next('.active-result').addClass('result-selected').addClass('highlighted');
            }
        }
    })

    //商品分组筛选
    $('.active-result').live('click', function(){
        var keyword = '';
        var group_id = $(this).attr('data-option-array-index');
        var group = $(this).text();
        if ($('.js-list-search > .txt').val() != '') {
            keyword = $('.js-list-search > .txt').val();
        }
        $('.chosen-single > span').text(group);
        $(this).closest('.chosen-container').removeClass('chosen-container-active chosen-with-drop');
        $('.app__content').load(load_url, {page: page_content, 'keyword': keyword, 'group_id': group_id}, function(){
            $('.chosen-single > span').text(group);
            $('.chosen-single').attr('group-id', group_id);
            if (keyword != ''){
                $('.js-list-search > .txt').val(keyword);
            }
        });
    })

    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.result-selected').length && $('.result-selected').closest('.chosen-container').hasClass('chosen-container-active')) {
            var keyword = '';
            var group_id = $('.result-selected').attr('data-option-array-index');
            var group = $('.result-selected').text();
            if ($('.js-list-search > .txt').val() != '') {
                keyword = $('.js-list-search > .txt').val();
            }
            $('.result-selected').closest('.chosen-container').removeClass('chosen-container-active chosen-with-drop');
            $('.app__content').load(load_url, {page: page_content, 'keyword': keyword, 'group_id': group_id}, function(){
                $('.chosen-single > span').text(group);
                $('.chosen-single').attr('group-id', group_id);
                if (keyword != ''){
                    $('.js-list-search > .txt').val(keyword);
                }
            });
        }
    })

    // 分配库存弹层 TODO
    $('.js-show-assign').live('click', function(){
        var product_id = typeof $(this).attr('data-product_id') != 'undefined' ? $(this).attr('data-product_id') : 0;
        var sku_id = typeof $(this).attr('data-sku_id') != 'undefined' ? $(this).attr('data-sku_id') : 0;
        $.post(assign_json_url, {'product_id': product_id, 'sku_id' : sku_id}, function(data){

            if (data.err_code) {
                layer_tips(data.err_code, data.err_msg);
                return false;
            }

            var data = $.parseJSON(data);
            var physical_arr = data.physical_quantity

            var html = '<div class="modal-backdrop fade in"></div>';
            html += '   <div class="modal hide fade order-price in" style="margin-top: -1000px; display: block;" aria-hidden="false">';
            html += '       <div class="modal-header">';
            html += '           <a class="close" data-dismiss="modal">×</a><h3 class="title">门店列表 | 库存总数: <span class="js-total-quantity">' + data.product_info.quantity + '</span></h3>';
            html += '       </div>';
            html += '       <div class="modal-body js-detail-container"><div>';
            html += '       <form action="" class="form-inline">';
            html += '       <table class="table order-price-table">';
            html += '           <thead>';
            html += '               <tr>';
            html += '                   <th class="tb-name">门店名</th>';
            html += '                   <th class="tb-price">联系地址</th>';
            html += '                   <th class="tb-num">联系电话</th>';
            html += '                   <th class="tb-discount">营业时间</th>';
            html += '                   <th class="tb-postage">门店库存</th>';
            html += '               </tr>';
            html += '           </thead>';
            html += '           <tbody>';
            for (i in data.store_physical) {
                html += '               <tr>';
                html += '                   <td class="tb-name">' + data.store_physical[i]['name'] + '</td>';
                html += '                   <td class="tb-price">' + data.store_physical[i]['address'] + '</td>';
                html += '                   <td class="tb-num">' + data.store_physical[i]['phone1'] + '-' + data.store_physical[i]['phone2'] + '</td>';
                html += '                   <td class="tb-discount">' + data.store_physical[i]['business_hours'] + '</td>';
                html += '                   <td class="tb-postage">';
                html += '                       <input type="hidden" value="' + data.store_physical[i]['pigcms_id'] + '" name="physical_ids[]" />';
                html += '                       <input type="text" class="input input-mini" value="' + (physical_arr[data.store_physical[i]['pigcms_id']] ? physical_arr[data.store_physical[i]['pigcms_id']] : 0) + '" name="nums[]" />';
                html += '                   </td>';
                html += '               </tr>';
            }
            html += '           </tbody>';
            html += '       </table>';
            html += '       </form>';
            html += '   </div>';
            html += '</div>';
            html += '   <div class="modal-footer clearfix">';
            html += '       <a href="javascript:;" class="btn btn-primary pull-right js-save-data" data-sku_id="' + sku_id + '" data-product_id="' + product_id + '" data-loading-text="确 定...">确 定</a>';
            html += '   </div></div>';

            $('body').append(html);
            $('.modal').animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
        })
    })

    $('.modal-header > .close').live('click', function(){
        $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
            $('.modal-backdrop,.modal').remove();
            if ($('.select2-display-none').length > 0) {
                $('.select2-display-none').remove();
            }
            $('.js-express-goods').removeClass('express-active');
        });
    })

    //保存库存分配
    $('.js-save-data').live('click', function(){

        var sub_total = parseFloat($('.js-total-quantity').text());
        var physical_ids_obj = $("input[name='physical_ids[]']");
        var nums_obj = $("input[name='nums[]']");
        var physical_ids = [];
        var nums = [];

        var total = 0;

        physical_ids_obj.each(function(){
            physical_ids.push($(this).val());
        });

        nums_obj.each(function(){
            var p = parseFloat($(this).val()) >= 0 ? parseFloat($(this).val()) : 0;
            total += p;
            nums.push(p);
        });

        if (total > sub_total) {
            layer_tips(1, '分配库存不能大于总库存')
            return false;
        }

        var obj = this;
        var product_id = $(this).attr('data-product_id');
        var sku_id = $(this).attr('data-sku_id');

        $.post(set_physical_quantity, {'product_id': product_id, 'sku_id': sku_id, 'physical_ids': physical_ids, 'nums': nums }, function(data){
            if (!data.err_code) {
                $('.modal').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
                    $('.modal-backdrop,.modal').remove();
                });
                $('.notifications').html('<div class="alert in fade alert-success">修改成功</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">修改失败</div>');
            }
            t = setTimeout('msg_hide()', 3000);
        })
    })

})


function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}