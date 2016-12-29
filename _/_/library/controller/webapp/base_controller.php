<?php
/**
 * 基础类
 */
class base_controller extends controller {
	public $user;
	public function __construct() {
		parent::__construct();
		
		$not_login_arr = array('tuan-channel', 'tuan-tuan_list', 'tuan-team_list', 'category-get_category');
		// 不是用户登录页面
		if (MODULE_NAME != 'user' && !in_array(MODULE_NAME . '-' . ACTION_NAME, $not_login_arr) && !isset($_GET['debug'])) {
			$user = $_SESSION['wap_user'];
			
			if (empty($user)) {
				json_return(20000, option('config.wap_site_url') . '/login.php');
			} else {
				$this->user = $user;
			}
		}
	}
}
?>