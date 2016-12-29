<?php
/**
 * 主营类目数据模型
 * User: pigcms_21
 * Date: 2015/2/13
 * Time: 13:57
 */
class seckill_user_model extends base_model{

    /**
     * 获取帮助我的好友列表
     * @param $seckill_id
     * @param $seckill_user_id
     * @return array
     */
    public function getUserList($seckill_id, $seckill_user_id){

        $sql = "select * from ".option('system.DB_PREFIX')."user as u,".option('system.DB_PREFIX')."seckill_user as sec where u.uid = sec.user_id and sec.seckill_id={$seckill_id} and sec.seckill_user_id = $seckill_user_id";

        $sql .= " ORDER BY preset_time DESC";

        $userList = $this->db->query($sql);

        return !empty($userList) ? $userList : array();
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