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
					<a href="{pigcms{:U('Physical/chahui')}" class="on">茶会列表</a>
				</ul>
			</div>
		
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
				
						<thead>
							<tr>
								<th>编号</th>
                                <th>茶会名称</th>
								<th>举办地址</th>
								<th>举办时间</th>
								<th>举办主题</th>
								<th>人数限制</th>
								<th>费用</th>
								<th>店铺名称</th>
								<th>店铺电话</th>
								<th>更新时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($store_physical)">
								<volist name="store_physical" id="store">
									<tr>
										<td>{pigcms{$store.pigcms_id}</td>
                                        <td>{pigcms{$store.name}</td>
										<td>{pigcms{$store.address}</td>
										<td>{pigcms{$store.sttime|date='Y-m-d H:i:s', ###}-{pigcms{$store.endtime|date='Y-m-d H:i:s', ###}</td>
										<td>{pigcms{$store.cat_name}</td>
										<td>{pigcms{$store.renshu}</td>
										<td>{pigcms{$store.price}</td>
										<td>{pigcms{$store.store_name}</td>
										<td>{pigcms{$store.tel}</td>
										<td>{pigcms{$store.last_time|date='Y-m-d H:i:s', ###}</td>
                                   	   <td>
									<if condition="$store.tj eq 1">
									 <a url="<?php echo U('Physical/chahui_tj', array('id' => $store['pigcms_id'],'tj' => '0')); ?>"  class="delete_row">取消推荐</a>
									   <else />
									 <a url="<?php echo U('Physical/chahui_tj', array('id' => $store['pigcms_id'],'tj' => '1')); ?>"  class="delete_row">设置推荐</a>
									   	</if></td>
									
										
                                       
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
