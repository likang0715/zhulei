<?php
class helping_controller extends base_controller {

    //加载
    public function load() {
        $action = strtolower(trim($_POST['page']));
        if (empty($action)) pigcms_tips('非法访问！', 'none');

        switch ($action) {
            case 'helping_list':
                $this->_helping_list();
                break;
            case 'helping_edit':
                $this->_helping_edit();
                break;
            case 'helping_add' :
                $this->_helping_add();
                break;
            case 'helping_log' :
                $this->_helping_log();
                break;
            default:
                break;
        }

        $this->display($_POST['page']);
    }

    /**
     * 助力主页面
     */
    public function helping_index(){
        // 优惠券
        $time = time();
        $where = array();
        $where['store_id'] = $_SESSION['store']['store_id'];
        $where['status'] = 1;
        $where['type'] = 1;
        $where['start_time'] = array('<=', $time);
        $where['end_time'] = array('>=', $time);
        $coupon_list = M('Coupon')->getList($where);
        $coupon_list_select = '';
        foreach($coupon_list as $k=>$v){
            $coupon_list_select = $coupon_list_select.'<option value="'.$v['id'].'" val="'.$v['name'].'">'.$v['name'].'</option>';
        }
        $this->assign('coupon_list_select',$coupon_list_select);
        //导航栏
        $this->assign('select_sidebar','helping');

        $this->display();
    }

    /**
     * 助力列表
     */
    public function _helping_list(){
        $helping = D('Helping');
        $Helping_news = D('Helping_news');
        $Helping_prize = D('Helping_prize');

        $page = $_REQUEST['p'] + 0;
        $page = max(1, $page);
        $type = $_REQUEST['type'];
        $keyword = $_REQUEST['keyword'];
        $limit = 20;

        $type_arr = array('future', 'on', 'end', 'all');
        if (!in_array($type, $type_arr)) {
            $type = 'all';
        }

        $store_id = $_SESSION['store']['store_id'];

        $where = array();
        $where['store_id'] = $store_id;
        $where['delete_flag'] = 0;

        if (!empty($keyword)) {
            $where['title'] = array('like', '%' . $keyword . '%');
        }

        $time = date("Y-m-d H:i:s");
        if ($type == 'future') {
            $where['start_time'] = array('>', $time);
            $where['is_open'] = 1;
        } else if ($type == 'on') {
            $where['start_time'] = array('<', $time);
            $where['end_time'] = array('>', $time);
            $where['is_open'] = 1;
        } else if ($type == 'end') {
            $where['end_time'] = array('<', $time);
            $where['is_open'] = 1;
        }

        $count = $helping->where($where)->count('id');

        $helping_list = array();
        $pages = '';
        if ($count > 0) {
            $page = min($page, ceil($count / $limit));
            $offset = ($page - 1) * $limit;

            $helping_list = $helping->where($where)->order('id desc')->limit($offset.",".$limit)->select();

            import('source.class.user_page');
            $user_page = new Page($count, $limit, $page);
            $pages = $user_page->show();
        }

        //判断活动状态
        $time = time();
        foreach($helping_list as $k=>$v){
            if (strtotime($v['start_time']) > $time) {
                $helping_list[$k]['status'] = "未开始";
            } else if (strtotime($v['end_time']) < $time) {
                $helping_list[$k]['status'] = "已结束";
            } else {
                $helping_list[$k]['status'] = "正在进行";
            }
        }

        $this->assign('keyword', $keyword);
        $this->assign('type', $type);
        $this->assign('pages', $pages);
        $this->assign('helping_list', $helping_list);
    }

