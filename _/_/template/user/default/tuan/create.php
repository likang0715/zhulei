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
</style>

<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有拼团</a>
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
			<a href="javascript:">添加拼团</a>
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
								<em class="required"> * </em>拼团名称：
							</label>
							<div class="controls">
								<input type="text" name="name" value="" id="name" placeholder="请填写活动名称" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>选择拼团商品：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product" data-product_id="0">
									<li><a href="javascript:;" class="add-goods js-add-picture">+产品</a>  </li>
								</ul>
							</div>
							<span style="padding-top: 5px; color: red;">
								备注：拼团开始时，请勿修改产品价格、库存规格信息。
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>开团时间段：
						</label>
						<div class="controls">
							<input type="text" name="start_time" value="" class="js-start-time Wdate" id="js-start-time" readonly style="cursor:default; background-color:white" />
							<span>至 </span>
							<input type="text" name="end_time" value="" class="js-end-time Wdate" id="js-end-time" readonly style="cursor:default; background-color:white" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"><em class="required"> *</em>开团设置：</label>
						<div class="reward-table-wrap">
							<table class="reward-table js-condition-table">
								<thead>
									<tr>
										<th width="26%" class="pl100">达标购买数量</th>
										<th width="26%" class="pl100">
											拼团折扣
											<span class="block-help">
												<a href="javascript:void(0);" class="js-help-notes">?</a>
												<span class="js-notes-cont hide">
													填写10以内的数字，只能有一位小数
												</span>
											</span>
										</th>
										<!-- <th width="26%" class="pl100">开始人数</th> -->
										<th width="100%" class="pl100">
											操作
											<span class="block-help">
												<a href="javascript:void(0);" class="js-help-notes">?</a>
												<span class="js-notes-cont hide">
													填写完成后，请点击新增
												</span>
											</span>
									</th>
									</tr>
								</thead>
								<!-- 默认的优惠条件，增加层级用 -->
								<tr style="text-align: center;">
									<td>
										<input type="text" name="number" value="" style="width: 100px;" class="js-number" />
									</td>
									<td>
										<input type="text" name="discount" value=""style="width: 100px;" class="js-discount" />
									</td>
									<!-- <td>
										<input type="text" name="start_number" value="" style="width: 100px;" class="js-start_number" />
									</td> -->
									<td>
										<a href="javascript:" class="js-condition-add">新增</a>
										
									</td>
								</tr>
								<tr class="js-condition js-condition-detail" style="text-align: center;">
									<td>1</td>
									<td>10</td>
									<td>-</td>
								</tr>
							</table>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">
							开团说明：
						</label>
						<div class="controls">
							<textarea rows="5" cols="55" style="width:65%" name="description" id="description" class="shuoming"></textarea>
							<em class="error-message"></em>
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
	})
	$('.popover-help-notes').live('hover', function(event) {
		if (event.type == 'mouseenter') {
			clearTimeout(t);
		} else {
			clearTimeout(t);
			hide();
		}
	})
})
function hide() {
	$('.popover-help-notes').remove();
}
</script>