//收货地址form框div
var $addAddressDiv = $("#addAddressDiv");
//新增收货地址按钮
var $newAddressBtn = $("#newAddressBtn");
//使用新地址单选按钮
var $newAddressRadio = $("#newAddressRadio");
//修改按钮,展示地址列表
var $changeAddressShow = $("#changeAddressShow");
//收货地址列表div
var $addressListDiv = $("#addressListDiv");
//默认展示的收货人地址div
var $defaultAddress = $("#defaultAddress");
//地址列表的单选按钮
var $addrList=$('#addressListDiv').find('[name="addrList"]');
//编辑按钮
var $editaddr=$("#editaddr");
//保存收货地址按钮
var $saveAddress=$("#saveAddress");
//删除收货地址
var $removeAddress=$('#removeAddress');
//新增按钮参数
var saveOption="";

var orderVersion = $('#orderVersion').val();
//项目模式
var projectModel=$('#projectModel').val();
var submitUrl = "";
var returnUrl = "";

/****************修改收货地址*******************/
$changeAddressShow.live("click",function(){
    $("#userAddressId").val(0);
    $("#addressOpt").val("edit");
    $addressListDiv.show();
    $defaultAddress.hide();
    $addAddressDiv.hide();
    $saveAddress.show();
});
$addrList.live("click",function(){
    $('#addressOpt').val("");
});
/****************新增收货地址*******************/
$newAddressBtn.live("click",function(){
    $addAddressDiv.show();
    $saveAddress.show();
    saveOption="button";
    $("#userAddressId").val("");
    newAddress();
});
/*****************使用新地址******************/
$newAddressRadio.live("click",function(){
    $("#userAddressId").val('');
    $addAddressDiv.show();
    $saveAddress.show();
    $("#sjld").show();
    saveOption="radio";
    newAddress();
});
function newAddress(){
    $("#addressOpt").val("new");
    $("#userAddressId").val(0);
    $("#provinceId_m").val('');
    $("#cityId_m").val('');
    $("#areaId_m").val('');
    $("#name").val('');
    $("#area_div").text("");
    $("#consignee_address").val('');
    $("#mobile").val('');
    $("#email").val('');
}
/*********************保存收货地址******************************/
$saveAddress.live("click",function(){
    var judge=true;
    var checkItem=$("input[name='addrList']:checked").val();
    if (checkItem>0){
            var addrName=$("#addrList_"+checkItem).attr("addrName");
            var addrMobile=$("#addrList_"+checkItem).attr("addrMobile");
            var addrFullAddress=$("#addrList_"+checkItem).attr("addrFullAddress");
            var userAddressId = $("#addrList_"+checkItem).attr("value");
            $("#userAddressId").val(userAddressId);
            $("#default_name").text(addrName+' '+addrMobile);
            $("#default_address").text(addrFullAddress);
            $defaultAddress.show();
            $addressListDiv.hide();
            $addAddressDiv.hide();
            $saveAddress.hide();
    }else{
        if ($('#addressOpt').val()=="new" || $('#addressOpt').val()=="modify"){
            dosave();
        }else {
            layer.msg('请选择一个收货地址!');
        }
    }
});
function dosave(){
    url="?a=ajax_setAddress";
    if (!checkData()){
        return ;
    }
    var addressId=$("#userAddressId").val();
    if (addressId==''|| addressId == null || addressId==undefined){
        addressId=0;
    }
    var name=$.trim($("#name").val());
    var consignee_province=$("#provinceId_m").val();
    var consignee_city=$("#cityId_m").val();
    var consignee_countyid=$("#areaId_m").val();
    var desc=$.trim($("#consignee_address").val());
    var mobile=$.trim($("#mobile").val());
    var addressPrefix=$("#area_div").html();
    $.ajax({
        url: url,
        type: 'POST',
        data:{
            addressId:addressId,
            name:name,
            province:consignee_province,
            city:consignee_city,
            area:consignee_countyid,
            address:desc,
            tel:mobile
        },
        dataType: 'json',
        success: function(result){
                console.log(result);
                if( result.err_code==0 ){
                        layer.msg("保存成功");
                        $("#userAddressId").val(result.err_msg.id);
                        $("#default_name").text(result.err_msg.name+' '+result.err_msg.tel);
                        $("#default_address").text(result.err_msg.full_address);
                        $defaultAddress.show();
                        $addressListDiv.hide();//地址列表
                        $addAddressDiv.hide();//填写框
                        $saveAddress.hide();//保存收货地址按钮
                        reloadAddress();//重新加载地址列表
                        $('#addressOpt').val('');
                }else {
                    layer.msg("服务器开小差了，请稍候再试！");
                }
        }
    });
}

