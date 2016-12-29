<?php
/**
 * 分销订单数据模型
 * User: pigcms_21
 * Date: 2015/4/8
 * Time: 17:30
 */

class fx_order_model extends base_model
{
    public function add($data)
    {
        return $this->db->data($data)->add();
    }

    public function edit($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }

    public function getOrderCount($where)
    {
        return $this->db->where($where)->count('fx_order_id');
    }

    public function getOrder($store_id, $order_id)
    {
        $order = $this->db->where(array('fx_order_id' => $order_id))->find();

        return $order;
    }

    public function getSupplierOrder($store_id, $order_id)
    {
        $order = $this->db->where(array('fx_order_id' => $order_id, 'supplier_id' => $store_id))->find();
        return $order;
    }

    public function getSellerOrder($store_id, $order_id)
    {
        $order = $this->db->where(array('order_id' => $order_id, 'store_id' => $store_id))->find();
        return $order;
    }

    public function getOrders($where, $offset = 0, $limit = 0)
    {
        if ($limit) {
            $orders = $this->db->where($where)->limit($offset . ',' . $limit)->order('fx_order_id DESC')->select();
        } else {
            $orders = $this->db->where($where)->order('fx_order_id DESC')->select();
        }
        return $orders;
    }

    public function getNextOrders($where, $offset = 0, $limit = 0)
    {
        $sql = "SELECT * FROM " . option('system.DB_PREFIX') . 'fx_order WHERE 1=1';
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                } else {
                    $sql .= " AND " . $key . "=" ."'". $value ."'";
                }
            }
        }

        $sql .= ' ORDER BY fx_order_id DESC';

        if ($limit) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }
        $sellers = $this->db->query($sql);

        return $sellers;
    }

    /* 获取主订单 */
    public function getOrderNos($where, $offset = 0, $limit = 0)
    {
        $sql = "SELECT * FROM " . option('system.DB_PREFIX') . 'order WHERE 1=1';
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    } else{
                        $sql .=" AND " .$key . "$value[0]" . "'" . $value[1] . "'";
                    }
                }else if($key == '_string'){
                    $sql .= "AND " . $value;
                }else if($key != '_string'){
                    $sql .= " AND " . $key . "=" . "'".$value."'";
                }
            }
        }

        $sql .= ' ORDER BY fx_order_id DESC';
        if ($limit) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }

        if ($orderby) {
            $sql .= ' ORDER BY ' . $orderby;
        }

        $ordersList = $this->db->query($sql);

        return $ordersList;
    }

    /* 获取主订单数量 */
    public function getOrderNoCount($where)
    {
        $sql = "SELECT count('fx_order_id') as fxOrderId FROM " . option('system.DB_PREFIX') . "order WHERE 1=1";
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    } else{
                        $sql .=" AND " .$key . "$value[0]" . "'" . $value[1] . "'";
                    }
                }else if($key == '_string'){
                    $sql .= "AND " . $value;
                }else if($key != '_string'){
                    $sql .= " AND " . $key . "=" . "'".$value."'";
                }
            }
        }
        $ordersCount = $this->db->query($sql);
        return !empty($ordersCount[0]['fxOrderId']) ? $ordersCount[0]['fxOrderId'] : 0;
    }


    public function getOrderscount($where)
    {
        $sql = "SELECT count(store_id) AS storeId FROM " . option('system.DB_PREFIX') . "order where 1=1";
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
        $sellers = $this->db->query($sql);
        return !empty($sellers[0]['storeId']) ? $sellers[0]['storeId'] : 0;
    }

    public function status($key = 0)
    {
        $status = array(
            1 => '待付款',
            2 => '待供货商发货',
            3 => '供货商已发货',
            4 => '已完成',
            5 => '已关闭'
        );
        if (!empty($key)) {
            return $status[$key];
        } else {
            return $status;
        }
    }

    public function status_text($key = 0)
    {
        $status = array(
            0 => '买家已付款',
            1 => '等待分销商付款',
            2 => '等待供货商发货',
            3 => '供货商已发货',
            4 => '订单已完成',
            5 => '订单已取消'
        );
        if (!empty($key)) {
            return $status[$key];
        } else {
            return $status;
        }
    }

    public function setPackaged($fx_order_id)
    {
        return $this->db->where(array('fx_order_id' => $fx_order_id))->data(array('status' => 3, 'supplier_sent_time' => time()))->save();
    }

    public function getOrderById($fx_order_id)
    {
        $order = $this->db->field('order_id,store_id')->where(array('fx_order_id' => $fx_order_id))->find();
        return $order;
    }

    public function setStatus($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }

    //销售额
    public function getSales($where)
    {
        $sales = $this->db->where($where)->sum('total');
        return $sales;
    }


    //截至今日的分销量
    public function getTodayOrders($where, $time)
    {
        $sql = "SELECT quantity, total FROM " . option('system.DB_PREFIX') . 'fx_order WHERE' . " add_time < $time";
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

        $sql .= ' ORDER BY fx_order_id DESC';

        $sellers = $this->db->query($sql);

        return $sellers;
    }
}
