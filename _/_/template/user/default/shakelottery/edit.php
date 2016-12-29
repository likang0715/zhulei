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
			<a href="javascript:">新增活动</a>
		</li>
	</ul>
</nav>
<style type="text/css">
.laberA a.cur {background: #f35858;color: #fff;}
.huibao label{display: initial;}
#action_desc{float: left}
</style>
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
								<input type="text" name="info[action_name]" value="<?php echo $lotteryInfo['action_name']; ?>" id="action_name" placeholder="请填写活动名称" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>活动简介：
							</label>
							<div class="controls">
							<script id="action_desc" name="info[action_desc]" type="text/plain"></script>
							</div>
						</div>
						<script>
						var uf = UE.getEditor('action_desc',{
						    initialFrameWidth:600,
						    initialFrameHeight:200
						});
						</script>
						<div class="control-group">

							<label class="control-label">
								<em class="required"></em>自定义分享标题：
							</label>
							<div class="controls">
								<input type="text" name="info[custom_sharetitle]" value="<?php echo $lotteryInfo['custom_sharetitle']; ?>" id="custom_sharetitle" placeholder="请填写自定义分享标题" style="width: 300px;" />
								<em class="error-message">不填则默认为：我正在参加“xxx”活动，摇手机轻松赢取丰厚奖品！</em>
							</div>
						</div>
						<div class="control-group">

							<label class="control-label">
								<em class="required"></em>自定义分享描述：
							</label>
							<div class="controls">
								<input type="text" name="info[custom_sharedsc]" value="<?php echo $lotteryInfo['custom_sharedsc']; ?>" id="custom_sharedsc" placeholder="请填写自定义分享描述" style="width: 300px;" />
								<em class="error-message">分享朋友圈或者分享给朋友时标题下面显示的描述！</em>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label">
								<em class="required"> </em>自定义分享图片：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-logo">
									<?php if(!empty($lotteryInfo['reply_pic'])){ ?>
									<li class="sort">
									<a href="javascript:void(0)" target="_blank"><img src="<?php echo getAttachmentUrl($lotteryInfo['reply_pic']); ?>"></a>
									<a class="js-delete-picture close-modal small hide">×</a>
									</li>
									<?php } ?>
									<li style="display: <?php echo !empty($lotteryInfo['reply_pic']) ? 'none' : 'block'; ?>;">
									<a href="javascript:;" class="add-goods js-add-logo" classname="reply_pic">上传</a>
									<input type="hidden" name="reply_pic" value="<?php echo getAttachmentUrl($lotteryInfo['reply_pic']); ?>" id="reply_pic">
									</li>
								</ul>
								<em class="error-message"><?php echo empty($lotteryInfo['reply_pic']) ? '不上传则默认为下方图片' : ''; ?></em>
							</div>
						</div>
						<?php if(empty($lotteryInfo['reply_pic'])){  ?>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> </em>
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-logo">
									<li style="width: 200px;height: 100px;">
									<a href="javascript:;"  ><img src="/template/wap/default/images/shakelottery/shakelottery.jpg" /></a>
									</li>
								</ul>
								<em class="error-message"></em>
							</div>
						</div>
						<?php  } ?>
						<div class="control-group">

							<label class="control-label">
								<em class="required"></em>未关注默认提示语：
							</label>
							<div class="controls">
								<textarea name="info[follow_msg]" value="" id="follow_msg" placeholder="" style="width: 300px;"><?php echo $lotteryInfo['follow_msg']; ?></textarea>
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">

							<label class="control-label">
								<em class="required"></em>引导关注按钮提示语：
							</label>
							<div class="controls">
								<input type="text" name="info[follow_btn_msg]" value="<?php echo $lotteryInfo['follow_btn_msg']; ?>" id="follow_btn_msg" placeholder="" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>活动时间：
							</label>
							<div class="controls">
								<input type="text" name="info[starttime]" value="<?php echo date('Y-m-d H:i',($lotteryInfo['starttime'])); ?>" id="starttime" placeholder="" style="width: 150px;" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"/>
								&nbsp;到&nbsp;
								<input type="text" name="info[endtime]" value="<?php echo date('Y-m-d H:i',$lotteryInfo['endtime']); ?>" id="endtime" placeholder="" style="width: 150px;" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})" />
								<em class="error-message">分享朋友圈或者分享给朋友时标题下面显示的描述！</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required">*</em>每人总摇奖次数：
							</label>
							<div class="controls">
								<input type="text" name="info[totaltimes]" value="<?php echo $lotteryInfo['totaltimes']; ?>" id="totaltimes" placeholder="" style="width: 150px;" />
								<em class="error-message">请输入大于0的整数</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required">*</em>每人每天摇奖次数：
							</label>
							<div class="controls">
								<input type="text" name="info[everydaytimes]" value="<?php echo $lotteryInfo['everydaytimes']; ?>" id="everydaytimes" placeholder="" style="width:150px;"/>
								<em class="error-message">必须小于总摇奖次数,可以为0,0表示不限制直到消耗完总摇奖次数为止,请输入整数</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required">*</em>预计参与人数：
							</label>
							<div class="controls">
								<input type="text" name="info[join_number]" value="<?php echo $lotteryInfo['join_number']; ?>" id="join_number" placeholder="" style="width: 150px;" />
								<em class="error-message">预计参与人数直接影响中奖概率</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>每人每次中奖时间间隔：
							</label>
							<div class="controls">
								<input type="text" name="info[timespan]" value="<?php echo $lotteryInfo['timespan']; ?>" id="timespan" placeholder="" style="width: 150px;" />
								<em class="error-message">粉丝中奖之后xx分钟内不会中奖,摇奖次数依旧累加,默认为0表示不限制,单位为分钟</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>获奖记录显示条数：
							</label>
							<div class="controls">
								<input type="text" name="info[record_nums]" value="<?php echo $lotteryInfo['record_nums']; ?>" id="record_nums" placeholder="" style="width: 150px;" />
								<em class="error-message">该配置只用于其他人的中奖记录,粉丝自己的中奖记录会全部显示，可以为0,若为0前台默认显示20条</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>限制每人每天中奖次数：
							</label>
							<div class="controls">
								<input type="text" name="info[is_limitwin]" value="<?php echo $lotteryInfo['is_limitwin']; ?>" id="is_limitwin" placeholder="" style="width: 150px;" />
								<em class="error-message">限制粉丝每天中奖的次数，0表示不限制，默认为0</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>手机端是否显示奖品数量：
							</label>
							<div class="controls">
								<input type="radio" name="is_amount" value="0"   <?php echo $lotteryInfo['is_amount']==0 ? 'checked' : ''; ?>/>是&nbsp;
								<input type="radio" name="is_amount" value="1"   <?php echo $lotteryInfo['is_amount']==1 ? 'checked' : ''; ?>/>否
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required">*</em>广告提示语和链接:
							</label>
							<div class="controls">
								<input type="text" name="info[remind_word]" value="<?php echo $lotteryInfo['remind_word']; ?>"  id="remind_word" />&nbsp;链接：
								<input type="text" name="info[remind_link]" value="<?php echo $lotteryInfo['remind_link']; ?>"  id="remind_link" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>是否开启活动积分玩法：
							</label>
							<div class="controls">
								<input type="radio" name="integral_status" value="1"  <?php echo $lotteryInfo['integral_status']==1 ? 'checked' :''; ?>  />开启&nbsp;
								<input type="radio" name="integral_status" value="0"  <?php echo $lotteryInfo['integral_status']==0 ? 'checked' :''; ?> />关闭
							</div>
							<em class="error-message">开启后，每玩一次，会消耗一定店铺积分</em>
						</div>
						<div class="control-group " style="display: <?php echo $lotteryInfo['integral_status']==1 ? 'block' :'none'; ?>;" id="integral_use">
							<label class="control-label">
								<em class="required"></em>每次消耗积分
							</label>
							<div class="controls">
								<input type="text" id="integral_nub" name="integral_nub" value="<?php echo $lotteryInfo['integral_status']==1 ? $lotteryInfo['integral_nub'] : '0'; ?>"   style="width: 60px;" />&nbsp;分
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"></em>活动状态：
							</label>
							<div class="controls">
								<input type="radio" name="status" value="1"  <?php echo $lotteryInfo['status']==1 ? 'checked' : ''; ?> />开启&nbsp;
								<input type="radio" name="status" value="0"  <?php echo $lotteryInfo['status']==0 ? 'checked' : ''; ?>/>关闭
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
				uf.ready(function() {
					uf.setContent('<?php echo $lotteryInfo["action_desc"];?>');
				});
				</script>
				<input  type="hidden" name="product_id" id="product_id" value="<?php echo $lotteryInfo['id']; ?>" />
			</form>
			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit" type="button" value="取 消" />
						<input class="btn btn-primary js-create-save" type="button" value="保存" data-loading-text="保 存..." to="false"/>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>