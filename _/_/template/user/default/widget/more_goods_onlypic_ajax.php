<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>

		<div class="modal-header">
			<a class="close js-news-modal-dismiss">×</a>
			<!-- 顶部tab -->
			<ul class="module-nav modal-tab">
				<li class="active"><a href="javascript:void(0);" class="js-modal-tab">已上架商品</a></li>
			</ul>
		</div>
		<div class="modal-body">
			<div class="tab-content">
				<div id="js-module-feature" class="tab-pane module-feature active">
					<?php if($is_system){ ?>
					<div style="font-size:12px;margin-bottom:15px;">您登录了管理员帐号，已显示网站所有列表。（如需只显示该店铺，请在后台退出后再点击下方的“刷新”按钮。<a href="./admin.php" target="_blank" style="color:blue;">后台链接</a>）</div>
					<?php } ?>
					<table class="table">
						<colgroup>
							<col class="modal-col-title">
							<col class="modal-col-time" span="2">
							<col class="modal-col-action">
						</colgroup>
						<!-- 表格头部 -->
						<thead>
							<tr>
								<th class="title" style="background-color:#f5f5f5;">
									<div class="td-cont">
										<span>商品名称</span> <a class="js-update" href="javascript:window.location.reload();">刷新</a>
									</div>
								</th>
								<th class="time" style="background-color:#f5f5f5;">
									<div class="td-cont">
										<span>商品图片</span>
									</div>
								</th>
								<th class="opts" style="background-color:#f5f5f5;">
									<div class="td-cont" style="padding:7px 0 3px 10px;">
										<form class="form-search" onsubmit="return false;">
											<div class="input-append">
												<input class="input-small js-modal-search-input" type="text" style="border-radius:4px 0px 0px 4px;"/><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search" style="color:white;border-radius:0 4px 4px 0;margin-left:0px;">搜</a>
											</div>
										</form>
									</div>
								</th>
							</tr>
						</thead>
						<!-- 表格数据区 -->
						<tbody>
							<?php foreach($products as $product){ ?>
								<tr>
									<td class="title" style="max-width:300px;">
										<div class="td-cont">
											<a target="_blank" class="new_window" href="<?php echo $config['wap_site_url'];?>/good.php?id=<?php echo $product['product_id'];?>"><?php echo $product['name']; ?></a>
										</div>
									</td>
									<td class="pic_list">

										<ul class="ico app-image-list js-ico-list">
											<?php if($product['image_list']) {?>
												<?php foreach($product['image_list'] as $k=>$v) {?>
												
											<li class="other_li sort">
												<div class="spans">
													<span class="checkico no-selected-style"><i class="icon-ok icon-white"></i>
													<img  class="avatar" src="<?php echo $v['image'];?>">
													</span>
												</div>
											</li>
												<?php }?>
											<?php } else {?>
											<li style="border:0px;width:auto;">该商品 暂无图片，无法选取哦！</li>		
											<?php }?>
										</ul>
					
					
					
									</td>
									<td class="opts">
										<div class="td-cont">
										<?php if($product['image_list']) {?>
											<button class="btn js-choose" data-id="<?php echo $product['product_id'];?>" data-title="<?php echo $product['name']; ?>" data-price="<?php echo $product['price']; ?>" data-image="<?php echo $product['image'];?>">选取</button>
										<?php } else {?>
											<button class="btn" readonly="readonly" disabled="disabled" data-id="<?php echo $product['product_id'];?>" data-title="<?php echo $product['name']; ?>" data-price="<?php echo $product['price']; ?>" data-image="<?php echo $product['image'];?>">选取</button>
										<?php }?>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div style="display:none;" class="js-confirm-choose left">
				<input type="button" class="btn btn-primary" value="确定使用">
			</div>
			<div class="pagenavi js-page-list" style="margin-top:0;padding-top:2px;"><?php echo $page; ?></div>
		</div>
