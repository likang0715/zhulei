<include file="Public:header"/>
<style type="text/css">
.table_form{border:1px solid #ddd;}
.table_form td a{color:#ff0000;margin:auto 4px;}
.tab_ul{margin-top:10px;border-color:#C5D0DC;margin-bottom:0!important;margin-left:0;position:relative;top:1px;border-bottom:1px solid #ddd;padding-left:0;list-style:none;}
.tab_ul>li{position:relative;display:block;float:left;margin-bottom:-1px;}
.tab_ul>li>a {position: relative; display: block; padding: 10px 15px; margin-right: 2px; line-height: 1.42857143; border: 1px solid transparent; border-radius: 4px 4px 0 0; padding: 7px 12px 8px; min-width: 100px; text-align: center; }
.tab_ul>li>a, .tab_ul>li>a:focus {border-radius: 0!important; border-color: #c5d0dc; background-color: #F9F9F9; color: #999; margin-right: -1px; line-height: 18px; position: relative; }
.tab_ul>li>a:focus, .tab_ul>li>a:hover {text-decoration: none; background-color: #eee; }
.tab_ul>li>a:hover {border-color: #eee #eee #ddd; }
.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {color: #555; background-color: #fff; border: 1px solid #ddd; border-bottom-color: transparent; cursor: default; }
.tab_ul>li>a:hover {background-color: #FFF; color: #4c8fbd; border-color: #c5d0dc; }
.tab_ul>li:first-child>a {margin-left: 0; }
.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {color: #576373; border-color: #c5d0dc #c5d0dc transparent; border-top: 2px solid #4c8fbd; background-color: #FFF; z-index: 1; line-height: 18px; margin-top: -1px; box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15); }
.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {color: #555; background-color: #fff; border: 1px solid #ddd; border-bottom-color: transparent; cursor: default; }
.tab_ul>li.active>a, .tab_ul>li.active>a:focus, .tab_ul>li.active>a:hover {color: #576373; border-color: #c5d0dc #c5d0dc transparent; border-top: 2px solid #4c8fbd; background-color: #FFF; z-index: 1; line-height: 18px; margin-top: -1px; box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15); }
.tab_ul:before,.tab_ul:after{content: " "; display: table; }
.tab_ul:after{clear: both; }
input.share-code {color: #3a6ea5; font-size: 16px; font-weight: bold; padding: 5px 10px; width: 90%; }
</style>
<div class="mainbox">
	<ul class="tab_ul"><li class="active"><a href="javascript:void(0)">邀请码</a></li></ul>
	<table cellpadding="0" cellspacing="0" class="table_form" width="100%" style="" id="tab_upyun">
		<tbody>
			<tr>
				<th width="160">使用该邀请码推广：</th>
				<td>
					<input type="text" class="input-text share-code" value="{pigcms{$agent_code}" tips="邀请码" readonly="readonly">
					<img src="./source/tp/Project/tpl/Static/images/help.gif" class="tips_img" title="邀请码">
				</td>
			</tr>
			<tr>
				<th width="160">推广注册链接：</th>
				<td>
					<input type="text" class="input-text share-code" value="{pigcms{$agent_url}" tips="邀请码" readonly="readonly">
					<img src="./source/tp/Project/tpl/Static/images/help.gif" class="tips_img" title="带邀请码链接">
				</td>
			</tr>
		</tbody>
	</table>
</div>
<include file="Public:footer"/>