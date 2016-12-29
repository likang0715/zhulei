<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>专题类别修改 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/subject.css" type="text/css" rel="stylesheet"/>

		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<!--  script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script-->
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/subject.js"></script>
		<script>var subtypeid = "<?php echo $array['id'];?>"; var location_type = "<?php echo dourl('subtype');?>";var subtype_editsave_url = "<?php echo dourl('subtype_edit');?>";</script>
		<script>
			//获取当前窗口索引
			var index = parent.layer.getFrameIndex(window.name);

			//关闭iframe
			$('.js-btn-quit-subtype-add').live("click",function(){
			    parent.layer.close(index);
			});
		</script>
	</head>
	
	<body>
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


	
<div class="app__content" style="width:auto;height:auto;min-height:350px;">
		<form class="js-page-form form-horizontal ui-form" method="POST" novalidate="novalidate">
			<div class="form-forms">
			<div class="control-group">
				<label class="control-label"><em class="required">*</em>专题类别名称</label>
				<div class="controls">
					<input type="text" class="for-post input-medium sub_typename" maxlength="30" name="rule_type" value="<?php echo $array['typename'];?>">	
				</div>
			</div>
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required">*</em>所属专题分类</label>
				<div class="controls">
					<select class="toptype" style="width:auto">
						<option <?php if($array['topid'] == 0) {?> selected="selected" <?php }?> value="0">顶级分类</option>
						<?php foreach($subtype_list as $k=>$v) {?>
							<?php if($array['id'] != $v['id']) {?><option <?php if($array['topid']>0) { if($v['id'] == $array['topid']) {?> selected="selected"  <?php }}?> value="<?php echo $v['id']?>"><?php echo $v['typename'];?></option><?php }?>
							<?php if(is_array($v['childArray'])) {?>
								<?php foreach($v['childArray'] as $k1=>$v1) {?>
									<!--  <option value="<?php echo $v1['id']?>">&#12288;|——<?php echo $v1['typename'];?></option>-->
								<?php }?>
							<?php }?>
						<?php }?>
						
					</select>
					
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
	
	
	
			<div class="control-group sub_typepic" <?php if($array['topid'] == 0) {?> style="display:none"<?php }?>>
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required">*</em>上传图片</label>
				<div class="controls">

					<ul class="ico app-image-list js-ico-list">
						<?php if($array['topid']>0) {?>
							
							<li class="sort"><a href="<?php echo $array['typepic']?>" target="_blank"><img src="<?php echo $array['typepic']?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
						
						<?php }?>
					
					
					
					
						<li>  <a href="javascript:;" class="add-goods js-add-subtype-picture">+加图</a>  </li>
					</ul>
					
					 <p class="help-desc">如需上传图片，请 <b><a href="javascript:" class="js-add-subtype-picture">点击</a></b> 上传。</p> 
				</div>
			</div>
			


			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required"></em>排列序号</label>
				<div class="controls">
					<input style="width:90px;" name='px' maxlength="4" size='4' type="text" class="sub_typepx" value="<?php echo $v['px'];?>">&#12288;&#12288;(<font color='#ff0000'>*系统将按照升序排序，即：越大的排列序号分类，将会越后面显示！</font>)
				</div>
			</div>

			
			
				
			<div class="form-actions">
				<input class="btn btn-primary js-btn-edit-save-subtype" type="button" value="保 存" data-loading-text="保 存...">
				<input type="button" class="btn btn-defaults js-btn-quit-subtype-add" value="返回" >
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
</body>
<script>
$(function(){
	$(".toptype").change(function(){
		var change_topid = $(this).val();
		if(change_topid > 0) {
			$(".sub_typepic").show();
		} else {
			$(".sub_typepic").hide();
		}
	})
})

function reloads2() {
	//parent.layer.close(index);
	window.top.location.href='<?php echo dourl('subtype');?>';
}
	var is_close_tip1 = true;
	$(".js-btn-edit-save-subtype").live("click",function() {
		if(!is_close_tip1) return false;
		is_close_tip1 = false;
		
		
		var typename = $(".sub_typename").val();
		var sel_topid = $(".toptype").val();
		var type_pic = "";
		var type_px = $(".sub_typepx").val();
		var reg_int = /^[\d]{1,4}$/;
		
		if(sel_topid) {
			var list_size = $('.sub_typepic img').size();
			if(list_size) {
				var type_pic = $('.sub_typepic img').attr('src');
			} else {
				
			}
		}
		
		
		if(!reg_int.test(type_px)) {
			is_close_tip1 = true;
			layer.alert("排序值为 0到9999 之内的 正整数，请正确填写！");
			return;
		}
		if(sel_topid > 0) {
			if(!type_pic) {
				is_close_tip1 = true;
				layer.alert("内容未填写完整！再瞅瞅吧！");
				return;
			}
		} 
		
		if(!typename || !type_px) {
			is_close_tip1 = true;
			layer.alert("内容未填写完整！再瞅瞅吧！");
			return;
			
		}
		
		
		$.post(subtype_editsave_url,{"id":subtypeid,"typename":typename,"sel_topid":sel_topid,"type_pic":type_pic,"type_px":type_px,"is_ajax":"1"},function(obj){
			is_close_tip1 = true;
			
			if(obj.err_code == '0') {
				layer.msg("修改成功");
				setTimeout(reloads2(), 2000 )
				
				
			} else {
				layer.msg(obj.err_msg);
			}



		},
		'json'
		)
	})
</script>
</html>