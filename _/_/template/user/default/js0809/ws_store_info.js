/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
var p = 1;
var page_content = '_ws_order_content';
var status = 1;
var active_nav = $('.ui-nav > ul > li:eq(0)');
var menu_obj = {'not-paid': '_ws_order_content', 'paid': '_ws_order_content', 'bond-expend': '_bond_expend_content', 'bond-recharge': '_bond_recharge_content', 'wholesale-product': '_wholesale_product_content', 'whitelist-product': '_whitelist_product_content', 'approve-data': '_approve_data_content'};
var menu_index = {'not-paid': 0, 'paid': 1, 'bond-expend': 2, 'bond-recharge': 3, 'wholesale-product': 4, 'whitelist-product': 5, 'approve-data': 6};
var key = '';

$(function(){

    $('.ui-nav > ul > li').live('click', function() {
        page_content = $(this).data('content') + '_content';
        status = $(this).data('checked');
        active_nav = this;
        load_page('.app__content', load_url, {page: page_content, 'store_id': store_id, 'status': status}, '', function(){
            $(active_nav).addClass('active').siblings('li').removeClass('active');
        });
    })

    //刷新保持选项卡选中不变
    if (window.location.hash != '') {
        var hash = window.location.hash;
        key = hash.replace('#', '');
        if (menu_obj[key] != undefined) {
            page_content = menu_obj[key];
        }
        if (menu_index[key] != undefined) {
            $('.ui-nav > ul > li').eq(menu_index[key]).trigger('click');
        }
    } else {
        load_page('.app__content', load_url, {page: page_content,'store_id':store_id, 'status': status}, '', function(){});
    }

    //分页
    $('.pagenavi > a').live('click', function(e){
        p = $(this).attr('data-page-num');
        $('.app__content').load(load_url, {page: page_content, 'p': p,'store_id':store_id, 'status': status}, function(){
            $(active_nav).addClass('active').siblings('li').removeClass('active');
        });
    })

    //移除白名单
    $('.remove-whitelist').live('click', function(e) {
        var id = $(this).data('id');
        var obj = this;
        button_box($(this).closest('td'), e, 'left', 'confirm', '确定移出白名单？', function(){
            $.post(remove_whitelist_url, {'id': id, 'update': 'whitelist'}, function(data) {
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    $('.ui-nav > ul > li:eq(6)').trigger('click');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                close_button_box();
                t = setTimeout('msg_hide()', 3000);
            });
        });
    });

    $('.caret').live('click', function(){
        var bank = $(this).data('bank');
        var opening_bank = $(this).data('opening-bank');
        var bank_account = $(this).data('bank-account');
        var bank_card = $(this).data('bank-card');
        $('body > .popover').remove();
        $('body').append('<div class="popover center-bottom bottom" style="display: block; top: ' + ($(this).offset().top) + 'px; left: ' + ($(this).offset().left - 129) + 'px;"><div class="arrow"></div><div class="popover-inner popover-delete"><div class="popover-content"><div class="js-content"><div><p>收款银行：' + bank + '</p><p>开户银行：' + opening_bank + '</p><p>银行帐户：' + bank_card + '</p><p>帐户名称：' + bank_account + '</p></div></div></div></div></div>');
    })

    function bodyClick(e)
    {
        var _con = $('.popover');   // 设置目标区域
        if((!_con.is(e.target) && _con.has(e.target).length === 0)){ // Mark 1
            if ($('.popover').prev('.help').length == 0) {
                $('.popover').remove();
            }
            $('body > .popover').remove();
        }
    }
    $('body').click(function(e){
        bodyClick(e);
    })

    $('.help').live('hover', function(e) {
        if (event.type == 'mouseover') {
            $(this).next('.js-intro-popover').show();
        } else if (event.type == 'mouseout') {
            $(this).next('.js-intro-popover').hide();
        }
    });

    $('.status > .js-status-select').live('change', function(e) {
        $('body').unbind('click');
        var text = {'1': '申请中', '2': '银行处理中', '3': '提现成功', '4': '提现失败'};
        var status = $(this).val();
        var id = $(this).data('id');
        var unchange_status = $(this).data('status');
        var obj = this;

        button_box($(this).closest('td'), e, 'left', 'confirm', text[$(this).val()], function(){
            $.post(update_income_url, {'status':status, 'id':id}, function(data){
                if (data) {
                    $('.notifications').html('<div class="alert in fade alert-success">修改状态操作成功</div>');
                    $('.ui-nav > ul > li:eq(4)').trigger('click');
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">修改状态操作失败</div>');
                }
                close_button_box();
                $('body').bind('click', function(e){
                    bodyClick(e);
                });
                t = setTimeout('msg_hide()', 3000);
            });
        }, '', function () {
            close_button_box();
            $('body').bind('click', function(e){
                bodyClick(e);
            });
            //还原选中项
            $(obj).val(unchange_status);
        });
    });

    $(".add-bak").live("click", function () {
        $(this).toggle(function () {
            var id = $(this).data('id');
            var bak = $(this).prevAll('.bak-content').text();
            $(this).text('取消备注');
            $(this).closest('td').next('td').children('.js-status-select').after('<span class="bak-span"><textarea name="bak" class="js-bak" data-id="' + id + '" style="width:86px">' + bak + '</textarea></span>');
        },function () {
            $(this).text('添加备注');
            $(this).closest('td').next('td').children('.js-status-select').next('.bak-span').remove();
        });
        //立即执行点击事件
        $(this).trigger('click');
    });

    $('.js-bak').live('blur', function() {
        var id = $(this).data('id');
        var bak = $(this).val().trim();
        var obj = this;
        $.post(update_income_url, {'update': 'bak', 'id': id, 'bak': bak}, function(data) {
            if (!data.err_code) {
                $(obj).closest('td').prev('td').children('.bak-content').text(bak);
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
            }
            $(obj).closest('td').prev('td').children('.add-bak').trigger('click');
            t = setTimeout('msg_hide()', 3000);
        })
    });
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}