<include file="Public:header"/>
<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Tuan/banner')}" class="on">商品分类横幅</a>
        </ul>
    </div>
    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>编号</th>
                <th>名称</th>
                <th>横幅图片</th>
                <th class="textcenter" width="100">操作</th>
            </tr>
            </thead>
            <tbody>
                <if condition="is_array($categories)">
                    <volist name="categories" id="category">
                    <tr>
                        <td>{pigcms{$category.cat_id}</td>
                        <td><span>{pigcms{$category.cat_name}</span></td>
                        <td>
                            <if condition="$category.cat_wap_banner neq ''">
                            <img src="{pigcms{$category.cat_wap_banner}" style="height:80px;"/></td>
                            <else/>
                            该类没有设置横幅图片
                            </if>
                        <td>
                            <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Tuan/wap_banner_edit',array('cat_id'=>$category['cat_id']))}','编辑分类横幅',500,200,true,false,false,editbtn,'add',true);">编辑</a>
                        </td>
                    </tr>
                    </volist>
                    <tr><td class="textcenter pagebar" colspan="7">{pigcms{$page}</td></tr>
                <else/>
                    <tr><td class="textcenter red" colspan="7">列表为空！</td></tr>
                </if>
            </tbody>
        </table>
    </div>
</div>
<include file="Public:footer"/>