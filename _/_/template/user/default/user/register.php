<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>茶馆入驻-
		<?php echo $config['site_name'];?></title>
		<meta name="Keywords" content="<?php echo $config['seo_keywords'];?>">
		<meta name="description" content="<?php echo $config['seo_description'];?>">
		<link href="<?php echo TPL_URL;?>css/base.css" type="text/css" rel="stylesheet">
		<link href="<?php echo TPL_URL;?>css/style.css" type="text/css" rel="stylesheet">
		<link href="<?php echo TPL_URL;?>css/index.css" type="text/css" rel="stylesheet">
		<link href="<?php echo TPL_URL;?>css/register.css" type="text/css" rel="stylesheet">
		<script type="text/javascript">
		var store_name_check="index.php?c=index&a=storename_check";
		var json_categories = '<?php echo $json_categories; ?>';
		var check_register_url = "<?php echo url('user:checkuser') ?>";
		var ajax_submit = "<?php echo url('user:register') ?>"
		</script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/jquery.form.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/common.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/layer/layer.min.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/base.js"></script>
		<script type="text/javascript" src="<?php echo TPL_URL;?>js/bdmap.js"></script>
		<script type="text/javascript" src="js/laydate/laydate.js"></script>
		<script type="text/javascript" src="<?php echo STATIC_URL;?>js/register.js"></script>
	</head>
	<body id="index1200" class="index1200">
		<!-- common header start -->
		<div class="header">
			<div class="header_common">
				<div class="header_inner">
					<div class="site_logo">
						<a href="<?php echo $config['site_url'];?>">
							<img src="<?php echo $config['site_logo'];?>" width="235" height="70">
						</a>
					</div>
				</div>
			</div>
		</div>
		<form class="join_form" name="form_register" id="register" method="post">
			<div class="user_join">
				<div class="common_inner">
					<div class="join_content">
						<div class="thouse_info cf">
							<div class="join_tit">
								<h3>茶馆信息</h3>
								<span class="join_tit_desc"></span>
							</div>
							<div class="info control-group">
								<label for="store_name">
									茶馆名称
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<input type="text" id="store_name" name="store_name" placeholder="认证通过之后不可更改">
							</div>
							<div class="info control-group">
								<label for="thouseArea">
									茶馆类型
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<div class="thouseAddress_sort" id="sale_category">
									<select name="sale_category_fid" id="category_top" ></select>
								</div>
							</div>

							<div class="info control-group">
								<label for="thouseAddress">
									茶馆地址
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<div class="thouseAddress_sort">
									<select name="province" id="s1" >
										<option value="">选择省份</option>
									</select>
									<select name="city" id="s2">
										<option value="">选择城市</option>
									</select>
									<select name="area" id="s3">
										<option value="">选择地区</option>
									</select>
								</div>
								<div class="thouseAddress_detail">
									<input type="text" id="thouseAddress" class="js-address-input" name="address" placeholder="例如：长宁路88号">
									<input type="button" value="搜索" class="thousePos_sort js-search" id="search_address">
								</div>
							</div>
							<div class="info control-group">
								<label class="control-label"> <em class="required">*</em>
									地图定位：
								</label>
								<div class="controls" style="margin-left: 171px;">
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
							<div class="info control-group">
								<label for="thouseTrans">茶馆简介</label>
								<span class="colon">：</span>
								<textarea name="" id="" cols="30" rows="10"></textarea>
							</div>
						</div>
						<div class="thouse_account cf">
							<div class="join_tit">
								<h3>入驻账号信息</h3>
								<span class="join_tit_desc">（此手机号用来审核通过后登陆商家后台使用）</span>
							</div>
							<div class="info control-group">
								<label for="contact_tel">
									手机号码
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<input type="text" name="mobile" id="contact_tel" placeholder="手机号码" class="info_l info_m">
								<span class="error_msg"></span>
							</div>
							<div class="info control-group">
								<label for="accountEmail">
									邮箱
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<input type="text" name="email" id="accountEmail" placeholder="请输入常用邮箱"  class="info_l info_m">
								<span class="error_msg"></span>
							</div>
							<div class="info control-group">
								<label for="accountPassword">
									密码
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<input type="password" name="password" id="fPassword" placeholder="请输入6-12位密码"  class="info_l info_m">
								<span class="error_msg"></span>
							</div>
							<div class="info control-group">
								<label for="accountPassword">
									重复密码
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<input type="password" name="repassword" id="rePassword" placeholder="重复输入密码"  class="info_l info_m">
								<span class="error_msg"></span>
							</div>
						</div>
						<div class="thouse_contact cf">
							<div class="join_tit">
								<h3>帐号运营人</h3>
								<span class="join_tit_desc">（负责茶馆帐号运营）</span>
							</div>
							<div class="info">
								<label for="operat_name">
									姓名
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<input type="text" name="contacts_name" id="operat_name" placeholder="请输入运营人姓名" class="info_s">
								<span class="error_msg"></span>
							</div>
							<div class="info">
								<label for="operat_tel">
									手机号
									<span class="info_must">*</span>
								</label>
								<span class="colon">：</span>
								<input type="text" name="contacts_phone" id="operat_tel" placeholder="请输入运营人手机号" class="info_l">
								<span class="error_msg"></span>
							</div>
						</div>
						<div class="thouse_qualification cf">
							<div class="join_tit">
								<h3>茶馆资质信息</h3>
								<span class="join_tit_desc">（请上传jpg、png、jpeg格式的文件，图片大小不超过5M，图片清晰，字迹可见）</span>
							</div>
							<div class="info control-group">
								<div style="margin-bottom: 24px;">
									<label for="license">
										法人
										<span class="info_must">*</span>
									</label>
									<span class="colon">：</span>
									<input type="text" name="legal_person" id="legal_person" class="info_s" ></div>
									<div class="info_box_qua">
										<label for="license">
											营业执照号
											<span class="info_must">*</span>
										</label>
										<span class="colon">：</span>
										<input type="text" name="business_licence_number" id="license" class="info_s" ></div>
										<div class="info_box_qua qua_r">
											<label for="license">
												有效期
												<span class="info_must">*</span>
											</label>
											<span class="colon">：</span>
											<input type="text" style="text-indent: 0;" placeholder="yy-dd-mm" id="date1" name="zzsttime" class="info_date" readonly>
											<input type="text" style="text-indent: 0;" placeholder="yy-dd-mm" id="date2" name="zzendtime" class="info_date" readonly></div>
											<div class="upload_box" style="background: none;"></div>
										</div>
										<div class="img_info info control-group" id="cert">
											<label>
												营业执照扫描件
												<span class="info_must">*</span>
											</label>
											<ul class="js-upload-image-list upload-image-list clearfix ui-sortable">
												<li class="fileinput-button js-add-image cert webuploader-container" data-type="loading">
													<div class="webuploader-pick">
														<a class="fileinput-button-icon" href="javascript:;">+上传扫描件</a>
													</div>
													<div class="webuploader-input">
														<input type="file" name="file" class="webuploader-element-invisible" accept="image/*">
														<label></label>
													</div>
												</li>
											</ul>
										</div>
										<div class="img_info info control-group" id="other">
											<label>其他证明材料</label>
											<ul class="js-upload-image-list upload-image-list clearfix ui-sortable">
												<li class="fileinput-button js-add-image other webuploader-container" data-type="loading">
													<div class="webuploader-pick">
														<a class="fileinput-button-icon" href="javascript:;">+其他证明材料</a>
													</div>
													<div class="webuploader-input">
														<input type="file" name="file" class="webuploader-element-invisible" accept="image/*">
														<label></label>
													</div>
												</li>
											</ul>
										</div>
									</div>
									<input type="hidden" name="cert" value="" id="cert_btn">
									<input type="hidden" name="other" value="" id="other_btn">
									<input type="hidden" name="newid" value="1" id="newid_btn">
									<input type="submit" value="提交" class="btn" id="submit_btn">
								</div>
							</div>
						</div>
					</form>
					<script>
					;!function(){

						laydate({

   elem: '#date1', //需显示日期的元素选择器

        event: 'click', //触发事件

        format: 'YYYY-MM-DD', //日期格式

        istime: false, //是否开启时间选择

        isclear: false, //是否显示清空

        istoday: true, //是否显示今天

        issure: true, 

        festival: false //是否显示节日

    })

					}();

					;!function(){

						laydate({

   elem: '#date2', //需显示日期的元素选择器
        event: 'click', //触发事件

        format: 'YYYY-MM-DD', //日期格式

        istime: false, //是否开启时间选择

        isclear: false, //是否显示清空

        istoday: true, //是否显示今天

        issure: true, 

        festival: false //是否显示节日

    })

					}();

					</script>

					<!--start foot-->
					<?php include display('public:footer_login');?>
					<!--end foot-->
				</body>
				</html>