<?php
/**
 * Created by PhpStorm.
 * User: pigcms_21
 * Date: 2015/5/11
 * Time: 10:29
 */
require_once dirname(__FILE__).'/global.php';

if (IS_POST && empty($_SESSION['wap_user'])) {
    json_return(10000, '操作失败，您还未登录');
} else if (empty($_SESSION['wap_user']) && stripos($_SERVER['REQUEST_URI'], 'drp_register.php') && !empty($_GET['id'])) {
    $now_store = M('Store')->wap_getStore($_GET['id']);
    setcookie('wap_store_id', $now_store['store_id'], $_SERVER['REQUEST_TIME'] + 10000000, '/');
} else if (empty($_SESSION['wap_user'])) {
    redirect('./login.php');
}

if (!option('config.open_store_drp')) { //未开启排他分销
    if (!empty($_COOKIE['wap_store_id'])) {
        redirect('./ucenter.php?id=' . $_COOKIE['wap_store_id']);
    } else {
        pigcms_tips('抱歉，您没有权限访问','none');
    }
}

$flag = true;
if (!empty($now_store)) {
    $tmp_store = $now_store;
} else {
    if (!empty($_SESSION['wap_drp_store']['store_id'])) {
        $store_id = $_SESSION['wap_drp_store']['store_id'];
    } else {
        $store_id = intval(trim($_GET['id']));
    }
    $tmp_store = D('Store')->field('store_id,drp_supplier_id,uid,open_drp_limit,drp_limit_buy,drp_limit_share,drp_limit_condition')->where(array('store_id' => $store_id))->find();
    if (!empty($tmp_store['drp_supplier_id'])) { //分销商
        $supplier = D('Store_supplier')->field('supply_chain')->where(array('seller_id' => $tmp_store['store_id'], 'type' => 1))->find();
        if (!empty($supplier['supply_chain'])) {
            $supplier = explode(',', $supplier['supply_chain']);
            if (!empty($supplier[1])) {
                $supplier_info = D('Store')->field('open_drp_limit,drp_limit_buy,drp_limit_share,drp_limit_condition')->where(array('store_id' => $supplier[1]))->find();
                $tmp_store['open_drp_limit']      = $supplier_info['open_drp_limit'];
                $tmp_store['drp_limit_buy']       = $supplier_info['drp_limit_buy'];
                $tmp_store['drp_limit_share']     = $supplier_info['drp_limit_share'];
                $tmp_store['drp_limit_condition'] = $supplier_info['drp_limit_condition'];
            }
        }
    }
}
if (!empty($tmp_store['open_drp_limit']) && $_SESSION['wap_user']['uid'] != $tmp_store['uid']) { //分销限制
    if (!empty($tmp_store['drp_limit_buy']) && $tmp_store['drp_limit_buy'] > 0) { //消费满多少
        $array = array();
        $array['store_id'] = $store_id;
        $array['status']   = array('in', array(2,3,4,7));
        if (!empty($_SESSION['wap_user']['uid'])) {
            $array['uid'] = $_SESSION['wap_user']['uid'];
        } else if (!empty($_COOKIE['uid'])) {
            $array['uid'] = $_COOKIE['uid'];
        } else if (session_id()) {
            $array['session_id'] = session_id();
        }
        $total = D('Order')->where($array)->sum('total');
        if ($total < $tmp_store['drp_limit_buy']) {
            $flag = false;
        }
    }
    $flag1 = true;
    /*if (!empty($tmp_store['drp_limit_share'])) { //分享满多少
        $flag1 = true;
    }*/
    //if (!empty($tmp_store['drp_limit_condition'])) { // 两个条件必须满足才可分销
        if (!($flag && $flag1)) {
            if (!empty($tmp_store['drp_limit_buy']) && !empty($tmp_store['drp_limit_share']) && $tmp_store['drp_limit_buy'] > 0 && $tmp_store['drp_limit_share'] > 0) {
                pigcms_tips('亲，还差一步哦，在本店消费满 ' . $tmp_store['drp_limit_buy'] . '元，同时分享本店 ' . $tmp_store['drp_limit_share'] . '次，即可申请成为本店分销商，点击【<a href="./home.php?id=' . $tmp_store['store_id'] . '">返回店铺</a>】。', 'none');
            } else if (!empty($tmp_store['drp_limit_buy']) && $tmp_store['drp_limit_buy'] > 0) {
                pigcms_tips('亲，还差一步哦，在本店消费满 ' . $tmp_store['drp_limit_buy'] . '元，即可申请成为本店分销商，点击【<a href="./home.php?id=' . $tmp_store['store_id'] . '">返回店铺</a>】。', 'none');
            } else if (!empty($tmp_store['drp_limit_share']) && $tmp_store['drp_limit_share'] > 0) {
                pigcms_tips('亲，还差一步哦，分享本店 ' . $tmp_store['drp_limit_share'] . '次，即可申请成为本店分销商，点击【<a href="./home.php?id=' . $tmp_store['store_id'] . '">返回店铺</a>】。', 'none');
            }
        }
    /*} else {
        if (!($flag || $flag1)) {
            if (!empty($tmp_store['drp_limit_buy']) && !empty($tmp_store['drp_limit_share'])) {
                pigcms_tips('亲，还差一步哦，在本店消费满 ' . $tmp_store['drp_limit_buy'] . '元，或分享本店 ' . $tmp_store['drp_limit_share'] . '次，即可申请成为本店分销商。', 'none');
            } else if (!empty($tmp_store['drp_limit_buy'])) {
                pigcms_tips('亲，还差一步哦，在本店消费满 ' . $tmp_store['drp_limit_buy'] . '元，即可申请成为本店分销商。', 'none');
            } else if (!empty($tmp_store['drp_limit_share'])) {
                pigcms_tips('亲，还差一步哦，分享本店 ' . $tmp_store['drp_limit_buy'] . '次，即可申请成为本店分销商。', 'none');
            }
        }
    }*/
}