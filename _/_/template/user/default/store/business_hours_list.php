 <div class="app-preview">
 	<nav class="ui-nav">
        <ul>
            <li class="js-list-index active"><a href="javascript:void(0);">营业时间列表</a></li>
        </ul>
    </nav>
    <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
			<a href="<?php dourl('business_hours'); ?>#create" class="ui-btn ui-btn-primary bind_qrcode">添加营业时间</a>
        </div>
    </div>
    
    <div class="ui-box">
		<?php if($time_list){ ?>
			<table class="ui-table ui-table-list" style="padding:0px;">
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr>
						<th class="cell-20"><a href="javascript:;" data-orderby="feature_count">营业时间段</a></th>
						<th class="text-right">操作</th>
					</tr>
				</thead>
				<tbody class="js-list-body-region">
					<?php foreach($time_list as $value){ ?>
						<tr cat-id="<?php echo $value['id']?>">
							<td><?php echo $value['business_time'];?></td>
							<td class="text-right">
								<a href="javascript:void(0)" style=" color:red" class="js_open" sid="<?php echo $value['id']?>"><?php if($value['is_open']){?>关闭<?php }else{ ?>开启<?php } ?></a>
								<span>-</span>
								<a href="#edit/<?php echo $value['id']?>">编辑</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete" sid="<?php echo $value['id']?>">删除</a>
								
								
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php }else{ ?>
			<div class="js-list-empty-region"></div>
		<?php } ?>
    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <div class="pagenavi js-page-list"><?php echo $group_list['page'];?></div>
        </div>
    </div>
</div>