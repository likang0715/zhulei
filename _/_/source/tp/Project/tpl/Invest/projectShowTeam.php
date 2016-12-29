<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('News/newsEditData')}" enctype="multipart/form-data">
		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
                    <volist name="teamList" id="vo">
                            <tr>
				<th width="80">成员头像</th>
				<td><img src="{pigcms{$vo.teamImg}" style="width: 80px;"/></td>
                            </tr>

                            <tr>
                                    <th width="80">名称</th>
                                    <td>{pigcms{$vo.teamName}</td>
                            </tr>
                            <tr>
                                    <th width="80">职位</th>
                                    <td>
                                           {pigcms{$vo.teamTitle}
                                    </td>
                            </tr>
                            <tr>
                                    <th width="80">介绍</th>
                                    <td>
                                           {pigcms{$vo.teamIntroduce}
                                    </td>
                            </tr>
                        <tr>
                            <th></th>
                            <td></td>
                        </tr>
                    </volist>
			
		</table>

	</form>


<include file="Public:footer"/>