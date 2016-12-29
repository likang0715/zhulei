/**
 * Created by pigcms_21 on 2015/10/8.
 */
var t;
$(function(){

	load_page('.app__content', load_url,{page:'store_content'}, '');

    $('.js-team-name-edit').live('click', function(){
        $('.js-team-name-input').removeClass('hide');
        $('.js-team-name-text').addClass('hide');
    })

    //店铺配置
    $('.js-physical-edit-submit').live('click', function(){
        if ($.trim($("input[name='team_name']").val()) == '') {
            $("input[name='team_name']").closest('.control-group').addClass('error');
            $("input[name='team_name']").next('.error-message').html('店铺名称不能为空');
            return false;
        }
        var name = $("input[name='team_name']").val();


        if (!$('.error').length) {

			$.post(store_physical_edit_url,{ name:name },function(result){
				if (!result.err_code) {
					$('.js-team-name-input').addClass('hide');
			        $('.js-team-name-text').removeClass('hide');
			        $('.js-team-name-text span').text(name);
                    layer_tips(0,result.err_msg);
				} else {
					layer_tips(1,result.err_msg);
				}
			});
        } else {
            return false;
        }
    });

})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}