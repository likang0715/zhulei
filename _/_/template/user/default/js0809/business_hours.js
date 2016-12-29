$(function(){
	load_page('.app__content',load_url,{page:'business_hours_list'},'');
});

/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
	location_page(location.hash);
	$('a').live('click',function(){
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') location_page($(this).attr('href'),$(this));
	});
	
	function location_page(mark,dom){
		var mark_arr = mark.split('/');
		
		switch(mark_arr[0]){
			case '#create':
			load_page('.app__content', load_url,{page:'business_hours_list'}, '',function(){
					//page_create(1);
				});
				break;
			case "#edit":
				if(mark_arr[1]){
					load_page('.app__content', load_url,{page:'edit_business_hours',id:mark_arr[1]},'',function(){
					});
				}else{
					layer.alert('非法访问！');
					location.hash = '#list';
					location_page('');
				}
				break;
			default:
				load_page('.app__content', load_url,{page:'business_hours_list'}, '');
		}
	}
	

	$('.bind_qrcode').live('click',function(){
		load_page('.app__content', load_url,{page:'business_hours_create'}, '',function(){
					//page_create(1);
				});
	});
	
	$('.js-delete').live('click',function(){
		var sid 	= $(this).attr('sid');
		if(confirm('确认要删除吗？')){
			$.post(delete_url,{sid:sid},function(res){
				if(res.err_code == 0){
					layer_tips(0,res.err_msg);
					setTimeout(function(){
							window.location=default_url;
						},1000);
				}else{
					layer_tips(1,res.err_msg);
				}
			});
		}
	
	});
	
	$('.js_open').live('click',function(){
		var sid=$(this).attr('sid');
		if(confirm('确认要修改状态吗？')){
			$.post(status_url,{sid:sid},function(res){
				if(res.err_code == 0){
					layer_tips(0,res.err_msg);
					setTimeout(function(){
							window.location=default_url;
						},1000);
				}else{
					layer_tips(1,res.err_msg);
				}
			});
		}
	})
	
	$('.submit-edit').live('click',function(){
		var id=$(this).attr('sid');
		var start_time=$('.js-start-time').val();
		var end_time=$('.js-end-time').val();
		if(confirm('确认要修改吗？')){
			$.post(edit_act_url,{id:id,start_time:start_time,end_time:end_time},function(res){
				if(res.err_code == 0){
					layer_tips(0,res.err_msg);
					setTimeout(function(){
							window.location=default_url;
						},1000);
				}else{
					layer_tips(1,res.err_msg);
				}
			});
		}
	});
	
	$('.submit-btn').live('click',function(){
		var flag=true;
		
		var bus_val_arr=[];
		$('.business_time').each(function(){
			if($(this).val()){
				bus_val_arr.push($(this).val());
			}
		});

		if(bus_val_arr.length==0||(bus_val_arr.length%2==1)){
			layer_tips(1,'时间段请填写完整！');
			flag 	= false;
			return flag;
		}

var bus_val_str=bus_val_arr.join(',');
		if(flag){
			$.post(add_url,{bus_val_str:bus_val_str},function(res){
				if(res.err_code){
					layer_tips(1,res.err_msg);
				}else{
					layer_tips(0,res.err_msg);
						setTimeout(function(){
							window.location=default_url;
						},1000);
				}
			});
		}
		
	});
	
	
	
$('#js-start-time').live('change',function(){
	var current_time=$(this).val();
	$.post(change_url,{current_time:current_time},function(res){
		time_change(res);
	});
});



$('#js-end-time').live('change',function(){
	var current_time=$(this).val();
	
	$.post(change_url,{current_time:current_time},function(res){
		time_change(res);
	});
});

function time_change(res){
	if(res.err_code == 1){
			layer_tips(1,res.err_msg);
			$('.ui-btn-primary').attr('disabled',true);
			$('.ui-btn-primary').css({'background':'gray','border-color':'gray'});
		}else{
			$('.ui-btn-primary').attr('disabled',false);
			$('.ui-btn-primary').css({'background':'#07d','border-color':'#006cc9'});
		}
	}
})