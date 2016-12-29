/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
$(function(){
    load_page('.app__content', load_url, {page:'supplier_goods_content'}, '');


    $('.ui-nav > ul > li').live('click', function() {
        $(this).addClass('active').end().siblings().removeClass('active');
        var is = $(this).children('a').data('is');
        load_page('.app__content', load_url, {page:'supplier_goods_content','is':is}, '', function(){
        });
    })

    //分页
    $('.pagenavi > a').live('click', function(e){
        var p = $(this).attr('data-page-num');
        $('.app__content').load(load_url, {page: 'supplier_goods_content', 'p': p}, '');
    })
})
