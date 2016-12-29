var oldHash = 'old';
$(function(){
	// if(navigator.userAgent.indexOf("Chrome") == -1){
	// 	location.href = 'user.php?c=chrome';
	// }
	function isHashChanged () {
		if (location.hash!=oldHash) {
			return true;
		}else{
			oldHash=location.hash
			return false;
		}
	}
	if( ("onhashchange" in window) && ((typeof document.documentMode==="undefined") || document.documentMode==8)) {
		window.onhashchange = function () {
			try{
				location_page(location.hash)
			}catch(err){
				// console.log(err)
			}
		}; 
	} else {
		setInterval(function() {
			var ischanged = isHashChanged(); 
			if(ischanged && oldHash!=location.hash) {
				location_page(location.hash); 
			}  
		}, 150);  
	}
	
	$('#js-open-live').click(function() {
		openFullScreen ();
		loadRound ()
	});
	$('.js-live-close').click(function() {
		closeFullScreen ();
	});
	document.addEventListener("fullscreenchange", function () {
		if (document.fullscreenElement) {
			openFullScreenAfter ();
		} else{
			closeFullScreenAfter ();
		};
	}, false);
	document.addEventListener("msfullscreenchange", function () {
		if (document.msFullscreenElement) {
			openFullScreenAfter ();
		} else{
			closeFullScreenAfter ();
		};
	}, false);

	document.addEventListener("mozfullscreenchange", function () {
		if (document.mozFullScreen) {
			openFullScreenAfter ();
		} else{
			closeFullScreenAfter ();
		};
	}, false);

	document.addEventListener("webkitfullscreenchange", function () {
		if (document.webkitIsFullScreen) {
			openFullScreenAfter ();
		} else{
			closeFullScreenAfter ();
		};
	}, false);
	$('.usertips').hover(function(){$(this).addClass('current').find('.downmenu1').show();},function(){$(this).removeClass('current').find('.downmenu1').hide();});

	/*播放音乐*/
	var play_voice_timer = null;
	$('.voice-player').live('click',function(){
		if($("#audio_wrapper").size() != 0){
			var old_dom = $('.js-audio-playnow');
			old_dom.find('.play').hide(),
			old_dom.find('.stop').text('点击播放').show(),
			old_dom.find('.second').empty().hide(),
			old_dom.removeClass("js-audio-playnow"),
			play_voice_timer && clearInterval(play_voice_timer),
			$('#audio_wrapper').remove();
		}
		var now_dom = $(this);
		now_dom.addClass('js-audio-playnow').find('.stop').html('loading...');
		var dom = $('<div id="audio_wrapper"><audio id="audio_player" preload="" type="audio/mpeg" src=""></audio></div>').hide();
		0 === $("#audio_wrapper").size() && $("body").append(dom);
		$("#audio_player").attr("src",now_dom.parent().attr('data-voice-src'));
		var player_dom = document.getElementById("audio_player");
		var o = function(){
			now_dom.find('.play').hide(),
			now_dom.find('.stop').text('点击播放').show(),
			now_dom.find('.second').empty().hide(),
			now_dom.removeClass("js-audio-playnow"),
			play_voice_timer && clearInterval(play_voice_timer),
			$('#audio_wrapper').remove();
		};
		var s = !!navigator.userAgent.match(/AppleWebKit.*Mobile./);
		s && player_dom.play();

		player_dom.addEventListener("canplay", function(){
			player_dom.play();
			play_voice_timer && clearInterval(play_voice_timer),
			now_dom.find('.stop').empty().hide().siblings('.play').show();
			now_dom.find('.second').empty().show().html("0/" + Math.floor(player_dom.duration));
			play_voice_timer = setInterval(function(){
				now_dom.find('.second').html(Math.round(player_dom.currentTime) + "/" + Math.floor(player_dom.duration))
			},1000);
			return false;
		});
		player_dom.addEventListener("ended", function() {
			o();
		});
		player_dom.addEventListener("error", function() {
			now_dom.find('.stop').text("加载失败！")
		}),
		$(".js-audio-playnow").one('click',function(e){
			player_dom.pause(),
			o(),
			e.stopPropagation();
		});
	});
});

/**
 *
 * @param msg_type
 * @param msg_content
 */
 function layer_tips(msg_type,msg_content){
 	layer.closeAll();
 	var time = msg_type==0 ? 3 : 4;
 	var type = msg_type==0 ? 1 : (msg_type != -1 ? 0 : -1);
 	if(type == 0){
 		msg_content = '<font color="red">'+msg_content+'</font>';
 	}
 	$.layer({
 		title: false,
 		offset: ['80px',''],
 		closeBtn:false,
 		shade:[0],
 		time:time,
 		dialog:{
 			type:type,
 			msg:msg_content
 		}
 	});
 }

/**
 *
 * @param msg
 * @param status
 */
 function golbal_tips(msg, status){
	//status 1:error, 0:success
	var type = status == 1 ? 'error' : 'success';
	if($("#infotips").length > 0) $("#infotips").remove();
	var html = '<div class="js-notifications notifications" id="infotips"><div class="alert in fade alert-'+type+'"><a href="javascript:;" class="close pull-right" onclick="$(\'#infotips\').remove();">×</a>' + msg + '</div></div>';
	$('body').append(html);
	$('#infotips').delay(1000).fadeOut(2000);
}

/**
 *
 * @param dom
 * @param url
 * @param param
 * @param cache
 * @param obj
 */
 var load_page_cache = [];
 function load_page(dom,url,param,cache,obj){
 	if(cache!='' && load_page_cache[cache]){
 		$(dom).html(load_page_cache[cache]);
 		if(obj) obj();
 	}else{
 		$(dom).html('<div class="loading-more"><span></span></div>');
 		$(dom).load(url+'&t='+Math.random(),param,function(response,status,xhr){
 			if(cache!='') load_page_cache[cache]=response;
 			if(obj) obj();
 		});
 	}

 }

/*
 * 上传logo图片弹出层
 *
 * param maxsize    最大上传尺寸            int 单位M
 * param showLocal  是否展示已上传图片列表  bool
 * param obj 	    回调函数                object
 * param maxnum     最多使用的图片数量      int
 */
 var upload_local_result = [];
 function upload_logo_box(maxsize,showLocal,obj,maxnum){
 	var upload_pic = [],oknum = 0,nowImagePage=1;
 	if(!showLocal) showLocal = false;
 	if(!maxnum) maxnum = 0;
 	var html = '<div class="modal-backdrop fade in"></div>';
 	var widgetDom = $('<div class="widget-image_shear modal fade hide in" style="margin-top: 0px; display: block;" aria-hidden="false"><div class="widget-image-shear"><div class="modal-dialog"><div class="modal-header"><span class="title">上传Logo</span><a href="javascript:void(0);" class="close" data-dismiss="modal" aria-label="Close"  aria-hidden="true">×</a></div><div class="modal-body"><div class="widget-image-shear__header">  <div class="notify"> <p>图片不允许涉及政治敏感与色情</p> <p>图片大小不可大于1M</p> </div> <input type="file" accept="image/*" class="ui-btn js-file" style="display:none"><a href="javascript:void(0);" class="ui-btn ui-btn-normal js-img-btn-trigger">选择图片</a><img class="js-sheared-img" style="display:none;"></div> <div class="widget-image-shear__content"> <div class="shear-wrapper"> <img class="js-origin-img"> <div class="js-shear shear ui-draggable ui-resizable"><div class="ui-resizable-handle ui-resizable-ne" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-nw" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-sw" style="z-index: 90;"></div></div> <div class="js-shear-shadow shear-shadow"></div> </div></div> <div class="widget-image-shear__preview"> <h4 class="title">头像预览</h4><div class="js-preview preview"> <img> </div> <div class="js-preview preview preview--circle"> <img></div></div> </div><div class="widget-image-shear__footer modal-footer"><a class="ui-btn ui-btn-primary js-gen-img" href="javascript:void(0);">生成</a></div></div></div></div>');
 	widgetDom.find('.close,.js-upload-image-btn').click(function(){
 		if(!$(this).hasClass('close')){
 			if(obj) obj(upload_pic);
 		}
 		$('.widget-image_shear,.modal-backdrop').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow", function(){
 			$('.widget-image,.modal-backdrop').remove();
 		});
 	});
 	$('.js-upload-image-list .js-remove-image').live('click',function(){
 		$.post('./user.php?c=attachment&a=attachment_del',{pigcms_id:$(this).attr('file-id')});
 		$(this).closest('li').remove();

 	});
 	var getLocalFun = function(page){
 		if(page == -1){
 			upload_local_result = [];
 			nowImagePage = 1;
 			page = 1;
 		}
 		$.post('./user.php?c=attachment&a=getImgList',{p:page},function(result){
 			if(!upload_local_result[page]){
 				upload_local_result[page] = {};
 			}
 			upload_local_result[page] = result.err_msg;
 			showLocalFun();
 		});
 	}
 	var showLocalFun = function(){
 		if(upload_local_result[nowImagePage].count){
 			widgetDom.find('.js-list-empty-region').empty();
 			var html = '';
 			for(var i in upload_local_result[nowImagePage].image_list){
 				var nowImage = upload_local_result[nowImagePage].image_list[i];
 				html += '<li class="widget-image-item" data-id="'+nowImage.pigcms_id+'" data-image="'+nowImage.file+'"><div class="js-choose" title="'+nowImage.name+'"><p class="image-size">'+nowImage.size+'<br>'+getSize(nowImage.size)+'</p><div class="widget-image-item-content" style="background-image:url('+nowImage.file+')"></div><div class="widget-image-meta">'+nowImage.width+'x'+nowImage.height+'</div><div class="selected-style"><i class="icon-ok icon-white"></i></div></div></li>';
 			}
 			widgetDom.find('.js-list-body-region').html(html);
 			widgetDom.find('.pagenavi').html(upload_local_result[nowImagePage].page_bar);

 			widgetDom.find('.pagenavi a').click(function(){
 				nowImagePage = $(this).data('page-num');
 				if(upload_local_result[nowImagePage]){
 					showLocalFun();
 				}else{
 					getLocalFun(nowImagePage);
 				}
 			});

 			if(maxnum == 1){
 				widgetDom.find('.widget-image-item').click(function(){
 					upload_pic[$(this).data('id')] = $(this).data('image');
 					if(obj) obj(upload_pic);
 					$('.widget-image,.modal-backdrop').remove();
 				});
 			}else{
 				widgetDom.find('.widget-image-item').click(function(){
 					if($(this).hasClass('selected')){
 						$(this).removeClass('selected');
 						delete upload_pic[$(this).data('id')];
 						if(widgetDom.find('.widget-image-item.selected').size() == 0){
 							widgetDom.find('.js-choose-image').addClass('hide');
 						}
 					}else{
 						if(maxnum > 0 && widgetDom.find('.widget-image-item.selected').size() >= maxnum){
 							layer_tips(1,'最多只能选取 '+maxnum+' 张');
 						}else{
 							widgetDom.find('.js-choose-image').removeClass('hide');
 							$(this).addClass('selected');
 							upload_pic[$(this).data('id')] = $(this).data('image');
 						}
 					}
 				});
 				widgetDom.find('.js-choose-image').click(function(){
 					if(obj) obj(upload_pic);
 					$('.widget-image,.modal-backdrop').remove();
 				});
 			}
 		}else{
 			widgetDom.find('.js-list-body-region').empty();
 			widgetDom.find('.pagenavi').empty();
 			widgetDom.find('.js-list-empty-region').html('<div><div class="no-result widget-list-empty">还没有相关数据。</div></div>');
 		}
 	}
 	if(showLocal){
 		if(upload_local_result.length == 0){
 			getLocalFun(nowImagePage);
 		}else{
 			showLocalFun();
 		}
 		widgetDom.find('.js-modal-tab a').click(function(){
 			if(!$(this).closest('li').hasClass('active')){
 				$(this).closest('li').addClass('active').siblings('li').removeClass('active');
 				$('.js-tab-pane-'+$(this).data('pane')).removeClass('hide').siblings('.js-tab-pane').addClass('hide');
 			}
 		});
 		widgetDom.find('.js-image-region .js-refresh').click(function(){
 			getLocalFun(-1);
 		});
 	}
 	var imageBtnDom = widgetDom.find('.js-upload-network-img');
 	var imageDom = widgetDom.find('.js-web-img-input');
 	var imageUrlError = function(tips){
 		layer_tips(1,tips);
 		imageDom.focus();
 		imageBtnDom.val('提取').prop('disabled',false);
 	}
 	imageBtnDom.click(function(){
 		$(this).val('提取中...').prop('disabled',true);
 		var imageUrl = $.trim(imageDom.val());
 		if(imageUrl.length == 0){
 			imageUrlError('请填写网址');
 			return false;
 		}
 		var lastDotIndex = imageUrl.lastIndexOf('.');
 		if(imageUrl.substr(0,7)!= 'http://' && imageUrl.substr(0,8)!= 'https://' && lastDotIndex == -1){
 			imageUrlError('请填写正确的网址，应以(http://或https://)开头');
 			return false;
 		}
 		var extName = imageUrl.substr(lastDotIndex+1);
 		if(extName!='gif' && extName!='jpg' && extName!='png' && extName!='jpeg'){
 			imageUrlError('为了网站安全考虑，<br/>网址应以(gif、jpg、png或jpeg)结尾');
 			return false;
 		}
 		var image = new Image();
 		image.src = imageUrl;
 		image.onerror = function(){
 			imageUrlError('该网址不存在，或不是一张合法的图片文件！');
 			return false;
 		}
 		image.onload = function(){
 			widgetDom.find('.preview-container').html('<img src="'+imageUrl+'"/>');
 			$.post('./user.php?c=attachment&a=img_download',{url:imageUrl},function(result){
 				if(result.err_code){
 					imageUrlError(result.err_msg);
 				}else{
 					imageBtnDom.val('提取').prop('disabled',false);
 					upload_pic[result.err_msg.pigcms_id] = result.err_msg.url;
 					if(obj) obj(upload_pic);
 					$('.widget-image,.modal-backdrop').remove();
 				}
 			});
 		}
 	});

