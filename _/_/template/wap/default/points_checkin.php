<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL;?>points/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>points/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>points/css/usercenter.css" type="text/css">
    <title>签到中心</title>
    <script src="<?php echo TPL_URL;?>points/js/rem.js"></script>
    <script src="<?php echo TPL_URL;?>points/js/jquery-1.7.2.js"></script>
    <script type="text/javascript">
        $(function(){

            var html="<small class='addBonus'>+"+"<?php echo $data['points'] ?>"+"</small>";
            var t=null;
            function showBonus(){
                $("body").append(html);
                $(".addBonus").addClass('zoomIn').show();
                t=setTimeout(function(){
                    $(".addBonus").removeClass('zoomIn');
                    $(".addBonus").addClass('zoomOut')
                    $(".addBonus").animate({'top':'50%'},1000,function(){
                        $(".addBonus").remove();
                    });
                },2000)
            }

            var points_checkin_url = "checkin.php?act=ajax_checkin";
            $("#signBtn").on('click',function(){
                var store_id = "<?php echo $store_id ?>";
                clearTimeout(t);
                $.post(points_checkin_url, {store_id:store_id}, function(result){
                    if (typeof(result) == 'object') {
                        if (result.err_code) {
                            alert(result.err_msg);
                        } else {
                            $("#signBtn").remove();
                            $("#signText").text("您今天已经获得 <?php echo $data['points'] ?> 积分");
                            showBonus();
                        }
                    } else {
                        alert('系统异常，请重试提交');
                    }
                });
            });

            // 分享遮罩
            $(".js-btn-copy").click(function () {
                $("#js-share-guide").removeClass("hide");
            });
            
            $("#js-share-guide").click(function () {
                $("#js-share-guide").addClass("hide");
            });

        });
    </script>
</head>
<body>
<div class="signIn">
    <div class="signInBanner">
       <img src="<?php echo TPL_URL;?>points/images/singinbanner.png"/>
        <div class="signBtn">
            <?php if ($data['is_checkin'] == 0) { ?>
            <a id="signBtn" href="javascript:void(0)">点我签到</a>
            <?php } ?>
        </div>
    </div>
    <div class="signUserInfo">
        <div class="signWrap">
            <h3>尊敬的会员 “<em><?php echo $wap_user['nickname'] ?></em>”</h3>
            <p>
            <?php if ($storePointsConfig['sign_type'] == 1) {
                echo '初次签到可得 '.$storePointsConfig['sign_plus_start'].' 积分，<br/>连续签到每日额外增加 '.$storePointsConfig['sign_plus_addition'].' 积分，<br/>最多为 '.$maxSignPoint.' 积分';
            } else {
                echo '每日签到可得 '.$storePointsConfig['sign_fixed_point'].' 积分';
            } ?>
            </p>
            <div class="signTip">
                <em id="signText">
                <?php if ($data['is_checkin']) {
                    echo "您今天已经获得 ".$data['points']." 积分";
                } else {
                    echo "您还未签到哦！！";
                } ?>
                </em>
            </div>
        </div>
    </div>
    <div class="task">
        <div class="blueTitle">任务区</div>
        <div class="row">
            <h3><i></i>任务一</h3>
            <p>分享下面链接到朋友圈  朋友点击就有可能给你带来积分收入哦</p>
            <div class="copyUrl">
                <a href="javascript:;" class="fr js-btn-copy" data-clipboard-text="<?php echo $data['share_link'] ?>">分享链接</a>
                <input type="text" value="<?php echo $data['share_link'] ?>" />
            </div>
        </div>
        <div class="row">
            <h3><i></i>任务二</h3>
            <p>将下面二维码分享到朋友圈，朋友扫码就有可能给你带来积分收入哦</p>
        </div>
    </div>
    <div class="follow">
        <div class="followWrap">
            <h2>欢迎关注<em><?php echo $storeInfo['name'] ?></em></h2>
            <div class="clearfix followInfo">
                <div class="followQrCode fl">
                    <img src="<?php echo option('config.site_url'); ?>/source/qrcode.php?type=pointShare&id=<?php echo $wap_user['uid']?>&url=<?php echo urlencode($data['share_link']) ?>"/>
                </div>
                <div class="followMe">
                    <div class="followText">
                        欢迎关注微店 “<?php echo $storeInfo['name'] ?>”，<br>
                        关注微店有好礼赠送。
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="js-share-guide" class="js-fullguide fullscreen-guide hide" style="font-size: 16px; line-height: 35px; color: #fff; text-align: center;"><span class="js-close-guide guide-close">×</span><span class="guide-arrow"></span><div class="guide-inner">请点击右上角<br>通过【发送给朋友】功能<br>或【分享到朋友圈】功能<br>把信息分享给朋友～</div></div>
<?php 
$share_conf     = array(
    'title'     => "关注微店，好礼赠送！", // 分享标题
    'desc'      => "欢迎关注微店 “".$storeInfo['name']."”，关注微店有好礼赠送。", // 分享描述
    'link'      => $data['share_link'], // 分享链接
    'imgUrl'    => option('config.site_url')."/upload/".$storeInfo['logo'], // 分享图片链接
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
