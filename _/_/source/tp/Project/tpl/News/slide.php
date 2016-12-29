<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
function slideEdit(id){
  var url='{pigcms{:U('News/slideEdit')}&id='+id;
        layer.open({
            type: 2,
            title: '幻灯片操作',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['80%', '70%'],
            content: url,
        });
}
function lookImg(imgPath){
	layer.open({
	    title:'图片查看',
	    type: 1,
	    skin: 'layui-layer-rim', //加上边框
	    area: ['50%', '50%'], //宽高
	    content: '<img src="'+imgPath+'" style="width:100%;height:100%;"/>'
	});
}
</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="javascript:;" class="on">幻灯片列表</a>&nbsp;&nbsp;
					<a href="javascript:slideEdit(0);" class="on">添加幻灯片</a>
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
								<th>幻灯片名称</th>
								<th>幻灯片链接</th>
								<th>分类</th>
								<th>最后操作时间</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($slide_list)">
								<volist name="slide_list" id="vo">
									<tr>
										<td>{pigcms{$vo.id}</td>
										<td>{pigcms{$vo.name}</td>
										<td>图片查看：<a href="javascript:lookImg('<?php echo getAttachmentUrl($vo['url']); ?>');"><?php echo  getAttachmentUrl($vo['url']); ?></a></td>
										<td><?php echo $slideClass[$vo['class']]; ?></td>
										<td>{pigcms{$vo.time|date='Y-m-d H:i:s',###}</td>
										<td class="textcenter">
											<a href="javascript:void(0);" onclick="slideEdit(<?php echo $vo['id']; ?>)">修改</a>&nbsp;&nbsp;
											<a href="{pigcms{:U('News/slideDel',array('id'=>$vo['id']))}" >删除</a>
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