<?php

/**
 * 测试
* User: pigcms_21
* Date: 2015/3/3
* Time: 14:41
*/
class test_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		/*$user = M('User')->getUserById($this->user_session['uid']);
		$user['last_ip']=  long2ip($user['last_ip']);
		$this->assign('user', $user);*/
	}
	
	public function index()
	{
		$where['uid'] = 1;
		$user_list = D('User')->where($where)->select();
		$this->assign('user_list',$user_list);
		$this->display();
	}
	
	public function testcors(){
		header("Access-Control-Allow-Origin:*");
		$nickname = $_GET['nickname']?$_GET['nickname']:'testname';
		echo json_encode($nickname);
		//$result = D('User')->data($data)->add();
		//echo 'result='.$result;
	}
	
	function test_json()
	{
		//return '111';
		json_return(array(2,4,'sdfsa'));
	}
	
	function testdourl()
	{
		$params = array('id'=>3,'name'=>'asdi');
		echo dourl('account:login',$params);
	}
	
	function test_websocet(){
		echo 'abc';
	}

    function wxsms(){
        import('source.class.Factory');
        import('source.class.MessageFactory');
        import('source.class.sendtemplate');
        $wx_tpl_no = "OPENTM207126233";
        $params = array();
        $template_data = array(
            'wecha_id' => 'oRiG1wJVTKUStHOksb7MJCJRvc9M',
            'first'    => '您好，恭喜您成为 【阿尔法】 的供货商。',
            'keyword1' => '阿尔法',
            'keyword2' => '18668578658',
            'keyword3' => date('Y-m-d H:i:s'),
            'remark'   => '状态：杨杰备注'
        );
        $params['template'] = array('template_id' => $wx_tpl_no, 'template_data' => $template_data);
        $params_array[] = 'TemplateMessage';
        $rs = MessageFactory::method($params,'TemplateMessage');
        var_dump($rs);
    }
}
