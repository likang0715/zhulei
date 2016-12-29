<include file="Public:header"/>
        <style type="text/css">
            .c-gray {
                color: #999;
            }
            .table-list tfoot tr {
                height: 40px;
            }
            .green {
                color: green;
            }
            a, a:hover{
                text-decoration: none;
            }
            .click_show{color: #498CD0;}
        </style>
<script type="text/javascript">
	$(function() {
		$('.status-enable > .cb-enable').click(function(){
			if (!$(this).hasClass('selected') ) {
				var url = window.location.href;
				var pid = $(this).data('id');
				$.post("<?php echo U('Sys_product_property/property_status'); ?>",{'status': 1, 'pid': pid}, function(data){
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
				var pid = $(this).data('id');
				if (!$(this).hasClass('selected')) {
					$.post("<?php echo U('Sys_product_property/property_status'); ?>", {'status': 0, 'pid': pid}, function (data) {
						window.location.href = url;
					})
				}
			}
			return false;
		})
	})
</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('Sys_product_property/property')}" class="on">商品栏目属性列表</a>|
                    <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Sys_product_property/property_add')}','添加商品栏目属性',480,310,true,false,false,addbtn,'add',true);">添加商品栏目属性分类</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('Sys_product_property/property')}" method="get">
							<input type="hidden" name="c" value="Property"/>
							<input type="hidden" name="a" value="property"/>
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
	                        <th>属性类别</th>
                            <th>属性名称</th>
                            <th>查看属性值</th>
                            <th>状态</th>
                            <th class="textcenter" width="100">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <if condition="is_array($propertys)">
                            <volist name="propertys" id="property">
                                <tr class="propertys_tr">
                                    <td class="first_td"><a url="<?php echo U('Sys_product_property/property_del', array('pid' => $property['pid'])); ?>"  class="delete_row"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Sys_product_property/property_edit', array('pid' => $property['pid']))}','修改商品属性名称 - {pigcms{$property.name}',480,<if condition="$property['cat_pic']">390<else/>310</if>,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>
                                    <td>{pigcms{$property.pid}</td>
                                      <td><b><a href="javascript:void(0)" onclick="window.top.artiframe('{pigcms{:U('Sys_product_property/propertyType_edit', array('type_id' => $property['type_id']))}','修改产品属性分类- {pigcms{$property.type_name}',480,<if condition="$property['type_name']">390<else/>310</if>,true,false,false,editbtn,'edit',true);">{pigcms{$property.type_name}</a></b></td>
                                    <td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Sys_product_property/property_edit', array('pid' => $property['pid'],'type_id'=>$property['property_type_id']))}','修改属性值 - {pigcms{$property.name}',480,<if condition="$property['name']">390<else/>310</if>,true,false,false,editbtn,'edit',true);"><?php if ($property['cat_level'] > 1){ echo str_repeat('|——', $property['cat_level']); } ?> <span <?php if ($property['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$property.name}</span></a>


                                    </td>
									<td>
										[<a href="javascript:" onclick="window.top.artiframe('{pigcms{:U('Sys_product_property/getOnePropertyValueList', array('pid' => $property['pid']))}','编辑菜单',800,450,true,false,false,false,'add',true);" class="click_show">点击查看属性值</a>]
									</td>
                                    <td>
                                        <if condition="$property['status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if>
                                    </td>

                                    <td class="end_td">
                                        <span class="cb-enable status-enable" data-id="<?php echo $property['pid']; ?>" ><label class="cb-enable <if condition="$property['status'] eq 1">selected</if>" data-id="<?php echo $property['pid']; ?>" data-status="{pigcms{$property.status}"><span>启用</span><input type="radio" name="status" value="1" <if condition="$property['status'] eq 1">checked="checked"</if> /></label></span>
                                        <span class="cb-disable status-disable" data-id="<?php echo $property['pid']; ?>" ><label class="cb-disable <if condition="$property['status'] eq 0">selected</if>" data-id="<?php echo $property['pid']; ?>"data-status="{pigcms{$property.status}"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$property['status'] eq 0">checked="checked"</if>/></label></span>
                                    </td>
                                </tr>

                                    <tr class="property_value" rowspan="2" style="display:none;max-height:300px;overflow:auto">
	                                    <td colspan="6" >
		                                    <table width="100%" style="border:3px solid #cc0000;background:#eef3f7;height:200px;overflow: auto">
			                                    <tr bgcolor="#e3e3e3">
				                                   <th>属性值id</th>
				                                   <th>属性值</th>
				                                   <th>操作</th>
			                                    </tr>

			                                    <volist name="property['property_value']" id="values">
			                                    <tr>
				                                    <td><?php echo $values['vid']; ?></td>
				                                    <td>{pigcms{$values.value}</td>
				                                    <td></td>
			                                    </tr>
												</volist>
			                                </table>

	                                    </td>

                                    </tr>


                            </volist>
                        </if>
                    </tbody>
                    <tfoot>
                        <if condition="is_array($propertys)">
                        <tr>
                            <td class="textcenter pagebar" colspan="7">{pigcms{$page}</td>
                        </tr>
                        <else/>
                        <tr><td class="textcenter red" colspan="7">列表为空！</td></tr>
                        </if>
                    </tfoot>
                </table>
            </div>
		</div>

<style>
.select-property-tr{  background-color:#3a6ea5;  }
.table-list  .select-property-tr td{padding-left:0px;}
.select-property td{border-top:3px solid #CC5522;background:#e2d7ea}
.select-property .first_td{border-left:3px solid #cc5522}
.select-property .end_td{border-right:3px solid #cc5522}
.property_value th,.property_value td{text-align: center}
.table-list .property_value  tbody td{float:none;text-align: center}
</style>
<script>
$(".show_value").click(function(){
	var property_index = $(".show_value").index($(this));
	//每次点击初始化
	$(".property_value").removeClass("select-property-tr");
	$(".propertys_tr").removeClass("select-property");
	$(".property_value").hide();



	//每次点击new效果
	$(".propertys_tr").eq(property_index).addClass("select-property");

	$(".property_value").eq(property_index).addClass("select-property-tr");


	$(".property_value").eq(property_index).show();
})
</script>
<include file="Public:footer"/>