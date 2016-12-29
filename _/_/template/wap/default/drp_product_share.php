<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title><?php echo $nowProduct['name']; ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- ▼ CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/font/icon.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/share-base.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/share-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/showcase.css">
    <script type="text/javascript" src="<?php echo TPL_URL; ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL; ?>js/dialog.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL; ?>js/weixinShare.js"></script>
    <script type="text/javascript">
        var drp_approve = parseInt("<?php echo $nowStore['drp_approve']; ?>");
        var status = parseInt("<?php echo $nowStore['status']; ?>");
        var is_fx = parseInt("<?php echo $nowProduct['is_fx'];?>");
    </script>
    <style type="text/css">
        .product .image img{
            height: auto;
            width: 100%;
        }
        .controls{
            text-align:center;
            padding: 5px;
        }
        .text_class{
            display:block;
            height: auto;
            font-size: 12px;
            border: 1px solid #cccccc;
            padding: 4px 6px;
            margin-left:65px;
            margin-bottom:5px;
            -webkit-border-radius: 6px;
        }
        .js-modal-close-btn {
            display: inline;
            font-size: 13px;
            background-color: #BFBFBF;
            color: #F0FFEC;
            padding: 5px;
            width: 45px;
            border: 0;
        }

        .js-modal-save-btn {
            display: inline;
            font-size: 13px;
            background-color: #FF575A;
            color: #F0FFEC;
            padding: 5px;
            width: 45px;
            border: 0;
        }
        .js-weixin-share {
            float: right;
            text-align: center;
            color: #F0FFEC;
            border: 1px solid #F0FFEC;
            padding: 0px;
            border-radius: inherit;
            position: absolute;
            right: 12px;
            top: 8px;
            width: 40px;
        }
        .share-mp-info {
            background: white;
        }
    </style>
</head>
<body wmall-title="<?php echo $nowProduct['name']; ?>" wmall-icon="<?php echo $nowProduct['image']; ?>" wmall-link="<?php echo option('config.wap_site_url'); ?>/good.php?id=<?php echo $nowProduct['product_id']; ?>&store_id=<?php echo $nowStore['store_id']?>" wmall-desc="<?php echo option('config.site_name'); ?>">
<div class="header">
    <!-- ▼顶部通栏 -->
    <div class="js-mp-info share-mp-info">
        <a class="page-mp-info" href="./home.php?id=<?php echo $store_id; ?>">
            <img class="mp-image" width="24" height="24" src="<?php echo $nowStore['logo'];?>" alt="<?php echo $nowStore['name']; ?>">
            <i class="mp-nickname"><?php echo $nowStore['name']; ?></i>
        </a>
        <div class="links">
            <a class="mp-homepage" href="./ucenter.php?id=<?php echo $store_id; ?>">会员中心</a>
        </div>
    </div>
    <!-- ▲顶部通栏 -->
