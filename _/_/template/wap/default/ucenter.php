<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/base.css"/>
    <link href="<?php echo TPL_URL;?>ucenter/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/swiper.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/usercenter.css" type="text/css">
    <?php if($is_mobile){ ?>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css?time='<?php echo time();?>'"/>
    <?php }else{ ?>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css?time='<?php echo time();?>'"/>
    <?php } ?>
    <title>个人中心</title>
    <script src="<?php echo TPL_URL;?>ucenter/js/swiper.min.js"></script>
    <script src="<?php echo TPL_URL;?>ucenter/js/rem.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>ucenter/js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/base.js"></script>
    <!--活动模块-->
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/weidian_files/style.css">
    <script src="<?php echo TPL_URL;?>/weidian_files/iscroll.js"></script>
    <script type="text/javascript">
    var drp_center_show = parseInt("<?php echo $drp_center_show; ?>");
    $(function () {
       $(".scroller").each(function (i) {
        $(this).find("a").css("height", "auto");
        var li = $(this).find("li");
        var liW = li.width() + 18;
        var liLen = li.length;
        $(this).width(liW * liLen);

        var class_name = $(this).parent().attr("class");
        new IScroll("." + class_name, { scrollX: true, scrollY: false, mouseWheel: false, click: true });
    });
   });
    </script>
    <!--		活动模块-->
</head>
<style type="text/css">
.motify {
    text-align: center;
    position: fixed;
    top: 35%;
    left: 50%;
    width: 220px;
    padding: 5px;
    margin: 0 0 0 -110px;
    z-index: 9999;
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
    font-size: 14px;
    line-height: 1.5em;
    border-radius: 6px;
    -webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.2);
}
.userTab > .bd .consumption-group .cell:nth-child(4n) {
    margin-bottom: .5rem;
}
.ucenter-tab {
    float: right;
    background-size: cover;
    margin-top: 0.1rem;
    margin-right: 19px;
    color:#f60;
}
.motify-inner {
    font-size: 12px;
}
</style>

