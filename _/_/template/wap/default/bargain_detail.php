<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="applicable-device" content="mobile">
    <link href="<?php echo TPL_URL;?>css/bargain/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/bargain/index.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/bargain/media.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/swiper.min.css" type="text/css">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/swiper.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <title><?php echo $bargain['name'];?></title>
    <script type="text/javascript">
        function layer_tips(msg_type,msg_content){
            layer.closeAll();
            var time = msg_type==0 ? 3 : 4;
            var type = msg_type==0 ? 1 : (msg_type != -1 ? 0 : -1);
            if(type == 0){
                msg_content = '<font color="red">'+msg_content+'</font>';
            }
            $.layer({
                title: false,
                offset: ['80px',''],
                closeBtn:false,
                shade:[0],
                time:time,
                dialog:{
                    type:type,
                    msg:msg_content
                }
            });
        }
    </script>
    <style>
        .fork {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,.5);
            z-index: 9;
        }
        .fork_content {
            background: #fff;
            position: fixed;
            width: 94%;
            margin-left: 3%;
            top: 18%;
            text-align: center;
            z-index: 10;
            height:55%;
        }
        .fork_content .fork_title {
            color: #fff;
            background: #45a5cf;
            line-height: 25px;
        }
        .fork_content p {
            color: #333333;
        }
        .fork_content img {
            height: 190px;
        }
        .fork_content p span {
            color: #999;
        }
        .fork_content button {
            background: #ff9c00;
            color: #fff;
        }
        .fork_content .fork_text p{
            background-color: #ffffff;
            margin-top: 3px;;
        }
    </style>
</head>
<body>
<?php if ($show_subscribe_div && empty($is_subscribe)) {?>
<aside>
    <div class="fork" style="display: block;"></div>
    <div class="fork_content">
        <div class="fork_title">亲，你还未关注店家的公众号，<br/>该活动只有关注后才能参加！</div>
        <div class="fork_text">
            <p>第一步：长按二维码并识别</p>
            <img style="margin: 0 auto;" src="<?php echo $qrcode['ticket'];?>" >
            <p>第二步：关注公共号，参加活动</p>
        </div>
    </div>
</aside>
<?php
}
?>

<div class="layer " ></div>
<div class="moeny center">
    <audio id="player" src="<?php echo TPL_URL;?>images/bargain/123.wav"></audio>
    <div class="moeny_img "><img src="<?php echo TPL_URL;?>images/bargain/money_13_13_10.png" /></div>
    <div class="close"></div>
    <div class="moeny_content  ">
        <p>哇哦，在您休息片刻之际，已有<span><?php echo isset($kan_total_time)?$kan_total_time:0;?></span>位亲友帮您砍掉</p>
        <span>￥<?php echo $kan_total_money<=$bargain['original']-$bargain['minimum']?$kan_total_money/$num_rate:($bargain['original']-$bargain['minimum'])/$num_rate;?></span>
        <h3>你是不是很开森啊!</h3>
        <div class="moeny_left"></div>
        <div class="moeny_right"></div>
    </div>
    <div class="coloured"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
    <div class="wallet"><i></i><i></i><i></i> </div>
    <div class="coin"><i></i><i></i><i></i><i></i><i></i> </div>
</div>

<div class="bargain_layer center">
    <audio id="player" src="<?php echo TPL_URL;?>images/bargain/jishui.wav"></audio>
    <div class="bargain_ball_img"><img src="<?php echo TPL_URL;?>images/bargain/knife_02.png" /></div>
    <div class="close"></div>
    <div class="bargain_crack "></div>
    <div class="bargain_people"><i></i><i></i><i></i></div>
    <div class="bargain_colour"></div>
    <div class="bargain_ribbon"><i></i><i></i></div>
    <div class="bargain_banner">成功砍价<span></span></div>
</div>

<header class="clearfix">
    <div class="header_left">已有<span><?php echo $all_kan_total_time;?></span>人参与砍价</div>
    <div class="header_right">库存:<span><?php echo $bargain['inventory'];?></span>销量:<span><?php echo $order_count;?></span></div>
