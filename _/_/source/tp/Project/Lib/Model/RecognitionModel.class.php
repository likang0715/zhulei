<?php
/**
 * 二维码操作model
 * @author： pigcms-s
 * @date: 2015/08/20 14:43
*/
class RecognitionModel extends Model{
	
	
	//生成临时二维码
	public function get_tmp_qrcode($qrcode_id) {
		$appid     = C('config.wechat_appid');
		$appsecret = C('config.wechat_appsecret');
	
		if(empty($appid) || empty($appsecret)){
			return(array('error_code'=>1,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
		}
	
		//import('Http');
		import('Http', './source/class/');
		$http = new Http();
	
		//微信授权获得access_token
		//import('WechatApi');
		import('WechatApi', './source/class/');
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

    //生成平台永久二维码
    public function get_platform_limit_scene_qrcode($qrcode_id) {
        $appid     = C('config.wechat_appid');
        $appsecret = C('config.wechat_appsecret');

        if(empty($appid) || empty($appsecret)){
            return(array('error_code'=>1,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
        }

        import('Http', './source/class/');
        $http = new Http();

        //微信授权获得access_token
        import('WechatApi', './source/class/');

        $tokenObj 	= new WechatApi(array('appid'=>$appid,'appsecret'=>$appsecret));

        $access_token 	= $tokenObj->get_access_token();

        $qrcode_url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token['access_token'];

        $post_data['action_name'] = 'QR_LIMIT_STR_SCENE';
        $post_data['action_info']['scene']['scene_str'] = $qrcode_id;

        $json = $http->curlPost($qrcode_url,json_encode($post_data));
        if (!$json['errcode']){
            return(array('error_code'=>0,'id'=>$qrcode_id,'ticket'=>'http://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($json['ticket'])));
        }else{
            return(array('error_code'=>1001,'msg'=>'产生二维码发生错误。发生错误：错误代码 '.$json['errcode'].'，微信返回错误信息：'.$json['errmsg']));
        }
    }


    public function get_platform_agent_binging($qrcode_id) {
        $appid     = C('config.wechat_appid');
        $appsecret = C('config.wechat_appsecret');

        if(empty($appid) || empty($appsecret)){
            return(array('error_code'=>1,'msg'=>'请联系管理员配置【AppId】【 AppSecret】'));
        }

        import('Http', './source/class/');
        $http = new Http();

        //微信授权获得access_token
        import('WechatApi', './source/class/');

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
	
	

	/*
	 * @description: 下载二维码至本地
	 * @param： $qrcode_id 场景id
	 * @param：$dir  保存路径
	 * */
	public function download_img_from_weixin($qrcode_id, $dir = "./upload/activity") {
		
		$return_info = $this->get_tmp_qrcode($qrcode_id);

		if($return_info['error_code'] == '0') {
			$imageinfo = $this->downloadsimg($return_info['ticket']);
			$rand_num = date('Y/m');
			$upload_dir = $dir.'/'.$rand_num.'/';

			if(!is_dir($upload_dir)){
				$this->mkdirs($upload_dir,0777);
			}		
			$filename = $upload_dir.uniqid().'_'.$qrcode_id.'.'.'jpg';
			
			$local_file = fopen($filename,'w+');
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
	
	//递归创建文件夹
	private function mkdirs($dir)  {  
		if(!is_dir($dir))  {  
			if(!self::mkdirs(dirname($dir))){  
				return false;  
			}  
			if(!mkdir($dir,0777)){  
				return false;  
			}  
		}  
		return true;  
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