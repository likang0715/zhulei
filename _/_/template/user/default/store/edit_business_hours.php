
<form class="form-horizontal" style=" margin-top:30px;">
<?php foreach($time_list as $v){?>
	<div class="control-group">
	<label class="control-label"><?php if(!$v['is_open']){?> 已关闭运营时间： <?php }else{ ?> 已运营时间： <?php } ?></label>
	<div class="controls">
			<ul>
				<li>
					<input type="text" value="<?php echo $v['start_time']?>" disabled style="border:none"/>
					<span> 至 </span>
					<input type="text" value="<?php echo $v['end_time']?>" disabled style="border:none"/>
				</li>
			
			</ul>
		</div>
	</div><?php } ?>
	
	<label class="control-label"> 运营时间： </label>
	<div class="controls">
		<ul>
			<li>
				<input type="text" value="<?php echo $info['start_time']?>" class="js-start-time Wdate business_time" readonly  style="cursor:default; background-color:white" />
				<span>至</span>
				<input type="text" value="<?php echo $info['end_time']?>" class="js-end-time Wdate business_time" readonly  style="cursor:default; background-color:white" />
			</li>
		</ul>
	</div>
	<div class="form-actions">
		<button type="button" class="ui-btn ui-btn-primary submit-edit" sid="<?php echo $info['id']?>">修改</button>
	</div>
</form>
<script type="text/javascript">
bindTimepicker();
 function bindTimepicker(){
	$('.js-start-time').each(function(){
		   $(this).timepicker();
		});
	$('.js-end-time').each(function(){
		   $(this).timepicker();
	});
	
}

</script>