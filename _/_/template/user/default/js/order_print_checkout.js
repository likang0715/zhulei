var check_print_save = true;
var check_print_style = true;
var check_go_printing = true;
var check_do_ico_all_print2 = true;

$(function(){
	$(".print_style").live("click",function(){
		if(!check_print_style) return false;
		check_print_style = false;
		var loadi =layer.load('正在查询', 10000000000000);
		var iss;
		$.ajax({
			type:"POST",	
			async: false,
			url:"./user.php?c=order&a=order_printing",
			data:"types=get",
			dataType:'json',
			success:function(result){
				layer.close(loadi);
				//layer.alert("正在导出中！")
				/////////////////////////////////////
				var arr = new Array();
				var	result_text = result.text;
					layer.tab({
						data:result_text,
						area: ['850px', '450px'] //宽度，高度
					});
					check_print_style = true;
					//////////////////////////////////////
				},
				error:function(){
					layer.close(loadi);
					layer.alert("暂无订单模版！")
					check_print_style = true;
				}
			 });

		
		
})

//订单打印选择checkbox
$(".ico_all_f .print_all").live("click",function(){
	if($(this).is(":checked")) {
		$(".order_check").attr("checked",true);
	} else {
		$(".order_check").attr("checked",false);
	}
})
//订单打印选择
$(".ico_all_f .do_ico_all_print2").live("click",function(){
	if(!check_do_ico_all_print2) return false;
	check_do_ico_all_print2 = false;
		//页面层
	var check_text;
	check_text ="<ul class='ico_all_print2_ul'>";
	check_text += "<li><input type='radio' name='print_types' value='1'>&nbsp;购物清单</li>";
	check_text += "<li><input type='radio' name='print_types' value='2'>&nbsp;配货单</li>";
	check_text += "</ul>";
	
	check_text +="<center style='clear:both'><button type='button'  class='input_button go_printing'>打印</button>&#12288<button type='button' style='position:static;right:0px;top:0px;background:#FF6600' class='xubox_tabclose input_button print_return' >返回</button></center>";
	layer.tab({
		data:[{'title':'选择打印的订单类型','content':check_text}],
		area: ['550px', '140px'] //宽度，高度
	});

	check_do_ico_all_print2 = true;
})

//订单打印模板保存
$(".print_save").live("click",function(){
	if(!check_print_save) return false;
	check_print_save = false;
	var loadi2 =layer.load('正在保存！', 10000000000000);
	$(this).closest("ul").each(function(){
		if($(this).is(":visible")) {
			var print_text = $(this).find("li:visible").find(".text_printing").val();
			objcs =  $(this).find("li:visible").find(".text_printing").text();
			$(this).find("li:visible").find(".text_printing").text(print_text);
			print_text = $(this).find("li:visible").find(".text_printing").val();
			var print_id = $(this).find("li:visible").find(".text_printing").attr("data_id");
		}
	
		if(!print_id || !print_text) {
			layer.close(loadi2);
			layer.alert("模版不能为空！"); 
		}

		$.ajax({
			type:"POST",	
			async: false, 
			url:"./user.php?c=order&a=order_printing",
			data:"types=save&typeid="+print_id+"&text="+print_text,
			dataType:'json',
			success:function(result){
					layer.close(loadi2);
					
					if(result.err_code=='0') {
						layer.alert("保存模板成功！");  	
					} else {
						layer.alert(result.err_msg);
					}
					
					check_print_save = true;
				},
				error:function(){
					layer.close(loadi2);
					layer.alert("保存模板异常！");
					check_print_save = true;
				}
			 });
	})
})

//去打印
$(".go_printing").live("click",function(){
	if(!check_go_printing) return false;
	check_go_printing = false;
	var loadi =layer.load('正在跳转', 10000000000000);
	var go_printing_checked_arr = [];
	$(".order_check").each(function(){
		if($(this).is(":checked")) {
			go_printing_checked_arr.push($(this).val());
		}
	});
		
	if(!$(".ico_all_print2_ul input[type='radio']:checked").val() || !go_printing_checked_arr.length) {
		layer.close(loadi);
		layer.alert('您还没有选择要打印的订单！', 8); 
		check_go_printing = true;
		return false;
	}

	var print_type = $(".ico_all_print2_ul input[type='radio']:checked").val();
	
	window.open("./user.php?c=order&a=do_printing&print_type="+print_type+"&order_id_str="+go_printing_checked_arr);
	check_go_printing = true;
	layer.close(loadi);
	$('.xubox_tabclose').trigger("click");
	
})

$(".huifu").live("click",function(){
	var huifu_ids="";
	layer.confirm('此操作不可逆，确认要操作么？',function(index4){
		var flag=0;
		$("input[name='huifu']").each(function(){
			if ($(this).is(':checked')) { 
				huifu_ids += $(this).attr('value')+',';
				flag += 1; 
			}
		})
		if(flag == 0){
			layer.alert('还没选择要恢复的哦！', 8);
			return;
		}
		$.post(
			order_print_huifu,
			{'huifu_ids':huifu_ids},
			function(obj){
				if(obj.err_code =='0') {
					layer.alert('操作成功！', 8); 
					layer.close(index4)
					$(".xubox_tabclose").trigger("click");
				} else {
					layer.close(index4)
					layer.alert('操作异常');
				}
				
				
			},
			'json'
		)
	})
})

//导出订单
$(".checkout_orders").live("click",function(){
	var loadi =layer.load('正在查询', 10000000000000);
		var checkout_type = $("#select_checkout_type").val();

		switch(checkout_type) {
			//当前页面订单
			case 'now':
					order_no = $("input[name='order_no']").val();
					trade_no = $("input[name='trade_no']").val();
					user = $("input[name='user']").val();
					tel = $("input[name='tel']").val();
					time_type = $("select[name='time_type']").val();
					start_time = $("input[name='start_time']").val();
					stop_time = $("input[name='end_time']").val();
					type = $("select[name='type']").val();
					//status = $("select[name='status']").val();
					payment_method = $("select[name='payment_method']").val();
					shipping_method = $("select[name='shipping_method']").val();
					
					$.post(
						order_checkout_url,
						{"check_type":'now',"order_no":order_no,"trade_no":trade_no,"user":user,"tel":tel,"time_type":time_type,"start_time":start_time,"stop_time":stop_time,"type":type,"status":status,"payment_method":payment_method,"shipping_method":shipping_method},
						function(obj) {
							layer.close(loadi);
							if(obj.err_msg>0) {
								layer.confirm('该指定条件下有 订单  '+obj.err_msg+' 条，确认导出？',function(index){
								 	layer.close(index);
								 	var url=order_checkout_url+'&check_type=now&order_no='+order_no+'&trade_no='+trade_no+'&user='+user+'&tel='+tel+'&time_type='+time_type+'&start_time='+start_time+'&stop_time='+stop_time+'&type='+type+'&status='+status+'&payment_method='+payment_method+'&shipping_method='+shipping_method;
									location.href=url;
								});
							} else {
								
								layer.alert('该搜索条件下没有订单数据，无需导出！', 8); 
							}		
						},
						'json'
					)
				return;	
				break;
			
			case 'check':
					if($(".order_check:checked").length == 0) {
						layer.alert('您尚未勾选任何订单哦，无需导出！', 8); 
						return;
					} 
					var order_check_id = [];
					$(".order_check:checked").each(function(i){
						order_check_id.push($(this).val());
					})
				
					$.post(
						order_checkout_url,
						{"check_type": checkout_type,"order_check_id": order_check_id},
						function(obj) {
							layer.close(loadi);
							if(obj.err_msg>0) {
								layer.confirm('该指定条件下有 订单  '+obj.err_msg+' 条，确认导出？',function(index){
								 	layer.close(index);
								 	var url=order_checkout_url+'&check_type='+checkout_type+"&order_check_id="+order_check_id;
								 	location.href=url;
								});
							} else {
								
								layer.alert('该搜索条件下没有订单数据，无需导出！', 8); 
							}		
						},
						'json'
					)	
				
					return;
					
				break;
				
			//全部订单	
			case 'all':
				
				break;
			//全部待付款
			case '1':
				
				break;
			//全部待发货	
			case '2':
				
				break;
			//全部已完成	
			case '3':
				
				break;
			//全部已发货
			case '4':
				
				break;
			//全部已关闭	
			case '5':
				
				break;
			//全部退款中	
			case '6':
				
				break;			
		}
	
	

		$.post(
				order_checkout_url,
				{"check_type": checkout_type},
				function(obj) {
					layer.close(loadi);
					if(obj.err_msg>0) {
						layer.confirm('该指定条件下有 订单  '+obj.err_msg+' 条，确认导出？',function(index){
						 	layer.close(index);
						 	var url=order_checkout_url+'&check_type='+checkout_type;
						 	location.href=url;
						});
					} else {
						
						layer.alert('该搜索条件下没有订单数据，无需导出！', 8); 
					}		
				},
				'json'
			)			
		
		
		
		
	
})
	

})