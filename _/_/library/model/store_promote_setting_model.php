<?php
/**
 * 分销单页推广模型
 * User: pigcms-s
 * Date: 2015/11/10
 * Time: 15:07
 */
class store_promote_setting_model extends base_model {


    public function createImage($result, $qrecode, $userInfo, $supplier_info)
    {
        import('source.class.Poster');
        $savename= date('YmdHis') . mt_rand(1, 100).'_reply'.'.png';
        $root = PIGCMS_PATH . 'cache/images/promote_qrcode/';

        $bannerConfig = $this->object_to_array(json_decode(htmlspecialchars_decode($result['banner_config'])));

        $posterModel = new Poster();

        $createRes = $posterModel->setVars(array(
            'username'=> mb_substr($userInfo['nickname'], 0, 8, 'utf-8'),//网名限制8个字
            //'sex'=> '男',
            'company'=> empty($result['store_nickname']) ? $supplier_info['name'] : $result['store_nickname'],
            'start_time' => date('Y-m-d',$result['start_time']),
            'end_time' => date('Y-m-d',$result['end_time']),
            'desc' => $result['descr'],
            'name' => ''
        ))->setConfig(array(
            'avatar' => !empty($userInfo['avatar']) ? getAttachmentUrl($userInfo['avatar'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
            //'qrcode' => 'http://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQE%2F8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL1Z6dmtVZlhtb1RMWU9aR2U3aFdDAAIELMQdVwMEgDoJAA%3D%3D',
            'qrcode' => strpos($qrecode['ticket'],'https') !== false ? str_replace('https:','http:',$qrecode['ticket']) : $qrecode['ticket'],
            'qrcode_url' => $qrecode['qrcode_url'],
            'logo' => !empty($supplier_info['logo']) ? getAttachmentUrl($supplier_info['logo'], FALSE) : getAttachmentUrl('images/default_shop.png', FALSE),
        ))->create($bannerConfig);

        $posterModel->save($root.$savename);

        return array('/cache/images/promote_qrcode/'.$savename,'image');
    }

    //对象转数组
    public function object_to_array($stdclassobject)
    {
        $_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
        foreach ($_array as $key => $value)
        {
            $value = (is_array($value) || is_object($value)) ? $this->object_to_array($value) : $value;
            $array[$key] = $value;
        }
        return $array;
    }
}