<?php
/**
 * 资源（图片）控制器
 */
class weixinimg_controller extends base_controller{
    
	public $config;
	public $_G;
	
	public function __construct(){
		global $_G;
		$this->_G = $_G;
		$this->arrays['config'] = $this->config = $_G['config'];
	}


	// 上传
	public function upload() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
		
		$byte=$_REQUEST['image'];
		if (empty($byte)) {
		     $results['result']='1';
			$results['msg']='图片数据流不能为空';
			exit(json_encode($results));
		}
		
			$byte=base64_decode($byte);
	
		

			$img_path_str = '';
		
			// 用会员uid
			$img_path_str = sprintf("%09d", $uid);
		
			// 产生目录结构
			$rand_num = 'images/' . substr($img_path_str, 0, 3) . '/' . substr($img_path_str, 3, 3) . '/' . substr($img_path_str, 6, 3) . '/' . date('Ym', $_SERVER['REQUEST_TIME']) . '/';
		
			$upload_dir = PIGCMS_PATH . '/upload/' . $rand_num;
			if(!is_dir($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}
			$rand=rand(1,99999);
			 $name = $rand.time().'.jpg';
             $filename=$upload_dir.$name;
			
			 if(file_put_contents($filename,$byte)){
           
          
		       $data['uid'] = $uid;
				$data['name'] = $name;
				$data['from'] = 0;
				$data['type'] = 0;
				$data['file'] = $rand_num . $name;
				$data['size'] = '';
				$data['add_time'] = $_SERVER['REQUEST_TIME'];
				$data['ip'] = get_client_ip(1);
				$data['agent'] = $_SERVER['HTTP_USER_AGENT'];
				
				
				
				$pigcms_id = M('Attachment_user')->add($data);
				
		    	$results['data']['image']=getAttachmentUrl($rand_num . $name);
			     exit(json_encode($results));
                   }else{
                $results['result']='1';
			    $results['msg']='图片上传失败';
			     exit(json_encode($results));
                  }

}
}