<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all"  class="active">
			<a href="<?php dourl('fx:degree'); ?>">所有等级标签</a>
		</li>
	</ul>
</nav>
<div class="app-design-wrap">
<div class="app-design clearfix without-add-region"><div class="page-tradeincard">


<style>
.app-fans-points-edit .checkbox {
	color: #999;
	margin-left: 16px;
}
button, input, label, select, textarea {
	font-size: 14px;
	font-weight: 400;
	line-height: 20px;
	font-family:Helvetica,STHeiti,"Microsoft YaHei",Verdana,Arial,Tahoma,sans-serif;
}
.input-append .add-on, .input-append .btn, .input-append .btn-group{margin-left:-3px;}
 .avatar img{width:50px;height:50px;}

.hyname {width:90%;height:auto;display:inline-block}
.hyname li{float:left;width:30%;height:25px;line-height:25px;}
.control-group.error .input-append .add-on, .control-group.error .input-prepend .add-on {
  color: #b94a48;
  background-color: #f2dede;
  border-color: #b94a48;
}
.form-horizontal .control-label{width:140px;}
.form-horizontal .controls{margin-left:155px;}
</style>


	
<div class="app__content">
		<form class="js-page-form form-horizontal ui-form" method="POST" novalidate="novalidate">
			<div class="control-group">
				<label class="control-label"><em class="required">*</em>
					会员标签名称</label>
				<div class="controls">

					<ul class="hyname">
					<?php foreach($degree as $k=>$v) {?>
						<li><input type="radio" name="degree_id" class="js-degree_id" value="<?php echo $v['pigcms_id']?>" id="degree_<?php echo $v['pigcms_id']; ?>" />&nbsp;<label for="degree_<?php echo $v['pigcms_id']; ?>" style="display: inline;"><?php echo $v['name'];?></label></li>
						
					<?php }?>
					
						<?php if('1'===$is_allow_diy_drp_degree) {?>
						<li><input type="radio" name="degree_id" class="js-degree_id" value="now" id="degree_now" />&nbsp;<input type="text"  name="now_degree_name" value="" style="width:90px;"></li>
						<?php }?>
					</ul>	
				</div>
			</div>
			
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required">*</em>等级值</label>
				<div class="controls">
					<input type="text" id="level_num" name="level_num" value="" placeholder="请输入数字" style="width:100px;">
					<p class="help-desc">值越大等级越高。</p>
				</div>
			</div>


	<style>
	<!--
	 .selected-style { position: absolute;left: 0; top: 0;border: 2px solid #09F;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box; display:inline-block;}
	 .selected-style:after { position: absolute;display: block;content: ' ';right: 0px; bottom: 0px;border: 14px solid #09f; border-left-color: transparent; border-top-color: transparent;}
	.selected-style i { position: absolute; right: 1px; bottom: 1px; z-index: 2; }
	.selected-styles{position:relative;float:left;width:51px;height:41px;}
	-->
	.controls .help-desc{clear:both;}
	.controls .help-desc a{color:#07d}
	.controls .ico li{float:left;width:54px;display:inline-block;height:55px;cursor:pointer}
	.controls .ico li .avatar{height:50px;width:50px;50px;display:inline-block}
	.ico .spans{position:relative}
	.no-selected-style i{display:none;}
	.app-image-list .other_li{background:none;border:0px;}
	</style>		
		<div class="control-group">
			<!--  <label class="control-label">或</label>-->
			<label class="control-label"><em class="required">*</em>等级图标</label>
				<div class="controls">
					<ul class="ico app-image-list js-ico-list">

						<?php foreach($degree as $k=>$v) {?>

							<li class="other_li sort">
								<div class="spans">
									<span class="checkico no-selected-style"><i class="icon-ok icon-white"></i>
									<img data-type='<?php echo $v['pigcms_id']?>' id="degree_icon_<?php echo $v['pigcms_id']; ?>" class="avatar" style="max-height:50px;width:auto;height:auto;" src="<?php echo $v['icon'];?>">
									</span>
								</div>
							</li>

						
						<?php }?>
						
						<?php if(preg_match('/^images\//',$degree['degree_icon_custom'])) {?>
									
							<li class="sort">
								<div class="spans">
									<span class="checkico selected-style">
										<i class="icon-ok icon-white"></i>
										<img src="<?php echo getAttachmentUrl($degree['degree_icon_custom']);?>" class="avatar">
									</span>
									<a class="js-delete-picture close-modal small hide">×</a></div></li>
						<?php }?>
						
						<?php if('1' === $is_allow_diy_drp_degree) {?>
							<li>  <a href="javascript:;" class="add-goods js-add-picture">+加图</a>  </li>
						<?php }?>
					</ul>
					<br/>	
					
					<?php if('1' === $is_allow_diy_drp_degree) {?>
						<p class="help-desc">如需增加可选的分销等级图标，请 <b><a href="javascript:" class="js-add-picture">点击</a></b> 更新。</p>
					<?php }?>
				</div>
			</div>
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required">*</em>达标条件</label>
				<div class="controls">
					<span class="help-inline">积分达到</span> <input type="text" name="points_limit" class="input-mini for-post" value="">
				
					<p class="help-desc">* 达标自动升级，若积分不够则降低等级。<br/><br/>* 若达标积分设置为0则为默认等级（默认等级唯一性）</p>
				</div>
					
			</div>	
			
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label">直销利润<br/>提升百分比</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" id="discount" name="seller_reward_3" value="" placeholder="请输入比例" style="width:73px;"><span class="add-on">%</span>
					</div>

					<p class="help-desc">留空，为不提升。</p>
				</div>
			</div>
			
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label">获取下级<br/>分润提升百分比</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" id="discount" name="seller_reward_2" value="" placeholder="请输入比例" style="width:73px;"><span class="add-on">%</span>
					</div>

					<p class="help-desc">留空，为不提升。</p>
				</div>
			</div>
			
			
			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label">获取下下级<br/>分润提升百分比</label>
				<div class="controls">
					<div class="input-append">
						<input type="text" id="discount" name="seller_reward_1" value="" placeholder="请输入比例" style="width:73px;"><span class="add-on">%</span>
					</div>

					<p class="help-desc">留空，为不提升。</p>
				</div>
			</div>
			
			

		
			<div class="control-group">
				<label class="control-label"><b>会员等级详情</b></label>
			</div>	

			<div class="control-group">
				<!--  <label class="control-label">或</label>-->
				<label class="control-label"><em class="required">*</em>使用须知</label>
				<div class="controls">
					<textarea id="description" class="description"   style="width:65%" name="description" cols="55" rows="4" placeholder="最多可输入200个字符，简述相关分销等级信息，以便分销商知晓。" maxlength="600"></textarea>
				</div>
			</div>			
			<div class="form-actions">
				<input class="btn btn-primary js-btn-add-save" type="button" value="保 存" data-loading-text="保 存...">
				<input type="button" class="btn btn-defaults js-btn-quit" value="返回" >
			</div>
		</form>
	</div>
</div>
</div>
</form>
		</div>



	</div>
</div>
