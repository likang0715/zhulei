<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户平台积分释放流水</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/my_store_withdrawal.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/common_datepick.css">
    <script src="<?php echo TPL_URL;?>js/jquery.js"></script>
    <script src="<?php echo TPL_URL;?>js/date.js"></script>
    <script src="<?php echo TPL_URL;?>js/iscroll.js"></script>
    <style type="text/css">
        .search-order-right {
            width: 155px;
        }
        .search-order-con {
            width: 70px;
            margin-top: 10px;
        }
        .empty-list {
            font-size: 14px;
            display: block;
            text-align: center;
            padding: 30px 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <ul class="search-list">
        <li>
            <div class="fl search-list-tit">开始时间</div>
            <div class="fr ">
                <span class="fl search-time" id="beginTime">请选择</span>
                <span class="icon-angle-right icon-2x fr"></span>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </li>
        <li>
            <div class="fl search-list-tit">结束时间</div>
            <div class="fr ">
                <span class="fl search-time" id="endTime">请选择</span>
                <span class="icon-angle-right icon-2x fr"></span>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </li>
    </ul>
<div class="btn search-btn">查询</div>
<ul class="search-order">
<!--内容ajax动态加载-->
</ul>
    <div class="wx_loading2"></div>
    <div class="empty-list list-finished" style="padding-top:60px;display: none;">
        <div>
            <h4>居然还没有积分释放记录</h4>
            <p class="font-size-12">加油！加油！……  (/ □ \)</p>
        </div>
    </div>
    <div id="datePlugin"></div>
    <script type="text/javascript">
        $(function(){
            $('#beginTime').date();
            $('#endTime').date();

            var now_page = 1;
            var is_ajax = false;
            var max_page;

            $(window).scroll(function(){
                if(now_page > 1 && $(window).scrollTop() / ($('body').height() - $(window).height()) >= 0.95){
                    if(is_ajax == true){
                        if(typeof(max_page) != 'undefined'){
                            if(now_page <= max_page) {
                                if($('.wx_loading2').is(":hidden")) {
                                    getReleases();
                                }
                            }
                        }
                    }
                }
            });

            function getReleases() {
                var start_time = '';
                var end_time = '';
                if ($('#beginTime').text() != '请选择') {
                    start_time = $('#beginTime').text();
                }
                if ($('#endTime').text() != '请选择') {
                    end_time = $('#endTime').text();
                }
                $('.wx_loading2').show();
                $.post("my_point.php?action=release", {'start_time': start_time, 'end_time': end_time, 'page': now_page}, function(data) {
                    if(data.err_code){
                        motify.log(data.err_msg);
                    } else {
                        if (data.err_msg.list != undefined && data.err_msg.list.length > 0) {
                            var str = '';
                            for(var i in data.err_msg.list){
                                var release = data.err_msg.list[i];
                                str += '<li>';
                                str += '    <div class="fl search-order-left">';
                                str += '        <p>单号：<span title="' + release['order_no'] + '">' + release['order_no'] + '</span></p>';
                                str += '        <p class="grey">时间：' + release['add_time'] + '</p>';
                                str += '    </div>';
                                str += '    <div class="fl search-order-right">';
                                str += '        <p>消费积分：' + release['send_point'] + '</p>';
                                str += '        <p class="orange">可用积分：' + release['point'] + '</p>';
                                str += '    </div>';
                                str += '    <div class="clear"></div>';
                                str += '</li>';
                            }
                            $(".search-order").append(str);

                            if(typeof(data.err_msg.noNextPage) == 'undefined'){
                                is_ajax = false;
                            }else if(data.err_msg.noNextPage) {
                                is_ajax = true;
                            }
                            max_page = data.err_msg.max_page;
                        } else {
                            $('.empty-list').show();
                        }
                        now_page ++;
                    }
                    $('.wx_loading2').hide();
                })
            }

            $('.search-btn').click(function() {
                now_page = 1;
                is_ajax = false;
                $(".search-order").html('');
                $('.empty-list').hide();
                getReleases();
            }).trigger('click');
        });
    </script>
</body>
</html>