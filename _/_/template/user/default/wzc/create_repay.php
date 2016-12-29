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
		<li id="js-list-nav-apply" <?php echo $type == 'apply' ? 'class="active"' : '' ?>>
			<a href="#apply">申请中</a>
		</li>
		<li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
			<a href="#future">预热中</a>
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
			<a href="javascript:">新增回报设置</a>
		</li>
	</ul>
</nav>
<style type="text/css">
.laberA a.cur {background: #f35858;color: #fff;}
.huibao label{display: initial;}
#productDetails{float: left}
</style>
<div class="app-design-wrap">
	<div class="page-presale clearfix">
		<div class="app-presale app-reward">
			<form class="form-horizontal" id="myformaaaaaaa">
				<div class="presale-info">
					<div class="js-basic-info-region">
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>回报类别：
							</label>
							<div class="controls">
								<div class="huibao">
									<label for="redoundType1">实物回报</label>
									<input id="redoundType1" type="radio" name="redoundType" value="1"  checked="" />
									<label for="redoundType0">虚拟物品回报</label>
									<input id="redoundType0"  type="radio" name="redoundType" value="0"    />
								</div>

							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>是否为抽奖档：
							</label>
							<div class="controls">
								<div class="huibao">
									<label for="raffleType1">是</label>
									<input id="raffleType1" type="radio" name="raffleType" value="1"   id="" />&nbsp;&nbsp;
									<label for="raffleType0">否</label>
									<input id="raffleType0"  type="radio" name="raffleType" value="0"   checked="" />
								</div>
							</div>
						</div>
						<div class="control-group guize1" style="display: none;">
							<label class="control-label">
								<em class="required"> * </em>抽奖规则：
							</label>
							<div class="controls">
								<div class="huibao">
									<input id="rar0" type="radio" name="raffleRule" value="0"  checked="" />
									<label for="rar0">
									每满&nbsp;<input id="raffleBase" type="text" name="raffleBase" value="0"  style="width: 50px;" />&nbsp;位支持者抽取1位幸运用户，不满足时也抽取1位。幸运用户将会获得&nbsp;<input id="raffleReword" type="text" name="raffleReword" value=""  style="width: 120px;" />
									</label>
								</div>
							</div>
						</div>
						<div class="control-group guize2" style="display: none;">
							<label class="control-label">
								<em class="required"></em>
							</label>
							<div class="controls">
								<div class="huibao">
									<input id="rar1" type="radio" name="raffleRule" value="1"   />
									<label for="rar1">
									将从所有支持者中抽取<input id="luckyCount" type="text" name="luckyCount" value="0" disabled="true" style="width: 50px;" />&nbsp;位幸运用户。幸运用户将会获得&nbsp;<input id="luckyReword" type="text" name="luckyReword" value=""  style="width: 120px;" disabled="true"/>
									</label>
								</div>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>回报档位：
							</label>
							<div class="controls">
								<div class="huibao">
									<label for="platform0">普通</label>
									<input id="platform0" type="radio" name="platform" value="0"  checked=""  />
									<label for="platform1">手机优惠</label>
									<input id="platform1"  type="radio" name="platform" value="1"   />
									<label for="platform2">手机专享</label>
									<input id="platform2"  type="radio" name="platform" value="2"   />
									<em class="error-message">*1.普通档：电脑端和手机上均显示且价格相同。2.手机优惠：手机端的价格比电脑端便宜。3.手机专享：只有在手机端才有的档位。</em>
								</div>
							</div>
						</div>
						<div class="control-group amount">

							<label class="control-label">
								<em class="required"> * </em>支持金额：
							</label>
							<div class="controls">
								<input type="text" name="amount" value="" id="amount" placeholder="0" style="width: 80px;" />元
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group mamount" style="display: none;">
							<label class="control-label">
								<em class="required"> * </em>手机端金额：
							</label>
							<div class="controls">
								<input type="text" name="mamount" value="" id="mamount" placeholder="0" style="width: 80px;" />元
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>回报内容：
							</label>
							<div class="controls">
								<textarea rows="4" cols="30" style="width:65%" name="redoundContent" class="descript" id="redoundContent"></textarea>
							</div>
						</div>
						<!-- 说明图片 -->
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>上传说明图片：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-logo">
									<li>
									<a href="javascript:;" class="add-goods js-add-logo" className="images">上传</a>
									<input type="hidden" name="images" value="" id="images">
									</li>
								</ul>
								<em class="error-message">大小： 600*600</em>
							</div>
						</div>
						<!-- 是否设置抢购 -->
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>是否设置抢购：
							</label>
							<div class="controls">
								<div class="huibao">
									<label for="scrambleStatus0">否</label>
									<input id="scrambleStatus0" type="radio" name="scrambleStatus" value="0"  checked=""  />
									<label for="scrambleStatus1">是</label>
									<input id="scrambleStatus1"  type="radio" name="scrambleStatus" value="1"   />
								</div>
							</div>
						</div>
						<div class="control-group">

							<label class="control-label">
								<em class="required"> * </em>限定名额：
							</label>
							<div class="controls">
								<input type="text" name="limits" value="" id="limits" placeholder="0" style="width: 80px;" />
								<em class="error-message">“0”为不限名额</em>
							</div>
						</div>
						<div class="control-group">

							<label class="control-label">
								<em class="required"> * </em>运费：
							</label>
							<div class="controls">
								<input type="text" name="freight" value="" id="freight" placeholder="0" style="width: 80px;" />&nbsp;元
								<em class="error-message">“0”为包邮</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>是否可开发票：
							</label>
							<div class="controls">
								<div class="huibao">
									<label for="invoiceStatus0">不可开发票</label>
									<input id="invoiceStatus0" type="radio" name="invoiceStatus" value="0"  checked=""  />
									<label for="invoiceStatus1">可开发票</label>
									<input id="invoiceStatus1"  type="radio" name="invoiceStatus" value="1"   />
								</div>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>填写备注信息：
							</label>
							<div class="controls">
								<div class="huibao">
								<label for="remarkStatus1">是</label>
								<input id="remarkStatus1"  type="radio" name="remarkStatus" value="1"   />
								<input type="text" name="remark" value="" id="remark" placeholder="请输入备注校验信息，例如：请填写您需要的颜色，尺寸等" style="width: 400px;" />&nbsp;
								</div>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> </em>
							</label>
							<div class="controls">
								<div class="huibao">
								<label for="remarkStatus0">否</label>
								<input id="remarkStatus0" type="radio" name="remarkStatus" value="0"  checked=""  />
								</div>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>回报时间：
							</label>
							<div class="controls">
								项目结束后&nbsp;<input type="text" name="redoundDays" value="" id="redoundDays" placeholder="0" style="width: 80px;" />&nbsp;天，将会向支持者发送回报
							</div>
						</div>
				</div>
				<input  type="hidden" name="optType" id="optType" value="add" />
				<input  type="hidden" name="repay_id" id="repay_id" value="0" />
			</form>
			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit-repay" type="button" value="取 消" url="#repaylist/<?php  echo $id; ?>"/>
						<input class="btn btn-primary js-create-save-repay" type="button" value="保存" data-loading-text="保 存..." proId="<?php echo $id; ?>"  to="false"  url="#repaylist/<?php echo $id; ?>"/>
						<input class="btn btn-primary js-create-save-repay-to" type="button" value="保存并继续添加" data-loading-text="保 存..." proId="<?php echo $id;  ?>" to="true"  url="#create_repay/<?php echo $id; ?>"/>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>