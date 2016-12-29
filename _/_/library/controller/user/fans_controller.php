<?php

/**
 * 客户
 * User: pigcms-s
 * Date: 2015/09/11
 * Time: 10:04
 */
class fans_controller extends base_controller {

    public $store_id;

    public function __construct() {
        parent::__construct();
        if (empty($this->store_session)) redirect(url('index:index'));
        $this->store_id = $this->store_session['store_id'];
        //该控制器只限： 认证服务号访问

    }

    //加载
    public function load() {
        $action = strtolower(trim($_REQUEST['page']));
        if (empty($action)) pigcms_tips('非法访问！', 'none');

        switch ($action) {

            case 'dashboard_content': 		//客户主页概况
                $this->_index_content();
                break;

            case 'tag_content':			 ////客户管理-标签管理-main
                $this->_tag_content();
                break;

            case 'tag_create':			//客户管理-标签管理-add
                $this->_tag_create();
                break;

            case 'tag_edit':				//客户管理-标签管理-edit
                $this->_tag_edit();
                break;

            case 'tag_download_by_csv':		//	客户管理-标签管理-download csv
                $this->_tag_download_by_csv();
                break;

            case 'points_content':			//客户管理-积分管理-main
                $this->_points_content();
                break;


            case 'points_create':			//客户管理-积分管理-add
                $this->_points_create();
                break;

            case 'points_edit':				//客户管理-积分管理-edit
                $this->_points_edit();
                break;

            case 'statistic_basic':				// 用户统计-概览
                $this->_statistic_basic();
                break;

            case 'statistic_fans':				// 用户统计-会员增减
                $this->_statistic_fans();
                break;

            case 'member_content':				//会员管理
                $this->_member_content();
                break;

            case 'points_apply_content':				//会员积分来源 - 消耗
                $this->_points_apply_content();
                break;


        }

        $this->display($_REQUEST['page']);
    }



    //客户主页
    public function dashboard() {
        $this->display();
    }


    //客户管理-标签管理
    public function tag() {
        $this->display();
    }


    //客户管理-标签管理-main
    public function _tag_content() {

        $page = $_REQUEST['p'] + 0;
        $page = max(1, $page);
        $type = $_REQUEST['type'];
        $keyword = $_REQUEST['keyword'];
        $limit = 20;

        $uid = $_SESSION['store']['uid'];
        $store_id = $_SESSION['store']['store_id'];

        $where = array();
        $where['uid'] = $uid;
        $where['store_id'] = $store_id;

        if (!empty($keyword)) {
            $where['name'] = array('like', '%' . $keyword . '%');
        }

        $time = time();
        $tag_model = M('User_degree');
        $count = $tag_model->getCount($where);

        if ($count > 0) {
            $page = min($page, ceil($count / $limit));
            $offset = ($page - 1) * $limit;
            $order_by = "";

            $tag_list = $tag_model->getList($where,$order_by,$limit,$offset);

            import('source.class.user_page');
            $user_page = new Page($count, $limit, $page);
            $pages = $user_page->show();
        }

        //当前会员等级是否开启了消耗积分
        $store_info = D('Store')->where(array('store_id'=>$store_id))->find();

        //echo "<pre>";
        //print_r($tag_list);

        $this->assign('type', $type);
        $this->assign('pages', $pages);
        $this->assign('keyword', $keyword);
        $this->assign('store_info', $store_info);
        $this->assign('tag_list', $tag_list);

    }

    //客户管理-标签管理-add
    public function _tag_create() {
        if (IS_POST && isset($_POST['is_submit'])) {


            $uid = $_SESSION['store']['uid'];
            $store_id = $_SESSION['store']['store_id'];
            $rule_name = $_POST['rule_name'];
            $rule_type = $_POST['rule_type'];
            $description = $_POST['description'];
            $level_num = $_POST['level_num'];
            $discount = $_POST['discount'] ? $_POST['discount']: '10.0';
            $is_postage_free = 0;

            $points_limit = $_POST['points_limit']?$_POST['points_limit']:0;
            $trade_limit = $_POST['trade_limit'] ? $_POST['trade_limit']:0;
            $amount_limit = $_POST['amount_limit']?$_POST['amount_limit']:0;
            $points_discount_toplimit = 0;
            $points_discount_ratio = 0;
            $is_discount = 0; 	//是否开启：打折
            $is_postage_free = 0;//是否开启：包邮
            $is_points_discount_toplimit = 0; //是否开启：积分抵现上限

            $degree_month = $_POST['degree_month']?$_POST['degree_month']:12;


            $level_pic = $_POST['level_pic']; //图片

            $power = $_POST['power'];

            if(!$uid || !$store_id) {
                json_return(1001, '登陆错误');
            }
            if(!in_array($rule_type,array('1','2','3','4','5'))) {
                json_return(1002, '会员标签类别不能为空！');
            }
            if(!preg_match('/^[\d]{1,}/',$level_num)) {
                json_return(1002, '等级值不能为空！');
            }
            switch($rule_type) {
                case '1': $rule_name = "普通会员";	break;
                case '2': $rule_name = "金牌会员";	break;
                case '3': $rule_name = "银牌会员";	break;
                case '4': $rule_name = "铜牌会员";	break;
                case '5':
                    if(!$rule_name) {
                        json_return(1003, '标签名不能为空！');
                    }
                    break;
            }

            //等级图标
            if(!$level_pic) {
                json_return(1004, '等级图标未选择！');
            }


            if(!preg_match('/^[0-9]{1,6}$/',$points_limit)) {
                json_return(1006, '填写积分错误！');
            }

            if($trade_limit) {
                if(!preg_match('/^[0-9]{1,4}$/',$trade_limit)) {
                    json_return(1006, '累计成功交易笔数必须大于等于0');
                }
            }
            if($amount_limit) {
                if(!preg_match('/^[0-9]{1,4}$/',$amount_limit)) {
                    json_return(1006, '累计购买金额必须大于等于0');
                }
            }

            if(!$description) {
                json_return(1007, '使用须知不能为空');
            } else {
                $description = msubstr($description,0,"200");
            }

            if($discount){
                if(in_array($discount,array('10','10.0','0','0.0'))) {
                    $discount = "10";
                } elseif(!preg_match('/^[0-9]{1}[\.]?[0-9]{0,1}$/',$discount)) {
                    json_return(1008, '折扣填写不正确！');
                }
            }
            if(!preg_match('/^[0-9]{1,6}$/',$_POST['points_discount_toplimit'])) {
                json_return(1009, '填写积分抵现上限错误！');
            } else {
                $points_discount_toplimit = $_POST['points_discount_toplimit'];
            }

            if(!preg_match('/^[0-9]{1,2}$/',$_POST['points_discount_ratio'])) {
                json_return(1010, '填写积分在订单金额抵现比例错误！');
            } else {
                $points_discount_ratio = $_POST['points_discount_ratio'];
            }


            if(!preg_match('/^[0-9]{1,2}$/',$_POST['degree_month']) || $_POST['degree_month']<=0) {
                json_return(1010, '填写等级有效期错误！');
            } else {
                $degree_month = $_POST['degree_month'];
            }

            //分为两种图片 1,2,3,4: 本地资源图， 5： 客户上传图
            $level_pic = getAttachment($level_pic);
			//解决等级默认图标保存路径错误问题
			$level_pic = preg_replace('/^http(.*?)\/static/i', './static', $level_pic);

            $discount = $discount?$discount:'10';

            if(is_array($power)) {
                if(in_array('is_discount',$power)) {
                    $is_discount = 1;
                }

                if(in_array('is_postage_free',$power)) {
                    $is_postage_free = 1;
                }

                if(in_array('is_points_discount_toplimit',$power)) {
                    $is_points_discount_toplimit = 1;
                }

                if(in_array('is_points_discount_ratio',$power)) {
                    $is_discount_radio = 1;
                }
            }

            $data = array(
                'uid' => $uid,
                'store_id' => $store_id,
                'name' => $rule_name,
                'points_limit' => $points_limit,
                'trade_limit' => $trade_limit,
                'amount_limit' => $amount_limit,
                'level_pic' => $level_pic,
                'discount' => $discount,
                'rule_type' => $rule_type,
                'level_num' => $level_num,
                'description' => $description,
                'degree_month' => $degree_month,
                'is_postage_free' => $is_postage_free,
                'is_discount' => $is_discount,
                'is_points_discount_toplimit' => $is_points_discount_toplimit,
                'is_points_discount_ratio' => $is_discount_radio,
                'points_discount_toplimit' => $points_discount_toplimit,
                'points_discount_ratio' => $points_discount_ratio,
                'timestamp' => time()
            );

            if($pid = D('User_degree')->data($data)->add()) {
                json_return(0, '添加成功');

            } else {
                json_return(1004, '添加失败，请重新试试');
            }

        }

    }


