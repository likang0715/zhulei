<include file="Public:header"/>
<style type="text/css">
.c-gray { color: #999; }
.table-list tfoot tr { height: 40px; }
.green { color: green; }
a, a:hover { text-decoration: none; }
</style>

<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="{pigcms{:U('Physical/chcate')}" class="on">茶会分类</a>| <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Physical/chcate_add')}','添加分类',600,500,true,false,false,addbtn,'add',true);">添加分类</a>
		</ul>
	</div>
	
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>删除 | 修改</th>
					<th>编号</th>
					<th>名称</th>
					<th>描述</th>
					<th>状态</th>
					<th>排序</th>
					
				</tr>
			</thead>
			<tbody>
				<if condition="is_array($categories)"> 
					<volist name="categories" id="category">
						<tr>
							<td><a url="<?php echo U('Physical/chcate_del', array('id' => $category['cat_id'])); ?>"  class="delete_row"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Physical/chcate_edit', array('id' => $category['cat_id']))}','修改分类 - {pigcms{$category.cat_name}',540,<if condition="$category['cat_pic']">500<else/>500</if>,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
							<td>{pigcms{$category.cat_id}</td>
							<td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Physical/chcate_edit', array('id' => $category['cat_id']))}','修改分类 - {pigcms{$category.cat_name}',600,<if condition="$category['cat_pic']">500<else/>500</if>,true,false,false,editbtn,'edit',true);"><?php if ($category['cat_level'] > 1){ echo str_repeat('|——', $category['cat_level']); } ?> <span <?php if ($category['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$category.cat_name}</span></a></td>
							<td>{pigcms{$category.cat_desc}</td>
							<td><span class="green"><if condition="$category['cat_status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if></span></td>
							<td>{pigcms{$category.cat_sort}</td>
						
						</tr>
						
				
					</volist>
				</if>
			</tbody>
			<tfoot>
				<if condition="is_array($categories)">
					<tr>
						<td class="textcenter pagebar" colspan="7">{pigcms{$page}</td>
					</tr>
					<else/>
					<tr>
						<td class="textcenter red" colspan="7">列表为空！</td>
					</tr>
				</if>
			</tfoot>
		</table>
	</div>
</div>
<include file="Public:footer"/>