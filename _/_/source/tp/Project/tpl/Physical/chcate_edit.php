<include file="Public:header"/>
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

<form id="myform" method="post" action="{pigcms{:U('Physical/chcate_edit')}" enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
      <tr>
      <th width="80">分类名称</th>
      <td><input type="text" class="input fl" name="name" id="name" size="25" value="{pigcms{$category.cat_name}" placeholder="" validate="maxlength:20,required:true" tips=""/></td>
    </tr>
    <if condition="$category['cat_pic']">
      <tr>
        <th width="80">分类现图</th>
        <td><img src="{pigcms{$category.cat_pic}" style="width:60px;height:60px;" class="view_msg"/></td>
      </tr>
    </if>
  
    <tr>
      <th width="80">分类图片</th>
      <td><input type="file" class="input fl" name="pic" style="width:175px;" placeholder="请上传图片" tips="不修改请不上传！上传新图片，老图片会被自动删除！"/></td>
    </tr>
       
    <tr>
      <th width="80">分类排序</th>
      <td><input type="text" class="input fl" name="cat_sort" value="{pigcms{$category.cat_sort}" size="10" placeholder="分类排序" validate="maxlength:6,number:true" tips="默认添加id排序！手动排序数值越小，排序越前。"/></td>
    </tr>
    
    <tr>
      <th width="80">分类状态</th>
      <td><span class="cb-enable">
        <label class="cb-enable <if condition='$category.cat_status eq 1'>selected</if>"><span>启用</span><input type="radio" name="status" value="1" 
          <if condition="$category['cat_status'] eq 1">checked="true"</if>
          /></label>
        </span> <span class="cb-disable">
        <label class="cb-disable <if condition='$category.cat_status eq 0'>selected</if>"><span>禁用</span><input type="radio" name="status" value="0" 
          <if condition="$category['cat_status'] eq 0">checked="true"</if>
          /></label>
        </span></td>
    </tr>
   
  </table>
  <div class="btn hidden">
    <input type="hidden" name="cat_id" value="{pigcms{$category.cat_id}" />
    <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
    <input type="reset" value="取消" class="button" />
  </div>
</form>
 
<include file="Public:footer"/>