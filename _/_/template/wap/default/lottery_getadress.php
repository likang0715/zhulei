<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0038)http://dj.jd.com/funding/investor.html -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="description" content="">
<meta name="Keywords" content="">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<title>填写收货地址 - 摇一摇抽奖</title>
<link rel="icon" href="http://dd2.pigcms.com/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="<?php echo TPL_URL; ?>js/shakelottery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL; ?>activity_style/js/layer.js"></script>
<script type="text/javascript" src="<?php echo TPL_URL; ?>js/shakelottery/area.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/shakelottery/new/base.css">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/shakelottery/supportPorject.css">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/shakelottery/zc.common.css">
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/shakelottery/order.css" >
<link rel="stylesheet" type="text/css" href="<?php echo TPL_URL;?>css/shakelottery/address.css">
</head>
<style>
.without_object{
border: 1px solid #ececec;
color: #666;
font-family: "microsoft yahei";
font-size: 14px;
line-height: 24px;
padding: 50px 0 50px 220px;
}
#sjld li{    margin-top: 10px;}
</style>
<body>
<div class="clearfix mt20">
        <script type="text/javascript">
            function changeArea() {
                getProvinces('provinceId_m',$('#provinceId_m').attr('data-province'),'省份');
                getCitys('cityId_m','provinceId_m',$('#cityId_m').attr('data-city'),'城市');
                getAreas('areaId_m','cityId_m',$('#areaId_m').attr('data-area'),'区县');
                $('#provinceId_m').change(function(){
                    if($(this).val() != ''){
                        getCitys('cityId_m','provinceId_m','','城市');
                    }else{
                        $('#cityId_m').html('<option value="">城市</option>');
                    }
                    $('#areaId_m').html('<option value="">区县</option>');
                });
                $('#cityId_m').change(function(){
                    if($(this).val() != ''){
                        getAreas('areaId_m','cityId_m','','区县');
                    }else{
                        $('#areaId_m').html('<option value="">区县</option>');
                    }
                });
            }
            $(function(){
                changeArea();
            })
        </script>

        <!--页面主体部分 start-->
        <div class="z_container">
            <div class="module_wrap mt20">