$('body').append(html);
$('body').append(widgetDom);
widgetDom.animate({
	'top': ($(window).scrollTop() + $(window).height() * 0.2) + 'px'
},100);
$.getScript('./static/js/webuploader/webuploader.js',function(){
	if(!WebUploader.Uploader.support()){
		alert( '您的浏览器不支持上传功能！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
		$('.widget-image,.modal-backdrop').remove();
	}
	var uploader = WebUploader.create({
		auto: true,
		swf: './static/js/webuploader/Uploader.swf',
		server: "./user.php?c=attachment&a=img_upload",
		pick: {
			id: '.js-add-image',
			innerHTML: '<a class="fileinput-button-icon" href="javascript:;">+</a>'
		},
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,png',
			mimeTypes: 'image/*'
		},
		fileSingleSizeLimit: maxsize * 1024 * 1024,
		duplicate:true
	});
	uploader.on('fileQueued',function(file){
		var pic_loading_dom = $('<li class="upload-preview-img sort loading uploadpic-'+file.id+'">');
		$('.js-add-image').before(pic_loading_dom);
	});
	uploader.on('uploadProgress',function(file,percentage){

	});
	uploader.on('uploadBeforeSend',function(block,data){
		data.maxsize = maxsize;
	});
	uploader.on('uploadSuccess',function(file,response){
		if(response['result'].error_code == '0'){
			upload_pic[response['result'].pigcms_id] = response['result'].url;
			$('.uploadpic-'+response['id']).removeClass('loading').html('<img src="'+response['result'].url+'"/><a href="javascript:;" class="close-modal small js-remove-image" file-id="'+response['result'].pigcms_id+'">×</a>');
			if(maxnum == 1 && oknum == 0 && obj){
				obj(upload_pic);
				$('.widget-image,.modal-backdrop').remove();
			}
			oknum++;
		}else{
			$('.uploadpic-'+response['id']).remove();
			layer_tips(1,response['result'].err_msg);
		}
	});

	uploader.on('uploadError', function(file,reason){
		$('.uploadpic-'+response['id']).remove();
		layer_tips(1,'上传失败！请重试。');
	});

});

}

/////////////
/*
 * 上传logo图片弹出层
 *
 * param maxsize    最大上传尺寸            int 单位M
 * param showLocal  是否展示已上传图片列表  bool
 * param obj 	    回调函数                object
 * param maxnum     最多使用的图片数量      int
 * param imgsize    图片最佳尺寸            [width,height]
 */
 var upload_local_result = [];
 function upload_pic_box2(maxsize,showLocal,obj,maxnum,imgsize){
 	var upload_pic = [],oknum = 0,nowImagePage=1;
 	if(!showLocal) showLocal = false;
 	var size_text = imgsize?'最佳尺寸'+imgsize[0]+'px*'+imgsize[1]+'px，':'';
 	if(!maxnum) maxnum = 0;
 	var html = '<div class="modal-backdrop fade in"></div>';
 	var widgetDom = $('<div class="widget-image modal fade in" style="top:-350px;"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><ul class="module-nav modal-tab js-modal-tab"><li class="js-modal-tab-item js-modal-tab-image'+(showLocal ? '' : ' hide')+'"><a href="javascript:;" data-pane="image">用过的图片</a><span>|</span></li><li class="js-modal-tab-item js-modal-tab-upload active"><a href="javascript:;" data-pane="upload">新图片</a></li></ul></div>'+(showLocal?'<div class="tab-pane js-tab-pane js-tab-pane-image js-image-region hide"><div class="widget-list"><div class="modal-body"><div class="js-list-filter-region clearfix ui-box" style="position:relative;min-height:28px;"><div class="widget-list-filter"><div class="widget-image-refresh"><span>点击图片即可选中</span> <a href="javascript:;" class="js-refresh">刷新</a></div><div class="js-list-search ui-search-box"><input class="txt" type="text" placeholder="搜索" value=""/></div></div></div><div class="ui-box"><ul class="js-list-body-region widget-image-list"></ul><div class="js-list-empty-region"><div><div class="no-result widget-list-empty">还没有相关数据。</div></div></div></div></div><div class="modal-footer js-list-footer-region"><div class="widget-list-footer"><div class="left"><a href="javascript:;" class="ui-btn ui-btn-primary js-choose-image hide">确定使用</a></div><div class="pagenavi"></div></div></div></div></div>' : '')+'<div class="tab-pane js-tab-pane js-tab-pane-upload js-upload-region"><div>' + '<div class="js-upload-network-region"><div><div class="modal-body"><div class="get-web-img js-get-web-img"><form class="form-horizontal" onsubmit="return false;"><div class="control-group"><label class="control-label">网络图片：</label><div class="controls"><input type="text" name="attachment_url" class="get-web-img-input js-web-img-input" placeholder="请贴入网络图片地址" value=""><input type="button" class="btn js-upload-network-img" value="提取"/></div><div class="controls preview-container"></div></div></form></div></div></div></div>' + '<div class="js-upload-local-region"><div><div class="modal-body"><div class="upload-local-img"><form class="form-horizontal"><div class="control-group"><label class="control-label">本地图片：</label><div class="controls"><div class="control-action"><ul class="js-upload-image-list upload-image-list clearfix ui-sortable"><li class="fileinput-button js-add-image"><a class="fileinput-button-icon" href="javascript:;">+</a><input class="js-fileupload-input fileupload" type="file" multiple=""/></li></ul><p class="help-desc">'+size_text+'最大支持 1 MB 的图片( jpg / gif / png )</p></div></div></div></form></div></div><div class="modal-footer"><div class="modal-action right"><input type="button" class="btn btn-primary js-upload-image-btn" value="上传完成"/></div></div></div></div></div></div></div>');
 	widgetDom.find('.close,.js-upload-image-btn').click(function(){
 		if(!$(this).hasClass('close')){
 			if(obj) obj(upload_pic);
 		}
 		$('.widget-image,.modal-backdrop').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow", function(){
 			$('.widget-image,.modal-backdrop').remove();
 		});
 	});
 	$('.js-upload-image-list .js-remove-image').live('click',function(){
 		$.post('./user.php?c=attachment&a=attachment_del',{pigcms_id:$(this).attr('file-id')});
 		$(this).closest('li').remove();
 	});
 	var getLocalFun = function(page){
 		if(page == -1){
 			upload_local_result = [];
 			nowImagePage = 1;
 			page = 1;
 		}
 		$.post('./user.php?c=attachment&a=getImgList',{p:page},function(result){
 			if(!upload_local_result[page]){
 				upload_local_result[page] = {};
 			}
 			upload_local_result[page] = result.err_msg;
 			showLocalFun();
 		});
 	}
 	var showLocalFun = function(){
 		if(upload_local_result[nowImagePage].count){
 			widgetDom.find('.js-list-empty-region').empty();
 			var html = '';
 			for(var i in upload_local_result[nowImagePage].image_list){
 				var nowImage = upload_local_result[nowImagePage].image_list[i];
 				html += '<li class="widget-image-item" data-id="'+nowImage.pigcms_id+'" data-image="'+nowImage.file+'"><div class="js-choose" title="'+nowImage.name+'"><p class="image-size">'+nowImage.size+'<br>'+getSize(nowImage.size)+'</p><div class="widget-image-item-content" style="background-image:url('+nowImage.file+')"></div><div class="widget-image-meta">'+nowImage.width+'x'+nowImage.height+'</div><div class="selected-style"><i class="icon-ok icon-white"></i></div></div></li>';
 			}
 			widgetDom.find('.js-list-body-region').html(html);
 			widgetDom.find('.pagenavi').html(upload_local_result[nowImagePage].page_bar);

 			widgetDom.find('.pagenavi a').click(function(){
 				nowImagePage = $(this).data('page-num');
 				if(upload_local_result[nowImagePage]){
 					showLocalFun();
 				}else{
 					getLocalFun(nowImagePage);
 				}
 			});

 			if(maxnum == 1){
 				widgetDom.find('.widget-image-item').click(function(){
 					upload_pic[$(this).data('id')] = $(this).data('image');
 					if(obj) obj(upload_pic);
 					$('.widget-image,.modal-backdrop').remove();
 				});
 			}else{
 				widgetDom.find('.widget-image-item').click(function(){
 					if($(this).hasClass('selected')){
 						$(this).removeClass('selected');
 						delete upload_pic[$(this).data('id')];
 						if(widgetDom.find('.widget-image-item.selected').size() == 0){
 							widgetDom.find('.js-choose-image').addClass('hide');
 						}
 					}else{
 						if(maxnum > 0 && widgetDom.find('.widget-image-item.selected').size() >= maxnum){
 							layer_tips(1,'最多只能选取 '+maxnum+' 张');
 						}else{
 							widgetDom.find('.js-choose-image').removeClass('hide');
 							$(this).addClass('selected');
 							upload_pic[$(this).data('id')] = $(this).data('image');
 						}
 					}
 				});
 				widgetDom.find('.js-choose-image').click(function(){
 					if(obj) obj(upload_pic);
 					$('.widget-image,.modal-backdrop').remove();
 				});
 			}
 		}else{
 			widgetDom.find('.js-list-body-region').empty();
 			widgetDom.find('.pagenavi').empty();
 			widgetDom.find('.js-list-empty-region').html('<div><div class="no-result widget-list-empty">还没有相关数据。</div></div>');
 		}
 	}
 	if(showLocal){
 		if(upload_local_result.length == 0){
 			getLocalFun(nowImagePage);
 		}else{
 			showLocalFun();
 		}
 		widgetDom.find('.js-modal-tab a').click(function(){
 			if(!$(this).closest('li').hasClass('active')){
 				$(this).closest('li').addClass('active').siblings('li').removeClass('active');
 				$('.js-tab-pane-'+$(this).data('pane')).removeClass('hide').siblings('.js-tab-pane').addClass('hide');
 			}
 		});
 		widgetDom.find('.js-image-region .js-refresh').click(function(){
 			getLocalFun(-1);
 		});
 	}
 	var imageBtnDom = widgetDom.find('.js-upload-network-img');
 	var imageDom = widgetDom.find('.js-web-img-input');
 	var imageUrlError = function(tips){
 		layer_tips(1,tips);
 		imageDom.focus();
 		imageBtnDom.val('提取').prop('disabled',false);
 	}
 	imageBtnDom.click(function(){
 		$(this).val('提取中...').prop('disabled',true);
 		var imageUrl = $.trim(imageDom.val());
 		if(imageUrl.length == 0){
 			imageUrlError('请填写网址');
 			return false;
 		}
 		var lastDotIndex = imageUrl.lastIndexOf('.');
 		if(imageUrl.substr(0,7)!= 'http://' && imageUrl.substr(0,8)!= 'https://' && lastDotIndex == -1){
 			imageUrlError('请填写正确的网址，应以(http://或https://)开头');
 			return false;
 		}
 		var extName = imageUrl.substr(lastDotIndex+1);
 		if(extName!='gif' && extName!='jpg' && extName!='png' && extName!='jpeg'){
 			imageUrlError('为了网站安全考虑，<br/>网址应以(gif、jpg、png或jpeg)结尾');
 			return false;
 		}
 		var image = new Image();
 		image.src = imageUrl;
 		image.onerror = function(){
 			imageUrlError('该网址不存在，或不是一张合法的图片文件！');
 			return false;
 		}
 		image.onload = function(){
 			widgetDom.find('.preview-container').html('<img src="'+imageUrl+'"/>');
 			$.post('./user.php?c=attachment&a=img_download',{url:imageUrl},function(result){
 				if(result.err_code){
 					imageUrlError(result.err_msg);
 				}else{
 					imageBtnDom.val('提取').prop('disabled',false);
 					upload_pic[result.err_msg.pigcms_id] = result.err_msg.url;
 					if(obj) obj(upload_pic);
 					$('.widget-image,.modal-backdrop').remove();
 				}
 			});
 		}
 	});

