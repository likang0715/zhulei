<!DOCTYPE html>
<html>
<head>
    <script src="<?php echo TPL_URL;?>js/rem.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <title>分销店铺 - 我的团队</title>
    <link href="<?php echo TPL_URL;?>ucenter/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>ucenter/css/style.css" rel="stylesheet">
</head>

<body>
<header class="header_title">
	
	<?php if($_COOKIE['wap_store_id']) {?>
		<a href="./ucenter.php?id=<?php echo $_COOKIE['wap_store_id'];?>#promotion" onclick="javascript:history.go(-1);"><i></i></a>
	<?php } else {?>
		<a href="javascript:void(0)" onclick="javascript:history.go(-1);"><i></i></a>
	<?php }?>	
    <p>我的团队</p>
</header>
<div class="team_header clearfix">
    <div class="team_header_top clearfix">
        <div class="team_img"><img src="<?php echo empty($team_info['logo']) ? getAttachmentUrl('images/default_shop.png ') : getAttachmentUrl($team_info['logo']);?>" alt=""></div>
        <div class="team_txt">
            <div class="team_name_top">
                <h4><?php echo $team_info['name']?></h4>
                <span><i>排位:<?php echo !empty($team_num) ? $team_num : 1;?></i></span>
            </div>
            <p>总营销额：￥<?php echo !empty($team_info['sales']) ? $team_info['sales'] : '0.00';?></p>
            <p>团队成员：<?php echo !empty($num) ? $num : 1;?></p>
        </div>
    </div>
    <div class="team_header_bottom"><i></i>创建者:&nbsp;<?php echo $auth['name'] ;?></div>
</div>
<div class="team_info_list">
    <li>
        <div class="team_info_title">直属成员[<?php echo !empty($member_lable[0]['name']) ? $member_lable[0]['name'] : '直属成员'?>]<a href="./my_fx.php?supplier_id=<?php echo $now_store['store_id'];?>&level=<?php echo $now_store['drp_level']+1;?>"><i></i></a></div>
        <ul class=" clearfix">
            <li>
                <p><?php echo $directly_members['member_count']?></p>
                <span>成员数量</span>
            </li>
            <li>
                <p><?php echo $directly_members['orders']?></p>
                <span>订单数量</span>
            </li>
        </ul>
        <p><span>累计销售：￥<?php echo $directly_members['sales']?></span><!--<span>带来收入：￥32843</span>--></p>
    </li>
    <li>
        <div class="team_info_title">下级成员[<?php echo !empty($member_lable[1]['name']) ? $member_lable[1]['name'] : '下级成员'?>]<a href="./my_fx.php?supplier_id=<?php echo $fxSupplierInfo['store_id'];?>&level=<?php echo $now_store['drp_level']+2;?>"><i></i></a></div>
        <ul class=" clearfix">
            <li>
                <p><?php echo $second_members['member_count']?></p>
                <span>成员数量</span>
            </li>
            <li>
                <p><?php echo $second_members['orders']?></p>
                <span>订单数量</span>
            </li>
        </ul>
        <p><span>累计销售：￥<?php echo $second_members['sales']?></span><!--<span>带来收入：￥32843</span>--></p>
    </li>
</div>
</body>
<script src="<?php echo TPL_URL;?>js/jquery-1.7.2.js"></script>
<script src="<?php echo TPL_URL;?>js/index.js"></script>
<script src="<?php echo TPL_URL;?>js/rem.js"></script>
</html>
