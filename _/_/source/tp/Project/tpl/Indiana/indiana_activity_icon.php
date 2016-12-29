<include file="Public:header"/>
<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Indiana/activityIcon')}" class="on">活动商品图标列表</a>|
            <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Indiana/activityIcon_add')}','添加活动商品图标',500,200,true,false,false,addbtn,'add',true);">添加活动商品图标</a>
        </ul>
    </div>
    <form name="myform" id="myform" action="" method="post">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <colgroup><col> <col> <col> <col><col> <col width="140" align="center"> </colgroup>
                <thead>
                <tr>
                    <th>编号</th>
                    <th>名字</th>
                    <th>价格</th>
                    <th>图标</th>
                    <th>状态</th>
                    <th class="textcenter">操作</th>
                </tr>
                </thead>
                <tbody>
                <if condition="is_array($activity_icon_list)">
                    <volist name="activity_icon_list" id="vo">
                        <tr>
                            <td>{pigcms{$vo.id}</td>
                            <td>{pigcms{$vo.name}</td>
                            <td>{pigcms{$vo.key}</td>
                            <td><img src="{pigcms{$vo.imgurl}"/></td>
                            <td><if condition="$vo.status eq 1">启用<else/>关闭</if></td>
                            <td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Indiana/activityIcon_edit',array('id'=>$vo['id'],'frame_show'=>true))}','查看详细信息',500,300,true,false,false,false,'add',true);">查看</a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Indiana/activityIcon_edit',array('id'=>$vo['id']))}','编辑活动图标',500,300,true,false,false,editbtn,'add',true);">编辑</a> | <a href="javascript:void(0);" class="delete_row" parameter="id={pigcms{$vo.id}" url="{pigcms{:U('Indiana/activityIcon_del')}">删除</a></td>
                        </tr>
                    </volist>
                    <tr><td class="textcenter pagebar" colspan="8">{pigcms{$pagebar}</td></tr>
                    <else/>
                    <tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
                </if>
                </tbody>
            </table>
        </div>
    </form>
</div>
<include file="Public:footer"/>
