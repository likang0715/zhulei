<?php if(!defined('PIGCMS_PATH')) exit('deny access!');?>
<!DOCTYPE html>
<html class="no-js" lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta name="keywords" content="<?php echo $config['seo_keywords'];?>" />
    <meta name="description" content="<?php echo $config['seo_description'];?>" />
    <meta name="HandheldFriendly" content="true"/>
    <meta name="MobileOptimized" content="320"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta http-equiv="cleartype" content="on"/>
    <link rel="icon" href="<?php echo $config['site_url'];?>/favicon.ico" />
    <title>收获地址</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/base.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>css/trade.css"/>
    <link rel="stylesheet" href="<?php echo TPL_URL;?>/css/offline_shop.css">
    <script src="<?php echo STATIC_URL;?>js/jquery.min.js"></script>
    <script src="<?php echo STATIC_URL;?>js/area/area.min.js"></script>
    <script src="<?php echo TPL_URL;?>js/base.js"></script>
    <script src="http://api.map.baidu.com/api?v=1.2" type="text/javascript"></script>
    <script>
        var postage = '<?php echo $nowOrder['postage'] ?>';
        var is_logistics = <?php echo ($now_store['open_logistics'] || $is_all_supplierproduct) ? 'true' : 'false' ?>;
        var is_selffetch = <?php echo ($now_store['buyer_selffetch'] && $is_all_selfproduct) ? 'true' : 'false' ?>;
    </script>
    <style>
        .qrcodepay {display:none;margin:0 10px 10px 10px;}
        .qrcodepay .item1{background:#fff;border:1px solid #e5e5e5;}
        .qrcodepay .title{margin:0 10px;padding:10px 0;border-bottom:1px solid #efefef;}
        .qrcodepay .info{text-align:center;line-height:25px;font-size:12px;}
        .qrcodepay .qrcode{margin-bottom:10px;}
        .qrcodepay .qrcode img{width:200px;height:200px;}
        .qrcodepay .item2 {background:#fff;border:1px solid #e5e5e5;margin:10px 0;line-height:40px;text-align:center;}
        .qrcodepay .item2 a{display:block;height:100%;width:100%;}
    </style>
</head>
	<body>
        <div id="addAdress" class="modal order-modal active">
            <div>
                <form class="js-address-fm address-ui address-fm">
                    <div class="block" style="margin-bottom:10px;">
                        <div class="block-item">
                            <label class="form-row form-text-row"><em class="form-text-label">收货人</em>
                                <span class="input-wrapper">
                                    <input type="text" name="user_name" class="form-text-input" value="<?php echo !empty($user_address['name']) ? $user_address['name'] : ''?>" placeholder="名字">
                                </span>
                            </label>
                        </div>
                        <div class="block-item">
                            <label class="form-row form-text-row"><em class="form-text-label">联系电话</em>
                                <span class="input-wrapper">
                                    <input type="tel" name="tel" class="form-text-input" value="<?php echo !empty($user_address['tel']) ? $user_address['tel'] : ''?>" placeholder="手机或固话">
                                </span>
                            </label>
                        </div>
                        <div class="block-item">
                            <div class="form-row form-text-row"><em class="form-text-label">选择地区</em>
                                <div class="input-wrapper input-region js-area-select">
                                    <span>
                                        <select id="s1" name="province" class="address-province"></select>
                                    </span>
                                    <span>
                                        <select id="s2" name="city" class="address-city"><option>城市</option></select>
                                    </span>
                                    <span>
                                        <select id="s3" name="county" class="address-county"><option>区县</option></select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="block-item">
                            <label class="form-row form-text-row"><em class="form-text-label">详细地址</em>
                                <span class="input-wrapper">
                                    <input type="text" name="address" class="form-text-input" value="<?php echo !empty($user_address['address']) ? $user_address['address'] : ''?>" placeholder="街道门牌信息">
                                </span>
                            </label>
                        </div>
                        <div class="block-item">
                            <label class="form-row form-text-row"><em class="form-text-label">邮政编码</em>
                                <span class="input-wrapper">
                                    <input type="tel" maxlength="6" name="zipcode" class="form-text-input" value="<?php echo !empty($user_address['zipcode']) ? $user_address['zipcode'] : ''?>" placeholder="邮政编码">
                                </span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <div class="action-container">
                            <input type="hidden" name="address_id" value="<?php echo !empty($address_id) ? $address_id : '';?>">
                            <a class="js-address-save btn btn-block btn-blue">保存</a>
                            <a class="js-address-quit btn btn-block " onclick="history.go(-1)">取消</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
		<script type="text/javascript">
            $(function(){
                getProvinces('s1', "<?php echo $user_address['province']; ?>");
                $('#s1').change(function(){
                    $('#s2').html('<option>选择城市</option>');
                    if($(this).val() != ''){
                        getCitys('s2','s1',"<?php echo $user_address['city']; ?>");
                    }
                    $('#s3').html('<option>选择地区</option>');
                }).trigger('change');
                $('#s2').change(function () {
                    getAreas('s3', 's2', "<?php echo $user_address['area']; ?>");
                }).trigger('change');



                $('.js-address-save').click(function(){
                    var address_id = $("input[name='address_id']").val();

                    var nameDom = $('input[name="user_name"]');
                    var name = $.trim(nameDom.val());
                    if(name.length == 0){
                        motify.log('请填写名字');
                        nameDom.focus();
                        return false;
                    }
                    //联系电话
                    var telDom = $('input[name="tel"]');
                    var tel = $.trim(telDom.val());
                    if(tel.length == 0){
                        motify.log('请填写联系电话');
                        telDom.focus();
                        return false;
                    }else if(!/^0[0-9\-]{10,13}$/.test(tel) && !/^((\+86)|(86))?(1)\d{10}$/.test(tel)){
                        motify.log('请填写正确的<br />手机号码或电话号码');
                        telDom.focus();
                        return false;
                    }
                    //地区
                    var province = parseInt($('select[name="province"]').val());
                    var city = parseInt($('select[name="city"]').val());
                    var area = parseInt($('select[name="county"]').val());
                    if(isNaN(province) || isNaN(city) || isNaN(area)){
                        motify.log('请选择地区');
                        return false;
                    }
                    //详细地址
                    var addressDom = $('input[name="address"]');
                    var address = $.trim(addressDom.val());
                    if(address.length == 0){
                        motify.log('请填写详细地址');
                        addressDom.focus();
                        return false;
                    }
                    //邮政编码
                    var zipcodeDom = $('input[name="zipcode"]');
                    var zipcode = $.trim(zipcodeDom.val());
                    if(zipcode.length > 0 && !/^\d{6}$/.test(zipcode)){
                        motify.log('邮政编码格式不正确');
                        zipcodeDom.focus();
                        return false;
                    }
                    var nowDom = $(this);
                    var hash = window.location.hash;
                    if(parseFloat(address_id)  > 0){
                        var post_url = './unitay_address.php?action=update';
                        var redirect_url = './user_address.php';
                        $.post(post_url,{'address_id':address_id,'user_name':name,'tel':tel,'province':province,'city':city,'area':area,'address':address,'zipcode':zipcode},function(data){
                            console.log(data.err_code);
                            if(data.err_code == 0){
                                motify.log(data.err_msg);
                                if(hash!='' && hash!=null){
                                    history.go(-1);
                                }else{
                                    setTimeout('location.replace("'+ redirect_url +'")',1000);//延时2秒
                                }
                            }else{
                                motify.log(data.err_msg);
                            }
                        });
                    }else{
                        var post_url = './unitay_address.php?action=add';
                        var redirect_url = './user_address.php';
                        $.post(post_url,{'user_name':name,'tel':tel,'province':province,'city':city,'area':area,'address':address,'zipcode':zipcode},function(data){
                            console.log(data.err_code);
                            if(data.err_code == 0){
                                motify.log(data.err_msg);
                                if(hash!='' && hash!=null){
                                    history.go(-1);
                                }else{
                                    setTimeout('location.replace("'+ redirect_url +'")',1000);//延时2秒
                                }
                            }else{
                                motify.log(data.err_msg);
                            }
                        });
                    }
                });

            });
		</script>
	</body>
</html>