$('body').append(html);
$('body').append(widgetDom);
widgetDom.animate({
	'top': ($(window).scrollTop() + $(window).height() * 0.2) + 'px'
},100);
$.getScript('./static/js/webuploader/webuploader.js',function(){
	if(!WebUploader.Uploader.support()){
		alert( '您的浏览器不支持上传功能！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
		$('.widget-image,.modal-backdrop').remove();
	}
	var uploader = WebUploader.create({
		auto: true,
		swf: './static/js/webuploader/Uploader.swf',
		server: "./user.php?c=attachment&a=img_upload",
		pick: {
			id: '.js-add-image',
			innerHTML: '<a class="fileinput-button-icon" href="javascript:;">+</a>'
		},
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,png',
			mimeTypes: 'image/*'
		},
		fileSingleSizeLimit: maxsize * 1024 * 1024,
		duplicate:true
	});
	uploader.on('fileQueued',function(file){
		var pic_loading_dom = $('<li class="upload-preview-img sort loading uploadpic-'+file.id+'">');
		$('.js-add-image').before(pic_loading_dom);
	});
	uploader.on('uploadProgress',function(file,percentage){

	});
	uploader.on('uploadBeforeSend',function(block,data){
		data.maxsize = maxsize;
	});
	uploader.on('uploadSuccess',function(file,response){
		if(response['result'].error_code == '0'){
			upload_pic[response['result'].pigcms_id] = response['result'].url;
			$('.uploadpic-'+response['id']).removeClass('loading').html('<img src="'+response['result'].url+'"/><a href="javascript:;" class="close-modal small js-remove-image" file-id="'+response['result'].pigcms_id+'">×</a>');
			if(maxnum == 1 && oknum == 0 && obj){
				obj(upload_pic);
				$('.widget-image,.modal-backdrop').remove();
			}
			oknum++;
		}else{
			$('.uploadpic-'+response['id']).remove();
			layer_tips(1,response['result'].err_msg);
		}
	});

	uploader.on('uploadError', function(file,reason){
		$('.uploadpic-'+response['id']).remove();
		layer_tips(1,'上传失败！请重试。');
	});

});

}

/*
 * 上传图片弹出层
 *
 * param maxsize    最大上传尺寸            int 单位M
 * param showLocal  是否展示已上传图片列表  bool
 * param obj 	    回调函数                object
 * param maxnum     最多使用的图片数量      int
 */
 var upload_local_result = [];
 function upload_pic_box(maxsize,showLocal,obj,maxnum,imgsize){
 	var upload_pic = [],oknum = 0,nowImagePage=1;
 	if(!showLocal) showLocal = false;
 	if(!maxnum) maxnum = 0;
 	var size_text = imgsize?imgsize[0]+'px*'+imgsize[1]+'px，':'960px*960px';
 	var html = '<div class="modal-backdrop fade in"></div>';
 	var widgetDom = $('<div class="widget-image modal fade in" style="top:-350px;"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><ul class="module-nav modal-tab js-modal-tab"><li class="js-modal-tab-item js-modal-tab-image'+(showLocal ? '' : ' hide')+'"><a href="javascript:;" data-pane="image">用过的图片</a><span>|</span></li><li class="js-modal-tab-item js-modal-tab-upload active"><a href="javascript:;" data-pane="upload">新图片</a></li></ul></div>'+(showLocal ? '<div class="tab-pane js-tab-pane js-tab-pane-image js-image-region hide"><div class="widget-list"><div class="modal-body"><div class="js-list-filter-region clearfix ui-box" style="position:relative;min-height:28px;"><div class="widget-list-filter"><div class="widget-image-refresh"><span>点击图片即可选中</span> <a href="javascript:;" class="js-refresh">刷新</a></div><div class="js-list-search ui-search-box"><input class="txt" type="text" placeholder="搜索" value=""/></div></div></div><div class="ui-box"><ul class="js-list-body-region widget-image-list"></ul><div class="js-list-empty-region"><div><div class="no-result widget-list-empty">还没有相关数据。</div></div></div></div></div><div class="modal-footer js-list-footer-region"><div class="widget-list-footer"><div class="left"><a href="javascript:;" class="ui-btn ui-btn-primary js-choose-image hide">确定使用</a></div><div class="pagenavi"></div></div></div></div></div>' : '')+'<div class="tab-pane js-tab-pane js-tab-pane-upload js-upload-region"><div>' + '<div class="js-upload-network-region"><div><div class="modal-body"><div class="get-web-img js-get-web-img"><form class="form-horizontal" onsubmit="return false;"><div class="control-group"><label class="control-label">网络图片：</label><div class="controls"><input type="text" name="attachment_url" class="get-web-img-input js-web-img-input" placeholder="请贴入网络图片地址" value=""><input type="button" class="btn js-upload-network-img" value="提取"/></div><div class="controls preview-container"></div></div></form></div></div></div></div>' + '<div class="js-upload-local-region"><div><div class="modal-body"><div class="upload-local-img"><form class="form-horizontal"><div class="control-group"><label class="control-label">本地图片：</label><div class="controls"><div class="control-action"><ul class="js-upload-image-list upload-image-list clearfix ui-sortable"><li class="fileinput-button js-add-image" data-type="loading"><a class="fileinput-button-icon" href="javascript:;">+</a></li></ul><p class="help-desc">推荐'+size_text+'宽高等比的图片会有更好的展示效果</p><p class="help-desc">最大支持 1 MB 的图片( jpg / gif / png )，不能选中大于 1 MB 的图片</p></div></div></div></form></div></div><div class="modal-footer"><div class="modal-action right"><input type="button" class="btn btn-primary js-upload-image-btn" value="上传完成"/></div></div></div></div></div></div></div>');
 	$(".js-add-image").live("click", function () {
 		if ($(this).data("type") == "loading") {
 			layer_tips(1, "网速慢，加载中，请稍等");
 			return;
 		}
 	});
 	widgetDom.find('.close,.js-upload-image-btn').click(function(){
 		if(!$(this).hasClass('close')){
 			if (obj) {
 				var pic_arr = [];
 				$(".js-upload-image-list").find("img").each(function () {
 					pic_arr.push($(this).attr("src"));
 				});
 				obj(pic_arr);
 			}
 		}
 		$('.widget-image,.modal-backdrop').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow", function(){
 			$('.widget-image,.modal-backdrop').remove();
 		});
 	});
 	$('.js-upload-image-list .js-remove-image').live('click',function(){
 		$.post('./user.php?c=attachment&a=attachment_del',{pigcms_id:$(this).attr('file-id')});
 		$(this).closest('li').remove();

 	});

	//回车提交搜索
	$(window).keydown(function(event){
		if (event.keyCode == 13 && widgetDom.find(".js-list-search input").is(':focus')) {
			var keyword = widgetDom.find(".js-list-search input").val();
			var old_keyword = widgetDom.find(".js-list-search input").data("old_keyword");
			
			if (typeof old_keyword == "undefined") {
				widgetDom.find(".js-list-search input").data("old_keyword", "");
				old_keyword = "";
			}
			
			if (old_keyword == keyword) {
				return;
			}
			widgetDom.find(".js-list-search input").data("old_keyword", keyword);
			getLocalFun(-1);
		}
	});
	
	var getLocalFun = function(page){
		if(page == -1){
			upload_local_result = [];
			nowImagePage = 1;
			page = 1;
		}
		var keyword = widgetDom.find(".js-list-search input").val();
		$.post('./user.php?c=attachment&a=getImgList',{p:page, keyword:keyword},function(result){
			if(!upload_local_result[page]){
				upload_local_result[page] = {};
			}
			upload_local_result[page] = result.err_msg;
			
			showLocalFun();
		});
	};
	
	var showLocalFun = function(){
		if(upload_local_result[nowImagePage].count){
			widgetDom.find('.js-list-empty-region').empty();
			var html = '';
			for(var i in upload_local_result[nowImagePage].image_list){
				var nowImage = upload_local_result[nowImagePage].image_list[i];
				var selected = "";
				if (typeof upload_pic[nowImage.pigcms_id] != "undefined") {
					selected = "selected";
				}
				
				html += '<li class="widget-image-item ' + selected + '" data-id="'+nowImage.pigcms_id+'" data-image="'+nowImage.file+'"><div class="js-choose" title="'+nowImage.name+'"><p class="image-size">'+nowImage.size+'<br>'+getSize(nowImage.size)+'</p><div class="widget-image-item-content" style="background-image:url('+nowImage.file+')"></div><div class="widget-image-meta">'+nowImage.width+'x'+nowImage.height+'</div><div class="selected-style"><i class="icon-ok icon-white"></i></div></div></li>';
			}
			widgetDom.find('.js-list-body-region').html(html);
			widgetDom.find('.pagenavi').html(upload_local_result[nowImagePage].page_bar);

			widgetDom.find('.pagenavi a').click(function(){
				nowImagePage = $(this).data('page-num');
				if(upload_local_result[nowImagePage]){
					showLocalFun();
				}else{
					getLocalFun(nowImagePage);
				}
			});

			if(maxnum == 1){
				widgetDom.find('.widget-image-item').click(function(){
					upload_pic[$(this).data('id')] = $(this).data('image');
					if(obj) obj(upload_pic);
					$('.widget-image,.modal-backdrop').remove();
				});
			}else{
				widgetDom.find('.widget-image-item').click(function(){
					if($(this).hasClass('selected')){
						$(this).removeClass('selected');
						delete upload_pic[$(this).data('id')];
						if(widgetDom.find('.widget-image-item.selected').size() == 0){
							widgetDom.find('.js-choose-image').addClass('hide');
						}
					}else{
						if(maxnum > 0 && widgetDom.find('.widget-image-item.selected').size() >= maxnum){
							layer_tips(1,'最多只能选取 '+maxnum+' 张');
						}else{
							widgetDom.find('.js-choose-image').removeClass('hide');
							$(this).addClass('selected');
							upload_pic[$(this).data('id')] = $(this).data('image');
						}
					}
				});
			}
		}else{
			widgetDom.find('.js-list-body-region').empty();
			widgetDom.find('.pagenavi').empty();
			widgetDom.find('.js-list-empty-region').html('<div><div class="no-result widget-list-empty">还没有相关数据。</div></div>');
		}
	};
	
	widgetDom.find('.js-choose-image').click(function(){
		if (obj) {
			var pic_arr = upload_pic.reverse();
			obj(pic_arr);
		}
		$('.widget-image,.modal-backdrop').remove();
	});
	
	if(showLocal){
		if(upload_local_result.length == 0){
			getLocalFun(nowImagePage);
		}else{
			showLocalFun();
		}
		widgetDom.find('.js-modal-tab a').click(function(){
			if(!$(this).closest('li').hasClass('active')){
				$(this).closest('li').addClass('active').siblings('li').removeClass('active');
				$('.js-tab-pane-'+$(this).data('pane')).removeClass('hide').siblings('.js-tab-pane').addClass('hide');
			}
		});
		widgetDom.find('.js-image-region .js-refresh').click(function(){
			getLocalFun(-1);
		});
	}
	var imageBtnDom = widgetDom.find('.js-upload-network-img');
	var imageDom = widgetDom.find('.js-web-img-input');
	var imageUrlError = function(tips){
		layer_tips(1,tips);
		imageDom.focus();
		imageBtnDom.val('提取').prop('disabled',false);
	}
	imageBtnDom.click(function(){
		$(this).val('提取中...').prop('disabled',true);
		var imageUrl = $.trim(imageDom.val());
		if(imageUrl.length == 0){
			imageUrlError('请填写网址');
			return false;
		}
		var lastDotIndex = imageUrl.lastIndexOf('.');
		if(imageUrl.substr(0,7)!= 'http://' && imageUrl.substr(0,8)!= 'https://' && lastDotIndex == -1){
			imageUrlError('请填写正确的网址，应以(http://或https://)开头');
			return false;
		}
		var extName = imageUrl.substr(lastDotIndex+1);
		if(extName!='gif' && extName!='jpg' && extName!='png' && extName!='jpeg'){
			imageUrlError('为了网站安全考虑，<br/>网址应以(gif、jpg、png或jpeg)结尾');
			return false;
		}
		var image = new Image();
		image.src = imageUrl;
		image.onerror = function(){
			imageUrlError('该网址不存在，或不是一张合法的图片文件！');
			return false;
		}
		image.onload = function(){
			widgetDom.find('.preview-container').html('<img src="'+imageUrl+'"/>');
			$.post('./user.php?c=attachment&a=img_download',{url:imageUrl},function(result){
				if(result.err_code){
					imageUrlError(result.err_msg);
				}else{
					imageBtnDom.val('提取').prop('disabled',false);
					upload_pic[result.err_msg.pigcms_id] = result.err_msg.url;
					if(obj) obj(upload_pic);
					$('.widget-image,.modal-backdrop').remove();
				}
			});
		}
	});
