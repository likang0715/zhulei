<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>微店-优惠接力</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/yousetdiscount/css/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/yousetdiscount/css/style.css">
    <script type="text/javascript" src="<?php echo TPL_URL;?>/yousetdiscount/js/jquery-2.1.1.min.js"></script>
    <?php $staticPath = TPL_URL; ?>

    <script type="text/javascript">
$(function(){
    $(".otherUser .bd .desc>a.arrowa").on("click",function(){
        $(this).toggleClass('on');
        $(this).parent().parent().parent().find(".subInfo").slideToggle();
    });

    // 领取优惠劵
    $(".js-getCoupon").bind("click", function(){
        var self = $(this);
        var coupon_id = self.data("coupon_id");
        var did = self.data("did");
        var url = "<?php echo option('site_url').'/wap/coupon_activity.php?action=yousetdiscount' ?>";
        var yid = "<?php echo $info['id'] ?>";

        if (!confirm('确定领取'+self.data('face_money')+'元优惠劵？')) {
            return;
        }

        $.ajax({
            type:"POST",
            url:url,
            dataType:"json",
            data:{
                coupon_id:coupon_id,
                yid:yid,
                did:did
            },
            success:function(data){

                if (data.err_code == 0) {
                    alert('领取成功!');
                    var ccc = setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                } else {
                    alert(data.err_msg);
                    return;
                }
            }
        });

    });

});
//窗口处理
$(function(){
    $(".aRule").on('click',function(){
        rule();
    });
});


//规则窗口
function rule(){
    setWindow.centerWindow('.wRule');
    $(".fullBg").fadeIn();
    $(".wRule").fadeIn();
}
function direction(is_show){
    if (is_show) {
        $(".js-getCoupon,.noBtn").hide();
    } else {
        $(".js-getCoupon,.noBtn").show();
    }
    setWindow.centerWindow('.direction');
    $(".fullBg").fadeIn();
    $(".direction").fadeIn();
}

var setWindow = {
    //1.居中方法，传入需要剧中的标签
    center: function(a) {
        var wWidth = $(window).width();
        var wHeight = $(window).height();
        var boxWidth = $(a).outerWidth(true);
        var boxHeight = $(a).height();
        var scrollTop = $(window).scrollTop();
        var scrollLeft = $(window).scrollLeft();
        var top = scrollTop + (wHeight - boxHeight) / 2;
        var left = scrollLeft + (wWidth - boxWidth) / 2;
        $(a).css({"top": top, "left": left});
    },
    //2.将盒子方法放入这个方，方便法统一调用
    centerWindow: function(a) {
        setWindow.center(a);
        //自适应窗口
        $(window).bind('scroll resize', function() {
            setWindow.center(a);
        });
    },
    //3.点击弹窗方法
    clickaShowWindow: function(a, b) {
        $(b).click(function() {
            setWindow.centerWindow(a);
            $(".fullBg").show();
            $(a).slideDown(300);
            return false;
        });
    },
    xClosed:function(){
        $(".fullBg").hide();
        $(".window").hide();
        $(".flagPosition").removeClass("hidden");
        $(".userWord ").css('visibility','visible');
    },
    closedWindow:function(){
        var timer=null;
        timer=setTimeout(function(){
            $(".fullBg").hide();$(".window").hide();
        },4000);
    },
    windowClosed:function(){
        $(".fullBg").hide();
        $(".window").hide();
    }
};

