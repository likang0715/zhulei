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
    <title>分销店铺 - 团队管理</title>
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/style.css" rel="stylesheet">
</head>

<body>
<header class="header_title">
    <a href="javascript:void(0)" onclick="javascript:history.go(-1);"><i></i></a>
    <p>团队排名</p>
</header>
<nav class="title_table activity_title">
    <ul class="clearfix">
        <li class=" active"><a href="">所属总队排名</a></li>
        <li><a href="">我在团队中的排名</a></li>
    </ul>
</nav>
<article>
    <ul class="acticity_list team_pading">
        <li>
            <section>
                <ul class="team_list">
                    <?php if(!empty($team_list)) {?>
                    <?php foreach($team_list as $k => $team){?>
                            <?php if($team['pigcms_id'] == $store['drp_team_id']) {?>
                            <li class="clearfix">
                                <a href="">
                                    <div class="team_num"><?php echo $k+1;?></div>
                                    <div class="team_img"><img src="<?php echo !empty($team['logo']) ? $team['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg';?>"></div>
                                    <div class="team_txt">
                                        <h4><?php echo $team['name'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#45a5cf">当前团队</span></h4>
                                        <p>销售额:<span>￥<?php echo $team['sales']?></span></p>
                                    </div>
                                </a>
                            </li>
                            <?php }?>
                        <?php }?>

                        <?php foreach($team_list as $k => $team){?>
                            <?php if($team['pigcms_id'] != $store['drp_team_id']) {?>
                                <li class="clearfix">
                                    <a href="">
                                        <div class="team_num"><?php echo $k+1;?></div>
                                        <div class="team_img"><img src="<?php echo !empty($team['logo']) ? $team['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg';?>"></div>
                                        <div class="team_txt">
                                            <h4><?php echo $team['name']?></h4>
                                            <p>销售额:<span>￥<?php echo $team['sales']?></span></p>
                                        </div>
                                    </a>
                                </li>
                            <?php }?>
                        <?php }?>
                    <?php } else {?>
                        <li class="clearfix">
                            <div style="text-align: center;">还未创建团队</div>
                        </li>
                    <?php }?>
                </ul>
            </section>
        </li>
        <li>
            <section>
                <ul class="team_list">
                    <?php if(!$is_owen){?>
                        <li class="clearfix">
                            <a href="">
                                <div class="team_num"><?php echo count($team_members)+1;?></div>
                                <div class="team_img"><img src="<?php echo !empty($now_store['logo']) ? $now_store['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg';?>"></div>
                                <div class="team_txt">
                                    <h4><?php echo $now_store['name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#45a5cf">当前店铺</span></h4>
                                    <p>销售额:<span>￥<?php echo $now_store['sales']?></span></p>
                                </div>
                            </a>
                        </li>
                    <?php }?>
                    <?php foreach($team_members as $k => $members){?>
                        <?php if($is_owen){?>
                            <?php if($members['store_id'] == $now_store['store_id']) {?>
                                <li class="clearfix">
                                    <a href="">
                                        <div class="team_num"><?php echo $k+1;?></div>
                                        <div class="team_img"><img src="<?php echo !empty($members['logo']) ? $members['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg';?>"></div>
                                        <div class="team_txt">
                                            <h4><?php echo $members['name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#45a5cf">当前店铺</span></h4>
                                            <p>销售额:<span>￥<?php echo $members['sales']?></span></p>
                                        </div>
                                    </a>
                                </li>
                            <?php }?>
                        <?php }?>
                    <?php }?>

                    <?php foreach($team_members as $k => $members){?>
                        <?php if($members['store_id'] != $now_store['store_id']) {?>
                            <li class="clearfix">
                                <a href="">
                                    <div class="team_num"><?php echo $k+1;?></div>
                                    <div class="team_img"><img src="<?php echo !empty($members['logo']) ? $members['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg';?>"></div>
                                    <div class="team_txt">
                                        <h4><?php echo $members['name']?></h4>
                                        <p>销售额:<span>￥<?php echo $members['sales']?></span></p>
                                    </div>
                                </a>
                            </li>
                        <?php }?>
                    <?php }?>
                </ul>
            </section>
        </li>
    </ul>
</article>
</body>
<script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/rem.js"></script>
</html>