$('body').append(html);
$('body').append(widgetDom);
widgetDom.animate({
	'top': ($(window).scrollTop() + $(window).height() * 0.2) + 'px'
},100);
$.getScript('./static/js/webuploader/webuploader.js',function(){
	$(".js-add-image").data("type", "load");
	if(!WebUploader.Uploader.support()){
		alert( '您的浏览器不支持上传功能！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
		$('.widget-image,.modal-backdrop').remove();
	}
	var uploader = WebUploader.create({
		auto: true,
		swf: './static/js/webuploader/Uploader.swf',
		server: "./user.php?c=attachment&a=img_upload",
		pick: {
			id: '.js-add-image',
			innerHTML: '<a class="fileinput-button-icon" href="javascript:;">+</a>'
		},
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,png',
			mimeTypes: 'image/*'
		},
		fileSingleSizeLimit: maxsize * 1024 * 1024,
		duplicate:true
	});
	uploader.on('fileQueued',function(file){
		var pic_loading_dom = $('<li class="upload-preview-img sort loading uploadpic-'+file.id+'">');
		$('.js-add-image').before(pic_loading_dom);
	});
	uploader.on('uploadProgress',function(file,percentage){

	});
	uploader.on('uploadBeforeSend',function(block,data){
		data.maxsize = maxsize;
	});
	uploader.on('uploadSuccess',function(file,response){
		if(response['result'].error_code == '0'){
			upload_pic[response['result'].pigcms_id] = response['result'].url;
			$('.uploadpic-'+response['id']).removeClass('loading').html('<img src="'+response['result'].url+'"/><a href="javascript:;" class="close-modal small js-remove-image" file-id="'+response['result'].pigcms_id+'">×</a>');
			if(maxnum == 1 && oknum == 0 && obj){
				obj(upload_pic);
				$('.widget-image,.modal-backdrop').remove();
			}
			oknum++;
		}else{
			$('.uploadpic-'+response['id']).remove();
			layer_tips(1,response['result'].err_msg);
		}
	});

	uploader.on('uploadError', function(file,reason){
		$('.uploadpic-'+response['id']).remove();
		layer_tips(1,'上传失败！请重试。');
	});

});

}

