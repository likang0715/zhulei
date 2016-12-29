<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<?php if($isAutoGo){echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";}?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	font-size: 12px;
	color: #666666;
	width:60%;
	margin:140px auto 0px;
	border-radius: 10px;
	padding:30px 10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
	font-size:16px;
}
.main p a{
	text-decoration:none;
}
.copyright{
	text-align:center;
	margin-top:200px;
}
.copyright a{
	color:#999;
	text-decoration:none;
}
-->
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
<div class="main">
<p><?php echo $msg;?></p>
<?php if($url != 'none') echo '<p style="margin-top:20px;"><a href="'.$url.'">&laquo;点击跳转</a></p>';?>
</div>
<?php //if(option('config.site_url')){ ?>
	<!-- <div class="copyright">
		<a href="<?php //echo option('config.site_url'); ?>" target="_blank">
			<i>©</i> <?php //echo getUrlTopDomain(option('config.site_url')); ?>
		</a>
	</div> -->
<?php //} ?>
</body>
</html>