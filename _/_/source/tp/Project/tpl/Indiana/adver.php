<include file="Public:header"/>
<div class="mainbox">
    <style type="text/css">
        .nav_div a.active{background: #498CD0;margin: 0 5px;padding: 9px 22px;text-decoration: none;font-size: 13px;float: left;color: #000000;}
        .nav_div a{margin: 0 5px;padding: 9px 22px;text-decoration: none;font-size: 13px;float: left;color: #000000;border: 1px solid #000000;}
        .nav_div p{color: #7D7D7D;padding-top: 7px;}
        .mainnav_title {clear: both;}
    </style>
    <div class="nav_div">
        <a href="{pigcms{:U('Indiana/adver')}" class="active">电脑端广告</a>
        <a href="{pigcms{:U('Indiana/wap_adver')}" class="">移动端广告</a>
        <p>唯一区别:图片显示大小不一样</p>
    </div>
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Indiana/pc_adver')}" class="on">电脑端-首页幻灯片(730*350)-广告列表</a>|
            <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Indiana/adver_add',array('type'=>1))}','添加电脑端首页幻灯片(730*350)',600,190,true,false,false,addbtn,'add',true);">添加广告</a>
        </ul>
    </div>
    <form name="myform" id="myform" action="" method="post">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>编号</th>
                    <th>名称</th>
                    <th>链接地址</th>
                    <th>图片(以下为强制小图，点击图片查看大图)</th>
                    <th>状态</th>
                    <th class="textcenter">添加时间</th>
                    <th class="textcenter">操作</th>
                </tr>
                </thead>
                <tbody>
                <if condition="is_array($adver_list)">
                    <volist name="adver_list" id="vo">
                        <tr>
                            <td>{pigcms{$vo.id}</td>
                            <td>{pigcms{$vo.name}</td>
                            <td><a href="{pigcms{$vo.url}" target="_blank">访问链接</a></td>
                            <td>
                                <img src="{pigcms{$vo.pic}" style="width:300px;height:80px;" class="view_msg"/>
                            </td>
                            <td>
                                <if condition="$vo.status eq 1">启用<else/>关闭</if>
                            </td>
                            <td class="textcenter">{pigcms{$vo.last_time|date='Y-m-d H:i:s',###}</td>
                            <td class="textcenter"><a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Adver/adver_edit',array('id'=>$vo['id'],'frame_show'=>true))}','查看广告信息',480,330,true,false,false,false,'add',true);">查看</a> | <a href="javascript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Tuan/adver_edit',array('id'=>$vo['id']))}','编辑广告信息',480,330,true,false,false,editbtn,'add',true);">编辑</a> | <a href="javascript:void(0);" class="delete_row" parameter="id={pigcms{$vo.id}" url="{pigcms{:U('Tuan/adver_del')}">删除</a></td>
                        </tr>
                    </volist>
                    <tr><td class="textcenter pagebar" colspan="9">{pigcms{$pagebar}</td></tr>
                <else/>
                <tr><td class="textcenter red" colspan="8">列表为空！</td></tr>
                </if>
                </tbody>
            </table>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function(){
        //是否启用
        $('.status-enable > .cb-enable').click(function(){
            if (!$(this).hasClass('selected')) {
                var group_id = $(this).data('id');
                $.post("<?php echo U('Admin/group_status'); ?>",{'status': 1, 'group_id': group_id}, function(data){})
            }
        });

        $('.status-disable > .cb-disable').click(function(){
            if (!$(this).hasClass('selected')) {
                var group_id = $(this).data('id');
                if (!$(this).hasClass('selected')) {
                    $.post("<?php echo U('Admin/group_status'); ?>", {'status': 0, 'group_id': group_id}, function (data) {})
                }
            }
        });
    })
</script>
<include file="Public:footer"/>