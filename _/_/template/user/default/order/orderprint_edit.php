
<div class="app-design-wrap">
	<div class="app-design clearfix without-add-region">
		<div class="page-tradeincard">
			<nav class="ui-nav clearfix">
				<ul class="pull-left">
					<li id="js-list-nav-all" class="active">
						<a href="javascript:void(0)">
							修改订单打印机
						</a>
					</li>
				</ul>
			</nav>
			<div class="suggestion"><span class="sugicon"><span class="sugicon_tip"></span><span class="strong colorgorning2" style="margin-left:23px;">无线订单打印机（小票打印机）是指无需人工处理，有微信订单的时候会自动打印订单信息的小型打印机，</span><span style="color:#f00">如果背部没有终端号，我们称之为A打印机</span></span></div>
			<!-- ------------- --->
			<div class="js-page-form form-horizontal ui-form" >
				<!--  
				<div class="control-group">
					<label class="control-label"><em class="required">*</em>绑定手机号</label>
					<div class="controls">
						<input type="text" id="mobile" name="mobile" value="<?php echo $array['mobile'];?>" placeholder="请输入手机号" style="width:100px;">
						<p class="help-desc"> A打印机无需填写。</p>
					</div>
				</div>

				<div class="control-group">
					<!--  <label class="control-label">或</label>--
					<label class="control-label">绑定账号</label>
					<div class="controls">
						<div class="input-append">
							<input type="text" id="username" name="username" value="<?php echo $array['username']?>" placeholder="请输入账号" style="width:250px;">
						</div>
						<p class="help-desc"> A打印机填写。</p>
					</div>
				</div>
				-->
				<div class="control-group">
					<!--  <label class="control-label">或</label>-->
					<label class="control-label">终端号</label>
					<div class="controls">
						<div class="input-append">
							<input type="text" id="terminal_number" name="terminal_number" value="<?php echo $array['terminal_number'];?>" placeholder="请输入终端号" style="width:300px;">
						</div>
						<p class="help-desc">非A打印机底部查看 / A打印机点击打印机后面黑色小按钮查看 。</p>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">密钥</label>
					<div class="controls">
						<div class="input-append">
							<input type="text" id="keys" name="keys" value="<?php echo $array['keys']?>" placeholder="请输入密钥" style="width:300px;">
						</div>
						<p class="help-desc">非A打印机底部查看 / A打印机在注册页面查看 。</p>
					</div>
				</div>			

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>打印份数</label>
					<div class="controls">
						<div class="input-append">
							<input type="text" id="counts" name="counts" value="<?php echo $array['counts']?>" placeholder="请输入份数" style="width:80px;" maxlength="4">
						</div>
						<p class="help-desc"> 每个订单打印几份 。</p>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label"><em class="required">*</em>
						打印类型</label>
					<div class="controls">
						<ul class="dytype">
							<li><input type="radio" class="print_type" name="print_type" value="1" <?php if($array['type']==1){?>checked="checked"<?php }?>>&nbsp;只打印付过款的</li>
							<li><input type="radio" class="print_type" name="print_type" value="2" <?php if($array['type']==2){?>checked="checked"<?php }?>>&nbsp;无论是否付款都打印</li>
						</ul>	

					</div>
				</div>

				<div class="app-preview">
					<div class="app-header"></div>
					<div class="js-add-region"><div></div></div>
				</div>

				<div class="app-actions" style="bottom: 0px;">
					<div class="form-actions text-center">
						
						<input class="hide" type="hide" name="oid" value="<?php echo $array[id];?>">
						<input type="button" class="btn btn-defaults js-btn-return" value="返回上一页">
						<input class="btn btn-primary js-btn-edit-save" type="button" value="保 存" data-loading-text="保 存...">
						
					</div>
				</div>

			</div>
			<!-- -------------- -->
		</div>
	</div>
</div>




