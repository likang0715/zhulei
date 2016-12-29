<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 13:45
 */
class UserDegreeModel extends Model
{
    /*
     * 获取一个人 在 某个店铺的会员等级
     */
    public function getUserDegree($uid,$store_id) {

        //获取用户在店铺积分信息
        $user_point_info = D('StoreUserData')->getpoints_by_storeid($uid,$store_id);
        if($user_point_info['point']) {
            $return = $this->where("store_id='" . $store_id . "' and points_limit <= '" . $user_point_info['point'] . "' ")->order("points_limit desc")->limit(1)->find();
        }
        $return = $return ? $return : array('name' => '未有等级');
        return $return;
    }
}