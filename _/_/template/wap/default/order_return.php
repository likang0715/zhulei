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
    <title>分销商品 - <?php echo $store['name']; ?></title>
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/style.css" rel="stylesheet">
</head>

<style>
    .header{
        width:108%;
    }
</style>
<body>
<header class="header_title">
    <a href="#" onclick="javascript:history.go(-1);"><i></i></a>
    <p>售后服务</p>
</header>
<nav class="title_table activity_title service_title">
    <ul class="clearfix">
        <li class=" active"><a href="">退款订单</a></li>
        <li><a href="">维权订单</a></li>
    </ul>
</nav>
<article>
    <ul class="acticity_list">
        <li>
            <section>
                <table class="service_table">
                    <thead>
                    <tr>
                        <th>商品</th>
                        <th>退货状态</th>
                        <th>查看</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <?php foreach ($orderList as $k => $order) {?>
                        <td class="clearfix">
                        <div class="header">订单号:<?php echo $order['order_no']?></div>
                            <?php foreach($order['order_product_list'] as $product){?>
                            <div class="server_img"><img src="images/weidian_28.png"></div>
                            <div class="server_text">
                                <p><?php echo $product['name']?></p>
                                <p><span>￥15.90</span></p>
                            </div>
                            <?php }?>
                        </td>
                        <td>
                            <p class="state">申请中</p>
                        </td>
                        <td>
                            <button>立即查看</button>
                        </td>
                    </tr>
                    <?php }?>
                    </tbody>
                </table>
            </section>
        </li>
        <li>
            <section>
                <table class="service_table">
                    <thead>
                    <tr>
                        <th>商品</th>
                        <th>售后状态</th>
                        <th>查看</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="clearfix">
                            <div class="server_img"><img src="images/weidian_28.png"></div>
                            <div class="server_text">
                                <p>黄焖鸡米饭黄焖鸡米饭黄焖鸡米饭黄焖鸡米饭</p>
                                <p><span>￥15.90</span></p>
                            </div>
                        </td>
                        <td>
                            <p class="state">申请中</p>
                        </td>
                        <td>
                            <button>立即查看</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="clearfix">
                            <div class="server_img"><img src="images/weidian_28.png"></div>
                            <div class="server_text">
                                <p>黄焖鸡米饭黄焖鸡米饭黄焖鸡米饭黄焖鸡米饭</p>
                                <p><span>￥15.90</span></p>
                            </div>
                        </td>
                        <td>
                            <p class="state">申请中</p>
                        </td>
                        <td>
                            <button>立即查看</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="clearfix">
                            <div class="server_img"><img src="images/weidian_28.png"></div>
                            <div class="server_text">
                                <p>黄焖鸡米饭黄焖鸡米饭黄焖鸡米饭黄焖鸡米饭</p>
                                <p><span>￥15.90</span></p>
                            </div>
                        </td>
                        <td>
                            <p class="state">申请中</p>
                        </td>
                        <td>
                            <button>立即查看</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </section>
        </li>
    </ul>
</article>
</body>
<script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
</html>
