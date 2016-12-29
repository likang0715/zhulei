/**
 * Created by Administrator on 2015/12/4.
 */
$(function(){
    load_page('.app__content',load_url,{page:'promotional_list'},'', function(){

    });

    //删除
    $('.js-cancel-to-fx').live('click', function(e){
        var pigcms_id = $(this).data('id');
        button_box($(this), e, 'left', 'confirm', '确认删除？', function(){
            $.post(delete_url, {'pigcms_id': pigcms_id}, function(data){
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">删除成功</div>');
                    setTimeout('history.go(0)',1000);//延时1秒
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">删除失败</div>');
                    setTimeout('history.go(0)',1000);//延时1秒
                }
            });
        });
    });

    //开启海报
    $('.js-enable-up').live('click', function(e){
        var pigcms_id = $(this).data('id');
        var type = 1;
        button_box($(this), e, 'left', 'confirm', '确认开启？', function(){
            $.post(enable_url, {'pigcms_id': pigcms_id,'type': type}, function(data){
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">开启成功</div>');
                    setTimeout('history.go(0)',1000);//延时1秒
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">开启失败</div>');
                    setTimeout('history.go(0)',1000);//延时1秒
                }
            });
        });
    });

    //关闭海报
    $('.js-enable-down').live('click', function(e){
        var pigcms_id = $(this).data('id');
        var type = 0;
        button_box($(this), e, 'left', 'confirm', '确认关闭？', function(){
            $.post(enable_url, {'pigcms_id': pigcms_id, 'type': type}, function(data){
                close_button_box();
                if (data.err_code == 0) {
                    $('.notifications').html('<div class="alert in fade alert-success">关闭成功</div>');
                    setTimeout('history.go(0)',1000);//延时1秒
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">关闭失败</div>');
                    setTimeout('history.go(0)',1000);//延时1秒
                }
            });
        });
    });


    $('.js-enable-up').live('mouseover', function(e){
        var text = $(this).text();
        if(text == '未启用')
        {
            $(this).text('启　用');
        }
    });

    $('.js-enable-up').live('mouseout',function(){
        var text = $(this).text();
        if(text == '启　用'){
            $(this).text('未启用');
        }
    });

    $('.js-enable-down').live('mouseover', function(e){
        var text = $(this).text();
        if(text == '已启用')
        {
            $(this).text('关　闭');
        }
    });

    $('.js-enable-down').live('mouseout',function(){
        var text = $(this).text();
        if(text == '关　闭'){
            $(this).text('已启用');
        }
    });

    $('.js-search-btn').live('click', function(){
        keyword = $.trim($('.filter-box-search').val());           /* 海报名称 */
        load_page('.app__content', load_url, {page:'promotional_list','keyword': keyword}, '', function(){
            if(keyword != ''){
                $('.filter-box-search').val(keyword);
            }
        });
    });

    /*$('.js-add-picture').live('click',function(){
        upload_pic_box(1,true,function(pic_list){
            if(pic_list.length > 0){
                for(var i in pic_list){
                    var list_size = $('.js-picture-list .sort').size();
                    if(list_size == 1){
                        layer_tips(1,'商品图片最多支持 1 张');
                        return false;
                    }else if(list_size > 0){
                        $('.js-picture-list .sort:last').after('<li class="sort"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
                    }else{
                        $('.js-picture-list').prepend('<li class="sort"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
                    }
                }
            }
        },15);
    });

    //删除图片
    $('.js-delete-picture').live('click', function(){
        $(this).closest('li').remove();
    });

    $('.ui-btn-preview').live('click',function(){
        var title = $('.contact-name').val();
        if(title.length == 0){
            layer_tips(1, '标题不能为空');
            $('.contact-name').focus();
            return false;
        }

        var content = $('.input-intro').val();
        if(content.length == 0){
            layer_tips(1, '简介不能为空');
            $('.input-intro').focus();
            return false;
        }

        var image = $('.app-image-list > .sort > a > img').attr('src');
        //alert(image);
        if(image == undefined){
            layer_tips(1, '请上传图片');
            $('.js-add-picture').css('border', '1px dotted red');
            return false;
        }

        var description = $('.description').val();
        if(description.length == 0){
            layer_tips(1, '尾语不能为空');
            $('.description').focus();
            return false;
        }

        $('.con_h1').text(title);
        $('.con_h2').text(content);
        $('.shou_end').text(description);
        $('.shou_con').css("background-image","url('" + image + "')");
        //$('.shou_con').css("background-repeat","no-repeat");
        $('.shou_con').css("background-size","cover");
    });
    $('.ui-btn-primary').live('click',function(){
        var title = $('.contact-name').val();
        if(title.length == 0){
            layer_tips(1, '标题不能为空');
            $('.contact-name').focus();
            return false;
        }

        var content = $('.input-intro').val();
        if(content.length == 0){
            layer_tips(1, '简介不能为空');
            $('.input-intro').focus();
            return false;
        }

        var image = $('.app-image-list > .sort > a > img').attr('src');
        //alert(image);
        if(image == undefined){
            layer_tips(1, '请上传图片');
            $('.js-add-picture').css('border', '1px dotted red');
            return false;
        }

        var description = $('.description').val();
        if(description.length == 0){
            layer_tips(1, '尾语不能为空');
            $('.description').focus();
            return false;
        }

        $.post(save_url, {'title': title, 'content': content, 'image': image, 'description': description}, function(data) {
            if (data.err_code == 0) {
                $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                  location.reload();
            } else {
                $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                  location.reload();
            }
        })

    });*/
});