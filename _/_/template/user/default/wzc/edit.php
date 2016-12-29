<style>
.error-message {color:#b94a48;}
.hide {display:none;}
.error{color:#b94a48;}
.ui-timepicker-div .ui-widget-header {margin-bottom:8px; }
.ui-timepicker-div dl {text-align:left; }
.ui-timepicker-div dl dt {height:25px;margin-bottom:-25px; }
.ui-timepicker-div dl dd {margin:0 10px10px65px; }
.ui-timepicker-div td {font-size:90%; }
.ui-tpicker-grid-label {background:none;border:none;margin:0;padding:0; }
.controls .ico li .checkico {width: 50px;height: 54px;display: block;}
.controls .ico li .avatar {width: auto; height: auto;max-height: 50px;max-width: 50px;display: inline-block;}
.no-selected-style i {display: none;}
.icon-ok {background-position: -288px 0;}
.module-goods-list li img, .app-image-list li img {height: 100%;width: 100%;}
.tequan {width: 100%;min-height: 60px;line-height: 60px;}
.controls .input-prepend .add-on { margin-top: 5px;}
.controls .input-prepend input {border-radius:0px 5px 5px 0px}
.control-group table.reward-table{width:85%;}
.tequan li{float:left;width:30%;text-align:left;margin-left:3%;}
.form-horizontal .control-label{width:150px;}
.form-horizontal .controls{margin-left:0px;}
.controls  .renshu .add-on{margin-left:-3px;border-radius:0 4px 4px 0;}
.js-condition {height:35px;}

.controls .chose-label { height: 28px; line-height: 28px; float: left; margin-right: 20px; }
</style>
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有</a>
		</li>
		<li id="js-list-nav-apply" <?php echo $type == 'apply' ? 'class="active"' : '' ?>>
			<a href="#apply">申请中</a>
		</li>
		<li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
			<a href="#future">预热中</a>
		</li>
		<li id="js-list-nav-on" <?php echo $type == 'on' ? 'class="active"' : '' ?>>
			<a href="#on">进行中</a>
		</li>
		<li id="js-list-nav-end" <?php echo $type == 'end' ? 'class="active"' : '' ?>>
			<a href="#end">已结束</a>
		</li>
	</ul>
</nav>
<nav class="ui-nav clearfix">
	<ul class="pull-left">
		<li id="js-list-nav-all" class="active">
			<a href="javascript:">新增活动</a>
		</li>
	</ul>
</nav>
<style type="text/css">
.laberA a.cur {background: #f35858;color: #fff;}
.huibao label{display: initial;}
#productDetails{float: left}
</style>
<div class="app-design-wrap">
	<div class="page-presale clearfix">
		<div class="app-presale app-reward">
			<form class="form-horizontal" id="myformaaaaaaa">
				<div class="presale-info">
					<div class="js-basic-info-region">
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>标签：
							</label>
							<div class="controls laberA">
				                            <?php
				                            $label = !empty($proInfo['label']) ? explode(',',$proInfo['label'] ) : array();
				                            if(!empty($productConfig['productLabel'])){
				                            foreach($productConfig['productLabel'] as $k=>$v){
				                            ?>
				                                <a href="javascript:changetag('<?php echo $k;?>','<?php echo $k;?>');" id="tagId_<?php echo $k?>" title="<?php echo $v;?>" value="<?php echo $v;?>"  <?php echo in_array($k, $label) ? 'class="cur"' : ''; ?>  ><?php echo $v?></a>
				                                <input type="hidden" name="tagID[]" id="choosetag_<?php echo $k;?>" value="<?php echo in_array($k, $label) ? $k : ''; ?>" class="choosetag">
				                            <?php }  }?>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>回报类型：
							</label>
							<div class="controls">
								<div class="huibao">
									<label for="productNormal">回报众筹</label>
									<input id="productNormal" type="radio" name="productType" value="1"  <?php echo $proInfo['productType']==1 ? 'checked' :''; ?> />
									<label for="productFree">公益捐助众筹</label>
									<input id="productFree"  type="radio" name="productType" value="2"  <?php echo $proInfo['productType']==2 ? 'checked' :''; ?>  />
								</div>

							</div>
						</div>
						<div class="control-group">

							<label class="control-label">
								<em class="required"> * </em>活动名称：
							</label>
							<div class="controls">
								<input type="text" name="info[productName]" value="<?php echo $proInfo['productName']; ?>" id="productName" placeholder="请填写活动名称" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<!-- <div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>活动分类：<?php echo $proInfo['class']; ?>
							</label>
							<div class="controls">
								<select name="info[class]" id="selectClass">
								    <option value="0">请选择分类</option>
						                    <?php foreach ($product_class as $k => $v) {  ?>
						                        <option value="<?php echo $v['id'] ?>"  <?php echo $proInfo['class']==$v['id'] ? 'selected' :''; ?>  ><?php echo $v['name']; ?></option>
						                    <?php } ?>
								</select>
							</div>
						</div> -->
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>一句话说明：
							</label>
							<div class="controls">
								<input type="text" name="info[productAdWord]" value="<?php echo $proInfo['productAdWord']; ?>" id="productAdWord" placeholder="请填写一句话说明" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group" id="targetAmount" style="<?php echo $proInfo['raiseType']==1 ? 'display: none;' : ''; ?>">
							<label class="control-label">
								<em class="required"> * </em>筹资金额：
							</label>
							<div class="controls">
								<input type="text" name="info[amount]" value="<?php echo $proInfo['amount']; ?>" id="amount" placeholder="不少于XX元" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group" id="productTopLimit" style="<?php echo $proInfo['raiseType']==1 ? 'display: none;' : ''; ?>">
							<label class="control-label">
								<em class="required"> * </em>筹资上限：
							</label>
							<div class="controls">
								<input type="text" name="info[toplimit]" value="<?php echo $proInfo['toplimit']; ?>" id="toplimit" placeholder="不少于100%" style="width: 300px;" />
								<em class="error-message"></em>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> * </em>筹资天数：
							</label>
							<div class="controls">
								<input type="radio" name="raiseType" value="0"  id="radNormal"  <?php echo $proInfo['raiseType']==0 ? 'checked' :''; ?>/>普通
								<input type="text"  name="collectDays"   value="<?php echo $proInfo['collectDays']; ?>"  placeholder="10~60 天" style="width: 80px;<?php echo $proInfo['raiseType']==1 ? 'display: none;' : ''; ?>" id="collectDays" />
								<input type="radio" name="raiseType" value="1"  id="radForever" <?php echo $proInfo['raiseType']==1 ? 'checked' :''; ?>/>筹 ∞
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">
								<em class="required"> *</em>上传预热图片：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-logo">
									<li class="sort">
										<a href="javascript:void(0)" target="_blank"><img src="<?php echo getAttachmentUrl($proInfo['productThumImage']); ?>"></a>
										<a class="js-delete-picture close-modal small hide">×</a></li>
									<li style="display: none;">
										<a href="javascript:;" class="add-goods js-add-logo" classname="productThumImage">上传</a>
										<input type="hidden" name="info[productThumImage]" value="<?php echo $proInfo['productThumImage']; ?>" id="productThumImage">
									</li>

								</ul>
							</div>
						</div>
						<div class="control-group">
							<input type="hidden" name="product_id" value="0">
							<input type="hidden" name="sku_id" value="0">
							<label class="control-label">
								<em class="required"> *</em>上传列表页图片：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product" data-product_id="0">
									<li class="sort"><a href="javascript:void(0)" target="_blank"><img src="<?php echo getAttachmentUrl($proInfo['productListImg']); ?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
									<li style="display: none;">
									<a href="javascript:;" class="add-goods js-add-logo-list" classname="productListImg">上传</a>
									<input type="hidden" name="info[productListImg]" value="<?php echo $proInfo['productListImg']; ?>" id="productListImg">
									</li>
								</ul>
							</div>
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
						<div class="control-group">
							<input type="hidden" name="product_id" value="0">
							<input type="hidden" name="sku_id" value="0">
							<label class="control-label">
								<em class="required"> *</em>上传首页图片：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product" data-product_id="0">
									<li class="sort"><a href="javascript:void(0)" target="_blank"><img src="<?php echo getAttachmentUrl($proInfo['productFirstImg']); ?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
									<li style="display: none;">
									<a href="javascript:;" class="add-goods js-add-logo-list" classname="productFirstImg">上传</a>
									<input type="hidden" name="info[productFirstImg]" value="<?php echo $proInfo['productFirstImg']; ?>" id="productFirstImg">
									</li>
								</ul>
							</div>
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
						<div class="control-group">
							<input type="hidden" name="product_id" value="0">
							<input type="hidden" name="sku_id" value="0">
							<label class="control-label">
								<em class="required"> *</em>上传活动封面：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product" data-product_id="0">
									<li class="sort"><a href="javascript:void(0)" target="_blank"><img src="<?php echo getAttachmentUrl($proInfo['productImage']); ?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
									<li style="display: none;">
									<a href="javascript:;" class="add-goods js-add-logo-list" classname="productImage">上传</a>
									<input type="hidden" name="info[productImage]" value="<?php echo $proInfo['productImage']; ?>" id="productImage">
									</li>
								</ul>
							</div>
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
						<div class="control-group">
							<input type="hidden" name="product_id" value="0">
							<input type="hidden" name="sku_id" value="0">
							<label class="control-label">
								<em class="required"> *</em>上传移动端图片：
							</label>
							<div class="controls">
								<ul class="ico app-image-list js-product" data-product_id="0">
									<li class="sort"><a href="javascript:void(0)" target="_blank"><img src="<?php echo getAttachmentUrl($proInfo['productImageMobile']); ?>"></a><a class="js-delete-picture close-modal small hide">×</a></li>
									<li style="display: none;">
									<a href="javascript:;" class="add-goods js-add-logo-list" classname="productImageMobile">上传</a>
									<input type="hidden" name="info[productImageMobile]" value="<?php echo $proInfo['productImageMobile']; ?>" id="productImageMobile">
									</li>
								</ul>
							</div>
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>视频介绍：
						</label>
						<div class="controls">
							<input type="text" name="info[videoAddr]" value="<?php echo $proInfo['videoAddr']; ?>" style="width: 300px;" id="videoAddr" />
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>项目简介：
						</label>
						<div class="controls">
							<textarea rows="2" cols="30" style="width:65%" name="info[productSummary]" class="descript" id="productSummary"><?php echo $proInfo['productSummary']; ?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>项目详情：
						</label>
						<div class="controls">
						<script id="productDetails" name="info[productDetails]" type="text/plain"></script>
						<!-- <textarea id="productDetails" rows="2" cols="30" style="width:65%" name="info[productDetails]" class="descript" ></textarea> -->
						</div>
					</div>
					<script>
					var uf = UE.getEditor('productDetails',{
					    initialFrameWidth:600,
					    initialFrameHeight:200
					});
					</script>
					<hr>
					<h3>发起人信息</h3>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>自我介绍：
						</label>
						<div class="controls">
							<input type="text" id="introduce" name="sponsor[introduce]" value="<?php echo $sponsorInfo['introduce'] ?>" style="width: 300px;" />
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>详细自我介绍：
						</label>
						<div class="controls">
							<textarea id="sponsorDetails" name="sponsor[sponsorDetails]" placeHolder="向支持者详细介绍你自己或你的团队，并详细说明你与所发起的项目之间的背景，让支持者能够在最短时间内了解你，以拉近彼此之间的距离，不可超过160字。" class="textA490_1" style="width: 65%;"><?php echo $sponsorInfo['sponsorDetails'] ?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>微博/博客地址：
						</label>
						<div class="controls">
							<input type="text" name="sponsor[weiBo]" value="<?php echo $sponsorInfo['weiBo'] ?>" style="width: 300px;" id="weiBo"/>
							<span style="padding-top: 5px; color: red;">
							</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> *</em>感谢信：
						</label>
						<div class="controls">
                        				<textarea id="thankMess" name="sponsor[thankMess]" placeHolder="" class="textA490_1" style="width: 65%;"><?php echo $sponsorInfo['thankMess'] ?></textarea>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">
							<em class="required"> </em>联系电话：
						</label>
						<div class="controls">
                       					<input id="sponsorPhone" name="sponsor[sponsorPhone]" value="<?php echo $sponsorInfo['sponsorPhone']; ?>" placeHolder="此信息不会显示在发起人详情页中" type="text" class="inp490" style="width: 300px;"/>
						</div>
					</div>
				</div>
				<input  type="hidden" name="product_id" id="product_id" value="<?php echo $proInfo['product_id']; ?>" />
			</form>
			<div class="app-design">
				<div class="app-actions">
					<div class="form-actions text-center">
						<input class="btn js-btn-quit" type="button" value="取 消" />
						<input class="btn btn-primary js-create-save" type="button" value="保存" data-loading-text="保 存..." to="false" />
					</div>
				</div>
			</div>
			<script type="text/javascript">
			uf.ready(function() {
				uf.setContent('<?php echo $proInfo["productDetails"];?>');
			});
			</script>
		</div>
	</div>

</div>