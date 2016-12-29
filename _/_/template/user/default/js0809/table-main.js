function autoTable () {
	var main = $('.table-main');
	var left = $('.table-main .table_list');
	var right = $('.table-main .table_order');
	var newWidth = main.width()-right.width()-8
	left.width(newWidth)
}
function selectAll (obj,CheckBox) {
	if (obj.is(':checked')) {
		CheckBox.each(function() {
			$(this).attr("checked","checked");
		});
	}else{
		CheckBox.each(function() {
			$(this).attr("checked",false);
		});
	}
}
function catDel (id) {
	if ( typeof(id)== "object") {
		
	} else if ( typeof(id)== "number" || typeof(id)== "string") {
		String(id)
	};
}
$(document).ready(function() {
	autoTable ()
	var orderTop = $('.table_order').offset().top-36;
	var orderLeft = $('.table_order').offset().left;
	var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
	if (scrollTop>orderTop) {
		$('.table_order').addClass('table_order_fix')
		$('.table_order').css('left', orderLeft);
	} else{
		$('.table_order').removeClass('table_order_fix')
	};
	$(window).scroll(function() {
		var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
		if (scrollTop>orderTop) {
			$('.table_order').addClass('table_order_fix')
			$('.table_order').css('left', orderLeft);
		} else{
			$('.table_order').removeClass('table_order_fix')
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
	$('.js-cat-edit').live('click',function() {
		var parent = $(this).parents('.cat_item');
		var catid = parent.attr('data-catid');
		parent.find('.state-show').hide();
		parent.find('.state-edit').show();
	});
	$('.js-cat-cancel').live('click',function() {
		var parent = $(this).parents('.cat_item');
		var oldname = parent.find('.cat-name').text();
		var oldsort = parent.find('.cat-sort').text();
		parent.find('input[name="cat_name"]').val(oldname)
		parent.find('input[name="cat_sort"]').val(oldsort)
		parent.find('.state-show').show();
		parent.find('.state-edit').hide();
	});
	$('.js-cat-save').live('click',function() {
		var parents = $(this).parents('.cat_item');
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
						var nameOther = $('input[name="cat_name"]').eq(i).text();
						if ($.trim(nameOther)==$.trim(value)) {
							onename++
						};
					};
					if (onename>0) {
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
		formObj['cat_id']=catid;
		console.log(formObj)
		$.post(cat_edit_url, formObj, function(data){
            if (!data.err_code) {
                teaAlert('保存成功')
                window.location.reload();
            } else {
                teaAlert('保存失败,请重试')
                setTimeout(function () {
                	window.location.reload();
                }, 1000)
            }
        });
	});
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
$(window).resize(function() {
	autoTable ();
});
