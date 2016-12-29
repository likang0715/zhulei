<?php

/**
 * 分销团队成员标签
 * User: pigcms_21
 * Date: 2016/1/24
 * Time: 16:58
 */
class drp_team_member_label_model extends base_model
{

    //成本标签
    public function getMemberLabels($where)
    {
        $labels = $this->db->where($where)->order('store_id DESC, drp_level ASC')->select();
        return !empty($labels) ? $labels : array();
    }
}