
<link rel="stylesheet" type="text/css" href="http://demo.pigcms.cn/tpl/User/default/common/css/style-1.css?id=103" />
<link rel="stylesheet" type="text/css" href="http://demo.pigcms.cn/tpl/User/default/common/css/style_2_common.css?BPm" />
<script src="http://demo.pigcms.cn/tpl/static/artDialog/jquery.artDialog.js?skin=default"></script>
<script src="http://demo.pigcms.cn//tpl/static/artDialog/plugins/iframeTools.js"></script>
<style>
a.a_upload,a.a_choose{border:1px solid #3d810c;box-shadow:0 1px #CCCCCC;-moz-box-shadow:0 1px #CCCCCC;-webkit-box-shadow:0 1px #CCCCCC;cursor:pointer;display:inline-block;text-align:center;vertical-align:bottom;overflow:visible;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;vertical-align:middle;background-color:#f1f1f1;background-image: -webkit-linear-gradient(bottom, #CCC 0%, #E5E5E5 3%, #FFF 97%, #FFF 100%); background-image: -moz-linear-gradient(bottom, #CCC 0%, #E5E5E5 3%, #FFF 97%, #FFF 100%); background-image: -ms-linear-gradient(bottom, #CCC 0%, #E5E5E5 3%, #FFF 97%, #FFF 100%); color:#000;border:1px solid #AAA;padding:2px 8px 2px 8px;text-shadow: 0 1px #FFFFFF;font-size: 14px;line-height: 1.5;
}

