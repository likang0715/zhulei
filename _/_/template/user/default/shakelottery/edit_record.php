<style>
.error-message {color:#b94a48;}
.hide {display:none;}
.error{color:#b94a48;}
.ui-timepicker-div .ui-widget-header {margin-bottom:8px; }
.ui-timepicker-div dl {text-align:left; }
.ui-timepicker-div dl dt {height:25px;margin-bottom:-25px; }
.ui-timepicker-div dl dd {margin:0 10px10px65px; }
.ui-timepicker-div td {font-size:90%; }
.ui-tpicker-grid-label {background:none;border:none;margin:0;padding:0; }
.controls .ico li .checkico {width: 50px;height: 54px;display: block;}
.controls .ico li .avatar {width: auto; height: auto;max-height: 50px;max-width: 50px;display: inline-block;}
.no-selected-style i {display: none;}
.icon-ok {background-position: -288px 0;}
.module-goods-list li img, .app-image-list li img {height: 100%;width: 100%;}
.tequan {width: 100%;min-height: 60px;line-height: 60px;}
.controls .input-prepend .add-on { margin-top: 5px;}
.controls .input-prepend input {border-radius:0px 5px 5px 0px}
.control-group table.reward-table{width:85%;}
.tequan li{float:left;width:30%;text-align:left;margin-left:3%;}
.form-horizontal .control-label{width:150px;}
.form-horizontal .controls{margin-left:0px;}
.controls  .renshu .add-on{margin-left:-3px;border-radius:0 4px 4px 0;}
.js-condition {height:35px;}
.controls .chose-label { height: 28px; line-height: 28px; float: left; margin-right: 20px; }
.laberA a.cur {background: #f35858;color: #fff;}
.huibao label{display: initial;}
#action_desc{float: left}
.align{    padding-top: 4px;}
</style>
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php   echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#lottery_list/all">所有</a>
		</li>
		<li id="js-list-nav-start" <?php echo $type == 'open' ? 'class="active"' : '' ?>>
			<a href="#lottery_list/open">开启</a>
		</li>
		<li id="js-list-nav-end" <?php   echo $type == 'close' ? 'class="active"' : '' ?>>
			<a href="#lottery_list/close">关闭</a>
		</li>
	</ul>
</nav>
<nav class="ui-nav clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="javascript:">编辑领取记录</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
	<div class="page-presale clearfix">
		<div class="app-presale app-reward">
			<form class="form-horizontal" id="myformaaaaaaa">
				<div class="presale-info">
					<div class="js-basic-info-region">
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>奖品名称：
							</label>
							<div class="controls">
								<p class="align"><?php echo $info['prizename']; ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>用户名称：
							</label>
							<div class="controls">
								<p class="align"><?php echo $info['wecha_name']; ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>手机号：
							</label>
							<div class="controls">
								<p class="align"><?php echo $info['phone']; ?></p>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>是否领取：
							</label>
							<div class="controls">
								<p class="align">
								<input type="radio" name="isaccept" value="1"   <?php echo $info['isaccept']==1 ? 'checked' : ''; ?>/>是&nbsp;
								<input type="radio" name="isaccept" value="0"   <?php echo $info['isaccept']==0 ? 'checked' : ''; ?>/>否
								</p>
							</div>
						</div>
					</div>
				</div>
				<input  type="hidden" name="aid" id="aid" value="<?php echo $info['aid']; ?>" />
				<input  type="hidden" name="recordid" id="recordid" value="<?php echo $info['recordid']; ?>" />
			</form>
			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit" type="button" value="取 消" />
						<input class="btn btn-primary js-create-save-record" type="button" value="保存" data-loading-text="保 存..." />
					</div>
				</div>
			</div>
		</div>
	</div>

</div>