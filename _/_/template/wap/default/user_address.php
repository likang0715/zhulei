<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理收货地址</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>ucenter/css/distribution.css" type="text/css">
    <script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script src="<?php echo TPL_URL;?>js/base.js"></script>
</head>
<body>
<style>
    .js-order-address .address-tip {
        padding: 15px 10px;
        border-radius: 0px;
        background-color:#43b8ec;
        color: #fff;
        text-align: center;
        font-size: 16px;
        margin-top: 10px;
        border: solid 1px #e1e1e1;
    }
    .js-order-address .address-tip a{
        text-decoration: none;
        color:#fff;
    }
</style>

<ul class="address">
    <?php foreach($address_list as $address) {?>
    <li class="<?php echo $address['default'] ? 'address-active' : ''?>">
        <div class="address-tit">
            <span class="fl address-tit-name"><?php echo $address['name']?></span>
            <span class="fr"><?php echo $address['tel']?></span>
            <div class="clear"></div>
        </div>
        <div class="address-con">
            <?php echo $address['province_txt']; ?> <?php echo $address['city_txt']; ?> <?php echo $address['area_txt']; ?>
            <?php echo $address['address']; ?>
        </div>
        <div class="address-edit">
                <span class="fl">
                    <!-- 切换效果需要切换图片 -->
                    <img class="address-sel fl" src="<?php echo TPL_URL;?>ucenter/images/<?php echo $address['default'] ? "address-ok.png" : "address.png" ;?>" alt="">
                    <?php if(!empty($address['default'])) {?>
                    <span class="fl">默认</span>
                    <?php } else {?>
                        <span class="address-sel-text fl" data-addressid="<?php echo $address['address_id'];?>" data-defaultid="<?php echo $address['default'];?>">默认</span>
                    <?php }?>
                    <span class="clear"></span>
                </span>
                <span class="fr">
                    <span class="icon-trash fl icon-icon-address"></span>
                    <span data-addressid="<?php echo $address['address_id'];?>" class="address-edita-text fl address-delete">删除</span>
                    <span class="clear"></span>
                </span>
                <span class="fr address-right-btn">
                    <img class="address-edita fl" src="<?php echo TPL_URL;?>ucenter/images/<?php echo $address['default'] ? "edit.png" : "edit-ok.png"?>" alt="">
                    <span class="address-edita-text fl address-update"><a style="color:#43b8ec;border:0px;text-decoration: none" href="./unitay_address.php?address_id=<?php echo $address['address_id'];?>">编辑</a></span>
                    <span class="clear"></span>
                </span>
            <div class="clear"></div>
        </div>
    </li>
    <?php }?>
    <div class="js-order-address express-panel">
        <div class="js-edit-address address-tip"><a href="./unitay_address.php"><span>添加新收货地址</span></a></div>
    </div>
</ul>

<script>
    $('.address-delete').click(function(e){
        var address_id = $(this).data('addressid');
        var post_url = './unitay_address.php?action=delete';
        var redirect_url = './user_address.php';
        if (!confirm("记录将不可恢复，确定删除？")) {
            return false;
        }
        $.post(post_url,{'address_id':address_id},function(data){
            if(data.err_code == 0){
                motify.log(data.err_msg);
                setTimeout('location.replace("'+ redirect_url +'")',1000);//延时2秒
            }else{
                motify.log(data.err_msg);
            }
        });

    });

    $('.address-sel-text').click(function(){
        var address_id = $(this).data('addressid');
        var post_url = './unitay_address.php?action=default';
        var redirect_url = './user_address.php';
        $.post(post_url,{'address_id':address_id},function(data){
            if(data.err_code == 0){
                motify.log(data.err_msg);
                setTimeout('location.replace("'+ redirect_url +'")',1500);//延时2秒
            }else{
                motify.log(data.err_msg);
            }
        });
    });
</script>
</body>
</html>