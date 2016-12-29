/**
 * Created by pigcms_21 on 2015/2/5.
 */
var name   = '';
var status = '';
var page   = 1; //ҳ��
var type   = 1;
$(function() {

    if (getQueryString('name')) {
        name = getQueryString('name').replace('+', ' ');
    }

    if (getQueryString('status')) {
        status = getQueryString('status');
    }

    $('.ui-nav > ul > li').live('click', function () {
        type = $(this).data('checked');
        var obj = this;
        load_page('.app__content', load_url, {page: page_content, 'name': name, 'status': status, 'type': type}, '', function(){
            if (name) {
                $("input[name='name']").val(name);
            }
            //״̬
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
            }
            $(obj).addClass('active').siblings('li').removeClass('active');
        });
    })

    if (location.hash == '#cash-pay') {
        type = 2;
        $('.ui-nav > ul > li').eq(1).trigger('click');
    } else {
        type = 1;
        $('.ui-nav > ul > li').eq(0).trigger('click');
    }

    //ɸѡ
    $('.js-filter').live('click', function(){
        name  = $("input[name='name']").val().trim();
        status = $("select[name='status']").val();

        load_page('.app__content', load_url, {page: page_content, 'name': name, 'status': status, 'type': type}, '', function(){
            if (name) {
                $("input[name='name']").val(name)
            }
            //״̬
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
    })

    //��ҳ
    $('.pagenavi > a').live('click', function(){
        page  = $(this).attr('data-page-num');
        name  = $("input[name='name']").val().trim();
        status = $("select[name='status']").val();
        load_page('.app__content', load_url, {page: page_content, 'p': page, 'name': name, 'status': status, 'type': type}, '', function(){
            if (name) {
                $("input[name='name']").val(name)
            }
            //״̬
            if (status) {
                $("select[name='status']").find("option[value='" + status + "']").attr('selected', true);
            }
        });
    })

})

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
}

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
