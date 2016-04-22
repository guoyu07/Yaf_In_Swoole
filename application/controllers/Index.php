<?php

/**
 * @name IndexController
 * @author chenzhidong
 * @desc   默认控制器
 * @see    http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class IndexController extends Yaf_Controller_Abstract {

	/**
	 * 默认动作
	 * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
	 * 对于如下的例子, 当访问http://yourhost/sample/index/index/index/name/chenzhidong 的时候, 你就会发现不同
	 */
	public function indexAction() {


		// fetch query
		// !SessionRewrite::sessionCheck() && session_start();
		// $_SESSION['U'] = 'kasiss';

		// fetch model
			$data = DemoModel::getUsers();

			$single = reset($data);
		//3. set views
		$view = $this->getView();
		$view->assign('content', $single['email']);
		$view->assign('name', 'kasiss');
		$view->display("index/index.html");


	}

	public function testAction()
	{
		var_dump($_GET);
		echo "this is the test123";
	}

}
