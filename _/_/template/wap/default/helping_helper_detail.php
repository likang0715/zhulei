<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>帮忙助力详情</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/helping/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/helping/style.css">
    <script src="<?php echo TPL_URL;?>js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo TPL_URL;?>js/helping.js"></script>
    <script>
        var timer=0;
        $(function(){
            var docHeight = $(document).height();
            $(".fullBg").height(docHeight);
            tab(".tabBox .hd ul li",".tabBox .bd .row","on");
            centerWindow(".window");
            $(".fullBg").click(function(){
                $(".window").removeClass("animate").hide();
                $(this).hide();
                clearTimeout(timer);
            });
        });
    </script>
</head>
<body>
<section class="topInfo">
    <div class="light0 animate">
        <img class="rotate360" src="<?php echo TPL_URL;?>/images/helping/roundLight.png"/>
    </div>
    <div class="singleInfo">
        <h2><?php echo $nickname;?></h2>
        <div class="ulBox">
            <ul>
                <li>排&nbsp;&nbsp;&nbsp;名：<?php echo $my_join_count>0 || $share_join_count>0?"第<em>".$my_rank."</em>位":"未参与";?></li>
                <li>助力值：<i><?php echo $share_join_info['help_count'];?></i></li>
                <li>转发数：<i><?php echo $share_join_info['share_num'];?></i></li>
            </ul>
        </div>

        <div class="topAvatar">
            <div class="imgT0">
                <i class="starl0"></i>
                <i class="starl1"></i>
                <i class="starr0"></i>
                <i class="starr1"></i>
            </div>
        </div>
        <div class="avatarThis">
            <div class="avatarImg">
                <img src="<?php echo $avatar;?>"/>
            </div>
        </div>

    </div>
</section>

<section class="otherUser">
    <div class="hd">
        <div class="tit">
            <h2>助力列表</h2>
        </div>
        <div class="line">
            <i class="fr"></i>
            <i class="fl"></i>
            <div class="lineThis"></div>
        </div>
    </div>
    <div class="bd">
        <ul>
            <?php foreach($helps_list as $hk=>$hv) { ?>
            <li>
                <div class="userAvatar fl">
                    <img src="<?php echo $hv['avatar'];?>"/>
                </div>
                <div class="desc">
                    <h3><?php echo $hv['nickname'];?></h3>
                    <p><?php echo date("Y-m-d H:i:s",$hv['addtime']);?></p>
                </div>
            </li>
            <?php } ?>
            <li>
                <div class="userAvatar fl">
                    <img src="<?php echo $share_join_info['avatar'];?>"/>
                </div>
                <div class="desc">
                    <h3><?php echo $share_join_info['nickname'];?></h3>
                    <p><?php echo date("Y-m-d H:i:s",$share_join_info['add_time']);?></p>
                </div>
            </li>
            <?php if($helps_count > 99){ ?>
            <li><center style="color:#fff">只显示最新的100位</center></li>
            <?php } ?>
        </ul>
    </div>
</section>
<footer>
    <div class="oBtn">
        <?php if($user_token!=$_GET['share_key']){ ?>
        <a href="/wap/helping.php?action=detail&id=<?php echo $pid;?>&share_key=<?php echo $_GET['share_key'];?>">返回助力页面</a>
        <?php }else{ ?>
        <a href="/wap/helping.php?action=detail&id=<?php echo $pid;?>">返回助力页面</a>
        <?php } ?>
    </div>
</footer>
</body>
</html>
