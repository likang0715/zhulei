<?php if (!defined('PIGCMS_PATH')) exit('deny access!'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta class="foundation-data-attribute-namespace"/>
    <meta class="foundation-mq-xxlarge"/>
    <meta class="foundation-mq-xlarge"/>
    <meta class="foundation-mq-large"/>
    <meta class="foundation-mq-medium"/>
    <meta class="foundation-mq-small"/>
    <title>会员中心 - <?php echo $store['name']; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/foundation.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL; ?>css/common.css"/>
    <style type="text/css">
        .header-r .try-tip {
            width: 100px;
        }
    </style>
</head>

<body class="body-gray">
<div class="mask"></div>
<div class="fixed">
    <nav class="tab-bar">
        <section class="left-small">
            <a class="menu-icon" href="./drp_ucenter.php"><span></span></a>
        </section>
        <section class="middle tab-bar-section">
            <h1 class="title">会员中心</h1>
        </section>
    </nav>
</div>

<div class="panel memberhead">
    <div class="header-l">
        <i class="icon-level-dis"></i>
    </div>
    <div class="header-r">
        <a href="./drp_ucenter.php?a=profile">
            <span class="name"><?php echo $store['name']; ?></span>
            <?php if ($drp_approve) { ?>
                <i class="try-tip">正式分销商</i>
            <?php } else { ?>
                <i class="try-tip">待审核分销商</i>
            <?php } ?>
            <span class="header-tip-text">
                <?php if (!empty($store['supplier'])) { ?>
                    供货商：<?php echo $store['supplier']; ?>
                <?php } else { ?>
                    您已成为正式分销商...
                <?php } ?>
            </span>
            <i class="arrow"></i> </a>
    </div>
</div>
<div class="panel member-nav">
    <ul class="side-nav">
        <li id="brokerage">
            <a href="./drp_commission.php?a=index">
                <i class="icon-commission"></i>
                <span class="text">我的佣金</span>
                <i class="arrow"></i>
            </a>
        </li>
        <li>
            <a href="./drp_store_fans.php?a=index">
                <i class="icon-client"></i>
                <span class="text">我的粉丝</span>
                <i class="arrow"></i>
            </a>
        </li>
        <li>
            <a href="./drp_trade.php?a=index">
                <i class="icon-ratio"></i>
                <span class="text">交易记录</span>
                <i class="arrow"></i>
            </a>
        </li>
        <li>
            <a href="./drp_commission.php?a=detail#1">
                <i class="icon-card"></i>
                <span class="text">提现记录</span>
                <i class="arrow"></i>
            </a>
        </li>
        <li>
            <a href="./drp_return.php?a=index">
                <i class="icon-return"></i>
                <span class="text">退货管理</span>
                <i class="arrow"></i>
            </a>
        </li>
        <li>
            <a href="./drp_rights.php?a=index">
                <i class="icon-return"></i>
                <span class="text">维权管理</span>
                <i class="arrow"></i>
            </a>
        </li>
    </ul>
</div>

<div class="panel member-nav">
    <ul class="side-nav">
        <li>
            <a href="./drp_store_qrcode.php?store_id=<?php echo $_SESSION['wap_drp_store']['store_id']?$_SESSION['wap_drp_store']['store_id']:0?>">
                <i class="icon-qrcode"></i>
                <span class="text">店铺二维码</span>
                <i class="arrow"></i>
            </a>
        </li>
        <li class="last">
            <a href="./drp_ucenter.php?a=profile">
                <i class="icon-personal"></i>
                <span class="text">个人资料</span>
                <i class="arrow"></i>
            </a>
        </li>
    </ul>
</div>

<div class="h50"></div>
<div class="fixed bottom">
    <dl class="sub-nav nav-b5">
        <dd>
            <div class="nav-b5-relative">
                <a href="./home.php?id=<?php echo $store['store_id']; ?>"><i class="icon-nav-bag"></i>逛街</a>
            </div>
        </dd>
        <dd>
            <div class="nav-b5-relative">
                <a href="./drp_ucenter.php"><i class="icon-nav-store"></i>分销管理</a>
            </div>
        </dd>
        <dd class="active">
            <div class="nav-b5-relative">
                <a href="javascript:void(0)"><i class="icon-nav-heart"></i>会员中心</a>
            </div>
        </dd>

        <dd>
            <div class="nav-b5-relative">
                <a href="./drp_store.php?a=logout"><i class="icon-nav-search"></i>退出</a>
            </div>
        </dd>
    </dl>
</div>
<?php echo $shareData;?>
</body>
</html>