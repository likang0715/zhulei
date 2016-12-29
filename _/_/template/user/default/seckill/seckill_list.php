<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有秒杀活动</a>
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
			<a href="#create" class="ui-btn ui-btn-primary js-create">添加活动</a>
			<span style="color: red;">注意：秒杀开始后不能再编辑</span>
			<div class="js-list-search ui-search-box" data-type="<?php echo $type ?>" data-keyword="<?php echo htmlspecialchars($keyword) ?>">
				<input class="txt js-tuan-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>
			</div>
		</div>
	</div>
</div>

<div class="ui-box">
	<?php if($seckill_list) { ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">秒杀名称</th>
					<th class="cell-15">团购产品</th>
					<th class="cell-25">有效时间</th>
					<th class="cell-15" style="text-align: center;">活动状态</th>
					<th class="cell-15 pl100">销量</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php
				foreach($seckill_list as $seckill) {
				?>
					<tr class="js-present-detail js-id-<?php echo $seckill['id'] ?>" service-id="<?php echo $seckill['id']?>">
						<td><?php echo htmlspecialchars($seckill['seckill_name']) ?></td>
						<td>
							<a href="<?php echo $seckill['product_url'] ?>" target="_blank">
								<img title="<?php echo $seckill['product_name'] ?>" src="<?php echo $seckill['product_image']?>" style="max-width: 60px; max-height: 60px;" />
                                <br/>
                                <p title="<?php echo $seckill['product_name'] ?>" style="color: #00f;display:block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;width:100px;">
                                    <?php echo $seckill['product_name'] ?>
                                </p>
							</a>
						</td>

						<td><?php echo date('Y-m-d H:i:s', $seckill['start_time']) ?>　至<br/><?php echo date('Y-m-d H:i:s', $seckill['end_time']) ?></td>
						<td style="text-align: center;"><?php echo $seckill['status'] == 1 ? getTimeType($seckill['start_time'], $seckill['end_time']) : '已结束' ?></td>
						<td><?php echo $seckill['sales_volume'] ?></td>
						<td class="text-right js-operate">
							<?php if ($seckill['status'] == 1) {?>
								<a href="javascript:void(0);" class="js-copy-link" data-id="<?php echo $seckill['pigcms_id'] ?>">复制链接</a><span>-</span>
								<a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $seckill['pigcms_id'] ?>">预览</a>
								<?php if ($seckill['start_time'] < time() && $seckill['end_time'] > time()) {?>
									<span>-</span>
									<a href="javascript:" data-id="<?php echo $seckill['pigcms_id'] ?>" class="js-disabled">使失效</a>
                                    <span>-</span>
                                    <a target="_blank" href="<?php dourl('order:activity');?>">查看订单</a>
								<?php } if ($seckill['start_time'] > time()) {?>
									<a href="#edit/<?php echo $seckill['pigcms_id']?>" class="js-edit">编辑资料</a>
									<span>-</span>
									<a href="javascript:void(0);" data-id="<?php echo $seckill['pigcms_id'] ?>" class="js-delete">删除</a>
							<?php	} } else { ?>
								已失效
							<?php } ?>
						</td>
					</tr
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>
    <div class="js-list-empty-region">
        <?php if (empty($seckill_list)) { ?>
            <div>
                <div class="no-result widget-list-empty">还没有相关数据。</div>
            </div>
        <?php } ?>
    </div>
    <div class="js-list-footer-region ui-box">
        <?php if (!empty($seckill_list)) { ?>
            <div class="widget-list-footer">
                <div class="pagenavi ui-box"><?php echo $page; ?></div>
            </div>
        <?php } ?>
    </div>
</div>