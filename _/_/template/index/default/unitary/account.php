<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="1元夺宝，就是指只需1元就有机会获得一件商品，是基于网易邮箱平台孵化的新项目，好玩有趣，不容错过。">
	<meta name="keywords" content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵">
	<title>小猪电商夺宝 - 一个收获惊喜的网站</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'];?>/static/unitary/css/bef6decb938119df87327e5e548e997f221af746.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'];?>/static/unitary/css/7a056a50e1ab75b10e47a6ae1f426a513a8165be.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'];?>/static/unitary/css/e28ef861cf2a621936f746655925fb9442143a7a.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'];?>/static/unitary/css/7abe3ec993cda23d68dfb6069302e85913622050.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $config['site_url'];?>/static/unitary/css/99676e3d5402964586035a0a0671db3ec82efeb3.css">
	<script src="<?php echo STATIC_URL;?>unitary/js/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="<?php echo STATIC_URL;?>unitary/js/jquery.ScrollPic.js" type="text/javascript"></script>
	<script type="text/javascript">
		var account_list_url = "<?php dourl('unitary:account_list') ?>";
		var account_luck_url = "<?php dourl('unitary:account_luck') ?>";
		var page_content = "<?php echo $now_page ?>";
	</script>
</head>
<body>
<?php include display('public:header_unitary'); ?>
<div class="g-body">
<div class="m-user">
<div class="g-wrap">
<div class="m-user-frame-wraper">

	<!-- left nav -->
	<div class="m-user-frame-colNav">
        <h3><a href="javascript:void(0)">我的夺宝</a></h3>
        <hr>
        <ul pro="userFrameNav">
            <li>
                <a href="<?php dourl('unitary:account', array('type'=>'list')) ?>" <?php if ($now_page == 'list') echo 'style="color:#db3652;font-weight:bold"'; ?> >夺宝记录 <strong pro="userDuobao_num" data-pos="userNav" class="txt-impt"></strong></a>
            </li>
            <li>
                <a href="<?php dourl('unitary:account', array('type'=>'luck')) ?>" <?php if ($now_page == 'luck') echo 'style="color:#db3652;font-weight:bold"'; ?> >幸运记录 <strong pro="userWin_num" data-pos="userNav" class="txt-impt"></strong></a>
            </li>
            <li><hr></li>
        </ul>
    </div>

    <!-- main -->
    <div class="m-user-frame-colMain ">
        <div class="m-user-frame-content" pro="userFrameWraper">

		    <ul class="w-crumbs f-clear">
		        <li class="w-crumbs-item">当前位置：</li>
		        <li class="w-crumbs-item <?php if ($now_page == 'list') { echo 'w-crumbs-active'; } ?>">
		        	<a href="<?php dourl('unitary:account') ?>">我的夺宝</a><span class="w-crumbs-split">&gt;</span>
		        </li>
				<li class="w-crumbs-item w-crumbs-active">
					<?php if ($now_page == 'list') {
						echo '夺宝记录';
					} else if ($now_page == 'luck') {
						echo '幸运记录';
					} ?>
				</li>
		    </ul>

		    <div id="account_con"></div>

        </div>
    </div>

    <div class="m-user-frame-clear"></div>

</div>
</div>
</div>
</div>

<?php include display('public:footer_unitary'); ?>
<script src="<?php echo STATIC_URL;?>unitary/js/common.js" type="text/javascript"></script>
<script src="<?php echo STATIC_URL;?>unitary/js/account.js" type="text/javascript"></script>
</body>
</html>