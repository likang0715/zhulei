<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){echo ' responsive-320';}elseif($_GET['ps']>=540){echo ' responsive-540';} if($_GET['ps']>540){echo ' responsive-800';} ?>" lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
    <meta name="description" 	content="<?php echo $config['seo_description'];?>" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="cleartype" content="on" />
    <link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
    <title><?php echo $nowProduct['name'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css?time=<?php echo time()?>" />
    <?php if($is_mobile){ ?>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase.css" />
        <script>var is_mobile = true;</script>
    <?php }else{ ?>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/showcase_admin.css" />
        <script>var is_mobile = false;</script>
    <?php } ?>

    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/goods.css" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/css/drp_notice.css" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/coupon.css" />
    <link rel="stylesheet" href="<?php echo TPL_URL?>css/comment.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/font/icon.css" />
    <link rel="stylesheet" href="<?php echo STATIC_URL;?>css/fancybox.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/style.css">
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script src="<?php echo STATIC_URL;?>js/jquery.waterfall.js"></script>
    <script src="<?php echo STATIC_URL;?>js/idangerous.swiper.min.js"></script>
    <script src="<?php echo STATIC_URL;?>js/jquery.fancybox-1.3.1.pack.js"></script>
    <script src="<?php echo TPL_URL;?>js/base.js"></script>

    <style>
        body,.container{background: #eaeaea;}
    </style>

    <style type="text/css">

        ._fly{
            height: 200px !important ;
            left: 0 !important;
        }
        .wxname {
            position: absolute;
            width: 37px !important;
            height: 38px !important;
            margin: 0 auto !important;
            left: 50% ;
            margin-left: -20px !important;
            z-index: 999
        }
        .footer {
            width: 100% !important ;
            height: 75px !important ;
            display: block !important ;
            text-align: center ;
        }

        .copyright .ft-links  a {
            font-size: 12px ;
            margin: 0px 6px;
            color: #333;
        }

        .copyright .ft-links  a:hover{
            text-decoration: none ;
        }

        .copyright .ft-copyright {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
        }
        .copyright .ft-copyright .company {
            color: #F39F6C;
        }

        .content , .container{
            background: #EEEEEE ;
        }

        .b-list{
            margin-top: 10px;
        }

        .thumb img{
            width: 58px ;
            max-height: 58px;
            height: auto;
        }

        .opt-btn{
            height: 32px ;
        }

        .opt-btn span{
            height: 32px;
            line-height: 32px ;
        }
        .pull-right {
            float: right;
            margin-right: 12px;
        }
        .font-size-12 {
            font-size: 13px !important;
            line-height: 40px;
        }
        .block .bottom {
            padding: 10px;
            height: 28px;
            line-height: 18px;
        }
        .btn {
            display: inline-block;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 3px;
            padding: 6px;
            text-align: center;
            margin: 0;
            color: #999;
            font-size: 12px;
            cursor: pointer;
            line-height: 18px;
        }
    </style>
</head>

<body style="background: #EEEEEE ; position: relative">
    <div class="container ">
        <div class="content">
            <div id="order-list-container">
            <?php if(!empty($orderList)) {?>
                <?php foreach($orderList as $orders) {?>
                    <div class="b-list">
                        <li class="block block-order animated">
                            <div class="header">
                                <span class="font-size-12">订单号：<?php echo $orders['order_no'];?></span>

                                <?php if($orders['status'] == 0) {?>
                                    <a class="js-cancel-order pull-right font-size-12 c-blue cancle-book" data-id="<?php echo $orders['order_id']?>" href="javascript:;">取消</a>
                                <?php } ?>
                            </div>

                            <hr class="margin-0 left-10">

                            <div class="block block-list block-border-top-none block-border-bottom-none">
                                <div class="block-item name-card name-card-3col clearfix">
                                    <a href="" class="thumb">
                                        <img src="<?php echo getAttachmentUrl($orders['product_image'],FALSE);?>">
                                    </a>
                                    <div class="detail">
                                        <a href="">
                                            <h3><?php echo mb_substr($orders['product_name'], 0, 12, 'utf-8');?></h3>
                                        </a>
                                    </div>
                                    <div class="right-col">
                                        <div class="price">¥&nbsp;<span><?php echo $orders['sub_total']?></span></div>
                                        <div class="num">
                                            ×<span class="num-txt">1</span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="margin-0 left-10">
                            </div>

                            <hr class="margin-0 left-10">

                            <div class="bottom">
                                商品总价：<span class="c-orange">￥<?php echo $orders['sub_total']?></span>
                                <div style="float:right;">
                                    <?php if($orders['status'] == 0) {?>
                                        <a href="./pay.php?id=PIG<?php echo $orders['order_no']?>&showwxpaytitle=1" class="btn btn-orange btn-in-order-list" style="/*margin-left: 150px;*/">付款</a>
                                    <?php }?>
                                </div>
                            </div>
                        </li>

                    </div>
               <?php }?>
            <?php }?>
                <div class="list-finished">
                    <?php if($ordersCount > 0) {?>共
                        <b style="color:red"><?php echo $ordersCount;?></b>个订单
                        <?php } else { ?>居然还没有订单<br/><br/>
                        <a href="">去逛逛
                        </a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="copyright">
            <div class="ft-links">
                <a href="./seckill.php?seckill_id=<?php echo $seckill_id;?>" >秒杀主页</a>
                <a href="">我的信息</a>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(".buy").click(function() {
        var shop_num = $(this).attr("data-nums");
        var orderid = $(this).attr("data-id") ;
        var price = $(this).attr("data-prices") ;
        var orderName = $(this).attr("data-names") ;
        if(shop_num <= 0){
            alert('未及时付款，货品已被抢光');
            return false;
        }
        var url = '' ;
        url += "{pigcms::U('pay')}" ;
        url += "&orderid="+orderid ;
        url += "&token={pigcms:$_GET['token']}" ;
        url += "&price="+price ;
        url += "&orderName="+orderName ;

        window.location.href = url ;
    }) ;

    //取消订单
    $('.js-cancel-order').live("click", function(){
        var nowDom = $(this);
        $.post('./order.php?del_id='+$(this).data('id'),function(result){
            motify.log(result.err_msg);
            if(result.err_code == 0){
                nowDom.closest('li').remove();
                if($('li.block-order').size() == 0){
                    $('.empty-list').show();
                }
            }
        });
    });
</script>
</body>
</html>