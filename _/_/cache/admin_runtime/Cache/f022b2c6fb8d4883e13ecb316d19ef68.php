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
	<style>
		.table-list tfoot tr {
			height: 40px;
		}
	</style>
	<script type="text/javascript">
		$(function(){
			var activityModel = '<?php echo $activity_type; ?>';
			$('.choice-all').live('click', function(){
				if ($(this).is(':checked')) {
					$('.choice').attr('checked', true);
					$('.disabled').attr('checked', false);
				} else {
					$('.choice').attr('checked', false);
				}
			})
			$('.label-choice-all').live('click', function(){
				$('.choice-all').attr('checked', true);
				$('.choice').attr('checked', true);
				$('.disabled').attr('checked', false);
			})

			$('.label-choice-cancel').live('click', function(){
				$('.choice-all').attr('checked', false);
				$('.choice').attr('checked', false);
			})
			$('.activityRecommend').click(function(){
				var id_str = "";
				$(".choice").each(function() {
					if ($(this).prop("checked")) {
						id_str += "," + $(this).val();
					}
				});
				
				if (id_str.length == 0) {
					window.top.msg(0, '请选择要推荐的活动');
					window.top.closeiframe();
					return;
				}
				
				$.post('?c=Store&a=game', {id_str: id_str, model: activityModel}, function(re) {
					if(re.status == 1){
						window.top.msg(1, re.msg);
					} else if (re.status == 2) {
						window.top.msg(0, re.msg);
					}
					window.top.closeiframe();
				},'json');
				return false;
			});
		})
	</script>
	<div class="mainbox">
		<div id="nav" class="mainnav_title">
			<ul>
				<a href="<?php echo U('Store/game');?>" class="on">店铺游戏活动列表</a>
			</ul>
		</div>
		<table class="search_table" width="100%">
			<tr>
				<td>
					<form action="<?php echo U('Store/game');?>" method="get">
						<input type="hidden" name="c" value="Store"/>
						<input type="hidden" name="a" value="game"/>
						筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>" />
						<select name="type">
							<option value="store_id" <?php if($_GET['type'] == 'store_id'): ?>selected="selected"<?php endif; ?>>店铺编号</option>
							<option value="name" <?php if($_GET['type'] == 'name'): ?>selected="selected"<?php endif; ?>>店铺名称</option>
							<option value="tel" <?php if($_GET['type'] == 'tel'): ?>selected="selected"<?php endif; ?>>联系电话</option>
						</select>
						&nbsp;&nbsp;活动类型：
						<select name="activity_type">
							<?php foreach($activity_type_arr as $key=>$val){ ?>
								<option <?php if($activity_type == $key): ?>selected="selected"<?php endif; ?> value="<?php echo ($key); ?>"><?php echo ($val); ?></option>
							<?php } ?>
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
						<th>标题</th>
						<th>活动类型</th>
						<th>所属店铺</th>
						<th>活动时间</th>
						<th>封面图</th>
						<th>活动状态</th>
					</tr>
				</thead>
				<tbody>
					<?php  if (is_array($activity_list)) { foreach ($activity_list as $activity) { ?>
							<tr>
								<td><?php echo $activity['name']; ?></td>
								<td><?php echo $activity_type_arr[$activity_type]; ?></td>
								<td><?php echo $activity['s_name']; ?></td>
								<td><?php echo $activity['time']; ?></td>
								<td><img src="<?php echo $activity['image']; ?>" width="60" class="view_msg"></td>
								<td><?php echo $activity['status_txt']; ?></td>
							</tr>
					<?php  } } ?>
				</tbody>
				
				<tfoot>
					<?php  if ($activity_list) { ?>
						<tr>
							<td class="pagebar" colspan="6">
								<div>
									<div style="float: right">
										<?php echo ($page); ?>
									</div>
								</div>
							</td>
						</tr>
					<?php  } else { ?>
						<tr><td class="textcenter red" colspan="7">列表为空！</td></tr>
					<?php  } ?>
				</tfoot>
			</table>
		</div>
	</div>
	<script type="text/template" id="activity-tmpl">
		<?php echo (json_encode($activityList)); ?>
	</script>
	</body>
</html>