    //标签管理页面渲染 修改页面-及操作
    public function _tag_edit() {

        $id = (Int)$_POST['id'];

        if (empty($id)) {
            json_return(1001, '缺少最基本的参数ID');
        }
        //判断以下修改的是否是自己的
        $wtag = D('User_degree')->where(array('id' => $id))->find();
        if(($_SESSION['store']['uid'] != $wtag['uid']) || $_SESSION['store']['store_id']!= $wtag['store_id']) {
            json_return(1001, '当前会员标签不是该店铺的！');
        }

        if (IS_POST && isset($_POST['is_submit'])) {
            $uid = $_SESSION['store']['uid'];
            $store_id = $_SESSION['store']['store_id'];
            $rule_name = $_POST['rule_name'];
            $rule_type = $_POST['rule_type'];
            $description = $_POST['description'];
            $level_num = $_POST['level_num'];
            $discount = $_POST['discount'];
            $is_postage_free = $_POST['is_postage_free'];

            $points_limit = $_POST['points_limit']?$_POST['points_limit']:0;
            $trade_limit = $_POST['trade_limit'] ? $_POST['trade_limit']:0;
            $amount_limit = $_POST['amount_limit']?$_POST['amount_limit']:0;
            $level_pic = $_POST['level_pic']; //图片

            $points_discount_toplimit = 0;
            $points_discount_ratio = 0;

            $is_discount = 0; 	//是否开启：打折
            $is_postage_free = 0;//是否开启：包邮
            $is_points_discount_toplimit = 0; //是否开启：积分抵现上限
            $is_points_discount_ratio = 0; //是否开启：积分在订单金额抵现比例
            $degree_month = $_POST['degree_month']?$_POST['degree_month']:12;
            $power = $_POST['power'] ? $_POST['power'] : array();


            if(!$uid || !$store_id) {
                json_return(1001, '登陆错误');
            }
            if(!in_array($rule_type,array('1','2','3','4','5'))) {
                json_return(1002, '会员标签类别不能为空！');
            }
            if(!preg_match('/^[\d]{1,}/',$level_num)) {
                json_return(1002, '等级值不能为空！');
            }
            switch($rule_type) {
                case '1': $rule_name = "普通会员";	break;
                case '2': $rule_name = "金牌会员";	break;
                case '3': $rule_name = "银牌会员";	break;
                case '4': $rule_name = "铜牌会员";	break;
                case '5':
                    if(!$rule_name) {
                        json_return(1003, '标签名不能为空！');
                    }
                    break;
            }

            //等级图标
            if(!$level_pic) {
                json_return(1004, '等级图标未选择！');
            }

            if($discount){
                if(in_array($discount,array('10','10.0','0','0.0'))) {
                    $discount = "10";
                } elseif(!preg_match('/^[0-9]{1}[\.]?[0-9]{0,1}$/',$discount)) {
                    json_return(1005, '折扣填写不正确！');
                }
            }
            if(!preg_match('/^[0-9]{1,6}$/',$points_limit)) {
                json_return(1006, '填写积分错误！');
            }

            if($trade_limit) {
                if(!preg_match('/^[0-9]{1,4}$/',$trade_limit)) {
                    json_return(1006, '累计成功交易笔数必须大于等于0');
                }
            }
            if($amount_limit) {
                if(!preg_match('/^[0-9]{1,4}$/',$amount_limit)) {
                    json_return(1006, '累计购买金额必须大于等于0');
                }
            }

            if(!$description) {
                json_return(1007, '使用须知不能为空');
            } else {
                $description = msubstr($description,0,"200");
            }

            if($discount){
                if(in_array($discount,array('10','10.0','0','0.0'))) {
                    $discount = "10";
                } elseif(!preg_match('/^[0-9]{1}[\.]?[0-9]{0,1}$/',$discount)) {
                    json_return(1008, '折扣填写不正确！');
                }
            }
            if(!preg_match('/^[0-9]{1,2}[\.]?[0-9]{0,1}$/',$_POST['points_discount_toplimit'])) {
                json_return(1009, '填写积分抵现上限错误！');
            } else {
                $points_discount_toplimit = $_POST['points_discount_toplimit'];
            }

            if(!preg_match('/^[0-9]{1,2}[\.]?[0-9]{0,1}$/',$_POST['points_discount_ratio'])) {
                json_return(1010, '填写积分在订单金额抵现比例错误！');
            } else {
                $points_discount_ratio = $_POST['points_discount_ratio'];
            }


            if(!preg_match('/^[0-9]{1,2}$/',$_POST['degree_month']) || $_POST['degree_month']<=0) {
                json_return(1011, '填写等级有效期错误！');
            } else {
                $degree_month = $_POST['degree_month'];
            }


            //分为两种图片 1,2,3,4: 本地资源图， 5： 客户上传图
            $level_pic = getAttachment($level_pic);
			//解决等级默认图标保存路径错误问题
			$level_pic = preg_replace('/^http(.*?)\/static/i', './static', $level_pic);

            if(in_array('is_discount',$power)) {
                $is_discount = 1;
            }

            if(in_array('is_postage_free',$power)) {
                $is_postage_free = 1;
            }

            if(in_array('is_points_discount_toplimit',$power)) {
                $is_points_discount_toplimit = 1;
            }

            if(in_array('is_points_discount_ratio',$power)) {
                $is_discount_radio = 1;
            }
            $discount = $discount ? $discount : '10';
            $data = array(
                'uid' => $uid,
                'store_id' => $store_id,
                'name' => $rule_name,
                'points_limit' => $points_limit,
                'trade_limit' => $trade_limit,
                'amount_limit' => $amount_limit,
                'level_pic' => $level_pic,
                'discount' => $discount,
                'rule_type' => $rule_type,
                'level_num' => $level_num,
                'description' => $description,
                'degree_month' => $degree_month,
                'is_postage_free' => $is_postage_free,
                'is_discount' => $is_discount,
                'is_points_discount_toplimit' => $is_points_discount_toplimit,
                'is_points_discount_ratio' => $is_discount_radio,
                'points_discount_toplimit' => $points_discount_toplimit,
                'points_discount_ratio' => $points_discount_ratio,
                'timestamp' => time()
            );

            D('User_degree')->data($data)->where(array('id' => $id))->save();

            json_return(0, '修改成功');
        }


        $tag_model = M('User_degree');
        $where = array();
        $where['uid'] = $_SESSION['store']['uid'];
        $where['store_id'] = $_SESSION['store']['store_id'];
        $where['id'] = $id;
        $tag = $tag_model->getTag($where);

        $this->assign('tag', $tag);


    }


