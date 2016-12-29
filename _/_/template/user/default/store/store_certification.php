<style type="text/css">
	.ui-table tr:nth-child(2n) { background-color: #fafafa; }

	.control-group label.error { float: right; color: #f66; margin-top: 5px; }
	.control-group .controls { position: relative; }
	.page-showcase-dashboard .block-help { top: 16px; right: -20px; position: absolute; }
	.form-horizontal .controls { margin-left: 190px; margin-right: 30px; }
	.ui-form .control-label { font-size: 14px; width: 170px; border-right: 1px solid #ccc; padding: 16px 20px 16px 0; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
	.ui-form .controls { border-left: none; }
	.popover { margin: 0 0 0 -110px; }
	.config_upload_image_btn .button { margin-left: 0px; margin-right: 5px; background: #6c6; color: #fff; padding: 5px;} 
	.config_upload_image_btn .button:hover { background: #6b6; } 
</style>

<nav class="ui-nav">
	<ul>
		<li id="js-nav-list-index" class="active"> 
			<a href="#list">店铺认证信息
			<?php if($store_info['approve']==2){?>
				(<span style="color:orange">认证中</span>)
			<?php }else if($store_info['approve']==3){ ?>
				(<span style="color:red">认证不通过，请重新上传认证</span>)
			<?php }else if($store_info['approve']==1){ ?>
				(<span style="color:green">认证通过</span>)<span class="change_certification" style="color:red;margin-left: 20px;">变更认证信息</span>
			<?php }else{ ?>
				(<span style="color:red">未认证</span>)
			<?php } ?>
			</a>
		</li>
	</ul>
</nav>

<div class="widget-list">
	<?php if (($store_info['approve'] == 0) || ($store_info['approve'] == 3) || empty($certification_info)) { ?>
		<!-- 填写 form -->
		<form id="myform" class="ui-form form-horizontal" refresh="true" action="<?php dourl('certification');?>" method="post">

			<?php foreach ($diy_list as $key => $val) { ?>
			<div class="control-group">
				<label class="control-label" title="<?php echo $val['info'] ?>"><em class="required">*</em><?php echo $val['info'] ?></label>
				<div class="controls">
				<?php

					$li_html = '';
					if ($val['config_type'] == 'text') {

						$size = !empty($type_arr['size']) ? $type_arr['size'] : '60';
						$li_html = "<input type=text name='" . $val['name'] . "' id=config_'" . $val['name']."' value='" . $val['value'] . "' size='" . $size . "' validate='" . $val['validate'] . "' tips='" . $val['desc'] . "'>";

					} else if ($val['config_type'] == 'image') {

						$li_html = '<span class="config_upload_image_btn">
								<input type="button" value="上传图片" class="button"/>
							</span>
							<input type="text" class="input-text input-image" name="' . $val['name'] . '" id="config_' . $val['name'] . '" value="' . $val['value'] . '" size="48" validate="' . $val['validate'] . '" tips="' . $val['desc'] . '"/> ';

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
			<?php } ?>

			<div style="margin-top:20px;" class="btn">
                <input type="hidden"  value="<?php echo $supplier_id; ?>" name="supplier_id"/>
				<input type="submit" class="button" value="提交" style=" background:none; color:#fff">
			</div>

		</form>
	<?php } else { ?>
		<!-- 展示 -->
		<table class="ui-table ui-table-list">
            <tbody class="js-list-body-region">
            <?php if ($certification_info) { foreach ($certification_info as $k => $v) { ?>
            <tr class="widget-list-item">
                <td style="width: 200px; border-right: 1px solid #ccc;"><?php echo $k;?>:</td>
                <td>
					<div class="show">
					<?php if (strpos($v,'images') !== false) { ?>
						<a href="<?php echo getAttachmentUrl($v); ?>" target="_blank">
							<img src="<?php echo getAttachmentUrl($v); ?>" width="120" height="120" />
						</a>
					<?php } else {
						echo $v;
					} ?>
					</div>
				</td>
            </tr>
            <?php } } ?>
            </tbody>
        </table>
		<script type="text/javascript">
			$('input,select').attr('disabled','disabled');
		</script>
	<?php } ?>
</div>

<script type="text/javascript">

	$(function() {
	 	$("#myform").validate();

	 	$('.js-help-notes').hover(function(){

			$('.popover-help-notes').remove();
			var htmls = $(this).closest(".block-help").find(".js-notes-cont").html();
			var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 20) + 'px; left: ' + ($(this).offset().left - 140) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content">'+htmls+'</div></div></div>';

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