    /**
     * 助力活动编辑页面
     */
    public function _helping_edit(){
        $database_helping = D('Helping');
        $database_helping_news = D('Helping_news');
        $database_helping_prize = D('Helping_prize');

        $id = $_REQUEST['id'];
        $uid = $_SESSION['store']['uid'];
        $store_id = $_SESSION['store']['store_id'];

        //获取助力活动信息
        unset($where);
        $where = array();
        $where['id'] = $_REQUEST['id'];
        $where['store_id'] = $_SESSION['store']['store_id'];
        $where['delete_flag'] = 0;

        $helping = $database_helping->where($where)->find();

        //获取活动宣传图片
        unset($where);
        $where['pid'] = $helping['id'];
        $helping_news = $database_helping_news->where($where)->select();

        //获取活动奖品图片
        unset($where);
        $where['pid'] = $helping['id'];
        $helping_prizes_count = $database_helping_prize->where($where)->count('id');
        if($helping_prizes_count>0){
            $helping_prizes = $database_helping_prize->where($where)->select();
            foreach($helping_prizes as $hpk=>$hpv){
                if($hpv['type']==1){
                    $rs = M('Product')->get(array('product_id'=>$hpv['title']), 'name');
                    $helping_prizes[$hpk]['proname'] = $rs['proname'];
                }
            }
        };

        //活动是否正在进行
        $now = time();
        if ($now < strtotime($helping["start_time"])) {
            $is_save = true;
        } else {
            $is_save = false;
        }

        // 优惠券
        $time = time();
        $where = array();
        $where['store_id'] = $_SESSION['store']['store_id'];
        $where['status'] = 1;
        $where['type'] = 1;
        $where['start_time'] = array('<=', $time);
        $where['end_time'] = array('>=', $time);
        $coupon_list = M('Coupon')->getList($where);
        $coupon_list_select = '';
        foreach($coupon_list as $k=>$v){
            $coupon_list_select = $coupon_list_select.'<option value="'.$v['id'].'" val="'.$v['name'].'">'.$v['name'].'</option>';
        }

        //生成令牌
        $hash = rand(100000,999999);
        $_SESSION['hash'] = $hash;

        $this->assign("helping",$helping);
        $this->assign("helping_news",$helping_news);
        $this->assign("helping_prizes",$helping_prizes);
        $this->assign("is_save",$is_save);
        $this->assign('coupon_list_select',$coupon_list_select);
        $this->assign('hash',$hash);
    }

    /**
     * 助力活动添加页面
     */
    public function _helping_add(){
        // 优惠券
        $time = time();
        $where = array();
        $where['store_id'] = $_SESSION['store']['store_id'];
        $where['status'] = 1;
        $where['type'] = 1;
        $where['start_time'] = array('<=', $time);
        $where['end_time'] = array('>=', $time);
        $coupon_list = M('Coupon')->getList($where);
        $coupon_list_select = '';
        foreach($coupon_list as $k=>$v){
            $coupon_list_select = $coupon_list_select.'<option value="'.$v['id'].'" val="'.$v['name'].'">'.$v['name'].'</option>';
        }

        //生成令牌
        $hash = rand(100000,999999);
        $_SESSION['hash'] = $hash;

        $this->assign('coupon_list_select',$coupon_list_select);
        $this->assign('hash',$hash);
    }

    /**
     *助力活动领奖纪录
     */
    public function _helping_log(){
        $Helping_prize = D('Helping_prize');

        $where = array();
        $where['pid'] = isset($_REQUEST['id'])?$_REQUEST['id']:'0';

        $count = $Helping_prize->where($where)->count('id');

        $helping_log = array();
        if ($count > 0) {
            $helping_log = $Helping_prize->where($where)->order('id desc')->select();
            foreach($helping_log as $hpk=>$hpv){
                if($hpv['type']==1){
                    $rs = M('Product')->get(array('product_id'=>$hpv['title']), 'name');
                    $helping_log[$hpk]['title'] = $rs['name'];
                }elseif($hpv['type']==2){
                    unset($where);
                    $where['id'] = $hpv['title'];
                    $where['type'] = 1;
                    $rs = M('Coupon')->getCoupon($where);
                    $helping_log[$hpk]['title'] = $rs['name'];
                }elseif($hpv['type']==3){
                    $helping_prizes[$hpk]['title'] = "店铺积分";
                };
            };
        }

        $this->assign('helping_log', $helping_log);
    }

