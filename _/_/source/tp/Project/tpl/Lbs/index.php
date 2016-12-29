<include file="Public:header"/>
<style>
.city_ul {width:100%}
.city_ul li{float:left;width:20%;line-height:23px; height:23px;padding:2px 0px;}
.city_ul li:hover{background:#3A6EA5;color:#fff;}
.city_ul li .add_hot{display:none;}
.city_ul li:hover .add_hot{display:inline;cursor:pointer}
.select2-search-choice{background:#fff;color:#000;height:24px;line-height:24px;display:inline-block;min-width:55px;padding:0px 2px;border-radius:5px;}
.aleady_hot_city ul li{float:left;padding-left:10px;padding-top:10px;}
.select2-search-choice-close {
	display: block;
	width: 12px;
	height: 12px;
	/*position: absolute;*/
	right: 3px;
	top: 4px;
	font-size: 1px;
	outline: none;
	background: url(./source/tp/Project/tpl/Static/css/img/select2.png) right top no-repeat;
  /* position: absolute;*/
}
.pagebar  .select2-search-choice .select2-search-choice-close{height:12px;}

.zhankai {float:right;margin-right:10px}
.city_ul span {float:left;width:20%;line-height:23px; height:23px;padding:2px 0px;color: #ffffff}
.city_ul li {position: relative;}
.area_info {display: none;position: absolute;background-color:rgb(37, 67, 90);z-index: 99;width: 326px;}
</style>
<script src="{pigcms{$static_public}js/layer/layer.min.js"></script>

<script>
$(function(){
	$(".all").click(function(){
		if($(this).attr("checked")) {
			$(".city").attr("checked",true);
			$(".all").attr("checked",true);
            $('.area').attr("checked",true);
		} else {
			$(".city").attr("checked",false);
			$(".all").attr("checked",false);
            $('.area').attr("checked",false);
		}
	})

	$(".add_hot").click(function(){
		var code = $(this).data("code");
		var pageii = layer.load('正在为您处理', 100000);
		$.ajax({
			url: "{pigcms{:U('Lbs/set_to_hot')}",
			data: {"type":'add_hot',"code":code},
			dataType:"json",
			async: false,
			cache: false,
			type: 'POST',
			success: function (res) {
				 layer.close(pageii);
				if(res.code==0) {
					window.top.msg(1,res.msg);
					window.top.main_refresh();
				} else {
					window.top.msg(0,res.msg);
				}
				
			},
			error:function(){
				 layer.close(pageii);
				layer.alert("操作异常")
			}
		})
	})


	function p_refresh () {
		window.top.main_refresh();
	}

	//热门城市删除
	$(".select2-search-choice-close").click(function(){
		var city_name = $(this).closest(".select2-search-choice").find("b").text();
		var code = $(this).data("code");
		$.layer({
			shade: [0],
			area: ['auto','auto'],
			dialog: {
				msg: '确认要从热门城市中删除：'+city_name+'？',
				btns: 2,					
				type: 4,
				btn: ['同意删除','打死不删'],
				yes: function(){

					$.ajax({
						url: "{pigcms{:U('Lbs/set_to_hot')}",
						data: {"type":'delete_hot',"code":code},
						dataType:"json",
						async: false,
						cache: false,
						type: 'POST',
						success: function (res) {
							// layer.close(pageii);
							if(res.code==0) {
								window.top.msg(1,res.msg);
								window.top.main_refresh();
							} else {
								window.top.msg(0,res.msg);
							}
							
						},
						error:function(){
							//layer.close(pageii);
							layer.alert("操作异常")
						}
					})


									
				}, no: function(){
					//layer.msg('重要', 1, 1);
					//layer.msg('奇葩', 1, 13);
				}
			}
		});
	});

		
	$(".lbs_distance_limit").keyup(function(){
		var this_val = $(this).val()
		if(this_val) {
			$(".lbs_distance_limit").val(this_val);
		} else {
			$(".lbs_distance_limit").val(0)
		}
	});

    $('.zhankai').click(function(){
        $_this = $(this);
        var text = $_this.val();
        if(text=='展开'){
            $_this.closest('li').find('div').slideToggle("slow");
            $_this.val('收起');
        }else if(text=='收起'){
            $_this.closest('li').find('div').slideToggle("slow");
            $_this.val('展开')
        }
    });
    $('.city').change(function(){
        $_this = $(this);
        if($(this).attr("checked")) {
            $_this.closest('li').find('span').children('.area').attr("checked",true);
        } else {
            $_this.closest('li').find('span').children('.area').attr("checked",false);
        }
    });

	// 更新lbs
	$(".js-lbs_update").click(function () {
		$.get("{pigcms{:U('Lbs/update')}", function (result) {
			if (result.code == 0) {
				window.top.msg(1, result.msg);
				 location.reload();
			} else {
				window.top.msg(0, result.msg)
			}
		});
	});
	
	$("#dosubmit").click(function () {
		var city = "0";
		var area = "0";
		
		$(".js-city").each(function () {
			if ($(this).prop("checked")) {
				city += "," + $(this).data("value");
			}
		});
		
		$(".js-area").each(function () {
			if ($(this).prop("checked")) {
				area += "," + $(this).data("value");
			}
		});
		
		var lbs_distance_limit1 = $(".lbs_distance_limit").val();
		
		$.post("{pigcms{:U('Lbs/index')}", {city: city, area: area, lbs_distance_limit1: lbs_distance_limit1}, function (result) {
			if (result.code == 0) {
				window.top.msg(1, result.msg);
			} else {
				window.top.msg(0, result.msg)
			}
		});
	});
})


</script>

	<div class="mainbox">
			<div class="table-list">
				<table width="100%" cellspacing="0">
					<colgroup><col/><col/><col/><col/><col/><col/><col/><col width="180" align="center"/></colgroup>
					<thead>
						<tr>
							<td class=" pagebar" colspan="9" style="background:#777777;height:30px;;text-align:left;color:#fff;font-weight:700;line-height:22px;">
								<div class="aleady_hot_city">
									<ul>
										<li style="width:100%;padding:10px 0px;">
										<font style="font-weight:700">说明:
										1.在扫码或能得到精确坐标后，将限定显示在此距离范围内的商家或商品数据(单位:km)<br/>
										&#12288;&#12288;&nbsp;&nbsp;2.若为0，则不对显示的店铺或商品进行距离限制<br/>
										&#12288;&#12288;&nbsp;&nbsp;3.若前台定位的只是城市（未获得坐标），以下设定的距离范围不生效，（只显示对应城市的店铺/商品数据）
										
										</font><br/>
										<br/>&#12288;&#12288;&nbsp;&nbsp;
											<span style="font-weight:500;">前台LBS距离设定：</span>
										
											<span style="font-weight:500;"><input type="text" value="<?php echo $lbs_distance_limit[value];?>" class="lbs_distance_limit" name="lbs_distance_limit1" style="width:100px;height:20px;padding:2px;line-height:20px;box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075);border:1px solid #cccccc;border-radius:2px;"><font> (单位：km)</font></span>
										</li>									
									</ul>
								</div>
							
							</td>
						</tr>
						<tr ><td class=" pagebar" colspan="9" style="background:#0b8;height:30px;;text-align:left;color:#fff;font-weight:700;line-height:22px;">以下勾选的是允许展示在前台的LBS定位区域,<br/>热门城市最多可选10个，未被显示的城市，不可设为热门城市</td></tr>
						<tr >
							<td class=" pagebar" colspan="9" style="background:#0b8;height:30px;;text-align:left;color:#fff;font-weight:700;">
								<input type="checkbox" value="all" class="all" > 全选
								<input type="button" value="如果缺少城市,请点击这里更新" class="js-lbs_update" />
							</td>
						</tr>

												
						<?php if(count($alert_area_hot)) {?>
						<tr >
							<td class=" pagebar" colspan="9" style="background:#0b8;height:30px;;text-align:left;color:#fff;font-weight:700;">
								<div class="aleady_hot_city">
									<ul>
									<li>
										<span><b>热门城市：</b></span>
									</li>
									
									<volist name="alert_area_hot" id="hot">
									<li>	
										<span class="select2-search-choice" value="{pigcms{$hot.code}">
											<b>{pigcms{$hot.name}</b>
											 <a href="javascript:void(0)" data-code="{pigcms{$hot.code}" class="select2-search-choice-close" tabindex="-1"></a> 
											 <input type="hidden" value="{pigcms{$hot.code}" name="hot_code[]">
										</span>
									</li>	
									</volist>
									
									</ul>
								</div>
							
							
							
							</td>
						</tr>
						<?php }?>						

						
					</thead>
					<tbody>
						<if condition="is_array($area)">
							<volist name="area" id="vo">
								<tr><td class="textleft pagebar" colspan="9"><b>{pigcms{$vo.province}</b></td></tr>
								<tr>
									<td class="textleft " colspan="9">
										<ul class="city_ul">
											<volist name="vo[city]" id="vo1" >
												<li>
													<input class="city js-city" name="city[{pigcms{$vo1.city_code}]" data-value="{pigcms{$vo1.city_code}" type="checkbox" value="{pigcms{$vo1.city}" <?php if(in_array($vo1['city_code'],$aleady_area_code)) {?>checked="checked"<?php }?>> {pigcms{$vo1.city}

                                                    <input type="button" class="zhankai" value="展开">
													<input type="button" class="add_hot" data-code="{pigcms{$vo1.city_code}"  value="设为热门" style="float:right;margin-right:10px">

                                                    <div class="area_info">
                                                        <volist name="vo1[area]" id="vo2">
                                                            <span>
                                                                <input class="area js-area" name="area[{pigcms{$vo2.area_code}]" data-value="{pigcms{$vo2.area_code}" type="checkbox" value="{pigcms{$vo2.area}" <?php if(in_array($vo2['area_code'],$aleady_area_code)) {?>checked="checked"<?php }?>> {pigcms{$vo2.area}
                                                            </span>
                                                        </volist>
                                                    </div>
												</li>

											</volist>
										</ul>
									</td>
								</tr>
							</volist>
						<tr>
							<td class=" pagebar" colspan="9" style="background:#777777;height:30px;;text-align:left;color:#fff;font-weight:700;line-height:22px;">
								<div class="aleady_hot_city">
									<ul>
										<li style="width:100%;padding:10px 0px;">
										<font style="font-weight:700">说明:
										1.在扫码或能得到精确坐标后，将限定显示在此距离范围内的商家或商品数据(单位:km)<br/>
										&#12288;&#12288;&nbsp;&nbsp;2.若为0，则不对显示的店铺或商品进行距离限制<br/>
										&#12288;&#12288;&nbsp;&nbsp;3.若前台定位的只是城市（未获得坐标），以下设定的距离范围不生效，（只显示对应城市的店铺/商品数据）<br/>
                                        &#12288;&#12288;&nbsp;&nbsp;4.由于区域数据过大，请点击提交后,等待提供成功信息。
										</font><br/>
										<br/>&#12288;&#12288;&nbsp;&nbsp;
											<span style="font-weight:500;">前台LBS距离设定：</span>
										
											<span style="font-weight:500;"><input type="text" value="<?php echo $lbs_distance_limit[value];?>" class="lbs_distance_limit" name="lbs_distance_limit1" style="width:100px;height:20px;padding:2px;line-height:20px;box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.075);border:1px solid #cccccc;border-radius:2px;"><font> (单位：km)</font></span>
										</li>									
									</ul>
								</div>
							
							</td>
						</tr>
									

							<tr >
								<td class=" pagebar" colspan="9" style="background:#0b8;height:30px;;text-align:left;color:#fff;font-weight:700;">
									<input type="checkbox" value="all" class="all" > 全选
								</td>
							</tr>
						<else/>
							<tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
						</if>
					
						<if condition="is_array($area)">
							<tr>
								<td class="textcenter " colspan="9">
									<div class="btn" style="margin-top:20px;">
										<input type="button" name="dosubmit" id="dosubmit" value="提交"  style="border-radius:5px; color:#fff;background:#3A6EA5;height:32px;line-height:22px;width:75px">
										<input type="reset" name="reset" id="reset" value="取消" class="button" style="background:#fff;height:32px;line-height:22px;width:75px">
									</div>
								</td>
							</tr>
						</if>
					</tbody>
				</table>
			</div>
	</div>
<include file="Public:footer"/>