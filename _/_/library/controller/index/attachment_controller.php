<?php
class attachment_controller extends base_controller{
	public function __construct(){
		parent::__construct();
		if(empty($_REQUEST['newid'])) json_return(999,'会话超时，请刷新页面重试');
	}
	

	public function rz_upload(){

		$dom_id = $_POST['id'];
		$stid = $_POST['newid'];

		if(!empty($_FILES['file']) && $_FILES['file']['error'] != 4){
			$img_store_id = sprintf("%09d",$stid);
			$rand_num = 'images/'.substr($img_store_id,0,3).'/'.substr($img_store_id,3,3).'/'.substr($img_store_id,6,3).'/'.date('Ym',$_SERVER['REQUEST_TIME']).'/';
		
			$upload_dir = './upload/'.$rand_num; 
			if(!is_dir($upload_dir)){
				mkdir($upload_dir,0777,true);
			}
			import('UploadFile');
			$upload = new UploadFile();
			$upload->maxSize = $_POST['maxsize']*1024*1024;
			$upload->allowExts = array('jpg','jpeg','png','gif');
			$upload->allowTypes = array('image/png','image/jpg','image/jpeg','image/gif');
			$upload->savePath = $upload_dir;
			$upload->saveRule = 'uniqid';
			if($upload->upload()){
				$uploadList = $upload->getUploadFileInfo();
				$add_result = $this->rz_add($uploadList[0]['name'],$rand_num.$uploadList[0]['savename'],$uploadList[0]['size'],$stid);
				if($add_result['err_code']){
					unlink($upload_dir.$uploadList[0]['name']);
					die('{"jsonrpc":"2.0","result":{"error_code":'.$add_result['err_code'].',"err_msg":"'.$add_result['err_msg'].'"},"id":"'.$dom_id.'"}');
				}

				// 上传到又拍云服务器
				$attachment_upload_type = option('config.attachment_upload_type');
				if ($attachment_upload_type == '1') {
					import('source.class.upload.upyunUser');
					upyunUser::upload('./upload/' . $rand_num . $uploadList[0]['savename'], '/' . $rand_num . $uploadList[0]['savename']);
				}

				die('{"jsonrpc":"2.0","result":{"error_code":0,"url":"'. getAttachmentUrl($rand_num.$uploadList[0]['savename']) .'","pigcms_id":'.$add_result['pigcms_id'].'},"id":"'.$dom_id.'"}');
			}else{
				die('{"jsonrpc":"2.0","result":{"error_code":999,"err_msg":"'.$upload->getErrorMsg().'"},"id":"'.$dom_id.'"}');
			}
		}else{
			die('{"jsonrpc":"2.0","result":{"error_code":999,"err_msg":"没有选择图片"},"id":"'.$dom_id.'"}');
		}
	}
	
	public function rz_add($name,$file,$size,$from=0,$type=0,$uid){
		
		$data_attachment['uid'] = $uid;
		$data_attachment['name'] = $name;
		$data_attachment['from'] = $from;
		$data_attachment['type'] = $type;
		$data_attachment['file'] = $file;
		$data_attachment['size'] = $size;
		$data_attachment['add_time'] = $_SERVER['REQUEST_TIME'];
		$data_attachment['ip'] = get_client_ip(1);
		$data_attachment['agent'] = $_SERVER['HTTP_USER_AGENT'];


		if($type == 0){
			list($data_attachment['width'],$data_attachment['height']) =getimagesize('./upload/'.$file);
		}
		if($pigcms_id = D('Attachment_rz')->data($data_attachment)->add()){
			return array('err_code'=>0,'pigcms_id'=>$pigcms_id);
		}else{
			return array('err_code'=>1001,'err_msg'=>'图片添加失败！请重试');
		}
	}
	
}
?>