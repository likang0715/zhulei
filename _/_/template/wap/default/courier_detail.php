<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
    <head>
        <meta charset="utf-8"/>
        <meta name="HandheldFriendly" content="true"/>
        <meta name="MobileOptimized" content="320"/>
        <meta name="format-detection" content="telephone=no"/>
        <meta http-equiv="cleartype" content="on"/>
        <link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
        <title>包裹</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
        <link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
        <script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    </head>
    <body>
        <div class="container js-page-content wap-page-order">
            <div class="content confirm-container">
                <div class="app app-order">
                    <div class="app-inner inner-order" id="js-page-content">
                        <!-- 订单状态 -->
                        <div class="important-message">
                            <p class="c-orange">
                                开始配送、送达时请及时修改包裹状态 
                                <?php if ($package_info['status'] == 1) { ?>
                                    <span class="pull-right">未开始</span>
                                <?php } else if ($package_info['status'] == 2) { ?>
                                    <span class="pull-right">配送中</span>
                                <?php } else if ($package_info['status'] == 3) {  ?>
                                    <span class="pull-right">已送达</span>
                                <?php } ?>
                            </p>
                        </div>
                        <style type="text/css">
                        .block.block-form .block-item a.map_btn { border:1px solid #f60; padding:0px 2px; border-radius:3px; color:#fff; background:#f60; }
                        .btn.btn-green { background-color: #0daf7c; border-color: #0daf7c; }
                        .block.block-form .block-item a.tel_txt { color: #0daf7c; display: inline; }
                        </style>

                        <div class="block block-form">
                            <!-- 快递 -->
                            <div class="block-item" style="padding:5px 0;">
                                <ul>
                                    <li>收件人: <?php echo $order_info['address_user'].'，<a href="tel:'.$order_info['address_tel'].'" class="tel_txt">'.$order_info['address_tel'] ?></a></li>
                                    <li>区域: <?php echo $order_info['address']['province'].' '.$order_info['address']['city'].' '.$order_info['address']['area'] ?></li>
                                    <li>街道地址: <?php echo $order_info['address']['address'] ?></li>
                                    <li><a href="/wap/courier_map.php?pigcms_id=<?php echo $package_info['package_id'] ?>" class="map_btn pull-right">地图</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- 商品列表 -->
                        <div class="block block-order block-border-top-none">
                            <hr class="margin-0 left-10"/>

                            <div class="block-item ">
                            <?php if ($package_info['status'] == 1) { ?>
                                <a class="btn btn-block btn-green js-send" data-id="<?php echo $package_info['package_id'] ?>" href="javascript:void(0)">开始配送</a>
                            <?php } else if ($package_info['status'] == 2) { ?>
                                <a class="btn btn-block btn-orange js-arrive" data-id="<?php echo $package_info['package_id'] ?>" href="javascript:void(0)">确认送达</a>
                            <?php } else if ($package_info['status'] == 3) {  ?>
                                <a class="btn btn-block btn-grayeee" href="javascript:void(0)">已经送达</a>
                            <?php } ?>
                            </div>

                            <div class="block block-top-0 block-border-top-none center">
                            <?php if ($total_count == 1) { ?>
                                <div class="center action-tip js-pay-tip">该订单为单包裹</div>
                            <?php } else { ?>
                                <div class="center action-tip js-pay-tip">本包裹为订单包裹的1/<?php echo $total_count ?></div>
                            <?php } ?>
                            </div>
                            <hr class="margin-0 left-10"/>
                            <div class="block block-list block-border-top-none block-border-bottom-none">
                                <?php foreach ($order_product as $op) { ?>
                                <div class="block-item name-card name-card-3col clearfix js-product-detail">
                                        <a href="./good.php?id=<?php echo $op['product_id'] ?>&store_id=<?php echo $op['store_id'] ?>" class="thumb">
                                            <img class="js-view-image" src="<?php echo $op['image'] ?>" alt="<?php echo $op['name'] ?>">
                                        </a>
                                    <div class="detail">
                                        <a href="./good.php?id=<?php echo $op['product_id'] ?>&store_id=<?php echo $op['store_id'] ?>"><h3><?php echo $op['name'] ?></h3></a>
                                        <?php if (!empty($op['sku_data'])) { ?>
                                            <?php foreach ($op['sku_data'] as $sku) { ?>
                                            <p class="c-gray ellipsis"><?php echo $sku['name'].':'.$sku['value'] ?></p>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="right-col">
                                        <div class="price">¥&nbsp;<span><?php echo $op['pro_price'] ?></span></div>
                                        <div class="num">
                                            X<span class="num-txt"><?php echo $op['pro_num'] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <hr class="margin-0 left-10"/>
                            <div class="order-message">
                                <span class="font-size-12">买家留言：</span><p class="message-content font-size-12"><?php echo $order_info['comment'] ? $order_info['comment'] : '无'?></p>
                            </div>
                        </div>

                        <!-- 支付 -->
                        <div class="block block-bottom-0">
                            <div class="block-item paid-time">
                                <div class="paid-time-inner">
                                    <p>订单号：<?php echo option('config.orderid_prefix') . $order_info['order_no'] ?></p>
                                    <p class="c-gray"><?php echo date('Y-m-d H:i:s', $package_info['add_time']) ?><br> 分派包裹</p>
                                    <?php if ($package_info['send_time']) { ?>
                                        <p class="c-gray"><?php echo date('Y-m-d H:i:s', $package_info['send_time']) ?><br> 开始配送</p>
                                    <?php } ?>
                                    <?php if ($package_info['arrive_time']) { ?>
                                        <p class="c-gray"><?php echo date('Y-m-d H:i:s', $package_info['arrive_time']) ?><br> 已经送达</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
<script type="text/javascript">
$(function(){
    $(".js-send").off("click").on("click", function(){
        if (!confirm("开始配送包裹？")) {
            return false;
        }
        var self = $(this);
        var package_id = self.attr("data-id");
        self.unbind("click");
        $.post('./courier_status.php',{package_id:package_id, action:'send'}, function(result){
            if (result.status) {
                window.location.reload();
            } else {
                alert(result.msg);
            }
        },'json');

    });

    $(".js-arrive").off("click").on("click", function(){
        if (!confirm("已经送达了吗？")) {
            return false;
        }
        var self = $(this);
        var package_id = self.attr("data-id");
        self.unbind("click");
        $.post('./courier_status.php',{package_id:package_id, action:'arrive'}, function(result){
            if (result.status) {
                window.location.reload();
            } else {
                alert(result.msg);
            }
        },'json');

    });
})
</script>
</html>