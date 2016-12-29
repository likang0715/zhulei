$(function() {
  var ue = UE.getEditor('editor_add', {
    toolbars: [
      ["bold", "italic", "underline", "strikethrough", "forecolor", "backcolor", "justifyleft", "justifycenter", "justifyright", "|", "insertunorderedlist", "insertorderedlist", "blockquote"],
      ["emotion", "uploadimage", "insertvideo", "link", "removeformat", "|", "rowspacingtop", "rowspacingbottom", "lineheight", "paragraph", "fontsize"],
      ["inserttable", "deletetable", "insertparagraphbeforetable", "insertrow", "deleterow", "insertcol", "deletecol", "mergecells", "mergeright", "mergedown", "splittocells", "splittorows", "splittocols"]
    ],
    autoClearinitialContent: false,
    autoFloatEnabled: true,
    wordCount: true,
    elementPathEnabled: false,
    maximumWords: 10000,
    initialFrameWidth: 458,
    initialFrameHeight: 600,
    focus: false
  });
  $('.js-add-picture').click(function() {
    var list_size = $('.js-picture-list .sort').size();
    if (list_size > 5) {
      layer_tips(1, '包厢图片最多支持 6 张');
      return false;
    }
    var obj = this;
    upload_pic_box(1, true, function(pic_list) {
      if (pic_list.length > 0) {
        for (var i in pic_list) {
          if (list_size > 5) {
            layer_tips(1, '包厢图片最多支持 6 张');
            return false;
          } else if (list_size > 0) {
            $('.js-picture-list .sort:last').after('<li class="sort"><a href="' + pic_list[i] + '" target="_blank"><img src="' + pic_list[i] + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
          } else {
            $('.js-picture-list').prepend('<li class="sort"><a href="' + pic_list[i] + '" target="_blank"><img src="' + pic_list[i] + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
          }
        }
      }
    }, 6 - $('.js-picture-list .sort').size());
  })
  $('.js-add-img').click(function() {
    var obj = this;
    var imgsize = ['840', '480'];
    upload_pic_box2(1, true, function(pic_list) {
      if (pic_list.length > 0) {
        for (var i in pic_list) {
          $('.preview-img-box').html('<li class="sort"><a href="' + pic_list[i] + '" target="_blank"><img src="' + pic_list[i] + '"></a><a class="js-delete-img close-modal small hide">×</a></li>');
        }
      }
    }, 1, imgsize);
  })
  $('.js-delete-picture,.js-delete-img').live('click', function() {
    $(this).closest('li').remove();
  })
  $('#table_submit').live('click', function() {
    var nowDom = $(this);
    layer.closeAll();
    var formObj = {};
    var form = $('#table_form').serializeArray();
    $.each(form, function(i, field) {
      formObj[field.name] = field.value;
    });
    for (var i in formObj) {
      var value = formObj[i];
      switch (i) {
        case 'name':
          if (value == '' || value.length > 20) {
            layer_tips(1, '包厢名称必填且必须小于20个字符');
            $('input[name="name"]').focus();
            return false;
          }
          break;
        case 'wz_id':
          if (!/^\d+$/.test(value)) {
            layer_tips(1, '包厢所属分类未选择');
            $('input[name="wz_id"]').focus();
            return false;
          }
          break;
        case 'description':
          if (value.length == 0) {
            layer_tips(1, '包厢介绍未填写');
            $('input[name="description"]').focus();
            return false;
          }
          break;
        case 'price':
          if (value.length == 0) {
            layer_tips(1, '包厢价格未填写');
            $('input[name="price"]').focus();
            return false;
          }
          break;
        case 'zno':
          if (value.length == 0) {
            layer_tips(1, '容纳人数未填写');
            $('input[name="zno"]').focus();
            return false;
          }
          break;
      }
    }
    formObj['images'] = [];
    formObj['image'] = $('.preview-img-box li a img').eq(0).attr('src');
    $.each($('.js-picture-list li a img'), function(i, item) {
      formObj['images'][i] = $(item).attr('src');
    });
    nowDom.prop('disabled', true).html('保存中...');
    $.post(store_physical_edit_url, formObj, function(result) {
      if (typeof(result) == 'object') {
        if (result.err_code) {
          nowDom.prop('disabled', false).html('保存');
          layer_tips(1, result.err_msg);
        } else {
          layer_tips(0, result.err_msg);
          window.location.href = store_physical_list_url ? store_physical_edit_url : store_physical_list_url;
        }
      } else {
        nowDom.prop('disabled', false).html('保存');
        layer_tips('系统异常，请重试提交');
      }
    });
  });
});