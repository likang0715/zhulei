<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
	<body>
		<div class="login" id="wxdl">
		<p style="<?php if(empty($_GET['mt'])){ ?>margin-top:50px;<?php } ?>margin-bottom:0px;text-align:center;">请扫描二维码后再注册</p>
		<p style="text-align:center;"><img src="<?php echo $ticket;?>" style="width:260px;height:260px;background:url('<?php echo STATIC_URL;?>images/lightbox-ico-loading.gif') no-repeat center"/></p>
		<p id="login_status" style="margin-top:20px;display:none;text-align:center;font-size:14px;"></p>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<link href="<?php echo TPL_URL;?>css/login.css" type="text/css" rel="stylesheet">
		<script>
			<?php if($_GET['referer']){ ?>var redirect_url = "<?php echo str_replace('&amp;', '&', htmlspecialchars_decode($_GET['referer']));?>";<?php }else{ ?>var redirect_url = window.top.location.href;<?php } ?>
			window.setTimeout(function(){
				window.location.href = window.location.href;
			},1200000);
			window.setTimeout(function(){
				ajax_weixin_sub();
			},3000);
			function ajax_weixin_sub(){
				$.get("<?php dourl('index:wxlogin:ajax_weixin_subscribe');?>",{qrcode_id:<?php echo $id;?>},function(result){
					if(result == 'to_reg') {
						$('#login_status').html('你已成功关注，赶紧注册吧').css('color','green').show();
						window.setTimeout(function(){
							$('.form_register', window.parent.document).show();
							$('iframe', window.parent.document).hide();
						},1500);
					} else if(result == 'waiting') {
						ajax_weixin_sub();
					}
				});
			}
		</script>
		</div>

		<script>
		$(".zh").click(function(){
			$(".login").hide();
			$("#zhdl").show();		
			
		})
		$("#wx_login").click(function(){
			$(".login").hide();
			$("#wxdl").show();				
			
		})
		</script>
	</body>
</html>