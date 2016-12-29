<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
			<?php if($withdrawal_count > 0): ?><script type="text/javascript">
					$(function(){
						$('#nav_4 > dd > #leftmenu_Order_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
					})
				</script><?php endif; ?>
			<?php if($unprocessed > 0): ?><script type="text/javascript">
					$(function(){
						if ($('#leftmenu_Credit_returnRecord', parent.document).length > 0) {
							var menu_html = $('#leftmenu_Credit_returnRecord', parent.document).html();
							menu_html = menu_html.split('(')[0];
							menu_html += ' <label style="color:red">(<?php echo ($unprocessed); ?>)</label>';
							$('#leftmenu_Credit_returnRecord', parent.document).html(menu_html);
						}
					})
				</script><?php endif; ?>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
<?php if($withdrawal_count > 0): ?><script type="text/javascript">
    $(function(){
	    $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
    })
</script>
<?php else: ?>
    <script type="text/javascript">
        $(function(){
           // $('#nav_12 > dd:last-child > span', parent.document).html('提现记录');

	        $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录');
			
			
        })
    </script><?php endif; ?>
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
					<a href="<?php echo U('Store/index');?>" class="on">店铺列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="<?php echo U('Store/index');?>" method="get">
							<input type="hidden" name="c" value="Store"/>
							<input type="hidden" name="a" value="index"/>
							筛选: <input type="text" name="keyword" class="input-text" value="<?php echo ($_GET['keyword']); ?>" />
							<select name="type">
								<option value="name" <?php if($_GET['type'] == 'name'): ?>selected="selected"<?php endif; ?>>店铺名称</option>
								<option value="store_id" <?php if($_GET['type'] == 'store_id'): ?>selected="selected"<?php endif; ?>>店铺编号</option>
                                <option value="user" <?php if($_GET['type'] == 'uid'): ?>selected="selected"<?php endif; ?>>商户编号</option>
								<option value="account" <?php if($_GET['type'] == 'account'): ?>selected="selected"<?php endif; ?>>商户昵称</option>
								<option value="tel" <?php if($_GET['type'] == 'tel'): ?>selected="selected"<?php endif; ?>>联系电话</option>
							</select>
							&nbsp;&nbsp;
							店铺类型：
							<select name="store_type">
								<option value="0">店铺类型</option>
								<option value="1" <?php if($_GET['store_type'] == 1): ?>selected="selected"<?php endif; ?>>供货商</option>
								<option value="2" <?php if($_GET['store_type'] == 2): ?>selected="selected"<?php endif; ?>>分销商</option>
							</select>
                            &nbsp;&nbsp;主营类目：
                            <select name="sale_category">
                                <option value="0">主营类目</option>
                                <?php if(is_array($sale_categories)): $i = 0; $__LIST__ = $sale_categories;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sale_category): $mod = ($i % 2 );++$i;?><option value="<?php echo ($sale_category["cat_id"]); ?>" <?php if($_GET['sale_category']== $sale_category['cat_id']): ?>selected="true"<?php endif; ?>><?php echo ($sale_category["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            &nbsp;&nbsp;认证：
                            <select name="approve">
                                <option value="*">认证状态</option>
                                <option value="0" <?php if (isset($_GET['approve']) && is_numeric($_GET['approve']) && $_GET['approve'] == 0) { ?>selected<?php } ?>>未认证</option>
                                <option value="1" <?php if($_GET['approve']== 1): ?>selected<?php endif; ?>>已认证</option>
								 <option value="2" <?php if($_GET['approve']== 2): ?>selected<?php endif; ?>>认证中</option>
								  <option value="3" <?php if($_GET['approve']== 3): ?>selected<?php endif; ?>>认证不通过</option>
                            </select>
                            &nbsp;&nbsp;状态：
                            <select name="status">
                                <option value="*">店铺状态</option>
                                <option value="1" <?php if($_GET['status']== 1): ?>selected<?php endif; ?>>正常</option>
			            		<option value="2" <?php if($_GET['status']== 2): ?>selected<?php endif; ?>>待审核</option>
			            		<option value="3" <?php if($_GET['status']== 3): ?>selected<?php endif; ?>>关闭或审核失败</option>
								<option value="4" <?php if($_GET['status']== 3): ?>selected<?php endif; ?>>用户关闭店铺</option>
			            		<option value="5" <?php if($_GET['status']== 5): ?>selected<?php endif; ?>>供货商关闭</option>
                            </select>

							&nbsp;&nbsp;区域：
							<span class="area_select area_wrap" data-province="<?php echo ($_GET['province']); ?>" data-city="<?php echo ($_GET['city']); ?>" data-county="<?php echo ($_GET['county']); ?>">
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
								<?php if(C('config.is_show_float_menu') == '1'): ?><th class="textcenter" style="width: 135px">浮动菜单<img title="开启后将会在wap端微页面和详情页显示浮动菜单" class="tips_img cursor" src="./source/tp/Project/tpl/Static/images/help.gif"></th><?php endif; ?>
                                <th class="textcenter">认证</th>
								<th class="textcenter">状态</th>
                                <th class="textcenter">创建时间</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php if(is_array($stores)): if(is_array($stores)): $i = 0; $__LIST__ = $stores;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$store): $mod = ($i % 2 );++$i;?><tr>
										<td><?php echo ($store["store_id"]); ?></td>
                                        <td>
											<?php echo ($store["type"]); ?> <a href="<?php echo U('User/tab_store',array('uid'=>$store['uid']));?>" target="_blank"><?php echo ($store["name"]); ?></a>
											<p class="gray">账号：<?php echo ($store["username"]); ?></p>
											<p class="gray">商户：<?php echo ($store["nickname"]); ?></p>
											<p class="gray">电话：<?php echo ($store["tel"]); ?></p>
										</td>
										<td><?php echo ($store["category"]); ?></td>
                                        <td style="text-align: right"><?php echo (number_format($store["balance"], 2, '.', '')); ?></td>
                                        <td style="text-align: right"><?php echo (number_format($store["unbalance"], 2, '.', '')); ?></td>
										<td style="text-align: right"><?php echo ($store["unwithdrawal_amount"]); ?></td>
										<td style="text-align: right"><a href="<?php echo U('Credit/depositRecord',array('store'=>$store['name']));?>"><?php echo ($store["margin_balance"]); ?></a></td>
										<td style="text-align: right"><a href="<?php echo U('Credit/record',array('record_type' => 2, 'ktype' => 'store', 'keyword' => $store['name']));?>"><?php echo ($store["point_balance"]); ?></a></td>
										<?php if(in_array($my_version,array(4,8))) {?>                                       
										<td class="textcenter" datas="<?php echo ($store["store_id"]); ?>">
											<span class="diplays">
											<?php if($store['public_display'] == 1): ?>正常展示
											<?php else: ?>
											已经关闭<?php endif; ?>
											</span>
											<span class="display_edit cursor" title="点击修改" style="">&nbsp;</span>
											<span class="display_save cursor" title="点击保存修改" style="display:none">&nbsp;</span>
										</td>
									   <?php }?>
									   	<?php if(C('config.is_show_float_menu') == '1'): ?><td style="text-align: right">
									   			<span class="cb-enable status-enable"><label class="cb-enable <?php if ($store['is_show_float_menu'] == 1) { ?>selected<?php } ?>" data-id="<?php echo $store['store_id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <?php if($store['is_show_float_menu'] == 1): ?>checked="checked"<?php endif; ?> /></label></span>
												<span class="cb-disable status-disable"><label class="cb-disable <?php if ($store['is_show_float_menu'] == 0) { ?>selected<?php } ?>" data-id="<?php echo $store['store_id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <?php if($store['is_show_float_menu'] == 0): ?>checked="checked"<?php endif; ?>/></label></span>
									   		</td><?php endif; ?>
                                        <td class="textcenter"><?php if($store['approve'] == 1): ?><a style="color:green; cursor:pointer" onclick="window.top.artiframe('<?php echo U('Store/certification_detail',array('id'=>$store['store_id'],'frame_show'=>true));?>','店铺详细 - <?php echo ($store["name"]); ?>',650,500,true,false,false,editbtn,'add',true);" href="javascript:void(0)">已认证</a><?php elseif($store['approve'] == 2): ?><a onclick="window.top.artiframe('<?php echo U('Store/certification_detail',array('id'=>$store['store_id'],'frame_show'=>true));?>','店铺详细 - <?php echo ($store["name"]); ?>',650,500,true,false,false,editbtn,'add',true);" style="color:orange; cursor:pointer">认证中</a><?php elseif($store['approve'] == 3): ?><a onclick="window.top.artiframe('<?php echo U('Store/certification_detail',array('id'=>$store['store_id'],'frame_show'=>true));?>','店铺详细 - <?php echo ($store["name"]); ?>',650,500,true,false,false,editbtn,'add',true);" style="color:red; cursor:pointer">认证不通过</a><?php else: ?><span style="color:red">未认证</span><?php endif; ?></td>
										<td class="textcenter">
											<?php if($store['status'] == 1): ?><span style="color:green">正常</span>
											<?php elseif($store['status'] == 2): ?>
												<span style="color:red">待审核</span>
											<?php elseif($store['status'] == 3): ?>
												<span style="color:red">关闭或审核失败</span>
											<?php elseif($store['status'] == 4): ?>
												<span style="color:red">用户关闭</span>
											<?php elseif($store['status'] == 5): ?>
												<span style="color:red">供货商关闭</span><?php endif; ?>
										</td>
										<td class="textcenter">
											<?php echo (date('Y-m-d', $store["date_added"])); ?>
											<br/>
											<?php echo (date('H:i:s', $store["date_added"])); ?>
										</td>
                                        <td class="textcenter">
											<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Store/check',array('id' => $store['store_id']));?>','店铺对账 - <?php echo ($store["name"]); ?>',800,600,true,false,false,false,'inoutdetail',true);">店铺对账</a> |
											<a href="<?php echo U('Store/detail',array('id'=>$store['store_id'],'frame_show'=>true));?>">查看详细</a> <br/>
											<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Store/inoutdetail',array('id' => $store['store_id']));?>','收支明细 - <?php echo ($store["name"]); ?>',700,500,true,false,false,false,'inoutdetail',true);">收支明细</a> |
											<a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Order/withdraw',array('id' => $store['store_id']));?>','提现记录 - <?php echo ($store["name"]); ?>',700,500,true,false,false,false,'withdraw',true);">提现记录</a> <br/>
											<a href="<?php echo U('User/tab_store',array('uid'=>$store['uid']));?>" target="_blank">进入店铺</a>
										</td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								<tr><td class="textcenter pagebar" <?php if(in_array($my_version,array(4,8))) {?>colspan="15"  <?php }else{?>colspan="14"<?php }?>  ><?php echo ($page); ?></td></tr>
							<?php else: ?>
								<tr><td class="textcenter red" <?php if(in_array($my_version,array(4,8))) {?>colspan="15"  <?php }else{?>colspan="14"<?php }?> >列表为空！</td></tr><?php endif; ?>
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

<script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>

<script type="text/javascript">
    $(function() {

       $(".search_checkout").click(function(){
  
            var loadi =layer.load('正在导出', 10000000000000);

            var searchcontent = encodeURIComponent(window.location.search.substr(1));

            $.post(
                    "<?php echo U('Store/index');?>",
                    {"searchcontent":searchcontent},
                    function(obj) {
                        layer.close(loadi);
                        if(obj.msg>0) {
                            layer.confirm('该条件下有记录  '+obj.msg+' 条，确认导出？',function(index){
                               layer.close(index);
                               location.href="<?php echo U('Store/index');?>&searchcontent="+searchcontent+"&download=1";
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

<script type="text/javascript" src="<?php echo ($static_public); ?>js/area/area.min.js"></script>
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
	</body>
</html>