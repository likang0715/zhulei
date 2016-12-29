<include file="Public:header"/>
	<form id="myform" method="post" action="" frame="true" refresh="true">
        <input type="hidden" name="fid" value="{pigcms{$cat_id}"/>
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">分类标示</th>
				<td><input type="text" class="input fl" name="cat_key" value="" size="15" placeholder="请输入名称" validate="maxlength:30,required:true"/></td>
			</tr>
            <tr>
                <th width="80">分类名称</th>
                <td><input type="text" class="input fl" name="cat_name" value="" size="15" placeholder="请输入名称" validate="maxlength:30,required:true"/></td>
            </tr>
            <?php if(!empty($categoryList)){ ?>
            <tr>
                <th width="80">产品分类</th>
                <td>
                    <select class="select fl" name="product_category" validate="maxlength:30,required:true">
                        <?php foreach($categoryList as $key=>$value){ ?>
                        <option value="<?php echo $value['cat_id'];?>"><?php echo $value['cat_name'];?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <th width="80">最大开启数量</th>
                <td><input type="text" class="input fl" name="cat_num" value="5" size="15" placeholder="请输入名称" validate="maxlength:30,required:true"/></td>
            </tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>