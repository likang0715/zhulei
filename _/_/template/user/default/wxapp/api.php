<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>应用营销 - <?php echo $store_session['name'];?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
        <meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/wx_sidebar.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_ucenter.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/store_wei_page_category.css" type="text/css" rel="stylesheet"/>
		
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>

		<?php include display('public:custom_header');?>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>

	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('public:yx_sidebar');?>
			<div class="app">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<div class="app__content js-app-main">
							<div class="clearfix"></div>
							<div class="nav-wrapper--app"></div>
							<script type="text/javascript" language="javascript">

							    function iFrameHeight() {
							
							        var ifm= document.getElementById("iframepage");

						            if(ifm != null) {
						            	ifm.height=$(document).height();
						            }

							    }

							    function actOrderHref() {
							    	window.location.href= "<?php dourl('order:activity'); ?>";
							    }
							    
								$(document).ready(function(){ 
							
								});
								$(window).resize(function(){
								   iFrameHeight();
								});
							</script> 
							<iframe style="min-height:1550px;" marginheight="0" marginwidth="0" frameborder="0" width="100%" id="iframepage" name="iframepage" class="wt" onLoad='iFrameHeight()' src="<?php echo $synUrl;?>"></iframe>					
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>