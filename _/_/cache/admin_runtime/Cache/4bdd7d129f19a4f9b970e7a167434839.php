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
			var activityModel = '<?php echo ($selectModel); ?>';
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
					window.top.msg(0, '请选择活动');
					window.top.closeiframe();
					return;
				}
				
				$actType = $(this).attr('actType');
				$.post('?c=Store&a='+$actType, {id_str: id_str} ,function(re){
					if(re.status == 1){
						window.top.msg(1,re.msg);
						window.location.reload();
					}else{
						window.top.msg(0,re.msg);
						window.top.closeiframe();
					}
				},'json');
				return false;
			});
		})
	</script>
	<div class="mainbox">
		<div id="nav" class="mainnav_title">
			<ul>
				<a href="<?php echo U('Store/activityManage');?>" class="on">推荐活动列表</a>
			</ul>
		</div>
		<table class="search_table" width="100%">
			<tr>
				<td>
					<form action="<?php echo U('Store/activityRecommend');?>" method="get">
						<input type="hidden" name="c" value="Store"/>
						<input type="hidden" name="a" value="activityRecommend"/>
						筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>" />
						<select name="type">
							<option value="activity_id" <?php if($_GET['type'] == 'activity_id'): ?>selected="selected"<?php endif; ?>>活动编号</option>
							<option value="activity_name" <?php if($_GET['type'] == 'activity_name'): ?>selected="selected"<?php endif; ?>>活动名称</option>
							<option value="store_id" <?php if($_GET['type'] == 'store_id'): ?>selected="selected"<?php endif; ?>>店铺编号</option>
							<option value="name" <?php if($_GET['type'] == 'name'): ?>selected="selected"<?php endif; ?>>店铺名称</option>
							<option value="tel" <?php if($_GET['type'] == 'tel'): ?>selected="selected"<?php endif; ?>>联系电话</option>
						</select>
						&nbsp;&nbsp;活动类型：
						<select name="activity_type">
							<option value="">全部</option>
							<?php  foreach($activity_type_arr as $key => $val){ ?>
								<option <?php if($_GET['activity_type'] == $key): ?>selected="selected"<?php endif; ?> value="<?php echo ($key); ?>"><?php echo ($val); ?></option>
							<?php  } ?>
						</select>
						<input type="submit" value="查询" class="button"/>
					</form>
				</td>
			</tr>
		</table>
		<div class="table-list">
			<table width="100%" cellspacing="0">
				<colgroup><col> <col> <col> <col><col><col><col><col width="240" align="center"> </colgroup>
				<thead>
					<tr>
						<th><input type="checkbox" class="choice-all" value="1" /></th>
						<th>编号</th>
						<th>标题</th>
						<th>状态</th>
						<th>时间</th>
						<th>推荐</th>
						<th>热门</th>
						<th>活动类型</th>
						<th>所属店铺</th>
						<th align="center"><center>封面图</center></th>
					</tr>
				</thead>
				<tbody>
					<?php  if (is_array($activity_recommend_list)) { foreach ($activity_recommend_list as $activity_recommend) { ?>
							<tr>
								<td><input type="checkbox" value="<?php echo $activity_recommend['id']; ?>" name="id[]" class="choice"/></td>
								<td><?php echo $activity_recommend['id']; ?></td>
								<td><?php echo $activity_recommend['title']; ?></td>
								<td><?php echo $activity_recommend['status'] ? '已结束' : $activity_recommend['status_txt']; ?></td>
								<td><?php echo $activity_recommend['time']; ?></td>
								<td>
									<?php  if ($activity_recommend['is_rec'] == 1) { echo '<font color="green">推荐</font>'; } else { echo '普通'; } ?>
								</td>
								<td>
									<?php  if ($activity_recommend['is_hot'] == 1) { echo '<font color="red">热门</font>'; } else { echo '普通'; } ?>
								</td>
								<td><?php echo $activity_type_arr[$activity_recommend['model']]; ?></td>
								<td><?php echo $activity_recommend['s_name']; ?></td>
								<td><img src="<?php echo $activity_recommend['image']; ?>" width="60" class="view_msg" /></td>
							</tr>
					<?php  } } ?>
				</tbody>
				<tfoot>
					<?php  if (!empty($activity_recommend_list)) { ?>
						<tr>
							<td class="pagebar" colspan="10">
								<div>
									<div style="float: left">
										<label style="cursor: pointer;color: #3865B8;" class="label-choice-all">全选</label> / <label style="cursor: pointer;color: #3865B8;" class="label-choice-cancel">取消</label>
										<button class="activityRecommend" actType="activityRecommendRecAdd" style="height:30px;width:100px;">添加推荐</button>
										<button class="activityRecommend" actType="activityRecommendRecDel" style="height:30px;width:100px;">取消推荐</button>
										<button class="activityRecommend" actType="activityRecommendHotAdd" style="height:30px;width:100px;">添加热门</button>
										<button class="activityRecommend" actType="activityRecommendHotDel" style="height:30px;width:100px;">取消热门</button>
										　　
										<button class="activityRecommend" actType="activityRecommendDel" style="height:30px;width:75px;">删除活动</button>
									</div>
									<div style="float: right">
										<?php echo ($page); ?>
									</div>
								</div>
							</td>
						</tr>
					<?php  } else { ?>
						<tr><td class="textcenter red" colspan="9">列表为空！</td></tr>
					<?php  } ?>
				</tfoot>
			</table>
		</div>
	</div>
	</body>
</html>