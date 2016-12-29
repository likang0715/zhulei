/**
 * Created by ediancha on 2016/8/9.
 */
function location_page(mark, page){
    var mark_arr = mark.split('/');

    switch(mark_arr[0]){
        case '#create':
            load_page('.app__content', load_url, {page : 'banner_add' }, '');
            break;
        case "#edit":
            if(mark_arr[1]){
                load_page('.app__content', load_url,{page:'banner_edit', id : mark_arr[1]},'',function(){
                });
            }else{
                layer.alert('非法访问！');
                location.hash = '#list';
                location_page('');
            }
            break;
        default :
            load_page('.app__content', load_url, {page : 'banner_list' }, '');
    }
}
$(function(){

    location_page(location.hash, 1)

    // 分页
    $(".js-banner_list_page a").live("click", function () {
        var p = $(this).data("page-num");
        var type = window.location.hash.substring(1);

        load_page('.app__content',load_url,{ page:'banner_list' , 'type' : type, 'p' : p},'');
    })

    //添加店铺横幅广告
    $(".js-add-banner").live("click",function(){
        var type = window.location.hash.substring(1);

        load_page('.app__content',load_url,{ page:'banner_add'},'');
    })

    //修改店铺横幅广告
    $(".js-banner-edit").live("click",function(){
        $_this = $(this);
        var id = $_this.closest("tr").attr("id");

        load_page('.app__content', load_url,{page:'banner_edit', id : id},'',function(){});
    })

    //上传横幅广告图片
    $('.js-add-banner-picture').live('click',function(){
        if($('.js-img-list li').size() >= 1){
            layer_tips(1,'你已经上传横幅图片了');
            return false;
        }else{
            upload_pic_box(1,true,function(pic_list){
                if(pic_list.length > 0){
                    for(var i in pic_list){
                        var list_size = $('.js-img-list li').size();
                        if(list_size > 1){
                            layer_tips(1,'上传图片过多');
                            return false;
                        }else{
                            $('#pic').val(pic_list[i]);
                            $('.js-img-list').append('<li class="upload-preview-img"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
                        }
                    }
                }
            },1);
        }
    });
    $('.js-delete-picture').live('click',function(){
        $(this).closest('li').remove();
    });

    //点击执行保存
    $(".js-banner-save").live("click", function () {
        var name = $("#name").val();
        var pic = $("#pic").val();
        var url = $("#url").val();

        if (pic.length == 0) {
            layer_tips(1, '请上传横幅图片');
            return false;
        };
        if (url.length == 0) {
            layer_tips(1, '请填写横幅链接地址');
            $("#url").focus();
            return false;
        };

        $.post("/user.php?c=case&a=do_banner_add",
            {
                "name" : name,
                "pic" : pic,
                "url" : url,
            }, function (data) {
                if (data.err_code == '0') {
                    layer_tips(0, data.err_msg);
                    var t = setTimeout(presentList(), 2000);
                    return;
                } else {
                    layer_tips(1, data.err_msg);
                    return;
                }
        });
    });

    //点击执行编辑
    $(".js-banner-edit-save").live("click", function () {
        var id = $("#id").val();
        var name = $("#name").val();
        var pic = $("#pic").val();
        var url = $("#url").val();

        if (pic.length == 0) {
            layer_tips(1, '请上传横幅图片');
            return false;
        };
        if (url.length == 0) {
            layer_tips(1, '请填写横幅链接地址');
            $("#url").focus();
            return false;
        };

        $.post("/user.php?c=case&a=do_banner_edit",
            {
                "id" : id,
                "name" : name,
                "pic" : pic,
                "url" : url,
            }, function (data) {
                if (data.err_code == '0') {
                    layer_tips(0, data.err_msg);
                    var t = setTimeout(presentList(), 2000);
                    return;
                } else {
                    layer_tips(1, data.err_msg);
                    return;
                }
            });
    });

    function presentList() {
        location.href = "user.php?c=case&a=banner";
    }

    //启用关闭店铺横幅广告
    $('.js-change-status').live('click', function(){
        var $_this = $(this);
        var id = $_this.closest("tr").attr("id");
        var state = $_this.attr("data-status");
        if(state==0){
            var u_count = 0;
            $('.js-change-status').each(function(i,v){
                if($('.js-change-status').eq(i).attr("data-status")==1){
                    u_count = u_count + 1;
                }
            });
            if(u_count==3){
                layer_tips(1, "最多启用3个横幅广告！");return false;
            }
            value = 1;
        }else if(state==1){
            value = 0;
        };
        $.ajax({
            type:"POST",
            url:"/user.php?c=case&a=do_banner_editone",
            dataType:"json",
            data:{
                type:"status" ,
                id:id ,
                value:value ,
            },
            success:function(data){
                if(data.err_code == 0){
                    $_this.attr("data-status",0);
                    $_this.children("span").css('color','#808080');
                    $_this.children("span").text("关闭");
                    $(".status").text("关闭");
                    layer_tips(0, data.err_msg);
                }else if(data.err_code == 1){
                    $_this.attr("data-status",1);
                    $_this.children("span").css('color','#07d');
                    $(".status").text("启用");
                    $_this.children("span").text("启用");
                    $(".status").text();
                    layer_tips(0, data.err_msg);
                }else{
                    layer_tips(1, data.err_msg);
                }
            }
        });
    });

    //删除店铺横幅广告
    $('.js-change-delete').live('click', function(){
        var $_this = $(this);
        var id = $_this.closest("tr").attr("id");
        $.ajax({
            type:"POST",
            url:"/user.php?c=case&a=do_banner_editone",
            dataType:"json",
            data:{
                type:"status" ,
                id:id ,
                value:2 ,
            },
            success:function(data){
                if(data.err_code == 2){
                    layer_tips(0, "删除成功");
                    $_this.closest("tr").remove();
                }else{
                    layer_tips(1, "删除失败");
                }
            }
        });
    });
});
