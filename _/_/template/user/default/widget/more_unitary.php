<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>商品挂件</title>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('.js-modal iframe',parent.document).height($('body').height());
				$('.modal-header .close').click(function(){
					parent.login_box_close();
				});
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
				$('.js-confirm-choose').live('click',function(){
					var data_arr = [];
					var re = /^[1-9]+[0-9]*]*$/;
					var a = 0;
					$.each($('.js-choose.btn-primary'),function(i,item){
						var id = $(item).data('id');
						if(!re.test($("#price"+id).val()) || !re.test($("#min"+id).val())){
							a = 1;
						}
						data_arr[i] = {'id':$(item).data('id'),'price':$("#price"+id).val(),'min':$("#min"+id).val(),'name':$("#name"+id).val(),'image':$("#image"+id).val()};
					});
					if(a == 1)
					{
						alert('价格和时间必须均为正整数');
						return;
					}
				   $.post("user.php?c=unitary&a=doadd", {post_info:data_arr},function(data){
						if(data.err_code)
						{
							alert(data.err_msg);
						}else
						{
							window.parent.location.href="user.php?c=wxapp&a=api&act=unitary";
						}
				   });
				});
			
				$('.js-page-list a').live('click',function(e){
					if(!$(this).hasClass('active')){
						var input_val = $('.js-modal-search-input').val();
						$('body').html('<div class="loading-more"><span></span></div>');
						$('body').load('<?php dourl('good',array('type'=>'more'));?>',{p:$(this).data('page-num'),'keyword':input_val},function(){
							$('.js-modal iframe',parent.document).height($('body').height());
						});
					}
				});
				$('.js-modal-search').live('click',function(e){
					var input_val = $('.js-modal-search-input').val();
					$('body').html('<div class="loading-more"><span></span></div>');
					$('body').load('<?php dourl('good',array('type'=>'more'));?>',{'keyword':input_val},function(){
						$('.js-modal iframe',parent.document).height($('body').height());
					});
					return false;
				});

				//回车提交搜索
				$(window).keydown(function(event){
					if (event.keyCode == 13 && $('.js-modal-search-input').is(':focus')) {
						var input_val = $('.js-modal-search-input').val();
						$('body').html('<div class="loading-more"><span></span></div>');
						$('body').load('<?php dourl('good',array('type'=>'more'));?>',{'keyword':input_val},function(){
							$('.js-modal iframe',parent.document).height($('body').height());
						});
						return false;
					}
				})
			});
		</script>
	</head>
	<body style="background-color:#ffffff;">
		<div class="modal-header">
			<a class="close js-news-modal-dismiss">×</a>
			<!-- 顶部tab -->
			<ul class="module-nav modal-tab">
				<li class="active"><a href="javascript:void(0);" class="js-modal-tab">已上架商品</a> |</li>
				<li><a href="<?php dourl('goods:create'); ?>" target="_blank" class="new_window">新建商品</a></li>
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
								<th class="title" style="background-color:#f5f5f5;">
									<div class="td-cont">
										<span title="默认原价格加二十邮费">夺宝价格</span>
									</div>
								</th>
								<th class="title" style="background-color:#f5f5f5;">
									<div class="td-cont">
										<span>结束倒计时</span>
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
										<input type="hidden" id="name<?php echo $product['product_id'];?>" value="<?php echo $product['name']; ?>"/>
										<input type="hidden" id="image<?php echo $product['product_id'];?>" value="<?php echo $product['image']; ?>"/>
									</td>
									<td class="time">
										<div class="td-cont">
											<span><?php echo date('Y-m-d H:i:s', $product['date_added']); ?></span>
										</div>
									</td>
									<td class="time">
										<div class="td-cont">
											<span><input class="input-small js-modal-search-input" id="price<?php echo $product['product_id'];?>" type="text" value="<?php echo $product['price']+20; ?>" name="price" style="border-radius:4px 0px 0px 4px;width:50px;"></span>
										</div>
									</td>
									<td class="time">
										<div class="td-cont">
											<span><input class="input-small js-modal-search-input" id="min<?php echo $product['product_id'];?>" type="text" value="5" name="min" style="border-radius:4px 0px 0px 4px;width:50px;"></span>
										</div>
									</td>
									<td class="opts">
										<div class="td-cont">
											<?php if(in_array($product['product_id'],$unitarys_arr)){?>
											<button class="btn">已参加</button>
											<?php }else{?>
											<button class="btn js-choose" data-id="<?php echo $product['product_id'];?>">选取</button>
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
			<div style="display:none;" class="js-confirm-choose left js-unitary-choose">
				<input type="button" class="btn btn-primary" value="确定使用">
			</div>
			<div class="pagenavi js-page-list" style="margin-top:0;padding-top:2px;"><?php echo $page; ?></div>
		</div>
	</body>
</html>