<include file="Public:header"/>
<script type="text/javascript" src="static/js/layer/layer/layer.js"></script>

		<table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
			<tr>
				<th width="80">新闻标题</th>
                        <input type="hidden" name="news_id" value="{pigcms{$now_news.news_id}"/>
				<td>{pigcms{$now_news.news_title}</td>
			</tr>
                        
                        <tr>
				<th width="80">新闻摘要</th>
				<td>{pigcms{$now_news.abstract}</td>
			</tr>
                        <tr>
                            <th width="80">文章类型</th>

                            <td>
                                <span style="color:red;"><if condition="$now_news['newsType'] eq 0">股权众筹<else />产品众筹</if></span>
                            </td>
			</tr>
                        <tr>
                            <th width="80">修改新闻图片</th>
                            <td>
                                <img src="{pigcms{$now_news.imgUrl}" style="width:80px; height: 80px;"/>
                            </td>
                        </tr>
                        <tr>
                            <th width="80">新闻分类</th>
                            <td>
                                    {pigcms{$catInfo.cat_name}   --   {pigcms{$catInfo.cat_key}
                            </td>
                        </tr>
                        <tr>
                            <th width="80">新闻状态</th>
                            <td>
                                <span style="color:red;"><if condition="$now_news['state'] eq 0">隐藏<else />显示</if></span>
                            </td>
                        </tr>
                
                        <tr>
                            <th width="80">新闻内容</th>
                            <td>
                                {pigcms{$now_news['news_content']|htmlspecialchars_decode=ENT_QUOTES}
                            </td>
                        </tr>
		</table>

<include file="Public:footer"/>