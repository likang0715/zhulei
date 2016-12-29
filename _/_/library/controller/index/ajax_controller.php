<?php
/**
 * Created by PhpStorm.
 * User: pigcms-s
 * Date: 2015/5/25
 * Time: 10:09
 * description:  PC-全站ajax操作
 */

class ajax_controller extends base_controller {

    public function load() {

        //需要登陆操作的
        $action = strtolower(trim($_GET['action']));

        if(in_array($action,array($action,array('collect'))) || !isset($action)) {
            //需要登陆才能操作
            $uid = $this->user_session['uid'];
            if(!$uid)   echo json_return(400, "请登录后操作"); //json 反馈

        }


        if (empty($action)) echo json_return(500, "非法操作"); //json 反馈
        switch ($action) {
            case 'collect':         //收藏店铺 or 商品
                    $this->_collect($uid);
                    break;

        }


    }



    //收藏店铺 or 商品
    private function _collect($uid) {

        /* 检查是否已经存在于用户的收藏夹 */
        $type = $_GET['type'];  //1：商品 2：店铺
        $dataid = $_GET['dataid'];
        $time = time();



        if(!in_array($type,array(1,2)) || !isset($dataid))  echo json_return(501, "非法操作");



        $data[ 'user_id'] = $where['user_id'] = $uid;
        $data[ 'type'] = $where['type'] =  $type;
        $data[ 'dataid'] = $where['dataid'] =  $dataid;
        $data['add_time'] = $time;

       $collect = D('User_collect')->where($where)->find();
        if($collect) echo json_return(502, "已收藏");


        if(D('User_collect')->data($data)->add()){
            json_return(0,'保存成功');
        }else{
            json_return(503,'保存失败');
        }

    }

}
