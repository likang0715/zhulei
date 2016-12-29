<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL; ?>/css/base.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL; ?>/ucenter/css/usercenter1.css" type="text/css">
    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <title>分销管理-推广海报</title>
</head>
<body>
<script type="text/javascript">
    $(function(){
        // 分享遮罩
        $(".js-btn-copy").click(function () {
            $("#js-share-guide").removeClass("hide");
        });

        $("#js-share-guide").click(function () {
            $("#js-share-guide").addClass("hide");
        });
    })
</script>
<div class="hbPage">
    <div class="row">
        <div class="cellRow addBorder">
            <h2 style="text-align: center;font-weight:bold;">商家推广名片</h2>
        </div>
        <div class="cellRow addBorder">
            <span class="nameSpan">我的昵称</span><span class="nameDesc"><?php echo $promote['store_nickname'] ? $promote['store_nickname'] : $now_store['name'];?></span>
        </div>
        <div class="cellRow">
            <span class="nameSpan">推广对象</span><span class="nameDesc"><?php echo $now_store['name'];?></span>
        </div>
    </div>
    <div class="row">
        <div class="hd">
            <h2>
                名片/海报的作用
            </h2>
        </div>
        <p>
            1、分销商推广自己的名片可获得更多的下级用户<br />
            2、分销商也可引入更多的流量<br />
            3、帮助供货商销售更多的商品，获得更多的分润<br />
            4、用户也可给平台推广，可获得平台提供的奖励
        </p>
    </div>
    <div class="row">
        <div class="hd">
            <h2>
                当前名片样式
            </h2>
        </div>
        <div class="hbImg">
            <?php if($promote['poster_type'] == 1) {?>
                <img src="<?php echo TPL_URL; ?>img/1.png" width="250" height="210"/>
            <?php } elseif ($promote['poster_type'] == 2) {?>
                <img src="<?php echo TPL_URL; ?>img/2.png" width="200" height="270"/>
            <?php } elseif ($promote['poster_type'] == 3) {?>
                <img src="<?php echo TPL_URL; ?>img/3.png" width="250" height="250"/>
            <?php }?>
        </div>
    </div>
    <div class="hbBtn">
        <ul>
            <li>
                <a class="js-btn-copy" href="javascript:;">链接分享</a>
            </li>
            <li>
                <a href="javascript:;" class="down">获取店铺名片</a>
            </li>
        </ul>
    </div>
    <div id="js-share-guide" class="js-fullguide fullscreen-guide hide" style="font-size: 16px; line-height: 35px; color: #fff; text-align: center;"><span class="js-close-guide guide-close">×</span><span class="guide-arrow"></span><div class="guide-inner">请点击右上角<br>通过【发送给朋友】功能<br>或【分享到朋友圈】功能<br>把信息分享给朋友～</div></div>
    <script>
        $('.down').click(function(){
            var act = 'down';
            var store_id = '<?php echo $_GET['store_id'];?>';
            var loadi =layer.load('海报正在生成', 10000000000000);
            $.post('./drp_store_qrcode.php',{'act':act,'store_id':store_id},function(data){
                layer.close(loadi);
                if(data.error_code == 0){
                    window.location.href='<?php option('config.site_url');?>'+data.message;
                } else if (data.error_code == 1001){
                    alert(data.message);
                }
            },'json');
        });
    </script>
</div>
<?php echo $shareData;?>
</body>
</html>