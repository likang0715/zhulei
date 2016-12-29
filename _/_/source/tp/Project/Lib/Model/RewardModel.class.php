<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 14:02
 */
class RewardModel extends Model
{
    public function getListByProductId($product_id_arr, $store_id, $uid) {
        $time = time();
        $db_prefix = C('DB_PREFIX');
        $sql = "SELECT distinct r.* FROM `" . $db_prefix . "reward` AS r LEFT JOIN `" . $db_prefix . "reward_product` AS rp ON `r`.`id` = `rp`.`rid` WHERE `r`.`store_id` = '" . $store_id . "' AND (`r`.`is_all` = 1 or `rp`.`product_id` in (" . join(',', $product_id_arr) . ")) AND `r`.`uid` = '" . $uid . "' AND `r`.`status` = '1' AND `r`.`start_time` <= '" . $time . "' AND `r`.`end_time` >= '" . $time . "'";
        $reward_list = $this->query($sql);

        foreach ($reward_list as &$reward) {
            $where = array();
            $where['rid'] = $reward['id'];

            // 优惠条件
            $reward_condition_list = D('RewardCondition')->getList($where, 0, 0, 'id desc');
            $reward['condition_list'] = $reward_condition_list;

            // 优惠参加产品
            if ($reward['is_all'] == 2) {
                $reward_product_list = D('RewardProduct')->getList($where);
                $product_id_arr = array();
                foreach ($reward_product_list as $tmp) {
                    $product_id_arr[$tmp['product_id']] = $tmp['product_id'];
                }

                $reward['product_list'] = $product_id_arr;
            } else {
                $reward['product_list'] = array();
            }
        }
        return $reward_list;
    }
}