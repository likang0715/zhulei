<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8"/> 
	<title>茶会</title>
	<meta name="copyright" content="<?php echo $config['site_url']; ?>"/>
	<link href="./css/base.css" type="text/css" rel="stylesheet"/>

		<link rel="stylesheet" type="text/css" href="./static/css/jquery.ui.css" />
       
		<script type="text/javascript" src="./static/js/jquery.min.js"></script>
		<script type="text/javascript" src="./static/js/layer/layer.min.js"></script>
		<script type="text/javascript" src="./static/js/area/area.min.js"></script>
		
		<script type="text/javascript" src="./static/js/date/WdatePicker.js"></script>
		<script type="text/javascript" src="./static/js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="./static/js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="./js/base.js"></script>
		<script type="text/javascript">
			var load_url="<?php dourl('load');?>";
			var page_content = "present_index";
			var page_product_list = "product_list";
			var page_present_create = "present_create";
			var page_present_edit = "present_edit";
			var disabled_url = "<?php dourl('disabled') ?>";
			var delete_url = "<?php dourl('delete') ?>";
		</script>
		<script type="text/javascript" src="./js/present.js"></script>
		<script type="text/javascript" src="./js/chahui_setting.js"></script>
	<script type="text/javascript" src="./js/bdmap.js"></script>
	<script type="text/javascript" src="./js/jquery-labelauty.js"></script>
	<script type="text/javascript" src="../js/laydate/laydate.js"></script>
	<script>
	$(function(){
		$(':input').labelauty();
	});
	</script>
	<link href="./css/freight.css" type="text/css" rel="stylesheet"/>
	<link href="./css/jquery-labelauty.css" type="text/css" rel="stylesheet"/>
	<link href="./css/store.css" type="text/css" rel="stylesheet"/>
	<link href="./css/setting_store.css" type="text/css" rel="stylesheet"/>
	<link rel="stylesheet" href="./skin/css/font-awesome.min.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui.min.css">
	<link rel="stylesheet" href="./skin/css/ace-fonts.css">
	<link rel="stylesheet" href="./skin/css/ace.min.css" id="main-ace-style">
	<link rel="stylesheet" href="./skin/css/ace-skins.min.css">
	<link rel="stylesheet" href="./skin/css/ace-rtl.min.css">
	<link rel="stylesheet" href="./skin/css/global.css">
	<link rel="stylesheet" href="./skin/css/hint.css">
	<link rel="stylesheet" href="./skin/css/jquery-ui-timepicker-addon.css">
	
