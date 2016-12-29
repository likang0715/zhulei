<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <title>订单详细</title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/person.css">


    <script src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <style type="text/css">
        object,embed{
            -webkit-animation-duration:.001s;
            -webkit-animation-name:playerInserted;
            -ms-animation-duration:.001s;
            -ms-animation-name:playerInserted;
            -o-animation-duration:.001s;
            -o-animation-name:playerInserted;
            animation-duration:.001s;
            animation-name:playerInserted;
        }
        @-webkit-keyframes playerInserted{
            from{opacity:0.99;}
            to{opacity:1;}
        }
        @-ms-keyframes playerInserted{
            from{opacity:0.99;}
            to{opacity:1;}
        }
        @-o-keyframes playerInserted{
            from{opacity:0.99;}
            to{opacity:1;}
        }
        @keyframes playerInserted{
            from{opacity:0.99;}
            to{opacity:1;}
        }
        .profit-money-row {
            font-weight: bold;
        }
        .profit {
            text-align: right;
            color:green;
            float: right;
            font-weight: bold;
        }
        .totle-money-row {
            clear: both;
            font-size: 14px!important;
        }
        .cost-price {
            color: red;
        }
        .profit-price {
            color: green;
        }
        .sales {
            color: orangered!important;
        }
        .alert-no {
            color: #999;
        }
        .button {
            line-height: 40px;
            height: 40px;
            font-size: 18px;
        }
        .order-detail .list-myorder {
            margin-bottom: 5px;
        }
        .button-list {
            margin: 0 15px;
        }
    </style>
</head>

<body class="body-gray">
<!--topbar begin-->

<div class="fixed tab-bar">
    <section class="left-small">
        <a class="menu-icon" onclick="window.history.go(-1)"><span></span></a>
    </section>
    <section class="middle tab-bar-section">
        <h1 class="title">订单详细</h1>
    </section>
