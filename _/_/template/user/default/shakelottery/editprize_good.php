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
			<a href="javascript:">设置实物奖品</a>
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
							<input type="hidden" name="product_id" value="<?php echo $prizeInfo['product_id'];  ?>">
							<input type="hidden" name="sku_id" value="<?php echo $prizeInfo['sku_id'];  ?>">
							<input type="hidden" name="aid" value="<?php echo $prizeInfo['aid'];  ?>">
							<input type="hidden" name="prize_id" value="<?php echo $prizeInfo['id'];  ?>">
							<input type="hidden" name="prizeimg" value="<?php echo $prizeInfo['prizeimg']; ?>">
							<label class="control-label">
								<em class="required"> *</em>选择实物商品：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product" data-product_id="0">
									<li class="sort" data-pid="<?php  echo $prizeInfo['product_id'];  ?>" data-skuid="<?php  echo $prizeInfo['sku_id'];  ?>">
									<a href="<?php echo option('config.site_url'); ?>/goods/<?php  echo $prizeInfo['product_id'];  ?>.html"  target="_blank" disabled="">
									<img data-pid="<?php  echo $prizeInfo['product_id'];  ?>" alt="<?php  echo $prizeInfo['prizename'];  ?>" title="<?php  echo $prizeInfo['prizename'];  ?>" src="<?php  echo $prizeInfo['prizeimg'];  ?>" disabled="">
									</a>
									<li style="display: none;"><a href="javascript:;" class="add-goods js-add-picture">选商品</a></li>
								</ul>
							</div>
							<span style="padding-top: 5px; color: red;">
								备注：抽奖开始时，请勿修改库存等信息。
							</span>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>奖品名称：
							</label>
							<div class="controls">
								<input type="text" name="prizename" value="<?php echo $prizeInfo['prizename'];  ?>" id="prizename" placeholder="请填写名称" style="width: 300px;" disabled=""/>
							<span style="padding-top: 5px; color: red;">
								禁止修改
							</span>
							</div>
						</div>
					</div>
					<div class="control-group sku" style="display: block;">
						<label class="control-label">
							<em class="required"> *</em>库存数量：
						</label>
						<div class="controls">
							<input type="text" name="skunub" style="width: 100px;" disabled="" value="<?php echo $prizeInfo['quantity']; ?>" />
							<span style="padding-top: 5px; color: red;">
								禁止修改
							</span>
						</div>
					</div>
					<div class="control-group sku" style="display: block;">
						<label class="control-label">
							<em class="required"> *</em>奖品消耗数量：
						</label>
						<div class="controls">
							<input type="text" name="expendnum" style="width: 100px;" disabled="" value="<?php echo $prizeInfo['expendnum']; ?>" />
							<span style="padding-top: 5px; color: red;">
								禁止修改
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>奖品数量：
						</label>
						<div class="controls">
							<input type="text" name="prizenum" value="<?php echo $prizeInfo['prizenum'];  ?>" style="width: 100px;" />
							<span style="padding-top: 5px; color: red;">
								奖品数量不能大于商品库存数量
							</span>
						</div>
					</div>
				</div>
			</form>

			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit-prize" type="button" value="取 消" />
						<input class="btn btn-primary js-create-save-good" type="button" value="保 存" data-loading-text="保 存..." />
					</div>
				</div>
			</div>
		</div>
	</div>

</div>