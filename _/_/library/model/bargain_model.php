<?php
/**
 * 应用营销砍价模型
 * User: gerrant
 * Date: 2016/02/17
 * Time: 10:06
 */
class bargain_model extends base_model{

    /**
     * 获取满足条件的砍价商品
     * @param $where
     * @return mixed
     */
    public function getCount($where){
        $count = $this->db->where($where)->count('pigcms_id');
        return $count;
    }

    /**
     * 分页获取砍价商品列表
     * @param $where
     * @param string $order_by
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
        $this->db->field("pigcms_id,name,original,minimum,inventory,addtime,state,logoimg1,product_id");

        $this->db->where($where);

        if (!empty($order_by)) {
            $this->db->order($order_by);
        }

        if (!empty($limit)) {
            $this->db->limit($offset . ',' . $limit);
        }

        $bargain_list = $this->db->select();
        return $bargain_list;
    }

    public function update($data,$where){
        return $this->db->where($where)->data($data)->save();
    }

    public function add($data){
        return $this->db->data($data)->add();
    }

    public function getOne($where){
        return $this->db->where($where)->find();
    }

    public function save($where,$data){
        return $this->db->where($where)->data($data)->save();
    }
}
