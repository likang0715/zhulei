<include file="Public:header"/>
	<form id="myform" method="post" action="{pigcms{:U('Invest/leaderInfo')}" >
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="15%">ID</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['id'];  ?></div></td>
                		<th width="15%">个人/单位</th>
                		<td width="35%"><?php echo $now_user['iscompany']==1 ? '企业' : '个人'; ?></td>
			<tr/>
			<tr>
				<th width="15%">真实姓名</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['name']; ?></div></td>
				<th width="15%">手机号</th>
				<td width="35%"><?php echo $now_user['phone']; ?></td>
			</tr>
			<tr>
				<th width="15%">电子邮箱</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['email']; ?></div></td>
				<th width="15%">微信号</th>
				<td width="35%"><?php echo $now_user['weixin']; ?></td>
			</tr>
			<tr>
				<th width="15%">是否外籍</th>
				<td width="35%"><?php echo $now_user['isforeign']==1 ? '是' : '否'; ?></td>
				<th width="15%">名片</th>
				<td width="35%"><?php echo $now_user['card_img']; ?></td>
			</tr>
			<tr>
				<th width="15%">自然人投资者</th>
				<td width="35%"><div style="height:24px;line-height:24px;">
				<?php
				if(!empty( $investorConfig['person_type'] )){
					foreach ($investorConfig['person_type'] as $k => $v) {
						if($k==$now_user['person_type']){
							echo $v;
							break;
						}
					}
				}	?>
				</div></td>
				<th width="15%">常驻城市</th>
				<td width="35%"><?php echo $now_user['province'].$now_user['city']; ?></td>
			</tr>
			<tr>
				<th width="15%">公司名称</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['company_name']; ?></div></td>
				<th width="15%">公司类型</th>
				<td width="35%">
				<div style="height:24px;line-height:24px;">
				<?php
				if(!empty( $investorConfig['company_type'] )){
					foreach ($investorConfig['company_type'] as $k => $v) {
						if($k==$now_user['company_type']){
							echo $v;
							break;
						}
					}
				}	?>
				</div></td>
			</tr>
			<tr>
				<th width="15%">职位头衔</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['job_grade']; ?></div></td>
				<th width="15%">教育背景</th>
				<td width="35%"><div style="height:24px;line-height:24px;">
				<?php
				if(!empty( $investorConfig['education_back'] )){
					foreach ($investorConfig['education_back'] as $k => $v) {
						if($k==$now_user['education_back']){
							echo $v;
							break;
						}
					}
				}
				?>
				</div></td>
			</tr>
			<tr>
				<th width="15%">工作经历</th>
				<td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;">{pigcms{$now_user.work_experience}</td>
			</tr>
			<tr>
				<th width="15%">行业偏好</th>
				<td width="35%"><div style="height:24px;line-height:24px;">
				<?php
				$businessInfo='';
				$business_prefer=explode(',', $now_user['business_prefer']);
				if(!empty($investorConfig['business_prefer']) && !empty($business_prefer) ){
					foreach ($investorConfig['business_prefer'] as $k => $v) {
						if(!empty($v)){
							if(in_array($k, $business_prefer)){
								$businessInfo .= $v.',';
							}
						}
					}
				}
				echo substr_replace($businessInfo, '', '-1','1');
				?>
				</div></td>
				<th width="15%">阶段偏好</th>
				<td width="35%"><div style="height:24px;line-height:24px;">
				<?php
				$stageInfo='';
				$stage_prefer=explode(',', $now_user['stage_prefer']);
				if(!empty($investorConfig['stage_prefer']) && !empty($stage_prefer) ){
					foreach ($investorConfig['stage_prefer'] as $k => $v) {
						if(!empty($v)){
							if(in_array($k, $stage_prefer)){
								$stageInfo .= $v.',';
							}
						}
					}
				}
				echo substr_replace($stageInfo, '', '-1','1');
				?>
				</div></td>
			</tr>
			<tr>
				<th width="15%">从事投资时间</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['investment_time']; ?></div></td>
				<th width="15%">已投项目数</th>
				<td width="35%"><div style="height:24px;line-height:24px;">
				<?php
				if(!empty( $investorConfig['investment_num'] )){
					foreach ($investorConfig['investment_num'] as $k => $v) {
						if($k==$now_user['investment_num']){
							echo $v;
							break;
						}
					}
				}
				?>
				</div></td>
			</tr>
			<tr>
				<th width="15%">已投资名称</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['investment_name']; ?></div></td>
				<th width="15%">项目已到下轮</th>
				<td width="35%"><div style="height:24px;line-height:24px;">
				<?php
				if(!empty( $investorConfig['next_num'] )){
					foreach ($investorConfig['next_num'] as $k => $v) {
						if($k==$now_user['next_num']){
							echo $v;
							break;
						}
					}
				}
				?>
				</div></td>
			</tr>
			<tr>
				<th width="15%">成功退出项目</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php
				if(!empty( $investorConfig['out_num'] )){
					foreach ($investorConfig['out_num'] as $k => $v) {
						if($k==$now_user['out_num']){
							echo $v;
							break;
						}
					}
				}
				?>
				</div></td>
				<th width="15%">成功案例名称</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['suncess_name']; ?></div></td>
			</tr>
			<tr>
				<th width="15%">成功案例简介</th>
				<td width="35%" colspan="3" style="padding: 7px 15px 9px 15px;"><?php echo $now_user['suncess_intro']; ?></td>
			</tr>
			<tr>
				<th width="15%">与跟投方互动</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo $now_user['isinteraction']==1 ? '是' : '否';  ?>
				</div></td>
				<th width="15%">申请领投人时间</th>
				<td width="35%"><div style="height:24px;line-height:24px;"><?php echo date('Y-m-d H:i:s',$now_user['apply_leader_time']); ?></div></td>
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