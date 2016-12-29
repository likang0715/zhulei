<include file="Public:header"/>
<if condition="$withdrawal_count gt 0">
<script type="text/javascript">
    $(function(){
	    $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录 <label style="color:red">(' + {pigcms{$withdrawal_count} + ')</label>')
    })
</script>
<else/>
    <script type="text/javascript">
        $(function(){
           // $('#nav_12 > dd:last-child > span', parent.document).html('提现记录');

	        $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录');
			
			
        })
    </script>
</if>
<script>
$(function(){
	
		var strs;
			$(".display_edit").live("click",function(){
				strs = "<select>";
				strs += "	<option value='1'>正常展示</option>";
				strs += "	<option value='0'>关闭展示</option>";
				strs += "</select>";				
				$(this).closest("td").find(".diplays").html(strs);
				$(this).hide();
				$(this).closest("td").find(".display_save").show();
			})

			$(".display_save").live("click",function(){
				var indexs = $(".display_save").index($(this))
				strs = "正常展示";
				var is_display = $(this).closest("td").find("select").val();
				var store_id = $(this).closest("td").attr("datas");;


				if(!store_id) {
					alert("系统错误，请联系管理员");
					return ;
				}
				
				$.post("<?php echo U('Store/change_public_display'); ?>",{'is_display': is_display, 'store_id': store_id}, function(data){
					if(data.status == 0) {
						if(data.type=='1') {
							$(".diplays").eq(indexs).html("修改成功：正常展示");
						} else {
							$(".diplays").eq(indexs).html("修改成功：关闭展示");
						}
						
						$(".display_save").eq(indexs).hide();
						$(".display_edit").eq(indexs).show();
						//alert("修改成功");
					} else {
						alert(data.msg);
					}
					//window.location.href = url;
				},
				'json'
				)
				

			})				
	
})
</script>
<style>
.cursor{cursor:pointer;}
.display_edit,.display_save{background:url('./source/tp/Project/tpl/Static/images/glyphicons-halflings.png') no-repeat;}
.display_edit{background-position: -20px -23px;display:inline-block;height:20px;width:20px;}
.display_save{background-position: -283px 0px;display:inline-block;height:20px;width:20px;}
td p {
	margin: 1px;
}
.gray {
	color:gray;
}
td {
	padding:5px;
}
</style>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Store/index')}" class="on">店铺列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('Store/index')}" method="get">
							<input type="hidden" name="c" value="Store"/>
							<input type="hidden" name="a" value="index"/>
							筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}" />
							<select name="type">
								<option value="name" <if condition="$_GET['type'] eq 'name'">selected="selected"</if>>店铺名称</option>
								<option value="store_id" <if condition="$_GET['type'] eq 'store_id'">selected="selected"</if>>店铺编号</option>
                                <option value="user" <if condition="$_GET['type'] eq 'uid'">selected="selected"</if>>商户编号</option>
								<option value="account" <if condition="$_GET['type'] eq 'account'">selected="selected"</if>>商户昵称</option>
								<option value="tel" <if condition="$_GET['type'] eq 'tel'">selected="selected"</if>>联系电话</option>
							</select>
							&nbsp;&nbsp;
							店铺类型：
							<select name="store_type">
								<option value="0">店铺类型</option>
								<option value="1" <if condition="$_GET['store_type'] eq 1">selected="selected"</if>>供货商</option>
								<option value="2" <if condition="$_GET['store_type'] eq 2">selected="selected"</if>>分销商</option>
							</select>
                            &nbsp;&nbsp;主营类目：
                            <select name="sale_category">
                                <option value="0">主营类目</option>
                                <volist name="sale_categories" id="sale_category">
                                <option value="{pigcms{$sale_category.cat_id}" <if condition="$Think.get.sale_category eq $sale_category['cat_id']">selected="true"</if>>{pigcms{$sale_category.name}</option>
                                </volist>
                            </select>
                            &nbsp;&nbsp;认证：
                            <select name="approve">
                                <option value="*">认证状态</option>
                                <option value="0" <?php if (isset($_GET['approve']) && is_numeric($_GET['approve']) && $_GET['approve'] == 0) { ?>selected<?php } ?>>未认证</option>
                                <option value="1" <if condition="$Think.get.approve eq 1">selected</if>>已认证</option>
								 <option value="2" <if condition="$Think.get.approve eq 2">selected</if>>认证中</option>
								  <option value="3" <if condition="$Think.get.approve eq 3">selected</if>>认证不通过</option>
                            </select>
                            &nbsp;&nbsp;状态：
                            <select name="status">
                                <option value="*">店铺状态</option>
                                <option value="1" <if condition="$Think.get.status eq 1">selected</if>>正常</option>
			            		<option value="2" <if condition="$Think.get.status eq 2">selected</if>>待审核</option>
			            		<option value="3" <if condition="$Think.get.status eq 3">selected</if>>关闭或审核失败</option>
								<option value="4" <if condition="$Think.get.status eq 3">selected</if>>用户关闭店铺</option>
			            		<option value="5" <if condition="$Think.get.status eq 5">selected</if>>供货商关闭</option>
                            </select>

							&nbsp;&nbsp;区域：
							<span class="area_select area_wrap" data-province="{pigcms{$Think.get.province}" data-city="{pigcms{$Think.get.city}" data-county="{pigcms{$Think.get.county}">
							<span><select name="province" id="s1"><option value="">选择省份</option></select></span>
							<span><select name="city" id="s2"><option value="">选择城市</option></select></span>
							<span><select name="county" id="s3"><option value="">选择地区</option></select></span>
							</span>
			
							<input type="submit" value="查询" class="button"/>
							<input type="button" value="导出" class="button search_checkout"  />
						</form>
					</td>
				</tr>
			</table>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>编号</th>
                                <th>店铺名称</th>
								<th>主营类目</th>
								<th style="text-align: right;width:110px">可提现余额(元)</th>
								<th style="text-align: right;width:110px">待结算余额(元)</th>
								<th style="text-align: right;width:110px">待处理提现(元)</th>
								<th style="text-align: right;width:110px">平台保证金(元)</th>
								<th style="text-align: right;width:110px">店铺积分(元)</th>
								<?php if(in_array($my_version,array(4,8))) {?>
									<th class="textcenter" style="width: 135px">综合展示<img title="开启后将会在微信综合商城 和 pc综合商城展示" class="tips_img cursor" src="./source/tp/Project/tpl/Static/images/help.gif"></th>
								<?php }?>
								<if condition="C('config.is_show_float_menu') eq '1'">
									<th class="textcenter" style="width: 135px">浮动菜单<img title="开启后将会在wap端微页面和详情页显示浮动菜单" class="tips_img cursor" src="./source/tp/Project/tpl/Static/images/help.gif"></th>
								</if>
                                <th class="textcenter">认证</th>
								<th class="textcenter">状态</th>
                                <th class="textcenter">创建时间</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($stores)">
								<volist name="stores" id="store">
									<tr>
										<td>{pigcms{$store.store_id}</td>
                                        <td>
											{pigcms{$store.type} <a href="{pigcms{:U('User/tab_store',array('uid'=>$store['uid']))}" target="_blank">{pigcms{$store.name}</a>
											<p class="gray">账号：{pigcms{$store.username}</p>
											<p class="gray">商户：{pigcms{$store.nickname}</p>
											<p class="gray">电话：{pigcms{$store.tel}</p>
										</td>
										<td>{pigcms{$store.category}</td>
                                        <td style="text-align: right">{pigcms{$store.balance|number_format=###, 2, '.', ''}</td>
                                        <td style="text-align: right">{pigcms{$store.unbalance|number_format=###, 2, '.', ''}</td>
										<td style="text-align: right">{pigcms{$store.unwithdrawal_amount}</td>
										<td style="text-align: right"><a href="{pigcms{:U('Credit/depositRecord',array('store'=>$store['name']))}">{pigcms{$store.margin_balance}</a></td>
										<td style="text-align: right"><a href="{pigcms{:U('Credit/record',array('record_type' => 2, 'ktype' => 'store', 'keyword' => $store['name']))}">{pigcms{$store.point_balance}</a></td>
										<?php if(in_array($my_version,array(4,8))) {?>                                       
										<td class="textcenter" datas="{pigcms{$store.store_id}">
											<span class="diplays">
											<if condition="$store['public_display'] eq 1">
											正常展示
											<else/>
											已经关闭
											</if>
											</span>
											<span class="display_edit cursor" title="点击修改" style="">&nbsp;</span>
											<span class="display_save cursor" title="点击保存修改" style="display:none">&nbsp;</span>
										</td>
									   <?php }?>
									   	<if condition="C('config.is_show_float_menu') eq '1'">
									   		<td style="text-align: right">
									   			<span class="cb-enable status-enable"><label class="cb-enable <?php if ($store['is_show_float_menu'] == 1) { ?>selected<?php } ?>" data-id="<?php echo $store['store_id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$store['is_show_float_menu'] eq 1">checked="checked"</if> /></label></span>
												<span class="cb-disable status-disable"><label class="cb-disable <?php if ($store['is_show_float_menu'] == 0) { ?>selected<?php } ?>" data-id="<?php echo $store['store_id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$store['is_show_float_menu'] eq 0">checked="checked"</if>/></label></span>
									   		</td>
									   	</if>
                                        <td class="textcenter"><if condition="$store['approve'] eq 1"><a style="color:green; cursor:pointer" onclick="window.top.artiframe('{pigcms{:U('Store/certification_detail',array('id'=>$store['store_id'],'frame_show'=>true))}','店铺详细 - {pigcms{$store.name}',650,500,true,false,false,editbtn,'add',true);" href="javascript:void(0)">已认证</a><elseif condition="$store['approve'] eq 2" /><a onclick="window.top.artiframe('{pigcms{:U('Store/certification_detail',array('id'=>$store['store_id'],'frame_show'=>true))}','店铺详细 - {pigcms{$store.name}',650,500,true,false,false,editbtn,'add',true);" style="color:orange; cursor:pointer">认证中</a><elseif condition="$store['approve'] eq 3"/><a onclick="window.top.artiframe('{pigcms{:U('Store/certification_detail',array('id'=>$store['store_id'],'frame_show'=>true))}','店铺详细 - {pigcms{$store.name}',650,500,true,false,false,editbtn,'add',true);" style="color:red; cursor:pointer">认证不通过</a><else/><span style="color:red">未认证</span></if></td>
										<td class="textcenter">
											<if condition="$store['status'] eq 1">
												<span style="color:green">正常</span>
											<elseif condition="$store['status'] eq 2"/>
												<span style="color:red">待审核</span>
											<elseif condition="$store['status'] eq 3"/>
												<span style="color:red">关闭或审核失败</span>
											<elseif condition="$store['status'] eq 4"/>
												<span style="color:red">用户关闭</span>
											<elseif condition="$store['status'] eq 5"/>
												<span style="color:red">供货商关闭</span>
											</if>
										</td>
										<td class="textcenter">
											{pigcms{$store.date_added|date='Y-m-d', ###}
											<br/>
											{pigcms{$store.date_added|date='H:i:s', ###}
										</td>
                                        <td class="textcenter">
											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/check',array('id' => $store['store_id']))}','店铺对账 - {pigcms{$store.name}',800,600,true,false,false,false,'inoutdetail',true);">店铺对账</a> |
											<a href="{pigcms{:U('Store/detail',array('id'=>$store['store_id'],'frame_show'=>true))}">查看详细</a> <br/>
											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/inoutdetail',array('id' => $store['store_id']))}','收支明细 - {pigcms{$store.name}',700,500,true,false,false,false,'inoutdetail',true);">收支明细</a> |
											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Order/withdraw',array('id' => $store['store_id']))}','提现记录 - {pigcms{$store.name}',700,500,true,false,false,false,'withdraw',true);">提现记录</a> <br/>
											<a href="{pigcms{:U('User/tab_store',array('uid'=>$store['uid']))}" target="_blank">进入店铺</a>
										</td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" <?php if(in_array($my_version,array(4,8))) {?>colspan="15"  <?php }else{?>colspan="14"<?php }?>  >{pigcms{$page}</td></tr>
							<else/>
								<tr><td class="textcenter red" <?php if(in_array($my_version,array(4,8))) {?>colspan="15"  <?php }else{?>colspan="14"<?php }?> >列表为空！</td></tr>
							</if>
						</tbody>
					</table>
				</div>
			</form>
		</div>
<script>
$(function(){
	//是否启用
	$('.status-enable > .cb-enable').click(function(){
		if (!$(this).hasClass('selected')) {
			var store_id = $(this).data('id');
			$.post("<?php echo U('Store/show_menu'); ?>",{'is_show_float_menu': 1, 'store_id': store_id}, function(data){})
		}
	})
	$('.status-disable > .cb-disable').click(function(){
		if (!$(this).hasClass('selected')) {
			var store_id = $(this).data('id');
			if (!$(this).hasClass('selected')) {
				$.post("<?php echo U('Store/show_menu'); ?>", {'is_show_float_menu': 0, 'store_id': store_id}, function (data) {})
			}
		}
	})
});
</script>

<script type="text/javascript" src="{pigcms{$static_public}js/layer/layer.min.js"></script>

<script type="text/javascript">
    $(function() {

       $(".search_checkout").click(function(){
  
            var loadi =layer.load('正在导出', 10000000000000);

            var searchcontent = encodeURIComponent(window.location.search.substr(1));

            $.post(
                    "{pigcms{:U('Store/index')}",
                    {"searchcontent":searchcontent},
                    function(obj) {
                        layer.close(loadi);
                        if(obj.msg>0) {
                            layer.confirm('该条件下有记录  '+obj.msg+' 条，确认导出？',function(index){
                               layer.close(index);
                               location.href="{pigcms{:U('Store/index')}&searchcontent="+searchcontent+"&download=1";
                            });
                        } else {
                            layer.alert('该搜索条件下没有数据，无需导出！', 8); 
                        }
                        
                    },
                    'json'
            )

        })

    })
</script>

<script type="text/javascript" src="{pigcms{$static_public}js/area/area.min.js"></script>
<script>
$(function(){
	if($('.area_wrap').data('province') == ''){
		getProvinces('s1','');
	}else{
		getProvinces('s1',$('.area_wrap').data('province'));
		getCitys('s2','s1',$('.area_wrap').data('city'));
		getAreas('s3','s2',$('.area_wrap').data('county'));
	}

	$('#s1').live('change',function(){
		if ($(this).val() != '') {
			getCitys('s2','s1','');
		} else {
			$('#s2').html('<option value="">选择城市</option>');
		}

		$('#s3').html('<option value="">选择地区</option>');
	});

	$('#s2').live('change',function(){
		if ($(this).val() != '') {
			getAreas('s3','s2','');
		} else {
			$('#s3').html('<option value="">选择地区</option>');
		}

	});

})
</script>
<include file="Public:footer"/>