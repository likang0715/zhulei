<!DOCTYPE html>
<html>
<head>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>分销店铺 - 我的粉丝</title>
    <link href="<?php echo TPL_URL;?>css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/style.css" rel="stylesheet">
    <script src="<?php echo TPL_URL;?>ucenter/js/jQuery.js"></script>
    <script src="<?php echo TPL_URL;?>js/base.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>ucenter/js/jqplot.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL; ?>js/dialog.js"></script>
    <script type="text/javascript">
        var max_page = parseInt("<?php echo $max_page; ?>");
        var page = 2;
        var page_url = './drp_fans.php?ajax=1';
        var is_ajax = false;
    </script>
    <style type="text/css">
        .fans .fans_titel {
            background: #F9F9F9;
            height: 43px;
            line-height: 43px;
        }
        .header_title {
            background: #F15A0C;
        }
        .fans_list > ul {
            margin: .5rem 0;
        }
        .fans .fans_list li {
            border-right: 1px solid #eee;
        }
        .fans .fans_list .fans-detail {
            border: none;
        }
        .table-title > .fans-detail {
            color: grey;
            height: 40px;
            line-height: 40px!important;
            padding: 0!important;
        }
        .seller-tag {
            margin-top:2px;
            display: inline-block;
            border: 1px solid #FF6D3E;
            border-radius:3px;
            color:#FF6D3E!important;
            padding: 2px;
            width: 50px;
            text-align: center;
            font-size: 0.4rem;
        }
        .member-tag {
            margin-top:2px;
            display: inline-block;
            border: 1px solid lightgrey;
            border-radius:3px;
            color:lightgrey!important;
            padding: 2px;
            width: 50px;
            text-align: center;
            font-size: 0.4rem;
        }
        .tab {
            margin-top: 10px;
            border-bottom: 1px solid #F15A0C;
        }
        .fans_titel {
            float: left;
            width: 50%;
            padding-left: 0!important;
            text-align: center;
        }
        .active {
            background: #F15A0C!important;
            color: white!important;
            font-weight: bold;
        }
        .empty-list {
            font-size: 14px;
            display: block;
            text-align: center;
            padding: 30px 10px;
            color: #999;
        }
        h4 {
            margin: 0;
            padding: 0;
            font: inherit;
            font-size: 100%;
        }
        .empty-list h4 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666;
        }
        .empty-list div {
            margin-bottom: 20px;
        }
        .tag {
            display: inline-block;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 3px;
            text-align: center;
            margin: 0;
            color: #999;
            font-size: 12px;
            line-height: 12px;
            padding: 4px;
        }
        .tag-big {
            font-size: 14px;
            line-height: 18px;
        }
        .tag.tag-orange {
            color: #f60;
            border-color: #f60;
        }
        .font-size-12 {
            font-size: 12px !important;
        }
        .pop-dialog {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 999;
        }
        .pop-dialog .bg {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.9;
            background-color: #000;
        }
        .pop-dialog .body {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }
        .js-dialog-link .collect-img {
            right: 20px!important;
        }
        .pop-dialog .body .collect-img {
            width: 90%;
            position: absolute;
            right: 0;
            top: 0;
        }
        .wx_loading2{width:100%;  height:50px; background:url(<?php echo TPL_URL;?>images/loading-0.gif) center center no-repeat;display: none;}
    </style>
</head>

<body>
<header class="header_title">
    <?php if($_COOKIE['wap_store_id']) {?>
        <a href="./ucenter.php?id=<?php echo $_COOKIE['wap_store_id'];?>#promotion" onclick="javascript:history.go(-1);"><i></i></a>
    <?php } else {?>
        <a href="javascript:void(0)" onclick="javascript:history.go(-1);"><i></i></a>
    <?php }?>
    <p>我的粉丝</p>
