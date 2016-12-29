<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="cleartype" content="on"/>
	<title>页面跳转中</title>
	<script src="<?php echo TPL_URL;?>courier_style/js/jquery-1.7.2.js"></script>
</head>
<body>
<script type="text/javascript">
$(function(){
	window.parent.actOrderHref();
})
</script>
</body>
</html>