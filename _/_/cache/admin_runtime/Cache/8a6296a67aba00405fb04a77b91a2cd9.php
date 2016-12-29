<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html"><head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo C('DEFAULT_CHARSET');?>" />
		<title>网站后台管理 Powered by pigcms.com</title>
		<script type="text/javascript">
			<!--if(self==top){window.top.location.href="<?php echo U('Index/index');?>";}-->
			var kind_editor=null,static_public="<?php echo ($static_public); ?>",static_path="<?php echo ($static_path); ?>",system_index="<?php echo U('Index/index');?>",choose_province="<?php echo U('Area/ajax_province');?>",choose_city="<?php echo U('Area/ajax_city');?>",choose_area="<?php echo U('Area/ajax_area');?>",choose_circle="<?php echo U('Area/ajax_circle');?>",choose_map="<?php echo U('Map/frame_map');?>",get_firstword="<?php echo U('Words/get_firstword');?>",frame_show=<?php if($_GET['frame_show']): ?>true<?php else: ?>false<?php endif; ?>;
		</script>
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/style.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo ($static_path); ?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo C('JQUERY_FILE');?>"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.validate.js"></script>
		<script type="text/javascript" src="/static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_public); ?>js/jquery.colorpicker.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo ($static_path); ?>js/date.js"></script>
			<?php if($withdrawal_count > 0): ?><script type="text/javascript">
					$(function(){
						$('#nav_4 > dd > #leftmenu_Order_withdraw', parent.document).html('提现记录 <label style="color:red">(' + <?php echo ($withdrawal_count); ?> + ')</label>')
					})
				</script><?php endif; ?>
			<?php if($unprocessed > 0): ?><script type="text/javascript">
					$(function(){
						if ($('#leftmenu_Credit_returnRecord', parent.document).length > 0) {
							var menu_html = $('#leftmenu_Credit_returnRecord', parent.document).html();
							menu_html = menu_html.split('(')[0];
							menu_html += ' <label style="color:red">(<?php echo ($unprocessed); ?>)</label>';
							$('#leftmenu_Credit_returnRecord', parent.document).html(menu_html);
						}
					})
				</script><?php endif; ?>
		</head>
		<body width="100%" 
		<?php if($bg_color): ?>style="background:<?php echo ($bg_color); ?>;"<?php endif; ?>
> 
<style type="text/css">
#cate_menu .select2-search-choice { padding: 3px 18px 3px 5px; margin: 3px 0 3px 5px; position: relative; line-height: 13px; color: #333; border: 1px solid #aaaaaa; border-radius: 3px; -webkit-box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05); box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05); background-clip: padding-box; -webkit-touch-callout: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-color: #e4e4e4; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeeeee', endColorstr='#f4f4f4', GradientType=0);
background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), color-stop(100%, #eee)); background-image: -webkit-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); background-image: -moz-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); background-image: -webkit-gradient(linear, left top, left bottom, from(top), color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), to(#eee)); background-image: linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); font-size: 12px; }
.select2-search-choice-close { display: block; width: 12px; height: 13px; position: absolute; right: 3px; top: 4px; font-size: 1px; outline: none; background: url(./source/tp/Project/tpl/Static/css/img/select2.png) right top no-repeat; position: absolute }
.select2-container-multi .select2-search-choice-close { right: 3px; }
#cate_menu span { cursor: pointer }
<!--
#cate_menu span { float: left; background: red; color: #fff; margin-left: 5px; }
-->

.cate_menu .select2-search-choice { padding: 3px 18px 3px 5px; margin: 3px 0 3px 5px; position: relative; line-height: 13px; color: #333; border: 1px solid #aaaaaa; border-radius: 3px; -webkit-box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05); box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05); background-clip: padding-box; -webkit-touch-callout: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-color: #e4e4e4; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#eeeeee', endColorstr='#f4f4f4', GradientType=0);
background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), color-stop(100%, #eee)); background-image: -webkit-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); background-image: -moz-linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); background-image: -webkit-gradient(linear, left top, left bottom, from(top), color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), to(#eee)); background-image: linear-gradient(top, #f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%); font-size: 12px; }
.select2-search-choice-close { display: block; width: 12px; height: 13px; position: absolute; right: 3px; top: 4px; font-size: 1px; outline: none; background: url(./source/tp/Project/tpl/Static/css/img/select2.png) right top no-repeat; position: absolute }
.select2-container-multi .select2-search-choice-close { right: 3px; }
.cate_menu span { cursor: pointer }
<!--
.cate_menu span { float: left; background: red; color: #fff; margin-left: 5px; }
-->
</style>

<form id="myform" method="post" action="<?php echo U('Physical/chcate_edit');?>" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
      <tr>
      <th width="80">分类名称</th>
      <td><input type="text" class="input fl" name="name" id="name" size="25" value="<?php echo ($category["cat_name"]); ?>" placeholder="" validate="maxlength:20,required:true" tips=""/></td>
    </tr>
    <?php if($category['cat_pic']): ?><tr>
        <th width="80">分类现图</th>
        <td><img src="<?php echo ($category["cat_pic"]); ?>" style="width:60px;height:60px;" class="view_msg"/></td>
      </tr><?php endif; ?>
  
    <tr>
      <th width="80">分类图片</th>
      <td><input type="file" class="input fl" name="pic" style="width:175px;" placeholder="请上传图片" tips="不修改请不上传！上传新图片，老图片会被自动删除！"/></td>
    </tr>
       
    <tr>
      <th width="80">分类排序</th>
      <td><input type="text" class="input fl" name="cat_sort" value="<?php echo ($category["cat_sort"]); ?>" size="10" placeholder="分类排序" validate="maxlength:6,number:true" tips="默认添加id排序！手动排序数值越小，排序越前。"/></td>
    </tr>
    
    <tr>
      <th width="80">分类状态</th>
      <td><span class="cb-enable">
        <label class="cb-enable <?php if($category["cat_status"] == 1): ?>selected<?php endif; ?>"><span>启用</span><input type="radio" name="status" value="1" 
          <?php if($category['cat_status'] == 1): ?>checked="true"<?php endif; ?>
          /></label>
        </span> <span class="cb-disable">
        <label class="cb-disable <?php if($category["cat_status"] == 0): ?>selected<?php endif; ?>"><span>禁用</span><input type="radio" name="status" value="0" 
          <?php if($category['cat_status'] == 0): ?>checked="true"<?php endif; ?>
          /></label>
        </span></td>
    </tr>
   
  </table>
  <div class="btn hidden">
    <input type="hidden" name="cat_id" value="<?php echo ($category["cat_id"]); ?>" />
    <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
    <input type="reset" value="取消" class="button" />
  </div>
</form>
 
	</body>
</html>