</header>
<article>

    <ul class="acticity_list fan_list_table">
        <li>
            <section class="fans">
                <div class="fans_list">
                    <ul class="clearfix">
                        <li>
                            <p><?php echo $fans_count;?></p>
                            <span>粉丝总数</span>
                        </li>
                        <li>
                            <p><?php echo $today_fans;?></p>
                            <span>今日新增</span>
                        </li>
                        <li>
                            <p><?php echo $yesterday_fans;?></p>
                            <span>昨日新增</span>
                        </li>
                    </ul>
                </div>
                <div class="tab">
                    <div class="fans_titel active">七日粉丝流量</div>
                    <div class="fans_titel">粉丝列表</div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="fans_table" style="border-top: none;">

                    <div id="chart1"></div>
                    <?php if ($max > 0) { ?>
                    <script type="text/javascript">
                        var data = [<?php echo $datas;?>];

                        var data_max = <?php echo $max; ?>; //Y轴最大刻度
                        var line_title = ["粉丝数"]; //曲线名称
                        var y_label = " "; //Y轴标题
                        var x_label = ""; //X轴标题
                        var x = <?php echo $days;?>; //定义X轴刻度值
                        var title = "这是标题"; //统计图标标题
                        j.jqplot.diagram.base("chart1", data, line_title, " ", x, x_label, y_label, data_max, 1);
                    </script>
                    <?php } else { ?>
                        <div class="empty-list list-finished" style="padding-top:60px;">
                            <div>
                                <h4>最近七日您居然还没有粉丝</h4>
                                <p class="font-size-12">粉丝多，赚钱快</p>
                            </div>
                            <div><a href="javascript:void(0);" class="tag tag-big tag-orange js-share-link" style="padding:8px 30px;">去分享</a></div>
                        </div>
                    <?php }?>
                </div>
                <div class="fans_table" style="padding: 0;display: none;">
                    <?php if ($fans_count > 0) { ?>
                    <ul class="fans_list table-title clearfix" style="margin-top: 0;border-top: none;">
                        <li class="fans-detail" style="width: 50%;text-align: center;">
                            头像/昵称
                        </li>
                        <li class="fans-detail" style="width: 30%;text-align: center;">
                            关注时间
                        </li>
                        <li class="fans-detail" style="width: 20%">
                            消费金额
                        </li>
                    </ul>
                    <?php foreach($fans_list as $fans) { ?>
                    <ul class="fans_list clearfix" style="margin-top: 0;border-top: none;">
                        <li class="fans-detail" style="width: 50%">
                            <div style="float: left;border-radius: 3rem;overflow:hidden;">
                                <img src="<?php echo $fans['avatar']; ?>" width="40" height="40" />
                            </div>
                            <div style="float: left;margin-left: 10px;text-align: left;">
                                <?php echo $fans['nickname']; ?><br/>
                                <?php if ($fans['seller_id'] > 0) { ?>
                                    <a href="./home.php?id=<?php echo $fans['seller_id']; ?>"><span class="seller-tag">分销商</span></a>
                                <?php } else { ?>
                                    <span class="member-tag">普通粉丝</span>
                                <?php } ?>
                            </div>
                        </li>
                        <li class="fans-detail" style="width: 30%;text-align: center;"><?php echo $fans['add_time']; ?></li>
                        <li class="fans-detail" style="width: 20%;text-align: right;padding-right: 10px"><?php echo $fans['money']; ?></li>
                    </ul>
                    <?php } ?>
                    <?php } ?>
                    <div class="empty-list list-finished" <?php if ($fans_count > 0) { ?>style="padding-top:60px;display: none;"<?php } else { ?>style="padding-top:60px;"<?php } ?>>
                        <div>
                            <h4>居然还没有粉丝</h4>
                            <p class="font-size-12">粉丝多，赚钱快</p>
                        </div>
                        <div><a href="javascript:void(0);" class="tag tag-big tag-orange js-share-link" style="padding:8px 30px;">去分享</a></div>
                    </div>
                    <div class="wx_loading2"><i class="wx_loading_icon"></i></div>
                </div>
            </section>
        </li>
    </ul>

</article>

<div class="pop-dialog js-dialog-link" style="display: none;">
    <div class="bg"></div>
    <div class="body">
        <img class="collect-img" src="<?php echo TPL_URL; ?>images/share_friend_fans.png" />
    </div>
</div>
<?php echo $shareData;?>
</body>
<script src="<?php echo TPL_URL;?>js/rem.js"></script>
<script type="text/javascript">
    $(function() {
        $('.tab > .fans_titel').click(function(e) {
            var index = $(this).index('.tab > .fans_titel');
            $(this).addClass('active').siblings('.fans_titel').removeClass('active');
            $('.fans_table').eq(index).slideDown(300).siblings('.fans_table').hide();
        });

        $('.js-share-link').on('click', function(){
            $(".js-dialog-link").show();
        });

        $('.js-dialog-link .body').on('click', function(){
            $(".js-dialog-link").hide();
        });

        $(window).scroll(function(){
            if ($('.tab > .fans_titel:eq(1)').hasClass('active')) {
                if(page > 1 && $(window).scrollTop()/($('body').height() -$(window).height())>=0.95){
                    if(is_ajax == false){
                        if(typeof(max_page) != 'undefined'){
                            if(page <= max_page) {
                                getFans();
                            }
                        }
                    }
                }
            }
        });

        function getFans(){
            $('.wx_loading2').show();
            $.ajax({
                type: 'post',
                url: page_url,
                data: 'p=' + page,
                dataType: 'json',
                async: false,
                success:function(result){
                    $('.wx_loading2').hide();
                    try {
                        if(result.err_code) {
                            motify.log(result.err_msg);
                        } else {
                            if(result.err_msg.fans_list.length > 0) {
                                var html = '';
                                for(var i in result.err_msg.fans_list){
                                    var fans_list = result.err_msg.fans_list;
                                    html += '<ul class="fans_list clearfix" style="margin-top: 0;border-top: none;">';
                                    html += '    <li class="fans-detail" style="width: 50%">';
                                    html += '        <div style="float: left;border-radius: 3rem;overflow:hidden;">';
                                    html += '            <img src="' + fans_list[i]['avatar'] + '" width="40" height="40" />';
                                    html += '        </div>';
                                    html += '        <div style="float: left;margin-left: 10px;text-align: left;">';
                                    html +=              fans_list[i]['nickname'] + '<br/>';
                                    if (parseInt(fans_list[i]['seller_id']) > 0) {
                                        html += '        <a href="./home.php?id=' + fans_list[i]['seller_id'] + '"><span class="seller-tag">分销商</span></a>';
                                    } else {
                                        html += '        <span class="member-tag">普通粉丝</span>';
                                    }
                                    html += '       </div>';
                                    html += '    </li>';
                                    html += '    <li class="fans-detail" style="width: 30%;text-align: center;">' + fans_list[i]['add_time'] + '</li>';
                                    html += '    <li class="fans-detail" style="width: 20%;text-align: right;padding-right: 10px">' + fans_list[i]['money'] + '</li>';
                                    html += '</ul>';
                                }
                                $('.empty-list').before(html);
                            }
                            page++;
                            if(typeof(result.err_msg.noNextPage) == 'undefined'){
                                is_ajax = false;
                            }else if(result.err_msg.noNextPage) {
                                is_ajax = true;
                            }
                        }
                    } catch (e) {

                    }
                },
                error:function(){
                    $('.wx_loading2').hide();
                    motify.log('粉丝读取失败，<br/>请刷新页面重试',0);
                }
            });
        }
    })
</script>
</html>
