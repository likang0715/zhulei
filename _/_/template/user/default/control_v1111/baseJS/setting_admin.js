/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t;
$(function(){
    location_page(location.hash);
    $('.dianpu_left a').live('click',function(){
        try {
            var mark_arr = $(this).attr("href").split("#");
            location_page("#" + mark_arr[1]);
        } catch(e) {
            location_page(location.hash);
        }
    });
    //用户中心左侧菜单专用
    $(".dianpu a").live('click',function(){
        var marks2 = $(this).attr('href').split('#');
        if(marks2[1]) {
            if($(this).attr('href')) location_page("#"+marks2[1],$(this));
        }
    })


    function location_page(mark,dom){
        var mark_arr = mark.split('/');
        switch(mark_arr[0]){
            case '#list':
                $(".dianpu_left .list:eq(1)").addClass("active").siblings().removeClass("active");
                $('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'list_admin_content'}, '');
                break;
            case '#add_admin':
                $('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'set_admin_content'}, '',function(){

                });
                break;
            case '#store_admin_edit':
                $('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'store_admin_edit',uid:mark_arr[1]}, '',function(){

                });
                break;
            default:
                $(".dianpu_left .info").addClass("active").siblings().removeClass("active");
                $('.js-app-nav.info').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'store_content'}, '');

        }
    }


    $('.physical_list .js-delete').live('click',function(e){
        var uid = $(this).attr('data-id');
        button_box($(this), e, 'left', 'confirm', '确定删除？', function(){
            $.post(store_admin_del, {'uid': uid}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    window.location.reload();
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
                close_button_box();
            });
        });
    });


})


function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}