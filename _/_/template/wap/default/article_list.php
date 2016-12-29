<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimum-scale=1.0,maximum-scale=1.0,minimal-ui">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<title>店铺动态</title>
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/article/base.css">
<link rel="stylesheet" href="<?php echo TPL_URL;?>css/article/shopIndex.css"  type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/article/swiper.min.css">
</head>

<body style="background:#f9f9f9">
<div class="shopDynamic" id="shopDynamic"></div>
<input type="hidden" id="page" value="1" />
<input type="hidden" id="hasmore" value="1" />
<input type="hidden" id="default_article" value="<?php echo $aid?>"/>
</body>
<script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo  STATIC_URL?>js/layer_mobile/layer.m.js"></script>
<script type="text/javascript">
var flag_scroll = true;
$('#page').val(1);
$('#hasmore').val(1);
// 加载动态
load_articles();

// 添加/删除收藏
function collections(obj){
    var aid = $(obj).attr('aid');
    var store_id = $(obj).attr('store_id');
    $.post('/wap/article.php?action=collect',{'aid':aid,'store_id':store_id},function(response){
        if(response.err_code>0){
            layer.open({title:["系统提示","background-color:#FF6600;color:#fff;"],content: response.err_msg});
            return;
        }
        var isactive = $(obj).find("i").hasClass('active');
        var collect_count = parseInt($(obj).find('label').text());
        if(isactive){
            $(obj).find("i").removeClass('active');
            $(obj).find('label').text(collect_count-1);
        }else{
            $(obj).find("i").addClass("active");
            $(obj).find('label').text(collect_count+1);
        }
    },'json');
}

// 加载动态
function load_articles(){
    var hasmore = parseInt($('#hasmore').val());
    if(hasmore==0){
        return;
    }
    var page = parseInt($('#page').val());
    var default_article = 0;
    if(page == 1){
        default_article = $('#default_article').val();
    }
    $.get('/wap/article.php?action=index&is_ajax=1',{'page':page,'hasmore':hasmore,'aid':default_article},function(response){
        if(response.err_code!=0){
            return;
        }
        var html = $('#shopDynamic').html();
        $('#shopDynamic').html(html+response.err_msg.html);
        $('#hasmore').val(response.err_msg.hasmore);
        flag_scroll = true;
    },'json');
}

$(function(){
    //滚动分页
    $(window).on("scroll",function(){
        if(flag_scroll==false){
            return;
        }
        var heights = $(window).scrollTop()+$(window).height();
        if($("#shopDynamic").height() <= $(window).scrollTop()+$(window).height()){
            var page = parseInt($('#page').val());
            $('#page').val(page+1);
            load_articles();
            flag_scroll = false;
        }
    });
});

</script>
</html>


