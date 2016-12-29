<div>
    <div class="js-list-filter-region clearfix ui-box" style="position:relative;">
        <div>
			<a href="#create" class="ui-btn ui-btn-primary">新建店铺动态</a>
            <div class="js-list-search ui-search-box">
                <input class="txt js-wei_page_txt" type="text" placeholder="搜索" value="">
            </div>
        </div>
    </div>
    <div class="ui-box">
					<table class="ui-table ui-table-list" style="padding:0px;">
				<thead class="js-list-header-region tableFloatingHeaderOriginal">
					<tr>
						<th class="cell-40">标题</th>
						<th class="cell-20"><a href="javascript:;" data-orderby="feature_count">关联商品</a></th>
						<th class="cell-15"><a href="javascript:;" data-orderby="created_time">发布时间<span class="orderby-arrow desc"></span></a></th>
						<th class="cell-10">状态</th>
						<th class="text-right">操作</th>
					</tr>
				</thead>
				<tbody class="js-list-body-region">
				<?php foreach($article_lists as $article){?>
						<tr id="tr_<?php echo $article['id']?>" cate_id="<?php echo $article['id']?>">
							<td>
								<a href="#" target="_blank" class="new-window"><?php echo $article['title']?></a>
							</td>
							<td><?php echo $article['product_name']?></td>
							<td><?php echo date('Y-m-d H:i:s',$article['dateline'])?></td>
							<td><?php echo $article['status']==0?'<span style="color:#ff0000">草稿</span>':'<span style="color:green">已发布</span>'?></td>
							<td class="text-right">
								<a href="javascript:void(0);" class="js-copy-link">链接</a>
								<span>-</span>
								<a href="#edit/<?php echo $article['id']?>">编辑</a>
								<span>-</span>
								<a href="javascript:void(0);" class="js-delete">删除</a>
							</td>
						</tr>
				<?php }?>
				</tbody>
			</table>
		    </div>
    <div class="js-list-footer-region ui-box">
        <div>
            <div class="pagenavi js-page-list"><span class="total">共 1 条，每页 15 条</span> </div>
        </div>
    </div>
</div>