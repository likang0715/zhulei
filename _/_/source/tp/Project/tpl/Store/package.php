<include file="Public:header"/>
<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="{pigcms{:U('Store/package')}" class="on">套餐列表</a>|
			<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/package_add')}','添加套餐',700,350,true,false,false,addbtn,'add',true);">添加套餐</a>
		</ul>
	</div>
	<table class="search_table" width="100%">
		<tr>
			<td>
				<form action="{pigcms{:U('Store/package')}" method="get">
					<input type="hidden" name="c" value="Store"/>
					<input type="hidden" name="a" value="package"/>
					筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
					<select name="searchtype">
						<option value="name" <if condition="$_GET['searchtype'] eq 'name'">selected="selected"</if>>名称</option>
						<option value="id" <if condition="$_GET['searchtype'] eq 'id'">selected="selected"</if>>序号</option>
					</select>
					<input type="submit" value="查询" class="button"/>
				</form>
			</td>
		</tr>
	</table>
	<form name="myform" id="myform" action="" method="post">
		<div class="table-list">
			<table width="100%" cellspacing="0">
				<colpackage>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col/>
					<col width="180" align="center"/>
				</colpackage>
				<thead>
					<tr>
						<th>序号</th>
						<th>名称</th>
						<th>特权有效时间</th>
						<th>开店数量</th>
						<th>状态</th>
						<th class="textcenter">操作</th>
					</tr>
				</thead>
				<tbody>
					<if condition="is_array($package_list)">
						<volist name="package_list" id="vo">
							<tr>
								<td>{pigcms{$vo.pigcms_id}</td>
									<td>
										{pigcms{$vo.name}
										<if condition="$vo['is_default'] eq 1">
											<span style="color: red;">(初始权限)</span>
										</if>
									</td>
								<if condition="$vo['time'] eq '0'">
									<td>永久</td>
								<else/>
								<td>{pigcms{$vo.time}</td>
								</if>
								<if condition="$vo['store_nums'] eq '0'">
									<td>不限</td>
								<else/>
									<td>{pigcms{$vo.store_nums}</td>
								</if>							
								<td class="textcenter">
									<!-- <if condition="$vo['status'] eq 1"><font color="green">正常</font><else/><font color="red">禁止</font></if> -->
									<span class="cb-enable status-enable"><label class="cb-enable <if condition="$vo['status'] eq 1">selected</if>" data-id="<?php echo $vo['pigcms_id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$vo['pigcms_id'] eq 1">checked="checked"</if> /></label></span>
									<span class="cb-disable status-disable"><label class="cb-disable <if condition="$vo['status'] eq 0">selected</if>" data-id="<?php echo $vo['pigcms_id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$vo['pigcms_id'] eq 0">checked="checked"</if>/></label></span>
								</td>
								<td class="textcenter">
									<!-- <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/package_menu',array('id'=>$vo['pigcms_id']))}','显示列表设置',500,400,true,false,false,editbtn,'edit',true);">显示列表设置</a>
									&nbsp;|&nbsp; -->
									<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/package_access',array('id'=>$vo['pigcms_id']))}','修改权限',500,400,true,false,false,editbtn,'edit',true);">店铺权限</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/package_edit',array('id'=>$vo['pigcms_id']))}','编辑套餐',620,350,true,false,false,editbtn,'edit',true);">编辑</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" class="package_delete_row" parameter="id={pigcms{$vo.pigcms_id}" url="{pigcms{:U('Store/package_del')}">删除</a>
									&nbsp;|&nbsp;
									<a href="javascript:void(0);" class="no_delete_row" parameter="id={pigcms{$vo.pigcms_id}" url="{pigcms{:U('Store/package_give')}">赋予全体用户该套餐</a>
									&nbsp;|&nbsp;
									
									<if condition="$vo['is_default'] eq 1">
										<a href="javascript:void(0);" class="no_delete_row" parameter="id={pigcms{$vo.pigcms_id}" url="{pigcms{:U('Store/package_default_cancel')}">取消默认套餐</a> 
									<else />
										<a href="javascript:void(0);" class="no_delete_row" parameter="id={pigcms{$vo.pigcms_id}" url="{pigcms{:U('Store/package_default')}">设置默认套餐</a>
									</if>
							
								</td>
							</tr>
						</volist>
						<tr><td class="textcenter pagebar" colspan="9">{pigcms{$pagebar}</td></tr>
					<else/>
						<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
					</if>
				</tbody>
			</table>
		</div>
	</form>
</div>
<script type="text/javascript">
$(function(){
	//是否启用
	$('.status-enable > .cb-enable').click(function(){
		if (!$(this).hasClass('selected')) {
			var package_id = $(this).data('id');
			$.post("<?php echo U('Store/package_status'); ?>",{'status': 1, 'package_id': package_id}, function(data){})
		}
	});

	$('.status-disable > .cb-disable').click(function(){
		if (!$(this).hasClass('selected')) {
			var package_id = $(this).data('id');
			if (!$(this).hasClass('selected')) {
				$.post("<?php echo U('Store/package_status'); ?>", {'status': 0, 'package_id': package_id}, function (data) {})
			}
		}
	});


	//删除行
	$('.no_delete_row').click(function(){
		var now_dom = $(this);
		window.top.art.dialog({
			icon: 'question',
			title: '请确认',
			id: 'msg' + Math.random(),
			lock: true,
			fixed: true,
			opacity:'0.4',
			resize: false,
			content: '你确定这样操作吗？操作后不能恢复！',
			ok:function (){
				$.post(now_dom.attr('url'),now_dom.attr('parameter'),function(result){
					if(result.status == 1){
						window.top.msg(1,result.info,true);				
						window.top.main_refresh();
					}else{
						window.top.msg(0,result.info);
					}
				});
			},
			cancel:true
		});
		return false;
	});

	//删除行
	$('.package_delete_row').click(function(){
		var now_dom = $(this);
		window.top.art.dialog({
			icon: 'question',
			title: '请确认',
			id: 'msg' + Math.random(),
			lock: true,
			fixed: true,
			opacity:'0.4',
			resize: false,
			content: '你确定这样操作吗？操作后该套餐店铺权限会失效，店铺拥有全部权限！',
			ok:function (){
				$.post(now_dom.attr('url'),now_dom.attr('parameter'),function(result){
					if(result.status == 1){
						window.top.msg(1,result.info,true);				
						if(now_dom.closest('table').find('tr').size()>3){
							now_dom.closest('tr').remove();
							$('#row_count').html(parseInt($('#row_count').html())-1);
						}else{
							window.top.main_refresh();
						}
					}else{
						window.top.msg(0,result.info);
					}
				});
			},
			cancel:true
		});
		return false;
	});
})
</script>
<include file="Public:footer"/>