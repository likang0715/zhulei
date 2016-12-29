<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all"  class="active">
			<a href="#list">分红规则</a>
		</li>
		<!-- <li id="js-list-nav-all" >
			<a href="#sendrules">奖金发放规则</a>
		</li> -->
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

.yjdx {width:90%;height:auto;display:inline-block}
.yjdx li{float:left;width:30%;height:25px;line-height:25px;}

.dbgz {width:100%;height:auto;display:inline-block}
.dbgz li{float:left;width:100%;height:40px;line-height:40px;}

.jjgz {width:100%;height:auto;display:inline-block}
.jjgz li{float:left;width:100%;height:40px;line-height:40px;}


.control-group.error .input-append .add-on, .control-group.error .input-prepend .add-on {
  color: #b94a48;
  background-color: #f2dede;
  border-color: #b94a48;
}
.form-horizontal .control-label{width:140px;}
.form-horizontal .controls{margin-left:155px;}
.ui-nav {
            border: none;
            background: none;
            position: relative;
            border-bottom: 1px solid #e5e5e5;
            margin-bottom: 15px;
        }
        .ui-nav ul {
            zoom: 1;
            margin-bottom: -1px;
            margin-left: 1px;
        }
        .ui-nav li {
            float: left;
            margin-left: -1px;
        }
        .ui-nav li a {
            display: inline-block;
            padding: 0 12px;
            line-height: 32px;
            color: #333;
            border: 1px solid #e5e5e5;
            background: #f8f8f8;
            min-width: 80px;
            text-align: center;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .ui-nav li.active a {
            font-size: 100%;
            border-bottom-color: #fff;
            background: #fff;
            margin: 0px;
            line-height: 32px;
        }
        .ui-table-order .content-row .aftermarket-cell, .ui-table-order .content-row .customer-cell, .ui-table-order .content-row .time-cell, .ui-table-order .content-row .state-cell, .ui-table-order .content-row .pay-price-cell {
            border-left: 1px solid #ccc;
        }
        .ui-table-order tr {
            border: none;
        }
        .ui-table-order tr {
            background: rgba(255,255,255,0.3);
            border-bottom: 1px solid #ccc;
        }
        .title-cell {
            border: none;
        }
        a.new-window {
            color: #4a4a4a;
        }
        #dt_1,#dt_2,#dt_3{
        	display: none;
        }
         .jjgz_team,.jjgz_team_desc{
        	display: none;
        }
</style>

