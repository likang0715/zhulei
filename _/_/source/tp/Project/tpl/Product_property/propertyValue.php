<include file="Public:header"/>        <style type="text/css">            .c-gray {                color: #999;            }            .table-list tfoot tr {                height: 40px;            }            .green {                color: green;            }            a, a:hover{                text-decoration: none;            }        </style><script type="text/javascript">	$(function() {		$('.status-enable > .cb-enable').click(function(){			if (!$(this).hasClass('selected') ) {				var url = window.location.href;				var vid = $(this).data('id');				$.post("<?php echo U('Product_property/propertyvalue_status'); ?>",{'status': 1, 'vid': vid}, function(data){					window.location.href = url;				})			}			if (parseFloat($(this).data('status')) == 0) {				$(this).removeClass('selected');			}			return false;		})		$('.status-disable > .cb-disable').click(function(){			if (!$(this).hasClass('selected') && parseFloat($(this).data('status')) == 1) {				var url = window.location.href;				var vid = $(this).data('id');				if (!$(this).hasClass('selected')) {					$.post("<?php echo U('Product_property/propertyvalue_status'); ?>", {'status': 0, 'vid': vid}, function (data) {						window.location.href = url;					})				}			}			return false;		})	})</script>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="{pigcms{:U('Product_property/propertyValue')}" class="on">商品属性值列表</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td>						<form action="{pigcms{:U('Product_property/propertyValue')}" method="get">							<input type="hidden" name="c" value="Property"/>							<input type="hidden" name="a" value="property"/>                            						</form>					</td>				</tr>			</table>            <div class="table-list">                <table width="100%" cellspacing="0">                    <thead>                        <tr>                            <th>删除 | 修改</th>                            <th>编号</th>	                        <th>属性</th>                            <th>属性值</th>                           <!-- <th>状态</th>                            <th class="textcenter" width="100">操作</th>-->                        </tr>                    </thead>                    <tbody>                        <if condition="is_array($propertyValues)">                            <volist name="propertyValues" id="propertyValue">                                <tr>                                    <td><a url="<?php echo U('Product_property/propertyValue_del', array('vid' => $propertyValue['vid'])); ?>"  class="delete_row"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product_property/propertyValue_edit', array('vid' => $propertyValue['vid']))}','修改商品属性值 - {pigcms{$property.name}',480,<if condition="$property['cat_pic']">390<else/>310</if>,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>                                    <td>{pigcms{$propertyValue.vid}</td>                                          <td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product_property/property_edit', array('pid' => $propertyValue['pid']))}','修改属性值 - {pigcms{$propertyValue.name}',480,<if condition="$property['name']">390<else/>310</if>,true,false,false,editbtn,'edit',true);"><?php if ($property['cat_level'] > 1){ echo str_repeat('|——', $property['cat_level']); } ?> <span <?php if ($property['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$propertyValue.name}</span></a></td>                                          <td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Product_property/propertyValue_edit', array('pid' => $propertyValue['vid']))}','修改属性值 - {pigcms{$propertyValue.value}',480,<if condition="$property['name']">390<else/>310</if>,true,false,false,editbtn,'edit',true);"><?php if ($property['cat_level'] > 1){ echo str_repeat('|——', $property['cat_level']); } ?> <span <?php if ($property['cat_level'] == 1){ ?>style="font-weight: bold;" <?php } ?>>{pigcms{$propertyValue.value}</span></a></td>									<!--                                    <td>                                        <if condition="$propertyValue['status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if>                                    </td>                                    <td>                                        <span class="cb-enable status-enable" data-id="<?php echo $propertyValue['vid']; ?>" ><label class="cb-enable <if condition="$propertyValue['status'] eq 1">selected</if>" data-id="<?php echo $propertyValue['vid']; ?>" data-status="{pigcms{$propertyValue.status}"><span>启用</span><input type="radio" name="status" value="1" <if condition="$propertyValue['status'] eq 1">checked="checked"</if> /></label></span>                                        <span class="cb-disable status-disable" data-id="<?php echo $propertyValue['vid']; ?>"><label class="cb-disable <if condition="$propertyValue['status'] eq 0">selected</if>" data-id="<?php echo $propertyValue['vid']; ?>"data-status="{pigcms{$propertyValue.status}"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$propertyValue['status'] eq 0">checked="checked"</if>/></label></span>                                    </td>									-->                                </tr>                            </volist>                        </if>                    </tbody>                    <tfoot>                        <if condition="is_array($propertyValues)">                        <tr>                            <td class="textcenter pagebar" colspan="7">{pigcms{$page}</td>                        </tr>                        <else/>                        <tr><td class="textcenter red" colspan="7">列表为空！</td></tr>                        </if>                    </tfoot>                </table>            </div>		</div><include file="Public:footer"/>