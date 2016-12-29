/**
 * Created by Administrator on 2015/11/2.
 */

var t = '';
$(function(){
    load_page('.app__content', load_url, {page:'my_bond_log_content','store_id': store_id}, '', function(){

    });

});

//分页
$('.pagenavi > a').live('click', function(e){
    var p = $(this).attr('data-page-num');
    var keyword = $.trim($('.js-search').val());

    $('.app__content').load(load_url, {page: 'my_bond_log_content', 'p':p, 'keyword': keyword, 'store_id':store_id}, function(){
        if (keyword != '') {
            $('.js-search').val(keyword);
        }
    });
});

//搜索
$('.ui-btn-primary').live('click', function(){
    var keyword = $.trim($('.js-list-search > .filter-box-search').val());
    load_page('.app__content', load_url, {page: 'my_bond_log_content', 'opening_bank': keyword,'store_id':store_id }, '', function(){
        $('.chosen-single > span').text(text);
        $('.active-result').not(index).removeClass('result-selected highlighted')
        $('.active-result').eq(index).addClass('result-selected highlighted');
        $('.js-list-search > .js-keyword').val(keyword);
        $('.js-list-search > .js-keyword').focus();
    });
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}


