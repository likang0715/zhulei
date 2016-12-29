<?php
/**
 * 主营类目数据模型
 * User: pigcms_21
 * Date: 2015/2/13
 * Time: 13:57
 */
class seckill_model extends base_model{

    public function getCount($where) {
        $tuan_count = $this->db->field('count(1) as count')->where($where)->find();
        return $tuan_count['count'];
    }

    /**
     * 根据条件获到列表
     * 当limit与offset都为0时，表示不行限制
     */
    public function getList($where, $order_by = '', $limit = 0, $offset = 0) {
        $this->db->where($where);
        if (!empty($order_by)) {
            $this->db->order($order_by);
        }

        if (!empty($limit)) {
            $this->db->limit($offset . ',' . $limit);
        }

        $seckill_list = $this->db->select();

        return $seckill_list;
    }

    /**
     * 得到秒杀用户排名
     * @param $seckill_uid
     * @param $seckill_id
     * @return int
     */
    public function getUserNum($seckill_uid, $seckill_id){
        $rank = 0;
        $seckillUser = D('Seckill_user')->field('preset_time')->where(array('seckill_user_id' => $seckill_uid, 'seckill_id'=>$seckill_id))->find();
        if (!empty($seckillUser) && !empty($seckillUser['preset_time'])) {
            $where = array();
            $where['seckill_id'] = $seckill_id;
            $where['preset_time'] = array('>', preset_time);
            $rank = D('Store')->distinct('preset_time')->where($where)->count('preset_time');
            $rank = !empty($rank) ? $rank : 0;
            $rank++;
        }
        return $rank;
    }

    /**
     * 格式化时间
     * @param $times
     * @return string
     */
    public function secToTime($times){
        $result = '00:00:00';
        if ($times>0) {
            $hour = floor($times/3600);
            $hour = ($hour > 10) ? $hour : '0'.$hour;
            $minute = floor(($times-3600 * $hour)/60);
            $minute = ($minute > 10) ? $minute."" : '0'.$minute."";
            $second = floor((($times-3600 * $hour) - 60 * $minute) % 60);
            $second = ($second > 10) ? $second.'' : '0'.$second.'';
            $result = $hour.':'.$minute.':'.$second;
        }
        return $result;
    }

}