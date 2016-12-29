<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport"/>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link href="<?php echo TPL_URL;?>points/css/base.css" rel="stylesheet">
    <link href="<?php echo TPL_URL;?>points/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TPL_URL;?>points/css/usercenter.css" type="text/css">
	<title>个人中心</title>
	<script src="<?php echo TPL_URL;?>points/js/rem.js"></script>
	<script src="<?php echo TPL_URL;?>points/js/jquery-1.7.2.js"></script>
	<script src="<?php echo STATIC_URL;?>js/layer_mobile/layer.m.js"></script>
	<script type="text/javascript">
	$(function(){
		// 分享遮罩
		$(".js-btn-copy").click(function () {
            $("#js-share-guide").removeClass("hide");
        });
        
        $("#js-share-guide").click(function () {
            $("#js-share-guide").addClass("hide");
        });
	})
	</script>
</head>
<body>
<div class="signIn signInDetail">
	<div class="task">
		<div class="row">
			<h3><i></i>您的专属二维码图片</h3>
			<div class="follow" style="margin-bottom: 1rem;">
				<div class="followWrap">
					<h2>欢迎关注<em><?php echo $storeInfo['name'] ?></em></h2>
					<div class="clearfix followInfo">
						<div class="followQrCode fl">
							<img src="<?php echo option('config.site_url'); ?>/source/qrcode.php?type=pointShare&id=<?php echo $wap_user['uid']?>&url=<?php echo urlencode($data['share_link']) ?>"/>
						</div>
						<div class="followMe">
							<div class="followText">
								欢迎关注微店 “<?php echo $storeInfo['name'] ?>”，<br>
								关注微店有好礼赠送。
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="codeTip">
				<a class="codeTipBtn fr" href="javascript:">生成专属海报</a>
				<span>生成图片，直接分享给朋友</span>
			</div>

            <script>
                $('.codeTipBtn').click(function(){
                    var act = 'down';
                    var store_id = '<?php echo $_GET['store_id'];?>';
                    var qrcode_url = '<?php echo $data['share_link'] ?>';
                    layer.open({
						content: '海报正在生成......',
						time:10
					});
                    $.post('./drp_store_qrcode.php',{'act':act,'store_id':store_id,'qrcode_url':qrcode_url},function(data){
                        if(data.error_code == 0){
                            window.location.href='<?php option('config.site_url');?>'+data.message;
                        } else {
                            layer.open({
								content: data.message,
								time:2
							});
                        }
                    },'json');
                });
            </script>
		</div>
		<div class="row">
			<h3><i></i>您的专属链接图片</h3>
			<p>分享下面链接到朋友圈  朋友点击就有可能给你带来积分收入哦</p>
			<div class="copyUrl">
				<a href="javascript:;" class="js-btn-copy fr">分享链接</a>
				<input type="text" value="<?php echo $data['share_link'] ?>">
			</div>
		</div>
	</div>
	<div class="followMoreInfo">
		<h3><i></i>推广说明</h3>
		<div class="Infotext">
			<p>如果店铺开启了店铺积分功能，推广可获得积分，同时下面的方法也可获得积分</p>
			<p>1.首次关注店铺公众号，可获得店铺赠送的大量积分；</p>
			<p>2.推荐别人关注公众号的人，也可获得一定积分奖励；</p>
			<p>3.关注公众号获得积分，推广可获得三级积分奖金；</p>
			<p>4.积分可抵现，可升级用户等级获得购物折扣，参加店铺举行的各种活动；</p>
		</div>
	</div>
</div>
<div id="js-share-guide" class="js-fullguide fullscreen-guide hide" style="font-size: 16px; line-height: 35px; color: #fff; text-align: center;"><span class="js-close-guide guide-close">×</span><span class="guide-arrow"></span><div class="guide-inner">请点击右上角<br>通过【发送给朋友】功能<br>或【分享到朋友圈】功能<br>把信息分享给朋友～</div></div>
<?php 
$share_conf     = array(
    'title'     => "关注微店，好礼赠送！", // 分享标题
    'desc'      => "欢迎关注微店 “".$storeInfo['name']."”，关注微店有好礼赠送。", // 分享描述
    'link'      => $data['share_link'], // 分享链接
    'imgUrl'    => option('config.site_url')."/upload/".$storeInfo['logo'], // 分享图片链接
    'type'      => '', // 分享类型,music、video或link，不填默认为link
    'dataUrl'   => '', // 如果type是music或video，则要提供数据链接，默认为空
);

import('WechatShare');
$share      = new WechatShare();
$shareData  = $share->getSgin($share_conf);
echo $shareData;
?>
</body>
</html>
