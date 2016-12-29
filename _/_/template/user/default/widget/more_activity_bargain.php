<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>活动挂件</title>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
//				设置高度
				$('.js-modal iframe',parent.document).height($('body').height());

//				关闭
				$('.modal-header .close').live("click", function(){
					parent.login_box_close();
				});

//				选取
				$('button.js-choose').live('click',function(){
					if($(this).hasClass('btn-primary')){
						$(this).removeClass('btn-primary').html('选取');
					}else{
						$(this).addClass('btn-primary').html('取消');
					}
					if($('.js-choose.btn-primary').size() > 0){
						$('.js-confirm-choose').show();
					}else{
						$('.js-confirm-choose').hide();
					}
				});

//				确定选取
				$('.js-confirm-choose').live('click',function(){
					var data_arr = [];
					$.each($('.js-choose.btn-primary'),function(i,item){
						var titles1 = $(item).data('title');
						var titles = titles1.toString();
						data_arr[i] = {'id':$(item).data('id'),'atype':$(item).data('atype'),'title':titles};
					});

					parent.widget_box_after('<?php echo $_GET['number'];?>',data_arr);
				});

//				分页
				$('.js-page-list a').live('click',function(e){
					if(!$(this).hasClass('active')){
						var input_val = $('.js-modal-search-input').val();
						$('body').html('<div class="loading-more"><span></span></div>');
						$('body').load('<?php dourl('activity_module',array('type'=>'more'));?>',{p:$(this).data('page-num'),'keyword':input_val},function(){
							$('.js-modal iframe',parent.document).height($('body').height());
						});
					}
				});

//				搜索
				$('.js-modal-search').live('click',function(e){
					var input_val = $('.js-modal-search-input').val();
					$('body').html('<div class="loading-more"><span></span></div>');
					$('body').load('<?php dourl('activity_module',array('type'=>'more'));?>',{'keyword':input_val},function(){
						$('.js-modal iframe',parent.document).height($('body').height());
					});
					return false;
				});

				//回车提交搜索
				$(window).keydown(function(event){
					if (event.keyCode == 13 && $('.js-modal-search-input').is(':focus')) {
						var input_val = $('.js-modal-search-input').val();
						$('body').html('<div class="loading-more"><span></span></div>');
						$('body').load('<?php dourl('activity_module',array('type'=>'more'));?>',{'keyword':input_val},function(){
							$('.js-modal iframe',parent.document).height($('body').height());
						});
						return false;
					}
				})
			});
		</script>
	</head>
	<body style="background-color:#ffffff;">

		
		<?php include display('widget:huodong_header')?>
		
		
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
										<span>砍价标题</span> <a class="js-update" href="javascript:window.location.reload();">刷新</a>
									</div>
								</th>
								<th class="time" style="background-color:#f5f5f5;">
									<div class="td-cont">
										<span>商品名称</span>
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
							<?php foreach($bargain_list as $bargain) {?>
								<tr>
									<td class="title" style="max-width:300px;">
										<div class="td-cont">
											<a target="_blank" class="new_window" href=""><?php echo $bargain['wxtitle']; ?></a>
										</div>
									</td>
									<td class="time">
										<div class="td-cont">
											<span><?php echo $bargain['product_name']; ?></span>
										</div>
									</td>
									<td class="opts">
										<div class="td-cont">
											<button class="btn js-choose" data-id="<?php echo $bargain['pigcms_id'];?>" data-atype="4" data-title="<?php echo $bargain['wxtitle'];?>">选取</button>
<!--											<button class="btn js-choose" data-id="--><?php //echo $product['product_id'];?><!--" data-title="--><?php //echo $product['name']; ?><!--" data-price="--><?php //echo $product['price']; ?><!--" data-image="--><?php //echo $product['image'];?><!--">选取</button>-->
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
			<div class="pagenavi js-page-list" style="margin-top:0;padding-top:2px;"><?php echo $bargain_page; ?></div>
		</div>
	</body>
</html>