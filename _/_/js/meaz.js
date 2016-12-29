$(function(){
$('.fetch_page').live('click', function(){
	//			alert(parseInt($(this).attr('data-page-num')));						
window.location.href = load_url+'&page=' + parseInt($(this).attr('data-page-num'));

	});
$('.page_btn').live('click', function(){
	//			alert(parseInt($(this).attr('data-page-num')));						
window.location.href = load_url+'&page=' + parseInt($(this).attr('data-page-num'));

	});
});
