<include file="Public:header"/>

<!-- jquery tree-table -->
<link rel="stylesheet" href="{pigcms{$static_path}treetable/css/jquery.treetable.css" />
<link rel="stylesheet" href="{pigcms{$static_path}treetable/css/jquery.treetable.theme.default.css?version=<?php echo time(); ?>" />
<script src="{pigcms{$static_path}treetable/js/jquery.treetable.js"></script>

<style type="text/css">
	.check_all_box { padding: 10px; border-bottom: 1px solid #eee; moz-user-select: -moz-none; -moz-user-select: none; -o-user-select:none; -khtml-user-select:none; -webkit-user-select:none; -ms-user-select:none; user-select:none;}
</style>

<form id="myform" method="post" action="{pigcms{:U('Store/package_access')}" frame="true" refresh="true">
	<input type="hidden" name="pid" value="{pigcms{$Think.get.id}">
	<input type="hidden" name="id" value="{pigcms{$rbac_package.id}">
	<div class="check_all_box">
		<input type="checkbox" name="all" id="js-top-check">
		<label for="js-top-check">&nbsp; 全 &nbsp;选</label>
	</div>
	<table cellpadding="0" cellspacing="0" class="frame_form" width="100%" id="rbac-root">
		<tbody>
			<volist name="default_module" id="vo">
				<tr data-tt-id="{pigcms{$vo}" <if condition="!is_array($config_list[$vo])"></if>>
					<td>
						<input type="checkbox" id="" class="js-check-all" cls="{pigcms{$vo}" name="menu[]"  value="{pigcms{$vo}" <if condition="in_array($vo, $rbac_list)">checked=checked</if>>
						<label >&nbsp; {pigcms{$key}</label>
					</td>		
				</tr>
				<if condition="is_array($config_list[$vo])">
				<volist name="config_list[$vo]" id="voo" key="k" >
					<tr data-tt-id="{pigcms{$key}" data-tt-parent-id="{pigcms{$vo}">
						<td>
							├─ &nbsp; <input type="checkbox"  name="menu[]" value="{pigcms{$key}" class="fid_{pigcms{$vo}" <if condition="in_array($key, $rbac_list)">checked=checked</if>>
							<label >&nbsp; {pigcms{$voo['name']}</label>
						</td>
					</tr>
				</volist>
				<else />
					<tr data-tt-id="" data-tt-parent-id="{pigcms{$vo}">
					</tr>
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
			$("input[name='menu[]'").attr("checked", "checked");
		} else {
			$("input[name='menu[]'").attr("checked", false);
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