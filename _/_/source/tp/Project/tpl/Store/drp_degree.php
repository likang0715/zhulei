<include file="Public:header"/>        <style type="text/css">            .c-gray {                color: #999;            }            .table-list tfoot tr {                height: 40px;            }            .green {                color: green;            }            a, a:hover{                text-decoration: none;            }        </style>        <if condition="$withdrawal_count gt 0">            <script type="text/javascript">                $(function(){	                $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录 <label style="color:red">(' + {pigcms{$withdrawal_count} + ')</label>')                })            </script>            <else/>            <script type="text/javascript">                $(function(){	                $('#nav_12 > dd > #leftmenu_Store_withdraw', parent.document).html('提现记录');                })            </script>        </if>        <script type="text/javascript">            $(function() {                $('.status-enable > .cb-enable').click(function(){                    if (!$(this).hasClass('selected') ) {                        var url = window.location.href;                        var pigcms_id = $(this).data('id');                        $.post("<?php echo U('Store/drp_degree_status'); ?>",{'status': 1, 'pigcms_id': pigcms_id}, function(data){                            window.location.href = url;                        })                    }                    if (parseFloat($(this).data('status')) == 0) {                        $(this).removeClass('selected');                    }                    return false;                })                $('.status-disable > .cb-disable').click(function(){                    if (!$(this).hasClass('selected') ) {                        var url = window.location.href;                        var pigcms_id = $(this).data('id');                        if (!$(this).hasClass('selected')) {                            $.post("<?php echo U('Store/drp_degree_status'); ?>", {'status': 0, 'pigcms_id': pigcms_id}, function (data) {                                window.location.href = url;                            })                        }                    }                    return false;                })            })        </script>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="{pigcms{:U('Store/drp_degree')}" class="on">分销商等级列表</a>|					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/drp_degree_add')}','添加分销等级',700,400,true,false,false,addbtn,'add',true);">添加分销商等级</a>				</ul>			</div>			<table class="search_table" width="100%">				<tr>					<td>						<style>.fonts b{color:#f00}</style>						<font class="fonts">* 系统默认提供 <b>4个等级 及图标</b>，若平台有商家已经使用，则<b>不予删除</b>该分销商等级</font>					</td>				</tr>			</table>			<div class="table-list">				<table width="100%" cellspacing="0">					<thead>						<tr>                            <th>删除 | 修改</th>                            <th>编号</th>                            <th>等级名称</th>                            <th>等级值</th>							<th>等级图标</th>                            <th>条件积分</th>							<th width="20%">使用须知</th>							<th>操作时间</th>                            <th>状态</th>                            <th class="textcenter" width="100">操作</th>                        </tr>                    </thead>                    <tbody>                        <if condition="is_array($array)">                            <volist name="array" id="degree">                                <tr>                                    <td><a url="<?php echo U('Store/drp_degree_del', array('id' => $degree['pigcms_id'])); ?>"  class="delete_row"><img src="{pigcms{$static_path}images/icon_delete.png" width="18" title="删除" alt="删除" /></a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/drp_degree_edit', array('id' => $degree['pigcms_id']))}','修改分销等级 - {pigcms{$degree.name}',700,<if condition="$degree['pic']">400<else/>400</if>,true,false,false,editbtn,'edit',true);"><img src="{pigcms{$static_path}images/icon_edit.png" width="18" title="修改" alt="修改" /></a></td>                                    <td>{pigcms{$degree.pigcms_id}</td>                                    <td><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Store/drp_degree_edit', array('id' => $degree['pigcms_id']))}','修改分销等级 - {pigcms{$degree.name}',700,<if condition="$degree['pic']">400<else/>400</if>,true,false,false,editbtn,'edit',true);"> <span style="font-weight: bold;" >{pigcms{$degree.name}</span></a></td>                                    <td>{pigcms{$degree.value}</td>									<td><img src="<?php echo $degree['icon']?>" style="max-height:50px;"></td>									<td>{pigcms{$degree.condition_point}</td>									<td>{pigcms{$degree.description}</td>									<td>{pigcms{$degree.add_time|date='Y-m-d H:i:s', ###}</td>                                    <td>                                        <if condition="$degree['status'] eq 1"><span class="green">启用</span><else/><span class="red">禁用</span></if>                                    </td>                                                                      <td>                                        <span class="cb-enable status-enable"><label class="cb-enable <if condition="$degree['status'] eq 1">selected</if>" data-id="<?php echo $degree['pigcms_id']; ?>"><span>启用</span><input type="radio" name="status" value="1" <if condition="$degree['pigcms_id'] eq 1">checked="checked"</if> /></label></span>                                        <span class="cb-disable status-disable"><label class="cb-disable <if condition="$degree['status'] eq 0">selected</if>" data-id="<?php echo $degree['pigcms_id']; ?>"><span>禁用</span><input type="radio" name="status" value="0" <if condition="$degree['pigcms_id'] eq 0">checked="checked"</if>/></label></span>                                    </td>                                </tr>                            </volist>                        </if>                    </tbody>                    <tfoot>                        <if condition="is_array($array)">                        <tr>                            <td class="textcenter pagebar" colspan="10">{pigcms{$page}</td>                        </tr>                        <else/>                        <tr><td class="textcenter red" colspan="10">列表为空！</td></tr>                        </if>                    </tfoot>                </table>            </div>		</div><include file="Public:footer"/>