.pages{padding:3px;margin:3px;text-align:center;}
.pages a{border:#eee 1px solid;padding:2px 5px;margin:2px;color:#036cb4;text-decoration:none;}
.pages a:hover{border:#999 1px solid;color:#666;}
.pages a:active{border:#999 1px solid;color:#666;}
.pages .current{border:#036cb4 1px solid;padding:2px 5px;font-weight:bold;margin:2px;color:#fff;background-color:#036cb4;}
.pages .disabled{border:#eee 1px solid;padding:2px 5px;margin:2px;color:#ddd;}
.tableContent {
	background:none !important;
	clear:both;
}
		.tableContent .content {
		border-left: 0;
		padding: 5px 10px;
		background-color: #FFFFFF;
		width:820px;
		min-height: inherit;
	}
	.tableContent .content .px {
		width:300px !important;
	}
	.tableContent .content .bgfc {
	padding:5px;
}
.app{width:810px;}
</style>
<script>
	$(function(){
		$("form").submit(function () {
			var keyword = $("#keyword").val();
			var wxpic = $("#wxpic").val();
			var name = $("#name").val();
			var price = $("#price").val();
			var type = $("#type").val();
			var logopic = $("#logopic").val();
			var fistpic = $("#fistpic").val();
			if(keyword == ''){
				alert('请填写关键字');
				buterror("#keyword");
				return false;
			}else if(wxpic == ''){
				alert('请添加活动图片');
				buterror("#wxpic");
				return false;
			}else if(name == ''){
				alert('请填写活动名称');
				buterror("#name");
				return false;
			}else if(price == '' || price == 0){
				alert('请填写商品价格');
				buterror("#price");
				return false;
			}else if(price < 2){
				alert('价格至少为2元');
				buterror("#price");
				return false;
			}else if(type == 0){
				alert('请选择商品分类');
				buterror("#type");
				return false;
			}else if(logopic == ''){
				alert('请添加商品logo图片');
				buterror("#logopic");
				return false;
			}else if(fistpic == ''){
				alert('请添加商品展示图片1');
				buterror("#fistpic");
				return false;
			}else{
				return true;
			}
		});
	});
	function buterror(id){
		$("html,body").animate({scrollTop: $("#ooo").offset().top}, 500);
		$(id).css("border","2px solid red");
		$(id).focus(function(){
			$(id).css("border","1px solid");
			$(id).css("border-color","#848484 #E0E0E0 #E0E0E0 #848484");
		})
	}
</script>
<div class="tableContent">
<form class="form" method="post"   action="/user.php?c=unitary&a=doadd" enctype="multipart/form-data" >
<link rel="stylesheet" type="text/css" href="http://demo.pigcms.cn//tpl/static/unitary/css/cymain.css" />
<div class="content">
	<div class="cLineB" id="ooo">
		<h4 class="left">新增一个活动商品</h4>
		<a href="{pigcms::U('Unitary/index',array('token'=>$token))}"  class="right btnGreen" >返回</a>
	</div>
	
	<div class="msgWrap bgfc">
		<table class="userinfoArea" style=" margin:0;" border="0" cellSpacing="0" cellPadding="0" width="100%">
			<tbody>
				<tr>
					<if condition="$_SESSION['is_syn'] eq 0">
					<th valign="top"><span class="red">*</span>关键词：</th>
					<td>
						<input type="input" class="px" id="keyword" value="" name="keyword" style="width:400px" />
						<br/>
						<span class="red">只能写一个关键词</span>，用户输入此关键词将会触发此活动。
					</td>
					<else />
						<th valign="top"></th>
						<td><input type="hidden" class="px" id="keyword" value="<?php echo $_SESSION['is_syn'];?>" name="keyword" style="width:400px" /></td>
					</if>
					<td rowspan="999" valign="top">
						<div style="margin-left:20px">
							<img id="wxpic_src" src="http://demo.pigcms.cn//tpl/static/unitary/images/wxnewspic.jpg" width="373px" >
							<br/>
							<input class="px"  name="wxpic" value="http://demo.pigcms.cn//tpl/static/unitary/images/wxnewspic.jpg" id="wxpic" style="width:363px;"  />
							<script src="http://demo.pigcms.cn//tpl/static/upyun.js"></script><a href="###" onclick="upyunPicUpload('wxpic',900,500,'{pigcms:$token}')" class="a_upload">上传</a> <a href="###" onclick="viewImg('wxpic')">预览</a>&nbsp;<span class="red"><strong>*</strong></span>微信图文信息图片，推荐尺寸：900*500
						</div>
					</td>
				</tr>
				<tr>
					<th valign="top"><span class="red">*</span>活动名称：</th>
					<td>
						<input type="input" class="px" id="name" value="" name="name" style="width:400px" />
						<br/>
						请不要多于50字!
					</td>
				</tr>
				<tr>
					<th valign="top">微信中图文信息说明：</th>
					<td>
						<textarea  class="px" id="wxinfo" name="wxinfo"  style="width:400px; height:125px" ></textarea>
						<br/>
						换行请输入
						&lt;br&gt;
					</td>
				</tr>
				<tr>
					<th valign="top"><span class="red">*</span>商品价格：</th>
					<td>
						&#165;<input type="input" class="px" id="price" value="" name="price" style="width:50px" />元
						<br/>
						不能有小数，活动开始后不能修改
					</td>
				</tr>
				<tr>
					<th valign="top"><span class="red">*</span>商品分类：</th>
					<td>
						<select name="type" id="type">
							<option value="0">--请选择分类--</option>
							<option value="1">手机数码</option>
							<option value="2">电脑办公</option>
							<option value="3">家用电器</option>
							<option value="4">化妆个护</option>
							<option value="5">钟表首饰</option>
							<option value="9999">其他商品</option>
						</select>
					</td>
				</tr>
				<tr>
					<th valign="top"><span class="red">*</span>商品logo图片：</th>
					<td colspan="2">
						<input type="input" class="px" id="logopic"  name="logopic" value=""  style="width:250px"/>
						<script src="http://demo.pigcms.cn//tpl/static/upyun.js"></script><a href="###" onclick="upyunPicUpload('logopic',400,400,'{pigcms:$token}')" class="a_upload">上传</a> <a href="###" onclick="viewImg('logopic')">预览</a><br/><span class="red"><strong>*</strong></span>推荐尺寸：400*400
					</td>
				</tr>
				<tr>
					<th valign="top"><span class="red">*</span>商品展示图片1：</th>
					<td>
						<input type="input" class="px" id="fistpic"  name="fistpic" value=""  style="width:250px"/>
						<script src="http://demo.pigcms.cn//tpl/static/upyun.js"></script><a href="###" onclick="upyunPicUpload('fistpic',900,500,'{pigcms:$token}')" class="a_upload">上传</a> <a href="###" onclick="viewImg('fistpic')">预览</a><br/><span class="red"><strong>*</strong></span>推荐尺寸：900*500
					</td>
				</tr>
				<tr>
					<th valign="top">商品展示图片2：</th>
					<td>
						<input type="input" class="px" id="secondpic"  name="secondpic" value=""  style="width:250px"/>
						<script src="http://demo.pigcms.cn//tpl/static/upyun.js"></script><a href="###" onclick="upyunPicUpload('secondpic',900,500,'{pigcms:$token}')" class="a_upload">上传</a> <a href="###" onclick="viewImg('secondpic')">预览</a>
					</td>
				</tr>
				<tr>
					<th valign="top">商品展示图片3：</th>
					<td>
						<input type="input" class="px" id="thirdpic"  name="thirdpic" value=""  style="width:250px"/>
						<script src="http://demo.pigcms.cn//tpl/static/upyun.js"></script><a href="###" onclick="upyunPicUpload('thirdpic',900,500,'{pigcms:$token}')" class="a_upload">上传</a> <a href="###" onclick="viewImg('thirdpic')">预览</a>
					</td>
				</tr>
				<tr>
					<th valign="top">商品展示图片4：</th>
					<td>
						<input type="input" class="px" id="fourpic"  name="fourpic" value=""  style="width:250px"/>
						<script src="http://demo.pigcms.cn//tpl/static/upyun.js"></script><a href="###" onclick="upyunPicUpload('fourpic',900,500,'{pigcms:$token}')" class="a_upload">上传</a> <a href="###" onclick="viewImg('fourpic')">预览</a>
					</td>
				</tr>
				<tr>
					<th valign="top">商品展示图片5：</th>
					<td>
						<input type="input" class="px" id="fivepic"  name="fivepic" value=""  style="width:250px"/>
						<script src="http://demo.pigcms.cn//tpl/static/upyun.js"></script><a href="###" onclick="upyunPicUpload('fivepic',900,500,'{pigcms:$token}')" class="a_upload">上传</a> <a href="###" onclick="viewImg('fivepic')">预览</a>
					</td>
				</tr>
				<tr>
					<th valign="top">商品展示图片6：</th>
					<td>
						<input type="input" class="px" id="sixpic"  name="sixpic" value=""  style="width:250px"/>
						<script src="http://demo.pigcms.cn//tpl/static/upyun.js"></script><a href="###" onclick="upyunPicUpload('sixpic',900,500,'{pigcms:$token}')" class="a_upload">上传</a> <a href="###" onclick="viewImg('sixpic')">预览</a>
					</td>
				</tr>
				<tr>
					<th valign="top">结束倒计时：</th>
					<td> 
						<input type="input" class="px" id="min" value="5" name="min" style="width:30px" /> 分钟 
						<br/>
						人数足够结束以后倒计时展示结果的时间，不填则不倒计时直接显示结果
					</td>
				</tr>
				<!-- <tr>
					<th valign="top">非关注用户：</th>
					<td><input class="radio" type="radio" name="wxregister" value="1" > 关注  <input class="radio" type="radio" name="wxregister" value="0"  checked> 注册 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;（非关注用户参加活动的处理方式）
				</td>
				</tr>
				<tr>
					<th valign="top">无粉丝信息：</th>
					<td><input class="radio" type="radio" name="register" value="1" > 注册  <input class="radio" type="radio" name="register" value="0"  checked> 不注册 &nbsp;&nbsp;&nbsp;（没有粉丝信息参加活动的处理方式）</td>
				</tr> -->
				<input class="" type="hidden" name="state" value="0">
				<tr>
					<th>&nbsp;</th>
					<td><button type="submit" class="btnGreen" >保存</button>　<a href="{pigcms::U('Unitary/index',array('token'=>$token))}"  class="btnGray vm">取消</a></td>
				</tr>
			</tbody>
		</table>
	</div>
	
</div>
</form>
</div>