    //是否开启-会员等级提升是否消耗积分
    public function degree_exchange_type()
    {
        if (IS_POST) {
            $status =  intval(trim($_POST['status']));
            if(!in_array($status,array(1,2))) {
                return false;
            }
            $result = D('Store')->where(array ('store_id' => $this->store_session['store_id']))->data(array ('degree_exchange_type' => $status))->save();
            if ($result) {
                $_SESSION['store']['open_drp_degree'] = $status;
                if($status == 2){
                    D('Store_user_data')->where(array('store_id'=>$_SESSION['store']['store_id']))->data(array('degree_update_date'=>date('Ymd',strtotime('-1 day'))))->save();
                }
                echo true;
            } else {
                echo false;
            }
        }
    }


    //更改用户积分
    public function change_user_point() {
        $store_id = $_SESSION['store']['store_id'];
        $point = $_REQUEST['change_jf'];
        if(!$point) $point = 0;
        $uid = $_REQUEST['uid'];
        $description = $_REQUEST['desc'];
        if(!$description || !$store_id || !$point) {
            json_return(1001, '更新失败');
        }
        import('source.class.Points');
        Points::change($uid,$store_id,$point,$description);

        json_return(0, '更新成功');
    }



    //标签管理-下载download
    function tag_download_csv() {

        import('source.class.execl');
        $execl = new execl();

        $execl->addHeader(array ('标签名','微信会员','手机会员'));
        $execl->addBody(
            $array = array(
                array('title'=>'嗯标题1','content'=>'内容1','description'=>'好的1'),
                array('title'=>'嗯标题2','content'=>'内容2','description'=>'好的2'),
                array('title'=>'嗯标题2','content'=>'内容3','description'=>'好的3')
            )
        );
        $execl->download("标签管理.xls");
    }






    //客户管理-积分管理
    public function points() {

        $this->display();
    }


    //客户管理-积分管理-main
    public function _points_content() {

        $page = $_REQUEST['p'] + 0;
        $page = max(1, $page);
        $type = $_REQUEST['type'];
        $keyword = $_REQUEST['keyword'];
        $limit = 20;

        $uid = $_SESSION['store']['uid'];
        $store_id = $_SESSION['store']['store_id'];

        $where = array();
        $where['uid'] = $uid;
        $where['store_id'] = $store_id;

        if (!empty($keyword)) {
            $where['points'] = array('like', '%' . $keyword . '%');
        }

        $time = time();


        $points_model = M('Points');
        $count = $points_model->getCount($where);

        if ($count > 0) {
            $page = min($page, ceil($count / $limit));
            $offset = ($page - 1) * $limit;
            $order_by = "";

            $points_list = $points_model->getList($where,$order_by,$limit,$offset);

            import('source.class.user_page');
            $user_page = new Page($count, $limit, $page);
            $pages = $user_page->show();
        }



        $this->assign('type', $type);
        $this->assign('pages', $pages);
        $this->assign('keyword', $keyword);
        $this->assign('points_list', $points_list);

    }

    //积分页面创建-及添加
    public function _points_create() {

        $uid = $_SESSION['store']['uid'];
        $store_id = $_SESSION['store']['store_id'];
        $points_model = M('Points');

        if (IS_POST && isset($_POST['is_submit'])) {

            $points = $_POST['points'] ? trim($_POST['points']) : '';
            $type = $_POST['type'];
            $is_call_to_fans = $_POST['is_call_to_fans'];
            $money_or_trade = $_POST['money_or_trade'];
            $starttime = $_POST['starttime'] ? $_POST['starttime']:'8';
            $endtime = $_POST['endtime']? $_POST['endtime']:"22";

            if(!in_array($type,array('1','2','3'))) {
                json_return(1001, '选择奖励条件错误！');
            }

            if(empty($points) || !preg_match('/^[1-9]{1}[0-9]{0,3}$/',$points)) {
                json_return(1002, '填写积分错误！');
            }
            if(!$uid || !$store_id) {
                json_return(1003, '登陆错误');
            }

            $data = array(
                'uid' => $uid,
                'store_id' => $store_id,
                'points' => $points,
                'type' => $type,
                'trade_or_amount' => $money_or_trade,
                'is_call_to_fans' => $is_call_to_fans,
                'starttime' => $starttime,
                'endtime' => $endtime

            );

            if($pid = D('Points')->data($data)->add()) {
                json_return(0, '添加成功');
            } else {
                json_return(1001, '添加失败，请重新试试');
            }
        }



    }

    //积分页面渲染 修改页面-及操作
    public function _points_edit() {
        $id = (Int)$_POST['id'];
        $uid = $_SESSION['store']['uid'];
        $store_id = $_SESSION['store']['store_id'];
        $points_model = M('Points');

        if (empty($id)) {
            json_return(1001, '缺少最基本的参数ID');
        }

        if (IS_POST && isset($_POST['is_submit'])) {

            $points = $_POST['points'] ? trim($_POST['points']) : '';
            $type = $_POST['type'];
            $is_call_to_fans = $_POST['is_call_to_fans'];
            $money_or_trade = $_POST['money_or_trade'];
            $starttime = $_POST['starttime'] ? $_POST['starttime']:'8';
            $endtime = $_POST['endtime']? $_POST['endtime']:"22";

            if(!in_array($type,array('1','2','3'))) {
                json_return(1001, '选择奖励条件错误！');
            }
            if(empty($points) || !preg_match('/^[1-9]{1}[0-9]{0,3}$/',$points)) {
                json_return(1002, '填写积分错误！');
            }
            if(!$uid || !$store_id) {
                json_return(1003, '登陆错误');
            }
            //判定操作的是否是自己的积分信息
            $tags = $points_model->getPoints(array('id'=>$id));
            if($tags['uid'] != $uid) {
                json_return(1004, '您操作的不是自己的标签信息！');
            }
            $data = array(
                'uid' => $uid,
                'store_id' => $store_id,
                'points' => $points,
                'type' => $type,
                'trade_or_amount' => $money_or_trade,
                'is_call_to_fans' => $is_call_to_fans,
                'starttime' => $starttime,
                'endtime' => $endtime

            );

            D('Points')->data($data)->where(array('id' => $id))->save();


            json_return(0, '修改成功');
        }


        $where = array();
        $where['uid'] = $uid;
        $where['store_id'] = $store_id;
        $where['id'] = $id;
        $points = $points_model->getPoints($where);
        $this->assign('points', $points);



        //查看哪些已被添加
        $had_point_type = array();
        $where = array();
        $where['uid'] = $uid;
        $where['store_id'] = $store_id;
        $points_list = $points_model->getList($where,$order_by);
        foreach($points_list as $k=>$v) {
            $had_point_type[] = $v['type'];
        }
        $this->assign('had_point_type', $had_point_type);




    }



