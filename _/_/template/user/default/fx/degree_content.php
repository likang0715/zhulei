<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
			<a href="#all">所有等级标签</a>
		</li>
	</ul>
</nav>

<div class="widget-list">
  <div style="position:relative;" class="js-list-filter-region clearfix ui-box">
	  <div>
		  <a class="ui-btn ui-btn-primary" href="#create">新建等级标签</a>
		  <!--  <a class="ui-btn ui-btn-primary2 downloadtag" target="_blank" href="<?php echo dourl("tag_download_csv");?>"></a>-->
		  <div class="js-list-search ui-search-box">
			  <input type="text" value="<?php echo $keyword;?>" placeholder="搜索" class="txt js-coupon-keyword">
		  </div>
	  </div>
  </div>
</div>
<style>
.ui-table-list .fans-box .fans-avatar {float: left;width: 60px;height: 60px;background: #eee;overflow: hidden;}
.ui-table-list .fans-box .fans-avatar img {width: 60px;height: auto;}
.ui-table-list .fans-box .fans-msg {float: left;}
.ui-table-list .fans-box .fans-msg p {padding: 0 5px;text-align: left;}
</style>
<div class="ui-box">
	<?php
	if($degree_list) {
		?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr class="widget-list-header"><th class="cell-10 text-left">
					等级标签名
				</th>

				<th class="cell-10">
					等级分润提升百分比
				</th>
				<th class="cell-10">
					等级值
				</th>
				<th class="cell-10">
					等级图标
				</th>
			
				<th class="cell-10">
					会员等级须知
				</th>
				<th class="cell-10">
					状态
				</th>
				
				<th class="cell-10"  align="right">
					操作
				</th>

			</tr>
			</thead>
			<tbody class="js-list-body-region">
			<?php foreach($degree_list as $v){ ?>
				<tr class="widget-list-item" data-id="<?php echo $v['pigcms_id']?>">
					<td>
						<?php if($v['is_platform_degree_name']=='0') {?>
							<?php echo $v['degree_alias'];?>
						<?php } else {?>
							<?php echo $sys_drp_degree[$v['is_platform_degree_name']]['name'];?>
						<?php }?>
					</td>
					<!--  
						<td>0</td>
						<td>0</td>
					-->
					<td>
						<?php if($v['seller_reward_1'] ){?>
							<font color="#f00">直销利润提升百分比：<?php echo $v['seller_reward_1'];?></font><br/>
						<?php }?>
						
						<?php if($v['seller_reward_2'] ){?>
							<font color="#07d">获取下级利润提升百分比：<?php echo $v['seller_reward_2'];?></font><br/>
						<?php }?>
						
						<?php if($v['seller_reward_3'] ){?>
							<font color="#0AC949">获取下下级利润提升百分比：<?php echo $v['seller_reward_3'];?></font>
						<?php }?>
					</td>
					
					<td><?php echo $v['value'];?></td>
					<td>
						<?php if($v['is_platform_degree_icon']=='0') {?>
							<img style="max-height:50px;max-weight:45px"  src="<?php echo $v['degree_icon_custom'];?>" >
						<?php }else{?>
							<img style="max-height:50px;max-weight:45px" src="<?php echo  $sys_drp_degree[$v['is_platform_degree_icon']]['icon'];?>" >
						<?php }?>
					</td>
					
					
					<td><?php echo msubstr($v['description'],0,10);?> <br/>【<a href="javascript:void(0)" class="show_more" data="<?php echo $v['description'];?>">点击查看更多</a>】</td>
					<td><span class="zt"><?php if($v['status'] ==1) {?>启用中<?php }else {?><font color="#f00">失效中</font><?php }?></span></td>
					<td align="right">
						<?php if($v['status'] == '1') {?>
							<a href="javascript:void(0)"  class="js-disabled open_or_close">使失效</a>
						<?php } else {?>
							<a href="javascript:void(0)"  class="js-able open_or_close">使开启</a>
						<?php }?>
						<span>-</span>
						<a href="#edit/<?php echo $v['pigcms_id']?>" class="js-edit">编辑</a>
						<span>-</span>
						<a href="javascript:void(0);" data="<?php echo $v['pigcms_id']?>"  class="js-delete">删除</a>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>


		<div class="js-list-footer-region ui-box">
			<div>
				<div class="pagenavi js-page-list"><?php echo $pages;?></div>
			</div>
		</div>
	<?php
	}else{
		?>
		<div class="js-list-empty-region">
			<div>
				<div class="no-result widget-list-empty">还没有相关数据。</div>
			</div>
		</div>
	<?php
	}
	?>
</div>

<div class="js-list-footer-region ui-box"></div>