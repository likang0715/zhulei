<?php
    error_reporting(0);
    header('Content-Type:text/html;charset=UTF-8');
    define('PIGCMS_PATH',   $_SERVER['DOCUMENT_ROOT'] . '/');
    define('REQUEST_METHOD',$_SERVER['REQUEST_METHOD']);
    define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
    define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
    define('IS_PUT',        REQUEST_METHOD =='PUT' ? true : false);
    define('IS_DELETE',     REQUEST_METHOD =='DELETE' ? true : false);
    define('IS_AJAX',       (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false);

	//自动载所需的类
	if(!function_exists('classAutoLoader')){
        function classAutoLoader($class){
            if (strtolower($class) == 'pager') {
                $classFile = dirname(__FILE__) . '/class/Pager.class.php';
            } else {
                $classFile = PIGCMS_PATH .'/source/class/' . $class . '.class.php';
            }
            if(is_file($classFile) && !class_exists($class)) {
                require_once $classFile;
            }
        } 
    }
    spl_autoload_register('classAutoLoader');

	//配置加载
	define('CONF_PATH', dirname(__FILE__) . '/config/');
	if (file_exists(CONF_PATH . 'config.php')) {
        $config = require_once CONF_PATH . 'config.php';
	} else {
        $config = require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
    }

    $GLOBALS['_G']['system'] = $config;

    //数据库
    $db = new mysql();

    /**
     * 显示系统信息
     *
     * @param string $msg 信息
     * @param string $url 返回地址 传none则无链接按钮
     * @param boolean $isAutoGo 是否自动返回 true false
     * @param boolean $showCopy 是否显示PIGCMS版权信息 true false
     */
    function pigcms_tips($msg,$url='',$isAutoGo=false,$showCopy=true){
        if(IS_AJAX){
            echo json_encode(array('msg'=>$msg,'url'=>$url));
        }else{
            if(empty($url)) $url = 'javascript:history.back(-1);';
            if ($msg == '404'){
                header("HTTP/1.1 404 Not Found");
                $msg = '抱歉，你所请求的页面不存在！';
            }
            include(PIGCMS_PATH.'source/sys_tpl/tip.php');
        }
        exit;
    }

    /**
     * 获取配置文件
     *
     * @param $key
     * @return string
     */
    function config($key)
    {
        global $_G;
        return !empty($_G['system'][$key]) ? $_G['system'][$key] : '';
    }

    /**
     * 格式化输出
     *
     * @param $content
     */
    function dump($content)
    {
        echo "<pre>";
        print_r($content);
        echo "</pre>";
    }

