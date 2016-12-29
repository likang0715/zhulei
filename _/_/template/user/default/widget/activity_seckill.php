<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>	
	<meta charset="utf-8"/>
	<title>秒杀活动</title>
	<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
	<script type="text/javascript">
	$(function(){
		// 设置高度
		$('.js-modal iframe',parent.document).height($('body').height());
		
		// 关闭
		$('.modal-header .close').live("click", function() {
			parent.login_box_close();
		});
		
		// 选取
		$('button.js-choose').live('click', function() {
			if ($(this).hasClass('btn-primary')) {
				$(this).removeClass('btn-primary').html('选取');
			} else {
				$(this).addClass('btn-primary').html('取消');
			}
			if ($('.js-choose.btn-primary').size() > 0) {
				$('.js-confirm-choose').show();
			} else {
				$('.js-confirm-choose').hide();
			}
		});
		
		// 确定选取
		$('.js-confirm-choose').live('click', function() {
			var data_arr = [];
			$.each($('.js-choose.btn-primary'), function(i, item) {
				data_arr[i] = {'id': $(item).data('id'), 'atype': $(item).data('atype'), 'title': $(item).data('title')};
			});
			
			parent.widget_box_after('<?php echo $_GET['number'];?>', data_arr);
		});
		
		// 分页
		$('.js-page-list a').live('click', function(e) {
			if (!$(this).hasClass('active')) {
				var input_val = $('.js-modal-search-input').attr("search_val");
				$('body').html('<div class="loading-more"><span></span></div>');
				$('body').load('<?php dourl('activity_module', array('huodong_type' => 'seckill', 'type'=>'ajax')); ?>', {p: $(this).data('page-num'), 'keyword': input_val}, function() {
					$('.js-modal iframe', parent.document).height($('body').height());
				});
			}
		});
		
		// 搜索
		$('.js-modal-search').live('click', function(e) {
			var input_val = $('.js-modal-search-input').val();
			$('body').html('<div class="loading-more"><span></span></div>');
			$('body').load('<?php dourl('activity_module',array('huodong_type' => 'seckill', 'type'=>'ajax')); ?>', {'keyword': input_val}, function() {
				$('.js-modal iframe', parent.document).height($('body').height());
			});
			return false;
		});
		
		//回车提交搜索
		$(window).keydown(function(event) {
			if (event.keyCode == 13 && $('.js-modal-search-input').is(':focus')) {
				var input_val = $('.js-modal-search-input').val();
				$('body').html('<div class="loading-more"><span></span></div>');
				$('body').load('<?php dourl('activity_module', array('huodong_type' => 'seckill', 'type'=>'ajax')); ?>', {'keyword': input_val}, function() {
					$('.js-modal iframe', parent.document).height($('body').height());
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
							<span>秒杀名称</span> <a class="js-update" href="javascript:window.location.reload();">刷新</a>
						</div>
					</th>
					<th class="time" style="background-color:#f5f5f5;">
						<div class="td-cont">
							<span>开始时间</span>
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
				<?php foreach($seckills as $seckill){ ?>
					<tr>
						<td class="title" style="max-width:300px;">
							<div class="td-cont">
								<a target="_blank" class="new_window" href="javascript:"><?php echo $seckill['name']; ?></a>
							</div>
						</td>
						<td class="time">
							<div class="td-cont">
								<span><?php echo date('Y-m-d H:i:s', $seckill['start_time']); ?></span>
							</div>
						</td>
						<td class="opts">
							<div class="td-cont">
								<button class="btn js-choose" data-id="<?php echo $seckill['pigcms_id'];?>" data-atype="5" data-title="<?php echo $seckill['name'];?>">选取</button>
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
	<div class="pagenavi js-page-list" style="margin-top:0;padding-top:2px;"><?php echo $seckill_page; ?></div>
</div>
</body>
</html>