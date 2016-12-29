<!-- 茶会编辑 -->
<div class="events_edit">
	<div class="events_edit_main">
		<div class="events_edit_main_con">
			<form class="form-horizontal">
				<input type="hidden" name="pigcms_id" value="<?php echo $store_physical['pigcms_id']?>"/>
				<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						茶会名称：
					</label>
					<div class="events_edit_item_input">
						<input type="text" name="name" placeholder="茶会名称最长支持30个汉字或字符" maxlength="30" value="<?php echo $store_physical['name']?>">
					</div>
				</div>
				<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						举办时间：
					</label>
					<div class="events_edit_item_input1">
						<input type="text" name="start_time" value="<?php echo date('Y-m-d H:i', strtotime($store_physical['sttime']))?>" placeholder="开始时间" class="js-start-time Wdate" id="js-start-time" readonly="readonly" id="" style="cursor:default; background-color:white" />
					</div>
					<p class="short_line">-</p>
					<div class="events_edit_item_input2">

						<input type="text" name="end_time" value="<?php echo date('Y-m-d H:i', strtotime($store_physical['endtime']))?>" placeholder="结束时间" class="js-end-time Wdate" id="js-end-time" readonly="readonly" id="" style="cursor:default; background-color:white" />
					</div>
				</div>
				<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						举办地点：
					</label>
					<div class="ui-regions js-regions-wrap" data-province="<?php echo $store_physical['province']?>" data-city="<?php echo $store_physical['city']?>" data-county="<?php echo $store_physical['county']?>">
						<span><select name="province" id="s1"></select></span>
						<span><select name="city" id="s2"><option value="">选择城市</option></select></span>
						<span><select name="county" id="s3"><option value="">选择地区</option></select></span>
					</div>
				</div>
				<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						详细地址：
					</label>
					<div class="events_edit_item_input">
						<input type="text" class="span6 js-address-input" name="address" value="<?php echo $store_physical['address']?>" placeholder="请填写详细地址，以便买家联系；（勿重复填写省市区信息）" maxlength="80"/>
						<button type="button" class="btn js-search">搜索地图</button>
					</div>
				</div>
				<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						位置标注：
					</label>
					<div class="events_edit_item_input">
						<input type="hidden" class="span6 js-address-input" name="map_long" id="map_long" value="<?php echo $store_physical['long']?>"/>
						<input type="hidden" class="span6 js-address-input" name="map_lat" id="map_lat" value="<?php echo $store_physical['lat']?>"/>
						<div class="shop-map-container">
							<div class="left hide">
								<ul class="place-list js-place-list"></ul>
							</div>
							<div class="map js-map-container large" id="cmmap"></div>
							<button type="button" class="ui-btn select-place js-select-place">点击地图标注位置</button>
						</div>
					</div>
				</div>
				<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						茶会海报：
					</label>
					<div class="events_edit_item_thumb">
						<div class="control-action js-picture-list-wrap">
							<div class="js-img-list" style="display:inline-block">
								<?php foreach($store_physical['images_arr'] as $value){ ?>
								<li class="upload-preview-img"><a href="<?php echo $value;?>" target="_blank"><img src="<?php echo $value;?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
								<?php } ?>
							</div>
							<div class="events_edit_item_thumb_upbtn" style="display:inline-block;float:none;vertical-align:top;">
								<a href="javascript:;" class="add js-add-physical-picture">+修改海报</a>
								<span>
									温馨提示：<br>
									图片最佳尺寸840px*480px！
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="events_edit_item">
					<label><em class="required">*</em>
						茶会主题：
					</label>
					<div class="events_edit_item_input">
						<select name="zt" class="events_edit_item_input_select">
							<option value="">选择主题</option>
							<?php foreach($category as  $key=>$r){ ?>
							<option value="<?php echo $r['cat_id'];?>"<?php if($r['cat_id']==$store_physical['zt']){?> selected="selected"<?php } ?>><?php echo $r['cat_name'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="events_edit_item">
				<label><em class="required">*</em>
					所在门店：
				</label>
				<div class="events_edit_item_input">
					<select name="physical_id" class="events_edit_item_input_select">
						<option value="">选择门店</option>
						<?php foreach($physical as $key=>$r){ ?>
						<option value="<?php echo $r['pigcms_id'];?>"<?php if($r['pigcms_id']==$store_physical['physical_id']){?> selected="selected"<?php } ?>><?php echo $r['name'];?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						联系电话：
					</label>
					<div class="events_edit_item_input">
						<input type="text" name="tel"  value="<?php echo $store_physical['tel']?>">
					</div>
				</div>
				<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						茶会描述：
					</label>
					<div class="events_edit_item_input">
						<textarea name="descs" style="width: 300px;height: 100px;" maxlength="40" placeholder="最多40个字"><?php echo $store_physical['descs']?></textarea>
					</div>
				</div>
				<div class="events_edit_item">
					<label>
						<em class="required">*</em>
						人数限制：
					</label>
					<div class="events_edit_item_input">
						<input type="text" name="renshu"  onkeyup="allnumLimit(this)" onblur="allnumLimit(this)" maxlength="3" value="<?php echo $store_physical['renshu']?>" style="line-height: 24px;height: 24px;padding: 6px 0;float: left;width: 198px;">
						<p style="float: left;line-height: 40px;text-indent: 10px;color: #999;font-size: 14px;">人</p>
					</div>
				</div>
				<div class="events_edit_item">
					<label><em class="required">*</em>
						茶会票价：
					</label>
					<div class="events_edit_item_radio">
						<ul>
							<li>
								<input type="radio" onchange="showPrice();" name="tickets" id="tickets_free" style="display:none" <?php if($store_physical['tickets']==1){?> checked="checked"<?php }?> value="1">
								<label class="tickets_free" for="tickets_free">免费</label>
							</li>
							<li>
								<input type="radio" onchange="showPrice();" name="tickets" id="tickets_charge" style="display:none" <?php if($store_physical['tickets']==2){?> checked="checked"<?php }?> class="tickets_charge" value="2">
								<label class="tickets_charge" for="tickets_charge">收费</label>
								<div class="tickets_price" <?php if($store_physical['tickets']==1){?> style="display:none"<?php }?>><input type="text" onkeyup="allnumLimit(this)" onblur="allnumLimit(this)" name="price" value="<?php echo $store_physical['price']?>" style="width: 120px;line-height: 24px; height: 24px; padding: 6px 0; color: #333;" ><span style="float:left">元/人</span></div>
							</li>			
						</ul>
					</div>
				</div>
				<div class="events_edit_item">
					<label><em class="required">*</em>
						详细内容：
					</label>
					<script id="editor" type="text/plain" style="width:700px;float:left"><?php echo $store_physical['description']?></script>
					<div id="btns"></div>
				</div>
				<div class="form-actions" style="margin-top:50px">
					<button class="ui-btn ui-btn-primary js-physical-edit-submit">保存</button>
				</div>
			</form>
			<script type="text/javascript">
			function showPrice () {
				switch($('.events_edit_item_radio ul li input:checked').attr('id')){
					case 'tickets_free':
					$('.tickets_price').hide();
					$('.tickets_price input').val('');
					break;
					case 'tickets_charge':
					$('.tickets_price').show();
					break;
					default:;
				}
			}
    </script>
</div>
</div>
</div>

