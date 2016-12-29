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
		<style type="text/css">
			.c-gray {
				color: #999;
			}
			.table-list tfoot tr {
				height: 40px;
			}
			.green {
				color: green;
			}
			a, a:hover{
				text-decoration: none;
			}
			.click_show{color: #498CD0;}
		</style>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="<?php echo U('Ng_word/index');?>" class="on">敏感词列表</a>|
					<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Ng_word/add');?>','添加商城TAG',680,310,true,false,false,addbtn,'add',true);">添加敏感词</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="<?php echo U('Tag/index');?>" method="get">
							<input type="hidden" name="c" value="Property"/>
							<input type="hidden" name="a" value="property"/>
						</form>
					</td>
				</tr>
			</table>

			<div class="table-list">
				<table width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>编号</th>
							<th>敏感词</th>
							<th>替换</th>
							<th class="textcenter" width="100">操作</th>
						</tr>
					</thead>
					<tbody>
						<?php  if (count($ng_word_list) > 0) { foreach ($ng_word_list as $ng_word) { ?>
								<tr class="propertys_tr">
									<td><?php echo $ng_word['id'] ?></td>
									<td><?php echo htmlspecialchars($ng_word['ng_word']) ?></td>
									<td><?php echo htmlspecialchars($ng_word['replace_word']) ?></td>
									<td class="end_td">
										<a href="javascript:" onclick="window.top.artiframe('<?php echo U('Ng_word/edit', array('id' => $ng_word['id']));?>', '编辑敏感词',400,200,true,false,false,false,'add',true);">修改</a>
										<a href="javascript:" url="<?php echo U('Ng_word/delete', array('id' => $ng_word['id'])) ?>" class="delete_row">删除</a>
									</td>
								</tr>
						<?php  } } ?>
					</tbody>
					<tfoot>
						<?php if(is_array($ng_word_list)): ?><tr>
							<td class="textcenter pagebar" colspan="7"><?php echo ($page); ?></td>
						</tr>
						<?php else: ?>
						<tr><td class="textcenter red" colspan="7">列表为空！</td></tr><?php endif; ?>
					</tfoot>
				</table>
			</div>
		</div>

<style>
.select-property-tr{  background-color:#3a6ea5;  }
.table-list  .select-property-tr td{padding-left:0px;}
.select-property td{border-top:3px solid #CC5522;background:#e2d7ea}
.select-property .first_td{border-left:3px solid #cc5522}
.select-property .end_td{border-right:3px solid #cc5522}
.property_value th,.property_value td{text-align: center}
.table-list .property_value  tbody td{float:none;text-align: center}
</style>
	</body>
</html>