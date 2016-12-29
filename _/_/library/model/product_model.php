<?php

/**
 * 商品数据模型
 * User: pigcms_21
 * Date: 2015/2/9
 * Time: 13:15
 */
class product_model extends base_model
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

    // 优质分销商品
    public function getExcellentFx($offset = 0, $limit = 10)
    {
        $where = array(
            'status' => 1,
            'is_fx' => 1,
            'source_product_id' => 0,
            'wholesale_product_id' => 0,
            'public_display'=>1
        );
        $order = "is_hot desc,drp_profit desc";
        $fxlist = $this->db->where($where)->order($order)->limit($offset . ',' . $limit)->select();
        foreach ($fxlist as &$v) {
            $v ['image'] = getAttachmentUrl($v ['image']);
            $v ['link'] = url_rewrite('goods:index', array(
                'id' => $v ['product_id']
            ));
            $v ['wx_image'] = option('config.site_url') . '/source/qrcode.php?type=good&id=' . $v ['product_id'];
            $v['fx_lirun_1'] = round($v['drp_level_1_price']-$v['drp_level_1_cost_price'],2);
            $v['fx_lirun_3'] = round($v['drp_level_3_price']-$v['drp_level_3_cost_price'],2);
            if($v['fx_lirun_1'] > $v['fx_lirun_3']) {
                $v['fx_lirun'] = $v['fx_lirun_3'].'~'.$v['fx_lirun_1'];
            } else {
                $v['fx_lirun'] = $v['fx_lirun_1'].'~'.$v['fx_lirun_3'];
            }
        }
        return $fxlist;
    }

    // 优质分销商品(新版)
    public function getExcellentFx_new($offset = 0, $limit = 10) {
        
        $order = "p.is_hot desc,p.drp_profit desc";
        $where = "p.status=1 and p.is_fx=1 and p.source_product_id=0 and p.wholesale_product_id=0 and p.public_display=1 and s.status=1 and s.public_display=1";

        $WebUserInfo = show_distance();
        $field = "p.*,sc.long,sc.lat,sc.city";
        
        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(option('config.lbs_distance_limit')) {
                //$this->db->field("`p`.*,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli");
                $field = "`p`.*,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli";
                $where = $where ." HAVING juli <=".option('config.lbs_distance_limit')*1000;
            }   

        } else if($WebUserInfo['city_name']) {
            $where .= " and sc.city=".$WebUserInfo['city_code'];
        }
        $fxlist = $this->db -> table("Product p")
                            -> join("Store s On p.store_id=s.store_id","LEFT")
                            -> join("Store_contact sc On sc.store_id=s.store_id","LEFT")
                            -> where($where)
                            -> field($field)
                            -> order($order)
                            -> limit($offset . ',' . $limit)
                            -> select();

        foreach ($fxlist as &$v) {
            $v ['image'] = getAttachmentUrl($v ['image']);
            $v ['link'] = url_rewrite('goods:index', array(
                    'id' => $v ['product_id']
            ));
            $v ['wx_image'] = option('config.site_url') . '/source/qrcode.php?type=good&id=' . $v ['product_id'];
            $v['fx_lirun_1'] = round($v['drp_level_1_price']-$v['drp_level_1_cost_price'],2);
            $v['fx_lirun_3'] = round($v['drp_level_3_price']-$v['drp_level_3_cost_price'],2);

            $v['fx_lirun_1'] = round($v['fx_lirun_1'], 2);
            $v['fx_lirun_3'] = round($v['fx_lirun_3'], 2);

            if($v['fx_lirun_1'] > $v['fx_lirun_3']) {
                $v['fx_lirun'] = $v['fx_lirun_3'].'~'.$v['fx_lirun_1'];
            } else {
                $v['fx_lirun'] = $v['fx_lirun_1'].'~'.$v['fx_lirun_3'];
            }
        }
        return $fxlist;
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

    public function getSelling_new($where, $order_by_field, $order_by_method, $offset="0", $limit="0", $is_show_distance = "") {
        if(is_array($where)) {
            $where = implode(" and ",$where);
        }
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order = "p.".$order_by_field . ' ' . strtoupper($order_by_method);
            if ($order_by_field == 'sort') {
                $order .= ', p.product_id DESC';
            }
        } else { // 默认排序
            $order = 'p.sort DESC, p.product_id DESC';
        }
        $field = "p.*,sc.long,sc.lat";
        
        $WebUserInfo = show_distance();
        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(option('config.lbs_distance_limit')) {
                $field = "`p`.*,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli";
                
                $where = $where ." HAVING juli <=".option('config.lbs_distance_limit')*1000;
            }   else {
                $where .= " and s.status=1 and p.quantity > 0 ";
            }   
        } else {
            if($WebUserInfo['city_name']) {
                if(!is_array($where)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {
                    $where[] = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                    $where = implode(" and ", $where);
                        
                }
            } else {
                $where .= " and s.status=1 and p.quantity > 0 ";
            }
        }
        

        if($limit){
            $this->db->limit($offset . ',' . $limit);
        }
        
        $products = $this-> db -> table("Product p")
                            -> join("Store s On p.store_id = s.store_id","LEFT")
                            -> join("Store_contact sc On sc.store_id = s.store_id", "LEFT")
                            -> field($field)
                            -> where($where)
                            -> order($order)
                            -> select();
        
        foreach ($products as &$tmp) {
            $tmp ['image'] = getAttachmentUrl($tmp ['image']);
            $tmp ['link'] = url_rewrite('goods:index', array(
                    'id' => $tmp ['product_id']
            ));
        }
        return $products;
    }

    public function getSellingCount_new($where, $is_show_distance = "") {
        if(is_array($where)) {
            $where = implode(" and ",$where);
        }
        $WebUserInfo = show_distance();
        $field = "count(p.product_id) as counts";
        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(option('config.lbs_distance_limit')) {
                $field = "count(p.product_id) as counts";
                $where = $where . " and ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) <".option('config.lbs_distance_limit')*1000;
                //$where = $where ." HAVING juli <=".option('config.lbs_distance_limit');
            } else {
                $where .= " and s.status=1 and p.quantity > 0 ";
            }
        } else {
            if(isset($WebUserInfo['city_name']) &&isset($WebUserInfo['area_name'])){
                if(!is_array($where)) {
                    $where1 = "sc.city='".$WebUserInfo['city_code']."' and sc.county='".$WebUserInfo['area_code']."'";
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {
                    $where[] = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."' and sc.county='".$WebUserInfo['area_code']."'";
                    $where = implode(" and ", $where);
                }
            } elseif ($WebUserInfo['city_name']) {
                if(!is_array($where)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {
                    $where[] = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                    $where = implode(" and ", $where);
                    
                }
            } else {
                $where .= " and s.status=1 and p.quantity > 0 ";
                //$where = implode(" and ", $where);
            }
        }
        
        $count = $this->db->table("Product p")
                      -> join("Store s On p.store_id = s.store_id","LEFT")
                      -> join("Store_contact sc On sc.store_id = s.store_id", "LEFT") 
                      -> where($where)
                      -> field($field)
                      -> find();
        
    
        return $count ['counts'];
    }

    /**
     * 批发市场详情页商品列表
     * @param $where
     * @param string $offset
     * @param string $limit
     * @param string $is_authen
     * @param string $store_id
     * @return mixed
     */

    public function getMarketProduct($where, $offset="0", $limit="0") {

        $sql = "select * from ".option('system.DB_PREFIX')."product where quantity>0 and status =1";

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

            $sql .= ' ORDER BY product_id DESC';

            if ($limit)  {
              $sql .= " limit {$offset}" .",". "{$limit} ";
            }
            $products = $this->db->query($sql);

            foreach ($products as &$tmp){
                $tmp ['image'] = getAttachmentUrl($tmp ['image']);
                $tmp ['link'] = url_rewrite('goods:index', array (
                    'id' => $tmp ['product_id']
                ));
            }

            return $products;
    }


    /**
     *  批发市场详情页商品数
     * @param $where
     * @param string $is_authen
     * @param string $store_id
     * @return int
     */

    public function getMarketTotal($where)
    {
        $sql = "select count(product_id) as product_id from ".option('system.DB_PREFIX')."product where quantity>0 and status =1";

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

        $products = $this->db->query($sql);

        return !empty($products[0]['product_id']) ? $products[0]['product_id'] : 0;
    }

    /* 获取批发商品 */
    public function getWholesale($where, $order_by_field, $order_by_method, $offset, $limit, $is_show_distance = "")
    {
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order = $order_by_field . ' ' . strtoupper($order_by_method);
            if ($order_by_field == 'sort') {
                $order .= ', product_id DESC';
            }
        } else { // 默认排序
            $order = 'sort DESC, product_id DESC';
        }

        /* 组装where条件获取仓库非仓库中的商品 */
        if (is_array($where)) {
            //$where ['status'] = array('<', 2);
        }
        $products = $this->db->field('*')->where($where)->order($order)->limit($offset . ',' . $limit)->select();

        foreach ($products as &$tmp) {
            $tmp ['image'] = getAttachmentUrl($tmp ['image']);
            $tmp ['link'] = url_rewrite('goods:index', array(
                'id' => $tmp ['product_id']
            ));
        }

        return $products;
    }

    // 根据距离降序 统计商铺的单商品个数
    public function getSellingBydistanceCount($where = "")
    {

        //不出现分销
        if (!is_array($where) || !$where) {
            $where = $where ? $where . " and " : "";
            $where = $where . "  p.supplier_id=0 and p.status=1 and p.is_recommend=1 and sc.long>0";
        }


        $count = $this->db->table("Product as p")
            ->join('Store as s ON s.store_id=p.store_id', 'LEFT')
            ->join('Store_contact as sc ON sc.store_id=p.store_id', 'LEFT')
            ->where($where)
            ->field("count(DISTINCT p.store_id) as counts")
            ->find();

        return $count ['counts'];
    }


    // 根据距离降序 统计商铺的单商品个数
    public function getSellingBydistanceCount_new($where = "")  {

        //不出现分销
        if (!is_array($where) || !$where) {
            $where = $where ? $where . " and " : "";
            $where = $where . "  p.supplier_id=0 and p.status=1  and sc.long>0";
        }
        $julis = "";
        $WebUserInfo = show_distance();

        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(option('config.lbs_distance_limit')) {
                $field = "count(p.product_id) as counts";
                if(is_array($where)) {
                    $where = implode(" and ",$where);
                } 
                $where = $where . " and ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) <".option('config.lbs_distance_limit')*1000;
            }
        } else {
            if($WebUserInfo['city_name']) {
                if(!is_array($where)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {
                    $where[] = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                    $where = implode(" and ", $where);
                    
                }
            } else {
                    if(is_array($where)) {
                        $where[] = " s.status=1 and p.quantity > 0 ";
                        $where = implode(" and ", $where);
                    } else {
                        $where .= " and s.status=1 and p.quantity > 0 ";;
                    }
                    
            }
        }
        
        $count = $this->db->table("Product as p")
            ->join('Store as s ON s.store_id=p.store_id', 'LEFT')
            ->join('Store_contact as sc ON sc.store_id=p.store_id', 'LEFT')
            ->where($where)
            ->field("count(DISTINCT p.store_id) as counts")
            ->find();

        return $count ['counts'];
    }
    
    /**
     * 根据距离 升降序商品
     * @param    $where string
     * @param    $orderbyfield 排序字段
     * @param    $orderbymethod 排序方式    ASC DESC
     * @param    $offset
     * @param    $limit
     * @param    $is_show_distance (0:不调取距离，1，调取距离，)
     * @return    array
     */
    public function getSellingBydistance($where = "", $order_by_field, $order_by_method, $offset, $limit, $is_show_distance = "")
    {
        $db_prefix = option('system.DB_PREFIX');
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order = $order_by_field . ' ' . strtoupper($order_by_method);
            if ($order_by_field == 'sort') {
                $order .= ', product_id DESC';
            }
        } else { // 默认排序
            $order = 'sort DESC, product_id DESC';
        }
        $julis = "";
        $WebUserInfo = show_distance();
        $long = $WebUserInfo ['long'];
        $lat = $WebUserInfo ['lat'];

        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(option('config.lbs_distance_limit')) {
                //$this->db->field("`p`.*,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli");
                $field = "count(p.product_id) as counts";
                if(is_array($where)) {
                    $where = implode(" and ",$where);
                } 
                
                $where = $where . " and ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) <".option('config.lbs_distance_limit')*1000;
                //$where = $where ." HAVING juli <=".option('config.lbs_distance_limit');
            }                   
        } else {
            if($WebUserInfo['city_name']) {
                if(!is_array($where)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {
                    $where[] = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                    $where = implode(" and ", $where);
                    
                }
            }
        }       

        //不出现分销
        if (is_array($where))
            $where = implode(" and ", $where);
        $where = $where ? ($where . "and") : "";
        $where = $where . "  p.supplier_id=0 and p.status=1 and p.is_recommend=1 and sc.long>0";


        $products = $this->db->table("Product as p")
            ->join('Store as s ON s.store_id=p.store_id', 'LEFT')
            ->join('Store_contact as sc ON sc.store_id=p.store_id', 'LEFT')
            ->field("`p`.*, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")
            //->where( "`sc`.`store_id`=`s`.`store_id` AND `s`.`status`='1' and `p`.`is_recommend` = 1 AND p.supplier_id = 0 and p.store_id = s.store_id" . $where )
            ->where($where)
            ->group('p.store_id')
            ->order("`juli` " . $order_by_method)
            ->limit($offset . ',' . $limit)
            ->select();


        foreach ($products as &$tmp) {
            $tmp ['image'] = getAttachmentUrl($tmp ['image']);
            $tmp ['link'] = url_rewrite('goods:index', array(
                'id' => $tmp ['product_id']
            ));
        }

        return $products;
    }
  
    /**
     * 根据距离 升降序商品
     * @param    $where string
     * @param    $orderbyfield 排序字段
     * @param    $orderbymethod 排序方式    ASC DESC
     * @param    $offset
     * @param    $limit
     * @param    $is_show_distance (0:不调取距离，1，调取距离，)
     * @return    array
     */
    public function getSellingBydistance_new($where = "", $order_by_field, $order_by_method, $offset, $limit, $is_show_distance = "") {
        $db_prefix = option('system.DB_PREFIX');
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order = $order_by_field . ' ' . strtoupper($order_by_method);
            if ($order_by_field == 'sort') {
                $order .= ', product_id DESC';
            }
        } else { // 默认排序
            $order = 'sort DESC, product_id DESC';
        }

        $julis = "";
        $WebUserInfo = show_distance();
    
        //不出现分销
        if (is_array($where)) {
            $where = implode(" and ", $where);
        }
        $where = $where ? ($where . "and") : "";
        $where = $where . " p.supplier_id=0 and p.status=1  and sc.long>0";

        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(is_array($where)) {
                $where = implode(" and ",$where);
            }
            if(option('config.lbs_distance_limit')) {
                $wheres = " HAVING juli <=".option('config.lbs_distance_limit')*1000;
            }                   
        } else {
            if($WebUserInfo['city_name']) {
                if(!is_array($where)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {
                    $where[] = " and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                    $where = implode(" and ", $where);
                    
                }
            } else {
                if(is_array($where)) {
                    $where[] = " s.status=1 and p.quantity > 0 ";
                    $where = implode(" and ", $where);
                } else {
                    $where .= " and s.status=1 and p.quantity > 0 ";;
                }
            }
        }   
        $where = $where." group by p.store_id";
        if($wheres) $where = $where.$wheres;
        $products = $this->db->table("Product as p")
                        ->join('Store as s ON s.store_id=p.store_id', 'LEFT')
                        ->join('Store_contact as sc ON sc.store_id=p.store_id', 'LEFT')
                        ->field("`p`.*, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli")
                        //->group('p.store_id')
                        ->where($where)
                        ->order("`juli` " . $order_by_method,",p.is_recommend desc")
                        ->limit($offset . ',' . $limit)
        ->select();

        foreach ($products as &$tmp) {
            $tmp ['image'] = getAttachmentUrl($tmp ['image']);
            $tmp ['link'] = url_rewrite('goods:index', array(
                    'id' => $tmp ['product_id']
            ));
        }

        return $products;
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
     * @return array
     */
    public function getSellingAndDistance($where, $order_by_field, $order_by_method, $offset, $limit) {
        $order = "";
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order[] = $order_by_field . ' ' . strtoupper($order_by_method);
        }
    
        $order[] = "p.product_id desc";
        $order = implode(",",$order);
    
        if (is_array($where)) {
            $where ['status'] = 1;
        } else {
            $where = $where . "  AND `s`.`status`='1' ";
        }
        // $products = D('')->table(array('Store_contact'=>'sc','Product'=>'p','Store'=>'s'))->field("p.*,`sc`.`long`,`sc`.`lat`")->where($where)->order($order)->limit($limit)->select();
        $products = array();
        $products = $this->db->table("Product as p")
        ->join('Store as s ON s.store_id=p.store_id', 'LEFT')
        ->join('Store_contact as sc ON sc.store_id=p.store_id', 'LEFT')
        ->field("p.*,`sc`.`long`,`sc`.`lat`")
        ->where($where)
        ->order($order)
        ->limit($limit)
        ->select();
    
    
        foreach ($products as &$tmp) {
            $tmp ['image'] = getAttachmentUrl($tmp ['image']);
            $tmp ['link'] = url_rewrite('goods:index', array(
                    'id' => $tmp ['product_id']
            ));
        }
    
        return $products;
    }
    /**
     *
     * @param $where
     * @param $orderbyfield 排序字段
     * @param $orderbymethod 排序方式 ASC DESC
     * @param $offset
     * @param $limit
     * @return array
     */
    public function getSellingAndDistance_new($where, $order_by_field, $order_by_method, $offset, $limit) { 
        $order = "";
        $field = "p.*,`sc`.`long`,`sc`.`lat`";
        
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order[] = $order_by_field . ' ' . strtoupper($order_by_method);
        } 
        $where1 = "p.is_present=0 and p.status = 1 and p.public_display=1 and p.quantity > 0 and 'p.supplier_id'=0 and p.public_display=1 and p.wholesale_product_id=0 and s.status='1' ";
        if($where) {
            $where = $where1 ." and ". $where;
        } else {
            $where = $where1;
        }
            
        $order[] = "p.product_id desc";
        $order = implode(",",$order);
        
        $WebUserInfo = show_distance();
        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(option('config.lbs_distance_limit')) {
                $field = "`p`.*,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli";
                $where = $where ." HAVING juli <=".option('config.lbs_distance_limit')*1000;
            } else {
                if(is_array($where)) {
                    $where = implode(" and ",$where);
                }
            }
        } else {
            if(isset($WebUserInfo['city_name']) &&isset($WebUserInfo['area_name'])){
                $where = $where. " and ". "sc.city='".$WebUserInfo['city_code']."' and sc.county='".$WebUserInfo['area_code']."'";
            }elseif($WebUserInfo['city_name']) {
                $where = $where. " and ". "sc.city=".$WebUserInfo['city_code'];
            }
        }
        
        $products = array();
        $products = $this->db->table("Product as p")
                        ->join('Store as s ON s.store_id=p.store_id', 'LEFT')
                        ->join('Store_contact as sc ON sc.store_id=p.store_id', 'LEFT')
                        ->field($field)
                        ->where($where)
                        ->order($order)
                        ->limit($limit)
                        ->select();

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
            $where ['quantity'] = array ('>', 0);
        }
         return $this->db->where($where)->order('product_id DESC')->count('product_id');
    }

    /**
     * 批发市场可批发商品数
     * @param $where
     * @return int
     */
    public function supplierMarketProductCount($where){
        $sql = "select count(product_id) as productId from ".option('system.DB_PREFIX')."product where status = 1";
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    } else {
                        $sql .= " AND " . $key ." $value[0] " . $value[1];
                    }
                } else {
                    $sql .= " AND " . $key . "=" .'"'. $value .'"';
                }
            }
        }
        $product_count = $this->db->query($sql);

        return !empty($product_count[0]['productId']) ? $product_count[0]['productId'] : 0;

    }

    /**
     * 批发市场可批发商品
     * @param $where
     * @param string $offset
     * @param string $limit
     * @return mixed
     */
    public function supplierMarketProducts($where, $offset="0", $limit="0"){
        $sql = "select * from ".option('system.DB_PREFIX')."product where status = 1";
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    } else {
                        $sql .= " AND " . $key ." $value[0] " . $value[1];
                    }
                } else {
                    $sql .= " AND " . $key . "=" .'"'. $value .'"';
                }
            }
        }

        $sql .= ' ORDER BY product_id DESC';

        if ($limit)  {
            $sql .= " limit {$offset}" .",". "{$limit} ";
        }
        $products = $this->db->query($sql);
        foreach ($products as &$tmp) {
            $tmp ['image'] = getAttachmentUrl($tmp ['image']);
            $tmp ['link'] = url_rewrite('goods:index', array(
                'id' => $tmp ['product_id']
            ));
        }

        return $products;
    }

    // 商品下架
    public function soldout($store_id, $product_ids)
    {
        if (!empty($product_ids) && !empty($store_id)) {
            $where = array();
            $where ['store_id'] = $store_id;
            $where ['product_id'] = array(
                'in',
                $product_ids
            );
            return $result = $this->db->where($where)->data(array(
                'status' => 0
            ))->save();
        }
    }

    // 商品上架
    public function putaway($store_id, $product_ids)
    {
        if (!empty($product_ids) && !empty($store_id)) {
            $where = array();
            $where ['store_id'] = $store_id;
            $where ['product_id'] = array(
                'in',
                $product_ids
            );
            return $result = $this->db->where($where)->data(array(
                'status' => 1
            ))->save();
        }
    }

    // 参与会员折扣
    public function allowDiscount($store_id, $discount, $product_ids)
    {
        if (!empty($product_ids) && !empty($store_id)) {
            $where = array();
            $where ['store_id'] = $store_id;
            $where ['product_id'] = array(
                'in',
                $product_ids
            );
            return $result = $this->db->where($where)->data(array(
                'allow_discount' => $discount
            ))->save();
        }
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

    public function getOne($productId, $fields = '*')
    {
        $sql = "select wholesale_product_id FROM pigcms_product where product_id = $productId";
        $product = $this->db->query($sql);
        if (empty($product)) {
            return array();
        }
        return $product;
    }

    // 已售罄的商品
    public function getStockout($where, $order_by_field, $order_by_method, $limit="0", $offset="0")
    {
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order = $order_by_field . ' ' . strtoupper($order_by_method);
            if ($order_by_field == 'sort') {
                $order .= ', product_id DESC';
            }
        } else { // 默认排序
            $order = 'sort DESC, product_id DESC';
        }
        $where ['quantity'] = array('<=', 0);
        $where ['status'] = 1;
        if($limit) $this->db->limit($limit . ',' . $offset);
        $products = $this->db->field('*')->where($where)->order($order)->select();

        foreach ($products as &$product) {
            $product ['image'] = getAttachmentUrl($product ['image']);
        }
        return $products;
    }
    
    // 已售罄的商品数量
    public function getStockoutTotal($where)
    {
        $where ['quantity'] = 0;
        $where ['status'] = 1;
        return $this->db->where($where)->count('product_id');
    }

    // 仓库中的商品
    public function getSoldout($where, $order_by_field, $order_by_method, $offset="0", $limit="0")
    {
        if (!empty($order_by_field) && !empty($order_by_method)) {
            $order = $order_by_field . ' ' . strtoupper($order_by_method);
            if ($order_by_field == 'sort') {
                $order .= ', product_id DESC';
            }
        } else { // 默认排序
            $order = 'sort DESC, product_id DESC';
        }
        $where ['status'] = 0;
        if($limit){
            $this->db->limit($offset . ',' . $limit);
        }

        $products = $this->db->field('*')->where($where)->order($order)->select();
        foreach ($products as &$product) {
            $product ['image'] = getAttachmentUrl($product ['image']);
        }
        return $products;
    }
    
    // 仓库中的商品数量
    public function getSoldoutTotal($where)
    {
        $where ['status'] = 0;
        return $this->db->where($where)->count('product_id');
    }

    // 店铺商品数量
    public function getTotalByStoreId($store_id)
    {
        $product_total = $this->db->where(array(
            'store_id' => $store_id,
            'status' => array(
                '<',
                2
            )
        ))->count('product_id');
        return $product_total;
    }

    /* 得到分组下的商品列表 */

    public function getGroupGoodList($group_id, $first_sort = '0', $second_sort = '0', $drp_level = '0')
    {
        switch ($first_sort) {
            case '0' :
                $order .= ' `p`.`sort` DESC';
                break;
            case '1' :
                $order .= ' `p`.`pv` DESC';
                break;
            default :
                $order .= ' `p`.`sort` DESC';
                break;
        }
        switch ($second_sort) {
            case '0' :
                $order .= ',`p`.`date_added` DESC';
                break;
            case '1' :
                $order .= ',`p`.`date_added` ASC';
            case '2' :
                if ($first_sort != '1') {
                    $order .= ',`p`.`pv` DESC';
                }

        }
        $database = D('');
        $product_list = $database->table(array(
            'Product_to_group' => 'ptg',
            'Product' => 'p'
        ))->where("`ptg`.`group_id`='$group_id' AND `ptg`.`product_id`=`p`.`product_id` AND `p`.`status` = 1 AND `p`.`quantity` > 0 AND p.store_id != '0'")->order($order)->select();

        foreach ($product_list as &$product) {
            $product ['image'] = getAttachmentUrl($product ['image']);
            
            if ($drp_level > 0 && $product['is_fx']) {
                if ($drp_level > 3) {
                    $drp_level = 3;
                }
            
                $product['price'] = $product['drp_level_' . $drp_level . '_price'];
            }
            
        }
        return $product_list;
    }

    /* 得到分组下指定数据的商品列表 */

    public function getGroupGoodNumberList($group_id, $number)
    {
        $database = D('');
        $product_list = $database->table(array(
            'Product_to_group' => 'ptg',
            'Product' => 'p'
        ))->where("`ptg`.`group_id`='$group_id' AND `ptg`.`product_id`=`p`.`product_id` AND `p`.status = 1 AND `p`.`quantity` > 0")->order('`p`.`product_id` DESC')->limit($number)->select();
        foreach ($product_list as &$product) {
            $product ['image'] = getAttachmentUrl($product ['image']);
        }
        return $product_list;
    }

    /* 得到搜索的商品列表 */

    public function getSearchGroupGoodList($key, $page, $store_id, $seller_id = 0, $drp_level = 0, $drp_diy_store = 1,$cat_id = 0)
    {
        $database_product = D('Product');
        $condition_product['store_id'] = $store_id;
        if($cat_id)  $condition_product['category_id'] = $cat_id;
        $condition_product ['name'] = array(
            'like',
            '%' . $key . '%'
        );
        $condition_product ['status'] = 1;
        $count = $database_product->where($condition_product)->count('product_id');
        $pageCount = ceil($count / 18);
        if ($page > $pageCount)
            $page = $pageCount;
        if ($count > 0) {
            $product_list = $database_product->where($condition_product)->order('`sort` DESC, `product_id` DESC')->limit((($page - 1) * 18) . ',18')->select();
            foreach ($product_list as &$value) {
                $value['image'] = getAttachmentUrl($value ['image']);
                if ($drp_level > 0 && $value['is_fx']) {
                    if ($drp_level > 3) {
                        $drp_level = 3;
                    }
                    $value['price'] = !empty($value['drp_level_' . $drp_level . '_price']) ? $value['drp_level_' . $drp_level . '_price'] : $value['price'];
                }
            }
            $return ['product_list'] = $product_list;

            $pageCount = ceil($count / 18);
            if ($pageCount > 1) {
                if ($page == 1) {
                    $pagebar = '<a href="javascript:void(0);" class="custom-paginations-prev disabled">上一页</a>';
                } else {
                    $ssid = ($seller_id > 0 && $drp_diy_store == 0) ? $seller_id : $store_id ;
                     $pagebar = '<a href="./search.php?store_id=' . $ssid. '&q=' . urlencode($key) . '&page=' . ($page - 1) . '" class="custom-paginations-prev">上一页</a>';
                }
                if ($page >= $pageCount) {
                    $pagebar .= '<a href="javascript:void(0);" class="custom-paginations-next disabled">下一页</a>';
                } else {
                    $ssid = ($seller_id > 0 && $drp_diy_store == 0) ? $seller_id : $store_id;
                    $pagebar .='<a href="./search.php?store_id=' . $ssid . '&q=' . urlencode($key) . '&page=' . ($page + 1) . '" class="custom-paginations-next">下一页</a>';
                }
                $return ['pagebar'] = $pagebar;
            }
            return $return;
        } else {
            return array();
        }
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

    public function fxEdit($product_id, $product)
    {
        $product_info = M('Product')->get(array(
            'product_id' => $product_id,
            'store_id' => $_SESSION ['store'] ['store_id']
        ));
        // 分销级别
        if (!empty($_SESSION ['store'] ['drp_level'])) {
            $drp_level = $_SESSION ['store'] ['drp_level'] + 1;
        } else {
            $drp_level = 1;
        }
        if (empty($product_info ['source_product_id']) && (!empty($product_info ['unified_price_setting']) || $_POST ['unified_price_setting'])) {
            $data = array(
                'drp_level_1_cost_price' => !empty($product ['drp_level_1_cost_price']) ? $product ['drp_level_1_cost_price'] : 0,
                'drp_level_2_cost_price' => !empty($product ['drp_level_2_cost_price']) ? $product ['drp_level_2_cost_price'] : 0,
                'drp_level_3_cost_price' => !empty($product ['drp_level_3_cost_price']) ? $product ['drp_level_3_cost_price'] : 0,
                'drp_level_1_price' => !empty($product ['drp_level_1_price']) ? $product ['drp_level_1_price'] : 0,
                'drp_level_2_price' => !empty($product ['drp_level_2_price']) ? $product ['drp_level_2_price'] : 0,
                'drp_level_3_price' => !empty($product ['drp_level_3_price']) ? $product ['drp_level_3_price'] : 0,
                'is_recommend' => $product ['is_recommend'],
                'is_fx' => $product ['is_fx'],
                'fx_type' => $product ['fx_type'],
                'is_fx_setting' => $product ['is_fx_setting'],
                'last_edit_time' => time(),
                'unified_price_setting' => $product ['unified_price_setting'],
                'unified_profit' => $product['unified_profit']
            );
            if (!empty($product ['drp_level_' . $drp_level . '_price'])) {
                $data ['min_fx_price'] = $product ['drp_level_' . $drp_level . '_price'];
                $data ['max_fx_price'] = $product ['drp_level_' . $drp_level . '_price'];
            } else {
                $data ['min_fx_price'] = !empty($product ['min_fx_price']) ? $product ['min_fx_price'] : 0;
                $data ['max_fx_price'] = !empty($product ['max_fx_price']) ? $product ['max_fx_price'] : 0;
            }
            if (!empty($product ['drp_level_' . $drp_level . '_cost_price'])) {
                $data ['cost_price'] = $product ['drp_level_' . $drp_level . '_cost_price'];
            } else {
                $data ['cost_price'] = !empty($product ['cost_price']) ? $product ['cost_price'] : 0;
            }
        } else if (!empty($product_info ['unified_price_setting'])) {
            $data = array(
                'unified_profit' => $data['unified_profit'],
                'is_recommend' => $product ['is_recommend'],
                'is_fx' => $product ['is_fx'],
                'fx_type' => $product ['fx_type'],
                'is_fx_setting' => $product ['is_fx_setting'],
                'last_edit_time' => time(),
                'min_fx_price' => $product_info ['drp_level_' . $drp_level . '_price'],
                'max_fx_price' => $product_info ['drp_level_' . $drp_level . '_price'],
                'cost_price' => $product_info ['drp_level_' . $drp_level . '_cost_price']
            );
        } else {
            $data = array(
                'unified_profit' => $product['unified_profit'],
                'is_recommend' => $product ['is_recommend'],
                'is_fx' => $product ['is_fx'],
                'fx_type' => $product ['fx_type'],
                'is_fx_setting' => $product ['is_fx_setting'],
                'last_edit_time' => time(),
                'min_fx_price' => !empty($product ['min_fx_price']) ? $product ['min_fx_price'] : 0,
                'max_fx_price' => !empty($product ['max_fx_price']) ? $product ['max_fx_price'] : 0,
                'cost_price' => !empty($product ['cost_price']) ? $product ['cost_price'] : 0
            );
        }
        return $this->db->where(array(
            'product_id' => $product_id
        ))->data($data)->save();
    }

    public function fxCancel($where)
    {
        return $this->db->where($where)->data(array(
            'is_fx' => 0,
            'is_fx_setting' => 0
        ))->save();
    }

    public function wholesaleCancel($where)
    {
        return $this->db->where($where)->data(array(
            'is_wholesale' => 0,
            'is_fx_setting' => 0
        ))->save();
    }

    // 商品浏览量统计
    public function analytics($where)
    {
        return $this->db->where($where)->setInc('pv', 1);
    }

    // 我分销的商品
    public function fxProducts($store_id, $offset = 0, $limit = 0)
    {
        if ($limit > 0) {
            $products = $this->db->where(array(
                'store_id' => $store_id,
                //'is_fx' => 1,
                'supplier_id' => array(
                    '>',
                    0
                ),
                'status' => array(
                    '<',
                    2
                )
            ))->limit($offset . ',' . $limit)->select();
        } else {
            $products = $this->db->where(array(
                'store_id' => $store_id,
                //'is_fx' => 1,
                'supplier_id' => array(
                    '>',
                    0
                ),
                'status' => array(
                    '<',
                    2
                )
            ))->select();
        }
        return $products;
    }

    // 可用的分销商品（不含删除状态）
    public function availableFxProducts($store_id, $offset = 0, $limit = 0)
    {
        if ($limit > 0) {
            $products = $this->db->where(array(
                'store_id' => $store_id,
                'status' => array(
                    '<',
                    2
                ),
                'supplier_id' => array(
                    '>',
                    0
                )
            ))->limit($offset . ',' . $limit)->select();
        } else {
            $products = $this->db->where(array(
                'store_id' => $store_id,
                'status' => array(
                    '<',
                    2
                ),
                'supplier_id' => array(
                    '>',
                    0
                )
            ))->select();
        }
        return $products;
    }

    public function fxProductCount($where)
    {
        return $this->db->where($where)->count('product_id');
    }

    // 供货商分销的商品
    public function supplierFxProducts($where, $offset = 0, $limit = 0)
    {
        if ($limit > 0) {
            $products = $this->db->where($where)->order('is_recommend DESC, product_id DESC')->order('product_id DESC')->limit($offset . ',' . $limit)->select();
        } else {
            $products = $this->db->where($where)->order('is_recommend DESC, product_id DESC')->order('product_id DESC')->select();
        }

        foreach ($products as &$product) {
            $product ['image'] = getAttachmentUrl($product ['image']);
        }
        return $products;
    }

    /**
     * 供货商设置分销商品数
     * @param $where
     * @return mixed
     */
    public function supplierFxProductCount($where)
    {
        return $this->db->where($where)->count('product_id');
    }

    public function getProducts($where)
    {
        $products = $this->db->where($where)->select();
        return $products;
    }

    public function delFxProduct($where)
    {
        return $this->db->where($where)->data(array(
            'status' => 2
        ))->save();
    }

    // 设置商品分销商数量
    public function setDrpSellerQty($product_id, $qty = 1)
    {
        return $this->db->where(array(
            'product_id' => $product_id
        ))->setInc('drp_seller_qty', $qty);
    }

    // 获取商品分销总利润
    public function getDrpProfit($product_id)
    {
        $profit = $this->db->field('drp_profit')->where(array(
            'product_id' => $product_id
        ))->find();
        return !empty($profit ['drp_profit']) ? $profit ['drp_profit'] : 0;
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

    
    
    /**
     * 折扣、优惠最多的商品
     * $type 类型 ZHEKOU、YOUHUI
     */
    public function getProductDiscountCount($type = 'ZHEKOU') {
        $where = array();
        $where['quantity'] = array('>', 0);
        $where['status'] = 1;
        $where['public_display'] = 1;
        $where['wholesale_product_id'] = 0;
        $where['price'] = array('<=', 'original_price');
        $where = "`quantity` > 0 AND `status` = 1 AND `public_display` = 1 AND `wholesale_product_id` = 0 AND `price` <= `original_price`";
        
        $count = $this->db->where($where)->count("product_id");
        return $count;
    }
    
    /**
     * 折扣、优惠最多的商品
     * $type 类型 ZHEKOU、YOUHUI
     */
    public function getProductDiscount($type = 'ZHEKOU', $offset = 0, $limit = 5) {
        $where = array();
        $where['quantity'] = array('>', 0);
        $where['status'] = 1;
        $where['public_display'] = 1;
        $where['wholesale_product_id'] = 0;
        $where['price'] = array('<=', 'original_price');
        $where = "`quantity` > 0 AND `status` = 1 AND `public_display` = 1 AND `wholesale_product_id` = 0 AND `price` <= `original_price`";
    
        $discount_str = '';
        if ($type == 'ZHEKOU') {
            $discount_str = ',(original_price - price) / original_price as discount';
        } else {
            $discount_str = ',(original_price - price) as discount';
        }
    
        $product_tmp_list = $this->db->where($where)->field("`product_id`, `store_id`, `name`, `quantity`, `price`, `original_price`, `weight`, `image`, `is_recommend`, `intro`" . $discount_str)->order('discount DESC')->limit($offset . ',' . $limit)->select();
        $product_list = array();
        foreach ($product_tmp_list as $product) {
            $product['image'] = getAttachmentUrl($product ['image']);
            $product['intro'] = mb_substr($product['intro'], 0, 50, 'utf-8');
            $product['pc_url'] = url_rewrite('goods:index', array('id' => $product['product_id']));
            $product['wap_url'] = '/wap/good.php?id=' . $product['product_id'] . '&store_id=' . $product['store_id'];
            $product['app_url'] = url('goods:index', array('id' => $product['product_id'], 'store_id' => $product['store_id']));
            $product_list[] = $product;
        }
    
        return $product_list;
    }
	
	/**
	 * 返回一个商品参与的活动
	 * param $product_id 产品ID
	 * param $is_list 是否返回参与活动列表，当false时，只要有参与活动，即返回true
	 */
	public function getActivity($product_id, $is_list = true) {
		$time = time();
		$activity_table_arr = array(
				'tuan' => array('Tuan', "product_id = '#' AND delete_flg = 0 AND status = 1 AND start_time <= '" . $time . "' AND end_time >= '" . $time . "'"),
				'presale' => array('Presale', "product_id = '#' AND is_open = 1 AND starttime <= '" . $time . "' AND endtime >= '" . $time . "'"),
				'bargain' => array('Bargain', "product_id = '#' AND delete_flag = 0 AND state = 1"),
				'seckill' => array('Seckill', "product_id = '# AND delete_flag = 0 AND status = 1' AND start_time <= '" . $time . "' AND end_time >= '" . $time . "'"),
				//'crowdfunding' => array('Zc_product', "product_id = '#' "),
				'unitary' => array('Unitary', "product_id = '#' AND state = 1"),
				'cutprice' => array('Cutprice', "product_id = '#' AND state = 1")
		);
		
		$activity_list = array();
		foreach ($activity_table_arr as $key => $activity_table) {
			if (!$is_list) {
				$count = D($activity_table[0])->where(str_replace('#', $product_id, $activity_table[1]))->count('*');
				
				if ($count > 0) {
					return true;
				}
			} else {
				$list = D($activity_table[0])->where(str_replace('#', $product_id, $activity_table[1]))->select();
				
				foreach ($list as $tmp) {
					$data = array();
					$data['type'] = $key;
					if ($key == 'tuan') {
						$data['pigcms_id'] = $tmp['id'];
						$data['name'] = $tmp['name'];
						$data['desc'] = $tmp['description'];
					} else if ($key == 'presale') {
						$data['pigcms_id'] = $tmp['id'];
						$data['name'] = $tmp['name'];
						$data['desc'] = $tmp['description'];
					} else if ($key == 'bargin') {
						$data['pigcms_id'] = $tmp['pigcms_id'];
						$data['name'] = $tmp['name'];
						$data['desc'] = $tmp['info'];
					} else if ($key == 'seckill') {
						$data['pigcms_id'] = $tmp['pigcms_id'];
						$data['name'] = $tmp['name'];
						$data['desc'] = $tmp['description'];
					} else if ($key == 'unitary') {
						$data['pigcms_id'] = $tmp['id'];
						$data['name'] = $tmp['name'];
						$data['desc'] = $tmp['descript'];
					} else if ($key == 'cutprice') {
						$data['pigcms_id'] = $tmp['pigcms_id'];
						$data['name'] = $tmp['active_name'];
						$data['desc'] = $tmp['info'];
					}
					
					$data['wap_url'] = activityUrl($data['pigcms_id'], $key, $tmp['store_id']);
					$activity_list[] = $data;
				}
			}
		}
		
		return $activity_list;
	}
	
	/**
	 * 返回一个商品参与的游戏
	 * param $product_id 产品ID
	 * param $is_list 是否返回参与活动列表，当false时，只要有参与活动，即返回true
	 */
	public function getGame($product_id, $is_list = true) {
		$time = time();
		$where = "l.status = 0 AND l.starttime < '" . $time . "' AND l.endtime >= '" . $time . "' AND lp.product_id = '" . $product_id . "'";
		
		if (!$is_list) {
			$count = D('Lottery AS l')->join('Lottery_prize AS lp ON l.id = lp.lottery_id')->where($where)->count('l.id');
			if ($count > 0) {
				return true;
			} else {
				$where = "s.status = 1 AND s.starttime < '" . $time . "' AND s.endtime >= '" . $time . "' AND sp.product_id = '" . $product_id . "'";
				$count = D('Shakelottery AS s')->join('Shakelottery_prize AS sp ON s.id = sp.aid')->where($where)->count('s.id');
				
				if ($count) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			$game_list = array();
			$lottery_type_arr = array('NO', 'DZHP', 'JGG', 'GGK', 'SHGJ', 'ZJD');
			$where = "l.status = 0 AND l.starttime < '" . $time . "' AND l.endtime >= '" . $time . "' AND lp.product_id = '" . $product_id . "'";
			$lottery_list = D('Lottery AS l')->join('Lottery_prize AS lp ON l.id = lp.lottery_id')->where($where)->field('DISTINCT l.*')->select();
			
			foreach ($lottery_list as $lottery) {
				$tmp = array();
				$tmp['pigcms_id'] = $lottery['id'];
				$tmp['name'] = $lottery['title'];
				$tmp['desc'] = $lottery['active_desc'];
				$tmp['wap_url'] = option('config.site_url') . '/wap/lottery.php?action=detail&id=' . $lottery['id'];
				$tmp['type'] = $lottery_type_arr[$lottery['type']];
				
				$game_list[] = $tmp;
			}
			
			$where = "s.status = 1 AND s.starttime < '" . $time . "' AND s.endtime >= '" . $time . "' AND sp.product_id = '" . $product_id . "'";
			$shakelottery_list = D('Shakelottery AS s')->join('Shakelottery_prize AS sp ON s.id = sp.aid')->where($where)->field('DISTINCT s.*')->select();
			foreach ($shakelottery_list as $shakelottery) {
				$tmp = array();
				$tmp['pigcms_id'] = $shakelottery['id'];
				$tmp['name'] = $shakelottery['action_name'];
				$tmp['desc'] = $shakelottery['action_desc'];
				$tmp['wap_url'] = option('config.site_url') . '/wap/shakelottery.php?id=' . $shakelottery['id'];
				$tmp['type'] = 'YYY';
				
				$game_list[] = $tmp;
			}
			
			return $game_list;
		}
	}
}
