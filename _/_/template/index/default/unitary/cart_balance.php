<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="1元夺宝，就是指只需1元就有机会获得一件商品，是基于网易邮箱平台孵化的新项目，好玩有趣，不容错过。">
    <meta name="keywords" content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵">
    <title>确认订单 - 夺宝</title>
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/bef6decb938119df87327e5e548e997f221af746.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/b5c1278e0e0fe59171c31ecba188867811c2934d.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/cart_balance.css">
    <script src="<?php echo STATIC_URL;?>unitary/js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/cart.js"></script>
    <script type="text/javascript">
        var cart_ajax_url = "<?php echo dourl('unitary:cartajax') ?>";
        var cart_ajax_round = "<?php echo dourl('unitary:round_list') ?>";
    </script>
    <style type="text/css">
    .m-duobao-order-list .show-code-box {}
    .show-code-box p { padding: 7px 0; border: 1px solid #ddd; text-align: center; background:#f2f2f2; color: #808080; font-size: 14px; }
    .show-code-box .show-code-img { width: 100%; height: 260px; text-align: center; }
    .show-code-box .show-code-img img { width: 260px; height: 260px; }
    </style>
<body>
<div class="g-header" module="header/Header" id="pro-view-0" module-id="module-1" module-launched="true">
    <div class="m-toolbar" module="toolbar/Toolbar" id="pro-view-4" module-id="module-4" module-launched="true">
        <div class="g-wrap f-clear">
            <div class="m-toolbar-l">
                <?php if(empty($user_session)){?>
                    Hi，欢迎来 <?php echo option('config.site_name');?>&nbsp;<a class="link-login style-red" target="_top" href="<?php echo url('account:login') ?>">请登录</a>&nbsp;&nbsp;
                    <a class="link-regist style-red"  target="_top" href="<?php echo url('account:register') ?>" >免费注册</a>  
                <?php }else{?>  
                    你好，<a class="link-login" href="<?php echo url('account:index') ?>" ><?php echo $user_session['nickname'];?>&nbsp;&nbsp;
                    <a class="link-regist style-red" target="_top" href="<?php echo url('account:logout') ?>">退出</a>                            
                <?php }?>
            </div>
            <ul class="m-toolbar-r">
                <li class="m-toolbar-myBonus"><a href="<?php dourl('index:index') ?>">返回主电商</a><var>|</var></li>
                <li class="m-toolbar-myDuobao">
                    <a class="m-toolbar-myDuobao-btn" href="<?php echo dourl('unitary:account') ?>">
                        我的夺宝 <i class="ico ico-arrow-gray-s ico-arrow-gray-s-down"></i>
                    </a>
                    <ul class="m-toolbar-myDuobao-menu">
                        <li><a href="<?php echo dourl('unitary:account') ?>">夺宝记录</a></li>
                        <li class="m-toolbar-myDuobao-menu-win"><a href="<?php echo dourl('unitary:account', array('type'=>'luck')) ?>">幸运记录</a></li>
                        <!-- <li class="m-toolbar-myDuobao-menu-mall"><a href="/user/mallrecord.do">购买记录</a></li> -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="g-body">
    <div class="m-duobao-order">
        <div class="m-header f-clear">
            <div class="m-header-logo">
                <h1>
                    <a class="m-header-logo-link" href="<?php echo dourl('unitary:index') ?>" title="一元夺宝">一元夺宝</a>
                </h1>
            </div>
            <div class="m-cart-order-steps">
                <div class="w-step-duobao w-step-duobao-2"></div>
            </div>
        </div>
        <div class="m-duobao-order-list">
            <div class="show-code-box">
                <p>请扫码并用账户 【<?php echo $user_session['nickname'];?>】 登录支付 <a target="_blank" href="<?php echo option("config.site_url").'/webapp/snatch/#/shopcar/'.$_GET['store_id']; ?>">测试支付</a></p>
                <div class="show-code-img">
                    <img src='<?php echo option("config.site_url")."/source/qrcode.php?type=unitary_cart&id=".$_GET['store_id'] ?>' />
                </div>
                <div class="f-clear"></div>
            </div>
            <ul class="order-list">
                <li class="order-list-header f-clear">
                    <div class="order-list-items-name items-goods-name">商品名称</div>
                    <div class="order-list-items-name items-goods-period">商品期号</div>
                    <div class="order-list-items-name items-goods-price">价值</div>
                    <div class="order-list-items-name items-goods-buyunit">夺宝价</div>
                    <div class="order-list-items-name items-goods-num">参与人次</div>
                    <div class="order-list-items-name items-goods-regular">&nbsp;</div>
                    <div class="order-list-items-name items-goods-total">小计</div>
                </li>
                <?php foreach ($cart_list as $val) { ?>
                <li class="order-list-items f-clear">
                    <div class="order-list-items-content items-goods-name">
                        <p>
                            <a href="<?php echo dourl('unitary:detail', array('id'=>$val['unitary']['id'])) ?>" target="_blank" title="<?php echo $val['name'] ?>"><?php echo $val['unitary']['name'] ?></a>
                        </p>
                    </div>
                    <div class="order-list-items-content items-goods-period f-items-center"><?php echo $val['unitary']['id'] ?></div>
                    <div class="order-list-items-content items-goods-price f-items-center"><?php echo $val['unitary']['price'] ?>元</div>
                    <div class="order-list-items-content items-goods-buyunit f-items-center"><?php echo $val['unitary']['item_price'] ?>元</div>
                    <div class="order-list-items-content items-goods-num f-items-center"><?php echo $val['count'] ?></div>
                    <div class="order-list-items-content items-goods-regular f-items-center">&nbsp;</div>
                    <div class="order-list-items-content items-goods-total f-items-center">
                        <span><?php echo $val['unitary']['item_price']*$val['count'] ?>元</span>
                    </div>
                </li>
                <?php } ?>
                <li class="order-list-footer f-clear">
                    <a href="<?php echo dourl('unitary:cart') ?>">返回清单修改</a>
                    <span class="order-total txt-gray">商品合计：<strong><?php echo $total_price ?></strong>&nbsp;元</span>
                </li>
            </ul>
            <div class="m-coupon-options f-clear" pro="orderfooter">
                <div class="m-order-footer-msg" id="pro-view-1">
                    <div class="footer-items pay-total">总需支付：<span class="footer-items-money"><strong>¥</strong><strong pro="total"><?php echo $total_price ?></strong></span></div>
                    <div class="m-order-operation f-clear"><button class="w-button w-button-main w-button-xl" type="button"><span>去支付</span></button></div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php include display('public:footer_unitary'); ?>
</div>
</body>
<script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/common.js"></script>
</html>