<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
function checkProduct(id){
  var url='?c=Invest&a=product_repay&payid='+id;
        layer.open({
            type: 2,
            title: '回报设置查看',
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
					<a href="{pigcms{:U('Invest/product')}" class="on">项目列表</a>
					<a href="{pigcms{:U('Invest/productClass')}" class="on">分类列表</a>
					<a href="{pigcms{:U('Invest/productSetclass')}" class="on">添加分类</a>
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
								<th class="textcenter">ID</th>
								<th class="textcenter">支付金额</th>
								<th class="textcenter">名额</th>
                                				<th class="textcenter">回报内容</th>
								<th class="textcenter" style="width: 12%;">回报时间</th>
								<th class="textcenter">运费</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($list)">
								<volist name="list" id="vo">
									<tr>
										<td class="textcenter">{pigcms{$vo.repay_id}</td>
										<td class="textcenter">{pigcms{$vo.amount}</td>
										<td class="textcenter">{pigcms{$vo.limits}</td>
                                        					<td class="textcenter">{pigcms{$vo.redoundContent}</td>
										<td class="textcenter"><?php echo '项目结束后'.$vo['redoundDays'].'天'; ?></td>
										<td class="textcenter">
										<?php echo empty($vo['freight']) ? '包邮' : $vo['freight'].'元'; ?>
										</td>
                                                                                <td class="textcenter">
                                                                                    <a href="javascript:checkProduct(<?php echo $vo['repay_id']; ?>)" >查看</a>
                                                                                </td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="12">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="12">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>