function checkData(){
    var name=$.trim($("#name").val());
    var consignee_province=$("#consignee_province").val();
    var consignee_city=$("#consignee_city").val();
    var consignee_countyid=$("#consignee_countyid").val();
    var consignee_town=$("#consignee_town").val();
    if (consignee_town==''|| consignee_town == null){
        consignee_town=0;
    }
    var consignee_address=$.trim($("#consignee_address").val());
    var mobile=$.trim($("#mobile").val());

    var addressPrefix=$("#area_div").html();
    if (name==""){
        layer.msg('请填写收货人姓名');
        return false;
    }else if (name.length>20){
        layer.msg('收货人超出20个字');
        return false;
    }
    if (consignee_province=="" || consignee_province=="0" || consignee_province==0){
        layer.msg('请选择在地区省份');
        return false;
    }
    if (consignee_city=="" || consignee_city=="0" || consignee_city==0){
        layer.msg('请选择所在地区城市');
        return false;
    }
    if (consignee_countyid=="" || consignee_countyid=="0" || consignee_countyid==0){
        layer.msg('请选择所在地区市区或县');
        return false;
    }
    var temp1=$("#span_town").is(":visible");
    if (temp1){
        if(consignee_town=="" || consignee_town=="0" || consignee_town==0){
            layer.msg('请选择所在地区镇');
            return false;
        }
    }
    if(consignee_address==""){
        layer.msg('请完善收货地址');
        return false;
    }else if (consignee_address.length>50){
        layer.msg('收货地址超出50个字');
        return false;
    }

    var customReg =  /^1[3578][0-9]\d{8}$/g;
    var re = new RegExp(customReg);
    if ($('#addressOpt').val()=="modify"){
        if(mobile==""){
            layer.msg('请填写手机号');
            return false;
        }
        if (!(customReg.test(mobile)||new RegExp(/^\d{3}\*\*\*\*\d{4}$/).test(mobile))){
            layer.msg('输入的手机格式错误');
            return false;
        }
    }else{
        if(mobile==""){
            layer.msg('请填写手机号');
            return false;
        }
        if (!(customReg.test(mobile))){
            layer.msg('输入的手机格式有误');
            return false;
        }
    }

    return true;
}

/**************编辑收货地址*****************/
$editaddr.live("click",function(){
    $addAddressDiv.show();
    $saveAddress.show();
    $("#sjld").show();
    $("#addressOpt").val("modify");

    var address_id=$(this).attr("addressId");
    var address_name=$(this).attr("addressName");
    var address_mobile=$(this).attr("addressMobile");
    var address_addressDetail=$(this).attr("addressAddressDetail");
    var address_provinceId=$(this).attr("addressProvinceId");
    var address_cityId=$(this).attr("addressCityId");
    var address_countyId=$(this).attr("addressCountyId");
    $("#addrList_"+address_id).attr("checked",'checked');

    $("#userAddressId").val(address_id);
    $("#name").val(address_name);
    $("#consignee_address").val(address_addressDetail);
    $("#mobile").val(address_mobile);
    $("#area_div").html('');
    $('#provinceId_m').attr("data-province",address_provinceId);
    $('#cityId_m').attr("data-city",address_cityId);
    $('#areaId_m').attr("data-area",address_countyId);
    changeArea();
});
/******************删除收货地址*********************/
$removeAddress.live("click",function(){
    var indexs = $(this).parent().index();
    var addressId = $(this).attr("name");
    $.ajax({
        url: '?a=ajax_delAddess',
        type: 'POST',
        data:{addressId:addressId},
        dataType: 'json',
        success: function(result){
            if (result.err_code ==  0 ) {
                $(".take_p").eq(indexs).remove();
                layer.msg('删除成功');
                $addAddressDiv.hide();
                $defaultAddress.hide();
                $addressListDiv.show();
            } else {
                layer.msg('抱歉服务器开小差了，请稍候再试！');
            }
        }
    });
});
/*****************重新加载地址列表*******************/
function checkForm(){
    var userAddressId = $('#userAddressId').val();
    var remark = $("#orderRemark").val();
    var id = $("#record_id").val();
    var url= '?a=getprize';
    if(userAddressId<1){
        layer.msg("请设置收货地址!");
        return;
    }else{
        $.post(url,{id:id,remark:remark,userAddressId:userAddressId},function(sta){
            console.log(sta);
            if(sta.err_code==0){
                layer.alert(sta.err_msg, {
                    title:'温馨提示',
                    skin: 'layui-layer-molv', //样式类名
                    closeBtn: 0
                }, function(){
                  layerClose();//关闭框架
                });
            }else{
                layer.msg(sta.err_msg);
            }
        },'json')
    }
}
// 关闭框架
function layerClose(){
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
}
function reloadAddress(){
    var url='?a=ajax_reloadAddress';
    $.get(url,function(result){
            $("#addressListDiv").html("");
            if(result.err_code==0){
                $("#addressListDiv").html(result.err_msg);
            }else {
                layer.msg(result.err_msg);
            }
    },'json');
}


