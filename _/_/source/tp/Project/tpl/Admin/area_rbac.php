<include file="Public:header"/>

<!-- jquery tree-table -->
<link rel="stylesheet" href="{pigcms{$static_path}treetable/css/jquery.treetable.css" />
<link rel="stylesheet" href="{pigcms{$static_path}treetable/css/jquery.treetable.theme.default.css?version=<?php echo time(); ?>" />
<script src="{pigcms{$static_path}treetable/js/jquery.treetable.js"></script>

<form id="myform" method="post" action="{pigcms{:U('Admin/area_rbac')}" frame="true" refresh="true">
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%" id="rbac-boot">
		<tbody>
			<volist name="system_menu" id="vo">
				<tr data-tt-id="{pigcms{$vo['id']}" <if condition="$vo.fid neq 0">data-tt-parent-id="{pigcms{$vo['fid']}"</if> >
					<td>
						<input type="checkbox" id="ipt_{pigcms{$vo.id}" class="js-check-all" name="pid[]" value="{pigcms{$vo.id}" <if condition="in_array($vo['id'], $all_filter)">checked=checked</if>>
						<label for="ipt_{pigcms{$vo.id}">&nbsp; {pigcms{$vo['name']}</label>
					</td>
				</tr>
				<if condition="is_array($vo['menu_list'])">
				<volist name="vo['menu_list']" id="voo">
					<tr data-tt-id="{pigcms{$voo['id']}" data-tt-parent-id="{pigcms{$voo['fid']}">
						<td>
							├─ &nbsp; <input type="checkbox" id="ipt_{pigcms{$voo.id}" class="fid_{pigcms{$voo['fid']}" name="cid[]" value="{pigcms{$voo['implode_val']}" <if condition="in_array($voo['id'], $all_filter)">checked=checked</if>>
							<label for="ipt_{pigcms{$voo.id}">&nbsp; {pigcms{$voo['name']} ({pigcms{$voo['module']}/{pigcms{$voo['action']})</label>
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

	$("#rbac-boot").treetable({ expandable: true });

	$(".js-check-all").each(function(){

		var pInput = $(this);
		var chdClass = "fid_"+pInput.val();
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