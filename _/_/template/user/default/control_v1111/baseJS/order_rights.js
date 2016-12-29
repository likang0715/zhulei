var detail_json_url = "http://www.weidian.com/user.php?c=order&a=detail_json";
$(function() {
	location_page(location.hash);
	$('a').live('click',function(){
		if($(this).attr('href') && $(this).attr('href').substr(0,1) == '#') {
			location_page($(this).attr('href'));
		}
	});

	function location_page(mark, page) {
		var mark_arr = mark.split('/');
		switch(mark_arr[0]){
			case '#detail':
				load_page('.app__content', load_url , {page : 'order_rights_detail', id : mark_arr[1]}, '', function () {
					
				});
				break;
			default :
				load_page('.app__content', load_url, {page : 'order_rights_list'}, '');
				break;
		}
	}
})