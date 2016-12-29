<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Invest/projectRecommend')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
                    <input type="hidden" name="project_id" value="<?php echo $projectInfo['project_id']?>"/>
			<tr>
				<th width="80">是否推荐</th>
                                <?php if($projectInfo['is_recommend'] == 1){
                                    ?>
                                    <td><input type="radio" name="is_recommend" value="1"  checked="checked"/>&nbsp;是&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="is_recommend" />&nbsp;否</td>
                               <?php } else{
                                   ?>
                                   <td><input type="radio" name="is_recommend" value="1" />&nbsp;是&nbsp;&nbsp;&nbsp;<input type="radio" value="0" name="is_recommend"  checked="checked" />&nbsp;否</td>
                                   <?php
                               }?>
			</tr>
                        <tr>
                            <th width="80">推荐排序</th>
                            <td><input type="text" class="input fl" name="recommend_order" value="<?php echo $projectInfo['recommend_order']?>" size="20" placeholder="请输入排序" validate="maxlength:20,required:true"/></td>
			</tr>
		</table>
		<div class="btn hidden">
			<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
			<input type="reset" value="取消" class="button" />
		</div>
	</form>
<include file="Public:footer"/>