    /**
     * 添加助力活动
     */
    public function _do_helping_add(){
        if( $_SESSION['hash']!=$_POST['hash'] || !isset($_SESSION['hash']) || !isset($_POST['hash']) ){
            json_return(1001,'页面已经过期');
        };

        if (IS_POST) {
            $title = $_POST['title'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $wxtitle = $_POST['wxtitle'];
            $wxinfo = $_POST['wxinfo'];
            $wxpic = $_POST['wxpic'];
            $guize = $_POST['guize'];
            $prize_type = $_POST['prize_type'];
            $prize_imgurl = $_POST['prize_imgurl'];
            $prize_title = $_POST['prize_title'];
            $news_imgurl = $_POST['news_imgurl'];
            $news_title = $_POST['news_title'];
            $rank_num = $_POST['rank_num'];
            $is_attention = $_POST['is_attention'];
            $is_help = $_POST['is_help'];
            $is_open = $_POST['is_open'];

            if (empty($title)) {
                json_return(1001,'活动名称没有填写，请填写');
            };
            if (empty($start_time)) {
                json_return(1002,'活动开始时间没有填写，请填写');
            };
            if (empty($start_time)) {
                json_return(1003,'活动结束时间没有填写，请填写');
            };
            if (empty($wxtitle)) {
                json_return(1004,'微信分享标题没有填写，请填写');
            };
            if (empty($wxinfo)) {
                json_return(1005,'微信分享描述没有填写，请填写');
            };
            if (empty($guize)) {
                json_return(1006,'活动规则未填写，请填写');
            };
            if (empty($rank_num)) {
                json_return(1007,'活动排行数未填写，请填写');
            };

            // 1.1添加活动记录
            $helping = D('Helping');
            $Helping_news = D('Helping_news');
            $Helping_prize = D('Helping_prize');


            $data['store_id'] = $_SESSION['store']['store_id'];
            $data['title'] = $title;
            $data['start_time'] = $start_time;
            $data['end_time'] = $end_time;
            $data['wxtitle'] = $wxtitle;
            $data['wxinfo'] = $wxinfo;
            $data['wxpic'] = $wxpic;
            $data['guize'] = $guize;
            $data['rank_num'] = $rank_num;
            $data['is_attention'] = $is_attention;
            $data['is_help'] = $is_help;
            $data['is_open'] = $is_open;
            $data['add_time'] = time();
            $pid = $helping->data($data)->add();
            //$pid = true;
            if($pid){
                //1.2添加宣传图片
                $imgurl_arr = array();
                $tmp_imgurl_arr = explode('&',urldecode($news_imgurl));
                $tmp_title_arr = explode('&',urldecode($news_title));
                if(count($tmp_imgurl_arr)==count($tmp_title_arr)){
                    for($i=0;$i<count($tmp_imgurl_arr);$i++){
                        $imgurl_arr = explode('=',$tmp_imgurl_arr[$i]);
                        $title_arr = explode('=',$tmp_title_arr[$i]);
                        $newsdata['pid'] = $pid;
                        $newsdata['title'] = $title_arr[1];
                        $newsdata['imgurl'] = $imgurl_arr[1];
                        $rs = $Helping_news->data($newsdata)->add();
                    }
                }
                //2.2添加奖品
                $imgurl_arr = array();
                unset($tmp_imgurl_arr);unset($tmp_title_arr);
                $tmp_type_arr = explode('&',urldecode($prize_type));
                $tmp_imgurl_arr = explode('&',urldecode($prize_imgurl));
                $tmp_title_arr = explode('&',urldecode($prize_title));
                if(count($tmp_type_arr)==count($tmp_imgurl_arr)){
                    for($i=0;$i<count($tmp_type_arr);$i++){
                        $type_arr = explode('=',$tmp_type_arr[$i]);
                        $imgurl_arr = explode('=',$tmp_imgurl_arr[$i]);
                        $title_arr = explode('=',$tmp_title_arr[$i]);
                        $prizedata['pid'] = $pid;
                        $prizedata['type'] = $type_arr[1];
                        $prizedata['title'] = $title_arr[1];
                        $prizedata['imgurl'] = $imgurl_arr[1];
                        $prizedata['num'] = $i+1;
                        $rs = $Helping_prize->data($prizedata)->add();
                    }
                }
                unset($_SESSION['hash']);
                json_return(0, '添加成功');
            }else{
                json_return(1008, '添加失败，请重新');
            }
        }
    }

    /**
     * 编辑助力活动
     */
    public function _do_helping_edit(){
        if( $_SESSION['hash']!=$_POST['hash'] || !isset($_SESSION['hash']) || !isset($_POST['hash']) ){
            json_return(1001,'页面已经过期');
        };

        if (IS_POST) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $wxtitle = $_POST['wxtitle'];
            $wxinfo = $_POST['wxinfo'];
            $wxpic = $_POST['wxpic'];
            $guize = $_POST['guize'];
            $prize_id = $_POST['prize_id'];
            $prize_type = $_POST['prize_type'];
            $prize_imgurl = $_POST['prize_imgurl'];
            $prize_title = $_POST['prize_title'];
            $news_id = $_POST['news_id'];
            $news_imgurl = $_POST['news_imgurl'];
            $news_title = $_POST['news_title'];
            $rank_num = $_POST['rank_num'];
            $is_attention = $_POST['is_attention'];
            $is_help = $_POST['is_help'];
            $is_open = $_POST['is_open'];

            if (empty($title)) {
                json_return(1001,'活动名称没有填写，请填写');
            };
            if (empty($start_time)) {
                json_return(1002,'活动开始时间没有填写，请填写');
            };
            if (empty($start_time)) {
                json_return(1003,'活动结束时间没有填写，请填写');
            };
            if (empty($wxtitle)) {
                json_return(1004,'微信分享标题没有填写，请填写');
            };
            if (empty($wxinfo)) {
                json_return(1005,'微信分享描述没有填写，请填写');
            };
            if (empty($guize)) {
                json_return(1006,'活动规则未填写，请填写');
            };
            if (empty($rank_num)) {
                json_return(1007,'活动排行数未填写，请填写');
            };

            // 1.1编辑活动记录
            $helping = D('Helping');
            $Helping_news = D('Helping_news');
            $Helping_prize = D('Helping_prize');

            $data['store_id'] = $_SESSION['store']['store_id'];
            $data['title'] = $title;
            $data['start_time'] = $start_time;
            $data['end_time'] = $end_time;
            $data['wxtitle'] = $wxtitle;
            $data['wxinfo'] = $wxinfo;
            $data['wxpic'] = $wxpic;
            $data['guize'] = $guize;
            $data['rank_num'] = $rank_num;
            $data['is_attention'] = $is_attention;
            $data['is_help'] = $is_help;
            $data['is_open'] = $is_open;
            $data['add_time'] = time();
            $pid = $helping->where(array('id'=>$id))->data($data)->save();
            if($pid){
                //1.2编辑宣传图片
                $imgurl_arr = array();
                $tmp_id_arr = explode('&',urldecode($news_id));
                $tmp_imgurl_arr = explode('&',urldecode($news_imgurl));
                $tmp_title_arr = explode('&',urldecode($news_title));
                if(count($tmp_imgurl_arr)==count($tmp_title_arr)){
                    for($i=0;$i<count($tmp_imgurl_arr);$i++){
                        $id_arr = explode('=',$tmp_id_arr[$i]);
                        $imgurl_arr = explode('=',$tmp_imgurl_arr[$i]);
                        $title_arr = explode('=',$tmp_title_arr[$i]);
                        $newsdata['title'] = $title_arr[1];
                        $newsdata['imgurl'] = $imgurl_arr[1];
                        $rs = $Helping_news->where(array('id'=>$id_arr[1]))->data($newsdata)->save();
                    }
                }
                //2.2编辑奖品
                $imgurl_arr = array();
                unset($tmp_imgurl_arr);unset($tmp_title_arr);
                $tmp_id_arr = explode('&',urldecode($prize_id));
                $tmp_type_arr = explode('&',urldecode($prize_type));
                $tmp_imgurl_arr = explode('&',urldecode($prize_imgurl));
                $tmp_title_arr = explode('&',urldecode($prize_title));
                if(count($tmp_type_arr)==count($tmp_imgurl_arr)){
                    for($i=0;$i<count($tmp_type_arr);$i++){
                        $id_arr = explode('=',$tmp_id_arr[$i]);
                        $type_arr = explode('=',$tmp_type_arr[$i]);
                        $imgurl_arr = explode('=',$tmp_imgurl_arr[$i]);
                        $title_arr = explode('=',$tmp_title_arr[$i]);
                        $prizedata['type'] = $type_arr[1];
                        $prizedata['title'] = $title_arr[1];
                        $prizedata['imgurl'] = $imgurl_arr[1];
                        $rs = $Helping_prize->where(array('id'=>$id_arr[1]))->data($prizedata)->save();
                    }
                }
                unset($_SESSION['hash']);
                json_return(0, '编辑成功');
            }else{
                json_return(1008, '编辑失败，请重新');
            }
        }
    }

    /**
     * 删除助力活动
     */
    public function helping_delete(){
        $database_helping = D('Helping');

        $pid = (int)$_GET['pid'];
        if($pid==0){
            json_return(1000,'活动id出错');
        }

        unset($where);
        $where['id'] = $pid;
        $where['store_id'] = $_SESSION['store']['store_id'];
        $data['delete_flag'] = 1;
        $result = $database_helping->where($where)->data($data)->save();

        if($result){
            redirect(url('user:helping:helping_index'));
        }else{
            json_return(1000,'删除失败');
        }
    }

}
