<?php

/**
 * 用户权限模型
 * User: pigcms_21
 * Date: 2015/2/11
 * Time: 16:37
 */
class rbac_action_model extends base_model {

    // 旧版 请用下面 add_rbac
    function add_rbac_goods($data)
    {
        $data_rbac['uid'] = $data['uid'];
        $data_rbac['add_time'] = time();
        $data_rbac['update_time'] = time();
        $data_rbac['controller_id'] = $data['goods_control'];
        $data_rbac['action_id'] = $data['goods_action'];
        $rbac = $this->db->data($data_rbac)->add();
    }

    // 旧版 请用下面 add_rbac
    function add_rbac_order($data)
    {
        $data_rbac['uid'] = $data['uid'];
        $data_rbac['add_time'] = time();
        $data_rbac['update_time'] = time();
        $data_rbac['controller_id'] = $data['order_control'];
        $data_rbac['action_id'] = $data['order_action'];
        $rbac = $this->db->data($data_rbac)->add();
        unset($data_rbac);
    }

    // 旧版 请用下面 add_rbac
    function add_rbac_trade($data)
    {
        $data_rbac['uid'] = $data['uid'];
        $data_rbac['add_time'] = time();
        $data_rbac['update_time'] = time();
        $data_rbac['controller_id'] = $data['trade_control'];
        $data_rbac['action_id'] = $data['trade_action'];
        $rbac = $this->db->data($data_rbac)->add();
    }

// yfz@20160818
   function add_rbac_events($data)
    {
        $data_rbac['uid'] = $data['uid'];
        $data_rbac['add_time'] = time();
        $data_rbac['update_time'] = time();
        $data_rbac['controller_id'] = $data['events_control'];
        $data_rbac['action_id'] = $data['events_action'];
        $rbac = $this->db->data($data_rbac)->add();
    }
	
	function add_rbac_meal($data)
    {
        $data_rbac['uid'] = $data['uid'];
        $data_rbac['add_time'] = time();
        $data_rbac['update_time'] = time();
        $data_rbac['controller_id'] = $data['meal_control'];
        $data_rbac['action_id'] = $data['meal_action'];
        $rbac = $this->db->data($data_rbac)->add();
    }
    /**
     * [add_rbac 添加一条用户权限记录]
     * @param    [type] $data [添加数据]
     * @param    [type] $controller [所属控制器]
     * @Auther   pigcms_89
     * @DateTime 2015-12-14T16:23:46+0800
     */
    public function add_rbac($data, $controller)
    {
        $data_rbac = array(
                'uid' => $data['uid'],
                'add_time' => time(),
                'update_time' => time(),
                'controller_id' => $controller,
                'action_id' => $data['action'],
            );
        $rbac = $this->db->data($data_rbac)->add();
    }

    public function delete_action($data)
    {
        $goods_condition['uid'] =  $data['uid'];
        $goods_condition['controller_id'] = $data['controller_id'];
        $rbac_model = $this->db->where($goods_condition)->delete();
    }


    public function getMethod($uid, $controller, $action)
    {
        $db_prefix = option('system.DB_PREFIX');
        $sql = "select * from `".$db_prefix."rbac_action` where uid='$uid' and controller_id='$controller' and action_id='$action'";
        $method = $this->db->query($sql);

        return count($method)>0 ? true : false;
    }

    public function getOne($uid, $controller)
    {
        $method = $this->db->where(array("uid"=>$uid,"controller_id"=>$controller))->find();
        return !empty($method) ? $method['action_id'] : '';
    }

    /**
     * [getControlArr 获取用户<控制器>下拥有的<权限方法>数组]
     * @param    [int] $uid [用户id]
     * @param    [str] $controller [控制器]
     * @return   [arr] [权限方法数组]
     * @Auther   pigcms_89
     * @DateTime 2015-12-14T16:22:08+0800
     */
    public function getControlArr($uid, $controller)
    {
        $rbacArr = array();

        $method = $this->db->where(array("uid"=>$uid,"controller_id"=>$controller))->select();
        foreach ($method as $val) {

            $rbacArr[] = $val['action_id'];
        }

        return $rbacArr;
    }

}