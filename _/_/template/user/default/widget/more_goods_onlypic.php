<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>商品挂件</title>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('.js-modal iframe',parent.document).height($('body').height());
				$('.modal-header .close').live("click",function(){
					parent.login_box_close();
				});
				$('button.js-choose').live('click',function(i){
					var js_choose_index = $('button.js-choose').index($(this));
					//var one_product_pic_sum = $(".table .pic_list").eq(js_choose_index).find(".selected-style").size();
					
					var one_product_pic_sum = $(this).closest("tr").find(".pic_list").find(".selected-style").size();
					
					
					if(one_product_pic_sum >0 && one_product_pic_sum < 3) {	
						if($(this).hasClass('btn-primary')){
							$(this).removeClass('btn-primary').html('选取');
						}else {
							var data_arr1 = [];
							//var objs = $(".table .pic_list").eq(js_choose_index).find(".selected-style");
							var objs = $(this).closest("tr").find(".pic_list").find(".selected-style");
							$.each(objs,function(j,items) {
								data_arr1.push($(items).find(".avatar").attr('src'));
								console.log(items)
								
							})
							//data_arr1.join("^");
							//console.log(data_arr1)
							$('button.js-choose').eq(js_choose_index).data("piclist",data_arr1);
							
							$(this).addClass('btn-primary').html('取消');
						}				
					} else if(one_product_pic_sum>2) {
						layer.msg("单个商品最多选择两个商品哦！");	
					}else {
						layer.msg("您先选择该产品展示的图片吧！");
					}

					if($('.js-choose.btn-primary').size() > 0){
						$('.js-confirm-choose').show();
					}else{
						$('.js-confirm-choose').hide();
					}

					
				});


				//点击产品图片
				$(".pic_list .ico li").live("click",function() {
					var pic_list_obj = $(this).closest(".pic_list");
					var pic_list_index = $(".pic_list").index(pic_list_obj);
					
					var ico_index = $(".pic_list .ico li").index($(this));
					if($(this).find(".checkico").hasClass('selected-style')) {
						//$(".pic_list .ico li .checkico").eq(ico_index).removeClass("selected-style").removeClass("no-selected-style").addClass("no-selected-style");
					//	alert(11)
						$(this).find(".checkico").removeClass("selected-style").removeClass("no-selected-style").addClass("no-selected-style");
					} else if($(this).find(".checkico").hasClass('no-selected-style')) {
						/////
						//alert(22);
						//alert(ico_index)
						if($(this).closest(".pic_list").find(".selected-style").size() > 1) {
								layer.msg("单个商品最多选择两个商品哦！");	
								return;
							}
						/////
						//$(".pic_list .ico li .checkico").eq(ico_index).removeClass("no-selected-style").addClass("selected-style");
						
						$(this).find(".checkico").removeClass("no-selected-style").addClass("selected-style");
					}

					var data_arr1 = [];
					var objs = $(".pic_list").eq(pic_list_index).find(".selected-style");
					$.each(objs,function(j,items) {
						data_arr1.push($(items).find(".avatar").attr('src'));
					})
					$(".js-choose").eq(pic_list_index).data("piclist",data_arr1);


					
				})
				
				$('.js-confirm-choose').live('click',function(){
					var data_arr = [];
					$.each($('.js-choose.btn-primary'),function(i,item){
						
						
						//data_arr[i] = {'id':$(item).data('id'),'title':$(item).data('title'),'piclist':$(item).data('piclist'),'image':$(item).data('image'),'price':$(item).data('price'),'url':'<?php echo $config['wap_site_url'];?>/good.php?id='+$(this).data('id')};

						data_arr[$(item).data('id')] = {'id':$(item).data('id'),'title':$(item).data('title'),'piclist':$(item).data('piclist'),'image':$(item).data('image'),'price':$(item).data('price'),'url':'<?php echo $config['wap_site_url'];?>/good.php?id='+$(this).data('id')};
						


				});

					/////console.log(data_arr);
					parent.widget_box_after('<?php echo $_GET['number'];?>',data_arr);
				});
				$('.js-page-list a').live('click',function(e){
					if(!$(this).hasClass('active')){
						var input_val = $('.js-modal-search-input').val();
						$('body').html('<div class="loading-more"><span></span></div>');
						$('body').load('<?php dourl('good_only_pic',array('type'=>'more'));?>',{p:$(this).data('page-num'),'keyword':input_val},function(){
							$('.js-modal iframe',parent.document).height($('body').height());
						});
					}
				});
				$('.js-modal-search').live('click',function(e){
					var input_val = $('.js-modal-search-input').val();
					$('body').html('<div class="loading-more"><span></span></div>');
					$('body').load('<?php dourl('good_only_pic',array('type'=>'more'));?>',{'keyword':input_val},function(){
						$('.js-modal iframe',parent.document).height($('body').height());
					});
					return false;
				});

				//回车提交搜索
				$(window).keydown(function(event){
					if (event.keyCode == 13 && $('.js-modal-search-input').is(':focus')) {
						var input_val = $('.js-modal-search-input').val();
						$('body').html('<div class="loading-more"><span></span></div>');
						$('body').load('<?php dourl('good_only_pic',array('type'=>'more'));?>',{'keyword':input_val},function(){
							$('.js-modal iframe',parent.document).height($('body').height());
						});
						return false;
					}
				})
			});
		</script>
<style>
.ico .spans { position: relative;}
.controls .ico li { float: left; width: 54px;display: inline-block; height: 55px;cursor: pointer;}
.app-image-list .other_li {background: none; line-height:41px;}
.no-selected-style i {display: none;}
.icon-ok { background-position: -288px 0;}
.selected-style {position: absolute;left: 0;top: 0;border: 2px solid #09F; -webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;}
.selected-style:after { position: absolute;display: block; content: ' ';right: 0px; bottom: 0px;border: 14px solid #09f;border-left-color: transparent;border-top-color: transparent;}
.selected-style i {position: absolute;right: 1px;bottom: 1px;z-index: 2;}
</style>
	</head>
	<body style="background-color:#ffffff;">
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
	</body>
</html>