<div class="app__content">
		<form class="js-page-form form-horizontal ui-form" method="POST" novalidate="novalidate">	
		
			<div class="control-group" style="border: 0px;margin-bottom: 0px;background:none;">
				<!-- <label class="control-label"><em class="required">*</em>依据对象</label> -->
				<label class="control-label">
					<nav class="ui-nav clearfix">
			            <ul class="pull-left">
			                <li class="<?php if($rules_info['dividends_type']==1 ){?>active<?php } ?> status-1" data-status="1">
			                <a href="#1">经销商</a>
							<input type="radio" name="dividends_type" id="dt_1" <?php if($rules_info['dividends_type']==1 ){?> checked="checked" <?php } ?> data-type="" value="1">
			                </li>
			                <li class="<?php if($rules_info['dividends_type']==2 ){?>active<?php } ?> status-2" data-status="2">
			                <a href="#2">分销团队</a>
							<input type="radio" name="dividends_type" id="dt_2" <?php if($rules_info['dividends_type']==2 ){?> checked="checked" <?php } ?> data-type="" value="2">
			                </li>
			                <li class="<?php if($rules_info['dividends_type']==3 ){?>active<?php } ?> status-3" data-status="3">
			                <a href="#3">独立分销商</a>
							
							<input type="radio" name="dividends_type" id="dt_3" <?php if($rules_info['dividends_type']==3 ){?> checked="checked" <?php } ?> data-type="" value="3">
			                </li>	 
			            </ul>
			        </nav>
				</label>
				
				<div class="controls" style="border-left: 0px;">
					<!-- <ul class="yjdx">
						<li>
							<input type="radio" name="dividends_type" <?php if($rules_info['dividends_type']==1 ){?> checked="checked" <?php } ?> data-type="" value="1">&nbsp;经销商
						</li>
						<li>
							<input type="radio" name="dividends_type" <?php if($rules_info['dividends_type']==2 ){?> checked="checked" <?php } ?> data-type="" value="2">&nbsp;分销团队
						</li>
						<li>
							<input type="radio" name="dividends_type" <?php if($rules_info['dividends_type']==3 ){?> checked="checked" <?php } ?> data-type="" value="3">&nbsp;独立分销商
						</li>
					</ul>
					<p class="help-desc">每个对象只有唯一一个分红规则</p>	 -->
				</div>
			</div>

			<div class="control-group">
				<label class="control-label"><em class="required">*</em>达标规则</label>
				<div class="controls">
					<ul class="dbgz">
						<li>
							<input type="radio" name="rule_type" <?php if($rules_info['rule_type']==1 ){?> checked="checked" <?php } ?> data-type="" value="1">&nbsp;规则1: &nbsp;<input type="text" id="rule1_month" name="rule1_month"  <?php if($rules_info['rule_type']==1 ){?>value="<?php echo $rules_info['month']?>" <?php } ?> placeholder="数字" style="width:25px;"> 月&nbsp; 进货交易额累计 <input type="text" id="rule1_money" name="rule1_money"  <?php if($rules_info['rule_type']==1 ){?>value="<?php echo $rules_info['money']?>"<?php } ?>  placeholder="请输入金额" style="width:60px;"> 元&nbsp;&nbsp;&nbsp;  <input type="checkbox" <?php if($rules_info['rule_type']==1 && $rules_info['is_bind'] == 1 ){?> checked="checked" <?php } ?>   class="js-check-toggle" id="rule1_is_bind" name="rule1_is_bind" value="1" >绑定规则3
						</li>
						
						<li>
							<input type="radio" name="rule_type" <?php if($rules_info['rule_type']==2 ){?> checked="checked" <?php } ?> data-type="" value="2">&nbsp;规则2: &nbsp;单月交易额达到 <input type="text" id="rule2_money" name="rule2_money" <?php if($rules_info['rule_type']==2 ){?>value="<?php echo $rules_info['money']?>"<?php } ?> placeholder="请输入金额" style="width:60px;"> 元 且保持 <input type="text" id="rule2_month" name="rule2_month" <?php if($rules_info['rule_type']==2 ){?>value="<?php echo $rules_info['month']?>"<?php } ?> placeholder="数字" style="width:25px;"> 月 &nbsp;&nbsp;&nbsp;<input type="checkbox" <?php if($rules_info['rule_type']==2 && $rules_info['is_bind'] == 1 ){?> checked="checked" <?php } ?> class="js-check-toggle" id="rule2_is_bind" name="rule2_is_bind" value="1">绑定规则3 &nbsp;&nbsp;&nbsp;<span class="help-desc">默认1个月</span>
						</li>
						

						<?php if($rules_info['dividends_type']==2 ){?>
							<li>
							<input type="radio" name="rule_type" <?php if($rules_info['rule_type']==3 ){?> checked="checked" <?php } ?> data-type="" value="3">&nbsp;规则3: &nbsp; <input type="text" id="rule3_month" name="rule3_month" value="<?php echo $rules_info['rule3_month']?>" placeholder="数字" style="width:25px;"> 月 新增分销商 <input type="text" id="rule3_seller_1" name="rule3_seller_1" value="<?php echo $rules_info['rule3_seller_1']?>" placeholder="数字" style="width:30px;"> 个
							</li>
						
						<?php }else{ ?>
							<li>
							<input type="radio" name="rule_type" <?php if($rules_info['rule_type']==3 ){?> checked="checked" <?php } ?> data-type="" value="3">&nbsp;规则3: &nbsp; <input type="text" id="rule3_month" name="rule3_month" value="<?php echo $rules_info['rule3_month']?>" placeholder="数字" style="width:25px;"> 月 发展下一级分销商 <input type="text" id="rule3_seller_1" name="rule3_seller_1" value="<?php echo $rules_info['rule3_seller_1']?>" placeholder="数字" style="width:30px;"> 个  发展下二级分销商 <input type="text" id="rule3_seller_2" name="rule3_seller_2" value="<?php echo $rules_info['rule3_seller_2']?>" placeholder="数字" style="width:30px;"> 个 
							</li>
						<?php } ?>
						


						<li class="help-desc" style="line-height: 30px;">规则3可独立也可绑定其他规则</li>
					</ul>	
				</div>
			</div>	
	
			<div class="control-group">
				<label class="control-label"><em class="required">*</em>奖金规则</label>
				<div class="controls">
					<ul class="jjgz">
						<li>
							<input type="radio" name="percentage_or_fix" <?php if($rules_info['percentage_or_fix']==1){?> checked="checked" <?php } ?> data-type="" value="1">&nbsp;周期内累计交易额的 <input type="text" id="percentage" name="percentage" value="<?php echo $rules_info['percentage']?>" placeholder="数字" style="width:25px;">%   &nbsp;<input type="radio" name="percentage_or_fix" <?php if($rules_info['percentage_or_fix']==2){?> checked="checked" <?php } ?> data-type="" value="2">固定值 <input type="text" id="fixed_amount" name="fixed_amount" value="<?php echo $rules_info['fixed_amount']?>" placeholder="请输入金额" style="width:60px;">
						</li>
						<li>
							<input type="checkbox" name="is_limit" id="is_limit" <?php if($rules_info['is_limit']==1){?> checked="checked" <?php } ?> class="js-check-toggle" value="1">本类型奖金分红额度上限 <input type="text" id="upper_limit" name="upper_limit" value="<?php echo $rules_info['upper_limit']?>" placeholder="请输入数字" style="width:60px;"> 元    &nbsp;&nbsp;&nbsp;<span class="help-desc">为0则不限制</span>
						</li>
						
					<?php if($rules_info['dividends_type']==2  && $rules_info['rule_type']==3 ){?>
						<li class="jjgz_team">
							<input type="checkbox" name="is_team_dividend" id="is_team_dividend" disabled="disabled"  checked="checked"  class="js-check-toggle" value="1" style="display: none;">团队所有者获取总奖金 100<input type="hidden" id="team_owner_percentage" name="team_owner_percentage" value="100" placeholder="数字" style="width:25px;">% <span class="help-desc">经销商 独立分销商 没有这条规则</span>
						</li>
					<?php }else{ ?>
						<li class="jjgz_team">
							<input type="checkbox" name="is_team_dividend" id="is_team_dividend" <?php if($rules_info['dividends_type']==2){?> checked="checked" <?php } ?> disabled="disabled" class="js-check-toggle" value="1" style="display: none;">团队所有者获取总奖金 <input type="text" id="team_owner_percentage" name="team_owner_percentage" value="<?php echo $rules_info['team_owner_percentage']?>" placeholder="数字" style="width:25px;">% 剩余由团队成员 交易额比例分成 &nbsp;&nbsp;&nbsp;<span class="help-desc">该规则只针对分销团队</span>
						</li>
					<?php } ?>
						

						<li class="help-desc jjgz_team_desc" style="line-height: 30px;">可设置0-100% 0则全部依据比例分成 100%则只给团长</li>
					</ul>	
				</div>
			</div>					

			<div class="form-actions">
				<input class="btn btn-primary js-btn-edit-save" type="button" value="保 存" data-loading-text="保 存...">
				<input type="hidden" value="<?php echo $rules_info['pigcms_id']?>" id="rules_id" >
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
