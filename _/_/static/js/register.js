// 商家入驻  @古德20160705
$(document).ready(function() {
	newid = $('#newid_btn').val();
	$('#store_name').on('blur', function(){
		checkStorename ();
	})
	$('#store_name').focus(function(){
		$(this).next('.error-message').remove();
	})
    // 主营类目
    var categories = $.parseJSON(json_categories);
    for (var i in categories) {
    	$('#category_top').prepend('<option value="'+categories[i].cat_id+'">'+categories[i].name+'</option>')
    };
    $('#category_top').change(function() {
    	var cat_id = $(this).val();
    	if (cat_id!= '' && cat_id!= undefined && categories[cat_id]['children'] != '' && categories[cat_id]['children'] != undefined) {

    		if ($('#category_child').size()==0) {

    			$('#sale_category').append('<select name="sale_category_id" id="category_child" ></select>')

    		} else{

    			$('#category_child').html('')

    		};


    		for (var j in categories[cat_id]['children']) {

    			$('#category_child').prepend('<option value="'+categories[cat_id]['children'][j].cat_id+'">'+categories[cat_id]['children'][j].name+'</option>')
    		}

    	}else{

    		$('#category_child').remove();

    	}
    });
	// 城市级联
	getProvinces('s1', '');
	$('#s1').change(function(){
		$('#s2').html('<option>选择城市</option>');
		if($(this).val() != ''){
			getCitys('s2','s1','');
		}
		$('#s3').html('<option>选择地区</option>');
	});
	$('#s2').change(function () {
		getAreas('s3', 's2', '');
	});
	$.getScript('./static/js/webuploader/webuploader.js',function(){
		$('.img_info').each(function() {
			var curthis = $(this);
			var curid = $(this).attr('id');
			if(!WebUploader.Uploader.support()){
				alert( '您的浏览器不支持上传功能！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
			}
			var uploader = WebUploader.create({
				auto: true,
				swf: './static/js/webuploader/Uploader.swf',
				server: "./index.php?c=attachment&a=rz_upload&newid="+newid+"",
				pick: {
					id: '.js-add-image.'+curid+'',
					innerHTML: '<a class="fileinput-button-icon" href="javascript:;">+'+(curid=="cert"?"上传扫描件":"其他证明材料")+'</a>'
				},
				accept: {
					title: 'Images',
					extensions: 'gif,jpg,jpeg,png',
					mimeTypes: 'image/*'
				},
				fileSingleSizeLimit: 5 * 1024 * 1024,
				duplicate:true
			});
			uploader.on('fileQueued',function(file){
				curthis.find('.js-add-image').hide();
				var pic_loading_dom = $('<li class="upload-preview-img sort loading '+curid+'-uploadpic-'+file.id+'">');
				curthis.find('.js-add-image').before(pic_loading_dom);
			});
			uploader.on('uploadProgress',function(file,percentage){

			});
			uploader.on('uploadBeforeSend',function(block,data){
				data.maxsize = 5;
			});
			uploader.on('uploadSuccess',function(file,response){
				if(response['result'].error_code == '0'){
					curthis.find('.'+curid+'-uploadpic-'+response['id']).removeClass('loading').html('<img src="'+response['result'].url+'"/><a href="javascript:;" class="close-modal small js-remove-image">×</a>');
					$('#cert_btn').val(response['result'].url);
				}else{
					curthis.find('.'+curid+'-uploadpic-'+response['id']).remove();
					layer_tips(1,response['result'].err_msg);
					curthis.find('.js-add-image').show();
					$('#cert_btn').val('');
				}
			});
			uploader.on('uploadError', function(file,reason){
				curthis.find('.'+curid+'-uploadpic-'+response['id']).remove();
				layer_tips(1,'上传失败！请重试。');
				curthis.find('.js-add-image').show();
				$('#cert_btn').val('');
			});
		});
});
$('.js-remove-image').live('click', function(event) {
	$(this).parents('.upload-preview-img').remove();
	if ($(this).parents('.js-upload-image-list').find('li.upload-preview-img')==0) {
		$('.js-add-image').hide();
	} else{
		$('.js-add-image').show();
	};
});
$("#contact_tel").on('blur', function(event) {
	event.stopPropagation();
	checkMobile ();
});
$("#accountEmail").on('blur', function(event) {
	event.stopPropagation();
	checkMali ()
});
$("#fPassword").on('blur', function(event) {
	event.stopPropagation();
	checkPwd ()
});
$("#rePassword").on('blur', function(event) {
	event.stopPropagation();
	checkREPwd ()
});
$("#contact_tel,#accountEmail,#fPassword,#rePassword").on('focus', function() {
	$(this).next('.error_msg').html('')
});
$('#dyMobileButton').click(function(event) {
	event.stopPropagation();
	var time=120;
	var code=$("#dyMobileButton");
	if(validCode1) {
			//检测是否已经注册
			var mobile = $("#contact_tel").val();
			if(!mobile) {
				tusi("请填写手机号,再获取验证码");
				return true;
			}
			if(document.form_register.phone.value.match(/^(1)[0-9]{10}$/ig)==null) {
				document.form_register.phone.focus();
				tusi("手机号码输入错误，请重新输入");
				return false;
			}
			$.post('user.php?c=user&a=check_username',{'is_ajax':'1','mobile':mobile},function(data){
				if(data.status>0) {
					tusi(data.msg);
					returns = '0';
				} else {
					returns = '1';
					validCode1 = false;
					if (validCode) {
						try{
							clearInterval(t1);
						}catch(e){

						}
						validCode=false;
						code.addClass("msgs1");
						var t=setInterval(function  () {
							time--;
							code.html(time+"秒后重新获取");
							if (time==0) {
								clearInterval(t);
								code.html("获取短信验证码");
								validCode=true;
								validCode1=true;
								code.removeClass("msgs1");

							}
						},1000)
					}
				}
			},
			'json'
			)

		}
	});
$('#register').on('submit',function(event) {
	event.preventDefault();
	if (checkAll()) {
		$.post('user.php?c=user&a=com_register', $('#register').serialize(), function(data) {
			var datas = $.parseJSON(data);
			if(datas.status){
				tusi("您的资料已提交，等待系统审核");
				setTimeout(function () {
					window.location.href = "http://"+document.domain
				}, 3000)
			}else{
				tusi(datas.msg);
			}
		});
	}else{
		return false;
	}
});


});
function checkAll () {
	var all = 1;
	if(checkImg (all) && checkOperat (all) && checkPwd (all) && checkREPwd (all) && checkMali (all) && checkMobile (all) && checkAddress (all) && checkStorename (all)){
		return true;
	}else{
		return false;
	}
}
function showBox (data) {
	
}
function checkMobile (all) {
	var bol=false;
	var mobile_reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
	var mobile = $("#contact_tel").val();
	var error_msg = $("#contact_tel").next('.error_msg');
	if(!mobile) {
		error_msg.html('手机号码不能为空');
		all==1?tusi('手机号码不能为空'):" " ;
		return false;
	}
	if(!mobile_reg.test(mobile)) {
		error_msg.html('手机号码格式错误')
		all==1?tusi('手机号码格式错误'):" " ;
		bol=false;
	}
	$.ajax({
		url: 'index.php?c=index&a=check_username',
		type: 'POST',
		async:false, 
		data: {'is_ajax':'1','mobile':mobile},
	})
	.done(function(data) {
		if(data.status>0) {
			error_msg.html(data.msg)
			all==1?tusi(data.msg):" " ;
			bol=false;
		}else{
			error_msg.html('手机号可以使用，提交信息后需要接收验证码');
			bol=true;
		}
	});
	return bol;
}
function checkMali (all) {
	var mail_reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	var mail = $("#accountEmail").val();
	var error_msg = $("#accountEmail").next('.error_msg');
	if(!mail) {
		error_msg.html('邮箱不能为空')
		all==1?tusi('邮箱不能为空'):" " ;
		return false;
	}
	if(!mail_reg.test(mail)) {
		error_msg.html('邮箱格式错误')
		all==1?tusi('邮箱格式错误'):" " ;
		return false;
	}
	error_msg.html('');
	return true;
}
function checkPwd (all) {
	var pwd_reg = /^[\w]{6,12}$/;
	var pwd = $("#fPassword").val();
	var error_msg = $("#fPassword").next('.error_msg');
	if(!pwd) {
		error_msg.html('密码不能为空')
		all==1?tusi('密码不能为空'):" " ;
		return false;
	}
	if(!pwd_reg.test(pwd)) {
		error_msg.html('密码只能是6-12位的字母、数字和下划线')
		all==1?tusi('密码只能是6-12位的字母、数字和下划线'):" " ;
		return false;
	}
	error_msg.html('');
	return true;
}

function checkREPwd (all) {
	var pwd_reg = /^[\w]{6,12}$/;
	var pwd = $("#fPassword").val();
	var REPwd = $("#rePassword").val();
	var error_msg = $("#rePassword").next('.error_msg');
	if(pwd!=REPwd) {
		error_msg.html('两次输入的密码不一致')
		all==1?tusi('两次输入的密码不一致'):" " ;
		return false;
	}
	error_msg.html('');
	return true;
}
function checkStorename (all) {
	$('#store_name').next('.error-message').remove();
	if ($.trim($('#store_name').val()) != '') {
		var bol=false;
		$.ajax({
			url: store_name_check,
			type: 'POST',
			async:false, 
			data: {'name': $.trim($('#store_name').val())},
		})
		.done(function(data) {
			if (data=='1') {
				$('#store_name').next('.error-message').remove();
				$('#store_name').after('<span class="error-message">茶馆名称已存在</span>');
				all==1?tusi('茶馆名称已存在'):" " ;
				bol = false;
			} else {
				$('#store_name').next('.error-message').remove();
				bol = true;
			}
		});
	} else {
		$('#store_name').next('.error-message').remove();
		$('#store_name').after('<span class="error-message">茶馆名称没有填写</span>');
		all==1?tusi('茶馆名称没有填写'):" " ;
		bol = false;
	}
	return bol;
}
function checkAddress (all) {
	if (!$('.thouseAddress_sort #s1').val()) {
		all==1?tusi('请选择省份'):" " ;
		return false;
	};
	if (!$('.thouseAddress_sort #s2').val()) {
		all==1?tusi('请选择城市'):" " ;
		return false;
	};
	if (!$('.thouseAddress_sort #s3').val()) {
		all==1?tusi('请选择地区'):" " ;
		return false;
	};
	if (!$.trim($('#thouseAddress').val())) {
		all==1?tusi('请填写详细地址'):" " ;
		return false;
	};
	if (!$('#map_long').val() && !$('#map_lat').val()) {
		all==1?tusi('请在地图中标注具体位置'):" " ;
		return false;
	};
	return true;
}
function checkImg (all) {
	if (!$('#cert .upload-preview-img img').attr('src')) {
		all==1?tusi('请上传营业执照扫描件'):" " ;
		return false;
	};
	if (!$('#license').val()) {
		all==1?tusi('请填写营业执照号'):" " ;
		return false;
	};
	if ($('#license').val().length<10) {
		all==1?tusi('请输入正确的营业执照号'):" " ;
		return false;
	};
	if (!$('#license').val()) {
		all==1?tusi('请填写营业执照号'):" " ;
		return false;
	};
	if (!$('#date1').val() && !$('#date2').val()) {
		all==1?tusi('请填写营业执照有效期'):" " ;
		return false;
	};
	return true;
}

function checkOperat (all) {
	var mobile_reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
	var operat_tel = $("#operat_tel").val();
	var operat_name = $("#operat_name").val();
	var error_msg = $("#contact_tel").next('.error_msg');
	if(!operat_name) {
		error_msg.html('运营人姓名不能为空');
		all==1?tusi('运营人姓名不能为空'):" " ;
		return false;
	}
	if(!operat_tel) {
		error_msg.html('运营人手机号码不能为空');
		all==1?tusi('运营人手机号码不能为空'):" " ;
		return false;
	}
	if(!mobile_reg.test(operat_tel)) {
		error_msg.html('运营人手机号码格式错误')
		all==1?tusi('运营人手机号码格式错误'):" " ;
		return false;
	}
	return true;
}