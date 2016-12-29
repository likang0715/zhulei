<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<?php include display('widget:huodong_header')?>

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
							<span>一元夺宝名称</span> <a class="js-update" href="javascript:window.location.reload();">刷新</a>
						</div>
					</th>
					<th class="time" style="background-color:#f5f5f5;">
						<div class="td-cont">
							<span>添加时间</span>
						</div>
					</th>
					<th class="opts" style="background-color:#f5f5f5;">
						<div class="td-cont" style="padding:7px 0 3px 10px;">
							<form class="form-search" onsubmit="return false;">
								<div class="input-append">
									<input class="input-small js-modal-search-input" type="text" value="<?php echo htmlspecialchars($_REQUEST['keyword']); ?>" search_val="<?php echo htmlspecialchars($_REQUEST['keyword']); ?>" style="border-radius:4px 0px 0px 4px;"/><a href="javascript:void(0);" class="btn js-fetch-page js-modal-search" style="color:white;border-radius:0 4px 4px 0;margin-left:0px;">搜</a>
								</div>
							</form>
						</div>
					</th>
				</tr>
				</thead>
				<!-- 表格数据区 -->
					<tbody>
					<?php foreach($unitarys as $unitary){ ?>
						<tr>
							<td class="title" style="max-width:300px;">
								<div class="td-cont">
									<a target="_blank" class="new_window" href="javascript:"><?php echo $unitary['name']; ?></a>
								</div>
							</td>
							<td class="time">
								<div class="td-cont">
									<span><?php echo date('Y-m-d H:i:s', $unitary['addtime']); ?></span>
								</div>
							</td>
							<td class="opts">
								<div class="td-cont">
									<button class="btn js-choose" data-id="<?php echo $unitary['id'];?>" data-atype="3" data-title="<?php echo $unitary['name'];?>">选取</button>
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
		<div class="pagenavi js-page-list" style="margin-top:0;padding-top:2px;"><?php echo $unitary_page; ?></div>
</div>