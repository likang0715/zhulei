<?php
/* *
 * 配置文件
 * 版本：3.5
 * 日期：2016-06-25
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
 * 2、更换浏览器或电脑，重新登录查询。
 */
 
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['partner']		= '2088421411561470';

//收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
$alipay_config['seller_id']	= $alipay_config['partner'];

//商户的私钥,此处填写原始私钥去头去尾，RSA公私钥生成：https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.nBDxfy&treeId=58&articleId=103242&docType=1
$alipay_config['private_key']	= 'MIICXQIBAAKBgQC9BfdlJ0oaa64qhv1pZqsFZB3VBwBXVpTVKaMp5lzUSsfWskU8QS/W6y3hND1zqGd0OQm6OJDcW8QSJiXpXvyOm726r67oFs4oSV5+rgwhqauC0jEAovNgd2HmfE3UzeNxxwNwMX5Ue/IdRlA+uBKgntgAlziaiXQQ+uTy5XW0bQIDAQABAoGBAI62Gnq8ly4rbmudT2ZspWKEnCFiD9fg/q2RqibQTfXaH9bw8WT0snHJTfJhxqOz2afeCIIYgwZcIkSxmJ4BoRucDzgp/YkzA3O9vO1SSstTni331Nd1r91dgPjNEOzz8PQXqFkU4fH0htZ+b0VY5ZvuXEzfURFxyviuMCO82O8BAkEA9rcOQAlSNHTYbvtNI9M0kGg55gqFo4bFkPV2E/KYwfaNW6eGW7Ur5/7RcblVl/bozW4aR2h0pFyT1QHZqAxDdQJBAMQjFkPotE2meF5BB9KH6VciPz9Uom4F5kkmAFUZ08JC3C30Ofs6fdml1srVOaEGNh8FA64nEGYADI9Yg2wI5hkCQGcg//jurIk26p4BuC4ohEl09/bcIR7JIF7G7HPMLeSubkqIzZYaNl9E2kIiic/7KzdsNdnxpQhrlnQs0NH5Rl0CQAEatXhiagl543mcYh/kVgMAlVyU7Gk0LUzCIwRXpeKVH8o+cskgVi8QiPoRY0at00YvcArd+3CnlWqFNBA6qJkCQQDHsa1ta258L4q6CgCQItbLK8qEPp3ZVoPMmrCYJ98EZA9ECTeGxZKSZn4EmOqy2zLCLfqHJEMVSf9nkqIsWwYy';


//支付宝的公钥，查看地址：https://openhome.alipay.com/platform/keyManage.htm?keyType=partner
$alipay_config['alipay_public_key']='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC9BfdlJ0oaa64qhv1pZqsFZB3VBwBXVpTVKaMp5lzUSsfWskU8QS/W6y3hND1zqGd0OQm6OJDcW8QSJiXpXvyOm726r67oFs4oSV5+rgwhqauC0jEAovNgd2HmfE3UzeNxxwNwMX5Ue/IdRlA+uBKgntgAlziaiXQQ+uTy5XW0bQIDAQAB';

// 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['notify_url'] = "http://商户网关网址/alipay.wap.create.direct.pay.by.user-PHPUTF-8/notify_url.php";

// 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
$alipay_config['return_url'] = "http://商户网址/alipay.wap.create.direct.pay.by.user-PHP-UTF-8/return_url.php";

//签名方式
$alipay_config['sign_type']    = strtoupper('RSA');

//字符编码格式 目前支持utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = getcwd().'\\cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';

// 支付类型 ，无需修改
$alipay_config['payment_type'] = "1";
		
// 产品类型，无需修改
$alipay_config['service'] = "alipay.wap.create.direct.pay.by.user";

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


?>