<?php

require_once dirname(__FILE__).'/global.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
    case 'createImage':

        import('source.class.Jpgraph');

        $title = !empty($_POST['header_title']) ? mb_substr($_POST['header_title'],0,12,'utf-8') : '';

        $sub_titel = !empty($_POST['head_text1']) ? $_POST['head_text1'] : '向您推荐此店铺';
        $desc = !empty($_POST['title']) ? mb_substr($_POST['title'], 0, 11,'utf-8') : '';

        if(mb_strlen($desc,'utf-8') < 12) {
            $length = mb_strlen($desc,'utf-8');
            $blank = str_repeat('  ',12-$length);
            $desc = $blank.$desc;
        }

        $content = !empty($_POST['content']) ? $_POST['content'] : '';

        if(mb_strlen($content,'utf-8') > 21){
            $length = mb_strlen($content,'utf-8');
            $start = mb_substr($content, 0,23,'utf-8');
            $content = $start;
        }

        $scan_qrcod_notice = '[长按此图,识别图中二维码]';
        $footer_title = !empty($_POST['description']) ? mb_substr($_POST['description'], 0, 12,'utf-8') : '';
        $header_image = option('config.site_url').'/static/images/header.png';
        $logo_image = !empty($_POST['logo_image']) ? $_POST['logo_image'] : option('config.site_url').'/static/images/default_shop_2.jpg';
        $qrcode_image = !empty($_POST['qcode_image']) ? $_POST['qcode_image'] : '';
        $bg_image     =  !empty($_POST['bg_image']) ? $_POST['bg_image'] : option('config.site_url').'/static/images/bg.png';

        //初始化，并创建画布
        $img = new Jpgraph(640, 900);

        //裁剪头像
        $image = $img->resize($logo_image, PIGCMS_PATH . 'cache/', 150, 150);
        $http_path = option('config.site_url') . '/cache/' . $image['http_path'];
        $save_path = $image['save_path'];
        
        //设置画面背景填充色
        $img->setBackgroundColor(227, 33, 57);
        $fill_color = $img->setFillColor(235, 235, 235);
        $img->addRectangle(0, 0, 200, 900, $fill_color);

        //设置中间区域背景
        $fill_color = $img->setFillColor(227, 33, 57);
        $img->addRectangle(0, 800, 200, 640, $fill_color);
        $img->addWatermark($bg_image, 0, 0, 0, 0, 640, 800);

        //设置会员头像水印
        $img->addWatermark($http_path, 30, 30, 0, 0, 150, 150, true);

        //设置遮罩背景
        $img->addWatermark($header_image, 0, 0, 0, 0, 640, 200);

        //设置底部背景
        $fill_color = $img->setFillColor(187, 25, 46);
        $img->addRectangle(0, 800, 900, 640, $fill_color);

        //设置底部横线
        $fill_color = $img->setFillColor(255, 181, 148);
        $img->addLine(20, 850, 90, 850, $fill_color);
        $img->addLine(550, 850, 620, 850, $fill_color);

        //设置二维码后面的白色背景
        $fill_color = $img->setFillColor(255, 255, 255);
        $img->addRectangle(160, 380, 700, 480, $fill_color);

        //设置标题
        $fill_color = $img->setFillColor(191, 34, 61);
        $img->addText(25, 'simhei', 195, 67, $title, $fill_color);
        $img->addText(25, 'simhei', 195, 68, $title, $fill_color);

        //设置子标题
        $fill_color = $img->setFillColor(0, 0, 0);
        $img->addText(25, 'simhei', 195, 130, $sub_titel, $fill_color);

        //描述
        $fill_color = $img->setFillColor(249, 235, 76);
        $img->addText(35, 'lihei', 40, 260, $desc, $fill_color);

        //内容
        $fill_color = $img->setFillColor(255, 255, 255);
        $img->addText(20, 'simhei', 30, 330, $content, $fill_color);

        //二维码下方扫码提示
        $img->addText(20, 'simhei', 150, 760, $scan_qrcod_notice, $fill_color);

        //底部文字
        $fill_color = $img->setFillColor(249, 235, 76);
        $img->addText(26, 'simhei', 105, 865, $footer_title, $fill_color);
        $img->addText(26, 'simhei', 105, 866, $footer_title, $fill_color);

        //二维码水印
        $img->addWatermark($qrcode_image, 160, 380, 0, 0, 320, 320);
        $img_dir = PIGCMS_PATH . '/upload/images/promote_qrcode/';
        if(!is_dir($img_dir)) {
        	mkdir($img_dir, 0777, true);
        }
        $image = $img->generate($img_dir,md5($_SESSION['tmp_store_id']));

		$now_store = M('Store')->getStore($_SESSION['tmp_store_id']);
		
		$image_path 	= option('config.site_url') . '/upload/images/promote_qrcode/' . $image['err_msg']['name'];
		
		//获取当前分销店铺的供货商id
		if($now_store['drp_level'] > 0) {
			$supplier_chain = D('Store_supplier')->field('supply_chain')->where(array('seller_id'=>$now_store['store_id']))->find();
			$supplier_ids = explode(',', $supplier_chain['supply_chain']);
			$supplier_id = $supplier_ids['1'];
		} else {
			$supplier_id 	= $now_store['store_id'];
		}
		//调取供货商微信接口上传图片附件
		$token_data = M('Weixin_bind')->get_access_token($supplier_id);
		
		if($token_data['errcode'] == 0){
			import('source.class.Http');
			$local_path 	= PIGCMS_PATH . 'upload/images/promote_qrcode/' . $image['err_msg']['name'];
			$upload = Http::curlPost('http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$token_data['access_token'].'&type=image', array('media' => '@'. $local_path));
			if ($upload['errcode'] == 0) {
				$media_id 	= $upload['media_id'];
			}
		}
		
		//保存店铺对应的推广二维码
		D('Store_promote_setting')->data(array('promote_qrcode'=>$image_path,'media_id'=>$media_id))->where(array('store_id'=>$_SESSION['tmp_store_id']))->save();

        echo $image_path;
        exit;
}


 /*function createImage(){

    import('source.class.Jpgraph');

    $title = !empty($_POST['header_title']) ? $_POST['header_title'] : '';
    $sub_titel = '我向您推荐此店铺';
    $desc = !empty($_POST['title']) ? $_POST['title'] : '';
    $content = !empty($_POST['content']) ? $_POST['content'] : '';
    $scan_qrcod_notice = '[长按此图,识别图中二维码]';
    $footer_title = !empty($_POST['description']) ? $_POST['description'] : '';
    $header_image = PIGCMS_PATH.'static/images/header.png';
    $logo_image   = PIGCMS_PATH.'static/images/5627455ad8c2abc.png';
    $qrcode_image = PIGCMS_PATH.'static/images/qrcode.png';
    $bg_image     = PIGCMS_PATH.'static/images/bg.png';


var_dump($title);
    //初始化，并创建画布
    $img = new Jpgraph(640, 900);

    //裁剪头像
    $image = $img->resize($logo_image, PIGCMS_PATH . 'upload/images/', 150, 150);
    $http_path = $url . 'upload/images/' . $image['http_path'];
    $save_path = $image['save_path'];

    //设置画面背景填充色
    $img->setBackgroundColor(227, 33, 57);
    $fill_color = $img->setFillColor(235, 235, 235);
    $img->addRectangle(0, 0, 200, 900, $fill_color);

    //设置中间区域背景
    $fill_color = $img->setFillColor(227, 33, 57);
    $img->addRectangle(0, 800, 200, 640, $fill_color);
    $img->addWatermark($bg_image, 0, 0, 0, 0, 640, 800);

    //设置会员头像水印
    $img->addWatermark($save_path, 30, 30, 0, 0, 150, 150, true);

    //设置遮罩背景
    $img->addWatermark($header_image, 0, 0, 0, 0, 640, 200);

    //设置底部背景
    $fill_color = $img->setFillColor(187, 25, 46);
    $img->addRectangle(0, 800, 900, 640, $fill_color);

    //设置底部横线
    $fill_color = $img->setFillColor(255, 181, 148);
    $img->addLine(20, 850, 90, 850, $fill_color);
    $img->addLine(550, 850, 620, 850, $fill_color);

    //设置二维码后面的白色背景
    $fill_color = $img->setFillColor(255, 255, 255);
    $img->addRectangle(160, 380, 700, 480, $fill_color);

    //设置标题
    $fill_color = $img->setFillColor(191, 34, 61);
    $img->addText(25, 'simhei', 195, 67, $title, $fill_color);
    $img->addText(25, 'simhei', 195, 68, $title, $fill_color);

    //设置子标题
    $fill_color = $img->setFillColor(0, 0, 0);
    $img->addText(25, 'simhei', 195, 130, $sub_titel, $fill_color);

    //描述
    $fill_color = $img->setFillColor(249, 235, 76);
    $img->addText(35, 'lihei', 40, 260, $desc, $fill_color);

    //内容
    $fill_color = $img->setFillColor(255, 255, 255);
    $img->addText(20, 'simhei', 30, 330, $content, $fill_color);

    //二维码下方扫码提示
    $img->addText(20, 'simhei', 150, 760, $scan_qrcod_notice, $fill_color);

    //底部文字
    $fill_color = $img->setFillColor(249, 235, 76);
    $img->addText(26, 'simhei', 105, 865, $footer_title, $fill_color);
    $img->addText(26, 'simhei', 105, 866, $footer_title, $fill_color);

    //二维码水印
    $img->addWatermark($qrcode_image, 160, 380, 0, 0, 320, 320);

    $image = $img->generate(PIGCMS_PATH . 'upload/images/');

    json_return( 0, $image);
}*/

?>

