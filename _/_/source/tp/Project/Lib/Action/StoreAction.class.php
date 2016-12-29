<?php

/**
 * 店铺
 * User: pigcms_21
 * Date: 2015/3/18
 * Time: 20:02
 */
class StoreAction extends BaseAction {
    public $synType     = 'weidian';
    public function index() {
        $store = D('StoreView');
        $sale_category_model = M('SaleCategory');
        $store_withdrawal = D('StoreWithdrawalView');
        $platform_income  = D('PlatformIncome');

        $searchcontent = $this->_request('searchcontent','trim,urldecode');
        if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);

        }

        $type = empty($type) ? $this->_get('type', 'trim') : trim($type);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
        $store_type = empty($store_type) ? $this->_get('store_type', 'trim') : trim($store_type);
        $sale_category = empty($sale_category) ? $this->_get('sale_category', 'trim') : trim($sale_category);
        $approve = !in_array($approve, array('0','1','2','3')) ? $this->_get('approve', 'trim') : trim($approve);
        $status = empty($status) ? $this->_get('status', 'trim') : trim($status);

       
        $province = empty($province) ? $this->_get('province', 'trim') : trim($province);
        $city = empty($city) ? $this->_get('city', 'trim') : trim($city);
        $county = empty($county) ? $this->_get('county', 'trim') : trim($county);

        $condition = array();
        if (!empty($type) && !empty($keyword)) {
            if ($type == 'store_id') {
                $condition['Store.store_id'] = trim($keyword);
            } else if ($type == 'user') {
                $condition['User.nickname'] = array('like', '%' . trim($keyword) . '%');
            } else if ($type == 'account') {
                $condition['User.phone'] = array('like', "%" . trim($keyword));
            } else if ($type == 'name') {
                $condition['Store.name'] = array('like', '%' . trim($keyword) . '%');
            } else if ($type == 'tel') {
                $condition['Store.tel'] = array('like', '%' . trim($keyword));
            }
        }

        if (!empty($store_type)) {
            if ($store_type == 1) {
                $condition['Store.drp_supplier_id'] = 0;
            } else {
                $condition['Store.drp_supplier_id'] = array('gt', 0);
            }
        }

        if (!empty($sale_category)) {
            $condition['_string'] = "(Store.sale_category_id = '" . $sale_category . "' OR Store.sale_category_fid = '" . $sale_category . "')";
        }

        if (isset($approve) && is_numeric($approve)) {
            $condition['approve'] = $approve;
        }
        if (isset($status) && is_numeric($status)) {
            $condition['status'] = $status;
        }

        if (isset($province) && is_numeric($province)) {
            $condition['province'] = $province;
        }

        if (isset($city) && is_numeric($city)) {
            $condition['city'] = $city;
        }

        if (isset($county) && is_numeric($county)) {
            $condition['county'] = $county;
        }

        // 区域管理员 只能查看自己区域的店铺
        if ($this->admin_user['type'] == 2) {
            $store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
            if (!empty($store_ids)) {
                $condition['store_id'] = array('in', $store_ids);
            } else {
                $condition['store_id'] = false;
            }
        } else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
            $store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
            if (!empty($store_ids)) {
                $condition['store_id'] = array('in', $store_ids);
            } else {
                $condition['store_id'] = false;
            }
        }

        $store_count = $store->where($condition)->count();
        
        $download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$store_count);
            echo json_encode($return);exit;
        }

        if($download == 1) {
            $stores = $store->where($condition)->order("Store.store_id DESC")->select();
            
             import('Xls','./source/class');
             $filename = '店铺信息';
             $fields = array('编号','店铺名称','主营类目','可提现余额(元)','待结算余额(元)','待处理提现(元)','平台保证金(元)','店铺积分(元)','综合展示','认证','状态','创建时间');
             $data = array();
            
             foreach ($stores as $key => $value) {
                $tmp_public_display = ($value['public_display'] == 1)?'正常展示':'已经关闭';
               
                if($value['approve'] == 1){
                     $tmp_approve = '已认证';
                }else if($value['approve'] == 2){
                    $tmp_approve = '认证中';
                }else if($value['approve'] == 3){
                    $tmp_approve = '认证不通过';
                }else{
                    $tmp_approve = '未认证';
                }

                if($value['status'] == 1){
                    $tmp_status = '正常';
                }else if($value['status'] == 2){
                    $tmp_status = '待审核';
                }else if($value['status'] == 3){
                    $tmp_status = '关闭或审核失败';
                }else if($value['status'] == 4){
                     $tmp_status = '用户关闭';
                }else if($value['status'] == 5){
                     $tmp_status = '供货商关闭';
                }

                $data[$key] = array($value['store_id'],$value['name'],$value['category'],$value['balance'],$value['unbalance'],$value['unwithdrawal_amount'],$value['margin_balance'],$value['point_balance'],$tmp_public_display,$tmp_approve,$tmp_status,date('Y-m-d H:i:s',$value['date_added']));
             }

             Xls::download_csv($filename,$fields,$data);


        }

        import('@.ORG.system_page');
        $page = new Page($store_count, 10);
        $stores = $store->where($condition)->order("Store.store_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
        if (!empty($stores)) {
            foreach ($stores as &$tmp_store) {
                $tmp_store['unwithdrawal_amount'] = '0.00';
                $tmp_store['service_fee']         = '0.00';
                if (empty($tmp_store['drp_supplier_id'])) {
                    $tmp_store['withdrawal_amount'] = $tmp_store['withdrawal_amount'];
                    //待处理提现
                    $where = array();
                    $where['store_id'] = $tmp_store['store_id'];
                    $where['type']     = 1;
                    $where['status']   = array('in', array(1,2));
                    $unwithdrawal_amount = $store_withdrawal->getAmount($where);
                    $tmp_store['unwithdrawal_amount'] = number_format($unwithdrawal_amount, 2, '.', '');
                    //平台服务费
                    $service_fee = $platform_income->getServiceFee($tmp_store['store_id']);
                    $tmp_store['service_fee'] = number_format($service_fee, 2, '.', '');
                }
                if (!empty($tmp_store['drp_supplier_id'])) {
                    $tmp_store['type'] = '<span style="display: inline-block;background-color: #f60;padding:2px;border-radius: 2px;color:white">分销商</span>';
                } else {
                    $tmp_store['type'] = '<span style="display: inline-block;background-color: #07d;padding:2px;border-radius: 2px;color:white;">供货商</span>';
                }
            }
        }

        $sale_categories = $sale_category_model->where(array('status' => 1))->select();

        //未处理的提现记录
        $withdrawal = M('StoreWithdrawal');
        $withdrawal_count = $withdrawal->where(array('status' => 1, 'supplier_id'=>0))->count('pigcms_id');

        $this->assign('stores', $stores);
        $this->assign('page', $page->show());
        $this->assign('sale_categories', $sale_categories);
        $this->assign('withdrawal_count', $withdrawal_count);
        $this->display();
    }

    //
    public function detail() {
        $store = D('StoreView');
        $bank = M('Bank');
        $database_store = D('Store');

        $store_id = $this->_get('id', 'trim,intval');
        $this->checkStore($store_id);   // 区域/管理员访问权限

        $store = $store->where(array('Store.store_id' => $store_id))->find();
        if (!empty($store['logo'])) {
            $store['logo'] = getAttachmentUrl($store['logo']);
        } else {
            $store['logo'] = getAttachmentUrl('images/default_shop_2.jpg', false);
        }
        if (!empty($store['store_pic'])) {
            $store['store_pic'] = getAttachmentUrl($store['store_pic']);
        } else {
            $store['store_pic'] = getAttachmentUrl('images/default_shop_2.jpg', false);
        }

        $bank = $bank->where(array('status' => 1))->field('bank_id,name')->select();
        $store['bank_arr'] = $bank;

        // 区域
        $area = array();
        if ($store_contact = D("Store_contact")->where(array("store_id"=>$store_id))->find()) {

            $area['user'] = array(
                'province' => $store_contact['province'],
                'city' => $store_contact['city'],
                'county' => $store_contact['county'],
            );

            import('area', './source/class');
            $areaClass = new area();
            $area['user']['province_txt'] = $areaClass->get_name($store_contact['province']);
            $area['user']['city_txt'] = $areaClass->get_name($store_contact['city']);
            $area['user']['county_txt'] = $areaClass->get_name($store_contact['county']);

        }

        if ($store_area_record = D("Store_area_record")->where(array("store_id"=>$store_id, 'status'=>1))->find()) {
            $area['admin'] = array(
                'province' => $store_area_record['province'],
                'city' => $store_area_record['city'],
                'county' => $store_area_record['county'],
            );
        }

        //获取区域经理信息
        $adminInfo = $this->getAreaAdminInfo($store_area_record['province'],$store_area_record['city'],$store_area_record['county']);
        $store['area_name'] = isset($adminInfo['realname'])?$adminInfo['realname']:'姓名未填写';
        $store['area_avatar'] = isset($adminInfo['avatar'])?getAttachmentUrl($adminInfo['avatar']):getAttachmentUrl('images/default_shop_2.jpg', false);;

        //获取客户经理信息
        $database_admin = D('Admin');
        $agent_list = $database_admin->where(array('type'=>3))->select();
        if (empty($agent_list)) {
            //$this->frame_error_tips("缺少客户经理(代理商)，请先创建");
        }

        //店铺绑定客户经理信息
        $database_user = D('User');
        $result = $database_user->where(array('uid'=>$store['uid']))->field('invite_admin')->find();
        $store['invite_admin'] = $result['invite_admin'];

        //店铺合同信息
        $data_contract = $database_store->where(array("store_id"=>$store_id))->field('contract')->find();
        $contract_info = json_decode($data_contract['contract']);

        if(IS_POST){
            $store_id = $this->_post('id', 'trim,intval');
            //更新银行账户信息
            $bankdata = array(
                'withdrawal_type' => $_POST['withdrawal_type'],
                'bank_id' => $_POST['bank_id'],
                'bank_card' => $_POST['bank_card'],
                'bank_card_user' => $_POST['bank_card_user']
            );

            $sales_ratio = $this->_post('sales_ratio');
            if($sales_ratio > 100 || !is_numeric($sales_ratio)){
                //$this->frame_error_tips('比例必须是小于100的数字');
                $this->error('比例必须是小于100的数字');
            }else{
                $bankdata['sales_ratio'] = $sales_ratio;
            }


            //更新门头照信息
            if($_FILES['pic']['error'] != 4){
                //上传图片
                $rand_num = date('Y/m',$_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/adver/'.$rand_num.'/';
                if(!is_dir($upload_dir)){
                    mkdir($upload_dir,0777,true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10*1024*1024;
                $upload->allowExts = array('jpg','jpeg','png','gif');
                $upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if($upload->upload()){
                    $uploadList = $upload->getUploadFileInfo();

                    $attachment_upload_type = C('config.attachment_upload_type');
                    // 上传到又拍云服务器
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/adver/' . $rand_num.'/'.$uploadList[0]['savename'], '/adver/' . $rand_num.'/'.$uploadList[0]['savename']);
                    }

                    $bankdata['store_pic'] = 'adver/' . $rand_num.'/'.$uploadList[0]['savename'];
                }else{
                    $this->error($upload->getErrorMsg());
                }
            }
            D('Store')->where(array('store_id'=>$store_id))->data($bankdata)->save();

            //更新客户经理信息
            $userdata['invite_admin'] = $_REQUEST['invite_admin'];
            $database_user->where(array('uid'=>$store['uid']))->data($userdata)->save();

            //更新合同信息
            $contract = $_REQUEST['contract'];
            $contdata['contract'] = json_encode($contract);
            D('Store')->where(array('store_id'=>$store_id))->data($contdata)->save();

            // 限制权限
            if ($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) {
                $this->frame_error_tips("区域管理或客户经理(代理商)无修改权限");
            }

            $data['province'] = $this->_post('province', 'trim');
            $data['city'] = $this->_post('city', 'trim');
            $data['county'] = $this->_post('county', 'trim');

            if (empty($store_id) || !$store = D('Store')->where(array('store_id'=>$store_id))->find()) {
                $this->frame_error_tips('参数错误');
            }

            if ($store_area_record = D("StoreAreaRecord")->where(array('store_id'=>$store_id, 'status'=>1))->find()) {
                D("StoreAreaRecord")->where(array("pigcms_id"=>$store_area_record["pigcms_id"]))->data(array("status"=>0))->save();
            }

            $data_add = array(
                'store_id' => $store_id,
                'province' => $data['province'],
                'city' => $data['city'],
                'county' => $data['county'],
                'creator' => $this->admin_user['id'],
                'status' => 1,
                'add_time' => time(),
            );

            $result = D("StoreAreaRecord")->data($data_add)->add();

            $this->frame_main_ok_tips("修改成功", 0);
        }
        
		//yfz@20160707入住信息查询
		$contact = D("store_contact")->where(array('store_id'=>$store_id))->find();
		 $this->assign('contact', $contact);
        //店铺特色类别
        $this->store_tags = M('store_tag')->where(array('status'=>1))->order('order_by asc')->select();

        $this->assign('agent_list', $agent_list);
        $this->assign('contract_info', $contract_info);
        $this->assign('store', $store);
        $this->assign('area', $area);
        $this->display();
    }

    public function certification_detail() {
        $diy_attestation_list = D('diy_attestation')->select();
        $store_id = $_GET['id'];
        $where['store_id'] = $store_id;
        $certification_info = M('Certification')->where($where)->order('`id` DESC')->find();
        $store_info=D('Store')->where($where)->find();
        $this->assign('diy_attestation_list', unserialize($certification_info['certification_info']));
        $this->assign('store_info', $store_info);
        $this->display();
    }

    //
    public function status() {
        $store = M('Store');

        if (IS_POST) {
            $store_id = $this->_post('store_id', 'trim,intval');
            $storeInfo = D('Store')->where(array('store_id'=>$store_id))->find();
            $status = $this->_post('status', 'trim,intval');
            $condition['status'] = $status;
            /*if($status != 1){
                $this->suspension_of_business($store_id);
            }*/
            if ($store->where(array('store_id' => $store_id))->save($condition)) {
                if(($status == 1 || $status == 3) && $storeInfo['drp_level'] == 0){
                    $results = D('AdminBonusConfig')->getNoticeAdmin($store_id);
                    $agent = array();
                    foreach($results as $result){
                        $agent[$result['type']] = $result['id'];
                    }
                    import('Notice', './source/class/');
                   // Notice::platform_to_agent($store_id, $agent['3'], $agent['2'], $status);
                }
				
				if($status == 1){
				 $id = 1;
				 }elseif($status == 3){
				 $id = 2;
				 }
				$sms = D('Sms_tpl')->where(array('id'=>$id,'status'=>'1'))->find();
				
				if($sms){
			 
			
			 import('SendSms', './source/class');
			 $storename=$storeInfo['name']; 
			 $mobile=$storeInfo['tel']; 
			 $content=$this->_post('content', 'trim');
		     $str=$sms['text'];
			 $str=str_replace('{storename}',$storename,$str); 
			 $str=str_replace('{mobile}',$mobile,$str); 
			 $str=str_replace('{content}',$content,$str);
		
		 	 $return	= SendSms::send($mobile,$str);
	//	exit(json_encode(array('error' => 0, 'message' => $return)));
			if($return==0){
			$data = array(
						'uid' 	=> 5,
						'store_id' 	=> 0,
						'price' 	=> 0,
						'mobile' 	=> $mobile,
						'text'		=> $str,
						'status'	=> 0,
						'time' => time(),
						'last_ip'	=> ip2long(get_client_ip())
				);
			D('Sms_record')->data($data)->add();
				}
				}
                exit(json_encode(array('error' => 0, 'message' => '状态修改成功')));
            }
            exit(json_encode(array('error' => 1, 'message' => '修改失败！请重试')));
        }
    }

    /**
     * 平台关闭供货商店铺时对商品的处理
     * @param $store_id  被关闭店铺的id
     */
    private function suspension_of_business($store_id){
        if(empty($store_id)){
            return false;
        }else{
            //查看店铺是否有商品
            $product_list = D('Product')->field('product_id')->where(array('store_id'=>$store_id))->select();
            //店铺是否设置了批发商品
            $wholesale_peoduct_list = D('Product')->field('product_id')->where(array('store_id'=>$store_id,'is_wholesale'=>1))->select();

            if($wholesale_peoduct_list){
                foreach($wholesale_peoduct_list as $wholesale_product){
                    D('Product')->where(array('wholesale_product_id'=>$wholesale_product['product_id']))->data(array('status'=>2))->save();
                }
            }
            if($product_list){
                D('Product')->where(array('store_id'=>$store_id))->data(array('status'=>2))->save();
            }
        }

    }

    public function chgAvailable()
    {
         $store = M('Store');
         
        if (IS_POST) {
            $store_id = $this->_post('store_id', 'trim,intval');
            $is_available = $this->_post('is_available', 'trim,intval');
            $condition['is_available'] = $is_available;
            $condition['expiration'] = time();
            if ($store->where(array('store_id' => $store_id))->save($condition)) {
                exit(json_encode(array('error' => 0, 'message' => '状态修改成功')));
            }
            exit(json_encode(array('error' => 1, 'message' => '修改失败！请重试')));
        }
    }


    public function chgStoreTag()
    {
         $store = M('Store');
         
        if (IS_POST) {
            $store_id = $this->_post('store_id', 'trim,intval');
            $tag_id = $this->_post('tag_id', 'trim,intval');
            $condition['tag_id'] = $tag_id;
            if ($store->where(array('store_id' => $store_id))->save($condition)) {
                exit(json_encode(array('error' => 0, 'message' => '类别修改成功')));
            }
            exit(json_encode(array('error' => 1, 'message' => '修改失败！请重试')));
        }
    }



    //是否显示充值保证金按钮
    public function showButton() {

        // 限制权限
        if ($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) {
            exit(json_encode(array('status' => 1000, 'msg' => '区域管理或客户经理(代理商)无修改权限')));
        }

        $store = M('Store');

        if (IS_POST) {
            $store_id = $this->_post('store_id', 'trim,intval');
            $is_show_recharge_button = $this->_post('is_show_recharge_button', 'trim,intval');
            if ($store->where(array('store_id' => $store_id))->save(array('is_show_recharge_button' => $is_show_recharge_button))) {
                if($is_show_recharge_button == 1){
                    exit(json_encode(array('status' => 0, 'msg' => '按钮开启成功')));
                }else if($is_show_recharge_button == 0){
                    exit(json_encode(array('status' => 0, 'msg' => '按钮隐藏成功')));
                }

            }
            exit(json_encode(array('error' => 1, 'message' => '修改失败！请重试')));
        }
    }

    public function show_menu() {
        $store = M('Store');
        if (IS_POST) {
            $store_id           = $this->_post('store_id', 'trim,intval');
            $is_show_float_menu = $this->_post('is_show_float_menu', 'trim,intval');
            if ($store->where(array('store_id' => $store_id))->save(array('is_show_float_menu' => $is_show_float_menu))) {
                exit(json_encode(array('error' => 0, 'message' => '修改成功')));
            }
            exit(json_encode(array('error' => 1, 'message' => '修改失败！请重试')));
        }
    }
    //
    public function approve() {
        if (IS_POST) {
            $store_id = $this->_post('store_id', 'trim,intval');
            $status = $this->_post('approve', 'trim,intval')?$this->_post('approve', 'trim,intval') : 1;
            $result = D('Store')->where(array('store_id' => $store_id))->data(array('approve' => $status))->save();
	    if($result){
		$this->success('更新成功！');
	    }else{
		$this->error('更新失败！');
	    }
            
        }
    }

    //修改店铺关联区域管理员记录
    public function setArea () {
        $bank = D('Bank')->where(array('status'=>1))->field('bank_id,name')->select();
        $store['bank'] = $bank;

        if (IS_POST) {
            $store_id = $this->_post('id', 'trim,intval');
            //更新银行账户信息
            $bankdata = array(
                'withdrawal_type' => $_POST['withdrawal_type'],
                'bank_id' => $_POST['bank_id'],
                'bank_card' => $_POST['bank_card'],
                'bank_card_user' => $_POST['bank_card_user']
            );

            D('Store')->where(array('store_id'=>$store_id))->data($bankdata)->save();
            // 限制权限
            if ($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) {
                $this->frame_error_tips("区域管理或客户经理(代理商)无修改权限");
            }

            $data['province'] = $this->_post('province', 'trim');
            $data['city'] = $this->_post('city', 'trim');
            $data['county'] = $this->_post('county', 'trim');

            if (empty($store_id) || !$store = D('Store')->where(array('store_id'=>$store_id))->find()) {
                $this->frame_error_tips('参数错误');
            }

            if ($store_area_record = D("StoreAreaRecord")->where(array('store_id'=>$store_id, 'status'=>1))->find()) {
                D("StoreAreaRecord")->where(array("pigcms_id"=>$store_area_record["pigcms_id"]))->data(array("status"=>0))->save();
            }

            $data_add = array(
                    'store_id' => $store_id,
                    'province' => $data['province'],
                    'city' => $data['city'],
                    'county' => $data['county'],
                    'creator' => $this->admin_user['id'],
                    'status' => 1,
                    'add_time' => time(),
                );

            $result = D("StoreAreaRecord")->data($data_add)->add();
            $this->frame_main_ok_tips("修改成功", 0);

        } else {
            $this->frame_error_tips('非法访问');
        }
    }

    //收支明细
    public function inoutdetail() {
        $order = D('OrderView');
        $financial_record = D('FinancialRecordView');

        $searchcontent = $this->_request('searchcontent','trim,urldecode');

        if(!empty($searchcontent)) {
            parse_str($searchcontent,$data_arr);
            extract($data_arr);
        }


        $store_id = $this->_get('id', 'trim,intval');
        $this->checkStore($store_id);   // 区域/管理员访问权限

        if ($store_id) {
            $where['FinancialRecord.store_id'] = $store_id;
        } else {
            //未处理的提现记录
            $withdrawal_count = M('StoreWithdrawal')->where(array('status' => 1, 'supplier_id'=>0))->count('pigcms_id');
            $this->assign('withdrawal_count', $withdrawal_count);
        }

        // 列表页面中
        if (empty($store_id)) {
            // 区域管理员 只能查看自己区域的店铺商品
            if ($this->admin_user['type'] == 2) {
                $store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
                if (!empty($store_ids)) {
                    $where['FinancialRecord.store_id'] = array('in', $store_ids);
                } else {
                    $where['FinancialRecord.store_id'] = false;
                }

            } else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺商品
                $store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
                if (!empty($store_ids)) {
                    $where['FinancialRecord.store_id'] = array('in', $store_ids);
                } else {
                    $where['FinancialRecord.store_id'] = false;
                }
            }
        }

        $type = empty($type) ? $this->_get('type', 'trim') : trim($type);
        $keyword = empty($keyword) ? $this->_get('keyword', 'trim') : trim($keyword);
        $payment_method = empty($payment_method) ? $this->_get('payment_method', 'trim') : trim($payment_method);
        $record_type = empty($record_type) ? $this->_get('record_type', 'trim') : trim($record_type);
 
        $start_time = empty($start_time) ? $this->_get('start_time', 'trim') : trim($start_time);
        $end_time = empty($end_time) ? $this->_get('end_time', 'trim') : trim($end_time);



        if ($type && $keyword) {
            if ($type == 'order_no') {
                $where['FinancialRecord.order_no'] = $keyword;
            } else if ($type == 'trade_no') {
                $where['FinancialRecord.trade_no'] = $keyword;
            } else if ($type == 'store') {
                $where['Store.name'] = array('like', '%' . $keyword . '%');
            }
        }

        if ($record_type) {
            $where['FinancialRecord.type'] = $record_type;
        }
        if ($payment_method) {
            $where['FinancialRecord.payment_method'] = $payment_method;
        }

        if ($start_time && $end_time) {
            $where['_string'] = "FinancialRecord.add_time >= '" . strtotime($start_time) . "' AND FinancialRecord.add_time <= '" . strtotime($end_time) . "'";
        } else if ($start_time) {
            $where['FinancialRecord.add_time'] = array('egt', strtotime($start_time));
        } else if ($end_time) {
            $where['FinancialRecord.add_time'] = array('elt', strtotime($end_time));
        }
        $record_count = $financial_record->where($where)->count('FinancialRecord.pigcms_id');


        $payment_methods = $order->getPaymentMethod();

        $record_types = array(
            1 => '订单入账',
            2 => '提现',
            3 => '退款',
            4 => '系统退款'
        );


        $download = $this->_get('download','intval',0);

        if(!$download && !empty($searchcontent)){
            $return = array('code'=>'0','msg'=>$record_count);
            echo json_encode($return);exit;
        }


        if($download == 1) {
            
            $records = $financial_record->where($where)->order("FinancialRecord.pigcms_id DESC")->select();
         
             import('Xls','./source/class');
             $filename = '收支明细';
             $fields = array('收支流水号','类型','店铺名称','收入(元)','支出(元)','余额(元)','支付渠道','交易单号','时间');
             $data = array();  
             foreach ($records as $key => $value) {

               if($value['income'] > 0){
                 $tmp_income_1 = '+'.$value['income'];
               }else{
                 $tmp_income_2 = '-'.abs($value['income']);
               }

               $data[$key] = array('`'.$value['order_no'].'`',$record_types[$value['type']],$value['store'],$tmp_income_1,$tmp_income_2,$value['balance'],$payment_methods[$value['payment_method']],'`'.$value['trade_no'].'`',date('Y-m-d H:i:s',$value['add_time']));
             }

             Xls::download_csv($filename,$fields,$data); 

        }



        import('@.ORG.system_page');
        $page = new Page($record_count, 10);
        $records = $financial_record->where($where)->order("FinancialRecord.pigcms_id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();


        $this->assign('records', $records);
        $this->assign('page', $page->show());
        $this->assign('payment_methods', $payment_methods);
        $this->assign('record_types', $record_types);
        if ($store_id) {
            $this->display('inoutdetail');
        } else {
            $this->display('inoutdetails');
        }
    }

    //主营类目
    public function category() {
        $category = M('SaleCategory');
        $where = array();
        if ($this->_get('cat_id', 'trim,intval')) {
            $where['_string'] = "cat_id = '" . $this->_get('cat_id', 'trim,intval') . "' OR parent_id = '" . $this->_get('cat_id', 'trim,intval') . "'";
        }

        $category_count = $category->where($where)->count('cat_id');
        import('@.ORG.system_page');
        $page = new Page($category_count, 20);
        $categories = $category->where($where)->order('path ASC')->limit($page->firstRow, $page->listRows)->select();

        //未处理的提现记录
        $withdrawal_count = M('StoreWithdrawal')->where(array('status' => 1,'supplier_id'=>0))->count('pigcms_id');
        $this->assign('withdrawal_count', $withdrawal_count);

        //所有分类
        $all_categories = $category->order('path ASC')->select();

        $this->assign('categories', $categories);
        $this->assign('all_categories', $all_categories);
        $this->assign('page', $page->show());
        $this->display();
    }

    //添加主营类目
    public function category_add() {
        $category = M('SaleCategory');

        if (IS_POST) {
            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/category/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/category/' . $rand_num . '/' . $uploadList[0]['savename'], '/category/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $_POST['cat_pic'] = 'category/' . $rand_num . '/' . $uploadList[0]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }
            $data = array();
            $data['parent_id'] = $this->_post('parent_id', 'trim,intval');
            $data['name'] = $this->_post('name', 'trim');
            $data['order_by'] = $this->_post('order_by', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['desc'] = $this->_post('desc', 'trim');
            if ($_POST['cat_pic']) {
                $data['cat_pic'] = $_POST['cat_pic'];
            }

            if (!empty($data['parent_id'])) {
                $data['level'] = 2;
                $path = $category->where(array('cat_id' => $data['parent_id']))->getField('path');
                $data['path'] = $path;
            } else {
                $data['level'] = 1;
                $data['path'] = 0;
            }
            if ($cat_id = $category->add($data)) {
                if ($cat_id <= 9) {
                    $str_cat_id = '0' . $cat_id;
                } else {
                    $str_cat_id = $cat_id;
                }
                $path = $data['path'] . ',' . $str_cat_id;
                $category->where(array('cat_id' => $cat_id))->save(array('path' => $path));
                $this->frame_submit_tips(1, '添加成功！');
            } else {
                $this->frame_submit_tips(0, '添加失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $categories = $category->where(array('level' => 1, 'status' => 1))->order('order_by ASC, cat_id ASC')->select();

        $this->assign('categories', $categories);
        $this->display();
    }

    //修改主营类目
    public function category_edit() {
        $category = M('SaleCategory');

        if (IS_POST) {
            $cat_id = $this->_post('cat_id', 'trim,intval');
            $now_cat = $category->find($cat_id);
            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/category/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/category/' . $rand_num . '/' . $uploadList[0]['savename'], '/category/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $_POST['cat_pic'] = 'category/' . $rand_num . '/' . $uploadList[0]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }

            $data = array();
            $data['parent_id'] = $this->_post('parent_id', 'trim,intval');
            $data['name'] = $this->_post('name', 'trim');
            $data['order_by'] = $this->_post('order_by', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['desc'] = $this->_post('desc', 'trim');
            if ($_POST['cat_pic']) {
                $data['cat_pic'] = $_POST['cat_pic'];
            }


            if (!empty($data['parent_id'])) {
                $data['level'] = 2;
                $path = $category->where(array('cat_id' => $data['parent_id']))->getField('path');
                $data['path'] = $path;
            } else {
                $data['level'] = 1;
                $data['path'] = 0;
            }

            if ($category->where(array('cat_id' => $cat_id))->save($data)) {
                if ($cat_id <= 9) {
                    $str_cat_id = '0' . $cat_id;
                } else {
                    $str_cat_id = $cat_id;
                }
                $path = $data['path'] . ',' . $str_cat_id;
                $category->where(array('cat_id' => $cat_id))->save(array('path' => $path));
                if ($_POST['cat_pic'] && $now_cat['cat_pic']) {
                    unlink('./upload/' . $now_cat['cat_pic']);

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::delete('/' . $now_cat['cat_pic']);
                    }
                }
                $this->frame_submit_tips(1, '修改成功！');
            } else {
                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $id = $this->_get('id', 'trim,intval');

        $categories = $category->where(array('level' => 1, 'status' => 1))->order('order_by ASC, cat_id ASC')->select();

        $category = $category->find($id);
        $category['cat_pic'] = getAttachmentUrl($category['cat_pic']);

        $this->assign('categories', $categories);
        $this->assign('category', $category);
        $this->display();
    }

    //修改主营类目状态
    public function category_status() {
        $category = M('SaleCategory');

        $cat_id = $this->_post('cat_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $category->where(array('cat_id' => $cat_id))->save(array('status' => $status));
        $category->where(array('parent_id' => $cat_id))->save(array('status' => $status, 'parent_status' => $status));
    }

    //删除主营类目
    public function category_del() {
        $category = M('SaleCategory');

        $cat_id = $this->_get('id', 'trim,intval');
        if ($category->delete($cat_id)) {
            $category->where(array('parent_id' => $cat_id))->delete(); //删除子分类
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }
    
	//修改商铺 是否综合展示(pc wap 列表 及公有区域展示)
	public function change_public_display() {

        // 限制权限
        if ($this->admin_user['type'] == 2 || $this->admin_user['type'] == 3) {
            echo json_encode(array('status' => 1, 'msg' => '区域管理或客户经理(代理商)无修改权限'));
            exit;
        }

		$is_display = $this->_post('is_display');
		$store_id = $this->_post('store_id');
		
		if(empty($store_id) || !isset($is_display)) {
			echo
				 json_encode(array('status' => 1, 'msg' => '参数出错，请联系管理员'));
			exit;
		} 
		
		

		M('Store')->where(array('store_id' => $store_id))->setField('public_display',$is_display);
		//批量 更改店铺的商品展示 or 不展示
		if($is_display == 0) {
			M('Product')->where(array('store_id' => $store_id))->setField('public_display',$is_display);
		}
		echo	json_encode(array('status' => 0,'type'=>$is_display, 'msg' => '修改成功'));exit;
	}

    //商铺品牌类别
    public function brandtype() {

        $count = M('StoreBrandType')->count();
        import('@.ORG.system_page');
        $page = new Page($count, 10);
        $list = M('StoreBrandType')->limit($page->firstRow . ',' . $page->listRows)->select();

        $this->assign('typelist', $list);
        $this->assign('page', $page->show());
        $this->display();
    }

    //修改商品品牌类别状态
    public function brandtype_status() {
        $StoreBrandType = M('StoreBrandType');
        $type_id = $this->_post('type_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $StoreBrandType->where(array('type_id' => $type_id))->save(array('status' => $status));
    }

    //添加商品品牌类别
    public function brandtype_add() {
        $StoreBrandType = M('StoreBrandType');

        if (IS_POST) {

            $data = array();
            $data['type_name'] = $this->_post('type_name', 'trim');
            $data['order_by'] = $this->_post('order_by', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');


            if ($type_id = $StoreBrandType->add($data)) {
                $this->frame_submit_tips(1, '添加成功！');
            } else {

                $this->frame_submit_tips(0, '添加失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $StoreBrandType = $StoreBrandType->where(array('status' => 1))->order('order_by ASC, type_id ASC')->select();

        $this->assign('categories', $StoreBrandType);
        $this->display();
    }

    //添加商品品牌类别
    public function brandtype_edit() {
        $StoreBrandType = M('StoreBrandType');

        if (IS_POST) {
            $type_id = $this->_post('type_id', 'trim,intval');

            $data = array();
            $data['type_name'] = $this->_post('type_name', 'trim');
            $data['order_by'] = $this->_post('order_by', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');

            if ($StoreBrandType->where(array('type_id' => $type_id))->save($data)) {
                $this->frame_submit_tips(1, '修改成功！');
            } else {
                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $type_id = $this->_get('id', 'trim,intval');

        $StoreBrandType = $StoreBrandType->find($type_id);

        $this->assign('brandtype', $StoreBrandType);
        $this->display();
    }

    //删除商品品牌类别
    public function brandtype_del() {
        $category = M('StoreBrandType');

        $type_id = $this->_get('id', 'trim,intval');


        /* 如果有子栏目 先删除子栏目再删除 */
        $where = array('type_id' => $type_id);
        if (M('StoreBrand')->where($where)->count()) {

            $this->error('删除失败！该品牌类目下仍有品牌，请先清除品牌再来操作！');
        }


        /* 如果有子栏目 先删除子栏目再删除 */

        if ($category->delete($type_id)) {
            //有品牌的時候刪除否？

            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }

    //商铺品牌列表
    public function brand() {

        if ($this->_get('type_id', 'trim,intval')) {
            $where['_string'] = "type_id = '" . $this->_get('type_id', 'trim,intval') . "'";
        }

        $count = M('StoreBrand')->where($where)->count();

        import('@.ORG.system_page');
        $page = new Page($count, 10);
        $list = M('StoreBrand')->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
        //类别
        $brandtype = M('StoreBrandType')->where(array('status' => 1))->order('order_by ASC, type_id ASC')->select();

        $this->assign('all_brandtypes', $brandtype);
        $this->assign('brands', $list);
        $this->assign('page', $page->show());
        $this->display();
    }

    //修改商品品牌类别状态
    public function brand_status() {
        $StoreBrand = M('StoreBrand');
        $brand_id = $this->_post('brand_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $StoreBrand->where(array('brand_id' => $brand_id))->save(array('status' => $status));
    }

    //添加商铺品牌
    public function brand_add() {
        $brand = M('StoreBrand');

        if (IS_POST) {

            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/brand/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/brand/' . $rand_num . '/' . $uploadList[0]['savename'], '/brand/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $_POST['pic'] = 'brand/' . $rand_num . '/' . $uploadList[0]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }
            $data = array();

            $data['store_id'] = $this->_post('storeid', 'trim');
            $data['type_id'] = $this->_post('type_id', 'trim');
            if (empty($data['store_id']) || empty($data['type_id']))
                $this->frame_submit_tips(0, '添加失败！请重试~');
            $data['name'] = $this->_post('name', 'trim');
            $data['order_by'] = $this->_post('order_by', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['desc'] = $this->_post('desc', 'trim');
            if ($_POST['pic']) {
                $data['pic'] = $_POST['pic'];
            }


            if ($brand_id = $brand->add($data)) {

                $this->frame_submit_tips(1, '添加成功！');
            } else {
                echo $brand->getLastSql();
                exit;
                $this->frame_submit_tips(0, '添加失败！请重试~~~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $brandtypes = M('StoreBrandType')->where(array('status' => 1))->order('order_by ASC,type_id ASC')->select();
        //echo M('StoreBrandType')->getLastSql();
        //dump($brandtypes);exit;
        $this->assign('brandtypes', $brandtypes);
        $this->display();
    }

    //修改商铺品牌
    public function brand_edit() {
        $StoreBrand = M('StoreBrand');

        if (IS_POST) {
            $brand_id = $this->_post('brand_id', 'trim,intval');
            $now_brand = $StoreBrand->find($brand_id);
            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/brand/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/brand/' . $rand_num . '/' . $uploadList[0]['savename'], '/brand/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $_POST['pic'] = 'brand/' . $rand_num . '/' . $uploadList[0]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }

            $data = array();
            $data['store_id'] = $this->_post('storeid', 'trim');
            $data['type_id'] = $this->_post('type_id', 'trim');
            if (empty($data['store_id']) || empty($data['type_id']))
                $this->frame_submit_tips(0, '添加失败！请重试~');
            $data['name'] = $this->_post('name', 'trim');
            $data['order_by'] = $this->_post('order_by', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['desc'] = $this->_post('desc', 'trim');
            if ($_POST['pic']) {
                $data['pic'] = $_POST['pic'];
            }


            $store_status = $StoreBrand->where(array('brand_id' => $brand_id))->save($data);
            if ($store_status === 0 || $store_status) {

                if ($_POST['pic'] && $now_brand['pic']) {
                    unlink('./upload/' . $now_brand['pic']);

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::delete('/' . $now_brand['pic']);
                    }
                }
                $this->frame_submit_tips(1, '修改成功！');
            } else {

                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $id = $this->_get('id', 'trim,intval');

        $brandtype = M('StoreBrandType')->where(array('status' => 1))->order('order_by ASC, type_id ASC')->select();
        $StoreBrand = $StoreBrand->find($id);
        $StoreBrand['pic'] = getAttachmentUrl($StoreBrand['pic']);
        if ($StoreBrand['store_id']) {
            $Store = M('Store')->find($StoreBrand['store_id']);
            $StoreBrand['store_name'] = $Store['name'];
        }
        $this->assign('brandtype', $brandtype);
        $this->assign('StoreBrand', $StoreBrand);
        $this->display();
    }

    //删除商铺品牌
    public function brand_del() {
        $StoreBrand = M('StoreBrand');
        $brand_id = $this->_get('id', 'trim,intval');

        $now_brand = $StoreBrand->find($brand_id);
        if ($StoreBrand->delete($brand_id)) {
            //删除图片
            if ($now_brand['pic']) {
                unlink('./upload/' . $now_brand['pic']);
                // 上传到又拍云服务器
                $attachment_upload_type = C('config.attachment_upload_type');
                if ($attachment_upload_type == '1') {
                    import('upyunUser', './source/class/upload/');
                    upyunUser::delete('/' . $now_brand['pic']);
                }
            }

            $this->success('删除成功！');
        } else {
            $this->error('删除失败！请重试~');
        }
    }

    //搜索店铺
    public function search_store() {
        $keyword = $this->_post('store_name');
        if (empty($keyword))
            return false;

        $where = array(
            'name' => array('like', '%' . $keyword . '%')
        );
        $Store = M('Store');
        $store_list = $Store->where($where)->field("`store_id`,`name`")->limit(10)->select();


        echo json_encode($store_list);
        exit;
    }

    private function getStoreNameToken($store_id_arr = array()) {
        if (empty($store_id_arr)) {
            return array(0 => '-');
        }

        $store_list = D('Store')->where("`status` = 1 AND `store_id` in (" . join(',', $store_id_arr) . ")")->select();

        $data = array();
        foreach ($store_list as $store) {
            $token = $this->getToken($store['store_id']);
            $data[$token] = $store['name'];
        }

        return $data;
    }

	public function activityManage() {
		$_activityModel = array('bargain', 'seckill', 'crowdfunding', 'unitary', 'cutprice','lottery','guajiang','jiugong','luckyFruit','goldenEgg');
		$_eventsId = array('bargain' => 'pigcms_id', 'seckill' => 'action_id', 'cutprice' => 'pigcms_id'); //活动ID转换，调用时用作排序
		$_eventsToken = array('seckill' => 'action_token'); //活动Token转换，where条件生成时需要
		$_eventsModel = array('seckill' => 'seckillAction', 'red_packet' => 'redPacket'); //活动Model转换，每张表明不一致
		
		$activity_type_arr = array();
		if (in_array($this->my_version, array('3','4','7','8'))) {
			$activity_type_arr = array('tuan' => '拼团', 'presale' => '预售', 'bargain' => '砍价', 'seckill' => '秒杀', 'crowdfunding' => '众筹', 'unitary' => '一元夺宝', 'cutprice' => '降价拍'/*,'lottery'=>'大转盘','guajiang'=>'刮刮卡','jiugong'=>'九宫格','luckyFruit'=>'幸运水果机','goldenEgg'=>'砸金蛋'*/); //活动名称
		} else if (in_array($this->my_version,array('2','6'))) {
			$activity_type_arr = array('tuan' => '拼团', 'presale' => '预售', 'bargain' => '砍价', 'seckill' => '秒杀', 'crowdfunding' => '众筹', 'unitary' => '一元夺宝', 'cutprice' => '降价拍');
		} else {
			$activity_type_arr = array('no_activity' => '无相关活动');
		}
		
		$activity_type = $this->_get('activity_type');
		$activity_type = $activity_type ? $activity_type : 'tuan';
		
		if (!isset($activity_type_arr[$activity_type])) {
			$this->error_tips('未找到相应的活动');
		}
		
		$p = max(1, $_GET['page']);
		$type = $_GET['type'];
		$keyword = $_GET['keyword'];
		$limit = 15;
		
		$activity_list = array();
		if ($activity_type == 'tuan') {
			// 拼团活动
			$where = 't.delete_flg = 0';
			if ($keyword) {
				if ($type == 'name') {
					$where .= " AND s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= " AND s.tel like '%" . $keyword . "%'";
				} else {
					$where .= " AND s.store_id = '" . $keyword . "'";
				}
			}
			
			$count = D('TuanView')->where($where)->count('t.id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
				
				$tuan_list = D('TuanView')->where($where)->order('t.id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($tuan_list as $activity) {
					$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
					
					$activity['image'] = getAttachmentUrl($product['image']);
					$activity['product_name'] = $product['name'];
					$activity['check'] = true;
					if ($activity['status'] == 2) {
						$activity['status_txt'] = '已失效';
						$activity['check'] = false;
					} else if ($activity['start_time'] < time() && $activity['end_time'] > time()) {
						$activity['status_txt'] = '进行中';
					} else if ($activity['start_time'] > time()) {
						$activity['status_txt'] = '未开始';
						$activity['check'] = false;
					} else {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					}
					
					$activity['time'] = date('Y-m-d H:i', $activity['start_time']) . '~' . date('Y-m-d H:i', $activity['end_time']);
					$activity_list[] = $activity;
				}
				
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		} else if ($activity_type == 'presale') {
			// 预售活动
			$where = '';
			if ($keyword) {
				if ($type == 'name') {
					$where .= "s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= "s.tel like '%" . $keyword . "%'";
				} else {
					$where .= "s.store_id = '" . $keyword . "'";
				}
			}
			
			$count = D('PresaleView')->where($where)->count('p.id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
			
				$presale_list = D('PresaleView')->where($where)->order('p.id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($presale_list as $activity) {
					$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
						
					$activity['image'] = getAttachmentUrl($product['image']);
					$activity['product_name'] = $product['name'];
					$activity['check'] = true;
					if ($activity['is_open'] == 0) {
						$activity['status_txt'] = '未开启';
						$activity['check'] = false;
					} else if ($activity['starttime'] < time() && $activity['endtime'] > time()) {
						$activity['status_txt'] = '进行中';
					} else if ($activity['starttime'] > time()) {
						$activity['status_txt'] = '未开始';
						$activity['check'] = false;
					} else {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					}
						
					$activity['time'] = date('Y-m-d H:i', $activity['starttime']) . '~' . date('Y-m-d H:i', $activity['endtime']);
					$activity_list[] = $activity;
				}
			
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		} else if ($activity_type == 'bargain') {
			// 	砍价活动
			$where = 'b.delete_flag = 0';
			if ($keyword) {
				if ($type == 'name') {
					$where .= " AND s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= " AND s.tel like '%" . $keyword . "%'";
				} else {
					$where .= " AND s.store_id = '" . $keyword . "'";
				}
			}
			
			$count = D('BargainView')->where($where)->count('b.pigcms_id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
					
				$bargain_list = D('BargainView')->where($where)->order('b.pigcms_id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($bargain_list as $activity) {
					$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
					
					$activity['id'] = $activity['pigcms_id'];
					$activity['image'] = getAttachmentUrl($product['image']);
					$activity['product_name'] = $product['name'];
					$activity['check'] = true;
					if ($activity['state'] == 0) {
						$activity['status_txt'] = '关闭';
						$activity['check'] = false;
					} else {
						$activity['status_txt'] = '进行中';
					}
			
					$activity['time'] = '';
					$activity_list[] = $activity;
				}
					
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		} else if ($activity_type == 'seckill') {
			// 秒杀活动
			$where = '';
			if ($keyword) {
				if ($type == 'name') {
					$where .= "s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= "s.tel like '%" . $keyword . "%'";
				} else {
					$where .= "s.store_id = '" . $keyword . "'";
				}
			}
			
			$count = D('SeckillView')->where($where)->count('a.pigcms_id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
					
				$seckill_list = D('SeckillView')->where($where)->order('a.pigcms_id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($seckill_list as $activity) {
					$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
					
					$activity['id'] = $activity['pigcms_id'];
					$activity['image'] = getAttachmentUrl($product['image']);
					$activity['product_name'] = $product['name'];
					$activity['check'] = true;
					if ($activity['status'] == 2) {
						$activity['status_txt'] = '失效';
						$activity['check'] = false;
					} else if ($activity['start_time'] < time() && $activity['end_time'] > time()) {
						$activity['status_txt'] = '进行中';
					} else if ($activity['start_time'] > time()) {
						$activity['status_txt'] = '未开始';
						$activity['check'] = false;
					} else {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					}
			
					$activity['time'] = date('Y-m-d H:i', $activity['start_time']) . '~' . date('Y-m-d H:i', $activity['end_time']);
					$activity_list[] = $activity;
				}
					
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		} else if ($activity_type == 'crowdfunding') {
			// 众筹活动
			$where = 'a.status > 0';
			if ($keyword) {
				if ($type == 'name') {
					$where .= " AND s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= " AND s.tel like '%" . $keyword . "%'";
				} else {
					$where .= " AND s.store_id = '" . $keyword . "'";
				}
			}
			
			$count = D('ZcProductView')->where($where)->count('a.product_id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
					
				$zc_product_list = D('ZcProductView')->where($where)->order('a.product_id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($zc_product_list as $activity) {
					$activity['id'] = $activity['product_id'];
					$activity['image'] = getAttachmentUrl($activity['productImageMobile']);
					$activity['name'] = $activity['productName'];
					$activity['check'] = true;
					if ($activity['status'] == 1) {
						$activity['status_txt'] = '申请中';
						$activity['check'] = false;
					} else if ($activity['status'] == 2) {
						$activity['status_txt'] = '审核通过预热中';
					} else if ($activity['status'] == 3) {
						$activity['status_txt'] = '审核拒绝';
						$activity['check'] = false;
					} else if ($activity['status'] == 4) {
						$activity['status_txt'] = '进行中';
					} else if ($activity['status'] == 6) {
						$activity['status_txt'] = '成功';
					} else if ($activity['status'] == 7) {
						$activity['status_txt'] = '失败';
						$activity['check'] = false;
					} 
			
					$activity['time'] = '';
					$activity_list[] = $activity;
				}
					
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		} else if ($activity_type == 'unitary') {
			// 夺宝活动
			$where = '';
			if ($keyword) {
				if ($type == 'name') {
					$where .= "s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= "s.tel like '%" . $keyword . "%'";
				} else {
					$where .= "s.store_id = '" . $keyword . "'";
				}
			}
			
			$count = D('UnitaryView')->where($where)->count('a.product_id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
					
				$unitary_list = D('UnitaryView')->where($where)->order('a.product_id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($unitary_list as $activity) {
					$activity['image'] = getAttachmentUrl($activity['logopic']);
					$activity['check'] = true;
					if ($activity['state'] == 0) {
						$activity['status_txt'] = '未开始';
						$activity['check'] = false;
					} else if ($activity['state'] == 1) {
						$activity['status_txt'] = '进行中';
					} else if ($activity['state'] == 2) {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					}
					
					$activity['time'] = '';
					$activity_list[] = $activity;
				}
				
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		} else if ($activity_type == 'cutprice') {
			// 降价拍活动
			$where = '';
			if ($keyword) {
				if ($type == 'name') {
					$where .= "s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= "s.tel like '%" . $keyword . "%'";
				} else {
					$where .= "s.store_id = '" . $keyword . "'";
				}
			}
			
			$count = D('CutpriceView')->where($where)->count('a.product_id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
					
				$unitary_list = D('CutpriceView')->where($where)->order('a.product_id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($unitary_list as $activity) {
					$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
						
					$activity['id'] = $activity['pigcms_id'];
					$activity['name'] = $activity['active_name'];
					$activity['image'] = getAttachmentUrl($product['image']);
					$activity['product_name'] = $product['name'];
					$activity['check'] = true;
					if ($activity['state'] == 1) {
						$activity['status_txt'] = '失败';
						$activity['check'] = false;
					} else if ($activity['state'] == 2) {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					} else if ($activity['starttime'] < time() && $activity['endtime'] > time()) {
						$cha = time() - $activity['starttime'];
						$chaprice = (floor($cha / 60 / $activity['cuttime'])) * $activity['cutprice'];
						if($activity['inventory'] > 0 && ($activity['startprice'] - $chaprice) > $activity['stopprice']){
							$activity['status_txt'] = '进行中';
						}else{
							$activity['status_txt'] = '已结束';
							$activity['check'] = false;
						}
					} else if ($activity['starttime'] > time()) {
						$activity['status_txt'] = '未开始';
					} else {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					}
					
					$activity['time'] = date('Y-m-d H:i', $activity['starttime']) . '~' . date('Y-m-d H:i', $activity['endtime']);
					$activity_list[] = $activity;
				}
				
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		} else if (in_array($activity_type, array('lottery', 'guajiang', 'jiugong', 'luckyFruit', 'goldenEgg'))) {
			// 大转盘、九宫格、刮刮卡、水果机、砸金蛋活动
			$lottery_type = 1;

			if ($activity_type == 'lottery') {
				$lottery_type = 1;
			} else if ($activity_type == 'guajiang') {
				$lottery_type = 3;
			} else if ($activity_type == 'jiugong') {
				$lottery_type = 2;
			} else if ($activity_type == 'luckyFruit') {
				$lottery_type = 4;
			} else if ($activity_type == 'goldenEgg') {
				$lottery_type = 5;
			}
			
			$where = "a.type = '" . $lottery_type . "' AND a.status < 3";
			if ($keyword) {
				if ($type == 'name') {
					$where .= " AND s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= " AND s.tel like '%" . $keyword . "%'";
				} else {
					$where .= " AND s.store_id = '" . $keyword . "'";
				}
			}
				
			$count = D('LotteryView')->where($where)->count('a.id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
				
				$lottery_list = D('LotteryView')->where($where)->order('a.id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($lottery_list as $activity) {
					$activity['name'] = $activity['title'];
					$activity['image'] = getAttachmentUrl($activity['backgroundThumImage']);
					$activity['check'] = true;
					if ($activity['status'] == 1) {
						$activity['status_txt'] = '已失效';
						$activity['check'] = false;
					} else if ($activity['status'] == 2) {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					} else if ($activity['starttime'] < time() && $activity['endtime'] > time()) {
						$activity['status_txt'] = '进行中';
					} else if ($activity['starttime'] > time()) {
						$activity['status_txt'] = '未开始';
					} else {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					}
					
					$activity['time'] = date('Y-m-d H:i', $activity['starttime']) . '~' . date('Y-m-d H:i', $activity['endtime']);
					$activity_list[] = $activity;
				}
				
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		}
		
		$this->assign('activity_type_arr', $activity_type_arr);
		$this->assign('activity_type', $activity_type);
		$this->assign('activity_list', $activity_list);
		$this->display();
	}

	public function activityRecommendAdd() {
		if ($this->isPost()) {
			$id_str = trim($_POST['id_str'], ',');
			$model = $_POST['model'];
			
			$activity_type_arr = array('tuan', 'presale', 'bargain', 'seckill', 'crowdfunding', 'unitary', 'cutprice', 'lottery', 'guajiang', 'jiugong', 'luckyFruit', 'goldenEgg');
			$activity_table_arr = array(
										'tuan' => array('Tuan', 'id, name, store_id', "delete_flg = 0 AND id = '#'"),
										'presale' => array('Presale', 'id, name, store_id', "id = '#'"),
										'bargain' => array('Bargain', 'pigcms_id as id, name, store_id', "delete_flag = 0 AND pigcms_id = '#'"),
										'seckill' => array('Seckill', 'pigcms_id as id, name, store_id', "delete_flag = 0 AND pigcms_id = '#'"),
										'crowdfunding' => array('Zc_product', 'product_id as id, productName as name, store_id', "product_id = '#'"),
										'unitary' => array('Unitary', 'id, name, store_id', "id = '#'"),
										'cutprice' => array('Cutprice', 'pigcms_id as id, active_name as name, store_id', "pigcms_id = '#'"),
										/*'lottery' => array('Lottery', 'id, title as name, store_id', "status != 3 AND type = '1' AND id = '#'"),
										'guajiang' => array('Lottery', 'id, title as name, store_id', "status != 3 AND type = '3' AND id = '#'"),
										'jiugong' => array('Lottery', 'id, title as name, store_id', "status != 3 AND type = '2' AND id = '#'"),
										'luckyFruit' => array('Lottery', 'id, title as name, store_id', "status != 3 AND type = '4' AND id = '#'"),
										'goldenEgg' => array('Lottery', 'id, title as name, store_id', "status != 3 AND type = '5' AND id = '#'"),*/);
			
			
			if (empty($id_str)) {
				json_encode(array('status' => 2, 'msg' => '请选择要推荐的活动'));
				exit;
			}
			
			if (!in_array($model, $activity_type_arr)) {
				json_encode(array('status' => 2, 'msg' => '活动类型不正确'));
				exit;
			}
			
			$id_arr = explode(',', $id_str);
			foreach ($id_arr as $id) {
				// 查找推荐活动里是否已经存在
				$activity_recommend = M('Activity_recommend')->where(array('modelId' => $id, 'model' => $model))->find();
				if (!empty($activity_recommend)) {
					continue;
				}
				
				$table_name = $activity_table_arr[$model][0];
				$activity = M($table_name)->where(str_replace('#', $id, $activity_table_arr[$model][2]))->field($activity_table_arr[$model][1])->find();
				if (empty($activity)) {
					continue;
				}
				
				$data = array();
				$data['modelId'] = $id;
				$data['title'] = $activity['name'];
				$data['model'] = $model;
				$data['store_id'] = $activity['store_id'];
				M('Activity_recommend')->add($data);
			}
			echo json_encode(array('status' => 1, 'msg' => '推荐成功'));
		}
	}

	public function activityRecommend() {
		// $_modelName = array('bargain' => '砍价', 'seckill' => '秒杀', 'crowdfunding' => '众筹', 'unitary' => '一元夺宝', 'cutprice' => '降价拍', 'red_packet' => '红包'); //活动名称
		$_modelName = array('bargain' => '砍价', 'seckill' => '秒杀', 'crowdfunding' => '众筹', 'unitary' => '一元夺宝', 'cutprice' => '降价拍','lottery'=>'大转盘','guajiang'=>'刮刮卡','jiugong'=>'九宫格','luckyFruit'=>'幸运水果机','goldenEgg'=>'砸金蛋'); //活动名称
		// $store_id = array();
		$activity_type_arr = array('tuan' => '拼团', 'presale' => '预售', 'bargain' => '砍价', 'seckill' => '秒杀', 'crowdfunding' => '众筹', 'unitary' => '一元夺宝', 'cutprice' => '降价拍'/*,'lottery'=>'大转盘','guajiang'=>'刮刮卡','jiugong'=>'九宫格','luckyFruit'=>'幸运水果机','goldenEgg'=>'砸金蛋'*/); //活动名称
		
		$activity_type = $_GET['activity_type'];
		if (!in_array($activity_type, array_keys($activity_type_arr))) {
			$activity_type = '';
		}
		
		$p = max(1, $_GET['page']);
		$limit = 15;
		$type = $_GET['type'];
		$keyword = trim($_GET['keyword']);
		$where = '1';
		if (!empty($keyword)) {
			if ($type == 'activity_id') {
				$where .= " AND a.id = '" . $keyword . "'";
			} else if ($type == 'activity_name') {
				$where .= " AND a.title like '%" . $keyword . "%'";
			} else if ($type == 'store_id') {
				$where .= " AND a.store_id = '" . $keyword . "'";
			} else if ($type == 'name') {
				$where .= " AND s.name like '%" . $keyword . "%'";
			} else if ($type == 'tel') {
				$where .= " AND s.tel like '%" . $keyword . "%'";
			}
		}
		
		if (!empty($activity_type)) {
			$where .= " AND a.model = '" . $activity_type . "'";
		}
		
		$count = D('ActivityRecommendView')->where($where)->count('a.id');
		
		$activity_recommend_list = array();
		if ($count > 0) {
			$p = min($p, ceil($count / $limit));
			$offset = ($p - 1) * $limit;
			$activity_recommend_list = D('ActivityRecommendView')->where($where)->limit($offset . ', ' . $limit)->order('a.is_rec DESC,a.id DESC')->select();
			
			$activity_table_arr = array(
										'tuan' => array('Tuan', "id = '#'"),
										'presale' => array('Presale', "id = '#'"),
										'bargain' => array('Bargain', "pigcms_id = '#'"),
										'seckill' => array('Seckill', "pigcms_id = '#'"),
										'crowdfunding' => array('Zc_product', "product_id = '#'"),
										'unitary' => array('Unitary', "id = '#'"),
										'cutprice' => array('Cutprice', "pigcms_id = '#'"),
										'lottery' => array('Lottery', "id = '#'"),
										'guajiang' => array('Lottery', "id = '#'"),
										'jiugong' => array('Lottery', "id = '#'"),
										'luckyFruit' => array('Lottery', "id = '#'"),
										'goldenEgg' => array('Lottery', "id = '#'")
									);
			
			foreach ($activity_recommend_list as &$activity_recommend) {
				$model = $activity_recommend['model'];
				if (!isset($activity_table_arr[$model])) {
					$activity_recommend['status_txt'] = '';
					$activity_recommend['images'] = '';
				} else {
					$activity = M($activity_table_arr[$model][0])->where(str_replace('#', $activity_recommend['modelId'], $activity_table_arr[$model][1]))->find();
					if (empty($activity)) {
						$activity_recommend['status_txt'] = '';
						$activity_recommend['images'] = '';
					} else {
						if ($model == 'tuan') {
							$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
							
							$activity_recommend['image'] = getAttachmentUrl($product['image']);
							$activity_recommend['check'] = true;
							if ($activity['status'] == 2) {
								$activity_recommend['status_txt'] = '已失效';
								$activity_recommend['check'] = false;
							} else if ($activity['start_time'] < time() && $activity['end_time'] > time()) {
								$activity_recommend['status_txt'] = '进行中';
							} else if ($activity['start_time'] > time()) {
								$activity_recommend['status_txt'] = '未开始';
								$activity_recommend['check'] = false;
							} else {
								$activity_recommend['status_txt'] = '已结束';
								$activity_recommend['check'] = false;
							}
							
							$activity_recommend['time'] = date('Y-m-d H:i', $activity['start_time']) . '~' . date('Y-m-d H:i', $activity['end_time']);
						} else if ($model == 'presale') {
							$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
							
							$activity_recommend['image'] = getAttachmentUrl($product['image']);
							$activity_recommend['check'] = true;
							if ($activity['is_open'] == 0) {
								$activity_recommend['status_txt'] = '未开启';
								$activity_recommend['check'] = false;
							} else if ($activity['starttime'] < time() && $activity['endtime'] > time()) {
								$activity_recommend['status_txt'] = '进行中';
							} else if ($activity['starttime'] > time()) {
								$activity_recommend['status_txt'] = '未开始';
								$activity_recommend['check'] = false;
							} else {
								$activity_recommend['status_txt'] = '已结束';
								$activity_recommend['check'] = false;
							}
							
							$activity_recommend['time'] = date('Y-m-d H:i', $activity['starttime']) . '~' . date('Y-m-d H:i', $activity['endtime']);
						} else if ($model == 'bargain') {
							$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
								
							$activity_recommend['image'] = getAttachmentUrl($product['image']);
							$activity_recommend['check'] = true;
							if ($activity['state'] == 0) {
								$activity_recommend['status_txt'] = '关闭';
								$activity_recommend['check'] = false;
							} else {
								$activity_recommend['status_txt'] = '进行中';
							}
							
							$activity_recommend['time'] = '';
						} else if ($model == 'seckill') {
							$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
							
							$activity_recommend['image'] = getAttachmentUrl($product['image']);
							$activity_recommend['check'] = true;
							if ($activity['status'] == 2) {
								$activity_recommend['status_txt'] = '失效';
								$activity_recommend['check'] = false;
							} else if ($activity['start_time'] < time() && $activity['end_time'] > time()) {
								$activity_recommend['status_txt'] = '进行中';
							} else if ($activity['start_time'] > time()) {
								$activity_recommend['status_txt'] = '未开始';
								$activity_recommend['check'] = false;
							} else {
								$activity_recommend['status_txt'] = '已结束';
								$activity_recommend['check'] = false;
							}
								
							$activity_recommend['time'] = date('Y-m-d H:i', $activity['start_time']) . '~' . date('Y-m-d H:i', $activity['end_time']);
						} else if ($model == 'crowdfunding') {
							$activity_recommend['image'] = getAttachmentUrl($activity['productImageMobile']);
							$activity_recommend['check'] = true;
							if ($activity['status'] == 1) {
								$activity_recommend['status_txt'] = '申请中';
								$activity_recommend['check'] = false;
							} else if ($activity['status'] == 2) {
								$activity_recommend['status_txt'] = '审核通过预热中';
							} else if ($activity['status'] == 3) {
								$activity_recommend['status_txt'] = '审核拒绝';
								$activity_recommend['check'] = false;
							} else if ($activity['status'] == 4) {
								$activity_recommend['status_txt'] = '进行中';

							} else if ($activity['status'] == 6) {
								$activity_recommend['status_txt'] = '成功';
							} else if ($activity['status'] == 7) {
								$activity_recommend['status_txt'] = '失败';
								$activity_recommend['check'] = false;
							}
							
							$activity_recommend['time'] = '';
						} else if ($model == 'unitary') {
							$activity_recommend['image'] = getAttachmentUrl($activity['logopic']);
							$activity_recommend['check'] = true;
							if ($activity['state'] == 0) {
								$activity_recommend['status_txt'] = '未开始';
								$activity_recommend['check'] = false;
							} else if ($activity['state'] == 1) {
								$activity_recommend['status_txt'] = '进行中';
							} else if ($activity['state'] == 2) {
								$activity_recommend['status_txt'] = '已结束';
								$activity_recommend['check'] = false;
							}
							
							$activity_recommend['time'] = '';
						} else if ($model == 'cutprice') {
							$product = M('Product')->where(array('product_id' => $activity['product_id']))->find();
							
							$activity_recommend['name'] = $activity['active_name'];
							$activity_recommend['image'] = getAttachmentUrl($product['image']);
							$activity_recommend['check'] = true;
							if ($activity['state'] == 1) {
								$activity_recommend['status_txt'] = '失败';
								$activity_recommend['check'] = false;
							} else if ($activity['state'] == 2) {
								$activity_recommend['status_txt'] = '已结束';
								$activity_recommend['check'] = false;
							} else if ($activity['starttime'] < time() && $activity['endtime'] > time()) {
								$cha = time() - $activity['starttime'];
								$chaprice = (floor($cha / 60 / $activity['cuttime'])) * $activity['cutprice'];
								if($activity['inventory'] > 0 && ($activity['startprice'] - $chaprice) > $activity['stopprice']){
									$activity_recommend['status_txt'] = '进行中';
								}else{
									$activity_recommend['status_txt'] = '已结束';
									$activity_recommend['check'] = false;
								}
							} else if ($activity['starttime'] > time()) {
								$activity_recommend['status_txt'] = '未开始';
							} else {
								$activity_recommend['status_txt'] = '已结束';
								$activity_recommend['check'] = false;
							}
							
							$activity_recommend['time'] = date('Y-m-d H:i', $activity['starttime']) . '~' . date('Y-m-d H:i', $activity['endtime']);
						} else if ($model == 'lottery') {
							$activity_recommend['name'] = $activity['title'];
							$activity_recommend['image'] = getAttachmentUrl($activity['backgroundThumImage']);
							$activity_recommend['check'] = true;
							if ($activity['status'] == 1) {
								$activity_recommend['status_txt'] = '已失效';
								$activity_recommend['check'] = false;
							} else if ($activity['status'] == 2) {
								$activity_recommend['status_txt'] = '已结束';
								$activity_recommend['check'] = false;
							} else if ($activity['starttime'] < time() && $activity['endtime'] > time()) {
								$activity_recommend['status_txt'] = '进行中';
							} else if ($activity['starttime'] > time()) {
								$activity_recommend['status_txt'] = '未开始';
							} else {
								$activity_recommend['status_txt'] = '已结束';
								$activity_recommend['check'] = false;
							}
							
							$activity_recommend['time'] = date('Y-m-d H:i', $activity['starttime']) . '~' . date('Y-m-d H:i', $activity['endtime']);
						}
					}
				}
			}
			
			import('@.ORG.system_page');
			$page = new Page($count, $limit, $p);
			$this->assign('page', $page->show());
		}
		
		$this->assign('activity_recommend_list', $activity_recommend_list);
		$this->assign('activity_type_arr', $activity_type_arr);
		$this->display();
	}

	public function activityRecommendDel() {
		if ($this->isPost()) {
			$data = $data = trim($_POST['id_str'], ',');
			if (M('Activity_recommend')->where(array('id' => array('in', $data)))->delete()) {
				echo json_encode(array('status' => 1, 'msg' => '删除成功'));
				exit;
			} else {
				echo json_encode(array('status' => 0, 'msg' => '删除失败'));
				exit;
			}
		}
	}

	public function activityRecommendRecAdd() {
		if ($this->isPost()) {
			$data = trim($_POST['id_str'], ',');
			if (M('Activity_recommend')->where(array('id' => array('in', $data)))->data(array('is_rec' => 1))->save()) {
				echo json_encode(array('status' => 1, 'msg' => '操作成功'));
				exit;
			} else {
				echo json_encode(array('status' => 0, 'msg' => '请不要重复添加'));
				exit;
			}
		}
	}

	public function activityRecommendRecDel() {
		if ($this->isPost()) {
			$data = trim($_POST['id_str'], ',');
			if (M('Activity_recommend')->where(array('id' => array('in', $data)))->data(array('is_rec' => 0))->save()) {
				echo json_encode(array('status' => 1, 'msg' => '操作成功'));
				exit;
			} else {
				echo json_encode(array('status' => 0, 'msg' => '请不要重复取消'));
				exit;
			}
		}
	}
	
	public function activityRecommendHotAdd() {
		if ($this->isPost()) {
			$data = trim($_POST['id_str'], ',');
			if (M('Activity_recommend')->where(array('id' => array('in', $data)))->data(array('is_hot' => 1))->save()) {
				echo json_encode(array('status' => 1, 'msg' => '操作成功'));
				exit;
			} else {
				echo json_encode(array('status' => 0, 'msg' => '请不要重复添加'));
				exit;
			}
		}
	}
	
	public function activityRecommendHotDel() {
		if ($this->isPost()) {
			$data = trim($_POST['id_str'], ',');
			if (M('Activity_recommend')->where(array('id' => array('in', $data)))->data(array('is_hot' => 0))->save()) {
				echo json_encode(array('status' => 1, 'msg' => '操作成功'));
				exit;
			} else {
				echo json_encode(array('status' => 0, 'msg' => '请不要重复取消'));
				exit;
			}
		}
	}

    private function clear_html($array) {
        if (!is_array($array))
            return trim(htmlspecialchars($array, ENT_QUOTES));
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->clear_html($value);
            } else {
                $array[$key] = trim(htmlspecialchars($value, ENT_QUOTES));
            }
        }
        return $array;
    }

    // 特殊活动-秒杀
    private function getActiveStaticInfo($actResult, $model) {

        if (empty($actResult)) {
            return array();
        }

        if ($model == 'seckillAction') {
            foreach ($actResult as $key => $val) {
                $whereShopTmp = array(
                        'order' => 'shop_id DESC',
                        'where' => array(
                                'shop_open' => 0,
                                'action_id' => $val['modelId'],
                            ),
                        'limit' => '0,1',
                    );
                $shops = $this->curlModelGet('seckillBaseShop', $whereShopTmp, 'select');
                $actResult[$key]['title'] = (isset($shops[0]['shop_name']) && !empty($shops[0]['shop_name'])) ? $shops[0]['shop_name'] : $val['title'];
                $actResult[$key]['price'] = isset($shops[0]['shop_price']) ? $shops[0]['shop_price'] : 0;
            }
        }

        return $actResult;
    }

    /**
     * 微信API CURL POST
     *
     * param url 抓取的URL
     * param data post的数组
     */
    private function api_curl_post($url, $data) {
        $result = $this->post($url, $data);
        $result_arr = json_decode($result, true);
        return $result_arr;
    }

    private function curlModelGet($model, $condition, $method='select') {

        $apiUrl = C('config.syn_domain');
        $salt = C('config.encryption') ? C('config.encryption') : 'pigcms';

        $post = array(
            'option' => $condition,
            'model' => ucfirst($model),
            'debug' => true,
        );
        $post['sign'] = $this->getSign($post, $salt);

        $curlUrl = $apiUrl.'/index.php?g=Home&m=Auth&a='.$method;
        $result = $this->api_curl_post($curlUrl, $post);
        // dump($result);
        if ($result['status'] == 0 && $result['data'] != null) {
            return $result['data'];
        } else {
            return array();
        }
    }

    private function post($url, $post) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // post数据
        curl_setopt($ch, CURLOPT_POST, true);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $result = curl_exec($ch);
        curl_close($ch);
        //返回获得的数据
        return $result;
    }

    private function getToken($id) {
        return substr(md5(C('config.site_url') . $id . $this->synType), 8, 16);
    }

    private function getSign($data, $salt) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $validate[$key] = $this->getSign($value, $salt);
            } else {
                $validate[$key] = $value;
            }
        }
        $validate['salt'] = $salt;
        sort($validate, SORT_STRING);
        return sha1(implode($validate));
    }

    //店铺对账
    public function check()
    {

        $order = D('Order');
        $order_product = D('OrderProduct');
        $financialRecord = D('FinancialRecord');

        $limit = 5;
        //现在
        $config_sales_ratio = $this->config['sales_ratio'];
        $sales_ratio = $config_sales_ratio * 0.01;
        $store_id = $this->_get('id');
        $this->checkStore($store_id);   // 区域/管理员访问权限

        $is_check = 1;
        if ($this->_get('types') == 'checked') {
            //已对账
            $is_check = 2;
        } else if ($this->_get('types') == 'useStorePay') { //店铺收款
            $is_check = 0;
        }

        if (IS_POST) {
            //修改对账状态

            $store_id = $store_id ? $store_id : $this->_post('store_id');
            $arr = array(
                'order_id' => $this->_post('order_id'),
                'order_no' => $this->_post('order_no'),
                'store_id' => $store_id,
                'is_check' => $this->_post('is_check')
            );
            $wheres = array(
                'order_id' => $this->_post('order_id'),
                'order_no' => $this->_post('order_no'),
                'status' => '4' //只可对 已完成的订单
            );
            $order->where($wheres)->save(array('is_check' => 2, 'sales_ratio' => $config_sales_ratio));
            if ($this->set_check_log($arr)) {
                exit(json_encode(array('error' => 0, 'message' => '已出账')));
            } else {
                exit(json_encode(array('error' => 1, 'message' => '缺少必要参数')));
            }
        }

        //是否是分销商
        $is_seller = 0;
        $store = D('Store')->getStore($store_id);
        if (!empty($store['drp_supplier_id'])) {
            $is_seller = $store['store_id'];
            //供货商
            $supplier = D('Store')->getSupplier($store_id);
            $store['supplier'] = $supplier['name'];
            $supplier_id = $supplier['store_id'];
        }


        $where['store_id']    = $store_id;
        $where['status']      = 4;   //只可对 已完成的订单
        if (empty($is_check)) {
            $where['useStorePay'] = 1;
        } else {
            $where['useStorePay'] = 0;
            $where['is_check']    = $is_check;
        }

        $order_total = $order->getOrderTotal($where);

        import('@.ORG.system_page');
        $page = new Page($order_total, $limit);

        $order_list = $order->where($where)->order("order_id asc")->limit($page->firstRow . ',' . $page->listRows)->select();

        import('@.ORG.Order');
        $page_uncheck_account      = 0;
        $page_checked_account      = 0;
        $page_should_check_account = 0;
        foreach ($order_list as $k => &$v) {

            $user_order_id = $v['order_id'];
            if (!empty($v['user_order_id'])) {
                $user_order_id = $v['user_order_id'];
            }

            //店铺收款
            if (!empty($v['useStorePay']) && !empty($v['storePay'])) {
                $storePay = D('Store')->field('name')->where(array('store_id' => $v['storePay']))->find();
                $v['storePay'] = $storePay['name'];
            }

            $order_total = 0;
            //分销商利润
            $seller_profit = 0;
            if (empty($is_seller)) {

                $order_total += ($v['sale_total'] > 0) ? $v['sale_total'] : $v['total'];

                if ($v['user_order_id'] > 0) {
                    $where = array();
                    $where['order_id'] = array('lt', $v['order_id']);
                    $where['_string']  = "(user_order_id = '" . $v['user_order_id'] . "' OR order_id = '" . $v['user_order_id'] . "')";
                    $seller_orders = M('Order')->field('order_id,store_id')->where($where)->select();
                    if (!empty($seller_orders)) {
                        foreach ($seller_orders as $seller_order) {
                            $seller_profit += D('FinancialRecord')->getOrderProfit($seller_order['order_id']);
                        }
                    }
                }
            } else {
                $seller_profit = D('FinancialRecord')->getOrderProfit($v['order_id']);
                if (!empty($supplier_id)) {
                    $tmp_order = D('Order')->field('total,sale_total')->where(array('user_order_id' => $user_order_id, 'store_id' => $supplier_id))->find();
                    $v['total'] = !empty($tmp_order['total']) ? $tmp_order['total'] : $v['total'];
                    $v['sale_total'] = $tmp_order['sale_total'];
                }
            }
            $v['seller_profit'] = number_format($seller_profit, 2, '.', '');

            //退货金额
            $where = array();
            $where['order_id'] = $v['order_id'];
            $return_amount = M('Return')->where($where)->sum('product_money + postage_money');
            $return_amount = !empty($return_amount) ? $return_amount : 0;
            $v['return_amount'] = number_format($return_amount, 2, '.', '');

            $products = $order_product->getProducts($v['order_id']);
            $order_sub_total = 0;
            $product_list = array();
            foreach ($products as $product) {
                $original_product_id = $product['original_product_id'];
                if (empty($product['original_product_id'])) {
                    $original_product_id = $product['product_id'];
                }

                $product_tmp = M('Order_product')->where("order_id = '" . $v['user_order_id'] . "' AND original_product_id = '" . $original_product_id . "' AND sku_data = '" . $product['sku_data'] . "'")->field('pro_price')->order("pigcms_id ASC")->find();
                $product['pro_price'] = $product_tmp['pro_price'];
                $order_sub_total += $product['pro_price'] * $product['pro_num'];
                $product_list[] = $product;

            }

            if (empty($is_seller)) {
                $v['un_check_account']     = $order_total;
                $v['should_check_account'] = number_format($v['un_check_account'] * (1 - $sales_ratio), 2, '.', '');
                $v['sales_ratio']          = ($v['sales_ratio']) . '%';

                //已对账
                if ($v['is_check'] == 2) {
                    $v['un_check_account'] = 0;
                    $v['checked_account']  = $v['sale_total'];
                }

            } else {
                $v['un_check_account']     = $financialRecord->getOrderProfit($v['order_id']);
                $v['un_check_account']     = $v['un_check_account'];
                $v['should_check_account'] = $v['un_check_account'];
                $v['sales_ratio']          = '0%';
                $sales_ratio               = 0;

                //已对账
                if ($v['is_check'] == 2) {
                    $v['checked_account']  = $v['un_check_account'];
                    $v['un_check_account'] = 0;
                }
            }

            $page_uncheck_account        += $v['un_check_account'];
            $page_checked_account        += $v['checked_account'];
            $page_should_check_account   += $v['un_check_account'] * (1 - $sales_ratio);

            $v['un_check_account'] = number_format($v['un_check_account'], 2, '.', '');
        }
        //本页包含的其他页面info
        $info = array(
            'sys_sales_ratio'               => number_format($sales_ratio * 100, 2, '.', '') . '%',
            'order_sales_ratio'             => number_format($sales_ratio * 100, 2, '.', '') . '%',
            'page_uncheck_account'          => $page_uncheck_account,
            'page_checked_account'          => $page_checked_account,
            'page_checked_account2'         => $page_checked_account * (1 - $sales_ratio),
            'page_should_check_account'     => $page_should_check_account,
        );

        $this->assign('orders', $order_list);
        $this->assign('page', $page->show());
        $this->assign('info', $info);
        $this->assign('store_id', $store_id);
        $this->assign('is_check', $is_check);
        $this->assign('store', $store);
        $this->display();
    }

    /* description:记录出账日志
     *
     * @arr : 必须包含： order_id,order_no
     */

    public function set_check_log($arr) {

        $check_log = D('OrderCheckLog');

        $thisUser = $this->system_session;

        if (empty($arr['order_id']) || empty($arr['order_no']) || empty($thisUser['id']) || empty($arr['store_id'])) {

            return false;
        }

        $description = "";

        $data = array(
            'timestamp' => time(),
            'admin_uid' => $thisUser['id'],
            'order_id' => $arr['order_id'],
            'store_id' => $arr['store_id'],
            'order_no' => $arr['order_no'],
            'ip' => ip2long($_SERVER['REMOTE_ADDR']),
            'description' => $description
        );

        if ($check_log->add($data)) {
            return true;
        } else {
            return false;
        }
    }

    //店铺评价删除
    public function comment_del() {

        $comment = M('Comment');
        $delete_flg = $this->_get('delete', 'trim,intval');
        $comment_id = $this->_get('comment_id', 'trim,intval');

        if ($comment->where(array('id' => $comment_id))->save(array('delete_flg' => $delete_flg))) {
            $this->success('操作成功');
            exit;
        } else {
            $this->error('操作失败');
        }
    }

    //店铺评价审核操作
    public function comment_status() {

        $comment = M('Comment');

        $comment_id = $this->_post('id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        if ($comment->where(array('id' => $comment_id))->save(array('status' => $status))) {
            $this->success('操作成功');
            exit;
        } else {

            $this->error('操作失败');
        }
    }

    //店铺评价管理
    public function comment() {
        $config = C('config');
        //$where['delete_flg'] = 0;
        $where['type'] = 'STORE';
        $comment_model = D('Comment');
        $isdelete = $this->_get("isdelete");
        if (in_array($isdelete, array('0', '1'))) {
            $where['delete_flg'] = $isdelete;
        }

        // 区域管理员 只能查看自己区域的店铺
        if ($this->admin_user['type'] == 2) {
            $store_ids = D('Admin')->getAreaStoreIds($this->admin_user);
            if (!empty($store_ids)) {
                $where['store_id'] = array('in', $store_ids);
            } else {
                $where['store_id'] = false;
            }
        } else if ($this->admin_user['type'] == 3) {    // 代理商 只能查看自己关联用户的店铺
            $store_ids = D("Admin")->getAgentStoreIds($this->admin_user);
            if (!empty($store_ids)) {
                $where['store_id'] = array('in', $store_ids);
            } else {
                $where['store_id'] = false;
            }
        }

        $count = $comment_model->getCount($where);
        if ($count > 0) {
            $limit = 15;
            import('@.ORG.system_page');
            $page = new Page($count, $limit);


            $comment_list = $comment_model->getList($where, 'id desc', $page->listRows, $page->firstRow, true);

            foreach ($comment_list['comment_list'] as $k => $v) {
                $product_new_arr[] = $v['relation_id'];
            }

            $in_array = $product_new_arr;

            $Stores = D('Store')->where(array('store_id' => array('in', $in_array)))->select();
            if (is_array($Stores)) {
                foreach ($Stores as $k => $v) {
                    $store_arr[$v['store_id']] = $v;
                }
            }
            //dump($comment_list);
            $this->assign('comments', $comment_list);
            $this->assign('page', $page->show());
            $this->assign('config', $config);
            $this->assign('isdelete', $isdelete);
            $this->assign('store_arr', $store_arr);
        }
        $this->display();
    }

    public function diyAttestation() {
        if (IS_POST) {
            if (!$_POST) {
                return false;
            }

            for ($i = 0; $i < count($_POST['field-type']); $i++) {
                switch ($_POST['field-type'][$i]) {
                    case 'text':
                    	$validate = 'required:true';
                    	if ($_POST['field-type-str'][$i] != 'all') {
                    		$validate .= ',' . $_POST['field-type-str'][$i] . ':true';
                    	}
                    	
                        $data['type'] = 'type=' . $_POST['field-type'][$i] . '&validate=' . $validate;
                        break;
                    case 'image':
                        $data['type'] = 'type=image&validate=required:true,url:true';
                        break;
                    case 'select':
                        $select_arr = explode(',', $_POST['field-type-str'][$i]);
                        if (!is_array($select_arr)) {
                            return false;
                        }

                        $str = '';
                        foreach ($select_arr as $k => $v) {
                            $str.=$v . ':' . $v . '|';
                        }
                        $data['type'] = 'type=select&value=' . trim($str, '|');
                        break;
                }
                $data['info'] = $_POST['info'][$i];
                $data['desc'] = $_POST['desc'][$i];
                $data['status'] = 1;
                $data['name'] = $_SESSION['system']['account'] . '_' . ($i + 1);
                if(empty($_POST['field-id'][$i])){ 
                    D('Diy_attestation')->add($data);
                }else{
                    D('Store')->where('1')->save(array('approve'=>0));
                    D('Diy_attestation')->where(array('id'=>$_POST['field-id'][$i]))->save($data);

                }
            }
            $this->success('操作成功！');
        } else {
            $diy_attestation_list = D('diy_attestation')->select();
            $this->assign('diy_attestation_list', $diy_attestation_list);
            $this->display();
        }
    }

    public function diyAttestation_del(){
        $id     = intval($_POST['id']);
        if(D('Diy_attestation')->where(array('id'=>$id))->delete()){
            echo true;
        }

    }
	
	
	//分销商等级
	public function drp_degree() {
		$where = array();
		if ($this->_get('type_id', 'trim,intval')) {
            $where['_string'] = "type_id = '" . $this->_get('type_id', 'trim,intval') . "'";
        }

        $count = M('Platform_drp_degree')->where($where)->count();

        import('@.ORG.system_page');
        $page = new Page($count, 10);
        $list = M('Platform_drp_degree')->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		
		if(is_array($list)) {
			foreach($list as $k=>&$v) {
				if ($v['icon']) {
					$v['icon'] = getAttachmentUrl($v['icon']);
				} 
			}
		}
		
        $this->assign('array', $list);
        $this->assign('page', $page->show());
		$this->display();
	}
	
	//添加分销等级
	public function drp_degree_add() {
        $drp_degree_model 		= M('Platform_drp_degree');
		$drp_degree_icon_model  = M('Platform_drp_degree_icon');
        if (IS_POST) {

            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/platform_drp_degree/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/platform_drp_degree/' . $rand_num . '/' . $uploadList[0]['savename'], '/platform_drp_degree/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $_POST['pic'] = 'platform_drp_degree/' . $rand_num . '/' . $uploadList[0]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }
            $data = array();
            $data['name'] = $this->_post('name', 'trim');
			$data['condition_point'] = $this->_post('condition_point', 'trim');
            $data['value'] = $this->_post('value', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['description'] = $this->_post('desc', 'trim');
			$data['add_time'] = time();
            if ($_POST['pic']) {
                $data['icon'] = $_POST['pic'];
            } else {
				
			}


            if ($brand_id = $drp_degree_model->add($data)) {

                $this->frame_submit_tips(1, '添加成功！');
            } else {
                echo $drp_degree->getLastSql();
                exit;
                $this->frame_submit_tips(0, '添加失败！请重试');
            }
        }
        $this->assign('bg_color', '#F3F3F3');

        $this->display();		
		
	}
	
	//分销等级修改
    public function drp_degree_edit() {
        $drp_degree_model = M('Platform_drp_degree');

        if (IS_POST) {
            $pigcms_id = $this->_post('pigcms_id', 'trim,intval');
            $now_degree = $drp_degree_model->where(array('pigcms_id'=>$pigcms_id))->find();
			
			 $data = array();
            $data['name'] = $this->_post('name', 'trim');
			$data['condition_point'] = $this->_post('condition_point', 'trim');
            $data['value'] = $this->_post('value', 'trim,intval');
            $data['status'] = $this->_post('status', 'trim,intval');
            $data['description'] = $this->_post('desc', 'trim');
			
			if(!$data['name'] || !$data['description']) {
				$this->frame_submit_tips(0, '等级名称或描述为空！');
				exit;
			}
			
			
            if ($_FILES['pic']['error'] != 4) {
                //上传图片
                $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
                $upload_dir = './upload/platform_drp_degree/' . $rand_num . '/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                import('ORG.Net.UploadFile');
                $upload = new UploadFile();
                $upload->maxSize = 10 * 1024 * 1024;
                $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
                $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif');
                $upload->savePath = $upload_dir;
                $upload->saveRule = 'uniqid';
                if ($upload->upload()) {
                    $uploadList = $upload->getUploadFileInfo();

                    // 上传到又拍云服务器
                    $attachment_upload_type = C('config.attachment_upload_type');
                    if ($attachment_upload_type == '1') {
                        import('upyunUser', './source/class/upload/');
                        upyunUser::upload('./upload/platform_drp_degree/' . $rand_num . '/' . $uploadList[0]['savename'], '/platform_drp_degree/' . $rand_num . '/' . $uploadList[0]['savename']);
                    }

                    $_POST['icon'] = 'platform_drp_degree/' . $rand_num . '/' . $uploadList[0]['savename'];
                } else {
                    $this->frame_submit_tips(0, $upload->getErrorMsg());
                }
            }


			
            if ($_POST['icon']) {
                $data['icon'] = $_POST['icon'];
            }
		

            $drp_degree_status = $drp_degree_model->where(array('pigcms_id' => $pigcms_id))->save($data);
            if ($drp_degree_status === 0 || $drp_degree_status) {

                if ($_POST['icon'] || $now_degree['icon']) {
					
					if($_POST['icon']) {
						@unlink('./upload/' . $now_degree['icon']);

						// 上传到又拍云服务器
						$attachment_upload_type = C('config.attachment_upload_type');
						if ($attachment_upload_type == '1') {
							import('upyunUser', './source/class/upload/');
							upyunUser::delete('/' . $now_degree['icon']);
						}
					}
					
                }
                $this->frame_submit_tips(1, '修改成功！');
            } else {
                $this->frame_submit_tips(0, '修改失败！请重试~');
            }
        }
        $this->assign('bg_color', '#F3F3F3');
        $id = $this->_get('id', 'trim,intval');


        $drp_degree_info = $drp_degree_model->where(array('pigcms_id'=>$id))->find();
		if($drp_degree_info['icon']) {
			$drp_degree_info['icon'] = getAttachmentUrl($drp_degree_info['icon']);
		}
        $this->assign('array', $drp_degree_info);
        $this->display();
    }
	
	
	//
	public function drp_degree_status() {
		$Platform_drp_degree = M('Platform_drp_degree');

        $pigcms_id = $this->_post('pigcms_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        if ($Platform_drp_degree->where(array('pigcms_id' => $pigcms_id))->save(array('status' => $status))) {
            $this->success('操作成功');
            exit;
        } else {
            $this->error('操作失败');
        }
	}
	
	
	public function drp_degree_del() {

		$id = $this->_get('id', 'trim,intval');
		$drp_degree = M('drp_degree')->where(array('is_platform_degree_name'=>$id))->find();
		if($drp_degree) {
			$this->error('删除失败！该分销等级已有商家在使用，不予删除！');
		} else {
			M('Platform_drp_degree')->where(array('pigcms_id'=>$id))->delete();
			$this->success("删除成功！");
		}
	
	}


    public function package(){

        $package_model = D('package');

        //筛选
        if (!empty($_GET['keyword'])) {
            if ($_GET['searchtype'] == 'id') {
                $condition['pigcms_id'] = $_GET['keyword'];
            } else if ($_GET['searchtype'] == 'name') {
                $condition['name'] = array('like', '%' . $_GET['keyword'] . '%');
            }
        }

        $count = $package_model->where($condition)->count();
        
        import('@.ORG.system_page');
        $p = new Page($count, 15);
        $this->package_list = $package_model->where($condition)->limit($p->firstRow . ',' . $p->listRows)->order("is_default desc,pigcms_id desc")->select();


        $this->pagebar = $p->show();
        
        
        $this->display();
    
    }

    public function package_status(){

        if (IS_POST) {
            $package_model = M('package');
            $package_id = $this->_post('package_id', 'trim,intval');
            $status = $this->_post('status', 'trim,intval');
            if ($package_model->where(array('pigcms_id' => $package_id))->save(array('status' => $status))) {
                echo json_encode(array('error' => 0, 'message' => '状态修改成功'));
                exit;
            }

            echo json_encode(array('error' => 1, 'message' => '修改失败！请重试'));
            exit;
        }


    }

    public function package_add(){

        if (IS_POST) {

            $package_model = M('package');

            $data = array();
            $data['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
            $data['time'] = isset($_POST['time']) ? intval($_POST['time']) : 0;
            $data['store_nums'] = isset($_POST['store_nums']) ? intval($_POST['store_nums']) : 0;
            $data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
            $data['store_pay_weixin_open'] = isset($_POST['store_pay_weixin_open']) ? intval($_POST['store_pay_weixin_open']) : 0;
            $data['distributor_nums'] = isset($_POST['distributor_nums']) ? intval($_POST['distributor_nums']) : 0;
            $data['store_online_trade'] = isset($_POST['store_online_trade']) ? intval($_POST['store_online_trade']) : 0;

            $data['store_point_total'] = isset($_POST['store_point_total']) ? trim($_POST['store_point_total']) : 0;

            if (empty($data['name'])) {
                $this->error('缺少名称');
            }

            if ($package_model->add($data)) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败，稍后再试');
            }

        } else {
            $this->display();
        }
    }


    public function package_edit(){

        $package_model = M('package');

        if (IS_POST) {
  
            $condition['pigcms_id'] = isset($_POST['id']) ? intval($_POST['id']) : 0;

            $data = array();
            $data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
            $data['time'] = isset($_POST['time']) ? intval($_POST['time']) : 0;
            $data['store_nums'] = isset($_POST['store_nums']) ? intval($_POST['store_nums']) : 0;
            $data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
            $data['store_pay_weixin_open'] = isset($_POST['store_pay_weixin_open']) ? intval($_POST['store_pay_weixin_open']) : 0;
            $data['distributor_nums'] = isset($_POST['distributor_nums']) ? intval($_POST['distributor_nums']) : 0;

            $data['store_online_trade'] = isset($_POST['store_online_trade']) ? intval($_POST['store_online_trade']) : 0;

            $data['store_point_total'] = isset($_POST['store_point_total']) ? trim($_POST['store_point_total']) : 0;

            $package = $package_model->where($condition)->find();
            if (empty($package)) {
                $this->error('未找到该套餐');
            }

            if (empty($data['name'])) {
                $this->error('缺少名称');
            }

            if ($package_model->where($condition)->data($data)->save()) {
                $this->success("修改成功");
            } else {
                $this->error("修改失败，稍后再试");
            }

        } else {

            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            if (empty($id)) {
                $this->frame_error_tips('缺少参数');
            }

            $package = $package_model->where(array('pigcms_id'=>$id))->find();
            if (empty($package)) {
                $this->frame_error_tips('该套餐不存在');
            }

            $this->assign('package', $package);
            $this->display();
        }
    
    }


    public function package_del(){

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        
        $back = D('package')->where(array('pigcms_id' => $id))->delete();
        if ($back == true) {
            M("user")->where('package_id='.$id)->data(array('package_id'=>0))->save();
            $this->success('删除成功');
        } else {
            $this->error('删除失败' . $this->_get('id'));
        }
        

    }


    public function package_give(){

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

        $Model = M("user");
        $back = $Model->execute("update __TABLE__ set package_id=".$id);

        if ($back == true) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败' . $this->_get('id'));
        }
        

    }


    public function package_default(){
        
        M('package')->where('is_default=1')->setField('is_default',0);
       
        $data['pigcms_id'] = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
       
        $data['is_default'] = 1;
       
        $back = M('package')->save($data);
       
        if ($back == true) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败' . $this->_get('id'));
        }

    }


    public function package_default_cancel(){

        $data['pigcms_id'] = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
       
        $data['is_default'] = 0;
       
        $back = M('package')->save($data);
       
        if ($back == true) {
            $this->success('操作成功');
        } else {
            $this->error('操作失败' . $this->_get('id'));
        }

    }


    public function package_access(){

        import('PackageConfig','./source/class');
        
        $this->default_module = PackageConfig::setDefaultModule();
       
        $this->config_list = PackageConfig::setRbacConfig();

        $pid = $this->_get('id','intval');

        $this->rbac_package = $rbac_package = M('rbac_package')->where('pid='.$pid)->find();

        $this->rbac_list = explode(',',$rbac_package['rbac_val']);

        
        if (IS_POST) {
        $data['id'] = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $data['pid'] = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
        $menu = isset($_POST['menu']) ? $_POST['menu'] : array();
        $data['rbac_val'] = implode(',',$menu);
        $data['add_time'] = time();

        if($data['id']) {

            $status  = M('rbac_package')->save($data);
        
        }else{

            $status  = M('rbac_package')->add($data);
            
        }
      
        if ($status) {

            //清除配置文件缓存
            import('ORG.Util.Dir');
            Dir::delDirnotself('./cache');

            $this->success('设置成功');
        } else {
            $this->error('设置失败，稍后再试');
        }
       
        }
        $this->display();

    }

    public function getAreaAdminInfo($province,$city,$county){
        $database_admin = D('Admin');
        if($county!=''){
            $where[1] = "(province='".$province."' and city='".$city."' and county='".$county."')";
            $where[2] = "(province='".$province."' and city='".$city."' and county='')";
            $where[3] = "(province='".$province."' and city='' and county='')";
            $where = implode('or',$where);
            $order = array("area_level DESC");
            $rs = $database_admin->where($where)->order($order)->field('realname,avatar')->find();
            if($rs){
                return $rs;
            }else{
                return array();
            }
        }elseif($city!=''){
            $where[2] = "(province='".$province."' and city='".$city."' and county='')";
            $where[3] = "(province='".$province."' and city='' and county='')";
            $where = implode('or',$where);
            $order = array("area_level DESC");
            $rs = $database_admin->where($where)->order($order)->field('realname,avatar')->find();
            if($rs){
                return $rs;
            }else{
                return array();
            }
        }elseif($province!=''){
            $where['province'] = $province;
            $where['area_level'] = 1;
            $rs = $database_admin->where($where)->field('realname,avatar')->find();
            if($rs){
                return $rs;
            }else{
                return array();
            }
        }
    }

    //店铺类别列表
    public function tag() {
        
        $count = M('StoreTag')->count();

        import('@.ORG.system_page');

        $page = new Page($count, 10);

        //类别

        $list = M('StoreTag')->limit($page->firstRow . ',' . $page->listRows)->select(); 

        $this->assign('tags', $list);

        $this->assign('page', $page->show());

        $this->display();

    }


    //修改店铺类别状态
    public function tag_status() {
        $StoreTag = M('StoreTag');
        $tag_id = $this->_post('tag_id', 'trim,intval');
        $status = $this->_post('status', 'trim,intval');
        $StoreTag->where(array('tag_id' => $tag_id))->save(array('status' => $status));
    }

    public function tag_del(){
        $tag_id = $this->_get('id', 'trim,intval');

        $back = M('StoreTag')->where(array('tag_id' => $tag_id))->delete();
        if ($back == true) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败' . $this->_get('id'));
        }

    }

     public function tag_add(){

        $StoreTag = M('StoreTag');

        if (IS_POST) {
  
            $data = array();
            $data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
            $data['order_by'] = isset($_POST['order_by']) ? intval($_POST['order_by']) : 0;
            $data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
    
            if (empty($data['name'])) {
                $this->error('缺少名称');
            }

            if ($StoreTag->data($data)->add()) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败，稍后再试");
            }

        } else {

            $this->display();
        }

    }

    public function tag_edit(){

        $StoreTag = M('StoreTag');

        if (IS_POST) {
  
            $condition['tag_id'] = isset($_POST['id']) ? intval($_POST['id']) : 0;

            $data = array();
            $data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
            $data['order_by'] = isset($_POST['order_by']) ? intval($_POST['order_by']) : 0;
            $data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
           

            $store_tag = $StoreTag->where($condition)->find();
            if (empty($store_tag)) {
                $this->error('未找到该类别');
            }

            if (empty($data['name'])) {
                $this->error('缺少名称');
            }

            if ($StoreTag->where($condition)->data($data)->save()) {
                $this->success("修改成功");
            } else {
                $this->error("修改失败，稍后再试");
            }

        } else {

            $tag_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            if (empty($tag_id)) {
                $this->frame_error_tips('缺少参数');
            }

            $store_tag = $StoreTag->where(array('tag_id'=>$tag_id))->find();
            if (empty($store_tag)) {
                $this->frame_error_tips('该类别不存在');
            }

            $this->assign('store_tag', $store_tag);
            $this->display();
        }

    }

    public function upload_contract(){
        if ($_FILES['pic']['error'] != 4) {
            //上传图片
            $rand_num = date('Y/m', $_SERVER['REQUEST_TIME']);
            $upload_dir = './upload/contract/' . $rand_num . '/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            import('ORG.Net.UploadFile');
            $upload = new UploadFile();
            $upload->maxSize = 1 * 1024 * 1024;
            $upload->allowExts = array('jpg', 'jpeg', 'png', 'gif');
            $upload->allowTypes = array('image/png', 'image/jpg', 'image/jpeg', 'image/gif','application/octet-stream');
            $upload->savePath = $upload_dir;
            $upload->saveRule = 'uniqid';
            if ($upload->upload()) {
                $uploadList = $upload->getUploadFileInfo();

                // 上传到又拍云服务器
                $attachment_upload_type = C('config.attachment_upload_type');
                if ($attachment_upload_type == '1') {
                    import('upyunUser', './source/class/upload/');
                    upyunUser::upload('./upload/contract/' . $rand_num . '/' . $uploadList[0]['savename'], '/contract/' . $rand_num . '/' . $uploadList[0]['savename']);
                }

                $pic = 'contract/' . $rand_num . '/' . $uploadList[0]['savename'];
                $data['error_code'] = 0;
                $data['msg'] = getAttachmentUrl($pic);
                echo json_encode($data);die();
            } else {
                error_log($upload->getErrorMsg());
                $data['error_code'] = 1002;
                $data['msg'] = $upload->getErrorMsg();
                echo json_encode($data);die();
            }
        }else{
            $data['error_code'] = 1001;
            $data['msg'] = '没有上传图片';
            echo json_encode($data);die();
        }
    }

	// 店铺游戏
	public function game() {
		$activity_type_arr = array('lottery'=>'大转盘','guajiang'=>'刮刮卡','jiugong'=>'九宫格','luckyFruit'=>'幸运水果机','goldenEgg'=>'砸金蛋'); //活动名称
		
		$activity_type = $this->_get('activity_type');
		$activity_type = $activity_type ? $activity_type : 'lottery';
		
		if (!isset($activity_type_arr[$activity_type])) {
			$this->error_tips('未找到相应的活动');
		}
		
		$p = max(1, $_GET['page']);
		$type = $_GET['type'];
		$keyword = $_GET['keyword'];
		$limit = 15;
		
		$activity_list = array();
		if (in_array($activity_type, array('lottery', 'guajiang', 'jiugong', 'luckyFruit', 'goldenEgg'))) {
			// 大转盘、九宫格、刮刮卡、水果机、砸金蛋活动
			$lottery_type = 1;
			if ($activity_type == 'lottery') {
				$lottery_type = 1;
			} else if ($activity_type == 'guajiang') {
				$lottery_type = 3;
			} else if ($activity_type == 'jiugong') {
				$lottery_type = 2;
			} else if ($activity_type == 'luckyFruit') {
				$lottery_type = 4;
			} else if ($activity_type == 'goldenEgg') {
				$lottery_type = 5;
			}
				
			$where = "a.type = '" . $lottery_type . "' AND a.status < 3";
			if ($keyword) {
				if ($type == 'name') {
					$where .= " AND s.name like '%" . $keyword . "%'";
				} else if ($type == 'tel') {
					$where .= " AND s.tel like '%" . $keyword . "%'";
				} else {
					$where .= " AND s.store_id = '" . $keyword . "'";
				}
			}
		
			$count = D('LotteryView')->where($where)->count('a.id');
			if ($count > 0) {
				$p = min($p, ceil($count / $limit));
				$offset = ($p - 1) * $limit;
		
				$lottery_list = D('LotteryView')->where($where)->order('a.id desc')->limit($offset . ', ' . $limit)->select();
				foreach ($lottery_list as $activity) {
					$activity['name'] = $activity['title'];
					$activity['image'] = getAttachmentUrl($activity['backgroundThumImage']);
					$activity['check'] = true;
					if ($activity['status'] == 1) {
						$activity['status_txt'] = '已失效';
						$activity['check'] = false;
					} else if ($activity['status'] == 2) {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					} else if ($activity['starttime'] < time() && $activity['endtime'] > time()) {
						$activity['status_txt'] = '进行中';
					} else if ($activity['starttime'] > time()) {
						$activity['status_txt'] = '未开始';
					} else {
						$activity['status_txt'] = '已结束';
						$activity['check'] = false;
					}
						
					$activity['time'] = date('Y-m-d H:i', $activity['starttime']) . '~' . date('Y-m-d H:i', $activity['endtime']);
					$activity_list[] = $activity;
				}
		
				import('@.ORG.system_page');
				$page = new Page($count, $limit, $p);
				$this->assign('page', $page->show());
			}
		}
		
		$this->assign('activity_type_arr', $activity_type_arr);
		$this->assign('activity_type', $activity_type);
		$this->assign('activity_list', $activity_list);
		$this->display();
	}
}
