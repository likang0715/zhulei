<?php
/**
 * 判断用户openid是否关注活动token所属店铺
 * POST
 * @param string token 对接活动token
 * @param string openid 平台openid
 * @return intval 是否关注 1是 0否
 */
define('PIGCMS_PATH', dirname(__FILE__).'/../../');
require_once PIGCMS_PATH.'source/init.php';
require_once '../functions.php';

$act = trim($_GET['act']);

if (empty($act)) {
	echo 'need param';
	exit;
}

// CURL POST 传输
	function curl_post2($url,$post)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$output = curl_exec($ch);
		curl_close($ch);
		//返回获得的数据
		return $output;
	}

switch ($act) {
	case 'pigcms':

		$post_data = array(
			'p' => 1,
			'token' => '4d8d3b3864af785c',
			'keyword' => '',
		);

		/* sign 串 */
		$sort_data = $post_data;
		$sort_data['salt'] = 'wenshui588_11232015';
		ksort($sort_data);
		$sign_key = sha1(http_build_query($sort_data));
		/* sign 串 */

		$post_data['sign_key'] = $sign_key;
		$url = "http://www.tcjjyg.cn/api/activity/act_goods.php";//微店接收数据的地址
		// echo $url;exit;
		$curlResult = curl_post2($url,$post_data);
		$return = json_decode($curlResult,true);
		dump($return);exit;
		// 
		break;
	case 'weidian':

		$post_data = array(
			'p' => 1,
			'token' => '905d3c75b2265f27',
			'keyword' => '',
		);

		/* sign 串 */
		$sort_data = $post_data;
		$sort_data['salt'] = 'pigcms';
		ksort($sort_data);
		$sign_key = sha1(http_build_query($sort_data));
		/* sign 串 */

		$post_data['sign_key'] = $sign_key;
		$url = "http://www.weidian.com/api/activity/act_goods.php";//微店接收数据的地址
		// echo $url;exit;
		$curlResult = curl_post2($url,$post_data);
		$return = json_decode($curlResult,true);
		dump($return);exit;
		// 
		break;
	case 'isbind':
		$postToken = '7835012370f03916';
		$postOpenid = 'oRiG1wAtyvO50pevnGdBv5nYkedk';

		$isAttention = M('Activity_spread')->isSubscribe($postToken, $postOpenid);
		var_dump($isAttention);exit;
		break;
	
	case 'getquantity':
		$product_id = 94;
		$sku_id = 238;

		if ($sku_id) {
		    $productInfo = D('Product_sku')->where(array('product_id'=>$product_id, 'sku_id'=>$sku_id))->find();
		} else {
		    $productInfo = D('Product')->where(array('product_id'=>$product_id))->find();
		}

		dump($productInfo);exit;
		break;

	case 'quantity':

		$postProductId = 94;
		$postSkuId = 238;
		$postStoreId = 33;
		$postType = 'minus';

		if ($sku_id) {
            $productInfo = D('Product_sku')->where(array('product_id'=>$postProductId, 'sku_id'=>$postSkuId))->find();
        } else {
            $productInfo = D('Product')->where(array('product_id'=>$postProductId))->find();
        }

        if ($postType == 'minus' && $num > $productInfo['quantity']) {
            $error_code = 1005;
            $error_msg = '库存扣除数量超限';
            $num = 0;

            echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'num' => $productInfo['quantity']));
            exit;
        }

        if ($postType == 'minus') {
            $newNum = $productInfo['quantity'] - $num;
        } else {
            $newNum = $productInfo['quantity'] + $num;
        }

        $upResult = D('Product')->where(array('product_id'=>$postProductId))->data(array('quantity'=>$newNum))->save();
        if ($upResult) {
            $error_code = 0;
            $error_msg = '库存修改成功';
            $num = $newNum;
        } else {
            $error_code = 1005;
            $error_msg = '库存修改失败，稍后再试';
            $num = 0;
        }

        echo json_encode(array('error_code' => $error_code, 'error_msg' => $error_msg, 'num' => $num));

		dump($productInfo);exit;
		break;

	case 'update':
		exit;
		$sex = array(0, 1, 2);
		$province = array('广东省', '青海省', '四川省', '海南省', '陕西省', '甘肃省', '云南省', '湖南省', '湖北省', '黑龙江省', '贵州省', '山东省', '江西省', '河南省', '河北省', '山西省', '安徽省', '福建省', '浙江省', '江苏省', '吉林省', '辽宁省', '台湾省', '新疆维吾尔自治区', '广西壮族自治区', '宁夏回族自治区', '内蒙古自治区', '西藏自治区', '北京市', '天津市', '上海市', '重庆市', '香港', '澳门');
		// print_r($province[array_rand($province, 1)]);exit;
		$users = D('User')->select();
		foreach ($users as $user) {
			$sex_tmp = $sex[array_rand($sex, 1)];
			$province_tmp = $province[array_rand($province, 1)];
			D('User')->where(array('uid'=>$user['uid']))->data(array('sex'=>$sex_tmp,'province'=>$province_tmp))->save();
		}
		// dump($users);exit;
		break;

	case 'test_msg':

			import('source.class.Factory');
			import('source.class.MessageFactory');
			import('source.class.sendtemplate');

			$openid = "oRiG1wAtyvO50pevnGdBv5nYkedk";
			$wx_tpl_no = "OPENTM203170813";
			$template_data = array(
				'wecha_id' => $openid,
				'first'    => 'xxxxx',
				'keyword1' => 11,
				'keyword2' => 'xxxx',
				'keyword3' => 32,
				'remark'   => '请尽快补充库存'
			);
			$params['template'] = array('template_id' => $wx_tpl_no, 'template_data' => $template_data,'sendType'=> '1');
			$param_array[]='TemplateMessage';
			MessageFactory::method($params, $param_array);
			echo 'aaaaa';
			dump($result);exit;

	case 'sql':

		$admin_module_action = array(
			'Ng_word' => array(
					'name' => '后台敏感词基础类',
					'child' => array(
						'index' => '列表',
						'add' => '添加',
						'delete' => '删除',
						'edit' => '修改',
					),
				),
			'Adver' => array(
					'name' => '广告管理',
					'child' => array(
						'index' => '分类列表',
						'cat_modify' => '分类添加',
						'cat_amend' => '分类编辑',
						'cat_del' => '分类删除',
						'adver_list' => '广告列表',
						'adver_modify' => '广告添加',
						'adver_amend' => '广告编辑',
						'adver_del' => '广告删除',
					),
				),
			'Bank' => array(
					'name' => '收款银行',
					'child' => array(
						'index' => '列表',
						'modify' => '添加',
						'amend' => '修改',
						'del' => '删除',
					),
				),
			'Config' => array(
					'name' => '站点配置',
					'child' => array(
						'index' => '站点配置',
						'amend' => '站点修改',
						'show' => '微信API接口填写信息',
						'sendmsg' => '测试短信接口',
					),
				),
			'Credit' => array(
					'name' => '总后台积分配置',
					'child' => array(
						'index' => '配置表单',
						'chgStatus' => '修改配置记录状态',
						'chgTodayCreditWeight' => '修改积分权数',
						'rules' => '查看规则',
						'upRules' => '修改规则',
						'depositRecord' => '保证金记录',
						'record' => '积分记录',
					),
				),
			'Diymenu' => array(
					'name' => '微信自定义菜单',
					'child' => array(
						'index' => '列表',
						'class_add' => '添加',
						'class_edit' => '修改',
						'class_del' => '删除',
						'class_send' => '发送到微信设置',
					),
				),
			'Express' => array(
					'name' => '快递公司',
					'child' => array(
						'index' => '列表',
						'modify' => '添加',
						'amend' => '修改',
						'del' => '删除',
					),
				),
			'Flink' => array(
					'name' => '友情链接',
					'child' => array(
						'index' => '列表',
						'modify' => '添加',
						'amend' => '修改',
						'del' => '删除',
					),
				),
			'Home' => array(
					'name' => '微信首页回复',
					'child' => array(
						'index' => '首页回复表单',
						'first' => '首次关注回复',
						'other' => '关键词回复',
						'other_add' => '关键词添加',
						'other_edit' => '关键词修改',
						'other_del' => '关键词删除',
					),
				),
			'Index' => array(
					'name' => '总后台首页',
					'child' => array(
						'main' => '后台首页',
						'amend_pass' => '修改密码',
						'amend_profile' => '修改个人资料',
						'cache' => '清除缓存',
						'offical_tore' => '创建官方店铺',
					),
				),
			'Order' => array(
					'name' => '订单',
					'child' => array(
						'dashboard' => '账务概况',
						'paymentRecord' => '平台收款记录',
						'incomeRecord' => '平台收益',
						'index' => '所有订单(不含临时订单)',
						'selffetch' => '到店自提订单(不含临时订单)',
						'codpay' => '货到付款订单(不含临时订单)',
						'payagent' => '代付的订单(不含临时订单)',
						'refund_peerpay' => '退款',
						'withdraw' => '提现记录',
						'withdraw_status' => '获取提现状态',
						'smspay' => '短信订单列表',
						'detail' => '订单详情',
						'check' => '对账列表',
						'checklog' => '对账日志',
						'alert_check' => '详细对账抽成比例',
						'check_status' => '修改出账状态',
						'return_order' => '退货列表',
						'return_detail' => '退货详情',
						'rights' => '维权列表',
						'rights_detail' => '维权详情',
						'rights_status' => '修改维权状态',
					),
				),
			'Product_property' => array(
					'name' => '商品属性',
					'child' => array(
						'property' => '商品属性列表',
						'property_status' => '修改商品属性分类的状态',
						'propertyvalue_status' => '修改商品属性值的分类状态',
						'property_edit' => '商品属性修改',
						'property_del' => '属性删除',
						'property_add' => '属性添加',
						'propertyValue' => '商品属性值列表',
						'getOnePropertyValueList' => '商品属性对应商品属性值的列表',
						'propertyValue_edit' => '商品属性修改',
						'propertyValue_del' => '商品属性删除',
					),
				),
			'Product' => array(
					'name' => '商品列表',
					'child' => array(
						'index' => '产品列表',
						'category' => '分类列表',
						'status' => '修改产品状态',
						'category_add' => '添加商品分类',
						'category_edit' => '修改',
						'category_del' => '删除',
						'category_status' => '状态修改',
						'group' => '产品组列表',
						'fxlist' => '被分销的商品列表',
						'comment_del' => '评价删除',
						'comment_status' => '评价状态修改',
						'comment' => '评价列表',
					),
				),
			'Search_hot' => array(
					'name' => '热门关键词',
					'child' => array(
						'index' => '列表',
						'modify' => '添加',
						'amend' => '修改',
						'del' => '删除',
					),
				),
			'Slider' => array(
					'name' => '导航管理',
					'child' => array(
						'index' => '分类列表',
						'cat_modify' => '分类添加',
						'cat_amend' => '分类修改',
						'cat_del' => '分类删除',
						'slider_list' => '导航列表',
						'slider_modify' => '导航添加',
						'slider_amend' => '导航修改',
						'slider_del' => '导航删除',
					),
				),
			'Store' => array(
					'name' => '店铺',
					'child' => array(
						'index' => '店铺列表',
						'detail' => '店铺详情',
						'certification_detail' => '认证详情',
						'status' => '状态修改',
						'approve' => '认证通过',
						'inoutdetail' => '收支明细',
						'category' => '主营类目列表',
						'category_add' => '主营类目添加',
						'category_edit' => '主营类目编辑',
						'category_status' => '主营类目状态修改',
						'category_del' => '主营类目删除',
						'brandType' => '品牌类别列表',
						'brandType_status' => '品牌类别状态',
						'brandtype_add' => '品牌类别添加',
						'brandtype_edit' => '品牌类别修改',
						'brandtype_del' => '品牌类别删除',
						'brand' => '品牌列表',
						'brand_status' => '品牌状态修改',
						'brand_add' => '品牌添加',
						'brand_edit' => '品牌编辑',
						'brand_del' => '品牌删除',
						'activityManage' => '获取对接营销活动列表',
						'activityRecommendAdd' => '对接活动添加',
						'activityRecommend' => '本站活动记录',
						'activityRecommendDel' => '对接活动删除',
						'activityRecommendRecAdd' => '添加到本站活动记录',
						'activityRecommendRecDel' => '本站活动记录删除',
						'check' => '店铺对账',
						'comment_del' => '评价删除',
						'comment_status' => '评价状态修改',
						'comment' => '店铺商品评价',
						'diyAttestation' => '认证自定义表单',
						'diyAttestation_del' => '认证自定义表单删除',
						'drp_degree' => '分销商等级',
						'drp_degree_add' => '分销商等级添加',
						'drp_degree_edit' => '分销商等级修改',
						'drp_degree_status' => '分销商等级状态修改',
						'drp_degree_del' => '分销商等级删除',
					),
				),
			'Sys_product_property' => array(
					'name' => '系统商品属性',
					'child' => array(
						'propertyType' => '商品属性类别',
						'propertytype_status' => '商品属性类别状态',
						'propertyType_add' => '商品属性类别添加',
						'propertyType_edit' => '商品属性类别修改',
						'propertyType_del' => '商品属性类别删除',
						'property' => '商品属性',
						'property_status' => '商品属性状态',
						'property_edit' => '商品属性修改',
						'property_del' => '商品属性删除',
						'property_add' => '商品属性添加',
						'propertyValue' => '商品属性值',
						'propertyValue_add' => '商品属性值添加',
						'propertyvalue_status' => '商品属性值状态修改',
						'propertyValue_edit' => '商品属性值修改',
						'propertyValue_del' => '商品属性值删除',
					),
				),
			'Tag' => array(
					'name' => '标签tag',
					'child' => array(
						'index' => '列表',
						'add' => '添加',
						'delete' => '删除',
						'edit' => '修改',
						'status' => '状态修改',
					),
				),
			'TemplateMsg' => array(
					'name' => '模板消息',
					'child' => array(
						'index' => '列表和操作',
					),
				),
			'User' => array(
					'name' => '用户',
					'child' => array(
						'index' => '列表',
						'amend' => '用户修改',
						'stores' => '查看拥有店铺列表',
						'tab_store' => '进入商家店铺 ',
						'checkout' => '导出列表',
					),
				),
		);
		exit;
		$time = time();

		foreach ($admin_module_action as $key => $val) {

			if (D('System_rbac_menu')->where(array('module'=>$key, 'fid'=>0))->find()) {
				continue;
			} else {
				D('System_rbac_menu')->data(array(
					'name' => $val['name'],
					'module' => $key,
					'add_time' => $time,
				))->add();
			}

		}

		foreach ($admin_module_action as $key => $val) {

			if (empty($val['child'])) {
				continue;
			}

			$p_tmp = D('System_rbac_menu')->where(array('module'=>$key))->find();
			foreach ($val['child'] as $k => $v) {

				if (D('System_rbac_menu')->where(array('module'=>$key, 'action'=>$k))->find()) {
					continue;
				} else {
					D('System_rbac_menu')->data(array(
						'fid' => $p_tmp['id'],
						'name' => $v,
						'module' => $key,
						'action' => $k,
						'add_time' => $time,
					))->add();
				}

			}

		}

		break;

	default:
		
		break;
}
