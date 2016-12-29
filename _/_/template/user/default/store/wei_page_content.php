<div>
	<div class="js-list-filter-region clearfix ui-box" style="position:relative;">
		<div>
			<div class="homepage-box clearfix">
				<div class="logo ">
					<img src="<?php echo $store_session['logo']?>" alt="<?php echo $store_session['name'];?>"/>
				</div>
				<div class="homepage-meta">
					<h3 class="homepage-title"><strong>店铺主页</strong></h3>
					<div class="homepage-create-time">创建时间：<?php echo date('Y-m-d H:i:s',$store_session['date_added']);?></div>
				</div>
				<div class="homepage-operate">
					<a href="#edit/<?php echo $home_page['page_id'];?>">编辑</a>
					<a href="javascript:;" class="js-copy-link" copy-link="<?php echo $config['wap_site_url'];?>/home.php?id=<?php echo $store_session['store_id'];?>">链接</a>
					<a class="js-help-notes" href="javascript:;">二维码</a>
					<span class="js-notes-cont hide">
						<p>微信扫一扫访问：</p>
						<p class="team-code"><img  src="<?php echo  option('config.site_url')."/source/qrcode.php?type=home&id=".$store_session['store_id'];?>" alt="店铺主页二维码" /></p>
						<p><a href="<?php echo  option('config.site_url')."/source/qrcode.php?type=home&id=".$store_session['store_id'];?>" download="" target="_blank">下载二维码</a></p>
					</span>
				</div>
			</div>
			<div style="position:relative;">
				<a href="javascript:;" onclick="$('.page-template,.body_dark').show();" class="ui-btn ui-btn-primary js-create-template">新建微页面</a>
				<!--<a class="ui-btn ui-btn-primary js-create-template" id="new_page">新建微页面</a>-->
			</div>
			<!-- 选择模板弹窗 古德20160617-->
			<div class="page-template">
				<div class="template-header modal-header">
					<a class="close" onclick="$('.page-template,.body_dark').hide();">×</a>
					<h3 class="title">选择页面模板</h3>
				</div>
				<ul class="template-filter">
					<li class="active">
						<a href="javascript:;" class="js-filter" data-type="all">所有模板</a>
					</li>
					<!--yfz@20160620 分页得到官方微页面的分类列表-->
					<?php if($catlist){ ?>
					<?php foreach($catlist as $r){ ?>
					<li class="">
						<a href="javascript:;" class="js-filter" data-type="<?php echo $r['cat_id'];?>"><?php echo $r['cat_name'];?></a>
					</li>
					<?php } ?>
					<?php } ?>
				</ul>
				<div class="template-body">
					<ul class="template-list clearfix">
						<li class="template-cat template-cat-0">
							<div class="img-wrap template-state-0">
								<img class="template-screenshot" src="../images/empty.jpg">
								<div class="template-cover">
									<div class="template-action-container">
										<a href="#create" class="ui-btn ui-btn-success ui-btn-use-template js-select-template">使用模板</a>
									</div>
								</div>
							</div>
							<p class="template-title">
								<span>自定义模板</span>
							</p>
						</li>
						<?php if($admin_list){ ?>
						<?php foreach($admin_list as $value){ ?>
						<li class="template-cat template-cat-<?php echo $value['cat_id'];?>">
							<div class="img-wrap">
								<img class="template-screenshot" src="<?php echo $value['thumb'];?>">
								<div class="template-cover">
									<div class="template-action-container">
										<a href="#create/<?php echo $value['page_id'];?>" class="ui-btn ui-btn-success ui-btn-use-template js-select-template">使用模板</a>
									</div>
								</div>
							</div>
							<p class="template-title">
								<span><?php echo $value['page_name'];?></span>
							</p>
						</li>
						<?php } ?>
						<?php }else{ ?>
						<div class="js-list-empty-region"></div>
						<?php } ?>
					</ul>
				</div>
				<div class="modal-footer">
				</div>
			</div>
			<div class="body_dark"></div>
			<!-- 弹窗结束 -->
		</div>
	</div>
	<div class="ui-box">
		<?php if($page_list['page_list']){ ?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
				<tr>
					<th class="cell-30">标题</th>
					<th class="cell-17"><a href="javascript:;" data-orderby="created_time">创建时间<span class="orderby-arrow desc"></span></a></th>
					<!--th class="cell-10 text-right"><a href="javascript:;" data-orderby="goods_num">商品数</a></th-->
					<th class="cell-10 text-right">浏览次数</th>
					<!--th class="cell-8  text-right"><a href="javascript:;" data-orderby="num">序号</a></th-->
					<th class="cell-25 text-right">操作</th>
				</tr>
			</thead>
			<tbody class="js-list-body-region">
				<?php foreach($page_list['page_list'] as $value){ ?>
				<tr page-id="<?php echo $value['page_id'];?>">
					<td>
						<a href="<?php echo $config['wap_site_url'];?>/page.php?id=<?php echo $value['page_id'];?>" target="_blank" class="new-window"><?php echo $value['page_name'];?></a>
					</td>
					<td><?php echo date('Y-m-d H:i:s',$value['add_time']);?></td>
					<!--td class="text-right"><?php echo $value['product_count'];?></td-->
					<td class="text-right"><?php echo $value['hits'];?></td>
							<!--td class="text-right">
								<a class="js-change-num" href="javascript:void(0);">0</a>
								<input class="input-mini js-input-num" type="number" min="0" maxlength="8" style="display:none;" value="<?php echo $value['page_sort'];?>"/>
							</td-->
							<td class="text-right">
								<?php if($home_page['page_id'] == $value['page_id']){ ?>
								<a href="javascript:void(0);" class="js-copy hover-show">复制</a>
								<span class="hover-show">-</span>
								<?php if(!in_array($value['type'],array(1,2))) {?>
								<a href="#edit/<?php echo $value['page_id'];?>">编辑</a>
								<span>-</span>
								<?php }?>
								<a href="javascript:void(0);" class="js-copy-link" copy-link="<?php echo $config['wap_site_url'];?>/page.php?id=<?php echo $value['page_id'];?>">链接</a>
								<span>-</span>
								<span class="c-gray">店铺主页</span>
								<?php }else{ ?>
								<a href="javascript:void(0);" class="js-copy hover-show">复制</a>
								<?php if(!in_array($value['type'],array(1,2))) {?>
								<span class="hover-show">-</span>
								<a href="#edit/<?php echo $value['page_id'];?>">编辑</a>

								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>

								<span>-</span>
								<?php }?>

								<?php if($value['type'] == 1) {?>
								<a href="javascript:void(0);" class="js-copy-link" copy-link="<?php echo $config['site_url'];?>/webapp/groupbuy/#/main/<?php echo $store_session['store_id'];?>">链接</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js_show_ewm" data-ewm_type="tuan_index" data-store_id="<?php echo $store_session['store_id'];?>" copy-link="<?php echo $config['site_url'];?>/webapp/groupbuy/#/main/<?php echo $store_session['store_id'];?>">手机预览</a>

								<?php } else if($value['type'] == 2) {?>
								<a href="javascript:void(0);" class="js-copy-link"    copy-link="<?php echo $config['site_url'];?>/webapp/groupbuy/#/main/<?php echo $store_session['store_id'];?>">链接</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js_show_ewm" data-ewm_type="yydb_index" data-store_id="<?php echo $store_session['store_id'];?>"  copy-link="<?php echo $config['site_url'];?>/webapp/groupbuy/#/main/<?php echo $store_session['store_id'];?>">手机预览</a>

								<?php } else {?>
								<a href="javascript:void(0);" class="js-copy-link" copy-link="<?php echo $config['wap_site_url'];?>/page.php?id=<?php echo $value['page_id'];?>">链接</a>
								<?php }?>

								<span>-</span>
								<a href="javascript:void(0);" class="js-set-as-homepage">设为主页</a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php }else{ ?>
				<div class="js-list-empty-region"></div>
				<?php } ?>
			</div>
			<div class="js-list-footer-region ui-box">
				<div>
					<div class="pagenavi js-page-list"><?php echo $page_list['page'];?></div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$('.page-template ul li a.js-filter').click(function() {
				var cat = $(this).attr('data-type');
				var parent = $(this).parents('li');
				var parents = $(this).parents('.template-filter').find('li.active');
				if (cat=="all") {
					$('.template-list li.template-cat').show();
				} else{
					$('.template-list li.template-cat').hide();
					$('.template-list li.template-cat.template-cat-'+cat+'').show();
				};
				parent.addClass('active');
				parents.removeClass('active');
			}); 
		});
		</script>