<script type="text/javascript">
$(function(){
	if(location.hash == '#promotion') {
		$(".dTab .hd ul li").removeClass('on');
		$(".dTab .hd ul li").eq(1).addClass('on');
		$('.likesomes,.consumption,.orderNav,.consumption-group,.customer,.user-image').css('display','none');
		$('.promotion,.promotion-group,.store-image,.index_footer').css('display','block');
	}
});
</script>
<body class="body-gray">
    <section class="userTop clearfix dTab" style="background-image:url('<?php echo  getAttachmentUrl($now_ucenter['bg_pic']);?>');background-size:cover">
        <!-- 样式结构修改 start -->
        <div class="userTopInfo">
            <div class="fl userAvatar">
                <a href="##" style="display:block;" class="user-image">
                    <img class="mp-image " width="24" height="24" src="<?php echo !empty($avatar) ? $avatar : option('config.site_url') . '/static/images/default_shop_2.jpg'; ?>" alt="<?php echo $_SESSION['wap_user']['nickname'];?>"/>
                </a>
                <a href="##" style="display:none;" class="store-image">
                    <img class="mp-image" width="24" height="24" src="<?php echo !empty($visitor['data']['logo']) ? $visitor['data']['logo'] : option('config.site_url') . '/static/images/default_shop_2.jpg'; ?>" alt="<?php echo $visitor['data']['name'];?>"/>
                </a>
            </div>
            <div class="userInfo consumption">
                <div class="name">
                    <span style="display:<?php echo in_array('1',$now_ucenter['consumption_field']) ? '' : 'none';?>"><?php echo !empty($_SESSION['wap_user']['nickname']) ? $_SESSION['wap_user']['nickname'] : ''; ?></span>
                    <span style="display:<?php echo in_array('3',$now_ucenter['consumption_field']) ? '' : 'none';?>">【<?php echo $storeUserData['degree_name'] ?>】</span>
                </div>
                <div class="price">
                    <span style="display:<?php echo in_array('2',$now_ucenter['consumption_field']) ? '' : 'none';?>">
                        会员积分：<?php echo $storeUserData['point'] ? $storeUserData['point'] : '0' ;?>
                    </span>
                </div>
            </div>
        </div>
        <!-- 样式结构修改 end -->
    </section>
    <section class="userTab dTab">
        <div class="bd">
            <div class="row">
                <div class="orderNav">
                    <ul class="box">
                        <li class="b-flex">
                            <a href="./order.php?id=<?php echo $now_store['store_id'];?>&action=unpay">
                                <i><?php echo intval($storeUserData['order_unpay']);?></i>
                                待付款
                            </a>
                        </li>
                        <li class="b-flex">
                            <a href="./order.php?id=<?php echo $now_store['store_id'];?>&action=unsend">
                                <i><?php echo intval($storeUserData['order_unsend']);?></i>
                                待发货
                            </a>
                        </li>
                        <li class="b-flex">
                            <a href="./order.php?id=<?php echo $now_store['store_id'];?>&action=send">
                                <i><?php echo intval($storeUserData['order_send']);?></i>
                                已发货
                            </a>
                        </li>
                        <li class="b-flex">
                            <a href="./order.php?id=<?php echo $now_store['store_id'];?>&action=complete">
                                <i><?php echo intval($storeUserData['order_complete']);?></i>
                                已完成
                            </a>
                        </li>
                        <li class="b-flex">
                            <a href="./return.php?id=<?php echo $now_store['store_id'];?>">
                                <i><?php echo $returnProduct > 0 ? $returnProduct : '0';?></i>
                                退换货
                            </a>
                        </li>
                    </ul>
                </div>
                <!--订单信息 start-->
                <div class="group consumption-group">
                    <div class="cell">
                        <a href="./order.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span class="cell_name"><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/order.png"/></i>茶品订单</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./dcorder.php?id=<?php echo $now_store['store_id'];?>&action=all">
                            <i class="arrow"></i>
                            <span class="cell_name"><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/tea.png"/></i>预约订单</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./chorder.php?id=<?php echo $now_store['store_id'];?>&action=all">
                            <i class="arrow"></i>
                            <span class="cell_name"><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/events.png"/></i>茶会报名</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./cart.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span class="cell_name"><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/cart.png"/></i>我的购物车</span>
                        </a>
                    </div>
                    <div class="group">
                        <div class="cell">
                            <a href="./drp_ucenter.php?a=profile">
                                <i class="arrow"></i>
                                <span><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/my.png"/></i>个人资料</span>
                            </a>
                        </div>
                        <div class="cell">
                            <a href="./degree.php?id=<?php echo $now_store['store_id'];?>">
                                <i class="arrow"></i>
                                <span class="cell_name"><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/vip.png"/></i>会员等级</span>
                            </a>
                        </div>
                        <div class="cell">
                            <a href="./user_address.php">
                                <i class="arrow"></i>
                                <span class="cell_name"><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/address.png"/></i>收货地址</span>
                            </a>
                        </div>
                    </div>
                    <div class="group">
                        <div class="cell">
                         <a href="./points_detailed.php?store_id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span class="cell_name"><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/jifen.png"/></i>积分明细</span>
                        </a>
                    </div>
                    <div class="cell">
                        <a href="./my_coupon.php?id=<?php echo $now_store['store_id'];?>">
                            <i class="arrow"></i>
                            <span class="cell_name"><i class="icon"><img src="<?php echo TPL_URL;?>ucenter/images/icon/vouchers.png"/></i>我的礼券</span>
                        </a>
                    </div>
                </div>
            </div>
            <!--会员消息end-->
            <div class="cell dTab likesomes" style="display:block;margin-bottom: 46px;">
                <div class="hd">
                    <ul class="box">
                        <li class="b-flex">
                            <a style="color:#F15A0C;" data-flex="product" href="javascript:;">喜欢的商品</a>
                        </li>
                        <li class="b-flex">
                            <a data-flex="article" href="javascript:;">喜欢的包厢</a>
                        </li>
                    </ul>
                </div>
                <div class="bd product">
                    <div class="row">
                        <?php if(!empty($collects)){?>
                        <?php foreach($collects as $collect) {?>
                        <div class="cell">
                            <a href="./good.php?id=<?php echo $collect['product_id']?>&store_id=<?php echo $collect['store_id']?>">
                                <i class="arrow"></i>
                                <div class="proImg fl">
                                    <img style="width:60px;height;60px;" src="<?php echo getAttachmentUrl($collect['image']); ?>"/>
                                </div>
                                <div class="detailInfo">
                                    <h3><?php echo mb_substr($collect['name'],'0','12','utf-8');?></h3>
                                    <p><?php echo date('Y-m-d', $collect['add_time'])?></p>
                                </div>
                            </a>
                        </div>
                        <?php }?>
                        <?php }?>
                    </div>
                </div>

                <div class="bd article" style="display:none;">
                    <div class="row">
                        <?php if(!empty($subjects)){?>
                        <?php foreach($subjects as $subject) {?>
                        <div class="cell">
                            <a href="./baoxiang.php?id=<?php echo $subject['dataid'] ?>">
                                <i class="arrow"></i>
                                <div class="proImg fl">
                                    <img src="<?php echo getAttachmentUrl($subject['image']); ?>"/>
                                </div>
                                <div class="detailInfo">
                                    <h3><?php echo $subject['name'] ?></h3>
                                    <p><?php echo date('Y-m-d', $subject['add_time'])?></p>
                                </div>
                            </a>
                        </div>
                        <?php }?>
                        <?php }?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <style>
    .custom-nav a {height: auto;}
    </style>
    <div class="customer" >

        <?php
        if($homeCustomField){
            foreach($homeCustomField as $value){
                echo $value['html'];
            }}?>
        </div>
    </section>
    <?php if(!empty($storeNav)){ echo $storeNav;}?>

