<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
function editQuestion(id){
  var url='{pigcms{:U('Invest/editQuestion')}&id='+id;
        layer.open({
            type: 2,
            title: '常见问题添加',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['80%', '70%'],
            content: url,
        });
}
</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="javascript:;" class="on">常见问题列表</a>&nbsp;&nbsp;
					<a href="javascript:editQuestion();" class="on">添加问题</a>
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
								<th>ID</th>
								<th>问题名称</th>
								<th>问题答案</th>
								<th>分类</th>
								<th>最后操作时间</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($question_list)">
								<volist name="question_list" id="vo">
									<tr>
										<td>{pigcms{$vo.id}</td>
										<td style="width:20%;">{pigcms{$vo.question_name}</td>
										<td style="width:60%;">{pigcms{$vo.question_answer}</td>
										<td><?php echo $questionClass[$vo['class']]; ?></td>
										<td>{pigcms{$vo.time|date='Y-m-d H:i:s',###}</td>
										<td class="textcenter">
											<a href="javascript:void(0);" onclick="editQuestion(<?php echo $vo['id']; ?>)">修改</a>&nbsp;&nbsp;
											<a href="{pigcms{:U('Invest/questionDel',array('id'=>$vo['id']))}" >删除</a>
										</td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="9">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="7">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>