/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var page = 1;
var checked = 1;
$(function() {
    load_page('.app__content', load_url, {page: page_content, 'p': page, 'checked': checked, 'store_id': store_id}, '', function(){});


    $('.ui-table-order > tbody').live('mouseover', function(e) {
        $(this).addClass('bgcolor');
    })

    $('.ui-table-order > tbody').live('mouseout', function(e) {
        $(this).removeClass('bgcolor');
    })
})

$('.ui-nav > ul > .active > a').live('click', function() {
    load_page('.app__content', load_url, {'page': page_content, 'p': page, 'checked': checked, 'store_id': store_id}, '', function(){});
});

$('.ui-nav > ul > li').live('click', function() {
    $(this).addClass('active');
    $(this).siblings('li').removeClass('active');
    checked = $(this).data('checked');
    load_page('.app__content', load_url, {'page': page_content, 'p': page, 'checked': checked, 'store_id': store_id}, '', function(){});
});

//分页
$('.pagenavi > a').live('click', function(){
    page = $(this).attr('data-page-num');
    load_page('.app__content', load_url, {'page': page_content, 'p': page, 'checked': checked, 'store_id': store_id}, '', function(){});
})

$('.js-comfirm-check').live('click', function(e) {
    var order_id = $(this).data('order-id');
    if (store_id == undefined || store_id == null || store_id == '') {
        store_id = 0;
    }
    button_box($(this), e, 'left', 'confirm', '确认对账？', function(){
        $.post(bill_check_url, {'order_id': order_id, 'store_id': store_id}, function(data){
            if (!data.err_code) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            close_button_box();
            //load_page('.app__content', load_url, {page: page_content, 'p': page, 'checked': checked, 'store_id': store_id}, '', function(){});
            window.location.reload();
        })
    })
})