</div>
<div id="views" style="padding-bottom: 70px;">
    <div class="ad-imgs" style="margin-bottom: 5px;">
        <div class="hd clearfix">
            <i class="iconfont icon" style="color: #ff9900;"></i>
            <p class="info">
                <span class="f18">分销佣金
                    <?php if ($nowProduct['min_profit'] == $nowProduct['max_profit']) { ?>
                    <label class="green"><?php echo $min_profit; ?></label>
                    <?php } else { ?>
                    <label class="green"><?php echo $min_profit; ?> ~ <?php echo $max_profit; ?></label>
                    <?php } ?>
                    元
                </span>
            </p>
        </div>
        <div class="talk-info">
            <div class="talk">
                <ul>
                    <li><img src="<?php echo $nowStore['logo']; ?>" width="40" height="40" /></li>
                    <li style="font-weight: bold; width: 90%" class="popover right">
                        <div class="arrow"></div>
                        <p class="msg">我是分销商 <span style="color: #FF9900;font-weight: bold"><?php echo $nowStore['name']; ?></span>，<br/>我为 <span style="color: #FF9900;font-weight: bold"><?php echo $store['name']; ?></span> 分销 <span class="js-weixin-share">编辑</span></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="product">
            <div class="image">
                <img src="<?php echo $nowProduct['image']; ?>">
                <div class="name" style="top:0;">
                    <span class="name-overflow"><?php echo $nowProduct['name']; ?></span><br/>
                    <span class="price">分销价: ￥<?php echo $nowProduct['price']; ?></span>
                </div>
            </div>
            <div class="qrcode">
                <img width="300" height="300" src="<?php echo $config['site_url'];?>/source/qrcode.php?type=good&id=<?php echo $nowProduct['product_id'];?>&store_id=<?php echo $nowStore['store_id']; ?>" />
            </div>
        </div>
        <div class="footer">
            <a class="btn btn-white js-share-link"><i class="iconfont" style="color:#ff7c22;"></i>链接分销</a>
            <a class="btn btn-white js-share-img"><i class="iconfont" style="color:#359999;"></i>图片分销</a>
        </div>
    </div>
    <div class="layout">
        <div class="item">
            <div class="row">
                <div class="hd" style="color: #000;">
                    <i class="iconfont" style="font-size: 18px;color: #ff6600;"></i>分销如何赚钱
                </div>
                <div class="bd" style="padding: 4px 0 0;">
                    <table cellpadding="0" cellspacing="0" style="margin-bottom: 6px;">
                        <tbody><tr>
                            <th width="55" style="text-align: left;vertical-align: top;">第一步
                            </th><td class="deep-gray">分享商品或店铺链接给微信好友；</td>
                        </tr>
                        <tr>
                            <th width="55" style="text-align: left;vertical-align: top;">第二步
                            </th><td class="deep-gray">从您转发的链接进入店铺的好友，他们在您的店铺中购买任何分销商品，您都可以获得分销佣金。</td>
                        </tr>
                        <tr>
                            <th width="55" style="text-align: left;vertical-align: top;">第三步
                            </th><td class="deep-gray">您可以在订单中查看好友下的订单。交易完成后，佣金可提现。</td>
                        </tr>
                        </tbody>
                    </table>
                    <p style="font-size14px;background-color: #fe924a;color: #fff;padding: 10px;">
                        说明：以上分销佣金仅为参考，实际的佣金请以交易完成后获得的佣金为准。
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pop-dialog js-dialog-link" style="display: none;">
    <div class="bg"></div>
    <div class="body">
        <img class="collect-img" src="<?php echo TPL_URL; ?>images/share_friend.png">
    </div>
</div>

<div class="dialog js-dialog-img">
    <div class="body">
        <div class="explain-text">
            <i class="iconfont" style="color: #ff9934;"></i>
            <span class="text">长按保存图片并将图片转发给您的好友。</span>
        </div>
        <a class="btn btn-green dialog-close">哦，我知道了</a>
    </div>
</div>


<script type="text/javascript">
    $('.js-share-link').on('click', function(){
        $(".js-dialog-img").Dialog('hide');
        $(".js-dialog-link").show();
    });
    $('.js-dialog-link .body').on('click', function(){
        $(".js-dialog-link").hide();
    });
    $(".js-share-img").on('click', function(){
        $('.explain-text > .text').text('长按保存图片并将图片转发给您的好友。');
        $(".js-dialog-link").hide();
        $(".js-dialog-img").Dialog();
    });

    if (status != 1) {
        $('.explain-text > .text').text('您的分销店铺已被禁用，无法正常访问！');
        $(".js-dialog-img").Dialog();
    } if (drp_approve == 0) {
        $('.explain-text > .text').text('您的分销店铺还在审核中，请耐心等待！');
        $(".js-dialog-img").Dialog();
    } else if (is_fx != 1) {
        $('.explain-text > .text').text('商品未设置分销，您无法获得分润！');
        $(".js-dialog-img").Dialog();
    }
</script>

<?php echo $shareData;?>
</body>