<!--小弹窗-->
<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
<style>
.shop-map-container .map{float:right;height:100%;width:732px}
.shop-map-container .map.large{width:100%}
.shop-map-container{height:500px}
.shop-map-container .left{background-color:#fff;border-right:1px solid #ccc;float:left;height:100%;overflow:scroll;width:210px}
.shop-map-container .left .place-list li{border-bottom:1px solid #ddd;cursor:pointer;line-height:20px;padding:10px 5px 10px 30px;position:relative}
.shop-map-container .left .place-list .place-order{background-color:red;border-radius:20px;color:#fff;float:left;font-style:normal;height:20px;left:5px;position:absolute;text-align:center;top:9px;width:20px}
.shop-map-container .left .place-list h3{text-align:left;font-size:14px;font-weight:400;margin-bottom:10px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.shop-map-container .left .place-list .place-adress{max-height:40px}
.shop-map-container .left .place-list .place-adress,.shop-map-container .left .place-list .place-phone{color:#999;overflow:hidden}
.ui-btn{border:1px solid silver;border-radius:2px;color:#333;cursor:pointer;display:inline-block;font-size:12px;height:26px;line-height:26px;padding:2px 8px}
.shop-map-container .select-place{position:absolute;right:10px;top:10px;background:#f7f7f7}
.address_map .buttons{margin-left:5px;border-radius:5px;color:#fff;background:#0b8;font-size:14px;line-height:30px;padding:0 32px}
.address_layer{z-index:999999}
.select select{line-height:30px;height:30px}
.shop-map-container .place-adress{text-align:left}
.shop-map-container .place-phone{text-align:left}
</style>

<script>	
function layer_tips(msg_type,msg_content){
	layer.closeAll();
	var time = msg_type==0 ? 3 : 4;
	var type = msg_type==0 ? 1 : (msg_type != -1 ? 0 : -1);
	if(type == 0){
		msg_content = '<font color="red">'+msg_content+'</font>';
	}
	$.layer({
		title: false,
		offset: ['80px',''],
		closeBtn:false,
		shade:[0],
		time:time,
		dialog:{
			type:type,
			msg:msg_content
		}
	});
}
$(function(){
	$("select[name='select_prov']").change(function(){
		var this_val = $(this).val();
		var htmls="";
		if(this_val) {
			$.post(
				"<?php echo url('changecity:ajax_get_area') ?>",
				{"prov_code":this_val},
				function(obj){
					if(obj.err_code == 0) {
						var objs = obj.err_msg;
						for(var i in objs) {
							htmls +="<option value='"+objs[i].code+"'>"+objs[i].name+"</option>";
						}
						$("select[name='select_city']").html(htmls);
					} else {
						
					}

				},
				'json'
			)
			
		} else {
			$("select[name='select_city']").html("<option value=''>未选择</option>");
		}
	})

	$(".location_home").click(function(){
		$(".baidu_map").show();
		$(".address_layer,.layer").fadeIn("400");
	})


})
</script>
<!-- -------------------------- -->
	<aside style="display:none" class="baidu_map">
		<div class="layer" style="display:block"></div>
		<div class="address_layer">
			<div class="address_title clearfix">
				<h4>精准定位</h4>
				<p>在地图上标注您的位置</p><i></i>
			</div>
			

			<div class="address_select clearfix">
				<div class="select"><span>所属区域:</span>
                        <span>
                        <select id="lbs1" name="lbsprovince" class="lbsprovince">
                            <option value="">选择省份</option>
                            <?php if(is_array($new_province_area)) {?>
                                <?php foreach($new_province_area as $k=>$v) {?>
                                    <option value="<?php echo $v['province_code'];?>"><?php echo $v['province'];?></option>
                                <?php }?>
                            <?php }?>
						</select>
                        </span>
                        <span>
                        <select id="lbs2" name="lbscity" class="lbscity">
                            <option value="">选择城市</option>
                        </select>
                        </span>
                        <span>
                        <select id="lbs3" name="lbsarea" class="lbsarea">
                            <option value="">选择地区</option>
                        </select>
                        </span>
					<!--  
					<button>确定</button>
					-->
					
				</div>
				<div class="select"><span>详细地址:</span>
					<input type="text" id="js-address-input" class="js-address-input" placeholder="请输入详细地址" />
					<button class="js-search">确定</button>
				</div>
			</div>
			<!--  
			<div class="address_map"><img src="<?php echo TPL_URL;?>images/pcmap_03.png">
				<i class="address_icon"></i>
				<div class="address_info"><span>新地中心C座写字楼写字楼</span>
					<button>确定</button>
					<i></i>
				</div>
			</div>
			-->

			<script>
			static_url="<?php echo TPL_URL;?>";
			$.getScript(static_url+'js/bdmap.js');
			</script>			
		<div class="controls address_map">
			<input type="hidden" class="span6 js-address-input" name="map_long" id="map_long" value="<?php echo $store_contact['long']?>"/>
			<input type="hidden" class="span6 js-address-input" name="map_lat" id="map_lat" value="<?php echo $store_contact['lat']?>"/>
			<div class="shop-map-container">
				<div class="left hide">
					<ul class="place-list js-place-list"></ul>
				</div>
				<div class="map js-map-container large" id="cmmap"></div>
				<button type="button" class="ui-btn select-place js-select-place">点击地图标注位置</button>
			</div>
		</div>

			
		</div>
	</aside>
	<!-- -------------------------- -->
	