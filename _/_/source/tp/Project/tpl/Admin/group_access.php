<include file="Public:header"/>

<!-- jquery tree-table -->
<link rel="stylesheet" href="{pigcms{$static_path}treetable/css/jquery.treetable.css" />
<link rel="stylesheet" href="{pigcms{$static_path}treetable/css/jquery.treetable.theme.default.css?version=<?php echo time(); ?>" />
<script src="{pigcms{$static_path}treetable/js/jquery.treetable.js"></script>

<style type="text/css">
	.check_all_box { padding: 10px; border-bottom: 1px solid #eee; moz-user-select: -moz-none; -moz-user-select: none; -o-user-select:none; -khtml-user-select:none; -webkit-user-select:none; -ms-user-select:none; user-select:none;}
</style>

<form id="myform" method="post" action="{pigcms{:U('Admin/group_access')}" frame="true" refresh="true">
	<input type="hidden" name="id" value="{pigcms{$group['id']}">
	<div class="check_all_box">
		<input type="checkbox" name="all" id="js-top-check">
		<label for="js-top-check">&nbsp; 全 &nbsp;选</label>
	</div>
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%" id="rbac-root">
		<tbody>
			<volist name="system_menu" id="vo">
				<tr data-tt-id="{pigcms{$vo['id']}" <if condition="$vo.fid neq 0">data-tt-parent-id="{pigcms{$vo['fid']}"</if> >
					<td>
						<input type="checkbox" id="ipt_{pigcms{$vo.id}" class="js-check-all" name="pid[]" cls="{pigcms{$vo.id}" value="{pigcms{$vo.implode_val}" <if condition="in_array($vo['id'], $all_filter)">checked=checked</if>>
						<label for="ipt_{pigcms{$vo.id}">&nbsp; {pigcms{$vo['name']}</label>
					</td>
				</tr>
				<if condition="is_array($vo['menu_list'])">
				<volist name="vo['menu_list']" id="voo">
					<tr data-tt-id="{pigcms{$voo['id']}" data-tt-parent-id="{pigcms{$voo['fid']}">
						<td>
							├─ &nbsp; <input type="checkbox" id="ipt_{pigcms{$voo.id}" class="fid_{pigcms{$voo['fid']}" name="cid[]" value="{pigcms{$voo['implode_val']}" <if condition="in_array($voo['id'], $all_filter)">checked=checked</if>>
							<label for="ipt_{pigcms{$voo.id}">&nbsp; {pigcms{$voo['name']}</label>
						</td>
					</tr>
				</volist>
				</if>
			</volist>
		</tbody>
	</table>
	<div class="btn hidden">
		<input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
		<input type="reset" value="取消" class="button" />
	</div>
</form>
<script type="text/javascript">
$(function(){

	$("#rbac-root").treetable({ expandable: true });

	$("#js-top-check").click(function(){

		var self = $(this);

		if (self.attr("checked") == "checked") {
			$("input[name='cid[]'").attr("checked", "checked");
			$("input[name='pid[]'").attr("checked", "checked");
		} else {
			$("input[name='cid[]'").attr("checked", false);
			$("input[name='pid[]'").attr("checked", false);
		}

	});

	$(".js-check-all").each(function(){

		var pInput = $(this);
		var chdClass = "fid_"+pInput.attr("cls");
		var chdInput = $("."+chdClass);

		pInput.bind("click", function(){
			var self = $(this);
			if (self.attr("checked") == "checked") {
				chdInput.attr("checked", "checked");
			} else {
				chdInput.attr("checked", false);
			}
		});

		chdInput.bind("click", function(){
			var chd = $(this);
			if (chd.attr("checked") == "checked") {
				pInput.attr("checked", "checked");
			}
		});

		if ($("."+chdClass+":checked").length > 0) {
			pInput.attr("checked", "checked");
		}

	});

})
</script>
<include file="Public:footer"/>