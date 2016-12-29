<?php
/**
 * 账务记录数据模型
 * User: pigcms_21
 * Date: 2015/3/13
 * Time: 10:57
 */

class financial_record_model extends base_model
{

    //收入统计
    public function getTotal($where)
    {
        $income = $this->db->where($where)->sum('income');
        return !empty($income) ? $income : 0;
    }

    public function getRecords($where, $offset, $limit)
    {
        return $this->db->field('*,CONCAT("' . option('config.orderid_prefix') . '", order_no) AS order_no')->where($where)->order('pigcms_id DESC')->limit($offset . ',' . $limit)->select();
    }

    public function getRecordCount($where)
    {
        return $this->db->where($where)->count('pigcms_id');
    }

    public function getRecordTypes($key = null)
    {
        $types =  array(
            1 => '订单入账',
            2 => '提现',
            3 => '退款',
            4 => '系统退款',
            5 => '分销',
            6 => '批发'
        );
        if (!is_null($key) && !empty($types[$key])) {
            return $types[$key];
        } else {
            return $types;
        }
    }

    public function setStatus($store_id, $order_id, $status)
    {
        return $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->data(array('status' => $status))->save();
    }

    public function editStatus($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }


    public function getRecordsByType($store_id, $type, $offset, $limit, $order = 'fr.pigcms_id DESC')
    {
        $sql = "SELECT fr.*,fo.total,(fo.total + fr.income) AS commission FROM " . option('system.DB_PREFIX') . "financial_record fr, " . option('system.DB_PREFIX') . "fx_order fo WHERE fr.order_id = fo.order_id AND fr.store_id = '" . $store_id . "' AND fr.type = '" . $type . "' AND fr.income < 0";
        $sql .= ' ORDER BY ' . $order;
        $sql .= ' LIMIT ' . $offset . ',' . $limit;
        return $this->db->query($sql);
    }

    public function getProfitRecords($where, $offset, $limit, $order = 'pigcms_id DESC')
    {
        $where['profit'] = array('>', 0);
        $profit_records = $this->db->where($where)->order($order)->limit($offset . ',' . $limit)->select();
        return $profit_records;
    }

    public function getProfitRecordCount($where)
    {
        //$where['profit'] = array('>', 0);
        return $this->db->where($where)->count('pigcms_id');
    }

    /*public function getRecordsByType($store_id, $type, $offset, $limit, $order = 'pigcms_id DESC')
    {
        $sql = "SELECT order_id, sum(income) AS commission,add_time FROM " . option('system.DB_PREFIX') . "financial_record WHERE store_id = '" . $store_id . "' AND type = 5";
        //$sql .= 'ORDER BY ' . $order;
        $sql .= ' GROUP BY order_id';
        $sql .= ' LIMIT ' . $offset . ',' . $limit;
        return $this->db->query($sql);
    }*/


    public function getRecordCountByType($store_id, $type)
    {
        $sql = "SELECT COUNT(fr.pigcms_id) AS count FROM " . option('system.DB_PREFIX') . "financial_record fr, " . option('system.DB_PREFIX') . "fx_order fo WHERE fr.order_id = fo.order_id AND fr.store_id = '" . $store_id . "' AND fr.type = '" . $type . "'  AND fr.income < 0";
        $result = $this->db->query($sql);
        return !empty($result[0]['count']) ? $result[0]['count'] : 0;
    }

    /*public function getOrderIncome($user_order_id)
    {
        $sql = "SELECT store_id, SUM(income) AS income, order_id, SUM(profit) AS profit FROM " . option('system.DB_PREFIX') . "financial_record WHERE user_order_id = '" . $user_order_id . "' GROUP BY store_id";
        $incomes = $this->db->query($sql);
        return $incomes;
    }*/

    //分销利润
    public function drpProfit($where)
    {
        $profit = $this->db->where($where)->sum('income');
        return !empty($profit) ? $profit : 0;
    }
    
	public function snsCount($where) {
		$where['profit'] = array('>', 0);
		
		$count = $this->db->where($where)->count('1');
		return $count;
	}
	
