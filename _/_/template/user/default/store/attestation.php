<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta name="renderer" content="webkit">
		<title id="js-meta-title">认证店铺 | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		 <link rel="icon" href="./favicon.ico" />
		<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/base.css" />
		<link rel="stylesheet" href="<?php echo TPL_URL; ?>css/app_team.css" />
		<link rel="stylesheet" href="<?php echo STATIC_URL;?>kindeditor/themes/default/default.css">
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>/js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script src="<?php echo STATIC_URL;?>/kindeditor/kindeditor.js"></script>
		<script src="<?php echo STATIC_URL;?>kindeditor/lang/zh_CN.js"></script>
			<script type="text/javascript" src="<?php echo TPL_URL; ?>/js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL; ?>js/store_attestation.js"></script>
		<style>
		.config_upload_image_btn .button {margin-left: 0px; margin-right: 5px; background: #6c6; color: #fff; padding: 5px;}
		.block-help > a {
    display: inline-block;
    width: 16px;
    height: 16px;
    line-height: 18px;
    border-radius: 8px;
    font-size: 12px;
    text-align: center;
    background: #bbb;
    color: #fff;}
    .block-help > a:after {content:'?'}
    .block-help > a:hover {
    	background-color: #6c6;
    	color:#fff
    }
    
    .control-group .controls .error { display:inline-block; margin-right: 10px; }
    .control-group .controls input { margin-right: 10px }
    
    .popover.bottom .arrow {
    top: 0;
    left: 90%;
    margin-left: -5px;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-bottom: 5px solid #000;
}
.popover-inner {
    padding: 3px;
    width: 260px;
    overflow: hidden;
    background: #000;
    background: rgba(0, 0, 0, 0.8);
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    border-radius: 6px;
    -webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
		</style>
	</head>
	<body>
		<div id="hd" class="wrap rel">
			<div class="wrap_1000 clearfix">
				<h1 id="hd_logo" class="abs" title="<?php echo $config['site_name'];?>">
					<?php if($config['pc_shopercenter_logo'] != ''){?>
						<a href="<?php dourl('store:select');?>">
							<img src="<?php echo $config['pc_shopercenter_logo'];?>" height="35" alt="<?php echo $config['site_name'];?>" style="height:35px;width:auto;max-width:none;"/>
						</a>
					<?php }?>
				</h1>
				<h2 class="tc hd_title">认证店铺</h2>
			</div>
		</div>
		<div class="container wrap_800" style="margin-top:60px;">
			<div class="content">
				<div class="app">
					<div class="app-init-container">
						<div class="team">
							<div class="wrapper-app">
								<div id="content" class="team-edit-create-shop page-showcase-dashboard">
									<div>
										<form class="form-horizontal" id="myform" action="" method="post">
											<fieldset>
												<?php 
												foreach ($diy_list as $val) {
												?>
													<div class="control-group">
														<label class="control-label"><em class="required">*</em><?php echo htmlspecialchars($val['info']); ?>：</label>
														<div class="controls">
															<?php
															$li_html = '';
															if ($val['config_type'] == 'text') {
																$size = !empty($type_arr['size']) ? $type_arr['size'] : '60';
																$li_html = "<input type=text name='" . $val['name'] . "' id=config_'" . $val['name']."' value='" . $val['value'] . "' size='" . $size . "' validate='" . $val['validate'] . "' tips='" . $val['desc'] . "'>";
															} else if ($val['config_type'] == 'image') {
																$li_html = '<span class="config_upload_image_btn">
																		<input type="button" value="上传图片" class="button"/>
																	</span> <input type="text" class="input-text input-image" style="width:230px;" name="' . $val['name'] . '" id="config_' . $val['name'] . '" value="' . $val['value'] . '" size="48" validate="' . $val['validate'] . '" tips="' . $val['desc'] . '"/> ';
										
															} else if ($val['config_type'] == 'select') {
										
																$radio_option = explode('|', $val['config']['value']);
																$li_html = '<select name="' . $val['name'] . '">';
																foreach ($radio_option as $radio_k => $radio_v) {
																	$radio_one = explode(':', $radio_v);
																	$li_html .= '<option value="' . $radio_one[0] . '" ' . ($val['value'] == $radio_one[0] ? 'selected="selected"' : '') . '>' . $radio_one[1] . '</option>';
																}
																$li_html .= '</select>';
																
															}
															$li_html .= '<span class="block-help"><a href="javascript:void(0);" class="js-help-notes"></a><div class="js-notes-cont hide"><p> '.$val['desc'].'</p> </div> </span>';
															echo $li_html;
															?>
														</div>
													</div>
													
												<?php 
												}
												?>
												<div class="controls">
													<button class="btn btn-large btn-primary submit-btn" type="submit">认证店铺</button>
												</div>
											</fieldset>
										</form>
									</div>
								</div>
								<div id="content-addition"></div>
							</div>
							<?php $show_footer_link = false; include display('public:footer');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
	$(function() {
		<?php 
		if ($error_message) {
			echo 'layer_tips(1, "' . $error_message . '");';
		}
		?>
		$("#myform").validate();

		$('.js-help-notes').hover(function(){
			$('.popover-help-notes').remove();
			var htmls = $(this).closest(".block-help").find(".js-notes-cont").html();
			var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 20) + 'px; left: ' + ($(this).offset().left - 240) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">'+htmls+'</div></div></div>';
			$('body').append(html);
			$('.popover-help-notes').show();
		}, function(){
			t = setTimeout(function(){
				$('.popover-help-notes').remove();
			}, 200);
		});

		$('.popover-help-notes').live('mouseleave', function(){
			clearTimeout(t);
			$('.popover-help-notes').remove();
		})

		$('.popover-help-notes').live('mouseover', function(){
			clearTimeout(t);
		})
	});

	KindEditor.ready(function(K){
		var site_url = "<?php echo option('config.site_url');?>";
		var editor = K.editor({
			allowFileManager : true
		});
		$('.config_upload_image_btn').click(function(){
			var upload_file_btn = $(this);
			editor.uploadJson = "/user.php?c=Store&a=ajax_upload_pic";
			editor.loadPlugin('image', function(){
				editor.plugin.imageDialog({
					showRemote : false,
					clickFn : function(url, title, width, height, border, align) {
						upload_file_btn.siblings('.input-image').val(site_url+url);
						editor.hideDialog();
					}
				});
			});
		});
		$('.config_upload_file_btn').click(function(){
			var upload_file_btn = $(this);
			editor.uploadJson = "/user.php?c=Store&a=ajax_upload_file&name="+upload_file_btn.siblings('.input-file').attr('name');
			editor.loadPlugin('insertfile', function(){
				editor.plugin.fileDialog({
					showRemote : false,
					clickFn : function(url, title, width, height, border, align) {
						upload_file_btn.siblings('.input-file').val(url);
						editor.hideDialog();
					}
				});
			});
		});
	});

</script>
</html>