    // 删除
    public function delete() {
        $id = (Int)$_GET['id'];
        $type= $_GET['type'];
        if (empty($id)) {
            json_return(1001, '缺少最基本的参数ID');
        }
        if (empty($type)) {
            json_return(1002, '缺少类别');
        }
        $where = array();
        $where['uid'] = $_SESSION['store']['uid'];
        $where['store_id'] = $_SESSION['store']['store_id'];

        switch($type) {

            case 'tag':
                $tag_model = M('User_degree');

                $where['id'] = $id;

                $tag = $tag_model->getTag($where);
                if (empty($tag)) {
                    json_return(1003, '未找到相应的等级信息！');
                }
                if($_SESSION['store']['uid'] != $tag['uid']) {
                    json_return(1004, '您操作的不是自己的等级标签信息！！');
                }

                //不能删除已被客户使用的等级
                if(D('Store_user_data')->where(array('degree_id'=>$id))->find()) {
                    json_return(1005, '不能删除已被客户使用的等级哦！！');
                }


                $tag_model->delete(array('id' => $tag['id']));

                break;

            case 'points':
                $points_model = M('Points');

                $where['id'] = $id;

                $points = $points_model->getPoints($where);
                if (empty($points)) {
                    json_return(1003, '未找到相应的积分规则！');
                }
                if($_SESSION['store']['uid'] != $points['uid']) {
                    json_return(1004, '您操作的不是自己的积分信息！！');
                }

                $points_model->delete(array('id' => $points['id']));

                break;
        }

        json_return(0, '操作完成');
    }


    //关闭 积分、等级
    public function disabled() {

        $id = (Int)$_GET['id'];
        $type= $_GET['type'];
        if (empty($id)) {
            json_return(1001, '缺少最基本的参数ID');
        }
        if (empty($type)) {
            json_return(1002, '缺少类别');
        }

        $where = array();
        $where['uid'] = $_SESSION['store']['uid'];
        $where['store_id'] = $_SESSION['store']['store_id'];

        switch($type) {

            case 'tag':

                break;

            case 'points':
                $points_model = M('Points');

                $where['id'] = $id;
                $points = $points_model->getPoints($where);
                if (empty($points)) {
                    json_return(1003, '未找到相应的积分规则！');
                }
                if($_SESSION['store']['uid'] != $points['uid']) {
                    json_return(1004, '您操作的不是自己的积分信息！！');
                }
                $data = "status=0";
                $points_model->edit(array('id' => $points['id']),$data);

                break;

        }

        json_return(0, '操作完成');

    }


    //开启 积分、等级
    public function able() {

        $id = (Int)$_GET['id'];
        $type= $_GET['type'];
        if (empty($id)) {
            json_return(1001, '缺少最基本的参数ID');
        }
        if (empty($type)) {
            json_return(1002, '缺少类别');
        }

        $where = array();
        $where['uid'] = $_SESSION['store']['uid'];
        $where['store_id'] = $_SESSION['store']['store_id'];

        switch($type) {

            case 'tag':

                break;

            case 'points':
                $points_model = M('Points');

                $where['id'] = $id;
                $points = $points_model->getPoints($where);
                if (empty($points)) {
                    json_return(1003, '未找到相应的积分规则！');
                }
                if($_SESSION['store']['uid'] != $points['uid']) {
                    json_return(1004, '您操作的不是自己的积分信息！！');
                }
                $data = "status=1";
                $points_model->edit(array('id' => $points['id']),$data);

                break;

        }

        json_return(0, '操作完成');

    }

    // 店铺积分
    public function store_points() {
        $pointsConfig = D('Store_points_config')->where(array('store_id'=>$this->store_id))->find();
        if (empty($pointsConfig)) {
            D('Store_points_config')->data(array('store_id'=>$this->store_id))->add();
            $pointsConfig = D('Store_points_config')->where(array('store_id'=>$this->store_id))->find();
        }
        $this->assign('data', $pointsConfig);
        $this->display();
    }

    // 店铺积分-推广
    public function points_config_update () {
        if (IS_POST) {

            // 推广积分
            $pointConfig['drp1_subscribe_point'] = isset($_POST['drp1_subscribe_point']) ? intval($_POST['drp1_subscribe_point']) : 0;
            $pointConfig['drp2_subscribe_point'] = isset($_POST['drp2_subscribe_point']) ? intval($_POST['drp2_subscribe_point']) : 0;
            $pointConfig['drp3_subscribe_point'] = isset($_POST['drp3_subscribe_point']) ? intval($_POST['drp3_subscribe_point']) : 0;
            $pointConfig['share_click_num'] = isset($_POST['share_click_num']) ? intval($_POST['share_click_num']) : 0;
            $pointConfig['share_click_point'] = isset($_POST['share_click_point']) ? intval($_POST['share_click_point']) : 0;
            $pointConfig['drp1_spoint'] = isset($_POST['drp1_spoint']) ? intval($_POST['drp1_spoint']) : 0;
            $pointConfig['drp2_spoint'] = isset($_POST['drp2_spoint']) ? intval($_POST['drp2_spoint']) : 0;
            $pointConfig['drp3_spoint'] = isset($_POST['drp3_spoint']) ? intval($_POST['drp3_spoint']) : 0;

            // 交易积分
            $pointConfig['consume_money'] = isset($_POST['consume_money']) ? intval($_POST['consume_money']) : 0;
            $pointConfig['consume_point'] = isset($_POST['consume_point']) ? intval($_POST['consume_point']) : 0;
            $pointConfig['proport_money'] = isset($_POST['proport_money']) ? intval($_POST['proport_money']) : 0;
            $pointConfig['drp1_spoint_money'] = isset($_POST['drp1_spoint_money']) ? intval($_POST['drp1_spoint_money']) : 0;
            $pointConfig['drp2_spoint_money'] = isset($_POST['drp2_spoint_money']) ? intval($_POST['drp2_spoint_money']) : 0;
            $pointConfig['drp3_spoint_money'] = isset($_POST['drp3_spoint_money']) ? intval($_POST['drp3_spoint_money']) : 0;
            $pointConfig['order_consume'] = isset($_POST['order_consume']) ? intval($_POST['order_consume']) : 0;

            // 价值管理
            $pointConfig['price'] = isset($_POST['price']) ? (float)$_POST['price'] : 0;
            $pointConfig['offset_cash'] = isset($_POST['offset_cash']) ? (float)$_POST['offset_cash'] : 0;
            $pointConfig['offset_limit'] = isset($_POST['offset_limit']) ? intval($_POST['offset_limit']) : 0;
            $pointConfig['is_percent'] = isset($_POST['is_percent']) ? intval($_POST['is_percent']) : 0;
            // $pointConfig['is_offset'] = isset($_POST['is_offset']) ? intval($_POST['is_offset']) : 0;
            $pointConfig['is_limit'] = isset($_POST['is_limit']) ? intval($_POST['is_limit']) : 0;

            // 每日签到
            $pointConfig['sign_fixed_point'] = isset($_POST['sign_fixed_point']) ? intval($_POST['sign_fixed_point']) : 0;
            $pointConfig['sign_plus_start'] = isset($_POST['sign_plus_start']) ? intval($_POST['sign_plus_start']) : 0;
            $pointConfig['sign_plus_addition'] = isset($_POST['sign_plus_addition']) ? intval($_POST['sign_plus_addition']) : 0;
            $pointConfig['sign_plus_day'] = isset($_POST['sign_plus_day']) ? intval($_POST['sign_plus_day']) : 0;
            $pointConfig['sign_type'] = isset($_POST['sign_type']) ? intval($_POST['sign_type']) : 0;

            $type = isset($_POST['type']) ? $_POST['type'] : 'spread';
            switch ($type) {
                case 'spread':
                    $data = array(
                        'drp1_subscribe_point' => $pointConfig['drp1_subscribe_point'],
                        'drp2_subscribe_point' => $pointConfig['drp2_subscribe_point'],
                        'drp3_subscribe_point' => $pointConfig['drp3_subscribe_point'],
                        'share_click_num' => $pointConfig['share_click_num'],
                        'share_click_point' => $pointConfig['share_click_point'],
                        'drp1_spoint' => $pointConfig['drp1_spoint'],
                        'drp2_spoint' => $pointConfig['drp2_spoint'],
                        'drp3_spoint' => $pointConfig['drp3_spoint'],
                    );
                    break;
                case 'trade':
                    $data = array(
                        'consume_money' => $pointConfig['consume_money'],
                        'consume_point' => $pointConfig['consume_point'],
                        'proport_money' => $pointConfig['proport_money'],
                        'drp1_spoint_money' => $pointConfig['drp1_spoint_money'],
                        'drp2_spoint_money' => $pointConfig['drp2_spoint_money'],
                        'drp3_spoint_money' => $pointConfig['drp3_spoint_money'],
                        'order_consume' => $pointConfig['order_consume'],
                    );
                    break;
                case 'worth':

                    if ($pointConfig['offset_cash'] > 100 || $pointConfig['offset_cash'] <= 0) {
                        json_return(1, '金额比例必须大于0小于等于100');
                    }

                    $data = array(
                        'price' => $pointConfig['price'],
                        'offset_cash' => $pointConfig['offset_cash'],
                        'offset_limit' => $pointConfig['offset_limit'],
                        'is_percent' => $pointConfig['is_percent'],
                        'is_limit' => $pointConfig['is_limit'],
                    );
                    break;
                case 'checkin':
                    $data = array(
                        'sign_fixed_point' => $pointConfig['sign_fixed_point'],
                        'sign_plus_start' => $pointConfig['sign_plus_start'],
                        'sign_plus_addition' => $pointConfig['sign_plus_addition'],
                        'sign_plus_day' => $pointConfig['sign_plus_day'],
                        'sign_type' => $pointConfig['sign_type'],
                    );
                    break;
                default:
                    break;
            }

            $result = D('Store_points_config')->where(array('store_id'=>$this->store_id))->data($data)->save();
            if ($result) {
                json_return(0, '修改成功');
            } else {
                json_return(1, '请先修改再保存');
            }

        } else {
            pigcms_tips('非法访问！', 'none');
        }

    }

