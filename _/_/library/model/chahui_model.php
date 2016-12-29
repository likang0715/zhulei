<?php

/**
 * 商品数据模型
 * User: pigcms_21
 * Date: 2015/2/9
 * Time: 13:15
 */
class chahui_model extends base_model
{

    public function add($data)
    {
        if (!empty($data ['image'])) {
            $data ['image'] = getAttachment($data ['image']);
        }
        $product_id = $this->db->data($data)->add();
        return $product_id;
    }

    public function edit($where, $data)
    {
        if (!empty($data ['image'])) {
            $data ['image'] = getAttachment($data ['image']);
        }
        return $this->db->where($where)->data($data)->save();
    }

   
   
   
   
   public function getlist($where=array(), $orderby="", $limit="10") {


        $store_list =  $this->db->where($where)->order($orderby)->limit($limit)->select();

        if(!empty($store_list)) {
            foreach($store_list as &$value){
                $value['url'] = option('config.wap_site_url').'/chahui_show.php?id='.$value['pigcms_id'].'&platform=1';
                $value['pcurl'] =  url_rewrite('chahui:chahui_show', array('id' => $value['pigcms_id']));

                if(empty($value['images'])) {
                    $value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $value['logo'] = getAttachmentUrl($value['images']);
                }

                //店铺二维码
                //本地化二维码$value['qcode'] = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
                $value['qcode'] = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];		//微信端临时二维码

                $value['wx_image'] =  $value['qcode'] ;

            }
        }

        return $store_list;
    }
  
    /**
     *
     * @param
     *            $where
     * @param $orderbyfield 排序字段
     * @param $orderbymethod 排序方式
     *            ASC DESC
     * @param
     *            $offset
     * @param
     *            $limit
     * @param $is_show_distance (0:
     *            不调取距离，1，调取距离，)
     * @return array
     */
    public function getSelling($where, $order_by_field, $order_by_method, $offset="0", $limit="0", $is_show_distance = "")
    {
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order = $order_by_field . ' ' . strtoupper($order_by_method);
            if ($order_by_field == 'sort') {
                $order .= ', product_id DESC';
            }
        } else { // 默认排序
            $order = 'sort DESC, product_id DESC';
        }

        if (is_array($where)) {
            $where ['status'] = 1;
            $where ['quantity'] = array('>',0);
        }
        if($limit){
            $this->db->limit($offset . ',' . $limit);
        }

        $products = $this->db->field('*')->where($where)->order($order)->select();

        foreach ($products as &$tmp) {
            $tmp ['image'] = getAttachmentUrl($tmp ['image']);
            $tmp ['link'] = url_rewrite('goods:index', array(
                'id' => $tmp ['product_id']
            ));
        }
        return $products;
    }

  

 
   
    // 出售中的商品数量
    public function getSellingTotal($where)
    {
        if (is_array($where)) {
            $where ['status'] = 1;
      
        }
         return $this->db->where($where)->order('product_id DESC')->count('product_id');
    }

    /**
     * 获取单个商品
     *
     * @param
     *            $where
     * @param string $fields
     */
    public function get($where, $fields = '*')
    {
        $product = $this->db->field($fields)->where($where)->find();

        if (empty($product)) {
            return array();
        }
        $product ['image'] = getAttachmentUrl($product ['image']);
        // $product['wx_image'] = option('config.site_url').'/source/qrcode.php?type=good&id='.$product['product_id'];
        return $product;
    }

    

   
  
    public function delete($store_id, $product_id)
    {
        $where = array();
        $where ['store_id'] = $store_id;
        if (is_array($product_id)) {
            $where ['product_id'] = array(
                'in',
                $product_id
            );
        } else {
            $where ['product_id'] = $product_id;
        }
        return $this->db->where($where)->data(array(
            'status' => 2
        ))->save();
    }

   
 
    // 商品浏览量统计
    public function analytics($where)
    {
        return $this->db->where($where)->setInc('pv', 1);
    }

 

    
    // 获取指定的商品
    public function getProduct($where, $order_by_field, $order_by_method, $limit="0", $offset="0")
    {
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order = $order_by_field . ' ' . strtoupper($order_by_method);
            if ($order_by_field == 'sort') {
                $order .= ', product_id DESC';
            }
        } else { // 默认排序
            $order = 'sort DESC, product_id DESC';
        }

        if($limit) $this->db->limit($limit . ',' . $offset);
        $products = $this->db->field('*')->where($where)->order($order)->select();
    
        foreach ($products as &$product) {
            $product ['image'] = getAttachmentUrl($product ['image']);
        }
        return $products;
    }


    
    // 获取指定的商品数量
    public function getProductTotal($where)
    {

        return $this->db->where($where)->count('product_id');
    }

    
   
	
	
}
