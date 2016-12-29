						<!-- ▼ Main container -->
						<!-- 
						<div class="widget-list">
						  <div style="position:relative;" class="js-list-filter-region clearfix ui-box">
							  <div>
								  <a class="ui-btn ui-btn-primary" href="#create">新建标签</a>
								  <!--  <a class="ui-btn ui-btn-primary2 downloadtag" target="_blank" href="<?php echo dourl("tag_download_csv");?>"></a>
								  <div class="js-list-search ui-search-box">
									  <input type="text" value="<?php echo $keyword;?>" placeholder="搜索" class="txt js-coupon-keyword">
								  </div>
							  </div>
						  </div>
						</div>
						-->
						<style>
						.ui-table-list .fans-box .fans-avatar {float: left;width: 60px;height: 60px;background: #eee;overflow: hidden;}
						.ui-table-list .fans-box .fans-avatar img {width: 60px;height: auto;}
						.ui-table-list .fans-box .fans-msg {float: left;}
						.ui-table-list .fans-box .fans-msg p {padding: 0 5px;text-align: left;}
						</style>
						<!-- ▼ Main container -->
						
						
<div class="app-design-wrap">
<div class="app-design clearfix without-add-region"><div class="page-tradeincard">

<style>
.app-fans-points-edit .checkbox {color: #999;margin-left: 16px;}
button, input, label, select, textarea {font-size: 14px;font-weight: 400;line-height: 20px;font-family:Helvetica,STHeiti,"Microsoft YaHei",Verdana,Arial,Tahoma,sans-serif;}
.input-append .add-on, .input-append .btn, .input-append .btn-group{margin-left:-3px;}
.avatar img{width:50px;height:50px}
.hyname {width:90%;height:auto;display:inline-block}
.hyname li{float:left;width:30%;height:25px;line-height:25px;}
.control-group.error .input-append .add-on, .control-group.error .input-prepend .add-on {color: #b94a48;background-color: #f2dede;border-color: #b94a48;}
</style>

	
<div class="app__content">
		<form class="js-page-form form-horizontal ui-form" method="POST" novalidate="novalidate">
			<div class="form-forms">
			<div class="control-group">
				<label class="control-label"><em class="required">*</em>
					攻略标题</label>
				<div class="controls">
					<input type="text" class="for-post input-medium" maxlength="30" name="subject_title" value="<?php echo $tag['name'];?>">	
				</div>
			</div>
			
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required">*</em>攻略分类</label>
				<div class="controls">
					<select class="select_toptype">
						<option value="">未选择</option>
						<?php if(is_array($subtype_list)) {?>
							<?php foreach($subtype_list as $k=>$v) :?>
								<option value="<?php echo $v['id']?>"><?php echo $v['typename'];?></option>
							<?php endforeach;?>
						<?php }?>
					</select>
					
					<select class="select_sontype" style="display:none"></select>
					<p class="help-desc">攻略分类增加，请点击 <b><a href="javascript:void(0)">这里</a></b>。</p>
				</div>
			</div>

			<style>
				.controls .help-desc{clear:both;}
				.controls .help-desc a{color:#07d}
				.controls .ico li{float:left;width:54px;display:inline-block;height:55px;cursor:pointer}
				.controls .ico li .avatar{height:50px;width:50px;display:inline-block}
				.ico .spans{position:relative}
				.no-selected-style i{display:none;}
				.app-image-list .other_li{background:none;border:0px;}
			</style>		
	
	
	
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required">*</em>上传图片</label>
				<div class="controls">

					<ul class="ico app-image-list js-ico-list js-subject-ico">
						<li>  <a href="javascript:;" class="add-goods js-add-sub-picture">+加图</a>  </li>
					</ul>
					
					 <p class="help-desc">如需上传图片，请 <b><a href="javascript:" class="js-add-sub-picture">点击</a></b> 上传。</p> 
				</div>
			</div>
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label">攻略内容</label>
				<div class="controls">

							<textarea id="description" class="description" style="height:auto;width:65%" name="description" cols="55" rows="5" placeholders="最多可输入200个字符，简述相关专题介绍信息，以便浏览者知晓。" maxlength="1200"></textarea>

				</div>
			</div>
<script>
$(function(){
	
	var rightHtmls = $(".controls_good").html();
	var rightHtml = $(rightHtmls);
	$(".controls_good .sort-goods-list").sortable({
      cancel: ".ui-state-disabled"
    }).live('sortupdate', function(j) {
		//$(rightHtmls).find(".controls").sortable().live('sortupdate', function(j) {
		$(".controls_good .sort-goods-list").sortable({cancel: ".ui-state-disabled"}).live('sortupdate', function(j) {
			$(".save_ok").html('<font style="font-size:11px;font-weight:700;color:#f00">商品位置更新成功,保存后生效。</font>').delay(1000).fadeIn(0,function(){
				$(".save_ok").html('温馨提示：上下挪动商品名称，可以改变商品排序!');	
			})
		})
	})
})
</script>
			<div class="control-group controls_good">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required">*</em>关联商品</label>
				<div class="controls module-goods-list sort-goods-list">
					<ul class="ui-state-disabled ico app-image-list js-ico-lists" style="clear:both;">
						<li>  <a href="javascript:;" class="add-goods js-add-sub-product"><i class="icon-product-add"></i></a>  </li>
					</ul>

				</div>
				<div class="controls module-goods-lists ">
					 <p class="help-desc ui-state-disabled">如需上传图片，请 <b><a href="javascript:" class="js-add-sub-product">点击</a></b> 上传。</p> 
					  <p class="help-desc save_ok ui-state-disabled" style="font-weight:700;;">上下挪动商品名称，可以改变商品排序！</p> 
				</div>
			</div>
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required"></em>首页展示</label>
				<div class="controls">
					<input type="radio" name='is_show' value="1" checked="checked"> 是&#12288;&#12288;&#12288;<input type="radio" name='is_show' value="0"  checked="checked">否
				</div>
			</div>

			
			
				
			<div class="form-actions subject_butt">
				<input class="btn btn-primary js-btn-add-save-subject" type="button" value="保 存" data-loading-text="保 存...">
				<input type="button" class="btn btn-defaults js-btn-quit" value="返回" >
			</div>
			</div>
		</form>
	</div>






</div>




</div>


			</form>
		</div>



	</div>
</div>
