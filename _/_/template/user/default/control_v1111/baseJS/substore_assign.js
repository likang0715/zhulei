/**
 * Created by pigcms_21 on 2015/2/6.
 */
$(function(){
	var hash_arr = location.hash.split("/");
	var current_index = 0;
	switch (hash_arr[0]) {
		case "#assign_auto" :
			current_index = 0;
			break;
		default :
			current_index = 0;
			break;
	}
	
	$(".js-app-nav").removeClass("active");
	$(".js-app-nav").eq(current_index).addClass("active");
	
	location_page(location.hash);
	$(".js-app-nav a").live("click", function () {
		$(this).closest("ul").find("li").removeClass("active");
		$(this).closest("li").addClass("active");
		location_page($(this).attr("href"));
	});
	
	function location_page(mark, page){
		var mark_arr = mark.split('/');
		switch(mark_arr[0]){
			case "#assign_auto" :
				load_page('.app__content', assign_url, {page : "assign_auto"}, '');
				break;
			default :
				load_page('.app__content', assign_url, {page : "assign_auto"}, '');
		}
	};
	



	$(".js-auto_order-status").live("click", function () {
		var obj = this;
		if ($(this).hasClass('ui-switch-off')) {
			var status = 1;
			var oldClassName = 'ui-switch-off';
			var className = 'ui-switch-on';
		} else {
			var status = 0;
			var oldClassName = 'ui-switch-on';
			var className = 'ui-switch-off';
		}
		$.post(assign_status_url, {'status': status}, function(data){
			if(!data.err_code) {
				$(obj).removeClass(oldClassName);
				$(obj).addClass(className);
			}
		})
	});

})


// 
function msg_hide() {
	$('.notifications').html('');
	clearTimeout(t);
}