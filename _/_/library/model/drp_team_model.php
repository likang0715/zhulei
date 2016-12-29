<?php

/**
 * 分销团队
 * User: pigcms_21
 * Date: 2016/1/24
 * Time: 15:40
 */
class drp_team_model extends base_model
{
    public function getDrpTeams($where, $order_by = 'dt.pigcms_id DESC', $offset = 0, $limit = 20)
    {
        $sql = "SELECT dt.*,s.name AS owner FROM " . option('system.DB_PREFIX') . "drp_team dt, " . option('system.DB_PREFIX') . "store s WHERE dt.store_id = s.store_id";
        if (!empty($where)) {
            if (is_string($where)) {
                $sql .= " AND " . $where;
            } else if (is_array($where)) {
                foreach ($where as $field => $value) {
                    if (is_array($value) && strtolower($value[0]) == 'like') {
                        $sql .= " AND " . $field . " LIKE '" . $value[1] . "'";
                    } else if (strtolower($field) == '_string') {
                        $sql .= " AND " . $value;
                    } else if (is_array($value)) {
                        $sql .= " AND " . $field . " " . $value[0] . " '" . $value[1] . "'";
                    } else if (is_string($value)) {
                        $sql .= " AND " . $field . " = '" . $value . "'";
                    }
                }
            }
        }
        $sql .= " ORDER BY " . $order_by;
        if ($limit > 0) {
            $sql .= " LIMIT " . $offset . ", " . $limit;
        }
        $teams = $this->db->query($sql);
        return !empty($teams) ? $teams : array();
    }

    public function getDrpTeamCount($where)
    {
        $sql = "SELECT COUNT(dt.pigcms_id) AS team_count FROM " . option('system.DB_PREFIX') . "drp_team dt, " . option('system.DB_PREFIX') . "store s WHERE dt.store_id = s.store_id";
        if (!empty($where)) {
            if (is_string($where)) {
                $sql .= " AND " . $where;
            } else if (is_array($where)) {
                foreach ($where as $field => $value) {
                    if (is_array($value) && strtolower($value[0]) == 'like') {
                        $sql .= " AND " . $field . " LIKE '" . $value[1] . "'";
                    } else if (strtolower($field) == '_string') {
                        $sql .= " AND " . $value;
                    } else if (is_array($value)) {
                        $sql .= " AND " . $field . " " . $value[0] . " '" . $value[1] . "'";
                    } else if (is_string($value)) {
                        $sql .= " AND " . $field . " = '" . $value . "'";
                    }
                }
            }
        }
        $teams = $this->db->query($sql);
        return !empty($teams[0]['team_count']) ? $teams[0]['team_count'] : 0;
    }

    public function getDrpTeam($where)
    {
        $drp_team = $this->db->where($where)->find();
        return !empty($drp_team) ? $drp_team : array();
    }

    //检测分销团队是否可用
    public function checkDrpTeam($store_id = 0, $return = false)
    {
        $open_drp_team_platform = option('config.open_drp_team');
        $flag = true;
        if (empty($open_drp_team_platform)) { //平台未开分销团队
            $flag = false;
        } else if (!empty($store_id)) {
            $store = D('Store')->where(array('store_id' => $store_id))->find();
            if (isset($store['root_supplier_id']) && !empty($store['root_supplier_id'])) {
                $supplier_id = $store['root_supplier_id'];
            } else if (empty($store['root_supplier_id']) && !empty($store['drp_supplier_id'])) {
                $supply_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $store_id, 'type' => 1))->find();
                if (!empty($supply_chain['supply_chain'])) {
                    $chain = explode(',', $supply_chain['supply_chain']);
                    $supplier_id = !empty($chain[1]) ? $chain[1] : $store_id;
                }
            } else {
                $supplier_id = $store_id;
            }
            if ($supplier_id != $store_id) {
                $supplier = D('Store')->field('open_drp_team')->where(array('store_id' => $supplier_id))->find();
            } else {
                $supplier = $store;
            }

