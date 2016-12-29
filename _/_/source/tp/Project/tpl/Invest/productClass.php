<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>
<script type="text/javascript" src="{pigcms{$static_path}js/invest.js"></script>
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
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th style="width: 100px;"><button >点击排序</button></th>
								<th>ID</th>
                                				<th>项目分类</th>
								<th>操作时间</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($class_list)">
								<volist name="class_list" id="vo">
									<tr>
									<td>&nbsp;<input type="text" name="sort[<?php echo $vo['id']; ?>]" value="<?php  echo $vo['sort'];  ?>" style="width: 30px;padding: 3px;border-radius: 3px;"></td>
                                        				<td >{pigcms{$vo.id}</td>
                                        				<td>{pigcms{$vo.name}</td>
									<td><?php echo date('Y-m-d H:i',$vo['time']); ?></td>
                                                                        <td style="text-align: center">
                                                                            <a href="{pigcms{:U('Invest/productSetclass',array('id'=>$vo['id']))}">编辑</a>
                                                                            <a href="{pigcms{:U('Invest/productDelClass',array('id'=>$vo['id']))}">删除</a>
                                                                        </td>
									</tr>
								</volist>
								<tr>
								<td class="textcenter pagebar" colspan="5">
								<div style="width: 100%">{pigcms{$pagebar}</div>
								</td>
								</tr>
							<else/>
								<tr><td class="textcenter red" colspan="5">列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>