</header>
<div class="banner">
    <div class="swiper-container s1 swiper-container-horizontal">
        <div class="swiper-wrapper" style="transition-duration: 0ms; -webkit-transition-duration: 0ms;  ">
            <div class="swiper-slide  swiper-slide-prev"  >
                <div class="banner_img"><img src="<?php echo $bargain['logoimg1'];?>" /></div>
                <div class="banner_txt clearfix">
                    <div style="clear:both"></div>
                    <p><span><?php echo msubstr(htmlspecialchars($bargain['logotitle1']),0,15,false);?></span>
                    <button onclick="location.href='<?php echo $config['site_url'].'/wap/bargain.php?action=good_detail&id='.$bargain['pigcms_id'];?>'">商品详情</button>
                    </p>
                </div>
            </div>
            <?php if($bargain['logoimg2'] != ''){?>
                <div class="swiper-slide  swiper-slide-prev"  >
                    <div class="banner_img"><img src="<?php echo $bargain['logoimg2'];?>" /></div>
                    <div class="banner_txt clearfix">
                        <div style="clear:both"></div>
                        <p><span><?php echo msubstr(htmlspecialchars($bargain['logotitle2']),0,15,false);?></span>
                        <button onclick="location.href='<?php echo $config['site_url'].'/wap/bargain.php?action=good_detail&id='.$bargain['pigcms_id'];?>'">商品详情</button>
                        </p>
                    </div>
                </div>
            <?php }?>
            <?php if($bargain['logoimg3'] != ''){?>
                <div class="swiper-slide  swiper-slide-prev"  >
                    <div class="banner_img"><img src="<?php echo $bargain['logoimg3'];?>" /></div>
                    <div class="banner_txt clearfix">
                        <div style="clear:both"></div>
                        <p><span><?php echo msubstr(htmlspecialchars($bargain['logotitle3']),0,15,false);?></span>
                        <button onclick="location.href='<?php echo $config['site_url'].'/wap/bargain.php?action=good_detail&id='.$bargain['pigcms_id'];?>'">商品详情</button>
                        </p>
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="swiper-pagination p1 swiper-pagination-clickable"><span class="swiper-pagination-bullet"></span><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span></div>
    </div>
</div>
<script>
    var mySwiper = new Swiper('.s1',{
        loop: false,
        autoplay: 3000,
        pagination: '.p1',
        paginationClickable: true
    });
    $(document).ready(function(){
        <?php if($is_over == 1){?>
        daojishi();
        <?php }?>
        <?php if(!in_array($is_over,array(3,5)) && $kan_total_time>0 && !$is_share_link && $time_interval){?>
        winning();
        <?php }?>
    });
    <?php if($is_over == 1){?>
    var day = <?php echo $day;?>;
    var hour = <?php echo $hour;?>;
    var minute = <?php echo $minute;?>;
    var second = <?php echo $second;?>;
    function daojishi(){
        if(second < 0){
            second = 59;
            minute--;
        }
        if(minute < 0){
            minute = 59;
            hour--;
        }
        if(hour < 0){
            hour = 23;
            day--;
        }
        if(second < 10){
            $('.second').html('0'+second);
        }else{
            $('.second').html(second);
        }
        if(minute < 10){
            $('.minute').html('0'+minute);
        }else{
            $('.minute').html(minute);
        }
        if(hour < 10){
            $('.hour').html('0'+hour);
        }else{
            $('.hour').html(hour);
        }
        if(day < 10){
            $('.day').html('0'+day);
        }else{
            $('.day').html(day);
        }
        if(day < 0){
            location.reload();
        }else{
            second--;
            setTimeout("daojishi()",1000);
        }
    }
    <?php }?>
</script>
<?php if($is_over != 0){?>
<div class="countdown clearfix"><i></i>
    <div class="countdown_time" ><?php if($is_over == 1){echo "砍价倒计时:";}elseif($is_over == 2){echo "砍价已最低:";}elseif($is_over == 3 || $is_over == 5){echo "已购买:";}elseif($is_over == 4){echo "砍价已结束:";}?><em class="day">00</em>天<em class="hour">00</em>时<em class="minute">00</em>分<em class="second">00</em>秒</div>
</div>
<?php }?>
<div class="content">
    <div class="bargain clearfix">
        <div class="bargain_img">
            <?php if($_REQUEST['friend']==''){ ?>
            <img src="<?php echo isset($avatar)?$avatar:TPL_URL.'images/bargain/portrait.jpg';?>" />
            <?php }else{ ?>
            <img src="<?php echo isset($wxuser['wecha_id'])?$wxuser['wecha_id']:TPL_URL.'images/bargain/portrait.jpg';?>" />
            <?php } ?>
        </div>
        <div class="bargain_content">
            <?php if($_REQUEST['friend']==''){ ?>
            <h1><?php echo isset($nickname)?$nickname:'匿名';?></h1>
            <?php }else{ ?>
            <h1><?php echo isset($wxuser['name'])?$wxuser['name']:'匿名';?></h1>
            <?php } ?>
            <p>现价:<span class="nowprice"><?php echo $bargain['myqprice']<$bargain['original']-$bargain['minimum']?($bargain['original']-$bargain['myqprice'])/$num_rate:$bargain['minimum']/$num_rate;?></span></p>
            <p style="text-decoration: line-through;"><b>原价:<?php echo $bargain['original']/$num_rate;?></b></p>
            <p><b>底价:<?php echo $bargain['minimum']/$num_rate;?></b></p>
        </div>
        <div class="bargain_info"><i class="myrank"><?php if($my_kanuser_count==0){echo "未参加";}else{echo "已参加";};?></i><i class="helpcount"><?php echo isset($kan_total_time)?$kan_total_time:0;?>人帮砍</i></div>
    </div>
    <?php if($kan_total_time > 0 && $friend==''){?>
        <div class="invite">
            <p>已有<span><?php echo isset($kan_total_time)?$kan_total_time:0;?></span>位亲友帮<?php echo $myorder?'TA':'我';?>砍价了，共砍掉<span>￥<?php echo $kan_total_money<=$bargain['original']-$bargain['minimum']?$kan_total_money/$num_rate:($bargain['original']-$bargain['minimum'])/$num_rate;?></span>，想以最低价<?php echo $orderid?'帮TA':'';?>收入囊中，那就赶紧去找亲友拔刀相助！</p>
        </div>
    <?php }?>
    <div class="operation clearfix">
        <div class="operation_info">
            <?php if($is_over == 0){?>
                <button onclick="firstblood()">砍下第一刀</button>
            <?php }elseif($is_over == 1){?>
                <?php if($is_share_link){?>
                    <?php if($my_kanuser_count == 0){?>
                        <button onclick="firstblood()">帮TA砍一刀</button>
                    <?php }?>
                    <button onclick="share()">找亲友帮Ta砍刀</button>
                    <button onclick="location.href='/wap/bargain.php?action=detail&id=<?php echo $_REQUEST['id'];?>&store_id=<?php echo $_REQUEST['store_id'];?>'">我也要玩</button>
                <?php }else{?>
                    <button onclick="share()">找亲友帮我砍刀</button>
                    <button class="js-mutiBtn-confirm">立即购买</button>
                <?php }?>
            <?php }elseif($is_over == 2 || $is_over == 3){?>
                <?php if(!$is_share_link){?>
                    <?php if($is_over == 2){ ?>
                    <button class="js-mutiBtn-confirm">立即购买</button>
                    <?php }elseif($is_over == 3){ ?>
                    <button class="js-mutiBtn-confirm">立即付款</button>
                    <?php } ?>
                <?php }else{?>
                    <button onclick="location.href='/wap/bargain.php?action=detail&id=<?php echo $_REQUEST['id'];?>&store_id=<?php echo $_REQUEST['store_id'];?>'">我也要玩</button>
                <?php }?>
            <?php }elseif($is_over == 4){?>
                <?php if(!$is_share_link){?>
                    <button>砍价已结束</button>
                    <button class="js-mutiBtn-confirm">立即购买</button>
                <?php }else{?>
                    <button onclick="location.href='/wap/bargain.php?action=detail&id=<?php echo $_REQUEST['id'];?>&store_id=<?php echo $_REQUEST['store_id'];?>'">我也要玩</button>
                <?php }?>
            <?php }elseif($is_over == 5){?>
                <?php if(!$is_share_link){?>
                    <button>已购买</button>
                <?php }else{?>
                    <button onclick="location.href='/wap/bargain.php?action=detail&id=<?php echo $_REQUEST['id'];?>&store_id=<?php echo $_REQUEST['store_id'];?>'">我也要玩</button>
                <?php }?>
            <?php }?>
        </div>
    </div>
</div>
<div class="share_bg" style="display: none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;text-align: center;background: rgba(0,0,0,0.7);z-index: 99;">
    <img src="<?php echo TPL_URL;?>images/bargain/share-guide.png" style="width: 100%;">
</div>

<div class="activity">
    <div class="activity_title">
        <ul class="clearfix">
            <li class="curn">活动规则</li>
            <li>亲友团出刀</li>
            <li>砍价榜TOP<?php echo $bargain['rank_num']?$bargain['rank_num']:10;?></li>
        </ul>
    </div>
    <ul class="acticity_list">
        <ul>
            <li style="padding:10px">
                <?php echo htmlspecialchars_decode($bargain['guize']);?>
            </li>
            <li style="display:block">
                <ul class="friends">
                    <?php foreach($kanuser_list as $k=>$v){ ?>
                        <li class="clearfix">
                            <div class="head_img"><img src="<?php echo $v['wecha_id']?$v['wecha_id']:TPL_URL.'images/bargain/portrait.jpg';?>" /></div>
                            <div class="bargain_content">
                                <h1><?php echo $v['name']?$v['name']:'匿名';?></h1>
                                <p><?php echo $v['addtime']?date("Y-m-d H:i:s",$v['addtime']):date("Y-m-d H:i:s");?></p>
                            </div>
                            <div class="price">帮砍:<span>￥<?php echo $v['dao']/$num_rate;?></span></div>
                        </li>
                    <?php } ?>
                    </volist>
                </ul>
            </li>
            <li class="bargain_list">
                <ul>
                    <?php foreach($rank_list as $k=>$v){ ?>
                        <li class=" clearfix"> <i><?php echo $k+1;?></i>
                            <div class="head_img"><img src="<?php echo $v['wecha_id']?$v['wecha_id']:TPL_URL.'images/bargain/portrait.jpg';?>" /></div>
                            <h2><?php echo $v['name']?$v['name']:'匿名';?></h2>
                            <p>已砍至:<span>￥<?php echo $v['now_price']/$num_rate;?></span></p>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    </ul>
</div>
<script>
    $(document).ready(function(){
        tab(".activity_title li", ".acticity_list > ul > li", "curn");
        $(".close,.layer").click(function() {
            $(".center").fadeOut(110);
            $(".layer").fadeOut(140);
            $("body").css({
                "height": "auto",
                "overflow": "auto"
            });

        });

        $('.js-mutiBtn-confirm').click(function(){
            var nowDom = $(this);
            nowDom.attr('disabled',true).html('正在提交中');

            var post_url = "./saveorder.php";
            var param = '';

            $.post(post_url,{
                type:50,
                price:'<?php echo $bargain['myqprice']<$bargain['original']-$bargain['minimum']?($bargain['original']-$bargain['myqprice'])/$num_rate:$bargain['minimum']/$num_rate;?>',
                storeId:'<?php echo $storeId;?>',
                activityId:'<?php echo $pigcms_id;?>',
                proId:'<?php echo $bargain['product_id'];?>',
                skuId:'<?php echo $bargain['sku_id'];?>',
                quantity:1,
                isAddCart:0
            },function(result){

                if(result.err_code==2){
                    window.location.href = './pay.php?id='+result.err_msg+'&showwxpaytitle=1' + param;
                    return false;
                }else if(result.err_code!=0){
                    layer_tips(1,result.err_msg);
                    return false;
                }else if(result.err_code==0){
                    $.post("./bargain.php", { action: "save_orderid", orderid: result.err_msg,pigcms_id:<?php echo isset($my_kanuser_id)?$my_kanuser_id:0;?>,activityId:<?php echo isset($pigcms_id)?$pigcms_id:0;?>},
                        function(resultb){

                            if(resultb.error==1){
                                layer_tips(1,resultb.err_msg);
                                return false;
                            }else{
                                window.location.href = './pay.php?id='+result.err_msg+'&showwxpaytitle=1' + param;
                            }

                        }
                    );
                }

            });

        });
    });

    var autioPlay = function(autioDom, controlDom) {
        var autoplay = typeof($(autioDom).attr('autoplay'));
        autioDom.play();
    }

    function share(){
        $('.share_bg').show();
        $('.share_bg').click(function(){
            if($(this).css('display') == 'block'){
                $(this).css('display','none');
            }
        });
    }

    function firstblood(){
        $.post("bargain.php",
        {
            action : 'new_firstblood',
            token : '<?php echo $bargain['token'];?>',
            id : '<?php echo $bargain['pigcms_id'];?>',
            friend : '<?php echo $_REQUEST['friend'];?>'
        }, function (data) {
            if (data.err_code == '0') {
                $(".bargain_banner span").html('￥'+data.dao);
                $(".bargain_layer").show();
                autioPlay(document.getElementById('player'), $('.player'));

                var t = setTimeout(function(){window.location.href = './bargain.php?action=detail&id='+data.id+'&store_id='+data.store_id+'&friend='+data.friend;return false;}, 4000);
            } else {
                window.location.href = './bargain.php?action=detail&id='+data.id+'&store_id='+data.store_id+'&friend='+data.friend;return false;
            }
        });
    }

    function tab(a, b, c) { //a 是点击的目标,,b 是所要切换的目标,c 是点击目标的当前样式
        var len = $(a);
        len.bind("click",
            function() {
                var index = 0;
                $(this).addClass(c).siblings().removeClass(c);
                index = len.index(this); //获取当前的索引
                $(b).eq(index).show().siblings().hide();
                return false;
            }).eq(0).trigger("click"); //浏览器模拟第一个点击
    }

    //进入时加载
    function winning() {
        var hh = $(window).height();
        var autioPlay = function(autioDom, controlDom) {
            var autoplay = typeof($(autioDom).attr('autoplay'));

            autioDom.play();
            $("body").css({
                "height": hh,
                "overflow": "hidden"
            });
            $(".moeny,.layer").show();
            clearTimeout(t);
            var t = setTimeout(function() {
                $(".center").fadeOut(110);
                $(".layer").fadeOut(140);
                $("body").css({
                    "height": "auto",
                    "overflow": "auto"
                });
            }, 6000);
            $(".close,.layer").click(function() {
                autioDom.pause();
            });
        }
        autioPlay(document.getElementById('player'), $('.player'));
    }
</script>

<?php
$linkcon = (isset($_REQUEST['friend']) && $_REQUEST['friend']!='')?$_REQUEST['friend']:$user_token;
$share_conf     = array(
    'title'     => $bargain['wxtitle'], // 分享标题
    'desc'      => $bargain['wxinfo'], // 分享描述
    'link'      => $config['site_url'].'/wap/bargain.php?action=detail&id='.$bargain['pigcms_id'].'&store_id='.$store_id.'&friend='.$linkcon , // 分享链接
    'imgUrl'    => $bargain['wxpic'], // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share      = new WechatShare();
$shareData  = $share->getSgin($share_conf);
echo $shareData;
?>

</body>
</html>
