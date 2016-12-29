<include file="Public:header"/>
<script type="text/javascript" charset="utf-8" src="{pigcms{$static_public}/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="{pigcms{$static_public}/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="{pigcms{$static_public}/ueditor/lang/zh-cn/zh-cn.js"></script>
<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Indiana/home')}">一元夺宝首页分类列表</a>
            <a href="{pigcms{:U('Indiana/about')}" class="on">什么是一元夺宝</a>
            <if condition="$activity_category_detail.cat_key eq 'wap_indiana_define'">
                <a href="javsscript:void(0);" onclick="window.top.artiframe('{pigcms{:U('Indiana/indianacat_add',array('cat_id'=>$activity_category_detail['cat_id']))}','新增模块',500,200,true,false,false,addbtn,'add',true);">新建内容模块</a>
            </if>
        </ul>
    </div>
    <form id="myform" method="post" action="{pigcms{:U('Tuan/adver_add')}" enctype="multipart/form-data">
        <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
            <tr>
                <th>一元夺宝说明</th>
            </tr>
            <tr>
                <script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>
            </tr>
        </table>
        <div class="btn">
            <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
            <input type="reset" value="取消" class="button" />
        </div>
    </form>
    <script type="text/javascript">
        //实例化编辑器
        var ue = UE.getEditor('editor',{
            toolbars: [[
                'fullscreen', 'source', '|', 'undo', 'redo', '|',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                'directionalityltr', 'directionalityrtl', 'indent', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                'simpleupload', 'insertimage', 'emotion', 'map', 'insertframe', 'insertcode', 'pagebreak', '|',
                'horizontal', 'date', 'time', 'spechars', 'help'
            ]],
            autoHeightEnabled: true,
            autoFloatEnabled: true
        });
    </script>
</div>
<include file="Public:footer"/>