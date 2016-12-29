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
> 
<script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>
<style type="text/css">
.c-gray { color: #999; }
.table-list tfoot tr { height: 40px; }
.green { color: green; }
.cursor{cursor:pointer}
a, a:hover { text-decoration: none; }
.input_sort{border-color: #a0a0a0 #cad9ea #cad9ea #a0a0a0;border-width: 1px;font-size: 9pt;height: 18px;padding:2px;}
.input_button{border-radius: 5px;background: #369 none repeat scroll 0 0;border: 2px solid #efefef;color: #fff;cursor: pointer;font-size: 12px;font-weight: 700;height: 26px;line-height: 21px;text-align: center;width: 55px;} 
</style>
<script type="text/javascript">
            $(function() {
                $('.status-enable > .cb-enable').click(function(){
                    if (!$(this).hasClass('selected') && parseFloat($(this).data('status')) == 1) {
                        var url = window.location.href;
                        var cat_id = $(this).data('id');
                        $.post("<?php echo U('Product/category_status'); ?>",{'status': 1, 'cat_id': cat_id}, function(data){
                            window.location.href = url;
                        })
                    }
                    if (parseFloat($(this).data('status')) == 0) {
                        $(this).removeClass('selected');
                    }
                    return false;
                })
                $('.status-disable > .cb-disable').click(function(){
                    if (!$(this).hasClass('selected') && parseFloat($(this).data('status')) == 1) {
                        var url = window.location.href;
                        var cat_id = $(this).data('id');
                        if (!$(this).hasClass('selected')) {
                            $.post("<?php echo U('Product/category_status'); ?>", {'status': 0, 'cat_id': cat_id}, function (data) {
                                window.location.href = url;
                            })
                        }
                    }
                    return false;
                })
				var click_status = true
                $(".input_button").click(function(){
            		var idvalue = "";
            		var pidvalue = "";
					if(click_status) {
						click_status=false;

						$('.cat_ids').each(function() {
							idvalue += $(this).val() + ','
						});
						$('input[name="sorts"]').each(function() {
							pidvalue += $(this).val() + ','
						});
						var valuearray = 'id_str=' + idvalue + '&sort_str=' + pidvalue;
					
						$.layer({
							shade: [0],
							area: ['auto','auto'],
							dialog: {
								msg: '确认批量排序么？',
								btns: 2,                    
								type: 4,
								btn: ['确定','取消'],
								yes: function(){	
									click_status = true;
									$.ajax({
										type: "POST",
										async: false,
										dataType:"json",
										url: "<?php echo U('Product/set_type_sort'); ?>",
										data: valuearray,
										success: function(data) {
											layer.alert(data.msg);
										}
									})
						        }, no: function(){
						        	click_status = true;
						        }
						    }
						});

						
					}
                	
					
                })
            })
        </script>
<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="<?php echo U('Product/category');?>" class="on">商品分类</a>| <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product/category_add');?>','添加分类',600,500,true,false,false,addbtn,'add',true);">添加分类</a>
		</ul>
	</div>
	<table class="search_table" width="100%">
		<tr>
			<td><form action="<?php echo U('Product/category');?>" method="get">
					<input type="hidden" name="c" value="Product"/>
					<input type="hidden" name="a" value="category"/>
					筛选:
					<select name="cat_id">
						<option value="0">商品类目</option>
						<?php if(is_array($all_categories)): $i = 0; $__LIST__ = $all_categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$all_category): $mod = ($i % 2 );++$i;?><option <?php if($_GET['cat_id']== $all_category['cat_id']): ?>selected<?php endif; ?>  value="<?php echo ($all_category['cat_id']); ?>">
							<?php if ($all_category['cat_level'] > 1){ echo str_repeat('&nbsp;&nbsp;', $all_category['cat_level']); } ?>
							 |-- <?php echo ($all_category["cat_name"]); ?>
							</option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
					<input type="submit" value="查询" class="button"/>
				</form>
			</td>
		</tr>
	</table>
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>删除 | 修改</th>
					<th>编号</th>
					<th>名称</th>
					<th>描述</th>
					<th>状态</th>
					<th style="text-align:center">排序 <input class="input_button" type="button" value="排序">
					<img title="商品分类显示规则: 1.按照先排序值升序，再编号升序排列" class="tips_img cursor" src="./source/tp/Project/tpl/Static/images/help.gif">
					</th>
					<th class="textcenter" width="100">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($categories)): ?><!-- <?php if(is_array($categories)): $i = 0; $__LIST__ = $categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><tr>
                                    <td><a url="<?php echo U('Product/category_del', array('id' => $category['cat_id'])); ?>"  class="delete_row"><img src="<?php echo ($static_path); ?>images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product/category_edit', array('id' => $category['cat_id']));?>','修改分类 - <?php echo ($category["cat_name"]); ?>',540,<?php if($category['cat_pic']): ?>500<?php else: ?>500<?php endif; ?>,true,false,false,editbtn,'edit',true);"><img src="<?php echo ($static_path); ?>images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
                                    <td><?php echo ($category["cat_id"]); ?></td>
                                    <td><a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product/category_edit', array('id' => $category['cat_id']));?>','修改分类 - <?php echo ($category["cat_name"]); ?>',540,<?php if($category['cat_pic']): ?>500<?php else: ?>500<?php endif; ?>,true,false,false,editbtn,'edit',true);"><?php if ($category['cat_level'] > 1){ echo str_repeat('|——', $category['cat_level']); } ?> <span <?php if ($category['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>><?php echo ($category["cat_name"]); ?></span></a></td>
                                    <td><?php echo ($category["cat_desc"]); ?></td>
                                    <td>
                                        <?php if($category['cat_status'] == 1): ?><span class="green">启用</span><?php else: ?><span class="red">禁用</span><?php endif; ?>
                                    </td>
                                    <td><?php echo ($category["cat_sort"]); ?>
                                 
                                    </td>
                                    <td>
                                        <span class="cb-enable status-enable"><label class="cb-enable <?php if($category['cat_status'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $category['cat_id']; ?>" data-status="<?php echo ($category["cat_parent_status"]); ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($category['cat_id'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
                                        <span class="cb-disable status-disable"><label class="cb-disable <?php if($category['cat_status'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $category['cat_id']; ?>" data-status="<?php echo ($category["cat_parent_status"]); ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($category['cat_id'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>-->
                            
					<?php if(is_array($categories2)): $i = 0; $__LIST__ = $categories2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$category): $mod = ($i % 2 );++$i;?><tr>
							<td><a url="<?php echo U('Product/category_del', array('id' => $category['cat_id'])); ?>"  class="delete_row"><img src="<?php echo ($static_path); ?>images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product/category_edit', array('id' => $category['cat_id']));?>','修改分类 - <?php echo ($category["cat_name"]); ?>',540,<?php if($category['cat_pic']): ?>500<?php else: ?>500<?php endif; ?>,true,false,false,editbtn,'edit',true);"><img src="<?php echo ($static_path); ?>images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
							<td><?php echo ($category["cat_id"]); ?></td>
							<td><a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product/category_edit', array('id' => $category['cat_id']));?>','修改分类 - <?php echo ($category["cat_name"]); ?>',600,<?php if($category['cat_pic']): ?>500<?php else: ?>500<?php endif; ?>,true,false,false,editbtn,'edit',true);"><?php if ($category['cat_level'] > 1){ echo str_repeat('|——', $category['cat_level']); } ?> <span <?php if ($category['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>><?php echo ($category["cat_name"]); ?></span></a></td>
							<td><?php echo ($category["cat_desc"]); ?></td>
							<td><span class="green"><?php if($category['cat_status'] == 1): ?><span class="green">启用</span><?php else: ?><span class="red">禁用</span><?php endif; ?></span></td>
							<td style="text-align:center">
								<!--  <input style="width:80px;" type="text" value="<?php echo ($category["cat_sort"]); ?>">-->
									<input size=2 maxlength=3 type="text" name="sorts" value="<?php echo ($category["cat_sort"]); ?>" class="input_sort">
									<input type="hidden" class="cat_ids" value="<?php echo ($category["cat_id"]); ?>">
								</td>
							<td>
								<span class="cb-enable status-enable"><label class="cb-enable <?php if($category['cat_status'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $category['cat_id']; ?>" data-status="<?php echo ($category["cat_parent_status"]); ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($category['cat_id'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
								<span class="cb-disable status-disable"><label class="cb-disable <?php if($category['cat_status'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $category['cat_id']; ?>" data-status="<?php echo ($category["cat_parent_status"]); ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($category['cat_id'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
							</td>
						</tr>
						
						<?php if(is_array($category['children'])): $i = 0; $__LIST__ = $category['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><tr>
							<td><a url="<?php echo U('Product/category_del', array('id' => $child['cat_id'])); ?>"  class="delete_row"><img src="<?php echo ($static_path); ?>images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product/category_edit', array('id' => $child['cat_id']));?>','修改分类 - <?php echo ($child["cat_name"]); ?>',540,<?php if($child['cat_pic']): ?>500<?php else: ?>500<?php endif; ?>,true,false,false,editbtn,'edit',true);"><img src="<?php echo ($static_path); ?>images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
							<td><?php echo ($child["cat_id"]); ?></td>
							<td><a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Product/category_edit', array('id' => $child['cat_id']));?>','修改分类 - <?php echo ($child["cat_name"]); ?>',600,<?php if($child['cat_pic']): ?>500<?php else: ?>500<?php endif; ?>,true,false,false,editbtn,'edit',true);"><?php if ($child['cat_level'] > 1){ echo str_repeat('|——', $child['cat_level']); } ?> <span <?php if ($child['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>><?php echo ($child["cat_name"]); ?></span></a></td>
							<td><?php echo ($child["cat_desc"]); ?></td>
							<td><span class="green"><?php if($child['cat_status'] == 1): ?><span class="green">启用</span><?php else: ?><span class="red">禁用</span><?php endif; ?></span></td>
							<td style="text-align:center">
							<input size=2 maxlength=3 type="text" name="sorts" value="<?php echo ($child["cat_sort"]); ?>" class="input_sort">
							<input type="hidden" class="cat_ids" value="<?php echo ($child["cat_id"]); ?>">
							</td>
							
							<td>
								<span class="cb-enable status-enable"><label class="cb-enable <?php if($child['cat_status'] == 1): ?>selected<?php endif; ?>" data-id="<?php echo $child['cat_id']; ?>" data-status="<?php echo ($child["cat_parent_status"]); ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($child['cat_id'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
								<span class="cb-disable status-disable"><label class="cb-disable <?php if($child['cat_status'] == 0): ?>selected<?php endif; ?>" data-id="<?php echo $child['cat_id']; ?>" data-status="<?php echo ($child["cat_parent_status"]); ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($child['cat_id'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; endif; ?>
			</tbody>
			<tfoot>
				<?php if(is_array($categories)): ?><tr>
						<!--  <td class="textcenter pagebar" colspan="7"><?php echo ($page); ?></td>-->
					</tr>
					<?php else: ?>
					<tr>
						<td class="textcenter red" colspan="7">列表为空！</td>
					</tr><?php endif; ?>
			</tfoot>
		</table>
	</div>
</div>
	</body>
</html>