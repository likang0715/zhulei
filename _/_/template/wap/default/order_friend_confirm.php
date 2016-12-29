<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<link href="<?php echo TPL_URL;?>css/order_friend_base.css" rel="stylesheet">
<link href="<?php echo TPL_URL;?>css/order_friend_index.css" rel="stylesheet">
<link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
<title>赠送他人</title>
</head>
<body>
	<div class="give">
		<div class="give_img"><a href="order_friend_pay.php?order_id=<?php echo $order_id ?>&type=1"><img src="<?php echo TPL_URL;?>images/give_02.png"></a></div>
		<?php 
		if ($commonweal_address) {
		?>
			<div class="give_img"><a href="order_friend_pay.php?order_id=<?php echo $order_id ?>&type=2"><img src="<?php echo TPL_URL;?>images/give_03.png"></a></div>
		<?php 
		} else {
		?>
			<div class="give_img"><a href="javascript: alert('店铺未设置送公益');"><img src="<?php echo TPL_URL;?>images/give_03.png"></a></div>
		<?php 
		}
		?>
		<div class="give_img"><a href="order_friend_pay.php?order_id=<?php echo $order_id ?>&type=3"><img src="<?php echo TPL_URL;?>images/give_04.png"></a></div>
	</div>
</body>
</html>