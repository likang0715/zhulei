<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>微助力，助你成功</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/helping/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/helping/swiper.min.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/helping/style.css">
    <style type="text/css">
        .fork{position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:9}
        .fork_content{background:#fff;position:fixed;width:94%;margin-left:3%;top:18%;text-align:center;z-index:10;height:55%}
        .fork_content .fork_title{color:#fff;background:#45a5cf;line-height:25px}
        .fork_content p{color:#333}
        .fork_content img{height:190px}
        .fork_content p span{color:#999}
        .fork_content button{background:#ff9c00;color:#fff}
        .fork_content .fork_text p{background-color:#fff;margin-top:3px}
    </style>
    <script src="<?php echo TPL_URL;?>js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo TPL_URL;?>js/swiper.jquery.min.js"></script>
    <script>
    var timer=0;
    $(function(){
        var docHeight = $(document).height();
        $(".fullBg").height(docHeight);
        $(".fullBg2").height(docHeight);
        tab(".tabBox .hd ul li",".tabBox .row","on");
        centerWindow(".w0");
        centerWindow(".w1");
        $(".fullBg").click(function(){
            $(".window").removeClass("animate").hide();
            $(this).hide();
            clearTimeout(timer);
        });
        daotime = '<?php if($is_over == 1){echo date('m',strtotime($helping['start_time'])).'/'.date('d',strtotime($helping['start_time'])).'/'.date('Y',strtotime($helping['start_time'])).' '.date('H:i:s',strtotime($helping['start_time']));}else{echo date('m',strtotime($helping['end_time'])).'/'.date('d',strtotime($helping['end_time'])).'/'.date('Y',strtotime($helping['end_time'])).' '.date('H:i:s',strtotime($helping['end_time']));}?>';
        <?php if($is_over != 2){ ?>
        timeShow();//倒计时
        <?php } ?>
        is_over = <?php echo is_over;?>;
    });
    </script>
    <script src="<?php echo TPL_URL;?>js/helping.js"></script>
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
    <?php } ?>
    <header class="scroll">
        <!-- Swiper -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach($helping_news as $nk=>$nv){ ?>
                <div class="swiper-slide">
                    <img src="<?php echo $nv['imgurl'];?>" width="100%">
                    <?php if($nv['title'] != ''){ ?>
                        <div class="title"><?php echo $nv['title'];?></div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <script>
            var swiper = new Swiper('.swiper-container', {
                loop:true,
                autoplay: 5000//可选选项，自动滑动
            });
        </script>
    </header>
    <div class="oTime">
        <div class="timeBox">
            <?php if($is_over != 2){ ?>
            <h2>
                <?php if($is_over == 1){echo '距离开始还剩';}else{echo '时间还剩';} ?>
            </h2>
            <ul class="timeShow">
                <li class="bg">00</li>
                <li class="oText">天</li>
                <li class="bg">00</li>
                <li class="oText">时</li>
                <li class="bg">00</li>
                <li class="oText">分</li>
                <li class="bg">00</li>
                <li class="oText">秒</li>
            </ul>
            <?php }else{ ?>
            <h2>
                活动已经结束
            </h2>
            <?php } ?>
        </div>
    </div>
    <div class="topUser">
        <div class="userBox">
            <div class="fl userAvatar">
                <img style="border-radius: 100%;" src="<?php echo $avatar;?>" />
            </div>
            <div class="userDesc">
                <h2><?php echo $nickname;?></h2>
                <P>排名：<?php echo $my_join_count>0 || $share_join_count>0?"第<em>".$my_rank."</em>位":"未参与";?></P>
            </div>
            <?php if(!isset($_GET['share_key'])){ ?>
            <div class="tipBox">
                <div class="tip tip0">
                    <h3>转发数</h3>
                    <p><?php echo isset($my_join_info['share_num'])?$my_join_info['share_num']:0;?></p>
                </div>
                <div class="tip tip1">
                    <h3>助力值</h3>
                    <p><?php echo isset($my_join_info['help_count'])?$my_join_info['help_count']:0;?></p>
                </div>
            </div>
            <?php }else{ ?>
            <div class="tipBox">
                <div class="tip tip0">
                    <h3>转发数</h3>
                    <p><?php echo $share_join_info['share_num'];?></p>
                </div>
                <div class="tip tip1">
                    <h3>助力值</h3>
                    <p><?php echo $share_join_info['help_count'];?></p>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="checkBtn animate clearfix">
        <?php if($my_join_info >0 || $share_join_count >0){?>
            <?php if(!isset($_GET['share_key'])){ ?>
            <a href="/wap/helping.php?action=helper_detail&id=<?php echo $pid;?>&share_key=<?php echo $user_token;?>" class="up35">查看谁给我助力</a>
            <?php }else{ ?>
            <a href="/wap/helping.php?action=helper_detail&id=<?php echo $pid;?>&share_key=<?php echo $_GET['share_key'];?>" class="up35">查看谁给TA助力</a>
            <?php } ?>
        <?php }?>
    </div>
    <div class="oTab">
        <div class="tabBox">
            <div class="hd clearfix">
                <ul>
                    <li class="li0 on" style="margin:0 2px"><i></i>活动规则</li><li class="li1" style="margin:0 2px"><i></i>活动奖品</li><li class="li2" style="margin:0 2px"><i></i>排行top<?php echo $helping['rank_num'];?></li>
                </ul>
            </div>
            <div class="bdRound">
                <div class="bd" style="padding-top: 15px;">
                    <div class="row rule" style="line-height:20px">
                        <?php echo $helping['guize'];?>
                    </div>
                    <style type="text/css">
                        .getprize {position: absolute;top: 30%;left: 65%;cursor: pointer;float: right;padding: 5px 5px;border-radius: 5px;border: 2px solid #DB3537;font-size: 1.4rem;margin: 0 5px;background: #FFC202;color: #464215;}
                    </style>
                    <div class="row prize">
                        <ul class="clearfix">
                            <?php foreach($helping_prizes as $k=>$v){ ?>
                            <li>
                                <div class="rightBar fr">
                                </div>
                                <div class="addBg">
                                    <div class="prizeImg fl">
                                        <?php if($v['type']==1){ ?>
                                        <img src="<?php echo $v['imgurl'];?>"/>
                                        <?php }elseif($v['type']==2){ ?>
                                        <img src="<?php echo TPL_URL;?>images/helping/coupon.png"/>
                                        <?php }elseif($v['type']==3){ ?>
                                        <img src="<?php echo TPL_URL;?>images/helping/point.png"/>
                                        <?php }elseif($v['type']==4){ ?>
                                        <img src="<?php echo TPL_URL;?>images/helping/prize.png"/>
                                        <?php } ?>
                                        <h4><?php echo $k+1;?>等奖</h4>
                                    </div>
                                    <div class="prizeDesc">
                                        <h3><?php echo $v['title'];?></h3>
                                        <?php if(isset($v['value'])){ ?><p>面值:<?php echo $v['value'];?></p><?php } ?>
                                        <?php if(isset($v['limit'])){ ?><p>限制条件:<?php echo $v['limit'];?></p><?php } ?>
                                        <?php if ($prize_winners[$k]['token']==$user_token && $v['is_cash']=='0'){ ?>
                                        <a href="javascript:void(0);" class="getprize dogetprize" data-type="<?php echo $v['type'];?>" data-num="<?php echo $k;?>">点击领奖</a>
                                        <?php } elseif ($prize_winners[$k]['token']==$user_token && $v['is_cash']!='0') { ?>
                                            <a href="javascript:void(0);" class="getprize">已经领取</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </li>
                            <?php };  ?>
                        </ul>
                    </div>
                    <div class="row list">
                        <ul>
                            <?php foreach($rank as $rk=>$rv){ ?>
                                <li>
                                    <div class="userBox">
                                        <div class="fl userAvatar">
                                            <img src="<?php echo $rv['avatar'];?>" />
                                        </div>
                                        <div class="userDesc">
                                            <h2><?php echo $rv['nickname'];?></h2>
                                            <!--p></p-->
                                        </div>
                                        <div class="tipBox">
                                            <div class="tip tip2">
                                                <h3>转发数</h3>
                                                <p><?php echo $rv['share_num'];?></p>
                                            </div>
                                            <div class="tip tip1">
                                                <h3>助力值</h3>
                                                <p><?php echo $rv['help_count'];?></p>
                                            </div>
                                        </div>
                                        <div class="num">
                                        <span>
                                            <i><?php echo $rk+1;?></i>
                                        </span>
                                            <s></s>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="oBtn">
            <?php if($is_over == 1){echo "<a href='#' style='background:#ddd'>活动未开始</a>";}elseif($is_over == 2){echo "<a href='#' style='background:#ddd'>活动已结束</a>";}else{ ?>
                <?php if($_GET['share_key'] != ''){ ?>
                    <?php if($my_help_count<=0){ ?>
                    <a href="javascript:;" class="first_help">
                        给TA助力
                    </a>
                    <?php } ?>
                    <a href="javascript:;" onclick="share()">
                        找朋友给TA助力
                    </a>
                    <?php //if($my_join_count<=0){ ?>
                    <a href="javascript:;" class="first_join">
                        我要参加
                    </a>
                    <?php //} ?>
                <?php }else{ ?>
                    <?php if($my_join_count > 0){?>
                        <a href="javascript:;" onclick="share()" style="background: #aa2343;color: #fff;">
                            找朋友助力
                        </a>
                    <?php }else{ ?>
                        <a href="javascript:void(0);" class="first_join">
                            我要参与
                        </a>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </footer>
    <div class="fullBg"></div>
    <div class="window w0" style="position: fixed; top: 30%; margin-top: 0px; left: 11.5px;">
        <div class="windowThis">
            <div class="hd"></div>
            <div class="bd">
                <div class="adMargin">
                    <div class="row">
                        <div class="putBorder">
                            <i></i><input class="tel" type="tel" placeholder="手机号" name="tel">
                        </div>
                    </div>
                    <div class="row">
                        <div class="putBorder">
                            <input class="w0_id" type="hidden" name="id" value="">
                            <input class="w0_num" type="hidden" name="num" value="">
                            <a href="javascript:;" class="getCode">填写领奖码</a> <i></i><input class="code" type="code" placeholder="领奖码" name="code">
                        </div>
                    </div>
                    <div class="row">
                        <button id="telyzbut">确定领奖</button>
                    </div>
                </div>
            </div>
            <div class="ft"></div>
        </div>
    </div>
    <div class="window w1" style="z-index: 1000; top: 378.5px; left: 11.5px;">
        <div class="windowThis">
            <div class="succeed">
                <div class="userAvatar">
                    <div class="imgBox">
                        <img src="<?php echo $wap_user['avatar'];?>">
                    </div>
                </div>
                <div class="title">
                    <h3>给<?php echo $nickname;?></h3>
                    <div class="tipWord">
                    </div>
                </div>
                <div class="roundLight rotate360">
                    <img class="" src="<?php echo TPL_URL;?>images/helping/roundLight.png">
                </div>
            </div>
        </div>
    </div>
    <div class="share_bg">
        <img src="<?php echo TPL_URL;?>/images/helping/share-guide.png">
    </div>
    <style>
        .fullBg2{background-color: #000;left: 0;opacity: 0.8;position: fixed;top: 0;z-index: 3;filter: alpha(opacity=80);-moz-opacity: 0.8;-khtml-opacity: 0.8;display: none;z-index: 888;width: 100%;}
        .w0 .windowThis .bd .row button{width: 100%;height: 30px;background: #f6514b;text-align: center;line-height: 30px;font-size: 1.4rem;color: #fff;border-radius: 5px}
        .tips{width: 100%;position: fixed;top: 0;left: 0;display: none;z-index: 9999}
        .tips h3{width: 70%;padding: 10px 0;  margin: 0 auto;  background: rgba(255,255,255,1);  text-align: center;  font-size: 1.2rem; color: red;}
    </style>
    <div class="tips" style="display: none;"><h3></h3></div>
    <script type="text/javascript">
        //参加
        $('.first_join').on('click',function(){
            $.post("/wap/helping.php",
            {
                action : 'firsthelp',
                id : '<?php echo $helping['id'];?>',
                ajax_key : '<?php echo $ajax_key;?>'
            } ,function(data){
                if (data.err_code == '10') {
                    //var t = setTimeout(function(){window.location.href = './helping.php?action=detail&id='+data.id;return false;}, 4000);
                    window.location.href = './helping.php?action=detail&id='+data.id;return false;
                } else if(data.err_code == '20'){
                    //var t = setTimeout(function(){window.location.href = './helping.php?action=detail&id='+data.id;return false;}, 4000);
                    window.location.href = './helping.php?action=detail&id='+data.id;return false;
                }else {
                    alert(data.err_msg);
                }
            });
        });
        //助力
        $('.first_help').on('click',function(){
            $.post("/wap/helping.php",
            {
                action : 'firsthelp',
                id : '<?php echo $helping['id'];?>',
                share_key : '<?php echo $_REQUEST['share_key'];?>',
                ajax_key : '<?php echo $ajax_key;?>'
            } ,function(data){
                if (data.err_code == '10') {
                    $('.fullBg').show();
                    $('.w1').show();
                    var t = setTimeout(function(){window.location.href = './helping.php?action=detail&id='+data.id+'&share_key='+data.share_key;return false;}, 1000);
                    //window.location.href = './helping.php?action=detail&id='+data.id+'&share_key='+data.share_key;return false;
                } else if(data.err_code == '20'){
                    //var t = setTimeout(function(){window.location.href = './helping.php?action=detail&id='+data.id+'&share_key='+data.share_key;return false;}, 4000);
                    window.location.href = './helping.php?action=detail&id='+data.id+'&share_key='+data.share_key;return false;
                }else {
                    alert(data.err_msg);
                }
            });
        });
        $('.dogetprize').on('click',function(){
            type = $(this).attr("data-type");
            id = $(this).attr("data-id");
            num = $(this).attr("data-num");
            if(type==4){
                $('.fullBg').show();
                $('.w0').show();
                $('.w0_id').val(id);
                $('.w0_num').val(num);
            }else{
                $.post("/wap/helping.php",
                    {
                        action   : 'cash_prize',
                        type     : type ,
                        num      : num ,
                        pid      : '<?php echo $pid;?>',
                        ajax_key : '<?php echo $ajax_key;?>'
                    } ,function(data){
                        if (data.err_code == 0) {
                            //var t = setTimeout(function(){window.location.href = './helping.php?action=detail&id='+data.id;return false;}, 4000);
                            window.location.href = './helping.php?action=detail&id='+data.id;return false;
                        } else {
                            alert(data.err_msg);
                        }
                    });
            }
        });
        $('#telyzbut').on('click',function(){
            type = 4;
            num = $(".w0_num").val();
            code = $(".code").val();
            tel = $(".tel").val();
            $.post("/wap/helping.php",
            {
                action   : 'cash_prize',
                type     : type ,
                num      : num ,
                pid      : '<?php echo $pid;?>',
                code     : code ,
                tel     : tel ,
                ajax_key : '<?php echo $ajax_key;?>'
            } ,function(data){
                if (data.err_code == 0) {
                    //var t = setTimeout(function(){window.location.href = './helping.php?action=detail&id='+data.id;return false;}, 4000);
                    window.location.href = './helping.php?action=detail&id='+data.id;return false;
                } else {
                    alert(data.err_msg);
                }
            });
        });
    </script>

<?php
$linkcon = (isset($_REQUEST['share_key']) && $_REQUEST['share_key']!='')?$_REQUEST['share_key']:$user_token;
$share_conf     = array(
    'title'     => $helping['wxtitle'], // 分享标题
    'desc'      => $helping['wxinfo'], // 分享描述
    'link'      => $config['site_url'].'/wap/helping.php?action=detail&id='.$helping['id'].'&store_id='.$helping['store_id'].'&share_key='.$linkcon , // 分享链接
    'imgUrl'    => $helping['wxpic'], // 分享图片链接
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
