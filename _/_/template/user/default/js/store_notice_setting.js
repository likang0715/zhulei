/**
 * Created by pigcms-s on 2015/10.26
 */

$(function(){
	
	
	//保存已经选择的 通知选项
	$(".js-btn-save-store").live("click",function(){
		var fields_seria = $(".js-list-body-region input[type='checkbox']").serializeArray();
		$.post(
			load_url, 
			{"page":'store_notice_setting',"fields_seria":fields_seria}, 
			function(data){
				if(data.status == '0') {
					alert("保存成功！");
					window.reload();
				} else {
					alert("保存失败！")
				}
			},
			'json'
		)		
	});
	
    // 旧版主营类目设置
 //    $('.js-category-edit').live("click",function(){
 //        $('.js-business').css('display','block');
 //    });
    
	// $('.sale-category').live('click', function(){
 //        var categories = $.parseJSON(json_categories);
 //        var cat_id = $(this).val();
 //        $(this).closest('.widget-selectbox').next('.widget-selectbox').remove();
 //        if ($(this).is(':checked')) {
 //            if(categories[cat_id] != '' && categories[cat_id] != undefined && categories[cat_id]['children'] != '' && categories[cat_id]['children'] != undefined) {
 //                var html = ' <div class="widget-selectbox">';
 //                    html += '   <span href="javascript:;" class="widget-selectbox-handle" style="border-color: rgb(204, 204, 204);">' + categories[cat_id]['children'][0]['name'] + '</span>';
 //                    html += '   <ul class="widget-selectbox-content" style="display: none;">';
 //                    for (i in categories[cat_id]['children']) {
 //                        checked = '';
 //                        if (i == 0) {
 //                            var checked = 'checked="true"';
 //                        }
 //                        html += '       <li data-id="' + categories[cat_id]['children'][i]['cat_id'] + '"><label class="radio"><input type="radio" name="sale_category_id" class="sale-category" value="' + categories[cat_id]['children'][i]['cat_id'] + '" data="' + categories[cat_id]['children'][i]['name'] + '" ' + checked + ' />' + categories[cat_id]['children'][i]['name'] + '</label></li>';
 //                    }
 //                    html += '   </ul>';
 //                    html += '</div>'
 //                $('.sale-category').closest('.widget-selectbox').after(html);
 //            }
 //            $(this).closest('.widget-selectbox').find('.widget-selectbox-handle').html($(this).attr('data'));
 //            $(this).closest('.widget-selectbox-content').hide();
 //            $('.widget-selectbox-handle').css('border-color','#ccc');
 //            $('.sale-category').parents('.js-business').next('.error-message').remove();
 //        }
 //    });
		
	// $('.widget-selectbox').live('hover', function(){
 //        if (event.type == 'mouseover') {
 //            $(this).children('.widget-selectbox-handle').css('border-bottom-color', 'transparent');
 //            $(this).children('.widget-selectbox-content').show();
 //        } else if (event.type == 'mouseout') {
 //            $(this).children('.widget-selectbox-handle').css('border-color','#ccc');
 //            $(this).children('.widget-selectbox-content').hide();
 //        }
	// });

    //主营类目
    $.fn.storeCateSelect = function () {
        var self = $(this);
        var fBox = $(".scb-li:eq(0)", self);
        var cBox = $(".scb-li:eq(1)", self);
        var fid = self.data("fid");
        var cid = self.data("cid");
        var fIpt = $('input[name="sale_category_fid"]', self);
        var cIpt = $('input[name="sale_category_id"]', self);

        var setObj = {
            init : function  () {

                $(".js-flabel", fBox).bind('click', function(){
                    var btn = $(this);
                    var cat_id = btn.data('cat_id');
                    btn.siblings(".selected").removeClass("selected").end().addClass("selected");
                    $(".js-clabel", cBox).hide();
                    $(".fid_"+cat_id, cBox).show();

                    if ($(".fid_"+cat_id, cBox).length > 0) {
                        cBox.show();
                    } else {
                        cBox.hide();
                    }

                    $(".js-clabel", cBox).removeClass("selected");
                    // $(".js-clabel input[name='sale_category_id']", cBox).attr('checked', false);
                    fIpt.val(cat_id);
                    cIpt.val(0);
                });

                $(".js-clabel", cBox).bind('click', function(){
                    var btn = $(this);
                    var cat_id = btn.data('cat_id');
                    btn.siblings(".selected").removeClass("selected").end().addClass("selected");
                    cIpt.val(cat_id);
                });

                $(".scb-cancel", fBox).bind('click', function(){
                    setObj.render();
                });

                setObj.render();
            },
            render : function () {

                $('.scb-label', cBox).hide();
                if (fid > 0) {
                    $('fid_'+fid).show();
                    $('.scb-label[data-cat_id="'+fid+'"]', fBox).siblings(".selected").removeClass("selected")
                        .end().addClass("selected");
                } else {
                    $('.scb-label', cBox).hide();
                }

                if (cid > 0) {
                    cBox.show();
                    $('.scb-label[data-cat_id="'+cid+'"]', cBox).siblings(".selected").removeClass("selected")
                        .end().addClass("selected").show();
                } else {
                    cBox.hide();
                }

                fIpt.val(fid);
                cIpt.val(cid);
            }
        };

        setObj.init();
        return setObj;

    }

    $('.js-category-edit').live("click",function(){
        $('.set-cate-block').show();
    });

})