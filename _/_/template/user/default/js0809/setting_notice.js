/**
 * Created by ediancha on 2016/07.26
 */
function saveNoticeform () {
    var fields_seria = $(".js-notice-form input[type='checkbox']").serializeArray();
    teaAlert('loading',"保存中");
    $.post(
            load_url, 
            {"page":'store_notice_setting',"fields_seria":fields_seria}, 
            function(data){
                if(data.status == '0') {
                    $('input.label_input').each(function() {
                        if ($(this).is(':checked')) {
                            $(this).next('label').addClass('notice_open').removeClass('notice_close');
                            $(this).next('label').find('span').text('已开启')
                        } else{
                            $(this).next('label').addClass('notice_close').removeClass('notice_open');
                            $(this).next('label').find('span').text('已关闭')
                        };
                    });
                    teaAlert('complete',"保存成功！");
                } else {
                    teaAlert('complete',"保存失败,请重试！")
                    var t = setTimeout(function () {
                        window.location.reload();
                    }, 500)
                }
            },
            'json'
        )
}
$(function(){
    location_page(location.hash);
    $('input.label_input').live('change', function() {
        saveNoticeform ()
    });
    $('.notice-nav a').live('click', function() {
        try {
            var mark_arr = $(this).attr("href").split("#");
            if (mark_arr[1]) {
                location_page("#" + mark_arr[1]);
            }
        } catch (e) {
            location_page(location.hash);
        }
    });
    function location_page(mark, dom) {
        var mark_arr = mark.split('/');
        switch (mark_arr[0]) {
            case '#notice_switch':
            $('.js-app-nav.notice_switch').addClass('active').siblings('.js-app-nav').removeClass('active');
            $(".notice-nav .notice_switch").addClass("active").siblings().removeClass("active");
            load_page('.app__content', load_url, {
                page: 'notice_switch'
            }, '', function() {
                $('input.label_input').each(function() {
                    var id= $(this).attr('id');
                    var c= $(this).attr('data-class');
                    $(this).after('<label class="notice_status_item '+c+'" for="'+id+'"><i class="notice_icon"></i><span></span></label>');
                    if ($(this).is(':checked')) {
                        $(this).next('label').addClass('notice_open')
                        $(this).next('label').find('span').text('已开启')
                    } else{
                        $(this).next('label').addClass('notice_close')
                        $(this).next('label').find('span').text('已关闭')
                    };
                });
            });
            break;
            case '#notice_recipient':
            $('.js-app-nav.notice_recipient').addClass('active').siblings('.js-app-nav').removeClass('active');
            $(".notice-nav .notice_recipient").addClass("active").siblings().removeClass("active");
            load_page('.app__content', load_url, {
                page: 'notice_recipient'
            }, '', function() {
            });
            break;
            case '#notice_sms':
            $('.js-app-nav.notice_sms').addClass('active').siblings('.js-app-nav').removeClass('active');
            $(".notice-nav .notice_sms").addClass("active").siblings().removeClass("active");
            load_page('.app__content', load_url, {
                page: 'notice_sms'
            }, '', function() {
            });
            break;
            default:
            $(".notice-nav .notice_switch").addClass("active").siblings().removeClass("active");
            $('.js-app-nav.notice_switch').addClass('active').siblings('.js-app-nav').removeClass('active');
            load_page('.app__content', load_url, {
                page: 'notice_switch'
            }, '', function() {
                $('input.label_input').each(function() {
                    var id= $(this).attr('id');
                    var c= $(this).attr('data-class');
                    $(this).after('<label class="notice_status_item '+c+'" for="'+id+'"><i class="notice_icon"></i><span></span></label>');
                    if ($(this).is(':checked')) {
                        $(this).next('label').addClass('notice_open')
                        $(this).next('label').find('span').text('已开启')
                    } else{
                        $(this).next('label').addClass('notice_close')
                        $(this).next('label').find('span').text('已关闭')
                    };
                });
                
            });

        }
    }
    $.fn.storeCateSelect = function () {
        var self = $(this);
        var fBox = $(".scb-li:eq(0)", self);
        var cBox = $(".scb-li:eq(1)", self);
        var fid = self.data("fid");
        var cid = self.data("cid");
        var fIpt = $('input[name="sale_category_fid"]', self);
        var cIpt = $('input[name="sale_category_id"]', self);

        var setObj = {
            init : function  () {

                $(".js-flabel", fBox).bind('click', function(){
                    var btn = $(this);
                    var cat_id = btn.data('cat_id');
                    btn.siblings(".selected").removeClass("selected").end().addClass("selected");
                    $(".js-clabel", cBox).hide();
                    $(".fid_"+cat_id, cBox).show();

                    if ($(".fid_"+cat_id, cBox).length > 0) {
                        cBox.show();
                    } else {
                        cBox.hide();
                    }

                    $(".js-clabel", cBox).removeClass("selected");
                    // $(".js-clabel input[name='sale_category_id']", cBox).attr('checked', false);
                    fIpt.val(cat_id);
                    cIpt.val(0);
                });

                $(".js-clabel", cBox).bind('click', function(){
                    var btn = $(this);
                    var cat_id = btn.data('cat_id');
                    btn.siblings(".selected").removeClass("selected").end().addClass("selected");
                    cIpt.val(cat_id);
                });

                $(".scb-cancel", fBox).bind('click', function(){
                    setObj.render();
                });

                setObj.render();
            },
            render : function () {

                $('.scb-label', cBox).hide();
                if (fid > 0) {
                    $('fid_'+fid).show();
                    $('.scb-label[data-cat_id="'+fid+'"]', fBox).siblings(".selected").removeClass("selected")
                        .end().addClass("selected");
                } else {
                    $('.scb-label', cBox).hide();
                }

                if (cid > 0) {
                    cBox.show();
                    $('.scb-label[data-cat_id="'+cid+'"]', cBox).siblings(".selected").removeClass("selected")
                        .end().addClass("selected").show();
                } else {
                    cBox.hide();
                }

                fIpt.val(fid);
                cIpt.val(cid);
            }
        };

        setObj.init();
        return setObj;

    }

    $('.js-category-edit').live("click",function(){
        $('.set-cate-block').show();
    });

})