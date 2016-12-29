<style>
    .red{color:red;}
    .good-info{display:none;}

    .ui-nav, .ui-nav2 {position: relative;margin-bottom: 4px;margin-top: 4px;background: #fff;width: auto; border: 0px solid #ccc;}
    .error-message {color:#b94a48;}
    .hide {display:none;}
    .error{color:#b94a48;}
    .ui-timepicker-div .ui-widget-header {margin-bottom:8px; }
    .ui-timepicker-div dl {text-align:left; }
    .ui-timepicker-div dl dt {height:25px;margin-bottom:-25px; }
    .ui-timepicker-div dl dd {margin:0 10px 10px 65px; }
    .ui-timepicker-div td {font-size:90%; }
    .ui-tpicker-grid-label {background:none;border:none;margin:0;padding:0; }
    .controls .ico li .checkico {width: 50px;height: 54px;display: block;}
    .controls .ico li .avatar {width: auto; height: auto;max-height: 50px;max-width: 50px;display: inline-block;}
    .no-selected-style i {display: none;}
    .icon-ok {background-position: -288px 0;}
    .module-goods-list li img, .app-image-list li img {height: 100%;width: 100%;}
    .tequan {width: 100%;min-height: 60px;line-height: 60px;}
    .controls .input-prepend .add-on { margin-top: 5px;}
    .controls .input-prepend input {border-radius:0px 5px 5px 0px}
    .control-group table.reward-table{width:85%;}
    .tequan li{float:left;width:30%;text-align:left;margin-left:3%;}
    .form-horizontal .control-label{width:150px;}
    .form-horizontal .controls{margin-left:0px;}
    .controls  .renshu .add-on{margin-left:-3px;border-radius:0 4px 4px 0;}

</style>

<nav class="ui-nav-table clearfix">
    <ul class="pull-left js-list-filter-region">
        <li id="js-list-nav-all" <?php echo $type == 'all' ? 'class="active"' : '' ?>>
            <a href="#all">所有秒杀活动</a>
        </li>
        <li id="js-list-nav-future" <?php echo $type == 'future' ? 'class="active"' : '' ?>>
            <a href="#future">未开始</a>
        </li>
        <li id="js-list-nav-on" <?php echo $type == 'on' ? 'class="active"' : '' ?>>
            <a href="#on">进行中</a>
        </li>
        <li id="js-list-nav-end" <?php echo $type == 'end' ? 'class="active"' : '' ?>>
            <a href="#end">已结束</a>
        </li>
    </ul>
</nav>
<nav class="ui-nav clearfix">
    <ul class="pull-left">
        <li id="js-list-nav-all" class="active">
            <a style="float:left;" href="javascript:">修改活动</a>
            <!--<a style="margin-left: 0px;" class="btnGreen js-btn-save" href="<?php /*dourl('wxapp:bargain');*/?>" class="right btnGreen">返回</a>-->
        </li>
    </ul>
</nav>
<form class="form" method="post" enctype="multipart/form-data">
    <div class="content">
        <div class="msgWrap bgfc">
            <table class="userinfoArea" style="margin:0;" border="0" cellSpacing="0" cellPadding="0" width="100%">
                <tbody>
                <tr>
                    <th valign="top"><span class="red">*</span>活动名称：</th>
                    <td valign="top"><input type="text" id="name" value="<?php echo $seckill['name']?>" name="name" style="width:400px"/></td>
                </tr>


                <tr>
                    <th valign="top"><span class="red">*</span>选择商品：</th>
                    <td>
                        <ul class="ico app-image-list js-product" data-product_id="0">
                            <?php
                            if (!empty($product)) {
                                ?>
                                <li class="sort" data-pid="<?php echo $product['product_id'] ?>">
                                    <a href="<?php echo $product['url'] ?>" target="_blank">
                                        <img data-pid="<?php echo $product['product_id'] ?>" src="<?php echo $product['image'] ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" />
                                    </a>
                                    <a class="js-delete-picture close-modal small hide">×</a>
                                </li>
                                <li id="js-select-product" style="display: none;"><a href="javascript:;" class="add-goods js-select-product">+产品</a></li>
                            <?php
                            }
                            ?>
                        </ul>
                        <input type="hidden"  id="product_id" value="<?php echo $product['product_id'];?>" name="product_id"/>
                    </td>



                </tr>
                <tr id="good_name" class="good-info">
                    <th valign="top">商品名称：</th>
                    <td><span class="good_name"></span></td>
                </tr>

                <tr id="original" class="good-info">
                    <th valign="top">原价：</th>
                    <td><span class="original"></span></td>
                </tr>

                <tr>
                    <th valign="top"><span class="">*</span>秒杀价：</th>
                    <td><input type="text" placeholder="不填默认商品原价"  id="seckill_price" value="<?php echo $seckill['seckill_price']?>" name="seckill_price" /></td>
                </tr>

                <tr>
                    <th valign="top"><span class="red">*</span>开始时间：</th>
                    <td><input type="text" name="start_time" value="<?php echo date('Y-m-d H:i:s',$seckill['start_time']);?>" class="js-start-time Wdate" id="js-start-time" readonly style="cursor:default; background-color:white" /></td>
                </tr>

                <tr>
                    <th valign="top"><span class="red">*</span>结束时间：</th>
                    <td><input type="text" name="end_time" value="<?php echo date('Y-m-d H:i:s', $seckill['end_time']);?>" class="js-end-time Wdate" id="js-end-time" readonly style="cursor:default; background-color:white" /></td>
                </tr>

                <tr>
                    <th valign="top"><span class="">*</span>分享好友提前时间：</th>
                    <td><input type="text" name="preset_time" value="<?php echo $seckill['preset_time'];?>" id="preset_time" class="preset_time"/></td>
                </tr>

                <tr>
                    <th valign="top">活动说明：</th>
                    <td><textarea  id="description" name="description" style="width:400px; height:125px"><?php echo $seckill['description'];?></textarea>
                    </td>
                </tr>

                <tr>
                    <th valign="top"><span class="red"></span>未关注是否可以参与：</th>
                    <td colspan="2">
                        <input type="radio" name="is_attention" id="is_subscribe" value="1" <?php echo $seckill['is_subscribe'] == 1 ? 'checked' : '';?>>是
                        <input type="radio" name="is_attention" id="is_subscribe" value="2" <?php echo $seckill['is_subscribe'] == 2 ? 'checked' : '';?>>否（该选项目前仅适用于认证服务号,非认证服务号体验稍差）
                    </td>
                </tr>

                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <input type="hidden" id="seckill_id" value="<?php echo $seckill['pigcms_id'] ?>" />
                        <a class="btnGreen js-create-save">保存</a>
                        　<a href="<?php /*dourl('wxapp:bargain');*/?>" class="btnGray vm">取消</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" id="hash" name="hash" value="<?php echo $hash;?>"/>
</form>