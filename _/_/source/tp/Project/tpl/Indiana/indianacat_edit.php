<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Indiana/indianacat_edit',array('cat_id'=>$activity_category_detail['cat_id']))}" frame="true" refresh="true">
		<input type="hidden" name="cat_id" value="{pigcms{$activity_category_detail.cat_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">分类名称</th>
				<td><input type="text" class="input fl" name="cat_name" value="{pigcms{$activity_category_detail.cat_name}" size="15" placeholder="请输入名称" validate="maxlength:30,required:true"/></td>
			</tr>
            <?php if(!empty($categoryList) && $activity_category_detail['product_category']!=0){ ?>
                <tr>
                    <th width="80">产品分类</th>
                    <td>
                        <select class="select fl" name="product_category" validate="maxlength:30,required:true">
                            <?php foreach($categoryList as $key=>$value){ ?>
                                <option value="<?php echo $value['cat_id'];?>" <?php if($value['cat_id']==$activity_category_detail['product_category']){echo 'selected="selected"';}?>><?php echo $value['cat_name'];?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th width="80">最大启用数</th>
                <td><input type="text" class="input fl" name="cat_num" value="{pigcms{$activity_category_detail.cat_num}" size="15" placeholder="请输入名称" validate="maxlength:30,required:true"/></td>
            </tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>