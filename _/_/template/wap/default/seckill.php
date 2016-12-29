<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
    <title>微店-秒杀活动</title>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/seckill/css/style.css"/>
    <script type="text/javascript" src="<?php echo TPL_URL;?>ucenter/js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
</head>
<style>
    #fancybox-left span {left : auto; left : 20px;}
    #fancybox-right span {left : auto; right : 20px;}

    .layer {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.5);
        z-index: 9;
    }

    .layer_content {
        background: #fff;
        position: fixed;
        width: 15rem;
        left: .5rem;
        top: 50%;
        text-align: center;
        z-index: 10;
        height: 19rem;
        margin-top: -8.5rem;
    }
    .layer_content .layer_title {
        font-size: .55rem;
        color: #fff;
        line-height: .9rem;
        padding: .3rem .5rem;
        background: #45a5cf;
        text-align: left;
        text-indent: 1.2rem;
    }
    .layer_content p {
        font-size: .55rem;
        color: #333333;
        line-height: 1.4rem;
    }
    .layer_content img {
        width: 8rem;
        margin: 1rem 0;
    }
    .layer_content p span {
        font-size: .45rem;
        color: #999;
        line-height: 0.9rem;
    }

    .layer_content button {
        background: #ff9c00;
        width: 5.5rem;
        height: 1.5rem;
        color: #fff;
        line-height: 1.5rem;
        border-radius: 1.5rem;
        margin: .6rem 0;
    }

    .layer_content i {
        background: url(/template/wap/default/ucenter/images/weidian_25.png) no-repeat;
        background-size: 1rem;
        height: 1.2rem;
        width: 1.24rem;
        display: inline-block;
        vertical-align: middle;
        position: absolute;
        right: -.5rem;
        top: -.5rem;
    }
</style>
<body style="background-color:#efefef;">

<!--<div class="banner" style="height:150px;overflow:hidden;width:100%;">
    <img src="<?php /*echo rtrim(option('config.url'), '/').'/upload/images/default_ucenter.jpg';*/?>" width="100%" alt="" />
</div>-->

<?php if ($seckillInfo['is_subscribe'] == 1 && empty($is_subscribe)) {?>
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
<?php
}
?>

<div class="time">
    <h1 class="time_1">您的抢购时间</h1>
    <h1 class="time_2"><?php echo date('Y-m-d',$my_start);?></h1>
    <h1 class="time_3"><?php echo date('H:i:s',$my_start);?></h1>
    <h2 class="time_old">标准时间<br/>
        <span style="text-decoration:line-through"><?php echo date('Y-m-d H:i:s',$seckillInfo['start_time'])?></span></h2>
    <h2>当前排名<br/>第<?php echo !empty($userNum) ? $userNum : '1';?><span style=" color:#288b26;"></span>位</h2>
</div>
<?php if($seckillInfo['start_time'] > time()) {?>
    <a href="./seckill_shop_invite.php?seckill_id=<?php echo $seckillInfo['pigcms_id'];?>&store_id=<?php echo $seckillInfo['store_id'];?>"><div class="btn">我要提前抢</div></a>
<?php } else if ($seckillInfo['start_time'] < time()){?>
    <div class="btn">抢购中点击商品抢购</div>
<?php } else if($seckillInfo['end_time'] < time()) {?>
    <a href="javascript:;"><div class="btn">活动已结束</div></a>
<?php } ?>

<?php if(empty($shareUser)) {?>
    <?php if($seckillInfo['start_time'] > time()) {?>
    <a href="./seckill_shop_invite.php?seckill_id=<?php echo $seckillInfo['pigcms_id']?>&store_id=<?php echo $seckillInfo['store_id'];?>">
        <div class="btn">暂无好友帮忙，快去邀请吧！</div>
    </a>
    <?php } ?>
<?php } else {?>
    <div class="help">
        <h1>帮助过您的好友&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="./seckill_see_invite.php?seckill_id=<?php echo $seckillInfo['pigcms_id']?>">详细列表</a></h1>
        <?php foreach($shareUser as $user) {?>
            <div>
                <img src="<?php echo !empty($user['avatar']) ? $user['avatar'] : option('config.site_url') . '/static/images/default_shop_2.jpg'; ?>" width="100%">
                <?php echo !empty($user['nickname']) ? $user['nickname'] : 'nickname';?>&nbsp;帮您提前秒&nbsp;<?php echo $user['preset_time'];?>
                <h2>
                    <span style=" font-weight:bold;">-<?php echo $user['preset_time'];?></span>秒
                </h2>
            </div>
        <?php }?>
    </div>
<?php }?>

<div class="guize" style="height:auto;padding-bottom:20px;">
    <div>活动规则</div>
    <?php echo $seckillInfo['description'];?>
</div>
<a href="./seckill_orders.php?uid=<?php echo $wap_user['uid']?>"><div class="btn" style="width:26%;margin-left:5%;">我的订单</div></a>
<ul class="product">
    <li class="product-left">
        <a class="product-class" href=''>
        <div style="height:120px;overflow:hidden;"><img src="<?php echo getAttachmentUrl($productInfo['image'],false);?>" width="100%"/></div>
        <h3><?php echo mb_substr($productInfo['name'], 0, 10,'UTF-8');?></h3>
        <h4><span style="font-size:12px; color:#ff0000; margin-right:2.5%;">￥<?php echo !empty($seckillInfo['seckill_price']) ? $seckillInfo['seckill_price'] : $productInfo['price']?></span>
            <span style="font-size:12px;">库存: <?php echo $productInfo['quantity']?></span>
        </h4>
        </a>
    </li>
</ul>

<script type="text/javascript">
    $('.product-left').click(function(){
        var time = <?php echo time();?>; //当前时间
        var href = "./seckill_shop.php?id=<?php echo $productInfo['product_id']?>&seckill_id=<?php echo $seckillInfo['pigcms_id']?>"; //购买地址
        var status = <?php echo $seckillInfo['status'];?>; //是否失效
        var delete_flag = <?php echo $seckillInfo['delete_flag'];?>; //是否删除
        var my_start = <?php echo $my_start;?>; //我的开始秒杀时间
        var my_end = <?php echo $seckillInfo['end_time'];?>; //我的开始秒杀时间

        if(my_start > time){
            alert('活动还未开始');
        }else if (my_start < time && status == 2){
            alert('活动已失效');
        }else if(my_start < time && delete_flag == 1){
            alert('活动已删除');
        }else if (time > my_end){
            alert('活动已结束');
        } else{
            $('.product-class').attr('href',href);
        }
    });


    $(function() {
        $(".close").click(function() {
            $(".layer").fadeToggle("300");
            $(".layer_content").fadeToggle("200");
        });

        $(".product_title i").on("click", function() {
            $(".product_title_table").slideToggle(300);
            $(this).toggleClass('active');
            $(".product_title_table .active").removeClass('active');
        });


        $(".product_title_table li").click(function() {

            var txt = $(this).html();
            var txt_li = $(".product_title_list .active").html();
            $(this).html(txt_li);
            $(".product_title_list .active").html(txt)

        });

    });
</script>
</body>
</html>
