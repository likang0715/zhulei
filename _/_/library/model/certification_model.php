<?php

/**
 * 认证信息模型
 * User: pigcms_21
 * Date: 2015/3/16
 * Time: 13:48
 */
class certification_model extends base_model {

    public function add($data) {
        if (!$data) {
            return false;
        }

        if (!empty($data ['signform_face_img'])) {
            $data ['signform_face_img'] = getAttachment($data ['signform_face_img']);
        }

        if (!empty($data ['identification_face'])) {
            $data ['identification_face'] = getAttachment($data ['identification_face']);
        }

        $data['store_id'] = $_SESSION['store']['store_id'];

        $certification_info = $this->db->where(array('store_id' => $data['store_id']))->find();
        if ($certification_info) {
            $this->db->where(array('store_id' => $data['store_id']))->delete();
        }


        $last_id = $this->db->data($data)->add();

        if ($last_id) {
            $store_data['approve'] = 2;
            D('Store')->where(array('store_id' => $_SESSION['store']['store_id']))->data($store_data)->save();
        }
        return $last_id;
    }

    public function get($where)
    {
        $data = $this->db->where($where)->find();
        return $data;
    }
}
