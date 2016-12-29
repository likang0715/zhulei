<!-- ▼ Main container -->

<div class="widget-list">
  <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
      <div>
          <a href="#create" class="ui-btn ui-btn-primary">添加打印机</a>
          <a href="javascript:void(0)" class="had_zdh ui-btn ui-btn-primary" style="background-color:#44b549;border-color:#44b549;">背部有终端号的操作说明</a>
          <!--  <a href="javascript:void(0)" class="no_had_zdh ui-btn ui-btn-primary" style="background-color:#44b549;border-color:#44b549;">背部无终端号的操作说明</a>-->
          
          <div class="js-list-search ui-search-box">
              <input class="txt js-orderprint-keyword" type="text"  placeholder="搜索" value="<?php if($keyword) echo $keyword;?>"/>
          </div>
      </div>
  </div>
</div>

<div class="ui-box">
	<?php
	if($machine_list) {
		?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr>
				<!--  <th class="cell-40">绑定手机号 <b>/<b> 账号</th>-->
				<th class="cell-25">终端号</th>
				<th class="cell-25">密钥</th>
				<th class="cell-25">最近修改时间</th>
				<th class="cell-15">当前状态</th>
				<th class="cell-25 text-right">操作</th>
			</tr>
			</thead>
			<tbody class="js-list-body-region">
			<?php foreach($machine_list as $list){ ?>
				<tr class="js-present-detail server_id" data-store-id="<?php echo $store_session['store_id'];?>" service_id="<?php echo $list['id']?>">
					
					<!--  <td><?php echo $list['mobile']?$list['mobile']:"暂无手机号"; ?> <b>/<b> <?php echo $list['username']?$list['username']:"暂无账号"; ?></td>-->
					<td>
						<?php echo $list['terminal_number'];?>
					</td>
					<td>
						<?php echo $list['keys'];?>
					</td>
					<td>
						<p class="text-left"><?php echo date('Y-m-d H:i:s', $list['timestamp']) ?></p>
					</td>

					<td>
						<?php if($list[is_open]==1){echo "<font class='zuangtai orderprint_black'>开启中</font>";} else{echo "<font class='zuangtai orderprint_red'>已关闭</font>";}?>
					</td>

					<td class="text-right js-operate server_id" data-store-id="<?php echo $store_session['store_id'];?>" service_id="<?php echo $list['id'] ?>">
						<?php
						if ($list['is_open']) {
							?>
							<span class="edit_span"><a href="#edit/<?php echo $list['id']?>" class="js-edit">编辑</a>
							<span>-</span></span>
							<a href="javascript:" class="js-disabled">使关闭</a>
							<span>-</span>
							<a href="javascript:void(0);" class="js-delete">删除</a>
						<?php
						} else {
							?>
							<a href="javascript:" class="js-able">去开启</a>
							<span>-</span>
							<a href="javascript:void(0);" class="js-delete">删除</a>
						<?php
						}
						?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>


		<div class="js-list-footer-region ui-box">
			<div>
				<div class="pagenavi js-page-list"><?php echo $pages;?></div>
			</div>
		</div>
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