	// sns
	public function sns($where = array(), $limit = 5, $offset = 0) {
		$db_prefix = option('system.DB_PREFIX');
		$sql = "SELECT fr.add_time, fr.profit, s.* FROM " . $db_prefix . "financial_record AS fr, " . $db_prefix . "store AS s WHERE s.store_id = fr.store_id AND fr.profit > 0";
		if (!empty($where)) {
			foreach ($where as $key => $tmp) {
				$sql .= " AND fr." . $key;
				if (is_array($tmp)) {
					$sql .= $tmp[0] . "'" . $tmp[1] . "'";
				} else {
					$sql .= " = '" . $tmp . "'";
				}
			}
		}
		$sql .= " ORDER BY fr.pigcms_id DESC LIMIT " . $offset . "," . $limit;
		$financial_list = $this->db->query($sql);
		
		foreach ($financial_list as &$tmp) {
			if(empty($tmp['logo'])) {
				$tmp['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
			} else {
				$tmp['logo'] = getAttachmentUrl($tmp['logo']);
			}
		}
		
		return $financial_list;
	}

    public function getSellersRank($where, $offset = 0, $limit = 0, $startTime, $endTime)
    {
        if(!empty($startTime) && !empty($endTime))
        {
            $sql = "SELECT DISTINCT ss.profit,s.status,s.drp_approve,ss.income,s.logo,s.name,s.qq,s.service_qq,s.service_weixin,s.`service_tel`,s.store_id FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'financial_record ss WHERE s.store_id = ss.store_id and ss.income > 0 and ss.add_time >' .$startTime . ' and ss.add_time < '. $endTime;
        }
        else
        {
            $sql = "SELECT DISTINCT ss.profit,s.status,s.drp_approve,ss.income,s.logo,s.name,s.qq,s.service_qq,s.service_weixin,s.`service_tel`,s.store_id FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'financial_record ss WHERE s.store_id = ss.store_id and ss.income > 0';
        }
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                } else {
                    $sql .= " AND " . $key . "=" . $value;
                }
            }
        }

        $sql .= ' ORDER BY ss.income DESC';

        if ($limit) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }

        $ranks = $this->db->query($sql);
        return $ranks;
    }


    public function seller_rank_count($where, $startTime, $endTime)
    {
        if(!empty($startTime) && !empty($endTime))
        {
            $sql = "SELECT count(distinct  ss.store_id) as storeId FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'financial_record ss WHERE s.store_id = ss.store_id and ss.income > 0 and ss.add_time >' .$startTime . ' and ss.add_time < '. $endTime;
        }
        else
        {
            $sql = "SELECT count(distinct  ss.store_id) as storeId FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'financial_record ss WHERE s.store_id = ss.store_id and ss.income > 0';
        }
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                } else {
                    $sql .= " AND " . $key . "=" . $value;
                }
            }
        }

        $sql .= ' ORDER BY ss.income DESC';

        $ranks = $this->db->query($sql);

        return !empty($ranks[0]['storeId']) ? $ranks[0]['storeId'] : 0;
    }

    /**
     * 订单入账
     * @param $order_id
     * @return int
     */
    public function getOrderIncome($order_id)
    {
        $financial = $this->db->field('income')->where(array('order_id' => $order_id, 'status' => 1, 'income' => array('>', 0)))->find();
        return !empty($financial['income']) ? $financial['income'] : 0;
    }

    /**
     * 订单入账(加)
     * @param $order_id
     * @param $income
     */
    public function setOrderIncomeInc($order_id, $income)
    {
        return $this->db->where(array('order_id' => $order_id, 'status' => 1, 'income' => array('>', 0)))->setInc('income', $income);
    }

    /**
     * 订单入账(减)
     * @param $order_id
     * @param $income
     */
    public function setOrderIncomeDec($order_id, $income)
    {
        return $this->db->where(array('order_id' => $order_id, 'status' => 1, 'income' => array('>', 0)))->setDec('income', $income);
    }

    /**
     * 订单利润（分销）
     * @param $order_id
     * @return int
     */
    public function getOrderProfit($order_id, $status = array(1,2,3))
    {
        /*$financial = $this->db->field('profit')->where(array('order_id' => $order_id, 'status' => array('in', array(1,3)), 'income' => array('>', 0)))->find();
        return !empty($financial['profit']) ? $financial['profit'] : 0;*/
        $profit = $this->db->where(array('order_id' => $order_id, 'status' => array('in', $status)))->sum('income');
        return !empty($profit) ? $profit : 0;
    }

    public function getGrossProfit($where)
    {
        $profit = $this->db->where($where)->sum('profit');
        return !empty($profit) ? $profit : 0;
    }
}