<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<style type="text/css">
			#is_ok{display:block;width:150px;height:30px;line-height:30px;border:1px solid #ccc;background:#006cc9;color:#fff;border-radius:4px;margin:0 auto;text-decoration: initial;}
		</style>
	</head>
	<body>
		<p style="<?php if(empty($_GET['mt'])){ ?>margin-top:50px;<?php } ?>margin-bottom:0px;text-align:center;">请使用微信扫描二维码绑定</p>
		<p style="text-align:center;"><img src="<?php echo $ticket;?>" style="width:260px;height:260px;background:url('<?php echo STATIC_URL;?>images/lightbox-ico-loading.gif') no-repeat center"/></p>
		<p style="margin-top:20px;text-align:center;font-size:14px;"><a href="javascript:void(0);" id="is_ok">确认绑定成功</a></p>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script>
			$(function(){
				$('#is_ok').click(function(){
					window.parent.location.reload();
				});
			});
		</script>
	</body>
</html>