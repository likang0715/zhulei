<?php
/**
 * 找人代付数据模型
 * User: pigcms_21
 * Date: 2015/2/4
 * Time: 11:32
 */
    class store_pay_agent_model extends base_model
    {
        //添加求助/留言
        public function add($data)
        {
            $result = $this->db->data($data)->add();
            return $result;
        }

        //修改求助/留言
        public function edit($data, $where)
        {
            $result = $this->db->where($where)->data($data)->save();
            return $result;
        }

        //删除求助/留言
        public function del($where)
        {
            $result = $this->db->where($where)->delete();
            return $result;
        }

        //获取发起人的求助
        public function getBuyerHelps($store_id)
        {
            $helps = $this->db->where(array('store_id' => $store_id, 'type' => 0))->order('agent_id DESC')->select();
            return $helps;
        }

        //获取代付人的留言
        public function getPayerComments($store_id)
        {
            $comments = $this->db->where(array('store_id' => $store_id, 'type' => 1))->order('agent_id DESC')->select();
            return $comments;
        }
    }