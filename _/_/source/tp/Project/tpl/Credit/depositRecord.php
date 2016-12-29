<include file="Public:header"/>
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
<script type="text/javascript" src="{pigcms{$static_public}js/area/area.min.js"></script>
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
            <a href="{pigcms{:U('Credit/depositRecord')}" class="on">平台充值现金流水</a>
            <span class="red">平台充值现金总额： <?php echo  number_format($commons_data['margin']['value'], 2, '.', '');?></span>
           	
           	<?php ?>
           	&#12288;
            <gt name="Think.get.type" value="0">
               <span class="red">当前搜索结果 ：充入平台充值现金：{pigcms{$get_margin_count}</span>
               <span class="red">平台扣除： {pigcms{$out_margin_count} <eq name="Think.get.type" value="2">(包含退单的数据)</eq> </span>
               <span class="red">返回总额： {pigcms{$return_margin_count}</span>
           </gt>
            </li>
        </ul>
    </div>
    <form action="{pigcms{:U('Credit/depositRecord')}" method="get">
     <table class="search_table" width="100%">
        <tr>
            <td width="80">店铺名称: </td>
            <td>
                <input type="hidden" name="c" value="Credit"/>
                <input type="hidden" name="a" value="depositRecord"/>
                <input type="text" name="store" class="input-text" value="{pigcms{$_GET['store']}" />&nbsp;&nbsp;
                类型：
                <select name="type">
                    <volist name="typelist" id="type">
                        <option value="{pigcms{$key}" <if condition="$nowtype eq $key">selected="true"</if>>{pigcms{$type}</option>
                    </volist>
                </select>
                &nbsp;&nbsp;
                订单: <input type="text" name="order_no" class="input-text" value="{pigcms{$_GET['order_no']}" placeholder="订单号/支付流水号" />
                &nbsp;&nbsp;
                支付方式：
                <select name="payment_method">
                    <option value="">全部</option>
                    <volist name="payment_methods" id="payment_method">
                        <option value="{pigcms{$key}" <if condition="$selected_payment_method eq $key">selected="true"</if>>{pigcms{$payment_method.name}</option>
                    </volist>
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
                <input type="text" name="start_time" id="js-start-time" class="input-text Wdate" style="width: 150px" value="{pigcms{$Think.get.start_time}" />- <input type="text" name="end_time" id="js-end-time" style="width: 150px" class="input-text Wdate" value="{pigcms{$Think.get.end_time}" />
                <span class="date-quick-pick" data-days="7">最近7天</span>
                <span class="date-quick-pick" data-days="30">最近30天</span>
            </td>
        </tr>
        <tr>
            <td>所属区域：</td>
            <td>
                <div style="display:inline-block;" class="area_select area-wrap" data-province="{pigcms{$province}" data-city="{pigcms{$city}" data-county="{pigcms{$county}">
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
            <if condition="is_array($list)">
                <volist name="list" id="lists">
                    <tr>
                        <td>
                            {pigcms{$lists.order_no}<br/>
                            <span class="c-gray">{pigcms{$lists.trade_no}</span><br/>
                            <span class="c-gray">{pigcms{$payment_methods[$lists['payment_method']]['name']}</span>
                        </td>
                        <td>{pigcms{$lists.store}</td>
						<td><if condition="$lists['amount'][0] neq '-'">+</if>{pigcms{$lists.amount}</td>
						<td>{pigcms{$lists.invite_admin}</td>
						<td>{pigcms{$lists.area_admin}</td>
                        <td>{pigcms{$lists.bak}</td>
                        <td>{pigcms{$lists.add_time|date='Y-m-d H:i:s', ###}</td>
                        <?php
                        //if($lists['type'] == 0){
                            if($lists['status'] == 2){
                                echo '<td>已处理</td>';
                            }else if($lists['status'] == 1){
                                echo '<td>未处理</td>';
                            }else{
                                echo '<td>未支付</td>';
                            }
                        //}else{
                            //echo '<td></td>';
                        //}     
                        ?>
                        
                        <!-- <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Order/detail',array('id' => $lists['order_id'], 'frame_show' => true))}','订单详情 #{pigcms{$lists.order_no}',750,700,true,false,false,false,'detail',true);">查看</a> -->

                         <td>
                        <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Credit/marginDetail',array('order_id' => $lists['order_id'],'order_offline_id' => $lists['order_offline_id'],'type' => $lists['type'],'add_time'=>$lists['add_time'],'status'=>$lists['status'],'amount'=>$lists['amount'],'bank_card'=>$lists['bank_card'],'bank_id'=>$lists['bank_id'],'order_no'=>$lists['order_no'],'frame_show' => true))}','订单详情 #{pigcms{$lists.order_no}',750,700,true,false,false,false,'detail',true);">查看</a>
                        </td>

                        

                    </tr>
                </volist>
            </if>
            </tbody>
            <tfoot>
            <if condition="is_array($list)">
                <tr>
                    <td class="textcenter pagebar" colspan="14">{pigcms{$page}</td>
                </tr>
                <else/>
                <tr><td class="textcenter red" colspan="14">列表为空！</td></tr>
            </if>
            </tfoot>
        </table>
    </div>

</div>
<include file="Public:footer"/>

<script type="text/javascript" src="{pigcms{$static_public}js/layer/layer.min.js"></script>

<script type="text/javascript">
    $(function() {

       $(".export-button").click(function(){
            
            var searchtype = $(this).data('id');
            var loadi =layer.load('正在导出', 10000000000000);

            var searchcontent = encodeURIComponent(window.location.search.substr(1));

            $.post(
                    "{pigcms{:U('Credit/depositRecord')}",
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
                               location.href="{pigcms{:U('Credit/depositRecord')}&searchtype="+searchtype+"&searchcontent="+searchcontent+"&download=1";
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