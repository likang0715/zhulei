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
			<a href="#create" class="ui-btn ui-btn-primary">添加抽奖活动</a>
			<div class="js-list-search ui-search-box">
				<input class="txt js-present-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php
	if($lottery_list) {
	?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">活动名称</th>
					<th class="cell-25">类型</th>
					<th class="cell-15">兑奖密码</th>
					<th class="cell-15">活动状态</th>
					<th class="cell-15">活动时间</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php
				foreach($lottery_list as $lottery) {
				?>
					<tr class="js-present-detail" service-id="<?php echo $lottery['id']?>">
						<td><?php echo htmlspecialchars($lottery['title']) ?></td>
						<td><?php echo $lottery_type[$lottery['type']]?></td>
						<td><?php echo $lottery['password']?></td>
						<td><?php echo $lottery['status']==0 ? getTimeType($lottery['starttime'], $lottery['endtime']) : ($lottery['status']==1?'已失效':'已结束') ?></td>
						<td><?php echo date('Y-m-d H:i:s', $lottery['starttime']) ?>至<?php echo date('Y-m-d H:i:s', $lottery['endtime']) ?></td>
						<td class="text-right js-operate" data-present_id="<?php echo $lottery['id'] ?>">
							<?php if ($lottery['status']==0) {?>
								<a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $lottery['id'] ?>">手机查看</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-copy-link" data-id="<?php echo $lottery['id'] ?>">复制链接</a>
								<span>-</span>
								<a href="#edit/<?php echo $lottery['id']?>" class="js-edit">编辑资料</a>
								<span>-</span>
								<a href="javascript:" class="js-disabled">使失效</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
								<span>-</span>
								<a href="#data/<?php echo $lottery['id']?>" class="js-data">抽奖记录</a>
							<?php } 
								elseif($lottery['status']==1){
									echo '已失效'.'-<a href="javascript:void(0);" class="js-delete">删除</a>';
								}elseif ($lottery['status']==2){
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