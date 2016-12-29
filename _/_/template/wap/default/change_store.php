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
    <title>分销店铺 - 店铺切换</title>
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/style.css" rel="stylesheet">
    <script src="<?php echo TPL_URL;?>ucenter/js/jQuery.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>ucenter/js/jqplot.js"></script>
    <style type="text/css">
        .header_title {

            width: 100%;

        }
        #account {
            height: auto;
            background-color: #FFD100;
            width: 90%;
            padding: 10px 10px 10px 10px;
            font-size: 14px;
            margin: 0 auto;
            margin-top: 5px;
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
            background-color: #fcf8e3;
            border: 1px solid #fbeed5;
            border-radius: 5px;
        }
        #account ul li {
            line-height: 25px;
        }
        #stores {
            margin-top: -5px;
        }
    </style>
</head>

<body>
<header class="header_title">
	<?php if($_COOKIE['wap_store_id']) {?>
		<a href="./ucenter.php?id=<?php echo $_COOKIE['wap_store_id'];?>#promotion" onclick="javascript:history.go(-1);"><i></i></a>
	<?php } else {?>
		<a href="javascript:void(0)" onclick="javascript:history.go(-1);"><i></i></a>
	<?php }?>
    <p>店铺切换</p>
</header>
<div id="account">
    <ul>
        <li>PC端店铺管理信息</li>
        <li class="msg-li"><?php echo $login_url; ?></li>
        <li class="msg-li">登录账户：<?php echo $user['phone']; ?></li>
        <li class="msg-li">登录密码：默认与账户相同&nbsp;&nbsp;&nbsp;<a href="drp_ucenter.php?a=profile" style="color: #45a5cf;">修改</a></li>
    </ul>
</div>
<article id="stores">
    <ul class="acticity_list fan_list_table">
        <li>
            <section>
                <ul class="store_list">
                    <?php foreach($stores as $store_info) {?>
                        <li class="clearfix">
                            <a href="./home.php?id=<?php echo $store_info['store_id'];?>">
                                <i></i>
                                <div class="store_img"><img src="<?php echo $store_info['logo']?>"></div>
                                <div class="store_txt">
                                    <div class="store_name <?php echo $current_store['store_id'] == $store_info['store_id'] ? 'mine' : ''?>">
                                        <h3><?php echo $store_info['name']?></h3>
                                        <?php if($current_store['root_supplier_id'] == $store_info['root_supplier_id']){?>
                                            <span>当前店铺</span>
                                        <?php }?>
                                    </div>
                                    <p>供货商：<?php echo $store_info['supplier'];?></p>
                                </div>
                            </a>
                        </li>
                    <?php }?>
                </ul>
            </section>
        </li>
    </ul>

</article>
</body>
<script src="<?php echo TPL_URL;?>js/rem.js"></script>
</html>
