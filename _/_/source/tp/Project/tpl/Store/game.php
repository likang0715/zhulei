<include file="Public:header"/>
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
				<a href="{pigcms{:U('Store/game')}" class="on">店铺游戏活动列表</a>
			</ul>
		</div>
		<table class="search_table" width="100%">
			<tr>
				<td>
					<form action="{pigcms{:U('Store/game')}" method="get">
						<input type="hidden" name="c" value="Store"/>
						<input type="hidden" name="a" value="game"/>
						筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}" />
						<select name="type">
							<option value="store_id" <if condition="$_GET['type'] eq 'store_id'">selected="selected"</if>>店铺编号</option>
							<option value="name" <if condition="$_GET['type'] eq 'name'">selected="selected"</if>>店铺名称</option>
							<option value="tel" <if condition="$_GET['type'] eq 'tel'">selected="selected"</if>>联系电话</option>
						</select>
						&nbsp;&nbsp;活动类型：
						<select name="activity_type">
							<php>
								foreach($activity_type_arr as $key=>$val){
							</php>
								<option <if condition="$activity_type eq $key">selected="selected"</if> value="{pigcms{$key}">{pigcms{$val}</option>
							<php>
								}
							</php>
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
					<?php 
					if (is_array($activity_list)) {
						foreach ($activity_list as $activity) {
					?>
							<tr>
								<td><?php echo $activity['name']; ?></td>
								<td><?php echo $activity_type_arr[$activity_type]; ?></td>
								<td><?php echo $activity['s_name']; ?></td>
								<td><?php echo $activity['time']; ?></td>
								<td><img src="<?php echo $activity['image']; ?>" width="60" class="view_msg"></td>
								<td><?php echo $activity['status_txt']; ?></td>
							</tr>
					<?php 
						}
					}
					?>
				</tbody>
				
				<tfoot>
					<?php 
					if ($activity_list) {
					?>
						<tr>
							<td class="pagebar" colspan="6">
								<div>
									<div style="float: right">
										{pigcms{$page}
									</div>
								</div>
							</td>
						</tr>
					<?php 
					} else {
					?>
						<tr><td class="textcenter red" colspan="7">列表为空！</td></tr>
					<?php 
					}
					?>
				</tfoot>
			</table>
		</div>
	</div>
	<script type="text/template" id="activity-tmpl">
		{pigcms{$activityList|json_encode}
	</script>
<include file="Public:footer"/>