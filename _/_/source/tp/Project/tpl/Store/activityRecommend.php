<include file="Public:header"/>
	<style>
		.table-list tfoot tr {
			height: 40px;
		}
	</style>
	<script type="text/javascript">
		$(function(){
			var activityModel = '{pigcms{$selectModel}';
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
				<a href="{pigcms{:U('Store/activityManage')}" class="on">推荐活动列表</a>
			</ul>
		</div>
		<table class="search_table" width="100%">
			<tr>
				<td>
					<form action="{pigcms{:U('Store/activityRecommend')}" method="get">
						<input type="hidden" name="c" value="Store"/>
						<input type="hidden" name="a" value="activityRecommend"/>
						筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}" />
						<select name="type">
							<option value="activity_id" <if condition="$_GET['type'] eq 'activity_id'">selected="selected"</if>>活动编号</option>
							<option value="activity_name" <if condition="$_GET['type'] eq 'activity_name'">selected="selected"</if>>活动名称</option>
							<option value="store_id" <if condition="$_GET['type'] eq 'store_id'">selected="selected"</if>>店铺编号</option>
							<option value="name" <if condition="$_GET['type'] eq 'name'">selected="selected"</if>>店铺名称</option>
							<option value="tel" <if condition="$_GET['type'] eq 'tel'">selected="selected"</if>>联系电话</option>
						</select>
						&nbsp;&nbsp;活动类型：
						<select name="activity_type">
							<option value="">全部</option>
							<?php 
							foreach($activity_type_arr as $key => $val){
							?>
								<option <if condition="$_GET['activity_type'] eq $key">selected="selected"</if> value="{pigcms{$key}">{pigcms{$val}</option>
							<?php 
							}
							?>
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
					<?php 
					if (is_array($activity_recommend_list)) {
						foreach ($activity_recommend_list as $activity_recommend) {
					?>
							<tr>
								<td><input type="checkbox" value="<?php echo $activity_recommend['id']; ?>" name="id[]" class="choice"/></td>
								<td><?php echo $activity_recommend['id']; ?></td>
								<td><?php echo $activity_recommend['title']; ?></td>
								<td><?php echo $activity_recommend['status'] ? '已结束' : $activity_recommend['status_txt']; ?></td>
								<td><?php echo $activity_recommend['time']; ?></td>
								<td>
									<?php 
									if ($activity_recommend['is_rec'] == 1) {
										echo '<font color="green">推荐</font>';
									} else {
										echo '普通';
									}
									?>
								</td>
								<td>
									<?php 
									if ($activity_recommend['is_hot'] == 1) {
										echo '<font color="red">热门</font>';
									} else {
										echo '普通';
									}
									?>
								</td>
								<td><?php echo $activity_type_arr[$activity_recommend['model']]; ?></td>
								<td><?php echo $activity_recommend['s_name']; ?></td>
								<td><img src="<?php echo $activity_recommend['image']; ?>" width="60" class="view_msg" /></td>
							</tr>
					<?php 
						}
					}
					?>
				</tbody>
				<tfoot>
					<?php 
					if (!empty($activity_recommend_list)) {
					?>
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
										{pigcms{$page}
									</div>
								</div>
							</td>
						</tr>
					<?php 
					} else {
					?>
						<tr><td class="textcenter red" colspan="9">列表为空！</td></tr>
					<?php 
					}
					?>
				</tfoot>
			</table>
		</div>
	</div>
<include file="Public:footer"/>