/*
 * 上传语音弹出层
 *
 * param maxsize    最大上传尺寸            int 单位M
 * param showLocal  是否展示已上传语音列表  bool
 * param obj 	    回调函数                object
 */
 function upload_voice_box(maxsize,showLocal,obj){
 	var last_file = null;
 	if(!showLocal) showLocal = false;
 	var html = '<div class="modal-backdrop fade in"></div>';
 	html    += '<div class="widget-image modal fade in"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><ul class="module-nav modal-tab js-modal-tab"><li class="js-modal-tab-item js-modal-tab-image'+(showLocal ? '' : ' hide')+'"><a href="javascript:;" data-pane="image">用过的语音</a><span>|</span></li><li class="js-modal-tab-item js-modal-tab-upload active"><a href="javascript:;" data-pane="upload">新语音</a></li></ul></div><div class="tab-pane js-tab-pane js-tab-pane-upload js-upload-region"><div><div class="js-upload-local-region"><div><div class="modal-body"><div class="upload-local-img"><form class="form-horizontal"><div class="control-group"><label class="control-label">本地语音：</label><div class="controls"><div class="control-action"><div class="voice-file-input"><a href="javascript:;" class="js-fileupload-btn"></a></div><div class="voice-preview hide"><p class="name"></p><p class="size"></p></div><p class="help-desc">最大支持 <span class="js-max-size">'+maxsize+' MB</span> 以内的语音 (amr, mp3 格式)</p></div></div></div></form></div></div><div class="modal-footer"><div class="modal-action right"><input type="button" class="btn btn-primary js-upload-audio-btn disabled" value="确定上传"></div></div></div></div></div></div></div>';
 	$('body').append(html);
 	$.getScript('./static/js/webuploader/webuploader.js',function(){
 		if ( !WebUploader.Uploader.support() ) {
 			alert( '您的浏览器不支持上传功能！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
 			$('.widget-image,.modal-backdrop').remove();
 		}
 		var uploader = WebUploader.create({
 			auto: false,
 			swf: './static/js/webuploader/Uploader.swf',
 			server: "./user.php?c=attachment&a=audio_upload",
 			pick: {
 				id: '.js-fileupload-btn',
 				innerHTML: '添加语音...',
 				multiple:false
 			},
 			accept:{
 				title: 'Voice',
 				extensions: 'amr,mp3',
 				mimeTypes: 'audio/mp3,audio/amr'
 			},
 			fileSingleSizeLimit:maxsize * 1024 * 1024,
 			duplicate:true
 		});
 		uploader.on('fileQueued',function(file){
 			if(last_file){
 				uploader.removeFile(last_file);
 			}
 			last_file = file;
 			$('.voice-preview').show().find('.name').html(file.name).siblings('.size').html(getSize(file.size));
 			$('.webuploader-pick').html('重新选择..');
 			$('.js-upload-audio-btn').removeClass('disabled');
 		});
 		uploader.on('uploadProgress',function(file,percentage){

 		});
 		uploader.on('uploadBeforeSend',function(block,data){
 			data.maxsize = maxsize;
 		});
 		uploader.on('uploadSuccess',function(file,response){
 			if(response['result'].error_code == '0'){
 				if(obj) obj(response['result'].url);
 				$('.widget-image,.modal-backdrop').remove();
 			}else{
 				layer_tips(1,response['result'].err_msg);
 				$('.js-upload-audio-btn').val('确定上传').prop('disabled',false);
 			}
 		});

 		uploader.on('uploadError', function(file,reason){
 			layer_tips(1,'上传失败！请重试。');
 		});
 		uploader.onError = function(code){
 			switch(code){
 				case 'Q_TYPE_DENIED':
 				layer_tips(1,'文件类型不允许！');
 				break;
 				case 'F_EXCEED_SIZE':
 				layer_tips(1,'文件超过了尺寸！最大 '+maxsize+' M');
 				break;
 			}
 		};

 		$('.widget-image .close').click(function(){
 			$('.widget-image,.modal-backdrop').remove();
 		});
 		$('.js-upload-audio-btn').click(function(){
 			if($(this).hasClass('disabled')){
 				layer_tips(1,'还没有选择文件');
 				return false;
 			}

 			uploader.upload();
 			$('.js-upload-audio-btn').val('上传中..').prop('disabled',true).unbind('click');
				// if(obj) obj(upload_pic);
				// $('.widget-image,.modal-backdrop').remove();
			});
 	});
}

/*
 * 小的弹出层
 *
 * param dom	  弹出层的ID 				使用 $(this);
 * param e	      弹出层的ID点击返回事件 	使用 event;
 * param position 方向  					left,top,right,bottom
 * param type     弹出层的类别  			copy,edit_txt,delete,confirm,multi_txt,radio,input,url,module
 * param content  内容
 * param ok_obj   点击确认键的回调方法
 * param placeholder 点位符
 */
 function button_box(dom,event,position,type,content,ok_obj,placeholder){
 	var cancel_obj = arguments[7];
 	event.stopPropagation();
 	var left=0,top=0,width=0,height=0;
 	var dom_offset = dom.offset();
 	$('.popover').remove();
 	if(type=='copy'){
 		$.getScript('./static/js/plugin/jquery.zclip.min.js',function(){
 			$('body').append('<div class="popover '+position+'" style="left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+($(window).height()/2)+'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><div class="form-inline"><div class="input-append"><input type="text" class="txt js-url-placeholder url-placeholder" readonly="" value="'+content+'"/><button type="button" class="btn js-btn-copy">复制</button></div></div></div></div></div>');
 			$('.popover .js-btn-copy').zclip({
 				path:'./static/js/plugin/ZeroClipboard.swf',
 				copy:function(){
 					return content;
 				},
 				afterCopy:function(){
 					$('.popover').remove();
 					layer_tips(0,'复制成功');
 				}
 			});
 			button_box_after();
 		});
 	}else if(type=='edit_txt'){
 		$('body').append('<div class="popover '+position+'" style="left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+'px;"><div class="arrow"></div><div class="popover-inner popover-rename"><div class="popover-content"><div class="form-horizontal"><div class="control-group"><div class="controls"><input type="text" class="js-rename-placeholder" maxlength="256"/> <button type="button" class="btn btn-primary js-btn-confirm">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div></div></div></div>');
 		$('.js-rename-placeholder').attr('placeholder', content).focus();
 		button_box_after();
 	} else if (type=='input') {
 		$('body').append('<div class="popover '+position+'" style="left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+'px;"><div class="arrow"></div><div class="popover-inner popover-rename"><div class="popover-content"><div class="form-horizontal"><div class="control-group"><div class="controls"><input type="text" class="js-rename-placeholder" maxlength="256"/> <button type="button" class="btn btn-primary js-btn-confirm">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div></div></div></div>');
 		if (placeholder) {
 			$('.js-rename-placeholder').attr('placeholder', placeholder);
 		}
 		$('.js-rename-placeholder').val(content).focus();
 		button_box_after();
 	} else if(type=='multi_txt') {
 		$('body').append('<div class="popover ' + position + '" style="left:-' + ($(window).width() * 5) + 'px;top:' + $(window).scrollTop() + 'px;"><div class="arrow"></div><div class="popover-inner popover-chosen"><div class="popover-content"><div class="select2-container select2-container-multi js-select2 select2-dropdown-open" style="width:242px;display:inline-block;"><ul class="select2-choices"><li class="select2-search-field">    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" style="width:192px;"></li></ul></div> <button type="button" class="btn btn-primary js-btn-confirm" data-loading-text="确定">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div>');
 		$('.popover-chosen .select2-input').attr('placeholder', content).focus();
 		multi_choose_obj();
 		button_box_after();
 	}else if(type=='multi_txt2') {
 		var cccat_id = content.cats_id;
 		$('body').append('<div class="popover ' + position + '" style="left:-' + ($(window).width() * 5) + 'px;top:' + $(window).scrollTop() + 'px;"><div class="arrow"></div><div class="popover-inner popover-chosen"><div class="popover-content"><div class="select2-container select2-container-multi js-select2 select2-dropdown-open" style="width:242px;display:inline-block;"><ul class="select2-choices"><li class="select2-search-field">    <input type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" id="s2id_autogen26" tabindex="-1" style="width:192px;"></li></ul></div> <button type="button" data-button-cat-id="'+cccat_id+'"  class="btn btn-primary js-btn-confirm" data-loading-text="确定">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div>');
 		$('.popover-chosen .select2-input').attr('placeholder', content.contents).focus();
       // multi_choose_obj();
       multi_choose_obj2(content.arr,content.has_atom_id);
       button_box_after();
   } else if (type == 'radio') {
   	$('body').append('<div class="popover ' + position + '" style="top: ' + $(window).scrollTop() + 'px; left: -' + ($(window).width()*5) + 'px;"><div class="arrow"></div><div class="popover-inner popover-change"><div class="popover-content text-center"><form class="form-inline"><label class="radio"><input type="radio" name="discount" value="1" checked="">参与</label><label class="radio"><input type="radio" name="discount" value="0">不参与</label><button type="button" class="btn btn-primary js-btn-confirm" data-loading-text="确定">确定</button><button type="reset" class="btn js-btn-cancel">取消</button></form></div></div></div>');
   	button_box_after();
   } else if (type == 'url') {
   	var yinxiao_btn = '';
   	if(is_show_activity == 1) {
   		yinxiao_btn = '<button type="button" class="btn js-btn-link">营销活动</button>';
   		yinxiao_btn += ' <button type="button" class="btn js-btn-link-new">新营销活动</button>';
   	} else if(is_show_activity == 2) {
   		yinxiao_btn = '<button type="button" class="btn js-btn-link">营销活动</button>';
   	} else if(is_show_activity == 3) {
   		yinxiao_btn += ' <button type="button" class="btn js-btn-link-new">新营销活动</button>';
   	}

   	var button_h = $('<div class="popover '+position+'" style="left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+'px;"><div class="arrow"></div><div class="popover-inner popover-rename"><div class="popover-content"><div class="form-horizontal"><div class="control-group"><div class="controls"><input type="text" id="dc" class="link-placeholder js-link-placeholder" placeholder="' + content + '" /> ' + yinxiao_btn + '  <button type="button" class="btn js-btn-diancha">点茶</button> <button type="button" class="btn js-btn-chahui">茶会</button> <button type="button" class="btn btn-primary js-btn-confirm">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div></div></div></div>');
   	button_h.find('.js-btn-diancha').click(function(){
   		$("#dc").val(wap_diancha_url);
   	});
   	button_h.find('.js-btn-chahui').click(function(){
   		$("#dc").val(wap_chahui_url);
   	});
   	button_h.find('.js-btn-link').click(function(){
   		$.layer({
   			type : 2,
   			title: '插入功能库链接',
   			shadeClose: true,
   			maxmin: true,
   			fix : false,  
   			area: ['600px','450px'],
   			iframe: {
   				src : '?c=link&a=index'
   			}
   		});
   	});

		//新活动弹窗
		button_h.find('.js-btn-link-new').click(function(){
			$.layer({
				type : 2,
				title: '插入其他新活动链接',
				shadeClose: true,
				maxmin: true,
				fix : false,  
				area: ['600px','450px'],
				iframe: {
					src : '?c=link&a=new_activity'
				}
			});
		});
		
		
		$('body').append(button_h);
		$('.js-rename-placeholder').val(content).focus();
		button_box_after();
	} else if (type == 'module') {
		$('body').append('<div class="popover '+ position + '" style="left:'+(dom_offset.left - 178)+'px;top:' + (dom_offset.top - 500) + 'px;"><div class="arrow"></div><div class="popover-inner popover-text"><div class="popover-content"><form class="form-horizontal"><div class="control-group"><label class="control-label">请设置模块名称：</label><div class="controls"><input type="text" class="text-placeholder js-text-placeholder"></div></div><div class="form-actions"><button type="button" class="btn btn-primary js-btn-confirm" data-loading-text="确定"> 确定</button><button type="reset" class="btn js-btn-cancel">取消</button></div></form></div></div></div>');
		$('.js-text-placeholder').focus();
		$('.js-text-placeholder').val(content);
		button_box_after();
		$('.popover').css({top:(dom_offset.top - dom.height() - 115), left: dom_offset.left - ($('.popover').width() / 2) + 20});
	} else if(type == 'tips') {
		$('body').append('<div class="popover '+position+'" style="display:block;left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+'px;"><div class="arrow"></div><div class="popover-inner popover-'+type+'"><div class="popover-content text-center"><div class="form-inline"><span class="help-inline item-delete">'+content+'</span><button type="button" class="btn btn-primary js-btn-confirm">确定</button> </div></div></div></div>');
		button_box_after();
	}
	else{
		$('body').append('<div class="popover '+position+'" style="display:block;left:-'+($(window).width()*5)+'px;top:'+$(window).scrollTop()+'px;"><div class="arrow"></div><div class="popover-inner popover-'+type+'"><div class="popover-content text-center"><div class="form-inline"><span class="help-inline item-delete">'+content+'</span><button type="button" class="btn btn-primary js-btn-confirm">确定</button> <button type="reset" class="btn js-btn-cancel">取消</button></div></div></div></div>');
		button_box_after();
	}

	function button_box_after(){
		$('.popover .js-btn-cancel').one('click',function(){
			if (cancel_obj != undefined) {
				cancel_obj();
			} else {
				close_button_box();
			}
		});
		$('.popover .js-btn-confirm').one('click',function(){
			if(ok_obj){
				ok_obj();
			} else {
				close_button_box();
			}
		});
		$('.popover').click(function(e){
			e.stopPropagation();
		});
		if (cancel_obj == undefined) {
			$('body').bind('click',function(){
				close_button_box();
			});
		}

		var popover_height = $('.popover').height();
		var popover_width = $('.popover').width();
		switch(position){
			case 'left':
			$('.popover').css({top:dom_offset.top-(popover_height+10-dom.height())/2,left:dom_offset.left-popover_width-14});
			break;
			case 'right':
			$('.popover').css({top:dom_offset.top-(popover_height+10-dom.height())/2,left:dom_offset.left+dom.width() + 27});
			$('.popover-confirm').css('margin-left', '0');
			break;
			case 'top':
			$('.popover').css({top:(dom_offset.top - dom.height() - 40),left:dom_offset.left - (popover_width/2) + (dom.width()/2)});
			break;
			case 'bottom':
			$('.popover').css({top:dom_offset.top+dom.height()-3,left:dom_offset.left - (popover_width/2) + (dom.width()/2)});
			break;
		}
	}
	//添加商品添加规格专用方法
	function multi_choose_obj(){
		$('.popover-chosen .select2-input').keyup(function(event){
			var input_select2 = $.trim($(this).val());
			if(event.keyCode == 13 && input_select2.length != 0){
				var html = $('<li class="select2-search-choice"><div>'+input_select2+'</div><a href="#" class="select2-search-choice-close" tabindex="-1" onclick="$(this).closest(\'li\').remove();$(\'.popover-chosen .select2-input\').focus();"></a></li>');
				if($('.popover-chosen .select2-choices .select2-search-choice').size() > 0){
					var has_li = false;
					$.each($('.popover-chosen .select2-choices .select2-search-choice'),function(i,item){
						if($(item).find('div').html() == input_select2){
							has_li = true;
							return false;
						}
					});
					if(has_li === false){
						$('.popover-chosen .select2-choices .select2-search-choice:last').after(html);
					}else{
						layer_tips(1,'已经存在相同的规格');
						$(this).val('').focus();
						return;
					}
				}else{
					$('.popover-chosen .select2-choices').prepend(html);
				}
				
				var r = getRandNumber();
				html.attr('data-vid', r);
				html.attr('check-data-vid', r);
				
				$.post(get_property_value_url,{pid:dom.closest('.sku-sub-group').find('.js-sku-name').attr('data-id'),txt:input_select2},function(result){
					if(result.err_code == 0){
						html.attr('data-vid',result.err_msg);
						
						if ($("#r_" + r).size() > 0) {
							$("#r_" + r).attr("atom-id", result.err_msg);
						}
					}else{
						layer_tips(result.err_msg);
						html.remove();
					}
				});
				$(this).removeAttr('placeholder').val('').focus();
			}
		});
}
    //查询商品属性规格专用方法  array(1,2,3)
    function multi_choose_obj2(strss,arr_has_atom_id){

    	var html;
    	$('.popover-chosen .select2-choices .select2-search-choice').detach('');
    	for(var i in strss) {
           // html +=  '<li class="select2-search-choice"  onclick="$(this).addClass(\'choice\');"  data-vid='+strss[i].pid+'"><div>'+strss[i].value+'</div><a href="#" class="select2-search-choice-select" tabindex="-1"  onclick="$(\'.popover-chosen .select2-input\').focus();"></a></li>';
           if(jQuery.inArray(strss[i].vid,arr_has_atom_id)=='-1') {
           	html +=  '<li class="select2-search-choice cursor"  onclick="javascript:if($(this).attr(\'idd\')==\'choice\'){ $(this).removeClass(\'choice\').attr(\'idd\',\'\'); } else{$(this).addClass(\'choice\').attr(\'idd\',\'choice\');}"  data-vid='+strss[i].vid+'"><div>'+strss[i].value+'</div><a href="javascript:" class="select2-search-choice-select" tabindex="-1"  onclick="$(\'.popover-chosen .select2-input\').focus();"></a></li>';
           }
       }
       var htmls = $(html);

       $('.popover-chosen .select2-choices').prepend(htmls);
        //包所有属性值 放入 容器中
        $('.popover-chosen .select2-input').keyup(function(event){


        })
    }
}

/**
 *
 * @param dom
 * @param txt
 * @param after_obj
 */
 function copy_txt(dom,txt,after_obj){
 	$.getScript('./static/js/plugin/jquery.zclip.min.js',function(){
 		dom.zclip({
 			path:'./static/js/plugin/ZeroClipboard.swf',
 			copy:function(){
 				return txt;
 			},
 			afterCopy:function(){
 				if(after_obj) after_obj();
 			}
 		});
 	});
 }

/**
 *
 */
 function close_button_box(){
 	$('.popover').remove();
 }

/**
 *
 */
// function checkValue (value,type) {
// 	var v = String(value);
// 	var t = String(type);
// 	if (t=='n') {
// 		value.replace(/[^\d]/g,'')
// 	} else if (t=='m') {
	
// 	}
// 	value.replace(/[^0-9]/g, '');
// }

/**
 * 链接弹出层
 */
 var link_save_box = {};
 function link_box(dom,typeArr,after_obj){
 	var domHtml;
 	dom.hover(function(){
 		if(dom.find('.dropdown-menu').size() == 0){
 			if(typeArr.length == 0){
 				domHtml = $('<ul class="dropdown-menu" style="display:block;"><li><a data-type="page" href="javascript:;">微页面及分类</a></li><li><a data-type="good" href="javascript:;">商品及分组</a></li><li><a data-type="checkin" href="javascript:;">我要签到</a></li><li><a data-type="home" href="javascript:;">店铺主页</a></li><li><a data-type="ucenter" href="javascript:;">会员主页</a> </li><li> <a data-type="chahui" href="javascript:;">茶会主页</a></li><li> <a data-type="diancha" href="javascript:;">点茶预约</a></li><li><a data-type="subject_type" href="javascript:;">专题分类展示</a> </li><li style="display:none"><a data-type="tuan" href="javascript:;">团购主页</a> </li><li style="display:none"><a data-type="yydb" href="javascript:;">一元夺宝主页</a> </li><li> <a data-type="link" href="javascript:;">自定义外链</a></li></ul>');
 			}else{
 				var domContent = '<ul class="dropdown-menu" style="display:block;">';
 				for(var i in typeArr){
 					domContent += '<li><a data-type="'+typeArr[i]+'" href="javascript:;">';
 					switch(typeArr[i]){
 						case 'page':
 						case 'pagecat':
 						domContent += '微页面及分类';
 						break;
 						case 'page_only':
 						domContent += '微页面';
 						break;
 						case 'pagecat_only':
 						domContent += '微页面分类';
 						break;
 						case 'good':
 						case 'goodcat':
 						domContent += '商品及分组';
 						break;
 						case 'good_only':
 						domContent += '商品';
 						break;
 						case 'good_only_pic':
 						domContent += '商品及图片';
 						break;
 						case 'goodcat_only':
 						domContent += '商品分组';
 						break;
 						case 'home':
 						domContent += '店铺主页';
 						break;
 						case 'subject_type':
 						domContent += '专题分类展示';
 						break;
 						case 'tuan':
							//domContent += '团购主页';
							break;
							case 'yydb':
							//domContent += '一元夺宝主页 ';
							break;
							case 'ucenter':
							domContent += '会员主页';
							break;
							case 'diancha':
							domContent += '点茶预约';
							break;
							case 'chahui':
							domContent += '茶会主页';
							break;
							case 'link':
							domContent += '自定义外链';
							break;
							case 'checkin':
							domContent += '我要签到';
							break;
						}
						domContent += '</a></li>';
					}
					domContent += '</ul>';
					domHtml = $(domContent);
				}
				dom.append(domHtml);
			}else{
				domHtml = dom.find('.dropdown-menu');
				domHtml.show();
			}
			var modalDom = {};
			domHtml.find('a').bind('click',function(){
				var type = $(this).data('type');
				if(type == 'home'){
					after_obj('home','店铺主页','店铺主页',wap_home_url);
					domHtml.trigger('mouseleave');
				}else if(type == 'subject_type'){
					after_obj('subject_type','专题分类展示页','专题分类展示页',wap_subject_type_url);
					domHtml.trigger('mouseleave');
				} else if (type == 'ucenter') {
					after_obj('home','会员主页','会员主页',wap_ucenter_url);
					domHtml.trigger('mouseleave');
				}else if(type == 'diancha'){
					after_obj('link','预约管理','点茶',wap_diancha_url);
					domHtml.trigger('mouseleave');
				}else if(type == 'chahui'){
					after_obj('link','茶会管理','茶会主页',wap_chahui_url);
					domHtml.trigger('mouseleave');
				} else if(type == 'tuan'){
					after_obj('tuan','团购主页','团购主页',wap_tuan_url);
					domHtml.trigger('mouseleave');
				} else if(type == 'yydb'){
					after_obj('yydb','一元夺宝主页','一元夺宝主页',wap_yydb_url);
					domHtml.trigger('mouseleave');
				}else if(type == 'checkin'){
					after_obj('home','我要签到','我要签到',checkin_url);
					domHtml.trigger('mouseleave');
				}else if(type == 'link'){
					button_box(dom,event,'bottom','url','链接地址：http://example.com',function(){
						var url = $('.js-link-placeholder').val();
						if(url != '') {
							if (!check_url(url)){
								url = 'http://' + url;
							}
							after_obj('link','外链',url,url);
							close_button_box();
						} else {
							return false;
						}
					});
					domHtml.trigger('mouseleave');
				}else{
					$('.modal-backdrop,.modal').remove();
					$('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');
					var randNum = getRandNumber();
					if(type.substr(-4,4) == 'only'){
						var load_url = 'user.php?c=widget&a='+type.replace('_only','')+'&only=1&number='+randNum;
					}else{
						var load_url = 'user.php?c=widget&a='+type+'&number='+randNum;
					}
					link_save_box[randNum] = after_obj;
					modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="'+load_url+'" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
					$('body').append(modalDom);
					modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
					$('.modal-backdrop').click(function(){
						login_box_close();
					});
				}
			});
},function(e){
	domHtml.hide().find('a').unbind('click');
});
}

/**
 *
 * @param number
 * @param type
 * @param title
 * @param url
 */
 function login_box_after(number,type,title,url){
 	var prefix = '';
 	switch(type){
 		case 'page':
 		prefix = '微页面';
 		break;
 		case 'pagecat':
 		prefix = '微页面分类';
 		break;
 		case 'goodcat':
 		prefix = '商品分组';
 		break;
 		case 'good':
 		prefix = '商品';
 		break;
 	}
 	link_save_box[number](type,prefix,title,url);
 	login_box_close();
 }

/**
 *
 */
 function login_box_close(){
 	$('.widget_link_box').animate({'margin-top': '-' + ($(window).scrollTop() + $(window).height()) + 'px'}, "slow",function(){
 		$('.widget_link_back,.widget_link_box').remove();
 	});
 }

/**
 * 挂件选择弹出层
 */
 var widget_link_save_box = {};

 function widget_link_box(dom,type,after_obj){
	//点击事件
	dom.click(function(){
		//移除
		$('.modal-backdrop,.modal').remove();

		//增加
		$('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');

		//赋值
		var randNum = getRandNumber();
		
		var load_url = 'user.php?c=widget&a='+type+'&type=more&number='+randNum;

		widget_link_save_box[randNum] = after_obj;

		modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="'+load_url+'" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');

		//增加
		$('body').append(modalDom);

		//动画
		modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");

		//点击关闭
		$('.modal-backdrop').click(function(){
			login_box_close();
		});
	});
}

/**
 * 挂件选择弹出层2 非传递 仅仅显示自营的 未售完de商品
 */
 var widget_link_save_box = {};
 function widget_link_box1(dom,type,after_obj){
 	dom.live("click",function(){
 		$('.modal-backdrop,.modal').remove();
 		$('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');
 		var randNum = getRandNumber();
 		var load_url = 'user.php?c=widget&a='+type+'&type=more&number='+randNum;
 		widget_link_save_box[randNum] = after_obj;
 		modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="'+load_url+'" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
 		$('body').append(modalDom);
 		modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
 		$('.modal-backdrop').click(function(){
 			login_box_close();
 		});
 	});
 }

/**
 * 挂件选择弹出层优惠券 非传递 仅仅显示优惠券
 */
 var widget_link_save_box = {};

 function widget_link_yhq(dom,type,after_obj){
	//点击
	dom.click(function(){
		//移除
		$('.modal-backdrop,.modal').remove();

		//添加
		$('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');

		//赋值
		var randNum = getRandNumber();
		var load_url = 'user.php?c=widget&a='+type+'&type=more&number='+randNum;

		widget_link_save_box[randNum] = after_obj;


		//添加
		modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="'+load_url+'" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
		$('body').append(modalDom);
		
		//动画
		modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");

		//关闭
		$('.modal-backdrop').click(function(){
			login_box_close();
		});
	});
}

/**
 *
 * @param dom
 * @param type
 * @param after_obj
 */
 var widget_link_save_box = {};
 function widget_link_hd(dom,type,after_obj){
	//点击
	dom.click(function(){
		//移除
		$('.modal-backdrop,.modal').remove();

		//添加
		$('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');

		//赋值
		var randNum = getRandNumber();
		var load_url = 'user.php?c=widget&a='+type+'&type=more&number='+randNum;

		widget_link_save_box[randNum] = after_obj;

		//添加
		modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="'+load_url+'" style="width:100%;height:200px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
		$('body').append(modalDom);
		//动画
		modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");

		//关闭
		$('.modal-backdrop').click(function(){
			login_box_close();
		});
	});
}


/**
 * 挂件选择弹出层显示模板

var widget_link_save_box = {};
function widget_link_page(dom,type,after_obj){
	dom.click(function(){
		$('.modal-backdrop,.modal').remove();
		$('body').append('<div class="modal-backdrop fade in widget_link_back"></div>');
		var randNum = getRandNumber();
		var load_url = 'user.php?c=widget&a='+type;
		widget_link_save_box[randNum] = after_obj;
		modalDom = $('<div class="modal fade hide js-modal in widget_link_box" aria-hidden="false" style="margin-top:0px;display:block;"><iframe src="'+load_url+'" style="width:100%;height:600px;border:0;-webkit-border-radius:6px;-moz-border-radius:6px;border-radius:6px;"></iframe></div>');
		$('body').append(modalDom);
		modalDom.animate({'margin-top': ($(window).scrollTop() + $(window).height() * 0.05) + 'px'}, "slow");
		$('.modal-backdrop').click(function(){
			login_box_close();
		});
	});
}
*/

/**
 *
 * @param number
 * @param data
 */
 function widget_box_after(number,data){
 	widget_link_save_box[number](data);
 	login_box_close();
 }

/**
 *
 * @param url
 * @returns {boolean}
 */
 function check_url(url){
 	var reg = new RegExp();
 	reg.compile("^(http|https)://.*?$");
 	if(!reg.test(url)){
 		return false;
 	}
 	return true;
 }
/**
 * 得到对象的长度
 */
 function getObjLength(obj){
 	var number = 0;
 	for(var i in obj){
 		number++;
 	}
 	return number;
 }

/**
 * 得到文件的大小
 */
 function getSize(size){
 	var kb = 1024;
 	var mb = 1024*kb;
 	var gb = 1024*mb;
 	var tb = 1024*gb;
 	if(size<mb){
 		return (size/kb).toFixed(2)+" KB";
 	}else if(size<gb){
 		return (size/mb).toFixed(2)+" MB";
 	}else if(size<tb){
 		return (size/gb).toFixed(2)+" GB";
 	}else{
 		return (size/tb).toFixed(2)+" TB";
 	}
 }

/**
 * 生成一个唯一数
 */
 function getRandNumber(){
 	var myDate=new Date();
 	return myDate.getTime() + '' + Math.floor(Math.random()*10000);
 }

/**
 * 转换成字符串
 */
 var obj2String = function(_obj) {
 	var t = typeof(_obj);
 	if (t != 'object' || _obj === null) {
        // simple data type
        if (t == 'string') {
        	_obj = '"' + _obj + '"';
        }
        return String(_obj);
    } else {
    	if (_obj instanceof Date) {
    		return _obj.toLocaleString();
    	}
        // recurse array or object
        var n, v, json = [],
        arr = (_obj && _obj.constructor == Array);
        for (n in _obj) {
        	v = _obj[n];
        	t = typeof(v);
        	if (t == 'string') {
        		v = '"' + v + '"';
        	} else if (t == "object" && v !== null) {
        		v = this.obj2String(v);
        	}
        	json.push((arr ? '': '"' + n + '":') + String(v));
        }
        return (arr ? '[': '{') + String(json) + (arr ? ']': '}');
    }
};

/**
 *
 * @param act loading加载中  complete完成
 * @param txt 显示的文本
 * @param fun 完成动作的回调函数
 */
 var teaAlertLoading = false;
 var teaAlertTime;
 function teaAlert(txt,act, fun) {
 	act = act?act:"complete";
 	if (act=="loading") {
 		if (teaAlertLoading) {
 			return false;
 		} else{
 			teaAlertLoading = true;
 			$('.teaAlert').remove();
 			var txt = txt?txt:"保存中";
 			var div = $('<div class="teaAlert teaAlertLoading" style="background: rgba(0,0,0,0.8);padding:0px 20px;min-height: 70px;margin:-35px 0 0 -120px;min-width: 240px;position: fixed;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 40px;padding:15px 0;font-size:18px;display:block">' + txt + '</span></div>');
 			$('body').append(div);
 			div.css('zIndex', 9999999);
 			div.css('left', parseInt(($(window).width() - div.width())*0.5));
 			var top = parseInt(($(window).height() - div.height())*0.5);
 			div.css('top', top);
 			teaAlertTime = setTimeout(function () {
 				$('.teaAlert.teaAlertLoading span').html('操作失败，请重试！')
 				window.location.reload();
 			}, 10000);
 		};
 	} else if(act="complete"){
 		var txt = txt?txt:"保存成功";
 		clearTimeout(teaAlertTime)
 		if ($('.teaAlert.teaAlertLoading').size()>0) {
 			$('.teaAlert.teaAlertLoading').removeClass('teaAlertLoading').addClass('teaAlertComplete').find('span').html(txt);
 			setTimeout(function () {
 				$('.teaAlert').remove();
 				teaAlertLoading = false;
 			}, 1500)
 		} else{
 			$('.teaAlert').remove();
 			var div = $('<div class="teaAlert teaAlertComplete" style="background: rgba(0,0,0,0.8);padding:0px 20px;min-height: 70px;margin:-35px 0 0 -120px;min-width: 240px;position: fixed;text-align: center;border-radius:10px;"><span style="color: #ffffff;line-height: 40px;padding:15px 0;font-size:18px;display:block">' + txt + '</span></div>');
 			$('body').append(div);
 			div.css('zIndex', 9999999);
 			div.css('left', parseInt(($(window).width() - div.width()) / 2));
 			var top = parseInt($(window).scrollTop() + ($(window).height() - div.height()) / 2);
 			div.css('top', top);
 			setTimeout(function () {
 				div.remove();
 				teaAlertLoading = false;
 				if (fun) {
 					eval("(" + fun + "())");
 				}
 			}, 1500);
 		};
 	};
 }

/*
 * 获取地址栏参数
 * param name    参数名
 */
function getUrlParam(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.href.substr(1).match(reg);
     if(r!=null){
     	return unescape(r[2])
     }else{
     	return false;
     }
}
/*
* 替换当前url的某个参数值 
* obj 新的参数值 {param1:value1,param2:value2}
* reload 是否刷新界面
*/
function replaceParamVal(obj,reload) {
    var origin = !window.location.origin?window.location.protocol + "//" + window.location.hostname + port:window.location.origin;
    var oUrl = this.location.href.toString().replace(origin,'');
    var port = window.location.port ? ':' + window.location.port: '';
    var reload = reload===true? true:false;
    var cacheUrl = oUrl;
    for (param in obj){
		if (getUrlParam(param)) {
		    var re=eval('/('+ param+'=)([^&^#]*)/gi');
		    cacheUrl = cacheUrl.replace(re,param+'='+obj[param]);
		} else if(getUrlParam(param)==="") {
		    cacheUrl = cacheUrl.replace(param+'=',param+'='+obj[param]);
		} else {
			var nUrl =cacheUrl += '&'+param+'='+obj[param];
		};
    }
	var newObj = new Object();
	newObj.rand = Math.random();
	reload?window.location.href = cacheUrl:window.history.replaceState(newObj, "", cacheUrl);
}
replaceParamVal.remove = function (name,reload) {
	var origin = !window.location.origin?window.location.protocol + "//" + window.location.hostname + port:window.location.origin;
    var oUrl = window.location.href.toString().replace(origin,'');
    var port = window.location.port ? ':' + window.location.port: '';
    var reload = reload===true? true:false;
    var cacheUrl = oUrl;
	if (getUrlParam(name)||getUrlParam(name)==="") {
	    var re=eval('/('+ name+'=)([^&^#]*)/gi');
	    cacheUrl = cacheUrl.replace(re,name+'=');
	    cacheUrl = cacheUrl.replace('&'+name+'=','');
	} else {
		return;
	};
	var newObj = new Object();
	newObj.rand = Math.random();
	reload?window.location.href = cacheUrl:window.history.replaceState(newObj, "", cacheUrl);
}
/** 把时间戳转换成年月日时分秒
 * @param times 时间戳 13位
 */
 function format(times)
 {
 	if (String(times).length==10) {
	 	var times = String(times)+'000'
 	};
 	var time = new Date(Number(times));
 	var returntime = time.format('yyyy-MM-dd hh:mm:ss')
 	return returntime.toString();
 }

/** 获取近days的时间戳
 * @param days 天数 0今天
 * @param one true?前days天:前days天到今天0点
 */
function changeDate(days,one){
    var today=new Date(); // 获取今天时间
    var begin;
    var days = Number(days);
    if (one) {
    	var todayend = new Date(today.format('yyyy-MM-dd 23:59:59')).getTime();
    	var todaystart = new Date(today.format('yyyy-MM-dd 00:00:00')).getTime();
	    var begin = todaystart-days*24*3600*1000;
	    var end = todayend-days*24*3600*1000;
	    return {'begin': begin, 'end': end};
    } else{
		today.setTime(today.getTime()-days*24*3600*1000);
		begin = today.format('yyyy-MM-dd');
		today = new Date();
		days===0?'':today.setTime(today.getTime()-1*24*3600*1000);
		end = today.format('yyyy-MM-dd');
		return {'begin': begin + ' 00:00:00', 'end': end + ' 23:59:59'};
    };
	    
}

/** 把年月日 时分秒转换成时间戳
 * @param date "2016-08-10 16:56:15" 或者 "2016-08-10"
 * @param forphp  时间戳位数 true or false
 */
function returnformat(date,forphp){
	if (!date) {
		return "";
	};
	if (typeof(forphp)=="boolean") {
		forphp = forphp;
	} else{
		forphp = true;
	};
 	var time = new Date(date).getTime();
 	if (forphp) {
 		returntime = String(time).substring(0,10)
 	} else{
 		returntime = time.toString();
 	};
 	return returntime;
 }
/** 格式化时间
 * new Date(1470819375940).format('yyyy-MM-dd hh:mm:ss');  //return "2016-08-10 16:56:15"
 * new Date(1470819375940).format('yyyy-MM-dd');  //return "2016-08-10"
 */
Date.prototype.format = function(format){
    var o = {
        "M+" : this.getMonth()+1, //month
        "d+" : this.getDate(),  //day
        "h+" : this.getHours(), //hour
        "m+" : this.getMinutes(), //minute
        "s+" : this.getSeconds(), //second
        "q+" : Math.floor((this.getMonth()+3)/3),  //quarter
        "S" : this.getMilliseconds() //millisecond
    }
    if(/(y+)/.test(format)) {
        format=format.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    }
    for(var k in o) {
        if(new RegExp("("+ k +")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length==1 ? o[k] : ("00"+ o[k]).substr((""+ o[k]).length));
        }
    }
    return format;
}
 /** 
 * 弹出一个窗口
 * @param type 1 DOM 2 iframe 3多个DOM（选项卡）
 * @param dom 要载入的DOM 或 url
 * @param fun 弹窗动画结束后回调函数
 * @param fun 弹窗关闭后的回调函数
 * @param animate 是否开启动画
 * type = 3 时dom 的格式为[['标题1','标题2','标题3'],['DOM1','DOM2','DOM3']]
 */
 function teaLayer (type,dom,title,fun,closefun,animate) {
 	var animate = typeof(animate)!='undefined'?animate:true;
 	var type = Number(type);
 	var myclass = 'layer'+getRandNumber();
 	var html = '<div class="modal-backdrop fade in '+myclass+'"></div>';
 	if (type==1) {
 		var widgetDom = $('<div class="widget-image modal '+(animate?'fade':'')+' in '+myclass+'" data-id="'+myclass+'" style="top:-520px"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><ul class="module-nav modal-tab js-modal-tab"><li class="js-modal-tab-item"><a href="javascript:;">'+title+'</a></li></ul></div><div class="modal-body">'+dom+'</div></div>');	
 	} else if(type==2) {
 		var widgetDom = $('<div class="widget-image modal '+(animate?'fade':'')+' in '+myclass+'" data-id="'+myclass+'" style="top:-520px"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><ul class="module-nav modal-tab js-modal-tab"><li class="js-modal-tab-item"><a href="javascript:;">'+title+'</a></li></ul></div><div class="modal-body">'+dom+'</div></div>');
 	} else if(type==3) {
 		if((typeof (dom)=="object") && (dom[0].length == dom[1].length)){
 			var liDom = "";
 			var paneDom = "";
 			for (var i = 0; i < dom[0].length; i++) {
 				if (i==dom[0].length-1) {
 					liDom = liDom + '<li class="js-modal-tab-item"><a href="javascript:;" data-pane="'+i+'">'+dom[0][i]+'</a></li>';
 				} else{
 					liDom = liDom + '<li class="js-modal-tab-item"><a href="javascript:;" data-pane="'+i+'">'+dom[0][i]+'</a><span>|</span></li>';
 				};
 			};
 			for (var j = 0; j < dom[0].length; j++) {
 				paneDom = paneDom + '<div class="hide js-tab-pane js-tab-pane'+j+'">'+dom[1][j]+'</div>';
 			};
 			var widgetDom = $('<div class="widget-image modal fade in '+myclass+'" data-id="'+myclass+'"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><ul class="module-nav modal-tab js-modal-tab">'+liDom+'</ul></div><div class="modal-body">'+paneDom+'</div></div>');
 			widgetDom.find('.js-modal-tab a').click(function(){
 				if(!$(this).closest('li').hasClass('active')){
 					$(this).closest('li').addClass('active').siblings('li').removeClass('active');
 					widgetDom.find('.js-tab-pane'+$(this).data('pane')).removeClass('hide').siblings('.js-tab-pane').addClass('hide');
 				}
 			});
 		}
 	};
	// var widgetDom = $('<div class="widget-image modal fade in"><div class="modal-header"><a class="close" data-dismiss="modal">×</a><ul class="module-nav modal-tab js-modal-tab"><li class="js-modal-tab-item js-modal-tab-image"><a href="javascript:;" data-pane="image">用过的图片</a><span>|</span></li><li class="js-modal-tab-item js-modal-tab-upload active"><a href="javascript:;" data-pane="upload">新图片</a></li></ul></div></div>');
	$('body').append(html);
	$('body').append(widgetDom);
	widgetDom.find('.js-modal-tab a').eq(0).click();
	if (fun) {
		eval("(" + fun + "())");
	}
	if (animate) {
		widgetDom.animate({
			'top': ($(window).scrollTop() + ($(window).height()-widgetDom.height()) * 0.5) + 'px'
		},200,function () {
			widgetDom.find('.close').click(function(){
				if (closefun) {
					eval("(" + closefun + "())");
				}
				$('.'+myclass).remove();
			});
		});
	} else{
		widgetDom.css('top', ($(window).scrollTop() + ($(window).height()-widgetDom.height()) * 0.5) + 'px');
		widgetDom.find('.close').click(function(){
			if (closefun) {
				eval("(" + closefun + "())");
			}
			$('.'+myclass).remove();
		});
	};
}
/** 
* 全屏界面函数
* 
*/
function openFullScreen() {
	var docElm = document.documentElement;
	if (docElm.requestFullscreen) {
		docElm.requestFullscreen();
	}
	else if (docElm.msRequestFullscreen) {
		docElm.msRequestFullscreen();
	}
	else if (docElm.mozRequestFullScreen) {
		docElm.mozRequestFullScreen();
	}
	else if (docElm.webkitRequestFullScreen) {
		docElm.webkitRequestFullScreen();
	}
}
function openFullScreenAfter () {
	$('#live-fullscreen').show();
	fullScreen =true;
	document.documentElement.style.overflowY = 'hidden';
	document.documentElement.style.overflowX = 'hidden';
}
function closeFullScreen() {
	fullScreen =false;
	if (document.exitFullscreen) {
		document.exitFullscreen();
	}
	else if (document.msExitFullscreen) {
		document.msExitFullscreen();
	}
	else if (document.mozCancelFullScreen) {
		document.mozCancelFullScreen();
	}
	else if (document.webkitCancelFullScreen) {
		document.webkitCancelFullScreen();
	}
}
function closeFullScreenAfter () {
	$('#live-fullscreen').hide();
	window.location.reload();
	document.documentElement.style.overflowY = 'auto';
	document.documentElement.style.overflowX = 'hidden';
}
function loadRound () {
	var c = document.getElementById('middle-round'),
	ctx = c.getContext('2d'),
	cw = c.width = 320,
	ch = c.height = 320,
	rand = function(a,b){return ~~((Math.random()*(b-a+1))+a);},
	dToR = function(degrees){
		return degrees * (Math.PI / 180);
	},
	circle = {
		x: (cw / 2) + 5,
		y: (ch / 2) + 22,
		radius: 100,
		speed: 1.5,
		rotation: 0,
		angleStart: 270,
		angleEnd: 90,
		hue: 220,
		thickness: 18,
		blur: 25
	},
	particles = [],
	particleMax = 100,
	updateCircle = function(){
		if(circle.rotation < 360){
			circle.rotation += circle.speed;
		} else {
			circle.rotation = 0; 
		}
	},
	renderCircle = function(){
		ctx.save();
		ctx.translate(circle.x, circle.y);
		ctx.rotate(dToR(circle.rotation));
		ctx.beginPath();
		ctx.arc(0, 0, circle.radius, dToR(circle.angleStart), dToR(circle.angleEnd), true);
		ctx.lineWidth = circle.thickness;    
		ctx.strokeStyle = gradient1;
		ctx.stroke();
		ctx.restore();
	},
	renderCircleBorder = function(){
		ctx.save();
		ctx.translate(circle.x, circle.y);
		ctx.rotate(dToR(circle.rotation));
		ctx.beginPath();
		ctx.arc(0, 0, circle.radius + (circle.thickness/2), dToR(circle.angleStart), dToR(circle.angleEnd), true);
		ctx.lineWidth = 2;  
		ctx.strokeStyle = gradient2;
		ctx.stroke();
		ctx.restore();
	},
	renderCircleFlare = function(){
		ctx.save();
		ctx.translate(circle.x, circle.y);
		ctx.rotate(dToR(circle.rotation+185));
		ctx.scale(1,1);
		ctx.beginPath();
		ctx.arc(0, circle.radius, 30, 0, Math.PI *2, false);
		ctx.closePath();
		var gradient3 = ctx.createRadialGradient(0, circle.radius, 0, 0, circle.radius, 30);      
		gradient3.addColorStop(0, 'hsla(330, 50%, 50%, .35)');
		gradient3.addColorStop(1, 'hsla(330, 50%, 50%, 0)');
		ctx.fillStyle = gradient3;
		ctx.fill();     
		ctx.restore();
	},
	renderCircleFlare2 = function(){
		ctx.save();
		ctx.translate(circle.x, circle.y);
		ctx.rotate(dToR(circle.rotation+165));
		ctx.scale(1.5,1);
		ctx.beginPath();
		ctx.arc(0, circle.radius, 25, 0, Math.PI *2, false);
		ctx.closePath();
		var gradient4 = ctx.createRadialGradient(0, circle.radius, 0, 0, circle.radius, 25);
		gradient4.addColorStop(0, 'hsla(30, 100%, 50%, .2)');
		gradient4.addColorStop(1, 'hsla(30, 100%, 50%, 0)');
		ctx.fillStyle = gradient4;
		ctx.fill();     
		ctx.restore();
	},
	createParticles = function(){
		if(particles.length < particleMax){
			particles.push({
				x: (circle.x + circle.radius * Math.cos(dToR(circle.rotation-85))) + (rand(0, circle.thickness*2) - circle.thickness),
				y: (circle.y + circle.radius * Math.sin(dToR(circle.rotation-85))) + (rand(0, circle.thickness*2) - circle.thickness),
				vx: (rand(0, 100)-50)/1000,
				vy: (rand(0, 100)-50)/1000,
				radius: rand(1, 6)/2,
				alpha: rand(10, 20)/100
			});
		}
	},
	updateParticles = function(){
		var i = particles.length;
		while(i--){
			var p = particles[i];
			p.vx += (rand(0, 100)-50)/750;
			p.vy += (rand(0, 100)-50)/750;
			p.x += p.vx;
			p.y += p.vy;
			p.alpha -= .01;

			if(p.alpha < .02){
				particles.splice(i, 1)
			}
		}
	},
	renderParticles = function(){
		var i = particles.length;
		while(i--){
			var p = particles[i];
			ctx.beginPath();
			ctx.fillRect(p.x, p.y, p.radius, p.radius);
			ctx.closePath();
			ctx.fillStyle = 'hsla(0, 0%, 100%, '+p.alpha+')';
		}
	},
	clear = function(){
		ctx.globalCompositeOperation = 'destination-out';
		ctx.fillStyle = 'rgba(0, 0, 0, .1)';
		ctx.fillRect(0, 0, cw, ch);
		ctx.globalCompositeOperation = 'lighter';     
	}
	loop = function(){
		clear();
		updateCircle();
		renderCircle();
		renderCircleBorder();
		renderCircleFlare();
		renderCircleFlare2();
		createParticles();
		updateParticles();
		renderParticles();
	}

	ctx.shadowBlur = circle.blur;
	ctx.shadowColor = 'hsla('+circle.hue+', 80%, 60%, 1)';
	ctx.lineCap = 'round'

	var gradient1 = ctx.createLinearGradient(0, -circle.radius, 0, circle.radius);
	gradient1.addColorStop(0, 'hsla('+circle.hue+', 60%, 50%, .25)');
	gradient1.addColorStop(1, 'hsla('+circle.hue+', 60%, 50%, 0)');

	var gradient2 = ctx.createLinearGradient(0, -circle.radius, 0, circle.radius);
	gradient2.addColorStop(0, 'hsla('+circle.hue+', 100%, 50%, 0)');
	gradient2.addColorStop(.1, 'hsla('+circle.hue+', 100%, 100%, .7)');
	gradient2.addColorStop(1, 'hsla('+circle.hue+', 100%, 50%, 0)');

	setInterval(loop, 16);
}
// live charts

$(function () {
	if ($('#live-charts').size()>0) {
		$('#live-charts').highcharts({
			chart: {
				backgroundColor: 'rgba(255,255,255,0)',
				borderColor: 'rgba(255,255,255,0)',
				type: 'areaspline',
				height: 150,
				spacing:0,
				events: {                                                           
					load: function() {
						var series1 = this.series[0];                                
						setInterval(function() {                                    
							var x = (new Date()).getTime(),   
							y = Math.random();                                  
							series1.addPoint([x, y], true, true);                    
						}, 50000);
						var series2 = this.series[1];                                
						setInterval(function() {                                    
							var x = (new Date()).getTime(),   
							y = Math.random();                                  
							series2.addPoint([x, y], true, true);                    
						}, 50000);                                                 
					}                                                               
				} 
			},
			legend: {
				layout: 'vertical',
				floating:true,
				align:'right',
				verticalAlign: 'top',
				itemStyle:{
					color: '#ccc',
					fontWeight: 'normal'
				},
				itemHoverStyle: {
					color: '#fff'
				}
			},
			title:{
				text: null
			},
			xAxis: {
				gridLineColor:'rgba(255,255,255,0)',
				lineColor:'rgba(255,255,255,0)',
				tickLength: 0,
				title: {
					text: null
				},
				labels: {
					enabled: false
				}
			},
			yAxis:{
				gridLineColor:'rgba(255,255,255,0)',
				lineColor:'rgba(255,255,255,0)',
				title: {
					text: null                                                   
				}, 
				labels:{
					enabled: false
				}
			},
			tooltip: {                                                              
				formatter: function() {                                             
					return '<b>'+ this.series.name +'</b><br/>'+
					Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) +'<br/>'+
					Highcharts.numberFormat(this.y, 2);
				}                                                                   
			},
			credits:{
				enabled:false
			},
			series: [{
				xAxis:0,
				yAxis:0,
				name: '访客数',
				lineWidth: 0,
				marker:{
					enabled:false
				},
				color:"#7ca5e2",
				data: (function() {
					var data = [],                                                  
					time = (new Date()).getTime(),                              
					i;                                                          
					for (i = -19; i <= 0; i++) {                                    
						data.push({                                                 
							x: time + i * 1000,                                     
							y: Math.random()                                        
						});                                                         
					}                                                               
					return data;                                                    
				})() 
			},
			{
				xAxis:0,
				yAxis:0,
				name: '买家数',
				lineWidth: 0,
				marker:{
					enabled:false
				},
				color:"#1a5295",
				data: (function() {                                                 
					var data = [],                                                  
					time = (new Date()).getTime(),                              
					i;                                                          
					for (i = -19; i <= 0; i++) {                                    
						data.push({                                                 
							x: time + i * 1000,                                     
							y: Math.random()                                        
						});                                                         
					}                                                               
					return data;                                                    
				})() 
			}]
		});
};
});   				