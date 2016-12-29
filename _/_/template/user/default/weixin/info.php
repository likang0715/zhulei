<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>公众号信息 - <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/sendall.css" rel="stylesheet" type="text/css"/>
	</head>
	<body class="font14 usercenter">
		<?php include display('public:first_sidebar');?>
        <?php include display('sidebar');?>
		<!-- ▼ Container-->
        <div id="container" class="clearfix container right-sidebar">
            <div id="container-left">
                <!-- ▼ Third Header -->
                <div id="third-header">
                    <ul class="third-header-inner">
				        <li>
							<a href="javascript:;">公众号信息</a>
						</li>
                    </ul>
                </div>
                <!-- ▲ Third Header -->
                <!-- ▼ Container App -->
                <div class="container-app">
					<div class="app-inner clearfix">
						<div class="app-init-container">
							<div class="nav-wrapper--app"></div>
							<div class="app__content page-setting-weixin">
								<div class="control-group">
									<div class="controls info-pane">
										<p>如果您的公众号已修改类型，请在微信公众平台取消授权后再进行授权！</p>
									</div>
								</div>
								<div>
									<form class="form-horizontal weixin-form" action="javascript:void(0);">
									<div class="wx-qrcode-wrap">
										<img class="wx-qrcode" src="<?php echo ($weixin_bind['qrcode_url']) ? $weixin_bind['qrcode_url'] : 'http://open.weixin.qq.com/qr/code/?username='.$weixin_bind['alias'];?>"/>					
										<div style="width:100%;height:30px;">
											<div style="float:left;" class="upload_qrcode"><i>+</i>上传二维码</div>
											<div style="float:right;"><input class="btn btn-primary btn-add" type="submit" value="保存"></div>
										</div>
										<input type="hidden" name="qrcode_url" class="qrcode_url" value="<?php echo ($weixin_bind['qrcode_url']) ? $weixin_bind['qrcode_url'] : 'http://open.weixin.qq.com/qr/code/?username='.$weixin_bind['alias'];?>">	
									</div>
									
										<div class="control-group">
											<label class="control-label" for="mp-weixin">公众微信号：</label>
											<div class="controls">
												<div class="control-action"><?php echo ($weixin_bind['alias'] ? $weixin_bind['alias'] : $weixin_bind['user_name']);?></div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="mp-nickname">公众号昵称：</label>
											<div class="controls">
												<div class="control-action"><?php echo $weixin_bind['nick_name'];?></div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="mp-nickname">微信账号类型：</label>
											<div class="controls">
												<div class="control-action"><?php echo $weixin_bind['service_type_txt'];?></div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="mp-nickname">引导关注地址：</label>
											<div class="controls">
												<div class="control-action">
													<input type="text" name="hurl" class="hurl" value="<?php //echo $weixin_bind['hurl'];?>">
													<a href="javascript:void(0);" class="instructions" style="color:#07d;"><u>点击查看如何配置</u></a>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<script>
			$(function(){
				$('.upload_qrcode').live('click',function(){
					upload_pic_box(1,true,function(pic_list){
						var pic 	= pic_list.pop();
						$('.wx-qrcode-wrap .wx-qrcode').attr('src',pic);
						$('.wx-qrcode-wrap .qrcode_url').val(pic);
					},1);
				});
				$('.weixin-form').submit(function(){
					var hurl 	= $('.hurl').val();
					var qrcode_url  = $('.qrcode_url').val();
					
					var lastDotIndex = hurl.lastIndexOf('.');
					if(hurl.substr(0,7)!= 'http://' && hurl.substr(0,8)!= 'https://' && lastDotIndex == -1){
						layer_tips(1, "请填写正确的网址");
						return false;
					}

					if(qrcode_url.length < 1){
						layer_tips(1, "请上传公众号二维码");
						return false;
					}
					
					$.post('./user.php?c=weixin&a=save_info',{'hurl':hurl,'qrcode_url':qrcode_url},function(result){
						if(result.err_code){
							layer_tips(1, result.err_msg);
						}else{
							layer_tips(0, result.err_msg);
						}
					});
				});
				
				$(".instructions").live("click",function(){
					$.layer({
						type: 2,
						shadeClose: true,
						title: false,
						closeBtn: [0, '#000'],
						shade: [0.8, '#000'],
						border: [0],
						offset: ['30px',''],
						area: ['800px', ($(window).height() - 150) +'px'],
						iframe: {src: '<?php dourl('weixin:instructions');?>'}
					}); 
				})
			});
		
		</script>
	</body>
</html>