<?php
/**
 * 资源（图片）控制器
 */
class appuploadpic_controller extends base_controller{

	// 上传
	public function upload() {
	$results = array('result'=>'0','data'=>array(),'msg'=>'');
	    $uid = $_REQUEST['uid'];
	
		$type = $_REQUEST['type'];
$imgs = array();  //定义一个数组存放上传图片的路径
$isSave = false;


			$img_path_str = '';
		
			// 用会员uid
			$img_path_str = sprintf("%09d", $uid);
		
			// 产生目录结构
			$rand_num = 'images/' . substr($img_path_str, 0, 3) . '/' . substr($img_path_str, 3, 3) . '/' . substr($img_path_str, 6, 3) . '/' . date('Ym', $_SERVER['REQUEST_TIME']) . '/';
		
			$upload_dir = PIGCMS_PATH . '/upload/' . $rand_num;
			if(!is_dir($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

		
			foreach ($_FILES["file"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["file"]["tmp_name"][$key];
		if($this->checkIsImage($_FILES["file"]["tmp_name"][$key])==false){
		$results['result']='1';
	    $results['msg']='图片格式错误';
	     exit(json_encode($results));
		}
        $name = time().substr(urlencode($_FILES["file"]["name"][$key]),-8);
        $filename = $upload_dir . $name;
        $isSave = move_uploaded_file($tmp_name, $filename);
        if ($isSave){
		       $data['uid'] = $uid;
				$data['name'] = $name;
				$data['from'] = 0;
				$data['type'] = $_FILES["file"]["type"][$key];
				$data['file'] = $rand_num . $name;
				$data['size'] = $_FILES["file"]["size"][$key];
				$data['add_time'] = $_SERVER['REQUEST_TIME'];
				$data['ip'] = get_client_ip(1);
				$data['agent'] = $_SERVER['HTTP_USER_AGENT'];
				
				
				
				$pigcms_id = M('Attachment_user')->add($data);
		     if($type==1){
			 $imgs[]=getAttachmentUrl($rand_num . $name);
			 }else{
            $imgs[$key]['image']=getAttachmentUrl($rand_num . $name);
			}
        }
    }
}
	

	
	if ($isSave) {
  
	$results['data']=$imgs;
    exit(json_encode($results));
} else {

	$results['result']='1';
	 $results['msg']='图片上传失败';
	 exit(json_encode($results));
} 
}

private function checkIsImage($filename){  
  
    $alltypes = '|.gif|.jpeg|.png|.bmp|.jpg';//定义检查的图片类型 
     if(file_exists($filename)){   

	  $result= getimagesize($filename);  
  
	  $ext = image_type_to_extension($result['2']);    
		
	return stripos($alltypes,$ext);   
		   }else{       
	   return false;   
	 }
}
}