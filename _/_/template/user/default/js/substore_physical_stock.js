$(function(){
	load_page('.app__content',load_url,{page: page_content},'');

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
			
			if(group_id!=''){
				group_id = $('.chosen-single').attr('group-id',group_id);
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
		var p = $(this).attr('data-page-num');
        var orderbyfield = '';
        var orderbymethod = '';
        var index = 0;
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
        //$('.app__content').load(load_url, {page: page_content, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
		  $('.app__content').load(load_url, {page: page_content, 'p': p, 'keyword': keyword, 'group_id': group_id, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod}, function(){
            if (orderbymethod == 'asc') {
                $('.orderby').children('span').remove();
                $('.orderby').eq(index).append('<span class="orderby-arrow asc"></span>');
            } else {
                $('.orderby').children('span').remove();
                $('.orderby').eq(index).append('<span class="orderby-arrow desc"></span>');
            }
			
			if (group != '') {
                $('.chosen-single > span').text(group);
            }
            if (keyword != '') {
                $('.js-list-search > .txt').val(keyword);
            }
			
			if(group_id!=''){
				group_id = $('.chosen-single').attr('group-id',group_id);
			}
        });
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

    // $('.chosen-single').live('click', function(){
    //     $(".chosen-search input").focus();
    //     if ($(this).closest('.chosen-container-single').hasClass('chosen-container-active')) {
    //         $(this).closest('.chosen-container-single').removeClass('chosen-container-active').removeClass('chosen-with-drop');
    //     } else {
    //         $(this).closest('.chosen-container-single').addClass('chosen-container-active').addClass('chosen-with-drop');
    //     }
    // })

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

    //商品分组修改
    $('.popover-category2 > .popover-footer > .js-btn-confirm').live('click', function(){
        if ($('.category-check-all').length == 0) {
            $('.notifications').html('<div class="alert in fade alert-error">没有选择分组</div>');
            t = setTimeout('msg_hide()', 3000);
            return false;
        }
        var data = [];
        $('.js-check-toggle:checked').each(function(i){
            var product_id = $(this).val();
            var group_id = [];
            $('.category-check-all').each(function(j){
                group_id[j] = $(this).closest('li').attr('data-id');
            })
            group_id = group_id.join(',');
            if (group_id != '' && product_id > 0) {
                data[i] = {'product_id': product_id, 'group_id': group_id};
            }
        })
        $.post(edit_group_url, {'data': data}, function(data) {
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            t = setTimeout('msg_hide()', 3000);
            $('.js-check-toggle:checked').attr('checked', false);
            $('.popover-category2').closest('.popover').remove();
        })
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

    //门店管理员修改/添加库存
    $('.js-physical-quantity-edit').live('click',function(event){

        // var pigcms_id = $(this).closest('tr').attr('pigcms-id');
        // var content_dom = $(this).closest('tr').find('.tb-title .new_window');

        var self = $(this);
        var product_id = self.attr("data-product_id");
        var sku_id = self.attr("data-sku_id");
        var content_dom = self.closest('tr').find('.data-quantity');

        button_box($(this),event,'left','input',parseInt(content_dom.text()),function(){

            var new_content = parseInt($('.js-rename-placeholder').val());

            if(new_content <= 0){
            }else if(parseInt(content_dom.text()) != new_content){
                $.post(physical_quantity_edit,{product_id:product_id,sku_id:sku_id,quantity:new_content},function(result){
                    if(result.err_code == 0){
                        close_button_box();
                        layer_tips(0,'库存修改成功');
                        content_dom.html(new_content);
                    }else{
                        layer_tips(1,result.err_msg);
                    }
                });
            }else{
                close_button_box();
                layer_tips(1,'未做过修改');
            }
        });

    });


});
function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}