<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
function leaderLook(uid){
  var url="{pigcms{:U('Invest/leaderInfo')}&uid="+uid;
        layer.open({
            type: 2,
            title: '领投人审核',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['80%', '80%'],
            content: url,
        });
}
$(function(){
	$(".table-list input").blur(function(){
		var val=$(this).val();
		var kid=$(this).attr("kid");
		var url="{pigcms{:U('Invest/ajax_setBeilv')}";
		$.post(url,{val:val,kid:kid},function(sta){
			if(sta.err_code==0){
				layer.msg(sta.msg);
			}else{
				layer.msg(sta.msg);
			}
		},"json");
	})
})
</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Invest/leaderList')}" class="on">领头人列表</a>
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
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th>UID</th>
								<th>姓名</th>
								<th>手机号</th>
                                				<th>公司名称</th>
								<th>申请时间</th>
								<th>信用倍率设置</th>
								<th class="textcenter">状态</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($user_list)">
								<volist name="user_list" id="vo">
									<tr>
										<td>{pigcms{$vo.uid}</td>
										<td>{pigcms{$vo.name}</td>
										<td>{pigcms{$vo.phone}</td>
                                        					<td>{pigcms{$vo.company_name}</td>
										<td>{pigcms{$vo.apply_leader_time|date='Y-m-d H:i:s',###}</td>
										<td><input  style="border-radius: 2px;width: 70px;padding: 3px;" type="text" name="beilv" value="<?php echo $vo['beilv']; ?>"  kid="<?php echo $vo['uid'];  ?>"  />
										<span style="color:red;">&nbsp;*整数</span></td>
										<td class="textcenter">
										<?php
										switch ($vo['leader_status']) {
											case '99':
												echo '<font color="green">审核通过</font>';
												break;
											case '98':
												echo '<font color="red">待审核</font>';
												break;
											case '97':
												echo '<font color="red">审核未通过</font>';
												break;
											default:
												echo '<font color="red">未申请</font>';
												break;
										} ?>
										</td>
										<td class="textcenter">
											<a href="javascript:void(0);" onclick="leaderLook(<?php echo $vo['uid']; ?>)">审核</a>&nbsp;&nbsp;
											<a href="{pigcms{:U('Invest/leaderDel',array('uid'=>$vo['uid']))}" >删除</a>
										</td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="9">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="9">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>