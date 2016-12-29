<?php
/**
 * 店铺模型
 * User: pigcms_21
 * Date: 2015/2/2
 * Time: 22:00
 */
class store_model extends base_model{
    //创建店铺
    public function create($data){
        if($store_id = $this->db->data($data)->add()){
            $data['store_id'] = $store_id;

            //
            $qid = "600000000";//场景起始id
            $qid = (int)$qid+(int)$store_id;

            /*
             * 加入店铺二维码进入本地
            //下载二维码图片 @simon
            $local_file = M('Recognition')->download_img_from_weixin($qid);

            $upyun_file = str_replace('./upload/' ,"", $local_file);
            // 上传到又拍云服务器
            $attachment_upload_type = option('config.attachment_upload_type');
            if ($attachment_upload_type == '1') {
                import('source.class.upload.upyunUser');

                upyunUser::upload($local_file, $upyun_file);
            }
            $datas['qcode'] = $upyun_file;
            */
            $datas = array();

            // 引入微信服务器端 临时二维码
            /*$qcode =  M('Recognition')->get_tmp_qrcode($qid);
            if($qcode['error_code']=='0') {
                $datas['qcode'] = $qcode['ticket'];
                $datas['qcode_starttime'] = time();
            }

            if(!empty($datas)){
                $this->db->where(array('store_id' => $store_id))->data($datas)->save();
            }*/


            return array('err_code' => 1,'err_msg' => $data);
        } else {
            return array('err_code' => 0,'err_msg' => '店铺创建失败');
        }
    }

    /*
    *
    *优质店铺
    *@description：public_display=1 表示 只可以显示的
    */
    public function goodExcellentList( $offset="0", $limit="10",$has_other_info= false,$public_display="1")
    {

        if ($has_other_info) {
            $where = "s.status=1 ";
            if($public_display == '1') $where .= " and s.public_display = 1";
            $order = "s.income desc,s.collect desc,s.approve desc";
            $store_list = $this->db->table("Store as s")->join('Store_contact sc  ON  s.store_id=sc.store_id','LEFT')->join('Sale_category ss ON ss.cat_id = s.sale_category_id' , 'left')
                ->where($where)
                ->limit($offset . ',' . $limit)
                ->order($order)
                ->field("s.*,sc.long,sc.lat,sc.city,sc.province,sc.address, ss.name as cate_name")
                ->select();

        } else {
            $where = array('status' => 1,'public_display'=>1);
            if($public_display == '1') $where['public_display']= "1";
            $order = "income desc,collect desc,approve desc";
            $store_list = $this->db->where($where)->order($order)->limit($offset . ',' . $limit)->select();
        }

        if(!empty($store_list)) {
            foreach($store_list as &$value) {
                $value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
                $value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));
                /*if ($has_other_info) {
                    $sale_cate = M('Sale_category')->getCategory($value['sale_category_id']);
                    $store['cate_name'] =$sale_cate['name'];
                }*/
                if(empty($value['logo'])) {
                    $store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $value['logo'] = getAttachmentUrl($value['logo']);
                }
                //店铺二维码
                //本地化$value['qcode'] = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
                $value['qcode'] = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];//微信端临时二维码

