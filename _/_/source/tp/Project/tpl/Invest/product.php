<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript">
function checkProduct(id){
  var url='?c=Invest&a=productCheck&id='+id;
        layer.open({
            type: 2,
            title: '产品众筹项目审核',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['80%', '90%'],
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
								<th class="textcenter">联系人</th>
								<th class="textcenter">联系电话</th>
                                				<th class="textcenter">项目名称</th>
								<th class="textcenter" style="width: 12%;">申请时间</th>
								<th class="textcenter">状态</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($product_list)">
								<volist name="product_list" id="vo">
									<tr>
										<td class="textcenter">{pigcms{$vo.product_id}</td>
										<td class="textcenter">{pigcms{$vo.nickname}</td>
										<td class="textcenter">{pigcms{$vo.sponsorPhone}</td>
                                        					<td class="textcenter">{pigcms{$vo.productName}</td>
										<td class="textcenter"><?php echo date('Y-m-d H:i:s',$vo['time']); ?></td>
										<td class="textcenter">
										<?php
										switch ($vo['status']) {
                                                                                        case '1':
												echo '<font color="red">申请中</font>';
												break;
                                                                                        case '2':
												echo '<font color="green">审核通过</font>';
												break;
                                                                                        case '3':
												echo '<font color="red">审核拒绝</font>';
												break;
                                                                                        case '4':
												echo '<font color="red">融资中</font>';
												break;
                                                                                        case '6':
												echo '<font color="red">融资成功</font>';
												break;
                                                                                        case '7':
												echo '<font color="red">融资失败</font>';
												break;
											default:
												echo '<font color="red">错误信息101</font>';
												break;
										} ?>
										</td>
                                                                                <td class="textcenter">
                                                                                  <a href="{pigcms{:U('Invest/product_repaylist',array('id'=>$vo['product_id']))}" >回报设置</a>-
                                                                                  <a href="javascript:checkProduct(<?php echo $vo['product_id']; ?>)" >审核</a>-
                                                                                  <a href="{pigcms{:U('Invest/productDelete',array('id'=>$vo['product_id']))}">删除</a>
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