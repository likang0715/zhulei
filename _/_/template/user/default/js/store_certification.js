/**
 * Created by pigcms_21 on 2015/2/5.
 */
var t = '';
$(function(){
	load_page('.app__content', load_url, {page:'store_certification', 'store_id': store_id}, '');

	$('.ui-store-board-logo').live('hover', function(event){
		if(event.type == 'mouseenter') {
			$(this).find('.hide').show();
		} else {
			$(this).find('.hide').hide();
		}
	})
	

	$('.btn-save').live('click',function(){
	/*	var company_name=$('input[name="company_name"]').val();
		var desc=$('textarea[name="desc"]').val();
		var signform_face_img=$('.signform_face_img').data('url');
		var real_name=$('input[name="real_name"]').val();
		var identity_number=$('input[name="identity_number"]').val();
		var identification_face=$('.identification_face').data('url');
		var mobile=$('input[name="mobile"]').val();

		 if (company_name == '') {
			 layer_tips(1,'企业名称不能为空！');
			 return false;
        }
		if(desc==''){
			layer_tips(1,'企业简介不能为空！');
			return false;
		}
		
		if(signform_face_img==''){
			layer_tips(1,'企业营业执照扫描件不能为空');
			return false;
		}
		
		if(real_name==''){
			layer_tips(1,'运营者姓名不能为空');
			return false;
		}
		
		
		if(identity_number==''){
			layer_tips(1,'运营者身份证号不能为空');
			return false;
		}
		
		if(identification_face==''){
			layer_tips(1,'运营者身份证照片不能为空！');
			return false;
		}
		
		if(mobile==''){
			layer_tips(1,'手机号不能为空！');
			return false;
		}*/
		
		$.post(certification_url,{'company_name':company_name,'desc':desc,'signform_face_img':signform_face_img,'real_name':real_name,'identity_number':identity_number,'identification_face':identification_face,'mobile':mobile},function(data){
			if(data['err_code']==1){
				layer_tips(1,data.err_msg);
			}else{
				layer_tips(0,data.err_msg);
				location.reload();
			}
		});
	})

			KindEditor.ready(function(K){
				var site_url = "http://www.weidian.com";
				var editor = K.editor({
					allowFileManager : true
				});
				$('.config_upload_image_btn').click(function(){
					var upload_file_btn = $(this);
					editor.uploadJson = "/user.php?c=Store&a=ajax_upload_pic";
					editor.loadPlugin('image', function(){
						editor.plugin.imageDialog({
							showRemote : false,
							clickFn : function(url, title, width, height, border, align) {
								upload_file_btn.siblings('.input-image').val(site_url+url);
								editor.hideDialog();
							}
						});
					});
				});
				$('.config_upload_file_btn').click(function(){
					var upload_file_btn = $(this);
					editor.uploadJson =  "/user.php?c=Store&a=ajax_upload_file&name="+upload_file_btn.siblings('.input-file').attr('name');
					editor.loadPlugin('insertfile', function(){
						editor.plugin.fileDialog({
							showRemote : false,
							clickFn : function(url, title, width, height, border, align) {
								upload_file_btn.siblings('.input-file').val(url);
								editor.hideDialog();
							}
						});
					});
				});
			});

			//测试短信发送
			var issign = true; 
			function test_send_sms() {
				var myDialog = window.top.art.dialog({id: 'N3690',width: '30em',  height: 75,title: "测试短信发送操作",color:"#ff0000"});
				var sms_topmain = $("#config_sms_topdomain").val();
				var sms_key = $("#config_sms_key").val();
				var sms_price = $("#config_sms_price").val();
				var sms_sign = $("#config_sms_sign").val();
				var sms_mobile = $("#config_sms_test_mobile").val();
				

				if(!sms_topmain || !sms_key || !sms_price || !sms_sign || !sms_mobile) {
					myDialog.content("短信配置不全，无法发送短信，请正确填写配置再重试！");
					myDialog.time("5");
					return;
				}
				
				if (!/^1[0-9]{10}$/.test(sms_mobile)) {
					myDialog.content("手机号填写不正确！");
					myDialog.time("5");
					return;
				}
				if(sms_sign.length>=6) {
					myDialog.content("短信签名建议不要超过5个字！");
					myDialog.time("5");
					return;
				}

				//关闭:myDialog.close();

				

				if(issign) {
					issign = false;
					jQuery.ajax({
						url:"/admin.php?c=Config&a=sendmsg",
						dataType:"json",
						type:"POST",
						data:{'mobile':sms_mobile,'topmain':sms_topmain,'skey':sms_key,'sprice':sms_price,'ssign':sms_sign},
						success: function (data) {
							issign = true;
							if(data.error=="0") {
								//myDialog.content("测试短信发送成功，请留意手机！");// 填充对话框内容
								myDialog.content(data.message);// 填充对话框内容
								myDialog.time("7");
							} else {
								myDialog.content(data.message);// 填充对话框内容
								myDialog.time("7");
							}	
						}
					}); 
				}
				
			}

    $(".change_certification").live('click',function(){
        load_page('.app__content', load_url, {page:'certification_change', 'store_id': store_id}, '');
    });
})
