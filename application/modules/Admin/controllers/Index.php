<?php

/**
 * 命令行controller示例
 *
 */
class IndexController extends Yaf_Controller_Abstract {

	public function indexAction() {
		Swoole::setHeader("Content-Type","text/plain");

		$_SESSION['userinfo'] = array('id'=>'12','name'=>uniqid());
		echo "admin\n";
	}
}
