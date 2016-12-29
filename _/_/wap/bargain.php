<?php
/**
 * Created by PhpStorm.
 * User: gerrant
 * Date: 16-2-23
 * Time: 下午4:41
 */
require_once dirname(__FILE__) . '/global.php';

//获取控制器名字
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
$table_name = isset($_REQUEST['table_name']) ? trim($_REQUEST['table_name']) : 'all';

if ($action == 'list') {
    if(IS_POST){
        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $pagesize = isset($_POST['pagesize']) ? intval($_POST['pagesize']) : 10;
        $orderBy = isset($_POST['order']) ? htmlspecialchars($_POST['order']) : 'asc';

        $page = max(1, $page);
        $start = ($page - 1) * $pagesize;

        $order = 'pigcms_id DESC';
        if ($orderBy == 'asc') {
            $order = 'pigcms_id ASC';
        }

        $where = array();
        $where['state'] = 1;
        $where['delete_flag'] = 0;

        $total = D('pigcms_bargain')->where($where)->count('id');
        $list = D('pigcms_bargain')->where($where)->order($order)->limit($start.','.$pagesize)->select();

        $page = ($start + $pagesize) < $total ? ($page + 1) : 0;

        $tmp_list = array();
        foreach ($list as $key => $val) {
            $tmp_list[$key]['id'] = $val['pigcms_id'];
            $tmp_list[$key]['pic'] = $val['logoimg1'];
            $tmp_list[$key]['endtime'] = $val['starttime'] * 3600 - ( time() - $val['addtime']);
            $tmp_list[$key]['title'] = $val['name'];
            $tmp_list[$key]['original_price'] = $val['original'];
            $tmp_list[$key]['price'] = $val['qprice']<$val['original']-$val['minimum']?$val['original']-$val['qprice']:$val['minimum'];
            $tmp_list[$key]['joinurl'] = '/wap/bargain.php?action=detail&id='.$val['pigcms_id'];
        };

        $json_return = array(
            'data' => $tmp_list,
            'page' => $page,
            'errcode' => 0,
        );

        if(!headers_sent()) header('Content-type:application/json');
        exit(json_encode($json_return, true));
        echo ob_get_clean();
    }else{
        include display("bargain_list");
        echo ob_get_clean();
    }

} else if ($action == 'detail') {
    $database_bargain_user = D('Bargain_kanuser');
    $database_order = D('Order');

    $friend = isset($_REQUEST['friend'])?$_REQUEST['friend']:'';
    $pigcms_id = isset($_REQUEST['id'])? trim($_REQUEST['id']):(isset($_REQUEST['amp;id'])?$_REQUEST['amp;id']:'0');
    $store_id =  isset($_REQUEST['store_id'])? trim($_REQUEST['store_id']):(isset($_REQUEST['amp;store_id'])?$_REQUEST['amp;store_id']:'0');
    if(!isset($store_id)){
        pigcms_tips('没有传入店铺id');
    }
    if(!isset($pigcms_id)){
        pigcms_tips('没有活动id',option('config.wap_site_url')."/home.php?id=".$store_id);
    }

    //判断是否分享(帮砍)的页面
    if(isset($_REQUEST['friend'])){
        $is_share_link = true;
    }else{
        $is_share_link = false;
    }

    //获取帮砍用户信息
    if($friend!=''){
        $wxuser = $database_bargain_user->where(array('token'=>$friend))->find();
    }

    //微信授权获取用户信息
    $now_store = M('Store')->wap_getStore($tmp_store_id);
    $wap_user = !empty($_SESSION['wap_user']) ? $_SESSION['wap_user'] : array();
    $avatar = $wap_user['avatar'] ? $wap_user['avatar']:getAttachmentUrl('images/touxiang.png', false);
    $nickname = isset($wap_user['nickname']) ? $wap_user['nickname'] : '匿名';
    $user_token = $wap_user['openid'] ? $wap_user['openid']:'token';
    if($nickname=='匿名'){
        pigcms_tips('请在微信客户端打开链接',option('config.wap_site_url')."/home.php?id=".$store_id);
    }

    //砍价商品信息
    $where = array();
    $where['pigcms_id'] = $pigcms_id;
    $bargain = D('Bargain')->where($where)->find();
    $num_rate = 100;

    if($bargain['state']==0){
        pigcms_tips('该活动已经关闭',option('config.wap_site_url')."/home.php?id=".$store_id);
    }
    if(empty($bargain) || $bargain['delete_flag']==1){
        pigcms_tips('不存在此活动',option('config.wap_site_url')."/home.php?id=".$store_id);
    }

    //如果用户打开自己分享的链接或者用户分享没有参加的活动,去掉分享属性
    $where = "token='".$friend."' and friend='' and bargain_id='".$pigcms_id."'";
    $friend_count = $database_bargain_user->where($where)->count('pigcms_id');
    if($is_share_link && ($user_token==$friend || $friend_count==0)){
        redirect('./bargain.php?action=detail&id='.$pigcms_id.'&store_id='.$store_id);
    };

    //是否关注商家公众号
    $act_type = 'bargain';
    $show_subscribe_div     = false;
    //关注帮砍还是关注砍价
    if ($friend && $is_share_link) {
        //是否开启关注
        if ($bargain['is_subhelp'] == 2) {
            $qrcode = M('Store')->concernRelationship(800000000, $wap_user['uid'], $store_id, 2, $act_type, $bargain['pigcms_id'] ,$friend);
            if ($qrcode['error_code'] == 0) {
                $is_subscribe = D('Subscribe_store')->where(array('uid'=>$wap_user['uid'],'store_id'=>$store_id,'is_leave'=>0))->find();
                $show_subscribe_div     = true;
            }
        }
    } else {
        //是否开启关注
        if ($bargain['is_attention'] == 2) {
            $qrcode = M('Store')->concernRelationship(800000000, $wap_user['uid'], $store_id, 2, $act_type, $bargain['pigcms_id']);
            if ($qrcode['error_code'] == 0) {
                $is_subscribe = D('Subscribe_store')->where(array('uid'=>$wap_user['uid'],'store_id'=>$store_id,'is_leave'=>0))->find();
                $show_subscribe_div     = true;
            }
        }
    }

    //获取砍价总人数
    $sql = "SELECT count(bargain.token) as total FROM (SELECT DISTINCT(token) FROM ".option('system.DB_PREFIX')."bargain_kanuser WHERE bargain_id=".$pigcms_id.") bargain";
    $result = D('')->query($sql);
    $all_kan_total_time  = empty($result)? 0:$result[0]['total'];

    //获取砍价库存信息
    unset($where);
    $where['product_id'] = $bargain['product_id'];
    $Product = M('Product')->get($where,'quantity,store_id,sales');
    if(empty($Product)){
        pigcms_tips('不存在此商品',option('config.wap_site_url')."/home.php?id=".$store_id);
    };
    if($Product['quantity']==0){
        pigcms_tips('该商品已经卖完',option('config.wap_site_url')."/home.php?id=".$store_id);
    };
    if($Product['soldout']==1){
        pigcms_tips('该商品已经下架',option('config.wap_site_url')."/home.php?id=".$store_id);
    };
    $bargain['inventory'] = $Product['quantity'];
    $storeId = $Product['store_id'];

    //获取每个团的砍价信息
    if($friend==''){
        $where = "(token='".$user_token."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$user_token."' and bargain_id='".$pigcms_id."')";
        $bargain['myqprice'] = $database_bargain_user->where($where)->sum('dao');
    }else{
        $where = "(token='".$_REQUEST['friend']."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$_REQUEST['friend']."' and bargain_id='".$pigcms_id."')";
        $bargain['myqprice'] = $database_bargain_user->where($where)->sum('dao');
    }

    //亲友团参加信息
    if($friend==''){
        $where = "(token='".$user_token."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$user_token."' and bargain_id='".$pigcms_id."')";
    }else{
        $where = "(token='".$_REQUEST['friend']."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$_REQUEST['friend']."' and bargain_id='".$pigcms_id."')";
    }
    $kan_total_time  = $database_bargain_user->where($where)->count('pigcms_id');
    $kan_total_money = $database_bargain_user->where($where)->sum('dao');

    //销量信息
    unset($where);
    $where = "activity_id='".$pigcms_id."' and type=50 and paid_time !=0";
    $order_count = D('Order')->where($where)->count('order_id');

    //参加砍价亲友团信息
    if($friend==''){
        $where = "(token='".$user_token."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$user_token."' and bargain_id='".$pigcms_id."')";
    }else{
        $where = "(token='".$_REQUEST['friend']."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$_REQUEST['friend']."' and bargain_id='".$pigcms_id."')";
    }
    $kanuser_list = $database_bargain_user->where($where)->select();

    //获得我的帮砍信息
    unset($where);
    $where['token'] = $user_token;
    $where['bargain_id'] = $pigcms_id;
    $where['friend'] = $friend;
    $my_kanuser_count = $database_bargain_user->where($where)->count('pigcms_id');

    //获取我的亲友团数量
    unset($where);
    $where = "(token='".$user_token."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$user_token."' and bargain_id='".$pigcms_id."')";
    $myhelp_kanuser_count = $database_bargain_user->where($where)->count('pigcms_id');

    //获取我的砍价信息
    unset($where);
    $where['token'] = $user_token;
    $where['bargain_id'] = $pigcms_id;
    $where['friend'] = '';
    $my_knauser_info = $database_bargain_user->where($where)->field('pigcms_id,addtime,orderid')->find();
    $my_kanuser_id = $my_knauser_info['pigcms_id'];

    //获取活动参与者信息
    unset($where);
    if($is_share_link){
        $where['token'] = $friend;
    }else{
        $where['token'] = $user_token;
    }
    $where['bargain_id'] = $pigcms_id;
    $where['friend'] = '';
    $join_kanuser_info = $database_bargain_user->where($where)->field('pigcms_id,addtime,orderid')->find();

    //砍价榜单
    unset($where);
    $where['bargain_id'] = $pigcms_id;
    $tmp_list_friend = $database_bargain_user->field('friend')->where($where)->group('friend')->select();
    unset($where);
    $where['bargain_id'] = $pigcms_id;
    $where['friend'] = '';
    $tmp_list_join = $database_bargain_user->field('token as friend')->where($where)->select();
    foreach($tmp_list_join as $k=>$v){
        if(!in_array($v,$tmp_list_friend)){
            array_push($tmp_list_friend,$v);
        }
    }
    $rank_list = array();
    foreach($tmp_list_friend as $key=>$value){
        if($value['friend']!=''){
            $where = "(token='".$value['friend']."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$value['friend']."' and bargain_id='".$pigcms_id."')";
            $qprice = $database_bargain_user->where($where)->sum('dao');
            if($qprice>0){
                $rank_list[$qprice]['now_price'] = $bargain['minimum'] >= $bargain['original'] - $qprice ? $bargain['minimum'] : $bargain['original'] - $qprice;
                $rank_list[$qprice]['qprice'] = $qprice;
                $where = "token='".$value['friend']."' and bargain_id='".$pigcms_id."'";
                $kaninfo = $database_bargain_user->where($where)->find();
                $rank_list[$qprice]['name'] = $kaninfo['name'];
                $rank_list[$qprice]['wecha_id'] = $kaninfo['wecha_id'];
            }
        }
    }
    sort($rank_list);$rank_list = array_slice($rank_list,0,$bargain['rank_num']);

    //获取参与者的订单信息
    unset($where);
    $where['order_no'] = $join_kanuser_info['orderid'];
    $my_order = $database_order->where($where)->field('status,paid_time')->find();

    //获取最近一次帮砍
    if(time()-$kanuser_list[count($kanuser_list)-1]['addtime']<10){
        $time_interval = false;
    }else{
        $time_interval = true;
    }

    //计算活动砍价状态
    $endtime = $bargain['starttime'] * 3600 - ( time() - $join_kanuser_info['addtime']);
    if(!empty($join_kanuser_info)){
        if(!empty($my_order)){
            if($my_order['paid_time']==0){
                $is_over = 3;
            }else{
                $is_over = 5;
            }
        }elseif($endtime>0){
            if($my_order['paid_time']!=0){
                $is_over = 5;
            }elseif($bargain['myqprice']>=$bargain['original']-$bargain['minimum']){
                $is_over = 2;
            }else{
                $day = (int)($endtime / 86400);
                $hour = (int)(($endtime - $day*86400) / 3600);
                $minute = (int)(($endtime - $day*86400 - $hour*3600) / 60);
                $second = (int)($endtime - $day*86400 - $hour*3600 - $minute*60);
                $is_over = 1;
            }
        }else{
            $is_over = 4;
        }
    }else{
        $is_over = 0;
    }

    include display('bargain_detail');
    echo ob_get_clean();
} elseif($action == 'new_firstblood'){
    $database_bargain_user = D('Bargain_kanuser');

    $pigcms_id = intval($_POST['id']);
    $token = $_POST['token'];
    $user_token = $wap_user['openid'] ? $wap_user['openid']:'token';
    $friend = isset($_REQUEST['friend']) ? $_REQUEST['friend'] : '匿名';

    $bargain = D("Bargain")->where(array('token'=>$token,'pigcms_id'=>$pigcms_id))->find();
    $num_rate = 100;

    $kanprice = rand($bargain['kan_min'],$bargain['kan_max']);

    //已经砍掉的价格
    if($friend==''){
        $where = "(token='".$user_token."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$user_token."' and bargain_id='".$pigcms_id."')";
        $total_kan = $database_bargain_user->where($where)->sum('dao');
    }else{
        $where = "(token='".$_REQUEST['friend']."' and friend='' and bargain_id='".$pigcms_id."') or (friend='".$_REQUEST['friend']."' and bargain_id='".$pigcms_id."')";
        $total_kan = $database_bargain_user->where($where)->sum('dao');
    };
    //砍到底价后不再添加记录
    $now_price = $total_kan<$bargain['original']-$bargain['minimum']?($bargain['original']-$total_kan)/$num_rate:$bargain['minimum']/$num_rate;
    if($now_price<=$bargain['minimum']/$num_rate){
        $data['err_code'] = 1;
        $data['id'] = $bargain['pigcms_id'];
        $data['store_id'] = $bargain['store_id'];
        $data['friend'] = $friend;
        if(!headers_sent()) header('Content-type:application/json');
        exit(json_encode($data, true));
    }
    //添加砍价纪录
    $kanuser = D("Bargain_kanuser")->where(array('token'=>$user_token,'bargain_id'=>$pigcms_id,'friend'=>$friend))->find();
    if(empty($kanuser)){
        $add_kanuser['bargain_id'] = $pigcms_id;
        $add_kanuser['token'] = $user_token;
        $add_kanuser['wecha_id'] = $wap_user['avatar'] ? $wap_user['avatar']:getAttachmentUrl('images/touxiang.png', false);
        $add_kanuser['orderid'] = '';
        $add_kanuser['name'] = isset($wap_user['nickname']) ? $wap_user['nickname'] : '匿名';
        $add_kanuser['friend'] = $friend;
        $add_kanuser['dao'] = $kanprice;
        $add_kanuser['addtime'] = time();

        $rs = D("Bargain_kanuser")->data($add_kanuser)->add();
        //修改砍价商品信息
        if($rs){
            $bargain_data['qdao'] = $bargain['qdao'] + 1;
            $bargain_data['qprice'] = $bargain['qprice'] + $kanprice;

            $pid = D("Bargain")->where(array('token'=>$token,'pigcms_id'=>$pigcms_id))->data($bargain_data)->save();

            if($pid){
                $data['err_code'] = 0;
                $data['dao'] = $kanprice/100;
                $data['id'] = $bargain['pigcms_id'];
                $data['store_id'] = $bargain['store_id'];
                $data['friend'] = $friend;
            }else{
                $data['err_code'] = 1;
                $data['id'] = $bargain['pigcms_id'];
                $data['store_id'] = $bargain['store_id'];
                $data['friend'] = $friend;
            }
        };
    }else{
        $data['err_code'] = 1;
        $data['id'] = $bargain['pigcms_id'];
        $data['store_id'] = $bargain['store_id'];
        $data['friend'] = $friend;
    };

    if(!headers_sent()) header('Content-type:application/json');
    exit(json_encode($data, true));

    echo ob_get_clean();
} elseif($action == 'save_orderid'){
    $orderid = $_POST['orderid'];

    if(!isset($orderid)){
        $json_return['error'] = 1;
        $json_return['msg'] = "没有传入订单号";
    }

    $pigcms_id = $_POST['pigcms_id'];
    if(!isset($pigcms_id)){
        $json_return['error'] = 1;
        $json_return['msg'] = "没有传入砍价活动id";
    }

    $data['orderid'] = str_replace(option('config.orderid_prefix'),'',$orderid);
    $rs = D("Bargain_kanuser")->where(array('pigcms_id'=>$pigcms_id))->data($data)->save();
    if($rs){
        $data_order['activity_id'] = isset($_POST['activityId'])?$_POST['activityId']:'';
        $data_order['activity_type'] = 50;

        $rs_order = D("Order")->where(array('order_no'=>$data['orderid']))->data($data_order)->save();
        if($rs_order){
            $json_return['error'] = 0;
            $json_return['msg'] = "保存订单id成功";
        }else{
            $json_return['error'] = 1;
            $json_return['msg'] = "保存订单信息失败";
        }
    }else{
        $json_return['error'] = 1;
        $json_return['msg'] = "保存订单id出错";
    };

    if(!headers_sent()) header('Content-type:application/json');
    exit(json_encode($json_return, true));
    echo ob_get_clean();
} elseif($action == 'good_detail'){
    //砍价商品信息
    $pigcms_id = intval($_REQUEST['id']);
    $where = array();
    $where['pigcms_id'] = $pigcms_id;
    $bargain = D('Bargain')->where($where)->field('pigcms_id,name,pigcms_id,store_id,wxtitle,wxinfo,product_id')->find();
    //获取商品信息
    $product = M('Product')->get(array('product_id'=>$bargain['product_id']),'info');

    include display('good_detail');
    echo ob_get_clean();
} else {

}

?>
