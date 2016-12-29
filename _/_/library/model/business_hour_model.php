<?php

class business_hour_model extends base_model {

//数据添加
    public function business_hour_add($data) {
        if (!$data) {
            return array('err_code' => 1, 'info' => '数据不存在！');
        }


        if (is_string($data['business_time'])) {
            $arr = explode(',', $data['business_time']);
            unset($data['business_time']);
        }

        $arr_num = count($arr);
        if ($arr_num == 0 || ($arr_num % 2 == 1)) {
            return array(0, '数据不正确！');
        }
        $where['store_id'] = $_SESSION['store']['store_id'];

        $start_time = strtotime(reset($arr)) - strtotime(date('Y-m-d', time()));
        $end_time = strtotime(end($arr)) - strtotime(date('Y-m-d', time()));

        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        if ($this->db->data($data)->add()) {
            return array('err_code' => 0, 'info' => '添加成功！');
        } else {
            return array('err_code' => 1, 'info' => '添加失败！');
        }
    }

//数据列表
//    public function getAllList($where, $page_size = 15) {
//
//        $list_count = $this->db->where($where)->count('id');
//        import('source.class.user_page');
//        $p = new Page($list_count, $page_size);
//        $page_list = $this->db->where($where)->order('`id` DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
//
//        $return['page_list'] = $page_list;
//        $return['page'] = $p->show();
//        return $return;
//    }

//修改状态
    public function edit_status($where) {
        if (!$where) {
            return array('err_code' => 1, 'err_msg' => '数据不存在！');
        }

        $info = $this->db->where($where)->find();
        if (!$info) {
            return array('err_code' => 1, 'err_msg' => '数据不存在！');
        }

        switch ($info['is_open']) {
            case 0:
                $data['is_open'] = 1;
                break;
            case 1:
                $data['is_open'] = 0;
                break;
            default:
                break;
        }

        $result = $this->db->where($where)->data($data)->save();
        if ($result) {
            return array('err_code' => 0, 'err_msg' => '修改成功！');
        } else {
            return array('err_code' => 1, 'err_msg' => '修改失败！');
        }
    }

    //数据修改
    public function business_hour_edit($where, $data) {
        if (!$where) {
            return array('err_code' => 1, 'err_msg' => '数据不存在！');
        }

        if (!$data) {
            return array('err_code' => 1, 'err_msg' => '数据不存在！');
        }

        $data['start_time'] = strtotime($data['start_time']) - strtotime(date('Y-m-d', time()));
        $data['end_time'] = strtotime($data['end_time']) - strtotime(date('Y-m-d', time()));
        $result = $this->db->where($where)->data($data)->save();

        if ($result) {
            return array('err_code' => 0, 'err_msg' => '修改成功！');
        } else {
            return array('err_code' => 1, 'err_msg' => '修改失败！');
        }
    }

}

?>
