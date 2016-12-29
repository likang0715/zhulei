<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>店铺栏目分类</title>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('.js-modal iframe',parent.document).height($('body').height());
				$('.modal-header .close').click(function(){
					parent.login_box_close();
				});
				$('button.js-choose').live('click',function(){
                    var data_arr = new Array();
                    data_arr['key'] = $(this).attr('data-key');
                    data_arr['value'] = $(this).attr('data-value');

                    parent.widget_box_after('<?php echo $_GET['number'];?>',data_arr);
				});
                $('.js-add-classfy').live('click',function(){
                    var name = $(".js-modal-add-input").val();
                    if(name==''){
                        alert("添加分类名不能为空！");return false;
                    }

                    $.post("<?php dourl('add_banner');?>", { name: name },
                        function(result){
                            result = jQuery.parseJSON(result);
                            if(result.error==0){
                                //console.log(result.msg);
                                window.location.reload();
                            }else{
                                console.log(result.msg);
                            }
                        }
                    );

                })
				/*$('.js-confirm-choose').live('click',function(){
                    if($('.js-choose.btn-primary').size() > 1){
                        alert("只能选取一个商品");
                        return false;
                    };
					var data_arr = [];
					$.each($('.js-choose.btn-primary'),function(i,item){
						data_arr[i] = {'id':$(item).data('id'),'title':$(item).data('title'),'image':$(item).data('image'),'price':$(item).data('price'),'logoimg1':$(item).data('logoimg1'),'logoimg2':$(item).data('logoimg2'),'logoimg3':$(item).data('logoimg3'),'inventory':$(item).data('inventory'),'url':'<?php echo $config['wap_site_url'];?>/good.php?id='+$(this).data('id')};
					});
					parent.widget_box_after('<?php echo $_GET['number'];?>',data_arr);
				});*/

			});
		</script>
	</head>
	<body style="background-color:#ffffff;">
		<div class="modal-header">
			<a class="close js-news-modal-dismiss">×</a>
			<!-- 顶部tab -->
			<ul class="module-nav modal-tab">
				<li class="active"><a href="javascript:void(0);" class="js-modal-tab">管理店铺栏目分类</a></li>
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
										<span>分类ID</span> <a class="js-update" href="javascript:window.location.reload();">刷新</a>
									</div>
								</th>
								<th class="time" style="background-color:#f5f5f5;">
									<div class="td-cont">
										<span>分类名称</span>
									</div>
								</th>
								<th class="opts" style="background-color:#f5f5f5;">
									<div class="td-cont" style="padding:7px 0 3px 10px;">
										<form class="form-search" onsubmit="return false;">
											<div class="input-append">
												<input class="input-small js-modal-add-input" type="text" style="border-radius:4px 0px 0px 4px;"/><a href="javascript:void(0);" class="btn js-add-classfy" style="color:white;border-radius:0 4px 4px 0;margin-left:0px;">添加大类</a>
											</div>
										</form>
									</div>
								</th>
							</tr>
						</thead>
						<!-- 表格数据区 -->
						<tbody>
							<?php foreach($first_banners as $key=>$value){ ?>
								<tr>
									<td class="title" style="max-width:300px;">
										<div class="td-cont">
                                            <span><?php echo $key;?></span>
										</div>
									</td>
									<td class="time">
										<div class="td-cont">
											<input type="text" data-key="<?php echo $key;?>" data-value="<?php echo $value;?>" value="<?php echo $value;?>"/><button type="button" class="btn js-btn-edit" data-key="<?php echo $key;?>" data-value="<?php echo $value;?>" style="margin-left: 10px;margin-top: -9px;">修改</button>
										</div>
									</td>
									<td class="opts">
										<div class="td-cont">
											<button class="btn js-choose" data-key="<?php echo $key;?>" data-value="<?php echo $value;?>">选取</button>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
        <script type="text/javascript">
            $(".js-btn-edit").click(function(){
                var inputdom = $(this).prev('input');
                var key = inputdom.attr("data-key");
                var ori_value = inputdom.attr("data-value");
                var now_value = inputdom.val();
                if(now_value=='' || ori_value==now_value){
                    alert("请填写正确的大类名");
                }

                $.post("<?php dourl('edit_banner');?>", { key:key,ori_value: ori_value,now_value:now_value },
                    function(result){
                        result = jQuery.parseJSON(result);
                        if(result.error==0){
                            parent.location.reload();
                        }else{
                            alert(result.msg);return false;
                        }
                    }
                );

            })
        </script>
	</body>
</html>
