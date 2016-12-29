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
							<label class="control-label">&nbsp;</label>
							<div class="controls" style="font-size:16px;">
								<em class="error-message">注意：降价幅度会影响活动的状态，降到最低价及时活动时间未到期，活动状态也结束了</em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>活动名称：
							</label>
							<div class="controls">
								<input type="text" name="name" value="<?php echo $cutprice['active_name']?>" id="name" placeholder="请填写名称" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">
							<input type="hidden" name="product_id" id="product_id" value="<?php echo $cutprice['product_id']?>">
							<input type="hidden" name="sku_id" id="sku_id" value="<?php echo $cutprice['sku_id']?>">
							<label class="control-label">
								<em class="required"> *</em>选择商品：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product" data-product_id="0">
									<li class="sort" data-pid="<?php echo $cutprice['product_id']?>">
										<a href="<?php echo $product['url'];?> target="_blank">
											<img data-pid="<?php echo $cutprice['product_id']?>" alt="男装-6" title="男装-6" src="<?php echo $product['image'];?>">
										</a>
										<a class="js-delete-picture close-modal small hide" href="javascript:;">×</a>
									</li>
									<li style="display:none"><a href="javascript:add_product()" class="add-goods js-add-picture">选商品</a></li>
								</ul>
							</div>
							<span style="padding-top: 5px; color: red;">
								备注：降价拍活动开始时，请勿修改产品价格、库存规格信息。
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							原价：
						</label>
						<div class="controls">
							<span id="price"><?php echo $cutprice['original']?></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>起拍价：
						</label>
						<div class="controls">
							<input type="text" name="start_price" id="start_price" value="<?php echo $cutprice['startprice']?>" style="width: 100px;" />
							<span style="padding-top: 5px; color: red;">
								起拍价不能低于最低价，不能高于原价
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>最低价：
						</label>
						<div class="controls">
							<input type="text" name="low_price" id="low_price" value="<?php echo $cutprice['stopprice']?>" style="width: 100px;" />
							<span style="padding-top: 5px; color: red;">
								最低价不能高于起拍价
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>起止时间：
						</label>
						<div class="controls">
							<input type="text" id="start_time" value="<?php echo date('Y-m-d H:i:s',$cutprice['starttime'])?>"/>&nbsp;&nbsp;<input type="text" id="end_time" value="<?php echo date('Y-m-d H:i:s',$cutprice['endtime'])?>"/>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> </em>降价力度：
						</label>
						<div class="controls">
							每<input type="text" style="width:50px;" id="minute" value="<?php echo $cutprice['cuttime']?>"/>分钟 下降<input type="text" style="width:50px;" id="down_price" value="<?php echo $cutprice['cutprice']?>"/>元
							<span style="margin-left:20px;color:red">注意：降价幅度会影响活动的状态，降到最低价及时活动时间未到期，活动状态也结束了</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> </em>商品数量：
						</label>
						<div class="controls">
							<input type="text" id="inventory" style="width:70px;" value="<?php echo $cutprice['inventory']?>"/>
							<span style="padding-top: 5px; color: red;">
								参加本次活动的商品数量，不能多于该商品的实际库存
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> </em>购买限制：
						</label>
						<div class="controls">
							每人限购<input type="text" id="buy_limit" style="width:70px;" value="<?php echo $cutprice['onebuynum']?>"/>
							<span style="padding-top: 5px; color: red;">
								不填或填写0则不限制
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> </em>购买说明：
						</label>
						<div class="controls">
							<textarea rows="5" cols="55" style="width:65%" name="descript" id="descript" class="descript"><?php echo $cutprice['info']?></textarea>
						</div>
					</div>
				</div>
			</form>
			<div class="control-group">
				<label class="control-label">
					未关注店铺公众号是否可以参与：
				</label>
				<div class="controls" id="issubscribe">
					<label class="radio inline"><input type="radio" name="subscribe" val="1" <?php if($cutprice['state_subscribe']==1){echo "checked";}?> />是 </label>
					<label class="radio inline"><input type="radio" name="subscribe" val="0" <?php if($cutprice['state_subscribe']==0){echo "checked";}?> />否</label>
				</div>
			</div>
			<?php if(!($cutprice['starttime']<=time()||$cutprice['state']>0)){?>
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
		data.active_name = $.trim($('#name').val());										// 活动名称
		data.product_id = $('#product_id').val();											// 商品id
		data.sku_id = $('#sku_id').val();													// 商品sku_id
		data.original = $('#price').text();
		data.startprice = $.trim($('#start_price').val());									// 起拍价不能低于最低价，不能高于原价
		data.stopprice = $.trim($('#low_price').val());										// 最低价不能高于起拍价
		data.starttime = $('#start_time').val();											// 活动开始时间
		data.endtime = $('#end_time').val();												// 活动结束时间
		data.cuttime = $('#minute').val();													// 降价时间间隔
		data.cutprice = $('#down_price').val();												// 降价幅度
		data.inventory = $.trim($('#inventory').val());										// 参加活动商品数量
		data.onebuynum = $('#buy_limit').val();												// 每人限购多少个
		data.info = $('#descript').val();													// 购买说明
		data.state_subscribe = $('#issubscribe :input[checked]').attr('val');				// 未关注公众号是否可以参加
		// 合法检测
		if(data.active_name.length<=0){
			layer_tips(1,'请先填写活动名称');
			return;
		}
		if(data.product_id<=0){
			layer_tips(1,'请先选择商品');
			return;
		}
		if(data.startprice<=0||data.stopprice<=0||data.original<=0){
			layer_tips(1,'价格不允许为零');
			return;
		}
		if(data.startprice > data.original){
			layer_tips(1,'起拍价不能低于最低价，不能高于原价');
			return;
		}
		if(parseInt(data.stopprice)>parseInt(data.startprice)){
			layer_tips(1,'最低价不能高于起拍价');
			return;
		}
		if(data.starttime.length <=0||data.endtime.length<=0){
			layer_tips(1,'请选择开始和结束时间');
			return;
		}
		if(data.cuttime<=0 || data.cutprice<=0){
			layer_tips(1,'请填写降价时间间隔和降价幅度');
			return;
		}
		if(data.inventory==''||data.inventory<=0){
			layer_tips(1,'请填写参加活动的商品数量');
			return;
		}
		$.post('/user.php?c=cutprice&a=save',{'data':data},function(response){
			if(response.err_code){
				layer_tips(1,response.err_msg);
			}else{
				layer_tips(0,response.err_msg);
				setTimeout(function(){window.location.href='/user.php?c=cutprice&a=cutprice_index'},1000);
			}
		},'json');
		
	}

	function add_product(){
		// 选取商品
		widget_link_box($(".js-add-picture"), "store_goods_by_sku", function (result) {
			var good_data = pic_list;
			$('.js-goods-list .sort').remove();
			for (var i in result) {
				item = result[i];
				var pic_list = "";
				var list_size = $('.js-product .sort').size();
				if(list_size > 0){
					layer_tips(1, '降价拍活动只能添加一件商品！');
					return false;
				}
				
				$(".js-product").prepend('<li class="sort" data-pid="' + item.product_id + '" data-skuid="' + item.sku_id + '"><a href="' + item.url + '" target="_blank"><img data-pid="' + item.product_id + '" alt="' + item.title + '" title="' + item.title + '" src="' + item.image + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
				$(".js-product").data("product_id", item.product_id);

				//$("input[name=price]").val(item.price);
				$('#price').text(item.price);
				$("input[name=product_id]").val(item.product_id);
				$("input[name=sku_id]").val(item.sku_id);
				$(".js-add-picture").parent().hide();
			}
		});
	}

	// 删除商品
	$('.js-delete-picture').live('click',function(){
		$(this).parent('li').siblings('li').show();
		$(this).parent('li').remove();
	});
</script>