            if (empty($supplier['open_drp_team'])) {
                $flag = false;
            }
        }

        if ($return) {
            return $flag;
        } else {
            if (!$flag) {
                pigcms_tips('分销团队不可用');
            }
        }
    }

    //检测分销团队所有者
    public function checkDrpTeamOwner($seller_id, $return = false)
    {
        $drp_team_owner = D('Store')->where(array('store_id' => $seller_id, 'drp_level' => 1))->count('store_id');
        $flag = true;
        if (empty($drp_team_owner)) {
            $flag = false;
        }

        if ($return) {
            return $flag;
        } else {
            if (!$flag) {
                pigcms_tips('无权限设置分销团队');
            }
        }
    }

    //检测分销团队名称唯一性
    public function checkUniqueName($where)
    {
        $name_exists = $this->db->where($where)->count('pigcms_id');
        return $name_exists;
    }

    //设置团队成员
    public function setMembers($team_id, $setInc = true)
    {
        $team = $this->getDrpTeam(array('pigcms_id' => $team_id));
        $new_members_count = 0;
        if (!empty($team)) {
            //团队所有者id
            $store_id = $team['store_id'];
            $sql = "SELECT seller_id FROM " . option('system.DB_PREFIX') . "store_supplier WHERE FIND_IN_SET(" . $store_id . ", supply_chain) AND type = 1";
            $members = $this->db->query($sql);
            if (!empty($members)) {
                foreach ($members as $member) {
                    if (D('Store')->where(array('store_id' => $member['seller_id'], 'drp_team_id' => array('!=', $team['pigcms_id'])))->data(array('drp_team_id' => $team['pigcms_id']))->save()) {
                        $new_members_count++;
                    }
                }
            }

            //更新成员人数统计
            if ($new_members_count > 0 && $setInc) {
                $this->db->where(array('pigcms_id' => $team_id))->setInc('members', $new_members_count);
            }
        }
        return $new_members_count;
    }

    //团队成员列表/排名
    public function getMembers($where, $order_by = 'store_id DESC', $offset = 0, $limit = 20)
    {
        $members = D('Store')->where($where)->order($order_by)->limit($offset . ',' . $limit)->select();
        return !empty($members) ? $members : array();
    }

    //团队成员总数
    public function getMemberCount($where)
    {
        $member_count = D('Store')->where($where)->count('store_id');
        return !empty($member_count) ? $member_count : 0;
    }

    //成员数累加
    public function setMembersInc($team_id, $members = 1)
    {
        return $this->db->where(array('pigcms_id' => $team_id))->setInc('members', $members);
    }

    //获取团队排名（参考对象：同一供货商下其它团队）,支持销售额sales,成员数members排名，默认排名第一
    public function getTeamRank($team_id, $rank_field = 'sales')
    {
        $rank = 0;
        $rank_fields = array('sales', 'members');
        if (!in_array($rank_field, $rank_fields)) {
            return $rank;
        }
        $team = $this->getDrpTeam(array('pigcms_id' => $team_id));
        if (!empty($team) && isset($team[$rank_field]) && $team[$rank_field] > 0) {
            $rank_value = $team[$rank_field];
            $where = array();
            $where['supplier_id'] = $team['supplier_id']; //同一供货商
            $where[$rank_field] = array('>', $rank_value);
            $rank = $this->db->distinct($rank_field)->where($where)->count($rank_field);
            $rank = !empty($rank) ? $rank : 0;
            $rank++;
        }
        return !empty($rank) ? $rank : 1;
    }

    //获取成员排名（参考对象：同一团队下其它成员）,仅支持销售额排名 sales, 非正常成员不参与排名 status = 1, 返回0 未达排名标准
    public function getMemberRank($member_id)
    {
        $rank = 0;
        $member = D('Store')->field('sales,drp_team_id')->where(array('store_id' => $member_id))->find();
        if (!empty($member) && !empty($member['drp_team_id']) && $member['sales'] > 0) {
            $drp_team_id = $member['drp_team_id'];
            $sales  = $member['sales'];
            $where = array();
            $where['drp_team_id'] = $drp_team_id;
            $where['status'] = 1;
            $where['sales'] = array('>', $sales);
            $rank = D('Store')->distinct('sales')->where($where)->count('sales');
            $rank = !empty($rank) ? $rank : 0;
            $rank++;
        }
        return $rank;
    }

    //指定分销级别下的成员
    public function getMembersByLevel($seller_id, $sub_level, $offset = 0, $limit = 20, $order_by = 'sales DESC')
    {
        $sql = "SELECT *,s.store_id,s.name,s.logo,s.date_added,s.drp_level,s.sales FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND ((ss.type = 1 AND FIND_IN_SET(" . $seller_id . ", ss.supply_chain))";
        if($sub_level){
            $sql .= " AND s.drp_level = '" . $sub_level ."')";
        } else {
            $sql .= " OR s.store_id = '" . $seller_id . "')";
        }

        if (!empty($order_by)) {
            $sql .= " ORDER BY " . $order_by;
        }
        if ($limit > 0) {
            $sql .= " LIMIT " . $offset . "," . $limit;
        }

        $members = $this->db->query($sql);
        return !empty($members) ? $members : array();
    }

    //指定分销级别下的成员总数、总销售额、总订单数
    public function getMemberCountByLevel($seller_id, $sub_level, $return_sales = false, $return_orders = false)
    {
        $fields = "COUNT(s.store_id) AS member_count";
        if ($return_sales) {
            $fields .= ",SUM(sales) AS sales";
        }
        if ($return_orders) {
            $fields .= ",SUM(orders) AS orders";
        }
        $sql = "SELECT " . $fields . " FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND ss.type = 1 AND FIND_IN_SET(" . $seller_id . ", ss.supply_chain) AND s.drp_level = '" . $sub_level ."'";

        $members = $this->db->query($sql);

        if ($return_sales && $return_orders) {
            return array(
                'member_count' => !empty($members[0]['member_count']) ? $members[0]['member_count'] : 0,
                'sales' => !empty($members[0]['sales']) ? $members[0]['sales'] : 0,
                'orders' => !empty($members[0]['orders']) ? $members[0]['orders'] : 0,
            );
        } else if ($return_sales) {
            return array(
                'member_count' => !empty($members[0]['member_count']) ? $members[0]['member_count'] : 0,
                'sales' => !empty($members[0]['sales']) ? $members[0]['sales'] : 0,
            );
        } else if ($return_orders) {
            return array(
                'member_count' => !empty($members[0]['member_count']) ? $members[0]['member_count'] : 0,
                'orders' => !empty($members[0]['orders']) ? $members[0]['orders'] : 0,
            );
        } else {
            return !empty($members[0]['member_count']) ? $members[0]['member_count'] : 0;
        }
    }

    //销售额累加
    public function setSalesInc($team_id, $sales)
    {
        return $this->db->where(array('pigcms_id' => $team_id))->setInc('sales', $sales);
    }

    //销售额递减
    public function setSalesDec($team_id, $sales)
    {
        $team = $this->getDrpTeam(array('pigcms_id' => $team_id));
        if (!empty($team) && $team['sales'] >= $sales) {
            return $this->db->where(array('pigcms_id' => $team_id))->setDec('sales', $sales);
        }
        return false;
    }
}