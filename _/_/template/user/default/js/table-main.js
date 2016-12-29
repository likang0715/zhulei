function autoOrderDay () {
	var mainHight = $(window).height()-$('#top_bar').height()-60;
	var maxSize = parseInt(mainHight/112);
	$('.table_order_day').each(function(index) {
		if (index>=maxSize) {
			$(this).hide();
		} else{
			$(this).show();
		};
	});
}
$(document).ready(function() {
	autoOrderDay ();
	var orderTop = $('.table_order').offset().top-36;
	var orderLeft = $('.table_order').offset().left;
	var minHeight = $(window).height()-$('#top_bar').height()-100;
	var left = $('.table-main .table_list').offset().left;
	var width = $('.table-main .table_list').width();
	var fixLeft = left+width-1;
	var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
	$('.table_list').css('min-height', minHeight);
	if (scrollTop>orderTop) {
		$('.table_order').addClass('table_order_fix')
		$('.table_order').css('left', fixLeft);
	} else{
		$('.table_order').removeClass('table_order_fix');
		$('.table_order').css('left', '');
	};
	$(window).scroll(function() {
		var left = $('.table-main .table_list').offset().left;
		var width = $('.table-main .table_list').width();
		var fixLeft = left+width-1;
		var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
		if (scrollTop>orderTop) {
			$('.table_order').addClass('table_order_fix')
			$('.table_order').css('left', fixLeft);
		} else{
			$('.table_order').removeClass('table_order_fix')
			$('.table_order').css('left', '');
		};
	});
	$(window).resize(function(event) {
		autoOrderDay ();
		var left = $('.table-main .table_list').offset().left;
		var width = $('.table-main .table_list').width();
		var fixLeft = left+width-1;
		if ($('.table_order').hasClass('table_order_fix')) {
			$('.table_order').css('left', fixLeft);
		} else{
			$('.table_order').css('left', '');
		};
	});
	$('.fourth-cat-add #js-cat-add').click(function() {
		var dom = catDom.length>0?catDom:$('#cat_edit_box').html();
		teaLayer(1,dom,"茶桌分类管理",function () {
			$('#cat_edit_box').remove();
		},function () {
			catDom = $('.modal-body').html();
		})
	});
	// 全选
	$('#all_select').live('click', function() {
		if ($(this).is(':checked')) {
			$('.cat_all').each(function() {
				$(this).attr("checked","checked");
			});
		}else{
			$('.cat_all').each(function() {
				$(this).attr("checked",false);
			});
		}
	});
// 新增分类
	$('.js-add-cat').live('click',function() {
		if ($(this).hasClass('editing')) {
			teaAlert('请先保存正在编辑的分类')
		} else{
			$('.cat_item.cat_item_t').after('<div class="cat_item" data-catid=""><div class="cat_item_con list_name"><input type="checkbox" class="cat_all" value=""><span class="state-show cat-name" style="display: none;"></span><input type="text" value="" name="cat_name" class="state-edit" style="display: inline-block;"></div><div class="cat_item_con list_sort"><span class="state-show cat-sort" style="display: none;"></span><input type="text" value="" name="cat_sort" class="state-edit" style="display: inline-block;"></div><div class="cat_item_con list_btn"><span class="js-cat-save state-edit add" style="display: inline;">保存</span><span class="js-cat-cancel state-edit" style="display: inline;"> - 取消</span></div></div>')
		};
	});
// 编辑分类
	$('.js-cat-edit').live('click',function() {
		var parent = $(this).parents('.cat_item');
		var catid = parent.attr('data-catid');
		parent.find('.state-show').hide();
		parent.find('.state-edit').show();
		$('.js-add-cat').addClass('editing');
	});
// 取消编辑
	$('.js-cat-cancel').live('click',function() {
		var parent = $(this).parents('.cat_item');
		var oldname = parent.find('.cat-name').text();
		var oldsort = parent.find('.cat-sort').text();
		parent.find('input[name="cat_name"]').val(oldname)
		parent.find('input[name="cat_sort"]').val(oldsort)
		parent.find('.state-show').show();
		parent.find('.state-edit').hide();
		$('.js-add-cat').removeClass('editing');
	});
// 保存分类
	$('.js-cat-save').live('click',function() {
		var saveDom = $(this);
		var ajaxUrl = saveDom.hasClass('add')?cat_add_url:cat_edit_url;
		var parents = saveDom.parents('.cat_item');
		var catid = parents.attr('data-catid');
	    teaAlert('保存中..','loading');
	    var formObj = {};
		var form = parents.find('input[type="text"]').serializeArray();
		$.each(form, function(i, field) {
			formObj[field.name] = field.value;
		});
		for (var i in formObj) {
			var value = formObj[i];
			switch (i) {
				case 'cat_name':
				var oldname = parents.find('.cat-name').text();
				if (value == ''|| value.replace(/\s/g,"")=='') {
				    teaAlert('分类名称不能为空');
					parents.find('input[name="cat_name"]').val(value.replace(/\s/g,""));
					parents.find('input[name="cat_name"]').focus();
					return false;
				}
				if (value.length > 8) {
				    teaAlert('分类名称不能大于8个字');
					parents.find('input[name="cat_name"]').focus();
					return false;
				}
				// if (value == oldname || value.replace(/\s/g,"")==oldname.replace(/\s/g,"")) {
				//     teaAlert('分类名称和原来一样');
				// 	parents.find('input[name="cat_name"]').focus();
				// 	return false;
				// }
				var nameRepeat = function () {
					var onename = 0;
					for (var i = 0; i < $('input[name="cat_name"]').size(); i++) {
						var nameOther = $('input[name="cat_name"]').eq(i).val();
						if ($.trim(nameOther)==$.trim(value)) {
							onename++
						};
					};
					if (onename>1) {
						return false;
					}else{
						return true;
					}
				}();
				if (!nameRepeat) {
				    teaAlert('分类名称不能重复');
					parents.find('input[name="cat_name"]').focus();
					return false;
				}
				break;
				case 'cat_sort':
				if (value != '' && !/^\d+$/.test(value)) {
				    teaAlert('排序为数字');
					$('input[name="cat_sort"]').focus();
					return false;
				}
				break;
			}
		}
		if (!saveDom.hasClass('add')) {
			formObj['cat_id']=catid;
		};
		$.post(ajaxUrl, formObj, function(data){
            if (!data.err_code) {
                teaAlert('保存成功')
                setTimeout(function () {
                	window.location.reload();
                }, 500)
            } else {
                teaAlert(data.err_msg)
                setTimeout(function () {
                	window.location.reload();
                }, 500)
            }
        });
	});
// 删除分类
	$('.js-cat-del').live('click',function(e) {
		var catid = $(this).parents('.cat_item').attr('data-catid');
	    button_box($(this), e, 'left', 'confirm', '确定删除分类？', function(){
	        teaAlert('删除中..','loading')
	        $.post(cat_del_url, {'cat_id': catid}, function(data){
	            if (!data.err_code) {
	                teaAlert('删除成功')
	                window.location.reload();
	            } else {
	                teaAlert('删除失败')
	                setTimeout(function () {
	                	window.location.reload();
	                }, 1000)
	            }
	        });
	    });
	});
});