    // 积分配置-多级推广开启
    public function is_subscribe () {
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        if ($result = D('Store_points_config')->where(array('store_id' => $this->store_id))->data(array('is_subscribe' => $status))->save()) {
            json_return(0, '保存成功！');
        }
        json_return(4099, '保存失败，请重试！');
    }

    // 积分配置-分享得积分开启
    public function is_share () {

        // 注释原因：不开启->能得用户积分
        // // 依赖分享成为分销商
        // $store_info = D('Store')->where(array('store_id' => $this->store_id))->find();

        // if ($store_info['is_fanshare_drp'] == 0) {
        // 	json_return(3, '请先开启【粉丝分享自动成为分销商】');
        // }

        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        if ($result = D('Store_points_config')->where(array('store_id' => $this->store_id))->data(array('is_share' => $status))->save()) {
            json_return(0, '保存成功！');
        }
        json_return(4099, '保存失败，请重试！');
    }


    // 积分配置-积分兑换开启
    public function is_offset () {
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        if ($result = D('Store_points_config')->where(array('store_id' => $this->store_id))->data(array('is_offset' => $status))->save()) {
            json_return(0, '保存成功！');
        }
        json_return(4099, '保存失败，请重试！');
    }

    // 积分配置-积分兑换开启
    public function is_sign () {
        $status = isset($_POST['status']) ? intval($_POST['status']) : 0;
        if ($result = D('Store_points_config')->where(array('store_id' => $this->store_id))->data(array('sign_set' => $status))->save()) {
            json_return(0, '保存成功！');
        }
        json_return(4099, '保存失败，请重试！');
    }

    // 用户统计
    public function statistic() {
        $this->display();
    }

    // 用户统计 - 基本概览
    public function _statistic_basic() {

        // 粉丝数量
        $data['num_fans'] = D('Subscribe_store')->where(array('store_id' => $this->store_id, 'is_leave' => 0, 'user_subscribe_time' => array('>', 0)))->count('sub_id');

        //会员总数
        $data['num_members'] = D('Store_user_data')->where(array('store_id' => $this->store_id))->count('pigcms_id');

        // 昨日新增
        $day = date("Y-m-d", strtotime('-1 day'));
        $starttime = strtotime($day . ' 00:00:00');
        $endtime = strtotime($day . ' 23:59:59');
        $data['num_yesterday'] = D('Subscribe_store')->where(array('store_id' => $this->store_id, 'is_leave' => 0, '_string' => "subscribe_time > " . $starttime . " AND subscribe_time <= " . $endtime))->count('sub_id');

        // 领过优惠 user_coupon 中至少一条记录的user_id数量
        $coupon_count = D('')->query("select count(distinct uid) as num from ".option('system.DB_PREFIX')."user_coupon where `store_id` = $this->store_id");
        $data['num_coupon'] = isset($coupon_count[0]['num']) ? intval($coupon_count[0]['num']) : 0;

        // 性别比例
        $data['sex_male'] = D('User AS u')->join('Subscribe_store AS ss ON u.uid = ss.uid')->where("ss.store_id = '".$this->store_id."' AND u.sex = 1")->count('u.uid');
        $data['sex_female'] = D('User AS u')->join('Subscribe_store AS ss ON u.uid = ss.uid')->where("ss.store_id = '".$this->store_id."' AND u.sex = 2")->count('u.uid');
        $data['sex_unknown'] = D('User AS u')->join('Subscribe_store AS ss ON u.uid = ss.uid')->where("ss.store_id = '".$this->store_id."' AND u.sex = 0")->count('u.uid');
        $data['sex_unit'] = "['男', '女', '未知']";
        $data['sex_chart_str'] = "[{value:".$data['sex_male'].", name:'男'}, {value:".$data['sex_female'].", name:'女'}, {value:".$data['sex_unknown'].", name:'未知'}]";

        // 分销用户比例
        $store_user_total = D('Store_user_data')->where(array('store_id'=>$this->store_id))->count("pigcms_id");
        $data['drp_seller_user'] = D('Store')->where(array("root_supplier_id"=>$this->store_id))->count("store_id");
        $drp_seller_user = $store_user_total - intval($data['drp_seller_user']);
        $data['drp_normal_user'] = ($drp_seller_user > 0) ? $drp_seller_user : 0;

        $data['drp_unit'] = "['分销用户', '普通用户']";
        $data['drp_chart_str'] = "[{value:".intval($data['drp_seller_user']).", name:'分销用户'}, {value:".intval($data['drp_normal_user']).", name:'普通用户'}]";

        // 等级比例
        $degree_name_arr = array();
        $degree_num_arr = array();

        $degree_list = D("User_degree")->where(array("store_id"=>$this->store_id))->select();
        foreach ($degree_list as $key => $val) {
            $num = D('Store_user_data')->where(array('degree_id'=>$val['id'], 'store_id'=>$this->store_id))->count("pigcms_id");
            $degree_name_arr[] = "'".$val['name']."'";
            $degree_num_arr[] = "{name: '".$val['name']."',value: ".intval($num)."}";
        }

        $degree_name_arr = array_merge(array('\'无等级用户\''), $degree_name_arr);
        $degree_num_arr = array_merge(array("{name: '无等级用户',value: 0}"), $degree_num_arr);

        $data['degree_unit'] = !empty($degree_name_arr) ? '['.implode(',', $degree_name_arr).']' : "[]";
        $data['degree_str'] = !empty($degree_num_arr) ? '['.implode(',', $degree_num_arr).']' : "[]";

        // 地域数量排名
        $area_list = D('')->query("SELECT u.province, COUNT(u.province) AS num FROM ".option('system.DB_PREFIX')."user AS u LEFT JOIN ".option('system.DB_PREFIX')."subscribe_store AS ss ON u.uid = ss.uid WHERE ss.store_id = ".$this->store_id." AND ss.user_subscribe_time > 0 GROUP BY u.province ORDER BY num DESC");

        $map_str = array();
        $province_filter = M('User_address')->get_province();

        // 地域分布
        foreach ($area_list as $k => $val) {
            if (empty($val['province']) || !in_array($val['province'], $province_filter)) {
                unset($area_list[$k]);
                continue;
            }
            $map_str[] = "{name: '".$val['province']."',value: ".$val['num']."}";
        }

        $area_list = array_values($area_list);

        $data['map_str'] = !empty($map_str) ? '['.implode(',', $map_str).']' : "[]";
        $data['area_list'] = $area_list;
        $data['map_min'] = 0;
        $data['map_max'] = isset($area_list[0]['num']) ? $area_list[0]['num'] : 0;
        $this->assign('data', $data);
    }

