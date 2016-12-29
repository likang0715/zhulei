						<!-- ▼ Main container -->
							
						
						<div class="widget-list">
						  <div style="position:relative;" class="js-list-filter-region clearfix ui-box">
							  <div>
								  <a class="ui-btn ui-btn-primary" href="#create">发布图文专题</a>
								  <!--  <a class="ui-btn ui-btn-primary2 downloadtag" target="_blank" href="<?php echo dourl("tag_download_csv");?>"></a>-->
								  <div class="js-list-search ui-search-box">
									 <!--   <input type="text" value="<?php echo $keyword;?>" placeholder="搜索" class="txt js-coupon-keyword">-->
								  </div>
							  </div>
						  </div>
						</div>
						<style>
						.ui-table-list .fans-box .fans-avatar {float: left;width: 60px;height: 60px;background: #eee;overflow: hidden;}
						.ui-table-list .fans-box .fans-avatar img {width: 60px;height: auto;}
						.ui-table-list .fans-box .fans-msg {float: left;}
						.ui-table-list .fans-box .fans-msg p {padding: 0 5px;text-align: left;}
						</style>
						<!-- ▼ Main container -->
					
						
						
						
						
<div class="ui-box">
	<?php
	if($tag_list) {
		?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr class="widget-list-header"><th class="cell-20 text-left">
					标题
				</th>

				<th class="cell-10">
					图片
				</th>
				<th class="cell-10">
					分类
				</th>
				<th class="cell-10" align="center">
					点赞数
				</th>
				<th class="cell-10" align="center">
					分享数
				</th>				
				<th class="cell-10" align="center">
					评论数
				</th>
				<th class="cell-10">
					发布时间
				</th>
				<th class="cell-10"  align="right">
					操作
				</th>

			</tr>
			</thead>
			<tbody class="js-list-body-region">
			<?php if(count($subject_list)) {?>
				<?php foreach($subject_list as $v){ ?>
					<tr class="widget-list-item">
	
						<td><?php echo $v['name'];?></td>
						<td><img width="50" height="50" src="<?php echo $v['pic']?>"></td>
						
						<td><?php if($subtype_list[$v['subject_typeid']]) { echo $subtype_list[$v['subject_typeid']]['typename'];} else {echo "分类已删";}?> <?php if($subtype_list['subject_type']) {if($subtype_list[$v['subject_typeid']]['status']=='0'){?>(<font color='#f00'>已关闭</font></font>)<?php }}?></td>
						<td align="center">
							
							<?php if($store_subject_data[$v['id']]) {?>
								<?php echo $store_subject_data[$v['id']]['dz_count'];?>
							<?php } else {?>
									暂无数据
							<?php }?>
							
						</td>
						<td align="center">
							<?php if($store_subject_data[$v['id']]) {?>
								<?php echo $store_subject_data[$v['id']]['share_count'];?>
							<?php } else {?>
									暂无数据
							<?php }?>
						</td>
						<td align="center">
							<?php if($store_subject_data[$v['id']]) {?>
								<?php echo $store_subject_data[$v['id']]['pinlun_count'];?>
							<?php } else {?>
									暂无数据
							<?php }?>
						</td>
						<td><?php echo date("Y-m-d H:i", $v['timestamp']);?></td>
						<td align="right">
							
							<a href="#edit/<?php echo $v['id']?>"  class="js-edit">编辑</a>
							<span>-</span>
							<a href="javascript:void(0);" data="<?php echo $v['id']?>" class="js-subject-delete">删除</a>
						</td>
					</tr>
				<?php } ?>
			<?php } else {?>
				<tr><td  colspan="8" align="center"><div class="js-list-empty-region">暂无内容！</div></td></tr>
			<?php }?>
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