<include file="Public:header"/>
<style>
.cursor{cursor:pointer;}
.display_edit,.display_save{background:url('./source/tp/Project/tpl/Static/images/glyphicons-halflings.png') no-repeat;}
.display_edit{background-position: -20px -23px;display:inline-block;height:20px;width:20px;}
.display_save{background-position: -283px 0px;display:inline-block;height:20px;width:20px;}
</style>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Physical/table')}" class="on">茶桌列表</a>
				</ul>
			</div>
		
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
				
						<thead>
							<tr>
								<th>编号</th>
                                <th>包厢名称</th>
								<th>包厢分类</th>
								<th>所属店铺</th>
								<th>所属门店</th>
								<th>添加时间</th>
							    <th>茶桌状态</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($list)">
								<volist name="list" id="store">
									<tr>
										<td>{pigcms{$store.cz_id}</td>
                                        <td>{pigcms{$store.name}</td>
										<td>{pigcms{$store.cat_name}</td>
										<td>{pigcms{$store.store_name}</td>
										<td>{pigcms{$store.p_name}</td>
										<td>{pigcms{$store.add_time|date='Y-m-d H:i:s', ###}</td>
                                        <td><if condition="$store.status eq 1"> 可预约<elseif condition="$store.status eq 2"/>不可预约<else/></if></td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="11">{pigcms{$page}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="11">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
		
<include file="Public:footer"/>
