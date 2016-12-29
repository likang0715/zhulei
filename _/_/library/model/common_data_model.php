<?php
/**
 * 公用数据
 * User: pigcms_21
 * Date: 2015/7/4
 * Time: 15:24
 */

class common_data_model extends base_model
{
    //设置店铺数
    public function setStoreQty($qty = 1)
    {
        if ($qty > 0) {
            return $this->db->where(array('key' => 'store_qty'))->setInc('value', $qty);
        } else {
            return $this->db->where(array('key' => 'store_qty'))->setDec('value', $qty);
        }
    }

    //获取店铺数
    public function getStoreQty()
    {
        $data = $this->db->where(array('key' => 'store_qty'))->find();
        return !empty($data['value']) && $data['value'] > 0 ? $data['value'] : 0;
    }

    //设置分销商数
    public function setDrpSellerQty($qty = 1)
    {
        if ($qty > 0) {
            return $this->db->where(array('key' => 'drp_seller_qty'))->setInc('value', $qty);
        } else {
            return $this->db->where(array('key' => 'drp_seller_qty'))->setDec('value', abs($qty));
        }
    }

    //获取分销商数
    public function getDrpSellerQty()
    {
        $data = $this->db->where(array('key' => 'drp_seller_qty'))->find();
        return !empty($data['value']) && $data['value'] > 0 ? $data['value'] : 0;
    }

    //设置商品数
    public function setProductQty($qty = 1)
    {
        if ($qty > 0) {
            return $this->db->where(array('key' => 'product_qty'))->setInc('value', $qty);
        } else {
            return $this->db->where(array('key' => 'product_qty'))->setDec('value', abs($qty));
        }
    }

    //获取商品数
    public function getProductQty()
    {
        $data = $this->db->where(array('key' => 'product_qty'))->find();
        return !empty($data['value']) && $data['value'] > 0 ? $data['value'] : 0;
    }

    //设置平台入账
    public function setData($key, $value)
    {
        $data = $this->db->field('pigcms_id,value')->where(array("key" => "$key"))->find();
        $tmp_value = !empty($data['value']) ? $data['value'] : 0;
        if ($value != 0) {
            $value = $tmp_value + $value;
            $value = number_format($value, 2, '.', '');
            $this->db->where(array('pigcms_id' => $data['pigcms_id']))->data(array('value' => $value))->save();
        }
    }

    public function getData($key)
    {
        $data = $this->db->field('value')->where(array("key" => "$key"))->find();
        return !empty($data['value']) ? $data['value'] : 0;
    }

    //设置保证金余额
    public function setMargin($margin)
    {
        if ($margin > 0) {
            return $this->db->where(array('key' => 'margin'))->setInc('value', $margin);
        } else {
            return $this->db->where(array('key' => 'margin'))->setDec('value', abs($margin));
        }
    }

    //设置推广奖励金额
    public function setPromotionReward($reward)
    {
        if ($reward > 0) {
            return $this->db->where(array('key' => 'promotion_reward'))->setInc('value', $reward);
        } else {
            return $this->db->where(array('key' => 'promotion_reward'))->setDec('value', abs($reward));
        }
    }
} 