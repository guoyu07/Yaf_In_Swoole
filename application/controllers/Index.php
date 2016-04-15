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
		// throw new  Exception("Error Processing Request", 1);

		//1. fetch query

		//2. fetch model
// 		$model = new SampleModel();

		// $view = $this->getView();
		// $view->assign('content', 'asdfasdfasdf');
		// $view->assign('name', 'kasiss');
		// $view->display("index/index.html");

		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板

	}

	public function testAction()
	{
		var_dump($_GET);
		echo "this is the test123";
	}

}
