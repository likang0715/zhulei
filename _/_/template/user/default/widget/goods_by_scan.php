<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>商品挂件</title>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/goods_by_scan.js"></script>
		<script type="text/javascript">
		var goods_by_sku_url = "<?php dourl('goods_by_sku') ?>";
		var uid = "<?php echo $_REQUEST["uid"] ?>";
		var number = "<?php echo $_GET['number'] ?>";
		</script>
	</head>
	<body style="background-color:#ffffff;">
		<div class="modal-header">
			<a class="close js-news-modal-dismiss">×</a>
			<!-- 顶部tab -->
			<ul class="module-nav modal-tab">
				<li class="active">
					<a href="javascript:void(0);" class="js-modal-tab">商品扫码列表</a>
				</li>
			</ul>
		</div>
		<div class="modal-header">
			<ul class="module-nav modal-tab">
				<li class="active">
					扫描:<input type="text" class="js-code" autofocus="autofocus" placeholder="" />备注：扫描时请将光标放到输入框内
				</li>
			</ul>
		</div>
		<div class="modal-body">
			<div class="tab-content">
				<div id="js-module-feature" class="tab-pane module-feature active">
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
										<span>标题</span>
									</div>
								</th>
								<th class="time" style="background-color:#f5f5f5; width:18%;">
									<div class="td-cont">
										<span>价格</span>
									</div>
								</th>
								<th class="time" style="background-color:#f5f5f5; width:30%;">
									<div class="td-cont">
										<span>购买数量</span>
									</div>
								</th>
								<th class="opts" style="background-color:#f5f5f5; width:12%;">
									<div class="td-cont" style="padding:7px 0 3px 10px; display:none;">
										<form class="form-search" onsubmit="return false;">
											<div class="input-append">
												<input class="input-small js-modal-search-input" type="text" style="border-radius:4px 0px 0px 4px;"/>
											</div>
										</form>
									</div>
								</th>
							</tr>
						</thead>
						<!-- 表格数据区 -->
					</table>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div style="float:left; display:none;" class="js-confirm-choose pull-left">
				<input type="button" class="btn btn-primary" value="确定使用">
			</div>
		</div>
	</body>
</html>