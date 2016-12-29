/**
 * Created by Administrator on 2015/10/18.
 */
var t = '';
$(function(){
    load_page('.app__content', load_url, {page:'agency_content'}, '');

    $('.js-search-btn').live('click', function(){
        var keyword = $.trim($('.js-search').val());
        var authen = $('.authen').data('authen');
        if(authen == 3 && keyword.length < 2)
        {
            layer_tips(1,'请填写至少两个字的店铺名');
            $('.filter-box-search').focus();
            return false;
        }
        load_page('.app__content', load_url, {page:'agency_content', 'keyword': keyword, 'authen':authen}, '', function(){
            $('.js-search').val(keyword);
            $('.js-search').focus();
        });
    })

    $(".js-search").live('keyup', function(e){
        if (event.keyCode == 13) { //回车
            $('.js-search-btn').trigger('click');
        }
    })

    //选项卡切换
    $('.ui-nav > ul > li').live('click', function() {
        $(this).addClass('active');
        $(this).siblings('li').removeClass('active');
        var authen = $(this).children('a').data('authen');
        var keyword = $.trim($('.js-search').val());
        load_page('.app__content', load_url, {page:'agency_content', 'keyword': keyword, 'authen':authen}, '', function(){
        });
    })

    //分页
    $('.pagenavi > a').live('click', function(e){
        var p = $(this).attr('data-page-num');
        var keyword = $.trim($('.js-search').val());
        var authen = $('.authen').data('authen');
        //alert(authen);
        $('.app__content').load(load_url, {page: 'agency_content', 'p': p, 'keyword': keyword,'authen':authen}, function(){
            if (keyword != '') {
                $('.js-search').val(keyword);
            }
        });
    });

    $('.js-add-to-agency').live('click', function(e){
        var store_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认添加为经销商？', function(){
            $.post(add_agency_url, {'store_id':store_id}, function(data){
                if (data.err_code == 1) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + '添加成功' + '</div>');
                    setTimeout('location.reload()',2000);//延时2秒
                }else if(data.err_code == 2){
                    $('.notifications').html('<div class="alert in fade alert-success">' + '此店铺以成为排他批发商不允许添加' + '</div>');
                    setTimeout('location.reload()',4000);//延时2秒
                }else if(data.err_code == 0){
                    $('.notifications').html('<div class="alert in fade alert-success">' + '添加失败' + '</div>');
                    setTimeout('location.reload()',2000);//延时2秒
                }
            });
        });
    });
});

function msg_hide(redirect, url) {
    if (redirect) {
        window.location.href = url;
    }
    $('.notifications').html('');
    clearTimeout(t);
}

