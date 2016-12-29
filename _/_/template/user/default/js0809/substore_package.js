/**
 * Created by pigcms_21 on 2015/9/19.
 */
var t;
var orderbyfield = ''; //排序字段
var orderbymethod = ''; //排序方式
var page = 1; //页码
var status = '';
var courier = 0;
$(function(){

    // load_page('.app__content', load_url,{page:'package_content', 'p': page, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod, 'status': status}, '', function(){
    //     $(".all").closest('li').addClass('active');
    // });

    var tmp_status = '*';
    load_page('.app__content', load_url,{page:'package_content', 'p': page, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod, 'status': tmp_status, 'courier': courier}, '', function(){
        
        $("select[name='courier']").find("option[value='" + courier + "']").attr('selected', true);
        //状态
        if (tmp_status) {

            $('.ui-nav > ul > li').removeClass('active');
            if (tmp_status != '*') {
                $(".status-" + tmp_status).closest('li').addClass('active');
                return false;
            } else {
                $(".all").closest('li').addClass('active');
                return false;
            }
        }
        if (orderbyfield != '' && orderbymethod != '') {
            $('.orderby').children('span').remove();
            $('.orderby_' + orderbyfield).append('<span class="orderby-arrow ' + orderbymethod + '"></span>');
        }
        $('.all').parent('li').addClass('active').siblings('li').removeClass('active');
    });

    $('.ui-nav > ul > li > a').live('click', function(){

        var obj = this;
        var class_name = $(this).attr('class');
        if (status == '') {
            status = $(this).attr('data');
        }

        load_page('.app__content', load_url,{page:'package_content', 'p': page, 'orderbyfield': orderbyfield, 'orderbymethod': orderbymethod, 'status': status, 'courier': courier}, '', function(){
            $('.' + class_name).parent('li').addClass('active').siblings('li').removeClass('active');
            $("select[name='courier']").find("option[value='" + courier + "']").attr('selected', true);
            if (status) {
                $('.ui-nav > ul > li').removeClass('active');
                if (status != '*') {
                    $(".status-" + status).closest('li').addClass('active');
                } else {
                    $(".all").closest('li').addClass('active');
                }
            }
            if (orderbyfield != '' && orderbymethod != '') {
                $('.orderby').children('span').remove();
                $('.orderby_' + orderbyfield).append('<span class="orderby-arrow ' + orderbymethod + '"></span>');
            }
            status = '';
        });
    })

    $("select[name='courier']").live('change', function(){

        courier = $(this).val();

        orderbyfield = $(this).attr('data-orderby');
        if ($(this).children('span').hasClass('desc')) {
            orderbymethod = 'asc';
        } else {
            orderbymethod = 'desc';
        }

        $('.ui-nav > ul > .active > a').trigger('click');

    });

    //排序
    $('.orderby').live('click', function(){
        orderbyfield = $(this).attr('data-orderby');
        if ($(this).children('span').hasClass('desc')) {
            orderbymethod = 'asc';
        } else {
            orderbymethod = 'desc';
        }

        $('.ui-nav > ul > .active > a').trigger('click');
    })

    //分页
    $('.pagenavi > a').live('click', function(){
        page = $(this).attr('data-page-num');

        $('.ui-nav > ul > .active > a').trigger('click');
    })
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}