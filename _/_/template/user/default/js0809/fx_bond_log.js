/**
 * Created by Administrator on 2015/10/31.
 */
$(function(){
    load_page('.app__content', load_url, {page:'bond_log_content','store_id':store_id}, '', function(){

    });

    //选项卡切换
    $('.ui-nav > ul > li').live('click', function() {
        $(this).addClass('active');
        $(this).siblings('li').removeClass('active');
        var status = $(this).children('a').data('status');

        var keyword = $.trim($('.js-search').val());
        load_page('.app__content', load_url, {page:'bond_log_content', 'status': status, 'store_id': store_id }, '', function(){

        });
    });

    //分页
    $('.pagenavi > a').live('click', function(e){
        var p = $(this).attr('data-page-num');
        var keyword = $.trim($('.js-search').val());
        var status = $.trim($('.status').data('status'));
        $('.app__content').load(load_url, {page: 'bond_log_content', 'p':p, 'keyword': keyword, 'store_id':store_id,'status':status}, function(){
            if (keyword != '') {
                $('.js-search').val(keyword);
            }
        });
    });

    //搜索
    $('.ui-btn-primary').live('click', function(){
        var keyword = $.trim($('.js-list-search > .filter-box-search').val());
        var status = $.trim($('.status').data('status'));
        load_page('.app__content', load_url, {page: 'bond_log_content', 'opening_bank': keyword,'store_id':store_id,'status':status}, '', function(){
            $('.chosen-single > span').text(text);
            $('.active-result').not(index).removeClass('result-selected highlighted')
            $('.active-result').eq(index).addClass('result-selected highlighted');
            $('.js-list-search > .js-keyword').val(keyword);
            $('.js-list-search > .js-keyword').focus();
        });
    })

    $('.confirmation_arrival').live('click', function(e){
        var bond_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认批发商线下打款您已收到？', function(){
            $.post(update_bond_url, {'id':bond_id}, function(data){
                if (data) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + '确认成功' + '</div>');
                    location.reload();
                }
            });
        });
    })

})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}