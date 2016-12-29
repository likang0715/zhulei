/**
 * Created by pigcms_21 on 2015/2/5.
 */
$(function(){
    load_page('.app__content', load_url, {page:'whole_detail_content','store_id':store_id}, '', function(){

    });

    $('#shenhe').live('click', function(e){
        var supplier_id = $('.supplierid').data('supplierid');
        var distributor_id = $('.distributorid').data('distributorid');
        button_box($(this), e, 'left', 'confirm', '确认审核通过？', function(){
            $.post(anthen_url, {'supplier_id': supplier_id, 'distributor_id': distributor_id, 'authen':1}, function(data){
                $('.notifications').html('<div class="alert in fade alert-success">' + '审核成功' + '</div>');
                location.replace(location);
            });
        });
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
