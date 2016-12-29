<!-- ▼ Main container -->
<nav class="ui-nav-table clearfix">
	<ul class="pull-left js-list-filter-region">
		<li id="js-list-nav-all"  class="active">
			<a href="#all">所有积分规则</a>
		</li>

	</ul>
</nav>


<div class="widget-list">
  <div style="position:relative;" class="js-list-filter-region clearfix ui-box">
	  <div>
		  <a class="ui-btn ui-btn-primary" href="#create">新建积分规则</a>
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
.block-help>a {
  display: inline-block;
  width: 16px;
  height: 16px;
  line-height: 18px;
  border-radius: 8px;
  font-size: 12px;
  text-align: center;
  background: #bbb;
  color: #fff;
}
.block-help>a:after {
  content: "?";
}
</style>


<div class="ui-box">
	<?php
		if($points_list) {
	?>
		<table class="ui-table ui-table-list" style="padding:0px;">
			<thead class="js-list-header-region tableFloatingHeaderOriginal">
			<tr class="widget-list-header">
				<th class="cell-30 text-left">
					奖励积分
				</th>

				<th class="cell-10 text-left">
					自动给积分的条件
				</th>
				<th class="cell-10 text-left">
					状态
			
				<span class="block-help">
					<a href="javascript:void(0);" class="js-help-notes"></a>
					<div class="js-notes-cont hide">
						<p><strong>1.</strong>启用后方可赠送积分！</p>
						<p><strong>2.</strong>同等条件下,系统按照最高标准赠送积分！</p>
					</div>
				</span>
			
				</th>
				<th class="cell-10" align="right">操作</th>

			</tr>
			</thead>
			<tbody class="js-list-body-region">
			<?php foreach($points_list as $points){ ?>
				<tr class="widget-list-item">

					<td align="left"><?php echo $points['points'];?></td>
						
					<th class="cell-10 text-left">
						<?php if($points['type']=='1') {?>
							首次关注我的微信
						<?php } elseif($points['type'] == '2') {?>
							成功交易<?php echo $points['trade_or_amount'];?>笔
						<?php } elseif($points['type'] == '3') {?>
							购买金额<?php echo $points['trade_or_amount'];?>元
						<?php }?>
					</td>

					<td  class="zt cell-10 text-left">
						<?php if($points['status'] == '1') {echo "启用中";}else{echo "<font color='#f00'>已失效</font>";}?>
					</td>
					<td align="right" data="<?php echo $points['id'];?>">
						<!--  <a target="_blank" href="<?php echo dourl('list')?>&from=fans_rule&id=<?php echo $points['id']?>" class="js-show-user">查看会员</a>
						<span>-</span>
						-->
						<a href="javascript:void(0)" class=" <?php if($points['status'] == '1') {echo "js-disabled";}else{echo "js-able";}?>"><?php if($points['status'] == '1') {echo "使失效";}else{echo "使开启";}?></a>
						<span>-</span>
						<a href="#edit/<?php echo $points['id']?>" class="js-edit">编辑</a>
						<span>-</span>
						<a href="javascript:void(0);" data="<?php echo $points['id']?>" class="js-delete">删除</a>
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
<script type="text/javascript">
    var t= '';
    $(function(){
        $('.js-help-notes').hover(function(){
            $('.popover-help-notes').remove();
            var html = '<div class="js-intro-popover popover popover-help-notes bottom" style="display: none; top: ' + ($(this).offset().top + 12) + 'px; left: ' + ($(this).offset().left - 140) + 'px;"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p><strong>1：</strong>启用后方可赠送积分！</p><p><strong>2：</strong>同等条件下,按照最高标准赠送积分！</p></div></div></div>';
           

		   $('body').append(html);
            $('.popover-help-notes').show();
        }, function(){
            t = setTimeout('hide()', 200);
        })

        $('.popover-help-notes').live('mouseleave', function(){
            clearTimeout(t);
           hide();
        })

        $('.popover-help-notes').live('mouseover', function(){
            clearTimeout(t);
        })

    })

    function hide() {
        $('.popover-help-notes').remove();
    }
</script>
<div class="js-list-footer-region ui-box"></div>