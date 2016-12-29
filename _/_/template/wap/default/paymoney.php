<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js admin <?php if($_GET['ps']<=320){ ?>responsive-320<?php }elseif($_GET['ps']>=540){ ?>responsive-540<?php }?> <?php if($_GET['ps']>540){ ?> responsive-800<?php } ?>" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
		<meta name="description" content="<?php echo $config['seo_description'];?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="renderer" content="webkit">
	<meta name="format-detection" content="telephone=no" />
	<meta name="format-detection" content="email=no" />
		<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
		<title>收银台</title>
	<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>pay/pay.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>pay/reset.css">
    <link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>pay/ux/iconfont.css">
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
	<link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
	<script src="<?php echo TPL_URL;?>js/base.js"></script>
	
	<script type="text/javascript" src="<?php echo TPL_URL;?>pay/jquery-2.2.3.js"></script>
    <script type="text/javascript" src="<?php echo TPL_URL;?>pay/fastclick.js"></script>
    <script type="text/javascript">
   		var order_no = "<?php echo $cashier_id; ?>";
		var noCart = true;
	</script>
	<script src="<?php echo TPL_URL;?>js/pay_cashier.js?time=<?php echo time() ?>"></script>
	<style>
			.qrcodepay {display:none;margin:0 10px 10px 10px;}
			.qrcodepay .item1{background:#fff;border:1px solid #e5e5e5;}
			.qrcodepay .title{margin:0 10px;padding:10px 0;border-bottom:1px solid #efefef;}
			.qrcodepay .info{text-align:center;line-height:25px;font-size:12px;}
			.qrcodepay .qrcode{margin-bottom:10px;}
			.qrcodepay .qrcode img{width:200px;height:200px;}		
			.qrcodepay .item2 {background:#fff;border:1px solid #e5e5e5;margin:10px 0;line-height:40px;text-align:center;}
			.qrcodepay .item2 a{display:block;height:100%;width:100%;}
		</style>
	</head>
	<body onselectstart="return true;" ondragstart="return false;">
	
	
	
	    <div class="container">
        <div class="content">
            <div class="cashier-info-container center">
                <div class="avatar cashier-avatar">
                    <a href="./home.php?id=<?php echo $now_store['store_id'];?>">
                        <img class="circular" src="<?php echo $now_store['logo'];?>" alt="<?php echo $now_store['name'];?>">
                    </a>
                </div>

                <div class="cashier-form">
                    <label for="cashier-price" class="font-size-12 cashier-label">金额（元）</label>
                    <div class="cashier-field">
                        <i class="money-text">￥</i>
                        <p class="showPrice" id="showPrice">
                            <i id="js-cashier-cursor" class="cursor cursor-animation"></i>
                        </p>

                        <!-- <span type="text" id="cashier-price" class="cashier-text"></span> -->
                        <!-- <i id="js-cashier-cursor" class="cursor cursor-animation"></i> -->
                    </div>
                </div>
                <input type="hidden" name="money" id="inputmony">
				<input type="hidden" name="cashier_id" id="cashier_id" value="<?php echo $cashier_id;?>">
                <input type="hidden" name="openid" id="openid" value="<?php echo $openid;?>">
				<input type="hidden" name="store_id" id="store_id" value="<?php echo $store_id;?>">
				<input type="hidden" name="pid" id="pid" value="<?php echo $pigcms_id;?>">
            </div>
            <div class="more-word">支付完成后，如需退款请及时联系卖家</div>
        </div>
        <div class="ui-keyboard">
            <ul class="ui-keyboard-numbers js-num">
                <li>1</li><li>2</li><li class="paddingOne">3</li>
                <li>4</li><li>5</li><li class="paddingOne">6</li>
                <li>7</li><li>8</li><li class="paddingOne">9</li>
                <li class="zero">0</li><li class="paddingOne">.</li>
            </ul>
            <ul class="ui-keyboard-buttons">
                <li class="btn-del js-del iconfont">&#xe6ef;</li>
                <li class="btn-ok js-ok gray">支付</li>
            </ul>
        </div>        
    </div>

    <script type="text/javascript" src="<?php echo TPL_URL;?>pay/pay.js"></script>
    <script type="text/javascript">
        FastClick.attach(document.body);
	</script>
    </body>
</html>
<?php Analytics($now_store['store_id'], 'ucenter', '会员主页', $now_store['store_id']); ?>