<?php if ($is_over != 2) { ?>
(function timeShow(){
    var show_time = $(".timeShow");
    var auto=null;
    endtime = new Date("<?php if($is_over == 1){echo date('m',$info['startdate']).'/'.date('d',$info['startdate']).'/'.date('Y',$info['startdate']).' '.date('H:i:s',$info['startdate']);}else{echo date('m',$info['enddate']).'/'.date('d',$info['enddate']).'/'.date('Y',$info['enddate']).' '.date('H:i:s',$info['enddate']);}?>");//结束时间
    today = new Date();//当前时间
    delta_T = endtime.getTime() - today.getTime();//时间间隔
    if(delta_T < 0){
        clearInterval(auto);
        location.reload();
        return;
    }
    auto=window.setTimeout(timeShow,1000);
    total_days = delta_T/(24*60*60*1000);//总天数
    total_show = Math.floor(total_days);//实际显示的天数
    total_hours = (total_days - total_show)*24;//剩余小时
    hours_show = Math.floor(total_hours);//实际显示的小时数
    total_minutes = (total_hours - hours_show)*60;//剩余的分钟数
    minutes_show = Math.floor(total_minutes);//实际显示的分钟数
    total_seconds = (total_minutes - minutes_show)*60;//剩余的分钟数
    seconds_show = Math.floor(total_seconds);//实际显示的秒数
    if(total_days<10){
        total_days="0"+total_days;
    }
    if(hours_show<10){
        hours_show="0"+hours_show;
    }
    if(minutes_show<10){
        minutes_show="0"+minutes_show;
    }
    if(seconds_show<10){
        seconds_show="0"+seconds_show;
    }
    show_time.find("li").eq(0).text(total_show);//显示在页面上
    show_time.find("li").eq(2).text(hours_show);
    show_time.find("li").eq(4).text(minutes_show);
    show_time.find("li").eq(6).text(seconds_show);
})();
<?php } ?>
function share(){
	$('.share_bg').show();
	$('.share_bg').click(function(){
		if($(this).css('display') == 'block'){
			$(this).css('display','none');
		}
	});
}

	</script>
    <style type="text/css">
    /* 优惠说明 */
    .direction{width: 290px;border: 5px solid rgba(46,37,79,.8);border-radius: 5px;background:#463870 url("<?php echo $staticPath ?>/yousetdiscount/images/ball.png") no-repeat left bottom; background-size:50px 50px;color: #fff}
    .direction .addPad{padding: 15px 20px 50px 20px;background: url("<?php echo $staticPath ?>/yousetdiscount/images/rulebg.png") repeat top center;}
    .direction .addPad .addPad-li { padding: 6px 0; }
    .direction .getBtn { float: right; padding: 1px 6px; background-color:#44b549; color: #fff; border-radius: 2px; }
    .direction .noBtn { float: right; padding: 1px 6px; background-color:#ccc; color: #fff; border-radius: 2px; }
    .direction h2{color: #ffde20;font-size: 16px;font-weight: normal}
    .direction p{padding-top: 15px;}
    .direction .xClosed,.oLogin .oClosed {position: absolute;top:-12px;right:-12px;width: 20px;height: 20px;background:#ffea73 url("<?php echo $staticPath ?>/yousetdiscount/images/xclosed.png") center center no-repeat;background-size: 15px 15px;border-radius: 100%;padding: 5px; }

    #fancybox-left span { left : auto; left : 20px; }
    #fancybox-right span { left : auto; right : 20px; }
    .layer { position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,.5); z-index: 9; }
    .layer_content {background: #fff; position: fixed; width: 80%; left: 10%; top: 50%; text-align: center; z-index: 10; /*height: 30rem;*/ margin-top: -15rem; }
    .layer_content .layer_title {font-size: 1.4rem; color: #fff; padding: .6rem 1rem; background: #45a5cf; text-align: left; }
    .layer_content .layer_text { padding-top: 1rem; padding-bottom: 1rem; }
    .layer_content p {font-size: 1.4rem; color: #333333; line-height: 1.4rem; }
    .layer_content img {width: 80%; max-width: 22rem; margin: 1rem 0; }
    .layer_content p span {font-size: .45rem; color: #999; line-height: 0.9rem; }
    .layer_content button {background: #ff9c00; width: 5.5rem; height: 1.5rem; color: #fff; line-height: 1.5rem; border-radius: 1.5rem; margin: .6rem 0; }
    .layer_content i {background: url(/template/wap/default/ucenter/images/weidian_25.png) no-repeat; background-size: 1rem; height: 1.2rem; width: 1.24rem; display: inline-block; vertical-align: middle; position: absolute; right: -.5rem; top: -.5rem; }

    </style>
</head>
<body style="padding-bottom: 40px;">

<?php if ($qrcode['error_code'] == 0 && $info['is_attention'] == 1 && empty($is_subscribe)) { ?>
<aside>
    <div class="layer"></div>
    <div class="layer_content">
        <!-- <i class="close"></i> -->
        <div class="layer_title">顶部： 亲，店家发现你还未关注店家的公众号，关注后才能参加店铺活动哦</div>
        <div class="layer_text">
            <p>第一步：长按二维码并识别</p>
            <img style="margin: 0 auto;" src="<?php echo $qrcode['ticket'];?>" >
            <p>第二步：打开图文再次进入本次活动</p>
        </div>
    </div>
</aside>
<?php } ?>

<section class="banner">
    <img src="<?php echo $info['bg1'] ?>" class="bn" alt="bn" style="width: 100%;" />
    <img src="<?php echo $info['bg2'] ?>" class="bannertit" alt="bannertit" height="78.5"/>
    <!-- <img src="<?php echo $info['bg3'] ?>" class="yellowtit" alt="yellowtit" height="50"/> -->
    <section class="boom oTime">
        <img src="<?php echo $staticPath ?>/yousetdiscount/images/boom.png" alt="boom"/>
            <div class="timeBox">
                <h2>
                    <?php if($is_over == 1){echo '距离开始还剩';}elseif($is_over == 0){echo '时间还剩';}else{echo "活动结束";} ?>
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
            </div>
    </section>
    <a class="aRule"></a>
</section>
<?php if ($info['discount_type'] == 1) { ?>
<section class="coupon">
    <div class="fl">
        <div class="avatar">
            <img src="<?php if ($user['userinfo']['avatar'] != '') { echo $user['userinfo']['avatar']; } else { echo $staticPath.'/yousetdiscount/images/portrait.jpg'; } ?>" alt="avatar">
            <h2>
				<?php $user['userinfo']['nickname'] = mb_substr($user['userinfo']['nickname'],0,10,'utf-8');?>
                <?php echo $user['userinfo']['nickname']?$user['userinfo']['nickname']:'匿名';?>
            </h2>
        </div>
        <p class="endTime">日期:<?php echo date('Y/m/d', $info['enddate']) ?>止</p>
    </div>
    <div class="rightPart mt20">
	<?php if ($helps_sum != 0) { ?>

        <div class="limit">
            <i>￥</i><em <?php if ($share_key == '' && $user['state'] != 1) { ?>style="font-size: 2.5rem;"<?php } else { ?>style="font-size: 4rem;"<?php } ?>><?php echo $helps_sum ?></em>
        </div>
        <p><a href="javascript:direction(true);">点此查看兑换说明</a></p>

		<?php if ($user['state'] != 1) { ?>
            <p>接力越多，分值越高</p>
        <?php } ?>
		
        <?php if ($share_key == '') { ?>
            <div class="code">
                <?php if ($user['state'] == 1) { ?>
                    <em><?php echo $coupon_txt ?></em>
                <?php } else { ?>
                    <a href="javascript:direction();"><em>领取优惠劵</em></a>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="code">
                <?php if ($user['state'] == 1) { ?>
                <em><?php echo $coupon_txt ?></em>
                <?php } ?>
            </div>
        <?php } ?>

	<?php } else { ?>
		<div class="limit"><i>￥</i><em style="font-size: 5rem;"><?php echo $helps_sum ?></em></div>
		<p>快去玩游戏，赚取积分吧</p>
	<?php } ?>
    </div>

</section>

<?php } elseif ($info['discount_type'] == 2) { // 折扣模式，停用 ?>

<section class="coupon">
    <div class="fl">
        <div class="avatar">
            <img src="<?php if ($user['userinfo']['avatar'] != '') { echo $user['userinfo']['avatar']; } else { ?><?php echo $staticPath?>/yousetdiscount/images/portrait.jpg<?php } ?>" alt="avatar">
            <h2>
                <?php $user['userinfo']['nickname'] = mb_substr($user['userinfo']['nickname'],0,10,'utf-8'); ?>
                <?php echo $user['userinfo']['nickname']?$user['userinfo']['nickname']:'匿名'; ?>
				<?php echo mb_strlen($hv['userinfo']['nickname'],'UTF8')>10?'...':''; ?>
            </h2>
        </div>
        <!-- <p class="endTime">有效期: xxTODOxx止</p> -->
    </div>
    <div class="rightPart mt20">
	<?php if ($helps_sum != 0) { ?>
        <div class="cut" <?php if ($share_key == '') { ?>style="font-size: 4.5rem;"<?php } else { ?>style="font-size: 6rem;"<?php } ?>>
            <?php echo (10 - $helps_sum) < $info['discount_min'] ? $info['discount_min'] : (10 - $helps_sum); ?><i>折</i>
			<p class="endTime">最高可优惠到<?php echo $info['discount_min']?>折</p>
        </div>
        <?php if ($share_key == '') { ?><div class="code">兑换码<em><?php if ($user['state'] == 1) { echo '已使用'; } else { echo 10000000 + $user['id']; } ?></em></div><?php } ?>
	<?php } else { ?>
		<div class="cut" style="font-size: 5rem;">
			<?php echo (10 - $helps_sum) < $info['discount_min'] ? $info['discount_min'] : (10 - $helps_sum); ?><i>折</i>
		</div>
		<p>快去玩游戏，赚取积分吧</p>
	<?php } ?>
    </div>

</section>

<?php } ?>
<?php if ($user['state'] != 1) { ?>
<?php if ($share_key == '') { ?>
<section class="tip tc mb20">
    <img src="<?php echo $staticPath ?>/yousetdiscount/images/tip.png" alt="tip" height="120" />
</section>
<?php } ?>
<section class="aBtn">
	<?php
	$cishu = $share_key ? ($info['friends_count']-$playcount) : ($info['my_count'] - $playcount);
	if ($cishu > 0) {
		$cishu_text = '帮'.$wota.'抢优惠('.$cishu.')次';
		// $cishu_url = U('Wap/YouSetDiscount/index',array('token'=>$token,'id'=>$info['id'],'share_key'=>$share_key,'game'=>'go'));
        $cishu_url = './yousetdiscount.php?action=index&store_id='.$info['store_id'].'&id='.$info['id'].'&share_key='.$share_key.'&game=go';
	} else {
		$cishu_text = '次数已用完';
		$cishu_url = "javascript:;";
	}
	?>
	<?php if ($is_over != 0) { ?>
	<a><?php echo $is_over == 1 ? '未开始' : '已结束'; ?></a>
	<?php } else { ?>
		<?php if ($memberNotice != '') { ?>
			<?php if ($sms == 1) { ?>
				<a href="javascript:login();"><?php echo $cishu_text ?></a>
			<?php } else { ?>
				<a href="#memberNoticeBox" id="modaltrigger_notice"><?php echo $cishu_text ?></a>
			<?php } ?>
		<?php } else { ?>
			<a href="<?php echo $cishu_url;?>" <?php if ($cishu <= 0) { ?>style="background: url('<?php echo $staticPath ?>/yousetdiscount/images/abtn1.png') no-repeat;background-size: cover;"<?php } ?>><?php echo $cishu_text ?></a>
		<?php } ?>
	<a href="javascript:share();">邀请好友帮<?php echo $wota ?>抢优惠</a>
	<?php } ?>
</section>
<?php } ?>

<?php if (count($helps) < 1) { ?>
<section class="noData">
    <img src="<?php echo $staticPath ?>/yousetdiscount/images/nodata.png" alt="nodata">
</section>
<?php } else { ?>
<section class="otherUser">
    <div class="hd">
        <div class="tit">
            <h2>有<?php echo count($helps);?>人给<?php echo $wota ?>抢优惠</h2>
        </div>
        <div class="line">
            <i class="fr"></i>
            <i class="fl"></i>
            <div class="lineThis"></div>
        </div>
    </div>
    <div class="bd">
        <ul>
            <?php foreach ($helps as $hv) { ?>
            <li>
                <div class="liwrap">
                    <div class="clearfix">
                        <div class="userAvatar fl">
                            <img src="<?php if ($hv['userinfo']['avatar'] != '') { echo $hv['userinfo']['avatar']; } else { ?><?php echo $staticPath ?>/yousetdiscount/images/portrait.jpg<?php } ?>">
                        </div>
                        <div class="desc">
                            <h3><?php echo $hv['userinfo']['nickname'] ? mb_substr($hv['userinfo']['nickname'],0,6,'utf-8') : '匿名'; ?><?php echo mb_strlen($hv['userinfo']['nickname'],'UTF8') > 6 ? '...' : ''; ?></h3>
                            <p class="money"><?php echo $info['discount_type'] == 1 ? '' : '<i>下降</i>'; ?><?php echo round($hv['discount'],2) ?><i><?php echo $info['discount_type'] == 1 ? '元' : '折'; ?></i></p>
                            <p class="tipText">玩了<?php echo count($hv['helps_data']); ?>次</p>
                            <a class="arrowa" href="javascript:;">
                            </a>
                        </div>
                    </div>
                    <div class="subInfo">
                        <ol>
							<?php foreach ($hv['helps_data'] as $hdv) { ?>
                            <li>
                                <span style="width:23%"><?php echo $info['discount_type']==1 ? '抢到优惠' : '下降了'; ?></span>
                                <span style="width:37%"><?php echo round($hdv['discount'],2); ?><?php echo $info['discount_type'] == 1 ? '元' : '折'; ?></span>
                                <span><?php echo date('Y-m-d', $hdv['addtime']) ?></span>
                            </li>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
                <div class="no">
                    <i><?php echo $i ?></i>
                </div>

            </li>
            <?php } ?>
        </ul>
    </div>
</section>
<?php } ?>
<?php if ($share_key != '') { ?>
<a class="backTo" href="./yousetdiscount.php?action=index&id=<?php echo $info['id'] ?>&store_id=<?php echo $info['store_id'] ?>"><i>我要优惠</i></a>
<?php } ?>
<div class="fullBg"></div>
<div class="window oLogin">
    <div class="windowThis">
        <div class="bd">
            <div class="adMargin">
                <div class="row">
                    <div class="putBorder"> <i></i>
                        <input type="text" placeholder="手机号" value="" name='tel'>
                    </div>
                </div>
                <div class="row">
                    <div class="putBorder"> <a href="javascript:;" class="getCode">获取验证码</a> <i></i>
                        <input type="text" placeholder="验证码" value="" name='code'>
                    </div>
                </div>
                <div class="row">
                    <button id="telyzbut">确定</button>
                </div>
            </div>
            <a href="javascript:;" onClick="setWindow.windowClosed()" class="oClosed"></a> </div>
    </div>
</div>

<div class="window wRule">
    <div class="addPad" style="height: 280px;overflow: auto;">
        <h2>活动规则</h2>
        <?php echo htmlspecialchars_decode($info['info']) ?>
    </div>
    <a class="xClosed" href="javascript:;" onclick="setWindow.windowClosed()"></a>
</div>

<!-- 优惠说明 -->
<div class="window direction">
    <div class="addPad">
        <h2>兑换说明</h2>
        <?php foreach ($direction as $div) { ?>
            <div class="addPad-li">满 <?php echo $div['at_least'] ?> 分领 <?php echo $div['face_money'] ?> 元优惠劵 
                <a href="javascript:void(0)" class="<?php if ($helps_sum >= $div['at_least']) { echo 'getBtn js-getCoupon'; } else { echo 'noBtn'; } ?>" data-coupon_id="<?php echo $div['coupon_id'] ?>" data-did="<?php echo $div['id'] ?>" data-face_money="<?php echo $div['face_money'] ?>">领取</a>
            </div>
        <?php } ?>
		<br/>
		注意：本活动仅可兑换一次优惠劵，请参照以上范围兑换。
    </div>
    <a class="xClosed" href="javascript:;" onclick="setWindow.windowClosed()"></a>
</div>

<div class="share_bg" style="display: none;position: fixed;top: 0;left: 0;width: 100%;height: 100%;text-align: center;background: rgba(0,0,0,0.7);z-index: 99;">
    <img src="<?php echo $staticPath ?>yousetdiscount/images/share-guide.png" style="width: 100%;">
</div>
<style>
.tips{width: 100%;position: fixed;top: 0;left: 0;display: none;z-index: 999999}
.tips h3{width: 70%;padding: 10px 0;  margin: 0 auto;  background: rgba(255,255,255,1);  text-align: center;  font-size: 1.2rem; color: red;}
</style>
<div class="tips" style="display: none;"><h3></h3></div>
<div style="display:none;">
<?php echo option('config.wap_site_url').'/yousetdiscount.php?action=index&store_id='.$info['store_id'].'&id='.$info['id'].'&share_key='.$user['share_key']; ?>
</div>
<script>
function alert(text){
	var t=null;
	clearTimeout(t);
	var tip= $(".tips");
	tip.find('h3').text(text);
	tip.slideDown();
	t=setTimeout(function(){ tip.slideUp()},3000);
}
</script>
<?php
    $helps_sum = $helps_sum ? $helps_sum : 0;
    if ($info['discount_type'] == 1) {
    	$youhuizhi = $helps_sum.'分';
    } else {
    	$youhuizhi = (10 - $helps_sum) < $info['discount_min'] ? $info['discount_min'] : (10 - $helps_sum);
    	$youhuizhi = $youhuizhi.'折';
    }

    if ($memberNotice == '' && $is_over == 0) {
        $shareData = _createShareData($YouSetDiscount, 'game', $user, $youhuizhi);
    } else {
        $shareData = _createShareData($YouSetDiscount, 'simple', $user, $youhuizhi);
    }
    echo $shareData;
?>
</body>
</html>