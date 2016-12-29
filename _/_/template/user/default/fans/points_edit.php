<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all"  class="active">
			<a href="<?php dourl('points');?>">所有积分规则</a>
		</li>

	</ul>
</nav>
<div class="app-design-wrap">
<div class="app-design clearfix without-add-region">

<div class="page-tradeincard">


<style>
	.app-fans-points-edit .checkbox {
	  color: #999;
	  margin-left: 16px;
	}
	button, input, label, select, textarea {
		font-size: 14px;
		font-weight: 400;
		line-height: 20px;
		font-family:Helvetica,STHeiti,"Microsoft YaHei",Verdana,Arial,Tahoma,sans-serif;
	}
</style>

<div class="app__content app-fans-points-edit">
		<form class="js-page-form form-horizontal" method="POST" novalidate="novalidate">
			<div class="control-group">
				<label class="control-label"><em class="required">*</em> 奖励分值： </label>
				<div class="controls">
					<input type="text" class="for-post input-mini" maxlength="30" name="give_points" value="<?php echo $points['points'];?>">
				</div>
			</div>
		<div class="control-groups control-group">
			<div class="controls controlss" style="margin-left:0px;">
			<div class="control-group" style="display:">
				<label class="control-label"> 奖励条件：</label>
				<div class="controls first_line">
					<div class="radio">
						<label>
							<input class="checkbox" name="item_checkbox" value="1" type="radio" <?php if($points['type']=='1'){?>checked="checked"<?php }?>>
							首次关注我的微信
						</label>
					</div>

					<div class="checkbox">
					   <label><input class="help-inline" type="checkbox" id="call_weixin" name="is_call_to_fans" <?php if($points['type']=='1'){?><?php if($points['is_call_to_fans']=='1'){echo "checked='checked'";}?> <?php }?>>给粉丝发送获得了积分的通知</label>
					</div>
				</div>
			</div>

			<div class="control-group" style="display:none">
				<label class="control-label"> 奖励条件：</label>
				<div class="controls first_line">
					<div class="radio">
						<label>
							<input class="checkbox" name="item_checkbox" value="2" type="radio" <?php if($points['type']=='2'){?>checked="checked"<?php }?>>
							成功交易
							<input type="text" name="trade_limit" class="input-mini for-post" <?php if($points['type']=='2'){?>value="<?php echo $points['trade_or_amount'];?>" <?php }?>> 笔
						</label>
					</div>
					<p class="hide help-block js-trade-limit-error"></p>
					<div class="checkbox">
					   <label><input class="help-inline" type="checkbox" id="call_trade" name="is_call_to_fans" <?php if($points['type']=='2'){?><?php if($points['is_call_to_fans']=='1'){echo "checked='checked'";}?> <?php }?>>给粉丝发送获得了积分的通知</label>
					</div>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<div class="radio">
						<label>
							<input class="checkbox" name="item_checkbox" value="3" type="radio" <?php if($points['type']=='3'){?>checked="checked"<?php }?>>
							<span class="">购买金额</span>
							<input type="text" name="amount_limit" class="input-mini for-post" <?php if($points['type']=='3'){?>value="<?php echo $points['trade_or_amount'];?>" <?php }?>> 元
						</label>
					</div>
					<p class="hide help-block js-amount-limit-error"></p>
					<div class="checkbox">
					   <label><input class="help-inline" type="checkbox" id="call_amount" name="is_call_to_fans" <?php if($points['type']=='3'){?><?php if($points['is_call_to_fans']=='1'){echo "checked='checked'";}?> <?php }?>>给粉丝发送获得了积分的通知</label>
					</div>
				</div>
			</div>
			</div>
		</div>
			<!-- <div class="control-group">
				<div class="controls">（通知发送时段：8:00 ~ 22:00）</div>
			</div> -->

			<div class="control-group">
				<div class="controls">
					<div class="js-select-error"></div>
				</div>
			</div>


		</form>
	</div>



<div class="app-actions" style="bottom: 0px;">
	<div class="form-actions text-center">
		<input class="btn js-btn-quit" type="button" value="返回">
		<input type="hidden" value="<?php echo $points['id']?>" id="points" >
		<input class="btn btn-primary js-btn-edit-save" type="submit" value="保 存" data-loading-text="保 存...">
	</div>
</div>
</div>




</div>


			</form>
		</div>



	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('.js-help-notes').hover(function() {
			var content = $(this).next('.js-notes-cont').html();
			$('.popover-help-notes').remove();
			var html = '<div class="js-intro-popover popover popover-help-notes right" style="display: none; top: ' + ($(this).offset().top - 27) + 'px; left: ' + ($(this).offset().left + 16) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p>' + content + '</p> </div></div></div>';
			$('body').append(html);
			$('.popover-help-notes').show();
		},
		function() {
			t = setTimeout('hide()', 200);
		}) $('.popover-help-notes').live('hover',
		function(event) {
			if (event.type == 'mouseenter') {
				clearTimeout(t);
			} else {
				clearTimeout(t);
				hide();
			}
		})
	}) function hide() {
		$('.popover-help-notes').remove();
	}
</script>