</head>
<body class="font14 usercenter">
	<?php include display('public:header');?>
	<div class="wrap_1000 clearfix container">
	<?php include display('sidebar');?>	
		<!-- 茶会列表 -->
		
		<!-- 茶会编辑 -->
		<div class="events_edit">
			<!-- 内容头部 -->
			<div class="events_edit_header">
				<h3>茶会编辑</h3>
			</div>
			<div class="events_edit_main">
				<div class="events_edit_main_con">
					<form class="events_edit_form">
						<input type="hidden" name="" value=""/>
						<div class="events_edit_item">
							<label>
								<em class="required">*</em>
								茶会名称：
							</label>
							<div class="events_edit_item_input">
								<input type="text" name="name" placeholder="茶会名称最长支持60个字符" maxlength="60" value="">
							</div>
						</div>
						<div class="events_edit_item">
							<label>
								<em class="required">*</em>
								举办时间：
							</label>
							<div class="events_edit_item_input1">
				   <input type="text" name="start_time" value="" placeholder="开始时间" class="js-start-time Wdate" id="js-start-time" readonly="readonly" id="" style="cursor:default; background-color:white"/>
							</div>
							<p class="short_line">-</p>
							<div class="events_edit_item_input2">
							
					<input type="text" name="end_time" value=""  placeholder="结束时间" class="js-end-time Wdate" id="js-end-time" readonly="readonly" id="" style="cursor:default; background-color:white"/>
							</div>
						</div>
						
					<div class="events_edit_item">
							<label>
								<em class="required">*</em>
								举办地点：
							</label>
		<div class="controls ui-regions js-regions-wrap" data-province="<?php echo $chahui['province']?>" data-city="<?php echo $chahui['city']?>" data-county="<?php echo $chahui['county']?>">
			<span><select name="province" id="s1"></select></span>
			<span><select name="city" id="s2"><option value="">选择城市</option></select></span>
			<span><select name="county" id="s3"><option value="">选择地区</option></select></span>
		</div>
						</div>
						<div class="events_edit_item">
							<label>
								<em class="required">*</em>
								详细地址：
							</label>
							<div class="events_edit_item_input">
								<input type="text" class="span6 js-address-input" name="address" value="<?php echo $store_physical['address']?>" placeholder="请填写详细地址，以便买家联系；（勿重复填写省市区信息）" maxlength="80"/>
								<button type="button" class="btn js-search">搜索地图</button>
							</div>
						</div>
						<div class="events_edit_item">
							<label>
								<em class="required">*</em>
								位置标注：
							</label>
							<div class="events_edit_item_input">
								<input type="hidden" class="span6 js-address-input" name="map_long" id="map_long" value=""/>
								<input type="hidden" class="span6 js-address-input" name="map_lat" id="map_lat" value=""/>
								<div class="shop-map-container">
									<div class="left hide">
										<ul class="place-list js-place-list"></ul>
									</div>
									<div class="map js-map-container large" id="cmmap"></div>
									<button type="button" class="ui-btn select-place js-select-place">点击地图标注位置</button>
								</div>
							</div>
						</div>
						<div class="events_edit_item">
							<label>
								<em class="required">*</em>
								茶会海报：
							</label>
							<div class="events_edit_item_thumb">
								<div class="control-action js-picture-list-wrap">
									<div class="js-img-list" style="display:inline-block">
										<?php foreach($store_physical['images_arr'] as $value){ ?>
										<li class="upload-preview-img"><a href="<?php echo $value;?>" target="_blank"><img src="<?php echo $value;?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
										<?php } ?>
									</div>
									<div class="events_edit_item_thumb_upbtn" style="display:inline-block;float:none;vertical-align:top;">
										<a href="javascript:;" class="add js-add-physical-picture">+上传海报</a>
										<span>
											温馨提示：<br>
											一张漂亮的海报，能让你的茶会锦上添花，带来更多用户报名及增加传播效果！
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="events_edit_item">
							<label><em class="required">*</em>
								茶会主题：
							</label>
							<div class="events_edit_item_input">
								<select name="" class="events_edit_item_input_select">
									<option value="">选择主题</option>
									<option value="">主题1</option>
									<option value="">主题2</option>
								</select>
							</div>
						</div>
						<div class="events_edit_item">
							<label>
								<em class="required">*</em>
								人数限制：
							</label>
							<div class="events_edit_item_input">
								<input type="text" name="name"  maxlength="60" value="" style="width:186px;float: left;">
								<p style="float: left;line-height: 40px;text-indent: 10px;color: #999;">人</p>
							</div>
						</div>
						<div class="events_edit_item">
							<label><em class="required">*</em>
								茶会票价：
							</label>
							<div class="events_edit_item_radio">
								<ul>
									<li><input type="radio" name="radio" data-labelauty="免费" checked></li>
									<li><input type="radio" name="radio" data-labelauty="收费" class="tickets_charge">
										<div class="events_edit_tickets"><input type="text" name="tickets"><p>元/人</p></div>
									</li>			
								</ul>
							</div>
						</div>
						<div class="events_edit_item">
							<label><em class="required">*</em>
								详细内容：
							</label>
							编辑器
						</div>
						<div class="form-actions" style="margin-top:50px">
							<button type="submit" class="ui-btn ui-btn-primary js-physical-edit-submit">保存</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		
		</div>
		<script type="text/javascript">
		$(document).ready(function() {
			$(".events_results_b_list ul").click(function() {
				$(this).next(".events_results_b_list_more").toggle()
			});
		});
		</script>
	</div>
	

	<?php include display('public:footer');?>
</body>
</html>