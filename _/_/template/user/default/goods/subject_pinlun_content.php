<script type="text/javascript">
	var comment_groups_json = '<?php echo $comment_groups_json; ?>';
</script>
<style type="text/css">
	.red {
		color: red;
	}
</style>
<div class="goods-list">
	<div class="js-list-filter-region clearfix ui-box" style="position: relative;display:none">
		<div>
			<h3 class="list-title js-goods-list-title">评价商品列表</h3>
			<div class="ui-block-head-help soldout-help js-soldout-help hide" style="display: block;">
				<a href="javascript:void(0);" class="js-help-notes" data-class="right"></a>
				<div class="js-notes-cont hide">
					<p>当评价的商品未删除时，将会在下表中显示</p>
				</div>
			</div>
			<div class="js-list-tag-filter ui-chosen" style="width: 200px;">

			</div>
			<!--
			<div class="js-list-search ui-search-box">
				<input class="txt" type="text" placeholder="搜索" value="">
			</div>-->
		</div>
	</div>
	<div class="ui-box">
		<table class="ui-table ui-table-list" style="padding: 0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 601.5px; z-index: 1; width: 850px;">
		   
			<tr>
			 
				<th class="checkbox cell-35" colspan="2" style="min-width: 200px; max-width: 200px;">
					<label class="checkbox inline"><input type="checkbox" class="js-check-all-subject_pinlun">评论内容</label>
				</th>
				<th class="cell-8 text-center" style="min-width: 200px; max-width: 200px;">
					<a href="javascript:;" class="orderby" data-orderby="quantity">评论的专题</a>
				</th>
				<th class="cell-8 text-center" style="min-width: 68px; max-width: 68px;">
					<a href="javascript:;" class="orderby" data-orderby="sort">客户信息<span class="orderby-arrow desc"></span></a>
				</th>

				<th class="cell-12 text-center" style="min-width: 95px; max-width: 95px;">
					<a href="javascript:;" class="orderby" data-orderby="date_added">评论时间</th>
			   
			   <th class="cell-8 text-center" style="min-width: 80px; max-width: 80px;">
					<a href="javascript:;" class="orderby" data-orderby="sales">显示状态</a>
				</th>
				<th class="cell-15 text-center" style="min-width: 95px; max-width: 95px;">操作</th>
			</tr>

			</thead>
			<tbody class="js-list-body-region">
		 <?php if (!empty($array)) { ?>
			<?php } ?>
			<?php 
			if(is_array($array)) {
			foreach ($array as $k=>$v) { ?>
				<tr data-plid="<?php echo $v['id']; ?>">
					<td class="checkbox">
						<input type="checkbox" class="js-check-toggle" value="<?php echo $v['id']; ?>" />
					</td>

					<td>
						<div> 
							<?php echo $v['content'];?>
						</div>
					</td>
					<td class="text-center">
						<?php if($subject_datas[$v['subject_id']]) {?>
							<?php echo $subject_datas[$v['subject_id']]['name']?>
						<?php }?>
					
					</td>

					
					<td class="goods-image-td">
						<div class="goods-image js-goods-image ">
							<img width="50" height="50" src="<?php echo $user_datas[$v['uid']]['avatar'];?>" />
							<br/><?php echo $user_datas[$v['uid']]['nickname'];?>(ID:<?php echo $user_datas[$v['uid']]['uid'];?>)
						</div>
					</td>
					
					
					
					

					<td class="text-center">
						<a class="js-change-nums" href="javascript:void(0);"><?php echo date('Y-m-d', $v['timestamp']); ?></a>
						<input class="input-mini js-change-nums" type="number" min="0" maxlength="8" style="display: none;" data-id="<?php echo $comment['comment_id']; ?>" value="<?php echo $comment['sort']; ?>">
					</td>
					<td class="text-center zt">
						<a <?php if(option('config.is_allow_comment_control') == 1) { ?>class="js-change-num"<?php }?> href="javascript:void(0);">
							<?php if($v['is_show'] == 1) {?>
								显示
							<?php } else {?>
								<font color="#f00">隐藏</font>
							<?php }?>	
							</a>

					</td>					
					<td class="text-right">
						<p>
							<?php if($v['is_show'] == 1) {?>
								<a href="javascript:void(0);" class="js-subject_pinlun-disabled">使隐藏</a><span></span>
							<?php }else {?>
								<a href="javascript:void(0);" class="js-subject_pinlun-disabled">使显示</a><span></span>
							<?php }?>
								- 
							<a href="javascript:void(0);" class="js-subject_pinlun-delete" data="<?php echo $comment['id']; ?>">删除</a><span></span>
						</p>
					</td>
				</tr>
			<?php } }?>
			</tbody>
		</table>
		<?php if (empty($array)) { ?>
		<div class="js-list-empty-region"><div><div class="no-result">还没有相关数据。</div></div></div>
		<?php } ?>
	</div>
	<div class="js-list-footer-region ui-box">
		<?php if (!empty($array)) { ?>
		<div>
			<div class="pull-left">
				<!--  <a href="javascript:;" class="ui-btn js-subject-batch_pinlun-disabled">隐藏</a>-->
				<a href="javascript:;" class="ui-btn js-subject-batch_pinlun-delete">删除</a>
			</div>
			<div class="js-page-list ui-box pagenavi"><?php echo $pages;?></div>
		</div>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.js-help-notes').hover(function() {
			var content = $(this).next('.js-notes-cont').html();
			$('.popover-help-notes').remove();
			var html = '<div class="js-intro-popover popover popover-help-notes right" style="display: none; top: ' + ($(this).offset().top - 27) + 'px; left: ' + ($(this).offset().left + 16) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p>' + content + '</p> </div></div></div>';
			$('body').append(html);
			$('.popover-help-notes').show();
		}, function() {
			t = setTimeout('hide()', 200);
		})

		$('.popover-help-notes').live('hover', function(event){
			if (event.type == 'mouseenter') {
				clearTimeout(t);
			} else {
				clearTimeout(t);
				hide();
			}
		})
	})
	function hide() {
		$('.popover-help-notes').remove();
	}
	

</script>