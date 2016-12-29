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
            case '#courier_list':
                $(".dianpu_left .list:eq(1)").addClass("active").siblings().removeClass("active");
                $('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'courier_list'}, '');
                break;
            case '#courier_add':
                $('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'courier_create'}, '',function(){

                });
                break;
            case '#courier_edit':
                $('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
                if(mark_arr[1]){
                    load_page('.app__content', load_url,{page:'courier_edit',courier_id:mark_arr[1]},'',function(){
                    });
                }else{
                    layer.alert('非法访问！');
                    location.hash = '#courier_list';
                    location_page('');
                }
                break;
            default:
                $('.js-app-nav.list').addClass('active').siblings('.js-app-nav').removeClass('active');
                load_page('.app__content', load_url,{page:'courier_list'}, '');

        }
    }


    $('.physical_list .js-delete').live('click',function(e){
        var courier_id = $(this).attr('data-id');
        var self = $(this);
        button_box($(this), e, 'left', 'confirm', '确定删除？', function(){
            $.post(courier_del, {'courier_id': courier_id}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    self.parents("tr:first").remove();
                    // window.location.reload();
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
                close_button_box();
            });
        });
    });

    $('.js-choose-bg').live('click',function(){
        var dom = $(this);
        upload_pic_box(1,true,function(pic_list){
            for(var i in pic_list){
                $('.avatar_show').attr('src',pic_list[i]);
                $('input[name=avatar]').val(pic_list[i]);
            }
        },1);
    });

    $('.submit-btn').live('click',function(){
        var avatar  = $('input[name=avatar]').val();
        var name    = $.trim($('input[name=name]').val());
        var sex    = $('input[name=sex]:checked').val();
        var tel         = $('input[name=tel]').val();
        var courier_id  = $('input[name=courier_id]').val();
        var physical_select = $('select[name=physical_id]');
        var physical_id = 0;

        if (physical_select.length > 0) {
            var physical_id = $('select[name=physical_id]').val();
        }

        var telReg      = /^1[1-9][0-9]{9}$/;
        var flag    = true;

        if(avatar == ''){
            layer_tips(1,'配送员头像必须上传');
            flag    = false;
            return flag;
        }
        
        if(name == ''){
            layer_tips(1,'配送员姓名必须填写');
            flag    = false;
            return flag;
        }
        
        if(!telReg.test(tel)){
            layer_tips(1,'请填写正确的手机号码');
            flag    = false;
            return flag;
        }

        if(physical_select.length > 0 && physical_id == 0){
            layer_tips(1,'请选择一个门店');
            flag    = false;
            return flag;
        } 

        var post_data   = {
            avatar : avatar,
            name : name,
            sex : sex,
            tel : tel,
            courier_id : courier_id,
            physical_id : physical_id
        };


        if(flag){
            $.post(courier_create,post_data,function(res){
                if(res == ''){
                    layer_tips(1,'请修改选项后再提交');      
                }else{
                    if(res.err_code == 0){
                        layer_tips(0,res.err_msg);
                        setTimeout(function(){
                            window.location=default_url;
                        },1000);
                    }else{
                        layer_tips(1,res.err_msg);
                    }
                }   
            });
        }
        
        return false;
    });    

    $('.bind_qrcode').live('click',function(){
        $.layer({
            type: 2,
            title: false,
            shadeClose: true,
            shade: [0.4, '#000'],
            area: ['330px','430px'],
            border: [0],
            iframe: {src:'./user.php?c=substore&a=bind_qrcode'}
        });
    });

})


function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}