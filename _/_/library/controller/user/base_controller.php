<?php
/**
 * 基础类
 *
 */
class base_controller extends controller{
	public $user_session;
	public $store_session;
    public $allow_store_drp; //是否允许排他分销
    public $allow_platform_drp; //是否允许全网批发
    private $enabled_drp; //是否开启分销
	public function __construct(){
		parent::__construct();
        import('source.class.Margin');

		//积分商城允许action
		if($_SESSION['store']['is_point_mall'] == 1) {
			if(MODULE_NAME == 'goods') {
				redirect(url('user:pointgoods:index'));exit;
			}

			if(!in_array(MODULE_NAME,array('store','case','pointgoods','pointorder','setting','user','account','substore','cashier','attachment','widget'))) {
				redirect(url('user:store:index'));exit;
			}
		}

        if (Margin::check()) {
            $point_alias = Margin::point_alias();
            $this->assign('point_alias', $point_alias);
        }

        //是否允许使用批发
        $this->allow_platform_drp = option('config.open_platform_drp');
        $this->assign('allow_platform_drp', $this->allow_platform_drp);
        //是否允许使用分销
        $this->allow_store_drp = option('config.open_store_drp');
        $this->assign('allow_store_drp', $this->allow_store_drp);


        //判定pc站是否开启了 短信功能
        if (!option("config.sms_topdomain") || !option("config.sms_price") || !option("config.sms_sign") || !option("config.sms_open")) {
            $is_used_sms = '0'; //关闭使用
        } else {
            $is_used_sms = '1'; //开启使用
        }
        $this->is_used_sms = $is_used_sms;
        $this->assign('is_used_sms', $is_used_sms);
		
		
        $open_store = true;
        if (!empty($_GET['sessid'])) {
            $user = M('User');
            $userinfo = $user->checkUser(array('session_id' => trim($_GET['sessid'])));
            if (!empty($userinfo)) {
                $_SESSION['sync_store']     = true;
                $_SESSION['user']           = $userinfo;
            } else {
                pigcms_tips('该用户不存在！');
            }
            if (!empty($_GET['store_id'])) {
                $tmp_store = M('Store')->getStoreById($_GET['store_id'],$userinfo['uid']);
                if($tmp_store) {
                    if(empty($tmp_store['logo'])) $tmp_store['logo'] = 'default_shop_2.jpg';
                    $_SESSION['store'] = $tmp_store;
                } else {
                    pigcms_tips('该店铺不存在！');
                }
            }
			
			$data = array();
			$data['sync_store'] = true;
			$data['user'] = $userinfo['uid'];
			$data['store_id'] = $tmp_store['store_id'];

			setcookie('session',serialize($data),$_SERVER['REQUEST_TIME']+10000000,'/');
        }else{
            if($_SESSION['user']['app_id'] == 0){
                $_SESSION['sync_store'] = false;
            }
        }

		if(empty($_SESSION['user'])){
            if (!empty($_COOKIE['session'])) {
				$cookie_session = unserialize(stripslashes($_COOKIE['session']));
				$_SESSION['sync_store'] = $cookie_session['sync_store'];
				$userinfo = D('User')->where("uid = '" . $cookie_session['user'] . "'")->find();
				$_SESSION['user'] = $userinfo;
				
				if (!empty($cookie_session['store_id'])) {
					$tmp_store = M('Store')->getStoreById($cookie_session['store_id'], $userinfo['uid']);
					if($tmp_store) {
						if(empty($tmp_store['logo'])) {
							$tmp_store['logo'] = 'default_shop_2.jpg';
						}
						$_SESSION['store'] = $tmp_store;
					} else {
						pigcms_tips('该店铺不存在！');
					}
				}
            } else {
                //对接用户超时提示
                $is_sync     = option('config.weidian_version');
                if(empty($is_sync)) {
                    redirect(url('user:user:login'));
                }else{
                    redirect(url('user:user:sycn_timeout'));
                }
                
            }
		}

        //获取套餐id

        $package_id = intval($_SESSION['user']['package_id']);

        $this->assign('package_id',$package_id);


        if(!empty($package_id) && !$_SESSION['user']['package']){
            
            $package_info = D('Package')->where(array('pigcms_id'=>$package_id,'status'=>'1'))->find();
            if($package_info){
                 $_SESSION['user']['package']['time'] = $package_info['time'];
                 $_SESSION['user']['package']['store_nums'] = $package_info['store_nums'];
                 //$tmp_rbac_val = D('Rbac_package')->where(array('pid'=>$package_id))->find();
                 //$_SESSION['user']['package']['rbac_val'] = $tmp_rbac_val['rbac_val'];
            }
        }
      
       if($_SESSION['user']['package']['time'] > 0 && $_SESSION['store']['store_id'] && (ACTION_NAME != 'select') && $_SESSION['store']['drp_supplier_id'] == 0 ){
            $now = time();
            $date1_stamp = ($_SESSION['store']['expiration'] > 0)?$_SESSION['store']['expiration']:$_SESSION['store']['date_added']; 
            $date2_stamp = $now;
            list($date_1['y'], $date_1['m']) = explode("-", date('Y-m', $date1_stamp));
            list($date_2['y'], $date_2['m']) = explode("-", date('Y-m', $date2_stamp));
            $month = abs(($date_2['y'] - $date_1['y']) * 12 + $date_2['m'] - $date_1['m']);
            if ($month >= $_SESSION['user']['package']['time'] || $_SESSION['store']['is_available'] == 0) {

               D('Store')->where(array('store_id' => $_SESSION['store']['store_id']))->data(array('is_available'=>'0'))->save();
               $open_store = false;
               // pigcms_tips('当前店铺套餐过期，请联系管理员');
            }
       }
       

        if (empty($_SESSION['store']['store_id']) && (ACTION_NAME != 'store' && MODULE_NAME != 'setting')) {  //选择的店铺session过期
            $open_store = false;
        }

        $store_info = M('Store')->getStoreById($_SESSION['store']['store_id'], $_SESSION['store']['uid']);
        if (!empty($_SESSION['store']['drp_supplier_id'])) {
            if (empty($store_info['drp_approve'])) { //未审核店铺不能打开
                $open_store = false;
            }
        }

        if (empty($_SESSION['store']['drp_approve'])) {
            $_SESSION['store']['drp_approve'] = $store_info['drp_approve'];
        }

        if (empty($_SESSION['store']['drp_level'])) {
            $_SESSION['store']['drp_level'] = $store_info['drp_level'];
        }

        if(empty($_SESSION['store']['name'])) {
            $_SESSION['store']['name'] = $store_info['name'];
        }

        if(empty($_SESSION['store']['update_drp_store_info'])) {
            $_SESSION['store']['update_drp_store_info'] = $store_info['update_drp_store_info'];
        }

        if (empty($_SESSION['store']['drp_diy_store'])) { //不允许装修店铺
            $supplier = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $_SESSION['store']['store_id']))->find();
            if (!empty($supplier['supply_chain'])) {
                $supplier = explode(',', $supplier['supply_chain']);
                if (!empty($supplier[1])) {
                    $_SESSION['store']['top_supplier_id'] = !empty($supplier[1]) ? $supplier[1] : $_SESSION['store']['store_id'];
                }
            }
        }
        $_SESSION['drp_diy_store'] = $store_info['drp_diy_store'];

		$this->store_session = $_SESSION['store'];
		$this->assign('store_session',$_SESSION['store']);
		$this->user_session = $_SESSION['user'];
		
		if ($_SESSION['store']['type'] != 1 && !empty($_SESSION['store']['uid']) && !empty($_SESSION['user']) && $_SESSION['store']['uid'] != $_SESSION['user']['uid']) {
			if (IS_AJAX) {
				json_return(1000, '数据错误，请刷新页面');
			} else {
				redirect(url('store:select'));
				exit;
			}
		}
		
		
		$this->assign('user_session',$_SESSION['user']);
        $this->assign('open_store', $open_store); //是否能打开店铺
        $this->assign('store_select', url('store:select')); //店铺打不开跳转地址


        //是否启用分销
        $open_store_drp = option('config.open_store_drp');
        if (!$this->checkFx(true) && !$open_store_drp) {
            $this->assign('enabled_drp', false);
            $this->enabled_drp = false;
        } else {
            $this->assign('enabled_drp', true);
            $this->enabled_drp = true;
        }
        $this->assign('method', $method);
        //$this->setPackageConfig();
		$this->setPhysicalRbac();

        //初始化套餐数据
        import('source.class.PackageConfig');
        
        $rbacconfig = PackageConfig::setRbacConfig();

        //$rbac_val = explode(',',$_SESSION['user']['package']['rbac_val']);


         $cache_data_package = F('packages_rbac_val');
                
         if(!$cache_data_package){
            
            $packages_rbac_val_arr = D('Rbac_package')->field('pid,rbac_val')->select();
            
            foreach ($packages_rbac_val_arr as $key => $value) {
                $packages_rbac_val[$value['pid']] = $value['rbac_val'];
            }
            $cache_data_package = $packages_rbac_val;
            F('packages_rbac_val', $packages_rbac_val);
         }

        $user_package_rbac_val = $cache_data_package[$_SESSION['user']['package_id']];

        $rbac_val = explode(',',$user_package_rbac_val);

        $merge_arr = $this->createPackageRbacArr(MODULE_NAME,$rbacconfig);

        
        $rbac_result = array_intersect($merge_arr,$rbac_val);


        $package_all_access = PackageConfig::all_access();
        
        
        //echo PackageConfig::getRbacIdByArr($rbac_result,MODULE_NAME,ACTION_NAME);
        if(in_array(ACTION_NAME,$package_all_access[MODULE_NAME]) && $package_id > 0 && $_SESSION['store']['drp_supplier_id'] == 0){

            if(!in_array(PackageConfig::getRbacIdByArr($rbac_result,MODULE_NAME,ACTION_NAME), $rbac_result)){ 

                pigcms_tips('当前套餐无法使用此功能，请联系管理员');
            }   
        }
       

        $this->assign('rbac_result', $rbac_result);
        $this->assign('rbac_val',$rbac_val);

        //屏蔽活动
        if (option('system.HIDDEN_MENU') || $_SESSION['sync_store']) {
             $show_activity  = '0';
        //全部显示
        } else if (option('system.HIDDEN_MENU') == '' && $_COOKIE['buytime']<1462032000 && empty($_SESSION['sync_store'])) {
            $show_activity  = '1';
        //显示新活动
        } else if (option('system.HIDDEN_MENU') == '' && $_COOKIE['buytime']>1462032000 && empty($_SESSION['sync_store'])) {
            $show_activity  = '3';
        //显示老的
        } else {
            $show_activity  = '2';
        }
        $this->assign('show_activity',$show_activity);


		
		//版本检测
		$version = $_COOKIE['my_version'];
		$this->my_version = $version;
		$this->assign('my_version',$version);
	}
	
    // 设置门店管理员rbac权限 以下纳入权限判断
	protected function setPhysicalRbac(){

        $rbacOption = option('physical.rbac');
        $rbacLinkOption = option('physical.link');
        // 参与权限的方法
        $rbacConfig = array(
            'goods'=>array(
                    'index'=>'出售中商品',
                    'stockout'=>'已售罄商品',
                    'soldout'=>'仓库中的商品',
                    'category'=>'商品分组',
                    'product_comment'=>'商品评价',
                    'store_comment'=>'店铺评价',
                    'create'=>'添加商品',

                    'edit'=>'修改商品',
                    'del_product'=>'删除商品',
                    'checkoutProduct'=>'商品导出',
                    'goods_category_add'=>'分组添加',
                    'goods_category_edit'=>'分组修改',
                    'goods_category_delete'=>'分组删除',
                    'soldout'=>'商品下架',
                    'edit_group'=>'商品修改分组',
                    'save_qrcode_activity'=>'保存扫码活动',
                    'get_qrcode_activity'=>'获取扫码活动',
                    'del_qrcode_activity'=>'删除扫码活动',
                    'del_comment'=>'删除评论',
                    'set_comment_status'=>'修改评论审核状态',
                    'checkoutProduct'=>'导出商品列表excel',
                ),
            'order'=>array(
                    'dashboard'=>'订单概况',
                    'all'=>'所有订单',
                    'selffetch'=>'到店自提订单',
                    'codpay'=>'货到付款订单',
                    'order_return'=>'退货列表',
                    'order_rights'=>'维权列表',
                    'star'=>'加星订单',
                    'activity'=>'活动订单',
                    'add'=>'添加订单',
                    'orderprint'=>'订单打印机',
                    'check'=>'平台对账',
                    'fx_bill_check'=>'分销对账',
                    'ws_bill_check'=>'批发对账',

                    'order_checkout_csv'=>'订单导出',
                    'save_bak'=>'订单备注',
                    'add_star'=>'订单加星',
                    'cancel_status'=>'取消订单',
                    'package_product'=>'发货弹窗',
                    'complate_status'=>'交易完成',
                    'selffetch_status'=>'到店自提完成',
                    // 'order_reward'=>'手动订单满减',
                    // 'order_postage'=>'手动修改邮费',
                    'return_save'=>'退单',
                    'return_over'=>'退货完成',
                ),
            'trade'=>array(
                    'delivery'=>'物流工具',
                    'income'=>'收入提现',
                ),
				/*** yfz@20160603 增加订座权限 ***/
			'meaz'=>array(
                    'listtwo'=>'订单管理',
                    'listone'=>'茶桌管理',
                ),	
        );

        // 链接
        $rbacLink = array(
            'goods'=>array(
                    'create',
                    'index',
                    'stockout',
                    'soldout',
                    'category',
                    'product_comment',
                    'store_comment',
                ),
            'order'=>array(
                    'dashboard',
                    'all',
                    'selffetch',
                    'codpay',
                    'order_return',
                    'order_rights',
                    'star',
                    'activity',
                    'add',
                    'check',
                    'fx_bill_check',
                    'ws_bill_check',
                    'orderprint',
                ),
            'trade'=>array(
                    'delivery',
                    'income',
                ),
				/*** yfz@20160603 增加订座权限 ***/
			'meaz'=>array(
                    'listtwo',
                    'listone',
                ),	
        );


        if (is_null($rbacOption)) {
            option('physical.rbac', $rbacConfig);
        }

        if (is_null($rbacLinkOption)) {
            option('physical.link', $rbacLink);
        }

    }


    // 套餐
    protected function setPackageConfig(){

        import('source.class.PackageConfig');

        $defaultmodule = option('package.defaultmodule');
        $rbacconfig = option('package.rbacconfig');
        

        if (is_null($defaultmodule)) {
            $defaultmodule = PackageConfig::setDefaultModule();
            option('package.defaultmodule', $defaultmodule);
        }

        if (is_null($rbacconfig)) {
            $rbacconfig = PackageConfig::setRbacConfig();
            option('package.rbacconfig', $rbacconfig);
        }

    }

    //套餐创建权限数组
    protected function createPackageRbacArr($c,$rbacconfig){
        switch ($c) {
            case 'store':
                 $merge_arr = array_merge(array(1,2,3,4,5,6),array_keys($rbacconfig[2]),array_keys($rbacconfig[3]),array_keys($rbacconfig[4]),array_keys($rbacconfig[5]),array_keys($rbacconfig[6]));
                break;
            case 'case':
                 $merge_arr = array_merge(array(1,2,3,4,5,6),array_keys($rbacconfig[2]),array_keys($rbacconfig[3]),array_keys($rbacconfig[4]),array_keys($rbacconfig[5]),array_keys($rbacconfig[6]));
                break;
            case 'setting':
                 $merge_arr = array_merge(array(1,2,3,4,5,6),array_keys($rbacconfig[2]),array_keys($rbacconfig[3]),array_keys($rbacconfig[4]),array_keys($rbacconfig[5]),array_keys($rbacconfig[6]));
                break;
            case 'cashier':
                 $merge_arr = array_merge(array(5),array_keys($rbacconfig[5]));
                break;
            case 'goods':
                 $merge_arr = array_merge(array(7,16),array_keys($rbacconfig[7]),array_keys($rbacconfig[16]));
                break;
            case 'order':
                 $merge_arr = array_merge(array(8,9),array_keys($rbacconfig[8]),array_keys($rbacconfig[9]));
                break;
            case 'offline':
                 $merge_arr = array_merge(array(8,9),array_keys($rbacconfig[8]),array_keys($rbacconfig[9]));
                break;
            case 'trade':
                 $merge_arr = array_merge(array(8,9),array_keys($rbacconfig[8]),array_keys($rbacconfig[9]));
                break;
            case 'fans':
                 $merge_arr = array_merge(array(10),array_keys($rbacconfig[10]));
                break;
            case 'appmarket':
                 $merge_arr = array_merge(array(11,12),array_keys($rbacconfig[11]),array_keys($rbacconfig[12]));
                break;
            case 'reward':
                 $merge_arr = array_merge(array(11,12),array_keys($rbacconfig[11]),array_keys($rbacconfig[12]));
                break;
            case 'preferential':
                 $merge_arr = array_merge(array(11,12),array_keys($rbacconfig[11]),array_keys($rbacconfig[12]));
                break;
            case 'peerpay':
                 $merge_arr = array_merge(array(11,12),array_keys($rbacconfig[11]),array_keys($rbacconfig[12]));
                break;
            case 'tuan':
                 $merge_arr = array_merge(array(11,12),array_keys($rbacconfig[11]),array_keys($rbacconfig[12]));
                break;
            case 'unitary':
                 $merge_arr = array_merge(array(11,12),array_keys($rbacconfig[11]),array_keys($rbacconfig[12]));
                break;
            case 'wxapp':
                 $merge_arr = array_merge(array(11,12),array_keys($rbacconfig[11]),array_keys($rbacconfig[12]));
                break;
            case 'weixin':
                 $merge_arr = array(13);
                break;
            case 'fx':
                 $merge_arr = array_merge(array(14,15),array_keys($rbacconfig[14]),array_keys($rbacconfig[15]));
                break;
            case 'substore':
                 $merge_arr = array_merge(array(7,16,17),array_keys($rbacconfig[16]),array_keys($rbacconfig[17]));
               break;
    
            default:
                $merge_arr = $keys_arr = array_keys($rbacconfig);
                foreach ($keys_arr as $key => $value) {
                   $merge_arr = array_merge($merge_arr,array_keys($rbacconfig[$value]));
                }
                break;
        }
        return $merge_arr;
        
    }



    //分销检测(排他分销)
    protected function checkDrp($return = false, $notice = false)
    {
        //是否开启排他分销
        $open_store_drp = option('config.open_store_drp');
        //分销最大级别
        $max_store_drp_level = option('config.max_store_drp_level');
        //店铺是否允许分销（显示分销菜单）
        $this->allow_store_drp = false;
        if (!empty($open_store_drp) && (empty($this->store_session['drp_level']) || ($max_store_drp_level == 0 || $this->store_session['drp_level'] <= $max_store_drp_level))) { //开启排他分销，并且店铺分销级别在允许分销级别内
            $this->allow_store_drp = true;
        }
        if ($notice && empty($this->allow_store_drp)) {
            pigcms_tips('此功能暂时无法使用，请联系管理员');
        }
        if ($return) {
            return $this->allow_store_drp;
        } else {
            $this->assign('allow_store_drp', $this->allow_store_drp);
        }
    }
    //分销检测(全网分销)
    protected function checkFx($return = false, $notice = false)
    {
        $open_platform_drp = option('config.open_platform_drp');
        if ($notice && empty($open_platform_drp)) {
            pigcms_tips('此功能暂时无法使用，请联系管理员');
        }
        if ($return) {
            return $this->open_platform_drp = $open_platform_drp;
        } else {
            $this->assign('allow_platform_drp', $open_platform_drp);
        }
    }

    protected function enabled_drp()
    {
        return $this->enabled_drp;
    }
}
?>