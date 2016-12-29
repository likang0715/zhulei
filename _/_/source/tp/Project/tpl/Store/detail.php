<include file="Public:header"/>
<script src="{pigcms{$static_path}uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{pigcms{$static_path}uploadify/uploadify.css">

<style type="text/css">
	.frame_form th{border-left: 1px solid #e5e3e3!important; font-weight: bold; color:#ccc; }
	.frame_form td {vertical-align: middle; }
	.center {text-align: center!important; }
	.right-border {border-right: 1px solid #e5e3e3!important; }
	.area_select select { width: 120px; margin-right: 5px; }
    .delete {background: url({pigcms{$static_path}images/icon_delete.png) no-repeat;background-size:15px 15px;width: 15px;height: 15px;position: absolute;margin-left: -15px;}
</style>
<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Store/index')}" class="on">返回店铺列表</a>
        </ul>
    </div>

    <form method="post" id="areaForm" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="{pigcms{$store.store_id}"/>
        <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
	<tr>
		<th width="60" class="center">店铺LOGO</th>
		<td><div class="show"><img src="{pigcms{$store.logo}" width="60" height="60" /></div></td>
		<th width="80" class="center">店铺名称</th>
		<td colspan="3" class="right-border">{pigcms{$store.name}</td>
	</tr>
    <tr>
        <th class="center">店铺门头照</th>
        <td colspan="5" class="right-border">
            <div class="show"><img src="{pigcms{$store.store_pic}" height="140"/><input type="file" class="input" name="pic" style="width:200px;height: 30px;"></div>
        </td>
    </tr>
	<tr>
		<th width="80" class="center">商户账号</th>
		<td>{pigcms{$store.username}</td>
		<th class="center">用户昵称</th>
		<td colspan="3" class="right-border">{pigcms{$store.nickname}</td>
	</tr>
	<tr>
		<th width="80" class="center">经营人</th>
		<td>{pigcms{$store.linkman}</td>
		<th class="center">法人</th>
		<td colspan="3" class="right-border">{pigcms{$store.legal_person}</td>
	</tr>
	<tr>
		<th class="center">主营类目</th>
		<td>{pigcms{$store.category}</td>
		<th class="center">创建时间</th>
		<td colspan="3" class="right-border">{pigcms{$store.date_added|date='Y-m-d H:i:s', ###}</td>
	</tr>
	<tr>
		<th class="center">联系电话</th>
		<td>{pigcms{$store.tel}</td>
		<th class="center">电子邮箱</th>
		<td align="center">{pigcms{$contact.email}</td>
		<th class="center">地址</th>
		<td colspan="3" class="right-border">{pigcms{$contact.address}</td>
	</tr>
	 <tr>
        <th class="center">营业执照</th>
        <td colspan="2" class="right-border">
            <div class="show"><img src="{pigcms{$contact.yyzz}" height="140"/></div>
			<br />执照号：{pigcms{$contact.zzno}<br />有效期：{pigcms{$contact.yxqtime}
        </td>
		<th class="center">其它资料</th>
        <td colspan="2" class="right-border">
            <div class="show"><img src="{pigcms{$contact.qtzl}" height="140"/></div>
        </td>
    </tr>
	<tr>
		<th class="center">店铺收入</th>
		<td align="right">￥{pigcms{$store.income}</td>
		<th class="center">可提现金额</th>
		<td align="right">￥{pigcms{$store.balance}</td>
		<th class="center">待结算金额</th>
		<td align="right" class="right-border">￥{pigcms{$store.unbalance}</td>
	</tr>
	<tr>
		<th class="center">上门自提</th>
		<td align="center"><if condition="$store['buyer_selffetch'] eq 1">已启用<else/>未启用</if></td>
		<th class="center">找人代付</th>
		<td align="center" colspan="3" class="right-border"><if condition="$store['pay_agent'] eq 1">已启用<else/>未启用</if></td>
	</tr>
	<tr>
		<th width="80" class="center">店铺状态</th>
		<td data-id="<?php echo $store['store_id']; ?>">
			<select class="js-store_status">
				<option value="1" <if condition="$store['status'] eq 1">selected="selected"</if>>正常</option>
				<option value="2" <if condition="$store['status'] eq 2">selected="selected"</if>>待审核</option>
				<option value="3" <if condition="$store['status'] eq 3">selected="selected"</if>>关闭或审核失败</option>
				<option value="4" <if condition="$store['status'] eq 4">selected="selected"</if>>用户关闭</option>
				<?php 
				if ($store['drp_supplier_id']) {
				?>
					<option value="5" <if condition="$store['status'] eq 5">selected="selected"</if>>供货商关闭</option>
				<?php 
				}
				?>
			</select>
		</td>
		<th class="center">认证状态</th>
        <td class="right-border"><if condition="$store['approve'] eq 1"><span style="color:green">已认证</span><elseif condition="$store['approve'] eq 2" /><span style=" color:orange">认证中</span><elseif condition="$store['approve'] eq 3"/><span class="red">认证不通过</span><else/><span class="red">未认证</span></if></td>
        <?php if($store['drp_level'] == 0) {?>
        <th class="center">开启保证金充值按钮</th>
        <td><span class="cb-enable ">
                <label class="cb-enable <?php echo $store['is_show_recharge_button']== 1 ? 'selected' : '';?>"><span>开启</span>
                    <input data-id="<?php echo $store['store_id']; ?>" type="radio" name="is_show_recharge_button" value="1" />
                </label>
            </span>
            <span class="cb-disable">
                <label class="cb-disable <?php echo $store['is_show_recharge_button']== 0 ? 'selected' : '';?>"><span>关闭</span>
                    <input data-id="<?php echo $store['store_id']; ?>" type="radio" name="is_show_recharge_button" value="0" />
                </label>
            </span>
        </td>
        <?php }?>
	</tr>
	<tr>
		<th class="center">是否过期</th>
		<td  class="right-border" data-id="<?php echo $store['store_id']; ?>">
			<if condition="$store['is_available'] eq 0">
				是  &nbsp;&nbsp;<a style="color: red;" href="javascript:" class="js-store_available">点击激活</a>
			<else />
				否
			</if>
			<!-- <select class="js-store_available">
				<option value="0" <if condition="$store['is_available'] eq 0">selected="selected"</if>>是</option>
				<option value="1" <if condition="$store['is_available'] eq 1">selected="selected"</if>>否</option>
			</select> -->
		</td>

		<th class="center">特色类别</th>
		<td  class="right-border" data-id="<?php echo $store['store_id']; ?>">
			<select class="js-store_tag">
				<option value="">请选择</option>
				<volist name="store_tags" id="vo">
				<option value="{pigcms{$vo.tag_id}" <if condition="$store['tag_id'] eq $vo['tag_id']">selected="selected"</if>>
					{pigcms{$vo.name}
				</option>
				</volist>
			</select>
		</td>

		<th class="center">销售分成比例</th>
		<td  class="right-border" >
			<input type="text" class="input-text valid" name="sales_ratio"  value="<?php echo $store['sales_ratio']; ?>" size="5" validate="required:true,number:true,maxlength:5,max:100" tips="例：填入：2，则相应扣除2%，最高位100%，按照所填百分比进行扣除">
		</td>

		

	</tr>
	<tr>
		<th class="center">店铺描述</th>
		<td colspan="5" class="right-border">{pigcms{$store.intro}</td>
	</tr>
	<tr>
		<th class="center" colspan="6">提现账号</th>
	</tr>
	<tr>
		<th class="center">提现方式</th>
		<td>
            <select name="withdrawal_type">
                <option value="1" <if condition="$store['withdrawal_type'] eq 1">selected</if>>对公银行账户</option>
                <option value="0" <if condition="$store['withdrawal_type'] eq 0">selected</if>>对私银行账户</option>
            </select>
        </td>
		<th class="center">开户银行</th>
		<td colspan="3" class="right-border">
            <select name="bank_id">
                <?php foreach($store['bank_arr'] as $k=>$v){ ?>
                <option value="<?php echo $v['bank_id'];?>" <if condition="$v['bank_id'] eq $store['bank_id']">selected</if>><?php echo $v['name'];?></option>
                <?php } ?>
            </select>
        </td>
	</tr>
	<tr>
		<th class="center">银行卡号</th>
		<td><input class="input-text" type="text" name="bank_card" value="{pigcms{$store.bank_card}"/></td>
		<th class="center">开卡人姓名</th>
		<td colspan="3" class="right-border"><input class="input-text" type="text" name="bank_card_user" value="{pigcms{$store.bank_card_user}"/></td>
	</tr>
	<tr>
		<th class="center" colspan="6">所属区域设置（用于区域管理员）</th>
	</tr>
	<tr>
		<th class="center">用户当前</th>
		<td colspan="5" class="right-border">
			<if condition="!empty($area['user'])">
				<span>{pigcms{$area['user']['province_txt']}</span>
				<span>-</span>
				<span>{pigcms{$area['user']['city_txt']}</span>
				<span>-</span>
				<span>{pigcms{$area['user']['county_txt']}</span>
			<else/>
				<span>未设置</span>
			</if>
		</td>
	</tr>
	<tr>
		<th class="center">修改关联设置</th>
		<td colspan="5" class="right-border">
			<div class="area_select area_wrap" data-province="{pigcms{$area['admin']['province']}" data-city="{pigcms{$area['admin']['city']}" data-county="{pigcms{$area['admin']['county']}">
				<span><select name="province" id="s1"><option value="">选择省份</option></select></span>
				<span><select name="city" id="s2"><option value="">选择城市</option></select></span>
				<span><select name="county" id="s3"><option value="">选择地区</option></select></span>
			</div>
		</td>
	</tr>
    <tr>
        <th class="center">所属区域经理</th>
        <td colspan="5" class="right-border">
            <div>
                {pigcms{$store['area_name']}<img src="{pigcms{$store['area_avatar']}" style="height: 100px;padding-left: 10px;">
            </div>
        </td>
    </tr>
    <tr>
        <th class="center" colspan="6">客户经理设置</th>
    </tr>
    <tr>
        <tr>
            <th class="center">关联客户经理(代理商)</th>
            <td colspan="5" class="right-border">
                <select class="invite_admin" name="invite_admin" style="width:200px;" validate="required:true">
                    <option value="">--请选择--</option>
                    <volist name="agent_list" id="vo">
                        <option value="{pigcms{$vo['id']}" data-avatar="<?php echo getAttachmentUrl($vo['avatar']);?>" <if condition="$store['invite_admin'] eq $vo['id']">selected=selected</if>>{pigcms{$vo['account']}</option>
                    </volist>
                </select>
                <img class="agent-avatar" src="" height="100">
            </td>
        </tr>
    </tr>
    <tr>
        <th class="center" colspan="6">合同管理</th>
    </tr>
    <tr>
    <tr>
        <style type="text/css">
            .right-border ul li {float: left;}
            .right-border ul li img {height: 150px;}
        </style>
        <th class="center">合同管理</th>
        <td colspan="5" class="right-border">
            <ul>
                <?php foreach($contract_info as $k=>$v){ ?>
                <li><input type="hidden" name="contract[]" value="<?php echo $v;?>"><img src="<?php echo $v;?>"/><icon class="delete"></icon></li>
                <?php } ?>
                <li class="up_bottom"><div id="queue"></div><input id="file_upload" name="file_upload" type="file" multiple="true"></li>
            </ul>
        </td>
    </tr>
    </tr>
    <script type="text/javascript">
        <?php $timestamp = time();?>
        $(function() {
            $('#file_upload').uploadify({
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                },
                'buttonText' : '上传合同',
                'swf'      : '{pigcms{$static_path}uploadify/uploadify.swf',
                'uploader' : '{pigcms{:U('Store/upload_contract')}',
                'onUploadSuccess' : function(file, data, response) {
                    data = JSON.parse(data);
                    if(data.error_code==0){
                        var html = '<li><input type="hidden" name="contract[]" value="'+data.msg+'"><img src="'+data.msg+'"/><icon class="delete"></icon></li>';
                        $('.up_bottom').before(html);
                    }
                }
            });
        });
    </script>
</table>
        <div class="btn">
            <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
            <input type="reset" value="取消" class="button" />
        </div>
    </form>
</div>
<script type="text/javascript" src="{pigcms{$static_public}js/area/area.min.js"></script>
<script type="text/javascript">
$(function(){
    $(".agent-avatar").attr("src",$('.invite_admin').find("option:selected").attr("data-avatar"));
    $('.invite_admin').change(function(){
        $_this = $(this);
        $(".agent-avatar").attr("src",$_this.find("option:selected").attr("data-avatar"));
    });
	$('.status-enable > .cb-enable').click(function(){
		if (!$(this).hasClass('selected')) {
			var store_id = $(this).data('id');
			$.post("<?php echo U('Store/status'); ?>",{'status': 1, 'store_id': store_id}, function(data){})
		}
	})
	$('.status-disable > .cb-disable').click(function(){
		var store_id = $(this).data('id');
		if (!$(this).hasClass('selected')) {
			$.post("<?php echo U('Store/status'); ?>",{'status': 0,  'store_id': store_id}, function(data){})
		}
	})
	$(".js-store_status").change(function () {
		var store_id = $(this).closest("td").data("id");
		var status = $(this).val();
		$.post("<?php echo U('Store/status'); ?>",{'status': status,  'store_id': store_id}, function(data){
			if (data.error == 0) {
				window.top.msg(1, data.message);
			} else {
				window.top.msg(false, data.message);
			}
		}, 'json')
	});

	$(".js-store_available").click(function () {
		var store_id = $(this).closest("td").data("id");
		//var is_available = $(this).val();
		var is_available = 1;
		$.post("<?php echo U('Store/chgAvailable'); ?>",{'is_available': is_available,  'store_id': store_id}, function(data){
			if (data.error == 0) {
				window.top.msg(1, data.message);
				window.top.main_refresh();
			} else {
				window.top.msg(false, data.message);
			}
		}, 'json')
	});

	$(".js-store_tag").change(function () {
		var store_id = $(this).closest("td").data("id");
		var tag_id = $(this).val();
		$.post("<?php echo U('Store/chgStoreTag'); ?>",{'tag_id': tag_id,  'store_id': store_id}, function(data){
			if (data.error == 0) {
				window.top.msg(1, data.message);
			} else {
				window.top.msg(false, data.message);
			}
		}, 'json')
	});

	$('.approve-enable > .cb-enable').click(function(){
		if (!$(this).hasClass('selected')) {
			var store_id = $(this).data('id');
			$.post("<?php echo U('Store/approve'); ?>",{'approve': 1, 'store_id': store_id}, function(data){})
		}
	})
	$('.approve-disable > .cb-disable').click(function(){
		var store_id = $(this).data('id');
		if (!$(this).hasClass('selected')) {
			$.post("<?php echo U('Store/approve'); ?>",{'approve': 0,  'store_id': store_id}, function(data){})
		}
	})


	if($('.area_wrap').data('province') == ''){
		getProvinces('s1','');
	}else{
		getProvinces('s1',$('.area_wrap').data('province'));
		getCitys('s2','s1',$('.area_wrap').data('city'));
		getAreas('s3','s2',$('.area_wrap').data('county'));
	}

	$('#s1').live('change',function(){
		if ($(this).val() != '') {
			getCitys('s2','s1','');
		} else {
			$('#s2').html('<option value="">选择城市</option>');
		}

		$('#s3').html('<option value="">选择地区</option>');
	});

	$('#s2').live('change',function(){
		if ($(this).val() != '') {
			getAreas('s3','s2','');
		} else {
			$('#s3').html('<option value="">选择地区</option>');
		}

	});

    //点击删除合同图片
    $('.delete').live('click',function(){
        $(this).closest('li').remove();
    });

	$("#areaForm").submit(function(){

		/*if ($("select[name=province]").val() == "") {
			window.top.msg(false, "请选择省份");
			return false;
		} else if ($("select[name=city]").val() == "") {
			window.top.msg(false, "请选择市区");
			return false;
		} else if ($("select[name=county]").val() == "") {
			window.top.msg(false, "请选择区县");
			return false;
		}

		// 判断修改
		if ($(".area_wrap").data("province")) {
			if ($(".area_wrap").data("province") == $("select[name=province]").val() && $(".area_wrap").data("city") == $("select[name=city]").val() && $(".area_wrap").data("county") == $("select[name=county]").val()) {
				window.top.msg(false, "请修改后提交");
				return false;
			}
		}*/

		return true;

	});


    $("input[name='is_show_recharge_button']").click(function(){
        var store_id = $(this).data('id');
        var is_show_recharge_button = $(this).val();

        $.post("<?php echo U('Store/showButton'); ?>",{'is_show_recharge_button': is_show_recharge_button,  'store_id': store_id}, function(data){
            if (data.status == 0) {
                window.top.msg(1, data.msg);
            } else {
                window.top.msg(false, data.msg);
            }
        }, 'json')
    });
})
</script>
<include file="Public:footer"/>