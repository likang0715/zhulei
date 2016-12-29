<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="applicable-device" content="mobile">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
<title><?php echo $actioninfo['action_name']; ?></title>
<link href="<?php echo TPL_URL; ?>css/shakelottery/weiba.new.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo TPL_URL; ?>css/shakelottery/shake.css" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/shakelottery/base.css">
<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/shakelottery/window.css">
<script type="text/javascript" src="<?php echo TPL_URL; ?>js/shakelottery/jquery-1.7.2.min.js"></script>
<script src="<?php echo TPL_URL; ?>js/shakelottery/shake.js"></script>
<script src="<?php echo TPL_URL; ?>js/shakelottery/alert.js"></script>
<script src="<?php echo TPL_URL; ?>activity_style/js/layer.js?ii=<?php echo rand(1,99999999); ?>"></script>
</head>
<body>
<audio id="failaudio" src='<?php echo TPL_URL; ?>images/shakelottery/fail.wav'></audio>
<audio id="successaudio" src='<?php echo TPL_URL; ?>images/shakelottery/success.wav'></audio>


<div class="wap">
    <div class="shake-title" onclick="window.location.href='<?php echo $actioninfo['remind_link']; ?>'"><?php echo $actioninfo['remind_word']; ?></div>
    <div class="game-status" style="width:300px;height:300px;;">
        <div class="game-yao"></div>
        <div class="lihua"></div>
    </div>
    <div class="game-btn" style="text-align:center;">
		<?php if($actioninfo['starttime'] > time()){?>
			<button class="game-prepare-btn" onclick="alert('活动未开始,请注意页面的倒计时');">开始摇奖</button>
		 <?php }else{?>
			<!--button class="game-start-btn" onclick="alert('请摇动手机进行抽奖')">开始摇奖</button-->
            <button class="game-start-btn" onclick="shakelottery()">开始摇奖</button>
		<?php } ?>
        <section class="oTime" >
        <div class="timeBox">
            <div class="fr timeBar"></div>
            <div class="fl timeBar"></div>
            <div class="hook right"></div>
            <div class="hook left"></div>
            <div class="timeCenter">
                <ul class="timeShow">
                    <li class="bg">00</li>
                    <li class="oText">天</li>
                    <li class="bg">00</li>
                    <li class="oText">时</li>
                    <li class="bg">00</li>
                    <li class="oText">分</li>
                    <li class="bg">00</li>
                    <li class="oText">秒</li>
                </ul>
            </div>
        </div>
    	</section>
    </div>
    <div class="game-box page-descs">
        <h1>摇奖说明</h1>
        <div class="content page-desc"><?php echo html_entity_decode($actioninfo['action_desc']); ?></div>
        <h1 class="game-prize-list">奖项设置</h1>
        <ul class="prize-list game-list clearfix page-prize-list">
	        <?php foreach ($prize as $k => $v) {  ?>
		        <li class="clearfix" style="margin-bottom:10px;"><img class="prize-img" src="<?php  if($v['prize_type']==1){ echo getAttachmentUrl($v['prizeimg']); }elseif($v['prize_type']==2){  echo option("config.site_url").'/template/wap/default/images/shakelottery/youhuiquan.jpg';   }elseif($v['prize_type']==3){   echo option("config.site_url").'/template/wap/default/images/shakelottery/jifen.jpg';  }    ?>">
		        <span class="prize-name" style="width:150px;"><?php echo mb_substr($v['prizename'], 0,15,'utf-8'); ?></span>
		        <span style="line-height: 30px;float: left;height: 30px;">
		        </span>
		        <span class="prize-num"> <?php echo $actioninfo['is_amount']!=2 ?  $v['prizenum'] : ''; ?> </span>
		        </li>
	        <?php } ?>
	   </ul>
    </div>
    <div class="game-box page-record-lists">
        <h1>我的中奖记录<div style="float: right;"><a href="/wap/ucenter.php?id=<?php echo $actioninfo['store_id']; ?>" style="color:#44b549;" target="_blank">会员中心</a></div></h1>
        <ul class="record-list page-record-list game-list clearfix myrecord"></ul>
    </div>
    <div class="game-box page-record-lists">
        <h1>其他中奖名单</h1>
        <ul class="record-list page-record-list game-list clearfix otherrecord"></ul>
    </div>
</div>
<div class="fullBg"></div>
<div class="owindow get">
<a class="aClosed" onclick="aClosed()"></a>
    <img src="<?php echo TPL_URL; ?>images/shakelottery/gettext.png" height="25" class="bigtext">
    <p class="tipText"></p>
    <div class="priceImg"></div>
</div>
<div class="owindow sorry">
    <a class="aClosed" onclick="aClosed()"></a>
    <img src="<?php echo TPL_URL; ?>images/shakelottery/sorrytext.png" height="25" class="bigtext">
    <p class="tipText"></p>
</div>
<input type="hidden" id="stat" value="ok" />
<?php include display('lottery_footer');?>
</body>
</html>