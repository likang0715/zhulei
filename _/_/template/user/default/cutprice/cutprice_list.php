<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有</a>
		</li>
		<li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
			<a href="#future">未开始</a>
		</li>
		<li id="js-list-nav-on" <?php echo $type == 'on' ? 'class="active"' : '' ?>>
			<a href="#on">进行中</a>
		</li>
		<li id="js-list-nav-end" <?php echo $type == 'end' ? 'class="active"' : '' ?>>
			<a href="#end">已结束</a>
		</li>
	</ul>
</nav>

<div class="widget-list">
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<a href="#create" class="ui-btn ui-btn-primary">添加降价拍商品</a>
			<div class="js-list-search ui-search-box">
				<input class="txt js-present-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php
	if($cutprice_list) {
	?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">活动名称</th>
					<th class="cell-25">关联商品</th>
					<th class="cell-15">活动底价</th>
					<th class="cell-15">活动状态</th>
					<th class="cell-15">销量</th>
					<th class="cell-15">结束时间</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php
				foreach($cutprice_list as $cutprice) {
				?>
					<tr class="js-present-detail" service-id="<?php echo $cutprice['pigcms_id']?>">
						<td><?php echo htmlspecialchars($cutprice['active_name']) ?></td>
						<td><?php echo htmlspecialchars($cutprice['product']['name']) ?></td>
						<td><?php echo $cutprice['stopprice'];?></td>
						<td><?php 
						$cha = time() - $cutprice['starttime'];
						$chaprice = (floor($cha/60/$cutprice['cuttime']))*$cutprice['cutprice'];
						if($cutprice['inventory'] > 0 && ($cutprice['startprice'] - $chaprice) > $cutprice['stopprice']){
							echo $cutprice['state']==0 ? getTimeType($cutprice['starttime'], $cutprice['endtime']) : '已结束';
						}else{
							$cutprice['state']=2;
							echo '已结束';
						}
						?></td>
						<td><?php echo $cutprice['sales'];?></td>
						<td><?php echo date('Y-m-d H:i:s', $cutprice['starttime']) ?>至<?php echo date('Y-m-d H:i:s', $cutprice['endtime']) ?></td>
						<td class="text-right js-operate" data-present_id="<?php echo $cutprice['pigcms_id'] ?>">
							<?php if ($cutprice['state']==0) {?>
								<a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $cutprice['pigcms_id'] ?>" data-store_id="<?php echo $cutprice['store_id']?>">手机查看</a>
								<a href="javascript:void(0);" class="js-copy-link" data-id="<?php echo $cutprice['pigcms_id'] ?>">复制链接</a>
								<a href="#edit/<?php echo $cutprice['pigcms_id']?>" class="js-edit">编辑资料</a>
								<span>-</span>
								<a href="javascript:" class="js-disabled">使失效</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
								<span>-</span>
								<!--<a href="#order/<?php echo $cutprice['pigcms_id']?>" class="js-order">订单</a>-->
								<a href="/user.php?c=order&a=all" class="js-order"> 订单</a>
							<?php } 
								elseif($cutprice['state']==1){
									echo '已失效'.'-<a href="javascript:void(0);" class="js-delete">删除</a>';
								}elseif ($cutprice['state']==2){
									echo '已结束'.'-<a href="javascript:void(0);" class="js-delete">删除</a>';
								}
							?>
							
						</td>
					</tr>
				<?php
				}
				if ($pages) {
				?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="5">
								<div class="pagenavi js-present_list_page">
									<span class="total"><?php echo $pages ?></span>
								</div>
							</td>
						</tr>
					</thead>
				<?php
				}
				?>
			</tbody>
		</table>
	<?php
	}else{
	?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php
	}
	?>
</div>

<div class="js-list-footer-region ui-box"></div>