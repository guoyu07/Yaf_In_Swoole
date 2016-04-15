<?php
/**
 * 命令行请求入口
 *
 * Created by IntelliJ IDEA.
 * User: chenzhidong
 * Date: 13-12-5
 * Time: 上午11:43
 */
define('APPLICATION_PATH', dirname(__FILE__));

if (!extension_loaded("yaf"))
{
	include(APPLICATION_PATH . '/framework/loader.php');
}


$yaf_request = new Yaf_Request_Http('index/test');
$yaf_request->setParam(array('lala'=>111));
	// var_dump($yaf_request);
	// var_dump(new Yaf_Request_Simple());
	// die();
$application = new Yaf_Application(APPLICATION_PATH . "/conf/application.ini");
// $application->bootstrap()->getDispatcher()->dispatch(new Yaf_Request_Simple());
$application->bootstrap()->getDispatcher()->dispatch($yaf_request);

?>
