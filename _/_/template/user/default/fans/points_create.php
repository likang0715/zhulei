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
					<input type="text" class="for-post input-mini" maxlength="30" name="give_points" value="">
				</div>
			</div>
		<div class="control-groups control-group">
			<div class="controls controlss" style="margin-left:0px;">
			
			<div class="control-group" >
				<label class="control-label"> 奖励条件：</label>
				<div class="controls first_line">
					<div class="radio">
						<label>
							<input class="checkbox" name="item_checkbox" value="1" type="radio">
							首次关注我的微信
						</label>
					</div>

					<div class="checkbox">
					   <label><input class="help-inline" type="checkbox" id="call_weixin" name="is_call_to_fans">给粉丝发送获得了积分的通知</label>
					</div>
				</div>
			</div>

			<div class="control-group" style="display:none">
				
				<div class="controls first_line">
					<div class="radio">
						<label>
							<input class="checkbox" name="item_checkbox" value="2" type="radio">
							每成功交易
							<input type="text" name="trade_limit" class="input-mini for-post" value=""> 笔
						</label>
					</div>
					<p class="hide help-block js-trade-limit-error"></p>
					<div class="checkbox">
					   <label><input class="help-inline" type="checkbox" id="call_trade" name="is_call_to_fans">给粉丝发送获得了积分的通知</label>
					</div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"> 奖励条件：</label>
				<div class="controls">
					<div class="radio">
						<label>
							<input class="checkbox" name="item_checkbox" value="3" type="radio">
							<span class="">购买金额</span>
							<input type="text" name="amount_limit" class="input-mini for-post" value=""> 元
						</label>
					</div>
					<p class="hide help-block js-amount-limit-error"></p>
					<div class="checkbox">
					   <label><input class="help-inline" type="checkbox" id="call_amount" name="is_call_to_fans">给粉丝发送获得了积分的通知</label>
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
		<input class="btn btn-primary js-btn-add-save" type="submit" value="保 存" data-loading-text="保 存...">
	</div>
</div>
</div>




</div>


			</form>
		</div>



	</div>
</div>