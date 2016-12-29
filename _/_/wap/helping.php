<?php
/**
 * Created by PhpStorm.
 * User: gerrant
 * Date: 16-2-23
 * Time: 下午4:41
 */
require_once dirname(__FILE__) . '/global.php';

//获取控制器名字
$module = array('detail','firsthelp','helper_detail','cash_prize');
$action = in_array($_REQUEST['action'],$module)? $_REQUEST['action'] : pigcms_tips('没有指定模块');

//微信授权获取用户信息
$now_store = M('Store')->check_cookie($tmp_store_id);
$wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();
$avatar = $wap_user['avatar'] ? $wap_user['avatar']:getAttachmentUrl('images/touxiang.png', false);
$nickname = isset($wap_user['nickname']) ? $wap_user['nickname'] : '匿名';
$user_token = $wap_user['openid'] ? $wap_user['openid']:'token';
if($nickname=='匿名'){
    pigcms_tips('请在微信客户端打开链接',option('config.wap_site_url')."/home.php?id=".$store_id);
}

if ($action == 'detail') {
    $database_helping = D('Helping');
    $database_helping_news = D('Helping_news');
    $database_helping_prize = D('Helping_prize');
    $database_helping_user = D('Helping_user');
    $database_helping_record = D('Helping_record');

    $share_key = isset($_REQUEST['share_key'])?$_REQUEST['share_key']:'';
    $pid = isset($_REQUEST['id'])? trim($_REQUEST['id']):(isset($_REQUEST['amp;id'])?$_REQUEST['amp;id']:null);
    if(!isset($pid)){
        pigcms_tips('没有活动id',option('config.wap_site_url')."/home.php?id=".$store_id);
    }
    $ajax_key = rand(10000,99999);
    $_SESSION['ajax_key'] = $ajax_key;

    //获取活动基本信息
    unset($where);
    $where['id'] = $pid;
    $helping = $database_helping->where($where)->find();
    $store_id =  $helping['store_id'];
    if(empty($helping) || $helping['delete_flag']==1){
        pigcms_tips('找不到该活动',option('config.wap_site_url')."/home.php?id=".$store_id);
    }
    if($helping['is_open']==0){
        pigcms_tips('该活动已关闭',option('config.wap_site_url')."/home.php?id=".$store_id);
    }

    //获取活动宣传图片
    unset($where);
    $where['pid'] = $pid;
    $helping_news = $database_helping_news->where($where)->select();

    //获取活动奖品图片
    unset($where);
    $where['pid'] = $pid;
    $helping_prizes_count = $database_helping_prize->where($where)->count('id');
    if($helping_prizes_count>0){
        $helping_prizes = $database_helping_prize->where($where)->select();
        foreach($helping_prizes as $hpk=>$hpv){
            if($hpv['type']==1){
                $rs = M('Product')->get(array('product_id'=>$hpv['title']), 'name');
                $helping_prizes[$hpk]['title'] = $rs['name'];
            }elseif($hpv['type']==2){
                unset($where);
                $where['id'] = $hpv['title'];
                $where['type'] = 1;
                $rs = M('Coupon')->getCoupon($where);
                $helping_prizes[$hpk]['title'] = $rs['name'];
                $helping_prizes[$hpk]['value'] = $rs['face_money'];
                if($rs['limit_money']==0){
                    $helping_prizes[$hpk]['limit'] = "无限制";
                }else{
                    $helping_prizes[$hpk]['limit'] = "满".$rs['limit_money']."元可使用";
                }
            }elseif($hpv['type']==3){
                $helping_prizes[$hpk]['value'] = $hpv['title'];
                $helping_prizes[$hpk]['title'] = "店铺积分";
            }
        };
    };

    //我的参与信息
    unset($where);
    $where['pid'] = $pid;
    $where['token'] = $user_token;
    $my_join_count = $database_helping_user->where($where)->count('id');
    if($my_join_count>0){
        $my_join_info = $database_helping_user->where($where)->find();
    }

    //分享者基本信息
    unset($where);
    $where['pid'] = $pid;
    $where['token'] = $_GET['share_key'];
    $share_join_count = $database_helping_user->where($where)->count('id');
    if(isset($_GET['share_key'])){
        //分享者分享数增加
        $sharewhere['pid'] = $pid;
        $sharewhere['token'] = $_GET['share_key'];
        $database_helping_user->where($sharewhere)->setInc('share_num',1);
        //获取分享者详情
        if($share_join_count>0 && $_GET['share_key']!=$user_token){
            $share_join_info = $database_helping_user->where($where)->find();
            $avatar = $share_join_info['avatar'] ? $share_join_info['avatar']:getAttachmentUrl('images/touxiang.png', false);
            $nickname = isset($share_join_info['nickname']) ? $share_join_info['nickname'] : '匿名';
        }else{
            redirect('./helping.php?action=detail&id='.$pid);
        };
    };

    //我的助力信息
    if(isset($_GET['share_key'])){
        unset($where);
        $where['pid'] = $pid;
        $where['token'] = $user_token;
        $where['share_key'] = $_GET['share_key'];
        $my_help_count = $database_helping_record->where($where)->count('id');
    }else{
        $my_help_count = 1;
    }

    //排行榜
    unset($where);
    $where['pid'] = $pid;
    $rank = $database_helping_user->where($where)->order('help_count desc')->select();
    $rank_name = array();
    foreach($rank as $rk=>$rv){
        $rank_name[$rk+1] = $rv['token'];
    };
    if(isset($_GET['share_key'])){
        $my_rank = array_search($_GET['share_key'],$rank_name);
    }else{
        $my_rank = array_search($user_token,$rank_name);
    };

    //活动进行状态
    $now = time();
    if ($now < strtotime($helping["start_time"])) {//未开始
        $is_over = 1;
    } elseif (strtotime($helping["end_time"]) < $now) {//已结束
        $is_over = 2;
    } else {
        $is_over = 0;
    }

    //计算获奖者token
    if($is_over == 2){
        unset($where);
        $where['pid'] = $pid;
        $prize_winners = $database_helping_user->where($where)->order('help_count desc')->limit($helping_prizes_count)->field('token')->select();
    }

    //是否关注商家公众号
    $act_type = 'helping';
    $show_subscribe_div     = false;
    //关注助力还是关注助力
    if (isset($_GET['share_key'])) {
        //关注助力
        if ($helping['is_help']==0) {
            $qrcode = M('Store')->concernRelationship(800000000, $wap_user['uid'], $store_id, 2, $act_type, $helping['id'] ,$_GET['share_key']);
            if ($qrcode['error_code'] == 0) {
                $is_subscribe = M('Store')->is_subscribe_store($wap_user['uid'],$store_id);
                $show_subscribe_div     = true;
            }
        }
    } else {
        //关注助力
        if ($helping['is_attention'] == 0) {
            $qrcode = M('Store')->concernRelationship(800000000, $wap_user['uid'], $store_id, 2, $act_type, $helping['id']);
            if ($qrcode['error_code'] == 0) {
                $is_subscribe = M('Store')->is_subscribe_store($wap_user['uid'],$store_id);
                $show_subscribe_div     = true;
            }
        }
    }

    include display("helping_detail");
    echo ob_get_clean();
} elseif($action == 'firsthelp'){
    if($_SESSION['ajax_key']!=$_POST['ajax_key']){
        json_return(1001,"提交成功，请勿重复提交");
    }
    $database_helping_user = D("Helping_user");
    $database_helping_record = D("Helping_record");

    $pid = intval($_POST['id']);
    $share_key = $_POST['share_key'];

    //判断是否参与者分享
    unset($where);
    $where['token'] = $share_key;
    $where['pid'] = $pid;
    $is_share = $database_helping_user->where($where)->count('id');
    if($is_share>0){//助力
        $ures = $database_helping_user->where($where)->setInc('help_count',1);
        if($ures){
            $recorddata['pid'] = $pid;
            $recorddata['token'] = $user_token;
            $recorddata['nickname'] = $nickname;
            $recorddata['avatar'] = $avatar;
            $recorddata['share_key'] = $share_key;
            $recorddata['addtime']  = time();
            $rres = $database_helping_record->data($recorddata)->add();
            if($rres){
                $json_return['err_code'] = 10;
                $json_return['id'] = $pid;
                $json_return['share_key'] = $share_key;
                unset($_SESSION['ajax_key']);
            }else{
                json_return(1002,"添加助力纪录失败");
            }
        }else{
            json_return(1003,"添加参与用户失败");
        }
    }else{//参与
        $userdata['pid'] = $pid;
        $userdata['token'] = $user_token;
        $userdata['nickname'] = $nickname;
        $userdata['avatar'] = $avatar;
        $userdata['help_count'] = 1;
        $userdata['help_count'] = 1;
        $userdata['share_num'] = 0;
        $userdata['add_time']  = time();
        $ures = $database_helping_user->data($userdata)->add();
        if($ures){
            $json_return['err_code'] = 10;
            $json_return['id'] = $pid;
            unset($_SESSION['ajax_key']);
        }else{
            json_return(1004,"添加参与用户失败");
        }
    }

    if(!headers_sent()) header('Content-type:application/json');
    exit(json_encode($json_return, true));

    echo ob_get_clean();
} elseif($action == 'helper_detail'){
    $database_helping_user = D('Helping_user');
    $database_helping_record = D('Helping_record');

    $pid = isset($_REQUEST['id'])? trim($_REQUEST['id']):(isset($_REQUEST['amp;id'])?$_REQUEST['amp;id']:null);

    //参与信息
    unset($where);
    $where['pid'] = $pid;
    $where['token'] = $_GET['share_key'];
    $share_join_count = $database_helping_user->where($where)->count('id');
    if($share_join_count>0){
        $share_join_info = $database_helping_user->where($where)->find();
        $avatar = $share_join_info['avatar'] ? $share_join_info['avatar']:getAttachmentUrl('images/touxiang.png', false);
        $nickname = isset($share_join_info['nickname']) ? $share_join_info['nickname'] : '匿名';
    };

    //排行榜
    unset($where);
    $where['pid'] = $pid;
    $rank = $database_helping_user->where($where)->order('help_count desc')->select();
    $rank_name = array();
    foreach($rank as $rk=>$rv){
        $rank_name[$rk+1] = $rv['token'];
    };
    if(isset($_GET['share_key'])){
        $my_rank = array_search($_GET['share_key'],$rank_name);
    }else{
        $my_rank = array_search($user_token,$rank_name);
    };

    //获取帮助力列表
    unset($where);
    $where['pid'] = $pid;
    $where['share_key'] = $_GET['share_key'];
    $helps_count = $database_helping_record ->where($where)->count('id');
    if($helps_count>0){
        $helps_list = $database_helping_record ->where($where)->limit(99)->select();
    };

    include display("helping_helper_detail");

    echo ob_get_clean();
} elseif($action == 'cash_prize'){
    if($_SESSION['ajax_key']!=$_POST['ajax_key']){
        json_return(1001,"提交成功，请勿重复提交");
    }
    $database_helping = D('Helping');
    $database_helping_prize = D('Helping_prize');
    $database_helping_user = D('Helping_user');

    $type = (int)$_POST['type'];
    $pid = (int)$_POST['pid'];
    $num = (int)$_POST['num']+1;

    //活动信息
    unset($where);
    $where = "id = '".$pid."' and is_open=1 and delete_flag=0";
    $helping = $database_helping->where($where)->find();
    if(empty($helping)){
        json_return(1000,'没有这个活动的相关信息');
    }
    //获奖资格查询
    unset($where);
    $where['pid'] = $pid;
    $prize_winners = $database_helping_user->where($where)->order('help_count desc')->limit(10)->field('token')->select();
    if($prize_winners[$num-1]['token']!=$user_token){
        json_return(1000,'改奖项并不属于你');
    }
    //奖品信息查询
    unset($where);
    $where['type'] = $type;
    $where['pid'] = $pid;
    $where['num'] = $num;
    $prize_info = $database_helping_prize->where($where)->find();
    if(empty($prize_info)){
        json_return(1000,'无法获取奖品信息');
    }
    if($prize_info['is_cash']==1){
        json_return(1000,'奖品已经兑换');
    }

    // 奖品类型（1商品2优惠券3店铺积分4其他）
    if($prize_info['type'] == 1){// 商品
        // 直接生成已支付的订单
        $productarr = explode('_',$prize_info['title']);
        if(isset($productarr[0])){
            $product_id = $productarr[0];
        };
        if(isset($productarr[1])){
            $sku_id = $productarr[1];
        }

        $order_id = M("Helping")->prize_product($helping['store_id'],$product_id,$sku_id);
        $rs = $database_helping_prize->where(array('pid'=>$pid,'num'=>$num))->data(array('is_cash' => $order_id,'prize_time'=>time()))->save();
        if($rs){
            unset($_SESSION['ajax_key']);
            $json_return['err_code'] = 0;
            $json_return['id'] = $pid;
        }else{
            json_return(1000,'兑将失败');
        }
    }
    if($prize_info['type'] == 2){	// 优惠券
        $res = M("Helping")->prize_coupon($prize_info['title']);
        if($res['err_code'] > 0){
            json_return($res['err_code'],$res['err_msg']);
        }
        $rs = $database_helping_prize->where(array('pid'=>$pid,'num'=>$num))->data(array('is_cash' => 1,'prize_time'=>time()))->save();
        if($rs){
            unset($_SESSION['ajax_key']);
            $json_return['err_code'] = 0;
            $json_return['id'] = $pid;
        }else{
            json_return(1000,'兑将失败');
        }
    }
    if($prize_info['type'] == 3){	// 店铺积分
        $data = array();
        $data['uid'] = $_SESSION['wap_user']['uid'];
        $data['store_id'] = $helping['store_id'];
        $data['type'] = 16;
        $data['is_available'] = 1;
        $data['timestamp'] = time();
        $data['points'] = $prize_info['title'];
        $data['bak'] = '中奖积分';
        $result = D('User_points')->data($data)->add();
        if($result){
            M('Store_user_data')->changePoint($helping['store_id'], $_SESSION['wap_user']['uid'], $data['points']);
            $rs = $database_helping_prize->where(array('pid'=>$pid,'num'=>$num))->data(array('is_cash' => 1,'prize_time'=>time()))->save();
            if($rs){
                unset($_SESSION['ajax_key']);
                $json_return['err_code'] = 0;
                $json_return['id'] = $pid;
            }else{
                json_return(1000,'兑将失败');
            }
        }
    }
    if($prize_info['type'] == 4){// 线下兑奖
        $prize_key = isset($_POST['code'])?$_POST['code']:"未填写";
        $tel = isset($_POST['tel'])?$_POST['tel']:"号码未填写";
        if($helping['prizecode']==$prize_key){
            $rs = $database_helping_prize->where(array('pid'=>$pid,'num'=>$num))->data(array('is_cash' => 1,'prize_time'=>time(),'code'=>$tel))->save();
            if($rs){
                unset($_SESSION['ajax_key']);
                $json_return['err_code'] = 0;
                $json_return['id'] = $pid;
            }else{
                json_return(1000,'兑奖失败');
            }
        }else{
            json_return(1000,'领奖码错误');
        }

    }

    if(!headers_sent()) header('Content-type:application/json');
    exit(json_encode($json_return, true));
}

?>
