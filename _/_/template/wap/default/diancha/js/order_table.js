$(document).ready(function() {
	$('.select_list li.selected').each(function() {
		$(this).parents('.edit_table').find('.edit_input input').val($(this).text())
	});
	$('.fast_type').click(function() {
		$('.normal_order.cur_order').removeClass('cur_order')
		$('.fast_order').addClass('cur_order');
		$(this).addClass('cur_type');
		$('.normal_type.cur_type').removeClass('cur_type');
	});
	$('.normal_type').click(function() {
		$('.fast_order.cur_order').removeClass('cur_order')
		$('.normal_order').addClass('cur_order');
		$(this).addClass('cur_type');
		$('.fast_type.cur_type').removeClass('cur_type');
	});
	$(document).ready(function() {
		$("#fast_order input").on('input change',function() {
			if($("#fast_order").Validform().check()){
				$('#fast_order .order_submit').attr('disabled', false);
			}else{
				$('#fast_order .order_submit').attr('disabled', 'disabled');
			}
		});
		$("#normal_order input").on('input change',function() {
			if($("#normal_order").Validform().check()){
				$('#normal_order .order_submit').attr('disabled', false);
			}else{
				$('#normal_order .order_submit').attr('disabled', 'disabled');
			}
		});
	});
	$('.select_box').each(function() {
		var input_box = $(this).parents('.edit_item');
		var input_show = input_box.find('.edit_input input.show-value');
		var input_hide = input_box.find('.edit_input input.hide-value');
		var box = $(this);
		var bg = $('.body_dark');
		$(this).find('.select_list ul li').click(function() {
			box.hide();
			bg.hide();
			$('.select_list ul li.selected').removeClass('selected');
			$(this).addClass('selected');
			input_show.val($(this).text());
			input_hide.val($(this).attr('data-value'))
			if($("#normal_order").Validform().check()){
				$('#normal_order .order_submit').attr('disabled', false);
			}else{
				$('#normal_order .order_submit').attr('disabled', 'disabled');
			}
		});
		$(this).find('i.close_btn').click(function() {
			box.hide();
			bg.hide();
		});
		input_show.click(function() {
			box.show();
			bg.show();
		});
	});
	$('span.num_less').click(function() {
		var input = $(this).parents('.edit_num').find('input');
		if (input.val()>1) {
			input.val(parseInt(input.val())-1)
		} else{
			input.val('1')
		};
	});
	$('span.num_add').click(function() {
		var input = $(this).parents('.edit_num').find('input');
		input.val(parseInt(input.val())+1)
	});
});