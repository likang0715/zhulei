<form class="form-horizontal">
	<input type="hidden" id="aid" value="<?php echo $article['id']?>"/>
    <div class="control-group">
        <label class="control-label">
            动态标题：
        </label>
        <div class="controls">
            <input type="text" id="title" value="" maxlength="20" style="width:400px;">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            动态描述：
        </label>
        <div class="controls">
            <textarea id="desc" rows="5" cols="20" maxlength="500" style="width:400px;" onblur="checklength()"></textarea>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">
            <em class="required">*</em>
            展示图片：
        </label>
        <div class="controls">
            <div class="control-action js-picture-list-wrap">
                <ul class="app-image-list clearfix">
                    <div class="js-img-list" style="display: inline-block"></div>
                    <li class="js-picture-btn-wrap" style="display:inline-block;float:none;vertical-align: top;">
                        <a href="javascript:;" class="add js-add-banner-picture">+加图</a>
                    </li>
                </ul><span style="vertical-align: middle;color: red;">(建议尺寸 400&times400)</span>
            </div>
        </div>
    </div>
    <input type="hidden" id="pic" name="pic" value=""/>

    <div class="control-group">
		<input type="hidden" name="product_id" id="product_id" value="0">
		<input type="hidden" name="sku_id" id="sku_id" value="0">
		<label class="control-label">
			<em class="required"> *</em>选择商品：
		</label>
		<div class="controls">
			<ul class="ico app-image-list js-product" data-product_id="0">
				<li id="addpicture"><a href="javascript:;" class="add-goods js-add-product">选商品</a></li>
			</ul>
		</div>
	</div>
	 <div class="control-group">
        <label class="control-label">
            是否发布：
        </label>
        <div class="controls">
            <div class="checkbox">
		    <label><input type="checkbox" id="status">发布</label>
		  </div>
        </div>
    </div>
    <div class="form-actions" style="margin-top:50px">
        <button type="button" class="ui-btn ui-btn-primary js-banner-save" onclick="save()">保存</button>
    </div>
</form>
<script type="text/javascript">
	//添加店铺横幅广告
    $(".js-add-banner").live("click",function(){
        var type = window.location.hash.substring(1);

        load_page('.app__content',load_url,{ page:'banner_add'},'');
    })

    //修改店铺横幅广告
    $(".js-banner-edit").live("click",function(){
        $_this = $(this);
        var id = $_this.closest("tr").attr("id");

        load_page('.app__content', load_url,{page:'banner_edit', id : id},'',function(){});
    })

    //上传横幅广告图片
    $('.js-add-banner-picture').live('click',function(){
        if($('.js-img-list li').size() >= 9){
            layer_tips(1,'最多只能上传9张图片');
            return false;
        }else{
            upload_pic_box(1,true,function(pic_list){
                if(pic_list.length > 0){
                    for(var i in pic_list){
                        var list_size = $('.js-img-list li').size();
                        if(list_size > 9){
                            layer_tips(1,'上传图片过多');
                            return false;
                        }else{
                            $('#pic').val(pic_list[i]);
                            $('.js-img-list').append('<li class="upload-preview-img"><a href="'+pic_list[i]+'" target="_blank"><img src="'+pic_list[i]+'"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
                        }
                    }
                }
            },1);
        }
    });
    $('.js-delete-picture').live('click',function(){
        $(this).closest('li').remove();
    });

    // 商品添加
	// 选取商品
	widget_link_box($(".js-add-product"), "store_goods_by_sku", function (result) {
		var good_data = pic_list;
		$('.js-goods-list .sort').remove();
		for (var i in result) {
			item = result[i];
			var pic_list = "";
			var list_size = $('.js-product .sort').size();
			if(list_size > 0){
				layer_tips(1, '最多只能添加一件商品！');
				return false;
			}
			
			$(".js-product").prepend('<li class="sort" data-pid="' + item.product_id + '" data-skuid="' + item.sku_id + '"><a href="' + item.url + '" target="_blank"><img data-pid="' + item.product_id + '" alt="' + item.title + '" title="' + item.title + '" src="' + item.image + '"></a><a class="js-delete-picture close-modal small hide">×</a></li>');
			$(".js-product").data("product_id", item.product_id);

			//$("input[name=price]").val(item.price);
			$('#price').text(item.price);
			$("input[name=product_id]").val(item.product_id);
			$("input[name=sku_id]").val(item.sku_id);
			$(".js-add-picture").parent().hide();
		}
	});

	// 删除商品
	$('.js-delete-picture').live('click',function(){
		$('#addpicture').show();
		$(this).parent('li').remove();
		$('#product_id').val(0);
		$('#sku_id').val(0);
	});


	// 保存
	function save(){
		var data = new Object();
		data.title = $('#title').val();
		data.desc = $('#desc').val();
		var length = data.desc.length;
		if(length>500){
			layer_tips(1, '动态描述最多输入500字');
			return;
		}
		// 商品图片
		var imgs = $('.js-img-list').children('li').children('a').children('img');
		var img_arr = [];
		$.each(imgs,function(i,v){
			img_arr[i] = $(v).attr('src');
		});
		if(img_arr.length<=0){
			layer_tips(1, '请上传商品图片');
			return false;
		}
		data.pictures = img_arr.join(',');
		data.product_id = parseInt($('#product_id').val());
		data.sku_id = parseInt($('#sku_id').val());
		if(data.product_id<=0&&data.sku_id<=0){
			layer_tips(1, '请上传商品');
			return false;
		}
		data.status = $('#status').is(':checked')?1:0;
		var aid = $('#aid').val();
		$.post('/user.php?c=article&a=save',{'data':data,'aid':aid},function(response){
			if(response.err_code==1){
				layer_tips(1, response.err_msg);
			}else{
				layer_tips(0, response.err_msg);
				setTimeout(function(){
					window.location.href='/user.php?c=article&a=index';
				},1000);
			}
		},'json');
	}

	// 检查描述长度
	function checklength(){
		var length = $('#desc').val().length;
		if(length>500){
			layer_tips(1, '动态描述最多输入500字');
		}
	}
</script>