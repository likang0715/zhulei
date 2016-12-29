<include file="Public:header"/>
<script type="text/javascript" src="{pigcms{$static_public}js/layer/layer.min.js"></script>
<style type="text/css">
.c-gray { color: #999; }
.table-list tfoot tr { height: 40px; }
.green { color: green; }
.cursor{cursor:pointer}
a, a:hover { text-decoration: none; }
.input_sort{border-color: #a0a0a0 #cad9ea #cad9ea #a0a0a0;border-width: 1px;font-size: 9pt;height: 18px;padding:2px;}
.input_button{border-radius: 5px;background: #369 none repeat scroll 0 0;border: 2px solid #efefef;color: #fff;cursor: pointer;font-size: 12px;font-weight: 700;height: 26px;line-height: 21px;text-align: center;width: 55px;} 
</style>
<script type="text/javascript">
            $(function() {
                $('.status-enable > .cb-enable').click(function(){
                    if (!$(this).hasClass('selected') && parseFloat($(this).data('status')) == 1) {
                        var url = window.location.href;
                        var cat_id = $(this).data('id');
                        $.post("<?php echo U('Product/category_status'); ?>",{'status': 1, 'cat_id': cat_id}, function(data){
                            window.location.href = url;
                        })
                    }
                    if (parseFloat($(this).data('status')) == 0) {
                        $(this).removeClass('selected');
                    }
                    return false;
                })
                $('.status-disable > .cb-disable').click(function(){
                    if (!$(this).hasClass('selected') && parseFloat($(this).data('status')) == 1) {
                        var url = window.location.href;
                        var cat_id = $(this).data('id');
                        if (!$(this).hasClass('selected')) {
                            $.post("<?php echo U('Product/category_status'); ?>", {'status': 0, 'cat_id': cat_id}, function (data) {
                                window.location.href = url;
                            })
                        }
                    }
                    return false;
                })
				var click_status = true
                $(".input_button").click(function(){
            		var idvalue = "";
            		var pidvalue = "";
					if(click_status) {
						click_status=false;

						$('.cat_ids').each(function() {
							idvalue += $(this).val() + ','
						});
						$('input[name="sorts"]').each(function() {
							pidvalue += $(this).val() + ','
						});
						var valuearray = 'id_str=' + idvalue + '&sort_str=' + pidvalue;
					
						$.layer({
							shade: [0],
							area: ['auto','auto'],
							dialog: {
								msg: '确认批量排序么？',
								btns: 2,                    
								type: 4,
								btn: ['确定','取消'],
								yes: function(){	
									click_status = true;
									$.ajax({
										type: "POST",
										async: false,
										dataType:"json",
										url: "<?php echo U('Product/set_type_sort'); ?>",
										data: valuearray,
										success: function(data) {
											layer.alert(data.msg);
										}
									})
						        }, no: function(){
						        	click_status = true;
						        }
						    }
						});

						
					}
                	
					
                })
            })
        </script>
<div class="mainbox">
	<div id="nav" class="mainnav_title">
		<ul>
			<a href="{pigcms{:U('Product/category')}" class="on">商品分类</a>| <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product/category_add')}','添加分类',600,500,true,false,false,addbtn,'add',true);">添加分类</a>
		</ul>
	</div>
	<table class="search_table" width="100%">
		<tr>
			<td><form action="{pigcms{:U('Product/category')}" method="get">
					<input type="hidden" name="c" value="Product"/>
					<input type="hidden" name="a" value="category"/>
					筛选:
					<select name="cat_id">
						<option value="0">商品类目</option>
						<volist name="all_categories" id="all_category">
						<option <if condition="$Think.get.cat_id eq $all_category['cat_id']">selected</if>  value="{pigcms{$all_category['cat_id']}">
							<?php if ($all_category['cat_level'] > 1){ echo str_repeat('&nbsp;&nbsp;', $all_category['cat_level']); } ?>
							 |-- {pigcms{$all_category.cat_name}
							</option>
						</volist>
					</select>
					<input type="submit" value="查询" class="button"/>
				</form>
			</td>
		</tr>
	</table>
	<div class="table-list">
		<table width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>删除 | 修改</th>
					<th>编号</th>
					<th>名称</th>
					<th>描述</th>
					<th>状态</th>
					<th style="text-align:center">排序 <input class="input_button" type="button" value="排序">
					<img title="商品分类显示规则: 1.按照先排序值升序，再编号升序排列" class="tips_img cursor" src="./source/tp/Project/tpl/Static/images/help.gif">
					</th>
					<th class="textcenter" width="100">操作</th>
				</tr>
			</thead>
			<tbody>
				<if condition="is_array($categories)"> 
					<!-- <volist name="categories" id="category">
                                <tr>
                                    <td><a url="<?php echo U('Product/category_del', array('id' => $category['cat_id'])); ?>"  class="delete_row"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product/category_edit', array('id' => $category['cat_id']))}','修改分类 - {pigcms{$category.cat_name}',540,<if condition="$category['cat_pic']">500<else/>500</if>,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
                                    <td>{pigcms{$category.cat_id}</td>
                                    <td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product/category_edit', array('id' => $category['cat_id']))}','修改分类 - {pigcms{$category.cat_name}',540,<if condition="$category['cat_pic']">500<else/>500</if>,true,false,false,editbtn,'edit',true);"><?php if ($category['cat_level'] > 1){ echo str_repeat('|——', $category['cat_level']); } ?> <span <?php if ($category['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$category.cat_name}</span></a></td>
                                    <td>{pigcms{$category.cat_desc}</td>
                                    <td>
                                        <if condition="$category['cat_status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if>
                                    </td>
                                    <td>{pigcms{$category.cat_sort}
                                 
                                    </td>
                                    <td>
                                        <span class="cb-enable status-enable"><label class="cb-enable <if condition="$category['cat_status'] eq 1">selected</if>" data-id="<?php echo $category['cat_id']; ?>" data-status="{pigcms{$category.cat_parent_status}"><span>启用</span><input type="radio" name="status" value="1" <if condition="$category['cat_id'] eq 1">checked="checked"</if> /></label></span>
                                        <span class="cb-disable status-disable"><label class="cb-disable <if condition="$category['cat_status'] eq 0">selected</if>" data-id="<?php echo $category['cat_id']; ?>" data-status="{pigcms{$category.cat_parent_status}"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$category['cat_id'] eq 0">checked="checked"</if>/></label></span>
                                    </td>
                                </tr>
                            </volist>-->
                            
					<volist name="categories2" id="category">
						<tr>
							<td><a url="<?php echo U('Product/category_del', array('id' => $category['cat_id'])); ?>"  class="delete_row"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product/category_edit', array('id' => $category['cat_id']))}','修改分类 - {pigcms{$category.cat_name}',540,<if condition="$category['cat_pic']">500<else/>500</if>,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
							<td>{pigcms{$category.cat_id}</td>
							<td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product/category_edit', array('id' => $category['cat_id']))}','修改分类 - {pigcms{$category.cat_name}',600,<if condition="$category['cat_pic']">500<else/>500</if>,true,false,false,editbtn,'edit',true);"><?php if ($category['cat_level'] > 1){ echo str_repeat('|——', $category['cat_level']); } ?> <span <?php if ($category['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$category.cat_name}</span></a></td>
							<td>{pigcms{$category.cat_desc}</td>
							<td><span class="green"><if condition="$category['cat_status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if></span></td>
							<td style="text-align:center">
								<!--  <input style="width:80px;" type="text" value="{pigcms{$category.cat_sort}">-->
									<input size=2 maxlength=3 type="text" name="sorts" value="{pigcms{$category.cat_sort}" class="input_sort">
									<input type="hidden" class="cat_ids" value="{pigcms{$category.cat_id}">
								</td>
							<td>
								<span class="cb-enable status-enable"><label class="cb-enable <if condition="$category['cat_status'] eq 1">selected</if>" data-id="<?php echo $category['cat_id']; ?>" data-status="{pigcms{$category.cat_parent_status}"><span>启用</span><input type="radio" name="status" value="1" <if condition="$category['cat_id'] eq 1">checked="checked"</if> /></label></span>
								<span class="cb-disable status-disable"><label class="cb-disable <if condition="$category['cat_status'] eq 0">selected</if>" data-id="<?php echo $category['cat_id']; ?>" data-status="{pigcms{$category.cat_parent_status}"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$category['cat_id'] eq 0">checked="checked"</if>/></label></span>
							</td>
						</tr>
						
						<volist name="category['children']" id="child">
						
						<tr>
							<td><a url="<?php echo U('Product/category_del', array('id' => $child['cat_id'])); ?>"  class="delete_row"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product/category_edit', array('id' => $child['cat_id']))}','修改分类 - {pigcms{$child.cat_name}',540,<if condition="$child['cat_pic']">500<else/>500</if>,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
							<td>{pigcms{$child.cat_id}</td>
							<td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product/category_edit', array('id' => $child['cat_id']))}','修改分类 - {pigcms{$child.cat_name}',600,<if condition="$child['cat_pic']">500<else/>500</if>,true,false,false,editbtn,'edit',true);"><?php if ($child['cat_level'] > 1){ echo str_repeat('|——', $child['cat_level']); } ?> <span <?php if ($child['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$child.cat_name}</span></a></td>
							<td>{pigcms{$child.cat_desc}</td>
							<td><span class="green"><if condition="$child['cat_status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if></span></td>
							<td style="text-align:center">
							<input size=2 maxlength=3 type="text" name="sorts" value="{pigcms{$child.cat_sort}" class="input_sort">
							<input type="hidden" class="cat_ids" value="{pigcms{$child.cat_id}">
							</td>
							
							<td>
								<span class="cb-enable status-enable"><label class="cb-enable <if condition="$child['cat_status'] eq 1">selected</if>" data-id="<?php echo $child['cat_id']; ?>" data-status="{pigcms{$child.cat_parent_status}"><span>启用</span><input type="radio" name="status" value="1" <if condition="$child['cat_id'] eq 1">checked="checked"</if> /></label></span>
								<span class="cb-disable status-disable"><label class="cb-disable <if condition="$child['cat_status'] eq 0">selected</if>" data-id="<?php echo $child['cat_id']; ?>" data-status="{pigcms{$child.cat_parent_status}"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$child['cat_id'] eq 0">checked="checked"</if>/></label></span>
							</td>
						</tr>
						</volist>
					</volist>
				</if>
			</tbody>
			<tfoot>
				<if condition="is_array($categories)">
					<tr>
						<!--  <td class="textcenter pagebar" colspan="7">{pigcms{$page}</td>-->
					</tr>
					<else/>
					<tr>
						<td class="textcenter red" colspan="7">列表为空！</td>
					</tr>
				</if>
			</tfoot>
		</table>
	</div>
</div>
<include file="Public:footer"/>