                $value['wx_image'] =  $value['qcode'] ;
            }
        }

        return $store_list;
    }


    //优质供应商
    public function supplieStore( $offset="0", $limit="10",$has_other_info= false,$public_display="1") {

        $order = "s.drp_profit desc";
        $where = "s.status=1 and s.drp_supplier_id=0 and public_display=1";
        if($public_display == '1') $where .=" and s.public_display=1";
        $store_list = $this->db->table("Store as s")->join('Sale_Category sc  ON  s.sale_category_id=sc.cat_id','LEFT')
            ->where($where)
            ->limit($offset . ',' . $limit)
            ->order($order)
            ->field("s.*,sc.name as cate_name")
            ->select();

        if(!empty($store_list)) {
            foreach($store_list as &$value) {
                $value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
                $value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));
                if(empty($value['logo'])) {
                    $store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $value['logo'] = getAttachmentUrl($value['logo']);
                }
                //店铺二维码
                //本地化$value['qcode'] = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
                $value['qcode'] = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];	//微信端临时二维码

                $value['wx_image'] =  $value['qcode'] ;
            }
        }
        return $store_list;
    }


    //获取指定条件下的店铺列表(old)
    public function getlist($where=array(), $orderby="", $limit="10") {


        $store_list =  $this->db->where($where)->order($orderby)->limit($limit)->select();

        if(!empty($store_list)) {
            foreach($store_list as &$value){
                $value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
                $value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));

                if(empty($value['logo'])) {
                    $value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $value['logo'] = getAttachmentUrl($value['logo']);
                }

                //店铺二维码
                //本地化二维码$value['qcode'] = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
                $value['qcode'] = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];		//微信端临时二维码

                $value['wx_image'] =  $value['qcode'] ;

            }
        }

        return $store_list;
    }

    //获取指定条件下的店铺列表(new)
    public function getlist_new($where=array(), $orderby="", $limit="10") {
        $field = "";
        $WebUserInfo = show_distance();
        if($WebUserInfo['long']) {
            if(option('config.lbs_distance_limit')) {
                $field = ", ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli";
                $where = $where ." HAVING juli <=".option('config.lbs_distance_limit')*1000;
            }
        } else {
            if($WebUserInfo['city_name']) {
                if(!is_array($where)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {

                }
            }
        }

        $store_list =  $this->db -> table("Store s")
            -> join("Store_contact sc On s.store_id=sc.store_id","left")
            -> field("s.*,sc.long,sc.lat,sc.address,sc.province,sc.city ".$field)
            -> where($where)
            -> order($orderby)
            -> limit($limit)
            -> select();


        if(!empty($store_list)) {
            foreach($store_list as &$value){
                $value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
                $value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));

                if(empty($value['logo'])) {
                    $value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $value['logo'] = getAttachmentUrl($value['logo']);
                }

                //店铺二维码
                //本地化二维码$value['qcode'] = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
                $value['qcode'] = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];		//微信端临时二维码

                $value['wx_image'] =  $value['qcode'] ;

            }
        }

        return $store_list;
    }


    //获取有批发商品的店铺列表
    public function getWholeStoer($where=array(), $offset = 0, $limit = 0) {
        $sql = "SELECT distinct s.sale_category_id,s.is_required_to_audit,s.is_required_margin,s.store_id,s.name,s.linkman,s.tel,s.approve,s.attention_num, s.logo,s.date_added,s.open_store_whole FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'product ss WHERE s.store_id = ss.store_id and ss.is_wholesale = 1';
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                    else
                    {
                        $sql .= " AND " . $key ." $value[0] " . $value[1];
                    }
                } else {
                    $sql .= " AND " . $key . "=" .'"'. $value .'"';
                }
            }

            if ($limit) {
                $sql .= ' LIMIT ' . $offset . ',' . $limit;
            }
        }
        $store_list = $this->db->query($sql);

        if(!empty($store_list)) {
            foreach($store_list as &$value){
                $value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
                $value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));

                if(empty($value['logo'])) {
                    $value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $value['logo'] = getAttachmentUrl($value['logo']);
                }

                $value['qcode'] = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];		//微信端临时二维码

                $value['wx_image'] =  $value['qcode'] ;

            }
        }
        return $store_list;
    }
    //获取有批发商品的店铺数
    public function getStoreCount($where)
    {
        $sql = "SELECT count(distinct s.store_id) as storeId FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . 'product ss WHERE s.store_id = ss.store_id and ss.is_wholesale = 1';
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
        $store_count = $this->db->query($sql);
        return !empty($store_count[0]['storeId']) ? $store_count[0]['storeId'] : 0;
    }

    //获取用户店铺
    public function getStoresByUid($uid, $status = 1){
        if ($status == 1 || $status == 0) {
            $where = array('uid'=>$uid,'status'=>$status);
            $orderby = 'store_id asc';
        } else {
            $where = array('uid'=>$uid, 'drp_approve' => 1);
            $orderby = 'status ASC, store_id asc';
        }
        $list_count = $this->db->where($where)->count('store_id');
        if (option('config.user_store_num_limit') > 0 && option('config.user_store_num_limit') <= 15) {
            $return['store_list'] = $this->db->where($where)->limit('0,' . option('config.user_store_num_limit'))->order($orderby)->select();
            $return['page'] = '';
        } else {
            import('source.class.user_page');
            $p = new Page($list_count,15);
            $return['store_list'] = $this->db->where($where)->limit($p->firstRow.','.$p->listRows)->order($orderby)->select();
            $return['page'] = $p->show();
        }
        return $return;
    }

    //获取分销用户店铺
    public function getStoresSellerByUid($uid){

        $sql = "SELECT count(store_id) as storeId FROM " . option('system.DB_PREFIX') . "store where uid = ".$uid." and drp_level > " .'0';

        $storeCount = $this->db->query($sql);

        return $storeCount[0]['storeId'];
    }

    //获取用户所有店铺
    public function getAllStoresByUid($uid, $store_id = 0){
        if (!empty($store_id)) {
            return $this->db->field('store_id,name')->where(array('store_id' => $store_id, 'uid' => $uid,'status'=>1))->select();
        } else {
            return $this->db->field('store_id,name')->where(array('uid' => $uid,'status'=>1))->select();
        }
    }

    //获取主营类目下的店铺列表(按距离搜索)
    public function getWeidianStoreListBySaleCategoryId_location_new($sale_category_id,$limit,$is_fid=false,$is_approve = ''){

        $field = '`s`.`store_id`,`s`.`name`,`s`.`logo`';
        $WebUserInfo = show_distance();
        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(option("config.lbs_distance_limit")) {
                $field .= ", ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli ";
                $has_limit_distance = " HAVING juli <=".option("config.lbs_distance_limit")*1000;
            }
        } else {
            if($WebUserInfo['city_name']) {
                $condition_store[] = " sc.city='".$WebUserInfo['city_code']."'";
            } else {
                //	$wheres[] = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                //	$wheres = implode(" and ", $wheres);

            }
        }

        $condition_store[] = "s.status = 1";
        $condition_store[] = "s.public_display = 1";
        $condition_store[] = "s.drp_level=0";
        $condition_store[] = "s.is_point_mall=0";
        if($is_fid){
            $condition_store[] = "( s.sale_category_fid = ".$sale_category_id." or s.sale_category_id = " .$sale_category_id." )";
        }else{
            $condition_store[] = "( s.sale_category_fid = ".$sale_category_id." or s.sale_category_id = " .$sale_category_id." )";
        }
        if($is_approve != '') $condition_store[] = "s.approve = ".$is_approve;

        $condition_store = implode(" and ",$condition_store);
        if($has_limit_distance) {
            $condition_store = $condition_store . " " .$has_limit_distance;
        }


        $store_list = $this->db->table("Store s")->join("Store_contact sc On s.store_id=sc.store_id","LEFT")->field($field)->where($condition_store)->order('`s`.`store_id` DESC')->limit($limit)->select();

        if(!empty($store_list)){
            foreach($store_list as &$value){
                $value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
                $value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));
                $value['app_url'] = url('store:index', array('id' => $value['store_id']));

                if(empty($value['logo'])) {
                    $value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $value['logo'] = getAttachmentUrl($value['logo']);
                }
            }
        }
        return $store_list;
    }


    //获取主营类目下的店铺列表
    public function getWeidianStoreListBySaleCategoryId($sale_category_id,$limit,$is_fid=false,$is_approve = ''){

        $condition_store['status'] = '1';
        $condition_store['public_display'] = '1';
        $condition_store['drp_level'] = '0';
        if($is_fid){
            $condition_store['sale_category_fid'] = $sale_category_id;
        }else{
            $condition_store['sale_category_id'] = $sale_category_id;
        }
        if($is_approve != '') $condition_store['approve'] = $is_approve;
        $store_list = $this->db->field('`store_id`,`name`,`logo`')->where($condition_store)->order('`store_id` DESC')->limit($limit)->select();

        if(!empty($store_list)){
            foreach($store_list as &$value){
                $value['url'] = option('config.wap_site_url').'/home.php?id='.$value['store_id'].'&platform=1';
                $value['pcurl'] =  url_rewrite('store:index', array('id' => $value['store_id']));
                $value['app_url'] = url('store:index', array('id' => $value['store_id']));

                if(empty($value['logo'])) {
                    $value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $value['logo'] = getAttachmentUrl($value['logo']);
                }
            }
        }
        return $store_list;
    }


    //获取指定个数主营类目下的指定店铺列表
    /*
     * @param 店铺类目二维数组 array()
     */
    public function getWeidianStoreListBySaleCategoryList($where_store,$sale_category_limit,$store_limit){

        $categoryList =  M('Sale_category')->getCategoryList($where_store,$sale_category_limit);
        $new_category_list = array();
        foreach($categoryList as $k=>$v){
            $new_category_list[$k] = $v;
            $categoryList = $this->getWeidianStoreListBySaleCategoryId($v['cat_id'],$store_limit,true,1);

            $new_category_list[$k]['cat_list'] = $categoryList;

        }

        return $new_category_list;
    }

    //获取单个店铺
    public function getStoreById($store_id, $uid){
        $store = $this->db->where(array('store_id' => $store_id, 'uid' => $uid, 'status' => 1))->find();
        if(!empty($store)){
            $store['url'] = option('config.wap_site_url').'/home.php?id='.$store['store_id'];
            if(empty($store['logo'])) {
                $store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
            } else {
                $store['logo'] = getAttachmentUrl($store['logo']);
            }
        }
        return $store;
    }

    //用店铺ID获取一个店铺
    public function getStore($store_id, $is_supplier_store_id = false){
        $store = $this->db->where(array('store_id'=>$store_id,'status'=>1))->find();
        if(!empty($store)){
            $store['url'] = option('config.wap_site_url').'/home.php?id='.$store['store_id'];

            if(empty($store['logo'])) {
                $store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
            } else {
                $store['logo'] = getAttachmentUrl($store['logo']);
            }
            //本地化二维码$store['qcode'] = $store['qcode'] ?  getAttachmentUrl($store['qcode']) : "/source/qrcode.php?type=home&id=".$store['store_id'];
            $store['qcode'] = $store['qcode'] ?  $store['qcode'] : "/source/qrcode.php?type=home&id=".$store['store_id'];	//微信端临时二维码
            $store['ucenter_url'] = option('config.wap_site_url').'/ucenter.php?id='.$store['store_id'];


            if ($is_supplier_store_id && !empty($store['drp_supplier_id'])) {
                $supplier = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $store['store_id'], 'type' => 1))->find();
                if (!empty($supplier['supply_chain'])) {
                    $supply_chain = $supplier['supply_chain'];
                    $supplier = explode(',', $supplier['supply_chain']);
                    if (!empty($supplier[1])) {
                        $store['top_supplier_id'] = $supplier[1];
                        $store['supply_chain']    = $supply_chain;

                        $supplier_info = D('Store')->where(array('store_id' => $supplier[1]))->find();
                        $store['open_nav']     = $supplier_info['open_nav'];
                        $store['use_nav_pages']     = $supplier_info['use_nav_pages'];
                        $store['use_ad_pages'] = $supplier_info['use_ad_pages'];
                        $store['open_ad']      = $supplier_info['open_ad'];
                        $store['nav_style_id'] = $supplier_info['nav_style_id'];
                        $store['has_ad']       = $supplier_info['has_ad'];
                        $store['ad_position']  = $supplier_info['ad_position'];
                        $store['use_ad_pages'] = $supplier_info['use_ad_pages'];

                        $store['open_logistics']      = $supplier_info['open_logistics'];
                        $store['buyer_selffetch']     = false;
                        $store['open_drp_limit']      = $supplier_info['open_drp_limit'];
                        $store['drp_limit_buy']       = $supplier_info['drp_limit_buy'];
                        $store['drp_limit_share']     = $supplier_info['drp_limit_share'];
                        $store['drp_limit_condition'] = $supplier_info['drp_limit_condition'];
                        $store['open_drp_guidance']   = $supplier_info['open_drp_guidance'];
                        $store['wxpay']               = $supplier_info['wxpay'];
                        $store['approve']             = $supplier_info['approve'];
                        $store['open_friend']         = $supplier_info['open_friend'];
                        $store['margin_balance']      = $supplier_info['margin_balance'];
                        
                        // 升级方式
                        $store['degree_exchange_type'] = $supplier_info['degree_exchange_type'];
                        $store['open_drp_degree'] = $supplier_info['open_drp_degree'];
                    }
                }
            }

            option('now_store',$store);
        }
        return $store;
    }

    //用店铺ID获取一个店铺(手机站专用)
    public function wap_getStore($store_id){
        $store = $this->db->where(array('store_id'=>$store_id))->find();
        //是否使用粉丝终身制
        if (!empty($_SESSION['wap_user'])) {
            import('source.class.Drp');
            Drp::fans_forever($_SESSION['wap_user']['uid'], $store_id, true);
        }
        if(!empty($store)){
            $_SESSION['tmp_store_id'] = $store_id;

            //检测分销商是否已经被禁用
            if (IS_GET && $store['status'] != 1) {
                pigcms_tips('您访问的店铺不存在或已被删除', 'none');
            } else if ((IS_POST || IS_AJAX) && $store['status'] != 1) {
                json_return(1001, '您访问的店铺不存在或已被删除');
            }
            if (IS_GET && $store['drp_approve'] != 1) {
                pigcms_tips('您访问的店铺正在审核中...', 'none');
            } else if ((IS_POST || IS_AJAX) && $store['drp_approve'] != 1) {
                json_return(1001, '您访问的店铺正在审核中..');
            }


            //解决o2o同一用户在微店生成多个用户问题
            if (!empty($_SESSION['wap_user']['source_site_url']) && !empty($_SESSION['wap_user']['third_id'])) {
                $users = D('User')->where(array('source_site_url' => $_SESSION['wap_user']['source_site_url'], 'third_id' => $_SESSION['wap_user']['third_id'], 'status' => 1))->count('uid');
                if ($users > 1) {
                    unset($_SESSION['sync_user']); //删除同步标识
                    unset($_SESSION['wap_user']); //删除用户登录状态
                }
            }


            //解决用户访问不同店铺重复授权生成新用户问题
            /*if (empty($_SESSION['wap_user']) && !empty($_COOKIE['uid'])) { //COOKIE中有用户信息
                $tmp_user = M('User')->checkUser(array('uid' => $_COOKIE['uid']));
                if (!empty($tmp_user)) {
                    $_SESSION['wap_user'] = $tmp_user;
                    $tmp_seller = D('Store')->where(array('drp_supplier_id' => $store_id, 'uid' => $_COOKIE['uid'], 'status' => 1))->find();
                    if (!empty($tmp_seller)) {
                        $_SESSION['wap_drp_store'] = $tmp_seller;
                        if (!empty($tmp_seller['oauth_url'])) { //对接微店
                            $_SESSION['sync_user'] = true;
                        }
                    }
                    setcookie('uid', $_COOKIE['uid'], $_SERVER['REQUEST_TIME']+10000000, '/'); //延长cookie有效期
                } else {
                    unset($_SESSION['sync_user']); //删除同步标识
                    unset($_SESSION['wap_user']); //删除用户登录状态
                }
            }*/
            //判断是否为对接微店
            if (!empty($store['oauth_url'])) {
                if (!empty($_SESSION['wap_user']) && $_SESSION['wap_user']['store_id'] != $store_id) { //非当前店铺粉丝，重新授权登陆
                    unset($_SESSION['sync_user']); //删除同步标识
                    unset($_SESSION['wap_user']); //删除用户登录状态
                }
            } else {
                unset($_SESSION['sync_user']);//非对接店铺 删除同步标识
            }
            //授权条件：非对接同步用户，非对接店铺，店铺管理后台未登录（不加此条件，店铺管理后台的所有链接无法在pc端打开，都会跳转授权）

            /*是否移动端*/
            $is_mobile = is_mobile();
            /*是否微信端*/
            $is_weixin = is_weixin();

            //对接网站用户授权登陆
            //授权条件：非对接同步用户，是对接店铺，店铺管理后台未登录（不加此条件，店铺管理后台的所有链接无法在pc端打开，都会跳转授权）
            if($_GET['preview']){
                return $store;
            }else if ($is_weixin && empty($_SESSION['sync_user']) && !empty($store['oauth_url']) && empty($_SESSION['sync_store'])) {

                $return_url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                if (!empty($store['oauth_url'])) {
                    if (stripos($store['oauth_url'], '?') === false) {
                        redirect($store['oauth_url'] . '?return_url=' . $return_url . '&store_id=' . $store_id . '&token=' . $store['token']);
                    } else {
                        redirect($store['oauth_url'] . '&return_url=' . $return_url . '&store_id=' . $store_id . '&token=' . $store['token']);
                    }
                }
            } else if (empty($_SESSION['sync_user']) && empty($store['oauth_url']) && empty($_SESSION['store']) && empty($_SESSION['app_login'])) { //默认授权

                //调试  清除登录信息
                //setcookie('pigcms_sessionid','',$_SERVER['REQUEST_TIME']-10000000,'/');
                //$_SESSION = null;
                //session_destroy();

                /*如果是微信端，且配置文件中配置了微信信息，得到openid*/

                if($is_weixin && $this->check_cookie($store_id) && (empty($_SESSION['openid']) || empty($_SESSION['wap_user']))){

                    if (option('config.wap_login_bind') == 1) {     // 配置要求绑定
                        $customeUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                        //跳转登陆
                        redirect(option('config.wap_site_url').'/login.php?store_id=' . $store_id . '&referer='.urlencode($customeUrl));
                    } else if (option('config.wap_login_bind') == 0) {        // 静默授权

                        //openid存在 通过openid查找用户
                        if (!empty($_SESSION['openid'])) {
                            $userinfo = M('User')->get_user('openid', $_SESSION['openid']);
                            $_SESSION['wap_user'] = $userinfo['user'];
                            mergeSessionUserInfo(session_id(), $userinfo['user']['uid']);
                            unset($_SESSION['wap_drp_store']);
                        }
                        //用户未登录 调用授权获取openid, 通过openid查找用户，如果已经存在，设置登录，如果不存在，添加一个新用户和openid关联
                        if (empty($_SESSION['openid']) || empty($_SESSION['wap_user'])) {

                            $customeUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

                            //判断店铺是否绑定过认证服务号
                            $wx_bind    = D('Weixin_bind')->where(array('store_id'=>$store['store_id']))->find();
                            if(empty($_GET['code'])){
                                $_SESSION['weixin']['state']   = md5(uniqid());
                                //if(!empty($wx_bind) && $wx_bind['service_type_info'] == 2 && $wx_bind['verify_type_info'] == 0){
                                    //$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wx_bind['authorizer_appid'].'&redirect_uri='.urlencode($customeUrl).'&response_type=code&scope=snsapi_userinfo&state='.$_SESSION['weixin']['state'].'&component_appid='.option('config.wx_appid').'#wechat_redirect';
                                //}else{
                                    //店铺非认证服务号走总后台授权
                                    $oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.option('config.wechat_appid').'&redirect_uri='.urlencode($customeUrl).'&response_type=code&scope=snsapi_userinfo&state='.$_SESSION['weixin']['state'].'#wechat_redirect';
                                //}
                                redirect($oauthUrl);exit;
                            }else if(isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixin']['state'])){
                                unset($_SESSION['weixin']);
                                import('Http');
                                $http = new Http();

                                //if(!empty($wx_bind) && $wx_bind['service_type_info'] == 2 && $wx_bind['verify_type_info'] == 0){
                                //  $component_token = M('Weixin_bind')->get_access_token($store['store_id'],true);
                                //  $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/component/access_token?appid='.$wx_bind['authorizer_appid'].'&code='.$_GET['code'].'&grant_type=authorization_code&component_appid='.option('config.wx_appid').'&component_access_token='.$component_token['component_access_token'];
                                //}else{
                                    $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.option('config.wechat_appid').'&secret='.option('config.wechat_appsecret').'&code='.$_GET['code'].'&grant_type=authorization_code';
                                //}
                         //   $err=$tokenUrl;
				//	error_log(date("[Y-m-d H:i:s]")." tokenUrl-[".$_SERVER['REQUEST_URI']."] :".$err."\n", 3, "D:/ceshi/tmp/php_sql_err.log");
                                $return = $http->curlGet($tokenUrl);
								$err=$return;
				//	error_log(date("[Y-m-d H:i:s]")." return-[".$_SERVER['REQUEST_URI']."] :".$err."\n", 3, "D:/ceshi/tmp/php_sql_err.log");
                                $jsonrt = json_decode($return,true);

                                if($jsonrt['errcode']){
                                    $error_msg_class = new GetErrorMsg();
                                    exit('授权发生错误：'.$jsonrt['errcode']);
                                }

                                if($jsonrt['openid']){ //微信中打开直接登陆
                                    $url    = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$jsonrt['access_token'].'&openid='.$jsonrt['openid'].'&lang=zh_CN';
						            $wxuser     = $http->curlGet($url);
								//	$err=$url;
								//	error_log(date("[Y-m-d H:i:s]")." url-[".$_SERVER['REQUEST_URI']."] :".$err."\n", 3, "D:/ceshi/tmp/php_sql_err.log");
                                    $wxuser = json_decode($wxuser, true);
									$err=$wxuser['unionid'];
error_log(date("[Y-m-d H:i:s]")." unionid-[".$_SERVER['REQUEST_URI']."] :".$err."\n", 3, "D:/ceshi/tmp/php_sql_err.log");
                                    $_SESSION['openid'] = $jsonrt['openid'];

                                    $userinfo = M('User')->get_user('openid', $_SESSION['openid']);
                                    if(empty($userinfo['user'])){ //用户不存在，添加新用户，并设置登录
                                        $data = array();
                                        $data['phone']          = '';
                                        $data['nickname']       = $wxuser['nickname'];
                                        $data['openid']         = $_SESSION['openid'];
                                        $data['avatar']         = $wxuser['headimgurl'];
                                        $data['password']       = '';
                                        $data['check_phone']    = 1;
                                        $data['login_count']    = 1;
                                        $data['sex']            = $wxuser['sex'];
                                        $data['province']       = $wxuser['province'];
                                        $data['city']           = $wxuser['city'];
										$data['unionid'] = $wxuser['unionid'];
                                        $add_result = M('User')->add_user($data);
										
                                        if($add_result['err_code'] == 0){
                                            $_SESSION['wap_user']               = $add_result['err_msg'];
                                            $_SESSION['wap_user']['sex']        = $wxuser['sex'];
                                            $_SESSION['wap_user']['province']   = $wxuser['province'];
                                            $_SESSION['wap_user']['city']       = $wxuser['city'];
                                            mergeSessionUserInfo(session_id(),$add_result['err_msg']['uid'], $store_id);
                                        }
                                    } else { //用户已存在，设置登录
                                        $_SESSION['wap_user']               = $userinfo['user'];
                                        $_SESSION['wap_user']['avatar']     = $wxuser['headimgurl'];
                                        $_SESSION['wap_user']['sex']        = $wxuser['sex'];
                                        $_SESSION['wap_user']['province']   = $wxuser['province'];
                                        $_SESSION['wap_user']['city']       = $wxuser['city'];
										$_SESSION['wap_user']['unionid']     = $wxuser['unionid'];
										
                                        mergeSessionUserInfo(session_id(), $userinfo['user']['uid']);
                                        if (empty($userinfo['user']['sex']) || empty($userinfo['user']['province']) || empty($userinfo['user']['unionid'])) {
										
                                            $userinfo['user']['avatar']     = $wxuser['headimgurl'];
                                            $userinfo['user']['sex']        = $wxuser['sex'];
                                            $userinfo['user']['province']   = $wxuser['province'];
                                            $userinfo['user']['city']       = $wxuser['city'];
											$userinfo['user']['unionid']       = $wxuser['unionid'];
                                            M('User')->edit_user($userinfo['user']);
											
                                        }
                                    }
                                    setcookie('LOGIN_'.option('config.wechat_appid'),$jsonrt['openid'],time()+60*60*24*30);
                                    unset($_SESSION['wap_drp_store']); //删除保存在session中的分销店铺
                                }
                            }
                        }

                    }

                } else {
                    setcookie('LOGIN_'.option('config.wechat_appid'),$_SESSION['openid'],time()+60*60*24*30);
                }

                //}
            }

            $store['url'] = option('config.wap_site_url').'/home.php?id='.$store['store_id'];
            if(empty($store['logo'])) {
                $store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
            } else if (stripos($store['logo'], 'http://') === false && stripos($store['logo'], 'https://') === false) {
                $store['logo'] = getAttachmentUrl($store['logo']);
            }
            $store['ucenter_url'] = option('config.wap_site_url').'/ucenter.php?id='.$store['store_id'];
            $store['physical_url'] = option('config.wap_site_url').'/physical.php?id='.$store['store_id'];
        }

        if (!empty($store['drp_supplier_id'])) {
            $supplier = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $store['store_id'], 'type' => 1))->find();
            if (!empty($supplier['supply_chain'])) {
                $supply_chain = $supplier['supply_chain'];
                $supplier = explode(',', $supplier['supply_chain']);
                if (!empty($supplier[1])) {
                    $store['top_supplier_id'] = $supplier[1];
                    $store['supply_chain']    = $supply_chain;

                    $supplier_info = D('Store')->field('open_nav,use_nav_pages,use_ad_pages,open_ad,open_friend,nav_style_id,has_ad,ad_position,use_ad_pages,open_logistics,buyer_selffetch,open_drp_limit,drp_limit_buy,drp_limit_share,drp_limit_condition,open_drp_guidance,margin_balance')->where(array('store_id' => $supplier[1]))->find();
                    $store['open_nav']     = $supplier_info['open_nav'];
                    $store['use_nav_pages']     = $supplier_info['use_nav_pages'];
                    $store['use_ad_pages'] = $supplier_info['use_ad_pages'];
                    $store['open_ad']      = $supplier_info['open_ad'];
                    $store['nav_style_id'] = $supplier_info['nav_style_id'];
                    $store['has_ad']       = $supplier_info['has_ad'];
                    $store['ad_position']  = $supplier_info['ad_position'];
                    $store['use_ad_pages'] = $supplier_info['use_ad_pages'];

                    $store['open_logistics']      = $supplier_info['open_logistics'];
                    $store['buyer_selffetch']     = false;
                    $store['open_drp_limit']      = $supplier_info['open_drp_limit'];
                    $store['drp_limit_buy']       = $supplier_info['drp_limit_buy'];
                    $store['drp_limit_share']     = $supplier_info['drp_limit_share'];
                    $store['drp_limit_condition'] = $supplier_info['drp_limit_condition'];
                    $store['open_drp_guidance']   = $supplier_info['open_drp_guidance'];
                    $store['wxpay']               = $supplier_info['wxpay'];
                    $store['approve']             = $supplier_info['approve'];
                    $store['open_friend']         = $supplier_info['open_friend'];
                    $store['margin_balance']      = $supplier_info['margin_balance'];
                }
            }
        }
        option('now_store',$store);

        /*判断链接是否带有真实openid（非认证服务号判断关注） start*/
        if (isset($_GET['sub_openid']) && $_SESSION['wap_user']['uid']) {
            //是否有关注记录
            $is_sub 	= D('Subscribe_store')->where(array('store_id'=>$store_id,'openid'=> $_GET['sub_openid']))->find();

            //获取顶级供货商绑定微信
            $supplier = D('Store')->where(array('store_id' => $store_id))->find();
            if ($supplier['drp_level'] > 0) {
                $root_supplier_id 	= $supplier['root_supplier_id'];
            } else if ($supplier['drp_level'] == 0) {
                $root_supplier_id 	= $store_id;
            }

            //店铺是否绑定公众号
            $weixin_bind_info	= D('Weixin_bind')->where($root_supplier_id)->find();
            if ($weixin_bind_info && $weixin_bind_info['service_type_info'] != 2 && $weixin_bind_info['verify_type_info'] != '0') {
                if($is_sub) {
                    if ($is_sub['uid'] == 0) {
                        D('Subscribe_store')->data(array('user_subscribe_time'=>time(), 'uid' => $_SESSION['wap_user']['uid']))->where(array('openid' => $_GET['sub_openid'], 'store_id'=>$store_id,'uid'=>0))->save();
                        //关注送积分
                        if ($store_id != $root_supplier_id) {
                            import('source.class.Points');
                            Points::subscribe($_SESSION['wap_user']['uid'], $root_supplier_id, $store_id);
                        }
                    }
                } else {
                    $data   = array(
                        'uid'       => $_SESSION['wap_user']['uid'],
                        'openid'    => $_GET['sub_openid'],
                        'store_id'  => $store_id,
                        'subscribe_time'    	=> '0',
                        'user_subscribe_time'	=> time(),
                    );
                    D('Subscribe_store')->data($data)->add();
                }
                $_SESSION['STORE_OPENID_' . $store_id] = $_GET['sub_openid'];
            }
        }
        /* end */
        //是否使用粉丝终身制
        if (!empty($_SESSION['wap_user'])) {
            import('source.class.Drp');
            Drp::fans_forever($_SESSION['wap_user']['uid'], $store_id, true);
        }

        return $store;
    }

    public function check_cookie($store_id){
        $appid  = option('config.wechat_appid');
        if(empty($_COOKIE['LOGIN_'.$appid])){
            return true;
        }else{
            $userinfo = M('User')->get_user('openid', $_COOKIE['LOGIN_'.$appid]);
            if(empty($userinfo['user']) || empty($_SESSION['wap_user'])) { //用户不存在，清除session重新授权
                return true;
            } else if (option('config.wap_login_bind') == 1 && empty($userinfo['user']['phone']) && $userinfo['user']['weixin_bind'] == 1) {
                $customeUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                //跳转绑定
                redirect(option('config.wap_site_url').'/login.php?referer='.urlencode($customeUrl));
            }
            $_SESSION['openid']     = $_COOKIE['LOGIN_'.$appid];
            $_SESSION['wap_user'] = $userinfo['user'];
            $_SESSION['wap_user']['sex'] = $userinfo['sex'];
            $_SESSION['wap_user']['province'] = $userinfo['province'];
            $_SESSION['wap_user']['city'] = $userinfo['city'];
            mergeSessionUserInfo(session_id(), $userinfo['user']['uid']);
            if(!empty($_SESSION['wap_drp_store']) && ($_SESSION['wap_drp_store']['uid'] != $userinfo['user']['uid'])){
                unset($_SESSION['wap_drp_store']); //删除保存在session中的分销店铺
            }

            /*已是平台用户，获取粉丝真实openid*/
            //获取顶级供货商绑定微信
            $supplier = D('Store')->where(array('store_id' => $store_id))->find();
            if($supplier['drp_level'] > 0) {
                $root_supplier_id   = $supplier['root_supplier_id'];
            }else if($supplier['drp_level'] == 0){
                $root_supplier_id   = $store_id;
            }

            $wx_bind        = D('Weixin_bind')->where(array('store_id' => $root_supplier_id))->find();

            //检查是否有真实openid
            $is_true_openid = D('Subscribe_store')->where("openid='" . $_SESSION['STORE_OPENID_' . $store_id] . "' AND uid='" . $userinfo['user']['uid'] . "' AND store_id=".$store_id)->find();


            //没有真实openid 并且商家绑定过认证服务号
            if(empty($is_true_openid) && ($wx_bind['service_type_info'] == 2 && $wx_bind['verify_type_info'] != '-1')) {
                if(empty($_GET['code'])){
                    $customeUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    $_SESSION['weixin']['state']   = md5(uniqid());
                    $oauthUrl   = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wx_bind['authorizer_appid'].'&redirect_uri='.urlencode($customeUrl).'&response_type=code&scope=snsapi_base&state='.$_SESSION['weixin']['state'].'&component_appid='.option('config.wx_appid').'#wechat_redirect';

                    redirect($oauthUrl);exit;

                }else if(isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixin']['state'])){
                    unset($_SESSION['weixin']);
                    import('Http');
                    $http = new Http();

                    $component_token = M('Weixin_bind')->get_access_token($root_supplier_id,true);
                    $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/component/access_token?appid='.$wx_bind['authorizer_appid'].'&code='.$_GET['code'].'&grant_type=authorization_code&component_appid='.option('config.wx_appid').'&component_access_token='.$component_token['component_access_token'];

                    $return = $http->curlGet($tokenUrl);
                    $jsonrt = json_decode($return,true);

                    if($jsonrt['errcode']){
                        $error_msg_class = new GetErrorMsg();
                        exit('授权发生错误：'.$jsonrt['errcode']);
                    }else{

                        /* 是否关注店铺 */
                        $is_subscribed = D('Subscribe_store')->where(array('openid' => $jsonrt['openid'],'_string'=>"(uid=0 or store_id=0)"))->find();
                        
                        if ($is_subscribed) {
                            if($is_subscribed['uid'] == 0 && $is_subscribed['store_id'] == 0) {
                                D('Subscribe_store')->data(array('user_subscribe_time'=>time(),'uid' => $userinfo['user']['uid'], 'store_id'=>$store_id))->where(array('openid' => $jsonrt['openid'], 'store_id'=>0, 'uid'=>0))->save();
                                //关注送积分
                                if ($store_id != $root_supplier_id) {
                                    import('source.class.Points');
                                    Points::subscribe($userinfo['user']['uid'], $root_supplier_id, $store_id);
                                }
                            } else if ($is_subscribed['uid'] == 0) {
                                D('Subscribe_store')->data(array('user_subscribe_time'=>time(),'uid' => $userinfo['user']['uid']))->where(array('openid' => $jsonrt['openid'], 'store_id'=>$store_id,'uid'=>0))->save();
                                //关注送积分
                                if ($store_id != $root_supplier_id) {
                                    import('source.class.Points');
                                    Points::subscribe($userinfo['user']['uid'], $root_supplier_id, $store_id);
                                }
                            }
                        } else if (empty($is_true_openid)){
                            $data   = array(
                                'uid'       => $userinfo['user']['uid'],
                                'openid'    => $jsonrt['openid'],
                                'store_id'  => $store_id,
                                'subscribe_time'    => '0',
                                'user_subscribe_time' => time(),
                            );
                            D('Subscribe_store')->data($data)->add();
                        } else {
                            D('Subscribe_store')->where("uid='" . $userinfo['user']['uid'] . "' AND store_id=".$store_id)->data(array('openid'=>$jsonrt['openid']))->save();
                        }
                        $_SESSION['STORE_OPENID_' . $store_id] = $jsonrt['openid']; //店铺真实openid
                    }
                }
            } else {
                $_SESSION['STORE_OPENID_' . $store_id] = $is_true_openid['openid']; //店铺真实openid
            }

            return false;
        }
    }

    //更改店铺状态
    public function change_status($store_id,$uid,$status){
        if($this->db->where(array('store_id'=>$store_id,'uid'=>$uid))->data(array('status'=>$status))->save()){
            return array('err_code'=>0,'err_msg'=>'更改状态成功');
        }else{
            return array('err_code'=>1,'err_msg'=>'更改状态失败！请重试');
        }
    }

    //删除店铺
    public function delete($store_id, $uid){
        $result = $this->db->where(array('store_id' => $store_id, 'uid' => $uid))->delete();
        return $result;
    }

    //主营类目
    public function getSaleCategory($store_id, $uid){
        $store = $this->db->field('sale_category_id,sale_category_fid')->where(array('store_id' => $store_id,'uid' => $uid))->find();
        if (!empty($store['sale_category_id']) && !empty($store['sale_category_fid'])) {
            $fcategory = M('Sale_category')->getCategory($store['sale_category_fid']);
            $category = M('Sale_category')->getCategory($store['sale_category_id']);
            return $fcategory['name'] . ' - ' . $category['name'];
        } else if (!empty($store['sale_category_fid'])) {
            $fcategory = M('Sale_category')->getCategory($store['sale_category_fid']);
            return $fcategory['name'];
        } else if (!empty($store['sale_category_id'])) {
            $category = M('Sale_category')->getCategory($store['sale_category_id']);
            return $category['name'];
        }
    }

    //设置买家上门自提状态
    public function setSelfFetchStatus($status, $store_id)
    {
        $result = $this->db->where(array('store_id' => $store_id))->data(array('buyer_selffetch' => $status))->save();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    //获取买家上门自提状态
    public function getSelfFetchStatus($store_id)
    {
        $store = $this->db->field('buyer_selffetch')->where(array('store_id' => $store_id))->find();
        if (isset($store['buyer_selffetch'])) {
            return $store['buyer_selffetch'];
        } else {
            return 0;
        }
    }
    //设置找人找付
    public function setPayAgentStatus($status, $store_id)
    {
        $result = $this->db->where(array('store_id' => $store_id))->data(array('pay_agent' => $status))->save();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    //获取找人代付状态
    public function getPayAgentStatus($store_id)
    {
        $store = $this->db->field('pay_agent')->where(array('store_id' => $store_id))->find();
        if (isset($store['pay_agent'])) {
            return $store['pay_agent'];
        } else {
            return 0;
        }
    }

    //店铺名唯一性
    public function getUniqueName($name)
    {
        $count = $this->db->where(array('name' => $name, 'status' => 1))->count('store_id');
        if ($count) {
            return false;
        } else {
            return true;
        }
    }

    //店铺设置
    public function setting($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }

    //开启/关闭店铺导航
    public function openNav($store_id, $status)
    {
        return $this->db->where(array('store_id' => $store_id))->data(array('open_nav' => $status))->save();
    }

    //开启/关闭店铺广告
    public function openAd($store_id, $status)
    {
        return $this->db->where(array('store_id' => $store_id))->data(array('open_ad' => $status))->save();
    }

    //设置导航菜单
    public function setUseNavPage($store_id, $use_nav_pages)
    {
        return $this->db->where(array('store_id' => $store_id))->data(array('use_nav_pages' => $use_nav_pages))->save();
    }

    //设置店铺广告
    public function setAd($store_id, $data)
    {
        return $this->db->where(array('store_id' => $store_id))->data(array('has_ad' => $data['has_ad'], 'ad_position' => $data['ad_position'], 'use_ad_pages' => $data['use_ad_pages'], 'date_edited' => $data['date_edited']))->save();
    }

    //店铺收入
    public function getIncome($store_id)
    {
        $store = $this->db->where(array('store_id' => $store_id))->find();
        return $store['income'];
    }

    //店铺可提现余额
    public function getBalance($store_id)
    {
        $store = $this->db->field('balance')->where(array('store_id' => $store_id))->find();
        return !empty($store['balance']) ? $store['balance'] : 0;
    }

    //店铺已提现金额
    public function getWithdrawalAmount($store_id)
    {
        $store = $this->db->field('withdrawal_amount')->where(array('store_id' => $store_id))->find();
        return !empty($store['withdrawal_amount']) ? $store['withdrawal_amount'] : 0;
    }
    //保存提现配置
    public function settingWithdrawal($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }

    //提现申请
    public function applywithdrawal($store_id, $amount)
    {
        return $this->db->where(array('store_id' => $store_id))->setDec('balance', $amount);
    }

    //利润提现
    /*public function drpProfitWithdrawal($store_id, $amount)
    {
        return $this->db->where(array('store_id' => $store_id))->setInc('drp_profit_withdrawal', $amount);
    }*/

    //删除提现账号
    public function delwithdrawal($store_id)
    {
        return $this->db->where(array('store_id' => $store_id))->data(array('withdrawal_type' => 0, 'bank_id' => 0, 'bank_card' => '', 'bank_card_user' => '', 'last_edit_time' => time()))->save();
    }

    //获取用户店铺
    public function getStoreByUid($uid)
    {
        $store = $this->db->where(array('uid' => $uid, 'status' => 1))->order('store_id ASC')->find();
        return !empty($store['store_id']) ? $store['store_id'] : '';
    }

    //设置分销
    public function setFx($where, $data)
    {
        return $this->db->where($where)->data($data)->save();
    }

    //添加余额
    public function setBalanceInc($store_id, $amount)
    {
        return $this->db->where(array('store_id' => $store_id))->setInc('balance', $amount);
    }

    //添加不可用余额
    public function setUnBalanceInc($store_id, $amount)
    {
        return $this->db->where(array('store_id' => $store_id))->setInc('unbalance', $amount);
    }

    //减少不可用余额
    public function setUnBalanceDec($store_id, $amount)
    {
        return $this->db->where(array('store_id' => $store_id))->setDec('unbalance', $amount);
    }

    //添加收入
    public function setIncomeInc($store_id, $amount)
    {
        return $this->db->where(array('store_id' => $store_id))->setInc('income', $amount);
    }

    //减少收入
    public function setIncomeDec($store_id, $amount)
    {
        return $this->db->where(array('store_id' => $store_id))->setDec('income', $amount);
    }

    public function checkStoreExist($where)
    {
        return $this->db->where($where)->count('store_id');
    }

    //店铺分销级别
    public function getDrpLevel($store_id)
    {
        $store = $this->db->field('drp_level')->where(array('store_id' => $store_id))->find();
        return !empty($store['drp_level']) ? $store['drp_level'] : 0;
    }

    /**
     * @desc 获取用户分销店铺
     * @param $uid 用户id
     * @param $drp_supplier_id 供货商id
     * @return 店铺
     */
    public function getUserDrpStore($uid, $store_id = 0, $drp_approve = 1)
    {
        $where = array();
        $where['uid'] = $uid;
        if ($store_id) {
            $where['store_id'] = $store_id;
        }
        $where['drp_supplier_id'] = array('>', 0);
        $where['status'] = 1;
        if ($drp_approve) {
            $where['drp_approve'] = 1;
        }
        $store = $this->db->where($where)->find();
        return !empty($store) ? $store : '';
    }

    public function getUserDrpStores($uid)
    {
        $stores = $this->db->where(array('uid' => $uid, 'drp_supplier_id' => array('>', 0), 'status' => 1))->select();
        return $stores;
    }

    //判断是否为分销店铺
    public function isDrpStore($store_id)
    {
        $store = $this->db->field('drp_supplier_id')->where(array('store_id' => $store_id))->find();
        return !empty($store['drp_supplier_id']) ? true : false;
    }

    /**
     * 根据店铺id来返回店铺名称
     * param store_id_arr array
     * return array
     */
    public function getStoreName($store_id_arr = array()) {
        if (empty($store_id_arr)) {
            return array(0 => '-');
        }

        $store_list = D('Store')->where("`status` = 1 AND `store_id` in (" . join(',', $store_id_arr) . ")")->select();

        $data = array();
        foreach ($store_list as $store) {
            $data[$store['store_id']] = $store['name'];
        }

        return $data;

    }





    /**
     * 根据自身坐标与划定区域，检索店铺
     * @param: $where where条件
     * @param： $limit 限制条数
     * @param：$offset 偏移量
     * @param: $order  排序规则
     * @param: $get_distance 查找指定距离范围内的店铺数据  单位：km
     * @param: $$is_distance_order 是否按照距离排序
     */
    public function getStoreByRoundDistance($where, $limit="10", $offset="0", $order="",$sort="asc", $get_distance="", $is_distance_order = false) {

        $WebUserInfo = show_distance();
        $db_prefix = option('system.DB_PREFIX');
        $orders = "";
        if($order) $orders = $order . $sort;

        if(empty($WebUserInfo['long'])) {

            $store_list = D('')->table("Store as s")->where($where)->limit($offset . ',' . $limit)->order($orders)->select();
            foreach($store_list as $k=>&$v) {
                $v['qcode'] ?  getAttachmentUrl($v['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$v['store_id'];
            }
        } else{
            if($get_distance) {//指定范围内的降序

                if(is_array($where)){
                    if(count($where)) {
                        $where = implode(" AND ", $where);
                    }
                } else{
                    if($where) $where = $where ." and ";
                }

                $store_list = $this->nearshops($WebUserInfo['long'],$WebUserInfo['lat'],$order,$sort,$offset,$limit,$get_distance,$where);


            } else {	//纯地理降序

                if($is_distance_order) {


                    $store_list = $this->nearshops($WebUserInfo['long'],$WebUserInfo['lat'],$order,$sort,$offset,$limit,$where);
                } else{

                    $store_list = D('')->table("Store as s")->where($where)->limit($offset . ',' . $limit)->order($order)->select();
                    foreach($store_list as $k=>&$v) {

                        //本地化$v['qcode'] ?  getAttachmentUrl($v['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$v['store_id'];
                        $v['qcode'] = $v['qcode'] ?  $v['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$v['store_id'];//微信端临时二维码
                    }
                }
            }
        }

        return $store_list;
    }

    public function getStoreByRoundDistance_new($where, $limit="10", $offset="0", $order="",$sort="asc", $get_distance="", $is_distance_order = false, $p_c_a_arr =array()) {

        $WebUserInfo = show_distance();
        $db_prefix = option('system.DB_PREFIX');
        $orders = "";
        if($order) $orders = $order . $sort;

        if(is_array($where)) {
            $where = implode(" and ",$where);
        }

        if(empty($WebUserInfo['long'])) {

            /*if($WebUserInfo['city_name']) {
                if(!is_array($where)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {
                    $where[] = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                    $where = implode(" and ", $where);

                }
            }*/

            //增加区域筛选

            if(count($p_c_a_arr) > 0){
                if(join(',',$p_c_a_arr) != '0,0,0'){

                    if(!is_array($where)) {

                        if(!empty($p_c_a_arr[0])){
                            $where1 = "sc.province=".$p_c_a_arr[0];
                        }
                        $where = $where ? ($where ." and ".$where1 ) : $where1;

                        if(!empty($p_c_a_arr[1])) {
                            $where .= " AND sc.city=".$p_c_a_arr[1];
                        }

                        if(!empty($p_c_a_arr[2])) {
                            $where .= " AND sc.county=".$p_c_a_arr[2];
                        }

                    } else {
                        if(!empty($p_c_a_arr[0])){
                            $tmp_where = " s.status=1 and p.quantity > 0 and sc.province='".$p_c_a_arr[0]."'";
                        }

                        if(!empty($p_c_a_arr[1])) {
                            $tmp_where .= " AND sc.city=".$p_c_a_arr[1];
                        }

                        if(!empty($p_c_a_arr[2])) {
                            $tmp_where .= " AND sc.county=".$p_c_a_arr[2];
                        }
                        $where[] = $tmp_where;
                        $where = implode(" and ", $where);

                    }


                }

            }else{

                if($WebUserInfo['city_name']) {

                    if(!is_array($where)) {
                        $where1 = "sc.city=".$WebUserInfo['city_code'];
                        $where = $where ? ($where ." and ".$where1 ) : $where1;
                        if($WebUserInfo['area_name']) {
                            $where .= " AND sc.county=".$WebUserInfo['area_code'];
                        }
                    } else {
                        $tmp_where = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                        if($WebUserInfo['area_name']) {
                            $tmp_where .= " AND sc.county=".$WebUserInfo['area_code'];
                        }
                        $where[] = $tmp_where;
                        $where = implode(" and ", $where);

                    }
                }

            }


            $store_list = $this->db ->table("Store s")
                -> join("Store_contact sc On s.store_id=sc.store_id","LEFT")
                -> where($where)
                -> limit($offset . ',' . $limit)
                -> order($orders)
                -> field("s.*,sc.long,sc.lat,sc.city,sc.province,sc.county")
                -> select();

            foreach($store_list as $k=>&$v) {
                $v['qcode'] ?  getAttachmentUrl($v['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$v['store_id'];
            }
        } else{
            if($get_distance) {//指定范围内的降序

                if(is_array($where)){
                    if(count($where)) {
                        $where = implode(" AND ", $where);
                    }
                } else{
                    if($where) $where = $where ." and ";
                }

                $store_list = $this->nearshops($WebUserInfo['long'],$WebUserInfo['lat'],$order,$sort,$offset,$limit,$get_distance,$where);


            } else {	//纯地理降序
                /*
                if($is_distance_order) {


                    $store_list = $this->nearshops($WebUserInfo['long'],$WebUserInfo['lat'],$order,$sort,$offset,$limit);
                } else{

                    $store_list = D('')->table("Store as s")->where($where)->limit($offset . ',' . $limit)->order($order)->select();
                    foreach($store_list as $k=>&$v) {

                        //本地化$v['qcode'] ?  getAttachmentUrl($v['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$v['store_id'];
                        $v['qcode'] = $v['qcode'] ?  $v['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$v['store_id'];//微信端临时二维码
                    }
                }
                */

                $store_list = $this->nearshops_new($WebUserInfo['long'],$WebUserInfo['lat'],$order,$sort,$offset,$limit,0,$where);

            }
        }

        return $store_list;
    }


    /**
     * 根据自身坐标与划定区域，统计店铺数量
     * @param: $where where条件
     * @param: $get_distance 查找指定距离范围内的店铺数据  单位：km
     * @param: $$is_distance_order 是否按照距离排序
     */
    public function getStoreByRoundDistanceCount($where,$get_distance="",$is_distance_order = false) {
        $WebUserInfo = show_distance();
        $db_prefix = option('system.DB_PREFIX');

        if(empty($WebUserInfo['long'])) {

            $count = D('')->table("Store as s")->where($where)->count('store_id');
        } else{
            if($get_distance) {//指定范围内的降序

                if(is_array($where)){
                    if(count($where)) {
                        $where = implode(" AND ", $where);
                    }
                } else{
                    if($where) $where = $where ." and ";
                }
                $squares = returnSquarePoint($WebUserInfo['long'], $WebUserInfo['lat'],$get_distance);


                $count = $this->nearshop_count($WebUserInfo['long'],$WebUserInfo['lat'],$get_distance,$where);


            } else {	//纯地理降序
                if($is_distance_order) {

                    $count = $this->nearshop_count($WebUserInfo['long'],$WebUserInfo['lat']);
                } else{

                    $count = D('')->table("Store as s")->where($where)->count("s.store_id");
                }
            }
        }

        //echo $ss;
        return $count;
    }

    public function getStoreByRoundDistanceCount_new($where,$get_distance="",$is_distance_order = false,$p_c_a_arr = array()) {
        $WebUserInfo = show_distance();
        $db_prefix = option('system.DB_PREFIX');
        //echo "@@";
        if(empty($WebUserInfo['long'])) {
            //没有具体坐标
            if(is_array($where)){
                if(count($where)) {
                    $where = implode(" AND ", $where);
                }
            } else{
                if($where) $where = $where ." and ";
            }

            //增加区域筛选

            if(count($p_c_a_arr) > 0){
                if(join(',',$p_c_a_arr) != '0,0,0'){

                    if(!is_array($where)) {

                        if(!empty($p_c_a_arr[0])){
                            $where1 = "sc.province=".$p_c_a_arr[0];
                        }
                        $where = $where ? ($where ." and ".$where1 ) : $where1;

                        if(!empty($p_c_a_arr[1])) {
                            $where .= " AND sc.city=".$p_c_a_arr[1];
                        }

                        if(!empty($p_c_a_arr[2])) {
                            $where .= " AND sc.county=".$p_c_a_arr[2];
                        }

                    } else {
                        if(!empty($p_c_a_arr[0])){
                            $tmp_where = " s.status=1 and p.quantity > 0 and sc.province='".$p_c_a_arr[0]."'";
                        }

                        if(!empty($p_c_a_arr[1])) {
                            $tmp_where .= " AND sc.city=".$p_c_a_arr[1];
                        }

                        if(!empty($p_c_a_arr[2])) {
                            $tmp_where .= " AND sc.county=".$p_c_a_arr[2];
                        }
                        $where[] = $tmp_where;
                        $where = implode(" and ", $where);

                    }


                }

            }else{
                if($WebUserInfo['city_name']) {
                    if(!is_array($where)) {
                        $where1 = "sc.city=".$WebUserInfo['city_code'];
                        $where = $where ? ($where ." and ".$where1 ) : $where1;
                        if($WebUserInfo['area_name']) {
                            $where .= " AND sc.county=".$WebUserInfo['area_code'];
                        }
                    } else {
                        $tmp_where = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                        if($WebUserInfo['area_name']) {
                            $tmp_where .= " AND sc.county=".$WebUserInfo['area_code'];
                        }
                        $where[] = $tmp_where;
                        $where = implode(" and ", $where);

                    }
                }

            }

            $count = $this->db->table("Store s")
                ->join("Store_contact sc On s.store_id=sc.store_id","LEFT")
                ->where($where)
                ->count('s.store_id');
        } else{
            if($get_distance) {//指定范围内的降序

                if(is_array($where)){
                    if(count($where)) {
                        $where = implode(" AND ", $where);
                    }
                } else{
                    if($where) $where = $where ." and ";
                }
                $squares = returnSquarePoint($WebUserInfo['long'], $WebUserInfo['lat'],$get_distance);


                $count = $this->nearshop_count($WebUserInfo['long'],$WebUserInfo['lat'],$get_distance,$where);


            } else {	//纯地理降序
                //if($is_distance_order) {

                $count = $this->nearshop_count($WebUserInfo['long'],$WebUserInfo['lat'],'',$where);
                //} else{

                //	$count = D('')->table("Store as s")->where($where)->count("s.store_id");
                //}
            }




        }

        //echo $ss;
        return $count;
    }
    //
    /*
     * @description：			根据坐标获取离你最近的商铺
     * @param: $long:			坐标经度
     * @param: $lat:			坐标纬度
     * @param: $offest:			偏移量
     * @param: $limit:			限制条数
     * @param: $get_distance:	查找指定距离范围内的店铺数据  单位：km（注：没空或0，则不限距离）
     * @param: 补充搜索条件
     * */
    public function nearshops($long, $lat, $order, $sort="asc" , $offset="0", $limit = "10",$get_distance="",$wheres="") {
        $limit = $limit ? $limit : '12';
        //$order = $order ? $order : "`juli` ASC";
        $where = ""; $where2 = "";
        $WebUserInfo = show_distance();
        $db_prefix = option('system.DB_PREFIX');
        $order_juli = ""; $orders = "";
        if($order == 'juli') {
            $order_juli = " order by c.juli " . $sort;
        } else {
            $orders= " order by " .$order .' '. $sort;
        }
        $julis ="";

        if($get_distance) {
            $squares = returnSquarePoint($WebUserInfo['long'], $WebUserInfo['lat'],$get_distance);
            $where .= "and sc.lat<>0 and sc.lat>{$squares['right-bottom']['lat']} and sc.lat<{$squares['left-top']['lat']} and sc.long>{$squares['left-top']['lng']} and sc.long<{$squares['right-bottom']['lng']}";
            $get_distance = $get_distance*1000;
            $julis .= " where c.juli < ".$get_distance;
        }
        $sql = "select * from (select `s`.`store_id`, `s`.`name`, `s`.`logo`, `s`.`intro`,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli from " . $db_prefix . "store_contact as sc, " . $db_prefix . "store as s where ". $wheres ." s.status = 1 and sc.store_id = s.store_id ". $where . $orders ." ) as c " .$julis . $order_juli ."  limit {$offset},{$limit}"  ;
        $near_store_list = $this->db->query($sql);


        foreach ($near_store_list as $key => $value) {
            $value['url'] = option('config.wap_site_url') . '/home.php?id=' . $value['store_id'] . '&platform=1';
            $value['pcurl'] = url_rewrite('store:index', array('id' => $value['store_id']));

            if (empty($value['logo'])) {
                $value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
            } else {
                $value['logo'] = getAttachmentUrl($value['logo']);
            }
            //本地化二维码$near_store_list[$key]['qcode']  = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
            $near_store_list[$key]['qcode']  = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];	//微信端二维码

            $near_store_list[$key]['logo'] = $value['logo'];
            $near_store_list[$key]['url'] = $value['url'];
            $near_store_list[$key]['pcurl'] = $value['pcurl'];
        }
        return $near_store_list;
    }



    public function nearshops_new($long, $lat, $order, $sort="asc" , $offset="0", $limit = "10",$get_distance="",$wheres="") {
        $limit = $limit ? $limit : '12';
        //$order = $order ? $order : "`juli` ASC";
        $where = ""; $where2 = "";
        $WebUserInfo = show_distance();
        $db_prefix = option('system.DB_PREFIX');
        $order_juli = ""; $orders = "";
        if($order == 'juli') {
            $order_juli = " order by c.juli " . $sort;
        } else {
            $orders= " order by " .$order .' '. $sort;
        }
        $julis ="";



        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(option('config.lbs_distance_limit')) {
                //$this->db->field("`p`.*,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli");
                //$field = "count(p.product_id) as counts";
                if(is_array($where)) {
                    $where = implode(" and ",$where);
                }

                $where =  " having juli<".option('config.lbs_distance_limit')*1000;
                //$where = $where ." HAVING juli <=".option('config.lbs_distance_limit');
            }
        } else {
            if($WebUserInfo['city_name']) {
                if(!is_array($where)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $where = $where ? ($where ." and ".$where1 ) : $where1;
                } else {
                    $where[] = "  sc.city='".$WebUserInfo['city_code']."'";
                    $where = implode(" and ", $where);

                }
            }
        }


        if($get_distance) {
            $squares = returnSquarePoint($WebUserInfo['long'], $WebUserInfo['lat'],$get_distance);
            $where .= "and sc.lat<>0 and sc.lat>{$squares['right-bottom']['lat']} and sc.lat<{$squares['left-top']['lat']} and sc.long>{$squares['left-top']['lng']} and sc.long<{$squares['right-bottom']['lng']}";
            $get_distance = $get_distance*1000;
            $julis .= " where c.juli < ".$get_distance;
            $sql = "select * from (select `s`.`store_id`, `s`.`name`, `s`.`logo`, `s`.`intro`,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli from " . $db_prefix . "store_contact as sc left join " . $db_prefix . "store as s  On s.store_id=sc.store_id where ". $wheres . $where . $orders ." ) as c " .$julis . $order_juli ."  limit {$offset},{$limit}"  ;

        }	else {
            $sql = "select * from (select `s`.`store_id`, `s`.`name`, `s`.`logo`, `s`.`intro`,`sc`.`long`,`sc`.`lat`, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli from " . $db_prefix . "store as s left join " . $db_prefix . "store_contact as sc  On s.store_id=sc.store_id where ". $wheres . $where . $orders ." ) as c " .$julis . $order_juli ."  limit {$offset},{$limit}"  ;
        }


        $near_store_list = $this->db->query($sql);


        foreach ($near_store_list as $key => $value) {
            $value['url'] = option('config.wap_site_url') . '/home.php?id=' . $value['store_id'] . '&platform=1';
            $value['pcurl'] = url_rewrite('store:index', array('id' => $value['store_id']));

            if (empty($value['logo'])) {
                $value['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
            } else {
                $value['logo'] = getAttachmentUrl($value['logo']);
            }
            //本地化二维码$near_store_list[$key]['qcode']  = $value['qcode'] ?  getAttachmentUrl($value['qcode']) : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];
            $near_store_list[$key]['qcode']  = $value['qcode'] ?  $value['qcode'] : option('config.site_url')."/source/qrcode.php?type=home&id=".$value['store_id'];	//微信端二维码

            $near_store_list[$key]['logo'] = $value['logo'];
            $near_store_list[$key]['url'] = $value['url'];
            $near_store_list[$key]['pcurl'] = $value['pcurl'];
        }
        return $near_store_list;
    }


    /*首页指定范围内容的店铺数量
     *@param: 当前用户的 经度
     *@param: 当前用户的维度
     *@param: 指定公里数 单位（km） 默认：10
     */
    public function nearshop_count($long,$lat,$get_distance="" , $wheres="") {
        $where2 = ""; $julis = "";
        //if($get_distane) $where2 = " AND juli < '".$get_distane."' ";
        if($get_distance) {
            $get_distance = $get_distance*1000;
            $julis = " where c.juli < ".$get_distance;
        }
        $db_prefix = option('system.DB_PREFIX');

        $WebUserInfo = show_distance();
        if($WebUserInfo['long']) {
            $long = $WebUserInfo ['long'];
            $lat = $WebUserInfo ['lat'];
            if(is_array($wheres)) {
                $wheres = implode(" and ", $wheres);
            }
            if(option('config.lbs_distance_limit')) {
                $has_limit_distance = " HAVING juli <=".option('config.lbs_distance_limit')*1000;
            }
        } else {
            if($WebUserInfo['city_name']) {
                if(!is_array($wheres)) {
                    $where1 = "sc.city=".$WebUserInfo['city_code'];
                    $wheres = $wheres ? ($wheres ." and ".$where1 ) : $where1;
                } else {
                    $wheres[] = " s.status=1 and p.quantity > 0 and sc.city='".$WebUserInfo['city_code']."'";
                    $wheres = implode(" and ", $wheres);

                }
            }
        }

        //$wheres =  $wheres ? ($wheres." and "):$wheres;
        $wheres1 = $wheres;

        $wheres = $wheres ? " where".$wheres:'';


        if($has_limit_distance) {
            $wheres = $wheres.$has_limit_distance;
        }

        if($get_distance) {
            $sql = "select count(c.juli) as count from (select ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli from " . $db_prefix . "store as s left join " . $db_prefix . "store_contact as sc  On s.store_id=sc.store_id". $wheres ." ) as c ".$julis ;
        } else {
            $sql = "select count(c.store_id) as count from (select s.store_id,ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN(({$lat}*PI()/180-`sc`.`lat`*PI()/180)/2),2)+COS({$lat}*PI()/180)*COS(`sc`.`lat`*PI()/180)*POW(SIN(({$long}*PI()/180-`sc`.`long`*PI()/180)/2),2)))*1000) AS juli from " . $db_prefix . "store as s left join " . $db_prefix . "store_contact as sc  On s.store_id=sc.store_id". $wheres ." ) as c ".$julis ;
        }

        $arr = $this->db->query($sql);

        $count = $arr[0]['count']?$arr[0]['count']:0;
        return  $count;
    }

    /*分销商排名*/
    public function getSellersRank($where, $offset = 0, $limit = 0, $startTime, $endTime)
    {
        if(!empty($startTime) && !empty($endTime))
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') . 'store WHERE income > 0 and date_edited >' .$startTime . ' and date_edited < '. $endTime;
        }
        else
        {
            $sql = "SELECT * FROM " . option('system.DB_PREFIX') .'store WHERE income > 0';
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

        $sql .= ' ORDER BY income DESC';

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
            $sql = "SELECT count(store_id) as storeId FROM " . option('system.DB_PREFIX') .'store WHERE income > 0 and date_edited >' .$startTime . ' and date_edited < '. $endTime;
        }
        else
        {
            $sql = "SELECT count(store_id) as storeId FROM " . option('system.DB_PREFIX') .'store WHERE income > 0';
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

        $sql .= ' ORDER BY income DESC';

        $ranks = $this->db->query($sql);

        return !empty($ranks[0]['storeId']) ? $ranks[0]['storeId'] : 0;
    }

    public function getSellerCountBySales($where, $drp_supplier_id = 0)
    {
        $sql = "SELECT COUNT(s.store_id) as sellers FROM " . option('system.DB_PREFIX') . "store s," . option('system.DB_PREFIX') . "store_supplier ss WHERE s.store_id = ss.seller_id AND s.store_id = ss.seller_id AND ss.type = 1";
        if (!empty($where)) {
            if (empty($drp_supplier_id)) {
                if (!empty($where['store_id'])) {
                    $sql .= " AND s.root_supplier_id = '" . $where['store_id'] . "'";
                    unset($where['store_id']);
                } else {
                    $sql .= " AND s.root_supplier_id = '" . $_SESSION['store']['store_id'] . "'";
                }
            } else {
                if (!empty($where['store_id'])) {
                    $sql .= " AND FIND_IN_SET(" . $where['store_id'] . ", ss.supply_chain)";
                    unset($where['store_id']);
                } else {
                    $sql .= " AND FIND_IN_SET(" . $_SESSION['store']['store_id'] . ", ss.supply_chain)";
                }
            }
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '%" . $value['like'] . "%'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    } else {
                        $sql .= " AND " . $key . " $value[0] '" . $value[1] . "'";
                    }
                } else if ($key == '_string') {
                    $sql .= " AND " . $value;
                } else {
                    $sql .= " AND " . $key . "=" . $value;
                }
            }
        }
        $sales = $this->db->query($sql);
        return !empty($sales[0]['sellers']) ? $sales[0]['sellers'] : 0;
    }

    public function getSellersBySales($where,$order_by = 'dt.pigcms_id DESC', $offset = 0, $limit = 0)
    {
        $sql = "select *,s.status as store_status, s.store_id as fx_store_id, s.logo as store_logo, s.sales as store_sales,s.name as store_name ,team.name as team_name from " . option('system.DB_PREFIX') . "store as s left join " . option('system.DB_PREFIX') . "store_supplier as ss on s.store_id = ss.seller_id left join " . option('system.DB_PREFIX') . "drp_team as team on s.drp_team_id = team.pigcms_id where s.store_id = ss.seller_id AND ss.type = 1";
        if (!empty($where)) {
            if (!empty($where['store_id'])) {
                $sql .= " AND FIND_IN_SET(" . $where['store_id'] . ", ss.supply_chain)";
                unset($where['store_id']);
            } else {
                $sql .= " AND FIND_IN_SET(" . $_SESSION['store']['store_id'] . ", ss.supply_chain)";
            }
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '%" . $value['like'] . "%'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    } else {
                        $sql .= " AND " . $key . " $value[0] '" . $value[1] . "'";
                    }
                } else if ($key == '_string') {
                    $sql .= " AND " . $value;
                } else {
                    $sql .= " AND " . $key . "=" . $value;
                }
            }
        }

        $sql .= " ORDER BY " . $order_by . " LIMIT " . $offset . ", " . $limit;

        $ranks = $this->db->query($sql);
        return $ranks;
    }

    public function getSellerBySales($where, $startTime, $endTime)
    {
        if(!empty($startTime) && !empty($endTime)) {
            $sql = "SELECT (SELECT CONCAT(SUM(o.total),'-', COUNT(o.order_id)) FROM " . option('system.DB_PREFIX') . "order o WHERE o.store_id = s.store_id AND o.is_fx = 1 AND o.status in (2,3,4,7) AND o.paid_time >= " . $startTime . " AND o.paid_time <= " . $endTime . ") AS sales FROM " . option('system.DB_PREFIX') . 'store s, ' . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id AND FIND_IN_SET(' . $_SESSION['store']['store_id'] . ', ss.supply_chain) AND s.drp_approve = 1';
        } else if (!empty($startTime)) {
            $sql = "SELECT (SELECT CONCAT(SUM(o.total),'-', COUNT(o.order_id)) FROM " . option('system.DB_PREFIX') . "order o WHERE o.store_id = s.store_id AND o.is_fx = 1 AND o.status in (2,3,4,7) AND o.paid_time >= " . $startTime . ") AS sales FROM " . option('system.DB_PREFIX') . 'store s, ' . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id AND FIND_IN_SET(' . $_SESSION['store']['store_id'] . ', ss.supply_chain) AND s.drp_approve = 1';
        } else if (!empty($endTime)) {
            $sql = "SELECT (SELECT CONCAT(SUM(o.total),'-', COUNT(o.order_id)) FROM " . option('system.DB_PREFIX') . "order o WHERE o.store_id = s.store_id AND o.is_fx = 1 AND o.status in (2,3,4,7) AND o.paid_time <= " . $endTime . ") AS sales FROM " . option('system.DB_PREFIX') . 'store s, ' . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id AND FIND_IN_SET(' . $_SESSION['store']['store_id'] . ', ss.supply_chain) AND s.drp_approve = 1';
        } else {
            $sql = "SELECT (SELECT CONCAT(SUM(o.total),'-', COUNT(o.order_id)) FROM " . option('system.DB_PREFIX') . "order o WHERE o.store_id = s.store_id AND o.is_fx = 1 AND o.status in (2,3,4,7)) AS sales FROM " . option('system.DB_PREFIX') . 'store s, ' . option('system.DB_PREFIX') . 'store_supplier ss WHERE s.store_id = ss.seller_id AND FIND_IN_SET(' . $_SESSION['store']['store_id'] . ', ss.supply_chain) AND s.drp_approve = 1';
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

        $ranks = $this->db->query($sql);
        return $ranks;
    }

    //获取我的供货商
    public function getMySupplierList($where, $offset = 0, $limit = 0, $distributor_id)
    {
        $sql = "SELECT * FROM " . option('system.DB_PREFIX') . "store as s," . option('system.DB_PREFIX') . "supp_dis_relation as supp where s.store_id = supp.supplier_id and distributor_id={$distributor_id}";

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
            if ($limit) {
                $sql .= ' LIMIT ' . $offset . ',' . $limit;
            }
        }
        $supplierList = $this->db->query($sql);
        return $supplierList;
    }

    //获取我的供货商数
    public function getSupplierCount($where, $distributor_id)
    {
        $sql = "SELECT count(s.store_id) as storeId FROM " . option('system.DB_PREFIX') . "store as s," . option('system.DB_PREFIX') . "supp_dis_relation as supp where s.store_id = supp.supplier_id and supp.distributor_id={$distributor_id}";

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

        $supplierCount = $this->db->query($sql);

        return !empty($supplierCount[0]['storeId']) ? $supplierCount[0]['storeId'] : 0;
    }


    public function getStoreList($where, $field=true,$orderby="", $offset="0", $limit="0"){
        if($orderby)$this->db->order($orderby);
        if($limit) $this->db->limit($offset . ',' . $limit);
        $stores = $this->db->where($where)->field($field)->select();
        return $stores;
    }

    //由分销store_id 调取供货商
    public function getSupplier($seller_id)
    {
        $store_supplier = D('Store_supplier')->where(array('seller_id' => $seller_id))->find();
        $supply_chain = $store_supplier['supply_chain'];
        $supply_chain = explode(',', $supply_chain);
        $supplier_id = !empty($supply_chain[1]) ? $supply_chain[1] : $store_supplier['supplier_id'];
        $supplier = $this->getStore($supplier_id);
        return $supplier;
    }



    //自身是(供货/分销)  获取供货商店铺信息，
    public function getSuppliers($seller_id) {
        $store_supplier = D('Store_supplier')->where(array('seller_id' => $seller_id))->find();
        $supply_chain = $store_supplier['supply_chain'];
        $supply_chain = explode(',', $supply_chain);
        //$supplier_id = !empty($supply_chain[1]) ? $supply_chain[1] : $store_supplier['supplier_id'];
        if($supply_chain[1]) {
            $supplier_id = $supply_chain[1];
            $supplier = $this->getStore($supplier_id);
            $supplier['fx_info'] = $this->getStore($seller_id);
        } else {
            $supplier = $this->getStore($seller_id);
        }
        return $supplier;
    }


    /*
      * 获取用户 关注的这个店铺信息
      * 无uid 是 店铺用户本身
      */
    public function getStoreBySub($store_id,$uid="") {
        if($uid) {
            $store = $this->db->table("Store s")->join("Subscribe_store ss ON s.store_id = ss.store_id")->where("s.store_id='".$store_id."' and s.status='1' and ss.uid='".$uid."'")->field("s.*, ss.openid sub_openid, ss.uid sub_uid")->find();
            if(!empty($store)){
                $store['url'] = option('config.wap_site_url').'/home.php?id='.$store['store_id'];
                if(empty($store['logo'])) {
                    $store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
                } else {
                    $store['logo'] = getAttachmentUrl($store['logo']);
                }
                $store['qcode'] = $store['qcode'] ?  $store['qcode'] : "/source/qrcode.php?type=home&id=".$store['store_id'];	//微信端临时二维码
                $store['ucenter_url'] = option('config.wap_site_url').'/ucenter.php?id='.$store['store_id'];
            }

            return $store;
        } else {
            $store = D('Store')->where(array('store_id'=>$store_id))->find();
            $store['sub_openid'] =$store['openid'];
            $store['sub_uid'] = $store['uid'];

            return $store;
        }
    }

    //我的分销商
    public function sellers($where, $offset = 0, $limit = 0, $supplier_id = 0)
    {
        //$sql = "SELECT *,s.status,s.drp_profit as profit,s.name FROM " . option('system.DB_PREFIX') . "store as s left join " . option('system.DB_PREFIX') . "store_supplier as ss on s.store_id = ss.seller_id  WHERE  and drp_level > 0 and FIND_IN_SET($supplier_id,supply_chain) ";
        $sql = "select *,team.name as team_name, s.store_id as fx_store_id, s.logo as store_logo, s.name as store_name,s.sales as store_sales, s.status as store_status from pigcms_store s left join " . option('system.DB_PREFIX') . "drp_degree dd on s.drp_degree_id = dd.pigcms_id left join " . option('system.DB_PREFIX') . "drp_team as team on s.drp_team_id=team.pigcms_id where s.root_supplier_id = {$supplier_id} AND s.drp_level > 0 ";

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                }else if($key == '_string'){
                    $sql .= "AND " . $value;
                }else if($key != '_string'){
                    $sql .= " AND " . $key . "=" . "'".$value."'";
                }
            }
        }

        $sql .= ' ORDER BY s.date_added DESC';
        if ($limit) {
            $sql .= ' LIMIT ' . $offset . ',' . $limit;
        }

        $sellers = $this->db->query($sql);
        foreach ($sellers as &$tmp) {
            $tmp['logo'] = getAttachmentUrl($tmp['logo']);
        }
        return $sellers;
    }

    //我的分销商数 （分页）
    public function seller_count($where,$supplier_id = 0)
    {
        //$sql = "SELECT count(s.drp_profit) AS sellers FROM " . option('system.DB_PREFIX') . "store s, " . option('system.DB_PREFIX') . "store_supplier ss,".option('system.DB_PREFIX')."platform_drp_degree as pp WHERE s.store_id = ss.seller_id and s.drp_degree_id = pp.pigcms_id and drp_level > 0 and FIND_IN_SET($supplier_id,supply_chain) ";
        $sql = "select count(s.store_id) as store_id from pigcms_store s left join " . option('system.DB_PREFIX') . "drp_degree dd on s.drp_degree_id = dd.pigcms_id left join " . option('system.DB_PREFIX') . "drp_team as team on s.drp_team_id=team.pigcms_id where s.root_supplier_id = {$supplier_id} AND s.drp_level > 0 ";
        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    if (array_key_exists('like', $value)) {
                        $sql .= " AND " . $key . " like '" . $value['like'] . "'";
                    } else if (array_key_exists('in', $value)) {
                        $sql .= " AND " . $key . " in (" . $value['in'] . ")";
                    }
                }else if($key == '_string'){
                    $sql .= "AND " . $value;
                }else if($key != '_string'){
                    $sql .= " AND " . $key . "=" . "'".$value."'";
                }
            }
        }
        $sellers = $this->db->query($sql);
        return !empty($sellers[0]['store_id']) ? $sellers[0]['store_id'] : 0;
    }

    /**
     * 平台积分
     * @param $store_id
     * @return int
     */
    public function getPoint($store_id)
    {
        $store = D('Store')->field('point_balance')->where(array('store_id' => $store_id))->find();
        return !empty($store['point_balance']) ? $store['point_balance'] : 0;
    }

    /**
     * 更新平台积分
     * @param $store_id
     * @param $point
     * @return bool|int
     */
    public function setPointDec($store_id, $point)
    {
        return D('Store')->where(array('store_id' => $store_id))->setDec('point_balance', $point);
    }


    /**
     * 判断是否关注
     * @param $store_id
     * @param $point
     * @return bool|int
     */
    public function is_subscribe_store($uid,$store_id)
    {
        if ($uid && $store_id) {

            $where  = array('uid'=>$uid, 'openid' => array('!=','""'), 'store_id' => $store_id, 'subscribe_time' => array('>',0),'is_leave'=>0);
            $is_sub = D('Subscribe_store')->where($where)->find();

            if ($is_sub) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
     * 获取引导关注二维码
     * @param $store_id
     * @return array
     */
    public function get_subscribe_qrcode($store_id,$product='')
    {
        $store_info = $this->getStore($store_id);

        //记录商品和店铺的关系、
        $store_product 	= D('Fx_store_product')->where(array('store_id'=>$store_id,'product_id'=>$product['product_id']))->find();
        if (empty($store_product)) {
            $data 	= array(
                'store_id' 		=> $store_id,
                'product_id' 	=> $product['product_id'],
            );
            $store_product['id'] 	= D('Fx_store_product')->data($data)->add();
        }
        /* 获取顶级供货商 */
        if ($store_info['drp_level'] > 0) {
            $supplier_root = D('Store')->field('root_supplier_id')->where(array('store_id'=>$store_info['store_id']))->find();
            $root_supplier_id = $supplier_root['root_supplier_id'];
        } else if($store_info['drp_level'] == 0) {
            $root_supplier_id = $store_info['store_id'];
        }

        /* 供货商店铺是否绑定公众号 */
        $is_bind = D('Weixin_bind')->where(array('store_id'=>$root_supplier_id))->find();

        //商品详情页关注
        if ($is_bind && ($is_bind['service_type_info'] == 2 && $is_bind['verify_type_info'] != '-1') && $product) {
            if ($product['after_subscribe_discount'] > 0) {
                $tmp_id 	= 600000000+$store_product['id'];
                $qrcode 	= M('Recognition')->get_bind_tmp_qrcode($tmp_id,$root_supplier_id);
                return array('error_code'=>0,'qrcode'=>$qrcode['ticket']);
            } else {
                return array('error_code'=>1001,'error_msg'=>'商品未设置折扣');
            }

            //预留
        } else if($is_bind && ($is_bind['service_type_info'] == 2 && $is_bind['verify_type_info'] != '-1')) {

            //非认证服务号引导关注
        } else if ($is_bind) {
            return array('error_code'=>1002,'error_msg'=>'商家绑定非认证服务号');
            //return array('error_code'=>0,'qrcode'=>$is_bind['qrcode_url']);
            //未做任何绑定
        } else {
            return array('error_code'=>1000,'error_msg'=>'商家未绑定公众号');
        }

    }

    /**
     * 获取活动页面引导关注二维码
     * @param $activity_id
     * @param int $type 1=>砍价活动
     * @return array
     */
    public function get_activity_subscribe_qrcode($activity_id,$type=1){
        if($type==1){
            $activity_info = D('Bargain')->where(array('pigcms_id'=>$activity_id))->find();
        }

        /* 供货商店铺是否绑定公众号 */
        $is_bind = D('Weixin_bind')->where(array('store_id'=>$activity_info['store_id']))->find();

        //获取活动商品信息
        $product = D('Product')->where(array('product_id'=>$activity_info['product_id']))->find();

        //活动页面关注
        if ($is_bind && ($is_bind['service_type_info'] == 2 && $is_bind['verify_type_info'] != '-1') && $product) {
            if (!empty($activity_info)) {
                $tmp_id 	= 700000000 + $type*10000000 + $activity_info['id'];
                $qrcode 	= M('Recognition')->get_bind_tmp_qrcode($tmp_id,$activity_info['store_id']);
                return array('error_code'=>0,'qrcode'=>$qrcode['ticket']);
            } else {
                return array('error_code'=>1001,'error_msg'=>'没有找个活动详细信息');
            }

            //预留
        } else if($is_bind && ($is_bind['service_type_info'] == 2 && $is_bind['verify_type_info'] != '-1')) {

            //非认证服务号引导关注
        } else if ($is_bind) {
            return array('error_code'=>1002,'error_msg'=>'商家绑定非认证服务号');
            //return array('error_code'=>0,'qrcode'=>$is_bind['qrcode_url']);
            //未做任何绑定
        } else {
            return array('error_code'=>1000,'error_msg'=>'商家未绑定公众号');
        }
    }

    /**
     * 图片推广及相关活动需要生成临时二维码
     * @param $scene_id        场景id
     * @param $uid             用户id (参与者)
     * @param $store_id        店铺id
     * @param string $type     类型 (1 店铺推广 2 活动)
     * @param string $act_type 活动类型 [ seckill(秒杀) bargain(砍价) unitary(一元夺宝) lottery(活动合集).... ]
     * @param string $act_id   活动id
     * @param string $help_uid 帮助者用户id (如果是活动)
     * @return array     微信二维码 (由场景值加新增id生成)
     */
    public function concernRelationship($scene_id, $uid, $store_id, $type = '1', $act_type = '', $act_id = '', $help_uid = '')
    {
        //获取供货商
        $supplier_id = '';
        $qrcode_id = ''; //生成临时二维码参数值
        if ($store_id) {
            $storeInfo = D('Store')->where(array('store_id'=>$store_id))->find();
            if($storeInfo['drp_level']>0) {
                $supplier_id = $storeInfo['root_supplier_id'];
            } elseif (empty($storeInfo['drp_level'])) {
                $supplier_id = $store_id;
            }
        }

        $data['uid'] = $uid;
        $data['store_id'] = $store_id;
        $data['type'] = $type;
        $data['act_type'] = $act_type;
        $data['supplier_id'] = $supplier_id;
        $data['act_id'] = $act_id;
        $data['help_uid'] = $help_uid;
        $data['add_time'] = time();

        if($type == 1){  //店铺推广
            $isset = D('Concern_relationship')->where(array('uid'=>$uid,'store_id'=>$store_id,'type'=>1))->find();
            if($isset){
                $qrcode_id = $scene_id + $isset['pigcms_id'];
            } else {
                $result = D('Concern_relationship')->data($data)->add();
                $qrcode_id = $scene_id + $result;
            }
        } elseif ($type == 2){  //活动
            $act = D('Concern_relationship')->where(array('uid'=>$uid,'store_id'=>$store_id,'type'=>$type,'act_type'=>$act_type,'act_id'=>$act_id,'help_uid'=>$help_uid))->find();

            if($act){
                $qrcode_id = $scene_id + $act['pigcms_id'];
            } else {
                $result = D('Concern_relationship')->data($data)->add();
                $qrcode_id = $scene_id + $result;
            }
        } elseif ($type == 'other'){
            //其他类型
        }

        if ($scene_id) {
            /* 供货商店铺是否绑定公众号 */
            $is_bind = D('Weixin_bind')->where(array('store_id'=>$supplier_id))->find();
           if ($is_bind && ($is_bind['service_type_info'] == 2 && $is_bind['verify_type_info'] != '-1')) {

                import('Http');
                $http = new Http();
                import('WechatApi');
                $result = M('Weixin_bind')->get_access_token($supplier_id);

                $qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$result['access_token'];

                $post_data['expire_seconds'] = 604800;
                $post_data['action_name'] = 'QR_SCENE';
                $post_data['action_info']['scene']['scene_id'] = $qrcode_id;

                $json = $http->curlPost($qrcode_url,json_encode($post_data));
                if (!$json['errcode']){
                    return(array('error_code'=>0,'id'=>$qrcode_id,'ticket'=>'http://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
                }else{
                    return(array('error_code'=>1001,'msg'=>'产生二维码发生错误。发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
                }
            } else if ($is_bind) {
                return(array('error_code'=>1002,'msg'=>'商家绑定非认证服务号'));
            } else if (empty($is_bind)) {
                return(array('error_code'=>1003,'msg'=>'商家未绑定公众号'));
            }
        }
    }
}