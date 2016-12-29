<div class="m-win m-win-myself">
    <div class="m-user-comm-wraper">
		<div class="m-user-comm-cont">
			<div class="m-win-hd">
				<div class="col info">商品信息</div>
				<div class="col status">商品状态</div>
				<div class="col opt">操作</div>
			</div>
			<div class="m-win-bd">
				<?php if (empty($lucknum_list)) { ?>
	                <div class="m-user-comm-empty">
	                    <b class="ico ico-face-sad"></b>
	                    <div class="i-desc">您还没有中奖记录哦~</div>
	                    <div class="i-opt"><a href="<?php dourl('unitary:index') ?>" class="w-button w-button-main w-button-xl">马上去逛逛</a></div>
	                </div>
	            <?php } ?>
				<?php foreach ($lucknum_list as $val) { ?>
				<div class="w-goods">
					<div class="col info">
						<div class="w-goods-pic">
							<a title="<?php echo $val['name'] ?>" target="_blank" href="<?php dourl('unitary:detail', array('id'=>$val['unitary_id'])) ?>">
								<img src="<?php echo $val['logopic'] ?>" alt="<?php echo $val['name'] ?>" style="width:120px;height:120px;">
							</a>
						</div>
						<div class="w-goods-content">
							<p class="w-goods-title">
								<a title="<?php echo $val['name'] ?>" target="_blank" href="<?php dourl('unitary:detail', array('id'=>$val['unitary_id'])) ?>"><?php echo $val['name'] ?></a>
							</p>
							<p class="w-goods-price">期号：<?php echo $val['unitary_id'] ?></p>
							<p class="w-goods-price">总需：<?php echo $val['total_num'] ?>人次</p>
							<p class="w-goods-info">幸运号码：
								<strong class="txt-impt"><?php echo 100000 + $val['lucknum'] ?></strong>，总共参与了
								<strong class="txt-dark"><?php echo $val['my_count'] ?></strong>人次
							</p>
							<p class="buyTime">夺宝时间：<?php echo $val['add_date'] ?></p>
							<p class="calcTime">揭晓时间：<?php echo date('Y-m-d H:i:s', $val['endtime']) ?>.000</p>
						</div>
					</div>
					<div class="col status">
						<span class="txt-suc"> <?php echo $val['order_status'] ?> </span>
					</div>
					<div class="col opt">
						<p>
							<a href="<?php dourl('order:detail', array('order_id'=>$val['order_no'])) ?>" target="_blank">查看详情</a>
						</p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<div class="w-pager js-my-luck"><?php echo $pages; ?></div>
	</div>
</div>