    // 用户统计 - 会员增减
    public function _statistic_fans() {


        $data['start_time'] = isset($_POST['start_time']) ? trim($_POST['start_time']) : '';
        $data['stop_time'] = isset($_POST['stop_time']) ? trim($_POST['stop_time']) : '';
        $store_id = $this->store_id;

        // 会员总数 (包括非微信关注会员)
        // $data['num_fans'] = D('Subscribe_store')->where(array('store_id'=>$this->store_id))->count('sub_id');
        $data['num_fans'] = D('Store_user_data')->where(array('store_id' => $this->store_id))->count('pigcms_id');

        // 图表-时间串
        $days = array();
        if (empty($data['start_time']) && empty($data['stop_time'])) {

            $start_unix_time = strtotime(date("Y-m-d", strtotime('-7 day')));
            $stop_unix_time = strtotime(date("Y-m-d"));

            for ($i = 7; $i >= 1; $i--) {
                $day = date("Y-m-d", strtotime('-' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['start_time']) && !empty($data['stop_time'])) {

            $start_unix_time = strtotime($data['start_time']);
            $stop_unix_time = strtotime($data['stop_time']);

            $tmp_days = round(($stop_unix_time - $start_unix_time) / 3600 / 24);
            $days = array($data['start_time']);
            if ($data['stop_time'] > $data['start_time']) {
                for ($i = 1; $i < $tmp_days; $i++) {
                    $days[] = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
                }
                $days[] = $data['stop_time'];
            }
        } else if (!empty($data['start_time'])) { //开始时间到后6天的数据
            $stop_time = date("Y-m-d", strtotime($data['start_time'] . ' +7 day'));

            $start_unix_time = strtotime($data['start_time']);
            $stop_unix_time = strtotime($stop_time);

            $days = array($data['start_time']);
            for ($i = 1; $i <= 6; $i++) {
                $day = date("Y-m-d", strtotime($data['start_time'] . ' +' . $i . 'day'));
                $days[] = $day;
            }
        } else if (!empty($data['stop_time'])) { //结束时间前6天的数据
            $start_time = date("Y-m-d", strtotime($data['stop_time'] . ' -7 day'));

            $start_unix_time = strtotime($start_time);
            $stop_unix_time = strtotime($data['stop_time']);

            $days = array($start_time);
            for ($i = 1; $i <= 6; $i++) {
                $day = date("Y-m-d", strtotime($start_time . ' +' . $i . 'day'));
                $days[] = $day;
            }
        }


        $days_add = array();
        $days_leave = array();
        $days_pure_add = array();

        $tmp_days = array();
        $statistic_list = array();

        foreach ($days as $day) {

            $start_time = strtotime($day . ' 00:00:00');	//开始时间
            $stop_time = strtotime($day . ' 23:59:59');		//结束时间

            $whereAdd = "`store_id` = '".$store_id."' AND `user_subscribe_time` >= $start_time AND `user_subscribe_time` <= $stop_time AND `is_leave` = 0";
            $whereLeave = "`store_id` = '".$store_id."' AND `leave_time` >= $start_time AND `leave_time` <= $stop_time AND `is_leave` = 1";

            $addCount = D("Subscribe_store")->where($whereAdd)->count("sub_id");
            $leaveCount = D("Subscribe_store")->where($whereLeave)->count("sub_id");
            $pureAddCount = $addCount - $leaveCount;

            $days_add[] = intval($addCount);
            $days_leave[] = intval($leaveCount);
            $days_pure_add[] = $pureAddCount;
            $tmp_days[] = "'" . $day . "'";

            $statistic_list[] = array(
                'date' => $day,
                'add' => intval($addCount),
                'leave' => intval($leaveCount),
                'pure_add' => $pureAddCount,
            );
        }

        $statistic_list = array_reverse($statistic_list);

        $days = !empty($tmp_days) ? '['.implode(",", $tmp_days).']' : '[]';
        $days_add = !empty($days_add) ? '['.implode(",", $days_add).']' : '[]';
        $days_leave = !empty($days_leave) ? '['.implode(",", $days_leave).']' : '[]';
        $days_pure_add = !empty($days_pure_add) ? '['.implode(",", $days_pure_add).']' : '[]';

        // 时间段数据
        $total_add = D("Subscribe_store")->where("`store_id` = '".$store_id."' AND `user_subscribe_time` >= $start_unix_time AND `user_subscribe_time` <= $stop_unix_time AND `is_leave` = 0")->count("sub_id");
        $total_leave = D("Subscribe_store")->where("`store_id` = '".$store_id."' AND `leave_time` >= $start_unix_time AND `leave_time` <= $stop_unix_time AND `is_leave` = 1")->count("sub_id");
        $data['num_add'] = intval($total_add);
        $data['num_leave'] = intval($total_leave);
        $data['num_pure_add'] = $data['num_add'] - $data['num_leave'];

        $this->assign('data', $data);
        $this->assign('statistic_list', $statistic_list);

        // 图表
        $this->assign('days', $days);
        $this->assign('days_add', $days_add);
        $this->assign('days_leave', $days_leave);
        $this->assign('days_pure_add', $days_pure_add);
    }

    //会员管理list
    public function member() {

        $this->display();
    }

	//会员管理
	public function _member_content() {
		$store_id = $this->store_session['store_id'];
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$limit = 10;
		$where_string = "";
		$count = "0";
		
		$select_type = $_POST['select_type'];
		$keyword = $_POST['input_type'];
		
		$select_degree = $_POST['select_degree'];
		$start_point = $_POST["start_point"];
		$end_point = $_POST["end_point"];
		
		$select_time_type = $_POST['select_time_type'];
		$start_time = $_POST['start_time'];
		$end_time = $_POST['end_time'];
		
		if ($keyword) {
			switch($select_type) {
				case 'uid':
					$where[] = "su.uid = '".$keyword."'";
					break;
					
				case 'nickname':
					$where[] = "u.nickname like '%".$keyword."%'";
					break;
					
				case 'phone':
					$where[] = "u.phone like '%".$keyword."%'";
					break;
			}
		}
		
		if ($select_degree) {
			$where[] = "su.degree_id = '" . $select_degree . "'";
		}

		if ($start_point!='' && $end_point!='') {
			$where[] = "su.point >= '" . $start_point . "' AND su.point <='" . $end_point . "'";
		}elseif($start_point!='' && $end_point==''){
            $where[] = "su.point >= '" . $start_point . "'";
        }elseif($start_point=='' && $end_point!=''){
            $where[] = "su.point <='" . $end_point . "'";
        }
		
		if(!empty($start_time) || !empty($end_time)) {
			if($select_time_type == 'add_time') {
				if (!empty($start_time) && !empty($end_time)) {
					$where[] = "u.reg_time >= '" . strtotime($start_time) . "' and u.reg_time <= '" . strtotime($end_time) . "'";
				} else if (!empty($start_time)) {
					$where[] = "u.reg_time >= '" . strtotime($start_time) . "'";
				} else {
					$where[] = "u.reg_time <= '" . strtotime($end_time) . "'";
				}
			} else if($select_time_type == 'last_time') {
				if (!empty($start_time) && !empty($end_time)) {
					$where[] = "u.last_time >= '" . strtotime($start_time) . "' and u.last_time <= '" . strtotime($end_time) . "'";
				} else if (!empty($start_time)) {
					$where[] = "u.last_time >= '" . strtotime($start_time) . "'";
				} else {
					$where[] = "u.last_time <= '" . strtotime($end_time) . "'";
				}
			}
		}
		
		$where[] = "su.store_id='" . $store_id . "'";
		if(is_array($where)) {
			$where_string = implode(" and ", $where);
		}
		
		$credit_setting = D('Credit_setting')->find();
		$platform_credit_name = $credit_setting['platform_credit_name'] ? $credit_setting['platform_credit_name'] : "平台币";

		$counts = D('')->table('User as u')->join("Store_user_data as su On u.uid=su.uid")->where($where_string)->field('count(u.uid) as count')->find();
		$count = $counts['count'] ? $counts['count'] : 0;
		if ($count) {
			$page = min($page, ceil($count / $limit));
			$offset = ($page - 1) * $limit;
			$order_by = "";
			
			$list = D('')->table('User as u')->join("Store_user_data as su On u.uid=su.uid")->where($where_string)->field("su.*,u.point_unbalance,u.point_balance,u.nickname,u.login_count,u.last_time,u.phone,u.openid")->limit($offset . ',' . $limit)->select();
			if(is_array($list)) {
				foreach($list as $k=>$v) {
					$userDegree = M('Store_user_data')->getUserData($store_id, $v['uid']);
					$list[$k]['degree_name'] = $userDegree['degree_name'];
					$uid_arr[] = $v['uid'];
				}
			}

			if(is_array($uid_arr)) {
				$subsrcibe_store_list = M('Subscribe_store')->getFansByStore($store_id, $uid_arr);
				if(is_array($subsrcibe_store_list)) {
					foreach($subsrcibe_store_list as $k=>$v) {
						$guanzhu[$v['uid']] = $v;
					}
				}
			}
			import('source.class.user_page');
			$user_page = new Page($count, $limit, $page);
			$pages = $user_page->show();
		}

		//调出店铺会员等级设定
		$user_degree = D('User_degree')->where(array('store_id'=>$store_id))->order("level_num asc")->select();
		if(is_array($user_degree)) {
			foreach($user_degree as $k=>&$v) {
				$user_info_degree[$v['id']] = $v;
			}
		}
		
		$bind = D('Weixin_bind')->where(array('store_id' => $this->store_session['store_id']))->find();
		$this->assign('bind',$bind);
		$this->assign('all_degree',$user_degree);
		$this->assign('array',$list);
		$this->assign('user_info_degree',$user_info_degree);
		$this->assign('count',$count);
		$this->assign('guanzhu_user_info',$guanzhu);
		$this->assign('platform_credit_name',$platform_credit_name);
		$this->assign('pages',$pages);
	}



	//会员导出 simon
	public function member_checkout_csv() {
		$store_id = $this->store_session['store_id'];
		$page = $_REQUEST['p'] + 0;
		$page = max(1, $page);
		$limit = 1;
		$where_string = "";
		$count = "0";
		$check_type = $_REQUEST['check_type'];
		
		$select_type = $_REQUEST['select_type'];
		$keyword = $_REQUEST['input_type'];
		
		$select_degree = $_REQUEST['select_degree'];
		$start_point = $_REQUEST["start_point"];
		$end_point = $_REQUEST["end_point"];
		
		$select_time_type = $_REQUEST['select_time_type'];
		$start_time = $_REQUEST['start_time'];
		$end_time = $_REQUEST['end_time'];
		
		$where[] = "su.store_id='".$store_id."'";

		switch($check_type) {
			//当前筛选出的 会员导出
			case 'now':
				
				break;
			//导出当前勾选的会员导出
			case 'check':
				$uid_arr = $_REQUEST['uid_arr'];
				
				if (is_array($uid_arr)) {
					$uid_str = implode(",", $uid_arr);
					$where[] = "su.uid in (" . $uid_str . ")";
				} else if (!empty($uid_arr)) {
					$where[] = "su.uid in (" . $uid_arr . ")";
				}
				break;
				
			//导出全部会员
			case 'all':
				
				break;
		}
		
		if($keyword) {
			switch($select_type) {
				case 'uid':
					$where[] = "su.uid = '" . $keyword . "'";
					break;
				case 'nickname':
					$where[] = "u.nickname like '%" . $keyword . "%'";
					break;
				case 'phone':
					$where[] = "u.phone like '%" . $keyword . "%'";
					break;
			}
		}
		
		if($select_degree) {
			$where[] = "su.degree_id = '" . $select_degree . "'";
		}
		
		if(!empty($start_point) && !empty($end_point)) {
			$where[] = "su.point >= '" . $start_point . "' AND su.point <='" . $end_point . "'";
		}
		
		if(!empty($start_time) || !empty($end_time)) {
			if($select_time_type == 'add_time') {
				if (!empty($start_time) && !empty($end_time)) {
					$where[] = "u.reg_time >= '" . strtotime($start_time) . "' and u.reg_time <= '" . strtotime($end_time) . "'";
				} else if (!empty($start_time)) {
					$where[] = "u.reg_time >= '" . strtotime($start_time) . "'";
				} else {
					$where[] = "u.reg_time <= '" . strtotime($end_time) . "'";
				}
			} elseif($select_time_type == 'last_time') {
				if (!empty($start_time) && !empty($end_time)) {
					$where[] = "u.last_time >= '" . strtotime($start_time) . "' and u.last_time <= '" . strtotime($end_time) . "'";
				} else if (!empty($start_time)) {
					$where[] = "u.last_time >= '" . strtotime($start_time) . "'";
				} else {
					$where[] = "u.last_time <= '" . strtotime($end_time) . "'";
				}
			}
		}
		
		if(is_array($where)) {
			$where_string = implode(" and ", $where);
		}
		
		$credit_setting = D('Credit_setting')->find();
		$platform_credit_name = $credit_setting['platform_credit_name'] ? $credit_setting['platform_credit_name'] : "平台积分";
		$counts = D('')->table('User as u')->join("Store_user_data as su On u.uid=su.uid")->where($where_string)->field('count(u.uid) as count')->find();
		$count = $counts['count'] ? $counts['count'] : 0;
		if($_POST['show_count']) {
			json_return(json_encode($where),$count);
		}
		
		include 'source/class/execl.class.php';
		$execl = new execl();
		$filename = date($level_cn."会员信息_YmdHis",time()).'.xls';
		header ( 'Content-Type: application/vnd.ms-excel' );
		header ( "Content-Disposition: attachment;filename=$filename" );
		header ( 'Cache-Type: charset=gb2312');
		echo "<style>table td{border:1px solid #ccc;}</style>";
		echo "<table>";
		echo '	<tr>';
		echo '		<td align="center"><b> 会员昵称 </b></td>';
		echo '		<td align="center"><b> 会员等级 </b></td>';
		echo '		<td align="center"><b> 手机号 </b></td>';
		echo '		<td align="center"><b> 用户类型  </b></td>';
		echo '		<td align="center"><b> 店铺积分  </b></td>';
		echo '		<td align="center"><b> 成长值 </b></td>';
		echo '		<td align="center"><b> '.$platform_credit_name.' </b></td>';
		echo '		<td align="center"><b> '.$platform_credit_name.'（可用） </b></td>';
		echo '		<td align="center"><b> 注册时间 </b></td>';
		echo '		<td align="center"><b> 最后登录时间  </b></td>';
		echo '	</tr>';

		$page = min($page, ceil($count / $limit));
		$offset = ($page - 1) * $limit;
		$order_by = "";
		$list = D('')->table('User as u')->join("Store_user_data as su On u.uid=su.uid")->where($where_string)->field("su.*,u.reg_time,u.point_unbalance,u.point_balance,u.nickname,u.login_count,u.last_time,u.phone,u.openid")->select();
		
		$uid_arr = array();
		if(is_array($list)) {
			foreach($list as $k=>$v) {
				$uid_arr[] = $v['uid'];
			}
		}

		if(is_array($uid_arr)) {
			$subsrcibe_store_list = M('Subscribe_store')->getFansByStore($store_id,$uid_arr);
			if(is_array($subsrcibe_store_list)) {
				foreach($subsrcibe_store_list as $k=>$v) {
					$guanzhu[$v['uid']] = $v;
				}
			}
		}
		
		//调出店铺会员等级设定
		$user_degree = D('User_degree')->where(array('store_id'=>$store_id))->order("level_num asc")->select();
		$user_info_degree = array();
		if(is_array($user_degree)) {
			foreach($user_degree as $k => $v) {
				$user_info_degree[$v['id']] = $v['name'];
			}
		}
		
		foreach ($list as $k => $v) {
			$tmp_info = '';
			
			$dengji = isset($user_info_degree[$v['degree_id']]) ? $user_info_degree[$v['degree_id']] : '默认等级';
			if($v['phone']) {
				$user_type =  1;
			}
			
			if($v['openid']) {
				$user_types = 2;
			}
			
			if($user_type == 1) {
				$typename = "手机用户";
			}
			
			if($user_types == 2) {
				$typename = "微信用户";
			}
			
			echo '	<tr>';
			echo '		<td  style="vnd.ms-excel.numberformat:@" align="center" width="300">' . $v['nickname'] . '</td>';
			echo '		<td  style="vnd.ms-excel.numberformat:@" align="center" width="190">' . $dengji . '</td>';
			echo '		<td align="center">' . $v['phone'] . '</td>';
			echo '		<td align="center">' . $typename . '</td>';
			echo '		<td align="center">' . $v['point'] . '</td>';
			echo '		<td align="center">' . $v['point_count']. '</td>';
			echo '		<td align="center">' . $v['point_unbalance'] . '</td>';
			echo '		<td align="center">' . $v['point_balance']. '</td>';
			echo '		<td align="center">' . ($v['reg_time'] ? date('Y-m-d H:i:s', $v['reg_time']) : '' ). '</td>';
			echo '		<td align="center">' . ($v['last_time'] ? date('Y-m-d H:i:s', $v['last_time']) : '' ). '</td>';
			echo '	</tr>';
		}
		echo '</table>';
	}


    //
    public function get_txcode() {
    	import('phpqrcode');
    	//应用场景
    	$scene = strtonumber(option('config.site_url') . '/card');
    	$code = $_GET['uid'];
    	$code = '2-' . $scene . '-' . $code;
    	QRcode::png(urldecode($code),false,2,7,2);
    	exit;
        import('source.class.scanCode');
        $code = $_GET['uid'];
        if(!$code) return false;

        $code = sprintf("%010d", $code);

        $barcode = new scanCode($code,$code);
        $barcode->createBarCode();

    }


    //会员管理-ajax显示info
    public function show_userdetail() {

        $uid = $_REQUEST['uid'];
        $store_id = $this->store_session['store_id'];

        //用户信息
        $user = D('User')->where(array('uid'=>$uid))->field("`nickname`,`phone`,`openid`,`reg_time`,`login_count`,`status`")->find();
        if($user['reg_time']) {
            $user['reg_time'] = date("Y-m-d H:m",$user['reg_time']);
        }
        //用户在店铺信息
        $store_user_data = D('Store_user_data')->where(array('store_id'=>$store_id,'uid'=>$uid))->find();
        //
        $counts = D('Order')->where(array('store_id'=>$store_id,'uid'=>$uid))->field('sum(pay_money) as count')->find();
        $count = $counts['count'] ? $counts['count'] : 0;

        $user = is_array($user) ? $user : array();
        $store_user_data = is_array($store_user_data) ? $store_user_data : array();

        $userinfo = array_merge($user,$store_user_data);

        $userinfo['order_pay_acount'] = $count;


        json_return(0,$userinfo);
    }


    public function points_apply(){
        $this->display();
    }

    private function _points_apply_content(){

        $user_points = M('User_points');

        $store_id = $this->store_session['store_id'];                          /*当前店铺id*/
        $type = !empty($_POST['type']) ? $_POST['type'] : '';                  /*积分来源*/
        $user_name = !empty($_POST['user_name']) ? $_POST['user_name'] : '';   /*用户名*/
        $user_uid = $_REQUEST['uid'];
        $start_time = !empty($_POST['start_time']) ? strtotime($_POST['start_time']) : '';/*时间 开始*/
        $end_time = !empty($_POST['end_time']) ? strtotime($_POST['end_time']) : '';      /*时间 结束*/
        $store_points = !empty($_POST['points']) ? $_POST['points'] : '1' ;          /*1 积分生成 2 积分消耗*/

        $where = array();

        $where['s.store_id'] = $store_id;
        $where['s.is_available'] = 1;

        if(!empty($type)){
            $where['s.type'] = $type;
        }

        if(!empty($user_name)){
            $where['ss.nickname'] = $user_name;
        }
        if(!empty($user_uid)) {
            $where['ss.uid'] = $user_uid;
        }
        if (!empty($start_time) && !empty($end_time)){
            $where['_string'] = "s.timestamp >= " . $start_time . " AND s.timestamp <= " . $end_time;
        }
        else if (!empty($start_time)){
            $where['s.timestamp'] = array ('>=', $start_time);
        } else if (!empty($end_time)){
            $where['s.timestamp'] = array ('<=', $end_time);
        }

        import('source.class.user_page');

        if($store_points == 1){

            $where['s.points'] = array('>',0);
            $points_count = $user_points->getPoints($where);

            $page = new Page($points_count, 10);

            $points = $user_points->getStoreData($where,$page->firstRow, $page->listRows);
        }else if($store_points == 2){

            $where['s.points'] = array('<',0);

            $points_count = $user_points->getPoints($where);

            $page = new Page($points_count, 10);

            $points = $user_points->getStoreData($where,$page->firstRow, $page->listRows);
        }

        $pointlist = array();
        foreach($points as $point){

            $order_no = D('Order')->field('order_no')->where(array('order_id' => $point['order_id']))->find(); /* 订单号 */

            $pointlist[] = array(
                'nickname' => $point['nickname'],
                'type' => $point['type'],
                'timestamp' => $point['timestamp'],
                'order_no' => $order_no['order_no'],
                'points' => $point['points'],
            );
        }
        $this->assign('pointlist',$pointlist);
        $this->assign('store_points',$store_points);
        $this->assign('page', $page->show());
    }

}