<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<div class="modal-header">
<!-- 顶部tab -->
			 <ul class="module-nav modal-tab">
				<?php foreach($physical as $r){ ?>
					<li><a href="<?php dourl('baoxiang',array('seller_id'=>$r['store_id'],'type'=>more,'number'=>$_GET['number']));?>" class="js-modal-tab"><?php echo $r['name']; ?></a> |</li>
				<?php 
				}
				?>
			
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
								<span>标题</span> <a class="js-update" href="javascript:window.location.reload();">刷新</a>
							</div>
						</th>
						<th class="time" style="background-color:#f5f5f5;">
							<div class="td-cont">
								<span>创建时间</span>
							</div>
						</th>
						<th class="opts" style="background-color:#f5f5f5;">
							<div class="td-cont" style="padding:7px 0 3px 10px;">
								<form class="form-search" onsubmit="return false;">
									<div class="input-append">
										<input class="input-small js-modal-search-input" type="text" value="<?php echo htmlspecialchars($_REQUEST['keyword']) ?>" style="border-radius:4px 0px 0px 4px;"/><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search" style="color:white;border-radius:0 4px 4px 0;margin-left:0px;">搜</a>
									</div>
								</form>
							</div>
						</th>
					</tr>
				</thead>
				<!-- 表格数据区 -->
				<tbody>
					<?php foreach($baoxiang as $product){ ?>
						<tr>
							<td class="title" style="max-width:300px;">
								<div class="td-cont">
									<a target="_blank" class="new_window" href="<?php echo $config['wap_site_url'];?>/baoxiang.php?id=<?php echo $product['cz_id'];?>"><?php echo $product['name']; ?></a>
								</div>
							</td>
							<td class="time">
								<div class="td-cont">
									<span><?php echo date('Y-m-d H:i:s', $product['add_time']); ?></span>
								</div>
							</td>
							<td class="opts">
								<div class="td-cont">
									<button class="btn js-choose" data-id="<?php echo $product['cz_id'];?>" data-title="<?php echo $product['name']; ?>" data-price="<?php echo $product['price']; ?>" data-image="<?php echo $product['image'];?>">选取</button>
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