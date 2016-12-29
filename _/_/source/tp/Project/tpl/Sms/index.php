<include file="Public:header"/>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Sms/index')}" class="on">分类列表</a> |
					
				</ul>
			</div>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th>编号</th>
								<th>内容</th>
								<th>类型</th>
								<th>状态</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($tp_list)">
								<volist name="tp_list" id="vo">
									<tr>
										<td>{pigcms{$vo.id}</td>
										<td>{pigcms{$vo.text|msubstr=0,80}</td>
										<td><if condition="$vo['type'] eq 1"><font color="orange">平台短信</font><elseif condition="$vo['type'] eq 2"/><font color="black">商家短信</font><else/><font color="blue">用户短信</font></if></td>
										<td><if condition="$vo['status'] eq 1"><font color="green">启用</font><else/><font color="red">关闭</font></if></td>
										<td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Sms/sms_edit',array('id'=>$vo['id']))}','查看信息',480,260,true,false,false,editbtn,'edit',true);">查看</a></td>
									</tr>
								</volist>
							<else/>
								<tr><td class="textcenter red" colspan="6">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>