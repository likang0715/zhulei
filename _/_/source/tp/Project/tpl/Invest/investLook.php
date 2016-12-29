<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Invest/investLook')}" >
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="15%">UID</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['uid'];  ?></div></td>
				<th width="15%">真实姓名</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['name']; ?></div></td>
			<tr/>
			<tr>
				<th width="15%">手机号</th>
				<td width="35%"><?php echo $now_user['phone']; ?></td>
				<th width="15%">是否外籍</th>
				<td width="35%"><?php echo $now_user['isforeign']==1 ? '是' : '否'; ?></td>
			</tr>
			<tr>
				<th width="15%">名片</th>
				<td width="35%"><?php echo $now_user['card_img']; ?></td>
                		<th width="15%">个人/单位</th>
                		<td width="35%"><?php echo $now_user['iscompany']==1 ? '企业' : '个人'; ?></td>
			</tr>
			<tr>
				<th width="15%">公司名称</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['company_name']; ?></div></td>
				<th width="15%">申请时间</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo date('Y-m-d H:i:s',$now_user['time']); ?></div></td>
			</tr>
			<?php if($now_user['iscompany'] !=1 ){  ?>
			<tr>
				<th width="15%">职位头衔</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['job_grade']; ?></div></td>
				<th width="15%">自然人投资者</th>
				<td width="35%"><div style="height:24px;line-height:24px;">
				<?php
				if(!empty( $person_type )){
					foreach ($person_type as $k => $v) {
						if($k==$now_user['person_type']){
							echo $v;
							break;
						}
					}
				}	?>
				</div></td>
			</tr>
			<?php 	}  ?>
            <tr>
                <th width="15%">自我描述：</th>
                <td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;">{pigcms{$now_user.description}</td>
            </tr>
		</table>
		<input type="hidden" name="uid" value="<?php echo $now_user['uid'];  ?>"/>
		<div style="margin-left: 40%;">
			<div style="width: 20%;">
			<input type="submit" name="isTrue"  value="通过" class="button" />
			<input type="submit" name="isFalse" value="不通过" class="button" />
			</div>
		</div>
	</form>
<include file="Public:footer"/>