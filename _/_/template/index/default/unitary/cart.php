<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="1元夺宝，就是指只需1元就有机会获得一件商品，是基于彼岸互联邮箱平台孵化的新项目，好玩有趣，不容错过。">
    <meta name="keywords" content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵">
    <title>清单 - 夺宝</title>
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/bef6decb938119df87327e5e548e997f221af746.css">
    <link rel="stylesheet" type="text/css" href="<?php echo STATIC_URL;?>unitary/css/b5c1278e0e0fe59171c31ecba188867811c2934d.css">
    <script src="<?php echo STATIC_URL;?>unitary/js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/cart.js"></script>
    <script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/common.js"></script>
    <script type="text/javascript">
        var cart_ajax_url = "<?php echo dourl('unitary:cartajax') ?>";
        var cart_ajax_round = "<?php echo dourl('unitary:round_list') ?>";
        var cart_balance_url = "<?php echo dourl('unitary:cart_balance') ?>";
    </script>
<body>
<div class="g-header" module="header/Header" id="pro-view-0" module-id="module-1" module-launched="true">
    <div class="m-toolbar" module="toolbar/Toolbar" id="pro-view-4" module-id="module-4" module-launched="true">
        <div class="g-wrap f-clear">
            <div class="m-toolbar-l">
                <?php if(empty($user_session)){?>
                    Hi，欢迎来 <?php echo option('config.site_name');?>&nbsp;<a class="link-login style-red" target="_top" href="<?php echo url('account:login') ?>">请登录</a>&nbsp;&nbsp;
                    <a class="link-regist style-red"  target="_top" href="<?php echo url('account:register') ?>" >免费注册</a>  
                <?php }else{?>  
                    你好，<a class="link-login" href="<?php echo url('account:index') ?>" ><?php echo $user_session['nickname'];?>&nbsp;&nbsp;
                    <a class="link-regist style-red" target="_top" href="<?php echo url('account:logout') ?>">退出</a>                            
                <?php }?>
            </div>
            <ul class="m-toolbar-r">
                <li class="m-toolbar-myBonus"><a href="<?php dourl('index:index') ?>">返回主电商</a><var>|</var></li>
                <li class="m-toolbar-myDuobao">
                    <a class="m-toolbar-myDuobao-btn" href="<?php echo dourl('unitary:account') ?>">
                        我的夺宝 <i class="ico ico-arrow-gray-s ico-arrow-gray-s-down"></i>
                    </a>
                    <ul class="m-toolbar-myDuobao-menu">
                        <li><a href="<?php echo dourl('unitary:account') ?>">夺宝记录</a></li>
                        <li class="m-toolbar-myDuobao-menu-win"><a href="<?php echo dourl('unitary:account', array('type'=>'luck')) ?>">幸运记录</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="g-body">
    <div class="m-cart">
        <div class="m-header f-clear">
            <div class="m-header-logo">
                <h1><a class="m-header-logo-link" href="<?php echo dourl('unitary:index') ?>">一元夺宝</a></h1>
            </div>
            <div class="m-cart-order-steps"><div class="w-step-duobao w-step-duobao-1"></div></div>
        </div>
        <div class="m-cart-content">

            <div module="cart/Cart" id="pro-view-4" module-id="module-4" module-launched="true">
                <div id="pro-view-11">
                    <!-- 购物车列表 -->
                    <ul class="m-cart-list m-cart-th">
                        <li class="m-cart-list-items m-cart-list-header f-clear">
                            <div class="cart-list-items-name items-content-checkbox">
                                <label class="w-checkbox" id="pro-view-20"> </label>
                            </div>
                            <div class="cart-list-items-name items-content-gpic">商品名称</div>
                            <div class="cart-list-items-name items-content-gname"></div>
                            <div class="cart-list-items-name items-content-price">价值</div>
                            <div class="cart-list-items-name items-content-buyunit">夺宝价</div>
                            <div class="cart-list-items-name items-content-numberInput">参与人次</div>
                            <div class="cart-list-items-name items-content-numberInput"> </div>
                            <div class="cart-list-items-name items-content-total">小计</div>
                            <div class="cart-list-items-name items-content-operation">操作</div>
                        </li>
                        <li class="m-cart-list-items f-clear js-cart-null" <?php if (!empty($cart_list)) { echo 'style="display:none"'; } ?>><div class="cart-empty-tips"><p>您的清单里还没有任何商品，<a href="<?php echo dourl('unitary:index') ?>">马上去逛逛~</a></p></div></li>
                    </ul>
                    <?php foreach ($cart_list as $val) { ?>
                    <ul class="m-cart-list m-cart-tr js-cart-shop">
                        <li class="m-cart-list-items m-cart-list-header f-clear">
                            <div class="cart-list-items-name items-content-checkbox">
                                <label class="w-checkbox"><input type="checkbox" class="js-checkbox-shop" value="<?php echo $val['shop']['store_id'] ?>" data-store_id="<?php echo $val['shop']['store_id'] ?>"> </label>
                            </div>
                            <div class="cart-list-items-name items-content-gpic"><?php echo $val['shop']['name'] ?></div>
                        </li>
                        <?php foreach ($val['list'] as $v) { ?>
                        <li class="m-cart-list-items f-clear">
                            <div class="cart-list-items-content items-content-checkbox">
                                <span pro="checkbox"><label class="w-checkbox"><input type="checkbox" class="js-checkbox-item" data-store_id="<?php echo $val['shop']['store_id'] ?>" data-item_price="<?php echo $v['unitary']['item_price'] ?>" value="<?php echo $v['id'] ?>" disabled="disabled"></label></span>
                            </div>
                            <div class="cart-list-items-content items-content-gpic">
                                <img src="<?php echo $v['unitary']['logopic'] ?>" alt="<?php ?>">
                            </div>
                            <div class="cart-list-items-content items-content-gname">
                                <p><a href="<?php echo dourl('unitary:detail', array('id'=>$v['unitary']['id'])) ?>" target="_blank"><?php echo $v['unitary']['name'] ?></a></p>
                                <p>总需<span style="color: #39f;"><?php echo $v['unitary']['total_num'] ?></span>人次参与，还剩：<span class="js-rest-num"><?php echo $v['unitary']['left_count'] ?></span>人次</p>
                            </div>
                            <div class="cart-list-items-content items-content-price f-cart-item-center"><p><?php echo $v['unitary']['price'] ?>元</p></div>
                            <div class="cart-list-items-content items-content-buyunit f-cart-item-center"><p><?php echo $v['unitary']['item_price'] ?>元</p></div>
                            <div class="cart-list-items-content items-content-numberInput">
                                <span pro="number" class="items-content-numberInput-number">
                                    <div class="w-number">
                                        <a class="w-number-btn w-number-btn-minus js-cart-minus" href="javascript:void(0);">－</a>
                                        <input class="w-number-input js-cart-num" type="text" value="<?php echo $v['count'] ?>">
                                        <a class="w-number-btn w-number-btn-plus js-cart-plus" href="javascript:void(0);">＋</a>
                                    </div>
                                </span>
                            </div>
                            <div class="cart-list-items-content items-content-numberInput"> </div>
                            <div class="cart-list-items-content items-content-total f-cart-item-center">
                                <span><em class="js-cart-amount"><?php echo $v['count']*$v['unitary']['item_price'] ?></em>元</span>
                            </div>
                            <div class="cart-list-items-content items-content-operation f-cart-item-center">
                                <a href="javascript:void(0)" class="js-delete-item">删除</a>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                    <div class="m-cart-list-footer f-clear" pro="footer">
                        <div id="pro-view-21">
                            <div class="cart-list-footer-total">
                                <p class="txt-bold">总计：<strong id="totalAmount">0</strong>&nbsp;元</p>
                            </div>
                            <div class="cart-list-footer-checkbox">
                                <span pro="footercheckbox"><label class="w-checkbox" id="pro-view-22"><!-- <input type="checkbox" checked=""> --></label></span>
                            </div>
                            <div class="cart-list-footer-operation f-cart-list-footer-center">
                                <a href="javascript:void(0)" class="js-delete-all">清空购物车</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 购物记录操作栏 -->
                <div class="m-cart-content-footer" pro="submitview">
                    <div class="footer-submit-btn" pro="submit">
                        <button class="w-button w-button-main" type="button" id="balanceBtn" style="width: 118px; height: 45px; line-height: 45px; font-size: 16px;">
                            <span>去结算</span>
                        </button>
                    </div>
                    <div class="footer-returnhome-btn" pro="returnhome"><a class="w-button w-button-aside" href="<?php echo dourl('unitary:index') ?>" target="_self" id="pro-view-24" style="width: 66px; height: 45px; line-height: 45px; font-size: 14px;"><span>返回首页</span></a></div>
                    <span pro="antiaddiction"><p style="float: right;clear: right;margin-top: 13px;color: #808080;font-size: 13px;" id="pro-view-28">夺宝有风险，参与需谨慎</p></span>
                </div>
                <!-- 服务协议 -->
                <div style="margin-top: 15px;" id="pro-view-26">
                    <div style="float:right;clear:right;margin-bottom:10px;">
                        <label class="w-checkbox"><input type="checkbox" class="js-agreementchk"> <span>我已阅读并同意《服务协议》</span></label>
                    </div>
                    <div style="width: 100%;height: 330px;border: 2px solid #ddd;overflow-y: auto;">
                        <h4 style="margin-bottom:10px;color:#000;text-align:center;font-size:20px;font-weight:bold">一元夺宝平台服务协议</h4>
                        <div style="color:#000;text-indent:2em;font-size:14px;word-wrap:break-word;word-break:break-all">
                            <p>欢迎访问一元夺宝平台（http://1.163.com），申请使用彼岸互联公司提供的一元夺宝平台服务（包括一元夺宝和全价购买服务），请您（下列简称为“用户”）仔细阅读以下全部内容<b style="text-decoration:underline">（特别是粗体下划线标注的内容）</b>。如用户不同意本服务条款任意内容，请勿注册或使用一元夺宝平台服务。如用户通过进入注册程序并勾选“我同意一元夺宝平台服务协议”，即表示用户与彼岸互联公司已达成协议，自愿接受本服务条款的所有内容。此后，用户不得以未阅读本服务条款内容作任何形式的抗辩。</p>
                            <p style="margin-top:20px;"><b>一、用户使用一元夺宝平台服务的前提条件</b></p>
                            <p>1、用户拥有彼岸互联公司认可的帐号，包括但不限于：</p>
                            <p>（1）彼岸互联邮箱帐号，用户通过彼岸互联邮箱帐号使用一元夺宝平台服务的，本服务协议是《彼岸互联邮箱帐号服务条款》的补充条款，与《彼岸互联邮箱帐号服务条款》具有同等法律效力。</p>
                            <p>（2）第三方帐号，用户可使用QQ帐号、微信帐号、微博帐号等其他彼岸互联公司认可的帐号在同意本服务条款后使用一元夺宝平台服务。</p>
                            <p>2、用户在使用一元夺宝平台服务时须具备相应的权利能力和行为能力，能够独立承担法律责任，如果用户在18周岁以下，必须在父母或监护人的监护参与下才能使用本站。</p>
                            <p style="margin-top:20px;"><b>二、用户管理</b></p>
                            <p>1、用户ID</p>
                            <p>用户首次登录一元夺宝平台时，一元夺宝平台会为每位用户生成一个帐户ID，作为其使用一元夺宝平台服务的唯一身份标识，用户需要对其帐户项下发生的所有行为负责。</p>
                            <p>2、用户资料完善</p>
                            <p>用户应当在使用一元夺宝平台服务时完善个人资料，用户资料包括但不限于个人手机号码、收货地址、帐号昵称、头像、密码、注册或更新彼岸互联邮箱帐号时输入的所有信息。</p>
                            <p>用户在完善个人资料时承诺遵守法律法规、社会主义制度、国家利益、公民合法权益、公共秩序、社会道德风尚和信息真实性等七条底线，不得在资料中出现违法和不良信息，且用户保证其在完善个人资料和使用帐号时，不得有以下情形：</p>
                            <p>（1）违反宪法或法律法规规定的；</p>
                            <p>（2）危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；</p>
                            <p>（3）损害国家荣誉和利益的，损害公共利益的；</p>
                            <p>（4）煽动民族仇恨、民族歧视，破坏民族团结的；</p>
                            <p>（5）破坏国家宗教政策，宣扬邪教和封建迷信的；</p>
                            <p>（6）散布谣言，扰乱社会秩序，破坏社会稳定的</p>
                            <p>（7）散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；</p>
                            <p>（8）侮辱或者诽谤他人，侵害他人合法权益的；</p>
                            <p>（9）含有法律、行政法规禁止的其他内容的。</p>
                            <p>若用户提供给彼岸互联公司的资料不准确，不真实，含有违法或不良信息的，彼岸互联公司有权不予完善，并保留终止用户使用一元夺宝平台服务的权利。若用户以虚假信息骗取帐号ID或帐号头像、个人简介等注册资料存在违法和不良信息的，彼岸互联公司有权采取通知限期改正、暂停使用、注销登记等措施。对于冒用关联机构或社会名人注册帐号名称的，彼岸互联公司有权注销该帐号，并向政府主管部门进行报告。</p>
                            <p>根据相关法律、法规规定以及考虑到一元夺宝平台服务的重要性，用户同意：</p>
                            <p>（1）在完善资料时提交个人有效身份信息进行实名认证；</p>
                            <p>（2）提供及时、详尽及准确的用户资料；</p>
                            <p>（3）不断更新用户资料，符合及时、详尽准确的要求，对完善个人资料时填写的身份证件信息不能更新。</p>
                            <p>（4）<b style="text-decoration:underline">用户有证明该帐号为本人所有的义务，需能提供彼岸互联邮箱注册资料或第三方平台注册资料以证明该帐号为本人所有，否则彼岸互联公司有权暂缓向用户交付其所获得的商品。</b></p>
                            <p>3、夺宝币及宝石</p>
                            <p>（1）<b style="text-decoration:underline">用户兑换夺宝币并使用后可根据宝石获得规则获取相应的宝石。夺宝币的有效期自兑换之日起算360天，有效期不可中断或延期，有效期届满后，用户帐户中有效期届满的夺宝币将被清空，且不可恢复。宝石自获取之日起生效，使用期限将在宝石规则中规定，详见“我的夺宝”下的“我的宝石”栏目。</b></p>
                            <p>（2）夺宝币必须通过彼岸互联公司提供或认可的平台获得，从非彼岸互联公司提供或认可的平台所获得的夺宝币将被认定为来源不符合本服务协议，彼岸互联公司有权拒绝从非彼岸互联公司提供或认可的平台所获得的夺宝币在一元夺宝平台中使用。</p>
                            <p>（3）<b style="text-decoration:underline">夺宝币及宝石不能在一元夺宝平台之外使用或者转移给其他用户。</b></p>
                            <p>4、用户应当保证在使用一元夺宝平台服务的过程中遵守诚实信用原则，不扰乱一元夺宝平台的正常秩序，<b style="text-decoration:underline">不得通过使用他人帐户、一人注册多个帐户、使用程序自动处理等非法方式损害他人或彼岸互联公司的利益。</b></p>
                            <p>5、若用户存在任何违法或违反本服务协议约定的行为，彼岸互联公司有权视用户的违法或违规情况适用以下一项或多项处罚措施：</p>
                            <p><b style="text-decoration:underline">（1）责令用户改正违法或违规行为；</b></p>
                            <p><b style="text-decoration:underline">（2）中止、终止部分或全部服务；</b></p>
                            <p><b style="text-decoration:underline">（3）取消用户夺宝订单并取消商品发放（若用户已获得商品）， 且用户已获得的夺宝币不予退回；</b></p>
                            <p><b style="text-decoration:underline">（4）冻结或注销用户帐号及其帐号中的夺宝币（如有）；</b></p>
                            <p><b style="text-decoration:underline">（5）其他彼岸互联公司认为合适在符合法律法规规定的情况下的处罚措施。</b></p>
                            <p><b style="text-decoration:underline">若用户的行为造成彼岸互联公司及其关联公司损失的，用户还应承担赔偿责任。</b></p>
                            <p><b style="text-decoration:underline">6、若用户发表侵犯他人权利或违反法律规定的言论，彼岸互联公司有权停止传输并删除其言论、禁止该用户发言、注销用户帐号及其帐号中的夺宝币（如有），同时，彼岸互联公司保留根据国家法律法规、相关政策向有关机关报告的权利。</b></p>
                            <p style="margin-top:20px;"><b>三、一元夺宝平台服务的规则</b></p>
                            <p>1、释义</p>
                            <p>（1）夺宝币：指用户为获得商品所支付并由彼岸互联公司预收货款后获得的使用一元夺宝平台服务的凭据。</p>
                            <p>（2）夺宝号码：指用户使用夺宝币参与一元夺宝服务时所获取的随机分配号码。</p>
                            <p>（3）幸运号码：指与某件商品的全部夺宝号码分配完毕后，一元夺宝根据夺宝规则（详见一元夺宝官方页面）计算出的一个号码。持有该幸运号码的用户可直接获得该商品。</p>
                            <p>（4）宝石：指用户参与一元夺宝平台活动后，其获得的夺宝号码中未包含幸运号码的情况下，可获取的相应回报。</p>
                            <p>（5）全价购买：指用户以固定价格直接获得一元夺宝平台商品的形式。</p>
                            <p>（6）一元夺宝：指用户花费一元兑换一个夺宝币，然后凭夺宝币参与一元夺宝平台活动，并在使用夺宝币后根据宝石获得规则获取相应宝石的形式。</p>
                            <p>2、彼岸互联公司承诺遵循公平、公正、公开的原则运营一元夺宝平台，确保所有用户在一元夺宝平台中享受同等的权利与义务，夺宝结果向所有用户公示。</p>
                            <p>3、用户知悉，除本协议另有约定外，无论是否获得商品，用户用于参与一元夺宝平台活动的夺宝币不能退回；其完全了解参与一元夺宝平台活动存在的风险，彼岸互联公司不保证用户参与一元夺宝一定会获得商品，但参与后可根据宝石规则获得相应的宝石。宝石规则，详见“我的夺宝”下的“我的宝石”栏目。</p>
                            <p><b style="text-decoration:underline">4、用户通过参与一元夺宝平台活动获得商品后，应在7天内登录一元夺宝平台提交或确认收货地址，否则视为放弃该商品，用户因此行为造成的损失，彼岸互联公司不承担任何责任。</b>商品由彼岸互联公司或经彼岸互联公司确认的第三方商家提供及发货。</p>
                            <p>5、用户通过参与一元夺宝平台活动获得的商品，享受该商品生产厂家提供的三包服务，具体三包规定以该商品生产厂家公布的为准。</p>
                            <p><b style="text-decoration:underline">6、如果下列情形发生，彼岸互联公司有权取消用户夺宝订单：</b></p>
                            <p><b style="text-decoration:underline">（1）因不可抗力、一元夺宝平台系统发生故障或遭受第三方攻击，或发生其他彼岸互联公司无法控制的情形；</b></p>
                            <p><b style="text-decoration:underline">（2）根据彼岸互联公司已经发布的或将来可能发布或更新的各类规则、公告的规定，彼岸互联公司有权取消用户订单的情形。</b></p>
                            <p><b style="text-decoration:underline">彼岸互联公司有权取消用户的订单时，用户可申请退还夺宝币，所退夺宝币将在3个工作日内退还至用户帐户中。</b></p>
                            <p>7、若某件商品的夺宝号码从开始分配之日起90天未分配完毕，则彼岸互联公司有权取消该件商品的夺宝活动，并向用户退还夺宝币，所退还夺宝币将在3个工作日内退还至用户帐户中。</p>
                            <p style="margin-top:20px;"><b>四、本服务协议的修改</b></p>
                            <p>用户知晓彼岸互联公司不时公布或修改的与本服务协议有关的其他规则、条款及公告等是本服务协议的组成部分。彼岸互联公司有权在必要时通过在一元夺宝平台内发出公告等合理方式修改本服务协议，用户在享受各项服务时，应当及时查阅了解修改的内容，并自觉遵守本服务协议。用户如继续使用本服务协议涉及的服务，则视为对修改内容的同意，当发生有关争议时，以最新的服务协议为准；用户在不同意修改内容的情况下，有权停止使用本服务协议涉及的服务。</p>
                            <p style="margin-bottom:30px;">如用户对本规则内容有任何疑问，可拨打客服电话（<span style="text-decoration:underline">4000178163</span>）或登录帮助中心（<a href="http://help.mail.163.com/feedback.do?m=add&amp;categoryName=%e4%b8%80%e5%85%83%e5%a4%ba%e5%ae%9d" target="_blank">http://help.mail.163.com/feedback.do?m=add&amp;categoryName=%e4%b8%80%e5%85%83%e5%a4%ba%e5%ae%9d</a>）进行查询。</p>
                        </div>			
                    </div>
                </div>
            </div>
            <!-- 推荐夺宝 -->
            <div style="margin-top:30px;">
                <div class="w-goodsRecommend">
                    <div class="w-hd">
                        <h3 class="w-hd-title">推荐夺宝</h3>
                        <a class="w-hd-refresh js-pswitch" href="javascript:void(0);">
                            <i class="ico ico-refresh"></i>换一批
                        </a>
                    </div>
                    <div class="w-recommend-bd">
                        <ul class="w-goodsList f-clear js-goods-list"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include display('public:footer_unitary'); ?>

</div>
</body>
<script type="text/javascript" src="<?php echo STATIC_URL;?>unitary/js/common.js"></script>
</html>