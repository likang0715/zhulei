<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>退还货列表-<?php echo $store['name']; ?></title>
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/style.css" rel="stylesheet">
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
    <script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
    <script type="text/javascript">
        var now_page = 1;
        var is_ajax = false;
        var max_page;
        var page_url = 'drp_return.php?a=return&tab_num=1&ajax=1#return';
        var tab_num = 1;

        if(location.hash == '#return'){
            page_url = 'drp_return.php?a=return&tab_num=1&ajax=1#return';
        }else if(location.hash == '#rights'){
            page_url = 'drp_return.php?a=rights&tab_num=2&ajax=1#rights'
        }
        $(function(){
            FastClick.attach(document.body);
            $(window).scroll(function(){
                if(now_page > 1 && $(window).scrollTop() / ($('body').height() - $(window).height()) >= 0.95){
                    if(is_ajax == true){
                        if(typeof(max_page) != 'undefined'){
                            if(now_page <= max_page) {
                                if($('.wx_loading2').is(":hidden")) {
                                    getReturnOrRights();
                                }
                            }
                        }
                    }
                }
            });
            getReturnOrRights();
            function getReturnOrRights(){
                $('.wx_loading2').show();
                $.ajax({
                    type:"POST",
                    url: page_url,
                    data:'page='+now_page,
                    dataType:'json',
                    success:function(result){
                        var html = '';
                        if(result.err_code){
                            motify.log(result.err_msg);
                        }else{
                            if(result.err_msg.list.length > 0) {
                                for(var i=0;i<result.err_msg.list.length;i++){
                                    html += '<tr>';
                                    html += '<td class="clearfix">';
                                    html += '<div class="server_img"><img src="' + result.err_msg.list[i]['image'] + '"></div>';
                                    html += '<div class="server_text">';
                                    html += '<p>' + result.err_msg.list[i]['name'] + '</p>';
                                    html += '<p><span>￥' + result.err_msg.list[i]['pro_price'] + '</span></p>';
                                    html += '</div>';
                                    html += '</td>';
                                    html += '<td>';
                                    html += '<p class="state">' + result.err_msg.list[i]['status_txt'] + '</p>';
                                    html += '</td>';
                                    html += '<td>';
                                    if(location.hash == '#return'){
                                        html += '<a href="drp_return_detail.php?a=detail&type=return&id=' + result.err_msg.list[i]['id'] + '">详情</a>';
                                    }else if(location.hash == '#rights'){
                                        html += '<a href="drp_return_detail.php?a=detail&type=right&id=' + result.err_msg.list[i]['id'] + '">详情</a>';
                                    }

                                    html += '</td>';
                                    html += '</tr>';
                                }
                                if(location.hash == '#return'){
                                    $(".acticity_tu table > tbody").append(html);
                                }else if(location.hash == '#rights'){
                                    $(".acticity_wq table > tbody").append(html);
                                }

                                if(typeof(result.err_msg.noNextPage) == 'undefined'){
                                    is_ajax = false;
                                }else if(result.err_msg.noNextPage) {
                                    is_ajax = true;
                                }
                                max_page = result.err_msg.max_page;
                            }else{
                                $('.empty-list').show();
                            }
                            now_page ++;
                        }

                        $('.wx_loading2').hide();
                    },
                    error:function(){
                        $('.wx_loading2').hide();
                        //motify.log(label + 'dd' + '流水读取失败，<br/>请刷新页面重试',0);
                    }
                });
            }
        });
    </script>
</head>

<body>
<header class="header_title">
    <?php if($_COOKIE['wap_store_id']) {?>
        <a href="./ucenter.php?id=<?php echo $_COOKIE['wap_store_id'];?>#promotion" onclicks="javascript:history.go(-1);"><i></i></a>
    <?php } else {?>
        <a href="javascript:void(0)" onclicks="javascript:history.go(-1);"><i></i></a>
    <?php }?>
    <p>售后服务</p>
</header>
<nav class="title_table activity_title service_title" >
    <ul class="clearfix tab-num">
        <li id="return" class="active" data-tab="1"><a href="drp_return.php?a=return&tab_num=1&ajax=1#return">退款订单</a></li>
        <li id="rights" data-tab="2"><a href="drp_return.php?a=rights&tab_num=2&ajax=1#rights">维权订单</a></li>
    </ul>
</nav>
<article>
    <ul id="wrapper" class="acticity_list">
        <li class="acticity_tu">
            <section>
                <table class="service_table">
                    <thead>
                    <tr>
                        <th>商品</th>
                        <th>退货状态</th>
                        <th>查看</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>
        </li>
        <li class="acticity_wq" style="display:none;">
            <section>
                <table class="service_table">
                    <thead>
                    <tr>
                        <th>商品</th>
                        <th>维权状态</th>
                        <th>查看</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </section>
        </li>
    </ul>
    <div class="wx_loading2"></div>
</article>
<script>
    $(function(){
        if(location.hash == '#rights'){
            $('#rights').addClass('active');
            $('#rights').siblings('li').removeClass('active');
            $('.acticity_tu').css('display','none');
            $('.acticity_wq').removeAttr('style');
        }else if(location.hash == '#return'){
            $('#return').addClass('active');
            $('#return').siblings('li').removeClass('active');
            $('.acticity_wq').css('display','none');
            $('.acticity_tu').removeAttr('style');
        }
    });
</script>
</body>
</html>