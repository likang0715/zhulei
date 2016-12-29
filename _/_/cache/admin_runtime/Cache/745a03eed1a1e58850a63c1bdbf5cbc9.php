<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
			<?php if($withdrawal_count > 0): ?><script type="text/javascript">
					$(function(){
						$('#nav_4 > dd > #leftmenu_Order_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
					})
				</script><?php endif; ?>
			<?php if($unprocessed > 0): ?><script type="text/javascript">
					$(function(){
						if ($('#leftmenu_Credit_returnRecord', parent.document).length > 0) {
							var menu_html = $('#leftmenu_Credit_returnRecord', parent.document).html();
							menu_html = menu_html.split('(')[0];
							menu_html += ' <label style="color:red">(<?php echo ($unprocessed); ?>)</label>';
							$('#leftmenu_Credit_returnRecord', parent.document).html(menu_html);
						}
					})
				</script><?php endif; ?>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
>         <style type="text/css">            .c-gray {                color: #999;            }            .table-list tfoot tr {                height: 40px;            }            .green {                color: green;            }            a, a:hover{                text-decoration: none;            }        </style><script type="text/javascript">	$(function() {		$('.status-enable > .cb-enable').click(function(){			if (!$(this).hasClass('selected') ) {				var url = window.location.href;				var vid = $(this).data('id');				$.post("<?php echo U('Product_property/propertyvalue_status'); ?>",{'status': 1, 'vid': vid}, function(data){					window.location.href = url;				})			}			if (parseFloat($(this).data('status')) == 0) {				$(this).removeClass('selected');			}			return false;		})		$('.status-disable > .cb-disable').click(function(){			if (!$(this).hasClass('selected') && parseFloat($(this).data('status')) == 1) {				var url = window.location.href;				var vid = $(this).data('id');				if (!$(this).hasClass('selected')) {					$.post("<?php echo U('Product_property/propertyvalue_status'); ?>", {'status': 0, 'vid': vid}, function (data) {						window.location.href = url;					})				}			}			return false;		})	})</script>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="<?php echo U('Product_property/propertyValue');?>" class="on">商品属性值列表</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td>						<form action="<?php echo U('Product_property/propertyValue');?>" method="get">							<input type="hidden" name="c" value="Property"/>							<input type="hidden" name="a" value="property"/>                            						</form>					</td>				</tr>			</table>            <div class="table-list">                <table width="100%" cellspacing="0">                    <thead>                        <tr>                            <th>删除 | 修改</th>                            <th>编号</th>	                        <th>属性</th>                            <th>属性值</th>                           <!-- <th>状态</th>                            <th class="textcenter" width="100">操作</th>-->                        </tr>                    </thead>                    <tbody>                        <?php if(is_array($propertyValues)): if(is_array($propertyValues)): $i = 0; $__LIST__ = $propertyValues;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$propertyValue): $mod = ($i % 2 );++$i;?><tr>                                    <td><a url="<?php echo U('Product_property/propertyValue_del', array('vid' => $propertyValue['vid'])); ?>"  class="delete_row"><img src="<?php echo ($static_path); ?>images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product_property/propertyValue_edit', array('vid' => $propertyValue['vid']));?>','修改商品属性值 - <?php echo ($property["name"]); ?>',480,<?php if($property['cat_pic']): ?>390<?php else: ?>310<?php endif; ?>,true,false,false,editbtn,'edit',true);"><img src="<?php echo ($static_path); ?>images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>                                    <td><?php echo ($propertyValue["vid"]); ?></td>                                          <td><a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product_property/property_edit', array('pid' => $propertyValue['pid']));?>','修改属性值 - <?php echo ($propertyValue["name"]); ?>',480,<?php if($property['name']): ?>390<?php else: ?>310<?php endif; ?>,true,false,false,editbtn,'edit',true);"><?php if ($property['cat_level'] > 1){ echo str_repeat('|——', $property['cat_level']); } ?> <span <?php if ($property['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>><?php echo ($propertyValue["name"]); ?></span></a></td>                                          <td><a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product_property/propertyValue_edit', array('pid' => $propertyValue['vid']));?>','修改属性值 - <?php echo ($propertyValue["value"]); ?>',480,<?php if($property['name']): ?>390<?php else: ?>310<?php endif; ?>,true,false,false,editbtn,'edit',true);"><?php if ($property['cat_level'] > 1){ echo str_repeat('|——', $property['cat_level']); } ?> <span <?php if ($property['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>><?php echo ($propertyValue["value"]); ?></span></a></td>									<!--                                    <td>                                        <?php if($propertyValue['status'] == 1): ?><span class="green">启用</span><?php else: ?><span class="red">禁用</span><?php endif; ?>                                    </td>                                    <td>                                        <span class="cb-enable status-enable" data-id="<?php echo $propertyValue['vid']; ?>" ><label class="cb-enable <?php if($propertyValue['status'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $propertyValue['vid']; ?>" data-status="<?php echo ($propertyValue["status"]); ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($propertyValue['status'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>                                        <span class="cb-disable status-disable" data-id="<?php echo $propertyValue['vid']; ?>"><label class="cb-disable <?php if($propertyValue['status'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $propertyValue['vid']; ?>"data-status="<?php echo ($propertyValue["status"]); ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($propertyValue['status'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>                                    </td>									-->                                </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>                    </tbody>                    <tfoot>                        <?php if(is_array($propertyValues)): ?><tr>                            <td class="textcenter pagebar" colspan="7"><?php echo ($page); ?></td>                        </tr>                        <?php else: ?>                        <tr><td class="textcenter red" colspan="7">列表为空！</td></tr><?php endif; ?>                    </tfoot>                </table>            </div>		</div>	</body>
</html>