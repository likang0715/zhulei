<include file="Public:header"/>		<div class="mainbox">			<div id="nav" class="mainnav_title">				<ul>					<a href="{pigcms{:U('News/newsList')}" class="on">新闻列表</a>|					<a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('News/newsAdd',array('cat_id'=>$now_category['cat_id']))}','添加新闻',700,600,true,false,false,addbtn,'add',true);">添加新闻</a>				</ul>			</div>			<form name="myform" id="myform" action="" method="post">				<div class="table-list">					<table width="100%" cellspacing="0">						<colgroup>							<col/>							<col/>							<col/>							<col/>							<col width="180" align="center"/>							<col width="180" align="center"/>						</colgroup>						<thead>							<tr>								<th>编号</th>								<th>所属分类</th>                                                                <th>key值</th>								<th>标题</th>								<th class="textcenter">添加时间</th>								<th class="textcenter">操作</th>							</tr>						</thead>						<tbody>							<if condition="is_array($news_list)">								<volist name="news_list" id="vo">									<tr>										<td>{pigcms{$vo.news_id}</td>										<td>{pigcms{$vo['cates']['cat_name']}</td>                                                                                <td>{pigcms{$vo['cates']['cat_key']}</td>										<td>{pigcms{$vo.news_title}</td>										<td class="textcenter">{pigcms{$vo.add_time|date='Y-m-d H:i:s',###}</td>										<td class="textcenter">                                                                                    <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('News/newsShow',array('id'=>$vo['news_id'],'frame_show'=>true))}','新闻预览',700,600,true,false,false,false,'news_edit',true);">预览</a> |                                                                                    <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('News/newsEdit',array('id'=>$vo['news_id']))}','编辑信息',700,600,true,false,false,editbtn,'news_edit',true);">编辑</a> |                                                                                     <a href="javascript:void(0);" class="delete_row" parameter="id={pigcms{$vo.news_id}" url="{pigcms{:U('News/newsDel')}">删除</a>                                                                                </td>									</tr>								</volist>								<tr><td class="textcenter pagebar" colspan="6">{pigcms{$pagebar}</td></tr>							<else/>								<tr><td class="textcenter red" colspan="6">列表为空！</td></tr>							</if>						</tbody>					</table>				</div>			</form>		</div><include file="Public:footer"/>