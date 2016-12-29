<form class="form" method="post" enctype="multipart/form-data">
    <div class="content">
        <div class="cLineB"><h4 class="left">添加一个砍价商品</h4><a href="<?php dourl('wxapp:bargain');?>" class="right btnGreen">返回</a></div>
        <div class="msgWrap bgfc">
            <table class="userinfoArea" style="margin:0;" border="0" cellSpacing="0" cellPadding="0" width="100%">
                <tbody>
                <tr>
                    <th valign="top"><span class="red">*</span>关键词：</th>
                    <td valign="top"><input type="text" id="keyword" value="<?php echo $bargain['keyword'];?>" name="keyword" style="width:400px"/><br/><span class="red">只能写一个关键词</span>，用户输入此关键词将会触发此活动。
                    </td>
                    <td rowspan="999" valign="top">
                        <div style="margin-left:20px">
                            <img id="wxpic_src" src="<?php echo $bargain['wxpic'];?>" width="373px"><br/>
                            <input type="text" name="wxpic" value="<?php echo $bargain['wxpic'];?>" id="wxpic" style="width:363px;"/>
                            <a href="javascript:" class="a_upload js-add-wxpic">上传</a>&nbsp;<span class="red"><strong>*</strong></span>微信图文信息图片，推荐尺寸：900*500
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th valign="top"><span class="red">*</span>选择商品：</th>
                    <td><input type="text"  id="name" value="<?php echo $bargain['name'];?>" name="name" style="width:400px" disabled/>
                        <a date-id="4" href="javascript:;" class="a_upload js-select-product">选择店铺商品</a>
                    </td>
                </tr>
                <tr>
                    <th valign="top"><span class="red">*</span>微信分享标题：</th>
                    <td><input type="text"  id="wxtitle" value="<?php echo $bargain['wxtitle'];?>" name="wxtitle" style="width:400px"/><br/>请不要多于50字!
                    </td>
                </tr>
                <tr>
                    <th valign="top">微信分享信息说明：</th>
                    <td><textarea  id="wxinfo" name="wxinfo" style="width:400px; height:125px"><?php echo $bargain['wxinfo'];?></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="cLineB"></div>
        <div class="msgWrap bgfc">
            <table class="userinfoArea" style=" margin:0;" border="0" cellSpacing="0" cellPadding="0" width="100%">
                <tbody>
                <tr>
                    <th valign="top"><span class="red">*</span>每人砍价时间：</th>
                    <td><input type="number"  id="starttime" value="<?php echo $bargain['starttime'];?>" name="starttime" style="width:100px"/>&nbsp;单位（小时）最大2376小时
                    </td>
                </tr>
                <tr>
                    <th valign="top"><span class="red">*</span>商品原价：</th>
                    <td><input type="text"  id="original" value="<?php echo $bargain['original'];?>" name="original" style="width:100px"/>&nbsp;原价不能低于底价，单位（元）
                        <span class="new">（注：支持小数，精确到小数点后两位）</span></td>
                </tr>
                <tr>
                    <th valign="top"><span class="red">*</span>商品底价：</th>
                    <td><input type="text"  id="minimum" value="<?php echo $bargain['minimum'];?>" name="minimum" style="width:100px"/>&nbsp;底价不能高于原价，单位（元）
                        <span class="new">（注：支持小数，精确到小数点后两位）</span></td>
                </tr>
                <tr>
                    <th valign="top"><span class="red">*</span>每次砍价范围</th>
                    <td><input type="text"  id="kan_min" name="kan_min" style="width:100px" value="<?php echo $bargain['kan_min'];?>">
                        &nbsp;到&nbsp;
                        <input type="text"  id="kan_max" name="kan_max" style="width:100px" value="<?php echo $bargain['kan_max'];?>">
                        &nbsp;（单位：元）（注：自己或朋友砍下一刀的范围，若砍下后小于底价则砍至底价，支持小数，精确到小数点后两位）
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="cLineB"></div>
        <div class="msgWrap bgfc">
            <table class="userinfoArea" style=" margin:0;" border="0" cellSpacing="0" cellPadding="0" width="100%">
                <tbody>
                <tr class="new">
                    <th valign="top">排行榜显示数量：</th>
                    <td><input type="text"  id="rank_num" name="rank_num" style="width:100px" value="<?php echo $bargain['rank_num'];?>">
                        &nbsp;不填默认为10
                    </td>
                </tr>
                <tr style="display:none;">
                    <td>
                        <input type="hidden" id="pigcms_id" name="pigcms_id" value="<?php echo $bargain['pigcms_id'];?>"/>
                        <input type="hidden" id="product_id" name="product_id" value="<?php echo $bargain['product_id'];?>"/>
                        <input type="number"  id="inventory" value="<?php echo $bargain['inventory'];?>" name="inventory" style="width:100px"/>
                        <input type="input"  id="logoimg1" name="logoimg1" value="<?php echo $bargain['logoimg1'];?>" style="width:250px"/>
                        <input type="input" id="logoimg2" name="logoimg2" value="<?php echo $bargain['logoimg2'];?>" style="width:250px"/>
                        <input type="input"  id="logoimg3" name="logoimg3" value="<?php echo $bargain['logoimg3'];?>" style="width:250px"/>
                    </td>
                </tr>
                <tr>
                    <th valign="top"><label for="guize">商品详情：</label></th>
                    <td><script id="info" name="info" type="text/plain"></script></td>
                    <script>
                        var uf = UE.getEditor('info',{
                            initialFrameWidth:590,
                            initialFrameHeight:360
                        });
                    </script>
                </tr>
                <tr>
                    <th valign="top"><label for="guize">活动规则：</label></th>
                    <td><script id="guize" name="guize" type="text/plain"></script></td>
                    <script>
                        var ug = UE.getEditor('guize',{
                            initialFrameWidth:590,
                            initialFrameHeight:360
                        });
                    </script>
                </tr>
                <script>
                    uf.ready(function() {
                        uf.setContent('<?php echo $bargain['info'];?>');
                    });
                    ug.ready(function() {
                        ug.setContent('<?php echo $bargain['guize'];?>');
                    });
                </script>
                <tr>
                    <th valign="top"><span class="red"></span>未关注是否可以参与：</th>
                    <td colspan="2">
                        <input type="radio" name="is_attention" id="is_attention1" value="1" <?php if($bargain['is_attention']==1){echo 'checked';};?>>是
                        <input type="radio" name="is_attention" id="is_attention2" value="2" <?php if($bargain['is_attention']==2){echo 'checked';};?>>否（该选项目前仅适用于认证服务号,非认证服务号体验稍差）
                    </td>
                </tr>
                <tr>
                    <th valign="top"><span class="red"></span>未关注是否可以帮砍：</th>
                    <td colspan="2">
                        <input type="radio" name="is_subhelp" id="is_subhelp1" value="1" <?php if($bargain['is_subhelp']==1){echo 'checked';};?>>是</label>
                        <input type="radio" name="is_subhelp" id="is_subhelp2" value="2" <?php if($bargain['is_subhelp']==2){echo 'checked';};?>>否（该选项目前仅适用于认证服务号,非认证服务号体验稍差）
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <a class="btnGreen js-btn-edit">保存</a>
                        　<a href="<?php dourl('wxapp:bargain');?>" class="btnGray vm">取消</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</form>
