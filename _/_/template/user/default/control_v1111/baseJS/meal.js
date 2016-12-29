/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t;
$(function(){
	location_page(location.hash);
	$('.dianpu_left a').live('click',function(){
		try {
			var mark_arr = $(this).attr("href").split("#");
			location_page("#" + mark_arr[1]);
		} catch(e) {
			location_page(location.hash);
		}
	});




    //上传店铺Logo
    $('.js-add-picture').live('click',function(){
        upload_pic_box(1,true,function(pic_list){
            if(pic_list.length > 0){
                for(var i in pic_list){
                    $('.avatar-img').attr('src', pic_list[i]);
                }
            }
        },1);
    });
	

    });



	$('.js-contact-submit').live('click', function(){
		layer.closeAll();
		var formObj = {};
		var form = $('.form-horizontal').serializeArray();
		$.each(form,function(i,field){
			formObj[field.name] = field.value;
		});

		$.post(store_contact_url,formObj,function(result){
			if(typeof(result) == 'object'){
				if(result.err_code){
					layer_tips(1,result.err_msg);
				}else{
					layer_tips(0,result.err_msg);
				}
			}else{
				layer_tips('系统异常，请重试提交');
			}
		});
	});
	
	$('.js-add-physical-picture').live('click',function(){
		if($('.js-img-list li').size() >= 5){
			layer_tips(1,'商品图片最多支持 5 张');
			return false;
		}else{
			upload_pic_box(1,true,function(pic_list){
				if(pic_list.length > 0){
					for(var i in pic_list){
						var list_size = $('.js-img-list li').size();
						if(list_size > 5){
							layer_tips(1,'商品图片最多支持 5 张');
							return false;
						}else{
							$('.js-img-list').append('<li class="upload-preview-img"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
						}
					}
				}
			},5-$('.js-img-list li').size());
		}
    });
	$('.js-delete-picture').live('click',function(){
		$(this).closest('li').remove();
	});
	$('.js-physical-submit').live('click', function(){
		var nowDom = $(this);
		layer.closeAll();
		var formObj = {};
		var form = $('.form-horizontal').serializeArray();
		$.each(form,function(i,field){
			formObj[field.name] = field.value;
		});
		
		if($('.js-img-list li a img').size() == 0){
			layer_tips(1,'请上传不多于5张的门店照片');
		}
		formObj['images'] = [];
		$.each($('.js-img-list li a img'),function(i,item){
			formObj['images'][i] = $(item).attr('src');
		});
		nowDom.prop('disabled',true).html('添加中...');

		
		$.post(store_physical_add_url,formObj,function(result){
			if(typeof(result) == 'object'){
				if(result.err_code){
					nowDom.prop('disabled',false).html('添加');
					layer_tips(1,result.err_msg);
				}else{
					window.location.hash = 'list';
					window.location.reload();
					layer_tips(0,result.err_msg);
				}
			}else{
				nowDom.prop('disabled',false).html('添加');
				layer_tips(1,'系统异常，请重试提交');
				
			}
		});
	});
	
	$('.js-physical-edit-submit').live('click', function(){
		var nowDom = $(this);
		layer.closeAll();
		var formObj = {};
		var form = $('.form-horizontal').serializeArray();
		$.each(form,function(i,field){
			formObj[field.name] = field.value;
		});
		for(var i in formObj){
			var value = formObj[i];
			switch(i){
				case 'name':
					if(value=='' || value.length>20){
						layer_tips(1,'门店名称必填且必须小于20个字符');
						$('input[name="name"]').focus();
						return false;
					}
					break;
				case 'phone1':
					if(value!= '' && !/^\d+$/.test(value)){
						layer_tips(1,'区号为数字');
						$('input[name="phone1"]').focus();
						return false;
					}
					break;
				case 'phone2':
					if(!/^\d+$/.test(value)){
						layer_tips(1,'电话为数字');
						$('input[name="phone2"]').focus();
						return false;
					}
					break;
				case 'province':
				case 'city':
				case 'county':
					if(!/^\d+$/.test(value)){
						layer_tips(1,'联系地址 区域 未选择');
						$('input[name="address"]').focus();
						return false;
					}
					break;
				case 'address':
					if(value.length == 0){
						layer_tips(1,'详细地址未填写');
						$('input[name="address"]').focus();
						return false;
					}
					break;
				case 'map_lat':
				case 'map_long':
					if(value.length == 0){
						layer_tips(1,'请点击地图、在地图中标识地理位置');
						return false;
					}
					break;
			}
		}
		if($('.js-img-list li a img').size() == 0){
			layer_tips(1,'请上传不多于5张的门店照片');
		}
		formObj['images'] = [];
		$.each($('.js-img-list li a img'),function(i,item){
			formObj['images'][i] = $(item).attr('src');
		});
		nowDom.prop('disabled',true).html('保存中...');
		$.post(store_physical_edit_url,formObj,function(result){
			if(typeof(result) == 'object'){
				if(result.err_code){
					nowDom.prop('disabled',false).html('保存');
					layer_tips(1,result.err_msg);
				}else{
					window.location.reload();
					layer_tips(0,result.err_msg);
				}
			}else{
				nowDom.prop('disabled',false).html('保存');
				layer_tips('系统异常，请重试提交');
			}
		});
	});
	$('.physical_list .js-delete').live('click',function(e){
		var pigcms_id = $(this).attr('data-id');
        button_box($(this), e, 'left', 'confirm', '确定删除？', function(){
            $.post(store_physical_del_url, {'pigcms_id': pigcms_id}, function(data){
                if (!data.err_code) {
                    $('.notifications').html('<div class="alert in fade alert-success">' + data.err_msg + '</div>');
                    window.location.reload();
                } else {
                    $('.notifications').html('<div class="alert in fade alert-error">' + data.err_msg + '</div>');
                }
                t = setTimeout('msg_hide()', 3000);
                close_button_box();
            });
        });
	});
})

function msg_hide() {
    $('.notifications').html('');
    clearTimeout(t);
}