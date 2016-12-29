<?php
class recognition_model extends base_model{
	public function get_new_qrcode($third_type,$third_id){
		$appid     = option('config.wechat_appid');
		$appsecret = option('config.wechat_appsecret');
		
		if(empty($appid) || empty($appsecret)){
			return(array('error_code'=>true,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
		}
		
		$qrcode_return = $this->add_new_qrcode_row($third_type,$third_id);
		
		if($qrcode_return['error_code']){
			return $qrcode_return;
		}
		
		import('ORG.Net.Http');
		$http = new Http();
		
		//微信授权获得access_token
		import('WechatApi');

		$tokenObj 	= new WechatApi(array('appid'=>$appid,'appsecret'=>$appsecret));
		
		$access_token 	= $tokenObj->get_access_token();
		
		$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token['access_token'];
		$post_data['action_name']='QR_LIMIT_SCENE';
		$post_data['action_info']['scene']['scene_id'] = $qrcode_return['qrcode_id'];
		
		$json = $http->curlPost($qrcode_url,json_encode($post_data));
		if (!$json['errcode']){
			$qrcode_save_return = $this->save_qrcode($qrcode_return['qrcode_id'],$json['ticket'],$third_type,$third_id);
			return $qrcode_save_return;	
		}else {
			return(array('error_code'=>true,'msg'=>'发生错误：错误代码'.$json['errcode'].',微信返回错误信息：'.$json['errmsg']));
		}
	}

	//生成二维码
	public function get_attention_qrcode($info = ""){
		$appid     = option('config.wechat_appid');
		$appsecret = option('config.wechat_appsecret');
		
		if(empty($appid) || empty($appsecret)){
			return(array('error_code'=>true,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
		}
		
		$database_sub_qrcode = D('Plat_sub_qrcode');
		
		$database_sub_qrcode->where(array('timestamp'=>array('<',($_SERVER['REQUEST_TIME']-604800))))->delete();
		$last_info = $database_sub_qrcode->order("id desc")->limit(1)->find();
		if($last_info['id']>=99999999) {
			//清空
			$sql = "delete from ".option('system.DB_PREFIX')."plat_sub_qrcode";
			$this->db->query($sql);
			$sql="alter table ". option('system.DB_PREFIX') ."plat_sub_qrcode auto_increment=1";
			$this->db->query($sql);
		}
		$qrcode_id = $database_sub_qrcode->data(array('timestamp'=>time()))->add();

		if(empty($qrcode_id)){
			return(array('error_code'=>true,'msg'=>'获取二维码错误！无法写入数据到数据库。请重试。'));
		} else {

		}
		
		import('Http');
		$http = new Http();
		
		//微信授权获得access_token
		import('WechatApi');

		$tokenObj 	= new WechatApi(array('appid'=>$appid,'appsecret'=>$appsecret));
		
		$access_token 	= $tokenObj->get_access_token();

		$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token['access_token'];
		$post_data['expire_seconds'] = 604800;
		$post_data['action_name'] = 'QR_SCENE';
		$post_data['action_info']['scene']['scene_id'] = $qrcode_id;
		
		$json = $http->curlPost($qrcode_url,json_encode($post_data));

		if (!$json['errcode']){
			//100000322
			$condition_sub_qrcode['id'] = $qrcode_id;
			$data_sub_qrcode['ticket'] = $json['ticket'];
			  if($database_sub_qrcode->where($condition_sub_qrcode)->data($data_sub_qrcode)->save()){
				return(array('error_code'=>false,'id'=>$qrcode_id,'msg'=>$last_sql,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
			}else{
				$database_sub_qrcode->where($condition_login_qrcode)->delete();
				return(array('error_code'=>true,'msg'=>'获取二维码错误！保存二维码失败。请重试。'));
			}
		}else{
			$condition_sub_qrcode['id'] = $qrcode_id;
			$database_sub_qrcode->where($condition_sub_qrcode)->delete();
			return(array('error_code'=>true,'msg'=>'发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
		}
	}	
	
	//生成登录用的临时二维码
	public function get_login_qrcode($info = ""){
		$appid     = option('config.wechat_appid');
		$appsecret = option('config.wechat_appsecret');
		
		if(empty($appid) || empty($appsecret)){
			return(array('error_code'=>true,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
		}
		
		$database_login_qrcode = D('Login_qrcode');
		$data_login_qrcode['add_time'] = $_SERVER['REQUEST_TIME'];
		$database_login_qrcode->where(array('add_time'=>array('<',($_SERVER['REQUEST_TIME']-604800))))->delete();
		$qrcode_id = $database_login_qrcode->data($data_login_qrcode)->add();
		$last_sql = $database_login_qrcode->last_sql;
		if(empty($qrcode_id)){
			return(array('error_code'=>true,'msg'=>'获取二维码错误！无法写入数据到数据库。请重试。'));
		} else {
			//写入注册信息
			if(!empty($info['phone']) && !empty($info['nickname']) && !empty($info['password'])) {
				$other_info = array('password'=>$info['password'],'phone'=>$info['phone'],'nickanme'=>$info['nickname']);
				$other_info = serialize($other_info);
				$database_login_qrcode->where(array('id'=>$qrcode_id))->data(array('phone'=>$info['phone'],'other_info'=>$other_info))->save();
			}
		}
		
		import('Http');
		$http = new Http();
		
		//微信授权获得access_token
		import('WechatApi');

		$tokenObj 	= new WechatApi(array('appid'=>$appid,'appsecret'=>$appsecret));
		
		$access_token 	= $tokenObj->get_access_token();

		$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token['access_token'];
		$post_data['expire_seconds'] = 604800;
		$post_data['action_name'] = 'QR_SCENE';
		$post_data['action_info']['scene']['scene_id'] = $qrcode_id;
		
		$json = $http->curlPost($qrcode_url,json_encode($post_data));

		if (!$json['errcode']){
			//100000322
			$condition_login_qrcode['id'] = $qrcode_id;
			$data_login_qrcode['ticket'] = $json['ticket'];
			if($database_login_qrcode->where($condition_login_qrcode)->data($data_login_qrcode)->save()){
				return(array('error_code'=>false,'id'=>$qrcode_id,'msg'=>$last_sql,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
			}else{
				$database_login_qrcode->where($condition_login_qrcode)->delete();
				return(array('error_code'=>true,'msg'=>'获取二维码错误！保存二维码失败。请重试。'));
			}
		}else{
			$condition_login_qrcode['id'] = $qrcode_id;
			$database_login_qrcode->where($condition_login_qrcode)->delete();
			return(array('error_code'=>true,'msg'=>'发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
		}
	}

	//生成获取位置临时二维码
	public function get_location_qrcode(){
		$appid     = option('config.wechat_appid');
		$appsecret = option('config.wechat_appsecret');
		
		if(empty($appid) || empty($appsecret)){
			return(array('error_code'=>true,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
		}
		
		$database_location 	= D('Location_qrcode');
		$data_location['add_time'] = $_SERVER['REQUEST_TIME'];
		$database_location->where(array('add_time'=>array('<',($_SERVER['REQUEST_TIME']-604800))))->delete();
		$qrcode_id = $database_location->data($data_location)->add();
		if(empty($qrcode_id)){
			return(array('error_code'=>true,'msg'=>'获取二维码错误！无法写入数据到数据库。请重试。'));
		}
		
		import('Http');
		$http = new Http();
		
		//微信授权获得access_token
		import('WechatApi');

		$tokenObj 	= new WechatApi(array('appid'=>$appid,'appsecret'=>$appsecret));
		
		$access_token 	= $tokenObj->get_access_token();

		$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token['access_token'];
		$post_data['expire_seconds'] = 604800;
		$post_data['action_name'] = 'QR_SCENE';
		$post_data['action_info']['scene']['scene_id'] = $qrcode_id;
		
		$json = $http->curlPost($qrcode_url,json_encode($post_data));

		if (!$json['errcode']){
			$condition_login_qrcode['id'] 	= $qrcode_id;
			$data_login_qrcode['ticket'] 	= $json['ticket'];
			if($database_location->where($condition_login_qrcode)->data($data_login_qrcode)->save()){
				return(array('error_code'=>false,'id'=>$qrcode_id,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
			}else{
				$database_location->where($condition_login_qrcode)->delete();
				return(array('error_code'=>true,'msg'=>'获取二维码错误！保存二维码失败。请重试。'));
			}
		}else{
			$condition_login_qrcode['id'] = $qrcode_id;
			$database_location->where($condition_login_qrcode)->delete();
			return(array('error_code'=>true,'msg'=>'发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
		}
	}

	//生成临时二维码
	public function get_tmp_qrcode($qrcode_id){
		$appid     = option('config.wechat_appid');
		$appsecret = option('config.wechat_appsecret');
		
		if(empty($appid) || empty($appsecret)){
			return(array('error_code'=>1,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
		}
		
		import('Http');
		$http = new Http();
		
		//微信授权获得access_token
		import('WechatApi');

		$tokenObj 	= new WechatApi(array('appid'=>$appid,'appsecret'=>$appsecret));
		
		$access_token 	= $tokenObj->get_access_token();

		$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token['access_token'];

		$post_data['expire_seconds'] = 604800;
		$post_data['action_name'] = 'QR_SCENE';
		$post_data['action_info']['scene']['scene_id'] = $qrcode_id;

		$json = $http->curlPost($qrcode_url,json_encode($post_data));
		if (!$json['errcode']){
			return(array('error_code'=>0,'id'=>$qrcode_id,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
		}else{
			return(array('error_code'=>1,'msg'=>'产生二维码发生错误。发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
		}
	}


    //生成永久二维码
    public function get_limit_scene_qrcode($qrcode_id, $store_id){
        $appid     = option('config.wechat_appid');
        $appsecret = option('config.wechat_appsecret');

        if(empty($appid) || empty($appsecret)){
            return(array('error_code'=>1,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
        }

              echo $appid.'<br>';
			  echo $appsecret.'<br>';
        import('Http');
        $http = new Http();

        import('WechatApi');
echo $store_id.'<br>';
        $result = M('Weixin_bind')->get_access_token($store_id);
 print_r($result);
        $tokenObj 	= new WechatApi(array('appid'=>$appid,'appsecret'=>$appsecret));
     
        $qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$result['access_token'];

        $post_data['action_name'] = 'QR_LIMIT_STR_SCENE';
        $post_data['action_info']['scene']['scene_str'] = $qrcode_id;

        $json = $http->curlPost($qrcode_url,json_encode($post_data));
        if (!$json['errcode']){
            return(array('error_code'=>$result,'id'=>$qrcode_id,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
        }else{
            return(array('error_code'=>$result,'msg'=>'产生二维码发生错误。发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
        }
    }


    //生成平台永久二维码
    public function get_platform_limit_scene_qrcode($qrcode_id) {
        $appid     = option('config.wechat_appid');
        $appsecret = option('config.wechat_appsecret');

        if(empty($appid) || empty($appsecret)){
            return(array('error_code'=>1,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
        }

        import('Http');
        $http = new Http();

        //微信授权获得access_token
        import('WechatApi');

        $tokenObj 	= new WechatApi(array('appid'=>$appid,'appsecret'=>$appsecret));
       
        $access_token 	= $tokenObj->get_access_token();
       
        $qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token['access_token'];

        $post_data['action_name'] = 'QR_LIMIT_STR_SCENE';
        $post_data['action_info']['scene']['scene_str'] = $qrcode_id;

        $json = $http->curlPost($qrcode_url,json_encode($post_data));
        if (!$json['errcode']){
            return(array('error_code'=>0,'id'=>$qrcode_id,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
        }else{
            return(array('error_code'=>1,'msg'=>'产生二维码发生错误。发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
        }
    }


	//生成分销临时二维码
	public function get_drp_tmp_qrcode($qrcode_id, $store_id)
	{
		$weixin_bind = D('Weixin_bind')->where(array('store_id' => $store_id))->find();

		if(empty($weixin_bind)){
			return(array('error_code'=>1,'msg'=>'请联系管理员绑定公众号'));
		}

		import('Http');
		$http = new Http();

		$appid = $weixin_bind['authorizer_appid'];

		$component_token = M('Weixin_bind')->get_access_token($store_id);
		$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$component_token['access_token'];

		$post_data['expire_seconds'] = 604800;
		$post_data['action_name'] = 'QR_SCENE';
		$post_data['action_info']['scene']['scene_id'] = $qrcode_id;
		$json = $http->curlPost($qrcode_url, json_encode($post_data));

		if (!$json['errcode']){
			return(array('error_code'=>0,'id'=>$qrcode_id,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
		}else{
			return(array('error_code'=>1,'msg'=>'产生二维码发生错误。发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
		}
	}

	// 生成临时二维码(商家)
	public function get_bind_tmp_qrcode($qrcode_id, $store_id){

		$token_data = M('Weixin_bind')->get_access_token($store_id);

		if ($token_data['errcode']) {
			return(array('error_code'=>1,'msg'=>'产生二维码发生错误。发生错误：错误代码 '.$token_data['errcode'].'，微信返回错误信息：'.$token_data['errmsg']));
		}

		$access_token = $token_data['access_token'];
		$qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
		
		$post_data['expire_seconds'] = 604800;
		$post_data['action_name'] = 'QR_SCENE';
		$post_data['action_info']['scene']['scene_id'] = $qrcode_id;

		import('Http');
		$http = new Http();
		$json = $http->curlPost($qrcode_url,json_encode($post_data));
		if (!$json['errcode']){
			return(array('error_code'=>0,'id'=>$qrcode_id,'ticket'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
		}else{
			return(array('error_code'=>1,'msg'=>'产生二维码发生错误。发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
		}
	}

	//产生一条新记录，不包含二维码的ticket
	public function add_new_qrcode_row($third_type,$third_id){
		$data_new_recognition['third_type'] = $third_type;
		$data_new_recognition['third_id'] = $third_id;
		$data_new_recognition['status'] = 0;
		$data_new_recognition['add_time'] = $_SERVER['REQUEST_TIME'];
		
		//首先查取有没有status = 0的，优先替换
		$condition_recognition['status'] = 0;
		$recognition = $this->field('`id`')->where($condition_recognition)->find();
		
		if(empty($recognition)){
			$qrcode_id = $this->data($data_new_recognition)->add();
			if($qrcode_id){
				return(array('error_code'=>false,'qrcode_id'=>$qrcode_id));
			}else{
				return(array('error_code'=>true,'msg'=>'获取失败！请重试。'));
			}
		}else{
			$condition_new_recognition['id'] = $recognition['id'];
			if($this->where($condition_new_recognition)->data($data_new_recognition)->save()){
				return(array('error_code'=>false,'qrcode_id'=>$recognition['id']));
			}else{
				return(array('error_code'=>true,'msg'=>'获取失败！请重试。'));
			}
		}
	}
	//保存二维码的ticket
	public function save_qrcode($qrcode_id,$ticket,$third_type,$third_id){
		$condition_recognition['id'] = $qrcode_id;
		$data_recognition['status'] = 1;
		$data_recognition['add_time'] = $_SERVER['REQUEST_TIME'];
		$data_recognition['ticket'] = $ticket;
		if($this->where($condition_recognition)->data($data_recognition)->save()){
			$save_return = $this->save_app_qrcode($qrcode_id,$third_type,$third_id);
			if($save_return['error_code']){
				return $save_return;
			}
			return(array('error_code'=>false,'qrcode_id'=>$qrcode_id,'qrcode'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket)));
		}else{
			return(array('error_code'=>true,'msg'=>'二维码保存失败！请重试。'));
		}
	}
	//保存qrcode_id到应用
	public function save_app_qrcode($qrcode_id,$third_type,$third_id){
		if($third_type == 'group'){
			$save_return = D('Group')->save_qrcode($third_id,$qrcode_id);
		}else if($third_type == 'merchant'){
			$save_return = D('Merchant')->save_qrcode($third_id,$qrcode_id);
		}else if($third_type == 'meal'){
			$save_return = D('Merchant_store')->save_qrcode($third_id,$qrcode_id);
		}else if($third_type == 'lottery'){
			$save_return = D('Lottery')->save_qrcode($third_id,$qrcode_id);
		}
		return $save_return;
	}
	//删除qrcode_id到应用
	public function del_app_qrcode($qrcode_id,$third_type,$third_id){
		if($third_type == 'group'){
			D('Group')->del_qrcode($third_id);
			$msg = '抱歉，没有找到该团购的二维码！页面将会跳转至获取。';
		}else if($third_type == 'merchant'){
			D('Merchant')->del_qrcode($third_id);
			$msg = '抱歉，没有找到商家信息的二维码！页面将会跳转至获取。';
		}
		exit('<html><head><script type="text/javascript">alert("'.$msg.'");window.location.href=window.location.href;</script></head></html>');
	}
	//返回现存的二维码
	public function get_qrcode($qrcode_id,$third_type,$third_id){
		$condition_recognition['id'] = $qrcode_id;
		$recognition = $this->field('`id`,`ticket`')->where($condition_recognition)->find();
		if(empty($recognition)){
			$this->del_app_qrcode($qrcode_id,$third_type,$third_id);
		}else{
			return(array('error_code'=>false,'qrcode_id'=>$recognition['id'],'qrcode'=>'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($recognition['ticket'])));
		}
	}
	
	


	
	/*
	 * @description: 下载二维码至本地
	 * @param： $qrcode_id 场景id
	 * @param：$dir  保存路径
	 * */
	public function download_img_from_weixin($qrcode_id, $dir = "./upload/store") {
		$dirs = $dir;
		$dir 	= PIGCMS_PATH.$dir;
		
		$return_info = $this->get_tmp_qrcode($qrcode_id);

		if($return_info['error_code'] == '0') {
			$imageinfo = $this->downloadsimg($return_info['ticket']);
			$rand_num = date('Y/m');
			$upload_dir = $dir.'/'.$rand_num.'/';
			
			if(!is_dir($upload_dir)){
				mkdir($upload_dir, 0777, true);
			}		
			
			$unid 	= uniqid();
			$filenames = $upload_dir.'/'.$unid.'_'.$qrcode_id.'.'.'jpg';
			//存库
			$filename = $dirs.'/'.$rand_num.'/'.$unid.'_'.$qrcode_id.'.'.'jpg';
			
			$local_file = fopen($filenames,'w+');
			if(false !== $local_file) {
				if(false !== fwrite($local_file,$imageinfo['body'])) {
				
					fclose($local_file);
	
					return $filename;
				}
			}else{
				//echo "!!+++";exit;
			}
		}
	}
	
	private function downloadsimg($url) {
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		return array_merge(array('body'=>$package),array('header'=>$httpinfo));
	}	
}
?>