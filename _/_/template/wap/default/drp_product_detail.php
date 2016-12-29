<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL;?>css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/distribution.css" type="text/css">
    <title>分销商品-等级分润明细</title>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/index.js"></script>
</head>
<body>
<style>
    .disList {
        margin-top: -12px;
    }
    .disItem .itemSin .itemImg {
        width: 220px;
    }
    .disItem .itemSin .itemPrice {
        font-size: .7rem;
        color: #45a5cf;
        margin-top: 0.5rem;
        float: right;
    }
</style>
<section class="distribution">
    <div class="disList">
        <div class="disTop">
            <h1>分销商等级分润明细</h1>
        </div>
        <div class="disItem">
            <div class="itemSin">
                <small class="itemPrice fr">
                    ￥<?php echo $price;?>
                </small>
                <h2 class="itemImg">
                    <i><img src="<?php echo getAttachmentUrl($product_detail['image'], FALSE);?>"/></i><?php echo $product_detail['name'];?>
                </h2>
            </div>

            <div class="disLevelDetail">
                <?php if(is_array($profit)) {?>
                <?php foreach($profit as $pro) { ?>
                <div class="row <?php echo $pro['degree_id'] == $store_detail['drp_degree_id'] ? 'now' : '';?> ">
                    <h3><i><img src="<?php echo $pro['ico'];?>"/></i><?php echo $pro['name']?> <em>分润</em><?php echo $pro['degree_id'] == $store_detail['drp_degree_id'] ? '<small class="levelNow">当前级别</small>' : '';?></h3>
                    <ul>
                        <li>
                            <h4>直销利润</h4>
                            <p>￥<?php echo $pro[1];?></p>
                        </li>
                        <li>
                            <h4>二级分润</h4>
                            <p>￥<?php echo $pro[2];?></p>
                        </li>
                        <li>
                            <h4>三级分润</h4>
                            <p>￥<?php echo $pro[3];?></p>
                        </li>
                    </ul>
                </div>
                <?php }?>
                <?php } else {?>
                <div class="disLevelDetail">
                    <div class="noData">
                        <div class="noDataImg">
                            <img src="<?php echo TPL_URL;?>ucenter/images/nodata.png"/>
                        </div>
                        <p><?php echo $profit;?></p>
                        <div class="backBtn">
                            <a href="javascript:history.go(-1);">
                                返回
                            </a>
                        </div>
                    </div>
                </div>
                <?php }?>

            </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
