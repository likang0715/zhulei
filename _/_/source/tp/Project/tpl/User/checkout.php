<include file="Public:header"/>

<script type="text/javascript" src="{pigcms{$static_public}js/layer/layer.min.js"></script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('User/checkout')}" class="on">用户信息导出</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td><center>
						<form action="{pigcms{:U('User/checkout')}" method="get">
							<input type="hidden" name="c" value="User"/>
							<input type="hidden" name="a" value="checkout"/>
							导出筛选: 
							<select name="searchtype">
								<option value="0" <if condition="$_GET['searchtype'] eq 'uid'">selected="selected"</if>>不限</option>
								<option value="1" <if condition="$_GET['searchtype'] eq 'nickname'">selected="selected"</if>>导出有手机号的用户</option>
								<option value="2" <if condition="$_GET['searchtype'] eq 'phone'">selected="selected"</if>>导出有微信登陆的用户</option>
							</select>
							
							&nbsp;&nbsp;用户注册时间：
							<input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="{pigcms{$Think.get.start_time}" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="{pigcms{$Think.get.end_time}" />
							<span class="date-quick-pick" data-days="7">最近7天</span>
							<span class="date-quick-pick" data-days="30">最近30天</span>
							<input type="button" value="查询并导出" class="button search_checkout"/>
						</form>
					</center></td>
				</tr>
			</table>
			<!--
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
						<tr><th colspan="8"><center style="font-size:14px;font-weight:700">导出记录</center></th></tr>
							<tr>
								<th>ID</th>
								<th>昵称</th>
								<th>手机号</th>
								<th>店铺数量</th>
								<th>最后登录时间</th>
								<th>最后登录IP</th>
								<th class="textcenter">状态</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							
							
									<tr>
										<td>{pigcms{$vo.uid}</td>
										<td>{pigcms{$vo.nickname}</td>
										<td>{pigcms{$vo.phone}</td>
										<td><?php if ($vo['stores'] > 0) { ?><a href="javascript:;" href="javascript:void(0);" style="color: #3865B8" onclick="window.top.artiframe('{pigcms{:U('User/stores',array('id' => $vo['uid'], 'frame_show' => true))}','商家“{pigcms{$vo.nickname}”的店铺',750,700,true,false,false,false,'detail',true);">{pigcms{$vo.stores}</a><?php } else { ?>0<?php } ?></td>
										<td>{pigcms{$vo.last_time|date='Y-m-d H:i:s',###}</td>
										<td>{pigcms{$vo.last_ip_txt}</td>
										<td class="textcenter"><if condition="$vo['status'] eq 1"><font color="green">正常</font><else/><font color="red">禁止</font></if></td>
										<td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('User/edit',array('uid'=>$vo['uid']))}','编辑用户信息',620,360,true,false,false,editbtn,'edit',true);">编辑</a>&nbsp;|&nbsp;<a href="{pigcms{:U('tab_store',array('uid'=>$vo['uid']))}" target="_blank">进入店铺</a></td>
									</tr>
								
								<tr><td class="textcenter pagebar" colspan="9">{pigcms{$pagebar}</td></tr>
							
								<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
							
						</tbody>
					</table>
				</div>
			</form>
			-->
		</div>
		
<script>
//搜索有多少需要导出

$(".search_checkout").click(function(){
	var searchtype = $("select[name='searchtype']").val();
	var start_time = $("input[name='start_time']").val();
	var end_time = $("input[name='end_time']").val();

	var start_time1 = start_time.replace(/:/g,'-');
	start_time1 = start_time1.replace(/ /g,'-');
	var arr1 = start_time1.split("-");
	var end_time1 = end_time.replace(/:/g,'-');
	end_time1 = end_time1.replace(/ /g,'-');
	var arr2 = end_time1.split("-");
	var datum1 = new Date(Date.UTC(arr1[0],arr1[1]-1,arr1[2],arr1[3]-8,arr1[4],arr1[5]));
	var starttime = datum1.getTime()/1000;
	var datum2 = new Date(Date.UTC(arr2[0],arr2[1]-1,arr2[2],arr2[3]-8,arr2[4],arr2[5]));
	var endtime = datum2.getTime()/1000;
		
	if(!start_time || !end_time || starttime >= endtime) {

		layer.alert('开始时间不能小于结束时间！', 8); 
		return;
	}
	
	
	var loadi =layer.load('正在查询', 10000000000000);
	$.post(
			"{pigcms{:U('User/checkout')}",
			{"searchtype":searchtype,"start_time":start_time,"end_time":end_time},
			function(obj) {
				layer.close(loadi);
				if(obj.msg>0) {
					layer.confirm('该指定条件下有 用户  '+obj.msg+' 人，确认导出？',function(index){
					 	layer.close(index);
					 	location.href="{pigcms{:U('User/download_csv_byuser')}&searchtype="+searchtype+"&start_time="+starttime+"&end_time="+endtime;

					
					});
				} else {
					layer.alert('该搜索条件下没有用户数据，无需导出！', 8); 
				}
				
			},
			'json'
	)

})





</script>		
		
<include file="Public:footer"/>