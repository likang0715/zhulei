<include file="Public:header"/>
	<script type="text/javascript">
		$(function() {
			//是否启用
			$('.status-enable > .cb-enable').click(function(){
				if (!$(this).hasClass('selected')) {
					var uid = $(this).data('id');
					$.post("<?php echo U('User/fans_forever'); ?>",{'status': 1, 'id': uid}, function(data){})
				}
			})
			$('.status-disable > .cb-disable').click(function(){
				if (!$(this).hasClass('selected')) {
					var uid = $(this).data('id');
					if (!$(this).hasClass('selected')) {
						$.post("<?php echo U('User/fans_forever'); ?>", {'status': 0, 'id': uid}, function (data) {})
					}
				}
			})
		});
	</script>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<ul>
					<a href="{pigcms{:U('User/index')}" class="on">用户列表</a>
				</ul>
			</div>
			<table class="search_table" width="100%">
				<tr>
					<td>
						<form action="{pigcms{:U('User/index')}" method="get">
							<input type="hidden" name="c" value="User"/>
							<input type="hidden" name="a" value="index"/>
							筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
							<select name="searchtype">
								<option value="uid" <if condition="$_GET['searchtype'] eq 'uid'">selected="selected"</if>>用户ID</option>
								<option value="nickname" <if condition="$_GET['searchtype'] eq 'nickname'">selected="selected"</if>>昵称</option>
								<option value="phone" <if condition="$_GET['searchtype'] eq 'phone'">selected="selected"</if>>手机号</option>
							</select>&nbsp;&nbsp;
							<select name="pid">
								<option value="" >所属店铺套餐</option>
								<volist name="packagelist" id="vo">
								<option value="{pigcms{$vo.pigcms_id}" <if condition="$_GET['pid'] eq $vo['pigcms_id']">selected="selected"</if>>{pigcms{$vo.name}</option>
								</volist>
							</select>
							<input type="submit" value="查询" class="button"/>
						</form>
					</td>
				</tr>
			</table>
			<form name="myform" id="myform" action="" method="post">
				<div class="table-list">
					<table width="100%" cellspacing="0">
						<colgroup>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col width="180" align="center"/>
						</colgroup>
						<thead>
							<tr>
								<th>ID</th>
								<th>昵称</th>
								<th>手机号</th>
                                <th style="text-align: right;">店铺数量</th>
								<th style="text-align: right;">积分余额</th>
								<th style="text-align: right;">待发放积分</th>
								<th style="text-align: right;">已使用积分</th>
								<th style="text-align: center;">最后登录时间</th>
								<th>最后登录IP</th>
								<th class="textcenter">状态</th>
								<th class="textcenter" style="width: 90px;">粉丝终身制</th>
								<th class="textcenter">操作</th>
							</tr>
						</thead>
						<tbody>
							<if condition="is_array($user_list)">
								<volist name="user_list" id="vo">
									<tr>
										<td>{pigcms{$vo.uid}</td>
										<td>{pigcms{$vo.nickname}</td>
										<td>{pigcms{$vo.phone}</td>
										<td style="text-align: right;"><?php if ($vo['stores'] > 0) { ?><a href="javascript:;" href="javascript:void(0);" style="color: #3865B8" onclick="window.top.artiframe('{pigcms{:U('User/stores',array('id' => $vo['uid'], 'frame_show' => true))}','商家“{pigcms{$vo.nickname}”的店铺',750,700,true,false,false,false,'detail',true);">{pigcms{$vo.stores}</a><?php } else { ?>0<?php } ?></td>
										<td style="text-align: right;color:green;"><a href="{pigcms{:U('Credit/record',array('record_type' => 1, 'ktype' => 'user', 'keyword' => $vo['nickname']))}"><?php echo $vo['point_balance']; ?></a></td>
										<td style="text-align: right;color:#999;"><?php echo $vo['point_unbalance']; ?></td>
										<td style="text-align: right;color:red;"><?php echo $vo['point_used']; ?></td>
										<td style="text-align: center;">{pigcms{$vo.last_time|date='Y-m-d H:i:s',###}</td>
										<td>{pigcms{$vo.last_ip_txt}</td>
										<td class="textcenter"><if condition="$vo['status'] eq 1"><font color="green">正常</font><else/><font color="red">禁止</font></if></td>
										<td class="textcenter">
											<?php if (isset($vo['fans_forever'])) { ?>
											<div style="margin: 0 auto;">
												<span class="cb-enable status-enable"><label class="cb-enable <?php if (!empty($vo['fans_forever'])) { ?>selected<?php } ?>" data-id="<?php echo $vo['uid']; ?>"><span>启用</span><input type="radio" name="status" value="1"></label></span>
												<span class="cb-disable status-disable"><label class="cb-disable <?php if (empty($vo['fans_forever'])) { ?>selected<?php } ?>" data-id="<?php echo $vo['uid']; ?>"><span>取消</span><input type="radio" name="status" value="0"></label></span>
												<div style="clear: both;"></div>
											</div>
											<?php } else { ?>
												无
											<?php } ?>
										</td>
										<td class="textcenter">
											<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('User/edit',array('uid'=>$vo['uid']))}','编辑用户信息',700,360,true,false,false,editbtn,'edit',true);">编辑</a>&nbsp;|&nbsp;
											<a href="{pigcms{:U('tab_store',array('uid'=>$vo['uid']))}" target="_blank">进入店铺</a>
											<if condition="C('config.allow_agent_invite')">
												&nbsp;|&nbsp;
												<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('User/agent_invite', array('uid'=>$vo['uid']))}','绑定客户经理(代理商)',620,360,true,false,false,editbtn,'edit',true);">绑定客户经理(代理商)</a>
											</if>
										</td>
									</tr>
								</volist>
								<tr><td class="textcenter pagebar" colspan="12">{pigcms{$pagebar}</td></tr>
							<else/>
								<tr><td class="textcenter red" colspan="12">列表为空！</td></tr>
							</if>
						</tbody>

					</table>
				</div>
			</form>
		</div>
<include file="Public:footer"/>