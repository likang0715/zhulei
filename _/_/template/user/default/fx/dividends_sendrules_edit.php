<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all"  >
			<a href="#list">分红规则</a>
		</li>
		<li id="js-list-nav-all" class="active">
			<a href="#sendrules">奖金发放规则</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
<div class="app-design clearfix without-add-region"><div class="page-tradeincard">


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
.input-append .add-on, .input-append .btn, .input-append .btn-group{margin-left:-3px;}
 .avatar img{width:50px;height:50px;}

.ffgz {width:90%;height:auto;display:inline-block}
.ffgz li{float:left;width:100%;height:25px;line-height:25px;}


.control-group.error .input-append .add-on, .control-group.error .input-prepend .add-on {
  color: #b94a48;
  background-color: #f2dede;
  border-color: #b94a48;
}
.form-horizontal .control-label{width:140px;}
.form-horizontal .controls{margin-left:155px;}
.message-add a{
	font-size: 12px;
}
.message-container .message-item {
margin-bottom: 8px;
margin-top: 5px;
}
.message-container .message-item:last-of-type {
margin-bottom: 0;
}
.message-container input, .message-container select {
margin-right: 5px;
}
.message-container input, .message-container select, .message-container .remove-message {
vertical-align: middle;
display: inline-block;
}
.message-container .remove-message {
padding-top: 5px;
margin: 0 0 0 10px;
}

</style>

<div class="app__content">
		<form class="js-page-form form-horizontal ui-form" method="POST" novalidate="novalidate">	
		
			<div class="control-group">
				<label class="control-label">规则1</label>
				<div class="controls">
					<ul class="ffgz">
						<li>
							<input type="radio" name="send_rules_type" <?php if($send_rules['type']==1 ){?> checked="checked" <?php } ?>  data-type="" value="1">&nbsp;手动发放  
							&nbsp;&nbsp;&nbsp;<span class="help-desc"></span>
						</li>
					</ul>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">规则2</label>
				<div class="controls">
					<ul class="ffgz">
						<li>
							<input type="radio" name="send_rules_type" <?php if($send_rules['type']==2 ){?> checked="checked" <?php } ?>  data-type="" value="2">&nbsp;自动发放
							&nbsp;&nbsp;&nbsp;<span class="help-desc"></span><!-- 每月&nbsp;<input type="text" id="rules2_value" name="rules2_value"  placeholder="数字" style="width:25px;" <?php if($send_rules['type']==2 ){?> value="<?php echo $send_rules['rules'] ?>" <?php } ?> >&nbsp;号 &nbsp;&nbsp;统一发放奖金  &nbsp;&nbsp;&nbsp;<span class="help-desc">每月几号发放奖金</span> -->
						</li>
					</ul>
				</div>
			</div>
			

			<!-- <div class="control-group">
				<label class="control-label">规则3</label>
				<div class="controls">
					<ul class="ffgz">
						<li>
							<input type="radio" name="send_rules_type" <?php if($send_rules['type']==3 ){?> checked="checked" <?php } ?>  data-type="" value="3">&nbsp;限额发放&nbsp;&nbsp;&nbsp;&nbsp;<span class="message-add"><a href="javascript:;" class="js-add-message control-action">+ 添加批次</a></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="help-desc">发放分批次</span>  
						</li>
					</ul>
					<div class="help-desc">奖金统计后，定时和定额发放 (当月最后一次发放，所有的剩余奖金)</div>
					
					<div class="js-message-container message-container">
						<?php
							if($send_rules['type'] == 3 && !empty($send_rules['rules'])){
								$ruleslist = unserialize($send_rules['rules']);
								$str = '';
								foreach ($ruleslist as $key => $value) {
									$str .= '<div class="message-item">每月 <input type="text" name="rules3_day" value="'.$value['rules3_day'].'" class="input-mini message-input rules3_day" maxlength="2"> 号 发放 <input type="text" name="rules3_percent" value="'.$value['rules3_percent'].'" class="input-mini message-input rules3_percent" maxlength="3"> %<a href="javascript:;" class="js-remove-message remove-message">删除</a></div>';
								}
								echo $str;
							}
						?>
						
					</div>
					
				</div>
			</div> -->

			<div class="form-actions">
				<input class="btn btn-primary js-btn-rulesedit-save" type="button" value="保 存" data-loading-text="保 存...">
				<input type="button" class="btn btn-defaults js-btn-quit" value="返回" >
			</div>
		</form>
	</div>
</div>
</div>
</form>
</div>
</div>
</div>
