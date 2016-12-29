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
								<th>所属门店</th>
								<th>联系人</th>
								<th>联系电话</th>
								<th>到店时间</th>
								<th>使用时常</th>
								<th>下单时间</th>
							    <th>预约状态</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($list)">
								<volist name="list" id="store">
									<tr>
										<td>{pigcms{$store.orderid}</td>
                                        <td>{pigcms{$store.tablename}</td>
										<td>{pigcms{$store.p_name}</td>
										<td>{pigcms{$store.name}</td>
										<td>{pigcms{$store.phone}</td>
										<td>{pigcms{$store.dd_time}</td>
										<td>{pigcms{$store.sc}</td>
										<td>{pigcms{$store.dateline|date='Y-m-d H:i:s', ###}</td>
                                        <td>{pigcms{$store.status}</td>
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
