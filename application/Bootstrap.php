<?php

class Bootstrap extends Yaf_Bootstrap_Abstract {
	protected $config;
	protected $server_config;

	public function _initConfig(Yaf_Dispatcher $dispatcher) {
		$this->config = Yaf_Application::app()->getConfig();
		$this->server_config = new Yaf_Config_Ini(APPLICATION_PATH."/conf/server.ini");

		Yaf_Registry::set('config', $this->config);
		Yaf_Registry::set('server_config', $this->server_config);

		// 判断请求方式，命令行请求应跳过一些HTTP请求使用的初始化操作，如模板引擎初始化
		!defined('REQUEST_METHOD') && define('REQUEST_METHOD', strtoupper($this->config->application->mode));
	}

	public function _initError(Yaf_Dispatcher $dispatcher) {
		if ($this->config->application->debug)
		{
			!defined('DEBUG_MODE') && define('DEBUG_MODE', TRUE);
			ini_set('display_errors', 'On');
		}else{
			!defined('DEBUG_MODE') && define('DEBUG_MODE', FALSE);
			ini_set('display_errors', 'Off');
		}
	}

	public function _initPlugin(Yaf_Dispatcher $dispatcher) {
		if (isset($this->config->application->benchmark) && $this->config->application->benchmark == true)
		{
			$benchmark = new BenchmarkPlugin();
			$dispatcher->registerPlugin($benchmark);
		}

		if(REQUEST_METHOD == 'SWOOLE')
		{
			$swoole = new SwoolePlugin();
			$dispatcher ->registerPlugin($swoole);
		}

	}

	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		// $routes = $this->config->routes;
		// if (!empty($routes) && REQUEST_METHOD != 'CLI' && REQUEST_METHOD != 'SWOOLE')
		// {
		// 	$router = $dispatcher->getRouter();
		// 	$router->addConfig($routes);
		// }
	}

	public function _initDatabase() {
		// $configs = $this->server_config->mysqli->toArray();
		// $configs = reset($configs);
		//
		// Server::set_maker('MysqliDb');
		//
		// if(!$configs) return;
		//
		// foreach($configs as $server_name => $config)
		// {
		// 	$server = new MysqliDb($config);
		// 	Server::set($server_name,$server,$config,Server::mysqli);
		// 	unset($server);
		// }

	}

	public function _initMemcache() {
			// $configs = $this->server_config->memcache->toArray();
	}

	public function _initRedis() {

	}

	public function _initMailer(Yaf_Dispatcher $dispatcher) {

	}

	public function _initView(Yaf_Dispatcher $dispatcher) {
		//命令行下基本不需要使用smarty
		if (REQUEST_METHOD != 'CLI')
		{
			$smarty = new SmartyPlugin();
			$dispatcher ->registerPlugin($smarty);
		}
	}


}
