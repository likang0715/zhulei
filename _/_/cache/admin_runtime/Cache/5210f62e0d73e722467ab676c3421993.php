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
<style type="text/css">
    .c-gray {
        color: #999;
    }
    .table-list tfoot tr {
        height: 40px;
    }
    .date-quick-pick {
        display: inline-block;
        color: #07d;
        cursor: pointer;
        padding: 2px 4px;
        border: 1px solid transparent;
        margin-left: 12px;
        border-radius: 4px;
        line-height: normal;
    }
    .date-quick-pick.current {
        background: #fff;
        border-color: #07d!important;
    } 
    .date-quick-pick:hover{border-color:#ccc;text-decoration:none}
    .red{
        color:'red';
        font-weight:bold;
    }
</style>
<script type="text/javascript" src="<?php echo ($static_public); ?>js/area/area.min.js"></script>
<script>
$(function(){
	if($('.area-wrap').data('province') == ''){
		getProvinces('s1','');
	}else{
		getProvinces('s1',$('.area-wrap').data('province'));
		getCitys('s2','s1',$('.area-wrap').data('city'));
		getAreas('s3','s2',$('.area-wrap').data('county'));
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

<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
        	<li>
            <a href="<?php echo U('Credit/depositRecord');?>" class="on">平台充值现金流水</a>
            <span class="red">平台充值现金总额： <?php echo number_format($commons_data['margin']['value'], 2, '.', '');?></span>
           	
           	<?php ?>
           	&#12288;
            <?php if(($_GET['type']) > "0"): ?><span class="red">当前搜索结果 ：充入平台充值现金：<?php echo ($get_margin_count); ?></span>
               <span class="red">平台扣除： <?php echo ($out_margin_count); ?> <?php if(($_GET['type']) == "2"): ?>(包含退单的数据)<?php endif; ?> </span>
               <span class="red">返回总额： <?php echo ($return_margin_count); ?></span><?php endif; ?>
            </li>
        </ul>
    </div>
    <form action="<?php echo U('Credit/depositRecord');?>" method="get">
     <table class="search_table" width="100%">
        <tr>
            <td width="80">店铺名称: </td>
            <td>
                <input type="hidden" name="c" value="Credit"/>
                <input type="hidden" name="a" value="depositRecord"/>
                <input type="text" name="store" class="input-text" value="<?php echo ($_GET['store']); ?>" />&nbsp;&nbsp;
                类型：
                <select name="type">
                    <?php if(is_array($typelist)): $i = 0; $__LIST__ = $typelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($nowtype == $key): ?>selected="true"<?php endif; ?>><?php echo ($type); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                &nbsp;&nbsp;
                订单: <input type="text" name="order_no" class="input-text" value="<?php echo ($_GET['order_no']); ?>" placeholder="订单号/支付流水号" />
                &nbsp;&nbsp;
                支付方式：
                <select name="payment_method">
                    <option value="">全部</option>
                    <?php if(is_array($payment_methods)): $i = 0; $__LIST__ = $payment_methods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$payment_method): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($selected_payment_method == $key): ?>selected="true"<?php endif; ?>><?php echo ($payment_method["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>

                状态：
                <select name="status">
                    <option value="">全部</option>
                    <option value="1">未支付</option>
                    <option value="2">未处理</option>
                    <option value="3">已处理</option>
                  
                </select>

              


            </td>
        </tr>
        <tr>
            <td>时间：</td>
            <td>
                <input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="<?php echo ($_GET['start_time']); ?>" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="<?php echo ($_GET['end_time']); ?>" />
                <span class="date-quick-pick" data-days="7">最近7天</span>
                <span class="date-quick-pick" data-days="30">最近30天</span>
            </td>
        </tr>
        <tr>
            <td>所属区域：</td>
            <td>
                <div style="display:inline-block;" class="area_select area-wrap" data-province="<?php echo ($province); ?>" data-city="<?php echo ($city); ?>" data-county="<?php echo ($county); ?>">
                    <span><select name="province" id="s1"><option value="">选择省份</option></select></span>
                    <span><select name="city" id="s2"><option value="">选择城市</option></select></span>
                    <span><select name="county" id="s3"><option value="">选择地区</option></select></span>
                </div>
                <input type="submit" value="查询" class="button"/>
                &nbsp;&nbsp;
                <input type="button" data-id="2" value="查询并导出符合条件记录" name="all_export" class="button export-button"/>
                &nbsp;&nbsp;
                <input type="button" data-id="1" value="导出所有记录" name="search_export" class="button export-button"/>
            </td>
        </tr>
    </table>
    </form>

    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>订单号 | 支付流水号</th>
                <th>店铺名称</th>
                <th>金额</th>
                <th>客户经理(代理商)</th>
                <th>区域管理员</th>
                <th>类型</th>
                <th>时间</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lists): $mod = ($i % 2 );++$i;?><tr>
                        <td>
                            <?php echo ($lists["order_no"]); ?><br/>
                            <span class="c-gray"><?php echo ($lists["trade_no"]); ?></span><br/>
                            <span class="c-gray"><?php echo ($payment_methods[$lists['payment_method']]['name']); ?></span>
                        </td>
                        <td><?php echo ($lists["store"]); ?></td>
						<td><?php if($lists['amount'][0] != '-'): ?>+<?php endif; echo ($lists["amount"]); ?></td>
						<td><?php echo ($lists["invite_admin"]); ?></td>
						<td><?php echo ($lists["area_admin"]); ?></td>
                        <td><?php echo ($lists["bak"]); ?></td>
                        <td><?php echo (date('Y-m-d H:i:s', $lists["add_time"])); ?></td>
                        <?php
 if($lists['status'] == 2){ echo '<td>已处理</td>'; }else if($lists['status'] == 1){ echo '<td>未处理</td>'; }else{ echo '<td>未支付</td>'; } ?>
                        
                        <!-- <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Order/detail',array('id' => $lists['order_id'], 'frame_show' => true));?>','订单详情 #<?php echo ($lists["order_no"]); ?>',750,700,true,false,false,false,'detail',true);">查看</a> -->

                         <td>
                        <a href="javascript:void(0);" onclick="window.top.artiframe('<?php echo U('Credit/marginDetail',array('order_id' => $lists['order_id'],'order_offline_id' => $lists['order_offline_id'],'type' => $lists['type'],'add_time'=>$lists['add_time'],'status'=>$lists['status'],'amount'=>$lists['amount'],'bank_card'=>$lists['bank_card'],'bank_id'=>$lists['bank_id'],'order_no'=>$lists['order_no'],'frame_show' => true));?>','订单详情 #<?php echo ($lists["order_no"]); ?>',750,700,true,false,false,false,'detail',true);">查看</a>
                        </td>

                        

                    </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </tbody>
            <tfoot>
            <?php if(is_array($list)): ?><tr>
                    <td class="textcenter pagebar" colspan="14"><?php echo ($page); ?></td>
                </tr>
                <?php else: ?>
                <tr><td class="textcenter red" colspan="14">列表为空！</td></tr><?php endif; ?>
            </tfoot>
        </table>
    </div>

</div>
	</body>
</html>

<script type="text/javascript" src="<?php echo ($static_public); ?>js/layer/layer.min.js"></script>

<script type="text/javascript">
    $(function() {

       $(".export-button").click(function(){
            
            var searchtype = $(this).data('id');
            var loadi =layer.load('正在导出', 10000000000000);

            var searchcontent = encodeURIComponent(window.location.search.substr(1));

            $.post(
                    "<?php echo U('Credit/depositRecord');?>",
                    {"searchtype":searchtype,"searchcontent":searchcontent},
                    function(obj) {
                        layer.close(loadi);
                        if(obj.msg>0) {
                            if(searchtype == 2){
                                var type_msg = '该指定条件下有 ';
                            }else{
                                var type_msg = '全部';
                            }
                            layer.confirm(type_msg+'记录  '+obj.msg+' 条，确认导出？',function(index){
                               layer.close(index);
                               location.href="<?php echo U('Credit/depositRecord');?>&searchtype="+searchtype+"&searchcontent="+searchcontent+"&download=1";
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