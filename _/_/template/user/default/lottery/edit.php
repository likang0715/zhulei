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
.game_type label{width:50px;float:left;margin-left:20px;}
</style>
<input type="hidden" id="lottery_id" value="<?php echo $lottery['id']?>"/>
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
			<a href="javascript:">新增抽奖活动</a>
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
								活动表现形式：
							</label>
							<div class="controls">
								<div class="checkbox game_type" id="game_type">
									<label><input type="checkbox" value="1" <?php if($lottery['type']==1){echo "checked";}?> disabled>大转盘</label>
									<label><input type="checkbox" value="2" <?php if($lottery['type']==2){echo "checked";}?> disabled>九宫格</label>
									<label><input type="checkbox" value="3" <?php if($lottery['type']==3){echo "checked";}?> disabled>刮刮卡</label>
									<label><input type="checkbox" value="4" <?php if($lottery['type']==4){echo "checked";}?> disabled>水果机</label>
									<label><input type="checkbox" value="5" <?php if($lottery['type']==5){echo "checked";}?> disabled>砸金蛋</label>
								</div>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" style="font-weight:bold;font-size:16px;">基础规则&nbsp;&nbsp;</label>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>活动名称：
							</label>
							<div class="controls">
								<input type="text" id="title" value="<?php echo $lottery['title']?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>兑奖信息：
							</label>
							<div class="controls">
								<input type="text" id="win_info" value="<?php echo $lottery['win_info']?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>中奖提示：
							</label>
							<div class="controls">
								<input type="text" id="win_tip" value="<?php echo $lottery['win_tip']?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>活动时间：
							</label>
							<div class="controls">
								<input type="text" id="start_time" value="<?php echo date('Y-m-d H:i:s',$lottery['starttime'])?>"/>&nbsp;&nbsp;<input type="text" id="end_time" value="<?php echo date('Y-m-d H:i:s',$lottery['endtime'])?>"/>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>活动说明：
							</label>
							<div class="controls">
								<textarea class="form-control" rows="3" id="active_desc"><?php echo $lottery['active_desc']?></textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>活动结束提示语：
							</label>
							<div class="controls">
								<input type="text" id="endtitle" value="<?php echo $lottery['endtitle']?>" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>重复参与提示：
							</label>
							<div class="controls">
								<input type="text" id="rejoin_tip" value="<?php echo $lottery['rejoin_tip']?>" />
								<span style="padding-top: 5px; color: red;">
								只有一次机会的，设置如 亲机会已经用完了哦；对于多次机会的，设置如 就差一点点了，加油
								</span>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>活动模块背景图片：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-logo">
									<li <?php if($lottery['backgroundThumImage']){echo 'style="display:none"';}?>>
									<a href="javascript:;" class="add-goods js-add-background" className="backgroundThumImage">上传</a>
									<input type="hidden" name="info[backgroundThumImage]" value="<?php echo getAttachmentUrl($lottery['backgroundThumImage'])?>" id="backgroundThumImage">
									</li>
									<?php if($lottery['backgroundThumImage']){?>
									<li class="sort">
									<a href="javascript:void(0)" target="_blank"><img src="<?php echo getAttachmentUrl($lottery['backgroundThumImage'])?>"></a>
									<a class="js-delete-picture close-modal small hide">×</a>
									</li>
									<?php }?>
								</ul>
								<span>注："九宫格和砸金蛋只能使用默认背景图"</span>
								<div class="clear controls" style="margin-left:56px;">
									<label class="control-label">填充方式</label>
									<div class="radio controls game_type" id="fill_type">
										<label><input type="radio" name="fill_type" <?php if($lottery['fill_type']==1){echo "checked";}?> value='1' />平铺</label>
										<label><input type="radio" name="fill_type" <?php if($lottery['fill_type']==0){echo "checked";}?> value="0"/>填充</label>
									</div>
								</div>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>是否显示奖品数量：
							</label>
							<div class="controls game_type" id="isshow_num">
								<label><input type="radio" name="isshow_num" <?php if($lottery['isshow_num']==1){echo "checked";}?> value='1' />是</label>
								<label><input type="radio" name="isshow_num" <?php if($lottery['isshow_num']==0){echo "checked";}?> value="0"/>否</label>
							</div>
						</div>
					</div>
					<div class="control-group">
						
						<!--<label style="float:right;">如果要确保用户100%中奖，需要选择一个奖项作为安慰奖</label>-->
						<div class="alert alert-success alert-dismissible" role="alert">
							<span style="font-weight:bold;font-size:16px;">奖项设置&nbsp;&nbsp;</span>
						  	如果要确保用户100%中奖，需要选择一个奖项作为安慰奖&nbsp;&nbsp;
						  	<span style="color:#ff0000;">奖品设置为线上商品时，注意奖品数量不要大于实际库存</span>
						</div>
					</div>
					<input type="hidden" id="anwei_id" value="<?php echo $lottery['anwei'];?>"/>
					<?php 
						$prizes = array(1=>'一等奖',2=>'二等奖',3=>'三等奖',4=>'四等奖',5=>'五等奖',6=>'六等奖');
					?>
					<?php foreach($prizes as $key => $prize){?>
					<div class="control-group">
						<span style="float:left;font-size:16px;color:#4cae4c"><?php echo $prize?></span>
						<label class="control-label" style="margin-left:-50px;">
							奖品类型：
						</label>
						<div class="controls">
							<select id="prize_<?php echo $key;?>" onchange="product_change(this)" name="activty_prize_types">
								<option value="0">选择奖品</option>
								<option value="1" <?php if($lottery_prizes[$key]['prize']==1){echo "selected";}?> >商品</option>
								<option value="2" <?php if($lottery_prizes[$key]['prize']==2){echo "selected";}?>>优惠券</option>
								<option value="3" <?php if($lottery_prizes[$key]['prize']==3){echo "selected";}?>>店铺积分</option>
								<option value="4" <?php if($lottery_prizes[$key]['prize']==4){echo "selected";}?>>其他</option>
							</select>
							<?php if($lottery['anwei']==$key){?>
							<a href="javascript:;" name="btn-anwei" class="btn btn-danger" onclick="set_anwei(this)" val="<?php echo $key;?>">取消设置</a>
							<?php }else{?>
							<a href="javascript:;" name="btn-anwei" class="btn btn-info" onclick="set_anwei(this)" val="<?php echo $key;?>">设为安慰奖</a>
							<?php }?>
						</div>
					</div>
					<div class="control-group">
						<div class="control-group" <?php if( $lottery_prizes[$key]['prize']!=1){echo 'style="display: none;"';}?> id="div_product_select_<?php echo $key;?>">
							<input type="hidden" name="product_id" id="product_id_<?php echo $key;?>" value="<?php echo $lottery_prizes[$key]['product_id']?>">
							<input type="hidden" name="sku_id" id="sku_id_<?php echo $key;?>" value="<?php echo $lottery_prizes[$key]['sku_id']?>">
							<label class="control-label">
								<em class="required"> *</em>选择商品：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product_<?php echo $key;?>" data-product_id="0">
								<?php if($lottery_prizes[$key]['product_id']||$lottery_prizes[$key]['sku_id']){?>
								<li class="sort" data-pid="<?php echo $lottery_prizes[$key]['product_id'];?>" data-skuid="<?php echo $lottery_prizes[$key]['sku_id'];?>"><a href="http://www.weidian.com/goods/<?php echo $lottery_prizes[$key]['product_id']?>.html" target="_blank"><img data-pid="<?php echo $lottery_prizes[$key]['product_id']?>" alt="<?php echo $lottery_prizes[$key]['product_name']?>" title="<?php echo $lottery_prizes[$key]['product_name']?>" src="<?php echo '/upload/'.$lottery_prizes[$key]['image'];?>"></a><a class="js-delete-picture_multy close-modal small hide">×</a></li>
								<li style="display:none;"><a href="javascript:add_product(<?php echo $key;?>)" class="add-goods js-add-picture_<?php echo $key;?>">选商品</a></li>
								<?php }else{?>
									<li><a href="javascript:add_product(<?php echo $key;?>)" class="add-goods js-add-picture_<?php echo $key;?>">选商品</a></li>
								<?php }?>
								</ul>
							</div>
						</div>
						<div class="control-group" <?php if( $lottery_prizes[$key]['prize']!=2){echo 'style="display: none;"';}?>" id="div_coupon_select_<?php echo $key;?>">
							<label class="control-label">&nbsp;</label>
							<div class="controls">
								<select class="js-reward-coupon" id="coupon_<?php echo $key;?>" style="width: 180px;" onclick="change_coupon(this,<?php echo $key;?>)">
									<option value="0">请选择优惠券</option>
									<?php 
									foreach ($coupon_list as $coupon) {
									?>
										<option value="<?php echo $coupon['id'] ?>" val="<?php echo htmlspecialchars($coupon['name']) ?>" <?php if($lottery_prizes[$key]['coupon']==$coupon['id']){echo 'selected';}?> ><?php echo htmlspecialchars($coupon['name']) ?></option>
									<?php 
									}
									if (empty($coupon_list)) {
									?>
										<option value="0">您还未创建优惠券</option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<label class="control-label">
							<em class="required"> *</em>奖品：
						</label>
						<div class="controls">
							<input type="text" id="product_name_<?php echo $key;?>" placeholder="积分名称" value="<?php echo $lottery_prizes[$key]['product_name']?>" <?php if(in_array($lottery_prizes[$key]['prize'],array(1,2))){echo 'readonly="readonly"';}?> />
							<input type="text" style="<?php if($lottery_prizes[$key]['prize']!=3){echo 'display:none;';}?>width:100px;" id="product_recharge_<?php echo $key;?>" value="<?php echo $lottery_prizes[$key]['product_recharge']?>" placeholder="实际奖励的积分数值" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>数量：
						</label>
						<div class="controls">
							<input type="text" id="product_num_<?php echo $key;?>" value="<?php echo $lottery_prizes[$key]['product_num']?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>中奖率：
						</label>
						<div class="controls">
							<input type="text" id="rates_<?php echo $key;?>" value="<?php echo $lottery_prizes[$key]['rates']?>" />
							<span style="color:gray;">不能设置100%</span>
						</div>
					</div>
					<?php }?>
					
					<div class="control-group">
						<!--<label class="control-label" style="font-weight:bold;font-size:16px;">玩法逻辑设置</label>-->
						<div class="alert alert-success alert-dismissible" role="alert">
							<span style="font-weight:bold;font-size:16px;">玩法逻辑设置</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>抽奖限制：
						</label>
						<div class="controls" style="margin-left:30px;" id="div_win_limits">
							<div class="control-group">
								<div class="radio">
									<label style="margin-left:134px;"><input type="radio" name="win_limit" <?php if($lottery['win_limit']==0){echo "checked";}?> value="0">不限制</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">&nbsp;</label>
								<div class="radio">
									<label style="width:80px;float:left;"><input type="radio" name="win_limit" <?php if($lottery['win_limit']==1){echo "checked";}?> value="1">每日限制</label>
									<span>一日</span><input type="text" style="width:50px" id="day_limit_num" value="<?php echo $lottery['win_limit_extend']?>" />次，
									分享<input type="text" style="width:50px" id="share_limit_num" value="<?php echo $lottery['win_limit_share_extend']?>" />次，增加一次机会
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">&nbsp;</label>
								<div class="radio">
									<label style="width:80px;float:left;"><input type="radio" name="win_limit" <?php if($lottery['win_limit']==3){echo "checked";}?> value="3">积分限制</label>
									<span>一次</span><input type="text" style="width:50px" id="recharge_limit_num" value="<?php echo $lottery['recharge_limit_num']?>" />积分
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">&nbsp;</label>
								<div class="checkbox">
									<label><input type="checkbox" id="need_subscribe" <?php if($lottery['need_subscribe']){echo "checked";}?> >需要用户关注参与</label>
								</div>
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>每人中奖次数：
						</label>
						<div class="controls" id="div_win_type">
							<div class="control-group">
								<label style="float:left;width:80px;"><input type="radio" name="win_type" value="0" <?php if($lottery['win_type']==0){echo "checked";}?> />总次数</label>
								<input type="text" style="width:100px;float:left" value="<?php echo $lottery['win_type']==0?$lottery['win_type_extend']:''?>" />
							</div>
							<label class="control-label">&nbsp;</label>
							<div class="control-group">
								<label style="float:left;width:80px;"><input type="radio" name="win_type" value="1" <?php if($lottery['win_type']==1){echo "checked";}?> />单日次数</label>
								<input type="text" style="width:100px;float:left" value="<?php echo $lottery['win_type']==1?$lottery['win_type_extend']:''?>" />
							</div>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>兑奖密码：
						</label>
						<div class="controls">
							<input type="text" id="win_password" value="<?php echo $lottery['password']?>" />
						</div>
					</div>
					
				</div>
			</form>
			<?php if(!($lottery['starttime']<=time()||$lottery['status'] > 0)){?>
			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit" type="button" value="取 消" />
						<input class="btn btn-primary js-create-save" type="button" onclick="save()" value="保 存" data-loading-text="保 存..." />
					</div>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#start_time,#end_time').datetimepicker({
            timeFormat: "HH:mm:ss",
            dateFormat: "yy-mm-dd"
        });
	});
	// 保存
	function save(){
		var data = new Object();
		//return;
		var game_types = $('#game_type :checkbox[checked]');
		var types = new Array();
		$.each(game_types,function(i,v){
			types.push($(v).val());
		});
		if(types.length<=0){
			layer_tips(1,'请选择活动表现形式');
			return;
		}
		data.game_type = types.join(',');

		var lottery_id = $('#lottery_id').val();
		data.title = $.trim($('#title').val());
		data.win_info = $.trim($('#win_info').val());
		data.win_tip = $.trim($('#win_tip').val());
		data.starttime = $('#start_time').val();
		data.endtime = $('#end_time').val();
		data.active_desc = $.trim($('#active_desc').val());
		data.endtitle = $.trim($('#endtitle').val());
		data.rejoin_tip = $.trim($('#rejoin_tip').val());
		data.backgroundThumImage = $('#backgroundThumImage').val();
		data.fill_type = $('#fill_type :radio[checked]').val();
		data.isshow_num = $('#isshow_num :radio[checked]').val();
		data.anwei_id = $('#anwei_id').val();
		
		// 一等奖
		data.prize_1 = $('#prize_1').val();
		data.product_id_1 = $('#product_id_1').val();
		data.sku_id_1 = $('#sku_id_1').val();
		data.product_name_1 = $('#product_name_1').val();
		data.coupon_1 = $('#coupon_1').val();
		data.product_recharge_1 = $('#product_recharge_1').val();
		data.product_num_1 = $('#product_num_1').val();
		data.rates_1 = $('#rates_1').val();
		// 二等奖
		data.prize_2 = $('#prize_2').val();
		data.product_id_2 = $('#product_id_2').val();
		data.sku_id_2 = $('#sku_id_2').val();
		data.product_name_2 = $('#product_name_2').val();
		data.coupon_2 = $('#coupon_2').val();
		data.product_recharge_2 = $('#product_recharge_2').val();
		data.product_num_2 = $('#product_num_2').val();
		data.rates_2 = $('#rates_2').val();
		// 三等奖
		data.prize_3 = $('#prize_3').val();
		data.product_id_3 = $('#product_id_3').val();
		data.sku_id_3 = $('#sku_id_3').val();
		data.product_name_3 = $('#product_name_3').val();
		data.coupon_3 = $('#coupon_3').val();
		data.product_recharge_3 = $('#product_recharge_3').val();
		data.product_num_3 = $('#product_num_3').val();
		data.rates_3 = $('#rates_3').val();
		// 四等奖
		data.prize_4 = $('#prize_4').val();
		data.product_id_4 = $('#product_id_4').val();
		data.sku_id_4 = $('#sku_id_4').val();
		data.product_name_4 = $('#product_name_4').val();
		data.coupon_4 = $('#coupon_4').val();
		data.product_recharge_4 = $('#product_recharge_4').val();
		data.product_num_4 = $('#product_num_4').val();
		data.rates_4 = $('#rates_4').val();
		// 五等奖
		data.prize_5 = $('#prize_5').val();
		data.product_id_5 = $('#product_id_5').val();
		data.sku_id_5 = $('#sku_id_5').val();
		data.product_name_5 = $('#product_name_5').val();
		data.coupon_5 = $('#coupon_5').val();
		data.product_recharge_5 = $('#product_recharge_5').val();
		data.product_num_5 = $('#product_num_5').val();
		data.rates_5 = $('#rates_5').val();
		// 六等奖
		data.prize_6 = $('#prize_6').val();
		data.product_id_6 = $('#product_id_6').val();
		data.sku_id_6 = $('#sku_id_6').val();
		data.product_name_6 = $('#product_name_6').val();
		data.coupon_6 = $('#coupon_6').val();
		data.product_recharge_6 = $('#product_recharge_6').val();
		data.product_num_6 = $('#product_num_6').val();
		data.rates_6 = $('#rates_6').val();

		// 奖项设置数据校验
		var res = checkPrizeData(data);
		if(res.err_code>0){
			layer_tips(1,res.err_msg);
			return;
		}
		// 抽奖限制
		data.win_limit = $("#div_win_limits :radio[checked]").val();
		data.win_limit_extend = 0;
		data.win_limit_share_extend = 0;
		if(data.win_limit>0){
			var win_limit_extend = $("#div_win_limits :radio[checked]").parent('label').siblings('span').siblings('input').val();
			win_limit_extend = parseInt(win_limit_extend);
			if(isNaN(win_limit_extend)){
				layer_tips(1,'抽奖限制不合法');
				return;
			}
			data.win_limit_extend = win_limit_extend;
			if(data.win_limit==1){	// 每日抽奖限制
				data.win_limit_share_extend = $('#share_limit_num').val();
			}
		}
		data.need_subscribe = $('#need_subscribe').is(':checked')?1:0;	// 是否需要用户关注参与，1需要0不需要
		// 每人中奖次数
		data.win_type = $('#div_win_type :radio[checked]').val();
		data.win_type_extend = 0;
		var win_type_extend = $("#div_win_type :radio[checked]").parent('label').siblings('input').val();
		win_type_extend = parseInt(win_type_extend);
		if(isNaN(win_type_extend)){
			layer_tips(1,'每人中奖次数不合法');
			return;
		}
		data.win_type_extend = win_type_extend;
		// 兑奖密码
		data.win_password = $.trim($('#win_password').val());
		if(data.win_password==''){
			layer_tips(1,'请设置兑奖密码');
			return;
		}
		console.log(data);
		$.post('/user.php?c=lottery&a=save',{'data':data,'lottery_id':lottery_id},function(response){
			if(response.err_code){
				layer_tips(1,response.err_msg);
			}else{
				layer_tips(0,response.err_msg);
				setTimeout(function(){window.location.href='/user.php?c=lottery&a=lottery_index'},1000);
			}
		},'json');
		
	}

	// 奖项校验
	function checkPrizeData(data){
		var result = new Object();
		if(data.title==''){
			result.err_code = 1;result.err_msg='请填写活动标题';
			return result;
		}
		if(data.win_info==''){
			result.err_code = 1;result.err_msg='请填写兑奖信息';
			return result;
		}
		if(data.win_tip==''){
			result.err_code = 1;result.err_msg='请填写中奖提示';
			return result;
		}
		if(data.starttime==''||data.endtime==''){
			result.err_code = 1;result.err_msg='请填写活动开始时间和结束时间';
			return result;
		}
		if(data.active_desc==''){
			result.err_code = 1;result.err_msg='请填写活动说明';
			return result;
		}
		if(data.endtitle==''){
			result.err_code = 1;result.err_msg='请填写活动结束提示语';
			return result;
		}
		if(data.rejoin_tip == ''){
			result.err_code = 1;result.err_msg='请填写重复参与提示';
			return result;
		}
		var activty_prize_types = $("select[name='activty_prize_types']");
		var selected_arr = [];	// 已设置的奖项元素序号数组
		$.each(activty_prize_types,function(i,v){
			if($(v).val()>0){
				selected_arr[i] = (i+1);
			}
		});
		if(selected_arr.length<=0){
			result.err_code = 1;result.err_msg='请设置奖项';
			return result;
		}
		var error_select = 0;
		$.each(selected_arr,function(ii,vv){
			if($('#product_name_'+vv).val()==''||$('#product_num_'+vv).val()==''||$('#rates_'+vv).val()==''){
				error_select = vv;
				return false;
			}
			// 店铺积分模式
			if($('#prize_'+vv).val() == 3){
				var product_recharge = $.trim($('#product_recharge_'+vv).val());
				if(product_recharge==''||isNaN(product_recharge)){
					error_select = vv;
					return false;
				}
			}
		});
		if(error_select > 0){
			result.err_code = 1;result.err_msg='第 ' + error_select +' 等奖信息设置不完整';
			return result;
		}
		result.err_code = 0;result.err_msg='ok';
		return result;
	}

	// 设置为安慰奖
	function set_anwei(obj){
		var id = $(obj).attr('val');
		if(id>6 || id<1){
			return;
		}
		if($(obj).text() == '设为安慰奖'){
			$('#anwei_id').val(id);
			$("a[name='btn-anwei']").text('设为安慰奖').removeClass('btn-danger').addClass('btn-info');
			$(obj).text('取消设置').removeClass('btn-info').addClass('btn-danger');
		}else{
			$('#anwei_id').val(0);
			$(obj).text('设为安慰奖').removeClass('btn-danger').addClass('btn-info');
		}
		//$("a[name='btn-anwei']").attr('disabled',false);
		//$(obj).attr('disabled',true);
	}

	
	// 奖品切换
	function product_change(obj){
		var option = $(obj).val();
		var key = $(obj).siblings('a').attr('val');
		if(option==1){
			// 商品
			$('#div_product_select_'+key).show();
			$('#div_coupon_select_'+key).hide();
			$('#product_recharge_'+key).hide();
			$('#product_name_'+key).attr('readonly',true);
		}else if(option==2){
			// 优惠券
			$('#div_product_select_'+key).hide();
			$('#div_coupon_select_'+key).show();
			$('#product_recharge_'+key).hide();
			$('#product_name_'+key).attr('readonly',true);
		}else if(option==3){
			$('#div_product_select_'+key).hide();
			$('#div_coupon_select_'+key).hide();
			$('#product_recharge_'+key).show();
			$('#product_name_'+key).attr('readonly',false);
		}else{
			$('#div_product_select_'+key).hide();
			$('#div_coupon_select_'+key).hide();
			$('#product_recharge_'+key).hide();
			$('#product_name_'+key).attr('readonly',false);
		}
	}

	// 选取商品
	function add_product(key){
		mykey = key;
		widget_link_box($(".js-add-picture_"+mykey), "store_goods_by_sku", function (result) {
			var good_data = pic_list;
			$('.js-goods-list .sort').remove();
			for (var i in result) {
				item = result[i];
				var pic_list = "";
				var list_size = $('.js-product .sort').size();
				if(list_size > 0){
					layer_tips(1, '活动只能添加一件商品！');
					return false;
				}
				
				$(".js-product_"+mykey).prepend('<li class="sort" data-pid="' + item.product_id + '" data-skuid="' + item.sku_id + '"><a href="' + item.url + '" target="_blank"><img data-pid="' + item.product_id + '" alt="' + item.title + '" title="' + item.title + '" src="' + item.image + '"></a><a class="js-delete-picture_multy close-modal small hide">×</a></li>');
				$(".js-product").data("product_id", item.product_id);

				// $('#price').text(item.price);
				$("#product_id_"+mykey).val(item.product_id);
				$("#sku_id_"+mykey).val(item.sku_id);
				$('#product_name_'+key).val(item.title);
				$(".js-add-picture_"+mykey).parent().hide();
			}
		});
	}

	// 删除商品图片
	$('.js-delete-picture_multy').live('click',function(){
		var self = $(this);
		self.parent('li').siblings('li').show();
		self.closest("li").remove();
	});

	// 切换优惠券
	function change_coupon(obj,key){
		var coupon_name = $(obj).find("option:selected").text();
		$('#product_name_'+key).val(coupon_name);
	}
</script>