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
.control-group .controls-tip { float: left; margin-left: 150px; color: red; width: 800px; }
.control-group .direction_li { width: 850px; padding-bottom: 5px; float: right; }
.control-group .direction_li .dir_left { width: 270px; float: left; }
.direction_li .dir_left input { padding: 2px 4px; }
.control-group .direction_li .dir_right { width: 580px; float: left; }
.direction_li .dir_right { padding: 4px 0; height: 20px; }
.direction_li .dir_right span { background-color: #44b549; border-radius: 2px; padding: 2px 4px; color: #fff; }
.direction_li .dir_right a { color: #fff; background-color: #009adb; padding: 2px 6px; border-radius: 3px; }
.direction_li .dir_right a:hover { background-color: #0089ca; }
.control-group .direction_bottom { padding-left: 150px; width: 850px; padding-top: 10px; float: left; }
.direction_bottom .a_choose { background-color: #44b549; color: #fff; padding: 4px 8px; border-radius: 3px; margin-right: 10px; float: left; }
.direction_bottom .a_choose:hover { background-color: #33a438; }

.module-goods-list { background-color: #fff; padding: 20px 0; }
.app-design { margin-top: 10px; background-color: #fff; padding: 10px 0; }
#info { float: left; }
.direction_box { padding-top: 5px; }
.add-pic { display: inline-block; width: 100%; height: 100%; line-height: 50px; text-align: center; }
</style>

<?php $staticPath = option('config.site_url').'/template/wap/default/' ?>
<?php // $staticPath = STATIC_URL.'template/wap/default/' ?>

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
<nav class="ui-nav clearfix" style="width:auto;">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="javascript:void(0)">新增活动</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
	<div class="page-presale clearfix">
		<div class="app-presale app-reward">
			<form class="form-horizontal" id="myformaaaaaaa">
				<div class="module-goods-list">
					<div class="control-group">
						<label class="control-label">
							<em class="required"> * </em>活动名称：
						</label>
						<div class="controls">
							<input type="text" name="name" value="优惠你说了算" id="name" placeholder="请填写名称" style="width: 600px;" />
							<em class="error-message"></em>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>活动时间：
						</label>
						<div class="controls">
							<input type="text" id="startdate" name="startdate" value="">
							 &nbsp; &nbsp; 
							<input type="text" id="enddate" name="enddate" value="">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							分享图片自定义：
						</label>
						<div class="controls js-pictures">
							<input type="hidden" id="fxpic" name="fxpic" value="<?php echo $staticPath; ?>yousetdiscount/images/wxpic.jpg">
							<ul class="ico app-image-list">
								<li class="sort">
									<a href="<?php echo $staticPath; ?>yousetdiscount/images/wxpic.jpg" target="_blank"><img src="<?php echo $staticPath; ?>yousetdiscount/images/wxpic.jpg"></a>
									<a class="js-delete-picture close-modal small hide">×</a>
								</li>
								<li class="hide"><a href="javascript:;" class="add-pic ">选图片</a></li>
							</ul>
						</div>
						<span class="controls-tip">
							建议尺寸为500*500，不传则为 <a href="<?php echo $staticPath; ?>yousetdiscount/images/wxpic.jpg" target="_blank">默认图片</a>
						</span>
					</div>
					<div class="control-group">
						<label class="control-label">
							分享标题自定义：
						</label>
						<div class="controls">
							<input type="text" id="fxtitle" name="fxtitle" value="" style="width:600px;" />
						</div>
						<span class="controls-tip">
							不填则默认为：我正在参加“{{活动名称}}”活动，快来帮我拿优惠！<br>
							填写时可带参数{{活动名称}}和{{分值}}<br>
							例如：我正在参加“{{活动名称}}”活动，已获得{{分值}}的积分，快来帮我拿优惠！<br>
							变为：我正在参加“优惠接力”活动，已获得99分的积分，快来帮我拿优惠！
						</span>
					</div>
					<div class="control-group">
						<label class="control-label">
							分享描述自定义：
						</label>
						<div class="controls">
							<input type="text" id="fxinfo" name="fxinfo" value="" style="width:600px;" />
						</div>
						<span class="controls-tip">
							分享给一个朋友时标题下显示的描述，或者分享到朋友圈时显示的描述，不填则默认为活动名称，使用方法同上。
						</span>
					</div>
					<div class="control-group">
						<label class="control-label">
							游戏分享标题自定义：
						</label>
						<div class="controls">
							<input type="text" id="fxtitle2" name="fxtitle2" value="" style="width:600px;" />
						</div>
						<span class="controls-tip">
							不填则默认为：我在{{时间}}秒内获得了{{分值}}的积分，手都快抽筋，你也来试试看！<br>
							填写时可带参数{{时间}}和{{分值}}<br>
							例如：我在{{时间}}秒内获得了{{分值}}的积分，手都快抽筋，你也来试试看！<br>
							变为：我在10秒内获得了12.3分的积分，手都快抽筋，你也来试试看！
						</span>
					</div>
					<div class="control-group">
						<label class="control-label">
							游戏分享描述自定义：
						</label>
						<div class="controls">
							<input type="text" id="fxinfo2" name="fxinfo2" value="" style="width:600px;" />
						</div>
						<span class="controls-tip">
							分享给一个朋友时标题下显示的描述，或者分享到朋友圈时显示的描述，不填则默认为活动名称，使用方法同上。
						</span>
					</div>
					<div class="control-group">
						<label class="control-label">
							修改背景图片1：
						</label>
						<div class="controls js-pictures">
							<input type="hidden" id="bg1" name="bg1" value="<?php echo $staticPath; ?>yousetdiscount/images/bn.png">
							<ul class="ico app-image-list">
								<li class="sort">
									<a href="<?php echo $staticPath; ?>yousetdiscount/images/bn.png" target="_blank"><img src="<?php echo $staticPath; ?>yousetdiscount/images/bn.png"></a>
									<a class="js-delete-picture close-modal small hide">×</a>
								</li>
								<li class="hide"><a href="javascript:;" class="add-pic ">选图片</a></li>
							</ul>
						</div>
						<span class="controls-tip">
							请严格参照示例图片的尺寸 <a href="<?php echo $staticPath; ?>yousetdiscount/images/bn.png" target="_blank">查看示例图片</a>
						</span>
					</div>
					<div class="control-group">
						<label class="control-label">
							修改背景图片2：
						</label>
						<div class="controls js-pictures">
							<input type="hidden" id="bg2" name="bg2" value="<?php echo $staticPath; ?>yousetdiscount/images/bannertit.png">
							<ul class="ico app-image-list">
								<li class="sort">
									<a href="<?php echo $staticPath; ?>yousetdiscount/images/bannertit.png" target="_blank"><img src="<?php echo $staticPath; ?>yousetdiscount/images/bannertit.png"></a>
									<a class="js-delete-picture close-modal small hide">×</a>
								</li>
								<li class="hide"><a href="javascript:;" class="add-pic ">选图片</a></li>
							</ul>
						</div>
						<span class="controls-tip">
							请严格参照示例图片的尺寸 <a href="<?php echo $staticPath; ?>yousetdiscount/images/bannertit.png" target="_blank">查看示例图片</a>
						</span>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> * </em>自己玩耍次数：
						</label>
						<div class="controls">
							<input type="text" id="my_count" name="my_count" value="1" style="width:80px;" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> * </em>每个朋友玩耍次数：
						</label>
						<div class="controls">
							<input type="text" id="friends_count" name="friends_count" value="1" style="width:80px;" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> * </em>每次玩耍时间：
						</label>
						<div class="controls">
							<input type="text" id="playtime" name="playtime" value="10" style="width:80px;" /> (秒)
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> * </em>每轮最大分值：
						</label>
						<div class="controls">
							<input type="text" id="money_end" name="money_end" value="" style="width:80px;" />
						</div>
						<span class="controls-tip">
							（每次往上滑动时出现的分值不一样，这里设置的就是每轮机会最终获得的最大分值，每轮无论怎么玩都不会超过最大值）
						</span>
					</div>

					<!-- 兑换档次 -->
					<div class="control-group">
						<label class="control-label">兑换档次：</label>
						<div class="controls direction_box">
							<div class="direction_li" data-level="1">
								<div class="dir_left">兑换档次(1)：满 <input type="text" name="at_least[]" value="" style="width: 60px;"> 分，可兑换优惠劵 </div>
								<div class="dir_right">
									<span title="" class="js-coupon">请选择优惠劵</span>
									<a href="javascript:void(0)" class="js-add-coupon">选优惠劵</a>
								</div>
								<input type="hidden" name="coupon_ids[]" value="">
							</div>
							<div class="direction_li" data-level="2">
								<div class="dir_left">兑换档次(2)：满 <input type="text" name="at_least[]" value="" style="width: 60px;"> 分，可兑换优惠劵 </div>
								<div class="dir_right">
									<span title="" class="js-coupon">请选择优惠劵</span>
									<a href="javascript:void(0)" class="js-add-coupon">选优惠劵</a>
								</div>
								<input type="hidden" name="coupon_ids[]" value="">
							</div>
						</div>
						<span class="controls-tip">
							兑换档次创建后无法修改
						</span>
						<div class="direction_bottom">
							<a href="javascript:void(0)" class="a_choose js-more">+&nbsp;添加更多档次</a>
							 &nbsp; 
							<a href="javascript:void(0)" class="a_choose js-del">-&nbsp;删除一个档次</a>
						</div>                                                                                                            
					</div>

					<div class="control-group">
						<label class="control-label">
							活动规则：
						</label>
						<div class="controls">
						<script id="info" name="info" type="text/plain"></script>
						<!-- <textarea id="info" rows="2" cols="30" style="width:65%" name="info" class="descript" ></textarea> -->
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">
							是否需要关注公众号：
						</label>
						<div class="controls">
							<label style="display: inline-block;margin-right: 20px;margin-top: 5px;"><input type="radio" name="is_attention" value="0" checked style="margin:0 2px 0 0" /> 否</label>
							<label style="display: inline-block;margin-right: 20px;margin-top: 5px;"><input type="radio" name="is_attention" value="1" style="margin:0 2px 0 0" /> 是</label>
							<span style="color:red">（店铺必须绑定认证服务号，此功能才能生效）</span>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">
							是否开启：
						</label>
						<div class="controls">
							<label style="display: inline-block;margin-right: 20px;margin-top: 5px;"><input type="radio" name="is_open" value="0" checked style="margin:0 2px 0 0" />开 启</label>
							<label style="display: inline-block;margin-right: 20px;margin-top: 5px;"><input type="radio" name="is_open" value="1" style="margin:0 2px 0 0" />关 闭</label>
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
	$(function(){
		$('#startdate,#enddate').datetimepicker({
            timeFormat: "HH:mm:ss",
            dateFormat: "yy-mm-dd"
        });
	});

	var ueditor = UE.getEditor('info',{
	    initialFrameWidth:800,
	    initialFrameHeight:200
	});

	// 优惠劵选择 obj = (.direction_li);
	function bind_coupon (obj) {
		var addBtn = obj.find(".js-add-coupon");
		var coupon = obj.find(".js-coupon");
		var ipt = obj.find("input[name='coupon_ids[]']");
		widget_link_yhq(addBtn, 'coupon', function(result){
			console.log(result);
			// coupon.text('优惠劵【'+result[0].title+'】价值'+result[0].face_money+'元');
			coupon.text('价值'+result[0].face_money+'元劵'+'['+result[0].number+'/'+result[0].total_amount+']');
			ipt.val(result[0].id);
		});
	}
	
	// 增减兑换档次
	$(".a_choose").bind('click', function(){

		var self = $(this);
		var direction;
		var box = $('.direction_box');
		var level = $('.direction_li', box).length;

		if (self.hasClass("js-more")) { // 增加
			level = parseInt(level) + 1;

			if (level > 4) {
				layer_tips(1, "兑换档次不能超过4个");
				return;
			}

			direction = $('<div class="direction_li" data-level="'+level+'">' +
				'<div class="dir_left">兑换档次('+level+')：满 <input type="text" name="at_least[]" value="" style="width: 60px;"> 分，可兑换优惠劵 </div>' +
				'<div class="dir_right">' +
					'<span title="" class="js-coupon">请选择优惠劵</span> ' +
					'<a href="javascript:void(0)" class="js-add-coupon">选优惠劵</a>' +
				'</div>' +
				'<input type="hidden" name="coupon_ids[]" value="">' +
			'</div>');
			bind_coupon(direction);
			box.append(direction);
		} else {	// 减少

			if (level <= 2) {
				layer_tips(1, "至少需要2个兑换档次");
				return;
			}

			$('.direction_li:last', box).remove();
		}

	});

	// 图片上传
    $(".js-pictures").each(function(){
    	var self = $(this);
    	var ipt = $("input[type=hidden]", self);
    	var close = self.find(".js-delete-picture");
    	var btn = self.find(".add-pic");

    	btn.bind("click", function(){
    		upload_pic_box(1,true,function(pic_list){

				if (pic_list.length == 0) {
					layer_tips(1, "请先上传图片");
					return false;
				}

				if (pic_list.length > 0) {
				    for (var i in pic_list) {
				        $("ul > li:last", self).before('<li class="sort"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
				        ipt.val(pic_list[i]);
				        btn.parent().hide();	
				    }
				}

	        },1);
    	});

    });

    // 删除选择的图片
	$(".js-delete-picture").live("click", function () {

		var self = $(this);
		var btn = self.closest("ul").find(".add-pic");

		self.parents(".js-pictures").find("input[type=hidden]").val('');

		// 显示 +图片 +产品 按钮
		self.closest("li").remove();
		btn.parent().show();

	});

	// init	
	$(".direction_li").each(function(){
		bind_coupon($(this));
	});

	function buterror(obj){
		obj.css("border","1px solid red");
		obj.css("background-color","rgb(255, 223, 221)");
		obj.focus(function(){
			obj.css("background-color","#fff");
			obj.css("border","1px solid");
			obj.css("border-color","#848484 #E0E0E0 #E0E0E0 #848484");
		});
	}

	// 活动添加/修改
	$(".js-create-save").bind('click', function(){

		var data = {};
		var name = $('#name').val();
		var startdate = $('#startdate').val();
		var enddate = $('#enddate').val();
		var fxpic = $('#fxpic').val();
		var fxtitle = $('#fxtitle').val();
		var fxinfo = $('#fxinfo').val();
		var fxtitle2 = $('#fxtitle2').val();
		var fxinfo2 = $('#fxinfo2').val();
		var bg1 = $('#bg1').val();
		var bg2 = $('#bg2').val();
		var my_count = $('#my_count').val();
		var friends_count = $('#friends_count').val();
		var playtime = $('#playtime').val();
		var money_end = $('#money_end').val();

		var at_least = $('input[name="at_least[]"]');
		var discount = $('input[name="discount[]"]');

		var info = ueditor.getContent();
		var is_open = $('input[name=is_open]:checked').val();
		var is_attention = $('input[name=is_attention]:checked').val();

		var is_error = true;
		var is_error_msg = "";

		if(name == ''){
			is_error_msg += "请填写活动名称！<br>";
			buterror($("#name"));
			is_error = false;
		}

		if(startdate == ''){
			is_error_msg += "请填写开始时间！<br>";
			buterror($("#startdate"));
			is_error = false;
		}

		if(enddate == ''){
			is_error_msg += "请填写结束时间！<br>";
			buterror($("#enddate"));
			is_error = false;
		}

		if(bg1 == ''){
			is_error_msg += "请填背景图片1！<br>";
			buterror($("#bg1"));
			is_error = false;
		}

		if(bg2 == ''){
			is_error_msg += "请填背景图片2！<br>";
			buterror($("#bg2"));
			is_error = false;
		}

		my_count = my_count*1;
		if(my_count <= 0){
			is_error_msg += "自己玩耍次数请大于零！<br>";
			buterror($("#my_count"));
			is_error = false;
		}

		friends_count = friends_count*1;
		if(friends_count <= 0){
			is_error_msg += "每个朋友玩耍次数请大于零！<br>";
			buterror($("#friends_count"));
			is_error = false;
		}

		playtime = playtime*1;
		if(playtime <= 0){
			is_error_msg += "每次玩耍时间请大于零！<br>";
			buterror($("#playtime"));
			is_error = false;
		}

		if(money_end*1 <= 0){
			is_error_msg += "请填写每次玩耍的分值范围最大值！<br>";
			buterror($("#money_end"));
			is_error = false;
		}

		data.name = name;
		data.startdate = startdate;
		data.enddate = enddate;
		data.fxpic = fxpic;
		data.fxtitle = fxtitle;

		data.fxinfo = fxinfo;
		data.fxtitle2 = fxtitle2;
		data.fxinfo2 = fxinfo2;
		data.bg1 = bg1;
		data.bg2 = bg2;

		data.my_count = my_count;
		data.friends_count = friends_count;
		data.playtime = playtime;
		data.money_end = money_end;
		data.info = info;

		data.is_open = is_open;
		data.is_attention = is_attention;
		data.direction = [];

		$(".direction_li").each(function(){
			var li = $(this);
			var liLevel = li.data("level");
			var at_least = li.find("input[name='at_least[]']");
			var coupon = li.find("input[name='coupon_ids[]']");
			var ac = {
				at_least:0,
				coupon:0
			};
			if (at_least.val()*1 <= 0) {
				is_error_msg += "请填写优惠使用档次("+liLevel+")满多少元！<br>";
				buterror(at_least);
				is_error = false;
			}

			if (coupon.val()*1 <= 0) {
				is_error_msg += "请为使用档次("+liLevel+")选择优惠劵！<br>";
				is_error = false;
			}

			ac.at_least = at_least.val()*1;
			ac.coupon = coupon.val()*1;
			data.direction.push(ac);

		});

		if (is_error == false) {
			layer_tips(1, is_error_msg);
			return
		}

		// 添加到优惠接力
		$.post('/user.php?c=yousetdiscount&a=set',{data},function(result){
			if (result.err_code) {
				layer_tips(1, result.err_msg);
			} else {
				layer_tips(0, result.err_msg);
				setTimeout(function(){
					window.location.href = '/user.php?c=yousetdiscount&a=yousetdiscount_index';
				},500);
			}
		},'json');

	});

</script>