<div class="events_list_main">
	<div class="events_list_main_con">
		<?php if(!empty($events)){ ?>
		<ul>
			<?php foreach($events as $value){ ?>
			<?php $array = explode(',', $value['images']); ?>
			<li>
				<div class="events_list_information">
					<span class="events_create"><?php echo date('Y年m月d日',$value['last_time']);?>更新</span>
				</div>
				<a target="_blank" href="./wap/chahui_show.php?id=<?php echo $value['pigcms_id'];?>&store_id=<?php echo $value['store_id'];?>"><img class="events_thumb" src="upload/<?php echo $array[0];?>"></a>
				<h3><?php echo $value['name'];?></h3>
				<div class="events_list_des">
					<span class="events_date"><?php echo date('Y-m-d',$value['sttime']);?>至<?php echo date('m-d',$value['endtime']);?></span>
					<span class="events_ticket"><?php if($value['tickets']==1){echo '免费';}else{ echo $value['price'].'元/人';}?></span>
				</div>
				<div class="events_list_op">
					<label>
						<a href="#edit/<?php echo $value['pigcms_id'];?>" class="js-load-page"><span class="events_edit hint--top hint--no-animate" data-hint="编辑" data-num="2"></span></a>
						<a href="javascript:;" class="js-delete" data-id="<?php echo $value['pigcms_id'];?>"><span class="events_delete hint--top hint--no-animate" data-hint="删除" data-num="<?php echo $value['pigcms_id'];?>"></span></a>
						<a href="<?php dourl('events:result');?>&id=<?php echo $value['pigcms_id'];?>"><span class="events_results hint--top hint--top4 hint--no-animate" data-hint="报名情况" data-num="<?php echo $value['pigcms_id'];?>"><i><?php if($value['audit']) echo $value['audit'];?></i></span></a>
					</label>
				</div>
			</li>
			<?php } ?>
		</ul>
		<?php }else{ ?>
		<div class="js-list-empty-region">
			<div class="no-result widget-list-empty">还没有相关数据。</div>
		</div>
		<?php } ?>
	</div>
	<?php if ($pages) {
		?>
		<table align="center">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<td colspan="5">
						<div class="pagenavi js-present_list_page" id="pages">
							<span class="total"><?php echo $pages ?></span>
						</div>
					</td>
				</tr>
			</thead>
		</table>
		<?php
	}
	?>
</div>