/**
 * Created by pigcms_21 on 2015/11/5.
 */
var t;
$(function(){

    load_page('.app__content', load_url,{page:'wxbind_content'}, '');
	
	
	$('.del_bind').live('click',function(){
		var store_id 	= $(this).data('store_id');
		$.post(del_bind_url, {'store_id': store_id}, function(data){
			if (data.err_code == 0) {
				layer_tips(0,data.err_msg);
				setTimeout(function(){
					window.location.reload();
				},1500);
			}
		});
	});

})