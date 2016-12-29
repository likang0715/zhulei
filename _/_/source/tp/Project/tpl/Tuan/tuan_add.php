<include file="Public:header"/>
<script type="text/css">
    .button { background: #004499;margin-left:15px; padding: 6px 8px; cursor: pointer; display: inline-block; text-align: center; line-height: 1; *padding:4px 10px; *height:2em; letter-spacing:2px; font-family: Tahoma, Arial/9!important; width:auto; overflow:visible; *width:1; color: #333; border: solid 1px #999;-moz-border-radius: 5px;-webkit-border-radius: 5px;  border-radius: 5px; background: #DDD; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFF', endColorstr='#DDDDDD'); background: linear-gradient(top, #FFF, #DDD); background: -moz-linear-gradient(top, #FFF, #DDD); background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#FFF), to(#DDD)); text-shadow: 0px 1px 1px rgba(255, 255, 255, 1); box-shadow: 0 1px 0 rgba(255, 255, 255, .7),  0 -1px 0 rgba(0, 0, 0, .09); -moz-transition:-moz-box-shadow linear .2s; -webkit-transition: -webkit-box-shadow linear .2s; transition: box-shadow linear .2s;color: #FFF; border: solid 1px #3399dd; background: #2880C3; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#2880C3', endColorstr='#126DAD'); background: linear-gradient(top, #2880C3, #126DAD); background: -moz-linear-gradient(top, #2880C3, #126DAD); background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#2880C3), to(#126DAD)); text-shadow: -1px -1px 1px #1c6a9e; color:#FFF; border-color:#1c6a9e;}
</script>
<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="javascript:void(0);" class="on">团购活动列表</a>
        </ul>
    </div>
    <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="{pigcms{:U('Tuan/tuan_add')}" method="get">
                    <input type="hidden" name="c" value="Tuan"/>
                    <input type="hidden" name="a" value="tuan_add"/>
                    <input type="hidden" name="cat_id" value="{pigcms{$_REQUEST['cat_id']}"/>
                    筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
                    <select name="type">
                        <option value="tuan_id" <if condition="$_GET['type'] eq 'tuan_id'">selected="selected"</if>>活动名称</option>
                        <option value="store_id" <if condition="$_GET['type'] eq 'store_id'">selected="selected"</if>>店铺名称</option>
                    </select>
                    <input type="submit" value="查询" class="button"/>
                </form>
            </td>
        </tr>
    </table>
    <form name="myform" id="myform" action="{pigcms{:U('Tuan/rcmd_tuan_all')}" method="post">
        <div class="table-list">
            <style>
                .table-list td{line-height:22px;padding-top:5px;padding-bottom:5px;}
            </style>
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th><input type="checkbox" class="js-check-all">全选</th>
                    <th>活动名称</th>
                    <th>商品名称</th>
                    <th>商品价</th>
                    <th>店铺名称</th>
                    <th class="textcenter" width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                <if condition="!empty($tuan_lists)">
                    <volist name="tuan_lists" id="vo">
                    <tr>
                        <td>
                            <input type="checkbox" name="tid[]" class="js-check-toggle" value="{pigcms{$vo.id}">
                            <input type="hidden" name="cat_id[]" value="{pigcms{$cat_id}"/>
                            <input type="hidden" name="product_id[]" value="{pigcms{$vo.product_id}"/>
                        </td>
                        <td>{pigcms{$vo.name}</td>
                        <td>{pigcms{$vo.product_name}</td>
                        <td>{pigcms{$vo.price}</td>
                        <td>{pigcms{$vo.store_name}</td>
                        <td><a class="button" href="{pigcms{:U('Tuan/rcmd_tuan',array('tid'=>$vo['id'],'cat_id'=>$cat_id,'product_id'=>$vo['product_id']))}" style="cursor: pointer;text-decoration:none;">添加推荐</a></td>
                    </tr>
                    </volist>
                <tr><td class="textcenter pagebar" colspan="10">{pigcms{$pagebar}</td></tr>
                <else/>
                <tr><td class="textcenter red" colspan="10">列表为空！</td></tr>
                </if>
                </tbody>
            </table>
            <div class="btn hidden">
                <input type="submit" name="dosubmit" id="dosubmit" value="提交" class="button">
                <input type="reset" value="取消" class="button">
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function(){
        $(".js-check-all").change(function(){
            $_this = $(this);
            if($_this.attr("checked")=="checked"){
                $(".js-check-toggle").attr("checked","checked");
            }else{
                $(".js-check-toggle").attr("checked",false);
            }
        });
    })
</script>
<include file="Public:footer"/>