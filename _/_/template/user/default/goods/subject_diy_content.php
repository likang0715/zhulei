<style>.ui-table th, .ui-table td{padding:9px 8px 7px 5px}</style>
<div>
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>

		</div>
	</div>
	<div class="ui-box">
		
			<table class="ui-table ui-table-list" style="padding:0px;">
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr><td colspan="3" align="left"><font color="#33A1FF">* 针对微信端专题特定含义专题关键词名称进行 <b>DIY</b> 设定</font></td></tr>
					<tr>
						<th width="35%" style="text-align:center">原名称</th>
						<th width="30%" style="text-align:center">标识</th>
						<th width="35%"  style="text-align:center"><a href="javascript:;" data-orderby="num">当前名称</a></th>
					</tr>
				</thead>
				<tbody class="js-list-body-region infolist">
					
						
						<tr class="subtype_ids contents" data-type="subject_type">
							<td width="35%" style="text-align:center">
								专题分类
							</td>
						
							<td style="text-align:center" >subject_type</td>
								
							<td  width="35%" style="text-align:center" data="<?php echo $content['id']?>" >
								<input type="text" name="subject_type" value="<?php echo $content['subject_type'];?>">
							</td>
						</tr>
						
						<tr class="subtype_ids contents" data-type="subject_display">
							<td width="35%" style="text-align:center">
								产品展示
							</td>
							<td style="text-align:center" >subject_display</td>
							
							<td width="35%" style="text-align:center" data="<?php echo $v1['id']?>" >
								<input type="text" name="subject_display" value="<?php echo $content['subject_display'];?>">
							</td>
						</tr>
						
						<tr>
							<td colspan="3" align="center">
								<div class="form-actions">
									<input class="btn btn-primary js-btn-save" type="button" value="保 存" data-loading-text="保 存...">
									<input type="button" class="btn btn-defaults js-btn-quit" value="刷新">
								</div>
							</td>
						</tr>
						<!-- 
							<tr><td colspan="3" align="center"><div class="js-list-empty-region">暂无分类哦！</div></td></tr>
						-->
				</tbody>
			</table>
		
			
	</div>
	<div class="js-list-footer-region ui-box">
		<div>
			<div class="pagenavi js-page-list"><?php echo $pages;?></div>
		</div>
	</div>
</div>