</div>
<!--topbar end-->
<!--content begin-->
<div class="order-detail mt-45">
    <!--summary begin-->
    <section class="order-detail-infor">
        <div class="order-detail-sum clear">
            <div class="sum-l order-detail-l">
                <i class="icon-orders-small"></i>
            </div>
            <div class="sum-r order-detail-r">
                <ul class="sum-r-ul">
                    <li><span class="status"><?php echo $order_status[$order_detail['status']]; ?></span></li>
                    <li><span class="label">订单号：</span><span class="value"><?php echo $order_detail['order_no']; ?></span></li>
                    <li><span class="label">下单时间：</span><span class="value"><?php echo $order_detail['add_time']; ?></span></li>
                    <?php if (!in_array($order_detail['status'], array(0,1,5))) { ?>
                    <li><span class="label">供货商：</span><span class="value"><?php echo $order_detail['supplier']; ?></span></li>
                    <?php } ?>
                    <li><span class="label">订单来源：</span><span class="value"><?php echo $order_detail['from']; ?></span></li>
                </ul>
            </div>
        </div>
    </section>
    <!--summary end-->
    <!--address begin-->
    <section class="order-detail-address">
        <div class="address-out clear">
            <div class="address-l order-detail-l">
                <i class="icon-address-small"></i>
            </div>
            <div class="address-r order-detail-r">
                <ul class="address-r-ul">
                    <li class="name"><span class="label">收货人：</span><span class="value"><?php echo $order_detail['address_user']; ?></span> <span class="value"><?php echo $order_detail['address_tel']; ?></span></li>
                    <li><span class="label">收货地址：</span><span class="value"><?php echo $order_detail['address']; ?></span></li>
                </ul>
            </div>
        </div>
    </section>
    <!--address end-->
    <!--logistics begin-->
    <?php if (!empty($packages)) { ?>
    <?php foreach ($packages as $key => $package) { ?>
    <section id="Logistics" class="order-detail-logistics">
        <a href="#" class="logistics-out">
            <span class="leftpoint">&nbsp;</span>
            <span class="leftline"></span>
            <div class="log-r order-detail-r">
                <ul class="log-r-ul">
                    <li><span class="label log-title">包裹(<?php echo $package['express_no']; ?>)</span></li>
                    <li><span class="log-msg" id="LogisticsMsg"><?php echo $package['express_company']; ?></span></li>
                    <li><span class="log-time" id="LogisticsTime"><?php echo date('Y-m-d H:i:s', $package['add_time']); ?></span></li>
                </ul>
            </div>
        </a>
        <!--<i class="arrow"></i>-->
    </section>
    <?php } ?>
    <?php } else { ?>
    <section id="NoLogistics" class="order-detail-noLogistics" style="display: block;">
        <div class="noLogistics-out clear">
            <div class="noLogistics-l order-detail-l">
                <i class="icon-double-round"></i>
            </div>
            <div class="noLogistics-r order-detail-r">
                <ul class="noLogistics-r-ul">
                    <li><span class="label log-title">物流信息</span></li>
                    <li><span class="alert-no">抱歉，该订单暂无物流信息！</span></li>
                </ul>
            </div>
        </div>
    </section>
    <?php } ?>
    <!--logistics end-->
    <!--remark end-->
    <section class="order-detail-remark">
        <div class="remark-out clear">
            <div class="remark-l order-detail-l">
                <i class="icon-talks-small"></i>
            </div>
            <div class="remark-r order-detail-r">
                <ul class="remark-r-ul">
                    <li class="name"><span class="label">买家留言</span></li>
                    <li><span class="alert-no"><?php echo !empty($order_detail['comment']) ? $order_detail['comment'] : '......'; ?></span></li>
                </ul>
            </div>
        </div>
    </section>
    <!--remark end-->
    <!--product begin-->
    <div class="list-myorder">
        <ul class="ul-product">
            <?php foreach ($products as $product) { ?>
            <li>
                <span class="pic"><img src="<?php echo $product['image']; ?>"></span>
                <div class="text">
                    <span class="pro-name"><?php echo $product['name']; ?></span>
                    <div class="pro-pric"><span>价格:</span>￥<?php echo $product['pro_price']; ?>&nbsp;&nbsp;<span>数量:<span class="sales"><?php echo $product['pro_num']; ?></span></span></div>
                    <?php if (!in_array($order_detail['status'], array(0,1,5))) { ?>
                    <div class="pro-profit">
                        <span class="cost-price">成本:￥<?php echo $product['cost_price']; ?></span> / <span class="profit-price">佣金:￥<?php echo $product['profit']; ?></span>
                    </div>
                    <?php } ?>
                    <?php if (!empty($product['skus'])) { ?>
                    <div class="pro-pec">
                        <?php foreach ($product['skus'] as $sku) { ?>
                        <span class="color"><?php echo $sku['name']; ?>:<?php echo $sku['value']; ?></span>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <div class="pro-return">

                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
        <div class="money-content">
            <div class="money-row">
                <span class="name">运费：</span>
                <span class="price"><?php echo $order_detail['postage']; ?></span>
            </div>
            <?php if (!in_array($order_detail['status'], array(0,1,5))) { ?>
            <div class="profit-money-row">
                <span class="name">佣金：</span>
                <span class="profit">+<?php echo $order_detail['profit']; ?></span>
            </div>
            <?php } ?>
            <div class="totle-money-row">
                <span class="name">总额（含运费）：</span>
                <span class="price"><?php echo $order_detail['total']; ?></span>
            </div>
        </div>
        <div class="button-list">
            <?php if (in_array($order_detail['status'], array(0,1))) { ?>
                <a href="#" class="button [radius blue round]" style="padding: 0;margin-top:5px;margin-bottom: 5px;">催付款</a>
                <a href="#" class="button [radius red round]" style="padding: 0;margin-top:5px;margin-bottom: 5px;">取消订单</a>
            <?php } ?>
            <a href="javascript:window.history.go(-1);" class="button [radius green round]" style="padding: 0;margin-top:5px;margin-bottom: 5px;">返回</a>
        </div>
    </div>
    <!--product end-->

</div>





</body></html>