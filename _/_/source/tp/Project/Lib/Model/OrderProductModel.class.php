<?php

/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/11/20
 * Time: 13:42
 */
class OrderProductModel extends Model
{
    public function getProducts($order_id) {
        $products = $this->query("SELECT p.is_wholesale,p.wholesale_price,p.drp_level_1_price,p.drp_level_2_price,p.drp_level_3_price, p.drp_level_1_cost_price,p.drp_level_2_cost_price,p.drp_level_3_cost_price, p.product_id,p.name,p.image,p.supplier_id,p.store_id,p.wholesale_product_id,op.pigcms_id,op.pro_num,op.pro_price,op.sku_id,op.sku_data,op.comment,op.is_packaged,op.in_package_status,op.is_fx,op.original_product_id,op.is_present,op.return_status,op.rights_status,op.profit FROM " . C('DB_PREFIX') . "order_product op, " . C('DB_PREFIX') . "product p WHERE op.product_id = p.product_id AND op.order_id = '" . $order_id . "'");
        return $products;
    }

    /**
     * 获取订单商品
     * @param $where
     */
    public function getProduct($order_product_id)
    {
        $products = $this->db->query("SELECT op.*,o.store_id FROM " . C('DB_PREFIX') . "order_product op, " . C('DB_PREFIX') . "order o WHERE op.order_id = o.order_id AND op.pigcms_id = '" . $order_product_id . "'");
        return !empty($products[0]) ? $products[0] : array();
    }
}