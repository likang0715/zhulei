<include file="Public:header"/>
		<div class="mainbox">
			<div id="nav" class="mainnav_title">
				<a href="javascript:;" class="on">基本设置</a>
			</div>
			<form method="post" id="myform" action="{pigcms{:U('Invest/config')}" refresh="true" frame="true">
				<table cellpadding="0" cellspacing="0" class="table_form" width="100%">
					<tr>
						<td  width="120">默认倍率值</td>
						<td><input type="text" style="width: 80px;" class="input-text"  name="info[beilv]" value="<?php echo $config['beilv']; ?>" validate="required:true" /><span style="color: red;">*整数</span>
						</td>
					</tr>
					<!-- <tr>
						<td>默认框架合同名称</td>
						<td><input type="text" style="width: 280px;" class="input-text"  name="info[framework_name]" value="<?php echo $config['framework_name']; ?>" validate="required:true" />
						</td>
					</tr> -->
					<tr>
						<td  width="120">默认大东家上限数</td>
						<td><input type="text" style="width: 80px;" class="input-text"  name="info[maxShareholder]" value="<?php echo $config['maxShareholder']; ?>" validate="required:true" /><span style="color: red;">*整数</span>
						</td>
					</tr>
					<tr>
						<td  width="120">默认大东家金额</td>
						<td><input type="text" style="width: 80px;" class="input-text"  name="info[maxShareholderMoney]" value="<?php echo $config['maxShareholderMoney']; ?>" validate="required:true" /><span style="color: red;">*整数</span>
						</td>
					</tr>
					<tr>
						<td  width="120">默认小东家上限数</td>
						<td><input type="text" style="width: 80px;" class="input-text"  name="info[minShareholder]" value="<?php echo $config['minShareholder']; ?>" validate="required:true" /><span style="color: red;">*整数</span>
						</td>
					</tr>
					<tr>
						<td  width="120">默认小东家金额</td>
						<td><input type="text" style="width: 80px;" class="input-text"  name="info[minShareholderMoney]" value="<?php echo $config['minShareholderMoney']; ?>" validate="required:true" /><span style="color: red;">*整数</span>
						</td>
					</tr>
					<tr>
						<td  width="120">是否开启路由设置</td>
						<td>
						<select name="info[rewrite]" style="width: 80px;"  style="border: 1px solid #dcdcdc;border-radius: 8px;">
							<option value="0" <?php echo $config['rewrite']==0 ? 'selected' : ''; ?>>关闭</option>
							<option value="1" <?php echo $config['rewrite']==1 ? 'selected' : ''; ?>>开启</option>
						</select>
						</td>
					</tr>

                                        <tr>
						<td  width="120">不限制登录</td>
						<td>
						<select name="info[isLogin]" style="width: 80px;"  style="border: 1px solid #dcdcdc;border-radius: 8px;">
							<option value="0" <?php echo $config['isLogin']==0 ? 'selected' : ''; ?>>关闭</option>
							<option value="1" <?php echo $config['isLogin']==1 ? 'selected' : ''; ?>>开启</option>
						</select>
						</td>
					</tr>

				</table>
				<div class="btn">
					<input type="submit"  name="dosubmit" value="提交" class="button" />
					<!-- <input type="reset"  value="取消" class="button" /> -->
				</div>
			</form>
		</div>
<include file="Public:footer"/>