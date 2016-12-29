<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8"/> 
		<title>导购管理 - <?php echo $store_session['name']; ?> | <?php if (empty($_SESSION['sync_store'])) { ?><?php echo $config['site_name'];?><?php } else { ?>微店系统<?php } ?></title>
		<meta name="copyright" content="<?php echo $config['site_url'];?>"/>
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet"/>
		<link href="<?php echo TPL_URL;?>css/subject.css" type="text/css" rel="stylesheet"/>
		<link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>css/jquery.ui.css" />
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/plugin/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.sortable1.js"></script>
		<script type="text/javascript">
			var load_url="<?php dourl('subject_load');?>";
			var location_type = "subject";
			var page_create = "subject_create";
			var page_edit = "subject_edit";
			var page_list_url = "<?php echo url("subject")?>";
			var delete_url = "<?php dourl('delete',array('type'=>'subject')) ?>";
			var subject_addsave_url = "<?php echo dourl('subject_create');?>";
			var subject_delete_url = "<?php dourl('subject_delete');?>";
			var page_content = "subject_content";
			var page_product_list = "product_list";
			var get_sonsubtype_url = "<?php  dourl('getSubtype');?>"; 

			var disabled_url = "<?php dourl('disabled',array('type'=>'subject')) ?>";
			var able_url = "<?php dourl('able',array('type'=>'subject')) ?>";
			var subject_piclist = "<?php echo $piclist?>";
		</script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/subject.js"></script>


	</head>
	<body class="font14 usercenter">
		<?php include display('public:header');?>
		<div class="wrap_1000 clearfix container">
			<?php include display('sidebar');?>
			<div class="app" style="padding-top: 15px;">
				<div class="app-inner clearfix">
					<div class="app-init-container">
						<nav class="ui-nav-table clearfix">
							<ul class="pull-left js-list-filter-region">
								<li id="js-list-nav-subject" <?php echo $typename == 'subject' ? 'class="active"' : '' ?>>
									<a href="<?php echo dourl('subject')?>">专题管理</a>
								</li>
								<li id="js-list-nav-subtype" <?php echo $typename == 'subtype' ? 'class="active"' : '' ?>>
									<a tips="no_click" href="<?php echo dourl('subtype')?>">专题分类</a>
								</li>
								<li id="js-list-nav-subject_pinlun" <?php echo $typename == 'subject_pinlun' ? 'class="active"' : '' ?>>
									<a tips="no_click" href="<?php echo dourl('subject_pinlun')?>">专题评论管理</a>
								</li>
								<li id="js-list-nav-subject_diy" <?php echo $typename == 'subject_diy' ? 'class="active"' : '' ?>>
									<a tips="no_click" href="<?php echo dourl('subject_diy')?>">专题名称DIY设定</a>
								</li>
							</ul>
						</nav>
						<div class="nav-wrapper--app"></div>
						
<div class="subject_search">
		<form class="form-horizontal ui-box list-filter-form" onsubmit="return false;">
	<div class="clearfix">
		<div class="filter-groups">



			<div class="control-group">
				<label class="control-label">标题：</label>
				<div class="controls">
				   		<input type="text" name="titles" value="<?php echo $search_name;?>" style="width:240px;">
						
					   
				</div>
			</div>
			
		   <div class="control-group">
				<label class="control-label">分类：</label>
				<div class="controls">
				   		<select name="subtype1" class="select_toptype_subject_content subtype1"  style="width:120px;">
						<option value="">未选择</option>
						<?php if(is_array($search_subtype_list)) {?>
							<?php foreach($search_subtype_list as $k=>$v) :?>
								<option value="<?php echo $v['id']?>"><?php echo $v['typename'];?></option>
							<?php endforeach;?>
						<?php }?>
					</select>
					
					<select name="subtype2" class="select_sontype_subject_content subtype2" style="width:120px;display:none"></select>
				</div>
			</div>
			
			
			
		</div>
		<div class="pull-left">
			<div class="time-filter-groups clearfix">
				<div class="control-group">
					<label class="control-label select">
						
					</label>

					<div class="controls">
						<input type="text" name="start_time" value="<?php echo $start_time;?>" class="js-start-time" id="js-start-time">
						<span>至</span>
						<input type="text" name="end_time" value="<?php echo $end_time;?>" class="js-end-time" id="js-end-time">
						<span class="date-quick-pick" data-days="7">最近7天</span>

					</div>
				</div>
			</div>
			<div class="filter-groups">
				<div class="control-group">
					
				</div>

				<!--<div class="control-group">
					<label class="control-label">微信昵称：</label>
					<div class="controls">
						<input type="text" name="weixin_user" />
					</div>
				</div>-->
			</div>
			<div class="filter-groups">



			</div>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<div class="ui-btn-group">
				<a href="javascript:;" class="subject_search_botton ui-btn ui-btn-primary js-filter" data-loading-text="正在筛选...">筛选</a>
			</div>
		</div>
	</div>
</form>		<style>
			
		</style>


	</div>
						<div class="app__content"></div>
					</div>
				</div>
			</div>
		</div>
		<?php include display('public:footer');?>
		<div id="nprogress"><div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div>
	</body>
</html>