</body>
<?php echo $shareData;?>
</html>
<script>
$(function(){
    $('.tab-name').click(function(){
        var data = $(this).data('tab');

        if(data == 'consumption'){
            $(this).parent('li').addClass('on').siblings().removeClass('on');
            $('.promotion').css('display','none');
            $('.orderNav').css('display','block');
            $('.consumption').css('display','block');
            $('.promotion-group').css('display','none');
            $('.consumption-group').css('display','block');
            $('.store-image').css('display','none');
            $('.user-image').css('display','block');

            $('.index_footer').css('display','none');
            $('.customer').css('display','block');
            $('.likesomes').css('display','block');

        }else if(data == 'promotion'){
            $(this).parent('li').addClass('on').siblings().removeClass('on');
            $('.likesomes').css('display','none');
            $('.consumption').css('display','none');
            $('.orderNav').css('display','none');
            $('.promotion').css('display','block');
            $('.promotion-group').css('display','block');
            $('.consumption-group').css('display','none');
            $('.user-image').css('display','none');
            $('.store-image').css('display','block');

            $('.index_footer').css('display','block');
            $('.customer').css('display','none');
        }
    });

$('.box li a').click(function(){
    var flex = $(this).data('flex');
    if(flex == 'product'){
        $('.product').css('display','block');
        $(this).css('color','#F15A0C');
        $(this).parent().siblings('li').children('a').removeAttr('style');
        $('.article').css('display','none');
    }else if(flex == 'article'){
        $('.article').css('display','block');
        $(this).css('color','#F15A0C');
        $(this).parent().siblings('li').children('a').removeAttr('style');
        $('.product').css('display','none');
    }
});

$('.no-status').click(function(){
    if (drp_center_show > 1) {
        warning();
    }
});
});

function warning() {
    $('.motify').remove();
    $('body').append('<div class="motify"><div class="motify-inner"><?php echo $warning_msg; ?></div></div>');
    setTimeout(function () {
        $('.motify').remove();
    }, 3000);
}
</script>