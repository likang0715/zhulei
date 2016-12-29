<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>最新揭晓 - 夺宝</title>
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/bef6decb938119df87327e5e548e997f221af746.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/8f0eca98fbe69d4f3877522fb22f2fb1e5e5ca89.css">
    <script src="<?php echo STATIC_URL;?>unitary/js/jquery-1.7.1.min.js" type="text/javascript"></script>
</head>
<body>
<?php include display('public:header_unitary'); ?>
<div class="g-body">
    <div class="m-results" module="results/Results" id="pro-view-6" module-id="module-5" module-launched="true">
        <div class="g-wrap f-clear">
            <div class="g-main m-results-revealList">
                <div class="m-results-mod-hd">
                    <h3>最近揭晓</h3>
                </div>
                <div class="m-results-mod-bd">
                    <ul class="w-revealList f-clear">
                        <?php foreach ($endList as $val) { ?>
                        <li class="w-revealList-item">
                            <div class="w-goods w-goods-reveal">
                                <div class="w-goods-info">
                                    <div class="w-goods-pic">
                                        <a href="<?php dourl('unitary:detail', array('id'=>$val['id'])) ?>" target="_blank">
                                            <img width="200" height="200" data-src="<?php echo $val['logopic'] ?>" class="lazyimg" src="<?php echo STATIC_URL;?>unitary/images/l.png">
                                        </a>
                                    </div>
                                    <p class="w-goods-title f-txtabb">
                                        <a href="<?php dourl('unitary:detail', array('id'=>$val['id'])) ?>" target="_blank"><?php echo $val['name'] ?></a>
                                    </p>
                                    <p class="w-goods-price">总需：<?php echo $val['total_num'] ?>人次</p>
                                    <p class="w-goods-period">期号：<?php echo $val['id'] ?></p>
                                </div>
                                <?php if ($val['is_countdown']) { ?>
                                    <div class="w-countdown">
                                        <p class="w-countdown-title"><i class="ico ico-countdown ico-countdown-gray"></i>揭晓倒计时</p>
                                        <p class="w-countdown-nums js-countdown jstimer" data-countdown="<?php echo $val['countdown_time'] ?>">
                                            <b>x</b><b>x</b>:<b>x</b><b>x</b>:<b>x</b><b>x</b>
                                        </p>
                                    </div>
                                <?php } else { ?>
                                    <div class="w-record">           
                                        <div class="w-record-avatar">
                                            <a href="javascript:void(0)" target="_blank">
                                                <img src="<?php echo $val['luck_user']['avatar'] ?>" style="width:40px;height:40px;">
                                            </a>
                                        </div>
                                        <div class="w-record-detail">
                                            <p class="user f-breakword">恭喜<a href="javascript:void(0)" title="<?php echo $val['luck_user']['nickname'] ?>"><?php echo $val['luck_user']['nickname'] ?></a><span class="txt-green"><?php if (!empty($val['luck_user']['address'])) { echo '('.$val['luck_user']['address'].')'; } ?></span>获得该商品</p>
                                            <p>幸运号码：<b class="txt-red"><?php echo $val['lucknum'] ?></b></p>
                                            <p>参与人次：<b class="txt-red"><?php echo $val['total_num'] ?></b></p>
                                            <p>揭晓时间：<span><?php echo date("Y-m-d H:i:s", $val['endtime']) ?></span></p>
                                            <p><a class="w-button w-button-simple" href="<?php dourl('unitary:detail', array('id'=>$val['id'])) ?>" target="_blank">查看详情</a></p>
                                        </div>       
                                    </div>
                                <?php } ?>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="m-results-revealList-end" style="display:none" pro="endTip">
                    <p style="padding:20px 0;text-align:center;">以上是最近三天揭晓的全部商品~</p>
                </div>
            </div>
            <div class="g-side">
                <div class="m-results-leastRemain">
                    <div class="m-results-leastRemain-title">
                        <h4>最快揭晓</h4>
                    </div>
                    <div class="m-results-leastRemain-title-ft"></div>
                    <div class="m-results-leastRemain-main">
                        <ul class="w-remainList">
                            <?php foreach ($fastList as $val) { ?>
                            <li class="w-remainList-item">
                                <?php if (in_array($val['item_price'], $area_ids)) { ?>
                                    <i class="ico ico-label " style="background: url(<?php echo $area_icons[$val['item_price']] ?>)"></i>
                                <?php } ?>
                                <div class="w-goods w-goods-ing">
                                    <div class="w-goods-pic">
                                        <a href="<?php echo dourl('unitary:detail', array('id'=>$val['id'])) ?>" title="<?php echo $val['name'] ?>" target="_blank">
                                            <img width="200" height="200" alt="<?php echo $val['name'] ?>" data-src="<?php echo $val['logopic'] ?>" class="lazyimg" src="<?php echo STATIC_URL;?>unitary/images/l.png">
                                        </a>
                                    </div>
                                    <p class="w-goods-title f-txtabb"><a title="<?php echo $val['name'] ?>" href="<?php echo dourl('unitary:detail', array('id'=>$val['id'])) ?>" target="_blank"><?php echo $val['name'] ?></a></p>
                                    <p class="w-goods-price">总需：<?php echo $val['total_num'] ?> 人次</p>
                                    <div class="w-progressBar" title="<?php echo $val['proportion'] ?>%">
                                        <p class="w-progressBar-wrap">
                                            <span class="w-progressBar-bar" style="width:<?php echo $val['proportion'] ?>%;"></span>
                                        </p>
                                        <ul class="w-progressBar-txt f-clear">
                                            <li class="w-progressBar-txt-l"><p><b><?php echo $val['pay_count'] ?></b></p>
                                                <p>已参与人次</p>
                                            </li>
                                            <li class="w-progressBar-txt-r"><p><b><?php echo $val['left_count'] ?></b></p>
                                                <p>剩余人次</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="w-goods-progressHint">
                                        <b class="txt-blue"><?php echo $val['pay_count'] ?></b>人次已参与，赶快去参加吧！剩余<b class="txt-red"><?php echo $val['left_count'] ?></b>人次
                                    </p>
                                    <div class="w-goods-opr js-side-cart" data-id="<?php echo $val['id'] ?>" data-left_count="<?php echo $val['left_count'] ?>">
                                        <a class="w-button w-button-main w-button-l w-goods-buyRemain js-buyAll" href="javascript:void(0)" style="width:70px;">我来包尾</a>
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
</div>
<?php include display('public:footer_unitary'); ?>
</body>
<script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/common.js"></script>
<script type="text/javascript">
$(function(){
    // 调用夺宝与购物
    $(".js-side-cart").setAddCart({
        "redirect": cart_url,
        "addCartUrl": add_cart_url,
    });

    runtime.init($(".jstimer"));
    scrollnav.init($('.m-nav'), $(".m-results-mod-hd"));    // 滚动效果
    $(".lazyimg").lazyLoad();

})

</script>
</html>