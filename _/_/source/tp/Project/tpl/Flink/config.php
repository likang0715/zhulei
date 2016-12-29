
<include file="Public:header"/>

	<form id="myform" method="post" action="{pigcms{:U('Flink/config')}" enctype="multipart/form-data">
		
		<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Flink/index')}" >友情链接列表</a>|
					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Flink/add')}','添加友情链接',520,250,true,false,false,addbtn,'add',true);">添加友情链接</a>|
					<a href="{pigcms{:U('Flink/config')}" class="on" >首页底部配置</a>
				</ul>
		</div>

		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			
			<tr>
				<th width="180">底部菜单1(友情链接一级分类)</th>
				<td>
					<input type="text" class="input fl" name="menu_1" id="menu_1" value="{pigcms{$info.menu_1}"   tips="作为友情链接一级分类展示在首页底部">
				</td>
			</tr>

			<tr>
				<th width="180">底部菜单2(友情链接一级分类)</th>
				<td>
					<input type="text" class="input fl" name="menu_2" id="menu_2" value="{pigcms{$info.menu_2}"   tips="作为友情链接一级分类展示在首页底部">
				</td>
			</tr>

			<tr>
				<th width="180">底部菜单3(友情链接一级分类)</th>
				<td>
					<input type="text" class="input fl" name="menu_3" id="menu_3" value="{pigcms{$info.menu_3}"   tips="作为友情链接一级分类展示在首页底部">
				</td>
			</tr>

			<tr>
				<th width="180">底部菜单4(友情链接一级分类)</th>
				<td>
					<input type="text" class="input fl" name="menu_4" id="menu_4" value="{pigcms{$info.menu_4}"   tips="作为友情链接一级分类展示在首页底部">
				</td>
			</tr>

			<tr>
				<th width="180">右边导航1</th>
				<td>
					<input type="text" class="input fl" name="nav_1" id="nav_1" value="{pigcms{$info.nav_1}"   tips="首页底部右边导航设置">
				</td>
			</tr>

			<tr>
				<th width="80">右边导航1(图标 34 * 34)</th>
				<td><input type="file" class="input fl" name="nav_1_pic" style="width:200px;" placeholder="请上传图标" /></td>
			</tr>

		<if condition="isset($info[nav_1_pic])">
			<tr>
				<th width="80">导航1现图</th>
				<td><img src="{pigcms{:getAttachmentUrl($info[nav_1_pic])}" style="width:34px;height:34px;" class="view_msg"/>&nbsp;&nbsp;<a style="color:red;text-decoration: none;cursor: pointer;" id="js_nav_1_pic" data-id="<?php echo $info['nav_1_pic']; ?>" >删除</a></td>
			</tr>
		</if>

			<tr>
				<th width="180">右边导航2</th>
				<td>
					<input type="text" class="input fl" name="nav_2" id="nav_2" value="{pigcms{$info.nav_2}"   tips="首页底部右边导航设置">
				</td>
			</tr>

			<tr>
				<th width="80">右边导航2(图标 34 * 34)</th>
				<td><input type="file" class="input fl" name="nav_2_pic" style="width:200px;" placeholder="请上传图标" /></td>
			</tr>
		<if condition="isset($info[nav_2_pic])">
			<tr>
				<th width="80">导航2现图</th>
				<td><img src="{pigcms{:getAttachmentUrl($info[nav_2_pic])}" style="width:34px;height:34px;" class="view_msg"/>&nbsp;&nbsp;<a style="color:red;text-decoration: none;cursor: pointer;" id="js_nav_2_pic" data-id="<?php echo $info['nav_2_pic']; ?>" >删除</a></td>
			</tr>
		</if>

			<tr>
				<th width="180">右边导航3</th>
				<td>
					<input type="text" class="input fl" name="nav_3" id="nav_3" value="{pigcms{$info.nav_3}"   tips="首页底部右边导航设置">
				</td>
			</tr>

			<tr>
				<th width="80">右边导航3(图标 34 * 34)</th>
				<td><input type="file" class="input fl" name="nav_3_pic" style="width:200px;" placeholder="请上传图标" /></td>
			</tr>
		<if condition="isset($info[nav_3_pic])">
			<tr>
				<th width="80">导航3现图</th>
				<td><img src="{pigcms{:getAttachmentUrl($info[nav_3_pic])}" style="width:34px;height:34px;" class="view_msg"/>&nbsp;&nbsp;<a style="color:red;text-decoration: none;cursor: pointer;" id="js_nav_3_pic" data-id="<?php echo $info['nav_3_pic']; ?>" >删除</a></td>
			</tr>
		</if>
		<tr>
			<th width="180">右下角广告位名称</th>
			<td>
				<input type="text" class="input fl" name="wx_title" id="wx_title" value="{pigcms{$info.wx_title}"  validate="" tips="右下角广告位名称">
			</td>
		</tr>
		<tr>
			<th width="180">右下角广告位链接</th>
			<td>
				<input style="width: 250px;" type="text" class="input fl" name="wx_link" id="wx_link" value="{pigcms{$info.wx_link}"  validate="" tips="右下角广告位链接url">
			</td>
		</tr>
		<tr>
			<th width="80">右下角广告位(图片 115 * 115)</th>
			<td><input type="file" class="input fl" name="wx" style="width:200px;" placeholder="请上传图片" /></td>
		</tr>
		<if condition="isset($info[wx])">
			<tr>
				<th width="80">右下角广告位现图</th>
				<td><img src="{pigcms{:getAttachmentUrl($info[wx])}" style="width:115px;height:115px;" class="view_msg"/>&nbsp;&nbsp;<a style="color:red;text-decoration: none;cursor: pointer;" id="js_wx" data-id="<?php echo $info['wx']; ?>" >删除</a></td>
			</tr>
		</if>
		
		
		</table>

		<div class="btn" style="margin-top:20px;">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>

		
	</form>

<include file="Public:footer"/>
<script>
	
$("#myform").validate({
	event:"blur",
	errorElement: "em",
	errorPlacement: function(error,element){
		error.appendTo(element.parent("td"));
	},
	success: function(label){
		label.addClass("success");
	},
	submitHandler:function(form){
		if($('.ke-container').size() > 0){
			kind_editor.sync();
		}
		if($(form).attr('frame') == 'true' || $(form).attr('refresh') == 'true'){
			$.post($(form).attr('action'),$(form).serialize(),function(result){
				if(result.status == 1){
					window.top.msg(1,result.info,true);
					if($(form).attr('refresh') == 'true'){
						window.top.main_refresh();
					}
					window.top.closeiframe();
				}else{
					window.top.msg(0,result.info,true);
				}
			});
			return false;
		}else{
			//window.top.msg(2,'表单提交中1，请稍等...',true,360);
			form.submit();
		}
	} 
});


$(function() {
	$('#js_wx,#js_nav_3_pic,#js_nav_2_pic,#js_nav_1_pic').click(function(){
		  var val = $(this).data('id');
		  var key = $(this).attr('id');
		  key = key.replace(/js_/, '');

		  $.post(
		  		"<?php echo U('Flink/delImg'); ?>",
		  		{'key' : key , 'val': val},
		  		function (data) {
		  			window.top.msg(1,"删除成功",true,'3');window.top.main_refresh();window.top.closeiframe();
		  		}
		  	);
	})
})

</script>
