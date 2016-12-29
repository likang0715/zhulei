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
					<a href="{pigcms{:U('Physical/chbm')}" class="on">茶会报名列表</a>
				</ul>
			</div>
		
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
				
						<thead>
							<tr>
								<th>编号</th>
                                <th>茶会名称</th>
								<th>店铺名称</th>
								<th>联系人</th>
								<th>联系电话</th>
								<th>报名时间</th>
							    <th>报名状态</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($baoming)">
								<volist name="baoming" id="store">
									<tr>
										<td>{pigcms{$store.id}</td>
                                        <td>{pigcms{$store.ch_name}</td>
										<td>{pigcms{$store.store_name}</td>
										<td>{pigcms{$store.name}</td>
										<td>{pigcms{$store.mobile}</td>
										<td>{pigcms{$store.addtime|date='Y-m-d H:i:s', ###}</td>
                                        <td><if condition="$store.status eq 1"> 待审核<elseif condition="$store.status eq 2"/>未通过<else/>已通过</if></td>
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
