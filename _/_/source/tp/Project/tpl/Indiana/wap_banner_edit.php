<include file="Public:header"/>
<form id="myform" method="post" action="{pigcms{:U('Indiana/wap_banner_edit')}" enctype="multipart/form-data">
    <input type="hidden" name="cat_id" value="{pigcms{$categorydetail.cat_id}"/>
    <input type="hidden" name="cat_indiana_pic" value="{pigcms{$categorydetail.cat_indiana_pic}"/>
    <input type="hidden" name="cat_indiana_adver" value="{pigcms{$categorydetail.cat_indiana_adver}"/>
    <table cellpadding="0" cellspacing="0" class="frame_form" width="100%">
        <tr>
            <th width="80">图标现图</th>
            <td><img src="{pigcms{$categorydetail.cat_indiana_pic_url}" style="width:260px;height:80px;" class="view_msg"/></td>
        </tr>
        <tr>
            <th width="80">图标图片</th>
            <td><input type="file" class="input fl" name="pic" style="width:200px;" placeholder="请上传图片" tips="不修改请不上传！上传新图片，老图片会被自动删除！"/></td>
        </tr>
        <tr>
            <th width="80">广告现图</th>
            <td><img src="{pigcms{$categorydetail.cat_indiana_adver_url}" style="width:260px;height:80px;" class="view_msg"/></td>
        </tr>
        <tr>
            <th width="80">广告图片</th>
            <td><input type="file" class="input fl" name="pic_adver" style="width:200px;" placeholder="请上传图片" tips="不修改请不上传！上传新图片，老图片会被自动删除！"/></td>
        </tr>
    </table>
    <div class="btn hidden">
        <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button" />
        <input type="reset" value="取消" class="button" />
    </div>
</form>
<include file="Public:footer"/>