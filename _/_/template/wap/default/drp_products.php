<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link href="<?php echo TPL_URL;?>css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/distribution.css" type="text/css">
    <title>分销商品 - <?php echo $store['name']; ?></title>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
    <script src="<?php echo TPL_URL;?>js/index.js"></script>
    <script src="<?php echo STATIC_URL;?>js/fastclick.js"></script>
    <script src="<?php echo TPL_URL;?>index_style/js/base.js"></script>
    <script>var page_url = 'drp_products.php?a=index&ajax=1', page_type = '<?php echo $action;?>', label = '店铺';</script>
    <script src="<?php echo TPL_URL;?>js/drp_product.js"></script>
</head>
<body>
<style>
    .fl {
        float: left;
    }
    .disList {
        margin-top: -12px;
    }
    .levelNow {
        background: #45a5cf;
        font-size: 12px;
        vertical-align: middle;
        display: inline-block;
        color: #fff;
        margin-left: .3rem;
        border-radius: .1rem;
        padding: 0 .2rem;
    }
    #account {
        height: auto;
        background-color: #FFD100;
        width: 90%;
        padding: 2px 10px 10px 2px;
        font-size: 12px;
        margin: 0 auto;
        margin-top: 5px;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
        background-color: #fcf8e3;
        border: 1px solid #fbeed5;
        border-radius: 5px;
    }
    #account .msg-li{
        margin-bottom: 5px;
    }
</style>
<section class="distribution">
    <div class="disList">
        <div class="disTop">
            <h1>商品列表</h1>
        </div>
        <div id="account">
            <ul>
                <li class="msg-li" style="color:#F52020;">温馨提示：<span class="more" style="float:right;color:#0F9AE6;cursor:hand;">更多</span></li>
                <li class="msg-li">1、直销利润是直接销售获得的利润</li>
                <div class="msg">
                    <li class="msg-li">2、二级分润是下级分销商销售当前店铺获得的利润</li>
                    <li class="msg-li">3、三级分润是下下级分销商销售当前店铺获得的利润</li>
                    <li class="msg-li" style="margin-bottom: 0px;">4、统一直销利润是各级直销将获得相同的利润</li>
                </div>

            </ul>
        </div>
        <script>
            $(function(){
               $('.msg').css('display','none');
                //$('.more').click(function(){
                    $('.more').toggle(function(){
                        $(this).text('收起');
                        $('.msg').slideDown(300);
                    },function(){
                        $(this).text('更多');
                        $('.msg').slideUp(300);
                    });
                //});
            });
        </script>
        <div class="disItem">
            <div class="disHead">
                <div class="disHeadWrap">
                    <span>
                        <i>
                            <img  src="<?php echo empty($icoPath) ? TPL_URL.'ucenter/images/kong.png' : $icoPath;?>"/></i><?php echo !empty($fxDegreeName) ? $fxDegreeName : '尚未获得分销等级'?> <em>分润</em>
                    </span>
                </div>
            </div>

            <div class="disLevelDetail" style="padding: 0rem;">
            </div>
            <div class="wx_loading2"></div>
        </div>
    </div>
</section>
<script src="<?php echo TPL_URL; ?>js/jquery.grid-a-licious.min.js"></script>
<?php echo $shareData;?>
</body>
</html>
