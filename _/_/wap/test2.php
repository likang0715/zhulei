<!DOCTYPE html>
<html class="no-js admin  responsive-320" lang="zh-CN">
	<head>
		<meta charset="utf-8"/>
		<meta name="keywords" content="小猪微店系统,微信商城,粉丝营销,微信商城运营" />
		<meta name="description" content="小猪微店系统是帮助商家在微信上搭建微信商城的平台，提供店铺、商品、订单、物流、消息和客户的管理模块，同时还提供丰富的营销应用和活动插件。" />
		<meta name="HandheldFriendly" content="true"/>
		<meta name="MobileOptimized" content="320"/>
		<meta name="format-detection" content="telephone=no"/>
		<meta http-equiv="cleartype" content="on"/>
		<link rel="icon" href="http://www.weidian.com/favicon.ico" />
		<title>我是供货商</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no,minimal-ui">
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<script src="http://dd2.pigcms.com/static/js/jquery.min.js"></script>
		<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>
		$(function () {
			$.get('test.php?' + Math.random(), function (data) {
				var share_data = data.err_msg.share_data;
				alert(share_data.appId);
				alert(share_data.timestamp);
				alert(share_data.nonceStr);
				alert(share_data.signature);


				var config = {};
				var jsApiList = [
									'checkJsApi',
									'onMenuShareTimeline',
									'onMenuShareAppMessage',
									'onMenuShareQQ',
									'onMenuShareWeibo',
									'openLocation',
									'getLocation',
									'addCard',
									'chooseCard',
									'openCard',
									'hideMenuItems',
									'getLocation',
									'scanQRCode'
								];
				config.debug = true;
				config.appId = share_data.appId;
				config.timestamp = share_data.timestamp;
				config.nonceStr = share_data.nonceStr;
				config.signature = share_data.signature
				config.jsApiList = jsApiList;


				/*{
					debug: true,
					appId: '<?php echo $share_data['appId'] ?>',
					timestamp: '<?php echo $share_data['timestamp'] ?>',
					nonceStr: '<?php echo $share_data['nonceStr'] ?>',
					signature: '<?php echo $share_data['signature'] ?>',
					jsApiList: [
							'checkJsApi',
							'onMenuShareTimeline',
							'onMenuShareAppMessage',
							'onMenuShareQQ',
							'onMenuShareWeibo',
							'openLocation',
							'getLocation',
							'addCard',
							'chooseCard',
							'openCard',
							'hideMenuItems',
							'getLocation',
							'scanQRCode'
						]
					}*/
				wx.config(config);
				alert(config.appId);

				wx.ready(function () {
					var shareObj = {    // 分享参数
                            title: "拼团购 - ",
                            desc: "拼团购 - ",
                            //link: data.err_msg.share_data.url + "#/detailinfo/9/1/23/0"+,
                            link: "http://dd2.pigcms.com/webapp/groupbuy/#/detailinfo/35/1/100/0",
                            imgUrl: "http://dd2.pigcms.com/upload/images/000/000/033/201603/56dff2268eb69.jpg"
                        };
					  // 2. 分享接口
					  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
						wx.onMenuShareAppMessage({
							title: shareObj.title,
							desc: shareObj.desc,
							link: shareObj.link,
							imgUrl: shareObj.imgUrl,
							type: '', // 分享类型,music、video或link，不填默认为link
							dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
							uid: 1,
							store_id: 1,
							data_id: 1,
							types: "",
							success: function () { 
								
							},
							cancel: function () { 
								//alert('分享朋友失败');
							},
							trigger: function () {
								
							}
						});


					  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
						wx.onMenuShareTimeline({
							title: shareObj.title,
							desc: shareObj.desc,
							link: shareObj.link,
							imgUrl: shareObj.imgUrl,
							type: '', // 分享类型,music、video或link，不填默认为link
							dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
							uid: 1,
							store_id: 1,
							data_id: 1,
							types: "",
							success: function () {
								
							},
							cancel: function () { 

							},
							trigger: function () {
							}
						});

					  // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
						wx.onMenuShareWeibo({
							title: shareObj.title,
							desc: shareObj.desc,
							link: shareObj.link,
							imgUrl: shareObj.imgUrl,
							type: '', // 分享类型,music、video或link，不填默认为link
							dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
							uid: 1,
							store_id: 1,
							data_id: 1,
							types: "",
						    success: function () {
						    },
						    cancel: function () { 
						        //alert('分享微博失败');
						    },
						    trigger: function () {
							}
						});
						wx.error(function (res) {
							alert('aaa');
						});
					});
			});
		});
		</script>
	</head>
	<body>
	appId: '<?php echo $share_data['appId'] ?>',
			timestamp: '<?php echo $share_data['timestamp'] ?>',
			nonceStr: '<?php echo $share_data['nonceStr'] ?>',
			signature: '<?php echo $share_data['signature'] ?>',
	</body>
</html>
