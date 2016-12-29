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
            .dFooter {
                padding: 0 3px;
                text-align: center;
                margin-top: 20px;
                margin-bottom: 2px;
            }
        </style>
    </head>

    <body <?php if($is_mobile){ ?> class="body-fixed-bottom" <?php } ?>>
    <div class="container">
        <div class="header">
            <!-- ▼顶部通栏 -->
            <div class="js-mp-info share-mp-info">
                <a class="page-mp-info" href="<?php echo $now_store['url'];?>">
                    <img class="mp-image" width="24" height="24" src="<?php echo $now_store['logo'];?>" alt="<?php echo $now_store['name'];?>" />
                    <i class="mp-nickname"><?php echo $now_store['name'];?></i>
                </a>
                <div class="links">
                    <a class="mp-homepage" href="<?php echo $now_store['ucenter_url'];?>">会员中心</a>
                </div>
            </div>
            <!-- ▲顶部通栏 -->
        </div>
        <div class="content">
            <div class="content-body">
                    <div class="site_wrap wrap" style="width:100%;">
                        <div class="img_slides_wrap slides_wrap">
                            <img style="width:100%" class='img_slide slide active' src="<?php echo getAttachmentUrl($nowProduct['image'],FALSE);?>"/>
                        </div>
                    </div>
                <hr style="border: 1px;">

                <div class="proInfo">
                    <div class="infoTop">
                        <h2><?php echo $nowProduct['name'] ?></h2>
                        <div class="parice">
						<span>
                            <div class="current-price">
                                <span>￥&nbsp;</span> <i class="js-goods-price price"><?php echo !empty($seckillInfo['seckill_price']) ? $seckillInfo['seckill_price'] : $nowProduct['price'];?></i>
                            </div>
						</span>
                        </div>
                    </div>
                    <div class="infoMore">
                        <ul class="flex-box">
                            <li>运费：￥<?php echo $nowProduct['postage_tpl'] ? $nowProduct['postage_tpl']['min'].'~'.$nowProduct['postage_tpl']['max'] : $nowProduct['postage']?></li>
                            <li>&nbsp;销量：<?php echo $nowProduct['sales'];?></li>
                            <?php if($nowProduct['show_sku']){ ?>
                                <li>&nbsp;剩余：<?php echo $nowProduct['quantity'] > 0 ? $nowProduct['quantity'] : 0;?>件</li>
                            <?php } ?>
                        </ul>
                    </div>
                    <style>
                        .integral{background: #FEF2F2;padding: 15px 0px;font-size: 12px;margin-bottom: 15px}
                        .integral span:first-child{margin-right: 15px}
                        .integral i{display: inline-block;vertical-align: middle;width: 20px;height: 20px;margin-right: 5px}
                    </style>

                    <div class="integral" style='display:<?php echo empty($seckillInfo['description']) ? 'none' : 'display';?>'>
                        <span> <?php echo $seckillInfo['description']; ?></span>
                    </div>
            </div>
            <?php if(!empty($storeNav)){ echo $storeNav;}?>
        </div>
            <div class="js-footer" style="min-height: 1px;">
                <div class="footer">
                    <div class="copyright">
                        <div class="ft-links" style="margin-bottom: 5px;">
                            <a href="./seckill.php?seckill_id=<?php echo $seckill_id;?>">秒杀主页</a>
                            <a href="./seckill_orders.php?uid=<?php echo $wap_user['uid']?>">我的信息</a>
                        </div>
                        <span style="font-size:10px;">©2012-2016 pigcms 版权所有</span>
                    </div>
                </div>
            </div>

        <div class="dFooter">
            <ul class="js-bottom-opts">
                <?php if($nowProduct['quantity'] > 0) {?>
                <li class="ziji"><a style="font-size: 16px;color: #fff;background-color: #06bf04;" href="javascript:" class="js-buy-it"><i></i>立即购买</a></li>
                <?php } else {?>
                    <li class="ziji"><a style="font-size: 16px;color: #463131;background-color: #e3e3e3;" href="javascript:"><i></i>商品已售罄</a></li>
                <?php }?>
            </ul>
        </div>
    </div>
        <script>
            $('.js-buy-it').click(function(){
                var product_id = <?php echo $nowProduct['product_id']?>;
                var seckill_id = <?php echo $seckill_id;?>;
                var sku_id = <?php echo !empty($seckillInfo['sku_id']) ? $seckillInfo['sku_id'] : 0;?>;


                var check_url = "./seckill_shop.php?action=check";
                var post_url = "./saveorder_by_seckill.php";

                $.post(check_url,{'seckill_id':seckill_id},function(result){

                    if(result.err_code == 0 && result.err_msg > 0){
                        alert('您已秒杀过此商品');
                    }else {
                        $.post(post_url,{'product_id':product_id, 'sku_id':sku_id, 'seckill_id':seckill_id},function(data){
                            if(data.err_code == 0){
                                window.location.href = './pay.php?id='+data.err_msg+'&showwxpaytitle=1';
                            }else{
                                alert(data.err_msg);
                            }
                        });
                    }
                });
            });
        </script>
    </body>
    </html>