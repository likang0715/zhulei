<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新活动功能库</title>
<meta http-equiv="MSThemeCompatible" content="Yes" />
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
<script src="<?php echo STATIC_URL;?>js/layer/layer.min.js" type="text/javascript"></script>
<link href="<?php echo TPL_URL;?>css/link_style_2_common.css?BPm" rel="stylesheet" type="text/css" />
<link href="<?php echo TPL_URL;?>css/link_style.css" rel="stylesheet" type="text/css" />
<style>
body{line-height:180%;}
ul.modules {float:left;	width:33%;}
ul.modules li{padding:4px;margin:4px;background:#efefef;float:left;width:92%;}
ul.modules li div.mleft{float:left;width:40%}
ul.modules li div.mright{float:right;width:55%;text-align:right;}
ul.modules li.first {font-weight:bold;background:#D4D4D4;color:#fff}
</style>
</head>
<body style="background:#fff;padding:20px 20px;">
<div style="background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;margin-bottom:5px;">使用方法：点击“选中”直接返回对应模块外链代码，或者点击“详细”选择具体的内容外链</div>
<h4>请选择模块：</h4>

<?php $i=0;?>
<?php foreach($data as $key=>$m){?>

<?php if($i%6==0) {?>
<ul class="modules">
<?php }?>

		<?php $i++;?>
		<li class="first"><?php echo $key;?></li>

		<?php 
			if(is_array($m)) {
				foreach($m as $k1=>$m1) {
					$i++;
		?>
		
		<li>
			<div class="mleft"><?php echo $m1['name'];?></div>
			<div class="mright">
                <?php if($m1['select']=='url'){ ?>
				<a href="javascript:void(0)" onclick="returnHomepage('<?php echo $m1['url']; ?>')" style="margin-left:14px;">选中</a>
                <?php }else{ ?>
                <a href="<?php echo $m1['url']; ?>" style="margin-left:14px;">详情</a>
                <?php } ?>
			</div>
			<div style="clear:both"></div>
		</li>
		<?php 
				}
			}
		?>
	

	<div style="clear:both"></div>

<?php if(  ($i%6==0)  || (in_array($i,array(6,12,18))) ) {?>	
</ul>
<?php }?>
<?php }?>



<script>
	function returnHomepage(url){
		$('.js-link-placeholder', parent.document).val(url).keyup();
		parent.layer.close(parent.layer.getFrameIndex(window.name));
	}
</script>
</body>
</html>