$(function(){

    function location_page(mark, page){
        var mark_arr = mark.split('/');

        switch(mark_arr[0]){
            case '#create':
                load_page('.app__content', load_url, {page : 'bargain_add' }, '');
                load_widget_link_box();
                break;
            case "#edit":
                if(mark_arr[1]){
                    load_page('.app__content', load_url,{page:'bargain_edit', id : mark_arr[1]},'',function(){
                    });
                }else{
                    layer.alert('非法访问！');
                    location.hash = '#list';
                    location_page('');
                }
                load_widget_link_box();
                break;
            default :
                load_page('.app__content', load_url, {page : 'bargain_list' }, '');
                load_widget_link_box();
                break;
        }
    }

    location_page(location.hash, 1)

    //回车提交搜索
    $(window).keydown(function(event){
        if (event.keyCode == 13 && $('.js-bargain-keyword').is(':focus')) {
            var keyword = $('.js-bargain-keyword').val();
            var type = window.location.hash.substring(1);

            load_page('.app__content',load_url,{ page:'bargain_list' , 'keyword':keyword , 'type' : type },'');
        }
    });

    // 分页
    $(".js-bargain_list_page a").live("click", function () {
        var p = $(this).data("page-num");
        var keyword = $('.js-bargain-keyword').val();
        var type = window.location.hash.substring(1);

        load_page('.app__content',load_url,{ page:'bargain_list' , 'keyword' : keyword, 'type' : type, 'p' : p},'');
    })

    //添加砍价商品
    $(".btn-bargain-add").live("click",function(){
        var type = window.location.hash.substring(1);

        load_page('.app__content',load_url,{ page:'bargain_add' , 'type' : type },'');
    })

    //修改砍价商品
    $(".btn-bargain-edit").live("click",function(){
        location_page($(this).attr("href"));
    })

    //选择店铺商品
    function load_widget_link_box() {

        widget_link_box1($(".js-select-product"), "store_goods_by_sku", function (result) {
            var good_data = pic_list;
            $('.js-goods-list .sort').remove();
            for (var i in result) {
                item = result[i];
                var pic_list = "";
                var list_size = $('.js-product .sort').size();
                if(list_size > 0){
                    layer_tips(1, '砍价活动只能添加一件商品！');
                    return false;
                }

                $("input[name=name]").val(item.title);
                $("input[name=product_id]").val(item.product_id);
                $("input[name=image]").val(item.image);
                $("input[name=original]").val(item.price);
                $("input[name=url]").val(item.url);
                $("input[name=inventory]").val(item.quantity);
                $("input[name=logoimg1]").val(item.image);
                $("input[name=logoimg2]").val(item.image);
                $("input[name=logoimg3]").val(item.image);
                $("input[name=sku_id]").val(item.sku_id);
            }
        });

    }

    //添加砍价微信预览图
    $('.js-add-wxpic').live('click',function(){
        upload_pic_box(1,true,function(pic_list){
            /*console.log(pic_list.length);
            if(pic_list.length > 1){
                alert("微信图片信息图片只能上传一张图片");
                return false;
            }else{*/
                for(var i in pic_list){
                    $("img[id='wxpic_src']").attr("src",pic_list[i]);
                    $("input[id='wxpic']").val(pic_list[i]);
                }
            //}
        }, 8);
    });

    //点击执行保存
    $(".js-btn-save").live("click", function () {
        var product_id = $("#product_id").val();
        var sku_id = $("#sku_id").val();
        var keyword = $("#keyword").val();
        var name = $("#name").val();
        var wxtitle = $("#wxtitle").val();
        var wxinfo = $("#wxinfo").val();
        var wxpic = $("#wxpic").val();
        var logoimg1 = $("#logoimg1").val();
        var logoimg2 = $("#logoimg2").val();
        var logoimg3 = $("#logoimg3").val();
        var starttime = parseInt($("#starttime").val());
        var original = parseFloat($("#original").val());
        var minimum = parseFloat($("#minimum").val());
        var kan_min = parseFloat($("#kan_min").val());
        var kan_max = parseFloat($("#kan_max").val());
        var rank_num = parseInt($("#rank_num").val());
        var guize = ug.getContent();
        var inventory = $("#inventory").val();
        var is_attention = $("input[name='is_attention']:checked").val();
        var is_subhelp = $("input[name='is_subhelp']:checked").val();
        var hash = $("#hash").val();

        if (keyword.length == 0) {
            layer_tips(1, '关键字没有填写，请填写');
            $("#keyword").focus();
            return false;
        };
        if (name.length == 0) {
            layer_tips(1, '请选择砍价商品');
            return false;
        };
        if (wxtitle.length == 0) {
            layer_tips(1, '微信分享标题没有填写，请填写');
            $("#wxtitle").focus();
            return false;
        };
        if (isNaN(starttime)) {
            layer_tips(1, '每人砍价时间未填写，请填写');
            $("#starttime").focus();
            return false;
        };
        if (starttime <= 0 || starttime >= 2376) {
            layer_tips(1, '每人砍价时间填写不正确，请重新填写');
            $("#starttime").focus();
            return false;
        };
        if (isNaN(original)) {
            layer_tips(1, '商品原价未填写，请填写');
            $("#original").focus();
            return false;
        };
        if(original<0) {
            layer_tips(1, '商品原价不能为负，请重新填写');
            $("#original").focus();
            return false;
        };
        if (isNaN(minimum)) {
            layer_tips(1, '商品底价未填写，请填写');
            $("#minimum").focus();
            return false;
        };
        if(minimum<0) {
            layer_tips(1, '商品底价不能为负，请重新填写');
            $("#original").focus();
            return false;
        };
        if (original <= minimum) {
            layer_tips(1, '商品底价不能大于原价，请填写');
            $("#minimum").focus();
            return false;
        };
        if (isNaN(kan_min) || isNaN(kan_max)) {
            layer_tips(1, '砍价范围未填写，请填写');
            $("#kan_max").focus();
            return false;
        };
        if (kan_min<0 || kan_max<0) {
            layer_tips(1, '砍价范围不能为负数，请重新填写');
            $("#kan_max").focus();
            return false;
        };
        if (kan_min >= kan_max) {
            layer_tips(1, '砍价范围设置不正确');
            $("#kan_max").focus();
            return false;
        };
        if (kan_max > original - minimum) {
            layer_tips(1, '砍价最大值不能大于原价减底价');
            $("#kan_max").focus();
            return false;
        };
        if(isNaN(rank_num)){
            rank_num = 10;
        };
        if(rank_num<0){
            rank_num = 10;
        };

        $.post("/user.php?c=bargain&a=_bargain_create",
            {
                "product_id" : product_id,
                "sku_id" : sku_id,
                "keyword" : keyword,
                "name" : name,
                "wxtitle" : wxtitle,
                "wxinfo" : wxinfo,
                "wxpic" : wxpic,
                "logoimg1" : logoimg1,
                "logoimg2" : logoimg2,
                "logoimg3" : logoimg3,
                "starttime" : starttime,
                "original" : original,
                "minimum" : minimum,
                "kan_min" : kan_min,
                "kan_max" : kan_max,
                "rank_num" : rank_num,
                "inventory" : inventory,
                "guize" : guize,
                "is_attention" : is_attention,
                "is_subhelp" : is_subhelp,
                "is_submit" : "submit",
                "hash" : hash
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

    //点击执行编辑保存
    $(".js-btn-edit").live("click", function () {
        var pigcms_id = $("#pigcms_id").val();
        var product_id = $("#product_id").val();
        var sku_id = $("#sku_id").val();
        var keyword = $("#keyword").val();
        var name = $("#name").val();
        var wxtitle = $("#wxtitle").val();
        var wxinfo = $("#wxinfo").val();
        var wxpic = $("#wxpic").val();
        var logoimg1 = $("#logoimg1").val();
        var logoimg2 = $("#logoimg2").val();
        var logoimg3 = $("#logoimg3").val();
        var starttime = parseInt($("#starttime").val());
        var original = parseFloat($("#original").val());
        var minimum = parseFloat($("#minimum").val());
        var kan_min = parseFloat($("#kan_min").val());
        var kan_max = parseFloat($("#kan_max").val());
        var rank_num = parseInt($("#rank_num").val());
        var guize = ug.getContent();
        var inventory = $("#inventory").val();
        var is_attention = $("input[name='is_attention']:checked").val();
        var is_subhelp = $("input[name='is_subhelp']:checked").val();

        if (keyword.length == 0) {
            layer_tips(1, '关键字没有填写，请填写');
            $("#keyword").focus();
            return false;
        };
        if (name.length == 0) {
            layer_tips(1, '请选择砍价商品');
            return false;
        };
        if (wxtitle.length == 0) {
            layer_tips(1, '微信分享标题没有填写，请填写');
            $("#wxtitle").focus();
            return false;
        };
        if (isNaN(starttime)) {
            layer_tips(1, '每人砍价时间未填写，请填写');
            $("#starttime").focus();
            return false;
        };
        if (starttime <= 0 || starttime >= 2376) {
            layer_tips(1, '每人砍价时间填写不正确，请重新填写');
            $("#starttime").focus();
            return false;
        };
        if (isNaN(original)) {
            layer_tips(1, '商品原价未填写，请填写');
            $("#original").focus();
            return false;
        };
        if(original<0) {
            layer_tips(1, '商品原价不能为负，请重新填写');
            $("#original").focus();
            return false;
        };
        if (isNaN(minimum)) {
            layer_tips(1, '商品底价未填写，请填写');
            $("#minimum").focus();
            return false;
        };
        if(minimum<0) {
            layer_tips(1, '商品底价不能为负，请重新填写');
            $("#original").focus();
            return false;
        };
        if (original <= minimum) {
            layer_tips(1, '商品底价不能大于原价，请填写');
            $("#minimum").focus();
            return false;
        };
        if (isNaN(kan_min) || isNaN(kan_max)) {
            layer_tips(1, '砍价范围未填写，请填写');
            $("#kan_max").focus();
            return false;
        };
        if (kan_min<0 || kan_max<0) {
            layer_tips(1, '砍价范围不能为负数，请重新填写');
            $("#kan_max").focus();
            return false;
        };
        if (kan_min >= kan_max) {
            layer_tips(1, '砍价范围设置不正确');
            $("#kan_max").focus();
            return false;
        };
        if (kan_max > original - minimum) {
            layer_tips(1, '砍价最大值不能大于原价减底价');
            $("#kan_max").focus();
            return false;
        };
        if(isNaN(rank_num)){
            rank_num = 10;
        };
        if(rank_num<=0){
            rank_num = 10;
        };

        $.post("/user.php?c=bargain&a=_do_bargain_edit",
            {
                "pigcms_id" : pigcms_id,
                "product_id" : product_id,
                "sku_id" : sku_id,
                "keyword" : keyword,
                "name" : name,
                "wxtitle" : wxtitle,
                "wxinfo" : wxinfo,
                "wxpic" : wxpic,
                "logoimg1" : logoimg1,
                "logoimg2" : logoimg2,
                "logoimg3" : logoimg3,
                "starttime" : starttime,
                "original" : original,
                "minimum" : minimum,
                "kan_min" : kan_min,
                "kan_max" : kan_max,
                "rank_num" : rank_num,
                "inventory" : inventory,
                "guize" : guize,
                "is_attention" : is_attention,
                "is_subhelp" : is_subhelp,
                "is_submit" : "submit"
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
        location.href = "user.php?c=bargain&a=index";
    }

    $('.js-trigger-image').live('click', function(){
        $_this = $(this);
        var pigcms_id = $_this.closest("tr").attr("pigcms_id");
        var state = $_this.children('.state').val();
        if(state==0){
            value = 1;
        }else if(state==1){
            value = 0;
        };
        $.ajax({
            type:"POST",
            url:"/user.php?c=bargain&a=edit_one&token=ijpows1454304142",
            dataType:"json",
            data:{
                type:"state" ,
                pigcms_id:pigcms_id ,
                value:value ,
                token:"ijpows1454304142"
            },
            success:function(data){
                if(data.error == 0){
                    $_this.children('.state').val(0);
                    $("#state"+pigcms_id).attr("src",STATIC_URL+"images/stop.png");
                }else if(data.error == 1){
                    $_this.children('.state').val(1);
                    $("#state"+pigcms_id).attr("src",STATIC_URL+"images/start.png");
                }else{
                    alert(data.msg);
                }
            }
        });
    });
});

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}
