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
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有</a>
		</li>
		<li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
			<a href="#future">未开始</a>
		</li>
		<li id="js-list-nav-on" <?php echo $type == 'on' ? 'class="active"' : '' ?>>
			<a href="#on">进行中</a>
		</li>
		<li id="js-list-nav-end" <?php echo $type == 'end' ? 'class="active"' : '' ?>>
			<a href="#end">已结束</a>
		</li>
	</ul>
</nav>
<nav class="ui-nav clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="javascript:">新增活动</a>
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
								<em class="required"> * </em>活动名称：
							</label>
							<div class="controls">
								<input type="text" name="name" value="" id="name" placeholder="请填写名称" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">
							<input type="hidden" name="logopic" value="">
							<label class="control-label">
								<em class="required"> *</em>上传夺宝logo图片：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-logo">
									<!-- <li class="sort"><a href="javascript:void(0)" target="_blank"><img src=""></a><a class="js-delete-picture close-modal small hide">×</a></li> -->
									<li><a href="javascript:;" class="add-goods js-add-logo">选图片</a></li>
								</ul>
							</div>
						</div>
						<div class="control-group">
							<input type="hidden" name="product_id" value="0">
							<input type="hidden" name="sku_id" value="0">
							<label class="control-label">
								<em class="required"> *</em>选择夺宝商品：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product" data-product_id="0">
									<li><a href="javascript:;" class="add-goods js-add-picture">选商品</a></li>
								</ul>
							</div>
							<span style="padding-top: 5px; color: red;">
								备注：夺宝开始时，请勿修改产品价格、库存规格信息。
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>商品价格：
						</label>
						<div class="controls">
							<input type="text" name="price" value="0" style="width: 100px;" />
							<span style="padding-top: 5px; color: red;">
								价格必须输入整数。
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>夺宝价格：
						</label>
						<div class="controls">
							<input type="text" name="item_price" value="0" style="width: 100px;" />
							<span style="padding-top: 5px; color: red;">
								价格必须输入整数。
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>夺宝人次：
						</label>
						<div class="controls">
							<span class="total_num" style="margin-top:5px;float:left;">0</span>
							<span style="margin-top:5px;margin-left:20px;color:red;float:left;">自动计算，如果整除则取商，如果除不尽则取商+1 </span>
							<span style="margin-top:5px;margin-left:20px;color:red;float:left;" class="total_num_warn"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> </em>倒计时：
						</label>
						<div class="controls">
							<input type="text" name="opentime" value="3" style="width: 30px;" /> 分钟
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> </em>夺宝说明：
						</label>
						<div class="controls">
							<textarea rows="5" cols="55" style="width:65%" name="descript" class="descript"></textarea>
						</div>
					</div>
				</div>
			</form>

			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit" type="button" value="取 消" />
						<input class="btn btn-primary js-create-save" type="button" value="保 存" data-loading-text="保 存..." />
					</div>
				</div>
			</div>
		</div>
	</div>

</div>