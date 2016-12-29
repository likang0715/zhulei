var p = 1;
var order_method = 'DESC';
var order_field = 'date_added';

$(function () {
    load_page('.app__content', load_url, {page: 'my_team_detail_content', 'team_id': team_id, 'order_field': order_field, 'order_method': order_method, 'p': p}, '');

    //排序
    $('.sort span').live('click', function(e) {
        order_method = $(this).data('method').toUpperCase();
        order_field = $(this).data('field');
        load_page('.app__content', load_url, {page: 'my_team_detail_content', 'team_id': team_id, 'order_field': order_field, 'order_method': order_method, 'p': p}, '', function() {});
    });

    //分页
    $('.js-page-list > a').live('click', function(e){
        p = $(this).attr('data-page-num');
        load_page('.app__content', load_url, {page: 'my_team_detail_content', 'team_id': team_id, 'order_field': order_field, 'order_method': order_method, 'p': p}, '', function() {});
    });
});


