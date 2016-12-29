<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title> 商品店铺 <?php echo $config['site_name'];?>分销平台 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
    <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
    <link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/fx.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo TPL_URL;?>css/order.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo STATIC_URL;?>css/jquery.ui.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
    <script type="text/javascript">var load_url="<?php dourl('load');?>", delivery_address_url = "<?php dourl('delivery_address'); ?>", market_url = "<?php dourl('market'); ?>", soldout_url = "<?php dourl('goods:soldout'); ?>", service_url="<?php dourl('service'); ?>";</script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/fx_common.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>js/fx_wholesale_market.js"></script>
    <style type="text/css">
    .select2-container .select2-choice {
        border-radius:0;
    }
    .select2-container .select2-choice {
        background-image: none;
    }
    .select2-container .select2-choice .select2-arrow {
        border-left: none;
        background: none;
        background-image: none;
    }
    .select2-drop {
        border-radius: 0;
    }
    .red {
        color:red;
    }

    .ui-nav {
        border: none;
        background: none;
        position: relative;
        border-bottom: 1px solid #e5e5e5;
        margin-bottom: 15px;
        margin-top: 23px;
    }
    .pull-left {
        float: left;
    }
    .ui-nav ul {
        zoom: 1;
        margin-bottom: -1px;
        margin-left: 1px;
    }
    .ui-nav li {
        float: left;
        margin-left: -1px;
    }
    .ui-nav li a {
        display: inline-block;
        padding: 0 12px;
        line-height: 32px;
        color: #333;
        border: 1px solid #e5e5e5;
        background: #f8f8f8;
        min-width: 80px;
        text-align: center;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .ui-nav li.active a {
        font-size: 100%;
        border-bottom-color: #fff;
        background: #fff;
        margin:0px;
        line-height: 32px;
    }

    .block-help>a {
        display: inline-block;
        width: 16px;
        height: 16px;
        line-height: 18px;
        border-radius: 8px;
        font-size: 12px;
        text-align: center;
        background: #bbb;
        color: #fff;
    }
    .block-help>a:after {
        content: "?";
    }
	
	
	
	.ui-nav-table {
    position: relative;
    border-bottom: 1px solid #ccc;
    margin-bottom: 15px;
	margin-top:15px;
}

.ui-nav-table ul {
    zoom: 1;
    margin-bottom: -1px;
    margin-left: 1px;
}
.pull-left {
    float: left;
}
.ui-nav-table li {
    float: left;
    margin-left: -1px;
}

.ui-nav-table li.active a {
    border-color: #ccc #ccc #fff;

    background: #fff;
    color: #07d;
}

.ui-nav-table li a {  display: inline-block;  padding: 0 12px;  line-height: 40px;  color: #333;  border: 1px solid #ccc;  background: #f8f8f8;  min-width: 80px;  text-align: center;  -webkit-box-sizing: border-box;  -moz-box-sizing: border-box;  box-sizing: border-box;  }
</style>

</head>
<body class="font14 usercenter">
<?php include display('public:header');?>
<div class="wrap_1000 clearfix container">
    <?php include display('sidebar');?>
    <div class="app">
        <div class="app-inner clearfix">
            <div class="app-init-container">
                 <nav class="ui-nav clearfix">
                    <ul class="pull-left">
                        <li class="active" data-checked="1">
                            <a href="#wholesale_market">可批发店铺</a>
                        </li>
                        <li data-checked="2">
                            <a href="#wholesale_market_product">可批发商品</a>
                        </li>
                    </ul>
                </nav>
                <div class="nav-wrapper--app"></div>
                <div class="app__content">
                </div>
            </div>
        </div>
    </div>
</div>
<?php include display('public:footer');?>
<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
</body>
</html>