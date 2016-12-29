<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<link rel="stylesheet" href="template/user/default/css/peerpay_setting.css" />
<div class="js-app-list">
	<div class="app-design">
		<div class="ui-box">
			<!-- 背景图片和文字颜色设置部分(开始) -->
			<div class="clearfix">
				<!-- 左侧效果展示 -->
				<div class="app-preview">
					<div class="app-config">
						<div class="app-header"></div>
						<div class="app-entry">
							<div class="app-field js-fields-region">
							<h1><span>代付</span></h1>
							<div class="app-fields ui-sortable js-show-set">
								<div class="page-peerpay" style="<?php echo $peerpay_custom['img'] ? 'background:url(' . $peerpay_custom['img'] . '); background-repeat: no-repeat; background-position: center center; background-size: cover;' : 'background:' . $peerpay_custom['color'] ?>">
									<p class="get-pay-text" style="color:<?php echo $peerpay_custom['txt_color'] ?>">此处为代付发起人所说的话…</p>
									<div class="peerpay-avatar"></div>
									<p class="watting-text" style="color:<?php echo $peerpay_custom['txt_color'] ?>">等待真爱路过…</p>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div>
				<!-- 右侧设置 -->
				<div class="app-sidebar" style="margin-top:75px;">
					<div class="arrow"></div>
					<div class="app-sidebar-inner js-sidebar-region">
						<form class="form-horizontal" novalidate="">
							<div class="control-group hide">
								<label class="control-label">背景颜色：</label>
								<div class="controls">
									<input type="color" class="js-change-bg-color" name="color" value="#000000" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">背景图片：</label>
								<div class="controls example-img-box">
									<?php 
									if ($peerpay_custom['img']) {
									?>
										<img class="example-img-size js-set-img" src="<?php echo $peerpay_custom['img'] ?>" />
										<p class="set-img">
											<a href="javascript:void(0)" class="font-size-12 js-modify-img">修改</a> |
											<a href="javascript:void(0)" class="font-size-12 js-delete-img">删除</a>
										</p>
									<?php
									} else {
									?>
										<img class="example-img-size js-set-img" src="" style="display:none;" />
										<p class="set-img">
											<a href="javascript:void(0)" class="font-size-12 js-modify-img">选择图片</a>
										</p>
									<?php
									}
									?>
									
									<p class="gray font-size-12">最佳尺寸：640x640像素<br>尺寸不匹配时，图片将被压缩或者拉伸已铺满画面</p>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">文字颜色：</label>
								<div class="controls">
									<input type="color" class="js-change-color" name="color" value="<?php echo $peerpay_custom['txt_color'] ?>">
									<input type="button" class="ui-btn js-reset-color" value="重置">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="app-actions" style="display: block; bottom: 0px;">
			<div class="form-actions text-center">
				<input class="btn btn-primary btn-save js-btn-save" type="submit" value="保存" data-loading-text="保存中...">
			</div>
		</div>
	</div>
</div>