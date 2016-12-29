<include file="Public:header"/>
<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Indiana/icon')}" class="on">一元夺宝商品分类图标</a>
        </ul>
    </div>
    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>编号</th>
                <th>名称</th>
                <th>类别图标</th>
                <th>类别广告图</th>
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
                            <if condition="$category.cat_indiana_pic neq ''">
                            <img src="{pigcms{$category.cat_indiana_pic}" style="height:80px;"/>
                            <else/>
                            该类别没有设置图标
                            </if>
                        </td>
                        <td>
                            <if condition="$category.cat_indiana_adver neq ''">
                                <img src="{pigcms{$category.cat_indiana_adver}" style="height:80px;"/>
                                <else/>
                                该类别没有设置广告图
                            </if>
                        </td>
                        <td>
                            <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Indiana/wap_banner_edit',array('cat_id'=>$category['cat_id']))}','编辑分类横幅',500,300,true,false,false,editbtn,'add',true);">编辑</a>
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