<!--                 <div class="common_tit">
                    <h1 class="common_tit_name">奖品信息</h1>
                </div> -->
                <div class="module_con">
                    <div>

                        <form method="post" action="<?php  ?>" id="frm">
                        <div class="module_item">
                            <dl>
                                <dt>奖品名称：</dt>
                                <dd><span class="f_red20"><?php echo $record['prizename']; ?></span></dd>
                            </dl>
                            <dl>
                                <dt>配送费用：</dt>
                                <dd> 免运费 </dd>
                            </dl>
                            <dl>
                                <dt>备注：</dt>
                                <dd><input name="orderRemark" id="orderRemark" maxlength="100" type="text" placeholder="" value="" class="inp_remark" style="width:90%"/></dd>
                            </dl>
                        </div>
                        <div style=" margin-top: 20px;"></div>
                        <div class="module_item">
                            <dl>
                                <dt>收货人：</dt>
                                <div class="order-infos-item" id="defaultAddress">
                                    <span class="order-infos-item">
                                        <span id="default_name"><?php echo $address_default['name']; ?> <?php echo $address_default['tel']; ?></span>
                                        <span class="tit-extra_address">(请确认收货地址无误！)</span>
                                    </span>
                                    <div class="modify_address">
                                        <span id="default_address"><?php echo $address_default['full_address']; ?></span>
                                        <em class="t_em01" id="changeAddressShow">修改</em>
                                    </div>
                                </div>
                                <div class="change_take_goods " id="addressListDiv" style="margin-top:-30px;">
                                    <?php if(!empty($address_list)){
                                        foreach ($address_list as $k => $v) {
                                    ?>
                                    <div class="take_p">
                                    <input    name="addrList" id="addrList_<?php echo $v['address_id']; ?>" type="radio"  value="<?php echo $v['address_id']; ?>" addrName="<?php echo $v['name']; ?>" addrMobile="<?php echo $v['tel']; ?>" addrFullAddress="<?php echo $v['full_address']; ?>" class="ta_r"/>
                                    <label for="<?php echo $v['address_id']; ?>"><?php echo $v['name']; ?>&nbsp;&nbsp;<?php echo  $v['full_address']; ?>&nbsp;<?php echo  $v['tel']; ?></label> <em class="t_em t_em_a" name="editaddr" id="editaddr" addressId="<?php echo $v['address_id']; ?>" addressName="<?php echo $v['name']; ?>" addressAddressDetail="<?php echo $v['address']; ?>" addressMobile="<?php echo $v['tel']; ?>"   addressProvinceId="<?php echo $v['province']; ?>" addressCityId="<?php echo $v['city']; ?>" addressCountyId="<?php echo $v['area']; ?>" >编辑</em> <em class="t_em t_em_a" name="<?php echo $v['address_id']; ?>" id="removeAddress">删除</em>
                                    </div>
                                    <?php  } }  ?>
                                <div class="take_p">
                                <input name="addrList" id="newAddressRadio" type="radio"  value="0" class="ta_r"/>
                                <label>&nbsp;使用新地址</label>
                                </div>
                                </div>
                            </dl>
                            <input type="hidden" id="userAddressId" name="userAddressId" value="<?php echo $address_default['address_id'];?>">
                            <input type="hidden" id="addressOpt"    name="addressOpt" value=""/>
                            <input type="hidden" id="record_id"    name="record_id" value="<?php echo $id;  ?>"/>
                            <div style=" margin-top: 20px;"></div>
                                <div class="take_adress">
                                <div class="take_show" id="addAddressDiv" style="display: none;">
                                    <div class="info-list mb20">
                                        <label class="take_l line36">
                                            <span class="stars-red" id="img">*</span>收货人：
                                        </label>
                                        <input class="ui-input ui-input-L" name="name" id="name" maxlength="60" value="" placeholder="真实姓名">
                                        <div class="form-err">
                                            <font color="red" id="err_name"></font>
                                        </div>
                                    </div>
                                    <div class="info-list mb20 clearfix">
                                        <label class="take_l line36" style="float:left;">
                                            <span class="stars-red">*</span>所在地区：
                                        </label>
                                        <div id="sjld" style="position:relative;margin-left: 84px;">
                                            <li>
                                            <select name="consignee_province" id="provinceId_m" data-province="">
                                                <option value="0" selected>请选择</option>
                                            </select>
                                            </li>
                                            <li>
                                            <select name="consignee_city" id="cityId_m" data-city="">
                                                <option value="0" selected>请选择</option>
                                            </select>
                                            </li>
                                            <li>
                                            <select name="consignee_countyid" id="areaId_m" data-area="">
                                                <option>请选择</option>
                                            </select>
                                            </li>
                                        </div>
                                    </div>
                                    <div class="info-list mb20">
                                        <label class="take_l line36">
                                            <span class="stars-red" id="img">*</span>详细地址：
                                        </label>
                                        <span id="area_div"></span>
                                        <input class="ui-input ui-input-L" name="consignee_address" id="consignee_address" maxlength="60" value="" placeholder="请输入详细地址">
                                        <div class="form-err">
                                            <font color="red" id="err_consignee_address"></font>
                                        </div>
                                    </div>
                                    <div class="info-list mb20">
                                        <label class="take_l line36">
                                            <span class="stars-red" id="img">*</span>手机号码：
                                        </label>
                                        <input class="ui-input ui-input-L" name="mobile" id="mobile" maxlength="60" value="" placeholder="">
                                        <div class="form-err">
                                            <font color="red" id="err_phone"></font>
                                        </div>
                                    </div>
                                </div>
                            <div class="take_btn_save" style=" margin-top: 5px;" id="saveAddress">保存收货地址</div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="common_button">
                        <button id="btn_next" onclick="checkForm()">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="Jr_Mask" style="width: 100%; display: none; height: 100%; position: fixed; left: 0px; top: 0px; opacity: 0.5; z-index: 1000; background: rgb(0, 0, 0);"></div>
    <div class="clearfix " style="padding-top: 20px;"></div>
    <!--页面主题部分 --End-->
    <script type="text/javascript" src="<?php echo TPL_URL; ?>js/shakelottery/address.js?ii=<?php echo rand(1,1000000); ?>"></script>
</body>
</html>