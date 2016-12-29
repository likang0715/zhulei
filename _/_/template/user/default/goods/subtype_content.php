<style>.ui-table th, .ui-table td{padding:9px 8px 7px 5px}</style>
<div>
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<div style="position:relative;">
				<a href="javascript:" tips="no_click" id="subtype_create" class="ui-btn ui-btn-primary js-create-template">新建分类</a>
				<a href="javscript:void(0)" tips="no_click" class="subtype_px_button ui-btn ui-btn-primary js-create-template">批量排序</a>
			</div>
		</div>
	</div>
	<div class="ui-box">
		
			<table class="ui-table ui-table-list" style="padding:0px;">
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr>
						<th width="25%" style="text-align:left">分类名称</th>
						<th width="15%" style="text-align:center"><a href="javascript:;" data-orderby="created_time">图标<span class="orderby-arrow desc"></span></a></th>
						<th width="15%"  style="text-align:center"><a href="javascript:;" data-orderby="num">排列序号</a></th>
						
						<th width="15%"  style="text-align:center"><a href="javascript:;" data-orderby="num">当前状态</a></th>
						<th width="30%" style="text-align:center">操作</th>
					</tr>
				</thead>
				<tbody class="js-list-body-region infolist">
					<?php if(count($subtype_list)){ ?>
						<?php foreach($subtype_list as $k=>$v) {?>
						<tr class="subtype_ids" data_subtype_id="<?php echo $v['id']?>" data_top = "<?php echo $v['id']?>">
							<td style="text-align:left">
								<a href="javascript:void(0)" tips="no_click" class="new-window"><?php if($v['topid']) {?>&nbsp;|—— <?php }?><?php echo $v['typename'];?></a>
							</td>
							<td style="text-align:center"><?php if($v['topid']>0) {?><?php }else{?>无需图片<?php }?></td>

							<td style="text-align:center">
								<input class="input-mini js-input-num" type="text" name="px" min="0" maxlength="4" value="<?php echo $v['px'];?>"/>
							</td>
							
							<td style="text-align:center" data="<?php echo $v1['id']?>" class="tr_status tr_status_<?php echo $v['id']?>">
								<?php if($v['status'] == 1) {?>
									<b>已开启</b>
								<?php } else {?>
									<b><font color='#f00'>已关闭</font></b>
								<?php }?>
							</td>
							
							<td style="text-align:center;">

								<table class="caozuo" style="width:100%;text-align:center">
										<tr data="<?php echo $v['id'];?>" datatype="fa">
											<?php if($v['topid'] != 0) {?>
											<td class="padding-left3" style="width:24%">
												&nbsp;	
											</td>
											<?php }?>
											<td style="width:24%">&nbsp;</td>
											<td class="padding-left3" style="width:24%">
												<?php if($v['status'] == 1) {?>
													<a hidefocus="true" title="关闭专题分类" href="javascript:void(0)" tips="no_click"    class="js_subtype_disabled setedit2">使失效</a>
												<?php }else {?>
													<a hidefocus="true" title="启用专题分类" href="javascript:void(0)" tips="no_click"   class="js_subtype_able setedit2">使开启</a>
												<?php }?>
											</td>
											
											<?php if($v['topid'] == 0) {?>
											<td class="padding-left3" style="display:none;width:24%">
												<a hidefocus="true" title="关于专题分类" href="javascript:void()" tips="no_click"  data="<?php echo $v['id'];?>"  class="subtype_create setedit2">添加分类</a>
											</td>
											
											<?php }?>
											
											<td class="padding-left3" style="width:24%">
												<a hidefocus="true" title="编辑专题分类" data="<?php echo $v['id'];?>"  href="javascript:void(0)" tips="no_click"  class="subtype_edit setedit2">编辑</a>
											</td>
											<td class="padding-left3" style="width:24%">
												<a hidefocus="true" title="删除专题分类" href="javascript:"  tips="no_click"  data="<?php echo $v['id'];?>"   class="js-subtype-delete setedit2">删除</a>
											</td>
										</tr>
								</table>
							</td>
						</tr>
						
						<!-- son -->
						<?php if(count($v['childArray']) > 0) {?>
							<?php foreach($v['childArray'] as $k1=>$v1) {?>
								<tr class="subtype_ids" data_top = "<?php echo $v1['topid']?>" data_subtype_id="<?php echo $v1['id']?>">
									<td style="text-align:left">
										<a href="javascript:void(0)" tips="no_click" class="new-window"><?php if($v1['topid']) {?>&nbsp;|—— <?php }?><?php echo $v1['typename'];?></a>
									</td>
									<td style="text-align:center">
									
										<img width="25px" height="" src="<?php echo $v1['typepic']?>">
									</td>
		
									<td style="text-align:center">
										<input class="input-mini js-input-num"  name="px" type="text" min="0" maxlength="4" value="<?php echo $v1['px'];?>"/>
									</td>
									
									<td style="text-align:center" data="<?php echo $v1['topid']?>" class="tr_status tr_status_<?php echo $v1['topid']?>">
										<?php if($v1['status'] == 1) {?>
											<b>已开启</b>
										<?php } else {?>
											<b><font color='#f00'>已关闭</font></b>
										<?php }?>
									</td>
									
									<td style="text-align:center;">
									<!--  
										<?php if($home_page['page_id'] == $value['page_id']){ ?>
											<a href="javascript:void(0);" class="js-copy hover-show">复制</a>
											<span class="hover-show">-</span>
											<a href="#edit/<?php echo $value['page_id'];?>">编辑</a>
											<span>-</span>
											<a href="javascript:void(0);" class="js-copy-link" copy-link="<?php echo $config['wap_site_url'];?>/page.php?id=<?php echo $value['page_id'];?>">链接</a>
											<span>-</span>
											<span class="c-gray">店铺主页</span>
										<?php }else{ ?>
											<a href="javascript:void(0);" class="js-copy hover-show">复制</a>
											<span class="hover-show">-</span>
											<a href="#edit/<?php echo $value['page_id'];?>">编辑</a>
											<span>-</span>
											<a href="javascript:void(0);" class="js-delete">删除</a>
											<span>-</span>
											<a href="javascript:void(0);" class="js-copy-link" copy-link="<?php echo $config['wap_site_url'];?>/page.php?id=<?php echo $value['page_id'];?>">链接</a>
											<span>-</span>
											<a href="javascript:void(0);" class="js-set-as-homepage">设为主页</a>
										<?php } ?>
										-->
										
										<table class="caozuo" style="width:100%;text-align:center">
										<tr data="<?php echo $v1['id'];?>">
											<td class="padding-left3" style="width:24%">
												&nbsp;	
											</td>
											<td class="padding-left3" style="width:24%">
												<?php if($v1['status'] == 1) {?>
													<a hidefocus="true" title="关闭专题分类" href="javascript:void(0)" tips="no_click"    class="js_subtype_disabled setedit2">使失效</a>
												<?php }else {?>
													<a hidefocus="true" title="启用专题分类" href="javascript:void(0)" tips="no_click"   class="js_subtype_able setedit2">使开启</a>
												<?php }?>
											</td>
											<td class="padding-left3" style="width:24%">
												<a hidefocus="true" title="编辑专题分类" data="<?php echo $v1['id'];?>"  href="javascript:void(0)" tips="no_click"  class="subtype_edit  setedit2">编辑</a>
											</td>
											<td class="padding-left3" style="width:24%">
												<a hidefocus="true" title="删除专题分类" href="javascript:" data="<?php echo $v1['id'];?>"  tips="no_click"   class="js-subtype-delete setedit2">删除</a>
											</td>
										</tr>
										</table>
									</td>
								</tr>
							<?php }?>
						<?php }?>
					<?php }?>	
					<?php } else {?>
						<tr><td colspan="5" align="center"><div class="js-list-empty-region">暂无分类哦！</div></td></tr>
	 			<?php }?>
					
				</tbody>
			</table>
		
			
	</div>
	<div class="js-list-footer-region ui-box">
		<div>
			<div class="pagenavi js-page-list"><?php echo $pages;?></div>
		</div>
	</div>
</div>
