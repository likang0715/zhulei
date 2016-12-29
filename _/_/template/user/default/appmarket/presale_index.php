<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
						<ul class="pull-left js-list-filter-region">
							<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
								<a href="#all">所有预售</a>
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
			<a href="#create" class="ui-btn ui-btn-primary">添加预售</a>
			<div class="js-list-search ui-search-box">
				<!--  <input class="txt js-presale-keyword" type="text" placeholder="搜索" value="<?php echo htmlspecialchars($keyword) ?>"/>-->
			</div>
		</div>
	</div>
</div>

<div class="ui-box">


<div style="background:#fefbe4;border:1px solid #f3ecb9;color:#993300;padding:10px;margin-bottom:5px;font-size:12px;margin-top:5px;">
<font style="color:#f00;font-weight:700">温馨提示：</font> 1.正在开启中的预售信息，可以选择失效(请慎重操作：但在开启期间产生的预订订单将仍然可以支付尾款，完成支付)！<br>
　　　　　 2.预售的商品 均为  <b>商品=》仓库中</b> 的商品 ， 在预售期间 仓库商品不得上架销售（请慎重操作：上架后将导致预售活动不能正常进行）<br>
　　　　　 3.若这里的预售已有用户预订（产生订单），为保证预售信息的连贯性准确性，则该预售不可(编辑/删除)<br/>
</div>

	<?php if(is_array($presale_list)) {?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-15">预售产品信息</th>
					<th class="cell-15">特权</th>
					<th class="cell-25">时间</th>
					<th class="cell-15">状态</th>
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php
					foreach($presale_list as $presale) {
				?>
					<tr class="js-presale-detail" service-id="<?php echo $presale['id']?>">
						<td>
						
							产品名：<a href="<?php echo $prodcut_arr_presale['product_id']['wap_url']?>"><?php echo $prodcut_arr_presale[$presale['product_id']]['name'];?>
		</a>					<br/>
							预售人数: <?php echo $presale['presale_person'];?><br/>
							预售商品数量限制:<?php echo $presale['presale_amount'];?><br/>
							<font color="#07d" style="">待支付尾款订单：<?php echo $presale['order_unendpay'];?>个</font><br/>
							<font color="#0AC949">已支付完成订单：<?php echo $presale['order_complate'];?>个</font>
						</td>
						
						<td>
						<?php if($presale['privileged_cash'] > 0) {?>
							减现金: ￥<?php echo $presale['privileged_cash'];?><br/>
						<?php }?>
						<?php if($presale['privileged_coupon']) {?>
							赠送券: <a target="_blank" href="<?php echo $coupon_arr_presale[$presale['privileged_coupon']]['link']?>"><?php echo $coupon_arr_presale[$presale['privileged_coupon']]['name'];?><br/>
						<?php }?>
						<?php if($presale['privileged_present']) {?>
							赠品名: <a target="_blank" href="<?php echo $present_arr[$presale['privileged_present']]['link']?>"><?php echo $present_arr[$presale['privileged_present']]['name'];?>
						<?php }?>
						</td>
						
						<td>
							开始时间：<?php echo date('Y-m-d H:i:s', $presale['starttime']) ?>
							<br/>
							结束时间：<?php echo date('Y-m-d H:i:s', $presale['endtime']) ?>
							<br/>
							<font color="#f00">尾款支付截止：<?php echo date('Y-m-d H:i:s', $presale['final_paytime']) ?></font>
						</td>
						<td>
							时间状态：<?php if(($presale['starttime'] - time())>0) {?>
								未开始
							<?php } else if(($presale['endtime'] - time())<0) {?>
								已结束
							<?php } else {?>
								进行中
							<?php }?>
							<br/>
							可用状态：<span class="open_status"><?php if($presale['is_open']) {?>启用中<?php } else {?><font color="#f00">关闭</font><?php }?></span>
						</td>
						
						<td class="text-right js-operate" data-presale_id="<?php echo $presale['id'] ?>">
							
							<?php if(!empty($presale['order_unendpay']) || !empty($presale['order_complate'])) {?>
								<a href="#show/<?php echo $presale['id']?>" class="js-show">查看详细</a>
							<?php } else {?>
								<a href="#edit/<?php echo $presale['id']?>" class="js-edit">编辑详细</a>
							<?php }?>

							<span>-</span>
							<?php if($presale['is_open']) {?>
								<a href="javascript:" class="js-disabled">使失效</a>
							<?php }else {?>
								
								<?php // if($presale['endtime'] > $presale['final_paytime']) {?>
								<?php if(!empty($presale['order_unendpay']) || !empty($presale['order_complate'])) {?>
									<a href="javascript:" class="js-disabled">使启用</a>
								<?php } else {?>
									<a href="javascript:" style="color:#f00">已过期</a>
								<?php }?>
							<?php }?>
							<span>-</span>
							<a href="javascript:void(0);" class="js-copy-link" data-id="<?php echo $presale['id'] ?>">复制链接</a>
							<span>-</span>
							<a href="javascript:void(0);" class="js_show_ewm" data-id="<?php echo $presale['id'] ?>">手机预览</a>		
							
							<?php if(!empty($presale['order_unendpay']) || !empty($presale['order_complate'])) {?>
							<?php } else {?>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
							<?php }?>			
						</td>
					</tr>
				<?php
				}
				if ($pages) {
				?>
					<thead class="js-list-header-region tableFloatingHeaderOriginal">
						<tr>
							<td colspan="5">
								<div class="pagenavi js-presale_list_page">
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